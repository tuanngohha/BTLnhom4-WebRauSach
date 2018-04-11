<?php
// Creating the widget 
class wpb_widget_followers extends WP_Widget {

	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'zap-directory-followers', 

			// Widget name will appear in UI
			__('Zap - Followers', 'functionality-for-zap-theme'), 

			// Widget description
			array( 'description' => __( 'Just a simple widget that displays social icons with follower count.', 'functionality-for-zap-theme' ), ) 
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		global $post, $wpdb, $wp_query;
		$maintitle      = $instance['maintitle'];
		$facebook_username = $instance['facebook_username'];
		$twitter_username = $instance['twitter_username'];
		$googleplus_username = $instance['googleplus_username'];
		$googleplus_api = $instance['googleplus_api'];
		$youtube_username = $instance['youtube_username'];
		$youtube_api = $instance['youtube_api'];
		$twitter_consumer_key = $instance['twitter_consumer_key'];
		$twitter_consumer_secret = $instance['twitter_consumer_secret'];
		$twitter_user_token = $instance['twitter_user_token'];
		$twitter_user_secret = $instance['twitter_user_secret'];
		$vimeo_username = $instance['vimeo_username'];
		$vimeo_access_token = $instance['vimeo_access_token'];
		$soundcloud_username = $instance['soundcloud_username'];
		$soundcloud_client_id = $instance['soundcloud_client_id'];
		$instagram_username = $instance['instagram_username'];
		$instagram_token = $instance['instagram_token'];
		$rss_feed = $instance['rss_feed'];
		$thePostID      = $wp_query->post->ID;

		// before and after widget arguments are defined by themes

		echo $args['before_widget'];
		
		if ( !empty($maintitle) ) {
			echo '<div class="item-title-bg">';
				echo '<h4>' . esc_html( $maintitle ) . '</h4>';
			echo '</div>';
		}

		if ( $twitter_username != '' && $twitter_consumer_key != '' && $twitter_consumer_secret && $twitter_user_token && $twitter_user_secret ) {
			require_once ZAP_PLUGIN . 'includes/twitterOauth/twitteroauth.php';
			$consumer_key = $twitter_consumer_key;
			$consumer_secret = $twitter_consumer_secret;
			$user_token = $twitter_user_token;
			$user_secret = $twitter_user_secret;
			$username = $twitter_username; //Your twitter screen name or page name
			$connection = new TwitterOAuth($consumer_key, $consumer_secret, $user_token, $user_secret);
			$followers = $connection->get('https://api.twitter.com/1.1/users/show.json?screen_name='.$username);

			echo '
			<div class="follow-me-twitter">
				<a href="https://twitter.com/'.esc_attr($twitter_username).'" class="social-icon icon-twitter" target="_blank"><span>'.$followers->followers_count.'</span> '.__('Followers', 'functionality-for-zap-theme').'</a>
			</div>';
		}

		if ( $facebook_username != '' ) {
			$FBFollow = @file_get_contents('http://api.facebook.com/method/fql.query?format=json&query=select+fan_count+from+page+where+page_id%3D'.$facebook_username.'');
			$data = json_decode($FBFollow);

			if ( !isset($data->error_code) && isset($data['0']->fan_count) ) {
				echo '
				<div class="follow-me-facebook">
					<a href="https://facebook.com/'.esc_attr($facebook_username).'" class="social-icon icon-facebook" target="_blank"><span>'.$data['0']->fan_count.'</span> '.__('Followers', 'functionality-for-zap-theme').'</a>
				</div>';
			}
		}

		if ( $rss_feed != '' ) {
			echo '
			<div class="follow-me-rss">
				<a href="'.$rss_feed.'" class="social-icon icon-rss" target="_blank"><span>'.__('RSS', 'functionality-for-zap-theme').'</span> '.__('Subscribe', 'functionality-for-zap-theme').'</a>
			</div>';
		}

		if ( $googleplus_username != '' && $googleplus_api != '' ) {
			$google = 'https://www.googleapis.com/plus/v1/people/' . $googleplus_username . '?key=' . $googleplus_api;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $google);
			$json_data = curl_exec($ch);
			curl_close($ch);
			$data =  json_decode($json_data);

			if ( isset($data->plusOneCount) ) {
				$gplusfollowers = $data->plusOneCount;
			} else {
				$gplusfollowers = '';
			}
			
