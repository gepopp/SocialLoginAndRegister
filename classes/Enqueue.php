<?php


namespace SocialLoginAndRegisterClasses;


class Enqueue {


	public function __construct() {

		add_action( 'wp_enqueue_scripts', [ $this, 'SLAR_enqueue_styles' ] );

	}


	public function SLAR_enqueue_styles(): void {
		wp_enqueue_style( 'slar_style',  SocialLoginAndRegister_URL . 'dist/main.css' );
	}

}