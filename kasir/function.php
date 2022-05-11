<?php 

session_start();


//koneksi
$c =mysqli_connect('localhost','root','','kasir');
if(isset($_POST['login'])){
	//initiate variable
	$username = $_POST['username'];
	$password = $_POST['password'];

	$check = mysqli_query($c,"SELECT * FROM user where username='$username' and password='$password' ");
	$hitung = mysqli_num_rows($check);

	if($hitung>0){
		//jika datanya ditemukan
		//berhasil login
		$_SESSION['login'] = 'True';
		header('location:index.php');
	} else {
		echo '
		<script>alert("Username atau password salah");
		window.location.href="login.php"
		</script>
		';
	}
}	

if(isset($_POST['tambahbarang'])){
	$namaproduk = $_POST['namaproduk'];
	$deskripsi = $_POST['deskripsi'];
	$stock = $_POST['stock'];
	$harga = $_POST['harga'];

	$insert = mysqli_query($c,"INSERT INTO produk (namaproduk,deskripsi,harga,stock) values ('$namaproduk','$deskripsi','$harga','$stock')");

	if($insert){
		header('location:stock.php');
	} else {
		echo '
		<script>alert("gagal memasukkan data");
		window.location.href="stock.php"
		</script>
		';
	}

}

if(isset($_POST['tambahpelanggan'])){
	$namapelanggan = $_POST['namapelanggan'];
	$notlp = $_POST['notlp'];
	$alamat = $_POST['alamat'];
	

	$insert = mysqli_query($c,"INSERT INTO pelanggan (namapelanggan,notlp,alamat) values ('$namapelanggan','$notlp','$alamat')");

	if($insert){
		header('location:pelanggan.php');
	} else {
		echo '
		<script>alert("gagal memasukkan data");
		window.location.href="pelanggan.php"
		</script>
		';
	}

}

if(isset($_POST['tambahpesanan'])){
	$idpelanggan = $_POST['idpelanggan'];

	

	$insert = mysqli_query($c,"INSERT INTO pesanan (idpelanggan) values ('$idpelanggan')");

	if($insert){
		header('location:index.php');
	} else {
		echo '
		<script>alert("gagal memasukkan pesanan");
		window.location.href="index.php"
		</script>
		';
	}

}

if(isset($_POST['addproduk'])){
	$idproduk = $_POST['idproduk'];
	$idp = $_POST['idp'];
	$qty = $_POST['qty'];

	$hitung1 = mysqli_query($c,"SELECT * FROM produk where idproduk= '$idproduk'");
	$hitung2 = mysqli_fetch_array($hitung1);
	$stocksekarang = $hitung2 ['stock'];

	if($stocksekarang>=$qty){

		//kurangi stock
		$selisih = $stocksekarang-$qty;

		//stock cukup
	$insert = mysqli_query($c,"INSERT INTO detailpesanan (idpesanan,idproduk,qty) values ('$idp','$idproduk','$qty')");
	$update = mysqli_query($c,"UPDATE produk set stock='$selisih' where idproduk='$idproduk'");

	if($insert&&$update){
		header('location:view.php?idp='.$idp);
	} else {
		echo '
		<script>alert("Gagal Menambah Pesanan Baru");
		window.location.href="view.php?idp='.$idp.'"
		</script>
		';
	}
	} else {
		//stok ga cukup
		echo '
		<script>alert("Stok Barang Tidak Mencukupi");
		window.location.href="view.php?idp='.$idp.'"
		</script>
		';
	}

}

if(isset($_POST['barangmasuk'])){
	$idproduk = $_POST['idproduk'];
	$qty = $_POST['qty'];

	$hitung3 = mysqli_query($c,"SELECT * FROM produk where idproduk= '$idproduk'");
	$hitung4 = mysqli_fetch_array($hitung3);
	$tambahproduk = $hitung4 ['stock'];

	$selisih2 = $qty+$tambahproduk;

	$insertb = mysqli_query($c,"INSERT INTO masuk (idproduk,qty) values ('$idproduk','$qty')");
	$update = mysqli_query($c,"UPDATE produk set stock='$selisih2' where idproduk='$idproduk'");
	 

	if($insertb&&$update){
		header('location:masuk.php');

		echo '
		<script>alert("Barang Berhasil Ditambah");
		window.location.href="masuk.php"
		</script>
		';

	} else {
		echo '
		<script>alert("Stok Barang Tidak Mencukupi");
		window.location.href="masuk.php"
		</script>
		';
	}

	}

//hapus produk pesanan
if(isset($_POST['hapusprodukpesanan'])){
	$idp = $_POST['idp']; //iddetailpesnan
	$idpr = $_POST['idpr']; //idproduk
	$idorder = $_POST['idorder'];

	//cek qty
	$cek1 = mysqli_query($c,"SELECT * from detailpesanan where iddetailpesnan='$idp'");
	$cek2 = mysqli_fetch_array($cek1);
	$qtysekarang = $cek2['qty'];
	//cek stock sekarang
	$cek3 = mysqli_query($c,"SELECT * from produk where idproduk='$idpr'");
	$cek4 = mysqli_fetch_array($cek3);
	$stocksekarang = $cek4['stock'];

	$hitung = $stocksekarang+$qtysekarang;

	$hapus = mysqli_query($c,"DELETE from detailpesanan where idproduk='$idpr' and iddetailpesnan='$idp'");
	$update = mysqli_query($c,"UPDATE produk set stock ='$hitung' where idproduk='$idpr'");
	
	
	if($update&&$hapus){
		header('location:view.php?idp='.$idorder);
	} else {
		echo '
		<script>alert("Gagal Menghapus Barang");
		window.location.href="view.php?idp='.$idorder.'"
		</script>
		';
	}


}
 //edit stock
