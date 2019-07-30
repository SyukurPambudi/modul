<?php 
	
	/*print_r($form_field);
	exit;*/
	/* 
		Jenis Filed tersedia

		1. Input Field
		2. Number
		3. Datepicker
		4. Textarea
		5. Dropdown Static
		6. Dropdown Dynamic
		7. File Upload
		8. Custom / Redraw

	*/
	$field_required=isset($field_required)?$field_required:"";
	$return="";
	switch ($iM_jenis_field) {
		case '1':
			$return = '<input type="text"  name="'.$field.'" id="'.$id.'" class="input_rows1 '.$field_required.' " size="35" >';
			break;
		
		case '2':
			$return = '<input type="text"  name="'.$field.'" id="'.$id.'" class="input_rows1 angka '.$field_required.'" size="10" >';
			break;

		case '3':
			$return = '<input type="text"  name="'.$field.'" id="'.$id.'" class="input_rows1 tanggal '.$field_required.'" size="10" >';
			break;

		case '4':
			$return = '<textarea  name="'.$field.'" class="input_rows1 '.$field_required.'" colspan="2" id="'.$id.'" ></textarea>';
			break;
		case '5':

			$pilihan = $vSource_input;
			$exp1 = explode(',', $pilihan);
			$choice = array();

			foreach ($exp1 as $key => $value) {
				$exp2 = explode(':', $value);
				$choice[$exp2[0]] = $exp2[1];
			}
			
            $return = '<select class="input_rows1 '.$field_required.' choose" name="'.$field.'"  id="'.$id.'" >';            
            foreach($choice as $k=>$v) {
                $return .= '<option value="'.$k.'">'.$v.'</option>';
            }            
            $return .= '</select>';

			break;
		case '55':

			$pilihan = $vSource_input;
			$exp1 = explode(',', $pilihan);
			$choice = array();

			foreach ($exp1 as $key => $value) {
				$exp2 = explode(':', $value);
				$choice[$exp2[0]] = $exp2[1];
			}
			
            $return = '<select class="input_rows1 '.$field_required.' " name="'.$field.'"  id="'.$id.'" >';            
            foreach($choice as $k=>$v) {
                $return .= '<option value="'.$k.'">'.$v.'</option>';
            }            
            $return .= '</select>';

			break;
		case '6':

			if ($form_field['iValidation']==1) {
				$sql = $vSource_input.' ';	

				$sFieldValidation = 'select a.vSource_input_validtation 
									from plc3.m_modul_fields_validation a 
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


			}else{
				$sql = $vSource_input;	
			}

			// baca jika baca team
			/*if ($form_field['iRead_team']==1) {
				$sql .=	 'and '.$form_field['vRead_team'].' in ('.$hasTeamID.') ';					

			}*/

			

			
			if($sql<>''){
				$sql = str_replace('$nip$', $this->user->gNIP, $sql);
				$pilihan = $this->db->query($sql)->result_array();
	            $return = '<select class="input_rows1 '.$field_required.' choose" name="'.$field.'"  id="'.$id.'" >';            
	            foreach($pilihan as $me) {
	                $return .= '<option value='.$me['valval'].'>'.$me['showshow'].'</option>';
	            }            
	            $return .= '</select>';

			}else{
				$return .= '<span style="color:red;">SQL Belum disetting</span>';				
			}
            
			break;

		case '7':
				/*$data['rowDataH']= $dataHead;*/
	           	$data['date'] = date('Y-m-d H:i:s');    
	           	$data['tabel_file'] = $tabel_file;
	           	$data['tabel_file_pk'] = $tabel_file_pk;
	           	$data['nmfield'] = $field;
	           	$data['tabel_file_pk_id'] = $tabel_file_pk_id;
	           	$data['field_required'] = $field_required;
                $data['iModul_id'] = $iModul_id;
                $data['modul_id'] = $modul_id;


	           $return = '<input type="hidden" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="30"  />';
	           $return .= $this->load->view('partial/v3_form_upload_file',$data,TRUE);

			break;


		case '8':
				/*$data['rowDataH']= $dataHead;*/
				$act=isset($act)?$act:'';
				$field=isset($field)?$field:'';
				$field_required=isset($field_required)?$field_required:'';
				$hasTeam=isset($hasTeam)?$hasTeam:'';
				$hasTeamID=isset($hasTeamID)?$hasTeamID:'';
				$iModul_id=isset($iModul_id)?$iModul_id:'';
				$modul_id=isset($modul_id)?$modul_id:'';
				$data['act'] = $act;
	           	$data['date'] = date('Y-m-d H:i:s');    
	           	// $data['tabel_file'] = $tabel_file;
	           	// $data['tabel_file_pk'] = $tabel_file_pk;
	           	$data['nmfield'] = $field;
	           	//$data['tabel_file_pk_id'] = $tabel_file_pk_id;
	           	$data['field_required'] = $field_required;
	           	
	           	
	           	$data['hasTeam']= $hasTeam ;
                $data['hasTeamID']= $hasTeamID;
                $data['iModul_id'] = $iModul_id;
                $data['modul_id'] = $modul_id;




	           //$return = '<input type="hidden" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="30"  />';
	           $return .= $this->load->view('partial/modul/'.$form_field['vFile_detail'],$data,TRUE);
	           
			break;

		case '9':
			$return = 'Auto Generate';
			break;

		case '10':
			$return = '<input type="text"  name="'.$field.'" id="'.$id.'" class="input_rows1 '.$field_required.'" size="10" '.$field_required.' value="'.date("Y-m-d").'" readonly="readonly">';
			break;

		case '11':
			$return = '<input type="text"  name="'.$field.'" id="'.$id.'" class="input_rows1 canbackdate '.$field_required.'" size="10" '.$field_required.' readonly="readonly">';

		case '12':
			$return = '<input type="text"  name="'.$field.'" id="'.$id.'" class="input_rows1 cannextdate '.$field_required.'" size="10" '.$field_required.' readonly="readonly">';
			break;

		case '13':

			if ($form_field['iValidation']==1) {
				$sql = $vSource_input.' ';	

				$sFieldValidation = 'select a.vSource_input_validtation 
									from plc3.m_modul_fields_validation a 
									where a.lDeleted=0 
									and a.iValidation=1 
									and a.iM_modul_fields= "'.$form_field['iM_modul_fields'].'" ';
				$dFieldValidation = $this->db->query($sFieldValidation)->result_array();

				if(!empty($dFieldValidation)){
					foreach ($dFieldValidation as $dFieldValid) {
						$sql .=	 $dFieldValid['vSource_input_validtation'].' ';					
					}
				}


			}else{
				$sql = $vSource_input;
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
				/*echo '<pre>'.$sql;*/
				/*Get Order And Group By*/
				$sFieldValidation_after = 'select m_modul_fields_validation_after.vSource_input_validtation_after  
									from plc3.m_modul_fields_validation_after
									where m_modul_fields_validation_after.lDeleted=0 and m_modul_fields_validation_after.iM_modul_fields="'.$form_field['iM_modul_fields'].'" 
									order by m_modul_fields_validation_after.iSort DESC';
				$dFieldValidation_after = $this->db->query($sFieldValidation_after)->result_array();

				if(!empty($dFieldValidation_after)){
					foreach ($dFieldValidation_after as $dFieldValid_after) {
						$sql .=	' '.$dFieldValid_after['vSource_input_validtation_after'].' ';					
					}
				}
				$pilihan = $this->db->query($sql)->result_array();
	            $return = '<select class="input_rows1 '.$field_required.' choose" name="'.$field.'"  id="'.$id.'" '.$field_required.' >';   
	             $return .= '<option value="">-------Pilih-------</option>';         
	            foreach($pilihan as $me) {
	                $return .= '<option value='.$me['valval'].'>'.$me['showshow'].'</option>';
	            }            
	            $return .= '</select>';
	            /*$return .='<div name="'.$field.'"  id="'.$id.'" class="full_colums" style="background-color:white;max-width:99%;">dsadsadsa</div>'; */
	            $return .='<div id="'.$id.'_details_upb" class="" style="max-width:98%;"></div>'; 
	            $return .='<script>
						$("#'.$id.'").on("change", function(evt, params) {
							attrjenis=$("#'.$id.'").attr("name");
						    if ($(this).val() != ""){
							    $.ajax({
										url: base_url+"processor/plc/v3/partial/controllers/plc?action=getDetailsUPB",
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
				$return .= '<span style="color:red;">SQL Belum disetting</span>';				
			}
			break;

		case '14':
			$return = '<input type="hidden"  name="'.$field.'" id="'.$id.'" value="'.$this->user->gNIP.'" class="input_rows1 '.$field_required.'" size="10" '.$field_required.' readonly="readonly">';

			$return .= $this->user->gNIP.' - '.$this->user->gName;
			break;

		case '15':
			$return = '<input type="text"  name="'.$field.'" id="'.$id.'" class="input_rows1 required" readonly="readonly" size="35" '.$field_required.'>';
			break;

		case '16':

			/*Get Details Form*/
			$sql='select * from erp_privi.sys_masterdok ma where ma.ldeleted = 0 and ma.iM_modul_fields='.$form_field['iM_modul_fields'];

			$qsql=$this->db->query($sql);
			if($qsql->num_rows()>0){
					$rowData=$qsql->row_array();
					//Config Variable//
					$grid="erp_privi_".$id."_".$rowData['filename'];
					$nmmodule=$field;
					$nmTable="tb_details_".$grid;
					$pager="pager_tb_details_".$grid;
					$caption = "";
					$isubmit=isset($isubmit)?$isubmit:0;
					$arrSearch=array('upload_file'=>'Nama File','vket'=>'Keterangan','action'=>'Action');
					$wsearch=array('upload_file'=>300,'vket'=>300,'action'=>180);
					$alsearch=array('action'=>'center');
					foreach ($get as $kget => $vget) {
					    if($kget!="action"){
					        $in[]=$kget."=".$vget;
					    }elseif($kget=="action"){
					        $in[]="act=".$vget;
					    }
					}
					$g=implode("&", $in);
					$g=$g."&isubmit=".$isubmit;
					$getUrl=str_replace('_','/',$grid);
					$getUrl=$nmmodule.'/'.$getUrl;
					?>
					<table id="<?php echo $nmTable ?>"></table>
					<div id="<?php echo $pager ?>"></div>
					<iframe height="0" width="0" id="iframe_preview_<?php echo $grid; ?>"></iframe>
					<script type="text/javascript">
					    $grid=$("#<?php echo $nmTable ?>");
					    <?php
					    $nmf=array();
					    foreach ($arrSearch as $kv => $vv) {
					        $nmf[]="'".$kv."'";
					        $cn[]="'".$vv."'";
					        $wi=isset($wsearch[$kv])?",width: ".$wsearch[$kv]:"";
					        $al=isset($alsearch[$kv])?",align: '".$alsearch[$kv]."'":"";
					        $cm[]="{name:'".$kv."'".$wi.$al."}";
					    }
					    ?>
					    var outerwidth = $grid.parent().width() - 20;
					    $(document).ready(function(){
					        $grid.jqGrid({
					            url: base_url+"processor/<?php echo $getUrl ?>?action=get_data_prev&<?php echo $g ?>",
					            postData: {id:'<?php echo $id ?>'},
					            datatype: "json",
					            mtype:'POST',
					            colNames: [<?php echo implode(",", $cn)?>],
					            colModel: [
					               <?php echo implode(",", $cm); ?> 
					            ],
					            loadonce: true,
					            rowNum: '1000',
					            pager:'#<?php echo $pager; ?>',
					            width:outerwidth,
					            shrinkToFit:false,
					            rownumbers:true,

					            pgbuttons: false,
					            pginput: false,
					            pgtext: "",

					            caption:"<?php echo $caption ?>",
					            autowidth:false,
					            cmTemplate: {
					                title: false,
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

					        jQuery("#<?php echo $nmTable ?>").jqGrid('gridResize',{minWidth:300,maxWidth:790,minHeight:80, maxHeight:370}).navGrid('#<?php echo $pager; ?>',{edit:false,add:false,del:false,search:false,refresh:false})
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
					            var sa=[["<input type='hidden' class='num_rows_<?php echo $nmTable ?>' value='"+rlast+"' /><input type='file' id='<?php echo $grid; ?>_upload_file_"+rlast+"' class='fileupload1 multi multifile required' name='<?php echo $grid; ?>_upload_file[]' style='width: 90%' /> *","<textarea class='' id='<?php echo $grid; ?>_fileketerangan_"+rlast+"' name='<?php echo $grid; ?>_fileketerangan[]' style='width: 290px; height: 50px;' size='290'></textarea>", "<button id='ihapus_<?php echo $nmTable ?>' class='ui-button-text icon_hapus' style='width:75px' onclick='javascript:hapus_row_<?php echo $nmTable ?>("+rlast+")' type='button'>Hapus</button>"]];
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

			if ($form_field['iValidation']==1) {
				$sql = $vSource_input.' ';	

				$sFieldValidation = 'select a.vSource_input_validtation 
									from plc3.m_modul_fields_validation a 
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
				$sql = $form_field['vSource_input'];	
			}

			

			
			if($sql<>''){
				$pilihan = $this->db->query($sql)->result_array();
	            $return = '<select class="input_rows1 '.$field_required.' choose" name="'.$field.'"  id="'.$id.'" >';            
	            foreach($pilihan as $me) {
	                $return .= '<option value='.$me['valval'].'>'.$me['showshow'].'</option>';
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
			$label = (isset($label))?$label:'-';
			$default = (isset($default))?$default:'0';
			$return = $label;
			$return .= '<input type="hidden" value="'.$default.'"  name="'.$field.'" id="'.$id.'" class="input_rows1 required" size="10" '.$field_required.'>';
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
			echo $this->load->view('partial/modul/'.$form_field['vLoad_path'],$dd,TRUE);
		}
	}
}

?>

<?php 
	
	
    

 ?>
<style>
	.chzn-container .chzn-results {
    max-height:150px;
}
</style>
<script type="text/javascript">
	// datepicker
	var dateToday = new Date();
	 $(".tanggal").datepicker({changeMonth:true,
								changeYear:true,
								dateFormat:"yy-mm-dd" });

	 $(".canbackdate").datepicker({changeMonth:true,
								changeYear:true,
								maxDate: dateToday,
								      showOn: "button",
						      buttonImage: base_url+"assets/images/calendar.gif",
						      buttonImageOnly: true,
						      buttonText: "Select date",
								dateFormat:"yy-mm-dd" });

	$(".cannextdate").datepicker({
	 	changeMonth:true,
		changeYear:true,
		minDate: dateToday,
		showOn: "button",
		buttonImage: base_url+"assets/images/calendar.gif",
		buttonImageOnly: true,
		buttonText: "Select date",
		dateFormat:"yy-mm-dd"
	});

	// input number
	   $(".angka").numeric();

	// dropdown chosen
	//$('select.choose').chosen({'allow_single_deselect' : true});\
	$('select.choose').chosen();
	
</script>