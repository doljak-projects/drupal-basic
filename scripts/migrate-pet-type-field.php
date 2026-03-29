<?php

/**
 * Migra field_pet_type de list_string para entity_reference (taxonomy pet_type).
 * Executar via: ddev drush php:script scripts/migrate-pet-type-field.php
 */

$entity_type_manager = \Drupal::entityTypeManager();
$node_storage = $entity_type_manager->getStorage('node');

// Mapeamento slug → tid.
$slug_to_tid = [
  'dogs'       => 1,
  'cats'       => 2,
  'birds'      => 3,
  'fish'       => 4,
  'small-pets' => 5,
];

// 1. Salva mapeamento nid → slug atual.
echo "Salvando mapeamento atual...\n";
$nodes = $node_storage->loadByProperties(['type' => 'waggy_product']);
$mapping = [];
foreach ($nodes as $node) {
  $mapping[$node->id()] = $node->get('field_pet_type')->value;
}
echo count($mapping) . " produtos mapeados.\n\n";

// 2. Remove o campo antigo (list_string).
echo "Removendo field_pet_type (list_string)...\n";
$field_config = \Drupal\field\Entity\FieldConfig::loadByName('node', 'waggy_product', 'field_pet_type');
if ($field_config) {
  $field_config->delete();
  echo "FieldConfig removido.\n";
}
$field_storage = \Drupal\field\Entity\FieldStorageConfig::loadByName('node', 'field_pet_type');
if ($field_storage) {
  $field_storage->delete();
  echo "FieldStorageConfig removido.\n";
}

// 3. Cria novo field storage como entity_reference.
echo "\nCriando novo field_pet_type (entity_reference)...\n";
\Drupal\field\Entity\FieldStorageConfig::create([
  'field_name'  => 'field_pet_type',
  'entity_type' => 'node',
  'type'        => 'entity_reference',
  'settings'    => ['target_type' => 'taxonomy_term'],
  'cardinality' => 1,
])->save();

\Drupal\field\Entity\FieldConfig::create([
  'field_name'  => 'field_pet_type',
  'entity_type' => 'node',
  'bundle'      => 'waggy_product',
  'label'       => 'Pet Type',
  'settings'    => [
    'handler'          => 'default:taxonomy_term',
    'handler_settings' => [
      'target_bundles' => ['pet_type' => 'pet_type'],
    ],
  ],
])->save();
echo "Novo campo criado.\n\n";

// 4. Repopula os produtos.
echo "Repopulando produtos...\n";
\Drupal::entityTypeManager()->clearCachedDefinitions();
$node_storage = \Drupal::entityTypeManager()->getStorage('node');

foreach ($mapping as $nid => $slug) {
  $tid = $slug_to_tid[$slug] ?? NULL;
  if (!$tid) {
    echo "AVISO: slug '{$slug}' sem mapeamento (nid {$nid})\n";
    continue;
  }
  $node = $node_storage->load($nid);
  $node->set('field_pet_type', ['target_id' => $tid]);
  $node->save();
  echo "✓ nid {$nid} → {$slug} (tid {$tid})\n";
}

echo "\nPronto!\n";
