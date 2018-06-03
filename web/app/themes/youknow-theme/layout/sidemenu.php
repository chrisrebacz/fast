<?php 
    $context = [
        'menu_to_display' => app('theme')->organization(),
    ];
?>
<aside id="sidemenu-container">
    <div id="sidemenu">
        <img id="youknowLogo" class="actual-size" src="<?php echo YK_THEME_ASSET_URL.'/images/YouKnow_rgb_pos.png';?>" alt="YouKnow Logo">
        <nav id="sidenav-container" class="menu-mobile-menu-container">
            <?php
            /* Sidebar Navigation */
            $menu = wp_nav_menu(array(
                'theme_location' => $context['menu_to_display'],
                'menu'           => 'mobile-menu',
                'container'      => 'div',
                'container_id'   => 'sidenav-container',
                'menu_class'     => 'sidenav',
                'echo'           => false,
            ));
             $search = '<ul class="sub-menu">';
             $replace = '<span class="sidenav-child-container"><span class="sidenav-child-trigger">+</span></span>
                        <ul class="sub-menu" style="height: 0;">';
             echo str_replace($search, $replace, $menu);
            ?>
        </nav>
    </div>
</aside>
