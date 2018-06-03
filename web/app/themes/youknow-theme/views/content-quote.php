<?php 
/**
 * The quote format is called Process Cards in the admin panel. It provides a flexible
 * format for listing out process steps in a card w/image or modal.  
 */
$posttype = get_youknow_posttype_config(get_the_ID());
?>
<div class="row">
    <div class="col-md-12 page-title">
        <h1><?php the_field('title_bar'); ?></h1>
        <p class="dock-article-subtitle"><?php get_youknow_published_date(); ?>  <span class="dock-subtitle-separator">&nbsp;&nbsp; | &nbsp;&nbsp;</span><span class="dock-type"><?php echo $posttype['label'];  ?></span></p>
        <p><?php the_field('title_summary'); ?></p>
    </div>         
</div>

<?php
if( have_rows('content_type') ): while ( have_rows('content_type') ) : the_row(); ?>
    
    <?php if( get_row_layout() == 'process_with_graphic' ):?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?php 
                    if( have_rows('process_steps') ): while ( have_rows('process_steps') ) : the_row(); ?>
                        <div class="col-sm-4">       
                            <img src="<?php the_sub_field('image'); ?>" alt="">
                            <div style="min-height: 66px; padding-top: 10px;"><?php the_sub_field('image_caption'); ?></div>   
                            <h2><?php the_sub_field('item_title'); ?></h2>
                            <div style="min-height: 110px;"><?php the_sub_field('item_subject'); ?></div>
                            <hr style=" border: 0; height: 1px; background: #067ab4; background-image: linear-gradient(to right, #A3CDE1, #067ab4, #A3CDE1);">        
                        </div>
                    <?php endwhile; endif; ?>    
                </div>
            </div>
        </div>
    </div>
    
    <?php elseif(get_row_layout() === 'additional_resources_head'): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-head style-primary">
                    <header>Additional Resources</header>
                </div>
                <div class="card-body no-padding">
                    <?php $article_links = get_sub_field('article_links'); ?>    
                    
                    <?php if ($article_links): ?>
                        <ul class="list divider-full-bleed tco-list-view">
                        <?php foreach ($article_links as $link) : ?>
                            <?php  $linktype = get_youknow_posttype_config($link->ID);  ?>  
                            <li class="tile" style="position: relative;">
                                <div class="tile-icon">
                                    <a type="button" class="<?php echo 'btn btn-circle-floating ' . $linktype['class'];?>" href="<?php echo get_permalink($link->ID); ?>">
                                        <i class="fa <?php echo $linktype['icon']; ?>"></i>
                                    </a>
                                </div>
                                <div class="tile-text">
                                    <a class="tile-content" href="<?php echo get_permalink($link->ID); ?>">
                                        <h4><?php echo youknow_trim_title(get_the_title($link->ID)); ?> <small><span class="dock-date"><?php echo get_the_modified_date(); ?></span> • <span class="dock-post-type"><?php echo $linktype['label']; ?></span></small></h4>
                                    </a>
                                    <small><?php echo $link->post_excerpt; ?></small>
                                </div>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    <?php endif?>
                </div>
            </div>
        </div>
    </div>
                
    <?php elseif(get_row_layout() === 'modal_head'): ?>
    
    <div class="modals">
        <div class="dock-modal remodal-bg"> 
            <div class="remodal" data-remodal-id="modalcontent">
                
                <?php if( have_rows('modal-steps')) : while ( have_rows('modal-steps') ) : the_row(); ?>
                    <h3 class="modal-header"><?php the_sub_field('modal_title'); ?></h3>  
                    <div class="dock-modal-content">
                        <div class="fppanel panel-default">
                            <p><?php the_sub_field('modal_content'); ?></p>
                        </div>
                    </div>              
                <?php endwhile; else : ?>
                    <li class="list-group-item">Content is currently not available.</li>
                <?php endif; ?>
                    <a href="#" class="remodal-confirm">Close</a>
            </div>
        </div>
    </div>
<?php endwhile; endif; ?>
