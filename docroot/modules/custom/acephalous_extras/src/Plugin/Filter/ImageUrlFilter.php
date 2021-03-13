<?php

namespace Drupal\acephalous_extras\Plugin\Filter;

use Drupal\Component\Utility\Html;
use Drupal\filter\Plugin\FilterBase;
use Drupal\filter\FilterProcessResult;

/**
 * @Filter(
 *   id = "image_url_filter",
 *   title = @Translation("Absolute Urls"),
 *   description = @Translation("Make sure that public image urls are using absolute paths."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_IRREVERSIBLE,
 *   weight = 999
 * )
 */
class ImageUrlFilter extends FilterBase {

  // @todo A better way to handle inline images.
  public function process($text, $langcode) {
    return new FilterProcessResult(Html::transformRootRelativeUrlsToAbsolute((string) $text, \Drupal::request()->getSchemeAndHttpHost()));
  }
}
