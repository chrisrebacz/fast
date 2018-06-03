<div>
    <?php
    $fileInfo = get_field('document');
    $fileType = substr(strrchr($fileInfo['url'], '.'), 1);
    if ($fileType == 'docx') {
        $filetype = 'doc';
    } elseif ($fileType == 'xlsx') {
        $filetype = 'xls';
    }
    ?>
    <div style="display:flex; align-items: center; ">
        <img style="width: 50px; height: 50px;" class="actual-size;" src="<?php echo get_template_directory_uri().'/assets/files/'. $fileType .'.png'; ?>" alt="<?php echo strtoupper($fileType); ?> Icon">
        <h4 style="margin: 0;padding-left: 10px;"><?php the_field('document_title'); ?></h4>
    </div>
    <h6><?php echo $fileInfo['filename'];?></h6>
    <?php the_excerpt(); ?>
    <a href="<?php echo $fileInfo['url'];?>" class="btn btn-lg btn-primary">Download</a>
</div>