if(isset($_POST['editbarang'])){
	$np = $_POST['namaproduk'];
	$desc = $_POST['deskripsi'];
	$harga = $_POST['harga'];
	$idp = $_POST['idp']; //idproduk


	$query = mysqli_query($c,"UPDATE produk set namaproduk='$np', deskripsi='$desc', harga= '$harga' where idproduk='$idp'");

	if($query){
		header('location:stock.php');
	} else {

		echo '
		<script>alert("Barang gagal di edit");
		window.location.href="stock.php"
		</script>
		';
	}

}

//hapus stock
if(isset($_POST['hapusbarang'])){
	$idp = $_POST['idp'];

	$query = mysqli_query($c,"DELETE from produk where idproduk='$idp'");

	if($query){
		header('location:stock.php');
	} else {
		echo '
		<script>alert("Barang gagal di Hapus");
		window.location.href="stock.php"
		</script>
		';
	}
}
//edit pelanggan
if(isset($_POST['editpelanggan'])) {
	$namapelanggan =$_POST['namapelanggan'];
	$notlp =$_POST['notlp'];
	$alamat =$_POST['alamat'];
	$idpl =$_POST['idpl'];


	$query = mysqli_query($c,"UPDATE pelanggan set namapelanggan='$namapelanggan', notlp= '$notlp', alamat= '$alamat' where idpelanggan ='$idpl'");

	if($query){
		header('location:pelanggan.php');
	} else {

		echo '
		<script>alert("Barang gagal di edit");
		window.location.href="pelanggan.php"
		</script>
		';
	}	
}
//hapus pelanggan
if(isset($_POST['hapuspelanggan'])) {
	$idpl = $_POST['idpl'];

	$query = mysqli_query($c, "DELETE from pelanggan where idpelanggan ='$idpl'");

	if($query){
		header('location:pelanggan.php');
	} else {

		echo '
		<script>alert("Barang gagal di Hapus");
		window.location.href="pelanggan.php"
		</script>
		';
	}	

}

//edit barang masuk
if(isset($_POST['editbarangmasuk'])) {
	$idmasuk = $_POST['idmasuk'];
	$qty = $_POST['qty'];
	$idproduk = $_POST['idproduk'];

	//cek quantiti
	$cekkuantiti = mysqli_query($c,"SELECT * from masuk where idmasuk= '$idmasuk'");
	$cekkuantiti2 =mysqli_fetch_array($cekkuantiti);
	$quantitisekarang= $cekkuantiti2['qty'];

	//stock sekarang
	$caristock = mysqli_query($c,"SELECT * from produk where idproduk = '$idproduk'");
	$caristock2 = mysqli_fetch_array($caristock);
	$stocksekarang=$caristock2 ['stock'];


	if($qty>=$quantitisekarang){
		//hitung selisih
		$selisih = $qty-$quantitisekarang;
		$newstock = $stocksekarang+$selisih;

		$query1 = mysqli_query($c,"UPDATE masuk set qty= '$qty' where idmasuk='$idmasuk'");
		$query2 = mysqli_query($c,"UPDATE produk set stock= '$newstock' where idproduk='$idproduk'");

		if($query1&&$query2){
		header('location:masuk.php');
	} else {

		echo '
		<script>alert("Barang gagal di Update");
		window.location.href="masuk.php"
		</script>
		';
	}	
	} else {
		$selisih = $quantitisekarang-$qty;
		$newstock = $stocksekarang-$selisih;

		$query1 = mysqli_query($c,"UPDATE masuk set qty= '$qty' where idmasuk='$idmasuk'");
		$query2 = mysqli_query($c,"UPDATE produk set stock= '$newstock' where idproduk='$idproduk'");


	if($query1&&$query2){
		header('location:masuk.php');
	} else {

		echo '
		<script>alert("Barang gagal di Update");
		window.location.href="masuk.php"
		</script>
		';
	}

}
	
}

//hapus data barang masuk
if(isset($_POST['hapusbarangmasuk'])) {
	$idmasuk = $_POST['idmasuk'];
	$idproduk = $_POST['idproduk'];

	//cek quantiti
	$cekkuantiti = mysqli_query($c,"SELECT * from masuk where idmasuk= '$idmasuk'");
	$cekkuantiti2 =mysqli_fetch_array($cekkuantiti);
	$quantitisekarang= $cekkuantiti2['qty'];

	//stock sekarang
	$caristock = mysqli_query($c,"SELECT * from produk where idproduk = '$idproduk'");
	$caristock2 = mysqli_fetch_array($caristock);
	$stocksekarang=$caristock2 ['stock'];

	$newstock = $stocksekarang-$quantitisekarang;

	$query1 = mysqli_query($c,"DELETE from masuk  where idmasuk='$idmasuk'");
	$query2 = mysqli_query($c,"UPDATE produk set stock ='$newstock' where idproduk= '$idproduk'");

	if($query1&&$query2){
		header('location:masuk.php');
	} else {

		echo '
		<script>alert("Barang gagal di Update");
		window.location.href="masuk.php"
		</script>
		';
	}

}

 ?>
