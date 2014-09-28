
<!-- High Calculus -->

	<?php $sidebars_widgets = wp_get_sidebars_widgets();

		$i1=0; $i2=0;
		if ( is_active_sidebar('sidebar-3') ) { $i1++; }
		if ( is_active_sidebar('sidebar-4') ) { $i1++; }
		if ( is_active_sidebar('sidebar-5') ) { $i1++; }

		switch ($i1) {
	    case 0:
	        $width_sottohome = '0%';
	        break;
	    case 1:
	        $width_sottohome = '96%';
	        break;
	    case 2:
	        $width_sottohome = '48%';
	        break;
	    case 3:
	        $width_sottohome = '31%';
	        break;
		}

		if ( is_active_sidebar('sidebar-6') ) { $i2++; }
		if ( is_active_sidebar('sidebar-7') ) { $i2++; }
		if ( is_active_sidebar('sidebar-8') ) { $i2++; }

		switch ($i2) {
	    case 0:
	        $width_home = '0%';
	        break;
	    case 1:
	        $width_home = '96%';
	        break;
	    case 2:
	        $width_home = '46%';
	        break;
	    case 3:
	        $width_home = '30%';
	        break;
		}


	?>

<div class="stickyc">
		<?php if (is_active_sidebar('sidebar-6')) { ?>
			<div class="stickyc-col" style="width: <?php echo $width_home; if ($i2 > 1) { echo '; border-right: 1px dotted #25385D'; } ?>;">
				<ul>
					<?php dynamic_sidebar("sidebar-6"); ?>
				</ul>
			</div>
		<?php } ?>
		<?php if (is_active_sidebar('sidebar-7')) { ?>
			<div class="stickyc-col" style="width: <?php echo $width_home; if ($i2 == 3) { echo '; border-right: 1px dotted #25385D'; } ?>;">
				<ul>
					<?php dynamic_sidebar("sidebar-7"); ?>
				</ul>
			</div>
		<?php } ?>
		<?php if (is_active_sidebar('sidebar-8')) { ?>
			<div class="stickyc-col" style="width: <?php echo $width_home;?>;">
				<ul>
					<?php dynamic_sidebar("sidebar-8"); ?>
				</ul>
			</div>
		<?php } ?>
		<div class="clear"></div>
	</div>




<!-- Widget "sottohome$"-->
<div id="sotto-hp">

		<?php if (is_active_sidebar('sidebar-3')) { ?>
			<div class="col-com2" style="width: <?php echo $width_sottohome;?>;">
				<ul>
					<?php dynamic_sidebar("sidebar-3"); ?>
				</ul>
			</div>
		<?php } ?>

		<?php if (is_active_sidebar('sidebar-4')) { ?>
			<div class="col-com2" style="width: <?php echo $width_sottohome;?>;">
				<ul>
					<?php dynamic_sidebar("sidebar-4"); ?>
				</ul>
			</div>
		<?php } ?>

		<?php if (is_active_sidebar('sidebar-5')) { ?>
			<div class="col-com2" style="width: <?php echo $width_sottohome;?>;">
				<ul>
					<?php dynamic_sidebar("sidebar-5"); ?>
				</ul>
			</div>
		<?php } ?>

</div>