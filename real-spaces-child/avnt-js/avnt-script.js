jQuery(document).ready(function($) {
  
//  setTimeout(searchFlip, 0);
  
  var searchFlip = function() {
    var $searchBox = $( 'header div.search-field' ).find( 'button' );
    var numOptions = $( 'header div.search-field select' ).children().length;
    console.log( numOptions );
    $searchBox.click(function() { 
      console.log("return");
      searchFlip.stop(); });

    var index = 2;
    setInterval(function() {
      if(index > numOptions) { index = 2 };

      $searchBox.children( 'span.searchWord' ).remove();
      var searchWord = $( 'header div.search-field select option:nth-child(' + index + ')').text();
      var $searchWord = $( '<span class="searchWord">' + searchWord + '</span>');
      $searchWord.hide();
      $searchWord.prependTo( $searchBox ).slideDown();

      $( 'header div.search-field select' ).val( searchWord.toLowerCase() ).change();
      console.log( $('header div.search-field select').val() );
      //console.log(searchWord);
      //console.log(index);
      setTimeout(function() {
        $searchBox.children( 'span.searchWord' ).slideUp();
      }, 3000);

      index = index+1;
    }, 3500);
  };
  
  searchFlip();
  
});

//var clicked=false;
//var searchFlip = function() {
//  if clicked then return;
//  do all the cool stuff;
//  setTimeout(searchFlip, 3500);
//};
//searchFlip();
//$searchBox.click( clicked = true );

//OR clearTimeout