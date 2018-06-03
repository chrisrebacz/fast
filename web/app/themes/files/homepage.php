<?php
/**
 * Template Name: Home Page
 */

$images_url = YK_THEME_ASSET_URL. '/images/';
$args = [
    'post_type' => 'post',
    'posts_per_page' => 5,
    'orderby' => 'modified',
    'order' => 'DESC'
];
$news = new WP_Query($args);

$department_field = get_field('users');

if (! $department_field) {
    $department = 'All';
} else {
    $department = $department_field[0];
}

function getNavOrder($dept) {

    $depts = [
        'iefs' => 'IEFS',
        'tfs'  => 'TFS',
        'nsg' => 'NSG',
        'ehs' => 'EH&S',
        'tcc' => 'TCC Dispatch',
        'tiots' => 'TIOTS',
        'youcoach' => 'YouCoach',
        'fleet' => 'Fleet'
    ];

    $firstItemLabel = $depts[$dept];

    $nav = [];
    $nav[$dept] = $firstItemLabel;

    foreach($depts as $name => $label) {
        if ($name !== $dept) {
            $nav[$name] = $label;
        }
    }
    return $nav;
}

$usernav = app('theme')->getUserHomeDefault();
$orderedNav = getNavOrder($usernav);

get_header();
?>

<div class="audience-filter-container">
    <ul class="audience-filter-list">
        <?php foreach($orderedNav as $name => $label) : ?>
            <li class="audience-filter-list-item"><a href="<?php echo home_url().'/'.$name.'-home'; ?>"><span><?php echo $label; ?></span></a></li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="container-fluid m-t-40 width-max-1200" id="dashboard">
    <div class="animated fadeIn">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <h2 style="text-align:center;"><?php the_title(); ?></h2>
        <?php endwhile; endif; ?>
        <div class="primary-search">
            <form action="<?php echo home_url('/'); ?>" method="get">
                <div class="input-group input-group-lg">
                    <div class="input-group-btn">
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $department; ?> <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">All YouKnow</a></li>
                            <li class="active"><a href="#"><?php echo $department; ?></a></li>
                            <li role="separator" class="divider"></li>
                            <?php if (have_rows('search_filters')): ?>
                                <?php  while (have_rows('search_filters')) : the_row() ; ?>
                                    <li><a href="#" data-search-filter="<?php the_sub_field('filter'); ?> " class="home_search_filter"><?php the_sub_field('filter_label'); ?></a>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <input type="search" name="s" class="form-control" aria-label="Search YouKnow Articles" placeholder="Search YouKnow Articles" id="search" value="<?php the_search_query(); ?>">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <?php if (have_rows('quick_links')): ?>
            <div class="dlh-content-title c-title-sm text-center">
                <h3>Quick Links</h3>
                <div class="c-line c-dot"></div>
            </div>
            <div class="row dln-quick-links">
                <?php  while (have_rows('quick_links')) : the_row() ; ?>
                    <div class="col-xs-6 col-md-4 col-lg-3">
                        <div class="list-group-item">
                            <a href="<?php the_sub_field('url'); ?>">
                                <i class="fa fa-bolt"></i>
                                <span><?php the_sub_field('label'); ?> </span>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="row animated fadeIn m-t-40">
        <div class="col-md-4 col-sm-6">
            <div class="dlh-article-list dlh-article-container">
                <div class="dlh-content-title c-title-sm text-center">
                    <h3 style="text-align:left;">Recent News &amp; Updates</h3>
                    <div class="c-line c-dot c-dot-right"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">

                        <?php if ($news->have_posts()) : while ($news->have_posts()) : $news->the_post(); ?>
                        <div class="dln-box float-e-margins dlh-article">
                            <div class="dln-box-content">
                                <p class="dlh-article-metadata"><span class="posttype">News</span> | <span class="date"><?php echo get_the_modified_date(); ?></span></p>
                                <h2 class="dlh-article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <p class="dlh-article-excerpt"><?php the_excerpt(); ?></p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button class="btn btn-primary btn-xs" type="button">Model</button>
                                        <button class="btn btn-primary btn-xs" type="button">Publishing</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                            endif;
                        ?>

                        <div class="dln-box float-e-margins dlh-article clearfix text-center">
                            <div class="btn btn-warning btn-sm"><a class="read-more-btn" href="<?php echo home_url().'/news'; ?>">View all recent news</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-6">
            <div class="dlh-article-list dlh-article-container">
                <div class="dlh-content-title c-title-sm">
                    <h3>Categories</h3>
                    <div class="c-line c-dot c-dot-right"></div>
                </div>
                    <?php
                    if (have_rows('categories')) :
                        $rows = get_field('categories');
                        foreach (array_chunk($rows, 2) as $chunk) :  ?>
                            <div class="row">
                                <?php foreach ($chunk as $row) : the_row(); ?>
                                    <div class="col-md-6">
                                        <div class="dlh-panel panel-collapse dlh-panel-with-image dlh-panel-no-mb">
                                            <div class="panel-heading dlh-built dlh-colored hblue clearfix">
                                                <div class="panel-heading-image">
                                                    <img class='dlh-panel-header-image' alt="category icon" src="<?php the_sub_field('category_image'); ?>"/>
                                                </div>
                                                <span class="panel-heading-title"><?php the_sub_field('category_name'); ?></span>
                                            </div>
                                            <div class="panel-body no-padding" style="display: none;">
                                                <?php if (have_rows('sub_categories')) : while (have_rows('sub_categories')) : the_row(); ?>
                                                    <?php
                                                        if (in_array('Category', get_sub_field('sub_category_type'))) {
                                                            $url = get_term_link(get_sub_field('sub_category_term')[0]->term_id);
                                                        } else if (in_array('Article', get_sub_field('sub_category_type'))) {
                                                            $url = get_sub_field('you_know_article');
                                                        } elseif (in_array('URL', get_sub_field('sub_category_type'))) {
                                                            $url = get_sub_field('sub_category_url');
                                                        } else  {
                                                            $url = false;
                                                        }
                                                    ?>

                                                    <?php if (! is_wp_error($url) && $url) : ?>
                                                        <div class="list-group-item">
                                                            <a href="<?php echo $url; ?>"><?php the_sub_field('sub_category_label'); ?></a>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endwhile; endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>



<?php get_footer(); ?>
