<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_bisnis_proses_sub extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
    }
    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle('Business Process Sub');		
		$grid->setTable('plc2.plc2_biz_process_sub');		
		$grid->setUrl('master_bisnis_proses_sub');
		// $grid->addList('idplc2_biz_process','idplc2_activity','iteam_id','cUsedLogic','iSequence','iSLA');
		$grid->addList('idplc2_biz_process','idplc2_activity','iteam_id');
		$grid->setSortBy('idplc2_biz_process');
		$grid->setSortOrder('ASC');
		$grid->setWidth('iSLA', '75');
		// $grid->setWidth('iSequence', '75');
		// $grid->setWidth('cUsedLogic', '75');
		// $grid->setWidth('idplc2_activity', '100');
		$grid->setWidth('idplc_div2_structure', '100');
		// $grid->setAlign('iSequence', 'right');
		// $grid->setAlign('iSLA', 'right');
		// $grid->setAlign('cUsedLogic', 'center');
		// $grid->addFields('idplc2_biz_process','idplc2_activity','iteam_id','iDependOnStep','cUsedLogic','iSequence','isMandatory','iSLA','vModule','next_step');
		$grid->addFields('idplc2_biz_process','idplc2_activity','iteam_id','vModule');
		// $grid->setLabel('iSLA', 'SLA (Hari)'); //Ganti Label
		// $grid->setLabel('iSequence', 'Sequence'); //Ganti Label
		// $grid->setLabel('cUsedLogic','Logic');
		 $grid->setLabel('iteam_id','Stakeholder Stucture');
		$grid->setLabel('idplc2_activity','Activity');
		// $grid->setLabel('iDependOnStep','Dependen Before');
		// $grid->setLabel('isMandatory','Mandatory');
		 $grid->setLabel('vModule','Module');
		$grid->setLabel('idplc2_biz_process','Bussiness Proccess');
		$grid->setSearch('idplc2_biz_process','idplc2_activity','iteam_id');
		// $grid->setRequired('idplc2_biz_process','idplc2_activity','iteam_id','iSequence','isMandatory','iSLA');
		$grid->setRequired('idplc2_biz_process','idplc2_activity','iteam_id');
		$grid->setRelation('idplc2_activity', 'plc2.plc2_activity', 'idplc2_activity', 'vActivityName');
		$grid->setRelation('iteam_id', 'plc2.plc2_upb_team', 'iteam_id', 'vteam','divStruktur');
		$grid->setRelation('vModule', 'erp_privi.privi_modules', 'idprivi_modules', 'vNameModule','','left','idprivi_apps=5');
		$grid->changeFieldType('tCreatedAt','hidden');
		$grid->changeFieldType('cCreatedBy','hidden');
		$grid->changeFieldType('tUpdatedAt','hidden');
		$grid->changeFieldType('cUpdatedBy','hidden');
		// $grid->changeFieldType('isMandatory','combobox', '', array(0=>'No', 1=>'Yes'));
		
		$grid->searchOperand('idplc2_biz_process', 'eq');
		
		// $grid->changeSearch('iSLA','between');
		$grid->setQuery('plc2_biz_process_sub.lDeleted', 0);		
		//$grid->setRelation('idplc_div', 'div', 'idplc_div', 'vCode','DivName','inner');
		
		//Set View Gridnya (Default = grid)
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
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'delete':
				echo $grid->delete_row();
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				echo $grid->updated_form();
				break;
			default:
				$grid->render_grid();
				break;
		}
    }
	function get_action() {
		$id = $this->input->post('sub_id');
		$this->db_plc0->where('idplc_biz_process_sub', $id);
		$acs = $this->db_plc0->get('plc_biz_process_sub')->row_array();
		$act_id = $acs['idplc_activity'];
		
		$this->db_plc0->where('idplc_activity', $act_id);
		$stats = $this->db_plc0->get('plc_status')->result_array();
		$echo = '<select class="" name="action[]">';
		$echo .= '<option value="">-- None --</option>';
		foreach($stats as $s) {
			$echo .= '<option value="'.$s['idplc_status'].'">'.$s['vCaption'].'</option>';
		}
		$echo .= '</select>';
		$response['status'] = TRUE;
		$response['source'] = $echo;
		echo json_encode($response);
	}
	function listBox_master_bisnis_proses_sub_idplc2_biz_process($value, $id, $column, $row) {
		//return $value;
		$sql = "SELECT b.idplc2_biz_process, t.vName, s.vStepName FROM plc2.plc2_biz_process b
				INNER JOIN plc2.plc2_biz_process_type t ON b.idplc2_biz_process_type=t.idplc2_biz_process_type
				INNER JOIN plc2.plc2_biz_has_steps s ON b.idplc2_biz_has_steps=s.idplc2_biz_has_steps
				WHERE s.isDeleted = 0 AND b.idplc2_biz_process = '".$value."'
				";
		$row = $this->db_plc0->query($sql)->row_array();
		return $row['vName'].' > '.$row['vStepName'].' ('.$value.')';
	}
	function searchBox_master_bisnis_proses_sub_idplc2_biz_process($fields, $id) {
		$sql = "SELECT b.idplc2_biz_process, t.vName, s.vStepName FROM plc2.plc2_biz_process b
				INNER JOIN plc2.plc2_biz_process_type t ON b.idplc2_biz_process_type=t.idplc2_biz_process_type
				INNER JOIN plc2.plc2_biz_has_steps s ON b.idplc2_biz_has_steps=s.idplc2_biz_has_steps
				WHERE s.isDeleted = 0 ORDER BY b.idplc2_biz_process_type ASC, b.iUrutan ASC
				";
		$rows = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="combobox" id="'.$id.'">';
		$echo .= '<option value="">-- None --</option>';
		foreach($rows as $r) {
			$echo .= '<option value="'.$r['idplc2_biz_process'].'">'.$r['vName'].' > '.$r['vStepName'].'('.$r['idplc2_biz_process'].')</option>';
		}
		$echo .= '</select>';
		//return $this->db_plc0->last_query();
		return $echo;
	}
	
	// function insertBox_master_bisnis_proses_sub_next_step($field, $id) {
		// return 'Save Records first';
		// /*$data['logics'] = $this->grid->get_enum_values('effect_action','cUsedLogic');
		// $sql = "SELECT bps.idplc_biz_process_sub, a.vActivityName, d.vCode, b.idplc_biz_process, t.vName, s.vStepName FROM ".$this->db_plc0->dbprefix('biz_process_sub')." bps
				// INNER JOIN ".$this->db_plc0->dbprefix('activity')." a ON bps.idplc_activity=a.idplc_activity
				// INNER JOIN ".$this->db_plc0->dbprefix('div_structure')." d ON bps.idplc_div_structure=d.idplc_div_structure
				// INNER JOIN ".$this->db_plc0->dbprefix('biz_process')." b ON bps.idplc_biz_process=b.idplc_biz_process
				// INNER JOIN ".$this->db_plc0->dbprefix('biz_process_type')." t ON b.idplc_biz_process_type=t.idplc_biz_process_type
				// INNER JOIN ".$this->db_plc0->dbprefix('biz_has_steps')." s ON b.idplc_biz_has_steps=s.idplc_biz_has_steps
				// WHERE b.isDeleted = 0 ORDER BY b.idplc_biz_process_type ASC, b.iUrutan ASC
				// ";
		// $rows = $this->db_plc0->query($sql)->result_array();
		// $echo = '<select onChange="javascript:getStatusByActivity(this)" class=" effected_proses" name="sub_proses[]">';
		// $echo .= '<option value="">-- None --</option>';
		// foreach($rows as $r) {
			// $echo .= '<option value="'.$r['idplc_biz_process_sub'].'">'.$r['vName'].' > '.$r['vStepName'].' > '.$r['vActivityName'].' ('.$r['vCode'].')</option>';
		// }
		// $echo .= '</select>';
		// $data['sub_proses'] = $echo;
		// return $this->load->view('effected',$data,TRUE);*/
	// }
	// function updateBox_master_bisnis_proses_sub_next_step($field, $id, $value, $rowData) {
		// //print_r($rowData); exit;
		// $data['logics'] = $this->grid->get_enum_values('plc2.plc2_effect_action','cUsedLogic');
		// $sql = "SELECT bps.idplc2_biz_process_sub, a.vActivityName, d.vteam, d.vtipe, b.idplc2_biz_process, t.vName, s.vStepName FROM plc2.plc2_biz_process_sub bps
				// INNER JOIN plc2.plc2_activity a ON bps.idplc2_activity=a.idplc2_activity
				// INNER JOIN plc2.plc2_upb_team d ON bps.iteam_id=d.iteam_id
				// INNER JOIN plc2.plc2_biz_process b ON bps.idplc2_biz_process=b.idplc2_biz_process
				// INNER JOIN plc2.plc2_biz_process_type t ON b.idplc2_biz_process_type=t.idplc2_biz_process_type
				// INNER JOIN plc2.plc2_biz_has_steps s ON b.idplc2_biz_has_steps=s.idplc2_biz_has_steps
				// WHERE b.isDeleted = 0 ORDER BY b.idplc2_biz_process_type ASC, b.iUrutan ASC
				// ";
		// $rows = $this->db_plc0->query($sql)->result_array();
		// //$echo = '<select onChange="javascript:getStatusByActivity(this)" class=" effected_proses" name="sub_proses[]">';		
		// $data['rows'] = $rows;
		// $this->db_plc0->where('idplc2_activity',$rowData['idplc2_activity']);
		// $data['actions'] = $this->db_plc0->get('plc2.plc2_status')->result_array();
		// $this->db_plc0->where('idplc2_biz_process_sub', $rowData['idplc2_biz_process_sub']);
		// $data['effecs_proses'] = $this->db_plc0->get('plc2.plc2_effect_action')->result_array();
		// return $this->load->view('master_bisnis_proses_sub_effected_edit',$data,TRUE);
	// }
	
	// function insertBox_master_bisnis_proses_sub_iDependOnStep($field, $id) {
		// $sql = "SELECT bps.idplc2_biz_process_sub, a.vActivityName, d.vteam, b.idplc2_biz_process, t.vName, s.vStepName FROM plc2.plc2_biz_process_sub bps
				// INNER JOIN plc2.plc2_activity a ON bps.idplc2_activity=a.idplc2_activity
				// INNER JOIN plc2.plc2_upb_team d ON bps.iteam_id=d.iteam_id
				// INNER JOIN plc2.plc2_biz_process b ON bps.idplc2_biz_process=b.idplc2_biz_process
				// INNER JOIN plc2.plc2_biz_process_type t ON b.idplc2_biz_process_type=t.idplc2_biz_process_type
				// INNER JOIN plc2.plc2_biz_has_steps s ON b.idplc2_biz_has_steps=s.idplc2_biz_has_steps
				// WHERE b.isDeleted = 0 ORDER BY b.idplc2_biz_process_type ASC, b.iUrutan ASC
				// ";
		// $rows = $this->db_plc0->query($sql)->result_array();
		// $echo = '<select class="chosen" multiple name="'.$id.'[]" id="'.$id.'" data-placeholder="Choose Proses">';
		// $echo .= '<option value="">-- None --</option>';
		// foreach($rows as $r) {
			// $echo .= '<option value="'.$r['idplc2_biz_process_sub'].'">'.$r['vName'].' > '.$r['vStepName'].' > '.$r['vActivityName'].' ('.$r['vteam'].')</option>';
		// }
		// $echo .= '</select>';
		// //return $this->db_plc0->last_query();
		// return $echo;
	// }
	// function updateBox_master_bisnis_proses_sub_iDependOnStep($field, $id, $value, $rowData) {
		// $sql = "SELECT bps.idplc2_biz_process_sub, a.vActivityName, d.vteam, b.idplc2_biz_process, t.vName, s.vStepName FROM plc2.plc2_biz_process_sub bps
				// INNER JOIN plc2.plc2_activity a ON bps.idplc2_activity=a.idplc2_activity
				// INNER JOIN plc2.plc2_upb_team d ON bps.iteam_id=d.iteam_id
				// INNER JOIN plc2.plc2_biz_process b ON bps.idplc2_biz_process=b.idplc2_biz_process
				// INNER JOIN plc2.plc2_biz_process_type t ON b.idplc2_biz_process_type=t.idplc2_biz_process_type
				// INNER JOIN plc2.plc2_biz_has_steps s ON b.idplc2_biz_has_steps=s.idplc2_biz_has_steps
				// WHERE b.isDeleted = 0 ORDER BY b.idplc2_biz_process_type ASC, b.iUrutan ASC
				// ";
		// $rows = $this->db_plc0->query($sql)->result_array();
		
		// $new_vals = explode(',', $value);
		
		// $echo = '<select class="chosen" multiple name="'.$field.'[]" id="'.$id.'" data-placeholder="Choose Proses">';
		// $echo .= '<option value="">-- None --</option>';
		// foreach($rows as $r) {
			// $selected = in_array($r['idplc2_biz_process_sub'], $new_vals) ? 'selected' : '';
			// $echo .= '<option '.$selected.' value="'.$r['idplc2_biz_process_sub'].'">'.$r['vName'].' > '.$r['vStepName'].' > '.$r['vActivityName'].' ('.$r['vteam'].')</option>';
		// }
		// $echo .= '</select>';
		// //return $this->db_plc0->last_query();
		// return $echo;
	// }
	function insertBox_master_bisnis_proses_sub_idplc2_biz_process($field, $id) {
		$sql = "SELECT b.idplc2_biz_process, t.vName, s.vStepName FROM plc2.plc2_biz_process b
				LEFT JOIN plc2.plc2_biz_process_type t ON b.idplc2_biz_process_type=t.idplc2_biz_process_type
				LEFT JOIN plc2.plc2_biz_has_steps s ON b.idplc2_biz_has_steps=s.idplc2_biz_has_steps
				WHERE s.isDeleted = 0 ORDER BY b.idplc2_biz_process_type ASC, b.iUrutan ASC
				";
		$rows = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="combobox" name="'.$id.'" id="'.$id.'">';
		$echo .= '<option value="">-- None --</option>';
		foreach($rows as $r) {
			$echo .= '<option value="'.$r['idplc2_biz_process'].'">'.$r['vName'].' > '.$r['vStepName'].'</option>';
		}
		$echo .= '</select>';
		//return $this->db_plc0->last_query();
		return $echo;
	}
	function updateBox_master_bisnis_proses_sub_idplc2_biz_process($field, $id, $value, $rowData) {
		$sql = "SELECT b.idplc2_biz_process, t.vName, s.vStepName FROM plc2.plc2_biz_process b
				LEFT JOIN plc2.plc2_biz_process_type t ON b.idplc2_biz_process_type=t.idplc2_biz_process_type
				LEFT JOIN plc2.plc2_biz_has_steps s ON b.idplc2_biz_has_steps=s.idplc2_biz_has_steps
				WHERE b.isDeleted = 0 ORDER BY b.idplc2_biz_process_type ASC, b.iUrutan ASC
				";
		$rows = $this->db_plc0->query($sql)->result_array();
		$echo = '<select class="combobox" name="'.$id.'" id="'.$id.'">';
		$echo .= '<option value="">-- None --</option>';
		foreach($rows as $r) {
			$selected = $r['idplc2_biz_process'] == $value ? 'selected' : '';
			$echo .= '<option '.$selected.' value="'.$r['idplc2_biz_process'].'">'.$r['vName'].' > '.$r['vStepName'].'</option>';
		}
		$echo .= '</select>';
		//return $this->db_plc0->last_query();
		return $echo;
	}
	// function before_insert_processor ($row, $postData) {
		
		// if(!isset($postData['iDependOnStep'])) {
			// return $postData;
		// }
		// else {
			// $depend = $postData['iDependOnStep'];
			// $new_depend = '';
			// $i=1;
			// foreach($depend as $k => $d) {
				// if($i == count($depend)) {
					// $new_depend .=$d;
				// }
				// else {
					// $new_depend .=$d.',';
				// }			
				// $i++;
			// }
			// $postData['iDependOnStep'] = $new_depend;
			// return $postData;
		// }
	// }
	// function before_update_processor ($row, $postData, $newUpdateData) {
	// //	print_r($postData);
		// unset($postData['action']);
		// unset($postData['sub_proses']);
		// unset($postData['logic']);
		// unset($postData['alert']);
		// if(!(is_array($postData['iDependOnStep']))) {
		// //if(!isset($postData['iDependOnStep'])) {
			// $postData['iDependOnStep'] = 0;
			// return $postData;
		// }
		// else {
			// //echo "ss";
			// $depend = $postData['iDependOnStep'];
			// $new_depend = '';
			// $i=1;
			// foreach($depend as $k => $d) {
				// if($i == count($depend)) {
					// $new_depend .=$d;
				// }
				// else {
					// $new_depend .=$d.',';
				// }
				// $i++;
			// }
			// $postData['iDependOnStep'] = $new_depend; 
			// return $postData;
		// }
		//print_r($postData); exit;
		//exit;
		/* unset($newUpdateData['action']);
		unset($newUpdateData['sub_proses']);
		unset($newUpdateData['logic']);
		unset($newUpdateData['alert']);
		if(!isset($newUpdateData['iDependOnStep'])) {
			$newUpdateData['iDependOnStep'] = 0;
			return $newUpdateData;
		}
		else {
			$depend = $newUpdateData['iDependOnStep'];
			$new_depend = '';
			$i=1;
			foreach($depend as $k => $d) {
				if($i == count($depend)) {
					$new_depend .=$d;
				}
				else {
					$new_depend .=$d.',';
				}			
				$i++;
			}
			$newUpdateData['iDependOnStep'] = $new_depend;
			return $newUpdateData;
		} */
		
		//print_r($postData); exit;
	// }
	// function after_update_processor ($row, $updateId, $postData, $old_data) {
		// //print_r($postData); exit;
		
		// $action = $postData['action'];
		// $effected = $postData['sub_proses'];
		// $logic = $postData['logic'];
		// $alert = $postData['alert'];
		
		// unset($postData['action']);
		// unset($postData['sub_proses']);
		// unset($postData['logic']);
		// unset($postData['alert']);
		
		// $this->db_plc0->where('idplc2_biz_process_sub', $updateId);
		// if($this->db_plc0->delete('plc2.plc2_effect_action')) {
			// foreach($action as $k => $v) {
				// $ins = array(
						// 'idplc2_biz_process_sub'=>$updateId,
						// 'iAffectedProcess'=>$effected[$k],
						// 'idplc2_status'=>$v,
						// 'cUsedLogic'=>$logic[$k],
						// 'isSendAlert'=>$alert[$k],
				// );
				// $this->db_plc0->insert('plc2.plc2_effect_action', $ins);
			// }
		// }		
	// }
	function output(){
    	$this->index($this->input->get('action'));
    }
}