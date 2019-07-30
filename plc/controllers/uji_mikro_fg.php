<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class uji_mikro_fg extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->dbset = $this->load->database('plc0',false, true);
		 $this->load->library('lib_flow');
		 $this->load->library('lib_utilitas');
		$this->user = $this->auth_localnon->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		//dc.m_vendor  database.tabel

		$grid->setTitle('Uji Mikro FG');		
		$grid->setTable('plc2.mikro_fg');		
		$grid->setUrl('uji_mikro_fg');
		$grid->addList('formula.vNo_formula','plc2_upb.vupb_nomor','plc2_upb.vupb_nama','plc2_upb.vgenerik','vno_surat','istatus','iappqa_uji');
		$grid->setSortBy('plc2_upb_formula.vkode_surat');
		$grid->setSortOrder('ASC');

		$grid->setAlign('formula.vNo_formula', 'center');
		$grid->setWidth('formula.vNo_formula', '120');
		$grid->setLabel('formula.vNo_formula', 'Nomor Formulasi');

		$grid->setAlign('plc2_upb.vupb_nomor', 'center');
		$grid->setWidth('plc2_upb.vupb_nomor', '120');
		$grid->setLabel('plc2_upb.vupb_nomor', 'UPB Nomor');

		$grid->setAlign('plc2_upb.vupb_nama', 'Left');
		$grid->setWidth('plc2_upb.vupb_nama', '200');
		$grid->setLabel('plc2_upb.vupb_nama', 'Nama Usulan');

		$grid->setAlign('plc2_upb.vgenerik', 'Left');
		$grid->setWidth('plc2_upb.vgenerik', '200');
		$grid->setLabel('plc2_upb.vgenerik', 'Nama Generik');

		$grid->setAlign('vno_surat', 'Left');
		$grid->setWidth('vno_surat', '200');
		$grid->setLabel('vno_surat','Nomor Surat');

		$grid->setAlign('istatus', 'Left');
		$grid->setWidth('istatus', '150');
		$grid->setLabel('istatus','Hasil Pengujian Mikro FG');


		$grid->setAlign('iappqa_uji', 'Left');
		$grid->setWidth('iappqa_uji', '150');
		$grid->setLabel('iappqa_uji','Approval QA');

		$grid->addFields('itujuan_req','ifor_id','iupb_id','vupb_nama','vgenerik','dmulai_uji','dselesai_uji','istatus','itrial_uji','vfile','cnip_penyusun','iappqa_uji');
		
		$grid->setLabel('itujuan_req','Tujuan Produk');
		$grid->setLabel('ifor_id','Nomor Formulasi');
		$grid->setLabel('iupb_id','Nomor UPB');
		$grid->setLabel('vupb_nama','Nama Usulan');
		$grid->setLabel('vgenerik','Nama Generik');
		$grid->setLabel('dmulai_uji','Tgl Mulai Mikro FG');
		$grid->setLabel('dselesai_uji','Tgl Selesai Mikro FG');
		$grid->setLabel('itrial_uji','Trial ke(Baru hasil OK)/PD Trial');
		$grid->setLabel('vfile','File FG');
		$grid->setLabel('cnip_penyusun','QA Penyusun');
		
		$grid->setQuery('mikro_fg.lDeleted','0');

		$grid->setRequired('ifor_id','dmulai_uji','dselesai_uji','itrial_uji','istatus','vfile','cnip_penyusun');
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('QA', $manager)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('QA', $team)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		$grid->setFormUpload(TRUE);
		$grid->setJoinTable('plc2.plc2_upb_formula', 'plc2_upb_formula.ifor_id = mikro_fg.ifor_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb', 'plc2.plc2_upb_formula.iupb_id = plc2.plc2_upb.iupb_id', 'inner');
		$grid->setJoinTable('plc2.study_literatur_pd', 'plc2.plc2_upb_formula.iupb_id = plc2.study_literatur_pd.iupb_id', 'inner');
		
		$grid->setJoinTable('pddetail.formula_process','formula_process.iFormula_process=plc2_upb_formula.iFormula_process','inner');
		$grid->setJoinTable('pddetail.formula','formula.iFormula_process=formula_process.iFormula_process','inner');

		$grid->setRelation('plc2.plc2_upb.iteamqa_id','plc2.plc2_upb_team','iteam_id','vteam','team_qa','inner',array('vtipe'=>'QA', 'ldeleted'=>0),array('vteam'=>'asc'));

		$grid->setQuery('mikro_fg.lDeleted',0);

		//New Parameter For PLC Non OTC
		$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
		$grid->setQuery('plc2.plc2_upb.iKill', 0);
		$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
		$grid->setQuery('plc2_upb.ihold', 0);
		
		$grid->setSearch('plc2_upb.vupb_nomor','plc2_upb.vupb_nama');
		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				//print_r($this->input->post());exit();
				$isUpload = $this->input->get('isUpload');
   				if($isUpload) {
   					$lastId=$this->input->get('lastId');
					$path = realpath("files/plc/uji_mikro_fg");
					if(!file_exists($path."/".$lastId)){
						if (!mkdir($path."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again!');
						}
					}
					$fKeterangan = array();
					foreach($_POST as $key=>$value) {						
						if ($key == 'fileketerangan') {
							foreach($value as $k=>$v) {
								$fKeterangan[$k] = $v;
							}
						}
					}
					$i=0;
					foreach ($_FILES['fileupload']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {
							$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
							$name =$_FILES['fileupload']["name"][$key];
							$data['filename'] = $name;
							//$data['id']=$idossier_dok_list_id;
							$data['dInsertDate'] = date('Y-m-d H:i:s');

								if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO plc2.uji_mikro_fg_file (imikro_fg_id, vFilename, vKeterangan, dCreate, cCreate) 
											VALUES (".$lastId.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
						}
					}
					foreach($sql as $q) {
						try {
						$this->dbset->query($q);
						}catch(Exception $e) {
						die($e);
						}
					}
					$r['message'] = "Data Berhasil di Simpan!";
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');					
					echo json_encode($r);
				}  else {
						echo $grid->saved_form();
				}
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

				$isUpload = $this->input->get('isUpload');
				$post=$this->input->post();
				$iuji_mikro_fg_id=$post['uji_mikro_fg_imikro_fg_id'];
				$path = realpath("files/plc/uji_mikro_fg/");
				if(!file_exists($path."/".$iuji_mikro_fg_id)){
					if (!mkdir($path."/".$iuji_mikro_fg_id, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}
									
				$fKeterangan = array();	
   				if($isUpload) {	
   					$fileid='';
   					foreach($_POST as $key=>$value) {
											
						if ($key == 'fileketerangan') {
							foreach($value as $y=>$u) {
								$fKeterangan[$y] = $u;
							}
						}
						if ($key == 'namafile') {
							foreach($value as $k=>$v) {
								$file_name[$k] = $v;
							}
						}
						if ($key == 'fileid') {
							$i=0;
							foreach($value as $k=>$v) {
								if($i==0){
									$fileid .= "'".$v."'";
								}else{
									$fileid .= ",'".$v."'";
								}
								$i++;
							}
						}
					}
					
					if (isset($_FILES['fileupload']))  {

						$i=0;
						foreach ($_FILES['fileupload']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
								$name =$_FILES['fileupload']["name"][$key];
								$data['filename'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path."/".$iuji_mikro_fg_id."/".$name)) {
									$sql[]="INSERT INTO plc2.uji_mikro_fg_file (imikro_fg_id, vFilename, vKeterangan, dCreate, cCreate) 
											VALUES (".$iuji_mikro_fg_id.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
							
						}
					
						foreach($sql as $q) {
							try {
								$this->dbset->query($q);
							}catch(Exception $e) {
								die($e);
							}
						}	

					}
					$r['message'] = "Data Berhasil di Simpan!";
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');				
					echo json_encode($r);
					exit();
				}  else {
					$fileid='';
					foreach($_POST as $key=>$value) {
											
						if ($key == 'fileketerangan') {
							foreach($value as $y=>$u) {
								$fKeterangan[$y] = $u;
							}
						}
						if ($key == 'namafile') {
							foreach($value as $k=>$v) {
								$file_name[$k] = $v;
							}
						}
						if ($key == 'fileid') {
							$i=0;
							foreach($value as $k=>$v) {
								if($i==0){
									$fileid .= "'".$v."'";
								}else{
									$fileid .= ",'".$v."'";
								}
								$i++;
							}
						}
					}
					$tgl= date('Y-m-d H:i:s');
					$sql1="update plc2.uji_mikro_fg_file set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where imikro_fg_id='".$iuji_mikro_fg_id."' and iuji_mikro_fg_file_id not in (".$fileid.")";
					//echo $sql1;exit();
					$this->dbset->query($sql1);
					echo $grid->updated_form();
				}
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
			case 'getemployee':
				echo $this->getEmployee();
				break;
			case 'confirm':
				$post=$this->input->post();
				$get=$this->input->get();
		    	
		    	$cNip= $this->user->gNIP;
				$tApprove=date('Y-m-d H:i:s');
				$sql="update plc2.mikro_fg set cappqa_uji='".$cNip."', dappqa_uji='".$tApprove."', iappqa_uji=2 where imikro_fg_id='".$get['last_id']."'";
				$this->dbset->query($sql);

				$sql="select fo.iupb_id, st.ijenis_sediaan from plc2.mikro_fg fg
					inner join plc2.plc2_upb_formula fo on fg.ifor_id=fo.ifor_id
					inner join plc2.study_literatur_pd st on st.iupb_id=fo.iupb_id
					where fg.imikro_fg_id=".$get['last_id'];
				$dt=$this->dbset->query($sql)->row_array();
				$iupb_id=$dt['iupb_id'];
				$ijenis=$dt['ijenis_sediaan'];
				$stj='';
				if($ijenis==0){
					$stj='Steril';
				}elseif($ijenis==1){
					$stj='Non Steril';
				}

				$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
		                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
		                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
		                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
		                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
		                        from plc2.plc2_upb u where u.iupb_id='".$iupb_id."'";
		        $rupb = $this->db_plc0->query($qupb)->row_array();

		        $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id,
		                (select te.iteam_id from plc2.plc2_upb_team te where te.cDeptId='PR') as iteampr_id 
		                from plc2.plc2_upb u 
		                where u.iupb_id='".$iupb_id."'";
		        $rsql = $this->db_plc0->query($qsql)->row_array();

		        //$query = $this->dbset->query($rsql);

		        $pd = $rsql['iteampd_id'];
		        $bd = $rsql['iteambusdev_id'];
		        $qa = $rsql['iteamqa_id'];
		        $qc = $rsql['iteamqc_id'];
		        $pr = $rsql['iteampr_id'];
		        
		        $team = $pd. ','.$qa. ','.$bd.',' .$qc ;
		        
		        $toEmail2='';
		        $toEmail = $this->lib_utilitas->get_email_team( $pr );
		        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );                        

		        $arrEmail = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );

		        $to = $cc = '';
		        if(is_array($arrEmail)) {
		                $count = count($arrEmail);
		                $to = $arrEmail[0];
		                for($i=1;$i<$count;$i++) {
		                        $cc.=isset($arrEmail[$i]) ? $arrEmail[$i].';' : ';';
		                }
		        }			

		        $to = $toEmail;
		        $cc = $toEmail2;
		        $subject="Proses Uji Mikro FG (Khusus Produk ".$stj."): UPB ".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada approval oleh QA Manager pada Proses Uji Mikro FG (Khusus Produk ".$stj.")(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
		                <div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
		                        <table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
		                                <tr>
		                                        <td style='width: 110px;'><b>No UPB</b></td><td style='width: 20px;'> : </td><td>".$rupb['vupb_nomor']."</td>
		                                </tr>
		                                <tr>
		                                        <td><b>Nama Usulan</b></td><td> : </td><td>".$rupb['vupb_nama']."</td>
		                                </tr>
		                                <tr>
		                                        <td><b>Nama Generik</b></td><td> : </td><td>".$rupb['vgenerik']."</td>
		                                </tr>
		                                <tr>
		                                        <td><b>Team Busdev</b></td><td> : </td><td>".$rupb['bd']."</td>
		                                </tr>
		                                <tr>
		                                        <td><b>Team PD</b></td><td> : </td><td>".$rupb['pd']."</td>
		                                </tr>
		                                <tr>
		                                        <td><b>Team QA</b></td><td> : </td><td>".$rupb['qa']."</td>
		                                </tr>
		                                <tr>
		                                        <td><b>Team QC</b></td><td> : </td><td>".$rupb['qc']."</td>
		                                </tr>
		                        </table>
		                </div>
		                <br/> 
		                Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
		                Post Master";
		        /*echo  $to;
		        echo '</br>cc:' .$cc;      
		        echo  $content ;    
		        exit     ;*/
		        $this->lib_utilitas->send_email($to, $cc, $subject, $content);

				$r = $get;
				$r['status'] = TRUE;
				$r['message'] = 'Confirm Success!';
				echo json_encode($r);
				exit();
			break;

			default:
				$grid->render_grid();
				break;
		}
    }

    /*Maniupulasi Gird Start*/
 function getEmployee() {
    	$term = $this->input->get('term');
    	$sql='select de.vDescription,em.cNip as cNIP, em.vName as vName from plc2.plc2_upb_team_item it
				inner join plc2.plc2_upb_team te on it.iteam_id= te.iteam_id
				inner join hrd.employee em on em.cNip=it.vnip
				inner join hrd.msdepartement de on de.iDeptID=em.iDepartementID 
				where em.vName like "%'.$term.'%" and te.vtipe="QA" AND it.ldeleted=0 order by em.vname ASC';
    	$dt=$this->db_plc0->query($sql);
    	$data = array();
    	if($dt->num_rows>0){
    		foreach($dt->result_array() as $line) {
	
				$row_array['value'] = trim($line['vName']);
				$row_array['id']    = $line['cNIP'];
	
				array_push($data, $row_array);
			}
    	}
    	echo json_encode($data);
		exit;
    }


/*Maniupulasi Gird end*/
	function listBox_uji_mikro_fg_iappqa_uji($value) {
		if($value==0){$vstatus='Waiting for approval';}
		elseif($value==1){$vstatus='Rejected';}
		elseif($value==2){$vstatus='Approved';}
		return $vstatus;
	}

	function listBox_Action($row, $actions) {
	    if($row->iappqa_uji<>0){
	    	unset($actions['edit']);
	    	unset($actions['delete']);
	    }
	    return $actions; 

	}
/*manipulasi view object form start*/

	function insertBox_uji_mikro_fg_itujuan_req($field,$id){
		$pilih=array('3'=>'-----Pilih----','0'=>'Khusus Produk Steril','1'=>'Khusus Non Steril');
		$return ="<select id='".$id."' name='".$id."'>";
		foreach ($pilih as $key => $value) {
			$return .= '<option value='.$key.'>'.$value.'</option>';
		}
		$return .= "</select>";
		$return .="<script>
						$(document).ready(function(){
							$('#steril').hide();
							$('#nonsteril').hide();
						})
						$('#uji_mikro_fg_itujuan_req').change(function(){
							var nilai=$('#uji_mikro_fg_itujuan_req').val();
							if (nilai==0) {
								$('#steril').show();
								$('#nonsteril').hide();
								resik();
							} else if (nilai==1) {
								$('#steril').hide();
								$('#nonsteril').show();
								resik();
							} else {
								$('#steril').hide();
								$('#nonsteril').hide();
								resik();
							}
						});
						
						function resik(){
							var nilai='';
							$('#uji_mikro_fg_ifor_id').val(nilai);
							$('#uji_mikro_fg_ifor_id_dis').val(nilai);
							$('#uji_mikro_fg_iupb_id_dis').val(nilai);
							$('#uji_mikro_fg_vupb_nama').val(nilai);
							$('#uji_mikro_fg_vgenerik').val(nilai);
						}
					</script>";
		return $return;
	}

 	function insertBox_uji_mikro_fg_ifor_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="isdraft" id="isdraft">';
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1 required" size="20" />&nbsp;';
		$return .= '<button id="steril" class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/uji/mikro/fg/popup?field=uji_mikro_fg&ijenis=0&modul_id='.$this->input->get('modul_id').'\',\'List UPB\')" type="button">&nbsp;</button>';
		$return .= '<button id="nonsteril" class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/uji/mikro/fg/popup?field=uji_mikro_fg&ijenis=1&modul_id='.$this->input->get('modul_id').'\',\'List UPB\')" type="button">&nbsp;</button>';
		return $return;
	}

	function insertBox_uji_mikro_fg_iupb_id($field, $id) {
		$return = '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="20" />';
		return $return;
	}
	function insertBox_uji_mikro_fg_vupb_nama($field, $id) {
		return '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" />';
	}
	function insertBox_uji_mikro_fg_vgenerik($field, $id) {
		return '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" />';
	}

	function insertBox_uji_mikro_fg_istatus($field, $id) {
		$return ='<input type="text" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="20" />';
		/*$return .='<script>
					$(document).ready(function(){
						$("#error_text_istatus").hide();
						$("#uji_mikro_fg_istatus").focus(function(){
							$("#error_text_istatus").hide();
						});
					});
					
					function ceknumber(){
						nilai=$("#uji_mikro_fg_istatus").val();
						var number=/^[0-9]+$/;
						if(!nilai.match(number)){
							$("#error_text_istatus").show();
							$("#uji_mikro_fg_istatus").val("");
						}else{
							$("#error_text_istatus").hide();
						}
					}
					</script>';*/
		return $return;
	}

	function insertBox_uji_mikro_fg_itrial_uji($field, $id) {
		$return ='<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'" class="input_rows1 required" size="20" onchange="ceknumber1()" /> <label id="error_text_itrial_uji" style="color:#8B0000">Number Only!</label>';
		$return .='<script>
					$(document).ready(function(){
						$("#error_text_itrial_uji").hide();
						$("#uji_mikro_fg_itrial_uji").focus(function(){
							$("#error_text_itrial_uji").hide();
						});
					});
					
					function ceknumber1(){
						nilai=$("#uji_mikro_fg_itrial_uji").val();
						var number=/^[0-9]+$/;
						if(!nilai.match(number)){
							$("#error_text_itrial_uji").show();
							$("#uji_mikro_fg_itrial_uji").val("");
						}else{
							$("#error_text_itrial_uji").hide();
						}
					}
					</script>';
		return $return;
	}

	function insertBox_uji_mikro_fg_dmulai_uji($field, $id){
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" />';
		$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
					</script>';
		return $return;
	}
	function insertBox_uji_mikro_fg_dselesai_uji($field, $id){
		$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" />';
		$return .=	'<script>
						$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
					</script>';
		return $return;
	}

    function insertBox_uji_mikro_fg_vfile($field, $id) {
    	$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('uji_mikro_fg_file',$data,TRUE);
	}

	function insertBox_uji_mikro_fg_cnip_penyusun($field, $id){
		$url = base_url().'processor/plc/uji/mikro/fg?action=getemployee';
		$return	= '<script language="text/javascript">
					$(document).ready(function() {
						var config = {
							source: function( request, response) {
								$.ajax({
									url: "'.$url.'",
									dataType: "json",
									data: {
										term: request.term,
									},
									success: function( data ) {
										response( data );
									}
								});
							},
							select: function(event, ui){
								$( "#'.$id.'" ).val(ui.item.id);
								$( "#'.$id.'_text" ).val(ui.item.value);
								return false;
							},
							minLength: 2,
							autoFocus: true,
						};
	
						$( "#'.$id.'_text" ).livequery(function() {
						 	$( this ).autocomplete(config);
						});
	
					});
		      </script>
		<input name="'.$id.'" id="'.$id.'" type="hidden" class="required" />
		<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20" />';
		return $return;
	}

	function insertBox_uji_mikro_fg_iappqa_uji($field, $id) {
    	return '-';
	}


	function updateBox_uji_mikro_fg_itujuan_req($field, $id, $value, $rowData){
		$sql='select st.ijenis_sediaan as jenis from plc2.plc2_upb_formula fo
			inner join plc2.study_literatur_pd st on st.iupb_id=fo.iupb_id
			where fo.ifor_id='.$rowData['ifor_id'];
		$data=$this->dbset->query($sql)->row_array();
		$pilih=array('3'=>'-----Pilih----','0'=>'Khusus Produk Steril','1'=>'Khusus Non Steril');
		if($this->input->get('action')=='view'){
			$return=$pilih[$data['jenis']];
		}else{
		$return ="<select id='".$id."' name='".$id."'>";
		foreach ($pilih as $key => $value) {
			$selected=$data['jenis']==$key ? 'selected':'';
			$return .= '<option value='.$key.' '.$selected.'>'.$value.'</option>';
		}
		$return .= "</select>";
		$return .="<script>
						$(document).ready(function(){
							$('#steril').hide();
							$('#nonsteril').hide();
							var nilai=$('#uji_mikro_fg_itujuan_req').val();
							if (nilai==0) {
								$('#steril').show();
								$('#nonsteril').hide();
							} else if (nilai==1) {
								$('#steril').hide();
								$('#nonsteril').show();
							} else {
								$('#steril').hide();
								$('#nonsteril').hide();
							}
						})
						$('#uji_mikro_fg_itujuan_req').change(function(){
							var nilai=$('#uji_mikro_fg_itujuan_req').val();
							if (nilai==0) {
								$('#steril').show();
								$('#nonsteril').hide();
								resik();
							} else if (nilai==1) {
								$('#steril').hide();
								$('#nonsteril').show();
								resik();
							} else {
								$('#steril').hide();
								$('#nonsteril').hide();
								resik();
							}
						});
						
						function resik(){
							var nilai='';
							$('#uji_mikro_fg_ifor_id').val(nilai);
							$('#uji_mikro_fg_ifor_id_dis').val(nilai);
							$('#uji_mikro_fg_iupb_id_dis').val(nilai);
							$('#uji_mikro_fg_vupb_nama').val(nilai);
							$('#uji_mikro_fg_vgenerik').val(nilai);
						}
					</script>";
		}
		return $return;
	}

	function updateBox_uji_mikro_fg_ifor_id($field, $id, $value, $rowData){
		$sql='select fo.ifor_id, fo.vkode_surat, up.vupb_nomor, up.vupb_nama, up.vgenerik from plc2.plc2_upb_formula fo
				inner join plc2.plc2_upb up on up.iupb_id=fo.iupb_id
				where fo.ifor_id='.$rowData['ifor_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vkode_surat'];
		}else{
			$return = '<script>
							$( "button.icon_pop" ).button({
								icons: {
									primary: "ui-icon-newwin"
								},
								text: false
							})
						</script>';
			$return .= '<input type="hidden" name="isdraft" id="isdraft">';
			$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" value="'.$dt['ifor_id'].'" />';
			$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$dt['vkode_surat'].'" />&nbsp;';
			$return .= '<button id="steril" class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/uji/mikro/fg/popup?field=uji_mikro_fg&ijenis=0&modul_id='.$this->input->get('modul_id').'\',\'List UPB\')" type="button">&nbsp;</button>';
			$return .= '<button id="nonsteril" class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/uji/mikro/fg/popup?field=uji_mikro_fg&ijenis=1&modul_id='.$this->input->get('modul_id').'\',\'List UPB\')" type="button">&nbsp;</button>';
		}
		return $return;
	}

	function updateBox_uji_mikro_fg_iupb_id($field, $id, $value, $rowData){
		$sql='select fo.ifor_id, fo.vkode_surat, up.vupb_nomor, up.vupb_nama, up.vgenerik from plc2.plc2_upb_formula fo
				inner join plc2.plc2_upb up on up.iupb_id=fo.iupb_id
				where fo.ifor_id='.$rowData['ifor_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nomor'];
		}else{
			$return = '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" value="'.$dt['vupb_nomor'].'" size="20" />&nbsp;';
		}
		return $return;
	}

	function updateBox_uji_mikro_fg_vupb_nama($field, $id, $value, $rowData) {
		$sql='select fo.ifor_id, fo.vkode_surat, up.vupb_nomor, up.vupb_nama, up.vgenerik from plc2.plc2_upb_formula fo
				inner join plc2.plc2_upb up on up.iupb_id=fo.iupb_id
				where fo.ifor_id='.$rowData['ifor_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nama'];
		}else{
			$return='<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" value="'.$dt['vupb_nama'].'" />';
		}
		return $return;
	}
	function updateBox_uji_mikro_fg_vgenerik($field, $id, $value, $rowData) {
		$sql='select fo.ifor_id, fo.vkode_surat, up.vupb_nomor, up.vupb_nama, up.vgenerik from plc2.plc2_upb_formula fo
				inner join plc2.plc2_upb up on up.iupb_id=fo.iupb_id
				where fo.ifor_id='.$rowData['ifor_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vgenerik'];
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1" size="20" value="'.$dt['vgenerik'].'" />';
		}
		return $return;
	}
	function updateBox_uji_mikro_fg_dmulai_uji($field,$id,$value,$rowData){
		if(($value==NULl) || ($value=='')){
			$value='';
		}else{
			$value=date('d-m-Y',strtotime($value));
		}
		if($this->input->get('action')=='view'){
			$return	=$value;
		}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$value.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
		}

		return $return;
	}
	function updateBox_uji_mikro_fg_dselesai_uji($field,$id,$value,$rowData){
		if(($value==NULl) || ($value=='')){
			$value='';
		}else{
			$value=date('d-m-Y',strtotime($value));
		}
		if($this->input->get('action')=='view'){
			$return	=$value;
		}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$value.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
		}

		return $return;
	}
	function updateBox_uji_mikro_fg_cnip_penyusun($field, $id, $value, $rowData) {
		$sql="select * from hrd.employee em where em.cNip='".$value."'";
		$dt=$this->db_plc0->query($sql)->row_array();
		if($dt){
				$vName=$dt['vName'];
				$value=$value;
			}else{
				$vName='';
				$value='';
			}
		if($this->input->get('action')=='view'){
			$return	=$vName;
		}else{
		$url = base_url().'processor/plc/uji/mikro/fg?action=getemployee';
		$return	= '<script language="text/javascript">
					$(document).ready(function() {
						var config = {
							source: function( request, response) {
								$.ajax({
									url: "'.$url.'",
									dataType: "json",
									data: {
										term: request.term,
									},
									success: function( data ) {
										response( data );
									}
								});
							},
							select: function(event, ui){
								$( "#'.$id.'" ).val(ui.item.id);
								$( "#'.$id.'_text" ).val(ui.item.value);
								return false;
							},
							minLength: 2,
							autoFocus: true,
						};
	
						$( "#'.$id.'_text" ).livequery(function() {
						 	$( this ).autocomplete(config);
						});
	
					});
		      </script>
		<input name="'.$id.'" id="'.$id.'" type="hidden" value="'.$value.'" class="required" />
		<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20" value="'.$vName.'"/>';
		}
		return $return;
	}

	function updateBox_uji_mikro_fg_istatus($field, $id, $value, $rowData){
		if($this->input->get('action')=='view'){
			$return=$value;
		}else{
		$return ='<input type="text" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="20" value="'.$value.'" />';
		/*$return ='<input type="text" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="20" onchange="ceknumber()" value="'.$value.'" /> <label id="error_text_istatus" style="color:#8B0000">Number Only!</label>';
		$return .='<script>
					$(document).ready(function(){
						$("#error_text_istatus").hide();
						$("#uji_mikro_fg_istatus").focus(function(){
							$("#error_text_istatus").hide();
						});
					});
					
					function ceknumber(){
						nilai=$("#uji_mikro_fg_istatus").val();
						var number=/^[0-9]+$/;
						if(!nilai.match(number)){
							$("#error_text_istatus").show();
							$("#uji_mikro_fg_istatus").val("'.$value.'");
						}else{
							$("#error_text_istatus").hide();
						}
					}
					</script>';*/
		}
		return $return;
	}

	function updateBox_uji_mikro_fg_itrial_uji($field, $id, $value, $rowData){
		if($this->input->get('action')=='view'){
			return $return=$value;
		}else{
		$return ='<input type="text" disabled="TRUE" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="20" onchange="ceknumber1()" value="'.$value.'" /> <label id="error_text_itrial_uji" style="color:#8B0000">Number Only!</label>';
		$return .='<script>
					$(document).ready(function(){
						$("#error_text_itrial_uji").hide();
						$("#uji_mikro_fg_itrial_uji").focus(function(){
							$("#error_text_itrial_uji").hide();
						});
					});
					
					function ceknumber1(){
						nilai=$("#uji_mikro_fg_itrial_uji").val();
						var number=/^[0-9]+$/;
						if(!nilai.match(number)){
							$("#error_text_itrial_uji").show();
							$("#uji_mikro_fg_itrial_uji").val("'.$value.'");
						}else{
							$("#error_text_itrial_uji").hide();
						}
					}
					</script>';
		return $return;
		}
	}

    function updateBox_uji_mikro_fg_vfile($field, $id, $value, $rowData) {
    	 	
		$qr="select * from plc2.uji_mikro_fg_file where imikro_fg_id='".$rowData['imikro_fg_id']."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('uji_mikro_fg_file',$data,TRUE);
	}
	function updateBox_uji_mikro_fg_iappqa_uji($field, $id, $value, $rowData) {
    	if($rowData['iappqa_uji'] != 0){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['cappqa_uji']))->row_array();
			if($rowData['iappqa_uji']==2){$st="Approved";}elseif($rowData['iappqa_uji']==1){$st="Rejected";} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['cappqa_uji'].' )'.' pada '.$rowData['dappqa_uji'];
		}else{
			$ret='Waiting Approval';
		}
		return $ret;
	}
