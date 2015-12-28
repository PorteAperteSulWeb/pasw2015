/**
 * PASW2015.js
 *
 * Some custom scripts for this theme.
 */
( function( $ ) {

	/*--------------------------------------------------------------
	Back-To-Top.
	--------------------------------------------------------------*/

	// Check to see if the window is top if not then display back-to-top button.
	$(window).scroll(function(){
		if ($(this).scrollTop() > 500) {
			$( ".back-to-top" ).addClass( "show-back-to-top" );
		} else {
			$( ".back-to-top" ).removeClass( "show-back-to-top" );
		}
	});

	// Click event to scroll to top.
	$( '.back-to-top' ).click(function(){
		$( 'html, body' ).animate({scrollTop : 0},800);
		return false;
	});

})( jQuery );