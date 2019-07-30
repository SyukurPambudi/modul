<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class export_browse_request_sample extends MX_Controller {
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
		$grid->setTitle('Request Reformulasi Export');
        $grid->setTable('reformulasi.export_req_refor');   	
		$grid->setUrl('export_browse_request_sample');
		$grid->addList('pilih','vno_export_req_refor','dossier_upd.vUpd_no','dossier_upd.vNama_usulan','dRequest'); 
        $grid->setSortBy('iexport_req_refor');
        $grid->setSortOrder('asc');  

		$grid->setAlign('pilih', 'center');
		$grid->setInputGet('field',$this->_field);
		$grid->hideTitleCol('pilih');
		$grid->notSortCol('pilih');
		$grid->setWidth('pilih', '55');
		$grid->setAlign('pilih', 'center');
		$grid->setSearch('dossier_upd.vNama_usulan','dossier_upd.vUpd_no','vno_export_req_refor');

		$grid->setWidth('vno_export_req_refor', '150');
        $grid->setAlign('vno_export_req_refor', 'center');
        $grid->setLabel('vno_export_req_refor','No Request');
    
        $grid->setWidth('vNo_deviasi', '100');
        $grid->setAlign('vNo_deviasi', 'left');
        $grid->setLabel('vNo_deviasi','No Deviasi');
    
        $grid->setWidth('iNo_usulan', '100');
        $grid->setAlign('iNo_usulan', 'left');
        $grid->setLabel('iNo_usulan','No Usulan Produk');
    
        $grid->setWidth('iKey', '100');
        $grid->setAlign('iKey', 'center');
        $grid->setLabel('iKey','Jenis Refor');
    
        $grid->setWidth('dossier_upd.vNama_usulan', '100');
        $grid->setAlign('dossier_upd.vNama_usulan', 'center');
        $grid->setLabel('dossier_upd.vNama_usulan','No Batch');

        $grid->setWidth('cIteno', '300');
        $grid->setAlign('cIteno', 'center');
        $grid->setLabel('cIteno','Nama Produk');
    
        $grid->setWidth('cInisiator', '200');
        $grid->setAlign('cInisiator', 'left');
        $grid->setLabel('cInisiator','Nama Inisiator');
    
        $grid->setWidth('idept_id', '100');
        $grid->setAlign('idept_id', 'left');
        $grid->setLabel('idept_id','Departement');
    
        $grid->setWidth('dRequest', '100');
        $grid->setAlign('dRequest', 'left');
        $grid->setLabel('dRequest','Tgl Request');
    
        $grid->setWidth('vAlasan_refor', '200');
        $grid->setAlign('vAlasan_refor', 'left');
        $grid->setLabel('vAlasan_refor','Alasan Refor');
    
        $grid->setWidth('iteam_pd', '100');
        $grid->setAlign('iteam_pd', 'left');
        $grid->setLabel('iteam_pd','Team PD');
    
        $grid->setWidth('iStatus', '100');
        $grid->setAlign('iStatus', 'center');
        $grid->setLabel('iStatus','Status Approval');
    
        $grid->setWidth('iSubmit', '100');
        $grid->setAlign('iSubmit', 'center');
        $grid->setLabel('iSubmit','Status Submit');

        $grid->setWidth('iStatus_proses', '200');
        $grid->setAlign('iStatus_proses', 'center');
        $grid->setLabel('iStatus_proses','Current Proses'); 
    
        $grid->setWidth('cApproved', '100');
        $grid->setAlign('cApproved', 'left');
        $grid->setLabel('cApproved','CAPPROVED');
    
        $grid->setWidth('vreason_approved', '100');
        $grid->setAlign('vreason_approved', 'left');
        $grid->setLabel('vreason_approved','VREASON_APPROVED');
    
        $grid->setWidth('cformulator', '100');
        $grid->setAlign('cformulator', 'left');
        $grid->setLabel('cformulator','CFORMULATOR');
    
        $grid->setWidth('istatus_terima_req', '100');
        $grid->setAlign('istatus_terima_req', 'left');
        $grid->setLabel('istatus_terima_req','ISTATUS_TERIMA_REQ');
    
        $grid->setWidth('cApproved_terima', '100');
        $grid->setAlign('cApproved_terima', 'left');
        $grid->setLabel('cApproved_terima','CAPPROVED_TERIMA');
    
        $grid->setWidth('dApproved_terima', '100');
        $grid->setAlign('dApproved_terima', 'left');
        $grid->setLabel('dApproved_terima','DAPPROVED_TERIMA');
    
        $grid->setWidth('vreason_terima', '100');
        $grid->setAlign('vreason_terima', 'left');
        $grid->setLabel('vreason_terima','Keterangan');
    
        $grid->setWidth('dTgl_rev_mbr', '100');
        $grid->setAlign('dTgl_rev_mbr', 'left');
        $grid->setLabel('dTgl_rev_mbr','DTGL_REV_MBR');
    
        $grid->setWidth('vNo_cc', '100');
        $grid->setAlign('vNo_cc', 'left');
        $grid->setLabel('vNo_cc','VNO_CC');
    
        $grid->setWidth('dPengajuan_cc', '100');
        $grid->setAlign('dPengajuan_cc', 'left');
        $grid->setLabel('dPengajuan_cc','DPENGAJUAN_CC');
    
        $grid->setWidth('iStatus_cc', '100');
        $grid->setAlign('iStatus_cc', 'left');
        $grid->setLabel('iStatus_cc','ISTATUS_CC');
    
        $grid->setWidth('dApproved_cc', '100');
        $grid->setAlign('dApproved_cc', 'left');
        $grid->setLabel('dApproved_cc','DAPPROVED_CC');
    
        $grid->setWidth('cApproved_cc', '100');
        $grid->setAlign('cApproved_cc', 'left');
        $grid->setLabel('cApproved_cc','CAPPROVED_CC');
    
        $grid->setWidth('dUji_BE', '100');
        $grid->setAlign('dUji_BE', 'left');
        $grid->setLabel('dUji_BE','DUJI_BE');
    
        $grid->setWidth('dSelesai_uji_BE', '100');
        $grid->setAlign('dSelesai_uji_BE', 'left');
        $grid->setLabel('dSelesai_uji_BE','DSELESAI_UJI_BE');
    
        $grid->setWidth('vNo_hasil_uji_BE', '100');
        $grid->setAlign('vNo_hasil_uji_BE', 'left');
        $grid->setLabel('vNo_hasil_uji_BE','VNO_HASIL_UJI_BE');
    
        $grid->setWidth('vHasil_uji_BE', '100');
        $grid->setAlign('vHasil_uji_BE', 'left');
        $grid->setLabel('vHasil_uji_BE','VHASIL_UJI_BE');
    
        $grid->setWidth('iStatus_uji_BE', '100');
        $grid->setAlign('iStatus_uji_BE', 'left');
        $grid->setLabel('iStatus_uji_BE','ISTATUS_UJI_BE');
    
        $grid->setWidth('dApproved_uji_BE', '100');
        $grid->setAlign('dApproved_uji_BE', 'left');
        $grid->setLabel('dApproved_uji_BE','DAPPROVED_UJI_BE');
    
        $grid->setWidth('cApproved_uji_BE', '100');
        $grid->setAlign('cApproved_uji_BE', 'left');
        $grid->setLabel('cApproved_uji_BE','CAPPROVED_UJI_BE');
    
        $grid->setWidth('dCreate', '100');
        $grid->setAlign('dCreate', 'left');
        $grid->setLabel('dCreate','DCREATE');
    
        $grid->setWidth('cCreated', '100');
        $grid->setAlign('cCreated', 'left');
        $grid->setLabel('cCreated','CCREATED');
    
        $grid->setWidth('dupdate', '100');
        $grid->setAlign('dupdate', 'left');
        $grid->setLabel('dupdate','DUPDATE');
    
        $grid->setWidth('cUpdate', '100');
        $grid->setAlign('cUpdate', 'left');
        $grid->setLabel('cUpdate','CUPDATE');
    
        $grid->setWidth('lDeleted', '100');
        $grid->setAlign('lDeleted', 'left');
        $grid->setLabel('lDeleted','LDELETED');

        $grid->setWidth('dossier_upd.vUpd_no', '150');
        $grid->setAlign('dossier_upd.vUpd_no', 'left');
        $grid->setLabel('dossier_upd.vUpd_no','Nama Product');
    
       
        $grid->setInputGet('iTujuan_req', $this->input->get('tujuan_request_sample'));
        $grid->setInputGet('field', $this->input->get('field'));

        //$grid->setQuery('isubmit_maping',1);

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
        $grid->setQuery('export_req_refor.iSubmitPD = 1 ', null); 

       $iTujuan_req=$_GET['iTujuan_req'];;

        //echo "tujuan".$$iTujuan_req;

        /*validasi*/
        //1. browse berdasarkan tujuan request
        if($iTujuan_req==1){
            // a. untuk skala trial
            // start bisa request ketika request refor sudah diterima , 
                $grid->setQuery('export_req_refor.iexport_req_refor IN (select a.iexport_req_refor 
                                                                from reformulasi.export_req_refor a 
                                                                where a.lDeleted=0 and a.iSubmitPD = 1)', null);

            //end ketika sudah selesai skala trial 
                $grid->setQuery('export_req_refor.iexport_req_refor NOT IN (SELECT a.iexport_req_refor 
                                                                            FROM reformulasi.export_refor_formula a 
                                                                            join reformulasi.export_req_refor b on b.iexport_req_refor=a.iexport_req_refor
                                                                            where a.lDeleted=0
                                                                            and b.lDeleted=0
                                                                            and a.iappd_trial=2)', null);

                
            


        }else if($iTujuan_req==2){
            // tujuan re-Trial , saat stress test TMS
            // start  saat sudah ada request refor yang selesai skala trial
             /*$grid->setQuery('export_req_refor.iexport_req_refor NOT IN (SELECT a.iexport_req_refor 
                                                                            FROM reformulasi.export_refor_formula a 
                                                                            join reformulasi.export_req_refor b on b.iexport_req_refor=a.iexport_req_refor
                                                                            where a.lDeleted=0
                                                                            and b.lDeleted=0
                                                                            and a.iappd_trial=2)', null);*/
            // end 
        }


        //1.2. tidak bisa request lagi no refor yang sama jika sebelumnya belum ada 1 pun batch yang diterima 
                $grid->setQuery('export_req_refor.iexport_req_refor NOT IN (SELECT a1.iexport_req_refor 
                                                                                    FROM reformulasi.export_req_refor a1                                 
                                                                                    where a1.lDeleted=0
                                                                                    and a1.iexport_req_refor in (
                                                                                                                        select a.iexport_req_refor
                                                                                                                        from reformulasi.export_request_sample a 
                                                                                                                        join reformulasi.export_request_sample_detail b on b.iexport_request_sample=a.iexport_request_sample
                                                                                                                        left join reformulasi.export_ro_detail c on c.iexport_request_sample_detail=b.iexport_request_sample_detail
                                                                                                                        left join reformulasi.export_ro_detail_batch d on d.iexport_ro_detail=c.iexport_ro_detail
                                                                                                                        where a.lDeleted=0
                                                                                                                        and b.lDeleted=0
                                                                                                                        and a.iTujuan_request="'.$iTujuan_req.'"
                                                                                                                        and d.iJumlah_terima is null

                                                                                    ))', null);

        //1.3 tidak bisa request jika masih ada permintaan sample yang masih aktif (belum ada keputusan approve atau reject)
                $grid->setQuery('export_req_refor.iexport_req_refor NOT IN (select e.iexport_req_refor 
                                from reformulasi.export_request_sample e 
                                where
                                e.lDeleted=0
                                and e.iTujuan_request="'.$iTujuan_req.'"
                                and e.iApprove_pd =0
                                )', null);
        

 
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

    

	function listBox_export_browse_request_sample_pilih($value, $pk, $name, $rowData) {
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