			echo '
			<div class="follow-me-googleplus">
				<a href="https://plus.google.com/'.$googleplus_username.'" class="social-icon icon-gplus" target="_blank"><span>'.$gplusfollowers.'</span> '.__('Followers', 'functionality-for-zap-theme').'</a>
			</div>';
		}

		if ( $youtube_username != '' && $youtube_api != '' ) {
			$youtube_data = json_decode(@file_get_contents('https://www.googleapis.com/youtube/v3/channels?part=statistics&id='.$youtube_username.'&key='.$youtube_api));

			echo '
			<div class="follow-me-youtube">
				<a href="https://youtube.com/user/'.$youtube_username.'" class="social-icon icon-youtube" target="_blank"><span>'.$youtube_data->items['0']->statistics->subscriberCount.'</span> '.__('Subscribers', 'functionality-for-zap-theme').'</a>
			</div>';
		}

		if ( $vimeo_username != '' && $vimeo_access_token != '' ) {
			$vimeo_data = json_decode(@file_get_contents('https://api.vimeo.com/users/'.$vimeo_username.'/followers/?access_token='.$vimeo_access_token));

			echo '
			<div class="follow-me-vimeo">
				<a href="https://vimeo.com/'.$vimeo_username.'" class="social-icon icon-vimeo" target="_blank"><span>'.$vimeo_data->total.'</span> '.__('Subscribers', 'functionality-for-zap-theme').'</a>
			</div>';
		}

		if ( $soundcloud_username != '' && $soundcloud_client_id != '' ) {
			$soundcloud_data = json_decode(@file_get_contents('http://api.soundcloud.com/users/'.$soundcloud_username.'?client_id='.$soundcloud_client_id));
			
			echo '
			<div class="follow-me-soundcloud">
				<a href="https://soundcloud.com/'.$soundcloud_username.'" class="social-icon icon-soundcloud" target="_blank"><span>'.$soundcloud_data->followers_count.'</span> '.__('Followers', 'functionality-for-zap-theme').'</a>
			</div>';
		}

		if ( $instagram_username != '' && $instagram_token != '' ) {
			$instagram_data = json_decode(@file_get_contents('https://api.instagram.com/v1/users/'.$instagram_username.'/?access_token='.$instagram_token));
			
			if ( isset($instagram_data) ) {
				echo '
				<div class="follow-me-instagram">
					<a href="https://instagram.com/'.$instagram_username.'" class="social-icon icon-instagram" target="_blank"><span>'.$instagram_data->data->counts->followed_by.'</span> '.__('Followers', 'functionality-for-zap-theme').'</a>
				</div>';
			}
		}

		echo $args['after_widget'];
	}
		
	// Widget Backend 
	public function form( $instance ) {

		$maintitle = isset($instance[ 'maintitle' ]) ? $instance[ 'maintitle' ] : '';
		$facebook_username = isset($instance[ 'facebook_username' ]) ? $instance[ 'facebook_username' ] : '';
		$twitter_username = isset($instance[ 'twitter_username' ]) ? $instance[ 'twitter_username' ] : '';
		$twitter_consumer_key = isset($instance[ 'twitter_consumer_key' ]) ? $instance[ 'twitter_consumer_key' ] : '';
		$twitter_consumer_secret = isset($instance[ 'twitter_consumer_secret' ]) ? $instance[ 'twitter_consumer_secret' ] : '';
		$twitter_user_token = isset($instance[ 'twitter_user_token' ]) ? $instance[ 'twitter_user_token' ] : '';
		$twitter_user_secret = isset($instance[ 'twitter_user_secret' ]) ? $instance[ 'twitter_user_secret' ] : '';
		$googleplus_username = isset($instance[ 'googleplus_username' ]) ? $instance[ 'googleplus_username' ] : '';
		$googleplus_api = isset($instance[ 'googleplus_api' ]) ? $instance[ 'googleplus_api' ] : '';
		$youtube_username = isset($instance[ 'youtube_username' ]) ? $instance[ 'youtube_username' ] : '';
		$youtube_api = isset($instance[ 'youtube_api' ]) ? $instance[ 'youtube_api' ] : '';
		$vimeo_username = isset($instance[ 'vimeo_username' ]) ? $instance[ 'vimeo_username' ] : '';
		$vimeo_access_token = isset($instance[ 'vimeo_access_token' ]) ? $instance[ 'vimeo_access_token' ] : '';
		$soundcloud_username = isset($instance[ 'soundcloud_username' ]) ? $instance[ 'soundcloud_username' ] : '';
		$soundcloud_client_id = isset($instance[ 'soundcloud_client_id' ]) ? $instance[ 'soundcloud_client_id' ] : '';
		$instagram_username = isset($instance[ 'instagram_username' ]) ? $instance[ 'instagram_username' ] : '';
		$instagram_token = isset($instance[ 'instagram_token' ]) ? $instance[ 'instagram_token' ] : '';
		$rss_feed = isset($instance[ 'rss_feed' ]) ? $instance[ 'rss_feed' ] : '';

		// Widget admin form
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'maintitle' ) ); ?>"><?php _e( 'Widget title:', 'functionality-for-zap-theme' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'maintitle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'maintitle' ) ); ?>" type="text" value="<?php echo esc_attr( $maintitle ); ?>" />
		</p>
		<hr></hr>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'facebook_username' ) ); ?>"><?php _e( 'Facebook page ID:', 'functionality-for-zap-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'facebook_username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'facebook_username' ) ); ?>" type="text" value="<?php echo esc_attr( $facebook_username ); ?>" />
		</p>
		<hr></hr>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'twitter_username' ) ); ?>"><?php _e( 'Twitter username:', 'functionality-for-zap-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter_username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter_username' ) ); ?>" type="text" value="<?php echo esc_attr( $twitter_username ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'twitter_consumer_key' ) ); ?>"><?php _e( 'Twitter consumer key:', 'functionality-for-zap-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter_consumer_key' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter_consumer_key' ) ); ?>" type="text" value="<?php echo esc_attr( $twitter_consumer_key ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'twitter_consumer_secret' ) ); ?>"><?php _e( 'Twitter consumer secret:', 'functionality-for-zap-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter_consumer_secret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter_consumer_secret' ) ); ?>" type="text" value="<?php echo esc_attr( $twitter_consumer_secret ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'twitter_user_token' ) ); ?>"><?php _e( 'Twitter user token:', 'functionality-for-zap-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter_user_token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter_user_token' ) ); ?>" type="text" value="<?php echo esc_attr( $twitter_user_token ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'twitter_user_secret' ) ); ?>"><?php _e( 'Twitter user secret:', 'functionality-for-zap-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter_user_secret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter_user_secret' ) ); ?>" type="text" value="<?php echo esc_attr( $twitter_user_secret ); ?>" />
		</p>
		<hr></hr>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'googleplus_username' ) ); ?>"><?php _e( 'Google+ page ID:', 'functionality-for-zap-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'googleplus_username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'googleplus_username' ) ); ?>" type="text" value="<?php echo esc_attr( $googleplus_username ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'googleplus_api' ) ); ?>"><?php _e( 'Google+ API key:', 'functionality-for-zap-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'googleplus_api' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'googleplus_api' ) ); ?>" type="text" value="<?php echo esc_attr( $googleplus_api ); ?>" />
		</p>
		<hr></hr>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'youtube_username' ) ); ?>"><?php _e( 'YouTube username:', 'functionality-for-zap-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'youtube_username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'youtube_username' ) ); ?>" type="text" value="<?php echo esc_attr( $youtube_username ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'youtube_api' ) ); ?>"><?php _e( 'YouTube API key:', 'functionality-for-zap-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'youtube_api' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'youtube_api' ) ); ?>" type="text" value="<?php echo esc_attr( $youtube_api ); ?>" />
		</p>
		<hr></hr>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'vimeo_username' ) ); ?>"><?php _e( 'Vimeo username:', 'functionality-for-zap-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'vimeo_username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'vimeo_username' ) ); ?>" type="text" value="<?php echo esc_attr( $vimeo_username ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'vimeo_access_token' ) ); ?>"><?php _e( 'Vimeo access token:', 'functionality-for-zap-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'vimeo_access_token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'vimeo_access_token' ) ); ?>" type="text" value="<?php echo esc_attr( $vimeo_access_token ); ?>" />
		</p>
		<hr></hr>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'soundcloud_username' ) ); ?>"><?php _e( 'Soundcloud username:', 'functionality-for-zap-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'soundcloud_username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'soundcloud_username' ) ); ?>" type="text" value="<?php echo esc_attr( $soundcloud_username ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'soundcloud_client_id' ) ); ?>"><?php _e( 'Soundclient client ID:', 'functionality-for-zap-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'soundcloud_client_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'soundcloud_client_id' ) ); ?>" type="text" value="<?php echo esc_attr( $soundcloud_client_id ); ?>" />
		</p>
		<hr></hr>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'instagram_username' ) ); ?>"><?php _e( 'Instagram username:', 'functionality-for-zap-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'instagram_username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'instagram_username' ) ); ?>" type="text" value="<?php echo esc_attr( $instagram_username ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'instagram_token' ) ); ?>"><?php _e( 'Instagram access token:', 'functionality-for-zap-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'instagram_token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'instagram_token' ) ); ?>" type="text" value="<?php echo esc_attr( $instagram_token ); ?>" />
		</p>
		<hr></hr>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'rss_feed' ) ); ?>"><?php _e( 'RSS Feed:', 'functionality-for-zap-theme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'rss_feed' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'rss_feed' ) ); ?>" type="text" value="<?php echo esc_attr( $rss_feed ); ?>" />
		</p>
		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['maintitle'] = ( ! empty( $new_instance['maintitle'] ) ) ? strip_tags( $new_instance['maintitle'] ) : '';
		$instance['facebook_username'] = ( ! empty( $new_instance['facebook_username'] ) ) ? strip_tags( $new_instance['facebook_username'] ) : '';
		$instance['twitter_username'] = ( ! empty( $new_instance['twitter_username'] ) ) ? strip_tags( $new_instance['twitter_username'] ) : '';
		$instance['googleplus_username'] = ( ! empty( $new_instance['googleplus_username'] ) ) ? $new_instance['googleplus_username'] : '';
		$instance['googleplus_api'] = ( ! empty( $new_instance['googleplus_api'] ) ) ? strip_tags( $new_instance['googleplus_api'] ) : '';
		$instance['youtube_username'] = ( ! empty( $new_instance['youtube_username'] ) ) ? strip_tags( $new_instance['youtube_username'] ) : '';
		$instance['youtube_api'] = ( ! empty( $new_instance['youtube_api'] ) ) ? strip_tags( $new_instance['youtube_api'] ) : '';
		$instance['twitter_consumer_key'] = ( ! empty( $new_instance['twitter_consumer_key'] ) ) ? strip_tags( $new_instance['twitter_consumer_key'] ) : '';
		$instance['twitter_consumer_secret'] = ( ! empty( $new_instance['twitter_consumer_secret'] ) ) ? strip_tags( $new_instance['twitter_consumer_secret'] ) : '';
		$instance['twitter_user_token'] = ( ! empty( $new_instance['twitter_user_token'] ) ) ? strip_tags( $new_instance['twitter_user_token'] ) : '';
		$instance['twitter_user_secret'] = ( ! empty( $new_instance['twitter_user_secret'] ) ) ? strip_tags( $new_instance['twitter_user_secret'] ) : '';
		$instance['vimeo_username'] = ( ! empty( $new_instance['vimeo_username'] ) ) ? strip_tags( $new_instance['vimeo_username'] ) : '';
		$instance['vimeo_access_token'] = ( ! empty( $new_instance['vimeo_access_token'] ) ) ? strip_tags( $new_instance['vimeo_access_token'] ) : '';
		$instance['soundcloud_username'] = ( ! empty( $new_instance['soundcloud_username'] ) ) ? strip_tags( $new_instance['soundcloud_username'] ) : '';
		$instance['soundcloud_client_id'] = ( ! empty( $new_instance['soundcloud_client_id'] ) ) ? strip_tags( $new_instance['soundcloud_client_id'] ) : '';
		$instance['instagram_username'] = ( ! empty( $new_instance['instagram_username'] ) ) ? strip_tags( $new_instance['instagram_username'] ) : '';
		$instance['instagram_token'] = ( ! empty( $new_instance['instagram_token'] ) ) ? strip_tags( $new_instance['instagram_token'] ) : '';
		$instance['rss_feed'] = ( ! empty( $new_instance['rss_feed'] ) ) ? strip_tags( $new_instance['rss_feed'] ) : '';

		return $instance;
	}
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget_followers() {
	register_widget( 'wpb_widget_followers' );
}
add_action( 'widgets_init', 'wpb_load_widget_followers' );
?>