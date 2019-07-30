<?php if (!defined('BASEPATH')) exit('No direct access is allowed');
class upb_injector extends MX_Controller {

	private $dbset;
	private $url;
	private $sess_auth;

	public function __construct() {
		parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->dbset = $this->load->database('plc', true);
		$this->load->library('lib_utilitas');
		$this->user = $this->auth->user();

		/*
		$this->sess_auth = new Zend_Session_Namespace('auth');
		$this->url = 'upb_injector';
		$this->dbset = $this->load->database('plc', true);
		$this->load->library('lib_manual');
		$this->load->library('auth');
		$this->user = $this->auth->user();
		*/
	}

	function index($action = '') {
    	//Bikin Object Baru Nama nya $grid
    	$action = $this->input->get('action') ? $this->input->get('action') : 'piew';

		$grid = new Grid;
		$grid->setTitle('Check Input UPB');
		$grid->setTable('plc.plc2_upb');
		$grid->setUrl('upb_injector');

		switch ($action) {
			case 'piew':
				$this->load->view('manual/upb_injector');
				break;
			case 'getcoloralert':
				echo $this->getcoloralert();
				break;
			case 'getrequirement':
				echo $this->getrequirement();
				break;
			case 'getInject':
				echo $this->getInject();
				break;
			case 'getkey':
				echo $this->getkey($this->input->post('module_id'));
				break;
			case 'getddModul':
				echo $this->getddModul();
				break;
			default:
				$grid->render_grid();
				break;
		}
	}

	function getddModul() {
	 	$echo = "";
		$iTipe = $this->input->post('iTipe');
		if($iTipe != '') {
			$selbd="select *
							from plc2.master_proses a
							where a.lDeleted=0
							and a.idplc2_biz_process_type='".$iTipe."'
							and a.iLevelProses=1 order by a.iUrutan  ";
			$rows = $this->db_plc0->query($selbd)->result_array();
			$echo.='<select class="choose input required" name="module_id" id="module_id" style="width: 300px">
			<option value=""> Pilih Modul</option>';
			foreach($rows as $rrrr) {
				$echo.= '<option value="'.$rrrr['master_proses_id'].'">'.$rrrr['vKode_modul'].' - '.$rrrr['vNama_modul'].'</option>';
			}
			$echo.= '</select>';
		}
		else {
			$echo = 'Pilih Tipe!';
		}
		echo $echo;
	}


	function getkey($module_id=0){
		$data['status']=false;
		if($module_id!=0){
			$data['status']=true;
			$sql="select * from plc2.master_proses a where a.lDeleted=0 and a.master_proses_id=".$module_id;
			$d=$this->dbset->query($sql)->row_array();
			$data['hasil']=$d['ikey_id'];
			return json_encode($data);
		}else{
			return json_encode($data);
		}
	}

	function getrequirement(){
		$idmodul=$_POST['module_id'];

		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();

		$sql='select * from plc2.master_proses_inject_info a where a.master_proses_id="'.$idmodul.'"';
		$reqs = $this->db_plc0->query($sql)->result_array();
		$data['reqs'] = $reqs;
		$data['mod'] = $mod;
		$view = $this->load->view('manual/part_requirement',$data,TRUE);

			return $view;
	}



