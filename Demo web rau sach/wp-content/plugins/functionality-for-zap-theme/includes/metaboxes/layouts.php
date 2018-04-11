<?php
/*
 * Layout options
 */

$config = array(
	'id'       => 'vh_layouts',
	'title'    => __('Layouts', 'zap'),
	'pages'    => array('page', 'post'),
	'context'  => 'normal',
	'priority' => 'high',
);

$options = array(array(
	'name'    => __('Layout type', 'zap'),
	'id'      => 'layouts',
	'type'    => 'layouts',
	'only'    => 'page,post',
	'default' => get_option('default-layout'),
));

require_once(plugin_dir_path( __FILE__ ) . '/add_metaboxes.php');
new create_meta_boxes($config, $options);