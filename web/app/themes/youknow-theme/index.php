<?php 
/**
 * The default template file.  If no other templates match, this
 * will be displayed.
 */
get_header();?>
<div class="container-fluid m-t-40 width-max-1200">
    <div class="dlh-article-container">
         <div class="row">
            <div class="col-lg-9">
                <?php if(have_posts()): while(have_posts()): the_post(); ?>
                    <div class="ibox float-e-margins dlh-article">
                        <div class="ibox-content">
                            <p class="dlh-article-metadata"><span class="date"><?php echo get_the_modified_date(); ?></span></p>
                            <h1 class="dlh-article-title" id="<?php echo str_slug(get_the_title()); ?>"><?php echo get_the_title(); ?></h1>
                            <div class="hr-line-dashed"></div>
                            <div class="dlh-article-content">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; endif; ?>
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
    </div>
</div>
<?php get_footer(); ?>
