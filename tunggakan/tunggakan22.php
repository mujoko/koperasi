<thead>
<tr class="td" bgcolor="#e5e5e5">
	<th rowspan="2">NO</th>
	<th rowspan="2">NOREK</th>
	<th rowspan="2">NAMA</th>
	<th rowspan="2">TGL MULAI</th>
	<th rowspan="2">TGL AKHIR</th>
	<th rowspan="2">JW / SB</th>
	<th rowspan="2">PLAFOND</th>
	<th rowspan="2">OUTSTANDING</th>
	<th colspan="4">TAGIHAN PER BULAN</th>
	<th colspan="4">AKUMULASI TUNGGAKAN TAGIHAN</th>
	<th rowspan="2">JML TUNGGAKAN</th>
	<th rowspan="2">KETERANGAN</th>
</tr>
<tr class="td" bgcolor="#e5e5e5">
	<th>POKOK</th>
	<th>BUNGA</th>
	<th>ADM</th>
	<th>JUMLAH</th>
	<th>POKOK</th>
	<th>BUNGA</th>
	<th>ADM</th>
	<th>JUMLAH</th>
</tr>
</thead>
<tbody><?php
	$no=1;$vbayar="";$vlunas='';
	$jnomi1=0;$jobd1=0;$jpokok1=0;$jbunga1=0;$jadm1=0;$jjumlah1=0;$jnomi2=0;$jobd2=0;$jpokok2=0;$jbunga2=0;$jadm2=0;$jjumlah2=0;
	$gnomi1=0;$gobd1=0;$gpokok1=0;$gbunga1=0;$gadm1=0;$gjumlah1=0;$gnomi2=0;$gobd2=0;$gpokok2=0;$gbunga2=0;$gadm2=0;$gjumlah2=0;
	$tnomi1=0;$tobd1=0;$tpokok1=0;$tbunga1=0;$tadm1=0;$tjumlah1=0;$tnomi2=0;$tobd2=0;$tpokok2=0;$tbunga2=0;$tadm2=0;$tjumlah2=0;
	while ($row=$result->row($hasil)){
		if ($vbayar!=$row['produk']){ 
			if($no>1){  ?>
				<tr class="td" bgcolor="#e5e5e5">
					<td colspan="6" align="center"><strong>JUMLAH <?php echo $vnmbayar; ?></strong></td>
					<td align="right"><?php echo formatrp($jnomi1); ?></td>
					<td align="right"><?php echo formatrp($jobd1); ?></td>
					<td align="right"><?php echo formatrp($jpokok1); ?></td>
					<td align="right"><?php echo formatrp($jbunga1); ?></td>
					<td align="right"><?php echo formatrp($jadm1); ?></td>
					<td align="right"><?php echo formatrp($jjumlah1); ?></td>
					<td align="right"><?php echo formatrp($jpokok2); ?></td>
					<td align="right"><?php echo formatrp($jbunga2); ?></td>
					<td align="right"><?php echo formatrp($jadm2); ?></td>
					<td align="right"><?php echo formatrp($jjumlah2); ?></td>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr class="td" bgcolor="#e5e5e5">
					<td colspan="6" align="center"><strong>GRAND TOTAL</strong></td>
					<td align="right"><?php echo formatrp($gnomi1); ?></td>
					<td align="right"><?php echo formatrp($gobd1); ?></td>
					<td align="right"><?php echo formatrp($gpokok1); ?></td>
					<td align="right"><?php echo formatrp($gbunga1); ?></td>
					<td align="right"><?php echo formatrp($gadm1); ?></td>
					<td align="right"><?php echo formatrp($gjumlah1); ?></td>
					<td align="right"><?php echo formatrp($gpokok2); ?></td>
					<td align="right"><?php echo formatrp($gbunga2); ?></td>
					<td align="right"><?php echo formatrp($gadm2); ?></td>
					<td align="right"><?php echo formatrp($gjumlah2); ?></td>
					<td colspan="2">&nbsp;</td>
				</tr>
				<?php
				$jnomi1=0;$jobd1=0;$jpokok1=0;$jbunga1=0;$jadm1=0;$jjumlah1=0;$jpokok2=0;$jbunga2=0;$jadm2=0;$jjumlah2=0;
				$gnomi1=0;$gobd1=0;$gpokok1=0;$gbunga1=0;$gadm1=0;$gjumlah1=0;$gpokok2=0;$gbunga2=0;$gadm2=0;$gjumlah2=0;
			}?>
			<tr><td colspan="18"><strong><?php echo ' JENIS PRODUK : '.$row['nmproduk']; ?></strong></td></tr><?php $no=1;
		}
		if($no>1){
			if ($vlunas!=$row['kkbayar']){ 
				if ($vbayar==$row['produk']){ ?>
					<tr class="td" bgcolor="#e5e5e5">
						<td colspan="6" align="center"><strong>JUMLAH <?php echo $vnmbayar; ?></strong></td>
						<td align="right"><?php echo formatrp($jnomi1); ?></td>
						<td align="right"><?php echo formatrp($jobd1); ?></td>
						<td align="right"><?php echo formatrp($jpokok1); ?></td>
						<td align="right"><?php echo formatrp($jbunga1); ?></td>
						<td align="right"><?php echo formatrp($jadm1); ?></td>
						<td align="right"><?php echo formatrp($jjumlah1); ?></td>
						<td align="right"><?php echo formatrp($jpokok2); ?></td>
						<td align="right"><?php echo formatrp($jbunga2); ?></td>
						<td align="right"><?php echo formatrp($jadm2); ?></td>
						<td align="right"><?php echo formatrp($jjumlah2); ?></td>
						<td colspan="2">&nbsp;</td>
					</tr>
					<?php
					$jnomi1=0;$jobd1=0;$jpokok1=0;$jbunga1=0;$jadm1=0;$jjumlah1=0;$jpokok2=0;$jbunga2=0;$jadm2=0;$jjumlah2=0;
				}
			}
		}?>
		<tr>
			<td><?php echo $no; ?></td>
			<td>&nbsp;<?php echo $row['norek']; ?></td>
			<td><?php echo $row['nama']; ?></td>
			<td><?php echo date_sql($row['tgtran']); ?></td>
			<td><?php echo date_sql($row['tgl_jatuh_tempo']); ?></td>
			<td><?php echo $row['jangka'].' / '.$row['suku']; ?></td>
			<td align="right"><?php echo formatrp($row['nomi']);?></td>
			<td align="right"><?php echo formatrp($row['saldoa']);?></td>
			<td align="right"><?php echo formatrp($row['pokok']);?></td>
			<td align="right"><?php echo formatrp($row['bunga']);?></td>
			<td align="right"><?php echo formatrp($row['administrasi']);?></td>
			<td align="right"><?php echo formatrp($row['jumlah']);?></td>
			<td align="right"><?php echo formatrp($row['pokoka']);?></td>
			<td align="right"><?php echo formatrp($row['bungaa']);?></td>
			<td align="right"><?php echo formatrp($row['adma']);?></td>
			<td align="right"><?php echo formatrp($row['jumlaha']);?></td>			
			<td align="right"><?php echo formatrp($row['rekening']);?></td>
			<td align="right">
				<?php echo $xkkolek='';$ketkolek=$row['ketkolek'];include '../parameter/alasan_kolek.php';echo $xkkolek; ?>
			</td>
		</tr><?php 
		$jnomi1 +=$row['nomi'];
		$jobd1 +=$row['saldoa'];
		$jpokok1 +=$row['pokok'];
		$jbunga1 +=$row['bunga'];
		$jadm1 +=$row['administrasi'];
		$jjumlah1 +=$row['jumlah'];
		$jpokok2 +=$row['pokoka'];
		$jbunga2 +=$row['bungaa'];
		$jadm2 +=$row['adma'];
		$jjumlah2 +=$row['jumlaha'];

		$gnomi1 +=$row['nomi'];
		$gobd1 +=$row['saldoa'];
		$gpokok1 +=$row['pokok'];
		$gbunga1 +=$row['bunga'];
		$gadm1 +=$row['administrasi'];
		$gjumlah1 +=$row['jumlah'];
		$gpokok2 +=$row['pokoka'];
		$gbunga2 +=$row['bungaa'];
		$gadm2 +=$row['adma'];
		$gjumlah2 +=$row['jumlaha'];
		
		$tnomi1 +=$row['nomi'];
		$tobd1 +=$row['saldoa'];
		$tpokok1 +=$row['pokok'];
		$tbunga1 +=$row['bunga'];
		$tadm1 +=$row['administrasi'];
		$tjumlah1 +=$row['jumlah'];
		$tpokok2 +=$row['pokoka'];
		$tbunga2 +=$row['bungaa'];
		$tadm2 +=$row['adma'];
		$tjumlah2 +=$row['jumlaha'];

		$vbayar=$row['produk'];
		$vlunas=$row['kkbayar'];
		$vnmbayar=$row['nmbayar'];
		$no++;
	}?>
	<tr class="td" bgcolor="#e5e5e5">
		<td colspan="6" align="center"><strong>JUMLAH <?php echo $vnmbayar; ?></strong></td>
		<td align="right"><?php echo formatrp($jnomi1); ?></td>
		<td align="right"><?php echo formatrp($jobd1); ?></td>
		<td align="right"><?php echo formatrp($jpokok1); ?></td>
		<td align="right"><?php echo formatrp($jbunga1); ?></td>
		<td align="right"><?php echo formatrp($jadm1); ?></td>
		<td align="right"><?php echo formatrp($jjumlah1); ?></td>
		<td align="right"><?php echo formatrp($jpokok2); ?></td>
		<td align="right"><?php echo formatrp($jbunga2); ?></td>
		<td align="right"><?php echo formatrp($jadm2); ?></td>
		<td align="right"><?php echo formatrp($jjumlah2); ?></td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr class="td" bgcolor="#e5e5e5">
		<td colspan="6" align="center"><strong>GRAND TOTAL</strong></td>
		<td align="right"><?php echo formatrp($gnomi1); ?></td>
		<td align="right"><?php echo formatrp($gobd1); ?></td>
		<td align="right"><?php echo formatrp($gpokok1); ?></td>
		<td align="right"><?php echo formatrp($gbunga1); ?></td>
		<td align="right"><?php echo formatrp($gadm1); ?></td>
		<td align="right"><?php echo formatrp($gjumlah1); ?></td>
		<td align="right"><?php echo formatrp($gpokok2); ?></td>
		<td align="right"><?php echo formatrp($gbunga2); ?></td>
		<td align="right"><?php echo formatrp($gadm2); ?></td>
		<td align="right"><?php echo formatrp($gjumlah2); ?></td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr class="td" bgcolor="#e5e5e5">
		<td colspan="6" align="center"><strong>TOTAL</strong></td>
		<td align="right"><?php echo formatrp($tnomi1); ?></td>
		<td align="right"><?php echo formatrp($tobd1); ?></td>
		<td align="right"><?php echo formatrp($tpokok1); ?></td>
		<td align="right"><?php echo formatrp($tbunga1); ?></td>
		<td align="right"><?php echo formatrp($tadm1); ?></td>
		<td align="right"><?php echo formatrp($tjumlah1); ?></td>
		<td align="right"><?php echo formatrp($tpokok2); ?></td>
		<td align="right"><?php echo formatrp($tbunga2); ?></td>
		<td align="right"><?php echo formatrp($tadm2); ?></td>
		<td align="right"><?php echo formatrp($tjumlah2); ?></td>
		<td colspan="2">&nbsp;</td>
	</tr>
</tbody>