<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Daftar_upd_export extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_plcexport');
		$this->load->library('lib_utilitas');
		$this->load->library('dossier_log');
		$this->dbset = $this->load->database('dosier', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth_plcexport->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Daftar UPD');
		$grid->setTable('dossier.dossier_upd');		
		$grid->setUrl('daftar_upd_export');
		$grid->addList('vUpd_no','vNama_usulan','employee.vName','itemas.C_ITENO','itemas.C_ITNAM','iTeam_andev','iSubmit_upd','iApprove_upd');
		$grid->setSortBy('vUpd_no');
		$grid->setSortOrder('DESC'); //sort ordernya

		$grid->addFields('vUpd_no','dTanggal_upd','vNama_usulan','cNip_pengusul','nama_pengusul','iupb_id'
							,'sediaan_produk','kekuatan','cpic_ir','iTeam_andev','istandar_dok_id','inegara_komparator','iperlu_be','isedia_be','iulang_be','iApprove_upd');

		//setting widht grid
		$grid ->setWidth('vUpd_no', '100'); 
		$grid->setWidth('lDeleted', '100'); 
		
		
		//modif label
		$grid->setLabel('vUpd_no','No UPD'); 
		$grid->setLabel('vNama_usulan','Nama Usulan'); 
		$grid->setLabel('cNip_pengusul','NIP Pengusul'); 
		$grid->setLabel('iupb_id','Kode Produk'); 
		$grid->setLabel('kekuatan','Unit'); 
		$grid->setLabel('sediaan_produk','Lisensi'); 
		$grid->setLabel('iApprove_upd','Approval BDIRM'); 
		$grid->setLabel('iSubmit_upd','Status UPD '); 
		$grid->setLabel('dTanggal_upd','Tanggal UPD'); 
		$grid->setLabel('cApproval_direksi','Approve by'); 
		$grid->setLabel('employee.vName','Nama Pengusul');
		$grid->setLabel('itemas.C_ITENO','No Produk'); 
		$grid->setLabel('itemas.C_ITNAM','Nama Produk'); 
		$grid->setLabel('iTeam_andev','Team Andev'); 
		$grid->setLabel('cpic_ir','PIC IR'); 
		$grid->setLabel('inegara_komparator','Asal Negara Komparator'); 
		$grid->setLabel('iperlu_be','Perlu Uji BE'); 
		$grid->setLabel('isedia_be','BE Tersedia'); 
		$grid->setLabel('iulang_be','Perlu BE Ulang'); 
		$grid->setLabel('istandar_dok_id','Standar Dokumen'); 

		$grid->setFormUpload(TRUE);

		$grid->setSearch('vUpd_no','vNama_usulan','employee.vName','itemas.C_ITNAM','itemas.C_ITNAM','iApprove_upd');
		
		
		// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('lDeleted','combobox','',array(''=>'Pilih',0=>'Aktif',1=>'Tidak aktif'));
		$grid->changeFieldType('iSubmit_upd','combobox','',array(0=>'Draft - Need to be Publish',1=>'Submitted'));
		$grid->changeFieldType('iApprove_upd','combobox','',array(''=> 'Pilih',0=>'Waiting Approval',1=>'Reject',2=>'Approved'));
		$grid->changeFieldType('iTeam_andev','combobox','',array(''=>'Pilih','17'=>'Andev Export 1','40'=>'Andev Export 2'));
		$grid->changeFieldType('iperlu_be','combobox','',array(''=>'Pilih','0'=>'Tidak','1'=>'Ya'));
		$grid->changeFieldType('isedia_be','combobox','',array(''=>'Pilih','0'=>'Tidak Tersedia','1'=>'Tersedia'));
		$grid->changeFieldType('iulang_be','combobox','',array(''=>'Pilih','0'=>'Tidak','1'=>'Ya'));

		//Field mandatori
		$grid->setRequired('vUpd_no');	
		$grid->setRequired('vNama_usulan');	
		$grid->setRequired('iupb_id');	
		$grid->setRequired('cpic_ir');	
		$grid->setRequired('iTeam_andev');	
		$grid->setRequired('istandar_dok_id');	
		$grid->setRequired('inegara_komparator');	
		$grid->setRequired('iperlu_be');	
		$grid->setRequired('isedia_be');	
		$grid->setRequired('iulang_be');	

		
		$grid->setJoinTable('hrd.employee', 'employee.cNip = dossier_upd.cNip_pengusul', 'inner');
		$grid->setJoinTable('plc2.itemas', 'itemas.C_ITENO=dossier_upd.iupb_id','inner');
		$grid->setQuery('dossier_upd.lDeleted', 0);
		$grid->setQuery('dossier_upd.ihold', 0);

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
			case 'download':
				$this->download($this->input->get('file'));
				break;

			case 'delete':
				echo $grid->delete_row();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'getspname':
				echo $this->getSpname();
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				echo $grid->updated_form();
				break;
			case 'approve':
				echo $this->approve_view();
				break;
			case 'approve_process':
				echo $this->approve_process();
				break;
			case 'reject':
				echo $this->reject_view();
				break;
			case 'reject_process':
				echo $this->reject_process();
				break;
			case 'getemployee':
				echo $this->getEmployee();
				break;
			case 'copyupd':
				echo $this->copyupd($this->input->post());
				break;
			default:
				$grid->render_grid();
				break;
		}
    }

   
	 function listBox_Action($row, $actions) {

	 	if ($row->iApprove_upd<>0) {
	 		// status sudah diapprove or reject , button edit hide 
	 		 unset($actions['edit']);
	 		 unset($actions['delete']);
	 	}
	 	if($row->iSubmit_upd!=0){
	 		 unset($actions['delete']);
	 	}
		$iTeam_andev=$row->iTeam_andev;
	 	if($this->auth_plcexport->is_manager()){
			$x=$this->auth_plcexport->dept();
			$manager=$x['manager'];
			$q="select * from plc2.plc2_upb_team te where te.vnip in ('".$this->user->gNIP."') and te.iTipe=2 and te.ldeleted=0";
		
			if(in_array('BDI', $manager)){
				$type='BDI';
				$q.=" and vtipe='".$type."'";
				$d=$this->dbset->query($q)->row_array();
				if($d['iteam_id']==91){//BDIRM 1
					if($iTeam_andev!=17){
						unset($actions['edit']);
	 		 			unset($actions['delete']);
					}
				}elseif ($d['iteam_id']==78) {
					if($iTeam_andev!=40 && $row->is_old==0){
						unset($actions['edit']);
	 		 			unset($actions['delete']);
					}
				}
			}
			elseif(in_array('IR', $manager)){
				$type='IR';
				$q.=" and vtipe='".$type."'";
				$d=$this->dbset->query($q)->row_array();
				if($d['iteam_id']==90){//BDIRM 1
					if($iTeam_andev!=17){
						unset($actions['edit']);
	 		 			unset($actions['delete']);
					}
				}elseif ($d['iteam_id']==82) {
					if($iTeam_andev!=40 && $row->is_old==0){
						unset($actions['edit']);
	 		 			unset($actions['delete']);
					}
				}
			}
		}else{
			$x=$this->auth_plcexport->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				$q="select * from plc2.plc2_upb_team_item te 
				inner join plc2.plc2_upb_team it on it.iteam_id
				where te.vnip in ('".$this->user->gNIP."') and te.ldeleted=0 and it.ldeleted=0";
				if(in_array('BDI', $team)){
					$type='BDI';
					$q.=" and vtipe='".$type."'";
					$d=$this->dbset->query($q)->row_array();
					if($d['iteam_id']==91){//BDIRM 1
						if($iTeam_andev!=17){
							unset($actions['edit']);
		 		 			unset($actions['delete']);
						}
					}elseif ($d['iteam_id']==78) {
						if($iTeam_andev!=40 && $row->is_old==0){
							unset($actions['edit']);
		 		 			unset($actions['delete']);
						}
					}
				}
				elseif(in_array('IR', $team)){
					$type='IR';
					$q.=" and vtipe='".$type."'";
					$d=$this->dbset->query($q)->row_array();
					if($d['iteam_id']==90){//BDIRM 1
						if($iTeam_andev!=17){
							unset($actions['edit']);
		 		 			unset($actions['delete']);
						}
					}elseif ($d['iteam_id']==82) {
						if($iTeam_andev!=40 && $row->is_old==0){
							unset($actions['edit']);
		 		 			unset($actions['delete']);
						}
					}
				}
			}
		}
		 return $actions;

	 } 

