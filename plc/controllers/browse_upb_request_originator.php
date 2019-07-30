<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Browse_upb_request_originator extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->_field = $this->input->get('field');
		$this->dbset = $this->load->database('plc', true);
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List UPB');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('browse_upb_request_originator');
		$grid->addList('vupb_nomor','vupb_nama','pilih');
		$grid->setSortBy('vupb_nomor');
		$grid->setSortOrder('DESC');
		$grid->setWidth('vupb_nomor', '55');
		$grid->setWidth('vupb_nama', '190');
		$grid->setWidth('vgenerik', '210');
		$grid->setWidth('iteambusdev_id', '80');
		$grid->setWidth('iteampd_id', '115');
		$grid->setWidth('ikategoriupb_id', '120');
		$grid->setWidth('ttanggal', '100');
		$grid->setWidth('pilih', '25');
		$grid->setLabel('vupb_nomor', 'No. UPB');
		$grid->setLabel('ikategoriupb_id', 'Kategori UPB');
		$grid->setLabel('vupb_nama', 'Nama Usulan');				
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('iteambusdev_id', 'Team Busdev');
		$grid->setLabel('iteampd_id', 'Team PD');
		$grid->setLabel('ttanggal', 'Tanggal UPB');
		$grid->setSearch('vupb_nomor','vupb_nama');
		$grid->setAlign('vupb_nomor', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');

		$grid->setInputGet('iTujuan_req', $this->input->get('iTujuan_req'));

		//$grid->setRelation('iteambusdev_id', 'plc2.plc2_div_team', 'idplc2_div_team', 'vName','bdTeamName','inner');

		// join table
	//	$grid->setJoinTable('plc2.plc2_upb_prioritas_detail', 'plc2_upb_prioritas_detail.iupb_id = plc2.plc2_upb.iupb_id', 'inner');
	//	$grid->setJoinTable('plc2.plc2_upb_prioritas', 'plc2_upb_prioritas.iprioritas_id = plc2.plc2_upb_prioritas_detail.iprioritas_id', 'inner');
		//$grid->setJoinTable('plc2.plc2_upb_request_originator', 'plc2_upb_request_originator.iupb_id = plc2.plc2_upb.iupb_id', 'inner');
		//$grid->setQuery('plc2_upb.iteampd_id ',$this->auth_localnon->myteam_item_id());

		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			
			else{$type='';}
		}

		
	//	$grid->setQuery('plc2_upb_prioritas.iappbusdev ',2);
	
		// upb sudah approve Daftar UPB or 
		$grid->setQuery('istatus = "7" ', null);
		//jenis kategori yang Non novell
		$grid->setQuery('vkat_originator = "3" ', null);
		/*basic required start*/
			$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
			$grid->setQuery('plc2.plc2_upb.iKill', 0);
			$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
			$grid->setQuery('plc2_upb.ihold', 0);
		/*basic required finish*/

		// berada pada flow tertentu
		//$grid->setQuery('master_flow_id in (2) ', null);

		// tidak boleh Request UPB yang masih aktif waiting  atau belum diterima 
		$grid->setQuery('plc2_upb.iupb_id not in (select  a.iupb_id from plc2.plc2_upb a 
																	join plc2.plc2_upb_request_originator b on a.iupb_id = b.iupb_id 
																   	where (b.iapppd=0 or b.isent_status=0 )
																   	and b.ldeleted=0
																	group by a.iupb_id) ',null);
		$grid->setQuery('plc2_upb.iupb_id not in (select  a.iupb_id from plc2.plc2_upb a 
																	join plc2.plc2_upb_request_originator b on a.iupb_id = b.iupb_id 
																	join plc2.plc2_upb_date_sample c on b.ireq_ori_id = c.iReq_ori_id
																   	where (b.iapppd=0 or b.isent_status=0 or c.dTanggalTerimaPD is null )
																   	and b.ldeleted=0
																	group by a.iupb_id) ',null);
		$iTujuan_req=$_GET['iTujuan_req'];
		if ($iTujuan_req==1) {
			// jika tujuannya sample , maka UPB harus belum melewati bahan kemas or study literatur PD or study literatur AD
			$grid->setQuery('plc2_upb.iupb_id not in(
				select a.iupb_id from plc2.study_literatur_pd a where a.lDeleted=0 
				union
				select b.iupb_id from plc2.study_literatur_ad b where b.lDeleted=0 
				union
				select c.iupb_id from plc2.plc2_upb_bahan_kemas c where c.ldeleted=0 

				)',null);
		}else if($iTujuan_req==2){

			// jika tujuannya pilot I

			//sudah lewat approve formula skala trial 
			/*$grid->setQuery('plc2_upb.iupb_id in(
					select a.iupb_id from plc2.plc2_upb_formula a where a.ldeleted=0 and a.iformula_apppd=2 and a.iwithori=1 )
				',null);

			// belum lewat di formula skala lab
			$grid->setQuery('plc2_upb.iupb_id not in(
					select a.iupb_id from plc2.plc2_upb_formula a where a.ldeleted=0 and a.ilab_apppd<>0 and a.iwithori=1)
				',null);*/

			/*integrasi PD detail by mansur 20170509*/

			$grid->setQuery('plc2_upb.iupb_id in(
											select fp.iupb_id 
											from pddetail.formula f 
											join pddetail.formula_process fp on fp.iFormula_process=f.iFormula_process
											where f.lDeleted=0
											and fp.lDeleted=0
											and f.iNextRegOriginator=1
											and f.iFinishRegOri=0
											and f.iFinishStresTest=1
												)
				',null);

			/*integrasi PD detail by mansur 20170509 end*/			

			

		}else{
			
			// untuk Resample *iTujuanreq 3
			/*// sudah basic formula 
			$grid->setQuery('plc2_upb.iupb_id in(
					select a.iupb_id from plc2.plc2_upb_formula a where a.ldeleted=0 and a.iapppd_basic=2 and a.iwithbasic=1 )
				',null);*/
			
			$grid->setQuery('plc2_upb.iupb_id in(
											select fp.iupb_id 
											from pddetail.formula f 
											join pddetail.formula_process fp on fp.iFormula_process=f.iFormula_process
											where f.lDeleted=0
											and fp.lDeleted=0
											and f.iBackSample=1
												)
				',null);
			
		}

		$grid->setGridView('grid');

		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			default:
				$grid->render_grid();
				break;
		}
    }

	function output(){
    	$this->index($this->input->get('action'));//test komen
    }

	function listBox_browse_upb_request_originator_pilih($value, $pk, $name, $rowData) {
		$url_header = base_url()."processor/plc/upb/request/originator/?action=gethistory"; 
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail('.$pk.',\''.$rowData->vupb_nomor.'\',\''.$rowData->vupb_nama.'\') ;" />
<script type="text/javascript">
		function pilih_upb_detail (id, vupb_nomor, vupb_nama){					
			custom_confirm("Yakin ?", function(){
				$("#'.$this->input->get('field').'_iupb_id").val(id);
				$("#'.$this->input->get('field').'_iupb_id_dis").val(vupb_nomor+" - "+vupb_nama);
				
				return $.ajax({
				url: "'.$url_header.'",
				type: "post",
				data: {
						upb_id: id,
						},
				beforeSend: function(){

				},
				success: function(data){
					$("#upb_request_originator_ireq_ke").html("");
					$("#history_req_originator").html(data);
					$("#alert_dialog_form").dialog("close");
				},
				}).responseText;

				$("#alert_dialog_form").dialog("close");
			});
		}
		</script>';
		return $o;
	}
}
