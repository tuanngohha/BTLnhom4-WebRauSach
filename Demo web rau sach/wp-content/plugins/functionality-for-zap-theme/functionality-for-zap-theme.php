<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://cohhe.com
 * @since             1.0
 * @package           zap_func
 *
 * @wordpress-plugin
 * Plugin Name:       Functionality for Zap theme
 * Plugin URI:        http://cohhe.com/
 * Description:       This plugin contains Zap theme core functionality
 * Version:           1.2.4
 * Author:            Cohhe
 * Author URI:        http://cohhe.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       functionality-for-zap-theme
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-zap-functionality-activator.php
 */
function zap_activate_zap_func() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-zap-functionality-activator.php';
	zap_func_Activator::zap_activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-zap-functionality-deactivator.php
 */
function zap_deactivate_zap_func() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-zap-functionality-deactivator.php';
	zap_func_Deactivator::zap_deactivate();
}

register_activation_hook( __FILE__, 'zap_activate_zap_func' );
register_deactivation_hook( __FILE__, 'zap_deactivate_zap_func' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
define('ZAP_PLUGIN', plugin_dir_path( __FILE__ ));
define('ZAP_PLUGIN_URI', plugin_dir_url( __FILE__ ));
require plugin_dir_path( __FILE__ ) . 'includes/class-zap-functionality.php';

require_once plugin_dir_path( __FILE__ ) . 'includes/widgets/widget-about-author.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/widgets/widget-recent-posts-plus.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/widgets/widget-fast-flickr.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/widgets/widget-followers.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_zap_func() {

	$plugin = new zap_func();
	$plugin->zap_run();

	require plugin_dir_path( __FILE__ ) . 'includes/metaboxes/layouts.php';

}
run_zap_func();

function zap_post_category_list( $post_id, $return = false ) {
	$category_list = get_the_category_list( ', ', '', $post_id );
	$entry_utility = '';
	if ( $category_list ) {
		$entry_utility .= '
		<span class="entry-content-category">
			' . $category_list . '
		</span>';
	}

	if ( $return ) {
		return $entry_utility;
	} else {
		echo $entry_utility;
	}
}

add_action( 'init', 'zap_create_post_type' );
function zap_create_post_type() {
	// Services
	register_post_type( 'service',
		array(
		'labels' => array(
			'name' => __( 'Services', "functionality-for-zap-theme" ),
			'singular_name' => __( 'Service', "functionality-for-zap-theme" )
		),
		'taxonomies' => array('service_category'),
		'rewrite' => array('slug'=>'service','with_front'=>false),
		'public' => true,
		'has_archive' => true,
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
			'post-templates',
			'excerpt'
			)
		)
	);

	register_taxonomy( 'service_category',
		array (
			0 => 'service',
		),
		array( 
			'hierarchical' => true, 
			'label' => 'Service Categories',
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array('slug' => ''),
			'singular_label' => 'Service Category'
		) 
	);

	// Projects
	register_post_type( 'projects',
		array(
		'labels' => array(
			'name' => __( 'Projects', "functionality-for-zap-theme" ),
			'singular_name' => __( 'Project', "functionality-for-zap-theme" )
		),
		//'taxonomies' => array('event_categories'),
		'rewrite' => array('slug'=>'projects','with_front'=>false),
		'public' => true,
		'has_archive' => true,
		'supports' => array(
			'title',
			'editor',
			'revisions',
			'thumbnail',
			// 'comments',
			// 'post-templates'
			)
		)
	);

	register_taxonomy( 'project_category',
		array (
			0 => 'projects',
		),
		array( 
			'hierarchical' => true, 
			'label' => 'Project Categories',
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array('slug' => ''),
			'singular_label' => 'Project Category'
		) 
	);

	// Locations
	register_post_type( 'locations',
		array(
		'labels' => array(
			'name' => __( 'Locations', "functionality-for-zap-theme" ),
			'singular_name' => __( 'Location', "functionality-for-zap-theme" )
		),
		//'taxonomies' => array('event_categories'),
		'rewrite' => array('slug'=>'locations','with_front'=>false),
		'public' => true,
		'has_archive' => true,
		'supports' => array(
			'title',
			'editor',
			'revisions',
			'thumbnail',
			'excerpt',
			// 'comments',
			// 'post-templates'
			)
		)
	);

	register_taxonomy( 'location_category',
		array (
			0 => 'locations',
		),
		array( 
			'hierarchical' => true, 
			'label' => 'Location Categories',
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array('slug' => ''),
			'singular_label' => 'Location Category'
		) 
	);
}

function zap_project_metabox_setup() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'zap_add_project_metabox' );

	/* Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'zap_save_project_metabox', 10, 2 );
}
add_action( 'load-post.php', 'zap_project_metabox_setup' );
add_action( 'load-post-new.php', 'zap_project_metabox_setup' );

function zap_save_project_metabox( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['zap_nonce'] ) || !wp_verify_nonce( $_POST['zap_nonce'], basename( __FILE__ ) ) )
	return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
	return $post_id;

	$meta_values = array(
		'zap_construction_date',
		'zap_project_right'
		);

	foreach ($meta_values as $a_meta_value) {
		/* Get the posted data and sanitize it for use as an HTML class. */
		$new_meta_value   = ( isset( $_POST[$a_meta_value] ) ? sanitize_text_field( $_POST[$a_meta_value] ) : '' );

		/* Get the meta key. */
		$meta_key   = $a_meta_value;

		/* Get the meta value of the custom field key. */
		$meta_value   = get_post_meta( $post_id, $meta_key, true );

		/* If a new meta value was added and there was no previous value, add it. */
		if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

		/* If the new meta value does not match the old value, update it. */
		elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

		/* If there is no new meta value but an old value exists, delete it. */
		elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
	}

}

function zap_add_project_metabox() {

	add_meta_box(
		'zap_project_metabox',                                   // Unique ID
		esc_html__( 'Project info', 'vh' ),  // Title
		'zap_project_metabox_function',                          // Callback function
		'projects',                                           // Admin page (or post type)
		'normal',                                           // Context
		'high'                                              // Priority
	);

}

