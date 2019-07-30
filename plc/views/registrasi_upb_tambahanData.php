<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<?php
$id = isset($id)?$id:'';
$tableId = 'table_'.$id;
?>
<script>
$("#<?php echo $tableId;?> .fileupload").MultiFile();
$("#<?php echo $tableId;?> .file_remove").click(function(){
	var li = $(this).closest('li');
	var fileid = li.attr('fileid');
	var tmpDel = $("#upb_filedel");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid;
	tmpDel.val( v );
	alert( $("#upb_filedel").val() );
});
$( "#divPR" ).click(function() {
	if($(this).is (':checked')){
		$("#notePR").removeAttr('disabled');
	}
	else{$("#notePR").attr('disabled',true);}
});
$( "#divAD" ).click(function() {
	if($(this).is (':checked')){
		$("#noteAD").removeAttr('disabled');
	}
	else{$("#noteAD").attr('disabled',true);}
});
$( "#divPD" ).click(function() {
	if($(this).is (':checked')){
		$("#notePD").removeAttr('disabled');
	}
	else{$("#notePD").attr('disabled',true);}
});
$( "#divQA" ).click(function() {
	if($(this).is (':checked')){
		$("#noteQA").removeAttr('disabled');
	}
	else{$("#noteQA").attr('disabled',true);}
});
$( "#divQAM" ).click(function() {
	if($(this).is (':checked')){
		$("#noteQAM").removeAttr('disabled');
	}
	else{$("#noteQAM").attr('disabled',true);}
});
$( "#divPDV" ).click(function() {
	if($(this).is (':checked')){
		$("#notePDV").removeAttr('disabled');
	}
	else{$("#notePDV").attr('disabled',true);}
});
$( "#divQC" ).click(function() {
	if($(this).is (':checked')){
		$("#noteQC").removeAttr('disabled');
	}
	else{$("#noteQC").attr('disabled',true);}
});

