<?php include 'h_tetap.php';?>
<script type="text/javascript" src="java/_formlaporan.js"></script>
<script type="text/javascript" src="jQuery/jquery.combobox.js"></script>
<script type="text/javascript">
	var url1="asuransi/asuransi12.php?p=1";
	var url2="asuransi/asuransi12.php?p=2";
	var url3="asuransi/asuransi12.php?p=3";
	var url4="asuransi/asuransi13.php?p=1";
	var url5="asuransi/asuransi13.php?p=2";
	var url6="asuransi/asuransi13.php?p=3";
</script>
<div class="ui-widget-content" align="center">
	<input type="hidden" id="cetakpdf" name="cetakpdf"/>
	<input type="hidden" id="cetakxls" name="cetakxls"/>	
	<?php include 'form_bulanan01.php';?>
	<button id="layar">Daftar Layar</button>
	<button id="rekap">Rekap Layar</button>	
</div>
<button id="btnpdf">PDF</button>
<button id="btnxls">XLS</button>
<div id="divPageLaporan"></div>