function zap_project_metabox_function( $object, $box ) { ?>

	<?php wp_nonce_field( basename( __FILE__ ), 'zap_nonce' ); ?>

	<p>
		<label for="zap_construction_date"><?php _e( "Construction date", 'vh' ); ?></label>
		<br />
		<input class="widefat" type="text" name="zap_construction_date" id="zap_construction_date" value="<?php echo esc_attr( get_post_meta( $object->ID, 'zap_construction_date', true ) ); ?>" size="30" />
	</p>

	<p>
		<label for="zap_project_right"><?php _e( "Project right side content", 'vh' ); ?></label>
		<br />
		<textarea class="widefat" name="zap_project_right" id="zap_project_right"><?php echo esc_attr( get_post_meta( $object->ID, 'zap_project_right', true ) ); ?></textarea>
	</p>

<?php }

function zap_location_metabox_setup() {

	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'zap_add_location_metabox' );

	/* Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'zap_save_location_metabox', 10, 2 );
}
add_action( 'load-post.php', 'zap_location_metabox_setup' );
add_action( 'load-post-new.php', 'zap_location_metabox_setup' );

function zap_save_location_metabox( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['zap_nonce'] ) || !wp_verify_nonce( $_POST['zap_nonce'], basename( __FILE__ ) ) )
	return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
	return $post_id;

	$meta_values = array(
		'zap_location_price',
		'zap_location_city',
		'zap_location_country',
		'zap_location_info',
		'zap_location_color',
		'zap_location_button_text',
		'zap_location_button_link',
		'zap_location_iframe',
		'zap_location_form',
		'zap_location_background'
		);

	foreach ($meta_values as $a_meta_value) {
		/* Get the posted data and sanitize it for use as an HTML class. */
		if ( $a_meta_value == 'zap_location_iframe' ) {
			$new_meta_value   = ( isset( $_POST[$a_meta_value] ) ? $_POST[$a_meta_value] : '' );
		} else {
			$new_meta_value   = ( isset( $_POST[$a_meta_value] ) ? sanitize_text_field( $_POST[$a_meta_value] ) : '' );
		}

		/* Get the meta key. */
		$meta_key   = $a_meta_value;

		/* Get the meta value of the custom field key. */
		$meta_value   = get_post_meta( $post_id, $meta_key, true );

		/* If a new meta value was added and there was no previous value, add it. */
		if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

		/* If the new meta value does not match the old value, update it. */
		elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

		/* If there is no new meta value but an old value exists, delete it. */
		elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
	}

}

function zap_add_location_metabox() {

	add_meta_box(
		'zap_location_metabox',                                   // Unique ID
		esc_html__( 'Location info', 'vh' ),  // Title
		'zap_location_metabox_function',                          // Callback function
		'locations',                                           // Admin page (or post type)
		'normal',                                           // Context
		'high'                                              // Priority
	);

}

function zap_location_metabox_function( $object, $box ) { ?>

	<?php wp_nonce_field( basename( __FILE__ ), 'zap_nonce' ); ?>

	<p>
		<label for="zap_location_price"><?php _e( "Location price", 'vh' ); ?></label>
		<br />
		<input class="widefat" type="text" name="zap_location_price" id="zap_location_price" value="<?php echo esc_attr( get_post_meta( $object->ID, 'zap_location_price', true ) ); ?>" size="30" />
	</p>

	<p>
		<label for="zap_location_city"><?php _e( "Location city", 'vh' ); ?></label>
		<br />
		<input class="widefat" type="text" name="zap_location_city" id="zap_location_city" value="<?php echo esc_attr( get_post_meta( $object->ID, 'zap_location_city', true ) ); ?>" size="30" />
	</p>

	<p>
		<label for="zap_location_country"><?php _e( "Location country", 'vh' ); ?></label>
		<br />
		<input class="widefat" type="text" name="zap_location_country" id="zap_location_country" value="<?php echo esc_attr( get_post_meta( $object->ID, 'zap_location_country', true ) ); ?>" size="30" />
	</p>

	<p>
		<label for="zap_location_info"><?php _e( "Location info", 'vh' ); ?></label>
		<br />
		<input class="widefat" type="text" name="zap_location_info" id="zap_location_info" value="<?php echo esc_attr( get_post_meta( $object->ID, 'zap_location_info', true ) ); ?>" size="30" />
	</p>

	<p>
		<label for="zap_location_color"><?php _e( "Location color", 'vh' ); ?></label>
		<br />
		<input class="widefat" type="text" name="zap_location_color" id="zap_location_color" value="<?php echo esc_attr( get_post_meta( $object->ID, 'zap_location_color', true ) ); ?>" size="30" />
	</p>

	<p>
		<label for="zap_location_button_text"><?php _e( "Location button text", 'vh' ); ?></label>
		<br />
		<input class="widefat" type="text" name="zap_location_button_text" id="zap_location_button_text" value="<?php echo esc_attr( get_post_meta( $object->ID, 'zap_location_button_text', true ) ); ?>" size="30" />
	</p>

	<p>
		<label for="zap_location_button_link"><?php _e( "Location button link", 'vh' ); ?></label>
		<br />
		<input class="widefat" type="text" name="zap_location_button_link" id="zap_location_button_link" value="<?php echo esc_attr( get_post_meta( $object->ID, 'zap_location_button_link', true ) ); ?>" size="30" />
		<span>External link, leave blank to link it to the location page.</span>
	</p>

	<p>
		<label for="zap_location_iframe"><?php _e( "Location map iframe", 'vh' ); ?></label>
		<br />
		<input class="widefat" type="text" name="zap_location_iframe" id="zap_location_iframe" value="<?php echo esc_attr( get_post_meta( $object->ID, 'zap_location_iframe', true ) ); ?>" size="30" />
	</p>

	<p>
		<label for="zap_location_form"><?php _e( "Location contact form ID", 'vh' ); ?></label>
		<br />
		<input class="widefat" type="text" name="zap_location_form" id="zap_location_form" value="<?php echo esc_attr( get_post_meta( $object->ID, 'zap_location_form', true ) ); ?>" size="30" />
	</p>

	<p>
		<label for="zap_location_background"><?php _e( "Location background image ID", 'vh' ); ?></label>
		<br />
		<input class="widefat" type="text" name="zap_location_background" id="zap_location_background" value="<?php echo esc_attr( get_post_meta( $object->ID, 'zap_location_background', true ) ); ?>" size="30" />
	</p>

<?php }

