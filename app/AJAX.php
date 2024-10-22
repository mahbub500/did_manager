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


	public function delete_user() {
	    // Initial unauthorized response
	    $response = [
	        'status'  => 0,
	        'message' => __('Unauthorized', 'did-manager'),
	    ];

	    // Verify nonce for security
	    if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'] ) ) {
	        wp_send_json_error( $response );
	    }

	    // Get the user ID from POST data
	    $item_id = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;

	    if ( !$item_id ) {
	        wp_send_json_error( __('Invalid ID', 'did-manager') );
	    }

	    global $wpdb;
	    $table_name = $wpdb->prefix . 'did_user_data';

	    // Fetch attachment data before deleting the user record
	    $attachment_data = $wpdb->get_results(
	        $wpdb->prepare(
	            "SELECT attachment_id, nid FROM $table_name WHERE id = %d", 
	            $item_id
	        ),
	        ARRAY_A
	    );

	    // Delete the user record from the custom table
	    $result = $wpdb->delete($table_name, array('id' => $item_id));

	    // Check if the delete operation was successful
	    if ($result) {
	        // Delete attachments if they exist
	        if ( !empty($attachment_data) ) {
	            foreach ($attachment_data[0] as $data) {
	                wp_delete_attachment($data, true);
	            
	            }
	        }

	        // Successful response
	        $response = [
	            'status'  => 1,
	            'message' => __('User and attachments deleted', 'did-manager'),
	        ];
	        wp_send_json_success( $response );
	    } else {
	        // Failed response
	        wp_send_json_error( __('Could not delete the user.', 'did-manager') );
	    }
	}

	function get_user_data() {
	    if ( !isset($_POST['user_id']) || !is_numeric($_POST['user_id']) ) {
	        wp_send_json_error('Invalid user ID.');
	    }

	    $user_id = intval($_POST['user_id']);
	    
	    global $wpdb;
	    $table_name = $wpdb->prefix . 'did_user_data';  // Your custom table name

	    // Fetch the user data
	    $user_data = $wpdb->get_row(
	        $wpdb->prepare(
	            "SELECT nid_number, user_name FROM $table_name WHERE id = %d",
	            $user_id
	        )
	    );

	    if ( ! $user_data ) {
	        wp_send_json_error('User not found.');
	    }

	    // Send the user data back to the front-end
	    wp_send_json_success( array(
	        'nid'  => $user_data->nid_number,
	        'name' => $user_data->user_name
	    ));
	}




}