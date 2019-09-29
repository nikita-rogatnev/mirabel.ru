<?php

namespace basicMenu\basicMenu;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

use VisualComposer\Framework\Container;
use VisualComposer\Framework\Illuminate\Support\Module;
use VisualComposer\Helpers\Traits\EventsFilters;

class WpMenuController extends Container implements Module
{
    use EventsFilters;

    public function __construct()
    {
        if (!defined('VCV_WP_MENU_CONTROLLER')) {
            $this->addFilter(
                'vcv:editor:variables vcv:editor:variables/basicMenu',
                'getVariables'
            );
            define('VCV_WP_MENU_CONTROLLER', true);
        }
    }

    /**
     * @param $variables
     * @param $payload
     *
     * @return array
     */
    protected function getVariables($variables, $payload)
    {
        $menuList = get_terms('nav_menu');
        $values = [];
        foreach ($menuList as $key => $menu) {
            $values[] = [
                'label' => $menu->name,
                'value' => $menu->slug,
            ];
        }

        if (empty($values)) {
            $values[] = [
                'label' => __('Select your menu', 'vcwb'),
                'value' => '',
            ];
        }


        $variables[] = [
            'key' => 'vcvWpMenus',
            'value' => $values,
        ];

        return $variables;
    }
}
