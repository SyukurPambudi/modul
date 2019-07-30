<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lib_calc {
	private $_ci;
	public $error;
	public $date1;
	public $date2;
	public $periode;
	public $nippemohon;
	public $imaster_id;
    public $ssid;

	public function __construct() {
		$this->_ci=& get_instance();
		$this->_ci->load->library('auth');

		$this->error = 'error';
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


    function getScorePO( $kode, $hasil ) {
		$this->db_erp_pk = $this->_ci->load->database('pk',false, true);

		$sql='select * from pk.pk_po_deskripsi b
				where b.ldeleted=0
				and b.ldeleted=0
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
		}
		return $this->error;
	}
	function setDateByPeriod($period=false) {
		if(!$period) return false;

		$periodnday = "01-".$period;
		//$this->date1 = $periodnday;
		//$this->date2 = date('d-m-Y', time());//date('t-m-Y',strtotime($periodnday));

		return true;
	}
	function SDMSIKAP(){
		return array('score'=>'manual','hasil'=>0);
	}
	function SDMPERFORMANCE(){
		return array('score'=>'manual','hasil'=>0);
	} 
	function SDMKEPEMIMPINAN(){
		return array('score'=>'manual','hasil'=>0);
	}  
	/*function SDMPO(){
		return array('score'=>'manual','hasil'=>0);
	}*/     
	function SDMPERFORMANCE_1(){
		$this->db_erp_pk = $this->_ci->load->database('pk',false, true);      
        
        //$datamaster=$this->getDetMaster($imaster_id);
        $year = date('Y', strtotime($this->date1));
        $month = date('M', strtotime($this->date1));
        $tgl1 = date($this->date1);
        $tgl2 = date($this->date2);          
        if( $month < 7){
            $semester = 1;
        }else{
            $semester = 2;
        }   
        
        $vNip = $this->nippemohon;
                      
        $sqlmain = "Select distinct a.id, a.problem_subject, a.iSizeProject, a.dclosePm  
                from hrd.ss_raw_problems a
                inner join  hrd.ss_raw_pic b on a.id = b.rawid and b.pic = '".$vNip."' and iRoleId = 1
                where a.dClosePm between '".$tgl1."' and '".$tgl2."' and b.Deleted = 'No' and
                iStatus = 13 ";   

        //where a.cTahun =".$year." and a.cSemester = ".$semester." and b.Deleted = 'No' and 
                
		$data['sql']=$sqlmain;
		$qsqlmain = $this->db_erp_pk->query($sqlmain);
        
		if($qsqlmain->num_rows>=1){
			$dtmain=$qsqlmain->result_array();
			//cek untuk $this->selisihHari($this->date1, $this->date2, $this->nippemohon)
			$selisih=0;
			$row=0;
            $x=0;
			foreach ($dtmain as $kmain => $vmain) {
				$x=$x + $vmain['iSizeProject'];
				$row++;
			}
			$hasil=$x;
			$calcDetail = new calcDetail();	
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('SDMPERFORMANCE_1', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());
		}else{
			return array('score'=>20,'hasil'=>'0');
		}
	}
	function SDMPERFORMANCE_2(){
		$this->db_erp_pk = $this->_ci->load->database('pk',false, true);
        //$datamaster=$this->getDetMaster($imaster_id);
        $year = date('Y', strtotime($this->date1));
        $month = date('M', strtotime($this->date1));
        $tgl1 = date($this->date1);
        $tgl2 = date($this->date2);          
        if( $month < 7){
            $semester = 1;
        }else{
            $semester = 2;
        }         
        
        $vNip = $this->nippemohon;
        
        $sqlmain = 
                "Select distinct a.id, a.problem_subject, a.iSizeProject, date(a.dclosePm) dclosePm ,
                 c.cStatus, a.dTarget_implement,
                	CASE when date(a.dclosePm) > date(a.dTarget_implement) then 'Ya'
                		else 'Tidak' end status
                 from hrd.ss_raw_problems a
                 inner join  hrd.ss_raw_pic b on a.id = b.rawid and b.pic = '".$vNip."' and iRoleId = 1
                 left outer join hrd.ss_project_status c on c.id = a.iStatus
                 where a.dClosePm between '".$tgl1."' and '".$tgl2."' and b.Deleted = 'No' and
                 iStatus = 13  ";  

        //where a.cTahun =".$year." and a.cSemester = ".$semester." and b.Deleted = 'No' and   
        //iStatus not in (1,2,8,9,11)  ";                
		$data['sql']=$sqlmain;
		$qsqlmain = $this->db_erp_pk->query($sqlmain);
        
		if($qsqlmain->num_rows>=1){
			$dtmain=$qsqlmain->result_array();
			//cek untuk $this->selisihHari($this->date1, $this->date2, $this->nippemohon)
			$selisih=0;
			$row=0;
            $x=0;
            $y=0;
			foreach ($dtmain as $kmain => $vmain) {
				if($vmain['status']=='Ya'){
				    $y++;
				}
				$x++;
			}
			$hasil=($y/$x)*100;
			$calcDetail = new calcDetail();	
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('SDMPERFORMANCE_2', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());
		}else{
			return array('score'=>20,'hasil'=>'0');
		}
	}   
    
	function SDMPERFORMANCE_3(){
		$this->db_erp_pk = $this->_ci->load->database('pk',false, true);
        //$datamaster=$this->getDetMaster($imaster_id);
        $year = date('Y', strtotime($this->date1));
        $month = date('M', strtotime($this->date1));
        $tgl1 = date($this->date1);
        $tgl2 = date($this->date2);        
        if( $month < 7){
            $semester = 1;
        }else{
            $semester = 2;
        }         
        
        $vNip = $this->nippemohon;
        
        $sqlmain =                 
            "select a.iCommitId, a.iSvnId,d.vName as appname,  a.vAuthor,c.vName, b.vFile, 
            sum(b.iLOC)loc, a.tCommit, MONTH(a.tCommit) Bulan
            from hrd.svn_commit_header a
            left outer join hrd.svn_commit_detail b on a.iCommitId = b.iCommitId
            left outer join hrd.employee c on a.vAuthor = c.cNip
            left outer join hrd.svn_info d on d.iSvnId = a.iSvnId
            where a.tCommit between '".$tgl1."' and '".$tgl2."' 
                and a.vAuthor = '".$vNip."'
                and b.vFile not in (select cd.vFile from hrd.svn_commit_detail cd
            	inner join hrd.svn_exclude  b on substr(cd.vFile,1,length(Trim(b.vFile))) = Trim(b.vFile))
            group by  a.iCommitId, a.iSvnId, a.vAuthor, c.vName, d.vName, b.vFile,a.tCommit";  
                
		$data['sql']=$sqlmain;
		$qsqlmain = $this->db_erp_pk->query($sqlmain);
        
		if($qsqlmain->num_rows>=1){
			$dtmain=$qsqlmain->result_array();
			//cek untuk $this->selisihHari($this->date1, $this->date2, $this->nippemohon)
			$selisih=0;
			$row=0;
            $x=0;
            $loc=0;
			foreach ($dtmain as $kmain => $vmain) {
                $loc = $loc + $vmain['loc'];
				$x++;
			}
			$hasil=$loc;
			$calcDetail = new calcDetail();	
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('SDMPERFORMANCE_3', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());
		}else{
			return array('score'=>20,'hasil'=>'0');
		}
	}        

	function SDMPERFORMANCE_4(){
		$this->db_erp_pk = $this->_ci->load->database('pk',false, true);
        //$datamaster=$this->getDetMaster($imaster_id);
        $year = date('Y', strtotime($this->date1));
        $month = date('M', strtotime($this->date1));
        $tgl1 = date($this->date1);
        $tgl2 = date($this->date2);        
        if( $month < 7){
            $semester = 1;
        }else{
            $semester = 2;
        }         
        
        $vNip = $this->nippemohon;
        
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
		$qsqlmain = $this->db_erp_pk->query($sqlmain);
        
		if($qsqlmain->num_rows>=1){
			$dtmain=$qsqlmain->result_array();
			//cek untuk $this->selisihHari($this->date1, $this->date2, $this->nippemohon)
			$selisih=0;
			$row=0;
            $x=0;
            $loc=0;
			foreach ($dtmain as $kmain => $vmain) {
                $loc = $loc + $vmain['N_SIZE'];
				$x++;
			}
			$hasil=$loc;
			$calcDetail = new calcDetail();	
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('SDMPERFORMANCE_4', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());
		}else{
			return array('score'=>20,'hasil'=>'0');
		}
	}    
	function SDMPERFORMANCE_5(){
		$this->db_erp_pk = $this->_ci->load->database('pk',false, true);
        //$datamaster=$this->getDetMaster($imaster_id);
        $year = date('Y', strtotime($this->date1));
        $month = date('M', strtotime($this->date1));
        $tgl1 = date($this->date1);
        $tgl2 = date($this->date2);        
        if( $month < 7){
            $semester = 1;
        }else{
            $semester = 2;
        }         
        
        $vNip = $this->nippemohon;
        
        $bawah = $this->getInferior($vNip);
        //echo $bawah;
        //exit;
        $sqlmain =
		"select min(loc)loc from (select a.vAuthor,c.vName, sum(b.iLOC)/6 loc
			from hrd.svn_commit_header a
			left outer join hrd.svn_commit_detail b on a.iCommitId = b.iCommitId
			left outer join hrd.employee c on a.vAuthor = c.cNip
			where a.tCommit between '".$tgl1."' and '".$tgl2."' and
			a.vAuthor in ('" . implode("','", $bawah) . "')	group by a.vAuthor)as hasil";

		$data['sql']=$sqlmain;
		$qsqlmain = $this->db_erp_pk->query($sqlmain);
        
		if($qsqlmain->num_rows>=1){
			$dtmain=$qsqlmain->result_array();
			foreach ($dtmain as $kmain => $vmain) {
				$loc =  $vmain['loc'];
			}
			$hasil=$loc;
			$calcDetail = new calcDetail();	
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('SDMPERFORMANCE_5', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());
		}else{
			return array('score'=>20,'hasil'=>'0');
		}
	}    

	function getInferior($superior='', $type = '1',$datecustom=false){
		$CI=& get_instance();
		//$MIS_MANAGER = $CI->session->userdata('mis_manager');
		$arrProperties = array();
		if(!$superior) return false;
		//if(in_array($superior)) {
			$arrProperties[] = $superior;
		//}
		
		$bawahan = $this->get_child($superior,$datecustom);
		$bawExp = explode(",", $bawahan);
		$arrayBawahan = array();
		foreach($bawExp as $b){
			if(strlen($b)>3) {
				if(!in_array($b,$arrProperties)){
					if($type == '1'){
						$arrProperties[] = $b;
					}else{
						$properties = $this->get_properties($b);
						$exp = explode('^', $properties);
						$a1 = array('nip'=>$b,'nama'=>capital_name($exp[1], '1'),'iPostId'=>$exp[6]);
						array_push($arrProperties, $a1);
					}
				}
			}
		}
		return $arrProperties;
	} 
	function get_child($nip,$datecustom=false,$monthyear=false){

		$CI=& get_instance();
		$this->db_erp_pk = $this->_ci->load->database('pk',false, true);
		$r = $this->get_childs($nip,$datecustom,$monthyear);
		$today = ($datecustom)?"$datecustom":"".date("Y-m-d")."";
		$child = '';
		foreach($r as $v){
                    if ($monthyear) {
                        $date1 = date('Y-m-01',strtotime($today));
                        $date2 = date('Y-m-t',strtotime($today));
                        $active = (($v['dResign'] >= $date1 && $v['dResign'] <= $date2) || $v['dResign']=='0000-00-00');
                    } else {
                        $active = ($v['dResign']=='0000-00-00' || $v['dResign'] >= $today);
                    }
		    
                    if ($active) $child = $child.$v['cNip'].',';
                    if($v['child'])$child .= $this->get_child($v['cNip'],$datecustom,$monthyear);
		}
		return $child;
	}	

	function get_childs($nip,$date=false,$monthyear=false){
		$sql="SELECT e.cNip, e.dResign, (SELECT COUNT(cNip) FROM employee WHERE cUpper=e.cNip) AS child
				  FROM employee e 
					  WHERE e.cUpper='$nip'";
		
		return $this->db_erp_pk->query($sql)->result_array();	
	}      
	function get_properties($nip){
		$query = "SELECT vNickName nick,vName name,IFNULL(vEmail,'') email,iDivisionID dept,
                iDepartementID divisi,iWorkArea, csex, iPostId FROM employee
                WHERE cNip='".trim($nip)."'";

		$sql = $this->db_erp_pk->query($query );
		$e = ($sql->num_rows()==0) ? $nip.'^'.$nip.'^ ^0^0^' : $sql->row()->nick.'^'.$sql->row()->name.'^'.$sql->row()->email.'^'.$sql->row()->dept.'^'.$sql->row()->iWorkArea.'^'.$sql->row()->csex.'^'.$sql->row()->iPostId.'^'.$sql->row()->divisi;
		return $e;
	} 
    
	function SDMPO(){
	    $this->db_erp_pk = $this->_ci->load->database('pk',false, true); 
	    $ssid = $this->ssid;
        $vNip = $this->nippemohon;

        $sqlmain =
		"Select * from hrd.ss_raw_problems where id =".$ssid;

		$data['sql']=$sqlmain;
		$qsqlmain = $this->db_erp_pk->query($sqlmain);
        
		if($qsqlmain->num_rows>=1){
			$dtmain=$qsqlmain->result_array();
			foreach ($dtmain as $kmain => $vmain) {
				$tglawal =  $vmain['dTarget_implement'];
   	            $tglakhir =  $vmain['dclosePm'];
                
			}
			$hasil=$this->selisihHari($tglawal, $tglakhir, $vNip);
            //echo $hasil;
			$calcDetail = new calcDetail();	
			$hasil = number_format( $hasil, 2, '.', '' );
			if(is_null($tglakhir)){
				$score = "20";
				$hasil = NULL;
			}else{
				$score = $this->getScorePO('SDMPO', $hasil);
			}

			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());
		}else{
			return array('score'=>20,'hasil'=>'0');
		}
	}        
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