jQuery(function($){
jQuery('div.default-feat-image').find('a').contents().unwrap();
var REAL = window.REAL || {};
/* ==================================================
	Contact Form Validations
================================================== */
	REAL.ContactForm = function(){
		$('.contact-form').each(function(){
			var formInstance = $(this);
			formInstance.submit(function(){
		
			var action = $(this).attr('action');
		
			$("#message").slideUp(750,function() {
			$('#message').hide();
		
			$('#submit')
				.after('<img src="' + $('#image_path').val() + 'images/assets/ajax-loader.gif" class="loader" />')
				.attr('disabled','disabled');
		
			$.post(action, {
				name: $('#name').val(),
				email: $('#email').val(),
				phone: $('#phone').val(),
				comments: $('#comments').val(),
                subject: $('#subject').val(),
                admin_email: $('#admin_email').val(),
			},
				function(data){
					document.getElementById('message').innerHTML = data;
					$('#message').slideDown('slow');
					$('.contact-form img.loader').fadeOut('slow',function(){$(this).remove()});
					$('#submit').removeAttr('disabled');
					if(data.match('success') != null) $('.contact-form').slideUp('slow');
		
				}
			);
			});
			return false;
		});
		});
	}
	
/* ==================================================
	Agent Contact Form Validations
================================================== */
	REAL.AgentContactForm = function(){
		$('.agent-contact-form').each(function(){
			var formInstance = $(this);
			formInstance.submit(function(){
		
			var action = $(this).attr('action');
		
			$("#message").slideUp(750,function() {
			$('#message').hide();
		
			$('#submit')
				.after('<img src="' + $('#image_path').val() + 'images/assets/ajax-loader.gif" class="loader" />')
				.attr('disabled','disabled');
		
			$.post(action, {
				email: $('#email').val(),
				comments: $('#comments').val(),
                                agent_email: $('#agent_email').val(),
								subject: $('#subject').val(),
			},
				function(data){
					document.getElementById('message').innerHTML = data;
					$('#message').slideDown('slow');
					$('.agent-contact-form img.loader').fadeOut('slow',function(){$(this).remove()});
					$('#submit').removeAttr('disabled');
					if(data.match('success') != null) $('.agent-contact-form').slideUp('slow');
		
				}
			);
			});
			return false;
		});
		});
	}	
	
/* ==================================================
	Responsive Nav Menu
================================================== */
	REAL.navMenu = function() {
		// Responsive Menu Events
		$(".menu-toggle").click(function(){
			$(".main-menu-wrapper").slideToggle();
			$(".menu-toggle").toggleClass('opened');
			return false;
		});
		$(window).resize(function(){
			if($(".menu-toggle").hasClass("opened")){
				$(".main-menu-wrapper").css("display","block");
			} else {
				$(".menu-toggle").css("display","none");
			}
		});
	}
/* ==================================================
	Scroll to Top
================================================== */
	REAL.scrollToTop = function(){
		var windowWidth = $(window).width(),
			didScroll = false;
	
		var $arrow = $('#back-to-top');
	
		$arrow.click(function(e) {
			$('body,html').animate({ scrollTop: "0" }, 750, 'easeOutExpo' );
			e.preventDefault();
		})
	
		$(window).scroll(function() {
			didScroll = true;
		});
	
		setInterval(function() {
			if( didScroll ) {
				didScroll = false;
	
				if( $(window).scrollTop() > 200 ) {
					$arrow.fadeIn();
				} else {
					$arrow.fadeOut();
				}
			}
		}, 250);
	}
/* ==================================================
   Accordion
================================================== */
	REAL.accordion = function(){
		var accordion_trigger = $('.accordion-heading.accordionize');
		
		accordion_trigger.delegate('.accordion-toggle','click', function(event){
			if($(this).hasClass('active')){
				$(this).removeClass('active');
				$(this).addClass('inactive');
			}
			else{
				accordion_trigger.find('.active').addClass('inactive');          
				accordion_trigger.find('.active').removeClass('active');   
				$(this).removeClass('inactive');
				$(this).addClass('active');
			}
			event.preventDefault();
		});
	}
/* ==================================================
   Toggle
================================================== */
	REAL.toggle = function(){
		var accordion_trigger_toggle = $('.accordion-heading.togglize');
		
		accordion_trigger_toggle.delegate('.accordion-toggle','click', function(event){
			if($(this).hasClass('active')){
				$(this).removeClass('active');
				$(this).addClass('inactive');
			}
			else{
				$(this).removeClass('inactive');
				$(this).addClass('active');
			}
			event.preventDefault();
		});
	}
/* ==================================================
   Tooltip
================================================== */
	REAL.toolTip = function(){ 
		$('a[data-toggle=tooltip]').tooltip();
	}
/* ==================================================
   Twitter Widget
================================================== */
	REAL.TwitterWidget = function() {
		$('.twitter-widget').each(function(){
			var twitterInstance = $(this); 
			twitterTweets = twitterInstance.attr("data-tweets-count") ? twitterInstance.attr("data-tweets-count") : "2"
			twitterInstance.twittie({
            	dateFormat: '%b. %d, %Y',
            	template: '<li><i class="fa fa-twitter"></i> {{tweet}} <span class="date">{{date}}</span></li>',
            	count: twitterTweets,
            	hideReplies: true
        	});
		});
	}
/* ==================================================
   Flex Slider
================================================== */
	REAL.FlexSlider = function() {
		$('.flexslider').each(function(){
				var sliderInstance = $(this); 
				sliderAutoplay = sliderInstance.attr("data-autoplay") == 'yes' ? true : false,
				sliderPagination = sliderInstance.attr("data-pagination") == 'yes' ? true : false,
				sliderArrows = sliderInstance.attr("data-arrows") == 'yes' ? true : false,
				sliderDirection = sliderInstance.attr("data-direction") ? sliderInstance.attr("data-direction") : "horizontal",
				sliderStyle = sliderInstance.attr("data-style") ? sliderInstance.attr("data-style") : "fade",
				sliderSpeed = sliderInstance.attr("data-speed") ? sliderInstance.attr("data-speed") : "5000",
				sliderPause = sliderInstance.attr("data-pause") == 'yes' ? true : false
				
				sliderInstance.flexslider({
					animation: sliderStyle,
					easing: "swing",               
					direction: sliderDirection,       
					slideshow: sliderAutoplay,              
					slideshowSpeed: sliderSpeed,         
					animationSpeed: 600,         
					initDelay: 0,              
					randomize: false,            
					pauseOnHover: sliderPause,       
					controlNav: sliderPagination,           
					directionNav: sliderArrows,            
					prevText: "",          
					nextText: "",
					start: function(){$(".flex-caption").fadeIn();}
				});
		});
	}
/* ==================================================
   Owl Carousel
================================================== */
	REAL.OwlCarousel = function() {
		$('.owl-carousel').each(function(){
				var carouselInstance = $(this); 
				carouselColumns = carouselInstance.attr("data-columns") ? carouselInstance.attr("data-columns") : "1",
				carouselitemsDesktop = carouselInstance.attr("data-items-desktop") ? carouselInstance.attr("data-items-desktop") : "4",
				carouselitemsDesktopSmall = carouselInstance.attr("data-items-desktop-small") ? carouselInstance.attr("data-items-desktop-small") : "3",
				carouselitemsTablet = carouselInstance.attr("data-items-tablet") ? carouselInstance.attr("data-items-tablet") : "2",
				carouselitemsMobile = carouselInstance.attr("data-items-mobile") ? carouselInstance.attr("data-items-mobile") : "1",
				carouselAutoplay = carouselInstance.attr("data-autoplay") == 'yes' ? true : false,
				carouselPagination = carouselInstance.attr("data-pagination") == 'yes' ? true : false,
				carouselArrows = carouselInstance.attr("data-arrows") == 'yes' ? true : false,
				carouselSingle = carouselInstance.attr("data-single-item") == 'yes' ? true : false
				carouselStyle = carouselInstance.attr("data-style") ? carouselInstance.attr("data-style") : "fade",
				carouselRTL = carouselInstance.attr("data-rtl") ? carouselInstance.attr("data-rtl") : "ltr",
				
				carouselInstance.owlCarousel({
					items: carouselColumns,
					autoPlay : carouselAutoplay,
					navigation : carouselArrows,
					pagination : carouselPagination,
					itemsDesktop:[1199,carouselitemsDesktop],
					itemsDesktopSmall:[979,carouselitemsDesktopSmall],
					itemsTablet:[768,carouselitemsTablet],
					itemsMobile:[479,carouselitemsMobile],
					singleItem:carouselSingle,
					navigationText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
					stopOnHover: true,
					lazyLoad: true,
					direction: carouselRTL,
					transitionStyle: carouselStyle
				});
		});
	}
/* ==================================================
   PrettyPhoto
================================================== */
	REAL.PrettyPhoto = function() {
			$("a[data-rel^='prettyPhoto']").prettyPhoto({
				  opacity: 0.5,
				  social_tools: "",
				  deeplinking: false
			});
	}
/* ==================================================
   Pricing Tables
================================================== */
	var $tallestCol;
	REAL.pricingTable = function(){
		$('.pricing-table').each(function(){
			$tallestCol = 0;
			$(this).find('> div .features').each(function(){
				($(this).height() > $tallestCol) ? $tallestCol = $(this).height() : $tallestCol = $tallestCol;
			});	
			if($tallestCol == 0) $tallestCol = 'auto';
			$(this).find('> div .features').css('height',$tallestCol);
		});
	}
/* ==================================================
   Animated Counters
================================================== */
	REAL.Counters = function() {
		$('.counters').each(function () {
			$(".timer .count").appear(function() {
			var counter = $(this).html();
			$(this).countTo({
				from: 0,
				to: counter,
				speed: 2000,
				refreshInterval: 60,
				});
			});
		});
	}
/* ==================================================
   SuperFish menu
================================================== */
	REAL.SuperFish = function() {
		$('.sf-menu').superfish({
			  delay: 200,
			  animation: {opacity:'show', height:'show'},
			  speed: 'fast',
			  cssArrows: false,
			  disableHI: true
		});
		$(".navigation > ul > li:has(ul)").find("a:first").append(" <i class='fa fa-angle-down'></i>");
		$(".navigation > ul > li > ul > li:has(ul)").find("a:first").append(" <i class='fa fa-caret-right'></i>");
	}
/* ==================================================
   IsoTope Portfolio
================================================== */
		REAL.IsoTope = function() {	
			$("ul.sort-source").each(function() {
				var source = $(this);
				var destination = $("ul.sort-destination[data-sort-id=" + $(this).attr("data-sort-id") + "]");
				if(destination.get(0)) {
					$(window).load(function() {
						destination.isotope({
							itemSelector: ".grid-item",
							layoutMode: 'sloppyMasonry'
						});
						source.find("a").click(function(e) {
							e.preventDefault();
							var $this = $(this),
								filter = $this.parent().attr("data-option-value");
							source.find("li.active").removeClass("active");
							$this.parent().addClass("active");
							destination.isotope({
								filter: filter
							});
							if(window.location.hash != "" || filter.replace(".","") != "*") {
								self.location = "#" + filter.replace(".","");
							}
							return false;
						});
						$(window).bind("hashchange", function(e) {
							var hashFilter = "." + location.hash.replace("#",""),
								hash = (hashFilter == "." || hashFilter == ".*" ? "*" : hashFilter);
							source.find("li.active").removeClass("active");
							source.find("li[data-option-value='" + hash + "']").addClass("active");
							destination.isotope({
								filter: hash
							});
						});
						var hashFilter = "." + (location.hash.replace("#","") || "*");
						var initFilterEl = source.find("li[data-option-value='" + hashFilter + "'] a");
						if(initFilterEl.get(0)) {
							source.find("li[data-option-value='" + hashFilter + "'] a").click();
						} else {
							source.find("li:first-child a").click();
						}
					});
				}
			});
			$(window).load(function() {
				IsoTopeCont = $(".isotope-grid");
				IsoTopeCont.isotope({
					itemSelector: ".grid-item",
					layoutMode: 'sloppyMasonry'
				});
				if ($(".grid-holder").length > 0){	
					var $container_blog = $('.grid-holder');
					$container_blog.isotope({
					itemSelector : '.grid-item'
					});
			
					$(window).resize(function() {
					var $container_blog = $('.grid-holder');
					$container_blog.isotope({
						itemSelector : '.grid-item'
					});
					});
				}
			});
		}
/* ==================================================
   Sticky Navigation
================================================== */	
	REAL.StickyNav = function() {
		if($("body").hasClass("boxed"))
			return false;
		if ($(window).width() > 992){
			$(".main-menu-wrapper").sticky({topSpacing:0});
		}
	}
/* ==================================================
   Check User Is login on login ragister page
================================================== */	
	REAL.redirect = function() {
            if(urlajax.is_register==1&&urlajax.is_login==1)
            {   
                window.location.href=urlajax.home_url;
                
            }}
 /* ==================================================
 Search Empty
================================================== */	
	REAL.search = function() {
            $('#searchform').submit(function(e) { // run the submit function, pin an event to it
        var s = $( this ).find("#s"); // find the #s, which is the search input id
        if (!s.val()) { // if s has no value, proceed
            e.preventDefault(); // prevent the default submission
           
            $('#s').focus(); // focus on the search input
        }
    });
}
/* ==================================================
 Search searchBy
================================================== */	
	REAL.searchBy = function() {
          $('.search_by').find('select').change(function(){
             var search_by= $(this).val();
            $(this).parents('.search_by').find('.search_by_keyword').val('Enter '+(search_by));
          $(".search_by_keyword" ).attr('name',search_by.toLowerCase()).focus();
          })
	}
/* ==================================================
 Filter with Search
================================================== */	
	REAL.searchWithFilterBy = function() {
            var $container = $('#property-listing');
             filters = {};
      // filter buttons
    $('.filter a').click(function(){
      var $this = $(this);
      // don't proceed if already selected
      if ( $this.hasClass('selected') ) {
        return;
      }
      
      var $optionSet = $this.parents('.option-set');
      // change selected class
      $optionSet.find('.selected').removeClass('selected');
      $this.addClass('selected');
   // store filter value in object
     var group = $optionSet.attr('data-filter-group');
      filters[ group ] = $this.attr('data-filter-value');
      // convert object into array
      var isoFilters = [];
      for ( var prop in filters ) {
        isoFilters.push( filters[ prop ] )
      }
      var selector = isoFilters.join('');
      $container.isotope({ filter: selector });
     return false;
    });
      $container.isotope({
        itemSelector : '.property_element',
        getSortData : {
         location : function( $elem ) {
            return $elem.find('.sort_by_location').text();
          },
         price : function( $elem ) {
            return parseInt( $elem.find('.sort_by_price').text(), 10 );
          },
        }
      });
     var $optionSets = $('#fat-menu .option-set'),
          $optionLinks = $optionSets.find('a');
$optionLinks.click(function(){
   var $this = $(this);
        // don't proceed if already selected
        if ( $this.hasClass('selected') ) {
         return false;
    }
        var $optionSet = $this.parents('.option-set');
        $optionSet.find('.selected').removeClass('selected');
        $this.addClass('selected');
        var options = {},
            key = $optionSet.attr('data-option-key'),
            value = $this.attr('data-option-value');
        // parse 'false' as false boolean
        value = value === 'false' ? false : value;
        options[ key ] = value;
        $container.isotope( options );
        return false;
      });
	}
        /* ==================================================
 Custom textonomy
================================================== */	
	REAL.customTextonomy = function() {
                var othertextonomies_meta= $('.othertextonomies_meta').attr('id');
                 var otherdata ='<div class="col-md-4 col-sm-4"><input type="text" name="othertextonomies" value ="'+othertextonomies_meta+'"  class ="form-control othertextonomies margin-0" placeholder="Enter city name"></div>';
                 $('.textonomies_city,.textonomies_subcity').live('change',function(){
           var textonomies_city= $(this).val();
                 var select_id_value = $(this).attr('data-id');
                 var textonomies_city_type_value= $(this).attr('data-city-type-value');
                 var data_lastselect_value= $(this).attr('data-last-select_value');
                
//	        other Data
          if(textonomies_city=='other'){
                    jQuery('.cities').parent().find('.sub_child_show').remove();
                    jQuery('.cities').parent().append(otherdata);
                    }else if(textonomies_city=='city'){
                         jQuery('.cities').parent().find('.sub_child_show').remove();
                        jQuery('.cities').parent().find('.othertextonomies').parent().remove();
                         
          }else{
                    jQuery('.cities').parent().find('.othertextonomies').parent().remove();
                    if(data_lastselect_value==''){
                       $("#LoadingImage").show();
                       var that = jQuery(this);
                        jQuery.ajax({
                        type: 'POST',
                        url: urlajax.url,
                        data: {
                        action: 'property_sub_cities',
                        city_slug: textonomies_city,
                        city_type_value:textonomies_city_type_value,
                        select_id:select_id_value,
                       
                        },
                        success: function(data) {
                             $("#LoadingImage").hide();
                            if(data!=0){
                            if(select_id_value!='subcity'){
								jQuery('.selectpicker').selectpicker({container:'body'});
                                jQuery('.cities').parent().find('.sub_child_show').remove();
          }
                    if(select_id_value=='subcity'){
                   if(jQuery('.cities').parent().find('.textonomies_subcity:last').attr('data-last-select_value')=='last_select'){
                     jQuery('.cities').parent().find('.sub_child_show:last').remove();
                   }}
                                if((data.length>=1)){
                                jQuery('.cities').parent().append(data);
								jQuery('.selectpicker').selectpicker({container:'body'});
                               
                             }}
                        if((data==0 &&select_id_value=='parent_city')){
                        jQuery('.cities').parent().find('.sub_child_show').remove();
	}
                          if((data==0 &&select_id_value=='subcity')){
                              
                            that.parent().siblings('.sub_child_show').remove();
                          }
                          },
                          error: function(errorThrown) {
                          }
                         });
			}}
       		}); 
                 var sub_sub_category_id= $('.sub_sub_category_id').attr('id');
                 var othertextonomies_meta= $('.othertextonomies_meta').attr('id');
                 if(sub_sub_category_id!=null){
                    $("#LoadingImage").show();
                    jQuery.ajax({
                    type: 'POST',
                    url: urlajax.url,
                data: {
                    action: 'property_sub_cities_at_start',
                    sub_sub_category_id: sub_sub_category_id,
                 },
              success: function(data) {
                $("#LoadingImage").hide();
                jQuery('.cities').parent().append(data);
				jQuery('.selectpicker').selectpicker({container:'body'});
            },
		error: function(errorThrown) {
		}
		});
                }
                if(othertextonomies_meta!=null){
                    $("#LoadingImage").show();
                    jQuery.ajax({
                            type: 'POST',
                            url: urlajax.url,
                            data: {
                            action: 'property_sub_cities_at_start',
                            othertextonomies_meta: othertextonomies_meta,
			     },
                            success: function(data) {
                            $("#LoadingImage").hide();
                            jQuery('.cities').parent().append(data);
							jQuery('.selectpicker').selectpicker({container:'body'});
                            },
                            error: function(errorThrown) {
                            }
                            });
                            }}
/* ==================================================
 Search Module
================================================== */	
	REAL.SearchModule = function() {
          SFH = $(".site-search-module-inside").height();
          SBOFF = SFH - 90;
		  $(".site-search-module").css("bottom",-+SBOFF);
          $('#ads-trigger').click(function () {   
            if ($(this).hasClass('advanced')) {
                $(this).removeClass('advanced');
                $(".site-search-module").animate({
                    'bottom': '-'+SBOFF
                });
                $(this).html('<i class="fa fa-plus"></i> '+urlajax.advanced);
                $('.slider-mask').fadeOut(500);
            } else {
               
                $(this).addClass('advanced');
                $(".site-search-module").animate({
                    'bottom': 0
                });
                $(this).html('<i class="fa fa-minus"></i> '+urlajax.basic);
                $('.slider-mask').fadeIn(500);
            }   
            return false;
        });
    }
        /* ==================================================
   Check User Is login on Payment page
================================================== */	
	REAL.paymentRedirect = function() {
          if(urlajax.is_payment==1&&urlajax.is_login==0)
            {   
                window.location.href=urlajax.register_url;
                
            }}
 /* ==================================================
   Init Functions
================================================== */
$(document).ready(function(){
	REAL.ContactForm();
	REAL.AgentContactForm();
	REAL.scrollToTop();
	REAL.accordion();
	REAL.toggle();
	REAL.toolTip();
	REAL.navMenu();
	REAL.TwitterWidget();
	REAL.FlexSlider();
	REAL.PrettyPhoto();
	REAL.SuperFish();
	REAL.pricingTable();
	REAL.Counters();
	REAL.IsoTope();
	if(urlajax.sticky==1) {
	REAL.StickyNav(); }
	REAL.OwlCarousel();
    REAL.redirect();
    REAL.search();
    REAL.searchBy();
    REAL.searchWithFilterBy();
    REAL.customTextonomy();
    REAL.paymentRedirect();
	$('.selectpicker').selectpicker({container:'body'});
       
  
});
jQuery(function() {
	// apply matchHeight to each item container's items
	$('#latest-properties').each(function() {
		$(this).find('.property-block').matchHeight();
		$(this).find('.property-block').find('.property-featured-image').matchHeight();
		$(this).find('.property-block').find('.property-info').matchHeight();
	});
});
$( document ).ajaxStop( function() {
		REAL.toolTip();
	});
$(window).load(function(){
	REAL.SearchModule();
          if(urlajax.is_submit_property==1){
        if(window.File && window.FileList && window.FileReader){
        document.getElementById("filePhotoMulti").addEventListener("change", function(event){
            var files = event.target.files; //FileList object
            for(var i = 0; i< files.length; i++){
                var file = files[i];
                if(!file.type.match('image')){ continue; }
                var multiPhotoReader = new FileReader();
                multiPhotoReader.addEventListener("load",function(event){
                    var img = event.target;
                    var div = document.createElement("div");
					div.setAttribute("class", 'col-md-2 col-sm-2');
                    div.innerHTML = "<img class='thumbnail' width='127' height ='95' src='" + img.result + "'" +
                            "title='" + img.name + "'/>";
					document.getElementById("photoList").insertBefore(div,null);            
});
                multiPhotoReader.readAsDataURL(file);
            }                               
        });
    }
          }});
$(".cust-counter" ).wrapAll( "<section class=\"counters padding-tb45 accent-color text-align-center\"><div class=\"container\"><div class=\"row\">");
$("#comment-submit").wrapAll("<div class=\"row\"><div class=\"form-group\"><div class=\"col-md-12\">");
$("#comment-submit").addClass("btn btn-primary btn-lg");
/* Design Related Scripts */
$(".flex-caption").each(function(){
	$(this).prepend('<i class="fa fa-caret-down"></i>');
});
$(".block-heading").each(function(){
	$(this).find('.heading-icon').prepend('<i class="fa fa-caret-right icon-design"></i>');
});
$(window).load(function(){
	$(".property-featured-image").each(function(){
		PIheight = $(this).find("img").outerHeight();
		$(this).prepend("<div class='overlay' style='line-height:"+PIheight+"px'><i class='fa fa-lightbulb-o'></i></div>");
	});
	$(".agent-featured-image").each(function(){
		PIheight = $(this).find("img").outerHeight();
		$(this).prepend("<div class='overlay' style='line-height:"+PIheight+"px'><i class='fa fa-plus'></i></div>");
	});
	$(".format-image").each(function(){
		$(this).find(".media-box").append("<span class='zoom'><i class='fa fa-search'></i></span>");
	});
	$(".format-standard").each(function(){
		$(this).find(".media-box").append("<span class='zoom'><i class='fa fa-plus'></i></span>");
	});
	$(".format-video").each(function(){
		$(this).find(".media-box").append("<span class='zoom'><i class='fa fa-play'></i></span>");
	});
	$(".format-link").each(function(){
		$(this).find(".media-box").append("<span class='zoom'><i class='fa fa-link'></i></span>");
	});
	$(".media-box .zoom").each(function(){
		mpwidth = $(this).parent().width();
		mpheight = $(this).parent().find("img").height();
		
		$(this).css("width", mpwidth);
		$(this).css("height", mpheight);
		$(this).css("line-height", mpheight+"px");
	});
});
$(window).resize(function(){
	$(".media-box .zoom").each(function(){
		mpwidth = $(this).parent().width();
		mpheight = $(this).parent().find("img").height();
		
		$(this).css("width", mpwidth);
		$(this).css("height", mpheight);
		$(this).css("line-height", mpheight+"px");
	});
	if ($(window).width() > 992){
		$(".main-menu-wrapper").css("display","block");
	} else {
		$(".main-menu-wrapper").css("display","none");
	}
});
// FITVIDS
$(".container").fitVids();
// List Styles
$(".location").prepend('<i class="fa fa-map-marker"></i> ');
$(".nav-tabs li").prepend('<i class="fa fa-caret-down"></i> ');
$('ul.chevrons li:even i').after('<i class="icon icon-envelope-alt"></i>');
$('ul.chevrons li:odd i').after('<i class="icon icon-film"></i>');
$('a.external').prepend('<i class="fa fa-external-link"></i> ');
// Animation Appear
$("[data-appear-animation]").each(function() {
	var $this = $(this);
  
	$this.addClass("appear-animation");
  
	if(!$("html").hasClass("no-csstransitions") && $(window).width() > 767) {
  
		$this.appear(function() {
  
			var delay = ($this.attr("data-appear-animation-delay") ? $this.attr("data-appear-animation-delay") : 1);
  
			if(delay > 1) $this.css("animation-delay", delay + "ms");
			$this.addClass($this.attr("data-appear-animation"));
  
			setTimeout(function() {
				$this.addClass("appear-animation-visible");
			}, delay);
  
		}, {accX: 0, accY: -150});
  
	} else {
  
		$this.addClass("appear-animation-visible");
	}
});
// Animation Progress Bars
$("[data-appear-progress-animation]").each(function() {
	var $this = $(this);
	$this.appear(function() {
		var delay = ($this.attr("data-appear-animation-delay") ? $this.attr("data-appear-animation-delay") : 1);
		if(delay > 1) $this.css("animation-delay", delay + "ms");
		$this.addClass($this.attr("data-appear-animation"));
		setTimeout(function() {
			$this.animate({
				width: $this.attr("data-appear-progress-animation")
			}, 1500, "easeOutQuad", function() {
				$this.find(".progress-bar-tooltip").animate({
					opacity: 1
				}, 500, "easeOutQuad");
			});
		}, delay);
	}, {accX: 0, accY: -50});
});
// Parallax Jquery Callings
if(!Modernizr.touch) {
	$(window).bind('load', function () {
		parallaxInit();						  
	});
}
function parallaxInit() {
	$('.parallax1').parallax("50%", 0.1);
	$('.parallax2').parallax("50%", 0.1);
	$('.parallax3').parallax("50%", 0.1);
	$('.parallax4').parallax("50%", 0.1);
	$('.parallax5').parallax("50%", 0.1);
	$('.parallax6').parallax("50%", 0.1);
	$('.parallax7').parallax("50%", 0.1);
	$('.parallax8').parallax("50%", 0.1);
	/*add as necessary*/
}
// Window height/Width Getter Classes
wheighter = $(window).height();
wwidth = $(window).width();
$(".wheighter").css("height",wheighter);
$(".wwidth").css("width",wwidth);
$(window).resize(function(){
	wheighter = $(window).height();
	wwidth = $(window).width();
	$(".wheighter").css("height",wheighter);
	$(".wwidth").css("width",wwidth);
});
/* Property details slider */
	 $('#property-thumbs').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 175,
    itemMargin: 10,
    asNavFor: '#property-images',            
	prevText: "",          
	nextText: ""
  });
   
  $('#property-images').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    sync: "#property-thumbs",            
	prevText: "",          
	nextText: ""
  });
});
function readURL(input) {
	var imgid = input.id;
		if(input.files[0].size >= 256000){
			var default_image = '<?php echo get_template_directory_uri(); ?>/images/dummy_agent.jpg';
			jQuery('#'+imgid).attr('src', default_image);
			jQuery('#'+imgid).val(''); 
			alert('Image size max then 250kb. Please check....');
			  
		} else {
			if (input.files && input.files[0]) {
			   var reader = new FileReader();
			   reader.onload = function(e) {
				   jQuery('#'+imgid).attr('src', e.target.result);
			   }
	
			   reader.readAsDataURL(input.files[0]);
		   }
		}
	}
