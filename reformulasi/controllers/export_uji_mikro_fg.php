<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class export_uji_mikro_fg extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('auth_export');
		$this->dbset = $this->load->database('formulasi', false, true);
		$this->load->library('lib_utilitas');
		$this->user = $this->auth_export->user();
		$this->filepath='files/reformulasi/export/uji_mikro_fg';
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Reformulasi - Uji Mikro FG');		
		$grid->setTable('reformulasi.export_uji_mikro_fg');		
		$grid->setUrl('export_uji_mikro_fg');
		$grid->addList('export_refor_formula.vnoFormulasi','export_req_refor.vno_export_req_refor','dossier_upd.vNama_usulan','isubmit');
		$grid->setSortBy('dupdate');
		$grid->setSortOrder('DESC');

		$grid->addFields('iexport_refor_formula','vNo_req_refor','vNama_usulan','dstart','dfinish','cpic','vhasil','itrial','vfile','iapprove_qa');

		$grid->setLabel('dossier_upd.vNama_usulan', 'Nama Produk');
		$grid->setLabel('export_req_refor.vno_export_req_refor', 'No Req Refor');
		$grid->setLabel('vNama_usulan', 'Nama Produk');
		$grid->setLabel('isubmit', 'Status');
		$grid->setLabel('export_refor_formula.vnoFormulasi', 'No Formulasi');
		$grid->setLabel('iexport_refor_formula', 'No Formulasi');
		$grid->setLabel('vNo_req_refor', 'No Request Refor');
		$grid->setLabel('dstart','Tgl Mulai Mikro FG');
		$grid->setLabel('dfinish','Tgl Selesai Mikro FG');
		$grid->setLabel('cpic','PIC Pengujian Mikro FG');
		$grid->setLabel('vhasil','Hasil Pengujian Mikro FG');
		$grid->setLabel('itrial','Trial ke - (baru hasil OK (PD Trial))');
		$grid->setLabel('vfile','Nama File FG');
		$grid->setLabel('iapprove_qa','Approval QA');

		$grid->setWidth('export_refor_formula.vnoFormulasi',100);
		$grid->setWidth('export_req_refor.vno_export_req_refor',100);
		$grid->setWidth('dossier_upd.vNama_usulan',350);

		$grid->setJoinTable('reformulasi.export_refor_formula', 'export_refor_formula.iexport_refor_formula=reformulasi.export_uji_mikro_fg.iexport_refor_formula', 'inner');
		$grid->setJoinTable('reformulasi.export_req_refor', 'export_req_refor.iexport_req_refor=reformulasi.export_refor_formula.iexport_req_refor', 'inner');
		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id=reformulasi.export_req_refor.idossier_upd_id', 'inner');
		$grid->setRequired('iexport_refor_formula','dstart','dfinish','cpic','vhasil','itrial');

		$grid->setFormUpload(TRUE);

		$grid->setSearch('export_refor_formula.vnoFormulasi','export_req_refor.vno_export_req_refor','dossier_upd.vNama_usulan');
		$grid->setQuery('dossier_upd.ldeleted',0);
		$grid->setQuery('export_uji_mikro_fg.ldeleted',0);
		$grid->setQuery('iexport_refor_formula.ldeleted',0);

		$grid->setGridView('grid');
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
   				$isUpload = $this->input->get('isUpload');
   				if($isUpload) {
   					$lastId=$this->input->get('lastId');
					$path = realpath($this->filepath);
					if(!file_exists($path."/".$lastId)){
						if (!mkdir($path."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again!');
						}
					}
					$fKeterangan = array();
					foreach($_POST as $key=>$value) {						
						if ($key == 'export_uji_mikro_fg_fileketerangan') {
							foreach($value as $k=>$v) {
								$fKeterangan[$k] = $v;
							}
						}
					}
					$i=0;
					foreach ($_FILES['export_uji_mikro_fg_upload_file']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {
							$tmp_name = $_FILES['export_uji_mikro_fg_upload_file']["tmp_name"][$key];
							$name =$_FILES['export_uji_mikro_fg_upload_file']["name"][$key];
							$data['filename'] = $name;
							$data['dInsertDate'] = date('Y-m-d H:i:s');

								if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO reformulasi.export_uji_mikro_fg_file (iuji_mikro_fg_id, vfilename, tketerangan, dcreate, ccreated) 
											VALUES (".$lastId.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
						}
					}
					foreach($sql as $q) {
						try {
						$this->dbset->query($q);
						}catch(Exception $e) {
						die($e);
						}
					}
					$r['message']="Data Berhasil Disimpan";
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');					
					echo json_encode($r);
   				}else{
   					echo $grid->saved_form();
				}
				break;
			case 'download':
				$this->download($this->input->get('file'));
				break;
			case 'delete':
				echo $grid->delete_row();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'updateproses':
				$isUpload = $this->input->get('isUpload');
				$post=$this->input->post();// print_r($post);exit();
				$lastId=$post['export_uji_mikro_fg_iuji_mikro_fg_id'];
				$path = realpath($this->filepath);
				if(!file_exists($path."/".$lastId)){
					if (!mkdir($path."/".$lastId, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
				$fKeterangan = array(); 
                $fileid='';
                foreach($_POST as $key=>$value) {     
                    if ($key == 'export_uji_mikro_fg_fileketerangan') {
                        foreach($value as $y=>$u) {
                            $fKeterangan[$y] = $u;
                        }
                    }
                    if ($key == 'iexport_uji_mikro_fg_file') {
                        $i=0;
                        foreach($value as $k=>$v) {
                            if($i==0){
                                $fileid .= "'".$v."'";
                            }else{
                                $fileid .= ",'".$v."'";
                            }
                            $i++;
                        }
                    }
                }
                if($isUpload) {
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update reformulasi.export_uji_mikro_fg_file set ldeleted=1, dupdate='".$tgl."', cupdate='".$this->user->gNIP."' where iuji_mikro_fg_id='".$lastId."' and iexport_uji_mikro_fg_file not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update reformulasi.export_uji_mikro_fg_file set ldeleted=1, dupdate='".$tgl."', cupdate='".$this->user->gNIP."' where iuji_mikro_fg_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }
                    $i=0;
                    if (isset($_FILES['export_uji_mikro_fg_upload_file']))  {
                        foreach ($_FILES['export_uji_mikro_fg_upload_file']["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['export_uji_mikro_fg_upload_file']["tmp_name"][$key];
                                $name =$_FILES['export_uji_mikro_fg_upload_file']["name"][$key];
                                $data['filename'] = $name;
                                $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO reformulasi.export_uji_mikro_fg_file (iuji_mikro_fg_id, vfilename, tketerangan, dcreate, ccreated) 
											VALUES (".$lastId.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
                            }
                        }
                        foreach($sql as $q) {
                            try {
                            $this->dbset->query($q);
                            }catch(Exception $e) {
                            die($e);
                            }
                        }
                    }

                    $r['message']='Data Berhasil di Simpan';
                    $r['status'] = TRUE;
                    $r['last_id'] = $this->input->get('lastId');                
                    echo json_encode($r);
                    exit();
                }else{
                    $fileid='';
                    foreach($_POST as $key=>$value) {
                        if ($key == 'iexport_uji_mikro_fg_file') {
                            $i=0;
                            foreach($value as $k=>$v) {
                                if($i==0){
                                    $fileid .= "'".$v."'";
                                }else{
                                    $fileid .= ",'".$v."'";
                                }
                                $i++;
                            }
                        }
                    }
                	if($fileid!=''){
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update reformulasi.export_uji_mikro_fg_file set ldeleted=1, dupdate='".$tgl."', cupdate='".$this->user->gNIP."' where iuji_mikro_fg_id='".$lastId."' and iexport_uji_mikro_fg_file not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update reformulasi.export_uji_mikro_fg_file set ldeleted=1, dupdate='".$tgl."', cupdate='".$this->user->gNIP."' where iuji_mikro_fg_id='".$lastId."'";
                        $this->dbset->query($sql1);
                    }
                    echo $grid->updated_form();
                }
				break;
			case 'getspname':
				echo $this->getSpname();
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				echo $grid->updated_form();
				break;
			case 'approve':
				echo $this->approve_view();
				break;
			case 'approve_process':
				echo $this->approve_process();
				break;
			case 'reject':
				echo $this->reject_view();
				break;
			case 'reject_process':
				echo $this->reject_process();
				break;
			case 'getemployee':
				echo $this->getEmployee();
				break;
			case 'get_data_prev':
				echo $this->getdetailsprev();
				break;
			default:
				$grid->render_grid();
				break;
		}
	}

	/*Manipulate main grid*/
	function listBox_export_uji_mikro_fg_isubmit($v, $pk, $name, $rowData) {
		$re="-";
		if($v==0){
			$re="Draft - Need Submit";
		}else{
			if($rowData->iapprove_qa==0){
				$re="Submited - Waiting Appoval";
			}elseif($rowData->iapprove_qa==1){
				$re="Rejected";
			}elseif($rowData->iapprove_qa==2){
				$re='Approved';
			}
		}
		return $re;
	}

	function listBox_Action($row, $actions) {
		if($this->auth_export->is_manager()){
			$x=$this->auth_export->dept();
			$manager=$x['manager'];
			if(in_array('QA', $manager)){
				if($row->iapprove_qa>=1){
					 unset($actions['edit']);
				}
			}else{unset($actions['edit']);}
		}
		else{
			$x=$this->auth_export->dept();
			$team=$x['team'];
			if(in_array('QA', $team)){
				$it=$this->getAccessApproveTeam("QA");
				if($it==true){
					if($row->iapprove_qa>=1){
						unset($actions['edit']);
					}
				}else{
					if($row->isubmit>=1){
						 unset($actions['edit']);
					}
				}
			}else{unset($actions['edit']);}
		}
		return $actions;
	}


	/*Insert FORM MOdification*/
	function insertBox_export_uji_mikro_fg_iexport_refor_formula($f, $i){
		$r = '<script>
					$( "button.icon_pop" ).button({
						icons: {
							primary: "ui-icon-newwin"
						},
						text: false
					})
				</script>';
		$r .= '<input type="hidden" name="isdraft" id="isdraft">';
		$r .= '<input type="hidden" name="'.$i.'" id="'.$i.'" class="input_rows1 required" />';
		$r .= '<input type="text" name="'.$i.'_dis" disabled="TRUE" id="'.$i.'_dis" class="input_rows1 required" size="20" />';
		$r .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/reformulasi/browse_export_uji_mikro_fg?field=export_uji_mikro_fg&modul_id='.$this->input->get('modul_id').'\',\'\')" type="button">&nbsp;</button>';
		return $r;
	}

	function insertBox_export_uji_mikro_fg_vNo_req_refor($f, $i){
		return '<input type="text" disabled="TRUE" name="'.$i.'" id="'.$i.'" class="input_rows1" size="20" />';
	}

	function insertBox_export_uji_mikro_fg_vNama_usulan($f, $i){
		return '<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'"></textarea>';
	}

	function insertBox_export_uji_mikro_fg_dstart($f, $i){
		$return = '<input name="'.$i.'" id="'.$i.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px"/>';
		$return .=	'<script>
						$("#'.$i.'").datepicker({dateFormat:"yy-mm-dd",changeMonth: true,changeYear: true});
					</script>';
		return $return;
	}

	function insertBox_export_uji_mikro_fg_dfinish($f, $i){
		$return = '<input name="'.$i.'" id="'.$i.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px"/>';
		$return .=	'<script>
						$("#'.$i.'").datepicker({dateFormat:"yy-mm-dd",changeMonth: true,changeYear: true});
					</script>';
		return $return;		
	}

	function insertBox_export_uji_mikro_fg_cpic($f, $i){
		$url = base_url().'processor/reformulasi/export_uji_mikro_fg?action=getemployee';
		$return	= '<script language="text/javascript">
					$(document).ready(function() {

						/*Is Numeric*/
						$(".isnumeric").keydown(function (e) {
					        // Allow: backspace, delete, tab, escape, enter and .
					        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
					             // Allow: Ctrl/cmd+A
					            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
					             // Allow: Ctrl/cmd+C
					            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
					             // Allow: Ctrl/cmd+X
					            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
					             // Allow: home, end, left, right
					            (e.keyCode >= 35 && e.keyCode <= 39)) {
					                 // let it happen, dont do anything
					                 return;
					        }
					        // Ensure that it is a number and stop the keypress
					        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					            e.preventDefault();
					        }
					    });

						var config = {
							source: function( request, response) {
								$.ajax({
									url: "'.$url.'",
									dataType: "json",
									data: {
										term: request.term,
									},
									success: function( data ) {
										response( data );
									}
								});
							},
							select: function(event, ui){
								$( "#'.$i.'" ).val(ui.item.id);
								$( "#'.$i.'_text" ).val(ui.item.value);
								return false;
							},
							minLength: 2,
							autoFocus: true,
						};
	
						$( "#'.$i.'_text" ).livequery(function() {
						 	$( this ).autocomplete(config);
						});
	
					});
		      </script>
		<input name="'.$i.'" id="'.$i.'" type="hidden" class="required"/>
		<input name="'.$i.'_text" id="'.$i.'_text" type="text" class="required" size="20"/>';
		return $return; 
	}

	function insertBox_export_uji_mikro_fg_vhasil($f, $i){
		$arr=array(""=>"Pilih Hasil",0=>"TMS",1=>"MS");
		$ret="<select id='".$i."' name='".$i."' class='input_rows1 required'>";
		foreach ($arr as $krr => $vrr) {
			$ret.="<option value=".$krr.">".$vrr."</option>";
		}
		$ret.="</select>";
		return $ret;
	}

	function insertBox_export_uji_mikro_fg_itrial($f, $i){
		return '<input type="text" name="'.$i.'" id="'.$i.'" class="input_rows1 isnumeric required" size="20" />';
	}

	function insertBox_export_uji_mikro_fg_vfile($f, $i){
		$data['id']=0;
		$data['get']=$this->input->get();
		return $this->load->view('export/export_uji_mikro_fg_file',$data,TRUE);
	}
	function insertBox_export_uji_mikro_fg_iapprove_qa($f, $i){
		return '-';
	}

	function manipulate_insert_button($buttons) {
		unset($buttons['save']);
		$grid='export_uji_mikro_fg';
		$data['grid']=$grid;
		$js = $this->load->view('export/js/export_uji_mikro_fg_js',$data);
		$save_draft = '<button onclick="javascript:save_draft_'.$grid.'(\''.$grid.'\', \''.base_url().'processor/reformulasi/'.$grid.'?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_'.$grid.'">Save as Draft</button>';
		$save = '<button onclick="javascript:save_submit_'.$grid.'(\''.$grid.'\', \''.base_url().'processor/reformulasi/'.$grid.'?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_'.$grid.'">Save &amp; Submit</button>';
		
		$buttons['save'] = $save_draft.$save.$js;
		return $buttons;
	}

	function before_insert_processor($row, $postData) {
		$postData['dcreate'] = date('Y-m-d H:i:s');
		$postData['ccreated'] =$this->user->gNIP;
			if($postData['isdraft']==true){
				$postData['isubmit']=0;
			} 
			else{
				$postData['isubmit']=1;
			} 
		return $postData;
	}
	function after_insert_processor($r, $insertid, $postData){
		//Jika Submit Send Mail to 
		if($postData['isubmit']==1){

			$dform = $this->getreqdata($insertid);
			$vteampd=$this->getdetailteam($dform['iTeamPD']);
			$teampd=isset($vteampd['vteam'])?$vteampd['vteam']:'-';
			$vteamad=$this->getdetailteam($dform['iTeamAndev']);
			$teamad=isset($vteamad['vteam'])?$vteamad['vteam']:'-';
			$data['cdata'] = array(
				'vno_export_req_refor'=>$dform['export_req_refor__vno_export_req_refor'],
				'vUpd_no'=>$dform['dossier_upd__vUpd_no'],
				'vNama_usulan'=>$dform['dossier_upd__vNama_usulan'],
				'iTeamPD'=>$teampd,
				'iTeamAndev'=>$teamad
			);

			$data['capdata']  = array(
				'vno_export_req_refor'=>'No Req Refor',
				'vUpd_no'=>'No UPD',
				'vNama_usulan'=>'Nama Usulan',
				'iTeamPD'=>'Team PD',
				'iTeamAndev'=>'Team Andev'
			);
			$data['menuapp']="ERP -> Reformulasi -> Export -> Uji Mikro FG";
			$data['caption']="Diberitahukan telah ada Submit pada Aplikasi Reformulasi Export module Uji Mikro FG, dengan rincian sebagai berikut :";
			$subject = "Reformulasi Export - Uji Mikro FG (".$dform['export_req_refor__vno_export_req_refor'].")";
			$teamQA=$this->getnipbytipe("QA");
			$to=implode(";", $teamQA['atasan']);
			$cc=implode(";", $teamQA['bawahan']);
			$content = $this->load->view('export/mail/reformulasi_main_mail',$data,TRUE);
			$this->sess_message->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);
		}
	}

	/*End Insert Form*/


	/*Update FORM MOdification*/

	function updateBox_export_uji_mikro_fg_iexport_refor_formula($f, $i, $v, $row){
		$val=$this->getDetailsForm($row['iuji_mikro_fg_id'],'vnoFormulasi');
		$r = '<script>
					$( "button.icon_pop" ).button({
						icons: {
							primary: "ui-icon-newwin"
						},
						text: false
					})
				</script>';
		$r .= '<input type="hidden" name="isdraft" id="isdraft">';
		$r .= '<input type="hidden" name="'.$i.'" id="'.$i.'" class="input_rows1 required" value="'.$v.'" />';
		$r .= '<input type="text" name="'.$i.'_dis" disabled="TRUE" id="'.$i.'_dis" class="input_rows1 required" size="20" value="'.$val.'" />';
		$r .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/reformulasi/browse_export_uji_mikro_fg?field=export_uji_mikro_fg&modul_id='.$this->input->get('modul_id').'\',\'\')" type="button">&nbsp;</button>';
		if($this->input->get('action')=='view'){
			$r='<input type="text" name="'.$i.'_dis" disabled="TRUE" id="'.$i.'_dis" class="input_rows1 required" size="20" value="'.$val.'" />';
		}
		return $r;
	}

	function updateBox_export_uji_mikro_fg_vNo_req_refor($f, $i, $v, $row){
		$val=$this->getDetailsForm($row['iuji_mikro_fg_id'],'export_req_refor__vno_export_req_refor');
		return '<input type="text" disabled="TRUE" name="'.$i.'" id="'.$i.'" class="input_rows1" size="20" value="'.$val.'" />';
	}

	function updateBox_export_uji_mikro_fg_vNama_usulan($f, $i, $v, $row){
		$val=$this->getDetailsForm($row['iuji_mikro_fg_id'],'dossier_upd__vNama_usulan');
		return '<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'">'.$val.'</textarea>';
	}

	function updateBox_export_uji_mikro_fg_dstart($f, $i, $v, $row){
		$return = '<input name="'.$i.'" id="'.$i.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$v.'"/>';
		$return .=	'<script>
						$("#'.$i.'").datepicker({dateFormat:"yy-mm-dd",changeMonth: true,changeYear: true});
					</script>';
		if($this->input->get('action')=='view'){
			$return='<input type="text" name="'.$i.'_dis" disabled="TRUE" id="'.$i.'_dis" class="input_rows1 required" size="20" value="'.$v.'" />';
		}
		return $return;
	}

	function updateBox_export_uji_mikro_fg_dfinish($f, $i, $v, $row){
		$return = '<input name="'.$i.'" id="'.$i.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$v.'"/>';
		$return .=	'<script>
						$("#'.$i.'").datepicker({dateFormat:"yy-mm-dd",changeMonth: true,changeYear: true});
					</script>';
		if($this->input->get('action')=='view'){
			$return='<input type="text" name="'.$i.'_dis" disabled="TRUE" id="'.$i.'_dis" class="input_rows1 required" size="20" value="'.$v.'" />';
		}
		return $return;		
	}

	function updateBox_export_uji_mikro_fg_cpic($f, $i, $v, $row){
		$val=$this->getDetailsEmploye($v);
		$url = base_url().'processor/reformulasi/export_uji_mikro_fg?action=getemployee';
		$return	= '<script language="text/javascript">
					$(document).ready(function() {

						/*Is Numeric*/
						$(".isnumeric").keydown(function (e) {
					        // Allow: backspace, delete, tab, escape, enter and .
					        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
					             // Allow: Ctrl/cmd+A
					            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
					             // Allow: Ctrl/cmd+C
					            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
					             // Allow: Ctrl/cmd+X
					            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
					             // Allow: home, end, left, right
					            (e.keyCode >= 35 && e.keyCode <= 39)) {
					                 // let it happen, dont do anything
					                 return;
					        }
					        // Ensure that it is a number and stop the keypress
					        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					            e.preventDefault();
					        }
					    });

						var config = {
							source: function( request, response) {
								$.ajax({
									url: "'.$url.'",
									dataType: "json",
									data: {
										term: request.term,
									},
									success: function( data ) {
										response( data );
									}
								});
							},
							select: function(event, ui){
								$( "#'.$i.'" ).val(ui.item.id);
								$( "#'.$i.'_text" ).val(ui.item.value);
								return false;
							},
							minLength: 2,
							autoFocus: true,
						};
	
						$( "#'.$i.'_text" ).livequery(function() {
						 	$( this ).autocomplete(config);
						});
	
					});
		      </script>
		<input name="'.$i.'" id="'.$i.'" type="hidden" class="required" value="'.$v.'"/>
		<input name="'.$i.'_text" id="'.$i.'_text" type="text" class="required" size="20" value="'.$v.' - '.$val['vName'].'"/>';
		if($this->input->get('action')=='view'){
			$return='<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'">'.$v.' - '.$val['vName'].'</textarea>';
		}
		return $return; 
	}

	function updateBox_export_uji_mikro_fg_vhasil($f, $i, $v, $row){
		$arr=array(""=>"Pilih Hasil",0=>"TMS",1=>"MS");
		$ret="<select id='".$i."' name='".$i."' class='input_rows1 required'>";
		foreach ($arr as $krr => $vrr) {
			$sel=$krr==$v?"selected":"";
			$ret.="<option value=".$krr." ".$sel.">".$vrr."</option>";
		}
		$ret.="</select>";
		if($this->input->get('action')=='view'){
			$v=isset($arr[$v])?$arr[$v]:'';
			$ret='<input type="text" name="'.$i.'_dis" disabled="TRUE" id="'.$i.'_dis" class="input_rows1 required" size="20" value="'.$v.'" />';
		}
		return $ret;
	}

	function updateBox_export_uji_mikro_fg_itrial($f, $i, $v, $row){
		$return='<input type="text" name="'.$i.'" id="'.$i.'" class="input_rows1 isnumeric required" size="20" value="'.$v.'" />';
		if($this->input->get('action')=='view'){
			$return='<input type="text" name="'.$i.'" id="'.$i.'" disabled="TRUE"  class="input_rows1 isnumeric required" size="20" value="'.$v.'" />';
		}
		return $return;
	}

	function updateBox_export_uji_mikro_fg_vfile($f, $i, $v, $row){
		$data['id']=$this->getDetailsForm($row['iuji_mikro_fg_id'],'iuji_mikro_fg_id');
		$data['get']=$this->input->get();
		$data['isubmit']=$row['isubmit'];
		return $this->load->view('export/export_uji_mikro_fg_file',$data,TRUE);
	}

	function updateBox_export_uji_mikro_fg_iapprove_qa($f, $i, $v, $row){
		$ret='';
		if($v==0){
			$sub=$row['isubmit']==1?"Submited":"Need Submit";
			$ret="Waiting Approval - ".$sub;
		}else{
			if($v==1){
				$ret="Rejected";
			}elseif($v==2){
				$ret="Approved";
			}
			$usr=$this->getDetailsEmploye($row['capprove_qa']);
			if(count($usr>=1)){
				$ret=" By ".$usr['vName']." at ".$row['dapprove_qa'];
			}
		}
		return $ret;
	}

	function after_update_processor($r, $insertid, $postData){
		if($postData['isubmit']==1){
			$dform = $this->getreqdata($insertid);
			$vteampd=$this->getdetailteam($dform['iTeamPD']);
			$teampd=isset($vteampd['vteam'])?$vteampd['vteam']:'-';
			$vteamad=$this->getdetailteam($dform['iTeamAndev']);
			$teamad=isset($vteamad['vteam'])?$vteamad['vteam']:'-';
			$data['cdata'] = array(
				'vno_export_req_refor'=>$dform['export_req_refor__vno_export_req_refor'],
				'vUpd_no'=>$dform['dossier_upd__vUpd_no'],
				'vNama_usulan'=>$dform['dossier_upd__vNama_usulan'],
				'iTeamPD'=>$teampd,
				'iTeamAndev'=>$teamad
			);

			$data['capdata']  = array(
				'vno_export_req_refor'=>'No Req Refor',
				'vUpd_no'=>'No UPD',
				'vNama_usulan'=>'Nama Usulan',
				'iTeamPD'=>'Team PD',
				'iTeamAndev'=>'Team Andev'
			);
			$data['menuapp']="ERP -> Reformulasi -> Export -> Uji Mikro FG";
			$data['caption']="Diberitahukan telah ada Submit pada Aplikasi Reformulasi Export module Uji Mikro FG, dengan rincian sebagai berikut :";
			$subject = "Reformulasi Export - Uji Mikro FG (".$dform['export_req_refor__vno_export_req_refor'].")";
			$teamQA=$this->getnipbytipe("QA");
			$to=implode(";", $teamQA['atasan']);
			$cc=implode(";", $teamQA['bawahan']);
			$content = $this->load->view('export/mail/reformulasi_main_mail',$data,TRUE);
			$this->sess_message->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);
		}
	}

	function manipulate_update_button($buttons, $rowData){
		unset($buttons['update']);
		$grid='export_uji_mikro_fg';
		$data['grid']=$grid;
		$js = $this->load->view('export/js/export_uji_mikro_fg_js',$data);
		$update_draft = '<button onclick="javascript:update_draft_'.$grid.'(\''.$grid.'\', \''.base_url().'processor/reformulasi/'.$grid.'?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_'.$grid.'">Update as Draft</button>';
		$update = '<button onclick="javascript:update_submit_'.$grid.'(\''.$grid.'\', \''.base_url().'processor/reformulasi/'.$grid.'?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_'.$grid.'">Update &amp; Submit</button>';
		$approve = '<button onclick="javascript:load_popup_'.$grid.'(\''.base_url().'processor/reformulasi/export/uji/mikro/fg?action=approve&iuji_mikro_fg_id='.$rowData['iuji_mikro_fg_id'].'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',\'\',\'Approve Uji Mikro FG\')" class="ui-button-text icon-save" id="button_approve_'.$grid.'">Approve</button>';
		if($this->auth_export->is_manager()){
			$x=$this->auth_export->dept();
			$manager=$x['manager'];
			if(in_array('QA', $manager)){
				if($rowData['isubmit']==0){
					$buttons['update'] = $update_draft.$update.$js;
				}else{
					if($rowData['iapprove_qa']<=0){
						$buttons['update'] = $approve.$js;
					}
				}
			}
		}
		else{
			$x=$this->auth_export->dept();
			$team=$x['team'];
			if(in_array('QA', $team)){
				$it=$this->getAccessApproveTeam("QA");
				if($rowData['isubmit']==0){
					$buttons['update'] = $update_draft.$update.$js;
				}else{
					if($it==true && $rowData['iapprove_qa']<=0){
						$buttons['update'] = $approve.$js;
					}
				}
			}
		}
		return $buttons;
	}

	function before_update_processor($row, $postData) {
		$postData['dcreate'] = date('Y-m-d H:i:s');
		$postData['ccreated'] =$this->user->gNIP;
			if($postData['isdraft']==true){
				$postData['isubmit']=0;
			} 
			else{
				$postData['isubmit']=1;
			} 
		return $postData;
	}

	/*End Update Form*/


	/*Public Output*/
	public function output(){
		$this->index($this->input->get('action'));
	}

	/*Function in Another Action*/
	function approve_view() {
		$echo = '<h1>Approve</h1><br />';
		$echo .= '<form id="form_approve_export_uji_mikro_fg" action="'.base_url().'processor/reformulasi/export/uji/mikro/fg?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="approveBox_export_uji_mikro_fg_iuji_mikro_fg_id" value="'.$this->input->get('iuji_mikro_fg_id').'" />
				<input type="hidden" name="approveBox_export_uji_mikro_fg_group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="approveBox_export_uji_mikro_fg_modul_id" value="'.$this->input->get('modul_id').'" />
				<input type="hidden" name="approveBox_export_uji_mikro_fg_company_id" value="'.$this->input->get('company_id').'" />
				<input type="hidden" name="approveBox_export_uji_mikro_fg_foreign_id" value="'.$this->input->get('foreign_id').'" />
				<input type="hidden" name="approveBox_export_uji_mikro_fg_iapprove_qa" value="2" />
				<textarea id="vRemark" name="approveBox_export_uji_mikro_fg_vRemark"></textarea>';
		$echo .= '</div>';
		$echo .= '</form>';

		return $echo;
	}

	function approve_process(){
		$post=$this->input->post();
		$dataup['iapprove_qa']=$post['approveBox_export_uji_mikro_fg_iapprove_qa'];
		$dataup['tapprove_qa']=$post['approveBox_export_uji_mikro_fg_vRemark'];
		$dataup['dapprove_qa']=date("Y-m-d H:i:s");
		$dataup['capprove_qa']=$this->user->gNIP;
		$dataup['cupdate']=$this->user->gNIP;
		$dataup['dupdate']=date("Y-m-d H:i:s");
		$this->dbset->where('iuji_mikro_fg_id',$post['approveBox_export_uji_mikro_fg_iuji_mikro_fg_id']);
		if($this->dbset->update('reformulasi.export_uji_mikro_fg',$dataup)){
			$data['message']="Approve Success";
			$data['status']=true;
			$data['group_id']=$post['approveBox_export_uji_mikro_fg_group_id'];
			$data['modul_id']=$post['approveBox_export_uji_mikro_fg_modul_id'];
			$data['foreign_id']=$post['approveBox_export_uji_mikro_fg_foreign_id'];
			$data['company_id']=$post['approveBox_export_uji_mikro_fg_company_id'];
			$data['last_id']=$post['approveBox_export_uji_mikro_fg_iuji_mikro_fg_id'];

			/*Send Notif*/
			$id=$post['approveBox_export_uji_mikro_fg_iuji_mikro_fg_id'];
			$dform = $this->getreqdata($id);
			$vteampd=$this->getdetailteam($dform['iTeamPD']);
			$teampd=isset($vteampd['vteam'])?$vteampd['vteam']:'-';
			$vteamad=$this->getdetailteam($dform['iTeamAndev']);
			$teamad=isset($vteamad['vteam'])?$vteamad['vteam']:'-';
			$data['cdata'] = array(
				'vno_export_req_refor'=>$dform['export_req_refor__vno_export_req_refor'],
				'vUpd_no'=>$dform['dossier_upd__vUpd_no'],
				'vNama_usulan'=>$dform['dossier_upd__vNama_usulan'],
				'iTeamPD'=>$teampd,
				'iTeamAndev'=>$teamad
			);

			$data['capdata']  = array(
				'vno_export_req_refor'=>'No Req Refor',
				'vUpd_no'=>'No UPD',
				'vNama_usulan'=>'Nama Usulan',
				'iTeamPD'=>'Team PD',
				'iTeamAndev'=>'Team Andev'
			);
			$data['menuapp']="ERP -> Reformulasi -> Export -> Best Formula";
			$data['caption']="Diberitahukan telah ada Approval pada Aplikasi Reformulasi Export module Uji Mikro FG, dengan rincian sebagai berikut :";
			$subject = "Reformulasi Export - Uji Mikro FG (".$dform['export_req_refor__vno_export_req_refor'].")";
			$teamQA=$this->getnipbytipe("PD",$dform['iTeamPD']);
			$to=implode(";", $teamQA['atasan']);
			$cc=implode(";", $teamQA['bawahan']);
			$content = $this->load->view('export/mail/reformulasi_main_mail',$data,TRUE);
			$this->sess_message->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);

		}else{
			$data['message']="Failed";
			$data['status']=false;
		}
		return json_encode($data);
	}

	/*OPTIONAL FUNCTION*/
	function getEmployee() {
    	$term = $this->input->get('term');
    	$sql='select de.vDescription,em.cNip as cNIP, em.vName as vName from reformulasi.reformulasi_team_item it
				inner join reformulasi.reformulasi_team te on it.ireformulasi_team= te.ireformulasi_team
				inner join hrd.employee em on em.cNip=it.vnip
				inner join hrd.msdepartement de on de.iDeptID=em.iDepartementID 
				where (em.vName like "%'.$term.'%" or em.cNip like "%'.$term.'%") and te.vtipe in ("AD","QA","PD") AND te.iTipe=2 AND it.ldeleted=0 group by em.cNip order by em.vname ASC';
    	$dt=$this->db->query($sql);
    	$data = array();
    	if($dt->num_rows>0){
    		foreach($dt->result_array() as $line) {
	
				$row_array['value'] = $line['cNIP'].' - '.trim($line['vName']);
				$row_array['id']    = $line['cNIP'];
	
				array_push($data, $row_array);
			}
    	}
    	echo json_encode($data);
		exit;
    }

    function getDetailsForm($id=0,$field='null'){
    	$sql="SELECT export_req_refor.vno_export_req_refor AS export_req_refor__vno_export_req_refor, dossier_upd.vNama_usulan AS dossier_upd__vNama_usulan, reformulasi.export_refor_formula.*, export_uji_mikro_fg.iuji_mikro_fg_id
			FROM (reformulasi.export_refor_formula)
			INNER JOIN reformulasi.export_req_refor ON export_req_refor.iexport_req_refor=reformulasi.export_refor_formula.iexport_req_refor
			INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id=reformulasi.export_req_refor.idossier_upd_id
			INNER JOIN reformulasi.export_uji_mikro_fg ON export_uji_mikro_fg.iexport_refor_formula=reformulasi.export_refor_formula.iexport_refor_formula
			WHERE export_uji_mikro_fg.iuji_mikro_fg_id=".$id;
		$qsql=$this->db->query($sql);
		$ret='-';
		if($qsql->num_rows()>=1){
			$dt=$qsql->row_array();
			if(isset($dt[$field])){
				$ret=$dt[$field];
			}
		}
		return $ret;
    }

    function getDetailsEmploye($nip=0){
    	$sql="select * from hrd.employee em where em.cNip='".$nip."'";
    	$qsql=$this->db->query($sql);
		$ret=array();
		if($qsql->num_rows()>=1){
			$ret=$qsql->row_array();
		}
		return $ret;
    }

    function getdetailsprev(){
    	$post=$this->input->post();
    	$get=$this->input->get();
		$sql_data="select * from reformulasi.export_uji_mikro_fg_file p where p.ldeleted=0 and p.iuji_mikro_fg_id=".$post['id'];
		//print($sql_data);exit();
		$q=$this->dbset->query($sql_data);
		$rsel=array('vfilename','tketerangan','update');
		$data = new StdClass;
		$data->records=$q->num_rows();
		$i=0;
		foreach ($q->result() as $k) {
			$data->rows[$i]['id']=$k->iexport_uji_mikro_fg_file;
			$z=0;
			foreach ($rsel as $dsel => $vsel) {
				if($vsel=="update"){
					$ini=$i+1;
					$btn1="<input type='hidden' class='num_rows_tb_details_export_uji_mikro_fg' value='".$ini."' />";
					if($get['isubmit']==0){
					$btn1=$btn1."<button id='ihapus_tb_details_harga_database' class='ui-button-text icon_hapus' style='width:75px' onclick='javascript:hapus_row_tb_details_export_uji_mikro_fg(".$ini.")' type='button'>Hapus</button><input type='hidden' name='iexport_uji_mikro_fg_file[]' value='".$k->iexport_uji_mikro_fg_file."' />";
					}
					$value=$k->vfilename;
					$id=$k->iuji_mikro_fg_id;
					$caption='No File';
					$btn2="";
					if($value != '') {
						if (file_exists('./'.$this->filepath.'/'.$id.'/'.$value)) {
							$caption='Download';
							$link = base_url().'processor/reformulasi/export/uji/mikro/fg?action=download&id='.$id.'&file='.$value;
							$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
							$btn2="<button id='ihapus_tb_details_harga_database' class='ui-button-text icon-extlink' style='width:100px' onclick='javascript:hapus_row_tb_details_export_uji_mikro_fg(".$ini.")' type='button'>".$caption."</button>";
						}
						else {
							$btn2 = ' [No File!]';
						}
					}
					else {
						$btn2 = ' [No File!]';
					}
					if($get['act']=='update'){
						$dataar[$dsel]=$btn1.$btn2;
					}else{
						$dataar[$dsel]=$btn2;
					}
				}else{
					$dataar[$dsel]=$k->{$vsel};
				}
				$z++;
			}
			$data->rows[$i]['cell']=$dataar;
			$i++;
		}
		return json_encode($data);
	}


	function getreqdata($id=0){
    	$sql="SELECT export_req_refor.iTeamPD,export_req_refor.iTeamAndev,export_req_refor.vno_export_req_refor AS export_req_refor__vno_export_req_refor, dossier_upd.vNama_usulan AS dossier_upd__vNama_usulan,dossier_upd.vUpd_no AS dossier_upd__vUpd_no, reformulasi.export_refor_formula.*, export_uji_mikro_fg.iuji_mikro_fg_id
			FROM (reformulasi.export_refor_formula)
			INNER JOIN reformulasi.export_req_refor ON export_req_refor.iexport_req_refor=reformulasi.export_refor_formula.iexport_req_refor
			INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id=reformulasi.export_req_refor.idossier_upd_id
			INNER JOIN reformulasi.export_uji_mikro_fg ON export_uji_mikro_fg.iexport_refor_formula=reformulasi.export_refor_formula.iexport_refor_formula
			WHERE export_uji_mikro_fg.iuji_mikro_fg_id=".$id;
		$qsql=$this->db->query($sql);
		$ret=array();
		if($qsql->num_rows()>=1){
			$ret=$qsql->row_array();
		}
		return $ret;
    }

    function getdetailteam($id,$h=0){
    	$ret=array();
    	if($h==0){
    		$sql="select t.* from reformulasi.reformulasi_team t where t.ldeleted=0 and t.iTipe=2 and t.ireformulasi_team=".$id;
    		$qr=$this->db->query($sql);
    		if($qr->num_rows>=1){
    			$ret=$qr->row_array();
    		}
    	}else{
    		$sql="select t.* from reformulasi.reformulasi_team_item it
    				join reformulasi.reformulasi_team t on t.ireformulasi_team=it.ireformulasi_team
    				where it.ldeleted=0 and t.ldeleted=0 and t.iTipe=2 and it.ireformulasi_team_item=".$id."
    				group by t.ireformulasi_team";
    				$qr=$this->db->query($sql);
    		if($qr->num_rows>=1){
    			$ret=$qr->row_array();
    		}
    	}
    	return $ret;
    }

    function getnipbytipe($type="",$id=0){
    	$nipatasan=array();
    	$tp=" and t.ireformulasi_team=".$id." and t.vtipe='".$type."'";
    	if($id==0){
    		$tp=" and t.vtipe='".$type."'";
    	}
    	$sqla="select t.* from reformulasi.reformulasi_team t where t.ldeleted=0 and t.iTipe=2 ".$tp;
		$qra=$this->db->query($sqla);
		if($qra->num_rows>=1){
			foreach ($qra->result_array() as $kqra => $vqra) {
				$nipatasan[]=$vqra['vnip'];
			}
		}

		$sqlb="select te.* from reformulasi.reformulasi_team_item te
			join reformulasi.reformulasi_team t on t.ireformulasi_team=te.ireformulasi_team
			where t.ldeleted=0 and t.iTipe=2 ".$tp;
		$qrb=$this->db->query($sqlb);
		$nipb=array();
		if($qrb->num_rows>=1){
			foreach ($qrb->result_array() as $kqrb => $vqrb) {
				$nipb[]=$vqrb['vnip'];
			}
		}
		$data['atasan']=$nipatasan;
		$data['bawahan']=$nipb;
		return $data;
    }

    function getAccessApproveTeam($vteam='0'){
    	$sqls='select i.iapprove from reformulasi.reformulasi_team_item i 
			join reformulasi.reformulasi_team t on t.ireformulasi_team=i.ireformulasi_team
    		where i.ldeleted=0 and t.ldeleted=0 and i.vnip="'.$this->user->gNIP.'" and t.vtipe = "'.$vteam.'"';
    	$qsq=$this->db->query($sqls);
    	$return = false;
    	if($qsq->num_rows()>=1){
    		$dqr=$qsq->row_array();
    		if($dqr['iapprove']==1){
    			$return=true;
    		}else{
    			$return=false;
    		}
    	}else{
    		$return=false;
    	}
    	return $return;
    }

}