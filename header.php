<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="it-IT" >

<head>

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php if ( function_exists('optimal_title') ) { ?><?php optimal_title(); ?><?php bloginfo('name'); ?><?php } else { ?><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?><?php } ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/print.css" type="text/css" media="print" />
<link rel="shortcut icon" type="image/ico" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php wp_head(); ?>

<?php if (get_option('pasw_ga_id')) { ?>
    <script type="text/javascript">
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', '<?php echo get_option('pasw_ga_id'); ?>', 'auto');
      ga('send', 'pageview');

    </script>
<?php } ?>

</head>

<?php flush(); ?>

<body class="custom-background">

<div id="wrapper" <?php if (get_option('pasw_fluid_layout') == '0') { echo 'style="max-width: 1150px;"'; } ?>>

<div id="sidebarleft-100-background"></div>

<div id="header" style="background: url(<?php header_image(); ?>);color:#<?php header_textcolor(); ?>;">

<?php
    if(function_exists('wp_nav_menu') && has_nav_menu( 'menu-1' ) ) {
        wp_nav_menu( array( 'menu' => '', 'container' => 'ul', 'menu_class' => 'sito', 'theme_location' => 'menu-1' ) );
    } else {
        echo '<ul class="sito"></ul>';
    }
?>

<div class="clear"></div>

<a href="<?php bloginfo('url'); ?>"><img style="margin-top: -10px;margin-left: 20px;margin-right:10px;max-height:110px;" src="<?php echo get_option('pasw_logo'); ?>" alt="" class="logo"/></a>

    <div class="head-widget">

    </div>

    <h1 style="color:#<?php header_textcolor(); ?>;"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1><?php // echo stripslashes(get_option('Pasw_Testa')); ?>
<?php echo stripslashes(get_bloginfo('description')); ?>
    <br/>
    <small>
        <?php echo get_option('pasw_indirizzo_scuola') . ' &bull; ' . get_option('pasw_recapito_scuola'); ?>
    </small>

</div>

<div id="topbar">

        <form style="float:right;padding: 1px;margin-right: 2px;" method="get" id="searchform" action='<?php echo bloginfo('url');?>' >
            <div><label class="screen-reader-text" for="s">Cerca:</label>
                <input type="text" value="" name="s" id="s" />
            </div>
        </form>

<?php
    $append_link = '<ul id="%1$s" class="%2$s">%3$s';
    if ( is_user_logged_in() ) {
                $append_link .= '<li><a href="' . wp_logout_url() . '" style="background-color: red;">Esci</a></li>';
        } else if (!get_option('pasw_menu_login')) {
                $append_link .= '<li><a href="' . wp_login_url() . '" style="background-color: green;">Log in</a></li>';
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
