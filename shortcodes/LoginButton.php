<?php
add_shortcode( 'slar_login_button', function ( $args ) {
	$session = \SocialLoginAndRegisterClasses\Session::sarl_session_get_instance();
	$url     = new \SocialLoginAndRegisterClasses\LinkedIn\LinkedInAuthorizationURL();
	ob_start();
	?>
    <a id="sarl_loginbutton" href="<?php echo $url->authorziation_url() ?>" class="cursor-pointer block w-full text-center text-white bg-linkedin py-3 focus:outline-none">
		<?php _e( 'Login via LinkedIn', 'slar' ) ?>
    </a>
    <div>
		<?php if ( $session->sarl_session_has( 'errors' ) ): ?>
			<?php echo $session->sarl_session_flash( 'errors' ) ?>
		<?php endif; ?>
    </div>
	<?php
	return ob_get_clean();
} );