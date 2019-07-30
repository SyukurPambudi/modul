<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_panel_test_upb extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->_field = $this->input->get('field');
		$this->dbset = $this->load->database('plc', true);
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List UPB');		
		$grid->setTable('plc2.plc2_upb_formula');		
		$grid->setUrl('browse_panel_test_upb');
		$grid->addList('pilih','vkode_surat','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','plc2_upb.iteambusdev_id','plc2_upb.iteampd_id');


		$grid->setWidth('pilih', '25'); // width nya

		$grid->setLabel('vkode_surat', 'No Formula'); //Ganti Label
        $grid->setAlign('vkode_surat', 'left'); //Align nya
        $grid->setWidth('vkode_surat', '120'); // width nya

        $grid->setLabel('plc2_upb.vupb_nomor', 'No UPB'); //Ganti Label
        $grid->setAlign('plc2_upb.vupb_nomor', 'center'); //Align nya
        $grid->setWidth('plc2_upb.vupb_nomor', '100'); // width nya

        $grid->setLabel('plc2_upb.vupb_nama', 'Nama UPB'); //Ganti Label
        $grid->setAlign('plc2_upb.vupb_nama', 'left'); //Align nya
        $grid->setWidth('plc2_upb.vupb_nama', '300'); // width nya

        $grid->setLabel('plc2_upb.vgenerik', 'Nama Generik'); //Ganti Label
        $grid->setAlign('plc2_upb.vgenerik', 'left'); //Align nya
        $grid->setWidth('plc2_upb.vgenerik', '300'); // width nya

        $grid->setLabel('plc2_upb.iteambusdev_id', 'team Busdev'); //Ganti Label
        $grid->setAlign('plc2_upb.iteambusdev_id', 'center'); //Align nya
        $grid->setWidth('plc2_upb.iteambusdev_id', '150'); // width nya

        $grid->setLabel('plc2_upb.iteampd_id', 'Team PD'); //Ganti Label
        $grid->setAlign('plc2_upb.iteampd_id', 'center'); //Align nya
        $grid->setWidth('plc2_upb.iteampd_id', '150'); // width nya



		$grid->setSortBy('plc2_upb.vupb_nomor');
		$grid->setSortOrder('DESC');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		//$grid->setRelation('iteambusdev_id', 'plc2.plc2_div_team', 'idplc2_div_team', 'vName','bdTeamName','inner');

		// join table
		$grid->setJoinTable('plc2.plc2_upb', 'plc2_upb.iupb_id = plc2.plc2_upb_formula.iupb_id', 'inner');
		$grid->setJoinTable('hrd.mnf_sediaan', 'mnf_sediaan.isediaan_id = plc2.plc2_upb.isediaan_id', 'inner');
		$grid->setJoinTable('hrd.mnf_kategori', 'mnf_kategori.ikategori_id = plc2.plc2_upb.ikategori_id', 'inner');
		// hanya satu formula yang mewakili UPB
		$grid->setQuery('ifor_id not in ( select a.ifor_id from plc2.plc2_upb_paneltest a where a.iApprove in (0,2) )', null);
		//sudah melalui stress test
		$grid->setQuery('istress_apppd', 2);
		// kategori UPB OTC
		$grid->setQuery('mnf_kategori.iOtc', 1);

	//	$grid->setQuery('iupb_id not in (select a.iupb_id from plc2.plc2_req_memo_busdev a ) ', null);
		/*
		if(in_array('BD', $team)){
			$type='BD';
			$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth->my_teams().')', null);
		}
		*/
		$grid->setQuery('plc2_upb.iteambusdev_id IN ('.$this->auth->my_teams().')', null);

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

     function listBox_browse_panel_test_upb_plc2_upb_iteampd_id($value) {
    	$team = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id' => $value))->row_array();
    	if(isset($team['vteam'])){
			return $team['vteam'];
		}
		else{
			return $value;
		}
		
    } 

    function listBox_browse_panel_test_upb_plc2_upb_iteambusdev_id($value) {
    	$team = $this->db_plc0->get_where('plc2.plc2_upb_team', array('iteam_id' => $value))->row_array();
    	if(isset($team['vteam'])){
			return $team['vteam'];
		}
		else{
			return $value;
		}
		
    } 

	function listBox_browse_panel_test_upb_pilih($value, $pk, $name, $rowData) {
		$url_rincian = base_url()."processor/plc/partial/view?action=gettestpaneloptpd"; 
		$url_rincian2 = base_url()."processor/plc/partial/view?action=gettestpaneloptbd"; 
		$url_header = base_url()."processor/plc/product/trial/test/panel/?action=getdetilupb"; 
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail_panel_test('.$pk.') ;" />';
		$o .= '<script type="text/javascript">
					function pilih_upb_detail_panel_test (id) {					
						custom_confirm("Yakin", function() {

						$("#'.$this->input->get('field').'_ifor_id").val(id);

		
				$.ajax({
					url: "'.$url_header.'",
					type: "post",
					data: {
						upb_id: id,
						},
					dataType: "json",
                    success: function( data ) {
                        var pd_id=0;
                        var bd_id=0;
                        $.each(data, function(index, element) {
                        	$("#'.$this->input->get('field').'_ifor_id").val(id);
                        	$("#'.$this->input->get('field').'_'.'ifor_id_dis").val(element.vkode_surat);
                        	$("#'.$this->input->get('field').'_no_upb").val(element.vupb_nomor);
                        	$("#'.$this->input->get('field').'_'.'nama_usulan").val(element.vupb_nama);
                        	$("#'.$this->input->get('field').'_'.'nama_generik").val(element.vgenerik);
                        	$("#'.$this->input->get('field').'_'.'nama_pd").val(element.iteampd_id);
                        	pd_id=element.id_teampd;
                        	bd_id=element.id_teambd;
                        })

						$.ajax({
						     url: "'.$url_rincian.'", 
						     type: "POST", 
						     data: {iteampd_id: pd_id}, 
						     success: function(response){
						     	 $("#'.$this->input->get('field').'_'.'cNip_kirim").html(response);
						         
						     }

						});

						$.ajax({
						     url: "'.$url_rincian2.'", 
						     type: "POST", 
						     data: {iteambusdev_id: bd_id}, 
						     success: function(response){
						     	 $("#'.$this->input->get('field').'_'.'cNip_terima").html(response);
						         
						     }

						});

                    }

					
				})


			$("#alert_dialog_form").dialog("close");
						});
					}
				</script>';

		return $o;
	}
}


