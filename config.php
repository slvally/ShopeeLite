<?php
    require 'vendor/autoload.php';
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $db = $client->tubes_basdat_rev;

    $dokumenCollection = $db->dokumen;
    $cartCollection = $db->cart;
    $checktoutCollection = $db->checkout;
    $detail_produkCollection = $db->detail_produk;
    $produkCollection = $db->produk;
    $riwayatCollection = $db->riwayat;
    $tokoCollection = $db->toko;
?>