<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class pk_ts extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
		$this->db_erp_pk = $this->load->database('pk', false,true);
		$this->db_erp_pk = $this->load->database('pk', false,true);
		$this->db_erp_pk = $this->load->database('pk', false,true);
		$this->load->library('lib_utilitas');
		$this->load->library('lib_calc_ts');
		$this->user = $this->auth->user();
		$this->url='pk_ts';
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;

		$grid->setTitle('PK Technical Support');		
		$grid->setTable('pk.pk_master');		
		$grid->setUrl('pk_ts');
		$grid->addList('employee.cNip','employee.vName','position.vDescription','tgl_penilaian','tgl1','tgl2');
		$grid->addFields('lblIntro','lblpro','lbldes','tgl_penilaian','tgl1','rincian_pk');
		
		$grid->setLabel('tgl_penilaian','Tanggal Penilaian');
		$grid ->setWidth('tgl_penilaian', '100'); 

		$grid->setLabel('tgl1','Periode Awal');
		$grid ->setWidth('tgl1', '100'); 
		$grid->setLabel('tgl2','Periode Akhir');
		$grid ->setWidth('tgl2', '100'); 

		$grid->setLabel('Periode','Periode Penilaian');
		
		$grid->setLabel('lblIntro','');
		$grid->setLabel('lbldes','');
		$grid->setLabel('lblpro','formulir');

		$grid->setLabel('employee.cNip','NIP');
		$grid ->setWidth('employee.cNip', '80'); 

		$grid->setLabel('employee.vName','Nama');
		$grid ->setWidth('employee.vName', '150'); 

		$grid->setLabel('position.vDescription','Jabatan');
		$grid ->setWidth('position.vDescription', '250'); 

		$grid->setJoinTable('hrd.employee', 'employee.cNip = pk_master.vnip', 'inner');
		$grid->setJoinTable('hrd.position', 'position.iPostId = employee.iPostId', 'inner');

 
		$data_open = explode(',', $this->open_data());
		if(!in_array($this->user->gNIP, $data_open)){

			$vnip='';
			$rows = $this->listPICNew($this->user->gNIP, date('Y-m-d'));
			foreach ($rows as $kr => $vr) {
				if($kr==0){
					$vnip.="'".$vr["cNip"]."'";
				}else{
					$vnip.=",'".$vr["cNip"]."'";
				}
			}
			$grid->setQuery('pk_master.vnip in ('.$vnip.')',NULL);

		}

		// $vnip='';
		// $rows = $this->listPICNew($this->user->gNIP, date('Y-m-d'));
		// foreach ($rows as $kr => $vr) {
		// 	if($kr==0){
		// 		$vnip.="'".$vr["cNip"]."'";
		// 	}else{
		// 		$vnip.=",'".$vr["cNip"]."'";
		// 	}
		// }
		// $grid->setQuery('pk_master.vnip in ('.$vnip.')',NULL);

		//$grid->setQuery('employee.cNip in (select em.cNip from hrd.employee em where (em.cUpper="'.$this->user->gNIP.'" or em.cNip="'.$this->user->gNIP.'") and em.dresign="0000-00-00")',NULL);

		$grid->setSortBy('tgl_penilaian');
		$grid->setSortOrder('DESC');

		
		$grid->setGridView('grid');
		
		switch ($action) {
			case 'detailsspv':
				echo $this->spv_pm2();
				break;
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				echo $grid->saved_form();
				break;
			case 'download':
				$this->download($this->input->get('file'));
				break;
			case 'delete':
				echo $grid->delete_row();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'getspname':
				echo $this->getSpname();
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
					echo $grid->updated_form();
				break;
			case 'approve':
				echo $this->approve_view();
				break;
			case 'approve_process':
				echo $this->approve_process();
				break;
			case 'reject':
				echo $this->reject_view();
				break;
			case 'reject_process':
				echo $this->reject_process();
				break;
			case 'calculate_all_rincian_hitung':
				$vFunction = $this->input->post('vFunction');
				$mPoin = $this->input->post('mPoin');
				$mCalc = $this->input->post('mCalc');
				$date1 = $this->input->post('date1');
				$date2 = $this->input->post('date2');
				$itim = $this->input->post('itim_id');
				$nippemohon=$this->input->post('nippemohon');
				$periode = '12-2015';
				
				$this->lib_calc_ts->itim = $itim;
				$this->lib_calc_ts->nippemohon = $nippemohon;
				$this->lib_calc_ts->date1 = $date1;
				$this->lib_calc_ts->date2 = $date2;
				$this->lib_calc_ts->periode = $periode;
				
				$calc = $this->lib_calc_ts->setCalc( $vFunction );
				if($calc == $this->lib_calc_ts->error ) {
					echo json_encode(array('message'=>'error'));
				} else {
					if ( $calc['score']=="manual") {
						$score = $mPoin;
						$hasil = $mCalc;
						$is_auto =0;
					}else{
						$score = $calc['score'];
						$hasil = $calc['hasil'];	
						$is_auto=1;
					}
					
					echo json_encode(array('message'=>$calc,'score'=>$score,'is_auto'=>$is_auto,'hasil'=>$hasil));
				}
				break;	
		
			case 'pos_calc' :
					$sql = array();
					$idmaster_id = $_POST['idmaster_id'];
					$iSubmit = $_POST['iSubmit'];
					$iparameter_id = array();
					$ip_del='';
					$i=0;
					foreach($_POST as $key=>$value) {	
						if ($key == 'iparameter_id') {
							foreach($value as $k=>$v) {
								$iparameter_id[$k] = $v;
								if($i==0){
									$ip_del .= "'".$v."'";
								}else{
									$ip_del .= ",'".$v."'";
								}
								$i++;
							}
						}
						
					}

					$hasil_calc = array();
					foreach($_POST as $key=>$value) {	
						if ($key == 'hasil_calc') {
							foreach($value as $k=>$v) {
								$hasil_calc[$k] = $v;
							}
						}
						
					}

					$poin = array();
					foreach($_POST as $key=>$value) {	
						if ($key == 'poin') {
							foreach($value as $k=>$v) {
								$poin[$k] = $v;
							}
						}
						
					}

					$i = 0;
					//upload form 1

					$sqldel = 'DELETE FROM pk.pk_nilai WHERE  idmaster_id="'.$idmaster_id.'" and iparameter_id in ('.$ip_del.')';
					$querydel = $this->db_erp_pk->query( $sqldel );

					foreach ($_POST['iparameter_id'] as $key => $error) {
						
						if ($poin[$i]==""){
							$sql[] = "INSERT INTO pk.pk_nilai(idmaster_id, iparameter_id,hasil_calc,poin,flag_dinilai) 
								VALUES ('".$idmaster_id."','".$iparameter_id[$i]."',NULL,NULL,'0')";
						}else{
							$sql[] = "INSERT INTO pk.pk_nilai(idmaster_id, iparameter_id,hasil_calc,poin,flag_dinilai) 
								VALUES ('".$idmaster_id."','".$iparameter_id[$i]."','".$hasil_calc[$i]."','".$poin[$i]."','1')";
							
						}
						$i++;	
						// update isubmit di tabelheader																		
					}		
					foreach($sql as $q) {
						try {
							$this->db_erp_pk->query($q);
							
						}catch(Exception $e) {
							die($e);
						}
					}

					$sqle = "UPDATE pk.pk_master SET iSubmit = '".$iSubmit."' WHERE idmaster_id=$idmaster_id LIMIT 1";
					$query = $this->db_erp_pk->query( $sqle );

						$r['status'] = TRUE;
		                $r['message'] = "Success";
		                echo json_encode($r);
				break;
			case 'pos_calc_ats' :
					//print_r($this->input->post());exit();
					$sql = array();
					$idmaster_id = $_POST['idmaster_id'];
					$iSubmit = $_POST['iSubmit'];
					$iparameter_id = array();
					foreach($_POST as $key=>$value) {	
						if ($key == 'iparameter_id') {
							foreach($value as $k=>$v) {
								$iparameter_id[$k] = $v;
							}
						}
						
					}

					$hasil_calc = array();
					foreach($_POST as $key=>$value) {	
						if ($key == 'hasil_calc') {
							foreach($value as $k=>$v) {
								$hasil_calc[$k] = $v;
							}
						}
						
					}

					$poin = array();
					foreach($_POST as $key=>$value) {	
						if ($key == 'poin') {
							foreach($value as $k=>$v) {
								$poin[$k] = $v;
							}
						}
						
					}
					$pk = array();
					foreach($_POST as $key=>$value) {	
						if ($key == 'pk') {
							foreach($value as $k=>$v) {
								$pk[$k] = $v;
							}
						}
						
					}
					$nilai = array();
					foreach($_POST as $key=>$value) {	
						if ($key == 'nilai') {
							foreach($value as $k=>$v) {
								$nilai[$k] = $v;
							}
						}
						
					}
					$scoreats=array();
					foreach($_POST as $key=>$value) {	
						if ($key == 'scoreats') {
							foreach($value as $k=>$v) {
								$scoreats[$k] = $v;
							}
						}
						
					}
					$vpoinsepakat=array();
					foreach($_POST as $key=>$value) {	
						if ($key == 'vpoinsepakat') {
							foreach($value as $k=>$v) {
								$vpoinsepakat[$k] = $v;
							}
						}
						
					}
					$vpoinsepakat=array();
					foreach($_POST as $key=>$value) {	
						if ($key == 'vpoinsepakat') {
							foreach($value as $k=>$v) {
								$vpoinsepakat[$k] = $v;
							}
						}
						
					}
					$score_input=array();
					foreach($_POST as $key=>$value) {	
						if ($key == 'score_input') {
							foreach($value as $k=>$v) {
								$score_input[$k] = $v;
							}
						}
						
					}
					$nilai_karyawan=array();
					foreach($_POST as $key=>$value) {	
						if ($key == 'nilai_karyawan') {
							foreach($value as $k=>$v) {
								$nilai_karyawan[$k] = $v;
							}
						}
						
					}
					//print_r($score_input);
					//print_r($nilai_karyawan);
					//exit();
					$i = 0;
					//upload form 1
					foreach ($_POST['iparameter_id'] as $key => $error) {
					//	$sqldel = 'DELETE FROM pk.pk_nilai WHERE  idmaster_id="'.$idmaster_id.'"';
					//	$querydel = $this->db_erp_pk->query( $sqldel );
						$p='';
						if(isset($scoreats[$error])){
							$p.="hasil_calc_ats = '".$vpoinsepakat[$error]."'";
							$p.=", poin_sepakat= '".$scoreats[$error]."'";
							$p.=", poin_sepakat_atasan= '".$vpoinsepakat[$error]."'";
						}else{
							$p.="hasil_calc_ats = '".$hasil_calc[$i]."'";
						}
						if(isset($score_input[$error])){
							$hasilsep=($score_input[$error]+$nilai_karyawan[$error])/2;
							$p.=", poin_sepakat= '".$score_input[$error]."'";
							$p.=", poin_sepakat_atasan= '".$hasilsep."'";
						}
						if ($poin[$i]==""){
							$sql[] = "UPDATE pk.pk_nilai SET ".$p." WHERE ipk_nilai=$pk[$i] ";
						}else{
							$sa=", ".$p;
							$sql[] = "UPDATE pk.pk_nilai SET flag_dinilai = '2' ".$sa." WHERE ipk_nilai=$pk[$i] ";
							
						}
						$s[]=$i;
						
						$i++;	


						$sqle = "UPDATE pk.pk_master SET iSubmit = 3, cupdate = '".$this->user->gNIP."',dupdate = '".date('Y-m-d H:i:s')."' WHERE idmaster_id=$idmaster_id LIMIT 1";
									$query = $this->db_erp_pk->query( $sqle );

						// update isubmit di tabelheader																		
					}			
					
					//print_r($sql);exit();
					foreach($sql as $q) {
						try {
							$this->db_erp_pk->query($q);
						}catch(Exception $e) {
							die($e);
						}
					}
					

						$r['status'] = TRUE;
		                $r['message'] = "Success";
		                echo json_encode($r);
				break;	

			case 'sikap_calc' :
					//print_r($_POST);exit();
					$sql = array();
					$idmaster_id = $_POST['idmaster_id'];
					$iSubmit = $_POST['iSubmit'];
					$itim = $_POST['itim'];
					$it = $_POST['it'];
					$iparameter_id = array();
					$bobot=array();
					$p_k=array();
					$p_p=array();
					$ip_del='';
					$i=0;
					foreach($_POST as $key=>$value) {	
						if ($key == 'iparameter_id') {
							foreach($value as $k=>$v) {
								$b='bobot_'.$v;
								$kl='poin_karyawan_'.$v;
								$p='poin_pimpinan_'.$v;
								$se='sepakat_'.$v;
								$bobot[$v]=$_POST[$b];
								$p_k[$v]=$_POST[$kl];
								$p_p[$v]=$_POST[$se];
								$p_s[$v]=$_POST[$p];
								if($i==0){
									$ip_del .= "'".$v."'";
								}else{
									$ip_del .= ",'".$v."'";
								}
								$i++;
								$iparameter_id[$k] = $v;
							}
						}
						
					}

					$hasil_calc = array();
					foreach($_POST as $key=>$value) {	
						if ($key == 'hasil_calc') {
							foreach($value as $k=>$v) {
								$hasil_calc[$k] = $v;
							}
						}
						
					}

					$poin = array();
					foreach($_POST as $key=>$value) {	
						if ($key == 'poin') {
							foreach($value as $k=>$v) {
								$poin[$k] = $v;
							}
						}
						
					}


					$i = 0;
					//upload form 1
					$sqldel = 'DELETE FROM pk.pk_nilai WHERE  idmaster_id="'.$idmaster_id.'" and iparameter_id in ('.$ip_del.')';
					$querydel = $this->db_erp_pk->query( $sqldel );


					foreach ($_POST['iparameter_id'] as $key => $error) {
						$sql[] = "INSERT INTO pk_nilai(idmaster_id, iparameter_id,poin,flag_dinilai,poin_bobot,poin_sepakat,poin_sepakat_atasan) 
								VALUES ('".$idmaster_id."','".$iparameter_id[$i]."','".$p_k[$iparameter_id[$i]]."','".$it."','".$bobot[$iparameter_id[$i]]."','".$p_s[$iparameter_id[$i]]."','".$p_p[$iparameter_id[$i]]."')";
						$i++;	
						// update isubmit di tabelheader																		
					}			
					foreach($sql as $q) {
						try {
							$this->db_erp_pk->query($q);
							
						}catch(Exception $e) {
							die($e);
						}
					}
					if($it==1){
						$iSubmit=$iSubmit+2;
					}
					$sqle = "UPDATE pk.pk_master SET iSubmit_Sikap = '".$iSubmit."' WHERE idmaster_id=$idmaster_id LIMIT 1";
					$query = $this->db_erp_pk->query( $sqle );

						$r['status'] = TRUE;
		                $r['message'] = "Success";
		                echo json_encode($r);
				break;
				case 'pimpin_calc' :
					$sql = array();
					$idmaster_id = $_POST['idmaster_id'];
					$iSubmit = $_POST['iSubmit'];
					$itim = $_POST['itim'];
					$it = $_POST['it'];
					$iparameter_id = array();
					$bobot=array();
					$p_k=array();
					$p_p=array();
					$ip_del='';
					$i=0;
					foreach($_POST as $key=>$value) {	
						if ($key == 'iparameter_id') {
							foreach($value as $k=>$v) {
								$b='bobot_'.$v;
								$kl='poin_karyawan_'.$v;
								$p='poin_pimpinan_'.$v;
								$se='nilai_'.$v;
								$bobot[$v]=$_POST[$b];
								$p_k[$v]=$_POST[$kl];
								$p_p[$v]=$_POST[$p];
								$p_s[$v]=$_POST[$se];
								if($i==0){
									$ip_del .= "'".$v."'";
								}else{
									$ip_del .= ",'".$v."'";
								}
								$i++;
								$iparameter_id[$k] = $v;
							}
						}
						
					}

					$hasil_calc = array();
					foreach($_POST as $key=>$value) {	
						if ($key == 'hasil_calc') {
							foreach($value as $k=>$v) {
								$hasil_calc[$k] = $v;
							}
						}
						
					}

					$poin = array();
					foreach($_POST as $key=>$value) {	
						if ($key == 'poin') {
							foreach($value as $k=>$v) {
								$poin[$k] = $v;
							}
						}
						
					}


					$i = 0;
					//upload form 1
					$sqldel = 'DELETE FROM pk.pk_nilai WHERE  idmaster_id="'.$idmaster_id.'" and iparameter_id in ('.$ip_del.')';
					$querydel = $this->db_erp_pk->query( $sqldel );


					foreach ($_POST['iparameter_id'] as $key => $error) {
						$sql[] = "INSERT INTO pk_nilai(idmaster_id, iparameter_id,poin,flag_dinilai,poin_bobot,poin_sepakat_atasan,poin_sepakat) 
								VALUES ('".$idmaster_id."','".$iparameter_id[$i]."','".$p_k[$iparameter_id[$i]]."','".$it."','".$bobot[$iparameter_id[$i]]."','".$p_p[$iparameter_id[$i]]."','".$p_s[$iparameter_id[$i]]."')";
						$i++;	
						// update isubmit di tabelheader																		
					}			
					foreach($sql as $q) {
						try {
							$this->db_erp_pk->query($q);
							
						}catch(Exception $e) {
							die($e);
						}
					}
					if($it==1){
						$iSubmit=$iSubmit+2;
					}
					$sqle = "UPDATE pk.pk_master SET iSubmit_Kepemimpinan = '".$iSubmit."' WHERE idmaster_id=$idmaster_id LIMIT 1";
					$query = $this->db_erp_pk->query( $sqle );

						$r['status'] = TRUE;
		                $r['message'] = "Success";
		                echo json_encode($r);
				break;			
			case 'getemployee':
				echo $this->getEmployee();
				break;
			case 'cetak_pk_pdf':
				$this->load->library('m_pdf');
				$pdf = $this->m_pdf->load('c', 'A4-L');
				$id=$this->input->get("id");
				
				$html = $this->form_cetak_petunjuk($id);
				/*echo $html;exit();*/
				//$html=$this->load->view('cetak_pdf_pk');
				$date=date('YmdHis');
				$pdffile = "report_pk_ts-".$date.".pdf";
				$pdf->setFooter("Page {PAGENO}");
				$pdf->AddPage('P', // L - landscape, P - portrait
				'', '', '', '',
				20, // margin_left
				20, // margin right
				10, // margin top
				20, // margin bottom
				10, // margin header
				10); // margin footer
				$pdf->shrink_tables_to_fit = 0;
				$pdf->WriteHTML($html);
 				
				//download it.				
				$pdf ->Output($pdffile, "D");
				exit();
				break;
				case 'updatenote':
					$ipk=$this->input->post('ipk');
					$tcatatan_umum_pengaju=$this->input->post('tcatatan_umum_pengaju');
					$tcatatan_rencana_pengaju=$this->input->post('tcatatan_rencana_pengaju');
					$isdraft=$this->input->post('isdraft');
					$sql="update pk.pk_master mas SET mas.tcatatan_umum_pengaju='".$tcatatan_umum_pengaju."', mas.tcatatan_rencana_pengaju='".$tcatatan_rencana_pengaju."', is_confirm_karyawan='".$isdraft."' where mas.idmaster_id=".$ipk;
					$this->db_erp_pk->query($sql);
					$data['message']="Data Update Succes!";
					$data['last_id']=$ipk;
					$data['status']=TRUE;
					echo json_encode($data);
					exit();
				case 'updatenote_ats':
					$ipk=$this->input->post('ipk');
					$tcatatan_umum_atasan=$this->input->post('tcatatan_umum_atasan');
					$tcatatan_saran_atasan=$this->input->post('tcatatan_saran_atasan');
					$tcatatan_pelatihan_atasan=$this->input->post('tcatatan_pelatihan_atasan');
					$isdraft=$this->input->post('isdraft');
					if($isdraft==0){
						$submit=3;
					}else{
						$submit=4;
					}
					$sql="update pk.pk_master mas SET mas.tcatatan_umum_atasan='".$tcatatan_umum_atasan."', mas.tcatatan_saran_atasan='".$tcatatan_saran_atasan."', mas.tcatatan_pelatihan_atasan='".$tcatatan_pelatihan_atasan."',mas.iSubmit='".$submit."' where mas.idmaster_id=".$ipk;
					$this->db_erp_pk->query($sql);
					$data['message']="Data Update Succes!";
					$data['last_id']=$ipk;
					$data['status']=TRUE;
					echo json_encode($data);
					exit();
			break;
			default:
				$grid->render_grid();
				break;
		}
    }
