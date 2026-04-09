<?php

namespace Drupal\footer_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Renders the site footer from a footer node using Paragraphs.
 *
 * @Block(
 *   id = "footer_block",
 *   admin_label = @Translation("Footer block"),
 * )
 */
class FooterBlock extends BlockBase implements ContainerFactoryPluginInterface
{
  /**
   * Constructs a FooterBlock instance.
   *
   * @param array $configuration
   *   Plugin configuration.
   * @param string $plugin_id
   *   Plugin ID.
   * @param mixed $plugin_definition
   *   Plugin definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager service.
   */
    public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        protected EntityTypeManagerInterface $entityTypeManager,
    ) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
    }

  /**
   * {@inheritdoc}
   */
    public static function create(
        ContainerInterface $container,
        array $configuration,
        $plugin_id,
        $plugin_definition,
    ): static {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('entity_type.manager'),
        );
    }

  /**
   * {@inheritdoc}
   */
    public function build(): array
    {
        $nodes = $this->entityTypeManager
        ->getStorage('node')
        ->loadByProperties([
        'type' => 'footer',
        'status' => NodeInterface::PUBLISHED,
        ]);

        if (empty($nodes)) {
            return [];
        }

        $node = reset($nodes);

        return $this->entityTypeManager
        ->getViewBuilder('node')
        ->view($node, 'full');
    }
}