	function getcoloralert(){

		$idmodul=$_POST['module_id'];
		$id=$_POST['id'];

		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();


		if(method_exists(get_class($this),$mod['vKode_modul'])) {
			 $this->$mod['vKode_modul']("$id");
		}



	}



function getInject(){

	$idmodul=$_POST['module_id'];
	$id=$_POST['id'];
	//$hasil=$_POST['hasil'];


	$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
	$mod = $this->db_plc0->query($sql_mod)->row_array();
	$vNama_modul = $mod['vNama_modul'];
	$sql_mods = 'select *
				from plc2.master_proses a
				where a.lDeleted=0
				and a.idplc2_biz_process_type=1
				and a.iLevelProses=1
				and a.iUrutan <="'.$mod['iUrutan'].'"
				order by a.iUrutan';
	$moduls = $this->db_plc0->query($sql_mods)->result_array();

	$returnView = '';
	foreach ($moduls as $modul) {

		$mode = $modul['vKode_modul'];
		$idmomod = $modul['master_proses_id'];
		if(method_exists(get_class($this),$mode)) {
			$returnView .= $this->$mode("$id","$idmomod")."<br>";
		}else{
			$returnView .= "tidak ada function, ";
		}


	}

	echo $returnView;




}


function P00002($id,$idmodul){
	//setting prioritas prareg
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
		$sqlcekAwal = 'select *
						from plc2.plc2_upb_prioritas a
						join plc2.plc2_upb_prioritas_detail b on b.iprioritas_id=a.iprioritas_id
						where b.iupb_id="'.$id.'"
						and a.ldeleted=0
						and b.ldeleted=0
						and a.iappbusdev <> 1 #status tidak reject
						order by a.iprioritas_id DESC limit 1
						';
		$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

		if (!empty($dAwal)) {

			/*jika ada , cek approval*/
			$setatus = $dAwal['iappbusdev'];
			if ($setatus== '') {
				$data_up=array('tappbusdev'=>date('Y-m-d H:i:s'),'iappbusdev'=>'2','iSubmit'=>'1');
				$this -> db -> where('iprioritas_id', $dAwal['iprioritas_id']);
				$updet = $this -> db -> update('plc2.plc2_upb_prioritas', $data_up);

				if ($updet) {
					$ret = ''.$vNama_modul.' => Approval Berhasil ';
				}else{
					$ret = ''.$vNama_modul.' => Approval Gagal ';
				}
			}else{
				/*jika sudah approve maka skip*/
				$ret = ''.$vNama_modul.' => SKIP';
			}

		}else{
			// data belum ada
				// cek apakah flow baru
				if($iNewFlow==1){
					//jika flow baru
				}else{
					// insert  bebas, tapi sesuai dengan info di tabel.
					/*
						ketentuan
						1. smester yang dipilih adalah semester 1
						2. tahun dipilih adalah tahun berjalan
						3. team PD yang dipilih sesuai dengan data pada daftar UPB
						4. bobot 1
					*/


					// jika flow lama
						// cek adakah prioritas di smester 1 tahun berjalan ?
						$sqCekmod = 'select * from plc2.plc2_upb_prioritas a where a.imonth = 1 and a.iyear ="'.date('Y').'" ';
						$dCekMod = $this->db_plc0->query($sqCekmod)->row_array();
						if (!empty($dCekMod)) {
							// jika ada insert di prioritas tersebut, maka insert detail saja
							$dataD=array();
							$dataD['iprioritas_id'] = $dCekMod['iprioritas_id'];
							$dataD['iupb_id'] = $id;
							$dataD['iteampd_id'] = $dUpb['iteampd_id'];
							$dataD['ibobot'] = '1';
							$dataH['tUpdate'] = date('Y-m-d H:i:s');
							$insD = $this -> db -> insert('plc2.plc2_upb_prioritas_detail', $dataD);
							if ($insD) {

								$ret = ''.$vNama_modul.'=> Insert Berhasil ';
							}

						}else{
							//jika tidak ada maka insert header dan detail
							$dataH=array();
							$dataH['imonth'] = '1';
							$dataH['iyear'] = date('Y');
							$dataH['iteambusdev_id'] = $dUpb['iteambusdev_id'];
							$dataH['cnip'] = $this->user->gNIP;
							$dataH['tupdate'] = date('Y-m-d H:i:s');

							#field approval
							$dataH['tappbusdev'] = date('Y-m-d H:i:s');
							$dataH['iappbusdev'] = '2';
							$dataH['iSubmit'] = '1';

							$insH = $this -> db -> insert('plc2.plc2_upb_prioritas', $dataH);
							$idHead=$this->db_plc0->insert_id();



							if ($insH) {
								$ret = $vNama_modul.' => Insert Berhasil ';

								$dataD=array();
								$dataD['iprioritas_id'] = $idHead;
								$dataD['iupb_id'] = $id;
								$dataD['iteampd_id'] = $dUpb['iteampd_id'];
								$dataD['ibobot'] = '1';
								$dataD['tUpdate'] = date('Y-m-d H:i:s');
								$insD = $this -> db -> insert('plc2.plc2_upb_prioritas_detail', $dataD);

								if ($insD) {
									$ret .= ''.$vNama_modul.' => Insert Berhasil ';
								}else{
									$ret .= ''.$vNama_modul.' => Insert Gagal ';
								}


							}else{

								$ret = ''.$vNama_modul.' => Insert Gagal ';


							}

						}
				}
		}

		return $ret;

}



function P00005($id,$idmodul){
		// Bahan Kemas
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
		$sqlcekAwal = '
						select *
						from plc2.plc2_upb_bahan_kemas a
						where
						a.ldeleted=0
						and a.iupb_id="'.$id.'"
						and a.iapppc <> 1
						order by a.ibk_id DESC limit 1

						';
		$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

		if (!empty($dAwal)) {

			/*jika ada , cek approval*/
			$setatus = $dAwal['iappqa'];
			if ($setatus == 0) {
				//app PD
							$dataH=array();

							$iapppd = $dAwal['iapppd'];
							if ($iapppd == 2) {
								$dataH['iapppd'] = $dAwal['iapppd'];
								$dataH['vnip_apppd'] = $dAwal['iapppd'];
								$dataH['tapppd'] = $dAwal['iapppd'];
							}else{
								$dataH['iapppd'] = '2';
								$dataH['vnip_apppd'] = $this->user->gNIP;
								$dataH['tapppd'] = date('Y-m-d H:i:s');
							}


							/*app QA*/
							$iappqa = $dAwal['iappqa'];
							if ($iappqa == 2) {
								$dataH['iappqa'] = $dAwal['iappqa'];
								$dataH['vnip_appqa'] = $dAwal['iappqa'];
								$dataH['tappqa'] = $dAwal['iappqa'];
							}else{
								$dataH['iappqa'] = '2';
								$dataH['vnip_appqa'] = $this->user->gNIP;
								$dataH['tappqa'] = date('Y-m-d H:i:s');
							}



							/*app BD*/
							$iappbd = $dAwal['iappbd'];
							if ($iappbd == 2) {
								$dataH['iappbd'] = $dAwal['iappbd'];
								$dataH['vnip_appbd'] = $dAwal['iappbd'];
								$dataH['tappbd'] = $dAwal['iappbd'];
							}else{
								$dataH['iappbd'] = '2';
								$dataH['vnip_appbd'] = $this->user->gNIP;
								$dataH['tappbd'] = date('Y-m-d H:i:s');
							}

							/*app PPIC*/
							$iapppc = $dAwal['iapppc'];
							if ($iapppc == 2) {
								$dataH['iapppc'] = $dAwal['iapppc'];
								$dataH['vnip_appbd'] = $dAwal['iapppc'];
								$dataH['tapppc'] = $dAwal['iapppc'];
							}else{
								$dataH['iapppc'] = '2';
								$dataH['vnip_apppc'] = $this->user->gNIP;
								$dataH['tapppc'] = date('Y-m-d H:i:s');
							}



				$this -> db -> where('ibk_id', $dAwal['ibk_id']);
				$updet = $this -> db -> update('plc2.plc2_upb_bahan_kemas', $dataH);

				if ($updet) {
					$ret = $vNama_modul.' => Approval Berhasil ';
				}else{
					$ret = $vNama_modul.' => Approval Gagal ';
				}
			}else{
				/*jika sudah approve maka skip*/
				$ret = $vNama_modul.' => SKIP';
			}

		}else{
			// data belum ada
				// cek apakah flow baru
				if($iNewFlow==1){
					//jika flow baru
				}else{
					// insert  bebas, tapi sesuai dengan info di tabel.
					/*
						ketentuan
						1. status approval sesuai dengan user yang melakukan inject

					*/


					// jika flow lama

							//jika tidak ada maka insert header dan detail
							$dataH=array();
							$dataH['iupb_id'] = $id;
							$dataH['itipe'] = '0';
							$dataH['ijenis_bk_id'] = '0';
							$dataH['ijenis_bk_id_sk'] = '0';
							$dataH['ijenis_bk_id_tr'] = '0';
							$dataH['filename'] = 'xxx';
							$dataH['iJenis_bk'] = '0';
							$dataH['vversi'] = '0';
							$dataH['vrevisi'] = '0';
							$dataH['vtitle'] = 'Inject By '.$this->user->gNIP;
							$dataH['treason'] = 'Inject By '.$this->user->gNIP;

							$dataH['iSubmit'] = '1';


							//app PD
							$dataH['iapppd'] = '2';
							$dataH['vnip_apppd'] = $this->user->gNIP;
							$dataH['tapppd'] = date('Y-m-d H:i:s');

							/*app QA*/
							$dataH['iappqa'] = '2';
							$dataH['vnip_appqa'] = $this->user->gNIP;
							$dataH['tappqa'] = date('Y-m-d H:i:s');

							/*app BD*/
							$dataH['iappbd'] = '2';
							$dataH['vnip_appbd'] = $this->user->gNIP;
							$dataH['tappbd'] = date('Y-m-d H:i:s');

							/*app PPIC*/
							$dataH['iapppc'] = '2';
							$dataH['vnip_apppc'] = $this->user->gNIP;
							$dataH['tapppc'] = date('Y-m-d H:i:s');


							$insH = $this -> db -> insert('plc2.plc2_upb_bahan_kemas', $dataH);
							//$idHead=$this->db_plc0->insert_id();



							if ($insH) {
								$ret = $vNama_modul.' => Insert Berhasil ';


							}else{

								$ret = $vNama_modul.' => Insert Gagal ';


							}

				}
		}

		return $ret;

}

function P00006($id,$idmodul){
		// Study Literatur PD
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
		$sqlcekAwal = '
						select *
						from plc2.study_literatur_pd a
						where a.lDeleted=0
						and a.iapppd <> 1
						and a.iupb_id="'.$id.'"
						order by a.istudy_pd_id DESC limit 1
						';
		$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

		if (!empty($dAwal)) {

			/*jika ada , cek approval*/
			$setatus = $dAwal['iapppd'];
			if ($setatus == 0) {
				//app PD
							$dataH=array();
							$dataH['iapppd'] = '2';
							$dataH['capppd'] = $this->user->gNIP;
							$dataH['dapppd'] = date('Y-m-d H:i:s');
							$dataH['iStatus'] = '1';
							$dataH['vRemark'] = 'Inject By '.$this->user->gNIP;






				$this -> db -> where('istudy_pd_id', $dAwal['istudy_pd_id']);
				$updet = $this -> db -> update('plc2.study_literatur_pd', $dataH);

				if ($updet) {
					$ret = $vNama_modul.' => Approval Berhasil ';
				}else{
					$ret = $vNama_modul.' => Approval Gagal ';
				}
			}else{
				/*jika sudah approve maka skip*/
				$ret = $vNama_modul.' => SKIP';
			}

		}else{
			// data belum ada
				// cek apakah flow baru
				if($iNewFlow==1){
					//jika flow baru
				}else{
					// insert  bebas, tapi sesuai dengan info di tabel.
					/*
						ketentuan
						1. status approval sesuai dengan user yang melakukan inject
						2. default uji mikro FG => NO
						3. PIC sesuai user yang melakukan inject
						4. jenis sediaan non - steril
						5. tgl mulai & selesai 1970-01-01

					*/


					// jika flow lama

							//jika tidak ada maka insert header dan detail
							$dataH=array();
							$dataH['iupb_id'] = $id;
							$dataH['cPIC'] = $this->user->gNIP;
							$dataH['dmulai_study'] = '1970-01-01';
							$dataH['dselesai_study'] = '1970-01-01';
							$dataH['iuji_mikro'] = '0';
							$dataH['ijenis_sediaan'] = '0';
							$dataH['vkompedial'] = 'Inject By '.$this->user->gNIP;
							$dataH['iStatus'] = '1';

							$dataH['cCreate'] = $this->user->gNIP;
							$dataH['dCreate'] = date('Y-m-d H:i:s');


							//app PD
							$dataH['iapppd'] = '2';
							$dataH['capppd'] = $this->user->gNIP;
							$dataH['dapppd'] = date('Y-m-d H:i:s');
							$dataH['vRemark'] = 'Inject By '.$this->user->gNIP;




							$insH = $this -> db -> insert('plc2.study_literatur_pd', $dataH);
							//$idHead=$this->db_plc0->insert_id();



							if ($insH) {
								$ret = $vNama_modul.' => Insert  Berhasil ';


							}else{

								$ret = $vNama_modul.' => Insert  Gagal ';


							}

				}
		}

		return $ret;

}

function P00007($id,$idmodul){
		// Study Literatur ad
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
		$sqlcekAwal = '
						select *
						from plc2.study_literatur_ad a
						where a.lDeleted=0
						and a.iappad <> 1
						and a.iupb_id="'.$id.'"
						order by a.istudy_ad_id DESC limit 1
						';
		$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

		if (!empty($dAwal)) {

			/*jika ada , cek approval*/
			$setatus = $dAwal['iappad'];
			if ($setatus == 0) {

				//app ad
							$dataH=array();
							$dataH['iappad'] = '2';
							$dataH['cappad'] = $this->user->gNIP;
							$dataH['dappad'] = date('Y-m-d H:i:s');
							$dataH['iStatus'] = '1';
							$dataH['vRemark'] = 'Inject By '.$this->user->gNIP;





				$this -> db -> where('istudy_ad_id', $dAwal['istudy_ad_id']);
				$updet = $this -> db -> update('plc2.study_literatur_ad', $dataH);

				if ($updet) {
					$ret = $vNama_modul.' => Approval Berhasil ';
				}else{
					$ret = $vNama_modul.' => Approval Gagal ';
				}
			}else{
				/*jika sudah approve maka skip*/
				$ret = $vNama_modul.' => SKIP';
			}

		}else{
			// data belum ada
				// cek apakah flow baru
				if($iNewFlow==1){
					//jika flow baru
				}else{
					// insert  bebas, tapi sesuai dengan info di tabel.
					/*
						ketentuan
						1. status approval sesuai dengan user yang melakukan inject
						2. default uji mikro FG => NO
						3. PIC sesuai user yang melakukan inject
						4. jenis sediaan non - steril
						5. tgl mulai & selesai 1970-01-01

					*/


					// jika flow lama

							//jika tidak ada maka insert header dan detail
							$dataH=array();
							$dataH['iupb_id'] = $id;
							$dataH['cPIC'] = $this->user->gNIP;
							$dataH['dmulai_study'] = '1970-01-01';
							$dataH['dselesai_study'] = '1970-01-01';
							$dataH['vkompedial'] = 'Inject By '.$this->user->gNIP;
							$dataH['iStatus'] = '1';

							$dataH['cCreate'] = $this->user->gNIP;
							$dataH['dCreate'] = date('Y-m-d H:i:s');


							//app ad
							$dataH['iappad'] = '2';
							$dataH['cappad'] = $this->user->gNIP;
							$dataH['dappad'] = date('Y-m-d H:i:s');
							$dataH['vRemark'] = 'Inject By '.$this->user->gNIP;




							$insH = $this -> db -> insert('plc2.study_literatur_ad', $dataH);
							//$idHead=$this->db_plc0->insert_id();



							if ($insH) {
								$ret = $vNama_modul.' => Insert Berhasil ';


							}else{

								$ret = $vNama_modul.' => Insert Gagal ';


							}

				}
		}

		return $ret;

}

function P00008($id,$idmodul){
	//Permintaan Sample BB ( Untuk sample )
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
		$sqlcekAwal = '
						select *
						from plc2.plc2_upb_request_sample a
						where a.ldeleted=0
						and a.iupb_id="'.$id.'"
						and a.iapppd <> 1
						order by a.ireq_id DESC limit 1
						';
		$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

		if (!empty($dAwal)) {

			/*jika ada , cek approval*/
			$setatus = $dAwal['iapppd'];
			if ($setatus== '0') {
				$dataH=array();

				#field approval
				$dataH['tapppd'] = date('Y-m-d H:i:s');
				$dataH['iapppd'] = '2';
				$dataH['vnip_apppd'] = $this->user->gNIP;
				$dataH['iSubmit'] = '1';

				$this -> db -> where('ireq_id', $dAwal['ireq_id']);
				$updet = $this -> db -> update('plc2.plc2_upb_request_sample', $dataH);

				if ($updet) {
					$ret = $vNama_modul.' => Approval Berhasil ';
				}else{
					$ret = $vNama_modul.' => Approval Gagal ';
				}
			}else{
				/*jika sudah approve maka skip*/
				$ret = $vNama_modul.' => SKIP';
			}

		}else{
			// data belum ada
				// cek apakah flow baru
				if($iNewFlow==1){
					//jika flow baru
				}else{
					// insert  bebas, tapi sesuai dengan info di tabel.
					/*
						ketentuan
						1. raw material yang di request hanya 1 , yaitu VITAMIN A (RETINOL PALMITATE) id 2
						2. tujuan request untuk sample
						3. No request menjadi Inj-Nip yang melakukan inject
					*/
							// insert header dan detail
							$dataH=array();
							$dataH['iupb_id'] = $id;

							$dataH['vreq_nomor'] = '1';
							$dataH['vreq_nomor'] = 'Inj-'.$this->user->gNIP;

							$dataH['cRequestor'] = $this->user->gNIP;

							$dataH['trequest'] = date('Y-m-d H:i:s');
							$dataH['cnip'] = $this->user->gNIP;
							$dataH['tupdate'] = date('Y-m-d H:i:s');
							$dataH['iSubmit'] = '1';
							$dataH['iTujuan_req'] = '1';

							#field approval
							$dataH['tapppd'] = date('Y-m-d H:i:s');
							$dataH['iapppd'] = '2';
							$dataH['vnip_apppd'] = $this->user->gNIP;


							$insH = $this -> db -> insert('plc2.plc2_upb_request_sample', $dataH);
							$idHead=$this->db_plc0->insert_id();



							if ($insH) {
								$ret = $vNama_modul.' => Insert Berhasil ';

								$dataD=array();
								$dataD['ireq_id'] = $idHead;
								$dataD['raw_id'] = '2'; #request Vitamin A
								$dataD['ijumlah'] = '1';
								$dataD['vsatuan'] = 'Gram';
								$insD = $this -> db -> insert('plc2.plc2_upb_request_sample_detail', $dataD);

								if ($insD) {
									$ret .= $vNama_modul.' => Insert Berhasil ';
								}else{
									$ret .= $vNama_modul.' => Insert Gagal ';
								}


							}else{

								$ret = $vNama_modul.' => Insert Gagal ';


							}


				}
		}

		return $ret;

}


function P00017($id,$idmodul){
	// Pembuatan PO Request sample untuk tujuan sample
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
		$sqlcekAwal1 = '
						select *
						from plc2.plc2_upb_request_sample a
						where a.ldeleted=0
						and a.iupb_id="'.$id.'"
						and a.iapppd = 2
						order by a.ireq_id DESC limit 1
						';
		$dAwal1 = $this->db_plc0->query($sqlcekAwal1)->row_array();
		$sqlcekAwal = '
					select *
					from plc2.plc2_upb_po a
					join plc2.plc2_upb_po_detail b on b.ipo_id=a.ipo_id
					where a.ldeleted=0
					and b.ldeleted=0
					and b.ireq_id in ('.$dAwal1['ireq_id'].')
					and a.iapppr <> 1
					order by a.ipo_id DESC limit 1
		';



		$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

		if (!empty($dAwal)) {

			/*jika ada , cek approval*/
			$setatus = $dAwal['iapppr'];
			if ($setatus== '0') {
				$dataH=array();

				#field approval
				$dataH['vnip_pur'] = $this->user->gNIP;
				$dataH['tapp_pur'] = date('Y-m-d H:i:s');
				$dataH['iapppr'] = '2';
				$this -> db -> where('ipo_id', $dAwal['ipo_id']);
				$updet = $this -> db -> update('plc2.plc2_upb_po', $dataH);

				if ($updet) {
					$ret = $vNama_modul.' => Approval Berhasil ';
				}else{
					$ret = $vNama_modul.' => Approval Gagal ';
				}
			}else{
				/*jika sudah approve maka skip*/
				$ret = $vNama_modul.' => SKIP';
			}

		}else{
			// data belum ada
				// cek apakah flow baru
				if($iNewFlow==1){
					//jika flow baru
				}else{
					// insert  bebas, tapi sesuai dengan info di tabel.
					/*
						ketentuan
						1. raw material yang dibuat PO hanya 1 , yaitu VITAMIN A (RETINOL PALMITATE) id 2
						2. tujuan request untuk sample
						3. No PO menjadi Inj-Nip yang melakukan inject
						4. supplier PT Pharos Indonesia 390
						5. Status PO langsung diclose.
						6. inputan tanggal menjadi 1970-01-01
					*/
							// insert header dan detail
							$dataH=array();
							//$dataH['iupb_id'] = $id;


							$dataH['vpo_nomor'] = 'Inj-'.$this->user->gNIP;
							$dataH['isupplier_id'] = '390';
							$dataH['iapprove'] = '0'; // not use, tapi tidak ada default value
							$dataH['iclose_po'] = '1';
							$dataH['trequest'] = date('Y-m-d');
							$dataH['vor_nomor'] = 'Inj-'.$this->user->gNIP;
							$dataH['ttransfer'] = '1970-01-01';
							$dataH['tdeadline'] = '1970-01-01';
							$dataH['itype'] = '1';



							$dataH['cnip'] = $this->user->gNIP;
							$dataH['tupdate'] = date('Y-m-d H:i:s');
							$dataH['iSubmit'] = '1';
							$dataH['istatus'] = '1';



							#field approval
							$dataH['vnip_pur'] = $this->user->gNIP;
							$dataH['tapp_pur'] = date('Y-m-d H:i:s');
							$dataH['iapppr'] = '2';



							$insH = $this -> db -> insert('plc2.plc2_upb_po', $dataH);
							$idHead=$this->db_plc0->insert_id();



							if ($insH) {
								$ret = $vNama_modul.' Insert di Header Berhasil ';

								$dataD=array();
								$dataD['ipo_id'] = $idHead;

								$dataD['ireq_id'] = $dAwal1['ireq_id'];
								$dataD['raw_id'] = '2'; #request Vitamin A

								$dataD['ijumlah'] = '1';
								$dataD['vsatuan'] = 'Gram';
								$dataD['imanufacture_id'] = '1'; #MERCK

								$insD = $this -> db -> insert('plc2.plc2_upb_po_detail', $dataD);

								if ($insD) {
									$ret .= $vNama_modul.' => Insert Berhasil ';
								}else{
									$ret .= $vNama_modul.' => Insert Gagal ';
								}


							}else{

								$ret = $vNama_modul.' => Insert Gagal ';


							}


				}
		}

		return $ret;

}

function P00018($id,$idmodul){
	// Penerimaan Sample dari Supplier
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
		$sqlcekAwal1 = '
						select *
						from plc2.plc2_upb_request_sample a
						where a.ldeleted=0
						and a.iupb_id="'.$id.'"
						and a.iapppd = 2
						order by a.ireq_id DESC limit 1
						';
		$dAwal1 = $this->db_plc0->query($sqlcekAwal1)->row_array();
		$sqlcekAwal2 = '
					select *
					from plc2.plc2_upb_po a
					join plc2.plc2_upb_po_detail b on b.ipo_id=a.ipo_id
					where a.ldeleted=0
					and b.ldeleted=0
					and b.ireq_id in ('.$dAwal1['ireq_id'].')
					and a.iapppr = 2
					order by a.ipo_id DESC limit 1
		';



		$dAwal2 = $this->db_plc0->query($sqlcekAwal2)->row_array();

		$sqlcekAwal = '
						select *
						from plc2.plc2_upb_ro a
						join plc2.plc2_upb_ro_detail b on b.iro_id=a.iro_id
						where a.ldeleted=0
						and b.ldeleted=0
						and a.iapppr <> 1
						and a.ipo_id in ('.$dAwal2['ipo_id'].')
						order by a.iro_id DESC limit 1

						';
		$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

		if (!empty($dAwal)) {

			/*jika ada , cek approval*/
			$setatus = $dAwal['iapppr'];
			if ($setatus== '0') {
				$dataH=array();

				#field approval
				$dataH['vnip_pur'] = $this->user->gNIP;
				$dataH['tapp_pur'] = date('Y-m-d H:i:s');
				$dataH['iapppr'] = '2';
				$this -> db -> where('iro_id', $dAwal['iro_id']);
				$updet = $this -> db -> update('plc2.plc2_upb_ro', $dataH);

				if ($updet) {
					$ret = $vNama_modul.' => Approval Berhasil ';
				}else{
					$ret = $vNama_modul.' => Approval Gagal ';
				}
			}else{
				/*jika sudah approve maka skip*/
				$ret = $vNama_modul.' => SKIP';
			}

		}else{
			// data belum ada
				// cek apakah flow baru
				if($iNewFlow==1){
					//jika flow baru
				}else{
					$sqlcekAwal3 = '
						select *
						from plc2.plc2_upb_ro a
						join plc2.plc2_upb_ro_detail b on b.iro_id=a.iro_id
						where a.ldeleted=0
						and b.ldeleted=0
						and a.ipo_id in ('.$dAwal2['ipo_id'].')
						order by a.iro_id DESC limit 1

						';
					$dAwal3 = $this->db_plc0->query($sqlcekAwal3)->row_array();

					if(empty($dAwal3)){
						// jika belum pernah ada penerimaan bahan baku dari supplier sekalipun


						// insert  bebas, tapi sesuai dengan info di tabel.
						/*
							ketentuan
							1.

						*/
							// insert header dan detail
							$dataH=array();
							//$dataH['iupb_id'] = $id;


							$dataH['vro_nomor'] = 'Inj-'.$this->user->gNIP;
							$dataH['ipo_id'] = $dAwal2['ipo_id'];
							$dataH['iclose_po'] = '1';
							$dataH['trequest'] = date('Y-m-d');
							$dataH['tdeadline'] = '1970-01-01';


							$dataH['cnip'] = $this->user->gNIP;
							$dataH['tupdate'] = date('Y-m-d H:i:s');
							$dataH['istatus'] = '1';



							#field approval
							$dataH['vnip_pur'] = $this->user->gNIP;
							$dataH['tapp_pur'] = date('Y-m-d H:i:s');
							$dataH['iapppr'] = '2';



							$insH = $this -> db -> insert('plc2.plc2_upb_ro', $dataH);
							$idHead=$this->db_plc0->insert_id();



							if ($insH) {
								$ret = $vNama_modul.' => Insert Berhasil ';

								$dataD=array();
								$dataD['iro_id'] = $idHead;
								$dataD['ipo_id'] = $dAwal2['ipo_id'];

								$dataD['imanufacture_id'] = '1'; #MERCK
								$dataD['ireq_id'] = $dAwal1['ireq_id'];
								$dataD['raw_id'] = '2';
								$dataD['ijumlah'] = '1';
								$insD = $this -> db -> insert('plc2.plc2_upb_ro_detail', $dataD);

								if ($insD) {
									$ret .= $vNama_modul.' => Insert Berhasil ';

									$dataD2=array();
									$dataD2['iro_id'] = $idHead;
									$dataD2['vbatch_nomor'] = 'Inj-'.$this->user->gNIP;
									$dataD2['iJumlah'] = '1';
									$dataD2['vSatuan'] = 'Gram';
									$dataD2['cnip_update'] = $this->user->gNIP;
									$dataD2['cnip_insert'] = $this->user->gNIP;
									$dataD2['tinsert'] = date('Y-m-d H:i:s');
									$dataD2['tupdate'] = date('Y-m-d H:i:s');

									$insD2 = $this -> db -> insert('plc2.plc2_upb_ro_batch', $dataD2);
									if ($insD2) {
										$ret .= $vNama_modul.' => Insert Berhasil ';
									}else{
										$ret .= $vNama_modul.' => Insert Gagal ';
									}


								}else{
									$ret .= $vNama_modul.' => Insert Gagal ';
								}


							}else{

								$ret = $vNama_modul.' => Insert  Gagal ';


							}
					}else{
						$ret = $vNama_modul.' sudah pernah ada penerimaan dengan PO '.$dAwal2['vpo_nomor'].' => SKIP';
					}


				}
		}

		return $ret;

}

function P00019($id,$idmodul){
	// Terima Sample BB oleh AD / PD
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
		$sqlcekAwal1 = '
						select *
						from plc2.plc2_upb_request_sample a
						where a.ldeleted=0
						and a.iupb_id="'.$id.'"
						and a.iapppd = 2
						order by a.ireq_id DESC limit 1
						';
		$dAwal1 = $this->db_plc0->query($sqlcekAwal1)->row_array();
		$sqlcekAwal2 = '
					select *
					from plc2.plc2_upb_po a
					join plc2.plc2_upb_po_detail b on b.ipo_id=a.ipo_id
					where a.ldeleted=0
					and b.ldeleted=0
					and b.ireq_id in ('.$dAwal1['ireq_id'].')
					and a.iapppr = 2
					order by a.ipo_id DESC limit 1
		';



		$dAwal2 = $this->db_plc0->query($sqlcekAwal2)->row_array();

		$sqlcekAwals = '
						select *
						from plc2.plc2_upb_ro a
						join plc2.plc2_upb_ro_detail b on b.iro_id=a.iro_id
						where a.ldeleted=0
						and b.ldeleted=0
						and a.iapppr = 2
						and a.ipo_id in ('.$dAwal2['ipo_id'].')
						#order by a.iro_id DESC limit 1

						';
		#$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();
		$dAwals = $this->db_plc0->query($sqlcekAwals)->result_array();
		if (!empty($dAwals)) {
			foreach ($dAwals as $dAwal) {
				if (!empty($dAwal)) {
					/*jika ada , cek approval*/
					$setatus = $dAwal['vrec_nip_pd'];
					if ($setatus== '') {
						$dataH=array();
						#field approval
						$dataH['iUjiMikro_bb'] = '0'; // default tidak Uji Mikro BB
						$dataH['vwadah'] = '1';
						$dataH['vrec_jum_pd'] = '1';
						$dataH['vrec_nip_pd'] = $this->user->gNIP;
						$dataH['trec_date_pd'] = '1970-01-01';
						$dataH['vrec_jum_qc'] = '1';
						$dataH['vrec_nip_qc'] = $this->user->gNIP;
						$dataH['trec_date_qc'] = '1970-01-01';

						$this -> db -> where('irodet_id', $dAwal['irodet_id']);
						$updet = $this -> db -> update('plc2.plc2_upb_ro_detail', $dataH);
							if ($updet) {
								$ret = $vNama_modul.' => Update Berhasil ';

							}else{
								$ret = $vNama_modul.' => Update Gagal ';
							}



					}else{
						/*jika sudah approve maka skip*/
						$ret = $vNama_modul.' => SKIP';
					}

				}

			}
		}




		return $ret;

}

function P00020x($id,$idmodul){
	//	Terima Sample BB oleh QA
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
		$sqlcekAwal1 = '
						select *
						from plc2.plc2_upb_request_sample a
						where a.ldeleted=0
						and a.iupb_id="'.$id.'"
						and a.iapppd = 2
						order by a.ireq_id DESC limit 1
						';
		$dAwal1 = $this->db_plc0->query($sqlcekAwal1)->row_array();
		$sqlcekAwal2 = '
					select *
					from plc2.plc2_upb_po a
					join plc2.plc2_upb_po_detail b on b.ipo_id=a.ipo_id
					where a.ldeleted=0
					and b.ldeleted=0
					and b.ireq_id in ('.$dAwal1['ireq_id'].')
					and a.iapppr = 2
					order by a.ipo_id DESC limit 1
		';



		$dAwal2 = $this->db_plc0->query($sqlcekAwal2)->row_array();

		$sqlcekAwal = '
						select *
						from plc2.plc2_upb_ro a
						join plc2.plc2_upb_ro_detail b on b.iro_id=a.iro_id
						where a.ldeleted=0
						and b.ldeleted=0
						and a.iapppr = 2
						and a.ipo_id in ('.$dAwal2['ipo_id'].')
						order by a.iro_id DESC limit 1

						';
		$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

		if (!empty($dAwal)) {
			/*jika ada , cek approval*/
			$setatus = $dAwal['vrec_jum_qa'];
			if ($setatus== '') {
				$dataH=array();
				#field approval
				$dataH['vrec_jum_qa'] = '1';
				$dataH['vrec_nip_qa'] = $this->user->gNIP;
				$dataH['trec_date_qa'] = '1970-01-01';

				$this -> db -> where('irodet_id', $dAwal['irodet_id']);
				$updet = $this -> db -> update('plc2.plc2_upb_ro_detail', $dataH);
					if ($updet) {
						$ret = $vNama_modul.' Update QA Terima Bahan Baku Berhasil ';
					}else{
						$ret = $vNama_modul.' Update QA Terima Bahan Baku Gagal ';
					}



			}else{
				/*jika sudah approve maka skip*/
				$ret = $vNama_modul.' SKIP';
			}

		}

		return $ret;

}
function P00020($id,$idmodul){
	//	Terima Sample BB oleh QA
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
		$sqlcekAwal1 = '
						select *
						from plc2.plc2_upb_request_sample a
						where a.ldeleted=0
						and a.iupb_id="'.$id.'"
						and a.iapppd = 2
						order by a.ireq_id DESC limit 1
						';
		$dAwal1 = $this->db_plc0->query($sqlcekAwal1)->row_array();
		$sqlcekAwal2 = '
					select *
					from plc2.plc2_upb_po a
					join plc2.plc2_upb_po_detail b on b.ipo_id=a.ipo_id
					where a.ldeleted=0
					and b.ldeleted=0
					and b.ireq_id in ('.$dAwal1['ireq_id'].')
					and a.iapppr = 2
					order by a.ipo_id DESC limit 1
		';



		$dAwal2 = $this->db_plc0->query($sqlcekAwal2)->row_array();

		$sqlcekAwals = '
						select *
						from plc2.plc2_upb_ro a
						join plc2.plc2_upb_ro_detail b on b.iro_id=a.iro_id
						where a.ldeleted=0
						and b.ldeleted=0
						and a.iapppr = 2
						and a.ipo_id in ('.$dAwal2['ipo_id'].')
						#order by a.iro_id DESC limit 1

						';
		#$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();
		$dAwals = $this->db_plc0->query($sqlcekAwals)->result_array();
		if (!empty($dAwals)) {
			foreach ($dAwals as $dAwal) {
				if (!empty($dAwal)) {
					/*jika ada , cek approval*/
					$setatus = $dAwal['vrec_jum_qa'];
					if ($setatus== '') {
						$dataH=array();
						#field approval
						$dataH['vrec_jum_qa'] = '1';
						$dataH['vrec_nip_qa'] = $this->user->gNIP;
						$dataH['trec_date_qa'] = '1970-01-01';

						$this -> db -> where('irodet_id', $dAwal['irodet_id']);
						$updet = $this -> db -> update('plc2.plc2_upb_ro_detail', $dataH);
							if ($updet) {
								$ret = $vNama_modul.' => Update Berhasil ';
							}else{
								$ret = $vNama_modul.' => Update Gagal ';
							}



					}else{
						/*jika sudah approve maka skip*/
						$ret = $vNama_modul.' => SKIP';
					}

				}

			}
		}

		return $ret;

}

function P00003($id,$idmodul){
	$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
	$mod = $this->db_plc0->query($sql_mod)->row_array();
	$vNama_modul = $mod['vNama_modul'];
	$iNewFlow = $mod['iNewFlow'];

	$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
	$dUpb = $this->db_plc0->query($sqUpb)->row_array();

	$ret= '';

	/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
	$sqlcekAwal = 'SELECT * FROM plc2.plc2_upb_request_originator pu WHERE
					pu.ldeleted = 0 AND pu.iapppd<> 1 AND pu.iupb_id =  "'.$id.'"  order by ireq_ori_id DESC LIMIT 1
					';
	$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

	if (!empty($dAwal)) {

		/*jika ada , cek approval*/
		$setatus = $dAwal['iapppd'];
		$kirim = $dAwal['isent_status'];
		if ($setatus== '') {
			$data_up=array('tapppd'=>date('Y-m-d H:i:s'),'iapppd'=>'2','iSubmit'=>'1');
			$this -> db -> where('ireq_ori_id', $dAwal['ireq_ori_id']);
			$updet = $this -> db -> update('plc2.plc2_upb_request_originator', $data_up);

			if ($updet) {
				$ret = $vNama_modul.' => Approval Berhasil ';
			}else{
				$ret = $vNama_modul.' => Approval Gagal ';
			}
		}else{
			/*jika sudah approve maka skip*/
			$ret = $vNama_modul.'  => SKIP';
		}

	}else{
		// data belum ada
			// cek apakah flow baru
			if($iNewFlow==1){
				//jika flow baru
			}else{
				// insert  bebas, tapi sesuai dengan info di tabel.
				/*
					ketentuan
					1. smester yang dipilih adalah semester 1
					2. tahun dipilih adalah tahun berjalan
					3. team PD yang dipilih sesuai dengan data pada daftar UPB
					4. bobot 1
				*/


				// jika flow lama
					// cek adakah prioritas di smester 1 tahun berjalan ?

					$dataH['iupb_id'] = $id;
					$dataH['iapprove'] = 2;
					$dataH['iapppd'] = 2;

					$dataH['ijum_ori'] = 1;
					$dataH['plc2_master_satuan_id'] = 11;
					$dataH['tupdate'] = date('Y-m-d H:i:s');

					$dataH['tapppd'] = date('Y-m-d H:i:s');
					$dataH['trequest'] = date('Y-m-d H:i:s');
					$dataH['trequest_ori'] = date('Y-m-d H:i:s');

					$dataH['vnama_originator'] = 'INJECT BY '.$this->user->gNIP;

					$dataH['cnip'] =$this->user->gNIP;
					$dataH['iTujuan_req'] =1;

					$dataH['iSubmit'] = '1';
					//$dataH['isent_status'] = '1';


					if($insH = $this -> db -> insert('plc2.plc2_upb_request_originator', $dataH)){
						$ids = $this->db_plc0->insert_id();
						$nomor = "R".str_pad($ids, 7, "0", STR_PAD_LEFT);
						$sql = "UPDATE plc2.plc2_upb_request_originator SET vreq_ori_no = '".$nomor."' WHERE ireq_ori_id=".$ids." LIMIT 1";
						$query = $this->db_plc0->query( $sql );
						$ret = $vNama_modul.'  => Update Berhasil';
					}else{
						$ret = $vNama_modul.' => Update Gagal';
					}
					//$idHead=$this->db_plc0->insert_id();






			}
	}

	return $ret;
}
function P00004($id,$idmodul){


	$sql = "SELECT plc2_upb_master_kategori_upb.vkategori AS plc2_upb_master_kategori_upb__vkategori,
		plc2_upb_request_originator.vreq_ori_no AS plc2_upb_request_originator__vreq_ori_no,
		plc2_upb_request_originator.isent_status
		AS plc2_upb_request_originator__isent_status, plc2_upb_request_originator.ireq_ori_id, plc2.plc2_upb.*
		FROM (plc2.plc2_upb)
		INNER JOIN plc2.plc2_upb_master_kategori_upb ON plc2_upb_master_kategori_upb.ikategori_id =
		plc2.plc2_upb.ikategoriupb_id
		INNER JOIN plc2.plc2_upb_request_originator ON plc2_upb_request_originator.iupb_id = plc2.plc2_upb.iupb_id
		WHERE plc2_upb.ldeleted =  0
		AND plc2.plc2_upb.ldeleted =  0
		AND plc2.plc2_upb.iKill =  0
		AND plc2_upb.ihold =  0
		AND plc2_upb_request_originator.iapppd =  2
		AND plc2.plc2_upb.iupb_id = '".$id."'
		";

	$nes = " LIMIT 1 ";

	$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
	$mod = $this->db_plc0->query($sql_mod)->row_array();
	$vNama_modul = $mod['vNama_modul'];
	$iNewFlow = $mod['iNewFlow'];


	$emp = $this->db_plc0->query($sql)->result_array();
	$ret = '';
	if(empty($emp)){
		if($iNewFlow==1){
				//jika flow baru
		}else{
			$qr = $sql.$nes;
			$ck = $this->db_plc0->query($qr)->row_array();
			if($ck['plc2_upb_request_originator__isent_status']==0){
				$dupb['isent_status']='1';
				$this->db_plc0->where('ireq_ori_id', $ck['ireq_ori_id']);
				$this->db_plc0->update('plc2.plc2_upb_request_originator', $dupb);
			}

					$idet['dTanggalTerimaQA'] = date('Y-m-d H:i:s');
					$idet['cPenerimaQA'] = $this->user->gNIP;
					$idet['txtNoteQA'] = 'INJECT BY '.$this->user->gNIP;
					$idet['cAdmQA'] = $this->user->gNIP;
					$idet['dInputQA'] = date('Y-m-d H:i:s');

					$idet['dTanggalTerimaQC'] = date('Y-m-d H:i:s');
					$idet['cPenerimaQC'] = $this->user->gNIP;
					$idet['txtNoteQC'] = 'INJECT BY '.$this->user->gNIP;
					$idet['cAdmQC'] = $this->user->gNIP;
					$idet['dInputQC'] = date('Y-m-d H:i:s');

					$idet['dTanggalKirimBD'] = date('Y-m-d H:i:s');
					$idet['cPengirimBD'] = $this->user->gNIP;
					$idet['txtNoteBD'] = 'INJECT BY '.$this->user->gNIP;
					$idet['cAdmBD'] = $this->user->gNIP;
					$idet['dInputBD'] = date('Y-m-d H:i:s');


					$idet['dTanggalTerimaAD'] = date('Y-m-d H:i:s');
					$idet['cPenerimaAD'] = $this->user->gNIP;
					$idet['txtNoteAD'] = 'INJECT BY '.$this->user->gNIP;
					$idet['cAdmAD'] = $this->user->gNIP;
					$idet['dInputAD'] = date('Y-m-d H:i:s');

					$idet['dTanggalTerimaPD'] = date('Y-m-d H:i:s');
					$idet['cPenerimaPD'] = $this->user->gNIP;
					$idet['txtNotePD'] = 'INJECT BY '.$this->user->gNIP;
					$idet['cAdmPD'] = $this->user->gNIP;
					$idet['dInputPD'] = date('Y-m-d H:i:s');

					$idet['iReq_ori_id'] = $ck['ireq_ori_id'];
					$idet['iupb_id'] = $id;
					$idet['iCompanyId'] = $ck['iCompanyId'];


					if($this->db_plc0->insert('plc2.plc2_upb_date_sample', $idet)){
						$ret .= $vNama_modul.' => Insert Berhasil';
					}else{
						$ret .= $vNama_modul.' => Insert Gagal';
					}

			//Insert in Here

		}

	}else{
		$ret .= $vNama_modul.' => SKIP';
	}

	return $ret;
}

//Ini Skala Trial
function P00010($id,$idmodul){

	$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
	$mod = $this->db_plc0->query($sql_mod)->row_array();
	$vNama_modul = $mod['vNama_modul'];
	$iNewFlow = $mod['iNewFlow'];

	//Cek Dulu Seblum Insert udah ngulang apa gx ?
	//Kalo udah ngulang Done
	//Kalo Belum INSERT
	//Cek UPB ITU UNTUK SAMPLE Kalo Bukan Done
	//Kalo Iya Insert ke Skala Trial 1
	$sqcc = "SELECT * FROM pddetail.formula_process fp WHERE fp.iMaster_flow=1 and fp.iupb_id = '".$id."'";
	$hellyeah = $this->db_plc0->query($sqcc)->result_array();

	if(empty($hellyeah)){
		if($iNewFlow==1){
			 	$cNip = $this->user->gNIP;
				$formula_i = 'FORMULA INJECT';

				//
					//Formula UPB
					$for = "SELECT pu.vkode_surat, pu.vnip_formulator FROM plc2.plc2_upb_formula pu WHERE pu.iupb_id = '".$id."' ORDER BY pu.ifor_id DESC";
					$dt = $this->db_plc0->query($for)->row_array();
					if(!empty($dt['vkode_surat'])){
						$formula_i = $dt['vkode_surat'];
					}

					if(!empty($dt['vnip_formulator'])){
						$cNip = $dt['vnip_formulator'];
					}


				//



				$dUpdate_time = date("Y-m-d H:i:s");


				$sqlto_Back = "INSERT pddetail.formula_process (iupb_id,iMaster_flow,cCreated,dCreate) VALUES
					('".$id."','1','".$cNip."',SYSDATE())";
				$this->db_plc0->query($sqlto_Back);
				$iFormula_process = $this->db_plc0->insert_id();

				//Insert Formula Proses Detail
				$pn = "INSERT INTO pddetail.formula_process_detail(iFormula_process, cPic, iProses_id, is_proses,
					dStart_time, cCreated, dCreate,dFinish_time)
				VALUES ('".$iFormula_process."','".$cNip."','1','1','".$dUpdate_time."','".$cNip."','".$dUpdate_time."','".$dUpdate_time."')";
				$this->db_plc0->query($pn);

				//Insert Formula Awal
				$ver = 0;
				$iFd ='INSERT INTO pddetail.formula (iFormula_process,iVersi,
					dCreate,cCreated,iFinishSkalaLab,iApp_formula,cApp_formula,
					dApp_formula,iNextStressTest,iNextSkalaLabs,vNo_formula,iKeteranganTrial) VALUES
					("'.$iFormula_process.'","0","'.$dUpdate_time.'",
						"'.$cNip.'",1,2,"'.$this->user->gNIP.'",
						"'.date("Y-m-d H:i:s").'",1,1,"'.$formula_i.'",1)';
				$this->db_plc0->query($iFd);



				$sqlcekupb= "SELECT a.iupb_id from plc2.plc2_upb_formula a where a.ldeleted = 0 and	a.iupb_id = '".$id."' and a.iFormula_process ='".$iFormula_process."'";
				$nums = $this->db_plc0->query($sqlcekupb)->num_rows();
				if($nums>0){
				}else{
					$sql = "INSERT INTO plc2.plc2_upb_formula (iupb_id,iFormula_process) values('".$id."','".$iFormula_process."')";
					$this->db_plc0->query($sql);
				}




				//Next Modul

				$sqlto_Back = "INSERT pddetail.formula_process (iupb_id,iMaster_flow,cCreated,dCreate) VALUES
					('".$id."','2','".$cNip."',SYSDATE())";
				$this->db_plc0->query($sqlto_Back);
				$iFormula_process = $this->db_plc0->insert_id();

				//Insert Formula Proses Detail
				//Isi Next Stress Test
				$pn = "INSERT INTO pddetail.formula_process_detail(iFormula_process, cPic, iProses_id, is_proses, dStart_time, cCreated, dCreate) VALUES ('".$iFormula_process."','".$cNip."','1','1','".$dUpdate_time."','".$cNip."','".$dUpdate_time."')";
				$this->db_plc0->query($pn);
				$ver = 0;
				$iFd ='INSERT INTO pddetail.formula (iFormula_process,iVersi,
					dCreate,cCreated,iNextStressTest,iNextSkalaLabs,vNo_formula) VALUES
					("'.$iFormula_process.'","0","'.$dUpdate_time.'",
						"'.$cNip.'",1,1,"'.$formula_i.'")';
				$this->db_plc0->query($iFd);
				$ret = ''.$vNama_modul." Insert Berhasil";


