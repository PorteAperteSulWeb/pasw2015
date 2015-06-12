<?php

require (get_template_directory() . '/include/widget.php');
require (get_template_directory() . '/include/pagination.php');
require (get_template_directory() . '/github/github-updater.php');

add_action('init', 'load_modules'); //ocio!

function load_modules() {
    require (get_template_directory() . '/include/welcome-pasw2015.php' );

    if (get_option('pasw_mcolumn') != 0) { require ( get_template_directory() . '/include/moduli/pasw2015-multiple-columns.php' ); }
    if (get_option('pasw_catpage') != 0) { require ( get_template_directory() . '/include/moduli/pasw2015-category-page.php' ); }
    if (get_option('pasw_taxdest') != 0) { require ( get_template_directory() . '/include/moduli/pasw2015-destinatari.php' ); }
    if (get_option('pasw_msidebar') != 0) {
        require ( get_template_directory() . '/include/moduli/pasw2015-multiple-sidebars.php' );
        pasw_sidebar_generator::init();
    }
    if (get_option('pasw_eulaw') != 0) { require ( get_template_directory() . '/include/moduli/pasw2015-eulaw.php' ); }
}
add_action('admin_init', "reg_set_p");

function reg_set_p() {
    require (get_template_directory() . '/include/moduli-pasw2015.php' );

    register_setting( 'pasw2015_options', 'pasw_social');
    register_setting( 'pasw2015_options', 'pasw_email_scuola');
    register_setting( 'pasw2015_options', 'pasw_pec_scuola');
    register_setting( 'pasw2015_options', 'pasw_recapito_scuola');
    register_setting( 'pasw2015_options', 'pasw_indirizzo_scuola');
    register_setting( 'pasw2015_options', 'pasw_fluid_width');
    register_setting( 'pasw2015_options', 'pasw_loghi_footer');
    register_setting( 'pasw2015_options', 'pasw_testo_footer');
    register_setting( 'pasw2015_options', 'pasw_secondo_menu');
    register_setting( 'pasw2015_options', 'pasw_menu_login');
    register_setting( 'pasw2015_options', 'pasw_ga_id');
    register_setting( 'pasw2015_options', 'pasw_ga_profile_id');
    register_setting( 'pasw2015_options', 'pasw_ga_user');
    register_setting( 'pasw2015_options', 'pasw_key');
    register_setting( 'pasw2015_options', 'pasw_ga_password');
    register_setting( 'pasw2015_options', 'pasw_logo');
    register_setting( 'pasw2015_options', 'pasw_submenu', 'intval');

    register_setting( 'pasw2015_functions', 'pasw_mcolumn', 'intval');
    register_setting( 'pasw2015_functions', 'pasw_catpage', 'intval');
    register_setting( 'pasw2015_functions', 'pasw_taxdest', 'intval');
    register_setting( 'pasw2015_functions', 'pasw_msidebar', 'intval');

  if (!get_option('pasw_key')) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < 10; $i++) {
      $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    update_option( 'pasw_key', $randomString);

    if( -1 != get_option('page_on_front') ) {
      update_post_meta( get_option('page_on_front'), '_wp_page_template', 'tmpl_home.php' );
    } // end if
  }

    add_option( 'pasw2015_version');
    if (version_compare(get_option('pasw2015_version'), get_pasw2015_version(), "<")) {
        if (get_option('pasw2015_version') == '') {
          update_option( 'pasw_logo', get_bloginfo("template_url").'/images/repubblica-italiana.png');
        }
        update_option('pasw2015_version', get_pasw2015_version());
        wpgov_update();
        wp_safe_redirect(admin_url('/admin.php?page=pasw2015', 'http'), 301);
    }

    if (get_option('pasw_favicon') == '') {
        update_option( 'pasw_favicon', get_bloginfo("template_url").'/images/favicon.ico');
    }

}

add_action( 'after_setup_theme', 'pasw2015_setup' );
add_action('admin_notices', 'pasw_alerts');
function pasw_alerts() {
    if (is_admin() && get_option('pasw_wrongdirectory') == 1) {
        echo '<div class="error"><p>Pasw2015 è installato nella directory "<b>' . get_template() . '</b>". Per un corretto funzionamento è necessario cambiare il nome della cartella in "pasw2015".<br/>
        Questo messaggio scomparirà automaticamente correggendo il problema.</p></div>';
    }
}
function pasw2015_setup() {
    if (get_template() != 'pasw2015') {
        update_option('pasw_wrongdirectory', 1);
    } else {
        delete_option('pasw_wrongdirectory');
    }
}

function get_pasw2015_version() {
	$p2015_theme = wp_get_theme( 'pasw2015' );
	if ( $p2015_theme->exists() ) {
  		return wp_get_theme('pasw2015')->get( 'Version' );
	} else {
		update_option('pasw_wrongdirectory', 1);
		return wp_get_theme()->get( 'Version' );
	}
}

function is_pasw2015_child($c) {
	if ( wp_get_theme( 'pasw2015-child' )->exists() ) {
		if ($c) {
			return 'C';
		} else {
			return true;
		}
	} else {
		if ($c) {
			return '';
		} else {
			return false;
		}
	}
}

