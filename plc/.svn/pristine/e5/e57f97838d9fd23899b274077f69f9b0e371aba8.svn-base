<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class cancel_dossier_upd extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->dbset = $this->load->database('dosier', true);
		$this->dbset2 = $this->load->database('plc', true);
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Cancel Dossier UPD');		
		$grid->setTable('dossier.dossier_upd');		
		$grid->setUrl('cancel_dossier_upd');
		$grid->addList('vUpd_no','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','plc2_upb.iteamqa_id','ihold_status','ihold');
		$grid->setSortBy('vUpd_no');
		$grid->setSortOrder('DESC');
		$grid->setAlign('vUpd_no', 'center');
		$grid->setWidth('vUpd_no', '100');
		$grid->setAlign('plc2_upb.vupb_nomor', 'center');
		$grid->setWidth('plc2_upb.vupb_nomor', '100');
		$grid->setAlign('plc2_upb.vupb_nama', 'Left');
		$grid->setWidth('plc2_upb.vupb_nama', '200');
		$grid->setAlign('plc2_upb.vgenerik', 'Left');
		$grid->setWidth('plc2_upb.vgenerik', '200');
		$grid->setAlign('plc2_upb.iteamqa_id', 'Left');
		$grid->setWidth('plc2_upb.iteamqa_id', '100');
		$grid->setAlign('ihold', 'center');
		$grid->setWidth('ihold', '100');
		$grid->setAlign('ihold_status', 'center');
		$grid->setWidth('ihold', '100');
		$grid->addFields('vUpd_no','vupb_nomor','vupb_nama','vgenerik','iteamqa_id');
		$grid->setLabel('vUpd_no', 'UPD Nomor');
		$grid->setLabel('plc2_upb.vupb_nomor', 'UPB Nomor');
		$grid->setLabel('vupb_nomor', 'UPB Nomor');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('plc2_upb.iteamqa_id', 'Team QA');
		$grid->setLabel('iteamqa_id', 'Team QA');
		$grid->setLabel('ihold', 'Status');
		$grid->setLabel('ihold_status', 'Status Hold');
		$grid->setRequired('ihold');
		$grid->setSearch('vUpd_no','plc2_upb.vupb_nomor','ihold');
		$grid->changeFieldType('ihold','combobox','',array(''=>'---Pilih---',0=>'Actived',1=>'Cancel'));
		$grid->changeFieldType('ihold_status','combobox','',array(0=>'Actived',1=>'Submited to Kill'));
		$grid->setRelation('plc2.plc2_upb.iteamqa_id','plc2.plc2_upb_team','iteam_id','vteam','team_qa','inner',array('vtipe'=>'QA', 'ldeleted'=>0),array('vteam'=>'asc'));
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb.iupb_id = dossier_upd.iupb_id', 'inner');

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
				$this->download($this->input->get('file'));
				break;
			case 'delete':
				echo $grid->delete_row();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				echo $grid->updated_form();
				break;
			case 'approveview':
				echo $this->approveview($this->input->get());
				break;
			case 'approve_process':
				echo $this->approve_process($this->input->get(),$this->input->post());
				break;
			case 'reject':
				echo $this->reject_view();
				break;
			case 'reject_process':
				echo $this->reject_process();
				break;
			case 'kill':
				echo $this->killview($this->input->get()); 
				break;
			case 'killprocess':
				$get=$this->input->get();
				$post=$this->input->post();

				$idossier_upd_id=$post['idossier_upd_id'];
				$data['treason']=$post['cancel_dossier_upd_reason'];
				$data['ihold_status']=1;
				$data['iapp_kill_qa']=0;
				$data['cUpdate']=$this->user->gNIP;
				$data['dupdate']=date('Y-m-d H:i:s');
				$this->dbset->where('idossier_upd_id',$idossier_upd_id);
				$this->dbset->update('dossier.dossier_upd',$data);

				if (isset($_FILES['cancel_dossier_upd_attc']))  {
					$path = realpath("files/plc/dossier_dok/dossier_cancel");
					if(!file_exists($path."/".$idossier_upd_id)){
						if (!mkdir($path."/".$idossier_upd_id, 0777, true)) { //id review
							die('Failed upload, try again!');
						}
					}

					foreach ($_FILES['cancel_dossier_upd_attc']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {
							$tmp_name = $_FILES['cancel_dossier_upd_attc']["tmp_name"][$key];
							$name =$_FILES['cancel_dossier_upd_attc']["name"][$key];
							$data['vattch'] = $name;
							if(move_uploaded_file($tmp_name, $path."/".$idossier_upd_id."/".$name)) {
								$data['vattch']=$name;
								$this->dbset->where('idossier_upd_id',$idossier_upd_id);
								$this->dbset->update('dossier.dossier_upd',$data);
							}
							else{
								echo "Upload ke folder gagal";	
							}
						}
					}
				}

				$data=array();
				$data=$get;
				$data['last_id']=$idossier_upd_id;
				$data['status']=TRUE;
				$data['message']='Data Berhasil Di Update';
				echo json_encode($data);
				break;
			default:
				$grid->render_grid();
				break;
		}
    }

