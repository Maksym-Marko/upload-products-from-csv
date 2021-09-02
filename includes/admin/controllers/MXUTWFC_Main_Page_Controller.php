<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXUTWFC_Main_Page_Controller extends MXUTWFC_Controller
{
	
	public function index()
	{

		$data = null;

		return new MXUTWFC_View( 'main-page', $data );

	}

	public function submenu()
	{

		return new MXUTWFC_View( 'sub-page' );

	}

	public function hidemenu()
	{

		return new MXUTWFC_View( 'hidemenu-page' );

	}

	public function settings_menu_item_action()
	{

		return new MXUTWFC_View( 'settings-page' );

	}

}