/*manipulasi view object form end*/

/*manipulasi proses object form start*/
   function manipulate_insert_button($buttons) {
		unset($buttons['save']);
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('QA', $manager)){$type='QA';
				$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'uji_mikro_fg\', \''.base_url().'processor/plc/uji/mikro/fg?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_uji_mikro_fg">Save as Draft</button>';
				$save = '<button onclick="javascript:save_btn_multiupload(\'uji_mikro_fg\', \''.base_url().'processor/plc/uji/mikro/fg?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_uji_mikro_fg">Save</button>';
				$js = $this->load->view('uji_mikro_fg_js');
				$js .= $this->load->view('uploadjs');
				$buttons['save'] = $save.$js;
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('QA', $team)){$type='QA';
				$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'uji_mikro_fg\', \''.base_url().'processor/plc/uji/mikro/fg?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_uji_mikro_fg">Save as Draft</button>';
				$save = '<button onclick="javascript:save_btn_multiupload(\'uji_mikro_fg\', \''.base_url().'processor/plc/uji/mikro/fg?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_uji_mikro_fg">Save</button>';
				$js = $this->load->view('uji_mikro_fg_js');
				$js .= $this->load->view('uploadjs');
				$buttons['save'] = $save.$js;
			}
			else{$type='';}
		}
		return $buttons;
	}
	function manipulate_update_button($buttons, $rowData){
		//print_r($rowData);exit();
		unset($buttons['update']);
		$js=$this->load->view('uji_mikro_fg_js');
		$js .= $this->load->view('uploadjs');
		$cNip=$this->user->gNIP;
		$sql= "select * from plc2.plc2_upb_formula fo
			inner join plc2.plc2_upb up on fo.iupb_id=up.iupb_id
			where fo.ifor_id=".$rowData['ifor_id'];
		$dt=$this->dbset->query($sql)->row_array();
		$setuju = '<button onclick="javascript:setuju(\'uji_mikro_fg\', \''.base_url().'processor/plc/uji/mikro/fg?action=confirm&last_id='.$this->input->get('id').'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_soi_fg">Confirm</button>';
		$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/uji/mikro/fg?action=approve&imikro_fg_id='.$rowData['imikro_fg_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_uji_mikro_fg">Approve</button>';
		$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/uji/mikro/fg?action=reject&imikro_fg_id='.$rowData['imikro_fg_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_uji_mikro_fg">Reject</button>';

		$update = '<button onclick="javascript:update_btn_back(\'uji_mikro_fg\', \''.base_url().'processor/plc/uji/mikro/fg?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_uji_mikro_fg">Update</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'uji_mikro_fg\', \''.base_url().'processor/plc/uji/mikro/fg?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_uji_mikro_fg">Update as Draft</button>';
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('QA', $manager)){
				$type='QA';
				if ($rowData['iappqa_uji']==0){
					$buttons['update']=$update.$setuju.$js;
				}else{}
			}else{

				$type='';
			}
		}else{

			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('QA', $team)){
				$type='QA';
				if($rowData['iappqa_uji']==0){
					//$buttons['update']=$update.$js;
					$buttons['update']=$update.$setuju.$js;
				}
			}else{
				$type='';
			}
		}
		return $buttons;
	}
   
