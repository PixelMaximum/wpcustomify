<?php
/**
 * Template Name: EDD My Account
 */

get_header(); ?>
	<div class="content-inner">


		<?php
        // If user logged in, show dashboard.
        if ( is_user_logged_in() ) : ?>
            <?php
	        $current_user      = wp_get_current_user();
	        $user_id           = $current_user->ID;
	        $user_email        = $current_user->user_email;
	        $user_display_name = $current_user->display_name;
	        $user_first_name   = $current_user->user_firstname;
	        $user_username     = $current_user->user_login;
	        $user_nicename     = $user_username;
	        if ( $user_display_name != '' ) {
		        $user_nicename = $user_display_name;
	        }
	        if ( $user_first_name != '' ) {
		        $user_nicename = $user_first_name;
	        }
            ?>

			<div class="my-account-wrapper clearfix">

                <div class="my-account-sidebar">
                    <div class="welcome-area">
                        <h4>Welcome, <?php echo $user_nicename; ?>!</h4>
                        <p>Use the links below to navigate your account information.</p>
                    </div>
                    <ul class="account-tabs" data-tabgroup="account-tab-first">
                        <li><a href="#tab1" class="active">Purchases</a></li>
                        <li><a href="#tab2">License Keys</a></li>
                        <li><a href="#tab3">Subscriptions</a></li>
                        <li><a href="#tab4">Downloads</a></li>
                        <li><a href="#tab5">Profile</a></li>
                    </ul>
                </div>

                <div class="my-account-main">
                    <div id="account-tab-first" class="account-tabs-group">

                        <div id="tab1" class="account-tab-content">
                            <h3>Your purchase history</h3>
                            <p>All purchases below were completed with the following email address: <?php echo $user_email; ?>. If you have trouble locating purchases, please contact support for assistance.</p>
                            <?php echo do_shortcode('[purchase_history]'); ?>
                        </div>

                        <div id="tab2" class="account-tab-content">
                            <h3>Manage your license keys</h3>
                            <p>Below you will find all license keys for you previous purchases. Use the <b>Manage Sites</b> links to authorize specific URLs for your license keys. Use the <b>Extend License</b> or <b>Renew License</b> links to adjust the terms of your license keys.</p>
                            <?php echo do_shortcode('[edd_license_keys]'); ?>
                        </div>

                        <div id="tab3" class="account-tab-content">
                            <h3>Manage your subscriptions</h3>
                            <p>Use the tools below to view subscription details, manage all of your product subscriptions, and view invoices.</p>
                            <?php echo do_shortcode( '[edd_subscriptions]' ); ?>
                        </div>

                        <div id="tab4" class="account-tab-content">
                            <h3>Your download history</h3>
                            <p>Below you will find a complete history of your file downloads.</p>
                            <?php echo do_shortcode('[download_history]'); ?>
                        </div>

                        <div id="tab5" class="account-tab-content">
                            <h4>Edit your profile information</h4>
                            <p>Use the form below to edit the information saved in your user profile. Select information will be used to auto-complete the checkout form for your next purchase.</p>
                            <?php echo do_shortcode('[edd_profile_editor]'); ?>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Account Tab JS -->
            <script type="text/javascript">
                jQuery('.account-tabs-group > div').hide();
                jQuery('.account-tabs-group > div:first-of-type').show();
                jQuery('.account-tabs a').click(function(e){
                    e.preventDefault();
                    var $this = jQuery(this),
                        tabgroup = '#'+$this.parents('.account-tabs').data('tabgroup'),
                        others = $this.closest('li').siblings().children('a'),
                        target = $this.attr('href');
                    others.removeClass('active');
                    $this.addClass('active');
                    jQuery(tabgroup).children('div').hide();
                    jQuery(target).show();
                });
            </script>

		<?php
        // User not logged, show login form.
        else: ?>
			<div class="edd-login-wrapper">
				<?php echo do_shortcode('[edd_login]'); ?>
			</div>
		<?php endif; ?>


	</div><!-- #.content-inner -->
<?php
get_footer();
