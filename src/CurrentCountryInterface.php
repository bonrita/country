<?php

namespace Drupal\country;

/**
 * Interface CurrentCountryInterface.
 *
 * @package Drupal\country
 */
interface CurrentCountryInterface {

  /**
   * Get country code of the current country.
   *
   * @return string
   */
  public function getSlug();
}
