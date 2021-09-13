<?php


namespace SocialLoginAndRegisterClasses;


use SocialLoginAndRegisterClasses\LinkedIn\Login;
use SocialLoginAndRegisterClasses\LinkedIn\LinkedInAuthorizationURL;

class RewriteRules {


	public function __construct() {
		add_action('parse_request', [ $this, 'SLAR_LinkedIn_rewrite_rule' ]);
	}


	public function SLAR_LinkedIn_rewrite_rule() {

		$linkedin_authorization_url = new LinkedInAuthorizationURL();
		$linkedInURL = $linkedin_authorization_url->get_redirect_path();

		if(str_starts_with($_SERVER["REQUEST_URI"], '/' . $linkedInURL)) {
			new Login();
			exit();
		}

	}



}