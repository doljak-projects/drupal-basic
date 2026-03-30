# Views with Friendly URLs via Taxonomy Slug Argument

> **Agent spec** — this document is written to be executed by an AI agent with no human intervention.
> Pass the four inputs below and follow the steps in order. Each step includes a verification command.

> **Drupal version:** 11.x · PHP 8.3+ required (PHP 8 native Attributes).
> The `#[ViewsArgument]` attribute and the removal of Doctrine docblock annotations are specific to Drupal 11.
> On Drupal 10, replace `#[ViewsArgument(id: 'taxonomy_slug')]` with `@ViewsArgument("taxonomy_slug")` in the docblock and remove the `use Drupal\views\Attribute\ViewsArgument;` line.

---

## Inputs (fill before starting)

```
CONTENT_TYPE   = waggy_product        # e.g. article, product, waggy_product
FIELD_NAME     = field_pet_type       # e.g. field_category, field_tags
VOCABULARY_ID  = pet_type             # e.g. tags, categories, pet_type
BASE_PATH      = shop                 # e.g. shop, blog, products
MODULE         = shop_by_pet_block    # custom module where the plugin will live
VIEW_ID        = shop                 # machine name of the Views page display
VIEW_DISPLAY   = page_1               # display ID inside the View
```

---

## Why Drupal's native options fail

Do not attempt these — they are documented here to explain why the custom approach is necessary.

### `taxonomy_index_tid` + `taxonomy_term_name` validator
The validator finds the term but writes the TID back into `$this->argument->argument` after the query is already prepared with the original string. SQL ends up as `WHERE taxonomy_index.tid = 'dogs'` — no results.

### `entity_target_id` (EntityReferenceArgument)
The default plugin for entity reference fields. Extends `NumericArgument` — no slug conversion.

### Custom plugin with `@ViewsArgument` docblock
Drupal 11 dropped Doctrine annotation discovery for Views plugins. Docblock annotations are silently ignored. Only PHP 8 native Attributes (`#[ViewsArgument(...)]`) are recognized.

### Custom plugin with `#[ViewsArgument]` but without `hook_views_data_alter`
The plugin is discovered by the manager, but Views resolves the handler plugin from the field's `views_data()` definition — **not** from the `plugin_id` stored in the View config. The config value is a UI hint only; it does not affect runtime. Without altering `views_data`, the field always loads its default plugin.

---

## Implementation — step by step

### Step 1 — Install Pathauto

```bash
ddev composer require drupal/pathauto
ddev drush en pathauto token -y
ddev drush cr
```

**Verify:**
```bash
ddev drush pm:list --filter=pathauto --field=status
# Expected: enabled
```

---

### Step 2 — Create the Pathauto pattern

```bash
ddev drush php:eval "
\$pattern = \Drupal\pathauto\Entity\PathautoPattern::create([
  'id'         => '{CONTENT_TYPE}_slug',
  'label'      => '{CONTENT_TYPE} URL pattern',
  'type'       => 'canonical_entities:node',
  'pattern'    => '{BASE_PATH}/[node:{FIELD_NAME}:entity:name]/[node:title]',
  'weight'     => -5,
]);
\$pattern->addSelectionCondition([
  'id'            => 'node_type',
  'bundles'       => ['{CONTENT_TYPE}' => '{CONTENT_TYPE}'],
  'negate'        => FALSE,
  'context_mapping' => ['node' => 'node'],
]);
\$pattern->save();
echo 'Pattern created: ' . \$pattern->id() . PHP_EOL;
"
```

> Replace `{CONTENT_TYPE}`, `{BASE_PATH}`, `{FIELD_NAME}` with the actual input values.

**Verify:**
```bash
ddev drush php:eval "
\$patterns = \Drupal::entityTypeManager()->getStorage('pathauto_pattern')->loadMultiple();
foreach (\$patterns as \$p) { echo \$p->id() . ': ' . \$p->getPattern() . PHP_EOL; }
"
# Expected: a line containing BASE_PATH/[node:FIELD_NAME:entity:name]/[node:title]
```