/*manipulasi view object form start*/
function getEmployee() {
	$term = $this->input->get('term');
	$sql='select de.vDescription,em.cNip as cNIP, em.vName as vName from plc2.plc2_upb_team_item it
			inner join plc2.plc2_upb_team te on it.iteam_id= te.iteam_id
			inner join hrd.employee em on em.cNip=it.vnip
			inner join hrd.msdepartement de on de.iDeptID=em.iDepartementID 
			where em.vName like "%'.$term.'%" and te.vtipe="IR" AND it.ldeleted=0 order by em.vname ASC';
	$dt=$this->db_plc0->query($sql);
	$data = array();
	if($dt->num_rows>0){
		foreach($dt->result_array() as $line) {

			$row_array['value'] = trim($line['vName']);
			$row_array['id']    = $line['cNIP'];

			array_push($data, $row_array);
		}
	}
	echo json_encode($data);
	exit;
}
function insertBox_daftar_upd_export_vUpd_no($field, $id) {
	$return = 'Auto generate';
	return $return;
}

function updateBox_daftar_upd_export_vUpd_no($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return= $value;
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
		}
		
		return $return;
}

function insertBox_daftar_upd_export_dTanggal_upd($field, $id) {
	$skg=date('Y-m-d');
	$cNip = $this->user->gNIP;
	$vName = $this->user->gName;
	$return = '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$skg.'" class="input_rows1" size="8" />';
	$return .= $skg;
	return $return;
}

function updateBox_daftar_upd_export_dTanggal_upd($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return= $value;
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
		}
		
		return $return;
}



function insertBox_daftar_upd_export_vNama_usulan($field, $id) {
		$return = '
		<input type="hidden" name="isdraft" id="isdraft">
		<input type="text" name="'.$field.'"   id="'.$id.'" value="" class="required input_rows1" size="25" />';
		return $return;
}


function updateBox_daftar_upd_export_vNama_usulan($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = '
			<input type="hidden" name="isdraft" id="isdraft">
			<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="25" />
			<button class="ui-button-text icon-copy"  onclick="javascript:copy_upd_'.$id.'(\''.base_url().'processor/plc/daftar/upd/export?action=copyupd&foreign_key=0&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',\'daftar_upd_export\')" type="button">Copy UPD</button>
			<script>
			function copy_upd_'.$id.'(url, grid){
				custom_confirm(comfirm_message,function(){
					$.ajax({
						url: url,
						type: "post",
						data: $("#form_update_"+grid).serialize(),
						success: function(data) {
							var o = $.parseJSON(data);
							var header = "Info";
							var info = "Info";
							if(o.status==true){
								_custom_alert(o.message,header,info, grid, 1, 20000);
								$("#grid_"+grid).trigger("reloadGrid");
								$.get(base_url+"processor/plc/daftar/upd/export?action=update&foreign_key=0&company_id='.$this->input->get('company_id').'&id="+o.last_id+"&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'", function(data) {
		                           $("div#form_"+grid).html(data);
		                           $("html, body").animate({scrollTop:$("#"+grid).offset().top - 20}, "slow");
		                    	});
							}else{
								_custom_alert(o.message,header,info, grid, 1, 20000);
							}
						}
		        	});
				});
			}
			$( "button.icon-copy" ).button({
				icons: {
					primary: "ui-icon-copy"
				},
				text: true
			});
			</script>';
		}
		
		return $return;
}

