<?php

namespace Drupal\acephalous_rest\Normalizer;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\TypedData\TypedDataInternalPropertiesHelper;
use Drupal\serialization\Normalizer\ContentEntityNormalizer;

/**
 * Normalizes/denormalizes Drupal content entities into an array structure.
 */
class AcephalousNormalizer extends ContentEntityNormalizer {

  /**
   * {@inheritdoc}
   */
  protected $supportedInterfaceOrClass = ContentEntityInterface::class;

  /**
   * {@inheritdoc}
   */
  public function normalize($entity, $format = NULL, array $context = []) {
    $context += [
      'account' => NULL,
    ];

    $attributes = [];
    /** @var \Drupal\Core\Entity\Entity $entity */
    foreach (TypedDataInternalPropertiesHelper::getNonInternalProperties($entity->getTypedData()) as $name => $field_items) {
      if ($field_items->access('view', $context['account'])) {
        if ($field_items->getFieldDefinition()->getType() === 'entity_reference' && $field_items->getFieldDefinition()->getName() !== 'type') {
          $attributes[$name] = $this->loadEntityReferences($field_items->referencedEntities(), $format, $context);
        }
        else {
          $attributes[$name] = $this->serializer->normalize($field_items, $format, $context);
        }
      }
    }
    $attributes['acephalous_normalizer'] = ['acephalous_normalizer'];
    return $attributes;
  }

  /**
   * Entity references are recursively loaded into the entity itself to reduce API calls.
   *
   * @param array $entities
   *   Array of entities to normalize.
   * @param string|null $format
   *   Format: json, hal, xml.
   * @param array $context
   *   Array of context variables.
   * @return array
   */
  private function loadEntityReferences($entities, $format = NULL, $context = []) {
    $attributes = [];
    foreach ($entities as $key => $entity) {
      foreach (TypedDataInternalPropertiesHelper::getNonInternalProperties($entity->getTypedData()) as $name => $field_items) {
        if ($field_items->getFieldDefinition()->getType() === 'entity_reference') {
          $attributes[$key][$name] = $this->loadEntityReferences($field_items->referencedEntities(), $format, $context);
        }
        else {
          $attributes[$key][$name] = $this->serializer->normalize($field_items, $format, $context);
        }
      }
    }
    return $attributes;
  }

}
