<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class dokumen_dt_sas extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->dbset = $this->load->database('dosier', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->load->library('lib_utilitas');
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Dokumen Tambahan SAS');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_dok_td_sas');		
		$grid->setUrl('dokumen_dt_sas');
		$grid->addList('vNo_req_dok_td_sas','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','istatus');
		$grid->setSortBy('vNo_req_dok_td_sas');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('vNo_req_dok_td_sas','idossier_dok_sas_id','vNama_bahan','dosis','vSediaan','vUpb_Ref','vEksisting','team_andev','vProduk_komparator','vUpd_no','vNo_req_komparator','dok_td','vfile','dkirim_bde','dkirim_bpom');

		//setting widht grid
		$grid->setWidth('vNo_req_dok_td_sas', '100');
		$grid->setWidth('idossier_dok_sas_id', '150'); 
		$grid->setWidth('iDok_Submit', '150');
		$grid->setWidth('dok_td', '100');
		$grid->setWidth('dApprove', '100');
		$grid->setWidth('vUpd_no', '150');
		$grid->setWidth('dossier_upd.vUpd_no', '150');
		$grid->setWidth('vNama_bahan', '200');
		$grid->setWidth('dossier_upd.vNama_usulan', '200');
		$grid->setWidth('dosis', '100'); 
		$grid->setWidth('vSediaan', '100'); 
		$grid->setWidth('vUpb_Ref', '100'); 
		$grid->setWidth('vEksisting', '100'); 
		$grid->setWidth('team_andev', '100'); 
		$grid->setWidth('vProduk_komparator', '100'); 
		$grid->setWidth('vNo_req_komparator', '60');
		
		//modif label
		$grid->setLabel('vNo_req_dok_td_sas','Nomor Permintaan TD');
		$grid->setLabel('idossier_dok_sas_id','No Req SAS');
		$grid->setLabel('iDok_Submit','Status');
		$grid->setLabel('dok_td','Dokumen TD');
		$grid->setLabel('dApprove','Tanggal Approve');
		$grid->setLabel('vUpd_no','No Dossier');
		$grid->setLabel('dossier_upd.vUpd_no','No Dossier');
		$grid->setLabel('vNama_bahan','Nama Produk');
		$grid->setLabel('dossier_upd.vNama_usulan','Nama Produk');
		$grid->setLabel('dosis','Kekuatan'); 
		$grid->setLabel('vSediaan', 'Sediaan'); 
		$grid->setLabel('vUpb_Ref', 'UPB Referensi'); 
		$grid->setLabel('vEksisting', 'Nama Eksisting'); 
		$grid->setLabel('team_andev', 'Team Andev'); 
		$grid->setLabel('vNo_req_komparator','No Req Komparator'); 
		$grid->setLabel('vProduk_komparator', 'Nama Produk Komparator'); 
		$grid->setLabel('vfile', 'File Dokumen Tambahan SAS'); 
		$grid->setLabel('dkirim_bde', 'Tanggal Kirim BDE'); 
		$grid->setLabel('dkirim_bpom', 'Tanggal Kirim BPOM');
		$grid->setLabel('istatus', 'Status Dokumen Tambahan'); 

		$grid->setFormUpload(TRUE);
		$grid->setSearch('vNo_req_dok_td_sas','dossier_upd.vUpd_no','dossier_upd.vNama_usulan');
		$grid->changeFieldType('iDok_Submit','combobox','',array(''=>'-Pilih Semua-',0=>'Draft - Need to be Publish',1=>'Submited'));
		

		//Field mandatori
		$grid->setRequired('vNo_req_dok_td_sas');	
		$grid->setRequired('idossier_dok_sas_id');
		$grid->setRequired('dok_td');
		$grid->setRequired('dkirim_bde');
		$grid->setRequired('dkirim_bpom');
		//join table
		$grid->setJoinTable('dossier.dossier_dok_sas', 'dossier_dok_sas.idossier_dok_sas_id = dossier_dok_td_sas.idossier_dok_sas_id', 'inner');
		$grid->setJoinTable('dossier.dossier_komparator', 'dossier_komparator.idossier_komparator_id = dossier_dok_sas.idossier_komparator_id', 'inner');
		$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = dossier_komparator.idossier_upd_id', 'inner');

		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_upd.lDeleted', 0);
		
		//Set View Gridnya (Default = grid)
		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				$idossier_dok_sas_id=$_POST['dokumen_dt_sas_idossier_dok_sas_id'];
				$qsql="select a.* from dossier.dossier_dok_td_sas as a where a.idossier_dok_sas_id='".$idossier_dok_sas_id."'";
				$idossier_dok_sas_id=$_POST['dokumen_dt_sas_idossier_dok_sas_id'];
				$sql="select a.* from dossier.dossier_dok_td_sas as a where idossier_dok_sas_id='".$idossier_dok_sas_id."'" ;
				$data_cek = $this->dbset->query($sql)->row_array();
                if ($data_cek) {
                	   	$r['status'] = FALSE;
                     	$r['message'] = "No Dokumen SAS Sudah Ada!";
                        echo json_encode($r);
                        exit;
                }
                else{
                	echo $grid->saved_form();
                }
				break;
			case 'download':
				$i=$this->input->get('ipk');
				$data['ddown_dtsas_dok']=date('Y-m-d H:i:s');
				$this->dbset->where('idossier_file_dok_dt_sas_id',$i);
				$this->dbset->update('dossier.dossier_file_dok_dt_sas',$data);
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
				$isUpload = $this->input->get('isUpload');
				$post=$this->input->post();
				$idoksas= $post['dokumen_dt_sas_idossier_dok_td_sas_id'];
					$path = realpath("files/plc/dok_dt_sas/");
					if(!file_exists($path."/".$idoksas)){
						if (!mkdir($path."/".$idoksas, 0777, true)) { //id review
							die('Failed upload, try again!');
						}
					}
					$fileid='';
					$cPic_doktd_sas=array();
					foreach($_POST as $key=>$value) {

						if ($key == 'cPic_doktd_sas') {
							foreach($value as $y=>$u) {
								$cPic_doktd_sas[$y] = $u;
							}
						}
						if ($key == 'namafile_doktd_sas') {
							foreach($value as $k=>$v) {
								$file_name[$k] = $v;
							}
						}

						if ($key == 'fileid_doktd_sas') {
							$i=0;
							foreach($value as $k=>$v) {
								if($i==0){
									$fileid .= "'".$v."'";
								}else{
									$fileid .= ",'".$v."'";
								}
								$i++;
							}
						}
					}
				//print_r($post);
				if($isUpload) {
					
					if (isset($_FILES['fileupload_doktd_sas']))  {
						$i=0;
						foreach ($_FILES['fileupload_doktd_sas']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload_doktd_sas']["tmp_name"][$key];
								$name =$_FILES['fileupload_doktd_sas']["name"][$key];
								$data['name'] = $name;
								$data['date'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path."/".$idoksas."/".$name)) {
									$sql[] = "INSERT INTO dossier.dossier_file_dok_dt_sas (idossier_dok_td_sas_id, vDok_sas_name, dDate_sas_dok, cPic_sas, cCreated,dCreate) 
										VALUES ('".$idoksas."', '".$data['name']."','".$data['date']."','".$cPic_doktd_sas[$i]."','".$this->user->gNIP."','".$data['date']."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
							
						}
					
						foreach($sql as $sq) {
							try {
								$this->dbset->query($sq);
							}catch(Exception $e) {
								die($e);
							}
						}	

					}
					$r['status'] = TRUE;
					$r['last_id'] = $idoksas;	
					$r['message'] = 'Data Berhasil Disimpan';			
					echo json_encode($r);
					exit();
				}else{
					$idoksas= $post['dokumen_dt_sas_idossier_dok_td_sas_id'];
					$fileid='';
					foreach($_POST as $key=>$value) {
						if ($key == 'fileid_doktd_sas') {
							$i=0;
							foreach($value as $k=>$v) {
								if($i==0){
									$fileid .= "'".$v."'";
								}else{
									$fileid .= ",'".$v."'";
								}
								$i++;
							}
						}
					}
					$tgl= date('Y-m-d H:i:s');
					if($fileid!=''){
						$sql1="update dossier.dossier_file_dok_dt_sas set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where idossier_dok_td_sas_id='".$idoksas."' and idossier_file_dok_dt_sas_id not in (".$fileid.")";
					}else{
						$sql1="update dossier.dossier_file_dok_dt_sas set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where idossier_dok_td_sas_id=".$idoksas;
					}
					$this->dbset->query($sql1);
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
				break;
			case 'confirm1':
				$post=$this->input->post();
				$get=$this->input->get();
				$skg=date('Y-m-d H:i:s');
				$sql='select * from dossier.dossier_dok_td_sas td
						inner join dossier.dossier_dok_sas sas on sas.idossier_dok_sas_id=td.idossier_dok_sas_id
						inner join dossier.dossier_komparator kom on kom.idossier_komparator_id=sas.idossier_komparator_id
						inner join dossier.dossier_upd upd on upd.idossier_upd_id=kom.idossier_upd_id
						inner join plc2.plc2_upb up on upd.iupb_id=up.iupb_id
						where td.iDeleted=0 and kom.lDeleted=0 and upd.lDeleted=0 and up.ldeleted=0
						and td.idossier_dok_td_sas_id='.$post['id'];
				$rupb1=$this->dbset->query($sql)->result_array();
				$rupb=array();
				foreach ($rupb1 as $k => $v) {
					$rupb=$v;
				}
				$this->dbset->where('idossier_dok_td_sas_id', $post['id']);
				$this->dbset->update('dossier.dossier_dok_td_sas', array('iAccept'=>2,'cAccept'=>$this->user->gNIP,'dAccept'=>$skg,'dkirim_bpom'=>$post['dkirim_bpom']));

				//update untuk idoktd
				$this->dbset->where('idossier_dok_sas_id', $rupb['idossier_dok_sas_id']);
				$this->dbset->update('dossier.dossier_dok_sas', array('iDok_td'=>0));
		    	//Email ke admin 

				$toEmail='';
				$toEmail2='';
				//cek send mail by database
				
				$team=87;
				$toEmail = $this->lib_utilitas->get_email_team($team);
		        $toEmail2 = $this->lib_utilitas->get_email_leader($team);                        

		        $arrEmail = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );

		        $to = $cc = '';
		        if(is_array($arrEmail)) {
		                $count = count($arrEmail);
		                $to = $arrEmail[0];
		                for($i=1;$i<$count;$i++) {
		                        $cc.=isset($arrEmail[$i]) ? $arrEmail[$i].';' : ';';
		                }
		        }	

				$to = $toEmail;
		        $cc = $toEmail2;
		        $subject="Proses Dokumen Tambahan SAS: Nomor Permintaan TD ".$rupb['vNo_req_dok_td_sas'];
		        $content="
	                Diberitahukan bahwa telah ada Upload File Dokumen SAS oleh IR Team pada proses Dokumen Tambahan SAS(aplikasi PLC-Export) dengan rincian sebagai berikut :<br><br>
	                <div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
	                        <table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
	                                <tr>
	                                        <td style='width: 110px;'><b>No Request SAS</b></td><td style='width: 20px;'> : </td><td>".$rupb['vNo_req_sas']."</td>
	                                </tr>
	                                <tr>
	                                        <td style='width: 110px;'><b>No Dossier</b></td><td style='width: 20px;'> : </td><td>".$rupb['vUpd_no']."</td>
	                                </tr>
	                                <tr>
	                                        <td style='width: 110px;'><b>No Request Komparator</b></td><td style='width: 20px;'> : </td><td>".$rupb['vNo_req_komparator']."</td>
	                                </tr>
	                                <tr>
	                                        <td style='width: 110px;'><b>No UPB</b></td><td style='width: 20px;'> : </td><td>".$rupb['vupb_nomor']."</td>
	                                </tr>
	                                <tr>
	                                        <td><b>Nama Usulan</b></td><td> : </td><td>".$rupb['vupb_nama']."</td>
	                                </tr>
	                                <tr>
	                                        <td><b>Nama Generik</b></td><td> : </td><td>".$rupb['vgenerik']."</td>
	                                </tr>
	                        </table>
	                </div>
	                <br/> 
	                Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
	                Post Master";
	        		$this->lib_utilitas->send_email($to, $cc, $subject, $content);

				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Accept Success!';
				echo json_encode($r);
				exit();
			break;
			case 'cekupd':
				$idossier_dok_sas_id=$_POST['dokumen_dt_sas_idossier_dok_sas_id'];
				$idossier_dok_sas_id_lm=$_POST['dokumen_dt_sas_idossier_dok_sas_id_lm'];
				$qsql="select a.* from dossier.dossier_dok_td_sas as a where a.idossier_dok_sas_id='".$idossier_dok_sas_id."' and a.idossier_dok_sas_id!='".$idossier_dok_sas_id."' and iDeleted=0";
				$data_cek = $this->dbset->query($qsql)->num_rows();
                if ($data_cek>=1) {
            	   	$r['status'] = FALSE;
                 	$r['message'] = "No Dokumen SAS Sudah Ada!";
                    echo json_encode($r);
                    exit;
                }
                else{
                	$r['status'] = TRUE;
                 	$r['message'] = "RaidenArmy!";
                    echo json_encode($r);
                    exit;
                }
			break;	
			default:
				$grid->render_grid();
				break;
		}
    }

