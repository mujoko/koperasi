<?php include 'auth.php';?>
<script type="text/javascript" src="java/_tambah_icon.js"></script>
<script TYPE="text/javascript">
	var url1='new_nasabah21.php';
	$("input#nonas").focus();
	$("#lookup_nonas").lookupbox({
		title: 'Daftar Rekening',
		url  : 'lookup/lookup_nonas.php?chars=',
		imgLoader: '<img src="images/load.gif">',
		onItemSelected: function(data)	{
			$('input[name=nonas]').val(data.nonas);
		},
		tableHeader: ['Branch','Nonas','Nama','No KTP']
	});
</script>
<div class="ui-widget-content" align="center">
	<form id="formsearch" name="formsearch" method="post" action="">
		NO NASABAH :
		<input  type="text" name="nonas" id="nonas" size="10"  maxlength="6" onKeyUp="caps(this)"/>
		<button type="button" id="lookup_nonas">&nbsp;</button>
		<button type="button" id="lacak_data">Cari Data</button>
	</form>
</div>
<div ID="divPageHasil"></div>