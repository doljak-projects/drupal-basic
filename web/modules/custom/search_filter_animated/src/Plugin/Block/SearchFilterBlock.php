<?php

namespace Drupal\search_filter_animated\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides the Search Filter Animated block.
 *
 * @Block(
 *   id = "search_filter_animated",
 *   admin_label = @Translation("Search Filter Animated"),
 * )
 */
class SearchFilterBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'search_filter_animated',
    ];
  }

}
