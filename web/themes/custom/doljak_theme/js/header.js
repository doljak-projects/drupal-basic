(function (Drupal, once) {

  Drupal.behaviors.headerMenu = {
    attach: function (context) {
      once('headerMenu', '#header-menu-toggle', context).forEach(function (toggle) {
        const syncMenuState = function () {
          const isOpen = toggle.checked;

          document.body.classList.toggle('site-header--menu-open', isOpen);
          document.documentElement.classList.toggle('site-header--menu-open', isOpen);
        };

        toggle.addEventListener('change', syncMenuState);

        document.addEventListener('keydown', function (event) {
          if (event.key === 'Escape' && toggle.checked) {
            toggle.checked = false;
            syncMenuState();
          }
        });

        window.addEventListener('resize', function () {
          if (window.innerWidth > 1100 && toggle.checked) {
            toggle.checked = false;
            syncMenuState();
          }
        });

        syncMenuState();
      });
    }
  };

  Drupal.behaviors.headerSearch = {
    attach: function (context, settings) {
      once('headerSearch', '.search-toggle', context).forEach(function (button) {
        const container = button.closest('.search-filter-animated');
        const input = container ? container.querySelector('.search-input') : null;

        if (!input) {
          return;
        }

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
