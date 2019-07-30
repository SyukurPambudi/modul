<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class v3_cek_dokumen_reg extends MX_Controller {
    function __construct() {
	parent::__construct();
	
		$this->load->library('auth');
		$this->user = $this->auth->user();
		$this->load->model('v3_m_reg');
		$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('lib_plc');
		$this->modul_id = $this->input->get('modul_id');
		$this->iModul_id = $this->lib_plc->getIModulID($this->input->get('modul_id'));
		$this->db = $this->load->database('hrd',false, true);

		$this->team = $this->lib_plc->hasTeam($this->user->gNIP);
		$this->teamID = $this->lib_plc->hasTeamID($this->user->gNIP);
		$this->isAdmin=$this->lib_plc->isAdmin($this->user->gNIP);

		$this->title = 'Cek Dokumen Registrasi';
		$this->url = 'v3_cek_dokumen_reg';
		$this->urlpath = 'plc/'.str_replace("_","/", $this->url);

    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;

		$grid->setTitle('Cek Dokumen Registrasi');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('v3_cek_dokumen_reg');
		$grid->addList('vupb_nomor','vupb_nama','vgenerik','iconfirm_registrasi');
		$grid->setSortBy('vupb_nomor');
		$grid->setSortOrder('ASC');
		$grid->setSearch('vupb_nomor','vupb_nama');
		$grid->addFields("details_log");
		$grid->addFields('iupb_id','vupb_nama','vgenerik','iNew_formula','vNew_formula');
		$grid->addFields("fileupload");
		$grid->setRequired('iupb_id','plc2_upb.vupb_nomor');
	
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('plc2_upb.vupb_nomor', 'No. UPB');
		$grid->setLabel('vgenerik', 'Nama Generik');

		$grid->setLabel('iNew_formula', 'Formula Baru ?');
		$grid->setLabel('vNew_formula', 'No Formula Baru ');

		$grid->setWidth('vupb_nomor', '73');
		$grid->setLabel('iupb_id', 'UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
		$grid->setWidth('vupb_nama', '189');

		$grid->setLabel('iconfirm_registrasi', 'Approval Busdev Manager');

		$grid->setLabel('form_iconfirm_registrasi', 'Approval Busdev Manager');
		$grid->setLabel('form_iconfirm_registrasi_qa', 'Approval QA Manager');
		$grid->setLabel('form_iconfirm_registrasi_pd', 'Approval PD Manager');


		$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
		$grid->setQuery('plc2.plc2_upb.iKill', 0);
		$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
		$grid->setQuery('plc2_upb.ihold', 0);

		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('BD', $manager)){
				$type='BD';
				$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth->my_teams().')', null);
				$grid->setQuery('(CASE WHEN plc2_upb.ineed_prareg=1 then
						plc2_upb.iprareg_ulang_prareg=0 and plc2_upb.iconfirm_dok>0 AND plc2_upb.iconfirm_dok_pd>0 AND plc2_upb.iconfirm_dok_qa>0 and plc2_upb.iappbd_hpr=2
					else
						plc2_upb.ldeleted=0
					END
				)', null);
			}
			elseif(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);
				$grid->setQuery('(CASE WHEN plc2_upb.ineed_prareg=1 then
						plc2_upb.iconfirm_dok_pd>0
					else
						plc2_upb.ldeleted=0
					END
				)', null);
			}
			elseif(in_array('QA', $manager)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth->my_teams().')', null);
				$grid->setQuery('(CASE WHEN plc2_upb.ineed_prareg=1 then
						plc2_upb.iconfirm_dok_pd>0 AND plc2_upb.iconfirm_dok_qa>0
					else
						plc2_upb.ldeleted=0
					END
				)', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('BD', $team)){
					$type='BD';
					$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth->my_teams().')', null);
					$grid->setQuery('(CASE WHEN plc2_upb.ineed_prareg=1 then
					plc2_upb.iprareg_ulang_prareg=0 and plc2_upb.iconfirm_dok>0 AND plc2_upb.iconfirm_dok_pd>0 AND plc2_upb.iconfirm_dok_qa>0 and plc2_upb.iappbd_hpr=2
					else
						plc2_upb.ldeleted=0
					END
				)', null);
				}
				elseif(in_array('PD', $team)){
					$type='PD';
					$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth->my_teams().')', null);
					$grid->setQuery('(CASE WHEN plc2_upb.ineed_prareg=1 then
						plc2_upb.iconfirm_dok_pd>0
					else
						plc2_upb.ldeleted=0
					END
				)', null);
				}
				elseif(in_array('QA', $team)){
					$type='QA';
					$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth->my_teams().')', null);
					$grid->setQuery('(CASE WHEN plc2_upb.ineed_prareg=1 then
						plc2_upb.iconfirm_dok_pd>0 AND plc2_upb.iconfirm_dok_qa>0
					else
						plc2_upb.ldeleted=0
					END
				)', null);
				}
				else{$type='';}
			}
		}

		$grid->setFormUpload(TRUE);
		$grid->setRequired('iupb_id');

		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				echo $grid->saved_form();
				break;
			case 'download':
				$this->v3_m_reg->download($this->input->get('file'));
				break;
			case 'delete':
				echo $grid->delete_row();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'cekReviseQA':
				$filter=array('de.ikategori_id=4 and de.ijenisdok=2 and de.jenisplc=1');
				
				$row1=$this->v3_m_reg->getDetailFiles($filter)->result_array();
				$row=array();
				$nilaiVal=array();
				foreach ($row1 as $kv => $vvvv) {
					$row[]=$vvvv['filename'];
					$filejenis=$vvvv['filename'];
					foreach($_POST as $key=>$value) {
						if($key == 'v3_cek_dokumen_reg_'.$filejenis.'_istatus'){
							foreach($value as $y=>$u) {
								if($y!=0){
									if($u[0]==0){
										$nilaiVal[$filejenis]["nilai"][]=1;
										$nilaiVal[$filejenis]["name"][]=$vvvv["labelform"];
									}
								}else{
									if($u==0){
										$nilaiVal[$filejenis]["nilai"][]=1;
										$nilaiVal[$filejenis]["name"][]=$vvvv["labelform"];
									}
								}
							}
						}
					}
	
				}
				$status=TRUE;
				$message="";
				if(count($nilaiVal)>0){
					$status=FALSE;
					$message.="<ul style='margin-left:30px;margin-top:10px;'>";
					foreach ($nilaiVal as $filejenis =>$nilai){
						$message.="<li>".$nilai["name"][0]." : ".count($nilai["nilai"])." File</li>";
					}
					$message.="</ul>";

				}
				$data["status"]=$status;
				$data["message"]=$message;
				echo json_encode($data);
				exit();

				break;
			case 'cekReviseBD':
				$filter=array('de.ikategori_id=4 and de.ijenisdok=2 and de.jenisplc=1');
				
				$row1=$this->v3_m_reg->getDetailFiles($filter)->result_array();
				$row=array();
				$nilaiVal=array();
				foreach ($row1 as $kv => $vvvv) {
					$row[]=$vvvv['filename'];
					$filejenis=$vvvv['filename'];
					foreach($_POST as $key=>$value) {
						if($key == 'v3_cek_dokumen_reg_'.$filejenis.'_iconfirm_reg'){
							foreach($value as $y=>$u) {
								if($y!=0){
									if($u[0]==0 or $u[0]==3){
										$nilaiVal[$filejenis]["nilai"][]=1;
										$nilaiVal[$filejenis]["name"][]=$vvvv["labelform"];
									}
								}else{
									if($u==0 or $u==3){
										$nilaiVal[$filejenis]["nilai"][]=1;
										$nilaiVal[$filejenis]["name"][]=$vvvv["labelform"];
									}
								}
							}
						}
					}
	
				}
				$status=TRUE;
				$message="";
				if(count($nilaiVal)>0){
					$status=FALSE;
					$message.="<ul style='margin-left:30px;margin-top:10px;'>";
					foreach ($nilaiVal as $filejenis =>$nilai){
						$message.="<li>".$nilai["name"][0]." : ".count($nilai["nilai"])." File</li>";
					}
					$message.="</ul>";

				}
				$data["status"]=$status;
				$data["message"]=$message;
				echo json_encode($data);
				exit();

				break;
			case 'cekDoneLast':
				$post=$this->input->post();
				$filter=array('de.ikategori_id=4 and de.ijenisdok=2 and de.jenisplc=1');
				$row=$this->v3_m_reg->getDetailFiles($filter)->result_array();
				$icount=0;
				foreach ($row as $krow => $vrow) {
					$ipk=$this->v3_m_reg->getAnotherUPB($vrow['fieldheader'],$post['v3_cek_dokumen_reg_iupb_id']);
					$iM_modul_fileds=$vrow['iM_modul_fileds'];
					$this->db_plc0->select("*")
								->from("plc2.group_file_upload")
								->where("iM_modul_fileds",$iM_modul_fileds)
								->where("idHeader_File",$ipk)
								->where("iDeleted",0)
								->where("iDone",0);
					$getFile=$this->db_plc0->get();
					$rowDet=$getFile->num_rows();
					if($rowDet>0){
						$icount++;
					}
				}
				$status=false;
				if($icount==1){
					$status=true;
				}
				$data["status"]=$status;
				echo json_encode($data);
				exit();

				break;
			case 'updateproses':
				$post=$this->input->post();
				$get=$this->input->get();
				$isUpload = $this->input->get('isUpload');
				$lastId=$this->input->get('lastId');
				$iupb_id=$post['v3_cek_dokumen_reg_iupb_id'];
				$postData=$this->input->post();
				$postData['iupb_id']=$iupb_id;
				/*Cek Team*/
				$type='';
				if($this->auth->is_manager()){
					$x=$this->auth->dept();
					$manager=$x['manager'];
					if(in_array('BD', $manager)){
						$type='BD';
					}elseif(in_array('PD', $manager)){
						$type='PD';
					}elseif(in_array('QA', $manager)){
						$type='QA';
					}elseif(in_array('PAC', $manager)){
						$type='PAC';
					}
					else{$type='';}
				}
				else{
					$x=$this->auth->dept();
					if(isset($x['team'])){
						$team=$x['team'];
						if(in_array('BD', $team)){
							$type='BD';
						}elseif(in_array('PD', $team)){
							$type='PD';
						}elseif(in_array('QA', $team)){
							$type='QA';
						}elseif(in_array('PAC', $team)){
							$type='PAC';
						}
						else{$type='';}
					}
				}
				if($postData['isdraft']==true){
					if($type=="BD"){
						$postData['isubmitbusdev']=0;
					}elseif($type=="QA"){
						$postData['isubmitqa']=0;
					}
				}else{
					if($type=="BD"){
						$postData['isubmitbusdev']=1;
					}elseif($type=="QA"){
						$postData['isubmitqa']=1;
					}
				}

				$returndarta=array();

				$dupb=$this->v3_m_reg->getUPBDetails($iupb_id);
				$filter=array('de.ikategori_id=4 and de.ijenisdok=2 and de.jenisplc=1');
				$row1=$this->v3_m_reg->getDetailFiles($filter)->result_array();
				$row=array();
				foreach ($row1 as $kv => $vvvv) {
					$row[]=$vvvv['filename'];
				}
				foreach ($row as $kfileup => $fieldfileup) {
					$returndarta[$fieldfileup]=$this->v3_m_reg->updateBeforeUpload($fieldfileup,$type);
				}
				/*If Upload*/
				/*Who Am I*/
				$kulo=$this->v3_m_reg->getEmployee($this->user->gNIP);
				if($isUpload){

				}else{
					if($type=="QA"){
						if($postData['isubmitqa']==1){
							$isPDReject=0;
							$isPACReject=0;
							$filter=array('de.ikategori_id=4 and de.ijenisdok=2 and de.jenisplc=1');
							$row=$this->v3_m_reg->getDetailFiles($filter)->result_array();
							foreach ($row as $krow => $vrow) {
								if($vrow["isPD"]==1){ 
									$ipk=$this->v3_m_reg->getAnotherUPB($vrow['fieldheader'],$post['v3_cek_dokumen_reg_iupb_id'],1);
									$iM_modul_fileds=$vrow['iM_modul_fileds'];
									$this->db_plc0->select("*")
												->from("plc2.group_file_upload")
												->where("iM_modul_fileds",$iM_modul_fileds)
												->where("idHeader_File",$ipk)
												->where("iDeleted",0)
												->where("istatus",0);
									$getFile=$this->db_plc0->get();
									$rowDet=$getFile->result_array();
									foreach ($rowDet as $krowDet => $vrowDet){
										$isPDReject++;
									}
								}
								if($vrow["isPackdev"]==1){
									$ipk=$this->v3_m_reg->getAnotherUPB($vrow['fieldheader'],$post['v3_cek_dokumen_reg_iupb_id'],1);
									$iM_modul_fileds=$vrow['iM_modul_fileds'];
									$this->db_plc0->select("*")
												->from("plc2.group_file_upload")
												->where("iM_modul_fileds",$iM_modul_fileds)
												->where("idHeader_File",$ipk)
												->where("iDeleted",0)
												->where("istatus",0);
									$getFile=$this->db_plc0->get();
									$rowDet=$getFile->result_array();
									foreach ($rowDet as $krowDet => $vrowDet){
										$isPACReject++;
									}
								}
							}
							/* Apabila PD Reject */
							if($isPDReject!=0){
                                $activities = $this->lib_plc->get_current_module_activities($this->modul_id,'iupb_id');
                                $getLastStatusApprove = $this->lib_plc->getLastStatusApprove($this->modul_id,'iupb_id');
                                $iM_modul_activity=0;
                                $iM_activity=0;
                                foreach ($activities as $act) {
                                    $iM_modul_activity=$act['iM_modul_activity'];
                                    $iM_activity=$act['iM_activity'];
                                }
                                $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();
                                $iupppp[]=$iupb_id;
                                $this->lib_plc->InsertActivityModule($iupppp,$this->modul_id,$iupb_id,$activity['iM_activity'],$activity['iSort'],'Reject QA',1);
                                $this->db_plc0->select("*")
                                                ->from("plc3.m_modul_log_activity")
                                                ->where('iKey_id',$iupb_id)
                                                ->where('iM_activity',$activity['iM_activity'])
                                                ->where('idprivi_modules',$this->modul_id)
                                                ->where('iApprove',1)
                                                ->where('lDeleted',0);
                                $row=$this->db_plc0->get()->row_array();
                                if(isset($row['iM_modul_log_activity'])){/* Update Deleted=1 Untuk Yang baru di Insert */
                                    $dataupdate['lDeleted']=0;
                                    $this->db_plc0->where('iM_modul_log_activity',$row['iM_modul_log_activity']);
                                    $this->db_plc0->update("plc3.m_modul_log_activity",$dataupdate);
                                }
								$sqlupdateReject='select mo.vNama_modul,ac.vDept_assigned,lo.* from plc3.m_modul_log_activity lo
									join plc3.m_modul mo on mo.idprivi_modules=lo.idprivi_modules
									join plc3.m_modul_activity ac on ac.iSort=lo.iSort and ac.iM_modul=mo.iM_modul and ac.iM_activity=lo.iM_activity
									where lo.lDeleted=0 and mo.lDeleted=0 and ac.lDeleted=0
									and ac.vDept_assigned="PD" AND mo.idprivi_modules='.$this->modul_id;
								$datarow=$this->db_plc0->query($sqlupdateReject)->result_array();
								foreach ($datarow as $krow => $vrow) {
									$this->db_plc0->where("iM_modul_log_activity",$vrow['iM_modul_log_activity']);
									$this->db_plc0->update('plc3.m_modul_log_activity',array('lDeleted'=>1));
								}
								/* Update Untuk plc2_upb */
								$iapprove ='iconfirm_registrasi_pd';
								$this->db_plc0->where('iupb_id', $iupb_id);
								$this->db_plc0->update('plc2.plc2_upb', array($iapprove=>0));

							}

						}
					}
					if($type=="BD"){
						if($postData['isubmitbusdev']==1){
							$isPDReject=0;
							$filter=array('de.ikategori_id=4 and de.ijenisdok=2 and de.jenisplc=1');
							$row=$this->v3_m_reg->getDetailFiles($filter)->result_array();
							foreach ($row as $krow => $vrow) {
								$ipk=$this->v3_m_reg->getAnotherUPB($vrow['fieldheader'],$post['v3_cek_dokumen_reg_iupb_id'],1);
								$iM_modul_fileds=$vrow['iM_modul_fileds'];
								$this->db_plc0->select("*")
											->from("plc2.group_file_upload")
											->where("iM_modul_fileds",$iM_modul_fileds)
											->where("idHeader_File",$ipk)
											->where("iDeleted",0)
											->where_in("iconfirm_busdev",array(0,3));
								$getFile=$this->db_plc0->get();
								$rowDet=$getFile->result_array();
								foreach ($rowDet as $krowDet => $vrowDet){
									$isPDReject++;
								}
							}
							
							/* Apabila PD Reject */
							if($isPDReject!=0){
                                $activities = $this->lib_plc->get_current_module_activities($this->modul_id,'iupb_id');
                                $getLastStatusApprove = $this->lib_plc->getLastStatusApprove($this->modul_id,'iupb_id');
                                $iM_modul_activity=0;
                                $iM_activity=0;
                                foreach ($activities as $act) {
                                    $iM_modul_activity=$act['iM_modul_activity'];
                                    $iM_activity=$act['iM_activity'];
                                }
                                $activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();
                                $iupppp[]=$iupb_id;
                                $this->lib_plc->InsertActivityModule($iupppp,$this->modul_id,$iupb_id,$activity['iM_activity'],$activity['iSort'],'Reject BD',1);
                                $this->db_plc0->select("*")
                                                ->from("plc3.m_modul_log_activity")
                                                ->where('iKey_id',$iupb_id)
                                                ->where('iM_activity',$activity['iM_activity'])
                                                ->where('idprivi_modules',$this->modul_id)
                                                ->where('iApprove',1)
                                                ->where('lDeleted',0);
                                $row=$this->db_plc0->get()->row_array();
                                if(isset($row['iM_modul_log_activity'])){/* Update Deleted=1 Untuk Yang baru di Insert */
                                    $dataupdate['lDeleted']=0;
                                    $this->db_plc0->where('iM_modul_log_activity',$row['iM_modul_log_activity']);
                                    $this->db_plc0->update("plc3.m_modul_log_activity",$dataupdate);
                                }
								$sqlupdateReject='select mo.vNama_modul,ac.vDept_assigned,lo.* from plc3.m_modul_log_activity lo
									join plc3.m_modul mo on mo.idprivi_modules=lo.idprivi_modules
									join plc3.m_modul_activity ac on ac.iSort=lo.iSort and ac.iM_modul=mo.iM_modul and ac.iM_activity=lo.iM_activity
									where lo.lDeleted=0 and mo.lDeleted=0 and ac.lDeleted=0
									and ac.vDept_assigned="QA" AND mo.idprivi_modules='.$this->modul_id;
								$datarow=$this->db_plc0->query($sqlupdateReject)->result_array();
								foreach ($datarow as $krow => $vrow) {
									$this->db_plc0->where("iM_modul_log_activity",$vrow['iM_modul_log_activity']);
									$this->db_plc0->update('plc3.m_modul_log_activity',array('lDeleted'=>1));
								}
								/* Update Untuk plc2_upb */
								$iapprove ='iconfirm_registrasi_qa';
								$this->db_plc0->where('iupb_id', $iupb_id);
								$this->db_plc0->update('plc2.plc2_upb', array($iapprove=>0));

							}

						}
					}
				}
				echo $grid->updated_form();
				break;
			case 'uploadFile':
				$post=$this->input->post();
				$get=$this->input->get();
				$isUpload = $this->input->get('isUpload');
				$lastId=$this->input->get('lastId');
				$iupb_id=$post['v3_cek_dokumen_reg_iupb_id'];
				$postData=$this->input->post();
				$postData['iupb_id']=$iupb_id;
				if($postData['isdraft']==true){
					$postData['isubmitbusdev']=0;
				}else{$postData['isubmitbusdev']=1;}
				/*Cek Team*/
				$type='';
				if($this->auth->is_manager()){
					$x=$this->auth->dept();
					$manager=$x['manager'];
					if(in_array('BD', $manager)){
						$type='BD';
					}elseif(in_array('PD', $manager)){
						$type='PD';
					}elseif(in_array('QA', $manager)){
						$type='QA';
					}elseif(in_array('PAC', $manager)){
						$type='PAC';
					}
					else{$type='';}
				}else{
					$x=$this->auth->dept();
					if(isset($x['team'])){
						$team=$x['team'];
						if(in_array('BD', $team)){
							$type='BD';
						}elseif(in_array('PD', $team)){
							$type='PD';
						}elseif(in_array('QA', $team)){
							$type='QA';
						}elseif(in_array('PAC', $team)){
							$type='PAC';
						}
						else{$type='';}
					}
				}

				$returndarta=array();

				$dupb=$this->v3_m_reg->getUPBDetails($iupb_id);
				$filter=array('de.ikategori_id=4 and de.ijenisdok=2 and de.jenisplc=1');
				$row1=$this->v3_m_reg->getDetailFiles($filter)->result_array();
				$row=array();
				foreach ($row1 as $kv => $vvvv) {
					$row[]=$vvvv['filename'];
				}
				foreach ($row as $kfileup => $fieldfileup) {
					$returndarta[$fieldfileup]=$this->v3_m_reg->updateBeforeUpload($fieldfileup,$type);
				}
				/*If Upload*/
				/*Who Am I*/
				$kulo=$this->v3_m_reg->getEmployee($this->user->gNIP);

				foreach ($row as $kfileup => $fieldfileup) {
					$this->v3_m_reg->updateUploadFile($fieldfileup,$type,$returndarta,$iupb_id);
				}

				/*End Uplad*/
				
				$r['message']="Data Berhasil Disimpan!";
				$r['status'] = TRUE;
				$r['last_id'] = $post['v3_cek_dokumen_reg_iupb_id'];				
				echo json_encode($r);
				exit();
			break;
			case 'confirmpd':
				$post=$this->input->post();
				$get=$this->input->get();
				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$iapprove ='iconfirm_registrasi_pd';$vapprove ='cconfirm_registrasi_pd';$tapprove ='dconfirm_registrasi_pd';
				$this->db_plc0->where('iupb_id', $post['iupb_id']);
				$this->db_plc0->update('plc2.plc2_upb', array($iapprove=>2,$vapprove=>$nip,$tapprove=>$skg));
				$iM_modul_activity=$get['iM_modul_activity'];
				$activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();

				$modul_id=$get['modul_id'];
				$iupb_id[]=$post['iupb_id'];
				$pk=$post['iupb_id'];

				$this->lib_plc->InsertActivityModule($iupb_id,$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],'Approval PD',2);

				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Approved Success!';
				echo json_encode($r);
				exit();
				break;
			case 'confirmbd':
				$post=$this->input->post();
				$get=$this->input->get();
				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$iapprove ='iconfirm_registrasi';$vapprove ='cconfirm_registrasi';$tapprove ='dconfirm_registrasi';
				$this->db_plc0->where('iupb_id', $post['iupb_id']);
				$this->db_plc0->update('plc2.plc2_upb', array($iapprove=>2,$vapprove=>$nip,$tapprove=>$skg));
				$iM_modul_activity=$get['iM_modul_activity'];
				$activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();

				$modul_id=$get['modul_id'];
				$iupb_id[]=$post['iupb_id'];
				$pk=$post['iupb_id'];

				$this->lib_plc->InsertActivityModule($iupb_id,$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],'Approval BD',2);

				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Approved Success!';
				echo json_encode($r);
				exit();
				break;
			
			case 'confirmqa':
				$post=$this->input->post();
				$get=$this->input->get();
				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$iapprove ='iconfirm_registrasi_qa';$vapprove ='cnip_confirm_registrasi_qa';$tapprove ='tconfirm_registrasi_qa';
				$this->db_plc0->where('iupb_id', $post['iupb_id']);
				$this->db_plc0->update('plc2.plc2_upb', array($iapprove=>2,$vapprove=>$nip,$tapprove=>$skg));
				/*Send Email to QA*/
				$iM_modul_activity=$get['iM_modul_activity'];
				$activity = $this->db->get_where('plc3.m_modul_activity', array('iM_modul_activity'=>$iM_modul_activity, 'lDeleted'=>0))->row_array();

				$modul_id=$get['modul_id'];
				$iupb_id[]=$post['iupb_id'];
				$pk=$post['iupb_id'];

				$this->lib_plc->InsertActivityModule($iupb_id,$modul_id,$pk,$activity['iM_activity'],$activity['iSort'],'Approval QA',2);

				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Approved Success!';
				echo json_encode($r);
				exit();
				break;

			case 'confirmpac':
				$post=$this->input->post();
				$get=$this->input->get();
				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$iapprove ='iconfirm_registrasi_pac';$vapprove ='cconfirm_registrasi_pac';$tapprove ='dconfirm_registrasi_pac';
				$this->db_plc0->where('iupb_id', $post['iupb_id']);
				$this->db_plc0->update('plc2.plc2_upb', array($iapprove=>2,$vapprove=>$nip,$tapprove=>$skg));

				$this->v3_m_reg->insert_history_approve($post['iupb_id'],"REGISTRASIOTC","PAC",2,$nip,$get);

				/*Send Email to QA*/
				$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
                        from plc2.plc2_upb u where u.iupb_id='".$post['iupb_id']."'";
		        $rupb = $this->db_plc0->query($qupb)->row_array();

		        $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id,
		                (select te.iteam_id from plc2.plc2_upb_team te where te.cDeptId='PR') as iteampr_id 
		                from plc2.plc2_upb u 
		                where u.iupb_id='".$post['iupb_id']."'";
		        $rsql = $this->db_plc0->query($qsql)->row_array();

		        $pd = $rsql['iteampd_id'];
		        $bd = $rsql['iteambusdev_id'];
		        $qa = $rsql['iteamqa_id'];
		        $qc = $rsql['iteamqc_id'];
		        $pr = $rsql['iteampr_id'];
		        
		        $team = $pd. ','.$qa. ','.$bd.',' .$qc ;
		        
		        $toEmail2='';
		        $toEmail = $this->lib_utilitas->get_email_team( $qa );
		        $toEmail2 = $this->lib_utilitas->get_email_leader( $qa );                        

		        $arrEmail = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );

		        $to = $cc = '';
		        if(is_array($arrEmail)) {
		                $count = count($arrEmail);
		                $to = $arrEmail[0];
		                for($i=1;$i<$count;$i++) {
		                        $cc.=isset($arrEmail[$i]) ? $arrEmail[$i].';' : ';';
		                }
		        }			

		        $to = $toEmail;
		        $cc = $toEmail2;
		        $subject="Cek Dokumen Registrasi: UPB ".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada Approval oleh PPIC Manager pada Cek Dokumen Registrasi(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
		                <div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
		                        <table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
		                                <tr>
		                                        <td style='width: 110px;'><b>No UPB</b></td><td style='width: 20px;'> : </td><td>".$rupb['vupb_nomor']."</td>
		                                </tr>
		                                <tr>
		                                        <td><b>Nama Usulan</b></td><td> : </td><td>".$rupb['vupb_nama']."</td>
		                                </tr>
		                                <tr>
		                                        <td><b>Nama Generik</b></td><td> : </td><td>".$rupb['vgenerik']."</td>
		                                </tr>
		                                <tr>
		                                        <td><b>Team Busdev</b></td><td> : </td><td>".$rupb['bd']."</td>
		                                </tr>
		                                <tr>
		                                        <td><b>Team PD</b></td><td> : </td><td>".$rupb['pd']."</td>
		                                </tr>
		                                <tr>
		                                        <td><b>Team QA</b></td><td> : </td><td>".$rupb['qa']."</td>
		                                </tr>
		                                <tr>
		                                        <td><b>Team QC</b></td><td> : </td><td>".$rupb['qc']."</td>
		                                </tr>
		                        </table>
		                </div>
		                <br/> 
		                Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
		                Post Master";
		        	$this->lib_utilitas->send_email($to, $cc, $subject, $content);

				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Approved Success!';
				echo json_encode($r);
				exit();
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
			case 'getuploadfile':
				$get=$this->input->get('field');
				switch ($get) {
					case 'null':
						echo "NOT FOUND";
						break;
					default:
						echo $this->v3_m_reg->get_v3_cek_dokumen_reg_filemain();
						break;
				}
				break;
			case 'doneprocess':
				$post=$this->input->post();
				echo $this->v3_m_reg->doneprocess();
				break;
			case 'confirm':
				$post=$this->input->post();
				$get=$this->input->get();
				$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$iapprove ='iconfirm_registrasi';$vapprove ='cconfirm_registrasi';$tapprove ='dconfirm_registrasi';
				$this->db_plc0->where('iupb_id', $post['iupb_id']);
				$this->db_plc0->update('plc2.plc2_upb', array($iapprove=>2,$vapprove=>$nip,$tapprove=>$skg));
				$iupb_id=$post['iupb_id'];
				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Confirm Success!';
				echo json_encode($r);
				exit();
				break;
			case 'getFormUpload':
				$post=$this->input->post();
				$get=$this->input->get();
				$dupb=$this->v3_m_reg->getUPBDetails($get['id']);
				$filter=array('de.ikategori_id=4 and de.ijenisdok=2 and de.jenisplc=1');
				$row=$this->v3_m_reg->getDetailFiles($filter)->result_array();
				$data['html']="";
				if(count($row)>=1){
					$html="";
					foreach ($row as $key => $vv) {
						/*Get ID Header*/

						/*	
							Mansur 27 April 2019 
							untuk SOI FG bisa jadi tidak dilewati,
							jika tidak dilewati maka form upload tidak perlu tampil
						 */
						/*Get ID Header*/
						if($vv['idetaildok']== 14 or $vv['idetaildok']== 29 ){
							$sql= 'select a.iuji_mikro 
										from plc2.study_literatur_pd a 
										where a.iupb_id="'.$get['id'].'" ';
							if($dupb['iCopy_brand']==1){
								$sql= 'select a.iuji_mikro 
										from plc2.study_literatur_pd a 
										join plc2.plc2_upb u on u.iupb_id_ref=a.iupb_id
										where u.iupb_id="'.$get['id'].'" ';
							}
							$dUji = $this->db_plc0->query($sql)->row_array();
							$field=$vv['filename'];

							if($dUji['iuji_mikro']==1){

								$rowData=$dupb;
								$dgrid=$this->v3_m_reg->getDoneOnUpdateBox($field,$rowData);
								$dgrid['get']=$get;
								$dgrid['urlpath']=$this->urlpath;
								$ret="-";
								$jenisteam="";
								if($vv['isPD']==1){
									$jenisteam="(PD)";
								}elseif($vv['isPackdev']==1){
									$jenisteam="(Packdev)";
								}elseif($vv['isQA']==1){
									$jenisteam="(QA)";
								}

								if($dgrid['nilaiid']>=1){
									$ret=$this->load->view('lokal/cek_dokumen_registrasi/v3_main_grid_reg',$dgrid,TRUE);
								}else{
									$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$field.'_dis" id="'.$field.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
								}
								$html.='<div class="rows_group" style="overflow:auto;"><label for="v3_cek_dokumen_reg_'.$vv['filename'].'" class="rows_label">'.$vv['labelform'].' '.$jenisteam.' </label><div class="rows_input">'.$ret.'</div></div>';
							}

						}else{
								$field=$vv['filename'];
									$rowData=$dupb;
									$dgrid=$this->v3_m_reg->getDoneOnUpdateBox($field,$rowData);
									$dgrid['get']=$get;
									$dgrid['urlpath']=$this->urlpath;
									$ret="-";
									$jenisteam="";
									if($vv['isPD']==1){
										$jenisteam="(PD)";
									}elseif($vv['isPackdev']==1){
										$jenisteam="(Packdev)";
									}elseif($vv['isQA']==1){
										$jenisteam="(QA)";
									}

									if($dgrid['nilaiid']>=1){
										$ret=$this->load->view('lokal/cek_dokumen_registrasi/v3_main_grid_reg',$dgrid,TRUE);
									}else{
										$ret= '<input type="text" style="background:#FFBBBB;border:solid 1px #FF0000;" disabled="TRUE" name="'.$field.'_dis" id="'.$field.'_dis" class="input_rows1" size="20" value="Module Belum Di Lalui" />';
									}
									$html.='<div class="rows_group" style="overflow:auto;"><label for="v3_cek_dokumen_reg_'.$vv['filename'].'" class="rows_label">'.$vv['labelform'].' '.$jenisteam.' </label><div class="rows_input">'.$ret.'</div></div>';
						}
						
					}
					$data["html"]=$html;
				}
				echo json_encode($data);
				break;
			default:
				$grid->render_grid();
				break;
		}
    }
