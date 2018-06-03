<?php 
    global $post; 
    $taxonomies = get_youknow_taxonomies(get_post_type($post));
    $post_terms = wp_get_object_terms($post->ID, array_keys($taxonomies));
    $separator = ', ';
?>
<div class="categories-container card">
    <div class="card-head card-head-xs style-warning">
        <header>Categories</header>
    </div>
    <div class="card-body no-padding">
        <ul class="list-group">
        <?php
        if (! empty($post_terms) && ! is_wp_error($post_terms)) {
            foreach( $post_terms as $term ) {
                echo '<li class="list-group-item list-tags-items"><a href="'. get_term_link( $term->slug, $term->taxonomy ) .'">'. $term->name . '</a></li>';
            }
        }
        ?>
        </ul>
    </div>
</div>