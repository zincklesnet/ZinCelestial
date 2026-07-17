// ZinCelestial main JS entry

(function ($) {
  'use strict';

  // Example: test AJAX endpoint
  $(document).on('click', '.zc-ajax-test', function (e) {
    e.preventDefault();

    $.post(zcAjax.url, {
      action: 'zc_ajax_example',
      nonce: zcAjax.nonce
    }).done(function (response) {
      console.log('ZinCelestial AJAX:', response);
    });
  });

})(jQuery);
