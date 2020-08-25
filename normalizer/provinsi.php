<?php

require __DIR__."/../bootstrap/init.php";

$pdo = DB::pdo();
$st  = $pdo->query("SELECT kode, nama FROM wilayah_2020 WHERE LENGTH(kode) < 3");

$iQuery = "INSERT INTO provinsi (kode, nama) VALUES ";
$data   = [];
$i      = 0;
while ($r = $st->fetch(PDO::FETCH_ASSOC)) {
  $iQuery .= ($i++ ? "," : "")."(?,?)";
  $data[]  = (int)$r["kode"];
  $data[]  = $r["nama"];
}

$pdo->prepare($iQuery)->execute($data);
