<?php


namespace SocialLoginAndRegisterClasses;


class SarlEnqueue {


	public function __construct() {

		add_action( 'wp_enqueue_scripts', [ $this, 'sarl_enqueue_styles' ] );
		add_action( 'login_enqueue_scripts', [ $this, 'sarl_enqueue_styles' ] );

	}


	public function sarl_enqueue_styles(): void {
		wp_enqueue_style( 'slar_style',  SocialLoginAndRegister_URL . 'dist/main.css' );
	}

}