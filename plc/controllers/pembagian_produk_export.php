<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pembagian_produk_export extends MX_Controller {
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
		$grid->setTitle('Pembagian Produk');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_upd');		
		$grid->setUrl('pembagian_produk_export');
		$grid->addList('vUpd_no','vNama_usulan','iSubmit_bagi_upd','dossier_prioritas.iSemester','dossier_prioritas.iTahun');
		$grid->setSortBy('vUpd_no');
		$grid->setSortOrder('DESC'); //sort ordernya

		$grid->addFields('vUpd_no','dTanggal_upd','vNama_usulan','iupb_id','nama_generik','iTeam_andev','iSediaan','iNegara');

		//setting widht grid
		$grid ->setWidth('vUpd_no', '100'); 
		$grid->setWidth('lDeleted', '100'); 
		
		
		//modif label
		$grid->setLabel('vUpd_no','No UPD'); 
		$grid->setLabel('vNama_usulan','Nama Usulan'); 
		$grid->setLabel('iTeam_andev','Team Andev'); 
		$grid->setLabel('iNegara','Negara'); 
		$grid->setLabel('iSediaan','Sediaan'); 
		$grid->setLabel('iupb_id','No UPB'); 
		$grid->setLabel('iApprove_upd','Status Approval'); 
		$grid->setLabel('iSubmit_bagi_upd','Status Pembagian Produk'); 
		$grid->setLabel('dTanggal_upd','Tanggal UPD'); 
		$grid->setLabel('dApproval_upd','Tanggal Approve'); 
		$grid->setLabel('cApproval_direksi','Approve by'); 
		$grid->setLabel('employee.vName','Nama Pengusul');
		$grid->setLabel('dossier_prioritas.iSemester','Semester Prioritas'); 
		$grid->setLabel('dossier_prioritas.iTahun','Tahun Prioritas');

		$grid->setFormUpload(TRUE);

		$grid->setSearch('vUpd_no');
		
		
	// ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('iSubmit_bagi_upd','combobox','',array(0=>'Draft - Need Submit',1=>'Submitted'));
		//$grid->changeFieldType('iSediaan','combobox','',array(''=>'Pilih','1'=>'Solid','2'=>'Non Solid'));
		$grid->changeFieldType('iTeam_andev','combobox','',array(''=>'Pilih','74'=>'Andev 1','75'=>'Andev 2'));
		
		

	//Field mandatori
		$grid->setRequired('iSediaan');	
		$grid->setRequired('iTeam_andev');	
		$grid->setRequired('lDeleted');	

		
		$grid->setJoinTable('dossier.dossier_prioritas_detail', 'dossier_prioritas_detail.idossier_upd_id = dossier_upd.idossier_upd_id', 'inner');
		$grid->setJoinTable('dossier.dossier_prioritas', 'dossier_prioritas.idossier_prioritas_id = dossier_prioritas_detail.idossier_prioritas_id', 'inner');
		$grid->setJoinTable('dossier.dossier_jenis_dok','dossier_jenis_dok.ijenis_dok_id=dossier_upd.iSediaan','left');

		$grid->setQuery('dossier_upd.lDeleted', 0);
		$grid->setQuery('dossier_upd.ihold', 0);
		$grid->setQuery('dossier_upd.idossier_upd_id in (
				select a.idossier_upd_id 
				from dossier.dossier_upd a 
				join dossier.dossier_prioritas_detail b on b.idossier_upd_id = a.idossier_upd_id
				join dossier.dossier_prioritas c on c.idossier_prioritas_id=b.idossier_prioritas_id 
				where c.iApprove_prio= 2
				and a.lDeleted = 0
				and b.lDeleted = 0
				and c.lDeleted = 0
				group by a.idossier_upd_id

			) ', NULL);

		//$grid->setMultiSelect(true);
		
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
			case 'carinegara':
				$this->carinegara();
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
			case 'employee_list':
				$this->employee_list();
				break;
			case 'confirm':
				$post=$this->input->post();
				$get=$this->input->get();

				$skg=date('Y-m-d H:i:s');
				$this->db_plc0->where('idossier_upd_id', $get['last_id']);
				$this->db_plc0->update('dossier.dossier_upd', array('iappad_pembagian'=>2,'cappad_pembagian'=>$this->user->gNIP,'dappad_pembagian'=>$skg));
		    	
				$andev = $post['iTeam_andev']; 
				$logged_nip =$this->user->gNIP;
				$qupd="select  a.iSubmit_upd,a.vUpd_no,a.vNama_usulan,a.cNip_pengusul,b.vupb_nomor,b.vupb_nama,c.vName,a.dTanggal_upd,a.iSubmit_bagi_upd,
						(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id='".$andev."') as ad
						from dossier.dossier_upd a
						join plc2.plc2_upb b on b.iupb_id = a.idossier_upd_id
						join hrd.employee c on c.cNip=a.cNip_pengusul
						where a.idossier_upd_id = '".$get['last_id']."'";
				$rupd = $this->db_plc0->query($qupd)->row_array();

				if ($andev == 74) {
					$iTeamandev = 'Andev 1';
				}else{
					$iTeamandev = 'Andev 2';
				}

				$ad = $rupd['ad'];
				$team = $ad;

		        $toEmail2='';
				$toEmail = $this->lib_utilitas->get_email_team( $team );
		        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );                   
		        $arrEmail = $this->lib_utilitas->get_email_by_nip( $logged_nip );                    
		                    
				$to = $cc = '';
				if(is_array($arrEmail)) {
					$count = count($toEmail);
					$to = $toEmail[0];
					for($i=1;$i<$count;$i++) {
						$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
					}
				}	
				$to = $arrEmail;
				$cc = $toEmail2.';'.$toEmail;                        

					$subject="Pembagian Produk: UPD ".$rupd['vUpd_no'];
					$content="Diberitahukan bahwa telah ada pembagian produk UPD yang dialokasikan pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
									<td><b>UPB</b></td><td> : </td><td>".$rupd['vupb_nomor'].' - '.$rupd['vupb_nama']."</td>
								</tr>
								<tr>
									<td><b>Team Andev</b></td><td> : </td><td>".$iTeamandev."</td>
								</tr>
							</table>
						</div>
						<br/> 
						Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
						Post Master";
					$this->lib_utilitas->send_email($to, $cc, $subject, $content);

				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Confirm Success!';
				echo json_encode($r);
				exit();
			break;
			default:
				$grid->render_grid();
				break;
		}
    }

   

