<?php

namespace themeEditor\themeEditor;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

use VisualComposer\Framework\Container;
use VisualComposer\Framework\Illuminate\Support\Module;
use VisualComposer\Helpers\Request;
use VisualComposer\Helpers\Traits\EventsFilters;

class TemplateController extends Container implements Module
{
    use EventsFilters;

    public function __construct()
    {
        $this->addEvent('vcv:editor:template:create', 'setTemplateType');
        $this->addFilter('vcv:template:groupName', 'getGroupName');
    }

    protected function setTemplateType($templateId, Request $requestHelper)
    {
        switch ($requestHelper->input('vcv-template-type')) {
            case 'header':
                update_post_meta($templateId, '_' . VCV_PREFIX . 'type', 'customHeader');
                break;
            case 'footer':
                update_post_meta($templateId, '_' . VCV_PREFIX . 'type', 'customFooter');
                break;
            case 'sidebar':
                update_post_meta($templateId, '_' . VCV_PREFIX . 'type', 'customSidebar');
                break;
        }
    }

    protected function getGroupName($name, $payload)
    {
        switch ($payload['key']) {
            case 'hubHeader':
                $name = __('Header Templates', 'vcwb');
                break;
            case 'hubFooter':
                $name = __('Footer Templates', 'vcwb');
                break;
            case 'hubSidebar':
                $name = __('Sidebar Templates', 'vcwb');
                break;
            case 'block':
                $name = __('Block Templates', 'vcwb');
                break;
        }

        return $name;
    }

    protected function viewVcTemplate($originalTemplate, $data)
    {
        if ($data && $data['type'] === 'vc') {
            if (in_array($data['value'], ['blank', 'boxed'])) {
                $template = $data['value'] . '-template.php';

                return vcapp()->path('visualcomposer/resources/views/editor/templates/') . $template;
            }
        }

        return $originalTemplate;
    }
}
