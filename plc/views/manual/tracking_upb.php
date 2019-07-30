
<style type="text/css">
	.tabel1{
      border-radius: 10px 10px 10px 10px; box-shadow: 0px 0px 2px rgb(0, 0, 0); opacity: 1;
      background-color: #fff;
      height: 150px;
      width: 200px;
      float: left;
      margin-right: 2%;
    }
    /*.tabel2{
      border-radius: 10px 10px 10px 10px; box-shadow: 0px 0px 2px rgb(0, 0, 0); opacity: 1;
      background-color: #fff;
      height: 100%;
      width: 45%;
      float: left;
    }

    .tabel31{
      border-radius: 10px 10px 10px 10px; box-shadow: 0px 0px 2px rgb(0, 0, 0); opacity: 1;
      background-color: #fff;
      height: 99%;
      width: 100%;

    }
    
    .tabel3{
      border-radius: 3px 3px 3px 3px; box-shadow: 0px 0px 2px rgb(0, 0, 0); opacity: 1;
      background-color: #fff;
      height: 99%;
      width: 100%;

    }*/

    #kotak{
    	width: 100%;
    	float: left;
    	height: 100%;
    }

</style>


<?php 
	//$this->load->view('manual/jsFunction');
 ?>
<div id="formnya">
	<table>
		<tr>
			<td>
				
					<?php 
					$sql='select * from plc2.plc2_upb a where a.ldeleted=0';
					$proses = $this->db->query($sql)->result_array();
					//echo $sql;
				    	$o = '<select id="iupb_id" name="iupb_id" class="input" style="width: 300px">';
				    	$o .= '<option value="">--Select--</option>';
				    	foreach ($proses as $t) {
				    		$o .= '<option value="'.$t['iupb_id'].'">'.$t['vupb_nomor'].' - '.$t['vupb_nama'].'</option>';
				    	}
				    	$o .= '</select>';
				    	
					 ?>
						NO UPB
				
			</td>
			<td>
				<div id="ddModule">
					<?php echo $o ?>
				</div>
				
			</td>
		</tr>

		<tr>
			<td></td>
			<td>

				<div style="padding:2px;">
					<button id="submit" class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false"><span class="ui-button-icon-primary ui-icon ui-icon-disk"></span><span class="ui-button-text">Submit</span></button>
					<button id="reset" class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false"><span class="ui-button-icon-primary ui-icon ui-icon-disk"></span><span class="ui-button-text">Reset</span></button>
				</div>
			</td>
		</tr>
	</table>
</div>

<hr>
<br>
<br>

<div id="kotak"  style="text-align:center;">
	<!-- <div style="" class="tabel1" id="rkotak"><h3><span>Result</span></h3></div> -->
</div>

<!-- <div id="div_requirement"></div>

<br>
<h3>Detail</h3> -->

<!-- <div style="" id="detail_hint" class="tabel3"> </div> -->

<script type="text/javascript">

	$("#reset").die();
	$("#reset").live("click",function(){

		$("#iupb_id").val("");
		
		
	})

	<?php $url3 = base_url()."processor/plc/partial/view/?action=getModulfromFlow";  ?>
	$("#iupb_id").die();
	$("#iupb_id").live("change",function(){
		var pal = $(this).val();
		return $.ajax({
			 url: "<?php echo $url3 ?>",
			 data: 'iupb_id='+pal,
			 type: 'post',
			 beforeSend: function() {
				// $('#data_breakdown').html('<img src="'+loading_image_login+'" />');
			 },
			 success: function(data){
				 $('#kotak').html(data);
			 }
		 }).responseText;


	})

	

</script>