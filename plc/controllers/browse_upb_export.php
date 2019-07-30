<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Browse_upb_export extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_plcexport');
		$this->_field = $this->input->get('field');
		$this->dbset = $this->load->database('plc', true);
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('Produk');
		//dc.m_vendor  database.tabel
		$grid->setTable('plc2.itemas');		
		$grid->setUrl('browse_upb_export');
		$grid->addList('pilih','C_ITENO','C_ITNAM','tabmas02.c_nmlisen','teamc.c_desc','C_UNDES','N_HET','stocknpl.n_hna','D_LAUNCH','C_STATUS');
		$grid->setSortBy('C_ITNAM');
		$grid->setSortOrder('asc');

		//setting widht grid
		
		$grid->setLabel('C_ITENO','Kode Produk'); 
		$grid ->setWidth('C_ITENO', '80'); 
		$grid->setAlign('C_ITENO', 'left'); 

		$grid->setLabel('C_ITNAM','Nama Produk'); 
		$grid ->setWidth('C_ITNAM', '200'); 
		$grid->setAlign('C_ITNAM', 'left'); 

		$grid->setLabel('tabmas02.c_nmlisen','Lisensi'); 
		$grid->setLabel('c_nmlisen','Lisensi'); 
		$grid ->setWidth('tabmas02.c_nmlisen', '200'); 
		$grid->setAlign('tabmas02.c_nmlisen', 'left'); 

		$grid->setLabel('teamc.c_desc','Team'); 
		$grid->setLabel('c_desc','Team'); 
		$grid ->setWidth('teamc.c_desc', '100'); 
		$grid->setAlign('teamc.c_desc', 'left'); 

		$grid->setLabel('C_UNDES','Unit'); 
		$grid ->setWidth('C_UNDES', '100'); 
		$grid->setAlign('C_UNDES', 'left'); 

		$grid->setLabel('N_HET','HET'); 
		$grid ->setWidth('N_HET', '80'); 
		$grid->setAlign('N_HET', 'right'); 

		$grid->setLabel('stocknpl.n_hna','HNA'); 
		$grid->setLabel('n_hna','HNA'); 
		$grid ->setWidth('stocknpl.n_hna', '80'); 
		$grid->setAlign('stocknpl.n_hna', 'right'); 

		$grid->setLabel('D_LAUNCH','Tgl Launching'); 
		$grid ->setWidth('D_LAUNCH', '100'); 
		$grid->setAlign('D_LAUNCH', 'left'); 

		$grid->setLabel('C_STATUS','Status'); 
		$grid ->setWidth('C_STATUS', '100'); 
		$grid->setAlign('C_STATUS', 'left'); 


		$grid->setAlign('pilih', 'center');
		$grid ->setWidth('pilih', '50'); 
		$grid->setAlign('pilih', 'left'); 
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');

		$grid->setSearch('C_ITENO','C_ITNAM','tabmas02.c_nmlisen','teamc.c_desc','C_STATUS');
		
		// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('C_STATUS','combobox','',array(''=>'Select One','A'=>'Aktif','M'=>'Mati','Y'=>'Suspend'));
		$grid->changeFieldType('ideleted','combobox','',array(''=>'Pilih',0=>'Aktif',1=>'Tidak aktif'));
		$grid->setJoinTable('plc2.tabmas02', 'tabmas02.c_lisensi = itemas.c_lisensi', 'inner');		
		$grid->setJoinTable('plc2.teamc', 'teamc.c_teamc = itemas.c_teamc', 'left');		
		$grid->setJoinTable('plc2.stocknpl', 'stocknpl.c_iteno = itemas.c_iteno', 'left');	

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

	function listBox_browse_upb_export_pilih($value, $pk, $name, $rowData) {
		$url_header = base_url()."processor/plc/daftar/upd/export/?action=getdetil"; 
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail('.$pk.',\''.$rowData->C_ITENO.'\',\''.$rowData->C_ITNAM.'\',\''.$rowData->C_UNDES.'\',\''.$rowData->tabmas02__c_nmlisen.'\') ;" />
		<script type="text/javascript">
		function pilih_upb_detail (id, cITENO, vupb_nama,dosis,sediaan){					
			custom_confirm("Yakin ?", function(){
				$("#'.$this->input->get('field').'_iupb_id").val(id);
				$("#'.$this->input->get('field').'_iupb_id_dis").val(cITENO+" - "+vupb_nama);
				
				return $.ajax({
				url: "'.$url_header.'",
				type: "post",
				data: {
						upb_id: id,
						},
				beforeSend: function(){

				},
				success: function(data){
					$("#daftar_upd_export_kekuatan").val(dosis);
					$("#daftar_upd_export_sediaan_produk").val(sediaan);
					
					$("#alert_dialog_form").dialog("close");
				},
				}).responseText;

				$("#alert_dialog_form").dialog("close");
			});
		}
		</script>';
		return $o;
	}
}
