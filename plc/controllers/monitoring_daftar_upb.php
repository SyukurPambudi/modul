<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class monitoring_daftar_upb extends MX_Controller {
	private $sess_auth;
	private $dbset;
	private $urutan = 0;
	private $report;
			
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		ini_set('memory_limit', '-1');
        $this->sess_auth = new Zend_Session_Namespace('auth'); 
		$this->load->library('auth');
		$this->load->library('lib_utilitas');
		$this->user = $this->auth->user();
		$this->url = 'monitoring_daftar_upb'; 
		$this->dbset = $this->load->database('plc', true);
		
	
	
    }
    function index($action = '') {		
    	//Bikin Object Baru Nama nya $grid
    	$action = $this->input->get('action') ? $this->input->get('action') : 'create';	
		//$action = $this->input->get('action');
        $grid = new Grid;		
        $grid->setTitle('Monitoring UPB');		
        $grid->setTable('plc2.plc2_upb');		
        $grid->setUrl('monitoring_daftar_upb');		
        $grid->addFields('iupb_id','cari');//, 'format'
        //$grid->addList('SendingDateTime','DestinationNumber','nama', 'iDivisionID ', 'TextDecoded', 'Status', 'cSenderBy', 'pengirim');//, 'tUpdated', 'cUpdatedBy');
        $grid->setLabel('iupb_id', 'UPB');
		$grid->setRequired('iupb_id');
		
		

        //$grid->setLabel('Nomor','Nomor Tujuan');
       
            switch ($action) {		
			case 'json':
                        $grid->getJsonData();
                        break;
            case 'view':
                        $grid->render_form($this->input->get('id'), true);
                        break;
            case 'create':
                        $grid->render_form();
                        break;
			case 'getData':
						echo $this->getData();
						break;
			case 'sendMail':
						echo $this->sendMail();
						break;
			case 'createproses':
                        echo $grid->saved_form();
                        break;
            case 'update':
                        $grid->render_form($this->input->get('id'));
                        break; 
			case 'updateproses':
                        echo $grid->updated_form();
                        break;			
			 case 'delete':
                        echo $grid->delete_row();
                        break;			
			
			default:
						$grid->render_grid();
						break;
		}
    }

	function insertBox_monitoring_daftar_upb_iupb_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="7" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/plc/upb/daftar/monitoring?field=monitoring_daftar_upb\',\'List UPB\')" type="button">&nbsp;</button>';
		
		return $return;
	}
	public function output(){
		$this->index('create');
	
	}
	public function manipulate_insert_button($button) {
		unset($button);
	}
	public function listBox_action($row, $actions) {	
		
		$actions['view'] = '';
		
		return $actions;
	}
	
	function insertBox_monitoring_daftar_upb_cari($field, $id) {
		$data['class_name'] = $this->url;
		return $this->load->view('monitoring_daftar_upb', $data, TRUE);
	}
	
	function getEmail($nip){
	$nips = explode(',',$nip);
	$email='';
		foreach($nips as $value){
		
			if($value!=''){
				$sql ="select vEmail from hrd.employee where cNip  ='".$value."'";
				$query = $this->db_plc0->query($sql);
				$tamp='';
				if ($query->num_rows() > 0) {
					$r = $query->row();
					$tamp = $r->vEmail;
				}
				$email = $email."".$tamp.",";
			}
			
		}
		return $email;
	}
	
	function getEmployeeName($id) {
		$sql = "Select vName from hrd.employee where cNip = '{$id}'";
		$query = $this->dbset->query($sql);
		$nm_comp = '';
		if ($query->num_rows() > 0) {
			$r = $query->row();
			$nm_comp = $r->vName;
		}
		
		return $nm_comp;
	}
	function sendMail() {
		
		$status_proses = $_GET['_parameter3'];
		$proses ='';
		if($status_proses==1){ $proses="Daftar UPB";}
		elseif($status_proses==2){ $proses="Setting Prioritas Pra-Reg";}
		elseif($status_proses==3){ $proses="Sample Originator";}
		elseif($status_proses==4){ $proses="Permintaan Sample";}
		elseif($status_proses==5){ $proses="Po Sample";}
		elseif($status_proses==6){ $proses="Penerimaan Sample";}
		elseif($status_proses==7){ $proses="Terima Bahan Baku";}
		elseif($status_proses==8){ $proses="Analisa Bahan Baku";}
		elseif($status_proses==9){ $proses="Release Bahan Baku";}
		elseif($status_proses==10){ $proses="Soi Bahan Baku";}
		elseif($status_proses==11){ $proses="Formula Skala Trial";}
		elseif($status_proses==12){ $proses="Street Test";}
		elseif($status_proses==13){ $proses="Formula Skala Lab";}
		elseif($status_proses==14){ $proses="Approval KSK";}
		elseif($status_proses==15){ $proses="Stabilita Lab";}
		elseif($status_proses==16){ $proses="Best Formula";}
		elseif($status_proses==17){ $proses="Spesifikasi SOI FG";}
		elseif($status_proses==18){ $proses="SOI FG";}
		elseif($status_proses==19){ $proses="Soi Mikro Final";}
		elseif($status_proses==20){ $proses="Approval HPP";}
		elseif($status_proses==21){ $proses="Basic Formula + Val. Moa";}
		elseif($status_proses==22){ $proses="Bahan Kemas";}
		elseif($status_proses==23){ $proses="Pembuatan MBR";}
		elseif($status_proses==24){ $proses="Produksi Pilot";}
		elseif($status_proses==25){ $proses="Stabilita Pilot";}
		elseif($status_proses==26){ $proses="Praregistrasi";}
		elseif($status_proses==27){ $proses="Setting Prioritas Registrasi";}
		elseif($status_proses==28){ $proses="Registrasi";}
		elseif($status_proses==29){ $proses="Launching Produk";}
		$sql_iupb_id = 'Select * from plc2.plc2_upb where vupb_nomor = "'.$_GET['_parameter'].'"';
		$isi = $this->db_plc0->query($sql_iupb_id)->row_array();
		
		$mail = $this->getEmail($_GET['_parameter1']);
		
	
			$to = $mail;
			$cc = "";
			$judul = str_replace('<br>', '', $_GET['_parameter2']);
			$subject=$judul;
			$a="
				<html>
				<head>
				
				</head>
				<body>
				<div><h3>Kepada Yth.Bapak/Ibu</h3></div>
				<div><h5>Berikut disampaikan informasi dari:<br><br></h5></div>
				<table class='tbl3' style='width: 100%' width='100%'>";
					
						$a.='
							<tr>
								<td >No. UPB</td>
								<td>:</td>
								<td >'.$_GET['_parameter'].'</td>
							</tr>
							<tr >
								<td >Proses</td>
								<td>:</td>
								<td >'.$proses.'</td>
							</tr>
							<tr >
								<td >Status</td>
								<td>:</td>
								<td >'.$_GET['_parameter2'].'</td>
							</tr>
							<tr >
								<td >Pengirim</td>
								<td>:</td>
								<td >'.$this->getEmployeeName($_GET['_parameter4']).'-'.$_GET['_parameter4'].'</td>
							</tr>
						';
					$a.="	
					</table>
				<br/> 
				Mohon kepada pihak terkait agar segera melakukan  follow up terhadap UPB tersebut untuk kelancaran proses UPB. Terimakasih.<br><br><br>
				Post Master
				</body>
			</html>";
				$content=$a;
		$this->lib_utilitas->send_email($to, $cc, $subject, $content);
		
		$data['status']  = true;
		$data['last_id'] =$isi['iupb_id'];
		return json_encode($data);
	
	}
	
	
	function getBusdev($iteam_id){
		$sql ="SELECT  t.`vnip`FROM
			  plc2.plc2_upb_team_item t INNER JOIN   plc2.plc2_upb_team ut 
				ON t.iteam_id = ut.iteam_id 
			   WHERE  t.ldeleted = 0  AND ut.`iteam_id` ='".$iteam_id."'";
		$nip ='';
		$query = $this->dbset->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			foreach($result as $row) {
				$nip = $nip."".$row['vnip'].",";
			}
		}
		return $nip;
	}
	
	function getPD($iteampd_id){
		$sql ="SELECT  t.`vnip`FROM
			  plc2.plc2_upb_team_item t INNER JOIN   plc2.plc2_upb_team ut 
				ON t.iteam_id = ut.iteam_id 
			   WHERE  t.ldeleted = 0  AND ut.`iteam_id` ='".$iteampd_id."'";
		$nip ='';
		$query = $this->dbset->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			foreach($result as $row) {
				$nip = $nip."".$row['vnip'].",";
			}
		}
		return $nip;
	}
	
	function getQA($iteamqa_id){
		$sql ="SELECT  t.`vnip`FROM
			  plc2.plc2_upb_team_item t INNER JOIN   plc2.plc2_upb_team ut 
				ON t.iteam_id = ut.iteam_id 
			   WHERE  t.ldeleted = 0  AND ut.`iteam_id` ='".$iteamqa_id."'";
		$nip ='';
		$query = $this->dbset->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			foreach($result as $row) {
				$nip = $nip."".$row['vnip'].",";
			}
		}
		return $nip;
	}
	
	function getQC($iteamqc_id){
		$sql ="SELECT  t.`vnip`FROM
			  plc2.plc2_upb_team_item t INNER JOIN   plc2.plc2_upb_team ut 
				ON t.iteam_id = ut.iteam_id 
			   WHERE  t.ldeleted = 0  AND ut.`iteam_id` ='".$iteamqc_id."'";
		$nip ='';
		$query = $this->dbset->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			foreach($result as $row) {
				$nip = $nip."".$row['vnip'].",";
			}
		}
		return $nip;
	}
	
	function getFA(){
		$sql ="SELECT * FROM plc2.plc2_upb_team WHERE vtipe ='FA'";
		$nip = $this->db_plc0->query($sql)->row_array();
		return $nip['vnip'];
	}
	
	
	function getPR(){
		$sql ="SELECT * FROM plc2.plc2_upb_team WHERE vtipe ='PR'";
		$nip = $this->db_plc0->query($sql)->row_array();
		return $nip['vnip'];
	}
	
	function statusClick($iteam_id, $nip){
	
		$sql ="SELECT ut.cDeptId FROM plc2.plc2_upb_team_item t INNER JOIN   plc2.plc2_upb_team ut 
				ON t.iteam_id = ut.iteam_id 
			   WHERE   ut.`iteam_id`='".$iteam_id."' AND t.`vnip`='".$nip."' ";
		//$sql ="SELECT ut.cDeptId FROM plc2.plc2_upb_team_item t INNER JOIN   plc2.plc2_upb_team ut 
		//		ON t.iteam_id = ut.iteam_id 
		//	   WHERE   ut.`iteam_id`=4 AND t.`vnip`='N12787'
		//	  AND t.ldeleted = 0 ;";
		$nip ='';
		$query = $this->dbset->query($sql);
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			foreach($result as $row) {
				$nip = $nip."".$row['cDeptId'].",";
			}
		}
		return $nip;
	
	}
	
	function getData() {
		$user = $this->user->gNIP;
		
		$data= array();
		$row_array['vupb_nomor'] = $_GET['_parameter'];
		$sql_iupb_id = 'Select * from plc2.plc2_upb where iupb_id = "'.$_GET['_parameter'].'"';
		$isi = $this->db_plc0->query($sql_iupb_id)->row_array();
		$busdev = $this->getBusdev($isi['iteambusdev_id']);
		$pd = $this->getPD($isi['iteampd_id']);
		$qa = $this->getQA($isi['iteamqa_id']);
		$qc = $this->getQC($isi['iteamqc_id']);
		$fa = $this->getFA();
		$pr = $this->getPR();
		//filter untuk bisa cli
		$mydept=$this->auth->tipe();
		if($this->auth->is_manager()){
			$x=$this->auth->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				$type2= $this->statusClick($isi['iteampd_id'],$user);
				if($type2){
					$row_array['click'] = 'Yes';
				}else{
					$row_array['click'] = 'no';
				}
			}
			elseif(in_array('BD', $manager)){
				$type='BD';
				$type2= $this->statusClick($isi['iteambusdev_id'],$user);
				if($type2){
					$row_array['click'] = 'Yes';
				}else{
					$row_array['click'] = 'no';
				}
			 }
			elseif(in_array('QA', $manager)){
				$type='QA';
				$type2= $this->statusClick($isi['iteamqa_id'],$user);
				if($type2){
					$row_array['click'] = 'Yes';
				}else{
					$row_array['click'] = 'no';
				}
			
			}
			elseif(in_array('QC', $manager)){
				$type='QC';
				$type2= $this->statusClick($isi['iteamqc_id'],$user);
				if($type2){
					$row_array['click'] = 'Yes';
				}else{
					$row_array['click'] = 'no';
				}
			}
			elseif(in_array('DR',$manager)){
				$type='DR';
				$row_array['click'] = 'Yes';
				
			}
			else{
				$row_array['click'] = 'no';
			}
		}
		else{
			$x=$this->auth->dept();
			if(!empty($x)){
				$team=$x['team'];
				
				if(in_array('PD', $team)){
					$type='PD';
					$type2= $this->statusClick($isi['iteampd_id'],$user);
					if($type2){
						$row_array['click'] = 'Yes';
					}else{
						$row_array['click'] = 'no';
					}
				}
				elseif(in_array('BD', $team)){
					$type='BD';
					$type2= $this->statusClick($isi['iteambusdev_id'],$user);
					if($type2){
						$row_array['click'] = 'Yes';
					}else{
						$row_array['click'] = 'no';
					}
				 }
				elseif(in_array('DR',$team)){
					$type='DR';
					$row_array['click'] = 'Yes';
				}
				elseif(in_array('QA', $team)){
					$type='QA';
					$type2= $this->statusClick($isi['iteamqa_id'],$user);
					if($type2){
						$row_array['click'] = 'Yes';
					}else{
						$row_array['click'] = 'no';
					}
				}
				elseif(in_array('QC', $team)){
					$type='QC';
					$type2= $this->statusClick($isi['iteamqc_id'],$user);
					if($type2){
					$row_array['click'] = 'Yes';
					}else{
						$row_array['click'] = 'no';
					}
				}
				else{$row_array['click'] = 'no';}
			}else{$row_array['click'] = 'no';}
		}
		$row_array['vupb_nomor'] = $isi['vupb_nomor'];
		$row_array['pengirim'] = $user;
		if($isi['iupb_id']){
			$iupb_id =$isi['iupb_id'];
			if($isi['ldeleted']==1){
				$row_array['box'] = '0';
			}
			elseif($isi['iappbusdev']==0 && $isi['iappbusdev']==0)
			{
				$row_array['box'] = '1';
				$row_array['status'] = 'Waiting Approval Busdev <br> Waiting Approval Direksi';
				$row_array['status1'] = $busdev;
			}elseif($isi['iappbusdev']==1 && $isi['iappbusdev']==0)
			{
				$row_array['box'] = '1';
				$row_array['status'] = 'Reject Busdev';
				$row_array['status1'] = '';
			}
			// untuk diamasukkan ke dalam setting prioritas 
			elseif($isi['iappbusdev']==2 && $isi['iappbusdev']==2)
			{
				$sql_iupb_id = "SELECT * FROM plc2.plc2_upb_prioritas a INNER JOIN plc2.plc2_upb_prioritas_detail b ON a.`iprioritas_id` = b.`iprioritas_id` WHERE b.`iupb_id` ='".$iupb_id."'";
				$isi2 = $this->db_plc0->query($sql_iupb_id)->row_array();
				if(empty($isi2)){
					$row_array['box'] = '2';
					$row_array['status'] = 'Waiting Input Setting Prioritas Prareg';
					$row_array['status1'] = $busdev;
				}elseif($isi2['iappbusdev']==0){
					$row_array['box'] = '2';
					$row_array['status'] = 'Waiting Approval Busdev ';
					$row_array['status1'] = $busdev;
				
				}elseif($isi2['iappbusdev']==1){
					$row_array['box'] = '2';
					$row_array['status'] = 'Reject Busdev';
					$row_array['status1'] = '';
				
				}elseif($isi2['iappbusdev']==2){
					//melewati input sample originator
				
					if($isi['voriginator']=='N/A'){
							$sql_permintaan_sample = "SELECT * FROM plc2.plc2_upb WHERE plc2.plc2_upb.iupb_id IN (SELECT pd.iupb_id FROM plc2.plc2_upb_prioritas_detail pd 
													INNER JOIN plc2.plc2_upb_prioritas pr ON pr.iprioritas_id=pd.iprioritas_id
											WHERE pd.ldeleted=0 AND pr.iappbusdev=2 ) AND iupb_id = '".$iupb_id."'";
							$isi = $this->db_plc0->query($sql_permintaan_sample)->row_array();
							if($isi){	
								$sql_permintaan_sample2 = "SELECT * FROM plc2.plc2_upb_request_sample a left JOIN plc2.plc2_upb b ON a.iupb_id = b.iupb_id WHERE a.iupb_id ='".$iupb_id."'";
								$isi = $this->db_plc0->query($sql_permintaan_sample2)->row_array();
								if(empty($isi)){
									$row_array['box'] = '4';
									$row_array['status'] = 'Waiting Approval  PD';
									$row_array['status1'] = $pd;
								}
								elseif($isi['iapppd']==0){
									$row_array['box'] = '4';
									$row_array['status'] = 'Waiting Approval  PD';
									$row_array['status1'] = $pd;
								
								}elseif($isi['iapppd']==1){
									$row_array['box'] = '4';
									$row_array['status'] = 'Waiting Approval PD';
									$row_array['status1'] = $pd;
								
								}else{
									$sql_po_sample = "SELECT * FROM plc2.plc2_upb_po  p LEFT JOIN  plc2.plc2_upb_po_detail z ON p.`ipo_id` = z.`ipo_id` WHERE z.`ireq_id` = '".$isi['ireq_id']."'";
									$isi = $this->db_plc0->query($sql_po_sample)->row_array();
									if(empty($isi)){
										$row_array['box'] = '5';
										$row_array['status'] = 'Waiting input new Purchasing';
										$row_array['status1'] = $pr;
									}
									elseif($isi['iapppr']==0){
										$row_array['box'] = '5';
										$row_array['status'] = 'Waiting Approval Purchasing';
										$row_array['status1'] = $pr;
									}elseif($isi['iapppr']==1){
										$row_array['box'] = '5';
										$row_array['status'] = 'Reject Purchasing';
										$row_array['status1'] = '';
									}elseif($isi['iapppr']==2){
										$isi2= $isi['ireq_id'];
										$sql_po_sample = "SELECT * FROM plc2.plc2_upb_ro  p LEFT JOIN  plc2.plc2_upb_ro_detail z ON p.`ipo_id` = z.`ipo_id` WHERE z.`ireq_id` = '".$isi['ireq_id']."'";
										$isi = $this->db_plc0->query($sql_po_sample)->row_array();
										if(empty($isi)){
											$row_array['box'] = '6';
											$row_array['status'] = 'Waiting Approval Purchasing';
											$row_array['status1'] = $pr;
										
										}
										elseif($isi['iapppr']==0){
											$row_array['box'] = '6';
											$row_array['status'] = 'Waiting Approval Purchasing';
											$row_array['status1'] = $pr;
										}elseif($isi['iapppr']==1){
											$row_array['box'] = '6';
											$row_array['status'] = 'Reject Purchasing';
											$row_array['status1'] = '';
										}elseif($isi['iapppr']==2){
											$sql_po_sample = "SELECT * FROM plc2.plc2_upb_ro_detail a INNER JOIN plc2.plc2_upb_request_sample b ON a.`ireq_id` = b.`ireq_id` WHERE a.`ireq_id` = '".$isi2."'";
											$isi = $this->db_plc0->query($sql_po_sample)->row_array();
											if(empty($isi)){
												$row_array['box'] = '7';
												$row_array['status'] = 'Waiting input PD';
												$row_array['status1'] = $pd;
											
											}
											if(($isi['vrec_nip_pd']=='') && ($isi['vrec_nip_qc']=='')){
												$row_array['box'] = '7';
												$row_array['status'] = 'Waiting input PD';
												$row_array['status1'] = $pd;
											}elseif($isi['vrec_nip_pd']!='' && $isi['vrec_nip_qc']!='' && $isi['vrec_nip_qa']==''){
												$row_array['box'] = '7';
												$row_array['status'] = 'Waiting input QA Mikro';
												$row_array['status1'] = $qa;
											}elseif(($isi['iapppd_analisa']=='')){
												$row_array['box'] = '8';
												$row_array['status'] = 'Waiting Approval PD ';
												$row_array['status1'] = $pd;
											}elseif(($isi['iapppd_analisa']==1)){
												$row_array['box'] = '8';
												$row_array['status'] = 'Rejected PD ';
												$row_array['status1'] = '';
											}elseif(($isi['iapppd_analisa']==2)){
												$sql_release_bb = "SELECT * FROM plc2.plc2_upb_ro_detail a INNER JOIN plc2.plc2_upb_request_sample b ON a.`ireq_id` = b.`ireq_id` JOIN plc2.plc2_upb_ro c ON a.`iro_id` = c.`iro_id` JOIN plc2.plc2_upb d ON b.`iupb_id` = d.`iupb_id` WHERE d.`iupb_id`='".$iupb_id."'";
												$isi = $this->db_plc0->query($sql_release_bb)->row_array();
												if(($isi['iapppd_rls']=='') || empty($isi['iapppd_rls'])){
													$row_array['box'] = '9';
													$row_array['status'] = 'Waiting Approval PD';
													$row_array['status1'] = $pd;
												}elseif($isi['iapppd_rls']==1){
													$row_array['box'] = '9';
													$row_array['status'] = 'Reject PD';
													$row_array['status1'] = '';
												}
												elseif($isi['iapppd_rls']==2){
													$sql_cek_soi_bb= "SELECT * FROM plc2.plc2_upb  WHERE iupb_id NOT IN (SELECT f.iupb_id FROM plc2.plc2_upb_soi_bahanbaku f WHERE f.iappqc=0 AND f.ldeleted=0) AND iupb_id IN 
													(
														SELECT rs.iupb_id FROM plc2.plc2_upb_request_sample rs 
															INNER JOIN plc2.plc2_upb_ro_detail rod ON rod.ireq_id=rs.ireq_id
														WHERE rs.iapppd=2 AND rs.ldeleted=0 AND rod.irelease=2 AND rod.iapppd_rls=2 AND rod.ldeleted=0
													) AND iappdireksi =2  AND ihold=0 and iupb_id='".$iupb_id."'";
													$sql_soi_bb ="SELECT * FROM plc2.`plc2_upb_soi_bahanbaku` WHERE iupb_id ='".$iupb_id."'";
													$isi2 = $this->db_plc0->query($sql_soi_bb)->row_array();
													$isi = $this->db_plc0->query($sql_cek_soi_bb)->row_array();
													if($isi && $isi2){
														if($isi2['iappqc']==1){
															$row_array['box'] = '10';
															$row_array['status'] = 'Rejected QC';
															$row_array['status1'] = $qc;
														}
														elseif($isi2['iappqc']==2){
															if($isi2['iappqa']==0){
																$row_array['box'] = '10';
																$row_array['status'] = 'Waiting Approval QA';
																$row_array['status1'] = $qa;
															}elseif($isi2['iappqa']==1){
																$row_array['box'] = '10';
																$row_array['status'] = 'Reject QA';
																$row_array['status1'] = '';
															}elseif($isi2['iappqa']==2){
																$sql_fomula_st = "SELECT * FROM plc2.plc2_upb_formula a INNER JOIN plc2.`plc2_upb` b ON a.`iupb_id` = b.`iupb_id` WHERE a.`iupb_id`='".$iupb_id."'";
																$isi = $this->db_plc0->query($sql_fomula_st)->row_array();
															
																if(empty($isi)){
																	$row_array['box'] = '11';
																	$row_array['status'] = 'Waiting Input PD- AD';
																	$row_array['status1'] = $pd;
																}elseif($isi){
																	if($isi['iformula_apppd']==0){
																		$row_array['box'] = '11';
																		$row_array['status'] = 'Waiting Approval PD ';
																		$row_array['status1'] = $pd;
																	}elseif($isi['iformula_apppd']==1){
																		$row_array['box'] = '11';
																		$row_array['status'] = 'Reject PD';
																		$row_array['status1'] = '';
																	}elseif($isi['iformula_apppd']==2){
																			//untuk lanjut ke Street Test
																		$sql_street_test = "SELECT * from plc2.plc2_upb_formula INNER JOIN plc2.plc2_upb  ON plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id 
																							WHERE plc2_upb_formula.ldeleted = 0 
																							  AND plc2_upb_formula.iwithstress = 1
																							  AND plc2_upb_formula.istress = 2 
																							  AND plc2_upb.ihold = 0
																							  AND plc2_upb_formula.iformula_apppd = 2
																							  AND plc2_upb_formula.`iupb_id` ='".$iupb_id."'";
																		$isi = $this->db_plc0->query($sql_street_test)->row_array();
																		if($isi){
																			if($isi['istress_apppd']==0){
																				$row_array['box'] = '12';
																				$row_array['status'] = 'Waiting Approval PD';
																				$row_array['status1'] = $pd;
																			}elseif($isi['istress_apppd']==1){
																				$row_array['box'] = '12';
																				$row_array['status'] = 'Rejected PD';
																				$row_array['status1'] = '';
																			}elseif($isi['istress_apppd']==2){
																				$sql_skala_lab = "SELECT * from plc2.plc2_upb_formula INNER JOIN plc2.plc2_upb  ON plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id 
																							WHERE plc2_upb_formula.ldeleted = 0 
																							  AND plc2_upb.ihold = 0
																							  AND plc2_upb_formula.iformula_apppd = 2
																							  AND plc2_upb_formula.`iupb_id` ='".$iupb_id."'";
																				$isi = $this->db_plc0->query($sql_skala_lab)->row_array();
																				if($isi['ilab_apppd']==0){
																					$row_array['box'] = '13';
																					$row_array['status'] = 'Waiting Update PD pada Formula Skala Lab';
																					$row_array['status1'] = '';
																				}elseif($isi['ilab_apppd']==2){
																					$sql_approval_ksk = "SELECT * from plc2.plc2_upb_ro_detail a 
																										INNER JOIN plc2.plc2_raw_material b ON a.`raw_id` = b.`raw_id` 
																										  JOIN plc2.plc2_upb_ro c ON c.`iro_id` = a.`iro_id` 
																										  JOIN plc2.plc2_upb_po d ON d.`ipo_id` = a.`ipo_id` 
																										  JOIN plc2.plc2_upb_request_sample e ON e.`ireq_id` = a.`ireq_id` 
																										  JOIN plc2.plc2_upb f ON e.`iupb_id` = f.`iupb_id` 
																										WHERE a.`ldeleted` = 0 
																										  AND c.`iclose_po` = 1 
																										  AND a.`vrec_jum_pd` IS NOT NULL 
																										  AND a.`iapppd_analisa` = 2 
																										  AND f.`ihold` = 0 
																										  AND f.`iupb_id` = '".$iupb_id."'";
																					$isi = $this->db_plc0->query($sql_approval_ksk)->row_array();
																					if($isi){
																						if($isi['iappmoa']==0 && $isi['iappqa_ksk']==0  ){
																							$row_array['box'] = '14';
																							$row_array['status'] = 'Waiting input - update PD';
																							$row_array['status1'] = $pd;
																						}elseif($isi['iappmoa']!=0 && $isi['vcoa']=='' && $isi['iappqa_ksk']==0   ){
																							$row_array['box'] = '14';
																							$row_array['status'] = 'input update  Purchasing';
																							$row_array['status1'] = $pr;
																						}elseif($isi['iappmoa']!=0 && $isi['vcoa']!='' && $isi['iresult']==0 && $isi['iappqa_ksk']==0 ){
																							$row_array['box'] = '14';
																							$row_array['status'] = 'Waiting Approval QA';
																							$row_array['status1'] = $qa;
																						}elseif($isi['iappmoa']!=0 && $isi['vcoa']!='' && $isi['iresult']==0 && $isi['iappqa_ksk']==1){
																							$row_array['box'] = '14';
																							$row_array['status'] = 'Rejected QA';
																							$row_array['status1'] = '';
																						}
																						elseif($isi['iappmoa']!=0 && $isi['vcoa']!='' && $isi['iresult']==1 && $isi['iappqa_ksk']==1  ){
																							$row_array['box'] = '14';
																							$row_array['status'] = 'Tidak DIsetujui oleh QA <br>Dan Rejected QA';
																							$row_array['status1'] = $qa;
																						}elseif($isi['iappmoa']!=0 && $isi['vcoa']!='' && $isi['iresult']==2 && $isi['iappqa_ksk']==0){
																							$row_array['box'] = '14';
																							$row_array['status'] = 'DIsetujui oleh QA <br> waiting Approval QA';
																							$row_array['status1'] = $qa;
																						}elseif($isi['iappmoa']!=0 && $isi['vcoa']!='' && $isi['iresult']==2 && $isi['iappqa_ksk']==2){
																							$sql_stabilita_lab = "SELECT plc2_upb_stabilita.iapppd FROM plc2.plc2_upb_stabilita 
																													LEFT JOIN plc2.plc2_upb_formula ON plc2_upb_stabilita.ifor_id = plc2.plc2_upb_formula.ifor_id 
																													LEFT JOIN plc2.plc2_upb ON plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id 
																													WHERE plc2_upb_stabilita.ldeleted = 0 
																													 AND plc2.plc2_upb_stabilita.inumber = 
																													 (SELECT 
																														MAX(st2.inumber) 
																													  FROM
																														plc2.plc2_upb_stabilita st2 
																													  WHERE plc2_upb_stabilita.ifor_id = st2.ifor_id) 
																													  AND plc2_upb.`iupb_id` ='".$iupb_id."'";
																							$isi_stabilita = $this->db_plc0->query($sql_stabilita_lab)->row_array();
																							if(empty($isi_stabilita)){
																								$row_array['box'] = '15';
																								$row_array['status'] = 'Waiting input new PD - AD';
																								$row_array['status1'] = $pd;
																							}elseif($isi_stabilita){
																								if($isi_stabilita['iapppd']==2){
																									$sql_best_formula = "SELECT f.ifor_id, f.vkode_surat,f.vbest_nip_apppd,f.tbest_apppd FROM plc2.plc2_upb_formula f WHERE f.ifor_id IN 
																														(SELECT st.ifor_id FROM plc2.plc2_upb_stabilita st 
																															WHERE st.inumber=6 AND st.isucced=2 AND st.iapppd=2) AND f.iupb_id='".$iupb_id."'";
																									$isi = $this->db_plc0->query($sql_best_formula)->row_array();
																									if($isi['vbest_nip_apppd']=='' || empty($isi['vbest_nip_apppd'])){
																										$row_array['box'] = '16';
																										$row_array['status'] = 'Waiting Approval PD';
																										$row_array['status1'] = $pd;
																									
																									}else{
																										$sql_spek_soi = "SELECT * FROM plc2.plc2_upb_spesifikasi_fg INNER JOIN plc2.plc2_upb ON plc2_upb_spesifikasi_fg.iupb_id = plc2.plc2_upb.iupb_id  WHERE plc2_upb_spesifikasi_fg.ldeleted = 0 AND plc2_upb.ihold = 0 AND plc2_upb.`iupb_id` ='".$iupb_id."'";
																										$isi = $this->db_plc0->query($sql_spek_soi)->row_array();
																										if(empty($isi)){
																											$row_array['box'] = '17';
																											$row_array['status'] = 'Waiting Input new PD - AD';
																											$row_array['status1'] = $pd;
																										}else{
																											if($isi['iapppd']==0){
																												$row_array['box'] = '17';
																												$row_array['status'] = 'Waiting Approval PD - AD';
																												$row_array['status1'] = $pd;
																											}elseif($isi['iapppd']==2 && $isi['iappqa']==0 ){
																												$row_array['box'] = '17';
																												$row_array['status'] = 'Waiting Approval QA';
																												$row_array['status1'] = $pd;
																											}elseif($isi['iapppd']==1 && $isi['iappqa']==0 ){
																												$row_array['box'] = '17';
																												$row_array['status'] = 'Rejected PD';
																												$row_array['status1'] = '';
																											}elseif($isi['iapppd']==2 && $isi['iappqa']==2 ){
																												$sql_spek_soi = "SELECT * FROM plc2.plc2_upb_soi_fg INNER JOIN plc2.plc2_upb ON plc2_upb_soi_fg.iupb_id = plc2.plc2_upb.iupb_id  WHERE plc2_upb_soi_fg.ldeleted = 0 AND plc2_upb.ihold = 0 AND plc2_upb.`iupb_id` ='".$iupb_id."'";
																												$isi = $this->db_plc0->query($sql_spek_soi)->row_array();
																												if(empty($isi)){
																													$row_array['box'] = '18';
																													$row_array['status'] = 'Waiting Input new PD - AD';
																													$row_array['status1'] = $pd;
																												}elseif($isi['iappqc']==0){
																													$row_array['box'] = '18';
																													$row_array['status'] = 'Waiting Approval PD - AD';
																													$row_array['status1'] = $pd;
																												}elseif($isi['iappqc']==1){
																													$row_array['box'] = '18';
																													$row_array['status'] = 'Reject PD - AD';
																													$row_array['status1'] = '';
																												}elseif($isi['iappqc']==2 && $isi['iappqa']==0 ){
																													$row_array['box'] = '18';
																													$row_array['status'] = 'Waiting approval QA';
																													$row_array['status1'] = $qa;
																												}elseif($isi['iappqc']==2 && $isi['iappqa']==1 ){
																													$row_array['box'] = '18';
																													$row_array['status'] = 'Rejected QA';
																													$row_array['status1'] = '';
																												}elseif($isi['iappqc']==2 && $isi['iappqa']==2 ){
																													$sql_soi_mikro = "SELECT * FROM plc2.plc2_upb 
																																	WHERE iupb_id NOT IN (SELECT f.iupb_id FROM plc2.plc2_upb_mikro_fg f 
																																	  WHERE f.iappqa = 0 AND f.ldeleted = 0) 
																																	  AND iupb_id IN (SELECT f.iupb_id FROM plc2.plc2_upb_soi_fg f 
																																	WHERE f.iappqc = 2 
																																		AND f.ldeleted = 0)
																																		AND iappdireksi = 2
																																		AND ihold = 0
																																		AND ispekpd =2
																																		AND ispekqa = 2
																																		AND iupb_id ='".$iupb_id."'";
																													$isi = $this->db_plc0->query($sql_soi_mikro)->row_array();
																													$sql_soi_mikro = "SELECT * FROM plc2.plc2_upb_mikro_fg INNER JOIN plc2.plc2_upb ON plc2_upb_mikro_fg.iupb_id = plc2.plc2_upb.iupb_id  WHERE plc2_upb_mikro_fg.ldeleted = 0 AND plc2_upb.ihold = 0 AND plc2_upb.`iupb_id` ='".$iupb_id."'";
																													$isi2 = $this->db_plc0->query($sql_soi_mikro)->row_array();
																													if($isi && $isi2){
																														if($isi2['iappqa']==1){
																															$row_array['box'] = '19';
																															$row_array['status'] = 'Rejected PD';
																															$row_array['status1'] = '';
																														}elseif($isi2['iappqa']==2){
																															$sql_approval_hpp = "SELECT plc2_hpp.vnip_apppd,plc2_hpp.vnip_appfa,plc2_hpp.vnip_appbd,plc2_hpp.vnip_appdir FROM plc2.plc2_upb_formula 
																																			INNER JOIN plc2.plc2_upb ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id 
																																			LEFT JOIN plc2.plc2_hpp  ON plc2_upb_formula.ifor_id = plc2.plc2_hpp.ifor_id 
																																			WHERE plc2_upb_formula.ibest =2 
																																			AND plc2_upb_formula.vbest_nip_apppd !=''
																																			AND plc2_upb_formula.ldeleted = 0
																																			AND ((plc2_upb_formula.iupb_id IN 
																																							(SELECT soi.iupb_id FROM plc2.plc2_upb_soi_fg soi 
																																								INNER JOIN plc2.plc2_upb u ON u.iupb_id=soi.iupb_id
																																								WHERE soi.iappqa=2 AND soi.itype=1 AND u.iuji_mikro=1))
																																					OR
																																					(plc2_upb_formula.iupb_id IN 
																																							(SELECT soi.iupb_id FROM plc2.plc2_upb_mikro_fg soi 
																																								INNER JOIN plc2.plc2_upb u ON u.iupb_id=soi.iupb_id
																																								WHERE soi.iappqa=2 AND soi.itype=1 AND u.iuji_mikro=2)))
																																			AND plc2_upb.iupb_id  ='".$iupb_id."'";
																															$isi = $this->db_plc0->query($sql_approval_hpp)->row_array();
																															if($isi['vnip_apppd']=='' && $isi['vnip_appfa']=='' && $isi['vnip_appbd']=='' && $isi['vnip_appdir']==''){
																																$row_array['box'] = '20';
																																$row_array['status'] = 'Waiting update & Approval PD';
																																$row_array['status1'] = $pd;
																															}elseif($isi['vnip_apppd']!='' && $isi['vnip_appfa']=='' && $isi['vnip_appbd']=='' && $isi['vnip_appdir']==''){
																																$row_array['box'] = '20';
																																$row_array['status'] = 'Waiting update & Approval FA';
																																$row_array['status1'] = $fa;
																															}elseif($isi['vnip_apppd']!='' && $isi['vnip_appfa']!='' && $isi['vnip_appbd']=='' && $isi['vnip_appdir']==''){
																																$row_array['box'] = '20';
																																$row_array['status'] = 'Waiting update & Approval Busdev';
																																$row_array['status1'] = $busdev;
																															}elseif($isi['vnip_apppd']!='' && $isi['vnip_appfa']!='' && $isi['vnip_appbd']!='' && $isi['vnip_appdir']==''){
																																$row_array['box'] = '20';
																																$row_array['status'] = 'Waiting  Approval Direksi';
																																$row_array['status1'] = '';
																															}elseif($isi['vnip_apppd']!='' && $isi['vnip_appfa']!=''  && $isi['vnip_appdir']!='' || $isi['vnip_appbd']==''){
																																$sql_basic_formula = "SELECT *  FROM plc2.plc2_upb_formula 
																																					  INNER JOIN plc2.plc2_upb  ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id 
																																						AND plc2_upb_formula.ibest = 2 
																																						AND plc2_upb_formula.vbest_nip_apppd IS NOT NULL 
																																						AND plc2_upb.ihold = 0 
																																						AND plc2_upb.ihpp = 2 
																																						AND plc2_upb_formula.ldeleted = 0 
																																						AND plc2_upb_formula.ifor_id IN 
																																						(SELECT 
																																						  hp.ifor_id 
																																						FROM
																																						  plc2.plc2_hpp hp 
																																						WHERE hp.vnip_appdir IS NOT NULL)
																																						AND plc2_upb_formula.`iupb_id`='".$iupb_id."'";
																																$isi = $this->db_plc0->query($sql_basic_formula)->row_array();
																																if(empty($isi)){
																																	$row_array['box'] = '21';
																																	$row_array['status'] = 'Keluar Jalur basic formula';
																																	$row_array['status1'] = '';
																																
																																}else{
																																	if($isi['iapppd_basic']==0){
																																		$row_array['box'] = '21';
																																		$row_array['status'] = 'Waiting input PD';
																																		$row_array['status1'] = $pd;
																																	}else{
																																		$sql_bahan_kemas = "SELECT plc2_upb_bahan_kemas.`iapppd`, plc2_upb_bahan_kemas.`iappqa`,plc2_upb_bahan_kemas.`iappbd` from plc2.plc2_upb_bahan_kemas 
																																							INNER JOIN plc2.plc2_upb ON plc2_upb_bahan_kemas.`iupb_id` = plc2_upb.`iupb_id` 
																																							WHERE plc2_upb_bahan_kemas.ldeleted = 0 
																																							  AND plc2_upb.ihold = 0
																																							  AND plc2_upb.`iupb_id`  ='".$iupb_id."'";
																																		$isi = $this->db_plc0->query($sql_bahan_kemas)->row_array();
																																		if(empty($isi)){
																																			$row_array['box'] = '22';
																																			$row_array['status'] = 'Waiting input PD';
																																			$row_array['status1'] = $pd;
																																		}else{
																																			if($isi['iapppd']== 0 && $isi['iappqa']== 0 &&$isi['iappbd']== 0){
																																				$row_array['box'] = '22';
																																				$row_array['status'] = 'Waiting Approval PD';
																																				$row_array['status1'] = $pd;
																																			}elseif($isi['iapppd']==1 && $isi['iappqa']== 0 &&$isi['iappbd']== 0){
																																				$row_array['box'] = '22';
																																				$row_array['status'] = 'Reject PD';
																																				$row_array['status1'] = $pd;
																																			}elseif($isi['iapppd']==2 && $isi['iappqa']== 0 &&$isi['iappbd']== 0){
																																				$row_array['box'] = '22';
																																				$row_array['status'] = 'Waiting Approval BD';
																																				$row_array['status1'] = $bd;
																																			}elseif($isi['iapppd']==2 && $isi['iappqa']== 0 &&$isi['iappbd']== 1){
																																				$row_array['box'] = '22';
																																				$row_array['status'] = 'Reject BD';
																																				$row_array['status1'] = '';
																																			}elseif($isi['iapppd']==2 && $isi['iappqa']== 0 &&$isi['iappbd']== 2){
																																				$row_array['box'] = '22';
																																				$row_array['status'] = 'Waiting Approval QA';
																																				$row_array['status1'] = $qa;
																																			}elseif($isi['iapppd']==2 && $isi['iappqa']== 1 &&$isi['iappbd']== 2){
																																				$row_array['box'] = '22';
																																				$row_array['status'] = 'Rejected QA';
																																				$row_array['status1'] = '';
																																			}elseif($isi['iapppd']==2 && $isi['iappqa']== 2 &&$isi['iappbd']== 2){
																																				$sql_mbr = "SELECT plc2_upb_buat_mbr.iapppd_bm FROM
																																							  plc2.plc2_upb_formula 
																																							  INNER JOIN plc2.plc2_upb 
																																								ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id 
																																							  LEFT JOIN plc2.plc2_upb_buat_mbr 
																																								ON plc2_upb_buat_mbr.ifor_id = plc2_upb_formula.ifor_id 
																																							 WHERE plc2_upb_formula.ldeleted = 0
																																							 AND plc2.plc2_upb_formula.ibest = 2
																																							 AND plc2_upb_formula.iupb_id IN (SELECT bk.iupb_id FROM plc2.plc2_upb_bahan_kemas bk WHERE bk.iappbd=2)
																																							 AND plc2_upb.ihold = 0
																																							 AND plc2_upb.iupb_id ='".$iupb_id."'";
																																				$isi = $this->db_plc0->query($sql_mbr)->row_array();
																																				if($isi['iapppd_bm']==''){
																																					$row_array['box'] = '23';
																																					$row_array['status'] = 'Waiting Approval PD';
																																					$row_array['status1'] = $pd;
																																				
																																				}elseif($isi['iapppd_bm']==2){
																																					$sql_prareg = "SELECT * FROM plc2.plc2_upb 
																																									WHERE plc2_upb.iappdireksi = 2 
																																									  AND plc2_upb.ldeleted = 0 
																																									  AND iupb_id IN (SELECT pd.iupb_id FROM plc2.plc2_upb_prioritas_detail pd 
																																										INNER JOIN plc2.plc2_upb_prioritas pr 
																																										ON pr.iprioritas_id = pd.iprioritas_id 
																																										WHERE pd.ldeleted = 0 
																																										AND pr.iappbusdev = 2) 
																																										AND iupb_id IN (SELECT f.iupb_id FROM plc2.plc2_upb_formula f 
																																										WHERE f.ibest = 2 AND f.ldeleted = 0)
																																									 AND  iupb_id ='".$iupb_id."'";
																																					$isi = $this->db_plc0->query($sql_prareg)->row_array();
																																					if($isi['iappbusdev_prareg']==0){
																																						$row_array['box'] = '26';
																																						$row_array['status'] = 'Waiting Approval BD';
																																						$row_array['status1'] = $pd;
																																					}if($isi['iappbusdev_prareg']==2){
																																						$sql_set_prareg = "SELECT * FROM plc2.plc2_upb_prioritas a INNER JOIN plc2.`plc2_upb_prioritas_detail` b ON a.`iprioritas_id` = b.`iprioritas_id` WHERE a.ldeleted = 0 and b.iupb_id ='".$iupb_id."'";
																																						$isi = $this->db_plc0->query($sql_set_prareg)->row_array();
																																						if(empty($isi)){
																																							$row_array['box'] = '27';
																																							$row_array['status'] = 'Waiting Input update BD';
																																							$row_array['status1'] = $busdev;
																																						
																																						}else{
																																							if($isi['iappbusdev']==0){
																																								$row_array['box'] = '27';
																																								$row_array['status'] = 'Waiting Approval BD';
																																								$row_array['status1'] = $busdev;
																																							}elseif($isi['iappbusdev']==2){
																																								$sql_set_prareg = "SELECT * FROM plc2.plc2_upb WHERE plc2_upb.iappdireksi = 2 AND iupb_id IN (SELECT pd.iupb_id FROM plc2.plc2_upb_prioritas_reg_detail pd 
																																													INNER JOIN plc2.plc2_upb_prioritas_reg pr ON pr.iprioritas_id=pd.iprioritas_id WHERE pd.ldeleted=0 AND pr.iappbusdev=2 ) AND iupb_id='".$iupb_id."'";
																																								$isi = $this->db_plc0->query($sql_set_prareg)->row_array();
																																								if($isi['iappbusdev_registrasi']==0){
																																									$row_array['box'] = '28';
																																									$row_array['status'] = 'Waiting Approval BD';
																																									$row_array['status1'] = $busdev;
																																								
																																								}elseif($isi['iappbusdev_registrasi']==1){
																																									$row_array['box'] = '28';
																																									$row_array['status'] = 'Rejected BD';
																																									$row_array['status1'] = '';
																																								
																																								}elseif($isi['iappbusdev_registrasi']==2){
																																									$row_array['box'] = '29';
																																									$row_array['status'] = 'Launching Produk';
																																									$row_array['status1'] = '';
																																								
																																								}
																																							}
																																						
																																						}
																																					}
																																	
																																				}
																																			}
																																		}
																																		
																																	
																																	}
																																}
																															}else{
																																	$row_array['box'] = '21';
																																	$row_array['status'] = 'Keluar Jalur';
																																	$row_array['status1'] = '';
																																
																																}
																															
																														}
																													}elseif($isi){
																														$row_array['box'] = '19';
																														$row_array['status'] = 'Waiting input New QA';
																														$row_array['status1'] = '';
																													}elseif($isi2){
																														$row_array['box'] = '19';
																														$row_array['status'] = 'Waiting Approval QA';
																														$row_array['status1'] = '';
																													
																													}
																													
																												}
																											}
																										}
																									}
																								}elseif($isi_stabilita['iapppd']==0){
																									$row_array['box'] = '15';
																									$row_array['status'] = 'Waiting Approval PD';
																									$row_array['status1'] = $isi_stabilita['iapppd'];
																									}
																								else{
																									$row_array['box'] = '15';
																									$row_array['status'] = 'testing PD';
																									$row_array['status1'] = '';
																								
																								}
																							}
																						}
																					}
																				}
																				
																			}
																		}
																		//end street test
																		
																	}
																}
																
															}
															
														}else{
															$row_array['box'] = '10';
															$row_array['status'] = 'Waiting input PD - AD';
															$row_array['status1'] = '';
														}
													}elseif($isi){
														
															$row_array['box'] = '10';
															$row_array['status'] = 'Waiting input PD - AD';
															$row_array['status1'] = '';
													}elseif($isi2){
														if($isi2['iappqc']==0){
															$row_array['box'] = '10';
															$row_array['status'] = 'Waiting Approval QC';
															$row_array['status1'] = '';
														}
													
													}
												}
											}
											
										
											
										}elseif(empty($isi)){
											$row_array['box'] = '7';
											$row_array['status'] = 'Waiting Input Penerimaan Sample oleh Originator';
											$row_array['status1'] = '';
										}
										
									}elseif(empty($isi)){
										$row_array['box'] = '5';
										$row_array['status'] = 'Waiting Input Purchasing';
										$row_array['status1'] = '';
									}
									
								
								}
					
							}else{
								$row_array['box'] = '4';
								$row_array['status'] = 'Waiting Input Permintaan sample Oleh PD';
								$row_array['status1'] = '';
							
							}	
					}
					else
					{
						//untuk ke input sample originator
						$sql_iupb_id = "SELECT * FROM plc2.plc2_upb_date_sample ds WHERE ds.iupb_id = '".$iupb_id."'";
						$isi = $this->db_plc0->query($sql_iupb_id)->row_array();
						if(empty($isi)){
							$row_array['box'] = '3';
							$row_array['status'] = 'Waiting Input Permintaan input sample originator oleh Busdev';
							$row_array['status1'] = $busdev;
						}
						elseif($isi['cPengirimBD'] ==''){
							$row_array['box'] = '3';
							$row_array['status'] = 'Waiting Input Permintaan input sample originator oleh Busdev';
							$row_array['status1'] = $busdev;
						}elseif($isi['cPenerimaPD'] ==''){
							$row_array['box'] = '3';
							$row_array['status'] = 'Waiting Input Permintaan input sample originator oleh Product Development';
							$row_array['status1'] = $pd;
						}elseif($isi['cPenerimaAD'] ==''){
							$row_array['box'] = '3';
							$row_array['status'] = 'Waiting Input Permintaan input sample originator oleh AD';
							$row_array['status1'] = $pd;
						}elseif($isi['cPenerimaQC'] ==''){
							$row_array['box'] = '3';
							$row_array['status'] = 'Waiting Input Permintaan input sample originator oleh QC';
							$row_array['status1'] = $qc;
						}else{
							//permintaan sample
							$sql_permintaan_sample = "SELECT * FROM plc2.plc2_upb WHERE plc2.plc2_upb.iupb_id IN (SELECT pd.iupb_id FROM plc2.plc2_upb_prioritas_detail pd 
													INNER JOIN plc2.plc2_upb_prioritas pr ON pr.iprioritas_id=pd.iprioritas_id
											WHERE pd.ldeleted=0 AND pr.iappbusdev=2 ) AND iupb_id = '".$iupb_id."'";
							$isi = $this->db_plc0->query($sql_permintaan_sample)->row_array();
							if($isi){	
								$sql_permintaan_sample2 = "SELECT * FROM plc2.plc2_upb_request_sample a left JOIN plc2.plc2_upb b ON a.iupb_id = b.iupb_id WHERE a.iupb_id ='".$iupb_id."'";
								$isi = $this->db_plc0->query($sql_permintaan_sample2)->row_array();
								if(empty($isi)){
									$row_array['box'] = '4';
									$row_array['status'] = 'Waiting Approval  PD';
									$row_array['status1'] = $pd;
								}
								elseif($isi['iapppd']==0){
									$row_array['box'] = '4';
									$row_array['status'] = 'Waiting Approval  PD';
									$row_array['status1'] = $pd;
								
								}elseif($isi['iapppd']==1){
									$row_array['box'] = '4';
									$row_array['status'] = 'Waiting Approval PD';
									$row_array['status1'] = $pd;
								
								}else{
									$sql_po_sample = "SELECT * FROM plc2.plc2_upb_po  p LEFT JOIN  plc2.plc2_upb_po_detail z ON p.`ipo_id` = z.`ipo_id` WHERE z.`ireq_id` = '".$isi['ireq_id']."'";
									$isi = $this->db_plc0->query($sql_po_sample)->row_array();
									if(empty($isi)){
										$row_array['box'] = '5';
										$row_array['status'] = 'Waiting Approval  Purchasing';
										$row_array['status1'] = $pr;
									}
									if($isi['iapppr']==0){
										$row_array['box'] = '5';
										$row_array['status'] = 'Waiting Approval Purchasing';
										$row_array['status1'] = $pr;
									}elseif($isi['iapppr']==1){
										$row_array['box'] = '5';
										$row_array['status'] = 'Reject Purchasing';
										$row_array['status1'] = '';
									}elseif($isi['iapppr']==2){
										$isi2= $isi['ireq_id'];
										$sql_po_sample = "SELECT * FROM plc2.plc2_upb_ro  p LEFT JOIN  plc2.plc2_upb_ro_detail z ON p.`ipo_id` = z.`ipo_id` WHERE z.`ireq_id` = '".$isi['ireq_id']."'";
										$isi = $this->db_plc0->query($sql_po_sample)->row_array();
										if($isi['iapppr']==0){
											$row_array['box'] = '6';
											$row_array['status'] = 'Waiting Approval Purchasing';
											$row_array['status1'] = $pr;
										}elseif($isi['iapppr']==1){
											$row_array['box'] = '6';
											$row_array['status'] = 'Reject Purchasing';
											$row_array['status1'] = '';
										}elseif($isi['iapppr']==2){
											$sql_po_sample = "SELECT * FROM plc2.plc2_upb_ro_detail a INNER JOIN plc2.plc2_upb_request_sample b ON a.`ireq_id` = b.`ireq_id` WHERE a.`ireq_id` = '".$isi2."'";
											$isi = $this->db_plc0->query($sql_po_sample)->row_array();
											if(($isi['vrec_nip_pd']=='') && ($isi['vrec_nip_qc']=='')){
												$row_array['box'] = '7';
												$row_array['status'] = 'Waiting input PD';
												$row_array['status1'] = $pd;
											}elseif($isi['vrec_nip_pd']!='' && $isi['vrec_nip_qc']!='' && $isi['vrec_nip_qa']==''){
												$row_array['box'] = '7';
												$row_array['status'] = 'Waiting input QA Mikro';
												$row_array['status1'] = $qa;
											}elseif(($isi['iapppd_analisa']=='')){
												$row_array['box'] = '8';
												$row_array['status'] = 'Waiting Approval PD ';
												$row_array['status1'] = $pd;
											}elseif(($isi['iapppd_analisa']==1)){
												$row_array['box'] = '8';
												$row_array['status'] = 'Rejected PD ';
												$row_array['status1'] = '';
											}elseif(($isi['iapppd_analisa']==2)){
												$sql_release_bb = "SELECT * FROM plc2.plc2_upb_ro_detail a INNER JOIN plc2.plc2_upb_request_sample b ON a.`ireq_id` = b.`ireq_id` JOIN plc2.plc2_upb_ro c ON a.`iro_id` = c.`iro_id` JOIN plc2.plc2_upb d ON b.`iupb_id` = d.`iupb_id` WHERE d.`iupb_id`='".$iupb_id."'";
												$isi = $this->db_plc0->query($sql_release_bb)->row_array();
												if(($isi['iapppd_rls']=='') || empty($isi['iapppd_rls'])){
													$row_array['box'] = '9';
													$row_array['status'] = 'Waiting Approval PD';
													$row_array['status1'] = $pd;
												}elseif($isi['iapppd_rls']==1){
													$row_array['box'] = '9';
													$row_array['status'] = 'Reject PD';
													$row_array['status1'] = '';
												}
												elseif($isi['iapppd_rls']==2){
													$sql_cek_soi_bb= "SELECT * FROM plc2.plc2_upb  WHERE iupb_id NOT IN (SELECT f.iupb_id FROM plc2.plc2_upb_soi_bahanbaku f WHERE f.iappqc=0 AND f.ldeleted=0) AND iupb_id IN 
													(
														SELECT rs.iupb_id FROM plc2.plc2_upb_request_sample rs 
															INNER JOIN plc2.plc2_upb_ro_detail rod ON rod.ireq_id=rs.ireq_id
														WHERE rs.iapppd=2 AND rs.ldeleted=0 AND rod.irelease=2 AND rod.iapppd_rls=2 AND rod.ldeleted=0
													) AND iappdireksi =2  AND ihold=0 and iupb_id='".$iupb_id."'";
													$sql_soi_bb ="SELECT * FROM plc2.`plc2_upb_soi_bahanbaku` WHERE iupb_id ='".$iupb_id."'";
													$isi2 = $this->db_plc0->query($sql_soi_bb)->row_array();
													$isi = $this->db_plc0->query($sql_cek_soi_bb)->row_array();
													if($isi && $isi2){
														if($isi2['iappqc']==1){
															$row_array['box'] = '10';
															$row_array['status'] = 'Rejected QC';
															$row_array['status1'] = $qc;
														}
														elseif($isi2['iappqc']==2){
															if($isi2['iappqa']==0){
																$row_array['box'] = '10';
																$row_array['status'] = 'Waiting Approval QA';
																$row_array['status1'] = $qa;
															}elseif($isi2['iappqa']==1){
																$row_array['box'] = '10';
																$row_array['status'] = 'Reject QA';
																$row_array['status1'] = '';
															}elseif($isi2['iappqa']==2){
																$sql_fomula_st = "SELECT * FROM plc2.plc2_upb_formula a INNER JOIN plc2.`plc2_upb` b ON a.`iupb_id` = b.`iupb_id` WHERE a.`iupb_id`='".$iupb_id."'";
																$isi = $this->db_plc0->query($sql_fomula_st)->row_array();
															
																if(empty($isi)){
																	$row_array['box'] = '11';
																	$row_array['status'] = 'Waiting Input PD- AD';
																	$row_array['status1'] = $pd;
																}elseif($isi){
																	if($isi['iformula_apppd']==0){
																		$row_array['box'] = '11';
																		$row_array['status'] = 'Waiting Approval PD ';
																		$row_array['status1'] = $pd;
																	}elseif($isi['iformula_apppd']==1){
																		$row_array['box'] = '11';
																		$row_array['status'] = 'Reject PD';
																		$row_array['status1'] = '';
																	}elseif($isi['iformula_apppd']==2){
																			//untuk lanjut ke Street Test
																		$sql_street_test = "SELECT * from plc2.plc2_upb_formula INNER JOIN plc2.plc2_upb  ON plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id 
																							WHERE plc2_upb_formula.ldeleted = 0 
																							  AND plc2_upb_formula.iwithstress = 1
																							  AND plc2_upb_formula.istress = 2 
																							  AND plc2_upb.ihold = 0
																							  AND plc2_upb_formula.iformula_apppd = 2
																							  AND plc2_upb_formula.`iupb_id` ='".$iupb_id."'";
																		$isi = $this->db_plc0->query($sql_street_test)->row_array();
																		if($isi){
																			if($isi['istress_apppd']==0){
																				$row_array['box'] = '12';
																				$row_array['status'] = 'Waiting Approval PD';
																				$row_array['status1'] = $pd;
																			}elseif($isi['istress_apppd']==1){
																				$row_array['box'] = '12';
																				$row_array['status'] = 'Rejected PD';
																				$row_array['status1'] = '';
																			}elseif($isi['istress_apppd']==2){
																				$sql_skala_lab = "SELECT * from plc2.plc2_upb_formula INNER JOIN plc2.plc2_upb  ON plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id 
																							WHERE plc2_upb_formula.ldeleted = 0 
																							  AND plc2_upb.ihold = 0
																							  AND plc2_upb_formula.iformula_apppd = 2
																							  AND plc2_upb_formula.`iupb_id` ='".$iupb_id."'";
																				$isi = $this->db_plc0->query($sql_skala_lab)->row_array();
																				if($isi['ilab_apppd']==0){
																					$row_array['box'] = '13';
																					$row_array['status'] = 'Waiting Update PD pada Formula Skala Lab';
																					$row_array['status1'] = '';
																				}elseif($isi['ilab_apppd']==2){
																					$sql_approval_ksk = "SELECT * from plc2.plc2_upb_ro_detail a 
																										INNER JOIN plc2.plc2_raw_material b ON a.`raw_id` = b.`raw_id` 
																										  JOIN plc2.plc2_upb_ro c ON c.`iro_id` = a.`iro_id` 
																										  JOIN plc2.plc2_upb_po d ON d.`ipo_id` = a.`ipo_id` 
																										  JOIN plc2.plc2_upb_request_sample e ON e.`ireq_id` = a.`ireq_id` 
																										  JOIN plc2.plc2_upb f ON e.`iupb_id` = f.`iupb_id` 
																										WHERE a.`ldeleted` = 0 
																										  AND c.`iclose_po` = 1 
																										  AND a.`vrec_jum_pd` IS NOT NULL 
																										  AND a.`iapppd_analisa` = 2 
																										  AND f.`ihold` = 0 
																										  AND f.`iupb_id` = '".$iupb_id."'";
																					$isi = $this->db_plc0->query($sql_approval_ksk)->row_array();
																					if($isi){
																						if($isi['iappmoa']==0 && $isi['iappqa_ksk']==0  ){
																							$row_array['box'] = '14';
																							$row_array['status'] = 'Waiting input - update PD';
																							$row_array['status1'] = $pd;
																						}elseif($isi['iappmoa']!=0 && $isi['vcoa']=='' && $isi['iappqa_ksk']==0   ){
																							$row_array['box'] = '14';
																							$row_array['status'] = 'input update  Purchasing';
																							$row_array['status1'] = $pr;
																						}elseif($isi['iappmoa']!=0 && $isi['vcoa']!='' && $isi['iresult']==0 && $isi['iappqa_ksk']==0 ){
																							$row_array['box'] = '14';
																							$row_array['status'] = 'Waiting Approval QA';
																							$row_array['status1'] = $qa;
																						}elseif($isi['iappmoa']!=0 && $isi['vcoa']!='' && $isi['iresult']==0 && $isi['iappqa_ksk']==1){
																							$row_array['box'] = '14';
																							$row_array['status'] = 'Rejected QA';
																							$row_array['status1'] = '';
																						}
																						elseif($isi['iappmoa']!=0 && $isi['vcoa']!='' && $isi['iresult']==1 && $isi['iappqa_ksk']==1  ){
																							$row_array['box'] = '14';
																							$row_array['status'] = 'Tidak DIsetujui oleh QA <br>Dan Rejected QA';
																							$row_array['status1'] = $qa;
																						}elseif($isi['iappmoa']!=0 && $isi['vcoa']!='' && $isi['iresult']==2 && $isi['iappqa_ksk']==0){
																							$row_array['box'] = '14';
																							$row_array['status'] = 'DIsetujui oleh QA <br> waiting Approval QA';
																							$row_array['status1'] = $qa;
																						}elseif($isi['iappmoa']!=0 && $isi['vcoa']!='' && $isi['iresult']==2 && $isi['iappqa_ksk']==2){
																							$sql_stabilita_lab = "SELECT plc2_upb_stabilita.iapppd FROM plc2.plc2_upb_stabilita 
																													LEFT JOIN plc2.plc2_upb_formula ON plc2_upb_stabilita.ifor_id = plc2.plc2_upb_formula.ifor_id 
																													LEFT JOIN plc2.plc2_upb ON plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id 
																													WHERE plc2_upb_stabilita.ldeleted = 0 
																													 AND plc2.plc2_upb_stabilita.inumber = 
																													 (SELECT 
																														MAX(st2.inumber) 
																													  FROM
																														plc2.plc2_upb_stabilita st2 
																													  WHERE plc2_upb_stabilita.ifor_id = st2.ifor_id) 
																													  AND plc2_upb.`iupb_id` ='".$iupb_id."'";
																							$isi_stabilita = $this->db_plc0->query($sql_stabilita_lab)->row_array();
																							if(empty($isi_stabilita)){
																								$row_array['box'] = '15';
																								$row_array['status'] = 'Waiting input new PD - AD';
																								$row_array['status1'] = $pd;
																							}elseif($isi_stabilita){
																								if($isi_stabilita['iapppd']==2){
																									$sql_best_formula = "SELECT f.ifor_id, f.vkode_surat,f.vbest_nip_apppd,f.tbest_apppd FROM plc2.plc2_upb_formula f WHERE f.ifor_id IN 
																														(SELECT st.ifor_id FROM plc2.plc2_upb_stabilita st 
																															WHERE st.inumber=6 AND st.isucced=2 AND st.iapppd=2) AND f.iupb_id='".$iupb_id."'";
																									$isi = $this->db_plc0->query($sql_best_formula)->row_array();
																									if($isi['vbest_nip_apppd']=='' || empty($isi['vbest_nip_apppd'])){
																										$row_array['box'] = '16';
																										$row_array['status'] = 'Waiting Approval PD';
																										$row_array['status1'] = $pd;
																									
																									}else{
																										$sql_spek_soi = "SELECT * FROM plc2.plc2_upb_spesifikasi_fg INNER JOIN plc2.plc2_upb ON plc2_upb_spesifikasi_fg.iupb_id = plc2.plc2_upb.iupb_id  WHERE plc2_upb_spesifikasi_fg.ldeleted = 0 AND plc2_upb.ihold = 0 AND plc2_upb.`iupb_id` ='".$iupb_id."'";
																										$isi = $this->db_plc0->query($sql_spek_soi)->row_array();
																										if(empty($isi)){
																											$row_array['box'] = '17';
																											$row_array['status'] = 'Waiting Input new PD - AD';
																											$row_array['status1'] = $pd;
																										}else{
																											if($isi['iapppd']==0){
																												$row_array['box'] = '17';
																												$row_array['status'] = 'Waiting Approval PD - AD';
																												$row_array['status1'] = $pd;
																											}elseif($isi['iapppd']==2 && $isi['iappqa']==0 ){
																												$row_array['box'] = '17';
																												$row_array['status'] = 'Waiting Approval QA';
																												$row_array['status1'] = $pd;
																											}elseif($isi['iapppd']==1 && $isi['iappqa']==0 ){
																												$row_array['box'] = '17';
																												$row_array['status'] = 'Rejected PD';
																												$row_array['status1'] = '';
																											}elseif($isi['iapppd']==2 && $isi['iappqa']==2 ){
																												$sql_spek_soi = "SELECT * FROM plc2.plc2_upb_soi_fg INNER JOIN plc2.plc2_upb ON plc2_upb_soi_fg.iupb_id = plc2.plc2_upb.iupb_id  WHERE plc2_upb_soi_fg.ldeleted = 0 AND plc2_upb.ihold = 0 AND plc2_upb.`iupb_id` ='".$iupb_id."'";
																												$isi = $this->db_plc0->query($sql_spek_soi)->row_array();
																												if(empty($isi)){
																													$row_array['box'] = '18';
																													$row_array['status'] = 'Waiting Input new PD - AD';
																													$row_array['status1'] = $pd;
																												}elseif($isi['iappqc']==0){
																													$row_array['box'] = '18';
																													$row_array['status'] = 'Waiting Approval PD - AD';
																													$row_array['status1'] = $pd;
																												}elseif($isi['iappqc']==1){
																													$row_array['box'] = '18';
																													$row_array['status'] = 'Reject PD - AD';
																													$row_array['status1'] = '';
																												}elseif($isi['iappqc']==2 && $isi['iappqa']==0 ){
																													$row_array['box'] = '18';
																													$row_array['status'] = 'Waiting approval QA';
																													$row_array['status1'] = $qa;
																												}elseif($isi['iappqc']==2 && $isi['iappqa']==1 ){
																													$row_array['box'] = '18';
																													$row_array['status'] = 'Rejected QA';
																													$row_array['status1'] = '';
																												}elseif($isi['iappqc']==2 && $isi['iappqa']==2 ){
																													$sql_soi_mikro = "SELECT * FROM plc2.plc2_upb 
																																	WHERE iupb_id NOT IN (SELECT f.iupb_id FROM plc2.plc2_upb_mikro_fg f 
																																	  WHERE f.iappqa = 0 AND f.ldeleted = 0) 
																																	  AND iupb_id IN (SELECT f.iupb_id FROM plc2.plc2_upb_soi_fg f 
																																	WHERE f.iappqc = 2 
																																		AND f.ldeleted = 0)
																																		AND iappdireksi = 2
																																		AND ihold = 0
																																		AND ispekpd =2
																																		AND ispekqa = 2
																																		AND iupb_id ='".$iupb_id."'";
																													$isi = $this->db_plc0->query($sql_soi_mikro)->row_array();
																													$sql_soi_mikro = "SELECT * FROM plc2.plc2_upb_mikro_fg INNER JOIN plc2.plc2_upb ON plc2_upb_mikro_fg.iupb_id = plc2.plc2_upb.iupb_id  WHERE plc2_upb_mikro_fg.ldeleted = 0 AND plc2_upb.ihold = 0 AND plc2_upb.`iupb_id` ='".$iupb_id."'";
																													$isi2 = $this->db_plc0->query($sql_soi_mikro)->row_array();
																													if($isi && $isi2){
																														if($isi2['iappqa']==1){
																															$row_array['box'] = '19';
																															$row_array['status'] = 'Rejected PD';
																															$row_array['status1'] = '';
																														}elseif($isi2['iappqa']==2){
																															$sql_approval_hpp = "SELECT plc2_hpp.vnip_apppd,plc2_hpp.vnip_appfa,plc2_hpp.vnip_appbd,plc2_hpp.vnip_appdir FROM plc2.plc2_upb_formula 
																																			INNER JOIN plc2.plc2_upb ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id 
																																			LEFT JOIN plc2.plc2_hpp  ON plc2_upb_formula.ifor_id = plc2.plc2_hpp.ifor_id 
																																			WHERE plc2_upb_formula.ibest =2 
																																			AND plc2_upb_formula.vbest_nip_apppd !=''
																																			AND plc2_upb_formula.ldeleted = 0
																																			AND ((plc2_upb_formula.iupb_id IN 
																																							(SELECT soi.iupb_id FROM plc2.plc2_upb_soi_fg soi 
																																								INNER JOIN plc2.plc2_upb u ON u.iupb_id=soi.iupb_id
																																								WHERE soi.iappqa=2 AND soi.itype=1 AND u.iuji_mikro=1))
																																					OR
																																					(plc2_upb_formula.iupb_id IN 
																																							(SELECT soi.iupb_id FROM plc2.plc2_upb_mikro_fg soi 
																																								INNER JOIN plc2.plc2_upb u ON u.iupb_id=soi.iupb_id
																																								WHERE soi.iappqa=2 AND soi.itype=1 AND u.iuji_mikro=2)))
																																			AND plc2_upb.iupb_id  ='".$iupb_id."'";
																															$isi = $this->db_plc0->query($sql_approval_hpp)->row_array();
																															if($isi['vnip_apppd']=='' && $isi['vnip_appfa']=='' && $isi['vnip_appbd']=='' && $isi['vnip_appdir']==''){
																																$row_array['box'] = '20';
																																$row_array['status'] = 'Waiting update & Approval PD';
																																$row_array['status1'] = $pd;
																															}elseif($isi['vnip_apppd']!='' && $isi['vnip_appfa']=='' && $isi['vnip_appbd']=='' && $isi['vnip_appdir']==''){
																																$row_array['box'] = '20';
																																$row_array['status'] = 'Waiting update & Approval FA';
																																$row_array['status1'] = $fa;
																															}elseif($isi['vnip_apppd']!='' && $isi['vnip_appfa']!='' && $isi['vnip_appbd']=='' && $isi['vnip_appdir']==''){
																																$row_array['box'] = '20';
																																$row_array['status'] = 'Waiting update & Approval Busdev';
																																$row_array['status1'] = $busdev;
																															}elseif($isi['vnip_apppd']!='' && $isi['vnip_appfa']!='' && $isi['vnip_appbd']!='' && $isi['vnip_appdir']==''){
																																$row_array['box'] = '20';
																																$row_array['status'] = 'Waiting  Approval Direksi';
																																$row_array['status1'] = '';
																															}elseif($isi['vnip_apppd']!='' && $isi['vnip_appfa']!=''  && $isi['vnip_appdir']!='' || $isi['vnip_appbd']==''){
																																$sql_basic_formula = "SELECT *  FROM plc2.plc2_upb_formula 
																																					  INNER JOIN plc2.plc2_upb  ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id 
																																						AND plc2_upb_formula.ibest = 2 
																																						AND plc2_upb_formula.vbest_nip_apppd IS NOT NULL 
																																						AND plc2_upb.ihold = 0 
																																						AND plc2_upb.ihpp = 2 
																																						AND plc2_upb_formula.ldeleted = 0 
																																						AND plc2_upb_formula.ifor_id IN 
																																						(SELECT 
																																						  hp.ifor_id 
																																						FROM
																																						  plc2.plc2_hpp hp 
																																						WHERE hp.vnip_appdir IS NOT NULL)
																																						AND plc2_upb_formula.`iupb_id`='".$iupb_id."'";
																																$isi = $this->db_plc0->query($sql_basic_formula)->row_array();
																																if(empty($isi)){
																																	$row_array['box'] = '21';
																																	$row_array['status'] = 'Keluar Jalur basic formula';
																																	$row_array['status1'] = '';
																																
																																}else{
																																	if($isi['iapppd_basic']==0){
																																		$row_array['box'] = '21';
																																		$row_array['status'] = 'Waiting input PD';
																																		$row_array['status1'] = $pd;
																																	}else{
																																		$sql_bahan_kemas = "SELECT plc2_upb_bahan_kemas.`iapppd`, plc2_upb_bahan_kemas.`iappqa`,plc2_upb_bahan_kemas.`iappbd` from plc2.plc2_upb_bahan_kemas 
																																							INNER JOIN plc2.plc2_upb ON plc2_upb_bahan_kemas.`iupb_id` = plc2_upb.`iupb_id` 
																																							WHERE plc2_upb_bahan_kemas.ldeleted = 0 
																																							  AND plc2_upb.ihold = 0
																																							  AND plc2_upb.`iupb_id`  ='".$iupb_id."'";
																																		$isi = $this->db_plc0->query($sql_bahan_kemas)->row_array();
																																		if(empty($isi)){
																																			$row_array['box'] = '22';
																																			$row_array['status'] = 'Waiting input PD';
																																			$row_array['status1'] = $pd;
																																		}else{
																																			if($isi['iapppd']== 0 && $isi['iappqa']== 0 &&$isi['iappbd']== 0){
																																				$row_array['box'] = '22';
																																				$row_array['status'] = 'Waiting Approval PD';
																																				$row_array['status1'] = $pd;
																																			}elseif($isi['iapppd']==1 && $isi['iappqa']== 0 &&$isi['iappbd']== 0){
																																				$row_array['box'] = '22';
																																				$row_array['status'] = 'Reject PD';
																																				$row_array['status1'] = $pd;
																																			}elseif($isi['iapppd']==2 && $isi['iappqa']== 0 &&$isi['iappbd']== 0){
																																				$row_array['box'] = '22';
																																				$row_array['status'] = 'Waiting Approval BD';
																																				$row_array['status1'] = $bd;
																																			}elseif($isi['iapppd']==2 && $isi['iappqa']== 0 &&$isi['iappbd']== 1){
																																				$row_array['box'] = '22';
																																				$row_array['status'] = 'Reject BD';
																																				$row_array['status1'] = '';
																																			}elseif($isi['iapppd']==2 && $isi['iappqa']== 0 &&$isi['iappbd']== 2){
																																				$row_array['box'] = '22';
																																				$row_array['status'] = 'Waiting Approval QA';
																																				$row_array['status1'] = $qa;
																																			}elseif($isi['iapppd']==2 && $isi['iappqa']== 1 &&$isi['iappbd']== 2){
																																				$row_array['box'] = '22';
																																				$row_array['status'] = 'Rejected QA';
																																				$row_array['status1'] = '';
																																			}elseif($isi['iapppd']==2 && $isi['iappqa']== 2 &&$isi['iappbd']== 2){
																																				$sql_mbr = "SELECT plc2_upb_buat_mbr.iapppd_bm FROM
																																							  plc2.plc2_upb_formula 
																																							  INNER JOIN plc2.plc2_upb 
																																								ON plc2_upb_formula.iupb_id = plc2_upb.iupb_id 
																																							  LEFT JOIN plc2.plc2_upb_buat_mbr 
																																								ON plc2_upb_buat_mbr.ifor_id = plc2_upb_formula.ifor_id 
																																							 WHERE plc2_upb_formula.ldeleted = 0
																																							 AND plc2.plc2_upb_formula.ibest = 2
																																							 AND plc2_upb_formula.iupb_id IN (SELECT bk.iupb_id FROM plc2.plc2_upb_bahan_kemas bk WHERE bk.iappbd=2)
																																							 AND plc2_upb.ihold = 0
																																							 AND plc2_upb.iupb_id ='".$iupb_id."'";
																																				$isi = $this->db_plc0->query($sql_mbr)->row_array();
																																				if($isi['iapppd_bm']==''){
																																					$row_array['box'] = '23';
																																					$row_array['status'] = 'Waiting Approval PD';
																																					$row_array['status1'] = $pd;
																																				
																																				}elseif($isi['iapppd_bm']==2){
																																					$sql_prareg = "SELECT * FROM plc2.plc2_upb 
																																									WHERE plc2_upb.iappdireksi = 2 
																																									  AND plc2_upb.ldeleted = 0 
																																									  AND iupb_id IN (SELECT pd.iupb_id FROM plc2.plc2_upb_prioritas_detail pd 
																																										INNER JOIN plc2.plc2_upb_prioritas pr 
																																										ON pr.iprioritas_id = pd.iprioritas_id 
																																										WHERE pd.ldeleted = 0 
																																										AND pr.iappbusdev = 2) 
																																										AND iupb_id IN (SELECT f.iupb_id FROM plc2.plc2_upb_formula f 
																																										WHERE f.ibest = 2 AND f.ldeleted = 0)
																																									 AND  iupb_id ='".$iupb_id."'";
																																					$isi = $this->db_plc0->query($sql_prareg)->row_array();
																																					if($isi['iappbusdev_prareg']==0){
																																						$row_array['box'] = '26';
																																						$row_array['status'] = 'Waiting Approval BD';
																																						$row_array['status1'] = $pd;
																																					}if($isi['iappbusdev_prareg']==2){
																																						$sql_set_prareg = "SELECT * FROM plc2.plc2_upb_prioritas a INNER JOIN plc2.`plc2_upb_prioritas_detail` b ON a.`iprioritas_id` = b.`iprioritas_id` WHERE a.ldeleted = 0 and b.iupb_id ='".$iupb_id."'";
																																						$isi = $this->db_plc0->query($sql_set_prareg)->row_array();
																																						if(empty($isi)){
																																							$row_array['box'] = '27';
																																							$row_array['status'] = 'Waiting Input update BD';
																																							$row_array['status1'] = $busdev;
																																						
																																						}else{
																																							if($isi['iappbusdev']==0){
																																								$row_array['box'] = '27';
																																								$row_array['status'] = 'Waiting Approval BD';
																																								$row_array['status1'] = $busdev;
																																							}elseif($isi['iappbusdev']==2){
																																								$sql_set_prareg = "SELECT * FROM plc2.plc2_upb WHERE plc2_upb.iappdireksi = 2 AND iupb_id IN (SELECT pd.iupb_id FROM plc2.plc2_upb_prioritas_reg_detail pd 
																																													INNER JOIN plc2.plc2_upb_prioritas_reg pr ON pr.iprioritas_id=pd.iprioritas_id WHERE pd.ldeleted=0 AND pr.iappbusdev=2 ) AND iupb_id='".$iupb_id."'";
																																								$isi = $this->db_plc0->query($sql_set_prareg)->row_array();
																																								if($isi['iappbusdev_registrasi']==0){
																																									$row_array['box'] = '28';
																																									$row_array['status'] = 'Waiting Approval BD';
																																									$row_array['status1'] = $busdev;
																																								
																																								}elseif($isi['iappbusdev_registrasi']==1){
																																									$row_array['box'] = '28';
																																									$row_array['status'] = 'Rejected BD';
																																									$row_array['status1'] = '';
																																								
																																								}elseif($isi['iappbusdev_registrasi']==2){
																																									$row_array['box'] = '29';
																																									$row_array['status'] = 'Launching Produk';
																																									$row_array['status1'] = '';
																																								
																																								}
																																							}
																																						
																																						}
																																					}
																																	
																																				}
																																			}
																																		}
																																		
																																	
																																	}
																																}
																															}else{
																																	$row_array['box'] = '21';
																																	$row_array['status'] = 'Keluar Jalur';
																																	$row_array['status1'] = '';
																																
																																}
																															
																														}
																													}elseif($isi){
																														$row_array['box'] = '19';
																														$row_array['status'] = 'Waiting input New QA';
																														$row_array['status1'] = '';
																													}elseif($isi2){
																														$row_array['box'] = '19';
																														$row_array['status'] = 'Waiting Approval QA';
																														$row_array['status1'] = '';
																													
																													}
																													
																												}
																											}
																										}
																									}
																								}elseif($isi_stabilita['iapppd']==0){
																									$row_array['box'] = '15';
																									$row_array['status'] = 'Waiting Approval PD';
																									$row_array['status1'] = $isi_stabilita['iapppd'];
																									}
																								else{
																									$row_array['box'] = '15';
																									$row_array['status'] = 'testing PD';
																									$row_array['status1'] = '';
																								
																								}
																							}
																						}
																					}
																				}
																				
																			}
																		}
																		//end street test
																		
																	}
																}
																
															}
															
														}else{
															$row_array['box'] = '10';
															$row_array['status'] = 'Waiting input PD - AD';
															$row_array['status1'] = '';
														}
													}elseif($isi){
														
															$row_array['box'] = '10';
															$row_array['status'] = 'Waiting input PD - AD';
															$row_array['status1'] = '';
													}elseif($isi2){
														if($isi2['iappqc']==0){
															$row_array['box'] = '10';
															$row_array['status'] = 'Waiting Approval QC';
															$row_array['status1'] = '';
														}
													
													}
												}
											}
											
										
											
										}elseif(empty($isi)){
											$row_array['box'] = '7';
											$row_array['status'] = 'Waiting Input Penerimaan Sample oleh Originator';
											$row_array['status1'] = '';
										}
										
									}elseif(empty($isi)){
										$row_array['box'] = '5';
										$row_array['status'] = 'Waiting Input Purchasing';
										$row_array['status1'] = '';
									}
									
								
								}
					
							}else{
								$row_array['box'] = '4';
								$row_array['status'] = 'Waiting Input Permintaan sample Oleh PD';
								$row_array['status1'] = '';
							
							}
					
						}
						//end permintaan sample
					
					}
				}
			
			}
		}else{
				$row_array['box'] = '0';
				
			}

		array_push($data, $row_array);
	
		return json_encode($data);
		exit;
		
	}
        
   
}
?>