function insertBox_daftar_upd_export_cNip_pengusul($field, $id) {
	$skg=date('Y-m-d');
	$cNip = $this->user->gNIP;
	$vName = $this->user->gName;
	$return = '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$cNip.'" class="input_rows1" size="8" />';
	$return .= $cNip;
	return $return;
}

function updateBox_daftar_upd_export_cNip_pengusul($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return= $value;
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
		}
		
		return $return;
}



function insertBox_daftar_upd_export_nama_pengusul($field, $id) {
	$skg=date('Y-m-d');
	$cNip = $this->user->gNIP;
	$vName = $this->user->gName;
	//$return = '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$cNip.'" class="input_rows1" size="8" />';
	$return = $vName;
	return $return;
}

function updateBox_daftar_upd_export_nama_pengusul($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cNip_pengusul']))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vName'];

		}
		else{
			$return= $rows['vName'];
		}
		
		return $return;
}


function insertBox_daftar_upd_export_iupb_id($field, $id) {
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
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upb/export?field=daftar_upd_export\',\'List Produk\')" type="button">&nbsp;</button>';                
		
		return $return;
}

function updateBox_daftar_upd_export_iupb_id($field, $id, $value, $rowData) {
	$sql = 'SELECT dossier_upd.vUpd_no,dossier_upd.vNama_usulan,dossier_upd.dTanggal_upd,dossier_upd.cNip_pengusul,
			employee.vName,itemas.C_ITENO,itemas.C_ITNAM,dossier_upd.iSubmit_upd,(if(dossier_upd.iTeam_andev=17,91,78)) as bdi
			FROM dossier.dossier_upd 
			inner join plc2.itemas on itemas.C_ITENO=dossier_upd.iupb_id
			INNER JOIN plc2.tabmas02 ON tabmas02.c_lisensi = itemas.c_lisensi
			LEFT JOIN plc2.teamc ON teamc.c_teamc = itemas.c_teamc
			LEFT JOIN plc2.stocknpl ON stocknpl.c_iteno = itemas.c_iteno
			JOIN hrd.employee ON employee.cNip=dossier_upd.cNip_pengusul
			WHERE dossier_upd.idossier_upd_id='.$rowData['idossier_upd_id'];
	$data_upb = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view') {
		$return= $data_upb['C_ITENO'].' - '.$data_upb['C_ITNAM'];

	}else{

		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="35" value="'.$data_upb['C_ITENO'].' - '.$data_upb['C_ITNAM'].'"/>';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upb/export?field=daftar_upd_export\',\'List Produk\')" type="button">&nbsp;</button>';                
	}
	
	return $return;
}


function insertBox_daftar_upd_export_kekuatan($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="25" disabled />';
	return $return;
}

function updateBox_daftar_upd_export_kekuatan($field, $id, $value, $rowData) {
		$sql = 'SELECT dossier_upd.vUpd_no,dossier_upd.vNama_usulan,dossier_upd.dTanggal_upd,dossier_upd.cNip_pengusul,
			employee.vName,itemas.C_ITENO,itemas.C_ITNAM,itemas.C_UNDES,dossier_upd.iSubmit_upd,(if(dossier_upd.iTeam_andev=17,91,78)) as bdi
			FROM dossier.dossier_upd 
			inner join plc2.itemas on itemas.C_ITENO=dossier_upd.iupb_id
			INNER JOIN plc2.tabmas02 ON tabmas02.c_lisensi = itemas.c_lisensi
			LEFT JOIN plc2.teamc ON teamc.c_teamc = itemas.c_teamc
			LEFT JOIN plc2.stocknpl ON stocknpl.c_iteno = itemas.c_iteno
			JOIN hrd.employee ON employee.cNip=dossier_upd.cNip_pengusul
			WHERE dossier_upd.idossier_upd_id='.$rowData['idossier_upd_id'];
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $data_upb['C_UNDES'];

		}
		else{
			$return = '<input type="text" name="'.$field.'" disabled id="'.$id.'" value="'.$data_upb['C_UNDES'].'" class="input_rows1" size="25" />';
		}
		
		return $return;
}
function insertBox_daftar_upd_export_cpic_ir($field, $id) {
	$url = base_url().'processor/plc/daftar/upd/export?action=getemployee';
	$return	= '<script language="text/javascript">
				$(document).ready(function() {
					var config = {
						source: function( request, response) {
							$( "#'.$id.'" ).val("");
							$.ajax({
								url: "'.$url.'",
								dataType: "json",
								data: {
									term: request.term,
								},
								success: function( data ) {
									response( data );
								}
							});
						},
						select: function(event, ui){
							$( "#'.$id.'" ).val(ui.item.id);
							$( "#'.$id.'_text" ).val(ui.item.value);
							return false;
						},
						minLength: 2,
						autoFocus: true,
					};

					$( "#'.$id.'_text" ).livequery(function() {
					 	$( this ).autocomplete(config);
					});

				});
	      </script>
	<input name="'.$id.'" id="'.$id.'" type="hidden" class="required"/>
	<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="25"/>';
	return $return;
}

