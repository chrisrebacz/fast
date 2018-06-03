<?php
/**
 * Template for any 404 or missing content page.
 */
get_header();?>
<div class="container-fluid m-t-40 width-max-1200">
    <div class="dlh-article-container">
        <div class="card no-padding single-article">
            <div class="card-body single-article-content">
                <h2>404: We're Sorry...</h2>
                <p>We could not find the page you were looking for. Please click the home button to start again.</p>
                <a href="<?php echo home_url(); ?>" class="btn btn-primary">Home</a>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
