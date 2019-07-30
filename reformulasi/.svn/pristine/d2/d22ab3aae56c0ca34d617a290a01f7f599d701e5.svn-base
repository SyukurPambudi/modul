<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class export_stabilita_pilot extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth_export');
		$this->dbset = $this->load->database('formulasi', false, true);
		$this->load->library('lib_utilitas');
		$this->user = $this->auth_export->user();
		$this->filepath='files/reformulasi/export/stabilita_pilot';
		$this->filepathreq="files/reformulasi/export/export_reg_file";
		$this->urlpath="processor/reformulasi/export/stabilita/pilot";
		$this->gridname="export_stabilita_pilot";
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Reformulasi - Stabilita Pilot');		
		$grid->setTable('reformulasi.export_stabilita_pilot');		
		$grid->setUrl($this->gridname);
		$grid->addList('export_refor_formula.vnoFormulasi','export_req_refor.vno_export_req_refor','dossier_upd.vNama_usulan','isubmit');
		$grid->setSortBy('dupdate');
		$grid->setSortOrder('DESC');
		$grid->addFields('iexport_refor_formula','vUpd_no','vNama_usulan','cInisiator_export','iDapartemen_export','tAlasan_export','vUploadfile','iTeamPD','dPermintaan_req_export','cApproval_ats_inisiator','cPicFormulator','lbl','dstabpilot','ireal','iacc','iinter','dhasilstabpilot','vfile','istatus_pilot','iperlu_sample','iapprove_pd');
		
		$grid->setLabel('iexport_refor_formula', 'Nomor Request');
		$grid->setLabel('vUpd_no', 'No UPD');
		$grid->setLabel('vNama_usulan', 'Nama Produk');
		$grid->setLabel('cInisiator_export', 'Nama Inisiator');
		$grid->setLabel('iDapartemen_export', 'Departement');
		$grid->setLabel('tAlasan_export', 'Alasan Refor');
		$grid->setLabel('vUploadfile', 'Upload File');
		$grid->setLabel('iTeamPD', 'Team PD');
		$grid->setLabel('dPermintaan_req_export', 'Tgl Permintaan Refor Export');
		$grid->setLabel('cApproval_ats_inisiator', 'Approval Atasan Inisiator');
		$grid->setLabel('cPicFormulator', 'PIC Formulator Refor');
		$grid->setLabel('lbl', ' ');
		$grid->setLabel('dstabpilot', 'Tanggal Mulai Stabilita Pilot');
		$grid->setLabel('dhasilstabpilot', 'Tanggal Selesai Stabilita Pilot');
		$grid->setLabel('vfile', 'File Upload');
		$grid->setLabel('istatus_pilot', 'Hasil Stabilita');
		$grid->setLabel('iperlu_sample', 'Perlu Sample ?');
		$grid->setLabel('iapprove_pd', 'PD Approval');
		$grid->setLabel('ireal', 'Real Time Test');
		$grid->setLabel('iacc', 'Accelerated Test');
		$grid->setLabel('iinter', 'Intermediate Test');
		$grid->setLabel('ihasil', 'Hasil Stabilita');

		$grid->setLabel('export_refor_formula.vnoFormulasi', 'No Formulasi');
		$grid->setLabel('export_req_refor.vno_export_req_refor', 'No Req Refor');
		$grid->setLabel('dossier_upd.vNama_usulan', 'Nama Produk');
		$grid->setLabel('isubmit', 'Status');

		$grid->setJoinTable('reformulasi.export_refor_formula', 'export_refor_formula.iexport_refor_formula=reformulasi.export_stabilita_pilot.iexport_refor_formula', 'inner');
		$grid->setJoinTable('reformulasi.export_req_refor', 'export_req_refor.iexport_req_refor=reformulasi.export_refor_formula.iexport_req_refor', 'inner');
		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id=reformulasi.export_req_refor.idossier_upd_id', 'inner');

		$grid->setRequired('iexport_refor_formula','ihasil','ireal','iacc','dstabpilot','dhasilstabpilot','vfile','istatus_pilot','iperlu_sample');
		$grid->setFormUpload(TRUE);
		$grid->setSearch('export_refor_formula.vnoFormulasi','export_req_refor.vno_export_req_refor','dossier_upd.vNama_usulan');

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
						if ($key == 'export_stabilita_pilot_file_fileketerangan') {
							foreach($value as $k=>$v) {
								$fKeterangan[$k] = $v;
							}
						}
					}
					$i=0;
					foreach ($_FILES['export_stabilita_pilot_file_upload_file']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {
							$tmp_name = $_FILES['export_stabilita_pilot_file_upload_file']["tmp_name"][$key];
							$name =$_FILES['export_stabilita_pilot_file_upload_file']["name"][$key];
							$data['filename'] = $name;
							$data['dInsertDate'] = date('Y-m-d H:i:s');

								if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO reformulasi.export_stabilita_pilot_file (iexport_stabilita_pilot, vfilename, tketerangan, dcreate, ccreated) 
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
				$lastId=$post['export_stabilita_pilot_iexport_stabilita_pilot'];
				$path = realpath($this->filepath);
				if(!file_exists($path."/".$lastId)){
					if (!mkdir($path."/".$lastId, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
				$fKeterangan = array(); 
                $fileid='';
                foreach($_POST as $key=>$value) {     
                    if ($key == 'export_stabilita_pilot_file_fileketerangan') {
                        foreach($value as $y=>$u) {
                            $fKeterangan[$y] = $u;
                        }
                    }
                    if ($key == 'iexport_stabilita_pilot_file') {
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
                        $sql1="update reformulasi.export_stabilita_pilot_file set ldeleted=1, dupdate='".$tgl."', cupdate='".$this->user->gNIP."' where iexport_stabilita_pilot='".$lastId."' and iexport_stabilita_pilot_file not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update reformulasi.export_stabilita_pilot_file set ldeleted=1, dupdate='".$tgl."', cupdate='".$this->user->gNIP."' where iexport_stabilita_pilot='".$lastId."'";
                        $this->dbset->query($sql1);
                    }
                    $i=0;
                    if (isset($_FILES['export_stabilita_pilot_file_upload_file']))  {
                        foreach ($_FILES['export_stabilita_pilot_file_upload_file']["error"] as $key => $error) {
                            if ($error == UPLOAD_ERR_OK) {
                                $tmp_name = $_FILES['export_stabilita_pilot_file_upload_file']["tmp_name"][$key];
                                $name =$_FILES['export_stabilita_pilot_file_upload_file']["name"][$key];
                                $data['filename'] = $name;
                                $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO reformulasi.export_stabilita_pilot_file (iexport_stabilita_pilot, vfilename, tketerangan, dcreate, ccreated) 
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
                        if ($key == 'iexport_stabilita_pilot_file') {
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
                        $sql1="update reformulasi.export_stabilita_pilot_file set ldeleted=1, dupdate='".$tgl."', cupdate='".$this->user->gNIP."' where iexport_stabilita_pilot='".$lastId."' and iexport_stabilita_pilot_file not in (".$fileid.")";
                        $this->dbset->query($sql1);
                    }else{
                        $tgl= date('Y-m-d H:i:s');
                        $sql1="update reformulasi.export_stabilita_pilot_file set ldeleted=1, dupdate='".$tgl."', cupdate='".$this->user->gNIP."' where iexport_stabilita_pilot='".$lastId."'";
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
			case 'get_data_prev_upload':
				echo $this->getdetailsprevupload();
				break;
			default:
				$grid->render_grid();
				break;
		}
	}

	function listBox_Action($row, $actions) {
		if($this->auth_export->is_manager()){
			$x=$this->auth_export->dept();
			$manager=$x['manager'];
			/*Untuk Manager Andev*/
			if(in_array('PD', $manager)){
				if($row->iapprove_pd>=1){
					 unset($actions['edit']);
				}
			}else{unset($actions['edit']);}
		}
		else{
			$x=$this->auth_export->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){
				$it=$this->getAccessApproveTeam("PD");
				if($it==true){
					if($row->iapprove_pd>=1){
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

	function listBox_export_stabilita_pilot_isubmit($v, $pk, $name, $rowData) {
		$re="-";
		if($v==0){
			$re="Draft - Need Submit";
		}else{
			$re="Submited";
		}
		return $re;
	}

	function listBox_export_stabilita_pilot_iapprove_ad($v, $pk, $name, $rowData) {
		$sa=array(0=>'Waiting Approval',1=>'Rejected',2=>'Approved');
		$re=isset($sa[$v])?$sa[$v]:'-';
		return $re;
	}

	function listBox_export_stabilita_pilot_iapprove_qa($v, $pk, $name, $rowData) {
		$sa=array(0=>'Waiting Approval',1=>'Rejected',2=>'Approved');
		$re=isset($sa[$v])?$sa[$v]:'-';
		return $re;
	}

	/*Insert FORM MOdification*/
	function insertBox_export_stabilita_pilot_iexport_refor_formula($f, $i){
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
		$r .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/reformulasi/browse_export_stabilita_pilot?field=export_stabilita_pilot&modul_id='.$this->input->get('modul_id').'\',\'\')" type="button">&nbsp;</button>';
		return $r;
	}

	function insertBox_export_stabilita_pilot_vUpd_no($f, $i){
		return '<input type="text" disabled="TRUE" name="'.$i.'" id="'.$i.'" class="input_rows1" size="20" />';
	}

	function insertBox_export_stabilita_pilot_vNama_usulan($f, $i){
		return '<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'"></textarea>';
	}

	function insertBox_export_stabilita_pilot_cInisiator_export($f, $i){
		return '<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'"></textarea>';
	}

	function insertBox_export_stabilita_pilot_iDapartemen_export($f, $i){
		return '<input type="text" disabled="TRUE" name="'.$i.'" id="'.$i.'" class="input_rows1" size="20" />';
	}

	function insertBox_export_stabilita_pilot_tAlasan_export($f, $i){
		return '<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'"></textarea>';
	}

	function insertBox_export_stabilita_pilot_vUploadfile($f, $i){
		$data['id']=0;
		$data['get']=$this->input->get();
		return $this->load->view('export/export_stabilita_pilot_file',$data,TRUE);
	}

	function insertBox_export_stabilita_pilot_iTeamPD($f, $i){
		return '<input type="text" disabled="TRUE" name="'.$i.'" id="'.$i.'" class="input_rows1" size="20" />';
	}

	function insertBox_export_stabilita_pilot_dPermintaan_req_export($f, $i){
		return '<input type="text" disabled="TRUE" name="'.$i.'" id="'.$i.'" class="input_rows1" size="20" />';
	}

	function insertBox_export_stabilita_pilot_cApproval_ats_inisiator($f, $i){
		return '<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'"></textarea>';
	}

	function insertBox_export_stabilita_pilot_cPicFormulator($f, $i){
		$r= '<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'"></textarea>';
		return $r;
	}

	function insertBox_export_stabilita_pilot_lbl($f, $i){
		$r = '<script>
			$("label[for=\''.$i.'\']").css({"border": "1px solid #dddddd", "background": "#548cb6", "border-collapse": "collapse","width":"99%","font-weight":"bold","color":"#ffffff","text-shadow": "0 1px 1px rgba(0, 0, 0, 0.3)","text-transform": "uppercase"});
		</script>';
		return $r;
	}

	function insertBox_export_stabilita_pilot_dstabpilot($f, $i){
		$r = '<input name="'.$i.'" id="'.$i.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px"/>';
		$r .=	'<script>
						$("#'.$i.'").datepicker({dateFormat:"yy-mm-dd",changeMonth: true,changeYear: true});
					</script>';
		return $r;
	}

	function insertBox_export_stabilita_pilot_dhasilstabpilot($f, $i){
		$r = '<input name="'.$i.'" id="'.$i.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px"/>';
		$r .=	'<script>
						$("#'.$i.'").datepicker({dateFormat:"yy-mm-dd",changeMonth: true,changeYear: true});
					</script>';
		return $r;
	}

	function insertBox_export_stabilita_pilot_vfile(){
		$data['id']=0;
		$data['get']=$this->input->get();
		return $this->load->view('export/export_stabilita_pilot_file_upload',$data,TRUE);
	}

	function insertBox_export_stabilita_pilot_istatus_pilot($f, $i){
		$sa=array(0=>"TMS",1=>"MS");
		$ret="<select id='".$i."' name='".$i."' class='required'>";
		$ret.="<option value=''>---Pilih---</option>";
		foreach ($sa as $ks => $vs) {
			$ret.="<option value='".$ks."'>".$vs."</option>";
		}
		$ret.='</select>';
		return $ret;
	}

	function insertBox_export_stabilita_pilot_ihasil($f, $i){
		$sa=array(0=>"TMS",1=>"MS");
		$ret="<select id='".$i."' name='".$i."' class='required'>";
		$ret.="<option value=''>---Pilih---</option>";
		foreach ($sa as $ks => $vs) {
			$ret.="<option value='".$ks."'>".$vs."</option>";
		}
		$ret.='</select>';
		return $ret;
	}

	function insertBox_export_stabilita_pilot_ireal($f, $i){
		$sa=array(0=>"TMS",1=>"MS");
		$ret="<select id='".$i."' name='".$i."' class='required'>";
		$ret.="<option value=''>---Pilih---</option>";
		foreach ($sa as $ks => $vs) {
			$ret.="<option value='".$ks."'>".$vs."</option>";
		}
		$ret.='</select>';
		return $ret;
	}

	function insertBox_export_stabilita_pilot_iacc($f, $i){
		$sa=array(0=>"TMS",1=>"MS");
		$ret="<select id='".$i."' name='".$i."' class='required'>";
		$ret.="<option value=''>---Pilih---</option>";
		foreach ($sa as $ks => $vs) {
			$ret.="<option value='".$ks."'>".$vs."</option>";
		}
		$ret.='</select>';
		return $ret;
	}

	function insertBox_export_stabilita_pilot_iinter($f, $i){
		$sa=array(0=>"TMS",1=>"MS");
		$ret="<select id='".$i."' name='".$i."' class=''>";
		$ret.="<option value='3'>---Pilih---</option>";
		foreach ($sa as $ks => $vs) {
			$ret.="<option value='".$ks."'>".$vs."</option>";
		}
		$ret.='</select>';
		return $ret;
	}

	function insertBox_export_stabilita_pilot_iperlu_sample($f, $i){
		$sa=array(0=>"Tidak",1=>"Ya");
		$ret="<select id='".$i."' name='".$i."' class='required'>";
		//$ret.="<option value=''>---Pilih---</option>";
		foreach ($sa as $ks => $vs) {
			$ret.="<option value='".$ks."'>".$vs."</option>";
		}
		$ret.='</select>';
		$ret.='<script type="text/javascript">';
		$ret.='var sa = $("#export_stabilita_pilot_istatus_pilot").val();';
		$ret.='if(sa != "0"){ $("#'.$i.'").parent().parent().hide() }';
		$ret.='$("#export_stabilita_pilot_istatus_pilot").change(function(){ if($(this).val()=="0"){ $("#'.$i.'").parent().parent().show() }else{ $("#'.$i.'").parent().parent().hide() } });';
		$ret.='</script>';
		return $ret;
	}
	function insertBox_export_stabilita_pilot_iapprove_pd($f, $i){
		return "-";
	}

	function manipulate_insert_button($buttons) {
		unset($buttons['save']);
		$grid='export_stabilita_pilot';
		$data['grid']=$grid;
		$js = $this->load->view('export/js/export_stabilita_pilot_js',$data);
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
		if($postData['istatus_pilot']==1){
			$postData['iperlu_sample']=0;
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
			$data['menuapp']="ERP -> Reformulasi -> Export -> Stabilita Pilot";
			$data['caption']="Diberitahukan telah ada Submit pada Aplikasi Reformulasi Export module Stabilita Pilot, dengan rincian sebagai berikut :";
			$subject = "Reformulasi Export - Stabilita Pilot (".$dform['export_req_refor__vno_export_req_refor'].")";
			$teamad=$this->getnipbytipe("PD");
			$to=implode(";", $teamad['atasan']);
			$cc=implode(";", $teamad['bawahan']);
			$content = $this->load->view('export/mail/reformulasi_main_mail',$data,TRUE);
			$this->sess_message->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);
		}
	}

	/*End Insert Form*/


	/*Update FORM MOdification*/

	function updateBox_export_stabilita_pilot_iexport_refor_formula($f, $i, $v, $row){
		$val=$this->getDetailsForm($row['iexport_stabilita_pilot'],'export_req_refor__vno_export_req_refor');
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
		if($row['isubmit']==0){
			$r .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/reformulasi/browse_export_stabilita_pilot?field=export_stabilita_pilot&modul_id='.$this->input->get('modul_id').'\',\'\')" type="button">&nbsp;</button>';
		}
		if($this->input->get('action')=='view' or $row['isubmit']>0){
			$r='<input type="text" name="'.$i.'_dis" disabled="TRUE" id="'.$i.'_dis" class="input_rows1 required" size="20" value="'.$val.'" />';
		}
		return $r;
	}

	function updateBox_export_stabilita_pilot_vUpd_no($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$r = '<input type="text" name="'.$i.'" disabled="TRUE" id="'.$i.'" class="input_rows1 required" size="20" value="'.$val['vUpd_no'].'" />';
		return $r;
	}
	
	function updateBox_export_stabilita_pilot_vNama_usulan($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$r ='<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'">'.$val['vNama_usulan'].'</textarea>';
		return $r;
	}

	function updateBox_export_stabilita_pilot_cInisiator_export($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$r ='<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'">'.$val['cInisiator_export'].'</textarea>';
		return $r;
	}

	function updateBox_export_stabilita_pilot_iDapartemen_export($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$r = '<input type="text" name="'.$i.'" disabled="TRUE" id="'.$i.'" class="input_rows1 required" size="20" value="'.$val['iDapartemen_export'].'" />';
		return $r;
	}

	function updateBox_export_stabilita_pilot_tAlasan_export($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$r ='<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'">'.$val['tAlasan_export'].'</textarea>';
		return $r;
	}

	function updateBox_export_stabilita_pilot_iTeamPD($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$r = '<input type="text" name="'.$i.'" disabled="TRUE" id="'.$i.'" class="input_rows1 required" size="20" value="'.$this->getTeamByID($val['iTeamPD']).'" />';
		return $r;
	}

	function updateBox_export_stabilita_pilot_dPermintaan_req_export($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$r = '<input type="text" name="'.$i.'" disabled="TRUE" id="'.$i.'" class="input_rows1 required" size="20" value="'.$val['dPermintaan_req_export'].'" />';
		return $r;
	}

	function updateBox_export_stabilita_pilot_cApproval_ats_inisiator($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$r ='<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'">'.$val['cApproval_ats_inisiator'].'</textarea>';
		return $r;
	}

	function updateBox_export_stabilita_pilot_cPicFormulator($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$r ='<textarea disabled="TRUE" name="'.$i.'" id="'.$i.'">'.$val['cPicFormulator'].'</textarea>';
		$data=array();
		$data['id']=$row['iexport_refor_formula'];
		$r.=$this->load->view('export/export_stabilita_pilot_file',$data,TRUE);
		return $r;
	}

	function updateBox_export_stabilita_pilot_vUploadfile($f, $i, $v, $row){
		$val=$this->getdetails($row['iexport_refor_formula']);
		$data['id']=$val['iexport_req_refor'];
		$data['get']=$this->input->get();
		return $this->load->view('export/export_stabilita_pilot_file',$data,TRUE);
	}

	function updateBox_export_stabilita_pilot_lbl($f, $i){
		$r = '<script>
			$("label[for=\''.$i.'\']").css({"border": "1px solid #dddddd", "background": "#548cb6", "border-collapse": "collapse","width":"99%","font-weight":"bold","color":"#ffffff","text-shadow": "0 1px 1px rgba(0, 0, 0, 0.3)","text-transform": "uppercase"});
		</script>';
		return $r;
	}

	function updateBox_export_stabilita_pilot_dstabpilot($f, $i, $v, $row){
		$dis="";
		if($this->input->get('action')=='view' or $row['isubmit']>0){
			$dis='disabled="TRUE"';
		}
		$return = '<input name="'.$i.'" id="'.$i.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" '.$dis.' value="'.$v.'" />';
		$return .=	'<script>
						$("#'.$i.'").datepicker({dateFormat:"yy-mm-dd",changeMonth: true,changeYear: true});
					</script>';
		return $return;
	}

	function updateBox_export_stabilita_pilot_dhasilstabpilot($f, $i, $v, $row){
		$dis="";
		if($this->input->get('action')=='view' or $row['isubmit']>0){
			$dis='disabled="TRUE"';
		}
		$return = '<input name="'.$i.'" id="'.$i.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" '.$dis.' value="'.$v.'" />';
		$return .=	'<script>
						$("#'.$i.'").datepicker({dateFormat:"yy-mm-dd",changeMonth: true,changeYear: true});
					</script>';
		return $return;
	}

	function updateBox_export_stabilita_pilot_vfile($f, $i, $v, $row){
		$data['id']=$row['iexport_stabilita_pilot'];
		$data['get']=$this->input->get();
		$data['isubmit']=$row['isubmit'];
		return $this->load->view('export/export_stabilita_pilot_file_upload',$data,TRUE);
	}

	function updateBox_export_stabilita_pilot_istatus_pilot($f, $i, $v, $row){
		$dis="";
		$ret="";
		$sa=array(0=>"TMS",1=>"MS");
		if($this->input->get('action')=='view' or $row['isubmit']>0){
			$dis='disabled="TRUE"';
			$ret='<input type="text" name="'.$i.'" id="'.$i.'" class="input_rows1 required" value="'.$sa[$v].'" '.$dis.' size="20" />';
		}else{
			$ret="<select id='".$i."' name='".$i."' class='required'>";
			$ret.="<option value=''>---Pilih---</option>";
			foreach ($sa as $ks => $vs) {
				$sel=$ks==$v?"selected":"";
				$ret.="<option value='".$ks."' ".$sel.">".$vs."</option>";
			}
			$ret.='</select>';
		}
		return $ret;
	}

	function updateBox_export_stabilita_pilot_iacc($f, $i, $v, $row){
		$dis="";
		$ret="";
		$sa=array(0=>"TMS",1=>"MS");
		if($this->input->get('action')=='view' or $row['isubmit']>0){
			$dis='disabled="TRUE"';
			$ret='<input type="text" name="'.$i.'" id="'.$i.'" class="input_rows1 required" value="'.$sa[$v].'" '.$dis.' size="20" />';
		}else{
			$ret="<select id='".$i."' name='".$i."' class='required'>";
			$ret.="<option value=''>---Pilih---</option>";
			foreach ($sa as $ks => $vs) {
				$sel=$ks==$v?"selected":"";
				$ret.="<option value='".$ks."' ".$sel.">".$vs."</option>";
			}
			$ret.='</select>';
		}
		return $ret;
	}

	function updateBox_export_stabilita_pilot_ireal($f, $i, $v, $row){
		$dis="";
		$ret="";
		$sa=array(0=>"TMS",1=>"MS");
		if($this->input->get('action')=='view' or $row['isubmit']>0){
			$dis='disabled="TRUE"';
			$ret='<input type="text" name="'.$i.'" id="'.$i.'" class="input_rows1 required" value="'.$sa[$v].'" '.$dis.' size="20" />';
		}else{
			$ret="<select id='".$i."' name='".$i."' class='required'>";
			$ret.="<option value=''>---Pilih---</option>";
			foreach ($sa as $ks => $vs) {
				$sel=$ks==$v?"selected":"";
				$ret.="<option value='".$ks."' ".$sel.">".$vs."</option>";
			}
			$ret.='</select>';
		}
		return $ret;
	}

	function updateBox_export_stabilita_pilot_ihasil($f, $i, $v, $row){
		$dis="";
		$ret="";
		$sa=array(0=>"TMS",1=>"MS");
		if($this->input->get('action')=='view' or $row['isubmit']>0){
			$dis='disabled="TRUE"';
			$ret='<input type="text" name="'.$i.'" id="'.$i.'" class="input_rows1 required" value="'.$sa[$v].'" '.$dis.' size="20" />';
		}else{
			$ret="<select id='".$i."' name='".$i."' class='required'>";
			$ret.="<option value=''>---Pilih---</option>";
			foreach ($sa as $ks => $vs) {
				$sel=$ks==$v?"selected":"";
				$ret.="<option value='".$ks."' ".$sel.">".$vs."</option>";
			}
			$ret.='</select>';
		}
		return $ret;
	}

	function updateBox_export_stabilita_pilot_iinter($f, $i, $v, $row){
		$dis="";
		$ret="";
		$sa=array(3=>"---Pilih---",0=>"TMS",1=>"MS");
		if($this->input->get('action')=='view' or $row['isubmit']>0){
			$dis='disabled="TRUE"';
			$ret='<input type="text" name="'.$i.'" id="'.$i.'" class="input_rows1 required" value="'.$sa[$v].'" '.$dis.' size="20" />';
		}else{
			$ret="<select id='".$i."' name='".$i."'>";
			foreach ($sa as $ks => $vs) {
				$sel=$ks==$v?"selected":"";
				$ret.="<option value='".$ks."' ".$sel.">".$vs."</option>";
			}
			$ret.='</select>';
		}
		return $ret;
	}

	function updateBox_export_stabilita_pilot_iperlu_sample($f, $i, $v, $row){
		$dis="";
		$ret="";
		$sa=array(0=>"Tidak",1=>"Ya");
		if($this->input->get('action')=='view' or $row['isubmit']>0){
			$dis='disabled="TRUE"';
			$ret='<input type="text" name="'.$i.'" id="'.$i.'" class="input_rows1 required" value="'.$sa[$v].'" '.$dis.' size="20" />';
		}else{
			$ret="<select id='".$i."' name='".$i."' class='required'>";
			$ret.="<option value=''>---Pilih---</option>";
			foreach ($sa as $ks => $vs) {
				$sel=$ks==$v?"selected":"";
				$ret.="<option value='".$ks."' ".$sel.">".$vs."</option>";
			}
			$ret.='</select>';
		}
		$ret.='<script type="text/javascript">';
		$ret.='var sa = "'.$row['istatus_pilot'].'";';
		$ret.='if(sa != "0"){ $("#'.$i.'").parent().parent().hide() }';
		$ret.='$("#export_stabilita_pilot_istatus_pilot").change(function(){ if($(this).val()=="0"){ $("#'.$i.'").parent().parent().show() }else{ $("#'.$i.'").parent().parent().hide() } });';
		$ret.='</script>';
		return $ret;
	}

	function updateBox_export_stabilita_pilot_iapprove_pd($f, $i, $v, $row){
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
			$usr=$this->getDetailsEmploye($row['capprove_pd']);
			if(count($usr>=1)){
				$ret.=" By ".$usr['vName']." [".$row['capprove_pd']."] at ".$row['dapprove_pd'];
			}
		}
		return $ret;
	}

	function manipulate_update_button($btn, $row){
		unset($btn['update']);
		$grid='export_stabilita_pilot';
		$data['grid']=$grid;
		$js = $this->load->view('export/js/export_stabilita_pilot_js',$data);
		$update_draft = '<button onclick="javascript:update_draft_'.$grid.'(\''.$grid.'\', \''.base_url().'processor/reformulasi/'.$grid.'?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_'.$grid.'">Update as Draft</button>';
		$update = '<button onclick="javascript:update_submit_'.$grid.'(\''.$grid.'\', \''.base_url().'processor/reformulasi/'.$grid.'?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_'.$grid.'">Update &amp; Submit</button>';
		$approvead = '<button onclick="javascript:load_popup_'.$grid.'(\''.base_url().'processor/reformulasi/'.$grid.'?action=approve&iexport_stabilita_pilot='.$row['iexport_stabilita_pilot'].'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'&company_id='.$this->input->get('company_id').'\',\'\',\'Approve Draft Stabilita Pilot\')" class="ui-button-text icon-save" id="button_approve_'.$grid.'">Approve</button>';
		$btn2='';
		if($this->auth_export->is_manager()){
			$x=$this->auth_export->dept();
			$manager=$x['manager'];
			/*Untuk Manager Andev*/
			if(in_array('PD', $manager)){
				if($row['isubmit']==0){
					$btn2=$update_draft.$update;
				}elseif($row['isubmit']>=1 && $row['iapprove_pd']==0){
					$btn2=$approvead;
				}
			}
		}else{
			$x=$this->auth_export->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){
				$it=$this->getAccessApproveTeam("PD");
				if($it==true){
					if($row['isubmit']==0){
						$btn2=$update_draft.$update;
					}elseif($row['isubmit']>1 && $row['iapprove_pd']==0){
						$btn2=$approvead;
					}
				}else{
					if($row['isubmit']==0){
						$btn2=$update_draft.$update;
					}
				}
			}
		}
		$btn['update'] = $btn2.$js;
		return $btn;
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
		if($postData['istatus_pilot']==1){
			$postData['iperlu_sample']=0;
		} 
		return $postData;
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
			$data['menuapp']="ERP -> Reformulasi -> Export -> Stabilita Pilot";
			$data['caption']="Diberitahukan telah ada Submit pada Aplikasi Reformulasi Export module Stabilita Pilot, dengan rincian sebagai berikut :";
			$subject = "Reformulasi Export - Stabilita Pilot (".$dform['export_req_refor__vno_export_req_refor'].")";
			$teamad=$this->getnipbytipe("PD");
			$to=implode(";", $teamad['atasan']);
			$cc=implode(";", $teamad['bawahan']);
			$content = $this->load->view('export/mail/reformulasi_main_mail',$data,TRUE);
			$this->sess_message->send_message_erp($this->uri->segment_array(),$to, $cc, $subject, $content);
		}
	}

	/*End Update Form*/


	/*Public Output*/
	public function output(){
		$this->index($this->input->get('action'));
	}

	function approve_view() {
		$echo = '<h1>Approve</h1><br />';
		$echo .= '<form id="form_approve_export_stabilita_pilot" action="'.base_url().$this->urlpath.'?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="approveBox_export_stabilita_pilot_iexport_stabilita_pilot" value="'.$this->input->get('iexport_stabilita_pilot').'" />
				<input type="hidden" name="approveBox_export_stabilita_pilot_group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="approveBox_export_stabilita_pilot_modul_id" value="'.$this->input->get('modul_id').'" />
				<input type="hidden" name="approveBox_export_stabilita_pilot_company_id" value="'.$this->input->get('company_id').'" />
				<input type="hidden" name="approveBox_export_stabilita_pilot_foreign_id" value="'.$this->input->get('foreign_id').'" />
				<input type="hidden" name="approveBox_export_stabilita_pilot_iapprove_pd" value="2" />
				<textarea id="approveBox_export_stabilita_pilot_vRemark" name="approveBox_export_stabilita_pilot_vRemark"></textarea>';
		$echo .= '</div>';
		$echo .= '</form>';

		return $echo;
	}

	function approve_process(){
		$post=$this->input->post();
		$dataup=array();
		$dataup['iapprove_pd']=$post['approveBox_export_stabilita_pilot_iapprove_pd'];
		$dataup['tapprove_pd']=$post['approveBox_export_stabilita_pilot_vRemark'];
		$dataup['dapprove_pd']=date("Y-m-d H:i:s");
		$dataup['capprove_pd']=$this->user->gNIP;
		$dataup['cupdate']=$this->user->gNIP;
		$dataup['dupdate']=date("Y-m-d H:i:s");

		$this->dbset->where('iexport_stabilita_pilot',$post['approveBox_export_stabilita_pilot_iexport_stabilita_pilot']);
		if($this->dbset->update('reformulasi.export_stabilita_pilot',$dataup)){

			/*Cek Untuk Permintaan Sample*/

			$sqlpro="select * from reformulasi.export_stabilita_pilot r where r.ldeleted=0 and r.iexport_stabilita_pilot=".$post['approveBox_export_stabilita_pilot_iexport_stabilita_pilot'];
			$dr=$this->dbset->query($sqlpro)->row_array();
			$datasample=array();
			if(count($dr)>=1){
				if($dr['istatus_pilot']==0 && $dr['iperlu_sample']==1){ // Insert Ke Sample Bahan Baku
					$val=$this->getdetails($dr['iexport_refor_formula']);
					$iexport_req_refor=$val['iexport_req_refor'];
					$sqlFor = "SELECT e.cPicFormulator FROM reformulasi.export_req_refor e WHERE 
                            e.iexport_req_refor ='".$val['iexport_req_refor']."' LIMIT 1";
                    $dt = $this->db->query($sqlFor)->row_array();
                    $insD['cRequestor'] = $this->user->gNIP;
                    if(!empty($dt['cPicFormulator'])){
                        $insD['cRequestor'] = $dt['cPicFormulator'];
                    }
                    $insD['iexport_req_refor'] = $val['iexport_req_refor'];
                    $insD['dTgl_request'] = date('Y-m-d H:i:s');
                    $insD['cCreated'] = $this->user->gNIP;
                    $insD['dCreate'] = date('Y-m-d H:i:s'); 
                    $insD['iTujuan_request'] = 7; // Tujuan ke Stabilita Pilot
                    if($this->db->insert('reformulasi.export_request_sample', $insD)){
                        $id2 = $this->db->insert_id();  
                        $nomor2 = "RS".str_pad($id2, 8, "0", STR_PAD_LEFT);
                        $sqlU = "UPDATE reformulasi.export_request_sample SET vRequest_no = '".$nomor2."'
                             WHERE iexport_request_sample='".$id2."' LIMIT 1";
                        $query = $this->db->query( $sqlU ); 
                        $sqlselsample="select * from reformulasi.export_request_sample where iexport_request_sample=".$id2;
                        $datasample=$this->dbset->query($sqlselsample)->row_array();
                    }
				}
				if($dr['istatus_pilot']==0 && $dr['iperlu_sample']==0){// Kembali Ke Trial
					$updatefor['iflag_open']=0;
					$updatefor['iflag_open_app']=1;
					$this->dbset->where('iexport_refor_formula',$dr['iexport_refor_formula']);
					$this->dbset->update('reformulasi.export_refor_formula',$updatefor);
				}
			}

			/*End Sample*/

			$data['message']="Approve Success";
			$data['status']=true;

			$data['group_id']=$post['approveBox_export_stabilita_pilot_group_id'];
			$data['modul_id']=$post['approveBox_export_stabilita_pilot_modul_id'];
			$data['foreign_id']=$post['approveBox_export_stabilita_pilot_foreign_id'];
			$data['company_id']=$post['approveBox_export_stabilita_pilot_company_id'];
			$data['last_id']=$post['approveBox_export_stabilita_pilot_iexport_stabilita_pilot'];

			/*Send Notif*/
			$id=$post['approveBox_export_stabilita_pilot_iexport_stabilita_pilot'];
			$dform = $this->getreqdata($id);
			$vteampd=$this->getdetailteam($dform['iTeamPD']);
			$teampd=isset($vteampd['vteam'])?$vteampd['vteam']:'-';
			$vteamad=$this->getdetailteam($dform['iTeamAndev']);
			$teamad=isset($vteamad['vteam'])?$vteamad['vteam']:'-';

			$data['cdata'] =array();
			$data['capdata'] =array();
			$data['menuapp']='';
			$data['caption']='';
			$subject='';
			$cc='';
			$to='';
			if(count($dr)>=1){
				if($dr['istatus_pilot']==0 && $dr['iperlu_sample']==1){ // Kirim Email Ke Sample
					$data['menuapp']="ERP -> Reformulasi -> Export -> Request Sample";
					$data['caption']="Diberitahukan telah ada Request Sample, dengan rincian sebagai berikut :";
					$subject = "Reformulasi Export - Request Sample (".$dform['export_req_refor__vno_export_req_refor'].")";
					$rrRequestor=isset($datasample['cRequestor'])?$datasample['cRequestor']:"-";
					$arrRequestor=$this->getDetailsEmploye($rrRequestor);
					$cRequestor=$rrRequestor." || ".$arrRequestor['vName'];
					$dTgl_request=isset($datasample['dTgl_request'])?$datasample['dTgl_request']:"-";
					$vRequest_no=isset($datasample['vRequest_no'])?$datasample['vRequest_no']:"-";
					$data['cdata'] = array(
						'vno_export_req_refor'=>$dform['export_req_refor__vno_export_req_refor'],
						'vUpd_no'=>$dform['dossier_upd__vUpd_no'],
						'vNama_usulan'=>$dform['dossier_upd__vNama_usulan'],
						'iTeamPD'=>$teampd,
						'iTeamAndev'=>$teamad,
						'vRequest_no'=>$vRequest_no,
						'cRequestor'=>$cRequestor,
						'dTgl_request'=>$dTgl_request
					);

					$data['capdata']  = array(
						'vno_export_req_refor'=>'No Req Refor',
						'vUpd_no'=>'No UPD',
						'vNama_usulan'=>'Nama Usulan',
						'iTeamPD'=>'Team PD',
						'iTeamAndev'=>'Team Andev',
						'vRequest_no'=>'No Request Sample',
						'cRequestor'=>'Requestor',
						'dTgl_request'=>'Tanggal Request'
					);
					$teamad=$this->getnipbytipe("PD");
					$cc=implode(";", $teamad['atasan']);
					$to=implode(";", $teamad['bawahan']);
				}
				if($dr['istatus_pilot']==0 && $dr['iperlu_sample']==0){ // Kirim Ke Trial
					$data['menuapp']="ERP -> Reformulasi -> Export -> Formula Skala Trial";
					$data['caption']="Diberitahukan telah ada Approval Pada Stabilita Pilot untuk dilakukan penginputan pada module Formula Skala Trial, dengan rincian sebagai berikut :";
					$subject = "Reformulasi Export - Formula Skala Trial (".$dform['export_req_refor__vno_export_req_refor'].")";
					$data['cdata'] = array(
						'vno_export_req_refor'=>$dform['export_req_refor__vno_export_req_refor'],
						'vUpd_no'=>$dform['dossier_upd__vUpd_no'],
						'vNama_usulan'=>$dform['dossier_upd__vNama_usulan'],
						'iTeamPD'=>$teampd,
						'iTeamAndev'=>$teamad );
					$data['capdata']  = array(
						'vno_export_req_refor'=>'No Req Refor',
						'vUpd_no'=>'No UPD',
						'vNama_usulan'=>'Nama Usulan',
						'iTeamPD'=>'Team PD',
						'iTeamAndev'=>'Team Andev' );
					$teamad=$this->getnipbytipe("PD");
					$cc=implode(";", $teamad['atasan']);
					$to=implode(";", $teamad['bawahan']);
				}
				if($dr['istatus_pilot']==1){ // Kirim Untuk Hasil 
					$data['menuapp']="ERP -> Reformulasi -> Export -> Stabilita Pilot";
					$data['caption']="Diberitahukan telah ada Approval Pada Stabilita Pilot untuk dilakukan penginputan pada module Formula Skala Trial, dengan rincian sebagai berikut :";
					$subject = "Reformulasi Export - Stabilita Pilot (".$dform['export_req_refor__vno_export_req_refor'].")";
					$data['cdata'] = array(
						'vno_export_req_refor'=>$dform['export_req_refor__vno_export_req_refor'],
						'vUpd_no'=>$dform['dossier_upd__vUpd_no'],
						'vNama_usulan'=>$dform['dossier_upd__vNama_usulan'],
						'iTeamPD'=>$teampd,
						'iTeamAndev'=>$teamad );
					$data['capdata']  = array(
						'vno_export_req_refor'=>'No Req Refor',
						'vUpd_no'=>'No UPD',
						'vNama_usulan'=>'Nama Usulan',
						'iTeamPD'=>'Team PD',
						'iTeamAndev'=>'Team Andev' );
					$teamad=$this->getnipbytipe("PD");
					$cc=implode(";", $teamad['atasan']);
					$to=implode(";", $teamad['bawahan']);
				}
			}else{
				$teamad=$this->getnipbytipe("PD");
			}
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
				where (em.vName like "%'.$term.'%" or em.cNip like "%'.$term.'%") and te.vtipe in ("AD","PD") AND te.iTipe=2 AND it.ldeleted=0 group by em.cNip order by em.vname ASC';
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

    function getdetails($id){
		$post=$this->input->post();
		$sql="select r.vno_export_req_refor,u.vUpd_no,u.vNama_usulan,r.cInisiator_export,r.iDapartemen_export,r.tAlasan_export,r.iTeamPD,r.dPermintaan_req_export,r.cApproval_ats_inisiator,r.cPicFormulator,r.iexport_req_refor 
			from reformulasi.export_refor_formula f
			join reformulasi.export_req_refor r on r.iexport_req_refor=f.iexport_req_refor
			join dossier.dossier_upd u on r.idossier_upd_id=u.idossier_upd_id
			where f.lDeleted=0 and r.lDeleted=0 and u.lDeleted=0 and f.iexport_refor_formula=".$id;
		$row=$this->db->query($sql)->row_array();
		$cInisiator_export=$this->getDetailsEmploye($row['cInisiator_export']);
		$row['cInisiator_export']="[".$row['cInisiator_export']."] ".$cInisiator_export['vName'];
		$depart=$this->getDetailsDepart($row['iDapartemen_export']);
		$row['iDapartemen_export']=$depart['vDescription'];
		$cApproval_ats_inisiator=$this->getDetailsEmploye($row['cApproval_ats_inisiator']);
		$row['cApproval_ats_inisiator']="[".$row['cApproval_ats_inisiator']."] ".$cApproval_ats_inisiator['vName'];
		$cPicFormulator=$this->getDetailsEmploye($row['cPicFormulator']);
		$row['cPicFormulator']="[".$row['cPicFormulator']."] ".$cPicFormulator['vName'];
		return $row;
	}

    function getDetailsForm($id=0,$field='null'){
    	$sql="SELECT export_req_refor.vno_export_req_refor AS export_req_refor__vno_export_req_refor, dossier_upd.vNama_usulan AS dossier_upd__vNama_usulan, export_req_refor.iTeamPD as export_req_refor__iTeamPD, reformulasi.export_refor_formula.*, export_stabilita_pilot.iexport_stabilita_pilot
			FROM (reformulasi.export_refor_formula)
			INNER JOIN reformulasi.export_req_refor ON export_req_refor.iexport_req_refor=reformulasi.export_refor_formula.iexport_req_refor
			INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id=reformulasi.export_req_refor.idossier_upd_id
			INNER JOIN reformulasi.export_stabilita_pilot ON export_stabilita_pilot.iexport_refor_formula=reformulasi.export_refor_formula.iexport_refor_formula
			WHERE export_stabilita_pilot.iexport_stabilita_pilot=".$id;
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

    function getDetailsDepart($id=0){
    	$sql="select * from hrd.msdepartement em where em.iDeptID='".$id."'";
    	$qsql=$this->db->query($sql);
		$ret=array();
		if($qsql->num_rows()>=1){
			$ret=$qsql->row_array();
		}
		return $ret;
    }

    function getdetailsprev(){
    	$post=$this->input->post();
		$sql_data="select * from reformulasi.export_req_refor_file p where p.lDeleted=0 and p.iexport_req_refor=".$post['id'];
		$q=$this->dbset->query($sql_data);
		$rsel=array('vFilename','tKeterangan','update');
		$data = new StdClass;
		$data->records=$q->num_rows();
		$i=0;
		foreach ($q->result() as $k) {
			$data->rows[$i]['id']=$k->iexport_req_refor_file;
			$z=0;
			foreach ($rsel as $dsel => $vsel) {
				if($vsel=="update"){
					$ini=$i+1;
					$btn1="<input type='hidden' class='num_rows_tb_details_export_stabilita_pilot' value='".$ini."' /><button id='ihapus_tb_details_harga_database' class='ui-button-text icon_hapus' style='width:75px' onclick='javascript:hapus_row_tb_details_export_stabilita_pilot(".$ini.")' type='button'>Hapus</button><input type='hidden' name='iexport_stabilita_pilot_file[]' value='".$k->iexport_req_refor_file."' />";
					$value=$k->tKeterangan;
					$id=$k->iexport_req_refor_file;
					$caption='No File';
					$btn2="";
					if($value != '') {
						if (file_exists('./'.$this->filepathreq.'/'.$id.'/'.$value)) {
							$caption='Download';
							$link = base_url().'processor/reformulasi/export/produksi/pilot?action=download&id='.$id.'&file='.$value;
							$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
							$btn2="<button id='ihapus_tb_details_harga_database' class='ui-button-text icon_hapus' style='width:100px' onclick='javascript:hapus_row_tb_details_export_stabilita_pilot(".$ini.")' type='button'>".$caption."</button>";
						}
						else {
							$btn2 = ' [No File!]';
						}
					}
					else {
						$btn2 = ' [No File!]';
					}

					
					$dataar[$dsel]=$btn2;
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

	function getdetailsprevupload(){
    	$post=$this->input->post();
    	$get=$this->input->get();
		$sql_data="select * from reformulasi.export_stabilita_pilot_file p where p.ldeleted=0 and p.iexport_stabilita_pilot=".$post['id'];
		$q=$this->dbset->query($sql_data);
		$rsel=array('vfilename','tketerangan','update');
		$data = new StdClass;
		$data->records=$q->num_rows();
		$i=0;
		foreach ($q->result() as $k) {
			$data->rows[$i]['id']=$k->iexport_stabilita_pilot_file;
			$z=0;
			foreach ($rsel as $dsel => $vsel) {
				if($vsel=="update"){
					$ini=$i+1;
					$btn1="<input type='hidden' class='num_rows_tb_details_export_stabilita_pilot_file' value='".$ini."' />";
					if($get['isubmit']==0){
					$btn1=$btn1."<button id='ihapus_tb_details_".$this->gridname."' class='ui-button-text icon_hapus' style='width:75px' onclick='javascript:hapus_row_tb_details_".$this->gridname."_file(".$ini.")' type='button'>Hapus</button><input type='hidden' name='iexport_stabilita_pilot_file[]' value='".$k->iexport_stabilita_pilot_file."' />";
					}
					$value=$k->vfilename;
					$id=$k->iexport_stabilita_pilot;
					$caption='No File';
					$btn2="";
					if($value != '') {
						if (file_exists('./'.$this->filepath.'/'.$id.'/'.$value)) {
							$caption='Download';
							$link = base_url().$this->urlpath.'?action=download&id='.$id.'&file='.$value;
							$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
							$btn2="<button id='ihapus_tb_details_".$this->gridname."' class='ui-button-text icon_hapus' style='width:100px' onclick='javascript:hapus_row_tb_details_".$this->gridname."_file(".$ini.")' type='button'>".$caption."</button>";
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
    	$sql="SELECT export_req_refor.iTeamPD,export_req_refor.iTeamAndev,export_req_refor.vno_export_req_refor AS export_req_refor__vno_export_req_refor, dossier_upd.vNama_usulan AS dossier_upd__vNama_usulan,dossier_upd.vUpd_no AS dossier_upd__vUpd_no, reformulasi.export_refor_formula.*, export_stabilita_pilot.iexport_stabilita_pilot
			FROM (reformulasi.export_refor_formula)
			INNER JOIN reformulasi.export_req_refor ON export_req_refor.iexport_req_refor=reformulasi.export_refor_formula.iexport_req_refor
			INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id=reformulasi.export_req_refor.idossier_upd_id
			INNER JOIN reformulasi.export_stabilita_pilot ON export_stabilita_pilot.iexport_refor_formula=reformulasi.export_refor_formula.iexport_refor_formula
			WHERE export_stabilita_pilot.iexport_stabilita_pilot=".$id;
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

    function getTeamByID($id=0){
        $sql='select * from reformulasi.reformulasi_team t where t.ldeleted=0 and t.ireformulasi_team='.$id;
        $qr=$this->db->query($sql);
        $ret="-";
        if($qr->num_rows()>=1){
            $row=$qr->row_array();
            $ret=isset($row['vteam'])?$row['vteam']:'-';
        }
        return $ret;
    }

}