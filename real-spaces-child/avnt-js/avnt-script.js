jQuery(document).ready(function($) {
  $( '#share-box' ).hide();
  $( '#share' ).click(function() {
    $( '#share-box' ).slideToggle( 400 );
  });

  setTimeout(searchFlip, 0);
  
  function searchFlip() {
    var $searchBox = $( 'div.search-field' ).find( 'button' );
    var numOptions = $( 'div.search-field select' ).children().length;
    console.log( numOptions );
    
    
    var index = 2;
    setInterval(function() {
      if(index > numOptions) { index = 2 };
      
      $searchBox.children( 'span.searchWord' ).remove();
      var searchWord = $( 'div.search-field select option:nth-child(' + index + ')').text();
      var $searchWord = $( '<span class="searchWord">' + searchWord + '</span>');
      $searchWord.hide();
      $searchWord.prependTo( $searchBox ).slideDown();
      
      $( 'div.search-field select' ).val( searchWord.toLowerCase() ).change();
      console.log( $('div.search-field select').val() );
      //console.log(searchWord);
      //console.log(index);
      setTimeout(function() {
        $searchBox.children( 'span.searchWord' ).slideUp();
      }, 3000);
      
      index = index+1;
    }, 3500);
    
    
    
  };
  
});

