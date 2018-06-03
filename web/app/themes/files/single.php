<?php
/**
 * Single Article template
 */
get_header();
?>
<div class="container-fluid m-t-40 width-max-1200">
    <div class="dlh-article-container">
        <?php if(have_posts()): while(have_posts()): the_post(); ?>
            <?php
                $format = youknow_get_format_for_type($post);
            ?>

            <div class="row">
                <div class="col-lg-9">
                    <div class="ibox float-e-margins dlh-article">
                        <div class="ibox-content">
                            <p class="dlh-article-metadata"><span class="posttype"><?php echo $format; ?></span> | <span class="date"><?php echo get_the_modified_date(); ?></span></p>
                            <h1 class="dlh-article-title" id="<?php echo str_slug(get_the_title()); ?>"><?php echo get_the_title(); ?> <a class="fragment-identifier js-fragment-identifier fragment-identifier-scroll" href="#<?php echo str_slug(get_the_title()); ?>"><i class="fa fa-link"></i></a> </h1>
                            <div class="hr-line-dashed"></div>
                            <div class="dlh-article-content">
                                <?php
                                if (get_post_format(get_the_ID()) === 'link') {
                                    get_template_part('content/content', 'document');
                                } else {
                                    the_content();
                                    $article = get_field('article');
                                    if ($article) {
                                        setup_postdata( $article );
                                        the_content();
                                        wp_reset_postdata();
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div style="margin-bottom:20px">
                        <?php echo lighthouse_bookmark_controls(); ?>
                    </div>
                    <div class="ibox float-e-margins dlh-sidebar">
                        <div class="ibox-title">
                            <h5>Related Topics</h5>
                        </div>
                        <div class="ibox-content no-padding">
                            <ul class="dlh-article-categories list-group">
                                <?php if (function_exists('dln_article_categories')) : ?>
                                    <?php foreach ($terms as $term) : ?>
                                        <li class="list-group-item dlh-article-category"><a href="">{!!  !!}</a></li>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <li class="list-group-item dlh-article-category">None assigned</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; else : ?>
            <?php  get_template_part('views/content', 'none'); ?>
        <?php endif; ?>
    </div>
</div><!-- .container-fluid -->

<?php get_footer(); ?>
