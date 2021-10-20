<?php


namespace SocialLoginAndRegisterClasses;


use SocialLoginAndRegisterClasses\LinkedIn\SarlLogin;
use SocialLoginAndRegisterClasses\LinkedIn\SarlLinkedInAuthorizationURL;

class SarlRewriteRules {


	public function __construct() {
		add_action('parse_request', [ $this, 'sarl_LinkedIn_rewrite_rule' ]);
	}


	public function sarl_LinkedIn_rewrite_rule() {

		$linkedin_authorization_url = new SarlLinkedInAuthorizationURL();
		$linkedInURL = $linkedin_authorization_url->sarl_get_redirect_path();

		if(str_starts_with($_SERVER["REQUEST_URI"], '/' . $linkedInURL)) {
			new SarlLogin();
			exit();
		}

	}



}