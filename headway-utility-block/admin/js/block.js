function addHeadings(id) {
	jQuery("#block-" + id + "-tab #sub-tab-social-options-content div[id*='input-social-title']").each(function(e) {
		var e = e + 1;
		jQuery(this).before("<div><h3>Social icon "+ e +"</h3></div>").prev().addClass("social-header");
	});	
}

function addRemoveOptions(value, id) {
	
	if (value.indexOf('logo') >= 0) {
		jQuery('#block-' + id + '-tab #sub-tab-logo-options').fadeIn(200);
	} else {
		jQuery('#block-' + id + '-tab #sub-tab-logo-options').fadeOut(200);
	}
	
	if (value.indexOf('tagline') >= 0) {
		jQuery('#block-' + id + '-tab #sub-tab-tagline-options').fadeIn(200);
	} else {
		jQuery('#block-' + id + '-tab #sub-tab-tagline-options').fadeOut(200);
	}
	
	if (value.indexOf('pagetitle') >= 0) {
		jQuery('#block-' + id + '-tab #sub-tab-pagetitle-options').fadeIn(200);
	} else {
		jQuery('#block-' + id + '-tab #sub-tab-pagetitle-options').fadeOut(200);
	}
	
	if (value.indexOf('social') >= 0) {
		jQuery('#block-' + id + '-tab #sub-tab-social-options').fadeIn(200);
	} else {
		jQuery('#block-' + id + '-tab #sub-tab-social-options').fadeOut(200);
	}
	
	if (value.indexOf('search') >= 0) {
		jQuery('#block-' + id + '-tab #sub-tab-search-options').fadeIn(200);
	} else {
		jQuery('#block-' + id + '-tab #sub-tab-search-options').fadeOut(200);
	}
	
	if (value.indexOf('totop') >= 0) {
		jQuery('#block-' + id + '-tab #sub-tab-totop-options').fadeIn(200);
	} else {
		jQuery('#block-' + id + '-tab #sub-tab-totop-options').fadeOut(200);
	}
	
	if (value.indexOf('menu') >= 0) {
		jQuery('#block-' + id + '-tab #sub-tab-menu-options').fadeIn(200);
	} else {
		jQuery('#block-' + id + '-tab #sub-tab-menu-options').fadeOut(200);
	}
	
	if (value.indexOf('datetime') >= 0) {
		jQuery('#block-' + id + '-tab #sub-tab-datetime-options').fadeIn(200);
	} else {
		jQuery('#block-' + id + '-tab #sub-tab-datetime-options').fadeOut(200);
	}
	
	if (value.indexOf('copyright') >= 0) {
		jQuery('#block-' + id + '-tab #sub-tab-copyright-options').fadeIn(200);
	} else {
		jQuery('#block-' + id + '-tab #sub-tab-copyright-options').fadeOut(200);
	}
	
	if (value.indexOf('page_subtitle') >= 0) {
		jQuery('#block-' + id + '-tab #sub-tab-page_subtitle-options').fadeIn(200);
	} else {
		jQuery('#block-' + id + '-tab #sub-tab-page_subtitle-options').fadeOut(200);
	}
	
}

function showHide(value, block, utility) {
	
	var thisutil = block.find(".block-content ." + utility + "-utility");
	id = thisutil.parent().parent().parent().attr("id");
	
	if (value == 1) {
		block.find(".block-content ." + utility + "-utility").fadeOut(300).delay(2000);
		stylesheet.update_rule("#" + id + " ." + utility + "-utility", {"display": "none"})
	} else {
		stylesheet.update_rule("#" + id + " ." + utility + "-utility", {"display": "block"})
	}
	
}

function togglePositioning(value, block, utility, input) {
	var thisutil = block.find(".block-content ." + utility + "-utility");
	id = thisutil.parent().parent().parent().attr("id");
	forceRight = jQuery("#input-"+ utility +"-options-force-right").find(".input-right img");
	
	if (value == 1) {
		jQuery(input).parent().parent().next().hide();
		jQuery(input).parent().parent().nextAll('#input-'+ utility +'top').hide();
		jQuery(input).parent().parent().nextAll('#input-'+ utility +'left').hide();
		jQuery(input).parent().parent().nextAll('#input-'+ utility +'right').hide();
		stylesheet.update_rule("#" + id + " ." + utility + "-utility", {"position": "static"})
	} else {
		jQuery(input).parent().parent().next().show();
		jQuery(input).parent().parent().nextAll('#input-'+ utility +'top').show();
		if(!forceRight.hasClass("checkbox-checked"))
			jQuery(input).parent().parent().nextAll('#input-'+ utility +'left').show();
		if(forceRight.hasClass("checkbox-checked"))
			jQuery(input).parent().parent().nextAll('#input-'+ utility +'right').show();
		stylesheet.update_rule("#" + id + " ." + utility + "-utility", {"position": "absolute"})
	}
}
