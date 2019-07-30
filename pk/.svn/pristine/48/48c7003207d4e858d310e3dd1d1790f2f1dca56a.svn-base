<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class pk_busdev extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
		$this->db_erp_pk = $this->load->database('pk', false,true);
		$this->db_erp_pk = $this->load->database('pk', false,true);
		$this->db_erp_pk = $this->load->database('pk', false,true);
		$this->load->library('lib_utilitas');
		$this->load->library('lib_calc_busdev');
		$this->user = $this->auth->user();
		$this->url='pk_busdev';
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;

		$grid->setTitle('PK Busdev');		
		$grid->setTable('plc2.pk_master');		
		$grid->setUrl('pk_busdev');
		$grid->addList('employee.cNip','employee.vName','plc2_upb_team.vteam','tgl_penilaian','tgl1','tgl2');
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

		$grid->setLabel('plc2_upb_team.vteam','Team');
		$grid ->setWidth('plc2_upb_team.vteam', '250'); 

		$grid->setJoinTable('hrd.employee', 'employee.cNip = pk_master.vnip', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_team', 'plc2_upb_team.iteam_id = pk_master.iteam_id', 'inner');

		$grid->setSortBy('tgl_penilaian');
		$grid->setSortOrder('DESC');

		$data_open = explode(',', $this->open_data());
		if(!in_array($this->user->gNIP, $data_open)){
			$mydept = $this->auth->my_depts(TRUE);
			if(!empty($mydept)){
				if((in_array('DR', $mydept))) {
					$grid->setQuery('pk_master.is_confirm_karyawan = 1', null);
				}
			}

			$x=$this->auth->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('BD', $team)){
					$type='BD';
					$grid->setQuery('pk_master.iteam_id IN ('.$this->auth->my_teams().')', null);
				}
			}
		}
		$grid->setGridView('grid');
		
		switch ($action) {
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
			//print_r($_POST);
			//exit;
				$vFunction = $this->input->post('vFunction');
				$mPoin = $this->input->post('mPoin');
				$mCalc = $this->input->post('mCalc');
				$date1 = $this->input->post('date1');
				$date2 = $this->input->post('date2');
				$itim = $this->input->post('itim_id');
				$nippemohon=$this->input->post('nippemohon');
				$periode = '12-2015';
				
				$this->lib_calc_busdev->itim = $itim;
				$this->lib_calc_busdev->nippemohon = $nippemohon;
				$this->lib_calc_busdev->date1 = $date1;
				$this->lib_calc_busdev->date2 = $date2;
				$this->lib_calc_busdev->periode = $periode;
				
				$calc = $this->lib_calc_busdev->setCalc( $vFunction );
				if($calc == $this->lib_calc_busdev->error ) {
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
					$itim = $_POST['itim'];
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

					$sqldel = 'DELETE FROM plc2.pk_nilai WHERE  idmaster_id="'.$idmaster_id.'" and iparameter_id in ('.$ip_del.')';
					$querydel = $this->db_erp_pk->query( $sqldel );

					foreach ($_POST['iparameter_id'] as $key => $error) {
						
						if ($poin[$i]==""){
							$sql[] = "INSERT INTO pk_nilai(idmaster_id, iparameter_id,hasil_calc,poin,flag_dinilai) 
								VALUES ('".$idmaster_id."','".$iparameter_id[$i]."',NULL,NULL,'0')";
						}else{
							$sql[] = "INSERT INTO pk_nilai(idmaster_id, iparameter_id,hasil_calc,poin,flag_dinilai) 
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

					$sqle = "UPDATE plc2.pk_master SET iSubmit = '".$iSubmit."' WHERE idmaster_id=$idmaster_id LIMIT 1";
					$query = $this->db_erp_pk->query( $sqle );

						$r['status'] = TRUE;
		                $r['message'] = "Success";
		                echo json_encode($r);
				break;
			case 'pos_calc_ats' :
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

					$i = 0;
					//upload form 1
					foreach ($_POST['iparameter_id'] as $key => $error) {
					//	$sqldel = 'DELETE FROM plc2.pk_nilai WHERE  idmaster_id="'.$idmaster_id.'"';
					//	$querydel = $this->db_erp_pk->query( $sqldel );

						if ($poin[$i]==""){
							$sql[] = "UPDATE plc2.pk_nilai SET hasil_calc_ats = '".$hasil_calc[$i]."' , poin_sepakat_atasan= '".$poin[$i]."', poin_sepakat= '".$nilai[$i]."' WHERE ipk_nilai=$pk[$i] ";
						}else{
							$sql[] = "UPDATE plc2.pk_nilai SET flag_dinilai = '2' ,hasil_calc_ats = '".$hasil_calc[$i]."' , poin_sepakat_atasan= '".$poin[$i]."', poin_sepakat= '".$nilai[$i]."' WHERE ipk_nilai=$pk[$i] ";
							
						}
						$s[]=$i;
						
						$i++;	


						$sqle = "UPDATE plc2.pk_master SET iSubmit = '".$iSubmit."',cupdate = '".$this->user->gNIP."',dupdate = '".date('Y-m-d H:i:s')."' WHERE idmaster_id=$idmaster_id LIMIT 1";
									$query = $this->db_erp_pk->query( $sqle );

						// update isubmit di tabelheader																		
					}			
					
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
					$sqldel = 'DELETE FROM plc2.pk_nilai WHERE  idmaster_id="'.$idmaster_id.'" and iparameter_id in ('.$ip_del.')';
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
					$sqle = "UPDATE plc2.pk_master SET iSubmit_Sikap = '".$iSubmit."' WHERE idmaster_id=$idmaster_id LIMIT 1";
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
					$sqldel = 'DELETE FROM plc2.pk_nilai WHERE  idmaster_id="'.$idmaster_id.'" and iparameter_id in ('.$ip_del.')';
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
					$sqle = "UPDATE plc2.pk_master SET iSubmit_Kepemimpinan = '".$iSubmit."' WHERE idmaster_id=$idmaster_id LIMIT 1";
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
				//$html=$this->load->view('cetak_pdf_pk');
				$date=date('YmdHis');
				$pdffile = "report_pk_busdev-".$date.".pdf";
				$pdf->setFooter("Page {PAGENO}");
				$pdf->AddPage('P', // L - landscape, P - portrait
				'', '', '', '',
				20, // margin_left
				20, // margin right
				10, // margin top
				10, // margin bottom
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
					if(in_array('BD', $team)){
						$tcatatan_umum_pengaju=$this->input->post('tcatatan_umum_pengaju');
						$tcatatan_rencana_pengaju=$this->input->post('tcatatan_rencana_pengaju');
						$isdraft=$this->input->post('isdraft');
						$sql="update plc2.pk_master mas SET mas.tcatatan_umum_pengaju='".$tcatatan_umum_pengaju."', mas.tcatatan_rencana_pengaju='".$tcatatan_rencana_pengaju."', is_confirm_karyawan='".$isdraft."' where mas.idmaster_id=".$ipk;
						$this->db_erp_pk->query($sql);
						$data['message']="Data Update Succes!";
						$data['last_id']=$ipk;
						$data['status']=TRUE;
						echo json_encode($data);
						exit();
					}else{
						echo "DR";
					}
				break;
			default:
				$grid->render_grid();
				break;
		}
    }
/*Maniupulasi Gird end*/
/*manipulasi view object form start*/
	 public function listBox_Action($row, $actions) {
	 	$mydept = $this->auth->my_depts(TRUE);
	 	if(!empty($mydept)){
			if(in_array('DR', $mydept)){
				if($row->is_confirm==1){
					unset($actions['edit']);
			 		unset($actions['delete']);
			 	}else{
			 		unset($actions['delete']);
			 	}
			}elseif(in_array('BD', $mydept)){
				if(($row->iSubmit>=1)||($row->iSubmit_Sikap>=1)||($row->iSubmit_Kepemimpinan>=1)){
					unset($actions['delete']);
				}elseif(($row->iSubmit>=2)&&($row->iSubmit_Sikap>=2)&&($row->iSubmit_Kepemimpinan>=2)){
					unset($actions['edit']);
		 			unset($actions['delete']);
				}
		 		
			}
		}
	 	
	 	 return $actions;
	 } 

 	function insertBox_pk_busdev_lblIntro($field, $id){
 		$return=$this->load->view('create_master_pk_busdev');
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

	function updateBox_pk_busdev_lblIntro($field, $id, $value, $rowData) {
		
			$return = '
				<script type="text/javascript">
					$("label[for=\''.$id.'\']").parent().hide();
				</script>
			';
		return $return;
	}
	function insertBox_pk_busdev_lblpro($field, $id){
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

	function updateBox_pk_busdev_lblpro($field, $id, $value, $rowData) {
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
	function insertBox_pk_busdev_lbldes($field,$id){


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

	function updateBox_pk_busdev_lbldes($field, $id, $value, $rowData) {
		$nipnya='';
		//if ($rowData['iSubmit']>0) {
			$nipnya =$rowData['vnip'] ;	
		//}else{
	//		$nipnya =$this->user->gNIP ;
	//	}
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

	function insertBox_pk_busdev_tgl_penilaian($field, $id) {
		$now=date('Y-m-d');
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$now.'" readonly="readonly" class=" input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_pk_busdev_tgl_penilaian($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			if ($rowData['iSubmit'] >=1) {
				$pktim=$this->teams_nya(false,$rowData['vnip']);	
			}else{
				$pktim=$this->auth->my_teams();
			}
			
			$sql_tim ='select a.vteam,iteam_id from plc2.plc2_upb_team a where a.ldeleted=0 and a.iteam_id in ("'.$pktim.'")';
			$qteam = $this->db->query($sql_tim)->row_array();
			$itim= $qteam['iteam_id'];
			



			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" readonly="readonly" class=" input_rows1 required" size="8" />';
			$return .= '<input type="hidden" name="itim"  id="itim" value="'.$itim.'" readonly="readonly" class=" input_rows1 required" size="8" />';
			$return .= '<input type="hidden" name="nippemohon"  id="nippemohon" value="'.$rowData['vnip'].'" readonly="readonly" class=" input_rows1 required" size="8" />';
		}
		return $return;
	}

	function insertBox_pk_busdev_tgl1($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class=" tanggal input_rows1 required" size="8" />';
		$return .= ' s/d ';
		$return .= '<input type="text" name="tgl2"  id="tgl2" class=" tanggal input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_pk_busdev_tgl1($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'"  readonly="readonly"class="  input_rows1 required" size="8" />';
			$return .= ' s/d ';
			$return .= '<input type="text" name="pk_busdev_tgl2"  id="pk_busdev_tgl2" value="'.$rowData['tgl2'].'" readonly="readonly" class="  input_rows1 required" size="8" />';
		}
		return $return;
	}

	function insertBox_pk_busdev_rincian_pk($field, $id) {
		$return = 'Save Record First';
		return $return;
	}

	function updateBox_pk_busdev_rincian_pk($field, $id, $value, $rowData) {
		//print_r($rowData);exit();
		$iSubmit = $rowData['iSubmit'];
		$submit_karyawan=$rowData['is_confirm_karyawan'];
		
			$return = '
				<script type="text/javascript">
					$("label[for=\''.$id.'\']").hide();
					$("label[for=\''.$id.'\']").next().css("margin-left",0);
				</script>
			';


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

			$datatab1['judulnya'] = 'ini judul tab 1';
			$datatab2['judulnya'] = 'ini judul tab 2';
			$datatab3['judulnya'] = 'ini judul tab 3';
			$datatablast['judulnya'] = 'ini judul tab 3';
			
			$data_open = explode(',', $this->open_data());
			$datatab1['data_open']=$data_open;
			$datatab2['data_open']=$data_open;
			$datatab3['data_open']=$data_open;

			$datatab2['rowData'] = $rowData;
			$datatab2['iSubmit'] = $iSubmit;
			$datatab2['submit_karyawan'] = $submit_karyawan;
			$datatab2['idmaster_id'] = $rowData['idmaster_id'];

			$datatab1['vnip']=$this->user->gNIP;

			$datatablast['nipnya']=$rowData['vnip'];
			$datatablast['id'] = $rowData['idmaster_id'];

			$sq="select * from plc2.pk_master pm where pm.idmaster_id=".$rowData['idmaster_id'];
			$datatablast['row']=$this->db_erp_pk->query($sq)->row_array();

			$dex=
			$sql = "SELECT * FROM plc2.pk_kategori d WHERE d.ldeleted = 0 ";
			$data['team_pd'] = $this->db->query($sql)->result_array();

			if ($iSubmit > 0) {
				//return $this->insertBox_pk_busdev_rincian_pk($field, $id, $value, $rowData);
				
				$data['tab1'] = $this->load->view('tab1.php', $datatab1, TRUE);
				$data['tab2'] = $this->load->view('tab2_edit.php', $datatab2, TRUE);
				$data['tab3'] = $this->load->view('tab3.php', $datatab3, TRUE);
			}else{
				$data['tab1'] = $this->load->view('tab1.php', $datatab1, TRUE);
				$data['tab2'] = $this->load->view('tab2.php', $datatab2, TRUE);
				$data['tab3'] = $this->load->view('tab3.php', $datatab3, TRUE);
			}
			$data['tab_karyawan']=$this->load->view('tab_last_karyawan', $datatablast, TRUE);
			$data['tab_last'] = $this->load->view('tab_last.php', $datatablast, TRUE);
			$data['rowData']=$rowData;
			$return .= $this->load->view('main_pk',$data,TRUE);	
		
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

/*manipulasi proses object form start*/
	function manipulate_update_button($buttons, $rowData){
		//print_r($rowData);
		unset($buttons['update_back']);
		unset($buttons['update']);
		$cNip=$this->user->gNIP;
		$type='';
		$mydept = $this->auth->my_depts(TRUE);
		if(!empty($mydept)){
			if(in_array('DR', $mydept)){
				$type='DR';
			}elseif(in_array('BD', $mydept)){
				$type='BD';
			}else{
				$type='';
			}
		}
		$query="select vName from hrd.employee where cNip='".$rowData['vnip']."' LIMIT 1";
		$dt=$this->db_erp_pk->query($query)->row_array();
		$confirm='<button class="ui-button-text icon-save" onclick="$(\'#alert_dialog_form\').detach();browse(\''.base_url().'processor/pk/browse/pk/busdev?action=view&field=pk_busdev&id='.$rowData['idmaster_id'].'&vnip='.$rowData['vnip'].'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',\'\',\'\',\'Konfirmasi Penilaian Akhir Kerja\')" type="button">Confirm</button>';
		$note_bd='<button class="ui-button-text icon-save" onclick="$(\'#alert_dialog_form\').detach();browse(\''.base_url().'processor/pk/browse/note/karyawan/pk/busdev?action=view&field=pk_busdev&id='.$rowData['idmaster_id'].'&vnip='.$rowData['vnip'].'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\',\'\',\'\',\'Catatan Dari Karyawan\')" type="button">Catatan</button>';
		//$btn = '<button onclick="javascript:cetak(\'pk_busdev\', \''.base_url().'processor/pk/pk/busdev?action=cetak_pk&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, \'pdf\', \''.$rowData["vnip"].'\')" class="ui-button-text icon-save" id="button_save_product_cetak_busdev">Cetak PDF</button>';
		//$btn .= '<button onclick="javascript:cetak(\'pk_busdev\', \''.base_url().'processor/pk/pk/busdev?action=cetak_pk&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, \'xls\', \''.$rowData["vnip"].'\')" class="ui-button-text icon-save" id="button_save_product_cetak_busdev">Cetak Excel</button>';

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
						document.getElementById("iframe_preview_'.$this->url.'").src = "'.base_url().'processor/pk/pk/busdev?action=cetak_pk_pdf&format=pdf&id='.$rowData['idmaster_id'].'";
					}
				}		
			</script>
		';
		 
		$btn .= '<iframe height="0" width="0" id="iframe_preview_'.$this->url.'"></iframe>';
		$btn .= '<button onclick="javascript:print_'.$this->url.'();" class="ui-button-text icon-save" id="iframe_preview_'.$this->url.'">Cetak PDF</button>';

		//$js=$this->load->view('pk_buttons_js');
		if ($this->input->get('action') == 'view') {
			if(($rowData['is_confirm']==1)){
				$buttons['update']= $btn;
			}else{unset($buttons['update']);}
		}
		else{
			if(($rowData['iSubmit']==4)&&($rowData['iSubmit_Sikap']==4)&&($rowData['iSubmit_Kepemimpinan']==4)&&($type=='DR')&&(($rowData['is_confirm']==NULL)||($rowData['is_confirm']=='')||($rowData['is_confirm']==0))){
				$buttons['update']=$confirm;
			}
			elseif(($rowData['iSubmit']>=2)&&($rowData['iSubmit_Sikap']>=2)&&($rowData['iSubmit_Kepemimpinan']>=2)&&($type=='BD')&&(($rowData['is_confirm']==NULL)||($rowData['is_confirm']=='')||($rowData['is_confirm']==0))){
				//$buttons['update']=$note_bd;
			}
			elseif(($rowData['is_confirm']==1)){
				$buttons['update']= $btn;
			}else{unset($buttons['update']);}
		}

	return $buttons;
	}

	/*Function Cetak PK DOKUMEN*/
	function form_cetak_petunjuk($id){
		$sqlp="select em.cNip as nip,em.vName as name,de.vDescription as departement,di.vDescription as division,po.vDescription as jabatan,em.dRealIn as masuk, ma.tgl_penilaian as tglnilai, ma.tgl1 as tgl1, ma.tgl2 as tgl2 from plc2.pk_master ma
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
		$o.=$this->load->view('form_cetak_pk_sikap',$datasikap,TRUE);
		$o.='</div>';
		$o.="<div style='page-break-after:always'>";
		$dataperformance['id']=$id;
		$o.=$this->load->view('form_cetak_pk_performance',$dataperformance,TRUE);
		$o.='</div>';
		$o.="<div style='page-break-after:always'>";
		$dataperformance['id']=$id;
		$o.=$this->load->view('form_cetak_pk_kepemimpinan',$dataperformance,TRUE);
		$o.='</div>';
		$datalast['id']=$id;
		$o.=$this->load->view('form_cetak_pk_akhir',$datalast,TRUE);
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

function open_data(){
 	$sql = "SELECT s.`id`,s.`cVariable`,s.`vContent` FROM pk.`sysparam` s WHERE s.`cVariable` = 'OPEN_PK_BD' AND s.`lDeleted` = 0";
 	$dt = $this->db_erp_pk->query($sql)->row_array();
 	return $dt['vContent'];
 }


/*function pendukung end*/    	
public function output(){
		$this->index($this->input->get('action'));
	}

}

