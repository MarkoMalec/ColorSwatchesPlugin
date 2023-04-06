jQuery(document).ready(function ($) {
    $('.swatch_wrap').on('click', function () {
      var color_data = $(this).find('.color_swatch').data('color');
      var image_url = $(this).find('.color_swatch').data('image-url');
      $(this).parents('.splide__slide.product').find('img.attachment-woocommerce_thumbnail').attr('src', image_url);
      $(this).parents('.splide__slide.product').find('img.attachment-woocommerce_thumbnail').attr('srcset', image_url);
      $(this).parents('.splide__slide.product').find('source').attr('srcset', image_url);
      $(this).addClass('active').siblings().removeClass('active');
    });
});