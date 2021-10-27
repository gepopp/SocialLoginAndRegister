<?php


namespace SocialLoginAndRegisterClasses\LinkedIn;


use SocialLoginAndRegisterClasses\SarlSession;

class SarlShare {

	protected $options;

	public function __construct() {

		$this->options = get_option('SLAR_general_settings');

		add_filter('the_content', [$this, 'sarl_add_share_buttons']);
	}


	public function sarl_add_share_buttons($content){

		$placement = $this->options['linkedin_share_content_button'];

		if(! (int) $placement == 0) return $content;

		$before = '';
		$after = '';

		if($placement == 'before_content' || $placement == 'before_after_content'){
			ob_start();
			?>
			<div class="flex justify-between">
                <a id="sarl_loginbutton" href="#" class="cursor-pointer block w-full text-center text-white bg-linkedin py-3 focus:outline-none">
					<?php _e( 'Share on LinkedIn', SocialLoginAndRegister_DOMAIN ) ?>
                </a>
			</div>
			<?php
			$before = ob_get_clean();
		}

		if($placement == 'after_content' || $placement == 'before_after_content'){
			ob_start();
			?>
			<div class="flex justify-between">
                <a id="sarl_loginbutton" href="#" class="cursor-pointer block w-full text-center text-white bg-linkedin py-3 focus:outline-none">
					<?php _e( 'Share on LinkedIn', SocialLoginAndRegister_DOMAIN ) ?>
                </a>
			</div>
			<?php
			$after = ob_get_clean();
		}


		return $before . $content . $after;

	}

}