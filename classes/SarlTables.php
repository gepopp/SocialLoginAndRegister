<?php


namespace SocialLoginAndRegisterClasses;


class SarlTables {

	const TOKENS_TABLE  = 'sarl_oauth_tokens';
	const SHARES_TABLE  = 'sarl_shares';
	const SESSION_TABLE = 'sarl_session';


	public function sarl_create_update_tables() {


		$installed_ver = get_option( "linkedinoauthversion" );

		if ( $installed_ver == SocialLoginAndRegister_VERSION ) {
			return;
		}

		global $wpdb;

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );


		$charset_collate = $wpdb->get_charset_collate();

		$table_name = $wpdb->prefix . self::SESSION_TABLE;

		$sql        = "CREATE TABLE $table_name (
		id BIGINT NOT NULL AUTO_INCREMENT,
		session_id VARCHAR(255) NOT NULL,
		content TEXT NULL,
		created_at TIMESTAMP NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";
		dbDelta( $sql );


		$table_name = $wpdb->prefix . self::TOKENS_TABLE;

		$sql        = "CREATE TABLE $table_name (
		id BIGINT NOT NULL AUTO_INCREMENT,
		plattform VARCHAR(255) NOT NULL,
		plattform_id VARCHAR(255) NOT NULL,
		email VARCHAR(255) NOT NULL,
		name VARCHAR(255) NOT NULL,
		access_token TEXT NOT NULL,
		expires_in BIGINT NOT NULL,
		created_at TIMESTAMP NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";
		dbDelta( $sql );

		$table_name = $wpdb->prefix . self::SHARES_TABLE;

		$sql = "CREATE TABLE $table_name (
		id BIGINT NOT NULL AUTO_INCREMENT,
		linkedin_id VARCHAR(255) NOT NULL,
		email VARCHAR(255) NOT NULL,
		name VARCHAR(255) NOT NULL,
		share_id TEXT NOT NULL,
		post_id BIGINT NOT NULL,
		created_at TIMESTAMP NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

		dbDelta( $sql );


		update_option( 'linkedinoauthversion', SocialLoginAndRegister_VERSION );

	}

}