/*manipulasi proses object form end*/    
function before_insert_processor($row, $postData) {
	$postData['dCreate'] = date('Y-m-d H:i:s');
	$postData['cCreate'] =$this->user->gNIP;
	$postData['dmulai_uji']=date('Y-m-d',strtotime($postData['dmulai_uji']));
	$postData['dselesai_uji']=date('Y-m-d',strtotime($postData['dselesai_uji']));
	unset($postData['uji_mikro_fg_dmulai_uji']);
	unset($postData['uji_mikro_fg_dselesai_uji']);
	unset($postData['uji_mikro_fg_cnip_penyusun_text']);
	unset($postData['iappqa_uji']);
	//print_r($postData);exit();
	return $postData;

}
function before_update_processor($row, $postData) {
	$postData['dupdate'] = date('Y-m-d H:i:s');
	$postData['cUpdate'] =$this->user->gNIP;
	$postData['dmulai_uji']=date('Y-m-d',strtotime($postData['dmulai_uji']));
	$postData['dselesai_uji']=date('Y-m-d',strtotime($postData['dselesai_uji']));
	unset($postData['uji_mikro_fg_dmulai_uji']);
	unset($postData['uji_mikro_fg_dselesai_uji']);
	unset($postData['uji_mikro_fg_cnip_penyusun_text']);
	unset($postData['iappqa_uji']);
	//print_r($postData);exit();
	return $postData;

}
function after_insert_processor($row, $insertId, $postData){
	//$iupb_id=$postData['iupb_id'];
	//$this->lib_flow->insert_logs($this->input->get('modul_id'),$iupb_id,1);
}