function updateBox_daftar_upd_export_cpic_ir($field, $id, $value, $rowData) {
		$url = base_url().'processor/plc/daftar/upd/export?action=getemployee';
		$sql="select * from hrd.employee em where em.cNip='".$value."'";
		$q=$this->dbset->query($sql)->row_array();
		$return	= '<script language="text/javascript">
					$(document).ready(function() {
						var config = {
							source: function( request, response) {
								$( "#'.$id.'" ).val("");
								$.ajax({
									url: "'.$url.'",
									dataType: "json",
									data: {
										term: request.term,
									},
									success: function( data ) {
										response( data );
									}
								});
							},
							select: function(event, ui){
								$( "#'.$id.'" ).val(ui.item.id);
								$( "#'.$id.'_text" ).val(ui.item.value);
								return false;
							},
							minLength: 2,
							autoFocus: true,
						};

						$( "#'.$id.'_text" ).livequery(function() {
						 	$( this ).autocomplete(config);
						});

					});
		      </script>
		<input name="'.$id.'" id="'.$id.'" type="hidden" class="required" value="'.$value.'" />
		<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="25" value="'.$q['vName'].'" />';
		if ($this->input->get('action') == 'view') {
			$r= $q['vName'];

		}else{
			$r=$return;
		}
		return $r;
}

function insertBox_daftar_upd_export_sediaan_produk($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'"  class="input_rows1" size="25" disabled />';
	return $return;
}

function updateBox_daftar_upd_export_sediaan_produk($field, $id, $value, $rowData) {
		$sql = 'SELECT dossier_upd.vUpd_no,dossier_upd.vNama_usulan,dossier_upd.dTanggal_upd,dossier_upd.cNip_pengusul,
			employee.vName,itemas.C_ITENO,itemas.C_ITNAM,itemas.C_UNDES,tabmas02.c_nmlisen,dossier_upd.iSubmit_upd,(if(dossier_upd.iTeam_andev=17,91,78)) as bdi
			FROM dossier.dossier_upd 
			inner join plc2.itemas on itemas.C_ITENO=dossier_upd.iupb_id
			INNER JOIN plc2.tabmas02 ON tabmas02.c_lisensi = itemas.c_lisensi
			LEFT JOIN plc2.teamc ON teamc.c_teamc = itemas.c_teamc
			LEFT JOIN plc2.stocknpl ON stocknpl.c_iteno = itemas.c_iteno
			JOIN hrd.employee ON employee.cNip=dossier_upd.cNip_pengusul
			WHERE dossier_upd.idossier_upd_id='.$rowData['idossier_upd_id'];
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $data_upb['c_nmlisen'];

		}
		else{
			$return = '<input type="text" name="'.$field.'" disabled id="'.$id.'" value="'.$data_upb['c_nmlisen'].'" class="input_rows1" size="25" />';
		}
		
		return $return;
}


function insertBox_daftar_upd_export_iApprove_upd($field, $id) {
	$return = '-';
	return $return;
}

function updateBox_daftar_upd_export_iApprove_upd($field, $id, $value, $rowData) {
	if ($rowData['iApprove_upd']<> 0 ) {
		$rows = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cApproval_direksi']))->row_array();

		if ($rowData['iApprove_upd'] == 2) {
			$palue='Approved by '.$rows['vName'].' pada '.$rowData['dApproval_upd'].', Remark :'.$rowData['vRemark'] ;	
		}else{
			$palue='Rejected by '.$rows['vName'].' pada '.$rowData['dApproval_upd'].', Remark :'.$rowData['vRemark'];	
		}
		
	}else{
		$palue='Waiting Approval';
	}

	if ($this->input->get('action') == 'view') {
		$return= $palue;

	}
	else{
		$return= $palue;
	}
	
	return $return;
}

function insertBox_daftar_upd_export_istandar_dok_id($field, $id){

	$sq="select * from dossier.dossier_standar_dok dok 
	inner join dossier.dossier_jenis_dok j on dok.ijenis_dok_id=j.ijenis_dok_id
	where dok.lDeleted=0 and j.lDeleted=0
	order by j.vjenis_dok ASC";
	$dt=$this->dbset->query($sq)->result_array();
	$o='<select id="'.$id.'" name="'.$id.'" class="required">';
	$o.='<option value="">---Pilih---</pilih>';
	foreach ($dt as $kt => $vt) {
		$label=$vt['vjenis_dok'];
		if($vt['ijenis_dok_id']==1){
			$neg=$this->dbset->query('select * from dossier.dossier_negara where lDeleted=0 and idossier_negara_id='.$vt['idossier_negara_id'])->row_array();
			$label=$label.'-'.$neg['vNama_Negara'];
		}
		$o.='<option value="'.$vt['istandar_dok_id'].'">'.$label.'</option>';
	}
	$o.='</select>';

	return $o;
}

function insertBox_daftar_upd_export_inegara_komparator($field, $id){
	$q=$this->dbset->query('select * from dossier.dossier_produsen_komparator where lDeleted=0');
	$o='<select id="'.$id.'" name="'.$id.'" class="required">';
	$o.='<option value="">---Pilih---</option>';
	if ($q->num_rows() > 0) {
                $r = $q->result_array();
                foreach($r as $row => $vr) {
                	$selected = '';
                   	$nr=strlen($vr['vNama_produsen']);
					if($nr>=50){
						$nama= substr($vr['vNama_produsen'], 0, 50);
					}else{
						$nama=$vr['vNama_produsen'];
					}
                   $o .= "<option value='".$vr['idossier_produsen_komparator_id']."'>".$vr['vKode_produsen']." - ".$nama."</option>";
                }
            }
	$o.='</select>';
	return $o;
}

