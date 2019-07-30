<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class pembuatan_mbr extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		//$this->db_plc0 = $this->load->database('plc', true);
		 $this->load->library('lib_flow');
		 $this->load->library('lib_utilitas');
		$this->user = $this->auth_localnon->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;

		$grid->setTitle('Pembuatan Master Formula dan MBR');		
		$grid->setTable('plc2.plc2_upb_formula');		
		$grid->setUrl('pembuatan_mbr');
		$grid->addList('formula.vNo_formula','plc2_upb.vupb_nomor','plc2_upb_buat_mbr.no_mbr','plc2_upb_buat_mbr.dbuat_mbr','plc2_upb_buat_mbr.isubmit','plc2_upb_buat_mbr.iapppd_bm');	
		
		$grid->setSortBy('plc2_upb.vupb_nomor');
		$grid->setSortOrder('ASC');

		$grid->setAlign('plc2_upb.vupb_nomor', 'center');
		$grid->setWidth('plc2_upb.vupb_nomor', '200');
		$grid->setLabel('plc2_upb.vupb_nomor', 'UPB Nomor');

		$grid->setAlign('formula.vNo_formula', 'center');
		$grid->setWidth('formula.vNo_formula', '200');
		
		$grid->setLabel('vkode_surat', 'No Formula');
		$grid->setLabel('formula.vNo_formula', 'No Formula');

		$grid->setAlign('plc2_upb_buat_mbr.no_mbr', 'center');
		$grid->setWidth('plc2_upb_buat_mbr.no_mbr', '200');
		$grid->setLabel('plc2_upb_buat_mbr.no_mbr', 'No MBR');

		$grid->setAlign('plc2_upb_buat_mbr.dbuat_mbr', 'center');
		$grid->setWidth('plc2_upb_buat_mbr.dbuat_mbr', '150');
		$grid->setLabel('plc2_upb_buat_mbr.dbuat_mbr', 'Tgl Buat MBR');

		$grid->setAlign('plc2_upb_buat_mbr.isubmit', 'center');
		$grid->setWidth('plc2_upb_buat_mbr.isubmit', '150');
		$grid->setLabel('plc2_upb_buat_mbr.isubmit', 'Status Submit');

		$grid->setAlign('plc2_upb_buat_mbr.iapppd_bm', 'center');
		$grid->setWidth('plc2_upb_buat_mbr.iapppd_bm', '150');
		$grid->setLabel('plc2_upb_buat_mbr.iapppd_bm', 'Approval PD');

		$grid->addFields('vkode_surat','no_mbr','dbuat_mbr','dtgl_appr_1','dtgl_appr_2','dtgl_appr_3','dtgl_appr_4','vnip_apppd_bm');

		$grid->setLabel('no_mbr', 'No. MBR');
		$grid->setLabel('dbuat_mbr', 'Tanggal Pembuatan MBR');
		$grid->setLabel('dtgl_appr_1', 'Tanggal Approve I');
		$grid->setLabel('dtgl_appr_2', 'Tanggal Approve II');
		$grid->setLabel('dtgl_appr_3', 'Tanggal Approve III');
		$grid->setLabel('dtgl_appr_4', 'Tanggal Approve IV');
		$grid->setLabel('vnip_apppd_bm', 'PD Approval');

		$grid->setRequired('no_mbr','dbuat_mbr','dtgl_appr_1','dtgl_appr_2','dtgl_appr_3','dtgl_appr_4');

		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			/*}elseif(in_array('QC', $manager)){
				$type='QC';
				$grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth_localnon->my_teams().')',null);
			*/}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('PD', $team)){
					$type='PD';
					$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
				/*}elseif(in_array('QC', $manager)){
					$type='QC';
					$grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth_localnon->my_teams().')',null);
				*/}
				else{$type='';}
			}
		}

		$grid->setQuery('plc2_upb_formula.iapp_basic',2); //Mandatori pada basic formula
		$grid->setQuery('plc2_upb_formula.iapppd_basic',2); //Mandatori pada basic formula
		/*$grid->setQuery('plc2_upb_formula.iupb_id in (select bk.iupb_id from plc2.plc2_upb_bahan_kemas bk where bk.iapppc=2 and bk.iapppd=2 and bk.iappqa=2 and bk.iappbd=2 and bk.ldeleted=0 group by bk.iupb_id)',Null);//Mandatori Bahan Kemas*/
		$grid->setQuery('plc2_upb_formula.iupb_id in (select bk.iupb_id from plc2.plc2_upb_bahan_kemas bk where bk.iapppd=2 and bk.iappqa=2 and bk.iappbd=2 and bk.ldeleted=0 group by bk.iupb_id)',Null);//Mandatori Bahan Kemas

		//New Parameter For PLC Non OTC
		$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
		$grid->setQuery('plc2.plc2_upb.iKill', 0);
		$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
		$grid->setQuery('plc2_upb.ihold', 0);
		
		$grid->setJoinTable('plc2.plc2_upb','plc2_upb_formula.iupb_id = plc2_upb.iupb_id','inner');
		$grid->setJoinTable('plc2.plc2_upb_buat_mbr','plc2_upb_buat_mbr.ifor_id = plc2_upb_formula.ifor_id','left');
		$grid->setJoinTable('pddetail.formula_process','formula_process.iupb_id=plc2_upb_formula.iupb_id','inner');
		$grid->setJoinTable('pddetail.formula','formula.iFormula_process=formula_process.iFormula_process','inner');
		
		$grid->changeFieldType('plc2_upb_buat_mbr.isubmit','combobox','',array(0=>'Need to Submit',1=>'Submited'));

		$grid->setSearch('formula.vNo_formula','plc2_upb.vupb_nomor');

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
			default:
				$grid->render_grid();
				break;
		}
    }

