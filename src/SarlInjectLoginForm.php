<?php
add_action( 'login_form', function () {
	$options = get_option( \SocialLoginAndRegisterClasses\SarlConstants::SLAR_GENERAL_SETTING );
	if ( $options['linkedin_auto_inject'] ?? false ) {
		ob_start();
		?>
        <div class="w-full py-10">
			<?php echo do_shortcode( '[slar_login_button]' ); ?>
        </div>
		<?php
		echo ob_get_clean();
	}
} );