				//Insert Formula
				$sqlcekupb= "SELECT a.iupb_id from plc2.plc2_upb_formula a where a.ldeleted = 0 and a.iupb_id = '".$id."' and
				a.iFormula_process ='".$iFormula_process."'";
				$nums = $this->db_plc0->query($sqlcekupb)->num_rows();
				if($nums>0){
				}else{
					$sql = "INSERT INTO plc2.plc2_upb_formula (iupb_id,iFormula_process) values('".$id."','".$iFormula_process."')";
					$this->db_plc0->query($sql);
					//Insert Data
				}

				//Langsung Insert 3 aja ke Formula Proses
			//}
		}else{
			$ret = ''.$vNama_modul." SKIP";
		}
	}else{
		$i=0;
		foreach ($hellyeah as $v) {
			if($i==0){
				$sql = "INSERT INTO plc2.plc2_upb_formula (iupb_id,iFormula_process) values('".$id."','".$v['iFormula_process']."')";
				$this->db_plc0->query($sql);
			}

			$s="select * from pddetail.formula f where f.iApp_formula  = 0 and f.iFormula_process = ".$v['iFormula_process'];
			$ss = $this->db_plc0->query($s)->result_array();
			if(!empty($ss)){
			$sql = "UPDATE pddetail.formula f SET f.iKeteranganTrial=1,f.iApp_formula=2, f.cApp_formula='".$this->user->gNIP."', dApp_formula='".date("Y-m-d H:i:s")."', iFinishSkalaTrial=1 where
					iFormula_process = ".$v['iFormula_process'];

			$this->db_plc0->query($sql );



				if($i==0){

					$dts = $s="select * from pddetail.formula f where f.iFormula_process = ".$v['iFormula_process']." LIMIT 1";
					$tss = $this->db_plc0->query($dts)->row_array();
					$cNip = $this->user->gNIP;
					$dUpdate_time = date("Y-m-d H:i:s");
					$formula_i = 'FORMULA INJECT';

					if(!empty($tss['vNo_formula'])){
						$formula_i = $tss['vNo_formula'];
					}

					if(!empty($tss['cCreated'])){
						$cNip = $tss['cCreated'];
					}



					$sqlto_Back = "INSERT pddetail.formula_process (iupb_id,iMaster_flow,cCreated,dCreate) VALUES
						('".$id."','2','".$cNip."',SYSDATE())";
					$this->db_plc0->query($sqlto_Back);
					$iFormula_process = $this->db_plc0->insert_id();
					//Insert Formula Proses Detail
					//Isi Next Stress Test
					$pn = "INSERT INTO pddetail.formula_process_detail(iFormula_process, cPic, iProses_id, is_proses, dStart_time, cCreated, dCreate) VALUES ('".$iFormula_process."','".$cNip."','1','1','".$dUpdate_time."','".$cNip."','".$dUpdate_time."')";
					$this->db_plc0->query($pn);
					$ver = 0;
					$iFd ='INSERT INTO pddetail.formula (iFormula_process,iVersi,
						dCreate,cCreated,iNextStressTest,iNextSkalaLabs,vNo_formula) VALUES
						("'.$iFormula_process.'","0","'.$dUpdate_time.'",
							"'.$cNip.'",1,1,"'.$formula_i.'")';
					$this->db_plc0->query($iFd);

					//Insert Formula
					$sqlcekupb= "SELECT a.iupb_id from plc2.plc2_upb_formula a where a.ldeleted = 0 and a.iupb_id = '".$id."' and
					a.iFormula_process ='".$iFormula_process."'";
					$nums = $this->db_plc0->query($sqlcekupb)->num_rows();
					if($nums>0){
					}else{
						$sql = "INSERT INTO plc2.plc2_upb_formula (iupb_id,iFormula_process) values('".$id."','".$iFormula_process."')";
						$this->db_plc0->query($sql);
						//Insert Data
					}

				}
				$i++;



			}
		}
		$ret = ''.$vNama_modul." => SKIP";
	}

	//Update or formula

	return $ret;
}

//Module Stress Test

