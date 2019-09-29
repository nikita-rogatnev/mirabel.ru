<?php

namespace themeEditor\themeEditor;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

require_once('PostTypeController.php');

use VisualComposer\Framework\Illuminate\Support\Module;

class SidebarController extends PostTypeController implements Module
{
    /**
     * @var string
     */
    protected $postType = 'vcv_sidebars';

    protected $postNameSlug = 'Sidebar';

    public function __construct()
    {
        $this->postNameSingular = __('Sidebar', 'vcwb');
        $this->postNamePlural = __('Sidebars', 'vcwb');
        parent::__construct();
    }
}
