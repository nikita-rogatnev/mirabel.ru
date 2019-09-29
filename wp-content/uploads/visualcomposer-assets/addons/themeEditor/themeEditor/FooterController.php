<?php

namespace themeEditor\themeEditor;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}
require_once('PostTypeController.php');

use VisualComposer\Framework\Illuminate\Support\Module;

class FooterController extends PostTypeController implements Module
{
    /**
     * @var string
     */
    protected $postType = 'vcv_footers';

    protected $postNameSlug = 'Footer';

    public function __construct()
    {
        $this->postNameSingular = __('Footer', 'vcwb');
        $this->postNamePlural = __('Footers', 'vcwb');
        parent::__construct();
    }
}