/*Maniupulasi Gird Start*/


/*Maniupulasi Gird end*/
	function listBox_pembuatan_mbr_plc2_upb_buat_mbr_iapppd_bm($value) {
		if($value==0){$vstatus='Waiting for approval';}
		elseif($value==1){$vstatus='Rejected';}
		elseif($value==2){$vstatus='Approved';}
		return $vstatus;
	}

	function listBox_pembuatan_mbr_plc2_upb_buat_mbr_isubmit($value) {
		if($value==0){$vstatus='Draft - Need to Submit';}
		elseif($value==1){$vstatus='Submited';}
		return $vstatus;
	}

	function listBox_Action($row, $actions) {
		$ifor_id=$row->ifor_id;
		$this->db_plc0->where('ifor_id',$ifor_id);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sel="select * from plc2.plc2_upb_buat_mbr where ifor_id=$ifor_id";
			$roww = $this->db_plc0->query($sel)->row_array();
			if($roww['iapppd_bm'] > 0){
				unset($actions['edit']);
				unset($actions['delete']);
			}
		}
		return $actions;
	}
/*manipulasi view object form start*/
 	
	function updateBox_pembuatan_mbr_vkode_surat($name, $id, $value,$rowData) {
		$sql='select fo.ifor_id,f.vNo_formula as vkode_surat, up.vupb_nomor, up.vupb_nama, up.vgenerik 
				from plc2.plc2_upb_formula fo
				inner join plc2.plc2_upb up on up.iupb_id=fo.iupb_id
				join pddetail.formula_process fp on fp.iFormula_process=fo.iFormula_process
				join pddetail.formula f on f.iFormula_process=fp.iFormula_process
				where fo.ifor_id='.$rowData['ifor_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		return $dt['vkode_surat'];
	}

	function updateBox_pembuatan_mbr_no_mbr($field, $id, $value, $rowData) {
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_buat_mbr m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			if($this->input->get('action')=='view'){
				return $row['no_mbr'];
			}else{
				return '<input type="text" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="15" value="'.$row['no_mbr'].'"/>';
			}
		}
		else{
			if($this->input->get('action')=='view'){
				return '-';
			}else{
				return '<input type="text" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="15"/>';
			}
		}
		
	}

	function updateBox_pembuatan_mbr_dbuat_mbr($field, $id, $value, $rowData) {
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_buat_mbr m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			$value=$row['dbuat_mbr'];
			$value=date("d-m-Y", strtotime($value));
			if($this->input->get('action')=='view'){
				$return	=date("d-m-Y", strtotime($value));
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" value='.$value.' />';
				$return .= '<input type="hidden" name="isdraft" id="isdraft">';
				$return .=	'<script>
									$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
		else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" />';
				$return .= '<input type="hidden" name="isdraft" id="isdraft">';
				$return .=	'<script>
									$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
		
	}
	function updateBox_pembuatan_mbr_dtgl_appr_1($field, $id, $value, $rowData) {

		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_buat_mbr m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			$value=$row['dtgl_appr_1'];
			$value=date("d-m-Y", strtotime($value));
			if($this->input->get('action')=='view'){
				$return	=date("d-m-Y", strtotime($value));
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" value='.$value.' />';
				$return .=	'<script>
									$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
		else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" />';
				$return .=	'<script>
									$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
	}
	function updateBox_pembuatan_mbr_dtgl_appr_2($field, $id, $value, $rowData) {
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_buat_mbr m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			$value=$row['dtgl_appr_2'];
			$value=date("d-m-Y", strtotime($value));
			if($this->input->get('action')=='view'){
				$return	=date("d-m-Y", strtotime($value));
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" value='.$value.' />';
				$return .=	'<script>
									$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
		else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" />';
				$return .=	'<script>
								$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
	}
	function updateBox_pembuatan_mbr_dtgl_appr_3($field, $id, $value, $rowData) {
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_buat_mbr m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			$value=$row['dtgl_appr_2'];
			$value=date("d-m-Y", strtotime($value));
			if($this->input->get('action')=='view'){
				$return	=date("d-m-Y", strtotime($value));
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" value='.$value.' />';
				$return .=	'<script>
									$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
		else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" />';
				$return .=	'<script>
									$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
	}
	function updateBox_pembuatan_mbr_dtgl_appr_4($field, $id, $value, $rowData) {
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_buat_mbr m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$row = $this->db_plc0->query($sql)->row_array();
			$value=$row['dtgl_appr_2'];
			$value=date("d-m-Y", strtotime($value));
			if($this->input->get('action')=='view'){
				$return	=date("d-m-Y", strtotime($value));
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" value='.$value.' />';
				$return .=	'<script>
									$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
		else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:100px" />';
				$return .=	'<script>
									$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
								
							</script>';
			}
			return $return;
		}
	}
	function updateBox_pembuatan_mbr_vnip_apppd_bm($field, $id, $value, $rowData) {
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
		if($j2> 0){
			$sql = "SELECT * FROM plc2.plc2_upb_buat_mbr m
				WHERE m.ifor_id='".$rowData['ifor_id']."'";
			$rows = $this->db_plc0->query($sql)->row_array();
			if(($rows['vnip_apppd_bm'] != null) && ($rows['iapppd_bm'] != 0)){
				$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rows['vnip_apppd_bm']))->row_array();
				if($rows['iapppd_bm']==2){$st="Approved";}elseif($rows['iapppd_bm']==1){$st="Rejected";} 
				$ret= $st.' oleh '.$row['vName'].' ( '.$rows['vnip_apppd_bm'].' )'.' pada '.$rows['tapppd_bm'];
			}
			else{
				$ret='Waiting for Approval';
			}
		}else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
/*manipulasi view object form end*/

/*manipulasi proses object form start*/

	function manipulate_update_button($buttons, $rowData){
		//print_r($rowData);exit();
		unset($buttons['update']);
		$js=$this->load->view('pembuatan_mbr_js');
		$cNip=$this->user->gNIP;
		$this->db_plc0->where('ifor_id', $rowData['ifor_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');

		$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/pembuatan/mbr?action=approve&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_pembuatan_mbr">Approve</button>';
		$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/pembuatan/mbr?action=reject&ifor_id='.$rowData['ifor_id'].'&iupb_id='.$rowData['iupb_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_pembuatan_mbr">Reject</button>';

		$update = '<button onclick="javascript:update_btn_back(\'pembuatan_mbr\', \''.base_url().'processor/plc/pembuatan/mbr?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_pembuatan_mbr">Update & Submit</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'pembuatan_mbr\', \''.base_url().'processor/plc/pembuatan/mbr?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_pembuatan_mbr">Update as Draft</button>';
		//echo $j2; exit();
		if($j2==0){
			if($this->auth_localnon->is_manager()){
				$x=$this->auth_localnon->dept();
				$manager=$x['manager'];
				if(in_array('PD', $manager)){
					$type='PD';
					$buttons['update']=$updatedraft.$update.$js;
				}else{
					$type='';
				}
			}else{
				$x=$this->auth_localnon->dept();
				$team=$x['team'];
				if(in_array('PD', $team)){
					$type='PD';
					$buttons['update']=$updatedraft.$update.$js;
				}else{
					$type='';
				}
			}
		}else{
			$sql="select * from plc2.plc2_upb_buat_mbr where ifor_id=".$rowData['ifor_id']." order by ibuatmbr_id DESC limit 1";
			$row=$this->db_plc0->query($sql)->row_array();
			if($this->auth_localnon->is_manager()){
				$x=$this->auth_localnon->dept();
				$manager=$x['manager'];
				if(in_array('PD', $manager)){
					$type='PD';
					if($row['isubmit']==0){
						$buttons['update']=$updatedraft.$update.$js;
					}else{
						if($row['iapppd_bm']==0){
							$buttons['update']=$approve;
						}
					}
				}else{
					$type='';
				}
			}else{
				$x=$this->auth_localnon->dept();
				$team=$x['team'];
				if(in_array('PD', $team)){
					$type='PD';
					if($row['isubmit']==0){
						$buttons['update']=$updatedraft.$update.$js;
					}else{}
				}else{
					$type='';
				}
			}
		}
		return $buttons;
	}
   
/*manipulasi proses object form end*/    

function before_update_processor($row, $postData) {
	$postData['dupdate'] = date('Y-m-d H:i:s');
	$postData['cUpdate'] =$this->user->gNIP;
		if($postData['isdraft']==true){
			$postData['isubmit']=0;
		} 
		else{$postData['isubmit']=1;} 
	$postData['dbuat_mbr']=date("Y-m-d", strtotime($postData['dbuat_mbr']));
	$postData['dtgl_appr_1']=date("Y-m-d", strtotime($postData['dtgl_appr_1']));
	$postData['dtgl_appr_2']=date("Y-m-d", strtotime($postData['dtgl_appr_2']));
	$postData['dtgl_appr_3']=date("Y-m-d", strtotime($postData['dtgl_appr_3']));
	$postData['dtgl_appr_4']=date("Y-m-d", strtotime($postData['dtgl_appr_1']));
	unset($postData['vkode_surat']);
	unset($postData['pembuatan_mbr_dbuat_mbr']);
	unset($postData['pembuatan_mbr_dtgl_appr_1']);
	unset($postData['pembuatan_mbr_dtgl_appr_2']);
	unset($postData['pembuatan_mbr_dtgl_appr_3']);
	unset($postData['pembuatan_mbr_dtgl_appr_4']);
	///print_r($postData);exit();
	return $postData;

}

/*Approval & Reject Proses */

function approve_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
						return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var url = "'.base_url().'processor/plc/pembuatan/mbr";
								if(o.status == true) {
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=view&id="+last_id, function(data) {
										 $("div#form_pembuatan_mbr").html(data);
									});
									reload_grid("grid_pembuatan_mbr");
								}
									
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_pembuatan_mbr_approve" action="'.base_url().'processor/plc/pembuatan/mbr?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="iupb_id" value="'.$this->input->get('iupb_id').'" />
    			<input type="hidden" name="ifor_id" value="'.$this->input->get('ifor_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_pembuatan_mbr_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
	}

	function approve_process(){
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('QC', $manager)){
				$type='QC';
			}elseif(in_array('PD', $manager)){
				$type='PD';
			}else{
				$type='';
			}
		}else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('QC', $team)){
				$type='QC';
			}else{
				$type='';
			}
		}
		$post = $this->input->post();
	 	$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$iapprove = $type == 'PD' ? 'iapppd_bm' : '';
		$this->db_plc0->update('plc2.plc2_upb_buat_mbr', array($iapprove=>2,'vnip_apppd_bm'=>$nip,'tapppd_bm'=>$skg));
    
    	$upbid = $post['iupb_id'];
	
    	$ins['iupb_id'] = $post['iupb_id'];
		$ins['iapp_id'] = $post['group_id']; // relasikan dgn erp_privi.privi_apps
		$ins['vmodule'] = $post['modul_id']; // relasikan dgn erp_privi.privi_modules
		$ins['idiv_id'] = '';
		$ins['vtipe'] = $type;
		$ins['iapprove'] = '2';
		$ins['cnip'] = $this->user->gNIP;
		$ins['treason'] = $post['remark'];
		$ins['tupdate'] = date('Y-m-d H:i:s');
    
    	$this->db_plc0->insert('plc2.plc2_upb_approve', $ins);
   	
		$ifor_id=$this->input->post('ifor_id');
        $ins2['ifor_id']=$ifor_id;
		$this->db_plc0->insert('plc2.plc2_upb_prodpilot', $ins2);
		//$this->lib_flow->insert_logs($post['modul_id'],$upbid,9,2);
       
        $qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
                        from plc2.plc2_upb u where u.iupb_id='".$post['iupb_id']."'";
        $rupb = $this->db_plc0->query($qupb)->row_array();

        $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id 
                from plc2.plc2_upb u where u.iupb_id='".$post['iupb_id']."'";
        $rsql = $this->db_plc0->query($qsql)->row_array();

        //$query = $this->db_plc0->query($rsql);

        $pd = $rsql['iteampd_id'];
        //$bd = $rsql['iteambusdev_id'];
        //$qa = $rsql['iteamqa_id'];

        $team = $pd ;

        $toEmail2='';
        $toEmail = $this->lib_utilitas->get_email_team( $team );
        //$toEmail2 = $this->lib_utilitas->get_email_leader( $team );                        

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
        $cc = $arrEmail;
        $subject="Proses Pembuatan MBR Selesai: UPB ".$rupb['vupb_nomor'];
        $content="
                Diberitahukan bahwa telah ada approval UPB oleh PD Manager pada proses Pembuatan MBR(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
                                <tr>
                                        <td><b>Proses Selanjutnya</b></td><td> : </td><td>Protokol Volpro</td>
                                </tr>
                        </table>
                </div>
                <br/> 
                Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
                Post Master";
        $this->lib_utilitas->send_email($to, $cc, $subject, $content);
		$data['group_id']=$post['group_id'];
		$data['modul_id']=$post['modul_id'];	
		$data['status']  = true;
    	$data['last_id'] = $ifor_id;
    	return json_encode($data);
	}


	function after_update_processor($row, $insertId, $postData){			
		//print_r($postData);exit();
		$post = $this->input->post();
		$skrg = date('Y-m-d H:i:s');
		
		$ifor_id=$postData['ifor_id'];
		$this->db_plc0->where('ifor_id',$ifor_id);		
		$j2 = $this->db_plc0->count_all_results('plc2.plc2_upb_buat_mbr');
			//data
			$data['ifor_id'] = $postData['ifor_id'];
			$data['no_mbr'] = $postData['no_mbr'];
			$data['dbuat_mbr'] =$postData['dbuat_mbr'];
			$data['dtgl_appr_1'] =$postData['dtgl_appr_1'];
			$data['dtgl_appr_2'] = $postData['dtgl_appr_2'];
			$data['dtgl_appr_3'] = $postData['dtgl_appr_3'];
			$data['dtgl_appr_4'] = $postData['dtgl_appr_4'];
			$data['isubmit'] = $postData['isubmit'];
		if($j2 > 0){
			//update data
			$this->db_plc0->where('ifor_id',$data['ifor_id']);
			$this->db_plc0->update('plc2.plc2_upb_buat_mbr', array('no_mbr'=>$data['no_mbr'],'dbuat_mbr'=>$data['dbuat_mbr'],'dtgl_appr_1'=>$data['dtgl_appr_1'],
																'dtgl_appr_2'=>$data['dtgl_appr_2'],'dtgl_appr_3'=>$data['dtgl_appr_3'],'dtgl_appr_4'=>$data['dtgl_appr_4'],'isubmit'=>$data['isubmit']));
		}
		else{
			//insert data
			$this->db_plc0->insert('plc2_upb_buat_mbr',$data);
		}
		$sel="select * from plc2.plc2_upb_formula f where f.ifor_id=$ifor_id";
		$rowb = $this->db_plc0->query($sel)->row_array();
		$iupb_id=$rowb['iupb_id'];
		//if($postData['isubmit']==1){
		//	$this->lib_flow->insert_logs($this->input->get('modul_id'),$iupb_id,7);
		//}
	}

/*function pendukung end*/    	
	public function output(){
		$this->index($this->input->get('action'));
	}

}