function listBox_Action($row, $actions) {
	if($this->auth->is_manager()){
		$x=$this->auth->dept();
		$manager=$x['manager'];
		if(in_array('IR', $manager)){
			$type='IR';
			if (($row->iDok_Submit== 0)&&($row->iApprove== 0)) {
			}elseif(($row->iDok_Submit== 1)&&($row->iApprove== 0)){
				unset($actions['delete']);
			}elseif(($row->iDok_Submit== 1)&&($row->iApprove== 2)&&($row->iFileupload_submit== 0)){
				unset($actions['delete']);
			}elseif(($row->iDok_Submit== 1)&&($row->iApprove== 2)&&($row->iFileupload_submit== 1)&&($row->iFiledownload_submit==0)){
				unset($actions['delete']);
			}else{
				unset($actions['delete']);unset($actions['edit']);
			}
		}elseif(in_array('BDE', $manager)){
			$type='BDE';
			if(($row->iDok_Submit== 1)&&($row->iApprove== 2)&&($row->iFileupload_submit== 1)&&($row->iFiledownload_submit==1)&&($row->iAccept==0)){
				unset($actions['delete']);
			}else{
				unset($actions['delete']);unset($actions['edit']);
			}
		}
		else{$type='';}
	}
	else{
		$x=$this->auth->dept();
		$team=$x['team'];
		if(in_array('IR', $team)){$type='IR';
			if (($row->iDok_Submit== 0)&&($row->iApprove== 0)) {
			}elseif(($row->iDok_Submit== 1)&&($row->iApprove== 2)&&($row->iFileupload_submit== 0)){
				unset($actions['delete']);
			}else{
				unset($actions['delete']);unset($actions['edit']);
			}
		}
		else{$type='';unset($actions['delete']);unset($actions['edit']);}
	}
	/*if($this->auth->is_manager()){
		$x=$this->auth->dept();
		$manager=$x['manager'];
		if(in_array('IR', $manager)){
			if($row->iDok_Submit<>0){
				unset($actions['edit']);
				unset($actions['delete']);
			}
		}
		else{
			unset($actions['edit']);
			unset($actions['delete']);
		}
	}else{
		$x=$this->auth->dept();
		$team=$x['team'];
		if(in_array('IR', $team)){
			if($row->iDok_Submit<>0){
				unset($actions['edit']);
				unset($actions['delete']);
			}
		}
		else{
			unset($actions['edit']);
			unset($actions['delete']);
		}
	}*/
	return $actions;
} 

