// Example formatting for making image media selector tool
// Global object to attach frame to
var listing_image_gallery_frame = new Object();
// <a> tag to attach the onclick listener to for opening the media selector
var image_gallery_link      = '.add_listing_images';
// ID of sub container that holds the list (should be a form)
var image_gallery_id        = '#listing_image_gallery';
// <div> container to contain all events pertinent to this instance of the media selector
var image_gallery_container = '#listing_images_container';
// subclass for where each entity in the gallery should be stored
var image_gallery_listing   = 'ul.listing_images';
// Acceptable file extensions (NOTE DOES NOT CHECK ANY MORE DEEPLY THAN THE NAME OF THE FILE, IF PEOPLE RENAMED PIPEBOMB.BAT TO FRIENDLYPONIES.PNG, IT WILL BE ACCEPTED).
var image_types             = ["png", "jpg", "jpeg", "gif", "svg"];

// Instantiate the media selector tool, and attach all necessary event listeners
foobar_gallery_popup(listing_image_gallery_frame, image_gallery_link, image_gallery_id, image_gallery_container, image_gallery_listing, true, image_types);

var listing_doc_gallery_frame = new Object();
var doc_gallery_link        = '.add_listing_docs';
var doc_gallery_id          = '#listing_doc_gallery';
var doc_gallery_container   = '#listing_docs_container';
var doc_gallery_listing     = 'ul.listing_docs';
var doc_types               = ["doc", "docx", "xls", "xlsx", "pdf"];
foobar_gallery_popup(listing_doc_gallery_frame, doc_gallery_link, doc_gallery_id, doc_gallery_container, doc_gallery_listing, false, doc_types);

/**
 * Function to attach a gallery that is not at all similar to WooCommerce, given varying parameters about.
 * @param  string 				listing_gallery_frame   Global Object to attach media selector tool to, for better user performance on multiple openings of tool.
 * @param  string 				link                    HTML Class of the (<a>) element to attach the onClick event to fire the selector tool to.
 * @param  string 				gallery_id              HTML ID of the gallery to store added objects to
 * @param  string 				listing_image_container HTML ID of the container (<div>) within which everything will happen, and we will look for each element
 * @param  string  				listing_image_class     HTML Class of the subelement for the ul list of which each element will be added as
 * @param  boolean 				use_default_thumbnail   Whether to use default WordPress DashIcons or attempt to pull thumbnails from the item itself (recommended false for non-images, default = false)
 * @param  array[string] 	$image_types            Acceptable file extensions (if empty, all file types will be accepted, default = [])
 * @return null
 */
function foobar_gallery_popup(listing_gallery_frame, link, gallery_id, listing_image_container, listing_image_class, use_default_thumbnail, $image_types){
	// Checking for default parameters
	if($image_types == undefined){
    $image_types = [];
  }
  if(use_default_thumbnail == undefined){
    use_default_thumbnail = false;
  }
  var $media_gallery_ids  = jQuery( gallery_id );
  var $listing_ul     = jQuery( listing_image_container ).find( listing_image_class );

	// Assigning onclick event to given item
	jQuery( link ).on('click', 'a', function(event){
    var $el = jQuery( this );

    event.preventDefault();

    // If the media frame already exists, reopen it.
    if ( listing_gallery_frame.a ) {
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

							// Check whether given type is contained within list of given types
							var s = check_types($image_types, el);
              if(s != true){
                wrong_filetype(s);
                return;
              }

							// Assign IDs to each added element for storage of the gallery into postmeta
              attachment_ids   = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
              var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

              $listing_ul.append( '<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li></ul></li>' );
            }else if ( attachment.id ) { // Cannot use default thumbnail, have to use one of wordpress' icon_dashicons
              var el = attachment.url.split(".")[attachment.url.split(".").length-1].toLowerCase();

              // Formatting errors in preparation for eventually turning these blocks into a function.
              var s = check_types($image_types, el);
              if(s != true){
                wrong_filetype(s);
                return;
              }

              attachment_ids   = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
              var attachment_doc;
							// TODO: add more types for other spreadsheets, ie videos, or whatnot
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

  // Apply remove images button.
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
/**
 * Function to output a given error log, and scroll to the top of the page (specifically for if a wrong file type is added)
 * @param  string 	s Error message.
 * @return null
 */
function wrong_filetype(s){
	jQuery('.wrong-filetype').remove();
	jQuery('<div class="notice notice-error wrong-filetype"><h2>' + s + '</h2></div>').insertAfter( jQuery(".wp-header-end") );
	jQuery("html, body").animate({ scrollTop: 0}, "fast");
}

/**
 * Function for comparing a given element to a given list and seeing if it is contained.
 * If the given list is empty, it will return true.
 * @param  array[] 	types Array of entities to cross check the element with.
 * @param  var 			el		Given element, to check whether or not is contained in list.
 * @return var			      If element is contained in list (or list is empty), will return (true). Else, will return a formatted error message with possible types.
 */
function check_types(types, el){
  for(var i=0;i<types.length;i++){
    if(el == types[i]){ // Found it, THE SEARCH IS OVER. Soft equals is intentional here.
      break;
    }else if(i === types.length - 1){ // At last element.
      var s = "Only files ending with a ";

			// Generate pretty string.
      for(var j=0;j<types.length;j++){
				// At last element and it's not the first element, add an or
        if(j === types.length-1 && types.length !== 1){
          s += " or ";
        }
        s += types[j];
				// If not at last element and there's not two elements total, we need commas
        if(j !== types.length-1 && types.length !== 2){
          s += ", ";
        }
      }

			// Specfically for this case.
      s += " extension are accepted in this field.";
      return s;
    }
  }
  return true;
}
