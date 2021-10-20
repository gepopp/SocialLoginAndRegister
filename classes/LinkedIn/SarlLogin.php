<?php


namespace SocialLoginAndRegisterClasses\LinkedIn;


use SocialLoginAndRegisterClasses\SarlSession;

class SarlLogin {


	private $token;

	private $profile;

	private $state;

	private SarlSession $session;

	public function __construct() {

		$this->session = SarlSession::sarl_session_get_instance();

		$this->state = ( new SarlLinkedInAuthorizationURL() )->sarl_decode_state();

		$this->sarl_handle_errors();

		$token       = new SarlToken();
		$this->token = $token->sarl_obtain_token();

		$this->sarl_get_profile();
		$this->sarl_get_email_address();

		$token->sarl_save_token( $this->token, $this->profile );

		$this->sarl_try_to_login();
	}


	public function sarl_try_to_login() {

		$user = get_user_by( 'email', $this->profile['email'] );

		if ( ! $user ) {
			$this->session->sarl_session_add( 'errors', 'This E-Mail Adress is not registered.' );
			wp_safe_redirect( $this->state->loginpage );
			exit;
		}

		wp_clear_auth_cookie();
		wp_set_current_user( $user->ID );
		wp_set_auth_cookie( $user->ID );

		do_action( 'wp_login', null, $user );

		wp_safe_redirect( $this->state->redirect );
		exit;


	}


	public function sarl_handle_errors() {


		if ( ! wp_verify_nonce( $this->state->nonce, 'linkedinoauth' ) ) {
			$this->session->sarl_session_add( 'errors', __( 'Spamprotection, could not login.', SocialLoginAndRegister_DOMAIN ) );
			wp_safe_redirect( $this->state->loginpage );
			exit;
		}


		if ( isset( $_GET['error'] ) || isset( $_GET['error_description'] ) ) {
			$this->session->sarl_session_add( 'errors', __( 'You have canceled the login.', SocialLoginAndRegister_DOMAIN ) );
			wp_safe_redirect( $this->state->loginpage );
			exit;
		}


	}





	public function sarl_get_profile() {

		$request = wp_remote_get( 'https://api.linkedin.com/v2/me', [
			'headers' => [
				'Authorization' => 'Bearer ' . $this->token->access_token,
			],
		] );

		if ( ! is_wp_error( $request ) ) {
			$profile = json_decode( wp_remote_retrieve_body( $request ) );

			$this->profile = [
				'lastname'  => $profile->localizedLastName,
				'firstname' => $profile->localizedFirstName,
				'id'        => $profile->id,
			];
		}else{
			wp_die('hier');
		}
	}


	public function sarl_get_email_address() {

		$request = wp_remote_get( 'https://api.linkedin.com/v2/clientAwareMemberHandles?q=members&projection=(elements*(primary,type,handle~))', [
			'headers' => [
				'Authorization' => 'Bearer ' . $this->token->access_token,
			],
		] );

		if ( ! is_wp_error( $request ) ) {
			$profile                = json_decode( wp_remote_retrieve_body( $request ) );
			$this->profile['email'] = $profile->elements[0]->{'handle~'}->emailAddress;
		}
	}

}