<?php
function wpcls3_menu_item() {
	global $wpcls3_settings_page_hook;
    $wpcls3_settings_page_hook = add_plugins_page( 'Logo Slider Settings', 'Logo Slider Settings', 'administrator', 'wpcls3_settings', 'wpcls3_render_settings_page' );
}
add_action( 'admin_menu', 'wpcls3_menu_item' );

function wpcls3_scripts_styles($hook) {
	global $wpcls3_settings_page_hook;
	if( $wpcls3_settings_page_hook != $hook )
		return;
	wp_enqueue_style("wpcls3-options-page", plugins_url( "css/settings.css" , __FILE__ ), false, "1.0", "all");
	wp_enqueue_script("wpcls3-options-page", plugins_url( "js/settings.js" , __FILE__ ), false, "1.0");
}
add_action( 'admin_enqueue_scripts', 'wpcls3_scripts_styles' );

function wpcls3_render_settings_page() {
?>
<div class="wrap">
<div id="icon-options-general" class="icon32"></div>
<h2>Logo Slider Settings</h2>
	<?php settings_errors(); ?>
	<div class="clearfix paddingtop20">
		<div class="first ninecol">
			<form method="post" action="options.php">
				<?php settings_fields( 'wpcls3_settings' ); ?>
				<?php do_settings_sections( "wpcls3_settings" ); ?>
				<?php submit_button(); ?>
			</form>
		</div>
		<div class="last threecol">
			<div class="side-block">
				Like the plugin? Don't forget to give it a good rating on WordPress.org.
			</div>
		</div>
	</div>
</div>
<?php }

function wpcls3_create_options() { 
	
	add_settings_section( 'wpcls3_images_section', null, null, 'wpcls3_settings' );
	add_settings_section( 'wpcls3_slider_section', null, null, 'wpcls3_settings' );

	add_settings_field(
        'wpcls3_slider_images', 'Image URLs of Logos', 'wpcls3_render_settings_field', 'wpcls3_settings', 'wpcls3_images_section',
		array(
			'desc' => 'Image URLs for the logo slider',
			'type' => 'imagefields',
			'id' => 'wpcls3_slider_images',
			'group' => 'wpcls3_slider_images'
		)
    );

    add_settings_field(
        'items', 'Item Count', 'wpcls3_render_settings_field', 'wpcls3_settings', 'wpcls3_slider_section',
		array(
			'desc' => 'Number of items to show on the widest screen',
			'id' => 'items',
			'type' => 'text',
			'group' => 'wpcls3_slider_settings'
		)
    );
    add_settings_field(
        'single_item', 'Show Single Item', 'wpcls3_render_settings_field', 'wpcls3_settings', 'wpcls3_slider_section',
		array(
			'desc' => 'If checked only a single item will be displayed no matter what the screen size is',
			'id' => 'single_item',
			'type' => 'checkbox',
			'group' => 'wpcls3_slider_settings'
		)
    );
    add_settings_field(
        'slide_speed', 'Slider Speed', 'wpcls3_render_settings_field', 'wpcls3_settings', 'wpcls3_slider_section',
		array(
			'desc' => 'Animation speed of the slider in milliseconds',
			'id' => 'slide_speed',
			'type' => 'text',
			'group' => 'wpcls3_slider_settings'
		)
    );
    add_settings_field(
        'pagination_speed', 'Pagination Speed', 'wpcls3_render_settings_field', 'wpcls3_settings', 'wpcls3_slider_section',
		array(
			'desc' => 'Pagination speed of the slider in milliseconds',
			'id' => 'pagination_speed',
			'type' => 'text',
			'group' => 'wpcls3_slider_settings'
		)
    );
    add_settings_field(
        'rewind_speed', 'Rewind Speed', 'wpcls3_render_settings_field', 'wpcls3_settings', 'wpcls3_slider_section',
		array(
			'desc' => 'Rewind speed of the slider in milliseconds',
			'id' => 'rewind_speed',
			'type' => 'text',
			'group' => 'wpcls3_slider_settings'
		)
    );
	add_settings_field(
        'auto_play', 'Auto Play Slider', 'wpcls3_render_settings_field', 'wpcls3_settings', 'wpcls3_slider_section',
		array(
			'desc' => 'If checked the slider will start to animate automatically on page load',
			'id' => 'auto_play',
			'type' => 'checkbox',
			'group' => 'wpcls3_slider_settings'
		)
    );
	add_settings_field(
        'stop_on_hover', 'Stop on hover', 'wpcls3_render_settings_field', 'wpcls3_settings', 'wpcls3_slider_section',
		array(
			'desc' => 'If checked the animation will stop on hover',
			'id' => 'stop_on_hover',
			'type' => 'checkbox',
			'group' => 'wpcls3_slider_settings'
		)
    );
	add_settings_field(
        'navigation', 'Display Navigation', 'wpcls3_render_settings_field', 'wpcls3_settings', 'wpcls3_slider_section',
		array(
			'desc' => 'If checked, next and previous links will be displayed',
			'id' => 'navigation',
			'type' => 'checkbox',
			'group' => 'wpcls3_slider_settings'
		)
    );
	add_settings_field(
        'pagination', 'Display Pagination', 'wpcls3_render_settings_field', 'wpcls3_settings', 'wpcls3_slider_section',
		array(
			'desc' => 'If checked the slider will be paginated',
			'id' => 'pagination',
			'type' => 'checkbox',
			'group' => 'wpcls3_slider_settings'
		)
    );
	add_settings_field(
        'responsive', 'Responsive', 'wpcls3_render_settings_field', 'wpcls3_settings', 'wpcls3_slider_section',
		array(
			'desc' => 'If checked the slider will automatically adapt to screen size',
			'id' => 'responsive',
			'type' => 'checkbox',
			'group' => 'wpcls3_slider_settings'
		)
    );
    // Finally, we register the fields with WordPress 
	register_setting('wpcls3_settings', 'wpcls3_slider_images', 'wpcls3_images_validation');
	register_setting('wpcls3_settings', 'wpcls3_slider_settings', 'wpcls3_settings_validation');
	
}
add_action('admin_init', 'wpcls3_create_options');

