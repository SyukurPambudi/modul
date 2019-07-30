<?php 
//print_r($mydept);
		$o='';
			
			// Get Team 
			$sql_j="select * from pk.pk_master ma where ma.idmaster_id=".$this->input->get('id')." and ma.ldeleted=0";
			$qt=$this->db->query($sql_j)->row_array();
			$it='';
			$is_confirm=$qt['is_confirm'];
			$is_confirm_karyawan=$qt['is_confirm_karyawan'];
			$teamid = $qt['iteam_id'];
			if($qt['vnip']==$vnip){
				if($is_confirm_karyawan==0){
					$iSubmit=1;
				}else{
					$iSubmit=2;
				}
				$type=0;
			}else{
				$it='<input type="hidden" name="it" id="it" value="1" class="required_par" />';
				$type=1;
			}

			$iatasan=0;
			if($datemployee['cUpper']==$vnip){
				$iatasan=1;
			}
			
			// get parameter PK TS
			if($type==0){
				$sqlp ="select a.*,kat.kategori 
                from pk.pk_parameter a 
				    inner join pk.pk_kategori kat on kat.ikategori_id=a.ikategori_id
				where a.ldeleted=0 and a.ikategori_id=2 and kat.ldeleted=0 and a.iteam_id=".$teamid;
			}else{
				$sqlp='select * from pk.pk_nilai ni
						inner join pk.pk_parameter pa on ni.iparameter_id=pa.iparameter_id
						where ni.idmaster_id='.$this->input->get('id').' and pa.ikategori_id=2 and pa.iteam_id='.$teamid;
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
			$o.='<thead style="background-color:#5c9ccc;color:#effff0;">';
			$o.='<tr class="trdetil"><th align="right">II</th><th align="center">PERFORMANCE<th></th></th><th class="thdetil" ><span style="font-size:80%;">Point Penilaian Oleh <br> (Pemohon | Atasan)</span></th><th class="thdetil">Point Sepakat</th><th class="thdetil">Bobot</th><th class="thdetil">Nilai (Point x Bobot)</th>';
			$o.='</thead>';
			$nomor=1;
			foreach($rows as $key => $row) {
				$vFunction = $row['vFunction'];
				$parameter = $row['parameter'];
				$iparameter_id=$row['iparameter_id'];
				$is_auto = $row['is_auto'];
				$bobot = $row['bobot'];
				$o.='<tr class="trdetil"><th align="right">'.$nomor.'</th><th align="left">'.$parameter.'<th></th></th><th class="thdetil" ></th><th class="thdetil">Point Sepakat</th><th class="thdetil"></th><th class="thdetil"></th>';
				//$o.='<tr class="trdetil"><th align="right">'.$nomor.'</th><th align="left">'.$parameter.'<th></th></th><th class="thdetil" ><span style="font-size:80%;">Point Penilaian Oleh <br> (Pemohon | Atasan)</span></th><th class="thdetil">Point Sepakat</th><th class="thdetil">Bobot</th><th class="thdetil">Nilai (Point x Bobot)</th>';
				
				$sql_cek_nilai='select * from pk.pk_nilai a where a.idmaster_id="'.$idmaster_id.'" and a.iparameter_id="'.$iparameter_id.'"';
				$dcek = $this->db->query($sql_cek_nilai)->row_array();




				if($datemployee['cUpper']==$vnip){
					if ($dcek['flag_dinilai']==2) {
						$valval= $iparameter_id;			
					}else{
						$valval= "";			
					}

				}else{
					if ($dcek['flag_dinilai']==1) {
						$valval= $iparameter_id;			
					}else{
						$valval= "";			
					}
					
				}

				$o .='<input type="hidden" value="'.$valval.'" id="req_tab2_'.$iparameter_id.'" class="required_par">';
				
				$o .='</tr>';

				
				$sqlpd = "select * from pk.pk_parameter_detail a where a.ldeleted=0 and a.iparameter_id='".$iparameter_id."' order by a.iUrut ";
				$querypd = $this->db->query($sqlpd);

				if ($is_auto == 1) {
					if($querypd->num_rows()>0) {
						$rows_ = $querypd->result_array();
						$btnHitung = '<div><span></span><br/><a href="javascript:void(0);" onclick="calculate_all_rincian_hitung($(this),\''.$vFunction.'\',\''.$iparameter_id.'\');">Hitung</a><p style="display:none;">Loading...</p></div>';
						$curr_score = '';
						
						// sudah disubmit
						if($iSubmit > 0) {
							$sql = 'select * from pk.pk_nilai a where a.lDeleted=0 and a.iparameter_id="'.$iparameter_id.'" and a.idmaster_id="'.$idmaster_id.'"';
							$query = $this->db->query($sql);
							if($query->num_rows()>0) {
								$row = $query->row_array();
								$btnHitung = '<div><p id="nilai_hasil_c_'.$iparameter_id.'">';
								$btnHitung.= $row['hasil_calc'];
								$btnHitung.= '</p><br/><a href="javascript:void(0);" onclick="$(\'#alert_dialog_form\').detach();browse(\''.base_url().'processor/pk/browse/details/performance/ts?action=view&field=browse_details_performance&id='.$this->input->get("id").'&iparameter_id='.$iparameter_id.'&foreign_key='.$this->input->get("foreign_key").'&company_id='.$this->input->get("company_id").'&group_id='.$this->input->get("group_id").'&modul_id='.$this->input->get("modul_id").'\',\'Details PK-Paremeter '.$nomor.'\',\'\',\'\');">Details</a>';
								
							//	$btnHitung.='<input id="parameter_'.$iparameter_id.'" class="parameters tabs2" type="hidden" name="iparameter_id[]" value="'.$row['iparameter_id'].'">';
							//	$btnHitung.='<input id="hasil_'.$iparameter_id.'" class="hasils tabs2" type="hidden" name="hasil_calc[]" value="'.$row['hasil_calc'].'">';
							//	$btnHitung.='<input id="poin_'.$iparameter_id.'" class="poins tabs2" type="hidden" name="poin[]" value="'.$row['poin'].'">';
								
								if($iSubmit < 2){
									$btnHitung.= '</span><br/><a href="javascript:void(0);" onclick="calculate_all_rincian_hitung($(this),\''.$vFunction.'\',\''.$iparameter_id.'\');">Hitung Ulang</a><p style="display:none;">Loading...</p></div>';
								}else{
									if($iatasan==1) {
										$btnHitung.= '</span><br/><a href="javascript:void(0);" onclick="calculate_all_rincian_hitung_ats($(this),\''.$vFunction.'\',\''.$iparameter_id.'\');">Hitung</a><p style="display:none;">Loading...</p></div>';
									}else{
										if($is_confirm==1){
											$btnHitung.= '<br>Final Score';		
										}
									}
									
									
								}
								
								if($iatasan==1) {
									$curr_score = $row['poin_sepakat'];
								}else{
									$curr_score = number_format($row['poin'],2);
								}

								
								
							}
						}
						
						
						$o.='<tr bgcolor="#FFFFFF"><td></td><td style="margin:0;padding:0"><table width="100%" height="100%" cellspacing="0" cellpadding="2">';
						
						foreach($rows_ as $key_ =>$row_) {
							$deskripsi = $row_['deskripsi'];
							$poin = $row_['poin'];
							$bgcolor = ($key_%2)?'#EFEFEF':'';
							
							$highlight = ($curr_score==$poin)?'color:#FFF;background:blue;':'';
							
							$o.='<tr bgcolor="'.$bgcolor.'" style="'.$highlight.'"><td width="80%">'.$deskripsi.'</td><td align="right" class="lbl_'.$poin.'">'.$poin.'</td></tr>';
						}
						
						$sqlnil = "select * from pk.pk_nilai a where a.idmaster_id='".$idmaster_id."' and a.iparameter_id='".$iparameter_id."'";
						$dnil = $this->db->query($sqlnil)->row_array();
						
						$npoint= $dnil['poin'];
						$npointsepatas= $dnil['poin_sepakat'];
						$npointsepakat = (($npoint + $npointsepatas) / 2);
						$vpoinsepakat = number_format($npointsepakat,2);
						$vnilai = number_format(($vpoinsepakat*$bobot),2);

						if($iatasan==1) {
							$nilpoin=$dnil['poin_sepakat'];
							$nilhsl= $dnil['hasil_calc_ats'];
						}else{
							$nilpoin=$dnil['poin'];
							$nilhsl= $dnil['hasil_calc'];	
						}

						$peka='<input id="pk_'.$iparameter_id.'" class="pkas tabs2 required_par" type="hidden" name="pk[]" value="'.$row['ipk_nilai'].'">';
						$peka.='<input id="nilai_'.$iparameter_id.'" class="pkas tabs2 required_par" type="hidden" name="nilai[]" value="'.$vnilai.'">';
						$parpar='<input id="parameter_'.$iparameter_id.'" class="parameters tabs2 required_par" type="hidden" name="iparameter_id[]" value="'.$iparameter_id.'">';
						$hashas='<input id="hasil_'.$iparameter_id.'" class="hasils tabs2 required_par" type="hidden" name="hasil_calc[]" value="'.$nilhsl.'">';
						$poipoi='<input id="poin_'.$iparameter_id.'" class="poins tabs2 required_par" type="hidden" name="poin[]" value="'.$nilpoin.'"><input type="hidden" id="flag_calc_'.$iparameter_id.'" value="" class="required_par"/>';

						$o.='</table></td><td align="center">'.$btnHitung.' ';
						$o.='</td>';
						$o.='<td align="center"><input type="hidden" id="nilai_karyawan_'.$iparameter_id.'" name="nilai_karyawan['.$iparameter_id.']" value="'.$npoint.'" class="tabs2 required_par" />'.$npoint.' | '.$npointsepatas.$parpar.$hashas.$poipoi.'</td>';
						$o.='<td align="center">'.$vpoinsepakat.'</td>';
						$b=$bobot*100;
						$o.='<td align="center">'.$b.'%</td>';
						$o.='<td align="center"><p id="hasil_calc_'.$iparameter_id.'"><input type="hidden" id="score_input'.$iparameter_id.'" name="score_input['.$iparameter_id.']" class="tabs2" value="'.$dnil['poin_sepakat'].'" /></p>'.$vnilai.$peka.'</td>';
						$o.='</tr>';
					}
				}else{
					// tidak auto 
					if($querypd->num_rows()>0) {
						$rows_ = $querypd->result_array();
						$btnHitung = '<div><span></span><br/><p style="display:none;">Loading...</p></div>';
						$curr_score = '';
						
						// sudah disubmit
						if($iSubmit > 0) {
							$sql = 'select * from pk.pk_nilai a where a.lDeleted=0 and a.iparameter_id="'.$iparameter_id.'" and a.idmaster_id="'.$idmaster_id.'"';
							$query = $this->db->query($sql);
							if($query->num_rows()>0) {
								$row = $query->row_array();
								$btnHitung = '<div><span>';
								$btnHitung.= $row['hasil_calc'];
							//	$btnHitung.='<input id="parameter_'.$iparameter_id.'" class="parameters tabs2" type="hidden" name="iparameter_id[]" value="'.$row['iparameter_id'].'">';
							//	$btnHitung.='<input id="hasil_'.$iparameter_id.'" class="hasils tabs2" type="hidden" name="hasil_calc[]" value="'.$row['hasil_calc'].'">';
							//	$btnHitung.='<input id="poin_'.$iparameter_id.'" class="poins tabs2" type="hidden" name="poin[]" value="'.$row['poin'].'">';
								
								if($iSubmit < 2){
									$btnHitung.= '</span><br/><p style="display:none;">Loading...</p></div>';
								}else{
									if($iatasan==1) {
										$btnHitung.= '';
									}else{
										if($is_confirm==1){
											$btnHitung.= '<br>Final Score';	
										}	
									}
								}
								
								if($iatasan==1) {
									$curr_score = number_format($row['poin_sepakat'],0);
								}else{
									$curr_score = number_format($row['poin'],0);
								}
							}
						}

						
						$o.='<tr bgcolor="#FFFFFF"><td></td><td style="margin:0;padding:0"><table width="100%" height="100%" cellspacing="0" cellpadding="2">';
						
						foreach($rows_ as $key_ =>$row_) {
							$deskripsi = $row_['deskripsi'];
							$poin = number_format($row_['poin'],0);
							$mcalc = $row_['iCondition'];
							$bgcolor = ($key_%2)?'#EFEFEF':'';
							
							//$highlight = ($curr_score==$poin)?'color:#FFF;background:blue;':'';
							$highlight = '';

							$ceked= ($poin==$curr_score)?'checked':'' ;
							
							$o.='<tr bgcolor="'.$bgcolor.'" style="'.$highlight.'"><td width="80%">'.$deskripsi.'</td><td align="right" class="lbl_'.$poin.'">'.$poin.' 
								<input type="radio" class="required_par"  id="mpoin_'.$iparameter_id.'" '.$ceked.' name="poin_'.$iparameter_id.'[]" value="'.$poin.'" onclick="calculate_all_rincian_hitung($(this),\''.$vFunction.'\',\''.$iparameter_id.'\',\''.$poin.'\',\''.$mcalc.'\');">

								</td>
							</tr>';
						}

						$sqlnil = "select * from pk.pk_nilai a where a.idmaster_id='".$idmaster_id."' and a.iparameter_id='".$iparameter_id."'";
						$dnil = $this->db->query($sqlnil)->row_array();
						
						$npoint= number_format($dnil['poin'],0);
						$npointsepatas= $dnil['poin_sepakat_atasan'];
						$poinatasan='';
						$sa='111';
						if($iatasan==1) {
							
							$nilpoin=$dnil['poin_sepakat_atasan'];
							$nilhsl= $dnil['hasil_calc_ats'];
							if($npointsepatas!=0){$sa=$npointsepatas;
								$npointsepakat = $npointsepatas;
							}else{
								$npointsepakat=number_format($npoint,2);
							}
							$poinatasan=number_format($dnil['poin_sepakat'],0);
							$vpoinsepakat = number_format($npointsepakat,0);
							$vnilai = number_format(($vpoinsepakat*$bobot),2);
						}else{
							$nilpoin=$dnil['poin'];
							$nilhsl= $dnil['hasil_calc'];
							$npointsepakat = number_format($npoint,2);
							$vpoinsepakat = number_format($npointsepakat,2);
							$vnilai = number_format(($vpoinsepakat*$bobot),2);	
						}

						$peka='<input id="pk_'.$iparameter_id.'" class="pkas tabs2 required_par" type="hidden" name="pk[]" value="'.$row['ipk_nilai'].'">';
						$peka.='<input id="nilai_'.$iparameter_id.'" class="pkas tabs2 required_par" type="hidden" name="nilai[]" value="'.$vnilai.'">';
						$parpar='<input id="parameter_'.$iparameter_id.'" class="parameters tabs2 required_par" type="hidden" name="iparameter_id[]" value="'.$iparameter_id.'">';
						$hashas='<input id="hasil_'.$iparameter_id.'" class="hasils tabs2 required_par" type="hidden" name="hasil_calc[]" value="'.$nilhsl.'">';
						$poipoi='<input id="poin_'.$iparameter_id.'" class="poins tabs2 required_par" type="hidden" name="poin[]" value="'.$nilpoin.'"><input type="hidden" id="flag_calc_'.$iparameter_id.'" value="" class="required_par"/>';

						$o.='</table></td><td align="center">'.$btnHitung.' ';
						$o.='</td>';
						$o.='<td align="center"><input type="hidden" id="point_karyawan_'.$iparameter_id.'" value="'.number_format($npoint,0).'" /><input id="scoreats_'.$iparameter_id.'" class="tabs2 required_par" name="scoreats['.$iparameter_id.']" value="'.$row['poin_sepakat'].'" type="hidden" />'.$peka.$parpar.$hashas.$poipoi.'<p id="point_n_'.$iparameter_id.'">'.number_format($npoint,0).' | '.$poinatasan.'</p></td>';
						if($iatasan==1) {
							$o.='<td align="center"><input type="text" name="vpoinsepakat['.$iparameter_id.']" id="vpoinsepakat_'.$iparameter_id.'" class="tabs2 required_par" value='.$sa.' /></td>';
							$o.='<script>';
							$o.='$("#vpoinsepakat_'.$iparameter_id.'").change(function(){
								var ats = Number($("#scoreats_'.$iparameter_id.'").val());
								var kar = Number($("#point_karyawan_'.$iparameter_id.'").val());
								var ini = Number($(this).val());
								if(ats==0){
									_custom_alert("Nilai Terlebih dahulu!","Error!","info");
									$(this).val(kar);
									return false;
								}
								if(kar>ats){
									if(ini>kar){
										_custom_alert("Nilai Sepakat Tidak Boleh Lebih / Kurang dari interval ("+ats+"-"+kar+")!","Error!","info");
										$(this).val(kar);
										return false;
									}else if(ini<ats){
										_custom_alert("Nilai Sepakat Tidak Boleh Lebih / Kurang dari interval ("+ats+"-"+kar+")!","Error!","info");
										$(this).val(kar);
										return false;
									}
								}
								if(ats>kar){
									if(ini>ats){
										_custom_alert("Nilai Sepakat Tidak Boleh Lebih / Kurang dari interval ("+kar+"-"+ats+")!","Error!","info");
										$(this).val(kar);
										return false;
									}else if(ini<kar){
										_custom_alert("Nilai Sepakat Tidak Boleh Lebih / Kurang dari interval ("+kar+"-"+ats+")!","Error!","info");
										$(this).val(kar);
										return false;
									}
								}

								if(kar==ats){
									_custom_alert("Nilai tidak bisa di rubah!","Error!","info");
									$(this).val(kar);
									return false;
								}
								var bobot= Number('.$bobot.');
								var n = Number(bobot * ini);
								$("#lbl_nilai_per_'.$iparameter_id.'").text(n);

							});';
							$o.='</script>';
						}else{
							$o.='<td align="center">'.number_format($vpoinsepakat,0).'</td>';
						}
						$b=$bobot*100;
						$o.='<td align="center"><input type="hidden" class="required_par" id="bobot_ats_'.$iparameter_id.'" value="'.$bobot.'" />'.$b.'%</td>';
						$o.='<td align="center"><p id="lbl_nilai_per_'.$iparameter_id.'">'.$vnilai.$peka.'</p></td>';
						$o.='</tr>';
					}

				}
				

			$nomor++;	
			}
			$o.= '</table></div>';
			
			$o.= '<script type="text/javascript">';
			$o.= 'function calculate_all_rincian_hitung(o, vFunction,iparameter_id,mPoin,mCalc) {
					var url = "'.base_url().'processor/pk/pk_ts?action=calculate_all_rincian_hitung";
					var date1 = $("#pk_ts_tgl1").val();
					var date2 = $("#pk_ts_tgl2").val();
					var periode = $("#pk_ts_tgl_penilaian").val();
					var itim_id = $("#itim").val();
					var nippemohon = $("#nippemohon").val();
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
					
					o.closest("tr").find("tr").css({"background":"transparent","color":"#000"});
					
					$.ajax({
						url: url,
						data: { vFunction:vFunction, date1:date1, date2:date2, periode:periode , mPoin:mPoin, mCalc:mCalc , itim_id:itim_id, nippemohon:nippemohon},
						type: "post",
						dataType: "json",
						success: function(data) {
							o.show();
							loading.hide();
							
							if(!data.error) {
								
								var fldParameter = 	$(\'<input>\').attr({
													    type: \'hidden\',
													    id: \'parameter_\'+iparameter_id,
													    class: \'parameters tabs2 required_par\',
													    name: \'iparameter_id[]\',
													    value: iparameter_id
													});

								var fldHasil = 	$(\'<input>\').attr({
													    type: \'hidden\',
													    id: \'hasil_\'+iparameter_id,
													    class: \'hasils tabs2 required_par\',
													    name: \'hasil_calc[]\',
													    value: data.hasil
													});
								var fldScore = 	$(\'<input>\').attr({
													    type: \'hidden\',
													    id: \'poin_\'+iparameter_id,
													    class: \'poins tabs2 required_par\',
													    name: \'poin[]\',
													    value: data.score
													});
								var scoreats = \'scoreats[\'+iparameter_id+\']\';
								var fldscoreats = 	$(\'<input>\').attr({
													    type: \'hidden\',
													    id: \'scoreats_\'+iparameter_id,
													    class: \'tabs2 required_par\',
													    name: scoreats,
													    value: data.score
													});
								
								$("#req_tab2_"+iparameter_id).val(data.score);
								$("#hasil_"+iparameter_id).val(data.hasil);
								$("#nilai_hasil_c_"+iparameter_id).text(data.hasil);
								$("#poin_"+iparameter_id).val(data.score);
								$("#flag_calc_"+iparameter_id).val(1);
								if (data.is_auto == 1) {
									var z = o.closest("tr").find(".lbl_"+data.score);
									z.parent().css({"background":"blue","color":"#fff"});
								//	o.parent().find("span").text( data.hasil );
								//	o.parent().find("span").append( fldParameter ).append( fldHasil ).append(fldScore);	
								}else{

									curnew.find("span").text( data.hasil );
									var kar=Number($("#point_karyawan_"+iparameter_id).val());
									var hsl=data.score;
									var sep=(Number(kar)+Number(hsl))/2;';
									if($iatasan==1){
										$o.='$("p#point_n_"+iparameter_id).text(kar+" | "+hsl);
											var bobot= Number($("#bobot_ats_"+iparameter_id).val());
											var n = Number(bobot * sep);
											$("p#lbl_nilai_per_"+iparameter_id).text(n);';
									}else{
										$o.='$("p#point_n_"+iparameter_id).text(hsl+" | ");
											var bobot= Number($("#bobot_ats_"+iparameter_id).val());
											var n = Number(bobot * hsl);
											$("p#lbl_nilai_per_"+iparameter_id).text(n);';
									}

								$o.='$("p#point_n_"+iparameter_id).append(fldscoreats);
									$("input#scoreats_"+iparameter_id).val(hsl);	
									$("input#vpoinsepakat_"+iparameter_id).val(sep);	
								//	curnew.find("span").append( fldParameter ).append( fldHasil ).append(fldScore);	
								}
								
							} else {
								
								alert( data.message );
							}
							
						}
					});
				  }';
			$o.= '</script>';

			$o.= '<script type="text/javascript">';
			$o.= 'function calculate_all_rincian_hitung_ats(o, vFunction,iparameter_id,mPoin,mCalc) {
					var url = "'.base_url().'processor/pk/pk_ts?action=calculate_all_rincian_hitung";
					var date1 = $("#pk_ts_tgl1").val();
					var date2 = $("#pk_ts_tgl2").val();
					var periode = $("#pk_ts_tgl_penilaian").val();
					var itim_id = $("#itim").val();
					var nippemohon = $("#nippemohon").val();

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
					
					o.closest("tr").find("tr").css({"background":"transparent","color":"#000"});
					
					$.ajax({
						url: url,
						data: { vFunction:vFunction, date1:date1, date2:date2, periode:periode , mPoin:mPoin, mCalc:mCalc , itim_id:itim_id, nippemohon:nippemohon},
						type: "post",
						dataType: "json",
						success: function(data) {
							o.show();
							loading.hide();
							
							if(!data.error) {
								
								var fldParameter = 	$(\'<input>\').attr({
													    type: \'hidden\',
													    id: \'parameter_\'+iparameter_id,
													    class: \'parameters tabs2 required_par\',
													    name: \'iparameter_id[]\',
													    value: iparameter_id
													});

								var fldHasil = 	$(\'<input>\').attr({
													    type: \'hidden\',
													    id: \'hasil_\'+iparameter_id,
													    class: \'hasils tabs2 required_par\',
													    name: \'hasil_calc[]\',
													    value: data.hasil
													});
								var fldScore = 	$(\'<input>\').attr({
													    type: \'hidden\',
													    id: \'poin_\'+iparameter_id,
													    class: \'poins tabs2 required_par\',
													    name: \'poin[]\',
													    value: data.score
													});

								var scoreats = \'scoreats[\'+iparameter_id+\']\';
								var fldscoreats = 	$(\'<input>\').attr({
													    type: \'hidden\',
													    id: \'scoreats_\'+iparameter_id,
													    class: \'tabs2 required_par\',
													    name: scoreats,
													    value: data.score
													});

								var sasa = "<input type=\'hidden\' name=\'score_input["+iparameter_id+"]\' class=\'tabs2 required_par\' value=\'"+data.score+"\' />";
								$("#req_tab2_"+iparameter_id).val(data.score);
								$("#hasil_"+iparameter_id).val(data.hasil);
								$("#poin_"+iparameter_id).val(data.score);
								$("#nilai_hasil_c_"+iparameter_id).text(data.hasil);
								$("p#hasil_calc_"+iparameter_id).text("");
								$("p#hasil_calc_"+iparameter_id).append(sasa);
								$("#flag_calc_"+iparameter_id).val(1);
								if (data.is_auto == 1) {
									var z = o.closest("tr").find(".lbl_"+data.score);
									z.parent().css({"background":"blue","color":"#fff"});
									//o.parent().find("span").text( data.hasil ).css("color","green");
								//	o.parent().find("span").append( fldParameter ).append( fldHasil ).append(fldScore);	
								}else{

									curnew.find("span").text( data.hasil );
									var kar=Number($("#point_karyawan_"+iparameter_id).val());
									var hsl=data.score;
									var sep=(Number(kar)+Number(hsl))/2;';
									if($iatasan==1){
										$o.='$("p#point_n_"+iparameter_id).text(kar+" | "+hsl);
											var bobot= Number($("#bobot_ats_"+iparameter_id).val());
											var n = Number(bobot * sep);
											$("p#lbl_nilai_per_"+iparameter_id).text(n);';
									}else{
										$o.='$("p#point_n_"+iparameter_id).text(hsl+" | ");
											var bobot= Number($("#bobot_ats_"+iparameter_id).val());
											var n = Number(bobot * hsl);
											$("p#lbl_nilai_per_"+iparameter_id).text(n);';
									}

								$o.='$("p#point_n_"+iparameter_id).append(fldscoreats);
									$("input#scoreats_"+iparameter_id).val(hsl);	
									$("input#vpoinsepakat_"+iparameter_id).val(sep);	

									//curnew.find("span").text( data.hasil ).css("color","green");
								//	curnew.find("span").append( fldParameter ).append( fldHasil ).append(fldScore);	
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
 <div>
 <?php if ($iSubmit < 2){  ?>
	<!--<button type="button" id="submit_draft_tab2" class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary">Save as Draft</button>-->
	<br><button type="button" id="submit_tab2" class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary">Save</button>
<?php  }?>


<?php if($iatasan==1 and $iSubmit >= 2 and $iSubmit < 5) { ?>
	<!--<button type="button" id="submit_ats_tab2" class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary">Save as Draft</button>-->
	<br><button type="button" id="submit_ats_tab2" class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary">Save</button>
<?php  }?>
</div>



<script type="text/javascript">
	$( "tr.trdetil:not(:first)" ).find('th.thdetil').text("");

	$('#submit_draft_tab2').die();
	$('#submit_draft_tab2').live('click', function(){
		var iparameter_id = $('input.parameters').serialize();
		var hasil_calc = $('input.hasils').serialize();
		var poin = $('input.poins').serialize();
		var BASE_URL = "<?php echo base_url();?>";
		var idmaster_id = $('#idmaster_id').val();
		var modul_id = $('#idmaster_id').val();
		var company_id  = $('#idmaster_id').val();
		var group_id= $('#idmaster_id').val();
		var itim_id = $("#itim").val();
		return $.ajax({
			url: BASE_URL+'processor/pk/pk_ts?action=pos_calc',
			type: 'post',
			data: $('input.tabs2').serialize()+'&idmaster_id='+idmaster_id+'&iSubmit=1'+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id+'&itim='+itim_id,
			beforeSend: function(xhr, opts) {
					var req = $(".required_par");
					var conf=0;
					$.each(req, function(i,v){
						if($(this).val() == "") {
							var id = $(this).attr("id");
							conf++;
						}		
					});
						
				//	if(conf > 0) {
				//		alert("Semua Parameter Harus Diisi");
				//		xhr.abort();
				//	}

			},
			success: function(data) {
				var o = $.parseJSON(data);												
				var info = 'Info';
				var header = 'Info';
				var last_id =idmaster_id;
					if(o.status == true) {
						_custom_alert("Data Tersimpan","Info","Info","", 1, 20000);
						$('#grid_pk_ts').trigger('reloadGrid');
						$.get(base_url+'processor/pk/pk/ts?action=update&foreign_key=0&company_id='+company_id+'&idnya='+last_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
		                    $('div#form_pk_ts').html(data);
		                    $('html, body').animate({scrollTop:$('#grid_pk_ts').offset().top - 20}, 'slow');
		            	});
		            }
			}
		});
		
	});

	$('#submit_tab2').die();
	$('#submit_tab2').live('click', function(){
		var iparameter_id = $('input.parameters').serialize();
		var hasil_calc = $('input.hasils').serialize();
		var poin = $('input.poins').serialize();
		var BASE_URL = "<?php echo base_url();?>";
		var idmaster_id = $('#idmaster_id').val();
		var modul_id = $('#idmaster_id').val();
		var company_id  = $('#idmaster_id').val();
		var group_id= $('#idmaster_id').val();
		var itim_id = $("#itim").val();
		return $.ajax({
			url: BASE_URL+'processor/pk/pk_ts?action=pos_calc',
			type: 'post',
			//data: 'parameter='+iparameter_id+'&hasil_calc='+hasil_calc+'&poin='+poin,
			data: $('input.tabs2').serialize()+'&idmaster_id='+idmaster_id+'&iSubmit=2'+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id+'&itim='+itim_id,
			beforeSend: function(xhr, opts) {
					var req = $(".required_par");
					var conf=0;
					message="";
					$.each(req, function(i,v){
						if($(this).val() == "") {
							var id = $(this).attr("id");
							message +=id+"<br>";
							conf++;
						}		
					});
						
					if(conf > 0) {
						_custom_alert(message,"Info","Info","",1,20000);
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
						$('#grid_pk_ts').trigger('reloadGrid');
						$.get(base_url+'processor/pk/pk/ts?action=update&foreign_key=0&company_id='+company_id+'&idnya='+last_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
		                    $('div#form_pk_ts').html(data);
		                    $('html, body').animate({scrollTop:$('#grid_pk_ts').offset().top - 20}, 'slow');
		            	});
		            }
			}
		});
		
	});

	$('#submit_draft_ats_tab2').die();
	$('#submit_draft_ats_tab2').live('click', function(){
		var iparameter_id = $('input.parameters').serialize();
		var hasil_calc = $('input.hasils').serialize();
		var poin = $('input.poins').serialize();
		var BASE_URL = "<?php echo base_url();?>";
		var idmaster_id = $('#idmaster_id').val();
		var modul_id = $('#idmaster_id').val();
		var company_id  = $('#idmaster_id').val();
		var group_id= $('#idmaster_id').val();
		var itim_id = $("#itim").val();
		return $.ajax({
			url: BASE_URL+'processor/pk/pk_ts?action=pos_calc_ats',
			type: 'post',
			data: $('input.tabs2').serialize()+'&idmaster_id='+idmaster_id+'&iSubmit=3'+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id+'&itim='+itim_id,
			beforeSend: function(xhr, opts) {
					var req = $(".required_par");
					var conf=0;
					$.each(req, function(i,v){
						if($(this).val() == "") {
							var id = $(this).attr("id");
							conf++;
						}		
					});
						

			},
			success: function(data) {
				var o = $.parseJSON(data);												
				var info = 'Info';
				var header = 'Info';
				var last_id =idmaster_id;
					if(o.status == true) {
						_custom_alert("Data Tersimpan","Info","Info","", 1, 20000);
						$('#grid_pk_ts').trigger('reloadGrid');
						$.get(base_url+'processor/pk/pk/ts?action=update&foreign_key=0&company_id='+company_id+'&idnya='+last_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
		                    $('div#form_pk_ts').html(data);
		                    $('html, body').animate({scrollTop:$('#grid_pk_ts').offset().top - 20}, 'slow');
		            	});
		            }
			}
		});
		
	});

	$('#submit_ats_tab2').die();
	$('#submit_ats_tab2').live('click', function(){
		var iparameter_id = $('input.parameters').serialize();
		var hasil_calc = $('input.hasils').serialize();
		var pk = $('input.pkas').serialize();
		var poin = $('input.poins').serialize();
		var BASE_URL = "<?php echo base_url();?>";
		var idmaster_id = $('#idmaster_id').val();
		var modul_id = $('#idmaster_id').val();
		var company_id  = $('#idmaster_id').val();
		var group_id= $('#idmaster_id').val();
		var itim_id = $("#itim").val();
		return $.ajax({
			url: BASE_URL+'processor/pk/pk_ts?action=pos_calc_ats',
			type: 'post',
			//data: 'parameter='+iparameter_id+'&hasil_calc='+hasil_calc+'&poin='+poin,
			data: $('input.tabs2').serialize()+'&idmaster_id='+idmaster_id+'&iSubmit=4'+'&company_id='+company_id+'&group_id='+group_id+'&modul_id='+modul_id+'&itim='+itim_id,
			beforeSend: function(xhr, opts) {
					var req = $(".required_par");
					var conf=0;
					var m="";
					$.each(req, function(i,v){
						if($(this).val() == "") {
							var id = $(this).attr("id");
							m +=id;
							conf++;
						}		
					});
						
					if(conf > 0) {
						_custom_alert('Semua Parameter Harus Diisi',"info","info","",1,20000);
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
						$('#grid_pk_ts').trigger('reloadGrid');
						$.get(base_url+'processor/pk/pk/ts?action=update&foreign_key=0&company_id='+company_id+'&idnya='+last_id+'&id='+last_id+'&group_id='+group_id+'&modul_id='+modul_id, function(data) {
		                    $('div#form_pk_ts').html(data);
		                    $('html, body').animate({scrollTop:$('#grid_pk_ts').offset().top - 20}, 'slow');
		            	});
		            }
			}
		});
		
	});


</script>