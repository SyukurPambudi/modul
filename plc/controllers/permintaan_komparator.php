<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class permintaan_komparator extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->load->library('lib_utilitas');
		$this->dbset = $this->load->database('dosier', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');

    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Permintaan Komparator');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_komparator');		
		$grid->setUrl('permintaan_komparator');
		$grid->addList('vNo_req_komparator','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','plc2_upb_team.vteam','iDok_Submit','dossier_upd.iTeam_andev','iApprove');
		$grid->setSortBy('vNo_req_komparator');
		$grid->setSortOrder('desc'); //sort ordernya

		$grid->addFields('vNo_req_komparator','idossier_upd_id','vNama_usulan','no_produk','name_produk','lisensi','dreq_komparator','vFileKom');

		//setting widht grid
		$grid->setWidth('vNo_req_komparator', '80'); 
		$grid->setWidth('dossier_upd.vUpd_no','100');
		$grid->setWidth('dossier_upd.vNama_usulan','400');
		$grid->setWidth('dosis','100');
		$grid->setWidth('vSediaan','100');
		$grid->setWidth('vUpb_Ref','100');
		$grid->setWidth('vEksisting','100');
		$grid->setWidth('plc2_upb_team.vteam','100');
		$grid->setWidth('vProduk_komparator','200');
		$grid->setWidth('vFileKom','100');
		$grid->setWidth('iDok_Submit','100');
		$grid->setWidth('iApprove', '150');
		$grid->setWidth('dossier_upd.iTeam_andev','-5');
		
		//modif label
		$grid->setLabel('vNo_req_komparator','No Req Komparator');
		$grid->setLabel('dossier_upd.vUpd_no','No Dossier');
		$grid->setLabel('idossier_upd_id','No Dossier');
		$grid->setLabel('dossier_upd.vNama_usulan','Nama Usulan');
		$grid->setLabel('vNama_usulan','Nama Usulan');
		$grid->setLabel('name_produk','Nama Produk');
		$grid->setLabel('vProduk_komparator','Requestor');
		$grid->setLabel('vFileKom','Permintaan Komparator');
		$grid->setLabel('dreq_komparator','Tanggal Permintaan Komprator');
		$grid->setLabel('iApprove','Approve Manager Dossier'); 
		$grid->setLabel('plc2_upb_team.vteam','Team Andev'); 
		$grid->setLabel('iDok_Submit','Status'); 


		$grid->setFormUpload(TRUE);

		$grid->setSearch('vNo_req_komparator','dossier_upd.vUpd_no','iDok_Submit');
		
		
		// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('iDok_Submit','combobox','',array(''=> 'Pilih',0=>'Draft - Need to be Publish',1=>'Submited'));
		$grid->changeFieldType('iApprove','combobox','',array(''=> 'Pilih',0=>'Waiting Approval',1=>'Reject',2=>'Approved'));
		

		//Field mandatori
		$grid->setRequired('vNo_req_komparator');	
		$grid->setRequired('idossier_upd_id');
		$grid->setRequired('vFileKom');
		$grid->setRequired('dreq_komparator');
		//join table
		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = dossier_komparator.idossier_upd_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_team','plc2_upb_team.iteam_id=dossier.dossier_upd.iTeam_andev','inner');
		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_upd.lDeleted', 0);

		$grid->setGridView('grid');
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				$idossier_upd_id=$_POST['permintaan_komparator_idossier_upd_id'];
				$cek_data = "select a.* from dossier.dossier_komparator as a where a.idossier_upd_id='".$idossier_upd_id."' and lDeleted=0";
                $data_cek = $this->dbset->query($cek_data)->row_array();
                if ($data_cek) {
                    $r['status'] = FALSE;
                    $r['message'] = "UPD Sudah Di Input!";
                    echo json_encode($r);
                    break;
                }else{
                	echo $grid->saved_form();
                }
                 //print_r($_POST);
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
					$post=$this->input->post();
					$idossier_komparator_id=$post['permintaan_komparator_idossier_komparator_id'];
					$idossier_upd_id=$_POST['permintaan_komparator_idossier_upd_id'];
					$idossier_upd_id_lm=$_POST['permintaan_komparator_idossier_upd_id_lm'];
					$cek_data = "select a.* from dossier.dossier_komparator as a where a.idossier_upd_id='".$idossier_upd_id."' and a.idossier_upd_id!='".$idossier_upd_id_lm."' and a.lDeleted='0'";
                    $data_cek = $this->dbset->query($cek_data)->row_array();
                    if ($data_cek) {
                     	$r['status'] = FALSE;
                        $r['message'] = "UPD Sudah Di Input!";
                        $r['last_id']=$idossier_upd_id_lm;
                        echo json_encode($r);
                        exit;
                    }else{
                    	$fileid	= '';
                    	foreach($_POST as $key=>$value) {
							if ($key == 'dossier_komparator_detail_id') {
								$i=0;
								foreach($value as $y=>$u) {
									$iddet[$y] = $u;
									if($i==0){
										$fileid .= "'".$u."'";
									}else{
										$fileid .= ",'".$u."'";
									}
									$i++;
								}
							}
							if ($key == 'idbahan') {
								$i=0;
								foreach($value as $y=>$u) {
									$idbahan[$y] = $u;
									$i++;
								}
							}
							if ($key == 'idprodusen') {
								foreach($value as $k=>$v) {
									$idprodusen[$k] = $v;
								}
							}
							if ($key == 'jumlah') {
								foreach($value as $k=>$v) {
									$jumlah[$k] = $v;
								}
							}
							if ($key == 'satuan') {
								foreach($value as $y=>$u) {
									$satuan[$y] = $u;
								}
							}
							if ($key == 'spek') {
								foreach($value as $y=>$u) {
									$spek[$y] = $u;
								}
							}
							if ($key == 'idbahan_ed') {
								$i=0;
								foreach($value as $y=>$u) {
									$idbahan_ed[$y] = $u;
									$i++;
								}
							}
							if ($key == 'idprodusen_ed') {
								foreach($value as $k=>$v) {
									$idprodusen_ed[$k] = $v;
								}
							}
							if ($key == 'jumlah_ed') {
								foreach($value as $k=>$v) {
									$jumlah_ed[$k] = $v;
								}
							}
							if ($key == 'satuan_ed') {
								foreach($value as $y=>$u) {
									$satuan_ed[$y] = $u;
								}
							}
							if ($key == 'spek_ed') {
								foreach($value as $y=>$u) {
									$spek_ed[$y] = $u;
								}
							}
						}
						$tgl= date('Y-m-d H:i:s');
						if($fileid!=""){
							$sql1="update dossier.dossier_komparator_detail set iDelete=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where idossier_komparator_id='".$idossier_komparator_id."' and dossier_komparator_detail_id not in (".$fileid.")";
						}else{
							$sql1="update dossier.dossier_komparator_detail set iDelete=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where idossier_komparator_id='".$idossier_komparator_id."'";
						}
						$this->dbset->query($sql1);
						if(isset($idbahan)){
							foreach ($idbahan as $kbahan => $vbahan) {
								$data=array();
								$data['idossier_bahan_komparator_id']=$idbahan[$kbahan];
								$data['idossier_produsen_komparator_id']=$idprodusen[$kbahan];
								$data['iJumlah']=$jumlah[$kbahan];
								$data['cSatuan']=$satuan[$kbahan];
								$data['vSpesifikasi']=$spek[$kbahan];
								$data['idossier_komparator_id']=$idossier_komparator_id;
								$data['cCreated']=$this->user->gNIP;
								$data['dCreate'] = date('Y-m-d H:i:s');
								$this->dbset->insert('dossier.dossier_komparator_detail',$data);
							}
						}
						if(isset($idbahan_ed)){
							foreach ($idbahan_ed as $kbahan_ed => $vbahan_ed) {
								$data_ed['idossier_bahan_komparator_id']=$idbahan_ed[$kbahan_ed];
								$data_ed['idossier_produsen_komparator_id']=$idprodusen_ed[$kbahan_ed];
								$data_ed['iJumlah']=$jumlah_ed[$kbahan_ed];
								$data_ed['cSatuan']=$satuan_ed[$kbahan_ed];
								$data_ed['vSpesifikasi']=$spek_ed[$kbahan_ed];
								$data_ed['cUpdate']=$this->user->gNIP;
								$data_ed['dupdate'] = date('Y-m-d H:i:s');
								$this->dbset->where('dossier_komparator_detail_id',$kbahan_ed);
								$this->dbset->update('dossier.dossier_komparator_detail',$data_ed);
							}
						}
                    	echo $grid->updated_form();
					}
					
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
			case 'employee_list':
				$this->employee_list();
			default:
				$grid->render_grid();
				break;
		}
    }