function zap_project_categories() {
	$output = '<div class="project-meta-item"><h5>'.__('Category', 'zap').'</h5><span class="icon-folder-open">';
	$terms = get_the_terms(get_the_ID(), 'project_category');

	if ( empty($terms) ) {
		return;
	}
	
	if ( !empty($terms) ) {
		foreach ($terms as $term_value) {
			$output .= $term_value->name.', ';
		}
		$output = rtrim($output, ', ');
	}

	$output .= '</span></div>';

	return $output;
}

function zap_project_nav() {
	$output = '<div class="project-single-nav">';
		$prev_post = get_previous_post();
		$next_post = get_next_post();

		if (!empty( $prev_post )) {
			$output .= '<a href="'. get_permalink( $prev_post->ID ).'" class="project-nav-button left icon-angle-left">'.__('Previous project', 'zap').'</a>';
		}

		if (!empty( $next_post )) {
			$output .= '<a href="'. get_permalink( $next_post->ID ).'" class="project-nav-button right icon-">'.__('Next project', 'zap').'</a>';
		}
		$output .= '
		<div class="clearfix"></div>
	</div>';

	echo $output;
}

function zap_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

function zap_service_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'id' => '',
	), $atts ) );
	$output = '';

	query_posts(array(
		'post_type' => 'service',
		'p' => $id,
	));

	if ( !have_posts() ) {
		wp_reset_query();
		wp_reset_postdata();
		return;
	}

	while(have_posts()) {
		the_post();

		$service_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');

		$output .= '<div class="service-wrapper">';
			if ( !empty($service_image['0']) ) {
				$output .= '<img src="'.$service_image['0'].'" class="service-image" alt="service-image">';
			}
			$output .= '<div class="service-title paint-area paint-area--text">' . get_the_title() . '</div>';
			$output .= '<div class="service-excerpt paint-area paint-area--text">' . get_the_excerpt() . '</div>';
			$output .= '<a href="' . get_the_permalink() . '" class="service-readmore icon-right paint-area paint-area--text">' . __('Read More', 'functionality-for-zap-theme') . '</a>';
		$output .= '</div>';
	}

	wp_reset_query();
	wp_reset_postdata();

	return $output;
}
add_shortcode('zap_service','zap_service_shortcode');

function zap_team_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'image_id' => '',
		'name'     => '',
		'title'    => '',
		'about'    => '',
		'youtube'  => '',
		'facebook' => '',
		'twitter'  => '',
		'url'      => ''
	), $atts ) );
	$output = '';
	$image = wp_get_attachment_url($image_id, 'full');

	$output .= '<div class="team-member-wrapper">';
		if ( $image ) {
			$output .= '<img src="'.$image.'" class="team-member-image" alt="Team member">';
		}
		$output .= '<div class="team-member-side">';
			if ( $name ) {
				$output .= '<span class="team-member-name paint-area paint-area--text">'.$name.'</span>';
			}
			if ( $title ) {
				$output .= '<span class="team-member-title paint-area paint-area--text">'.$title.'</span>';
			}
			if ( $youtube || $facebook || $twitter || $url ) {
				$output .= '<span class="team-member-social">';
					if ( $youtube ) {
						$output .= '<a href="'.$youtube.'" class="team-member-youtube icon-youtube-play paint-area paint-area--text"></a>';
					}
					if ( $facebook ) {
						$output .= '<a href="'.$facebook.'" class="team-member-facebook icon-facebook paint-area paint-area--text"></a>';
					}
					if ( $twitter ) {
						$output .= '<a href="'.$twitter.'" class="team-member-twitter icon-twitter paint-area paint-area--text"></a>';
					}
					if ( $url ) {
						$output .= '<a href="'.$url.'" class="team-member-url icon-plus paint-area paint-area--text"></a>';
					}
				$output .= '</span>';
			}
		$output .= '</div>';
		if ( $about ) {
			$output .= '<p class="team-member-about paint-area paint-area--text">'.$about.'</p>';
		}
	$output .= '</div>';

	return $output;
}
add_shortcode('zap_team','zap_team_shortcode');

function zap_testimonial_carousel_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'category' => '',
		'limit'    => '-1'
	), $atts ) );
	$output = '';

	query_posts(array(
		'post_type' => 'testimonial',
		'posts_per_page' => $limit,
		'easy-testimonial-category' => $category,
		'post_status' => 'publish'

	));

	if ( !have_posts() ) {
		wp_reset_query();
		wp_reset_postdata();
		return;
	}

	$output = '
	<div class="testimonial-wrapper">
		<div id="testimonial-container">';

			while(have_posts()) {
				the_post();

				$output .= '
				<div class="testimonial-item">
					<div class="testimonial-data">
						<p class="testimonial-content paint-area paint-area--text"><span class="testimonial-quote icon-quote-left"></span>'.get_the_excerpt().'</p>';
						if ( get_post_meta(get_the_ID(), '_ikcf_client', true) ) {
							$output .= '<span class="testimonial-author paint-area paint-area--text">'.get_post_meta(get_the_ID(), '_ikcf_client', true).'</span>';
						}
						if ( get_post_meta(get_the_ID(), '_ikcf_position', true) ) {
							$output .= '<span class="testimonial-company paint-area paint-area--text">'.get_post_meta(get_the_ID(), '_ikcf_position', true).'</span>';
						}
						$output .= '
					</div>
					<div class="testimonial-image">';
						$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
						if ( !empty($img['0']) ) {
							$output .= '<img src="'.$img['0'].'" class="attachment-tbtestimonial_thumbnail wp-post-image" alt="testimonial-image">';
						}
					$output .= '
					</div>
					<div class="clearfix"></div>
				</div>';
			}

	$output .= '</div><div class="testimonial-pagination"></div></div>';

	wp_reset_query();
	wp_reset_postdata();

	return $output;
}
add_shortcode('zap_testimonial_carousel','zap_testimonial_carousel_shortcode');

