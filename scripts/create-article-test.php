<?php

/**
 * Cria um artigo de teste baseado no mock do Paper (Waggy — Article).
 * Executar via: ddev exec drush php:script scripts/create-article-test.php
 */

$entity_type_manager = \Drupal::entityTypeManager();

// Buscar uma imagem já existente no sistema (labrador) ou usar NULL.
$image_fid = NULL;
$files = $entity_type_manager->getStorage('file')->loadByProperties([]);
foreach ($files as $file) {
  if (str_contains($file->getFileUri(), 'labrador')) {
    $image_fid = $file->id();
    break;
  }
}

$node = $entity_type_manager->getStorage('node')->create([
  'type'                => 'article',
  'status'              => 1,
  'title'               => 'How to build a calmer daily routine for your dog',
  'body'                => [
    'value'   => '<p>A calmer routine rarely comes from one dramatic change. It starts with consistent feeding windows, a more intentional play block, and a clearer signal that the home is shifting into rest mode.</p>
<p>Dogs read transitions constantly. When meals, walks, and wind-down moments happen at roughly the same time, they spend less energy guessing what comes next and more energy settling into the pattern.</p>
<h2>Small rituals that make the whole day feel easier</h2>
<p>Feed with predictability. Anchor breakfast and dinner to a repeatable window so digestion and energy feel more stable through the week.</p>
<p>Match play to recovery. High-energy toys work better when followed by a clear cool-down cue: fresh water, a familiar bed, softer lighting, and a room that stops asking for more stimulation.</p>
<blockquote>When the evening routine becomes quieter, even sensitive dogs stop treating the house like a place that might surprise them.</blockquote>
<h2>A routine that still works on busy days</h2>
<ol>
<li><strong>Morning cue</strong> — Keep the first five minutes of the day almost identical: open the curtain, refresh water, take a short walk, then feed.</li>
<li><strong>Midday reset</strong> — If the day is crowded, use one reliable enrichment moment instead of several random interruptions.</li>
<li><strong>Evening wind-down</strong> — Dim the room, reduce noise, and move toward touch, grooming, or gentle chew time.</li>
</ol>',
    'summary' => 'A practical guide to meal timing, play windows, rest cues, and the small rituals that help anxious pets settle faster at home.',
    'format'  => 'basic_html',
  ],
  'field_category'     => 'Daily Rhythm',
  'field_reading_time' => '8 min read',
  'field_image'        => $image_fid ? ['target_id' => $image_fid] : [],
  'field_tags'         => [],
]);

$node->save();

echo "✓ Artigo criado: \"{$node->label()}\" [nid: {$node->id()}]\n";
echo "  URL: /node/{$node->id()}\n";