//Manipulate button
 function listBox_Action($row, $actions) {
	if($this->auth->is_manager()){
		$x=$this->auth->dept();
		$manager=$x['manager'];
		if(in_array('TD', $manager)){
			$type='TD';
			if($row->iDok_Submit==0){
				$actions['edit'];
				$actions['delete'];
			}else{
				if($row->iApprove==0){
					$actions['edit'];
					unset($actions['delete']);
				}
				else{
					unset($actions['edit']);
					unset($actions['delete']);
				}
			}
		}
		elseif(in_array('AD', $manager)){
			$type='AD';
			if($row->iDok_Submit==0){
				$actions['edit'];
				$actions['delete'];
			}else{
				if($row->iApprove==0){
					$actions['edit'];
					unset($actions['delete']);
				}
				else{
					unset($actions['edit']);
					unset($actions['delete']);
				}
			}
		}
		else{$type='';}
	}
	else{
		$x=$this->auth->dept();
		$team=$x['team'];
		if(in_array('AD', $team)){$type='AD';
			if($row->iDok_Submit!=0){
				unset($actions['delete']);
				unset($actions['edit']);
			}else{
				$q="select * from plc2.plc2_upb_team_item it where it.lDeleted=0 and it.vnip='".$this->user->gNIP."'";
				$dt=$this->dbset->query($q);
				if($dt->num_rows()!=0){
					$d=$dt->row_array();
					if($d['iapprove']!=1){
						unset($actions['delete']);
						unset($actions['edit']);
					}
				}else{}
			}
		}
		elseif(in_array('TD', $team)){$type='TD';
			if($row->iDok_Submit!=0){
				unset($actions['delete']);
				unset($actions['edit']);
			}
		}
		else{$type='';}
	}
	return $actions;
}

