<?php
/* $this->load->view('js/select2_js');
$this->load->view('js/select2_css'); */
	 
/*echo $dataHead[$main_table_pk];
echo "<br>";
echo $main_table_pk;
echo "<br>";
print_r($dataHead);*/
	/* 
		Jenis Filed tersedia

		1. Input Field
		2. Number
		3. Datepicker
		4. Textarea
		5. Dropdown Static
		6. Dropdown Dynamic
		7. File Upload

	*/
	
		$readonly=$form_field['iRead_only_form']==1?'readonly="readonly"':'';
		$field_required=$form_field['iRequired']==1?"required":"";
		$return="";
		$dataHead[$field]=isset($dataHead[$field])?$dataHead[$field]:"";
	switch ($iM_jenis_field) {
		case '1':
			$return = '<input type="text" value="'.$dataHead[$field].'" name="'.$field.'" id="'.$id.'" class="input_rows1 '.$field_required.'" '.$readonly.' size="35" >';
			break;
		
		case '2':
			$return = '<input type="text" value="'.$dataHead[$field].'" name="'.$field.'" id="'.$id.'" class="input_rows1 angka '.$field_required.'" '.$readonly.' size="10" >';
			break;

		case '3':
			$tanggal = ($form_field['iRead_only_form'] == 1) ? '' : 'tanggal';
			$return = '<input type="text" value="'.$dataHead[$field].'" name="'.$field.'" id="'.$id.'" class="input_rows1 '.$tanggal.' '.$field_required.'" readonly="readonly" size="10" >';
			break;

		case '4':
			$return = '<textarea  name="'.$field.'" class="input_rows1 '.$field_required.'" colspan="2" id="'.$id.'" >'.nl2br($dataHead[$field]).'</textarea>';
			break;
		case '5':

			$pilihan = $vSource_input;
			$exp1 = explode(',', $pilihan);
			$choice = array();
			foreach ($exp1 as $key => $value) {
				$exp2 = explode(':', $value);
				$choice[$exp2[0]] = $exp2[1];
			}
			
	        if ($act == 'view') { 
	        	$return = '<input type="hidden" value="'.$dataHead[$field].'" name="'.$field.'" id="'.$id.'" class="input_rows1  '.$field_required.'" size="10" >';
	            $return .= (array_key_exists($dataHead[$field], $choice))?$choice[$dataHead[$field]]:'Belum Dipilih';
	        } else {
	        	$readonlyvalue="";
		            $return = '<select class="input_rows1 choose '.$field_required.' " name="'.$field.'"  id="'.$id.'" >';   
		            $return .= '<option value="">-- Belum Dipilih --</option>';         
		            foreach($choice as $k=>$v) {
		                if ($k == $dataHead[$field]){ 
		                	$selected = ' selected';
		                	$readonlyvalue=$v;
		                }
		                else { $selected = ''; }
		                $return .= '<option '.$selected.' value="'.$k.'">'.$v.'</option>';
		            }            
		            $return .= '</select>';

		        if($form_field['iRead_only_form']==1){
					$return ='<input type="hidden"  name="'.$field.'" id="'.$id.'" class="input_rows1 '.$field_required.'" size="10" '.$field_required.' readonly="readonly" value="'.$dataHead[$field].'">';
					$return .= '<input type="text"  name="'.$field.'_dis" id="'.$id.'_details_formula" class="input_rows1 '.$field_required.'" size="45" '.$field_required.' readonly="readonly" value="'.$readonlyvalue.'">';
					//$return .= $readonlyvalue;
	            }
			}
			
			$return .= '
					<style>
						#'.$id.'{
							min-width: 150px;
						}
					</style>
					';



			break;
		case '55':

			$pilihan = $vSource_input;
			$exp1 = explode(',', $pilihan);
			$choice = array();

			foreach ($exp1 as $key => $value) {
				$exp2 = explode(':', $value);
				$choice[$exp2[0]] = $exp2[1];
			}
			
	        if ($act == 'view') {
	        	$return = '<input type="hidden" value="'.$dataHead[$field].'" name="'.$field.'" id="'.$id.'" class="input_rows1  '.$field_required.'" size="10" >';
	            $return .= $choice[$dataHead[$field]];
	        } else {
	            $return = '<select class="input_rows1  '.$field_required.' " name="'.$field.'"  id="'.$id.'" >';            
	            foreach($choice as $k=>$v) {
	                if ($k == $dataHead[$field]) $selected = ' selected';
	                else $selected = '';
	                $return .= '<option '.$selected.' value="'.$k.'">'.$v.'</option>';
	            }            
	            $return .= '</select>';
	        }


			break;
		case '6':

			if ($form_field['iValidation']==1) {
				$sql = $vSource_input.' ';	


				$sFieldValidation = 'select a.vSource_input_edit_validtation 
									from erp_privi.m_modul_fields_validation a 
									where a.lDeleted=0 
									and a.iValidation=1 
									and a.iM_modul_fields= "'.$form_field['iM_modul_fields'].'" ';
				$dFieldValidation = $this->db->query($sFieldValidation)->result_array();

				if(!empty($dFieldValidation)){
					foreach ($dFieldValidation as $dFieldValid) {
						$sql .=	 $dFieldValid['vSource_input_edit_validtation'].' ';					
					}
				}
			}else{
				$sql = $vSource_input;	
			}
			
			if($sql<>''){/*Get Order And Group By*/
				$sFieldValidation_after = 'select m_modul_fields_validation_after.vSource_input_validtation_after  
									from erp_privi.m_modul_fields_validation_after
									where m_modul_fields_validation_after.lDeleted=0 
									and m_modul_fields_validation_after.iM_modul_fields="'.$form_field['iM_modul_fields'].'" 
									order by m_modul_fields_validation_after.iSort DESC';
				$dFieldValidation_after = $this->db->query($sFieldValidation_after)->result_array();

				if(!empty($dFieldValidation_after)){
					foreach ($dFieldValidation_after as $dFieldValid_after) {
						$sql .=	' '.$dFieldValid_after['vSource_input_validtation_after'].' ';					
					}
				}
				$sql = str_replace('$nip$', $this->user->gNIP, $sql); 

				if ($form_field['iRead_team']==1) {
					$sql .=	 'and '.$form_field['vRead_team'].' in ('.$hasTeamID.') ';					
	
				}

				//echo '<pre>'.$sql.'=>'.$dataHead[$field];
				$pilihan =  $this->db->query($sql, array($dataHead[$field]))->result_array();
	            $readonlyvalue = '-';
				$return = '<select class="input_rows1 '.$field_required.' choose" name="'.$field.'"  id="'.$id.'" >';    
				$return .= '<option value="">---Pilih---</option>';				        
	            foreach($pilihan as $me) {
	            	$selected = '';
	                if ($me['valval'] == $dataHead[$field]){
	                	$readonlyvalue = $me['showshow'];
	                	$selected = ' selected';
	                }  
                    $return .= '<option '.$selected.' value='.$me['valval'].'>'.$me['showshow'].'</option>';
	            }            
	            $return .= '</select>';

	           	if($form_field['iRead_only_form']==1){
	            	$return ='<input type="hidden"  name="'.$field.'" id="'.$id.'" class="input_rows1 '.$field_required.'" size="10" '.$field_required.' readonly="readonly" value="'.$dataHead[$field].'"><input type="text"  name="'.$field.'_dis" id="'.$id.'_details_formula" class="input_rows1 '.$field_required.'" size="45" '.$field_required.' readonly="readonly" value="'.$readonlyvalue.'">';
	            }

			}else{
				$return .= '<span style="color:red;">SQL Belum disetting</span>';				
			}
			
			$return .= '
					<style>
						#'.$id.'{
							min-width: 150px;
						}
					</style>
					';
			if($form_field['iShow_SQL']==1){$return.="<br /<pre>".$sql.'</pre>';}
			break;

		case '7':
				$data['rowDataH']= $dataHead;
	           	$data['date'] = date('Y-m-d H:i:s');    
	           	$data['tabel_file'] = $tabel_file;
	           	$data['tabel_file_pk'] = $tabel_file_pk;
	           	$data['nmfield'] = $field;
	           	$data['tabel_file_pk_id'] = $tabel_file_pk_id;
	           	$data['field_required'] = $field_required;

	           	$data['path'] = $path;
	            $data['FOLDER_APP'] = $FOLDER_APP;
	            $data['createname_space'] = $createname_space;
	            $data['tempat'] = $tempat;
                $data['iModul_id'] = $iModul_id;
                $data['modul_id'] = $modul_id;

                if (!isset($qrFiles)){
	           		$qrFiles= 'select * from plc2.'.$tabel_file.' where lDeleted=0 and '.$tabel_file_pk.'= '.$dataHead[$tabel_file_pk].'   ';
                }
	           /*echo $qrFiles;
	           echo $field_required;
	           exit;*/
               $data['rows'] = $this->db->query($qrFiles)->result_array();
	            
	           $return = '<input type="hidden" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="30"  />';
	           $return .= $this->load->view('partial/v3_form_upload_file',$data,TRUE);

			break;

		case '8':
				$field_required=isset($field_required)?$field_required:"";
				$iModul_id=isset($iModul_id)?$iModul_id:0;
				$modul_id=isset($modul_id)?$modul_id:0;
				$hasTeam=isset($hasTeam)?$hasTeam:0;
				$hasTeamID=isset($hasTeamID)?$hasTeamID:0;
				$isAdmin=isset($isAdmin)?$isAdmin:FALSE;
				$data['act'] = $act;
				$data['row_value']= (isset($dataHead[$field])?$dataHead[$field]:0);
				$data['main_table_pk_value'] = $dataHead[$main_table_pk];
				
	           	$data['date'] = date('Y-m-d H:i:s');    
	           	$data['nmfield'] = $field;
				$data['rowDataH']= $dataHead;
	           	$data['field_required'] = $field_required;
               	$data['iModul_id'] = $iModul_id;
                $data['modul_id'] = $modul_id;
                $data['hasTeam']= $hasTeam ;
                $data['hasTeamID']= $hasTeamID;
                $data['isAdmin']= $isAdmin;
                $data['form_field'] = $form_field;
	           //$return = '<input type="hidden" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="30"  />';
	           $return = $this->load->view('partial/modul/'.$form_field['vFile_detail'],$data,TRUE);

			break;
			

		case '9':
			$return = $dataHead[$field];
			$return .= '<input type="hidden" readonly="readonly" value="'.$dataHead[$field].'" name="'.$field.'" id="'.$id.'" class="input_rows1 '.$field_required.'" size="10" >';

			if (isset($iM_modul_fields)){
				if($iM_modul_fields == 19){
					$type = 'BD';
					$usernip = $logged_nip;
					$return .='&nbsp;&nbsp;&nbsp; <span onclick="javascript:load_popup(\''.base_url().'processor/plc/v3/daftar/upb?action=copyUPB&upb_id='.$dataHead['iupb_id'].'&user='.$usernip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'&company_id='.$this->input->get('company_id').'\')" class="ui-button-text icon-save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" id="button_copyUPB">Copy UPB</span>';
				}
			}
			break;

		case '10':

			$return = '<input type="text"  name="'.$field.'" id="'.$id.'" class="input_rows1 '.$field_required.'" size="10" '.$field_required.' value="'.$dataHead[$field].'" readonly="readonly">';
			break;

		case '11':
			$return = '<input type="text"  name="'.$field.'" id="'.$id.'" class="input_rows1 canbackdate '.$field_required.'" size="10" '.$field_required.' readonly="readonly" value="'.$dataHead[$field].'">';

		case '12':
			$return = '<input type="text"  name="'.$field.'" id="'.$id.'" class="input_rows1 cannextdate '.$field_required.'" size="10" '.$field_required.' readonly="readonly" value="'.$dataHead[$field].'">';
			break;

		case '13':
			$value=$dataHead[$field];
			if ($form_field['iValidation']==1) {
				$sql = $vSource_input.' ';	

				$sFieldValidation = 'select a.vSource_input_edit_validtation 
									from erp_privi.m_modul_fields_validation a 
									where a.lDeleted=0 
									and a.iValidation=1 
									and a.iM_modul_fields= "'.$form_field['iM_modul_fields'].'" ';
				/*echo $sFieldValidation;
				exit;*/
				$dFieldValidation = $this->db->query($sFieldValidation)->result_array();

				if(!empty($dFieldValidation)){
					foreach ($dFieldValidation as $dFieldValid) {
						$sql .=	' '.$dFieldValid['vSource_input_edit_validtation'].' ';					
					}
				}


			}else{
				$sql = $vSource_input;
			}
			
			$sql = str_replace('?',$value, $sql); 
			if($form_field['iFilter_log']==1){
				$sql.=$this->lib_plc->getUpbLog($form_field['iM_modul']);
			}

			if($sql<>''){
				if(!isset($isAdmin)){
					$isAdmin=false;
				}
				if($isAdmin==false){
					if(!isset($hasTeamID)){
						$hasTeamID=0;
					}else{
						$hasTeamID=$hasTeamID!=""?$hasTeamID:"0";
					}
					if ($form_field['iRead_team']==1) {
						$sql .=	 ' and '.$form_field['vRead_team'].' in ('.$hasTeamID.') ';					

					}
				}
				
				/*Get Order And Group By*/
				$sFieldValidation_after = 'select m_modul_fields_validation_after.vSource_input_validtation_after  
									from erp_privi.m_modul_fields_validation_after
									where m_modul_fields_validation_after.lDeleted=0 and m_modul_fields_validation_after.iM_modul_fields="'.$form_field['iM_modul_fields'].'" 
									order by m_modul_fields_validation_after.iSort DESC';
				$dFieldValidation_after = $this->db->query($sFieldValidation_after)->result_array();

				if(!empty($dFieldValidation_after)){
					foreach ($dFieldValidation_after as $dFieldValid_after) {
						$sql .=	 ' '.$dFieldValid_after['vSource_input_validtation_after'].' ';					
					}
				}

				 //echo '<pre>'.$sql.'</pre>';

				$pilihan = $this->db->query($sql, array($value))->result_array();
				$readonlyvalue=0;
				$return="";
				if($form_field['iShow_SQL']==1){$return.="<br /<pre>".$sql.'</pre>';}
	            $return .= '<select class="input_rows1 '.$field_required.' choose" name="'.$field.'"  id="'.$id.'" '.$field_required.' '.$readonly.' >';   
	             $return .= '<option value="">-------Pilih-------</option>';     
	            foreach($pilihan as $me) {
	            	$select=$value==$me['valval']?'selected':'';
	            	if($value==$me['valval']){
	            		$readonlyvalue=$me['showshow'];
	            	}
	                $return .= '<option value='.$me['valval'].' '.$select.'>'.$me['showshow'].'</option>';
	            }            
	            $return .= '</select>';
	            /*$return .='<div name="'.$field.'"  id="'.$id.'" class="full_colums" style="background-color:white;max-width:99%;">dsadsadsa</div>'; */
	            if($form_field['iRead_only_form']==1){
	            	$return ='<input type="hidden"  name="'.$field.'" id="'.$id.'" class="input_rows1 '.$field_required.'" size="10" '.$field_required.' readonly="readonly" value="'.$dataHead[$field].'"><input type="text"  name="'.$field.'_details_formula" id="'.$id.'_details_formula" class="input_rows1 '.$field_required.'" size="45" '.$field_required.' readonly="readonly" value="'.$readonlyvalue.'">';
	            }
	            $return .='<div id="'.$id.'_details_upb" class="rows_input" style="max-width:98%;padding-top:3px;margin-left:0px;"></div>'; 
	            $return .='<script>
					    $.ajax({
								url: base_url+"processor/'.$folderpath.'v3/partial/controllers/'.$folderpath.'?action=getDetails",
								type: "post",
								data : {id:"'.$value.'",jenis:"'.$field.'",},
								success: function(data) {
									$("div#'.$id.'_details_upb").html(data);
								}
							});
						$("#'.$id.'").on("change", function(evt, params) {
							attrjenis=$("#'.$id.'").attr("name");
							if ($(this).val() != ""){
							    $.ajax({
										url: base_url+"processor/'.$folderpath.'v3/partial/controllers/'.$folderpath.'?action=getDetails",
										type: "post",
										data : {id:$(this).val(),jenis:attrjenis,},
										success: function(data) {
											$("div#'.$id.'_details_upb").html(data);
										}
									});
							}else{
								$("div#'.$id.'_details_upb").html("");
							}
						 });
	            		</script>'; 

			}else{
				$return = '<span style="color:red;">SQL Belum disetting</span>';				
			}
			break;

		case '14':
			$return = '<input hidden="text"  name="'.$field.'" id="'.$id.'" class="input_rows1 '.$field_required.'" size="10" '.$field_required.' readonly="readonly" value="'.$dataHead[$field].'">';

			$sql1 = 'select b.vDescription as vdepartemen,a.*,b.*,c.iLvlemp 
                        from hrd.employee a 
                        join hrd.msdepartement b on b.iDeptID=a.iDepartementID
                        join hrd.position c on c.iPostId=a.iPostID
                        where a.cNip ="'.$dataHead[$field].'"
                        ';
        
        	$datax = $this->db->query($sql1)->row_array();

			$return .= $dataHead[$field].' - '.ucwords($datax['vName']).' - '.$datax['vdepartemen'];
			break;

		case '15':
			$return = '<input type="text" value="'.$dataHead[$field].'"  name="'.$field.'" id="'.$id.'" class="input_rows1 required" readonly="readonly" size="35" '.$field_required.'>';
			break;

		case '16': 
			// $pathFile = $form_field['vPath_upload'];
			//print_r($form_field);exit();
			$sql='select * from erp_privi.sys_masterdok ma where ma.ldeleted = 0 and ma.iM_modul_fields='.$form_field['iM_modul_fields'];
			$qsql=$this->db->query($sql);
			if($qsql->num_rows()>0){
				$rowData=$qsql->row_array();

				$grid="erp_privi_".$id."_".$rowData['filename'];
				$nmmodule= $form_field['vParent_path_file']; //ambil dari field di m_application
				$nmTable="tb_details_".$grid; 
				$pager="pager_tb_details_".$grid;
				$caption 	= "";
				$isubmit 	= isset($isubmit)?$isubmit:0;
				$arrSearch 	= array('upload_file'=>'Nama File','vket'=>'Keterangan','action'=>'Action');
				$wsearch 	= array('upload_file'=>300,'vket'=>300,'action'=>180);
				$alsearch 	= array('action'=>'center'); 
				$in 		= array();

				foreach ($get as $kget => $vget) {
				    if($kget != "action"){
				        $in[] = $kget."=".$vget;
				    } else if ($kget == "action"){
				        $in[] = "act=".$vget;
				    } else if ($kget == "act"){
				        $in[] = "act2=".$vget;
				    }
				}

				$g 			= implode("&", $in);
				$g 			= $g."&isubmit=".$isubmit;
				$grid2 		= str_replace("_".$field,"",$id);
				$getUrl 	= str_replace('_','/',$grid2);
				$getUrl 	= $nmmodule.'/'.$getUrl;

				?>

				<table id="<?php echo $nmTable ?>"></table>
				<div id="<?php echo $pager ?>"></div>
				<iframe height="0" width="0" id="iframe_preview_<?php echo $grid; ?>"></iframe>
				<script type="text/javascript">
				    $grid 	= $("#<?php echo $nmTable ?>");
				    <?php

				    $nmf 	= array();
				    foreach ($arrSearch as $kv => $vv) {
				        $nmf[] 	= "'".$kv."'";
				        $cn[] 	= "'".$vv."'";
				        $wi 	= isset($wsearch[$kv])?",width: ".$wsearch[$kv]:"";
				        $al 	= isset($alsearch[$kv])?",align: '".$alsearch[$kv]."'":"";
				        $cm[] 	= "{name:'".$kv."'".$wi.$al."}";
				    }

				    ?>
				    var outerwidth = $grid.parent().width() - 20;
				    $(document).ready(function(){
				        $grid.jqGrid({
				            url 		: base_url+"processor/<?php echo $getUrl ?>?action=get_data_prev&<?php echo $g ?>",
							postData	: 
								{
									id:'<?php echo $dataHead[$main_table_pk] ?>',
									grid:"<?php echo $grid ?>",nmTable:"<?php echo $nmTable ?>",
									namefield:"<?php echo $rowData['filename'] ?>",
									iReq:<?php echo $form_field['iRequired']?> 
								},
				            datatype 	: "json",
				            mtype 		: 'POST',
				            colNames 	: [<?php echo implode(",", $cn)?>],
				            colModel 	: [
				               <?php echo implode(",", $cm); ?> 
				            ],
				            loadonce 	: false,
				            rowNum 		: '1000',
				            pager 		: '#<?php echo $pager; ?>',
				            width 		: outerwidth,
				            shrinkToFit : false,
				            rownumbers  : true,

				            pgbuttons 	: false,
				            pginput 	: false,
				            pgtext 		: "",

				            caption 	: "<?php echo $caption ?>",
				            autowidth 	: false,
				            cmTemplate 	: {
				                title 	: false,
				                sortable: false
				            },
				            gridComplete: function () {
				                $('#lbl_rowcount').val($grid.getGridParam('records'));
				                $(".icon-play").button({
				                    icons:{
				                        primary: "ui-icon-play"
				                    },
				                    text: true
				                });
				                $(".icon-extlink").button({
				                    icons:{
				                        primary: "ui-icon-extlink"
				                    },
				                    text: true
				                }); 
				                $(".icon-disk").button({
				                    icons:{
				                        primary: "ui-icon-disk"
				                    },
				                    text: true
				                });
				                $(".icon-pause").button({
				                    icons:{
				                        primary: "ui-icon-pause"
				                    },
				                    text: true
				                });
				                $(".icon-stop").button({
				                    icons:{
				                        primary: "ui-icon-stop"
				                    },
				                    text: true
				                });

				                $( "button.icon_hapus" ).button({
				                    icons: {
				                        primary: "ui-icon-close"
				                    },
				                    text: true
				                });
				            }
				    
				        });

				        jQuery("#<?php echo $nmTable ?>")
				        	.jqGrid('gridResize',
				        			{ 
				        				minWidth 	: 300,
				        				maxWidth 	: 790,
				        				minHeight 	: 80, 
				        				maxHeight 	:370
				        			})
				        	.navGrid('#<?php echo $pager; ?>',
				        		{
				        			edit 	: false,
				        			add 	: false,
				        			del 	: false,
				        			search 	: false,
				        			refresh : false
				        		})
				       <?php if($get['action']!='view' and $isubmit==0){ ?>
				                .navButtonAdd('#<?php echo $pager; ?>',{
				                   caption:"Tambah", 
				                   buttonicon:"ui-icon-plus", 
				                   onClickButton: function(){ 
				                    addrow_<?php echo $nmTable; ?>();
				                   }, 
				                   position:"last"
				                })
				        <?php 
				        }
				        ?>
				    })
				    

				    function addrow_<?php echo $nmTable; ?>(){
				            //get last num rows
				            var n='';
				            var i=0;
				            $.each($(".num_rows_<?php echo $nmTable; ?>"),function(){
				                if(i==0){
				                    n+=$(this).val();
				                }else{
				                    n+=','+$(this).val();
				                }
				                i++;
				            });
				            if(n==""){
				                var rlast=1;   
				            }else{
				                var s=JSON.parse("["+n+"]");
				                var rlast = parseInt(Math.max.apply(Math, s)) +1;
				            }
				            var sa=[["<input type='hidden' class='num_rows_<?php echo $nmTable ?>' value='"+rlast+"' /><input type='file' id='<?php echo $grid; ?>_upload_file_"+rlast+"' class='fileupload1 multi multifile required' name='<?php echo $grid; ?>_upload_file[]' style='width: 90%' /> *","<textarea class='' id='<?php echo $grid; ?>_fileketerangan_"+rlast+"' name='<?php echo $grid; ?>_fileketerangan[]' style='width: 290px; height: 50px;' size='290'></textarea>","<a class='ui-button-text' href='javascript:;' onclick='javascript:hapus_row_<?php echo $nmTable ?>("+rlast+")'>[Hapus]</a>"]];
				            var lastr=jQuery("#<?php echo $nmTable; ?>").jqGrid('getGridParam', 'records');
				            var names = [<?php $sas = implode(',', $nmf); echo $sas;?>];
				            var mydata = [];
				            for (var i = 0; i < sa.length; i++) {
				                mydata[i] = {};
				                for (var j = 0; j < sa[i].length; j++) {
				                    mydata[i][names[j]] = sa[i][j];
				                }
				            }
				            $("#<?php echo $nmTable; ?>").jqGrid('addRowData', rlast, mydata[0]);
				            $( "button.icon_hapus" ).button({
				                icons: {
				                    primary: "ui-icon-close"
				                },
				                text: true
				            });
				    }

				    function hapus_row_<?php echo $nmTable ?>(rowId){
				        var lastr=jQuery("#<?php echo $nmTable; ?>").jqGrid('getGridParam', 'records');
				        if(lastr<=1){
				             _custom_alert("Tidak Bisa, Minimal 1 Upload","Info","info", "<?php echo $grid ?>", 1, 20000);
				             return false;
				        }else{
				            custom_confirm('Anda Yakin ?',function(){
				                $('#<?php echo $nmTable; ?>').jqGrid('delRowData',rowId);
				            });
				        }
				    }

				</script>
			<?php
				}else{
					echo '<span style="color:red;">Module Upload Not Config</span>';
				}
			break;

		case '17':
			$sql="";
			$value=$dataHead[$field];
			if ($form_field['iValidation']==1) {
				$sql =$form_field['vSource_input_edit'].' ';	

				$sFieldValidation = 'select a.vSource_input_validtation 
									from erp_privi.m_modul_fields_validation a 
									where a.lDeleted=0 
									and a.iValidation=1 
									and a.iM_modul_fields= "'.$form_field['iM_modul_fields'].'" ';
				$dFieldValidation = $this->db->query($sFieldValidation)->result_array();

				if(!empty($dFieldValidation)){
					foreach ($dFieldValidation as $dFieldValid) {
						$sql .=	 $dFieldValid['vSource_input_validtation'].' ';					
					}
				}

				if(!empty($dFieldValidation)){
					foreach ($dFieldValidation as $dFieldValid) {
						$sql .=	 $dFieldValid['vSource_input_validtation'].' ';					
					}
				}



				// baca team
				
				$sql .=	 'and a.cNip in (
											select b1.vnip 
											from plc2.plc2_upb_team a1
											join plc2.plc2_upb_team_item b1 on b1.iteam_id=a1.iteam_id
											where a1.ldeleted=0
											and b1.ldeleted=0
											and a1.iteam_id in ('.$hasTeamID.')
					) ';					

				

			}else{
				$sql = $form_field['vSource_input_edit'];	
			}

			if($sql<>''){
				$union = 'select cNip as valval, concat(cNip, " - ", vName) as showshow from hrd.employee where cNip = "'.$value.'" union ';
				$pilihan = $this->db->query($union.$sql)->result_array();
	            $return = '<select class="input_rows1 '.$field_required.' choose" name="'.$field.'"  id="'.$id.'" >';   
	             $return .= '<option value="">-------Pilih-------</option>';
	            foreach($pilihan as $me) {
	            	$select=$value==$me['valval']?'selected':'';
	                $return .= '<option value='.$me['valval'].' '.$select.'>'.$me['showshow'].'</option>';
	            }            
	            $return .= '</select>';

			}else{
				$return .= '<span style="color:red;">SQL Belum disetting</span>';				
			}
			break;
		case '18':
			$ff=str_replace($field, "form_detail", $id).'_'.$field;
			$return .= '<script>
					$("label[for=\''.$ff.'\']").css({"border": "1px solid #dddddd", "background": "#548cb6", "border-collapse": "collapse","width":"99%","font-weight":"bold","color":"#ffffff","text-shadow": "0 1px 1px rgba(0, 0, 0, 0.3)","text-transform": "uppercase"});
				</script>';
			break;
		case '19':
			$label = (isset($label))?$label:$dataHead[$field];
			$default = (isset($default))?$default:$dataHead[$field];
			$return = $label;
			$return .= '<input type="hidden" value="'.$default.'"  name="'.$field.'" id="'.$id.'" class="input_rows1" size="10" '.$field_required.'>';
			break;
		case '20':
			$vSource_input_edit =$form_field['vSource_input_edit'].' ';	
			if ($form_field['iValidation']==1) {
				$sql = $vSource_input_edit;	
			}else{
				$sql = $vSource_input_edit;	
			}
			
			if($sql<>''){

				$val = $dataHead[$field];
				if($val==""){
					$vale = 0;
				}else{
					$vale = $val;
				}

				$sql = str_replace('$valval',$vale, $sql); 
				
				$pilihan =  $this->db->query($sql)->row_array();
				
				if(!empty($pilihan)){
					$return .= $pilihan['showshow'];
				}else{
					$return .= 'Value Not Found';
				}

				$return .= '<input type="hidden"  name="'.$field.'" id="'.$id.'" value="'.$dataHead[$field].'" class="input_rows1 '.$field_required.'" size="10"  readonly="readonly">';

			}else{
				$return .= '<span style="color:red;">SQL Belum disetting</span>';				
			}
			
			break;

		default:
			$return = '<input type="text"  name="'.$field.'" id="'.$id.'" class="input_rows1 required" size="10" '.$field_required.'>';
			break;



	}