function zap_clients_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'clients' => ''
	), $atts ) );
	$output = '';
	$client_arr = array();
	if ( strpos($clients,'|') !== false ) {
		$client_arr['multi_column'] = true;
		$columns = explode('|', $clients);
		$column_clients = array();
		foreach ($columns as $column_value) {
			$column_clients[] = explode(',', $column_value);
		}
		$client_arr['clients'] = $column_clients;
	} else {
		$client_arr['multi_column'] = false;
		$client_arr['clients'] = explode(',', $clients);
		$count = count($client_arr['clients']);
		$width = 100/$count;
	}

	if ( !empty($client_arr) ) {
		if ( !$client_arr['multi_column'] ) {
			$output .= '<div class="client-list">';
			$output .= '<div class="client-list-row">';
			foreach ($client_arr['clients'] as $client_value) {
				$client_url = '';
				if ( strpos($client_value,'=') !== false ) {
					$client_data = explode('=', $client_value);
					$client_value = $client_data['0'];
					$client_url = $client_data['1'];
				}
				$client_logo = wp_get_attachment_url($client_value);
				$output .= '<div class="client-item" style="width: '.$width.'%">';
					if ( $client_url ) {
						$output .= '<a href="'.$client_url.'">';
					}
					$output .= '<img src="'.$client_logo.'" class="client-logo" alt="Client logo">';
					if ( $client_url ) {
						$output .= '</a>';
					}
				$output .= '</div>';
			}
			$output .= '<div class="clearfix"></div></div>';
		} else {
			$output .= '<div class="client-list multi-row">';
			$output .= '<div class="client-list-row">';
			$loop = 1;
			foreach ($client_arr['clients'] as $client_list) {
				$width = 100/count($client_list);
				foreach ($client_list as $client_value) {
					$client_url = '';
					if ( strpos($client_value,'=') !== false ) {
						$client_data = explode('=', $client_value);
						$client_value = $client_data['0'];
						$client_url = $client_data['1'];
					}
					$client_logo = wp_get_attachment_url($client_value);
					$output .= '<div class="client-item" style="width: '.$width.'%">';
						if ( $client_url ) {
							$output .= '<a href="'.$client_url.'">';
						}
						$output .= '<img src="'.$client_logo.'" class="client-logo" alt="Client logo">';
						if ( $client_url ) {
							$output .= '</a>';
						}
					$output .= '</div>';
				}
				$output .= '<div class="clearfix"></div>';
				$output .= '</div>';

				if ( count($client_arr['clients']) != $loop ) {
					$output .= '<div class="client-list-row">';
				}
				
				$loop++;
			}
			$output .= '</div>';
		}
		$output .= '</div>';
	}

	return $output;
}
add_shortcode('zap_clients','zap_clients_shortcode');

function zap_contact_form_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'address' => '',
		'contact_form' => '',
		'marker_text' => '',
		'background_color' => '#e7e7e7',
		'landscape_color' => '#2698d7',
		'road_color' => '#81d2ff',
		'highway_color' => '#8cd1f7',
		'transit_color' => '#8cd1f7',
		'water_color' => '#363636',
		'marker_image' => ZAP_PLUGIN_URI . "public//images/marker.png",
		'hue_color' => '#0076ff'
	), $atts ) );
	$output = '';

	if ( $address ) {
		$output .= '
		<div class="contact-us-wrapper wide-container">
			<div class="contact-us-left">
				<script type="text/javascript">
					function start_geolocation() {
						if (typeof google === "object" && typeof google.maps === "object") {
							var geocoder = new google.maps.Geocoder();
							var address = "' . $address . '";

							geocoder.geocode( { "address": address}, function(results, status) {

								if (status == google.maps.GeocoderStatus.OK) {
									var latitude = results[0].geometry.location.A;
									var longitude = results[0].geometry.location.F;
									initialize(results[0].geometry.location);
								} 
							});
						}
					}
					function initialize(location) {
						var mapCanvas = document.getElementById("contact-us-map");
						var myLatlng = location;
						var mapOptions = {
							center: location,
							zoom: 13,
							mapTypeId: google.maps.MapTypeId.ROADMAP,
							scrollwheel: false,
							navigationControl: false,
							mapTypeControl: false,
							scaleControl: false,
							disableDefaultUI: true,
							styles: [{"featureType":"all","elementType":"all","stylers":[{"invert_lightness":true},{"saturation":10},{"lightness":30},{"gamma":0.5},{"hue":"'.$hue_color.'"},{"weight":"0.5"}]},{"featureType":"administrative","elementType":"all","stylers":[{"color":"#ffffff"},{"visibility":"simplified"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"'.$landscape_color.'"}]},{"featureType":"poi","elementType":"labels.text","stylers":[{"color":"#fa0000"},{"visibility":"off"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"on"},{"color":"'.$road_color.'"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"color":"'.$highway_color.'"},{"weight":"0.50"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"visibility":"on"},{"color":"'.$transit_color.'"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"'.$water_color.'"}]}]
						}
						var map = new google.maps.Map(mapCanvas, mapOptions);

						map.panBy(150, -100);

						var contentString = "' . trim(preg_replace('/\s+/', ' ', $marker_text)) . '";

						var marker = new google.maps.Marker({
							position: myLatlng,
							map: map,
							icon: {
								url: "'.$marker_image.'",
								origin: new google.maps.Point(0, 0),
								anchor: new google.maps.Point(35, 65)
						    },
						    title: "' . $address . '"
						});

						if ( contentString != "" ) {
							var infowindow = new google.maps.InfoWindow({
								content: contentString
							});

							marker.addListener("click", function() {
								infowindow.open(map, marker);
							});
						}
					}
					jQuery(window).ready(function() {
						start_geolocation();
					});
				</script>
				<div id="contact-us-map"></div>
			</div>
			<div class="contact-us-right">
				<style type="text/css">
				.contact-us-right {background-color: '.$background_color.';}
				.contact-us-right:before {border-right-color: '.$background_color.';}
				.contact-us-right:after {background: '.$background_color.';}
				</style>
				<h2>'.__('Have a Question?', 'functionality-for-zap-theme').'</h2>';
				if ( $contact_form ) {
					$output .= do_shortcode('[contact-form-7 id="'.$contact_form.'"]');
				} else {
					$output .= 'Contact form 7 ID isn\'t provided';
				}
			$output .= '</div>
		</div>';
	}

	return $output;
}
add_shortcode('zap_contact_form','zap_contact_form_shortcode');

