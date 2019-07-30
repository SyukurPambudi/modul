<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lib_calc_busdev {
	private $_ci;
	public $error;
	public $date1;
	public $date2;
	public $periode;
	public function __construct() {
		$this->_ci=& get_instance();
		$this->_ci->load->library('auth');
		
		$this->error = 'error';
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
				from plc2.pk_parameter a 
				join plc2.pk_parameter_detail b on b.iparameter_id=a.iparameter_id
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

 		//Modify Semester 4 lalu
 		$tgl2=$this->date2;
    	$d=$this->getSemester($tgl2,FALSE);
    	$y=$d['tahun'];
    	$semester=$d['semester'];

 		$itim=$this->itim;
		$this->db_erp_pk = $this->load->database('pk', false,true);
		$sql_tim ='select a.vteam,iteam_id from plc2.plc2_upb_team a where a.ldeleted=0 and a.iteam_id in ("'.$itim.'")';
		//echo $sql_tim;
		$qteam = $this->db_erp_pk->query($sql_tim)->row_array();
		$itim= $qteam['iteam_id'];



		$calcDetail = new calcDetail();
		$sql_par = 'select 
					#group distinct karena hanya mengambil jumlah group produk
					count(distinct(a.iGroup_produk)) jum 
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					where 
					#upb team nya 
						a.iteambusdev_id="'.$itim.'" 
					#upb sudah diapprove
						and a.iappdireksi=2 
					#info paten tidak null
						and a.tinfo_paten is not null
					and a.iteammarketing_id <> 0 
					and a.iteammarketing_id is not null
					and a.ldeleted=0
					and b.ldeleted=0
					and c.ldeleted=0';

		//$sql_par .=' and c.iyear="'.$tahun.'" and c.imonth = "'.$imonth.'" ';
		//$sql_par .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= concat(YEAR(NOW()) , month(NOW()) ) ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= 'order by a.iupb_id desc';
		//return array('score'=>$y,'hasil'=>$sql_par,'detail'=>$calcDetail->output());exit();
		//echo $sql_par;
		$dupb = $this->db_erp_pk->query($sql_par)->row_array();
		if($dupb['jum'] > 0) {
			$hasil = $dupb['jum'];
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_1', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_1', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
		//return array('score'=>20,'hasil'=>0);
		//return $nilai;
	}

	function BD2_2($itim=false){
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
					count(distinct(a.iteammarketing_id)) as penyebut
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
			$hasil = number_format($dupb['jum']/$dcount['penyebut']);

			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_2', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_2', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
		//return array('score'=>20,'hasil'=>0);
		//return $nilai;
	}


	function BD2_3($itim=false){
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
					sum(datediff(a.ttarget_prareg,date(d.tupdate))) as jum
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					join plc2.plc2_upb_approve d on d.iupb_id=a.iupb_id and d.vtipe="DR"
					where 
					#upb team nya 
						a.iteambusdev_id="'.$itim.'" 
					#upb sudah diapprove
						and a.iappdireksi=2 
					
					and a.ldeleted=0
					and b.ldeleted=0
					and c.ldeleted=0
					and a.iteammarketing_id <> 0 
					and a.iteammarketing_id is not null
					and d.tupdate is not null
					and a.ttarget_prareg is not null
					and a.ttarget_prareg <> "1970-01-01"
					and a.ttarget_prareg <> "0000-00-00"

					';

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
					join plc2.plc2_upb_approve d on d.iupb_id=a.iupb_id and d.vtipe="DR"
					where 
					#upb team nya 
						a.iteambusdev_id="'.$itim.'" 
					#upb sudah diapprove
						and a.iappdireksi=2 
					
					and a.ldeleted=0
					and b.ldeleted=0
					and c.ldeleted=0
					
					and a.iteammarketing_id <> 0 
					and a.iteammarketing_id is not null
					and d.tupdate is not null
					and a.ttarget_prareg is not null
					and a.ttarget_prareg <> "1970-01-01"
					and a.ttarget_prareg <> "0000-00-00"

					';

		//$sql_par2 .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par2 .=' and  concat(c.iyear,c.imonth) <= concat(YEAR(NOW()) , month(NOW()) ) ';
		$sql_par2 .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par2 .= 'order by a.iupb_id desc';
		//echo $sql_par;
		$dcount = $this->db_erp_pk->query($sql_par2)->row_array();

		$dupb = $this->db_erp_pk->query($sql_par)->row_array();
		if($dupb['jum'] > 0) {
			$hasil = $dupb['jum']/30;
			$hasil = number_format($dupb['jum']/$dcount['penyebut']);

			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_4', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_4', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
		//return array('score'=>20,'hasil'=>0);
		//return $nilai;
	}

	function BD2_5($itim=false){
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
					
					and a.ldeleted=0
					and b.ldeleted=0
					and c.ldeleted=0
					and a.iteammarketing_id <> 0 
					and a.iteammarketing_id is not null

					#ini misal jenis kategori A
					and a.ikategoriupb_id in (10)
					and a.ttarget_prareg is not null
					and a.ttarget_prareg <> "1970-01-01"
					and a.ttarget_prareg <> "0000-00-00"

					
					';

		//$sql_par .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= concat(YEAR(NOW()) , month(NOW()) ) ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= 'order by a.iupb_id desc';
		//echo $sql_par;


		$dupb = $this->db_erp_pk->query($sql_par)->row_array();
		if($dupb['jum'] > 0) {
			$hasil = $dupb['jum'];
			$hasil = number_format($dupb['jum']);

			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_5', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_5', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
		//return array('score'=>20,'hasil'=>0);
		//return $nilai;
	}

	function BD2_6($itim=false){
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
					and a.ldeleted=0
					and b.ldeleted=0
					and c.ldeleted=0

					and a.ttarget_prareg is not null
					and a.ttarget_prareg <> "1970-01-01"
					and a.ttarget_prareg <> "0000-00-00"

					';

		//$sql_par .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= concat(YEAR(NOW()) , month(NOW()) ) ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= 'order by a.iupb_id desc';
		//echo $sql_par;

		// jumlah tim marketing 
		$sql_par2 = 'select 
					count(distinct(a.iteammarketing_id)) as penyebut
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
					and a.ldeleted=0
					and b.ldeleted=0
					and c.ldeleted=0
					and a.ttarget_prareg is not null
					and a.ttarget_prareg <> "1970-01-01"
					and a.ttarget_prareg <> "0000-00-00"';

		//$sql_par2 .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par2 .=' and  concat(c.iyear,c.imonth) <= concat(YEAR(NOW()) , month(NOW()) ) ';
		$sql_par2 .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par2 .= 'order by a.iupb_id desc';
		//echo $sql_par;
		$dcount = $this->db_erp_pk->query($sql_par2)->row_array();

		$dupb = $this->db_erp_pk->query($sql_par)->row_array();
		if($dupb['jum'] > 0) {
			$hasil = $dupb['jum'];
			$hasil = number_format($dupb['jum']/$dcount['penyebut']);

			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_2', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_2', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
		//return array('score'=>20,'hasil'=>0);
		//return $nilai;
	}

	function BD2_7($itim=false){
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
					sum(datediff(date(a.ttarget_hpr),a.ttarget_prareg)) as jum
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					where 
					#upb team nya 
						a.iteambusdev_id="'.$itim.'" 
					#upb sudah diapprove
						and a.iappdireksi=2 
					
					and a.ldeleted=0
					and b.ldeleted=0
					and c.ldeleted=0
					and a.iteammarketing_id <> 0 
					and a.iteammarketing_id is not null

					#ini misal jenis kategori A
					and a.ikategoriupb_id in (10)
					and a.ttarget_hpr is not null
					and a.ttarget_hpr <> "1970-01-01"
					and a.ttarget_hpr <> "0000-00-00"
					and a.ttarget_prareg is not null
					and a.ttarget_prareg <> "1970-01-01"
					and a.ttarget_prareg <> "0000-00-00"

					';

		//$sql_par .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= concat(YEAR(NOW()) , month(NOW()) ) ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= 'order by a.iupb_id desc';
		//echo $sql_par;

		// jumlah tim marketing 
		$sql_par2 = 'select 
					count(a.iupb_id) as penyebut
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					where 
					#upb team nya 
						a.iteambusdev_id="'.$itim.'" 
					#upb sudah diapprove
						and a.iappdireksi=2 
					
					and a.ldeleted=0
					and b.ldeleted=0
					and c.ldeleted=0
					and a.iteammarketing_id <> 0 
					and a.iteammarketing_id is not null

					#ini misal jenis kategori A
					and a.ikategoriupb_id in (10)
					and a.ttarget_hpr is not null
					and a.ttarget_hpr <> "1970-01-01"
					and a.ttarget_hpr <> "0000-00-00"
					and a.ttarget_prareg is not null
					and a.ttarget_prareg <> "1970-01-01"
					and a.ttarget_prareg <> "0000-00-00"

					';

		//$sql_par2 .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par2 .=' and  concat(c.iyear,c.imonth) <= concat(YEAR(NOW()) , month(NOW()) ) ';
		$sql_par2 .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par2 .= 'order by a.iupb_id desc';
		//echo $sql_par;
		$dcount = $this->db_erp_pk->query($sql_par2)->row_array();

		$dupb = $this->db_erp_pk->query($sql_par)->row_array();
		if($dupb['jum'] > 0) {
			$hasil = round($dupb['jum']);
			//echo $hasil.'-';
			//echo $dcount['penyebut'];
			$hasil=number_format(( ($dupb['jum']/$dcount['penyebut']) / 30),2);
			//$hasil = number_format(($dupb['jum']/$dcount['penyebut']),2);
			//echo $hasil.'-';
			//$hasil = number_format( $hasil, 2, '.', '' );
			//echo $hasil.'-';
			$score = $this->getScore('BD2_7', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_7', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
		//return array('score'=>20,'hasil'=>0);
		//return $nilai;
	}

	function BD2_8($itim=false){
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
					sum(datediff(date(a.ttarget_reg),a.ttarget_hpr)) as jum
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					where 
					#upb team nya 
						a.iteambusdev_id="'.$itim.'" 
					#upb sudah diapprove
						and a.iappdireksi=2 
					
					and a.ldeleted=0
					and b.ldeleted=0
					and c.ldeleted=0
					and a.iteammarketing_id <> 0 
					and a.iteammarketing_id is not null

					#ini misal jenis kategori A
					and a.ikategoriupb_id in (10)
					and a.ttarget_hpr is not null
					and a.ttarget_hpr <> "1970-01-01"
					and a.ttarget_hpr <> "0000-00-00"
					and a.ttarget_reg is not null
					and a.ttarget_reg <> "1970-01-01"
					and a.ttarget_reg <> "0000-00-00"

					';

		//$sql_par .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= concat(YEAR(NOW()) , month(NOW()) ) ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= 'order by a.iupb_id desc';
		//echo $sql_par;

		// jumlah tim marketing 
		$sql_par2 = 'select 
					count(a.iupb_id) as penyebut
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					where 
					#upb team nya 
						a.iteambusdev_id="'.$itim.'" 
					#upb sudah diapprove
						and a.iappdireksi=2 
					
					and a.ldeleted=0
					and b.ldeleted=0
					and c.ldeleted=0
					and a.iteammarketing_id <> 0 
					and a.iteammarketing_id is not null

					#ini misal jenis kategori A
					and a.ikategoriupb_id in (10)
					and a.ttarget_hpr is not null
					and a.ttarget_hpr <> "1970-01-01"
					and a.ttarget_hpr <> "0000-00-00"
					and a.ttarget_reg is not null
					and a.ttarget_reg <> "1970-01-01"
					and a.ttarget_reg <> "0000-00-00"

					';

		//$sql_par2 .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par2 .=' and  concat(c.iyear,c.imonth) <= concat(YEAR(NOW()) , month(NOW()) ) ';
		$sql_par2 .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par2 .= 'order by a.iupb_id desc';
		//echo $sql_par;
		$dcount = $this->db_erp_pk->query($sql_par2)->row_array();

		$dupb = $this->db_erp_pk->query($sql_par)->row_array();
		if($dupb['jum'] > 0) {
			$hasil = $dupb['jum'];
			$hasil = number_format(($dupb['jum']/$dcount['penyebut']),2);
			$hasil = number_format(($hasil/7),2);
			//$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_8', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_8', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
		//return array('score'=>20,'hasil'=>0);
		//return $nilai;
	}

	function BD2_9($itim=false){
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
					#group distinct karena hanya mengambil jumlah group produk
					count(distinct(a.iGroup_produk)) jum 
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id

					where 
					#upb team nya 
						a.iteambusdev_id="'.$itim.'" 
					#upb sudah diapprove
						and a.iappdireksi=2 
					
					and a.ldeleted=0
					and b.ldeleted=0
					and c.ldeleted=0
					and a.iteammarketing_id <> 0 
					and a.iteammarketing_id is not null

					#ini misal jenis kategori A
					and a.ikategoriupb_id in (10)
					and a.tsubmit_dokapplet is not null
					and a.tsubmit_dokapplet <> "1970-01-01"
					and a.tsubmit_dokapplet <> "0000-00-00"

					
					';

		//$sql_par .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= concat(YEAR(NOW()) , month(NOW()) ) ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= 'order by a.iupb_id desc';
		//echo $sql_par;


		$dupb = $this->db_erp_pk->query($sql_par)->row_array();
		if($dupb['jum'] > 0) {
			$hasil = $dupb['jum'];
			$hasil = number_format($dupb['jum']);

			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_9', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_9', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
		//return array('score'=>20,'hasil'=>0);
		//return $nilai;
	}

	function BD2_10($itim=false){
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
					#group distinct karena hanya mengambil jumlah group produk
					count(distinct(a.iGroup_produk)) jum 
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id

					where 
					#upb team nya 
						a.iteambusdev_id="'.$itim.'" 
					#upb sudah diapprove
						and a.iappdireksi=2 
					
					and a.ldeleted=0
					and b.ldeleted=0
					and c.ldeleted=0
					and a.iteammarketing_id <> 0 
					and a.iteammarketing_id is not null

					#jenis kategori B
					and a.ikategoriupb_id in (11)
					and a.tsubmit_dokapplet is not null
					and a.tsubmit_dokapplet <> "1970-01-01"
					and a.tsubmit_dokapplet <> "0000-00-00"

					
					';

		//$sql_par .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= concat(YEAR(NOW()) , month(NOW()) ) ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= 'order by a.iupb_id desc';
		//echo $sql_par;


		$dupb = $this->db_erp_pk->query($sql_par)->row_array();
		if($dupb['jum'] > 0) {
			$hasil = $dupb['jum'];
			$hasil = number_format($dupb['jum']);

			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_10', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_10', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
		//return array('score'=>20,'hasil'=>0);
		//return $nilai;
	}

	function BD2_11($itim=false){
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
					sum(datediff(date(a.ttarget_noreg),a.ttarget_reg)) as jum
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					where 
					#upb team nya 
						a.iteambusdev_id="'.$itim.'" 
					#upb sudah diapprove
						and a.iappdireksi=2 
					
					and a.ldeleted=0
					and b.ldeleted=0
					and c.ldeleted=0
					and a.iteammarketing_id <> 0 
					and a.iteammarketing_id is not null

					#ini misal jenis kategori A
					and a.ikategoriupb_id in (10)

					and a.ttarget_noreg is not null
					and a.ttarget_noreg <> "1970-01-01"
					and a.ttarget_noreg <> "0000-00-00"

					and a.ttarget_reg is not null
					and a.ttarget_reg <> "1970-01-01"
					and a.ttarget_reg <> "0000-00-00"

					';

		//$sql_par .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= concat(YEAR(NOW()) , month(NOW()) ) ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= 'order by a.iupb_id desc';
		//echo $sql_par;

		// jumlah tim marketing 
		$sql_par2 = 'select 
					count(a.iupb_id) as penyebut
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					where 
					#upb team nya 
						a.iteambusdev_id="'.$itim.'" 
					#upb sudah diapprove
						and a.iappdireksi=2 
					
					and a.ldeleted=0
					and b.ldeleted=0
					and c.ldeleted=0
					and a.iteammarketing_id <> 0 
					and a.iteammarketing_id is not null

					#ini misal jenis kategori A
					and a.ikategoriupb_id in (10)

					and a.ttarget_noreg is not null
					and a.ttarget_noreg <> "1970-01-01"
					and a.ttarget_noreg <> "0000-00-00"
					
					and a.ttarget_reg is not null
					and a.ttarget_reg <> "1970-01-01"
					and a.ttarget_reg <> "0000-00-00"

					';

		//$sql_par2 .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par2 .=' and  concat(c.iyear,c.imonth) <= concat(YEAR(NOW()) , month(NOW()) ) ';
		$sql_par2 .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par2 .= 'order by a.iupb_id desc';
		//echo $sql_par2;
		$dcount = $this->db_erp_pk->query($sql_par2)->row_array();

		$dupb = $this->db_erp_pk->query($sql_par)->row_array();
		if($dupb['jum'] > 0) {
			$hasil = $dupb['jum'];
			//$hasil = number_format($dupb['jum']/$dcount['penyebut']);
			$hasil=number_format(( ($dupb['jum']/$dcount['penyebut']) / 30),2);
			//$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_11', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_11', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
		//return array('score'=>20,'hasil'=>0);
		//return $nilai;
	}

	function BD2_12($itim=false){
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
					sum(datediff(date(a.ttarget_noreg),  if(a.tTd_applet is not null,a.tTd_applet,a.ttarget_noreg )  )) as jum
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					where 
					#upb team nya 
						a.iteambusdev_id="'.$itim.'" 
					#upb sudah diapprove
						and a.iappdireksi=2 
					
					and a.ldeleted=0
					and b.ldeleted=0
					and c.ldeleted=0
					and a.iteammarketing_id <> 0 
					and a.iteammarketing_id is not null

					#ini misal jenis kategori B
					and a.ikategoriupb_id in (11)
					#NIE
					and a.ttarget_noreg is not null
					and a.ttarget_noreg <> "1970-01-01"
					and a.ttarget_noreg <> "0000-00-00"

					and a.ttarget_hpr <> "1970-01-01"
					and a.ttarget_hpr <> "0000-00-00"

					and a.tTd_applet <> "1970-01-01"
					and a.tTd_applet <> "0000-00-00"



					';

		//$sql_par .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= concat(YEAR(NOW()) , month(NOW()) ) ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= 'order by a.iupb_id desc';
		//echo $sql_par;

		// jumlah tim marketing 
		$sql_par2 = 'select 
					count(a.iupb_id) as penyebut
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					where 
					#upb team nya 
						a.iteambusdev_id="'.$itim.'" 
					#upb sudah diapprove
						and a.iappdireksi=2 
					
					and a.ldeleted=0
					and b.ldeleted=0
					and c.ldeleted=0
					and a.iteammarketing_id <> 0 
					and a.iteammarketing_id is not null

					#ini misal jenis kategori B
					and a.ikategoriupb_id in (11)
					#NIE
					and a.ttarget_noreg is not null
					and a.ttarget_noreg <> "1970-01-01"
					and a.ttarget_noreg <> "0000-00-00"

					and a.ttarget_hpr <> "1970-01-01"
					and a.ttarget_hpr <> "0000-00-00"

					and a.tTd_applet <> "1970-01-01"
					and a.tTd_applet <> "0000-00-00"
					';

		//$sql_par2 .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par2 .=' and  concat(c.iyear,c.imonth) <= concat(YEAR(NOW()) , month(NOW()) ) ';
		$sql_par2 .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par2 .= 'order by a.iupb_id desc';
		//echo $sql_par2;
		$dcount = $this->db_erp_pk->query($sql_par2)->row_array();

		$dupb = $this->db_erp_pk->query($sql_par)->row_array();
		if($dupb['jum'] > 0) {
			$hasil = $dupb['jum'];
		//	echo $hasil."-";
		//	echo $dcount['penyebut'];
			//$hasil = number_format($dupb['jum']/$dcount['penyebut']);
			$hasil=number_format(( ($dupb['jum']/$dcount['penyebut']) / 30),2);
			//echo $hasil."xx";
			//$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_12', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD2_12', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
		//return array('score'=>20,'hasil'=>0);
		//return $nilai;
	}

	function BD2_13(){
		// get semester
		return array('score'=>'manual','hasil'=>0);
	}

	function BD2_14(){

		return array('score'=>'manual','hasil'=>0);
	}


	//Busdev 1
	function BD1_1(){
		$tgl2=$this->date2;
    	$d=$this->getSemester($tgl2,FALSE);
    	$y=$d['tahun'];
    	$semester=$d['semester'];
    	$dn=$this->getSemester($tgl2,TRUE);
    	$yn=$dn['tahun'];
    	$semestern=$dn['semester'];

		$this->db_erp_pk = $this->load->database('pk', false,true);
		$itim=$this->itim;
		$sql_tim ='select * from plc2.plc2_upb_team where ldeleted=0 and iteam_id in ('.$itim.')';
		$qteam = $this->db_erp_pk->query($sql_tim)->row_array();
		$team_id= $qteam['iteam_id'];

		$sql="select count(distinct(up.iGroup_produk)) jml from plc2.plc2_upb_prioritas pr
				inner join plc2.plc2_upb_prioritas_detail prdet on pr.iprioritas_id=prdet.iprioritas_id
				inner join plc2.plc2_upb up on prdet.iupb_id=up.iupb_id
				where pr.ldeleted=0 and prdet.ldeleted=0 and up.iappdireksi=2
				#Informasi Hak Paten Tidak NULL
				AND up.tinfo_paten is not NULL
				AND up.tinfo_paten !=''
				#Sesuai Team Busdevnya
				AND up.iteambusdev_id=".$team_id."
				#UPB setting Prioritas yang sudah di approve
				AND pr.iappbusdev=2
				#UPB sudah setting Prioritas 4 Semester Lalu
				AND concat(pr.iyear,'0',pr.imonth) = ".$y.$semester;
		//$sql .="and pr.imonth=".$semester." and pr.iyear=".$y." and pr.iteambusdev_id=".$team_id;

		$c = new calcDetail();
		$da = $this->db_erp_pk->query($sql)->row_array();
		if($da['jml']>0){
			$hasil = $da['jml'];
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_1', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}

		return array('score'=>20,'hasil'=>0);
	}
	function BD1_2(){
		$tgl2=$this->date2;
    	$d=$this->getSemester($tgl2,FALSE);
    	$y=$d['tahun'];
    	$semester=$d['semester'];
    	$dn=$this->getSemester($tgl2,TRUE);
    	$yn=$dn['tahun'];
    	$semestern=$dn['semester'];

		$this->db_erp_pk = $this->load->database('pk', false,true);
		$iteam_id = $this->itim;
		$sql_tim ='select * from plc2.plc2_upb_team where ldeleted=0 and iteam_id in ('.$iteam_id.')';
		$qteam = $this->db_erp_pk->query($sql_tim)->row_array();
		$team_id= $qteam['iteam_id'];

		$sql="select count(distinct(up.iupb_id)) jml from plc2.plc2_upb_prioritas pr
				inner join plc2.plc2_upb_prioritas_detail prdet on pr.iprioritas_id=prdet.iprioritas_id
				inner join plc2.plc2_upb up on prdet.iupb_id=up.iupb_id
				left join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=up.ikategoriupb_id
				where pr.ldeleted=0 and prdet.ldeleted=0 and up.iappdireksi=2
				#kategori yang aktif
				#and kat.ldeleted=0
				#Sesuai Team Busdevnya
				AND up.iteambusdev_id=".$team_id."
				#UPB setting Prioritas yang sudah di approve
				AND pr.iappbusdev=2
				#UPB sudah setting Prioritas 4 Semester Lalu
				AND concat(pr.iyear,'0',pr.imonth) = ".$y.$semester;
		$sql2 =$sql;
		$sql2.='#kategori UPB A
				AND up.ikategoriupb_id=10';

		$c = new calcDetail();
		$dall = $this->db_erp_pk->query($sql)->row_array();
		$dasel = $this->db_erp_pk->query($sql2)->row_array();
		if($dasel){
			if($dasel['jml']>0){
				$hasil = number_format($dasel['jml']/$dall['jml']*100);
				$hasil = number_format( $hasil, 2, '.', '' );
				$score = $this->getScore('BD1_2', $hasil);
				return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
			}else{
				$hasil = number_format(0);
				$hasil = number_format( $hasil, 2, '.', '' );
				$score = $this->getScore('BD1_2', $hasil);
				return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
			}
		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_2', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}
	}
	function BD1_3(){
		$tgl2=$this->date2;
    	$d=$this->getSemester($tgl2,FALSE);
    	$y=$d['tahun'];
    	$semester=$d['semester'];
    	$dn=$this->getSemester($tgl2,TRUE);
    	$yn=$dn['tahun'];
    	$semestern=$dn['semester'];

		$this->db_erp_pk = $this->load->database('pk', false,true);
		$iteam_id = $this->itim;
		$sql_tim ='select * from plc2.plc2_upb_team where ldeleted=0 and iteam_id in ('.$iteam_id.')';
		$qteam = $this->db_erp_pk->query($sql_tim)->row_array();
		$team_id= $qteam['iteam_id'];

		$sql="select count(distinct(up.iupb_id)) jml from plc2.plc2_upb_prioritas pr
				inner join plc2.plc2_upb_prioritas_detail prdet on pr.iprioritas_id=prdet.iprioritas_id
				inner join plc2.plc2_upb up on prdet.iupb_id=up.iupb_id
				left join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=up.ikategoriupb_id
				where pr.ldeleted=0 and prdet.ldeleted=0 and up.iappdireksi=2
				#kategori yang aktif
				#and kat.ldeleted=0
				#Sesuai Team Busdevnya
				AND up.iteambusdev_id=".$team_id."
				#Tanggal Pra Registrasi di isi
				AND up.tsubmit_prareg is not null
				AND up.tsubmit_prareg != '0000-00-00'
				AND up.tsubmit_prareg != '1970-01-01'
				#UPB setting Prioritas yang sudah di approve
				AND pr.iappbusdev=2
				#kategori UPB A
				AND up.ikategoriupb_id=10
				#UPB sudah setting Prioritas 4 Semester Lalu
				AND concat(pr.iyear,'0',pr.imonth) = ".$y.$semester;

		$c = new calcDetail();
		$da = $this->db_erp_pk->query($sql)->row_array();
		if($da['jml']>0){
			$hasil = $da['jml'];
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_3', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}

		return array('score'=>20,'hasil'=>0);
	}

	function BD1_4(){
		$tgl2=$this->date2;
    	$d=$this->getSemester($tgl2,FALSE);
    	$y=$d['tahun'];
    	$semester=$d['semester'];
    	$dn=$this->getSemester($tgl2,TRUE);
    	$yn=$dn['tahun'];
    	$semestern=$dn['semester'];

		$this->db_erp_pk = $this->load->database('pk', false,true);
		$iteam_id = $this->itim;
		$sql_tim ='select * from plc2.plc2_upb_team where ldeleted=0 and iteam_id in ('.$iteam_id.')';
		$qteam = $this->db_erp_pk->query($sql_tim)->row_array();
		$team_id= $qteam['iteam_id'];

		$sql="select count(distinct(up.iupb_id)) jml from plc2.plc2_upb_prioritas pr
				inner join plc2.plc2_upb_prioritas_detail prdet on pr.iprioritas_id=prdet.iprioritas_id
				inner join plc2.plc2_upb up on prdet.iupb_id=up.iupb_id
				left join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=up.ikategoriupb_id
				where pr.ldeleted=0 and prdet.ldeleted=0 and up.iappdireksi=2
				#kategori yang aktif
				#and kat.ldeleted=0
				#Sesuai Team Busdevnya
				AND up.iteambusdev_id=".$team_id."
				#kategori UPB A
				AND up.ikategoriupb_id=10
				#Tanggal Registrasi di isi
				AND up.tregistrasi is not null
				AND up.tregistrasi != '0000-00-00'
				AND up.tregistrasi != '1970-01-01'
				#UPB setting Prioritas yang sudah di approve
				AND pr.iappbusdev=2
				#UPB sudah setting Prioritas 4 Semester Lalu
				AND concat(pr.iyear,'0',pr.imonth) = ".$y.$semester;

		$c = new calcDetail();
		$da = $this->db_erp_pk->query($sql)->row_array();
		if($da['jml']>0){
			$hasil = $da['jml'];
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_4', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}

		return array('score'=>20,'hasil'=>0);
	}

	function BD1_5(){
		$tgl2=$this->date2;
    	$d=$this->getSemester($tgl2,FALSE);
    	$y=$d['tahun'];
    	$semester=$d['semester'];
    	$dn=$this->getSemester($tgl2,TRUE);
    	$yn=$dn['tahun'];
    	$semestern=$dn['semester'];

		$this->db_erp_pk = $this->load->database('pk', false,true);
		$iteam_id = $this->itim;
		$sql_tim ='select * from plc2.plc2_upb_team where ldeleted=0 and iteam_id in ('.$iteam_id.')';
		$qteam = $this->db_erp_pk->query($sql_tim)->row_array();
		$team_id= $qteam['iteam_id'];

		$sql_jml="select count(distinct(up.iupb_id)) jml from plc2.plc2_upb_prioritas pr
				inner join plc2.plc2_upb_prioritas_detail prdet on pr.iprioritas_id=prdet.iprioritas_id
				inner join plc2.plc2_upb up on prdet.iupb_id=up.iupb_id
				inner join plc2.plc2_upb_approve ap on ap.iupb_id=up.iupb_id
				where pr.ldeleted=0 and prdet.ldeleted=0 and up.iappdireksi=2 and ap.ldeleted=0
				#approval direksi upb
				AND ap.vmodule='AppUPB-DR'
				AND ap.iapprove=2
				#Sesuai Team Busdevnya
				AND up.iteambusdev_id=".$team_id."
				#Tanggal Pra Registrasi di isi
				AND up.tsubmit_prareg is not null
				AND up.tsubmit_prareg != '0000-00-00'
				AND up.tsubmit_prareg != '1970-01-01'
				#UPB setting Prioritas yang sudah di approve
				AND pr.iappbusdev=2
				#UPB sudah setting Prioritas 4 Semester Lalu
				AND concat(pr.iyear,'0',pr.imonth) = ".$y.$semester;

		$sql_date="select up.tsubmit_prareg, ap.tupdate from plc2.plc2_upb_prioritas pr
				inner join plc2.plc2_upb_prioritas_detail prdet on pr.iprioritas_id=prdet.iprioritas_id
				inner join plc2.plc2_upb up on prdet.iupb_id=up.iupb_id
				inner join plc2.plc2_upb_approve ap on ap.iupb_id=up.iupb_id
				where pr.ldeleted=0 and prdet.ldeleted=0 and up.iappdireksi=2 and ap.ldeleted=0
				#approval direksi upb
				AND ap.vmodule='AppUPB-DR'
				AND ap.iapprove=2
				#Sesuai Team Busdevnya
				AND up.iteambusdev_id=".$team_id."
				#Tanggal Pra Registrasi di isi
				AND up.tsubmit_prareg is not null
				AND up.tsubmit_prareg != '0000-00-00'
				AND up.tsubmit_prareg != '1970-01-01'
				#UPB setting Prioritas yang sudah di approve
				AND pr.iappbusdev=2
				#UPB sudah setting Prioritas 4 Semester Lalu
				AND concat(pr.iyear,'0',pr.imonth) = ".$y.$semester;
		$sql_date.=" GROUP BY up.vupb_nomor";
		$qselectall=$this->db_erp_pk->query($sql_date)->result_array();
		$da = $this->db_erp_pk->query($sql_jml)->row_array();
		$c = new calcDetail();
		
		if($da){
			if($da['jml']>0){
				$sm=array();
				$i=1;
				foreach ($qselectall as $k => $v) {
					$sm[]=$this->diffInMonths($v['tupdate'],$v['tsubmit_prareg']);
					$i++;
				}
				$hasil =array_sum($sm)/$da['jml'];
				$hasil = number_format( $hasil, 2, '.', '' );
				$score = $this->getScore('BD1_5', $hasil);
				return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
			}else{
				$hasil = 0;
				$hasil = number_format( $hasil, 2, '.', '' );
				//$score = $this->getScore('BD1_5', $hasil);
				$score=20;
				return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
			}
		}else{
			$hasil = 0;
			$hasil = number_format( $hasil, 2, '.', '' );
			//$score = $this->getScore('BD1_5', $hasil);
			$score=20;
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}
	}

	function BD1_6(){
		$tgl2=$this->date2;
    	$d=$this->getSemester($tgl2,FALSE);
    	$y=$d['tahun'];
    	$semester=$d['semester'];
    	$dn=$this->getSemester($tgl2,TRUE);
    	$yn=$dn['tahun'];
    	$semestern=$dn['semester'];

		$this->db_erp_pk = $this->load->database('pk', false,true);
		$iteam_id = $this->itim;
		$sql_tim ='select * from plc2.plc2_upb_team where ldeleted=0 and iteam_id in ('.$iteam_id.')';
		$qteam = $this->db_erp_pk->query($sql_tim)->row_array();
		$team_id= $qteam['iteam_id'];

		$sql="select count(distinct(up.iGroup_produk)) jml from plc2.plc2_upb_prioritas pr
				inner join plc2.plc2_upb_prioritas_detail prdet on pr.iprioritas_id=prdet.iprioritas_id
				inner join plc2.plc2_upb up on prdet.iupb_id=up.iupb_id
				inner join plc2.plc2_upb_approve ap on ap.iupb_id=up.iupb_id
				where pr.ldeleted=0 and prdet.ldeleted=0 and up.iappdireksi=2 and ap.ldeleted=0
				#approval direksi upb
				AND ap.vmodule='AppUPB-DR'
				AND ap.iapprove=2
				#Sesuai Team Busdevnya
				AND up.iteambusdev_id=".$team_id."
				#Tanggal Pra Registrasi di isi
				AND up.dinput_applet is not null
				AND up.dinput_applet != '0000-00-00'
				AND up.dinput_applet != '1970-01-01'
				#UPB setting Prioritas yang sudah di approve
				AND pr.iappbusdev=2
				#UPB sudah setting Prioritas 4 Semester Lalu
				AND concat(pr.iyear,'0',pr.imonth) = ".$y.$semester;

		$c = new calcDetail();
		$da = $this->db_erp_pk->query($sql)->row_array();
		if($da['jml']>0){
			$hasil = $da['jml'];
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_6', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}

		return array('score'=>20,'hasil'=>0);
	}

	//Cek pengurangan bulan
	public  function diffInMonths($datestart, $dateend)
    {
    	$date1 = new DateTime($datestart);
    	$date2 = new DateTime($dateend);
	    $diff =  $date1->diff($date2);

	    $months = $diff->y * 12 + $diff->m + $diff->d / 30;
	    return (int) floor($months);
    //return (int) round($months);
    }

	function BD1_7(){
		return array('score'=>'manual','hasil'=>0);
	}

	function BD1_8(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BD1_9(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BD1_10(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BD1_11(){
		$tgl2=$this->date2;
    	$d=$this->getSemester($tgl2,FALSE);
    	$y=$d['tahun'];
    	$semester=$d['semester'];
    	$dn=$this->getSemester($tgl2,TRUE);
    	$yn=$dn['tahun'];
    	$semestern=$dn['semester'];

		$this->db_erp_pk = $this->load->database('pk', false,true);
		$iteam_id = $this->itim;
		$sql_tim ='select * from plc2.plc2_upb_team where ldeleted=0 and iteam_id in ('.$iteam_id.')';
		$qteam = $this->db_erp_pk->query($sql_tim)->row_array();
		$team_id= $qteam['iteam_id'];

		$sql_jml="select count(distinct(up.iupb_id)) jml from plc2.plc2_upb_prioritas pr
				inner join plc2.plc2_upb_prioritas_detail prdet on pr.iprioritas_id=prdet.iprioritas_id
				inner join plc2.plc2_upb up on prdet.iupb_id=up.iupb_id
				where pr.ldeleted=0 and prdet.ldeleted=0 and up.iappdireksi=2
				#kategori UPB B
				AND up.ikategoriupb_id=11
				#Tanggal NIE harus isi
				AND up.ttarget_noreg is not null
				AND up.ttarget_noreg != '0000-00-00'
				AND up.ttarget_noreg != '1970-01-01'
				#Sesuai Team Busdevnya
				AND up.iteambusdev_id=".$team_id."
				#UPB sudah setting Prioritas 4 Semester Lalu
				AND concat(pr.iyear,'0',pr.imonth) = ".$y.$semester;

		$sql_date="select up.iupb_id as iupb, up.ttarget_noreg as nie, up.itambahan_applet as tambahan, (select ad.dsrt_td from applet_dokumen ad where ad.iupb_id=up.iupb_id order by ad.iapplet_dok_id DESC Limit 1) as ttambahan, up.ttarget_hpr as thpr from plc2.plc2_upb_prioritas pr
				inner join plc2.plc2_upb_prioritas_detail prdet on pr.iprioritas_id=prdet.iprioritas_id
				inner join plc2.plc2_upb up on prdet.iupb_id=up.iupb_id
				left join plc2.applet_dokumen ad on ad.iupb_id=up.iupb_id
				where pr.ldeleted=0 and prdet.ldeleted=0 and up.iappdireksi=2
				#kategori UPB B
				AND up.ikategoriupb_id=11
				#Tanggal NIE harus isi
				AND up.ttarget_noreg is not null
				AND up.ttarget_noreg != '0000-00-00'
				AND up.ttarget_noreg != '1970-01-01'
				#Sesuai Team Busdevnya
				AND up.iteambusdev_id=".$team_id."
				#UPB sudah setting Prioritas 4 Semester Lalu
				AND concat(pr.iyear,'0',pr.imonth) = ".$y.$semester."
				group by up.iupb_id";
			$c = new calcDetail();
		$q=mysql_query($sql_date);
		$nie=array();
		$tambahan=array();
		$ttambahan=array();
		$thpr=array();
		while ($d=mysql_fetch_array($q)) {
			$nie[]=$d['nie'];
			$tambahan[]=$d['tambahan'];
			$ttambahan[]=$d['ttambahan'];
			$thpr[]=$d['thpr'];
		}
		$da = $this->db_erp_pk->query($sql_jml)->row_array();
		
		
		if($da){
			if($da['jml']>0){
				$sm=array();
				$i=1;
				foreach ($nie as $k => $v) {
					$n1=$v;
					$n2=0;
					if($tambahan[$k]==1){
						$n2=$ttambahan[$k];
					}else{
						$n2=$thpr[$k];
					}
					$sm[]=$this->diffInMonths($n1,$n2);
					$i++;
				}		

				$hasil =array_sum($sm)/$da['jml'];
				$hasil = number_format( $hasil, 2, '.', '' );
				$score = $this->getScore('BD1_11', $hasil);
				return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
			}else{
				$hasil = 0;
				$hasil = number_format( $hasil, 2, '.', '' );
				$score = 20;
				//$score = $this->getScore('BD1_11', $hasil);
				return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
			}
		}else{
			$hasil = 0;
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = 20;
			//$score = $this->getScore('BD1_11', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}
	}
	function BD1_12(){
		$tgl2=$this->date2;
    	$d=$this->getSemester($tgl2,FALSE);
    	$y=$d['tahun'];
    	$semester=$d['semester'];
    	$dn=$this->getSemester($tgl2,TRUE);
    	$yn=$dn['tahun'];
    	$semestern=$dn['semester'];

		$this->db_erp_pk = $this->load->database('pk', false,true);
		$iteam_id = $this->itim;
		$sql_tim ='select * from plc2.plc2_upb_team where ldeleted=0 and iteam_id in ('.$iteam_id.')';
		$qteam = $this->db_erp_pk->query($sql_tim)->row_array();
		$team_id= $qteam['iteam_id'];

		$sql_jml="select count(distinct(up.iupb_id)) jml from plc2.plc2_upb_prioritas pr
				inner join plc2.plc2_upb_prioritas_detail prdet on pr.iprioritas_id=prdet.iprioritas_id
				inner join plc2.plc2_upb up on prdet.iupb_id=up.iupb_id
				where pr.ldeleted=0 and prdet.ldeleted=0 and up.iappdireksi=2
				#Tanggal NIE harus isi
				AND up.ttarget_noreg is not null
				AND up.ttarget_noreg != '0000-00-00'
				AND up.ttarget_noreg != '1970-01-01'
				#Tanggal Input Applet harus isi
				AND up.dinput_applet is not null
				AND up.dinput_applet != '0000-00-00'
				AND up.dinput_applet != '1970-01-01'
				#Sesuai Team Busdevnya
				AND up.iteambusdev_id=".$team_id."
				#UPB sudah setting Prioritas 4 Semester Lalu
				AND concat(pr.iyear,'0',pr.imonth) = ".$y.$semester."
				group by up.iupb_id";

		$sql_date="select up.iupb_id as iupb, up.ttarget_noreg as nie, up.dinput_applet as tapplet from plc2.plc2_upb_prioritas pr
				inner join plc2.plc2_upb_prioritas_detail prdet on pr.iprioritas_id=prdet.iprioritas_id
				inner join plc2.plc2_upb up on prdet.iupb_id=up.iupb_id
				where pr.ldeleted=0 and prdet.ldeleted=0 and up.iappdireksi=2
				#Tanggal NIE harus isi
				AND up.ttarget_noreg is not null
				AND up.ttarget_noreg != '0000-00-00'
				AND up.ttarget_noreg != '1970-01-01'
				#Tanggal Input Applet harus isi
				AND up.dinput_applet is not null
				AND up.dinput_applet != '0000-00-00'
				AND up.dinput_applet != '1970-01-01'
				#Sesuai Team Busdevnya
				AND up.iteambusdev_id=".$team_id."
				#UPB sudah setting Prioritas 4 Semester Lalu
				AND concat(pr.iyear,'0',pr.imonth) = ".$y.$semester."
				group by up.iupb_id";
		$q=mysql_query($sql_date);
		$nie=array();
		$tapplet=array();
		while ($d=mysql_fetch_array($q)) {
			$nie[]=$d['nie'];
			$tapplet[]=$d['tapplet'];
		}
		$da = $this->db_erp_pk->query($sql_jml)->row_array();
		$c = new calcDetail();
		if($da){
			if($da['jml']>0){
				$sm=array();
				$i=1;
				foreach ($nie as $k => $v) {
					$n1=$v;
					$n2=$tapplet[$k];
					$sm[]=$this->diffInMonths($n1,$n2);
					$i++;
				}		

				$hasil =array_sum($sm)/$da['jml'];
				$hasil = number_format( $hasil, 2, '.', '' );
				$score = $this->getScore('BD1_12', $hasil);
				return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
			}else{
				$hasil = 0;
				$hasil = number_format( $hasil, 2, '.', '' );
				//$score = $this->getScore('BD1_12', $hasil);
				$score=20;
				return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());	
			}
		}else{
			$hasil = 0;
			$hasil = number_format( $hasil, 2, '.', '' );
			$score=20;
			//$score = $this->getScore('BD1_12', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}
	}
	function BDSIKAP1_1(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP1_2(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP1_3(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP1_4(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP1_5(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP1_6(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP1_7(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP1_8(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP1_9(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP1_10(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP1_11(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDPIMPIN(){
		return array('score'=>'manual','hasil'=>0);
	}

	function BD3_1(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BD3_2(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BD3_3(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BD3_4(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BD3_5(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BD3_6(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BD3_7(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BD3_8(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BD3_9(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BD3_10(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BD3_11(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BD3_12(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BD3_13(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP3_1(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP3_2(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP3_3(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP3_4(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP3_5(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP3_6(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP3_7(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP3_8(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP3_9(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP3_10(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP3_11(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDPIMPIN3_1(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDPIMPIN3_2(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDPIMPIN3_3(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDPIMPIN3_4(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDPIMPIN3_5(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDPIMPIN3_6(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDPIMPIN3_7(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDPIMPIN3_8(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDPIMPIN3_9(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDPIMPIN3_10(){
		return array('score'=>'manual','hasil'=>0);
	}
	function BDPIMPIN3_11(){
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