---

### Step 3 — Bulk generate URL aliases

```bash
ddev drush php:eval "
\$pathauto = \Drupal::service('pathauto.generator');
\$storage  = \Drupal::entityTypeManager()->getStorage('node');
\$nids     = \$storage->getQuery()->condition('type', '{CONTENT_TYPE}')->accessCheck(FALSE)->execute();
foreach (\$nids as \$nid) {
  \$node = \$storage->load(\$nid);
  \$pathauto->updateEntityAlias(\$node, 'bulkupdate');
}
echo count(\$nids) . ' nodes processed' . PHP_EOL;
"
```

**Verify:**
```bash
ddev drush php:eval "
\$storage = \Drupal::entityTypeManager()->getStorage('node');
\$nids    = \$storage->getQuery()->condition('type', '{CONTENT_TYPE}')->accessCheck(FALSE)->execute();
\$nid     = reset(\$nids);
\$alias   = \Drupal::service('path_alias.manager')->getAliasByPath('/node/' . \$nid);
echo 'Sample alias: ' . \$alias . PHP_EOL;
"
# Expected: /BASE_PATH/TERM_NAME/node-title  (not /node/NID)
```

---

### Step 4 — Find the field's views_data table and column

```bash
ddev drush php:eval "
\$data = \Drupal::service('views.views_data')->get('node__{FIELD_NAME}');
echo 'Table: node__{FIELD_NAME}' . PHP_EOL;
echo 'Columns: ' . implode(', ', array_keys(\$data)) . PHP_EOL;
"
# Look for the column ending in _target_id — that is the argument column.
# Format: {FIELD_NAME}_target_id
```

---

### Step 5 — Create the reusable plugin file

Create `web/modules/custom/{MODULE}/src/Plugin/views/argument/TaxonomySlug.php`:

```php
<?php

namespace Drupal\{MODULE}\Plugin\views\argument;

use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Attribute\ViewsArgument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\views\Plugin\views\argument\EntityReferenceArgument;

#[ViewsArgument(
  id: 'taxonomy_slug',
)]
class TaxonomySlug extends EntityReferenceArgument {

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration, $plugin_id, $plugin_definition,
      $container->get('entity.repository'),
      $container->get('entity_type.manager')
    );
  }

  public function defineOptions() {
    $options = parent::defineOptions();
    $options['vid'] = ['default' => ''];
    return $options;
  }

  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $vocabularies = $this->entityTypeManager
      ->getStorage('taxonomy_vocabulary')
      ->loadMultiple();

    $options = ['' => $this->t('- Select -')];
    foreach ($vocabularies as $vid => $vocab) {
      $options[$vid] = $vocab->label();
    }

    $form['vid'] = [
      '#type'          => 'select',
      '#title'         => $this->t('Vocabulary'),
      '#description'   => $this->t('Vocabulary whose term names will be used as URL slugs.'),
      '#options'       => $options,
      '#default_value' => $this->options['vid'],
      '#required'      => TRUE,
      '#weight'        => -10,
    ];
  }

  public function setArgument($arg) {
    if ($arg !== 'all' && !is_numeric($arg)) {
      $tid = $this->slugToTid($arg);
      if ($tid) {
        $arg = $tid;
      }
    }
    return parent::setArgument($arg);
  }

  protected function slugToTid(string $slug): ?int {
    $vid = $this->options['vid'] ?? '';
    if (!$vid) {
      return NULL;
    }

    $terms = $this->entityTypeManager
      ->getStorage('taxonomy_term')
      ->loadByProperties(['vid' => $vid]);

    foreach ($terms as $term) {
      if (strtolower(str_replace(' ', '-', $term->label())) === $slug) {
        return (int) $term->id();
      }
    }

    return NULL;
  }
}
```

