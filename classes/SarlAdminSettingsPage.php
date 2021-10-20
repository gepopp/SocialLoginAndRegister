<?php

namespace SocialLoginAndRegisterClasses;


class SarlAdminSettingsPage {


	public function __construct() {

		add_action( 'admin_menu', [ $this, 'sarl_add_settings_page' ] );
		add_action( 'admin_init', [ $this, 'sarl_add_settings_section' ] );

	}


	public function sarl_add_settings_page() {

		add_menu_page(
			__( 'Social Media Connections', SocialLoginAndRegister_DOMAIN ),
			__( 'Social Media Settings', SocialLoginAndRegister_DOMAIN ),
			'administrator',
			'SLAR_settings_page',
			[ $this, 'sarl_settings_page_content' ],
			'dashicons-share-alt'
		);

	}


	public function sarl_settings_page_content() {

		?>
        <div class="wrap">
            <h2><?php _e( 'Social media API Credentials', SocialLoginAndRegister_DOMAIN ) ?></h2>
            <!-- Make a call to the WordPress function for rendering errors when settings are saved. -->
			<?php settings_errors(); ?>
            <!-- Create the form that will be used to render our options -->
            <form method="post" action="options.php">
				<?php settings_fields( 'SLAR_general_settings' ); ?>
				<?php do_settings_sections( 'SLAR_settings_page' ); ?>
				<?php submit_button(); ?>
            </form>
        </div>
		<?php

	}

	public function sarl_add_settings_section() {


		// If the theme options don't exist, create them.
		if ( false == get_option( 'SLAR_general_settings' ) ) {
			add_option( 'SLAR_general_settings' );
		} // end if


		add_settings_section(
			'SLAR_general_settings_section',
			__( 'LinkedIn API Credentials', SocialLoginAndRegister_DOMAIN ),
			[ $this, 'sarl_settings_section_content' ],
			'SLAR_settings_page'
		);


		add_settings_field(
			'linkedin_api_client_id',
			__( 'Client ID', SocialLoginAndRegister_DOMAIN ),
			[
				$this,
				'sarl_client_id_input',
			],
			'SLAR_settings_page',
			'SLAR_general_settings_section',
			[
				'type' => 'password',
				'name' => 'linkedin_client_id',
			]
		);

		add_settings_field(
			'linkedin_api_client_secret',
			__( 'Client Secret', SocialLoginAndRegister_DOMAIN ),
			[
				$this,
				'sarl_client_id_input',
			],
			'SLAR_settings_page',
			'SLAR_general_settings_section',
			[
				'type' => 'password',
				'name' => 'linkedin_client_secret',
			]
		);


		add_settings_field(
			'linkedin_api_redirect_url',
			__( 'Redirecturl', SocialLoginAndRegister_DOMAIN ),
			[
				$this,
				'sarl_client_id_input',
			],
			'SLAR_settings_page',
			'SLAR_general_settings_section',
			[
				'type'        => 'text',
				'name'        => 'linkedin_redirect_url',
				'placeholder' => 'linkedinoauth',
			]
		);

		add_settings_field(
			'linkedin_auto_inject',
			__( 'Add to Login form', SocialLoginAndRegister_DOMAIN ),
			[
				$this,
				'sarl_client_id_checkbox',
			],
			'SLAR_settings_page',
			'SLAR_general_settings_section',
			[
				'type'  => 'checkbox',
				'name'  => 'linkedin_auto_inject',
				'label' => __( 'Place LinkedIn button at the end of Login forms.', 'sarl' ),
			]
		);


		register_setting(
			'SLAR_general_settings',
			'SLAR_general_settings'
		);
	}

	public function sarl_settings_section_content() {
	}


	public function sarl_client_id_checkbox( $args ) {

		$options = get_option( 'SLAR_general_settings' );
		$value   = isset( $options[ $args['name'] ] ) ? $options[ $args['name'] ] : 0;
		?>
        <input id="<?php echo $args['name'] ?>"
               type="checkbox"
               name="SLAR_general_settings[<?php echo $args['name'] ?>]"
               value="1"
			<?php checked( $value, 1, true ) ?>>
        <label><?php echo $args['label'] ?></label>
		<?php
	}


	public function sarl_client_id_input( $args ) {
		// First, we read the options collection
		$options = get_option( 'SLAR_general_settings' );
		?>
        <input type="<?php echo $args['type'] ?>"
               id="<?php echo $args['name'] ?>"
               name="SLAR_general_settings[<?php echo $args['name'] ?>]"
               value="<?php echo $options[ $args['name'] ] ?? '' ?>"
               class="regular-text"
			<?php echo isset( $args['placeholder'] ) ? 'placeholder="' . $args['placeholder'] . '" ' : '' ?>
        />
		<?php
		if ( isset( $args['label'] ) ) {
			echo $args['label'];
		}
	}
}