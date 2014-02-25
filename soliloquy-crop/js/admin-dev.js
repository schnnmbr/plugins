/**
 * jQuery to power the Crop Addon admin.
 * 
 * @package   Tgmsp-Crop
 * @version   1.0.0
 * @author    Thomas Griffin <thomas@thomasgriffinmedia.com>
 * @copyright Copyright (c) 2013, Thomas Griffin
 */
jQuery(document).ready(function($){

	/** Append information to the global settings ID var */
	if ( 'undefined' == typeof soliloquyPreviewSettingsID || false == soliloquyPreviewSettingsID )
		soliloquyPreviewSettingsID = '#soliloquy_crop_settings .form-table td,';
	else
		soliloquyPreviewSettingsID += '#soliloquy_crop_settings .form-table td,';
		
	/** Show custom message if cropped size is selected */
	var default_text = $('#soliloquy-default-sizes #soliloquy-height').next();
	if ( 'cropped' == $('#soliloquy-default-size option[selected]').val() ) {
		$('#soliloquy-custom-sizes').hide();
		$(default_text).hide().after('<p class="soliloquy-crop-size description"><strong>' + soliloquy_crop.desc + '</strong</p>');
	}
	
	/** Process toggle switches for field changes */
	$('#soliloquy-default-size').on('change', function() {
		if ( 'cropped' == $(this).val() ) {
			$('#soliloquy-custom-sizes, #soliloquy-explain-size').hide();
			if ( ! $('#soliloquy-default-sizes').is(':visible') )
				$('#soliloquy-default-sizes').fadeIn('normal');
			$(default_text).hide().after('<p class="soliloquy-crop-size description"><strong>' + soliloquy_crop.desc + '</strong</p>');
		} 
		else if ( 'default' == $(this).val() ) {
			$(default_text).fadeIn('normal');
			$('#soliloquy-custom-sizes').hide();
			$('.soliloquy-crop-size').remove();
		} else {
			$('.soliloquy-crop-size').remove();
		}
	});

});