---

### Step 6 — Register the plugin for the field via `hook_views_data_alter`

Add to `web/modules/custom/{MODULE}/{MODULE}.module`:

```php
function {MODULE}_views_data_alter(array &$data) {
  if (isset($data['node__{FIELD_NAME}']['{FIELD_NAME}_target_id']['argument'])) {
    $data['node__{FIELD_NAME}']['{FIELD_NAME}_target_id']['argument']['id'] = 'taxonomy_slug';
  }
}
```

> This is the critical step. Views resolves the handler plugin from `views_data()` at runtime,
> NOT from the `plugin_id` stored in the View config. Without this hook, the custom plugin
> is never loaded regardless of what is saved in the View configuration.

---

### Step 7 — Clear caches and verify plugin discovery

```bash
ddev drush cr
```

```bash
ddev drush php:eval "
\$plugins = \Drupal::service('plugin.manager.views.argument')->getDefinitions();
echo isset(\$plugins['taxonomy_slug']) ? 'Plugin OK' : 'Plugin NOT FOUND';
echo PHP_EOL;
"
# Expected: Plugin OK
```

---

### Step 8 — Configure the View argument programmatically

This replaces the Views UI step. Finds the argument key name first, then updates the config:

```bash
ddev drush php:eval "
\$view     = \Drupal\views\Views::getView('{VIEW_ID}');
\$displays = \$view->storage->get('display');

// Find the argument key for FIELD_NAME
\$args = \$displays['default']['display_options']['arguments'] ?? [];
echo 'Current argument keys: ' . implode(', ', array_keys(\$args)) . PHP_EOL;
"
```

Then save the plugin_id and vocabulary into the argument config:

```bash
ddev drush php:eval "
\$view     = \Drupal\views\Views::getView('{VIEW_ID}');
\$displays = \$view->storage->get('display');

// Replace ARGUMENT_KEY with the key found in the previous command
\$arg_key = '{FIELD_NAME}_target_id';
\$displays['default']['display_options']['arguments'][\$arg_key]['plugin_id'] = 'taxonomy_slug';
\$displays['default']['display_options']['arguments'][\$arg_key]['vid']       = '{VOCABULARY_ID}';
\$displays['default']['display_options']['arguments'][\$arg_key]['specify_validation'] = FALSE;
\$displays['default']['display_options']['arguments'][\$arg_key]['validate']['type']   = 'none';
\$displays['default']['display_options']['arguments'][\$arg_key]['validate_options']   = [];

// Remove any display-level argument override that may conflict
unset(\$displays['{VIEW_DISPLAY}']['display_options']['arguments']);

\$view->storage->set('display', \$displays);
\$view->storage->save();
echo 'View updated' . PHP_EOL;
" 2>&1 | grep -v warning | grep -v Schema
```

---

### Step 9 — Verify the View returns results for each slug

```bash
ddev drush php:eval "
\$terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')
  ->loadByProperties(['vid' => '{VOCABULARY_ID}']);

foreach (\$terms as \$term) {
  \$slug = strtolower(str_replace(' ', '-', \$term->label()));
  \$view = \Drupal\views\Views::getView('{VIEW_ID}');
  \$view->setArguments([\$slug]);
  \$view->execute('{VIEW_DISPLAY}');
  echo \$slug . ': ' . count(\$view->result) . ' results' . PHP_EOL;
}
"
# Expected: each slug returns > 0 results
```

---

### Step 10 — Update the Twig template URL

In the row template (`views-view-fields--{VIEW_ID}.html.twig`), replace any use of `row.url` with:

```twig
{% set product_url = path('entity.node.canonical', {'node': row._entity.id}) %}
```

> `row.url` is always empty in field-based Views. `path()` with the canonical route resolves
> Pathauto aliases automatically.

