<?php $attLogo = YK_THEME_ASSET_URL.'/images/att_hz_lkp_rgb_wht.svg'; ?>
<header id="header">
    <div style="width: 100px;">
        <div class="toolbar-button toolbar-menu-trigger">
            <button type="button" class="header-toggle" id="menu-trigger">
                <span><i class="fa fa-lg fa-bars"></i></span>
            </button>
        </div>
    </div>
    <div style="display: flex;align-content: center;justify-content: center;flex: 1;">
        <a href="<?php echo YK_BASE_URI; ?>"><img id="mainlogo" src="<?php echo $attLogo; ?>" alt="logo"></a>
        <!-- <div style="display: flex; justify-content: center; align-items: center;">  <a style="font-weight: bold;color: #009fdb;padding-bottom: 0.25rem;text-transform: uppercase;" class="header-org-menu">TCC Dispatch <i class="fa fa-caret-down"></i></a>
        </div> -->
    </div>
    
    <div style="display:flex; width: 100px; justify-content: flex-end;">
        <div class="toolbar-button toolbar-search-button">
             <button type="button" class="header-toggle off-canvas-menu-slide-right-trigger slide-right-trigger" id="search-trigger">
                <span><i class="fa fa-lg fa-bookmark"></i></span>
            </button>
        </div>
    </div>
</header>
