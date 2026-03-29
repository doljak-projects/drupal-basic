<?php

namespace Drupal\shop_by_pet_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * @Block(
 *   id = "shop_by_pet_block",
 *   admin_label = @Translation("Shop by pet menu item"),
 * )
 */
class ShopByPetBlock extends BlockBase {

  public function build() {
    $base_url = \Drupal::request()->getSchemeAndHttpHost();

    $url = $base_url . '/jsonapi/taxonomy_term/pet_type'
      . '?include=field_product_link_category_butt,field_product_link_category_butt.field_media_image'
      . '&sort=weight';

    try {
      $body = json_decode(
        \Drupal::httpClient()->get($url, ['headers' => ['Accept' => 'application/vnd.api+json']])
          ->getBody()->getContents(),
        TRUE
      );
    }
    catch (\Exception $e) {
      return ['#markup' => ''];
    }

    $included = [];
    foreach ($body['included'] ?? [] as $item) {
      $included[$item['type']][$item['id']] = $item;
    }

    $categories = [];
    foreach ($body['data'] ?? [] as $term) {
      $categories[] = [
        'label' => $term['attributes']['name'],
        'image' => $this->resolveTermImage($term, $included, $base_url),
      ];
    }

    return [
      '#theme'      => 'shop_by_pet_block',
      '#categories' => $categories,
      '#attached'   => ['library' => ['shop_by_pet_block/shop-by-pet']],
      '#cache'      => ['tags' => ['taxonomy_term_list:pet_type']],
    ];
  }

  private function resolveTermImage(array $term, array $included, string $base_url): string {
    $media_rel = $term['relationships']['field_product_link_category_butt']['data'] ?? NULL;
    if (!$media_rel) {
      return '';
    }

    $refs = isset($media_rel[0]) ? $media_rel : [$media_rel];

    // Se tiver mais de uma mídia, usa a que não tem "thumb" no nome.
    $chosen = $refs[0];
    if (count($refs) > 1) {
      foreach ($refs as $ref) {
        $media = $included['media--image'][$ref['id']] ?? NULL;
        if ($media && stripos($media['attributes']['name'], 'thumb') === FALSE) {
          $chosen = $ref;
          break;
        }
      }
    }

    $media = $included['media--image'][$chosen['id']] ?? NULL;
    if (!$media) {
      return '';
    }

    $file_ref = $media['relationships']['field_media_image']['data'] ?? NULL;
    $file     = $included['file--file'][$file_ref['id']] ?? NULL;
    $uri      = $file['attributes']['uri']['url'] ?? '';

    return $uri ? $base_url . $uri : '';
  }

}
