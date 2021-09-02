<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*
* Error Handle calss
*/
class MXUTWFC_Display_Error
{

	/**
	* Error notice
	*/
	public $mxutwfc_error_notice = '';

	public function __construct( $mxutwfc_error_notice )
	{

		$this->mxutwfc_error_notice = $mxutwfc_error_notice;

	}

	public function mxutwfc_show_error()
	{
		add_action( 'admin_notices', function() { ?>

			<div class="notice notice-error is-dismissible">

			    <p><?php echo esc_attr( $this->mxutwfc_error_notice ); ?></p>
			    
			</div>
		    
		<?php } );
	}

}