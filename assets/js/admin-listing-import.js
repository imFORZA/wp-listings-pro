jQuery(document).ready(function($) {
	/* === Begin listing importer JS. === */

	jQuery(function() {
		jQuery("img.lazy").lazyload({
			event: "scrollstop"
		});
	});

	jQuery('.grid').masonry({
		columnWidth: '.grid-sizer',
		itemSelector: '.grid-item'
	});

	jQuery(document).on( 'click', '.delete-post', function() {
		var id = jQuery(this).data('id');
		var nonce = jQuery(this).data('nonce');
		var post = jQuery(this).parents('.post:first');
		var grid = jQuery('.grid').masonry({
			columnWidth: '.grid-sizer',
			itemSelector: '.grid-item'
		});
		$.ajax({
			type: 'post',
			url: DeleteListingAjax.ajaxurl,
			data: {
				action: 'wp_listings_idx_listing_delete',
				nonce: nonce,
				id: id
			},
			success: function( result ) {
				if( result === 'success' ) {
					post.fadeOut( function(){
						post.remove();
						grid.masonry('layout');
					});
				}
			}
		});
		return false;
	});

	jQuery(document).on( 'click', '.delete-all', function() {
		var go_ahead = confirm("This will delete all imported listings and their attached images. Are you sure you want to continue?");
		var nonce = jQuery(this).data('nonce');
		var post = jQuery('#selectable').find('.selected');
		var grid = jQuery('.grid').masonry({
			columnWidth: '.grid-sizer',
			itemSelector: '.grid-item'
		});
		if ( go_ahead === true ) {
			$.ajax({
				type: 'post',
				url: DeleteAllListingAjax.ajaxurl,
				data: {
					action: 'wp_listings_idx_listing_delete_all',
					nonce: nonce,
				},
				success: function( result ) {
					if( result === 'success' ) {
						post.fadeOut( function(){
							post.remove();
							grid.masonry('layout');
						});
					}
				}
			});
			return false;
		} else {
			return false;
		}

	});




	// make sure labels are drawn in the correct state
	jQuery('li').each(function()
	{

		if (jQuery(this).find(':checkbox').attr('checked'))
			jQuery(this).addClass('selected');

	});

	// toggle label css when checkbox is clicked
	jQuery(':checkbox').click(function(e)
	{

		var checked = jQuery(this).attr('checked');
		jQuery(this).closest('li').toggleClass('selected', checked);

	});

	// Select all
	jQuery("#selectall").change(function(){
		jQuery(".checkbox").prop('checked', jQuery(this).prop("checked"));
		jQuery(this).closest('li').addClass('selected');
	});

	/* === End listing importer JS. === */

	/* === Scrollstop event ===*/
	(function(){

		var special = jQuery.event.special,
			uid1 = 'D' + (+new Date()),
			uid2 = 'D' + (+new Date() + 1);

		special.scrollstart = {
			setup: function() {

				var timer,
					handler =  function(evt) {

						var _self = this,
							_args = arguments;

						if (timer) {
							clearTimeout(timer);
						} else {
							evt.type = 'scrollstart';
							jQuery.event.handle.apply(_self, _args);
						}

						timer = setTimeout( function(){
							timer = null;
						}, special.scrollstop.latency);

					};

				jQuery(this).bind('scroll', handler).data(uid1, handler);

			},
			teardown: function(){
				jQuery(this).unbind( 'scroll', jQuery(this).data(uid1) );
			}
		};

		special.scrollstop = {
			latency: 300,
			setup: function() {

				var timer,
						handler = function(evt) {

						var _self = this,
							_args = arguments;

						if (timer) {
							clearTimeout(timer);
						}

						timer = setTimeout( function(){

							timer = null;
							evt.type = 'scrollstop';
							jQuery.event.handle.apply(_self, _args);

						}, special.scrollstop.latency);

					};

				jQuery(this).bind('scroll', handler).data(uid2, handler);

			},
			teardown: function() {
				jQuery(this).unbind( 'scroll', jQuery(this).data(uid2) );
			}
		};

	})();
});