function P00026($id,$idmodul){

	$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
	$mod = $this->db_plc0->query($sql_mod)->row_array();
	$vNama_modul = $mod['vNama_modul'];
	$iNewFlow = $mod['iNewFlow'];

	$sqcc = "SELECT * FROM pddetail.formula_process fp WHERE fp.iMaster_flow=2 and fp.iupb_id = '".$id."'";
		$hellyeah = $this->db_plc0->query($sqcc)->result_array();
	if(empty($hellyeah)){
	if($iNewFlow==1){
		$cNip = $this->user->gNIP;
		$dUpdate_time = date("Y-m-d H:i:s");
		$formula_i = 'FORMULA INJECT';



		//No Formula
		$for = "SELECT pu.vkode_surat, pu.vnip_formulator FROM plc2.plc2_upb_formula pu WHERE pu.iupb_id = '".$id."' ORDER BY pu.ifor_id DESC";
		$dt = $this->db_plc0->query($for)->row_array();
		if(!empty($dt['vkode_surat'])){
			$formula_i = $dt['vkode_surat'];
		}

		if(!empty($dt['vnip_formulator'])){
			$cNip = $dt['vnip_formulator'];
		}





		$sqlto_Back = "INSERT pddetail.formula_process (iupb_id,iMaster_flow,cCreated,dCreate) VALUES
			('".$id."','2','".$cNip."',SYSDATE())";
		$this->db_plc0->query($sqlto_Back);
		$iFormula_process = $this->db_plc0->insert_id();

		//Insert Formula Proses Detail
		$pn = "INSERT INTO pddetail.formula_process_detail(iFormula_process, cPic, iProses_id, is_proses,
			dStart_time, cCreated, dCreate,dFinish_time)
		VALUES ('".$iFormula_process."','".$cNip."','1','1','".$dUpdate_time."','".$cNip."','".$dUpdate_time."','".$dUpdate_time."')";
		$this->db_plc0->query($pn);

		//Insert Formula Awal
		$ver = 0;
		$iFd ='INSERT INTO pddetail.formula (iFormula_process,iVersi,
					dCreate,cCreated,iFinishSkalaLab,iApp_formula,cApp_formula,
					dApp_formula,iNextStressTest,iNextSkalaLabs,vNo_formula,iKeteranganTrial) VALUES
					("'.$iFormula_process.'","0","'.$dUpdate_time.'",
						"'.$cNip.'",1,2,"'.$this->user->gNIP.'",
						"'.date("Y-m-d H:i:s").'",1,1,"'.$formula_i.'",1)';
				$this->db_plc0->query($iFd);


		//$ret = ''.$vNama_modul." DONE";

		//Skala Lab
		$sqlto_Back = "INSERT pddetail.formula_process (iupb_id,iMaster_flow,cCreated,dCreate) VALUES
					('".$id."','4','".$cNip."',SYSDATE())";
				$this->db_plc0->query($sqlto_Back);
				$iFormula_process = $this->db_plc0->insert_id();
		$pn = "INSERT INTO pddetail.formula_process_detail(iFormula_process, cPic, iProses_id,
			is_proses, dStart_time, cCreated,
			dCreate) VALUES ('".$iFormula_process."','".$cNip."','1','1',
			'".$dUpdate_time."','".$cNip."','".$dUpdate_time."')";
		$this->db_plc0->query($pn);
		$ver = 0;
		$iFd ='INSERT INTO pddetail.formula (iFormula_process,iVersi,
			dCreate,cCreated,iNextStressTest,iNextSkalaLabs, vNo_formula) VALUES
			("'.$iFormula_process.'","0","'.$dUpdate_time.'",
				"'.$cNip.'",1,1,"'.$formula_i.'")';
		$this->db_plc0->query($iFd);
		$ret = $vNama_modul." => Insert Berhasil'";

		//Mapping Skala Lab
		$sqlMap = "INSERT INTO pddetail.flow_upb (iMaster_flow,iupb_id) VALUES(4,".$id.")";
		$this->db_plc0->query($sqlMap);
		$in = $this->db_plc0->insert_id();

		//$dt = array(1,2,3,4,14,16,15,5,6,7,8);
		$sqls="SELECT m.iProses_id FROM pddetail.master_flow_detail m WHERE m.iMaster_flow = 4 AND m.lDeleted = 0 ORDER BY m.iSort ASC";
		$dt = $this->db_plc0->query($dt)->result_array();
		$i=1;
		foreach ($dt as $d) {
			$sql = "INSERT INTO pddetail.flow_upb_detail (iFlow_upb, iProses_id, iSort)
			VALUES(".$in.",".$d['iProses_id'].",".$i.")";
			$this->db_plc0->query($sql);
			$i++;
		}



	}else{
		$ret = $vNama_modul." => SKIP";
	}
	}else{
		$i=0;
		$j=0;
		foreach ($hellyeah as $v) {
			$s="select * from pddetail.formula f where f.iApp_formula  = 0 and f.iFormula_process = ".$v['iFormula_process'];
			$ss = $this->db_plc0->query($s)->result_array();
			if(!empty($ss)){
			$sql = "UPDATE pddetail.formula f SET f.iKeteranganTrial=1, f.iApp_formula=2, f.cApp_formula='".$this->user->gNIP."', dApp_formula='".date("Y-m-d H:i:s")."', iFinishStresTest=1 where
					iFormula_process = ".$v['iFormula_process'];
			$this->db_plc0->query($sql );
			$j++;
				if($i==0){
				// $cNip = $this->user->gNIP;
				// $dUpdate_time = date("Y-m-d H:i:s");


				$dts = $s="select * from pddetail.formula f where f.iFormula_process = ".$v['iFormula_process']." LIMIT 1";
				$tss = $this->db_plc0->query($dts)->row_array();
				$cNip = $this->user->gNIP;
				$dUpdate_time = date("Y-m-d H:i:s");
				$formula_i = 'FORMULA INJECT';

				if(!empty($tss['vNo_formula'])){
					$formula_i = $tss['vNo_formula'];
				}

				if(!empty($tss['cCreated'])){
					$cNip = $tss['cCreated'];
				}


				$sqlto_Back = "INSERT pddetail.formula_process (iupb_id,iMaster_flow,cCreated,dCreate) VALUES
							('".$id."','4','".$cNip."',SYSDATE())";
						$this->db_plc0->query($sqlto_Back);
						$iFormula_process = $this->db_plc0->insert_id();
				$pn = "INSERT INTO pddetail.formula_process_detail(iFormula_process, cPic, iProses_id,
					is_proses, dStart_time, cCreated,
					dCreate) VALUES ('".$iFormula_process."','".$cNip."','1','1',
					'".$dUpdate_time."','".$cNip."','".$dUpdate_time."')";
				$this->db_plc0->query($pn);
				$ver = 0;
				$iFd ='INSERT INTO pddetail.formula (iFormula_process,iVersi,
					dCreate,cCreated,iNextStressTest,iNextSkalaLabs, vNo_formula) VALUES
					("'.$iFormula_process.'","0","'.$dUpdate_time.'",
						"'.$cNip.'",1,1,"'.$formula_i.'")';
				$this->db_plc0->query($iFd);


				//Mapping Skala Lab
				$sqlMap = "INSERT INTO pddetail.flow_upb (iMaster_flow,iupb_id) VALUES(4,".$id.")";
				$this->db_plc0->query($sqlMap);
				$in = $this->db_plc0->insert_id();

				$sqls="SELECT m.iProses_id FROM pddetail.master_flow_detail m WHERE m.iMaster_flow = 4 AND m.lDeleted = 0 ORDER BY m.iSort ASC";
				$dt = $this->db_plc0->query($dt)->result_array();
				$i=1;
				foreach ($dt as $d) {
					$sql = "INSERT INTO pddetail.flow_upb_detail (iFlow_upb, iProses_id, iSort)
					VALUES(".$in.",".$d.",".$i.")";
					$this->db_plc0->query($sql);
					$i++;
				}

				}
				$i++;

			}
		}
		if($j>0){
			$ret = ''.$vNama_modul." => Approval Berhasil";
		}else{
			$ret = ''.$vNama_modul." => SKIP";
		}
	}
//$ret = 'Lagi Dibuat Santai coy !!';


	return $ret;
}
//Modul Skala Lab
function P00015($id,$idmodul){
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqcc = "SELECT * FROM pddetail.formula_process fp WHERE fp.iMaster_flow=4 and fp.iupb_id = '".$id."'";
		$hellyeah = $this->db_plc0->query($sqcc)->result_array();
		if(empty($hellyeah)){
			if($iNewFlow==1){
				$cNip = $this->user->gNIP;
				$dUpdate_time = date("Y-m-d H:i:s");
				$formula_i = 'FORMULA INJECT';



				//No Formula
				$for = "SELECT pu.vkode_surat, pu.vnip_formulator FROM plc2.plc2_upb_formula pu WHERE pu.iupb_id = '".$id."' ORDER BY pu.ifor_id DESC";
				$dt = $this->db_plc0->query($for)->row_array();
				if(!empty($dt['vkode_surat'])){
					$formula_i = $dt['vkode_surat'];
				}

				if(!empty($dt['vnip_formulator'])){
					$cNip = $dt['vnip_formulator'];
				}


				$sqlto_Back = "INSERT pddetail.formula_process (iupb_id,iMaster_flow,cCreated,dCreate) VALUES
					('".$id."','4','".$cNip."',SYSDATE())";
				$this->db_plc0->query($sqlto_Back);
				$iFormula_process = $this->db_plc0->insert_id();

				//Insert Formula Proses Detail
				$pn = "INSERT INTO pddetail.formula_process_detail(iFormula_process, cPic, iProses_id, is_proses,
					dStart_time, cCreated, dCreate,dFinish_time)
				VALUES ('".$iFormula_process."','".$cNip."','1','1','".$dUpdate_time."','".$cNip."','".$dUpdate_time."','".$dUpdate_time."')";
				$this->db_plc0->query($pn);

				//Insert Formula Awal
				$ver = 0;
				$iFd ='INSERT INTO pddetail.formula (iFormula_process,iVersi,
							dCreate,cCreated,iFinishSkalaLab,iApp_formula,cApp_formula,
							dApp_formula,iNextStressTest,iNextSkalaLabs,vNo_formula,iKeteranganTrial) VALUES
							("'.$iFormula_process.'","0","'.$dUpdate_time.'",
								"'.$cNip.'",1,2,"'.$this->user->gNIP.'",
								"'.date("Y-m-d H:i:s").'",1,1,"'.$formula_i.'",1)';
						$this->db_plc0->query($iFd);


				$ret = ''.$vNama_modul." => Insert Berhasil";

				//Skala Lab
				$this->next_proses($id,6,0,$formula_i,0);//To Stabilita LAB Accelarated
				$this->next_proses($id,7,0,$formula_i,0);//To Stabilita LAB Intermediate
				$this->next_proses($id,8,0,$formula_i,0);//To Stabilita LAB Realtime


		}else{
			$ret = $vNama_modul." => SKIP";
		}
	}else{
		$i=0;
		foreach ($hellyeah as $v) {
			$s="select * from pddetail.formula f where f.iApp_formula  = 0 and f.iFormula_process = ".$v['iFormula_process'];
			$ss = $this->db_plc0->query($s)->result_array();
			if(!empty($ss)){
			$sql = "UPDATE pddetail.formula f SET f.iKeteranganTrial=1, f.iApp_formula=2, f.cApp_formula='".$this->user->gNIP."', dApp_formula='".date("Y-m-d H:i:s")."', iFinishSkalaLab=1 where
					iFormula_process = ".$v['iFormula_process'];
			$this->db_plc0->query($sql );
				if($i==0){

					$dts = $s="select * from pddetail.formula f where f.iFormula_process = ".$v['iFormula_process']." LIMIT 1";
					$tss = $this->db_plc0->query($dts)->row_array();
					$cNip = $this->user->gNIP;
					$dUpdate_time = date("Y-m-d H:i:s");
					$formula_i = 'FORMULA INJECT';
					if(!empty($tss['vNo_formula'])){
						$formula_i = $tss['vNo_formula'];
					}

					if(!empty($tss['cCreated'])){
						$cNip = $tss['cCreated'];
					}


					$this->next_proses($id,6,0,$formula_i,0);//To Stabilita LAB Accelarated
					$this->next_proses($id,7,0,$formula_i,0);//To Stabilita LAB Intermediate
					$this->next_proses($id,8,0,$formula_i,0);//To Stabilita LAB Realtime
				}
				$i++;
			}
		}
		if($i>0){
			$ret = ''.$vNama_modul." => Approval Berhasil";
		}else{
			$ret = ''.$vNama_modul." => SKIP";
		}

	}
	//$ret = 'Lagi Dibuat Santai coy !!';


	return $ret;
}
function next_proses($iupb,$n_modul,$versi,$noFormula,$dt){
		$dFinish_time = date('Y-m-d H:i:s');
		$dUpdate_time = date('Y-m-d H:i:s');
		$cNip = $this->user->gNIP;

		$insertFormula = "INSERT pddetail.formula_process (iupb_id,iMaster_flow,dCreate,cCreated) VALUES
		('".$iupb."','".$n_modul."','".$dUpdate_time."','".$cNip."') ";
		$this->db_plc0->query($insertFormula);

		$iFormula_process = $this->db_plc0->insert_id();

		//Insert Detail
		$insertProses_detail = "INSERT INTO pddetail.formula_process_detail(iFormula_process, cPic, iProses_id, is_proses, dStart_time,
			cCreated, dCreate) VALUES ('".$iFormula_process."','".$cNip."','1','1','".$dFinish_time."','".$cNip."','".$dUpdate_time."')";
		$this->db_plc0->query($insertProses_detail);

		//Insert To formula
		if($dt==0){
			$iFd ='INSERT INTO pddetail.formula_stabilita (iFormula_process,dCreate,cCreated,vNo_formula,iVersi)
				VALUES("'.$iFormula_process.'","'.$dUpdate_time.'","'.$cNip.'","'.$noFormula.'","'.$versi.'")';
			$this->dbset->query($iFd);
		}else{
			$iFd ='INSERT INTO pddetail.formula_stabilita (iFormula_process,dCreate,cCreated,
				vNo_formula,iVersi,iApp_formula,cApp_formula,dApp_formula,iFinishProses,iKesimpulanStabilita,
				isKesimpulanOk,isubmitformula)
				VALUES("'.$iFormula_process.'","'.$dUpdate_time.'","'.$cNip.'",
					"'.$noFormula.'","'.$versi.'",2,"'.$cNip.'","'.$dUpdate_time.'",1,1,1,1)';
			$this->dbset->query($iFd);
		}
}

	//Stabilita Lab
function P00028($id,$idmodul){
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];


		$sqlc="SELECT formula_process.iFormula_process AS ifo, formula_process.iupb_id , formula_stabilita.iVersi, formula_stabilita.vNo_formula AS formula_stabilita_vNo_formula,
		formula_stabilita.iKesimpulanStabilita AS formula_stabilita_iKesimpulanStabilita,
		formula_stabilita.iApp_formula AS formula_stabilita_iApp_formula,
		plc2_upb.vupb_nomor AS plc2_upb_vupb_nomor, plc2_upb.vupb_nama AS plc2_upb_vupb_nama,  pddetail.formula_process.*
		FROM (pddetail.formula_process)
		INNER JOIN pddetail.formula_process_detail ON formula_process_detail.iFormula_process = formula_process.iFormula_process
		INNER JOIN pddetail.formula_stabilita ON formula_stabilita.iFormula_process = formula_process.iFormula_process
		INNER JOIN plc2.plc2_upb ON plc2_upb.iupb_id = formula_process.iupb_id
		WHERE formula_process_detail.lDeleted = '0'
		AND formula_stabilita.lDeleted = '0'
		AND formula_process.lDeleted = '0'
		AND formula_process.iMaster_flow IN (6,7,8)
		AND formula_process.ij_product=0
		AND formula_process.iupb_id = ".$id."
		GROUP BY iupb_id, iVersi";
		$hellyeah = $this->db_plc0->query($sqlc)->result_array();
		if(empty($hellyeah)){
			//
			if($iNewFlow==1){
				$formula_i = 'FORMULA INJECT';
				$for = "SELECT pu.vkode_surat, pu.vnip_formulator FROM plc2.plc2_upb_formula pu WHERE pu.iupb_id = '".$id."' ORDER BY pu.ifor_id DESC";
				$dt = $this->db_plc0->query($for)->row_array();
				if(!empty($dt['vkode_surat'])){
					$formula_i = $dt['vkode_surat'];
				}



				$this->next_proses($id,6,0,$formula_i,1);//To Stabilita LAB Accelarated
				$this->next_proses($id,7,0,$formula_i,1);//To Stabilita LAB Intermediate
				$this->next_proses($id,8,0,$formula_i,1);//To Stabilita LAB Realtime
				$ret = $vNama_modul." => Insert Berhasil";
			}else{
				$ret = $vNama_modul." => SKIP";
			}
		}else{
			$i = 0 ;
			foreach ($hellyeah as $v) {
				if($v['formula_stabilita_iApp_formula']==0 || empty($V['formula_stabilita_iApp_formula'])){
					$sql_update = 'UPDATE pddetail.formula_stabilita fs JOIN
							pddetail.formula_process fp ON fs.iFormula_process = fp.iFormula_process
							SET fs.iBackSample = "0" ,
							fs.iKesimpulanStabilita = "1" ,
							isubmitformula = "1",
							fs.dupdate = "'.date('Y-m-d H:i:s').'",
							fs.cUpdate = "'.$this->user->gNIP.'",
							fs.iApp_formula = 2,
							fs.cApp_formula = "'.$this->user->gNIP.'",
							fs.dApp_formula =  "'.date('Y-m-d H:i:s').'",
							fs.iFinishProses = 1,
							fs.isKesimpulanOk = 1
							WHERE fp.iupb_id = "'.$id.'"
							AND fp.iMaster_flow IN(6,7,8)
							AND fs.iApp_formula=0';
					$this->db_plc0->query($sql_update);
					$i++;
				}
			}
			if($i>0){
				$ret = ''.$vNama_modul." => Approval Berhasil";
			}else{
				$ret = ''.$vNama_modul." => SKIP";
			}


		}


		return $ret;
}
//Stabilita Pilot
function P00039($id,$idmodul){

	$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
	$mod = $this->db_plc0->query($sql_mod)->row_array();
	$vNama_modul = $mod['vNama_modul'];
	$iNewFlow = $mod['iNewFlow'];


	$sqlc="SELECT formula_process.iFormula_process AS ifo, formula_process.iupb_id , formula_stabilita.iVersi, formula_stabilita.vNo_formula AS formula_stabilita_vNo_formula,
	formula_stabilita.iKesimpulanStabilita AS formula_stabilita_iKesimpulanStabilita,
	formula_stabilita.iApp_formula AS formula_stabilita_iApp_formula,
	plc2_upb.vupb_nomor AS plc2_upb_vupb_nomor, plc2_upb.vupb_nama AS plc2_upb_vupb_nama,  pddetail.formula_process.*
	FROM (pddetail.formula_process)
	INNER JOIN pddetail.formula_process_detail ON formula_process_detail.iFormula_process = formula_process.iFormula_process
	INNER JOIN pddetail.formula_stabilita ON formula_stabilita.iFormula_process = formula_process.iFormula_process
	INNER JOIN plc2.plc2_upb ON plc2_upb.iupb_id = formula_process.iupb_id
	WHERE formula_process_detail.lDeleted = '0'
	AND formula_stabilita.lDeleted = '0'
	AND formula_process.lDeleted = '0'
	AND formula_process.iMaster_flow IN (9,10,11)
	AND formula_process.ij_product=0
	AND formula_process.iupb_id = ".$id."
	GROUP BY iupb_id, iVersi";
	$hellyeah = $this->db_plc0->query($sqlc)->result_array();
	if(empty($hellyeah)){
		//
		if($iNewFlow==1){
			$formula_i = 'FORMULA INJECT';
			$for = "SELECT pu.vkode_surat, pu.vnip_formulator FROM plc2.plc2_upb_formula pu WHERE pu.iupb_id = '".$id."' ORDER BY pu.ifor_id DESC";
			$dt = $this->db_plc0->query($for)->row_array();
			if(!empty($dt['vkode_surat'])){
				$formula_i = $dt['vkode_surat'];
			}

			$this->next_proses($id,9,0,$formula_i,1);//To Stabilita LAB Accelarated
			$this->next_proses($id,10,0,$formula_i,1);//To Stabilita LAB Intermediate
			$this->next_proses($id,11,0,$formula_i,1);//To Stabilita LAB Realtime
			$ret = $vNama_modul." => Insert Berhasil";
		}else{
			$ret = $vNama_modul." => SKIP";
		}
	}else{
		$i2=0;
		foreach ($hellyeah as $v) {
			if($v['formula_stabilita_iApp_formula']==0 || empty($v['formula_stabilita_iApp_formula'])){
				$sql_update = 'UPDATE pddetail.formula_stabilita fs JOIN
						pddetail.formula_process fp ON fs.iFormula_process = fp.iFormula_process
						SET fs.iBackSample = "0" ,
						fs.iKesimpulanStabilita = "1" ,
						isubmitformula = "1",
						fs.dupdate = "'.date('Y-m-d H:i:s').'",
						fs.cUpdate = "'.$this->user->gNIP.'",
						fs.iApp_formula = 2,
						fs.cApp_formula = "'.$this->user->gNIP.'",
						fs.dApp_formula =  "'.date('Y-m-d H:i:s').'",
						fs.iFinishProses = 1,
						fs.isKesimpulanOk = 1
						WHERE fp.iupb_id = "'.$id.'"
						AND fp.iMaster_flow IN(9,10,11)
						AND fs.iApp_formula=0';
				$this->db_plc0->query($sql_update);
				$i2++;
			}
		}

		if($i2>0){
			$ret = ''.$vNama_modul." => Approval Berhasil";
		}else{
			$ret = ''.$vNama_modul." => SKIP";
		}


	}


	return $ret;
}

