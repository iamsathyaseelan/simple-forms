<?php
/**
 * This is a shortcode template for saving data to custom simple forms table.
 *
 * @category Template
 * @package  Simple-forms
 * @author   Sathyaseelan <iamsathyaseelan@gmail.com>
 * @license  GPL-3.0+ https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://wordpress.com
 */
?>

<form method="post" name="simple_form" action="<?php echo esc_url(rest_url('simple-form/v1/add-new-thing')) ?>">
    <label for="thing_name" class="input-label"><?php _e("Thing's name", "simple-forms"); ?></label>
    <div>
        <input name="name" id="thing_name" placeholder="<?php esc_attr_e("Enter thing's name", "simple-forms"); ?>" class="input-text"/>
        <button type="submit"><?php _e("Save", "simple-forms"); ?></button>
    </div>
    <p class="form-response"></p>
    <input type="hidden" name="_simple_form_nonce" value="<?php echo esc_attr(wp_create_nonce('simple-forms-add-new-thing')); ?>" />
</form>
