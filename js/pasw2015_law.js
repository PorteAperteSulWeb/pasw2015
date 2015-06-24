(function($){'use strict';
	var bannerText= pasw2015_law_text.message;
	var buttonText= pasw2015_law_text.button;
	var moreText= pasw2015_law_text.more;
	var url= pasw2015_law_text.url;
	var timeexpire= parseInt(pasw2015_law_text.fine);
	var revoca = "Revoca cookie";
	var show = parseInt(pasw2015_law_text.bottom_active);
	var position = parseInt (pasw2015_law_text.position);
	var positionrevocalr = parseInt (pasw2015_law_text.positionrevocalr);
	var positionrevocatb = parseInt (pasw2015_law_text.positionrevocatb);
	var styleposition = 'bottom: 35px;';
	var bgbanner = pasw2015_law_text.bgbanner;
	var textcolor = pasw2015_law_text.textcolor;
	var acceptOnClick = parseInt (pasw2015_law_text.acceptOnClick);
	var cookieName = pasw2015_law_text.cookieName;
	
	
	// creazione link pagina cookie
	var cookiePolicyLink = "<span class='pasw2015eu-policy-link'>&nbsp;&nbsp;<button id='go-cookie'>" + moreText + "</button></span>";
	
	// verifica posizione pagina
	var chekposition = document.location.href.indexOf(url);
	
	if (position == 1){styleposition = 'top: 15px';}
	if (positionrevocalr == 1) {positionrevocalr = 'right:10px;';} else {positionrevocalr = 'left:10px;';}
	if (positionrevocatb == 1) {positionrevocatb = 'top:25px;';} else {positionrevocatb = 'bottom:25px;';}
	
	if(!_checkCookie(cookieName)) {$('body').prepend('<div class="pasw2015cookies" style="display: block;'+ styleposition +'"><div class="pasw2015cookies-cookie-pop" style="background: none repeat scroll 0 0 '+ bgbanner +' ;"><div class="pasw2015cookies-banner-text" style="color:'+ textcolor +'">'+ bannerText + cookiePolicyLink +'&nbsp;&nbsp;<button id="accept-cookie">' + buttonText + '</button></div> </div></div>');$( '#accept-cookie' ).click(function () {_laweuAccept(cookieName);});}
	if ( _checkCookie(cookieName) && show == 1 ) {$('body').prepend('<a href="#" id="remove-cookie" class="remove-cookie" style="'+ positionrevocalr + positionrevocatb +'">Revoca Consenso<br>Cookie</a>');}

	$( '#remove-cookie' ).click(function () { _laweuRemove(cookieName); });
	$( '#remove-cookie-short' ).click(function () { _laweuRemove(cookieName); });
	$( '#go-cookie' ).click(function () { window.location.href = url ; });
	
	if((acceptOnClick == 1) && (!_checkCookie(cookieName))){

		if(chekposition !== -1)
		{}
		else
		{
			$(document).on("click.pasw2015cookie", "a", function() {
				if(!$(this).parent().hasClass("pasw2015eu-policy-link")) {
						_laweuAccept(cookieName);
						$(document).off("click.pasw2015cookie", "a");
					}
				});

		}
	}

	/*----------------------------------------
	 * Pasw2015 Cookies module functions 
	-----------------------------------------*/
	
	function _checkCookie(cookieName) {
	    return document.cookie.match(new RegExp(cookieName + '=([^;]+)'));
	}
	
	function _laweuAccept(cookieName) {
		$.cookie( cookieName, 'yes' , { expires: timeexpire, path: '/' });
		$( '.cookie-pop' ).remove();location.reload();
	}

	function _laweuRemove(cookieName) {
		$.removeCookie( cookieName, {path: '/' });
		location.reload();
	}
	
})(jQuery);

