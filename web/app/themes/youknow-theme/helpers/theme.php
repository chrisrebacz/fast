<?php


if (! function_exists('youknow_get_format_for_type')) :
    /**
     * Get the appropriate post format for the post type.
     */
    function youknow_get_format_for_type($post)
    {
        $type = get_post_type($post->ID);

        $labels = [
            'iefs' => 'IEFS',
            'iefs_comm' => 'IEFS Communications',
            'tfs'  => 'TFS',
            'post' => 'News',
            'iefs_tu' => 'IEFS Training',
            'tfs_tu' => 'TFS Training',
            'youcoach' => 'YouCoach',
            'fleet' => 'Fleet',
            'ehs' => 'EH&S',
            'nsg' => 'NSG',
            'tiots' => 'Regional',
        ];

        return isset($labels[$type]) ? $labels[$type] : 'Reference';
    }
endif;

if (! function_exists('get_youknow_posttype_label')) :
    /**
     * Get the label for the post type for display purposes. Since
     * the Post label can be renamed via admin config, we check to
     * see if that has been set first.
     */
    function get_youknow_posttype_label($id)
    {
        $type = get_post_type($id);

        if ($type == 'post') {
            return app('config')->get('admin.post_label.menu', 'Post');
        }

        if ($type == 'iefs_tu') {
            return 'IEFS';
        }

        if ($type == 'iefs_comm') {
            return 'IEFS Communication';
        }

        if ($type == 'tfs_tu') {
            return 'TFS';
        }

        return get_post_type_object($type)->labels->name;
    }
endif;

if (! function_exists('get_youknow_formatted_title')) :
    /**
     * Format the title tag within an HTML page based on the
     * specific template that is being loaded.
     */
    function get_youknow_formatted_title()
    {
        /* Used variables */
        $title_separator = '|';
        $output = '';

        /* Page related formatting */
        if (is_tag()) {
            $output .= single_tag_title(__('Tag Archive for', 'att') . ' &quot;', false) . '&quot; ' . $title_separator . ' ';
        } elseif (is_archive()) {
            $output .= wp_title('', false) . ' ' . __('Archive', 'att') . ' ' . $title_separator . ' ';
        } elseif (is_search()) {
            $output .= ' ' . __('Search for', 'att') . ' &quot;' . get_search_query() . '&quot; ' . $title_separator . ' ';
        } elseif (!(is_404()) && (is_single()) || (is_page())) {
            $output .= wp_title('', false) . ' ' . $title_separator . ' ';
        } elseif (is_404()) {
            $output .= ' ' . __('Not Found', 'att') . ' ' . $title_separator . ' ';
        }

        /* If home - prints description */
        if (is_home()) {
            $output .= 'AT&T | YouKnow';
        } else {
            $output .= 'YouKnow';
        }

        /* Paged sites */
        if (isset($paged)) {
            if ($paged > 1) {
                $output .= ' ' . $title_separator . ' ' . __('page', 'att') . ' ' . $paged;
            }
        }
        echo $output;
    }
endif;


if (! function_exists('get_youknow_published_date')) :
    /**
     * Highlight via badges when an article is either new or updated. It defaults
     * to the modified date from within the posts table.
     */
    function get_youknow_published_date()
    {
        $cutoff = new DateTime('-2 weeks');
        $badge = '';
        $updated_date = new DateTime(get_the_modified_date());
        $created_date = new DateTime(get_the_date());
        $published_diff = $updated_date->diff($created_date);
        $formatted_diff = $published_diff->format('%d');
        if($formatted_diff > '7'){
            $badgeText = 'updated';
        } else {
            $badgeText = 'new';
        }
        if ($updated_date > $cutoff) {
            $badge = '<span class="youknow-date-badge">' . $badgeText . '</span>';
        }
        echo '<span class="youknow-date-title">'. get_the_modified_date() . $badge . '</span>';
    }
endif;


if (! function_exists('get_youknow_posttype_config')) :
    /**
     * Get data that is captured within the posttypes config file used within the theme.  Currently,
     * that includes three items.
     */
    function get_youknow_posttype_config($post_id)
    {
        $posttype = get_post_type($post_id);
        if ($posttype == 'post' || $posttype == 'page') {
            if ($posttype == 'post') {
                return [
                    'label' => 'News',
                    'class' => 'news',
                    'icon'  => 'fa-news'
                ];
            } elseif ($posttype == 'page') {
                return [
                    'label' => 'Page',
                    'class' => 'reference',
                    'icon'  => 'fa-book'
                ];
            }
        }

        $options = collect(app('config')->get('posttypes', []));

        $option = $options->filter(function ($type) use($posttype) {
            return $type['name'] == $posttype;
        });
        if (! empty($option) && is_array($option)) {
            $option = $option->toArray()[0];    
        } else {
            $option = [];
        }
        
        return [
            'label' => isset($option['labels']['plural']) ? $option['labels']['plural'] : 'Reference',
            'class' => isset($option['meta']['class']) ? $option['meta']['class'] : 'reference',
            'icon'  => isset($option['meta']['icon']) ? $option['meta']['icon'] : 'fa-book',
        ];
    }
endif;


if (! function_exists('get_youknow_posttype_label')) :
    /**
     * Get the label for the post type for display purposes. Since
     * the Post label can be renamed via admin config, we check to
     * see if that has been set first.
     */
    function get_youknow_posttype_label($id)
    {
        $type = get_post_type($id);

        if ($type == 'post') {
            return app('config')->get('admin.post_label.menu', 'Post');
        }

        if ($type == 'iefs_tu') {
            return 'IEFS';
        }

        if ($type == 'tfs_tu') {
            return 'TFS';
        }

        return get_post_type_object($type)->labels->name;
    }
endif;

