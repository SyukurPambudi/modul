<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<?php
$id = isset($id)?$id:'';
$tableId = 'table_'.$id;
?>
<script>
function browseupd(url, title, dis, param) {
		var i = $('.btn_browse_bb').index(dis);	
		load_popup_multi(url+'&'+param,'','',title,i);
	}
function get_upb_exists() {
		var i = 0;
		var l_upb_id = '';
		$('.upd_id').each(function() {
			if  ($('.upd_id').eq(i).val() != '') {
				l_upb_id += $('.upd_id').eq(i).val()+',';
			}
			i++;
		});
	
		l_upb_id = l_upb_id.substring(0, l_upb_id.length - 1);
		if (l_upb_id == undefined || l_upb_id == '') l_upb_id= 0;
		$('.list_upbid_exists').val(l_upb_id);		
	}

$("#<?php echo $tableId;?> .fileupload").MultiFile();
$("#<?php echo $tableId;?> .file_remove").click(function(){
	var li = $(this).closest('li');
	var fileid = li.attr('fileid');
	var tmpDel = $("#det_upd_del");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid;
	tmpDel.val( v );
	alert( $("#det_upd_del").val() );
});

function add_row_det_upd_upload(table_id){		
		//alert(table_id);
		var row = $('table#'+table_id+' tbody tr:last').clone();
		$("span."+table_id+"_num:first").text('1');
		var n = $("span."+table_id+"_num:last").text();
		if (n.length == 0) {
			var c = 1;
			var row_content = '';
			row_content ='<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content +='<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content +='<span class="det_upd_upload_num">'+c+'</span></td>';
			row_content +='<td colspan="1" style="border: 1px solid #dddddd; width: 10%">';
			row_content +='<input type="text" name="idossier_upd_id_dis[]" disabled="TRUE" id="idossier_upd_id_dis_field_'+c+'" class="input_rows1 required" size="10" />';						
			row_content +='<input type="hidden" name="idossier_upd_id[]" id="idossier_upd_id_field_'+c+'" class="input_rows1 upd_id required" size="10" />';						
			row_content +='&nbsp;<button class="icon_pop"  onclick="javascript:get_upb_exists();javascript:browseupd(\'<?php echo base_url() ?>processor/plc/browse/upd/dokumen/pembagian/staff?field=field_'+c+'\',\'List UPD\',this,\'idossier_upd_id=\'+$(\'.list_upbid_exists\').val());return false;" type="button">&nbsp;</button>';			
			row_content +='<input type="hidden" name="list_upbid_exists" class="list_upbid_exists" value=""/>';		
			row_content +='</td>';		
			row_content +='<td colspan="1" style="border: 1px solid #dddddd; width: 15%">';	
			row_content +='<input type="text" name="vgenerik[]" disabled="TRUE" id="vgenerik_field_'+c+'" class="input_rows1 required" size="20" />';
			row_content +='</td>';
			row_content +='<td colspan="1" style="border: 1px solid #dddddd; width: 15%">';
			row_content +='<input type="text" name="vsediaan[]" disabled="TRUE" id="vsediaan_field_'+c+'" class="input_rows1 required" size="20" />';
			row_content +='</td>';
			row_content +='<td colspan="1" style="border: 1px solid #dddddd; width: 15%">';
			row_content +='<input type="text" name="dosis[]" disabled="TRUE" id="vsediaan_field_'+c+'" class="input_rows1 required" size="20" />';
			row_content +='</td>';
			row_content +='<td colspan="1" style="border: 1px solid #dddddd; width: 20%">';
			row_content +='<input type="text" disabled="TRUE" id="pic_pembagian_produk_field_'+c+'_dis" class="input_rows1 required" size="25" />';
			row_content +='<input type="hidden" name="pic_pembagian_produk[]" id="pic_pembagian_produk_field_'+c+'" class="input_rows1 required" size="25" />';
			row_content +='&nbsp;<button class="icon_pop"  onclick="browse(\'<?php echo base_url() ?>processor/plc/browse/pic/dokumen/pembagian/staff?field=pic_pembagian_produk_field_'+c+'&gr=TD\',\'List PIC\')" type="button">&nbsp;</button>';
			row_content +='</td>';
			row_content +='<td colspan="1" style="border: 1px solid #dddddd; width: 20%">';
			row_content +='<input type="text" disabled="TRUE" id="pic_pembagian_produk_andev_field_'+c+'_dis" class="input_rows1 required" size="25" />';
			row_content +='<input type="hidden" name="pic_pembagian_produk_andev[]" id="pic_pembagian_produk_andev_field_'+c+'" class="input_rows1 required" size="25" />';
			row_content +='&nbsp;<button class="icon_pop"  onclick="browse(\'<?php echo base_url() ?>processor/plc/browse/pic/dokumen/pembagian/staff?field=pic_pembagian_produk_andev_field_'+c+'&gr=AD\',\'List PIC\')" type="button">&nbsp;</button>';
			row_content +='</td>';
			row_content +='<td style="border: 1px solid #dddddd; width: 10%">';
			row_content +='<span class="delete_btn"><a href="javascript:;" class="det_upd_del" onclick="del_row(this, \'det_upd_del\')">[Hapus]</a></span>';
			row_content +='</td>';
			row_content +='</tr>';
			
			jQuery("#"+table_id+" tbody").append(row_content);
		} else {
			var no = parseInt(n);
			var c = no + 1;
			var row_content = '';
			row_content ='<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content +='<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content +='<span class="det_upd_upload_num">'+c+'</span></td>';
			row_content +='<td colspan="1" style="border: 1px solid #dddddd; width: 10%">';
			row_content +='<input type="text" name="idossier_upd_id_dis[]" disabled="TRUE" id="idossier_upd_id_dis_field_'+c+'" class="input_rows1 required" size="10" />';						
			row_content +='<input type="hidden" name="idossier_upd_id[]" id="idossier_upd_id_field_'+c+'" class="input_rows1 upd_id required" size="10" />';						
			row_content +='&nbsp;<button class="icon_pop"  onclick="javascript:get_upb_exists();javascript:browseupd(\'<?php echo base_url() ?>processor/plc/browse/upd/dokumen/pembagian/staff?field=field_'+c+'\',\'List UPD\',this,\'idossier_upd_id=\'+$(\'.list_upbid_exists\').val());return false;" type="button">&nbsp;</button>';			
			row_content +='<input type="hidden" name="list_upbid_exists" class="list_upbid_exists" value=""/>';		
			row_content +='</td>';		
			row_content +='<td colspan="1" style="border: 1px solid #dddddd; width: 15%">';	
			row_content +='<input type="text" name="vgenerik[]" disabled="TRUE" id="vgenerik_field_'+c+'" class="input_rows1 required" size="20" />';
			row_content +='</td>';
			row_content +='<td colspan="1" style="border: 1px solid #dddddd; width: 15%">';
			row_content +='<input type="text" name="vsediaan[]" disabled="TRUE" id="vsediaan_field_'+c+'" class="input_rows1 required" size="20" />';
			row_content +='</td>';
			row_content +='<td colspan="1" style="border: 1px solid #dddddd; width: 15%">';
			row_content +='<input type="text" name="dosis[]" class="required" disabled="TRUE" id="dosis_field_'+c+'" class="input_rows1" size="20" />';
			row_content +='</td>';
			row_content +='<td colspan="1" style="border: 1px solid #dddddd; width: 20%">';
			row_content +='<input type="text" disabled="TRUE" id="pic_pembagian_produk_field_'+c+'_dis" class="input_rows1 required" size="25" />';
			row_content +='<input type="hidden" name="pic_pembagian_produk[]" id="pic_pembagian_produk_field_'+c+'" class="input_rows1 required" size="25" />';
			row_content +='&nbsp;<button class="icon_pop"  onclick="browse(\'<?php echo base_url() ?>processor/plc/browse/pic/dokumen/pembagian/staff?field=pic_pembagian_produk_field_'+c+'&gr=TD\',\'List PIC\')" type="button">&nbsp;</button>';
			row_content +='</td>';
			row_content +='<td colspan="1" style="border: 1px solid #dddddd; width: 20%">';
			row_content +='<input type="text" disabled="TRUE" id="pic_pembagian_produk_andev_field_'+c+'_dis" class="input_rows1 required" size="25" />';
			row_content +='<input type="hidden" name="pic_pembagian_produk_andev[]" id="pic_pembagian_produk_andev_field_'+c+'" class="input_rows1 required" size="25" />';
			row_content +='&nbsp;<button class="icon_pop"  onclick="browse(\'<?php echo base_url() ?>processor/plc/browse/pic/dokumen/pembagian/staff?field=pic_pembagian_produk_andev_field_'+c+'&gr=AD\',\'List PIC\')" type="button">&nbsp;</button>';
			row_content +='</td>';
			row_content +='<td style="border: 1px solid #dddddd; width: 10%">';
			row_content +='<span class="delete_btn"><a href="javascript:;" class="det_upd_del" onclick="del_row(this, \'det_upd_del\')">[Hapus]</a></span>';
			row_content +='</td>';
			row_content +='</tr>';
			
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
		});

}
</script>

