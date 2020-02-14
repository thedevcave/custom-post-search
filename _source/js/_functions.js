/************************************************************************/
/* JAVASCRIPT FUNCTIONS
/************************************************************************/

function heroAnimation(){
	$("#page_hero .hero-image img").on('load', function(){
		$(this).parents('#page_hero').find('.hero-circle').addClass('active');
	}).each(function(){
		if(this.complete){
			$(this).trigger('load');
		}
	});
}

function floatingLabels(){
	$('.styled-select').each(function(){
		if($(this).find(':selected').val() !== "" && $(this).find(':selected').is(':enabled')){
			$(this).addClass('active');
		}
	});
	
	$('.styled-select').find('select').change(function(){
		//console.log('select has been changed');
		$(this).parents('.styled-select').addClass('active');
	});
	
	$('p.input').find('input').bind('input', function(){
		if($(this).val() !== ''){
			$(this).parents('p.input').addClass('active');
		} else {
			$(this).parents('p.input').removeClass('active');
		}
	});
}

function floorplans() {
	$('.floorplan').click(function(e) {
		var zoomID = $(this).find('.zoom').attr('id');
		var floorplanNum = zoomID.substr(zoomID.length - 1);
		$('#floorplan_overlay'+floorplanNum).fadeIn();
		e.preventDefault();
	});

	$('.floorplans .overlay').click(function(){
		$(this).hide();
	});
	$('.floorplans .close_floorplan').click(function(){
		$('.floorplans .overlay').fadeOut();
	});
}

function sendInfoOverlay(){
	$('.sendinfo').click(function(){
		$('#send_info_overlay').fadeIn().addClass('active');
	});
	$('.overlay-content').click(function(e){
		$('#send_info_overlay').fadeOut().removeClass('active');
	});
	$('.overlay-content article .close').click(function(e){
		$('#send_info_overlay').fadeOut().removeClass('active');
	});
	$('.overlay-content article').click(function(e){
		e.stopPropagation();
	});
	
	if($('#send_info_overlay').length){
		var builder = $('#send_info_overlay').data('builder');
		var builderEmail = $('#send_info_overlay').data('builderemail');
		var model = $('#send_info_overlay').data('model');
		
		$('#send_info_overlay').find('input[name="builder"]').val(builder);
		$('#send_info_overlay').find('input[name="builder_email"]').val(builderEmail);
		$('#send_info_overlay').find('input[name="model"]').val(model);
	}
}

function stayInTouchBuilderEmails(){
	if($('.content-section.stay-in-touch').length){
		var form = $('.content-section.stay-in-touch form');
		var builderEmails = form.parents('article').data('builderemails');
		
		form.find('input[name="builder_emails"]').val(builderEmails);
	}
}

function initCarousels(){
	$('.slider').each(function(){
		var windowWidth = $(window).width(),
				carouselWidth = $(this).parents('.slider-container').width();
				
		if(windowWidth >= 600){
			var sliderItems = 2,
				sliderHeight = 330,
				defaultSize = 0.14,
				activeSize = 0.86;
		} else {
			var sliderItems = 2,
				sliderHeight = 280,
				defaultSize = 0.10,
				activeSize = 0.90;
		}
		console.log("carouselWidth = "+carouselWidth);
		console.log("default slide width = "+carouselWidth * defaultSize);
		console.log("active slide width = "+carouselWidth * activeSize);
		
		$(this).carouFredSel({
			auto: false,
			width: '100%',
			align: false,
			items: sliderItems,
			items: {
				width: carouselWidth * defaultSize,
				height: sliderHeight,
				visible: 1,
				minimum: 1
			},
			scroll: {
				items: 1,
				timeoutDuration : 5000,
				onBefore: function(data) {
		
					//	find current and next slide
					var currentSlide = $('.slide.active', this),
						nextSlide = data.items.visible,
						_width = $('.slider-container').width();
		
					//	resize currentslide to small version
					currentSlide.stop().animate({
						width: _width * defaultSize
					});		
					currentSlide.removeClass( 'active' );
		
					//	hide current block
					data.items.old.add( data.items.visible ).find( '.slide-block' ).stop().fadeOut();					
		
					//	animate clicked slide to large size
					nextSlide.addClass( 'active' );
					nextSlide.stop().animate({
						width: _width * activeSize
					});						
				},
				onAfter: function(data) {
					//	show active slide block
					data.items.visible.last().find( '.slide-block' ).stop().fadeIn();
				}
			},
			onCreate: function(data){
		
				//	clone images for better sliding and insert them dynamacly in slider
				var newitems = $('.slide',this).clone( true ),
					_width = $(this).parents('.slider-container').width();
		
				$(this).trigger( 'insertItem', [newitems, newitems.length, false] );
		
				//	show images 
				$('.slide', this).fadeIn();
				$('.slide:first-child', this).addClass( 'active' );
				$('.slide', this).width( _width * defaultSize );
		
				//	enlarge first slide
				$('.slide:first-child', this).animate({
					width: _width * activeSize
				});
		
				//	show first title block and hide the rest
				$(this).find( '.slide-block' ).hide();
				$(this).find( '.slide.active .slide-block' ).stop().fadeIn();
			}
		});
	});
	
	//	Handle click events
	$('.slider').children().click(function() {
		//console.log('image preview clicked');
		slideIndex = $(this).data('index');
		console.log(slideIndex);
		$(this).parents('.slider').trigger( 'slideTo', slideIndex );
	});
	$('.slider-next').click(function(){
		//console.log('slider next button clicked');
		slideIndex = $(this).parents('.slide').data('index');
		$(this).parents('.slider').trigger( 'slideTo', slideIndex );
	});
	
	//	Enable code below if you want to support browser resizing
	$(window).resize(function(){
		
		$('.slider').each(function(){	
			var slider = $(this),
				_width = $(this).parents('.slider-container').width();
			
			if(slider.hasClass('large')){
				var defaultSize = 0.15,
					activeSize = 0.7;
			} else {
				var defaultSize = 0.14,
					activeSize = 0.86;
			}
		
			//	show images
			slider.find( '.slide' ).width( _width * defaultSize );
		
			//	enlarge first slide
			slider.find( '.slide.active' ).width( _width * activeSize );
		
			//	update item width config
			slider.trigger( 'configuration', ['items.width', _width * defaultSize] );
		});
	});
};

