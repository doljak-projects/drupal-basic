<?php

/**
 * Seeds 12 journal article nodes with images.
 * Run via: ddev drush php:script scripts/create-articles.php
 *
 * Source images: imagens exportadas/journal/<file>
 * Destination:   public://journal/<file>
 *
 * Skips articles whose title already exists to stay idempotent on re-runs.
 */

$articles = [
  [
    'title'        => 'What to watch before changing your pet\'s food',
    'category'     => 'Nutrition',
    'reading_time' => '5 min read',
    'summary'      => 'A practical checklist for food transitions that feel gentler on digestion and keep the feeding routine clear and predictable.',
    'body'         => '<p>Switching your pet\'s food too quickly is one of the most common causes of digestive upset. Even when the new food is better quality, the gut needs time to adjust to new proteins, fiber levels and ingredient ratios.</p><p>A seven-to-ten day transition — mixing increasing proportions of the new food into the old — gives the digestive system a chance to catch up. Watch for loose stools, reduced appetite or unusual thirst as early signals that the pace needs to slow down.</p><p>Beyond digestion, pay attention to energy levels in the first two weeks. Some pets become more active; others need a few days to settle. Both are normal. What matters is that the pattern stabilizes by the end of the second week.</p>',
    'file'         => 'article-food-transition.jpg',
  ],
  [
    'title'        => 'How to build a calmer daily routine for your dog',
    'category'     => 'Routine',
    'reading_time' => '8 min read',
    'summary'      => 'Meal timing, play windows and gentle rest cues can change the mood of the whole house. This piece turns routine into something realistic and repeatable.',
    'body'         => '<p>A calmer routine rarely comes from one dramatic change. It starts with consistent feeding windows, a more intentional play block and a clearer signal that the home is shifting into rest mode.</p><p>Dogs read transitions constantly. When meals, walks and wind-down moments happen at roughly the same time, they spend less energy guessing what comes next and more energy settling into the pattern.</p><p>Start with just one anchor point — the morning feed. Keep it within a thirty-minute window every day for two weeks. Once that feels stable, add an anchor at the other end of the day. Build the routine one reliable moment at a time.</p>',
    'file'         => 'article-routine-dog.jpg',
  ],
  [
    'title'        => 'Evening reset habits for dogs that stay alert too long',
    'category'     => 'Routine',
    'reading_time' => '6 min read',
    'summary'      => 'Small wind-down cues, softer lighting and calmer transitions that help sensitive dogs stop carrying the whole day into bedtime.',
    'body'         => '<p>Some dogs hold tension from the day long after the household has quieted. They pace, stay near the door or keep watch from the couch — not because something is wrong, but because no clear signal told them the day was over.</p><p>The evening reset is that signal. It can be as simple as dimming one lamp, moving to a specific room and shifting from active play to touch or quiet chew time. The consistency matters more than the ritual itself.</p><p>Over a few weeks, these cues compound. The dog begins to recognize the sequence and starts releasing tension before you even sit down. The house becomes a place that stops asking for more at a predictable time.</p>',
    'file'         => 'article-evening-reset.jpg',
  ],
  [
    'title'        => 'Small grooming habits that reduce bath-time stress',
    'category'     => 'Grooming',
    'reading_time' => '4 min read',
    'summary'      => 'Short daily sessions with a brush or comb make full baths feel familiar rather than overwhelming for most dogs.',
    'body'         => '<p>Bath-time anxiety in dogs is rarely about the water. It is usually about the unfamiliarity — the constraint, the sounds, the handling of sensitive areas like paws and ears. Regular short grooming sessions desensitize all of that gradually.</p><p>Three minutes a day with a soft brush, touching paws and ears without doing anything to them, creates a history of low-stakes handling. By the time a bath is needed, the dog has experienced hundreds of calm, uneventful contact moments.</p><p>Keep the sessions short enough that you always stop before the dog wants to leave. End on a neutral or positive note. The goal is a dog that tolerates grooming, not one that performs it.</p>',
    'file'         => 'article-grooming-stress.jpg',
  ],
  [
    'title'        => 'How to turn daily walks into a calming ritual',
    'category'     => 'Wellness',
    'reading_time' => '5 min read',
    'summary'      => 'Pace, route consistency and leash pressure patterns matter more than distance when walks are meant to settle rather than excite.',
    'body'         => '<p>A walk does not automatically calm a dog. At the wrong pace or with too much environmental stimulation, it can wind them up further. The difference lies in how the walk is structured, not how long it is.</p><p>A predictable route removes decision-making pressure from both ends of the leash. When the dog knows where the walk goes, they spend less energy scanning and more energy moving. Pair that with a consistent pace and loose leash pressure and most dogs settle noticeably within five minutes.</p><p>Reserve high-stimulation routes — busy streets, dog parks, markets — for days when you want to engage energy rather than settle it. Keep the calming walk simple and repeatable.</p>',
    'file'         => 'article-walk-anxiety.jpg',
  ],
  [
    'title'        => 'Adjusting care routines for aging dogs',
    'category'     => 'Care',
    'reading_time' => '7 min read',
    'summary'      => 'Older dogs need the same structure as younger ones but with softer edges — shorter walks, warmer beds and more predictable mealtimes.',
    'body'         => '<p>Aging changes what a dog needs from their routine without changing how much they need routine itself. Senior dogs often become more reliant on predictability as their senses and mobility shift.</p><p>The adjustment is mostly about softening the edges. Shorter but more frequent walks preserve movement without overtaxing joints. Elevated food bowls reduce neck strain. A bed with memory foam or extra insulation makes the overnight rest more restorative.</p><p>Pay attention to how long it takes your dog to settle after activity. That recovery window lengthens with age. Building it into the schedule — rather than treating it as an interruption — keeps the routine sustainable for both of you.</p>',
    'file'         => 'article-senior-dog.jpg',
  ],
  [
    'title'        => 'The signs your cat wants more vertical space',
    'category'     => 'Habitat',
    'reading_time' => '4 min read',
    'summary'      => 'Cats that climb furniture, sit on top of appliances or watch from high shelves are telling you something about their habitat needs.',
    'body'         => '<p>Cats are vertical animals. In the wild, height provides safety, visibility and control over their territory. Indoor cats that lack vertical options often compensate by using furniture, refrigerator tops or open shelves — not out of mischief, but out of genuine environmental need.</p><p>The signs are easy to read once you know what you are looking for. A cat that consistently seeks the highest point in a room, that watches activity from above rather than at floor level, or that becomes calmer after access to a high perch is communicating a clear preference.</p><p>A cat tree near a window is the most efficient solution. Floor-to-ceiling modular shelving works well in smaller spaces. The key is a stable, comfortable platform at a height that gives the cat a genuine vantage point over the room.</p>',
    'file'         => 'article-vertical-space.jpg',
  ],
  [
    'title'        => 'Indoor play ideas that keep smart cats engaged',
    'category'     => 'Play',
    'reading_time' => '5 min read',
    'summary'      => 'Cats with high prey drive and quick minds need play that mimics the hunt cycle — stalk, chase, catch, finish — to feel genuinely satisfied.',
    'body'         => '<p>A bored cat is often a destructive or anxious cat. The solution is not more toys but better play structure. A wand toy dragged slowly across the floor, paused, then moved unpredictably replicates the behavior of small prey — and that unpredictability is what engages the cat\'s full attention.</p><p>The hunt cycle matters. Most cats need a play session that includes a clear finish — a moment where they catch and hold the toy. Without it, the arousal from the chase has nowhere to go. End sessions by letting the cat catch the toy and carry it briefly before putting it away.</p><p>Fifteen focused minutes twice a day outperforms an hour of passive exposure to toys left on the floor. Rotate toys weekly to preserve novelty.</p>',
    'file'         => 'article-indoor-play.jpg',
  ],
  [
    'title'        => 'Reading your cat\'s sleep and rest patterns',
    'category'     => 'Wellness',
    'reading_time' => '4 min read',
    'summary'      => 'Cats sleep between twelve and sixteen hours a day. Where and how they sleep reveals a lot about their comfort and stress levels.',
    'body'         => '<p>A cat that sleeps in open, exposed areas is usually a confident, relaxed animal. A cat that consistently sleeps in enclosed, hidden spots — inside boxes, behind furniture, in closets — may be managing stress or simply preferring the security of a contained space. Both are normal, but the pattern is worth noticing.</p><p>Sleep quality matters as much as duration. A cat in deep sleep — rolled on their side, limbs extended, occasionally twitching — is genuinely resting. A cat that sleeps in a tight, guarded position with eyes only partially closed is resting lightly and may be reacting to something in the environment.</p><p>Providing two or three sleep options at different heights and levels of enclosure lets the cat choose the kind of rest they need on a given day.</p>',
    'file'         => 'article-cat-sleep.jpg',
  ],
  [
    'title'        => 'A grooming rhythm cats actually tolerate',
    'category'     => 'Grooming',
    'reading_time' => '5 min read',
    'summary'      => 'Most grooming resistance in cats comes from infrequent, high-intensity sessions. Short daily contact builds tolerance without confrontation.',
    'body'         => '<p>Cats that resist grooming have usually learned to associate it with constraint and discomfort. The remedy is not force but frequency — short, low-stakes contact that never asks for more than the cat is currently willing to give.</p><p>Start with a soft brush and two or three strokes along the back during a moment when the cat is already relaxed — after a meal, during a quiet afternoon nap, when they have chosen to be near you. Stop before they show any sign of wanting to move away.</p><p>Over a few weeks, most cats begin to anticipate and even lean into the brush. Long-haired breeds benefit particularly from daily sessions that prevent matting before it becomes painful to address. The goal is a grooming ritual that is unremarkable — something the cat expects and accepts without drama.</p>',
    'file'         => 'article-cat-grooming.jpg',
  ],
  [
    'title'        => 'Bird toys that encourage curiosity, not chaos',
    'category'     => 'Play',
    'reading_time' => '5 min read',
    'summary'      => 'How to choose stimulation that keeps birds engaged without overwhelming the habitat or the caretaker.',
    'body'         => '<p>Birds are highly intelligent animals with a strong need for environmental enrichment. The challenge is providing stimulation that engages their problem-solving instincts without creating an environment that feels chaotic or overstimulating.</p><p>Foraging toys — those that require the bird to work for a treat — are the most effective form of enrichment. They replicate the searching and extracting behavior that occupies a large portion of a wild bird\'s day. Start with simple designs where the reward is easy to find, then increase complexity as the bird learns.</p><p>Rotate three or four toys on a weekly cycle rather than filling the cage with everything at once. A bird that has seen the same toy every day for a month will ignore it; the same toy reintroduced after a week away becomes interesting again.</p>',
    'file'         => 'article-bird-toys.jpg',
  ],
  [
    'title'        => 'Rethinking your bird\'s habitat for better interaction',
    'category'     => 'Habitat',
    'reading_time' => '6 min read',
    'summary'      => 'Cage placement, perch variety and out-of-cage time shape how confident and social a bird becomes over time.',
    'body'         => '<p>A bird\'s cage placement affects its personality more than most owners realize. A cage against a wall in a quiet corner produces a different bird than one positioned at the edge of a social room where the bird can observe daily life without being overwhelmed by it.</p><p>The ideal position gives the bird a view of the room from a corner or wall — never in the middle of a space where movement comes from all directions. Height matters too. Eye level or slightly above places the bird in a position of security; below eye level can increase anxiety in more sensitive species.</p><p>Perch variety is equally important. Uniform wooden dowels of the same diameter cause foot fatigue and reduce grip strength over time. Natural wood branches, rope perches and platform perches at different heights give the feet constant variation and exercise.</p>',
    'file'         => 'article-bird-habitat.jpg',
  ],
];

