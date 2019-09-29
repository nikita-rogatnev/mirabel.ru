<?php

namespace themeEditor\themeEditor;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

use VisualComposer\Framework\Container;
use VisualComposer\Helpers\Access\CurrentUser;
use VisualComposer\Helpers\Access\UserCapabilities;
use VisualComposer\Helpers\Frontend;
use VisualComposer\Helpers\Nonce;
use VisualComposer\Helpers\Options;
use VisualComposer\Helpers\PostType;
use VisualComposer\Helpers\Request;
use VisualComposer\Helpers\Str;
use VisualComposer\Helpers\Traits\WpFiltersActions;
use VisualComposer\Helpers\Traits\EventsFilters;
use VisualComposer\Helpers\Url;
use WP_Query;

abstract class PostTypeController extends Container
{
    use WpFiltersActions;
    use EventsFilters;

    protected $postType;

    protected $postNameSlug;

    protected $postNameSingular;

    protected $postNamePlural;

    public function __construct()
    {
        $this->addFilter('vcv:frontend:head:extraOutput', 'outputEditorLayouts');
        $this->wpAddAction('admin_init', 'doRedirect');
        $this->addFilter('vcv:helpers:access:editorPostType', 'addPostType');
        $this->wpAddFilter('post_row_actions', 'updatePostEditBarLinks');
        $this->wpAddFilter('bulk_actions-edit-' . $this->postType, 'removePostActions', 10, 1);
        $this->wpAddFilter('get_edit_post_link', 'modifyPostEditLink', 10, 2);
        $this->addFilter('vcv:frontend:url', 'addTypeToLink');
        $this->addFilter('vcv:ajax:addon:themeEditor:setAsDefault:adminNonce', 'setDefault');
        $this->addEvent('vcv:inited', 'registerPostType');
        // We use wp action for 3rd developers API
        $this->wpAddAction('vcv:themeEditor:' . strtolower($this->postNameSlug), 'render');
        $this->wpAddFilter('vcv:themeEditor:' . strtolower($this->postNameSlug) . ':enabled', 'checkHfs');
        $this->wpAddFilter('display_post_states', 'addPostState');
        $this->addFilter('vcv:frontend:head:extraOutput', 'addGlobalVariables');

        $this->wpAddAction('admin_init', 'coreCapabilities');

        $this->addFilter('vcv:addons:exportImport:allowedPostTypes', 'enableExportTypes');
    }

    /**
     * Redirect to frontend editor
     *
     * @param \VisualComposer\Helpers\Request $requestHelper
     */
    protected function doRedirect(Request $requestHelper)
    {
        global $pagenow;
        if (($pagenow === 'post-new.php' || $pagenow === 'post.php')
            && ($requestHelper->input('post_type') === $this->postType
                || get_post_type($requestHelper->input('post')) === $this->postType
            )
            && !$requestHelper->exists('vcv-action')
        ) {
            $attr = '?';
            //redirect from clasic editor to frontend editor
            if ($pagenow === 'post.php' && $requestHelper->input('post')) {
                $sourceId = $requestHelper->input('post');
                $attr .= 'post=' . $sourceId . '&action=edit&vcv-source-id=' . $sourceId . '&';
            }

            wp_redirect(
                admin_url(
                    $pagenow . $attr . 'post_type=' . rawurlencode($this->postType)
                    . '&vcv-action=frontend&vcv-editor-type='
                    . rawurlencode($this->postType)
                )
            );
        }
    }

    /**
     * Add post type support for frontend editor
     *
     * @return array
     */
    protected function addPostType($postTypes)
    {
        if (!in_array($this->postType, $postTypes)) {
            $postTypes[] = $this->postType;
        }

        return $postTypes;
    }

    /**
     * Update update post edit bar links
     *
     * @param $actions
     * @param $post
     * @param \VisualComposer\Helpers\Access\UserCapabilities $userCapabilitiesHelper
     * @param \VisualComposer\Helpers\Url $urlHelper
     * @param \VisualComposer\Helpers\Nonce $nonceHelper
     * @param \VisualComposer\Helpers\Options $optionsHelper
     *
     * @return mixed
     */
    protected function updatePostEditBarLinks(
        $actions,
        $post,
        UserCapabilities $userCapabilitiesHelper,
        Url $urlHelper,
        Nonce $nonceHelper,
        Options $optionsHelper
    ) {
        // @codingStandardsIgnoreLine
        if ($post->post_type === $this->postType) {
            unset($actions['inline hide-if-no-js']);
            unset($actions['edit']);
            unset($actions['view']);
            unset($actions['preview']);
            $sourceId = get_the_ID();
            $actions = array_reverse($actions);
            // @codingStandardsIgnoreLine
            if ('publish' === $post->post_status) {
                if ($userCapabilitiesHelper->canEdit($sourceId)) {
                    $url = $urlHelper->adminAjax(
                        [
                            'vcv-action' => 'addon:themeEditor:setAsDefault:adminNonce',
                            'vcv-source-id' => $sourceId,
                            'vcv-nonce' => $nonceHelper->admin(),
                            'vcv-post-type' => $this->postType,
                        ]
                    );
                }

                if ((int)$optionsHelper->get('default' . $this->postType) === $sourceId) {
                    $actions['vcv_default_layout'] = __('Set as Default', 'vcwb');
                } else {
                    $actions['vcv_set_as_default'] = sprintf(
                        '<a href="%s">%s</a>',
                        $url,
                        __('Set as Default', 'vcwb')
                    );
                }
            }
        }

        return $actions;
    }

