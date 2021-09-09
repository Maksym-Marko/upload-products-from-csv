<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Main page Model
*/
class MXUTWFC_Main_Page_Model extends MXUTWFC_Model
{

	/*
	* Observe function
	*/
	public static function mxutwfc_wp_ajax()
	{

		// get file abspath
		add_action( 'wp_ajax_mxmtzc_get_file_abspath', [ 'MXUTWFC_Main_Page_Model', 'mxmtzc_get_file_abspath' ], 10, 1 );

		// get file data
		add_action( 'wp_ajax_mxmtzc_get_file_data', [ 'MXUTWFC_Main_Page_Model', 'mxmtzc_get_file_data' ], 10, 1 );

		// insert data
		add_action( 'wp_ajax_mxmtzc_insert_data', [ 'MXUTWFC_Main_Page_Model', 'mxmtzc_prepare_data' ], 10, 1 );

		// remove posts
		add_action( 'wp_ajax_mxmtzc_remove_posts', [ 'MXUTWFC_Main_Page_Model', 'mxmtzc_remove_posts' ], 10, 1 );

		// get count posts
		add_action( 'wp_ajax_mxmtzc_get_count_posts', [ 'MXUTWFC_Main_Page_Model', 'mxmtzc_get_count_posts' ], 10, 1 );		

	}

	/*
	* get count posts
	*/
	public static function mxmtzc_get_count_posts()
	{

		// Checked POST nonce is not empty
		if( empty( $_POST['nonce'] ) ) wp_die( '0' );

		// Checked or nonce match
		if( wp_verify_nonce( $_POST['nonce'], 'mxutwfc_nonce_request' ) ) {

			global $wpdb;

			$posts_table = $wpdb->prefix . 'posts';

			$posts_count = $wpdb->get_var( 
				"SELECT COUNT(*)
					FROM $posts_table
					WHERE post_type = 'product-watches'
					AND post_status = 'publish'" 
			);

			$count = 0;

			if( $posts_count ) {

				$count = $posts_count;

			}

			echo $count;

			wp_die();

		}

	}

	/*
	* Remove data
	*/
	public static function mxmtzc_remove_posts()
	{

		// Checked POST nonce is not empty
		if( empty( $_POST['nonce'] ) ) wp_die( '0' );

		// Checked or nonce match
		if( wp_verify_nonce( $_POST['nonce'], 'mxutwfc_nonce_request' ) ) {

			$saved_posts = $_POST['saved_posts'];


			global $wpdb;

			$posts_table = $wpdb->prefix . 'posts';

			$sql_str = "SELECT ID
				FROM $posts_table
				WHERE post_type = 'product-watches'
					AND post_status = 'publish'";

			$results = $wpdb->get_results( $sql_str, ARRAY_A );

			if( $results ) {

				$post_ids = [];

				foreach ( $results as $key => $value) {
					
					$post_id = $value['ID'];

					if( ! in_array( $post_id, $saved_posts ) ) {

						$_post = [];

						$to_trash = wp_trash_post( $post_id );

						array_push( $post_ids, $post_id );

					}					

				}

				echo json_encode( $post_ids );

			}			

			wp_die();

		}

	}

	/*
	* Prepare insert data
	*/
	public static function mxmtzc_prepare_data()
	{

		// Checked POST nonce is not empty
		if( empty( $_POST['nonce'] ) ) wp_die( '0' );

		// Checked or nonce match
		if( wp_verify_nonce( $_POST['nonce'], 'mxutwfc_nonce_request' ) ) {

			$meta_query = array(
				array(
					'key' 		=> '_mx_extra-metabox-number_product-watches_id',
					'value' 	=> sanitize_text_field( $_POST['line']['id'] )
				)
			);

			$results = new WP_Query(

				array(
					'post_type' 		=> 'product-watches',
					'post_status'		=> 'publish',
					'meta_query'		=> $meta_query
				)

			);

			if( isset( $results->posts ) AND count( $results->posts ) > 0 ){

				// post exists				
				if( isset( $results->posts[0] ) ) {

					self::mxmtzc_update_data( $results->posts[0]->ID, $_POST );

				}

			} else {

				// post not exists
				self::mxmtzc_insert_data( $_POST );

			}

			// if post not exists
			// 

			wp_die();

		}

	}

