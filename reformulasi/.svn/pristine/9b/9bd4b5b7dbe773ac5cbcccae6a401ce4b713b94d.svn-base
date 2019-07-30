<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_dossier_upd extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
        $this->load->library('auth_export');
        $this->user = $this->auth_export->user();
        $this->arrEmployee = array(); 
        $this->arrEmployeeUpper = array();

		$this->_field = $this->input->get('field');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('Request dossier export');
        $grid->setTable('dossier.dossier_upd');   	
		$grid->setUrl('browse_dossier_upd');
		$grid->addList('pilih','vUpd_no','vNama_usulan','iupb_id','itemas.c_itnam'); 
        $grid->setSortBy('idossier_upd_id');
        $grid->setSortOrder('asc');  

		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setWidth('pilih', '55');
		$grid->setAlign('pilih', 'center');
		$grid->setSearch('vUpd_no','vNama_usulan','iupb_id','itemas.c_itnam');

		$grid->setWidth('vUpd_no', '100');
        $grid->setAlign('vUpd_no', 'center');
        $grid->setLabel('vUpd_no','No UPD');
    
        $grid->setWidth('vNama_usulan', '200');
        $grid->setAlign('vNama_usulan', 'left');
        $grid->setLabel('vNama_usulan','Nama Usulan');
    
        $grid->setWidth('iupb_id', '100');
        $grid->setAlign('iupb_id', 'left');
        $grid->setLabel('iupb_id','Kode Product');
        
        $grid->setWidth('itemas.c_itnam', '200');
        $grid->setAlign('itemas.c_itnam', 'center');
        $grid->setLabel('itemas.c_itnam','Product Existing'); 

        $grid->setJoinTable('sales.itemas', 'itemas.c_iteno = dossier_upd.iupb_id', 'inner');
         
        $grid->setQuery('dossier_upd.lDeleted',0);
        $grid->setQuery('dossier_upd.iSubmit_upd',1);
        $grid->setQuery('itemas.lDeleted',0);
 
        $grid->setSortOrder('DESC');  



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
 

	function listBox_browse_dossier_upd_pilih($value, $pk, $name, $rowData) { 

        $itname = "SELECT i.`c_itnam` FROM sales.`itemas` i WHERE i.`lDeleted` = 0 AND i.`c_iteno` = '".$rowData->iupb_id."'";
        $c_itnam = $this->db->Query($itname)->row_array();
        $citno = $rowData->iupb_id;
        if(!empty($c_itnam['c_itnam'])){
             $citno .= '-'.$c_itnam['c_itnam'];
        }  

		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail('.$pk.',\''.$rowData->vUpd_no.'\',
				\''.$rowData->vNama_usulan.'\',\''.$citno.'\') ;" />
			  <script type="text/javascript">
				function pilih_upb_detail (id, vUpd_no, vNama_usulan, c_iteno){					
					custom_confirm("Yakin ?", function(){
						$(".'.$this->input->get('field').'_vUpd_no").val(vUpd_no); 
                        $(".'.$this->input->get('field').'_idossier_upd_id").val(id);  
                        $(".'.$this->input->get('field').'_vNama_usulan").text(vNama_usulan);  
                        $(".'.$this->input->get('field').'_c_iteno").text(c_iteno);  
						$("#alert_dialog_form").dialog("destroy");
					});
				}
			  </script>';
		return $o;
	}
}
