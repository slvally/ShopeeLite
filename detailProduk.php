<?php
  require "config.php";

  $prd = $_GET['id_produk'];

  $test =  new MongoDB\BSON\ObjectId($_GET['id_produk']);
  $produk = $produkCollection->findOne(['_id' => $test]);
  $toko = $tokoCollection->findOne(['_id' => $produk->toko]);
  $detailproduk = $detail_produkCollection->findOne(['_id' => $produk->detail_produk]);

  if (isset($_POST['submit'])) {
    $insertone = $cartCollection->insertOne([
      'produk' => $produk->_id,
      'toko' => $produk->toko,
      'harga_total' => $produk->Harga,
      'harga_produk' => $produk->Harga,
      'catatan' => 'test aja ini mah',
      'kuantitas' => 1,
      'check' => false,
    ]);
    header("location:index.php");
  }
  
?>
<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- Icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  
  <!-- CSS -->
  <link rel="stylesheet" href="style.css"/>
  
  <title>Shopee Lite</title>
</head>
<body>
  <!-- Navbar --> 
  <nav class="navbar" id="h_navbar">
    <div class="container d-flex justify-content-start">
        <div class="me-5"><a href="index.php"><i class="icon bi bi-arrow-left"></i></a></div>
        <div class="" id="logo">
           <img src="/BasDat_Shopee/Assets/LogoShopee.png" alt="" class="d-inline-block align-text-top"> 
        </div>
        <div class="vertical-line mx-3" style="height: 45px; display: block; width: 1px; background-color: white;"></div>
      <div class="fs-5" style="font-weight: 300; color: white; position: relative; top: 2px;">Detail Produk</div>
    </div>
  </nav>
  <!-- Navbar End -->

  <!-- List Cart -->
  <?php

  $rupiah=number_format($produk->Harga,0,',','.');
  echo 
  "<div class='container border mt-4 py-3' id='detail'>
    <div class='container' id='d_top'>
      <div style='background-image: url(".$produk->Gambar."); background-size: cover; background-position: center;' class='container' id='d_pict'>
      </div>
      <div class='container p-3 ms-2' id='d_info'>
          <div class='h4 mb-4'>".$produk->Nama."</div>
          <div class='h4 mb-4'>Rp ". $rupiah."</div>
          <div class='d-flex'>
              <div class='fs-6 me-5'><p class='text-uppercase'>Rating ".$detailproduk->Rating."</p></div>
              <div class='fs-6 me-5'><p class='text-uppercase'>Komentar ".$detailproduk->Penilaian."</p></div>
              <div class='fs-6'><p class='text-uppercase'>Terjual ".$detailproduk->Terjual."</p></div>
          </div>
          <form method='POST'><button type='submit' name='submit' class='btn mt-5' id='addtocart'>Masukkan Keranjang</button></form>
      </div>
    </div>
  </div>";

  echo
  "<div class='container border mt-3 p-3' id='merchant'>
    <div class='ms-2 d-flex' id='shopname'>
        <div class='rounded-circle border' style='background-image: . $produk->Gambar.'; background-size: contain; background-position: center;' id='shoppict'>

        </div>
        <div class='h5 ms-4 mt-3'>".$toko->nama."</div>
    </div>
    <div class=' d-flex py-3' id='shopdetail'>
        <div class='fs-5' style='text-align: center;'>
            Penilaian <br> ".$toko->penilaian."
        </div>
        <div class='fs-5' style='text-align: center;'>
            Pengikut <br> ".$toko->pengikut."
        </div>
        <div class='fs-5' style='text-align: center;'>
            Jumlah Produk <br> ".$toko->jmlh_prdk."
        </div>
    </div>
  </div>"
  ?>

  <?php
  echo"
  <div class='container border p-5 mb-5 d-flex' id='desc'>
    <div class='' id='spec'>
        <div class='h5'>Spesifikasi</div>
        <div class='p'>$detailproduk->Spesifikasi</div>
    </div>";
    echo"
    <div class='' id='des'>
        <div class='h5'>Deskripsi</div>
        <div class='p'>$detailproduk->Deskripsi</div>
    </div>
  </div>";
  ?>
  <!-- End List -->

</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="javascript.js"></script>
</html>