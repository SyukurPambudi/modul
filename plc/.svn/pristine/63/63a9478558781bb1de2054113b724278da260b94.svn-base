<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_prareg extends CI_Model {

	function __construct() {
	    parent::__construct();
	  	$this->dbset = $this->load->database('plc0',false, true);
	    $this->user = $this->auth_localnon->user();

	    /*Field Untuk PD*/
	    /*$this->isPD = array('filedmf','filecoars','filecoaws','filecoabb_lsa','filespekfg','filelpp','filecoaex','filelsaex','filevamoa','filelpo','fileprot_stab','fileprot_udt','filesoiex','filebk');
	    $this->isQA = array('filesoibb','fileproval','filesoifg');*/
	    $this->isPD = array('filecoars','filecoaws','filespekfg','filelpp','filevamoa','filelpo','fileprot_stab','fileprot_udt');
	    $this->isQA = array('filedmf','filecoabb_lsa','filesoibb','fileproval','filesoifg','filecoaex','filelsaex','filesoiex','filebk');

	    /*File DMF Config*/
		$this->tbfiledmf='plc2.plc2_upb_file_bk_dmf'; //Data Table Upload
		$this->pkfiledmf='iupb_id'; //Untuk Header
		$this->pkdfiledmf='id'; //Id PK File
		$this->pathfiledmf = "files/plc/dmf"; //PathFile
		$this->rselfiledmf=array('iconfirm_busdev','istatus','filename','vketerangan','iact'); //Data Grid View
		$this->fuploadfiledmf='filename, dInsertDate, vketerangan, cInsert'; //Data Grid View
		$this->fdupdatefiledmf='dUpdateDate'; //Data Grid View
		$this->fcupdatefiledmf='cUpdated'; //Data Grid View
		$this->filenamefiledmf='filename'; //Data Grid View
		$this->captionfiledmf='File DMF'; //Data Grid View
		/*End DMF*/

		/*Coa RS Config*/
		$this->tbfilecoars='plc2.plc2_upb_pilot_file_coars'; //Data Table Upload
		$this->pkfilecoars='ifor_id'; //Untuk Header
		$this->pkdfilecoars='id'; //Id PK File
		$this->pathfilecoars = "files/plc/pilot/coars"; //PathFile
		$this->rselfilecoars=array('iconfirm_busdev','istatus','filename','keterangan','iact'); //Data Grid View
		$this->fuploadfilecoars='filename, dInsertDate, keterangan, cInsert'; //Data Grid View
		$this->fdupdatefilecoars='dUpdateDate'; //Data Grid View
		$this->fcupdatefilecoars='cUpdated'; //Data Grid View
		$this->filenamefilecoars='filename'; //Data Grid View
		$this->captionfilecoars='File CoA RS'; //Data Grid View
		/*End Coa*/

		/*Coa WS Config*/
		$this->tbfilecoaws='plc2.plc2_upb_pilot_file_coaws'; //Data Table Upload
		$this->pkfilecoaws='ifor_id'; //Untuk Header
		$this->pkdfilecoaws='id'; //Id PK File
		$this->pathfilecoaws = "files/plc/pilot/coaws"; //PathFile
		$this->rselfilecoaws=array('iconfirm_busdev','istatus','filename','keterangan','iact'); //Data Grid View
		$this->fuploadfilecoaws='filename, dInsertDate, keterangan, cInsert'; //Data Grid View
		$this->fdupdatefilecoaws='dUpdateDate'; //Data Grid View
		$this->fcupdatefilecoaws='cUpdated'; //Data Grid View
		$this->filenamefilecoaws='filename'; //Data Grid View
		$this->captionfilecoaws='File CoA WS'; //Data Grid View
		/*End Coa*/

		/*filecoabb_lsa Config*/
		$this->tbfilecoabb_lsa='plc2.plc2_upb_pilot_file_coabb_lsa'; //Data Table Upload
		$this->pkfilecoabb_lsa='ifor_id'; //Untuk Header
		$this->pkdfilecoabb_lsa='id'; //Id PK File
		$this->pathfilecoabb_lsa = "files/plc/pilot/coabb_lsa"; //PathFile
		$this->rselfilecoabb_lsa=array('iconfirm_busdev','istatus','filename','keterangan','iact'); //Data Grid View
		$this->fuploadfilecoabb_lsa='filename, dInsertDate, keterangan, cInsert'; //Data Grid View
		$this->fdupdatefilecoabb_lsa='dUpdateDate'; //Data Grid View
		$this->fcupdatefilecoabb_lsa='cUpdated'; //Data Grid View
		$this->filenamefilecoabb_lsa='filename'; //Data Grid View
		$this->captionfilecoabb_lsa='File CoA & LSA Zat Aktif'; //Data Grid View
		/*End Coa*/

		/*filecoabb_lsa Config*/
	$this->tbfilesoibb='plc2.plc2_upb_file_soi_bahanbaku'; //Data Table Upload
		$this->pkfilesoibb='isoibb_id'; //Untuk Header
		$this->pkdfilesoibb='id'; //Id PK File
		$this->pathfilesoibb = "files/plc/soi_bahanbaku"; //PathFile
		$this->rselfilesoibb=array('iconfirm_busdev','istatus','filename','vKeterangan','iact'); //Data Grid View
		$this->fuploadfilesoibb='filename, dInsertDate, vKeterangan, cInsert'; //Data Grid View
		$this->fdupdatefilesoibb='dUpdateDate'; //Data Grid View
		$this->fcupdatefilesoibb='cUpdated'; //Data Grid View
		$this->filenamefilesoibb='filename'; //Data Grid View
		$this->captionfilesoibb='File SOI BB'; //Data Grid View
		/*End Coa*/

		/*filespekfg Config*/
		$this->tbfilespekfg='plc2.plc2_file_spesifikasi'; //Data Table Upload
		$this->pkfilespekfg='ifor_id'; //Untuk Header
		$this->pkdfilespekfg='id'; //Id PK File
		$this->pathfilespekfg = "files/plc/product_trial/basic_formula/spesifikasi_fg"; //PathFile
		$this->rselfilespekfg=array('iconfirm_busdev','istatus','filename','keterangan','iact'); //Data Grid View
		$this->fuploadfilespekfg='filename, dInsertDate, keterangan, cInsert'; //Data Grid View
		$this->fdupdatefilespekfg='dUpdateDate'; //Data Grid View
		$this->fcupdatefilespekfg='cUpdated'; //Data Grid View
		$this->filenamefilespekfg='filename'; //Data Grid View
		$this->captionfilespekfg='File Spesifikasi FG'; //Data Grid View
		/*End Coa*/

		/*filelpp Config*/
		$this->tbfilelpp='plc2.lpp_file'; //Data Table Upload
		$this->pkfilelpp='ifor_id'; //Untuk Header
		$this->pkdfilelpp='ilpp_file_id'; //Id PK File
		$this->pathfilelpp = "files/plc/lpp"; //PathFile
		$this->rselfilelpp=array('iconfirm_busdev','istatus','vFilename','vKeterangan','iact'); //Data Grid View
		$this->fuploadfilelpp='vFilename, dCreate, vKeterangan, cCreate'; //Data Grid View
		$this->fdupdatefilelpp='dupdate'; //Data Grid View
		$this->fcupdatefilelpp='cUpdate'; //Data Grid View
		$this->filenamefilelpp='vFilename'; //Data Grid View
		$this->captionfilelpp='Laporan Pengembangan Produk '; //Data Grid View
		/*End Coa*/

		/*fileproval Config*/
		$this->tbfileproval='plc2.protokol_valpro_file'; //Data Table Upload
		$this->pkfileproval='iprotokol_id'; //Untuk Header
		$this->pkdfileproval='iprotokol_detail_id'; //Id PK File
		$this->pathfileproval = "files/plc/protokol_valpro"; //PathFile
		$this->rselfileproval=array('iconfirm_busdev','istatus','vFilename','vKeterangan','iact'); //Data Grid View
		$this->fuploadfileproval='vFilename, dCreate, vKeterangan, cCreate'; //Data Grid View
		$this->fdupdatefileproval='dupdate'; //Data Grid View
		$this->fcupdatefileproval='cUpdate'; //Data Grid View
		$this->filenamefileproval='vFilename'; //Data Grid View
		$this->captionfileproval='File Protokol Valpro'; //Data Grid View
		/*End Coa*/

		/*filecoaex Config*/
		$this->tbfilecoaex='plc2.plc2_upb_file_coa_ex'; //Data Table Upload
		$this->pkfilecoaex='ifor_id'; //Untuk Header
		$this->pkdfilecoaex='id'; //Id PK File
		$this->pathfilecoaex = "files/plc/coaex"; //PathFile
		$this->rselfilecoaex=array('iconfirm_busdev','istatus','filename','keterangan','iact'); //Data Grid View
		$this->fuploadfilecoaex='filename, dInsertDate, keterangan, cInsert'; //Data Grid View
		$this->fdupdatefilecoaex='dUpdateDate'; //Data Grid View
		$this->fcupdatefilecoaex='cUpdated'; //Data Grid View
		$this->filenamefilecoaex='filename'; //Data Grid View
		$this->captionfilecoaex='File CoA Excipient'; //Data Grid View
		/*End Coa*/

		/*filelsaex Config*/
		$this->tbfilelsaex='plc2.plc2_upb_file_lsa_ex'; //Data Table Upload
		$this->pkfilelsaex='ifor_id'; //Untuk Header
		$this->pkdfilelsaex='id'; //Id PK File
		$this->pathfilelsaex = "files/plc/lsaex"; //PathFile
		$this->rselfilelsaex=array('iconfirm_busdev','istatus','filename','keterangan','iact'); //Data Grid View
		$this->fuploadfilelsaex='filename, dInsertDate, keterangan, cInsert'; //Data Grid View
		$this->fdupdatefilelsaex='dUpdateDate'; //Data Grid View
		$this->fcupdatefilelsaex='cUpdated'; //Data Grid View
		$this->filenamefilelsaex='filename'; //Data Grid View
		$this->captionfilelsaex='File LSA Excipient'; //Data Grid View
		/*End Coa*/

		/*filesoifg Config*/
		$this->tbfilesoifg='plc2.plc2_upb_file_soi_fg'; //Data Table Upload
		$this->pkfilesoifg='isoi_id'; //Untuk Header
		$this->pkdfilesoifg='id'; //Id PK File
		$this->pathfilesoifg = "files/plc/spek_soi_fg"; //PathFile
		$this->rselfilesoifg=array('iconfirm_busdev','istatus','filename','vKeterangan','iact'); //Data Grid View
		$this->fuploadfilesoifg='filename, dInsertDate, vKeterangan, cInsert'; //Data Grid View
		$this->fdupdatefilesoifg='dUpdateDate'; //Data Grid View
		$this->fcupdatefilesoifg='cUpdated'; //Data Grid View
		$this->filenamefilesoifg='filename'; //Data Grid View
		$this->captionfilesoifg='File SOI FG'; //Data Grid View
		/*End Coa*/

		/*filevamoa Config*/
		$this->tbfilevamoa='plc2.plc2_vamoa_file'; //Data Table Upload
		$this->pkfilevamoa='ivalmoa_id'; //Untuk Header
		$this->pkdfilevamoa='ivamoa_file_id'; //Id PK File
		$this->pathfilevamoa = "files/plc/validasi_moa"; //PathFile
		$this->rselfilevamoa=array('iconfirm_busdev','istatus','vFilename','vKeterangan','iact'); //Data Grid View
		$this->fuploadfilevamoa='vFilename, dCreate, vKeterangan, cCreate'; //Data Grid View
		$this->fdupdatefilevamoa='dupdate'; //Data Grid View
		$this->fcupdatefilevamoa='cUpdate'; //Data Grid View
		$this->filenamefilevamoa='vFilename'; //Data Grid View
		$this->captionfilevamoa='File protokol Validasi MoA'; //Data Grid View
		/*End Coa*/

		/*filelpo Config*/
		$this->tbfilelpo='plc2.lpo_file'; //Data Table Upload
		$this->pkfilelpo='ilpo_id'; //Untuk Header
		$this->pkdfilelpo='ilpo_file_id'; //Id PK File
		$this->pathfilelpo = "files/plc/lpo"; //PathFile
		$this->rselfilelpo=array('iconfirm_busdev','istatus','vFilename','vKeterangan','iact'); //Data Grid View
		$this->fuploadfilelpo='vFilename, dCreate, vKeterangan, cCreate'; //Data Grid View
		$this->fdupdatefilelpo='dupdate'; //Data Grid View
		$this->fcupdatefilelpo='cUpdate'; //Data Grid View
		$this->filenamefilelpo='vFilename'; //Data Grid View
		$this->captionfilelpo='File Laporan Pemeriksaan Originator'; //Data Grid View
		/*End Coa*/

		/*fileprot_stab Config*/
		$this->tbfileprot_stab='plc2.plc2_upb_pilot_file_prot_stab'; //Data Table Upload
		$this->pkfileprot_stab='ifor_id'; //Untuk Header
		$this->pkdfileprot_stab='id'; //Id PK File
		$this->pathfileprot_stab = "files/plc/pilot/prot_stab"; //PathFile
		$this->rselfileprot_stab=array('iconfirm_busdev','istatus','filename','keterangan','iact'); //Data Grid View
		$this->fuploadfileprot_stab='filename, dInsertDate, keterangan, cInsert'; //Data Grid View
		$this->fdupdatefileprot_stab='dUpdateDate'; //Data Grid View
		$this->fcupdatefileprot_stab='cUpdated'; //Data Grid View
		$this->filenamefileprot_stab='filename'; //Data Grid View
		$this->captionfileprot_stab='File Protokol Stabilita'; //Data Grid View
		/*End Coa*/

		/*fileprot_udt Config*/
		$this->tbfileprot_udt='plc2.plc2_upb_pilot_file_prot_udt'; //Data Table Upload
		$this->pkfileprot_udt='ifor_id'; //Untuk Header
		$this->pkdfileprot_udt='id'; //Id PK File
		$this->pathfileprot_udt = "files/plc/prot_udt"; //PathFile
		$this->rselfileprot_udt=array('iconfirm_busdev','istatus','filename','keterangan','iact'); //Data Grid View
		$this->fuploadfileprot_udt='filename, dInsertDate, keterangan, cInsert'; //Data Grid View
		$this->fdupdatefileprot_udt='dUpdateDate'; //Data Grid View
		$this->fcupdatefileprot_udt='cUpdated'; //Data Grid View
		$this->filenamefileprot_udt='filename'; //Data Grid View
		$this->captionfileprot_udt='File Protokol UDT'; //Data Grid View
		/*End Coa*/

		/*filesoiex Config*/
		$this->tbfilesoiex='plc2.plc2_upb_file_soi_ex'; //Data Table Upload
		$this->pkfilesoiex='ifor_id'; //Untuk Header
		$this->pkdfilesoiex='id'; //Id PK File
		$this->pathfilesoiex = "files/plc/soiex"; //PathFile
		$this->rselfilesoiex=array('iconfirm_busdev','istatus','filename','keterangan','iact'); //Data Grid View
		$this->fuploadfilesoiex='filename, dInsertDate, keterangan, cInsert'; //Data Grid View
		$this->fdupdatefilesoiex='dUpdateDate'; //Data Grid View
		$this->fcupdatefilesoiex='cUpdated'; //Data Grid View
		$this->filenamefilesoiex='filename'; //Data Grid View
		$this->captionfilesoiex='File SOI Excipients'; //Data Grid View
		/*End Coa*/

		/*filebk Config*/
		$this->tbfilebk='plc2.plc2_upb_file_bahan_kemas'; //Data Table Upload
		$this->pkfilebk='ibk_id'; //Untuk Header
		$this->pkdfilebk='id'; //Id PK File
		$this->pathfilebk = "files/plc/bahan_kemas/bahan_kemas_primer"; //PathFile
		$this->rselfilebk=array('iconfirm_busdev','istatus','filename','vketerangan','iact'); //Data Grid View
		$this->fuploadfilebk='filename, dInsertDate, vketerangan, cInsert'; //Data Grid View
		$this->fdupdatefilebk='dUpdateDate'; //Data Grid View
		$this->fcupdatefilebk='cUpdated'; //Data Grid View
		$this->filenamefilebk='filename'; //Data Grid View
		$this->captionfilebk='File Bahan Kemas'; //Data Grid View
		/*End Coa*/
	}

	function updateUploadFile($filejenis='',$type='',$dataretu=array(),$iupb_id=0){
		$filepath='path'.$filejenis;
		$pkfilecoars='pk'.$filejenis;
		$tbfile='tb'.$filejenis;
		$fieldupload='fupload'.$filejenis;
		$id=$this->getAnotherUPB($this->{$pkfilecoars},$iupb_id);
		$fileketerangan=$dataretu[$filejenis]['fileketerangan'];
		$istatus_upload=$dataretu[$filejenis]['istatus_upload'];
		$iconfirm_prareg_upload=$dataretu[$filejenis]['iconfirm_prareg_upload'];
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
								VALUES (".$id.",'".$data['filename']."','".$data['dInsertDate']."','".$fileketerangan[$i]."','".$this->user->gNIP."','".$istatus_upload[$i]."','".$iconfirm_prareg_upload[$i]."')";
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

		$iupb_id=$post['cek_dokumen_prareg_iupb_id'];
		$id=$this->getAnotherUPB($this->{$pkjenis},$iupb_id);

		$pathjenisfix = realpath($this->{$pathjenis});
		if(!file_exists($pathjenisfix."/".$id)){
			if (!mkdir($pathjenisfix."/".$id, 0777, true)) { //id review
				die('Failed upload, try again - '.$filejenis.'!');
			}
		}
		$fileketeranganmain = array();
		$istatusmain = array();
		$iconfirmprareg = array();
		$iconfirm_prareg_upload = array();
		$istatusmain_upload = array();
		$fileidmain='';
		foreach($_POST as $key=>$value) {
			if($key == 'cek_dokumen_prareg_'.$filejenis.'_istatus'){
				foreach($value as $y=>$u) {
					if($y!=0){
						$istatusmain[$y]=$u[0];
					}else{
						$istatusmain_upload[]=$u;
					}
				}
			}
			if($key == 'cek_dokumen_prareg_'.$filejenis.'_iconfirm_prareg'){
				foreach($value as $y=>$u) {
					if($y!=0){
						$iconfirmprareg[$y]=$u[0];
					}else{
						$iconfirm_prareg_upload[]=$u;
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
			if(count($iconfirm_prareg_upload)>=1){
				$iconfirm_prareg_upload=$iconfirm_prareg_upload[0];
			}
			if(count($istatusmain_upload)>=1){
				$istatusmain_upload=$istatusmain_upload[0];
			}
			foreach ($fileketeranganmain as $kketmain => $vketmain) {
				if(!isset($iconfirm_prareg_upload[$kketmain])){
					if($type!='BD'){
						$iconfirm_prareg_upload[$kketmain]=0;
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
		if(count($iconfirmprareg)>=1){
			foreach ($iconfirmprareg as $kmain => $vmain) {
				$sqlupp="update ".$this->{$tbjenis}." set iconfirm_busdev=".$vmain." where ".$this->{$pkjenis}."='".$id."' and ".$this->{$pkdjenis}."=".$kmain;
				$this->dbset->query($sqlupp);
			}
		}


		$dataret['fileketerangan']=$fileketeranganmain;
		$dataret['istatus_upload']=$istatusmain_upload;
		$dataret['iconfirm_prareg_upload']=$iconfirm_prareg_upload;
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
			//if($type!='QA'){
				$dgrid['ddd']=1;
			//}
		}

		return $dgrid;
	}

	function get_cek_dokumen_prareg_filemain(){

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
						$link = base_url().'processor/plc/cek_dokumen_prareg?action=download&id='.$id.'&file='.$value.'&path='.$field;
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
					$opt="<select id='cek_dokumen_prareg_".$field."_iconfirm_prareg_".$n."' name='cek_dokumen_prareg_".$field."_iconfirm_prareg[".$k->{$idpkd}."][]' ".$dis." >";
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
					$opt="<select id='cek_dokumen_prareg_".$field."_istatus_".$n."' name='cek_dokumen_prareg_".$field."_istatus[".$k->{$idpkd}."][]' ".$dis." >";
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

}