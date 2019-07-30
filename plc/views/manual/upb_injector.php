
<style type="text/css">
	.tabel1{
      border-radius: 10px 10px 10px 10px; box-shadow: 0px 0px 2px rgb(0, 0, 0); opacity: 1;
      background-color: #fff;
      height: 100%;
      width: 100%;
      float: left;
      margin-right: 2%;
      padding-left: 1%;
      margin-bottom: 20px;

    }
    .tabel2{
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

    }

    #kotak{
    	
    	margin-right: 5%;
    	margin-left: 5%;
    	margin-top: 20px;
    	margin-bottom: 20px;
    }

</style>


<?php 
	$this->load->view('manual/jsFunction');
 ?>
<div id="formnya">
	<table>
		<tr>
			<td>
				Tipe 
			</td>
			<td> 
				<select id="iTipe" class="input">
					<option value="">--Select--</option>
					<option value="1" >Local Non-OTC</option>
					<!-- <option value="6">Local OTC</option> -->
				</select>
			</td>
		</tr>
		<tr>
			<td>
				
					<?php 
					$sql='select * from plc2.master_proses a where a.lDeleted=0 and  a.idplc2_biz_process_type=00';
					$proses = $this->db_plc0->query($sql)->result_array();
					//echo $sql;
						//$proses = $this->db_plc0->get_where('plc2.master_proses', array('lDeleted' => 0,'idplc2_biz_process_type' => '6'))->result_array();
				    	$o = '<select id="module_id" name="module_id" class="input" style="width: 300px">';
				    	$o .= '<option value="">--Select--</option>';
				    	foreach ($proses as $t) {
				    		$o .= '<option value="'.$t['master_proses_id'].'">'.$t['vKode_modul'].' - '.$t['vNama_modul'].'</option>';
				    	}
				    	$o .= '</select>';
				    	
					 ?>
						Inject sampai Modul
				
			</td>
			<td>
				<div id="ddModule">
					<?php echo $o ?>
				</div>
				
			</td>
		</tr>
		<tr>
			<td>
				<p id="lbl_cek">Key</p>
			</td>
			<td>
				<?php 
					$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
					$return .= '<input type="hidden" name="id" id="id" class="input_rows1 required" />';
					$return .= '<input type="text" name="id_dis" disabled="TRUE" id="id_dis" class="input_rows1" size="35" />&nbsp;';
					$return .= '<button class="icon_pop btn_iupbid"  onclick="browse(\''.base_url().'processor/plc/upb/injector/popup?field=checkinput\',\'List UPB\')" type="button">&nbsp;</button>';
					$return .= '<button class="icon_pop btn_iforid"  onclick="browse(\''.base_url().'processor/plcotc/browse/formula/check?field=checkinput\',\'List Formula\')" type="button">&nbsp;</button>';
					echo $return;

				 ?>
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

<div id="kotak">
	<div style="" class="tabel1" id="rkotak"><h3><span>Result</span></h3></div>
	<!-- <div style="" class="tabel2" id="red"></div>	 -->
	
</div>

<br>
<br>
<br>

 

<br>
<h3>Keterangan</h3>
<hr>
<div style="" id="detail_hint2" class="tabel3">
	<table cellpadding="3">
		<tr>
			<td>SKIP</td>
			<td>:</td>
			<td>Data sudah ada atau Data sudah dilewati/tidak dilewati</td>
		</tr>
		<tr>
			<td>Insert Berhasil</td>
			<td>:</td>
			<td>Insert data pada module berhasil (Dummy jika tidak ada data / Insert Menggunakan Data Lama)</td>
		</tr>
		<tr>
			<td>Insert Gagal</td>
			<td>:</td>
			<td>Insert data pada module gagal</td>
		</tr>
		<tr>
			<td>Update Berhasil</td>
			<td>:</td>
			<td>Update data pada module berhasil</td>
		</tr>
		<tr>
			<td>Update Gagal</td>
			<td>:</td>
			<td>Insert data pada module gagal</td>
		</tr>
		<tr>
			<td>Approval Berhasil</td>
			<td>:</td>
			<td>Approval data pada module berhasil</td>
		</tr>
		<tr>
			<td>Approval Gagal</td>
			<td>:</td>
			<td>Approval data pada module gagal</td>
		</tr>
	</table> 

</div>

<script type="text/javascript">
	<?php $url3 = base_url()."processor/plc/upb/injector/?action=getddModul";  ?>
	$("#iTipe").die();
	$("#iTipe").live("change",function(){
		var pal = $(this).val();
		return $.ajax({
			 url: "<?php echo $url3 ?>",
			 data: 'iTipe='+pal,
			 type: 'post',
			 beforeSend: function() {
				// $('#data_breakdown').html('<img src="'+loading_image_login+'" />');
			 },
			 success: function(data){
				 $('#ddModule').html(data);
			 }
		 }).responseText;


	})

	

</script>