<?php 
	/*
		echo $row_value;
		echo "<br>";
		echo $hasTeamID;
	*/

		//print_r($rowDataH);

		$ipatent_new = 0;
		if ($act != "create"){
			$ipatent_new = $rowDataH['ipatent_new'];
		}

?>

<script type="text/javascript">
	var patent = "<?php echo $ipatent_new; ?>";
	if( patent == 2 ){
		$('#daftar_upb_detail_patent').show();	
		
		$('#iPatent_ind').prop('checked', true);
		$('#iPatent_ind_exp').addClass('required');
		$('#iPatent_ind_info').addClass('required');

		$('#iPatent_int').prop('checked', true);
		$('#iPatent_int_exp').addClass('required');
		$('#iPatent_int_info').addClass('required');

	}else{
		$('#daftar_upb_detail_patent').hide();

		$('#iPatent_ind').prop('checked', false);
		$('#iPatent_ind_exp').removeClass('required');
		$('#iPatent_ind_info').removeClass('required');

		$('#iPatent_int').prop('checked', false);
		$('#iPatent_int_exp').removeClass('required');
		$('#iPatent_int_info').removeClass('required');

	}

	$('#v3_daftar_upb_ipatent_new').die();
	$('#v3_daftar_upb_ipatent_new').live('change',function(){
		//alert($(this).val());
		if( $(this).val() == 2 ){
			$('#daftar_upb_detail_patent').show();	
			
			$('#iPatent_ind').prop('checked', true);
			$('#iPatent_ind_exp').addClass('required');
			$('#iPatent_ind_info').addClass('required');

			$('#iPatent_int').prop('checked', true);
			$('#iPatent_int_exp').addClass('required');
			$('#iPatent_int_info').addClass('required');

			


		}else{
			$('#daftar_upb_detail_patent').hide();

			$('#iPatent_ind').prop('checked', false);
			$('#iPatent_ind_exp').removeClass('required');
			$('#iPatent_ind_info').removeClass('required');

			$('#iPatent_int').prop('checked', false);
			$('#iPatent_int_exp').removeClass('required');
			$('#iPatent_int_info').removeClass('required');

		}
		
		
	})


	$("#iPatent_ind").change(function() {
	    var ischecked= $(this).is(':checked');
	    if(!ischecked){

	    	$('#iPatent_ind').prop('checked', false);
			$('#iPatent_ind_exp').removeClass('required');
			$('#iPatent_ind_info').removeClass('required');


			$('#iPatent_int').prop('checked', true);
			$('#iPatent_int_exp').addClass('required');
			$('#iPatent_int_info').addClass('required');

	    } else {

			$('#iPatent_ind_exp').addClass('required');
			$('#iPatent_ind_info').addClass('required');

	    }
	    
	}); 


	$("#iPatent_int").change(function() {
	    var ischecked= $(this).is(':checked');
	    if(!ischecked){
			
			$('#iPatent_int').prop('checked', false);
			$('#iPatent_int_exp').removeClass('required');
			$('#iPatent_int_info').removeClass('required');


			$('#iPatent_ind').prop('checked', true);
			$('#iPatent_ind_exp').addClass('required');
			$('#iPatent_ind_info').addClass('required');
			
	    } else {

			$('#iPatent_int_exp').addClass('required');
			$('#iPatent_int_info').addClass('required');
			
	    }
	    
	}); 



	 $("#iPatent_ind_exp").mask('0000-00');
	 $("#iPatent_int_exp").mask('0000-00');

	 $(".nextdatepicker").datepicker({
	 	changeMonth:true,
		changeYear:true,
		changeDay:false,
		// minDate: dateToday,
		showOn: "button",
		buttonImage: base_url+"assets/images/calendar.gif",
		buttonImageOnly: true,
		buttonText: "Select date",
		dateFormat:"yy-mm",
        showButtonPanel: true,
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
	});

</script>