function zap_info_box_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'main_title' => '',
		'secondary_title' => '',
		'short_desc' => '',
		'icon' => '',
		'secondary_desc' => '',
		'button_text' => '',
		'button_link' => '',
		'background_color' => '',
		'background_image' => '',
		'button_color' => ''
	), $atts ) );
	$output = '';
	$background_style = ' style="';

	if ( $background_color ) {
		$background_style .= 'background-color: '.$background_color.';';
	}

	if ( $background_image ) {
		$background_style .= 'background: url('.$background_image.') no-repeat; background-size: cover; background-position: center;';
	}

	$unique_id = rand();

	$background_style .= '"';

	$output .= '<div class="info-box-container id-'.$unique_id.'"'.$background_style.'>';
		if ( $button_color ) {
			$output .= '<style type="text/css">#main .id-'.$unique_id.' .info-box-link { background: '.$button_color.'; } #main .id-'.$unique_id.' .info-box-link:hover { background: #fff; color: '.$button_color.'; }</style>';
		}
		$output .= '<div class="info-box-front">';
			$output .= '<h2 class="info-box-main-title">'.$main_title.'</h2>';
			$output .= '<h4 class="info-box-secondary-title">'.$secondary_title.'</h4>';
			$output .= '<p class="info-box-short-desc">'.$short_desc.'</p>';
		$output .= '</div>';
		$output .= '<div class="info-box-secondary">';
			$output .= '<span class="info-box-icon '.$icon.'"></span>';
			$output .= '<p class="info-box-secondary-desc">'.$secondary_desc.'</p>';
			$output .= '<a href="'.$button_link.'" class="info-box-link">'.$button_text.'</a>';
		$output .= '</div>';
	$output .= '</div>';

	return $output;
}
add_shortcode('zap_info_box','zap_info_box_shortcode');

function zap_latest_news_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'category' => '',
		'limit'    => '-1',
		'type'     => ''
	), $atts ) );
	$output = '';

	$query_atts = array(
		'post_type' => 'post',
		'posts_per_page' => $limit,
		'category_name' => $category,
		'post_status' => 'publish',
		'ignore_sticky_posts' => 1
	);



	query_posts($query_atts);

	if ( !have_posts() ) {
		wp_reset_query();
		wp_reset_postdata();
		return;
	}

	if ( $type != 'fullwidth' ) {
		$output = '
		<script type="text/javascript">
		jQuery(document).ready(function($) {
			jQuery(".latest-news-wrapper").on("jcarousel:create", function(event, carousel) {
				var item_width = jQuery(".latest-news-wrapper").width()/3-30;
				jQuery(".latest-news-wrapper .latest-news-item").width(item_width);
			}).on("jcarousel:scroll", function(event, carousel) {
				jQuery("#latest-news-container").hide().stop().fadeIn(700);
			}).jcarousel({
				wrap: "circular",
				animation: {
					duration: 0
				}
			});

			jQuery(".latest-news-pagination").on("jcarouselpagination:create", function(carousel) {
				jQuery(carousel.target).find("a:first-child").addClass("active");
			}).on("jcarouselpagination:active", "a", function() {
				jQuery(this).addClass("active");
			}).on("jcarouselpagination:inactive", "a", function() {
				jQuery(this).removeClass("active");
			}).jcarouselPagination({
				"carousel": jQuery(".latest-news-wrapper"),
				"perPage": 3
			});
		});
		jQuery(window).load(function() {
			jQuery(".latest-news-item").each(function() {
				var item_image = jQuery(this).find("div.latest-news-image").outerHeight();
				var item_title = jQuery(this).find(".latest-news-title").outerHeight()+39;
				var item_category = jQuery(this).find(".entry-content-category").outerHeight();

				var max_item_height = 460-item_image-item_title-item_category-3;
				jQuery(this).find(".latest-news-excerpt").dotdotdot({ height: max_item_height });
			});
		});
		</script>';
	}

	$output .= '
	<div class="latest-news-wrapper '.$type.'">
		<div id="latest-news-container">';

			while(have_posts()) {
				the_post();

				$output .= '
				<div class="latest-news-item">';
						if ( $type != 'fullwidth' ) {
							$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'zap-medium-thumbnail');
						} else {
							$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'zap-thumbnail-large');
						}
						if ( !empty($img['0']) ) {
							if ( $type != 'fullwidth' ) {
								$output .= '
								<div class="latest-news-image not-single-post">
									<a href="'.get_the_permalink().'"><img src="'.$img['0'].'" class="latest-news-image" alt="Latest news image"></a>
									<span class="single-post-date icon-clock">4 months ago</span>
								</div>';
							} else {
								$output .= '<div class="latest-news-image" style="background: url('.$img['0'].') no-repeat; background-size: cover; background-position: center; height: 315px;">';
									$output .= '<div class="latest-news-overlay"><div class="latest-news-overlay-inner">';
										$output .= '<a href="'.get_the_permalink().'" class="latest-news-title">'.get_the_title().'</a>';
										$output .= '<span class="latest-news-date icon-calendar">'.get_the_date( get_option( 'date_format' ), get_the_ID() ).'</span>';
										$tc = wp_count_comments( get_the_ID() );
										
										$output .= '<span class="latest-news-comments icon-comment-empty">' . $tc->approved  . '</span>';
									$output .= '</div></div>';
								$output .= '</div>';
							}
						}
					if ( $type != 'fullwidth' ) {
						$output .= '<a href="'.get_the_permalink().'" class="latest-news-title">'.get_the_title().'</a>';
						$output .= '<p class="latest-news-excerpt">'.get_the_excerpt().'</p>';
						$output .= zap_post_category_list( get_the_ID(), true );
					}
				$output .= '</div>';
			}

	$output .= '</div><div class="latest-news-pagination"></div></div>';

	wp_reset_query();
	wp_reset_postdata();

	return $output;
}
add_shortcode('zap_latest_news','zap_latest_news_shortcode');

