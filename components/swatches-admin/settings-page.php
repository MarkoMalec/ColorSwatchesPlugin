<?php

function malec_color_swatches_settings() {
    add_options_page(
        'Color Swatches Settings',
        'Color Swatches',
        'manage_options',
        'malec-color-swatches',
        'malec_color_swatches_settings_page'
    );
}
add_action('admin_menu', 'malec_color_swatches_settings');

function malec_color_swatches_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('malec_color_swatches');
            do_settings_sections('malec_color_swatches');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function malec_color_swatches_settings_init() {
    register_setting('malec_color_swatches', 'malec_color_swatches_options');

    add_settings_section(
        'malec_color_swatches_section',
        'Choose Product Attribute for Color Swatches',
        'malec_color_swatches_section_callback',
        'malec_color_swatches'
    );

    add_settings_field(
        'malec_color_swatches_attribute',
        'Attribute',
        'malec_color_swatches_attribute_callback',
        'malec_color_swatches',
        'malec_color_swatches_section'
    );
}
add_action('admin_init', 'malec_color_swatches_settings_init');

// content of the settings page
function malec_color_swatches_section_callback() { ?>
    <h4>Choose the attribute you want to use for color swatches.</h4>
	<p>After you select a desired Attribute, check that attribute's page and its variations and modify the color there.</p>
<?php }

// callback function for setting page (select menu for choosing attribute you want to apply swatches to)
function malec_color_swatches_attribute_callback() {
    $options = get_option('malec_color_swatches_options');
    $attribute = $options['attribute'] ?? '';

	$attributes = wc_get_attribute_taxonomies();
    ?>
	<select name="malec_color_swatches_options[attribute]">
        <?php foreach ($attributes as $attr): ?>
            <option value="<?php echo esc_attr('pa_' . $attr->attribute_name); ?>" <?php selected($attribute, 'pa_' . $attr->attribute_name); ?>>
                <?php echo esc_html($attr->attribute_label); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php
}