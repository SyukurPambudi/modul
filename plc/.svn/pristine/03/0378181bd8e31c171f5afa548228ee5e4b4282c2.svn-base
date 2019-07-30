<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<?php
$id = isset($id)?$id:'';
$tableId = 'table_'.$id;
$dtnow=date('Y-m-d H:i:s');
?>

<script>
$("#<?php echo $tableId;?> .fileupload").MultiFile();
$("#<?php echo $tableId;?> .file_remove").click(function(){
	var li = $(this).closest('li');
	var fileid = li.attr('fileid');
	var tmpDel = $("#brosur_bb_del");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid;
	tmpDel.val( v );
	alert( $("#brosur_bb_del").val() );
});

function add_row_brosur_upload(table_id){		
		//alert(table_id);
		var row = $('table#'+table_id+' tbody tr:last').clone();
		$("span."+table_id+"_num:first").text('1');
		var n = $("span."+table_id+"_num:last").text();
		var dtnow='<?php echo $dtnow; ?>';
		if (n.length == 0) {
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';			
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<select id= "idbahan'+c+'" name="idbahan[]" tyle="width: 70%" class="required"><option value="">---Pilih---</option>';
			row_content  += '<?php $sql=mysql_query("select a.idossier_bahan_komparator_id as a1, a.vKode_bahan as b, a.vNama_bahan as c from dossier.dossier_bahan_komparator as a order by a.vNama_bahan ASC "); while ($dt=mysql_fetch_array($sql)){ ?><option value="<?php echo $dt[0]; ?>"><?php echo $dt[1]."-".$dt[2]; ?></option><?php } ?>';
			row_content  += '</select></td>';
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 8%">';
			row_content  += '<input type="hidden" id="permintaan_komparator_idprodusen1" name="idprodusen[]" value="" class="required" />'; 
			row_content  += '<input type="text" id="permintaan_komparator_idprodusen1_dis" value="" class="required" disabled="disabled" size="35"/>'; 
			row_content  += '<button class="icon_pop"  onclick="browse(\'<?php echo base_url() ?>processor/plc/browse/produsen/komparator?field=permintaan_komparator_idprodusen1\',\'List Produsen Komparator\')" type="button">&nbsp;</button>';
			row_content	 += '</td>';
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<input type="number" id="jumlah'+c+'" name="jumlah[]" min=1 max=9999999 value="" class="required"/></td>';
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<input type="text" id="satuan'+c+'" name="satuan[]" value="" class="required" /></td>';
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<input type="text" id="spek'+c+'" name="spek[]" value="" class="required" />';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="brosur_bb_del" onclick="del_row(this, \'brosur_bb_del\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';

			jQuery("#"+table_id+" tbody").append(row_content);
		} else {
			var no = parseInt(n);
			var c = no + 1;
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';			
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<select id= "idbahan'+c+'" name="idbahan[]" tyle="width: 70%" class="required"><option value="">---Pilih---</option>';
			row_content  += '<?php $sql=mysql_query("select a.idossier_bahan_komparator_id as a1, a.vKode_bahan as b, a.vNama_bahan as c from dossier.dossier_bahan_komparator as a order by a.vNama_bahan ASC "); while ($dt=mysql_fetch_array($sql)){ ?><option value="<?php echo $dt[0]; ?>"><?php echo $dt[1]."-".$dt[2]; ?></option><?php } ?>';
			row_content  += '</select></td>';
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 8%">';
			row_content  += '<input type="hidden" id="permintaan_komparator_idprodusen'+c+'" name="idprodusen[]" value="" class="required" />'; 
			row_content  += '<input type="text" id="permintaan_komparator_idprodusen'+c+'_dis" value="" class="required" disabled="disabled" size="35"/>'; 
			row_content  += '<button class="icon_pop"  onclick="browse(\'<?php echo base_url() ?>processor/plc/browse/produsen/komparator?field=permintaan_komparator_idprodusen'+c+'\',\'List Produsen Komparator\')" type="button">&nbsp;</button>';
			row_content	 += '</td>';
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<input type="number" id="jumlah'+c+'" name="jumlah[]" min=1 max=9999999 value="" class="required" /></td>';
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<input type="text" id="satuan'+c+'" name="satuan[]" value="" class="required" /></td>';
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 8%">';
			row_content	 += '<input type="text" id="spek'+c+'" name="spek[]" value="" class="required" />';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="brosur_bb_del" onclick="del_row(this, \'brosur_bb_del\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			$('table#'+table_id+' tbody tr:last').after(row_content);
           	$('table#'+table_id+' tbody tr:last input').val("");
			$('table#'+table_id+' tbody tr:last div').text("");
			$("span."+table_id+"_num:last").text(c);		
		}
		$( "button.icon_pop" ).button({
			icons: {
				primary: "ui-icon-newwin"
			},
			text: false
		})

}
</script>