function P00016($id,$idmodul){
	$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
	$mod = $this->db_plc0->query($sql_mod)->row_array();
	$vNama_modul = $mod['vNama_modul'];
	$iNewFlow = $mod['iNewFlow'];

	$dtForCheck =" SELECT plc2_upb.vupb_nomor AS plc2_upb__vupb_nomor, plc2_upb.vupb_nama AS plc2_upb__vupb_nama,
	plc2.plc2_upb_team.vteam AS team_pd, plc2.plc2_upb_soi_fg.*
		FROM (plc2.plc2_upb_soi_fg)
		INNER JOIN plc2.plc2_upb ON plc2_upb_soi_fg.iupb_id = plc2.plc2_upb.iupb_id
		INNER JOIN plc2.plc2_upb_team ON plc2.plc2_upb.iteampd_id=plc2.plc2_upb_team.iteam_id
		WHERE plc2.plc2_upb_soi_fg.ldeleted =  0
		AND plc2.plc2_upb.ldeleted =  0
		AND plc2.plc2_upb.iKill =  0
		AND plc2_upb.ihold =  0
		AND plc2.plc2_upb.iupb_id = '".$id."'
		GROUP BY isoi_id
		ORDER BY isoi_id desc";
	$dtRessCheck = $this->db_plc0->query($dtForCheck)->result_array();
	if(empty($dtRessCheck)){
		if($iNewFlow==0){

			$dataD['istatus'] = '3';

			$dataD['iupb_id']=$id;
			$dataD['vkode_surat'] = "SOI INJECT";
			$dataD['dmulai_draft'] = date('Y-m-d H:i:s');
			$dataD['dselesai_draft'] = date('Y-m-d H:i:s');
			$dataD['isubmit'] = 1;

			$dataD['vnip_qc'] = $this->user->gNIP;
			$dataD['tapp_qc'] = date('Y-m-d H:i:s');
			$dataD['iappqc'] = 2;

			$dataD['iapppd'] = 2;
			$dataD['vapppd'] = $this->user->gNIP;
			$dataD['dapppd'] = date('Y-m-d H:i:s');

			$dataD['iappqa'] = 2;
			$dataD['vnip_qa'] = $this->user->gNIP;
			$dataD['tapp_qa'] = date('Y-m-d H:i:s');

			$insD = $this -> db -> insert('plc2.plc2_upb_soi_fg', $dataD);
			$ret = ''.$vNama_modul." => Insert Berhasil";

		}else{
			$ret = ''.$vNama_modul." => SKIP";
		}
	}else{
		$i = 0;
		foreach ($dtRessCheck as $v) {
			if($v['iapppd']==0 || $v['iappqa']==0){
				$nn='';
				if($v['vkode_surat']=='' || empty($v['vkode_surat'])){
					$nn = "SOI FG INJECT";
				}
				$this->db_plc0->where('isoi_id', $v['isoi_id']);
	    		$this->db_plc0->update('plc2.plc2_upb_soi_fg', array('istatus'=>3, 'iapppd'=>2, 'vapppd'=>$this->user->gNIP,
	    		'dapppd'=>date('Y-m-d H:i:s'), 'iappqa'=>2, 'vnip_qa'=>$this->user->gNIP,
	    		'tapp_qa'=>date('Y-m-d H:i:s'),'iappqc'=>2, 'vnip_qc'=>$this->user->gNIP, 'vkode_surat'=>$nn,
	    		'tapp_qc'=>date('Y-m-d H:i:s') ));

	    		$i++;
    		}
    	}
    	if($i>0){
    		$ret = ''.$vNama_modul." => Approval Berhasil";
    	}else{
    		$ret = ''.$vNama_modul." => SKIP";
    	}


	}
	return $ret;
}

function P00029($id,$idmodul){
	$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
	$mod = $this->db_plc0->query($sql_mod)->row_array();
	$vNama_modul = $mod['vNama_modul'];
	$iNewFlow = $mod['iNewFlow'];

	$sqc = "SELECT * FROM plc2.plc2_vamoa pv WHERE pv.lDeleted = 0 AND pv.iupb_id = '".$id."'";
	$dtc = $this->db_plc0->query($sqc)->result_array();
	if(empty($dtc)){
		if($iNewFlow==1){
			//If New Flow
			$ret = $vNama_modul.' => SKIP';

		}else{
			//Insert In Here

			$dataD['iupb_id']=$id;
			$dataD['isubmit'] = 1;
			$dataD['cPIC_AD'] = $this->user->gNIP;
			$dataD['dmulai_vamoa'] = date('Y-m-d H:i:s');
			$dataD['dselesai_vamoa'] = date('Y-m-d H:i:s');
			$dataD['isubmit'] = 1;
			$dataD['iapppd'] = 2;
			$dataD['capppd'] = $this->user->gNIP;
			$dataD['dapppd'] = date('Y-m-d H:i:s');
			$dataD['vRemark'] = "INJECT BY ".$this->user->gNIP;
			$dataD['cCreate'] = $this->user->gNIP;
			$dataD['dCreate'] = date('Y-m-d H:i:s');
			$insD = $this -> db -> insert('plc2.plc2_vamoa', $dataD);

			$vamoa_id = $this->db_plc0->insert_id();
			$nomor = "V".str_pad($vamoa_id, 5, "0", STR_PAD_LEFT);
			$sql = "UPDATE plc2.plc2_vamoa SET vnomor_moa = '".$nomor."' WHERE ivalmoa_id='".$vamoa_id."' LIMIT 1";
			$query = $this->db_plc0->query( $sql );

			$ret = $vNama_modul.' => Insert Berhasil';
		}
		//Insert
	}else{
		$i = 0;
		foreach ($dtc as $d) {
			if(empty($d['iapppd']) || $d['iapppd']==0){
				//Update In Here
				$sql = "UPDATE plc2.plc2_vamoa SET iapppd = '2',
				capppd = '".$this->user->gNIP."', dapppd = '".date('Y-m-d H:i:s')."'
				WHERE ivalmoa_id='".$d['ivalmoa_id']."' LIMIT 1";
				$query = $this->db_plc0->query( $sql );

				$i++;
			}
		}
		if($i>0){
			$ret = $vNama_modul.' => Approval Berhasil';
		}else{
			$ret = $vNama_modul.' => SKIP';
		}

	}
	return $ret;
}

function P00024($id,$idmodul){
	$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
	$mod = $this->db_plc0->query($sql_mod)->row_array();
	$vNama_modul = $mod['vNama_modul'];
	$iNewFlow = $mod['iNewFlow'];

	$sqc = "SELECT plc2.plc2_upb_ro_detail.*
			FROM (plc2.plc2_upb_ro_detail)
			INNER JOIN plc2.plc2_upb_request_sample ON plc2.plc2_upb_request_sample.ireq_id = plc2.plc2_upb_ro_detail.ireq_id
			INNER JOIN plc2.plc2_upb_ro ON plc2.plc2_upb_ro.iro_id = plc2.plc2_upb_ro_detail.iro_id
			INNER JOIN plc2.plc2_upb ON plc2.plc2_upb.iupb_id = plc2.plc2_upb_request_sample.iupb_id
			INNER JOIN plc2.plc2_raw_material ON plc2.plc2_raw_material.raw_id = plc2.plc2_upb_ro_detail.raw_id
			WHERE plc2_upb.ihold =  0
			AND plc2_upb_ro_detail.ldeleted =  0
			AND plc2_upb_ro.iclose_po =  1
			AND vrec_jum_pd IS NOT NULL
			AND plc2_upb_request_sample.iTujuan_req =  1
			AND plc2.plc2_upb.ldeleted =  0
			AND plc2.plc2_upb.iKill =  0
			AND plc2_upb.ihold =  0
			AND plc2_upb.iupb_id =  '".$id."'
			AND plc2_upb_ro_detail.iapppd_analisa <> 1
			GROUP BY irodet_id
			ORDER BY irodet_id DESC
			LIMIT 1";
	$dtc = $this->db_plc0->query($sqc)->result_array();
	if(empty($dtc)){
		 $ret = $vNama_modul.' SKIP';
	}else{
		$i = 0;
		foreach ($dtc as $d) {
			 if(empty($d['iapppd_analisa']) || $d['iapppd_analisa']==0){
			 	//Update Approve in Here

			 	$this->db_plc0->where('irodet_id', $d['irodet_id']);
	    		$this->db_plc0->update('plc2.plc2_upb_ro_detail',
	    			array(
	    				  'vnip_apppd_analisa'=>$this->user->gNIP,
	    				  'tapppd_analisa'=>date('Y-m-d H:i:s'),
	    				  'iapppd_analisa'=>2,
	    				  'irelease'=>1,
	    				  'dFinish_analisa'=>date('Y-m-d H:i:s'),
	    				  'dStart_analisa'=>date('Y-m-d H:i:s') ));
	    		$i++;
			 }
		}
		if($i>0){
			$ret = $vNama_modul.' => Approval Berhasil';
		}else{
			$ret = $vNama_modul.' => SKIP';
		}

		$cek_upb = "SELECT * FROM plc2.plc2_upb_request_sample purs
			WHERE purs.ldeleted = 0 AND purs.iTujuan_req in(1,4)
			AND purs.iupb_id IN (".$id.") ";
			$cek = $this->db_plc0->query($cek_upb)->result_array();
			if(!empty($cek)){
				$cek_form = "SELECT * FROM pddetail.formula_process fp WHERE fp.lDeleted = 0 AND
				fp.iMaster_flow = 1 AND fp.iupb_id IN (".$id.")";
				$dcek = $this->db_plc0->query($cek_form)->result_array();
				if(empty($dcek)){

						$cNip = $this->user->gNIP;
						$dUpdate_time = date("Y-m-d H:i:s");

						//Insert Formula Proses
						$sqlto_Back = "INSERT pddetail.formula_process (iupb_id,iMaster_flow,cCreated,dCreate) VALUES
							('".$id."','1','".$cNip."',SYSDATE())";
						$this->db_plc0->query($sqlto_Back);
						$iFormula_process = $this->db_plc0->insert_id();

						//Insert Formula Proses Detail
						$pn = "INSERT INTO pddetail.formula_process_detail(iFormula_process, cPic, iProses_id, is_proses, dStart_time, cCreated, dCreate) VALUES ('".$iFormula_process."','".$cNip."','1','1','".$dUpdate_time."','".$cNip."','".$dUpdate_time."')";
						$this->db_plc0->query($pn);

						//Insert Formula Awal
						$ver = 0;
						$iFd ='INSERT INTO pddetail.formula (iFormula_process,iVersi,dCreate,cCreated)
								VALUES("'.$iFormula_process.'","'.$ver.'","'.$dUpdate_time.'","'.$cNip.'")';
						$this->db_plc0->query($iFd);
				}
			}

	}



	return $ret;
}

function P00025($id,$idmodul){
	$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
	$mod = $this->db_plc0->query($sql_mod)->row_array();
	$vNama_modul = $mod['vNama_modul'];
	$iNewFlow = $mod['iNewFlow'];

	$sqc = 'SELECT ds.`cApproval`, ds.`dApproval`,ds.`iApprove`, ds.`vNoDraft`
					FROM plc2.`draft_soi_bb` ds WHERE
					ds.`lDeleted` = 0 AND
					ds.`iupb_id` = "'.$id.'"';
	$dtc = $this->db_plc0->query($sqc)->result_array();
	if(empty($dtc)){
		 //$ret = $vNama_modul.' => SKIP';
		//insert
		$dataH['cApproval'] = $this->user->gNIP;
		$dataH['iApprove'] = '2';
		$dataH['dApproval'] = date('Y-m-d H:i:s');
		$dataH['vNoDraft'] = 'INJECT by '.$this->user->gNIP;
		$dataH['iupb_id'] = $id;

		if($this ->db-> insert('plc2.draft_soi_bb', $dataH)){
			$ret = $vNama_modul.' => Insert Berhasil';
		}else{
			$ret = $vNama_modul.' => Insert Gagal';
		}

	}else{
		$i=0;
		foreach ($dtc as $d) {
			 if(empty($d['iApprove']) || $d['iApprove']==0){
			 	//Update Approve in Here

			 	$this->db_plc0->where('iupb_id', $id);
	    		$this->db_plc0->update('plc2.draft_soi_bb',
	    			array(
	    				  'cApproval'=>$this->user->gNIP,
	    				  'dApproval'=>date('Y-m-d H:i:s'),
	    				  'iApprove'=>2));
	    		$i++;
			 }
		}
		if($i>0){
			$ret = $vNama_modul.' => Approval Berhasil';
		}else{
			$ret = $vNama_modul.' => SKIP';
		}

	}
	return $ret;
}


function P00021($id,$idmodul){
	//	Uji Mikro BB
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
		$sqlcekAwal1 = '
						select *
						from plc2.plc2_upb_request_sample a
						where a.ldeleted=0
						and a.iupb_id="'.$id.'"
						and a.iapppd = 2
						order by a.ireq_id DESC limit 1
						';
		$dAwal1 = $this->db_plc0->query($sqlcekAwal1)->row_array();
		$sqlcekAwal2 = '
					select *
					from plc2.plc2_upb_po a
					join plc2.plc2_upb_po_detail b on b.ipo_id=a.ipo_id
					where a.ldeleted=0
					and b.ldeleted=0
					and b.ireq_id in ('.$dAwal1['ireq_id'].')
					and a.iapppr = 2
					order by a.ipo_id DESC limit 1
		';



		$dAwal2 = $this->db_plc0->query($sqlcekAwal2)->row_array();

		$sqlcekAwals = '
						select *
						from plc2.plc2_upb_ro a
						join plc2.plc2_upb_ro_detail b on b.iro_id=a.iro_id
						where a.ldeleted=0
						and b.ldeleted=0
						and a.iapppr = 2
						and a.ipo_id in ('.$dAwal2['ipo_id'].')
						and b.iUjiMikro_bb =1


						';
		$dAwals = $this->db_plc0->query($sqlcekAwals)->result_array();
		if (!empty($dAwals)) {
			foreach ($dAwals as $dataAwal) {
				$sqReqDet = 'select * from plc2.plc2_upb_request_sample_detail a where a.ireq_id="'.$dAwal1['ireq_id'].'" and a.raw_id="'.$dataAwal['raw_id'].'" limit 1';
				$dSqReqDet = $this->db_plc0->query($sqReqDet)->row_array();

				$sqlCek = 'select *
							from plc2.uji_mikro_bb a
							where a.lDeleted=0
							and a.ireqdet_id="'.$dSqReqDet['ireqdet_id'].'"
							and a.iApprove_uji <> 1
							order by a.iuji_mikro_bb DESC limit 1';
				$dAwal = $this->db_plc0->query($sqlCek)->row_array();

				if (!empty($dAwal)) {
					/*jika ada , cek approval*/
					$setatus = $dAwal['iApprove_uji'];
					if ($setatus== '0') {
						$dataH=array();
						#field approval
						$dataH['iApprove_uji'] = '2';
						$dataH['cApproval_uji'] = $this->user->gNIP;
						$dataH['dApproval_uji'] = '1970-01-01';
						$dataH['vRemark_uji'] = 'Inject by '.$this->user->gNIP;

						$this -> db -> where('iuji_mikro_bb', $dAwal['iuji_mikro_bb']);
						$updet = $this -> db -> update('plc2.uji_mikro_bb', $dataH);
							if ($updet) {
								$ret = $vNama_modul.' => Approval Berhasil ';
							}else{
								$ret = $vNama_modul.' => Approval Gagal ';
							}



					}else{
						/*jika sudah approve maka skip*/
						$ret = $vNama_modul.' => SKIP';
					}

				}else{
					// inject data
					//jika tidak ada maka insert header dan detail
								$sqReqDet = 'select * from plc2.plc2_upb_request_sample_detail a where a.ireq_id="'.$dAwal1['ireq_id'].'" and a.raw_id="'.$dataAwal['raw_id'].'" limit 1';
								$dSqReqDet = $this->db_plc0->query($sqReqDet)->row_array();


								$dataH=array();
								$dataH['ireqdet_id'] = $dSqReqDet['ireqdet_id'];
								$dataH['iJumlah_terima'] = '1';



								$dataH['vBatch_bb'] = 'Inject By '.$this->user->gNIP;

								$dataH['dMulai_literatur'] = '1970-01-01';
								$dataH['dSelesai_literatur'] = '1970-01-01';
								$dataH['dMulai_uji'] = '1970-01-01';
								$dataH['dSelesai_uji'] = '1970-01-01';

								$dataH['cPic_uji'] = $this->user->gNIP;
								$dataH['iHasil_uji'] = '2';
								$dataH['iUji_spesifik'] = '0';
								$dataH['iSubmit'] = '1';


								$dataH['cCreated'] = $this->user->gNIP;
								$dataH['dCreate'] = date('Y-m-d H:i:s');


								//approval field
								$dataH['iApprove_uji'] = '2';
								$dataH['cApproval_uji'] = $this->user->gNIP;
								$dataH['dApproval_uji'] = '1970-01-01';
								$dataH['vRemark_uji'] = 'Inject by '.$this->user->gNIP;




								$insH = $this -> db -> insert('plc2.uji_mikro_bb', $dataH);
								//$idHead=$this->db_plc0->insert_id();



								if ($insH) {
									$ret = $vNama_modul.' => Insert Berhasil ';


								}else{

									$ret = $vNama_modul.' => Insert Gagal ';


								}

				}

			}
		}else{
			$ret = $vNama_modul.' tidak ada yang butuh Uji Mikro BB => SKIP ';
		}




		return $ret;

}

