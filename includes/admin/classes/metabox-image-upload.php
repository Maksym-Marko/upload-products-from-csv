<?php 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// metabox creating main class
class MXUTWFC_Metaboxes_Image_Upload_Class
{

	// we will use jQuery
	// So we have to register scripts

	public static function register_scrips()
	{
		add_action( 'admin_enqueue_scripts', ['MXUTWFC_Metaboxes_Image_Upload_Class', 'upload_image_scrips'] );
	}

		public static function upload_image_scrips()
		{

			wp_enqueue_script( 'mxutwfc_image-upload', MXUTWFC_PLUGIN_URL . 'includes/admin/assets/js/image-upload.js', [ 'jquery' ], MXUTWFC_PLUGIN_VERSION, false );

		}

}
