<?php
	$rows 		= array();
	if (strtolower($act) == 'create'){
		$idRef 	= $form_field['id_refor'];
		$sql 	= 'SELECT d.*, r.vnama FROM reformulasi.export_req_refor_rawmaterial d 
					JOIN plc2.plc2_raw_material r ON d.raw_id = r.raw_id
					WHERE d.lDeleted = 0 AND d.iexport_req_refor = ? ';
		$rows 	= $this->db->query($sql, array($idRef))->result_array();
	} else {
		$idReq 	= $rowDataH['iexport_request_sample'];
		$sql 	= 'SELECT d.*, r.vnama, m2.id AS id_mr, CONCAT(m2.c_mrno, " - ", i.c_itnam, " (", m2.c_batchno, ")") AS no_mr
					FROM reformulasi.export_request_sample_detail d 
					JOIN plc2.plc2_raw_material r ON d.raw_id = r.raw_id
					LEFT JOIN purchase.mr02 m2 ON d.id_mr = m2.id
					LEFT JOIN purchase.mr01 m1 ON m2.c_mrno = m1.c_mrno AND m2.iCompanyID = m1.iCompanyID
					LEFT JOIN sales.itemas i ON m1.c_iteno = i.c_iteno AND m1.iCompanyID = i.iCompanyID
					WHERE d.iexport_request_sample = ? AND d.lDeleted = 0';
		$rows 	= $this->db->query($sql, array($idReq))->result_array(); 
	}

	$arrMR 		= array(1 => 'New', 2 => 'Existing');

	$controller = str_replace("_".$field, "", $id);
	$modulField = $form_field['iM_modul_fields'];

	$urlMR 		= base_url().'processor/reformulasi/'.$controller.'?action=searchMR&id_field='.$modulField;
	$urlRaw 	= base_url().'processor/reformulasi/'.$controller.'?action=searchRaw&id_field='.$modulField;


?>

