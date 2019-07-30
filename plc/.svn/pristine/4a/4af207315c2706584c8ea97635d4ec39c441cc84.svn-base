<?php if (!defined('BASEPATH')) exit('No direct access is allowed');
class tracking_upb extends MX_Controller {
	
	private $dbset;
	private $url;
	private $sess_auth;
	
	public function __construct() {
		parent::__construct();
		$this->db_pl0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->load->library('lib_utilitas');
		$this->user = $this->auth->user();

	}
	
	function index($action = '') {		
    	//Bikin Object Baru Nama nya $grid
    	$action = $this->input->get('action') ? $this->input->get('action') : 'piew';	
	
		$grid = new Grid;		
		$grid->setTitle('Where\'s my UPB');		
		$grid->setTable('plc.plc2_upb');		
		$grid->setUrl('tracking_upb');		
			
		switch ($action) {		
			case 'piew':
				$this->load->view('manual/tracking_upb');
				break;
			case 'getcoloralert':
				echo $this->getcoloralert();
				break;
			case 'getrequirement':
				echo $this->getrequirement();
				break;
			case 'getdetail':
				echo $this->getdetail();
				break;
			case 'getkey':
				echo $this->getkey($this->input->post('module_id'));
				break;
			default:
				$grid->render_grid();
				break;
		}
	}

	function getkey($module_id=0){
		$data['status']=false;
		if($module_id!=0){
			$data['status']=true;
			$sql="select * from plc2.master_proses a where a.lDeleted=0 and a.master_proses_id=".$module_id;
			$d=$this->db_pl0->query($sql)->row_array();
			$data['hasil']=$d['ikey_id'];
			return json_encode($data);
		}else{
			return json_encode($data);
		}
	}

	function getrequirement(){
		$idmodul=$_POST['module_id'];

		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_pl0->query($sql_mod)->row_array();

		$sql='select * from plc2.master_proses_requirement a where a.master_proses_id="'.$idmodul.'"';
		$reqs = $this->db_pl0->query($sql)->result_array();
		$data['reqs'] = $reqs;
		$data['mod'] = $mod;
		$view = $this->load->view('manual/part_requirement',$data,TRUE);

			return $view;
	}



	function getcoloralert(){
		//print_r($_POST);
		$idmodul=$_POST['module_id'];
		$id=$_POST['id'];

		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_pl0->query($sql_mod)->row_array();

		//print_r($mod);
		if(method_exists(get_class($this),$mod['vKode_modul'])) {
			 $this->$mod['vKode_modul']("$id");
		}


		
	}

	function P00002($id){
			$data = array();
			$sql='
					SELECT plc2.plc2_upb_team.vteam AS pdTeamName, plc2.plc2_upb_master_kategori_upb.vkategori AS katUpb, /*browse_upb_setprareg/browse_upb_setprareg.php/output*/plc2.plc2_upb.*
					FROM (`plc2`.`plc2_upb`)
					INNER JOIN `plc2`.`plc2_upb_team` ON `plc2`.`plc2_upb`.`iteampd_id`=`plc2`.`plc2_upb_team`.`iteam_id`
					INNER JOIN `plc2`.`plc2_upb_master_kategori_upb` ON `plc2`.`plc2_upb`.`ikategoriupb_id`=`plc2`.`plc2_upb_master_kategori_upb`.`ikategori_id`
					WHERE `iappdireksi` =  2
					AND `ihold` =  0
					AND `plc2`.`plc2_upb`.`iupb_id` not in (0)
					AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"
					GROUP BY iupb_id
			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}

