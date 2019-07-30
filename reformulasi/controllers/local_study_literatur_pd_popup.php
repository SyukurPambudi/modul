<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class local_study_literatur_pd_popup extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth_local');
		$this->_field = $this->input->get('field');
		$this->user = $this->auth_local->user();
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List Formula');		
		$grid->setTable('reformulasi.local_req_refor');		
		$grid->setUrl('local_study_literatur_pd_popup');
		//$grid->addList('pilih','vNo_req_refor','itemas.c_itnam','vBatch_no');
		$grid->addList('pilih','vNo_req_refor','itemas.c_itnam');
		$grid->setSortBy('vNo_req_refor');
		$grid->setSortOrder('DESC');
		$grid->setWidth('vNo_req_refor', '100');
		$grid->setWidth('itemas.c_itnam', '300');
		$grid->setWidth('vBatch_no', '100');
		$grid->setWidth('pilih', '25');
		$grid->setLabel('vNo_req_refor', 'No Request');
		$grid->setLabel('itemas.c_itnam', 'Nama Produk');
		$grid->setLabel('vBatch_no', 'No Batch');
		$grid->setSearch('vNo_req_refor','itemas.c_itnam');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setJoinTable('sales.itemas', 'itemas.c_iteno = reformulasi.local_req_refor.cIteno', 'inner');
		$grid->setQuery('local_req_refor.iLocal_req_refor IN (select ma.iLocal_req_refor from reformulasi.lokal_mapping_refor ma
			join reformulasi.master_proses_refor m on m.imaster_proses_refor=ma.imaster_proses_refor
			where ma.lDeleted=0 and m.lDeleted=0 and m.vkode_proses_refor="STUL")',NULL);
		$grid->setQuery('local_req_refor.iLocal_req_refor NOT IN (select m.iLocal_req_refor from reformulasi.lokal_refor_study_literatur_pd m where m.ldeleted=0)',NULL);
		$grid->setQuery('local_req_refor.lDeleted',0);
		$grid->setQuery('local_req_refor.cFormulator in ("'.$this->user->gNIP.'")',NULL);
		if($this->auth_local->is_manager()){
            $x=$this->auth_local->dept();
            $manager=$x['manager'];
            if(in_array('PD', $manager)){
                $type='PD';
                $grid->setQuery('local_req_refor.iteam_pd IN ('.$this->auth_local->my_teams().')', null); 
            }
            else{$type='';}
        }
        else{
            $x=$this->auth_local->dept();
            $team=$x['team'];
            if(in_array('PD', $team)){
                $type='PD';
                $grid->setQuery('local_req_refor.iteam_pd IN ('.$this->auth_local->my_teams().')', null); 
            }
            else{$type='';}
        }

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
		$d['nmTable']="tb_req_refor_study";
		$d['pager']="pager_tb_req_refor_study";
		$d['caption'] = "List File Request Refor";
    	$data['details']=$this->load->view('local/jqgrid/details_req_study',$d,true);
    	return json_encode($data);
    }

    function getdetailsMR(){
    	$post=$this->input->get();
		$sql_data='select * from reformulasi.local_req_refor_file f where f.lDeleted=0 and f.iLocal_req_refor='.$post['id'];
		//echo $sql_data;
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
							$link = base_url().'processor/reformulasi/local/study/literatur/pd/popup?action=download&id='.$k->iLocal_req_refor.'&file='.$value;
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

	function listBox_local_study_literatur_pd_popup_pilih($value, $pk, $name, $rowData) {
		$iAm['vdepartemen']="-";
		$iapp['vName']="-";
		$req['vName']="-";
		if($rowData->cInisiator!=""){
			$iAm = $this->whoAmI($rowData->cInisiator);
		}
		if($rowData->cApproval!=""){
			$iapp = $this->whoAmI($rowData->cApproval);
		}
		if($rowData->cFormulator!=""){
			$req = $this->whoAmI($rowData->cFormulator);
		}
		$iteam=array(0=>"NULL",1=>"Gunung Putri",2=>"Ulujami PD",3=>"Etercon");
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_std_popup(\''.$pk.'\',\''.$rowData->vNo_req_refor.'\',\''.$rowData->itemas__c_itnam.'\',\''.$rowData->vBatch_no.'\',\''.$rowData->cInisiator.'\',\''.$iAm['vdepartemen'].'\',\''.$rowData->vAlasan_refor.'\',\''.$iteam[$rowData->iteam_pd].'\',\''.$rowData->dRequest.'\',\''.$iapp['vName'].'\',\''.$req['vName'].'\') ;" />';
		$o.='<script>
				function pilih_upb_std_popup(iLocal_req_refor,vNo_req_refor,cIteno,vBatch_no,cInisiator,vdepartemen,vAlasan_refor,iteam_pd,dRequest,cApproval,cFormulator){
					custom_confirm("Yakin ?", function(){
						$("#'.$this->input->get('field').'_iLocal_req_refor").val(iLocal_req_refor);
						$("#'.$this->input->get('field').'_vNo_req_refor_dis").val(vNo_req_refor);
						$("#'.$this->input->get('field').'_cIteno").val(cIteno);
						//$("#'.$this->input->get('field').'_vBatch_no").val(vBatch_no);
						$("#'.$this->input->get('field').'_cInisiator").val(cInisiator);
						$("#'.$this->input->get('field').'_idept_id").val(vdepartemen);
						$("#'.$this->input->get('field').'_iteam_pd").val(iteam_pd);
						$("#'.$this->input->get('field').'_vAlasan_refor").text(vAlasan_refor);
						$("#'.$this->input->get('field').'_dRequest").val(dRequest);
						$("#'.$this->input->get('field').'_cApproval").val(cApproval);
						$("#'.$this->input->get('field').'_cFormulator").val(cFormulator);
						/*Untuk Me Load Details Upload Request Refor*/
						$.ajax({
							url: base_url+"processor/reformulasi/local_study_literatur_pd_popup?action=get_details",
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
