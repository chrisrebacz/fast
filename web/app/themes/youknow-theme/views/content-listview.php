<?php
# This partial is used within the loop to return the list items for a list-view.
# 
$class = is_search() ? 'youknow-search-date' : 'youknow-date';
$posttype = get_youknow_posttype_label(get_the_ID());
$terms = wp_get_post_terms(get_the_ID(), 'post_tag');
?>
<div class="dln-box float-e-margins dlh-article">
    <div class="dln-box-content">
        <p class="dlh-article-metadata"><span class="posttype"><?php echo $posttype; ?></span> | <span class="date"><?php echo get_the_modified_date(); ?></span></p>
        <h2 class="dlh-article-title"><a href="<?php the_permalink(); ?>"><?php youknow_trim_title(get_the_title()); ?></a></h2>
        <p class="dlh-article-excerpt"><?php echo get_the_excerpt(); ?></p>
        <div class="row">
            <div class="col-md-6"> 
                <?php foreach ($terms as $term) : ?>
                    <a class="btn btn-primary btn-xs" href="<?php echo get_tag_link($term->term_id); ?>"><?php echo $term->name; ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>



