<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_upi_to_kill extends MX_Controller {
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
		$grid->setTitle('List UPI');		
		$grid->setTable('plc2.daftar_upi');		
		$grid->setUrl('browse_upi_to_kill');
		$grid->addList('vNo_upi','vNama_usulan','pilih');

		$grid->setSortBy('iupi_id');
		$grid->setSortOrder('asc'); 

		$grid ->setWidth('vNo_upi', '150'); 
		$grid->setWidth('vNama_usulan', '500'); 
		$grid->setWidth('pilih', '25');

		$grid->setLabel('iupi_id','No UPI'); //Ganti Label
		$grid->setLabel('vNo_upi','No UPI'); //Ganti Label
		$grid->setLabel('vNama_usulan','Nama Usulan'); //Ganti Label

		$grid->setSearch('vNo_upi');
		$grid->setAlign('vNo_upi', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		//$grid->setRelation('iteambusdev_id', 'plc2.plc2_div_team', 'idplc2_div_team', 'vName','bdTeamName','inner');

		// join table
		$grid->setQuery('iStatusKill = "0" ', null);
		//$grid->setQuery('istatus_launching = "0" or istatus_launching is NULL ', null);
		
		
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

	function listBox_browse_upi_to_kill_pilih($value, $pk, $name, $rowData) {
		//$url_header = base_url()."processor/plc/UPI/kill/?action=gethistory"; 
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_UPI_detail('.$pk.',\''.$rowData->vNo_upi.'\',\''.$rowData->vNama_usulan.'\') ;" />
		<script type="text/javascript">
		function pilih_UPI_detail (id, vNo_upi, vNama_usulan){					
			custom_confirm("Yakin ?", function(){
				$("#'.$this->input->get('field').'_iupi_id").val(id);
				$("#'.$this->input->get('field').'_iupi_id_dis").val(vNo_upi+" - "+vNama_usulan);
				
				


				$("#alert_dialog_form").dialog("close");
			});
		}
		</script>';
		return $o;
	}

   function manipulate_insert_button($button) {
        $btnSave  = "";
    	$btnSave .=  "<script type='text/javascript'>
                                    function save_btn_".$this->url."(grid, url, dis) {
								        var req = $('#form_create_'+grid+' input.required, #form_create_'+grid+' select.required, #form_create_'+grid+' textarea.required');
										var conf=0;
										var alert_message = '';
										$.each(req, function(i,v){
											$(this).removeClass('error_text');
											if($(this).val() == '') {
												var id = $(this).attr('id');
												var label = $('label[for=\"'+id+'\"]').text();
												label = label.replace('*','');
												// alert_message += '<br /><b>'+label+'</b> '+required_message;			
												alert_message +='<b>Field '+label+' Required!</b> <br/>';			
												$(this).addClass('error_text');			
												conf++;
											}		
										})
										if(conf > 0) {		
											showMessage(alert_message);
										}
										else {		
											if ($('#release_pinjaman_total_release').val() =='' || $('#release_pinjaman_total_release').val() == '0')  {
												alert('Jumlah release tidak boleh kosong!');
												return false ;
											}

											custom_confirm(comfirm_message,function(){	
												$.ajax({
													url: $('#form_create_'+grid).attr('action'),
													type: 'post',
													data: $('#form_create_'+grid).serialize(),
													success: function(data) {
														var o = $.parseJSON(data);
														var info = 'Error';
														var header = 'Error';
														var last_id = o.last_id;
														var foreign_id = o.foreign_id;
														if(o.status == true) {	
															info = 'Info';
															header = 'Info';
															_custom_alert(o.message,header,info, grid, 1, 20000);						
															$('#form_create_'+grid)[0].reset();
															$('#list').html('');
														}
														$('#list').html('');	
														$('#grid_'+grid).trigger('reloadGrid');
														reload_grid('grid_release_pinjaman');
														
													}
												});
											})											
										}		
									}</script>";
            $btnSave .= "<button type='button'
                                    name='button_save_".$this->url."'
                                    id='button_save_".$this->url."'
                                    class='icon-save ui-button'
                                    onclick='javascript:save_btn_".$this->url."(\"release_pinjaman\", \"".base_url()."processor/koperasi/release/pinjaman?company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>Release
                                    </button>
									 ";
							
			$button['save'] = $btnSave;
            return $button;
			
    }


}