function listBox_pembagian_produk_export_dossier_prioritas_iSemester ($value) {
	return 'Semester '.$value;
}

function listBox_Action($row, $actions) {

 	if ($row->iappad_pembagian<>0) {
 		// status sudah diapprove or reject , button edit hide 
 		 unset($actions['edit']);
 		 unset($actions['delete']);
 	}
	 return $actions;

} 


function updateBox_pembagian_produk_export_vUpd_no($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return= $value;
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
		}
		
		return $return;
}
function updateBox_pembagian_produk_export_dTanggal_upd($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return= $value;
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
		}
		
		return $return;
}

function updateBox_pembagian_produk_export_vNama_usulan($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return= $value;
			$return .= '<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
		}
		
		return $return;
}

function updateBox_pembagian_produk_export_iupb_id($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$value))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vupb_nomor'].' - '.$rows['vupb_nama'];

		}
		else{
			$return= $rows['vupb_nomor'].' - '.$rows['vupb_nama'];
			$return .= '
			<input type="hidden" name="isdraft" id="isdraft">
			<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
		}
		
		return $return;
}

function updateBox_pembagian_produk_export_nama_generik($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id']))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vgenerik'];

		}
		else{
			$return= $rows['vgenerik'];
			$return .= '
			<input type="hidden" name="'.$field.'"  readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 " size="10" />';
		}
		
		return $return;
}