<style type="text/css">
	.exp_permintaan_sample_raw_table{ 
		border 			: 2px #A1CCEE solid;
		padding 		: 5px;
		background 		: #fff;
		border-radius 	: 5px;
		width 			: 150%;
	}

	.exp_permintaan_sample_raw_table thead tr{    
		border 			: 1px solid #89b9e0;
	    text-align 		: center;
	    color 			: #FFFFFF;
	    background 		: -webkit-gradient(linear, left top, left bottom, from(#1e5f8f), to(#3496df)) repeat-x;
	    background 		: -moz-linear-gradient(top, #1e5f8f, #3496df) repeat-x;
	    text-transform 	: uppercase; 
	    padding 		: 5px;
	}

	.exp_permintaan_sample_raw_table tbody tr td{
		border 			: 1px #dddddd solid;
		padding 		: 3px;
		text-align 		: center;
	}

	.exp_permintaan_sample_raw_table tbody tr{
		border 			: 1px solid #ddd;
		border-collapse : collapse;
		background 		: #fff
	}

	.exp_permintaan_sample_raw_div{
		min-width 		: 99%; 
		overflow-x 		: scroll; 
		overflow-y 		: hidden; 
		white-space 	: nowrap;
	}
</style>

<div class="exp_permintaan_sample_raw_div">
	<table class="exp_permintaan_sample_raw_table" id="exp_permintaan_sample_raw_table" cellspacing="0" cellpadding="1">
		<thead>
			<tr>
				<th colspan="13"><?php echo $form_field['vDesciption'] ?></th>
			</tr>
			<tr>
				<!-- selalu aktif -->
				<th>No.</th>
				<th>Bahan Baku</th>
				<th>Material MR</th>

				<!-- field untuk sample baru -->
				<th>Qty</th>
				<th>Unit Size</th>
				<th>Spesifikasi</th>

				<!-- field untuk sample existing -->
				<th>Kekuatan</th>
				<th>Satuan</th>
				<th>Fungsi</th>
				<th>MR No.</th>
				<th>Tgl. MR</th>
				<th>Qty. MR</th>

				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
				if (count($rows) > 0){
					$num = 1;
					foreach ($rows as $row) {
						?>
							<tr>
								<td>
									<span class="exp_permintaan_sample_raw_table_num"><?php echo $num; ?></span>
									<input type="hidden" name="id_detail[]" value="<?php echo $row['iexport_request_sample_detail']; ?>" style="width: 90%" />
								</td>	
								<td>
									<input type="hidden" id="select_raw_<?php echo $num; ?>" name="raw_id[]" value="<?php echo $row['raw_id']; ?>" style="width: 90%" />
									<input type="text" id="select_raw_<?php echo $num; ?>_dis" value="<?php echo $row['vnama']; ?>" style="width: 90%" />
								</td>	
								<td>
									<select id="select_mr_<?php echo $num; ?>" name="material_mr[]" onchange="changeMR('<?php echo $num; ?>')">
									<?php
										foreach ($arrMR as $id => $val){
											$selected = ( $id == $row['iMaterialMR'] ) ? 'selected' : '';
											echo '<option '.$selected.' value="'.$id.'">'.$val.'</option>';
										}
									?>
									</select>
								</td>

								<!-- Field untuk sample new -->
								<td>
									<input class="type_new_<?php echo $num; ?> angka" type="number" min="1" id="raw_qty_<?php echo $num; ?>" type="text" name="qty[]" value="<?php echo $row['iJumlah']; ?>" style="width: 90%" />
								</td>
								<td>
									<input class="type_new_<?php echo $num; ?>" id="raw_size_<?php echo $num; ?>" type="text" name="size[]" value="<?php echo $row['vUnitSize']; ?>" style="width: 90%" />
								</td>
								<td>
									<input class="type_new_<?php echo $num; ?>" id="raw_spek_<?php echo $num; ?>" type="text" name="spesifikasi[]" value="<?php echo $row['vSpesifikasi']; ?>" style="width: 90%" />
								</td>
								<!-- Field untuk sample new -->

								<!-- field untuk sample existing -->
								<td>
									<input class="type_existing_<?php echo $num; ?>" id="raw_kekuatan_<?php echo $num; ?>" type="text" name="kekuatan[]" value="<?php echo $row['vKekuatan']; ?>" style="width: 90%" />
								</td>
								<td>
									<input class="type_existing_<?php echo $num; ?>" type="text" id="satuan_<?php echo $num; ?>" name="satuan[]" value="<?php echo $row['vSatuan']; ?>" style="width: 90%" />
								</td>
								<td>
									<input class="type_existing_<?php echo $num; ?>" type="text" name="fungsi[]" value="<?php echo $row['vFungsi']; ?>" style="width: 90%" />
								</td>
								<td>
									<input class="type_existing_<?php echo $num; ?>" type="hidden" id="mr_no_<?php echo $num; ?>" name="mr_no[]" value="<?php echo $row['id_mr']; ?>" style="width: 90%" />
									<input class="type_existing_<?php echo $num; ?>" type="text" id="mr_no_<?php echo $num; ?>_dis" value="<?php echo $row['no_mr']; ?>" style="width: 90%" />
								</td>
								<td>
									<input class="type_existing_<?php echo $num; ?>" type="text" id="tgl_mr_<?php echo $num; ?>" name="tgl_mr[]" value="<?php echo $row['dTgl_mr']; ?>" style="width: 70%" />
								</td>
								<td>
									<input class="type_existing_<?php echo $num; ?> angka" type="number" min="1" type="text" id="qty_mr_<?php echo $num; ?>" name="qty_mr[]" value="<?php echo $row['iQty_mr']; ?>" style="width: 90%" />
								</td>
								<!-- field untuk sample existing -->

								<td>
									<span class="exp_permintaan_sample_raw_table_delete_btn">
										<a href="javascript:;" class="exp_permintaan_sample_raw_table_del" onclick="del_row(this, 'exp_permintaan_sample_raw_table_del')">[Hapus]</a>
									</span>
								</td>
							</tr>
							<script type="text/javascript">
								changeMR(<?php echo $num; ?>);
								setAutoComplete(<?php echo $num; ?>);
								setDatePicker(<?php echo $num; ?>);
							</script>
						<?php
						$num ++;
					}
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="12"></td>
				<!-- <td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row('exp_permintaan_sample_raw_table')">Tambah</a></td> -->
				<td style="text-align: center"><a href="javascript:;" onclick="javascript:add_row_raw2()">Tambah1</a></td>
			</tr>
		</tfoot>
	</table>
	<br><br><br><br>
</div>

<script>
	$(".angka").numeric();
	function setDropDown(num){
		$("#select_raw_"+num).chosen();
		// $("#select_raw_"+num).chosen({
	 //        allow_single_deselect: true
	 //    });
	 //    $(function() {
	 //        var els = jQuery("#select_raw_"+num);
	 //        els.chosen({no_results_text: "No results matched"});
	 //        els.on("liszt:showing_dropdown", function () {
	 //                $(this).parents("div").css("overflow", "visible");
	 //            });
	 //        els.on("liszt:hiding_dropdown", function () {
	 //                $(this).parents("div").css("overflow", "");
	 //            });
	 //    });
	}

	function setAutoComplete(num){
		//auto complete untuk nomor mr
		$('#mr_no_'+num+'_dis').live('keyup', function(e) {
            var config = {
	            source 		: '<?php echo $urlMR; ?>',          
	            select 	 	: function(event, ui){
	                $('#mr_no_'+num).val(ui.item.id);
	                $('#mr_no_'+num+'_dis').val(ui.item.value);   
	                $('#tgl_mr_'+num).val(ui.item.d_mrdate);   
	                $('#qty_mr_'+num).val(ui.item.n_qty);   
	                return false;                           
	            },
	            minLength 	: 2,
	            autoFocus 	: true,
            }; 
            $('#mr_no_'+num+'_dis').autocomplete(config);  
            $(this).keypress(function(e){
                if(e.which != 13) {
                    $('#mr_no_'+num).val('');
                }           
            });
            $(this).blur(function(){
                if($('#mr_no_'+num).val() == '') {
                    $(this).val('');
                }           
            });

        }); 

        //auto complete untuk raw material
        $('#select_raw_'+num+'_dis').live('keyup', function(e) {
            var config = {
	            source 		: '<?php echo $urlRaw; ?>',          
	            select 	 	: function(event, ui){
	                $('#select_raw_'+num).val(ui.item.id);
	                $('#select_raw_'+num+'_dis').val(ui.item.value);   
	                $('#raw_size_'+num).val(ui.item.vsatuan);     
	                $('#satuan_'+num).val(ui.item.vsatuan);   
	                return false;                           
	            },
	            minLength 	: 2,
	            autoFocus 	: true,
            }; 
            $('#select_raw_'+num+'_dis').autocomplete(config);  
            $(this).keypress(function(e){
                if(e.which != 13) {
                    $('#select_raw_'+num).val('');
                }           
            });
            $(this).blur(function(){
                if($('#select_raw_'+num).val() == '') {
                    $(this).val('');
                }           
            });

        }); 
	}


 	function setDatePicker(num){
		 $("#tgl_mr_"+num).datepicker({
			 	changeMonth 	: true,
				changeYear 		: true,
				dateFormat 		: "yy-mm-dd", 
				showOn 			: "button",
				buttonImage 	: base_url+"assets/images/calendar.gif",
				buttonImageOnly : true,
				buttonText 		: "Select date"
			}).attr('readonly','readonly');
 	}

	 function changeMR (num){
	 	var mr_no = $("#select_mr_"+num).val();
	 	if (mr_no == 1){
	 		$(".type_existing_"+num).prop('readonly', true);
	 		$(".type_existing_"+num).val('');
	 		$(".type_existing_"+num).removeClass('required');
	 		$(".type_existing_"+num).parent().css({ 'background-color' : 'white' });
	 		$(".type_new_"+num).parent().css({ 'background-color' : '#b3d2ea' });
	 		$(".type_new_"+num).addClass('required');
	 		$(".type_new_"+num).removeAttr('readonly');
	 	} else {
	 		$(".type_new_"+num).prop('readonly', true);
	 		$(".type_new_"+num).val('');
	 		$(".type_new_"+num).removeClass('required');
	 		$(".type_new_"+num).parent().css({ 'background-color' : 'white' });
	 		$(".type_existing_"+num).parent().css({ 'background-color' : '#b3d2ea' });
	 		$(".type_existing_"+num).addClass('required');
	 		$(".type_existing_"+num).removeAttr('readonly'); 		
	 	}
	 }

	 <?php
	 	if(count($rows) == 0){
	 		?>
	 			add_row_raw2();
	 		<?php
	 	}
	 ?>

	function add_row_raw2() {
		var num 	= $("span.exp_permintaan_sample_raw_table_num:last").text();
		var row 	= $('table#exp_permintaan_sample_raw_table tbody tr:last').clone();

		var numlast = ( num.length == 0 ) ? 1 : (parseInt(num) + 1);

		var content = '';
		content 	+= '<tr>';
		content 	+= '	<td>';
		content 	+= '		<span class="exp_permintaan_sample_raw_table_num">'+numlast+'</span>';
		content 	+= '		<input type="hidden" name="id_detail[]" value="" style="width: 90%" />';
		content 	+= '	</td>';
		content 	+= '	<td>';
		content 	+= '		<input type="hidden" id="select_raw_'+numlast+'" name="raw_id[]" value="" style="width: 90%" />';
		content 	+= '		<input type="text" id="select_raw_'+numlast+'_dis" value="" style="width: 90%" />';
		content 	+= '	</td>';
		content 	+= '	<td>';
		content 	+= '		<select id="select_mr_'+numlast+'" name="material_mr[]" onchange="changeMR('+numlast+')">';
		<?php
			foreach ($arrMR as $id => $val){
				?>
					var id 		= "<?php echo $id; ?>";
					var val 	= "<?php echo $val; ?>";
					content 	+= '	<option value="'+id+'">'+val+'</option>';
				<?php
			}
		?>
		content 	+= '		</select>';
		content 	+= '	</td>';

		// field untuk sample new
		content 	+= '	<td>';
		content 	+= '		<input class="type_new_'+numlast+' angka" type="number" min="1" id="raw_qty_'+numlast+'" type="text" name="qty[]" value="" style="width: 90%" />';
		content 	+= '	</td>';
		content 	+= '	<td>';
		content 	+= '		<input class="type_new_'+numlast+'" id="raw_size_'+numlast+'" type="text" name="size[]" value="" style="width: 90%" />';
		content 	+= '	</td>';
		content 	+= '	<td>';
		content 	+= '		<input class="type_new_'+numlast+'" id="raw_spek_'+numlast+'" type="text" name="spesifikasi[]" value="" style="width: 90%" />';
		content 	+= '	</td>';
		// field untuk sample new

		//field untuk sample existing
		content 	+= '	<td>';
		content 	+= '		<input class="type_existing_'+numlast+'" id="raw_kekuatan_'+numlast+'" type="text" name="kekuatan[]" value="" style="width: 90%" />';
		content 	+= '	</td>';

		content 	+= '	<td>';
		content 	+= '		<input class="type_existing_'+numlast+'" type="text" id="satuan_'+numlast+'" name="satuan[]" value="" style="width: 90%" />';
		content 	+= '	</td>';
		content 	+= '	<td>';
		content 	+= '		<input class="type_existing_'+numlast+'" type="text" name="fungsi[]" value="" style="width: 90%" />';
		content 	+= '	</td>';
		content 	+= '	<td>';
		content 	+= '		<input class="type_existing_'+numlast+'" type="hidden" id="mr_no_'+numlast+'" name="mr_no[]" value="" style="width: 90%" />';
		content 	+= '		<input class="type_existing_'+numlast+'" type="text" id="mr_no_'+numlast+'_dis" value="" style="width: 90%" />';
		content 	+= '	</td>';
		content 	+= '	<td>';
		content 	+= '		<input class="type_existing_'+numlast+'" type="text" id="tgl_mr_'+numlast+'" name="tgl_mr[]" value="" style="width: 70%" />';
		content 	+= '	</td>';
		content 	+= '	<td>';
		content 	+= '		<input class="type_existing_'+numlast+' angka" type="number" min="1" id="qty_mr_'+numlast+'" name="qty_mr[]" value="" style="width: 90%" />';
		content 	+= '	</td>';
		//field untuk sample existing

		content 	+= '	<td colspan="12">';
		content 	+= '		<span class="exp_permintaan_sample_raw_table_delete_btn">';
		content 	+= '			<a href="javascript:;" class="exp_permintaan_sample_raw_table_del" onclick="del_row(this, \'exp_permintaan_sample_raw_table_del\')">[Hapus]</a>';
		content 	+= '		</span>';		
		content 	+= '	</td>';
		content 	+= '</tr>';

		jQuery("#exp_permintaan_sample_raw_table tbody").append(content);
		changeMR(numlast);
		setAutoComplete(numlast);
		setDatePicker(numlast);
	}
</script>