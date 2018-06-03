<div class="ibox float-e-margins dlh-sidebar" id="desktop-search-container">
    <div class="ibox-title">
      <h5>Search YouKnow</h5>
    </div>
    <div class="ibox-content no-padding">
      <form class="form" role="search" action="<?php echo home_url('/'); ?>" style="padding: 1.5rem;">
        <div class="input-group">
          <input type="search" class="form-control" placeholder="Search for..." name="s" id="dock-desktop-menu-search-input">
          <span class="input-group-btn">
            <button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button>
          </span>
        </div>
        <?php if (youknow_user_is_vendor()) : ?>

          <?php else:  ?>
          <div class="input-group">
                <div class="checkbox">
                  <label class="youknow_search_options">
                    <input type="checkbox" id="desktop_post_type_all" name="youknow_search_filter[]" value="all" checked>
                    All articles
                  </label>
                </div>
                <div class="checkbox">
                  <label class="youknow_search_options">
                    <input type="checkbox" id="desktop_post_type_news" name="youknow_search_filter[]" value="post">
                    News
                  </label>
                </div>
                <div class="checkbox">
                  <label class="youknow_search_options">
                    <input type="checkbox"  id="desktop_post_type_iefs" name="youknow_search_filter[]" value="iefs">
                    IEFS
                  </label>
                </div>
                <div class="checkbox">
                  <label class="youknow_search_options">
                    <input type="checkbox" id="desktop_post_type_tfs" name="youknow_search_filter[]" value="tfs">
                    TFS
                  </label>
                </div>
                <div class="checkbox">
                  <label class="youknow_search_options">
                    <input type="checkbox" id="desktop_post_type_ehs" name="youknow_search_filter[]" value="ehs">
                    EH&S
                  </label>
                </div>
                <div class="checkbox">
                  <label class="youknow_search_options">
                    <input type="checkbox" id="desktop_post_type_nsg" name="youknow_search_filter[]" value="nsg">
                    NSG
                  </label>
                </div>
                <div class="checkbox">
                  <label class="youknow_search_options">
                    <input type="checkbox" id="desktop_post_type_tcc" name="youknow_search_filter[]" value="tcc">
                    TCC Dispatch
                  </label>
                </div>
                <div class="checkbox">
                  <label class="youknow_search_options">
                    <input type="checkbox" id="desktop_post_type_tiots" name="youknow_search_filter[]" value="tiots">
                    TIOTS
                  </label>
                </div>
                <div class="checkbox">
                  <label class="youknow_search_options">
                    <input type="checkbox" id="desktop_post_type_fleet" name="youknow_search_filter[]" value="fleet">
                    Fleet
                  </label>
                </div>
                <div class="checkbox">
                  <label class="youknow_search_options">
                    <input type="checkbox" id="desktop_post_type_youcoach" name="youknow_search_filter[]" value="youcoach">
                    youCoach
                  </label>
                </div>
            </div>
          <?php endif; ?>
      </form>
    </div>
</div>
<style>
  label.youknow_search_options {
    font-weight: 700;
  }
</style>
