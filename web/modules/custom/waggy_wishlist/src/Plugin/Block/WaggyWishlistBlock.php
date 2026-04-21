<?php

namespace Drupal\waggy_wishlist\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;

/**
 * Provides the Waggy Wishlist block.
 *
 * @Block(
 *   id = "waggy_wishlist",
 *   admin_label = @Translation("Waggy Wishlist"),
 * )
 */
class WaggyWishlistBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'waggy_wishlist',
      '#wishlist_url' => Url::fromRoute('waggy_wishlist.page')->toString(),
    ];
  }

}
