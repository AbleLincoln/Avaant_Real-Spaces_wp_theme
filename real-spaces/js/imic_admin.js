/*
 *
 *	Admin jQuery Functions
 *	------------------------------------------------
 *	Imic Framework
 * 	Copyright Imic 2014 - http://imithemes.com
 *
 */
jQuery(window).load(function() {
jQuery('#wpseo_meta.postbox').show();
});
jQuery(function(jQuery) {
//SELECTED TEMPLATE BASED META BOX DISPLAY
    function show_hide_metabox() {
       if ((jQuery('body').hasClass('post-php')||(jQuery('body').hasClass('post-new-php')))&&jQuery('body').hasClass('post-type-page')) {
           var metaID = jQuery('#page_template').val().slice(0, -4);
            metaboxName = metaID.substring(metaID.indexOf('-') + 1);
            
            jQuery('#normal-sortables > div').each(function(i, k)
            { 
                if (jQuery(this).attr('id').indexOf(metaboxName) != -1)
                {
                    jQuery(this).show();
                    
                }
                else
                {
                    jQuery(this).hide();
                }
				if(metaID == 'template-home' || metaID == 'template-home-second'){
					jQuery('#post_page_meta_box').hide();
				}
				else {
					jQuery('#post_page_meta_box').show();
				}
				if(metaID=="template-home-second") {
					jQuery("#template-home2").show();
					jQuery("#template-home3").show();
					jQuery("#template-home4").show();
					jQuery("#template-home6").show();
					jQuery('#select_sidebar').show();
				}
                               if((metaID=="template-compare properties")||(metaID=='template-property-listing')||(metaID=='template-our-agents')||(metaID=='def')) {
					jQuery('#select_sidebar').show();
				}
				if((metaID=='template-property-listing')||(metaID=='template-contact')) {
					jQuery('#imic_banner_type option:gt(1)').show();
				}
				else{
					jQuery('#imic_banner_type option:gt(1)').hide();	
				}
                                
            })
        }
    }
    show_hide_metabox();
    // META FIELD DISPLAY ON TEMPLATE SELECT
    jQuery('#page_template').on('change', function() {
        show_hide_metabox();
    });
     // slider display for home
    var $imic_slider_with_property = jQuery('#imic_slider_with_property');
    function slider_display() {
        var $imic_slider_image = jQuery('#imic_slider_image_description').closest('.rwmb-field');
        var $imic_revolution_from_list = jQuery('#imic_pages_select_revolution_from_list').closest('.rwmb-field');
       var $imic_slider_auto_slide=jQuery('#imic_slider_auto_slide').closest('.rwmb-field');
       var $imic_slider_direction_arrows=jQuery('#imic_slider_direction_arrows').closest('.rwmb-field');
       var $imic_slider_effects=jQuery('#imic_slider_effects').closest('.rwmb-field');
      
   if ($imic_slider_with_property.val()==0) {
            $imic_slider_image.hide();
            $imic_revolution_from_list.hide();
            $imic_slider_auto_slide.show();
            $imic_slider_direction_arrows.show();
            $imic_slider_effects.show();
       }
       else if ($imic_slider_with_property.val()==2) {
            $imic_slider_image.hide();
            $imic_revolution_from_list.show();
            $imic_slider_auto_slide.hide();
            $imic_slider_direction_arrows.hide();
            $imic_slider_effects.hide();
       }
       else {
            $imic_slider_image.show();
            $imic_revolution_from_list.hide();
        }
    }
    slider_display();
    $imic_slider_with_property.change(function() {
        slider_display();
    });
	//COLUMN FIELD FOR GRID GALLERY
	var imic_gallery_type = jQuery('#imic_gallery_type');
	var imic_gallery_column = jQuery('#imic_gallery_pagination_columns_layout').parent().parent();
	function showcolumngallery() {
		var gallery_type = jQuery('#imic_gallery_type').val()
		if(gallery_type==0) {
			imic_gallery_column.show();
		}
		else {
			imic_gallery_column.hide();
		}
	}
	showcolumngallery();
	jQuery('#imic_gallery_type').on('change',function() {
		showcolumngallery();
	});
	
	
	//META FIELDS SHOW FOR THEIR RESPECTIVE POST FORMAT
    var imic_post_format_meta_box = jQuery('#gallery_meta_box');
	var imic_gallery_meta_box = jQuery('#imic_gallery_images_description').parent().parent();
    var imic_link_url = jQuery('#imic_gallery_link_url').parent().parent();
   var imic_gallery_slider_all =jQuery('#imic_gallery_slider_pagination,#imic_gallery_slider_auto_slide,#imic_gallery_slider_direction_arrows,#imic_gallery_slider_effects').parent().parent();
   function checkPostFormat(radio_val) {
        if (jQuery.trim(radio_val) == 'gallery') {
			imic_post_format_meta_box.show();
            imic_gallery_meta_box.show();
            imic_link_url.hide();
            imic_gallery_slider_all.show();
        }
        else if (jQuery.trim(radio_val) == 'link') {
			imic_post_format_meta_box.show();
            imic_gallery_meta_box.hide();
            imic_link_url.show();
            imic_gallery_slider_all.hide();
        }
        else {
            imic_post_format_meta_box.hide();
            
        }
    }
    jQuery('.post-type-post .post-format').click(function() {
        if (jQuery(this).is(':checked'))
        {
            var radio_val = jQuery(this).val();
            checkPostFormat(radio_val)
        }
    })
	 jQuery('.post-type-post').find('.post-format').each(function() {
        if (jQuery(this).is(':checked'))
        {
            var radio_val = jQuery(this).val();
            checkPostFormat(radio_val);
            
        }
    })
	if (jQuery("body").hasClass("post-type-post")) {
		jQuery('#imic_banner_type option:gt(1)').hide();
	}
	// Page Banner Selection
    var $bannerType = jQuery('#imic_banner_type');
    function bannerTypeOptions() {
       var $bannerImage = jQuery('ul[data-field_id=imic_banner_image]').parent().parent();
		
        if ($bannerType.val() == "banner") {
            $bannerImage.css('display', 'block');
           
        } else {
			$bannerImage.css('display', 'none');
            		
		}
    }
    bannerTypeOptions();
    $bannerType.change(function() {
        bannerTypeOptions();
    });
// Amenities at property page
jQuery("#imic_property_amenities_description").closest('.rwmb-text-wrapper').find('.rwmb-clone .rwmb-text').live('click',function(){
var text_name = jQuery(this).attr('name');
jQuery( "body" ).data("text_name", text_name );
if(jQuery("#amenity_array").length == 0) {
jQuery("#imic_property_amenities_description").closest('.rwmb-text-wrapper').append(amenity_array.value);
jQuery("#imic_property_amenities_description").closest('.rwmb-text-wrapper').find('select').focus();
}});
jQuery("#amenity_select_array").live('change',function(){
text_name=jQuery( "body" ).data( "text_name" );
var current_value = jQuery("#amenity_select_array option:selected").text();
jQuery( "body").find('input[name$="'+text_name+'"]').val(current_value);
});
});
 jQuery(function($){
      if(jQuery('#upload_image_preview').attr('src')==''){
       jQuery('#upload_image_preview').hide();
       jQuery('#upload_agent_button_remove').hide();
    }
    jQuery('#upload_agent_button_remove').live('click', function() {
        jQuery('#upload_image_preview').attr('src','');
        jQuery('#agent_url').val('');
        jQuery('#upload_image_preview').hide();
    })
    jQuery('#upload_agent_button').live('click', function() {
        var fileFrame = wp.media.frames.file_frame = wp.media({
            multiple: false
        });
        fileFrame.on('select', function() {
            var attachment = fileFrame.state().get('selection').first().toJSON();
	    jQuery('#agent_url').val(attachment.url);
            jQuery('#upload_image_preview').show();
            jQuery('#upload_agent_button_remove').show();
            jQuery('img#upload_image_preview').attr('src',attachment.url);
});
fileFrame.open(); 
});
});
 jQuery(function($){
      if(jQuery('#upload_banner_preview').attr('src')==''){
       jQuery('#upload_banner_preview').hide();
       jQuery('#upload_agent_banner_remove').hide();
    }
    jQuery('#upload_agent_banner_remove').live('click', function() {
        jQuery('#upload_banner_preview').attr('src','');
        jQuery('#agent_banner').val('');
        jQuery('#upload_banner_preview').hide();
    })
    jQuery('#upload_agent_banner').live('click', function() {
        var fileFrame = wp.media.frames.file_frame = wp.media({
            multiple: false
        });
        fileFrame.on('select', function() {
            var attachment = fileFrame.state().get('selection').first().toJSON();
	    jQuery('#agent_banner').val(attachment.url);
            jQuery('#upload_banner_preview').show();
            jQuery('#upload_agent_banner_remove').show();
            jQuery('img#upload_banner_preview').attr('src',attachment.url);
});
fileFrame.open(); 
});
});