echo $return;
	
if(isset($form_field['iLoad'])&&isset($form_field['vLoad_path'])){
	if($form_field['iLoad']==1){
		$path =CI::$APP->router->fetch_module();
		if(file_exists(APPPATH.'../modules/'.$path.'/views/partial/modul/'.$form_field['vLoad_path'].EXT) || file_exists(APPPATH.'../../erp_modules/'.$path.'/views/partial/modul/'.$form_field['vLoad_path'].EXT)){
			$dd["field"]=$field;
			$dd["id"]=$id;
			$dd['rowData']=$form_field;
			$dd['dataHead']=$dataHead;
			echo $this->load->view('partial/modul/'.$form_field['vLoad_path'],$dd,TRUE);
		}
	}
}


?>

<style>
	.chzn-container .chzn-results {
    max-height:150px;
}
</style>

<script type="text/javascript">
	var dateToday = new Date();
	// datepicker
	 $(".tanggal").datepicker({changeMonth:true,
								changeYear:true,
								dateFormat:"yy-mm-dd", 
								showOn: "button",
						      	buttonImage: base_url+"assets/images/calendar.gif",
						      	buttonImageOnly: true,
						      	buttonText: "Select date" }).attr('readonly','readonly');;

	 $(".canbackdate").datepicker({changeMonth:true,
								changeYear:true,
								maxDate: dateToday,
								      showOn: "button",
						      buttonImage: base_url+"assets/images/calendar.gif",
						      buttonImageOnly: true,
						      buttonText: "Select date",
								dateFormat:"yy-mm-dd" }).attr('readonly','readonly');;
	 $(".cannextdate").datepicker({
	 	changeMonth:true,
		changeYear:true,
		minDate: dateToday,
		showOn: "button",
		buttonImage: base_url+"assets/images/calendar.gif",
		buttonImageOnly: true,
		buttonText: "Select date",
		dateFormat:"yy-mm-dd"
	}).attr('readonly','readonly');;

	// input number
	   $(".angka").numeric();

	// dropdown chosen
	//$('select.choose').chosen({'allow_single_deselect' : true});\
	$('select.choose').chosen();
	//$('select.choose').select2();
</script>