function updateBox_pembagian_produk_export_iSediaan($field, $id, $value, $rowData) {
		$sql="select * from dossier.dossier_jenis_dok je where je.lDeleted=0";
		$dt=$this->dbset->query($sql)->result_array();
		$r='';
		$va='-';
		foreach ($dt as $kd => $vd) {
			$select=$vd['ijenis_dok_id']==$value?'selected':'';
			if($vd['ijenis_dok_id']==$value){
				$va=$vd["vjenis_dok"];
			}
			$r.='<option value="'.$vd['ijenis_dok_id'].'" '.$select.'>'.$vd["vjenis_dok"].'</option>';
		}
		
		if ($this->input->get('action') == 'view') {
			$return= $va;

		}
		else{
			$return = '<select name="'.$id.'" id="'.$id.'" class="input_rows1 required">';
			$return .= '<option value="" >----Pilih----</option>';
			$return .= $r;
			$return .='</select>';
		}
		
		return $return;
}

function updateBox_pembagian_produk_export_iNegara($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('dossier.dossier_upd_negara', array('lDeleted'=>0,'idossier_upd_id'=>$rowData['idossier_upd_id']))->result_array();
		
		$data['isi'] = $rows;
		return $this->load->view('pembagian_produk_export_negara',$data,TRUE);
}

function before_update_processor($row, $postData) {

	// ubah status submit
		if($postData['isdraft']==true){
			$postData['iSubmit_bagi_upd']=0;
		} 
		else{$postData['iSubmit_bagi_upd']=1;} 
	
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;
	

	return $postData;

}
function before_insert_processor($row, $postData) {
	

	
	$postData['dCreate'] = date('Y-m-d H:i:s');
	$postData['cCreated'] =$this->user->gNIP;

	
	return $postData;

}


function carinegara() {
	$term = $this->input->get('term');
	$return_arr = array();
	$this->db_plc0->like('vNama_Negara',$term);
	$this->db_plc0->or_like('vNama_Negara',$term);
	$this->db_plc0->limit(50);
	$lines = $this->db_plc0->get('dossier.dossier_negara')->result_array();
	$i=0;
	foreach($lines as $line) {
		$row_array["value"] = trim($line["vKode_Negara"]).' - '.trim($line["vNama_Negara"]);
		$row_array["id"] = trim($line["idossier_negara_id"]);
		array_push($return_arr, $row_array);
	}
	echo json_encode($return_arr);exit();
	
}