function zap_projects_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'categories' => '',
		'limit'    => '-1'
	), $atts ) );
	$output = '';

	if ( $categories != '' ) {
		$categories = 'all-projects,'.$categories;
	}

	$categories_arr = explode(',', $categories);
	if ( !empty($categories_arr) ) {

		$output .= '<div class="projects-container">';

		$output .= '
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				if ( jQuery(".project-row-inner").children().length > 4 ) {
					jQuery(".project-row.carousel-active").on("jcarousel:create", function(event, carousel) {
						var item_width = jQuery(".project-row.carousel-active").width()/4-23;
						jQuery(".project-row.carousel-active .project-item").width(item_width);
					}).on("jcarousel:scroll", function(event, carousel) {
						// jQuery("#latest-news-container").hide().stop().fadeIn(700);
					}).jcarousel({
						wrap: "circular",
						// animation: {
						// 	duration: 0
						// }
					});

					jQuery(document).on("click", ".project-navigation-right", function() {
						jQuery(".project-row.carousel-active.project-visible").jcarousel("scroll", "+=4");
					});
					jQuery(document).on("click", ".project-navigation-left", function() {
						jQuery(".project-row.carousel-active.project-visible").jcarousel("scroll", "-=4");
					});
				}
			});
		</script>';

		$output .= '<div class="projects-categories">';
			foreach ($categories_arr as $cat_key => $cat_value) {
				$extra_class = '';
				if ( $cat_key == 0 ) {
					$extra_class = ' active';
				}
				if ( $cat_value == 'all-projects' ) {
					$project_name = __('All Projects', 'functionality-for-zap-theme');
				} else {
					$project_name = $cat_value;
				}
				$output .= '<a href="javascript:void(0)" class="project-category'.$extra_class.'" data-category="'.$cat_value.'">'.$project_name.'</a>';
			}
		$output .= '</div>';

		$output .= '<div class="project-navigation"><a href="javascript:void(0)" class="project-navigation-left icon-angle-left"></a><a href="javascript:void(0)" class="project-navigation-right icon-angle-right"></a></div>';

		$output .= '<div class="project-rows">';

			foreach ($categories_arr as $cat_key => $cat_value) {
				if ( $cat_value == 'all-projects' ) {
					$project_cat = '';
				} else {
					$project_cat = $cat_value;
				}
				$query_atts = array(
					'post_type' => 'projects',
					'posts_per_page' => $limit,
					'project_category' => $project_cat,
					'post_status' => 'publish',
					'ignore_sticky_posts' => 1
				);

				$project_query = query_posts($query_atts);

				if ( !have_posts() ) {
					wp_reset_query();
					wp_reset_postdata();
					return;
				}

				$extra_class = '';
				if ( $cat_key == 0 ) {
					$extra_class = ' project-visible';
				}

				if ( count($project_query) > 4 ) {
					$extra_class .= ' carousel-active';
				}

				$output .= '<div class="project-row category-'.$cat_value.$extra_class.'"><div class="project-row-inner">';

				while(have_posts()) {
					the_post();

					$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'zap-medium-thumbnail');

					$output .= '<div class="project-item">';
						$output .= '<div class="project-item-container">';
							$output .= '<a href="'.get_the_permalink().'">';
								if ( !empty($img['0']) ) {
									$output .= '<div class="project-item-image">';
										$output .= '<img src="'.$img['0'].'" alt="">';
									$output .= '</div>';
								}
								$output .= '<div class="project-item-inner">';
									$output .= '<span class="project-item-title">'.get_the_title().'</span>';
									$output .= '<span class="project-item-date">'.get_the_date( get_option( 'date_format' ), get_the_ID() ).'</span>';
								$output .= '</div>';
							$output .= '</a>';
						$output .= '</div>';
					$output .= '</div>';
				}

				$output .= '</div></div>';

				wp_reset_query();
				wp_reset_postdata();
			}

		$output .= '</div>';

		$output .= '</div>';
	}

	return $output;
}
add_shortcode('zap_projects','zap_projects_shortcode');