    /**
     * Remove edit action from dropdown
     *
     * @param $actions
     *
     * @return mixed
     */
    protected function removePostActions($actions)
    {
        global $post;

        // @codingStandardsIgnoreLine
        if (isset($post->post_type) && $post->post_type === $this->postType) {
            unset($actions['edit']);
        }

        return $actions;
    }

    /**
     * Modify default edit link on post title
     *
     * @param $link
     * @param $sourceId
     *
     * @return string
     */
    protected function modifyPostEditLink($link, $sourceId)
    {
        global $post;

        // @codingStandardsIgnoreLine
        if (isset($post->post_type) && $post->post_type === $this->postType) {
            $question = (preg_match('/\?/', $link) ? '&' : '?');
            $query = [
                'vcv-action' => 'frontend',
                'vcv-source-id' => $sourceId,
                'vcv-editor-type' => $this->postType,
            ];
            $link = $link . $question . http_build_query($query, '', '&');
            $link = str_replace('?&', '?', $link);
        }

        return $link;
    }

    /**
     * @param $url
     * @param $payload
     *
     * @return string
     */
    protected function addTypeToLink($url, $payload)
    {
        if ($this->postType === get_post_type($payload['sourceId'])) {
            return add_query_arg(['vcv-editor-type' => $this->postType], $url);
        }

        return $url;
    }

    /**
     * Set post as default
     *
     * @param \VisualComposer\Helpers\Request $requestHelper
     * @param \VisualComposer\Helpers\Access\CurrentUser $currentUserAccessHelper
     * @param \VisualComposer\Helpers\Options $optionsHelper
     */
    protected function setDefault(
        Request $requestHelper,
        CurrentUser $currentUserAccessHelper,
        Options $optionsHelper
    ) {
        if ($requestHelper->exists('vcv-source-id') && $requestHelper->exists('vcv-post-type')
            && $currentUserAccessHelper->wpAll('edit_posts')->get()
            && $requestHelper->input('vcv-post-type') === $this->postType) {
            $sourceID = $requestHelper->input('vcv-source-id');
            if (get_post($sourceID)) {
                $optionsHelper->set('default' . $this->postType, $sourceID);
            }

            wp_redirect(admin_url('edit.php?post_type=' . $this->postType));
        }
    }

