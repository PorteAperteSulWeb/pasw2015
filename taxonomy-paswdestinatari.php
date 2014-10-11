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
    <?php if (have_posts()) : ?>

    <h2 class="posttitle">Contenuti per <?php single_cat_title(); ?></h2>

    <div style="float:right;">
        <ul>
            <?php
                wp_dropdown_categories('show_count=1&hierarchical=1');
            ?>
            <script type="text/javascript">
                var dropdown = document.getElementById("cat");
                function onCatChange() {
                    if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
                        location.href = "<?php echo get_option('home');
            ?>/?cat="+dropdown.options[dropdown.selectedIndex].value;
                    }
                }
                dropdown.onchange = onCatChange;
            </script>
            <select name="archive-dropdown" onChange='document.location.href=this.options[this.selectedIndex].value;'>
                <option value="">Filtra per mese</option>
                <?php wp_get_archives('type=monthly&format=option&show_post_count=1'); ?>
            </select>
            <select name="archive-dropdown" onChange='document.location.href=this.options[this.selectedIndex].value;'>
                <option value="">Filtra per anno</option>
                <?php wp_get_archives('type=yearly&format=option&show_post_count=1'); ?>
            </select>
        </ul>
    </div>

    <h3>Archivio</h3>
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
        <h2><?php echo single_cat_title(); ?></h2>
        <p><?php _e('Spiacenti, ma non ci sono articoli per questa categoria.'); ?></p>
    <?php endif; ?>
    <div class="clear"></div>
    <div style="text-align:center;width:100%;">
        <?php _sds_numeric_posts_nav( 'nav-below' ); ?>
    </div>
    </div>
<?php include(TEMPLATEPATH . '/rightsidebar.php'); ?>
<?php get_footer(); ?>