function P00022($id,$idmodul){
	//	Draft SOI Mikro BB
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
		$sqlcekAwal1 = '
						select *
						from plc2.plc2_upb_request_sample a
						where a.ldeleted=0
						and a.iupb_id="'.$id.'"
						and a.iapppd = 2
						order by a.ireq_id DESC limit 1
						';
		$dAwal1 = $this->db_plc0->query($sqlcekAwal1)->row_array();
		$sqlcekAwal2 = '
					select *
					from plc2.plc2_upb_po a
					join plc2.plc2_upb_po_detail b on b.ipo_id=a.ipo_id
					where a.ldeleted=0
					and b.ldeleted=0
					and b.ireq_id in ('.$dAwal1['ireq_id'].')
					and a.iapppr = 2
					order by a.ipo_id DESC limit 1
		';



		$dAwal2 = $this->db_plc0->query($sqlcekAwal2)->row_array();

		$sqlcekAwals = '
						select *
						from plc2.plc2_upb_ro a
						join plc2.plc2_upb_ro_detail b on b.iro_id=a.iro_id
						where a.ldeleted=0
						and b.ldeleted=0
						and a.iapppr = 2
						and a.ipo_id in ('.$dAwal2['ipo_id'].')
						and b.iUjiMikro_bb =1


						';
		$dAwals = $this->db_plc0->query($sqlcekAwals)->result_array();
		if (!empty($dAwals)) {
			foreach ($dAwals as $dataAwal) {
				$sqReqDet = 'select * from plc2.plc2_upb_request_sample_detail a where a.ireq_id="'.$dAwal1['ireq_id'].'" and a.raw_id="'.$dataAwal['raw_id'].'" limit 1';
				$dSqReqDet = $this->db_plc0->query($sqReqDet)->row_array();

				$sqlCek = 'select *
							from plc2.uji_mikro_bb a
							where a.lDeleted=0
							and a.ireqdet_id="'.$dSqReqDet['ireqdet_id'].'"
							and a.iApprove_uji = 2
							and a.iUji_spesifik = 1
							and a.iApprove_draft <> 1
							order by a.iuji_mikro_bb DESC limit 1';
				$dAwal = $this->db_plc0->query($sqlCek)->row_array();

				if (!empty($dAwal)) {
					/*jika ada , cek approval*/
					$setatus = $dAwal['iApprove_draft'];
					if ($setatus== '0') {
						$dataH=array();


						$dataH['dMulai_draft_soi'] = '1970-01-01';
						$dataH['dSelesai_draft_soi'] = '1970-01-01';
						$dataH['cPic_draft_soi'] = $this->user->gNIP;
						$dataH['iSubmit_draft_soi'] = '1';

						#field approval
						$dataH['iApprove_draft'] = '2';
						$dataH['cApproval_draft'] = $this->user->gNIP;
						$dataH['dApproval_draft'] = '1970-01-01';
						$dataH['vRemark_draft'] = 'Inject by '.$this->user->gNIP;

						$this -> db -> where('iuji_mikro_bb', $dAwal['iuji_mikro_bb']);
						$updet = $this -> db -> update('plc2.uji_mikro_bb', $dataH);
							if ($updet) {
								$ret = $vNama_modul.' => Approval Berhasil ';
							}else{
								$ret = $vNama_modul.'  => Approval Gagal ';
							}



					}else{
						/*jika sudah approve maka skip*/
						$ret = $vNama_modul.'  => SKIP';
					}

				}else{

					$ret = $vNama_modul.' tidak ada yang butuh Draft SOI Mikro BB => SKIP';
				}

			}
		}else{
			$ret = $vNama_modul.' tidak ada yang butuh Uji Mikro BB => SKIP';
		}




		return $ret;

}

function P00023($id,$idmodul){
	//	SOI Mikro BB Final
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
		$sqlcekAwal1 = '
						select *
						from plc2.plc2_upb_request_sample a
						where a.ldeleted=0
						and a.iupb_id="'.$id.'"
						and a.iapppd = 2
						order by a.ireq_id DESC limit 1
						';
		$dAwal1 = $this->db_plc0->query($sqlcekAwal1)->row_array();
		$sqlcekAwal2 = '
					select *
					from plc2.plc2_upb_po a
					join plc2.plc2_upb_po_detail b on b.ipo_id=a.ipo_id
					where a.ldeleted=0
					and b.ldeleted=0
					and b.ireq_id in ('.$dAwal1['ireq_id'].')
					and a.iapppr = 2
					order by a.ipo_id DESC limit 1
		';



		$dAwal2 = $this->db_plc0->query($sqlcekAwal2)->row_array();

		$sqlcekAwals = '
						select *
						from plc2.plc2_upb_ro a
						join plc2.plc2_upb_ro_detail b on b.iro_id=a.iro_id
						where a.ldeleted=0
						and b.ldeleted=0
						and a.iapppr = 2
						and a.ipo_id in ('.$dAwal2['ipo_id'].')
						and b.iUjiMikro_bb =1


						';
		$dAwals = $this->db_plc0->query($sqlcekAwals)->result_array();
		if (!empty($dAwals)) {
			foreach ($dAwals as $dataAwal) {
				$sqReqDet = 'select * from plc2.plc2_upb_request_sample_detail a where a.ireq_id="'.$dAwal1['ireq_id'].'" and a.raw_id="'.$dataAwal['raw_id'].'" limit 1';
				$dSqReqDet = $this->db_plc0->query($sqReqDet)->row_array();

				$sqlCek = 'select *
							from plc2.uji_mikro_bb a
							where a.lDeleted=0
							and a.ireqdet_id="'.$dSqReqDet['ireqdet_id'].'"
							and a.iApprove_uji = 2
							and a.iUji_spesifik = 1
							and a.iApprove_mikro_final <> 1
							order by a.iuji_mikro_bb DESC limit 1';
				$dAwal = $this->db_plc0->query($sqlCek)->row_array();

				if (!empty($dAwal)) {
					/*jika ada , cek approval*/
					$setatus = $dAwal['iApprove_mikro_final'];
					if ($setatus== '0') {
						$dataH=array();



						$dataH['cPic_mikro_final'] = $this->user->gNIP;
						$dataH['iSubmit_mikro_final'] = '1';

						#field approval
						$dataH['iApprove_mikro_final'] = '2';
						$dataH['cApproval_mikro_final'] = $this->user->gNIP;
						$dataH['dApproval_mikro_final'] = '1970-01-01';
						$dataH['vRemark_mikro_final'] = 'Inject by '.$this->user->gNIP;

						$this -> db -> where('iuji_mikro_bb', $dAwal['iuji_mikro_bb']);
						$updet = $this -> db -> update('plc2.uji_mikro_bb', $dataH);
							if ($updet) {
								$ret = $vNama_modul.' => Approval Berhasil ';
							}else{
								$ret = $vNama_modul.' => Approval Gagal ';
							}



					}else{
						/*jika sudah approve maka skip*/
						$ret = $vNama_modul.' => SKIP';
					}

				}else{

					$ret = $vNama_modul.' tidak ada yang butuh SOI Mikro BB Final => SKIP';
				}

			}
		}else{
			$ret = $vNama_modul.' tidak ada yang butuh Uji Mikro BB => SKIP';
		}




		return $ret;

}

function P00009($id,$idmodul){

	$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
	$mod = $this->db_plc0->query($sql_mod)->row_array();
	$vNama_modul = $mod['vNama_modul'];
	$iNewFlow = $mod['iNewFlow'];

	$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
	$dUpb = $this->db_plc0->query($sqUpb)->row_array();

	$ret= '';

	$ck = "SELECT * FROM plc2.plc2_upb_soi_bahanbaku p
		JOIN plc2.plc2_upb b ON p.iupb_id = b.iupb_id
		WHERE p.iappqc IS NOT NULL AND iappqa IS NOT NULL and b.iupb_id= ".$id;
    $ckD = $this->db_plc0->query($ck)->result_array();
    if(empty($ckD)){
    	///INSERT IN HERE

    	$inKon = "SELECT iupb_id
			FROM (plc2.plc2_upb)
			INNER JOIN plc2.plc2_upb_master_kategori_upb ON plc2.plc2_upb.ikategoriupb_id=plc2.plc2_upb_master_kategori_upb.ikategori_id
			WHERE iappdireksi =  2
			AND ihold =  0
			AND iupb_id NOT IN (SELECT f.iupb_id FROM plc2.plc2_upb_soi_bahanbaku f WHERE f.ldeleted=0)
			AND iupb_id IN (
			 	 SELECT a.iupb_id FROM plc2.draft_soi_bb a WHERE a.iApprove=2
			)
			AND iupb_id = '".$id."'";

		if($this->db_plc0->query($inKon)->num_rows()>0){
			$dataH['iupb_id']=$id;
			$dataH['vversi']='00';
			$dataH['vkode_surat']='INJECT';
			$dataH['tberlaku']=date('Y-m-d H:i:s');
			$dataH['vnip_formulator'] = $this->user->gNIP;

			//app pd
			$dataH['iappqa'] = '2';
			$dataH['vnip_qa'] = $this->user->gNIP;
			$dataH['tapp_qa'] = date('Y-m-d H:i:s');

			$dataH['iappqc'] = '2';
			$dataH['vnip_qc'] = $this->user->gNIP;
			$dataH['tapp_qc'] = date('Y-m-d H:i:s');

			if($this -> db -> insert('plc2.plc2_upb_soi_bahanbaku', $dataH)){
				$ret = $vNama_modul.' => Approval Berhasil';
			}else{
				$ret = $vNama_modul.' => Insert Gagal';
			}
		}else{
			$ret = $vNama_modul.' => SKIP';
		}

    }else{
    	///UPDATE IN HERE
    	$i=0;
		foreach ($ckD as $d) {
		     $sq = "UPDATE plc2.plc2_upb_soi_bahanbaku p SET p.iappqa = 2, p.iappqc = 2, p.tapp_qa = '".date('Y-m-d H:i:s')."',
		     		p.tapp_qc = '".date('Y-m-d H:i:s')."', p.vnip_qa = '".$this->user->gNIP."', p.vnip_qc = '".$this->user->gNIP."'
		     		where p.isoibb_id = '".$d['isoibb_id']."'
		     		";
		     		$i++;
		}
		if($i>0){
			$ret = $vNama_modul.' => Approval Berhasil';
		}else{
			$ret = $vNama_modul.' => SKIP';
		}

    }

	return $ret;
}


	/*@Exit*/



