/**
 * jQuery to power the Featured Content Addon.
 *
 * The object passed to this script file via wp_localize_script is
 * soliloquy_fc.
 *
 * @package   Tgmsp-FC
 * @version   1.0.0
 * @author    Thomas Griffin <thomas@thomasgriffinmedia.com>
 * @copyright Copyright (c) 2012, Thomas Griffin
 */

jQuery(document).ready(function($) {

	/** Append information to the global settings ID var */
	if ( 'undefined' == typeof soliloquyPreviewSettingsID || false == soliloquyPreviewSettingsID )
		soliloquyPreviewSettingsID = '#soliloquy-fc-query th,#soliloquy-fc-query td,#soliloquy-fc-content td,';
	else
		soliloquyPreviewSettingsID += '#soliloquy-fc-query th,#soliloquy-fc-query td,#soliloquy-fc-content td,';

	/** Flag for determing if the user has selected anything or not yet since page load */
	var chosen_term = false;
	var chosen_post = false;

	/** Let's go ahead and initialize the jQuery Chosen plugin */
	$('.soliloquy-fc-create select').chosen();

	/** Set default value for number of posts */
	if ( 0 == $('#soliloquy-fc-number').val().length )
		$('#soliloquy-fc-number').val(soliloquy_fc.posts_num);

	/** Set default value for number of words in post content excerpt */
	if ( 0 == $('#soliloquy-fc-post-content-length').val().length )
		$('#soliloquy-fc-post-content-length').val(soliloquy_fc.post_content_length);

	/** Set default value for read more text */
	if ( 0 == $('#soliloquy-fc-read-more-text').val().length )
		$('#soliloquy-fc-read-more-text').val(soliloquy_fc.read_more);

	/** Set default and change value for linking post title to the post */
	if ( $('#soliloquy-fc-post-title').is(':checked') )
		$('#soliloquy-fc-post-title-link-box').show();
	else
		$('#soliloquy-fc-post-title-link-box').hide();

	$('#soliloquy-fc-post-title').on('change', function(){
		if ( $(this).is(':checked') )
			$('#soliloquy-fc-post-title-link-box').fadeIn();
		else
			$('#soliloquy-fc-post-title-link-box').fadeOut();
	});

	/** Set default and change value for showing number of content words */
	if ( 'post-content' == $('#soliloquy-fc-content-type option:selected').val() )
		$('#soliloquy-fc-post-content-length-box, #soliloquy-fc-ellipses-box').show();
	else
		$('#soliloquy-fc-post-content-length-box, #soliloquy-fc-ellipses-box').hide();

	$('#soliloquy-fc-content-type').on('change', function(){
		if ( 'post-content' == $(this).val() )
			$('#soliloquy-fc-post-content-length-box, #soliloquy-fc-ellipses-box').fadeIn();
		else
			$('#soliloquy-fc-post-content-length-box, #soliloquy-fc-ellipses-box').fadeOut();
	});

	/** Set default and change value for read more text */
	if ( $('#soliloquy-fc-read-more').is(':checked') )
		$('#soliloquy-fc-read-more-text-box').show();
	else
		$('#soliloquy-fc-read-more-text-box').hide();

	$('#soliloquy-fc-read-more').on('change', function(){
		if ( $(this).is(':checked') )
			$('#soliloquy-fc-read-more-text-box').fadeIn();
		else
			$('#soliloquy-fc-read-more-text-box').fadeOut();
	});

	/** Show/hide the normal or dynamic area on page load */
	if ( 'featured' == $('input[name="_soliloquy_settings[type]"]:checked').val() )
		$('.soliloquy-fc-create').show();
	else
		$('.soliloquy-fc-create').hide();

	/** Show/hide the normal or dynamic area on user selection */
	$('input[name="_soliloquy_settings[type]"]').on('change', function() {
		if ( 'featured' == $(this).val() )
			$('.soliloquy-fc-create').fadeIn();
		else
			$('.soliloquy-fc-create').hide();
	});

	/** Show/hide the inclusion groups (and even the inclusion step itself if certain conditions are met */
	if ( $('#soliloquy-fc-post-type').val() ) {
		if ( $('#soliloquy-fc-post-type').val().length >= 2 ) {
			$('#soliloquy-fc-include-exclude option:selected').removeAttr('selected').trigger('change').trigger('liszt:updated');
			$('#soliloquy-fc-include-exclude-box').hide();

			/** Do a conditional check if more than one post type is selected on page load to see if we should show the terms select box */
			if ( ! chosen_term ) {
				chosen_term = true;
				soliloquyFcRefreshTermsCondMulti($('#soliloquy-fc-post-type').val());
			} else {
				soliloquyFcRefreshTerms($('#soliloquy-fc-post-type').val());
			}
		} else {
			$('#soliloquy-fc-include-exclude-box').show();

			/** Do a conditional check if more than one post type is selected on page load to see if we should show the terms select box */
			if ( ! chosen_post ) {
				chosen_post = true;
				soliloquyFcRefreshPostsCond($('#soliloquy-fc-post-type').val());
			} else {
				soliloquyFcRefreshPosts($('#soliloquy-fc-post-type').val());
			}

			if ( ! chosen_term ) {
				chosen_term = true;
				soliloquyFcRefreshTermsCond($('#soliloquy-fc-post-type').val());
			} else {
				soliloquyFcRefreshTerms($('#soliloquy-fc-post-type').val());
			}
		}
	} else {
		/** Default to "post" and trigger events to make sure Chosen functions correctly */
		$('#soliloquy-fc-post-type option[value="post"]').attr('selected', 'selected').trigger('change').trigger('liszt:updated');

		/** Do a conditional check if more than one post type is selected on page load to see if we should show the terms select box */
		if ( ! chosen_post ) {
			chosen_post = true;
			soliloquyFcRefreshPostsCond($('#soliloquy-fc-post-type').val());
		}

		if ( ! chosen_term ) {
			chosen_term = true;
			soliloquyFcRefreshTermsCond($('#soliloquy-fc-post-type').val());
		}
	}

	/** Use ajax to show/hide terms related to the currently selected post type(s) */
	$('#soliloquy-fc-post-type').chosen().change(function(){
		if ( $('#soliloquy-fc-post-type').val() ) {
			if ( $('#soliloquy-fc-post-type').val().length >= 2 ) {
				$('#soliloquy-fc-include-exclude option:selected').removeAttr('selected').trigger('change').trigger('liszt:updated');
				$('#soliloquy-fc-include-exclude-box').fadeOut();
				soliloquyFcRefreshTerms($('#soliloquy-fc-post-type').val());
			} else {
				$('#soliloquy-fc-include-exclude-box').fadeIn();
				soliloquyFcRefreshPosts($('#soliloquy-fc-post-type').val());
				soliloquyFcRefreshTerms($('#soliloquy-fc-post-type').val());
			}
		}
	});

	/** Callback function to process the terms and post selection areas for the query settings */
	function soliloquyFcRefreshTerms(posttype){
		if ( ! chosen_term ) {
			chosen_term = true;
			return;
		}

		/** Set type to post in array if there is none selected */
		if ( ! posttype )
			posttype = ['post'];

		/** Output the loading icon */
		$('#soliloquy_fc_terms_chzn').after('<span class="soliloquy-waiting-terms"><img class="soliloquy-spinner" src="' + soliloquy.spinner + '" width="16px" height="16px" style="margin: 5px 5px 0; vertical-align: top;" /></span>');

		var opts = {
			type: 'post',
			url: soliloquy.ajaxurl,
			async: true,
			cache: false,
			dataType: 'json',
			data: {
				action: 'soliloquy_fc_refresh_terms',
				nonce: soliloquy_fc.term_nonce,
				post_type: posttype,
				id: soliloquy_fc.id
			},
			success: function(json){
				if ( typeof json.error !== "undefined" ) {
					$('.soliloquy-waiting-terms').remove();
					$('#soliloquy-fc-terms option:selected').removeAttr('selected').trigger('change').trigger('liszt:updated');
					$('#soliloquy-fc-terms-box').fadeOut();
				} else {
					$('#soliloquy-fc-terms-box').fadeIn('normal', function(){
						$('.soliloquy-waiting-terms').remove();
						$('#soliloquy-fc-terms').empty().append(json).trigger('change').trigger('liszt:updated');
					});
				}
			},
			error: function(xhr){
				$('.soliloquy-waiting-terms').remove();
			}
		}
		$.ajax(opts);
	}

	function soliloquyFcRefreshTermsCond(posttype){
		var opts = {
			type: 'post',
			url: soliloquy.ajaxurl,
			async: true,
			cache: false,
			dataType: 'json',
			data: {
				action: 'soliloquy_fc_refresh_terms',
				nonce: soliloquy_fc.term_nonce,
				post_type: posttype,
				id: soliloquy_fc.id
			},
			success: function(json){
				/** We only need to handle errors if no taxonomy is shared between the post types */
				if ( typeof json.error !== "undefined" ) {
					$('#soliloquy-fc-terms-box').hide();
					return;
				} else {
					/** Grab all currently chosen items and repopulate them */
					$('#soliloquy-fc-terms-box').show();
					$('#soliloquy-fc-terms').empty().append(json);
					$('#soliloquy_fc_terms_chzn .chzn-results li.result-selected').each(function(){
						var el = $(this);
						$('#soliloquy-fc-terms option').each(function(){
							if ( $(this).text() == el.text() )
								$(this).attr('selected', 'selected');
						});
					});
					$('#soliloquy-fc-terms').trigger('change').trigger('liszt:updated');
				}
			},
			error: function(xhr){
			}
		}
		$.ajax(opts);
	}

	function soliloquyFcRefreshTermsCondMulti(posttype){
		var opts = {
			type: 'post',
			url: soliloquy.ajaxurl,
			async: true,
			cache: false,
			dataType: 'json',
			data: {
				action: 'soliloquy_fc_refresh_terms',
				nonce: soliloquy_fc.term_nonce,
				post_type: posttype,
				id: soliloquy_fc.id
			},
			success: function(json){
				/** We only need to handle errors if no taxonomy is shared between the post types */
				if ( typeof json.error !== "undefined" ) {
					$('#soliloquy-fc-terms-box').hide();
					$('#soliloquy-fc-terms option:selected').removeAttr('selected').trigger('change').trigger('liszt:updated');
				}
			},
			error: function(xhr){
			}
		}
		$.ajax(opts);
	}

	function soliloquyFcRefreshPosts(posttype){
		if ( ! chosen_post ) {
			chosen_post = true;
			return;
		}

		/** Set type to post in array if there is none selected */
		if ( ! posttype )
			posttype = ['post'];

		/** Output the loading icon */
		$('#soliloquy_fc_include_exclude_chzn').after('<span class="soliloquy-waiting-posts"><img class="soliloquy-spinner" src="' + soliloquy.spinner + '" width="16px" height="16px" style="margin: 5px 5px 0; vertical-align: top;" /></span>');

		var opts = {
			type: 'post',
			url: soliloquy.ajaxurl,
			async: true,
			cache: false,
			dataType: 'json',
			data: {
				action: 'soliloquy_fc_refresh_posts',
				nonce: soliloquy_fc.post_nonce,
				post_type: posttype,
				id: soliloquy_fc.id
			},
			success: function(json){
				if ( typeof json.error !== "undefined" ) {
					$('.soliloquy-waiting-posts').remove();
					$('#soliloquy-fc-include-exclude option:selected').removeAttr('selected').trigger('change').trigger('liszt:updated');
					$('#soliloquy-fc-include-exclude-box').fadeOut();
				} else {
					$('#soliloquy-fc-include-exclude-box').fadeIn('normal', function(){
						$('.soliloquy-waiting-posts').remove();
						$('#soliloquy-fc-include-exclude').empty().append(json).trigger('change').trigger('liszt:updated');
					});
				}
			},
			error: function(xhr){
				$('.soliloquy-waiting-posts').remove();
			}
		}
		$.ajax(opts);
	}

	function soliloquyFcRefreshPostsCond(posttype){
		var opts = {
			type: 'post',
			url: soliloquy.ajaxurl,
			async: true,
			cache: false,
			dataType: 'json',
			data: {
				action: 'soliloquy_fc_refresh_posts',
				nonce: soliloquy_fc.post_nonce,
				post_type: posttype,
				id: soliloquy_fc.id
			},
			success: function(json){
				/** We only need to update the list of posts to chose from based on the user selection on page load */
				if ( typeof json.error !== "undefined" ) {
					$('#soliloquy-fc-include-exclude-box').hide();
					return;
				} else {
					/** Grab all currently chosen items and repopulate them */
					$('#soliloquy-fc-include-exclude-box').show();
					$('#soliloquy-fc-include-exclude').empty().append(json);
					$('#soliloquy_fc_include_exclude_chzn .chzn-results li.result-selected').each(function(){
						var el = $(this);
						$('#soliloquy-fc-include-exclude option').each(function(){
							if ( $(this).text() == el.text() )
								$(this).attr('selected', 'selected');
						});
					});
					$('#soliloquy-fc-include-exclude').trigger('change').trigger('liszt:updated');
				}
			},
			error: function(xhr){
			}
		}
		$.ajax(opts);
	}

});