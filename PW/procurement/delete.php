<?php
include_once "library/inc.seslogin.php";
//ini untuk ngecek, apakah yang akses admin atau petugas
/*if (!$_SESSION['SES_ADMIN'] && !$_SESSION['SES_PETUGAS']){
	echo "<meta http-equiv='refresh' content='0; url=".$baseURL."'>";
	exit;
}*/
//ini digunakan untuk mengambil berdasarkan kode
if (isset($_GET['kode'])){
	$kode = $_GET['kode'];
//perhatikan nama tabel yang digunakan
$mySql = "DELETE FROM po WHERE no_po='$kode'";
$myQry = mysqli_query($koneksidb, $mySql);
$mySql = "DELETE FROM po_item WHERE no_po='$kode'";
$myQry = mysqli_query($koneksidb, $mySql);
//menegmbalikan ke folder berikutnya dan pada file data.php
echo "<meta http-equiv='refresh' content='0; url=".$baseURL."procurement/data'>";
}
else{
	echo "<b> Data yang dihapus tidak ada</b>";
}
?>
