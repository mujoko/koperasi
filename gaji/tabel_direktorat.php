<?php 
$par_atas='Tabel Direktorat';
include "../gaji/par_atas.php";
$hasil=$result->query_x("SELECT id,kode_organisasi,nama_organisasi FROM $tabel_organisasi ORDER BY kode_organisasi",'');
?>
<script>
	url1="../gaji/tabel_direktorat01.php";
	url2="../gaji/tabel_direktorat02.php?p=1";
	url3="../gaji/tabel_direktorat02.php?p=2";
	url4="../gaji/tabel_direktorat.php";
	uhead='DATA TABEL DIREKTORAT';
</script>
</head>
<body>
<div style="float: right;">
	<button id="tambah">Tambah Direktorat</button>
</div>
<div class='filter-container'>
	<input autocomplete='off' class='filter' name='kode_organisasi' placeholder='Masukan Kode Organisasi' data-col='kode Organisasi'/>
</div>
<div ID="divPageHasil">
<div class='container' style="padding-top: 5px">
	<table class="table-line">
		<thead>
			<tr>
				<th>NO</th>
				<th>KODE DIREKTORAT</th>
				<th>NAMA DIREKTORAT</th>
				<th align="center">MAINTANCE</th>
			</tr>
		</thead>
	<tbody>
	<?php
	$no=1;
	if($result->num($hasil)!=0){
		while($row = $result->row($hasil)){
			echo "<tr>";
			echo "<td>".$no."</td>";
			echo "<td>".$row['kode_organisasi']."</td>";
			echo "<td>".$row['nama_organisasi']."</td>";
			echo "<td align='center'>"; ?>
			<a title='Edit Direktorat' class='standar' onClick='showEdit("<?php echo $row['id'];?>")'><img src='../css/images/edit.png'></a>
			<a title='Hapus Direktorat' class='standar' onClick='showDelete("<?php echo $row['id'];?>")'><img src='../css/images/delete.png'></a>
			<?php
			echo "</td>";
			echo "</tr>";
			$no++;
		}
	}else{
		echo "<tr><td align='center' colspan='5'>Data Direktorat Belum Ada</td></tr>";
	}?>
	</tbody>
	</table>
</div>
</div>
<?php include '../gaji/par_bawah.php';?>
