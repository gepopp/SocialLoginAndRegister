<?php


namespace SocialLoginAndRegisterClasses;


class Constants {

	const SLAR_GENERAL_SETTING = 'SLAR_general_settings';

	const SLAR_LINKEDIN_API_URL = 'https://www.linkedin.com/oauth/v2/authorization';

	const SLAR_LINKEDIN_PROFILE_SCOPE = 'r_liteprofile';

	const SLAR_LINKEDIN_EMAIL_SCOPE = 'r_emailaddress';

	CONST SLAR_LINKEDIN_SCHARING_SCOPE = 'w_member_social';


	public static function get_client_id() : string {
		if(defined('LINKEDIN_CLIENT_ID')){
			return LINKEDIN_CLIENT_ID;
		}else{
			$options = get_option(Constants::SLAR_GENERAL_SETTING);
			if(isset($options['linkedin_client_id'])){
				return $options['linkedin_client_id'];
			}
		}

		return false;
	}

	public static function get_client_secret() : string {
		if(defined('LINKEDIN_CLIENT_SECRET')){
			return LINKEDIN_CLIENT_SECRET;
		}else{
			$options = get_option(Constants::SLAR_GENERAL_SETTING);
			if(isset($options['linkedin_client_secret'])){
				return $options['linkedin_client_secret'];
			}
		}

		return false;
	}
	
}