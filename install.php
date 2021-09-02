<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// create table class
require_once MXUTWFC_PLUGIN_ABS_PATH . 'includes/core/create-table.php';

class MXUTWFC_Basis_Plugin_Class
{

	private static $table_slug = MXUTWFC_TABLE_SLUG;

	public static function activate()
	{
		

	}

	public static function deactivate()
	{

		
	}

	/*
	* This function sets the option in the table for CPT rewrite rules
	*/
	public static function create_option_for_activation()
	{


	}

}