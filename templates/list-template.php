<?php
/**
 * This is a shortcode template for listing data from custom simple forms table.
 *
 * @category Template
 * @package  Simple-forms
 * @author   Sathyaseelan <iamsathyaseelan@gmail.com>
 * @license  GPL-3.0+ https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://wordpress.com
 */
?>

<div>
    <form method="post" name="simple_form_list"
          action="<?php echo esc_url(rest_url('simple-form/v1/search-thing')) ?>">
        <div>
            <label><input name="keyword" placeholder="<?php esc_attr_e("Enter the search keyword", "simple-forms"); ?>" class="input-text simple-form-keyword"/></label>
            <button type="submit" class="search-button"><?php _e("Search", "simple-forms"); ?></button>
        </div>
        <input type="hidden" name="_simple_form_nonce"
               value="<?php echo esc_attr(wp_create_nonce('simple-forms-list')); ?>"/>
        <input type="hidden" name="page" value="1"/>
        <div>
            <ol class="simple-form-list"></ol>
        </div>
        <button type="submit" class="load-more-button" style="display: none"><?php _e("Load More", "simple-forms"); ?></button>
    </form>
</div>
