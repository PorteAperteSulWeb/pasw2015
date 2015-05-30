(function($){'use strict';
	// var bannerText= "I cookie ci aiutano a migliorare il sito. Utilizzando il sito, accetti l'utilizzo dei cookie da parte nostra.";
	var bannerText= pasw2015_law_text.message;
	var buttonText= pasw2015_law_text.button;
	var moreText= pasw2015_law_text.more;
	var url= pasw2015_law_text.url;
	if ( 'yes' !== $.cookie( 'pasw_law_cookie' ) ) {$('body').prepend('<div class="pasw2015cookies" style="display: block;"><div class="cookie-pop"><p class="pasw2015cookies-banner-text">'+ bannerText +'</p> <a href="'+url+'">' + moreText + '</a>&nbsp;&nbsp;<button id="accept-cookie">' + buttonText + '</button> </div></div>');$( '#accept-cookie' ).click(function () {$.cookie( 'pasw_law_cookie', 'yes' );$( '.cookie-pop' ).remove();location.reload();});}
})(jQuery);