$source_dir = DRUPAL_ROOT . '/../imagens exportadas/journal/';
$file_system = \Drupal::service('file_system');
$entity_type_manager = \Drupal::entityTypeManager();
$node_storage = $entity_type_manager->getStorage('node');

// Prepare destination directory.
$dir = 'public://journal';
$file_system->prepareDirectory($dir, \Drupal\Core\File\FileSystemInterface::CREATE_DIRECTORY);

$created = 0;
$skipped = 0;

foreach ($articles as $a) {
  // Skip if a node with this title already exists.
  $existing = $node_storage->loadByProperties(['type' => 'article', 'title' => $a['title']]);
  if (!empty($existing)) {
    echo "SKIP (exists): {$a['title']}\n";
    $skipped++;
    continue;
  }

  // Handle image.
  $file_id = NULL;
  $source = $source_dir . $a['file'];
  if (file_exists($source)) {
    $destination = 'public://journal/' . $a['file'];
    $uri = $file_system->copy($source, $destination, \Drupal\Core\File\FileSystemInterface::EXISTS_REPLACE);
    $file = \Drupal\file\Entity\File::create(['uri' => $uri, 'status' => 1]);
    $file->save();
    $file_id = $file->id();
  }
  else {
    echo "WARN: image not found — {$a['file']}\n";
  }

  // Create node.
  $node = $node_storage->create([
    'type'               => 'article',
    'status'             => 1,
    'title'              => $a['title'],
    'field_category'     => $a['category'],
    'field_reading_time' => $a['reading_time'],
    'body'               => [
      'value'   => $a['body'],
      'summary' => $a['summary'],
      'format'  => 'basic_html',
    ],
    'field_image' => $file_id ? ['target_id' => $file_id] : [],
  ]);
  $node->save();
  echo "✓ [{$node->id()}] {$a['title']}\n";
  $created++;
}

echo "\nPronto! $created criados, $skipped ignorados.\n";
