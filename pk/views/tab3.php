<?php 
//echo $mydept.'ini teamnya';
		$o='';
			
			// Get Team 
			
			$sql_tim ='select a.vteam,iteam_id from plc2.plc2_upb_team a where a.ldeleted=0 and a.iteam_id in ("'.$team_id.'")';
			$qteam = $this->db->query($sql_tim)->row_array();
			$itim= $qteam['iteam_id'];

			//Get Status Leader
			$sql_j="select * from plc2.pk_master ma where ma.idmaster_id=".$this->input->get('id')." and ma.ldeleted=0";
			$qt=$this->db->query($sql_j)->row_array();
			$it='';
			$iSubmit=$qt['is_confirm_karyawan'];
			$type=0;
			if(!in_array($this->user->gNIP, $data_open)){
				if($qt['vnip']==$vnip){
					$it='<input type="hidden" name="it" id="it" value="0" />';
					$type=0;
				}else{
					$it='<input type="hidden" name="it" id="it" value="1" />';
					$type=1;
				}
			}
			if($type==0){
			// get parameter PK Busdev
				$sqlp ='select * from plc2.pk_parameter a where a.ldeleted=0 and a.ikategori_id=3 and a.iteam_id ="'.$itim.'" ';
			}else{
				$sqlp='select * from plc2.pk_nilai ni
						inner join plc2.pk_parameter pa on ni.iparameter_id=pa.iparameter_id
						where ni.idmaster_id='.$this->input->get('id').' and pa.ikategori_id=3';
			}
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
			$o .= '<th rowspan="2">III</th>';
			$o .= '<th rowspan="2" colspan="2">KEPEMIMPINAN</th>';
			$o .= '<th colspan="2">POIN PENILAIAN</th>';
			$o .= '<th rowspan="2" width=100>POIN SEPAKAT</th>';
			$o .= '<th rowspan="2" width=100>NILAI BOBOT</th>';
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
				$parameter = $row['parameter'];
				$iparameter_id=$row['iparameter_id'];
				$is_auto = $row['is_auto'];
				$bobot = $row['bobot'];
				$o.='<tr style="background-color:#EFEFEF;"><th width="10px">'.$nomor.'</th><th colspan="2">'.$parameter.'</th><th colspan="2"></th><th></th><th></th>';
				$o .='<input type="hidden" value="'.$iparameter_id.'" id="req_tab3_'.$iparameter_id.'" class="required_par_tab3">';
				$o .='</tr>';


				//Cek Nilai;
				$cek_nilai ="select * from plc2.pk_nilai ni
					inner join plc2.pk_parameter pa on ni.iparameter_id=pa.iparameter_id
					where pa.ikategori_id=3 and pa.ldeleted=0 and ni.ldeleted=0 and ni.iparameter_id=".$iparameter_id." and ni.idmaster_id=".$this->input->get('id')." LIMIT 1";	
				$qcek = $this->db->query($cek_nilai);
				$nilai="0";
				$pk="0";
				$ps="0";
				$po="0";
				if($qcek->num_rows()>0) {
					$dr = $qcek->row_array();
					if($type==0){
						$nilai=$dr['poin'];
						$pk=$dr['poin'];
						$ps=$dr['poin_sepakat_atasan'];
						$po=$dr['poin_sepakat'];
					}else{
						$nilai=$dr['poin_sepakat_atasan'];
						$pk=$dr['poin'];
						$ps=$dr['poin_sepakat_atasan'];
						$po=$dr['poin_sepakat'];
					}
				}else{
					$nilai='0';
				}

				
				$sqlpd = "select * from plc2.pk_parameter_detail a where a.ldeleted=0 and a.iparameter_id='".$iparameter_id."' order by a.iUrut";
				$querypd = $this->db->query($sqlpd);
				// tidak auto 
				if($querypd->num_rows()>0) {
					$rows_ = $querypd->result_array();
					$btnHitung = '<div><span></span><br/><p style="display:none;">Loading...</p></div>';
					$curr_score = '';
					$npoint= '';
					$npointsepatas= '';
					$npointsepakat = '';
					$vpoinsepakat = '';
					$vnilai = '';

					$parpar='<input id="parameter_'.$iparameter_id.'" class="parameters tabs3" type="hidden"  name="iparameter_id[]" value="'.$iparameter_id.'">';
					$hashas='<input id="hasil_'.$iparameter_id.'" class="hasils tabs3" type="hidden" name="hasil_calc[]" value="'.$nilai.'">';
					$poipoi='<input id="poin_'.$iparameter_id.'" class="poins tabs3" type="hidden" name="poin[]" value="'.$nilai.'">';

					
					$o.='<tr bgcolor="#FFFFFF"><td>'.$npointsepatas.$parpar.$hashas.$poipoi.'</td><td style="margin:0;padding:0" colspan="2"><table width="100%" height="100%" cellspacing="0" cellpadding="2" class="table_tab3_row_'.$iparameter_id.'">';
					
					foreach($rows_ as $key_ =>$row_) {
						$deskripsi = $row_['deskripsi'];
						$poin = $row_['poin'];
						$mcalc = $row_['iCondition'];
						$bgcolor = '#FFF';
						
						$check = $poin==$nilai? 'checked':'';
						$o.='<tr bgcolor="'.$bgcolor.'">

							<td width="80%">'.$deskripsi.'</td><td align="right" class="lbl_'.$poin.'">'.$poin.' 
							<input type="radio" id="mpoin_'.$iparameter_id.'"  name="poin[]_'.$iparameter_id.'" value="'.$poin.'"  onclick="calculate_all_rincian_hitung_tab3($(this),\''.$vFunction.'\',\''.$iparameter_id.'\',\''.$poin.'\',\''.$mcalc.'\');" '.$check.'>';
						$o.='<script>';
						$o.='$(function() {
						    var $radios = $(\'input:radio[id=mpoin_'.$iparameter_id.']:checked\');
						     var color = "#ffffff";
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
								$radios.parent().parent().parent().find("td").css({"background":"#ffffff"});
								$radios.parent().css({"background":color});
								$radios.parent().parent().children().css({"background":color});
						       
						});';
						$o.='</script>';
						$o.='</td>
						</tr>';
					}
					
					$bo=$bobot*100;
					$o.='</table></td>';
					$o.='<td align="center"><input type="hidden" value="'.$pk.'" id="poin_karyawan_'.$iparameter_id.'" class="tabs3" name="poin_karyawan_'.$iparameter_id.'" /><p id="lbl_poin_karyawan_'.$iparameter_id.'">'.$pk.'</p></td>';
					$o.='<td align="center"><input type="hidden" value="'.$ps.'" id="poin_pimpinan_'.$iparameter_id.'" class="tabs3" name="poin_pimpinan_'.$iparameter_id.'" /><p id="lbl_poin_pimpinan_'.$iparameter_id.'">'.$ps.'</p></td>';
					$o.='<td align="center"><input type="hidden" value="'.$bobot.'" id="bobot_'.$iparameter_id.'" class="tabs3" name="bobot_'.$iparameter_id.'" />'.$bo.' %</td>';
					$o.='<td align="center"><input type="hidden" value="'.$po.'" id="nilai_'.$iparameter_id.'" class="tabs3" name="nilai_'.$iparameter_id.'" /><p id="lbl_nilai_'.$iparameter_id.'">'.$po.'</p></td>';
					$o.='</tr>';
				}
			$nomor++;	
			}
			$o.= '</tbody></table></div>';
			
			$o.= '<script type="text/javascript">';
			$o.='';
			$o.= 'function calculate_all_rincian_hitung_tab3(o, vFunction,iparameter_id,mPoin,mCalc) {
					var url = "'.base_url().'processor/pk/pk_busdev?action=calculate_all_rincian_hitung";
					var date1 = $("#calculate_all_cPeriode_1").val();
					var date2 = $("#calculate_all_cPeriode_2").val();
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
					
					//o.hide();
					//loading.show();
					var color = "#ffffff";
					switch (mPoin) {
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
					o.parent().parent().parent().find("td").css({"background":"#ffffff"});
					o.parent().css({"background":color});
					o.parent().parent().children().css({"background":color});
					//o.closest("tr").find("tr").css({"background":"transparent","color":"#000"});
					
					$.ajax({
						url: url,
						data: { vFunction:vFunction, date1:date1, date2:date2, periode:periode, mPoin:mPoin, mCalc:mCalc, itim_id:itim_id, nippemohon:nippemohon},
						type: "post",
						dataType: "json",
						success: function(data) {
							o.show();
							loading.hide();
							
							if(!data.error) {
								
								

								var fldHasil = 	$(\'<input>\').attr({
													    type: \'hidden\',
													    id: \'hasil_\'+iparameter_id,
													    class: \'hasils tabs3\',
													    name: \'hasil_calc[]\',
													    value: data.hasil
													});
								var fldScore = 	$(\'<input>\').attr({
													    type: \'hidden\',
													    id: \'poin_\'+iparameter_id,
													    class: \'poins tabs3\',
													    name: \'poin[]\',
													    value: data.score
													});
								


								$("#req_tab3_"+iparameter_id).val(data.score);
								
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
									var url2 = "'.base_url().'processor/pk/pk_busdev?action=calculate_bobot";
									var k = parseFloat($("#poin_karyawan_"+iparameter_id).val());
									var p = parseFloat($("#poin_pimpinan_"+iparameter_id).val());
									var b = parseFloat($("#bobot_"+iparameter_id).val());
									var n = parseFloat((k+p)/2*b);
									$("#nilai_"+iparameter_id).val(n);
									$("#lbl_nilai_"+iparameter_id).text(n);
									curnew.find("span").text( data.hasil );
									//curnew.find("span").append( fldHasil ).append(fldScore);	
								}
								
							} else {
								
								alert( data.message );
							}
							
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
	 	//$ca='<button type="button" id="submit_draft_tab3" class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary">Save as Draft</button>';
		$ca='<button type="button" id="submit_tab3" class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary">Save</button>';
	 	if($type==0){
	 	 	if($iSubmit==0){
	 	 		echo $ca;
	 	 	}
	 	}else{
	 	 	if($iSubmit<=3){
	 	 		echo $ca;
	 	 	}
	 	}
 	}
	?>
