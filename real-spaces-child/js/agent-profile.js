/* ==================================================
	Register Form Ajax Call
================================================== */
jQuery(document).ready(function() {
	jQuery(".agent-profile-form").submit(function(event) {
		jQuery("#message").slideUp(750,function() {
		jQuery('#message').hide();
	
		jQuery('#submit')
		   .after('<img src="' + jQuery('#image_path').val() + 'images/assets/ajax-loader.gif" class="loader" />')
		   .attr('disabled','disabled');
	
		jQuery.ajax({
			type: 'POST',
			url: agent_profile.ajaxurl,
			data: {
				action: 'imic_agent_profile',
				first_name: jQuery('#first_name').val(),
				last_name: jQuery('#last_name').val(),
				email: jQuery('#email').val(),
				org_pwd: jQuery('#org_pwd').val(),
				pwd1: jQuery('#pwd1').val(),
				pwd2: jQuery('#pwd2').val(),
				description: jQuery('#description').val(),
				agent_image: jQuery('#agent-image').val(),
				mobile_phone: jQuery('#mobile-phone').val(),
				work_phone: jQuery('#work-phone').val(),
				fb_link: jQuery('#fb-link').val(),
				twt_link: jQuery('#twt-link').val(),
				gp_link: jQuery('#gp-link').val(),
				msg_link: jQuery('#msg-link').val(),
				task: jQuery('#action').val(),
				},
			success: function(data) {
				document.getElementById('message').innerHTML = data;
				jQuery('#message').slideDown('slow');
				jQuery('.agent-profile-form img.loader').fadeOut('slow',function(){jQuery(this).remove()});
				jQuery('#submit').removeAttr('disabled');
				//if(data.match('success') != null) document.getElementById('registerform').reset();
			},
			error: function(errorThrown) {
			}
		});
		});
		return false;
	});
	
	function readURL(input) {
		if(input.files[0].size >= 256000){
			var default_image = agent_profile.dir + '/images/dummy_agent.jpg';
			jQuery('#preview_area').attr('src', default_image);
			jQuery('#agent-image').val(''); 
			alert('Image size max then 250kb. Please check....');
			  
		} else {
			if (input.files && input.files[0]) {
			   var reader = new FileReader();
			   reader.onload = function(e) {
				   jQuery('#preview_area').attr('src', e.target.result);
			   }
	
			   reader.readAsDataURL(input.files[0]);
		   }
		}
	}
	jQuery("#agent-image").change(function() {
	   readURL(this);
   });
});