function updateBox_daftar_upd_export_istandar_dok_id($field, $id, $value, $rowData) {
	$sq="select * from dossier.dossier_standar_dok dok 
	inner join dossier.dossier_jenis_dok j on dok.ijenis_dok_id=j.ijenis_dok_id
	where dok.lDeleted=0 and j.lDeleted=0
	order by j.vjenis_dok ASC";
	$dt=$this->dbset->query($sq)->result_array();
	$o='<select id="'.$id.'" name="'.$id.'" class="required">';
	$o.='<option value="">---Pilih---</pilih>';
	$v='';
	foreach ($dt as $kt => $vt) {
		$label=$vt['vjenis_dok'];
		if($vt['ijenis_dok_id']==1){
			$neg=$this->dbset->query('select * from dossier.dossier_negara where lDeleted=0 and idossier_negara_id='.$vt['idossier_negara_id'])->row_array();
			$label=$label.'-'.$neg['vNama_Negara'];
		}
		$sel=$vt['istandar_dok_id']==$value?'selected':'';
		if($vt['istandar_dok_id']==$value){
			$v=$label;
		}
		$o.='<option value="'.$vt['istandar_dok_id'].'" '.$sel.'>'.$label.'</option>';
	}
	$o.='</select>';
	if ($this->input->get('action') == 'view') {
		$r=$v;

	}else{
		$r=$o;
	}
	return $r;
}
function updateBox_daftar_upd_export_inegara_komparator($field, $id, $value, $rowData) {
	$q=$this->dbset->query('select * from dossier.dossier_produsen_komparator where lDeleted=0');
	$o='<select id="'.$id.'" name="'.$id.'">';
	$o.='<option value="">---Pilih---</option>';
	$v='-';
	if ($q->num_rows() > 0) {
        $r = $q->result_array();
        foreach($r as $row => $vr) {
        	$selected = '';
           	$nr=strlen($vr['vNama_produsen']);
			if($nr>=50){
				$nama= substr($vr['vNama_produsen'], 0, 50);
			}else{
				$nama=$vr['vNama_produsen'];
			}
			$sel=$value==$vr['idossier_produsen_komparator_id']?'selected':'';
			if($vr['idossier_produsen_komparator_id']==$value){
				$v=$vr['vKode_produsen']." - ".$vr['vNama_produsen'];
			}
           $o .= "<option value='".$vr['idossier_produsen_komparator_id']."' ".$sel.">".$vr['vKode_produsen']." - ".$nama."</option>";
        }
    }
	$o.='</select>';
	if ($this->input->get('action') == 'view') {
		$r=$v;

	}else{
		$r=$o;
	}
	return $r;
}

/*function pendukung start*/  
function before_update_processor($row, $postData) {
	
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;
	$postData['cApproval_direksi'] = NULL;
	$postData['iApprove_upd'] = NULL;

	// ubah status submit
	if($postData['isdraft']==true){
		$postData['iSubmit_upd']=0;
	} 
	else{$postData['iSubmit_upd']=1;} 
	return $postData;

}
function before_insert_processor($row, $postData) {
	
	// insert iteam andev

	//end 
	$postData['cApproval_direksi'] = NULL;
	$postData['iApprove_upd'] = NULL;
	$postData['dCreate'] = date('Y-m-d H:i:s');
	$postData['cCreated'] =$this->user->gNIP;

	// ubah status submit
		if($postData['isdraft']==true){
			$postData['iSubmit_upd']=0;
		} 
		else{$postData['iSubmit_upd']=1;} 

	return $postData;

}


function manipulate_update_button($buttons, $rowData) {
	$mydept = $this->auth_plcexport->my_depts(TRUE);
	$cNip= $this->user->gNIP;

	$js = $this->load->view('daftar_upd_export_js');

	$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/daftar/upd/export?action=approve&idossier_upd_id='.$rowData['idossier_upd_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_daftar_upd_export">Approve</button>';
	$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/daftar/upd/export?action=reject&idossier_upd_id='.$rowData['idossier_upd_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_daftar_upd_export">Reject</button>';

	$update = '<button onclick="javascript:update_btn_back(\'daftar_upd_export\', \''.base_url().'processor/plc/daftar/upd/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upd_export">Update & Submit</button>';
	$updatedraft = '<button onclick="javascript:update_draft_btn(\'daftar_upd_export\', \''.base_url().'processor/plc/daftar/upd/export?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_daftar_upd_export">Update as Draft</button>';



	if ($this->input->get('action') == 'view') {unset($buttons['update']);}

	else{
		unset($buttons['update_back']);
		unset($buttons['update']);

		if ($rowData['iSubmit_upd']== 0) {
			// jika masih draft , show button update draft & update submit 
			$buttons['update'] = $update.$updatedraft.$js;
		}else{
			// sudah disubmit , show button approval 
			if (isset($mydept)) {
				// jika punya team di plc2_upb_team
				if(in_array('BDI', $mydept)){
					// jika BDIRM , maka bisa approve
					$buttons['update'] = $approve.$reject.$js;	
				}
			}
			
		}
	}
	return $buttons;


}								
function manipulate_insert_button($buttons) {
	unset($buttons['save']);

	$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'daftar_upd_export\', \''.base_url().'processor/plc/daftar/upd/export?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_daftar_upd_export">Save as Draft</button>';
	$save = '<button onclick="javascript:save_btn_multiupload(\'daftar_upd_export\', \''.base_url().'processor/plc/daftar/upd/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Save &amp; Submit</button>';
	$js = $this->load->view('daftar_upd_export_js');
	$buttons['save'] = $save_draft.$save.$js;
	return $buttons;
}

