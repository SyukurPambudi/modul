<?php 
//print_r($team_id);
//echo $mydept.'ini teamnya';
		$o='';
			
			// Get Team 
		
			/*$sql_tim ='select a.vteam,iteam_id from plc2.plc2_upb_team a where a.ldeleted=0 and a.iteam_id in ("'.$team_id.'")';
			$qteam = $this->db->query($sql_tim)->row_array();
			$itim= $qteam['iteam_id'];*/
			// get parameter PK TS
			$sql_j="select * from pk.pk_master ma where ma.idmaster_id=".$this->input->get('id')." and ma.ldeleted=0";
			$qt=$this->db->query($sql_j)->row_array();
			$it='';
			$is_confirm=$qt['is_confirm'];
			$is_confirm_karyawan=$qt['is_confirm_karyawan'];
			$teamid = $qt['iteam_id'];

			$sqlp ='select * from pk.pk_parameter a 
				inner join pk.pk_kategori b on a.ikategori_id=b.ikategori_id
				where a.ldeleted=0 and a.ikategori_id=2 and b.iPostId="'.$datemployee['iPostID'].'" and a.iteam_id='.$teamid;
			$queryp = $this->db->query($sqlp);

		if($queryp->num_rows()>0) {
			$rows = $queryp->result_array();
			
			$o = '<div id="target_'.$id.'"><table cellspacing="0" cellpadding="2" class="table_pk">';
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
				$o .='<input type="hidden" value="" id="req_tab2_'.$iparameter_id.'" class="required_par">';
				$o .='</tr>';

				
				$sqlpd = "select * from pk.pk_parameter_detail a where a.ldeleted=0 and a.iparameter_id='".$iparameter_id."' order by a.iUrut";
				$querypd = $this->db->query($sqlpd);

				if ($is_auto == 1) {
					if($querypd->num_rows()>0) {
						$rows_ = $querypd->result_array();
						$btnHitung = '<div><span></span><br/><a href="javascript:void(0);" onclick="calculate_all_rincian_hitung($(this),\''.$vFunction.'\',\''.$iparameter_id.'\',0,0);">Hitung</a><p style="display:none;">Loading...</p></div>';
						$curr_score = '';
						
						
						$o.='<tr bgcolor="#FFFFFF"><td></td><td style="margin:0;padding:0"><table width="100%" height="100%" cellspacing="0" cellpadding="2">';
						
						foreach($rows_ as $key_ =>$row_) {
							$deskripsi = $row_['deskripsi'];
							$poin = $row_['poin'];
							$bgcolor = ($key_%2)?'#EFEFEF':'';
							
							$highlight = ($curr_score==$poin)?'color:#FFF;background:blue;':'';
							
							$o.='<tr bgcolor="'.$bgcolor.'" style="'.$highlight.'"><td width="80%">'.$deskripsi.'</td><td align="right" class="lbl_'.$poin.'">'.$poin.'</td></tr>';
						}
						
						
						$npoint= '';
						$npointsepatas= '';
						$npointsepakat = '';
						$vpoinsepakat = '';
						$vnilai = '';

						$parpar='<input id="parameter_'.$iparameter_id.'" class="parameters tabs2" type="hidden" name="iparameter_id[]" value="'.$iparameter_id.'">';
						$hashas='<input id="hasil_'.$iparameter_id.'" class="hasils tabs2" type="hidden" name="hasil_calc[]" value="">';
						$poipoi='<input id="poin_'.$iparameter_id.'" class="poins tabs2" type="hidden" name="poin[]" value="">';
					

						$o.='</table></td><td>'.$btnHitung.' ';
						$o.='</td>';
						$o.='<td align="center">'.$npoint.' | '.$npointsepatas.$parpar.$hashas.$poipoi.'</td>';
						$o.='<td align="center">'.$vpoinsepakat.'</td>';
						$b=$bobot*100;
						$o.='<td align="center">'.$b.'%</td>';
						$o.='<td align="center">'.$vnilai.'</td>';
						$o.='</tr>';
					}
				}else{
					// tidak auto 
					if($querypd->num_rows()>0) {
						$rows_ = $querypd->result_array();
						$btnHitung = '<div><span></span><br/><p style="display:none;">Loading...</p></div>';
						$curr_score = '';
						
						$o.='<tr bgcolor="#FFFFFF"><td></td><td style="margin:0;padding:0"><table width="100%" height="100%" cellspacing="0" cellpadding="2">';
						
						foreach($rows_ as $key_ =>$row_) {
							$deskripsi = $row_['deskripsi'];
							$poin = $row_['poin'];
							$mcalc = $row_['iCondition'];
							$bgcolor = ($key_%2)?'#EFEFEF':'';
							
							$highlight = ($curr_score==$poin)?'color:#FFF;background:blue;':'';
							
							$o.='<tr bgcolor="'.$bgcolor.'" style="'.$highlight.'">

								<td width="80%">'.$deskripsi.'</td><td align="right" class="lbl_'.$poin.'">'.$poin.' 
								<input type="radio" id="mpoin_'.$iparameter_id.'"  name="poin[]_'.$iparameter_id.'" value="'.$poin.'" onclick="calculate_all_rincian_hitung($(this),\''.$vFunction.'\',\''.$iparameter_id.'\',\''.$poin.'\',\''.$mcalc.'\');">

								</td>
							</tr>';
						}
						
						$npoint= '';
						$npointsepatas= '';
						$npointsepakat = '';
						$vpoinsepakat = '';
						$vnilai = '';

						$parpar='<input id="parameter_'.$iparameter_id.'" class="parameters tabs2" type="hidden"  name="iparameter_id[]" value="'.$iparameter_id.'">';
						$hashas='<input id="hasil_'.$iparameter_id.'" class="hasils tabs2" type="hidden" name="hasil_calc[]" value="">';
						$poipoi='<input id="poin_'.$iparameter_id.'" class="poins tabs2" type="hidden" name="poin[]" value="">';

						$o.='</table></td><td>'.$btnHitung.' ';
						$o.='</td>';
						$o.='<td align="center">'.$npoint.' | '.$npointsepatas.$parpar.$hashas.$poipoi.'</td>';
						$o.='<td align="center">'.$vpoinsepakat.'</td>';
						$b=$bobot*100;
						$o.='<td align="center">'.$b.'%</td>';
						$o.='<td align="center">'.$vnilai.'</td>';
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
					var periode = $("#calculate_all_cPeriode").val();
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
						data: { vFunction:vFunction, date1:date1, date2:date2, periode:periode , mPoin:mPoin, mCalc:mCalc, itim_id:itim_id, nippemohon:nippemohon},
						type: "post",
						dataType: "json",
						success: function(data) {
							o.show();
							loading.hide();
							
							if(!data.error) {
								
								

								var fldHasil = 	$(\'<input>\').attr({
													    type: \'hidden\',
													    id: \'hasil_\'+iparameter_id,
													    class: \'hasils tabs2\',
													    name: \'hasil_calc[]\',
													    value: data.hasil
													});
								var fldScore = 	$(\'<input>\').attr({
													    type: \'hidden\',
													    id: \'poin_\'+iparameter_id,
													    class: \'poins tabs2\',
													    name: \'poin[]\',
													    value: data.score
													});
								


								$("#req_tab2_"+iparameter_id).val(data.score);
								
								$("#hasil_"+iparameter_id).val(data.hasil);
								$("#poin_"+iparameter_id).val(data.score);

								if (data.is_auto == 1) {
									var z = o.closest("tr").find(".lbl_"+data.score);
									z.parent().css({"background":"blue","color":"#fff"});
									o.parent().find("span").text( data.hasil );
									//o.parent().find("span").append( fldHasil ).append(fldScore);	
								}else{

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
if ($this->input->get('action') == 'view') {
 	}else{		
 ?>		
 <div>

	<!--<button type="button" id="submit_draft_tab2" class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary">Save as Draft</button>-->
	<?php 
	$sql_j="select * from pk.pk_master ma where ma.idmaster_id=".$this->input->get('id')." and ma.ldeleted=0";
	$qt=$this->db->query($sql_j)->row_array();
	$it='';
	$iSubmit=$qt['is_confirm_karyawan'];
	if($qt['vnip']==$vnip){
		$type=0;
	}else{
		$type=1;
	}
	$ca= '<br><button type="button" id="submit_tab2" class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary">Save</button>';
	 if($type==0){
 	 	if($iSubmit==0){
 	 		echo $ca;
 	 	}
 	 }else{
 	 	if($iSubmit<=3){
 	 		echo $ca;
 	 	}
 	 }?>
</div>
<?php } ?>


<script type="text/javascript">
	//$( "tr.trdetil:not(:first)" ).find('th.thdetil').text("");

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
			//data: 'parameter='+iparameter_id+'&hasil_calc='+hasil_calc+'&poin='+poin,
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