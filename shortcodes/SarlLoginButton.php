<?php
add_shortcode( 'slar_login_button', function ( $args ) {
	$session = \SocialLoginAndRegisterClasses\SarlSession::sarl_session_get_instance();
	$url     = new \SocialLoginAndRegisterClasses\LinkedIn\SarlLinkedInAuthorizationURL();
	ob_start();
	?>
    <div>
		<?php if ( $session->sarl_session_has( 'errors' ) ): ?>
			<?php echo $session->sarl_session_flash( 'errors' ) ?>
		<?php endif; ?>
    </div>
    <a id="sarl_loginbutton" href="<?php echo $url->sarl_authorziation_url() ?>" class="cursor-pointer block w-full text-center text-white bg-linkedin py-3 focus:outline-none">
		<?php _e( 'Login via LinkedIn', SocialLoginAndRegister_DOMAIN ) ?>
    </a>
	<?php
	return ob_get_clean();
} );