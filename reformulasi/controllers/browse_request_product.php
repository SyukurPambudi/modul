<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_request_product extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth_localnon');
		$this->_field = $this->input->get('field');
		$this->_irefor = $this->input->get('irefor');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List Formula');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('browse_request_product');
		$grid->addList('pilih','vnomorusulan','namaUsulan');
		$grid->setSortBy('vnomorusulan');
		$grid->setSortOrder('DESC');
		$grid->setWidth('vnomorusulan', '100');
		$grid->setWidth('namaUsulan', '300');
		$grid->setWidth('dInput', '100');
		$grid->setWidth('pilih', '25');
		$grid->setLabel('vnomorusulan', 'No. Usulan');
		$grid->setLabel('namaUsulan', 'Nama Usulan');
		$grid->setLabel('dInput', 'Tanggal Usulan');
		$grid->setSearch('vnomorusulan','namaUsulan');
		$grid->setAlign('vnomorusulan', 'center');
		$grid->setAlign('dInput', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->setInputGet('irefor',$this->_irefor);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$teamPD="";
		//$grid->setQuery('pk not in (select f.pk from plc2.plc2_upb_spesifikasi_fg f where f.itype=1)',null);
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				//$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
				$teamPD='AND b.iteampd_id IN ('.$this->auth_localnon->my_teams().')';
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){
				$type='PD';
				//$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
				$teamPD='AND b.iteampd_id IN ('.$this->auth_localnon->my_teams().')';
			}
			else{$type='';}
		}

			$grid ->setSql("
				

				select z.pk,z.vnomorusulan,z.namaUsulan, z.iKey ,z.lDeleted,z.iteampd_id 
				from (
					select a.idossier_upd_id as pk,a.vUpd_no as vnomorusulan , a.vNama_usulan as namaUsulan , '2' as iKey 
					,a.lDeleted,100 as iteampd_id
					from dossier.dossier_upd a 
					where a.lDeleted=0
					and a.ihold=0
					#sudah approve review dokumen
					and a.idossier_upd_id in (
						select a2.idossier_upd_id from dossier.dossier_review a1
						join dossier.dossier_upd a2 on a2.idossier_upd_id=a1.idossier_upd_id
						where a1.lDeleted=0
						and a2.lDeleted=0
						and a1.iApprove_review=2
					)

					#upd tidak bisa dipilih lagi 
					and a.idossier_upd_id not in(

						select ax.iNo_usulan 
						from plc2.req_refor ax 
						where ax.lDeleted=0 and ax.iStatus in (0,2)
					)


						union 
					select b.iupb_id as pk ,b.vupb_nomor as vnomorusulan, b.vupb_nama as namaUsulan , '1' as iKey 
					, b.lDeleted,b.iteampd_id
					from plc2.plc2_upb b 
					where b.lDeleted=0
					and b.ihold=0 and b.itipe_id not in (6) and b.iKill=0
					#sudah ada tgl Nie
					and b.vnie <> ''
					and b.ttarget_noreg is not null
					".$teamPD."
					#upd tidak bisa dipilih lagi 
					
					and b.iupb_id not in (

						select ax.iNo_usulan 
						from plc2.req_refor ax 
						where ax.lDeleted=0 and ax.iStatus in (0,2)
					)


				) as z
				
				 "); 

		$getvnomorusulan='';	
		$getvnamaUsulann='';	
		if(isset($_GET['vnomorusulan'])){
			$getvnomorusulan=$_GET['vnomorusulan'];
		}
		if(isset($_GET['namaUsulan'])){
			$getvnamaUsulann=$_GET['namaUsulan'];
		}
		$grid ->setSqlCond(" WHERE z.lDeleted=0 and z.vnomorusulan like '%".$getvnomorusulan."%' and z.namaUsulan like '%".$getvnamaUsulann."%'"); 	

		$grid ->setSqlOrder(" GROUP BY z.vnomorusulan
								ORDER BY z.vnomorusulan asc
								");

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
    	$this->index($this->input->get('action'));
    }

	function listBox_browse_request_product_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_std_popup(\''.$rowData->pk.'\',\''.$rowData->vnomorusulan.'\',\''.$rowData->iKey.'\',\''.$rowData->namaUsulan.'\',\''.$rowData->dInput.'\') ;" />';
		$o.='<script>
				function pilih_upb_std_popup(pk,vnomorusulan,iKey,namaUsulan,dInput){
					custom_confirm("Yakin ?", function(){
						$("#'.$this->input->get('field').'_iNo_usulan").val(pk);
						$("#'.$this->input->get('field').'_iNo_usulan_dis").val(vnomorusulan+" - "+namaUsulan );
						$("#'.$this->input->get('field').'_iKey").val(iKey);
						if(iKey==1){
							$("#'.$this->input->get('field').'_iKey_dis").val("Refor Local");
						}else{
							$("#'.$this->input->get('field').'_iKey_dis").val("Refor Export");
						}
						$("#alert_dialog_form").dialog("close");
					});
				}
			</script>';
		return $o;
	}
}
