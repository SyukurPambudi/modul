<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_details_performance extends MX_Controller {
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
    	$q="select * from plc2.pk_parameter where ldeleted=0 and iparameter_id=$iparameter_id limit 1";
    	$st=$this->db_erp_pk->query($q)->row_array();
    	if(method_exists($this, $st['vFunction'])){
    		$func=$st['vFunction'];
    		return $this->$func($imaster_id);
    	}else{
    		return "NOT FOUND FUNCTION";
    	}
    }
    private function getDetMaster($imaster_id){
    	$tq="select * from plc2.pk_master mas where mas.ldeleted=0 and mas.idmaster_id=$imaster_id";
    	$qmas=$this->db_erp_pk->query($tq)->row_array();
    	return $qmas;
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

    /* Fungsi View Details Setiap parameter */
    public function BD1_1($imaster_id){
    	$dmas=$this->getDetMaster($imaster_id);
    	$tgl2=$dmas['tgl2'];
    	$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];
    	$sqlc="select distinct(up.iGroup_produk) jml ";
    	$sqls="select up.*,pr.iyear,pr.imonth ";
    	$sqlf="from plc2.plc2_upb_prioritas pr
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
		$sqloreder=" ORDER BY up.iGroup_produk ASC";
		$qcount=$sqlc.$sqlf;
		$qall=$sqls.$sqlf.$sqloreder;
		$dtall=$this->db_erp_pk->query($qall);
		$dtcount=$this->db_erp_pk->query($qcount);
		if($dtall->num_rows()>=1){
			$data['dataall']=$dtall->result_array();
			$data['row']='1';
		}else{
			$data['row']='nol';
		}
		$data['jmlupb']=$dtall->num_rows();
		if($dtcount->num_rows()>=1){
			$data['datacount']=$dtcount->result_array();
		}else{
			$data['datacount']='0';
		}
		$data['sql']='';
		$view=$this->load->view('details_bd1_1',$data,true);
		return $view;
    }
    public function BD1_2($imaster_id){
    	$dmas=$this->getDetMaster($imaster_id);
    	$tgl2=$dmas['tgl2'];
    	$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];
    	$dn=$this->getSemester($tgl2,TRUE);
    	$yn=$dn['tahun'];
    	$semestern=$dn['semester'];
    	$sqlco="select count(distinct(up.iupb_id)) jml ";
    	$sqlall="select up.*,pr.iyear,pr.imonth,kat.vkategori,(case when kat.ldeleted=1 then '-' else kat.vkategori end) as kategori";
    	$sql1="	from plc2.plc2_upb_prioritas pr
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
		$sql2 =$sql1;
		$sql2.='#kategori UPB A
				AND up.ikategoriupb_id=10';
		$sqloreder=" ORDER BY up.vupb_nomor ASC";
		$sqlgr=" GROUP BY up.vupb_nomor";
		$qsql1all=$this->db_erp_pk->query($sqlall.$sql1.$sqlgr.$sqloreder);
		$qsql1count=$this->db_erp_pk->query($sqlco.$sql1.$sqloreder);
		$qsql2all=$this->db_erp_pk->query($sqlall.$sql2.$sqlgr.$sqloreder);
		$qsql2count=$this->db_erp_pk->query($sqlco.$sql2.$sqloreder);
		$data['row1']="0";
		$data['jrow1']="0";
		if($qsql1all->num_rows()>=1){
			$data['row1']="1";
			$data["dt1"]=$qsql1all->result_array();
			$data['jrow1']=$qsql1count->row_array();
		}
		$data['row2']="0";
		$data['jrow2']="0";
		if($qsql1all->num_rows()>=1){
			$data['row2']="1";
			$data["dt2"]=$qsql2all->result_array();
			$data['jrow2']=$qsql2count->row_array();
		}
		$data['sql']='';
		$view=$this->load->view('details_bd1_2',$data,true);
		return $view;
    }

    public function BD1_3($imaster_id){
    	$dmas=$this->getDetMaster($imaster_id);
    	$tgl2=$dmas['tgl2'];
    	$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];
    	$dn=$this->getSemester($tgl2,TRUE);
    	$yn=$dn['tahun'];
    	$semestern=$dn['semester'];

		$sql="select up.*,pr.iyear,pr.imonth,up.tsubmit_prareg,kat.vkategori,(case when kat.ldeleted=1 then '-' else kat.vkategori end) as kategori from plc2.plc2_upb_prioritas pr
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
		$sqloreder=" ORDER BY up.vupb_nomor ASC";
		$sqlgr=" GROUP BY up.vupb_nomor";
		$q=$this->db_erp_pk->query($sql.$sqlgr.$sqloreder);
		$data['row']="0";
		if($q->num_rows()>=1){
			$data['row']=$q->num_rows();
			$data['datarow']=$q->result_array();
		}
		$view=$this->load->view('details_bd1_3',$data,true);
		return $view;

    }

    public function BD1_4($imaster_id){
    	$dmas=$this->getDetMaster($imaster_id);
    	$tgl2=$dmas['tgl2'];
    	$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];
    	$dn=$this->getSemester($tgl2,TRUE);
    	$yn=$dn['tahun'];
    	$semestern=$dn['semester'];

    	$sql="select up.*,pr.iyear,pr.imonth,up.tregistrasi,kat.vkategori,(case when kat.ldeleted=1 then '-' else kat.vkategori end) as kategori from plc2.plc2_upb_prioritas pr
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
		$sqloreder=" ORDER BY up.vupb_nomor ASC";
		$sqlgr=" GROUP BY up.vupb_nomor";
		$q=$this->db_erp_pk->query($sql.$sqlgr.$sqloreder);
		$data['row']="0";
		if($q->num_rows()>=1){
			$data['row']=$q->num_rows();
			$data['datarow']=$q->result_array();
		}
		$view=$this->load->view('details_bd1_4',$data,true);
		return $view;

    }

    public function BD1_5($imaster_id){
    	$dmas=$this->getDetMaster($imaster_id);
    	$tgl2=$dmas['tgl2'];
    	$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];
    	$dn=$this->getSemester($tgl2,TRUE);
    	$yn=$dn['tahun'];
    	$semestern=$dn['semester'];

    	$sql="select  up.*,pr.iyear,pr.imonth,up.tsubmit_prareg, ap.tupdate from plc2.plc2_upb_prioritas pr
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
		$sqloreder=" ORDER BY up.vupb_nomor ASC";
		$sqlgr=" GROUP BY up.vupb_nomor";
		$q=$this->db_erp_pk->query($sql.$sqlgr.$sqloreder);
		$data['row']="0";
		$datdate=array();
		if($q->num_rows()>=1){
			$data['row']=$q->num_rows();
			$data['datarow']=$q->result_array();
			foreach ($q->result_array() as $k => $val) {
				$datdate[$k]=$this->diffInMonths($val['tupdate'],$val['tsubmit_prareg']);
			}
		}
		$data['datdate']=$datdate;

		$view=$this->load->view('details_bd1_5',$data,true);
		return $view;
    }

    public function BD1_6($imaster_id){
    	$dmas=$this->getDetMaster($imaster_id);
    	$tgl2=$dmas['tgl2'];
    	$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];
    	$dn=$this->getSemester($tgl2,TRUE);
    	$yn=$dn['tahun'];
    	$semestern=$dn['semester'];

    	$sql="select up.*,pr.iyear,pr.imonth,up.dinput_applet ";
    	$sqlco="select count(distinct(up.iGroup_produk)) jml ";
    	$sqldis="select distinct(up.iGroup_produk) jml ";
    	$sql1="from plc2.plc2_upb_prioritas pr
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
		$sqloreder=" ORDER BY up.vupb_nomor ASC";
		$sqlgr=" GROUP BY up.vupb_nomor";
		$q=$this->db_erp_pk->query($sql.$sql1.$sqlgr.$sqloreder);
		$qc=$this->db_erp_pk->query($sqlco.$sql1);
		$qsc=$this->db_erp_pk->query($sqldis.$sql1);
		$data['row']="0";
		$data['rowsc']=array();
		if($q->num_rows()>=1){
			$data['row']=$q->num_rows();
			$data['datarow']=$q->result_array();
		}
		$data['rows']="-";
		if($qsc->num_rows()>=1){
			$data['datarowsc']=$qsc->result_array();
			$data['rows']="1";
		}
		
		$data['datarowc']=$qc->row_array();
		$view=$this->load->view('details_bd1_6',$data,true);
		return $view;

    }

    public function BD1_11($imaster_id){
    	$dmas=$this->getDetMaster($imaster_id);
    	$tgl2=$dmas['tgl2'];
    	$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];
    	$dn=$this->getSemester($tgl2,TRUE);
    	$yn=$dn['tahun'];
    	$semestern=$dn['semester'];

    	$sqls="select up.*, (select ad.dsrt_td from applet_dokumen ad where ad.iupb_id=up.iupb_id order by ad.iapplet_dok_id DESC Limit 1) as ttambahan";
    	$sql_date=" from plc2.plc2_upb_prioritas pr
				inner join plc2.plc2_upb_prioritas_detail prdet on pr.iprioritas_id=prdet.iprioritas_id
				inner join plc2.plc2_upb up on prdet.iupb_id=up.iupb_id
				left join plc2.applet_dokumen ad on ad.iupb_id=up.iupb_id
				where pr.ldeleted=0 and prdet.ldeleted=0 and up.iappdireksi=2 and ad.ldeleted=0
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
		$sqlorder=" group by up.iupb_id";
    	$q=$this->db_erp_pk->query($sqls.$sql_date.$sqlorder);
		$data['row']="0";
		$sm=array();
		if($q->num_rows()>=1){
			$data['row']=$q->num_rows();
			$data['datarow']=$q->result_array();
			
			foreach ($q->result_array() as $kq => $vq) {
				$n1=$vq['ttarget_noreg'];
				if($vq['itambahan_applet']==1){
					$n2=$vq["ttambahan"];
				}else{
					$n2=$vq["ttarget_hpr"];
				}
				$sm[$kq]=$this->diffInMonths($n1,$n2);
			}
		}
		$data['rselisih']=$sm;
		$view=$this->load->view('details_bd1_11',$data,true);
		return $view;
    }

    public function BD1_12($imaster_id){
    	$dmas=$this->getDetMaster($imaster_id);
    	$tgl2=$dmas['tgl2'];
    	$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];
    	$dn=$this->getSemester($tgl2,TRUE);
    	$yn=$dn['tahun'];
    	$semestern=$dn['semester'];

    	$sqls="select up.*";
    	$sql_date=" from plc2.plc2_upb_prioritas pr
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
				AND concat(pr.iyear,'0',pr.imonth) = ".$y.$semester;
		$sqlorder=" group by up.iupb_id";
    	$q=$this->db_erp_pk->query($sqls.$sql_date.$sqlorder);
		$data['row']="0";
		$data['rselisih']=array();
		if($q->num_rows()>=1){
			$data['row']=$q->num_rows();
			$data['datarow']=$q->result_array();
			foreach ($q->result_array() as $kq => $vq) {
				$n1=$vq['ttarget_noreg'];
				$n2=$vq['dinput_applet'];
				$sm[$kq]=$this->diffInMonths($n1,$n2);
			}
			$data['rselisih']=$sm;
		}
		$view=$this->load->view('details_bd1_12',$data,true);
		return $view;
    }

    function BD2_1($imaster_id){
		$dmas=$this->getDetMaster($imaster_id);
    	
    	$tgl2=$dmas['tgl2'];
    	$team_id=$dmas['iteam_id'];
    	$tanggal = strtotime($tgl2);
    	$now = date("m", $tanggal);
    	$itim= $team_id;$periode1 = date("Y", $tanggal);


		$noww=date('m');

		switch ($noww) {
			case '01':
			case '02':
			case '03': 
			case '04':
			case '05':
			case '06':
				$smesters = 1;
				break;			
			case '07':
			case '08':
			case '09':
			case '10':
			case '11':
			case '12':
				$smesters = 2;
				break;
			default:
				$smesters = 1;
				break;
		}
		$periode = $periode1.$smesters;
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

 		//Modify Semester
 		$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];

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

		//$sql_par .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester;
		$sql_par .= ' order by a.iupb_id desc';
		$dupb = $this->db_erp_pk->query($sql_par)->row_array();

		$sql_pard = 'select 
					a.*,c.iyear,c.imonth
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

		//$sql_pard .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_pard .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_pard .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester;
		$sql_pard .= ' order by a.iupb_id desc';
		$dupbd = $this->db_erp_pk->query($sql_pard)->result_array();

		$sql_parc = 'select 
					distinct(a.iGroup_produk) groupnya
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

		//$sql_parc .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_parc .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_parc .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester;
		$sql_parc .= ' order by a.iupb_id desc';
		$dupbc = $this->db_erp_pk->query($sql_parc)->result_array();

		$data['sql_par']=$sql_par;
		$data['count']=$dupb['jum'];
		$data['group']=$dupbc;
		$data['sql_parc']=$sql_parc;
		$data['datas']=$dupbd;

		$view=$this->load->view('detail_perform/bd2_1',$data,true);
		return $view;
	}

	function BD2_2($imaster_id){
		$dmas=$this->getDetMaster($imaster_id);
    	
    	$tgl2=$dmas['tgl2'];
    	$team_id=$dmas['iteam_id'];
    	$tanggal = strtotime($tgl2);
    	$now = date("m", $tanggal);
    	$itim= $team_id;$periode1 = date("Y", $tanggal);

		$noww=date('m');

		switch ($noww) {
			case '01':
			case '02':
			case '03': 
			case '04':
			case '05':
			case '06':
				$smesters = 1;
				break;			
			case '07':
			case '08':
			case '09':
			case '10':
			case '11':
			case '12':
				$smesters = 2;
				break;
			default:
				$smesters = 1;
				break;
		}
		$periode = $periode1.$smesters;
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

 		//Modify Semester
 		$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];


		$sql_par = 'select 
					a.*,c.iyear,c.imonth,d.*
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					join plc2.plc2_upb_team d on d.iteam_id = a.iteammarketing_id
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
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= 'group by a.iupb_id order by a.iupb_id desc';
		//echo $sql_par;

		// jumlah tim marketing 
		$sql_par2 = 'select 
					distinct(d.vteam) as penyebut
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					join plc2.plc2_upb_team d on d.iteam_id = a.iteammarketing_id
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
		//$sql_par2 .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par2 .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par2 .= 'order by a.iupb_id desc';


		$dcount = $this->db_erp_pk->query($sql_par2)->result_array();
		$dupb = $this->db_erp_pk->query($sql_par)->result_array();


		$data['count']=$dcount;
		$data['datas']=$dupb;

		$view=$this->load->view('detail_perform/bd2_2',$data,true);
		return $view;
	}

	function BD2_3($imaster_id){
		$dmas=$this->getDetMaster($imaster_id);
    	
    	$tgl2=$dmas['tgl2'];
    	$team_id=$dmas['iteam_id'];
    	$tanggal = strtotime($tgl2);
    	$now = date("m", $tanggal);
    	$itim= $team_id;$periode1 = date("Y", $tanggal);

		$noww=date('m');

		switch ($noww) {
			case '01':
			case '02':
			case '03': 
			case '04':
			case '05':
			case '06':
				$smesters = 1;
				break;			
			case '07':
			case '08':
			case '09':
			case '10':
			case '11':
			case '12':
				$smesters = 2;
				break;
			default:
				$smesters = 1;
				break;
		}
		$periode = $periode1.$smesters;
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

 		//Modify Semester
 		$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];

		$sql_par = 'select 
					a.*,c.iyear,c.imonth,d.*,e.*
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					join plc2.plc2_upb_team d on d.iteam_id = a.iteammarketing_id
					join plc2_upb_master_kategori_upb e on e.ikategori_id=a.ikategoriupb_id
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
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= 'group by a.iupb_id order by a.iupb_id desc';
		//echo $sql_par;

		// jumlah tim marketing 
		$sql_par2 = 'select 
					a.*,c.iyear,c.imonth,d.*,e.*
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					join plc2.plc2_upb_team d on d.iteam_id = a.iteammarketing_id
					join plc2_upb_master_kategori_upb e on e.ikategori_id=a.ikategoriupb_id
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
		//$sql_par2 .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par2 .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par2 .= 'group by a.iupb_id order by a.iupb_id desc';


		$dcount = $this->db_erp_pk->query($sql_par2)->result_array();
		$dupb = $this->db_erp_pk->query($sql_par)->result_array();


		$data['datas2']=$dcount;
		$data['datas']=$dupb;

		$view=$this->load->view('detail_perform/bd2_3',$data,true);
		return $view;
	}

	function BD2_4($imaster_id){
		$dmas=$this->getDetMaster($imaster_id);
    	
    	$tgl2=$dmas['tgl2'];
    	$team_id=$dmas['iteam_id'];
    	$tanggal = strtotime($tgl2);
    	$now = date("m", $tanggal);
    	$itim= $team_id;$periode1 = date("Y", $tanggal);

		$noww=date('m');

		switch ($noww) {
			case '01':
			case '02':
			case '03': 
			case '04':
			case '05':
			case '06':
				$smesters = 1;
				break;			
			case '07':
			case '08':
			case '09':
			case '10':
			case '11':
			case '12':
				$smesters = 2;
				break;
			default:
				$smesters = 1;
				break;
		}
		$periode = $periode1.$smesters;

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

 		//Modify Semester
 		$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];

		$sql_par = 'select 
					a.*,c.iyear,c.imonth,d.*,e.*,datediff(
					a.ttarget_prareg,date(d.tupdate)) as selisih, d.tupdate as tgl_dr
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					join plc2.plc2_upb_approve d on d.iupb_id=a.iupb_id and d.vtipe="DR"
					join plc2_upb_master_kategori_upb e on e.ikategori_id=a.ikategoriupb_id
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
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= 'group by a.iupb_id order by a.iupb_id desc';
		//echo $sql_par;

		// jumlah tim marketing 
		$sql_par2 = 'select 
					count(distinct(a.iupb_id)) as penyebut
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					join plc2.plc2_upb_approve d on d.iupb_id=a.iupb_id and d.vtipe="DR"
					join plc2_upb_master_kategori_upb e on e.ikategori_id=a.ikategoriupb_id
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
		//$sql_par2 .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par2 .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par2 .= 'order by a.iupb_id desc';


		$dcount = $this->db_erp_pk->query($sql_par2)->row_array();
		$dupb = $this->db_erp_pk->query($sql_par)->result_array();


		$data['datas2']=$dcount;
		$data['datas']=$dupb;

		$view=$this->load->view('detail_perform/bd2_4',$data,true);
		return $view;
	}

	function BD2_5($imaster_id){
		$dmas=$this->getDetMaster($imaster_id);
    	
    	$tgl2=$dmas['tgl2'];
    	$team_id=$dmas['iteam_id'];
    	$tanggal = strtotime($tgl2);
    	$now = date("m", $tanggal);
    	$itim= $team_id;$periode1 = date("Y", $tanggal);

		$noww=date('m');

		switch ($noww) {
			case '01':
			case '02':
			case '03': 
			case '04':
			case '05':
			case '06':
				$smesters = 1;
				break;			
			case '07':
			case '08':
			case '09':
			case '10':
			case '11':
			case '12':
				$smesters = 2;
				break;
			default:
				$smesters = 1;
				break;
		}
		$periode = $periode1.$smesters;
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

 		//Modify Semester
 		$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];

		$sql_par = 'select 
					a.*,c.iyear,c.imonth
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
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= 'group by a.iupb_id order by a.iupb_id desc';
		//echo $sql_par;

		$dupb = $this->db_erp_pk->query($sql_par)->result_array();
		$data['datas']=$dupb;

		$view=$this->load->view('detail_perform/bd2_5',$data,true);
		return $view;
	}

	function BD2_6($imaster_id){
		$dmas=$this->getDetMaster($imaster_id);
    	
    	$tgl2=$dmas['tgl2'];
    	$team_id=$dmas['iteam_id'];
    	$tanggal = strtotime($tgl2);
    	$now = date("m", $tanggal);
    	$itim= $team_id;$periode1 = date("Y", $tanggal);

		$noww=date('m');

		switch ($noww) {
			case '01':
			case '02':
			case '03': 
			case '04':
			case '05':
			case '06':
				$smesters = 1;
				break;			
			case '07':
			case '08':
			case '09':
			case '10':
			case '11':
			case '12':
				$smesters = 2;
				break;
			default:
				$smesters = 1;
				break;
		}
		$periode = $periode1.$smesters;
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

 		//Modify Semester
 		$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];

		$sql_par = 'select 
					a.*,c.iyear,c.imonth,d.*
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					join plc2.plc2_upb_team d on d.iteam_id = a.iteammarketing_id
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

		//$sql_par .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= 'group by a.iupb_id order by a.iupb_id desc';
		//echo $sql_par;

		// jumlah tim marketing 
		$sql_par2 = 'select 
					distinct(d.vteam) as penyebut
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					join plc2.plc2_upb_team d on d.iteam_id = a.iteammarketing_id
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

		//$sql_par2 .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par2 .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par2 .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par2 .= 'order by a.iupb_id desc';


		$dcount = $this->db_erp_pk->query($sql_par2)->result_array();
		$dupb = $this->db_erp_pk->query($sql_par)->result_array();


		$data['count']=$dcount;
		$data['datas']=$dupb;

		$view=$this->load->view('detail_perform/bd2_6',$data,true);
		return $view;
	}

	function BD2_7($imaster_id){
		$dmas=$this->getDetMaster($imaster_id);
    	
    	$tgl2=$dmas['tgl2'];
    	$team_id=$dmas['iteam_id'];
    	$tanggal = strtotime($tgl2);
    	$now = date("m", $tanggal);
    	$itim= $team_id;$periode1 = date("Y", $tanggal);

		$noww=date('m');

		switch ($noww) {
			case '01':
			case '02':
			case '03': 
			case '04':
			case '05':
			case '06':
				$smesters = 1;
				break;			
			case '07':
			case '08':
			case '09':
			case '10':
			case '11':
			case '12':
				$smesters = 2;
				break;
			default:
				$smesters = 1;
				break;
		}
		$periode = $periode1.$smesters;
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

 		//Modify Semester
 		$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];


		$sql_par = 'select 
					a.*,c.iyear,c.imonth,datediff(date(a.ttarget_hpr),a.ttarget_prareg) as selisih
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
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= ' order by a.iupb_id desc';
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
		//$sql_par2 .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par2 .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par2 .= 'order by a.iupb_id desc';


		$dcount = $this->db_erp_pk->query($sql_par2)->row_array();
		$dupb = $this->db_erp_pk->query($sql_par)->result_array();


		$data['datas2']=$dcount;
		$data['datas']=$dupb;

		$view=$this->load->view('detail_perform/bd2_7',$data,true);
		return $view;
	}

	function BD2_8($imaster_id){
		$dmas=$this->getDetMaster($imaster_id);
    	
    	$tgl2=$dmas['tgl2'];
    	$team_id=$dmas['iteam_id'];
    	$tanggal = strtotime($tgl2);
    	$now = date("m", $tanggal);
    	$itim= $team_id;$periode1 = date("Y", $tanggal);

		$noww=date('m');

		switch ($noww) {
			case '01':
			case '02':
			case '03': 
			case '04':
			case '05':
			case '06':
				$smesters = 1;
				break;			
			case '07':
			case '08':
			case '09':
			case '10':
			case '11':
			case '12':
				$smesters = 2;
				break;
			default:
				$smesters = 1;
				break;
		}
		$periode = $periode1.$smesters;
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

 		//Modify Semester
 		$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];

		$sql_par = 'select 
					a.*,c.iyear,c.imonth,datediff(date(a.ttarget_reg),a.ttarget_hpr) as selisih
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
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= ' order by a.iupb_id desc';
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
		//$sql_par2 .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par2 .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par2 .= 'order by a.iupb_id desc';


		$dcount = $this->db_erp_pk->query($sql_par2)->row_array();
		$dupb = $this->db_erp_pk->query($sql_par)->result_array();


		$data['datas2']=$dcount;
		$data['datas']=$dupb;

		$view=$this->load->view('detail_perform/bd2_8',$data,true);
		return $view;
	}
	function BD2_9($imaster_id){
		$dmas=$this->getDetMaster($imaster_id);
    	
    	$tgl2=$dmas['tgl2'];
    	$team_id=$dmas['iteam_id'];
    	$tanggal = strtotime($tgl2);
    	$now = date("m", $tanggal);
    	$itim= $team_id;$periode1 = date("Y", $tanggal);

		$noww=date('m');

		switch ($noww) {
			case '01':
			case '02':
			case '03': 
			case '04':
			case '05':
			case '06':
				$smesters = 1;
				break;			
			case '07':
			case '08':
			case '09':
			case '10':
			case '11':
			case '12':
				$smesters = 2;
				break;
			default:
				$smesters = 1;
				break;
		}
		$periode = $periode1.$smesters;
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

 		//Modify Semester
 		$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];

		$sql_par = 'select 
					a.*,c.iyear,c.imonth
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
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= 'group by a.iupb_id order by a.iupb_id desc';
		//echo $sql_par;

		$sql_parc = 'select 
					distinct(a.iGroup_produk) groupnya
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
					and a.tsubmit_dokapplet <> "0000-00-00"';

		//$sql_parc .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		$sql_parc .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_parc .= 'order by a.iupb_id desc';
		$dupbc = $this->db_erp_pk->query($sql_parc)->result_array();


		$dupb = $this->db_erp_pk->query($sql_par)->result_array();
		$data['datas']=$dupb;
		$data['group']=$dupbc;
		$view=$this->load->view('detail_perform/bd2_9',$data,true);
		return $view;
	}
	function BD2_10($imaster_id){
		$dmas=$this->getDetMaster($imaster_id);
    	
    	$tgl2=$dmas['tgl2'];
    	$team_id=$dmas['iteam_id'];
    	$tanggal = strtotime($tgl2);
    	$now = date("m", $tanggal);
    	$itim= $team_id;$periode1 = date("Y", $tanggal);

		$noww=date('m');

		switch ($noww) {
			case '01':
			case '02':
			case '03': 
			case '04':
			case '05':
			case '06':
				$smesters = 1;
				break;			
			case '07':
			case '08':
			case '09':
			case '10':
			case '11':
			case '12':
				$smesters = 2;
				break;
			default:
				$smesters = 1;
				break;
		}
		$periode = $periode1.$smesters;
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

 		//Modify Semester
 		$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];

		$sql_par = 'select 
					a.*,c.iyear,c.imonth
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
					and a.tsubmit_dokapplet is not null
					and a.tsubmit_dokapplet <> "1970-01-01"
					and a.tsubmit_dokapplet <> "0000-00-00"

					';

		//$sql_par .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= 'group by a.iupb_id order by a.iupb_id desc';
		//echo $sql_par;

		$sql_parc = 'select 
					distinct(a.iGroup_produk) groupnya
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
					and a.tsubmit_dokapplet is not null
					and a.tsubmit_dokapplet <> "1970-01-01"
					and a.tsubmit_dokapplet <> "0000-00-00"';

		//$sql_parc .=' and concat(c.iyear,c.imonth) >="'.$tahun.$imonth.'"  ';
		$sql_parc .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_parc .= 'order by a.iupb_id desc';
		$dupbc = $this->db_erp_pk->query($sql_parc)->result_array();


		$dupb = $this->db_erp_pk->query($sql_par)->result_array();
		$data['datas']=$dupb;
		$data['group']=$dupbc;
		$view=$this->load->view('detail_perform/bd2_10',$data,true);
		return $view;
	}
	function BD2_11($imaster_id){
		$dmas=$this->getDetMaster($imaster_id);
    	
    	$tgl2=$dmas['tgl2'];
    	$team_id=$dmas['iteam_id'];
    	$tanggal = strtotime($tgl2);
    	$now = date("m", $tanggal);
    	$itim= $team_id;$periode1 = date("Y", $tanggal);

		$noww=date('m');

		switch ($noww) {
			case '01':
			case '02':
			case '03': 
			case '04':
			case '05':
			case '06':
				$smesters = 1;
				break;			
			case '07':
			case '08':
			case '09':
			case '10':
			case '11':
			case '12':
				$smesters = 2;
				break;
			default:
				$smesters = 1;
				break;
		}
		$periode = $periode1.$smesters;
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

 		//Modify Semester
 		$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];

		$sql_par = 'select 
					a.*,c.iyear,c.imonth,datediff(date(a.ttarget_noreg),a.ttarget_reg) as selisih
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
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= ' order by a.iupb_id desc';
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
		//$sql_par2 .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par2 .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par2 .= 'order by a.iupb_id desc';


		$dcount = $this->db_erp_pk->query($sql_par2)->row_array();
		$dupb = $this->db_erp_pk->query($sql_par)->result_array();


		$data['datas2']=$dcount;
		$data['datas']=$dupb;

		$view=$this->load->view('detail_perform/bd2_11',$data,true);
		return $view;
	}	

	function BD2_12($imaster_id){
		$dmas=$this->getDetMaster($imaster_id);
    	
    	$tgl2=$dmas['tgl2'];
    	$team_id=$dmas['iteam_id'];
    	$tanggal = strtotime($tgl2);
    	$now = date("m", $tanggal);
    	$itim= $team_id;$periode1 = date("Y", $tanggal);

		$noww=date('m');

		switch ($noww) {
			case '01':
			case '02':
			case '03': 
			case '04':
			case '05':
			case '06':
				$smesters = 1;
				break;			
			case '07':
			case '08':
			case '09':
			case '10':
			case '11':
			case '12':
				$smesters = 2;
				break;
			default:
				$smesters = 1;
				break;
		}
		$periode = $periode1.$smesters;
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

 		//Modify Semester
 		$d=$this->getSemester($tgl2,FALSE);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];

		$sql_par = 'select 
					a.*,c.iyear,c.imonth,
					datediff(date(a.ttarget_noreg),  if(a.tTd_applet is not null,a.tTd_applet,a.ttarget_noreg )  ) as selisih
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
		//$sql_par .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par .= ' order by a.iupb_id desc';
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
		//$sql_par2 .=' and  concat(c.iyear,c.imonth) <= "'.$periode.'" ';
		$sql_par2 .= " AND concat(c.iyear,'0',c.imonth) = ".$y.$semester." ";
		$sql_par2 .= 'order by a.iupb_id desc';


		$dcount = $this->db_erp_pk->query($sql_par2)->row_array();
		$dupb = $this->db_erp_pk->query($sql_par)->result_array();


		$data['datas2']=$dcount;
		$data['datas']=$dupb;

		$view=$this->load->view('detail_perform/bd2_12',$data,true);
		return $view;
	}	



    public function BD2_1xx($imaster_id){
    	$dmas=$this->getDetMaster($imaster_id);
    	$tgl2=$dmas['tgl2'];
    	$d=$this->getSemester($tgl2);
    	$team_id=$dmas['iteam_id'];
    	$tahun=$d['tahun'];
    	$semester=$d['semester'];

    	$sql_par = 'select 
					#group distinct karena hanya mengambil jumlah group produk
					count(distinct(a.iGroup_produk)) jum 
					from plc2.plc2_upb a 
					join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
					join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
					where 
					#upb team nya 
						a.iteambusdev_id="'.$team_id.'" 
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
		$sql_par .=' and concat(c.iyear,c.imonth) >="'.$tahun.$semester.'"  ';
		$sql_par .= 'order by a.iupb_id desc';
		$dupb = $this->db_erp_pk->query($sql_par)->row_array();
    	
		$data['jum']=$dupb['jum'];
		$view=$this->load->view('detail_perform/bd2_1',$data,true);
		return $view;
    }
    public function BD2_1xxx($imaster_id){
    	$dmas=$this->getDetMaster($imaster_id);
    	$tgl2=$dmas['tgl2'];
    	$d=$this->getSemester($tgl2);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];
    	$sqlc="select distinct(up.iGroup_produk) jml ";
    	$sqls="select up.*,pr.iyear,pr.imonth ";
    	$sqlf="from plc2.plc2_upb_prioritas pr
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
				AND concat(pr.iyear,'0',pr.imonth)>=".$y.$semester;
		$sqloreder=" ORDER BY up.iGroup_produk ASC";
		$qcount=$sqlc.$sqlf;
		$qall=$sqls.$sqlf.$sqloreder;
		$dtall=$this->db_erp_pk->query($qall);
		$dtcount=$this->db_erp_pk->query($qcount);
		if($dtall->num_rows()>=1){
			$data['dataall']=$dtall->result_array();
			$data['row']='1';
		}else{
			$data['row']='nol';
		}
		$data['jmlupb']=$dtall->num_rows();
		if($dtcount->num_rows()>=1){
			$data['datacount']=$dtcount->result_array();
		}else{
			$data['datacount']='0';
		}
		$view=$this->load->view('detail_perform/bd2_1',$data,true);
		return $view;
    }

    public function BD2_3x($imaster_id){
    	$dmas=$this->getDetMaster($imaster_id);
    	$tgl2=$dmas['tgl2'];
    	$d=$this->getSemester($tgl2);
    	$team_id=$dmas['iteam_id'];
    	$y=$d['tahun'];
    	$semester=$d['semester'];
    	$sqlco="select count(distinct(up.iupb_id)) jml ";
    	$sqlall="select up.*,pr.iyear,pr.imonth,kat.vkategori ";
    	$sql1="	from plc2.plc2_upb_prioritas pr
				inner join plc2.plc2_upb_prioritas_detail prdet on pr.iprioritas_id=prdet.iprioritas_id
				inner join plc2.plc2_upb up on prdet.iupb_id=up.iupb_id
				left join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=up.ikategoriupb_id
				where pr.ldeleted=0 and prdet.ldeleted=0 and up.iappdireksi=2
				#Sesuai Team Busdevnya
				AND up.iteambusdev_id=".$team_id."
				#UPB setting Prioritas yang sudah di approve
				AND pr.iappbusdev=2
				#UPB sudah setting Prioritas 4 Semester Lalu
				AND concat(pr.iyear,'0',pr.imonth)>=".$y.$semester;
		$sql2 =$sql1;
		$sql2.='#kategori UPB A
				AND up.ikategoriupb_id=10';
		$sqloreder=" ORDER BY up.vupb_nomor ASC";
		$sqlgr=" GROUP BY up.vupb_nomor";
		$qsql1all=$this->db_erp_pk->query($sqlall.$sql1.$sqlgr.$sqloreder);
		$qsql1count=$this->db_erp_pk->query($sqlco.$sql1.$sqloreder);
		$qsql2all=$this->db_erp_pk->query($sqlall.$sql2.$sqlgr.$sqloreder);
		$qsql2count=$this->db_erp_pk->query($sqlco.$sql2.$sqloreder);
		$data['row1']="0";
		$data['jrow1']="0";
		if($qsql1all->num_rows()>=1){
			$data['row1']="1";
			$data["dt1"]=$qsql1all->result_array();
			$data['jrow1']=$qsql1count->row_array();
		}
		$data['row2']="0";
		$data['jrow2']="0";
		if($qsql1all->num_rows()>=1){
			$data['row2']="1";
			$data["dt2"]=$qsql2all->result_array();
			$data['jrow2']=$qsql2count->row_array();
		}
		$view=$this->load->view('detail_perform/bd2_3',$data,true);
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

