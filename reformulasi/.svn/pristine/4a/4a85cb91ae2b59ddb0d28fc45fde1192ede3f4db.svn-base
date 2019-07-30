<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class lokal_req_ujibe_browse extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth_local');
		$this->_field = $this->input->get('field');
		$this->dbset = $this->load->database('formulasi', false, true);
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List Request Uji BE');		
		$grid->setTable('reformulasi.lokal_refor_skala_trial');		
		$grid->setQuery('local_req_refor.iUji_be ', "1"); 
        
		$grid->setUrl('lokal_req_ujibe_browse');
		$grid->addList('pilih','local_req_refor.vNo_req_refor','itemas.c_itnam','lokal_refor_skala_trial.vnoFormulasi');
		
		$grid->setSortBy('local_req_refor.vNo_req_refor');
		$grid->setSortOrder('DESC');
		$grid->setWidth('local_req_refor.vNo_req_refor', '100');
		$grid->setWidth('itemas.c_itnam', '300');
		$grid->setWidth('lokal_refor_skala_trial.vnoFormulasi', '100');
		

		$grid->setWidth('pilih', '25');
		$grid->setLabel('local_req_refor.vNo_req_refor', 'No Request');
		$grid->setLabel('itemas.c_itnam', 'Nama Produk');
		$grid->setLabel('lokal_refor_skala_trial.vnoFormulasi','No Formulasi');
		

		$grid->setSearch('local_req_refor.vNo_req_refor','itemas.c_itnam');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');

		$grid->setJoinTable('reformulasi.local_req_refor', 'local_req_refor.iLocal_req_refor = reformulasi.lokal_refor_skala_trial.iLocal_req_refor', 'inner');
		$grid->setJoinTable('sales.itemas', 'itemas.c_iteno = reformulasi.local_req_refor.cIteno', 'inner');


		/*$grid->setQuery('lokal_refor_skala_trial.ilokal_refor_skala_trial not in (select b.ilokal_refor_skala_trial from reformulasi.local_req_ujibe b where b.ldeleted=0)', NULL);*/

		$grid->setQuery('lokal_refor_skala_trial.ilokal_refor_skala_trial IN (CASE
				#Apabila Scale Up Harus Di lalui 
				WHEN
				 	(select count(ma.iLocal_req_refor) as jml from reformulasi.lokal_mapping_refor ma
				 		join reformulasi.master_proses_refor m on m.imaster_proses_refor=ma.imaster_proses_refor
				 		where ma.lDeleted=0 and m.lDeleted=0 and m.vkode_proses_refor="SKLA" and ma.iLocal_req_refor=lokal_refor_skala_trial.iLocal_req_refor)>0
			 	THEN
				 	(select tr.ilokal_refor_skala_trial from reformulasi.lokal_refor_skala_trial tr
				 		join reformulasi.lokal_refor_skala_lab lb on lb.iLocal_req_refor=tr.iLocal_req_refor and lb.vnoFormulasi=tr.vnoFormulasi
				 		where tr.ldeleted=0 and lb.ldeleted=0 and tr.iflag_open=0 and lb.iflag_open=0 and lb.iappd=2 and lb.iksm_skala_lab=1 and lb.iLocal_req_refor=lokal_refor_skala_trial.iLocal_req_refor)
				 #Apabila Stress Test Dilalui
				 WHEN
				 	(select count(ma.iLocal_req_refor) as jml from reformulasi.lokal_mapping_refor ma
				 		join reformulasi.master_proses_refor m on m.imaster_proses_refor=ma.imaster_proses_refor
				 		where ma.lDeleted=0 and m.lDeleted=0 and m.vkode_proses_refor="STRS" and ma.iLocal_req_refor=lokal_refor_skala_trial.iLocal_req_refor)>0
			 	THEN
				 	(select tr.ilokal_refor_skala_trial from reformulasi.lokal_refor_skala_trial tr
				 		join reformulasi.lokal_refor_stress_test lb on lb.iLocal_req_refor=tr.iLocal_req_refor and lb.vnoFormulasi=tr.vnoFormulasi
				 		where tr.ldeleted=0 and lb.ldeleted=0 and tr.iflag_open=0 and lb.iflag_open=0 and lb.iappd=2 and lb.iksm_stress_test=1 and lb.iLocal_req_refor=lokal_refor_skala_trial.iLocal_req_refor)
			ELSE
			  		(select ilokal_refor_skala_trial from reformulasi.lokal_refor_skala_trial tr where tr.ldeleted=0 and tr.iappd=2 and tr.iksm_skala_trial=1 and tr.iLocal_req_refor=lokal_refor_skala_trial.iLocal_req_refor)
			end)',NULL);
		/*$grid->setQuery('local_req_refor.ilokal_refor_skala_trial NOT IN (select st.ilokal_refor_skala_trial from reformulasi.lokal_refor_stabilita_lab st where st.ldeleted=0)',NULL);*/
		
		$grid->setQuery('lokal_refor_skala_trial.ilokal_refor_skala_trial not in (select b.ilokal_refor_skala_trial from reformulasi.local_req_ujibe b where b.ldeleted=0)', NULL);
		$grid->setQuery('local_req_refor.iLocal_req_refor IN (select ma.iLocal_req_refor from reformulasi.lokal_mapping_refor ma
			join reformulasi.master_proses_refor m on m.imaster_proses_refor=ma.imaster_proses_refor
			where ma.lDeleted=0 and m.lDeleted=0 and m.vkode_proses_refor="STBL")',NULL);
		$grid->setQuery('lokal_refor_skala_trial.ldeleted',0);
		$grid->setQuery('lokal_refor_skala_trial.iappd',2);
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
			default:
				$grid->render_grid();
				break;
		}
    }

	function output(){
    	$this->index($this->input->get('action'));
    }

    function get_details(){
    	$post=$this->input->post();
		$d['post']=$post;
    	$data['details']=$this->load->view('local/jqgrid/details_req_ujibe',$d,true);
    	return json_encode($data);
    }



    function download($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/reformulasi/local/request_refor/'.$id.'/'.$name);	
		force_download($name, $path);
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
						if (file_exists('./files/reformulasi/local/lokal/uji/be'.$k->iLocal_req_refor.'/'.$value)) {
							$link = base_url().'processor/reformulasi/lokal/req/ujibe/popup?action=download&id='.$k->iLocal_req_refor.'&file='.$value;
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
	function listBox_lokal_req_ujibe_browse_pilih($value, $pk, $name, $rowData) {
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
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_std_popup(\''.$pk.'\',\''.$dtrefor['iLocal_req_refor'].'\',\''.$dtrefor['vNo_req_refor'].'\',\''.$dtrefor['c_itnam'].'\',\''.$dtrefor['cInisiator'].'\',\''.$iAm['vdepartemen'].'\',\''.$dtrefor['vAlasan_refor'].'\',\''.$iteam[$dtrefor['iteam_pd']].'\',\''.$dtrefor['dRequest'].'\',\''.$iapp['vName'].'\',\''.$req['vName'].'\',\''.$rowData->vnoFormulasi.'\') ;" />';
		$o.='<script>
				function pilih_upb_std_popup(ilokal_refor_skala_trial,iLocal_req_refor,vNo_req_refor,cIteno,cInisiator,vdepartemen,vAlasan_refor,iteam_pd,dRequest,cApproval,cFormulator,vnoFormulasi){
					custom_confirm("Yakin ?", function(){
						$("#'.$this->input->get('field').'_ilokal_refor_skala_trial").val(ilokal_refor_skala_trial);
						$("#'.$this->input->get('field').'_vNo_req_refor_dis").val(vNo_req_refor);
						$("#'.$this->input->get('field').'_cIteno").val(cIteno);
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
							url: base_url+"processor/reformulasi/local_stabilita_lab_popup?action=get_details",
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
	/*	$sql="select * from reformulasi.local_req_refor r 
			join sales.itemas i on i.c_iteno = r.cIteno
			where r.iLocal_req_refor=".$id;
		$ret=$this->dbset->query($sql)->row_array();
		return $ret;
	} */

	    $sql="select r.*,t.vnoFormulasi,i.c_itnam from reformulasi.lokal_refor_skala_trial t
                        join reformulasi.local_req_refor r on r.iLocal_req_refor=t.iLocal_req_refor
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
