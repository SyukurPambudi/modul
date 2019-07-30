<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class master_standar_dokumen_export extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->dbset = $this->load->database('dosier', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Master Standar Dokumen');
		//dc.m_vendor  database.tabel
		$grid->setTable('dossier.dossier_standar_dok');		
		$grid->setUrl('master_standar_dokumen_export');
		$grid->addList('ijenis_dok_id','lDeleted');

		$grid->setSortBy('ijenis_dok_id');
		$grid->setSortOrder('asc'); //sort ordernya

		$grid->addFields('ijenis_dok_id','idossier_negara_id','vdokumen','lDeleted');

		//setting widht grid
		$grid ->setWidth('ijenis_dok_id', '250'); 
		$grid ->setWidth('lDeleted', '150'); 
		
		
		//modif label
		$grid->setLabel('ijenis_dok_id','Standar Dokumen'); 
		$grid->setLabel('idossier_negara_id','Negara'); 
		$grid->setLabel('vdokumen','Dokumen Yang Di Perlukan'); 
		$grid->setLabel('lDeleted','Status'); 
		$grid->setFormUpload(TRUE);

		$grid->setSearch('ijenis_dok_id','lDeleted');
		
	 	//ini untuk dropdown jika ada field yang menggunakan pilihan
		$grid->changeFieldType('lDeleted','combobox','',array(''=>'Pilih',0=>'Aktif',1=>'Tidak aktif'));
		

		//Field mandatori
		$grid->setRequired('ijenis_dok_id');	
		$grid->setRequired('lDeleted');	

		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				//print_r($this->input->post());exit();
				$post=$this->input->post();
				$key2 = $post['master_standar_dokumen_export_ijenis_dok_id'];
				$and='';
				if($key2==1){
					$and='AND a.idossier_negara_id='.$post['master_standar_dokumen_export_idossier_negara_id'];
				}
                $cek_data = 'select * from dossier_standar_dok a where a.ijenis_dok_id="'.$key2.'" '.$and;
                $data_cek = $this->dbset->query($cek_data)->num_rows();
                if ($data_cek==0) {
                     echo $grid->saved_form();
                }else{
                    $r['status'] = FALSE;
                    $r['message'] = "Nama Standar Dokumen Sudah ada!";
                    echo json_encode($r);
                }
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
				$id=$this->input->post('master_standar_dokumen_export_istandar_dok_id');
				$key2 = $this->input->post('master_standar_dokumen_export_ijenis_dok_id');
				foreach ($post as $kpo => $vpo) {
					if($kpo=='master_standar_vdok'){
						foreach ($vpo as $kp => $vp) {
							$kc[$kp]=$vp;
						}
					}
				}
				$and='';
				if($key2==1){
					$and='AND a.idossier_negara_id='.$post['master_standar_dokumen_export_idossier_negara_id'];
				}
                $cek_data = 'select * from dossier_standar_dok a where a.ijenis_dok_id="'.$key2.'" and istandar_dok_id != "'.$id.'"'.$and;
                $data_cek = $this->dbset->query($cek_data)->num_rows();

                if ($data_cek==0) {

	                //Cek di review
					$sqre="select rev.* from dossier.dossier_review rev 
						inner join dossier.dossier_upd up on up.idossier_upd_id=rev.idossier_upd_id
						inner join dossier.dossier_standar_dok st on st.istandar_dok_id=up.istandar_dok_id
						where up.lDeleted=0 and rev.lDeleted=0 and st.lDeleted=0 
						and rev.iSubmit_kelengkapan2=0 and rev.iKelengkapan_data2=0
						and st.istandar_dok_id=".$id;

					$cekre=$this->dbset->query($sqre);
					if($cekre->num_rows()!=0){
						foreach ($cekre->result_array() as $kce => $vce) {
							$iada=array();
							$itidak=array();
							foreach ($kc as $kin => $vin) {
								$sqdok="select * from dossier.dossier_dok_list li where li.idossier_review_id=".$vce['idossier_review_id']." and li.idossier_dokumen_id=".$kin;
								$qdok=$this->dbset->query($sqdok);
								if($qdok->num_rows()>=1){
									$dtdok=$qdok->row_array();
									$iada[]=$dtdok['idossier_dok_list_id'];
								}else{
									$itidak[]=$kin;
								}
							}
							if(count($iada>=1)){
								$inot='';
								foreach ($iada as $kv => $vidossier_dok_list) {
									$datali['lDeleted']=0;
									$this->dbset->where('idossier_dok_list_id',$vidossier_dok_list);
									$this->dbset->update('dossier_dok_list',$datali);
									if($kv==0){
										$inot.=$vidossier_dok_list;
									}else{
										$inot.=','.$vidossier_dok_list;
									}
								}
								if($inot!=''){
									$sqn="update dossier.dossier_dok_list set lDeleted=1 where idossier_review_id=".$vce['idossier_review_id']." and idossier_dok_list_id not in (".$inot.")";
									$this->dbset->query($sqn);
								}elseif($inot==''){
									$sqn="update dossier.dossier_dok_list set lDeleted=1 where idossier_review_id=".$vce['idossier_review_id'];
									$this->dbset->query($sqn);
								}
							}
							if(count($itidak)>=1){
								foreach ($itidak as $kti => $vti) {
									$datainsert['idossier_review_id']=$vce['idossier_review_id'];
									$datainsert['idossier_dokumen_id']=$vti;
									$datainsert['istatus_keberadaan']=1;
									$datainsert['istatus_keberadaan_update']=1;
									$this->dbset->insert('dossier.dossier_dok_list',$datainsert);
								}
							}
						}
					}
                    echo $grid->updated_form();
                }else{
                    $r['status'] = FALSE;
                    $r['message'] = "Nama Dokumen Sudah ada!";
                    echo json_encode($r);
                }
				break;
			default:
				$grid->render_grid();
				break;
		}
    }