function SingleMap() {
  var properties=[];
  if(urlajax.is_property==1){
     properties.push({  
        title :jQuery('.single-property').find('.property_address').text(),                               
        price :jQuery('.single-property').find('.property_price').html(),
        lat :jQuery('.single-property').find('.latitude').text(),
        lng :jQuery('.single-property').find('.longitude').text() ,
        thumb:jQuery('.single-property').find('.property_image_map').text(),  
        url:jQuery('.single-property').find('.property_url').text(),  
        icon:jQuery('.single-property').find('.property_image_url').text() 
     });   
       }else{
           if(urlajax.is_contact==1){
             properties.push({  
        title :jQuery('.property_container').find('.property_address').text(),                               
        lat :jQuery('.property_container').find('.latitude').text(),
        lng :jQuery('.property_container').find('.longitude').text() ,
        icon:jQuery('.property_container').find('.property_image_url').text() 
     });   
       }
	   else{
             properties.push({                                
        lat :'10',
        lng :'10' ,
     });   
       }}
    var property_zoom;
   if(urlajax.is_property==1||urlajax.is_contact==1){
    property_zoom= parseInt(jQuery('.property_zoom_level').attr('id'));
       }
       else{
       property_zoom=4;
   }
var mapOptions = {
                zoom: property_zoom,
				center: new google.maps.LatLng(properties[0].lat,properties[0].lng),
                scrollwheel: false
            }
            var map = new google.maps.Map(document.getElementById("onemap"), mapOptions);
            var markers = new Array();
            var info_windows = new Array();
            for (var i=0; i < properties.length; i++) {
                              markers[i] = new google.maps.Marker({
                    position: map.getCenter(),
                    map: map,
                    icon: properties[i].icon,
                    title: properties[i].title,
                    animation: google.maps.Animation.DROP
                });
   if(urlajax.is_contact==1){
     info_windows[i] = new google.maps.InfoWindow({
                    content:'<div class="map-property">'+
                        '<h4 class="property-title">'+properties[i].title+'</h4>'+
                         '</div>'
                });  
     }else{
   info_windows[i] = new google.maps.InfoWindow({
                    content:    '<div class="map-property">'+
                        '<h4 class="property-title"><a class="title-link" href="'+properties[i].url+'">'+properties[i].title+'</a></h4>'+
                        '<a class="property-featured-image" href="'+properties[i].url+'"><img class="property-thumb" src="'+properties[i].thumb+'" alt="'+properties[i].title+'"/></a>'+
                        '<p><span class="price">'+properties[i].price+'</span></p>'+
                        '<a class="btn btn-primary btn-sm" href="'+properties[i].url+'">Details</a>'+
                        '</div>'
                });  
 }
        attachInfoWindowToMarker(map, markers[i], info_windows[i]);
            }
            /* function to attach infowindow with marker */
            function attachInfoWindowToMarker( map, marker, infoWindow ){
                google.maps.event.addListener( marker, 'click', function(){
                    infoWindow.open( map, marker );
                });
            }
        }
       