if (! function_exists('get_youknow_taxonomies')) :
    /**
     * Get a list of available taxonomies for a particular post type. Since
     * we are not using category for content but for access, we will remove
     * it.
     */
    function get_youknow_taxonomies($posttype)
    {
        $taxonomies = get_object_taxonomies($posttype, 'objects');
        unset($taxonomies['category']);
        return $taxonomies;
    }
endif;


if (! function_exists('youknow_trim_title')) :
    /**
     * If an article title is written with a prefix, and users would like
     * the prefix removed when a list view of all articles is generatd, this
     * function can be used to remove the prefix pattern from the title.
     */
    function youknow_trim_title($title = null, $prefix = null)
    {
        $title = the_title('','',false);
        // $pattern [0] = '/System Error Code: /';
        $pattern[0] = '/'.$prefix.'/';
        $replacement [0] = '';

        echo preg_replace($pattern, $replacement, $title);
    }
endif;

if (! function_exists('youknow_pagination')) :
    /**
     * pagination helper that utilizes Bootstrap styling
     */
    function youknow_pagination($args = [])
    {
        $defaults = array(
            'range'           => 4,
            'custom_query'    => FALSE,
            'previous_string' => 'Prev',
            'next_string'     => 'Next',
            'before_output'   => '<div class="post-nav"><ul class="pager">',
            'after_output'    => '</ul></div>'
        );

        $args = wp_parse_args(
            $args,
            apply_filters('youknow_pagination_defaults', $defaults)
        );

        $args['range'] = (int) $args['range'] - 1;
        if (! $args['custom_query']) {
            $args['custom_query'] = @$GLOBALS['wp_query'];
        }

        $count = (int) $args['custom_query']->max_num_pages;
        $page  = intval( get_query_var( 'paged' ) );
        $ceil  = ceil( $args['range'] / 2 );

        if ( $count <= 1 ) {
            return false;
        }

        if (! $page) {
            $page = 1;
        }

        if ( $count > $args['range'] ) {
            if ( $page <= $args['range'] ) {
                $min = 1;
                $max = $args['range'] + 1;
            } elseif ( $page >= ($count - $ceil) ) {
                $min = $count - $args['range'];
                $max = $count;
            } elseif ( $page >= $args['range'] && $page < ($count - $ceil) ) {
                $min = $page - $ceil;
                $max = $page + $ceil;
            }
        } else {
            $min = 1;
            $max = $count;
        }

        $echo = '';
        $previous = intval($page) - 1;
        $previous = esc_attr(get_pagenum_link($previous));
        $firstpage = esc_attr(get_pagenum_link(1));

        if ($firstpage && (1 != $page)) {
            $echo .= '<li class="previous"><a href="' . $firstpage . '">First</a></li>';
        }

        if ($previous && (1 != $page)) {
            $echo .= '<li><a href="'.$previous.'" title="previous">'.$args['previous_string'].'</a></li>';
        }

        if (! empty($min) && !empty($max)) {
            for( $i = $min; $i <= $max; $i++ ) {
                if ($page == $i) {
                    $echo .= '<li class="active"><span class="active">'.str_pad((int)$i, 2, '0', STR_PAD_LEFT ).'</span></li>';
                } else {
                    $echo .= sprintf('<li><a href="%s">%002d</a></li>', esc_attr( get_pagenum_link($i)), $i);
                }
            }
        }

        $next = intval($page) + 1;
        $next = esc_attr(get_pagenum_link($next));
        if ($next && ($count != $page) ) {
            $echo .= '<li><a href="'.$next.'" title="next">'.$args['next_string'].'</a></li>';
        }
        $lastpage = esc_attr( get_pagenum_link($count) );
        if ($lastpage) {
            $echo .= '<li class="next"><a href="'.$lastpage.'">Last</a></li>';
        }

        if ( isset($echo) ) {
            echo $args['before_output'] . $echo . $args['after_output'];
        }
    }
endif;

if (! function_exists('youknow_slug_exists')) :
    /**
     * Check whether a slug already exists in the database.
     */
    function youknow_slug_exists($slug = null)
    {
        if ($slug !== null) {
            global $wpdb;
            
            if ($wpdb->get_row("SELECT post_name FROM $wpdb->posts WHERE post_name = '".$slug."'", 'ARRAY_A')) {
                return true;
            } else {
                return false;
            }
        }
    }
endif;


if (! function_exists('youknow_related_content')) :
    /**
     * Get a list of related content to a document.
     */
    function youknow_related_content ($post_id = null) 
    {
        if (is_null($post_id)) {
            $post_id = get_the_ID();
        }
        $articles = get_field('related_articles', $post_id);
        if (! $articles || ! is_array($articles)) {
            $articles = [];
        }
        $downloads = get_field('downloads_from_youknow', $post_id);
        if (! $downloads || ! is_array($downloads)) {
            $downloads = [];
        }
        $external = get_field('related_external_documents', $post_id);
        if (! $external || ! is_array($external)) {
            $external = [];
        }

        return [
            'articles' => $articles,
            'downloads' => $downloads,
            'external' => $external
        ];
    }
endif;


if (! function_exists('youknow_related_topics')) :
    /**
     * //
     */
    function youknow_related_topics ($post_id = null) 
    {
        if (is_null($post_id)) {
            $post_id = get_the_ID();
        }
        $posttype = get_post_type($post_id);

        if (strpos($posttype, 'iefs') !== false) {
            $taxonomy = 'iefs_cat';
        } elseif (strpos($posttype, 'tfs') !== false) {
            $taxonomy = 'tfs_cat';
        } else {
            $taxonomy = $posttype.'_cat';
        }
        $terms = wp_get_object_terms($post_id, $taxonomy);
        return $terms;
    }
endif;
