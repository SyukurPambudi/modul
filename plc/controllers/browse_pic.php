<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_pic extends MX_Controller {
	private $sess_auth;
	private $dbset;
	private $_id = 0;
	private $_iDeptId = 0;
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
        $this->sess_auth = new Zend_Session_Namespace('auth');
        $this->dbset = $this->load->database('hrd', true);  
		$this->_tipe = $this->input->get('type');      
		$this->_ix = $this->input->get('ix');
		$this->_field = $this->input->get('field');
		$this->load->library('auth');
    }
    function index($action = '') {
    	$action = $this->input->get('action');
		
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('Employee');		
		$grid->setTable('hrd.employee');		
		$grid->setUrl('browse_pic');
		$grid->addList('cNip', 'vName', 'pilih');
		$grid->setSortBy('cNip');
		$grid->setSortOrder('ASC'); //sort ordernya
		$grid->setAlign('cNip', 'left'); //Align nya
		$grid->setWidth('cNip', '100'); 
		$grid->setAlign('vName', 'left'); //Align nya
		$grid->setWidth('vName', '650'); 
		$grid->setWidth('pilih', '30'); // width nya
		$grid->setAlign('pilih', 'center'); // align nya
		//$grid->addFields('id', 'idga_mstype', 'idga_msservis','iBufferStock', 'iMaxStock');
		$grid->addFields('cNip', 'vName', 'pilih');
		$grid->setLabel('cNip', 'NIP'); //Ganti Label
		$grid->setLabel('vName', 'Nama Employee'); //Ganti Label
		$grid->setSearch('cNip','vName');
		
		//belum resign
		$grid->setQuery('hrd.employee.dResign', '0000-00-00');
		$grid->setQuery('hrd.employee.iCompanyID in (2,3,4,5,7)', null);

		$grid->setInputGet('field',$this->_field);
		$grid->setInputGet('pic_for', $this->input->get('pic_for'));
		$grid->setInputGet('idfield', $this->input->get('idfield'));

		$pic_for=$_GET['pic_for'];
		
		
		if ($pic_for=='uji_mikro_bb') {
			//uji mikro BB , employee QA
			$grid->setQuery('iDepartementID',89);
			$grid->setQuery('iDivisionID',2);
		}else if($pic_for=='draft_soi_bb'){
			//$grid->setJoinTable('plc2.plc2_upb_team', 'plc2_upb.iupb_id = draft_soi_bb.iupb_id', 'inner');

			if($this->auth->is_manager()){
				$x=$this->auth->dept();
				$manager=$x['manager'];
				if(in_array('PD', $manager)){
					$type='PD';
					$grid->setQuery('cNip IN ( select a.cNip 
									from hrd.employee a 
									join plc2.plc2_upb_team_item b on b.vnip = a.cNip
									join plc2.plc2_upb_team c on c.iteam_id=b.iteam_id
									where b.ldeleted=0
									and c.ldeleted=0
									and a.dresign="0000-00-00"
									and c.iteam_id IN(
									'.$this->auth->my_teams().') ) ', null);
				}
				else{$type='';}
			}
			else{
				$x=$this->auth->dept();
				$team=$x['team'];
				if(in_array('PD', $team)){
					$type='PD';
					$grid->setQuery('cNip IN ( select a.cNip 
									from hrd.employee a 
									join plc2.plc2_upb_team_item b on b.vnip = a.cNip
									join plc2.plc2_upb_team c on c.iteam_id=b.iteam_id
									where b.ldeleted=0
									and c.ldeleted=0
									and a.dresign="0000-00-00"
									and c.iteam_id IN(
									'.$this->auth->my_teams().') ) ', null);
				}
				else{$type='';}
			}


		}
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
			case 'view':
				$grid->render_form($this->input->get('id'), true);
				break;
			case 'updateproses':
				echo $grid->updated_form();
				break;
			case 'getlaststock':
				$this->getlaststok();
				break;
			default:
				$grid->render_grid();
				break;
		}
    }
	public function output(){
		$this->index($this->input->get('action'));
	}	
	



	function listBox_browse_pic_pilih($value, $pk, $name, $rowData) {
		$idfield=$this->input->get('idfield');
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail('.$pk.',\''.$rowData->cNip.'\',\''.$rowData->vName.'\') ;" />';
		$o .='<script type="text/javascript">
		function pilih_upb_detail (id, nip, nama){		
			custom_confirm("Yakin ?", function(){
				$("#'.$this->input->get('field').'_'.$idfield.'").val(nip);
				$("#'.$this->input->get('field').'_'.$idfield.'_dis").val(nip+" - "+nama);

				$("#alert_dialog_form").dialog("close");
			});
		}
		</script>';
		return $o;
	}


}