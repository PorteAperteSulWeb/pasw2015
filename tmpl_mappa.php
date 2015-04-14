<?php
    /*
    Template Name: Mappa del Sito
    */
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>
    <div class="post" id="post-<?php the_ID(); ?>">
        <div class="postentry">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <h2 class="posttitle"><?php the_title(); ?></h2>
            <?php the_content(); ?>
            <?php endwhile; endif; ?>

                <div id="left">
                    <h3>Pagine</h3>
                    <ul>
                    <?php
                    wp_list_pages ("sort_column=menu_order&title_li=");
                    ?>
                    </ul>
                </div>
                <div id="right">
                    <h3>Categorie</h3>
                    <ul>
                    <?php
                    wp_list_categories ("hide_empty=0&sort_column=menu_order&title_li=");
                     ?>
                    </ul>
                </div>
        </div>
    </div>
</div>
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>

