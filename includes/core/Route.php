<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// require Route-Registrar.php
require_once MXUTWFC_PLUGIN_ABS_PATH . 'includes/core/Route-Registrar.php';

/*
* Routes class
*/
class MXUTWFC_Route
{

	public function __construct()
	{
		// ...
	}
	
	public static function mxutwfc_get( ...$args )
	{

		return new MXUTWFC_Route_Registrar( ...$args );

	}
	
}