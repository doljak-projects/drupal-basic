<?php

namespace Drupal\search_filter_animated\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * @Block(
 *   id = "search_filter_animated",
 *   admin_label = @Translation("Search Filter Animated"),
 * )
 */
class SearchFilterBlock extends BlockBase {

  public function build() {
    return [
      '#theme' => 'search_filter_animated',
    ];
  }

}
