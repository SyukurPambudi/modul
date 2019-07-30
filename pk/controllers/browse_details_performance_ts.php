<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_details_performance_ts extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
		$this->db_erp_pk = $this->load->database('pk', false,true);
		$this->user = $this->auth->user();
		//$this->load->model('details_busdev');
    }
    function index($action = '') {
    	$iparameter_id=$this->input->get('iparameter_id');
    	$imaster_id=$this->input->get('id');
		switch ($action) {		
			case "view":
				echo $this->renderfunc($imaster_id,$iparameter_id);
				break;
			default:
				echo $this->renderfunc($imaster_id,$iparameter_id);
				break;
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

    public function TSPERFM_01($imaster_id){
    	$datamaster=$this->getDetMaster($imaster_id);
    	$sqlmain="select raw.id, raw.problem_subject, raw.problem_description, raw.actual_finish,raw.assignTime,so.input_date,so.commentType from hrd.ss_raw_problems raw 
			inner join hrd.ss_solution so on raw.id=so.id
			where 
			#raw ldeleted
			raw.Deleted='No' AND
			#Activity Type-Client CPU Instalasi
			raw.activity_id=116 AND 
			#Task status Finish
			raw.taskStatus='Finish' AND
			#SS Sudag Accepted
			raw.eAcceptanceStat='Accepted' AND
			#comment type yang assign atau mark finish
			so.commentType in (2,50) AND 
			#pic nip pengusul dan requestor bukan nip pengusul
			raw.requestor not in ('".$datamaster['vnip']."') AND raw.pic like '%".$datamaster['vnip']."%' AND
			#interval waktu penilaian
			raw.actual_finish between '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'";
		$sqlmain="SELECT z.id,z.problem_subject, z.date_posted,z.assignTime,z.actual_start,z.startDuration,z.input_date,z.commentType, z.vType, z.solution_id,z.actual_finish 
			FROM (SELECT a.id,b.solution_id,a.problem_subject, a.date_posted, 
			Case when a.approveDate is not null then a.approveDate 
			When a.assignTime is not null then a.assignTime 
			else a.date_posted end 
			assignTime, a.actual_start,b.startDuration,b.input_date,b.commentType,b.vType,iGrp_activity_id, a.actual_finish 
			FROM hrd.ss_raw_problems a JOIN hrd.ss_solution b ON b.id = a.id JOIN hrd.ss_activity_type c on c.activity_id = a.activity_id 
			WHERE #pic nip pengusul dan requestor bukan nip pengusul 
			a.requestor not in ('".$datamaster['vnip']."') and a.posted_by not in ('".$datamaster['vnip']."')
			AND a.pic like '%".$datamaster['vnip']."%'
			#interval waktu penilaian 
			AND DATE(a.actual_finish) between '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."' 
			AND CASE WHEN (SELECT assign FROM hrd.ss_support_type WHERE typeId=a.typeId)='Y' 
			THEN (b.commentType = 2) END 
			#Activity Type-Client CPU Instalasi 
			AND a.activity_id = 224 
			AND (b.isDeleted = 0 OR b.isDeleted IS NULL) 
			UNION 
			SELECT a.id,b.solution_id,a.problem_subject, a.date_posted, 
			Case when a.approveDate is not null then a.approveDate 
			When a.assignTime is not null then a.assignTime 
			else a.date_posted end 
			assignTime, a.actual_start,b.startDuration,b.input_date,b.commentType, b.vType,c.iGrp_activity_id, a.actual_finish 
			FROM hrd.ss_raw_problems a 
			JOIN hrd.ss_solution b ON b.id = a.id 
			JOIN hrd.ss_activity_type c on c.activity_id = a.activity_id 
			WHERE #pic nip pengusul dan requestor bukan nip pengusul 
			a.requestor not in ('".$datamaster['vnip']."') and a.posted_by not in ('".$datamaster['vnip']."')
			AND a.pic like '%".$datamaster['vnip']."%' 
			#interval waktu penilaian 
			AND DATE(a.actual_finish) between '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."' AND (b.commentType = 50) 
			#Activity Type-Client CPU Instalasi 
			AND a.activity_id = 224 AND (b.isDeleted = 0 OR b.isDeleted IS NULL) 
			) AS z 
			GROUP BY z.id, z.vType 
			ORDER BY z.date_posted,z.solution_id";
		$data['sql']=$sqlmain;
		$dupb = $this->db_erp_pk->query($sqlmain);
		
		$data['datas']=$dupb;
		$data['nippemohon']=$datamaster['vnip'];
    	$view=$this->load->view('detail_perform/ts/performance_1',$data,true);
		return $view;
    }

    public function TSPERFM_02($imaster_id){
    	$datamaster=$this->getDetMaster($imaster_id);
    	$sqlmain="select raw.id,raw.problem_subject, raw.actual_start, raw.actual_finish,act.iSLARate,act.mDescription from hrd.ss_raw_problems raw 
			inner join hrd.ss_activity_type act on act.activity_id=raw.activity_id
			where 
			#raw ldeleted
			raw.Deleted='No' AND
			#Menghitung bukan module
			raw.moduleId=0 and
			#bukan module
			act.isModule='N' AND
			#SLA
			act.isSLA='Y' AND 
			#pic nip pengusul dan requestor bukan nip pengusul
			raw.requestor not in ('".$datamaster['vnip']."') AND raw.pic like '%".$datamaster['vnip']."%' AND
			#interval waktu penilaian
			raw.actual_finish between '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'";
		$sqlmain="SELECT z.id,z.problem_subject, z.date_posted,z.assignTime,z.actual_start,z.startDuration,z.input_date,z.commentType, z.vType, z.solution_id,z.actual_finish,z.iSLARate 
				FROM (SELECT a.id,b.solution_id,a.problem_subject, a.date_posted, 
				Case when a.approveDate is not null then a.approveDate 
				When a.assignTime is not null then a.assignTime 
				else a.date_posted end 
				assignTime, a.actual_start,b.startDuration,b.input_date,b.commentType,b.vType,iGrp_activity_id, a.actual_finish , c.iSLARate
				FROM hrd.ss_raw_problems a JOIN hrd.ss_solution b ON b.id = a.id 
				JOIN hrd.ss_activity_type c on c.activity_id = a.activity_id 
				WHERE #pic nip pengusul dan requestor bukan nip pengusul 
				a.requestor not in ('".$datamaster['vnip']."') 
				AND a.pic like '%".$datamaster['vnip']."%'
				#interval waktu penilaian 
				AND DATE(a.actual_finish) between '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'
				AND CASE WHEN (SELECT assign FROM hrd.ss_support_type WHERE typeId=a.typeId)='Y' 
				THEN (b.commentType = 2) END
				#bukan module
				AND c.isModule='N' 
				#SLA yes
				AND c.isSLA='Y'  
				AND (b.isDeleted = 0 OR b.isDeleted IS NULL) 
				UNION 
				SELECT a.id,b.solution_id,a.problem_subject, a.date_posted, 
				Case when a.approveDate is not null then a.approveDate 
				When a.assignTime is not null then a.assignTime 
				else a.date_posted end 
				assignTime, a.actual_start,b.startDuration,b.input_date,b.commentType, b.vType,c.iGrp_activity_id, a.actual_finish, c.iSLARate 
				FROM hrd.ss_raw_problems a 
				JOIN hrd.ss_solution b ON b.id = a.id 
				JOIN hrd.ss_activity_type c on c.activity_id = a.activity_id 
				WHERE #pic nip pengusul dan requestor bukan nip pengusul 
				a.requestor not in ('".$datamaster['vnip']."') 
				AND a.pic like '%".$datamaster['vnip']."%'
				#interval waktu penilaian 
				AND DATE(a.actual_finish) between '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."' #AND (b.commentType = 50) 
				#bukan module
				AND c.isModule='N' 
				#SLA yes
				AND c.isSLA='Y'   
				#Activity Type-Client CPU Instalasi 
				AND (b.isDeleted = 0 OR b.isDeleted IS NULL) 
				) AS z 
				GROUP BY z.id, z.vType 
				ORDER BY z.date_posted,z.solution_id";
		$data['sql']=$sqlmain;
		$dupb = $this->db_erp_pk->query($sqlmain)->result_array();
		$data['nip']=$datamaster['vnip'];
		$data['datas']=$dupb;
    	$view=$this->load->view('detail_perform/ts/performance_2',$data,true);
		return $view;
    }
    public function TSPERFM_03($imaster_id){
    	$datamaster=$this->getDetMaster($imaster_id);
    	$sqlmain="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
			where 
			#raw ldeleted
			raw.Deleted='No' AND
			#activity type Maintenance Server dari virus dan Junk data user yang tidak berhubungan dengan kantor
			raw.activity_id=221 AND
			#status SS telah finish
			raw.taskStatus='Finish' AND
			#pic nip pengusul dan requestor bukan nip pengusul
			raw.requestor not in ('".$datamaster['vnip']."') AND raw.pic like '%".$datamaster['vnip']."%' AND
			#interval waktu penilaian
			raw.tMarkedAsFinished between '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'
			ORDER BY raw.satisfaction_value DESC
			LIMIT 6";
		$data['sql']=$sqlmain;
		$dupb = $this->db_erp_pk->query($sqlmain)->result_array();
		$data['nip']=$datamaster['vnip'];
		$data['datas']=$dupb;
    	$view=$this->load->view('detail_perform/ts/performance_3',$data,true);
		return $view;
    }

    public function TSPERFM_04($imaster_id){
    	$datamaster=$this->getDetMaster($imaster_id);
    	$sqlmain="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
			where 
			#raw ldeleted
			raw.Deleted='No' AND
			#activity type Maintenance - Cek & Update Account Email dan LDAP
			raw.activity_id=222 AND
			#status SS telah finish
			raw.taskStatus='Finish' AND
			#pic nip pengusul dan requestor bukan nip pengusul
			raw.requestor not in ('".$datamaster['vnip']."') AND raw.pic like '%".$datamaster['vnip']."%' AND
			#interval waktu penilaian
			raw.tMarkedAsFinished between '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'
			ORDER BY raw.satisfaction_value DESC
			LIMIT 6";
		$data['sql']=$sqlmain;
		$dupb = $this->db_erp_pk->query($sqlmain)->result_array();
		$data['nip']=$datamaster['vnip'];
		$data['datas']=$dupb;
    	$view=$this->load->view('detail_perform/ts/performance_4',$data,true);
		return $view;
    }
    public function TSPERFM_07($imaster_id){
    	$datamaster=$this->getDetMaster($imaster_id);
    	$sqlmain="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
			where 
			#raw ldeleted
			raw.Deleted='No' AND
			#activity type Maintenance-Update data inventaris di GLPI dan OCS
			raw.activity_id=223 AND
			#status SS telah finish
			raw.taskStatus='Finish' AND
			#pic nip pengusul dan requestor bukan nip pengusul
			raw.requestor not in ('".$datamaster['vnip']."') AND raw.pic like '%".$datamaster['vnip']."%' AND
			#interval waktu penilaian
			raw.tMarkedAsFinished between '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'
			ORDER BY raw.satisfaction_value DESC
			LIMIT 6";
		$data['sql']=$sqlmain;
		$dupb = $this->db_erp_pk->query($sqlmain)->result_array();
		$data['nip']=$datamaster['vnip'];
		$data['datas']=$dupb;
    	$view=$this->load->view('detail_perform/ts/performance_7',$data,true);
		return $view;
    }
     public function TSPERFM_08($imaster_id){
    	$datamaster=$this->getDetMaster($imaster_id);


    	//Task Finish
		$sql1 = "SELECT * FROM hrd.ss_raw_problems b 
			WHERE b.`taskStatus` ='Finish' AND b.`satisfaction_value` IS NOT NULL AND b.Deleted='No' 
			AND b.`finishing_by` IS NOT NULL AND b.requestor NOT IN ('".$datamaster['vnip']."') 
			AND b.pic LIKE '%".$datamaster['vnip']."%' AND 
			b.tMarkedAsFinished BETWEEN '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'";

		$dupb=$this->db_erp_pk->query($sql1);

		$data['data1']=$dupb->result_array();
		$data['data3']=$dupb->num_rows;

    	$view=$this->load->view('detail_perform/ts/performance_8',$data,true);

		return $view;
    }
    public function TSPERFM_09($imaster_id){
    	$datamaster=$this->getDetMaster($imaster_id);
    	$sqlmain="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
			where 
			#raw ldeleted
			raw.Deleted='No' AND
			#activity type Maintenance - Daily/Weekly/Monthly 
			raw.activity_id=227 AND
			#status SS telah finish
			raw.taskStatus='Finish' AND
			#pic nip pengusul dan requestor bukan nip pengusul
			raw.requestor not in ('".$datamaster['vnip']."') AND raw.pic like '%".$datamaster['vnip']."%' AND
			#interval waktu penilaian
			raw.tMarkedAsFinished between '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'
			ORDER BY raw.satisfaction_value DESC
			LIMIT 6";
		$data['sql']=$sqlmain;
		$dupb = $this->db_erp_pk->query($sqlmain)->result_array();
		$data['nip']=$datamaster['vnip'];
		$data['datas']=$dupb;
    	$view=$this->load->view('detail_perform/ts/performance_9',$data,true);
		return $view;
    }
    public function TSPERFM_10($imaster_id){

    	$datamaster=$this->getDetMaster($imaster_id);

    	$sqlmain="SELECT z.id,z.problem_subject, z.date_posted,z.assignTime, 
			z.actual_start,z.startDuration,z.input_date,z.commentType,
			z.vType, z.solution_id FROM (
			SELECT a.id,b.solution_id,a.problem_subject, a.date_posted, CASE WHEN a.approveDate IS NOT NULL THEN a.approveDate
				WHEN a.assignTime IS NOT NULL THEN a.assignTime  ELSE a.date_posted END assignTime,
							a.actual_start,b.startDuration,b.input_date,b.commentType,
							b.vType
							FROM hrd.ss_raw_problems a 
							JOIN hrd.`ss_solution` b ON b.id = a.id
							WHERE 
							#Bukan Req
							a.requestor NOT IN ('".$datamaster['vnip']."') 
							AND a.pic LIKE '%".$datamaster['vnip']."%'
							#AND a.parent_id != 0
							AND DATE(a.date_posted) BETWEEN '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'
							AND CASE WHEN (SELECT assign FROM hrd.ss_support_type WHERE typeId=a.typeId)='Y'
							    THEN (b.commentType = 2) END
							#AND a.activity_id != 22
							AND b.pic LIKE '%".$datamaster['vnip']."%'
							AND (b.isDeleted = 0 OR b.isDeleted IS NULL)
			UNION
			SELECT a.id,b.solution_id,a.problem_subject, a.date_posted,	CASE WHEN a.approveDate IS NOT NULL THEN a.approveDate
				WHEN a.assignTime IS NOT NULL THEN a.assignTime  ELSE a.date_posted END assignTime,
							a.actual_start,b.startDuration,b.input_date,b.commentType,
							b.vType
							FROM hrd.ss_raw_problems a 
							JOIN hrd.ss_solution b ON b.id = a.id
							WHERE 
							#Bukan Req
							a.requestor NOT IN ('".$datamaster['vnip']."') 
							AND a.pic LIKE '%".$datamaster['vnip']."%'
							#AND a.parent_id != 0
							AND DATE(a.date_posted) BETWEEN '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'
							AND b.commentType = 50
							#AND a.activity_id != 22
							AND b.pic LIKE '%".$datamaster['vnip']."%'
							AND (b.isDeleted = 0 OR b.isDeleted IS NULL)
		) AS z
		GROUP BY z.id, z.vType
		ORDER BY z.date_posted,z.solution_id";
		$data['sql']=$sqlmain;
		$dupb = $this->db_erp_pk->query($sqlmain)->result_array();
		$data['data1']=$dupb;
		$data['nippemohon']=$datamaster['vnip'];
    	$view=$this->load->view('detail_perform/ts/performance_10',$data,true);
		return $view;
    }
    public function TSPERFM_11($imaster_id){

    	$datamaster=$this->getDetMaster($imaster_id);
    	#Total absensi 
    	$sqlmain="SELECT b.cin, b.`dAbsensi` FROM  hrd.`msabsen` b 
				WHERE 
				#absensi diatas jam 8
				b.`cin` > '08:00:00' AND b.cin !='' 
				AND b.cNip LIKE '%".$datamaster['vnip']."%' AND b.`dAbsensi` 
				BETWEEN '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'";

		$data['sql']=$sqlmain;
		$dupb = $this->db_erp_pk->query($sqlmain);

		$data['data1']=$dupb->result_array();
		$data['data3']=$dupb->num_rows;
    	$view=$this->load->view('detail_perform/ts/performance_11',$data,true);
		return $view;
    }
    public function TSPERFM_12($imaster_id){

       	$datamaster=$this->getDetMaster($imaster_id);

       	/*$sql1 ="SELECT a.`iArea` FROM hrd.employee a WHERE a.`cNip`='".$datamaster['vnip']."'";
       	$dupb = $this->db_erp_pk->query($sql1);
			
		$dtmain=$dupb->row_array();
		if($dtmain['iArea']==45){
			$cout ="18:00:00";
		}else{
			$cout ="17:00:00";
		}
		*/

		$sql1 = "SELECT * FROM hrd.dshift da
					INNER JOIN hrd.gshift gs ON da.iShiftID=gs.iShiftID
					INNER JOIN hrd.employee em ON em.igshiftid=gs.iGShiftID
					WHERE em.cNip='".$datamaster['vnip']."' AND (da.ciIn!='00:00:00' OR da.ciEnd!='00:00:00')";
		
		$qsqlmain1 = $this->db_erp_pk->query($sql1);
			
		$dtmain=$qsqlmain1->num_rows();

		if($dtmain==5){
			$cout ="18:00:00";
		}else{
			$cout ="17:00:00";
		}


		$sqlmain1 = "SELECT DISTINCT
					(
					SELECT COUNT(*) FROM hrd.msabsen aa
					WHERE aa.cNip = '".$datamaster['vnip']."'
					AND MONTH(aa.dAbsensi)=MONTH(a.dAbsensi )
					# AND YEAR(aa.dAbsensi)=2016
					AND aa.cout>'".$cout."' AND aa.`cout` <> ':  :' AND aa.`cout` != '' AND aa.dAbsensi BETWEEN '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'
					) 
						AS piket, MONTH(a.dAbsensi) AS bln
						FROM hrd.msabsen a
						WHERE a.cNip='".$datamaster['vnip']."'

						# AND month(a.dAbsensi)=12
						AND a.dAbsensi BETWEEN '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'
						# AND YEAR(a.dAbsensi)=2016
						GROUP BY MONTH(a.dAbsensi);";

		$data['sql1']=$sqlmain1;
		$dupb1 = $this->db_erp_pk->query($sqlmain1);

		$data['data2']=$dupb1->result_array();
		$data['nippemohon']=$datamaster['vnip'];
		$data['tgl1']=$datamaster['tgl1'];
		$data['tgl2']=$datamaster['tgl2'];
		$data['area']=$dtmain;
    	$view=$this->load->view('detail_perform/ts/performance_12',$data,true);
		return $view;
    }

    public function TSPERFM_13($imaster_id){
    	$datamaster=$this->getDetMaster($imaster_id);
    	$sqlmain="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
			where 
			#raw ldeleted
			raw.Deleted='No' AND
			#activity type Maintenance - Laporan Server Down
			raw.activity_id=229 AND
			#status SS telah finish
			#raw.taskStatus='Finish' AND
			#pic nip pengusul dan requestor bukan nip pengusul
			#raw.requestor not in ('".$datamaster['vnip']."') AND 
			raw.pic like '%".$datamaster['vnip']."%' AND
			#interval waktu penilaian
			raw.tMarkedAsFinished between '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'
			ORDER BY raw.satisfaction_value DESC ";
		$data['sql']=$sqlmain;
		$dupb = $this->db_erp_pk->query($sqlmain)->result_array();
		$data['nip']=$datamaster['vnip'];
		$data['datas']=$dupb;
    	$view=$this->load->view('detail_perform/ts/performance_13',$data,true);
		return $view;
    }

     public function TSPERFM_15($imaster_id){
    	$datamaster=$this->getDetMaster($imaster_id);
    	$sqlmain="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
			where 
			#raw ldeleted
			raw.Deleted='No' AND
			#activity type Maintenance - Kelengkapan Laporan Stock
			raw.activity_id=228 AND
			#status SS telah finish
			raw.taskStatus='Finish' AND
			#pic nip pengusul dan requestor bukan nip pengusul
			raw.requestor not in ('".$datamaster['vnip']."') AND raw.pic like '%".$datamaster['vnip']."%' AND
			#interval waktu penilaian
			raw.tMarkedAsFinished between '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'
			ORDER BY raw.satisfaction_value DESC
			LIMIT 6";
		$data['sql']=$sqlmain;
		$dupb = $this->db_erp_pk->query($sqlmain)->result_array();
		// Satisvaction value > 0
    	
    	$cNip=$this->user->gNIP;
		//Mengecek apakah user login atasan dari data
		$sqldatatab2="select * from hrd.employee em where cNip='".$datamaster['vnip']."'";
		$datemployee=$this->db_erp_pk->query($sqldatatab2)->row_array();
		$iatasan=0;
		if($datemployee['cUpper']==$cNip){
			$iatasan=1;
		}
		
		$data['nip']=$datamaster['vnip'];
		$data['datas']=$dupb;
		$data['atasan']=$iatasan;
    	$view=$this->load->view('detail_perform/ts/performance_15',$data,true);
		return $view;
    }

     public function TSPERFM_14($imaster_id){

    	$datamaster=$this->getDetMaster($imaster_id);

		$sqlmain = "SELECT SUM(b.`satisfaction_value`) AS TOT 
			FROM  hrd.ss_raw_problems b WHERE b.`satisfaction_value` IS NOT NULL AND b.`satisfaction_value` > 0  AND  b.`taskStatus` = 'Finish'  
			AND
			b.pic LIKE '".$datamaster['vnip']."' AND b.Deleted='No' and 
			b.`tMarkedAsFinished` BETWEEN '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'";
		$data['sql']=$sqlmain;
		$dupb = $this->db_erp_pk->query($sqlmain);

		$sqlmain1 = "SELECT * FROM  hrd.ss_raw_problems b 
				WHERE b.`satisfaction_value` IS NOT NULL AND b.`satisfaction_value` > 0  AND  b.`taskStatus` = 'Finish' AND
				b.pic LIKE '".$datamaster['vnip']."' AND b.Deleted='No' 
					
				and
				b.`tMarkedAsFinished` BETWEEN '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'";
		$data['sql1']=$sqlmain1;
		$dupb1 = $this->db_erp_pk->query($sqlmain1);


		// Satisvaction value > 0
    	
    	//$cNip=$this->user->gNIP;
		//Mengecek apakah user login atasan dari data
		//$sqldatatab2="select * from hrd.employee em where cNip='".$datamaster['vnip']."'";
		//$datemployee=$this->db_erp_pk->query($sqldatatab2)->row_array();
		//$iatasan=0;
		//if($datemployee['cUpper']==$cNip){
		//	$iatasan=1;
		//}


		$data['data1']=$dupb->row_array();
		$data['data2']=$dupb1->result_array();
		$data['data3']=$dupb1->num_rows;
		$data['atasan']=$iatasan;

    	$view=$this->load->view('detail_perform/ts/performance_14',$data,true);
		return $view;
    }
     public function TSPERFM_16($imaster_id){
    	$datamaster=$this->getDetMaster($imaster_id);
    	$sqlmain="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
			where 
			#raw ldeleted
			raw.Deleted='No' AND
			#activity type Maintenance - Bandwith Monitoring 
			raw.activity_id=230 AND
			#status SS telah finish
			raw.taskStatus='Finish' AND
			#pic nip pengusul dan requestor bukan nip pengusul
			raw.requestor not in ('".$datamaster['vnip']."') AND raw.pic like '%".$datamaster['vnip']."%' AND
			#interval waktu penilaian
			raw.tMarkedAsFinished between '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'
			ORDER BY raw.satisfaction_value DESC
			LIMIT 6";
		$data['sql']=$sqlmain;
		$dupb = $this->db_erp_pk->query($sqlmain)->result_array();
		$data['nip']=$datamaster['vnip'];
		$data['datas']=$dupb;
    	$view=$this->load->view('detail_perform/ts/performance_16',$data,true);
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

