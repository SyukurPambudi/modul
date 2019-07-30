<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class calc_bd1 {
	private $_ci;
	public $error;
	public $date1;
	public $date2;
	public $periode; 
	public $nippemohon;
	public function __construct() {
		$this->_ci=& get_instance();
		$this->_ci->load->library('auth');
		$this->db_erp_pk = $this->load->database('pk', false,true);
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

 
 
 


	//Busdev 1
	function BD1_1(){ 

		//Menghitung Jumlah Group Product
		$sql='SELECT COUNT(DISTINCT(u.`iGroup_produk`)) as jml FROM plc2.`plc2_upb` u 
			JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
			JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
			WHERE u.`ldeleted` = 0 
			AND u.tinfo_paten IS NOT NULL
			AND u.tinfo_paten !=""
			AND u.`iteambusdev_id` = 4 
			AND ua.`vtipe` = "DR"
			AND ua.`iapprove` = 2
			AND ua.`tupdate` >= "'.$this->date1.'" 
			AND ua.`tupdate` <= "'.$this->date2.'"'; 

		$c = new calcDetail();
		$da = $this->db_erp_pk->query($sql)->row_array();
		if($da['jml']>0){
			$hasil = $da['jml'];
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_1', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_1', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}

		
	}
	function BD1_2(){

		//Menghitung JumLAH upb (A)
		$sqlp1='SELECT COUNT(u.`iupb_id`) As t_upb FROM plc2.`plc2_upb` u 
			JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`  
			#JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
			WHERE u.`ldeleted` = 0 
			AND u.tinfo_paten IS NOT NULL
			AND u.tinfo_paten !=""
			AND u.`iteambusdev_id` = 4 
			AND u.iteammarketing_id IS NOT NULL
			AND ua.`vtipe` = "DR"
			AND ua.`iapprove` = 2
			AND ua.`tupdate` >= "'.$this->date1.'" 
			AND ua.`tupdate` <= "'.$this->date2.'"
			';

		//Menghitung Jumalah Divisi Marketing (B)
		$sqlp2='SELECT COUNT(DISTINCT(u.iteammarketing_id)) As t_Mark FROM plc2.`plc2_upb` u 
			JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
			#JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
			WHERE u.`ldeleted` = 0 
			AND u.tinfo_paten IS NOT NULL
			AND u.iteammarketing_id IS NOT NULL
			AND u.tinfo_paten !=""
			AND u.`iteambusdev_id` = 4 
			AND ua.`vtipe` = "DR"
			AND ua.`iapprove` = 2
			AND ua.`tupdate` >= "'.$this->date1.'" 
			AND ua.`tupdate` <= "'.$this->date2.'"';
 

		$c = new calcDetail();
		$upb = $this->db_erp_pk->query($sqlp1)->row_array(); 
		$mar = $this->db_erp_pk->query($sqlp2)->row_array();
		if($mar){
			if($mar['t_Mark']>0){
				$hasil = $upb['t_upb']/$mar['t_Mark'];  // (A)/(B)
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
		//Menghitung JumLAH upb (A) kategory A
		$sqlp1='SELECT COUNT(u.`iupb_id`) As t_upb1 FROM plc2.`plc2_upb` u 
			JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
			JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
			#JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
			WHERE u.`ldeleted` = 0 
			AND u.tinfo_paten IS NOT NULL
			AND u.tinfo_paten !=""
			AND u.`iteambusdev_id` = 4 
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
			#JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
			WHERE u.`ldeleted` = 0 
			AND u.tinfo_paten IS NOT NULL
			AND u.tinfo_paten !=""
			AND u.`iteambusdev_id` = 4 
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
				$score = $this->getScore('BD1_3', $hasil);
				return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
			}else{
				$hasil = number_format(0);
				$hasil = number_format( $hasil, 2, '.', '' );
				$score = $this->getScore('BD1_3', $hasil);
				return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
			}
		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_3', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}
		
	}

	function BD1_4(){

		//Menghitung Selisih Submit Prareg dengan Submit Prioritas
		 $sql_t = ' SELECT u.`tsubmit_prareg` , ( 
						SELECT b.`tappbusdev`
						FROM plc2.plc2_upb_prioritas b 
						JOIN plc2.plc2_upb_prioritas_detail c ON c.iprioritas_id=b.iprioritas_id
						WHERE 
						b.ldeleted=0
						AND c.ldeleted=0
						AND c.iupb_id=u.iupb_id
						AND tappbusdev IS NOT NULL
						ORDER BY b.iprioritas_id ASC LIMIT 1 
					) AS tappbusdev , u.`iupb_id`, u.`iGroup_produk`

					FROM plc2.`plc2_upb` u   
					WHERE u.`ldeleted` = 0 
					AND u.`iupb_id` IN (
						SELECT cb.`iupb_id`
						FROM plc2.plc2_upb_prioritas bb 
						JOIN plc2.plc2_upb_prioritas_detail cb ON cb.iprioritas_id=bb.iprioritas_id
						WHERE 
						bb.ldeleted=0
						AND cb.ldeleted=0 
						AND tappbusdev IS NOT NULL 
						)
					AND u.`tsubmit_prareg` IS NOT NULL
					AND u.`ldeleted` = 0 
					AND u.`iteambusdev_id` = 4 
					AND u.`tsubmit_prareg` >= "'.$this->date1.'" 
					AND u.`tsubmit_prareg` <= "'.$this->date2.'" ';
		$loop = $this->db_erp_pk->query($sql_t)->result_array();

		$selisih = 0;
		$upb = 0;
		foreach ($loop as $v) {

			$timeEnd = strtotime($v['tsubmit_prareg']);
			$timeStart = strtotime($v['tappbusdev']);
 
			$time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
			$time +=  (date("m",$timeEnd)-date("m",$timeStart));      
			if($time <=0){
				$durasi = -1*($time);
			}else{
				$durasi = $time;
			}
			$selisih += $durasi;
			$upb ++;
		}
		$c = new calcDetail();
		if($upb>0){ 
			$hasil = $selisih/$upb;  // (A)/(B)
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_4', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}else{ 
			$hasil = 0;
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_4', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		} 
	}
 	

 	function BD1_5(){
 		//Menghitung Jumalah UPB yang sudah submit prareg dan tipenya A
		 $sql_t = 'SELECT COUNT(u.`iupb_id`) AS t_upb FROM plc2.`plc2_upb` u 
					JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
					WHERE u.`ldeleted` = 0  
					AND u.`iteambusdev_id` = 4 
					AND ua.`vtipe` = "DR"
					AND ua.`iapprove` = 2 
					AND u.`ikategoriupb_id` = 10 
					AND u.tsubmit_prareg IS NOT NULL
					AND u.`tsubmit_prareg` >= "'.$this->date1.'" 
					AND u.`tsubmit_prareg` <= "'.$this->date2.'" ';
		$tot = $this->db_erp_pk->query($sql_t)->row_array(); 

		$c = new calcDetail();
		if($tot['t_upb']>0){ 
			$hasil = $tot['t_upb'];  // (A)/(B)
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_5', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_5', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		} 
	}

	function BD1_6(){

		//Menghitung JumLAH upb (A)
		$sqlp1='SELECT COUNT(u.`iupb_id`) As t_upb FROM plc2.`plc2_upb` u  
			WHERE u.`ldeleted` = 0  
			AND u.`iteambusdev_id` = 4 
			AND u.tsubmit_prareg IS NOT NULL
			AND u.iteammarketing_id IS NOT NULL
			AND u.`tsubmit_prareg` >= "'.$this->date1.'" 
			AND u.`tsubmit_prareg` <= "'.$this->date2.'" '; 

		//Menghitung Jumalah Divisi Marketing (B)
		$sqlp2='SELECT COUNT(DISTINCT(u.iteammarketing_id)) As t_Mark FROM plc2.`plc2_upb` u  
			WHERE u.`ldeleted` = 0   
			AND u.`iteambusdev_id` = 4
			AND u.iteammarketing_id IS NOT NULL 
			AND u.tsubmit_prareg IS NOT NULL
			AND u.`tsubmit_prareg` >= "'.$this->date1.'" 
			AND u.`tsubmit_prareg` <= "'.$this->date2.'" '; 

		$c = new calcDetail();
		$upb = $this->db_erp_pk->query($sqlp1)->row_array(); 
		$mar = $this->db_erp_pk->query($sqlp2)->row_array();
		if($mar){
			if($mar['t_Mark']>0){
				$hasil = $upb['t_upb']/$mar['t_Mark'];  // (A)/(B)
				$hasil = number_format( $hasil, 2, '.', '' );
				$score = $this->getScore('BD1_6', $hasil);
				return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
			}else{
				$hasil = number_format(0);
				$hasil = number_format( $hasil, 2, '.', '' );
				$score = $this->getScore('BD1_6', $hasil);
				return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
			}
		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_6', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}
	}


	function BD1_7(){

		//Menghitung BE
		$sqlp1='SELECT pu.`tsubmit_prareg`,pu.`ttarget_hpr` ,pu.`iupb_id`FROM plc2.`plc2_upb` pu 
				JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = pu.`ikategoriupb_id`
				WHERE 
				pu.`ldeleted` = 0
				AND pu.`ibe` = 1
				AND pu.`tsubmit_prareg` IS NOT NULL
				AND pu.`ttarget_hpr` IS NOT NULL
				AND pu.`ikategoriupb_id` = 10
				AND pu.`iteambusdev_id` = 4
				AND pu.`ttarget_hpr` >= "'.$this->date1.'" 
				AND pu.`ttarget_hpr` <= "'.$this->date2.'" ';  

		$sqlp2='SELECT pu.`tsubmit_prareg`,pu.`tregistrasi` ,pu.`iupb_id`FROM plc2.`plc2_upb` pu 
				JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = pu.`ikategoriupb_id`
				WHERE 
				pu.`ldeleted` = 0
				AND pu.`ibe` = 2
				AND pu.`tsubmit_prareg` IS NOT NULL
				AND pu.`tregistrasi` IS NOT NULL
				AND pu.`ikategoriupb_id` = 10
				AND pu.`iteambusdev_id` = 4
				AND pu.`tregistrasi` >= "'.$this->date1.'" 
				AND pu.`tregistrasi` <= "'.$this->date2.'" '; 

		$t_be = $this->db_erp_pk->query($sqlp1)->result_array();
		$t_nbe = $this->db_erp_pk->query($sqlp2)->result_array();


		//Menghitung BE
		$selisih_be = 0;
		$upb_be = 0 ;
		foreach ($t_be as $be) {
			$timeEnd = strtotime($be['ttarget_hpr']);
			$timeStart = strtotime($be['tsubmit_prareg']);
 
			$time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
			$time +=  (date("m",$timeEnd)-date("m",$timeStart));    

			if($time <=0){
				$durasi = -1*($time);
			}else{
				$durasi = $time;
			}
			$selisih_be += $durasi;
			$upb_be ++;
		}


		//Menghitung NON BE
		$selisih_nbe = 0;
		$upb_nbe = 0 ;
		foreach ($t_nbe as $nbe) {
			$timeEnd = strtotime($nbe['tregistrasi']);
			$timeStart = strtotime($nbe['tsubmit_prareg']);
 
			$time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
			$time +=  (date("m",$timeEnd)-date("m",$timeStart));     

			if($time <=0){
				$durasi = -1*($time);
			}else{
				$durasi = $time;
			}
			$selisih_nbe += $durasi;
			$upb_nbe ++;
		} 

		//Mentotalkan Data
		$sum_selisih = $selisih_nbe + $selisih_be;
		$sum_upb = $upb_nbe + $upb_be;


		$c = new calcDetail();
		if($sum_upb>0){ 
			$hasil = $sum_selisih/$sum_upb;  // (A)/(B)
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_7', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_7', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		} 
	}

 

	function BD1_8(){

		//Menghitung Jumlah Upb tipe A dan sudah input Applet
		 $sql_t = 'SELECT COUNT(DISTINCT(u.`iGroup_produk`)) AS t_upb FROM plc2.`plc2_upb` u 
		 			JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
		 			JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
					WHERE u.`ldeleted` = 0 
					AND u.`iteambusdev_id` = 4 
					AND u.dinput_applet IS NOT NULL 
					AND u.`dinput_applet` >= "'.$this->date1.'" 
					AND u.`dinput_applet` <= "'.$this->date2.'" 
					AND u.`ikategoriupb_id` = 10 
					';
		$tot = $this->db_erp_pk->query($sql_t)->row_array(); 


		$c = new calcDetail();
		if($tot['t_upb']>0){ 
			$hasil = $tot['t_upb'];  // (A)/(B)
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_8', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_8', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		} 
	}

	function BD1_9(){
		//Menghitung Jumlah Upb tipe B dan sudah input Applet
		 $sql_t = 'SELECT COUNT(DISTINCT(u.`iGroup_produk`)) AS t_upb FROM plc2.`plc2_upb` u 
		 			JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
		 			JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
					WHERE u.`ldeleted` = 0 
					AND u.`iteambusdev_id` = 4 
					AND u.dinput_applet IS NOT NULL 
					AND u.`dinput_applet` >= "'.$this->date1.'" 
					AND u.`dinput_applet` <= "'.$this->date2.'" 
					AND u.`ikategoriupb_id` = 11 
					';
		$tot = $this->db_erp_pk->query($sql_t)->row_array(); 
		$c = new calcDetail();
		if($tot['t_upb']>0){ 
			$hasil = $tot['t_upb'];  // (A)/(B)
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_9', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_9', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		} 
	}


	function BD1_10(){

		//Menghitung Selisih Submit Prareg dengan Submit Prioritas
		 $sql_t = ' SELECT u.`iupb_id` , u.`dinput_applet` , u.`tregistrasi`, u.ikategoriupb_id FROM plc2.`plc2_upb` u 
					WHERE u.`ldeleted` = 0 
					AND u.`iteambusdev_id` = 4 
					AND u.dinput_applet IS NOT NULL 
					AND u.tregistrasi IS NOT NULL  
					AND u.`ikategoriupb_id` = 10 
					AND u.`dinput_applet` >= "'.$this->date1.'" 
					AND u.`dinput_applet` <= "'.$this->date2.'" ';
		$loop = $this->db_erp_pk->query($sql_t)->result_array();

		$selisih = 0;
		$upb = 0;
		foreach ($loop as $v) {

			$timeEnd = strtotime($v['dinput_applet']);
			$timeStart = strtotime($v['tregistrasi']);
 
			$time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
				$time +=  (date("m",$timeEnd)-date("m",$timeStart));      
			if($time <=0){
				$durasi = -1*($time);
			}else{
				$durasi = $time;
			}
			$selisih += $durasi;
			$upb ++;
		}
		$c = new calcDetail();
		if($upb>0){ 
			$hasil = $selisih/$upb;  // (A)/(B)
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_10', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}else{ 
			$hasil = 0;
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_10', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		} 
	}

	function BD1_11(){

		//Menghitung Selisih Submit Prareg dengan Submit Prioritas
		 $sql_t = 'SELECT u.`iupb_id` , u.`dinput_applet` , u.`tregistrasi`, 
					u.ikategoriupb_id, 

					(SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
					AND ad.`iupb_id`  = u.`iupb_id`
					AND ad.`dsubmit_dok` IS NOT NULL
					ORDER BY ad.`dsubmit_dok` DESC LIMIT 1)  AS dsubmit_dok

					FROM plc2.`plc2_upb` u  
					WHERE u.`ldeleted` = 0 
					AND u.`iupb_id` IN (SELECT ad.`iupb_id` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0  
					AND ad.`dsubmit_dok` IS NOT NULL )

					AND u.`iteambusdev_id` = 4 
					AND u.dinput_applet IS NOT NULL 
					AND u.tregistrasi IS NOT NULL AND u.`ikategoriupb_id` = 11 
					AND u.`dinput_applet` >= "'.$this->date1.'" 
					AND u.`dinput_applet` <= "'.$this->date2.'" ';
		$loop = $this->db_erp_pk->query($sql_t)->result_array();

		$selisih = 0;
		$upb = 0;
		foreach ($loop as $v) {

			$timeEnd = strtotime($v['dinput_applet']);
			$timeStart = strtotime($v['dsubmit_dok']);
 
			$time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
				$time +=  (date("m",$timeEnd)-date("m",$timeStart));      
			if($time <=0){
				$durasi = -1*($time);
			}else{
				$durasi = $time;
			}
			$selisih += $durasi;
			$upb ++;
		}
		$c = new calcDetail();
		if($upb>0){ 
			$hasil = $selisih/$upb;  // (A)/(B)
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_11', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}else{ 
			$hasil = 0;
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_11', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		} 
	}

	function BD1_12(){ 
		return array('score'=>'manual','hasil'=>0);
	}

	function BD1_13(){ 

		//Menghitung Jumlah Upb tipe B dan sudah input Applet
		 $sql_t = 'SELECT COUNT(cc.`icall_id`) AS `icall_id` FROM kartu_call.`call_card` cc 
		 			WHERE cc.`lDeleted` = 0 
					AND cc.`itarget_kunjungan_id` = 5   
					AND cc.`vNIP` LIKE "%'.$this->nippemohon.'%"
					AND cc.`dCreate` >= "'.$this->date1.'" 
					AND cc.`dCreate` <= "'.$this->date2.'"  
					';
		$tot = $this->db_erp_pk->query($sql_t)->row_array(); 

		$timeEnd = strtotime($this->date2);
		$timeStart = strtotime($this->date1);

		$c = new calcDetail();
		$time = 1+(date("Y",$timeEnd)-date("Y",$timeStart))*12;
				$time +=  (date("m",$timeEnd)-date("m",$timeStart));      
		if($time < 1){
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_13', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}else{
			$hasil = $tot['icall_id'] / $time;  // (A)/(B)
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD1_13', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}
 
	} 

	function BDPIMPIN(){ 
		return array('score'=>'manual','hasil'=>0);
	}
	function BDSIKAP(){ 
		return array('score'=>'manual','hasil'=>0);
	}

}


