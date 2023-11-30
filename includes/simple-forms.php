<?php
/**
 * File to handle main functionality of the plugin. This is the class responsible for
 * initializing all main features of the plugin.
 *
 * @category Class
 * @package  Simple-forms
 * @author   Sathyaseelan <iamsathyaseelan@gmail.com>
 * @license  GPL-3.0+ https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://wordpress.com
 */

namespace SimpleForms;

use SimpleForms\Api\FormApi;
use SimpleForms\Shortcodes\FormShortcode;

/**
 * Class SimpleForms
 *
 * Handles all plugin functionality.
 *
 * @category Class
 * @package  Simple-forms
 * @author   Sathyaseelan <iamsathyaseelan@gmail.com>
 * @license  GPL-3.0+ https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://wordpress.com
 */
class SimpleForms
{

    /**
     * Initialize plugin features.
     *
     * @return void
     */
    public function initializeFeatures()
    {
        $formShortcode = new FormShortcode();
        $formShortcode->initialize();

        $formApi = new FormApi();
        $formApi->initialize();
    }

    /**
     * Initialize the plugin features.
     *
     * @return void
     */
    public function initialize()
    {
        $this->_includeRequiredFiles();
        $this->_hookActions();
    }

    /**
     * Include necessary files.
     *
     * @return void
     */
    private function _includeRequiredFiles()
    {
        include_once plugin_dir_path(__FILE__) . 'shortcodes/form-shortcode.php';
        include_once plugin_dir_path(__FILE__) . 'api/form-api.php';
    }

    /**
     * Hook into WordPress actions.
     *
     * @return void
     */
    private function _hookActions()
    {
        // Initialize the required features
        add_action('init', [ $this, 'initializeFeatures' ]);

        // Enqueue CSS and JS files
        add_action('wp_enqueue_scripts', [ $this, 'enqueueCustomFiles' ]);

        add_action('plugins_loaded', [ $this,'loadTextDomain']);
    }

    /**
     * Load the plugin's text domain for localization.
     *
     * @return void
     */
    public function loadTextDomain()
    {
        load_plugin_textdomain('your-plugin', false, plugin_basename(dirname(__FILE__)) . '/languages');
    }

    /**
     * Enqueue CSS and JS files.
     *
     * @return void
     */
    public function enqueueCustomFiles()
    {
        // Enqueue CSS file
        wp_enqueue_style('simple-form-styles', plugin_dir_url(SIMPLE_FORMS_PLUGIN_FILE) . 'assets/css/styles.css', [], filemtime(plugin_dir_path(SIMPLE_FORMS_PLUGIN_FILE) . 'assets/css/styles.css'), 'all');

        // Enqueue JS file
        wp_enqueue_script('simple-form-script', plugin_dir_url(SIMPLE_FORMS_PLUGIN_FILE) . 'assets/js/script.js', [ 'jquery' ], filemtime(plugin_dir_path(SIMPLE_FORMS_PLUGIN_FILE) . 'assets/js/script.js'), true);
    }
}
