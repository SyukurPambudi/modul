<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class export_browse_draft_soi_bb extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth_export');
        $this->user = $this->auth_export->user();
        $this->arrEmployee = array(); 
        $this->arrEmployeeUpper = array();

		$this->_field = $this->input->get('field');
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List Batch');
        $grid->setTable('reformulasi.export_ro_detail');   	
		$grid->setUrl('export_browse_draft_soi_bb');
		//$grid->addList('pilih','vno_export_req_refor','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','dRequest'); 
        $grid->addList('pilih','export_ro.vRo_no','plc2_raw_material.vnama','export_req_refor.vno_export_req_refor','export_req_refor.iexport_req_refor','dossier_upd.vUpd_no','dossier_upd.vNama_usulan'); 
        //$grid->addList('pilih','export_ro.vRo_no','plc2_raw_material.vnama','export_req_refor.vno_export_req_refor'); 
        $grid->setSortBy('iexport_ro_detail');
        $grid->setSortOrder('asc');  

		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setWidth('pilih', '55');
		$grid->setAlign('pilih', 'center');
		//$grid->setSearch('dossier_upd.vNama_usulan','dossier_upd.vUpd_no','vno_export_req_refor');

		$grid->setWidth('plc2_raw_material.vnama', '200');
        $grid->setAlign('plc2_raw_material.vnama', 'left');
        $grid->setLabel('plc2_raw_material.vnama','Bahan Baku');

        $grid->setWidth('export_req_refor.vno_export_req_refor', '100');
        $grid->setAlign('export_req_refor.vno_export_req_refor', 'center');
        $grid->setLabel('export_req_refor.vno_export_req_refor','No Req. Refor');
        
        $grid->setWidth('export_req_refor.iexport_req_refor', '-10');

        

        $grid->setWidth('dossier_upd.vUpd_no', '100');
        $grid->setAlign('dossier_upd.vUpd_no', 'center');
        $grid->setLabel('dossier_upd.vUpd_no','No UPD');

        $grid->setWidth('dossier_upd.vNama_usulan', '350');
        $grid->setAlign('dossier_upd.vNama_usulan', 'left');
        $grid->setLabel('dossier_upd.vNama_usulan','Nama Usulan');

        $grid->setWidth('export_ro.vRo_no', '100');
        $grid->setAlign('export_ro.vRo_no', 'left');
        $grid->setLabel('export_ro.vRo_no','No Penerimaan');


        


    
       
        

        //$grid->setQuery('isubmit_maping',1);

        //Query PD
        /*if($this->auth_export->is_manager()){
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
        }*/


        $grid->setJoinTable('reformulasi.export_ro', 'export_ro.iexport_ro = export_ro_detail.iexport_ro', 'inner');
        $grid->setJoinTable('reformulasi.export_request_sample_detail', 'export_request_sample_detail.iexport_request_sample_detail = export_ro_detail.iexport_request_sample_detail', 'inner');
        $grid->setJoinTable('plc2.plc2_raw_material', 'plc2_raw_material.raw_id = export_request_sample_detail.raw_id', 'inner');
        $grid->setJoinTable('reformulasi.export_request_sample', 'export_request_sample.iexport_request_sample = export_request_sample_detail.iexport_request_sample', 'inner');
       
        $grid->setJoinTable('reformulasi.export_req_refor', 'export_req_refor.iexport_req_refor = export_request_sample.iexport_req_refor', 'inner');
        $grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = export_req_refor.idossier_upd_id', 'inner');

        //$grid->setRelation('ireformulasi_team','reformulasi.reformulasi_team','ireformulasi_team','vteam','vteam','inner',array('ldeleted'=>0,'iTipe'=>2,'cDeptId'=>5),array('vteam'=>'asc'));

        //$grid->setJoinTable('dossier.dossier_upd', 'dossier_upd.idossier_upd_id = export_req_refor.idossier_upd_id', 'inner');

        //$grid->setQuery('export_req_refor.lDeleted',0);
        
        // sudah selesai uji mikro 
        $grid->setQuery('export_request_sample_detail.iexport_request_sample_detail in (
                    select c.iexport_request_sample_detail 
                    from reformulasi.export_ro_detail_batch a 
                    join reformulasi.export_ro_detail b on b.iexport_ro_detail=a.iexport_ro_detail
                    join reformulasi.export_request_sample_detail c on c.iexport_request_sample_detail=b.iexport_request_sample_detail
                    where a.lDeleted=0 
                    and a.iHasil_analisa_bb=2
                    and b.lDeleted=0
                    and c.lDeleted=0



                ) ', null); 

        // belum pernah ada pada draft soi
        $grid->setQuery('export_ro_detail.iexport_ro_detail not in (
                            select a.iexport_ro_detail 
                            from reformulasi.export_draft_soi_bb a
                            where a.lDeleted=0

                        ) ', null);

        $grid->setSearch('export_ro.vRo_no','plc2_raw_material.vnama','export_req_refor.vno_export_req_refor','dossier_upd.vUpd_no','dossier_upd.vNama_usulan');
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
    /*function _child ($nip){ 
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
    }*/

	function output(){
    	$this->index($this->input->get('action'));//test komen
    }

    /*function dt_upload(){
        $iexport_ro_detail = $this->input->post('iexport_ro_detail');
        $sq_all='SELECT * FROM reformulasi.`export_req_refor_file` lf WHERE lf.lDeleted = 0 AND 
                lf.iexport_ro_detail = "'.$iexport_ro_detail.'"'; 
        $data['sq_all'] = $this->db->query($sq_all)->result_array();  
        echo $this->load->view('local/lokal_skala_trial_ref_file',$data,TRUE);
    }*/

    

	function listBox_export_browse_draft_soi_bb_pilih($value, $pk, $name, $rowData) {
        //print_r($rowData);
        //$url_ = base_url().'processor/reformulasi/browse/skala/trial?action=dt_upload';
        $sq = 'select * from reformulasi.export_req_refor a where a.iexport_req_refor =  "'.$rowData->export_req_refor__iexport_req_refor.'" ';
        $dsq = $this->db->query($sq)->row_array();
        if(empty($dsq['iTeamPD'])){
            $dsq['iTeamPD'] = '0';
        }


        $pd = "SELECT r.vteam FROM reformulasi.`reformulasi_team` r WHERE r.lDeleted=0 AND r.ireformulasi_team= '".$dsq['iTeamPD']."'";
        $c_pd = $this->db->Query($pd)->row_array();
        if(empty($c_pd['vteam'])){
            $c_pd['vteam'] = '-';
        }

        /*$pd = "SELECT r.vteam FROM reformulasi.`reformulasi_team` r WHERE r.ldeleted=0 AND r.ireformulasi_team= '".$dsq['iTeamPD']."'";
        $c_pd = $this->db->Query($pd)->row_array();
        if(empty($c_pd['vteam'])){
            $c_pd['vteam'] = '-';
        }*/

        $ad = "SELECT r.vteam FROM reformulasi.`reformulasi_team` r WHERE r.ldeleted=0 AND r.ireformulasi_team= '".$rowData->iTeamAndev."'";
        $c_ad = $this->db->Query($ad)->row_array();
        if(empty($c_ad['vteam'])){
            $c_ad['vteam'] = '-';
        }


        


		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_upb_detail('.$pk.',\''.$rowData->export_req_refor__vno_export_req_refor.'\',\''.$rowData->plc2_raw_material__vnama.'\',\''.$rowData->dossier_upd__vUpd_no.'\',\''.$rowData->dossier_upd__vNama_usulan.'\',\''.$c_pd['vteam'].'\'
                ) ;" />
			  <script type="text/javascript">
				function pilih_upb_detail (id, vno_export_req_refor, raw, dossier_upd_vUpd_no, dossier_upd_vNama_usulan,iTeamPD){					
					custom_confirm("Yakin ?", function(){
                            //alert(dossier_upd_vNama_usulan)
						$(".'.$this->input->get('field').'_vnama").val(raw); 
                        $(".'.$this->input->get('field').'_vno_export_req_refor").text(vno_export_req_refor); 
                        $(".'.$this->input->get('field').'_iexport_ro_detail").val(id); 
                        $(".'.$this->input->get('field').'_vUpd_no").text(dossier_upd_vUpd_no);  
                        $(".'.$this->input->get('field').'_vNama_usulan").text(dossier_upd_vNama_usulan);  
                        $(".'.$this->input->get('field').'_iTeamPD").text(iTeamPD);  
                        
                        
                        

                       
						$("#alert_dialog_form").dialog("destroy");
					});
				}
			  </script>';
		return $o;
	}
}