function zap_locations_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'categories' => '',
		'limit'    => '-1',
		'type' => ''
	), $atts ) );
	$output = '';

	$query_atts = array(
		'post_type' => 'locations',
		'posts_per_page' => $limit,
		'project_category' => $categories,
		'post_status' => 'publish',
		'ignore_sticky_posts' => 1
	);

	$location_query = query_posts($query_atts);

	if ( !have_posts() ) {
		wp_reset_query();
		wp_reset_postdata();
		return;
	}

	$output .= '<div class="locations-container '.$type.'">';

	$output .= '<div class="locations-dialog-container"></div>';

	$output .= '
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			// jQuery(document).on("click", ".location-map-button, .location-booking-button", function() {
			// 	var current_dialog_parent = jQuery(this).parent();
			// 	jQuery(this).parent().find(".location-dialog").dialog({
			// 		dialogClass: "location-map-dialog-box",
			// 		draggable: false,
			// 		modal: true,
			// 		close: function () {
			// 			if ( current_dialog_parent.hasClass("location-booking-container") ) {
			// 				var dialog_title = "'.__('Book this travel', 'zap').'";
			// 			} else {
			// 				var dialog_title = "'.__('Take a closer look', 'zap').'";
			// 			}
			// 			current_dialog_parent.append(jQuery(jQuery(this).prop("outerHTML")).attr("style", "").attr("id", "").attr("title", dialog_title));
			// 		},
			// 		width: "400px",
			// 		minHeight: "500px",
			// 		resizable: false
			// 	});
			// });
			jQuery(document).on("click", ".location-map-button, .location-booking-button", function() {
				jQuery(this).parent().addClass("dialog-visible");
				jQuery("body").addClass("dialog-overlay");
			});
			jQuery(document).on("click", ".location-item .location-item-image", function() {
				window.location = jQuery(this).find(".location-read-more").attr("href");
			});
			jQuery(document).on("click", ".location-dialog-close", function() {
				jQuery(this).parent().parent().parent().removeClass("dialog-visible");
				jQuery("body").removeClass("dialog-overlay");
			});
		});
	</script>';

	while(have_posts()) {
		the_post();

		$location_price = get_post_meta( get_the_ID(), 'zap_location_price', true );
		$location_city = get_post_meta( get_the_ID(), 'zap_location_city', true );
		$location_country = get_post_meta( get_the_ID(), 'zap_location_country', true );
		$location_info = get_post_meta( get_the_ID(), 'zap_location_info', true );
		$location_color = get_post_meta( get_the_ID(), 'zap_location_color', true );
		$location_button_text = get_post_meta( get_the_ID(), 'zap_location_button_text', true );
		$location_button_link = get_post_meta( get_the_ID(), 'zap_location_button_link', true );
		$location_button_iframe = get_post_meta( get_the_ID(), 'zap_location_iframe', true );
		$location_button_form = get_post_meta( get_the_ID(), 'zap_location_form', true );
		$background_style = '';
		if ( $location_color ) {
			$background_style .= ' style="background-color: '.$location_color.';"';
		}
		if ( !$location_button_link ) {
			$location_button_link = get_the_permalink();
		}
		if ( !$location_button_text ) {
			$location_button_text = 'Details';
		}

		$output .= '<div class="location-item">';
			$output .= '<div class="location-item-inner">';
				$output .= '<div class="location-item-image">';
					$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'zap-medium-thumbnail');
					if ( !empty($img['0']) ) {
						$output .= '<img src="'.$img['0'].'" alt="">';
					}
					if ( $location_price ) {
						$output .= '<span class="location-item-price">'.$location_price.'</span>';
					}
					$output .= '<a href="'.$location_button_link.'" class="location-read-more">'.$location_button_text.'</a>';
				$output .= '</div>';
				if ( $location_city ) {
					$output .= '<span class="location-item-city">'.$location_city.'</span>';
				}
				if ( $location_country ) {
					$output .= '<span class="location-item-country icon-direction"'.$background_style.'>'.$location_country.'</span>';
				}
				if ( $location_info ) {
					$output .= '<span class="location-item-info icon-info"'.$background_style.'>'.$location_info.'</span>';
				}
				$output .= '<div class="clearfix"></div>';
				if ( $type != 'tumbnails' ) {
					$output .= '<div class="location-item-lower">';
						$output .= get_the_excerpt();
						$output .= '<div class="clearfix"></div>';
						$output .= '<a href="'.$location_button_link.'" class="location-read-more">'.$location_button_text.'</a>';
						if ( $location_button_iframe ) {
							$output .= '<div class="location-map-container">';
								$output .= '<a href="javascript:void(0)" class="location-map-button icon-location"></a>';
								$output .= '
								<div class="location-dialog">
									<div class="location-dialog-title">'.__('Take a closer look', 'zap').'<span class="location-dialog-close icon-cancel"></span></div>
									'.$location_button_iframe.'
								</div>';
							$output .= '</div>';
						}
						if ( $location_button_form ) {
							$output .= '<div class="location-booking-container">';
								$output .= '<a href="javascript:void(0)" class="location-booking-button icon-mail-alt"></a>';
								$output .= '
								<div class="location-dialog">
									<div class="location-dialog-title">'.__('Book this travel', 'zap').'<span class="location-dialog-close icon-cancel"></span></div>
									'.do_shortcode('[contact-form-7 id="'.$location_button_form.'"]').'
								</div>';
							$output .= '</div>';
						}
					$output .= '</div>';
				}
			$output .= '</div>';
		$output .= '</div>';
	}

	$output .= '<div class="clearfix"></div>';
			
	$output .= '</div>';

	wp_reset_query();
	wp_reset_postdata();

	return $output;
}
add_shortcode('zap_locations','zap_locations_shortcode');

function zap_locations_infobox_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'icon' => '',
		'title' => '',
		'content' => ''
	), $atts ) );

	$output = '<div class="zip-location-infobox-container">';
		$output .= '<span class="location-infobox-icon '.$icon.'"></span>';
		$output .= '<span class="location-infobox-title">'.$title.'</span>';
		$output .= '<span class="location-infobox-content">'.$content.'</span>';
	$output .= '</div>';

	return $output;
}
add_shortcode('zap_locations_infobox','zap_locations_infobox_shortcode');

function zap_locations_included_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'icon' => '',
		'title' => '',
		'included' => '',
		'inluce_bg' => '#1BBC9B'
	), $atts ) );

	$unique = rand();

	$output = '<div class="zip-location-included-container id-'.$unique.'">';
		$output .= '<style type="text/css">.zip-location-included-container.id-'.$unique.' .location-included-status { background-color: '.$inluce_bg.'; }.zip-location-included-container.id-'.$unique.' .location-included-status:before { border-right-color: '.$inluce_bg.'; }</style>';
		$output .= '<span class="location-included-icon '.$icon.'"></span>';
		$output .= '<span class="location-included-title">'.$title.'</span>';
		$output .= '<span class="location-included-status">'.$included.'</span>';
	$output .= '</div>';

	return $output;
}
add_shortcode('zap_locations_included','zap_locations_included_shortcode');

function zap_gap_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'height' => ''
	), $atts ) );

	$output = '<div class="zip-gap" style="height: '.$height.'px;"></div>';

	return $output;
}
add_shortcode('zap_gap','zap_gap_shortcode');

function zap_share_icons() {
	$output = '<div class="single-open-post-share">
	<span class="share-text">'.__('Share', 'zap').'</span>';
	$output .= '<a href="http://www.facebook.com/sharer.php?u=' . get_permalink() . '" class="social-icon icon-facebook" target="_blank"></a>';
	$output .= '<a href="http://twitter.com/share?url=' . get_permalink() . '&amp;text=' . urlencode( get_the_title() ) . '" class="social-icon icon-twitter" target="_blank"></a>';
	$output .= '<a href="https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode( get_the_permalink() ) . '&title=' . urlencode( get_the_title() ) . '" class="single-share-linkedin icon-linkedin"></a>';
	$output .= '<a href="http://tumblr.com/widgets/share/tool?canonicalUrl=' . urlencode( get_the_permalink() ) . '" class="single-share-tumblr icon-tumblr"></a>';
	$output .= '<a href="https://plus.google.com/share?url=' . get_permalink() . '" class="social-icon icon-gplus" target="_blank"></a>';
	$output .= "<a href=\"javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','//assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());\" class=\"social-icon icon-pinterest\" target=\"_blank\"></a>";
	$output .= '</div>';

	echo $output;
}

function remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
add_filter( 'the_content_more_link', 'remove_more_link_scroll' );

