<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_req_prio extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth_export');
        $this->user = $this->auth_export->user();
        $this->arrEmployee = array(); 
        $this->arrEmployeeUpper = array();

		$this->_field = 'upb_set_prio';
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('Request Reformulasi Export');
        $grid->setTable('reformulasi.export_req_refor');   	
		$grid->setUrl('browse_req_prio');
		$grid->addList('pilih','vno_export_req_refor','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','dPermintaan_req_export'); 
        $grid->setSortBy('iexport_req_refor');
        $grid->setSortOrder('asc');  

		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setWidth('pilih', '55');
		$grid->setAlign('pilih', 'center');
		$grid->setSearch('dossier_upd.vNama_usulan','dossier_upd.vUpd_no','vno_export_req_refor','dPermintaan_req_export');

		$grid->setWidth('vno_export_req_refor', '150');
        $grid->setAlign('vno_export_req_refor', 'center');
        $grid->setLabel('vno_export_req_refor','No Request');
    
        $grid->setWidth('dossier_upd.vNama_usulan', '250');
        $grid->setAlign('dossier_upd.vNama_usulan', 'center');
        $grid->setLabel('dossier_upd.vNama_usulan','Nama Produk');

        $grid->setWidth('dossier_upd.vUpd_no', '100');
        $grid->setAlign('dossier_upd.vUpd_no', 'center');
        $grid->setLabel('dossier_upd.vUpd_no','No UPD');

        $grid->setWidth('dPermintaan_req_export', '150');
        $grid->setAlign('dPermintaan_req_export', 'center');
        $grid->setLabel('dPermintaan_req_export','Tgl Request');
        
        $grid->setAlign('pilih', 'center');
        $grid->changeSearch('dPermintaan_req_export','between');

        //Query PD
        if($this->auth_export->is_manager()){
            $x=$this->auth_export->dept();
            $manager=$x['manager'];
            if(in_array('PD', $manager)){
                $type='PD';
                $grid->setQuery('export_req_refor.iTeamPD IN ('.$this->auth_export->my_teams().')', null);
            }
            else{$type='';}
        }
        else{
            $x=$this->auth_export->dept();
            $team=$x['team'];
            if(in_array('PD', $team)){
                $type='PD';
                $grid->setQuery('export_req_refor.iTeamPD IN ('.$this->auth_export->my_teams().')', null);
            }
            else{$type='';}
        }


        
        $grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = export_req_refor.idossier_upd_id', 'inner');

        $grid->setQuery('export_req_refor.lDeleted',0);
        $grid->setQuery('export_req_refor.iConfirmPD = 2 ', null); 

        //$grid->setInputGet('_iexport_req_refor', $this->input->get('iexport_req_refor'));

        //$grid->setQuery('export_req_refor.iexport_req_refor not in ('.str_replace("_", ",", $this->input->get('_iexport_req_refor')).')', null);
        
        $grid->setSortOrder('DESC');  



		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;
            case 'dt_upload':
                $this->dt_upload();
                break;			
			default:
				$grid->render_grid();
				break;
		}
    }
    function _child ($nip){ 
        $sql = "SELECT cNip, vName 
                    FROM hrd.employee 
                    WHERE cUpper = '$nip' 
                    AND dresign = '0000-00-00'
                    ORDER BY vName ASC";
        $dt_cek = $this->db->query($sql)->result_array();     
        if(!empty($dt_cek)){ 
            foreach($dt_cek as $x){
                $isi['nip'] = $x['cNip'];
                $isi['name'] = $x['vName'];
                array_push($this->arrEmployee, $isi);
                $this->_child($x['cNip']);
            } 
        } 
    }

    function _upper ($nip){ 
        $sql = "SELECT cUpper, vName 
                    FROM hrd.employee a
                    join hrd.position b on b.iPostID=a.iPostID
                    WHERE a.cNip = '$nip' 
                    AND a.dresign = '0000-00-00'
                    and b.iLvlemp <= 6
                    ORDER BY vName ASC";
        $dt_cek = $this->db->query($sql)->result_array();     
        if(!empty($dt_cek)){ 
            foreach($dt_cek as $x){
                $isi['nip'] = $x['cUpper'];
                array_push($this->arrEmployeeUpper, $isi);
                $this->_upper($x['cUpper']);
            } 
        } 
    }

	function output(){
    	$this->index($this->input->get('action'));//test komen
    }

    function dt_upload(){
        $iexport_req_refor = $this->input->post('iexport_req_refor');
        $sq_all='SELECT * FROM reformulasi.`export_req_refor_file` lf WHERE lf.lDeleted = 0 AND 
                lf.iexport_req_refor = "'.$iexport_req_refor.'"'; 
        $data['sq_all'] = $this->db->query($sq_all)->result_array();  
        echo $this->load->view('local/lokal_skala_trial_ref_file',$data,TRUE);
    }

    
    function listBox_browse_req_prio_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_prio('.$pk.',\''.$rowData->vno_export_req_refor.'\',\''.$rowData->dossier_upd__vUpd_no.'\',\''.$rowData->dossier_upd__vNama_usulan.'\') ;" />
		<script type="text/javascript">
			var ix = "'.$this->input->get('index').'";
			function pilih_upb_prio (id, vno_export_req_refor, vUpd_no,vNama_usulan) {					
				custom_confirm("Yakin", function() {
                    $(".iexport_req_refori").eq(ix).prev().val(id);
					$(".iexport_req_refori").eq(ix).val(id);
					$(".upb_set_prio_iexport_req_refor").eq(ix).val(vno_export_req_refor);
                    $(".upb_set_prio_vUpd_no").eq(ix).text(vUpd_no);
                    $(".upb_set_prio_vNama_usulan").eq(ix).text(vNama_usulan);

                    $("#alert_dialog_form").dialog("close");
				});
			}
		</script>';
		return $o;
    }
    
	function listBox_browse_req_prio_pilihx($value, $pk, $name, $rowData) {
        //$url_ = base_url().'processor/reformulasi/browse/skala/trial?action=dt_upload';

        $pd = "SELECT r.vteam FROM reformulasi.`reformulasi_team` r WHERE r.ldeleted=0 AND r.ireformulasi_team= '".$rowData->iTeamPD."'";
        $c_pd = $this->db->Query($pd)->row_array();
        if(empty($c_pd['vteam'])){
            $c_pd['vteam'] = '-';
        }

        $ad = "SELECT r.vteam FROM reformulasi.`reformulasi_team` r WHERE r.ldeleted=0 AND r.ireformulasi_team= '".$rowData->iTeamAndev."'";
        $c_ad = $this->db->Query($ad)->row_array();
        if(empty($c_ad['vteam'])){
            $c_ad['vteam'] = '-';
        }


        


		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail('.$pk.',\''.$rowData->vno_export_req_refor.'\',\''.$rowData->dossier_upd__vUpd_no.'\',\''.$rowData->dossier_upd__vNama_usulan.'\',\''.$c_pd['vteam'].'\',\''.$c_ad['vteam'].'\'
                ) ;" />
			  <script type="text/javascript">
				function pilih_upb_detail (id, vno_export_req_refor, dossier_upd_vUpd_no, dossier_upd_vNama_usulan,iTeamPD,iTeamAndev){					
					custom_confirm("Yakin ?", function(){
                            //alert(dossier_upd_vNama_usulan)
						$(".'.$this->input->get('field').'_vno_export_req_refor").val(vno_export_req_refor); 
                        $(".'.$this->input->get('field').'_iexport_req_refor").val(id); 
                        $(".'.$this->input->get('field').'_vUpd_no").text(dossier_upd_vUpd_no);  
                        $(".'.$this->input->get('field').'_vNama_usulan").text(dossier_upd_vNama_usulan);  
                        $(".'.$this->input->get('field').'_iTeamPD").text(iTeamPD);  
                        $(".'.$this->input->get('field').'_iTeamAndev").text(iTeamAndev);  
                        
                        

                        /*$.ajax({
                            url: "'.$url_.'",
                            type: "post",
                            data: {
                                    iexport_req_refor: id,
                                    field: "'.$this->input->get('field').'", 
                                },
                            success: function(data){
                                $(".'.$this->input->get('field').'_iupload_f").html(data);  
                            }
                        })*/
						$("#alert_dialog_form").dialog("destroy");
					});
				}
			  </script>';
		return $o;
	}
}
