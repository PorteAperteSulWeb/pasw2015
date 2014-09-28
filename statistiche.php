<?
/*
Template Name: Statistiche
*/
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>
<div id="centrecontent" class="column">
<?php require_once('include/GAAPI/gacounter.php'); ?>
</div>
<?php include(TEMPLATEPATH . '/rightsidebar.php'); ?>
<?php get_footer(); ?>