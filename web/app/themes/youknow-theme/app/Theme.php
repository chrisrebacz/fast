<?php
namespace YouKnow;

class Theme
{
    public function run()
    {
        add_action('init', [$this, 'registerMenus']);
        add_action('init', [$this, 'addThemeSupports']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
        add_filter('lighthouse_localize_data', [$this, 'addJavascriptData']);
        add_filter('pre_get_posts', [$this, 'addCustomTypesToQuery'], 4);
        add_filter('wp_nav_menu_items', [$this, 'addLogoutLink'], 20, 5);
        add_filter('excerpt_length', [$this, 'setExcerptLength'], 999);
        add_filter('get_the_archive_title', [$this, 'modifyArchiveTitle']);
        add_filter('wp_head', [$this, 'addInlineCss'], 999);

        add_shortcode('yk_popular_tags', [$this, 'tagCloud']);
        add_filter('widget_text', 'do_shortcode');

        add_action('template_redirect', [$this, 'routeToDepartmentHomePage']);
    }

    public function enqueueAssets()
    {

        wp_enqueue_style('font-awesome', YK_THEME_ASSET_URL.'/css/font-awesome.min.css');
        wp_enqueue_style('youknow-css', YK_THEME_ASSET_URL.'/css/youknow.css');
        wp_enqueue_script('youknow-js', YK_THEME_ASSET_URL.'/js/youknow.js', ['jquery'], YK_THEME_VERSION, true);

        $this->localizeJsData('youknow-js');
    }

    /**
     * Data that we would like to pass from PHP to Javascript so that
     * our JS can have the requisite information.
     * @param  string $handle
     * @return void
     */
    public function localizeJsData($handle = 'youknow-js')
    {
        $data = [
            'site_url' => get_site_url(),
            'ajaxurl' => admin_url('admin-ajax.php'),
            'rest_url' => rest_url().'lighthouse/v1/',
        ];
        $data = apply_filters('lighthouse_localize_data', $data);

        wp_localize_script($handle, 'DLH', $data);
    }

    /**
     * Enable custom post types within archive queries for
     * taxonomies.
     * @param \WP_Query $query
     */
    public function addCustomTypesToQuery($query)
    {
        if (is_category() || is_tag() && empty($query->query_vars['suppress_filters'])) {
            $query->set('post_type', $this->getPublicPostTypes());
        }
        return $query;
    }

    /**
     * Register Menus For Each Business Unit.
     * @return void
     */
    public function registerMenus()
    {
        $orgs = app('options')->get('app.orgs', []);
        foreach ($orgs as $name => $label) {
            register_nav_menu($name, $label);
        }
    }

    /**
     * Register various theme supports within the theme
     * @return void
     */
    public function addThemeSupports()
    {
        add_post_type_support('page', 'excerpt');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('html5', ['caption', 'gallery', 'search-form']);
    }

    /**
     * Add a logout link to the side menu so that users can easily
     * log out of the account.
     * If you ever change the core html of the side menu, make sure to
     * update the html structure in this method.
     * @param   array $items
     * @param   array $args
     * @return  array
     */
    public function addLogoutLink($items, $args)
    {
        if (is_admin()) {
            return items;
        }

        $link = '<a href="'.wp_logout_url('/index.php').'" title="Logout">'. __('Logout', 'att').'</a>';
        $items .= '<li id="login_logout_menu-link" class="menu-item menu-type-link">'.$link.'</li>';
        if (current_user_can('edit_posts') || current_user_can('edit_users')) {
            $link2 = '<a href="'.admin_url('/').'" title="Admin">'. __('Admin', 'att').'</a>';
            $items .= '<li id="login_logout_menu-link" class="menu-item menu-type-link">'.$link2.'</li>';
        }
        
        return $items;
    }

    /**
     * When a user requests a home page, we want to be sure to send them to
     * the default home page for their organization. This only impacts
     * users who are requesting the base url of the site.
     * @return void
     */
    public function routeToDepartmentHomePage()
    {
        if (is_front_page() || is_home()) {
            $userrole = get_query_var('userrole', 'att_employee');
            $attuid = get_query_var('attuid', false);
            $org = $this->getUserHomeDefault($userrole);
            if ($org === null) {
                $org = 'iefs';
            }
            $page = get_page_by_path($org.'-home');
            $pageUrl = get_permalink($page->ID);
            $url = add_query_arg('userrole', $userrole, $pageUrl);
            if ($attuid) {
                $url = add_query_arg('attuid', $attuid, $url);
            }
            wp_redirect($url);
            exit();
        }
    }

    /**
     * Get a list of all post types that are available for viewing
     * within the frontend of the site.
     * @return array
     */
    public function getPublicPostTypes()
    {
        $types = app('config')->get('posttypes', []);
        if (count($types) > 0) {
            $return = array_map(function ($type) {
                return $type['name'];
            }, $types);
            $return[] = 'post';
            return $return;
        }
        return ['post', 'page'];
    }


    public function getUserHomeDefault($userrole = null)
    {
        if (is_null($userrole)) {
            $userrole = get_query_var('userrole', false);
        }

        if ($userrole) {
            if (strpos($userrole, 'tfs_') !== false) {
                return 'tfs';
            }
            if (strpos($userrole, 'tcc_') !== false) {
                return 'tcc';
            }

            if ($userrole == 'contractor_tech') {
                return 'vendor';
            }
        }
        return 'iefs';
    }

    public static function organization($userrole = null)
    {
        if (is_null($userrole)) {
            $userrole = get_query_var('userrole', false);
        }
        if ($userrole) {
            if (strpos($userrole, 'tfs_') !== false) {
                return 'tfs';
            }
            if (strpos($userrole, 'tcc_') !== false) {
                return 'tcc';
            }

            if ($userrole == 'contractor_tech' || $userrole == 'vendor') {
                return 'vendor';
            }
        }
        return 'iefs';
    }

    public function addJavascriptData($data)
    {
        global $wp_query;
        if (get_page_template_slug(get_queried_object_id()) == 'homepage.php') {
            $page = $wp_query->query['pagename'];
            $activeTab = str_replace('-home', '', $page);

            $departmentFields = get_fields(get_queried_object_id());

            $data['home'] = [
                'default_tab' => $this->getUserHomeDefault(),
                'active_tab' => $activeTab,
                'departmentFields' => $departmentFields,
                'saved' => [
                    'initial_load' => true
                ],
                'departments' => [
                    [
                        'name' => 'iefs',
                        'label' => 'IEFS',
                        'searchfilters' => [],
                        'quicklinks' => [],
                        'categories' => []
                    ],
                    [
                        'name' => 'tfs',
                        'label' => 'TFS',
                        'searchfilters' => [],
                        'quicklinks' => [],
                        'categories' => []
                    ],
                    [
                        'name' => 'nsg',
                        'label' => 'NSG',
                        'searchfilters' => [],
                        'quicklinks' => [],
                        'categories' => []
                    ],
                    [
                        'name' => 'ehs',
                        'label' => 'EH&S',
                        'searchfilters' => [],
                        'quicklinks' => [],
                        'categories' => []
                    ],
                    [
                        'name' => 'tcc',
                        'label' => 'TCC Dispatch',
                        'searchfilters' => [],
                        'quicklinks' => [],
                        'categories' => []
                    ],
                    [
                        'name' => 'tiots',
                        'label' => 'TIOTS',
                        'searchfilters' => [],
                        'quicklinks' => [],
                        'categories' => []
                    ],
                    [
                        'name' => 'youcoach',
                        'label' => 'youCoach',
                        'searchfilters' => [],
                        'quicklinks' => [],
                        'categories' => []
                    ],
                    [
                        'name' => 'fleet',
                        'label' => 'Fleet',
                        'searchfilters' => [],
                        'quicklinks' => [],
                        'categories' => []
                    ],
                ],
            ];
        }

        

        return $data;
    }

    /**
     * Modify the length of the excerpt. This only applies
     * if the excerpt is generated from the first words of
     * the article.  Custom excerpts are the length they
     * need to be.
     * @param integer $length
     */
    public function setExcerptLength($length)
    {
        return 30;
    }

    /**
     * Modify the archive title when we call those pages
     * within YouKnow
     * @param  string $title
     * @return string
     */
    public function modifyArchiveTitle($title)
    {
        if (is_category()) {
            $title = single_cat_title('', false);
        } elseif (is_tag()) {
            $title = single_tag_title('', false);
        } elseif (is_post_type_archive()) {
            $title = str_replace('Archives: ', '', $title);
        }
        return $title;
    }

    public function tagCloud()
    {
        $tags = get_tags();
        $args = array(
            'smallest'                  => 10,
            'largest'                   => 22,
            'unit'                      => 'px',
            'number'                    => 10,
            'format'                    => 'flat',
            'separator'                 => " ",
            'orderby'                   => 'count',
            'order'                     => 'DESC',
            'show_count'                => 1,
            'echo'                      => false
        );
 
        $tag_string = wp_generate_tag_cloud($tags, $args);
 
        return $tag_string;
    }



    /**
     * Add styles to the head of the document.
     *
     * For example, we add styles that hide the admin bar
     * from regular viewers, but still show it to our
     * content authors.
     */
    public function addInlineCss()
    {
        if (current_user_can('edit_posts')) {
        ?>
        <style type="text/css">
            @media screen and (max-width: 600px) {
                #wpadminbar {
                    position: fixed !important;
                }
            }
        </style>
        <?php
        } else {
        ?>
        <style type="text/css">
            #wpadminbar {display:none;}
            html { margin-top: 0 !important; }
            * html body { margin-top: 0 !important; }
            @media screen and ( max-width: 782px ) {
                html { margin-top: 0 !important; }
                * html body { margin-top: 0 !important; }
            }
        </style>
        <?php
        }
    }
}
