<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class upi_kill extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->dbset = $this->load->database('plc', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth->user();
		$this->url = 'upi_kill';
		$this->_table = 'plc2.daftar_upi';
		$this->load->library('lib_utilitas');
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Kill UPI');
		//$grid->setTitle($this->user->gName);
		//dc.m_vendor  database.tabel
		$grid->setTable($this->_table);	

		$grid->setUrl('upi_kill');
		$grid->addList('vNo_upi','vNama_usulan','mnf_kategori.vkategori','plc2_upb_master_kategori_upb.vkategori');

		$grid->setSortBy('iupi_id');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('iupi_id','iStatusKill');

		//setting widht grid 950 width total
		$grid ->setWidth('vNo_upi', '50'); 
		$grid->setWidth('vNama_usulan', '250'); 
		$grid->setWidth('mnf_kategori.vkategori', '100'); 
		$grid->setWidth('plc2_upb_master_kategori_upb.vkategori', '100'); 

		
		//modif label
		$grid->setLabel('iupi_id','No UPI'); //Ganti Label
		$grid->setLabel('vNo_upi','No UPI'); //Ganti Label
		$grid->setLabel('vNama_usulan','Nama Usulan'); //Ganti Label
		$grid->setLabel('mnf_kategori.vkategori','Kategori Produk'); //Ganti Label
		$grid->setLabel('plc2_upb_master_kategori_upb.vkategori','Kategori UPI'); //Ganti Label
		$grid->setLabel('iStatusKill','Kill UPI'); //Ganti Label
		
		
		$grid->setSearch('vNo_upi');
		$grid->setRequired('iupi_id');	//Field yg mandatori
		$grid->setRequired('iStatusKill');	//Field yg mandatori
		$grid->setFormUpload(TRUE);
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('iStatusKill','combobox','',array(''=>'Pilih',1=>'Yes'));

		// join table
		$grid->setQuery('daftar_upi.ldeleted',0);
		$grid->setQuery('daftar_upi.iStatusKill',1);

		$grid->setJoinTable('hrd.mnf_kategori', 'mnf_kategori.ikategori_id = daftar_upi.ikategori_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_master_kategori_upb', 'plc2_upb_master_kategori_upb.ikategori_id = daftar_upi.ikategoriupi_id', 'inner');
		
		//Set View Gridnya (Default = grid)
		$grid->setSortBy('iupi_id');
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

    

	public function insertBox_upi_kill_iupi_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="20" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upi/to/kill?field=upi_kill\',\'List UPI\')" type="button">&nbsp;</button>';                
		
		return $return;
	}


/*manipulasi view object form end*/

/*manipulasi proses object form start*/
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
														reload_grid('grid_upi_kill');
														
													}
												});
											})											
										}		
									}</script>";
            $btnSave .= "<button type='button'
                                    name='button_save_".$this->url."'
                                    id='button_save_".$this->url."'
                                    class='icon-save ui-button'
                                    onclick='javascript:save_btn_".$this->url."(\"upi_kill\", \"".base_url()."processor/plc/upi/kill?company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>Kill UPI
                                    </button>
									 ";
							
			$button['save'] = $btnSave;
            return $button;
			
    }	

   

function kill_process() {

	$id = $_POST['upi_kill_iupi_id'];
	$nip = $this->user->gNIP;
	$skg=date('Y-m-d H:i:s');
	$date=date('Y-m-d');


	$this->db_plc0->where('iupi_id', $id);
	$this->db_plc0->update('plc2.daftar_upi', array('iStatusKill'=>1,'cnipKill'=>$nip,'dateKill'=>$skg));


	$data['status']  = true;
	$data['message']  = 'UPI Berhasil diStatusKill';
	return json_encode($data);
}

	
/*function pendukung end*/    	

	public function output(){
		$this->index($this->input->get('action'));
	}

}
