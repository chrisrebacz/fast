<div class="single-bookmark-container">
    <?php echo lighthouse_bookmark_controls($add_text = 'Bookmark This!', $delete_text = 'Remove Bookmark', $wrapper = true) ?>
</div>

<?php if( is_single() ) {
    get_template_part('widgets/categoryterms');
}
get_template_part('widgets/pagesearch'); 