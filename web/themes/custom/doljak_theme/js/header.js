(function (Drupal, once) {

  Drupal.behaviors.headerMenu = {
    attach: function (context) {
      once('headerMenu', '#header-menu-toggle', context).forEach(function (toggle) {
        const header = toggle.closest('header[role="banner"]');
        const menu = document.getElementById('block-doljak-theme-mainnavigation');
        const menuBackdrop = document.querySelector('.site-header__menu-backdrop');
        const menuButton = document.querySelector('.site-header__menu-button');

        const syncHeaderMetrics = function () {
          if (!header) {
            return;
          }

          document.documentElement.style.setProperty('--site-header-bottom', `${header.getBoundingClientRect().bottom}px`);
        };

        const closeMenu = function () {
          toggle.checked = false;
          syncMenuState();
        };

        const syncMenuState = function () {
          const isOpen = toggle.checked;

          syncHeaderMetrics();
          document.body.classList.toggle('site-header--menu-open', isOpen);
          document.documentElement.classList.toggle('site-header--menu-open', isOpen);
        };

        toggle.addEventListener('change', syncMenuState);

        document.addEventListener('keydown', function (event) {
          if (event.key === 'Escape' && toggle.checked) {
            closeMenu();
          }
        });

        document.addEventListener('click', function (event) {
          const target = event.target;

          if (!toggle.checked || !(target instanceof Element)) {
            return;
          }

          if (target === toggle) {
            return;
          }

          if ((menu && menu.contains(target)) || (menuButton && menuButton.contains(target))) {
            return;
          }

          closeMenu();
        });

        if (menuBackdrop) {
          menuBackdrop.addEventListener('click', function (event) {
            event.preventDefault();
            closeMenu();
          });
        }

        window.addEventListener('resize', function () {
          syncHeaderMetrics();

          if (window.innerWidth > 1100 && toggle.checked) {
            closeMenu();
          }
        });

        window.addEventListener('scroll', syncHeaderMetrics, { passive: true });

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
