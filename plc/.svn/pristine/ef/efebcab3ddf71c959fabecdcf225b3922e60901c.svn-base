<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class uji_mikro_fg_popup extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->_field = $this->input->get('field');
		$this->dbset = $this->load->database('plc0',false, true);
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List UPB');		
		$grid->setTable('plc2.plc2_upb_formula');		
		$grid->setUrl('uji_mikro_fg_popup');
		$grid->addList('pilih','formula.vNo_formula','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','plc2_upb.iteamqa_id','study_literatur_pd.ijenis_sediaan');
		$grid->setSortBy('plc2_upb.vupb_nomor');
		$grid->setSortOrder('DESC');
		$grid->setWidth('plc2_upb.vupb_nomor', '55');
		$grid->setWidth('plc2_upb.vupb_nama', '200');
		$grid->setWidth('plc2_upb.vgenerik', '200');
		$grid->setWidth('plc2_upb.iteamqa_id', '90');
		$grid->setWidth('study_literatur_pd.ijenis_sediaan', '90');
		$grid->setWidth('formula.vNo_formula', '90');
		$grid->setWidth('pilih', '25');

		$grid->setLabel('plc2_upb.vupb_nomor', 'Nomor UPB');
		$grid->setLabel('formula.vNo_formula', 'No Formula');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');				
		$grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');
		$grid->setLabel('plc2_upb.iteamqa_id', 'Team QA');
		$grid->setLabel('study_literatur_pd.ijenis_sediaan','Jenis Produk');

		$grid->setSearch('plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','plc2_upb.iteamqa_id');
		$grid->setAlign('vupb_nomor', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->setInputGet('ijenis',$this->input->get('ijenis'));
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setJoinTable('plc2.plc2_upb','plc2_upb_formula.iupb_id=plc2_upb.iupb_id','inner');
		$grid->setJoinTable('plc2.study_literatur_pd','study_literatur_pd.iupb_id=plc2_upb.iupb_id','inner');
		$grid->setJoinTable('pddetail.formula_process','formula_process.iFormula_process=plc2_upb_formula.iFormula_process','inner');
		$grid->setJoinTable('pddetail.formula','formula.iFormula_process=formula_process.iFormula_process','inner');

		$grid->setRelation('plc2.plc2_upb.iteamqa_id', 'plc2.plc2_upb_team', 'iteam_id', 'vteam','qaTeamName','inner',array('vtipe'=>'QA', 'ldeleted'=>0));
		$isedia=$_GET['ijenis'];
		$grid->setQuery('plc2_upb_formula.iupb_id in (select iupb_id from plc2.study_literatur_pd where ijenis_sediaan='.$isedia.')',NULL);
		$grid->setQuery('study_literatur_pd.iuji_mikro',1);
		$grid->setQuery('plc2_upb_formula.ifor_id not in (select fg.ifor_id from plc2.mikro_fg fg where fg.iappqa_uji !=1 and fg.lDeleted=0)',NULL);
		
		/*basic required start*/
			$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
			$grid->setQuery('plc2.plc2_upb.iKill', 0);
			$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
			$grid->setQuery('plc2_upb.ihold', 0);
		/*basic required finish*/

		//if($isedia==0){
			//$grid->setQuery('plc2_upb_formula.ifor_id in (select pi.ifor_id from plc2.plc2_upb_prodpilot pi where pi.ldeleted=0 and pi.iapppd_pp=2)',NULL);
		//}else 
		if($isedia==1){

			//$grid->setQuery('plc2_upb_formula.ilab_apppd',2);
			/*integrasi PD detail , status sudah skala lab ambil dari pd detail 20170510 by mansur*/
			$grid->setQuery('formula.iKeteranganTrial',1);
			$grid->setQuery('plc2_upb_formula.iFormula_process is not null',NULL);
				/*$grid->setQuery('plc2_upb.iupb_id in(
											select fp.iupb_id 
											from pddetail.formula f 
											join pddetail.formula_process fp on fp.iFormula_process=f.iFormula_process
											where f.lDeleted=0
											and fp.lDeleted=0
											and f.iFinishSkalaLab=1
											)
				',null);*/

		}

		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('QA', $manager)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('QA', $team)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;		
			case 'getnum':
				$iupb_id=$this->input->post('iupb_id');
				/*$sql="select count(ifor_id) as jml 
						from plc2.plc2_upb_formula fo
				 		where fo.ilab_apppd=2 AND fo.iupb_id=".$iupb_id;*/
				 $sql='select b.vNo_formula,b.iVersi,b.*,a.* 
						from pddetail.formula_process a 
						join pddetail.formula b on b.iFormula_process=a.iFormula_process
						where a.lDeleted=0
						and b.lDeleted=0
						and a.iupb_id="'.$iupb_id.'"
						and b.iFinishSkalaLab=1';
				//echo $sql;
				$count = $this->db_plc0->query($sql)->row_array();
				$data['status']=TRUE;
				/*$data['count']=$count['jml'];*/
				$data['vNo_formula']=$count['vNo_formula'];
				$data['iVersi']=$count['iVersi'];
				echo json_encode($data);
				exit();
				break;
			default:
				$grid->render_grid();
				break;
		}
    }

	function output(){
    	$this->index($this->input->get('action'));
    }

    function listBox_uji_mikro_fg_popup_study_literatur_pd_ijenis_sediaan($value){
    	if($value==0){$vstatus='Steril';}
		elseif($value==1){$vstatus='Non Steril';}
		else{$vstatus="-";}
		return $vstatus;
    }

	function listBox_uji_mikro_fg_popup_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" style="margin-bottom:0;vertical-align:middle;" name="pilih" onClick="javascript:pilih_upb_fst('.$pk.',\''.$rowData->vkode_surat.'\',\''.$rowData->iupb_id.'\',\''.$rowData->study_literatur_pd__ijenis_sediaan.'\',\''.$rowData->plc2_upb__vupb_nomor.'\',\''.$rowData->plc2_upb__vupb_nama.'\',\''.$rowData->plc2_upb__vgenerik.'\') ;" />
		<script type="text/javascript">
		function pilih_upb_fst (id, vkode_surat, iupb_id, ijenis, vupb_nomor, vupb_nama, vgenerik){
			var url = "'.base_url().'processor/plc/uji/mikro/fg/popup?action=getnum&ijenis="+ijenis;			
			custom_confirm("Yakin ?", function(){
				var itrial_uji = 0;
				$.ajax({
					url: url,
					type: "post",
					data: "iupb_id="+iupb_id,
					success: function(data) {
						var o = $.parseJSON(data);
						itrial_uji=o.iVersi;
						vNo_formula=o.vNo_formula;
						$("#'.$this->input->get('field').'_ifor_id").val(id);
						$("#'.$this->input->get('field').'_ifor_id_dis").val(vNo_formula);
						$("#'.$this->input->get('field').'_iupb_id_dis").val(vupb_nomor);
						$("#'.$this->input->get('field').'_vupb_nama").val(vupb_nama);
						$("#'.$this->input->get('field').'_vgenerik").val(vgenerik);
						$("#'.$this->input->get('field').'_itrial_uji").val(itrial_uji);
						$("#alert_dialog_form").dialog("close");
					}		
				});	
			});
		}
		</script>';
		return $o;
	}
}
