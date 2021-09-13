<?php
add_action( 'login_form', function () {

    new \SocialLoginAndRegisterClasses\Session();

	$options = get_option( \SocialLoginAndRegisterClasses\Constants::SLAR_GENERAL_SETTING );
	if ( $options['linkedin_auto_inject'] ) {
		ob_start();
		?>
        <div class="w-full py-10">
			<?php echo do_shortcode( '[slar_login_button]' ); ?>
        </div>
		<?php
		echo ob_get_clean();
	}
} );