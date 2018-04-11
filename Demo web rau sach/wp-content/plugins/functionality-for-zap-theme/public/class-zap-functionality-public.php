<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    zap_func
 * @subpackage zap_func/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    zap_func
 * @subpackage zap_func/public
 * @author     Your Name <email@example.com>
 */
class zap_func_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $zap_func    The ID of this plugin.
	 */
	private $zap_func;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $zap_func       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $zap_func, $version ) {

		$this->zap_func = $zap_func;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in zap_func_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The zap_func_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->zap_func, plugin_dir_url( __FILE__ ) . 'css/zap-functionality-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in zap_func_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The zap_func_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_style( 'wp-jquery-ui-dialog' );

		wp_enqueue_script( 'js.cookie', plugin_dir_url( __FILE__ ) . 'js/js.cookie.js', array( 'jquery' ), '', false );
		wp_enqueue_script( $this->zap_func, plugin_dir_url( __FILE__ ) . 'js/zap-functionality-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->zap_func, 'zap_main', array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		));
		
		wp_enqueue_script( 'dotdotdot', plugin_dir_url( __FILE__ ) . 'js/jquery.dotdotdot.min.js', array( 'jquery' ), $this->version, false );

		$googlemaps_key = get_theme_mod('zap_gmap_key', '');
		if ( $googlemaps_key ) {
			wp_enqueue_script('googlemap', '//maps.googleapis.com/maps/api/js?key='.$googlemaps_key, array(), '3', false);
		}

	}

}