/*Maniupulasi Gird end*/

/*manipulasi view object form end*/
	
	function updateBox_cancel_dossier_upd_iteamqa_id($field, $id, $value, $rowData){
		$sql='select * from plc2.plc2_upb up
			inner join plc2.plc2_upb_team te on up.iteamqa_id=te.iteam_id
		 where up.iupb_id='.$rowData['iupb_id'];
		$qs=$this->dbset2->query($sql);
		if($qs->num_rows()>=1){
			$ds=$qs->row_array();
			$return=$ds['vteam'];
		}else{
			$return='';
		}
		return $return;
	}

	function updateBox_cancel_dossier_upd_vUpd_no($field, $id, $value, $rowData){
		return $rowData['vUpd_no'];
	}

	function updateBox_cancel_dossier_upd_vupb_nomor($field, $id, $value, $rowData){
		$sql='select * from plc2.plc2_upb up where up.iupb_id='.$rowData['iupb_id'];
		$qs=$this->dbset2->query($sql);
		if($qs->num_rows()>=1){
			$ds=$qs->row_array();
			$return=$ds['vupb_nomor'];
		}else{
			$return='';
		}
		return $return;
	}
	function updateBox_cancel_dossier_upd_vupb_nama($field, $id, $value, $rowData){
		$sql='select * from plc2.plc2_upb up where up.iupb_id='.$rowData['iupb_id'];
		$qs=$this->dbset2->query($sql);
		if($qs->num_rows()>=1){
			$ds=$qs->row_array();
			$return=$ds['vupb_nama'];
		}else{
			$return='';
		}
		return $return;
	}
	function updateBox_cancel_dossier_upd_vgenerik($field, $id, $value, $rowData){
		$sql='select * from plc2.plc2_upb up where up.iupb_id='.$rowData['iupb_id'];
		$qs=$this->dbset2->query($sql);
		if($qs->num_rows()>=1){
			$ds=$qs->row_array();
			$return=$ds['vgenerik'];
		}else{
			$return='';
		}
		return $return;
	}