function PropertiesMap() {
  var properties=[];
          jQuery('ul#property_grid_holder li').each(function(i)
      { 
        properties.push({  
        title :jQuery(this).find('.property_address').text(),                               
        price :jQuery(this).find('.property_price').html(),
        lat :jQuery(this).find('.latitude').text(),
        lng :jQuery(this).find('.longitude').text() ,
        thumb:jQuery(this).find('.property_image_map').text(),  
        url:jQuery(this).find('.property_url').text(),  
        icon:jQuery(this).find('.property_image_url').text() 
     });
   });
var mapOptions = {
                zoom: 12,
                scrollwheel: false
            }
            var map = new google.maps.Map(document.getElementById("gmap"), mapOptions);
            var bounds = new google.maps.LatLngBounds();
            var markers = new Array();
            var info_windows = new Array();
            for (var i=0; i < properties.length; i++) {
                              markers[i] = new google.maps.Marker({
                    position: new google.maps.LatLng(properties[i].lat,properties[i].lng),
                    map: map,
                    icon: properties[i].icon,
                    title: properties[i].title,
                    animation: google.maps.Animation.DROP
                });
				bounds.extend(markers[i].getPosition());
   info_windows[i] = new google.maps.InfoWindow({
                    content:    '<div class="map-property">'+
                        '<h4 class="property-title"><a class="title-link" href="'+properties[i].url+'">'+properties[i].title+'</a></h4>'+
                        '<a class="property-featured-image" href="'+properties[i].url+'"><img class="property-thumb" src="'+properties[i].thumb+'" alt="'+properties[i].title+'"/></a>'+
                        '<p><span class="price">'+properties[i].price+'</span></p>'+
                        '<a class="btn btn-primary btn-sm" href="'+properties[i].url+'">Details</a>'+
                        '</div>'
                });  
        attachInfoWindowToMarker(map, markers[i], info_windows[i]);
            }
            map.fitBounds(bounds);
            /* function to attach infowindow with marker */
            function attachInfoWindowToMarker( map, marker, infoWindow ){
                google.maps.event.addListener( marker, 'click', function(){
                    infoWindow.open( map, marker );
                });
            }
        }
       google.maps.event.addDomListener(window, 'load', PropertiesMap);
	   google.maps.event.addDomListener(window, 'load', SingleMap);
	   
