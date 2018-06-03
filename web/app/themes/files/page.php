<?php
/**
 * Page template
 */
get_header();
?>
<div class="container-fluid m-t-40 width-max-1200">
    <div class="dlh-article-container">
        <?php if(have_posts()): while(have_posts()): the_post(); ?>
            <div class="row">
                <div class="col-lg-9">
                    <div class="ibox float-e-margins dlh-article">
                        <div class="ibox-content">
                            <h1 class="dlh-article-title" id="<?php echo str_slug(get_the_title()); ?>"><?php echo get_the_title(); ?> <a class="fragment-identifier js-fragment-identifier fragment-identifier-scroll" href="#<?php echo str_slug(get_the_title()); ?>"><i class="fa fa-link"></i></a> </h1>
                            <div class="hr-line-dashed"></div>
                            <div class="dlh-article-content">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div style="margin-bottom:20px">
                        <?php echo lighthouse_bookmark_controls(); ?>
                    </div>
                </div>
            </div>
        <?php endwhile; else : ?>
            <?php  get_template_part('views/content', 'none'); ?>
        <?php endif; ?>
    </div>
</div><!-- .container-fluid -->

<?php get_footer(); ?>