/*Maniupulasi Gird end*/
/*manipulasi view object form start*/ 

 	function insertBox_pk_ts_lblIntro($field, $id){
 		$return=$this->load->view('create_master_pk_ts');
		$return.='
		<script type="text/javascript">
			// datepicker
			 $(".tanggal").datepicker({changeMonth:true,
										changeYear:true,
										dateFormat:"yy-mm-dd" });

			// input number
			   $(".angka").numeric();
		</script>
		';
		return $return;
	}

	function updateBox_pk_ts_lblIntro($field, $id, $value, $rowData) {
		
			$return = '
				<script type="text/javascript">
					$("label[for=\''.$id.'\']").parent().hide();
				</script>
			';
		return $return;
	}
	function insertBox_pk_ts_lblpro($field, $id){
 		$return = '<script>
			$("label[for=\''.$id.'\']").css({"border": "1px solid #dddddd", "background": "#548cb6", "border-collapse": "collapse","width":"98%","font-weight":"bold","color":"#ffffff","text-shadow": "0 1px 1px rgba(0, 0, 0, 0.3)","text-transform": "uppercase"});
		</script>';
		$return.='
		<script type="text/javascript">
			// datepicker
			 $(".tanggal").datepicker({changeMonth:true,
										changeYear:true,
										dateFormat:"yy-mm-dd" });

			// input number
			   $(".angka").numeric();
		</script>
		';
		return $return;
	}

	function updateBox_pk_ts_lblpro($field, $id, $value, $rowData) {
 		$return = '<script>
			$("label[for=\''.$id.'\']").css({"border": "1px solid #dddddd", "background": "#548cb6", "border-collapse": "collapse","width":"98%","font-weight":"bold","color":"#ffffff","text-shadow": "0 1px 1px rgba(0, 0, 0, 0.3)","text-transform": "uppercase"});
		</script>';
		$return.='
		<script type="text/javascript">
			// datepicker
			 $(".tanggal").datepicker({changeMonth:true,
										changeYear:true,
										dateFormat:"yy-mm-dd" });

			// input number
			   $(".angka").numeric();
		</script>
		';
		return $return;
	}
	function insertBox_pk_ts_lbldes($field,$id){


		$sql="select em.cNip,em.vName,de.vDescription as departement,di.vDescription as division,po.vDescription as jabatan,em.dRealIn as masuk from hrd.employee em
			inner join hrd.msdepartement de on de.iDeptID=em.iDepartementID
			inner join hrd.msdivision di on em.iDivisionID=di.iDivID
			inner join hrd.position po on po.iPostId=em.iPostID
			Where em.cNip='".$this->user->gNIP."'";
		$data['rows'] = $this->db->query($sql)->result_array();
		$data['id']=$id;
		$return=$this->load->view('details_employee',$data);
		return $return;
	}

	function updateBox_pk_ts_lbldes($field, $id, $value, $rowData) {
		$nipnya='';
		if ($rowData['iSubmit']>0) {
			$nipnya =$rowData['vnip'] ;	
		}else{
			$nipnya =$rowData['vnip'] ;
		}
		$sql="select em.cNip,em.vName,de.vDescription as departement,di.vDescription as division,po.vDescription as jabatan,em.dRealIn as masuk from hrd.employee em
			inner join hrd.msdepartement de on de.iDeptID=em.iDepartementID
			inner join hrd.msdivision di on em.iDivisionID=di.iDivID
			inner join hrd.position po on po.iPostId=em.iPostID
			Where em.cNip='".$nipnya."'";
		$data['rows'] = $this->db->query($sql)->result_array();
		$data['id']=$id;
		$return=$this->load->view('details_employee',$data);
		return $return;
	}

	function insertBox_pk_ts_tgl_penilaian($field, $id) {

		$now=date('Y-m-d');
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$now.'" readonly="readonly" class=" input_rows1 required" size="12" />';
		return  $return;
	}

	function updateBox_pk_ts_tgl_penilaian($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			if ($rowData['iSubmit'] >=1) {
				$pktim=$this->teams_nya(false,$rowData['vnip']);	
			}else{
				$pktim=$this->auth->my_teams();
			}
			



			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" readonly="readonly" class=" input_rows1 required" size="12" />';
			$return .= '<input type="hidden" name="nippemohon"  id="nippemohon" value="'.$rowData['vnip'].'" readonly="readonly" class=" input_rows1 required" size="12" />';
		}
		return $return;
	}

	function insertBox_pk_ts_tgl1($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class=" tanggal input_rows1 required" size="12" />';
		$return .= ' s/d ';
		$return .= '<input type="text" name="tgl2"  id="tgl2" class=" tanggal input_rows1 required" size="12" />';
		return $return;
	}

	function updateBox_pk_ts_tgl1($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'"  readonly="readonly"class="  input_rows1 required" size="12" />';
			$return .= ' s/d ';
			$return .= '<input type="text" name="pk_ts_tgl2"  id="pk_ts_tgl2" value="'.$rowData['tgl2'].'" readonly="readonly" class="  input_rows1 required" size="12" />';
		}
		return $return;
	}

	function insertBox_pk_ts_rincian_pk($field, $id) {
		$return = 'Save Record First';
		return $return;
	}

	function updateBox_pk_ts_rincian_pk($field, $id, $value, $rowData) {
		//print_r($rowData);exit();
		$iSubmit = $rowData['iSubmit'];
		$submit_karyawan=$rowData['is_confirm_karyawan'];
		$nip = $rowData['vnip'];
		
			$return = '
				<script type="text/javascript">
					$("label[for=\''.$id.'\']").hide();
					$("label[for=\''.$id.'\']").next().css("margin-left",0);
				</script>
			';

			$sql = "select id, vContent from pk.sysparam where cVariable ='PK_TS_MGR'";
	        $row = $this->db_erp_pk->query($sql)->row_array();
	        $teamid = 0;
	        $team = explode(",", $row['vContent']);

			for ($x=0;$x<count($team);$x++) {
	            if($nip == $team[$x]){
	                $teamid = $row['id'] ;
	            }
	        } 

			//Cek PostID
			$sqldatatab2="select * from hrd.employee em where cNip='".$rowData['vnip']."'";
			$datatab2['datemployee']=$this->db_erp_pk->query($sqldatatab2)->row_array();

			if($rowData['is_confirm']){
				$data['is_confirm']=1;
			}else{
				$data['is_confirm']=0;
			}
			if ($iSubmit > 0) {
				$mydept = $this->auth->my_depts(TRUE);
				$datatab1['team_id'] = $this->teams_nya(false,$rowData['vnip']);

				$datatab2['team_id'] = $this->teams_nya(false,$rowData['vnip']);
				$datatab2['mydept'] = $mydept;



			}else{

				$datatab1['team_id'] = $this->auth->my_teams();
				
				$datatab2['team_id'] = $this->auth->my_teams();
				$data['team_id'] = $this->auth->my_teams();	
			}
			
			$data['idmaster_id'] = $rowData['idmaster_id'];
			$datatab1['vnip']=$this->user->gNIP;
			$datatab1['judulnya'] = 'ini judul tab 1';
			$datatab2['judulnya'] = 'ini judul tab 2';
			$datatab3['judulnya'] = 'ini judul tab 3';
			$datatablast['judulnya'] = 'ini judul tab 3';

			$datatab2['rowData'] = $rowData;
			$datatab2['iSubmit'] = $iSubmit;
			$datatab2['submit_karyawan'] = $submit_karyawan;
			$datatab2['idmaster_id'] = $rowData['idmaster_id'];

			$datatab1['vnip']=$this->user->gNIP;
			$datatab2['vnip']=$this->user->gNIP;

			$datatablast['nipnya']=$rowData['vnip'];
			$datatablast['id'] = $rowData['idmaster_id'];

			$sq="select * from pk.pk_master pm where pm.idmaster_id=".$rowData['idmaster_id'];
			$datatablast['row']=$this->db_erp_pk->query($sq)->row_array();      
            
            $sql = "select vContent 
                        from pk.sysparam where cVariable ='PK_TS_STAFF_CATEGORY'";
            $vContent=$this->db_erp_pk->query($sql)->result_array();           
            $qrys = implode(",", $vContent[0]);

            $sql = "SELECT * FROM pk.pk_kategori 
                        where ikategori_id in  (" . implode(",", $vContent[0]) . ")";

                       
            $data['team_pd'] = $this->db->query($sql)->result_array();    

			if ($iSubmit > 0) {
				//return $this->insertBox_pk_ts_rincian_pk($field, $id, $value, $rowData);
				
				$data['tab1'] = $this->load->view('tab1_ts.php', $datatab1, TRUE);
				$data['tab2'] = $this->load->view('tab2_ts_edit.php', $datatab2, TRUE);
				//$data['tab3'] = $this->load->view('tab3.php', $datatab3, TRUE);
			}else{
				$data['tab1'] = $this->load->view('tab1_ts.php', $datatab1, TRUE);
				$data['tab2'] = $this->load->view('tab2_ts.php', $datatab2, TRUE);
				//$data['tab3'] = $this->load->view('tab3.php', $datatab3, TRUE);
			}
			$data['tab_karyawan']=$this->load->view('tab_last_karyawan_ts', $datatablast, TRUE);
			$data['tab_atasan']=$this->load->view('tab_last_atasan_ts', $datatablast, TRUE);
			$data['tab_last'] = $this->load->view('tab_last_ts.php', $datatablast, TRUE);
			$data['rowData']=$rowData;
			$data['employee']=$datatab2['datemployee'];
			$return .= $this->load->view('main_pk_ts',$data,TRUE);	
		$return.="<div class='priview_print'></div>";
		return $return;
	}


