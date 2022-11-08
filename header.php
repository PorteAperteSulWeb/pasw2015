<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    
	<?php if (get_option('pasw_responsive_layout') == 1) { ?>
		<meta name="viewport" content="width=device-width">
	<?php } ?>

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php if (get_option('pasw_fixedmenu') == 1) { ?>
<script src="<?php echo get_template_directory_uri() . '/js/jquery.min.js';?>"></script>
<script>
    jQuery("document").ready(function($){
    var nav = $('#topbar');
    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    $(window).scroll(function () {
        if ($(this).scrollTop() > <?php echo get_custom_header()->height + 30; ?> && width >= 1024) {
            nav.addClass("f-nav");
        } else {
            nav.removeClass("f-nav");
        }
    });

});
</script>
<?php
    if ( is_user_logged_in() ) {
        echo '<style>.f-nav { top:30px; }</style>';
    }
}
    wp_head();
    include(TEMPLATEPATH . '/include/frontend/google-analytics.php');
?>

</head>

<?php flush(); ?>

<body class="custom-background">

<div id="wrapper" <?php if (get_option('pasw_fluid_layout') == '0') { echo 'style="max-width: 1150px;"'; } ?>>

<div id="sidebarleft-100-background"></div>

<div id="header" style="height: <?php echo get_custom_header()->height; ?>px; background: url(<?php header_image(); ?>);color:#<?php header_textcolor(); ?>;">

        <?php
            if(function_exists('wp_nav_menu') && has_nav_menu( 'menu-1' ) ) {
                wp_nav_menu( array( 'menu' => '', 'container' => 'ul', 'menu_class' => 'sito', 'theme_location' => 'menu-1' ) );
            } else {
                echo '<ul class="sito"></ul>';
            }
        ?>
    <div class="clear"></div>
    <div id="header-interno">

        <?php 
		$header_image = get_option('pasw_logo');	
		$lung= strlen($header_image);
		if ( $lung > 7 ) { ?>
			<a href="<?php bloginfo('url'); ?>"><img style="max-height:110px;" src="<?php echo get_option('pasw_logo'); ?>" alt="vai alla home" class="logo"/></a>
		<?php } ?>

            <h1 style="color:#<?php header_textcolor(); ?>;" class="site-title">
                <a style="color:#<?php header_textcolor(); ?>;" href="<?php bloginfo('url'); ?>">
                    <?php bloginfo('name'); ?>
                </a>
            </h1>
	    <small>
            <div class="site-description">
		<?php bloginfo('description'); ?>
            	<br>
                <?php echo stripslashes(get_option('pasw_indirizzo_scuola')) . ' &bull; ' . stripslashes(get_option('pasw_recapito_scuola')); ?>
            </div>
	    </small>

    </div>
</div>
<?php if (get_option('pasw_search_show') == '0') { ?>
    <form class="topsearch-div" method="get" id="searchform" action='<?php echo bloginfo('url');?>' >
        <div>
            <label class="screen-reader-text" for="s">Cerca:</label>
            <input placeholder="Cerca..." type="text" value="" name="s" id="s" />
        </div>
    </form>
<?php    }
?>      
<div id="topbar">

<?php
    $append_link = '<ul id="%1$s" class="%2$s">%3$s';
    if ( is_user_logged_in() ) {
                $append_link .= '<li><a href="' . wp_logout_url() . '" id="btn-logout">Esci</a></li>';
        } else if (!get_option('pasw_menu_login')) {
                $append_link .= '<li><a href="' . wp_login_url() . '" id="btn-login">Log in</a></li>';
    }
    $append_link .= '</ul>';

    if(function_exists('wp_nav_menu') && has_nav_menu( 'menu-2' ) ) {
        wp_nav_menu( array( 'menu' => '', 'items_wrap' => $append_link, 'container' => '', 'menu_class' => 'menu-principale-responsivo', 'theme_location' => 'menu-2' ) );
    } else     {
        echo '
        <ul id="menu-menu-superiore">
            <li id="menu-item-0" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-0">

            </li>
        </ul>';
    }
?>

</div>

<div id="container">
