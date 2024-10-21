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

	    $nid_number = sanitize_text_field($_POST['nid_number']);
	    $user_name  = sanitize_text_field($_POST['user_name']);
	    $birthday   = sanitize_text_field($_POST['dm_birthday']);
	    $mobile_no  = sanitize_text_field($_POST['dm_mobile_no']);
	    $word_no    = sanitize_text_field($_POST['dm_word_no']);

	    $upozila 	= sanitize_text_field($_POST['dm_upozila']);
        $union 		= sanitize_text_field($_POST['dm_union']);

	    $attachment_id = 0;

	    if (!empty($_FILES['dm_image']['name'])) {
	        $uploaded_file = $_FILES['dm_image'];
	        $file_name = sanitize_file_name($nid_number . '-' . $uploaded_file['name']);
	        $upload_overrides = ['test_form' => false, 'unique_filename_callback' => function($dir, $name, $ext) use ($file_name) {
	            return $file_name;
	        }];

	        $upload = wp_handle_upload($uploaded_file, $upload_overrides);

	        if ($upload && !isset($upload['error'])) {
	            $attachment_data = [
	                'guid'           => $upload['url'],
	                'post_mime_type' => $upload['type'],
	                'post_title'     => sanitize_file_name($file_name),
	                'post_content'   => '',
	                'post_status'    => 'inherit',
	            ];

	            $attachment_id = wp_insert_attachment($attachment_data, $upload['file']);
	            require_once(ABSPATH . 'wp-admin/includes/image.php');
	            $attachment_metadata = wp_generate_attachment_metadata($attachment_id, $upload['file']);
	            wp_update_attachment_metadata($attachment_id, $attachment_metadata);
	        } else {
	            wp_send_json_error('Failed to upload image: ' . $upload['error']);
	        }
	    }

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
	            'attachment_id'=> $attachment_id
	        ),
	        array(
	            '%s',
	            '%s',
	            '%s',
	            '%s',
	            '%s',
	            '%s',
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

}