<?php

namespace basicMenu\basicMenu;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

use VisualComposer\Framework\Illuminate\Support\Module;
use VisualComposer\Framework\Container;
use VisualComposer\Helpers\Traits\EventsFilters;
use VisualComposer\Modules\Elements\Traits\AddShortcodeTrait;

class WpMenuShortcode extends Container implements Module
{
    use EventsFilters;
    use AddShortcodeTrait;

    public function __construct()
    {
        if (!defined('VCV_WP_BASIC_MENU_SHORTCODE')) {
            $this->addEvent('vcv:inited', 'registerShortcode');
            define('VCV_WP_BASIC_MENU_SHORTCODE', true);
        }
    }

    /**
     *
     */
    protected function registerShortcode()
    {
        $this->addShortcode('vcv_menu', 'render');
    }

    /**
     * @param $atts
     * @param $content
     * @param $tag
     *
     * @return string
     */
    protected function render($atts, $content, $tag)
    {
        $output = '';
        $atts = shortcode_atts(
            [
                'key' => '',
            ],
            $atts
        );
        if (empty($atts['key'])) {
            $menuList = get_terms('nav_menu');
            $current = current($menuList);
            if (!empty($current)) {
                $atts['key'] = $current->slug;
            }
        }

        if ($atts['key'] && is_nav_menu($atts['key'])) {
            ob_start();
            wp_nav_menu(
                [
                    'menu' => $atts['key'],
                    'container' => 'nav',
                    'menu_id' => '1',
                    'walker' => new MenuWalker(),
                ]
            );
            $output = ob_get_clean();

            $output = str_replace('id="1"', '', $output);
        }

        return $output;
    }
}