	function P00003($id){
			$data = array();
			$sql='
				SELECT /*browse_upb_request_originator/browse_upb_request_originator.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				WHERE 
				`istatus` = "7" 
				AND `vkat_originator` = "3" 
				AND `plc2_upb`.`iupb_id` not in (select a.iupb_id from plc2.plc2_upb a 
				 join plc2.plc2_upb_request_originator b on a.iupb_id = b.iupb_id 
				 where (b.iapppd=0 or b.isent_status=0 )
				 group by a.iupb_id) 
				AND `plc2_upb`.`iupb_id` not in (select a.iupb_id from plc2.plc2_upb a 
				 join plc2.plc2_upb_request_originator b on a.iupb_id = b.iupb_id 
				 join plc2.plc2_upb_date_sample c on b.ireq_ori_id = c.iReq_ori_id
				 where (b.iapppd=0 or b.isent_status=0 or c.dTanggalTerimaPD is null )
				 group by a.iupb_id) 
				AND `plc2_upb`.`iupb_id` not in(
				 select a.iupb_id from plc2.study_literatur_pd a where a.lDeleted=0 
				 union
				 select b.iupb_id from plc2.study_literatur_ad b where b.lDeleted=0 
				 union
				 select c.iupb_id from plc2.plc2_upb_bahan_kemas c where c.ldeleted=0 

				 )

				AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"
				GROUP BY iupb_id

			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}

	function P00005($id){
			$data = array();
			$sql='
				SELECT plc2.plc2_upb_team.vteam AS pdTeamName, plc2.plc2_upb_master_kategori_upb.vkategori AS katUpb, /*plc_upb_daftar_bahan_kemas/plc_upb_daftar_bahan_kemas.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				INNER JOIN `plc2`.`plc2_upb_team` ON `plc2`.`plc2_upb`.`iteampd_id`=`plc2`.`plc2_upb_team`.`iteam_id`
				INNER JOIN `plc2`.`plc2_upb_master_kategori_upb` ON `plc2`.`plc2_upb`.`ikategoriupb_id`=`plc2`.`plc2_upb_master_kategori_upb`.`ikategori_id`
				WHERE `plc2`.`plc2_upb`.`iupb_id` in (select pd.iupb_id from plc2.plc2_upb_prioritas_detail pd 
				 inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=pd.iprioritas_id
				 where pd.ldeleted=0 and pr.iappbusdev=2 )
				AND (CASE WHEN plc2_upb.vkat_originator=3 THEN plc2.plc2_upb.iupb_id in (select ro.iupb_id from plc2.plc2_upb_request_originator ro where ro.ldeleted=0 and ro.isent_status=1)
				 else plc2.`plc2_upb`.`iupb_id` in (select pd.iupb_id from plc2.plc2_upb_prioritas_detail pd inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=pd.iprioritas_id where pd.ldeleted=0 and pr.iappbusdev=2)
				 END)
				AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"
				GROUP BY iupb_id

			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}

	function P00006($id){
			$data = array();
			$sql='
				SELECT plc2.plc2_upb_team.vteam AS pdTeamName, plc2.plc2_upb_master_kategori_upb.vkategori AS katUpb, /*study_literatur_pd_popup/study_literatur_pd_popup.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				INNER JOIN `plc2`.`plc2_upb_team` ON `plc2`.`plc2_upb`.`iteampd_id`=`plc2`.`plc2_upb_team`.`iteam_id`
				INNER JOIN `plc2`.`plc2_upb_master_kategori_upb` ON `plc2`.`plc2_upb`.`ikategoriupb_id`=`plc2`.`plc2_upb_master_kategori_upb`.`ikategori_id`
				WHERE `plc2`.`plc2_upb`.`iupb_id` in (select pd.iupb_id from plc2.plc2_upb_prioritas_detail pd 
				 inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=pd.iprioritas_id
				 where pd.ldeleted=0 and pr.iappbusdev=2 )
				AND (CASE WHEN plc2_upb.vkat_originator=3 THEN plc2.plc2_upb.iupb_id in (select ro.iupb_id from plc2.plc2_upb_request_originator ro where ro.ldeleted=0 and ro.isent_status=1)
				 else plc2.`plc2_upb`.`iupb_id` in (select pd.iupb_id from plc2.plc2_upb_prioritas_detail pd inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=pd.iprioritas_id where pd.ldeleted=0 and pr.iappbusdev=2)
				 END)
				AND `iupb_id` not in (select iupb_id from plc2.study_literatur_pd where ldeleted=0 and iapppd !=1 )


				AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"

				GROUP BY iupb_id
				ORDER BY `vupb_nomor` desc
			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}

	function P00007($id){
			$data = array();
			$sql='
				SELECT plc2.plc2_upb_team.vteam AS pdTeamName, plc2.plc2_upb_master_kategori_upb.vkategori AS katUpb, /*study_literatur_ad_popup/study_literatur_ad_popup.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				INNER JOIN `plc2`.`plc2_upb_team` ON `plc2`.`plc2_upb`.`iteampd_id`=`plc2`.`plc2_upb_team`.`iteam_id`
				INNER JOIN `plc2`.`plc2_upb_master_kategori_upb` ON `plc2`.`plc2_upb`.`ikategoriupb_id`=`plc2`.`plc2_upb_master_kategori_upb`.`ikategori_id`
				WHERE `plc2`.`plc2_upb`.`iupb_id` in (select pd.iupb_id from plc2.plc2_upb_prioritas_detail pd 
				 inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=pd.iprioritas_id
				 where pd.ldeleted=0 and pr.iappbusdev=2 )
				AND (CASE WHEN plc2_upb.vkat_originator=3 THEN plc2.plc2_upb.iupb_id in (select ro.iupb_id from plc2.plc2_upb_request_originator ro where ro.ldeleted=0 and ro.isent_status=1)
				 else plc2.`plc2_upb`.`iupb_id` in (select pd.iupb_id from plc2.plc2_upb_prioritas_detail pd inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=pd.iprioritas_id where pd.ldeleted=0 and pr.iappbusdev=2)
				 END)
				AND `iupb_id` not in (select iupb_id from plc2.study_literatur_ad where ldeleted=0 and iappad !=1)

				AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"

				GROUP BY iupb_id
				ORDER BY `vupb_nomor` desc
			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}

	function P00008($id){
			$data = array();
			$sql='
				SELECT plc2.plc2_upb_team.vteam AS pdTeamName, plc2.plc2_upb_master_kategori_upb.vkategori AS katUpb, /*plc_upb_daftar_popup/plc_upb_daftar_popup.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				INNER JOIN `plc2`.`plc2_upb_team` ON `plc2`.`plc2_upb`.`iteampd_id`=`plc2`.`plc2_upb_team`.`iteam_id`
				INNER JOIN `plc2`.`plc2_upb_master_kategori_upb` ON `plc2`.`plc2_upb`.`ikategoriupb_id`=`plc2`.`plc2_upb_master_kategori_upb`.`ikategori_id`
				WHERE `iappdireksi` =  2
				AND `ihold` =  0
				AND `plc2`.`plc2_upb`.`iupb_id` in (select a.iupb_id from plc2.study_literatur_pd a where a.lDeleted=0 and a.iapppd=2)
				AND `plc2`.`plc2_upb`.`iupb_id` in (select a.iupb_id from plc2.study_literatur_ad a where a.lDeleted=0 and a.iappad=2)
				AND `iupb_id` not in (
				 select d.iupb_id
				 from plc2.plc2_upb_ro_detail a 
				 join plc2.plc2_upb_request_sample b on b.ireq_id=a.ireq_id
				 join plc2.plc2_upb_ro c on c.iro_id=a.iro_id
				 join plc2.plc2_upb d on d.iupb_id=b.iupb_id
				 join plc2.plc2_raw_material e on e.raw_id=a.raw_id
				 where 
				 a.vrec_nip_qc is not null
				 and a.trec_date_qc is not null
				 and a.ldeleted=0
				 and b.ldeleted=0
				 and c.ldeleted=0
				 and d.ldeleted=0
				 and e.ldeleted=0
				 

				 )
				AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"

				GROUP BY iupb_id
				ORDER BY `vupb_nomor` desc
			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}

	function P00009($id){
			$data = array();
			$sql='
				SELECT plc2.plc2_upb_team.vteam AS pdTeamName, plc2.plc2_upb_master_kategori_upb.vkategori AS katUpb, /*plc_upb_daftar_soibb_popup/plc_upb_daftar_soibb_popup.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				INNER JOIN `plc2`.`plc2_upb_team` ON `plc2`.`plc2_upb`.`iteampd_id`=`plc2`.`plc2_upb_team`.`iteam_id`
				INNER JOIN `plc2`.`plc2_upb_master_kategori_upb` ON `plc2`.`plc2_upb`.`ikategoriupb_id`=`plc2`.`plc2_upb_master_kategori_upb`.`ikategori_id`
				WHERE `iappdireksi` =  2
				AND `iprioritas` =  1
				AND `ihold` =  0
				AND `iupb_id` not in (select f.iupb_id from plc2.plc2_upb_soi_bahanbaku f where f.iappqc=0 and f.ldeleted=0)
				AND `iupb_id` in 
				 (
				 select rs.iupb_id from plc2.plc2_upb_request_sample rs 
				 inner join plc2.plc2_upb_ro_detail rod on rod.ireq_id=rs.ireq_id
				 where rs.iapppd=2 and rs.ldeleted=0 and rod.irelease=2 and rod.ldeleted=0
				 and rs.iTujuan_req=1
				 )
				AND `iupb_id` in (
				 select a.iupb_id from plc2.draft_soi_bb a where a.iApprove=2
				 )


				AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"

				GROUP BY iupb_id
				ORDER BY `vupb_nomor` desc
			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}

	function P00010($id){
			$data = array();
			$sql='
				SELECT plc2.plc2_upb_team.vteam AS pdTeamName, plc2.plc2_upb_master_kategori_upb.vkategori AS katUpb, /*plc_upb_daftar_fst_popup/plc_upb_daftar_fst_popup.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				INNER JOIN `plc2`.`plc2_upb_team` ON `plc2`.`plc2_upb`.`iteampd_id`=`plc2`.`plc2_upb_team`.`iteam_id`
				INNER JOIN `plc2`.`plc2_upb_master_kategori_upb` ON `plc2`.`plc2_upb`.`ikategoriupb_id`=`plc2`.`plc2_upb_master_kategori_upb`.`ikategori_id`
				WHERE `iappdireksi` =  2
				AND `ihold` =  0
				AND `iappbusdev_prareg` <> 2
				AND `iupb_id` in (select pd.iupb_id from plc2.plc2_upb_prioritas_detail pd 
				 inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=pd.iprioritas_id
				 where pd.ldeleted=0 and pr.iappbusdev=2 )
				AND (
				 #terima 
				 (
				 select 
				 count(b.raw_id)
				 from plc2.plc2_upb_ro a 
				 join plc2.plc2_upb_ro_detail b on b.iro_id=a.iro_id
				 join plc2.plc2_upb_request_sample c on c.ireq_id=b.ireq_id
				 where a.ldeleted=0
				 and b.ldeleted=0
				 and c.iupb_id = `plc2`.`plc2_upb`.iupb_id
				 )
				 >=
				 #minta
				 (
				 select IFNULL(count(bb.raw_id),0)
				 from plc2.plc2_upb_request_sample aa
				 join plc2.plc2_upb_request_sample_detail bb on bb.ireq_id=aa.ireq_id
				 where aa.ldeleted=0
				 and bb.ldeleted=0
				 and aa.iupb_id= `plc2`.`plc2_upb`.iupb_id
				 #group by aa.iupb_id
				 )
				 

				 )

				 
				AND `iupb_id` not in (
				 select a.iupb_id from plc2.plc2_upb_formula a where a.iformula_apppd=0
				 union
				 select a.iupb_id from plc2.plc2_upb_formula a where a.iformula_apppd=2 and a.istress=2
				 )
				

				AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"

				GROUP BY iupb_id
				ORDER BY `vupb_nomor` desc
			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}

	function P00011($id){
			$data = array();
			$sql='
				SELECT plc2.plc2_upb_team.vteam AS pdTeamName, plc2.plc2_upb_master_kategori_upb.vkategori AS katUpb, /*plc_upb_daftar_popup/plc_upb_daftar_popup.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				INNER JOIN `plc2`.`plc2_upb_team` ON `plc2`.`plc2_upb`.`iteampd_id`=`plc2`.`plc2_upb_team`.`iteam_id`
				INNER JOIN `plc2`.`plc2_upb_master_kategori_upb` ON `plc2`.`plc2_upb`.`ikategoriupb_id`=`plc2`.`plc2_upb_master_kategori_upb`.`ikategori_id`
				WHERE `iappdireksi` =  2
				AND `ihold` =  0
				AND `plc2_upb`.`iupb_id` in(
				 select a.iupb_id from plc2.plc2_upb_formula a where a.ldeleted=0 and a.iformula_apppd=2 and a.iwithbb=1 )
				 
				AND `plc2_upb`.`iupb_id` not in(
				 select a.iupb_id from plc2.plc2_upb_formula a where a.ldeleted=0 and a.ilab_apppd<>0 and a.iwithbb=1)
 
				AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"
				GROUP BY iupb_id

			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}

	function P00012($id){
			$data = array();
			$sql='
				SELECT /*browse_upb_request_originator/browse_upb_request_originator.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				WHERE `istatus` = "7" 
				AND `vkat_originator` = "3" 
				AND `ihold` =  0
				AND `plc2_upb`.`iupb_id` not in (select a.iupb_id from plc2.plc2_upb a 
				 join plc2.plc2_upb_request_originator b on a.iupb_id = b.iupb_id 
				 where (b.iapppd=0 or b.isent_status=0 )
				 group by a.iupb_id) 
				AND `plc2_upb`.`iupb_id` not in (select a.iupb_id from plc2.plc2_upb a 
				 join plc2.plc2_upb_request_originator b on a.iupb_id = b.iupb_id 
				 join plc2.plc2_upb_date_sample c on b.ireq_ori_id = c.iReq_ori_id
				 where (b.iapppd=0 or b.isent_status=0 or c.dTanggalTerimaPD is null )
				 group by a.iupb_id) 
				AND `plc2_upb`.`iupb_id` in(
				 select a.iupb_id from plc2.plc2_upb_formula a where a.ldeleted=0 and a.iformula_apppd=2 and a.iwithori=1 )
				 
				AND `plc2_upb`.`iupb_id` not in(
				 select a.iupb_id from plc2.plc2_upb_formula a where a.ldeleted=0 and a.ilab_apppd<>0 and a.iwithori=1)
 
 				AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"
				GROUP BY iupb_id

			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}

	function P00013($id){
			$data = array();
			$sql='
				SELECT plc2.plc2_upb_team.vteam AS pdTeamName, plc2.plc2_upb_master_kategori_upb.vkategori AS katUpb, /*plc_upb_daftar_popup/plc_upb_daftar_popup.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				INNER JOIN `plc2`.`plc2_upb_team` ON `plc2`.`plc2_upb`.`iteampd_id`=`plc2`.`plc2_upb_team`.`iteam_id`
				INNER JOIN `plc2`.`plc2_upb_master_kategori_upb` ON `plc2`.`plc2_upb`.`ikategoriupb_id`=`plc2`.`plc2_upb_master_kategori_upb`.`ikategori_id`
				WHERE `iappdireksi` =  2
				AND `ihold` =  0
				AND `plc2_upb`.`iupb_id` in(
				 select a.iupb_id from plc2.plc2_upb_formula a where a.iapp_basic=2 and a.iwithbasic=1
				 )
				 
				AND `plc2_upb`.`iupb_id` not in(
				 select a1.iupb_id from plc2.plc2_upb_formula a1
				 join plc2.plc2_upb_prodpilot b1 on b1.ifor_id=a1.ifor_id
				 where 
				 (b1.dtglmulai_prod is not null and b1.dtglmulai_prod !="0000-00-00" )
				 )
 
 				AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"
				GROUP BY iupb_id

			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}
	function P00015($id){ // function untuk module formula skala lab
			$data = array();
			$sql='SELECT *
				FROM (plc2.plc2_upb_formula)
				LEFT JOIN plc2.plc2_upb ON plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id
				INNER JOIN plc2.plc2_upb_team ON plc2.plc2_upb.iteampd_id=plc2.plc2_upb_team.iteam_id
				WHERE plc2_upb_formula.ifor_id='.$id.'
				AND plc2_upb_formula.ldeleted =  0 #formula status aktif
				AND plc2_upb.ihold =  0 #UPB tidak hold
				AND plc2_upb_formula.ilab <> 1 #hasil stess test berhasil
				AND plc2_upb_formula.iformula_apppd = 2 #formula sudah di approve pada formula skala trial
				AND plc2_upb_formula.ifor_id in (select fo.ifor_id from plc2.plc2_upb_formula fo
				 where 
				 (case when fo.iwithstress=1 then #Cek Melewati StresTest
				 (case when fo.iKeSkala_lab=1 then #Jika langsung ke skala lab
				 fo.istress_apppd=2
				 else
				 (case when fo.iwithbb=1 and fo.iwithori=1 then #Jika Melewati Permintaan sample dan melewati permintaan sample originator 
				 fo.iupb_id in (select req.iupb_id from plc2.plc2_upb_ro_detail rod
				 inner join plc2.plc2_upb_ro ro on rod.iro_id=ro.iro_id
				 inner join plc2.plc2_upb_request_sample req on req.ireq_id=rod.ireq_id
				 where rod.vwadah is not NULL and rod.vrec_jum_pd is not null) #Sample yang sudah diterima PD
				 AND fo.iupb_id in (select ori.iupb_id from plc2.plc2_upb_request_originator ori where ori.iapppd=2 and
				 ori.isent_status=1) #Sample Sudah di terima originator dan sudah di approve
				 when fo.iwithbb=1 and fo.iwithori=0 then
				 fo.iupb_id in (select req.iupb_id from plc2.plc2_upb_ro_detail rod
				 inner join plc2.plc2_upb_ro ro on rod.iro_id=ro.iro_id
				 inner join plc2.plc2_upb_request_sample req on req.ireq_id=rod.ireq_id
				 where rod.vwadah is not NULL and rod.vrec_jum_pd is not null)
				 when fo.iwithbb=0 and fo.iwithori=1 then
				 fo.iupb_id in (select ori.iupb_id from plc2.plc2_upb_request_originator ori where ori.iapppd=2 and ori
				 .isent_status=1)
				 end)
				 END)
				 else
				 fo.iformula_apppd=2
				 END))';
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				$result=1;
				
			}else{
				$result=0;
				
			}
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}
	function P00016($id){ // function untuk module formula skala lab
			$data = array();
			$sql='SELECT *
					FROM plc2.plc2_upb
					INNER JOIN plc2.plc2_upb_team ON plc2.plc2_upb.iteampd_id=plc2.plc2_upb_team.iteam_id
					INNER JOIN plc2.plc2_upb_master_kategori_upb ON plc2.plc2_upb.ikategoriupb_id=plc2.plc2_upb_master_kategori_upb.ikategori_id
					WHERE plc2_upb.iupb_id='.$id.'
					AND plc2_upb.iappdireksi =  2
					AND plc2_upb.ihold =  0
					AND plc2_upb.iupb_id in (select iupb_id from plc2.plc2_upb_formula where ilab_apppd=2 and ldeleted=0 group by iupb_id)
					AND plc2_upb.iupb_id not in (select f.iupb_id from plc2.plc2_upb_soi_fg f where f.ldeleted=0)
					AND plc2_upb.iupb_id in (select st.iupb_id from plc2.study_literatur_pd st where st.lDeleted=0 and st.iapppd=2)
					GROUP BY iupb_id';
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				$result=1;
				
			}else{
				$result=0;
				
			}
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}


	// Function OTC Start
	function C00002($id){
			//review_upb
			$data = array();
			$sql='
				SELECT plc2.plc2_upb_master_kategori_upb.vkategori AS upb_kat, hrd.mnf_kategori.vkategori AS mnf_kat, `hrd`.`mnf_sediaan`.`vsediaan`, plc2.plc2_biz_process_type.vName AS nama_type, /*upb_daftar_review/upb_daftar_review.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				INNER JOIN `plc2`.`plc2_upb_master_kategori_upb` ON `plc2`.`plc2_upb`.`ikategoriupb_id`=`plc2`.`plc2_upb_master_kategori_upb`.`ikategori_id`
				INNER JOIN `hrd`.`mnf_kategori` ON `plc2`.`plc2_upb`.`ikategori_id`=`hrd`.`mnf_kategori`.`ikategori_id`
				INNER JOIN `hrd`.`mnf_sediaan` ON `plc2`.`plc2_upb`.`isediaan_id`=`hrd`.`mnf_sediaan`.`isediaan_id`
				INNER JOIN `plc2`.`plc2_biz_process_type` ON `plc2`.`plc2_upb`.`itipe_id`=`plc2`.`plc2_biz_process_type`.`idplc2_biz_process_type`
				WHERE `plc2_upb`.`itipe_id` =  6
				AND `plc2`.`plc2_upb`.`ldeleted` =  0
				AND `plc2`.`plc2_upb`.`iappdireksi` =  2
 
 				AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"
		

			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}

	function C00003($id){
			//settingprareg
			$data = array();
			$sql='
				SELECT plc2.plc2_upb_team.vteam AS pdTeamName, plc2.plc2_upb_master_kategori_upb.vkategori AS katUpb, /*browse_upb_setprareg/browse_upb_setprareg.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				INNER JOIN `plc2`.`plc2_upb_team` ON `plc2`.`plc2_upb`.`iteampd_id`=`plc2`.`plc2_upb_team`.`iteam_id`
				INNER JOIN `plc2`.`plc2_upb_master_kategori_upb` ON `plc2`.`plc2_upb`.`ikategoriupb_id`=`plc2`.`plc2_upb_master_kategori_upb`.`ikategori_id`
				WHERE `iappdireksi` =  2
				AND `ihold` =  0
				AND `iReview` = "2" 
				AND `plc2`.`plc2_upb`.`iupb_id` not in (0)
				AND `plc2_upb`.`itipe_id` =  6
				AND `plc2`.`plc2_upb`.`ldeleted` =  0
				AND `plc2`.`plc2_upb`.`iSubmit_review` =  1
 				AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"
		

			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}

	function C00004($id){
			//reqoriginator
			$data = array();
			$sql='
				SELECT /*browse_upb_request_originator/browse_upb_request_originator.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				WHERE `istatus` = "7" 
				AND `ihold` =  0
				AND `iReview` = "2" 
				AND `plc2_upb`.`iupb_id` in(
				 select up.iupb_id from plc2.plc2_upb up 
				 where up.ldeleted=0
				 and (
				 select count(*) 
				 from plc2.otc_request_ori_detail a 
				 join plc2.plc2_upb_request_originator b on b.ireq_ori_id=a.ireq_ori_id
				 where a.lDeleted=0
				 and b.iupb_id=up.iupb_id
				 ) <
				 (
				 select count(*) from plc2.otc_produk_sejenis a 
				 join plc2.plc2_upb b on b.iupb_id=a.iupb_id
				 where
				 a.lDeleted=0
				 and b.ldeleted=0
				 and b.iupb_id=up.iupb_id
				 )
				 ) 
				 
				AND `plc2_upb`.`itipe_id` =  6
				AND `plc2`.`plc2_upb`.`ldeleted` =  0
				AND `plc2`.`plc2_upb`.`iSubmit_review` =  1
				
 				AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"
		

			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}

	function C00006($id){
			//reqoriginator
			$data = array();
			$sql='
				SELECT plc2.plc2_upb_team.vteam AS pdTeamName, plc2.plc2_upb_master_kategori_upb.vkategori AS katUpb, /*plc_upb_daftar_bahan_kemas/plc_upb_daftar_bahan_kemas.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				INNER JOIN `plc2`.`plc2_upb_team` ON `plc2`.`plc2_upb`.`iteampd_id`=`plc2`.`plc2_upb_team`.`iteam_id`
				INNER JOIN `plc2`.`plc2_upb_master_kategori_upb` ON `plc2`.`plc2_upb`.`ikategoriupb_id`=`plc2`.`plc2_upb_master_kategori_upb`.`ikategori_id`
				WHERE `plc2`.`plc2_upb`.`iupb_id` in (select pd.iupb_id from plc2.plc2_upb_prioritas_detail pd 
				 inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=pd.iprioritas_id
				 where pd.ldeleted=0 and pr.iappbusdev=2 )
				AND `plc2`.`plc2_upb`.`iupb_id` in (select ro.iupb_id 
				 from plc2.plc2_upb_request_originator ro 
				 join plc2.otc_request_ori_detail rd on rd.ireq_ori_id=ro.ireq_ori_id
				 where ro.ldeleted=0 
				 and rd.lDeleted=0
				 and rd.isent_status=1)
				AND `plc2_upb`.`itipe_id` =  6
				AND `plc2`.`plc2_upb`.`ldeleted` =  0
				
 				AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"
		

			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}

	function C00007($id){
			//bahankemassekunder
			$data = array();
			$sql='
				SELECT plc2.plc2_upb_team.vteam AS pdTeamName, plc2.plc2_upb_master_kategori_upb.vkategori AS katUpb, /*plc_upb_daftar_bahan_kemas/plc_upb_daftar_bahan_kemas.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				INNER JOIN `plc2`.`plc2_upb_team` ON `plc2`.`plc2_upb`.`iteampd_id`=`plc2`.`plc2_upb_team`.`iteam_id`
				INNER JOIN `plc2`.`plc2_upb_master_kategori_upb` ON `plc2`.`plc2_upb`.`ikategoriupb_id`=`plc2`.`plc2_upb_master_kategori_upb`.`ikategori_id`
				WHERE `plc2`.`plc2_upb`.`iupb_id` in (select pd.iupb_id from plc2.plc2_upb_prioritas_detail pd 
				 inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=pd.iprioritas_id
				 where pd.ldeleted=0 and pr.iappbusdev=2 )
				AND `plc2`.`plc2_upb`.`iupb_id` in (select ro.iupb_id 
				 from plc2.plc2_upb_request_originator ro 
				 join plc2.otc_request_ori_detail rd on rd.ireq_ori_id=ro.ireq_ori_id
				 where ro.ldeleted=0 
				 and rd.lDeleted=0
				 and rd.isent_status=1)
				AND `plc2_upb`.`itipe_id` =  6
				AND `plc2`.`plc2_upb`.`ldeleted` =  0
				
 				AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"
		

			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}

	function C00008($id){
			//studyliteraturpd
			$data = array();
			$sql='
				SELECT plc2.plc2_upb_team.vteam AS pdTeamName, plc2.plc2_upb_master_kategori_upb.vkategori AS katUpb, /*study_literatur_pd_popup/study_literatur_pd_popup.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				INNER JOIN `plc2`.`plc2_upb_team` ON `plc2`.`plc2_upb`.`iteampd_id`=`plc2`.`plc2_upb_team`.`iteam_id`
				INNER JOIN `plc2`.`plc2_upb_master_kategori_upb` ON `plc2`.`plc2_upb`.`ikategoriupb_id`=`plc2`.`plc2_upb_master_kategori_upb`.`ikategori_id`
				WHERE `plc2`.`plc2_upb`.`iupb_id` in (select pd.iupb_id from plc2.plc2_upb_prioritas_detail pd 
				 inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=pd.iprioritas_id
				 where pd.ldeleted=0 and pr.iappbusdev=2 )
				AND `plc2`.`plc2_upb`.`iupb_id` in (select ro.iupb_id 
				 from plc2.plc2_upb_request_originator ro 
				 join plc2.otc_request_ori_detail rd on rd.ireq_ori_id=ro.ireq_ori_id
				 where ro.ldeleted=0 
				 and rd.lDeleted=0
				 and rd.isent_status=1)
				AND `iupb_id` not in (select iupb_id from plc2.study_literatur_pd where ldeleted=0 and iapppd !=1 )
				AND `plc2_upb`.`itipe_id` =  6
				AND `plc2`.`plc2_upb`.`ldeleted` =  0
				AND `plc2`.`plc2_upb`.`ihold` =  0

 				AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"
		

			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}

	function C00009($id){
			//studyliteraturpd
			$data = array();
			$sql='
				SELECT plc2.plc2_upb_team.vteam AS pdTeamName, plc2.plc2_upb_master_kategori_upb.vkategori AS katUpb, /*study_literatur_pd_popup/study_literatur_pd_popup.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				INNER JOIN `plc2`.`plc2_upb_team` ON `plc2`.`plc2_upb`.`iteampd_id`=`plc2`.`plc2_upb_team`.`iteam_id`
				INNER JOIN `plc2`.`plc2_upb_master_kategori_upb` ON `plc2`.`plc2_upb`.`ikategoriupb_id`=`plc2`.`plc2_upb_master_kategori_upb`.`ikategori_id`
				WHERE `plc2`.`plc2_upb`.`iupb_id` in (select pd.iupb_id from plc2.plc2_upb_prioritas_detail pd 
				 inner join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=pd.iprioritas_id
				 where pd.ldeleted=0 and pr.iappbusdev=2 )
				AND `plc2`.`plc2_upb`.`iupb_id` in (select ro.iupb_id 
				 from plc2.plc2_upb_request_originator ro 
				 join plc2.otc_request_ori_detail rd on rd.ireq_ori_id=ro.ireq_ori_id
				 where ro.ldeleted=0 
				 and rd.lDeleted=0
				 and rd.isent_status=1)
				AND `iupb_id` not in (select iupb_id from plc2.study_literatur_ad where ldeleted=0 and iappad !=1 )
				AND `plc2_upb`.`itipe_id` =  6
				AND `plc2`.`plc2_upb`.`ldeleted` =  0
				AND `plc2`.`plc2_upb`.`ihold` =  0

 				AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"
		

			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}

	function C00010($id){
			//studyliteraturpd
			$data = array();
			$sql='
				SELECT plc2.plc2_upb_team.vteam AS pdTeamName, plc2.plc2_upb_master_kategori_upb.vkategori AS katUpb, /*plc_upb_daftar_popup/plc_upb_daftar_popup.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				INNER JOIN `plc2`.`plc2_upb_team` ON `plc2`.`plc2_upb`.`iteampd_id`=`plc2`.`plc2_upb_team`.`iteam_id`
				INNER JOIN `plc2`.`plc2_upb_master_kategori_upb` ON `plc2`.`plc2_upb`.`ikategoriupb_id`=`plc2`.`plc2_upb_master_kategori_upb`.`ikategori_id`
				WHERE `iappdireksi` =  2
				AND `ihold` =  0
				AND `plc2`.`plc2_upb`.`iupb_id` in (select a.iupb_id from plc2.study_literatur_pd a where a.lDeleted=0 and a.iapppd=2)
				AND `plc2`.`plc2_upb`.`iupb_id` in (select a.iupb_id from plc2.study_literatur_ad a where a.lDeleted=0 and a.iappad=2)
				AND `iupb_id` not in (
				 select d.iupb_id
				 from plc2.plc2_upb_ro_detail a 
				 join plc2.plc2_upb_request_sample b on b.ireq_id=a.ireq_id
				 join plc2.plc2_upb_ro c on c.iro_id=a.iro_id
				 join plc2.plc2_upb d on d.iupb_id=b.iupb_id
				 join plc2.plc2_raw_material e on e.raw_id=a.raw_id
				 where 
				 a.vrec_nip_qc is not null
				 and a.trec_date_qc is not null
				 and a.ldeleted=0
				 and b.ldeleted=0
				 and c.ldeleted=0
				 and d.ldeleted=0
				 and e.ldeleted=0
				 

				 )
				AND `plc2_upb`.`itipe_id` =  6
				AND `plc2`.`plc2_upb`.`ldeleted` =  0


 				AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"
		

			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}

	function C00011($id){
			//soiBB
			$data = array();
			$sql='
				SELECT plc2.plc2_upb_team.vteam AS pdTeamName, plc2.plc2_upb_master_kategori_upb.vkategori AS katUpb, /*plc_upb_daftar_soibb_popup/plc_upb_daftar_soibb_popup.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				INNER JOIN `plc2`.`plc2_upb_team` ON `plc2`.`plc2_upb`.`iteampd_id`=`plc2`.`plc2_upb_team`.`iteam_id`
				INNER JOIN `plc2`.`plc2_upb_master_kategori_upb` ON `plc2`.`plc2_upb`.`ikategoriupb_id`=`plc2`.`plc2_upb_master_kategori_upb`.`ikategori_id`
				WHERE `iappdireksi` =  2
				AND `iprioritas` =  1
				AND `ihold` =  0
				AND plc2_upb.`ldeleted` =  0
				AND `iupb_id` not in (select f.iupb_id from plc2.plc2_upb_soi_bahanbaku f where f.iappqc=0 and f.ldeleted=0)
				AND `iupb_id` in 
				 (
				 select a.iupb_id from plc2.analisa_bb a where a.lDeleted=0 and a.iApprove=2 and a.irelease=2 and a.iTujuan_req=1
				 )
				AND `iupb_id` in (
				 select a.iupb_id from plc2.draft_soi_bb a where a.iApprove=2
				 )

 				AND `plc2`.`plc2_upb`.`iupb_id` ="'.$id.'"
		

			';

			//echo $sql;
			//exit;
			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			//return $view;
			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}






	function getdetail(){

		$idmodul=$_POST['module_id'];
		$id=$_POST['id'];
		$hasil=$_POST['hasil'];

		//echo $hasil;
		

		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_pl0->query($sql_mod)->row_array();

		$mode = $mod['vKode_modul'].'_detail';
		if(method_exists(get_class($this),$mode)) {
			 $this->$mode("$id","$hasil");
			// echo "ada function";
		}else{
			//echo "tidak ada function";
		}

		

	}



	function P00002_detail($id,$hasil){
		//	echo "masuk sini gan";
			
			$sql='
					select a.iappdireksi,a.ihold,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.ihold=0,"No","Yes") as stcancel,
					a.* 
					from plc2.plc2_upb a 
					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/nonotc/setting_pareg',$data);
			return $view;
	}

	function P00003_detail($id,$hasil){
		
			
			$sql='
					select a.iappdireksi,a.ihold,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,

					a.* 
					from plc2.plc2_upb a 
					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/nonotc/request_originator_sample',$data);
			return $view;
	}

	function P00005_detail($id,$hasil){
		//	echo "masuk sini gan";
			
			$sql='
					select a.iappdireksi,a.ihold,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
						
					a.* 
					from plc2.plc2_upb a 
					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/nonotc/bahan_kemas',$data);
			return $view;
	}

	function P00006_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
						
					a.* 
					from plc2.plc2_upb a 
					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/nonotc/study_literatur_pd',$data);
			return $view;
	}

	function P00007_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
						
					a.* 
					from plc2.plc2_upb a 
					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/nonotc/study_literatur_ad',$data);
			return $view;
	}

	function P00008_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
						
					a.* 
					from plc2.plc2_upb a 
					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/nonotc/req_sample_rsample',$data);
			return $view;
	}

	function P00009_detail($id,$hasil){
		//	echo "masuk sini gan";
			
			$sql='
					select a.iappdireksi,a.ihold,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
						
					a.* 
					from plc2.plc2_upb a 
					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/nonotc/soi_bb',$data);
			return $view;
	}

	function P00010_detail($id,$hasil){
		//	echo "masuk sini gan";
			
			$sql='
					select a.iappdireksi,a.ihold,a.iappbusdev_prareg,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
						
					a.* 
					from plc2.plc2_upb a 
					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/nonotc/skala_trial',$data);
			return $view;
	}

	function P00011_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
						
					a.* 
					from plc2.plc2_upb a 
					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/nonotc/req_sample_rpilot1',$data);
			return $view;
	}

	function P00012_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
						
					a.* 
					from plc2.plc2_upb a 
					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/nonotc/request_originator_pilot1',$data);
			return $view;
	}

	function P00013_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
						
					a.* 
					from plc2.plc2_upb a 
					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/nonotc/req_sample_rpilot2',$data);
			return $view;
	}

	function P00015_detail($id,$hasil){
			
			$sql='SELECT if(plc2_upb_formula.ldeleted=0,"Actived","Deleted") as statusFormula,
				if(plc2_upb.ihold=0,"Actived","Cancel") as ihold,
				if(plc2_upb_formula.ilab!=1,"Berhasil","Gagal") as hasilLab,
				plc2_upb_formula.iformula_apppd,
				plc2_upb_formula.iwithstress,
				plc2_upb_formula.vformula_nip_apppd,
				plc2_upb_formula.tformula_apppd,
				plc2_upb_formula.iKeSkala_lab,
				plc2_upb_formula.iwithstress,
				plc2_upb_formula.iwithbb,
				plc2_upb_formula.iwithori
				FROM (plc2.plc2_upb_formula)
				LEFT JOIN plc2.plc2_upb ON plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id
				INNER JOIN plc2.plc2_upb_team ON plc2.plc2_upb.iteampd_id=plc2.plc2_upb_team.iteam_id
				WHERE plc2_upb_formula.ifor_id='.$id;
			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
		   	$data['id']=$id;
			$data['hasil'] = $hasil;
			$view = $this->load->view('manual/nonotc/formula_skala_lab',$data);
			return $view;
	}
	function P00016_detail($id,$hasil){
			
			$sql='SELECT if(plc2_upb_formula.ldeleted=0,"Actived","Deleted") as statusFormula,
				if(plc2_upb.ihold=0,"Actived","Cancel") as ihold,
				if(plc2_upb_formula.ilab!=1,"Berhasil","Gagal") as hasilLab,
				plc2_upb_formula.iformula_apppd,
				plc2_upb_formula.iwithstress,
				plc2_upb_formula.vformula_nip_apppd,
				plc2_upb_formula.tformula_apppd,
				plc2_upb_formula.iKeSkala_lab,
				plc2_upb_formula.iwithstress,
				plc2_upb_formula.iwithbb,
				plc2_upb_formula.iwithori
				FROM (plc2.plc2_upb_formula)
				LEFT JOIN plc2.plc2_upb ON plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id
				INNER JOIN plc2.plc2_upb_team ON plc2.plc2_upb.iteampd_id=plc2.plc2_upb_team.iteam_id
				WHERE plc2_upb_formula.ifor_id='.$id;
			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
		   	$data['id']=$id;
			$data['hasil'] = $hasil;
			$view = $this->load->view('manual/nonotc/formula_skala_lab',$data);
			return $view;
	}

	function C00002_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.iReview=2,"Diterima",if(a.iReview=1,"Ditolak","Waiting Review")) as strev,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.ldeleted=0,"No","Yes") as stdelete,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
					pd.vteam as pdteam,bd.vteam as bdteam,qa.vteam as qateam,ad.vteam as adteam,
					tp.vName as tipeupb,
					a.* 
					from plc2.plc2_upb a 
					join plc2.plc2_upb_team pd on pd.iteam_id = a.iteampd_id
					join plc2.plc2_upb_team bd on bd.iteam_id = a.iteambusdev_id
					join plc2.plc2_upb_team qa on qa.iteam_id = a.iteamqa_id
					join plc2.plc2_upb_team ad on ad.iteam_id = a.iteamad_id
					join plc2.plc2_biz_process_type tp on tp.idplc2_biz_process_type=a.itipe_id

					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/otc/review_upb',$data);
			return $view;
	}

	function C00003_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.iReview=2,"Diterima",if(a.iReview=1,"Ditolak","Waiting Review")) as strev,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.ldeleted=0,"No","Yes") as stdelete,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
					pd.vteam as pdteam,bd.vteam as bdteam,qa.vteam as qateam,ad.vteam as adteam,
					tp.vName as tipeupb,
					a.* 
					from plc2.plc2_upb a 
					join plc2.plc2_upb_team pd on pd.iteam_id = a.iteampd_id
					join plc2.plc2_upb_team bd on bd.iteam_id = a.iteambusdev_id
					join plc2.plc2_upb_team qa on qa.iteam_id = a.iteamqa_id
					join plc2.plc2_upb_team ad on ad.iteam_id = a.iteamad_id
					join plc2.plc2_biz_process_type tp on tp.idplc2_biz_process_type=a.itipe_id

					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/otc/setting_prareg',$data);
			return $view;
	}

	function C00004_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.iReview=2,"Diterima",if(a.iReview=1,"Ditolak","Waiting Review")) as strev,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.ldeleted=0,"No","Yes") as stdelete,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
					pd.vteam as pdteam,bd.vteam as bdteam,qa.vteam as qateam,ad.vteam as adteam,
					tp.vName as tipeupb,
					a.* 
					from plc2.plc2_upb a 
					join plc2.plc2_upb_team pd on pd.iteam_id = a.iteampd_id
					join plc2.plc2_upb_team bd on bd.iteam_id = a.iteambusdev_id
					join plc2.plc2_upb_team qa on qa.iteam_id = a.iteamqa_id
					join plc2.plc2_upb_team ad on ad.iteam_id = a.iteamad_id
					join plc2.plc2_biz_process_type tp on tp.idplc2_biz_process_type=a.itipe_id

					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/otc/request_originator_sample',$data);
			return $view;
	}

	function C00006_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.iReview=2,"Diterima",if(a.iReview=1,"Ditolak","Waiting Review")) as strev,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.ldeleted=0,"No","Yes") as stdelete,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
					pd.vteam as pdteam,bd.vteam as bdteam,qa.vteam as qateam,ad.vteam as adteam,
					tp.vName as tipeupb,
					a.* 
					from plc2.plc2_upb a 
					join plc2.plc2_upb_team pd on pd.iteam_id = a.iteampd_id
					join plc2.plc2_upb_team bd on bd.iteam_id = a.iteambusdev_id
					join plc2.plc2_upb_team qa on qa.iteam_id = a.iteamqa_id
					join plc2.plc2_upb_team ad on ad.iteam_id = a.iteamad_id
					join plc2.plc2_biz_process_type tp on tp.idplc2_biz_process_type=a.itipe_id

					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/otc/bahan_kemas_primer',$data);
			return $view;
	}

	function C00007_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.iReview=2,"Diterima",if(a.iReview=1,"Ditolak","Waiting Review")) as strev,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.ldeleted=0,"No","Yes") as stdelete,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
					pd.vteam as pdteam,bd.vteam as bdteam,qa.vteam as qateam,ad.vteam as adteam,
					tp.vName as tipeupb,
					a.* 
					from plc2.plc2_upb a 
					join plc2.plc2_upb_team pd on pd.iteam_id = a.iteampd_id
					join plc2.plc2_upb_team bd on bd.iteam_id = a.iteambusdev_id
					join plc2.plc2_upb_team qa on qa.iteam_id = a.iteamqa_id
					join plc2.plc2_upb_team ad on ad.iteam_id = a.iteamad_id
					join plc2.plc2_biz_process_type tp on tp.idplc2_biz_process_type=a.itipe_id

					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/otc/bahan_kemas_sekunder',$data);
			return $view;
	}

	function C00008_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.iReview=2,"Diterima",if(a.iReview=1,"Ditolak","Waiting Review")) as strev,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.ldeleted=0,"No","Yes") as stdelete,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
					pd.vteam as pdteam,bd.vteam as bdteam,qa.vteam as qateam,ad.vteam as adteam,
					tp.vName as tipeupb,
					a.* 
					from plc2.plc2_upb a 
					join plc2.plc2_upb_team pd on pd.iteam_id = a.iteampd_id
					join plc2.plc2_upb_team bd on bd.iteam_id = a.iteambusdev_id
					join plc2.plc2_upb_team qa on qa.iteam_id = a.iteamqa_id
					join plc2.plc2_upb_team ad on ad.iteam_id = a.iteamad_id
					join plc2.plc2_biz_process_type tp on tp.idplc2_biz_process_type=a.itipe_id

					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/otc/study_literatur_pd',$data);
			return $view;
	}

	function C00009_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.iReview=2,"Diterima",if(a.iReview=1,"Ditolak","Waiting Review")) as strev,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.ldeleted=0,"No","Yes") as stdelete,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
					pd.vteam as pdteam,bd.vteam as bdteam,qa.vteam as qateam,ad.vteam as adteam,
					tp.vName as tipeupb,
					a.* 
					from plc2.plc2_upb a 
					join plc2.plc2_upb_team pd on pd.iteam_id = a.iteampd_id
					join plc2.plc2_upb_team bd on bd.iteam_id = a.iteambusdev_id
					join plc2.plc2_upb_team qa on qa.iteam_id = a.iteamqa_id
					join plc2.plc2_upb_team ad on ad.iteam_id = a.iteamad_id
					join plc2.plc2_biz_process_type tp on tp.idplc2_biz_process_type=a.itipe_id

					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/otc/study_literatur_ad',$data);
			return $view;
	}

	function C00010_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.iReview=2,"Diterima",if(a.iReview=1,"Ditolak","Waiting Review")) as strev,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.ldeleted=0,"No","Yes") as stdelete,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
					pd.vteam as pdteam,bd.vteam as bdteam,qa.vteam as qateam,ad.vteam as adteam,
					tp.vName as tipeupb,
					a.* 
					from plc2.plc2_upb a 
					join plc2.plc2_upb_team pd on pd.iteam_id = a.iteampd_id
					join plc2.plc2_upb_team bd on bd.iteam_id = a.iteambusdev_id
					join plc2.plc2_upb_team qa on qa.iteam_id = a.iteamqa_id
					join plc2.plc2_upb_team ad on ad.iteam_id = a.iteamad_id
					join plc2.plc2_biz_process_type tp on tp.idplc2_biz_process_type=a.itipe_id

					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/otc/req_sample_rsample',$data);
			return $view;
	}
	function C00011_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.iReview=2,"Diterima",if(a.iReview=1,"Ditolak","Waiting Review")) as strev,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.ldeleted=0,"No","Yes") as stdelete,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
					pd.vteam as pdteam,bd.vteam as bdteam,qa.vteam as qateam,ad.vteam as adteam,
					tp.vName as tipeupb,
					a.* 
					from plc2.plc2_upb a 
					join plc2.plc2_upb_team pd on pd.iteam_id = a.iteampd_id
					join plc2.plc2_upb_team bd on bd.iteam_id = a.iteambusdev_id
					join plc2.plc2_upb_team qa on qa.iteam_id = a.iteamqa_id
					join plc2.plc2_upb_team ad on ad.iteam_id = a.iteamad_id
					join plc2.plc2_biz_process_type tp on tp.idplc2_biz_process_type=a.itipe_id


					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"




			';
		}

	function C00016($id){
			$data = array();
			$sql='
				SELECT plc2_upb.vupb_nomor AS plc2_upb__vupb_nomor, plc2_upb.vupb_nama AS plc2_upb__vupb_nama, plc2_upb.vgenerik AS plc2_upb__vgenerik, plc2_upb.iteampd_id 
					AS plc2_upb__iteampd_id, plc2.plc2_upb_team.vteam AS team_pd, plc2.plc2_vamoa.*
					FROM (`plc2`.`plc2_vamoa`) INNER JOIN `plc2`.`plc2_upb` ON `plc2_vamoa`.`iupb_id` = `plc2`.`plc2_upb`.`iupb_id`
					INNER JOIN `plc2`.`plc2_upb_team` ON `plc2`.`plc2_upb`.`iteampd_id`=`plc2`.`plc2_upb_team`.`iteam_id`
					WHERE `plc2_upb`.`vupb_nomor` LIKE "%'.$id.'%"
					AND `plc2_vamoa`.`lDeleted` =  0
					AND `plc2_upb`.`itipe_id` =  6
					';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
	// 		$view = $this->load->view('manual/otc/soi_bb',$data);
	// 		return $view;
	// }

			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}


			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}
	function C00016_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,a.iappbusdev_prareg,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
						
					a.* 
					from plc2.plc2_upb a 
					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';




			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/otc/validasi_moa',$data);
			return $view;
	}

	function C00017($id){
			$data = array();
			$sql='
				SELECT plc2.plc2_upb.*
					FROM (`plc2`.`plc2_upb`)
					WHERE  `iupb_id` IN (SELECT po.iupb_id FROM plc2.lpo po WHERE po.iapppd=2 AND po.lDeleted=0 )
					AND `iupb_id` IN (SELECT fo.iupb_id FROM plc2.plc2_upb_formula fo WHERE fo.iapppd_lpp=2 AND fo.ldeleted=0)
					AND `iupb_id` IN (SELECT bb.iupb_id FROM plc2.plc2_upb_soi_bahanbaku bb WHERE bb.ldeleted=0 AND bb.iappqc =2 AND bb.iappqa=2)
					AND `iupb_id` IN (SELECT a.`iupb_id` FROM plc2.plc2_upb_fg a WHERE a.iApprove_soifg=2 AND a.`lDeleted`=0)
					AND `iupb_id` IN (SELECT a.`iupb_id` FROM plc2.plc2_upb_bahan_kemas a WHERE a.iappqa=2 AND a.`ldeleted` = 0 AND a.iJenis_bk = 1)
					AND `iupb_id` IN (SELECT a.`iupb_id` FROM plc2.plc2_upb_bahan_kemas a WHERE a.iappqa=2 AND a.`ldeleted` = 0 AND a.iJenis_bk = 2)
					AND `iupb_id` IN (SELECT DISTINCT(rs.iupb_id) FROM plc2.plc2_upb_ro ro
					 LEFT OUTER JOIN plc2.plc2_upb_ro_detail rod ON rod.iro_id = ro.iro_id AND rod.ldeleted = 0
					 LEFT OUTER JOIN plc2.plc2_upb_po po ON po.ipo_id = ro.ipo_id
					 LEFT OUTER JOIN plc2.plc2_upb_request_sample_detail rsd ON rsd.ireq_id = rod.ireq_id AND rsd.raw_id

					 = rod.raw_id AND rsd.ldeleted = 0
					 LEFT OUTER JOIN plc2.plc2_raw_material rm ON rm.raw_id=rsd.raw_id
					 LEFT OUTER JOIN plc2.plc2_upb_request_sample rs ON rs.ireq_id = rod.ireq_id 
					 LEFT OUTER JOIN plc2.plc2_upb u ON u.iupb_id = rs.iupb_id

					 WHERE rod.ireq_id IN (SELECT d.ireq_id FROM plc2.uji_mikro_bb u
					 INNER JOIN plc2.plc2_upb_request_sample_detail d ON u.ireqdet_id=d.ireqdet_id
					 INNER JOIN plc2.plc2_upb_request_sample s ON d.ireq_id=s.ireq_id
					 INNER JOIN plc2.plc2_raw_material m ON d.raw_id=m.raw_id
					 WHERE u.lDeleted=0 AND u.iApprove_uji=2 #and u.iApprove_mikro_final=2
					 ))
					AND `plc2_upb`.`ldeleted` =  0
					AND `plc2_upb`.`ihold` =  0
					AND `plc2_upb`.`itipe_id` =  6
					AND `plc2_upb`.`iupb_id` =  '.$id.'';

			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}
	function C00017_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,a.iappbusdev_prareg,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
						
					a.* 
					from plc2.plc2_upb a 
					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/otc/cek_dokumen',$data);
			return $view;
	}

	function C00018($id){
			$data = array();
			$sql='
				SELECT plc2.plc2_upb_team.vteam AS team_bd, /*hpr/hpr.php/output*/plc2.plc2_upb.*
					FROM (`plc2`.`plc2_upb`)
					INNER JOIN `plc2`.`plc2_upb_formula` ON `plc2_upb_formula`.`iupb_id`=`plc2`.`plc2_upb`.`iupb_id`
					INNER JOIN `plc2`.`plc2_upb_buat_mbr` ON `plc2_upb_buat_mbr`.`ifor_id`=`plc2_upb_formula`.`ifor_id`
					INNER JOIN `plc2`.`plc2_upb_team` ON `plc2`.`plc2_upb`.`iteambusdev_id`=`plc2`.`plc2_upb_team`.`iteam_id`
					WHERE  `plc2_upb`.`itipe_id` =  6
					AND `plc2_upb`.`ldeleted` =  0
					AND `plc2_upb`.`ihold` =  0
					AND `plc2_upb`.`iappbusdev_prareg` =  2
					AND `plc2_upb`.`iconfirm_dok` =  2
					AND `plc2_upb`.`iupb_id` IN (SELECT DISTINCT(fo.iupb_id) FROM plc2.plc2_upb_formula fo
					 INNER JOIN plc2.plc2_upb_prodpilot pr ON pr.ifor_id=fo.ifor_id
					 WHERE fo.ldeleted=0 AND pr.ldeleted=0 AND pr.iapppd_pp=2)
					 AND `plc2_upb`.iupb_id =  '.$id.'';

			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}
	function C00018_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,a.iappbusdev_prareg,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
						
