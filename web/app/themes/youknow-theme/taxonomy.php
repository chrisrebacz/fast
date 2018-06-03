<?php 
/**
 * Articles Assigned to a Taxonomy
 */

    
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

$args = [
    'post_type' => '*',
    'tax_query' => [
        [
            'taxonomy' => get_query_var('taxonomy'),
            'field' => 'id',
            'terms' => $term->term_id
        ]
    ],
];

$tax = new WP_Query($args);
get_header();
?>

<div class="container-fluid m-t-40 width-max-1200">
    <div class="dlh-article-container">
        <div class="col-md-9">
            <div class="dlh-content-title c-title-sm text-center">
                <h2 style="text-align:left;"><?php echo $term->name; ?> </h2>
                <div class="c-line c-dot c-dot-right"></div>
            </div>
            <?php 
            if ($tax->have_posts()) {

                while ($tax->have_posts()) : $tax->the_post(); ?>
                    <?php 
                        $posttype = get_youknow_posttype_label(get_the_ID());
                    ?>
                    <div class="dln-box float-e-margins dlh-article">
                        <div class="dln-box-content">
                            <p class="dlh-article-metadata"><span class="posttype"><?php echo $posttype; ?></span> | <span class="date"><?php echo get_the_modified_date(); ?></span></p>
                            <h2 class="dlh-article-title"><a href="<?php the_permalink(); ?>"><?php echo youknow_trim_title(get_the_title()); ?></a></h2>
                            <p class="dlh-article-excerpt"><?php echo get_the_excerpt(); ?></p>
                        </div>
                    </div>


                <?php endwhile; 

            } else {
             
                get_template_part('content/content', 'none'); 

            }
            ?>     
        </div> 
    </div>
</div>

<?php get_footer(); ?>
