console.log("here");

var product_gallery_frame;
var $image_gallery_ids  = jQuery( '#listing_image_gallery' );
var $product_images     = jQuery( '#listing_images_container' ).find( 'ul.listing_images' );
jQuery('.add_listing_images').on('click', 'a', function(event){
  var $el = jQuery( this );

  event.preventDefault();

  // If the media frame already exists, reopen it.
  if ( product_gallery_frame ) {
      product_gallery_frame.open();
      return;
  }

  // Create the media frame.
  product_gallery_frame = wp.media.frames.product_gallery = wp.media({
      // Set the title of the modal.
      title: $el.data( 'choose' ),
      button: {
          text: $el.data( 'update' )
      },
      states: [
          new wp.media.controller.Library({
              title: $el.data( 'choose' ),
              filterable: 'all',
              multiple: true
          })
      ]
  });
  // When an image is selected, run a callback.
  product_gallery_frame.on( 'select', function() {
      console.log("selected");
      var selection = product_gallery_frame.state().get( 'selection' );
      var attachment_ids = $image_gallery_ids.val();

      selection.map( function( attachment ) {
          attachment = attachment.toJSON();

          if ( attachment.id ) {
							var el = attachment.url.split(".")[attachment.url.split(".").length-1];
							console.log(el);
							if(el != "png" && el != "jpg" && el != "jpeg" && el != "gif" && el != "svg"){
								// Potential TODO: replace alert with a popup, and reopen the medie selector tool rather than close it
								alert("Only files ending with a .png, .jpg, .jpeg, .gif, or .svg are accepted in this field.");
								return;
							}
              attachment_ids   = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
							console.log(attachment.url);
              var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

              $product_images.append( '<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li></ul></li>' );
          }
      });

      $image_gallery_ids.val( attachment_ids );
  });

  // Finally, open the modal.
  product_gallery_frame.open();
});

jQuery( '#listing_images_container' ).find( 'ul.listing_images' ).sortable({
	items: 'li.image',
	cursor: 'move',
	scrollSensitivity: 40,
	forcePlaceholderSize: true,
	forceHelperSize: false,
	helper: 'clone',
	opacity: 0.65,
	placeholder: 'wc-metabox-sortable-placeholder',
	start: function( event, ui ) {
		ui.item.css( 'background-color', '#f6f6f6 ' );
	},
	stop: function( event, ui ) {
		ui.item.removeAttr( 'style' );
	},
	update: function() {
		var attachment_ids = '';

		jQuery( '#listing_images_container' ).find( 'ul li.image' ).css( 'cursor', 'default' ).each( function() {
			var attachment_id = jQuery( this ).attr( 'data-attachment_id' );
			attachment_ids = attachment_ids + attachment_id + ',';
		});

		$image_gallery_ids.val( attachment_ids );
	}
});

// Remove images.
jQuery( '#listing_images_container' ).on( 'click', 'a.delete', function() {
	jQuery( this ).closest( 'li.image' ).remove();

	var attachment_ids = '';

	jQuery( '#listing_images_container' ).find( 'ul li.image' ).css( 'cursor', 'default' ).each( function() {
		var attachment_id = jQuery( this ).attr( 'data-attachment_id' );
		attachment_ids = attachment_ids + attachment_id + ',';
	});

	$image_gallery_ids.val( attachment_ids );

	// Remove any lingering tooltips.
	jQuery( '#tiptip_holder' ).removeAttr( 'style' );
	jQuery( '#tiptip_arrow' ).removeAttr( 'style' );

	return false;
});
//
// var $video_gallery_ids  = jQuery( '#listing_video_gallery' );
// var $product_videos     = jQuery( '#listing_videos_container' ).find( 'ul.listing_videos' );
// jQuery('.add_listing_videos').on('click', 'a', function(event){
//   var $el = jQuery( this );
//
//   event.preventDefault();
//
//   // If the media frame already exists, reopen it.
//   if ( product_gallery_frame ) {
//       product_gallery_frame.open();
//       return;
//   }
//
//   // Create the media frame.
//   product_gallery_frame = wp.media.frames.product_gallery = wp.media({
//       // Set the title of the modal.
//       title: $el.data( 'choose' ),
//       button: {
//           text: $el.data( 'update' )
//       },
//       states: [
//           new wp.media.controller.Library({
//               title: $el.data( 'choose' ),
//               filterable: 'all',
//               multiple: true
//           })
//       ]
//   });
//   // When an video is selected, run a callback.
//   product_gallery_frame.on( 'select', function() {
//       console.log("selected");
//       var selection = product_gallery_frame.state().get( 'selection' );
//       var attachment_ids = $video_gallery_ids.val();
//
//       selection.map( function( attachment ) {
//           attachment = attachment.toJSON();
//
//           if ( attachment.id ) {
// 							var el = attachment.url.split(".")[attachment.url.split(".").length-1].toLowerCase();
// 							console.log(el);
// 							if(el != "mp4" && el != "ogg" && el != "flv" && el != "mkv" && el != "3gp" && el != "webm"){
// 								// Potential TODO: replace alert with a popup, and reopen the medie selector tool rather than close it
// 								alert("Only files ending with a .mp4, .ogg, .flv, .mkv, .webm, or .3gp are accepted in this field.");
// 								return;
// 							}
//               attachment_ids   = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
// 							console.log(attachment.url);
//               var attachment_video = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
//
//               $product_videos.append( '<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_video + '" /><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li></ul></li>' );
//           }
//       });
//
//       $video_gallery_ids.val( attachment_ids );
//   });
//
//   // Finally, open the modal.
//   product_gallery_frame.open();
// });
//
// jQuery( '#listing_videos_container' ).find( 'ul.listing_videos' ).sortable({
// 	items: 'li.image',
// 	cursor: 'move',
// 	scrollSensitivity: 40,
// 	forcePlaceholderSize: true,
// 	forceHelperSize: false,
// 	helper: 'clone',
// 	opacity: 0.65,
// 	placeholder: 'wc-metabox-sortable-placeholder',
// 	start: function( event, ui ) {
// 		ui.item.css( 'background-color', '#f6f6f6 ' );
// 	},
// 	stop: function( event, ui ) {
// 		ui.item.removeAttr( 'style' );
// 	},
// 	update: function() {
// 		var attachment_ids = '';
//
// 		jQuery( '#listing_videos_container' ).find( 'ul li.image' ).css( 'cursor', 'default' ).each( function() {
// 			var attachment_id = jQuery( this ).attr( 'data-attachment_id' );
// 			attachment_ids = attachment_ids + attachment_id + ',';
// 		});
//
// 		$video_gallery_ids.val( attachment_ids );
// 	}
// });
//
// // Remove videos.
// jQuery( '#listing_videos_container' ).on( 'click', 'a.delete', function() {
// 	jQuery( this ).closest( 'li.image' ).remove();
//
// 	var attachment_ids = '';
//
// 	jQuery( '#listing_videos_container' ).find( 'ul li.image' ).css( 'cursor', 'default' ).each( function() {
// 		var attachment_id = jQuery( this ).attr( 'data-attachment_id' );
// 		attachment_ids = attachment_ids + attachment_id + ',';
// 	});
//
// 	$video_gallery_ids.val( attachment_ids );
//
// 	// Remove any lingering tooltips.
// 	jQuery( '#tiptip_holder' ).removeAttr( 'style' );
// 	jQuery( '#tiptip_arrow' ).removeAttr( 'style' );
//
// 	return false;
// });