function teams_nya($as_array = FALSE,$nipnya) {
		if($as_array == TRUE) {
			$teams = $this->team_nya($nipnya);
			$my_teams = '';			
			$i = 1;
			if(!empty($teams['manager'])) {
				foreach($teams['manager'] as $k => $m) {
					$my_teams[] = $m;							
				}
			}
			if(!empty($teams['team'])) {
				foreach($teams['team'] as $k => $m) {
					$my_teams[] = $m;			
				}
			}
			return $my_teams;
		}
		else {
			$teams = $this->team_nya($nipnya);
			$mteams = '';
			$tteams = '';
			$i = 1;
			if(!empty($teams['manager'])) {
				$i = 1;
				foreach($teams['manager'] as $k => $m) {
					if($i==1) {
						$mteams .= $m;
					}
					else {
						$mteams .= ','.$m;
					}
					$i++;		
				}
			}
			if(!empty($teams['team'])) {
				$i = 1;
				foreach($teams['team'] as $k => $m) {
					if($i==1) {
						$tteams .= $m;
					}
					else {
						$tteams .= ','.$m;
					}
					$i++;			
				}
			}
			$tteams = $tteams == '' ? 0 : $tteams;
			$mteams = $mteams == '' ? 0 : $mteams;
			return $tteams.','.$mteams;
		}
	}

	
