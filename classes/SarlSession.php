<?php


namespace SocialLoginAndRegisterClasses;


class SarlSession {


	const COOKIENAME = 'PHPSESSID';

	protected \wpdb $wpdb;

	protected $tablename;

	protected $session_id;

	protected $content = [];

	private static $instance = null;


	private function __construct() {}


	public static function sarl_session_get_instance() {

		if ( self::$instance == null ) {
			self::$instance = new SarlSession();
			self::$instance->sarl_session_setup();
		}

		return self::$instance;
	}

	private function __clone() {
	}


	public function sarl_session_add( $index, $message ) {

		$this->content[ $index ][] = $message;
		$this->sarl_session_save();

	}


	public function sarl_session_setup() {

		global $wpdb;
		$this->wpdb      = $wpdb;
		$this->tablename = $wpdb->prefix . SarlTables::SESSION_TABLE;

		$this->sarl_session_load();

	}


	public function sarl_session_load() {

		$saved_session = $this->wpdb->get_row( sprintf( 'SELECT * FROM %s WHERE session_id = "%s" LIMIT 1', $this->tablename, sanitize_text_field( $_COOKIE[ self::COOKIENAME ] ) ), ARRAY_A );

		$this->session_id = $saved_session['session_id'] ?? $_COOKIE[ self::COOKIENAME ];
		$this->content    = maybe_unserialize( $saved_session['content'] ?? [] );

		$this->sarl_session_save();

	}


	public function sarl_session_has( $index ) {

		return array_key_exists( $index, $this->content );

	}

	public function sarl_session_flash( $index ) {
		ob_start()
		?>
        <ul class="text-xs w-full text-center my-3 text-red-900">
			<?php foreach ( $this->content[ $index ] as $item ): ?>
                <li><?php echo $item ?></li>
			<?php endforeach; ?>
        </ul>
		<?php
		$content = ob_get_clean();
		unset( $this->content, $index );
		$this->sarl_session_save();

		return $content;
	}


	public function sarl_session_save() {

		$this->wpdb->delete( $this->tablename, [ 'session_id' => $this->session_id ] );
		$this->wpdb->insert( $this->tablename, [
			'session_id' => $this->session_id,
			'content'    => maybe_serialize( $this->content ?? [] ),
		] );

	}


	public function sarl_session_get( $index = false ) {
		if ( ! $index ) {
			return $this->content;
		} else {
			return $this->content[ $index ];
		}
	}

}