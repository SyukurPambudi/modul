<?php 
//echo $mydept.'ini teamnya';
		$o='';
			//Get Status Leader
			$sql_j="select * from pk.pk_master ma where ma.idmaster_id=".$this->input->get('id')." and ma.ldeleted=0";
			$qt=$this->db->query($sql_j)->row_array();
			$it='';
			$is_confirm_karyawan=$qt['is_confirm_karyawan'];
			$iSubmit=$qt['iSubmit'];
            $teamid = $qt['iteam_id'];
            $year1 = date('Y', strtotime($qt['tgl1']));
            $month1 = date('m', strtotime($qt['tgl1']));
            $year2 = date('Y', strtotime($qt['tgl2']));
            $month2 = date('m', strtotime($qt['tgl2']));  
            $period1 = $year1.$month1;
            $period2 = $year2.$month2;              
            
			if($qt['vnip']==$vnip){
				$it='<input type="hidden" name="it" id="it" value="0" />';
				$type=0;
			}else{
				$it='<input type="hidden" name="it" id="it" value="1" />';
				$type=1;
			}
			if($type==0){
                $sqlp ="select 4 as ikategory_id, ".$teamid." as iteam_id, CONCAT(a.problem_subject,' (',a.id,')') AS parameter,
                    0 as is_auto, 'SDMPO' as vFunction, 0 AS iparameter_id, 0  AS bobot,a.id as ssid
                    from hrd.ss_raw_problems a 
                    inner join hrd.ss_raw_pic b on b.rawid = a.id and b.pic = '$vnip' and b.iRoleId =1
                    where (EXTRACT( YEAR_MONTH FROM a.dTarget_implement ) between '$period1' and '$period2' or
                    EXTRACT( YEAR_MONTH FROM a.dcloseGm ) between '$period1' and '$period2')
                    and a.iStatus in (4,5,6,7,12,13) and
                    a.id not in (select ssid from pk.pk_parameter_po where idmaster_id <> ".$this->input->get('id').")
                    GROUP BY CONCAT(a.problem_subject,' (',a.id,')') ";  
			}else{
				$sqlp='select * from pk.pk_nilai ni
						inner join pk.pk_parameter_po pa on ni.iparameter_id=pa.iparameter_id and ni.idmaster_id= pa.idmaster_id
						where ni.idmaster_id='.$this->input->get('id').' and pa.ikategori_id=4 and pa.iteam_id='.$teamid;
			}
            //echo $sqlp;
			$queryp = $this->db->query($sqlp);
		if($queryp->num_rows()>0) {
			$rows = $queryp->result_array();
			
			$o = '<div id="target_'.$id.'">';
			$o .= '<style>';
			$o .= '.table_pk, table_pk th, table_pk tr, .table_pk td, .table_pk thead, .table_pk tbody{
					border:1px solid #c5dbec;
					}
					.table_pk tbody tr th{
						text-align:left;
					}';
			$o .='</style>';
			$o .= $it;
			$o .= '<table width="100%" height="100%" class="table_pk">';
			$o .= '<thead style="background-color:#5c9ccc;color:#effff0;">';
			$o .= '<tr>';
			$o .= '<th rowspan="2">I</th>';
			$o .= '<th rowspan="2" colspan="2">PERFORMANCE OBJECTIVE</th>';
            $o .= '<th rowspan="2" >KALKULASI</th>';
			$o .= '<th colspan="2">POIN PENILAIAN</th>';
			$o .= '<th rowspan="2" width=100>POIN SEPAKAT</th>';
			$o .= '<th rowspan="2" width=100>BOBOT</th>';
			$o .= '<th rowspan="2" width=100>BOBOT * SEPAKAT</th>';
			$o .= '</tr>';
			$o .= '<tr>';
			$o .= '<th width=100>KARYAWAN</th>';
			$o .= '<th width=100>ATASAN</th>';
			$o .= '</tr>';
			$o .= '</thead>';
			$o .= '<tbody style="">';

			$nomor=1;
			foreach($rows as $key => $row) {
				$vFunction = $row['vFunction'];
                $ssid = $row['ssid'];
				$parameter = $row['parameter'];
				//$iparameter_id=$row['iparameter_id'];
                $iparameter_id=$nomor;
				$is_auto = $row['is_auto'];
				$bobot = $row['bobot'];
				$o.='<tr style="background-color:#EFEFEF;"><th width="10px">'.$nomor.'</th>';
                $o.='<th colspan="2">
						<input type="hidden" value="'.$parameter.'" id="parameter_'.$nomor.'" class="tabs4" name="parameter_'.$nomor.'" />
						<p id="lbl_parameter_'.$nomor.'">'
							.$parameter.'
						</p>
					</th>';
				$o.=' <th colspan="2">
						<input type="hidden" value="'.$ssid.'" id="ssid_'.$nomor.'" class="tabs4" name="ssid_'.$nomor.'" />
					</th><th></th><th></th><th></th><th></th>';
                $o .='<input type="hidden" value="'.$iparameter_id.'" id="req_tab4_'.$iparameter_id.'" class="required_par_tab4">';
				$o .='</tr>';
				//Cek Nilai;
                $cek_nilai='select * from pk.pk_nilai ni
    				inner join pk.pk_parameter_po pa on ni.iparameter_id=pa.iparameter_id and pa.idmaster_id=ni.idmaster_id
    				where ni.idmaster_id='.$this->input->get('id').' and pa.ikategori_id=4 and pa.iteam_id='.$teamid.' and  ni.iparameter_id='.$nomor.' LIMIT 1';     

 
            	$qcek = $this->db->query($cek_nilai);
				$nilai="0";
				$pk="0";
				$ps="0";
				$po="0";
                $bobot = 0;
                $kalkulasi = 0;
                $curr_score = '';
				if($qcek->num_rows()>0) {
					$dr = $qcek->row_array();
                    $bobot = number_format(($dr['bobot'])*100,2);
					$calc = number_format(($dr['hasil_calc']),2);
					$kalkulasi = !is_null($dr['hasil_calc']) ? $calc : "NULL";
                    $curr_score = number_format($dr['poin'],2);
                    //$kalkulasi = number_format(($dr['hasil_calc']),2);
					if($type==0){
						$nilai=number_format($dr['poin'],0);
						$pk=number_format($dr['poin'],0);
						$ps=number_format($dr['poin_sepakat'],0);
						$po=number_format($dr['poin_sepakat_atasan'],0);
					}else{
						$nilai=number_format($dr['poin_sepakat'],0);
						$pk=number_format($dr['poin'],0);
						$ps=number_format($dr['poin_sepakat'],0);
						$po=number_format($dr['poin_sepakat_atasan'],0);
					}
				}else{
					$nilai='0';
				}

				
				$sqlpd = "select * from pk.pk_po_deskripsi";
				$querypd = $this->db->query($sqlpd);
				// tidak auto 
				if($querypd->num_rows()>0) {
					$rows_ = $querypd->result_array();
					$btnHitung = '<div><span></span><br/><p style="display:none;">Loading...</p></div>';
                    
					$npoint= '';
					$npointsepatas= '';
					$npointsepakat = '';
					$vpoinsepakat = '';
					$vnilai = '';

					$parpar='<input id="parameter_'.$iparameter_id.'" class="parameters tabs4" type="hidden"  name="iparameter_id[]" value="'.$iparameter_id.'">';
					$hashas='<input id="hasil_'.$iparameter_id.'" class="hasils tabs4" type="hidden" name="hasil_calc[]" value="'.$nilai.'">';
					$poipoi='<input id="poin_'.$iparameter_id.'" class="poins tabs4" type="hidden" name="poin[]" value="'.$nilai.'">';

					
					$o.='<tr bgcolor="#FFFFFF"><td>'.$npointsepatas.$parpar.$hashas.$poipoi.'</td><td style="margin:0;padding:0" colspan="2"><table width="100%" height="100%" cellspacing="0" cellpadding="2" class="table_tab4_row_'.$iparameter_id.'">';
					
					foreach($rows_ as $key_ =>$row_) {

						$deskripsi = $row_['deskripsi'];
						$poin = $row_['poin'];
						$mcalc = $row_['iCondition'];
						$bgcolor = '#FFF';
                        //$vkalkulasi =  $row_['deskripsi'];
                        $highlight = ($curr_score==$poin)?'color:#FFF;background:blue;':'';
                        
                        $btnHitung = '<div><span>'.$kalkulasi.'</span><br/><a href="javascript:void(0);" 
                            onclick="calculate_all_rincian_hitung_tab4($(this),\''.$vFunction.'\',\''.$iparameter_id.'\',\''.$poin.'\',\''.$mcalc.'\',\''.$ssid.'\');">Hitung</a><p style="display:none;">Loading...</p></div>';
						
                        $btnDetails= '</span><br/><a href="javascript:void(0);" 
                            onclick="$(\'#alert_dialog_form\').detach();browse(\''.base_url().'processor/pk/browse/details/performance/sdm?action=view&field=browse_details_performance_sdm&id='.$this->input->get("id").'&ssid='.$ssid.'&iparameter_id='.$iparameter_id.'&foreign_key='.$this->input->get("foreign_key").'&company_id='.$this->input->get("company_id").'&group_id='.$this->input->get("group_id").'&modul_id='.$this->input->get("modul_id").'\',\'Performance Objective\',\'\',\'\');">Details</a>';
						
                        $check = $poin==$nilai? 'checked':'';                      
                        
						$o.='<tr bgcolor="'.$bgcolor.'" style="'.$highlight.'">
							<td width="80%">'.$deskripsi.'</td><td align="right" class="lbl_'.$poin.'">'.$poin.' ';
							//<input type="radio" id="mpoin_'.$iparameter_id.'"  name="poin[]_'.$iparameter_id.'" value="'.$poin.'"  onclick="calculate_all_rincian_hitung_tab4($(this),\''.$vFunction.'\',\''.$iparameter_id.'\',\''.$poin.'\',\''.$mcalc.'\');" '.$check.'>';
						$o.='<script>';
						$o.='$(function() {
						    var $radios = $(\'[id=lbl_poin_karyawan_'.$iparameter_id.']\');
						     var color = "#ffb84d";
						        var nilai = parseInt($radios.val());
								switch (nilai) {
									case 100:
										color="#66ccff";
										break;
									case 80:
										color="#00ff00";
										break;
									case 60:
										color="#ffff66";
										break;
									case 40:
										color="#ffb84d";
										break;
									case 20:
										color="#ff4d4d";
										break;
									default:
										color="#ffffff";
										break;
								}
								$radios.parent().find("td").css({"background":"#ffffff"});
								$radios.parent().css({"background":color});
								$radios.parent().parent().children().css({"background":color});
						       
						});';
						$o.='</script>';
						$o.='</td>
						</tr>';
					}
					
					$bo=$bobot*100;
					$ni=0;
					if($po!=0){
						$ni=($po*$bobot)/100;
					}
					//$o.='</table></td>';
                    $o.='</table></td><td align="center">'.$btnHitung.'
                    <br align="center">'.$btnDetails.' ';
					$o.='<td align="center"><input type="hidden" value="'.$pk.'" id="poin_karyawan_'.$iparameter_id.'" class="tabs4" name="poin_karyawan_'.$iparameter_id.'" /><p id="lbl_poin_karyawan_'.$iparameter_id.'">'.$pk.'</p></td>';
					$o.='<td align="center"><input type="hidden" value="'.$ps.'" id="poin_pimpinan_'.$iparameter_id.'" class="tabs4" name="poin_pimpinan_'.$iparameter_id.'" /><p id="lbl_poin_pimpinan_'.$iparameter_id.'">'.$ps.'</p></td>';
					if($qt['vnip']==$vnip){
						$o.='<td align="center"><input type="hidden" value="'.$po.'" id="sepakat_'.$iparameter_id.'" class="tabs4" name="sepakat_'.$iparameter_id.'" /><p id="lbl_sepakat_'.$iparameter_id.'">'.$po.'</p></td>';
					}else{
						$o.='<td align="center"><input type="text" value="'.$po.'" id="sepakat_'.$iparameter_id.'" class="tabs4" name="sepakat_'.$iparameter_id.'" /><p id="lbl_sepakat_'.$iparameter_id.'"></td>';
						$o.='<script>';
						$o.='$("#sepakat_'.$iparameter_id.'").change(function(){
							var ats = Number($("#poin_pimpinan_'.$iparameter_id.'").val());
							var kar = Number($("#poin_karyawan_'.$iparameter_id.'").val());
							var ini = Number($(this).val());
							if(ats==0){
								_custom_alert("Nilai Terlebih dahulu!","Error!","info");
								$(this).val(kar);
								return false;
							}
							if(kar>ats){
								if(ini>kar){
									_custom_alert("Nilai Sepakat Tidak Boleh Lebih / Kurang dari interval ("+ats+"-"+kar+")!","Error!","info");
									$("#sepakat_'.$iparameter_id.'").val(kar);
									return false;
								}else if(ini<ats){
									_custom_alert("Nilai Sepakat Tidak Boleh Lebih / Kurang dari interval ("+ats+"-"+kar+")!","Error!","info");
									$("#sepakat_'.$iparameter_id.'").val(kar);
									return false;
								}
							}
							if(ats>kar){
								if(ini>ats){
									_custom_alert("Nilai Sepakat Tidak Boleh Lebih / Kurang dari interval ("+kar+"-"+ats+")!","Error!","info");
									$("#sepakat_'.$iparameter_id.'").val(kar);
									return false;
								}else if(ini<kar){
									_custom_alert("Nilai Sepakat Tidak Boleh Lebih / Kurang dari interval ("+kar+"-"+ats+")!","Error!","info");
									$("#sepakat_'.$iparameter_id.'").val(kar);
									return false;
								}
							}

							if(kar==ats){
								_custom_alert("Nilai sama, tidak bisa di rubah!","Error!","info");
								$("#sepakat_'.$iparameter_id.'").val(kar);
								return false;
							}
							var bobot= Number('.$bobot.');
							var n = Number((bobot * ini)/100);
							$("#lbl_nilai_'.$iparameter_id.'").text(n);

						});';
						$o.='</script>';
					}
					//$o.='<td align="center"><input type="hidden" value="'.$bobot.'" id="bobot_'.$iparameter_id.'" class="tabs4" name="bobot_'.$iparameter_id.'" />'.$bo.' %</td>';
					$o.='<td align="center"><input type="text" size = "3"  value="'.$bobot.'" id="bobot_'.$nomor.'" class="tabs4" name="bobot_'.$nomor.'" /> %</td>';
                    $o.='<td align="center"><input type="hidden" value="" id="nilai_'.$iparameter_id.'" class="tabs4" name="nilai_'.$iparameter_id.'" /><p id="lbl_nilai_'.$iparameter_id.'">'.$ni.'</p></td>';
					$o.='</tr>';
				}
			$nomor++;	
			}
			$o.= '</tbody></table></div>';
			
			$o.= '<script type="text/javascript">';
			$o.='';
			$o.= 'function calculate_all_rincian_hitung_tab4(o, vFunction,iparameter_id,mPoin,mCalc, ssid) {
					var url = "'.base_url().'processor/pk/pk_softdev_mgr?action=calculate_all_rincian_hitung";
					var date1 = $("#pk_softdev_mgr_tgl1").val();
					var date2 = $("#pk_softdev_mgr_tgl2").val();
					var periode = $("#calculate_all_cPeriode").val();
					var itim_id = $("#itim").val();
					var nippemohon = $("#nippemohon").val();
					var bobot = $("#bobot").val();
                    

					var curnew = o.parent().parent().parent().parent().parent().next().children();
					if (mCalc == 0) {
						var loading = o.parent().find("p");
					}else{
						var loading = o.parent().parent().parent().parent().parent().next().children().find("p");	
					}
					

					if( date1 == \'\' || date2 == \'\'  || periode == \'\' ) 
					{
						alert("Periode cannot empty!");
						return false;
					}
					
					o.hide();
					loading.show();
					var color = "#ffffff";
                    var calPoin = parseFloat($("#poin_karyawan_"+iparameter_id).val());
					switch (calPoin) {
						case "100":
							color="#66ccff";
							break;
						case "80":
							color="#00ff00";
							break;
						case "60":
							color="#ffff66";
							break;
						case "40":
							color="#ffb84d";
							break;
						case "20":
							color="#ff4d4d";
							break;
						default:
							color="#ffffff";
							break;
					}
                    //alert(calPoin);
					//o.parent().parent().parent().find("td").css({"background":"#ffffff"});
					//o.parent().css({"background":color});
					//o.parent().parent().children().css({"background":color});
					//o.closest("tr").find("tr").css({"background":"transparent","color":"#000"});
					
					$.ajax({
						url: url,
						data: { vFunction:vFunction, date1:date1, date2:date2, periode:periode, mPoin:mPoin, mCalc:mCalc, itim_id:itim_id, nippemohon:nippemohon, ssid:ssid},
						type: "post",
						dataType: "json",
						success: function(data) {
							o.show();
							loading.hide();
							
							if(!data.error) {
    							var fldHasil = 	$(\'<input>\').attr({
													    type: \'hidden\',
													    id: \'hasil_\'+iparameter_id,
													    class: \'hasils tabs4\',
													    name: \'hasil_calc[]\',
													    value: data.hasil
													});
								var fldScore = 	$(\'<input>\').attr({
													    type: \'hidden\',
													    id: \'poin_\'+iparameter_id,
													    class: \'poins tabs4\',
													    name: \'poin[]\',
													    value: data.score
													});
								$("#req_tab4_"+iparameter_id).val(data.score);
								
								$("#hasil_"+iparameter_id).val(data.hasil);
								$("#poin_"+iparameter_id).val(data.score);';
								if($type==0){
									$o.='$("#poin_karyawan_"+iparameter_id).val(data.score);';
									$o.='$("#lbl_poin_karyawan_"+iparameter_id).text(data.score);';
								}else{
									$o.='$("#poin_pimpinan_"+iparameter_id).val(data.score);';
									$o.='$("#lbl_poin_pimpinan_"+iparameter_id).text(data.score);';
								}

								$o.='if (data.is_auto == 1) {
    									var z = o.closest("tr").find(".lbl_"+data.score);
    									z.parent().css({"background":"blue","color":"#fff"});
    									o.parent().find("span").text( data.hasil );
    									//o.parent().find("span").append( fldHasil ).append(fldScore);
    								}else{
    									var url2 = "'.base_url().'processor/pk/pk_softdev_mgr?action=calculate_bobot";
    									var k = parseFloat($("#poin_karyawan_"+iparameter_id).val());
    									var p = parseFloat($("#poin_pimpinan_"+iparameter_id).val());
    									var b = parseFloat($("#bobot_"+iparameter_id).val());';
								if($qt['vnip']==$vnip){
									$o.='$("p.#lbl_sepakat_"+iparameter_id).text(parseFloat(k+p));
										$("input.#sepakat_"+iparameter_id).val(parseFloat(k+p));
										var n = (parseFloat(k*b))/100;
										';

								}else{
									$o.='$("input.#sepakat_"+iparameter_id).val(parseFloat((k+p)/2));
										var n = (parseFloat(((k+p)/2)*b))/100;
									';
								}
								$o.='
									$("#nilai_"+iparameter_id).val(n);
									$("#lbl_nilai_"+iparameter_id).text(n);';

								$o.='curnew.find("span").text( data.hasil );
									//curnew.find("span").append( fldHasil ).append(fldScore);	
								}
								
							} else {
								alert( data.message );
							}';
                         
                            if($qt['vnip']==$vnip){
								$o.='
    									var k = parseFloat($("#poin_karyawan_"+iparameter_id).val());
    									var b = parseFloat($("#bobot_"+iparameter_id).val());
                                        var n = (parseFloat(k*b)/100);
                                        $("#lbl_sepakat_"+iparameter_id).text(k); 
                                        $("input.#sepakat_"+iparameter_id).val(parseFloat(k));
                                    ';                                
									

							}else{
								$o.='
                                    var b = parseFloat($("#bobot_"+iparameter_id).val());
                                    var p = parseFloat($("#poin_pimpinan_"+iparameter_id).val());  
                                    var k = parseFloat($("#poin_karyawan_"+iparameter_id).val());
									var n = (parseFloat(((k+p)/2)*b)/100);                                                                      
                                    $("input.#sepakat_"+iparameter_id).val(parseFloat((k+p)/2));

								';
							}

                            $o.='$("#lbl_nilai_"+iparameter_id).text(n);   
                                 
                                                                           
						}
					});

					
				  }';
			$o.= '</script>';
		}
		echo $o;
		
 ?>	
 <br />	
 <div><?php
 	if ($this->input->get('action') == 'view') {
 	}else{
 	//$ca='<button type="button" id="submit_draft_tab1" class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary">Save as Draft</button>';
	$ca='<button type="button" id="submit_tab4" class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary">Save</button>';
	if($type==0){
		if($is_confirm_karyawan==0){
			echo $ca;
		}
	}else{
		if($iSubmit<5){
			if($is_confirm_karyawan<=3 ){
				echo $ca;
			}
		}
	}
 	}
	?>
