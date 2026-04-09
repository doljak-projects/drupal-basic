<?php

namespace Drupal\waggy_cache;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

class WaggyCacheService {

  protected $cacheBackend;
  protected $entityTypeManager;

  public function __construct(CacheBackendInterface $cache_backend, EntityTypeManagerInterface $entity_type_manager) {
    $this->cacheBackend = $cache_backend;
    $this->entityTypeManager = $entity_type_manager;
  }

  public function getRecentProducts() {
    $cid = 'waggy_cache:recent_products';
    $cached = $this->cacheBackend->get($cid);
    $storage = $this->entityTypeManager->getStorage('node');
    if ($cached) {
      return $storage->loadMultiple($cached->data);
    }
    $query = $storage->getQuery()
      ->condition('type', 'waggy_product')
      ->sort('created', 'DESC')
      ->range(0, 5)
      ->accessCheck(FALSE);
    $nids = $query->execute();

    $this->cacheBackend->set($cid, $nids, Cache::PERMANENT, ['waggy_cache:waggy_products']);

    return $storage->loadMultiple($nids);
  }

}