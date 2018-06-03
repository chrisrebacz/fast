<?php


$images_url = YK_THEME_ASSET_URL. '/images/';
$userrole = get_query_var('userrole', 'att_employee');

$args = [
    'post_type' => 'post',
    'posts_per_page' => 5,
    'orderby' => 'modified',
    'order' => 'DESC',
];
if (youknow_is_regional_role($userrole)) {
    $accessIds = app('options')->get('roles.accessIds', []);
    $allowed = isset($accessIds[$userrole]) ? $accessIds[$userrole] : [];
    if (! empty($allowed) && is_array($allowed)) {
        $args['post_type'] = ['post', 'tiots'];
        $args['category__in'] = $allowed;
    }
}
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

    foreach ($depts as $name => $label) {
        if ($name !== $dept) {
            $nav[$name] = $label;
        }
    }
    return $nav;
}

$usernav = app('theme')->getUserHomeDefault();
$orderedNav = getNavOrder($usernav);


$attuid = get_query_var('attuid', false);
$userrole = get_query_var('userrole', false);
$titleWrapper = '<img id="headerLogo" class="actual-size" src="'.YK_THEME_ASSET_URL.'/images/YouKnow_rgb_pos_crop.png" alt="Header YouKnow Logo" style="width: 300px;">';

get_header();
?>
<style>
    .primarySearchMenu input[type="radio"] {
        display: none;
    }
    input[type="radio"] ~ label {
        width: 100%;
        padding: 0.5rem 1rem;
    }
    input[type="radio"]:checked ~ label {
        background-color: #009fdb;
        color: #fff;
    }
    .audience-filter-list-item.active {
        background-color: rgb(5, 104,174);
    }
    .audience-filter-list-item.active a {
        color: #fff;
    }

</style>
<div class="audience-filter-container">
    <ul class="audience-filter-list">
        <?php foreach($orderedNav as $name => $label) : ?>
            <?php 
                $active = $department == $label ? ' active' : ''; 
            ?>
            <li class="audience-filter-list-item<?php echo $active; ?>">
                <a href="<?php echo get_permalink(get_page_by_path($name.'-home')->ID); ?>"><span><?php echo $label; ?></span></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="container-fluid m-t-40 width-max-1200" id="dashboard">
    <div class="animated fadeIn">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <h2 style="text-align:center; margin-top: 0;"><?php echo $titleWrapper; ?></h2>
        <?php endwhile; endif; ?>
        <div class="primary-search">
            <form action="<?php echo home_url('/'); ?>" method="get" class="primary-search-form">
                <div class="input-group input-group-lg">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="primarySearchToggle"><span id="activeSearchLabel"><?php echo $department; ?></span> <span class="caret"></span></button>
                        <ul class="dropdown-menu primarySearchMenu">
                            <li><div class="primarySearchMenuFilter">
                                <input type="radio" class="radio youknow_search_filter" name="youknow_search_filter" id="yksf_all" value="all"><label for="yksf_all"> All YouKnow</label></div></li>
                            <li class="active"><div class="primarySearchMenuFilter"><input type="radio" name="youknow_search_filter" class="radio youknow_search_filter" id="yksf_<?php echo $department; ?>" value="<?php echo $department; ?>" checked="checked"><label for="yksf_<?php echo $department; ?>"><?php echo $department; ?></label></div></li>
                            <?php if (have_rows('search_filters')): ?>
                                <li role="separator" class="divider"></li>
                                <?php  while (have_rows('search_filters')) : the_row() ; ?>
                                    <li><div class="primarySearchMenuFilter"><input type="radio" class="radio youknow_search_filter" id="yksf_<?php the_sub_field('filter'); ?>" name="youknow_search_filter" value="<?php the_sub_field('filter'); ?> " class="home_search_filter"><label for="yksf_<?php the_sub_field('filter'); ?>"><?php the_sub_field('filter_label'); ?></label></div></li>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <input type="search" name="s" class="form-control" aria-label="Search YouKnow Articles" placeholder="Search YouKnow Articles" id="search" value="<?php the_search_query(); ?>">
                    <div class="input-group-btn">
                        <button type="submit" class="primary-search-btn btn btn-primary"><i class="fa fa-search"></i></button>
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
                    <h3 style="text-align:left;">Recent Communications</h3>
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
                                        <!-- <button class="btn btn-primary btn-xs" type="button">Model</button>
                                        <button class="btn btn-primary btn-xs" type="button">Publishing</button> -->
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
        <div class="col-md-4 col-sm-6">
            <div class="dlh-article-list dlh-article-container">
                <div class="dlh-content-title c-title-sm text-center">
                    <h3 style="text-align:left;">Recent M&Ps and Process</h3>
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
                                        <!-- <button class="btn btn-primary btn-xs" type="button">Model</button>
                                        <button class="btn btn-primary btn-xs" type="button">Publishing</button> -->
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
        <div class="col-md-4 col-sm-6">
            <div class="dlh-article-list dlh-article-container">
                <div class="dlh-content-title c-title-sm text-center">
                    <h3 style="text-align:left;">Recent M&Ps and Process</h3>
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
                                        <!-- <button class="btn btn-primary btn-xs" type="button">Model</button>
                                        <button class="btn btn-primary btn-xs" type="button">Publishing</button> -->
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
    </div>
    <div class="row animated fadeIn m-t-40">
        <div class="col-md-12">
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
