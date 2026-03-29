<?php

/**
 * Script para criar os 30 produtos Waggy com imagens.
 * Executar via: ddev drush php:script scripts/create-products.php
 */

$products = [
  ['name' => 'Premium Dry Food Mix',   'pet' => 'dogs',       'price' => 24.99, 'badge' => 'NEW',  'file' => 'premium-dry-food-mix.jpg'],
  ['name' => 'Comfort Pet Harness',    'pet' => 'dogs',       'price' => 34.99, 'badge' => 'BEST', 'file' => 'comfort-pet-harness.jpg'],
  ['name' => 'Dog Chew Toy Bone',      'pet' => 'dogs',       'price' => 9.99,  'badge' => 'HOT',  'file' => 'dog-chew-toy-bone.jpg'],
  ['name' => 'Waterproof Dog Bed',     'pet' => 'dogs',       'price' => 49.99, 'badge' => 'NEW',  'file' => 'waterproof-dog-bed.jpg'],
  ['name' => 'Retractable Leash Pro',  'pet' => 'dogs',       'price' => 19.99, 'badge' => '',     'file' => 'retractable-leash-pro.jpg'],
  ['name' => 'Flea & Tick Collar',     'pet' => 'dogs',       'price' => 14.99, 'badge' => 'BEST', 'file' => 'flea-tick-collar.jpg'],
  ['name' => 'Interactive Play Set',   'pet' => 'cats',       'price' => 18.99, 'badge' => '-15%', 'file' => 'interactive-play-set.jpg'],
  ['name' => 'Soft Grooming Brush',    'pet' => 'cats',       'price' => 14.99, 'badge' => 'HOT',  'file' => 'soft-grooming-brush.jpg'],
  ['name' => 'Cat Scratching Post',    'pet' => 'cats',       'price' => 29.99, 'badge' => 'NEW',  'file' => 'cat-scratching-post.jpg'],
  ['name' => 'Automatic Cat Feeder',   'pet' => 'cats',       'price' => 39.99, 'badge' => 'BEST', 'file' => 'automatic-cat-feeder.jpg'],
  ['name' => 'Catnip Toy Bundle',      'pet' => 'cats',       'price' => 7.99,  'badge' => '',     'file' => 'catnip-toy-bundle.jpg'],
  ['name' => 'Window Perch Bed',       'pet' => 'cats',       'price' => 24.99, 'badge' => 'HOT',  'file' => 'window-perch-bed.jpg'],
  ['name' => 'Colorful Swing Toy',     'pet' => 'birds',      'price' => 8.99,  'badge' => 'NEW',  'file' => 'colorful-swing-toy.jpg'],
  ['name' => 'Seed & Pellet Mix',      'pet' => 'birds',      'price' => 12.99, 'badge' => 'BEST', 'file' => 'seed-pellet-mix.jpg'],
  ['name' => 'Wooden Bird Perch',      'pet' => 'birds',      'price' => 16.99, 'badge' => '',     'file' => 'wooden-bird-perch.jpg'],
  ['name' => 'Mineral Block Set',      'pet' => 'birds',      'price' => 6.99,  'badge' => 'HOT',  'file' => 'mineral-block-set.jpg'],
  ['name' => 'Travel Bird Cage',       'pet' => 'birds',      'price' => 44.99, 'badge' => 'NEW',  'file' => 'travel-bird-cage.jpg'],
  ['name' => 'Feather Rope Toy',       'pet' => 'birds',      'price' => 9.99,  'badge' => '',     'file' => 'feather-rope-toy.jpg'],
  ['name' => 'Tropical Fish Food',     'pet' => 'fish',       'price' => 11.99, 'badge' => 'BEST', 'file' => 'tropical-fish-food.jpg'],
  ['name' => 'Aquarium Filter Pro',    'pet' => 'fish',       'price' => 27.99, 'badge' => 'NEW',  'file' => 'aquarium-filter-pro.jpg'],
  ['name' => 'LED Tank Light',         'pet' => 'fish',       'price' => 34.99, 'badge' => 'HOT',  'file' => 'led-tank-light.jpg'],
  ['name' => 'Water Conditioner',      'pet' => 'fish',       'price' => 8.99,  'badge' => '',     'file' => 'water-conditioner.jpg'],
  ['name' => 'Decorative Coral Set',   'pet' => 'fish',       'price' => 15.99, 'badge' => 'NEW',  'file' => 'decorative-coral-set.jpg'],
  ['name' => 'Breeding Net',           'pet' => 'fish',       'price' => 6.99,  'badge' => 'BEST', 'file' => 'breeding-net.jpg'],
  ['name' => 'Hamster Wheel Silent',   'pet' => 'small-pets', 'price' => 13.99, 'badge' => 'NEW',  'file' => 'hamster-wheel-silent.jpg'],
  ['name' => 'Cozy Nesting Pad',       'pet' => 'small-pets', 'price' => 9.99,  'badge' => 'HOT',  'file' => 'cozy-nesting-pad.jpg'],
  ['name' => 'Vitamin Drops',          'pet' => 'small-pets', 'price' => 7.99,  'badge' => 'BEST', 'file' => 'vitamin-drops.jpg'],
  ['name' => 'Wooden Hideout House',   'pet' => 'small-pets', 'price' => 18.99, 'badge' => 'NEW',  'file' => 'wooden-hideout-house.jpg'],
  ['name' => 'Hay & Bedding Mix',      'pet' => 'small-pets', 'price' => 11.99, 'badge' => '',     'file' => 'hay-bedding-mix.jpg'],
  ['name' => 'Exercise Ball Large',    'pet' => 'small-pets', 'price' => 8.99,  'badge' => 'HOT',  'file' => 'exercise-ball-large.jpg'],
];

$source_dir = DRUPAL_ROOT . '/../imagens exportadas/produtos/';
$file_system = \Drupal::service('file_system');
$entity_type_manager = \Drupal::entityTypeManager();

foreach ($products as $p) {
  $source = $source_dir . $p['file'];

  if (!file_exists($source)) {
    echo "AVISO: imagem não encontrada — {$p['file']}\n";
    $media_id = NULL;
  } else {
    // Copia a imagem para public://produtos/
    $destination = 'public://produtos/' . $p['file'];
    $dir = 'public://produtos';
    $file_system->prepareDirectory($dir, \Drupal\Core\File\FileSystemInterface::CREATE_DIRECTORY);
    $uri = $file_system->copy($source, $destination, \Drupal\Core\File\FileSystemInterface::EXISTS_REPLACE);

    // Cria entidade File
    $file = \Drupal\file\Entity\File::create([
      'uri'    => $uri,
      'status' => 1,
    ]);
    $file->save();

    // Cria entidade Media
    $media = $entity_type_manager->getStorage('media')->create([
      'bundle'      => 'image',
      'name'        => $p['name'],
      'field_media_image' => [
        'target_id' => $file->id(),
        'alt'       => $p['name'],
      ],
      'status' => 1,
    ]);
    $media->save();
    $media_id = $media->id();
  }

  // Cria o node
  $node = $entity_type_manager->getStorage('node')->create([
    'type'                 => 'waggy_product',
    'title'                => $p['name'],
    'status'               => 1,
    'field_pet_type'       => $p['pet'],
    'field_price'          => $p['price'],
    'field_product_badge'  => $p['badge'],
    'field_product_image'  => $media_id ? ['target_id' => $media_id] : [],
  ]);
  $node->save();

  echo "✓ {$p['name']} [{$p['pet']}]\n";
}

echo "\nPronto! " . count($products) . " produtos criados.\n";
