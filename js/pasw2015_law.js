(function($){'use strict';
	var bannerText= pasw2015_law_text.message;
	var buttonText= pasw2015_law_text.button;
	var moreText= pasw2015_law_text.more;
	var url= pasw2015_law_text.url;
	var timeexpire= parseInt(pasw2015_law_text.fine);
	var revoca = "Revoca cookie";
	var show = parseInt(pasw2015_law_text.bottom_active);
	var position = parseInt (pasw2015_law_text.position);
	var styleposition = 'bottom: 5px;';
	var bgbanner = pasw2015_law_text.bgbanner;
	var textcolor = pasw2015_law_text.textcolor;
	
	if (position == 1){styleposition = 'top: 5px';}
	
	if ( 'yes' !== $.cookie( 'pasw_law_cookie' ) ) {$('body').prepend('<div class="pasw2015cookies" style="background: none repeat scroll 0 0 '+ bgbanner +' ;display: block;'+ styleposition +'"><div class="cookie-pop"><p class="pasw2015cookies-banner-text" style="color:'+ textcolor +'">'+ bannerText + '</p> <a href="'+url+'">' + moreText +'</a>&nbsp;&nbsp;<button id="accept-cookie">' + buttonText + '</button> </div></div>');$( '#accept-cookie' ).click(function () {$.cookie( 'pasw_law_cookie', 'yes' , { expires: timeexpire, path: '/' });$( '.cookie-pop' ).remove();location.reload();});}

//	if ( 'yes' == $.cookie( 'pasw_law_cookie' ) ) {$('body').prepend('<a href="#" id="remove-cookie" class="remove-cookie">Revoca Cookie</a>');$( '#remove-cookie' ).click(function () {$.removeCookie( 'pasw_law_cookie', {path: '/' });location.reload();});}
	if ( 'yes' == $.cookie( 'pasw_law_cookie' ) && show == 1 ) {$('body').prepend('<a href="#" id="remove-cookie" class="remove-cookie">Revoca Consenso<br>Cookie</a>');}

	$( '#remove-cookie' ).click(function () {$.removeCookie( 'pasw_law_cookie', {path: '/' });location.reload();});
	$( '#remove-cookie-short' ).click(function () {$.removeCookie( 'pasw_law_cookie', {path: '/' });location.reload();});

	
})(jQuery);

