<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class dossier_change_pic extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
		$this->dbset = $this->load->database('dosier', true);
		$this->dbset2 = $this->load->database('hrd', true);
		$this->user = $this->auth->user();
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Change PIC');
		$grid->setTable('dossier.dossier_upd');		
		$grid->setUrl('dossier_change_pic');
		$grid->addList('vUpd_no','vNama_usulan','cpic_ir','vpic','vpic_andev');

		$grid->setSortBy('dossier_upd.idossier_upd_id');
		$grid->setSortOrder('DESC'); //sort ordernya

		$grid->addFields('vUpd_no','vNama_usulan','kekuatan','team_ir','history_ir','team_td','history_td','team_ad','history_ad');

		//setting widht grid
		$grid ->setWidth('dossier_upd.vUpd_no', '250'); 
		
		
		//modif label
		$grid->setLabel('vUpd_no','Nomor UPD'); 
		$grid->setLabel('vNama_usulan','Nama Usulan'); 
		$grid->setLabel('vpic','PIC Dossier'); 
		$grid->setLabel('kekuatan','Nama Produk'); 
		$grid->setLabel('vpic_andev','PIC Andev'); 
		$grid->setLabel('team_td','PIC Dossier'); 
		$grid->setLabel('cpic_ir','PIC IR');
		$grid->setLabel('team_ad','PIC Andev'); 
		$grid->setLabel('history_td','History PIC Dossier'); 
		$grid->setLabel('history_ad','History PIC Andev'); 

		$grid->setSearch('vUpd_no');
		
		//relation table

		//Field Mandatori
		$grid->setQuery('(dossier_upd.vNo_nie is null or dossier_upd.vNo_nie = "")',NULL); //Belum Muncul No NIE
		//$grid->setQuery('dossier_upd.iappad_produk_staff',2); 
		$grid->setQuery('dossier_upd.iSubmit_upd',1);
		$grid->setQuery('dossier_upd.lDeleted',0);

		//Field mandatori
		//$grid->setRequired('dossier_upd.vUpd_no');	

		//set groupby
		$grid->setGroupBy('dossier_upd.idossier_upd_id');

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
			case 'delete':
				echo $grid->delete_row();
				break;
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				$post=$this->input->post();
				$get=$this->input->get();
				$sq="select * from dossier.dossier_upd up where up.idossier_upd_id=".$post['dossier_change_pic_idossier_upd_id'];
				$dupd=$this->dbset->query($sq)->row_array();
				$sa3="SELECT pic.ihistory_id, pic.cpic_ir FROM dossier.dossier_history_pic_ir pic WHERE pic.lDeleted=0 AND pic.idossier_upd_id=".$post['dossier_change_pic_idossier_upd_id']."
							ORDER BY pic.ihistory_id DESC LIMIT 1";
				$dt3=$this->dbset->query($sa3)->row_array();
				if(isset($dt3['cpic_ir'])){
					if($dt3['cpic_ir']!=$post['dossier_change_pic_idossier_upd_id']){
						$d['dselesai']=date('Y-m-d H:m:s');
						$this->dbset->where('ihistory_id',$dt3['ihistory_id']);
						$this->dbset->update('dossier.dossier_history_pic_ir',$d);
						$q="select * from dossier.dossier_history_pic_ir pi where pi.ihistory_id=".$dt3['ihistory_id'];
						$da=$this->dbset->query($q)->row_array();
						$data['dmulai']=$d['dselesai'];
						$data['cpic_ir']=$post['dossier_change_pic_idossier_upd_id'];
						$data['idossier_upd_id']=$post['dossier_change_pic_idossier_upd_id'];
						$data['dCreate']=date('Y-m-d H:m:s');
						$data['cCreated']=$this->user->gNIP;
						$this->dbset->insert('dossier.dossier_history_pic_ir',$data);
					}
				}else{
					$data['idossier_upd_id']=$post['dossier_change_pic_idossier_upd_id'];
					$data['cpic_ir']=$post['dossier_change_pic_team_ir'];
					$data['dmulai']=date('Y-m-d H:m:s');
					$data['dCreate']=date('Y-m-d H:m:s');
					$data['cCreated']=$this->user->gNIP;
					$this->dbset->insert('dossier.dossier_history_pic_ir',$data);
				}
				$dataup['cpic_ir']=$post['dossier_change_pic_team_ir'];
				if($dupd['iSubmit_bagi_staff']==1){
					$sa="SELECT pic.ihistory_id, pic.cpic_dossier FROM dossier.dossier_history_pic_dossier pic WHERE pic.lDeleted=0 AND pic.idossier_upd_id=".$post['dossier_change_pic_idossier_upd_id']."
							ORDER BY pic.ihistory_id DESC LIMIT 1";
					$dt1=$this->dbset->query($sa)->row_array();
					if($dt1['cpic_dossier']!=$post['dossier_change_pic_team_td']){
						$d['dselesai']=date('Y-m-d H:m:s');
						$this->dbset->where('ihistory_id',$dt1['ihistory_id']);
						$this->dbset->update('dossier.dossier_history_pic_dossier',$d);
						$q="select * from dossier.dossier_history_pic_dossier pi where pi.ihistory_id=".$dt1['ihistory_id'];
						$da=$this->dbset->query($q)->row_array();
						$data1['dmulai']=$d['dselesai'];
						$data1['cpic_dossier']=$post['dossier_change_pic_team_td'];
						$data1['idossier_upd_id']=$post['dossier_change_pic_idossier_upd_id'];
						$data1['dCreate']=date('Y-m-d H:m:s');
						$data1['cCreated']=$this->user->gNIP;
						$this->dbset->insert('dossier.dossier_history_pic_dossier',$data1);
					}
					$sa2="SELECT pic.ihistory_id, pic.cpic_andev FROM dossier.dossier_history_pic_andev pic WHERE pic.lDeleted=0 AND pic.idossier_upd_id=".$post['dossier_change_pic_idossier_upd_id']."
							ORDER BY pic.ihistory_id DESC LIMIT 1";
					$dt2=$this->dbset->query($sa2)->row_array();
					if($dt2['cpic_andev']!=$post['dossier_change_pic_team_ad']){
						$dt['dselesai']=date('Y-m-d H:m:s');
						$this->dbset->where('ihistory_id',$dt2['ihistory_id']);
						$this->dbset->update('dossier.dossier_history_pic_andev',$dt);
						$q="select * from dossier.dossier_history_pic_andev pi where pi.ihistory_id=".$dt2['ihistory_id'];
						$da=$this->dbset->query($q)->row_array();
						$data2['dmulai']=$dt['dselesai'];
						$data2['cpic_andev']=$post['dossier_change_pic_team_ad'];
						$data2['idossier_upd_id']=$post['dossier_change_pic_idossier_upd_id'];
						$data2['dCreate']=date('Y-m-d H:m:s');
						$data2['cCreated']=$this->user->gNIP;
						$this->dbset->insert('dossier.dossier_history_pic_andev',$data2);
					}
					$dataup['vpic']=$post['dossier_change_pic_team_td'];
					$dataup['vpic_andev']=$post['dossier_change_pic_team_ad'];
					
				}
				$this->dbset->where('idossier_upd_id',$post['dossier_change_pic_idossier_upd_id']);
				$this->dbset->update('dossier_upd',$dataup);
				$r['status'] = TRUE;
				$r['last_id'] = $post['dossier_change_pic_idossier_upd_id'];
				$r['foreign_id'] = 0;
				$r['company_id'] = $get['company_id'];
				$r['group_id'] = $get['group_id'];
				$r['modul_id'] = $get['modul_id'];
				$r['message'] = "Data Updated Successfuly";
				echo json_encode($r);
				break;
			default:
				$grid->render_grid();
				break;
		}
    }

    //Change Main Grid views
    function listBox_dossier_change_pic_vpic($value){
    	$sql="select * from hrd.employee em where em.cNip='".$value."'";
    	$dt=$this->dbset->query($sql);
    	if($dt->num_rows>=1){
    		$d=$dt->row_array();
    		return $value.'-'.$d['vName'];
    	}
    	else{
    		return $value;
    	}
    }
    function listBox_dossier_change_pic_cpic_ir($value){
    	$sql="select * from hrd.employee em where em.cNip='".$value."'";
    	$dt=$this->dbset->query($sql);
    	if($dt->num_rows>=1){
    		$d=$dt->row_array();
    		return $value.'-'.$d['vName'];
    	}
    	else{
    		return $value;
    	}
    }
    function listBox_dossier_change_pic_vpic_andev($value){
    	$sql="select * from hrd.employee em where em.cNip='".$value."'";
    	$dt=$this->dbset->query($sql);
    	if($dt->num_rows>=1){
    		$d=$dt->row_array();
    		return $value.'-'.$d['vName'];
    	}
    	else{
    		return $value;
    	}
    }

    //Update Form Change
    function updateBox_dossier_change_pic_vUpd_no($field, $id, $value, $rowData) {
    	$qs="select * from dossier.dossier_upd up where up.idossier_upd_id=".$rowData['idossier_upd_id'];
    	$d=$this->dbset->query($qs)->row_array();
    	return $d['vUpd_no'];
    }
    function updateBox_dossier_change_pic_vNama_usulan($field, $id, $value, $rowData) {
    	$qs="select * from dossier.dossier_upd up where up.idossier_upd_id=".$rowData['idossier_upd_id'];
    	$d=$this->dbset->query($qs)->row_array();
    	return $d['vNama_usulan'];
    }
    function updateBox_dossier_change_pic_kekuatan($field, $id, $value, $rowData) {
    	$qs='SELECT dossier_upd.vUpd_no,dossier_upd.vNama_usulan,dossier_upd.dTanggal_upd,dossier_upd.cNip_pengusul,
			employee.vName,itemas.C_ITENO,itemas.C_ITNAM,dossier_upd.iSubmit_upd
			FROM dossier.dossier_upd 
			inner join plc2.itemas on itemas.C_ITENO=dossier_upd.iupb_id
			INNER JOIN plc2.tabmas02 ON tabmas02.c_lisensi = itemas.c_lisensi
			LEFT JOIN plc2.teamc ON teamc.c_teamc = itemas.c_teamc
			LEFT JOIN plc2.stocknpl ON stocknpl.c_iteno = itemas.c_iteno
			JOIN hrd.employee ON employee.cNip=dossier_upd.cNip_pengusul
			WHERE dossier_upd.idossier_upd_id='.$rowData['idossier_upd_id'];
    	$d=$this->dbset->query($qs)->row_array();
    	return $d['C_ITENO'].' - '.$d['C_ITNAM'];
    }
    function updateBox_dossier_change_pic_sediaan($field, $id, $value, $rowData) {
    	$qs="select d.* from dossier.dossier_upd up 
    		inner join plc2.plc2_upb u on u.iupb_id=up.iupb_id
    		inner join hrd.mnf_sediaan as d on d.isediaan_id=u.isediaan_id
    		where up.idossier_upd_id=".$rowData['idossier_upd_id'];
    	$d=$this->dbset->query($qs)->row_array();
    	return $d['vsediaan'];
    }
    function updateBox_dossier_change_pic_team_ad($field, $id, $value, $rowData){
    	if($rowData['iSubmit_bagi_staff']==1){
	    	$sql="select * from hrd.employee em where em.cNip='".$rowData['vpic_andev']."'";
	    	$o="";
	    	$d=$this->dbset->query($sql)->row_array();
	    	$v=$rowData['vpic_andev'].'-'.$d['vName'];
	    	$o = '<script>
							$( "button.icon_pop" ).button({
								icons: {
									primary: "ui-icon-newwin"
								},
								text: false
							})
						</script>';
	    	$o.='<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'_dis" class="input_rows1 required" size="25" value="'.$v.'" />';
			$o.='<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="25" value="'.$rowData['vpic_andev'].'" />';
			$o.='&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/pic/dokumen/pembagian/staff?field='.$id.'&gr=AD\',\'List PIC Team Dossier\')" type="button">&nbsp;</button>';
		}else{
			$o="-";
		}
    	return $o;
    }
    function updateBox_dossier_change_pic_team_ir($field, $id, $value, $rowData){
    	
    	$sql="select * from hrd.employee em where em.cNip='".$rowData['cpic_ir']."'";
    	$d=$this->dbset->query($sql)->row_array();
    	$v=$rowData['cpic_ir'].'-'.$d['vName'];
    	
    	$o = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
    	$o.='<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'_dis" class="input_rows1 required" size="25" value="'.$v.'" />';
		$o.='<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="25" value="'.$rowData['cpic_ir'].'" />';
		$o.='&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/pic/dokumen/pembagian/staff?field='.$id.'&gr=IR\',\'List PIC Team IR\')" type="button">&nbsp;</button>';
		

    	return $o;
    }
    function updateBox_dossier_change_pic_team_td($field, $id, $value, $rowData){
    	if($rowData['iSubmit_bagi_staff']==1){
	    	$sql="select * from hrd.employee em where em.cNip='".$rowData['vpic']."'";
	    	$d=$this->dbset->query($sql)->row_array();
	    	$v=$rowData['vpic'].'-'.$d['vName'];
	    	$o = '<script>
							$( "button.icon_pop" ).button({
								icons: {
									primary: "ui-icon-newwin"
								},
								text: false
							})
						</script>';
	    	$o.='<input type="text" name="'.$id.'" disabled="TRUE" id="'.$id.'_dis" class="input_rows1 required" size="25" value="'.$v.'" />';
			$o.='<input type="hidden" name="'.$id.'" id="'.$id.'" class="input_rows1 required" size="25" value="'.$rowData['vpic'].'" />';
			$o.='&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/browse/pic/dokumen/pembagian/staff?field='.$id.'&gr=TD\',\'List PIC Team Dossier\')" type="button">&nbsp;</button>';
		}else{
			$o="-";
		}
    	return $o;
    }
  	function updateBox_dossier_change_pic_history_td($field, $id, $value, $rowData){
  		if($rowData['iSubmit_bagi_staff']==1){
	    	$sa="SELECT pic.ihistory_id FROM dossier.dossier_history_pic_dossier pic WHERE pic.lDeleted=0 AND pic.idossier_upd_id=".$rowData['idossier_upd_id']."
				ORDER BY pic.ihistory_id DESC LIMIT 1";
			$dt=$this->dbset->query($sa)->row_array();
	    	$q="select concat(pi.cpic_dossier, '-', (select em.vName from hrd.employee em where em.cNip=pi.cpic_dossier)) as pic, pi.dmulai as dmulai, pi.dselesai as dselesai from dossier.dossier_history_pic_dossier pi where pi.lDeleted=0 
	    		and pi.ihistory_id not in(".$dt['ihistory_id'].")  
	    		and pi.idossier_upd_id=".$rowData['idossier_upd_id'];
	    	$data['dquery']=$this->dbset->query($q);
	    	$data['table_id']='table_'.$id;
	    	$data['caption']='History PIC Dossier';
	    	$data['lblcaption']='PIC Dossier';
	    	$r=$this->load->view('export/history_pic_ad',$data,TRUE);
	    }else{
	    	$r="-";
	    }
    	return $r;
    } 
    function updateBox_dossier_change_pic_history_ad($field, $id, $value, $rowData){
    	if($rowData['iSubmit_bagi_staff']==1){
	    	$sa="SELECT pic.ihistory_id FROM dossier.dossier_history_pic_andev pic WHERE pic.lDeleted=0 AND pic.idossier_upd_id=".$rowData['idossier_upd_id']."
				ORDER BY pic.ihistory_id DESC LIMIT 1";
			$dt=$this->dbset->query($sa)->row_array();
	    	$q="select concat(pi.cpic_andev, '-', (select em.vName from hrd.employee em where em.cNip=pi.cpic_andev)) as pic, pi.dmulai as dmulai, pi.dselesai as dselesai from dossier.dossier_history_pic_andev pi where pi.lDeleted=0 
	    		and pi.ihistory_id not in(".$dt['ihistory_id'].")  
	    		and pi.idossier_upd_id=".$rowData['idossier_upd_id'];
	    	$data['dquery']=$this->dbset->query($q);
	    	$data['table_id']='table_'.$id;
	    	$data['caption']='History PIC Andev';
	    	$data['lblcaption']='PIC Dossier';
	    	$r=$this->load->view('export/history_pic_ad',$data,TRUE);
	    }else{
	    	$r="-";
	    }
	    return $r;
    }
    function updateBox_dossier_change_pic_history_ir($field, $id, $value, $rowData){
	    	$sa="SELECT pic.ihistory_id FROM dossier.dossier_history_pic_ir pic WHERE pic.lDeleted=0 AND pic.idossier_upd_id=".$rowData['idossier_upd_id']."
				ORDER BY pic.ihistory_id DESC LIMIT 1";
			$dt=$this->dbset->query($sa)->row_array();
			$d=isset($dt['ihistory_id'])?$dt['ihistory_id']:0;
	    	$q="select concat(pi.cpic_ir, '-', (select em.vName from hrd.employee em where em.cNip=pi.cpic_ir)) as pic, pi.dmulai as dmulai, pi.dselesai as dselesai from dossier.dossier_history_pic_ir pi where pi.lDeleted=0 
	    		and pi.ihistory_id not in(".$d.")  
	    		and pi.idossier_upd_id=".$rowData['idossier_upd_id'];
	    	$data['dquery']=$this->dbset->query($q);
	    	$data['table_id']='table_'.$id;
	    	$data['caption']='History PIC IR';
	    	$data['lblcaption']='PIC Dossier';
	    	$r=$this->load->view('export/history_pic_ir',$data,TRUE);
	    return $r;
    }

    public function output(){
		$this->index($this->input->get('action'));
	}
}