function team_nya($nipnya) {
		$return = array();
		$sqlmgr = "SELECT t.iteam_id FROM plc2.plc2_upb_team t
				   WHERE t.vnip = '".$nipnya."' and t.ldeleted=0";
		$ms = $this->db->query($sqlmgr)->result_array();
		foreach($ms as $m) {
			$return['manager'][$m['iteam_id']] = $m['iteam_id'];
		}
		
		$sql = "SELECT t.iteam_id FROM plc2.plc2_upb_team_item t
			   	WHERE t.vnip = '".$nipnya."' and t.ldeleted=0";
		$us = $this->db->query($sql)->result_array();
		foreach($us as $m) {
			$return['team'][$m['iteam_id']] = $m['iteam_id'];
		}
		
		return $return;
}

/*manipulasi view object form end*/
 function listPICNew($nip=null,$resignDate=null,$division=null,$isAll=false) {
        
        $this->auth->setNip( $nip );
        $this->auth->setResignDate( $resignDate );
        $this->auth->setDivision( $division );
        $this->auth->setSortBy( 'vName' );
        
        $arrSelf = $this->auth->getSelf();
        $rows = $this->auth->getInferior( '', $arrSelf );
        return $rows;
        
    }
 function open_data(){
 	$sql = "SELECT s.`id`,s.`cVariable`,s.`vContent` FROM pk.`sysparam` s WHERE s.`cVariable` = 'OPEN_PK_TS' AND s.`lDeleted` = 0";
 	$dt = $this->db_erp_pk->query($sql)->row_array();
 	return $dt['vContent'];
 }