/*Approval & Reject Proses */

function approve_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {

						return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;							
								if(o.status == true) {
									$("#alert_dialog_form").dialog("close");
										$.get(base_url+"processor/plc/uji/mikro/fg?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
	                            			 $("div#form_uji_mikro_fg").html(data);
	                    				});
									
								}
									reload_grid("grid_uji_mikro_fg");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_uji_mikro_fg_approve" action="'.base_url().'processor/plc/uji/mikro/fg?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="imikro_fg_id" value="'.$this->input->get('imikro_fg_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_uji_mikro_fg_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function approve_process(){
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update plc2.mikro_fg set vremark_uji='".$vRemark."',cappqa_uji='".$cNip."', dappqa_uji='".$tApprove."', iappqa_uji=2 where imikro_fg_id='".$post['imikro_fg_id']."'";
		$this->dbset->query($sql);

		$sql="select fo.iupb_id, st.ijenis_sediaan from plc2.mikro_fg fg
			inner join plc2.plc2_upb_formula fo on fg.ifor_id=fo.ifor_id
			inner join plc2.study_literatur_pd st on st.iupb_id=fo.iupb_id
			where fg.imikro_fg_id=".$post['imikro_fg_id'];
		$dt=$this->dbset->query($sql)->row_array();
		$iupb_id=$dt['iupb_id'];
		$ijenis=$dt['ijenis_sediaan'];
		$stj='';
		if($ijenis==0){
			$stj='Steril';
		}elseif($ijenis==1){
			$stj='Non Steril';
		}
		//$this->lib_flow->insert_logs($post['modul_id'],$iupb_id,9,2);

		//$sqli="update plc2.plc2_upb set istudypd=1 where iupb_id='".$iupb_id."'";
        //$this->dbset->query($sqli);

		$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
                        (select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
                        from plc2.plc2_upb u where u.iupb_id='".$iupb_id."'";
        $rupb = $this->db_plc0->query($qupb)->row_array();

        $qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id,
                (select te.iteam_id from plc2.plc2_upb_team te where te.cDeptId='PR') as iteampr_id 
                from plc2.plc2_upb u 
                where u.iupb_id='".$iupb_id."'";
        $rsql = $this->db_plc0->query($qsql)->row_array();

        //$query = $this->dbset->query($rsql);

        $pd = $rsql['iteampd_id'];
        $bd = $rsql['iteambusdev_id'];
        $qa = $rsql['iteamqa_id'];
        $qc = $rsql['iteamqc_id'];
        $pr = $rsql['iteampr_id'];
        
        $team = $pd. ','.$qa. ','.$bd.',' .$qc ;
        
        $toEmail2='';
        $toEmail = $this->lib_utilitas->get_email_team( $pr );
        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );                        

        $arrEmail = $this->lib_utilitas->get_email_by_nip( $this->user->gNIP );

        $to = $cc = '';
        if(is_array($arrEmail)) {
                $count = count($arrEmail);
                $to = $arrEmail[0];
                for($i=1;$i<$count;$i++) {
                        $cc.=isset($arrEmail[$i]) ? $arrEmail[$i].';' : ';';
                }
        }			

        $to = $toEmail;
        $cc = $toEmail2;
        $subject="Proses Uji Mikro FG (Khusus Produk ".$stj."): UPB ".$rupb['vupb_nomor'];
        $content="
                Diberitahukan bahwa telah ada approval oleh QA Manager pada Proses Uji Mikro FG (Khusus Produk ".$stj.")(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
                <div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
                        <table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
                                <tr>
                                        <td style='width: 110px;'><b>No UPB</b></td><td style='width: 20px;'> : </td><td>".$rupb['vupb_nomor']."</td>
                                </tr>
                                <tr>
                                        <td><b>Nama Usulan</b></td><td> : </td><td>".$rupb['vupb_nama']."</td>
                                </tr>
                                <tr>
                                        <td><b>Nama Generik</b></td><td> : </td><td>".$rupb['vgenerik']."</td>
                                </tr>
                                <tr>
                                        <td><b>Team Busdev</b></td><td> : </td><td>".$rupb['bd']."</td>
                                </tr>
                                <tr>
                                        <td><b>Team PD</b></td><td> : </td><td>".$rupb['pd']."</td>
                                </tr>
                                <tr>
                                        <td><b>Team QA</b></td><td> : </td><td>".$rupb['qa']."</td>
                                </tr>
                                <tr>
                                        <td><b>Team QC</b></td><td> : </td><td>".$rupb['qc']."</td>
                                </tr>
                        </table>
                </div>
                <br/> 
                Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
                Post Master";
        /*echo  $to;
        echo '</br>cc:' .$cc;      
        echo  $content ;    
        exit     ;*/
        $this->lib_utilitas->send_email($to, $cc, $subject, $content);
        
		$data['group_id']=$post['group_id'];
		$data['modul_id']=$post['modul_id'];
		$data['status']  = true;
		$data['last_id'] = $post['imikro_fg_id'];
		
		return json_encode($data);
	}

