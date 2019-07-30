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
	var tmpDel = $("#brosur_bb_del");
	li.remove();
	var v = tmpDel.val();
	v+=','+fileid;
	tmpDel.val( v );
	alert( $("#brosur_bb_del").val() );
});

	var prinsip='';
	var config3 = {
		source: base_url+'processor/plc/import/analisa/principal?action=cariprinsipal&prinsip='+$('#prinsip').val()+'  ',					
		select: function(event, ui){
			var old_prinsip = $('#prinsip').val();

			$('.iprinsipal_id').val(ui.item.id);						
			$('.vNama_prinsipal').val(ui.item.vNama_prinsipal);						

			if ( old_prinsip =='') {
				$('#prinsip').val(ui.item.id);
			}else{
				$('#prinsip').val(old_prinsip+','+ui.item.id);
			}

		},
		minLength: 2,
		autoFocus: true,
	};

	$(".vNama_prinsipal").livequery(function(){
		$(this).autocomplete(config3);
		var i = $('.vNama_prinsipal').index(this);
		$(this).keypress(function(e){
			if(e.which != 13) {
				$('.iprinsipal_id').val('');
			}			
		});
		$(this).blur(function(){
			if($('.iprinsipal_id').val() == '') {
				$(this).val('');
			}			
		});
	})





function add_row_brosur_upload(table_id){		
		
		var dBerhasil_dihubungi = "<select id='dBerhasil_dihubungi' name='dBerhasil_dihubungi[]'>";
		dBerhasil_dihubungi += "<option value='Y'";
		dBerhasil_dihubungi += ">Y</option>";
		dBerhasil_dihubungi += "<option value='N'";
		dBerhasil_dihubungi += ">N</option>";
		dBerhasil_dihubungi += "</select>";

		var vTahap_pembahasan = "<select id='vTahap_pembahasan' name='vTahap_pembahasan[]'>";
		vTahap_pembahasan += "<option value='Y'";
		vTahap_pembahasan += ">Y</option>";
		vTahap_pembahasan += "<option value='N'";
		vTahap_pembahasan += ">N</option>";
		vTahap_pembahasan += "</select>";

		var iPrincipal_terpilih = "<select id='iPrincipal_terpilih' name='iPrincipal_terpilih[]' class='required cbpilih'>";
		iPrincipal_terpilih += "<option value=''";
		iPrincipal_terpilih += ">Pilih</option>";
		iPrincipal_terpilih += "<option value='Y'";
		iPrincipal_terpilih += ">Y</option>";
		iPrincipal_terpilih += "<option value='N'";
		iPrincipal_terpilih += ">N</option>";
		iPrincipal_terpilih += "</select>";



		//alert(table_id);
		var row = $('table#'+table_id+' tbody tr:last').clone();
		$("span."+table_id+"_num:first").text('1');
		var n = $("span."+table_id+"_num:last").text();

		var no = parseInt(n);
		var c = no + 1;

		if (c > 5) {
			alert('Maksimal 5 Row');
			return;
		}


		if (n.length == 0) {
			var row_content = '';
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';			
			
			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input class="iprinsipal_id'+c+'" type="hidden" name="iprinsipal_id[]"  size="15" />';
			row_content  += '<input class="vNama_prinsipal'+c+'" type="text" name="vNama_prinsipal[]" size="15" /></td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="vEmail[]" size="15" /></td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="dBerhasil_dihubungi[]" size="8" class="datepicker2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += 	vTahap_pembahasan;
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="dKirim_coa[]" size="8" class="datepicker2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="vNo_awb[]" size="20"  /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="dAggreement[]" size="8" class="datepicker2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="fHarga[]" size="8" class="angka2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="fHna[]" size="8" class="angka2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="fCogs[]" size="8" class="angka2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="fPrice_novell[]" size="8" class="angka2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="fPrice_principal[]" size="8" class="angka2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="fHpp_hna[]" size="8" class="angka2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="fMoq_novell[]" size="8" class="angka2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="fMoq_principal[]" size="8" class="angka2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += 	iPrincipal_terpilih;
			row_content  += '</td>';

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
			row_content  += '<input class="iprinsipal_id'+c+' required" type="hidden" name="iprinsipal_id[]"  size="15" />';
			row_content  += '<input class="vNama_prinsipal'+c+' required" type="text" name="vNama_prinsipal[]" size="15" /></td>';


			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" class="required" name="vEmail[]" size="15" /></td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="dBerhasil_dihubungi[]" size="8" class="datepicker2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += 	vTahap_pembahasan;
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="dKirim_coa[]" size="8" class="datepicker2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" class="required" name="vNo_awb[]" size="20"  /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="dAggreement[]" size="8" class="datepicker2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="fHarga[]" size="8" class="angka2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="fHna[]" size="8" class="angka2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="fCogs[]" size="8" class="angka2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="fPrice_novell[]" size="8" class="angka2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="fPrice_principal[]" size="8" class="angka2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="fHpp_hna[]" size="8" class="angka2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="fMoq_novell[]" size="8" class="angka2 required" /></td>';
			row_content  += '</td>';

			row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			row_content  += '<input type="text" name="fMoq_principal[]" size="8" class="angka2 required" /></td>';
			row_content  += '</td>';

			row_content  += '<td></td>';
			//row_content	 += '<td colspan="1" style="border: 1px solid #dddddd; width: 30%">';
			//row_content  += 	iPrincipal_terpilih;
			//row_content  += '</td>';

			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
			row_content	 += '<span class="delete_btn"><a href="javascript:;" class="brosur_bb_del" onclick="del_row(this, \'brosur_bb_del\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			$('table#'+table_id+' tbody tr:last').after(row_content);
           	$('table#'+table_id+' tbody tr:last input').val("");
			$('table#'+table_id+' tbody tr:last div').text("");
			$("span."+table_id+"_num:last").text(c);		
		}

		$(".datepicker2").datepicker({dateFormat:"yy-mm-dd" ,
							changeYear: true ,
							changeMonth: true 
							});

		$(".angka2").keyup(function(){
							 		this.value = this.value.replace(/[^0-9\.]/g,"");
	                        });
		$(".angka2").css('text-align','right');



		var config3 = {
			source: base_url+'processor/plc/import/analisa/principal?action=cariprinsipal&prinsip='+$('#prinsip').val()+'  ',					
			select: function(event, ui){
				var old_prinsip = $('#prinsip').val();
				$('.iprinsipal_id'+c).val(ui.item.id);						
				$('.vNama_prinsipal'+c).val(ui.item.vNama_prinsipal);	

				if ( old_prinsip =='') {
					$('#prinsip').val(ui.item.id);
				}else{
					$('#prinsip').val(old_prinsip+','+ui.item.id);
				}

			},
			minLength: 2,
			autoFocus: true,
		};

		$(".vNama_prinsipal"+c).livequery(function(){
			$(this).autocomplete(config3);
			var i = $('.vNama_prinsipal'+c).index(this);
			$(this).keypress(function(e){
				if(e.which != 13) {
					$('.iprinsipal_id'+c).val('');
				}			
			});
			$(this).blur(function(){
				if($('.iprinsipal_id'+c).val() == '') {
					$(this).val('');
				}			
			});
		})


}
</script>





