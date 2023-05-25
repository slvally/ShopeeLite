
<?php

use Psy\Readline\Hoa\Console;
require 'config.php';
$totalhargaPR = 0;
$totalharga = 0;
$checkout = $checktoutCollection->findOne([]);
if(isset($_POST['checkout'])){
  foreach($checkout->items as $item){
    $produk = $produkCollection->findOne(['_id' => $item['produk']]);
    $totalharga += $produk->Harga * $item->jumlah_produk;
  }
  $totalharga += 10000;
  $riwayatCollection->insertOne([
    'produk' => $checkout->items, 
    'harga_total' => $totalharga,
    'tanggal' => date("Y-m-d"),
    'alamat' => $_POST['pengiriman'],
    'jasa' => $_POST['opsipengiriman'],
    'metode' => $_POST['metode']]);
  $cartCollection->deleteMany(['check' => true]);
  $checktoutCollection->deleteOne(['_id' => $checkout->_id]);
  header("location: index.php");
};
  if(isset($_GET['deletecheck'])){
    $checktoutCollection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($_GET['deletecheck'])]);
    header("location: cart.php");
  }
?>

<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <!-- Icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  
  <!-- CSS -->
  <link rel="stylesheet" href="style.css"/>
  
  <title>Shopee Lite</title>
</head>
<body>
  
  <!-- Navbar -->
  <nav class="navbar mb-4" id="h_navbar">
    <div class="container d-flex justify-content-start">
      <?php
      echo"<div class='me-5'><a href='checkout.php?deletecheck=".$checkout->_id."'><i class='icon bi bi-arrow-left'></i></a></div>";
      ?>
        
        <div class='' id="logo">
           <img src="/BasDat_Shopee/Assets/LogoShopee.png" alt="" class="d-inline-block align-text-top"> 
        </div>
        <div class="vertical-line mx-3" style="height: 45px; display: block; width: 1px; background-color: white;"></div>
      <div class="fs-5" style="font-weight: 300; color: white; position: relative; top: 2px;">Checkout</div>
    </div>
  </nav>
  <!-- Navbar End -->
  
  <!-- List Item -->
  <div class="container border mt-4 p-4" id="c_item">
    <div class="h5">Items</div>
    <?php
    
    // print_r($items);
    foreach($checkout->items as $item){
      $produk = $produkCollection->findOne(['_id' => $item['produk']]);
      $toko = $tokoCollection->findOne(['_id' => $item['toko']]);
      $totalhargaPR += $produk->Harga;
    echo "
      <div class='citems p-2 mb-2 px-3 d-flex justify-content-between' id='citems'>
          <div style='flex:1;' class=''>".$produk->Nama."</div>
          <div style='flex:1;' class='text-center'>".$toko->nama."</div>
          <div style='flex:1;' class='text-right'>".$produk->Harga."</div>
      </div>
      ";
    }
    ?>
    </div>
  </div>
  <!-- End List Item -->

  <!-- Opsi Pesanan -->
  <form action="" method="post">
  <div class="container border mt-3 p-4" id="copsi">
    <div class="h5">Alamat Pengiriman</div>
    <div class="form-outline mb-4">
        <textarea required class="form-control" id="textAreaExample6" rows="2" name="pengiriman"></textarea>
      </div>
    <div class="h5">Opsi Pemngiriman</div>
    <div class="form-inline">
        <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="opsipengiriman">
          <option selected value="JNE - Reguler">JNE - Reguler</option>
          <option value="Sicepat - Reguler">Sicepat - Reguler</option>
          <option value="Kargo">Kargo</option>
        </select>
  </div>
    <div class="h5 mt-4">Metode Pembayaran</div>
    <div class="form-inline">
        <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="metode">
          <option selected value="BCA - Virtual Account">BCA - Virtual Account</option>
          <option value="Gopay">Gopay</option>
          <option value="COD">COD</option>
        </select>
  </div>
  </div>
  <!-- End Opsi Pesanan -->

  <!-- Summary -->
  <div class="container border mt-3 p-4" id="csum">
    <div class="h5">Rincian Pembayaran</div>
    <div class="">
        <div class=" p-2 px-3 d-flex justify-content-between" id="">
            <div class="">Subtotal Produk</div>
            <?php
              echo"<div class=''>Rp ".$totalhargaPR."</div>";
            ?>
        </div>
        <div class=" p-2 px-3 d-flex justify-content-between" id="">
            <div class="">Biaya Layanan</div>
            <div class="">Rp 10.000</div>
        </div>
        <div class=" p-2 px-3 d-flex justify-content-between" id="">
            <div class="">Subtotal Pembayaran</div>
            <?php
              $totalharga = $totalhargaPR + 10000;
              echo"<div class=''> Rp ".$totalharga."</div>"
            ?>
        </div>
    </div>
  </div>
  <div class="container border mb-5 d-flex rounded-0 px-0" id="conf">
    <div class=" d-flex justify-content-between align-items-center mx-4" style="flex: 3;">
        <h5>Total Pembayaran</h5>
        <?php
        echo"<h5>".$totalharga."</h5>";
        ?>
    </div>
    <button class="btn py-3" type="submit" name="checkout" style="flex: 1; background-color:#FB5631; color:white; font-weight:600;">CONFIRM
    </button>
  </div>
  </form>
  <!-- End Summary -->

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="script.js"></script>
</html>