/*manipulasi proses object form start*/
   
	function killview($get){
		$o='';
		$o.='<form class="form_horizontal_plc" method="post" action="'.base_url().'processor/plc/cancel/dossier/upd?action=killprocess&foreign_key='.$get['foreign_key'].'&company_id='.$get['company_id'].'&group_id='.$get['group_id'].'&modul_id='.$get['modul_id'].'" id="form_popup_cancel_dossier_upd">';
		$o.='<div class="rows_group" style="overflow:auto;"><label for="cancel_dossier_upd_reason" class="rows_label">Reason </label>
				<div class="rows_input">
					<input type="hidden" name="idossier_upd_id" id="idossier_upd_id" value="'.$get['idossier_upd_id'].'"  />
					<textarea id="cancel_dossier_upd_reason" name="cancel_dossier_upd_reason" class="required"></textarea>
				</div>
			</div>';
		$o.='<div class="rows_group" style="overflow:auto;"><label for="cancel_dossier_upd_attc" class="rows_label">Attachement </label>
				<div class="rows_input">
					 <input type="file" id="cancel_dossier_upd_attc" class="fileupload multi multifile" name="cancel_dossier_upd_attc[]" style="width: 40%" />
				</div>
			</div>';
		$o.='</form>';
		$o.='<script>';
		$o.='$("#cancel_dossier_upd_attc").change(function () {
		        var fileExtension = ["pdf","jpeg", "jpg", "png", "gif", "bmp"];
		        if ($.inArray($(this).val().split(".").pop().toLowerCase(), fileExtension) == -1) {
		        	_custom_alert("Only formats are allowed : "+fileExtension.join(", "),"info","info", "killview", 1, 20000);
		        	$(this).val("");
		        }
			 });';
		$o.='</script>';
		return $o;
	}

	function approveview($get){
		$q="select * from dossier.dossier_upd up where up.idossier_upd_id=".$get['idossier_upd_id'];
		$dt=$this->dbset->query($q)->row_array();
		$required=$get['ihold']==1?'required':'';
		$type=$get['group'];
		$o='';
		$o.='<form class="form_horizontal_plc" method="post" action="'.base_url().'processor/plc/cancel/dossier/upd?action=approve_process&foreign_key='.$get['foreign_key'].'&company_id='.$get['company_id'].'&group_id='.$get['group_id'].'&modul_id='.$get['modul_id'].'" id="form_popup_cancel_dossier_upd">';
		$o.='<div class="rows_group" style="overflow:auto;"><label for="cancel_dossier_upd_reason" class="rows_label">Reason </label>
				<div class="rows_input">
					<input type="hidden" name="idossier_upd_id" id="idossier_upd_id" value="'.$get['idossier_upd_id'].'"  />
					<input type="hidden" name="group" id="group" value="'.$type.'" />
					<input type="hidden" name="status" id="status" value="'.$get['ihold'].'" />
					<textarea id="cancel_dossier_upd_reason" name="cancel_dossier_upd_reason" disabled="disabled">'.$dt['treason'].'</textarea>
				</div>
			</div>';
		$o.='<div class="rows_group" style="overflow:auto;"><label for="cancel_dossier_upd_attc" class="rows_label">Attachement </label>
				<div class="rows_input">';
		if($dt['vattch']!='' or $dt['vattch']!=null){
			$value =  $dt['vattch'];
			if (file_exists('./files/plc/dossier_dok/dossier_cancel/'.$get['idossier_upd_id'].'/'.$value)) {
				$link = base_url().'processor/plc/cancel/dossier/upd?action=download&id='.$get['idossier_upd_id'].'&file='.$value;
				$linknya = '<a style="color: #0000ff" href="javascript:;" onclick="window.location=\''.$link.'\'">'.$value.'</a>';
			}
			else {
				$linknya = $value;
			}
			$o.=$linknya;	
		}else{
			$o.=$dt['vattch'];
		}
		$o.='</div>
			</div>';
		$disabled=$type=='BDI'?'disabled="disabled"':'';
		$o.='<div class="rows_group" style="overflow:auto;"><label for="cancel_dossier_upd_vremark_qa" class="rows_label">Remark QA</label>
				<div class="rows_input">
					<textarea id="cancel_dossier_upd_vremark" name="cancel_dossier_upd_vremark_qa" class="'.$required.'" '.$disabled.'>'.$dt['vremark_kill_qa'].'</textarea>
				</div>
			</div>';
		if($type=='BDI'){
			$o.='<div class="rows_group" style="overflow:auto;"><label for="cancel_dossier_upd_vremark_bdi" class="rows_label">Remark BDIRM</label>
				<div class="rows_input">
					<textarea id="cancel_dossier_upd_vremark" name="cancel_dossier_upd_vremark_bdi" class="'.$required.'">'.$dt['vremark_kill_bdi'].'</textarea>
				</div>
			</div>';
		}
		$o.='</form>';
		return $o;
	}

	function approve_process($get,$post){
		$type=$post['group'];
		$iapp=$type=="QA"?"iapp_kill_qa":"iapp_kill_bdi";
		$dapp=$type=="QA"?"dapp_kill_qa":"dapp_kill_bdi";
		$capp=$type=="QA"?"capp_kill_qa":"capp_kill_bdi";
		$vremark=$type=="QA"?"vremark_kill_qa":"vremark_kill_bdi";
		$vremark_text=$type=="QA"?$post['cancel_dossier_upd_vremark_qa']:$post['cancel_dossier_upd_vremark_bdi'];
		$nip=$this->user->gNIP;
		$date=date('Y-m-d H:i:s');
		$status=$post['status'];

		$dataupdate[$iapp]=$status;
		$dataupdate[$dapp]=$date;
		$dataupdate[$capp]=$nip;
		$dataupdate[$vremark]=$vremark_text;
		if($type=='QA'){
			$dataupdate['iapp_kill_bdi']=0;
		}else{
			if($status==2){
				$dataupdate['ihold']=1;
			}
		}
		if($status==1){
			$dataupdate['ihold_status']=0;
		}
		$this->dbset->where('idossier_upd_id',$post['idossier_upd_id']);
		$this->dbset->update('dossier.dossier_upd',$dataupdate);

		$data=array();
		$data=$get;
		$data['last_id']=$post['idossier_upd_id'];
		$data['status']=TRUE;
		$data['message']='Data Berhasil Di Update';
		return json_encode($data);
	}

	function manipulate_update_button($buttons, $rowData){
		unset($buttons['update']);
		$cNip=$this->user->gNIP;
		$js=$this->load->view('cancel_dossier_upd_js');
		$js .= $this->load->view('uploadjs');
		$kill = '<button onclick="javascript:load_pop_cancel(\''.base_url().'processor/plc/cancel/dossier/upd?action=kill&idossier_upd_id='.$rowData['idossier_upd_id'].'&cNip='.$cNip.'&ihold=1&group_id='.$this->input->get('group_id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'\',\'Kill Proses UPD\',\'Kill\',\'cancel_dossier_upd\',\'processor/plc/cancel/dossier/upd?action=update\')" class="ui-button-text icon-save" id="button_kill_cancel_dossier_upd">Kill</button>';
		$app = '<button onclick="javascript:load_pop_bdi(\''.base_url().'processor/plc/cancel/dossier/upd?action=approveview&idossier_upd_id='.$rowData['idossier_upd_id'].'&group=BDI&cNip='.$cNip.'&ihold=2&group_id='.$this->input->get('group_id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'\',\'Approve Kill Proses UPD Oleh BDIRM\',\'Approve\',\'cancel_dossier_upd\',\'processor/plc/cancel/dossier/upd?action=view\')" class="ui-button-text icon-save" id="button_kill_cancel_dossier_upd">Approve</button>';
		$rej = '<button onclick="javascript:load_pop_bdi(\''.base_url().'processor/plc/cancel/dossier/upd?action=approveview&idossier_upd_id='.$rowData['idossier_upd_id'].'&group=BDI&cNip='.$cNip.'&ihold=1&group_id='.$this->input->get('group_id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'\',\'Reject Kill Proses UPD Oleh BDIRM\',\'Reject\',\'cancel_dossier_upd\',\'processor/plc/cancel/dossier/upd?action=update\')" class="ui-button-text icon-save" id="button_kill_cancel_dossier_upd">Reject</button>';
		$appqa = '<button onclick="javascript:load_pop_bdi(\''.base_url().'processor/plc/cancel/dossier/upd?action=approveview&idossier_upd_id='.$rowData['idossier_upd_id'].'&group=QA&cNip='.$cNip.'&ihold=2&group_id='.$this->input->get('group_id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'\',\'Approve Kill Proses UPD Oleh QA\',\'Approve\',\'cancel_dossier_upd\',\'processor/plc/cancel/dossier/upd?action=view\')" class="ui-button-text icon-save" id="button_kill_cancel_dossier_upd">Approve</button>';
		$rejqa = '<button onclick="javascript:load_pop_bdi(\''.base_url().'processor/plc/cancel/dossier/upd?action=approveview&idossier_upd_id='.$rowData['idossier_upd_id'].'&group=QA&cNip='.$cNip.'&ihold=1&group_id='.$this->input->get('group_id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'\',\'Reject Kill Proses UPD Oleh QA\',\'Reject\',\'cancel_dossier_upd\',\'processor/plc/cancel/dossier/upd?action=update\')" class="ui-button-text icon-save" id="button_kill_cancel_dossier_upd">Reject</button>';
		
		if($this->input->get('action')=='view'){

		}else{
			if($this->auth->is_manager()){
				$x=$this->auth->dept();
				$manager=$x['manager'];
				if(in_array('QA', $manager)){
					if($rowData['ihold_status']==0){
						$buttons['update']=$kill.$js;
					}elseif($rowData['ihold_status']==1 && $rowData['iapp_kill_qa']==0){
						$buttons['update']=$appqa.$rejqa.$js;
					}
				}elseif(in_array('BDI', $manager)){
					if($rowData['ihold_status']==1&& $rowData['iapp_kill_qa']==2 && $rowData['iapp_kill_bdi']==0){
						$buttons['update']=$app.$rej.$js;
					}
				}else{
					$type='';
				}
			}else{
				$x=$this->auth->dept();
				$team=$x['team'];
				if(in_array('QA', $team)){
				
				}else{
					$type='';
				}
			}
		}
		return $buttons;
	}
function download($filename) {
	$this->load->helper('download');		
	$name = $_GET['file'];
	$id = $_GET['id'];
	$path = file_get_contents('./files/plc/dossier_dok/dossier_cancel/'.$id.'/'.$name);	
	force_download($name, $path);
}
/*Approval & Reject Proses */
	public function output(){
		$this->index($this->input->get('action'));
	}

}
