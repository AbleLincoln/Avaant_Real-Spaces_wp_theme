jQuery(document).ready(function() {
        jQuery('.mandatory').hide();
        jQuery('.cus_submit').click(function() {
            var username = jQuery('.username');
            var pwd1 = jQuery('.pwd1');
            var pwd2 = jQuery('.pwd2');
            var email1 = jQuery('.email1');
            var first_name = jQuery('.first_name');
            var last_name = jQuery('.last_name');
            if (!validPwd1() || !validPwd2() || !validateEmail1() || !validFirstName() || !validLastName()) {
                validPwd1();
                validPwd2();
                validateEmail1();
                validFirstName();
                validLastName();
                jQuery('.mandatory').show();
                return false;
            }
            else {
                jQuery('.mandatory').hide();
                return true;
            }
            function validPwd1() {
                if ((pwd1.val().length < 4 && pwd1.val().length > 40))
                {
                    pwd1.addClass("error_err");
                    return false;
                }
                else
                {
                    pwd1.removeClass("error_err");
                    return true;
                }
            }
            function validPwd2() {
                if ((pwd2.val().length < 4 && pwd2.val().length > 40))
                {
                    pwd2.addClass("error_err");
                    return false;
                }
                else if (pwd1.val() != pwd2.val()) {
                    pwd2.addClass("error_err");
                    return false;
                }
                else
                {
                    pwd2.removeClass("error_err");
                    return true;
                }
            }
            function IsEmail(email) {
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                return regex.test(email);
            }
            function validateEmail1()
            {
                if (jQuery.trim(email1.val()) == "")
                {
                    email1.addClass("error_err");
                    return false;
                }
                if (jQuery.trim(email1.val()) == "Your e-mail*")
                {
                    email1.addClass("error_err");
                    return false;
                }
                else if (!(IsEmail(email1.val())))
                {
                    email1.addClass("error_err");
                    return false;
                }
                else
                {
                    email1.removeClass("error_err");
                    return true;
                }
            }
           
            function validFirstName() {
                if ((first_name.val().length < 4 && first_name.val().length > 40) || (jQuery.trim(first_name.val()) == "") || (jQuery.trim(first_name.val()) == "nitinvipi123@gmail.com"))
                {
                    first_name.addClass("error_err");
                    return false;
                }
                else
                {
                    first_name.removeClass("error_err");
                    return true;
                }
            }
            function validLastName() {
                if ((last_name.val().length < 4 && last_name.val().length > 40) || (jQuery.trim(last_name.val()) == "") || (jQuery.trim(last_name.val()) == "Name*"))
                {
                    last_name.addClass("error_err");
                    return false;
                }
                else
                {
                    last_name.removeClass("error_err");
                    return true;
                }
            }
            
            function validOldPassword() {
                if ((org_pwd.val().length < 8) || (jQuery.trim(org_pwd.val()) == ""))
                {
                    org_pwd.addClass("error_err");
                    return false;
                }
                else
                {
                    org_pwd.removeClass("error_err");
                    return true;
                }
            }
        })
    })