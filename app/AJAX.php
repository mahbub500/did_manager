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

	public function handle_add_user(){
		$response = [
	        'status'  => 0,
	        'message' => __('Unauthorized', 'did-manager'),
	    ];

	    if( ! wp_verify_nonce( $_POST['_wpnonce'] ) ) {
			wp_send_json_success( $response );
		}

		$current_user_id = get_current_user_id();



	    $nid_number = isset($_POST['nid_number']) ? sanitize_text_field($_POST['nid_number']) : '';
	    $user_name = isset($_POST['user_name']) ? sanitize_text_field($_POST['user_name']) : '';


	    global $wpdb;
	    $table_name = $wpdb->prefix . 'did_user_list';

	    $inserted = $wpdb->insert(
	        $table_name,
	        [
	            'added_by'   => get_current_user_id(),          
	            'name'  => $user_name,                     
	            'nid'   => $nid_number,                    
	            'created_at' => current_time('mysql'),         
	        ],
	        [
	            '%d',   
	            '%s',   
	            '%s',  
	            '%s',   
	        ]
	    );

	    wp_send_json_success(['status' => 1, 'message' => __('User added successfully', 'did-manager')]);
	    
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

	

	    
	    if ($existing_nid) {
	    	wp_send_json_success(['status' => 2, 'message' => __('User already exists', 'did-manager')]);
	    }
	    else{
	    	wp_send_json_success(['status' => 1, 'message' => __('User added successfully', 'did-manager')]);
	    }

		

	
	}

}