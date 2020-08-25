<?php

namespace GoogleMapsScraper;

use GoogleMapsScraper;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 * @version 0.0.1
 * @package \GoogleMapsScraper
 */
class Provinsi extends GoogleMapsScraper
{
  /**
   * @param string $query
   * @return ?array
   */
  public function getLatLong(string $query): ?array
  {
    $o = $this->curl("https://www.google.com/maps/place/".urlencode($query));


    // ["0x2e7a1c951240608b:0x4027a76e352edc0","Karangmalang, Sragen, Jawa Tengah, Indonesia",null,[null,null,-7.4431005,111.0220207]

    if (preg_match(
      "/\[\"0x[0-9a-f]+?:0x[0-9a-f]+?\",\"{$query}\",.{10,50}([\-0-9\.]+?),([\-0-9\.]+?)\]/",
      $o["out"],
      $m
    )) {
      return [(double)$m[1], (double)$m[2]];
    }

    return null;
  }
}
