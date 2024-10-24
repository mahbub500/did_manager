<?php
/**
 * All public facing functions
 */
namespace wppluginhub\Did_Manager\App;
use WpPluginHub\Plugin\Base;
use wppluginhub\Did_Manager\Helper;
/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Front
 * @author Codexpert <hi@codexpert.io>
 */
class Front extends Base {

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

	public function head() {
		
	}
	
	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts() {
		$min = defined( 'DID_MANAGER_DEBUG' ) && DID_MANAGER_DEBUG ? '' : '.min';

		// Enqueue main plugin styles and scripts
		wp_enqueue_style( $this->slug, plugins_url( "/assets/css/front{$min}.css", DID_MANAGER ), '', $this->version, 'all' );

		// Enqueue Bootstrap CSS
		wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css', [], '4.6.2', 'all');

		// Enqueue plugin's JavaScript
		wp_enqueue_script( $this->slug, plugins_url( "/assets/js/front{$min}.js", DID_MANAGER ), [ 'jquery' ], $this->version, true );

		// Enqueue Bootstrap JS
		wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js', ['jquery'], '4.6.2', true);

		// Enqueue DataTables CSS and JS
		wp_enqueue_style( 'data-table', 'https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css', '', $this->version, 'all' );
		wp_enqueue_script( 'data-table', 'https://cdn.datatables.net/2.1.8/js/dataTables.min.js', [ 'jquery' ], $this->version, true );

		// Localize script with ajax URL and nonce
		$localized = [
			'ajaxurl'	=> admin_url( 'admin-ajax.php' ),
			'_wpnonce'	=> wp_create_nonce(),
		];
		wp_localize_script( $this->slug, 'DID_MANAGER', apply_filters( "{$this->slug}-localized", $localized ) );
	}


	public function modal() {
		echo '
		<div id="did-manager-modal" style="display: none">
			<img id="did-manager-modal-loader" src="' . esc_attr( DID_MANAGER_ASSET . '/img/loader.gif' ) . '" />
		</div>';
	}
}