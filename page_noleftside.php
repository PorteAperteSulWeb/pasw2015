<?php
/*
Template Name: Pagina senza B.L. SX
*/
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>
<style>
#centrecontent {
    width: 77%;
}
</style>

<!-- breadcrumbs -->
<div id="path">
<?php if(function_exists('bcn_display')) { bcn_display(); } ?>
</div>
<!-- fine breadcrumbs -->

<?php if (have_posts()){
        while (have_posts()) : the_post();
?>            <div class="post" id="post-<?php the_ID(); ?>">

            <div class="lastmodified">
            Ultima modifica: <?php the_modified_date('j F Y'); ?>
            </div>

                <h2 class="posttitle"><?php the_title(); ?></h2>

                <?php $children = wp_list_pages('depth=1&title_li=&child_of='.$post->ID."&echo=0");
                if($children){ ?>
                <div class="sotto-pagine">
                    <ul>
                        <?php wp_list_pages('depth=1&title_li=&child_of='.$post->ID); ?>
                    </ul>
                </div>
                <?php } ?>
                <div class="postentry">
                    <?php the_content(__('Leggi il resto &raquo;')); ?>
                </div>
            </div>
<?php   endwhile; } ?>
<?php
    $TitoloPagina=$post->post_title;
    if ( get_post_meta($post->ID, 'usrlo_pagina_categoria', true)!=-1 ) {
        $categoria_pagina = get_post_meta($post->ID, 'usrlo_pagina_categoria', true);
        if(isset($categoria_pagina)){
            echo '<div class="clear"></div>
                    <div class="pagecat">';

            $category_link = get_category_link( $categoria_pagina );
            echo '<a style="float:right;padding: 20px;" href="' . esc_url( $category_link ) . '" title="Tutte le ' .  get_cat_name( $categoria_pagina) . '">Visualizza tutto &raquo;</a>';

            echo '<h3>Ultime 5 ' . strtolower ( get_cat_name( $categoria_pagina)) . ' inserite:</h3>';
            global $post;
                    $myposts = get_posts('numberposts=5&category='.$categoria_pagina);
                    foreach($myposts as $post) :
                            setup_postdata($post);
                            global $more;
                            $more = 0;
                    ?>
                        <h4><font class="hdate"><?php the_time('j F Y') ?></font> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                  <?php the_excerpt();
                    endforeach;

            echo '</div>';
        }
    }
?>
</div>
<?php
get_footer();
?>
