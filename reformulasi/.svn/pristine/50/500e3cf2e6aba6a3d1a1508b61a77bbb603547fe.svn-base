<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class local_stabilita_pilot_popup extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth_local');
		$this->_field = $this->input->get('field');
		$this->dbset = $this->load->database('formulasi', false, true);
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List Usulan');		
		$grid->setTable('reformulasi.lokal_refor_skala_trial');		
		$grid->setUrl('local_stabilita_pilot_popup');
		$grid->addList('pilih','vnoFormulasi','local_req_refor.vNo_req_refor','itemas.c_itnam');
		$grid->setSortBy('local_req_refor.vNo_req_refor');
		$grid->setSortOrder('DESC');
		$grid->setWidth('local_req_refor.vNo_req_refor', '100');
		$grid->setWidth('itemas.c_itnam', '300');
		$grid->setWidth('local_req_refor.vBatch_no', '100');
		$grid->setWidth('pilih', '25');
		$grid->setLabel('local_req_refor.vNo_req_refor', 'No Request');
		$grid->setLabel('itemas.c_itnam', 'Nama Produk');
		$grid->setLabel('local_req_refor.vBatch_no', 'No Batch');
		$grid->setLabel('vnoFormulasi', 'No Formulasi');
		$grid->setJoinTable('reformulasi.local_req_refor', 'local_req_refor.iLocal_req_refor = reformulasi.lokal_refor_skala_trial.iLocal_req_refor', 'inner');
		$grid->setJoinTable('sales.itemas', 'itemas.c_iteno = reformulasi.local_req_refor.cIteno', 'inner');
		$grid->setSearch('local_req_refor.vNo_req_refor','itemas.c_itnam');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setQuery("(lokal_refor_skala_trial.ilokal_refor_skala_trial IN 
				(SELECT tr.ilokal_refor_skala_trial FROM reformulasi.lokal_refor_skala_trial tr
					LEFT JOIN reformulasi.lokal_mapping_refor mp ON tr.iLocal_req_refor = mp.iLocal_req_refor
					WHERE tr.iappd = '2' AND tr.lDeleted = '0' AND tr.ilokal_refor_skala_trial IN 
						(SELECT mbr.ilokal_refor_skala_trial FROM reformulasi.lokal_ref_dok_mbr mbr WHERE mbr.iapppd = '2' AND mbr.ldeleted = '0')
						AND mp.imaster_proses_refor <> '9')
			OR lokal_refor_skala_trial.ilokal_refor_skala_trial IN
				(SELECT tr.ilokal_refor_skala_trial FROM reformulasi.lokal_refor_skala_trial tr
					LEFT JOIN reformulasi.lokal_mapping_refor mp ON tr.iLocal_req_refor = mp.iLocal_req_refor
					WHERE tr.iappd = '2' AND tr.lDeleted = '0' AND tr.ilokal_refor_skala_trial IN 
						(SELECT pl.ilokal_refor_skala_trial FROM reformulasi.lokal_refor_prod_pilot pl WHERE pl.iapppd = '2' AND pl.ldeleted = '0')
						AND mp.imaster_proses_refor = '9')) ",NULL);
		$grid->setQuery("lokal_refor_skala_trial.ilokal_refor_skala_trial NOT IN 
			(SELECT plt.ilokal_refor_skala_trial FROM reformulasi.lokal_refor_stabilita_pilot plt WHERE plt.ldeleted = '0')",NULL);
		$grid->setQuery('lokal_refor_skala_trial.ldeleted',0);
		$grid->setQuery('lokal_refor_skala_trial.iappd',2);
		// $grid->setQuery('IF(local_req_refor.iUji_be=1,(SELECT COUNT(uj.`ilocal_req_ujibe`) FROM reformulasi.`local_req_ujibe` uj JOIN 
		// 	 reformulasi.`lokal_refor_skala_trial` lr ON `uj`.`ilokal_refor_skala_trial` = lr.ilokal_refor_skala_trial
		// 	 WHERE lr.`lDeleted` = 0 AND uj.`iapp_pd`=2 AND uj.`lDeleted` = 0 AND lr.`iLocal_req_refor` = `local_req_refor`.`iLocal_req_refor`)>0,
		// 	 local_req_refor.iUji_be=0)',NULL);
		$grid->setQuery('lokal_refor_skala_trial.iksm_skala_trial',1);


		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;	
			case 'get_details':
				echo $this->get_details();
				break;
			case 'getdetailsMR':
				echo $this->getdetailsMR();
				break;
			case 'download':
				$this->download($this->input->get('file'));
				break;
			default:
				$grid->render_grid();
				break;
		}
    }

	function output(){
    	$this->index($this->input->get('action'));
    }
    function download($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/reformulasi/local/request_refor/'.$id.'/'.$name);	
		force_download($name, $path);
	}


    function get_details(){
    	$post=$this->input->post();
		$d['post']=$post;
		$d['nmTable']="tb_req_refor_stabpilot";
		$d['pager']="pager_tb_req_refor_stabpilot";
		$d['caption'] = "List File Request Refor";
    	$data['details']=$this->load->view('local/jqgrid/details_req_study',$d,true);
    	return json_encode($data);
    }

    function getdetailsMR(){
    	$post=$this->input->get();
		$sql_data='select * from reformulasi.local_req_refor_file f where f.lDeleted=0 and f.iLocal_req_refor='.$post['id'];
		$q=$this->db->query($sql_data);
		$rsel=array('vFilename','vKeterangan','iact');
		$data = new StdClass;
		$data->records=$q->num_rows();
		$i=0;
		foreach ($q->result() as $k) {
			$data->rows[$i]['id']=$k->iLocal_req_refor_file;
			$z=0;
			foreach ($rsel as $dsel => $vsel) {
				if($vsel=="iact"){
					$value = $k->vFilename;	
					$linknya = 'No File';
					if($value != '') {
						if (file_exists('./files/reformulasi/local/request_refor/'.$k->iLocal_req_refor.'/'.$value)) {
							$link = base_url().'processor/reformulasi/local/stabilita/pilot/popup?action=download&id='.$k->iLocal_req_refor.'&file='.$value;
							$linknya = '<a class="ui-button-text icon_cetak" href="javascript:;" onclick="window.location=\''.$link.'\'">Download</a>';
						}
						else {
							$linknya = 'File Deleted';
						}
					}
					$dataar[$dsel]=$linknya;
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

	function listBox_local_stabilita_pilot_popup_pilih($value, $pk, $name, $rowData) {
		$dtrefor=$this->getrefordata($rowData->iLocal_req_refor);
		$iAm['vdepartemen']="-";
		$iapp['vName']="-";
		$req['vName']="-";
		if($dtrefor['cInisiator']!=""){
			$iAm = $this->whoAmI($dtrefor['cInisiator']);
		}
		if($dtrefor['cApproval']!=""){
			$iapp = $this->whoAmI($dtrefor['cApproval']);
		}
		if($dtrefor['cFormulator']!=""){
			$req = $this->whoAmI($dtrefor['cFormulator']);
		}
		$iteam=array(0=>"NULL",1=>"Gunung Putri",2=>"Ulujami PD",3=>"Etercon");
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_std_popup(\''.$pk.'\',\''.$dtrefor['iLocal_req_refor'].'\',\''.$dtrefor['vNo_req_refor'].'\',\''.$dtrefor['c_itnam'].'\',\''.$dtrefor['vBatch_no'].'\',\''.$dtrefor['cInisiator'].'\',\''.$iAm['vdepartemen'].'\',\''.$dtrefor['vAlasan_refor'].'\',\''.$iteam[$dtrefor['iteam_pd']].'\',\''.$dtrefor['dRequest'].'\',\''.$iapp['vName'].'\',\''.$req['vName'].'\',\''.$rowData->vnoFormulasi.'\') ;" />';
		$o.='<script>
				function pilih_upb_std_popup(ilokal_refor_skala_trial,iLocal_req_refor,vNo_req_refor,cIteno,vBatch_no,cInisiator,vdepartemen,vAlasan_refor,iteam_pd,dRequest,cApproval,cFormulator,vnoFormulasi){
					custom_confirm("Yakin ?", function(){
						$("#'.$this->input->get('field').'_ilokal_refor_skala_trial").val(ilokal_refor_skala_trial);
						$("#'.$this->input->get('field').'_vNo_req_refor_dis").val(vNo_req_refor);
						$("#'.$this->input->get('field').'_cIteno").val(cIteno);
						$("#'.$this->input->get('field').'_vBatch_no").val(vBatch_no);
						$("#'.$this->input->get('field').'_cInisiator").val(cInisiator);
						$("#'.$this->input->get('field').'_idept_id").val(vdepartemen);
						$("#'.$this->input->get('field').'_iteam_pd").val(iteam_pd);
						$("#'.$this->input->get('field').'_vAlasan_refor").text(vAlasan_refor);
						$("#'.$this->input->get('field').'_dRequest").val(dRequest);
						$("#'.$this->input->get('field').'_cApproval").val(cApproval);
						$("#'.$this->input->get('field').'_cFormulator").val(cFormulator);
						$("#'.$this->input->get('field').'_vnoFormulasi").val(vnoFormulasi);
						/*Untuk Me Load Details Upload Request Refor*/
						$.ajax({
							url: base_url+"processor/reformulasi/local_stabilita_pilot_popup?action=get_details",
							type: "post",
							data: "id="+iLocal_req_refor,
							success: function(data) {
								var o = $.parseJSON(data);
								$("label[for=\''.$this->input->get('field').'_details\']").next().html(o.details);
							}
						});
						$("#alert_dialog_form").dialog("close");
					});
				}
			</script>';
		return $o;
	}
	function getrefordata($id=0){
		$sql="select * from reformulasi.local_req_refor r 
			join sales.itemas i on i.c_iteno = r.cIteno
			where r.iLocal_req_refor=".$id;
		$ret=$this->dbset->query($sql)->row_array();
		return $ret;
	} 
	function whoAmI($nip){
        $sql = 'select b.vDescription as vdepartemen,a.vName,a.cNip
                from hrd.employee a 
                join hrd.msdepartement b on b.iDeptID=a.iDepartementID
                where a.cNip ="'.$nip.'"
                ';
        $data = $this->db->query($sql);
       if($data->num_rows()>=1){
       	$dt=$data->row_array();
        return $dt;
       }else{
       	return "0";
       }
    }
}
