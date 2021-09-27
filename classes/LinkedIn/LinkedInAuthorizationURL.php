<?php

namespace SocialLoginAndRegisterClasses\LinkedIn;

use SocialLoginAndRegisterClasses\Session;
use SocialLoginAndRegisterClasses\Constants;


class LinkedInAuthorizationURL {


	protected $redirectUrl;


	public function __construct() {

		$this->redirectUrl = home_url( $this->get_redirect_path() );
		new Session();

	}




	public function authorziation_url($redirect = '', $action = '' ) : string {

		return add_query_arg( [
			'state'         => $this->create_state($redirect, $action),
			'response_type' => 'code',
			'client_id'     => Constants::get_client_id(),
			'redirect_uri'  => $this->redirectUrl,
			'scope'         => Constants::SLAR_LINKEDIN_EMAIL_SCOPE . '%20' . Constants::SLAR_LINKEDIN_PROFILE_SCOPE,
		], Constants::SLAR_LINKEDIN_API_URL );

	}






	public function create_state($redirect = '', $action = '') : string {

		$state = [
			'nonce'    => wp_create_nonce( 'linkedinoauth' ),
			'redirect' => empty($redirect) ? wp_get_referer() : $redirect,
			'action'   => $action
		];

		return base64_encode(json_encode($state));
	}





	/**
	 * @return string|void
	 */
	public function get_redirect_url(): string {
		return $this->redirectUrl;
	}




	/**
	 *
	 * @return string
	 */
	public function get_redirect_path(): string {
		$options = get_option(Constants::SLAR_GENERAL_SETTING);
		return empty( $options['linkedin_redirect_url'] ) ? 'linkedinoauth' : $options['linkedin_redirect_url'];
	}




	public function decode_state(){

		$state = sanitize_text_field($_GET['state']);
		return json_decode(base64_decode($state));

	}


	public function get_current_url(){
		global $wp;
		return home_url( $wp->request );
	}

}