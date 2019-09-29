<?php
/**
Plugin Name: UniSender
Plugin URI: http://www.unisender.com/
Description: Integrate the blog with UniSender newsletter delivery service
Version: 2.0.6
Author: UniSender
Author URI: http://www.unisender.com/
License: GPL2

Copyright (c) 2010. UniSender Software Ltd.  (email : plugins@unisender.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

*/


require_once(plugin_dir_path(__FILE__).'class/UnisenderActivation.php');
require_once(plugin_dir_path(__FILE__).'class/UnisenderApi.php');
require_once(plugin_dir_path(__FILE__).'class/UnisenderContactList.php');
require_once(plugin_dir_path(__FILE__).'class/UnisenderField.php');
require_once(plugin_dir_path(__FILE__).'class/UnisenderForm.php');
require_once(plugin_dir_path(__FILE__).'class/UnisenderMessage.php');

load_plugin_textdomain('unisender',  false, basename( dirname( __FILE__ ) ) . '/languages');

register_activation_hook(__FILE__, array('UnisenderActivation', 'activatePlugin'));
register_deactivation_hook(__FILE__, array('UnisenderActivation', 'deactivatePlugin'));

add_action('admin_menu', array('UnisenderActivation', 'addMenuPages'));

add_action('widgets_init', 'registerUnisenderWidget');
add_action('wp_ajax_unisenderSubscribe', array('UnisenderForm', 'actionSubscribe'));
add_action('wp_ajax_nopriv_unisenderSubscribe', array('UnisenderForm', 'actionSubscribe'));

add_action('wp_ajax_unisenderGetLetterBody', array('UnisenderMessage', 'actionGetLetterBody'));
add_action('wp_ajax_nopriv_unisenderGetLetterBody', array('UnisenderMessage', 'actionGetLetterBody'));

function registerUnisenderWidget()
{
	register_widget("UnisenderWidget");
	return true;
}

abstract class UnisenderAbstract
{
	public $textdomain = 'unisender';
	protected $section;

	public function __construct()
	{
		$action = !empty($_POST['action']) ? substr($_POST['action'], 10) : 'index';

		$method = 'action'.ucfirst($action);
		if (method_exists($this, $method)) {
			$this->$method();
		} else {
			$this->actionIndex();
		}
	}

	public abstract function actionIndex();

	protected static function setResponse($isSuccess, $message = '', $redirectUrl = '')
	{
		$response['status'] = $isSuccess ? 'success' : 'error';
		if ($message !== '') {
			$response['message'] = $message;
		}
		if ($redirectUrl !== '') {
			$response['redirectUrl'] = $redirectUrl;
		}

		return json_encode($response);
	}


	protected function render($tpl, $data = array())
	{
		$tpl = $this->section . '/' . $tpl . '.php';
		foreach ($data as $name => $value) {
			$$name = $value;
		}
		include(plugin_dir_path(__FILE__) . '/tpl/base.php');
	}
}

class UnisenderWidget extends WP_Widget
{
	public $textdomain = 'unisender';

	public function __construct() {
		parent::__construct(
			'unisender_subscribe_form',
			__('Unisender subscription form', $this->textdomain),
			array('description' => __('Allows you to display the subscription form for the visitors', $this->textdomain))
		);
	}

	public function widget($args, $instance)
	{
		$defaultListId = UnisenderContactList::getDefaultListId();
		if (!$defaultListId) {
			return false;
		}
		wp_enqueue_script('unisender', plugin_dir_url(__FILE__) . 'js/unisender.js');
		wp_localize_script('unisender', 'WPURLS', array('siteurl' => get_option('siteurl')));
		wp_enqueue_style('unisender', plugin_dir_url(__FILE__) . 'css/unisender.css', false);
		wp_enqueue_style('unisender_datetime', plugin_dir_url(__FILE__) . '/css/jquery.datetimepicker.css', false);
		wp_enqueue_script('unisender_datetime', plugin_dir_url(__FILE__) . '/js/jquery.datetimepicker.js');

		$fields = UnisenderField::getFields(false, true);

		echo '<aside id="'. $args['widget_id'] .'" class="widget unisender_form">';
		echo '<h2 class="widget-title">' . get_option('unisender_form_title', __('Subscribe', $this->textdomain)) . '</h2>';
		echo '<form name="'. $args['widget_id'] .'" method="POST" id="unisender_subscribe_form">';
		echo '<input type="hidden" name="action" value="unisenderSubscribe">';
		foreach ($fields as $f) {
			echo '<label for="' . $f['name'] . '">'
			     . $f['public_name']
			     . ($f['is_form_required'] ? '<span class="required"> *</span>' : '')
			     . '</label><br>';
			$type = 'text';
			if ($f['type'] === 'text' && $f['name'] === 'email') {
				$type = 'email';
			} elseif ($f['type'] === 'date') {
				echo '<script type="text/javascript">jQuery(document).ready(function() {
			             jQuery("#'.$f['name'].'").datetimepicker({format: "Y-m-d H:i"});});</script>';
				$type = 'text" readonly="readonly';
			} elseif ($f['type'] === 'bool') {
				$type = 'checkbox';
			} elseif ($f['type'] === 'number') {
				$type = 'number';
			} elseif ($f['type'] === 'text') {
				echo '<textarea name="' . $f['name'] . '" id="'
				     . $f['name'] . '" placeholder="' . (!empty($f['placeholder']) ? $f['placeholder'] : '') . '"'
				     . ($f['is_form_required'] ? 'required="required"' : '') .'></textarea><br><br>';
				continue;
			}

			echo '<input type="' . $type . '" name="' . $f['name'] . '" id="'
			     . $f['name'] . '" placeholder="' . (!empty($f['placeholder']) ? $f['placeholder'] : '') . '"'
			     . ($f['is_form_required'] ? 'required="required"' : '') .'><br><br>';
		}
		echo '<input type="submit" value="' . get_option('unisender_from_title', __('Subscribe', $this->textdomain)) . '">';
		echo '<img src="' . admin_url('images/spinner.gif') . '" style="margin-left: 10px; display: none;">';
		echo '</form>';
		echo '</aside>';
	}
}
