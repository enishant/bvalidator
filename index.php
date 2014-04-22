<?php
/**
Plugin Name: bValidator
Plugin URI: https://github.com/enishant
Description: Includes jQuery and CSS for bValidator
Tags: bvalidator,jquery,validation.validator
Version: 1.0
Author: Nishant Vaity
Author URI: https://github.com/enishant
License: GPL2
Reference : http://bojanmauser.from.hr/bvalidator/
*/

class bValidator
{
	function __construct()
	{
		add_action( 'wp_enqueue_scripts', array($this,'bvalidator_enqueue_scripts'));	
		add_shortcode('binitform', array($this,'bvalidator_init_form'));
	}

	function bvalidator_enqueue_scripts() 
	{
		wp_enqueue_style( 'bvalidator-css', plugins_url( 'bvalidator.css' , __FILE__ ) );
		wp_enqueue_script( 'bvalidator-js', plugins_url( 'jquery.bvalidator.js' , __FILE__ ));	
	}

	function bvalidator_init_form($atts)
	{
		extract( shortcode_atts( array(
		  'formid' => '',
		), $atts ) );
		if($formid)		
		{
			$bvalidator_init .= '<script type="text/javascript">';
			$bvalidator_init .= 'jQuery(document).ready(function () {';
			$bvalidator_init .= "	jQuery('#" . $formid . "').bValidator();";
			$bvalidator_init .= '});';
			$bvalidator_init .= '</script>';
		}
		return $bvalidator_init;
	}
}
new bValidator;