function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#vRemark").val();
					 	if (remark=="") {
					 		alert("Remark tidak boleh kosong ");
					 		return
					 	}
					 	return $.ajax({
					 		url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var url = "'.base_url().'processor/plc/uji/mikro/fg";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=view&id="+last_id+"&group_id="+o.group_id+"&modul_id="+o.modul_id, function(data) {
										 $("div#form_uji_mikro_fg").html(data);
									});
									
								}
									reload_grid("grid_uji_mikro_fg");
							}
					 	 	
					 	 })
					
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_uji_mikro_fg_reject" action="'.base_url().'processor/plc/uji/mikro/fg?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="imikro_fg_id" value="'.$this->input->get('imikro_fg_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_uji_mikro_fg_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function reject_process () {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vRemark = $post['vRemark'];
		$tApprove=date('Y-m-d H:i:s');
		$sql="update plc2.mikro_fg set vremark_uji='".$vRemark."',cappqa_uji='".$cNip."', dappqa_uji='".$tApprove."', iappqa_uji=1 where imikro_fg_id='".$post['imikro_fg_id']."'";
		$this->dbset->query($sql);
		$data['group_id']=$post['group_id'];
		$data['modul_id']=$post['modul_id'];
		$data['status']  = true;
		$data['last_id'] = $post['imikro_fg_id'];
		return json_encode($data);
	}

/*function pendukung end*/    	
function download($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/uji_mikro_fg/'.$id.'/'.$name);	
		force_download($name, $path);
	}

	public function output(){
		$this->index($this->input->get('action'));
	}

}
