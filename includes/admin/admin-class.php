<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXUTWFC_Admin_Main
{

	// list of model names used in the plugin
	public $models_collection = [
		'MXUTWFC_Main_Page_Model'
	];

	/*
	* MXUTWFC_Admin_Main constructor
	*/
	public function __construct()
	{

	}

	/*
	* Additional classes
	*/
	public function mxutwfc_additional_classes()
	{

		// enqueue_scripts class
		mxutwfc_require_class_file_admin( 'enqueue-scripts.php' );

		MXUTWFC_Enqueue_Scripts::mxutwfc_register();

		// mx metaboxes class
		mxutwfc_require_class_file_admin( 'metabox.php' );

		mxutwfc_require_class_file_admin( 'metabox-image-upload.php' );

		MXUTWFC_Metaboxes_Image_Upload_Class::register_scrips();
		
		// CPT class
		// mxutwfc_require_class_file_admin( 'cpt.php' );

		// MXUTWFCCPTclass::createCPT();

	}

	/*
	* Models Connection
	*/
	public function mxutwfc_models_collection()
	{

		// require model file
		foreach ( $this->models_collection as $model ) {
			
			mxutwfc_use_model( $model );

		}		

	}

	/**
	* registration ajax actions
	*/
	public function mxutwfc_registration_ajax_actions()
	{

		// ajax requests to main page
		MXUTWFC_Main_Page_Model::mxutwfc_wp_ajax();

	}

	/*
	* Routes collection
	*/
	public function mxutwfc_routes_collection()
	{

		// main menu item
		MXUTWFC_Route::mxutwfc_get( 'MXUTWFC_Main_Page_Controller', 'index', '', [
			'page_title' => 'Import products',
			'menu_title' => 'Import products'
		] );

	}

}

// Initialize
$initialize_admin_class = new MXUTWFC_Admin_Main();

// include classes
$initialize_admin_class->mxutwfc_additional_classes();

// include models
$initialize_admin_class->mxutwfc_models_collection();

// ajax requests
$initialize_admin_class->mxutwfc_registration_ajax_actions();

// include controllers
$initialize_admin_class->mxutwfc_routes_collection();