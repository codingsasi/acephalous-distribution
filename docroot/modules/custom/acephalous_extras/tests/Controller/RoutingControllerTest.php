<?php

namespace Drupal\acephalous_extras\Tests;

use Drupal\simpletest\WebTestBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Provides automated tests for the acephalous_extras module.
 */
class RoutingControllerTest extends WebTestBase {

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "acephalous_extras RoutingController's controller functionality",
      'description' => 'Test Unit for module acephalous_extras and controller RoutingController.',
      'group' => 'Other',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests acephalous_extras functionality.
   */
  public function testRoutingController() {
    // Check that the basic functions of module acephalous_extras.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
