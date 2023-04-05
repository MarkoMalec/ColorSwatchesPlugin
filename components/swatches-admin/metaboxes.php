<?php
function malec_color_meta_fields($term) {
    wp_nonce_field(basename(__FILE__), 'malec_color_nonce');
    $malec_color = get_term_meta($term->term_id, 'malec_color', true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="malec_color"><?php _e('Color Picker'); ?></label></th>
        <td>
            <input type="text" class="malec-color-picker" name="malec_color" value="<?php echo esc_attr($malec_color); ?>" />
        </td>
    </tr>
    <?php
}
add_action('pa_kleur_edit_form_fields', 'malec_color_meta_fields');
add_action('pa_kleur_add_form_fields', 'malec_color_meta_fields');


function malec_save_color_meta($term_id) {
    if (!isset($_POST['malec_color_nonce']) || !wp_verify_nonce($_POST['malec_color_nonce'], basename(__FILE__))) {
        return;
    }
    $old_color = get_term_meta($term_id, 'malec_color', true);
    $new_color = isset($_POST['malec_color']) ? $_POST['malec_color'] : '';

    if ($new_color && $new_color !== $old_color) {
        update_term_meta($term_id, 'malec_color', $new_color);
    } elseif ('' === $new_color && $old_color) {
        delete_term_meta($term_id, 'malec_color', $old_color);
    }
}
add_action('edited_pa_kleur', 'malec_save_color_meta');
add_action('create_pa_kleur', 'malec_save_color_meta');

function malec_enqueue_color_picker($hook) {
    if ('edit-tags.php' !== $hook && 'term.php' !== $hook) {
        return;
    }
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('malec-color-picker', get_template_directory_uri() . '/js/color-picker.js', array('wp-color-picker'), false, true);
}
add_action('admin_enqueue_scripts', 'malec_enqueue_color_picker');