/*Maniupulasi Gird end*/




	function listBox_v3_cek_dokumen_reg_iconfirm_registrasi($value) {
		if($value==0){$vstatus='Waiting for approval';}
		elseif($value==1){$vstatus='Rejected';}
		elseif($value==2){$vstatus='Approved';}
		return $vstatus;
	}
	
/*manipulasi view object form start*/
function updatebox_v3_cek_dokumen_reg_iNew_formula($field, $id, $value,$rowData) {
	$x=$this->auth->dept();
	if($this->auth->is_manager()){
		$x=$this->auth->dept();
		$manager=$x['manager'];
		if(in_array('PD', $manager)){$type='PD';$isman=true;}
		elseif(in_array('BD', $manager)){$type='BD';$isman=true;}
		elseif(in_array('PR', $manager)){$type='PR';$isman=true;}
		elseif(in_array('QA', $manager)){$type='QA';$isman=true;}
		elseif(in_array('QC', $manager)){$type='QC';$isman=true;}
		elseif(in_array('PAC', $manager)){$type='PAC';$isman=true;}
		else{$type='';}
	}
	else{
		$x=$this->auth->dept();
		if(isset($x['team'])){
			$team=$x['team'];
			if(in_array('BD', $team)){$type='BD';}
			elseif(in_array('PR', $team)){$type='PR';}
			elseif(in_array('QA', $team)){$type='QA';}
			elseif(in_array('QC', $team)){$type='QC';}
			elseif(in_array('PAC', $team)){$type='PAC';}
			elseif(in_array('PD', $team)){$type='PD';}
			else{$type='';}
		}
	}

		$lmarketing = array(''=>'Select One',0=>'Tidak', 1=>'Ya');
		if ($this->input->get('action') == 'view') {
				$o = $lmarketing[$value];
		} else {
			if($rowData['iCopy_brand'] == 1){
				if($value <> ""){
					$o = $lmarketing[$value];
					$o .= '<input type="hidden" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1" size="30" />';
				}else{

					if($type == 'PD'){
						$o  = "<select name='".$field."' id='".$id."' class='required'>";            
						foreach($lmarketing as $k=>$v) {
								if ($k == $value) $selected = " selected";
								else $selected = "";
								$o .= "<option {$selected} value='".$k."'>".$v."</option>";
						}            
						$o .= "</select>";	
					}
					

				}

			}else{
				$o = 'Diisi jika UPB Copy brand  <input type="hidden" name="'.$field.'" id="'.$id.'" value="NULL" class="input_rows1" size="30" />';
			}
				
				
		}
		return $o;
}