					a.* 
					from plc2.plc2_upb a 
					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/otc/HPR',$data);
			return $view;
	}
	function C00019($id){
			$data = array();
			$sql='
				SELECT /*registrasi_upb/registrasi_upb.php/output*/plc2.plc2_upb.*
					FROM (`plc2`.`plc2_upb`)
					WHERE  `plc2_upb`.`iappdireksi` =  2
					AND `plc2_upb`.`itipe_id` =  6
					AND `plc2_upb`.`iconfirm_registrasi` =  2
					AND `plc2_upb`.`ldeleted` =  0
					AND `plc2_upb`.`ihold` =  0
					AND  `plc2_upb`.`iupb_id` =  '.$id.'';

			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}
	function C00019_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,a.iappbusdev_prareg,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
						
					a.* 
					from plc2.plc2_upb a 
					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/otc/registrasi',$data);
			return $view;
	}

	function C00020($id){
			$data = array();
			$sql='
				SELECT plc2.plc2_upb_team.vteam AS team_bd, /*applet/applet.php/output*/plc2.plc2_upb.*
				FROM (`plc2`.`plc2_upb`)
				INNER JOIN `plc2`.`plc2_upb_formula` ON `plc2_upb_formula`.`iupb_id`=`plc2`.`plc2_upb`.`iupb_id`
				INNER JOIN `plc2`.`plc2_upb_buat_mbr` ON `plc2_upb_buat_mbr`.`ifor_id`=`plc2_upb_formula`.`ifor_id`
				INNER JOIN `plc2`.`plc2_upb_team` ON `plc2`.`plc2_upb`.`iteambusdev_id`=`plc2`.`plc2_upb_team`.`iteam_id`
				WHERE  `plc2_upb`.`itipe_id` =  6
				AND `plc2_upb`.`ldeleted` =  0
				AND `plc2_upb`.`iappdireksi` =  2
				AND `plc2_upb`.`iappbusdev_registrasi` =  2
				#AND `plc2_upb`.`iconfirm_registrasi` =  2
				AND `plc2_upb`.`ikategori_id` IN (1,5)
				AND  plc2_upb. `iupb_id` ='.$id.'';

			$datas = $this->db_pl0->query($sql)->row_array();
		   
			if (!empty($datas)) {
				// oke
				$result=1;
				
			}else{
				$result=0;
				
			}

			$row_array['result'] =trim($result);

			array_push($data, $row_array);
		    echo json_encode($data);
		    exit;

	}
	function C00020_detail($id,$hasil){
			
			$sql='
					select a.iappdireksi,a.ihold,a.iappbusdev_prareg,
					if(a.iappdireksi=2,"Appoved",if(a.iappdireksi=1,"Rejected","Waiting Approval")) as stdir,
					if(a.ihold=0,"No","Yes") as stcancel,
					if(a.vkat_originator=1,"NA",if(a.vkat_originator=2,"Novell","Non-Novell")) as svkat_originator,
						
					a.* 
					from plc2.plc2_upb a 
					where 
					a.ldeleted=0
					and a.iupb_id="'.$id.'"

			';

			
			$datas = $this->db_pl0->query($sql)->row_array();
		   	
		   	if (!empty($datas)) {
		   		$data['datas'] = $datas;	
		   	}else{
		   		$data['datas'] = 0;
		   	}
			$data['hasil'] = $hasil;
			
			$view = $this->load->view('manual/otc/Applet',$data);
			return $view;
	}

	/*@Exit*/








	public function output(){
		$this->index('piew');
	}
}

?>
