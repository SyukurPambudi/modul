<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class pk_busdevI extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
		$this->db_erp_pk = $this->load->database('pk', false,true);
		$this->load->library('lib_utilitas');
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;

		$grid->setTitle('PK Busdev 1');		
		$grid->setTable('plc2.pk_master');		
		$grid->setUrl('pk_busdevI');
		$grid->addList('tgl_penilaian','periode');
		$grid->addFields('lblIntro','lblpro','lbldes','tgl_penilaian');
		$grid->setLabel('tgl_penilaian','Tanggal Penilaian');
		$grid->setLabel('Periode','Periode Penilaian');
		$grid->setLabel('lblIntro','');
		$grid->setLabel('lbldes','');
		$grid->setLabel('lblpro','formulir');

		$grid->setSortBy('tgl_penilaian');
		$grid->setSortOrder('DESC');

		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				echo $grid->saved_form();
				break;
			case 'download':
				$this->download($this->input->get('file'));
				break;
			case 'delete':
				echo $grid->delete_row();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'getspname':
				echo $this->getSpname();
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
					echo $grid->updated_form();
				break;
			case 'approve':
				echo $this->approve_view();
				break;
			case 'approve_process':
				echo $this->approve_process();
				break;
			case 'reject':
				echo $this->reject_view();
				break;
			case 'reject_process':
				echo $this->reject_process();
				break;
			case 'getemployee':
				echo $this->getEmployee();
				break;
			default:
				$grid->render_grid();
				break;
		}
    }
/*Maniupulasi Gird end*/
	function listBox_cek_dokumen_registrasi_iconfirm_registrasi($value) {
		if($value==0){$vstatus='Waiting for approval';}
		elseif($value==1){$vstatus='Rejected';}
		elseif($value==2){$vstatus='Approved';}
		return $vstatus;
	}
	function listBox_Action($row, $actions) {
		//print_r($row);
	    if($row->iconfirm_registrasi<>0){
	    	unset($actions['edit']);
	    	unset($actions['delete']);
	    }
	    return $actions; 

	}

/*manipulasi view object form start*/
 	function insertBox_pk_busdevI_lblIntro($field, $id){
 		$return=$this->load->view('create_master_pk_busdevI');
		return $return;
	}
	function insertBox_pk_busdevI_lblpro($field, $id){
 		$return = '<script>
			$("label[for=\''.$id.'\']").css({"border": "1px solid #dddddd", "background": "#548cb6", "border-collapse": "collapse","width":"99%","font-weight":"bold","color":"#ffffff","text-shadow": "0 1px 1px rgba(0, 0, 0, 0.3)","text-transform": "uppercase"});
		</script>';
		return $return;
	}
	function insertBox_pk_busdevI_lbldes($field,$id){
		$sql="select em.cNip,em.vName,de.vDescription as departement,di.vDescription as division,po.vDescription as jabatan,em.dRealIn as masuk from hrd.employee em
			inner join hrd.departement de on de.iDeptID=em.iDeptID
			inner join hrd.division di on em.iDivID=di.iDivID
			inner join hrd.position po on po.iPostId=em.iPostID
			Where em.cNip='".$this->user->gNIP."'";
		$data['rows'] = $this->db->query($sql)->result_array();
		$data['id']=$id;
		$return=$this->load->view('details_employee',$data);
		return $return;
	}
/*manipulasi view object form end*/

/*manipulasi proses object form start*/
	function manipulate_update_button($buttons, $rowData){
		
	}
   
/*manipulasi proses object form end*/    



/*function pendukung end*/    	
public function output(){
		$this->index($this->input->get('action'));
	}

}
