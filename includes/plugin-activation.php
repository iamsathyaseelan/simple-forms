<?php
/**
 * File to handle plugin activation functionality of the plugin.
 *
 * @category Class
 * @package  Simple-forms
 * @author   Sathyaseelan <iamsathyaseelan@gmail.com>
 * @license  GPL-3.0+ https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://wordpress.com
 */

namespace SimpleForms;

/**
 * Class PluginActivation
 *
 * Handles plugin activation functionality.
 *
 * @category Class
 * @package  Simple-forms
 * @author   Sathyaseelan <iamsathyaseelan@gmail.com>
 * @license  GPL-3.0+ https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://wordpress.com
 */
class PluginActivation
{

    /**
     * Create or update required tables during plugin activation.
     *
     * @return void
     */
    public function createRequiredTables()
    {
        global $wpdb;

        $table_name      = $wpdb->prefix . 'sf_things';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        include_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

}
