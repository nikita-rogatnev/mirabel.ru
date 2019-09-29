<?php

namespace themeEditor\themeEditor;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

use VisualComposer\Framework\Container;
use VisualComposer\Framework\Illuminate\Support\Module;
use VisualComposer\Helpers\Frontend;
use VisualComposer\Helpers\Request;
use VisualComposer\Helpers\Traits\EventsFilters;

class SaveController extends Container implements Module
{
    use EventsFilters;

    public function __construct()
    {
        $this->addFilter('vcv:dataAjax:setData', 'savePostLayouts');
        $this->addFilter('vcv:assets:postTypes', 'addPostTypes');
    }

    protected function addPostTypes($postTypes)
    {
        $postTypes = array_merge(
            $postTypes,
            [
                'vcv_headers',
                'vcv_footers',
                'vcv_sidebars',
            ]
        );

        return $postTypes;
    }

    protected function savePostLayouts($response, $payload, Request $requestHelper, Frontend $frontendHelper)
    {
        if (!vcIsBadResponse($response)) {
            if ($requestHelper->exists('vcv-extra')) {
                $extra = $requestHelper->input('vcv-extra');
                $sourceId = $payload['sourceId'];
                if ($frontendHelper->isPreview()) {
                    $preview = wp_get_post_autosave($sourceId);
                    if (is_object($preview)) {
                        $sourceId = $preview->ID;
                    }
                }
                $headerId = '';
                if (is_array($extra) && array_key_exists('vcv-header-id', $extra)) {
                    // Save custom header ID
                    $headerId = $extra['vcv-header-id'];
                }
                $sidebarId = '';
                if (is_array($extra) && array_key_exists('vcv-sidebar-id', $extra)) {
                    // Save custom header ID
                    $sidebarId = $extra['vcv-sidebar-id'];
                }
                $footerId = '';
                if (is_array($extra) && array_key_exists('vcv-footer-id', $extra)) {
                    // Save custom header ID
                    $footerId = $extra['vcv-footer-id'];
                }

                $this->updateMetadata($sourceId, $headerId, $sidebarId, $footerId);
            }
        }

        return $response;
    }

    /**
     * @param $sourceId
     * @param $headerId
     * @param $sidebarId
     * @param $footerId
     */
    protected function updateMetadata($sourceId, $headerId, $sidebarId, $footerId)
    {
        update_metadata(
            'post',
            $sourceId,
            '_' . VCV_PREFIX . 'HeaderTemplateId',
            $headerId
        );
        update_metadata(
            'post',
            $sourceId,
            '_' . VCV_PREFIX . 'SidebarTemplateId',
            $sidebarId
        );
        update_metadata(
            'post',
            $sourceId,
            '_' . VCV_PREFIX . 'FooterTemplateId',
            $footerId
        );
    }
}
