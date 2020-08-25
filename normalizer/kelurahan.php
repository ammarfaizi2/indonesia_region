<?php

require __DIR__."/../bootstrap/init.php";

$pdo = DB::pdo();
$st  = $pdo->query("SELECT c.id, CONCAT(a.kode, '.', b.kode, '.', c.kode) AS kode FROM provinsi AS a INNER JOIN kabupaten AS b ON a.id = b.id_provinsi INNER JOIN kecamatan AS c ON b.id = c.id_kabupaten;");

$hashKecamatan = [];
while ($r = $st->fetch(PDO::FETCH_ASSOC)) {
  $hashKecamatan[$r["kode"]] = (int)$r["id"];
}

$st  = $pdo->query("SELECT kode, nama FROM wilayah_2020 WHERE LENGTH(kode) > 9");
$iQuery = "INSERT INTO kelurahan (id_kecamatan, kode, nama) VALUES ";
$data   = [];
$i      = 0;
while ($r = $st->fetch(PDO::FETCH_ASSOC)) {
  if (isset($hashKecamatan[substr($r["kode"], 0, 8)])) {
    $iQuery .= ($i++ ? "," : "")."(?,?,?)";
    $data[]  = $hashKecamatan[substr($r["kode"], 0, 8)];
    $data[]  = substr($r["kode"], 9);
    $data[]  = $r["nama"];
  }
}

$pdo->prepare($iQuery)->execute($data);
