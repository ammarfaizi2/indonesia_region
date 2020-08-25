<?php

require __DIR__."/../bootstrap/init.php";

$pdo = DB::pdo();
$st  = $pdo->query("SELECT b.id, CONCAT(a.kode, '.', b.kode) AS kode FROM provinsi AS a INNER JOIN kabupaten AS b ON a.id = b.id_provinsi;");

$hashKabupaten = [];
while ($r = $st->fetch(PDO::FETCH_ASSOC)) {
  $hashKabupaten[$r["kode"]] = (int)$r["id"];
}

$st  = $pdo->query("SELECT kode, nama FROM wilayah_2020 WHERE LENGTH(kode) > 5 AND LENGTH(kode) < 9");
$iQuery = "INSERT INTO kecamatan (id_kabupaten, kode, nama) VALUES ";
$data   = [];
$i      = 0;
while ($r = $st->fetch(PDO::FETCH_ASSOC)) {
  $iQuery .= ($i++ ? "," : "")."(?,?,?)";
  $data[]  = $hashKabupaten[substr($r["kode"], 0, 5)];
  $data[]  = (int)substr($r["kode"], 6);
  $data[]  = $r["nama"];
}

$pdo->prepare($iQuery)->execute($data);
