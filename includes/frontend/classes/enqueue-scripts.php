<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXUTWFC_Enqueue_Scripts_Frontend
{

	/*
	* MXUTWFC_Enqueue_Scripts_Frontend
	*/
	public function __construct()
	{

	}

	/*
	* Registration of styles and scripts
	*/
	public static function mxutwfc_register()
	{

		// register scripts and styles
		add_action( 'wp_enqueue_scripts', [ 'MXUTWFC_Enqueue_Scripts_Frontend', 'mxutwfc_enqueue' ] );

	}

		public static function mxutwfc_enqueue()
		{

			wp_enqueue_style( 'mxutwfc_font_awesome', MXUTWFC_PLUGIN_URL . 'assets/font-awesome-4.6.3/css/font-awesome.min.css' );
			
			wp_enqueue_style( 'mxutwfc_style', MXUTWFC_PLUGIN_URL . 'includes/frontend/assets/css/style.css', [ 'mxutwfc_font_awesome' ], MXUTWFC_PLUGIN_VERSION, 'all' );
			
			wp_enqueue_script( 'mxutwfc_script', MXUTWFC_PLUGIN_URL . 'includes/frontend/assets/js/script.js', [ 'jquery' ], MXUTWFC_PLUGIN_VERSION, false );
		
		}

}