function pasw2015_stili() {
	// Main stylesheet
	wp_enqueue_style( 'pasw2015_styles', get_stylesheet_uri() , array());
	wp_enqueue_style( 'pasw2015_styles-print', get_template_directory_uri() . '/print.css',  null, null, 'print' );
}
add_action( 'wp_enqueue_scripts', 'pasw2015_stili' );

function pasw2015_favicon() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_option('pasw_favicon').'" />';
}
add_action('wp_head', 'pasw2015_favicon');

$defaults = array(
    'default-color'          => 'white',
    'default-image'          => get_template_directory_uri() . '/images/pattern_default_pasw2015.jpg',
    'default-repeat'         => 'repeat'
);
add_theme_support( 'custom-background', $defaults );

$args = array(
    'width'         => 1150,
    'height'        => 125,
    'flex-height'   => true,
    'flex-width'    => true,
    'default-image' => get_template_directory_uri() . '/images/header-default-pasw2015.jpg',
    'default-repeat'=> 'repeat',
    'default-text-color'    => '#00004d'
);
add_theme_support( 'custom-header', $args );
add_theme_support('post-thumbnails');
add_theme_support( 'title-tag' );

/* Menu */
add_action('init', 'register_my_menus');
function register_my_menus() {
  if (get_option('pasw_secondo_menu')) {
    $array_menu = array('menu-1' => 'Menù Superiore', 'menu-2' => 'Menù Principale', 'menu-4' => 'Menù Principale Secondario', 'menu-3' => 'Menù Inferiore');
  } else {
    $array_menu = array('menu-1' => 'Menù Superiore', 'menu-2' => 'Menù Principale', 'menu-3' => 'Menù Inferiore');
  }
  register_nav_menus($array_menu);
}

function pasw2015_widgets_init() {
  register_sidebar( array(
        'name' => 'Barra laterale (SX)',
        'id' => 'sidebar-1',
        'description' => 'Sidebar sinistra del sito web.'
    ) );
    register_sidebar( array(
        'name' => 'Barra laterale (DX)',
        'id' => 'sidebar-2',
        'description' => 'Sidebar destra del sito web.'
    ) );
    register_sidebar( array(
        'name' => 'Home (SX)',
        'id' => 'sidebar-6',
        'description' => 'Area Widget (1) della homepage.'
    ) );
    register_sidebar( array(
        'name' => 'Home (CX)',
        'id' => 'sidebar-7',
        'description' => 'Area Widget (2) della homepage.'
    ) );
    register_sidebar( array(
        'name' => 'Home (DX)',
        'id' => 'sidebar-8',
        'description' => 'Area Widget (3) della homepage.'
    ) );
    register_sidebar( array(
        'name' => 'Sotto home (SX)',
        'id' => 'sidebar-3',
        'description' => 'Area Widget (1) sotto la homepage.'
    ) );
    register_sidebar( array(
        'name' => 'Sotto home (CX)',
        'id' => 'sidebar-4',
        'description' => 'Area Widget (2) sotto la homepage.'
    ) );
    register_sidebar( array(
        'name' => 'Sotto home (DX)',
        'id' => 'sidebar-5',
        'description' => 'Area Widget (3) sotto la homepage.'
    ) );
}
add_action( 'widgets_init', 'pasw2015_widgets_init' );

/* returns the count of comments or pings depending */
function comment_count_special($post_id, $comment_type)
{
      $the_post_comments = get_comments('post_id=' . $post_id);
      $comments_by_type = &separate_comments($the_post_comments);
      return count($comments_by_type[$comment_type]);
}
/* Only return comment counts */
add_filter('get_comments_number', 'comment_count', 0);
function comment_count( $count )
{
      global $id;
      global $nearlysprung;
      if ($nearlysprung->option['splitpings'] != "yes")
      {
           return $count;
      }
      else
      {
         return comment_count_special($id, 'comment');
      }
}
function ns_comments($comment, $args, $depth)
{
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
      <div class="comment-author vcard">
         <?php echo get_avatar($comment->comment_author_email, $size = '40', $comment->comment_author_link); ?>
         <?php printf(__('<cite class="fn">%s</cite> <span class="says">said,</span>'), get_comment_author_link()) ?>
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>
      <div class="comment-meta commentmetadataa">
            <?php comment_date('F j, Y') ?>
            @ <a href="#comment-<?php comment_ID() ?>"><?php comment_time() ?></a>
            <?php edit_comment_link(__("Edit"), ' &#183; ', ''); ?>
      </div>
      <?php comment_text() ?>
      <div class="reply">
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>
     </div>
<?php
}
function ns_trackbacks($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-trackbackping-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
      <div class="comment-author vcard">
         <?php printf(__('<cite class="fn">%s</cite> <span class="says">said,</span>'), get_comment_author_link()) ?>
      </div>
      <div class="comment-meta commentmetadataa">
            <?php comment_date('F j, Y') ?>
            @ <a href="#trackbackping-<?php comment_ID() ?>"><?php comment_time() ?></a>
            <?php edit_comment_link(__("Edit"), ' &#183; ', ''); ?>
      </div>
      <?php comment_text() ?>
     </div>
<?php
}

