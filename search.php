<?php get_header(); ?>
<?php get_sidebar(); ?>

    <?php if (have_posts()) : ?>
        <h2 class="pagetitle">Risultati della ricerca</h2>
        <p>Di seguito sono elencati i risultati della ricerca. Speriamo che ci sia anche quello che stavi cercando.</p>
        <p>Se non hai trovato quello che sercavi, prova a fare una ricerca più generale.</p>

        <?php while (have_posts()) : the_post(); ?>
            <div class="post">
                <h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h3>
                <small><?php the_time('l, F jS, Y') ?></small>
                <p class="postmetadata">Pubblicato in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>
            </div>
        <?php endwhile; ?>
    <?php else : ?>
        <h2 class="center">Nessun articolo trovato</h2>
        <p><strong>Siamo spiacenti, ma la tua ricerca non ha dato risultati!</strong></p>
        <p>Prova ad allargare la ricerca. </p>
        <p><em>Prova ad inserire nel modulo di ricerca termini più generali.</em></p>
        <?php include (TEMPLATEPATH . '/searchform.php'); ?>
    <?php endif; ?>
</div>
<?php include(TEMPLATEPATH . '/rightsidebar.php'); ?>
<?php get_footer(); ?>