function listBox_dokumen_dt_sas_istatus($value,$pk,$name,$row) {
		$return='';
		if (($row->iDok_Submit== 0)&&($row->iApprove== 0)) {
			$return	='Draft-Dokumen Tambahan SAS';
			}elseif(($row->iDok_Submit== 1)&&($row->iApprove== 0)){
				$return	='Submit-Dokumen Tambahan SAS';
			}elseif(($row->iDok_Submit== 1)&&($row->iApprove== 2)&&($row->iFileupload_submit== 0)){
				$return	='Draft-Upload Dokumen Tambahan SAS';
			}elseif(($row->iDok_Submit== 1)&&($row->iApprove== 2)&&($row->iFileupload_submit== 1)&&($row->iFiledownload_submit==0)){
				$return	='Draft-Download Dokumen Tambahan SAS';
			}elseif(($row->iDok_Submit== 1)&&($row->iApprove== 2)&&($row->iFileupload_submit== 1)&&($row->iFiledownload_submit==1)&&($row->iAccept==0)){
				$return	='Waiting Accept BDE';
			}elseif(($row->iDok_Submit== 1)&&($row->iApprove== 2)&&($row->iFileupload_submit== 1)&&($row->iFiledownload_submit==1)&&($row->iAccept==2)){
				$return	='Accepted BDE';
			}elseif($row->iApprove==1){
				$return ='Rejected By IR-SPV';
			}elseif($row->iAccept==1){
				$return ='Rejected By BDE';
			}else{
				$return='-';
			}
    	return $return;
    }