/***********************************************************************************************************************************/
/***********************************************************************************************************************************/
/***********************************************************************************************************************************/
/***********************************************************************************************************************************/

	function P00027($id,$idmodul){
		// Uji Mikro FG Untuk Produk Non Steril
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/

		$sqls="select * from plc2.study_literatur_pd p where p.ldeleted=0 and p.iupb_id=".$id;

		$qq=$this->dbset->query($sqls)->row_array();
		if(!empty($qq)){
			if($qq['iuji_mikro']==1){
				$sqlcekAwal = 'SELECT plc2_upb.vupb_nomor AS plc2_upb__vupb_nomor, plc2_upb.vupb_nama AS plc2_upb__vupb_nama,
					plc2_upb.vgenerik AS plc2_upb__vgenerik, formula.vNo_formula AS formula__vNo_formula,
				 #plc2.plc2_upb_team.vteam AS team_qa,
				 /*uji_mikro_fg/uji_mikro_fg.php/output*/plc2.mikro_fg.*
					FROM (plc2.mikro_fg)
					INNER JOIN plc2.plc2_upb_formula ON plc2_upb_formula.ifor_id = mikro_fg.ifor_id
					INNER JOIN plc2.plc2_upb ON plc2.plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id
					INNER JOIN plc2.study_literatur_pd ON plc2.plc2_upb_formula.iupb_id = plc2.study_literatur_pd.iupb_id
					INNER JOIN pddetail.formula_process ON formula_process.iupb_id=plc2_upb_formula.iupb_id
					INNER JOIN pddetail.formula ON formula.iFormula_process=formula_process.iFormula_process
					WHERE mikro_fg.lDeleted = 0
					AND mikro_fg.lDeleted =  0
					AND plc2.plc2_upb.ldeleted =  0
					AND plc2.plc2_upb.iKill =  0
					AND plc2.plc2_upb.itipe_id not in (6)
					AND plc2_upb.ihold =  0
					AND mikro_fg.iappqa_uji!=1
					AND plc2_upb.iupb_id='.$id.' order by plc2_upb_formula.ifor_id DESC';
				$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

				if (!empty($dAwal)) {

					/*jika ada , cek approval*/
					$setatus = $dAwal['iappqa_uji'];
					if ($setatus == 0) {
						//app PD
						$dataH=array();

						#field approval
						$dataH['iappqa_uji'] = '2';
						$dataH['cappqa_uji'] = $this->user->gNIP;
						$dataH['dappqa_uji'] = date('Y-m-d H:i:s');
						$dataH['vremark_uji'] = 'Injct By - '.$this->user->gNIP;
						//$dataH['isubmit']='1';
						$this -> db -> where('imikro_fg_id', $dAwal['imikro_fg_id']);
						$updet = $this -> db -> update('plc2.mikro_fg', $dataH);

						if ($updet) {
							$ret = $vNama_modul.' => Approval Berhasil ';
						}else{
							$ret = $vNama_modul.' => Approval Gagal ';
						}
					}else{
						/*jika sudah approve maka skip*/
						$ret = $vNama_modul.' => SKIP';
					}

				}else{
					// data belum ada
						// cek apakah flow baru
						if($iNewFlow==1){
							//jika flow baru
						}else{
							// insert  bebas, tapi sesuai dengan info di tabel.

							// jika flow lama

									//jika tidak ada maka insert header dan detail
									/*Get Data Ifor ID*/

									$sqlget="SELECT plc2.plc2_upb_formula.*
										FROM (plc2.plc2_upb_formula)
										INNER JOIN plc2.plc2_upb ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id
										INNER JOIN pddetail.formula_process ON formula_process.iupb_id=plc2_upb_formula.iupb_id
										INNER JOIN pddetail.formula ON formula.iFormula_process=formula_process.iFormula_process
										WHERE plc2_upb_formula.ldeleted=0 and plc2_upb_formula.iupb_id=".$id." order by plc2_upb_formula.ifor_id desc";
									$qqq=$this->db_plc0->query($sqlget);
									if($qqq->num_rows()>=1){
										$ddd=$qqq->row_array();
										$dataH=array();

										$dataH['ifor_id']=$ddd['ifor_id'];
										$dataH['dmulai_uji']='1970-01-01';
										$dataH['dselesai_uji']='1970-01-01';
										$dataH['istatus']='INJECT By '.$this->user->gNIP;
										$dataH['istatus']='0';

										//app pd
										$dataH['iappqa_uji'] = '2';
										$dataH['cappqa_uji'] = $this->user->gNIP;
										$dataH['dappqa_uji'] = date('Y-m-d H:i:s');
										$dataH['vremark_uji'] = 'Injct By - '.$this->user->gNIP;

										$insH = $this -> db -> insert('plc2.mikro_fg', $dataH);
										//$idHead=$this->db_plc0->insert_id();

										if ($insH) {
											$ret = $vNama_modul.' => Insert Berhasil ';
										}else{

											$ret = $vNama_modul.' => Insert Gagal ';
										}
									}else{
										$ret = $vNama_modul.' Nomor Formula Tidak Ada => SKIP';
									}

						}
				}
			}else{
				$ret = $vNama_modul.' => SKIP - Khusus Produk Steril ';
			}
	   	}else{
	   		$ret = $vNama_modul.' Study Literature Not Found Data => SKIP';
	   	}
		return $ret;

	}


	function P00030($id,$idmodul){
		// SOI Mikro FG
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/

		$sqls="select * from plc2.study_literatur_pd p where p.ldeleted=0 and p.iupb_id=".$id;

		$qq=$this->dbset->query($sqls)->row_array();
		if(!empty($qq)){
			if($qq['iuji_mikro']==1){
				$sqlcekAwal = 'SELECT plc2_upb.vupb_nomor AS plc2_upb__vupb_nomor, plc2_upb.vupb_nama AS plc2_upb__vupb_nama, plc2_upb.vgenerik AS plc2_upb__vgenerik, formula.vNo_formula AS formula__vNo_formula
					#, plc2.plc2_upb_team.vteam AS team_qa
					, /*uji_mikro_fg/uji_mikro_fg.php/output*/plc2.mikro_fg.*
					FROM (plc2.mikro_fg)
					INNER JOIN plc2.plc2_upb_formula ON plc2_upb_formula.ifor_id = mikro_fg.ifor_id
					INNER JOIN plc2.plc2_upb ON plc2.plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id
					INNER JOIN plc2.study_literatur_pd ON plc2.plc2_upb_formula.iupb_id = plc2.study_literatur_pd.iupb_id
					INNER JOIN pddetail.formula_process ON formula_process.iupb_id=plc2_upb_formula.iupb_id
					INNER JOIN pddetail.formula ON formula.iFormula_process=formula_process.iFormula_process
					WHERE mikro_fg.lDeleted = 0
					AND mikro_fg.lDeleted =  0
					AND plc2.plc2_upb.ldeleted =  0
					AND plc2.plc2_upb.iKill =  0
					AND plc2.plc2_upb.itipe_id not in (6)
					AND plc2_upb.ihold =  0
					AND mikro_fg.iappqa_uji!=1
					AND plc2_upb.iupb_id='.$id.' order by plc2_upb_formula.ifor_id DESC';
				$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

				if (!empty($dAwal)) {

					/*jika ada , cek approval*/
					$setatus = $dAwal['iappqa_soi'];
					if ($setatus == 0) {
						//app PD
						$dataH=array();

						#field approval
						$dataH['iappqa_soi'] = '2';
						$dataH['cappqa_soi'] = $this->user->gNIP;
						$dataH['dappqa_soi'] = date('Y-m-d H:i:s');
						$dataH['vremark_soi'] = 'Inject By - '.$this->user->gNIP;
						//$dataH['isubmit']='1';
						$this -> db -> where('imikro_fg_id', $dAwal['imikro_fg_id']);
						$updet = $this -> db -> update('plc2.mikro_fg', $dataH);

						if ($updet) {
							$ret = $vNama_modul.' => Approval Berhasil ';
						}else{
							$ret = $vNama_modul.' => Approval Gagal ';
						}
					}else{
						/*jika sudah approve maka skip*/
						$ret = $vNama_modul.' => SKIP';
					}

				}else{
					// data belum ada
						// cek apakah flow baru
						if($iNewFlow==1){
							//jika flow baru
						}else{
							// insert  bebas, tapi sesuai dengan info di tabel.

							// jika flow lama

							$ret = $vNama_modul.' - Uji Mikro Not Found => SKIP  ';
						}
				}
			}else{
				$ret = $vNama_modul.'  - Khusus Produk Steril => SKIP ';
			}
	   	}else{
	   		$ret = $vNama_modul.' Study Literature Not Found Data => SKIP ';
	   	}
		return $ret;

	}

	function P00031($id,$idmodul){
		// Approval KSK
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
			$sqlcekAwal = 'SELECT plc2.plc2_upb_ro_detail.*
					FROM (plc2.plc2_upb_ro_detail)
					INNER JOIN plc2.plc2_raw_material ON plc2.plc2_raw_material.raw_id = plc2.plc2_upb_ro_detail.raw_id
					INNER JOIN plc2.plc2_upb_ro ON plc2.plc2_upb_ro.iro_id = plc2.plc2_upb_ro_detail.iro_id
					INNER JOIN plc2.plc2_upb_po ON plc2.plc2_upb_po.ipo_id = plc2.plc2_upb_ro_detail.ipo_id
					INNER JOIN plc2.plc2_upb_request_sample ON plc2.plc2_upb_request_sample.ireq_id = plc2.plc2_upb_ro_detail.ireq_id
					INNER JOIN plc2.plc2_upb ON plc2.plc2_upb.iupb_id = plc2.plc2_upb_request_sample.iupb_id
					WHERE plc2_upb.iupb_id in(
					 select fp.iupb_id
					 from pddetail.formula_stabilita f
					 join pddetail.formula_process fp on fp.iFormula_process=f.iFormula_process
					 where f.lDeleted=0
					 and fp.lDeleted=0
					 and f.iKesimpulanStabilita=1
					 and f.iApp_formula=2
					 and fp.iFormula_process in (select a.iFormula_process
					 from pddetail.formula_process a where a.lDeleted=0
					 and a.iMaster_flow in (6,7,8))
					 )

					AND plc2_upb.iupb_id in (select up.iupb_id from plc2.plc2_upb up
					 inner join plc2.study_literatur_pd st on up.iupb_id=st.iupb_id
					 where
					 (case when st.iuji_mikro=1 then
					 (case when st.ijenis_sediaan=1
					 then up.iupb_id in (select fo.iupb_id from plc2.mikro_fg mi inner join plc2.plc2_upb_formula fo on fo.ifor_id=mi.ifor_id where mi.iappqa_soi=2 and mi.lDeleted=0 and fo.ldeleted=0) AND up.iupb_id in (select sp.iupb_id from plc2.plc2_upb_soi_fg sp where sp.ldeleted=0 and sp.iapppd=2 and sp.iappqa=2) AND up.iupb_id in (select mo.iupb_id from plc2.plc2_vamoa mo where mo.lDeleted=0 and mo.iapppd=2)
					 else
					 up.iupb_id in (select sp.iupb_id from plc2.plc2_upb_soi_fg sp where sp.ldeleted=0 and sp.iapppd=2 and sp.iappqa=2) AND up.iupb_id in (select mo.iupb_id from plc2.plc2_vamoa mo where mo.lDeleted=0 and mo.iapppd=2)
					 end)
					 else up.ldeleted=0
					 end)
					 )
					AND plc2_upb_ro_detail.ldeleted =  0
					AND plc2.plc2_upb.ldeleted =  0
					AND plc2.plc2_upb.iKill =  0
					AND plc2.plc2_upb.itipe_id not in (6)
					AND plc2_upb.ihold =  0
					AND plc2_upb_ro_detail.iappqa_ksk!=1
					AND plc2_upb.iupb_id='.$id;
			$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

			if (!empty($dAwal)) {

				/*jika ada , cek approval*/
				$setatus = $dAwal['iappqa_ksk'];
				if ($setatus == 0) {
					//app PD
					$dr=$this->dbset->query($sqlcekAwal)->result_array();
					foreach ($dr as $kv => $vv) {

						$dataH=array();
						#field approval
						$dataH['iappqa_ksk'] = '2';
						$dataH['vnip_appqa_ksk'] = $this->user->gNIP;
						$dataH['tappqa_ksk'] = date('Y-m-d H:i:s');

						$this -> db -> where('irodet_id', $vv['irodet_id']);
						$updet = $this -> db -> update('plc2.plc2_upb_ro_detail', $dataH);
						if ($updet) {
							$ret = $vNama_modul.' => Approval Berhasil ';
						}else{
							$ret = $vNama_modul.' => Approval Gagal ';
						}
					}
				}else{
					/*jika sudah approve maka skip*/
					$ret = $vNama_modul.' => SKIP';
				}

			}else{
				// data belum ada
					// cek apakah flow baru
					if($iNewFlow==1){
						//jika flow baru
					}else{
						// insert  bebas, tapi sesuai dengan info di tabel.

						// jika flow lama

						$ret = $vNama_modul.'  Ro Details Not Found => SKIP ';
					}
			}
		return $ret;

	}

	function P00032($id,$idmodul){
		// Best Formula
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
			$sqlcekAwal = 'SELECT plc2_upb_formula.*
				FROM (plc2.plc2_upb)
				INNER JOIN plc2.plc2_upb_formula ON plc2_upb_formula.iupb_id=plc2_upb.iupb_id
				WHERE plc2_upb.ldeleted =  0
				AND plc2_upb.iappdireksi =  2
				AND plc2.plc2_upb.ldeleted =  0
				AND plc2.plc2_upb.iKill =  0
				AND plc2.plc2_upb.itipe_id not in (6)
				AND plc2_upb.ihold =  0
				AND plc2_upb.iupb_id in(
				 select fp.iupb_id
				 from pddetail.formula_stabilita f
				 join pddetail.formula_process fp on fp.iFormula_process=f.iFormula_process
				 where f.lDeleted=0
				 and fp.lDeleted=0
				 and f.iKesimpulanStabilita=1
				 and f.iApp_formula=2
				 and fp.iFormula_process in (select a.iFormula_process
				 from pddetail.formula_process a where a.lDeleted=0
				 and a.iMaster_flow in (6,7,8))
				 )

				AND plc2_upb.iupb_id in (select up.iupb_id from plc2.plc2_upb up
				 inner join plc2.study_literatur_pd st on up.iupb_id=st.iupb_id
				 where
				 (CASE WHEN st.iuji_mikro=1 THEN
				 (case when st.ijenis_sediaan=1
				 then up.iupb_id in (select fo.iupb_id from plc2.mikro_fg mi inner join plc2.plc2_upb_formula fo on fo.ifor_id=mi.ifor_id where mi.iappqa_soi=2 and mi.lDeleted=0 and fo.ldeleted=0) AND up.iupb_id in (select sp.iupb_id from plc2.plc2_upb_soi_fg sp where sp.ldeleted=0 and sp.iapppd=2 and sp.iappqa=2) AND up.iupb_id in (select mo.iupb_id from plc2.plc2_vamoa mo where mo.lDeleted=0 and mo.iapppd=2)
				 else
				 up.iupb_id in (select sp.iupb_id from plc2.plc2_upb_soi_fg sp where sp.ldeleted=0 and sp.iapppd=2 and sp.iappqa=2) AND up.iupb_id in (select mo.iupb_id from plc2.plc2_vamoa mo where mo.lDeleted=0 and mo.iapppd=2)
				 END)
				 ELSE st.ldeleted=0
				 END)
				 )
				AND plc2_upb_formula.ibest!=1
				AND plc2_upb.iupb_id='.$id.' order by plc2_upb_formula.ifor_id DESC';
			$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

			if (!empty($dAwal)) {

				/*jika ada , cek approval*/
				$setatus = $dAwal['ibest'];
				if ($setatus == 0) {
					//app PD
					$dr=$this->dbset->query($sqlcekAwal)->result_array();
					foreach ($dr as $kv => $vv) {

						$dataH=array();
						#field approval
						$dataH['ibest'] = '2';
						$dataH['isubmit_best'] = '1';
						$dataH['vbest_nip_apppd'] = $this->user->gNIP;
						$dataH['tbest_apppd'] = date('Y-m-d H:i:s');

						$this -> db -> where('ifor_id', $vv['ifor_id']);
						$updet = $this -> db -> update('plc2.plc2_upb_formula', $dataH);
						if ($updet) {
							$ret = $vNama_modul.' => Approval Berhasil ';
						}else{
							$ret = $vNama_modul.' => Approval Gagal ';
						}
					}
				}else{
					/*jika sudah approve maka skip*/
					$ret = $vNama_modul.' => SKIP';
				}

			}else{
				// data belum ada
					// cek apakah flow baru
					if($iNewFlow==1){
						//jika flow baru
					}else{
						// insert  bebas, tapi sesuai dengan info di tabel.

						// jika flow lama

						$ret = $vNama_modul.' Ro Details Not Found => SKIP  ';
					}
			}
			//echo $ret;
		return $ret;

	}

	function P00033($id,$idmodul){
		// Basic Formula
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
			$sqlcekAwal = 'SELECT plc2.plc2_upb_formula.*
			FROM (plc2.plc2_upb_formula)
			INNER JOIN plc2.plc2_upb ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id
			INNER JOIN pddetail.formula_process ON formula_process.iupb_id=plc2_upb_formula.iupb_id
			INNER JOIN pddetail.formula ON formula.iFormula_process=formula_process.iFormula_process
			WHERE plc2_upb_formula.ibest =  2
			AND plc2_upb_formula.vbest_nip_apppd is not null
			AND plc2_upb.ihold =  0
			AND plc2_upb_formula.ldeleted =  0
			AND plc2_upb.iupb_id in (SELECT plc2_upb.iupb_id
			 FROM (plc2.plc2_upb_ro_detail)
			 INNER JOIN plc2.plc2_upb_ro ON plc2.plc2_upb_ro.iro_id = plc2.plc2_upb_ro_detail.iro_id
			 INNER JOIN plc2.plc2_upb_po ON plc2.plc2_upb_po.ipo_id = plc2.plc2_upb_ro_detail.ipo_id
			 INNER JOIN plc2.plc2_upb_request_sample ON plc2.plc2_upb_request_sample.ireq_id = plc2.plc2_upb_ro_detail.ireq_id
			 INNER JOIN plc2.plc2_upb ON plc2.plc2_upb.iupb_id = plc2.plc2_upb_request_sample.iupb_id
			 WHERE plc2.plc2_upb.iupb_id in (
			 select fp.iupb_id
			 from pddetail.formula_stabilita f
			 join pddetail.formula_process fp on fp.iFormula_process=f.iFormula_process
			 where f.lDeleted=0
			 and fp.lDeleted=0
			 and f.iKesimpulanStabilita=1
			 and f.iApp_formula=2
			 and fp.iFormula_process in (select a.iFormula_process
			 from pddetail.formula_process a where a.lDeleted=0
			 and a.iMaster_flow in (6,7,8))
			 )

			 AND plc2_upb_ro_detail.ldeleted = 0
			 AND plc2_upb_ro.iclose_po = 1
			 AND plc2_upb.ihold = 0
			 AND plc2_upb_ro_detail.iappqa_ksk=2
			 GROUP BY plc2_upb.iupb_id)
			AND plc2.plc2_upb.ldeleted =  0
			AND plc2.plc2_upb.iKill =  0
			AND plc2.plc2_upb.itipe_id not in (6)
			AND plc2_upb.ihold = 0
			AND plc2_upb_formula.iapppd_basic!=1
			AND plc2_upb.iupb_id = '.$id.' order by plc2_upb_formula.ifor_id DESC';
			$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

			if (!empty($dAwal)) {

				/*jika ada , cek approval*/
				$setatus = $dAwal['iapppd_basic'];
				if ($setatus == 0) {
					//app PD
					$dr=$this->dbset->query($sqlcekAwal)->result_array();
					foreach ($dr as $kv => $vv) {

						$dataH=array();
						#field approval
						$dataH['iapp_basic'] = '2';
						$dataH['iapppd_basic'] = '2';
						$dataH['isubmit_basic'] = '1';
						$dataH['vbasic_nip_apppd'] = $this->user->gNIP;
						$dataH['tbasic_apppd'] = date('Y-m-d H:i:s');

						$this -> db -> where('ifor_id', $vv['ifor_id']);
						$updet = $this -> db -> update('plc2.plc2_upb_formula', $dataH);
						if ($updet) {
							$ret = $vNama_modul.' => Approval Berhasil ';
						}else{
							$ret = $vNama_modul.' => Approval Gagal ';
						}
					}
				}else{
					/*jika sudah approve maka skip*/
					$ret = $vNama_modul.' => SKIP';
				}

			}else{
				// data belum ada
					// cek apakah flow baru
					if($iNewFlow==1){
						//jika flow baru
					}else{
						// insert  bebas, tapi sesuai dengan info di tabel.

						// jika flow lama

						$dataH=array();
						#field approval
						$dataH['iapp_basic'] = '2';
						$dataH['iapppd_basic'] = '2';
						$dataH['isubmit_basic'] = '1';
						$dataH['vbasic_nip_apppd'] = $this->user->gNIP;
						$dataH['tbasic_apppd'] = date('Y-m-d H:i:s');

						$this -> db -> where('iupb_id', $id);
						$updet = $this -> db -> update('plc2.plc2_upb_formula', $dataH);
						if ($updet) {
							$ret = $vNama_modul.' => Approval Berhasil ';
						}else{
							$ret = $vNama_modul.' => Approval Gagal ';
						}
					}
			}
		return $ret;

	}
	function P00014($id,$idmodul){
		// Produksi Pilot
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
			$sqlcekAwal = 'SELECT plc2.plc2_upb_formula.*,plc2_upb_prodpilot.iapppd_pp,plc2_upb_prodpilot.iprodpilot_id
				FROM (plc2.plc2_upb_formula)
				INNER JOIN plc2.plc2_upb ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id
				LEFT JOIN plc2.plc2_upb_prodpilot ON plc2_upb_prodpilot.ifor_id = plc2_upb_formula.ifor_id
				INNER JOIN pddetail.formula_process ON formula_process.iupb_id=plc2_upb_formula.iupb_id
				INNER JOIN pddetail.formula ON formula.iFormula_process=formula_process.iFormula_process
				WHERE plc2_upb_formula.ldeleted =  0
				AND (if(plc2_upb_prodpilot.iprodpilot_id is not null , plc2_upb_prodpilot.ldeleted = 0 ,plc2_upb_formula.ldeleted = 0 ) )
				AND plc2.plc2_upb_formula.ibest =  2
				AND plc2_upb_formula.ifor_id in (select mb.ifor_id from plc2.plc2_upb_buat_mbr mb where mb.iapppd_bm=2)
				AND plc2.plc2_upb.ldeleted =  0
				AND plc2.plc2_upb.iKill =  0
				AND plc2.plc2_upb.itipe_id not in (6)
				AND plc2_upb.ihold =  0
				AND plc2_upb.iupb_id in (
				 select a.iupb_id from plc2.protokol_valpro a
				 where a.iappqa =2
				 and a.lDeleted=0
				 )
				AND if(plc2.plc2_upb_formula.iwithbasic=1,
				 (plc2.plc2_upb.iupb_id in (
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
				 and b.iTujuan_req=3
				 )
				 )

				 ,plc2.plc2_upb_formula.ldeleted=0
				 )
				AND plc2_upb_prodpilot.iapppd_pp!=1
				AND plc2_upb_formula.iupb_id = '.$id.' order by plc2_upb_formula.ifor_id DESC';
			$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

			if (!empty($dAwal)) {

				/*jika ada , cek approval*/
				$setatus = $dAwal['iapppd_pp'];
				if ($setatus == 0) {
					//app PD
					$dr=$this->dbset->query($sqlcekAwal)->result_array();
					foreach ($dr as $kv => $vv) {

						$dataH=array();
						#field approval
						$dataH['iapppd_pp'] = '2';
						$dataH['vnip_apppd_pp'] = $this->user->gNIP;
						$dataH['tapppd_pp'] = date('Y-m-d H:i:s');

						$this -> db -> where('iprodpilot_id', $vv['iprodpilot_id']);
						$updet = $this -> db -> update('plc2.plc2_upb_prodpilot', $dataH);
						if ($updet) {
							$ret = $vNama_modul.' => Approval Berhasil ';
						}else{
							$ret = $vNama_modul.' => Approval Gagal ';
						}
					}
				}else{
					/*jika sudah approve maka skip*/
					$ret = $vNama_modul.' => SKIP';
				}

			}else{
				// data belum ada
					// cek apakah flow baru
					if($iNewFlow==1){
						//jika flow baru
					}else{
						// insert  bebas, tapi sesuai dengan info di tabel.

						// jika flow lama

						$sqlsel = 'SELECT plc2.plc2_upb_formula.*
							FROM (plc2.plc2_upb_formula)
							INNER JOIN plc2.plc2_upb ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id
							INNER JOIN pddetail.formula_process ON formula_process.iupb_id=plc2_upb_formula.iupb_id
							INNER JOIN pddetail.formula ON formula.iFormula_process=formula_process.iFormula_process
							WHERE plc2_upb_formula.ldeleted =  0
							AND plc2.plc2_upb_formula.ibest =  2
							AND plc2_upb_formula.ifor_id in (select mb.ifor_id from plc2.plc2_upb_buat_mbr mb where mb.iapppd_bm=2)
							AND plc2.plc2_upb.ldeleted =  0
							AND plc2.plc2_upb.iKill =  0
							AND plc2.plc2_upb.itipe_id not in (6)
							AND plc2_upb.ihold =  0
							AND plc2_upb.iupb_id in (
							 select a.iupb_id from plc2.protokol_valpro a
							 where a.iappqa =2
							 and a.lDeleted=0
							 )
							AND if(plc2.plc2_upb_formula.iwithbasic=1,
							 (plc2.plc2_upb.iupb_id in (
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
							 and b.iTujuan_req=3
							 )
							 )

							 ,plc2.plc2_upb_formula.ldeleted=0
							 )
							AND plc2_upb_formula.iupb_id = '.$id.' order by plc2_upb_formula.ifor_id DESC limit 1';
						if($this->db_plc0->query($sqlsel)->num_rows>=1){
							$dsel = $this->db_plc0->query($sqlsel)->row_array();

							$dataI=array();
							#field approval
							$dataI['ifor_id'] = $dsel['ifor_id'];
							$dataI['dtglmulai_prod'] = '1970-01-01';
							$dataI['dtglselesai_prod'] = '1970-01-01';
							$dataI['iapppd_pp'] = '2';
							$dataI['vnip_apppd_pp'] = $this->user->gNIP;
							$dataI['tapppd_pp'] = date('Y-m-d H:i:s');

							$updet = $this -> db -> insert('plc2.plc2_upb_prodpilot', $dataI);
							if ($updet) {
								$ret = $vNama_modul.' => Approval Berhasil ';
							}else{
								$ret = $vNama_modul.' => Approval Gagal ';
							}
						}else{
							$ret = $vNama_modul.' Formula Tidak Di Temukan! => SKIP ';
						}
					}
			}
		return $ret;

	}

	function P00034($id,$idmodul){
		// Pembuatan MBR
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
		$sqlcekAwal = 'SELECT plc2_upb_buat_mbr.*
				FROM plc2.plc2_upb_formula
				INNER JOIN plc2.plc2_upb ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id
				INNER JOIN plc2.plc2_upb_buat_mbr ON plc2_upb_buat_mbr.ifor_id = plc2_upb_formula.ifor_id
				INNER JOIN pddetail.formula_process ON formula_process.iupb_id=plc2_upb_formula.iupb_id
				INNER JOIN pddetail.formula ON formula.iFormula_process=formula_process.iFormula_process
				WHERE plc2_upb_buat_mbr.iapppd_bm!=1 and plc2_upb_buat_mbr.ldeleted=0 and plc2_upb.iupb_id='.$id." ORDER BY plc2_upb_formula.ifor_id DESC";
		$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

		if (!empty($dAwal)) {

			/*jika ada , cek approval*/
			$setatus = $dAwal['iapppd_bm'];
			if ($setatus == 0) {
				//app PD
				$dataH=array();

				#field approval
				$dataH['iapppd_bm'] = '2';
				$dataH['vnip_apppd_bm'] = $this->user->gNIP;
				$dataH['tapppd_bm'] = date('Y-m-d H:i:s');
				$dataH['isubmit']='1';
				$this -> db -> where('ibuatmbr_id', $dAwal['ibuatmbr_id']);
				$updet = $this -> db -> update('plc2.plc2_upb_buat_mbr', $dataH);

				if ($updet) {
					$ret = $vNama_modul.' => Approval Berhasil ';
				}else{
					$ret = $vNama_modul.' => Approval Gagal ';
				}
			}else{
				/*jika sudah approve maka skip*/
				$ret = $vNama_modul.' => SKIP';
			}

		}else{
			// data belum ada
				// cek apakah flow baru
				if($iNewFlow==1){
					//jika flow baru
				}else{
					// insert  bebas, tapi sesuai dengan info di tabel.
						/*
							ketentuan
							1. status approval sesuai dengan user yang melakukan inject
							2. tgl Approval I - IV = 1970-01-01
							3. tgl Pembuat MBR I - IV = 1970-01-01
							4. No Batch = 'Null'

						*/


					// jika flow lama

							//jika tidak ada maka insert header dan detail
							/*Get Data Ifor ID*/

							$sqlget="SELECT plc2.plc2_upb_formula.*
								FROM (plc2.plc2_upb_formula)
								INNER JOIN plc2.plc2_upb ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id
								INNER JOIN pddetail.formula_process ON formula_process.iupb_id=plc2_upb_formula.iupb_id
								INNER JOIN pddetail.formula ON formula.iFormula_process=formula_process.iFormula_process
								WHERE plc2_upb_formula.ldeleted=0 and plc2_upb_formula.iupb_id=".$id."
								order by plc2_upb_formula.ifor_id desc limit 1";
							$qqq=$this->db_plc0->query($sqlget);
							if($qqq->num_rows()>=1){
								$ddd=$qqq->row_array();
								$dataH=array();

								$dataH['ifor_id']=$ddd['ifor_id'];
								$dataH['dbuat_mbr']='1970-01-01';
								$dataH['dtgl_appr_1']='1970-01-01';
								$dataH['dtgl_appr_2']='1970-01-01';
								$dataH['dtgl_appr_3']='1970-01-01';
								$dataH['no_mbr']='NULL';
								$dataH['isubmit']='1';

								//app pd
								$dataH['iapppd_bm'] = '2';
								$dataH['vnip_apppd_bm'] = $this->user->gNIP;
								$dataH['tapppd_bm'] = date('Y-m-d H:i:s');

								$insH = $this -> db -> insert('plc2.plc2_upb_buat_mbr', $dataH);
								//$idHead=$this->db_plc0->insert_id();

								if ($insH) {
									$ret = $vNama_modul.' => Insert Berhasil ';
								}else{

									$ret = $vNama_modul.' => Insert Gagal ';
								}
							}else{
								$ret = $vNama_modul.' Nomor Formula Tidak Ada => SKIP';
							}

				}
		}

		return $ret;

	}


