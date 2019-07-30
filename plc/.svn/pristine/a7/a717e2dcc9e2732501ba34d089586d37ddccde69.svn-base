<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_upb_draft_soi extends MX_Controller {
	private $sess_auth;
	private $dbset;
	private $_id = 0;
	private $_iDeptId = 0;
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
        $this->sess_auth = new Zend_Session_Namespace('auth');
        $this->dbset = $this->load->database('plc', true);  
		$this->_field = $this->input->get('field');
    }
    function index($action = '') {
    	$action = $this->input->get('action');
		
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('Bahan Baku');		
		$grid->setTable('plc2.plc2_upb_request_sample_detail');		
		$grid->setUrl('browse_upb_draft_soi');
		$grid->addList('pilih','plc2_upb_request_sample.vreq_nomor','plc2_upb_po.vpo_nomor','plc2_upb_ro.vro_nomor','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_raw_material.vnama','ijumlah','plc2_upb.iupb_id','plc2_upb_team.vteam','plc2_upb.vgenerik');
		$grid->setSortBy('ireqdet_id');
		$grid->setSortOrder('ASC'); //sort ordernya
		

		$grid->setLabel('plc2_upb_request_sample.vreq_nomor', 'Nomor Request'); //Ganti Label
        $grid->setAlign('plc2_upb_request_sample.vreq_nomor', 'center'); //Align nya
        $grid->setWidth('plc2_upb_request_sample.vreq_nomor', '80'); // width nya      

        $grid->setLabel('plc2_upb_po.vpo_nomor', 'No PO'); //Ganti Label
        $grid->setAlign('plc2_upb_po.vpo_nomor', 'center'); //Align nya
        $grid->setWidth('plc2_upb_po.vpo_nomor', '80'); // width nya  
        $grid->setWidth('plc2_upb_po.iupb_id', '-80'); // width nya  
        $grid->setWidth('plc2_upb.iupb_id', '-80'); // width nya  
        $grid->setWidth('plc2_upb_team.vteam', '-80'); // width nya 
        $grid->setWidth('plc2_upb.vgenerik', '-80'); // width nya 
        

        $grid->setLabel('plc2_upb_ro.vro_nomor', 'No Penerimaan'); //Ganti Label
        $grid->setAlign('plc2_upb_ro.vro_nomor', 'center'); //Align nya
        $grid->setWidth('plc2_upb_ro.vro_nomor', '80'); // width nya  


        $grid->setLabel('plc2_raw_material.vnama', 'Nama Bahan baku'); //Ganti Label
        $grid->setAlign('plc2_raw_material.vnama', 'left'); //Align nya
        $grid->setWidth('plc2_raw_material.vnama', '200'); // width nya  

        $grid->setLabel('plc2_upb.vupb_nomor', 'No UPB'); //Ganti Label
        $grid->setAlign('plc2_upb.vupb_nomor', 'center'); //Align nya
        $grid->setWidth('plc2_upb.vupb_nomor', '50'); // width nya  

        $grid->setLabel('plc2_upb.vupb_nama', 'Nama UPB'); //Ganti Label
        $grid->setAlign('plc2_upb.vupb_nama', 'left'); //Align nya
        $grid->setWidth('plc2_upb.vupb_nama', '200'); // width nya  


        $grid->setLabel('ijumlah', 'Jumlah'); //Ganti Label
        $grid->setAlign('ijumlah', 'left'); //Align nya
        $grid->setWidth('ijumlah', '50'); // width nya  
       
       	$grid->setWidth('pilih', '25'); // width nya  
		$grid->setAlign('pilih', 'center'); //Align nya

		$grid->addFields('cNip', 'vName', 'pilih');
		$grid->setSearch('plc2_upb_request_sample.vreq_nomor','plc2_upb_po.vpo_nomor','plc2_upb_ro.vro_nomor','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_raw_material.vnama');
		
		$grid->setJoinTable('plc2.plc2_upb_request_sample', 'plc2_upb_request_sample.ireq_id = plc2_upb_request_sample_detail.ireq_id', 'inner');
        $grid->setJoinTable('plc2.plc2_upb_ro_detail', 'plc2_upb_ro_detail.ireq_id = plc2_upb_request_sample_detail.ireq_id and plc2_upb_ro_detail.raw_id = plc2_upb_request_sample_detail.raw_id  ' , 'inner');
        $grid->setJoinTable('plc2.plc2_upb_po', 'plc2_upb_po.ipo_id = plc2_upb_ro_detail.ipo_id', 'inner');
        $grid->setJoinTable('plc2.plc2_upb_ro', 'plc2_upb_ro.iro_id = plc2_upb_ro_detail.iro_id', 'inner');
        $grid->setJoinTable('plc2.plc2_raw_material', 'plc2_raw_material.raw_id = plc2_upb_request_sample_detail.raw_id', 'inner');
        $grid->setJoinTable('plc2.plc2_upb', 'plc2_upb.iupb_id = plc2_upb_request_sample.iupb_id', 'inner');
        $grid->setJoinTable('plc2.plc2_upb_team', 'plc2_upb_team.iteam_id = plc2_upb.iteampd_id', 'inner');
     //   $grid->setRelation('plc2.plc2_upb.iteampd_id', 'plc2.plc2_upb_team', 'iteam_id', 'vteam','pdTeamName','inner',array('vtipe'=>'PD', 'ldeleted'=>0));

		//membutuhkan uji mikro 
		$grid->setQuery('plc2.plc2_upb_ro_detail.irelease', 2);
		// QA sudah terima bahan baku sample
		//$grid->setQuery('plc2.plc2_upb_ro_detail.trec_date_qa is not null', null);
		

		$grid->setInputGet('field',$this->_field);
		
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
	

	function listBox_browse_upb_draft_soi_pilih($value, $pk, $name, $rowData) {
		$url_header = base_url()."processor/plc/draft/soi/bb/?action=getdetilupb"; 
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail('.$pk.',\''.$rowData->plc2_upb_request_sample__vreq_nomor.'\',\''.$rowData->plc2_upb_po__vpo_nomor.'\',\''.$rowData->plc2_upb_ro__vro_nomor.'\',\''.$rowData->plc2_raw_material__vnama.'\',\''.$rowData->plc2_upb__vupb_nomor.'\',\''.$rowData->plc2_upb__vupb_nama.'\',\''.$rowData->plc2_upb__iupb_id.'\',\''.$rowData->plc2_upb_team__vteam.'\',\''.$rowData->plc2_upb__vgenerik.'\') ;" />';
		$o .='<script type="text/javascript">
		function pilih_upb_detail (id, reqno,pono,recno,nmmatr,noupb,nmupb,iupb_id,timpd,vgenerik){		
			custom_confirm("Yakin ?", function(){
				$("#'.$this->input->get('field').'_ireqdet_id").val(id);
				$("#'.$this->input->get('field').'_ireqdet_id_dis").val(reqno+" - "+nmmatr);
			
				$("#'.$this->input->get('field').'_iupb_id").val(iupb_id);
				$("#'.$this->input->get('field').'_iupb_id_dis").val(noupb);

				
				$("#'.$this->input->get('field').'_vupb_nama").val(nmupb);
				$("#'.$this->input->get('field').'_vgenerik").val(vgenerik);
				$("#'.$this->input->get('field').'_team_pd").val(timpd);
				
				

				$("#alert_dialog_form").dialog("close");
			});
		}
		</script>';
		return $o;
	}
/*
	function listBox_Browse_upb_draft_soi_pilih($value, $pk, $name, $rowData) {
		$url_header = base_url()."processor/plc/draft/soi/bb/?action=getdetilupb"; 
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_spek_fg('.$pk.',\''.$rowData->vupb_nomor.'\',\''.$rowData->vupb_nama.'\',\''.$rowData->vgenerik.'\',\''.$rowData->pdTeamName.'\') ;" />
		<script type="text/javascript">
		function pilih_upb_spek_fg (id, vupb_nomor, vupb_nama, vgenerik, pdTeam){					
			custom_confirm("Yakin ?", function(){
				$("#'.$this->input->get('field').'_iupb_id").val(id);
				$("#'.$this->input->get('field').'_iupb_id_dis").val(vupb_nomor);
				$("#'.$this->input->get('field').'_vupb_nama").val(vupb_nama);
				$("#'.$this->input->get('field').'_vupb_nama").text(vupb_nama);
				$("#'.$this->input->get('field').'_vgenerik").val(vgenerik);
				$("#'.$this->input->get('field').'_vgenerik").text(vgenerik);
				$("#'.$this->input->get('field').'_iteampd_id").val(pdTeam);
				$("#'.$this->input->get('field').'_iteampd_id").text(pdTeam);

				return $.ajax({
				url: "'.$url_header.'",
				type: "post",
				data: {
						upb_id: id,
						},
				beforeSend: function(){

				},
				success: function(data){
					$("#draft_soi_bb_team_pd").val(pdTeam);
					
					$("#alert_dialog_form").dialog("close");
				},
				}).responseText;

				$("#alert_dialog_form").dialog("close");
			});
		}
		</script>';
		return $o;
	}
*/
}