public function after_update_processor($fields, $id, $post) {
	// kirim email notifikasi ke BDIRM 
	$qupd='SELECT dossier_upd.vUpd_no,dossier_upd.vNama_usulan,dossier_upd.dTanggal_upd,dossier_upd.cNip_pengusul,
		employee.vName,itemas.C_ITENO,itemas.C_ITNAM,dossier_upd.iSubmit_upd,(if(dossier_upd.iTeam_andev=17,91,78)) as bdi,dossier_upd.iTeam_andev as ad
		FROM dossier.dossier_upd 
		inner join plc2.itemas on itemas.C_ITENO=dossier_upd.iupb_id
		INNER JOIN plc2.tabmas02 ON tabmas02.c_lisensi = itemas.c_lisensi
		LEFT JOIN plc2.teamc ON teamc.c_teamc = itemas.c_teamc
		LEFT JOIN plc2.stocknpl ON stocknpl.c_iteno = itemas.c_iteno
		JOIN hrd.employee ON employee.cNip=dossier_upd.cNip_pengusul
		WHERE dossier_upd.idossier_upd_id='.$id;
	$rupd = $this->db_plc0->query($qupd)->row_array();

	$submit = $rupd['iSubmit_upd'] ;
	if ($rupd['ad'] == 17) {
		$iTeamandev = 'Andev Export 1';
		$vkode="DAFTAR_SUBMIT_AD1";
	}else{
		$iTeamandev = 'Andev Export 2';
		$vkode="DAFTAR_SUBMIT_AD2";
	}
	$iproses=3;
	if ($submit == 1) {
		$datain['cpic_ir']=$post['cpic_ir'];
		$datain['idossier_upd_id']=$post['idossier_upd_id'];
		$cek="select * from dossier.dossier_history_pic_ir ir where ir.lDeleted=0 and ir.idossier_upd_id = ".$post['idossier_upd_id']." ORDER BY ir.ihistory_id DESC";
		$qcek=$this->dbset->query($cek);
		if($qcek->num_rows()!=0){
			$dt=$qcek->row_array();
			$q="update dossier.dossier_history_pic_ir ir set ir.cpic_ir='".$post['idossier_upd_id']."' where ir.lDeleted=0 and ir.ihistory_id=".$dt['ihistory_id'];
			$this->dbset->query($q);
		}else{
			$datain['dCreate']=date('Y-m-d H:i:s');
			$datain['cCreated']=$this->user->gNIP;
			$this->dbset->insert('dossier.dossier_history_pic_ir',$datain);
		}
		$bdi = $rupd['bdi'];
		$team = $rupd['ad'];
		$sql="select * from dossier.dossier_sysparam where vsysparam='".$vkode."' and lDeleted=0";
		$dt=$this->dbset->query($sql)->row_array();
		$to = $dt['tto'];
		$cc = $dt['tcc'];                        

		$subject="Waiting Approval: UPD ".$rupd['vUpd_no'];
		$content="Diberitahukan bahwa telah ada input UPD yang membutuhkan approval dari BDIRM pada aplikasi PLC-Export dengan rincian sebagai berikut :<br><br>
			<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
				<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
					<tr>
						<td style='width: 110px;'><b>No UPD</b></td><td style='width: 20px;'> : </td><td>".$rupd['vUpd_no']."</td>
					</tr>
					<tr>
						<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['vNama_usulan']."</td>
					</tr>
					<tr>
						<td><b>Tanggal UPD</b></td><td> : </td><td>".$rupd['dTanggal_upd']."</td>
					</tr>
					<tr>
						<td><b>Nama Pengusul</b></td><td> : </td><td>".$rupd['cNip_pengusul'].' - '.$rupd['vName']."</td>
					</tr>
					<tr>
						<td><b>Produk</b></td><td> : </td><td>".$rupd['C_ITENO'].' - '.$rupd['C_ITNAM']."</td>
					</tr>
				</table>
			</div>
			<br/> 
			Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
			Post Master";
		$this->lib_utilitas->send_email($to, $cc, $subject, $content);
		
	}
	$this->dossier_log->insertlog($id,$this->input->get('modul_id'),$iproses);
}