<?php 
	$displayn = '';
	if($act == 'create'){
		// if ($rowDataH['ipatent_new'] == 2) {
		// 	// jika patent 
		// 	$displayn ='style="display: block;"';	
		// }else{
		// 	// jika off patent
		// 	$displayn ='style="display: none;"';	
		// }
		
?>
	<div id="daftar_upb_detail_patent" style="display: none;">
		<table class="hover_table" id="file_upload" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse" cellspacing="0" cellpadding="1">
			<thead>
				<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
					<th style="border: 1px solid #dddddd;">
						<span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">
							<input type="checkbox" value="1"  name="iPatent_ind" id="iPatent_ind" class="angka input_rows1 required"> Patent Ind ( HKI )
						</span>
					</th>
					<th style="border: 1px solid #dddddd;">
						<span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">
							<input type="checkbox" value="1" name="iPatent_int" id="iPatent_int" class="angka input_rows1 required"> Patent Int ( WEB )
						</span>
					</th>
				</tr>
			
			</thead>
			<tbody>
						<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
							<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
								<table style="width: 100%;" border="0">
									<tbody>
										<tr>
											<td width="40%">Patent Exp</td>
											<td>:</td>
											<td width="60%">
												<input type="text" placeholder="yyyy-mm" name="iPatent_ind_exp" id="iPatent_ind_exp" readonly="readonly" class="input_rows1 nextdatepicker" size="10" >
											</td>
										</tr>
										<tr>
											<td width="40%">Informasi Hak Paten</td>
											<td>:</td>
											<td width="60%">
												<textarea  class="input_rows1 " rows="3" cols="200" name="iPatent_ind_info" id="iPatent_ind_info" ></textarea>
											</td>
										</tr>		
										
									</tbody>	
								</table>
							</td>		
							<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
								<table style="width: 100%;" border="0">
									<tbody>
										<tr>
											<td width="40%">Patent Exp</td>
											<td>:</td>
											<td width="60%">
												<input type="text" placeholder="yyyy-mm" name="iPatent_int_exp" id="iPatent_int_exp" readonly="readonly" class=" input_rows1 nextdatepicker" size="10" >
											</td>
										</tr>
										<tr>
											<td width="40%">Informasi Hak Paten</td>
											<td>:</td>
											<td width="60%">
												<textarea  class="input_rows1 " rows="3" cols="200" name="iPatent_int_info" id="iPatent_int_info" ></textarea>
											</td>
										</tr>		
										
									</tbody>	
								</table>
							</td>		
						</tr>
					</tbody>

		</table>
		
	</div>


<?php 
	}else{
		$checkediPatent_ind = '';
		$checkediPatent_int = '';
		if (($rowDataH['iPatent_ind'] == "1")) {
	        $checkediPatent_ind = 'checked';
	    }else{
			$displayn = 'style="display: none;"';	
		}

	    if (($rowDataH['iPatent_int'] == "1")) {
	        $checkediPatent_int = 'checked';
	    }else{
			$displayn = 'style="display: none;"';	
		}


?>		
	<div id="daftar_upb_detail_patent" <?php echo $displayn ?> >
		<table class="hover_table" id="file_upload" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse" cellspacing="0" cellpadding="1">
			<thead>
				<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
					<th style="border: 1px solid #dddddd;">
						<span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">
							<input type="checkbox" value="1"  name="iPatent_ind" id="iPatent_ind" <?php echo $checkediPatent_ind ?> class="angka input_rows1 required"> Patent Ind ( HKI )
						</span>
					</th>
					<th style="border: 1px solid #dddddd;">
						<span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">
							<input type="checkbox" value="1" name="iPatent_int" id="iPatent_int" <?php echo $checkediPatent_int ?> class="angka input_rows1 required"> Patent Int ( WEB )
						</span>
					</th>
				</tr>
			
			</thead>
			<tbody>
						<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
							<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
								<table style="width: 100%;" border="0">
									<tbody>
										<tr>
											<td width="40%">Patent Exp</td>
											<td>:</td>
											<td width="60%">
												<input type="text" value="<?php echo $rowDataH['iPatent_ind_exp'] ?> "  name="iPatent_ind_exp" id="iPatent_ind_exp" readonly="readonly" class=" input_rows1 nextdatepicker" size="10" >
											</td>
										</tr>
										<tr>
											<td width="40%">Informasi Hak Paten</td>
											<td>:</td>
											<td width="60%">
												<textarea  class="input_rows1 " rows="3" cols="200" name="iPatent_ind_info" id="iPatent_ind_info" ><?php echo nl2br($rowDataH['iPatent_ind_info']) ?></textarea>
											</td>
										</tr>		
										
									</tbody>	
								</table>
							</td>		
							<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
								<table style="width: 100%;" border="0">
									<tbody>
										<tr>
											<td width="40%">Patent Exp</td>
											<td>:</td>
											<td width="60%">
												<input type="text" value="<?php echo $rowDataH['iPatent_int_exp'] ?> "  name="iPatent_int_exp" id="iPatent_int_exp" readonly="readonly" class=" input_rows1 nextdatepicker" size="10" >
											</td>
										</tr>
										<tr>
											<td width="40%">Informasi Hak Paten</td>
											<td>:</td>
											<td width="60%">
												<textarea  class="input_rows1 " rows="3" cols="200" name="iPatent_int_info" id="iPatent_int_info" ><?php echo nl2br($rowDataH['iPatent_int_info']) ?></textarea>
											</td>
										</tr>		
										
									</tbody>	
								</table>
							</td>		
						</tr>
					</tbody>

		</table>
		
	</div>


<?php 
	}
 ?>		