$( "#tambahdata" ).click(function() {
	if($('#tambahdata').is (':checked')){
		$("#divPR").addClass("required");
		$("#divPD").addClass('required');
		$("#divAD").addClass('required');
		$("#divQA").addClass('required');
		$("#divQAM").addClass('required');
		$("#divQC").addClass('required');
		$("#divPDV").addClass('required');
		$("#fileuploadtd").addClass('required');
		$("#tTamb_Data_td").addClass('required');
		$("#tSub_TD_td").addClass('required');
		$("#tSub_Dok_AppLet_td").addClass('required');
		$("#tTD_AppLet_td").addClass('required');
		$( "#registrasi_td" ).show( "slow" );
	}
	else{
		$("#divPR").removeClass('required');
		$("#divPD").removeClass('required');
		$("#divAD").removeClass('required');
		$("#divQA").removeClass('required');
		$("#divQAM").removeClass('required');
		$("#divQC").removeClass('required');
		$("#divPDV").removeClass('required');
		$("#fileuploadtd").removeClass('required');
		$("#tTamb_Data_td").removeClass('required');
		$("#tSub_TD_td").removeClass('required');
		$("#tSub_Dok_AppLet_td").removeClass('required');
		$("#tTD_AppLet_td").removeClass('required');
		$( "#registrasi_td" ).hide( "slow" );
	}
});
</script>
<input type="checkbox" name="tambahdata" id="tambahdata" value="1"/>
<table class="hover_table" id="registrasi_td" cellspacing="0" cellpadding="1" style="width: 120%; border: 1px solid #dddddd; text-align: center; margin-left: -180px;  margin-top: 30px; border-collapse: collapse;display: none;">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="6" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Tambahan Data</span></th>
	</tr>
	<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">Tgl TD</th>
		<th style="border: 1px solid #dddddd;">Tgl Submit TD</th>
		<th style="border: 1px solid #dddddd;">Tgl Submit Dok.AppLet</th>
		<th style="border: 1px solid #dddddd;">Tgl TD AppLet</th>
		<th style="border: 1px solid #dddddd;">Memo TD</th>
		<th style="border: 1px solid #dddddd;">Divisi</th>
	</tr>
	</thead>
	<tbody>
		<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
			<td style="border: 1px solid #dddddd;" valign="top">
				<input type="text" class="input_tgl datepicker input_rows1" name="tTamb_Data_td" id="tTamb_Data_td">
			</td>
			<td style="border: 1px solid #dddddd;" valign="top">
				<input type="text" class="input_tgl datepicker input_rows1" name="tSub_TD_td" id="tSub_TD_td">
			</td>
			<td style="border: 1px solid #dddddd;" valign="top">
				<input type="text" class="input_tgl datepicker input_rows1" name="tSub_Dok_AppLet_td" id="tSub_Dok_AppLet_td">
			</td>
			<td style="border: 1px solid #dddddd;"valign="top">
				<input type="text" class="input_tgl datepicker input_rows1" name="tTD_AppLet_td" id="tTD_AppLet_td">
			</td>
			<td valign="top" style="border: 1px solid #dddddd; width: 150px">
				<input type="file" class="fileupload multi multifile" name="fileuploadtd[]" style="width:150px" /> *max 5 mb
				<input type="hidden" name="namafiletd[]" style="width: 70%" value="" />
				<input type="hidden" name="fileidtd[]" style="width: 70%" value="" />
			</td>
			<td style="border: 1px solid #dddddd; width: 52%">
				<div style="height: 30px;">
					<div style="width:75px; float:left; text-align: left; margin-left: 5px">Purchasing PD</div> 
					<div style="width:25px; float:left;"><input type="checkbox" name="divPR" id="divPR" value="PR"/></div>
					<div style="width:420px; float:left;"><input type="text" name="notePR" disabled id="notePR" class="input_rows1" style="width: 420px;" /></div>
				</div>
				<div style="height: 30px;">
					<div style="width:75px; float:left; text-align: left; margin-left: 5px">AD</div> 
					<div style="width:25px; float:left;"><input type="checkbox" name="divAD" id="divAD" value="AD"/></div>
					<div style="width:420px; float:left;"><input type="text" name="noteAD" id="noteAD" disabled class="input_rows1" style="width: 420px;" /></div>
				</div>
				<div style="height: 30px;">
					<div style="width:75px; float:left; text-align: left; margin-left: 5px">PD</div> 
					<div style="width:25px; float:left;"><input type="checkbox" name="divPD" id="divPD" value="PD"/></div>
					<div style="width:420px; float:left;"><input type="text" name="notePD" id="notePD" disabled class="input_rows1" style="width: 420px;" /></div>
				</div>
				<div style="height: 30px;">
					<div style="width:75px; float:left; text-align: left; margin-left: 5px">QA</div> 
					<div style="width:25px; float:left;"><input type="checkbox" name="divQA" id="divQA" value="QA"/></div>
					<div style="width:420px; float:left;"><input type="text" name="noteQA" id="noteQA" disabled class="input_rows1" style="width: 420px;" /></div>
				</div>
				<div style="height: 30px;">
					<div style="width:75px; float:left; text-align: left; margin-left: 5px">QA Mikro</div> 
					<div style="width:25px; float:left;"><input type="checkbox" name="divQAM" id="divQAM" value="QAM"/></div>
					<div style="width:420px; float:left;"><input type="text" name="noteQAM" id="noteQAM" disabled class="input_rows1" style="width: 420px;" /></div>
				</div>
				<div style="height: 30px;">
					<div style="width:75px; float:left; text-align: left; margin-left: 5px">Packdev</div> 
					<div style="width:25px; float:left;"><input type="checkbox" name="divPDV" id="divPDV" value="PDV"/></div>
					<div style="width:420px; float:left;"><input type="text" name="notePDV" id="notePDV" disabled class="input_rows1" style="width: 420px;" /></div>
				</div>
				<div style="height: 30px;">
					<div style="width:75px; float:left; text-align: left; margin-left: 5px">QC</div> 
					<div style="width:25px; float:left;"><input type="checkbox" name="divQC" id="divQC" value="QC"/></div>
					<div style="width:420px; float:left;"><input type="text" name="noteQC" id="noteQC" disabled class="input_rows1" style="width: 420px;" /></div>
				</div>
			</td>		
		</tr>
	</tbody>
</table>