<?
/*
Template Name: Statistiche
*/
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>
    <div class="post" id="post-<?php the_ID(); ?>">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <h2 class="posttitle"><?php the_title(); ?></h2>
        <?php the_content(); ?>
        
        <?php 
            if ( get_option( 'pasw_ga_password' ) ) {
                require_once('include/GAAPIOLD/gacounter.php');
            } else {
                require_once('include/GAAPI/gacounter.php');
            }
        ?>
        <?php endwhile; endif; ?>
    </div>
</div>
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>
