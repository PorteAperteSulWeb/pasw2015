<?
/*
Template Name: Statistiche
*/
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>
    <div class="post" id="post-<?php the_ID(); ?>">
        <h2 class="posttitle"><?php the_title(); ?></h2>
        <?php require_once('include/GAAPI/gacounter.php'); ?>
    </div>
</div>
<?php include(TEMPLATEPATH . '/rightsidebar.php'); ?>
<?php get_footer(); ?>
