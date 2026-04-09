<?php

namespace Drupal\block_hero\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\NodeInterface;

/**
 * Provides the Block Hero block.
 *
 * @Block(
 *   id = "block_hero",
 *   admin_label = @Translation("Block hero"),
 * )
 */
class BlockHero extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $nodes = \Drupal::entityTypeManager()
      ->getStorage('node')
      ->loadByProperties([
        'type' => 'hero',
        'status' => NodeInterface::PUBLISHED,
      ]);

    if (empty($nodes)) {
      return [];
    }

    $node = reset($nodes);
    $view_builder = \Drupal::entityTypeManager()->getViewBuilder('node');

    return $view_builder->view($node, 'full');
  }

}
