jQuery(document).ready(function($) {
	/* === Begin listing importer JS. === */

	var $container = jQuery('.grid');
	$container.imagesLoaded(function(){
		$container.masonry({
			columnWidth: '.grid-sizer',
			itemSelector: '.grid-item'
		});
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
			url: DeleteAgentAjax.ajaxurl,
			data: {
				action: 'impa_idx_agent_delete',
				nonce: nonce,
				id: id
			},
			success: function( result ) {
				if( result == 'success' ) {
					post.fadeOut( function(){
						post.remove();
						grid.masonry('layout');
					});
				}
			}
		});
		return false;
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
});
