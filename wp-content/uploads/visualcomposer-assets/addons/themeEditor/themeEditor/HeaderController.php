<?php

namespace themeEditor\themeEditor;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}
require_once('PostTypeController.php');

use VisualComposer\Framework\Illuminate\Support\Module;

class HeaderController extends PostTypeController implements Module
{
    /**
     * @var string
     */
    protected $postType = 'vcv_headers';

    protected $postNameSlug = 'Header';

    public function __construct()
    {
        $this->postNameSingular = __('Header', 'vcwb');
        $this->postNamePlural = __('Headers', 'vcwb');
        parent::__construct();
    }
}
