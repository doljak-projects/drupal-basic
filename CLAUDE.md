# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Environment

This is a **Drupal 11** project running on **DDEV** (PHP 8.4, MariaDB 11.8, nginx-fpm).

- Local URL: http://drupal-treino-b.ddev.site
- Docroot: `web/`
- All `ddev exec` and `ddev drush` commands must be run from the project root.

## Common Commands

```bash
# Start/stop environment
ddev start
ddev stop

# Drush (always via ddev)
ddev drush cr                  # Clear all caches
ddev drush updb                # Run pending database updates
ddev drush cex                 # Export config to files
ddev drush cim                 # Import config from files
ddev drush en <module>         # Enable a module
ddev drush pmu <module>        # Uninstall a module

# Composer (always via ddev)
ddev composer require drupal/<module>
ddev composer update

# Open tools
ddev mailpit                   # Open Mailpit (email catcher)
ddev xhgui                     # Open XHGui (profiler)
```

## Project Structure

```
web/
  modules/
    contrib/         # Modules installed via Composer
    custom/          # Custom modules (create here)
  themes/
    contrib/         # Themes installed via Composer (gin)
    custom/          # Custom themes (create here)
  sites/
    default/
      settings.php
      settings.ddev.php   # DDEV-generated, do not edit manually
```

## Installed Contrib Modules/Themes

- `drupal/gin` — admin theme (v5)
- `drupal/toolbar_menu` — toolbar menu integration
- `drush/drush` — CLI (v13)

## Custom Module Conventions

- Place custom modules in `web/modules/custom/<module_name>/`
- Required files: `<module>.info.yml`, `<module>.module` (if using hooks), `<module>.routing.yml` (if adding pages)
- Services defined in `<module>.services.yml`
- Templates in `<module>/templates/`, registered via `hook_theme()`

## Custom Theme Conventions

- Place custom themes in `web/themes/custom/<theme_name>/`
- Use `drupal generate:theme` via Drush or copy from StarterKit (`web/core/starterkit_theme`)
- Twig templates go in `<theme>/templates/`
- Preprocess functions go in `<theme>.theme` file
- Regions declared in `<theme>.info.yml` and used in `page.html.twig`

## Config Sync

Config is synced to `web/sites/default/files/sync` (set by DDEV). After any structural changes, run `ddev drush cex` to export and commit the config files.
