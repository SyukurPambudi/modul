<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upb_Kill extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->dbset = $this->load->database('plc', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth->user();
		$this->url = 'upb_kill';
		$this->_table = 'plc2.plc2_upb';
		$this->load->library('lib_utilitas');
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Kill UPB');
		//$grid->setTitle($this->user->gName);
		//dc.m_vendor  database.tabel
		$grid->setTable($this->_table);	

		$grid->setUrl('upb_kill');
		$grid->addList('vupb_nomor','vupb_nama','vgenerik');
		$grid->setSortBy('iupb_id');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('iupb_id','iKill','vnipKill','dateKill');

		//setting widht grid 950 width total
		$grid ->setWidth('vupb_nomor', '150'); 
		$grid->setLabel('vnipKill','Kill UPB By');
		$grid->setLabel('dateKill','Tanggal Kill');
		$grid->setWidth('vupb_nama', '500'); 
		$grid->setWidth('vgenerik', '500'); 

		
		//modif label
		$grid->setLabel('iupb_id','No UPB'); //Ganti Label
		$grid->setLabel('vupb_nomor','No UPB'); //Ganti Label
		$grid->setLabel('vupb_nama','Nama UPB'); //Ganti Label
		$grid->setLabel('vgenerik','Nama Generik'); //Ganti Label
		$grid->setLabel('iKill','Kill UPB'); //Ganti Label
		
		
		$grid->setSearch('vupb_nomor');
		$grid->setRequired('iupb_id');	//Field yg mandatori
		$grid->setRequired('iKill');	//Field yg mandatori
		$grid->setFormUpload(TRUE);
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('iKill','combobox','',array(''=>'Pilih',1=>'Yes'));

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

	public function insertBox_upb_kill_iupb_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="35" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upb/to/kill?field=upb_kill\',\'List UPB\')" type="button">&nbsp;</button>';                
		
		return $return;
	}
	function insertBox_upb_kill_vnipkill($field, $id) {
		$return ='';
		$return .= '
					<script type="text/javascript">
						$("label[for=\''.$id.'\']").hide();
						$("label[for=\''.$id.'\']").next().css("margin-left",0);
					</script>
				';
		$return .= '<div></div>';
		return $return;
		 
	}
	function insertBox_upb_kill_dateKill($field, $id) { 
		$return ='';
		$return .= '
					<script type="text/javascript">
						$("label[for=\''.$id.'\']").hide();
						$("label[for=\''.$id.'\']").next().css("margin-left",0);
					</script>
				';
		$return .= '<div></div>';
		return $return;
	}
	function updateBox_upb_kill_vnipkill($field, $id, $value, $rowData) {
		$skg=date('Y-m-d');
		$cNip = $this->user->gNIP; 

		if($value=="" or empty($value)){
			$value = $cNip;
			$emp['vName'] = "";
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
	function updatebox_upb_kill_dateKill($field, $id, $value, $rowData) {
		$skg=date('Y-m-d H:i:s');
		if($value=="" or empty($value)){
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
														reload_grid('grid_upb_kill');
														
													}
												});
											})											
										}		
									}</script>";
            $btnSave .= "<button type='button'
                                    name='button_save_".$this->url."'
                                    id='button_save_".$this->url."'
                                    class='icon-save ui-button'
                                    onclick='javascript:save_btn_".$this->url."(\"upb_kill\", \"".base_url()."processor/plc/kill/upb?company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>Kill UPB
                                    </button>
									 ";
							
			$button['save'] = $btnSave;
            return $button;
			
   }	

   
   
/*manipulasi proses object form end*/    

/*function pendukung start*/  

function kill_process() {

   # [upb_kill_iupb_id] => 2264
   # [upb_kill_iKill] => 1
	$id = $_POST['upb_kill_iupb_id'];
	$nip = $this->user->gNIP;
	$skg=date('Y-m-d H:i:s');
	$date=date('Y-m-d');


	$this->db_plc0->where('iupb_id', $id);
	$this->db_plc0->update('plc2.plc2_upb', array('iKill'=>1,'inonKill'=>0,'vnipKill'=>$nip,'dateKill'=>$skg));

/*
	// ubah status jadi relase
	foreach($_POST['id_pinjaman'] as $k=>$v) {
		$id = $v;
		$this->db_plc0->where('pinjaman_id', $id);
		$this->db_plc0->update('koperasi.kop_pinjaman', array('dReleased'=>$date,'cReleaseBy'=>$nip,'dReleaseAt'=>$skg));


		$sql='select * from koperasi.kop_pinjaman a 
		join koperasi.kop_master_anggota b on a.iAnggota_id=b.id
		where a.pinjaman_id="'.$id.'"';
		$data_pinjaman = $this->db_plc0->query($sql)->row_array();
		$durasi=$data_pinjaman['idurasi'];

		$cek_sisa_pinjam='select * from koperasi.kop_cicilan a where a.cNip= "'.$data_pinjaman['cNip'].'" and ((a.dCicil is null) ) ';
		$data_sisa = $this->dbset->query($cek_sisa_pinjam)->result_array();

		$get_id='select a.pinjaman_id from koperasi.kop_cicilan a where a.cNip="'.$data_pinjaman['cNip'].'" and ((a.dCicil is null) )  limit 1';
		$data_pinjam_id = $this->db_plc0->query($get_id)->row_array();

		// close last pinjaman
		$cNip = $this->user->gNIP;
		$tUpdated = date('Y-m-d H:i:s', mktime());
		if (!empty($data_pinjam_id)) {
			$SQL = "UPDATE koperasi.kop_pinjaman set cUpdate='{$cNip}', dupdate='{$tUpdated}' ,iStatus_pinjam='1' where pinjaman_id = '{$data_pinjam_id['pinjaman_id']}'";
			$this->dbset->query($SQL);
		}

		// close detail cicilan last pinjaman
		if (!empty($data_sisa)) {
			foreach($data_sisa as $data) {
				$cNip = $this->user->gNIP;
				$tUpdated = date('Y-m-d H:i:s', mktime());
				$SQL = "UPDATE koperasi.kop_cicilan set cUpdate='{$cNip}', dupdate='{$tUpdated}',dCicil= '{$tUpdated}' where ikop_cicilan_id = '{$data['ikop_cicilan_id']}'";
				$this->dbset->query($SQL);
		    } 	
		}


		$jumlah_pinjaman=$data_pinjaman['fJumlah_pinjaman'];
		for ($x = 1; $x <= $durasi; $x++) {
			$sisa_hutang=($jumlah_pinjaman-($data_pinjaman['fBesar_cicilan']*$x) );

			if ( $sisa_hutang < 0) {
				$sisa = 0;
			}else{
				$sisa = $sisa_hutang;
			}
			
			$nextmonth=date("Y-m-d",strtotime("+".$x." month"));
			$sql = "INSERT INTO koperasi.kop_cicilan (pinjaman_id,cNip, iCicilan_ke,dBulan, fBesar_cicilan,fSisa_hutang,dcreate,cCreatedBy) 
									VALUES ('".$data_pinjaman['pinjaman_id']."', '".$data_pinjaman['cNip']."', '".$x."','".$nextmonth."','".$data_pinjaman['fBesar_cicilan']."','".$sisa."','".$skg."','".$nip."')";
			$this->dbset->query($sql);
		} 
	
		
	}

	*/

	$data['status']  = true;
	$data['message']  = 'UPB Berhasil diKill';
	return json_encode($data);
}

	
/*function pendukung end*/    	

	public function output(){
		$this->index($this->input->get('action'));
	}

}
