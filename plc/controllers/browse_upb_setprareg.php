<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Browse_upb_setprareg extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List UPB');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('browse_upb_setprareg');
		$grid->addList('pilih','vupb_nomor','vupb_nama','vgenerik','ttanggal','ikategoriupb_id','iteambusdev_id');
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
		$grid->setSearch('vupb_nomor','vupb_nama','vgenerik','iteambusdev_id','ttanggal');
		$grid->setAlign('vupb_nomor', 'center');
		$grid->setAlign('pilih', 'center');
		$grid->setRelation('iteambusdev_id', 'plc2.plc2_upb_team', 'iteam_id', 'vteam','bdTeamName','inner');
		$grid->setRelation('ikategoriupb_id', 'plc2.plc2_upb_master_kategori_upb', 'ikategori_id', 'vkategori','katUpb','inner');
		
		$grid->setQuery('iappbusdev', 2); // upb yg bisa dipilih hanya upb yg sudah di app busdev
		
		$grid->setQuery('(`iappdireksi` not in (1) or `iappdireksi` is null)',NULL); // upb yg bisa dipilih hanya upb yg sudah di app busdev

		/*basic required start*/
			$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
			$grid->setQuery('plc2.plc2_upb.iKill', 0);
			$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
			$grid->setQuery('plc2_upb.ihold', 0);
		/*basic required finish*/
		
		$grid->changeSearch('ttanggal','between');
		//upb yg sudah ada...
		$grid->setInputGet('_iupb_id', $this->input->get('iupb_id'));
		$grid->setQuery('plc2.plc2_upb.iupb_id not in ('.str_replace("_", ",", $this->input->get('_iupb_id')).')', null);

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

    function searchBox_browse_upb_setprareg_iteambusdev_id($rowData, $id) {
        $teams = $this->db_plc0->get_where('plc2.plc2_upb_team', array('ldeleted' => 0,'vtipe' => 'BD','iTipe' => 1))->result_array();
        $o = '<select id="'.$id.'">';
        $o .= '<option value="">--Select--</option>';
        foreach ($teams as $t) {
            $o .= '<option value="'.$t['iteam_id'].'">'.$t['vteam'].'</option>';
        }
        $o .= '</select>';
        return $o;
	}
	
	

	function listBox_browse_upb_setprareg_pilih($value, $pk, $name, $rowData) {
		$url_header = base_url()."processor/plc/partial/view?action=getdetil"; 
		$sqlBB = 'select * 
				from plc3.m_flow_proses a 
				join plc3.m_modul b on b.iM_modul=a.iM_modul
				where a.lDeleted=0
				and b.lDeleted=0
				and a.iM_flow=1
				and b.vCodeModule="3.25.0.0_v3_terima_sample_bb" ';
		$dBB = $this->db->query($sqlBB)->row_array();

		$urutan = 70;
		if(!empty($dBB)){
			$urutan = $dBB['iUrut'];			
		}

				
		$this->load->library('lib_plc');
		$lastModul = $this->lib_plc->getCurrent_modul($pk);


		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_prio('.$pk.',\''.$rowData->vupb_nomor.'\',\''.$rowData->vgenerik.'\',\''.$rowData->katUpb.'\',\''.$lastModul['vNama_modul'].'\',\''.$lastModul['iUrut'].'\',\''.$rowData->iteamqa_id.'\',\''.$rowData->iteammarketing_id.'\') ;" />
		<script type="text/javascript">
			var ix = "'.$this->input->get('index').'";
			function pilih_upb_prio (id, vupb_nomor, vgenerik, ikategoriupb_id,vNama_modul,iUrut,iteamqa_id,iteammarketing_id) {				
				custom_confirm("Yakin", function() {
					$(".upb_set_prio_upb_id").eq(ix).val(id);
					$(".upb_idi").eq(ix).val(id);
					
					$(".upb_set_prio_upbno").eq(ix).val(vupb_nomor);
					$(".upb_set_prio_generik").eq(ix).text(vgenerik);
					$(".upb_set_prio_generik").eq(ix).parent().next().next().next().next().next().text(vNama_modul);
					$(".upb_set_prio_generik").eq(ix).parent().next().next().next().find("select").val(iteamqa_id);
					$(".upb_set_prio_generik").eq(ix).parent().next().next().next().next().find("select").val(iteammarketing_id);

					//$(".last_modul").eq(ix).text(vNama_modul);
					//$(".iUrut").eq(ix).val(iUrut);
					
					$(".btn_browse_upb_detail").eq(ix).show();
					var btDetail = $(".btn_browse_upb_detail").eq(ix);
					btDetail.show();

					var onbtDetail = btDetail.attr("onclick");
					//alert(onbtDetail);

					var onbtDetailNew = onbtDetail.replace(/GANTI_UPB/g, id);
					
					//alert(onbtDetailNew);
					btDetail.attr("onclick",onbtDetailNew)

					$(".btn_browse_upb").eq(ix).hide();

					$("#alert_dialog_form").dialog("close");
				});
			}
		</script>';
		//'.$pk.','.$rowData->cNamaSup.'
		return $o;
	}
}