/*manipulasi proses object form start*/
	function manipulate_update_button($buttons, $rowData){
		//print_r($rowData);
		unset($buttons['update_back']);
		unset($buttons['update']);
		$cNip=$this->user->gNIP;
		$type='';
		$sqldatatab2="select * from hrd.employee em where cNip='".$rowData['vnip']."'";
		$datemployee=$this->db_erp_pk->query($sqldatatab2)->row_array();
		$iatasan=0;
		if($datemployee['cUpper']==$cNip){
			$iatasan=1;
		}
		$query="select vName from hrd.employee where cNip='".$rowData['vnip']."' LIMIT 1";
		$dt=$this->db_erp_pk->query($query)->row_array();
		$confirm='<button class="ui-button-text icon-save" onclick="$(\'#alert_dialog_form\').detach();browse(\''.base_url().'processor/pk/browse/pk/ts?action=view&field=pk_ts&id='.$rowData['idmaster_id'].'&vnip='.$rowData['vnip'].'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',\'\',\'\',\'Konfirmasi Penilaian Akhir Kerja\')" type="button">Confirm</button>';
		$note_bd='<button class="ui-button-text icon-save" onclick="$(\'#alert_dialog_form\').detach();browse(\''.base_url().'processor/pk/browse/note/karyawan/pk/ts?action=view&field=pk_ts&id='.$rowData['idmaster_id'].'&vnip='.$rowData['vnip'].'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',\'\',\'\',\'Catatan Dari Karyawan\')" type="button">Catatan</button>';
		//$btn = '<button onclick="javascript:cetak(\'pk_ts\', \''.base_url().'processor/pk/pk/ts?action=cetak_pk&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, \'pdf\', \''.$rowData["vnip"].'\')" class="ui-button-text icon-save" id="button_save_product_cetak_ts">Cetak PDF</button>';
		//$btn .= '<button onclick="javascript:cetak(\'pk_ts\', \''.base_url().'processor/pk/pk/ts?action=cetak_pk&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, \'xls\', \''.$rowData["vnip"].'\')" class="ui-button-text icon-save" id="button_save_product_cetak_ts">Cetak Excel</button>';

		$btn  = '
			<script type="text/javascript">
				$(document).ready(function() {					
				});		
				
				function print_'.$this->url.'()	{
					var valid     = 1;
					
					
					if (valid=="2") {
						alert("Pilih Format Laporan !!");
						$("#'.$this->url.'_format").focus();
						return false;

					} else {
						/*$.ajax({
							url: "'.base_url().'processor/pk/pk/ts?action=cetak_pk_pdf&format=pdf&id='.$rowData['idmaster_id'].'",
							type: "post",
							data: id=1,
							success: function(data) {
								$(".priview_print").html(data);
							}
						});*/
						
						document.getElementById("iframe_preview_'.$this->url.'").src = "'.base_url().'processor/pk/pk/ts?action=cetak_pk_pdf&format=pdf&id='.$rowData['idmaster_id'].'";
					}
				}		
			</script>
		';
		 
		$btn .= '<iframe height="0" width="0" id="iframe_preview_'.$this->url.'"></iframe>';
		$btn .= '<button onclick="javascript:print_'.$this->url.'();" class="ui-button-text icon-save" id="iframe_preview_'.$this->url.'">Cetak PDF</button>';

		//$js=$this->load->view('pk_buttons_js');
		if ($this->input->get('action') == 'view') {
			if(($rowData['is_confirm']==1)&&(($iatasan==0)||($iatasan==1))){
				$buttons['update']= $btn;
			}else{unset($buttons['update']);}
		}
		else{
			if(($rowData['iSubmit']==4)&&($rowData['iSubmit_Sikap']==4)&&($iatasan==1)&&(($rowData['is_confirm']==NULL)||($rowData['is_confirm']=='')||($rowData['is_confirm']==0))){
				$buttons['update']=$confirm;
			}
			elseif(($rowData['iSubmit']>=2)&&($rowData['iSubmit_Sikap']>=2)&&($iatasan==0)&&(($rowData['is_confirm']==NULL)||($rowData['is_confirm']=='')||($rowData['is_confirm']==0))){
				//$buttons['update']=$note_bd;
			}
			elseif(($rowData['is_confirm']==1)&&(($iatasan==0)||($iatasan==1))){
				$buttons['update']= $btn;
			}else{unset($buttons['update']);}
		}
	return $buttons;
	}

	/*Function Cetak PK DOKUMEN*/
	function form_cetak_petunjuk($id){
		$sqlp="select em.cNip as nip,em.vName as name,de.vDescription as departement,di.vDescription as division,po.vDescription as jabatan,em.dRealIn as masuk, ma.tgl_penilaian as tglnilai, ma.tgl1 as tgl1, ma.tgl2 as tgl2 from pk.pk_master ma
			inner join hrd.employee em on em.cNip=ma.vnip
			inner join hrd.msdepartement de on de.iDeptID=em.iDepartementID
			inner join hrd.msdivision di on em.iDivisionID=di.iDivID
			inner join hrd.position po on po.iPostId=em.iPostID
			where ma.idmaster_id=".$id;
		$d=$this->db_erp_pk->query($sqlp)->row_array();
		$datpetunjuk['name']=$d['name'];
		$datpetunjuk['nip']=$d['nip'];
		$datpetunjuk['departement']=$d['departement'];
		$datpetunjuk['jabatan']=$d['jabatan'];
		$datpetunjuk['masuk']=$d['masuk'];
		$datpetunjuk['tglnilai']=$d['tglnilai'];
		$datpetunjuk['tgl1']=$d['tgl1'];
		$datpetunjuk['tgl2']=$d['tgl2'];
		$o='';
		$o.="<div style='page-break-after:always'>";
		$o.=$this->load->view('form_cetak_pk_petunjuk',$datpetunjuk,TRUE);
		$o.='</div>';
		$o.="<div style='page-break-after:always'>";
		$datasikap['id']=$id;
		$o.=$this->load->view('formcetak/form_cetak_pk_sikap_master',$datasikap,TRUE);
		$o.='</div>';
		$o.="<div style='page-break-after:always'>";
		$dataperformance['id']=$id;
		$o.=$this->load->view('formcetak/form_cetak_pk_performance_master',$dataperformance,TRUE);
		$o.='</div>';
		//$o.="<div style='page-break-after:always'>";
		//$dataperformance['id']=$id;
		//$o.=$this->load->view('form_cetak_pk_kepemimpinan',$dataperformance,TRUE);
		//$o.='</div>';
		$datalast['id']=$id;
		$o.=$this->load->view('formcetak/form_cetak_pk_akhir_master',$datalast,TRUE);
		//$o="sasa";
		return $o;
	}
   