</div>


<script type="text/javascript">
	$( "tr.trdetil:not(:first)" ).find('th.thdetil').text("");

	$('#submit_draft_tab3').die();
	$('#submit_draft_tab3').live('click', function(){
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
			url: BASE_URL+'processor/pk/pk_busdev?action=pimpin_calc',
			type: 'post',
			//data: 'parameter='+iparameter_id+'&hasil_calc='+hasil_calc+'&poin='+poin,
			data: $('input.tabs3').serialize()+'&idmaster_id='+idmaster_id+'&iSubmit=1'+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id+'&itim='+itim_id+'&it='+it,
			beforeSend: function(xhr, opts) {
					var req = $(".required_par_tab3");
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
						$('#grid_pk_busdev').trigger('reloadGrid');
						$.get(base_url+'processor/pk/pk/busdev?action=update&foreign_key=0&company_id='+company_id+'&idnya='+last_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
		                    $('div#form_pk_busdev').html(data);
		                    $('html, body').animate({scrollTop:$('#grid_pk_busdev').offset().top - 20}, 'slow');
		            	});
		            }

			}
		});
		
	});

	$('#submit_tab3').die();
	$('#submit_tab3').live('click', function(){
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
			url: BASE_URL+'processor/pk/pk_busdev?action=pimpin_calc',
			type: 'post',
			//data: 'parameter='+iparameter_id+'&hasil_calc='+hasil_calc+'&poin='+poin,
			data: $('input.tabs3').serialize()+'&idmaster_id='+idmaster_id+'&iSubmit=2'+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id+'&itim='+itim_id+'&it='+it,
			beforeSend: function(xhr, opts) {
					var req = $(".required_par_tab3");
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
						$('#grid_pk_busdev').trigger('reloadGrid');
						$.get(base_url+'processor/pk/pk/busdev?action=update&foreign_key=0&company_id='+company_id+'&idnya='+last_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
		                    $('div#form_pk_busdev').html(data);
		                    $('html, body').animate({scrollTop:$('#grid_pk_busdev').offset().top - 20}, 'slow');
		            	});
		            }
			}
		});
		
	});


</script>