/*manipulasi view object form start*/
function insertBox_permintaan_komparator_vNo_req_komparator($field, $id) {

	$path = realpath("files/");
	if(!file_exists($path."/pddetail")){
		if (!mkdir($path."/pddetail", 0777, true)) { //id review
			die('Failed upload, try again!');
		}
	}

	$return = 'Auto Number';
	return $return;
}
function updateBox_permintaan_komparator_vNo_req_komparator($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return= $value;
		$return .= '<input type="hidden" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';

		
	}
	
	return $return;
}	

function insertBox_permintaan_komparator_idossier_upd_id($field, $id) {
		$nip=$this->user->gNIP;
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="isdraft" id="isdraft"><input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="15" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upd/komparator?field=permintaan_komparator&nip='.$nip.'\',\'List Komparator\')" type="button">&nbsp;</button>';                
		return $return;
}

function updateBox_permintaan_komparator_idossier_upd_id($field, $id, $value, $rowData) {
$sql = 'select b.vUpd_no as a1 from dossier_komparator as a, dossier_upd as b where a.idossier_upd_id=b.idossier_upd_id and a.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();

	if ($this->input->get('action') == 'view') {
		$return= $data_kom['a1'];

	}else{

		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';

		$return .= '<input type="hidden" name="isdraft" id="isdraft"><input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$value.'" class="input_rows1 required" />';
		if($rowData['iDok_Submit']==0){
			$return .= '<input type="hidden" name="'.$id.'_lm" id="'.$id.'_lm" value="'.$rowData['idossier_upd_id'].'" />';
			$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$rowData['idossier_upd_id'].'" />';
			$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="15" value="'.$data_kom['a1'].'"/>';
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/upd/komparator?field=permintaan_komparator\',\'List Komparator\')" type="button">&nbsp;</button>';
		}else{
			$return .=$data_kom['a1'];  
		}        
	}
	return $return; 
	
}


function insertBox_permintaan_komparator_vNama_usulan($field, $id) {
	$return = '<span id="'.$id.'">-</span>';
	return $return;
}