function updatebox_v3_cek_dokumen_reg_iNew_formulax($field, $id, $value) {
	$lmarketing = array(''=>'Select One',0=>'Tidak', 1=>'Ya');
	if ($this->input->get('action') == 'view') {
			$o = $lmarketing[$value];
	} else {
			if($value <> ""){
				$o = $lmarketing[$value];
				$o .= '<input type="hidden" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1" size="30" />';
			}else{
				$o  = "<select name='".$field."' id='".$id."'>";            
				foreach($lmarketing as $k=>$v) {
						if ($k == $value) $selected = " selected";
						else $selected = "";
						$o .= "<option {$selected} value='".$k."'>".$v."</option>";
				}            
				$o .= "</select>";

			}
			
	}
	return $o;
}

function updatebox_v3_cek_dokumen_reg_vNew_formula($field, $id, $value,$rowData) {
	if($rowData['iNew_formula'] <> ""){
		$return = '<input type="hidden" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1" size="30" />';
		$return .= $value;
	}else{
		if($rowData['iCopy_brand'] == 1){
			$return = '<input type="text" name="'.$field.'" id="'.$id.'" value="'.$value.'" class="input_rows1" size="30" />';
			$return .= '<br>Update dahulu dan Formula baru Ya agar dapat menambah file';

			$return .= '<script>';
						$return .= '
												$("#v3_cek_dokumen_reg_vNew_formula").hide();
												$("#v3_cek_dokumen_reg_iNew_formula").die();
												$("#v3_cek_dokumen_reg_iNew_formula").live("change",function(){
													
													if($(this).val() == 1){
														$("#v3_cek_dokumen_reg_vNew_formula").show();
													}else{
														$("#v3_cek_dokumen_reg_vNew_formula").hide();
													}

												})';
				$return .= '</script>';

		}else{
			$return = 'Diisi jika UPB Copy brand  <input type="hidden" name="'.$field.'" id="'.$id.'" value="NULL" class="input_rows1" size="30" />';
		}
		

		
	}

	return $return;
}

 	function updateBox_v3_cek_dokumen_reg_details_log($field, $id, $value, $rowData){
		$post=$this->input->post();
        $get=$this->input->get();

        $sqlFields = 'select * from plc3.m_modul_fileds a where a.lDeleted=0 and  a.iM_modul='.$this->iModul_id.' order by a.iSort ASC';
		$dFields = $this->db->query($sqlFields)->result_array();

        $return = '
            <table class="hover_table" style="width:98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse" cellspacing="0" cellpadding="1">
                <thead>
                    <tr style="width: 100%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
                        <th style="border: 1px solid #dddddd;">Activity Name</th>
                        <th style="border: 1px solid #dddddd;">Status</th>
                        <th style="border: 1px solid #dddddd;">at</th>      
                        <th style="border: 1px solid #dddddd;">by</th>      
                        <th style="border: 1px solid #dddddd;">Remark</th>      
                    </tr>
                </thead>
                <tbody>';

                $return .= $this->getHistoryActivity($this->modul_id,$rowData['iupb_id']);

        $return .='
                </tbody>
            </table>
            <br>
            <br>
            <hr>
        ';
		$return .= '<script>
			var sebelum = $("label[for=\''.$this->url.'_details_log\']").parent();
			$("label[for=\''.$this->url.'_details_log\']").remove();
			sebelum.find("div").attr("style","margin-left:10px;");
		</script>';
		return $return;
	}
 	function updateBox_v3_cek_dokumen_reg_iupb_id($field, $id, $value, $rowData){
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nomor'];
		}else{
		$return = '<input type="hidden" name="isdraft" id="isdraft">';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1" value='.$value.' />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" value="'.$dt['vupb_nomor'].'" size="20" />';
		$return .= '<input type="hidden" name="isdraft" id="isdraft">';
		}
		return $return;
	}

	function updateBox_v3_cek_dokumen_reg_vupb_nama($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nama'];
		}else{
			$return='<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$dt['vupb_nama'].'" />';
			$return='<textarea disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20">'.$dt['vupb_nama'].'</textarea>';
		}
		return $return;
	}
	function updateBox_v3_cek_dokumen_reg_vgenerik($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vgenerik'];
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$dt['vgenerik'].'" />';
			$return='<textarea disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20">'.$dt['vgenerik'].'</textarea>';

		}
		return $return;
	}

	/*FileUpload*/
	function updateBox_v3_cek_dokumen_reg_fileupload($field,$id,$value,$rowData){
		$get=$this->input->get();
		$post=$this->input->post();
		foreach ($get as $kget => $vget) {
		    if($kget!="action"){
		        $in[]=$kget."=".$vget;
		    }
		    if($kget=="action"){
		    	$in[]="act=".$vget;
		    }
		}
		$g=implode("&", $in);
		$return = '<script>
			var sebelum = $("label[for=\'v3_cek_dokumen_reg_fileupload\']").parent();
			$("label[for=\'v3_cek_dokumen_reg_fileupload\']").remove();
			sebelum.attr("id","'.$id.'");
			sebelum.html("");
			sebelum.removeAttr("class");
			sebelum.removeAttr("style");
			$.ajax({
				url: base_url+"processor/'.$this->urlpath.'?action=getFormUpload&'.$g.'",
				type: "post",
				data: iupb_id=0,
				success: function(data) {
					var o = $.parseJSON(data);
					sebelum.html(o.html);
				}		
			});
		</script>';
		return $return;
	}

	function updateBox_v3_cek_dokumen_reg_form_iconfirm_registrasi_pd($field, $id, $value, $rowData) {
		if($rowData['iconfirm_registrasi_pd'] != 0){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cconfirm_registrasi_pd']))->row_array();
			if($rowData['iconfirm_registrasi_pd']==1){$st="Approved";}
			$ret= $st.' By '.$row['vName'].' ( '.$rowData['cconfirm_registrasi_pd'].' )'.' At '.$rowData['dconfirm_registrasi_pd'];
		}
		else{
			$ret='Waiting for Approval';
		}
		$ret.='<input type="hidden" name="'.$id.'" value="'.$rowData['iconfirm_registrasi_pd'].'" />';
		return $ret;
	}
	
	function updateBox_v3_cek_dokumen_reg_form_iconfirm_registrasi_qa($field, $id, $value, $rowData) {
		if($rowData['iconfirm_registrasi_qa'] != 0){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cnip_confirm_registrasi_qa']))->row_array();
			if($rowData['iconfirm_registrasi_qa']==1){$st="Submited";} 
			$name=isset($row['vName'])?$row['vName']:"";
			$ret= $st.' oleh '.$name.' ( '.$rowData['cnip_confirm_registrasi_qa'].' )'.' pada '.$rowData['tconfirm_registrasi_qa'];
		}
		else{
			$ret='Waiting for Approval';
		}
		$ret.='<input type="hidden" name="'.$id.'" value="'.$rowData['iconfirm_registrasi_qa'].'" />';
		return $ret;
	}
	
	function updateBox_v3_cek_dokumen_reg_form_iconfirm_registrasi($field, $id, $value, $rowData) {
		if($rowData['iconfirm_registrasi'] != 0){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cconfirm_registrasi']))->row_array();
			if($rowData['iconfirm_registrasi']==2){$st="Approved";}elseif($rowData['iconfirm_registrasi']==1){$st="Rejected";} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['cconfirm_registrasi'].' )'.' pada '.$rowData['dconfirm_registrasi'];
		}
		else{
			$ret='Waiting for Approval';
		}
		$ret.='<input type="hidden" name="'.$id.'" value="'.$rowData['iconfirm_registrasi'].'" />';
		return $ret;
	}

	