**Verify:**
```bash
curl -s "http://YOUR_SITE/{BASE_PATH}/FIRST_TERM_SLUG" | grep 'href="/{BASE_PATH}/' | head -3
# Expected: href="/BASE_PATH/TERM_SLUG/node-title"
```

---

### Step 11 — Export config

```bash
ddev drush cex -y
```

---

## Adaptation guide

| Scenario | What changes |
|----------|-------------|
| `/blog/javascript` filtering posts by tag | `FIELD_NAME` → `field_tags`, `VOCABULARY_ID` → `tags` |
| Multiple slug filters on one View | Add one `hook_views_data_alter` entry per field, both pointing to `taxonomy_slug` |
| Non-taxonomy field (e.g. select list) | Cannot use this plugin — extend `StringArgument` or `NumericArgument` instead, no `slugToTid()` needed |
| Term names with special characters | Extend `slugToTid()` with transliteration: `\Drupal::transliteration()->transliterate($label)` |
| Drupal without DDEV | Replace `ddev drush` with `vendor/bin/drush` or `./drush` |

---

## Concepts applied

### Drupal Plugin System
Drupal 11 discovers plugins via PHP 8 native Attributes (`#[ViewsArgument(...)]`). The older Doctrine docblock annotations (`@ViewsArgument`) are silently ignored. Plugin discovery scans `src/Plugin/` by namespace convention.

**Study:** [Drupal Plugin API](https://www.drupal.org/docs/drupal-apis/plugin-api)

---

### Views Handler Pipeline
`DisplayPluginBase::getHandlers()` → `ViewsHandlerManager::getHandler($item)` → resolves the plugin ID from `views_data()`, not from the saved View config.

The `plugin_id` stored in the View config is a UI hint. At runtime, the field's `views_data` definition wins. `hook_views_data_alter()` is the only way to override the runtime plugin for a field.

**Study:** `web/core/modules/views/src/Plugin/ViewsHandlerManager.php::getHandler()`

---

### DRY — Don't Repeat Yourself
The plugin started hardcoded to `vid: 'pet_type'`. Adding `defineOptions()` + `buildOptionsForm()` lifted the vocabulary choice into configuration, making the same class serve any taxonomy-based slug filter across any project.

**Study:** [Refactoring Guru — Duplicate Code](https://refactoring.guru/smells/duplicate-code)

---

### Separation of Concerns
Three responsibilities, each in the right layer:

| Layer | Responsibility | Tool |
|-------|---------------|------|
| Listing URL | Friendly path for the filtered listing | Views page path `BASE_PATH/%` |
| Argument resolution | Slug → TID at query time | `TaxonomySlug` plugin |
| Item URL | Friendly path for individual nodes | Pathauto |

Mixing these (e.g. a preprocess hook that rewrites both) creates coupling that breaks when one layer changes.

---

### Drupal Hook System — alter pattern
`hook_views_data_alter()` follows Drupal's alter pattern: core defines data structures, modules modify them without patching core. The hook name convention is `MODULE_HOOKNAME_alter`.

**Study:** [Drupal Hook System](https://www.drupal.org/docs/drupal-apis/module-api/hooks)

---

### Dependency Injection in Drupal Plugins
The plugin receives `entity.repository` and `entity_type.manager` via the `create()` factory instead of calling `\Drupal::service()` statically. This follows the Inversion of Control principle: the plugin declares what it needs, the container provides it. Static service calls make code harder to test and couple it to the global container.

**Study:** [Drupal Services and Dependency Injection](https://www.drupal.org/docs/drupal-apis/services-and-dependency-injection)

---

### Pathauto Token System
Pathauto uses Drupal's Token API to build aliases dynamically from entity field values. The chain `[node:field_pet_type:entity:name]` means: from the node → follow the entity reference field → load the referenced term → read its name. Understanding token chaining is key to building non-trivial URL patterns without custom code.

**Study:** [Token module](https://www.drupal.org/project/token) · [Pathauto patterns](https://www.drupal.org/docs/contributed-modules/pathauto)