function updateBox_permintaan_komparator_vNama_usulan($field, $id, $value, $rowData) {
	$sql = 'SELECT * FROM dossier.dossier_komparator
	INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id=dossier_komparator.idossier_upd_id
	INNER JOIN plc2.itemas ON dossier_upd.iupb_id=itemas.C_ITENO
	INNER JOIN plc2.tabmas02 ON tabmas02.c_lisensi = itemas.c_lisensi
	where dossier_komparator.lDeleted=0 and dossier_upd.lDeleted=0 and dossier_komparator.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['vNama_usulan'];
	}
	else{
		$return = '<span id="'.$id.'">'.$data_kom['vNama_usulan'].'</span>';
	}
	return $return;
	
}	

function insertBox_permintaan_komparator_no_produk($field, $id) {
	$return = '<span id="'.$id.'">-</span>';
	return $return;
}

function updateBox_permintaan_komparator_no_produk($field, $id, $value, $rowData) {
	$sql = 'SELECT * FROM dossier.dossier_komparator
		INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id=dossier_komparator.idossier_upd_id
		INNER JOIN plc2.itemas ON dossier_upd.iupb_id=itemas.C_ITENO
		INNER JOIN plc2.tabmas02 ON tabmas02.c_lisensi = itemas.c_lisensi
		where dossier_komparator.lDeleted=0 and dossier_upd.lDeleted=0 and dossier_komparator.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['C_ITENO'];
	}
	else{
		$return = '<span id="'.$id.'">'.$data_kom['C_ITENO'].'</span>';
	}
	return $return;
	
}
function insertBox_permintaan_komparator_name_produk($field, $id) {
	$return = '<span id="'.$id.'">-</span>';
	return $return;
}

function updateBox_permintaan_komparator_name_produk($field, $id, $value, $rowData) {
	$sql = 'SELECT * FROM dossier.dossier_komparator
		INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id=dossier_komparator.idossier_upd_id
		INNER JOIN plc2.itemas ON dossier_upd.iupb_id=itemas.C_ITENO
		INNER JOIN plc2.tabmas02 ON tabmas02.c_lisensi = itemas.c_lisensi
		where dossier_komparator.lDeleted=0 and dossier_upd.lDeleted=0 and dossier_komparator.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['C_ITNAM'];
	}
	else{
		$return = '<span id="'.$id.'">'.$data_kom['C_ITNAM'].'</span>';
	}
	return $return;
	
}	
function insertBox_permintaan_komparator_lisensi($field, $id) {
	$return = '<span id="'.$id.'">-</span>';
	return $return;
}

function updateBox_permintaan_komparator_lisensi($field, $id, $value, $rowData) {
	$sql = 'SELECT * FROM dossier.dossier_komparator
		INNER JOIN dossier.dossier_upd ON dossier_upd.idossier_upd_id=dossier_komparator.idossier_upd_id
		INNER JOIN plc2.itemas ON dossier_upd.iupb_id=itemas.C_ITENO
		INNER JOIN plc2.tabmas02 ON tabmas02.c_lisensi = itemas.c_lisensi
		where dossier_komparator.lDeleted=0 and dossier_upd.lDeleted=0 and dossier_komparator.idossier_komparator_id="'.$rowData["idossier_komparator_id"].'"';
	$data_kom = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $data_kom['c_nmlisen'];
	}
	else{
		$return = '<span id="'.$id.'">'.$data_kom['c_nmlisen'].'</span>';
	}
	return $return;
	
}	

function insertBox_permintaan_komparator_dreq_komparator($field, $id) {
	$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="25" class="input_tgl datepicker required" style="width:175px"/>';
	$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
					
				</script>';
	return $return;
}

function updateBox_permintaan_komparator_dreq_komparator($field, $id, $value, $rowData) {
	if($this->input->get('action')=='view'){
		$return	=date('d-m-Y',strtotime($value));
	}else{
		if($rowData['iDok_Submit']==0){
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value='.$value.' />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
		}else{
			$return = $value;
		}
	}
	return $return;
}

function insertBox_permintaan_komparator_vFileKom($field, $id) {
		$data['date'] = date('Y-m-d H:i:s');
		return $this->load->view('permintaan_komparator_file',$data,TRUE);
	}
function updateBox_permintaan_komparator_vFileKom($field, $id, $value, $rowData) {

 	$idossier_komparator_id=$rowData['idossier_komparator_id'];
	$data['rows'] = $this->db_plc0->get_where('dossier.dossier_komparator_detail', array('idossier_komparator_id'=>$idossier_komparator_id, 'iDelete'=>0))->result_array();
	if ($this->input->get('action') == 'view') {
		return $this->load->view('permintaan_app_komparator_file',$data,TRUE);
	}else{
		if($rowData['iDok_Submit']==1){
			return $this->load->view('permintaan_app_komparator_file',$data,TRUE);
		}
		else{
			return $this->load->view('permintaan_komparator_file',$data,TRUE);
		}
	}
		
}

