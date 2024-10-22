<?php
/**
 * All admin facing functions
 */
namespace wppluginhub\Did_Manager\App;
use WpPluginHub\Plugin\Base;
use WpPluginHub\Plugin\Metabox;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Admin
 * @author Codexpert <hi@codexpert.io>
 */
class Admin extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->server	= $this->plugin['server'];
		$this->version	= $this->plugin['Version'];
	}

	/**
	 * Internationalization
	 */
	public function i18n() {
		load_plugin_textdomain( 'did-manager', false, DID_MANAGER_DIR . '/languages/' );
	}

	/**
	 * Installer. Runs once when the plugin in activated.
	 *
	 * @since 1.0
	 */
	public function install() {

		if( ! get_option( 'did-manager_version' ) ){
			update_option( 'did-manager_version', $this->version );
		}
		
		if( ! get_option( 'did-manager_install_time' ) ){
			update_option( 'did-manager_install_time', time() );
		}

		global $wpdb;

		$table_name = $wpdb->prefix . 'did_user_data';

		if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE $table_name (
			    id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			    nid_number VARCHAR(50) NOT NULL,
			    user_name VARCHAR(100) NOT NULL,
			    birthday DATE NOT NULL,
			    mobile_no VARCHAR(20) NOT NULL,
			    created_by BIGINT(20) NOT NULL,
			    upozila VARCHAR(100) DEFAULT NULL,
			    dm_union VARCHAR(100) DEFAULT NULL,
			    word_no INT(11) DEFAULT NULL,
			    attachment_id BIGINT(20) UNSIGNED DEFAULT NULL,
			    nid BIGINT(20) UNSIGNED DEFAULT NULL,
			    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
			) $charset_collate;";

			dbDelta($sql);

		}
	}

	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts() {
		$min = defined( 'DID_MANAGER_DEBUG' ) && DID_MANAGER_DEBUG ? '' : '.min';
		
		wp_enqueue_style( $this->slug, plugins_url( "/assets/css/admin{$min}.css", DID_MANAGER ), '', $this->version, 'all' );

		wp_enqueue_script( $this->slug, plugins_url( "/assets/js/admin{$min}.js", DID_MANAGER ), [ 'jquery' ], $this->version, true );
	}

	public function footer_text( $text ) {
		if( get_current_screen()->parent_base != $this->slug ) return $text;

		return sprintf( __( 'Built with %1$s by the folks at <a href="%2$s" target="_blank">Codexpert, Inc</a>.' ), '&hearts;', 'https://codexpert.io' );
	}

	public function modal() {
		echo '
		<div id="did-manager-modal" style="display: none">
			<img id="did-manager-modal-loader" src="' . esc_attr( DID_MANAGER_ASSET . '/img/loader.gif' ) . '" />
		</div>';
	}
}