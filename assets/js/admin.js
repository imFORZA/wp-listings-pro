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

var listing_doc_gallery_frame = new Object();
var doc_gallery_link        = '.add_listing_docs';
var doc_gallery_id          = '#listing_doc_gallery';
var doc_gallery_container   = '#listing_docs_container';
var doc_gallery_listing     = 'ul.listing_docs';
var doc_types               = ["doc", "docx", "xls", "xlsx", "pdf"];

var selected = "";
jQuery(document).ready(function($) {
	// Instantiate the media selector tool, and attach all necessary event listeners
	foobar_gallery_popup(listing_image_gallery_frame, image_gallery_link, image_gallery_id, image_gallery_container, image_gallery_listing, true, image_types);
	foobar_gallery_popup(listing_doc_gallery_frame, doc_gallery_link, doc_gallery_id, doc_gallery_container, doc_gallery_listing, false, doc_types);

	jQuery("#wplpro_custom_inputs").attr("disabled", true);
	// Save dismiss state
	jQuery( '.notice.is-dismissible' ).on('click', '.notice-dismiss', function ( event ) {
		event.preventDefault();
		var $this = jQuery(this);
		if( ! $this.parent().data( 'key' ) ){
			return;
		}
		jQuery.post( wp_listings_adminL10n.ajaxurl, {
			action: "WPLPRO_Admin_Notice",
			url: wp_listings_adminL10n.ajaxurl,
			nag: $this.parent().data( 'key' ),
			nonce: wp_listings_adminL10n.othernonce || ''
		});
	});

	jQuery(document).on( 'click', '.submit-imports-button', function(event){
														// Can one truly prevent nature's course?
		event.preventDefault(); // Yes. Yes they can.
		var all = jQuery('.selected').contents();
		var mlses = [];
		for(var i=0; i<all.length;i++){
			if(all[i].id){
				mlses[mlses.length] = all[i].id;
			}
		}
		mlses = mlses.join(','); // probably not the cleanest way of doing this...
		jQuery.ajax({
			type : "get",
			dataType: "json",
			url: "/wp-json/wp-listings-pro/v1/import-listings/?mlses=" + mlses,
			data: {
				mlses: mlses
			},
			beforeSend:function( xhr ){
				xhr.setRequestHeader( 'X-WP-Nonce', wp_listings_adminL10n.nonce);
			},
			success:function(response){
				window.location.reload();
				console.log(response);
			},
			error:function(response){
				console.log(response);
			}
		});
	})

	// Code for changing CSS of elements within masonry for visual effects based on whether they're checked or not, in support of the selectall/deselect all.
	jQuery( '.idx-import-option' ).on('click', function(event){
		setTimeout(cause_html, 100);
	})
	function cause_html(){
		if( jQuery( '#wplpro_idx_update_custom' ).attr('checked')){
			jQuery("#wplpro_custom_inputs").attr("disabled", false);
		}else if(jQuery('#_listing_sync_update_custom').attr("checked")){
			jQuery("#listing_custom_inputs").attr("disabled", false);
		}else{
			jQuery("#wplpro_custom_inputs").attr("disabled", true);
			jQuery("#listing_custom_inputs").attr("disabled", true);
		}
	}
	setTimeout(cause_html, 100);


	// Make notices dismissible - backward compatabity -4.2 - copied from WordPress 4.2
	jQuery( '.notice.is-dismissible' ).each( function() {
		if( wp_listings_adminL10n.wp_version ){
			return;
		}

		var $this = jQuery( this ),
			$button = jQuery( '<button type="button" class="notice-dismiss"><span class="screen-reader-text"></span></button>' ),
			btnText = wp_listings_adminL10n.dismiss || '';

		// Ensure plain text
		$button.find( '.screen-reader-text' ).text( btnText );

		$this.append( $button );

		$button.on( 'click.wp-dismiss-notice', function( event ) {
			event.preventDefault();
			$this.fadeTo( 100 , 0, function() {
				jQuery(this).slideUp( 100, function() {
					jQuery(this).remove();
				});
			});
		});
	});

	/* === Begin listing importer JS. === */

	setTimeout(function(){jQuery(function() {
		jQuery("img.lazy").lazyload({
			event: "scrollstop"
		});
	})}, 600);

	var $container = jQuery('.grid');
	$container.imagesLoaded(function(){
		$container.masonry({
			columnWidth: '.grid-sizer',
			itemSelector: '.grid-item'
		});
	});

	// mine feat. Finding Nemo
	jQuery(document).on( 'click', '.delete-listing', function(){
		var el = jQuery(this);
		var id = el.data('id');
		var post = el.parents('.post:first');
		var grid = jQuery('.grid').masonry({
			columnWidth: '.grid-sizer',
			itemSelector: '.grid-item'
		});
		jQuery.ajax({
			type : "post",
			dataType: "json",
			url: "/wp-json/wp-listings-pro/v1/delete-listing/?id=" + id,
			data: {
				id: id
			},
			beforeSend:function( xhr ){
				xhr.setRequestHeader( 'X-WP-Nonce', wp_listings_adminL10n.nonce);
			},
			success:function(response){
				el.parent().removeClass("imported selected");
				el.parent().find("input.checkbox").removeAttr('checked');
				el.parent().find("span.imported").remove();
				el.remove(); // Has to be done last, since it IS the jQuery(this) that is being referred to.)
			},
			error:function(response){
				console.log(response);
			}
		});
	})

	// mine feat. Finding Nemo
	jQuery(document).on( 'click', '#sync-idx-settings-now', function(e){
		console.log(e);
		e.preventDefault();
		jQuery.ajax({
			type : "get",
			dataType: "json",
			url: "/wp-json/wp-listings-pro/v1/sync-all",
			beforeSend:function( xhr ){
				xhr.setRequestHeader( 'X-WP-Nonce', wp_listings_adminL10n.nonce);
			}
		});
		window.location.reload();
	})

	jQuery(document).on( 'click', '.delete-agent', function() {
		var el = jQuery(this);
		var id = el.data('id');
		var nonce = el.data('nonce');
		var post = el.parents('.post:first');
		var grid = jQuery('.grid').masonry({
			columnWidth: '.grid-sizer',
			itemSelector: '.grid-item'
		});
		jQuery.ajax({
			type: 'post',
			url: 'admin-ajax.php?action=impa_idx_agent_delete&id=' + id + '&nonce=' + nonce  ,
			data: {
				action: 'impa_idx_agent_delete',
				nonce: nonce,
				id: id
			},
			beforeSend:function( xhr ){
				xhr.setRequestHeader( 'X-WP-Nonce', wp_listings_adminL10n.nonce);
			},
			success: function( result ) {
				el.parent().parent().removeClass("imported selected");
				el.parent().parent().find("input.checkbox").removeAttr('checked');
				el.parent().find("span.imported").remove();
				el.remove(); // Has to be done last, since it IS the jQuery(this) that is being referred to.)
			},
			error: function( result) {
				console.log(result);
			}
		});
		//return false;
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
			jQuery.ajax({
				type: 'post',
				url: 'admin-ajax.php?action=wp_listings_idx_delete_all&nonce=' + nonce,
				data: {
					action: 'wp_listings_idx_listing_delete_all',
					nonce: nonce
				},
				success: function( result ) {
					// window.location.reload();
				}
			});
		} else {
			return false;
		}

	});

	// Make sure labels are drawn in the correct state.
	jQuery('li').each(function()
	{

		if (jQuery(this).find(':checkbox').attr('checked'))
			jQuery(this).addClass('selected');

	});

	// Toggle label css when checkbox is clicked.
	jQuery(".idx-listing :not('.imported') .checkbox").click(function(e)
	{

		var checked = jQuery(this).attr('checked');
		jQuery(this).closest('li').toggleClass('selected', checked);

	});
	jQuery('.idx-listing .imported .checkbox').click(function(e){
		e.preventDefault()
	});

	jQuery(".idx-agent :not('.imported') .checkbox").click(function(e)
	{

		var checked = jQuery(this).attr('checked');
		jQuery(this).closest('li').toggleClass('selected', checked);

	});
	jQuery('.idx-agent .imported .checkbox').click(function(e){
		e.preventDefault()
	});

	// Select all.
	jQuery("#selectall").change(function(){
		if(selected === ""){
			jQuery(".checkbox").prop('checked', true);
			jQuery(".idx-listing li").removeClass("selected").addClass("selected"); // Don't want to add doubles.
			jQuery(".idx-agent li").removeClass("selected").addClass("selected");
			selected = "y";
		}else{
			jQuery(".checkbox").prop('checked', false);
			jQuery(".imported .checkbox").prop('checked', true);
			jQuery(".idx-listing li").removeClass("selected");
			jQuery(".idx-agent li").removeClass("selected");
			selected = "";
		}
	});

	/* === End listing importer JS. === */

	/* === Scrollstop event. ===*/
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

/**
 * Function to attach a gallery that is not at all similar to WooCommerce, given varying parameters about it and it's locations.
 * @param  string 				listing_gallery_frame   Global Object to attach media selector tool to, for better user performance on opening and closing the tool repeatedly.
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
	if($image_types === undefined){
    $image_types = [];
  }
  if(use_default_thumbnail === undefined){
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
}//</div>