<table class="hover_table" id="det_upd_upload" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="8" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;"></span></th>
	</tr>
	<tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd; width: 5%;" >No</th>
		<th colspan="1" style="border: 1px solid #dddddd; width: 10%;">UPD</th>
		<th colspan="1" style="border: 1px solid #dddddd;width: 15%;">Nama Usulan</th>
		<th colspan="1" style="border: 1px solid #dddddd;width: 15%;">No Produk</th>
		<th colspan="1" style="border: 1px solid #dddddd;width: 15%;">Nama Produk</th>
		<th colspan="1" style="border: 1px solid #dddddd;width: 20%;">PIC Dossier</th>
		<th colspan="1" style="border: 1px solid #dddddd;width: 20%;">PIC Andev</th>
		<th style="border: 1px solid #dddddd; width: 10%;">Action</th>		
	</tr>
	</thead>
	<tbody>
		<?php
		
			$i = 1;
			$linknya = "";
			if(!empty($rows)) {

				foreach($rows as $row) {
				//	$sql="select * from hrd.employee em where em.cNip in ('".$row['vpic']."','".$row['vpic_andev']."')";
				//	$dt=$this-
			//selesai tambahan download
				?>
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
				<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
					<span class="det_upd_upload_num">1</span>
				</td>		
				<td colspan="1" style="border: 1px solid #dddddd; width: 10%">
					<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>
					
					<input type="text" name="idossier_upd_id_dis" disabled="TRUE" id="idossier_upd_id_dis_field_1" class="input_rows1 required" size="10" value="<?php echo $row['vUpd_no'] ?>" />
					<input type="hidden" name="idossier_upd_id" id="idossier_upd_id_field_1" class="input_rows1 upd_id required" size="10" value="<?php echo $row['idossier_upd_id'] ?>" />
					<input type="hidden" name="list_upbid_exists" class="list_upbid_exists" value="<?php echo $row['idossier_upd_id'] ?>" />
				</td>	
				<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
					<input type="text" name="vgenerik" disabled="TRUE" id="vgenerik_field_1" class="input_rows1 required" size="20" value="<?php echo $row['vNama_usulan'] ?>" />
				</td>
				<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
					<input type="text" name="vsediaan" class="required" disabled="TRUE" id="vsediaan_field_1" class="input_rows1 required" size="20" value="<?php echo $row['C_ITENO'] ?>" />
				</td>
				<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
					<input type="text" name="dosis" disabled="TRUE" id="dosis_field_1" class="input_rows1 required" size="20" value="<?php echo $row['C_ITNAM'] ?>" />
				</td>
				<td colspan="1" style="border: 1px solid #dddddd; width: 20%">
					<input type="text" name="pic_pembagian_produk" disabled="TRUE" id="pic_pembagian_produk_field_1_dis" class="input_rows1 required" size="25" value="<?php echo $row['vpic'].'-'.$row['namedossier']; ?>" />
					<input type="hidden" name="pic_pembagian_produk" id="pic_pembagian_produk_field_1" class="input_rows1 required" size="25" value="<?php echo $row['vpic'] ?>" />
					&nbsp;<button class="icon_pop"  onclick="browse('<?php echo base_url() ?>processor/plc/browse/pic/dokumen/pembagian/staff?field=pic_pembagian_produk_field_1&gr=TD','List PIC Team Dossier')" type="button">&nbsp;</button>
				</td>
				<td colspan="1" style="border: 1px solid #dddddd; width: 20%">
					<input type="text" name="pic_pembagian_andev_produk" disabled="TRUE" id="pic_pembagian_andev_produk_field_1_dis" class="input_rows1 required" size="25" value="<?php echo $row['vpic_andev'].'-'.$row['nameandev']; ?>" />
					<input type="hidden" name="pic_pembagian_andev_produk" id="pic_pembagian_andev_produk_field_1" class="input_rows1 required" size="25" value="<?php echo $row['vpic_andev'] ?>" />
					&nbsp;<button class="icon_pop"  onclick="browse('<?php echo base_url() ?>processor/plc/browse/pic/dokumen/pembagian/staff?field=pic_pembagian_andev_produk_field_1&gr=AD','List PIC Andev')" type="button">&nbsp;</button>
				</td>
				<td style="border: 1px solid #dddddd; width: 10%">
					-
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
					<span class="det_upd_upload_num">1</span>
				</td>		
				<td colspan="1" style="border: 1px solid #dddddd; width: 10%">
					<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>
					
					<input type="text" name="idossier_upd_id_dis[]" disabled="TRUE" id="idossier_upd_id_dis_field_1" class="input_rows1 required" size="10" />
					<input type="hidden" name="idossier_upd_id[]" id="idossier_upd_id_field_1" class="input_rows1 upd_id required" size="10" />
					&nbsp;<button class="icon_pop"  onclick="javascript:get_upb_exists();javascript:browseupd('<?php echo base_url() ?>processor/plc/browse/upd/dokumen/pembagian/staff?field=field_1','List UPD',this,'idossier_upd_id='+$('.list_upbid_exists').val());return false;" type="button">&nbsp;</button>
					<input type="hidden" name="list_upbid_exists" class="list_upbid_exists" value=""/>
				</td>	
				<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
					<input type="text" name="vgenerik[]" disabled="TRUE" id="vgenerik_field_1" class="input_rows1 required" size="20" />
				</td>
				<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
					<input type="text" name="vsediaan[]" class="required" disabled="TRUE" id="vsediaan_field_1" class="input_rows1 required" size="20" />
				</td>
				<td colspan="1" style="border: 1px solid #dddddd; width: 15%">
					<input type="text" name="dosis[]" disabled="TRUE" id="dosis_field_1" class="input_rows1 required" size="20" />
				</td>
				<td colspan="1" style="border: 1px solid #dddddd; width: 20%">
					<input type="text" name="pic_pembagian_produk[]" disabled="TRUE" id="pic_pembagian_produk_field_1_dis" class="input_rows1 required" size="25" />
					<input type="hidden" name="pic_pembagian_produk[]" id="pic_pembagian_produk_field_1" class="input_rows1 required" size="25" />
					&nbsp;<button class="icon_pop"  onclick="browse('<?php echo base_url() ?>processor/plc/browse/pic/dokumen/pembagian/staff?field=pic_pembagian_produk_field_1&gr=TD','List PIC Team Dossier')" type="button">&nbsp;</button>
				</td>
				<td colspan="1" style="border: 1px solid #dddddd; width: 20%">
					<input type="text" name="pic_pembagian_produk_andev[]" disabled="TRUE" id="pic_pembagian_produk_andev_field_1_dis" class="input_rows1 required" size="25" />
					<input type="hidden" name="pic_pembagian_produk_andev[]" id="pic_pembagian_produk_andev_field_1" class="input_rows1 required" size="25" />
					&nbsp;<button class="icon_pop"  onclick="browse('<?php echo base_url() ?>processor/plc/browse/pic/dokumen/pembagian/staff?field=pic_pembagian_produk_andev_field_1&gr=AD','List PIC AD')" type="button">&nbsp;</button>
				</td>
				<td style="border: 1px solid #dddddd; width: 10%">
					<span class="delete_btn"><a href="javascript:;" class="det_upd_del" onclick="del_row(this, 'det_upd_del')">[Hapus]</a></span>
				</td>	
			</tr>
		<?php } }?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6" style="text-align: left"></td><td style="text-align: center">
				<?php if ($this->input->get('action') == 'create') { ?>
					<a href="javascript:;" onclick="javascript:add_row_det_upd_upload('det_upd_upload')">Tambah</a>	
				<?php } ?>
				
			</td>
		</tr>
	</tfoot>
</table>
<script type="text/javascript">
$( document ).ready(function() {
	$("#det_upd_upload").parent().css({"margin-left": "0px"});
});
</script>