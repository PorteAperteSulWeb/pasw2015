<?php
    $categories = get_categories('hide_empty=0&child_of='.get_query_var('cat'));

    if (count($categories)) {
        echo '<select name="archive-dropdown" onChange="document.location.href=this.options[this.selectedIndex].value;">';
        echo '<option value="">Sottocategorie</option>';
        foreach ($categories as $category) {
            $option = '<option value="' . get_site_url() . '/category/'.$category->category_nicename.'">';
            $option .= $category->cat_name;
            $option .= ' ('.$category->category_count.')';
            $option .= '</option>';
            echo $option;
        }
        echo '</select>';
    }
?>

            <select name="archive-dropdown" onChange='document.location.href=this.options[this.selectedIndex].value;'>
                <option value="">Filtra per data</option>
                <?php wp_get_archives('type=monthly&format=option&show_post_count=1'); ?>
            </select>
