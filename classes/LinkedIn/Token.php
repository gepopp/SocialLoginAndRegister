<?php


namespace SocialLoginAndRegisterClasses\LinkedIn;


use SocialLoginAndRegisterClasses\Tables;
use SocialLoginAndRegisterClasses\Constants;

class Token {

	private $token_url = "https://www.linkedin.com/oauth/v2/accessToken";


	public function save_token( $token, $profile ) {

		global $wpdb;
		$wpdb->delete($wpdb->prefix . Tables::TOKENS_TABLE, ['email' => $profile['email']]);
		$wpdb->insert( $wpdb->prefix . Tables::TOKENS_TABLE, [
			'plattform'    => 'linkedin',
			'plattform_id' => $profile['id'],
			'email'        => $profile['email'],
			'name'         => $profile['firstname'] . ' ' . $profile['lastname'],
			'access_token' => $token->access_token,
			'expires_in'   => $token->expires_in,
		] );

	}


	public function obtain_token() {

		$authorization = new LinkedInAuthorizationURL();

		$url = add_query_arg( [
			'grant_type'    => 'authorization_code',
			'code'          => $_GET['code'],
			'client_id'     => Constants::get_client_id(),
			'client_secret' => Constants::get_client_secret(),
			'redirect_uri'  => $authorization->get_redirect_url(),
		], $this->token_url );



		$request = wp_remote_post( $url, [
			'headers' => [
				'Content-Type' => 'x-www-form-urlencoded',
			],
		] );

		if ( ! is_wp_error( $request ) ) {
			return json_decode(wp_remote_retrieve_body( $request ));
		}

	}

}