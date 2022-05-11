<?php 
require 'cek_login.php';
$h1 = mysqli_query($c,"SELECT * FROM produk ");
$h2 = mysqli_num_rows($h1); //jumlah pesanan 
 ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Stock Barang</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
         <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Aplikasi Kasir </a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">menu</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Order
                            </a>
                            <a class="nav-link" href="stock.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="pelanggan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Kelola Pelanggan
                            </a>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                       User
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                         <h1 class="mt-4">Stock Barang</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Data Stock</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Jumlah Stock : <?=$h2;?></div>
                                </div>
                            </div>
                        </div>
                          <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-info mb-4"  data-toggle="modal" data-target="#myModal">
                              Tambah Stock barang
                            </button>  
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Barang
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Deskripsi</th>
                                            <th>Stock</th>
                                            <th>Harga </th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $get = mysqli_query($c,"SELECT * fROM produk");
                                        $i = 1;

                                        while ($p=mysqli_fetch_array($get)) {
                                          $namaproduk = $p['namaproduk'];
                                          $deskripsi = $p['deskripsi'];
                                          $harga = $p['harga'];
                                          $stock = $p['stock'];
                                          $idproduk= $p['idproduk'];

                                         ?>


                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$namaproduk;?></td>
                                            <td><?=$deskripsi;?></td>
                                            <td><?=$stock;?></td>
                                            <td>Rp<?=number_format($harga);?></td>
                                            <td align="center">
                                                 <button type="button" class="btn btn-warning mb-4"  data-toggle="modal" data-target="#edit<?=$idproduk;?>">
                                                      edit
                                                    </button> 
                                                     <button type="button" class="btn btn-danger mb-4"  data-toggle="modal" data-target="#hapus<?=$idproduk;?>">
                                                      hapus
                                                    </button> 
                                             </td>
                                        </tr> 


                                            <!-- Modal Edit -->
                                          <div class="modal fade" id="edit<?=$idproduk;?>">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                              
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                  <h4 class="modal-title">Edit Stock</h4>
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <form method="post">
                                                    
                                                    <!-- Modal body -->
                                                        <div class="modal-body">
                                                            <input type="text" name="namaproduk" class="form-control" placeholder="Edit Nama produk" value="<?=$namaproduk;?>">
                                                            <br>
                                                            <input type="text" name="deskripsi" class="form-control" placeholder="Edit Deskripsi" value="<?=$deskripsi;?>">
                                                            <br>
                                                            <input type="number" name="harga" class="form-control" placeholder="Edit harga produk" value="<?=$harga;?>">
                                                            <input type="hidden" name="idp" value="<?=$idproduk;?>">
                                                        </div>
                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                          <button type="submit" class="btn btn-success" name="editbarang">Submit</button>
                                                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        </div>
                                                </form>

                                              </div>
                                            </div>
                                        </div>


                                              <!-- Modal Edit -->
                                          <div class="modal fade" id="hapus<?=$idproduk;?>">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                              
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                  <h4 class="modal-title">Hapus Stock</h4>
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <form method="post">
                                                    
                                                    <!-- Modal body -->
                                                        <div class="modal-body">
                                                            Apakah Anda Yakin Menghapus Barang Ini?
                                                            <input type="hidden" name="idp" value="<?=$idproduk;?>">
                                                        </div>
                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                          <button type="submit" class="btn btn-success" name="hapusbarang">Submit</button>
                                                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                              </div>
                                            </div>
                                        </div>

                                        <?php 
                                         }; //end of while
                                         ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2021</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
    <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Barang Baru</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="post">
            
            <!-- Modal body -->
                <div class="modal-body">
                    <input type="text" name="namaproduk" class="form-control" placeholder="Nama produk">
                    <br>
                    <input type="text" name="deskripsi" class="form-control" placeholder="Deskripsi">
                    <br>
                    <input type="number" name="stock" class="form-control" placeholder="Stock Awal">
                    <br>
                    <input type="number" name="harga" class="form-control" placeholder="harga produk">

                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success" name="tambahbarang">Submit</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</html>