jQuery("#property-img").live('click',function(){
   
    var that =jQuery(this);
	$property_id = jQuery(this).find('.property-id').text();
	$thumb_id = jQuery(this).find('.thumb-id').text();
	jQuery.ajax({
            type: 'POST',
            url: urlajax.url,
            data: {
                action: 'update_property_featured_image',
                property_id: $property_id,
				thumb_id: $thumb_id,
            },
            success: function(data) {
            jQuery('div#property-img').each(function(){
                   if(that.parent().find('.thumb-id').text()!=jQuery(this).find('.thumb-id').text()){
                   jQuery(this).find('div#property-thumb').contents().unwrap();
              jQuery(this).find('a').contents().unwrap();
               jQuery(this).find('img#filePhoto2').wrap('<a id="feat-image" class="accent-color default-image" data-original-title="Set as default image" data-toggle="tooltip" style="text-decoration:none;" href="#"></a>');
                   }else{
                       jQuery(this).find('div#property-thumb').contents().unwrap();
              jQuery(this).find('a').contents().unwrap(); 
                   }
                   })
            },
            error: function(errorThrown) {
            }
        });
});
//Remove property image
jQuery(".remove-image").live('click',function(){
    var ID =jQuery(this).attr('id');
	var PRID =jQuery(this).attr('rel');
	jQuery.ajax({
            type: 'POST',
            url: urlajax.url,
            data: {
                action: 'imic_remove_property_image',
                thumb_id: ID,
				property_id: PRID,
            },
            success: function(data) {
				jQuery("#"+ID).parent().parent().remove();
            },
            error: function(errorThrown) {
            }
        });
});