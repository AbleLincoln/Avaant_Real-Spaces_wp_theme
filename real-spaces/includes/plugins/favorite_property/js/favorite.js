jQuery(function($){
var REAL = window.REAL || {};
/* ==================================================
 Favorite
================================================== */	
REAL.favorite = function() {
$('.favorite_information .favorite').click(function(e){
	$property_title = jQuery(this).find('.favorite-title').text();
	$property_body = jQuery(this).find('.favorite-body').text();
	$property_success = jQuery(this).find('.favorite-success').text();
	$(".single-property").append('<div id="favourite-box"><div id="mymodal" class="modal fade in" aria-hidden="true" aria-labelledby="mymodalLabel" role="dialog" tabindex="-1" style="display:block;"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 id="mymodalLabel" class="modal-title">'+$property_title+'</h4></div><div class="modal-body temp">'+$property_body+'</div><div class="modal-footer"></div></div></div></div></div>');
e.preventDefault();
$.ajax({
type: "POST",
url: tmpurl.plugin_path+"/favorite.php",
data: 'f_author_n=' + jQuery(this).parent().find('.f_author_n').attr('id') + '&f_property_n=' + jQuery(this).parent().find('.f_property_n').attr('id'),
dataType: 'text',
success: function(msg) {
$(".temp").empty();
$(".temp").append(msg);
if(msg.match('added') != null) { $(".favorite_information").empty();
$(".favorite_information").append('<a id="already-in" href="#" class="accent-color" style="cursor:default; text-decoration:none;" data-toggle="tooltip" data-original-title="'+$property_success+'"><i class="fa fa-heart"></i></a>'); }
},
complete: function() {
setTimeout(fade_out, 2000);
function fade_out() {
  jQuery("#favourite-box").remove();
}
}
});
});
}

REAL.login = function() {
$('#login-modal').click(function(e){
$('body').prepend('<div class="login_overlay"></div>');
$('form#login').fadeIn(500);
});
}
/* ==================================================
 search
================================================== */	
REAL.search = function() {
$('.search_information .search').click(function(e){
e.preventDefault();

var encoded = encodeURIComponent(document.URL);
var search_title=$("#search").val();
$.ajax({
type: "POST",
url: tmpurl.plugin_path+"search_information.php",
data: 'f_author_n=' + jQuery(this).parents('.modal-body').find('.f_author_n').attr('id') + '&f_search_url=' + encoded+'&f_search_title=' + search_title,
dataType: 'text',
success: function(msg) {
$("#message").empty();
$("#message").append('<div class="alert alert-success">'+msg+'</div>');
}
});
});
}
/* ==================================================
 search Remove
================================================== */	
REAL.searchRemove = function() {
$('.remove-search').click(function(e){
	$search_title = jQuery(this).find('.search-title').text();
e.preventDefault();
 var that = jQuery(this);
var encoded = encodeURIComponent(jQuery(this).attr('id'));
$("#details").append('<div id="search-box"><div id="mymodal" class="modal fade in" aria-hidden="true" aria-labelledby="mymodalLabel" role="dialog" tabindex="-1" style="display:block;"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 id="mymodalLabel" class="modal-title"></h4></div><div class="modal-body">'+$search_title+'</div><div class="modal-footer"></div></div></div></div></div>');
$.ajax({
type: "POST",
url: tmpurl.plugin_path+"search_information.php",
data: 'f_author_n_remove=' + jQuery(this).parents('.properties-table').find('.f_author_n').attr('id') + '&f_search_url=' + encoded,
dataType: 'text',
success: function(msg) {
that.parents('tr').remove();
$("#search-box").remove();
recalcId();
id--;
}
});
});
function recalcId(){
    jQuery.each(jQuery("table tbody tr"),function (i,el){
        jQuery(this).find("td:first").html(i + 1); // Simply couse the first "prototype" is not counted in the list
    })
}
}
/* ==================================================
   Init Functions
================================================== */
$(document).ready(function(){
REAL.favorite();
REAL.login();
REAL.search();
REAL.searchRemove();
})
});