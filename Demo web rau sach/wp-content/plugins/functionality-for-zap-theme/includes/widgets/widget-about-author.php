<?php

/**
* About Us widget
*/

class zap_author extends WP_Widget {
	public function zap_author() {
		$widget_options = array(
			'classname'   => 'zap_author',
			'description' => __('Display information about a person.', 'functionality-for-zap-theme')
		);
		parent::__construct('zap_author', __('Zap - About Author', 'functionality-for-zap-theme') , $widget_options);
	}

	public function widget($args, $instance) {
		extract($args);
		$title              = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		$image_uri          = $instance['image_uri'];
		$author_name        = $instance['author_name'];
		$author_position    = $instance['author_position'];
		$author_facebook    = $instance['author_facebook'];
		$author_youtube     = $instance['author_youtube'];
		$author_twitter     = $instance['author_twitter'];
		$author_googleplus  = $instance['author_googleplus'];
		$author_description = $instance['author_description'];
		
		echo $before_widget;

		if ($title)
			echo $before_title . $title . $after_title;
		?>

		<div class="zap-about-author">
			<?php if ($image_uri) { ?>
				<img src="<?php echo $image_uri; ?>" class="author-image">
			<?php } ?>
			<?php if ($author_name) { ?>
				<span class="author-name paint-area paint-area--text"><?php echo $author_name; ?></span>
			<?php } ?>
			<?php if ($author_position) { ?>
				<span class="author-position paint-area paint-area--text"><?php echo $author_position; ?></span>
			<?php } ?>
			<?php if ($author_facebook || $author_youtube || $author_twitter || $author_googleplus) { ?>
				<div class="about-author-social">
					<?php if ($author_facebook) { ?>
						<a href="<?php echo $author_facebook; ?>" class="author-social icon-facebook paint-area paint-area--text"></a>
					<?php } ?>
					<?php if ($author_youtube) { ?>
						<a href="<?php echo $author_youtube; ?>" class="author-social icon-youtube-play paint-area paint-area--text"></a>
					<?php } ?>
					<?php if ($author_twitter) { ?>
						<a href="<?php echo $author_twitter; ?>" class="author-social icon-twitter paint-area paint-area--text"></a>
					<?php } ?>
					<?php if ($author_googleplus) { ?>
						<a href="<?php echo $author_googleplus; ?>" class="author-social icon-gplus paint-area paint-area--text"></a>
					<?php } ?>
				</div>
			<?php } ?>
			<?php if ($author_description) { ?>
				<p class="author-description paint-area paint-area--text"><?php echo $author_description; ?></p>
			<?php } ?>
		</div>

		<?php
		echo $after_widget;
	}

	public function update($new_instance, $old_instance) {
		$instance              = $old_instance;
		$instance['title']     = strip_tags($new_instance['title']);
		$instance['image_uri'] = strip_tags($new_instance['image_uri']);
		$instance['author_name']     = strip_tags($new_instance['author_name']);
		$instance['author_position']     = strip_tags($new_instance['author_position']);
		$instance['author_facebook']     = strip_tags($new_instance['author_facebook']);
		$instance['author_youtube']     = strip_tags($new_instance['author_youtube']);
		$instance['author_twitter']     = strip_tags($new_instance['author_twitter']);
		$instance['author_googleplus']     = strip_tags($new_instance['author_googleplus']);
		$instance['author_description']     = strip_tags($new_instance['author_description']);

		return $instance;
	}

	public function form($instance) {
		$title  = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$image_uri    = isset($instance['image_uri']) ? esc_attr($instance['image_uri']) : '';
		$author_name  = isset($instance['author_name']) ? esc_attr($instance['author_name']) : '';
		$author_position  = isset($instance['author_position']) ? esc_attr($instance['author_position']) : '';
		$author_facebook  = isset($instance['author_facebook']) ? esc_attr($instance['author_facebook']) : '';
		$author_youtube  = isset($instance['author_youtube']) ? esc_attr($instance['author_youtube']) : '';
		$author_twitter  = isset($instance['author_twitter']) ? esc_attr($instance['author_twitter']) : '';
		$author_googleplus  = isset($instance['author_googleplus']) ? esc_attr($instance['author_googleplus']) : '';
		$author_description  = isset($instance['author_description']) ? esc_attr($instance['author_description']) : '';
		
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'functionality-for-zap-theme'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('image_uri')); ?>"><?php _e('Image:', 'functionality-for-zap-theme'); ?></label>
			<br><img src="<?php echo $image_uri; ?>" class="author-img"><br>
			<input type="hidden" class="img" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo $image_uri; ?>" />
			<input type="button" class="select-img" value="Select Image" />
			<input type="button" class="remove-img" value="Remove Image" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('author_name')); ?>"><?php _e('Author name:', 'functionality-for-zap-theme'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('author_name')); ?>" name="<?php echo esc_attr($this->get_field_name('author_name')); ?>" type="text" value="<?php echo esc_attr($author_name); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('author_position')); ?>"><?php _e('Author position:', 'functionality-for-zap-theme'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('author_position')); ?>" name="<?php echo esc_attr($this->get_field_name('author_position')); ?>" type="text" value="<?php echo esc_attr($author_position); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('author_facebook')); ?>"><?php _e('Author Facebook URL:', 'functionality-for-zap-theme'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('author_facebook')); ?>" name="<?php echo esc_attr($this->get_field_name('author_facebook')); ?>" type="text" value="<?php echo esc_attr($author_facebook); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('author_youtube')); ?>"><?php _e('Author YouTube URL:', 'functionality-for-zap-theme'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('author_youtube')); ?>" name="<?php echo esc_attr($this->get_field_name('author_youtube')); ?>" type="text" value="<?php echo esc_attr($author_youtube); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('author_twitter')); ?>"><?php _e('Author Twitter URL:', 'functionality-for-zap-theme'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('author_twitter')); ?>" name="<?php echo esc_attr($this->get_field_name('author_twitter')); ?>" type="text" value="<?php echo esc_attr($author_twitter); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('author_googleplus')); ?>"><?php _e('Author Google+ URL:', 'functionality-for-zap-theme'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('author_googleplus')); ?>" name="<?php echo esc_attr($this->get_field_name('author_googleplus')); ?>" type="text" value="<?php echo esc_attr($author_googleplus); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('author_description')); ?>"><?php _e('Author description:', 'functionality-for-zap-theme'); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('author_description')); ?>" name="<?php echo esc_attr($this->get_field_name('author_description')); ?>"><?php echo esc_attr($author_description); ?></textarea>
		</p>
	<?php
	}
}

function zap_register_author_widget() {
	register_widget( 'zap_author', 'zap_register_author_widget' );
}

add_action( 'widgets_init', 'zap_register_author_widget');

global $pagenow;

if ( $pagenow == 'widgets.php' ) {
	function hrw_enqueue() {
		wp_enqueue_style('thickbox');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('widget-image', get_template_directory_uri().'/inc/js/widget-image.js', null, null, true);
	}
	add_action('admin_enqueue_scripts', 'hrw_enqueue');
}