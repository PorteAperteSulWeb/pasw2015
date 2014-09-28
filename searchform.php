<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
<div>
    <input type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="cerca" />
</div>
</form>
