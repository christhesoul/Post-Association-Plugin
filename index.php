<?php   
  
/* 
Plugin Name: Post Association
Plugin URI: http://www.wearecondiment.com
Description: For associating X of one post type with Y of another
Version: 1.0 
Author: Chris Waters
Author URI: http://www.wearecondiment.com
*/

function Post_Association() {
	
	$pa_options = get_option('post_association_options');
	$association_has_many_post_types = $pa_options['has_many'];
	$association_belongs_to_post_types = $pa_options['belongs_to'];

	$pa_has_many_mb = new WPAlchemy_MetaBox(array
	(
		'id' => '_post_association_meta',
		'title' => 'Post Association Meta',
		'template' => dirname(__FILE__) . '/post_association_has_many_meta.php',
		'types' => array($association_has_many_post_types),
		'mode' => WPALCHEMY_MODE_EXTRACT,
		'prefix' => '_my_'
	));
	$pa_belongs_to_mb = new WPAlchemy_MetaBox(array
	(
		'id' => '_post_association_meta',
		'title' => 'Post Association Meta',
		'template' => dirname(__FILE__) . '/post_association_belongs_to_meta.php',
		'types' => array($association_belongs_to_post_types),
		'mode' => WPALCHEMY_MODE_EXTRACT,
		'prefix' => '_my_'
	));
	
	include_once dirname(__FILE__) . '/helpers.php';
	
}

add_action('init','Post_Association');

/* Add the plugin setttings page */

function post_association_plugin_add_page() {
	add_options_page('Post Association Options', 'Post Association Options', 'manage_options', 'post_association', 'post_association_options_page');
}

add_action('admin_menu', 'post_association_plugin_add_page');

function post_association_options_page() {
?>
	<div class="wrap">
		<h2>Associate Posts</h2>
		<form action="options.php" method="post">
			<?php settings_fields('post_association_options'); ?>
			<?php do_settings_sections('post_association'); ?>
			<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
		</form>
	</div>
<?php }

add_action('admin_init', 'post_association_plugin_admin_init');

function post_association_plugin_admin_init(){
	register_setting('post_association_options', 'post_association_options', 'post_association_options_validate' );
	add_settings_section('post_association_plugin_main', 'Set associations', 'post_association_plugin_section_text', 'post_association');
	add_settings_field('plugin_text_string', 'The post type with the name of ', 'post_association_plugin_setting_string', 'post_association', 'post_association_plugin_main');
}

function post_association_plugin_section_text() {
	echo '<p>Main description of this section here.</p>';
}

function post_association_plugin_setting_string() {
	$options = get_option('post_association_options');
	$post_types = get_post_types('','names');
	echo '<select name="post_association_options[has_many]">';
	foreach ($post_types as $post_type ) {
		$selected = $options['has_many'] == $post_type ? ' selected=selected' : '';
  	echo '<option value="'.$post_type.'"'.$selected.'>'.$post_type.'</option>';	
	}
	echo '</select>';
	echo ' has ';
	echo '<input type="text" style="width:25px;" name="post_association_options[number_of]" value="'.$options['number_of'].'" />';
	echo ' of the following post type ';
	echo '<select name="post_association_options[belongs_to]">';
	foreach ($post_types as $post_type ) {
		$selected = $options['belongs_to'] == $post_type ? ' selected=selected' : '';
  	echo '<option value="'.$post_type.'"'.$selected.'>'.$post_type.'</option>';	
	}
	echo '</select>';
	//print_r($options);
}

function post_association_options_validate($input) {
	$options = get_option('post_association_options');
	$options['has_many'] = trim($input['has_many']);
	$options['number_of'] = trim($input['number_of']);
	$options['belongs_to'] = trim($input['belongs_to']);
	return $options;
}