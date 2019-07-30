<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class calc_bd2 {
	private $_ci;
	public $error;
	public $date1;
	public $date2;
	public $periode;
	public function __construct() {
		$this->_ci=& get_instance();
		$this->_ci->load->library('auth');
		$this->db_erp_pk = $this->load->database('pk', false,true);
		
		$this->error = 'error';
	}

	public function selisihbulan($date1,$date2){
		$arrdate1=explode('-',date_format($date1,"Y-m-d"));
		$arrdate2=explode('-',date_format($date2,"Y-m-d"));
		$sisa=0;
		/*Edit Date 1*/
		$sumdate1=$arrdate1[0]*12+$arrdate1[1];
		$sumdate2=$arrdate2[0]*12+$arrdate2[1];

		$sisa=intval($sumdate1)-intval($sumdate2);
		$min=-1;
		$sisa=$sisa<0?$sisa*$min:$sisa;
		return intval($sisa);
	}

	public  function selisihbulan1(\DateTime $date1, \DateTime $date2)
    {
	    $diff =  $date1->diff($date2);

	    $months = $diff->y * 12 + $diff->m + $diff->d / 30;

	    return (int) floor($months);
    }

    public function selisihminggu($startDate,$endDate,$day_number=1){
    	if($startDate > $endDate){
    		$tgl1=$startDate;
    		$tgl2=$endDate;
    		$startDate=$tgl2;
    		$endDate=$tgl1;
    	}
		$endDate = strtotime($endDate);
		$days=array('1'=>'Monday','2' => 'Tuesday','3' => 'Wednesday','4'=>'Thursday','5' =>'Friday','6' => 'Saturday','7'=>'Sunday');
		for($i = strtotime($days[$day_number], strtotime($startDate)); $i <= $endDate; $i = strtotime('+1 week', $i))
		$date_array[]=date('Y-m-d',$i);

		return count($date_array);
	}

    public  function selisihminggu1(\DateTime $date1, \DateTime $date2)
    {
	    $diff =  $date1->diff($date2);

	    $weak = ($diff->y * 12 + $diff->m + $diff->d / 30) * 4;

	    return (int) $weak;
    }
	function setDateByPeriod($period=false) {
		if(!$period) return false;
		
		$periodnday = "01-".$period;
		//$this->date1 = $periodnday;
		//$this->date2 = date('d-m-Y', time());//date('t-m-Y',strtotime($periodnday));
		
		return true;
	}
	function getScore( $kode, $hasil ) {
		$this->db_erp_pk = $this->load->database('pk', false,true);
		
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

	function BD2_1($itim=false){
		
		$sql='SELECT COUNT(DISTINCT(u.`iGroup_produk`)) as jml FROM plc2.`plc2_upb` u 
			JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
			JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
			WHERE u.`ldeleted` = 0 
			AND u.tinfo_paten IS NOT NULL
			AND u.tinfo_paten !=""
			AND u.`iteambusdev_id` = '.$this->itim.'
			AND ua.`vtipe` = "DR"
			AND ua.`iapprove` = 2
			AND ua.`tupdate` >= "'.$this->date1.'" 
			AND ua.`tupdate` <= "'.$this->date2.'"'; 

		$c = new calcDetail();
		$da = $this->db_erp_pk->query($sql)->row_array();
		if($da['jml']>0){
			$hasil = $da['jml'];
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_1', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_1', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}
		
	}

	function BD2_2($itim=false){
		 $sqlp1='SELECT COUNT(u.`iupb_id`) As t_upb FROM plc2.`plc2_upb` u 
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
            JOIN plc2.plc2_upb_team ut on ut.iteam_id = u.iteammarketing_id
            WHERE u.`ldeleted` = 0 
            AND u.tinfo_paten IS NOT NULL
            AND u.tinfo_paten !=""
            AND u.iteammarketing_id IS NOT NULL
            AND u.`iteambusdev_id` = "'.$this->itim.'"
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            AND ua.`tupdate` >= "'.$this->date1.'" 
			AND ua.`tupdate` <= "'.$this->date2.'"';  


        $sqlp2='SELECT COUNT(DISTINCT(u.iteammarketing_id)) as t_Mark FROM plc2.`plc2_upb` u 
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
            JOIN plc2.plc2_upb_team ut on ut.iteam_id = u.iteammarketing_id
            WHERE u.`ldeleted` = 0 
            AND u.tinfo_paten IS NOT NULL
            AND u.tinfo_paten !=""
            AND u.iteammarketing_id IS NOT NULL
            AND u.`iteambusdev_id` = "'.$this->itim.'"
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            AND ua.`tupdate` >= "'.$this->date1.'" 
			AND ua.`tupdate` <= "'.$this->date2.'"
            and u.iteammarketing_id in (29,8)
            ';  

		//Menghitung JumLAH upb (A)
		// $sqlp2='SELECT COUNT(u.`iupb_id`) As t_upb FROM plc2.`plc2_upb` u 
		// 	JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`  
		// 	WHERE u.`ldeleted` = 0 
		// 	AND u.tinfo_paten IS NOT NULL
		// 	AND u.tinfo_paten !=""
		// 	AND u.`iteambusdev_id` = "'.$this->itim.'"
		// 	AND u.iteammarketing_id IS NOT NULL
		// 	AND ua.`vtipe` = "DR"
		// 	AND ua.`iapprove` = 2
		// 	AND ua.`tupdate` >= "'.$this->date1.'" 
		// 	AND ua.`tupdate` <= "'.$this->date2.'"
		// 	';

		// //Menghitung Jumalah Divisi Marketing (B)
		// $sqlp2='SELECT COUNT(DISTINCT(u.iteammarketing_id)) As t_Mark FROM plc2.`plc2_upb` u 
		// 	JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
		// 	JOIN plc2.plc2_upb_team ut on ut.iteam_id = u.iteammarketing_id
		// 	WHERE u.`ldeleted` = 0 
		// 	AND u.tinfo_paten IS NOT NULL
		// 	AND u.iteammarketing_id IS NOT NULL
		// 	AND u.tinfo_paten !=""
		// 	AND u.`iteambusdev_id` = "'.$this->itim.'"
		// 	AND ua.`vtipe` = "DR"
		// 	AND ua.`iapprove` = 2
		// 	AND ua.`tupdate` >= "'.$this->date1.'" 
		// 	AND ua.`tupdate` <= "'.$this->date2.'"
		// 	and u.iteammarketing_id in (29,8)';
 

		$c = new calcDetail();
		$upb = $this->db_erp_pk->query($sqlp1)->row_array(); 
		$mar = $this->db_erp_pk->query($sqlp2)->row_array();
		if($mar){
			if($mar['t_Mark']>0){
				$hasil = $upb['t_upb']/$mar['t_Mark'];  // (A)/(B)
				$hasil = number_format( $hasil, 2, '.', '' );
				$score = $this->getScore('BD2_2', $hasil);
				return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
			}else{
				$hasil = number_format(0);
				$hasil = number_format( $hasil, 2, '.', '' );
				$score = $this->getScore('BD2_2', $hasil);
				return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
			}
		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_2', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}


		/*$calcDetail = new calcDetail();
		$sql_par = '
					select 
					count(a.iupb_id) jum
					from plc2.plc2_upb a 
					join plc2.plc2_upb_approve b on b.iupb_id=a.iupb_id and b.vtipe="DR"
					where 
					 a.ldeleted=0
					#upb team nya 
					and a.iteambusdev_id="'.$this->itim.'"
					#upb sudah diapprove
					and a.iappdireksi=2 
					and b.iapprove=2
					#tgl approval masuk periode PK
					and b.tupdate >= "'.$this->date1.'"
					and b.tupdate <= "'.$this->date2.'"
					and a.iteammarketing_id in (29,8)
				';
		// pembagi hanya marketing ogB dan Beta, jadi hanya 2
		$pembagi = 2;
		$dupb = $this->db_erp_pk->query($sql_par)->row_array();

		if($dupb['jum'] > 0) {
			$hasil = $dupb['jum'];
			$hasil = number_format(($dupb['jum']/$pembagi ),2);

			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_2', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_2', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}*/
	}

	function BD2_3($itim=false){
		$sqlp1='SELECT COUNT(u.`iupb_id`) As t_upb1 FROM plc2.`plc2_upb` u 
			JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
			JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
			WHERE u.`ldeleted` = 0 
			AND u.tinfo_paten IS NOT NULL
			AND u.tinfo_paten !=""
			AND u.`iteambusdev_id` = "'.$this->itim.'"
			AND ua.`vtipe` = "DR"
			AND ua.`iapprove` = 2
			AND ua.`tupdate` >= "'.$this->date1.'" 
			AND ua.`tupdate` <= "'.$this->date2.'"
			AND u.`ikategoriupb_id` = 10 
			';

		 //Menghitung JumLAH upb (B) Sesuai Parameter 1
		$sqlp2='SELECT COUNT(u.`iupb_id`) As t_upb2 FROM plc2.`plc2_upb` u 
			JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
			JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
			WHERE u.`ldeleted` = 0 
			AND u.tinfo_paten IS NOT NULL
			AND u.tinfo_paten !=""
			AND u.`iteambusdev_id` = "'.$this->itim.'"
			AND ua.`vtipe` = "DR"
			AND ua.`iapprove` = 2
			AND ua.`tupdate` >= "'.$this->date1.'" 
			AND ua.`tupdate` <= "'.$this->date2.'"
			';

		$c = new calcDetail();
		$upb1 = $this->db_erp_pk->query($sqlp1)->row_array(); 
		$upb2 = $this->db_erp_pk->query($sqlp2)->row_array();
		if($upb2){
			if($upb2['t_upb2']>0){
				$hasil = $upb1['t_upb1']/$upb2['t_upb2']*100;  // (A)/(B)
				$hasil = number_format( $hasil, 2, '.', '' );
				$score = $this->getScore('BD2_3', $hasil);
				return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
			}else{
				$hasil = number_format(0);
				$hasil = number_format( $hasil, 2, '.', '' );
				$score = $this->getScore('BD2_3', $hasil);
				return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
			}
		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_3', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}

		
		/*$calcDetail = new calcDetail();
		$sql_par = '
					select 
					count(a.iupb_id) jum
					from plc2.plc2_upb a 
					join plc2.plc2_upb_approve b on b.iupb_id=a.iupb_id and b.vtipe="DR"
					where 
					 a.ldeleted=0
					#upb team nya 
					and a.iteambusdev_id="'.$this->itim.'"
					#upb sudah diapprove
					and a.iappdireksi=2 
					and b.iapprove=2
					#tgl approval masuk periode PK
					and b.tupdate >= "'.$this->date1.'"
					and b.tupdate <= "'.$this->date2.'"
					#kategori UPB A
					#and a.ikategoriupb_id in (10)
					
				';
				//echo $sql_par;

		$sql_par2 = '
					select 
					count(a.iupb_id) jum
					from plc2.plc2_upb a 
					join plc2.plc2_upb_approve b on b.iupb_id=a.iupb_id and b.vtipe="DR"
					where 
					 a.ldeleted=0
					#upb team nya 
					and a.iteambusdev_id="'.$this->itim.'"
					#upb sudah diapprove
					and a.iappdireksi=2 
					and b.iapprove=2
					#tgl approval masuk periode PK
					and b.tupdate >= "'.$this->date1.'"
					and b.tupdate <= "'.$this->date2.'"
					#kategori UPB All
					
				';
				//echo $sql_par2;
		// pembagi hanya marketing ogB dan Beta, jadi hanya 2
		
		$dupb = $this->db_erp_pk->query($sql_par)->row_array();
		$dupb2 = $this->db_erp_pk->query($sql_par2)->row_array();
		$pembagi = $dupb2['jum'];

		if($dupb['jum'] > 0) {
			$hasil = $dupb['jum'];
			$hasil = number_format(( ($dupb['jum']/$pembagi)*100 ),2);
			//$hasil = number_format(($dupb['jum']/$pembagi)*100);

			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_3', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_3', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}*/
	}	


	function BD2_3x($itim=false){
		//echo $itim;
		//exit;
		// get semester
		$now=date('m');
		switch ($now) {
			case '01':
			case '02':
			case '03': 
			case '04':
			case '05':
			case '06':
				$smester = 1;
				break;			
			case '07':
			case '08':
			case '09':
			case '10':
			case '11':
			case '12':
				$smester = 2;
				break;
			default:
				$smester = 1;
				break;
		}

		// get 2 years 
		$time_2 = strtotime("-2 year", time());
 		$date_2 = date("Y", $time_2);

 		// get 3 years 
		$time_3 = strtotime("-3 year", time());
 		$date_3 = date("Y", $time_3);

 		if ($smester == 1) {
 			$tahun = $date_3;
 			$imonth = 2;
 		}else{
 			$tahun = $date_2;
 			$imonth = 1;
 		}

 		$itim=$this->itim;
		$this->db_erp_pk = $this->load->database('pk', false,true);
		$sql_tim ='select a.vteam,iteam_id from plc2.plc2_upb_team a where a.ldeleted=0 and a.iteam_id in ("'.$itim.'")';
		//echo $sql_tim;
		$qteam = $this->db_erp_pk->query($sql_tim)->row_array();
		$itim= $qteam['iteam_id'];

		//Modify Semester 4 lalu
 		$tgl2=$this->date2;
    	$d=$this->getSemester($tgl2,FALSE);
    	$y=$d['tahun'];
    	$semester=$d['semester'];

		$calcDetail = new calcDetail();
		$sql_par = 'select 
					count(distinct(a.iupb_id)) jum
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					where 
					#upb team nya 
						a.iteambusdev_id="'.$itim.'" 
					#upb sudah diapprove
						and a.iappdireksi=2 
					and a.iteammarketing_id <> 0 
					and a.iteammarketing_id is not null
					and a.ikategori_id <> 0 
					#ini misal jenis kategori A
					and a.ikategoriupb_id in (10)
					and a.ldeleted=0
					and b.ldeleted=0
					and c.ldeleted=0';

		//$sql_par .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= concat(YEAR(NOW()) , month(NOW()) ) ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= 'order by a.iupb_id desc';
		//echo $sql_par;

		// jumlah tim marketing 
		$sql_par2 = 'select 
					count(distinct(a.iupb_id)) as penyebut
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					where 
					#upb team nya 
						a.iteambusdev_id="'.$itim.'" 
					#upb sudah diapprove
						and a.iappdireksi=2 
					and a.iteammarketing_id <> 0 
					and a.iteammarketing_id is not null
					and a.ikategori_id <> 0 
					#ini misal jenis kategori 1 dan 2
					and a.ldeleted=0
					and b.ldeleted=0
					and c.ldeleted=0';

		//$sql_par2 .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par2 .=' and  concat(c.iyear,c.imonth) <= concat(YEAR(NOW()) , month(NOW()) ) ';
		$sql_par2 .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par2 .= 'order by a.iupb_id desc';
		//echo $sql_par;
		$dcount = $this->db_erp_pk->query($sql_par2)->row_array();

		$dupb = $this->db_erp_pk->query($sql_par)->row_array();
		if($dupb['jum'] > 0) {
			$hasil = $dupb['jum'];

			$hasil = number_format(($dupb['jum']/$dcount['penyebut']) ,2);
			$hasil = $hasil*100;
			//$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_3', $hasil);

			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_3', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
		//return array('score'=>20,'hasil'=>0);
		//return $nilai;
	}

	function BD2_4($itim=false){
		$calcDetail = new calcDetail();
		$sql_par = 'select a.*,a.tsubmit_prareg,c.tappbusdev from plc2.plc2_upb a 
					join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR"
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					#Filter Deleted
					where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0
					#upb team nya 
					and a.iteambusdev_id="'.$this->itim.'" 
					#Tanggal Prareg not null
					and a.tsubmit_prareg is not null
					#Tanggal Approve BDM not NUll
					and c.tappbusdev is not null
					#Tanggal app dir not null
					and a.iappdireksi = 2 and app.tupdate is not null
					#periode tanggal prareg
					and a.tsubmit_prareg >= "'.$this->date1.'"
					and a.tsubmit_prareg <= "'.$this->date2.'"
					group by a.iupb_id
				';
		$qupb = $this->db_erp_pk->query($sql_par);
		if($qupb->num_rows() > 0) {
			$sumsel=array();
			foreach ($qupb->result_array() as $r => $vrupb) {
				$tglprareg=date_create($vrupb['tsubmit_prareg']);
				$tglprio=date_create($vrupb['tappbusdev']);
				$sumsel[]=$this->selisihbulan($tglprareg,$tglprio);
			}
			$hasil1=intval(array_sum($sumsel))/$qupb->num_rows();

			$hasil = number_format( $hasil1, 2, '.', '' );
			$score = $this->getScore('BD2_4', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_4', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
	}

	function BD2_5($itim=false){
		$calcDetail = new calcDetail();
		$sql_par = 'select a.*,a.tsubmit_prareg,c.tappbusdev,kat.vkategori,a.ikategori_id,app.tupdate 
				from plc2.plc2_upb a 
				join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" and app.vmodule="AppUPB-DR"
				join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
				join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id 
				join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategori_id
				#Filter Deleted 
				where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0 and kat.ldeleted=0
				#upb team nya 
				and a.iteambusdev_id="'.$this->itim.'" 
				#Tanggal Prareg not null 
				and a.tsubmit_prareg is not null 
				#Tanggal Approve BDM not NUll 
				and c.tappbusdev is not null 
				#Tanggal app dir not null 
				and a.iappdireksi = 2 and app.tupdate is not null 
				#Kategori UPB A
				and a.ikategori_id=10
				#periode tanggal 
				and app.tupdate >= "'.$this->date1.'" 
				and app.tupdate <= "'.$this->date2.'" 
				group by a.iupb_id 
				';
		$qupb = $this->db_erp_pk->query($sql_par);
		if($qupb->num_rows() > 0) {
			$hasil=intval($qupb->num_rows());
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_5', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_5', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
	}

	function BD2_6($itim=false){
		$calcDetail = new calcDetail();
		$sql_par = 'select a.*,a.tsubmit_prareg,a.ttarget_hpr 
				from plc2.plc2_upb a 
				join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
				join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
				join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id 
				#Filter Deleted 
				where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0 
				#upb team nya 
				and a.iteambusdev_id="'.$this->itim.'" 
				#Tanggal Prareg not null 
				and a.tsubmit_prareg is not null 
				#Tanggal Approve BDM not NUll 
				and c.tappbusdev is not null 
				#Tanggal HPR Not NULl 
				and a.ttarget_hpr is not null 
				#Kategori UPB A
				and a.ikategori_id=10
				#Tanggal app dir not null 
				and a.iappdireksi = 2 and app.tupdate is not null 
				#periode tanggal prareg 
				and a.ttarget_hpr >= "'.$this->date1.'" 
				and a.ttarget_hpr <= "'.$this->date2.'" 
				group by a.iupb_id
				';
		//return array('score'=>$sql_par,'hasil'=>0,'detail'=>$calcDetail->output());exit();
		$qupb = $this->db_erp_pk->query($sql_par);
		if($qupb->num_rows() > 0) {
			$sumsel=array();
			foreach ($qupb->result_array() as $r => $vrupb) {
				$tgl1=date_create($vrupb['ttarget_hpr']);
				$tgl2=date_create($vrupb['tsubmit_prareg']);
				$sumsel[]=$this->selisihbulan($tgl1,$tgl2);
			}
			$hasil1=intval(array_sum($sumsel))/$qupb->num_rows();

			$hasil = number_format( $hasil1, 2, '.', '' );
			$score = $this->getScore('BD2_6', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			//Jika Tidak ada UPB Sama Sekali
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_6', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
	}

	function BD2_7($itim=false){
		$calcDetail = new calcDetail();
		$sql_par = 'select a.*,a.tregistrasi,a.ttarget_hpr 
				from plc2.plc2_upb a 
				join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
				join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
				join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id 
				#Filter Deleted 
				where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0 
				#upb team nya 
				and a.iteambusdev_id="'.$this->itim.'" 
				#Tanggal HPR Not NULl 
				and a.ttarget_hpr is not null 
				#Tanggal Registrasi Not Null
				and a.tregistrasi is not null
				#Kategori UPB A 
				and a.ikategori_id=10 
				#Tanggal app dir not null 
				and a.iappdireksi = 2 and app.tupdate is not null
				#periode tanggal prareg 
				and a.tregistrasi >= "'.$this->date1.'" 
				and a.tregistrasi <= "'.$this->date2.'" 
				group by a.iupb_id
				';
		//return array('score'=>$sql_par,'hasil'=>0,'detail'=>$calcDetail->output());exit();
		$qupb = $this->db_erp_pk->query($sql_par);
		if($qupb->num_rows() > 0) {
			$sumsel=array();
			foreach ($qupb->result_array() as $r => $vrupb) {
				/*$tgl1=date_create($vrupb['tregistrasi']);
				$tgl2=date_create($vrupb['ttarget_hpr']);*/

				$tgl1=$vrupb['tregistrasi'];
				$tgl2=$vrupb['ttarget_hpr'];
				$sumsel[]=$this->selisihminggu($tgl1,$tgl2);
			}
			$hasil1=intval(array_sum($sumsel))/$qupb->num_rows();

			$hasil = number_format( $hasil1, 2, '.', '' );
			$score = $this->getScore('BD2_7', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_7', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
	}

	function BD2_8($itim=false){
		$calcDetail = new calcDetail();
		$sql_par = 'select 
				#group distinct karena hanya mengambil jumlah group produk 
				count(distinct(a.iGroup_produk)) jum
				#a.dinput_applet,a.*
				from plc2.plc2_upb a 
				join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
				join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
				join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk
	            #Filter Deleted 
	            where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0
				#upb team nya 
				and a.iteambusdev_id="'.$this->itim.'" 
				#Tanggal Applet Not NULl 
				and a.dinput_applet is not null 
				#Kategori UPB A 
				and a.ikategori_id=10 
				#Tanggal app dir not null 
				and a.iappdireksi = 2 and app.tupdate is not null 
				#periode tanggal prareg 
				and a.dinput_applet >= "'.$this->date1.'" 
				and a.dinput_applet <= "'.$this->date2.'"  
				';
		//return array('score'=>$sql_par,'hasil'=>0,'detail'=>$calcDetail->output());exit();
		$qupb = $this->db_erp_pk->query($sql_par);
		if($qupb->num_rows() > 0) {

			$dr=$qupb->row_array();

			$hasil = number_format( $dr['jum'], 2, '.', '' );
			$score = $this->getScore('BD2_8', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_8', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
	}

	function BD2_9($itim=false){
		$calcDetail = new calcDetail();
		$sql_par = 'select 
				#group distinct karena hanya mengambil jumlah group produk 
				count(distinct(a.iGroup_produk)) jum
				#a.dinput_applet,a.*
				from plc2.plc2_upb a 
				join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
				join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
				join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk
	            #Filter Deleted 
	            where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0
				#upb team nya 
				and a.iteambusdev_id="'.$this->itim.'" 
				#Tanggal Applet Not NULl 
				and a.dinput_applet is not null 
				#Kategori UPB B 
				and a.ikategori_id=11 
				#Tanggal app dir not null 
				and a.iappdireksi = 2 and app.tupdate is not null 
				#periode tanggal prareg 
				and a.dinput_applet >= "'.$this->date1.'" 
				and a.dinput_applet <= "'.$this->date2.'"  
				';
		//return array('score'=>$sql_par,'hasil'=>0,'detail'=>$calcDetail->output());exit();
		$qupb = $this->db_erp_pk->query($sql_par);
		if($qupb->num_rows() > 0) {
			$dr=$qupb->row_array();

			$hasil = number_format( $dr['jum'], 2, '.', '' );
			$score = $this->getScore('BD2_9', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_9', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
	}

	function BD2_10($itim=false){
		$calcDetail = new calcDetail();
		$sql_par = 'select a.*,a.dinput_applet,a.tregistrasi 
				from plc2.plc2_upb a 
				join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
				join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
				join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id 
				#Filter Deleted 
				where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0 
				#upb team nya 
				and a.iteambusdev_id="'.$this->itim.'" 
				#Tanggal Applet Not NULl 
				and a.dinput_applet is not null 
				#Tanggal Registrasi Not Null
				and a.tregistrasi is not null
				#Kategori UPB A 
				and a.ikategori_id=10 
				#Tanggal app dir not null 
				and a.iappdireksi = 2 and app.tupdate is not null
				#periode tanggal prareg 
				and a.dinput_applet >= "'.$this->date1.'" 
				and a.dinput_applet <= "'.$this->date2.'" 
				group by a.iupb_id
				';
		//return array('score'=>$sql_par,'hasil'=>0,'detail'=>$calcDetail->output());exit();
		$qupb = $this->db_erp_pk->query($sql_par);
		if($qupb->num_rows() > 0) {
			$sumsel=array();
			foreach ($qupb->result_array() as $r => $vrupb) {
				$tgl1=date_create($vrupb['dinput_applet']);
				$tgl2=date_create($vrupb['tregistrasi']);
				$sumsel[]=$this->selisihbulan($tgl1,$tgl2);
			}
			$hasil1=intval(array_sum($sumsel))/$qupb->num_rows();

			$hasil = number_format( $hasil1, 2, '.', '' );
			$score = $this->getScore('BD2_10', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_10', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
	}

	function BD2_11($itim=false){
		$calcDetail = new calcDetail();
		$sql_par = 'select a.*,a.dinput_applet, 
			#Filter Dokumen Applet Dsubmit Not NUll and Last Update
			(select dap.dsubmit_dok from plc2.applet_dokumen dap where dap.lDeleted=0 and dap.dsubmit_dok is not null and dap.iupb_id=a.iupb_id order by dap.dsubmit_dok DESC limit 1) as dsubmit_dok
			from plc2.plc2_upb a 
			join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
			join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
			join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id 
			join plc2.applet_dokumen d on d.iupb_id=a.iupb_id
			#Filter Deleted 
			where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0 #and d.lDeleted=0
			#upb team nya 
			and a.iteambusdev_id="'.$this->itim.'" 
			#Tanggal HPR Not NULl 
			and a.dinput_applet is not null 
			#Kategori UPB B 
			and a.ikategori_id=11 
			#Tanggal app dir not null 
			and a.iappdireksi = 2 and app.tupdate is not null
			#periode tanggal prareg 
			and a.dinput_applet >= "'.$this->date1.'" 
			and a.dinput_applet <= "'.$this->date2.'"
			group by a.iupb_id
				';
		//return array('score'=>$sql_par,'hasil'=>0,'detail'=>$calcDetail->output());exit();
		$qupb = $this->db_erp_pk->query($sql_par);
		if($qupb->num_rows() > 0) {
			$sumsel=array();
			foreach ($qupb->result_array() as $r => $vrupb) {
				$tgl1=date_create($vrupb['dsubmit_dok']);
				$tgl2=date_create($vrupb['dinput_applet']);
				$sumsel[]=$this->selisihbulan1($tgl1,$tgl2);
			}
			$hasil1=intval(array_sum($sumsel))/$qupb->num_rows();

			$hasil = number_format( $hasil1, 2, '.', '' );
			$score = $this->getScore('BD2_10', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_10', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
	}

	function BD2_12(){
		// get semester
		return array('score'=>'manual','hasil'=>0);
	}

	function BD2_13(){
		$calcDetail = new calcDetail();
		$sql_par = 'SELECT cc.*,i.tReceived
					FROM kartu_call.call_card cc 
					JOIN gps_msg.inbox i on i.ID=cc.igpsm_id 
					WHERE cc.lDeleted = 0 
					AND cc.itarget_kunjungan_id = 5  
					AND cc.vNIP LIKE "%'.$this->nippemohon.'%"
					AND i.tReceived >= "'.$this->date1.'" 
					AND i.tReceived <= "'.$this->date2.'"
				';
		$tgl1=date_create($this->date2);
		$tgl2=date_create($this->date1);
		$sumsel=$this->selisihbulan($tgl1,$tgl2)+1;
		$qupb = $this->db_erp_pk->query($sql_par);
		//return array('score'=>$sumsel,'hasil'=>$qupb->num_rows(),'detail'=>$calcDetail->output());exit();
		if($qupb->num_rows() > 0) {
			$hasil1= $qupb->num_rows()/$sumsel;
			$hasil = number_format( $hasil1, 2, '.', '' );
			$score = $this->getScore('BD2_13', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_13', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
	}

	function BDPIMPIN(){ 
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP(){ 
		return array('score'=>'manual','hasil'=>0);
	}
	
	private function getSemester($date,$now1=FALSE){
    	$now=date('Y-m-d',strtotime($date));
    	$d = new DateTime($now);
    	$m=0;
    	$y=0;
    	$semester='01';
    	/*if($now1==FALSE){
    		$sm=0;
    		if($d->format('m')<=6){
				$sm=1;
			}elseif($d->format('m')>=7){
				$sm=2;
			}
    		if($sm==2){
				$d->modify( 'first day of -1 year' );
				$m=$d->format( 'm' )-6;
			}else{
				$d->modify( 'first day of -2 year' );
				$m=$d->format( 'm' )+6;
			}
			$y=$d->format('Y');
			if(intval($m)<=6){
				$semester='01';
			}elseif(intval($m)>=7){
				$semester='02';
			}
		}else{
			$m=$d->format( 'm' );
			$y=$d->format('Y');
		}*/
		$d->modify( 'first day of -2 year' );
		$m=$d->format( 'm' );
		$y=$d->format('Y');
		if(intval($m)<=6){
				$semester='01';
		}elseif(intval($m)>=7){
			$semester='02';
		}
		
		$data['tanggal']=$d->format( 'm' ).$d->format('Y').'-'.$date;
		$data['semester']=$semester;
		$data['tahun']=$y;
		return $data;
    }

}