    /**
     * Register post type
     */
    protected function registerPostType()
    {
        $settings = vcapp('SettingsPagesSettings');
        register_post_type(
            $this->postType,
            [
                'labels' => [
                    'name' => $this->postNamePlural,
                    'singular_name' => $this->postNameSingular,
                    'menu_name' => $this->postNamePlural,
                    'add_new' => sprintf(__('Add %s', 'vcwb'), $this->postNameSingular),
                    'add_new_item' => sprintf(__('Add New %s', 'vcwb'), $this->postNameSingular),
                    'edit' => __('Edit', 'vcwb'),
                    'edit_item' => sprintf(__('Edit %s', 'vcwb'), $this->postNameSingular),
                    'new_item' => sprintf(__('New %s', 'vcwb'), $this->postNameSingular),
                    'view' => sprintf(__('View %s', 'vcwb'), $this->postNamePlural),
                    'view_item' => sprintf(__('View %s', 'vcwb'), $this->postNameSingular),
                    'search_items' => sprintf(__('Search %s', 'vcwb'), $this->postNameSingular),
                    'not_found' => sprintf(__('No %s Found', 'vcwb'), $this->postNamePlural),
                    'not_found_in_trash' => sprintf(__('No %s Found in Trash', 'vcwb'), $this->postNamePlural),
                    'parent' => sprintf(__('Parent %s', 'vcwb'), $this->postNameSingular),
                    'filter_items_list' => sprintf(__('Filter %s', 'vcwb'), $this->postNamePlural),
                    'items_list_navigation' => sprintf(__('%s Navigation', 'vcwb'), $this->postNamePlural),
                    'items_list' => sprintf(__('%s List', 'vcwb'), $this->postNamePlural),
                ],
                'public' => false,
                'capability_type' => $this->postType,
                'capabilities' => [
                    'edit_post' => 'edit_' . $this->postType,
                    'read_post' => 'read_' . $this->postType,
                    'delete_post' => 'delete_' . $this->postType,
                    'edit_posts' => 'edit_' . $this->postType . 's',
                    'edit_others_posts' => 'edit_others_' . $this->postType . 's',
                    'publish_posts' => 'publish_' . $this->postType . 's',
                    'read_private_posts' => 'read_private_' . $this->postType . 's',
                    'create_posts' => 'edit_' . $this->postType . 's',
                    'edit_published_posts' => 'edit_published_' . $this->postType . 's',
                    'delete_posts' => 'delete_' . $this->postType . 's',
                    'delete_private_posts' => 'delete_private_' . $this->postType . 's',
                    'delete_published_posts' => 'delete_published_' . $this->postType . 's',
                    'delete_others_posts' => 'delete_others_' . $this->postType . 's',
                    'read' => 'read_' . $this->postType,
                ],
                'publicly_queryable' => false,
                'exclude_from_search' => true,
                'show_ui' => true,
                'show_in_menu' => $settings->getSlug(),
                'menu_icon' => 'dashicons-admin-page',
                'hierarchical' => false,
                'taxonomies' => [],
                'has_archive' => false,
                'rewrite' => false,
                'query_var' => false,
                'show_in_nav_menus' => false,
            ]
        );
    }

    protected function coreCapabilities()
    {
        $role = get_role('administrator');

        $capabilities = [
            "edit_{$this->postType}",
            "read_{$this->postType}",
            "delete_{$this->postType}",
            "edit_{$this->postType}s",
            "edit_others_{$this->postType}s",
            "publish_{$this->postType}s",
            "read_private_{$this->postType}s",
            "create_{$this->postType}s",
            "delete_{$this->postType}s",
            "delete_private_{$this->postType}s",
            "delete_published_{$this->postType}s",
            "delete_others_{$this->postType}s",
            "edit_private_{$this->postType}s",
            "edit_published_{$this->postType}s",
        ];

        foreach ($capabilities as $cap) {
            $role->add_cap($cap);
        }
    }

    protected function outputEditorLayouts(
        $response,
        $payload,
        PostType $postTypeHelper,
        Str $strHelper,
        Options $optionsHelper
    ) {
        $currentPost = $postTypeHelper->get();
        $posts = $postTypeHelper->query(['post_type' => $this->postType, 'posts_per_page' => -1]);

        $layouts = [];
        foreach ($posts as $post) {
            /** @var \WP_Post $post */
            // @codingStandardsIgnoreLine
            $layouts[ $post->ID ] = $post->post_title;
        }

        $currentLayout = get_post_meta($currentPost->ID, '_' . VCV_PREFIX . $this->postNameSlug . 'TemplateId', true);
        if (empty($currentLayout)) {
            $currentLayout = $optionsHelper->get('default' . $this->postType, 'default');
        }

        return array_merge(
            $response,
            [
                vcview(
                    'partials/constant-script',
                    [
                        'key' => 'VCV_' . $strHelper->upper($this->postNameSlug) . '_TEMPLATES',
                        'value' => [
                            'current' => $currentLayout,
                            'all' => count($layouts) > 0 ? $layouts : false,
                        ],
                    ]
                ),
            ]
        );
    }

    protected function render(Options $optionsHelper, Frontend $frontendHelper)
    {
        $sourceId = get_the_ID();
        if ($frontendHelper->isPreview()) {
            $preview = wp_get_post_autosave($sourceId);
            if (is_object($preview)) {
                $sourceId = $preview->ID;
            }
        }
        $currentTemplateId = get_post_meta($sourceId, '_' . VCV_PREFIX . $this->postNameSlug . 'TemplateId', true);
        $defaultTemplate = $optionsHelper->get('default' . $this->postType);
        $currentTemplatePost = (intval($currentTemplateId) && $currentTemplateId > 0) ? get_post($currentTemplateId)
            : false;
        $defaultTemplatePost = (intval($defaultTemplate) && $defaultTemplate > 0) ? get_post($defaultTemplate) : false;
        /** @see \themeEditor\themeEditor\PostTypeController::getQueryArgs */
        $args = $this->call(
            'getQueryArgs',
            [
                $defaultTemplatePost,
                $currentTemplatePost,
                $defaultTemplate,
                $currentTemplateId,
            ]
        );

        $blockId = 0;
        if (isset($args['p']) && $args['p'] > 0) {
            global $post;
            $query = new WP_Query($args);
            while ($query->have_posts()) {
                $query->the_post();
                $newPosts[] = $post;
                $blockId = get_the_ID();
                // the_content(); // Has issues with typewritter
                // @codingStandardsIgnoreLine
                echo vcfilter('vcv:frontend:content', do_shortcode($post->post_content));
                wp_reset_postdata();
                break;
            }
        } elseif ($frontendHelper->isPageEditable()) {
            echo sprintf(
                '<div class="vcv-zone-empty"><span class="vcv-zone-empty-text">%s</span></div>',
                sprintf(__('Please Select Your %s', 'vcwb'), esc_attr($this->postNameSingular))
            );
        }

        if ($frontendHelper->isPageEditable()) {
            echo vcaddonview(
                'zone-edit-control',
                [
                    'addon' => 'themeEditor',
                    'blockId' => $blockId,
                    'editLink' => $blockId > 0 ? get_edit_post_link($blockId, 'url') : '',
                    'title' => $this->postNameSingular,
                ]
            );
        }
    }

