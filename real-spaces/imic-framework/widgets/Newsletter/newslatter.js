/* 
 * Newsletter Jquery
 */
jQuery(document).ready(function() {
    var defalutemail = jQuery('.widget_newsletter').find('.form-control').val();
       jQuery('.widget_newsletter').find('.btn-primary').click(function() {
           var email = jQuery('.widget_newsletter').find('.form-control');
        if (!validateEmail()) {
              validateEmail();
               return false;
            }
            else {
                return true;
            }
           function IsEmail(email) {
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                return regex.test(email);
            }
            function validateEmail()
            {
                if (jQuery.trim(email.val()) == "")
                {
                    email.addClass("error_err");
                    return false;
                }
                if (jQuery.trim(email.val()) == defalutemail)
                {
                    email.addClass("error_err");
                    return false;
                }
                else if (!(IsEmail(email.val())))
                {
                    email.addClass("error_err");
                    return false;
                }
                else
                {
                    email.removeClass("error_err");
                    return true;
                }
            }
           })
    })