/*manipulasi view object form end*/

/*manipulasi proses object form start*/

    
   
/*manipulasi proses object form end*/    

/*function pendukung start*/  
function before_update_processor($row, $postData) {

	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;
	$postData['dreq_komparator']=date('Y-m-d',strtotime($postData['dreq_komparator']));
	unset($postData['permintaan_komparator_dreq_komparator']);
	if($postData['isdraft']==true){
		$postData['iDok_Submit']=0;
	} 
	else{$postData['iDok_Submit']=1;} 

	return $postData;

}
function before_insert_processor($row, $postData) {
	$postData['dreq_komparator']=date('Y-m-d',strtotime($postData['dreq_komparator']));
	unset($postData['permintaan_komparator_dreq_komparator']);
	$postData['dCreate'] = date('Y-m-d H:i:s');
	$postData['cCreate'] =$this->user->gNIP;
	if($postData['isdraft']==true){
		$postData['iDok_Submit']=0;
	} 
	else{$postData['iDok_Submit']=1;} 
	return $postData;

}


function manipulate_update_button($buttons, $rowData) {
	$cNip= $this->user->gNIP;

	$js = $this->load->view('permintaan_komparator_js');

	$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/permintaan/komparator?action=approve&idossier_komparator_id='.$rowData['idossier_komparator_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_permintaan_komparator">Approve</button>';
	$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/permintaan/komparator?action=reject&idossier_komparator_id='.$rowData['idossier_komparator_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_permintaan_komparator">Reject</button>';

	$update = '<button onclick="javascript:update_btn_back(\'permintaan_komparator\', \''.base_url().'processor/plc/permintaan/komparator?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_permintaan_komparator">Update & Submit</button>';
	$updatedraft = '<button onclick="javascript:update_draft_btn(\'permintaan_komparator\', \''.base_url().'processor/plc/permintaan/komparator?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_permintaan_komparator">Update as Draft</button>';



	if ($this->input->get('action') == 'view') {unset($buttons['update']);}
	else{
		unset($buttons['update_back']);
		unset($buttons['update']);
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('TD', $manager)){
				$type='TD';
				if($rowData['iDok_Submit']==0){
					$buttons['update']=$update.$updatedraft.$js;
				}else{
					if($rowData['iApprove']==0){
						$buttons['update']=$approve.$reject.$js;
					}
				}
			}
			elseif(in_array('AD', $manager)){
				$type='AD';
				if($rowData['iDok_Submit']==0){
					$buttons['update']=$update.$updatedraft.$js;
				}else{
					if($rowData['iApprove']==0){
						$buttons['update']=$approve.$reject.$js;
					}
				}
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('AD', $team)){$type='AD';
				if($rowData['iSubmit_bagi_staff']==0){
					$buttons['update']=$update.$updatedraft.$js;
				}else{
					$q="select * from plc2.plc2_upb_team_item it where it.lDeleted=0 and it.vnip='".$this->user->gNIP."'";
					$dt=$this->dbset->query($q);
					if($dt->num_rows()!=0){
						$d=$dt->row_array();
						if($d['iapprove']==1){
							$buttons['update']=$approve.$reject.$js;
						}
					}else{}
				}
			}
			elseif(in_array('TD', $team)){$type='TD';
				if($rowData['iSubmit_bagi_staff']==0){
					$buttons['update']=$update.$updatedraft.$js;
				}else{
					$q="select * from plc2.plc2_upb_team_item it where it.lDeleted=0 and it.vnip='".$this->user->gNIP."'";
					$dt=$this->dbset->query($q);
					if($dt->num_rows()!=0){
						$d=$dt->row_array();
						if($d['iapprove']==1){
							$buttons['update']=$approve.$reject.$js;
						}
					}else{}
				}
			}
			else{$type='';}
		}
	}
	return $buttons;


}								
function manipulate_insert_button($buttons) {
	unset($buttons['save']);

	$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'permintaan_komparator\', \''.base_url().'processor/plc/permintaan/komparator?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_permintaan_komparator">Save as Draft</button>';
	$save = '<button onclick="javascript:save_btn_multiupload(\'permintaan_komparator\', \''.base_url().'processor/plc/permintaan/komparator?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_permintaan_komparator">Save &amp; Submit</button>';
	$js = $this->load->view('permintaan_komparator_js');
	$buttons['save'] = $save_draft.$save.$js;

	return $buttons;
}

