jQuery(document).ready(function($) {
  $( '#share-box' ).hide();
  $( '#share' ).click(function() {
    $( '#share-box' ).slideToggle( 400 );
  });
})