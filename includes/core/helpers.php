<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*
* Require class for admin panel
*/
function mxutwfc_require_class_file_admin( $file ) {

	require_once MXUTWFC_PLUGIN_ABS_PATH . 'includes/admin/classes/' . $file;

}


/*
* Require class for frontend panel
*/
function mxutwfc_require_class_file_frontend( $file ) {

	require_once MXUTWFC_PLUGIN_ABS_PATH . 'includes/frontend/classes/' . $file;

}

/*
* Require a Model
*/
function mxutwfc_use_model( $model ) {

	require_once MXUTWFC_PLUGIN_ABS_PATH . 'includes/admin/models/' . $model . '.php';

}

/*
* Debugging
*/
function mxutwfc_debug_to_file( $content ) {

	$content = mxutwfc_content_to_string( $content );

	$path = MXUTWFC_PLUGIN_ABS_PATH . 'mx-debug' ;

	if( ! file_exists( $path ) ) :

		mkdir( $path, 0777, true );

		file_put_contents( $path . '/mx-debug.txt', $content );

	else :

		file_put_contents( $path . '/mx-debug.txt', $content );

	endif;

}
	// pretty debug text to the file
	function mxutwfc_content_to_string( $content ) {

		ob_start();

		var_dump( $content );

		return ob_get_clean();

	}

/*
* Manage posts columns. Add column to position
*/
function mxutwfc_insert_new_column_to_position( array $columns, int $position, array $new_column ) {

	$chunked_array = array_chunk( $columns, $position, true );

	$result = array_merge( $chunked_array[0], $new_column, $chunked_array[1] );

	return $result;

}

// 
function mxutwfc_file_download( $img_url ) { 

	$url = $img_url;

	$timeout_seconds = 5;

	// Download file to temp dir
	$temp_file = download_url( $url, $timeout_seconds );

	if ( ! is_wp_error( $temp_file ) ) {

		$wp_file_type = wp_check_filetype($temp_file);

		$filemime = $wp_file_type['type'];

		// Array based on $_FILE as seen in PHP file uploads
		$file = [
			'name'     => basename( $url ),
			'type'     => $filemime,
			'tmp_name' => $temp_file,
			'error'    => 0,
			'size'     => filesize( $temp_file )
		];

		$overrides = [
			'test_form' => false,
			'test_size' => true,
		];

		// Move the temporary file into the uploads directory
		$results = media_handle_sideload( $file ); 

		return $results;
		//	$results = media_handle_sideload( $file, $overrides );

	}

}

// if url exists
function mxutwfc_does_url_exists( $url ) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_exec($ch);

	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	if ($code == 200) {
		$status = true;
	} else {
		$status = false;
	}

	curl_close($ch);
	return $status;
}