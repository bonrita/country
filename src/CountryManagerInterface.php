<?php

namespace Drupal\country;

/**
 * @package Drupal\country
 */
interface CountryManagerInterface {

  /**
   * @return \Drupal\country\Entity\Country|NULL
   */
  public function suggestCountry();

  /**
   * @return array
   *   Associative array of language objects each country supports. Keyed by
   *   country code.
   */
  public function getLanguagesPerCountry();

  /**
   * @return array
   *   Array of region data
   */
  public function getRegions();

  /**
   * Returns countries grouped by their region.
   *
   * @return \Drupal\country\Entity\Country[]
   */
  public function getCountriesPerRegion();

  /**
   * Returns a list of countries to be used a options in a select list.
   *
   * @return array
   *   Associative array of counties. Keyed by 2 character country code, with
   *   value of the translated country name.
   */
  public function countryOptionList();

}
