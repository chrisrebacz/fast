<?php

/**
 * Search Results Template
 */
get_header();
?>

<div class="container-fluid m-t-40 width-max-1200">
    <div class="dlh-article-container">
        <div class="col-md-9">
            <div class="dlh-content-title c-title-sm text-center">
                <h2 style="text-align:left;">Search Results: <?php the_search_query(); ?></h2>
                <div class="c-line c-dot c-dot-right"></div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
    <div class="dlh-article-container">
        <div class="col-md-9">
            <?php
            if (have_posts()) {
                while (have_posts()) : the_post();
                    get_template_part('views/content', 'listview');
                endwhile;
            } else {
                get_template_part('views/content', 'none');
            }
            ?>
        </div>
        <div class="col-md-3">
            <?php get_template_part('widgets/pagesearch'); ?>
        </div>
    </div>
</div>

<?php get_footer();
