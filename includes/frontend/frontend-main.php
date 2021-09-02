<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXUTWFC_FrontEnd_Main
{

	/*
	* MXUTWFC_FrontEnd_Main constructor
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
		mxutwfc_require_class_file_frontend( 'enqueue-scripts.php' );

		MXUTWFC_Enqueue_Scripts_Frontend::mxutwfc_register();

	}

}

// Initialize
$initialize_admin_class = new MXUTWFC_FrontEnd_Main();

// include classes
$initialize_admin_class->mxutwfc_additional_classes();