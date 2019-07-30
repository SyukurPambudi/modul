<?php 
	$this->load->library('lib_refor');
	$browse_url = base_url().'processor/reformulasi/browse/req/prio?action=index';
?>


<script type="text/javascript">
	$("label[for=\'v2_exp_setting_prioritas_form_detail_detail_refor\']").siblings().css('margin-left',0);
	$("label[for=\'v2_exp_setting_prioritas_form_detail_detail_refor\']").remove();

	$(".moveUpprio,.moveDownprio").live('click', function(){
        var row = $(this).parents("tbody tr:first");
        if ($(this).is(".moveUpprio")) {
            row.insertBefore(row.prev());
        } else {
            row.insertAfter(row.next());
        }
    });

    function add_row_priox(table_id){		
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
				row_content	 += '<input type="hidden" name="iexport_req_refor[]" class="upb_set_prio_iexport_req_refor iexport_req_refor" />';
				row_content	 += '<input type="hidden" name="iexport_req_refori[]" class="iexport_req_refori" />';

				row_content	 += '<input readonly="readonly" style="width: 60%" class="input_tgl upb_set_prio_upbno" type="text" name="iupb_nomor" />';
																																																							//row_content	 += 'onclick="del_row1(this, \'<?php echo $nmfield ?>_del\')';
				
				row_content  += '<button class="btn_browse_upb icon_pop ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only" onclick="javascript:get_upb_exists();javascript:browse_multi1_setting_prioritas_prareg(\'<?php echo $browse_url ?>&pdId=<?php echo $t['iteam_id'] ?>\',\'List UPB\',this,\'iexport_req_refor=\'+$(\'.list_updid_exists\').val());return false;"  type="button" role="button" aria-disabled="false" title="">';	
					row_content	 += '<span class="ui-button-icon-primary ui-icon ui-icon-newwin"></span>';
					row_content	 += '<span class="ui-button-text">&nbsp;</span>';
				row_content	 += '</button>';

				row_content  += '<button style="display:none;" class="btn_browse_upb_detail ui-icon-lightbulb ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only" onclick="javascript:browse_detail_upb(\'<?php echo $browse_url1 ?>&iexport_req_refor=GANTI_UPB\',\'Detail UPB\',this,\'iexport_req_refor=GANTI_UPB\');return false;"  type="button" role="button" aria-disabled="false" title="Detail UPB">';	
					row_content	 += '<span class="ui-button-icon-primary ui-icon ui-icon-lightbulb"></span>';
					row_content	 += '<span class="ui-button-text">&nbsp;</span>';
				row_content	 += '</button>';

				row_content	 += '<input type="hidden" name="list_updid_exists" class="list_updid_exists" value=""/>';

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
				row_content	 += '<input type="hidden" name="iexport_req_refor[]" class="upb_set_prio_iexport_req_refor iexport_req_refor" />';
				row_content	 += '<input type="hidden" name="iexport_req_refori[]" class="iexport_req_refori" />';
				row_content	 += '<input readonly="readonly" style="width: 60%" class="input_tgl upb_set_prio_upbno" type="text" name="iupb_nomor" />';
																																																							//row_content	 += 'onclick="del_row1(this, \'<?php echo $nmfield ?>_del\')';
				
				row_content  += '<button class="btn_browse_upb icon_pop ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only" onclick="javascript:get_upb_exists();javascript:browse_multi1_setting_prioritas_prareg(\'<?php echo $browse_url ?>&pdId=<?php echo $t['iteam_id'] ?>\',\'List UPB\',this,\'iexport_req_refor=\'+$(\'.list_updid_exists\').val());return false;"  type="button" role="button" aria-disabled="false" title="">';	
					row_content	 += '<span class="ui-button-icon-primary ui-icon ui-icon-newwin"></span>';
					row_content	 += '<span class="ui-button-text">&nbsp;</span>';
				row_content	 += '</button>';

				row_content  += '<button style="display:none;" class="btn_browse_upb_detail ui-icon-lightbulb ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only" onclick="javascript:browse_detail_upb(\'<?php echo $browse_url1 ?>&iexport_req_refor=GANTI_UPB\',\'Detail UPB\',this,\'iexport_req_refor=GANTI_UPB\');return false;"  type="button" role="button" aria-disabled="false" title="Detail UPB">';	
					row_content	 += '<span class="ui-button-icon-primary ui-icon ui-icon-lightbulb"></span>';
					row_content	 += '<span class="ui-button-text">&nbsp;</span>';
				row_content	 += '</button>';

				row_content	 += '<input type="hidden" name="list_updid_exists" class="list_updid_exists" value=""/>';

			row_content  += '</td>';

			row_content	 += '<td style="border: 1px solid #dddddd; width: 40%; text-align: left">';
				row_content	 += '<div class="upb_set_prio_generik"></div>';
				row_content  += '<input class="iUrut" type="hidden" name="iUrut[]"> </span>';	
			row_content  += '</td>';

			row_content	 += '<td  style="border: 1px solid #dddddd; width: 15%;text-align: left;">';

			
			row_content  += '<span id="statusesNew_'+c+'" ><?php echo $statusesNew ?></span>';
			
			row_content  += '</td>';

			row_content	 += '<td style="border: 1px solid #dddddd; width: 15%;text-align: left;">';
			row_content  += '<span id="pD_new'+c+'" ><?php echo $oNew ?></span>';
			row_content  += '</td>';

			row_content	 += '<td style="border: 1px solid #dddddd; width: 15%;text-align: left;">';
			row_content  += '<span id="qA_new'+c+'" ><?php echo $oNew2 ?></span>';
			row_content  += '</td>';
			

			row_content	 += '<td style="border: 1px solid #dddddd; width: 15%;text-align: left;">';
			row_content  += '<span class="last_modul"> </span>';	
			
			row_content  += '</td>';


			row_content	 += '<td style="border: 1px solid #dddddd; width: 10%">';
				row_content	 += '<span class="delete_btn"><a href="javascript:;" class="<?php echo $nmfield ?>_del" onclick="del_row1(this, \'<?php echo $nmfield ?>_del\')">[Hapus]</a></span></td>';		
			row_content  += '</tr>';
			
			$('table#'+table_id+' tbody tr:last').after(row_content);
           	$('table#'+table_id+' tbody tr:last input').val("");
			$('table#'+table_id+' tbody tr:last div').text("");
			$("span."+table_id+"_num:last").text(c);


			
		}


	}


    function add_row_prio(table_id) {
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
		echo "<b>Save First ...</b>";
		$dUdahPrioSubmit = 0;


?>

<?php 
	}else{
		// form upbate

		$sqludahprio= 'select *
				        from reformulasi.exp_setting_prioritas a
				        where a.lDeleted=0
				        and a.iExp_setting_prioritas = "'.$rowDataH['iExp_setting_prioritas'].'"

				        ';
        $dUdahPrio = $this->db->query($sqludahprio)->row_array();
        $dUdahPrioSubmit = $dUdahPrio['iSubmit'];
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
                var l_iexport_req_refor = '';
                $('.iexport_req_refori').each(function() {
                    if  ($('.iexport_req_refori').eq(i).val() != '') {
                        l_iexport_req_refor += $('.iexport_req_refori').eq(i).val()+'_';
                    }
                    
                    i++;
                });
            
                l_iexport_req_refor = l_iexport_req_refor.substring(0, l_iexport_req_refor.length - 1);
                if (l_iexport_req_refor == undefined || l_iexport_req_refor == '') l_iexport_req_refor= 0;
                $('.list_updid_exists').val(l_iexport_req_refor);		
            }
        </script>

        <div class="tab">
            <hr>
            <ul>
                <?php
                        echo '<li>
                                <a href="#teampd">Rincian Refor</a>
                            </li>
                            ';
                ?>	
            </ul>
            <?php		
                
                    $sql = "SELECT c.vno_export_req_refor,d.vUpd_no,d.vNama_usulan,c.iexport_req_refor
                            FROM reformulasi.exp_setting_prioritas a
                            JOIN reformulasi.exp_setting_prioritas_detail b ON b.iExp_setting_prioritas=a.iExp_setting_prioritas
                            JOIN reformulasi.export_req_refor c ON c.iexport_req_refor=b.iexport_req_refor
                            JOIN dossier.dossier_upd d ON d.idossier_upd_id=c.idossier_upd_id
                            WHERE a.lDeleted=0
                            AND b.lDeleted=0
                            and a.iExp_setting_prioritas= '".$rowDataH['iExp_setting_prioritas']."'
                            ";
                            //echo '<pre>'.$sql;
                    $rows = $this->db->query($sql)->result_array();			
            ?>
                    <div id="teampd" class="margin_0">
                        <div>
                            <table id="table_upb_setting_prio_rincian" cellspacing="0" cellpadding="3" style="width: 98%; border: 1px solid #5c9ccc; text-align: center; margin-left: 5px; border-collapse: collapse">
                                <thead>
                                    <tr class="nodrop nodrag" style="width: 98%; border: 1px solid #dddddd; background: #5c9ccc; border-collapse: collapse">
                                        <th style="border: 1px solid #dddddd;">No</th>
                                        <th style="border: 1px solid #dddddd;">NO.REQ REFOR</th>
                                        <th style="border: 1px solid #dddddd;">No UPD</th>
                                        <th style="border: 1px solid #dddddd;">NAMA GENERIK</th>
                                        <th style="border: 1px solid #dddddd;">ACTION</th>
                                    </tr>
                                </thead>					
                                <tbody id="sortable">
                                    <?php

                                        $urutan = 1000;
                                        $no = 1;
                                        if(count($rows) > 0) {
                                            foreach($rows as $r) {
                                                $bisasort='bisasort';
                                                $title = 'Drag untuk merubah posisi prioritas';
                                                

                                        ?>
                                                <tr title="<?php echo $title ?>" style="border: 1px solid #dddddd; border-collapse: collapse;" class="<?php echo $bisasort ?>">
                                                    <td style="border: 1px solid #dddddd; width: 5%; text-align: center;"><span class="table_upb_setting_prio_rincian_num"><?php echo $no; ?></span></td>
                                                    <td style="border: 1px solid #dddddd; width: 20%; text-align: left" class="dropdon">
                                                        <input type="hidden" value="<?php echo $r['iexport_req_refor'] ?>" name="iexport_req_refor[]" class="upb_set_prio_iexport_req_refor" />
                                                        <input type="hidden" name="iexport_req_refori[]" class="iexport_req_refori" value="<?php echo $r['iexport_req_refor'] ?>">
                                                        <input readonly="readonly" style="width: 60%" class="input_tgl upb_set_prio_upbno iexport_req_refor" type="text" name="iupb_nomor" value="<?php echo $r['vno_export_req_refor'] ?>" />
                                                        <button class="btn_browse_upd" type="button" onclick="javascript:get_upb_exists();javascript:browse_multi1_setting_prioritas_prareg('<?php echo $browse_url ?>&pdId=<?php echo $dUdahPrio['iTeamPD'] ?>','List Request Refor',this,'iexport_req_refor='+$('.list_updid_exists').val());return false;">...</button>
                                                        <input type="hidden" name="list_updid_exists" class="list_updid_exists" value=""/>
                                                    </td>
                                                    <td style="border: 1px solid #dddddd; width: 15%; text-align: left"><div class="upb_set_prio_generik"><?php echo $r['vUpd_no'] ?></div></td>
                                                    <td style="border: 1px solid #dddddd; width: 40%; text-align: left"><div class="upb_set_prio_generik"><?php echo $r['vNama_usulan'] ?></div></td>
													
													<td style="border: 1px solid #dddddd; width: 10%;">
													<?php 
														if($dUdahPrioSubmit <> 1){
														?>
															<span class="delete_btn "><a href="javascript:;" class="table_upb_prioritas_rincian_del" onclick="del_row(this, 'table_upb_prioritas_rincian_del')">[Delete]</a></span>
														<?php 
															
															}
														?>
													</td>
                                                </tr>
                                        <?php
                                            $no++;
                                            }
                                        }else{
                                        ?>

                                        <!-- jika untuk pertama kali -->
                                                <tr title="<?php echo $title ?>" style="border: 1px solid #dddddd; border-collapse: collapse;" class="<?php echo $bisasort ?>">
                                                    <td style="border: 1px solid #dddddd; width: 5%; text-align: center;"><span class="table_upb_setting_prio_rincian_num"><?php echo $no; ?></span></td>
                                                    <td style="border: 1px solid #dddddd; width: 20%; text-align: left" class="dropdon">
                                                        <input type="hidden" value="" name="iexport_req_refor[]" class="upb_set_prio_iexport_req_refor" />
                                                        <input type="hidden" name="iexport_req_refori[]" class="iexport_req_refori" value="">
                                                        <input readonly="readonly" style="width: 60%" class="input_tgl upb_set_prio_iexport_req_refor iexport_req_refor" type="text" name="iupb_nomor" value="" />
                                                        <button class="btn_browse_upd" type="button" onclick="javascript:get_upb_exists();javascript:browse_multi1_setting_prioritas_prareg('<?php echo $browse_url ?>&pdId=<?php echo $dUdahPrio['iTeamPD'] ?>','List Request Refor',this,'iexport_req_refor='+$('.list_updid_exists').val());return false;">...</button>
                                                        <input type="hidden" name="list_updid_exists" class="list_updid_exists" value=""/>
                                                    </td>
                                                    <td style="border: 1px solid #dddddd; width: 15%; text-align: center"><div class="upb_set_prio_vUpd_no"></div></td>
                                                    <td style="border: 1px solid #dddddd; width: 40%; text-align: left"><div class="upb_set_prio_vNama_usulan"></div></td>
                                                    <td style="border: 1px solid #dddddd; width: 10%;"><span class="delete_btn "><a href="javascript:;" class="table_upb_prioritas_rincian_del" onclick="del_row(this, 'table_upb_prioritas_rincian_del')">[Delete]</a></span></td>
                                                </tr>

                                        <?php
                                        }
                                        ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4"></td>
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
                                </tfoot>
                            </table>
                        </div>			
                    </div>
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