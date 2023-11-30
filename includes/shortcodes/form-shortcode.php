<?php
/**
 * File to handle shortcode functionality of the plugin.
 *
 * @category Class
 * @package  Simple-forms
 * @author   Sathyaseelan <iamsathyaseelan@gmail.com>
 * @license  GPL-3.0+ https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://wordpress.com
 */

namespace SimpleForms\Shortcodes;

/**
 * Class FormShortcode
 *
 * Handles shortcode functionality for form submissions and listings.
 *
 * @category Class
 * @package  Simple-forms
 * @author   Sathyaseelan <iamsathyaseelan@gmail.com>
 * @license  GPL-3.0+ https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://wordpress.com
 */
class FormShortcode
{
    /**
     * Initialize the shortcodes.
     *
     * @return void
     */
    public function initialize()
    {
        add_shortcode('my_form', array( $this, 'renderFormShortcode' ));
        add_shortcode('my_list', array( $this, 'renderListShortcode' ));
    }

    /**
     * Render the 'my_form' shortcode.
     * Shortcode parameters: None.
     *
     * @return string
     */
    public function renderFormShortcode()
    {
        return $this->_loadTemplate('form-template');
    }

    /**
     * Load the shortcode template, allowing for template override.
     *
     * @param string $templateName The name of the template.
     *
     * @return string
     */
    private function _loadTemplate( $templateName )
    {
        // Check if a custom template exists in the theme directory
        $template = locate_template("simple-forms/{$templateName}.php");

        ob_start();

        if ($template ) {
            // Use the custom template
            include $template;
        } else {
            // Use the default template from the plugin directory
            include plugin_dir_path(SIMPLE_FORMS_PLUGIN_FILE) . "templates/{$templateName}.php";
        }

        return ob_get_clean();
    }

    /**
     * Render the 'my_list' shortcode.
     * Shortcode parameters: None.
     *
     * @return string
     */
    public function renderListShortcode()
    {
        return $this->_loadTemplate('list-template');
    }

}
