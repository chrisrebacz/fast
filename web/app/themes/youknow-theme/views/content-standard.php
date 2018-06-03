<?php
    $posttype = get_youknow_posttype_config(get_the_ID());
?>
<div class="page-title">
    <h1><?php youknow_trim_title(get_the_title()); ?></h1>
    <p class="dock-article-subtitle"><?php get_youknow_published_date(); ?>  <span class="dock-subtitle-separator">&nbsp;&nbsp; | &nbsp;&nbsp;</span><span class="dock-type"><?php echo $posttype['label'];  ?></span></p>
</div>

<div class="card no-padding single-article">
    <div class="card-body single-article-content">
        <?php the_content(); ?>
    </div>
</div>
