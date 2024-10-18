<?php
/**
 * All AJAX related functions
 */
namespace wppluginhub\Did_Manager\App;
use WpPluginHub\Plugin\Base;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage AJAX
 * @author Codexpert <hi@codexpert.io>
 */
class AJAX extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->version	= $this->plugin['Version'];
	}

	function handle_add_user_data() {
	    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'add_user_nonce')) {
	        wp_send_json_error('Invalid request');
	        return;
	    }


	    $nid_number = sanitize_text_field($_POST['nid_number']);
	    $user_name = sanitize_text_field($_POST['user_name']);
	    $birthday = sanitize_text_field($_POST['dm_birthday']);
	    $mobile_no = sanitize_text_field($_POST['dm_mobile_no']);
	    $village = sanitize_text_field($_POST['dm_village']);
	    $word_no = sanitize_text_field($_POST['dm_word_no']);

	   

	    $user_data = array(
	        'nid_number' => $nid_number,
	        'user_name' => $user_name,
	        'birthday' => $birthday,
	        'mobile_no' => $mobile_no,
	        'village' => $village,
	        'word_no' => $word_no
	    );
	    update_option('user_data_' . $nid_number, $user_data); 



	    if (!empty($_FILES['dm_image']['name'])) {
	        $uploaded_file = $_FILES['dm_image'];


	        $upload_dir = wp_upload_dir();
	        $custom_dir = $upload_dir['basedir'] . '/did_image'; 

	        if (!file_exists($custom_dir)) {
	            wp_mkdir_p($custom_dir); 
	        }


	        $file_name = sanitize_file_name($uploaded_file['name']);
	        $file_path = $custom_dir . '/' . $file_name;

	        if (move_uploaded_file($uploaded_file['tmp_name'], $file_path)) {
	            
	            $file_url = $upload_dir['baseurl'] . '/did_image/' . $file_name;
	            update_option('user_image_' . $nid_number, $file_url);
	        } else {
	            wp_send_json_error('Failed to upload image');
	        }
	    }

	    global $wpdb;
		$table_name = $wpdb->prefix . 'did_user_data';

		$wpdb->insert(
		    $table_name,
		    array(
		        'nid_number' => $nid_number,
		        'user_name' => $user_name,
		        'birthday' => $birthday,
		        'mobile_no' => $mobile_no,
		        'village' => $village,
		        'word_no' => $word_no,
		        'image_url' => $file_url
		    ),
		    array(
		        '%s', 
		        '%s', // user_name
		        '%s', // birthday
		        '%s', // mobile_no
		        '%s', // village
		        '%d', // word_no
		        '%s'  // image_url
		    )
		);


	    wp_send_json_success('Form data and image saved successfully');
	}


	public function check_nid(){
		$response = [
	        'status'  => 0,
	        'message' => __('Unauthorized', 'did-manager'),
	    ];

	    if( ! wp_verify_nonce( $_POST['_wpnonce'] ) ) {
			wp_send_json_success( $response );
		}

		$nid_no = isset($_POST['nid_no']) ? sanitize_text_field($_POST['nid_no']) : '';

		global $wpdb;
   		$table_name = $wpdb->prefix . 'did_user_list';


	    $existing_nid = $wpdb->get_var($wpdb->prepare("SELECT nid FROM $table_name WHERE nid = %s", $nid_no));

	

	    
	    if ( $existing_nid ) {
	    	wp_send_json_success(['status' => 2, 'message' => __('User already exists', 'did-manager')]);
	    }
	    else{
	    	wp_send_json_success(['status' => 1, 'message' => __('User added successfully', 'did-manager')]);
	    }

		

	
	}

}