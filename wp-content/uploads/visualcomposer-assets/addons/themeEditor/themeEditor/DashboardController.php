<?php

namespace themeEditor\themeEditor;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

use VisualComposer\Framework\Container;
use VisualComposer\Framework\Illuminate\Support\Module;
use VisualComposer\Helpers\Traits\WpFiltersActions;

class DashboardController extends Container implements Module
{
    use WpFiltersActions;

    public function __construct()
    {
        $this->wpAddFilter('admin_menu', 'checkSubmenu', 11);
    }

    protected function checkSubmenu()
    {
        global $submenu;

        if (isset($submenu) && isset($submenu['vcv-settings'])) {
            foreach ($submenu['vcv-settings'] as $id => $meta) {
                if (strpos($meta[2], '&classic-editor') !== false) {
                    unset($submenu['vcv-settings'][ $id ]);
                }
            }
        }
    }
}
