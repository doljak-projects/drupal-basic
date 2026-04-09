<?php

namespace Drupal\waggy_wishlist\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller for the Waggy Wishlist page.
 */
final class WishlistPageController extends ControllerBase {

  /**
   * Renders the wishlist page.
   */
  public function build(): array {
    $theme_path = \Drupal::service('extension.list.theme')->getPath('doljak_theme');
    $base_path = rtrim(base_path(), '/');
    $asset_base = ($base_path ? $base_path : '') . '/' . trim($theme_path, '/') . '/assets/journal/';

    return [
      '#theme' => 'waggy_wishlist_page',
      '#asset_base' => $asset_base,
    ];
  }

}