function zap_get_social_icons() {
	$facebook = get_theme_mod('zap_headerfacebook', '');
	$youtube = get_theme_mod('zap_headeryoutube', '');
	$twitter = get_theme_mod('zap_headertwitter', '');
	$gplus = get_theme_mod('zap_headergplus', '');
	$output = '';
	$count = 1;
	$class = 'count-';

	if ( $facebook != '' || $youtube != '' || $twitter != '' || $gplus != '' ) {
		$output .= '
		<div class="header-share-icons">
			<a href="javascript:void(0)" class="header-share icon-share"></a>
			<div class="header-icon-wrapper">';
				if ( $facebook != '' ) {
					$output .= '<a href="' . esc_url($facebook) . '" class="header-social ' . $class . $count . ' icon-facebook"></a>';
					$count++;
				}

				if ( $youtube != '' ) {
					$output .= '<a href="' . esc_url($youtube) . '" class="header-social ' . $class . $count . ' icon-youtube-play"></a>';
					$count++;
				}

				if ( $twitter != '' ) {
					$output .= '<a href="' . esc_url($twitter) . '" class="header-social ' . $class . $count . ' icon-twitter"></a>';
					$count++;
				}

				if ( $gplus != '' ) {
					$output .= '<a href="' . esc_url($gplus) . '" class="header-social ' . $class . $count . ' icon-gplus"></a>';
					$count++;
				}
			
		$output .= '<div class="clearfix"></div></div></div>';
	}

	return $output;
}

function zap_single_social_icons() {
	echo '<div class="single-post-share">
		<a href="http://www.facebook.com/sharer.php?u=' . urlencode( get_the_permalink() ) . '" class="single-share-facebook icon-facebook"></a>
		<a href="http://twitter.com/share?url=' . urlencode( get_the_permalink() ) . '&amp;text=' . urlencode( get_the_title() ) . '" class="single-share-twitter icon-twitter"></a>
		<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=' . urlencode( get_the_permalink() ) . '&title=' . urlencode( get_the_title() ) . '" class="single-share-linkedin icon-linkedin"></a>
		<a href="http://tumblr.com/widgets/share/tool?canonicalUrl=' . urlencode( get_the_permalink() ) . '" class="single-share-tumblr icon-tumblr"></a>
	</div>';
}

function zap_like_button() {
	$post_id = get_the_ID();
	global $wpdb;
	$old_like_table = $wpdb->prefix.'like_dislike_counters';
	$current_like_value = get_post_meta( $post_id, 'zap_post_likes', true );
	if ( function_exists('ldc_like_counter_p') && $wpdb->get_var("SHOW TABLES LIKE '$old_like_table'") == $old_like_table && $current_like_value == '' ) { // Old values exist, so save them into the post meta
		$old_like_values = $wpdb->get_results("SELECT * FROM $old_like_table");
		if ( !empty($old_like_values) ) {
			foreach ($old_like_values as $like_values) {
				update_post_meta( $post_id, 'zap_post_likes', $like_values->ul_value );
			}
		}
	}

	if ( intval($current_like_value) == 0 ) {
		$output = "<span class='single-post-like icon-heart-empty' data-id='".$post_id."'><span>".$current_like_value."</span></span>";;
	} else {
		$output = "<span class='single-post-like icon-heart-1' data-id='".$post_id."'><span>".$current_like_value."</span></span>";;
	}

	return $output;
}

function zap_update_post_likes() {
	$post_id = ( isset($_POST['zap_post_id']) ? intval($_POST['zap_post_id']) : '' );
	$current_likes = get_post_meta( $post_id, 'zap_post_likes', true );

	if ( !isset($_COOKIE['zap-liked-'.$post_id]) ) {
		$new_like_count = $current_likes+1;
		update_post_meta( $post_id, 'zap_post_likes', $new_like_count );
	} else {
		$new_like_count = $current_likes;
	}

	echo $new_like_count;
	die(0);
}
add_action( 'wp_ajax_zap_listing_like', 'zap_update_post_likes' );
add_action( 'wp_ajax_nopriv_zap_listing_like', 'zap_update_post_likes' );

function zap_allowed_tags() {
	global $allowedposttags;
	$allowedposttags['script'] = array(
		'type' => true,
		'src' => true
	);
}
add_action( 'init', 'zap_allowed_tags' );

function zap_customizer_register( $wp_customize ) {
	// Header facebook
	$wp_customize->add_section( 'zap_header_facebook', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Facebook URL' , 'zap'),
		'description'    => __( 'Facebook URL for your header social icon.' , 'zap'),
		'panel'          => 'zap_header_panel'
	) );

	$wp_customize->add_setting( 'zap_headerfacebook', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'zap_headerfacebook',
		array(
			'label'      => 'Facebook URL',
			'section'    => 'zap_header_facebook',
			'type'       => 'text',
		)
	);

	// Header youtube
	$wp_customize->add_section( 'zap_header_youtube', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'YouTube URL' , 'zap'),
		'description'    => __( 'YouTube URL for your header social icon.' , 'zap'),
		'panel'          => 'zap_header_panel'
	) );

	$wp_customize->add_setting( 'zap_headeryoutube', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'zap_headeryoutube',
		array(
			'label'      => 'YouTube URL',
			'section'    => 'zap_header_youtube',
			'type'       => 'text',
		)
	);

	// Header twitter
	$wp_customize->add_section( 'zap_header_twitter', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Twitter URL' , 'zap'),
		'description'    => __( 'Twitter URL for your header social icon.' , 'zap'),
		'panel'          => 'zap_header_panel'
	) );

	$wp_customize->add_setting( 'zap_headertwitter', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'zap_headertwitter',
		array(
			'label'      => 'Twitter URL',
			'section'    => 'zap_header_twitter',
			'type'       => 'text',
		)
	);

	// Header google plus
	$wp_customize->add_section( 'zap_header_gplus', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Google+ URL' , 'zap'),
		'description'    => __( 'Google+ URL for your header social icon.' , 'zap'),
		'panel'          => 'zap_header_panel'
	) );

	$wp_customize->add_setting( 'zap_headergplus', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'zap_headergplus',
		array(
			'label'      => 'Google+ URL',
			'section'    => 'zap_header_gplus',
			'type'       => 'text',
		)
	);

	// Google maps key
	$wp_customize->add_section( 'zap_google_maps_key', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Google maps key' , 'zap'),
		'description'    => __( 'Google maps API key so theme can use Google maps API.' , 'zap'),
		'panel'          => 'zap_general_panel'
	) );

	$wp_customize->add_setting( 'zap_gmap_key', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'zap_gmap_key',
		array(
			'label'      => 'Google maps key',
			'section'    => 'zap_google_maps_key',
			'type'       => 'text',
		)
	);
}
add_action( 'customize_register', 'zap_customizer_register' );