function listBox_master_standar_dokumen_export_ijenis_dok_id($value, $pk, $name, $rowData) {
	$sql="select * from dossier.dossier_jenis_dok j where j.lDeleted=0 and j.ijenis_dok_id=".$value;
	$d=$this->dbset->query($sql);
	if($d->num_rows()!=0){
		$r=$d->row_array();
		if($value!=1){
			return $r['vjenis_dok'];
		}else{
			$sqr=$this->dbset->query('select * from dossier.dossier_negara where lDeleted=0 and idossier_negara_id='.$rowData->idossier_negara_id);
			if($sqr->num_rows()!=0){
				$n=$sqr->row_array();
				return $r['vjenis_dok'].'-'.$n['vNama_Negara'];
			}else{
				return $r['vjenis_dok'];
			}
		}
	}else{
		return '';
	}
}

/*manipulasi view object form start*/
function insertBox_master_standar_dokumen_export_idossier_negara_id($field, $id){
	$neg=$this->dbset->query('select * from dossier.dossier_negara where lDeleted=0');
	$o='<select id="'.$id.'" name="'.$id.'">';
	$o.='<option value="">---Pilih---</option>';
	foreach ($neg->result_array() as $kn => $vn) {
		$o.='<option value="'.$vn['idossier_negara_id'].'">'.$vn['vKode_Negara'].'-'.$vn['vNama_Negara'].'</option>';
	}
	$o.='</select>';
	$o.='<script>
		var c = $("#'.$id.'").val();
		if(c=="2"){
			$("#'.$id.'").parent().parent().show();
			$("#'.$id.'").addClass("required");
		}else{
			$("#'.$id.'").parent().parent().hide();
			$("#'.$id.'").removeClass("required");

		}
		</script>';
	return $o;
}
function insertBox_master_standar_dokumen_export_ijenis_dok_id($field, $id){
	$sql="select * from dossier.dossier_jenis_dok j where j.lDeleted=0";
	$d=$this->dbset->query($sql)->result_array();
	$r="";
	$r.='<select id="'.$id.'" name="'.$id.'" class="required" onchange="javascript:select_'.$id.'(\''.$id.'\')">';
	$r.='<option value="">---Pilih---</option>';
	foreach ($d as $kstan => $vstand) {
		$r.="<option value=".$vstand['ijenis_dok_id'].">".$vstand['vjenis_dok']."</option>";
	}
	$r.="</select>";
	$r.='<script>';
	$r.='function select_'.$id.'(id){';
	$r.='var c = $("#"+id).val();
		if(c=="1"){
			$("#master_standar_dokumen_export_idossier_negara_id").parent().parent().show();
			$("#master_standar_dokumen_export_idossier_negara_id").addClass("required");
		}else{
			$("#master_standar_dokumen_export_idossier_negara_id").parent().parent().hide();
			$("#master_standar_dokumen_export_idossier_negara_id").removeClass("required");

		}';
	$r.='}';
	$r.='</script>';
	return $r;
}

