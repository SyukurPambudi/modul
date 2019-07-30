<?php 
	$this->load->library('lib_plc');
	$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'PD' AND d.iTipe=1 AND d.ldeleted = 0 ORDER BY d.iteam_id ASC";
	$team_pd = $this->db->query($sql)->result_array();

	$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'QA' AND d.iTipe=1 AND d.ldeleted = 0 ORDER BY d.iteam_id ASC";
	$team_qa = $this->db->query($sql)->result_array();

	$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'MR' AND d.iTipe=1 AND d.ldeleted = 0 ORDER BY d.iteam_id ASC";
	$team_mr = $this->db->query($sql)->result_array();


	$browse_url = base_url().'processor/plc/browse/upb/setprareg?action=index';
	$browse_url1 = base_url().'processor/plc/browse/detail/upb?action=index';

	/*print_r($rowDataH);
	echo $act;*/
	$statuses = array(''=>'--Select--', 2=>'Approve',1=>'Reject');
	$statusesNew  = '<select class="dropdon required " name="iappdireksi[]" required="required" >';            
    foreach($statuses as $k=>$v) {
        $statusesNew .= '<option value="'.$k.'">'.$v.'</option>';
    }            
    $statusesNew .= '</select>';


    $oNew = '<select class="required  dropdon" name="iteampd_id[]" >';
    /*$oNew .= '<option value="">--Select--</option>';*/
    $oNew .= '<option value="0" >-</option>';
    foreach ($team_pd as $t) {
        $oNew .= '<option  value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    }
	$oNew .= '</select>';
	

	$oNew2 = '<select class="required  dropdon" name="iteamqa_id[]" >';
    /*$oNew .= '<option value="">--Select--</option>';*/
    $oNew2 .= '<option value="0" >-</option>';
    foreach ($team_qa as $t) {
        $oNew2 .= '<option  value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    }
	$oNew2 .= '</select>';

	$oNew3 = '<select class="required  dropdon" name="iteammarketing_id[]" >';
    /*$oNew .= '<option value="">--Select--</option>';*/
    $oNew3 .= '<option value="0" >-</option>';
    foreach ($team_mr as $t) {
        $oNew3 .= '<option  value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
    }
	$oNew3 .= '</select>';
	

    
    



?>


<script type="text/javascript">
	$("label[for=\'v3_setting_prioritas_form_detail_detail_upb\']").siblings().css('margin-left',0);
	$("label[for=\'v3_setting_prioritas_form_detail_detail_upb\']").remove();

	$(".moveUpprio,.moveDownprio").live('click', function(){
        var row = $(this).parents("tbody tr:first");
        if ($(this).is(".moveUpprio")) {
            row.insertBefore(row.prev());
        } else {
            row.insertAfter(row.next());
        }
    });

    function add_row_prio(table_id){		
    	//alert('masuk');

		var row = $('table#'+table_id+' tbody tr:last').clone(true);
		$("span."+table_id+"_num:first").text('1');
		var n = $("span."+table_id+"_num:last").text();
		var no = parseInt(n);
		var c = no + 1;
		
		if (n.length == 0) {
			/*alert('atas');*/
			var c = 1;
			var row_content = '';
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';		

			row_content	 += '<td style="border: 1px solid #dddddd; width: 15%; text-align: left">';
				row_content	 += '<input type="hidden" name="iupb_id[]" class="upb_set_prio_upb_id upb_id" />';
				row_content	 += '<input type="hidden" name="upb_idi[]" class="upb_idi" />';

				row_content	 += '<input readonly="readonly" style="width: 60%" class="input_tgl upb_set_prio_upbno" type="text" name="iupb_nomor" />';
																																																							//row_content	 += 'onclick="del_row1(this, \'<?php echo $nmfield ?>_del\')';
				
				row_content  += '<button class="btn_browse_upb icon_pop ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only" onclick="javascript:get_upb_exists();javascript:browse_multi1_setting_prioritas_prareg(\'<?php echo $browse_url ?>&pdId=<?php echo $t['iteam_id'] ?>\',\'List UPB\',this,\'iupb_id=\'+$(\'.list_upbid_exists\').val());return false;"  type="button" role="button" aria-disabled="false" title="">';	
					row_content	 += '<span class="ui-button-icon-primary ui-icon ui-icon-newwin"></span>';
					row_content	 += '<span class="ui-button-text">&nbsp;</span>';
				row_content	 += '</button>';

				row_content  += '<button style="display:none;" class="btn_browse_upb_detail ui-icon-lightbulb ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only" onclick="javascript:browse_detail_upb(\'<?php echo $browse_url1 ?>&iupb_id=GANTI_UPB\',\'Detail UPB\',this,\'iupb_id=GANTI_UPB\');return false;"  type="button" role="button" aria-disabled="false" title="Detail UPB">';	
					row_content	 += '<span class="ui-button-icon-primary ui-icon ui-icon-lightbulb"></span>';
					row_content	 += '<span class="ui-button-text">&nbsp;</span>';
				row_content	 += '</button>';

				row_content	 += '<input type="hidden" name="list_upbid_exists" class="list_upbid_exists" value=""/>';

			row_content  += '</td>';

			row_content	 += '<td style="border: 1px solid #dddddd; width: 40%; text-align: left">';
				row_content	 += '<div class="upb_set_prio_generik"></div>';
				row_content  += '<input class="iUrut" type="hidden" name="iUrut[]"> </span>';	
			row_content  += '</td>';

			row_content	 += '<td style="border: 1px solid #dddddd; width: 15%;text-align: left;">';


			row_content  += '<span id="statusesNew_'+c+'" ><?php echo $statusesNew ?></span>';
			row_content  += '</td>';

			row_content	 += '<td style="border: 1px solid #dddddd; width: 15%;text-align: left;">';
			row_content  += 'PD';	
			row_content  += '</td>';

			row_content	 += '<td style="border: 1px solid #dddddd; width: 15%;text-align: left;">';
			row_content  += 'QA';	
			row_content  += '</td>';

			row_content	 += '<td style="border: 1px solid #dddddd; width: 15%;text-align: left;">';
			row_content  += '<span class="last_modul"> </span>';	
			
			row_content  += '</td>';

			//row_content	 += '<td style="border: 1px solid #dddddd; width: 7%;">';
			//row_content  += '<a href="javascript:;" class="moveUpprio"><img alt="Keatas" src="<?php echo base_url() ?>assets/images/up.gif" /></a> <a href="javascript:;" class="moveDownprio"><img alt="Kebawah" src="<?php echo base_url() ?>assets/images/down.gif" /></a>';	
			//row_content  += '</td>';


			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
				row_content	 += '<span class="delete_btn"><a href="javascript:;" class="<?php echo $nmfield ?>_del" onclick="del_row1(this, \'<?php echo $nmfield ?>_del\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			
			jQuery("#"+table_id+" tbody").append(row_content);
		} else {
			/*alert('bawah');*/
			var no = parseInt(n);
			var c = no + 1;
			var row_content = '';
			
			row_content	  = '<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">';
			row_content	 += '<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">';
			row_content	 += '<span class="'+table_id+'_num">1</span></td>';		

			row_content	 += '<td style="border: 1px solid #dddddd; width: 15%; text-align: left">';
				row_content	 += '<input type="hidden" name="iupb_id[]" class="upb_set_prio_upb_id upb_id" />';
				row_content	 += '<input type="hidden" name="upb_idi[]" class="upb_idi" />';
				row_content	 += '<input readonly="readonly" style="width: 60%" class="input_tgl upb_set_prio_upbno" type="text" name="iupb_nomor" />';
																																																							//row_content	 += 'onclick="del_row1(this, \'<?php echo $nmfield ?>_del\')';
				
				row_content  += '<button class="btn_browse_upb icon_pop ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only" onclick="javascript:get_upb_exists();javascript:browse_multi1_setting_prioritas_prareg(\'<?php echo $browse_url ?>&pdId=<?php echo $t['iteam_id'] ?>\',\'List UPB\',this,\'iupb_id=\'+$(\'.list_upbid_exists\').val());return false;"  type="button" role="button" aria-disabled="false" title="">';	
					row_content	 += '<span class="ui-button-icon-primary ui-icon ui-icon-newwin"></span>';
					row_content	 += '<span class="ui-button-text">&nbsp;</span>';
				row_content	 += '</button>';

				row_content  += '<button style="display:none;" class="btn_browse_upb_detail ui-icon-lightbulb ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only" onclick="javascript:browse_detail_upb(\'<?php echo $browse_url1 ?>&iupb_id=GANTI_UPB\',\'Detail UPB\',this,\'iupb_id=GANTI_UPB\');return false;"  type="button" role="button" aria-disabled="false" title="Detail UPB">';	
					row_content	 += '<span class="ui-button-icon-primary ui-icon ui-icon-lightbulb"></span>';
					row_content	 += '<span class="ui-button-text">&nbsp;</span>';
				row_content	 += '</button>';

				row_content	 += '<input type="hidden" name="list_upbid_exists" class="list_upbid_exists" value=""/>';

			row_content  += '</td>';

			row_content	 += '<td style="border: 1px solid #dddddd; width: 40%; text-align: left">';
				row_content	 += '<div class="upb_set_prio_generik"></div>';
				row_content  += '<input class="iUrut" type="hidden" name="iUrut[]"> </span>';	
			row_content  += '</td>';

			row_content	 += '<td  style="border: 1px solid #dddddd; width: 15%;text-align: left;">';

			//row_content  += 'bawah';	
			//row_content  += '<select class="required" name="appdireksi[]" ><option  value="">--Select--</option><option  value="2">Approve</option><option  value="1">Reject</option></select>';
			row_content  += '<span id="statusesNew_'+c+'" ><?php echo $statusesNew ?></span>';
			
			row_content  += '</td>';

			row_content	 += '<td style="border: 1px solid #dddddd; width: 15%;text-align: left;">';
			row_content  += '<span id="pD_new'+c+'" ><?php echo $oNew ?></span>';
			row_content  += '</td>';

			row_content	 += '<td style="border: 1px solid #dddddd; width: 15%;text-align: left;">';
			row_content  += '<span id="qA_new'+c+'" ><?php echo $oNew2 ?></span>';
			row_content  += '</td>';

			row_content	 += '<td style="border: 1px solid #dddddd; width: 15%;text-align: left;">';
			row_content  += '<span id="mR_new'+c+'" ><?php echo $oNew3 ?></span>';
			row_content  += '</td>';
			

			row_content	 += '<td style="border: 1px solid #dddddd; width: 15%;text-align: left;">';
			row_content  += '<span class="last_modul"> </span>';	
			
			row_content  += '</td>';

			//row_content	 += '<td style="border: 1px solid #dddddd; width: 7%;">';
			//row_content  += '<a href="javascript:;" class="moveUpprio"><img alt="Keatas" src="<?php echo base_url() ?>assets/images/up.gif" /></a> <a href="javascript:;" class="moveDownprio"><img alt="Kebawah" src="<?php echo base_url() ?>assets/images/down.gif" /></a>';	
			//row_content  += '</td>';


			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
				row_content	 += '<span class="delete_btn"><a href="javascript:;" class="<?php echo $nmfield ?>_del" onclick="del_row1(this, \'<?php echo $nmfield ?>_del\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			$('table#'+table_id+' tbody tr:last').after(row_content);
           	$('table#'+table_id+' tbody tr:last input').val("");
			$('table#'+table_id+' tbody tr:last div').text("");
			$("span."+table_id+"_num:last").text(c);


			
		}

		$('#statusesNew_'+c).find('select').addClass('statusesNew_'+c);
		$('#pD_new'+c).find('select').addClass('pD_new'+c);
		$('#qA_new'+c).find('select').addClass('qA_new'+c);
		$('#mR_new'+c).find('select').addClass('mR_new'+c);

		$('select.statusesNew_'+c).die();
		$('select.statusesNew_'+c).live('change',function(){
			var pal = $(this).val();
			/*alert(pal);*/
			if (pal == 1) {
				$('select.pD_new'+c).children("option[value=0]").show();
				$('select.pD_new'+c).children("option[value!=0]").hide();
				$('select.pD_new'+c).val(0);
				$('select.pD_new'+c).hide();

				$('select.qA_new'+c).children("option[value=0]").show();
				$('select.qA_new'+c).children("option[value!=0]").hide();
				$('select.qA_new'+c).val(0);
				$('select.qA_new'+c).hide();

				$('select.mR_new'+c).children("option[value=0]").show();
				$('select.mR_new'+c).children("option[value!=0]").hide();
				$('select.mR_new'+c).val(0);
				$('select.mR_new'+c).hide();

			}else{
				$('select.pD_new'+c).show();
				$('select.pD_new'+c).children("option[value=0]").hide();
				$('select.pD_new'+c).children("option[value!=0]").show();
				$('select.pD_new'+c).val(1);

				$('select.qA_new'+c).show();
				$('select.qA_new'+c).children("option[value=0]").hide();
				$('select.qA_new'+c).children("option[value!=0]").show();
				$('select.qA_new'+c).val(16);

				$('select.mR_new'+c).show();
				$('select.mR_new'+c).children("option[value=0]").hide();
				$('select.mR_new'+c).children("option[value!=0]").show();
				$('select.mR_new'+c).val(6);

			}

		});


	}


    function add_row_priox(table_id) {
		//alert(table_id);
		var row = $('table#'+table_id+' tbody tr:last').clone(true);
		$("span."+table_id+"_num:first").text('1');
		var n = $("span."+table_id+"_num:last").text();
		var no = parseInt(n);
		var c = no + 1;
		//datepicker on clone active
		row.find('input.tanggal').attr("id", "").removeClass('hasDatepicker').removeData('datepicker').unbind().datepicker({changeMonth:true,
											changeYear:true,
											dateFormat:"yy-mm-dd" });

		$('table#'+table_id+' tbody tr:last').after(row);
		$('table#'+table_id+' tbody tr:last input').val("");
		$('table#'+table_id+' tbody tr:last div').text("");
		$('table#' + table_id + ' tbody tr:last textarea').val("");
		$("span."+table_id+"_num:last").text(c);
	}


</script>

<?php 
	if($act == 'create'){
		// add new record

		/*echo "keatas";*/
		echo "Save First ...";
		$dUdahPrioSubmit = 0;


?>

<?php 
	}else{
		// form upbate

		$sqludahprio= 'select *
				        from plc2.plc2_upb_prioritas a
				        where a.ldeleted=0
				        and a.iprioritas_id = "'.$rowDataH['iprioritas_id'].'"

				        ';
		//echo "<pre>".$sqludahprio;
        $dUdahPrio = $this->db->query($sqludahprio)->row_array();
        $dUdahPrioSubmit = $dUdahPrio['iSubmit'];
        //echo $dUdahPrioSubmit;
?>

	<script type="text/javascript">
		function browse_detail_upb(url, title, dis, param) {
			var i = $('.btn_browse_detail_upb').index(dis);	
			load_popup_multi(url+'&'+param,'','',title,i);
		}

		function browse_multi1_setting_prioritas_prareg(url, title, dis, param) {
			var i = $('.btn_browse_upb').index(dis);	
			load_popup_multi(url+'&'+param,'','',title,i);
		}
		function get_upb_exists() {
			var i = 0;
			var l_upb_id = '';
			$('.upb_idi').each(function() {
				if  ($('.upb_idi').eq(i).val() != '') {
					l_upb_id += $('.upb_idi').eq(i).val()+'_';
				}
				
				i++;
			});
		
			l_upb_id = l_upb_id.substring(0, l_upb_id.length - 1);
			if (l_upb_id == undefined || l_upb_id == '') l_upb_id= 0;
			$('.list_upbid_exists').val(l_upb_id);		
		}
	</script>

	<div class="tab">
		<hr>
		<ul>
			<?php
					echo '<li>
							  <a href="#teampd">Rincian UPB</a>
						  </li>
						  ';
			?>	
		</ul>
		<?php		
			
				$sql = "SELECT *,
						IFNULL(
							
							(
								select d.iUrut
								from plc3.m_modul_log_upb a 
								join plc3.m_modul_log_activity b on b.iM_modul_log_activity=a.iM_modul_log_activity
								join plc3.m_modul c on c.idprivi_modules=b.idprivi_modules 
								join plc3.m_flow_proses d on d.iM_modul=c.iM_modul and d.iM_flow=1
								where 
								a.lDeleted=0 
								and b.lDeleted=0
								and c.lDeleted=0
								and d.lDeleted=0
								and  a.iupb_id = dt.iupb_id
								order by d.iUrut DESC
								limit 1
							)
							
							, 0) as iUrut

						,IFNULL(
							
							(
								select c.vNama_modul
								from plc3.m_modul_log_upb a 
								join plc3.m_modul_log_activity b on b.iM_modul_log_activity=a.iM_modul_log_activity
								join plc3.m_modul c on c.idprivi_modules=b.idprivi_modules 
								join plc3.m_flow_proses d on d.iM_modul=c.iM_modul and d.iM_flow=1
								where 
								a.lDeleted=0 
								and b.lDeleted=0
								and c.lDeleted=0
								and d.lDeleted=0
								and  a.iupb_id = dt.iupb_id
								order by d.iUrut DESC
								limit 1
							)
							
							, 'Log Modul tidak ditemukan') as vNama_modul

						FROM plc2.plc2_upb_prioritas_detail dt
						INNER JOIN plc2.plc2_upb u ON dt.iupb_id=u.iupb_id
						WHERE dt.iprioritas_id = '".$rowDataH['iprioritas_id']."'
						AND dt.ldeleted = 0";
				if($dUdahPrioSubmit == 1){
					$sql .=" and u.iappdireksi = 2 ";
				}		
				

				$sql .="
						order by iUrut DESC

						";

						//echo "<pre>".$sql;
				$rows = $this->db->query($sql)->result_array();			
		?>
			<div id="teampd" class="margin_0">
				<div>
					<table id="table_upb_setting_prio_rincian" cellspacing="0" cellpadding="3" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
						<thead>
							<tr class="nodrop nodrag" style="width: 98%; border: 1px solid #dddddd; background: #aaaaaa; border-collapse: collapse">
								<th style="border: 1px solid #dddddd;">No</th>
								<th style="border: 1px solid #dddddd;">NO. UPB</th>
								<th style="border: 1px solid #dddddd;">NAMA GENERIK</th>
								<th style="border: 1px solid #dddddd;">STATUS</th>
								<th style="border: 1px solid #dddddd;">TEAM PD</th>
								<th style="border: 1px solid #dddddd;">TEAM QA</th>
								<th style="border: 1px solid #dddddd;">TEAM MARKETING</th>
								<th style="border: 1px solid #dddddd;">LAST MODUL</th>
								<th style="border: 1px solid #dddddd;">ACTION</th>
							</tr>
						</thead>					
						<tbody id="sortable">
							<?php
							$sqlBB = 'select * 
									from plc3.m_flow_proses a 
									join plc3.m_modul b on b.iM_modul=a.iM_modul
									where a.lDeleted=0
									and b.lDeleted=0
									and a.iM_flow=1
									and b.vCodeModule="3.25.0.0_v3_terima_sample_bb" 
									#and b.vCodeModule="10_Study_literatur_01_PD" 
									';
							$dBB = $this->db->query($sqlBB)->row_array();

							$urutan = 70;
							if(!empty($dBB)){
								$urutan = $dBB['iUrut'];			
							}

							$no = 1;
							if(count($rows) > 0) {
								foreach($rows as $r) {
									$sql_upb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$r['iupb_id'].'" ';
									$dataUPB = $this->db->query($sql_upb)->row_array();

									
									$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'PD' AND d.iTipe=1 AND d.ldeleted = 0 ORDER BY d.iteam_id ASC";
									$team_pd = $this->db->query($sql)->result_array();

									$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'QA' AND d.iTipe=1 AND d.ldeleted = 0 ORDER BY d.iteam_id ASC";
									$team_qa = $this->db->query($sql)->result_array();

									$sql = "SELECT * FROM plc2.plc2_upb_team d WHERE d.vtipe = 'MR' AND d.iTipe=1 AND d.ldeleted = 0 ORDER BY d.iteam_id ASC";
									$team_mr = $this->db->query($sql)->result_array();

									$browse_url = base_url().'processor/plc/browse/upb/setprareg?action=index';
									$browse_url1 = base_url().'processor/plc/browse/detail/upb?action=index';

									/*print_r($rowDataH);
									echo $act;*/
									$statuses = array(''=>'--Select--', 2=>'Approve',1=>'Reject');
									$statusesNew  = '<select class="dropdon required " name="iappdireksi[]" required="required" >';            
									foreach($statuses as $k=>$v) {
										if ($k == $dataUPB['iappdireksi']) $selected = " selected";
										else $selected = "";
										$statusesNew .= '<option {$selected} value="'.$k.'">'.$v.'</option>';
									}            
									$statusesNew .= '</select>';


									$oNew = '<select class="required  dropdon" name="iteampd_id[]" >';
									/*$oNew .= '<option value="">--Select--</option>';*/
									$oNew .= '<option value="0" >-</option>';
									foreach ($team_pd as $t) {
										if ($t['iteam_id'] == $dataUPB['iteampd_id']) $selected = " selected";
										else $selected = "";

										$oNew .= '<option '.$selected.' value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
									}
									$oNew .= '</select>';


									$oNew2 = '<select class="required  dropdon" name="iteamqa_id[]" >';
									/*$oNew .= '<option value="">--Select--</option>';*/
									$oNew2 .= '<option value="0" >-</option>';
									foreach ($team_qa as $t) {
										if ($t['iteam_id'] == $dataUPB['iteamqa_id']) $selected = " selected";
										else $selected = "";

										$oNew2 .= '<option '.$selected.' value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
									}
									$oNew2 .= '</select>';

									$oNew3 = '<select class="required  dropdon" name="iteammarketing_id[]" >';
									/*$oNew .= '<option value="">--Select--</option>';*/
									$oNew3 .= '<option value="0" >-</option>';
									foreach ($team_mr as $t) {
										if ($t['iteam_id'] == $dataUPB['iteammarketing_id']) $selected = " selected";
										else $selected = "";

										$oNew3 .= '<option '.$selected.' value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
									}
									$oNew3 .= '</select>';


	
									/*$this->load->library('lib_plc');
									$lastModul = $this->lib_plc->getCurrent_modul($r['iupb_id']);*/
									

									if($r['iUrut'] >= $urutan){
										$bisasort='tidakbisasort';
										$title = '';
									}else{
										$bisasort='bisasort';
										$title = 'Drag untuk merubah posisi prioritas';
									}
									

							?>
								<tr title="<?php echo $title ?>" style="border: 1px solid #dddddd; border-collapse: collapse;" class="<?php echo $bisasort ?>">
									<td style="border: 1px solid #dddddd; width: 5%; text-align: center;"><span class="table_upb_setting_prio_rincian_num"><?php echo $no; ?></span></td>
									<td style="border: 1px solid #dddddd; width: 15%; text-align: left">
										<input type="hidden" value="<?php echo $r['iupb_id'] ?>" name="iupb_id[]" class="upb_set_prio_upb_id" />
										<input type="hidden" name="upb_idi[]" class="upb_idi" value="<?php echo $r['iupb_id'] ?>">
										<input readonly="readonly" style="width: 60%" class="input_tgl upb_set_prio_upbno upb_id" type="text" name="iupb_nomor" value="<?php echo $r['vupb_nomor'] ?>" />
										
										<button style="display: none;" class="btn_browse_upb icon_pop ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only"  type="button" role="button" aria-disabled="false" title="Detail UPB">
										
										</button>

										<button class="btn_browse_upb_detail ui-icon-lightbulb ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only" onclick="javascript:browse_detail_upb('<?php echo $browse_url1 ?>&iupb_id=<?php echo $r['iupb_id'] ?>','Detail UPB',this,'iupb_id=<?php echo $r['iupb_id'] ?>');return false;"  type="button" role="button" aria-disabled="false" title="Detail UPB">
											<span class="ui-button-icon-primary ui-icon ui-icon-lightbulb"></span>
											<span class="ui-button-text">&nbsp;</span>
										</button>

										<input type="hidden" name="list_upbid_exists" class="list_upbid_exists" value=""/>
										
										
									</td>
									<td style="border: 1px solid #dddddd; width: 40%; text-align: left"><div class="upb_set_prio_generik"><?php echo $r['vgenerik'] ?></div></td>
									<td style="border: 1px solid #dddddd; width: 10%;">
										<span id="statusesNew_<?php echo $no ?>" >
										<?php 
												$statuses = array(''=>'--Select--', 2=>'Approve',1=>'Reject');
									            
									            

									            if($dataUPB['iappdireksi']<> 0){
									            	$ret = $statuses[$dataUPB['iappdireksi']];
									            	$ret .= '<input type="hidden" value="'.$dataUPB['iappdireksi'].'" name="iappdireksi[]" />';

									            }else{
									            	$ret  = "<select class='required dropdon' name='iappdireksi[]' >";            
										            foreach($statuses as $k=>$v) {
										            	if ($k == $dataUPB['iappdireksi']) $selected = " selected";
										                else $selected = "";
										                $ret .= "<option {$selected} value='".$k."'>".$v."</option>";
										            }            
										            $ret .= "</select>";

									            }

									            echo $ret;
									             

										 ?>
										</span>
									</td>
									<td style="border: 1px solid #dddddd; width: 10%; text-align: left">
										<?php 
										/*print_r($dataUPB);*/

											/*cek UPb sudah pernah disubmit prioritas*/
											$sqludah= 'select b.iupb_id
													from plc2.plc2_upb_prioritas a
													join plc2.plc2_upb_prioritas_detail b on b.iprioritas_id=a.iprioritas_id
													where a.ldeleted=0
													and b.ldeleted=0
													and a.iSubmit > 0
													and b.iupb_id = "'.$dataUPB['iupb_id'].'"

													';
											$dUdah = $this->db->query($sqludah)->row_array();

											if(empty($dUdah)){
												//$o = '<span id="pD_new_'.$no.'>';
												$o  = '<select class="required dropdon" name="iteampd_id[]" >';
										            /*$o .= '<option value="">--Select--</option>';*/
										            /*$o .= '<option value="0" >Reject</option>';*/
										            foreach ($team_pd as $t) {
										            	if ($t['iteam_id'] == $dataUPB['iteampd_id']) $selected = " selected";
											            else $selected = "";
										                $o .= '<option '.$selected.' value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
										            }
										            $o .= '</select>';
									           // $o .= '</span>';

											}else{
												$dUpbteam = $this->lib_plc->getNamaTeamUPB($dataUPB['iupb_id']);
												$o = $dUpbteam['nmPD'];
									            $o .= '<input type="hidden" value="'.$dataUPB['iteampd_id'].'" name="iteampd_id[]" />';
											}

								            

								            echo $o;
										?>
									</td>

									<td style="border: 1px solid #dddddd; width: 10%; text-align: left">
										<?php 
										/*print_r($dataUPB);*/

											/*cek UPb sudah pernah disubmit prioritas*/
											$sqludah= 'select b.iupb_id
													from plc2.plc2_upb_prioritas a
													join plc2.plc2_upb_prioritas_detail b on b.iprioritas_id=a.iprioritas_id
													where a.ldeleted=0
													and b.ldeleted=0
													and a.iSubmit > 0
													and b.iupb_id = "'.$dataUPB['iupb_id'].'"

													';
											$dUdah = $this->db->query($sqludah)->row_array();

											if(empty($dUdah)){
												//$o = '<span id="pD_new_'.$no.'>';
												$o  = '<select class="required dropdon" name="iteamqa_id[]" >';
										            /*$o .= '<option value="">--Select--</option>';*/
										            /*$o .= '<option value="0" >Reject</option>';*/
										            foreach ($team_qa as $t) {
										            	if ($t['iteam_id'] == $dataUPB['iteamqa_id']) $selected = " selected";
											            else $selected = "";
										                $o .= '<option '.$selected.' value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
										            }
										            $o .= '</select>';
									           // $o .= '</span>';

											}else{
												$dUpbteam = $this->lib_plc->getNamaTeamUPB($dataUPB['iupb_id']);
												$o = $dUpbteam['nmQA'];
									            $o .= '<input type="hidden" value="'.$dataUPB['iteamqa_id'].'" name="iteamqa_id[]" />';
											}

								            

								            echo $o;
										?>
									</td>
									<td style="border: 1px solid #dddddd; width: 10%; text-align: left">
										<?php 
										/*print_r($dataUPB);*/

											/*cek UPb sudah pernah disubmit prioritas*/
											$sqludah= 'select b.iupb_id
													from plc2.plc2_upb_prioritas a
													join plc2.plc2_upb_prioritas_detail b on b.iprioritas_id=a.iprioritas_id
													where a.ldeleted=0
													and b.ldeleted=0
													and a.iSubmit > 0
													and b.iupb_id = "'.$dataUPB['iupb_id'].'"

													';
											$dUdah = $this->db->query($sqludah)->row_array();

											if(empty($dUdah)){
												//$o = '<span id="pD_new_'.$no.'>';
												$o  = '<select class="required dropdon" name="iteammarketing_id[]" >';
										            /*$o .= '<option value="">--Select--</option>';*/
										            /*$o .= '<option value="0" >Reject</option>';*/
										            foreach ($team_mr as $t) {
										            	if ($t['iteam_id'] == $dataUPB['iteammarketing_id']) $selected = " selected";
											            else $selected = "";
										                $o .= '<option '.$selected.' value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
										            }
										            $o .= '</select>';
									           // $o .= '</span>';

											}else{
												$dUpbteam = $this->lib_plc->getNamaTeamUPB($dataUPB['iupb_id']);
												$o = $dUpbteam['nmMKT'];
									            $o .= '<input type="hidden" value="'.$dataUPB['iteammarketing_id'].'" name="iteammarketing_id[]" />';
											}

								            

								            echo $o;
										?>
									</td>
									<td style="border: 1px solid #dddddd; width: 25%; text-align: left">
										<?php echo $r['vNama_modul'] ?>
										<input class="iUrut" type="hidden" name="iUrut[]" value="<?php echo $r['iUrut'] ?> ">
									</td>
									<!-- <td style="border: 1px solid #dddddd; width: 7%;"><a href="javascript:;" class="moveUp"><img alt="Keatas" src="<?php echo base_url() ?>assets/images/up.gif" /></a> <a href="javascript:;" class="moveDown"><img alt="Kebawah" src="<?php echo base_url() ?>assets/images/down.gif" /></a></td> -->
									<!-- <td style="border: 1px solid #dddddd; width: 10%;"><span class="delete_btn"><a href="javascript:;" class="table_upb_setting_prio_rincian_del" onclick="del_row1(this, 'table_upb_setting_prio_rincian_del')">[Delete]</a></span></td> -->
								</tr>

								<script type="text/javascript">
									
								</script>
							<?php
								$no++;
								}
							}
							else {
							?>
								
							<?php
								}
							?>
							

						</tbody>
						<tfoot>
							<tr>
								
								<td colspan="6"></td>
								<td style="text-align: center">
									<?php 
										

										if($dUdahPrioSubmit <> 1){
									?>
										<a href="javascript:;" onclick="javascript:add_row_prio('table_upb_setting_prio_rincian')">Tambah</a>
									<?php 
										
										}
									?>
								</td>

							</tr>
							<tr>
								<td colspan="6" style="text-align: center">
									<!-- <?php 
										if($dUdahPrioSubmit==1){
									?>
									
									<?php 
										}else{
											echo "<span style='color:blue;font-style:italic;'>Prioritas sudah disubmit, silahkan melakukan sorting</span>";
										}
									?> -->
								</td>
							</tr>
						</tfoot>
					</table>
				</div>			
			</div>
		<?php
			
		?>
			
	</div>

<?php 
	}
 ?>		

<?php 
   	if($dUdahPrioSubmit == 0){
?>
		<script type="text/javascript">
		   	//$( "#sortable" ).sortable();
		   	$( "#sortable" ).sortable({
		   		cancel: '.tidakbisasort, .dropdon' ,
		   		beforeStop: function(event, ui) {
		   				//alert(JSON.stringify(ui));

		                var a = $(ui.helper).index('table tbody#sortable tr'); 
		              	var b = $('tbody#sortable tr:eq('+(a)+')').index();
		              	var c = (parseInt(b, 10) +2);
		              	var iOrderNext = parseInt($('tbody#sortable tr:eq('+(c)+')').find('input.iUrut').val());
		              	var iOrderNow = parseInt($('tbody#sortable tr:eq('+(b)+')').find('input.iUrut').val());
		              	
		   			  if(iOrderNext >=  '<?php echo $urutan ?>'  ){
		   			  	if(iOrderNow >= '<?php echo $urutan ?>'){

		   			  	}else{
		   			  		$("#sortable").sortable("cancel");
			            	alert('UPB yang sudah melalui Tahap Terima Sample BB tidak bisa disisipkan UPB Lain');
		   			  	}
			            	
			          }else{
			            // berhasil dipindah
			            $(ui.item).css('background-color','#759dc8');
			          }



		   		}

		   	});
		</script>
<?php 
	}
 ?>

<style>
	tr.bisasort { cursor: pointer; }
</style>