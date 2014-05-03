<?php
/**
Plugin Name: bValidator
Plugin URI: http://wordpress.org/plugins/bvalidator/
Description: Includes jQuery and CSS for bValidator
Tags: bvalidator,jquery,validation.validator
Version: 1.0
Author: Nishant Vaity
Author URI: http://profiles.wordpress.org/enishant/
License: GPL2
*/

class bValidator
{
	function __construct()
	{
		add_action( 'wp_enqueue_scripts', array($this,'bvalidator_enqueue_scripts'));	
		add_shortcode('binitform', array($this,'bvalidator_init_form'));
		register_activation_hook( __FILE__, array($this,'send_email_on_plugin_activate'));
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

	function send_email_on_plugin_activate() 
	{
		$plugin_title = "bValidator";
		$plugin_url = 'http://wordpress.org/plugins/bvalidator/';
		$plugin_support_url = 'http://wordpress.org/support/plugin/bvalidator';
		$plugin_author = 'Nishant Vaity';
		$plugin_author_url = 'https://github.com/enishant';
		$plugin_author_mail = 'enishant@gmail.com';

		$website_name  = get_option('blogname');
		$adminemail = get_option('admin_email');
		$user = get_user_by( 'email', $adminemail );

		$headers = 'From: ' . $website_name . ' <' . $adminemail . '>' . "\r\n";
		$subject = "Thank you for installing " . $plugin_title . "!\n";
		if($user->first_name)
		{
			$message = "Dear " . $user->first_name . ",\n\n";
		}
		else
		{
			$message = "Dear Administrator,\n\n";
		}
		$message.= "Thank your for installing " . $plugin_title . " plugin.\n";
		$message.= "Visit this plugin's site at " . $plugin_url . " \n\n";
		$message.= "Please write your queries and suggestions at developers support \n" . $plugin_support_url ."\n";
		$message.= "All the best !\n\n";
		$message.= "Thanks & Regards,\n";
		$message.= $plugin_author . "\n";
		$message.= $plugin_author_url ;
		wp_mail( $adminemail, $subject, $message,$headers);
		
		$subject = $plugin_title . " plugin is installed and activated by website " . get_option('home') ."\n";
		$message = $plugin_title  . " plugin is installed and activated by website " . get_option('home') ."\n\n";
		$message.= "Website : " . get_option('home') . "\n";
		$message.="Email : " . $adminemail . "\n";
		if($user->first_name)
		{
			$message.= "First name : " . $user->first_name . " \n";
		}
		if($user->last_name)
		{
			$message.= "Last name : " . $user->last_name . "\n";	
		}
		wp_mail( $plugin_author_mail , $subject, $message,$headers);
	}
}
new bValidator;
?>
