<?php
include '../h_atas.php';
$bln=$result->c_d($_GET['bln']);
$thn=$result->c_d($_GET['thn']);
$pilih=$result->c_d($_GET['p']);
$branch=$result->c_d($_GET['branch']);
$fieldhari2='bulandk'.substr('00'.$bln,-2);
$fieldhari3='bulankk'.substr('00'.$bln,-2);
$fieldhari4='bulandm'.substr('00'.$bln,-2);
$fieldhari5='bulankm'.substr('00'.$bln,-2);
$fieldhari6='bulan'.substr('00'.$bln,-2);
$blnl=$bln-1;$thnl=$thn;
$fieldhari1='bulan'.substr('00'.$blnl,-2);
if($branch=='0111'){
	if($bln=='01'){
		$thnl=$thn-1;
		$fieldhari1='tahun12a';
		$tabeln='akuntansi.sandi'.$thnl;
		$result->res("CREATE TEMPORARY TABLE $userid SELECT a.branch,a.nonas,a.nama,a.norekgssl,a.produk,SUM(b.$fieldhari1) AS $fieldhari1,SUM(a.$fieldhari2) AS $fieldhari2,SUM(a.$fieldhari3) AS $fieldhari3,SUM(a.$fieldhari4) AS $fieldhari4,SUM(a.$fieldhari5) AS $fieldhari5,SUM(a.$fieldhari6) AS $fieldhari6 FROM $tabel_sandi a JOIN $tabeln b ON a.norekgssl=b.norekgssl GROUP BY a.nonas ORDER BY a.nonas");
	}else{
		if($thn!=$thnxxx){
			if($bln=='01'){
				$thnl=$thn-1;
				$fieldhari1='tahun12a';
				$tabeln='akuntansi.sandi'.$thnl;
				$tabel_sandi='akuntansi.sandi'.$thn;
				$result->res("CREATE TEMPORARY TABLE $userid SELECT a.branch,a.nonas,a.nama,a.norekgssl,a.produk,SUM(b.$fieldhari1) AS $fieldhari1,SUM(a.$fieldhari2) AS $fieldhari2,SUM(a.$fieldhari3) AS $fieldhari3,SUM(a.$fieldhari4) AS $fieldhari4,SUM(a.$fieldhari5) AS $fieldhari5,SUM(a.$fieldhari6) AS $fieldhari6 FROM $tabel_sandi a JOIN $tabeln b ON a.norekgssl=b.norekgssl GROUP BY a.nonas ORDER BY a.nonas");				
			}else{
				$tabel_sandi='akuntansi.sandi'.$thn;
				if($bln!=$blnl){
					$fieldhari1='bulan'.substr('00'.$blnl,-2);
				}
				$result->res("CREATE TEMPORARY TABLE $userid SELECT branch,nonas,nama,norekgssl,produk,SUM($fieldhari1) AS $fieldhari1,SUM($fieldhari2) AS $fieldhari2,SUM($fieldhari3) AS $fieldhari3,SUM($fieldhari4) AS $fieldhari4,SUM($fieldhari5) AS $fieldhari5,SUM($fieldhari6) AS $fieldhari6 FROM $tabel_sandi GROUP BY nonas ORDER BY nonas,norekgssl");
			}
		}else{
			if($bln!=$blnl){
				$fieldhari1='bulan'.substr('00'.$blnl,-2);
			}
			$result->res("CREATE TEMPORARY TABLE $userid SELECT branch,nonas,nama,norekgssl,produk,SUM($fieldhari1) AS $fieldhari1,SUM($fieldhari2) AS $fieldhari2,SUM($fieldhari3) AS $fieldhari3,SUM($fieldhari4) AS $fieldhari4,SUM($fieldhari5) AS $fieldhari5,SUM($fieldhari6) AS $fieldhari6 FROM $tabel_sandi GROUP BY nonas ORDER BY nonas,norekgssl");
		}
	}		
}else{
	if($bln=='01'){
		$thnl=$thn-1;
		$fieldhari1='tahun12a';
		$tabeln='akuntansi.sandi'.$thnl;
		$result->res("CREATE TEMPORARY TABLE $userid SELECT a.branch,a.nonas,a.nama,a.norekgssl,a.produk,b.$fieldhari1,a.$fieldhari2,a.$fieldhari3,a.$fieldhari4,a.$fieldhari5,a.$fieldhari6 FROM $tabel_sandi a JOIN $tabeln b ON a.norekgssl=b.norekgssl WHERE a.branch='$branch' ORDER BY a.norekgssl");
	}else{
		if($thn!=$thnxxx){
			if($bln=='01'){
				$thnl=$thn-1;
				$fieldhari1='tahun12a';
				$tabeln='akuntansi.sandi'.$thnl;
				$tabel_sandi='akuntansi.sandi'.$thn;
				$result->res("CREATE TEMPORARY TABLE $userid SELECT a.branch,a.nonas,a.nama,a.norekgssl,a.produk,b.$fieldhari1,a.$fieldhari2,a.$fieldhari3,a.$fieldhari4,a.$fieldhari5,a.$fieldhari6 FROM $tabel_sandi a JOIN $tabeln b ON a.norekgssl=b.norekgssl WHERE a.branch='$branch' ORDER BY a.norekgssl");				
			}else{
				$tabel_sandi='akuntansi.sandi'.$thn;
				if($bln!=$blnl){
					$fieldhari1='bulan'.substr('00'.$blnl,-2);
				}
				$result->res("CREATE TEMPORARY TABLE $userid SELECT branch,nonas,nama,norekgssl,produk,$fieldhari1,$fieldhari2,$fieldhari3,$fieldhari4,$fieldhari5,$fieldhari6 FROM $tabel_sandi WHERE branch='$branch' ORDER BY norekgssl");
			}
		}else{
			if($bln!=$blnl){
				$fieldhari1='bulan'.substr('00'.$blnl,-2);
			}
			$result->res("CREATE TEMPORARY TABLE $userid SELECT branch,nonas,nama,norekgssl,produk,$fieldhari1,$fieldhari2,$fieldhari3,$fieldhari4,$fieldhari5,$fieldhari6 FROM $tabel_sandi WHERE branch='$branch' ORDER BY norekgssl");		
		}
	}	
}
?>