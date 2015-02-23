jQuery("document").ready(function($){

	if (pasw2015_javascript_params.fixedmenu) {
		var nav = $('#topbar');

		$(window).scroll(function () {
			if ( $(window).width() > 1024 && $(this).scrollTop() > pasw2015_javascript_params.headersizeh ) {
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

});