</div>


<script type="text/javascript">
	$( "tr.trdetil:not(:first)" ).find('th.thdetil').text("");

	$('#submit_draft_tab4').die();
	$('#submit_draft_tab4').live('click', function(){
		var iparameter_id = $('input.parameters').serialize();
		var hasil_calc = $('input.hasils').serialize();
		var poin = $('input.poins').serialize();
		var BASE_URL = "<?php echo base_url();?>";
		var idmaster_id = $('#idmaster_id').val();
		var modul_id = $('#idmaster_id').val();
		var company_id  = $('#idmaster_id').val();
		var group_id= $('#idmaster_id').val();
		var itim_id = $("#itim").val();
		var it = $("#it").val();
		return $.ajax({
			url: BASE_URL+'processor/pk/pk_softdev_mgr?action=performance_obj_calc',
			type: 'post',
			//data: 'parameter='+iparameter_id+'&hasil_calc='+hasil_calc+'&poin='+poin,
			data: $('input.tabs4').serialize()+'&idmaster_id='+idmaster_id+'&iSubmit=1'+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id+'&itim='+itim_id+'&it='+it,
			beforeSend: function(xhr, opts) {
					var req = $(".required_par_tab4");
					var conf=0;
					$.each(req, function(i,v){
						if($(this).val() == "") {
							var id = $(this).attr("id");
							conf++;
						}		
					});
						
//					if(conf > 0) {
//						alert("Semua Parameter Harus Diisi");
//						xhr.abort();
//					}

			},
			success: function(data) {
				var o = $.parseJSON(data);												
				var info = 'Info';
				var header = 'Info';
				var last_id =idmaster_id;
					if(o.status == true) {
						_custom_alert("Data Tersimpan","Info","Info","", 1, 20000);
						$('#grid_pk_softdev_mgr').trigger('reloadGrid');
						$.get(base_url+'processor/pk/pk/softdev/mgr?action=update&foreign_key=0&company_id='+company_id+'&idnya='+last_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
		                    $('div#form_pk_softdev_mgr').html(data);
		                    $('html, body').animate({scrollTop:$('#grid_pk_softdev_mgr').offset().top - 20}, 'slow');
		            	});
		            }

			}
		});
		
	});

	$('#submit_tab4').die();
	$('#submit_tab4').live('click', function(){
		var iparameter_id = $('input.parameters').serialize();
		var hasil_calc = $('input.hasils').serialize();
		var poin = $('input.poins').serialize();
		var BASE_URL = "<?php echo base_url();?>";
		var idmaster_id = $('#idmaster_id').val();
		var modul_id = $('#idmaster_id').val();
		var company_id  = $('#idmaster_id').val();
		var group_id= $('#idmaster_id').val();
		var itim_id = $("#itim").val();
		var it = $("#it").val();
		return $.ajax({
			url: BASE_URL+'processor/pk/pk_softdev_mgr?action=performance_obj_calc',
			type: 'post',
			//data: 'parameter='+iparameter_id+'&hasil_calc='+hasil_calc+'&poin='+poin,
			data: $('input.tabs4').serialize()+'&idmaster_id='+idmaster_id+'&iSubmit=2'+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id+'&itim='+itim_id+'&it='+it,
			beforeSend: function(xhr, opts) {
					var req = $(".required_par_tab4");
					var conf=0;
					$.each(req, function(i,v){
						if($(this).val() == "") {
							var id = $(this).attr("id");
							conf++;
						}		
					});
					if(conf > 0) {
						alert("Semua Parameter Harus Diisi");
						xhr.abort();
					}

			},
			success: function(data) {
				var o = $.parseJSON(data);												
				var info = 'Info';
				var header = 'Info';
				var last_id =idmaster_id;
					if(o.status == true) {
						_custom_alert("Data Tersimpan","Info","Info","", 1, 20000);
						$('#grid_pk_softdev_mgr').trigger('reloadGrid');
						$.get(base_url+'processor/pk/pk/softdev/mgr?action=update&foreign_key=0&company_id='+company_id+'&idnya='+last_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
		                    $('div#form_pk_softdev_mgr').html(data);
		                    $('html, body').animate({scrollTop:$('#grid_pk_softdev_mgr').offset().top - 20}, 'slow');
		            	});
		            }
			}
		});
		
	});


</script>