function after_insert_processor($fields, $id, $post) {
		
		//update service_request autonumber No Brosur
		$nomor = "D".str_pad($id, 5, "0", STR_PAD_LEFT);
		$sql = "UPDATE dossier.dossier_upd SET vUpd_no = '".$nomor."' WHERE idossier_upd_id=$id LIMIT 1";
		$query = $this->db_plc0->query( $sql );

		// kirim email notifikasi ke BDIRM 
		$qupd='SELECT dossier_upd.vUpd_no,dossier_upd.vNama_usulan,dossier_upd.dTanggal_upd,dossier_upd.cNip_pengusul,
			employee.vName,itemas.C_ITENO,itemas.C_ITNAM,dossier_upd.iSubmit_upd,(if(dossier_upd.iTeam_andev=17,91,78)) as bdi,dossier_upd.iTeam_andev as ad
			FROM dossier.dossier_upd 
			inner join plc2.itemas on itemas.C_ITENO=dossier_upd.iupb_id
			INNER JOIN plc2.tabmas02 ON tabmas02.c_lisensi = itemas.c_lisensi
			LEFT JOIN plc2.teamc ON teamc.c_teamc = itemas.c_teamc
			LEFT JOIN plc2.stocknpl ON stocknpl.c_iteno = itemas.c_iteno
			JOIN hrd.employee ON employee.cNip=dossier_upd.cNip_pengusul
			WHERE dossier_upd.idossier_upd_id='.$id;
		$rupd = $this->db_plc0->query($qupd)->row_array();
		$submit = $rupd['iSubmit_upd'];
		$iproses=1;
		if ($submit == 1) {
			$iproses=2;

			//insert to dossier pic ir
			$datain['cpic_ir']=$post['cpic_ir'];
			$datain['idossier_upd_id']=$id;
			$cek="select * from dossier.dossier_history_pic_ir ir where ir.lDeleted=0 and ir.idossier_upd_id = ".$id." ORDER BY ir.ihistory_id DESC";
			$qcek=$this->dbset->query($cek);
			if($qcek->num_rows()!=0){
				$dt=$qcek->row_array();
				$q="update dossier.dossier_history_pic_ir ir set ir.cpic_ir='".$post['idossier_upd_id']."' where ir.lDeleted=0 and ir.ihistory_id=".$dt['ihistory_id'];
				$this->dbset->query($q);
			}else{
				$datain['dCreate']=date('Y-m-d H:i:s');
				$datain['cCreated']=$this->user->gNIP;
				$this->dbset->insert('dossier.dossier_history_pic_ir',$datain);
			}

			if ($rupd['ad'] == 17) {
				$iTeamandev = 'Andev Export 1';
				$vkode="DAFTAR_SUBMIT_AD1";
			}else{
				$iTeamandev = 'Andev Export 2';
				$vkode="DAFTAR_SUBMIT_AD2";
			}   

			$sql="select * from dossier.dossier_sysparam where vsysparam='".$vkode."' and lDeleted=0";
			$dt=$this->dbset->query($sql)->row_array();
			$to = $dt['tto'];
			$cc = $dt['tcc'];                        

				$subject="Waiting Approval: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada Input UPD yang membutuhkan approval dari BDIRM pada aplikasi PLC-Export dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>No UPD</b></td><td style='width: 20px;'> : </td><td>".$rupd['vUpd_no']."</td>
							</tr>
							<tr>
								<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['vNama_usulan']."</td>
							</tr>
							<tr>
								<td><b>Tanggal UPD</b></td><td> : </td><td>".$rupd['dTanggal_upd']."</td>
							</tr>
							<tr>
								<td><b>Nama Pengusul</b></td><td> : </td><td>".$rupd['cNip_pengusul'].' - '.$rupd['vName']."</td>
							</tr>
							<tr>
								<td><b>Produk</b></td><td> : </td><td>".$rupd['C_ITENO'].' - '.$rupd['C_ITNAM']."</td>
							</tr>
						</table>
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}
		$this->dossier_log->insertlog($id,$this->input->get('modul_id'),$iproses);
		
} 

	function approve_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
						return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var url = "'.base_url().'processor/plc/daftar/upd/export";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_daftar_upd_export").html(data);
										 $("#button_approve_daftar_upd_export").hide();
										 $("#button_reject_daftar_upd_export").hide();
									});
									
								}
									reload_grid("grid_daftar_upd_export");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_daftar_upd_export_approve" action="'.base_url().'processor/plc/daftar/upd/export?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_upd_id" value="'.$this->input->get('idossier_upd_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_daftar_upd_export_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_upd_id = $post['idossier_upd_id'];
		$vRemark = $post['vRemark'];

		$data=array('iApprove_upd'=>'2','cApproval_direksi'=>$cNip , 'dApproval_upd'=>date('Y-m-d H:i:s'), 'vRemark'=>$vRemark);
		$this -> db -> where('idossier_upd_id', $idossier_upd_id);
		$updet = $this -> db -> update('dossier.dossier_upd', $data);

		$iproses=6;
		$this->dossier_log->insertlog($idossier_upd_id,$this->input->post('modul_id'),$iproses);

		$qupd='SELECT dossier_upd.vUpd_no,dossier_upd.vNama_usulan,dossier_upd.dTanggal_upd,dossier_upd.cNip_pengusul,
			employee.vName,itemas.C_ITENO,itemas.C_ITNAM,dossier_upd.iSubmit_upd,(if(dossier_upd.iTeam_andev=17,91,78)) as bdi
			FROM dossier.dossier_upd 
			inner join plc2.itemas on itemas.C_ITENO=dossier_upd.iupb_id
			INNER JOIN plc2.tabmas02 ON tabmas02.c_lisensi = itemas.c_lisensi
			LEFT JOIN plc2.teamc ON teamc.c_teamc = itemas.c_teamc
			LEFT JOIN plc2.stocknpl ON stocknpl.c_iteno = itemas.c_iteno
			JOIN hrd.employee ON employee.cNip=dossier_upd.cNip_pengusul
			WHERE dossier_upd.idossier_upd_id='.$idossier_upd_id;
		$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit_upd'] ;

		if ($updet) {
			$bdi = $rupd['bdi'];
			$team = $bdi ;
			if ($rupd['bdi'] == 91) {
				$iTeamandev = 'Andev Export 1';
				$vkode="DAFTAR_APP_AD1";
			}else{
				$iTeamandev = 'Andev Export 2';
				$vkode="DAFTAR_APP_AD2";
			}  
			$sql="select * from dossier.dossier_sysparam where vsysparam='".$vkode."' and lDeleted=0";
			$dt=$this->dbset->query($sql)->row_array();
			$to = $dt['tto'];
			$cc = $dt['tcc'];                   

				$subject="Approval: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada approval UPD dari BDIRM pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>No UPD</b></td><td style='width: 20px;'> : </td><td>".$rupd['vUpd_no']."</td>
							</tr>
							<tr>
								<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['vNama_usulan']."</td>
							</tr>
							<tr>
								<td><b>Tanggal UPD</b></td><td> : </td><td>".$rupd['dTanggal_upd']."</td>
							</tr>
							<tr>
								<td><b>Nama Pengusul</b></td><td> : </td><td>".$rupd['cNip_pengusul'].' - '.$rupd['vName']."</td>
							</tr>
							<tr>
								<td><b>Produk</b></td><td> : </td><td>".$rupd['C_ITENO'].' - '.$rupd['C_ITNAM']."</td>
							</tr>
						</table>
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}

		$data['status']  = true;
		$data['last_id'] = $post['idossier_upd_id'];
		return json_encode($data);
	}

	function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_daftar_upd_export_remark").val();
					 	if (remark=="") {
					 		alert("Remark tidak boleh kosong ");
					 		return
					 	}
						return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var url = "'.base_url().'processor/plc/daftar/upd/export";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_daftar_upd_export").html(data);
										 $("#button_approve_daftar_upd_export").hide();
										 $("#button_reject_daftar_upd_export").hide();
									});
									
								}
									reload_grid("grid_daftar_upd_export");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_daftar_upd_export_reject" action="'.base_url().'processor/plc/daftar/upd/export?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_upd_id" value="'.$this->input->get('idossier_upd_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="reject_daftar_upd_export_remark"class="required" required="required"></textarea>
		<button type="button" onclick="submit_ajax(\'form_daftar_upd_export_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	
	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_upd_id = $post['idossier_upd_id'];
		$vRemark = $post['vRemark'];
		
		$data=array('iApprove_upd'=>'1','cApproval_direksi'=>$cNip , 'dApproval_upd'=>date('Y-m-d H:i:s'), 'vRemark'=>$vRemark);
		$this -> db -> where('idossier_upd_id', $idossier_upd_id);
		$updet = $this -> db -> update('dossier.dossier_upd', $data);
		$iproses=5;
		$this->dossier_log->insertlog($idossier_upd_id,$this->input->post('modul_id'),$iproses);
			$qupd='SELECT dossier_upd.vUpd_no,dossier_upd.vNama_usulan,dossier_upd.dTanggal_upd,dossier_upd.cNip_pengusul,
			employee.vName,itemas.C_ITENO,itemas.C_ITNAM,dossier_upd.iSubmit_upd,(if(dossier_upd.iTeam_andev=17,91,78)) as bdi
			FROM dossier.dossier_upd 
			inner join plc2.itemas on itemas.C_ITENO=dossier_upd.iupb_id
			INNER JOIN plc2.tabmas02 ON tabmas02.c_lisensi = itemas.c_lisensi
			LEFT JOIN plc2.teamc ON teamc.c_teamc = itemas.c_teamc
			LEFT JOIN plc2.stocknpl ON stocknpl.c_iteno = itemas.c_iteno
			JOIN hrd.employee ON employee.cNip=dossier_upd.cNip_pengusul
			WHERE dossier_upd.idossier_upd_id='.$idossier_upd_id;
		$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit_upd'] ;

		if ($updet) {
			$bdi = $rupd['bdi'];
			$team = $bdi ;
			//$team = '81' ;

	        if ($rupd['bdi'] == 91) {
				$iTeamandev = 'Andev Export 1';
				$vkode="DAFTAR_APP_AD1";
			}else{
				$iTeamandev = 'Andev Export 2';
				$vkode="DAFTAR_APP_AD2";
			}  
			$team = $rupd['ad'];
			$sql="select * from dossier.dossier_sysparam where vsysparam='".$vkode."' and lDeleted=0";
			$dt=$this->dbset->query($sql)->row_array();
			$to = $dt['tto'];
			$cc = $dt['tcc'];                         

			//$to = $arrEmail;
			//$cc = $toEmail2.';'.$toEmail;                        

				$subject="Approval: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada reject UPD dari BDIRM pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>No UPD</b></td><td style='width: 20px;'> : </td><td>".$rupd['vUpd_no']."</td>
							</tr>
							<tr>
								<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['vNama_usulan']."</td>
							</tr>
							<tr>
								<td><b>Tanggal UPD</b></td><td> : </td><td>".$rupd['dTanggal_upd']."</td>
							</tr>
							<tr>
								<td><b>Nama Pengusul</b></td><td> : </td><td>".$rupd['cNip_pengusul'].' - '.$rupd['vName']."</td>
							</tr>
							<tr>
								<td><b>Produk</b></td><td> : </td><td>".$rupd['C_ITENO'].' - '.$rupd['C_ITNAM']."</td>
							</tr>
						</table>
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}

		$data['status']  = true;
		$data['last_id'] = $post['idossier_upd_id'];
		return json_encode($data);
	}

	function copyupd($post){
		$id=$post['daftar_upd_export_idossier_upd_id'];
		$sql="select * from dossier.dossier_upd up where up.idossier_upd_id=".$id;
		$q=$this->dbset->query($sql);
		$data=array();
		$data['status']=false;
		$data['message']='Copy UPD Gagal';
		$data['last_id']=0;
		if($q->num_rows()!=0){
			$d=$q->row_array();
			$inda['dTanggal_upd']=$d['dTanggal_upd'];
			$inda['vNama_usulan']=$d['vNama_usulan'];
			$inda['cNip_pengusul']=$d['cNip_pengusul'];
			$inda['iupb_id']=$d['iupb_id'];
			$inda['iTeam_andev']=$d['iTeam_andev'];
			$inda['cpic_ir']=$d['cpic_ir'];
			$inda['inegara_komparator']=$d['inegara_komparator'];
			$inda['iperlu_be']=$d['iperlu_be'];
			$inda['isedia_be']=$d['isedia_be'];
			$inda['iulang_be']=$d['iulang_be'];
			$inda['dCreate']=date('Y-m-d H:i:s');
			$inda['cCreated']=$this->user->gNIP;
			$this->dbset->insert('dossier.dossier_upd',$inda);
			$que="select * from dossier_upd up where up.lDeleted=0 and up.dTanggal_upd='".$inda['dTanggal_upd']."' and up.vNama_usulan='".$inda['vNama_usulan']."' order by up.idossier_upd_id DESC";
			$qu=$this->dbset->query($que);
			if($qu->num_rows!=0){
				$qu=$qu->row_array();
				$id=$qu['idossier_upd_id'];
				$nomor = "D".str_pad($id, 5, "0", STR_PAD_LEFT);
				$sql = "UPDATE dossier.dossier_upd SET vUpd_no = '".$nomor."' WHERE idossier_upd_id=$id LIMIT 1";
				$query = $this->dbset->query( $sql );
				$data['status']=true;
				$data['message']='Copy UPD Berhasil';
				$data['last_id']=$id;
				$iproses=1;
				$this->dossier_log->insertlog($id,$this->input->get('modul_id'),$iproses);
			}
		}
		return json_encode($data);
	}
	
/*function pendukung end*/
	public function output(){
		$this->index($this->input->get('action'));
	}

}

