<?php

require __DIR__."/../bootstrap/init.php";

$pdo = DB::pdo();
$st  = $pdo->query("SELECT id, kode FROM provinsi");

$hashProvinsi = [];
while ($r = $st->fetch(PDO::FETCH_ASSOC)) {
  $hashProvinsi[$r["kode"]] = (int)$r["id"];
}

$st  = $pdo->query("SELECT kode, nama FROM wilayah_2020 WHERE LENGTH(kode) > 3 AND LENGTH(kode) < 6");
$iQuery = "INSERT INTO kabupaten (id_provinsi, kode, nama) VALUES ";
$data   = [];
$i      = 0;
while ($r = $st->fetch(PDO::FETCH_ASSOC)) {
  $iQuery .= ($i++ ? "," : "")."(?,?,?)";
  $data[]  = $hashProvinsi[(int)substr($r["kode"], 0, 2)];
  $data[]  = (int)$r["kode"];
  $data[]  = $r["nama"];
}

$pdo->prepare($iQuery)->execute($data);
