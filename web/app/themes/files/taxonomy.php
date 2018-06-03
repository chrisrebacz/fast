<?php 
/**
 * Articles Assigned to a Taxonomy
 */

    
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

get_header();
?>

<div class="container-fluid m-t-40 width-max-1200">
    <div class="dlh-article-container">
        <div class="col-md-9">
            <div class="dlh-content-title c-title-sm text-center">
                <h2 style="text-align:left;">Articles Assigned To: <?php $term->name; ?> </h2>
                <div class="c-line c-dot c-dot-right"></div>
            </div>
            <?php 
            if (have_posts()) {

                while (have_posts()) : the_post(); 

                    get_template_part('content/content', 'listview');

                endwhile; 

            } else {
             
                get_template_part('content/content', 'none'); 

            }
            ?>     
        </div> 
    </div>
</div>

<?php get_footer(); ?>