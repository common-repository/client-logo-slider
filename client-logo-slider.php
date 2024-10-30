<?php
/*
Plugin Name: Client Logo Slider
Plugin URI: http://thegeekhangout.com/
Description: Showcase your client logos in an elegant, responsive carousel with the help of a shortcode.
Version: 1.0
Author: Aaron Astbury
Author URI: http://thegeekhangout.com/
License: GPL2
*/

/*
* Initialize the plugin options on first run
*/

function wpcls3_initialize(){
	$options_not_set = get_option('wpcls3_post_type_settings');
	if( $options_not_set ) return;
	
	$slider_settings = array( 'items' => 3, 'single_item' => false, 'slide_speed' => 500, 'pagination_speed' => 500, 'rewind_speed' => 500, 'auto_play' => true, 'stop_on_hover' => true, 'navigation' => false, 'pagination' => true, 'responsive' => true );
	update_option('wpcls3_slider_settings', $slider_settings);
}
register_activation_hook(__FILE__, 'wpcls3_initialize');

/*
* Delete the plugin options on uninstall
*/

function wpcls3_remove_options(){
	delete_option('wpcls3_slider_settings');
}
register_uninstall_hook(__FILE__, 'wpcls3_remove_options');

/*
* Enqueue scripts and stylesheets on the pages where the shortcode has been used
*/

function wpcls3_enqueue_shortcode_files($posts) {
    if ( empty($posts) )
        return $posts;
 
    $found_slider = false;
    foreach ($posts as $post) {
        if ( has_shortcode($post->post_content, 'wpcls3_logo_slider') ){
        	$found_slider = true;
        	break;
        }
    }
 
    if ($found_slider){
        wp_enqueue_style( 'wpcls3-logo-slider', plugins_url('css/logo-slider.css', __FILE__), array(), '1.0', 'all' );
        wp_enqueue_script( "wpcls3-logo-slider", plugins_url('js/logo-slider.js', __FILE__ ), array('jquery') );
        $slider_settings = get_option('wpcls3_slider_settings');
        wp_localize_script( 'wpcls3-logo-slider', 'wpcls3', $slider_settings);
    }
    return $posts;
}
add_action('the_posts', 'wpcls3_enqueue_shortcode_files');

/*
* If the function has_sortcode() is not defined, define it
*/

if(!function_exists('has_shortcode')){
	function has_shortcode( $content, $tag ) {
		if(stripos($content, '['.$tag.']') !== false)
			return true;
		return false;
	}
}

/*
* Setup the shortcode
*/

function wpcls3_logo_slider_callback( $atts ) {
	ob_start();
	$image_urls = get_option('wpcls3_slider_images');
	if(is_array($image_urls) && count($image_urls)):
?>
	<div id="wpcls3-logo-slider" class="owl-carousel">
		<?php foreach ( $image_urls as $url ) : ?>
			<div class="logo-container">
				<img src="<?=$url?>"/>
			</div>
		<?php endforeach; ?>
	</div>
<?php
	else:
		$control_panel_url = admin_url('plugins.php?page=wpcls3_settings');
		echo "The client logo slider is ready. Please <a href='$control_panel_url'>add logo images</a> in the plugin control panel.";
	endif;
	return ob_get_clean();
}
add_shortcode( 'wpcls3_logo_slider', 'wpcls3_logo_slider_callback' );

/*
* Include the settings page
*/

include_once('settings.php');

?>