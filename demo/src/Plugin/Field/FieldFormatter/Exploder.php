<?php

namespace Drupal\demo\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'SpaceExploder' formatter.
 *
 * @FieldFormatter(
 *   id = "Space_Exploder",
 *   label = @Translation("Space Exploder"),
 *   field_types = {
 *    "text",
 *    "string",
 *   }
 * )
 */
class Exploder extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {
      $ModifiedValue = $this->spaceExploder($item->value);
      // Render each element as markup.
      $element[$delta] = ['#markup' => $ModifiedValue];
    }

    return $element;
  }

  /**
   *
   */
  public function spaceExploder($item) {

    return str_replace(' ', '-', $item);

  }

}
