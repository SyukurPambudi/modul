<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lib_calc_ts {
	private $_ci;
	public $error;
	public $date1;
	public $date2;
	public $periode;
	public $nippemohon;
	public function __construct() {
		$this->_ci=& get_instance();
		$this->_ci->load->library('auth');
		
		$this->error = 'error';
	}

	//Cek Tanggal libur, dan tanggal kerja
	function selisihHari($tglAwal, $tglAkhir, $nip, $type="day"){
		$this->dbseth = $this->_ci->load->database('hrd', true);
		//select jumlah hari kerja shiftnya
		$sqlc="select * from hrd.dshift da
				inner join hrd.gshift gs on da.iShiftID=gs.iShiftID
				inner join hrd.employee em on em.igshiftid=gs.iGShiftID
				where em.cNip='".$nip."' and (da.ciIn!='00:00:00' or da.ciEnd!='00:00:00')";
		$counthr=$this->dbseth->query($sqlc)->num_rows();

		//$tglLibur = Array("2016-12-25", "2016-12-26");
		$tglLibur = array();
		$sqlholi="select * from hrd.holiday holi
			where holi.bDeleted=0 and holi.ddate Between '".$tglAwal."' AND '".$tglAkhir."'";
		$qlholi=$this->dbseth->query($sqlholi);
		if($qlholi->num_rows()>=1){
			foreach ($qlholi->result_array() as $kholi => $vholi) {
				array_push($tglLibur, $vholi['ddate']);
			}
		}
		 // memecah string tanggal awal untuk mendapatkan
		// tanggal, bulan, tahun
		$pecah1 = explode("-", date("Y-m-d",strtotime($tglAwal)));
		$date1 = $pecah1[2];
		$month1 = $pecah1[1];
		$year1 = $pecah1[0];
		// memecah string tanggal akhir untuk mendapatkan
		// tanggal, bulan, tahun
		$pecah2 = explode("-", date("Y-m-d",strtotime($tglAkhir)));
		$date2 = $pecah2[2];
		$month2 = $pecah2[1];
		$year2 =  $pecah2[0];
		// mencari selisih hari dari tanggal awal dan akhir
		$jd1 = GregorianToJD($month1, $date1, $year1);
		$jd2 = GregorianToJD($month2, $date2, $year2);
		$selisih = $jd2 - $jd1;
		$libur1=0;
		$libur2=0;
		$libur3=0;
		// proses menghitung tanggal merah dan hari minggu
		// di antara tanggal awal dan akhir
		for($i=1; $i<=$selisih; $i++){
			// menentukan tanggal pada hari ke-i dari tanggal awal
			$tanggal = mktime(0, 0, 0, $month1, $date1+$i, $year1);
			$tglstr = date("Y-m-d", $tanggal);
			// menghitung jumlah tanggal pada hari ke-i
			// yang masuk dalam daftar tanggal merah selain minggu
			if (in_array($tglstr, $tglLibur))
			{
				$libur1++;
			}
			// menghitung jumlah tanggal pada hari ke-i
			// yang merupakan hari minggu
			if ((date("N", $tanggal) == 7))
			{
				if (in_array($tglstr, $tglLibur))
				{
					$libur1=$libur1-1;
				}
				$libur2++;
			}
			if ((date("N", $tanggal) == 6))
			{
				if (in_array($tglstr, $tglLibur))
				{
					$libur1=$libur1-1;
				}
				$libur3++;
			}
		}
		if($type=='day'){ //Output Hari
		 // menghitung selisih hari yang bukan tanggal merah dan hari minggu
			if($counthr==5){
				$hasil = $selisih-$libur1-$libur2-$libur3;
			}else{
				$hasil = $selisih-$libur1-$libur2;
			}
			if($hasil>=0){
				if(date('H:i:s', strtotime($tglAwal)) > date('H:i:s', strtotime($tglAkhir))){
					$hasil=$hasil-1;
				}
			}
			//Pengecekan 
			return $hasil;
		}
		if($type='minute'){
			if($counthr==5){
				$hasil = $selisih-$libur1-$libur2-$libur3;
			}else{
				$hasil = $selisih-$libur1-$libur2;
			}
			$hmennt=0;
			if($hasil>=1){
				if(date('H:i:s', strtotime($tglAwal)) > date('H:i:s', strtotime($tglAkhir))){
					#$hasil=$hasil-1;
					$hmennt=(int)$hasil*1440;
					$selmnt=$this->selisihMenit(date('H:i:s', strtotime($tglAkhir)),date('H:i:s', strtotime($tglAwal)));
					$selmnt=1440-(int)$selmnt;
					$hmennt=$hmennt+(int)$selmnt;
					return $hmennt;
				}else{
					$hmennt=(int)$hasil*1440;
					$selmnt=$this->selisihMenit(date('H:i:s', strtotime($tglAwal)),date('H:i:s', strtotime($tglAkhir)));
					$hmennt=$hmennt+(int)$selmnt;
					return $hmennt;
				}
			}else{
				if(date('H:i:s', strtotime($tglAkhir)) > date('H:i:s', strtotime($tglAwal))){
					$selmnt=$this->selisihMenit(date('H:i:s', strtotime($tglAwal)),date('H:i:s', strtotime($tglAkhir)));
					return $selmnt;
					$hmennt=(int)$selmnt;
					return $hmennt;
				}else{
					return "0";
				}
			}
		}
	}

	function selisihMenit($mntawal, $mntakhir){
		/*$time1=date('H:m:s',strtotime($mntawal));
		$time2=date('H:m:s',strtotime($mntakhir));
		list($h1,$m1,$s1)=explode(":", $time1);
		$dtawal=mktime($h1,$m1,$s1,"1","1","1");
		list($h2,$m2,$s2)=explode(":", $time2);
		$dtakhir=mktime($h2,$m2,$s2,"1","1","1");
		return $dtawal.'-'.$dtakhir;
		$durasi=($dtakhir-$dtawal)/60;
		return $durasi;*/
		$a='1991-03-19 '.$mntawal;
		$b='1991-03-19 '.$mntakhir;
		$mna=date_create($a);
		$mnb=date_create($b);
		$diff=date_diff($mna,$mnb);
		$j=$diff->h;
		$s=0;
		if($j>0){
			$s=$j*60;
		}
		$m=$diff->i;
		$n=$s+$m;
		return $n;
	}

	function selisihJam($tglAwal, $tglAkhir, $nip){
		$this->dbseth = $this->_ci->load->database('hrd', true);
		//select jumlah hari kerja shiftnya
		$sqlc="select * from hrd.dshift da
				inner join hrd.gshift gs on da.iShiftID=gs.iShiftID
				inner join hrd.employee em on em.igshiftid=gs.iGShiftID
				where em.cNip='".$nip."' and (da.ciIn!='00:00:00' or da.ciEnd!='00:00:00')";
		$counthr=$this->dbseth->query($sqlc)->num_rows();

		//$tglLibur = Array("2016-12-25", "2016-12-26");
		$tglLibur = array();
		$sqlholi="select * from hrd.holiday holi
			where holi.bDeleted=0 and holi.ddate Between '".$tglAwal."' AND '".$tglAkhir."'";
		$qlholi=$this->dbseth->query($sqlholi);
		if($qlholi->num_rows()>=1){
			foreach ($qlholi->result_array() as $kholi => $vholi) {
				array_push($tglLibur, $vholi['ddate']);
			}
		}
		 // memecah string tanggal awal untuk mendapatkan
		// tanggal, bulan, tahun
		$pecah1 = explode("-", date("Y-m-d",strtotime($tglAwal)));
		$date1 = $pecah1[2];
		$month1 = $pecah1[1];
		$year1 = $pecah1[0];
		// memecah string tanggal akhir untuk mendapatkan
		// tanggal, bulan, tahun
		$pecah2 = explode("-", date("Y-m-d",strtotime($tglAkhir)));
		$date2 = $pecah2[2];
		$month2 = $pecah2[1];
		$year2 =  $pecah2[0];
		// mencari selisih hari dari tanggal awal dan akhir
		$jd1 = GregorianToJD($month1, $date1, $year1);
		$jd2 = GregorianToJD($month2, $date2, $year2);
		$selisih = $jd2 - $jd1;
		$libur1=0;
		$libur2=0;
		$libur3=0;
		// proses menghitung tanggal merah dan hari minggu
		// di antara tanggal awal dan akhir
		for($i=1; $i<=$selisih; $i++){
			// menentukan tanggal pada hari ke-i dari tanggal awal
			$tanggal = mktime(0, 0, 0, $month1, $date1+$i, $year1);
			$tglstr = date("Y-m-d", $tanggal);
			// menghitung jumlah tanggal pada hari ke-i
			// yang masuk dalam daftar tanggal merah selain minggu
			if (in_array($tglstr, $tglLibur))
			{
				$libur1++;
			}
			// menghitung jumlah tanggal pada hari ke-i
			// yang merupakan hari minggu
			if ((date("N", $tanggal) == 7))
			{
				if (in_array($tglstr, $tglLibur))
				{
					$libur1=$libur1-1;
				}
				$libur2++;
			}
			if ((date("N", $tanggal) == 6))
			{
				if (in_array($tglstr, $tglLibur))
				{
					$libur1=$libur1-1;
				}
				$libur3++;
			}

		}
		 // Menotalkan jumlah libur
		if($counthr==5){
			return $libur1+$libur2+$libur3;
		}else{
			return $libur1+$libur2;
		}
	}


	function setDateByPeriod($period=false) {
		if(!$period) return false;
		
		$periodnday = "01-".$period;
		//$this->date1 = $periodnday;
		//$this->date2 = date('d-m-Y', time());//date('t-m-Y',strtotime($periodnday));
		
		return true;
	}
	function getScore( $kode, $hasil ) {
		$this->db_erp_pk = $this->_ci->load->database('pk',false, true);
		
		$sql='select * 
				from pk.pk_parameter a 
				join pk.pk_parameter_detail b on b.iparameter_id=a.iparameter_id
				where a.ldeleted=0
				and b.ldeleted=0
				and a.vFunction="'.$kode.'" 
				order by b.iUrut :order';

		$sql_ = str_replace(':order','ASC',$sql);
		$query = $this->db_erp_pk->query($sql_);
		
		if($query->num_rows()>0) {
			$rows = $query->result_array();
			
			foreach($rows as $row) {
				$sign = (!empty($row['vConSign']))?$row['vConSign']:'>=';
				$cond = $row['iCondition'];
				$score = $row['poin'];
				$statement = "return ( $hasil $sign $cond );";
		
				$check = eval( $statement );
				
				if($check) {
					return $score;
				}
			}
		}
		
		
		$sql_ = str_replace(':order','DESC',$sql);
		
		if($query->num_rows()>0) {
			$rows = $query->result_array();
				
			foreach($rows as $row) {
				$sign = (!empty($row['vConSign']))?$row['vConSign']:'>=';
				$cond = $row['iCondition'];
				$score = $row['poin'];
		
				$statement = "return ( $hasil $sign $cond );";
		
				$check = eval( $statement );
		
				if($check) {
					return $score;
				}
			}
		}
		
		return $this->error;
	}
	function setCalc($kode,$itim=false) {
		if(!$kode) return $this->error;
		
		if(!empty($this->periode)) {
			$this->setDateByPeriod($this->periode);
		}
		
		if(method_exists(get_class($this),$kode)) {
			return $this->$kode("$itim");
			//return $this->$kode("$itim");
			//echo $kode.'('.$itim.'=false)';
			//exit;
		}
		return $this->error;
	}

	
	function TSPERFM_01(){
		$this->dbseth = $this->_ci->load->database('hrd', true);
		$sqlmain="select raw.actual_finish,raw.assignTime,so.input_date,so.commentType from hrd.ss_raw_problems raw 
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
			raw.requestor not in ('".$this->nippemohon."') AND raw.pic like '%".$this->nippemohon."%' AND
			#interval waktu penilaian
			raw.actual_finish between '".$this->date1."' AND '".$this->date2."'
			group by (raw.id)
			";
		$sqlmain="SELECT z.id,z.problem_subject, z.date_posted,z.assignTime,z.actual_start,z.startDuration,z.input_date,z.commentType, z.vType, z.solution_id,z.actual_finish 
			FROM (SELECT a.id,b.solution_id,a.problem_subject, a.date_posted, 
			Case when a.approveDate is not null then a.approveDate 
			When a.assignTime is not null then a.assignTime 
			else a.date_posted end 
			assignTime, a.actual_start,b.startDuration,b.input_date,b.commentType,b.vType,iGrp_activity_id, a.actual_finish 
			FROM ss_raw_problems a JOIN ss_solution b ON b.id = a.id JOIN ss_activity_type c on c.activity_id = a.activity_id 
			WHERE #pic nip pengusul dan requestor bukan nip pengusul 
			a.requestor not in ('".$this->nippemohon."') and a.posted_by not in ('".$this->nippemohon."')
			AND a.pic like '%".$this->nippemohon."%'
			#interval waktu penilaian 
			AND DATE(a.actual_finish) between '".$this->date1."' AND '".$this->date2."' 
			AND CASE WHEN (SELECT assign FROM ss_support_type WHERE typeId=a.typeId)='Y' 
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
			FROM ss_raw_problems a 
			JOIN ss_solution b ON b.id = a.id 
			JOIN ss_activity_type c on c.activity_id = a.activity_id 
			WHERE #pic nip pengusul dan requestor bukan nip pengusul 
			a.requestor not in ('".$this->nippemohon."') and a.posted_by not in ('".$this->nippemohon."')
			AND a.pic like '%".$this->nippemohon."%' 
			#interval waktu penilaian 
			AND DATE(a.actual_finish) between '".$this->date1."' AND '".$this->date2."' AND (b.commentType = 50) 
			#Activity Type-Client CPU Instalasi 
			AND a.activity_id = 224 AND (b.isDeleted = 0 OR b.isDeleted IS NULL) 
			) AS z 
			GROUP BY z.id, z.vType 
			ORDER BY z.date_posted,z.solution_id";
		$qsqlmain=$this->dbseth->query($sqlmain);
		$calcDetail = new calcDetail();	
		if($qsqlmain->num_rows>=1){
			$dtmain=$qsqlmain->result_array();
			//cek untuk $this->selisihHari($this->date1, $this->date2, $this->nippemohon)
			//kebalik
			$selisih=array();
			$row=0;
			foreach ($dtmain as $kmain => $vmain) {
				$date_posted = $vmain['date_posted'];
				//$assignTime = $vmain['assignTime'];
				$actual_start = $vmain['actual_start'];
				//$start_def = (empty($assignTime))?$date_posted:$assignTime;
				//$tstart = (empty($vmain['startDuration']))?$start_def:$vmain['startDuration'];
				$s=$this->selisihHari($date_posted, $vmain['actual_finish'], $this->nippemohon,'minute');
				$selisih[]=number_format($s/1440, 2, '.', '' );
				$row++;
			}
			$hasil=array_sum($selisih)/count($selisih);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('TSPERFM_01', $hasil);
			//$hasil=$this->selisihHari('2016-12-12 08:08:01','2016-12-13 08:08:00',$this->nippemohon);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());
		}else{
			$score=100;
			$hasil=0;
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());
		}
	}
	function TSPERFM_02(){
		$this->dbseth = $this->_ci->load->database('hrd', true);
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
			raw.requestor not in ('".$this->nippemohon."') AND raw.pic like '%".$this->nippemohon."%' AND
			#interval waktu penilaian
			raw.actual_finish between '".$this->date1."' AND '".$this->date2."'";
		$sqlmain="
			SELECT z.id,z.problem_subject, z.date_posted,z.assignTime,z.actual_start,z.startDuration,z.input_date,z.commentType, z.vType, z.solution_id,z.actual_finish,z.iSLARate 
				FROM (SELECT a.id,b.solution_id,a.problem_subject, a.date_posted, 
				Case when a.approveDate is not null then a.approveDate 
				When a.assignTime is not null then a.assignTime 
				else a.date_posted end 
				assignTime, a.actual_start,b.startDuration,b.input_date,b.commentType,b.vType,iGrp_activity_id, a.actual_finish , c.iSLARate
				FROM hrd.ss_raw_problems a JOIN hrd.ss_solution b ON b.id = a.id 
				JOIN hrd.ss_activity_type c on c.activity_id = a.activity_id 
				WHERE #pic nip pengusul dan requestor bukan nip pengusul 
				a.requestor not in ('".$this->nippemohon."') 
				AND a.pic like '%".$this->nippemohon."%'
				#interval waktu penilaian 
				AND DATE(a.actual_finish) between '".$this->date1."' AND '".$this->date2."'
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
				a.requestor not in ('".$this->nippemohon."') 
				AND a.pic like '%".$this->nippemohon."%'
				#interval waktu penilaian 
				AND DATE(a.actual_finish) between '".$this->date1."' AND '".$this->date2."' #AND (b.commentType = 50) 
				#bukan module
				AND c.isModule='N' 
				#SLA yes
				AND c.isSLA='Y'   
				#Activity Type-Client CPU Instalasi 
				AND (b.isDeleted = 0 OR b.isDeleted IS NULL) 
				) AS z 
				GROUP BY z.id, z.vType 
				ORDER BY z.date_posted,z.solution_id
		";
		//return array('score'=>20,'hasil'=>$sqlmain);exit();
		$qsqlmain=$this->dbseth->query($sqlmain);
		$calcDetail = new calcDetail();
		if($qsqlmain->num_rows>=1){
			$dtmain=$qsqlmain->result_array();
			$mem=0; //memenuhi syarat
			$row=0;
			foreach ($dtmain as $kmain => $vmain) {
				$takhir= date('Y-m-d H:i:s', strtotime($vmain['actual_finish']));
				$tawal= date('Y-m-d H:i:s', strtotime($vmain['actual_start']));
				$selisih=$this->selisihHari($tawal,$takhir,$this->nippemohon,'minute');
				$durasi=$selisih;
				$rate=$vmain['iSLARate'];
				/*if ($rate!=0&&$durasi!=0){
					$nilai[]=$rate/$durasi*100; //Rate di bagi durasi antara actual start dan mark finish
				}elseif($rate==0){
					$nilai[]=0;
				}elseif($durasi==0){
					$nilai[]=0;
				}*/
				if($rate>=$durasi){ //Cek Apabila rate SLA kurang dari durasi pengerjaan - by minute
					$mem++;
				}
				$row++;
			}
			$hasil=0;
			if($row != 0 and $mem !=0){
				$hasil=$mem/$row*100;
			}
				
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('TSPERFM_02', $hasil);
			return array('score'=>$score,'hasil'=>$hasil." %",'detail'=>$calcDetail->output());
		}else{
			return array('score'=>20,'hasil'=>'0','detail'=>$calcDetail->output());
		}
	}
	function TSPERFM_03(){
		$this->dbseth = $this->_ci->load->database('hrd', true);
		$sqlmain="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
			where 
			#raw ldeleted
			raw.Deleted='No' AND
			#activity type Maintenance Server dari virus dan Junk data user yang tidak berhubungan dengan kantor
			raw.activity_id=221 AND
			#status SS telah finish
			raw.taskStatus='Finish' AND
			#pic nip pengusul dan requestor bukan nip pengusul
			raw.requestor not in ('".$this->nippemohon."') AND raw.pic like '%".$this->nippemohon."%' AND
			#interval waktu penilaian
			raw.tMarkedAsFinished between '".$this->date1."' AND '".$this->date2."'
			ORDER BY raw.satisfaction_value DESC
			LIMIT 6
			";
		$qsqlmain=$this->dbseth->query($sqlmain);
		if($qsqlmain->num_rows>=1){
			$dtmain=$qsqlmain->result_array();
			//cek untuk $this->selisihHari($this->date1, $this->date2, $this->nippemohon)
			$selisih=0;
			$row=0;
			foreach ($dtmain as $kmain => $vmain) {
				$satis[]=$vmain['satisfaction_value'];
				$row++;
			}
			$hasil=0;
			if(array_sum($satis)!=0){
				//if count < 6 
				$hasil=array_sum($satis)/6;
			}
			$calcDetail = new calcDetail();	
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('TSPERFM_03', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());
		}else{
			return array('score'=>20,'hasil'=>'0');
		}
	}
	function TSPERFM_04(){
		$this->dbseth = $this->_ci->load->database('hrd', true);
		$sqlmain="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
			where 
			#raw ldeleted
			raw.Deleted='No' AND
			#activity type Maintenance - Cek & Update Account Email dan LDAP
			raw.activity_id=222 AND
			#status SS telah finish
			raw.taskStatus='Finish' AND
			#pic nip pengusul dan requestor bukan nip pengusul
			raw.requestor not in ('".$this->nippemohon."') AND raw.pic like '%".$this->nippemohon."%' AND
			#interval waktu penilaian
			raw.tMarkedAsFinished between '".$this->date1."' AND '".$this->date2."'
			ORDER BY raw.satisfaction_value DESC
			LIMIT 6";
		$qsqlmain=$this->dbseth->query($sqlmain);
		if($qsqlmain->num_rows>=1){
			$dtmain=$qsqlmain->result_array();
			//cek untuk $this->selisihHari($this->date1, $this->date2, $this->nippemohon)
			$selisih=0;
			$row=0;
			foreach ($dtmain as $kmain => $vmain) {
				$satis[]=$vmain['satisfaction_value'];
				$row++;
			}
			$hasil=0;
			if(array_sum($satis)!=0){
				$hasil=array_sum($satis)/6;
			}
			$calcDetail = new calcDetail();	
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('TSPERFM_03', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());
		}else{
			return array('score'=>20,'hasil'=>'0');
		}
	}
	function TSPERFM_05(){
		return array('score'=>'manual','hasil'=>0);
	}
	function TSPERFM_06(){
		return array('score'=>'manual','hasil'=>0);
	}
	function TSPERFM_07(){
		$this->dbseth = $this->_ci->load->database('hrd', true);
		$sqlmain="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
			where 
			#raw ldeleted
			raw.Deleted='No' AND
			#activity type Maintenance-Update data inventaris di GLPI dan OCS
			raw.activity_id=223 AND
			#status SS telah finish
			raw.taskStatus='Finish' AND
			#pic nip pengusul dan requestor bukan nip pengusul
			raw.requestor not in ('".$this->nippemohon."') AND raw.pic like '%".$this->nippemohon."%' AND
			#interval waktu penilaian
			raw.tMarkedAsFinished between '".$this->date1."' AND '".$this->date2."
			ORDER BY raw.satisfaction_value DESC
			LIMIT 6'";
		$qsqlmain=$this->dbseth->query($sqlmain);
		if($qsqlmain->num_rows>=1){
			$dtmain=$qsqlmain->result_array();
			//cek untuk $this->selisihHari($this->date1, $this->date2, $this->nippemohon)
			$selisih=0;
			$row=0;
			foreach ($dtmain as $kmain => $vmain) {
				$satis[]=$vmain['satisfaction_value'];
				$row++;
			}
			$hasil=0;
			if(array_sum($satis)!=0){
				$hasil=array_sum($satis)/6;
			}
			$calcDetail = new calcDetail();	
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('TSPERFM_03', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());
		}else{
			return array('score'=>20,'hasil'=>'0');
		}
	}
	function TSPERFM_08(){
		$this->dbseth = $this->_ci->load->database('hrd', true);

		//Menentukan Task yang finish
		$sql1 = "SELECT b.id FROM  hrd.ss_raw_problems b 
				#mengambil task finish dan satisfaction gx null
				WHERE b.`taskStatus` ='Finish' AND b.`satisfaction_value` IS NOT NULL AND b.Deleted='No' 
				AND b.`finishing_by` IS NOT NULL 
				#not requested
				AND b.requestor NOT IN ('".$this->nippemohon."') 
				AND b.pic LIKE '%".$this->nippemohon."%' AND 
				b.tMarkedAsFinished BETWEEN '".$this->date1."' AND '".$this->date2."'";
		$qsqlmain1=$this->dbseth->query($sql1);

		//Mencari Task Finish tapi pernah Unfinish
		if($qsqlmain1->num_rows>0){
			$re = $qsqlmain1->result_array();
			$pembagi = 0;
			foreach ($re as $r => $value) {
				$sq = "SELECT so.commentType FROM hrd.`ss_solution` so WHERE so.commentType IN (5) AND so.id ='".$value['id']."'";
				$ss=$this->dbseth->query($sq);
				if($ss->num_rows>0){
					$pembagi++;
				}
			}
			// Rumus (Unfinish/TaskFinis) * 100

			$Taskfinis = $qsqlmain1->num_rows;
			$Unfinish = $pembagi;
			$c = new calcDetail();
			$hasil = ($Unfinish/$Taskfinis) * 100 ;
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('TSPERFM_08', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());

		}else{
			$c = new calcDetail();
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('TSPERFM_08', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}
	}

	function TSPERFM_09(){
		return array('score'=>'manual','hasil'=>0);
	}
	/*
	function TSPERFM_09(){
		$this->dbseth = $this->_ci->load->database('hrd', true);
		$sqlmain="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
			where 
			#raw ldeleted
			raw.Deleted='No' AND
			#activity type Maintenance - Daily/Weekly/Monthly 
			raw.activity_id=227 AND
			#status SS telah finish
			raw.taskStatus='Finish' AND
			#pic nip pengusul dan requestor bukan nip pengusul
			raw.requestor not in ('".$this->nippemohon."') AND raw.pic like '%".$this->nippemohon."%' AND
			#interval waktu penilaian
			raw.tMarkedAsFinished between '".$this->date1."' AND '".$this->date2."'
			ORDER BY raw.satisfaction_value DESC
			LIMIT 6";
		$qsqlmain=$this->dbseth->query($sqlmain);
		if($qsqlmain->num_rows>=1){
			$dtmain=$qsqlmain->result_array();
			//cek untuk $this->selisihHari($this->date1, $this->date2, $this->nippemohon)
			$selisih=0;
			$row=0;
			foreach ($dtmain as $kmain => $vmain) {
				$satis[]=$vmain['satisfaction_value'];
				$row++;
			}
			$hasil=0;
			if(array_sum($satis)!=0){
				$hasil=array_sum($satis)/6;
			}
			$calcDetail = new calcDetail();	
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('TSPERFM_09', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());
		}else{
			return array('score'=>20,'hasil'=>'0');
		}
	}*/
	function TSPERFM_10(){
		$this->dbseth = $this->_ci->load->database('hrd', true);


		#QUERY SAMA DENGAN PK PROGRAMMER
		$sqlmain="SELECT z.id,z.problem_subject, z.date_posted,z.assignTime, 
			z.actual_start,z.startDuration,z.input_date,z.commentType,
			z.vType, z.solution_id FROM (
			SELECT a.id,b.solution_id,a.problem_subject, a.date_posted, CASE WHEN a.approveDate IS NOT NULL THEN a.approveDate
				WHEN a.assignTime IS NOT NULL THEN a.assignTime  ELSE a.date_posted END assignTime,
							a.actual_start,b.startDuration,b.input_date,b.commentType,
							b.vType
							FROM ss_raw_problems a 
							JOIN `ss_solution` b ON b.id = a.id
							WHERE 
							#Bukan Req
							a.requestor NOT IN ('".$this->nippemohon."') 
							AND a.pic LIKE '%".$this->nippemohon."%'
							#AND a.parent_id != 0
							AND DATE(a.date_posted) BETWEEN '".$this->date1."' AND '".$this->date2."'
							AND CASE WHEN (SELECT assign FROM ss_support_type WHERE typeId=a.typeId)='Y'
							    THEN (b.commentType = 2) END
							#AND a.activity_id != 22
							AND b.pic LIKE '%".$this->nippemohon."%'
							AND (b.isDeleted = 0 OR b.isDeleted IS NULL)
			UNION
			SELECT a.id,b.solution_id,a.problem_subject, a.date_posted,	CASE WHEN a.approveDate IS NOT NULL THEN a.approveDate
				WHEN a.assignTime IS NOT NULL THEN a.assignTime  ELSE a.date_posted END assignTime,
							a.actual_start,b.startDuration,b.input_date,b.commentType,
							b.vType
							FROM ss_raw_problems a 
							JOIN ss_solution b ON b.id = a.id
							WHERE 
							#Bukan Req
							a.requestor NOT IN ('".$this->nippemohon."') 
							AND a.pic LIKE '%".$this->nippemohon."%'
							#AND a.parent_id != 0
							AND DATE(a.date_posted) BETWEEN '".$this->date1."' AND '".$this->date2."'
							AND b.commentType = 50
							#AND a.activity_id != 22
							AND b.pic LIKE '%".$this->nippemohon."%'
							AND (b.isDeleted = 0 OR b.isDeleted IS NULL)
		) AS z
		GROUP BY z.id, z.vType
		ORDER BY z.date_posted,z.solution_id";

		$qsqlmain=$this->dbseth->query($sqlmain);

		if($qsqlmain->num_rows>=1){
			$dtmain=$qsqlmain->result_array();
			$row = 0 ;
			foreach ($dtmain as $kmain => $vmain) {

				$id = $vmain['id'];
				$subject = $vmain['problem_subject'];
				
				$date_posted = $vmain['date_posted'];
				$assignTime = $vmain['assignTime'];
				$actual_start = $vmain['actual_start'];


				if( $vmain['vType'] == 'Joblog' ) {
					$start_duration = (empty($assignTime)||strtotime($assignTime)<strtotime($date_posted))?$date_posted:$assignTime;
					$input_date = $vmain['startDuration'];
				} else {
					$start_def = (empty($assignTime))?$date_posted:$assignTime;
					$start_duration = (empty($vmain['startDuration']))?$start_def:$vmain['startDuration'];					
					$input_date = $vmain['input_date'];
				}
				
				$selisih=($this->selisihJam($start_duration, $input_date, $this->nippemohon)) *24*3600;
				
                $time = (strtotime($input_date)-strtotime($start_duration)) - $selisih;

				if($time <=0){
					$durasi = 0;
				}else{
					$durasi = number_format( $time/3600, 2, '.', '' ) ;
				}
				$row += $durasi;
			}
			$hasil=$row/$qsqlmain->num_rows;
			$calcDetail = new calcDetail();	
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('TSPERFM_10', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());
		}else{
			return array('score'=>20,'hasil'=>'-');
		}
	}

	function TSPERFM_11(){
		$this->dbseth = $this->_ci->load->database('hrd', true);
		

		//Total Absensi Telat
		$sql1 = "SELECT b.cin, b.`dAbsensi` FROM hrd.`msabsen` b 
				WHERE b.`cin` > '08:00:00' AND b.cin !=''
				AND b.cNip LIKE '%".$this->nippemohon."%' AND b.`dAbsensi` 
				BETWEEN '".$this->date1."' AND '".$this->date2."'";

 
		$qsqlmain1=$this->dbseth->query($sql1)->num_rows();

		$c = new calcDetail();
		if($qsqlmain1>=1){
			$hasil = number_format( $qsqlmain1, 0, '.', '' );
			$score = $this->getScore('TSPERFM_11', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 0, '.', '' );
			$score = $this->getScore('TSPERFM_11', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}
	}
	function TSPERFM_12(){
		$this->dbseth = $this->_ci->load->database('hrd', true);
		$sql1 = "SELECT * FROM hrd.dshift da
					INNER JOIN hrd.gshift gs ON da.iShiftID=gs.iShiftID
					INNER JOIN hrd.employee em ON em.igshiftid=gs.iGShiftID
					WHERE em.cNip='".$this->nippemohon."' AND (da.ciIn!='00:00:00' OR da.ciEnd!='00:00:00')";
		// Cek Area
		//$sql1 ="SELECT a.`iArea` FROM hrd.employee a WHERE a.`cNip`='".$this->nippemohon."'";
		$qsqlmain1 = $this->dbseth->query($sql1);
			
		$dtmain=$qsqlmain1->num_rows();

		if($dtmain==5){
			$cout ="18:00:00";
		}else{
			$cout ="17:00:00";
		}

		$sql2 = "SELECT DISTINCT
				(
				SELECT COUNT(*) FROM hrd.msabsen aa
				WHERE aa.cNip = '".$this->nippemohon."'
				AND MONTH(aa.dAbsensi)=MONTH(a.dAbsensi )
				# AND YEAR(aa.dAbsensi)=2016
				AND aa.cout>'".$cout."' AND aa.`cout` <> ':  :' AND aa.`cout` != '' AND aa.dAbsensi BETWEEN '".$this->date1."' AND '".$this->date2."'
				) 
					AS piket, MONTH(a.dAbsensi) AS bln
					FROM hrd.msabsen a
					WHERE a.cNip='".$this->nippemohon."'

					# AND month(a.dAbsensi)=12

					AND a.dAbsensi BETWEEN '".$this->date1."' AND '".$this->date2."'

					# AND YEAR(a.dAbsensi)=2016

					GROUP BY MONTH(a.dAbsensi)";

		$qsqlmain2 = $this->dbseth->query($sql2);

		if($qsqlmain2->num_rows>0){
			$dtmain1=$qsqlmain2->result_array();
			$tot=0;
			foreach ($dtmain1 as $kmain => $vmain) {
				if($vmain['piket']>=10){
					$tot += 100;
				}else if($vmain['piket']>=9){
					$tot += 80;
				}else if($vmain['piket']>=8){
					$tot += 60;
				}else if($vmain['piket']>=7){
					$tot += 40;
				}else{
					$tot += 20;
				}
			}
			$hasil=$tot/6;
			$calcDetail = new calcDetail();	
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('TSPERFM_12', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());
		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			return array('score'=>20,'hasil'=>$hasil);
		}
		
	}
	function TSPERFM_13(){
		return array('score'=>'manual','hasil'=>0);
	}
	/*function TSPERFM_13(){
		$this->dbseth = $this->_ci->load->database('hrd', true);
		$sqlmain="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
			where 
			#raw ldeleted
			raw.Deleted='No' AND
			#activity type Maintenance - Laporan Server Down
			raw.activity_id=229 AND
			#status SS telah finish
			#raw.taskStatus='Finish' AND
			#pic nip pengusul dan requestor bukan nip pengusul
			#raw.requestor not in ('".$this->nippemohon."') AND 
			raw.pic like '%".$this->nippemohon."%' AND
			#interval waktu penilaian
			raw.tMarkedAsFinished between '".$this->date1."' AND '".$this->date2."'
			ORDER BY raw.satisfaction_value DESC ";
		$qsqlmain=$this->dbseth->query($sqlmain);
		if($qsqlmain->num_rows>=1){
			//$dtmain=$qsqlmain->result_array();
			$hasil = $qsqlmain->num_rows();
			$calcDetail = new calcDetail();	
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('TSPERFM_13', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());
		}else{
			return array('score'=>20,'hasil'=>'0');
		}
	}*/
	function TSPERFM_15(){
		return array('score'=>'manual','hasil'=>0);
	}/*
	function TSPERFM_15(){
		$this->dbseth = $this->_ci->load->database('hrd', true);
		$sqlmain="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
			where 
			#raw ldeleted
			raw.Deleted='No' AND
			#activity type Maintenance - Kelengkapan Laporan Stock
			raw.activity_id=228 AND
			#status SS telah finish
			raw.taskStatus='Finish' AND
			#pic nip pengusul dan requestor bukan nip pengusul
			raw.requestor not in ('".$this->nippemohon."') AND raw.pic like '%".$this->nippemohon."%' AND
			#interval waktu penilaian
			raw.tMarkedAsFinished between '".$this->date1."' AND '".$this->date2."'
			ORDER BY raw.satisfaction_value DESC
			LIMIT 6";
		$qsqlmain=$this->dbseth->query($sqlmain);
		if($qsqlmain->num_rows>=1){
			$dtmain=$qsqlmain->result_array();
			//cek untuk $this->selisihHari($this->date1, $this->date2, $this->nippemohon)
			$selisih=0;
			$row=0;
			foreach ($dtmain as $kmain => $vmain) {
				$satis[]=$vmain['satisfaction_value'];
				$row++;
			}
			$hasil=0;
			if(array_sum($satis)!=0){
				$hasil=array_sum($satis)/6;
			}
			$calcDetail = new calcDetail();	
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('TSPERFM_15', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());
		}else{
			return array('score'=>20,'hasil'=>'0');
		}

	}*/
	function TSPERFM_16(){
		$this->dbseth = $this->_ci->load->database('hrd', true);
		$sqlmain="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
			where 
			#raw ldeleted
			raw.Deleted='No' AND
			#activity type Maintenance - Bandwith Monitoring 
			raw.activity_id=230 AND
			#status SS telah finish
			raw.taskStatus='Finish' AND
			#pic nip pengusul dan requestor bukan nip pengusul
			raw.requestor not in ('".$this->nippemohon."') AND raw.pic like '%".$this->nippemohon."%' AND
			#interval waktu penilaian
			raw.tMarkedAsFinished between '".$this->date1."' AND '".$this->date2."'
			ORDER BY raw.satisfaction_value DESC
			LIMIT 6";
		$qsqlmain=$this->dbseth->query($sqlmain);
		if($qsqlmain->num_rows>=1){
			$dtmain=$qsqlmain->result_array();
			//cek untuk $this->selisihHari($this->date1, $this->date2, $this->nippemohon)
			$selisih=0;
			$row=0;
			foreach ($dtmain as $kmain => $vmain) {
				$satis[]=$vmain['satisfaction_value'];
				$row++;
			}
			$hasil=0;
			if(array_sum($satis)!=0){
				$hasil=array_sum($satis)/6;
			}
			$calcDetail = new calcDetail();	
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('TSPERFM_16', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());
		}else{
			return array('score'=>20,'hasil'=>'0');
		}
	}
	function TSPERFM_14(){
		$this->dbseth = $this->_ci->load->database('hrd', true);
		$sql1 = "SELECT SUM(b.`satisfaction_value`) AS TOT 
				FROM  hrd.ss_raw_problems b WHERE b.`satisfaction_value` IS NOT NULL AND b.`satisfaction_value` > 0  AND  b.`taskStatus` = 'Finish'
				AND
				b.pic LIKE '".$this->nippemohon."' AND b.Deleted='No' and
				b.`tMarkedAsFinished` BETWEEN '".$this->date1."' AND '".$this->date2."'";
		$qsqlmain1=$this->dbseth->query($sql1)->row_array();

		$sql2 = "SELECT * FROM  hrd.ss_raw_problems b 
				WHERE b.`satisfaction_value` IS NOT NULL AND b.`satisfaction_value` > 0  AND  b.`taskStatus` = 'Finish' AND
				b.pic LIKE '".$this->nippemohon."' AND b.Deleted='No' AND
				b.`tMarkedAsFinished` BETWEEN '".$this->date1."' AND '".$this->date2."'";
		$qsqlmain2=$this->dbseth->query($sql2)->num_rows;

		$c = new calcDetail();
		if($qsqlmain1['TOT']>=1 && $qsqlmain2>=1){
			$hasil = $qsqlmain1['TOT']/$qsqlmain2;
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('TSPERFM_14', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('TSPERFM_14', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}
	}
	function TSPERFM_17(){
		return array('score'=>'manual','hasil'=>0);
	}
	function TSSIKAP(){
		return array('score'=>'manual','hasil'=>0);
	}

}

class calcDetail {
	public $tblHead;
	public $tblBody;
	public $nomor=0;
	public $tblAlign;
	public function setTblHead(){
		$numargs = func_num_args();
		$arg_list = func_get_args();
		
		$this->tblHead = '<tr><th>No.</th>';
		for ($i = 0; $i < $numargs; $i++) {
			$this->tblHead.='<th>'.$arg_list[$i].'</th>';
		}
		$this->tblHead .= '</tr>';
	}
	public function setTblBody(){
		$numargs = func_num_args();
		$arg_list = func_get_args();
		
		$this->nomor++;
		$nomor = $this->nomor;
		$css = ($nomor%2>0)?'background:#CCC':'#FFF';
		$this->tblBody .= '<tr style="'.$css.'"><td>'.$nomor.'</td>';
		for ($i = 0; $i < $numargs; $i++) {
			$align=isset($this->tblAlign[$i])?$this->tblAlign[$i]:'left';
			$this->tblBody.='<td align="'.$align.'">'.$arg_list[$i].'</td>';
		}
		$this->tblBody .= '</tr>';
	}
	public function setTblAlign(){
		$numargs = func_num_args();
		$arg_list = func_get_args();
		for($i = 0; $i< $numargs; $i++) {
			$this->tblAlign[$i]=$arg_list[$i];
		}
	}
	public function output() {
		$return = '<table cellspacing="0" cellpadding="4" border="1" rules="all">';
		$return.= '<thead>';
		$return.= $this->tblHead;
		$return.= '</thead>';
		$return.= '<tbody>';
		$return.= $this->tblBody;
		$return.= '</tbody>';
		$return.= '</table>';
		
		return $return;
	}
}