function pasw2015_colors_register_theme_customizer( $wp_customize ) {

    $wp_customize->add_setting( 'pasw2015_colore_principale', array( 'default' => '#00004d', 'transport'   => 'postMessage' ));
    $wp_customize->add_setting( 'pasw2015_colore_secondario', array( 'default' => '#C2E2ED', 'transport'   => 'postMessage' ));

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'colore-principale',
            array(
                'label'      => 'Colore principale',
                'section'    => 'colors',
                'settings'   => 'pasw2015_colore_principale'
            )
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'colore-secondario',
            array(
                'label'      => 'Colore secondario',
                'section'    => 'colors',
                'settings'   => 'pasw2015_colore_secondario'
            )
        )
    );

}
add_action( 'customize_register', 'pasw2015_colors_register_theme_customizer' );

function pasw2015_customizer_css() { ?>

    <style type="text/css">
        <?php
            $c_principale = get_theme_mod( 'pasw2015_colore_principale', '#00004d');
            $c_secondario = get_theme_mod( 'pasw2015_colore_secondario', '#C2E2ED');
            
            if ( ! display_header_text() ) {
                echo '.site-title, .site-description { display:none; }';
            }
        ?>
        h1, h2, h3, h4 {
            color: <?php echo $c_principale; ?>;
        }
        input, textarea, select {
            box-shadow: 0 0 3px <?php echo $c_principale; ?>;
        }
        a:link, a:visited, a:hover, a:active {
            color: <?php echo $c_principale; ?>;
        }
        
        #topbar, #header ul.sito, #footer, #rightsidebar h2, .hdate, .sotto-pagine li:hover, #centrecontent a img:hover, .showall_widget a:hover {
            background-color: <?php echo $c_principale; ?>;
        }
        
        #wrapper, #topbar, #header ul.sito, #footer {
            box-shadow: 0 0 3px <?php echo $c_principale; ?>;
        }
        .posttitle, .pagetitle, #leftsidebar h2 {
            border-color: <?php echo $c_principale; ?>;
        }

        #centrecontent img {
            border-color: <?php echo $c_secondario; ?>;
        }
        
        #sidebarleft-100-background, #topbar ul li a:hover, #topbar ul li.current_page_item a, .showall_widget {
            background-color: <?php echo $c_secondario; ?>;
        }

        .col-com2, .sotto-pagine, .pagecat, .riassunto, .postmeta, .secondo-menu {
            background-color: <?php echo $c_secondario; ?>;
        }
        input#submit{
            background-color: <?php echo $c_secondario; ?>;
            border-bottom: 1px solid <?php echo $c_principale; ?>;
    </style>

    <?php
}
add_action( 'wp_head', 'pasw2015_customizer_css' );

function pasw2015_customizer_live_preview() {

    wp_enqueue_script(
        'pasw2015-theme-customizer',
        get_template_directory_uri() . '/js/theme-customizer.js',
        array( 'jquery', 'customize-preview' ),
        '0.3.0',
        true
    );

}
add_action( 'customize_preview_init', 'pasw2015_customizer_live_preview' );

function wpgov_update() {

    $options = array(
        'name' => get_bloginfo('name'),
        'key' => md5(get_option('pasw_key')),
        'address' => get_option('pasw_indirizzo_scuola'),
        'version' => get_option('pasw2015_version'),
        'domain' => site_url());

     $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_URL,'http://pasw2015.wpgov.it/welcome.php');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $options);
        $result = curl_exec($ch);
     curl_close($ch);
}

//add_filter( 'pre_get_posts', 'pasw_get_posts' );

function pasw_get_posts( $query ) {
    if( !is_admin() && $_SERVER['post_type'] == null) {
        if ( (is_home() || is_category() || is_tag() || is_archive()  || is_feed() ) && $query->is_main_query() ) {
            $query->set( 'post_type', array( 'any' ) );
        }
        return $query;
    }
}


// Replaces the excerpt "more" text by a link
function new_excerpt_more($more) {
       global $post;
	return '&nbsp; &nbsp; <a class="moretag" href="'. get_permalink($post->ID) . '" title="Leggi l&#180;intero articolo">&raquo;</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

// widget per visualizzare l'immagine in evidenza di una pagina o di un articolo (ad esempio sulla barra destra) 
class ThumbWidget extends WP_Widget {
    function ThumbWidget() {
        parent::__construct( false, 'Immagine in evidenza' );
    }
    function widget( $args, $instance ) {
        extract($args);
        echo $before_widget;
        
        if ( has_post_thumbnail() ) {
	         
           the_post_thumbnail('rightbar-thumb');
           
        } 
 
        echo $after_widget;
    }
    function update( $new_instance, $old_instance ) {
        return $new_instance;
    }
    function form( $instance ) {
    }
}
 
function register_ThumbWidget() {
    register_widget( 'ThumbWidget' );
  if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'rightbar-thumb', 180, 9999 );  
}
}
 
add_action( 'widgets_init', 'register_ThumbWidget' );
?>
