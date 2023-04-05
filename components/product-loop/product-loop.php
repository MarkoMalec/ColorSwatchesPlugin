<?php
add_action('woocommerce_after_shop_loop_item_title', 'malec_add_color_choice', 5);
function malec_add_color_choice() {

  global $product;

  if ($product->is_type('variable')) {
    $variations = $product->get_available_variations();
    $displayed_swatch_colors = array();
 ?>
	
    <div class="color_swatches">
      <?php
      foreach ($variations as $variation):

        $attr_data = $variation['attributes'];

		$options = get_option('malec_color_swatches_options');
		$chosen_attribute = $options['attribute'] ?? '';
		$chosen_attribute_key = 'attribute_' . $chosen_attribute;
        
		if (!isset($attr_data[$chosen_attribute_key]) || !$attr_data[$chosen_attribute_key]) {
          continue;
        }

          $color_terms = get_terms(
            $chosen_attribute,
            array(
              'hide_empty' => false,
              'orderby' => 'name',
              'order' => 'ASC'
            )
          );

          foreach ($color_terms as $color_term) {
            $color_id = $color_term->term_id;
            $color_name = trim(strtolower($color_term->name));
            $color_image = $variation['image']['url'];
			$color_swatch = get_term_meta($color_id, 'malec_color', true);
            $color_attr_data = str_replace("-", " ", $variation['attributes']['attribute_pa_kleur']);

            if ($color_name === $color_attr_data && !in_array($color_name, $displayed_swatch_colors)) { 
              $displayed_swatch_colors[] = $color_name;
            ?>
            <div class="swatch_wrap">
              <a style="background-color:<?= $color_swatch; ?>" class="color_swatch" data-image-url="<?php echo $color_image; ?>"
                data-color='<?php echo $color_attr_data; ?>'></a>
            </div>
            <?php }
          } ?>
        <?php 

      endforeach; ?>

    </div>
  <?php
  }
}