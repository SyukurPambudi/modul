<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class lpo extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->dbset = $this->load->database('plc0',false, true);
		$this->load->library('lib_utilitas');
		$this->user = $this->auth_localnon->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;

		$grid->setTitle('Laporan Pemeriksaan Originator');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('lpo');
		$grid->addList('vupb_nomor','vupb_nama','vgenerik','lpo.dmulai_lpo','lpo.dselesai_lpo','lpo.iapppd');
		$grid->setSortBy('iupb_id');
		$grid->setSortOrder('DESC');
		$grid->setLabel('vupb_nomor', 'UPB Nomor');
		$grid->setLabel('vupb_nama', 'Nama Usulan');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setAlign('vupb_nomor', 'center');
		$grid->setWidth('vupb_nomor', '120');
		$grid->setAlign('vupb_nama', 'Left');
		$grid->setWidth('vupb_nama', '200');
		$grid->setAlign('lpo.dmulai_lpo', 'Left');
		$grid->setWidth('lpo.dmulai_lpo', '200');
		$grid->setAlign('lpo.dselesai_lpo', 'Left');
		$grid->setWidth('lpo.dselesai_lpo', '200');
		$grid->setAlign('lpo.iapppd', 'Left');
		$grid->setWidth('lpo.iapppd', '150');
		$grid->addFields('iupb_id','vupb_nama','vgenerik','dmulai_lpo','dselesai_lpo','vPICpd','vfile','iapppd');
		$grid->setLabel('lpo.dmulai_lpo', 'Tgl Mulai Penyusunan');
		$grid->setLabel('lpo.dselesai_lpo', 'Tgl Mulai Penyusunan');
		$grid->setLabel('dmulai_lpo', 'Tgl Mulai Penyusunan');
		$grid->setLabel('dselesai_lpo', 'Tgl Selesai Penyusunan');
		$grid->setLabel('iupb_id', 'No. UPB');
		$grid->setLabel('vgenerik', 'Nama Generik');
		$grid->setLabel('vPICpd', 'PIC Penyusunan');
		$grid->setLabel('vfile', 'Upload File');
		$grid->setLabel('iapppd', 'Approval PD');
		$grid->setLabel('lpo.iapppd', 'Approval PD');;
		$grid->setFormUpload(TRUE);
		$grid->setRequired('iupb_id','dmulai_lpo','dselesai_lpo','vPICpd','vfile');
		
		$grid->setJoinTable('plc2.lpo', 'lpo.iupb_id = plc2_upb.iupb_id', 'left');
		$grid->setJoinTable('plc2.plc2_upb_formula', 'plc2_upb_formula.iupb_id=plc2.plc2_upb.iupb_id','inner');
		//$grid->setJoinTable('pddetail.formula_process','formula_process.iFormula_process=plc2_upb_formula.iFormula_process','inner');
		$grid->setJoinTable('pddetail.formula_process','formula_process.iupb_id=plc2_upb_formula.iupb_id','inner');
		$grid->setJoinTable('pddetail.formula','formula.iFormula_process=formula_process.iFormula_process','inner');
		$grid->setJoinTable('plc2.plc2_upb_buat_mbr', 'plc2_upb_buat_mbr.ifor_id=plc2_upb_formula.ifor_id','inner');
		$grid->setRelation('plc2.plc2_upb.iteampd_id','plc2.plc2_upb_team','iteam_id','vteam','team_pd','inner',array('vtipe'=>'PD', 'ldeleted'=>0),array('vteam'=>'asc'));

		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('PD', $team)){
					$type='PD';
					$grid->setQuery('plc2_upb.iteampd_id IN ('.$this->auth_localnon->my_teams().')', null);
				}
				else{$type='';}
			}
		}
		$grid->setSearch('vupb_nomor','vupb_nama');
		$grid->setQuery('plc2_upb.ldeleted',0);
		$grid->setQuery('plc2_upb_buat_mbr.iapppd_bm',2);
		$grid->setQuery('plc2_upb_buat_mbr.ldeleted',0);
		$grid->setQuery('plc2_upb.ihold',0);
		/*$grid->setQuery('plc2_upb.iupb_id in (select bk.iupb_id from plc2.plc2_upb_bahan_kemas bk where bk.iapppc=2 and bk.iapppd=2 and bk.iappqa=2 and bk.iappbd=2 and bk.ldeleted=0 group by bk.iupb_id)', null); //tambah approval bahan_kemas*/
		$grid->setQuery('plc2_upb.iupb_id in (select bk.iupb_id from plc2.plc2_upb_bahan_kemas bk where bk.iapppd=2 and bk.iappqa=2 and bk.iappbd=2 and bk.ldeleted=0 group by bk.iupb_id)', null); //tambah approval bahan_kemas
		$grid->setQuery('plc2_upb.iupb_id in (select distinct(fo.iupb_id) from plc2.plc2_upb_formula fo
						inner join plc2.plc2_upb_prodpilot pr on pr.ifor_id=fo.ifor_id
						where fo.ldeleted=0 and pr.ldeleted=0 and pr.iapppd_pp=2)',NULL);

		//New Parameter For PLC Non OTC
		$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
		$grid->setQuery('plc2.plc2_upb.iKill', 0);
		$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
		$grid->setQuery('plc2_upb.ihold', 0);

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
				$isUpload = $this->input->get('isUpload');
				$post=$this->input->post();
				$post['dupdate'] = date('Y-m-d H:i:s');
				$post['cUpdate'] =$this->user->gNIP;
					if($post['isdraft']==true){
						$post['isubmit']=0;$isubmit=0;
					} 
					else{$post['isubmit']=1;$isubmit=1;} 
				$post['dmulai_lpo']=date("Y-m-d", strtotime($post['lpo_dmulai_lpo']));
				$post['dselesai_lpo']=date("Y-m-d", strtotime($post['lpo_dselesai_lpo']));

				$this->db_plc0->where('iupb_id', $post['lpo_iupb_id']);		
				$j2 = $this->db_plc0->count_all_results('plc2.lpo');
					$data['iupb_id']=$post['lpo_iupb_id'];
					$data['dmulai_lpo']=$post['dmulai_lpo'];
					$data['dselesai_lpo']=$post['dselesai_lpo'];
					$data['vPICpd']=$post['lpo_vPICpd'];
					$data['isubmit']=$post['isubmit'];
					$data['dupdate']=$post['dupdate'];
					$data['cUpdate']=$post['cUpdate'];
					$data['dCreate']=$post['dupdate'];
					$data['cCreate']=$post['cUpdate'];
				if($j2==0){
					$this->db_plc0->insert('plc2.lpo', $data);
					$sql="select * from plc2.lpo where iupb_id=".$data['iupb_id']." order by ilpo_id DESC limit 1";
					$dt=$this->dbset->query($sql)->row_array();
					$ilpo_id=$dt['ilpo_id'];
				}else{
					$sql="select * from plc2.lpo where iupb_id=".$post['lpo_iupb_id']." order by ilpo_id DESC limit 1";
					$dt=$this->dbset->query($sql)->row_array();
					$ilpo_id=$dt['ilpo_id'];
					$sql="UPDATE plc2.lpo SET iupb_id=".$data['iupb_id'].", dmulai_lpo='".$data['dmulai_lpo']."',
						dselesai_lpo='".$data['dselesai_lpo']."', vPICpd='".$data['vPICpd']."', isubmit=".$data['isubmit'].", 
						dupdate='".$data['dupdate']."', cUpdate='".$data['cUpdate']."' WHERE ilpo_id=".$ilpo_id;
					$this->db_plc0->query($sql);
				}
				$path = realpath("files/plc/lpo/");
				if(!file_exists($path."/".$ilpo_id)){
					if (!mkdir($path."/".$ilpo_id, 0777, true)) { //id review
						die('Failed upload, try again!');
					}
				}			
				$fKeterangan = array();	
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
				$sql1="update plc2.lpo_file set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where ilpo_id='".$ilpo_id."' and ilpo_file_id not in (".$fileid.")";
				$this->dbset->query($sql1);
   				if($isUpload) {	
	   					
					if (isset($_FILES['fileupload']))  {
						$i=0;
						foreach ($_FILES['fileupload']["error"] as $key => $error) {	
							if ($error == UPLOAD_ERR_OK) {
								$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
								$name =$_FILES['fileupload']["name"][$key];
								$data['filename'] = $name;
								$data['dInsertDate'] = date('Y-m-d H:i:s');
								if(move_uploaded_file($tmp_name, $path."/".$ilpo_id."/".$name)) {
									$sqli[]="INSERT INTO plc2.lpo_file (ilpo_id, vFilename, vKeterangan, dCreate, cCreate) 
											VALUES (".$ilpo_id.",'".$data['filename']."','".$fKeterangan[$i]."','".$data['dInsertDate']."','".$this->user->gNIP."')";
									$i++;	
								}
								else{
									echo "Upload ke folder gagal";	
								}
							}
							
						}
					
						foreach($sqli as $ql) {
							try {
								$this->dbset->query($ql);
							}catch(Exception $e) {
								die($e);
							}
						}	

					}
					$r['message']='Data Berhasil Di Simpan!';
					$r['status'] = TRUE;
					$r['last_id'] = $post['lpo_iupb_id'];				
					echo json_encode($r);
					exit();
				}  else {
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
				$iupb_id = $post['iupb_id'];
				$tApprove=date('Y-m-d H:i:s');
				$sql="update plc2.lpo set vapppd='".$cNip."', dapppd='".$tApprove."', iapppd=2 where ilpo_id='".$get['ilpo_id']."'";
				$this->dbset->query($sql);

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
		        $subject="Laporan Pemeriksaan Originator: UPB ".$rupb['vupb_nomor'];
		        $content="
		                Diberitahukan bahwa telah ada approval oleh PD Manager pada proses Laporan Pemeriksaan Originator(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
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
				where em.vName like "%'.$term.'%" and te.vtipe="PD" AND it.ldeleted=0 order by em.vname ASC';
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
function listBox_lpo_lpo_iapppd($value) {
	if($value==0){$vstatus='Waiting for approval';}
	elseif($value==1){$vstatus='Rejected';}
	elseif($value==2){$vstatus='Approved';}
	return $vstatus;
}
function listBox_lpo_lpo_vPICpd($value) {
	$data='-';
	$sql='select em.cNip as cNip, em.vName as vName from hrd.employee em where em.cNip="'.$value.'" LIMIT 1';
	$dt=$this->db_plc0->query($sql)->row_array();
	if($dt){
		$data=$dt['cNip'].' - '.$dt['vName'];
	}
	return $data;
}
function listBox_Action($row, $actions) {
	//print_r($row);
    if($row->lpo__iapppd<>0){
    	unset($actions['edit']);
    }
    return $actions; 

	}
/*manipulasi view object form start*/
 	function updateBox_lpo_iupb_id($field, $id, $value, $rowData){
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nomor'];
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
		$return .= '<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1" value='.$value.' />';
		$return .= '<input type="text" name="'.$id.'_dis" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" value="'.$dt['vupb_nomor'].'" size="20" />';
		}
		return $return;
	}

	function updateBox_lpo_vupb_nama($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vupb_nama'];
		}else{
			$return='<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$dt['vupb_nama'].'" />';
		}
		return $return;
	}
	function updateBox_lpo_vgenerik($field, $id, $value, $rowData) {
		$sql='select * from plc2.plc2_upb where iupb_id='.$rowData['iupb_id'];
		$dt=$this->db_plc0->query($sql)->row_array();
		if($this->input->get('action')=='view'){
			$return=$dt['vgenerik'];
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="20" value="'.$dt['vgenerik'].'" />';
		}
		return $return;
	}
	
	function updateBox_lpo_dmulai_lpo($field, $id, $value, $rowData) {
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.lpo');
		if($j2> 0){
			$sql="select * from plc2.lpo where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=date('d-m-Y',strtotime($dt['dmulai_lpo']));
			if(($value==NULL)||($value=='')||($value=='0000-00-00')){
				$val='';
			}else{
				$val=date('d-m-Y',strtotime($value));
			}
			if($this->input->get('action')=='view'){
			$return	=$val;
			}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" />';
				$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}
		return $return;
	}
	function updateBox_lpo_dselesai_lpo($field, $id, $value, $rowData) {
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.lpo');
		if($j2> 0){
			$sql="select * from plc2.lpo where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=date('d-m-Y',strtotime($dt['dselesai_lpo']));
			if(($value==NULL)||($value=='')||($value=='0000-00-00')){
				$val='';
			}else{
				$val=date('d-m-Y',strtotime($value));
			}
			if($this->input->get('action')=='view'){
				$return	=$val;
			}else{
			$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" value="'.$val.'" />';
			$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}else{
			if($this->input->get('action')=='view'){
			$return	='-';
			}else{
				$return = '<input name="'.$id.'" id="'.$id.'" type="text" size="20" class="input_tgl datepicker required" style="width:130px" />';
				$return .=	'<script>
							$("#'.$id.'").datepicker({dateFormat:"dd-mm-yy"});
						</script>';
			}
		}
		return $return;
	}
	function updateBox_lpo_vPICpd($field, $id, $value, $rowData) {
		$url = base_url().'processor/plc/lpo?action=getemployee';
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
		      </script>';
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.lpo');
		if($j2> 0){
			$sql="select * from plc2.lpo where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['vPICpd'];
			if(($value!=NULL)||($value!='')){
				$sql="select * from plc2.lpo where ilpo_id=".$dt['ilpo_id']." LIMIT 1";
				$dt=$this->db_plc0->query($sql)->row_array();
				$value=$dt['vPICpd'];
				$sql="select * from hrd.employee em where em.cNip='".$value."'";
				$dt=$this->db_plc0->query($sql)->row_array();
				if($this->input->get('action')=='view'){
					$return	=$dt['vName'];
				}else{
					$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" value="'.$value.'" class="required" />
					<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20" value="'.$dt['vName'].'"/>';
				}
			}else{
				if($this->input->get('action')=='view'){
					$return	='-';
				}else{
					$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" class="required" />
					<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20"/>';
				}
			}
		}else{
			if($this->input->get('action')=='view'){
				$return	='-';
			}else{
				$return .='<input name="'.$id.'" id="'.$id.'" type="hidden" class="required" />
				<input name="'.$id.'_text" id="'.$id.'_text" type="text" size="20"/>';
			}
		}
		
		return $return;
	}

    function updateBox_lpo_vfile($field, $id, $value, $rowData) {
    	$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.lpo');
		if($j2> 0){
			$sql="select * from plc2.lpo where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$value=$dt['ilpo_id'];
		}else{$value='0';} 	
		$qr="select * from plc2.lpo_file where ilpo_id='".$value."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('lpo_file',$data,TRUE);
	}
	function updateBox_lpo_iapppd($field, $id, $value, $rowData) {
		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.lpo');
		if($j2> 0){
			$sql="select * from plc2.lpo where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			if($dt['iapppd'] != 0){
				$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$dt['vapppd']))->row_array();
				if($dt['iapppd']==2){$st="Approved";}elseif($dt['iapppd']==1){$st="Rejected";} 
				$ret= $st.' oleh '.$row['vName'].' ( '.$dt['vapppd'].' )'.' pada '.$dt['dapppd'];
			}
			else{
				$ret='Waiting for Approval';
			}
		}else{
			$ret='Waiting for Approval';
		}
		return $ret;
	}