/*manipulasi view object form end*/

/*manipulasi proses object form start*/
	function manipulate_update_button($buttons, $rowData){
		$iupb_id=$rowData['iupb_id'];
		$mydept = $this->auth->my_depts(TRUE);
		$data['typeupdate']="0";
		if(in_array('BD', $mydept)){
			$data['typeupdate']="BD";
		}
		if(in_array('QA', $mydept)){
			$data['typeupdate']="QA";
		}

		$cNip= $this->user->gNIP;
		$data['upload']='upload_custom_grid';
		$js = $this->load->view('js/standard_js',$data,TRUE);
		$js .= $this->load->view('js/cek_dok_reg_js',$data,TRUE);
	
		$iframe = '<iframe name="'.$this->url.'_frame" id="'.$this->url.'_frame" height="0" width="0"></iframe>';
		$update_draft = '<button onclick="javascript:update_draft_btn(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?last_id='.$iupb_id.'&draft=true&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',this,true )"  id="button_update_draft_'.$this->url.'"  class="ui-button-text icon-save" >Update</button>';
		$update = '<button onclick="javascript:update_btn_back(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?last_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_update_submit_'.$this->url.'"  class="ui-button-text icon-save" >Update &amp; Submit</button>';
		$updateQA = '<button onclick="javascript:update_btn_back_v3_cekdok_reg_QA(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?last_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_update_submit_'.$this->url.'"  class="ui-button-text icon-save" >Update &amp; Submit</button>';
		$updateBD = '<button onclick="javascript:update_btn_back_v3_cekdok_reg_BD(\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?last_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_update_submit_'.$this->url.'"  class="ui-button-text icon-save" >Update &amp; Submit</button>';
		$refresh="";
		if($rowData["iCopy_brand"]==1){
			$refresh = '<button onclick="javascript:reload_copy2(\''.$iupb_id.'\',\''.$this->url.'\', \' '.base_url().'processor/'.$this->urlpath.'?last_id='.$iupb_id.'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').' \',this,true )"  id="button_refresh_'.$this->url.'"  class="ui-button-text icon-save" >Refresh Copy</button>';
		}

		$cNip=$this->user->gNIP;
		$sql= "select * from plc2.plc2_upb up where up.iupb_id=".$rowData['iupb_id'];
		$type="";
		$dt=$this->db_plc0->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {unset($buttons['update']);}
		else{
			unset($buttons['update']);
			unset($buttons['update_back']);
			$user = $this->auth->user();
		
			$x=$this->auth->dept();
			if($this->auth->is_manager()){
				$x=$this->auth->dept();
				$manager=$x['manager'];
				if(in_array('PD', $manager)){$type='PD';$isman=true;}
				elseif(in_array('BD', $manager)){$type='BD';$isman=true;}
				elseif(in_array('PR', $manager)){$type='PR';$isman=true;}
				elseif(in_array('QA', $manager)){$type='QA';$isman=true;}
				elseif(in_array('QC', $manager)){$type='QC';$isman=true;}
				elseif(in_array('PAC', $manager)){$type='PAC';$isman=true;}
				else{$type='';}
			}
			else{
				$x=$this->auth->dept();
				if(isset($x['team'])){
					$team=$x['team'];
					if(in_array('BD', $team)){$type='BD';}
					elseif(in_array('PR', $team)){$type='PR';}
					elseif(in_array('QA', $team)){$type='QA';}
					elseif(in_array('QC', $team)){$type='QC';}
					elseif(in_array('PAC', $team)){$type='PAC';}
					elseif(in_array('PD', $team)){$type='PD';}
					else{$type='';}
				}
			}

			$iupb_id=$rowData['iupb_id'];
			$ifor_id=$this->v3_m_reg->getAnotherUPB('ifor_id',$iupb_id);
			$iprotokol_id=$this->v3_m_reg->getAnotherUPB('iprotokol_id',$iupb_id);
			$isoi_id=$this->v3_m_reg->getAnotherUPB('isoi_id',$iupb_id);
			$ivalmoa_id=$this->v3_m_reg->getAnotherUPB('ivalmoa_id',$iupb_id);
			$ibk_id=$this->v3_m_reg->getAnotherUPB('ibk_id',$iupb_id);

			/*---------------------Cek Untuk PD----------------------------------*/
			/*List Tabel*/
			$pddetailtable=$this->v3_m_reg->getDetailtable("PD",$iupb_id,1);
			$table=$pddetailtable['table'];
			$pktable=$pddetailtable['pktable'];/*PK per table*/
			$nitable=$pddetailtable['nitable'];
			$iM_modul_fileds=$pddetailtable['iM_modul_fileds'];
			/*End Table PD*/
			/*---------------------Cek Untuk QA----------------------------------*/
			/*List Tabel*/
			$pddetailtableqa=$this->v3_m_reg->getDetailtable("QA",$iupb_id,1);
			$tableqa=$pddetailtableqa['table'];
			$pktableqa=$pddetailtableqa['pktable'];/*PK per table*/
			$nitableqa=$pddetailtableqa['nitable'];
			/*End Table QA*/
			/*---------------------Cek Untuk PAC----------------------------------*/
			/*List Tabel*/
			$pddetailtablepac=$this->v3_m_reg->getDetailtable("PAC",$iupb_id,1);
			$tablepac=$pddetailtablepac['table'];
			$pktablepac=$pddetailtablepac['pktable'];/*PK per table*/
			$nitablepac=$pddetailtablepac['nitable'];
			/*End Table QA*/

			$activities = $this->lib_plc->get_current_module_activities($this->modul_id,'iupb_id');
			$getLastStatusApprove = $this->lib_plc->getLastStatusApprove($this->modul_id,'iupb_id');
			$iM_modul_activity=0;
			$iM_activity=0;
			foreach ($activities as $act) {
				$iM_modul_activity=$act['iM_modul_activity'];
				$iM_activity=$act['iM_activity'];
			}

			$ii=0;//nilai apakah sudah ada belum
			foreach ($table as $ktb => $vtb) {
				/*Cek Untuk dokumen PD minimal 1 File*/
				$sqlc="select * from plc2.group_file_upload where iDeleted=0 and iM_modul_fileds=".$iM_modul_fileds[$ktb]." AND idHeader_File=".$nitable[$ktb];
				if($this->db_plc0->query($sqlc)->num_rows()==0){
					$ii++;
				}
			}

			
			/* if($rowData['ineed_prareg']==1){
				
					if($type=='PD'&&$rowData['iconfirm_registrasi_pd']==0 && $rowData['iappbusdev_prareg']==2){

						$approve = '<button onclick="javascript:setuju(\'v3_cek_dokumen_reg\', \''.base_url().'processor/'.$this->urlpath.'?action=confirmpd&last_id='.$this->input->get('id').'&iM_modul_activity='.$iM_modul_activity.'&iM_activity='.$iM_activity.'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\',\'processor/plc/v3/cek/dokumen/reg?action=view\')" class="ui-button-text icon-save" id="button_v3_cek_dokumen_reg">Approve</button>';
						if($ii==0){
							$buttons['update']=$refresh.$update_draft.$approve.$js;
						}else{
							$buttons['update']=$refresh.$update_draft.$js;
						}
					}else{
						$buttons['update']= $refresh.$js.'<br>'.'Prareg belum selesai';
					}

			}else{
				if($type=='PD'&&$rowData['iconfirm_registrasi_pd']==0){


					$approve = '<button onclick="javascript:setuju(\'v3_cek_dokumen_reg\', \''.base_url().'processor/'.$this->urlpath.'?action=confirmpd&last_id='.$this->input->get('id').'&iM_modul_activity='.$iM_modul_activity.'&iM_activity='.$iM_activity.'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\',\'processor/plc/v3/cek/dokumen/reg?action=view\')" class="ui-button-text icon-save" id="button_v3_cek_dokumen_reg">Approve</button>';
					if($ii==0){
						$buttons['update']=$refresh.$update_draft.$approve.$js;
					}else{
						$buttons['update']=$refresh.$update_draft.$js;
					}
				}

			} */

			if($type=='PD'&&$rowData['iconfirm_registrasi_pd']==0){


				$approve = '<button onclick="javascript:setuju(\'v3_cek_dokumen_reg\', \''.base_url().'processor/'.$this->urlpath.'?action=confirmpd&last_id='.$this->input->get('id').'&iM_modul_activity='.$iM_modul_activity.'&iM_activity='.$iM_activity.'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\',\'processor/plc/v3/cek/dokumen/reg?action=view\')" class="ui-button-text icon-save" id="button_v3_cek_dokumen_reg">Approve</button>';
				if($ii==0){
					$buttons['update']=$refresh.$update_draft.$approve.$js;
				}else{
					$buttons['update']=$refresh.$update_draft.$js;
				}
			}


			
			
			$iia=0;//nilai apakah sudah ada belum
			$iSRejectBD=0;
			$iDone=0;
			$iSRejectQA=0;
			foreach ($table as $ktb => $vtb) {
				/*Cek Untuk dokumen PD minimal 1 File*/
				$sqlc="select * from plc2.group_file_upload where iDeleted=0 and iM_modul_fileds=".$iM_modul_fileds[$ktb]." AND idHeader_File=".$nitable[$ktb];
				if($this->db_plc0->query($sqlc)->num_rows()==0){
					$iia++;
				}
			}
			if($type=='QA'&&$rowData['iconfirm_registrasi_pd']>0&&$rowData['iconfirm_registrasi_qa']==0){
				$approve = '<button onclick="javascript:setuju(\'v3_cek_dokumen_reg\', \''.base_url().'processor/'.$this->urlpath.'?action=confirmqa&last_id='.$this->input->get('id').'&iM_modul_activity='.$iM_modul_activity.'&iM_activity='.$iM_activity.'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\',\'processor/plc/v3/cek/dokumen/reg?action=view\')" class="ui-button-text icon-save" id="button_v3_cek_dokumen_reg">Approve</button>';
				
				$filter=array('de.ikategori_id=4 and de.ijenisdok=2 and de.jenisplc=1');
				$row=$this->v3_m_reg->getDetailFiles($filter)->result_array();
				foreach ($row as $krow => $vrow) {
					$ipk=$this->v3_m_reg->getAnotherUPB($vrow['fieldheader'],$rowData['iupb_id']);
					$iM_modul_fileds=$vrow['iM_modul_fileds'];
					$this->db_plc0->select("*")
								->from("plc2.group_file_upload")
								->where("iM_modul_fileds",$iM_modul_fileds)
								->where("idHeader_File",$ipk)
								->where("istatus",0)
								->where("iDeleted",0);
					$getFile=$this->db_plc0->get();
					$rowDet=$getFile->result_array();
					foreach ($rowDet as $krowDet => $vrowDet){
						$iSRejectQA++;
					}
				}
				
				if($iia==0 && $iSRejectQA==0){
					$buttons['update']=$refresh.$update_draft.$updateQA.$approve.$js;
				}else{
					$buttons['update']=$refresh.$update_draft.$updateQA.$js;
				}
			}
			if($type=='BD'&&$rowData['iconfirm_registrasi_pd']>0&&$rowData['iconfirm_registrasi_qa']>0&&$rowData['iconfirm_registrasi']==0){
				$approve = '<button onclick="javascript:setuju(\'v3_cek_dokumen_reg\', \''.base_url().'processor/'.$this->urlpath.'?action=confirmbd&last_id='.$this->input->get('id').'&iM_modul_activity='.$iM_modul_activity.'&iM_activity='.$iM_activity.'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\',\'processor/plc/v3/cek/dokumen/reg?action=view\')" class="ui-button-text icon-save" id="button_v3_cek_dokumen_reg">Approve</button>';
				
				$filter=array('de.ikategori_id=4 and de.ijenisdok=2 and de.jenisplc=1');
				$row=$this->v3_m_reg->getDetailFiles($filter)->result_array();
				foreach ($row as $krow => $vrow) {
					$ipk=$this->v3_m_reg->getAnotherUPB($vrow['fieldheader'],$rowData['iupb_id']);
					$iM_modul_fileds=$vrow['iM_modul_fileds'];
					$this->db_plc0->select("*")
								->from("plc2.group_file_upload")
								->where("iM_modul_fileds",$iM_modul_fileds)
								->where("idHeader_File",$ipk)
								->where("iDeleted",0)
								->where_in("iconfirm_busdev",array(0,3))
								->where("iDone",0);
					$getFile=$this->db_plc0->get();
					$rowDet=$getFile->result_array();
					foreach ($rowDet as $krowDet => $vrowDet){
						$iSRejectBD++;
					}
					$this->db_plc0->select("*")
								->from("plc2.group_file_upload")
								->where("iM_modul_fileds",$iM_modul_fileds)
								->where("idHeader_File",$ipk)
								->where("iDeleted",0)
								->where("iDone",0);
					$getFile=$this->db_plc0->get();
					$rowDet=$getFile->result_array();
					foreach ($rowDet as $krowDet => $vrowDet){
						$iDone++;
					}
				}
				
				if($iia==0 && $iSRejectBD==0){
					if($iDone==0){
						$buttons['update']=$refresh.$approve.$js;
					}else{
						$buttons['update']=$refresh.$update_draft.$updateBD.$js;
					}
					
				}else{
					$buttons['update']=$refresh.$update_draft.$updateBD.$js;
				}
			}
		}	

		/* $sButton = $iframe.$js;
		$sButton .= $update_draft.$update;
		$buttons['update']=$sButton; */

		/* ---------- Cek Untuk Module Sebelumnya --------- */
		$isisemua=0;
		$tittle="";
		$contectModule="";
		$ss=0;
		/* Cek Untuk Validasi Proses*/
		$query5="select iupb_id from plc2.validasi_proses where iappqa=2 and lDeleted=0 and iupb_id=".$rowData['iupb_id'];
		$row5=$this->db_plc0->query($query5)->num_rows();
		if($row5==0 && $type!="PD"){
			$ss++;
			$contectModule.="<li>Module Validasi Proses[QA]</li>";
		}

		/* Cek Untuk Protokol Valpro */
		$query2="select iupb_id from plc2.protokol_valpro  where iappqa=2 and ldeleted=0 and iupb_id=".$rowData['iupb_id'];
		$row2=$this->db_plc0->query($query2)->num_rows();
		if($row2==0 && $type!="PD"){
			$ss++;
			$contectModule.="<li>Module Protokol Valpro [QA]</li>";
		}
		/* Cek Untuk Uji Mikro FG Steril*/
		$query2="select * from plc2.plc2_upb_formula
		join plc2.study_literatur_pd on study_literatur_pd.iupb_id=plc2_upb_formula.iupb_id
			where plc2_upb_formula.ldeleted=0 and study_literatur_pd.lDeleted=0 
			AND	(
					CASE WHEN study_literatur_pd.ijenis_sediaan=0 AND study_literatur_pd.iuji_mikro=1 THEN
						plc2_upb_formula.ifor_id IN (select mikro_fg.ifor_id from plc2.mikro_fg where mikro_fg.iappqa_uji=2 and mikro_fg.lDeleted=0 )
					ELSE
						study_literatur_pd.lDeleted=0
					END
				)
		AND study_literatur_pd.iupb_id=".$rowData['iupb_id'];
		$row2=$this->db_plc0->query($query2)->num_rows();
		if($row2==0 && $type!="PD"){
			$ss++;
			$contectModule.="<li>Module Uji Mikro FG Steril [QA]</li>";
		}
		/* Cek Untuk Need Prareg*/
		$and="";
		if($type=="QA"){
			$and=" AND iconfirm_dok_pd>0";
		}
		if($type=="BD"){
			$and=" AND iconfirm_dok>0 AND iappbd_hpr=2 AND iprareg_ulang_prareg=0";
		}
		$query2="select * from plc2.plc2_upb 
			WHERE (CASE WHEN ineed_prareg=1 THEN
				iconfirm_dok_pd=2
				".$and."
			ELSE
				ldeleted=0
			END)
			AND iupb_id=".$rowData['iupb_id'];
		$row2=$this->db_plc0->query($query2)->num_rows();
		if($row2==0){
			$ss++;
			if($type!="BD"){
				$contectModule.="<li>Module Cek Dokumen Prareg[PD / QA]</li>";
			}else{
				$contectModule.="<li>Module Prareg - Tidak Prareg Ulang[BD]</li>";
			}
		}


		if($ss!=0){
			$tittle.="<span style='font-weight:bold'>Module belum dilalui :</span><br /></span><span style='color:red'><ul style='list-style-type: circle;;margin-left:10px;'>".$contectModule."</ul></span>";
		}

		/* $sButton = $iframe.$js;
		$sButton .= $update_draft.$update; */

		$dupb=$this->v3_m_reg->getUPBDetails($rowData['iupb_id']);
		$filter=array('de.ikategori_id=4 and de.ijenisdok=2 and de.jenisplc=1');
		if($type=="PD"){
			$filter=array('de.ikategori_id=4 and de.ijenisdok=2 and de.jenisplc=1 and de.isPD=1');
		}
		$row=$this->v3_m_reg->getDetailFiles($filter)->result_array();
		$get=$this->input->get();
		$belumissi=array();
		if(count($row)>=1){
			foreach ($row as $key => $vv) {
				/*Get ID Header*/
				/*SOI FG required jika study literatur uji mikro Ya*/
				if($vv['idetaildok']== 14 or $vv['idetaildok']== 29 ){
					$sql= 'select a.iuji_mikro 
								from plc2.study_literatur_pd a 
								where a.iupb_id="'.$rowData['iupb_id'].'" ';
					if($rowData['iCopy_brand']==1){
						$sql= 'select a.iuji_mikro 
								from plc2.study_literatur_pd a 
								join plc2.plc2_upb u on u.iupb_id_ref=a.iupb_id
								where u.iupb_id="'.$rowData['iupb_id'].'" ';
					}
					$dUji = $this->db_plc0->query($sql)->row_array();

					if($dUji['iuji_mikro']==1){
						$field=$vv['filename'];
						$rowData=$dupb;
						$dgrid=$this->v3_m_reg->getDoneOnUpdateBox($field,$rowData,$get);

						if($dgrid['nilaiid']==0){
							$isisemua++;
							$belumissi[]=$vv['labelform'];
						}

					}
				}else{
					$field=$vv['filename'];
					$rowData=$dupb;
					$dgrid=$this->v3_m_reg->getDoneOnUpdateBox($field,$rowData,$get);
					if($dgrid['nilaiid']==0){
						$isisemua++;
						$belumissi[]=$vv['labelform'];
					}

				}
				
			}
		}
		if($isisemua>0){
			$tt="";
			foreach($belumissi as $ss => $valisi){
				$tt.="<li>".$valisi."</li>";
			}
			$tittle.="<span style='font-weight:bold'>File dokumen belum diupload :</span><br /></span><span style='color:red'><ul style='list-style-type: circle;;margin-left:10px;'>".$tt."</ul></span>";
			
		}
		if($isisemua>0 or $ss>0){
			$js.="<script>
				$('#initooltip').tooltip({
					items: '#initooltip',
					content: function () {
						return $(this).prop('title');
					},
					position: {
						my: 'right bottom',
						at: 'left-15 top'
					}
				});
			</script>";
			if($rowData["iCopy_brand"]!=1){
			$buttons['update']=$refresh.' <a href="#" id="initooltip" title="'.$tittle.'" class="ui-icon ui-icon-info">Help</a>'.$js;
			}else{
				$buttons['update']=$refresh.$js;
			}
		}




		if($rowData["iCopy_brand"]==1){
			$approve="-";
			if($type=="BD"){
				$approve = '<button onclick="javascript:setuju(\'v3_cek_dokumen_reg\', \''.base_url().'processor/'.$this->urlpath.'?action=confirmbd&last_id='.$this->input->get('id').'&iM_modul_activity='.$iM_modul_activity.'&iM_activity='.$iM_activity.'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_v3_cek_dokumen_prareg">Approve</button>';
				if($rowData['iconfirm_registrasi']==0){
					if($iia==0 && $iSRejectBD==0 && $iDone==0){
					 //$buttons['update'] = $refresh.$update_draft.$update.$approve.$js;
					/* 
							check UPB reference sudah approve cekdok belum 
							jika belum, maka tidak bisa approve
							
						
						*/
						$sqlMother = 'select * from plc2.plc2_upb a where a.iupb_id= "'.$rowData['iupb_id_ref'].'"';
						$dMother = $this->db->query($sqlMother)->row_array();
						if($dMother['iconfirm_registrasi'] == 2 ){
							$buttons['update'] = $refresh.$update_draft.$updateBD.$approve.$js;
						}else{
							$buttons['update'] = $refresh.$update_draft.$updateBD.$js.'<br>'.'UPB Original ['.$dMother['vupb_nomor'].'] belum melewati Approval BD';
						}

					}else{
					$buttons['update'] = $refresh.$update_draft.$update.$js;
					}
				}
			}
			elseif($type=="QA"){
				$approve = '<button onclick="javascript:setuju(\'v3_cek_dokumen_reg\', \''.base_url().'processor/'.$this->urlpath.'?action=confirmqa&last_id='.$this->input->get('id').'&iM_modul_activity='.$iM_modul_activity.'&iM_activity='.$iM_activity.'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_v3_cek_dokumen_prareg">Approve</button>';
				if($rowData['iconfirm_registrasi_qa']==0){
					if($iia==0 && $iSRejectQA==0){
						$buttons['update'] = $refresh.$update_draft.$updateQA.$approve.$js;
					}else{
						$buttons['update'] = $refresh.$update_draft.$updateQA.$js;
					}
				}
			}
			elseif($type=="PD" && $rowData['iconfirm_registrasi_pd']==0){
				$approve = '<button onclick="javascript:setuju(\'v3_cek_dokumen_reg\', \''.base_url().'processor/'.$this->urlpath.'?action=confirmpd&last_id='.$this->input->get('id').'&iM_modul_activity='.$iM_modul_activity.'&iM_activity='.$iM_activity.'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_v3_cek_dokumen_prareg">Approve</button>';
				if($rowData['iconfirm_registrasi_pd']==0){	
					if($ii==0){
					$buttons['update'] = $refresh.$update_draft.$approve.$js;
					}else{
					$buttons['update'] = $refresh.$update_draft.$js;
					}
				}
			}
			else{ $buttons['update']=$refresh.$js; }
		}
		return $buttons;
	}
   
