(function (Drupal, once) {

  Drupal.behaviors.headerSearch = {
    attach: function (context, settings) {
      once('headerSearch', '.search-toggle', context).forEach(function (button) {
        const input = button.closest('.search-filter-animated').querySelector('.search-input');

        // Hide input initially
        input.style.width = '0';
        input.style.opacity = '0';
        input.style.overflow = 'hidden';
        input.style.transition = 'width 0.3s ease, opacity 0.3s ease';

        button.addEventListener('click', function () {
          const isOpen = input.style.width !== '0px' && input.style.width !== '0';

          if (isOpen) {
            input.style.width = '0';
            input.style.opacity = '0';
            input.blur();
          } else {
            input.style.width = '200px';
            input.style.opacity = '1';
            input.focus();
          }
        });
      });
    }
  };

})(Drupal, once);