	/*
	* Update data
	*/
	public static function mxmtzc_update_data( $post_id, $_post, $post_status = 'publish' )
	{

		$update_post = [];
		$update_post['ID'] = $post_id;
			
		$update_post['post_title'] = sanitize_text_field( $_post['line']['model_name'] );
		$update_post['post_content'] = $_post['line']['description'];

		$update_post['post_status'] = $post_status;

		$post_id = wp_update_post( wp_slash( $update_post ) );		

		if( $post_status == 'publish' ) {

			// update post meta
			foreach ( $_post['line'] as $key => $value ) {

				// set watch case
				if( $key == 'case' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-clock-case_product-watches_id' );

				}

				// set watch movement
				if( $key == 'movement' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-movement_product-watches_id' );

				}

				// set watch crown
				if( $key == 'crown' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-crown_product-watches_id' );

				}

				// set watch waterproofness
				if( $key == 'waterproofness' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-waterproofness_product-watches_id' );

				}

				// set watch bezel
				if( $key == 'bezel' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-bezel_product-watches_id' );

				}

				// set watch price
				if( $key == 'price' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-price_product-watches_id' );

				}

				// set watch color
				if( $key == 'color' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-clock-color_product-watches_id' );

				}

				// set watch model_short_text
				if( $key == 'model_short_text' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-model_short_text_product-watches_id' );

				}

				// set watch model_brand
				if( $key == 'model_brand' ) {

					if( $value == '' ) {

						$value = 'Brand';

					}

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-clock_brand_product-watches_id' );

				}

				// set watch model_gender
				if( $key == 'model_gender' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-product_clock_gender_product-watches_id' );

				}

				// set watch model_label_movement
				if( $key == 'model_label_movement' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-clock_label_movement_product-watches_id' );

				}

				// set watch case_material
				if( $key == 'case_material' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-case_material_product-watches_id' );

				}

				// set watch model_glass
				if( $key == 'model_glass' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-clock_glass_product-watches_id' );

				}

				// set watch model_diameter
				if( $key == 'model_diameter' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-clock_diameter_product-watches_id' );

				}
				
				// set watch water_resistance
				if( $key == 'water_resistance' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-water_resistance_product-watches_id' );

				}

				// set watch mode_warranty
				if( $key == 'mode_warranty' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-warranty_product-watches_id' );

				}

				// set watch model_clasp
				if( $key == 'model_clasp' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-clasp_product-watches_id' );

				}

				// category "model_collection"
				if( $key == 'model_collection' ) {

					if( $value !== '' ) {

						// remove post categories
						$post_categories = get_the_terms( $post_id, 'product_watches' );

						if( $post_categories ) {
							
							foreach( $post_categories as $key => $_value ) {

								wp_remove_object_terms( $post_id, $_value->slug, 'product_watches' );

							}

						}

						// set category
						$cat = get_term_by( 'name', $value, 'product_watches' );

						if ( $cat ) {
							
							$cat_id = intval( $cat->term_id );

							wp_set_post_terms( $post_id, [$cat_id], 'product_watches', true );

						} else {

							$insert_data = wp_insert_term(
								$value, 
								'product_watches'
							);

							if( ! is_wp_error( $insert_data ) ) {

								$term_id = $insert_data['term_id'];

								wp_set_post_terms( $post_id, [$term_id], 'product_watches', true );

							}

						}
					
					}

				}

			}

		}

		$update_result = [
			'status' => 'updated',
			'post_id' => $post_id
		];

		echo json_encode( $update_result );

	}