function after_update_processor($row, $insertId, $postData){
	$submit=$postData['iDok_Submit'];
	if ($submit == 1) {
			$qupd="select d.iteam_id as item,a.iDok_Submit as submit, a.vNo_req_komparator as no_komparator, b.vUpd_no as no_upd, b.vNama_usulan as nama_usulan, b.cNip_pengusul as nip, c.vName as name, b.iTeam_andev as ad 
			from dossier.dossier_komparator as a
			join dossier.dossier_upd as b on a.idossier_upd_id=b.idossier_upd_id
			join hrd.employee as c on b.cNip_pengusul=c.cNip
			join plc2.plc2_upb_team as d on b.iTeam_andev=d.iteam_id
			where a.idossier_komparator_id='".$insertId."'";
			$rupd = $this->db_plc0->query($qupd)->row_array();
			$vkode="";
			if ($rupd['ad'] == 17) {
				$iTeamandev = 'Andev Export 1';
				$vkode="REQ_KOMPARATOR_SUBMIT_TD1";
			}else{
				$iTeamandev = 'Andev Export 2';
				$vkode="REQ_KOMPARATOR_SUBMIT_TD2";
			}
			$sql="select * from dossier.dossier_sysparam where vsysparam='".$vkode."' and lDeleted=0";
			$dt=$this->dbset->query($sql)->row_array();
			$to = $dt['tto'];
			$cc = $dt['tcc'];                      

				$subject="Permintaan Komparator: <".$rupd['no_komparator'].">";
				$content="Diberitahukan bahwa telah ada permintaan komparator yang dialokasikan pada aplikasi PLC - Export dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #DCDCDC;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>No Komparator</b></td><td style='width: 20px;'> : </td><td>".$rupd['no_komparator']."</td>
							</tr>
							<tr>
								<td><b>No UPD</b></td><td> : </td><td>".$rupd['no_upd']."</td>
							</tr>
							<tr>
								<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['nama_usulan']."</td>
							</tr>
							<tr>
								<td><b>Nama Pengusul</b></td><td> : </td><td>".$rupd['nip']."-".$rupd['name']."</td>
							</tr>
						</table><br />
					</div><br/>
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}
}

