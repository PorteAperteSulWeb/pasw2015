jQuery("document").ready(function($){

	if (pasw2015_javascript_params.fixedmenu) {
		var nav = $('#topbar');

		$(window).scroll(function () {
			if ( pasw2015_javascript_params.fixedmenu && $(window).width() > 1024 && $(this).scrollTop() > pasw2015_javascript_params.headersizeh ) {
				nav.addClass("f-nav");
			} else {
				nav.removeClass("f-nav");
			}
		});
	}

	if (pasw2015_javascript_params.responsive) {
		$("#responsive-controls").click(function(){
            if ( $( "#leftsidebar" ).hasClass( "ls-responsive" ) ) {
                $( "#leftsidebar" ).removeClass( "ls-responsive" );
                $( "#rightsidebar" ).removeClass( "rs-responsive" );
            } else {
                $( "#leftsidebar" ).addClass( "ls-responsive" );
                $( "#rightsidebar" ).addClass( "rs-responsive" );
            }
        });
        $("#centrecontent").click(function(){
            $( "#leftsidebar" ).removeClass( "ls-responsive" );
            $( "#rightsidebar" ).removeClass( "rs-responsive" );
        });
	}
	
	if (pasw2015_javascript_params.eulaw && $(window).width() > 480) {
		
/*! jquery.cookie v1.4.1 | MIT */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?a(require("jquery")):a(jQuery)}(function(a){function b(a){return h.raw?a:encodeURIComponent(a)}function c(a){return h.raw?a:decodeURIComponent(a)}function d(a){return b(h.json?JSON.stringify(a):String(a))}function e(a){0===a.indexOf('"')&&(a=a.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\"));try{return a=decodeURIComponent(a.replace(g," ")),h.json?JSON.parse(a):a}catch(b){}}function f(b,c){var d=h.raw?b:e(b);return a.isFunction(c)?c(d):d}var g=/\+/g,h=a.cookie=function(e,g,i){if(void 0!==g&&!a.isFunction(g)){if(i=a.extend({},h.defaults,i),"number"==typeof i.expires){var j=i.expires,k=i.expires=new Date;k.setTime(+k+864e5*j)}return document.cookie=[b(e),"=",d(g),i.expires?"; expires="+i.expires.toUTCString():"",i.path?"; path="+i.path:"",i.domain?"; domain="+i.domain:"",i.secure?"; secure":""].join("")}for(var l=e?void 0:{},m=document.cookie?document.cookie.split("; "):[],n=0,o=m.length;o>n;n++){var p=m[n].split("="),q=c(p.shift()),r=p.join("=");if(e&&e===q){l=f(r,g);break}e||void 0===(r=f(r))||(l[q]=r)}return l};h.defaults={},a.removeCookie=function(b,c){return void 0===a.cookie(b)?!1:(a.cookie(b,"",a.extend({},c,{expires:-1})),!a.cookie(b))}});

		(function($){'use strict';
		var bannerText= pasw2015_javascript_params.message;
		var buttonText= pasw2015_javascript_params.button;
		var moreText= pasw2015_javascript_params.more;
		var url= pasw2015_javascript_params.url;
		if ( 'yes' !== $.cookie( 'pasw_law_cookie' ) ) {
			$('body').prepend('<div class="pasw2015cookies" style="display: block;"><div class="cookie-pop"><p class="pasw2015cookies-banner-text">'+ bannerText +'</p> <a href="'+url+'">' + moreText + '</a>&nbsp;&nbsp;<a href="" id="accept-cookie">' + buttonText + '</a> </div></div>');
			$( '#accept-cookie' ).click(function () {
				$.cookie( 'pasw_law_cookie', 'yes' );
				$( '.cookie-pop' ).remove();
			}
			);
		}
	})(jQuery);
	}

});