	/*
	* Insert data to DB
	*/
	public static function mxmtzc_insert_data( $_post )
	{

		$post_data = array(
			'post_title'    => sanitize_text_field( $_post['line']['model_name'] ),
			'post_content'  => $_post['line']['description'],
			'post_status'   => 'publish',
			'post_author'   => 1,
			'post_type' 	=> 'product-watches',
			'comment_status'=> 'closed'
		);

		$post_id = wp_insert_post( $post_data );

		if( intval( $post_id ) ) {

			// insert meta data
			foreach ( $_post['line'] as $key => $value ) {

				// set watch id
				if( $key == 'id' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-number_product-watches_id' );

				}

				// set watch case
				if( $key == 'case' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-clock-case_product-watches_id' );

				}

				// set watch movement
				if( $key == 'movement' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-movement_product-watches_id' );

				}

				// set watch crown
				if( $key == 'crown' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-crown_product-watches_id' );

				}

				// set watch waterproofness
				if( $key == 'waterproofness' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-waterproofness_product-watches_id' );

				}

				// set watch bezel
				if( $key == 'bezel' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-bezel_product-watches_id' );

				}

				// set watch price
				if( $key == 'price' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-price_product-watches_id' );

				}

				// set watch color
				if( $key == 'color' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-clock-color_product-watches_id' );

				}

				// set watch model_short_text
				if( $key == 'model_short_text' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-model_short_text_product-watches_id' );

				}

				// set watch model_brand
				if( $key == 'model_brand' ) {

					if( $value == '' ) {

						$value = 'Brand';

					}

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-clock_brand_product-watches_id' );

				}

				// set watch model_gender
				if( $key == 'model_gender' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-product_clock_gender_product-watches_id' );

				}

				// set watch model_label_movement
				if( $key == 'model_label_movement' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-clock_label_movement_product-watches_id' );

				}

				// set watch case_material
				if( $key == 'case_material' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-case_material_product-watches_id' );

				}

				// set watch model_glass
				if( $key == 'model_glass' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-clock_glass_product-watches_id' );

				}

				// set watch model_diameter
				if( $key == 'model_diameter' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-clock_diameter_product-watches_id' );

				}
				
				// set watch water_resistance
				if( $key == 'water_resistance' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-water_resistance_product-watches_id' );

				}

				// set watch mode_warranty
				if( $key == 'mode_warranty' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-warranty_product-watches_id' );

				}

				// set watch model_clasp
				if( $key == 'model_clasp' ) {

					self::mxmtzc_set_meta_data( $post_id, $value, '_mx_extra-metabox-clasp_product-watches_id' );

				}

				// category "model_collection"
				if( $key == 'model_collection' ) {

					if( $value !== '' ) {

						$cat = get_term_by( 'name', $value, 'product_watches' );

						if ( $cat ) {
							
							$cat_id = intval( $cat->term_id );

							wp_set_post_terms( $post_id, [$cat_id], 'product_watches', true );

						} else {

							$insert_data = wp_insert_term(
								$value, 
								'product_watches'
							);

							if( ! is_wp_error( $insert_data ) ) {

								$term_id = $insert_data['term_id'];

								wp_set_post_terms( $post_id, [$term_id], 'product_watches', true );

							}

						}

					}	

				}

				/*
				* Images upload
				*/					
				if( $key == 'id' ) {

					// set post thumbnali
					self::mxmtzc_set_post_thumbnali( $post_id, $value );

					// post metas
					self::mxmtzc_post_meta_images_upload( $post_id, $value );

				}

			}

			$create_result = [
				'status' => 'created',
				'post_id' => $post_id
			];

			echo json_encode( $create_result );

		} else {

			$create_result = [
				'status' => 'create failed',
				'post_id' => null
			];

			echo json_encode( $create_result );

		}

	}

	/*
	* Set post thumbnail
	*/
	public static function mxmtzc_set_post_thumbnali( $post_id, $image_name )
	{

		$img_url = 'http://domain.com/products/1/' . $image_name . '.png';

		$exists = mxutwfc_does_url_exists( $img_url );

		if( $exists ) {

			$img_id = mxutwfc_file_download( $img_url );

			set_post_thumbnail( $post_id, $img_id );

			return;

		}

		$img_url = 'http://domain.com/products/1/' . $image_name . '.jpg';

		$exists = mxutwfc_does_url_exists( $img_url );

		if( $exists ) {

			$img_id = mxutwfc_file_download( $img_url );

			set_post_thumbnail( $post_id, $img_id );

			return;

		}

	}

