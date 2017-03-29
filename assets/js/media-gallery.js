var listing_image_gallery_frame = new Object();
var image_gallery_link      = '.add_listing_images';
var image_gallery_id        = '#listing_image_gallery';
var image_gallery_container = '#listing_images_container';
var image_gallery_listing   = 'ul.listing_images';
var image_types             = ["png", "jpg", "jpeg", "gif", "svg"];
foobar_gallery_popup(listing_image_gallery_frame, image_gallery_link, image_gallery_id, image_gallery_container, image_gallery_listing, image_types, true);

var listing_doc_gallery_frame = new Object();
var doc_gallery_link        = '.add_listing_docs';
var doc_gallery_id          = '#listing_doc_gallery';
var doc_gallery_container   = '#listing_docs_container';
var doc_gallery_listing     = 'ul.listing_docs';
var doc_types               = ["doc", "docx", "xls", "xlsx", "pdf"];
foobar_gallery_popup(listing_doc_gallery_frame, doc_gallery_link, doc_gallery_id, doc_gallery_container, doc_gallery_listing, doc_types, false);

function foobar_gallery_popup(listing_gallery_frame, link, gallery_id, listing_image_container, listing_image_class, $image_types = [], use_default_thumbnail = true){
  var $media_gallery_ids  = jQuery( gallery_id );
  var $listing_ul     = jQuery( listing_image_container ).find( listing_image_class );
  jQuery( link ).on('click', 'a', function(event){
    console.log("click!");
    var $el = jQuery( this );

    event.preventDefault();

    // If the media frame already exists, reopen it.
    if ( listing_gallery_frame.a ) {
        console.log("RERUNNING");
        listing_gallery_frame.a.open();
        return;
    }

    // Create the media frame.
    listing_gallery_frame.a = wp.media.frames.listing_image_gallery = wp.media({
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
    listing_gallery_frame.a.on( 'select', function() {
        var selection = listing_gallery_frame.a.state().get( 'selection' );
        var attachment_ids = $media_gallery_ids.val();

        selection.map( function( attachment ) {
            attachment = attachment.toJSON();
            if ( attachment.id && use_default_thumbnail ) {
							var el = attachment.url.split(".")[attachment.url.split(".").length-1];

              // Formatting errors in preparation for eventually turning these blocks into a function.
              var s = check_types($image_types, el);
              if(s != true){
                alert(s);
                return;
              }
              attachment_ids   = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
              var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

              $listing_ul.append( '<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li></ul></li>' );
            }else if ( attachment.id ) { // Cannot use default thumbnail, have to use one of wordpress' icon_dashicons
              var el = attachment.url.split(".")[attachment.url.split(".").length-1].toLowerCase();

              // Formatting errors in preparation for eventually turning these blocks into a function.
              var s = check_types($image_types, el);
              if(s != true){
                alert(s);
                return;
              }

              attachment_ids   = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
              var attachment_doc;
  						if(el == "xls" || el == "xlsx"){
  							attachment_doc = "/wp-includes/images/media/spreadsheet.png";
  						}else{
  							attachment_doc = "/wp-includes/images/media/document.png";
  						}

              $listing_ul.append( '<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_doc + '" /><div class="filename"><div>' + attachment.filename + '</div></div><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li></ul></li>' );
            }
        });

        $media_gallery_ids.val( attachment_ids );
    });

    // Finally, open the modal.
    listing_gallery_frame.a.open();
  });

  // Make sortable.
  jQuery( listing_image_container ).find( listing_image_class ).sortable({
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

  		jQuery( image_gallery_container ).find( 'ul li.image' ).css( 'cursor', 'default' ).each( function() {
  			var attachment_id = jQuery( this ).attr( 'data-attachment_id' );
  			attachment_ids = attachment_ids + attachment_id + ',';
  		});

  		$media_gallery_ids.val( attachment_ids );
  	}
  });

  // Remove images.
  jQuery( listing_image_container ).on( 'click', 'a.delete', function() {
  	jQuery( this ).closest( 'li.image' ).remove();

  	var attachment_ids = '';

  	jQuery( listing_image_container ).find( 'ul li.image' ).css( 'cursor', 'default' ).each( function() {
  		var attachment_id = jQuery( this ).attr( 'data-attachment_id' );
  		attachment_ids = attachment_ids + attachment_id + ',';
  	});

  	$media_gallery_ids.val( attachment_ids );

  	// Remove any lingering tooltips.
  	jQuery( '#tiptip_holder' ).removeAttr( 'style' );
  	jQuery( '#tiptip_arrow' ).removeAttr( 'style' );

  	return false;
  });
}

function check_types(types, el){
  for(var i=0;i<types.length;i++){
    if(el == types[i]){
      return true;
    }else if(i == types.length - 1){
      var s = "Only files ending with a ";
      for(var j=0;j<types.length;j++){
        if(j == types.length-1 && types.length != 1){
          s += " or ";
        }
        s += types[j];
        if(j != types.length-1 && types.length != 2){
          s += ", ";
        }
      }
      s += " extension are accepted in this field.";
      return s;
    }
  }
  return true;
}


// var $video_gallery_ids  = jQuery( '#listing_video_gallery' );
// var $listing_videos     = jQuery( '#listing_videos_container' ).find( 'ul.listing_videos' );
// jQuery('.add_listing_videos').on('click', 'a', function(event){
//   var $el = jQuery( this );
//
//   event.preventDefault();
//
//   // If the media frame already exists, reopen it.
//   if ( listing_gallery_frame ) {
//       listing_gallery_frame.open();
//       return;
//   }
//
//   // Create the media frame.
//   listing_gallery_frame = wp.media.frames.listing_gallery = wp.media({
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
//   listing_gallery_frame.on( 'select', function() {
//       console.log("selected");
//       var selection = listing_gallery_frame.state().get( 'selection' );
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
//               $listing_videos.append( '<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_video + '" /><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li></ul></li>' );
//           }
//       });
//
//       $video_gallery_ids.val( attachment_ids );
//   });
//
//   // Finally, open the modal.
//   listing_gallery_frame.open();
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
//
// var listing_doc_gallery_frame;
// var $doc_types        = ["doc", "docx", "xls", "xlsx", "pdf"];
// var $doc_gallery_ids  = jQuery( '#listing_doc_gallery' );
// var $listing_docs     = jQuery( '#listing_docs_container' ).find( 'ul.listing_docs' );
// jQuery('.add_listing_docs').on('click', 'a', function(event){
//   var $el = jQuery( this );
//
//   event.preventDefault();
//
//   // If the media frame already exists, reopen it.
//   if ( listing_doc_gallery_frame ) {
//       listing_doc_gallery_frame.open();
//       return;
//   }
//
//   // Create the media frame.
//   listing_doc_gallery_frame = wp.media.frames.listing_doc_gallery = wp.media({
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
//   // When an doc is selected, run a callback.
//   listing_doc_gallery_frame.on( 'select', function() {
//       var selection = listing_doc_gallery_frame.state().get( 'selection' );
//       var attachment_ids = $doc_gallery_ids.val();
//
//       selection.map( function( attachment ) {
//           attachment = attachment.toJSON();
//           if ( attachment.id ) {
// 							var el = attachment.url.split(".")[attachment.url.split(".").length-1].toLowerCase();
//               // Formatting errors in preparation for eventually turning these blocks into a function.
//               for(var i=0;i<$doc_types.length;i++){
//                 if(el == $doc_types[i]){
//                   break;
//                 }else if(i == $doc_types.length - 1){
//                   var s = "Only files ending with a ";
//                   for(var j=0;j<$doc_types.length;j++){
//                     if(j == $doc_types.length-1 && $doc_types.length != 1){
//                       s += " or ";
//                     }
//                     s += $doc_types[j];
//                     if(j != $doc_types.length-1 && $doc_types.length != 2){
//                       s += ", ";
//                     }
//                   }
//                   s += " extension are accepted in this field.";
//                   alert(s);
//                   return;
//                 }
//               }
//               attachment_ids   = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
//               //var attachment_doc = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
// 							var attachment_doc;
// 							if(el == "xls" || el == "xlsx"){
// 								attachment_doc = "/wp-includes/images/media/spreadsheet.png";
// 							}else{
// 								attachment_doc = "/wp-includes/images/media/document.png";
// 							}
//
//               $listing_docs.append( '<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_doc + '" /><div class="filename"><div>' + attachment.filename + '</div></div><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li></ul></li>' );
//           }
//       });
//
//       $doc_gallery_ids.val( attachment_ids );
//   });
//
//   // Finally, open the modal.
//   listing_doc_gallery_frame.open();
// });
//
// jQuery( '#listing_docs_container' ).find( 'ul.listing_docs' ).sortable({
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
// 		jQuery( '#listing_docs_container' ).find( 'ul li.image' ).css( 'cursor', 'default' ).each( function() {
// 			var attachment_id = jQuery( this ).attr( 'data-attachment_id' );
// 			attachment_ids = attachment_ids + attachment_id + ',';
// 		});
//
// 		$doc_gallery_ids.val( attachment_ids );
// 	}
// });
//
// // Remove docs.
// jQuery( '#listing_docs_container' ).on( 'click', 'a.delete', function() {
// 	jQuery( this ).closest( 'li.image' ).remove();
//
// 	var attachment_ids = '';
//
// 	jQuery( '#listing_docs_container' ).find( 'ul li.image' ).css( 'cursor', 'default' ).each( function() {
// 		var attachment_id = jQuery( this ).attr( 'data-attachment_id' );
// 		attachment_ids = attachment_ids + attachment_id + ',';
// 	});
//
// 	$doc_gallery_ids.val( attachment_ids );
//
// 	// Remove any lingering tooltips.
// 	jQuery( '#tiptip_holder' ).removeAttr( 'style' );
// 	jQuery( '#tiptip_arrow' ).removeAttr( 'style' );
//
// 	return false;
// });
