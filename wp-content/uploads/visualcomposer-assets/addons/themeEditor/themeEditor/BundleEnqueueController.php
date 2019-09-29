<?php

namespace themeEditor\themeEditor;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

use VisualComposer\Framework\Container;
use VisualComposer\Framework\Illuminate\Support\Module;
use VisualComposer\Helpers\Assets;
use VisualComposer\Helpers\Frontend;
use VisualComposer\Helpers\Request;
use VisualComposer\Helpers\Traits\EventsFilters;
use VisualComposer\Helpers\Url;

class BundleEnqueueController extends Container implements Module
{
    use EventsFilters;

    public function __construct()
    {
        $this->addFilter(
            'vcv:editors:frontend:render',
            function ($response, Request $requestHelper, Frontend $frontendHelper) {
                if ($requestHelper->exists('vcv-editor-type') && $frontendHelper->isFrontend()) {
                    /** @see \VisualComposer\Modules\Editors\Frontend\BundleController::addFooterBundleScript */
                    $this->addFilter('vcv:frontend:footer:extraOutput', 'addFooterBundleScript', 10);
                    $this->addFilter('vcv:editor:variables', 'addEditorTypeVariable');
                } elseif (!$requestHelper->exists('vcv-editor-type') && $frontendHelper->isFrontend()) {
                    /** @see \VisualComposer\Modules\Editors\Frontend\BundleController::addFooterBundleScript */
                    $this->addFilter('vcv:frontend:footer:extraOutput', 'addFooterBundleScriptFe', 10);
                }

                return $response;
            },
            -2
        );
    }

    protected function addEditorTypeVariable($variables, Request $requestHelper)
    {
        $key = 'VCV_EDITOR_TYPE';
        $value = 'header';
        switch ($requestHelper->input('vcv-editor-type')) {
            case 'vcv_headers':
                $value = 'header';
                break;
            case 'vcv_footers':
                $value = 'footer';
                break;
            case 'vcv_sidebars':
                $value = 'sidebar';
                break;
        }

        $variables[] = [
            'key' => $key,
            'value' => $value,
            'type' => 'constant',
        ];

        return $variables;
    }

    protected function addFooterBundleScript($response, $payload, Url $urlHelper, Assets $assetsHelper)
    {
        // Add JS
        if (vcvenv('VCV_ENV_DEV_ADDONS')) {
            $response = array_merge(
                (array)$response,
                [
                    sprintf(
                        '<script id="vcv-script-theme-editor-fe-bundle" type="text/javascript" src="%s"></script>',
                        $urlHelper->to(
                            'devAddons/themeEditor/public/dist/themeEditor.bundle.js?v=' . VCV_VERSION
                        )
                    ),
                ]
            );
        } else {
            $response = array_merge(
                (array)$response,
                [
                    sprintf(
                        '<script id="vcv-script-theme-editor-fe-bundle" type="text/javascript" src="%s"></script>',
                        $assetsHelper->getAssetUrl(
                            '/addons/themeEditor/public/dist/themeEditor.bundle.js?v=' . VCV_VERSION
                        )
                    ),
                ]
            );
        }

        return $response;
    }

    protected function addFooterBundleScriptFe($response, $payload, Url $urlHelper, Assets $assetsHelper)
    {
        // Add JS
        if (vcvenv('VCV_ENV_DEV_ADDONS')) {
            $response = array_merge(
                (array)$response,
                [
                    sprintf(
                        '<script id="vcv-script-theme-layouts-fe-bundle" type="text/javascript" src="%s"></script>',
                        $urlHelper->to(
                            'devAddons/themeEditor/public/dist/layoutsView.bundle.js?v=' . VCV_VERSION
                        )
                    ),
                ]
            );
        } else {
            $response = array_merge(
                (array)$response,
                [
                    sprintf(
                        '<script id="vcv-script-theme-layouts-fe-bundle" type="text/javascript" src="%s"></script>',
                        $assetsHelper->getAssetUrl(
                            '/addons/themeEditor/public/dist/layoutsView.bundle.js?v=' . VCV_VERSION
                        )
                    ),
                ]
            );
        }

        return $response;
    }
}
