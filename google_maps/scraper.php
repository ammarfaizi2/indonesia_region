<?php

require __DIR__."/../bootstrap/init.php";

use GoogleMapsScraper\Provinsi;


define("COOKIE_PATH", "/tmp");

scrapeProvinsi();

function scrapeProvinsi()
{
  $pdo = DB::pdo();
  $st  = $pdo->prepare("SELECT id, nama FROM provinsi WHERE lat_long IS NULL");
  $st->execute();

  $pid        = getmypid();
  $cookieFile = COOKIE_PATH."/provinsi_{$pid}.txt";
  $scraper    = new Provinsi($cookieFile);

  $st2 = $pdo->prepare("UPDATE provinsi SET lat_long = ? WHERE id = ?");
  while ($r = $st->fetch(PDO::FETCH_ASSOC)) {
    echo "Scraping ".$r["nama"].", Indonesia"."...";
    if ($latLong = $scraper->getLatLong($r["nama"].", Indonesia")) {
      echo " ".($json = json_encode($latLong))."\n";
      $st2->execute([$json, $r["id"]]);
    } else {
      echo " null\n";
    }
  }

  @unlink($cookieFile);
}
