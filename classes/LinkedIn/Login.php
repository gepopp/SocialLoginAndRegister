<?php


namespace SocialLoginAndRegisterClasses\LinkedIn;


class Login {


	private $token;

	private $profile;

	public function __construct() {


		$token       = new Token();
		$this->token = $token->obtain_token();

		$this->get_profile();
		$this->get_email_addresse();

		$token->save_token($this->token, $this->profile);

		$this->try_to_login();
	}


	public function try_to_login(){

		$user = get_user_by('email', $this->profile['email']);

		wp_clear_auth_cookie();
		wp_set_current_user($user->ID);
		wp_set_auth_cookie($user->ID);
		do_action('wp_login', null, $user);
		wp_safe_redirect(home_url());
		exit;


	}



	public function get_profile() {

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
		}
	}

	public function get_email_addresse(){
		$request = wp_remote_get( 'https://api.linkedin.com/v2/clientAwareMemberHandles?q=members&projection=(elements*(primary,type,handle~))', [
			'headers' => [
				'Authorization' => 'Bearer ' . $this->token->access_token,
			],
		] );

		if ( ! is_wp_error( $request ) ) {
			$profile = json_decode( wp_remote_retrieve_body( $request ) );
			$this->profile['email'] = $profile->elements[0]->{'handle~'}->emailAddress;
		}
	}

}