function getHashFilter() {
    var hash = location.hash;
    // get filter=filterName
    var matches = location.hash.match( /filter=([^&]+)/i );
    var hashFilter = matches && matches[1];
    return hashFilter && decodeURIComponent( hashFilter );
}

function gridInit(){
        
    var $grid = $('.grid-results');
    
    // bind filter button click
    var $filters = $('.grid-filters').on('click', '.grid-filter', function(){
        var filterAttr = $(this).data('filter');
        // set filter in the hash
        location.hash = 'filter=' + encodeURIComponent( filterAttr );
    })
    
    var isIsotopeInit = false;
    
    function onHashChange() {
        // Check to ensure isotope exists on the current page
        if ( $.isFunction($.fn.isotope) ) {
            var hashFilter = getHashFilter();
            var sessionHash = localStorage['sessionHash'];
            if( !hashFilter && isIsotopeInit ){
                Cookies.set('sessionHash', '*');
                return;
            }
            isIsotopeInit = true;
            Cookies.set('sessionHash', hashFilter);
            //console.log(Cookies.get('sessionHash'));
        
            // filter isotope
            $grid.isotope({
                itemSelector: '.grid-block',
                filter: hashFilter,
                percentPosition: true,
                layoutMode: 'fitRows',
                fitRows: {
                    columnWidth: '.grid-block',
                    gutter: 12
                },
                getSortData: {
	                title: '.title'
                },
                sortBy: 'title'
            });
            
            // set active class on filter
            if ( hashFilter ){
                $filters.find('.active').removeClass('active');
                $filters.find('[data-filter="' + hashFilter + '"]').addClass('active');
                $('.grid-filter-toggle').find('span').text($filters.find('[data-filter="' + hashFilter + '"]').text());
            }
        };
    }
    
    $(window).on( 'hashchange', onHashChange );
    $(window).on( 'load', onHashChange );
    // trigger event handler to init Isotope
    onHashChange();
    
    
}
function mobileGridToggle(){
    // mobile grid filter toggle
    $('.grid-filter-toggle').on('click', function(){
        $('.grid-filters').stop().slideToggle().toggleClass('open');
        $(this).find('.fa').toggleClass('fa-angle-down fa-angle-up');
    });
    
    $('.grid').on('click', '.grid-filters.open .grid-filter', function(){
        if($('.grid-filter-toggle').is(':visible')){
            $('.grid-filters').stop().slideToggle('fast').toggleClass('open');
            $('.grid-filter-toggle').find('.fa').toggleClass('fa-angle-down fa-angle-up');
        }
    })    
}
function backToGridHash(){    
    // add hash to back to grid button
    if($('nav#back_nav.grid').length){
        var backLink = $('nav#back_nav a').attr('href');
        var backHash = encodeURIComponent( Cookies.get('sessionHash') );
                
        $('nav#back_nav a').attr('href', backLink + "#filter=" + backHash);
    }
}


function builderPopupForm(){
	if($('#builder_popup_form').length){
		var popupActive = false,
			popup = $('#builder_popup_form'),
			builder = popup.data('builder'),
			builderEmail = popup.data('builderemail'),
			exitIntent = popup.data('exit'),
			scroll50 = popup.data('scroll'),
			timedDelay = popup.data('timed'),
			delayLength = popup.data('delay'),
			dismissedTimer = popup.data('dismiss'),
			popupCookie = Cookies.get('builder_popup_dismiss');
		
		popup.find('span.builder').text(builder);
		popup.find('input[name="builder"]').val(builder);
		popup.find('input[name="builder_email"]').val(builderEmail);
		
		if(exitIntent === true){
			// Exit intent
			function addEvent(obj, evt, fn) {
			  if (obj.addEventListener) {
			    obj.addEventListener(evt, fn, false);
			  } else if (obj.attachEvent) {
			    obj.attachEvent("on" + evt, fn);
			  }
			}

			// Exit intent trigger
			addEvent(document, 'mouseout', function(evt) {
				if (evt.toElement === null && evt.relatedTarget === null && popupActive === false && popupCookie != 'true') {
		            popup.fadeToggle().toggleClass('active');
			        popupActive = true;
		        }
		    });
		}
		if(scroll50 === true){
			var documentHeight = $(document).outerHeight(),
				windowHeight = $(window).outerHeight();
			
			$(window).scroll(function(){
				if($(window).scrollTop() >= (documentHeight / 2 - (windowHeight / 2)) && popupActive === false && popupCookie != 'true'){
					popup.fadeToggle().toggleClass('active');
			        popupActive = true;
				}
			});
		}
		if(timedDelay === true && delayLength != '' && popupCookie != 'true'){
			setTimeout(function(){
				if(popupActive === false){
					popup.fadeToggle().toggleClass('active');
			        popupActive = true;
			    }
			}, (delayLength * 1000));
		}
		
		$('#builder_popup_form .toggle-btn').on('click', function(){
			popup.find('.wpcf7').slideToggle();
			$(this).hide();
		})
		
		$('#builder_popup_form .close').on('click', function(){
			popup.fadeOut().removeClass('active');
			Cookies.set('builder_popup_dismiss', true, { expires: dismissedTimer });
		})
	}
}