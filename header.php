<!DOCTYPE html>
<html>

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<meta name="viewport" content="width=device-width">
<meta property="og:image" content="<?php echo get_option('pasw_logo'); ?>" />
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php
    wp_head();
    include(TEMPLATEPATH . '/include/frontend/google-analytics.php');
?>

</head>

<?php flush(); ?>

<body class="custom-background">

<div id="header" style="height: <?php echo get_custom_header()->height; ?>px; background: url(<?php header_image(); ?>);color:#<?php header_textcolor(); ?>;">

    <div id="header-interno">

        <a href="<?php bloginfo('url'); ?>"><img class="site-title" style="max-height:110px;" src="<?php echo get_option('pasw_logo'); ?>" alt="" class="logo"/></a>

            <h1 style="color:#<?php header_textcolor(); ?>;" class="site-title">
                <a style="color:#<?php header_textcolor(); ?>;" href="<?php bloginfo('url'); ?>">
                    <?php bloginfo('name'); ?>
                </a>
            </h1>
            <div class="site-description"><?php bloginfo('description'); ?>
            <br/>
            <small>
                <?php echo stripslashes(get_option('pasw_indirizzo_scuola')) . ' &bull; ' . stripslashes(get_option('pasw_recapito_scuola')); ?>
            </small>
            </div>
    
    <div id="topbar" <?php if (get_option('pasw_fluid_layout') == '0') { echo 'style="max-width: 1150px;"'; } ?>>

    <?php
        $append_link = '<ul id="%1$s" class="%2$s">%3$s</ul>';
    
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
    
    </div>

</div>

<div id="wrapper" <?php if (get_option('pasw_fluid_layout') == '0') { echo 'style="max-width: 1150px;"'; } ?>>

<div id="sidebarleft-100-background"></div>

<div id="container">
