<?php
add_shortcode( 'slar_login_button', function ( $args ) {

	$url = new \SocialLoginAndRegisterClasses\LinkedIn\LinkedInAuthorizationURL();

	ob_start();
	?>
    <div id="url"></div>


	<?php
	$window = ob_get_clean();

	ob_start();
	?>

    <button id="sarl_loginbutton" class="cursor-pointer block w-full text-center text-white bg-linkedin py-3 focus:outline-none">
		<?php _e( 'Login via LinkedIn', 'slar' ) ?>
    </button>
    <script>
        var iframe = '<iframe src="<?php echo $url->authorziation_url( null, 'login' ) ?>"  width="520" height="570" id="loginframe" frameBorder="0" ></iframe>';
        var loginbutton = document.getElementById('sarl_loginbutton');
        var loginwindow;

        loginbutton.addEventListener("click", (event) => {
            loginwindow = window.open(null, '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');
            loginwindow.document.write(iframe);
            var s = loginwindow.document.createElement("script");
            s.type = "text/javascript";
            s.src = "<?php echo SocialLoginAndRegister_URL . '/dist/loginwindow.js'?>";
            loginwindow.document.head.append(s);

            var id = setInterval(function () {
                var redirect = loginwindow.document.getElementById('redirect_url').dataset.url;
                if (typeof redirect !== "undefined") {
                     clearInterval(id);
                    loginwindow.close();
                    window.location = redirect;
                }
            }, 500);


        })

    </script>

	<?php
	return ob_get_clean();

} );