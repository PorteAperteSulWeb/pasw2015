(function( $ ) {
    "use strict";
 
    wp.customize( 'pasw2015_colore_principale', function( value ) {
        value.bind( function( to ) {
            $( '#topbar' ).css( 'background-color', to );
			$( '#footer' ).css( 'background-color', to );
			$( '#header ul.sito' ).css( 'background-color', to );
			$( '#rightsidebar h2' ).css( 'background-color', to );
			$( '.hdate' ).css( 'background-color', to );
			
			$( '#header h1 a' ).css( 'color', to );
			$( 'a:link' ).css( 'color', to );
			$( 'a:visited' ).css( 'color', to );
			$( 'a:hover' ).css( 'color', to );
			$( 'a:active' ).css( 'color', to );
        } );
    });
	
	wp.customize( 'pasw2015_colore_secondario', function( value ) {
        value.bind( function( to ) {
            $( '#sidebarleft-100-background' ).css( 'background-color', to );
			$( '#topbar ul li a:hover' ).css( 'background-color', to );
			$( '#topbar ul li.current_page_item a' ).css( 'background-color', to );
			$( '.col-com2' ).css( 'background-color', to );
			
        } );
    });
 
})( jQuery );