function insertBox_master_standar_dokumen_export_vdokumen($field, $id){
	$qdokumen='select * from dossier.dossier_dokumen dok 
			inner join dossier.dossier_kat_dok_details det on dok.idossier_kat_dok_details_id=det.idossier_kat_dok_details_id
			inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id = det.idossier_kat_dok_id
			where dok.lDeleted=0 and kat.lDeleted=0 and det.lDeleted=0';
	$datdokumen=$this->dbset->query($qdokumen)->result_array();
	$qkatdok='select * from dossier.dossier_kat_dok_details kat where kat.lDeleted=0';
	$datkat=$this->dbset->query($qkatdok)->result_array();
	$data['vdok']=$datdokumen;
	$data['vkat']=$datkat;
	$data['rvkat']=$this->dbset->query($qkatdok)->num_rows();
	$r=$this->load->view('export/master_standar_dokumen_export_vdokumen',$data,TRUE);
	return $r;
}

function updateBox_master_standar_dokumen_export_idossier_negara_id($field, $id, $value, $rowData) {
	$neg=$this->dbset->query('select * from dossier.dossier_negara where lDeleted=0');
	$o='<select id="'.$id.'" name="'.$id.'">';
	$o.='<option value="">---Pilih---</option>';
	foreach ($neg->result_array() as $kn => $vn) {
		$sel=$value==$vn['idossier_negara_id']?'selected':'';
		$o.='<option value="'.$vn['idossier_negara_id'].'" '.$sel.' >'.$vn['vKode_Negara'].'-'.$vn['vNama_Negara'].'</option>';
	}
	$o.='</select>';
	$o.='<script>
		var c = $("#master_standar_dokumen_export_ijenis_dok_id").val();
		if(c=="1"){
			$("#'.$id.'").parent().parent().show();
			$("#'.$id.'").addClass("required");
		}else{
			$("#'.$id.'").parent().parent().hide();
			$("#'.$id.'").removeClass("required");

		}
		</script>';
	return $o;
}


function updateBox_master_standar_dokumen_export_ijenis_dok_id($field, $id, $value, $rowData) {
	$sql="select * from dossier.dossier_jenis_dok j where j.lDeleted=0";
	$d=$this->dbset->query($sql)->result_array();
	$r="";
	$r.='<select id="'.$id.'" name="'.$id.'" class="required" onchange="javascript:select_'.$id.'(\''.$id.'\')">';
	$r.='<option value="">---Pilih---</option>';
	foreach ($d as $kstan => $vstand) {
		$sel=$vstand['ijenis_dok_id']==$value?"selected":"";
		$r.="<option value=".$vstand['ijenis_dok_id']." ".$sel.">".$vstand['vjenis_dok']."</option>";

	}
	$r.="</select>";
	$r.='<script>';
	$r.='function select_'.$id.'(id){';
	$r.='var c = $("#"+id).val();
		if(c=="1"){
			$("#master_standar_dokumen_export_idossier_negara_id").parent().parent().show();
			$("#master_standar_dokumen_export_idossier_negara_id").addClass("required");
		}else{
			$("#master_standar_dokumen_export_idossier_negara_id").parent().parent().hide();
			$("#master_standar_dokumen_export_idossier_negara_id").removeClass("required");

		}';
	$r.='}';
	$r.='</script>';
	return $r;
}

