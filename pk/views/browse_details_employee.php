<?php
if(!empty($rows)) {
	foreach($rows as $row) {
		$vname=$row['vName'];
		$jabatan=$row['jabatan'];
		$division=$row['division'];
		$masuk=date("d-m-Y", strtotime($row['masuk']));
		$departement=$row['departement'];
	}
}else{
	$vname='';
	$jabatan='';
	$masuk='';
	$division='';
	$departement='';
}
?>
<script>
pro1="";
pro1 += "<style>";
pro1 += ".table_<?php echo $id; ?>{background-color:#5c9ccc;color:#effff0;}"
pro1 += ".table_<?php echo $id; ?> tr.border_bottom td{padding:5px 5px 5px 5px;}";
pro1 += "</style>";
pro1 += "<table id='table_<?php echo $id; ?>' class='table_<?php echo $id; ?>' width='100%'>";
pro1 += "<tr class='border_bottom'>";
pro1 += "<td>";
pro1 += "Nama Lengkap";
pro1 += "</td>";
pro1 += "<td>";
pro1 += ":";
pro1 += "</td>";
pro1 += "<td>";
pro1 += "<?php echo $vname; ?>";
pro1 += "</td>";
pro1 += "</tr>";
pro1 += "<tr class='border_bottom'>";
pro1 += "<td>";
pro1 += "Jabatan";
pro1 += "</td>";
pro1 += "<td>";
pro1 += ":";
pro1 += "</td>";
pro1 += "<td>";
pro1 += "<?php echo $jabatan; ?>";
pro1 += "</td>";
pro1 += "</tr>";
pro1 += "<tr class='border_bottom'>";
pro1 += "<td>";
pro1 += "Departemen";
pro1 += "</td>";
pro1 += "<td>";
pro1 += ":";
pro1 += "</td>";
pro1 += "<td>";
pro1 += "<?php echo $departement; ?>";
pro1 += "</td>";
pro1 += "</tr>";
pro1 += "<tr class='border_bottom'>";
pro1 += "<td>";
pro1 += "Tgl. Masuk";
pro1 += "</td>";
pro1 += "<td>";
pro1 += ":";
pro1 += "</td>";
pro1 += "<td>";
pro1 += "<?php echo $masuk; ?>";
pro1 += "</td>";
pro1 += "</tr>";
pro1 +="</table>";
$("label[for='<?php echo $id; ?>']").css({"width":"99%","text-transform": "uppercase","font-weight":"bold","color":"#000000"});
$("label[for='<?php echo $id; ?>']").append(pro1);
$("label[for='<?php echo $id; ?>']").next().remove();
</script>
<div style="overflow:auto;" class="rows_group">
	<label class="rows_label" for="<?php echo $id; ?>">
	</label>
	<div class="rows_input">
	</div>
</div>