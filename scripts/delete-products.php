<?php

$nids = \Drupal::entityQuery('node')
  ->condition('type', 'waggy_product')
  ->accessCheck(FALSE)
  ->execute();

echo 'Nodes encontrados: ' . count($nids) . PHP_EOL;

$media_ids = [];
foreach ($nids as $nid) {
  $node = \Drupal\node\Entity\Node::load($nid);
  if ($node && $node->hasField('field_product_image') && !$node->get('field_product_image')->isEmpty()) {
    $media_ids[] = $node->get('field_product_image')->target_id;
  }
}

\Drupal::entityTypeManager()->getStorage('node')
  ->delete(\Drupal::entityTypeManager()->getStorage('node')->loadMultiple($nids));
echo 'Nodes deletados.' . PHP_EOL;

$deleted = 0;
foreach ($media_ids as $mid) {
  $media = \Drupal::entityTypeManager()->getStorage('media')->load($mid);
  if ($media) {
    $fid = $media->get('field_media_image')->target_id;
    $media->delete();
    if ($fid) {
      $file = \Drupal\file\Entity\File::load($fid);
      if ($file) $file->delete();
    }
    $deleted++;
  }
}
echo "Mídias/arquivos deletados: $deleted" . PHP_EOL;
echo 'Pronto!' . PHP_EOL;
