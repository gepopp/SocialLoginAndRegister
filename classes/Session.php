<?php


namespace SocialLoginAndRegisterClasses;


class Session {


	protected $wpdb;

	protected $tablename;

	protected $session;


	public function __construct() {

		global $wpdb;
		$this->wpdb      = $wpdb;
		$this->tablename = $wpdb->prefix . Tables::SESSION_TABLE;

		$this->sarl_cleanup_table();

		if ( ! isset( $_COOKIE['PHPSESSID'] ) ) {
			session_start();
			$this->sarl_save();
		}

		$this->get();
	}

	public function get( $id = '' ) {

		if(empty($id)) $id = $_COOKIE['PHPSESSID'] ?? session_id();
		$sql = sprintf('SELECT * FROM %s WHERE session_id = "%s" LIMIT 1;', $this->tablename, $id);
		return $this->wpdb->get_row($sql);

	}




	private function sarl_save( $content = [] ) {

		$this->wpdb->insert( $this->tablename, [
			'session_id' => session_id(),
			'content'    => maybe_serialize( $content ),
		], [ '%s', '%s' ] );

	}




	public function sarl_update( $id, $content = [] ) {

		$this->wpdb->update( $this->tablename, [
			'content' => maybe_serialize($content),
		],
			[ 'session_id' => $id ]
		);

	}


	public function sarl_cleanup_table() {

		$sql = sprintf( 'DELETE FROM %s WHERE created_at < (NOW() - INTERVAL 30 MINUTE);', $this->tablename );
		$this->wpdb->get_results( $sql );

	}


}