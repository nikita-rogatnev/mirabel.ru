<?php

namespace themeEditor\themeEditor;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

use VisualComposer\Framework\Container;
use VisualComposer\Framework\Illuminate\Support\Module;
use VisualComposer\Helpers\Hub\Addons;
use VisualComposer\Helpers\Traits\EventsFilters;

class PageTemplateLayoutController extends Container implements Module
{
    use EventsFilters;

    protected $addonPath;

    public function __construct(Addons $addonsHelper)
    {
        $this->addonPath = rtrim($addonsHelper->getAddonRealPath('themeEditor'), '\\/');

        $this->addFilter('vcv:editor:settings:pageTemplatesLayouts', 'addHfsLayouts');
        $this->addFilter('vcv:editor:settings:viewPageTemplate', 'viewVcThemeTemplate');

        $this->addFilter('vcv:editor:settings:peTemplate', 'viewVcThemeTemplate');
    }

    protected function addHfsLayouts($templates)
    {
        $templates[] = [
            'type' => 'vc-theme',
            'title' => __('Visual Composer Premium'),
            'values' => [
                [
                    'label' => __('Header and Footer', 'vcwb'),
                    'value' => 'header-footer-layout',
                    'header' => true,
                    'footer' => true,
                ],
                [
                    'label' => __('Right Sidebar', 'vcwb'),
                    'value' => 'header-footer-sidebar-layout',
                    'header' => true,
                    'footer' => true,
                    'sidebar' => true,
                ],
                [
                    'label' => __('Left Sidebar', 'vcwb'),
                    'value' => 'header-footer-sidebar-left-layout',
                    'header' => true,
                    'footer' => true,
                    'sidebar' => true,
                ],
            ],
        ];

        return $templates;
    }

    protected function viewVcThemeTemplate($originalTemplate, $data)
    {
        if ($data && $data['type'] === 'vc-theme') {
            if (in_array(
                $data['value'],
                ['header-footer-layout', 'header-footer-sidebar-layout', 'header-footer-sidebar-left-layout']
            )) {
                $template = '/views/layouts/vcv-' . $data['value'] . '.php';

                return $this->addonPath . $template;
            }
        }

        return $originalTemplate;
    }
}
