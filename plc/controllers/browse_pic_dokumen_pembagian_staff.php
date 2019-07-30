<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_pic_dokumen_pembagian_staff extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->load->library('lib_utilitas');
		$this->dbset = $this->load->database('plc', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth->user();
		$this->_field = $this->input->get('field');
		$this->_get = $this->input->get('gr');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Daftar User PIC');
		//dc.m_vendor  database.tabel
		$grid->setTable('plc2.plc2_upb_team_item');		
		$grid->setUrl('browse_pic_dokumen_pembagian_staff');
		$grid->addList('pilih','vnip','employee.vName');
		$grid->setSortBy('employee.cNip');
		$grid->setSortOrder('DESC'); //sort ordernya

		//setting widht grid
		$grid ->setWidth('vUpd_no', '100'); 
		//modif label
		$grid->setLabel('vUpd_no','No UPD');

		$grid->setSearch('vnip','employee.vName');
		$grid->setGroupBy('vnip');

		$grid->setAlign('pilih', 'center');
		$grid->setLabel('employee.vName', 'Nama');
		$grid->setLabel('vnip', 'NIP');
		$grid->setInputGet('field',$this->_field);
		$grid->setInputGet('group',$this->_get);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setWidth('pilih', '25');	

		$grid->setJoinTable('hrd.employee', 'employee.cNip = plc2_upb_team_item.vnip', 'inner');
		$grid->setQuery('employee.cNip in (select ite.vnip from plc2.plc2_upb_team_item ite
							inner join plc2.plc2_upb_team te on ite.iteam_id=te.iteam_id
							where ite.ldeleted=0 and te.ldeleted=0 and te.vtipe="'.$this->input->get('group').'")',NULL);
		/*if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array($this->input->get('group'), $manager)){
				$type=$this->input->get('group');
				$grid->setQuery('employee.cNip in (select ite.vnip from plc2.plc2_upb_team_item ite
							inner join plc2.plc2_upb_team te on ite.iteam_id=te.iteam_id
							where ite.ldeleted=0 and te.ldeleted=0 and te.vnip="'.$this->user->gNIP.'")',NULL);
			}
			else{$type='';
				$grid->setQuery('employee.cNip in ("'.$this->input->get('group').'")',NULL);
			}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array($this->input->get('group'), $team)){
				$type=$this->input->get('group');
				$grid->setQuery('plc2_upb_team_item.iteam_id in (select ite.iteam_id from plc2.plc2_upb_team_item ite
							where ite.ldeleted=0 and ite.vnip="'.$this->user->gNIP.'")',NULL);
			}
			else{$type='';}
		}*/
		
		//Set View Gridnya (Default = grid)
		$grid->setGridView('grid');

		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			default:
				$grid->render_grid();
				break;
		}
    }

	function output(){
    	$this->index($this->input->get('action'));//test komen
    }

	function listBox_browse_pic_dokumen_pembagian_staff_pilih($value, $pk, $name, $rowData) { 
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upd_prio('.$pk.',\''.$rowData->vnip.'\',\''.$rowData->employee__vName.'\') ;" />';
		$o .= '<script type="text/javascript">
					function pilih_upd_prio (id, vnip, employee) {					
						custom_confirm("Yakin", function() {

						$("#'.$this->input->get("field").'_dis").val(vnip+"-"+employee);
						$("#'.$this->input->get("field").'").val(vnip);
						$("#alert_dialog_form").dialog("close");


						});
					}
				</script>';

		return $o;
	}
}

