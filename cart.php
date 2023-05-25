<?php

  use Psy\Readline\Hoa\Console;

  session_start();
  require 'config.php';

  $cart = $cartCollection->find([]);
  // delete list
  if(isset($_GET['idtrash'])){
    $objectidTrash = new MongoDB\BSON\ObjectId($_GET['id_trash']);
    $cartCollection->deleteOne(['_id' => $objectidTrash]);
    header("location:cart.php");
  }
  
  //update quantity +
  if(isset($_GET['id_plus'])){
    $objectid = new MongoDB\BSON\ObjectId($_GET['id_plus']);
    $objectCart = $cartCollection->findOne(['_id' => $objectid]);
    
    $hargaproduk = $objectCart->harga_produk;
    $finalQuantity = $objectCart->kuantitas + 1;
    $finalTotalPrice = $hargaproduk * $finalQuantity;

    $cartCollection->updateOne(
      [
        '_id' => $objectid,
      ],
      [
        '$set' => ['kuantitas' => $finalQuantity, 'harga_total' => $finalTotalPrice], 
      ]
    );
    header("location:cart.php");
  }

  //update quantity -
  if(isset($_GET['id_minus'])){
    $objectid = new MongoDB\BSON\ObjectId($_GET['id_minus']);
    $objectCart = $cartCollection->findOne(['_id' => $objectid]);

    $hargaproduk = $objectCart->harga_produk;
    $finalQuantity = $objectCart->kuantitas - 1;
    $finalTotalPrice = $hargaproduk * $finalQuantity;
    
    if ($finalQuantity == 0)
    {
      $cartCollection->deleteOne(['_id' => $objectid]);
    }
    $cartCollection->updateOne(
      [
        '_id' => $objectid,
      ],
      [
        '$set' => ['kuantitas' => $finalQuantity, 'harga_total' => $finalTotalPrice],
      ]
    );
    header("location:cart.php");
  }

  //checked array
  $idchecked = array();
  $arrayitems["items"] = array();
  if(isset($_POST['submit'])){
    if(!empty($_POST['check'])) {    
      foreach($_POST['check'] as $value){  
          //update checked value
          $cartCollection->updateOne(
            [
              '_id' => new MongoDB\BSON\ObjectId($value),
            ],
            [
              '$set' => ['check' => true],
            ]
          );
          //insert data ke checkout collection
          $cartsearch = $cartCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($value)]);
          $arrayitems["items"][] = array("produk" => $cartsearch->produk, "jumlah_produk" => $cartsearch->kuantitas, "toko" => $cartsearch->toko);
      };
      $checktoutCollection->insertOne(['items' => $arrayitems["items"]]);
      header("location:checkout.php");
    }
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
  <nav class="navbar mb-4" id="h_navbar">
    <div class="container d-flex justify-content-start">
        <div class="me-5"><a href="Index.php"><i class="icon bi bi-arrow-left"></i></a></div>
        <div class="" id="logo">
           <img src="/BasDat_Shopee/Assets/LogoShopee.png" alt="" class="d-inline-block align-text-top"> 
        </div>
        <div class="vertical-line mx-3" style="height: 45px; display: block; width: 1px; background-color: white;"></div>
      <div class="fs-5" style="font-weight: 300; color: white; position: relative; top: 2px;">Keranjang Belanja</div>
    </div>
  </nav>
  <!-- Navbar End -->

  <!-- List Cart -->
  <form action="" method="post">
  <?php


  foreach($cart as $item){
    $produk = $produkCollection->findOne(['_id' => $item->produk]);
    $toko = $tokoCollection->findOne(['_id' => $item->toko]);

    $rupiah=number_format($item->harga_total,0,',','.');
    echo 
    "
    <div id='listcart' class='container border mb-3'>
      <input class='form-check-input ms-3'name='check[]' type='checkbox' id='inlineCheckbox1' value='".$item->_id."'>
    <div id='cartimg' style='background-image: url(".$produk->Gambar.");'  class='text-center mx-3 my-2'>
    
    </div>
    <div class='' style='flex: 4;'>
        <div class='h5 mb-4'>".$produk->Nama."</div>
        <div class='fs-6'>".$toko->nama."</div>
    </div>
    <div id='cartharga' class='h6'>Rp ".$rupiah."</div>
    <div class='' style='flex: 2; display: flex; align-items: center; justify-content: center;'>
        <div class=''>
          <a href='cart.php?id_minus=".$item->_id."'><i class='icon2 bi bi-dash-circle'></i></a>
        </div>
        <div class='h5 mx-4' style='position: relative; top: 3px;'>
          ".$item->kuantitas."
        </div>
        <div class=''>
          <a href='cart.php?id_plus=".$item->_id."'>
          <i class='icon2 bi bi-plus-circle'></i>
          </a>
        </div>
    </div>
    <a style='font-size:28px; color:#FB5631;' href='delete.php?idtrash=".$item->_id."' class='me-4'><i class='bi bi-trash-fill'></i></a>
    </div>";
  };
  if(empty($cart)){
    echo "<div class='container'>
    <button type='submit' name='submit' id='ckbutton' style='float: right;background-color: #FB5631; color:white;' class='btn disabled border py-2 px-4' aria-disabled='true'>Checkout</button>
    </div>";
  }else{
    echo "<div class='container'>
    <button type='submit' name='submit' id='ckbutton' style='float: right;background-color: #FB5631;color: white;' class='btn border py-2 px-4'>Checkout</button>
    </div>";
  }

  ?>
</form>
<div class="btn float-right"></div>
<!-- End List -->

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="script.js"></script>
</html>