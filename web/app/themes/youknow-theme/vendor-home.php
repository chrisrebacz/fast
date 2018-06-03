<?php
/**
 * Template Name: Vendor Home Page
 */

$images_url = YK_THEME_ASSET_URL. '/images/';
$userrole = get_query_var('userrole', 'vendor');

$department_field = get_field('users');

if (! $department_field) {
    $department = 'All';
} else {
    $department = $department_field[0];
}

function youknow_departments($key = null, $flip = false) {
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

    if ($flip) {
        $depts = array_flip($depts);
    }

    if (is_null($key) || !isset($depts[$key])) {
        return $depts;
    }

    return $depts[$key];
}



function getNavOrder($dept) {

    if ($dept == 'vendor') {
        return [
            'vendor' => 'HSPs & AFCs'
        ];
    }

    $depts = youknow_departments();

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



$args = [
    'post_type' => ['vendor'],
    'posts_per_page' => 5,
    'orderby' => 'modified',
    'post_status' => 'publish',
    'order' => 'DESC',
    'tax_query' => [
        [
            'taxonomy' => 'vendor_type',
            'field'    => 'slug',
            'terms'    => 'communication',
        ]
    ]
];
$vendornews = new WP_Query($args);

$jobaidsargs = [
    'post_type' => ['vendor'],
    'posts_per_page' => 5,
    'orderby' => 'modified',
    'post_status' => 'publish',
    'order' => 'DESC',
    'tax_query' => [
        [
            'taxonomy' => 'vendor_type',
            'field'    => 'slug',
            'terms'    => 'job-aid',
        ]
    ]
];
$jobaids = new WP_Query($jobaidsargs);

$iefsargs = [
    'post_type' => ['iefs'],
    'posts_per_page' => 5, 
    'orderby' => 'modified',
    'post_status' => 'publish',
    'order' => 'DESC',
    'cat' => [1, 66]
];
$iefs = new WP_Query($iefsargs);


$attuid = get_query_var('attuid', false);
$userrole = get_query_var('userrole', false);
$titleWrapper = '<img id="headerLogo" class="actual-size" src="'.YK_THEME_ASSET_URL.'/images/YouKnow_rgb_pos_crop.png" alt="Header YouKnow Logo" style="width: 300px;">';

get_header('vendor');
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
        <li class="audience-filter-list-item">
            <a href="<?php echo get_permalink(get_page_by_path('vendor-home')->ID); ?>"><span>YouKnow for HSPs & AFCs</span></a>
        </li>
        <?php if ($userrole !== 'contractor_tech' || $userrole !== 'vendor') : ?>
            
        <?php endif; ?>
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
                        <?php if ($vendornews->have_posts()) : while ($vendornews->have_posts()) : $vendornews->the_post(); ?>
                        <div class="dln-box float-e-margins dlh-article">
                            <div class="dln-box-content">
                                <p class="dlh-article-metadata"><span class="posttype">Communication</span> | <span class="date"><?php echo get_the_modified_date(); ?></span></p>
                                <h2 class="dlh-article-title"><a href="<?php the_permalink(); ?>"><?php youknow_trim_title(get_the_title()); ?></a></h2>
                                <p class="dlh-article-excerpt"><?php the_excerpt(); ?></p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php 
                                            $tags = wp_get_post_tags(get_the_id()); 
                                            foreach ($tags as $tag):
                                        ?>
                                        <a href="<?php echo get_tag_link($tag->term_id); ?>" class="btn btn-primary btn-xs"><?php echo $tag->name; ?></a>
                                        <?php endforeach; ?>
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
                            <div class="btn btn-warning btn-sm"><a class="read-more-btn" href="<?php echo home_url().'/news'; ?>">View All Communications</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="dlh-article-list dlh-article-container">
                <div class="dlh-content-title c-title-sm text-center">
                    <h3 style="text-align:left;">Recent Job Aids</h3>
                    <div class="c-line c-dot c-dot-right"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?php if ($jobaids->have_posts()) : while ($jobaids->have_posts()) : $jobaids->the_post(); ?>
                        <div class="dln-box float-e-margins dlh-article">
                            <div class="dln-box-content">
                                <p class="dlh-article-metadata"><span class="posttype">Job Aid</span> | <span class="date"><?php echo get_the_modified_date(); ?></span></p>
                                <h2 class="dlh-article-title"><a href="<?php the_permalink(); ?>"><?php youknow_trim_title(get_the_title()); ?></a></h2>
                                <p class="dlh-article-excerpt"><?php the_excerpt(); ?></p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php 
                                            $tags = wp_get_post_tags(get_the_ID()); 
                                            foreach ($tags as $tag):
                                        ?>
                                        <a href="<?php echo get_tag_link($tag->term_id); ?>" class="btn btn-primary btn-xs"><?php echo $tag->name; ?></a>
                                        <?php endforeach; ?>
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
                            <div class="btn btn-warning btn-sm"><a class="read-more-btn" href="<?php echo home_url().'/iefs'; ?>">View All Job Aids</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="dlh-article-list dlh-article-container">
                <div class="dlh-content-title c-title-sm text-center">
                    <h3 style="text-align:left;">IEFS</h3>
                    <div class="c-line c-dot c-dot-right"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?php if ($iefs->have_posts()) : while ($iefs->have_posts()) : $iefs->the_post(); ?>
                        <div class="dln-box float-e-margins dlh-article">
                            <div class="dln-box-content">
                                <p class="dlh-article-metadata"><span class="posttype">IEFS</span> | <span class="date"><?php echo get_the_modified_date(); ?></span></p>
                                <h2 class="dlh-article-title"><a href="<?php the_permalink(); ?>"><?php youknow_trim_title(get_the_title()); ?></a></h2>
                                <p class="dlh-article-excerpt"><?php the_excerpt(); ?></p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php 
                                            $tags = wp_get_post_tags(get_the_ID()); 
                                            foreach ($tags as $tag):
                                        ?>
                                        <a href="<?php echo get_tag_link($tag->term_id); ?>" class="btn btn-primary btn-xs"><?php echo $tag->name; ?></a>
                                        <?php endforeach; ?>
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
                            <div class="btn btn-warning btn-sm"><a class="read-more-btn" href="<?php echo home_url().'/iefs'; ?>">View More IEFS</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row animated fadeIn m-t-40">
        <div class="dlh-article-list dlh-article-container">
                <div class="dlh-content-title c-title-sm text-center">
                    <h3 style="text-align:left;">Categories</h3>
                    <div class="c-line c-dot c-dot-right"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?php if (have_rows('categories')) :
                            $chunks = get_field('categories'); ?>
                            <?php foreach (array_chunk($chunks, 3) as $rows) : ?>
                            <div class="row">
                                <?php foreach ($rows as $row) :
                                    the_row(); ?>
                                    <div class="col-md-4">
                                        <div class="dlh-panel panel-collapse dlh-panel-with-image dlh-panel-no-mb">
                                            <div class="panel-heading dlh-built dlh-colored hblue clearfix">
                                                <div class="panel-heading-image">
                                                    <img class='dlh-panel-header-image' style="width: 100%;" alt="category icon" src="<?php the_sub_field('category_image'); ?>"/>
                                                </div>
                                                <span class="panel-heading-title"><?php the_sub_field('category_name'); ?></span>
                                            </div>
                                            <div class="panel-body no-padding" style="display: none;">
                                                <?php if (have_rows('sub_categories')) :
                                                    while (have_rows('sub_categories')) :
                                                        the_row(); ?>
                                                        <?php
                                                        if (in_array('Category', get_sub_field('sub_category_type'))) {
                                                            $url = get_term_link(get_sub_field('sub_category_term')[0]->term_id);
                                                        } elseif (in_array('Article', get_sub_field('sub_category_type'))) {
                                                            $url = get_sub_field('you_know_article');
                                                        } elseif (in_array('URL', get_sub_field('sub_category_type'))) {
                                                            $url = get_sub_field('sub_category_url');
                                                        } else {
                                                            $url = false;
                                                        }
                                                        
                                                        if (! is_wp_error($url) && $url) : ?>
                                                            <div class="list-group-item">
                                                                <a href="<?php echo $url; ?>">
                                                                    <?php the_sub_field('sub_category_label'); ?>
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endwhile; ?> 
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
    </div>
</div>



<?php get_footer(); ?>
