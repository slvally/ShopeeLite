
<?php
use Psy\Readline\Hoa\Console;
require 'config.php';
$history = $riwayatCollection->find([]);
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
      <div class="fs-5" style="font-weight: 300; color: white; position: relative; top: 2px;">Riwayat Pembelian</div>
    </div>
  </nav>
  <!-- Navbar End -->


  <!-- List Cart -->
  <div class="container mt-4 mb-4">
    <div id="acordion">
      <?php
      $counter = 1;
      foreach($history as $item){
        $rupiah=number_format($item->harga_total,0,',','.');
        echo "
          <div class='card'>
            <div class='card-header' id='headingOne'>
              <h5 class='m-0'>
                <button class='btn' data-toggle='collapse' data-target='#collapse".$counter."' aria-expanded='true' aria-controls='collapseOne'>
                  Riwayat Pembelian #".$counter."
                </button>
              </h5>
            </div>
            <div id='collapse".$counter."' class='collapse ' aria-labelledby='headingOne' data-parent='#accordion'>
            <div class='d-flex'>
                <div class='card-body mx-4' id='transaksi' style='flex:1;'>
                <table class='table table-borderless'>
                <tbody>
                  <tr>
                    <th scope='row'>Nomor Transaksi</th>
                    <td>$item->_id</td>
                  </tr>
                  <tr>
                    <th scope='row'>Tanggal</th>
                    <td>$item->tanggal</td>
                  </tr>
                  <tr>
                    <th scope='row'>Alamat Pengiriman</th>
                    <td>$item->alamat</td>
                  </tr>
                  <tr>
                    <th scope='row'>Jasa Pengiriman</th>
                    <td>$item->jasa</td>
                  </tr>
                  <tr>
                    <th scope='row'>Metode Pembayaran</th>
                    <td>$item->metode</td>
                  </tr>
                </tbody>
                </table>
                </div>
                <div class='card-body' id='detail' style='flex:1;'>
                <div class='fw-bold'>List Produk</div>
                <table class='mx-3 table table-borderless'>
                <tbody>
                <thead>
                  <tr>
                    <th scope='col'>Nama Produk</th>
                    <th scope='col'>Kuantitas</th>
                    <th scope='col'>Harga Produk</th>
                  </tr>
                </thead>";

                foreach($item->produk as $produk){
                  $produksearch = $produkCollection->findOne(['_id' => $produk->produk]);
                  $rupiahProduk=number_format($produksearch->Harga,0,',','.');
                  echo"
                    <tr>
                      <td>$produksearch->Nama</td>
                      <td>$produk->jumlah_produk</td>
                      <td>Rp $rupiahProduk</td>
                    </tr>
                  ";
                }
                echo "
                </tbody>
                </table>
              </div>    

            </div>
            <div class='card footer p-3 text-end'>
              <h6 class='me-5'>Total Pembayaran : Rp ".$rupiah."</h6>
            </div>
          </div>


        ";
        $counter++;
      }
      ?>

    </div>
  </div>
  <!-- End List -->

  
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="javascript.js"></script>
</html>