<table class="hover_table" id="brosur_bb_upload" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="8" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Komparator Details</span></th>
	</tr>
	<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd; width: 5%;" >No</th>
		<th colspan="1" style="border: 1px solid #dddddd; width: 25%;">Nama Produk Komparator</th>
		<th colspan="1" style="border: 1px solid #dddddd;width: 20%;">Nama Produsen</th>
		<th colspan="1" style="border: 1px solid #dddddd;width: 20%;">Jumlah</th>
		<th colspan="1" style="border: 1px solid #dddddd;width: 20%;">Satuan</th>
		<th colspan="1" style="border: 1px solid #dddddd;width: 20%;">Spesifikasi</th>
		<th style="border: 1px solid #dddddd; width: 20%;">Action</th>		
	</tr>
	</thead>
	<tbody>
		<?php
		
			$i = 1;
			$linknya = "";
			if(!empty($rows)) {
				foreach($rows as $row) {
					$idkompa  = $row['idossier_bahan_komparator_id'];
					$idprodusen = $row['idossier_produsen_komparator_id'];	
					$iJumlah=$row['iJumlah'];
					$cSatuan=$row['cSatuan'];
					$vSpesifikasi=$row['vSpesifikasi'];
					$dossier_komparator_detail_id=$row['dossier_komparator_detail_id'];

					//tambahan untuk download file	
			//selesai tambahan download
		?>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<input type="hidden" name='dossier_komparator_detail_id[]' value="<?php echo $dossier_komparator_detail_id; ?>" id="dossier_komparator_detail_id<?php echo $i; ?>" />
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="brosur_bb_upload_num"><?php echo  $i; ?></span>
					</td>		
					<td colspan="1" style="border: 1px solid #dddddd; width: 8%">
						<select id= "idbahan<?php echo  $i; ?>" name="idbahan_ed[<?php echo $dossier_komparator_detail_id; ?>]" tyle="width: 70%" class="required">
							<option value="">---Pilih---</option>
							<?php 
							$sql="select a.idossier_bahan_komparator_id as a1, a.vKode_bahan as b, a.vNama_bahan as c from dossier.dossier_bahan_komparator as a order by a.vNama_bahan ASC "; 
							$q=$this->dbset->query($sql)->result_array();
							foreach ($q as $k => $vq) {
								$sel=$idkompa==$vq['a1']?'selected':'';
								echo '<option value="'.$vq['a1'].'" '.$sel.'>'.$vq['b'].' - '.$vq['c'].'</option>';
								} ?>
							</select>
						</td>	
					<td colspan="1" style="border: 1px solid #dddddd; width: 27%">
						<input type="hidden" id="permintaan_komparator_idprodusen<?php echo  $i; ?>" name="idprodusen_ed[<?php echo $dossier_komparator_detail_id; ?>]" value="<?php echo $idprodusen; ?>" class="required" /> 
						<?php
							$s="select * from dossier.dossier_produsen_komparator pr where pr.idossier_produsen_komparator_id=".$idprodusen;
							$d=$this->dbset->query($s)->row_array();
							$nr=strlen($d['vNama_produsen']);
							if($nr>=50){
								$nama= substr($d['vNama_produsen'], 0, 50);
							}else{
								$nama=$d['vNama_produsen'];
							}
							$nama=$d['vKode_produsen'].' - '.$nama;
						?>
						<input type="text" id="permintaan_komparator_idprodusen<?php echo  $i; ?>_dis" value="<?php echo $nama; ?>" class="required" disabled="disabled" size="35"/> 
						<button class="icon_pop" onclick="browse('<?php echo base_url() ?>processor/plc/browse/produsen/komparator?field=permintaan_komparator_idprodusen<?php echo  $i; ?>','List Produsen Komparator')" type="button">&nbsp;</button>
					</td>
					<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
						<input type="number" id="jumlah<?php echo  $i; ?>" name="jumlah_ed[<?php echo $dossier_komparator_detail_id; ?>]" min=1 max=9999999 value="<?php echo $iJumlah; ?>" class="required" /></td>
					<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
						<input type="text" id="satuan<?php echo  $i; ?>" name="satuan_ed[<?php echo $dossier_komparator_detail_id; ?>]" value="<?php echo $cSatuan; ?>" class="required" /></td>
					<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
						<input type="text" id="spek<?php echo  $i; ?>" name="spek_ed[<?php echo $dossier_komparator_detail_id; ?>]" value="<?php echo $vSpesifikasi; ?>" class="required" /></td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="brosur_bb_del" onclick="del_row1(this, 'brosur_bb_del')">[Hapus]</a></span>
					</td>	
				</tr>
		<?php
			$i++;	
				}

			}
			else {

				if ($this->input->get('action') == 'view') {
					//untuk view yang tidak ada file upload sama sekali
				?>
					<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
						<td colspan="6"style="border: 1px solid #dddddd; width: 3%; text-align: center;">
							<span>Tidak ada file diupload</span>
						</td>		
					</tr>

					

				<?php 
				}else{
			//$i++;
		?>
		<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
						<span class="brosur_bb_upload_num">1</span>
					</td>		
					<td colspan="1" style="border: 1px solid #dddddd; width: 8%">
						<select id= "idbahan1" name="idbahan[]" tyle="width: 70%" class="required">
							<option value="">---Pilih---</option>
							<?php $sql=mysql_query("select a.idossier_bahan_komparator_id as a1, a.vKode_bahan as b, a.vNama_bahan as c from dossier.dossier_bahan_komparator as a order by a.vNama_bahan ASC "); while ($dt=mysql_fetch_array($sql)){ ?><option value="<?php echo $dt[0]; ?>"><?php echo $dt[1]."-".$dt[2]; ?></option><?php } ?>
							</select>
						</td>	
					<td colspan="1" style="border: 1px solid #dddddd; width: 27%">
						<input type="hidden" id="permintaan_komparator_idprodusen1" name="idprodusen[]" value="" class="required" /> 
						<input type="text" id="permintaan_komparator_idprodusen1_dis" value="" class="required" disabled="disabled" size="35"/> 
						<button class="icon_pop"  onclick="browse('<?php echo base_url() ?>processor/plc/browse/produsen/komparator?field=permintaan_komparator_idprodusen1','List Produsen Komparator')" type="button">&nbsp;</button>
					</td>
					<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
						<input type="number" id="jumlah1" name="jumlah[]" min=1 max=9999999 value="" class="required" /></td>
					<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
						<input type="text" id="satuan1" name="satuan[]" value="" class="required" /></td>
					<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
						<input type="text" id="spek1" name="spek[]" value="" class="required" /></td>
					<td style="border: 1px solid #dddddd; width: 10%">
						<span class="delete_btn"><a href="javascript:;" class="brosur_bb_del" onclick="del_row1(this, 'brosur_bb_del')">[Hapus]</a></span>
					</td>	
				</tr>
		<?php } }?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6"></td><td style="text-align: center">
				<?php if ($this->input->get('action') != 'view') { ?>
					<a href="javascript:;" onclick="javascript:add_row_brosur_upload('brosur_bb_upload')">Tambah</a>	
				<?php } ?>
				
			</td>
		</tr>
	</tfoot>
</table>