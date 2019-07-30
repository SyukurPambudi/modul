<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class master_dokumen extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->db_plc0 = $this->load->database('brosur0',false, true);
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Master Dokumen ERP Core');	
		$grid->setTable('erp_privi.sys_masterdok');		
		$grid->setUrl('master_dokumen');
		$grid->addList('filename','modulename','labelform','filepath','note','ldeleted');
		$grid->setSortBy('filename');
        $grid->setSortOrder('DESC');
        $grid->setLabel('filename', 'File Kode');
        $grid->addFields('filename','iApplication','iModuleApplication','iM_modul_fields','modulename','labelform','filepath','note');
        $grid->setRequired('filename','iApplication','iModuleApplication','iM_modul_fields','modulename','labelform','filepath','note');
		$grid->setFormUpload(TRUE);
        $grid->setLabel('iApplication', 'Aplikasi');
        $grid->setLabel('iModuleApplication', 'Module');
        $grid->setLabel('iM_modul_fields', 'Field');
        $grid->setLabel('modulename', 'Nama Module');
        $grid->setLabel('labelform', 'Form Label');
        $grid->setLabel('filepath', 'File Path');
        $grid->setLabel('note', 'Note');
		
		//$grid->setJoinTable('plc2.plc2_upb', 'master_dokumen.iupb_id = plc2.plc2_upb.iupb_id', 'inner');
		$grid->changeFieldType('ldeleted','combobox','',array(''=>'-- Pilih --',0=>'Aktive',1=>'Deleted'));
		$grid->setSearch('filename','modulename','ldeleted');
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
            case 'getModul':
                    $this->db_plc0->where("iM_application",$this->input->post("id"));
                    $row=$this->db_plc0->get('erp_privi.m_modul')->result_array();
                    $o='<select name="master_dokumen_iModuleApplication" id="master_dokumen_iModuleApplication" class="required" >';
                    $o.='<option value="">----Pilih---</option>';
                    foreach ($row as $kr => $vr) {
                        $o.='<option value="'.$vr['iM_modul'].'">'.$vr['vKode_modul'].' - '.$vr['vDesciption'].'</option>';
                    }
                    $o.='</select>';
                    $o.='<script>
                    $("#master_dokumen_iModuleApplication").change(function(){
                        $.ajax({
                            url: base_url+"processor/brosur/master/dokumen?action=getField",
                            type: "post",
                            data: "id="+$(this).val(),
                            success: function(data) {
                                $("#div_master_dokumen_iM_modul_fields").html(data);
                            }
                        });
                    });
                    </script>';
                    echo $o;
                break;
            case 'getField':
                $this->db_plc0->where("iM_modul",$this->input->post("id"));
                $this->db_plc0->where("iM_jenis_field",16);
                $row=$this->db_plc0->get('erp_privi.m_modul_fields')->result_array();
                $o='<select name="master_dokumen_iM_modul_fields" id="master_dokumen_iM_modul_fields" class="required" >';
                $o.='<option value="">----Pilih---</option>';
                foreach ($row as $kr => $vr) {
                    $o.='<option value="'.$vr['iM_modul_fields'].'">'.$vr['vNama_field'].'</option>';
                }
                $o.='</select>';
                echo $o;
            break;
			default:
				$grid->render_grid();
				break;
		}
    }

    /*Maniupulasi Gird Start*/


/*Maniupulasi Grid end*/
function listBox_master_dokumen_cPIC($value) {
	$data='-';
	$sql='select em.cNip as cNip, em.vName as vName from hrd.employee em where em.cNip="'.$value.'" LIMIT 1';
	$dt=$this->db_plc0->query($sql)->row_array();
	if($dt){
		$data=$dt['cNip'].' - '.$dt['vName'];
	}
	return $data;
}
function listBox_Action($row, $actions) {
    return $actions; 
}
/*manipulasi view object form start*/
 	
 	function insertBox_master_dokumen_iApplication($field, $id) {
        $row=$this->db_plc0->get('erp_privi.m_application')->result_array();
        $o='<select name="'.$id.'" id="'.$id.'" class="required" >';
        $o.='<option value="">----Pilih---</option>';
        foreach ($row as $kr => $vr) {
            $o.='<option value="'.$vr['iM_application'].'">'.$vr['vDesciption'].'</option>';
        }
        $o.='</select>';
        $o.='<script>
        $("#'.$id.'").change(function(){
            $.ajax({
                url: base_url+"processor/brosur/master/dokumen?action=getModul",
                type: "post",
                data: "id="+$(this).val(),
                success: function(data) {
                    $("#div_master_dokumen_iModuleApplication").html(data);
                }
            });
        });
        </script>';
    	return $o;
    }
    function insertBox_master_dokumen_iModuleApplication($field, $id) {
        $o='<div id="div_master_dokumen_iModuleApplication"><select name="'.$id.'" id="'.$id.'" class="required" >';
        $o.='<option value="">----Pilih---</option>';
        $o.='</select>';
        $o.="</div>";
    	return $o;
    }
    function insertBox_master_dokumen_iM_modul_fields($field, $id) {
        $o='<div id="div_master_dokumen_iM_modul_fields"><select name="'.$id.'" id="'.$id.'" class="required" >';
        $o.='<option value="">----Pilih---</option>';
        $o.='</select>';
        $o.="</div>";
    	return $o;
    }

	function updateBox_master_dokumen_iupb_id($field, $id, $value, $rowData){
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nomor'];
		}else{
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="isdraft" id="isdraft">';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" value='.$value.' />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" value="'.$dt['vupb_nomor'].'" size="20" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/study/literatur/pd/popup?field=master_dokumen&modul_id='.$this->input->get('modul_id').'\',\'List UPB\')" type="button">&nbsp;</button>';
		}
		return $return;
	}
/*manipulasi view object form end*/

/*manipulasi proses object form start*/
    
/*manipulasi proses object form end*/    


/*Approval & Reject Proses */

	public function output(){
		$this->index($this->input->get('action'));
	}

}
