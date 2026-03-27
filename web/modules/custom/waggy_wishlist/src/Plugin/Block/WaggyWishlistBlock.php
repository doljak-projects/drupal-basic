<?php

namespace Drupal\waggy_wishlist\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * @Block(
 *   id = "waggy_wishlist",
 *   admin_label = @Translation("Waggy Wishlist"),
 * )
 */
class WaggyWishlistBlock extends BlockBase {

  public function build() {
    return [
      '#theme' => 'waggy_wishlist',
    ];
  }

}
