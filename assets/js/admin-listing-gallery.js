jQuery( function( $ ) {

	/**
	 * listing gallery class.
	 */
	var listingGallery = function( $target, args ) {
		this.$target = $target;
		this.$images = jQuery( '.wplpro-listing-gallery__image', $target );

		// No images? Abort.
		if ( 0 === this.$images.length ) {
			return;
		}

		// Make this object available.
		$target.data( 'listing_gallery', this );

		// Pick functionality to initialize...
		this.flexslider_enabled = $.isFunction( $.fn.flexslider ) && wc_single_listing_params.flexslider_enabled;
		this.zoom_enabled       = $.isFunction( $.fn.zoom ) && wc_single_listing_params.zoom_enabled;
		this.photoswipe_enabled = typeof PhotoSwipe !== 'undefined' && wc_single_listing_params.photoswipe_enabled;

		// ...also taking args into account.
		if ( args ) {
			this.flexslider_enabled = false === args.photoswipe_enabled ? false : this.flexslider_enabled;
			this.zoom_enabled       = false === args.zoom_enabled ? false : this.zoom_enabled;
			this.photoswipe_enabled = false === args.photoswipe_enabled ? false : this.photoswipe_enabled;
		}

		// Bind functions to this.
		this.initFlexslider       = this.initFlexslider.bind( this );
		this.initZoom             = this.initZoom.bind( this );
		this.initPhotoswipe       = this.initPhotoswipe.bind( this );
		this.onResetSlidePosition = this.onResetSlidePosition.bind( this );
		this.getGalleryItems      = this.getGalleryItems.bind( this );
		this.openPhotoswipe       = this.openPhotoswipe.bind( this );

		if ( this.flexslider_enabled ) {
			this.initFlexslider();
			$target.on( 'wplpro_gallery_reset_slide_position', this.onResetSlidePosition );
		}

		if ( this.zoom_enabled ) {
			this.initZoom();
			$target.on( 'wplpro_gallery_init_zoom', this.initZoom );
		}

		if ( this.photoswipe_enabled ) {
			this.initPhotoswipe();
		}
	};

	/**
	 * Initialize flexSlider.
	 */
	listingGallery.prototype.initFlexslider = function() {
		var images = this.$images;

		this.$target.flexslider( {
			selector:       '.wplpro-listing-gallery__wrapper > .wplpro-listing-gallery__image',
			animation:      wc_single_listing_params.flexslider.animation,
			smoothHeight:   wc_single_listing_params.flexslider.smoothHeight,
			directionNav:   wc_single_listing_params.flexslider.directionNav,
			controlNav:     wc_single_listing_params.flexslider.controlNav,
			slideshow:      wc_single_listing_params.flexslider.slideshow,
			animationSpeed: wc_single_listing_params.flexslider.animationSpeed,
			animationLoop:  wc_single_listing_params.flexslider.animationLoop, // Breaks photoswipe pagination if true.
			start: function() {
				var largest_height = 0;

				images.each( function() {
					var height = jQuery( this ).height();

					if ( height > largest_height ) {
						largest_height = height;
					}
				} );

				images.each( function() {
					jQuery( this ).css( 'min-height', largest_height );
				} );
			}
		} );
	};

	/**
	 * Init zoom.
	 */
	listingGallery.prototype.initZoom = function() {
		var zoomTarget   = this.$images,
			galleryWidth = this.$target.width(),
			zoomEnabled  = false;

		if ( ! this.flexslider_enabled ) {
			zoomTarget = zoomTarget.first();
		}

		jQuery( zoomTarget ).each( function( index, target ) {
			var image = jQuery( target ).find( 'img' );

			if ( image.attr( 'width' ) > galleryWidth ) {
				zoomEnabled = true;
				return false;
			}
		} );

		// But only zoom if the img is larger than its container.
		if ( zoomEnabled ) {
			zoomTarget.trigger( 'zoom.destroy' );
			zoomTarget.zoom( {
				touch: false
			} );
		}
	};

	/**
	 * Init PhotoSwipe.
	 */
	listingGallery.prototype.initPhotoswipe = function() {
		if ( this.zoom_enabled && this.$images.length > 0 ) {
			this.$target.prepend( '<a href="#" class="wplpro-listing-gallery__trigger">🔍</a>' );
			this.$target.on( 'click', '.wplpro-listing-gallery__trigger', this.openPhotoswipe );
		}
		this.$target.on( 'click', '.wplpro-listing-gallery__image a', this.openPhotoswipe );
	};

	/**
	 * Reset slide position to 0.
	 */
	listingGallery.prototype.onResetSlidePosition = function() {
		this.$target.flexslider( 0 );
	};

	/**
	 * Get listing gallery image items.
	 */
	listingGallery.prototype.getGalleryItems = function() {
		var $slides = this.$images,
			items   = [];

		if ( $slides.length > 0 ) {
			$slides.each( function( i, el ) {
				var img = jQuery( el ).find( 'img' ),
					large_image_src = img.attr( 'data-large_image' ),
					large_image_w   = img.attr( 'data-large_image_width' ),
					large_image_h   = img.attr( 'data-large_image_height' ),
					item            = {
						src: large_image_src,
						w:   large_image_w,
						h:   large_image_h,
						title: img.attr( 'title' )
					};
				items.push( item );
			} );
		}

		return items;
	};

	/**
	 * Open photoswipe modal.
	 */
	listingGallery.prototype.openPhotoswipe = function( e ) {
		e.preventDefault();

		var pswpElement = jQuery( '.pswp' )[0],
			items       = this.getGalleryItems(),
			eventTarget = jQuery( e.target ),
			clicked;

		if ( ! eventTarget.is( '.wplpro-listing-gallery__trigger' ) ) {
			clicked = eventTarget.closest( '.wplpro-listing-gallery__image' );
		} else {
			clicked = this.$target.find( '.flex-active-slide' );
		}

		var options = {
			index:                 jQuery( clicked ).index(),
			shareEl:               false,
			closeOnScroll:         false,
			history:               false,
			hideAnimationDuration: 0,
			showAnimationDuration: 0
		};

		// Initializes and opens PhotoSwipe.
		var photoswipe = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options );
		photoswipe.init();
	};

	/**
	 * Function to call wc_listing_gallery on jquery selector.
	 */
	$.fn.wc_listing_gallery = function( args ) {
		new listingGallery( this, args );
		return this;
	};

	/*
	 * Initialize all galleries on page.
	 */
	jQuery( '.wplpro-listing-gallery' ).each( function() {
		jQuery( this ).wc_listing_gallery();
	} );


	// Uploading files.
	var downloadable_file_frame;
	var file_path_field;

	jQuery( document.body ).on( 'click', '.upload_file_button', function( event ) {
		var $el = jQuery( this );

		file_path_field = $el.closest( 'tr' ).find( 'td.file_url input' );

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( downloadable_file_frame ) {
			downloadable_file_frame.open();
			return;
		}

		var downloadable_file_states = [
			// Main states.
			new wp.media.controller.Library({
				library:   wp.media.query(),
				multiple:  true,
				title:     $el.data('choose'),
				priority:  20,
				filterable: 'uploaded'
			})
		];

		// Create the media frame.
		downloadable_file_frame = wp.media.frames.downloadable_file = wp.media({
			// Set the title of the modal.
			title: $el.data('choose'),
			library: {
				type: ''
			},
			button: {
				text: $el.data('update')
			},
			multiple: true,
			states: downloadable_file_states
		});

		// When an image is selected, run a callback.
		downloadable_file_frame.on( 'select', function() {
			var file_path = '';
			var selection = downloadable_file_frame.state().get( 'selection' );

			selection.map( function( attachment ) {
				attachment = attachment.toJSON();
				if ( attachment.url ) {
					file_path = attachment.url;
				}
			});

			file_path_field.val( file_path ).change();
		});

		// Set post to 0 and set our custom type.
		downloadable_file_frame.on( 'ready', function() {
			downloadable_file_frame.uploader.options.uploader.params = {
				type: 'downloadable_listing'
			};
		});

		// Finally, open the modal.
		downloadable_file_frame.open();
	});

	// Download ordering.
	jQuery( '.downloadable_files tbody' ).sortable({
		items: 'tr',
		cursor: 'move',
		axis: 'y',
		handle: 'td.sort',
		scrollSensitivity: 40,
		forcePlaceholderSize: true,
		helper: 'clone',
		opacity: 0.65
	});

	// listing gallery file uploads.
	var listing_gallery_frame;
	var $image_gallery_ids = jQuery( '#listing_image_gallery' );
	var $listing_images    = jQuery( '#listing_images_container' ).find( 'ul.listing_images' );

	jQuery( '.add_listing_images' ).on( 'click', 'a', function( event ) {
		var $el = jQuery( this );

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( listing_gallery_frame ) {
			listing_gallery_frame.open();
			return;
		}

		// Create the media frame.
		listing_gallery_frame = wp.media.frames.listing_gallery = wp.media({
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
		listing_gallery_frame.on( 'select', function() {
			var selection = listing_gallery_frame.state().get( 'selection' );
			var attachment_ids = $image_gallery_ids.val();

			selection.map( function( attachment ) {
				attachment = attachment.toJSON();

				if ( attachment.id ) {
					attachment_ids   = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
					var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

					$listing_images.append( '<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li></ul></li>' );
				}
			});

			$image_gallery_ids.val( attachment_ids );
		});

		// Finally, open the modal.
		listing_gallery_frame.open();
	});

	// Image ordering.
	$listing_images.sortable({
		items: 'li.image',
		cursor: 'move',
		scrollSensitivity: 40,
		forcePlaceholderSize: true,
		forceHelperSize: false,
		helper: 'clone',
		opacity: 0.65,
		placeholder: 'wc-metabox-sortable-placeholder',
		start: function( event, ui ) {
			ui.item.css( 'background-color', '#f6f6f6' );
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


} );
