<?php

namespace Drupal\acephalous_extras\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SiteInfoAPIController.
 */
class SiteInfoAPIController extends ControllerBase {

  /**
   * Drupal\Core\Entity\EntityManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new SiteInfoAPIController object.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Siteinfo.
   *
   * @return string
   *   Return Hello string.
   */
  public function siteInfo() {
    $config = $this->config('system.site');
    $site_info = [
      'name' => $config->get('name'),
      'slogan' => $config->get('slogan'),
      'page' => $config->get('page'),
    ];
    return new JsonResponse($site_info);
  }

}
