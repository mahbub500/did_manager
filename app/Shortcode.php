<?php
/**
 * All Shortcode related functions
 */
namespace Codexpert\Did_Manager\App;
use WpPluginHub\Plugin\Base;
use Codexpert\Did_Manager\Helper;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * @package Plugin
 * @subpackage Shortcode
 * @author Codexpert <hi@codexpert.io>
 */
class Shortcode extends Base {

    public $plugin;

    /**
     * Constructor function
     */
    public function __construct( $plugin ) {
        $this->plugin   = $plugin;
        $this->slug     = $this->plugin['TextDomain'];
        $this->name     = $this->plugin['Name'];
        $this->version  = $this->plugin['Version'];
    }

    public function did_manager() {
        return __( 'My Shortcode', 'did-manager' );
    }
}