/*manipulasi view object form end*/

/*manipulasi proses object form start*/
	function manipulate_update_button($buttons, $rowData){
		//print_r($rowData);exit();

		$this->db_plc0->where('iupb_id', $rowData['iupb_id']);		
		$j2 = $this->db_plc0->count_all_results('plc2.lpo');
		$ilpo_id=0;
		if($j2> 0){
			$sql="select * from plc2.lpo where iupb_id=".$rowData['iupb_id']." LIMIT 1";
			$dt=$this->db_plc0->query($sql)->row_array();
			$ilpo_id=$dt['ilpo_id'];
		}

		unset($buttons['update']);
		$js=$this->load->view('lpo_js');
		$js .= $this->load->view('uploadjs');
		$cNip=$this->user->gNIP;
		$sql= "select * from plc2.plc2_upb up where up.iupb_id=".$rowData['iupb_id'];
		$dt=$this->dbset->query($sql)->row_array();
		$setuju = '<button onclick="javascript:setuju(\'lpo\', \''.base_url().'processor/plc/lpo?action=confirm&last_id='.$this->input->get('id').'&ilpo_id='.$ilpo_id.'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_soi_fg">Confirm</button>';
		$update = '<button onclick="javascript:update_btn_back(\'lpo\', \''.base_url().'processor/plc/lpo?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_lpo">Update & Submit</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'lpo\', \''.base_url().'processor/plc/lpo?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_lpo">Update as Draft</button>';
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				if($j2> 0){
					$sql="select * from plc2.lpo where ilpo_id=".$ilpo_id." LIMIT 1";
					$dt=$this->db_plc0->query($sql)->row_array();
					if($dt['isubmit']==0){
						$buttons['update']=$updatedraft.$update.$js;
					}
					elseif(($dt['isubmit']<>0)&&($dt['iapppd']==0)){
						$buttons['update']=$setuju.$js;
					}else{}
				}else{
					$buttons['update']=$updatedraft.$update.$js;
				}
				$type='PD';
			}else{

				$type='';
			}
		}else{

			$x=$this->auth_localnon->dept();
			if(isset($x['team'])){
				$team=$x['team'];
				if(in_array('PD', $team)){
					$type='PD';
					if($j2> 0){
						$sql="select * from plc2.lpo where ilpo=".$ilpo_id." LIMIT 1";
						$dt=$this->db_plc0->query($sql)->row_array();
						if($dt['isubmit']==0){
							$buttons['update']=$updatedraft.$update.$js;
						}else{}
					}else{
						$buttons['update']=$updatedraft.$update.$js;
					}
				}else{
					$type='';
				}
			}
		}
		return $buttons;
	}
   
/*manipulasi proses object form end*/    
function before_update_processor($row, $postData) {
	unset($postData['vupb_nama']);
	unset($postData['vgenerik']);
	unset($postData['lpo_dmulai_lpo']);
	unset($postData['lpo_dselesai_lpo']);
	unset($postData['lpo_vPICpd_text']);
	unset($postData['vPICpd']);
	
	//print_r($postData);exit();
	return $postData;

}

/*function pendukung end*/    	
function download($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/lpo/'.$id.'/'.$name);	
		force_download($name, $path);
	}

	public function output(){
		$this->index($this->input->get('action'));
	}

}
