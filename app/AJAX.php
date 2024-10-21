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
	    $response = [
	        'status'  => 0,
	        'message' => __('Unauthorized', 'did-manager'),
	    ];

	    if (!wp_verify_nonce($_POST['_wpnonce'])) {
	        wp_send_json_success($response);
	    }

	    $current_user_id = get_current_user_id();


	    $nid_number = sanitize_text_field($_POST['nid_number']);
	    $user_name  = sanitize_text_field($_POST['user_name']);
	    $birthday   = sanitize_text_field($_POST['dm_birthday']);
	    $mobile_no  = sanitize_text_field($_POST['dm_mobile_no']);
	    $word_no    = sanitize_text_field($_POST['dm_word_no']);

	    $upozila 	= sanitize_text_field($_POST['dm_upozila']);
        $union 		= sanitize_text_field($_POST['dm_union']);


	   // Call the function for both 'dm_image' and 'dm_nid'
		$dm_image_id = handle_image_upload('dm_image', $nid_number);
		$dm_nid_id 	= handle_image_upload('dm_nid_image', $nid_number, '-nid');

	    global $wpdb;
	    $table_name = $wpdb->prefix . 'did_user_data';

	    $wpdb->insert(
	        $table_name,
	        array(
	            'nid_number'   => $nid_number,
	            'user_name'    => $user_name,
	            'birthday'     => $birthday,
	            'mobile_no'    => $mobile_no,
	            'upozila'      => $upozila,
	            'union'      	=> $union,
	            'word_no'      => $word_no,
	            'attachment_id'=> $dm_image_id,
	            'nid'			=> $dm_nid_id,
	            'created_by'	=> $current_user_id
	        ),
	        array(
	            '%s',
	            '%s',
	            '%s',
	            '%s',
	            '%s',
	            '%s',
	            '%d',
	            '%d',
	            '%d'
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
   		$table_name = $wpdb->prefix . 'did_user_data';


	    $existing_nid = $wpdb->get_var($wpdb->prepare("SELECT nid_number FROM $table_name WHERE nid_number = %s", $nid_no));

	

	    
	    if ( $existing_nid ) {
	    	wp_send_json_success(['status' => 2, 'message' => __('User already exists', 'did-manager')]);
	    }
	    else{
	    	wp_send_json_success(['status' => 1, 'message' => __('This is unique user', 'did-manager')]);
	    }

	}

	public function delete_user(){

		$response = [
	        'status'  => 0,
	        'message' => __('Unauthorized', 'did-manager'),
	    ];

	    if( ! wp_verify_nonce( $_POST['_wpnonce'] ) ) {
			wp_send_json_success( $response );
		}

		// update_option( 'test_id', $_POST['id'] );
		// return;

		$item_id = $_POST['id']; 

		global $wpdb;
	    $table_name = $wpdb->prefix . 'did_user_data';
	    $result = $wpdb->delete($table_name, array('id' => $item_id));

    

		$response = [
	        'status'  => 1,
	        'message' => __('User Deleted', 'did-manager'),
	    ];

	    if ($result) {
	       wp_send_json_success( $response );
	    } else {
	        wp_send_json_error('Could not delete the item.');
	    }

	    




	}

}