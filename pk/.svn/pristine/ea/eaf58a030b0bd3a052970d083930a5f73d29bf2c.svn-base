<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_details_performance_sdm extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
		$this->db_erp_pk = $this->load->database('pk', false,true);
		$this->user = $this->auth->user();
		//$this->load->model('details_busdev');
    }
    function index($action = '') {
    	$iparameter_id=$this->input->get('iparameter_id');
        $ssid=$this->input->get('ssid');
    	$imaster_id=$this->input->get('id');
        if(!empty($ssid)){
            switch ($action) {
                case "view":
                    echo $this->renderfunc_po($imaster_id,$iparameter_id,$ssid);
                    break;
                default:
                    echo $this->renderfunc_po($imaster_id,$iparameter_id,$ssid);
                    break;
            }
        }else{
            switch ($action) {
                case "view":
                    echo $this->renderfunc($imaster_id,$iparameter_id);
                    break;
                default:
                    echo $this->renderfunc($imaster_id,$iparameter_id);
                    break;
            }
        }

    }

    public function renderfunc_po($imaster_id,$iparameter_id,$ssid){
        $q="select * from pk.pk_parameter_po where ldeleted=0 and iparameter_id=$iparameter_id limit 1";
        $st=$this->db_erp_pk->query($q)->row_array();
        if(method_exists($this, $st['vFunction'])){
            $func=$st['vFunction'];
            return $this->$func($imaster_id,$ssid);
        }else{
            return "NOT FOUND FUNCTION";
        }
    }

    public function renderfunc($imaster_id,$iparameter_id){
    	$q="select * from pk.pk_parameter where ldeleted=0 and iparameter_id=$iparameter_id limit 1";
    	$st=$this->db_erp_pk->query($q)->row_array();
    	if(method_exists($this, $st['vFunction'])){
    		$func=$st['vFunction'];
    		return $this->$func($imaster_id);
    	}else{
    		return "NOT FOUND FUNCTION";
    	}
    }
    private function getDetMaster($imaster_id){
    	$tq="select * from pk.pk_master mas where mas.ldeleted=0 and mas.idmaster_id=$imaster_id";
    	$qmas=$this->db_erp_pk->query($tq)->row_array();
    	return $qmas;
    }

    public function SDMPERFORMANCE_1($imaster_id){
        $datamaster=$this->getDetMaster($imaster_id);
        $year = date('Y', strtotime($datamaster['tgl1']));
        $month = date('M', strtotime($datamaster['tgl1']));
        $tgl1 = date($datamaster['tgl1']);
        $tgl2 = date($datamaster['tgl2']);     
        if( $month < 7){
            $semester = 1;
        }else{
            $semester = 2;
        } 
        $sql = "select vnip from pk.pk_master where idmaster_id  = ".$imaster_id ;
    	$qt=$this->db->query($sql)->row_array();
        
        $vNip = $qt['vnip']; 
        
        $sqlmain = "Select distinct a.id, a.problem_subject, a.iSizeProject, a.dclosePm  
                from hrd.ss_raw_problems a
                inner join  hrd.ss_raw_pic b on a.id = b.rawid and b.pic = '".$vNip."' and iRoleId = 1
                where a.dClosePm between '".$tgl1."' and '".$tgl2."' and b.Deleted = 'No' and
                iStatus = 13 ";   
                                
        /*        where a.cTahun =".$year." and a.cSemester = ".$semester." and b.Deleted = 'No' and 
                iStatus = 13 "; */  
                
		$data['sql']=$sqlmain;
		$dupb = $this->db_erp_pk->query($sqlmain);
		
		$data['datas']=$dupb;
		$data['nippemohon']=$datamaster['vnip'];
    	$view=$this->load->view('detail_perform/sdm/performance_1',$data,true);
		return $view;                    
    }

    public function SDMPERFORMANCE_2($imaster_id){
        $datamaster=$this->getDetMaster($imaster_id);
        $year = date('Y', strtotime($datamaster['tgl1']));
        $month = date('M', strtotime($datamaster['tgl1']));
        $tgl1 = date($datamaster['tgl1']);
        $tgl2 = date($datamaster['tgl2']);        
        if( $month < 7){
            $semester = 1;
        }else{
            $semester = 2;
        } 
        $sql = "select vnip from pk.pk_master where idmaster_id  = ".$imaster_id ;
    	$qt=$this->db->query($sql)->row_array();
        
        $vNip = $qt['vnip']; 
        
        $sqlmain = 
                "Select distinct a.id, a.problem_subject, a.iSizeProject, date(a.dclosePm) dclosePm ,
                 c.cStatus, a.dTarget_implement,
                	CASE when date(a.dclosePm) > date(a.dTarget_implement) then 'Ya'
                		else 'Tidak' end status
                 from hrd.ss_raw_problems a
                 inner join  hrd.ss_raw_pic b on a.id = b.rawid and b.pic = '".$vNip."' and iRoleId = 1
                 left outer join hrd.ss_project_status c on c.id = a.iStatus
                where a.dClosePm between '".$tgl1."' and '".$tgl2."' and b.Deleted = 'No' and
                iStatus = 13 "; 
                                 
       /*          where a.cTahun =".$year." and a.cSemester = ".$semester." and b.Deleted = 'No' and 
                 iStatus not in (1,2,8,9,11)  ";     */                  
                
		$data['sql']=$sqlmain;
		$dupb = $this->db_erp_pk->query($sqlmain);
		
		$data['datas']=$dupb;
		$data['nippemohon']=$datamaster['vnip'];
    	$view=$this->load->view('detail_perform/sdm/performance_2',$data,true);
		return $view;                    
    }        

    public function SDMPERFORMANCE_3($imaster_id){
        $datamaster=$this->getDetMaster($imaster_id);
        $tgl1 = date($datamaster['tgl1']);
        $tgl2 = date($datamaster['tgl2']);

        $sql = "select vnip from pk.pk_master where idmaster_id  = ".$imaster_id ;
    	$qt=$this->db->query($sql)->row_array();
        
        $vNip = $qt['vnip']; 
        
        $sqlmain =                 
            "select a.iCommitId, a.iSvnId,d.vName as appname,  a.vAuthor,c.vName, b.vFile, 
            sum(b.iLOC)loc, a.tCommit, MONTH(a.tCommit) Bulan
            from hrd.svn_commit_header a
            left outer join hrd.svn_commit_detail b on a.iCommitId = b.iCommitId
            left outer join hrd.employee c on a.vAuthor = c.cNip
            left outer join hrd.svn_info d on d.iSvnId = a.iSvnId
            where a.tCommit between '".$tgl1."' and '".$tgl2."' and a.vAuthor = '".$vNip."'
                and b.vFile not in (select cd.vFile from hrd.svn_commit_detail cd
            	inner join hrd.svn_exclude  b on substr(cd.vFile,1,length(Trim(b.vFile))) = Trim(b.vFile))
            group by  a.iCommitId, a.iSvnId, a.vAuthor, c.vName, d.vName, b.vFile,a.tCommit";                  
                
		$data['sql']=$sqlmain;
		$dupb = $this->db_erp_pk->query($sqlmain);
		
		$data['datas']=$dupb;
		$data['nippemohon']=$datamaster['vnip'];
    	$view=$this->load->view('detail_perform/sdm/performance_3',$data,true);
		return $view;                    
    }

    public function SDMPERFORMANCE_4($imaster_id){
        $datamaster=$this->getDetMaster($imaster_id);
        $tgl1 = date($datamaster['tgl1']);
        $tgl2 = date($datamaster['tgl2']);

        $sql = "select vnip from pk.pk_master where idmaster_id  = ".$imaster_id ;
    	$qt=$this->db->query($sql)->row_array();
        
        $vNip = $qt['vnip']; 
        
        $sqlmain =                                
        "select b.moduleId, c.V_MDL_NAME,  c.V_ATTACH, c.N_SIZE
            from hrd.ss_raw_problems a 
            left outer join hrd.ss_raw_problems_module b on a.id = b.parentId
            left outer join hrd.prv_appmodules c on c.id = b.moduleId
            where a.activity_id = 24 and 
            a.actual_finish between  '".$tgl1."' and '".$tgl2."' and
            a.pic = '".$vNip."'and c.N_SIZE > 0
            group by b.moduleId, c.V_MDL_NAME,  c.V_ATTACH, c.N_SIZE";
                
		$data['sql']=$sqlmain;
		$dupb = $this->db_erp_pk->query($sqlmain);
		
		$data['datas']=$dupb;
		$data['nippemohon']=$datamaster['vnip'];
    	$view=$this->load->view('detail_perform/sdm/performance_4',$data,true);
		return $view;                    
    }
    public function SDMPERFORMANCE_5($imaster_id){

        $this->load->library('lib_calc');
        
        $datamaster=$this->getDetMaster($imaster_id);
        $tgl1 = date($datamaster['tgl1']);
        $tgl2 = date($datamaster['tgl2']);

        $sql = "select vnip from pk.pk_master where idmaster_id  = ".$imaster_id ;
        $qt=$this->db->query($sql)->row_array();

        $vNip = $qt['vnip'];


        $bawah = $this->lib_calc->getInferior($vNip);
        $sqlmain =
        "select a.vAuthor,c.vName, sum(b.iLOC)/6 loc
			from hrd.svn_commit_header a
			left outer join hrd.svn_commit_detail b on a.iCommitId = b.iCommitId
			left outer join hrd.employee c on a.vAuthor = c.cNip
			where a.tCommit between '".$tgl1."' and '".$tgl2."' and
			a.vAuthor in ('" . implode("','", $bawah) . "')	group by a.vAuthor";

        $data['sql']=$sqlmain;
        $dupb = $this->db_erp_pk->query($sqlmain);

        $data['datas']=$dupb;
        $data['nippemohon']=$datamaster['vnip'];
        $view=$this->load->view('detail_perform/sdm/performance_5',$data,true);
        return $view;
    }
    
    public function SDMPO($imaster_id,$ssid){
        $datamaster=$this->getDetMaster($imaster_id);
        $this->load->library('lib_calc');
        

        $sql = "select vnip from pk.pk_master where idmaster_id  = ".$imaster_id ;
    	$qt=$this->db->query($sql)->row_array();
        
        $vNip = $qt['vnip']; 
        
        $sqlmain = "Select * from hrd.ss_raw_problems where id =".$ssid;
              
		$data['sql']=$sqlmain;
        $qsqlmain = $this->db_erp_pk->query($sqlmain);
		if($qsqlmain->num_rows>=1){
			$dtmain=$qsqlmain->result_array();
			foreach ($dtmain as $kmain => $vmain) {
				$tglawal =  $vmain['dTarget_implement'];
   	            $tglakhir =  date('Y-m-d', strtotime($vmain['dclosePm']));
				$data['tglawal'] =  $tglawal;
   	            $data['tglakhir'] =  $tglakhir;
			}
            $hasil=$this->lib_calc->selisihHari($tglawal, $tglakhir, $vNip);
            //echo $hasil;
            $data['hasil'] = $hasil;
		}
        $dupb = $this->db_erp_pk->query($sqlmain);
        $data['datas']=$dupb;
		$data['nippemohon']=$datamaster['vnip'];
    	$view=$this->load->view('detail_perform/sdm/performance_obj',$data,true);
		return $view;                    
    }    
    public  function diffInMonths($datestart, $dateend){
	    	$date1 = new DateTime($datestart);
	    	$date2 = new DateTime($dateend);
		    $diff =  $date1->diff($date2);

		    $months = $diff->y * 12 + $diff->m + $diff->d / 30;
		    return (int) floor($months);
	    	//return (int) round($months);
    }

	public function output(){
		$this->index($this->input->get('action'));
	}

}