function after_update_processor($row, $insertId, $postData, $old_data) {

	$det = array();		
		$this->db_plc0->where('idossier_upd_id', $postData['idossier_upd_id']);
		if($this->db_plc0->update('dossier.dossier_upd_negara', array('lDeleted'=>1))) {
			foreach($postData['negara_id'] as $k=>$v) {
				
					if($v != '') {
						$det['idossier_upd_id'] = $postData['idossier_upd_id'];
						$det['idossier_negara_id'] = $v;

						try {
							$this->db_plc0->insert('dossier.dossier_upd_negara', $det);
						}catch(Exception $e) {
							die('salah!');
						} 
					}
			}//exit;
		}

		$andev = $_POST['pembagian_produk_export_iTeam_andev']; 
		$logged_nip =$this->user->gNIP;
		$qupd="select  a.iSubmit_upd,a.vUpd_no,a.vNama_usulan,a.cNip_pengusul,b.vupb_nomor,b.vupb_nama,c.vName,a.dTanggal_upd,a.iSubmit_bagi_upd,
				(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='AD' and te.ldeleted=0 and te.iteam_id='".$andev."') as ad
				from dossier.dossier_upd a
				join plc2.plc2_upb b on b.iupb_id = a.idossier_upd_id
				join hrd.employee c on c.cNip=a.cNip_pengusul
				where a.idossier_upd_id = '".$insertId."'";
		$rupd = $this->db_plc0->query($qupd)->row_array();

		$submit = $rupd['iSubmit_bagi_upd'] ;

		if ($andev == 74) {
			$iTeamandev = 'Andev 1';
		}else{
			$iTeamandev = 'Andev 2';
		}

		if ($submit == 1) {
			$ad = $rupd['ad'];

			//$team = $dr ;
			$team = $ad;
			//$team = '81' ;

	        $toEmail2='';
			$toEmail = $this->lib_utilitas->get_email_team( $team );
	        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );
	        //$arrEmail = $this->lib_utilitas->get_email_by_nip( "N00923" );                    
	        $arrEmail = $this->lib_utilitas->get_email_by_nip( $logged_nip );                    
	                    
			$to = $cc = '';
			if(is_array($arrEmail)) {
				$count = count($toEmail);
				$to = $toEmail[0];
				for($i=1;$i<$count;$i++) {
					$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
				}
			}	

			//$to = $toEmail2.';'.$toEmail;
			//$cc = $arrEmail;                        

			$to = $arrEmail;
			$cc = $toEmail2.';'.$toEmail;                        

				$subject="Pembagian Produk: UPD ".$rupd['vUpd_no'];
				$content="Diberitahukan bahwa telah ada pembagian produk UPD yang dialokasikan pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
								<td><b>UPB</b></td><td> : </td><td>".$rupd['vupb_nomor'].' - '.$rupd['vupb_nama']."</td>
							</tr>
							<tr>
								<td><b>Team Andev</b></td><td> : </td><td>".$iTeamandev."</td>
							</tr>
						</table>
					</div>
					<br/> 
					Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
					Post Master";
				//$this->lib_utilitas->send_email($to, $cc, $subject, $content);
			
		}

}	

function manipulate_update_button($buttons, $rowData) {

	$cNip= $this->user->gNIP;
	$js = $this->load->view('pembagian_produk_export_js');
	$update = '<button onclick="javascript:update_btn_back(\'pembagian_produk_export\', \''.base_url().'processor/plc/pembagian/produk/export?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_pembagian_produk_export_submit">Save & Submit</button>';
	$updatedraft = '<button onclick="javascript:update_draft_btn(\'pembagian_produk_export\', \''.base_url().'processor/plc/pembagian/produk/export?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_pembagian_produk_export_draft">Save as Draft</button>';
	$setuju = '<button onclick="javascript:setuju(\'pembagian_produk_export\', \''.base_url().'processor/plc/pembagian/produk/export?action=confirm&last_id='.$rowData['idossier_upd_id'].'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$rowData['idossier_upd_id'].', \''.$rowData['vUpd_no'].'\','.$rowData['iTeam_andev'].')" class="ui-button-text icon-save" id="button_save_pembagian_produk_export">Approve</button>';

	if ($this->input->get('action') == 'view') {unset($buttons['update']);}
	else{
		unset($buttons['update_back']);
		unset($buttons['update']);
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('IR', $manager)){
				$type='IR';
			}elseif(in_array('AD', $manager)){
				$type='AD';
			}elseif(in_array('BDI', $manager)){
				$type='BDI';
			}elseif(in_array('IM', $manager)){
				$type='IM';
			}
			else{$type='';}
		}
		else{
			$x=$this->auth->dept();
			$team=$x['team'];
			if(in_array('IR', $team)){
				$type='IR';
			}elseif(in_array('AD', $team)){
				$type='AD';
			}elseif(in_array('BDI', $team)){
				$type='BDI';
			}elseif(in_array('IM', $team)){
				$type='IM';
			}
			else{$type='';}
		}
		if($this->auth->is_manager()){
			if ($type=='BDI') {
				if ($rowData['iSubmit_bagi_upd']== 1) {
					if($rowData['iappad_pembagian']==0){
						$buttons['update'] = $setuju.$js;
					}
				}else{
					
					$buttons['update'] = $update.$updatedraft.$js;
				}
			}
		}
	}
	return $buttons;
	
}




public function output(){
	$this->index($this->input->get('action'));
}

}

