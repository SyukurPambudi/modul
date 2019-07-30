<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Partial_view extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		/*$this->dbset = $this->load->database('dosier', true);
		$this->dbset2 = $this->load->database('hrd', true);*/
		$this->load->library('lib_plc');
		$this->user = $this->auth->user();
    }

    function index($action = '') {
    	$action = $this->input->get('action');

    	switch ($action) {
			case 'getreviewdokumen':
				echo $this->getreviewdokumen();
				break;
			case 'gethistorytd':
				echo $this->gethistorytd();
				break;
			case 'getdokwithkat':
				echo $this->getdokwithkat();
				break;
			case 'gettestpaneloptpd':
				echo $this->gettestpaneloptpd();
				break;
			case 'gettestpaneloptbd':
				echo $this->gettestpaneloptbd();
				break;
			case 'getupidokbb':
				echo $this->getupidokbb();
				break;
			case 'getupidoksm':
				echo $this->getupidoksm();
				break;
			case 'gethistdatatamb':
				echo $this->gethistdatatamb();
				break;
			case 'getModulfromFlow':
				echo $this->getModulfromFlow();
				break;
			default:
				echo $this->getreviewdokumen();
				break;
		}

    }


    function getUPB($iupb_id){
    	$sql = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$iupb_id.'" ';
    	$data = $this->db->query($sql)->row_array();
    	return $data;

    }
    function getModulfromFlow(){
    	$iupb_id = $_POST['iupb_id'];
    	$upbTeam = $this->lib_plc->upbTeam($iupb_id);
    	$dUPB = $this->getUPB($iupb_id);


    	$sqlMods = 'select * 
					from plc3.m_flow_proses a
					join plc3.m_flow b on b.iM_flow=a.iM_flow
					join plc3.m_modul c on c.iM_modul=a.iM_modul
					where a.lDeleted=0
					and b.lDeleted=0
					and c.lDeleted=0
					order by a.iUrut
					';
		$dModuls = $this->db->query($sqlMods)->result_array();

		$data['dModuls'] = $dModuls;

		return $this->load->view('manual/tracking_upb_result',$data);



    }

	function gettestpaneloptpd(){
		$iteampd_id=$_POST['iteampd_id'];
		$o  = "<select name='cNip_kirim' id='product_trial_test_panel_cNip_kirim' class='required'>";
        $o .= "<option value=''>Pilih</option>";
        $sql = "select a.vnip,b.vName 
				from plc2.plc2_upb_team_item a 
				join hrd.employee b on a.vnip=b.cNip
				where a.ldeleted=0
				and a.iteam_id='".$iteampd_id."'
				order by b.vName";
        $query = $this->dbset->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            foreach($result as $row) {
                   if ($id == $row['vnip']) $selected = " selected";
                   else $selected = '';
                   $o .= "<option {$selected}  value='".$row['vnip']."'>".$row['vName']."</option>";
            }
        }
        $o .= "</select>";
        
        return $o;


	}

	function gettestpaneloptbd(){
		$iteambd_id=$_POST['iteambusdev_id'];
		$o  = "<select name='cNip_kirim' id='product_trial_test_panel_cNip_kirim' class='required'>";
        $o .= "<option value=''>Pilih</option>";
        $sql = "select a.vnip,b.vName 
				from plc2.plc2_upb_team_item a 
				join hrd.employee b on a.vnip=b.cNip
				where a.ldeleted=0
				and a.iteam_id='".$iteambd_id."'
				order by b.vName";
        $query = $this->dbset->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            foreach($result as $row) {
                   if ($id == $row['vnip']) $selected = " selected";
                   else $selected = '';
                   $o .= "<option {$selected}  value='".$row['vnip']."'>".$row['vName']."</option>";
            }
        }
        $o .= "</select>";
        
        return $o;


	}

	function getupidokbb() {
		$iupi_id=$_POST['iupi_id'];
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$iupi_id,'ldeleted'=>0))->row_array();
		$this->db_plc0->where('ldeleted', 0);
		$this->db_plc0->order_by('vdokumen', 'ASC');
		$data['docs'] = $this->db_plc0->get('plc2.plc2_upb_master_dokumen_bb')->result_array();
		$data['isi'] = $rows['txtDocBB'];
		return $this->load->view('import/prareg_upi_dokumen_bb_edit',$data,TRUE);
		//return $x;
	}

	function getupidoksm() {
		$iupi_id=$_POST['iupi_id'];
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$iupi_id,'ldeleted'=>0))->row_array();

		$this->db_plc0->where('ldeleted', 0);
		$this->db_plc0->order_by('vdokumen', 'ASC');
		$data['isi'] = $rows['txtDocSM'];
		$data['docs'] = $this->db_plc0->get('plc2.plc2_upb_master_dokumen_sm')->result_array();
		return $this->load->view('import/prareg_upi_dokumen_sm_edit',$data,TRUE);

	}

	function gethistdatatamb() {
		$sql_dtapp = 'select a.vNo_request,b.vNama_dokumen,b.dTgl_td,b.eStatus,
					a.* 
					from plc2.upi_dok_td a 
					join plc2.upi_dok_td_detail b on b.iupi_dok_td_id=a.iupi_dok_td_id
					where a.lDeleted=0
					and b.lDeleted=0
					and a.iupi_id = "'.$_POST['iupi_id'].'"';
		$rows = $this->db_plc0->query($sql_dtapp)->result_array();
		$data['rows'] = $rows;
		return $this->load->view('import/import_tambahan_data_history',$data,TRUE);

	}



	
	public function output(){
		$this->index($this->input->get('action'));
	}

}

