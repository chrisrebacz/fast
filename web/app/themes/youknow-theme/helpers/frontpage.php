<?php 
/*
|----------------------------------------------------------------
| Functions related to the frontpage of the site
|----------------------------------------------------------------
*/

if (! function_exists('youknow_frontpage_topnav')) :
    /**
     * Get the list of content areas that will filter the 
     * rest of the page. 
     * @return  string 
     */
    function youknow_frontpage_topnav()
    {
        //
    }
endif;

if (! function_exists('youknow_frontpage_quicklinks')) :
    /**
     * Get a list of the quick links to display on the front page.
     */
    function youknow_frontpage_quicklinks()
    {
        //
    }
endif;

if (! function_exists('youknow_frontpage_categories')) :
    /**
     * Get a list of categories to display on the front page.
     * Top level terms of each group's primary taxonomy.
     */
    function youknow_frontpage_categories()
    {
        //
    }
endif;

if (! function_exists('youknow_frontpage_tags')) :
    /**
     * //
     */
    function youknow_frontpage_tags () 
    {
        echo app('theme')->tagCloud();
    }
endif;