/*manipulasi proses object form end*/    

function before_insert_processor($row, $postData) {

	// ubah status submit
	/*
		if($postData['isdraft']==true){
			$postData['iSubmit']=0;
		} 
		else{$postData['iSubmit']=1;} 
	*/
	$postData['vnip'] =	$this->user->gNIP;		
	$postData['iteam_id'] =	$this->auth->my_teams();
	$postData['dcreate'] = date('Y-m-d H:i:s');
	$postData['ccreate'] =$this->user->gNIP;
	
	return $postData;

}

function before_update_processor($row, $postData) {
	$postData['dupdate'] = date('Y-m-d H:i:s');
	$postData['cupdate'] =$this->user->gNIP;
	return $postData;

}
public function spv_pm2(){
	$datamaster['vnip']=$this->input->get('nip');
	$datamaster['tgl1']=$this->input->get('awal');
	$datamaster['tgl2']=$this->input->get('akhir');
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
			raw.requestor not in ('".$datamaster['vnip']."') AND raw.pic like '%".$datamaster['vnip']."%' AND
			#interval waktu penilaian
			raw.actual_finish between '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'";
		$sqlmain="SELECT z.id,z.problem_subject, z.date_posted,z.assignTime,z.actual_start,z.startDuration,z.input_date,z.commentType, z.vType, z.solution_id,z.actual_finish,z.iSLARate 
				FROM (SELECT a.id,b.solution_id,a.problem_subject, a.date_posted, 
				Case when a.approveDate is not null then a.approveDate 
				When a.assignTime is not null then a.assignTime 
				else a.date_posted end 
				assignTime, a.actual_start,b.startDuration,b.input_date,b.commentType,b.vType,iGrp_activity_id, a.actual_finish , c.iSLARate
				FROM hrd.ss_raw_problems a JOIN hrd.ss_solution b ON b.id = a.id 
				JOIN hrd.ss_activity_type c on c.activity_id = a.activity_id 
				WHERE #pic nip pengusul dan requestor bukan nip pengusul 
				a.requestor not in ('".$datamaster['vnip']."') 
				AND a.pic like '%".$datamaster['vnip']."%'
				#interval waktu penilaian 
				AND DATE(a.actual_finish) between '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."'
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
				a.requestor not in ('".$datamaster['vnip']."') 
				AND a.pic like '%".$datamaster['vnip']."%'
				#interval waktu penilaian 
				AND DATE(a.actual_finish) between '".$datamaster['tgl1']."' AND '".$datamaster['tgl2']."' #AND (b.commentType = 50) 
				#bukan module
				AND c.isModule='N' 
				#SLA yes
				AND c.isSLA='Y'   
				#Activity Type-Client CPU Instalasi 
				AND (b.isDeleted = 0 OR b.isDeleted IS NULL) 
				) AS z 
				GROUP BY z.id 
				ORDER BY z.date_posted,z.solution_id";
		$data['sql']=$sqlmain;
		$dupb = $this->db_erp_pk->query($sqlmain)->result_array();
		$data['nip']=$datamaster['vnip'];
		$data['datas']=$dupb;
    	$view=$this->load->view('detail_perform/ts/performance_2',$data,true);
		return $view;
}


/*function pendukung end*/    	
public function output(){
		$this->index($this->input->get('action'));
	}

}

