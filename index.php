<?php
require "config.php";

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
    <div class="container">
        <div class="" id="logo">
           <a href="index.php"><img src="/BasDat_Shopee/Assets/LogoShopee.png" alt="" class="d-inline-block align-text-top"> </a>
        </div>
        <div class=" px-4 d-flex justify-content-center align-items-center" id="search">
            <div class="h5" style="position:relative; top:5px; color: white; ">KELOMPOK 3 C1 BASIS DATA NON RELATIONAL</div>
        </div>
        <div class="" id="menu">
            <a href="cart.php"><i class="icon bi bi-cart2 pe-4"></i></a>
            <a href="history.php"><i class="icon bi bi-clock-history"></i></a>
        </div>
    </div>
  </nav>
  <!-- End Navbar -->
  
  <!-- Slider  -->
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div style="background: url('https://images.pexels.com/photos/683039/pexels-photo-683039.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1') no-repeat center;width: 100%;height: 400px;background-size: cover; " class="carousel-item active">
      
    </div>
    <div style="background: url('https://images.pexels.com/photos/683039/pexels-photo-683039.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1') no-repeat center;width: 100%;height: 400px;background-size: cover; " class="carousel-item">
      
    </div>
    <div style="background: url('https://images.pexels.com/photos/683039/pexels-photo-683039.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1') no-repeat center;width: 100%;height: 400px;background-size: cover; " class="carousel-item">
      
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
  <!-- End Slider -->

  <!-- Kategori -->
  <div class="container border my-4 p-4" id="h_kategori">
    <div class="h4 fs-4">Kategori</div>
    <div class="mt-3" id="listkategori">
      <?php
      $produk = $produkCollection->find([]);
      foreach($produk as $produk){
        echo "
        <a style='text-decoration:none; color:black;' href='index.php?kategori=".$produk->Kategori."'>
        <div class='kategori border'><div class='fs-6'>".$produk->Kategori."</div>
        </div>
        </a>";
      };
      ?>
    </div>
  </div>
  <!-- End Kategori -->
  

  <!-- Produk -->
  <div class="container border p-4 mb-4" id="h_produk">
    <div class="h4 fs-4">Produk</div>
    <div id="listproduk">
        <div class="row m-0">
         <?php
          $produk = $produkCollection->find([]);
         if(isset($_GET['kategori'])){
             $produk = $produkCollection->find(['Kategori' => ($_GET['kategori'])]);
          }

          foreach($produk as $produk){
            $rupiah=number_format($produk->Harga,0,',','.');
            
            echo "
            <div class='col-md-3 col-sm-6 col-xl-2 p-2 m-0'>
            <a style='color:black;' class='text-decoration-none' href='detailProduk.php?id_produk=" . $produk->_id . "'>
            <div class='card' style=''>
            <img class='card-img-top' style'' src='". $produk->Gambar."' alt='Card image cap'>
            <div class='card-body'>
            <h6 class='card-text'>". $produk->Nama ."</h6>
            </div>
            <div class='card-footer'>
            <p class='card-text text-muted'> Rp ".$rupiah."</p>
            </div>
            </div>
            </a>
            </div>
            
            ";
          };

         ?>
        </div>
    </div>
  </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="javascript.js"></script>
</html>