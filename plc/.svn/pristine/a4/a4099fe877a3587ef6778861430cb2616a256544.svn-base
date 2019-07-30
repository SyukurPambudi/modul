<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class test extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
        $this->load->library('lib_flow');
        $this->load->library('biz_process');
        $this->load->library('lib_utilitas');
		$this->user = $this->auth->user(); 
    }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setTitle(' Test Controller ');		
		$grid->setTable('hrd.mnf_supplier');		
		$grid->setUrl('test');
		$grid->addList('vnmsupp','valamat','ldeleted');
		$grid->setSortBy('vnmsupp');
		$grid->setSortOrder('asc');
		$grid->addFields('vnmsupp');
		//$grid->addFields('vkota','inegara_id','vtelp1','vtelp2','vfax','vcontact','vemail1','vemail2','vurl','ldeleted');
		$grid->setLabel('vnmsupp', 'Nama');
		$grid->setLabel('valamat', 'Alamat1');
		$grid->setLabel('valamat2', 'Alamat2');
		$grid->setLabel('vzip', 'Kode Pos');
		$grid->setLabel('vkota', 'Kota');
		$grid->setLabel('inegara_id', 'Negara');
		$grid->setLabel('vtelp1', 'Telp1');
		$grid->setLabel('vtelp2', 'Telp2');
		$grid->setLabel('vfax', 'Fax');
		$grid->setLabel('vemail1', 'Email1');
		$grid->setLabel('vemail2', 'Email2');
		$grid->setLabel('vurl', 'Website');
		$grid->setLabel('vcontact', 'Contact Person');
		$grid->setLabel('ldeleted','Aktif');
		$grid->setSearch('vnmsupp','vcontact','ldeleted');
		$grid->setRequired('vnmsupp','valamat');
		$grid->setRelation('inegara_id','hrd.mnf_negara','inegara_id','vnmnegara');
		$grid->changeFieldType('ldeleted', 'combobox', '', array(''=>'-', 0=>'Aktif', 1=>'Tidak Aktif'));
		$grid->changeFieldType('valamat2', 'text');
		
		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				//echo $grid->saved_form();
				//$this->kirim();
			
				$path = realpath("");
					$poss=$_POST['test_vnmsupp'];

					if (!mkdir('files/plc/'.$poss, 0777, true)) { //id review
						//die('Create Folder Cuy!');
						//echo "create folder daftar_upb ";
						$r['status'] = false;
						$r['message'] = 'Gagal Create Folder done';						
					}else{
						$r['status'] = TRUE;
						$r['message'] = 'Create Folder done';						
					}
						
						echo json_encode($r);
					/*
					if (!mkdir('files/plc/otc/daftar_upb/dok_review', 0777, true)) { //id review
						//die('Create Folder Cuy!');
						echo "create folder daftar_upb ";
					}
					*/

					

			

				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				echo $grid->updated_form();
				break;
			default:
				$grid->render_grid();
				break;
		}
    }

	function output(){
    	$this->index($this->input->get('action'));
    }

    function kirim(){
    	$upbtest = '2438';
    	$qupb="select u.vupb_nomor, u.vupb_nama, u.vgenerik,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteambusdev_id) as bd,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteampd_id) as pd,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqa_id) as qa,
					(select te.vteam from plc2.plc2_upb_team te where te.iteam_id=u.iteamqc_id) as qc
					from plc2.plc2_upb u where u.iupb_id='".$upbtest."'";
			$rupb = $this->db_plc0->query($qupb)->row_array();
			                        
			$qsql="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id 
                                from plc2.plc2_upb u where u.iupb_id='".$upbtest."'";
			$rsql = $this->db_plc0->query($qsql)->row_array();
                        
                        //$query = $this->dbset->query($rsql);
   
                        $pd = $rsql['iteampd_id'];
                        $bd = $rsql['iteambusdev_id'];
                        $qa = $rsql['iteamqa_id'];
                        $qc = $rsql['iteamqc_id'];
                        
                        $team = $pd. ','.$qa. ','.$bd.',' .$qc ;
                        $toEmail2='';
						$toEmail = $this->lib_utilitas->get_email_team( $team );
                        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );
                        $arrEmail = $this->lib_utilitas->get_email_by_nip("N14615");                    
                        
			$to = $cc = '';
			if(is_array($arrEmail)) {
				$count = count($toEmail);
				$to = $toEmail[0];
				for($i=1;$i<$count;$i++) {
					$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
				}
			}	
			
			$to = $toEmail2.$toEmail;
			//$to = $toEmail;
			//$to = 'martha.dewi@novellpharm.com';
			$cc = $arrEmail; 

			//echo $to;
			//exit;                       
			$subject="Local Test Has Been Approved : UPB ".$rupb['vupb_nomor'];
			$content="Diberitahukan bahwa telah ada approval UPB oleh Direksi pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
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
			$this->lib_utilitas->send_email($to, $cc, $subject, $content);

							$r['status'] = TRUE;
                            $r['message'] = "Email Terkirim";
                            echo json_encode($r);
    }
}