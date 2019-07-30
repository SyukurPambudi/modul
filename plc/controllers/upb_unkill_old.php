<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upb_Unkill extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->dbset = $this->load->database('plc', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth->user();
		$this->url = 'upb_unkill';
		$this->_table = 'plc2.plc2_upb';
		$this->load->library('lib_utilitas');
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Unkill UPB');
		//$grid->setTitle($this->user->gName);
		//dc.m_vendor  database.tabel
		$grid->setTable($this->_table);	

		$grid->setUrl('upb_unkill');
		$grid->addList('vupb_nomor','vupb_nama','vgenerik');
		$grid->setSortBy('iupb_id');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('iupb_id','iKill','vnipUnkill','dateUnkill');

		//setting widht grid 950 width total
		$grid ->setWidth('vupb_nomor', '150'); 
		$grid->setWidth('vupb_nama', '500'); 
		$grid->setWidth('vgenerik', '500'); 

		
		//modif label
		$grid->setLabel('iupb_id','No UPB'); //Ganti Label
		$grid->setLabel('vnipUnkill','Unkill UPB By');
		$grid->setLabel('dateUnkill','Tanggal Unkill');
		$grid->setLabel('vupb_nomor','No UPB'); //Ganti Label
		$grid->setLabel('vupb_nama','Nama UPB'); //Ganti Label
		$grid->setLabel('vgenerik','Nama Generik'); //Ganti Label
		$grid->setLabel('iKill','Unkill UPB'); //Ganti Label
		
		
		$grid->setSearch('vupb_nomor');
		$grid->setRequired('iupb_id');	//Field yg mandatori
		$grid->setRequired('iKill');	//Field yg mandatori
		$grid->setFormUpload(TRUE);
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('iKill','combobox','',array(''=>'Pilih',0=>'Yes'));

		// join table
		$grid->setQuery('plc2_upb.ldeleted',0);
		$grid->setQuery('plc2_upb.iKill',1);

		
		//Set View Gridnya (Default = grid)
		$grid->setSortBy('iupb_id');
		$grid->setSortOrder('DESC');
		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				//echo $grid->saved_form();
				echo $this->kill_process();
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
			case 'gethistory':
				echo $this->gethistory();
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'approve':
				echo $this->approve_view();
				break;
			case 'kill_process':
				echo $this->kill_process();
				break;
			case 'reject':
				echo $this->reject_view();
				break;
			case 'reject_process':
				echo $this->reject_process();
				break;

			case 'updateproses':
				echo $grid->updated_form();
				break;
			case 'employee_list':
				$this->employee_list();
			default:
				$grid->render_grid();
				break;
		}
    }

    /*Maniupulasi Gird Start*/

   
	

/*Maniupulasi Gird end*/

/*manipulasi view object form start*/
	function updatebox_upb_unkill_iupb_id($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') { 
			$o = "<label title='No UPB'>".$value."</label>";
		
		}else{
			//$o 	= "<textarea name='".$id."' id='".$id."' class='required' data-validation='required' data-validation-error-msg='Tags tidak boleh kosong'   style='width: 240px; height: 50px;'size='250'>".nl2br($value)."</textarea>";
			$o = "<label title='No UPB'>".$rowData['vupb_nomor']."</label>";
		}

		
		return $o;
	}

	function updatebox_upb_unkill_dateUnkill($field, $id, $value, $rowData) {
		$skg=date('Y-m-d H:i:s');
		if($value=="0000-00-00" or empty($value)){
			$value = $skg;
		}
 
		if ($this->input->get('action') == 'view') {
			$return= $value; 
		}
		else{
			$return = $skg;
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="8" />';
		}
		
		return $return;
	}

	function updateBox_upb_unkill_vnipUnkill($field, $id, $value, $rowData) {
		$skg=date('Y-m-d');
		$cNip = $this->user->gNIP; 

		if($value=="" or empty($value)){
			$value = $cNip;
			$emp = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$value))->row_array();
		}else{
			$emp = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$value))->row_array();
		}

		if ($this->input->get('action') == 'view') {
			$return= $emp['vName']; 
		}
		else{
			$return = $emp['vName'];
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="8" />';
		}
		
		return $return;
	}

/*manipulasi view object form end*/

/*manipulasi proses object form start*/
/*
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
												alert_message +='<b>Field '+label+' Required!</b> <br/>';			
												$(this).addClass('error_text');			
												conf++;
											}		
										})
										if(conf > 0) {		
											showMessage(alert_message);
										}
										else {		
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
														reload_grid('grid_upb_unkill');
														
													}
												});
											})											
										}		
									}</script>";
            $btnSave .= "<button type='button'
                                    name='button_save_".$this->url."'
                                    id='button_save_".$this->url."'
                                    class='icon-save ui-button'
                                    onclick='javascript:save_btn_".$this->url."(\"upb_unkill\", \"".base_url()."processor/plc/kill/upb?company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>Kill UPB
                                    </button>
									 ";
							
			$button['save'] = $btnSave;
            return $button;
			
    }	
*/
   
   
/*manipulasi proses object form end*/    

/*function pendukung start*/  
/*
	function kill_process() {

	   # [upb_unkill_iupb_id] => 2264
	   # [upb_unkill_iKill] => 1
		$id = $_POST['upb_unkill_iupb_id'];
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$date=date('Y-m-d');


		$this->db_plc0->where('iupb_id', $id);
		$this->db_plc0->update('plc2.plc2_upb', array('iKill'=>1,'vnipKill'=>$nip,'dateKill'=>$skg));

		$data['status']  = true;
		$data['message']  = 'UPB Berhasil diKill';
		return json_encode($data);
	}
*/
	
/*function pendukung end*/    	

	public function output(){
		$this->index($this->input->get('action'));
	}

}