function P00035($id,$idmodul){
			// Protokol Valpro
			$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
			$mod = $this->db_plc0->query($sql_mod)->row_array();
			$vNama_modul = $mod['vNama_modul'];
			$iNewFlow = $mod['iNewFlow'];

			$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
			$dUpb = $this->db_plc0->query($sqUpb)->row_array();

			$ret= '';

			/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
			$sqlcekAwal = 'select * from plc2.protokol_valpro a
							where a.ldeleted=0
							and a.iappqa!=1
							and a.iupb_id="'.$id.'"
							';
			$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

			if (!empty($dAwal)) {

				/*jika ada , cek approval*/
				$setatus = $dAwal['iappqa'];
				if ($setatus == 0) {
					//app QA
								$dataH=array();
								$dataH['iappqa'] = '2';
								$dataH['vappqa'] = $this->user->gNIP;
								$dataH['dappqa'] = date('Y-m-d H:i:s');
								$dataH['cUpdate'] = $this->user->gNIP;
								$dataH['dupdate'] = date('Y-m-d H:i:s');
								$dataH['isubmit'] = '1';
								$dataH['vRemark'] = 'Inject By '.$this->user->gNIP;






					$this -> db -> where('protokol_valpro', $dAwal['iprotokol_id']);
					$updet = $this -> db -> update('plc2.protokol_valpro', $dataH);

					if ($updet) {
						$ret = $vNama_modul.'  => Approval Berhasil ';
					}else{
						$ret = $vNama_modul.'  => Approval Gagal ';
					}
				}else{
					/*jika sudah approve maka skip*/
					$ret = $vNama_modul.'  => SKIP';
				}

			}else{
				// data belum ada
					// cek apakah flow baru
					if($iNewFlow==1){
						//jika flow baru
					}else{
						// insert  bebas, tapi sesuai dengan info di tabel.
						/*
							ketentuan
							1. status approval sesuai dengan user yang melakukan inject
							2. PIC sesuai user yang melakukan inject
							3. Nomor Batch = 0
							4. tgl mulai & selesai 1970-01-01

						*/


						// jika flow lama

								//jika tidak ada maka insert header dan detail
								$dataH=array();
								$dataH['iupb_id'] = $id;
								$dataH['vPICqa'] = $this->user->gNIP;
								$dataH['dmulai_protokol'] = '1970-01-01';
								$dataH['dselesai_protokol'] = '1970-01-01';
								$dataH['ibatch'] = '0';
								$dataH['isubmit'] = '1';

								$dataH['cCreate'] = $this->user->gNIP;
								$dataH['dCreate'] = date('Y-m-d H:i:s');


								//app QA
								$dataH['iappqa'] = '2';
								$dataH['vappqa'] = $this->user->gNIP;
								$dataH['dappqa'] = date('Y-m-d H:i:s');
								$dataH['vRemark'] = 'Inject By '.$this->user->gNIP;




								$insH = $this -> db -> insert('plc2.protokol_valpro', $dataH);
								//$idHead=$this->db_plc0->insert_id();



								if ($insH) {
									$ret = $vNama_modul.'  => Insert  Berhasil ';


								}else{

									$ret = $vNama_modul.'  => Insert  Gagal ';


								}

					}
			}

			return $ret;

	}

	function P00037($id,$idmodul){
			// Laporan Pengembangan Produk
			$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
			$mod = $this->db_plc0->query($sql_mod)->row_array();
			$vNama_modul = $mod['vNama_modul'];
			$iNewFlow = $mod['iNewFlow'];

			$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
			$dUpb = $this->db_plc0->query($sqUpb)->row_array();

			$ret= '';

			/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
			$sqlcekAwal = 'select * from plc2.plc2_upb_formula a
							where a.ldeleted=0
							and a.iapppd_lpp!=1
							and a.iupb_id="'.$id.'"
							 order by a.ifor_id DESC
							';
			$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

			if (!empty($dAwal)) {

				/*jika ada , cek approval*/
				$setatus = $dAwal['iapppd_lpp'];
				if ($setatus == 0) {
					//app PD
					$dataH=array();
					$dataH['iapppd_lpp'] = '2';
					$dataH['capppd_lpp'] = $this->user->gNIP;
					$dataH['dapppd_lpp'] = date('Y-m-d H:i:s');
					$dataH['isubmit_lpp'] = '1';
					$dataH['vRemark_lpp'] = 'Inject By '.$this->user->gNIP;

					$this -> db -> where('ifor_id', $dAwal['ifor_id']);
					$updet = $this -> db -> update('plc2.plc2_upb_formula', $dataH);

					if ($updet) {
						$ret = $vNama_modul.'  => Approval Berhasil ';
					}else{
						$ret = $vNama_modul.'  => Approval Gagal ';
					}
				}else{
					/*jika sudah approve maka skip*/
					$ret = $vNama_modul.'  => SKIP';
				}

			}else{
				// data belum ada
					// cek apakah flow baru
					if($iNewFlow==1){
						//jika flow baru
					}else{
						$ret= $vNama_modul.' Not Found Formula  => SKIP';
					}
			}

			return $ret;

	}

	function P00038($id,$idmodul){
			// LPO
			$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
			$mod = $this->db_plc0->query($sql_mod)->row_array();
			$vNama_modul = $mod['vNama_modul'];
			$iNewFlow = $mod['iNewFlow'];

			$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
			$dUpb = $this->db_plc0->query($sqUpb)->row_array();

			$ret= '';

			/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
			$sqlcekAwal = 'select * from plc2.lpo a
							where a.ldeleted=0
							and a.iapppd!=1
							and a.iupb_id="'.$id.'"
							 order by a.ilpo_id DESC
							';
			$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

			if (!empty($dAwal)) {

				/*jika ada , cek approval*/
				$setatus = $dAwal['iapppd'];
				if ($setatus == 0) {
					//app PD
					$dataH=array();
					$dataH['iapppd'] = '2';
					$dataH['vapppd'] = $this->user->gNIP;
					$dataH['dapppd'] = date('Y-m-d H:i:s');
					$dataH['isubmit'] = '1';
					$dataH['vRemark'] = 'Inject By '.$this->user->gNIP;

					$this -> db -> where('ilpo_id', $dAwal['ilpo_id']);
					$updet = $this -> db -> update('plc2.lpo', $dataH);

					if ($updet) {
						$ret = $vNama_modul.' => Approval Berhasil ';
					}else{
						$ret = $vNama_modul.' => Approval Gagal ';
					}
				}else{
					/*jika sudah approve maka skip*/
					$ret = $vNama_modul.' => SKIP';

				}

			}else{
				// data belum ada
					// cek apakah flow baru
					if($iNewFlow==1){
						//jika flow baru
					}else{
						// insert  bebas, tapi sesuai dengan info di tabel.
						/*
							ketentuan
							1. status approval sesuai dengan user yang melakukan inject
							2. PIC sesuai user yang melakukan inject
							3. Nomor Batch = 0
							4. tgl mulai & selesai 1970-01-01

						*/


						// jika flow lama

						//jika tidak ada maka insert header dan detail
						$dataH=array();
						$dataH['iupb_id'] = $id;
						$dataH['vPICpd'] = $this->user->gNIP;
						$dataH['dmulai_lpo'] = '1970-01-01';
						$dataH['dselesai_lpo'] = '1970-01-01';
						$dataH['isubmit'] = '1';

						$dataH['cCreate'] = $this->user->gNIP;
						$dataH['dCreate'] = date('Y-m-d H:i:s');


						//app PD
						$dataH['iapppd'] = '2';
						$dataH['vapppd'] = $this->user->gNIP;
						$dataH['dapppd'] = date('Y-m-d H:i:s');
						$dataH['vRemark'] = 'Inject By '.$this->user->gNIP;

						$insH = $this -> db -> insert('plc2.lpo', $dataH);



						if ($insH) {
							$ret = $vNama_modul.' => Insert Berhasil ';


						}else{

							$ret = $vNama_modul.' => Insert  Gagal ';


						}
					}
			}


			//iNSERT pILOT
				$sqlc="SELECT formula_process.iFormula_process AS ifo, formula_process.iupb_id , formula_stabilita.iVersi, formula_stabilita.vNo_formula AS formula_stabilita_vNo_formula,
				formula_stabilita.iKesimpulanStabilita AS formula_stabilita_iKesimpulanStabilita,
				formula_stabilita.iApp_formula AS formula_stabilita_iApp_formula,
				plc2_upb.vupb_nomor AS plc2_upb_vupb_nomor, plc2_upb.vupb_nama AS plc2_upb_vupb_nama,  pddetail.formula_process.*
				FROM (pddetail.formula_process)
				INNER JOIN pddetail.formula_process_detail ON formula_process_detail.iFormula_process = formula_process.iFormula_process
				INNER JOIN pddetail.formula_stabilita ON formula_stabilita.iFormula_process = formula_process.iFormula_process
				INNER JOIN plc2.plc2_upb ON plc2_upb.iupb_id = formula_process.iupb_id
				WHERE formula_process_detail.lDeleted = '0'
				AND formula_stabilita.lDeleted = '0'
				AND formula_process.lDeleted = '0'
				AND formula_process.iMaster_flow IN (9,10,11)
				AND formula_process.ij_product=0
				AND formula_process.iupb_id = ".$id."
				GROUP BY iupb_id, iVersi";
				$hellyeah = $this->db_plc0->query($sqlc)->result_array();
				if(empty($hellyeah)){
						$formula_i = 'FORMULA INJECT';
						$for = "SELECT pu.vkode_surat, pu.vnip_formulator FROM plc2.plc2_upb_formula pu WHERE pu.iupb_id = '".$id."' ORDER BY pu.ifor_id DESC";
						$dt = $this->db_plc0->query($for)->row_array();
						if(!empty($dt['vkode_surat'])){
							$formula_i = $dt['vkode_surat'];
						}

						$this->next_proses($id,9,0,$formula_i,1);//To Stabilita LAB Accelarated
						$this->next_proses($id,10,0,$formula_i,1);//To Stabilita LAB Intermediate
						$this->next_proses($id,11,0,$formula_i,1);//To
				}

			return $ret;

	}

	function P00040($id,$idmodul){
			// Validasi Proses
			$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
			$mod = $this->db_plc0->query($sql_mod)->row_array();
			$vNama_modul = $mod['vNama_modul'];
			$iNewFlow = $mod['iNewFlow'];

			$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
			$dUpb = $this->db_plc0->query($sqUpb)->row_array();

			$ret= '';

			/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
			$sqlcekAwal = 'select * from plc2.validasi_proses a
							where a.lDeleted=0
							and a.iappqa!=1
							and a.iupb_id="'.$id.'"
							';
			$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

			if (!empty($dAwal)) {

				/*jika ada , cek approval*/
				$setatus = $dAwal['iappqa'];
				if ($setatus == 0) {
					//app QA
								$dataH=array();
								$dataH['iappqa'] = '2';
								$dataH['vappqa'] = $this->user->gNIP;
								$dataH['dappqa'] = date('Y-m-d H:i:s');
								$dataH['cUpdate'] = $this->user->gNIP;
								$dataH['dupdate'] = date('Y-m-d H:i:s');
								$dataH['isubmit'] = '1';
								$dataH['vRemark'] = 'Inject By '.$this->user->gNIP;






					$this -> db -> where('ivalidasi_id', $dAwal['ivalidasi_id']);
					$updet = $this -> db -> update('plc2.validasi_proses', $dataH);

					if ($updet) {
						$ret = $vNama_modul.' => Approval Berhasil ';
					}else{
						$ret = $vNama_modul.' => Approval Gagal ';
					}
				}else{
					/*jika sudah approve maka skip*/
					$ret = $vNama_modul.' => SKIP';
				}

			}else{
				// data belum ada
					// cek apakah flow baru
					if($iNewFlow==1){
						//jika flow baru
					}else{
						// insert  bebas, tapi sesuai dengan info di tabel.
						/*
							ketentuan
							1. status approval sesuai dengan user yang melakukan inject
							2. PIC sesuai user yang melakukan inject
							3. Nomor Batch = 'NULL'
							4. tgl mulai & selesai 1970-01-01

						*/


						// jika flow lama

								//jika tidak ada maka insert header dan detail
								$dataH=array();
								$dataH['iupb_id'] = $id;
								$dataH['vPICqa'] = $this->user->gNIP;
								$dataH['dmulai_validasi'] = '1970-01-01';
								$dataH['dselesai_validasi'] = '1970-01-01';
								$dataH['vbatch'] = 'NULL';
								$dataH['isubmit'] = '1';

								$dataH['cCreate'] = $this->user->gNIP;
								$dataH['dCreate'] = date('Y-m-d H:i:s');


								//app QA
								$dataH['iappqa'] = '2';
								$dataH['vappqa'] = $this->user->gNIP;
								$dataH['dappqa'] = date('Y-m-d H:i:s');
								$dataH['vRemark'] = 'Inject By '.$this->user->gNIP;




								$insH = $this -> db -> insert('plc2.validasi_proses', $dataH);
								//$idHead=$this->db_plc0->insert_id();



								if ($insH) {
									$ret = $vNama_modul.' => Insert Berhasil ';


								}else{

									$ret = $vNama_modul.' => Insert  Gagal ';


								}

					}
			}

			return $ret;

	}


	function P00041($id,$idmodul){
		// COA Pilot dan Lab
		$sql_mod='select * from plc2.master_proses a where a.master_proses_id="'.$idmodul.'"';
		$mod = $this->db_plc0->query($sql_mod)->row_array();
		$vNama_modul = $mod['vNama_modul'];
		$iNewFlow = $mod['iNewFlow'];

		$sqUpb = 'select * from plc2.plc2_upb a where a.iupb_id = "'.$id.'"';
		$dUpb = $this->db_plc0->query($sqUpb)->row_array();

		$ret= '';

		/*cek apakah data ada pada table dengan kondisi requirement sekarang ?*/
			$sqlcekAwal = 'SELECT validasi_proses.*
			FROM (plc2.plc2_upb)
			LEFT JOIN plc2.coa_pilot_lab ON coa_pilot_lab.iupb_id = plc2_upb.iupb_id
			INNER JOIN plc2.validasi_proses ON validasi_proses.iupb_id = plc2_upb.iupb_id
			INNER JOIN plc2.plc2_upb_formula ON plc2_upb_formula.iupb_id=plc2.plc2_upb.iupb_id
			INNER JOIN pddetail.formula_process ON formula_process.iupb_id=plc2_upb_formula.iupb_id
			INNER JOIN pddetail.formula ON formula.iFormula_process=formula_process.iFormula_process
			INNER JOIN plc2.plc2_upb_buat_mbr ON plc2_upb_buat_mbr.ifor_id=plc2_upb_formula.ifor_id
			WHERE plc2_upb.ldeleted =  0
			AND plc2_upb_buat_mbr.iapppd_bm =  2
			AND plc2_upb_buat_mbr.ldeleted =  0
			AND plc2_upb.ihold =  0
			AND validasi_proses.iappqa =  2
			AND plc2_upb.iupb_id in (select bk.iupb_id from plc2.plc2_upb_bahan_kemas bk where bk.iapppc=2 and bk.iapppd=2 and bk.iappqa=2 and bk.iappbd=2 and bk.ldeleted=0 group by bk.iupb_id)
			AND plc2_upb.iupb_id in (select distinct(fo.iupb_id) from plc2.plc2_upb_formula fo
			 inner join plc2.plc2_upb_prodpilot pr on pr.ifor_id=fo.ifor_id
			 where fo.ldeleted=0 and pr.ldeleted=0 and pr.iapppd_pp=2)
			AND plc2.plc2_upb.ldeleted =  0
			AND plc2.plc2_upb.iKill =  0
			AND plc2.plc2_upb.itipe_id not in (6)
			AND plc2_upb.ihold = 0
			AND coa_pilot_lab.iappqa!=1
			AND plc2.plc2_upb.iupb_id='.$id;
			$dAwal = $this->db_plc0->query($sqlcekAwal)->row_array();

			if (!empty($dAwal)) {

				/*jika ada , cek approval*/
				$setatus = $dAwal['iappqa'];
				if ($setatus == 0) {
					//app PD
					$dr=$this->dbset->query($sqlcekAwal)->result_array();
					foreach ($dr as $kv => $vv) {

						$dataH=array();
						#field approval
						$dataH['isubmit'] = '1';
						$dataH['iappqa'] = '2';
						$dataH['vappqa'] = $this->user->gNIP;
						$dataH['dappqa'] = date('Y-m-d H:i:s');
						$dataH['vRemark'] ='Inject By - '.$this->user->gNIP;

						$this -> db -> where('icoa_id', $vv['icoa_id']);
						$updet = $this -> db -> update('plc2.coa_pilot_lab', $dataH);
						if ($updet) {
							$ret = $vNama_modul.' => Approval Berhasil ';
						}else{
							$ret = $vNama_modul.' => Approval Gagal ';
						}
					}
				}else{
					/*jika sudah approve maka skip*/
					$ret = $vNama_modul.' => SKIP';
				}

			}else{
				// data belum ada
					// cek apakah flow baru
					if($iNewFlow==1){
						//jika flow baru
					}else{
						// insert  bebas, tapi sesuai dengan info di tabel.

						// jika flow lama

						$dataI=array();
						#field approval
						$dataI['iupb_id'] = $id;
						$dataI['isubmit'] = '1';
						$dataI['iappqa'] = '2';
						$dataI['vappqa'] = $this->user->gNIP;
						$dataI['dappqa'] = date('Y-m-d H:i:s');
						$dataI['vRemark'] ='Inject By - '.$this->user->gNIP;


						$updet = $this -> db -> insert('plc2.coa_pilot_lab', $dataI);
						if ($updet) {
							$ret = $vNama_modul.' => Approval Berhasil ';
						}else{
							$ret = $vNama_modul.' => Approval Gagal ';
						}
					}
			}
		return $ret;

	}




	public function output(){
		$this->index('piew');
	}
}

?>
