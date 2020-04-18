<?php if (!defined('OFFDIRECT')) include '../error404.php';?>
<body class="nav-md">
<div class="container body">
<div class="main_container">
		
<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include "menu.php";
include "base_template_topnav.php";
?>
<!--HEADER TITLE-->
<link href="<?php echo $baseURL;?>assets/other/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $baseURL;?>assets/other/datables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
	<div class="right_col" role="main">
	<div class="">
	<div class="page-title">
	<div class="title_left">
		<h3>General<small>Barang</small></h3>
	</div>
	</div>
	<div class="clearfix"></div>
	<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	<div class="x_title">
		<h2>Data Barang<small></small></h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
<!-- BATAS HEADER TITLE-->
<!-- DIGUNAKAN UNTUK PROSES PENCARIAN BERDASARKAN KATEGORI (DISESUAIKAN DENGAN PENCARIAN) -->
<?php
$filterSQL="";
// SETELAH TOMBOL GO DI KLIK AKAN PROSES SCRIPT SEPERTI INI
$Kat 			= isset($_GET['Kat']) ? $_GET['Kat'] : 'semua';//dari URL
$dataKategori 	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $Kat; //dari form
if (trim($dataKategori)=="semua") {
		$filterSQL ="";		
	}
	else {
		$filterSQL="WHERE barang.kd_kategori='$dataKategori' ";
}
?>
<!--BATAS DIGUNAKAN UNTUK PROSES PENCARIAN
	BERDASARKAN KATEGORI (DISESUAIKAN DENGAN PENCARIAN) -->
	
<!-- FORM PENCARIAN BERDASARKAN KATEGORI-->
<form class="form-horizontal form-label-left" action="<?php $_server['PHP_SELF'];?>"method="post" name="form1" target="_self">

<div class="form-group">	
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="aaa">Tanggal</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<div class="controls">
					<div class="input-prepend input-group">
						<span class="add-on input-group-addon">
							<!-- SALAH fa-calender harusnya fa-calendar -->
							 <i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
							 
							<input type="text" name="txtTanggal" id="txtTanggal" class="form-control" value="" />
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="aaa">Nama Suplier</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<select id="aaa" class="form-control" name="cmbSuplier">
				<option value="semua"></option>
				<?php
				
				$dataSql ="SELECT * FROM po ORDER BY no_po";
				$dataQry = mysqli_query($koneksidb, $dataSql);
				while ($dataRow = mysqli_fetch_array($dataQry)) {
					if ($dataRow['no_po']== $dataKategori){
						$cek ="selected";

					} else {$cek="";}
					echo "<option value='$dataRow[no_po]' $cek>$dataRow[nm_supplier]</option>";
				}
				
				?>
				
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="aaa">Nama Kategori</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<select id="aaa" class="form-control" name="cmbKategori">
				<option value="semua"></option>
				<?php
				
				$dataSql ="SELECT * FROM po_item ORDER BY no_po";
				$dataQry = mysqli_query($koneksidb, $dataSql);
				while ($dataRow = mysqli_fetch_array($dataQry)) {
					if ($dataRow['no_po']== $dataKategori){
						$cek ="selected";

					} else {$cek="";}
					echo "<option value='$dataRow[no_po]' $cek>$dataRow[no_po]</option>";
				}
				
				?>
				
			</select>
		</div>
		<input type="submit" class ="btn btn-default" name="btnTampil" value="Tampil"/>
	</div>
</form>
<!-- BATAS FORM PENCARIAN BERDASARKAN KATEGORI -->
<div class="ln_solid"></div>
<!--DATAGRID BERDASARKAN DATA YANG AKAN KITA TAMPILKAN-->
<table id="datatable" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th width="23" align="center"><strong>No</strong></th>
			<th width="51"><strong>No PO</strong></th>
			<th width="417"><strong>Tanggal PO</strong></th>
			<th width="132">Nama Supplier</th>
			<th width="70" align="center"><strong>Divisi Tujuan</strong></th>
			<th width="70" align="center"><strong>Tanggal</strong></th>
			<th width="100" align="center"><a href="<?php echo $baseURL;?>object/add" target"_self">
				<span class="fa fa-plus-circle"></span> Add Data</a></th>
		</tr>
	</thead>
	<?php
	/* PENCARIAN BERDASARKA DATA DI TABEL*/
	$mySql ="SELECT * FROM po $filterSQL ORDER BY timestamp DESC, no_po DESC";
	$myQry = mysqli_query($koneksidb, $mySql);
	$nomor = $hal;
	//PERULANGAN DATA
	while ($myData = mysqli_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData ['no_po'];
		?>
		
	<!--MENAMPILKAN HASIL PENCARIAN DATABASE-->
	<tr>
		<td align="center"><?php echo $nomor;?></td>
		<td><?php echo $myData['no_po']?></td>
		<td><?php echo $myData['tgl_po']?></td>
		<td><?php echo $myData['nm_supplier']?></td>
		<td align="center"><?php echo $myData['divisi_tujuan'];?></td>
		<td align="center"><?php echo $myData['tanggal'];?></td>

		<td align="center">
			<?php if (!$_SESSION['SES_PENGGUNA']):?>
				<a href="<?php echo $baseURL;?>object/edit?kode=<?php echo $Kode; ?>">
					<span class="fa fa-pencil"></span></a>
				<a href="<?php echo $baseURL;?>object/delete?kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('Apakah anda yakin ingin menghapus data <?php echo $Kode; ?>')">
					<span class="fa fa-trash"></span></a>
				</td>
				<?php endif;?>
	</tr>              
<?php }?>
<!--BATAS PERULANGAN DATA-->
</table>
<!--BATAS DATAGRID BERDASARKA DATA YANG AKAN KITA TAMPILKAN-->
</div>
</div>
</div>
</div>
</div>
</div>

<?php include "base_template_footer.php";?>
</div>
</div>
<!--Datatables PEMBENTUKAN TABLE BERDASARKAN DATABASE-->
<script src="<?php echo $baseURL;?>assets/others/datables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $baseURL;?>assets/others/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $baseURL;?>assets/others/dataTables.net-buttons/js/dataTables.bootstrap.buttons.min.js"></script>

<!-- Datatables-->
<script>
	pagename='object/data';
	$(document).ready(function(){
		$('#datatable').dataTables({
			"columnDefs": [
			{"orderable": false, "targets": 3}]
		});
	});
</script>
</body>
</form>
</body>
