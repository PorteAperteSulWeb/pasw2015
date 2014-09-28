<?php get_header(); ?>
<?php get_sidebar(); ?>
<div class="nascosto">
<strong> Navigazione veloce </strong>
<ul>
<li><a href="#wrapper">torna in cima</a></li>
<li><a href="#centrecontent">vai al contenuto</a></li>
<li><a href="#leftsidebar">vai alla navigazione principale</a></li>
</ul>
</div>
<div id="centrecontent" class="column">
<div class="nascosto">
<strong> Navigazione veloce </strong>
<ul>
<li><a href="#wrapper">torna in cima</a></li>
<li><a href="#leftsidebar">vai alla navigazione principale</a></li>
<li><a href="#rightsidebar">vai alla navigazione contestuale</a></li>
</ul>
</div>
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
	
		<?php $post = $posts[0]; // Thanks Kubrick for this code ?>
		
<?php if (is_category()) { ?>				
		<h2><?php _e('Articoli in'); ?> <?php echo single_cat_title(); ?></h2>		
 	  	<?php } elseif (is_day()) { ?>
		<h2><?php _e('Articoli in'); ?> <?php the_time('F j, Y'); ?></h2>
		
	 	<?php } elseif (is_month()) { ?>
		<h2><?php _e('Articoli in'); ?> <?php the_time('F, Y'); ?></h2>
		<?php } elseif (is_year()) { ?>
		<h2><?php _e('Articoli in'); ?> <?php the_time('Y'); ?></h2>
		<?php } elseif (is_author()) { ?>
		<h2><?php _e('Articoli di'); ?></h2>
		<?php } elseif (is_search()) { ?>
		<h2><?php _e('Risultati ricerca'); ?></h2>
		<?php } ?>
				
		<?php while (have_posts()) : the_post(); ?>
		
			<div class="post" id="post-<?php the_ID(); ?>">
				<h2 class="posttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<?php if (is_page()) { 
				$children = wp_list_pages('title_li=&depth=1&child_of='.$post->ID.'&echo=0');
				if ($children) { ?>
				<ul class="gerarchia">
				<?php echo $children; ?>
				</ul>
				<?php }
				} ?>
				<p class="postmeta">
				<?php if (!is_page()) { ?>
				<span class="postauthor"><?php _e('Scritto da '); ?><?php the_author(); ?></span><?php _e(' ('); ?>
				<?php the_time('F j, Y') ?> <?php _e('alle'); ?> <?php the_time() ?><?php _e(')'); ?>
				<?php if ( is_callable(array('GeoMashup','show_on_map_link')) ) {
				  $linkString = GeoMashup::show_on_map_link('text=Map%20&show_icon=false');
				  if ($linkString != "")
				  {
				  	echo ' &#183; ';
				  	echo $linkString;
				  }
				} ?>
				&#183; <?php _e('Contenuto in'); ?> <?php the_category(', ') ?><?php $posttags = get_the_tags($post->ID); 
							if ($posttags) { ?>
								<span>- Tag:</span>
								<?php 
								foreach($posttags as $tag) {
									echo '<a href="';
									echo get_tag_link($tag);
									echo '">';
									echo $tag->name . ' ';
									echo '</a>';
								}
							}
			?>
				<?php } ?>
				<?php edit_post_link(__('Edit'), ' &#183; ', ''); ?>
				</p>
			
				<div class="postentry">
				<?php if (is_search()) { ?>
					<?php the_excerpt() ?>
				<?php } else { ?>
					<?php the_content(__('Leggi il resto &raquo;')); ?>
					<?php if (is_single()) { ?>
						<?php link_pages('', '', 'next') ?>
					<?php } ?>
				<?php } ?>
				</div>
			
				<p class="postfeedback">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permaink a'); ?> <?php the_title(); ?>" class="permalink"><?php _e('Permalink'); ?></a>			
				<?php // add support for wp-email 
					if(function_exists('wp_email')) { email_link('E-Mail to a friend', 'E-Mail to a friend', ' class="permalink"'); } ?>
				<?php 
				global $nearlysprung;
  				if ($nearlysprung->option['splitpings'] != "yes")
				{
					$pingCount = 0;
				}
				else
				{
					$pingCount = comment_count_special($post->ID, 'pings');
				}
				comments_popup_link(__('Comments'), __('Comments (1)'), __('Comments (%)'), 'commentslink', __('Comments off')); 
				if ($pingCount > 1)
				{ ?>
				<a href="<?php the_permalink() ?>#trackback" title="Trackback" class="trackbacklink">Trackbacks / Pingbacks (<?php echo $pingCount; ?>)</a>
				<?php 
				} 
				else
				{
				 	if ($pingCount > 0)
				 	{ ?>
				<a href="<?php the_permalink() ?>#trackback" title="Trackback" class="trackbacklink">Trackback / Pingback (<?php echo $pingCount; ?>)</a>
				<?php 
					}
				} ?>
				</p>
				
				<!--
				<?php trackback_rdf(); ?>
				-->
			
			</div>
				
		<?php endwhile; ?>
		<p><?php posts_nav_link(' ', __(' '), __('&laquo; Articoli precedenti')); ?>
		<?php posts_nav_link(' &#183; ', __(' '), __(' ')); ?>
		<?php posts_nav_link(' ', __('Articolii successivi &raquo;'), __(' ')); ?></p>
				
	<?php else : ?>
		<h2><?php _e('Non trovato'); ?></h2>
		<p><?php _e('Spiacenti, ma nessun articolo corrisponde ai criteri'); ?></p>
	<?php endif; ?>
</div>
<div class="nascosto">
<strong> Navigazione veloce </strong>
<ul>
<li><a href="#wrapper">torna in cima</a></li>
<li><a href="#centrecontent">vai al contenuto</a></li>
<li><a href="#rightsidebar">vai alla navigazione contestuale</a></li>
</ul>
</div>
<?php include(TEMPLATEPATH . '/rightsidebar.php'); ?>
<?php get_footer(); ?>