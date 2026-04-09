<?php

namespace Drupal\shop_by_pet_block\Plugin\views\argument;

use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Attribute\ViewsArgument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\views\Plugin\views\argument\EntityReferenceArgument;

/**
 * Views argument that accepts a taxonomy term slug (e.g. "dogs", "small-pets")
 * and converts it to a TID before the query runs.
 *
 * The vocabulary is configurable via the Views UI, making this plugin
 * reusable across any taxonomy-based entity reference filter.
 */
#[ViewsArgument(
    id: 'taxonomy_slug',
)]
class PetTypeSlug extends EntityReferenceArgument
{
  /**
   * {@inheritdoc}
   */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('entity.repository'),
            $container->get('entity_type.manager')
        );
    }

  /**
   * {@inheritdoc}
   */
    public function defineOptions()
    {
        $options = parent::defineOptions();
        $options['vid'] = ['default' => ''];
        return $options;
    }

  /**
   * {@inheritdoc}
   */
    public function buildOptionsForm(&$form, FormStateInterface $form_state)
    {
        parent::buildOptionsForm($form, $form_state);

        $vocabularies = $this->entityTypeManager
        ->getStorage('taxonomy_vocabulary')
        ->loadMultiple();

        $options = ['' => $this->t('- Select -')];
        foreach ($vocabularies as $vid => $vocab) {
            $options[$vid] = $vocab->label();
        }

        $form['vid'] = [
        '#type' => 'select',
        '#title' => $this->t('Vocabulary'),
        '#description' => $this->t('Select the taxonomy vocabulary whose term names will be used as URL slugs.'),
        '#options' => $options,
        '#default_value' => $this->options['vid'],
        '#required' => true,
        '#weight' => -10,
        ];
    }

  /**
   * Converts a slug (e.g. "small-pets") to a numeric TID before the query.
   */
    public function setArgument($arg)
    {
        if ($arg !== 'all' && !is_numeric($arg)) {
            $tid = $this->slugToTid($arg);
            if ($tid) {
                $arg = $tid;
            }
        }
        return parent::setArgument($arg);
    }

  /**
   * Looks up a TID by matching the term label slug against the configured vocabulary.
   */
    protected function slugToTid(string $slug): ?int
    {
        $vid = $this->options['vid'] ?? '';
        if (!$vid) {
            return null;
        }

        $terms = $this->entityTypeManager
        ->getStorage('taxonomy_term')
        ->loadByProperties(['vid' => $vid]);

        foreach ($terms as $term) {
            $term_slug = strtolower(str_replace(' ', '-', $term->label()));
            if ($term_slug === $slug) {
                return (int) $term->id();
            }
        }

        return null;
    }
}
