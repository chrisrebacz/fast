<?php

if (! function_exists('youknow_user_default_home')) :
    /**
     * Identify the default home page to show to users
     * within YouKnow. We default to the 'iefs' page.
     */
    function youknow_user_default_home()
    {
        return app('theme')->organization();
    }
endif;

if (! function_exists('youknow_user_is_vendor')) :
    /**
     * //
     */
    function youknow_user_is_vendor ($userrole = null) 
    {
        if (is_null($userrole)) {
            $userrole = get_query_var('userrole', false);
        } 
        $vendorRoles = ['vendor', 'contractor_tech', 'vendor_tech'];
        return in_array($userrole, $vendorRoles);
    }
endif;