function updateBox_master_standar_dokumen_export_vdokumen($field, $id, $value, $rowData) {
	$qdokumen='select * from dossier.dossier_dokumen dok 
			inner join dossier.dossier_kat_dok_details det on dok.idossier_kat_dok_details_id=det.idossier_kat_dok_details_id
			inner join dossier.dossier_kat_dok kat on kat.idossier_kat_dok_id = det.idossier_kat_dok_id
			where dok.lDeleted=0 and kat.lDeleted=0 and det.lDeleted=0';
	$datdokumen=$this->dbset->query($qdokumen)->result_array();
	$qkatdok='select * from dossier.dossier_kat_dok_details kat where kat.lDeleted=0';
	$datkat=$this->dbset->query($qkatdok)->result_array();
	$data['vdok']=$datdokumen;
	$data['vkat']=$datkat;
	$data['rvkat']=$this->dbset->query($qkatdok)->num_rows();
	$qsel="select * from dossier.dossier_standar_dok_detail det where det.istandar_dok_id=".$rowData['istandar_dok_id'].' and det.lDeleted=0';
	$dt=$this->dbset->query($qsel)->result_array();
	foreach ($dt as $kd => $vd) {
		$d[]=$vd['idossier_dokumen_id'];
	}
	$data['vdetdok']=$d;
	$r=$this->load->view('export/master_standar_dokumen_export_vdokumen',$data,TRUE);
	return $r;
}

/*manipulasi view object form end*/

/*manipulasi proses object form start*/

   
/*manipulasi proses object form end*/    

/*function pendukung start*/  
function before_update_processor($row, $postData) {
	$postData['dUpdate'] = date('Y-m-d H:i:s');
	$postData['cUpdated'] =$this->user->gNIP;

	return $postData;

}
function before_insert_processor($row, $postData) {
	$postData['dCreate'] = date('Y-m-d H:i:s');
	$postData['cCreated'] =$this->user->gNIP;
	return $postData;

}

function after_insert_processor($fields, $id, $post) {
	$istandar=$id;
	$nip=$this->user->gNIP;
	$date=date('Y-m-d H:m:s');
	foreach ($post as $kpo => $vpo) {
		if($kpo=='master_standar_vdok'){
			foreach ($vpo as $kp => $vp) {
				$kc[]=$kp;
			}
		}
	}

	$dtk=array_unique($kc);
	foreach ($dtk as $ktk => $vtk) {
		$data['dCreate']=$date;
		$data['cCreated']=$nip;
		$data['istandar_dok_id']=$id;
		$data['idossier_dokumen_id']=$vtk;
		$this->dbset->insert('dossier.dossier_standar_dok_detail',$data);
		$this->dbset->insert('dossier.dossier_standar_dok_log',$data);
	}

}

function after_update_processor($fields, $id, $post){
	$istandar=$id;
	$nip=$this->user->gNIP;
	$date=date('Y-m-d H:m:s');
	foreach ($post as $kpo => $vpo) {
		if($kpo=='master_standar_vdok'){
			foreach ($vpo as $kp => $vp) {
				$kc[]=$kp;
			}
		}
	}
	$dtk=array_unique($kc);
	$this->dbset->where('istandar_dok_id',$id);
	$datadelete['lDeleted']=1;
	$this->dbset->update('dossier.dossier_standar_dok_detail',$datadelete);
	foreach ($dtk as $ktk => $vtk) {
		$data['dCreate']=$date;
		$data['cCreated']=$nip;
		$data['istandar_dok_id']=$id;
		$data['idossier_dokumen_id']=$vtk;
		$this->dbset->insert('dossier.dossier_standar_dok_detail',$data);
		$this->dbset->insert('dossier.dossier_standar_dok_log',$data);
	}
}

function manipulate_insert_button($buttons) {
	unset($buttons['save']);

	$save = '<button onclick="javascript:save_btn_multiupload(\'master_standar_dokumen_export\', \''.base_url().'processor/plc_export/daftar/upd?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_daftar_upb">Save</button>';
	$js = $this->load->view('export/master_standar_dokumen_export_js');
	$buttons['save'] = $save.$js;

	return $buttons;
}
function manipulate_update_button($b, $r){
	if($this->input->get('action')=="view"){
		unset($b['update']);
	}
	return $b;
}
/*function pendukung end*/    	

	public function output(){
		$this->index($this->input->get('action'));
	}

}