	/*
	* Images Upload
	*/
	public static function mxmtzc_post_meta_images_upload( $post_id, $image_name )
	{

		// post meta 2
		self::mxmtzc_post_meta_image_upload( $post_id, $image_name, '2', 'kd_featured-image-2_product-watches_id' );

		// post meta 3
		self::mxmtzc_post_meta_image_upload( $post_id, $image_name, '3', 'kd_featured-image-3_product-watches_id' );

		// post meta 4
		self::mxmtzc_post_meta_image_upload( $post_id, $image_name, '4', 'kd_featured-image-4_product-watches_id' );

	}

		public static function mxmtzc_post_meta_image_upload( $post_id, $image_name, $internal_folder, $meta_key )
		{

			$img_url = 'http://domain.com/products/' . $internal_folder . '/' . $image_name . '.png';

			$exists = mxutwfc_does_url_exists( $img_url );

			if( $exists ) {

				$img_id = mxutwfc_file_download( $img_url );

				add_post_meta( $post_id, $meta_key, $img_id );

				return;

			}

			$img_url = 'http://domain.com/products/' . $internal_folder . '/' . $image_name . '.jpg';

			$exists = mxutwfc_does_url_exists( $img_url );

			if( $exists ) {

				$img_id = mxutwfc_file_download( $img_url );

				add_post_meta( $post_id, $meta_key, $img_id );

				return;

			}

		}

	/*
	* Set meta data
	*/
	public static function mxmtzc_set_meta_data( $post_id, $csv_valus = '', $meta_key )
	{

		if( isset( $meta_key ) ) {

			update_post_meta( $post_id, $meta_key, $csv_valus );

		}

	}

	/*
	* Get file abspath
	*/
	public static function mxmtzc_get_file_abspath()
	{
		
		// Checked POST nonce is not empty
		if( empty( $_POST['nonce'] ) ) wp_die( '0' );

		// Checked or nonce match
		if( wp_verify_nonce( $_POST['nonce'], 'mxutwfc_nonce_request' ) ) {

			$file_abspath = get_attached_file( $_POST['file_id'] );

			$mine = mime_content_type( $file_abspath );

			$csvMimes = [
			    'text/csv',
			    'text/plain',
			    'application/csv'
			];

			if ( in_array( $mine, $csvMimes ) ) {
			
				echo $file_abspath;

			} else {

				echo 'not csv';

			}

		}

		wp_die();

	}

	/*
	* Get file data
	*/
	public static function mxmtzc_get_file_data()
	{
		
		// Checked POST nonce is not empty
		if( empty( $_POST['nonce'] ) ) wp_die( '0' );

		// Checked or nonce match
		if( wp_verify_nonce( $_POST['nonce'], 'mxutwfc_nonce_request' ) ) {

			$abspath = $_POST['file_abspath'];

			$abspath = str_replace( '\\\\', '\\', $abspath );

			$mine = mime_content_type( $abspath );

			$csvMimes = [
			    'text/csv',
			    'text/plain',
			    'application/csv'
			];

			if ( in_array( $mine, $csvMimes ) ) {

				if ( ( $handle = fopen( $abspath, "r" ) ) !== false ) {

					$key_data = fgetcsv( $handle );

					// var_dump($key_data);

					$data = [];

					for ( $i = 0; $row = fgetcsv( $handle ); $i++ ) {

						// var_dump( $row );

						$data[$i] = [];

						foreach ( $row as $key => $value ) {

							$data[$i][$key_data[$key]] = $value;

						}

					}

					echo json_encode( $data );

					fclose($handle);

				} 

			} else {

				echo 'not csv';

			}

		}

		wp_die();

	}

	
		
	
}