<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_registrasi extends CI_Model {

	function __construct() {
	    parent::__construct();
	    $this->dbset=$this->load->database('plc0',false, true);
	    $this->user = $this->auth_localnon->user();

	    /*Field Untuk PD*/
	    $this->isPD = array('lapprot_udt','stabilita_pilot','lapvalmoa');
	    $this->isQA = array('validasi_proses');

	    /*File Laporan UDT Config*/
		$this->tblapprot_udt='plc2.plc2_upb_file_lapprot_udt'; //Data Table Upload
		$this->pklapprot_udt='ifor_id'; //Untuk Header
		$this->pkdlapprot_udt='id'; //Id PK File
		$this->pathlapprot_udt = "files/plc/udt"; //PathFile
		$this->rsellapprot_udt=array('iconfirm_busdev','istatus','filename','keterangan','iact'); //Data Grid View
		$this->fuploadlapprot_udt='filename, dInsertDate, keterangan, cInsert'; //Data Grid View
		$this->fdupdatelapprot_udt='dUpdateDate'; //Data Grid View
		$this->fcupdatelapprot_udt='cUpdated'; //Data Grid View
		$this->filenamelapprot_udt='filename'; //Data Grid View
		$this->captionlapprot_udt='File Laporan UDT'; //Data Grid View
		/*End Laporan UDT*/

		/*File stabilita_pilot Config*/
		$this->tbstabilita_pilot='pddetail.file_stabilita_pilot'; //Data Table Upload
		$this->pkstabilita_pilot='iFormula'; //Untuk Header
		$this->pkdstabilita_pilot='id_formula_stabilita'; //Id PK File
		$this->pathstabilita_pilot = "files/pddetail/stabilita_pilot"; //PathFile
		$this->rselstabilita_pilot=array('iconfirm_busdev','istatus','vfilename','tKeterangan','iact'); //Data Grid View
		$this->fuploadstabilita_pilot='vfilename, dCreate, tKeterangan, cCreated'; //Data Grid View
		$this->fdupdatestabilita_pilot='dupdate'; //Data Grid View
		$this->fcupdatestabilita_pilot='cUpdate'; //Data Grid View
		$this->filenamestabilita_pilot='vfilename'; //Data Grid View
		$this->captionstabilita_pilot='File Stabilita LAB Detail'; //Data Grid View
		/*End stabilita_pilot*/

		/*File validasi_proses Config*/
		$this->tbvalidasi_proses='plc2.validasi_proses_file'; //Data Table Upload
		$this->pkvalidasi_proses='ivalidasi_id'; //Untuk Header
		$this->pkdvalidasi_proses='ivalidasi_proses_file_id'; //Id PK File
		$this->pathvalidasi_proses = "files/plc/validasi_proses"; //PathFile
		$this->rselvalidasi_proses=array('iconfirm_busdev','istatus','vFilename','vKeterangan','iact'); //Data Grid View
		$this->fuploadvalidasi_proses='vFilename, dCreate, vKeterangan, cCreate'; //Data Grid View
		$this->fdupdatevalidasi_proses='dupdate'; //Data Grid View
		$this->fcupdatevalidasi_proses='cUpdate'; //Data Grid View
		$this->filenamevalidasi_proses='vFilename'; //Data Grid View
		$this->captionvalidasi_proses='File Laporan Validasi Proses'; //Data Grid View
		/*End Laporan UDT*/

		/*File lapvalmoa Config*/
		$this->tblapvalmoa='plc2.plc2_vamoa_laporan_file'; //Data Table Upload
		$this->pklapvalmoa='ivalmoa_id'; //Untuk Header
		$this->pkdlapvalmoa='ivamoa_lapfile_id'; //Id PK File
		$this->pathlapvalmoa = "files/plc/lap_valmoa"; //PathFile
		$this->rsellapvalmoa=array('iconfirm_busdev','istatus','vFilename','vKeterangan','iact'); //Data Grid View
		$this->fuploadlapvalmoa='vFilename, dCreate, vKeterangan, cCreate'; //Data Grid View
		$this->fdupdatelapvalmoa='dupdate'; //Data Grid View
		$this->fcupdatelapvalmoa='cUpdate'; //Data Grid View
		$this->filenamelapvalmoa='vFilename'; //Data Grid View
		$this->captionlapvalmoa='File Laporan Validasi Proses'; //Data Grid View
		/*End Laporan UDT*/
	}

	function updateUploadFile($filejenis='',$type='',$dataretu=array(),$iupb_id=0){
		$filepath='path'.$filejenis;
		$pkfilecoars='pk'.$filejenis;
		$tbfile='tb'.$filejenis;
		$fieldupload='fupload'.$filejenis;
		$id=$this->getAnotherUPB($this->{$pkfilecoars},$iupb_id);
		$fileketerangan=$dataretu[$filejenis]['fileketerangan'];
		$istatus_upload=$dataretu[$filejenis]['istatus_upload'];
		$iconfirm_registrasi_upload=$dataretu[$filejenis]['iconfirm_registrasi_upload'];
		if (isset($_FILES['fileupload_local_'.$filejenis])){
			$i=0;
			foreach ($_FILES['fileupload_local_'.$filejenis]["error"] as $key => $error) {	
				if ($error == UPLOAD_ERR_OK) {
					$tmp_name = $_FILES['fileupload_local_'.$filejenis]["tmp_name"][$key];
					$name =$_FILES['fileupload_local_'.$filejenis]["name"][$key];
					$data['filename'] = $name;
					$data['dInsertDate'] = date('Y-m-d H:i:s');
					if(move_uploaded_file($tmp_name, $this->{$filepath}."/".$id."/".$name)) {
						$sqldmf[] = "INSERT INTO ".$this->{$tbfile}."(".$this->{$pkfilecoars}." ,".$this->{$fieldupload}.", istatus, iconfirm_busdev) 
								VALUES (".$id.",'".$data['filename']."','".$data['dInsertDate']."','".$fileketerangan[$i]."','".$this->user->gNIP."','".$istatus_upload[$i]."','".$iconfirm_registrasi_upload[$i]."')";
						$i++;	
					}
					else{
						echo "Upload ke folder gagal";	
					}
				}
			}
			foreach($sqldmf as $qdmf) {
				try {
					$this->dbset->query($qdmf);
				}catch(Exception $e) {
					die($e);
				}
			}	
		}
	}

	function updateBeforeUpload($filejenis='',$type=''){
		$post=$this->input->post();
		$get=$this->input->get();
		$isUpload = $this->input->get('isUpload');
		$lastId=$this->input->get('lastId');

		$pathjenis='path'.$filejenis;
		$pkjenis='pk'.$filejenis;
		$tbjenis='tb'.$filejenis;
		$pkdjenis='pkd'.$filejenis;
		$dupdatedjenis='fdupdate'.$filejenis;
		$cupdatedjenis='fcupdate'.$filejenis;

		$iupb_id=$post['cek_dokumen_registrasi_iupb_id'];
		$id=$this->getAnotherUPB($this->{$pkjenis},$iupb_id);

		$pathjenisfix = realpath($this->{$pathjenis});
		if(!file_exists($pathjenisfix."/".$id)){
			if (!mkdir($pathjenisfix."/".$id, 0777, true)) { //id review
				die('Failed upload, try again - '.$filejenis.'!');
			}
		}
		$fileketeranganmain = array();
		$istatusmain = array();
		$iconfirmregistrasi = array();
		$iconfirm_registrasi_upload = array();
		$istatusmain_upload = array();
		$fileidmain='';
		foreach($_POST as $key=>$value) {
			if($key == 'cek_dokumen_registrasi_'.$filejenis.'_istatus'){
				foreach($value as $y=>$u) {
					if($y!=0){
						$istatusmain[$y]=$u[0];
					}else{
						$istatusmain_upload[]=$u;
					}
				}
			}
			if($key == 'cek_dokumen_registrasi_'.$filejenis.'_iconfirm_registrasi'){
				foreach($value as $y=>$u) {
					if($y!=0){
						$iconfirmregistrasi[$y]=$u[0];
					}else{
						$iconfirm_registrasi_upload[]=$u;
					}
				}
			}
			if($key == 'file_keterangan_local_'.$filejenis){
				foreach($value as $y=>$u) {
					$fileketeranganmain[] = $u;
				}
			}
			if ($key == 'ifile_'.$filejenis) {
				$i=0;
				foreach($value as $k=>$v) {
					$ifile_filemain[$k] = $v;
					if($i==0){
						$fileidmain .= "'".$v."'";
					}else{
						$fileidmain .= ",'".$v."'";
					}
					$i++;
				}
			}
		}
		/*Cek Confirm untuk upload*/
		if(count($fileketeranganmain)>=1){
			if(count($iconfirm_registrasi_upload)>=1){
				$iconfirm_registrasi_upload=$iconfirm_registrasi_upload[0];
			}
			if(count($istatusmain_upload)>=1){
				$istatusmain_upload=$istatusmain_upload[0];
			}
			foreach ($fileketeranganmain as $kketmain => $vketmain) {
				if(!isset($iconfirm_registrasi_upload[$kketmain])){
					if($type!='BD'){
						$iconfirm_registrasi_upload[$kketmain]=0;
					}
				}
				if(!isset($istatusmain_upload[$kketmain])){
					if($type=='BD'){
						$istatusmain_upload[$kketmain]=1;
					}
				}
			}
		}

		/*Update delete file*/
		if($fileidmain!=''){
			$tgl= date('Y-m-d H:i:s');
			$sql1="update ".$this->{$tbjenis}." set ldeleted=1, ".$this->{$dupdatedjenis}."='".$tgl."', ".$this->{$cupdatedjenis}."='".$this->user->gNIP."' where ".$this->{$pkjenis}."='".$id."' and ".$this->{$pkdjenis}." not in (".$fileidmain.")";
			$this->dbset->query($sql1);
		}elseif($fileidmain==""){
			$tgl= date('Y-m-d H:i:s');
			$sql1="update ".$this->{$tbjenis}." set ldeleted=1, ".$this->{$dupdatedjenis}."='".$tgl."', ".$this->{$cupdatedjenis}."='".$this->user->gNIP."' where ".$this->{$pkjenis}."='".$id."'";
			$this->dbset->query($sql1);
		}
		/*Update istatus oleh qa*/
		if(count($istatusmain)>=1){
			foreach ($istatusmain as $kmain => $vmain) {
				$sqlup="update ".$this->{$tbjenis}." set istatus=".$vmain." where ".$this->{$pkjenis}."='".$id."' and ".$this->{$pkdjenis}."=".$kmain;
				$this->dbset->query($sqlup);
			}
		}
		if(count($iconfirmregistrasi)>=1){
			foreach ($iconfirmregistrasi as $kmain => $vmain) {
				$sqlupp="update ".$this->{$tbjenis}." set iconfirm_busdev=".$vmain." where ".$this->{$pkjenis}."='".$id."' and ".$this->{$pkdjenis}."=".$kmain;
				$this->dbset->query($sqlupp);
			}
		}


		$dataret['fileketerangan']=$fileketeranganmain;
		$dataret['istatus_upload']=$istatusmain_upload;
		$dataret['iconfirm_registrasi_upload']=$iconfirm_registrasi_upload;
		return $dataret;
	}

	function getDoneOnUpdateBox($field='',$rowData=array()){
		$tbfield='tb'.$field;
		$pkfield='pk'.$field;
		$dgrid['isPD']=(in_array($field, $this->isPD))?1:0;
		$dgrid['field']=$field;
		$dgrid['id']=$field;
		$dgrid['rowData']=$rowData;
		$dgrid['get']=$this->input->get();
		$dgrid['caption']=' ';
		$id=$this->getAnotherUPB($this->{$pkfield},$rowData['iupb_id']);
		$dgrid['nilaiid']=$id;
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('BD', $manager)){
				$type='BD';
			}elseif(in_array('PD', $manager)){
				$type='PD';
			}elseif(in_array('QA', $manager)){
				$type='QA';
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('BD', $team)){
					$type='BD';
				}elseif(in_array('PD', $team)){
					$type='PD';
				}elseif(in_array('QA', $team)){
					$type='QA';
				}
				else{$type='';}
			}
		}
		/*Cek Untuk Done*/
		$dgrid['cekdone']=0;
		$sqlc="select * from ".$this->{$tbfield}." where (ldeleted is null or ldeleted=0) and iconfirm_busdev in (0,3) and ".$this->{$pkfield}."=".$id;
		$dgrid['cekdone']=$this->dbset->query($sqlc)->num_rows();
		$dgrid['ddd']=0;
		$sqlc2="select * from ".$this->{$tbfield}." where (ldeleted is null or ldeleted=0) and iDone!=1 and ".$this->{$pkfield}."=".$id;
		$dgrid['ddd']=$this->dbset->query($sqlc2)->num_rows();
		$dgrid['type']=$type;
		$sqlcc="select * from ".$this->{$tbfield}." where (ldeleted is null or ldeleted=0) and ".$this->{$pkfield}."=".$id;
		$nn=$this->dbset->query($sqlcc);
		if($nn->num_rows()==0){
			//if($type=='QA' or $type=='PD'){
				$dgrid['ddd']=1;
			//}
		}

		return $dgrid;
	}

	function get_cek_dokumen_registrasi_filemain(){

 		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('BD', $manager)){
				$type='BD';
			}elseif(in_array('PD', $manager)){
				$type='PD';
			}elseif(in_array('QA', $manager)){
				$type='QA';
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('BD', $team)){
					$type='BD';
				}elseif(in_array('PD', $team)){
					$type='PD';
				}elseif(in_array('QA', $team)){
					$type='QA';
				}
				else{$type='';}
			}
		}
    	$post=$this->input->get();
		$field=$this->input->get('field');

		$tbfield='tb'.$field;
		$pkfield='pk'.$field;
		$pathfield='path'.$field;
		$rselfield='rsel'.$field;
		$filenamefield='filename'.$field;
		$pkdfield='pkd'.$field;
		$idpkd=$this->{$pkdfield};

		$id=$this->getAnotherUPB($this->{$pkfield},$post['id']);

    	/*Untuk Master Data*/
    	$sql_data="select * from ".$this->{$tbfield}." p where (p.ldeleted=0 or p.ldeleted is null) and p.".$this->{$pkfield}."=".$id;
		$rsel=$this->{$rselfield};
		$idpk='id';
		$vfilename=$this->{$filenamefield};
		$idpkheader=$this->{$pkfield};
		$thisfilepath=$this->{$pathfield};

		$q=$this->db->query($sql_data);

		$data = new StdClass;
		$data->records=$q->num_rows();
		$i=0;
		foreach ($q->result() as $k) {
			$n=$i+1;
			$data->rows[$i]['id']=$n;
			$z=0;
			foreach ($rsel as $dsel => $vsel) {
				$value=$k->{$vfilename};
				$id=$k->{$idpkheader};
				$linknya = 'No File';
				if($value != '') {
					if (file_exists('./'.$thisfilepath.'/'.$id.'/'.$value)) {
						$link = base_url().'processor/plc/cek_dokumen_registrasi?action=download&id='.$id.'&file='.$value.'&path='.$field;
						$linknya = '<a class="ui-button-text" href="javascript:;" onclick="window.location=\''.$link.'\'">'.$value.'</a>';
					}else {
						$linknya = $value;
					}
				}
				$linknya=$linknya.'<input type="hidden" class="cek_num_row_'.$field.'" value=1 />';
				if($vsel=="iact"){
					if($post['acc']!="view"){
						if($type=="BD" || $type=="QA"){
							if($k->iconfirm_busdev==0||$k->iconfirm_busdev==3){
								$dataar[$dsel]='<input type="hidden" class="num_rows_details_file_'.$field.'_edit" value="'.$n.'" /><button id="table_file_'.$field.'_details_edit_hapus" class="ui-button-text icon_hapus" style="width:75px" onclick="javascript:hapus_row_details_file_'.$field.'_edit('.$n.')" type="button">Hapus</button><input type="hidden" name="ifile_'.$field.'[]" value="'.$k->{$idpkd}.'"';
							}else{
								$dataar[$dsel]='<input type="hidden" class="num_rows_details_file_'.$field.'_edit" value="'.$n.'" /><input type="hidden" name="ifile_'.$field.'[]" value="'.$k->{$idpkd}.'"';
							}
						}else{
							$isPD=(in_array($field, $this->isPD))?1:0;
							if($type=="PD" && ($k->iconfirm_busdev==0||$k->iconfirm_busdev==3) && $isPD==1){
								$dataar[$dsel]='<input type="hidden" class="num_rows_details_file_'.$field.'_edit" value="'.$n.'" /><button id="table_file_'.$field.'_details_edit_hapus" class="ui-button-text icon_hapus" style="width:75px" onclick="javascript:hapus_row_details_file_'.$field.'_edit('.$n.')" type="button">Hapus</button><input type="hidden" name="ifile_'.$field.'[]" value="'.$k->{$idpkd}.'"';
							}else{
								$dataar[$dsel]='<input type="hidden" class="num_rows_details_file_'.$field.'_edit" value="'.$n.'" /><input type="hidden" name="ifile_'.$field.'[]" value="'.$k->{$idpkd}.'"';
							}
						}
					}else{
						$dataar[$dsel]='<input type="hidden" class="num_rows_details_file_'.$field.'_edit" value="'.$n.'" />';
					}
				}elseif($vsel=="iconfirm_busdev"){
					$dis="";
					if($type=="BD"){
						if($k->iDone==1){
							$dis="Disabled='disabled'";
						}
					}else{
						$dis="Disabled='disabled'";
					}
					if($k->iDone==1){
						$dis="Disabled='disabled'";
					}
					$arr=array(0=>"Haven't been checked",1=>"Confirm", 2=>"Un Used", 3=>"Un Confirm");
					$opt="<select id='cek_dokumen_registrasi_".$field."_iconfirm_registrasi_".$n."' name='cek_dokumen_registrasi_".$field."_iconfirm_registrasi[".$k->{$idpkd}."][]' ".$dis." >";
					foreach ($arr as $karr => $varr) {
						$sel=$karr==$k->{$vsel}?'selected':'';
						$opt.="<option value='".$karr."' ".$sel.">".$varr."</option>";
					}
					$opt.="</select>";
					$dataar[$z]=$opt;
				}elseif($vsel=="istatus"){
					$dis="";
					if($type!="QA"){
						$dis="Disabled='disabled'";
					}else{
						if($k->iconfirm_busdev==1||$k->iconfirm_busdev==2){
							$dis="Disabled='disabled'";
						}
					}
					if($k->iDone==1){
						$dis="Disabled='disabled'";
					}
					$arr=array(0=>"Draft",1=>"Finish");
					$opt="<select id='cek_dokumen_registrasi_".$field."_istatus_".$n."' name='cek_dokumen_registrasi_".$field."_istatus[".$k->{$idpkd}."][]' ".$dis." >";
					foreach ($arr as $karr => $varr) {
						$sel=$karr==$k->{$vsel}?'selected':'';
						$opt.="<option value='".$karr."' ".$sel.">".$varr."</option>";
					}
					$opt.="</select>";
					$dataar[$z]=$opt;
				}elseif($vsel==$vfilename){
					$dataar[$z]=$linknya;
				}else{
					$dataar[$z]=$k->{$vsel};
				}
				$z++;
			}
			$data->rows[$i]['cell']=$dataar;
			$i++;
		}
		return json_encode($data);
    }

    function getAnotherUPB($field='iupb_id',$iupb_id){
		$ret=0;
		switch ($field) {
			case 'ifor_id':
				$sql_lapori="select * from plc2.plc2_upb_formula where iupb_id=".$iupb_id." and iFormula_process is not null and iapp_basic=2 and iapppd_basic=2 and ldeleted=0 order by ifor_id DESC limit 1";
				$q_lapori=$this->db->query($sql_lapori)->row_array();
				$ret=isset($q_lapori[$field])?$q_lapori[$field]:0;
				break;
			case 'iprotokol_id':
				$sql_lapori="select * from plc2.protokol_valpro where iupb_id=".$iupb_id." and iappqa=2 and lDeleted=0 order by iprotokol_id DESC limit 1";
				$q_lapori=$this->db->query($sql_lapori)->row_array();
				$ret=isset($q_lapori[$field])?$q_lapori[$field]:0;
				break;
			case 'isoi_id':
				$sql_lapori="select * from plc2.plc2_upb_soi_fg fg where fg.iupb_id=".$iupb_id." and fg.ldeleted=0 and fg.iapppd=2 and fg.iappqa=2 order by fg.isoi_id DESC Limit 1";
				$q_lapori=$this->db->query($sql_lapori)->row_array();
				$ret=isset($q_lapori[$field])?$q_lapori[$field]:0;
				break;
			case 'ivalmoa_id':
				$sql_lapori="select * from plc2.plc2_vamoa fg where fg.iupb_id=".$iupb_id." and fg.lDeleted=0 and fg.iapppd=2 order by fg.ivalmoa_id DESC Limit 1";
				$q_lapori=$this->db->query($sql_lapori)->row_array();
				$ret=isset($q_lapori[$field])?$q_lapori[$field]:0;
				break;
			case 'ibk_id':
				$sql_lapori="select * from plc2.plc2_upb_bahan_kemas bk where bk.iupb_id=".$iupb_id." 
				#and bk.iapppc=2 
				and bk.iapppd=2 and bk.iappqa=2 and bk.iappbd=2 and bk.ldeleted=0 order by bk.ibk_id DESC Limit 1";
				$q_lapori=$this->db->query($sql_lapori)->row_array();
				$ret=isset($q_lapori[$field])?$q_lapori[$field]:0;
				break;
			case 'isoibb_id':
				$sql_lapori="select * from plc2.plc2_upb_soi_bahanbaku where iupb_id=".$iupb_id." and ldeleted=0 and iappqa=2 and iappqc=2 order by isoibb_id DESC Limit 1";
				$q_lapori=$this->db->query($sql_lapori)->row_array();
				$ret=isset($q_lapori[$field])?$q_lapori[$field]:0;
				break;
			case 'ilpo_id':
				$sql_lapori="select * from plc2.lpo where iupb_id=".$iupb_id." and ldeleted=0 and iapppd=2 order by ilpo_id DESC Limit 1";
				$q_lapori=$this->db->query($sql_lapori)->row_array();
				$ret=isset($q_lapori[$field])?$q_lapori[$field]:0;
				break;
			case 'ivalidasi_id':
				$sql_lapori="SELECT validasi_proses.*
					FROM plc2.validasi_proses
					INNER JOIN plc2.plc2_upb_formula ON plc2_upb_formula.iupb_id=validasi_proses.iupb_id
					WHERE validasi_proses.iupb_id=".$iupb_id."
					AND validasi_proses.iappqa=2
					GROUP BY validasi_proses.iupb_id
					ORDER BY validasi_proses.iupb_id desc
					LIMIT 1";
				$q_lapori=$this->db->query($sql_lapori)->row_array();
				$ret=isset($q_lapori[$field])?$q_lapori[$field]:0;
				break;
			case 'iFormula':
				$sql_lapori="SELECT formula_stabilita.*
					FROM (pddetail.formula_process)
					INNER JOIN pddetail.formula_process_detail ON formula_process_detail.iFormula_process = formula_process.iFormula_process
					INNER JOIN pddetail.formula_stabilita ON formula_stabilita.iFormula_process = formula_process.iFormula_process
					INNER JOIN plc2.plc2_upb ON plc2_upb.iupb_id = formula_process.iupb_id
					WHERE plc2.plc2_upb.iupb_id=".$iupb_id."
					AND formula_process_detail.lDeleted = 0 
					AND formula_stabilita.lDeleted = 0
					AND formula_process.lDeleted = 0 
					AND formula_process.iMaster_flow IN (9,10,11) 
					GROUP BY plc2.plc2_upb.iupb_id, formula_stabilita.iVersi
					ORDER BY iFormula_process desc
					LIMIT 1";
				$q_lapori=$this->db->query($sql_lapori)->row_array();
				$ret=isset($q_lapori['iFormula_process'])?$q_lapori['iFormula_process']:0;
				break;
			default:
				$ret=$iupb_id;
				break;
		}
		return $ret;
	}



	function download($filename) {
		$this->load->helper('download');
		$type=$_GET['path'];
		$pname='path'.$type;

		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./'.$this->{$pname}.'/'.$id.'/'.$name);	
		force_download($name, $path);
	}

	function getDetailtable($team='PD',$iupb_id){
		$isTeam='is'.$team;
		$isTeamFielad=$this->{$isTeam};
		$table=array();
		$pktable=array();
		$nitable=array();
		foreach ($isTeamFielad as $kteam => $vteam) {
			$tbname='tb'.$vteam;
			$pkname='pk'.$vteam;
			$table[$kteam]=$this->{$tbname};
			$pktable[$kteam]=$this->{$pkname};
			$nitable[$kteam]=$this->getAnotherUPB($this->{$pkname},$iupb_id);
		}
		$dataret['table']=$table;
		$dataret['pktable']=$pktable;
		$dataret['nitable']=$nitable;
		return $dataret;
	}	

	function getDetailtableUse($post){
		$isPD=$this->isPD;
		$isQA=$this->isQA;
		$isTeamFielad=array_merge($isPD,$isQA);
		$table=array();
		$pktable=array();
		$nitable=array();
		$caption=array();
		$iupb_id=$post['iupb_id'];
		foreach ($isTeamFielad as $kteam => $vteam) {
			$tbname='tb'.$vteam;
			$pkname='pk'.$vteam;
			$capname='caption'.$vteam;
			$table[$kteam]=$this->{$tbname};
			$pktable[$kteam]=$this->{$pkname};
			$caption[$kteam]=$this->{$capname};
			$nitable[$kteam]=$this->getAnotherUPB($this->{$pkname},$iupb_id);
		}
		$dataret['table']=$table;
		$dataret['pktable']=$pktable;
		$dataret['nitable']=$nitable;
		$dataret['caption']=$caption;
		return $dataret;
	}

	function cek_dokumen_confirm($post){
		$iupb_id=$post['iupb_id'];
		$isPD=$this->isPD;
		$isQA=$this->isQA;
		$isTeamFielad=array_merge($isPD,$isQA);
		$ii=0;
		foreach ($isTeamFielad as $kteam => $vteam) {
			$tbname='tb'.$vteam;
			$pkname='pk'.$vteam;
			$nitable=$this->getAnotherUPB($this->{$pkname},$iupb_id);
			$sqlc="select * from ".$this->{$tbname}." where (ldeleted is null or ldeleted=0) and iconfirm_busdev in (0,3) and ".$this->{$pkname}."=".$nitable;
			if($this->dbset->query($sqlc)->num_rows()>=1){
				$ii++;
			}
		}
		return $ii;
	}

	function doneprocess(){
		$post=$this->input->post();
		$get=$this->input->get();
		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$field=$get['field'];
		$updone = array();
		$updone['iDone']=1;
		$updone['dDoneDate']=$skg;
		$updone['cDone']=$nip;
		$tbname='tb'.$field;
		$pkname='pk'.$field;
		$captionname='caption'.$field;
		$id=$this->getAnotherUPB($this->{$pkname},$post['iupb_id']);
		$this->dbset->where('(ldeleted is NULL or ldeleted=0)',NULL);
		$this->dbset->where($this->{$pkname},$id);
		$this->dbset->update($this->{$tbname},$updone);
		$r = $get;
		$r['status'] = TRUE;
		$r['message'] = 'Done '.$this->{$captionname}.' Success!';
		return json_encode($r);
	}

	function getERPPrivi($imoduleid){
		$this->dbset->where('idprivi_modules',$imoduleid);
		$row=$this->dbset->get('erp_privi.privi_modules')->row_array();
		return $row;
	}

}