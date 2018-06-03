<?php
namespace YouKnow;

class ThemeActivation
{
    public function run()
    {
        $orgs = app('options')->get('app.orgs', []);
        $user = wp_get_current_user();

        foreach ($orgs as $name => $label) {
            $slug = $name.'-home';
            if (! youknow_slug_exists($slug)) {
                $new_page_id = wp_insert_post([
                    'post_title' => $label.' Home Page',
                    'post_type'  => 'page',
                    'post_name'  => $slug,
                    'comment_status' => 'closed',
                    'ping_status' => 'closed',
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_author' => $user->ID,
                    'menu_order' => 0,
                    'page_template' => 'homepage.php',
                ]);
            }
        }
    }
}
