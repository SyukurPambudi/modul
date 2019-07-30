<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class calc_bd3 {
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


	//Busdev 3
	//
	
	function BD3_1($itim=false){
		$calcDetail = new calcDetail();
		$sql_par = 'select 
				#group distinct karena hanya mengambil jumlah group produk 
				distinct(a.iGroup_produk) jum  
				#app.tupdate,a.*,d.vNama_Group 
				from plc2.plc2_upb a 
				join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
				join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
				join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk 
				#Filter Deleted 
				where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0 
				#upb team nya 
				and a.iteambusdev_id="'.$this->itim.'"  
				#Kategori Produk Non Alkes dan Not NUll
				and a.ikategori_id!=15 and a.ikategori_id is not null
				#Informasi Hak Patent Not NUll
				and a.tinfo_paten is not NULL
				#approval direksi
				and a.iappdireksi = 2 and app.tupdate is not null 
				#periode tanggal prareg 
				and app.tupdate >= "'.$this->date1.'" 
				and app.tupdate <= "'.$this->date2.'" 
				group by a.iupb_id 
				';
		$qupb = $this->db_erp_pk->query($sql_par);
		if($qupb->num_rows() > 0) {
			$d=$qupb->result_array();
			foreach ($d as $k => $v) {
				$s[$v['jum']]=$v['jum'];
			}
			$hasil=count($s);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD3_1', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD3_1', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
	}
	function BD3_2($itim=false){
		$calcDetail = new calcDetail();
		$sdisct ='select 
				#group distinct karena hanya mengambil jumlah group produk 
				distinct(te.iteam_id) jum';
		$sdat='select app.tupdate,a.*';
		$sql_par = ' from plc2.plc2_upb a 
				join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
				join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
				join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk
				join plc2.plc2_upb_team te on a.iteammarketing_id=te.iteam_id
				#Filter Deleted 
				where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0 
				#upb team nya 
				and a.iteambusdev_id="'.$this->itim.'"
				#approval direksi
				and a.iappdireksi = 2 and app.tupdate is not null 
				#periode tanggal prareg 
				and app.tupdate >= "'.$this->date1.'" 
				and app.tupdate <= "'.$this->date2.'" 
				group by a.iupb_id 
				';
		$qupbdat = $this->db_erp_pk->query($sdat.$sql_par);
		if($qupbdat->num_rows() > 0) {
			$d=$this->db_erp_pk->query($sdisct.$sql_par)->num_rows();
			$hasil=$qupbdat->num_rows()/$d;
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD3_2', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD3_2', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
	} 

	function BD3_3($itim=false){
		$calcDetail = new calcDetail();
		$sql_par = 'select 
				a.*,s.dTanggalTerimaBD,t.dApp_dir
				from plc2.plc2_upb a 
				join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
				join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
				join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk 
				join plc2.otc_sample_panel s on s.iupb_id = a.iupb_id 
				join plc2.otc_panel_test t on t.isample_panel_id=s.isample_panel_id 
				#Filter Deleted 
				where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0 and s.lDeleted=0 and t.lDeleted=0
				#upb team nya 
				and a.iteambusdev_id="'.$this->itim.'" 
				#Tanggal app dir not null 
				and a.iappdireksi = 2 and app.tupdate is not null 
				#tanggal approve req panel not null
				and t.dApp_dir is not null
				#tanggal terima sample
				and s.dTanggalTerimaBD is not null
				#periode tanggal prareg 
				and t.dApp_dir >= "'.$this->date1.'" 
				and t.dApp_dir <= "'.$this->date2.'" 
				group by s.isample_panel_id 
				';
		$qupb = $this->db_erp_pk->query($sql_par);
		if($qupb->num_rows() > 0) {
			$sumsel=array();
			foreach ($qupb->result_array() as $r => $vrupb) {
				$tgl1=date_create($vrupb['dApp_dir']);
				$tgl2=date_create($vrupb['dTanggalTerimaBD']);
				$sumsel[]=$this->selisihbulan($tgl1,$tgl2);
			}
			$hasil1=intval(array_sum($sumsel))/$qupb->num_rows();

			$hasil = number_format( $hasil1, 2, '.', '' );
			$score = $this->getScore('BD3_3', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			//Jika Tidak ada UPB Sama Sekali
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD3_3', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
	} 

	function BD3_4(){ 
		return array('score'=>'manual','hasil'=>0);
	}

	function BD3_5($itim=false){
		$calcDetail = new calcDetail();
		$sql_par = 'select 
				#group distinct karena hanya mengambil jumlah group produk 
				count(distinct(a.iGroup_produk)) jum 
				#a.tsubmit_prareg,a.* 
				from plc2.plc2_upb a 
				join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
				join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
				join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk 
				#Filter Deleted 
				where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0 
				#upb team nya 
				and a.iteambusdev_id="'.$this->itim.'"  
				#Tanggal Prared Not NULl 
				and a.tsubmit_prareg is not null 
				#Tanggal app dir not null 
				and a.iappdireksi = 2 and app.tupdate is not null 
				#periode tanggal prareg 
				and a.tsubmit_prareg >= "'.$this->date1.'" 
				and a.tsubmit_prareg <= "'.$this->date2.'"  
				';
		$qupb = $this->db_erp_pk->query($sql_par);
		if($qupb->num_rows() > 0) {
			$d=$qupb->row_array();
			$hasil=$d['jum'];
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD3_5', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD3_5', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
	} 

	function BD3_6($itim=false){
		$calcDetail = new calcDetail();
		$sql_par = 'select a.*,a.tsubmit_prareg,a.ttanggal 
				from plc2.plc2_upb a join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
				join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
				join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id 
				#Filter Deleted 
				where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0 
				#upb team nya 
				and a.iteambusdev_id="'.$this->itim.'" 
				#Tanggal Prareg not null 
				and a.tsubmit_prareg is not null 
				#Tanggal Submit UPB not NUll 
				and a.ttanggal is not null 
				#Tanggal app dir not null 
				and a.iappdireksi = 2 and app.tupdate is not null 
				#periode tanggal prareg 
				and a.tsubmit_prareg >= "'.$this->date1.'" 
				and a.tsubmit_prareg <= "'.$this->date2.'" 
				group by a.iupb_id 
				';
		//return array('score'=>$sql_par,'hasil'=>0,'detail'=>$calcDetail->output());exit();
		$qupb = $this->db_erp_pk->query($sql_par);
		if($qupb->num_rows() > 0) {
			$sumsel=array();
			foreach ($qupb->result_array() as $r => $vrupb) {
				$tgl1=date_create($vrupb['tsubmit_prareg']);
				$tgl2=date_create($vrupb['ttanggal']);
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

	function BD3_7($itim=false){
		$calcDetail = new calcDetail();
		$selall= 'select z.iupb_id, z.vupb_nomor, z.vupb_nama, z.vKode_obat, z.iGroup_produk, z.dinput_applet, z.ttarget_noreg';
		$seldisct= 'select distinct(z.iGroup_produk) as jum'; 
		$sql_par =' from (
					#untuk Produk Kategori Obat
					select
					a.iupb_id,a.vupb_nomor,a.vupb_nama,a.vKode_obat, a.iGroup_produk, a.dinput_applet, a.ttarget_noreg
					from plc2.plc2_upb a 
					join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
					join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk 
					#Filter Deleted 
					where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0 
					#upb team nya 
					and a.iteambusdev_id="'.$this->itim.'" 
					#Tanggal Applet Not NULl 
					#and a.dinput_applet is not null 
					#Kategori Obat
					AND a.ikategori_id in (1,2,5,10,11,12)
					#Tanggal app dir not null 
					and a.iappdireksi = 2 and app.tupdate is not null 
					#periode tanggal prareg 
					and a.dinput_applet >= "'.$this->date1.'" 
					and a.dinput_applet <= "'.$this->date2.'"
					group by a.iupb_id
					UNION
					select
					#untuk Produk Kategori Non Obat
					a.iupb_id,a.vupb_nomor,a.vupb_nama,a.vKode_obat, a.iGroup_produk, a.dinput_applet, a.ttarget_noreg
					from plc2.plc2_upb a 
					join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
					join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk 
					#Filter Deleted 
					where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0 
					#upb team nya 
					and a.iteambusdev_id="'.$this->itim.'" 
					#Tanggal NIE Not NULl 
					and a.ttarget_noreg is not null 
					#Kategori Obat
					AND a.ikategori_id in (3,4,6,7,8,9,13)
					#Tanggal app dir not null 
					and a.iappdireksi = 2 and app.tupdate is not null 
					#periode tanggal prareg 
					and a.ttarget_noreg >= "'.$this->date1.'" 
					and a.ttarget_noreg <= "'.$this->date2.'"
					group by a.iupb_id
					) AS z
					group by z.iupb_id 
					ORDER BY z.vupb_nomor ASC  
				';
		$qupb = $this->db_erp_pk->query($selall.$sql_par);
		if($qupb->num_rows() > 0) {
			$qgroup=$this->db_erp_pk->query($seldisct.$sql_par)->row_array();
			$hasil=$qupb->num_rows()/$qgroup['jum'];
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD3_7', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD3_7', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$calcDetail->output());

		}
	}
 
	function BD3_8(){ 
		return array('score'=>'manual','hasil'=>0);
	}

	function BD3_9(){
		//Menghitung Jumlah Upb tipe B dan sudah input Applet
		 

		$sqlp1 = '   SELECT u.`dinput_applet`, u.`tregistrasi` FROM plc2.`plc2_upb` u 
					WHERE u.`ldeleted` = 0 
					AND u.`iteambusdev_id` = 5 
					AND u.dinput_applet IS NOT NULL  
					AND u.`ikategori_id` IN (1,2,5,10, 11, 12)
					AND u.`tregistrasi` IS NOT NULL
					AND u.`dinput_applet` >= "'.$this->date1.'" 
					AND u.`dinput_applet` <= "'.$this->date2.'"  
					';

		$sqlp2 = '	SELECT u.`ttarget_noreg`, u.`tregistrasi` FROM plc2.`plc2_upb` u 
					WHERE u.`ldeleted` = 0 
					AND u.`iteambusdev_id` = 5 
					AND u.`ttarget_noreg` IS NOT NULL  
					AND u.`ikategori_id` IN (7)
					AND u.`tregistrasi` IS NOT NULL
					AND u.`ttarget_noreg` >= "'.$this->date1.'" 
					AND u.`ttarget_noreg` <= "'.$this->date2.'"  
					';



		$t_be = $this->db_erp_pk->query($sqlp1)->result_array();
		$t_nbe = $this->db_erp_pk->query($sqlp2)->result_array();


		//Menghitung BE
		$selisih_be = 0;
		$upb_be = 0 ;
		foreach ($t_be as $be) {
			$timeEnd = strtotime($be['dinput_applet']);
			$timeStart = strtotime($be['tregistrasi']);
 
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
			$timeEnd = strtotime($nbe['ttarget_noreg']);
			$timeStart = strtotime($nbe['tregistrasi']);
 
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
			$score = $this->getScore('BD3_9', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}else{
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD3_9', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		} 
	}


	function BD3_10(){

		//Menghitung Selisih Submit Prareg dengan Submit Prioritas 

		$sql_t = '	SELECT u.`ttarget_noreg`, u.`tregistrasi` FROM plc2.`plc2_upb` u 
					join hrd.mnf_kategori mk on mk.ikategori_id = u.ikategori_id
					WHERE u.`ldeleted` = 0 

					AND u.`iteambusdev_id` = 5 
					AND u.`ttarget_noreg` IS NOT NULL  
					AND u.`ikategori_id` IN (3,4,6,8,9,10,13)
					AND u.`tregistrasi` IS NOT NULL
					AND u.dinput_applet IS NOT NULL  
					AND u.`ttarget_noreg` >= "'.$this->date1.'" 
					AND u.`ttarget_noreg` <= "'.$this->date2.'"  
					';
 
		$loop = $this->db_erp_pk->query($sql_t)->result_array();

		$selisih = 0;
		$upb = 0;
		foreach ($loop as $v) {

			$timeEnd = strtotime($v['ttarget_noreg']);
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
			$score = $this->getScore('BD3_10', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}else{ 
			$hasil = 0;
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD3_10', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		} 
	}
 

	function BD3_11(){ 
		return array('score'=>'manual','hasil'=>0);
	}

	function BD3_12(){ 

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
		$time = 1 + (date("Y",$timeEnd)-date("Y",$timeStart))*12;
		$time +=  (date("m",$timeEnd)-date("m",$timeStart));   
		if($time < 1){
			$hasil = number_format(0);
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD3_12', $hasil);
			return array('score'=>$score,'hasil'=>$hasil,'detail'=>$c->output());
		}else{
			$hasil = $tot['icall_id'] / $time;  // (A)/(B)
			$hasil = number_format( $hasil, 2, '.', '' );
			$score = $this->getScore('BD3_12', $hasil);
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