function wpcls3_images_validation($input){
	foreach ($input as $key => $img) {
		if( trim($img) )
			$input[$key] = esc_url($img);
		else
			unset($input[$key]);
	}
	return $input;
}

function wpcls3_settings_validation($input){
	$input['single_item'] 		= (bool)$input['single_item'];
	$input['auto_play'] 		= (bool)$input['auto_play'];
	$input['stop_on_hover'] 	= (bool)$input['stop_on_hover'];
	$input['navigation'] 		= (bool)$input['navigation'];
	$input['pagination'] 		= (bool)$input['pagination'];
	$input['responsive'] 		= (bool)$input['responsive'];
	$input['items'] 			= (trim($input['items']) && is_numeric($input['items']))?((int)$input['items']):6;
	$input['slide_speed'] 		= (trim($input['slide_speed']) && is_numeric($input['slide_speed']))?((int)$input['slide_speed']):500;
	$input['pagination_speed'] 	= (trim($input['pagination_speed']) && is_numeric($input['pagination_speed']))?((int)$input['pagination_speed']):500;
	$input['rewind_speed'] 		= (trim($input['rewind_speed']) && is_numeric($input['rewind_speed']))?((int)$input['rewind_speed']):500;
	return $input;
}

function wpcls3_render_settings_field($args){
	$option_value = get_option($args['group']);
?>
	<?php if($args['type'] == 'imagefields'): ?>
		<div id="wpcls3-images">
			<?php if(is_array($option_value) && count($option_value)): ?>
				<?php foreach ($option_value as $key => $image): ?>
					<div class="wpcls3-image"><input value="<?=$image?>" name="wpcls3_slider_images[]" type="text"/><button type="button" class="button">X</button></div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<button type="button" id="wpcls3-add-image-btn" class="button">Add</button>
	<?php elseif($args['type'] == 'text'): ?>
		<input type="text" id="<?php echo $args['id'] ?>" name="<?php echo $args['group'].'['.$args['id'].']'; ?>" value="<?php echo (isset($option_value[$args['id']]))?esc_attr($option_value[$args['id']]):''; ?>">
	<?php elseif ($args['type'] == 'select'): ?>
		<select name="<?php echo $args['group'].'['.$args['id'].']'; ?>" id="<?php echo $args['id']; ?>">
			<?php foreach ($args['options'] as $key=>$option) { ?>
				<option <?php if(isset($option_value[$args['id']])) selected($option_value[$args['id']], $key); echo 'value="'.$key.'"'; ?>><?php echo $option; ?></option><?php } ?>
		</select>
	<?php elseif($args['type'] == 'checkbox'): ?>
		<input type="hidden" name="<?php echo $args['group'].'['.$args['id'].']'; ?>" value="0" />
		<input type="checkbox" name="<?php echo $args['group'].'['.$args['id'].']'; ?>" id="<?php echo $args['id']; ?>" value="1" <?php if(isset($option_value[$args['id']])) checked($option_value[$args['id']], true); ?> />
	<?php elseif($args['type'] == 'textarea'): ?>
		<textarea name="<?php echo $args['group'].'['.$args['id'].']'; ?>" type="<?php echo $args['type']; ?>" cols="" rows=""><?php echo isset($option_value[$args['id']])?stripslashes(esc_textarea($option_value[$args['id']]) ):''; ?></textarea>
	<?php endif; ?>
		<p class="description"><?php echo $args['desc'] ?></p>
<?php
}

?>