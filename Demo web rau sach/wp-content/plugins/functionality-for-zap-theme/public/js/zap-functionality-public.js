(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */

})( jQuery );

jQuery(document).ready(function($) {
	jQuery('.projects-categories a').on('click', function() {
		// Change active class
		jQuery('.projects-categories a').removeClass('active');
		jQuery(this).addClass('active');

		// Show project
		jQuery('.project-row').removeClass('project-visible');
		jQuery('.project-row.category-'+jQuery(this).attr('data-category')).addClass('project-visible');

		// Show pagination
		var row_items = jQuery('.project-row.category-'+jQuery(this).attr('data-category')+' .project-row-inner').children().length;
		if ( row_items > 4 ) {
			jQuery('.project-navigation').show();
		} else {
			jQuery('.project-navigation').hide();
		}
	});
	jQuery('[class^="bwg_lightbox_"]').on('click', function() {
		jQuery('body').addClass('hide-on-overlay');
	});
	jQuery(document).keyup(function(e) {
	     if (e.keyCode == 27) {
	        jQuery('body').removeClass('hide-on-overlay');
	    }
	});
	jQuery(document).on('click', '.spider_popup_close, .spider_popup_close_fullscreen', function() {
		jQuery('body').removeClass('hide-on-overlay');
	});
	jQuery(document).on('click', '.single-post-like', function() {
		var post_like = jQuery(this);

		post_like.find('span').html('..');
		jQuery.ajax({
			type: 'POST',
			url: zap_main.ajaxurl,
			data: { 
				'action': 'zap_listing_like',
				'zap_post_id': post_like.attr('data-id'),
			},
			success: function( data ) {
				Cookies.set('zap-liked-'+post_like.attr('data-id'), 'liked', { expires: 365, path: '/' });
				if ( post_like.hasClass('icon-heart-empty') ) {
					post_like.removeClass('icon-heart-empty').addClass('icon-heart-1');
				}
				post_like.find('span').html(data);
			}
		});
	});
});