    /**
     * Add custom post state
     *
     * @param $postState
     * @param $post
     * @param \VisualComposer\Helpers\Options $optionsHelper
     *
     * @return array
     */
    protected function addPostState($postState, $post, Options $optionsHelper)
    {
        if (get_the_ID() === (int)$optionsHelper->get('default' . $this->postType)) {
            return [sprintf(__('Default %s', 'vcwb'), $this->postNameSingular)];
        }

        return $postState;
    }

    /**
     * @param $scripts
     *
     * @return array
     */
    protected function addGlobalVariables($scripts)
    {
        $variables = [];
        $variables[] = sprintf(
            '<script>window["vcvCreate" + "%s"] = "%s";</script>',
            $this->postNameSlug,
            admin_url('post-new.php?post_type=' . $this->postType)
        );

        return array_merge($scripts, $variables);
    }

    /**
     * @param $defaultTemplatePost
     * @param $currentTemplatePost
     * @param $defaultTemplate
     * @param $currentTemplateId
     * @param \VisualComposer\Helpers\Request $requestHelper
     * @param \VisualComposer\Helpers\Frontend $frontendHelper
     * @param \VisualComposer\Helpers\Str $strHelper
     *
     * @return array
     */
    protected function getQueryArgs(
        $defaultTemplatePost,
        $currentTemplatePost,
        $defaultTemplate,
        $currentTemplateId,
        Request $requestHelper,
        Frontend $frontendHelper,
        Str $strHelper
    ) {
        $args = [
            'post_type' => $this->postType,
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ];
        // @codingStandardsIgnoreLine
        if ($defaultTemplatePost && $defaultTemplatePost->post_status === 'publish'
            // @codingStandardsIgnoreLine
            && (!$currentTemplatePost || $currentTemplatePost->post_status !== 'publish')) {
            $args['p'] = $defaultTemplate;
            // @codingStandardsIgnoreLine
        } elseif ($currentTemplatePost && $currentTemplatePost->post_status === 'publish') {
            $args['p'] = $currentTemplateId;
        }

        if ($requestHelper->exists('vcv-' . $strHelper->lower($this->postNameSlug))
            && $frontendHelper->isPageEditable()) {
            if ('default' === $requestHelper->input('vcv-' . $strHelper->lower($this->postNameSlug))
                && $defaultTemplatePost
                // @codingStandardsIgnoreLine
                && $defaultTemplatePost->post_status === 'publish') {
                $args['p'] = $defaultTemplate;
            } else {
                $args['p'] = intval($requestHelper->input('vcv-' . $strHelper->lower($this->postNameSlug)));
            }
        }

        return $args;
    }

    protected function enableExportTypes($postTypes)
    {
        array_push($postTypes, $this->postType);

        return $postTypes;
    }

    protected function checkHfs($state, Request $requestHelper, Frontend $frontendHelper, Str $strHelper)
    {
        $state = false;

        $sourceId = get_the_ID();
        if ($frontendHelper->isPreview()) {
            $preview = wp_get_post_autosave($sourceId);
            if (is_object($preview)) {
                $sourceId = $preview->ID;
            }
        }

        $currentTemplateId = get_post_meta($sourceId, '_' . VCV_PREFIX . $this->postNameSlug . 'TemplateId', true);
        $currentHfs = $requestHelper->input('vcv-' . $strHelper->lower($this->postNameSlug));

        if (($currentHfs !== 'none' && $currentTemplateId !== 'none')
            || ($currentTemplateId === 'none'
                && $currentHfs
                && $currentHfs !== 'none')) {
            $state = true;
        }

        return $state;
    }
}
