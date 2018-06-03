
            </div><!-- #content -->
            <footer>
                <div class="container-fluid" style="max-width: 1000px;">
                    <img id="footerLogo" class="actual-size" src="<?php echo YK_THEME_ASSET_URL.'/images/YouKnow_rgb_pos.png'  ?>" alt="Footer logo of YouKnow">
                    <div class="row">
                        <div class="col-sm-6">
                            <?php if ( is_active_sidebar( 'youknow_footer_left' ) ) : ?>
                                <div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
                                    <?php dynamic_sidebar( 'youknow_footer_left' ); ?>
                                </div><!-- #primary-sidebar -->
                            <?php endif; ?>
                        </div>
                        <div class="col-sm-6">
                            <?php if ( is_active_sidebar( 'youknow_footer_right' ) ) : ?>
                                <div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
                                    <?php dynamic_sidebar( 'youknow_footer_right' ); ?>
                                </div><!-- #primary-sidebar -->
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="copyright">
                        <p class="copyrightdate"><strong>Copyright AT&amp;T 2018</strong></p>
                        <p class="copyrighttext">The information contained on this page is confidential, proprietary AT&amp;T business information and is intended for authorized users only. Unauthorized use, disclosure or copying of this information is strictly prohibited and may be unlawful.</p>
                    </div>

                </div>
            </footer>
            <div id="content-mask" class="content-mask"></div>
        </div><!-- #content-wrapper -->
    </div><!-- #container -->

    <?php wp_footer(); ?>
</body>
