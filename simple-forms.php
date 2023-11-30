<?php
/**
 * Plugin Name: Simple Forms
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: Creating this plugin for Wpmudev as a part of the interview process.
 * Version: 1.0
 * Author: Sathyaseelan
 * Author URI: https://inperks.org
 * License: GPLv3 or Later
 *
 * @category Class
 * @package  Simple-forms
 * @author   Sathyaseelan <iamsathyaseelan@gmail.com>
 * @license  GPL-3.0+ https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://wordpress.com
 */

define('SIMPLE_FORMS_PLUGIN_FILE', __FILE__);

// Activation and Deactivation Hooks
register_activation_hook(__FILE__, 'Simple_Forms_On_Plugin_activation');
register_deactivation_hook(__FILE__, 'Simple_Forms_On_Plugin_deactivation');

/**
 * On plugin activation, run required actions.
 *
 * @return void
 */
function Simple_Forms_On_Plugin_activation()
{
    include_once plugin_dir_path(__FILE__) . 'includes/plugin-activation.php';
    $plugin_activation_controller = new SimpleForms\PluginActivation();

    // Create or update database tables
    $plugin_activation_controller->createRequiredTables();
}

/**
 * On plugin de-activation, run required actions.
 *
 * @return void
 */
function Simple_Forms_On_Plugin_deactivation()
{
    // Deactivation tasks
}

require_once plugin_dir_path(__FILE__) . 'includes/simple-forms.php';
$app = new SimpleForms\SimpleForms();
$app->initialize();
