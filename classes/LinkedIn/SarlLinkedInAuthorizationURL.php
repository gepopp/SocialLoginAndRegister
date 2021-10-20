<?php

namespace SocialLoginAndRegisterClasses\LinkedIn;

use SocialLoginAndRegisterClasses\SarlConstants;


class SarlLinkedInAuthorizationURL {


	protected $redirectUrl;


	public function __construct() {
		$this->redirectUrl = home_url( $this->sarl_get_redirect_path() );
	}




	public function sarl_authorziation_url($redirect = '', $action = '' ) : string {

		return add_query_arg( [
			'state'         => $this->sarl_create_state($redirect, $action),
			'response_type' => 'code',
			'client_id'     => SarlConstants::sarl_get_client_id(),
			'redirect_uri'  => $this->redirectUrl,
			'scope'         => SarlConstants::SLAR_LINKEDIN_EMAIL_SCOPE . '%20' . SarlConstants::SLAR_LINKEDIN_PROFILE_SCOPE,
		], SarlConstants::SLAR_LINKEDIN_API_URL );

	}




	public function sarl_create_state($redirect = '', $action = '') : string {

		global $wp;

		$state = [
			'nonce'    => wp_create_nonce( 'linkedinoauth' ),
			'redirect' => empty($redirect) ? wp_get_referer() : $redirect,
			'loginpage'=> home_url($wp->request),
			'action'   => $action
		];

		return base64_encode(json_encode($state));

	}



	public function sarl_get_redirect_url(): string {

		return $this->redirectUrl;

	}


	public function sarl_get_redirect_path(): string {

		$options = get_option(SarlConstants::SLAR_GENERAL_SETTING);
		return empty( $options['linkedin_redirect_url'] ) ? 'linkedinoauth' : $options['linkedin_redirect_url'];

	}

	public function sarl_decode_state(){

		$state = sanitize_text_field($_GET['state']);
		return json_decode(base64_decode($state));

	}


	public function sarl_get_current_url(){

		global $wp;
		return home_url( $wp->request );

	}

}