/*manipulasi view object form start*/
function insertBox_dokumen_dt_sas_vNo_req_dok_td_sas($field, $id) {
	$return = 'Auto Number';
	return $return;
}
function updateBox_dokumen_dt_sas_vNo_req_dok_td_sas($field, $id, $value, $rowData) {
	if ($this->input->get('action') == 'view') {
		$return= $value;

	}
	else{
		$return= $value;
		$return .= '<input type="hidden" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="15" />';

		
	}
	
	return $return;
}	

function insertBox_dokumen_dt_sas_idossier_dok_sas_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="hidden" name="isdraft" id="isdraft">';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="25" />';
		$return .= '&nbsp;<button class="icon_pop" onclick="browse(\''.base_url().'processor/plc/browse/doksas?field=dokumen_dt_sas\',\'List Dokumen SAS\')" type="button">&nbsp;</button>';                
		return $return;
}

function updateBox_dokumen_dt_sas_idossier_dok_sas_id($field, $id, $value, $rowData) {
	$sql = 'select b.vNo_req_sas as a1, a.idossier_dok_sas_id as b1 from dossier_dok_td_sas as a, dossier_dok_sas as b where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'"';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{

		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';

		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" value="'.$dtkm['b1'].'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" class="" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="25" value="'.$dtkm['a1'].'"/>';
		$return .= '<input type="hidden" name="isdraft" id="isdraft">';
		$return .= '<input type="hidden" name="'.$id.'_lm" id="'.$id.'_lm" value="'.$rowData['idossier_dok_sas_id'].'" >';
		if($rowData['iDok_Submit']==0){
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/doksas?field=dokumen_dt_sas\',\'List Komparator\')" type="button">&nbsp;</button>';                
		}            
	}
	return $return; 
	
}

function insertBox_dokumen_dt_sas_dosis($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" disabled="TRUE" size="25" />';
	return $return;
}

