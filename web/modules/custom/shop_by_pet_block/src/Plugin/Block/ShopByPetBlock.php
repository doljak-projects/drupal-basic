<?php

namespace Drupal\shop_by_pet_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * @Block(
 *   id = "shop_by_pet_block",
 *   admin_label = @Translation("Shop by pet menu item"),
 * )
 */
class ShopByPetBlock extends BlockBase {

  public function build() {
    return [
      '#theme' => 'shop_by_pet_block',
    ];
  }

}