/*manipulasi proses object form end*/    
function before_update_processor($row, $postData) {
	unset($postData['vupb_nama']);
	unset($postData['vgenerik']);
	return $postData;

}

function after_update_processor($row, $post, $postData) {
	
}

function getHistoryActivity($modul_id,$iKey_id){
	$sql = '
			select b.vNama_activity,a.dCreate,c.vName,a.vRemark
			,if(a.iApprove=2,"Approve",if(a.iApprove=1,"Reject","-")) as setatus
			from plc3.m_modul_log_activity a 
			join plc3.m_activity b on b.iM_activity=a.iM_activity
			join hrd.employee c on c.cNip=a.cCreated
			where 
			a.idprivi_modules ="'.$modul_id.'"
			and a.iKey_id ="'.$iKey_id.'"
			order by a.iM_modul_log_activity DESC
	';

	$query = $this->db_plc0->query($sql);
	$jmlRow = $query->num_rows();
	
	$html = '';

	if ($jmlRow > 0) {
		$rows = $query->result_array();
		$i=0;
		foreach ($rows as $data ) {
			$html .='
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td style="border: 1px solid #dddddd; text-align: center;">
						<span class="">'.$data['vNama_activity'].'</span>
					</td>
					<td style="border: 1px solid #dddddd; text-align: center;">
						<span class="">'.$data['setatus'].'</span>
					</td>
					<td style="border: 1px solid #dddddd; text-align: center;">
						<span class="">'.$data['dCreate'].'</span>
					</td>
					<td style="border: 1px solid #dddddd; text-align: center;">
						<span class="">'.$data['vName'].'</span>
					</td>
					<td style="border: 1px solid #dddddd; text-align: center;">
						<span class="">'.$data['vRemark'].'</span>
					</td>
				</tr>';


			$i++;
		}
	}else{
		$html .='
				<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
					<td colspan="5" style="border: 1px solid #dddddd; text-align: center;">
						<span class="">No Data</span>
					</td>
				</tr>';


	}

	return $html;

}

/*function pendukung end*/   

	public function output(){
		$this->index($this->input->get('action'));
	}

}