function updateBox_dokumen_dt_sas_dosis($field, $id, $value, $rowData) {
	$sql = 'select c.dosis as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}

function insertBox_dokumen_dt_sas_vSediaan($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" disabled="TRUE" size="25" />';
	return $return;
}

function updateBox_dokumen_dt_sas_vSediaan($field, $id, $value, $rowData) {
	$sql = 'select f.vSediaan as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}

function insertBox_dokumen_dt_sas_vUpb_Ref($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" disabled="TRUE" size="25" />';
	return $return;
}


function updateBox_dokumen_dt_sas_vUpb_Ref($field, $id, $value, $rowData) {
	$sql = 'select c.vupb_nomor as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}

function insertBox_dokumen_dt_sas_vEksisting($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" disabled="TRUE" size="25" />';
	return $return;
}

function updateBox_dokumen_dt_sas_vEksisting($field, $id, $value, $rowData) {
	$sql = 'select c.vupb_nama as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}

function insertBox_dokumen_dt_sas_team_andev($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" disabled="TRUE" size="25" />';
	return $return;
}

function updateBox_dokumen_dt_sas_team_andev($field, $id, $value, $rowData) {
	$sql = 'select g.vteam as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f, plc2.plc2_upb_team as g where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id and e.iTeam_andev=g.iteam_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}

function insertBox_dokumen_dt_sas_vProduk_komparator($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" disabled="TRUE" size="25" />';
	return $return;
}

function updateBox_dokumen_dt_sas_vProduk_komparator($field, $id, $value, $rowData) {
	$sql = 'select e.cNip_pengusul as a1, e.vNama_usulan as b1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f, plc2.plc2_upb_team as g where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id and e.iTeam_andev=g.iteam_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1']." - ".$dtkm['b1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].' - '.$dtkm['b1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}

function insertBox_dokumen_dt_sas_vNama_bahan($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" disabled="TRUE" size="25" />';
	return $return;
}

function updateBox_dokumen_dt_sas_vNama_bahan($field, $id, $value, $rowData) {
	$sql = 'select e.vNama_usulan as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f, plc2.plc2_upb_team as g, dossier.dossier_bahan_komparator as h where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id and e.iTeam_andev=g.iteam_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}

function insertBox_dokumen_dt_sas_vUpd_no($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" disabled="TRUE" size="25" />';
	return $return;
}

function updateBox_dokumen_dt_sas_vUpd_no($field, $id, $value, $rowData) {
	$sql = 'select e.vUpd_no as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f, plc2.plc2_upb_team as g, dossier.dossier_bahan_komparator as h where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id and e.iTeam_andev=g.iteam_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}

function insertBox_dokumen_dt_sas_vNo_req_komparator($field, $id) {
	$return = '<input type="text" name="'.$field.'"  id="'.$id.'" readonly="readonly"  class="input_rows1" disabled="TRUE" size="25" />';
	return $return;
}

function updateBox_dokumen_dt_sas_vNo_req_komparator($field, $id, $value, $rowData) {
	$sql = 'select d.vNo_req_komparator as a1 from dossier.dossier_dok_td_sas as a, dossier.dossier_dok_sas as b, plc2.plc2_upb as c, dossier.dossier_komparator as d, dossier.dossier_upd as e, hrd.mnf_sediaan as f, plc2.plc2_upb_team as g, dossier.dossier_bahan_komparator as h where a.idossier_dok_sas_id=b.idossier_dok_sas_id and a.idossier_dok_td_sas_id="'.$rowData['idossier_dok_td_sas_id'].'" and b.idossier_komparator_id=d.idossier_komparator_id and d.idossier_upd_id=e.idossier_upd_id and c.iupb_id=e.iupb_id and c.isediaan_id=f.isediaan_id and e.iTeam_andev=g.iteam_id';
	$dtkm = $this->dbset->query($sql)->row_array();
	if ($this->input->get('action') == 'view') {
		$return= $dtkm['a1'];

	}else{
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$dtkm['a1'].'" class="input_rows1" disabled="TRUE" size="25" />';
	}
	return $return;
	
}


function insertBox_dokumen_dt_sas_dok_td($field, $id) {
	$return = '<textarea name="'.$field.'"  id="'.$id.'" class="input_rows1" rows=2></textarea>';
	return $return;
}

function updateBox_dokumen_dt_sas_dok_td($field, $id, $value, $rowData) {
	$n=$rowData['iDok_Submit']!=0?'readonly="readonly"':'';
	if ($this->input->get('action') == 'view') {
		$return= $value;
	}
	else{
		$return = '<textarea name="'.$field.'"  id="'.$id.'" class="input_rows1" size="25" row="2" '.$n.'>'.$value.'</textarea>';
	}
	return $return;
	
}	

function insertBox_dokumen_dt_sas_vFile($field, $id) {
 	$return='<script>';
 	$return.='$("label[for=\''.$id.'\']").parent().remove()';
 	$return.='</script>';
 	return $return;
}
function insertBox_dokumen_dt_sas_dkirim_bpom($field, $id){
	$return='<script>';
 	$return.='$("label[for=\''.$id.'\']").parent().remove()';
 	$return.='</script>';
 	return $return;
}
function insertBox_dokumen_dt_sas_dkirim_bde($field, $id){
	$return='<script>';
 	$return.='$("label[for=\''.$id.'\']").parent().remove()';
 	$return.='</script>';
 	return $return;
}
function updateBox_dokumen_dt_sas_vFile($field, $id, $value, $rowData) {
	if($rowData['iFileupload_submit']== 0){
		$data['status']=0;
	}else{
		$data['status']=1;
	}
	$return='';
	if($rowData['iDok_Submit']==0){
		$return.='<script>';
	 	$return.='$("label[for=\''.$id.'\']").parent().remove()';
	 	$return.='</script>';
	}elseif(($rowData['iDok_Submit']!=0)&&($rowData['iApprove']==0)){
		$return.='<script>';
	 	$return.='$("label[for=\''.$id.'\']").parent().remove()';
	 	$return.='</script>';
	}else{
		$sqpic="select em.* from plc2.plc2_upb_team_item it
			inner join plc2.plc2_upb_team te on it.iteam_id=te.iteam_id
			inner join hrd.employee em on em.cNip=it.vnip
			where te.vtipe='AD' and it.ldeleted=0 and te.ldeleted=0 and em.lDeleted=0 ";
		$data['cpic']=$this->dbset2->query($sqpic)->result_array();
	 	$idossier_dok_td_sas_id=$rowData['idossier_dok_td_sas_id'];
		$data['rows'] = $this->db_plc0->get_where('dossier.dossier_file_dok_dt_sas', array('idossier_dok_td_sas_id'=>$idossier_dok_td_sas_id,'lDeleted'=>0))->result_array();
		$return.=$this->load->view('upload_doktd_sas_file',$data,TRUE);
	}
	return $return;
}

function updateBox_dokumen_dt_sas_dkirim_bde($field, $id, $value, $rowData){
	$return='';
	if(($rowData['iDok_Submit']== 1)&&($rowData['iApprove']== 2)&&($rowData['iFileupload_submit']== 1)){
		if(($value=='')||($value==NULL)||($value=='0000-00-00')){
			$value='';
		}
		$disabled=$rowData['iFiledownload_submit']==1?'Disabled="TRUE"':'';
	 	$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" '.$disabled.' style="width:130px" value="'.$value.'"/>';
		$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
					</script>';
	 }else{
	 	$return.='<script>';
	 	$return.='$("label[for=\''.$id.'\']").parent().remove()';
	 	$return.='</script>';
	 }
	 return $return;
}
function updateBox_dokumen_dt_sas_dkirim_bpom($field, $id, $value, $rowData){
	$type='';
	if($this->auth->is_manager()){
		$x=$this->auth->dept();
		$manager=$x['manager'];
		if(in_array('IR', $manager)){$type='IR';
		}elseif(in_array('BDE', $manager)){$type='BDE';
		}else{$type='';}
	}
	else{
		$x=$this->auth->dept();
		$team=$x['team'];
		if(in_array('IR', $team)){$type='IR';}
		else{$type='';}
	}
	$return='';
	if(($rowData['iDok_Submit']== 1)&&($rowData['iApprove']== 2)&&($rowData['iFileupload_submit']== 1)&&($rowData['iFiledownload_submit']==1)&&($type=='BDE')){
		if(($value=='')||($value==NULL)||($value=='0000-00-00')){
			$value='';
		}
		$disabled=$rowData['iAccept']!=0?'Disabled="TRUE"':'';
	 	$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" '.$disabled.' style="width:130px" value="'.$value.'"/>';
		$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"yy-mm-dd"});
					</script>';
	 }else{
	 	$return.='<script>';
	 	$return.='$("label[for=\''.$id.'\']").parent().remove()';
	 	$return.='</script>';
	 }
	 return $return;
}



/*manipulasi view object form end*/

/*manipulasi proses object form start*/

/*manipulasi proses object form end*/    

/*function pendukung start*/  
function before_update_processor($row, $postData) {
	//print_r($postData);exit();
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;
	if($postData['update']==1){
		if($postData['isdraft']==true){
			$postData['iDok_Submit']=0;
		} 
		else{$postData['iDok_Submit']=1;} 
	}elseif($postData['update']==2){
		if($postData['isdraft']==true){
			$postData['iFileupload_submit']=0;
		} 
		else{$postData['iFileupload_submit']=1;} 
	}elseif($postData['update']==3){
		if($postData['isdraft']==true){
			$postData['iFiledownload_submit']=0;
		} 
		else{$postData['iFiledownload_submit']=1;} 
	}
	return $postData; 

}
function before_insert_processor($row, $postData) {
	$postData['cApproval_sas'] = NULL;
	$postData['dApproval_sas'] = NULL;
	$postData['dCreate'] = date('Y-m-d H:i:s');
	$postData['cCreate'] =$this->user->gNIP;
	if($postData['isdraft']==true){
		$postData['iDok_Submit']=0;
	} 
	else{$postData['iDok_Submit']=1;} 
	return $postData;

}

function after_update_processor($row, $insertId, $postData){
	$sql='select * from dossier.dossier_dok_td_sas td
			inner join dossier.dossier_dok_sas sas on sas.idossier_dok_sas_id=td.idossier_dok_sas_id
			inner join dossier.dossier_komparator kom on kom.idossier_komparator_id=sas.idossier_komparator_id
			inner join dossier.dossier_upd upd on upd.idossier_upd_id=kom.idossier_upd_id
			inner join plc2.plc2_upb up on upd.iupb_id=up.iupb_id
			where td.iDeleted=0 and kom.lDeleted=0 and upd.lDeleted=0 and up.ldeleted=0
			and td.idossier_dok_td_sas_id='.$postData['dokumen_dt_sas_idossier_dok_td_sas_id'];
	$rupb1=$this->dbset->query($sql)->result_array();
	$rupb=array();
	foreach ($rupb1 as $k => $v) {
		$rupb=$v;
	}
	if(isset($postData['iFileupload_submit'])){
		if($postData['iFileupload_submit']==1){
			$toEmail='';
			$toEmail2='';
		//cek send mail by database
			$toE=array();
			if(isset($postData['cPic_doktd_sas'])){
				foreach ($postData['cPic_doktd_sas'] as $kp => $vc) {
					$sql1="select * from hrd.employee em where em.cNip='".$vc."'";
					$dt=$this->dbset2->query($sql1)->row_array();
					$toE[]=$dt['vEmail'];
				}
			}
			$qtb="select * from dossier.dossier_file_dok_dt_sas dt 
			inner join hrd.employee em on em.cNip=dt.cPic_sas
			where dt.lDeleted=0 and dt.idossier_dok_td_sas_id=".$postData['dokumen_dt_sas_idossier_dok_td_sas_id'];
			$q=$this->dbset->query($qtb);
			if($q->num_rows()>=1){
				$dt=$q->row_array();
				$toE[]=$dt['vEmail'];
			}
			$i=0;
			
			foreach ($toE as $k => $v) {
				if ($i==0){
					$toEmail.=$v;
				}else{
					$toEmail.=';'.$v;
				}
				$i++;
			}

			$toEmail2='Supri@Novellpharm.com';

			$to = $toEmail;
	        $cc = $toEmail2;
	        $subject="Proses Dokumen Tambahan SAS: Nomor Permintaan TD ".$postData['vNo_req_dok_td_sas'];
	        $content="
	                Diberitahukan bahwa telah ada Upload File Dokumen Tambahan SAS oleh IR Team pada proses Dokumen Tambahan SAS(aplikasi PLC-Export) dengan rincian sebagai berikut :<br><br>
	                <div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
	                        <table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
	                                <tr>
	                                        <td style='width: 110px;'><b>No Request SAS</b></td><td style='width: 20px;'> : </td><td>".$rupb['vNo_req_sas']."</td>
	                                </tr>
	                                <tr>
	                                        <td style='width: 110px;'><b>No Dossier</b></td><td style='width: 20px;'> : </td><td>".$rupb['vUpd_no']."</td>
	                                </tr>
	                                <tr>
	                                        <td style='width: 110px;'><b>No Request Komparator</b></td><td style='width: 20px;'> : </td><td>".$rupb['vNo_req_komparator']."</td>
	                                </tr>
	                                <tr>
	                                        <td style='width: 110px;'><b>No UPB</b></td><td style='width: 20px;'> : </td><td>".$rupb['vupb_nomor']."</td>
	                                </tr>
	                                <tr>
	                                        <td><b>Nama Usulan</b></td><td> : </td><td>".$rupb['vupb_nama']."</td>
	                                </tr>
	                                <tr>
	                                        <td><b>Nama Generik</b></td><td> : </td><td>".$rupb['vgenerik']."</td>
	                                </tr>
	                        </table>
	                </div>
	                <br/> 
	                Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
	                Post Master";
	        		$this->lib_utilitas->send_email($to, $cc, $subject, $content);
		}
	}
	if(isset($postData['iFiledownload_submit'])){
		if($postData['iFiledownload_submit']==1){
			$toEmail='';
			$toEmail2='';
		//cek send mail by database
			$team=85;
			$toEmail = $this->lib_utilitas->get_email_team($team);
	        $toEmail2 = $this->lib_utilitas->get_email_leader($team);                        

	        $arrEmail = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );

	        $to = $cc = '';
	        if(is_array($arrEmail)) {
	                $count = count($arrEmail);
	                $to = $arrEmail[0];
	                for($i=1;$i<$count;$i++) {
	                        $cc.=isset($arrEmail[$i]) ? $arrEmail[$i].';' : ';';
	                }
	        }	

			$to = $toEmail;
	        $cc = $toEmail2;
	        $subject="Proses Dokumen Tambahan SAS: Nomor Permintaan TD ".$postData['vNo_req_dok_td_sas'];
	        $content="
	                Diberitahukan bahwa telah ada Upload File Dokumen SAS oleh IR Team pada proses Dokumen Tambahan SAS(aplikasi PLC-Export) dengan rincian sebagai berikut :<br><br>
	                <div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
	                        <table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
	                                <tr>
	                                        <td style='width: 110px;'><b>No Request SAS</b></td><td style='width: 20px;'> : </td><td>".$rupb['vNo_req_sas']."</td>
	                                </tr>
	                                <tr>
	                                        <td style='width: 110px;'><b>No Dossier</b></td><td style='width: 20px;'> : </td><td>".$rupb['vUpd_no']."</td>
	                                </tr>
	                                <tr>
	                                        <td style='width: 110px;'><b>No Request Komparator</b></td><td style='width: 20px;'> : </td><td>".$rupb['vNo_req_komparator']."</td>
	                                </tr>
	                                <tr>
	                                        <td style='width: 110px;'><b>No UPB</b></td><td style='width: 20px;'> : </td><td>".$rupb['vupb_nomor']."</td>
	                                </tr>
	                                <tr>
	                                        <td><b>Nama Usulan</b></td><td> : </td><td>".$rupb['vupb_nama']."</td>
	                                </tr>
	                                <tr>
	                                        <td><b>Nama Generik</b></td><td> : </td><td>".$rupb['vgenerik']."</td>
	                                </tr>
	                        </table>
	                </div>
	                <br/> 
	                Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
	                Post Master";
	        		$this->lib_utilitas->send_email($to, $cc, $subject, $content);
		}
	}
}

function manipulate_update_button($buttons, $rowData) {
	unset($buttons['update']);
	$cNip= $this->user->gNIP;
	$js = $this->load->view('dokumen_dt_sas_js');
	$jsupload = $this->load->view('uploadjs');

	//print_r($rowData);exit();
	$id=$rowData['idossier_dok_td_sas_id'];
	$no=$rowData['vNo_req_dok_td_sas'];
	
	$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/dokumen/dt/sas?action=approve&idossier_dok_td_sas_id='.$rowData['idossier_dok_td_sas_id'].'&company_id='.$this->input->get('company_id').'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_dokumen_dt_sas">Approve</button>';
	$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/dokumen/dt/sas?action=reject&idossier_dok_td_sas_id='.$rowData['idossier_dok_td_sas_id'].'&company_id='.$this->input->get('company_id').'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_dokumen_dt_sas">Reject</button>';

	$update = '<button onclick="javascript:update_btn_1(\'dokumen_dt_sas\', \''.base_url().'processor/plc/dokumen/dt/sas?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_dokumen_dt_sas">Update & Submit</button>';
	$updatedraft = '<button onclick="javascript:update_draft_1(\'dokumen_dt_sas\', \''.base_url().'processor/plc/dokumen/dt/sas?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_dokumen_dt_sas">Update as Draft</button>';
	$app1 = '<button onclick="javascript:setuju1(\'dokumen_dt_sas\', \''.base_url().'processor/plc/dokumen/dt/sas?action=confirm1&last_id='.$this->input->get('id').'&no='.$no.'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$id.', \''.$no.'\')" class="ui-button-text icon-save" id="button_save_dokumen_dt_sas">Accept</button>';

	$update2 = '<button onclick="javascript:update_btn_2(\'dokumen_dt_sas\', \''.base_url().'processor/plc/dokumen/dt/sas?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_dokumen_dt_sas">Update & Submit</button>';
	$updatedraft2 = '<button onclick="javascript:update_draft_2(\'dokumen_dt_sas\', \''.base_url().'processor/plc/dokumen/dt/sas?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_dokumen_dt_sas">Update as Draft</button>';
	
	$update3 = '<button onclick="javascript:update_btn_3(\'dokumen_dt_sas\', \''.base_url().'processor/plc/dokumen/dt/sas?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_dokumen_dt_sas">Update & Submit</button>';
	$updatedraft3 = '<button onclick="javascript:update_draft_3(\'dokumen_dt_sas\', \''.base_url().'processor/plc/dokumen/dt/sas?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_dokumen_dt_sas">Update as Draft</button>';
	
	//Cek Tanggal Download
	$sq="select * from dossier.dossier_file_dok_dt_sas det where det.lDeleted=0 and det.ddown_dtsas_dok is null and det.idossier_dok_td_sas_id=".$rowData['idossier_dok_td_sas_id'];
	$cfile=$this->dbset->query($sq)->num_rows();

	if ($this->input->get('action') == 'view') {unset($buttons['update']);}
	else{
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('IR', $manager)){
				$type='IR';
				if (($rowData['iDok_Submit']== 0)&&($rowData['iApprove']== 0)) {
					$buttons['update'] = $update.$updatedraft.$js;
				}elseif(($rowData['iDok_Submit']== 1)&&($rowData['iApprove']== 0)){
					$buttons['update'] = $approve.$reject;
				}elseif(($rowData['iDok_Submit']== 1)&&($rowData['iApprove']== 2)&&($rowData['iFileupload_submit']== 0)){
					$buttons['update'] = $update2.$updatedraft2.$js.$jsupload;
				}elseif(($rowData['iDok_Submit']== 1)&&($rowData['iApprove']== 2)&&($rowData['iFileupload_submit']== 1)&&($rowData['iFiledownload_submit']==0)){
					if($cfile==0){
						$buttons['update'] =  $update3.$updatedraft3.$js;
					}else{
						$buttons['update'] =  $updatedraft3.$js;
					}
				}else{

				}
			}elseif(in_array('BDE', $manager)){
				$type='BDE';
				if(($rowData['iDok_Submit']== 1)&&($rowData['iApprove']== 2)&&($rowData['iFileupload_submit']== 1)&&($rowData['iFiledownload_submit']==1)&&($rowData['iAccept']==0)){
					$buttons['update'] = $app1.$js;
				}else{
					
				}
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('IR', $team)){$type='IR';
				if (($rowData['iDok_Submit']== 0)&&($rowData['iApprove']== 0)) {
					$buttons['update'] = $update.$updatedraft.$js;
				}elseif(($rowData['iDok_Submit']== 1)&&($rowData['iApprove']== 2)&&($rowData['iFileupload_submit']== 0)){
					$buttons['update'] = $update2.$updatedraft2.$js.$jsupload;
				}else{

				}
			}
			else{$type='';}
		}
	}
	

	return $buttons;
}							
function manipulate_insert_button($buttons) {
	unset($buttons['save']);

	$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'dokumen_dt_sas\', \''.base_url().'processor/plc/dokumen/dt/sas?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_dokumen_dt_sas">Save as Draft</button>';
	$save = '<button onclick="javascript:save_btn_multiupload(\'dokumen_dt_sas\', \''.base_url().'processor/plc/dokumen/dt/sas?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_dokumen_dt_sas">Save &amp; Submit</button>';
	$js = $this->load->view('dokumen_dt_sas_js');
	$buttons['save'] = $save_draft.$save.$js;

	return $buttons;
}


public function after_insert_processor($fields, $id, $post) {
	$cNip = $this->user->gNIP;
	//update service_request autonumber No Brosur
	$nomor = "T".str_pad($id, 4, "0", STR_PAD_LEFT);
	$sql = "UPDATE dossier.dossier_dok_td_sas SET vNo_req_dok_td_sas = '".$nomor."' WHERE idossier_dok_td_sas_id=$id LIMIT 1";
	$query = $this->db_plc0->query( $sql );
}

public function approve_view() {
		$echo ='<script>
			function submit_ajax(form_id) {

				return $.ajax({
			 	 	url: $("#"+form_id).attr("action"),
			 	 	type: $("#"+form_id).attr("method"),
			 	 	data: $("#"+form_id).serialize(),
			 	 	success: function(data) {
			 	 		var o = $.parseJSON(data);							
						if(o.status == true) {
							$("#alert_dialog_form").dialog("close");
								$.get(base_url+"processor/plc/dokumen/dt/sas?action=update&id="+o.last_id+"&foreign_key="+o.foreign_id+"&company_id="+o.company_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
			                    $("div#form_dokumen_dt_sas").html(data);
			                });
							reload_grid("grid_dokumen_dt_sas");
						}
							
					}
			 	 	
			 	 })
			 }
		</script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_dokumen_dt_sas_approve" action="'.base_url().'processor/plc/dokumen/dt/sas?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_dok_td_sas_id" value="'.$this->input->get('idossier_dok_td_sas_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" ></textarea>
				<button type="button" onclick="submit_ajax(\'form_dokumen_dt_sas_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
}
    
function approve_process() {
	$post = $this->input->post();
	$nip = $this->user->gNIP;
	$skg=date('Y-m-d H:i:s');
	$this->db_plc0->where('idossier_dok_td_sas_id', $post['idossier_dok_td_sas_id']);
	$this->db_plc0->update('dossier.dossier_dok_td_sas', array('iApprove'=>2,'cApprove'=>$nip,'dApprove'=>$skg,'vapp_remark'=>$post['vRemark']));
	$data['status']  = true;
	$data['last_id'] = $post['idossier_dok_td_sas_id'];
	$data['group_id']=$post['group_id'];
	$data['modul_id']=$post['modul_id'];
	return json_encode($data);
}
    
function reject_view() {
    	$echo ='<script>
			function submit_ajax(form_id) {
				var vRemark = $("#vRemark").val();
				if(vRemark!=""){
					return $.ajax({
				 	 	url: $("#"+form_id).attr("action"),
				 	 	type: $("#"+form_id).attr("method"),
				 	 	data: $("#"+form_id).serialize(),
				 	 	success: function(data) {
				 	 		var o = $.parseJSON(data);							
							if(o.status == true) {
								$("#alert_dialog_form").dialog("close");
									$.get(base_url+"processor/plc/dokumen/dt/sas?action=update&id="+o.last_id+"&foreign_key="+o.foreign_id+"&company_id="+o.company_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
				                    $("div#form_dokumen_dt_sas").html(data);
				                });
								reload_grid("grid_dokumen_dt_sas");
							}
								
						}
				 	 	
				 	 })
				}
			 }
		</script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_dokumen_dt_sas_reject" action="'.base_url().'processor/plc/dokumen/dt/sas?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="idossier_dok_td_sas_id" value="'.$this->input->get('idossier_dok_td_sas_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" class="required"></textarea>
				<button type="button" onclick="submit_ajax(\'form_dokumen_dt_sas_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
}
    
function reject_process () {
	$post = $this->input->post();
	$nip = $this->user->gNIP;
	$skg=date('Y-m-d H:i:s');
	$this->db_plc0->where('idossier_dok_td_sas_id', $post['idossier_dok_td_sas_id']);
	$this->db_plc0->update('dossier.dossier_dok_td_sas', array('iApprove'=>1,'cApprove'=>$nip,'dApprove'=>$skg,'vapp_remark'=>$post['vRemark']));
	$data['status']  = true;
	$data['last_id'] = $post['idossier_dok_td_sas_id'];
	$data['group_id']=$post['group_id'];
	$data['modul_id']=$post['modul_id'];
	return json_encode($data);
}

function download($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/dok_dt_sas/'.$id.'/'.$name);	
		force_download($name, $path);
	}

/*function pendukung end*/    	


public function output(){
		$this->index($this->input->get('action'));
	}

}