function after_insert_processor($row, $insertId, $postData) {

		$cNip = $this->user->gNIP;
		$nomor = "K".str_pad($insertId, 4, "0", STR_PAD_LEFT);
		$sql = "UPDATE dossier.dossier_komparator SET vNo_req_komparator = '".$nomor."' WHERE idossier_komparator_id=$insertId LIMIT 1";
		$query = $this->db_plc0->query( $sql );
		$idbahan = array();
		$idprodusen= array();
		$jumlah=array();
		$satuan = array();
		$spek = array();
				
		foreach($_POST as $key=>$value) {
													
			if ($key == 'idbahan') {
				$i=0;
				foreach($value as $y=>$u) {
					$idbahan[$y] = $u;
					$i++;
				}
			}
							
			if ($key == 'idprodusen') {
				foreach($value as $k=>$v) {
					$idprodusen[$k] = $v;
				}
			}
			
			if ($key == 'jumlah') {
				foreach($value as $k=>$v) {
				$jumlah[$k] = $v;
				}
			}
			if ($key == 'satuan') {
				foreach($value as $y=>$u) {
					$satuan[$y] = $u;
					}
			}
			if ($key == 'spek') {
				foreach($value as $y=>$u) {
				$spek[$y] = $u;
				}
			}
		}
		$sql2= array();
		$y=0;
		$i=$i-1;
		for($x=0; $x<=$i; $x++){
			$data['id']=$insertId;
			$data['nip']=$this->user->gNIP;
			$data['dInsertDate'] = date('Y-m-d H:i:s');
			$sql2[] = "INSERT INTO dossier_komparator_detail (idossier_komparator_id, idossier_bahan_komparator_id, idossier_produsen_komparator_id, iJumlah, cSatuan, vSpesifikasi, dCreate, cCreated) VALUES ('".$data['id']."', '".$idbahan[$y]."','".$idprodusen[$y]."','".$jumlah[$y]."','".$satuan[$y]."','".$spek[$y]."','".$data['dInsertDate']."','".$data['nip']."')";
			$y++;	
		}
		foreach($sql2 as $q) {
			try {
				$this->dbset->query($q);
			}catch(Exception $e) {
				die($e);
			}
		}
		//Send Mail;
		$submit=$postData['iDok_Submit'];
		if ($submit == 1) {
			$qupd="select d.iteam_id as item,a.iDok_Submit as submit, a.vNo_req_komparator as no_komparator, b.vUpd_no as no_upd, b.vNama_usulan as nama_usulan, b.cNip_pengusul as nip, c.vName as name, b.iTeam_andev as ad 
			from dossier.dossier_komparator as a
			join dossier.dossier_upd as b on a.idossier_upd_id=b.idossier_upd_id
			join hrd.employee as c on b.cNip_pengusul=c.cNip
			join plc2.plc2_upb_team as d on b.iTeam_andev=d.iteam_id
			where a.idossier_komparator_id='".$insertId."'";
			$rupd = $this->db_plc0->query($qupd)->row_array();
			$vkode="";
			if ($rupd['ad'] == 17) {
				$iTeamandev = 'Andev Export 1';
				$vkode="REQ_KOMPARATOR_SUBMIT_TD1";
			}else{
				$iTeamandev = 'Andev Export 2';
				$vkode="REQ_KOMPARATOR_SUBMIT_TD2";
			}
			$sql="select * from dossier.dossier_sysparam where vsysparam='".$vkode."' and lDeleted=0";
			$dt=$this->dbset->query($sql)->row_array();
			$to = $dt['tto'];
			$cc = $dt['tcc'];                      

				$subject="Permintaan Komparator: <".$rupd['no_komparator'].">";
				$content="Diberitahukan bahwa telah ada permintaan komparator yang dialokasikan pada aplikasi PLC - Export dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #DCDCDC;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>No Komparator</b></td><td style='width: 20px;'> : </td><td>".$rupd['no_komparator']."</td>
							</tr>
							<tr>
								<td><b>No UPD</b></td><td> : </td><td>".$rupd['no_upd']."</td>
							</tr>
							<tr>
								<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['nama_usulan']."</td>
							</tr>
							<tr>
								<td><b>Nama Pengusul</b></td><td> : </td><td>".$rupd['nip']."-".$rupd['name']."</td>
							</tr>
						</table><br />
					</div><br/>
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}


}  
//update row iDelete
function hapus($table, $lastId){
	mysql_query("UPDATE dossier.".$table." SET iDelete=1 where idossier_komparator_id=".$lastId."");
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
								var url = "'.base_url().'processor/plc/permintaan/komparator";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=view&id="+last_id, function(data) {
										 $("div#form_permintaan_komparator").html(data);
									});
									
								}
									reload_grid("grid_permintaan_komparator");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_permintaan_komparator_approve" action="'.base_url().'processor/plc/permintaan/komparator?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_komparator_id" value="'.$this->input->get('idossier_komparator_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_permintaan_komparator_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_komparator_id = $post['idossier_komparator_id'];
		$vRemark = $post['vRemark'];
		$manager=0;
		$sqman="select count(b.iteam_id) as jmlman from dossier.dossier_upd as a
			join plc2.plc2_upb_team as b on a.iTeam_andev=b.iteam_id
			where b.vtipe='AD' and b.vnip='".$this->user->gNIP."'
			group by a.iTeam_andev";
		$datman=$this->dbset->query($sqman)->row_array();
		if(isset($datman['jmlman'])){
	 		$manager=$datman['jmlman'];
	 	}
	 	$date=date('Y-m-d H:i:s');
			$data=array('iApprove'=>'2','cApprove'=>$cNip , 'dApprove'=>$date, 'vRemark'=>$vRemark);
			$this -> db -> where('idossier_komparator_id', $idossier_komparator_id);
			$updet = $this -> db -> update('dossier.dossier_komparator', $data);
		//Kirim Email
			$qupd="select d.iteam_id as item,a.iDok_Submit as submit,a.vNo_req_komparator as no_komparator, b.vUpd_no as no_upd, b.vNama_usulan as nama_usulan, b.cNip_pengusul as nip, c.vName as name,b.iTeam_andev as ad 
			from dossier.dossier_komparator as a
			join dossier.dossier_upd as b on a.idossier_upd_id=b.idossier_upd_id
			join hrd.employee as c on b.cNip_pengusul=c.cNip
			join plc2.plc2_upb_team as d on b.iTeam_andev=d.iteam_id
			where a.idossier_komparator_id='".$idossier_komparator_id."'";
			$rupd = $this->db_plc0->query($qupd)->row_array();

			$vkode="";
			if ($rupd['ad'] == 17) {
				$iTeamandev = 'Andev Export 1';
				$vkode="REQ_KOMPARATOR_APP";
			}else{
				$iTeamandev = 'Andev Export 2';
				$vkode="REQ_KOMPARATOR_APP";
			}
			$sql="select * from dossier.dossier_sysparam where vsysparam='".$vkode."' and lDeleted=0";
			$dt=$this->dbset->query($sql)->row_array();
			$to = $dt['tto'];
			$cc = $dt['tcc'];      
                     

				$subject="Permintaan Komparator: <".$rupd['no_komparator'].">";
				$content="Diberitahukan bahwa telah ada permintaan komparator yang dialokasikan pada aplikasi PLC - Export dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #DCDCDC;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>No Komparator</b></td><td style='width: 20px;'> : </td><td>".$rupd['no_komparator']."</td>
							</tr>
							<tr>
								<td><b>No UPD</b></td><td> : </td><td>".$rupd['no_upd']."</td>
							</tr>
							<tr>
								<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['nama_usulan']."</td>
							</tr>
							<tr>
								<td><b>Nama Pengusul</b></td><td> : </td><td>".$rupd['nip']."-".$rupd['name']."</td>
							</tr>
						</table><br />
					</div><br/>
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				$this->lib_utilitas->send_email($to, $cc, $subject, $content);


		$data['status']  = true;
		$data['last_id'] = $post['idossier_komparator_id'];
		return json_encode($data);
	}

	function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_permintaan_komparator_vRemark").val();
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
								var url = "'.base_url().'processor/plc/permintaan/komparator";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=view&id="+last_id, function(data) {
										 $("div#form_permintaan_komparator").html(data);
									});
									
								}
									reload_grid("grid_permintaan_komparator");
							}
					 	 	
					 	 })
					
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_permintaan_komparator_reject" action="'.base_url().'processor/plc/permintaan/komparator?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_komparator_id" value="'.$this->input->get('idossier_komparator_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="reject_permintaan_komparator_vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_permintaan_komparator_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	
	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$idossier_komparator_id = $post['idossier_komparator_id'];
		$vRemark = $post['vRemark'];
		/*
		if($this->auth->is_dir()){
			$dApprove_direksi=date('Y-m-d H:i:s');
			$data=array('iApprove_direksi'=>'1','cApprove_direksi'=>$cNip , 'dApprove_direksi'=>$dApprove_direksi, 'vRemark_direksi'=>$vRemark);
			$this -> db -> where('idossier_komparator_id', $idossier_komparator_id);
			$updet = $this -> db -> update('dossier.dossier_komparator', $data);

		}
		elseif($this->auth->is_bdirm()){
			$dApprove_bdirm=date('Y-m-d H:i:s');
			$data=array('iApprove_bdirm'=>'1','cApprove_bdirm'=>$cNip , 'dApprove_bdirm'=>$dApprove_bdirm, 'vRemark_bdirm'=>$vRemark);
			$this -> db -> where('idossier_komparator_id', $idossier_komparator_id);
			$updet = $this -> db -> update('dossier.dossier_komparator', $data);
		}
		*/
			$date=date('Y-m-d H:i:s');
			$data=array('iApprove'=>'1','cApprove'=>$cNip , 'dApprove'=>$date, 'vRemark'=>$vRemark);
			$this -> db -> where('idossier_komparator_id', $idossier_komparator_id);
			$updet = $this -> db -> update('dossier.dossier_komparator', $data);
		$data['status']  = true;
		$data['last_id'] = $post['idossier_komparator_id'];
		return json_encode($data);
	}


	
/*function pendukung end*/    	


	public function output(){
		$this->index($this->input->get('action'));
	}

}
