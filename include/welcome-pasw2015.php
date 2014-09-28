<?php

require ( get_template_directory() . '/include/impostazioni-pasw2015.php' );

add_action('admin_menu', 'pasw2015_menu');

function pasw2015_menu() {

	add_menu_page('WordPress PASW 2015', 'Pasw 2015', 'manage_options', 'pasw2015', 'pasw2015_welcome', 'dashicons-screenoptions', 63);
	add_submenu_page('pasw2015', 'Moduli', 'Moduli', 'manage_options', 'pasw2015-moduli', 'pasw2015_moduli' );
	add_submenu_page('pasw2015', 'Impostazioni', 'Impostazioni', 'manage_options', 'pasw2015-impostazioni', 'pasw2015_impostazioni' );
}

function pasw2015_welcome() { ?>
	<div class="wrap about-wrap">
		<h1>Benvenuto in Pasw 2015 <small><?php echo get_option('pasw2015_version'); ?></small></h1>
		<div class="about-text">Pasw2015 è il nuovo tema realizzato dalla Comunità di Pratica Porte Aperte sul Web.
		<br/>Bello, accessibile e innovativo.</div>
		<div class="wp-badge">Pasw2015 
		<?php echo get_option('pasw2015_version') . '<br/>';
		$filename = get_theme_root() . '/pasw2015/style.css';
		if (file_exists($filename)) {
    		echo date ("d M Y", filemtime($filename));
		}
   		?></div>

<ul class="wp-people-group ">
	<li class="wp-person">
		<a href=""><img src="http://www.gravatar.com/avatar/18434072beb69131948d13ec49b43bc3.jpg?s=60" class="gravatar"></a>
		<a class="web" href="">Alberto Ardizzone</a>
		<span class="title">-</span>
	</li>
	<li class="wp-person">
		<a href=""><img src="http://www.gravatar.com/avatar/f73d67c77f89c70ef303588aeab44ceb.jpg?s=60" class="gravatar"></a>
		<a class="web" href="">Ignazio Scimone</a>
		<span class="title">-</span>
	</li>
	<li class="wp-person">
		<a href="http://marcomilesi.ml"><img src="http://www.gravatar.com/avatar/c70b8e378aa035f77ab7a3ddee83b892.jpg?s=60" class="gravatar"></a>
		<a class="web" href="http://marcomilesi.ml">Marco Milesi</a>
		<span class="title">San Pellegrino Terme</span>
	</li>
	<li class="wp-person">
		<a href=""><img src="http://www.gravatar.com/avatar/a5294e8762346dbbfa62e6fee71b3614.jpg?s=60" class="gravatar"></a>
		<a class="web" href="">Renata Durighello</a>
		<span class="title">-</span>
	</li>
</ul>
<h4 class="wp-people-group">e ancora...</h4>
<ul class="wp-people-group ">
	<li class="wp-person">
		<a href=""><img src="http://www.gravatar.com/avatar/9474c75c8be90627711a1e69d48f1797.jpg?s=60" class="gravatar"></a>
		<a class="web" href="">Andrea Smith</a>
		<span class="title">-</span>
	</li>
	<li class="wp-person">
		<a href=""><img src="http://www.gravatar.com/avatar/bd973f68c52839b913061d9b9e414014.jpg?s=60" class="gravatar"></a>
		<a class="web" href="">Paolo Valenti</a>
		<span class="title">-</span>
	</li>
	<li class="wp-person">
		<a href=""><img src="http://www.gravatar.com/avatar/f5c122f213686878dd4b39f7d9ae34c6.jpg?s=60" class="gravatar"></a>
		<a class="web" href="">Riccardo Boccaccio</a>
		<span class="title">-</span>
	</li>
</ul>
<p class="wp-credits-list">
Anna Ladu, Antonello Facchetti, Candida Zappacosta, Caterina Toccafondi, Giorgio Galli, Lillo Sciasia, Paolo Mauri
</p>
	</div>
<?php }

?>