<div id="kotak">
	<table class="hover_table" id="brosur_bb_upload" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
		<thead>
		<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
			<th colspan="18" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">DETAIL PRINCIPAL</span></th>
		</tr>
		<tr>
			<th rowspan="2" style="border: 1px solid #dddddd; width: 5%;" >No</th>
			<th rowspan="2" style="border: 1px solid #dddddd;">Nama Principal</th>
			<th rowspan="2" style="border: 1px solid #dddddd;">Email</th>
			<th rowspan="2" style="border: 1px solid #dddddd;">Berhasil<br> dihubungi</th>
			<th rowspan="2" style="border: 1px solid #dddddd;">Tahap Pembahasan</th>
			<th rowspan="2" style="border: 1px solid #dddddd;width: 5%;">Tgl Kirim <br> CDA</th>
			<th rowspan="2" style="border: 1px solid #dddddd;">No AWB</th>
			<th rowspan="2" style="border: 1px solid #dddddd;">Tgl Aggreement <br> Done</th>
			<th rowspan="2" style="border: 1px solid #dddddd;">Harga (USD)</th>
			<th rowspan="2" style="border: 1px solid #dddddd;">HNA <br> Novell(USD)</th>
			<th rowspan="2" style="border: 1px solid #dddddd;">COGS(USD)</th>
			


			<th colspan="2">Price Offering</th>
			<th colspan="2">MOQ Offering</th>
			<th rowspan="2" style="border: 1px solid #dddddd;">% <br>HPP vs HNA</th>
			<th rowspan="2" style="border: 1px solid #dddddd;">Principal Terpilih</th>

			<th rowspan="2"  style="border: 1px solid #dddddd; width: 5%;">Action</th>
		</tr>
		<tr>
			<th rowspan="1" style="border: 1px solid #dddddd;">Novell</th>
			<th rowspan="1" style="border: 1px solid #dddddd;">Principal</th>
			<th rowspan="1" style="border: 1px solid #dddddd;">Novell</th>
			<th rowspan="1" style="border: 1px solid #dddddd;">Principal</th>
		</tr>
		
		</thead>
		<tbody>
			
			<?php
				$val_prinsip= '0';
			
				$i = 1;
				$linknya = "";
				if(!empty($rows)) {

					foreach($rows as $row) {

						if ($i==1) {
							$val_prinsip =$row['iprinsipal_id'] ;							
						}else{
							$val_prinsip = $val_prinsip.','.$row['iprinsipal_id'] ;							
						}
						//tambahan untuk download file
			?>
					<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
						<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
							<span class="brosur_bb_upload_num"><?php echo $i ?></span>
						</td>	
						<td class="rec">
							<input class='iprinsipal_id required' type="hidden" name="iprinsipal_id[]" value="<?php echo $row['iprinsipal_id'] ?>" size="15">
							<input class='vNama_prinsipal required' name="vNama_prinsipal[]" value="<?php echo $row['vNama_prinsipal'] ?>" size="15">
						</td>
						<td class="rec"><input class="required" name="vEmail[]" value="<?php echo $row['vEmail'] ?>" size="15"></td>
						<td class="rec">
							<input  name="dBerhasil_dihubungi[]" class="datepicker2 required" size="8" value="<?php echo $row['dBerhasil_dihubungi'] ?>">
						</td>

						<td class="rec">
							<?php 
						        $lmarketing = array('Y'=>'Y','N'=>'N');
					            $o  = "<select name='vTahap_pembahasan[]' class='required' >";            
					            foreach($lmarketing as $k=>$v) {
					                if ($k == $row['vTahap_pembahasan']) $selected = " selected";
					                else $selected = "";
					                $o .= "<option {$selected} value='".$k."'>".$v."</option>";
					            }            
					            $o .= "</select>";
					            echo $o;
						 	?>
						</td>
						<td class="rec"><input  name="dKirim_coa[]" class="datepicker2 required" size="8" value="<?php echo $row['dKirim_coa'] ?>"></td>
						<td class="rec"><input class="required" name="vNo_awb[]" size="20" value="<?php echo $row['vNo_awb'] ?>"></td>
						<td class="rec"><input id="dAggreement" name="dAggreement[]" class="datepicker2 required" size="8" value="<?php echo $row['dAggreement'] ?>"></td>
						<td class="rec"><input name="fHarga[]" class="angka2 required" size="8" value="<?php echo $row['fHarga'] ?>"></td>
						<td class="rec"><input name="fHna[]" class="angka2 required" size="8" value="<?php echo $row['fHna'] ?>"></td>
						<td class="rec"><input name="fCogs[]"  class="angka2 required" size="8" value="<?php echo $row['fCogs'] ?>"></td>
						<td class="rec"><input name="fPrice_novell[]" class="angka2 required" size="8" value="<?php echo $row['fPrice_novell'] ?>"></td>
						<td class="rec"><input name="fPrice_principal[]" class="angka2 required" size="8" value="<?php echo $row['fPrice_principal'] ?>"></td>
						<td class="rec"><input name="fHpp_hna[]" class="angka2 required" size="8" value="<?php echo $row['fHpp_hna'] ?>"></td>
						<td class="rec"><input name="fMoq_novell[]" class="angka2 required" size="8" value="<?php echo $row['fMoq_novell'] ?>"></td>
						<td class="rec"><input name="fMoq_principal[]" class="angka2 required" size="8" value="<?php echo $row['fMoq_principal'] ?>"></td>

						<td class="rec">
							<?php 
								if ($row['iSubmit_prinsipal']==1) {
									# code...
							        $lmarketing = array('Y'=>'Y','N'=>'N');
						            $o  = "<select name='iPrincipal_terpilih[]' class='required cbpilih' >";     
						            $o  .= "<option value=''>Pilih</option>" ;
						            foreach($lmarketing as $k=>$v) {
						                if ($k == $row['iPrincipal_terpilih']) $selected = " selected";
						                else $selected = "";
						                $o .= "<option {$selected} value='".$k."'>".$v."</option>";
						            }            
						            $o .= "</select>";
						            echo $o;
					            }
						 	?>
						</td>

						
						<td style="border: 1px solid #dddddd; width: 10%">
							<?php if ($this->input->get('action') != 'view') { ?>
								<span class="delete_btn"><a href="javascript:;" class="brosur_bb_del" onclick="del_row(this, 'brosur_bb_del')">[Hapus]</a></span>	
							<?php	} ?>
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
						<td class="rec">
							<input class='iprinsipal_id required' name="iprinsipal_id[]" value='' size="15" type="hidden">
							<input  class='vNama_prinsipal required' name="vNama_prinsipal[]" value='' size="15" type="text">
						</td>
						<td class="rec"><input name="vEmail[]" class="required" value='' size="15" type="text"></td>
						<td class="rec">
							<input  name="dBerhasil_dihubungi[]" class="datepicker2 required" size="8" >
						</td>
						<td class="rec">
							<select class="required" name="vTahap_pembahasan[]">
								<option value="Y">Y</option>
								<option value="N">N</option>
							</select>

						</td>
						<td class="rec"><input  name="dKirim_coa[]" class="datepicker2 required" size="8" ></td>
						<td class="rec"><input class="required" name="vNo_awb[]" size="20" ></td>
						<td class="rec"><input id="dAggreement" name="dAggreement[]" class="datepicker2 required" size="8"></td>
						<td class="rec"><input name="fHarga[]" class="angka2 required" size="8"></td>
						<td class="rec"><input name="fHna[]" class="angka2 required" size="8"></td>
						<td class="rec"><input name="fCogs[]"  class="angka2 required" size="8"></td>
						<td class="rec"><input name="fPrice_novell[]" class="angka2 required" size="8"></td>
						<td class="rec"><input name="fPrice_principal[]" class="angka2 required" size="8" ></td>
						<td class="rec"><input name="fHpp_hna[]" class="angka2 required" size="8"></td>
						<td class="rec"><input name="fMoq_novell[]" class="angka2 required" size="8" ></td>
						<td class="rec"><input name="fMoq_principal[]" class="angka2 required" size="8" ></td>
						<td></td>
						<td style="border: 1px solid #dddddd; width: 10%;"><span class="delete_btn"><a href="javascript:;" class="brosur_bb_del" onclick="del_row(this, 'table_komposisi_upb_del')">[Hapus]</a></span></td>
						
					</tr>
			<?php } }?>
			<?php 
				// flag untuk validasi duplikat input prinsipal
			 ?>
			<input type="hidden" name="prinsip" id="prinsip" size="35" style="background-color:red;" value=<?php echo $val_prinsip ?> />
		</tbody>
		<tfoot>
			<tr>
				<td colspan="5"></td><td style="text-align: center">
					<?php if ($this->input->get('action') != 'view') { ?>
						<a href="javascript:;" onclick="javascript:add_row_brosur_upload('brosur_bb_upload')">Tambah</a>	
					<?php } ?>
					
				</td>
			</tr>
		</tfoot>
	</table>
</div>

	<script>
		$('#filekt1').keyup(function() {
		var len = this.value.length;
		if (len >= 250) {
		this.value = this.value.substring(0, 250);
		}
		$('#len1').text(250 - len);
		});


		$(".datepicker2").datepicker({dateFormat:"yy-mm-dd" ,
								changeYear: true ,
								changeMonth: true 
								});
		 $(".angka2").keyup(function(){
							 		this.value = this.value.replace(/[^0-9\.]/g,"");
	                        });
		 $(".angka2").css('text-align','right');


		 /*
		 principal terpilih lebih dari satu 
		 $(".cbpilih").live('change',function(){
		 	//$(".cbpilih").not(this).hide("slow");
		 	if ($(this).val() =='Y' ) {
		 		$(".cbpilih").not(this).val("N")
		 	}
		 });
		*/

	</script>
