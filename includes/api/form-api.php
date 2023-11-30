<?php
/**
 * File to handle rest-api functionality of the plugin. This is the class responsible for
 * initializing rest api for saving and listing data from tables.
 *
 * @category Class
 * @package  Simple-forms
 * @author   Sathyaseelan <iamsathyaseelan@gmail.com>
 * @license  GPL-3.0+ https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://wordpress.com
 */

namespace SimpleForms\Api;

use WP_REST_Response;
use WP_REST_Request;
use WP_Error;

/**
 * Class FormApi
 *
 * Handles REST API functionality for form submissions.
 *
 * @category Class
 * @package  Simple-forms
 * @author   Sathyaseelan <iamsathyaseelan@gmail.com>
 * @license  GPL-3.0+ https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://wordpress.com
 */
class FormApi
{
    /**
     * Initialize the REST API endpoint.
     *
     * @return void
     */
    public function initialize()
    {
        add_action('rest_api_init', array( $this, 'registerRestEndpoint' ));
    }

    /**
     * Register the REST API endpoint.
     *
     * @return void
     */
    public function registerRestEndpoint()
    {
        register_rest_route(
            'simple-form/v1', '/add-new-thing', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'handleAddThingFormSubmission' ),
            'permission_callback' => function () {
                // If user logged in, then allow user to do further action
                if (! empty(get_current_user()) ) {
                    return true;
                }

                // Check nonce validation here
                $nonce = isset($_POST['_simple_form_nonce']) ? sanitize_text_field($_POST['_simple_form_nonce']) : '';

                return wp_verify_nonce($nonce, 'simple-forms-add-new-thing');
            },
            'args'                => array(
                'name' => array(
                    'required'          => true,
                    'sanitize_callback' => 'sanitize_text_field',
                    'validate_callback' => array( $this, 'validateName' ),
                    'description'       => 'The name to be saved in the database.',
            ),
            ),
            )
        );

        register_rest_route(
            'simple-form/v1', '/search-thing', array(
            'methods'             => 'POST',
            'callback'            => array( $this, 'handleSearchThings' ),
            'permission_callback' => function () {
                // If user logged in, then allow user to do further action
                if (! empty(get_current_user()) ) {
                    return true;
                }

                // Check nonce validation here
                $nonce = isset($_POST['_simple_form_nonce']) ? sanitize_text_field($_POST['_simple_form_nonce']) : '';

                return wp_verify_nonce($nonce, 'simple-forms-list');
            },
            'args'                => array(
                'keyword' => array(
                    'required'          => true,
                    'sanitize_callback' => 'sanitize_text_field',
                    'description'       => 'The keyword to search the database.',
            ),
            ),
            )
        );
    }

    /**
     * Callback function to handle form submission.
     *
     * @param WP_REST_Request $request The REST API request.
     *
     * @return WP_REST_Response|WP_Error The REST API response or error.
     */
    public function handleAddThingFormSubmission( WP_REST_Request $request )
    {
        // Extract data from the request
        $name = $request->get_param('name');

        // Save data to the database
        $result = $this->_saveDataToDatabase($name);

        if ($result ) {
            return new WP_REST_Response(array( 'message' => 'Data saved successfully' ), 200);
        } else {
            return new WP_Error('error', 'Failed to save data', array( 'status' => 500 ));
        }
    }

    /**
     * Save data to the database.
     *
     * @param string $name The name to be saved.
     *
     * @return bool Whether the data was saved successfully.
     */
    private function _saveDataToDatabase( $name )
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'sf_things';

        $data = array(
        'name'       => $name,
        'created_at' => current_time('mysql'),
        );

        // Insert data into the database
        return $wpdb->insert($table_name, $data);
    }

    /**
     * Callback function to handle form submission.
     *
     * @param WP_REST_Request $request The REST API request.
     *
     * @return WP_REST_Response|WP_Error The REST API response or error.
     */
    public function handleSearchThings( WP_REST_Request $request )
    {
        // Extract data from the request
        $search = $request->get_param('keyword');
        $page   = intval($request->get_param('page'));

        if (empty($page) ) {
            $page = 1;
        }

        $perPage = 10;
        $offset  = ( $page - 1 ) * $perPage;

        // Query the custom table based on the search term
        global $wpdb;
        $tableName = $wpdb->prefix . 'sf_things';

        $query = "SELECT * FROM $tableName ";

        if (! empty($search) ) {
            $query .= $wpdb->prepare(" WHERE name LIKE %s", '%' . $wpdb->esc_like($search) . '%');
        }

        $query .= $wpdb->prepare(" LIMIT %d, %d", $offset, $perPage);

        $results = $wpdb->get_results($query, ARRAY_A);

        if ($results ) {
            return new WP_REST_Response(
                array(
                'message'   => 'Data saved successfully',
                'data'      => $results,
                'next_page' => $page + 1
                ), 200
            );
        } else {
            return new WP_Error('error', 'Failed to get data', array( 'status' => 500 ));
        }
    }

    /**
     * Validate the 'name' parameter.
     *
     * @param mixed           $value   The parameter value.
     * @param WP_REST_Request $request The REST API request.
     * @param string          $param   The parameter name.
     *
     * @return bool|WP_Error True if the parameter is valid, WP_Error otherwise.
     */
    public function validateName( $value, $request, $param )
    {
        if (empty($value) ) {
            return new WP_Error("rest_invalid_name", "Please enter the name.");
        }

        if (strlen($value) > 150 ) {
            return new WP_Error("rest_invalid_name", "Name should not exceed 150 characters.");
        }

        return true;
    }
}
