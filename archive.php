<?php get_header(); ?>
<?php get_sidebar(); ?>
<!-- breadcrumbs -->
<div id="path">
<?php
if(function_exists('bcn_display'))
{
    bcn_display();
}
?>
</div>
<!-- fine breadcrumbs -->

        <?php
            if (single_cat_title( '', false )) {
                echo '<h2>'; single_cat_title( '', true ); echo '</h2>';

                echo '<div style="float:right;"><small>';
                include(TEMPLATEPATH . '/include/archive-filters.php');
                echo '</small></div>';

            } else {
                echo '<h2>Archivio</h2>';
            }
        ?>

     <?php if (have_posts()) : ?>

    <?php if( is_tax( 'tipologie' ) ) { echo '<div class="clear"></div>'; at_archive_buttons(); } ?>

        <?php while (have_posts()) : the_post(); ?>

        <div class="post-box-archive">
        <span class="hdate"><?php the_time('j F y'); ?></span>

            <a href="<?php the_permalink(); ?>">
            <?php
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail(array(100,100));
                }
            ?>
            </a>

            <h4 class="piccino"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <div class="piccino">
                        <?php the_excerpt(); ?>
                    </div>
        </div>
        <?php endwhile; ?>
    <?php else : ?>
        <p><div class="clear"></div><br/><br/>Spiacenti, ma non ci sono articoli per questa categoria.</p>
    <?php endif; ?>
    <div class="clear"></div>
    <div style="text-align:center;width:100%;">
        <?php _sds_numeric_posts_nav( 'nav-below' ); ?>
    </div>
    </div>
<?php include(TEMPLATEPATH . '/rightsidebar.php'); ?>
<?php get_footer(); ?>
