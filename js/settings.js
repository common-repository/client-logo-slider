jQuery(document).ready(function($){
	$('#wpcls3-add-image-btn').click(function(e){
		$('<div class="wpcls3-image"><input name="wpcls3_slider_images[]" type="text"/><button type="button" class="button">X</button></div>').appendTo('#wpcls3-images');
	});

	$('body').on('click', '#wpcls3-images .wpcls3-image .button', function(e){
		$(this).closest('.wpcls3-image').remove();
	});
});