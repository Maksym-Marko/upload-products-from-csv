<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXUTWFC_Enqueue_Scripts
{

	/*
	* MXUTWFC_Enqueue_Scripts
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
		add_action( 'admin_enqueue_scripts', [ 'MXUTWFC_Enqueue_Scripts', 'mxutwfc_enqueue' ] );

	}

		public static function mxutwfc_enqueue()
		{

			wp_enqueue_style( 'mxutwfc_font_awesome', MXUTWFC_PLUGIN_URL . 'assets/font-awesome-4.6.3/css/font-awesome.min.css' );

			wp_enqueue_style( 'mxutwfc_admin_style', MXUTWFC_PLUGIN_URL . 'includes/admin/assets/css/style.css', [ 'mxutwfc_font_awesome' ], MXUTWFC_PLUGIN_VERSION, 'all' );



			// include Vue.js
				// dev version
				wp_enqueue_script( 'mx_ddp_vue_js', MXUTWFC_PLUGIN_URL . 'includes/admin/assets/add/vue_js/vue.dev.js', [], MXUTWFC_PLUGIN_VERSION, true );

				// production version
				// wp_enqueue_script( 'mx_ddp_vue_js', MXUTWFC_PLUGIN_URL . 'includes/admin/assets/add/vue_js/vue.production.js', [], MXUTWFC_PLUGIN_VERSION, true );

			wp_enqueue_media();

			wp_enqueue_script( 'mxaio_admin_script', MXUTWFC_PLUGIN_URL . 'includes/admin/assets/js/script.js', ['jquery', 'mx_ddp_vue_js'], MXUTWFC_PLUGIN_VERSION, true );

			wp_localize_script( 'mxaio_admin_script', 'mxutwfc_admin_localize', [

				'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
				'nonce' 			=> wp_create_nonce( 'mxutwfc_nonce_request' )

			] );

		}

}