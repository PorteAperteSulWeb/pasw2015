<?php get_header(); ?>
<?php get_sidebar(); ?>

    <?php if (have_posts()) : ?>
        <h2 class="pagetitle">Risultati della ricerca</h2>
        <p>Di seguito sono elencati i risultati della ricerca. Speriamo che ci sia anche quello che stavi cercando.</p>

        <?php while (have_posts()) : the_post(); ?>
            <div class="post">
                <h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h3>
                <small><?php the_time('l, F jS, Y') ?></small>
            </div>
        <?php endwhile; ?>
    <?php else : ?>
    <h2 style="text-align: center;font-size: 20em;line-height: 0;margin-top: 0.5em;">:(</h2><br/>
         <p style="text-align: center;font-size: 2em;color: #25385D;">Nessun risultato trovato</p>Prova con una ricerca più generale o con parole chiave differenti...<br/><br/>
        <?php include (TEMPLATEPATH . '/searchform.php'); ?>
    <?php endif; ?>
</div>
<?php include(TEMPLATEPATH . '/rightsidebar.php'); ?>
<?php get_footer(); ?>
