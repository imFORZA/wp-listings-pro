console.log("here");

// Thus far, it loads the wordpress media renderer, and it allows you to add/remove photos

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
  console.log("herorine");
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

// function renderMediaUploader() {
//     'use strict';
//
//     var file_frame, image_data;
//
//     /**
//      * If an instance of file_frame already exists, then we can open it
//      * rather than creating a new instance.
//      */
//     if ( undefined !== file_frame ) {
//
//         file_frame.open();
//         return;
//
//     }
//
//     /**
//      * If we're this far, then an instance does not exist, so we need to
//      * create our own.
//      *
//      * Here, use the wp.media library to define the settings of the Media
//      * Uploader. We're opting to use the 'post' frame which is a template
//      * defined in WordPress core and are initializing the file frame
//      * with the 'insert' state.
//      *
//      * We're also not allowing the user to select more than one image.
//      */
//     file_frame = wp.media.frames.file_frame = wp.media({
//         frame:    'post',
//         state:    'insert',
//         multiple: false
//     });
//
//     /**
//      * Setup an event handler for what to do when an image has been
//      * selected.
//      *
//      * Since we're using the 'view' state when initializing
//      * the file_frame, we need to make sure that the handler is attached
//      * to the insert event.
//      */
//     file_frame.on( 'insert', function() {
//
//         /**
//          * We'll cover this in the next version.
//          */
//
//     });
//
//     // Now display the actual file_frame
//     file_frame.open();
//
// }
//
// (function( $ ) {
//     'use strict';
//
//     $(function() {
//         $( '#set-footer-thumbnail' ).on( 'click', function( evt ) {
//
//             // Stop the anchor's default behavior
//             evt.preventDefault();
//
//             // Display the media uploader
//             renderMediaUploader();
//
//         });
//
//     });
// }
