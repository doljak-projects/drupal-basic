<?php

/**
 * Pantheon environment settings.
 *
 * Loaded automatically from settings.php when PANTHEON_ENVIRONMENT is set.
 * Mirrors the role that settings.ddev.php plays for the local DDEV environment.
 */

if (!isset($_ENV['PANTHEON_ENVIRONMENT'])) {
  return;
}

// Database — credentials are injected by Pantheon via environment variables.
$databases['default']['default'] = [
  'database'  => $_ENV['DB_NAME'],
  'username'  => $_ENV['DB_USER'],
  'password'  => $_ENV['DB_PASSWORD'],
  'host'      => $_ENV['DB_HOST'],
  'port'      => $_ENV['DB_PORT'],
  'driver'    => 'mysql',
  'prefix'    => '',
  'collation' => 'utf8mb4_general_ci',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
];

// Hash salt — use Pantheon site UUID for uniqueness across environments.
if (empty($settings['hash_salt'])) {
  $settings['hash_salt'] = $_ENV['DRUPAL_HASH_SALT'] ?? hash('sha256', $_ENV['PANTHEON_SITE_UUID'] ?? 'pantheon-fallback');
}

// Config sync directory — committed to git, outside the files/ directory.
if (empty($settings['config_sync_directory'])) {
  $settings['config_sync_directory'] = '../config/sync';
}

// Trusted host patterns — allow all Pantheon subdomains.
$settings['trusted_host_patterns'] = [
  '^.+\.pantheonsite\.io$',
  '^.+\.pantheon\.io$',
];

// Skip permissions hardening — Pantheon manages file permissions.
$settings['skip_permissions_hardening'] = TRUE;

// Reverse proxy — Pantheon uses load balancers.
$settings['reverse_proxy'] = TRUE;
$settings['reverse_proxy_addresses'] = [$_SERVER['REMOTE_ADDR'] ?? ''];
