<?php
/**
 * Single Article template
 */
get_header();
?>
<div class="container-fluid m-t-40 width-max-1200">
    <div class="dlh-article-container">
        <?php if (have_posts()) :
            while (have_posts()) :
                the_post();
                $format = youknow_get_format_for_type($post);
            ?>
            <div class="row">
                <div class="col-lg-9">
                    <div class="ibox float-e-margins dlh-article">
                        <div class="ibox-content">
                            <p class="dlh-article-metadata"><span class="posttype"><?php echo $format; ?></span> | <span class="date"><?php echo get_the_modified_date(); ?></span></p>
                            <h1 class="dlh-article-title" id="<?php echo str_slug(get_the_title()); ?>"><?php echo youknow_trim_title(get_the_title()); ?> <a class="fragment-identifier js-fragment-identifier fragment-identifier-scroll" href="#<?php echo str_slug(get_the_title()); ?>"><i class="fa fa-link"></i></a> </h1>
                            <div class="hr-line-dashed"></div>
                            <div class="four-w-row">
                                <?php 
                                    $who = get_field('att_who'); 
                                    if (! empty($who)) :
                                ?>
                                    <div class="four-w-container"><div class="four-w-tag"><span class="four-w-tag-inner">Who</span></div> <span class="four-w-value"><?php echo $who; ?></span></div>
                                <?php endif; ?>
                                <?php 
                                    $when = get_field('att_when'); 
                                    if (! empty($when)) :
                                ?>
                                    <div class="four-w-container"><div class="four-w-tag"><span class="four-w-tag-inner">When</span></div> <span class="four-w-value"><?php echo $when;?></span></div>
                                <?php endif; ?>
                                <?php 
                                    $where = get_field('att_where'); 
                                    if ($where) :
                                ?>
                                    <div class="four-w-container"><div class="four-w-tag"><span class="four-w-tag-inner">Where</span></div> <span class="four-w-value"><?php echo $where;?></span></div>
                                <?php endif; ?>
                            </div>
                            <?php 
                                $why = get_field('att_why');
                                if (! empty($why)) :
                            ?>
                                <div class="four-w-row" style="margin-top: 0;">
                                    <div class="four-w-container" style="flex: 3;"><div class="four-w-tag"><span class="four-w-tag-inner">Why</span></div> <span class="four-w-value"><?php echo $why; ?></span></div>
                                </div>
                            <?php endif; ?>
                            <div class="hr-line-dashed"></div>
                            <div class="dlh-article-content">
                                <?php
                                if (get_post_format(get_the_ID()) === 'link') {
                                    get_template_part('content/content', 'document');
                                } elseif (get_field('is_m&p')) {
                                    the_content();
                                    $posts = get_field('sections');
                                    $output = get_field('output');
                                    foreach ($posts as $post) {
                                        setup_postdata($post);
                                        echo '<h4><a href="'.get_the_permalink().'" target="_blank">'. youknow_trim_title(get_the_title()). '</a></h4>';
                                        $content = '<div class="mp_section">';
                                        if ($output == 'content' || $output == 'All Content') {
                                            $content .= get_the_content();
                                        } elseif ($output == 'excerpt' || $output == 'Excerpts with Links') {
                                            $content .= get_the_excerpt();
                                        } else {
                                            $content .= $output;
                                        }
                                        echo $content;
                                        echo '</div>';
                                        wp_reset_postdata();
                                    }
                                } else {
                                    the_content();
                                    $article = get_field('article');
                                    if ($article) {
                                        setup_postdata($article);
                                        the_content();
                                        wp_reset_postdata();
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="ibox float-e-margins dlh-sidebar">
                       <div class="ibox-title">
                            <h5>Version History</h5>
                        </div>
                        <div class="ibox-content no-padding">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>By</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (have_rows('revision_history')) : while (have_rows('revision_history')) : the_row(); ?>
                                            <tr>
                                                <td><?php the_sub_field('issue_num'); ?></td>
                                                <td><?php the_sub_field('revision_date'); ?></td>
                                                <td><?php the_sub_field('revision_published_by'); ?></td>
                                                <td><?php the_sub_field('revision_description'); ?></td>
                                            </tr>
                                        <?php endwhile; endif; ?>
                                    </tbody>
                                </table>    
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
                                <?php 
                                    $terms = youknow_related_topics(get_the_ID());
                                    if ($terms && is_array($terms)) :
                                        foreach ($terms as $term) :
                                            echo '<li class="list-group-item dlh-article-category"><a href="'.get_term_link($term).'">'.$term->name.'</a></li>';
                                        endforeach; 
                                    else :
                                        echo '<li class="list-group-item dlh-article-category">None assigned </li>';
                                    endif;
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="ibox float-e-margins dlh-sidebar">
                        <div class="ibox-title">
                            <h5>Links & Resources</h5>
                        </div>
                        <div class="ibox-content no-padding">
                            <ul class="dlh-article-categories list-group">
                                <?php 
                                    $content = youknow_related_content(get_the_ID());
                                    $hasContent = false;
                                    if (! empty($content['articles'])) :
                                        $hasContent = true;
                                        
                                        foreach ($content['articles'] as $article) :
                                        ?>
                                            <li class="list-group-item dlh-article-category"><a href="<?php echo get_permalink($article->ID); ?>"><?php echo youknow_trim_title($article->post_title); ?></a></li> 
                                        <?php
                                        endforeach;
                                    endif;
                                    if (! empty($content['downloads'])) :
                                        $hasContent = true;
                                        
                                        foreach ($content['downloads'] as $download) :
                                            $file = $download['sda_file_download'];
                                        ?>
                                            <li class="list-group-item dlh-article-category"><a href="<?php echo $file['url']; ?>"><?php echo youknow_trim_title($file['title']); ?></a></li>
                                        <?php
                                        endforeach;
                                    endif;
                                    if (! empty($content['external'])) :
                                        $hasContent = true;
                                        
                                        foreach ($content['external'] as $external) :
                                        ?>
                                            <li class="list-group-item dlh-article-category"><a href="<?php echo $external['sda_external_url']; ?>"><?php echo $external['sda_external_url_label']; ?></a></li> 
                                        <?php
                                        endforeach;
                                    endif;
                                    if (! $hasContent) {
                                        echo '<li class="list-group-item dlh-article-category">None assigned </li>';
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <?php $tags = wp_get_post_tags(get_the_ID()); ?>
                    <?php if ($tags && is_array($tags)) : ?>
                        <div class="youknow_single_tag_container" style="margin-bottom:20px">
                            <?php foreach ($tags as $tag) : ?>                            
                                <a href="<?php echo get_term_link($tag); ?>" class="btn btn-primary btn-xs"><?php echo $tag->name; ?></a>
                            <?php endforeach ?>
                        </div>    
                    <?php endif; ?>
                    <div class="ibox float-e-margins dlh-sidebar">
                        <div class="ibox-title">
                            <h5>Points of Contact</h5>
                        </div>
                        <div class="ibox-content no-padding">
                            <ul class="dlh-article-categories list-group">
                                <?php 
                                    $users = get_field('point_of_contact', get_the_ID());
                                    if ($users && is_array($users)) {
                                        $profiles = $users[0]['user_profile'];
                                        foreach ($profiles as $user) {
                                            $name = $user['display_name'];
                                            $email  = $user['user_email'];
                                            $title = get_field('title', 'user_'.$user['ID']);
                                            $phone = get_field('phone_number', 'user_'.$user['ID']);
                                            ?>
                                            <li class="list-group-item">
                                                <div class="dlh-article-poc-container">
                                                    <h5 class="dlh-user-name" style="margin:0; padding: 0;"><?php echo $name; ?></h5>
                                                    <p class="dlh-user-title" style='margin:0; padding: 0; font-size: 1.3rem; font-weight: 600;'><?php echo $title; ?></p>
                                                    <p class="dlh-user-email" style='margin:0; padding: 0; font-size: 1.3rem; font-weight: 600;'><a href="mailto:<?php echo $email; ?>"><i class="fa fa-envelope"></i> <span><?php echo $email; ?></span></a></p>
                                                    <?php if(! empty($phone)) : ?>
                                                        <p class="dlh-user-phone" style="margin:0; padding: 0; font-size: 1.3rem; font-weight: 600;"><a href="tel:<?php echo $phone; ?>"><i class="fa fa-phone"></i> <span><?php echo $phone; ?></span></a></p> 
                                                    <?php endif; ?>

                                                </div>
                                            </li>

                                            <?php 
                                        }
                                    }
                                ?>
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
