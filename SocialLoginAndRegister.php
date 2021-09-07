<?php
/**
 * Plugin Name:       Social Login and Register
 * Plugin URI:        https://poppgerhard.at
 * Description:       Login Via LinkedIn, Google and Facebook.
 * Version:           0.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Popp Gerhard
 * Author URI:        https://poppgerhard.at
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       social-login-register
 * Domain Path:       /languages
 */
namespace SocialLoginAndRegister;


if( !function_exists('get_plugin_data') ){
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

$plugindata = get_plugin_data(__FILE__);

define('SocialLoginAndRegister_VERSION', $plugindata['Version']);
define('SocialLoginAndRegister_DIR', __DIR__);
define('SocialLoginAndRegister_FILE', __FILE__);
define('SocialLoginAndRegister_URL', get_template_directory_uri());

$loader = require_once( SocialLoginAndRegister_DIR . '/vendor/autoload.php' );
$loader->addPsr4('classes\\', __DIR__ . '/SocialLoginAndRegisterClasses');

\A7\autoload(__DIR__ . '/src');