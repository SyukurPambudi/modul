<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bahan_baku_approval_ksk extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth_localnon');
		$this->user = $this->auth_localnon->user();
		$this->load->library('biz_process');
        $this->load->library('lib_utilitas');
        $this->load->library('lib_flow');
		$this->_table = 'plc2.plc2_upb_ro_detail';
		$this->_table2 = 'plc2.plc2_raw_material';
		$this->_table3 = 'plc2.plc2_upb_ro_uji_detail';
		$this->_table4 = 'plc2.plc2_upb_ro';
		$this->_table5 = 'plc2.plc2_upb_po';
		$this->_table6 = 'plc2.plc2_upb_request_sample';
		$this->_table7 = 'plc2.plc2_upb';
		$this->load->helper('to_mysql');
	 }
    function index($action = '') {
    	$grid = new Grid;
		$grid->setTitle('Approval KSK');		
		$grid->setTable($this->_table);		
		$grid->setUrl('bahan_baku_approval_ksk');
		$grid->addList('plc2_upb_po.vpo_nomor','plc2_upb_ro.vro_nomor','plc2_upb.vupb_nomor','plc2_raw_material.vnama','isyarat','isubmit_ksk','iappqa_ksk');
		$grid->setJoinTable($this->_table2, $this->_table2.'.raw_id = '.$this->_table.'.raw_id', 'inner');
		$grid->setJoinTable($this->_table4, $this->_table4.'.iro_id = '.$this->_table.'.iro_id', 'inner');
		$grid->setJoinTable($this->_table5, $this->_table5.'.ipo_id = '.$this->_table.'.ipo_id', 'inner');
		$grid->setJoinTable($this->_table6, $this->_table6.'.ireq_id = '.$this->_table.'.ireq_id', 'inner');
		$grid->setJoinTable($this->_table7, $this->_table7.'.iupb_id = '.$this->_table6.'.iupb_id', 'inner');
		$grid->setSortBy('irodet_id');
		$grid->setSortOrder('desc');
		//$grid->setRelation($this->_table_plc_upb.'.iteampd_id', $this->_table_plc_team, 'iteam_id', 'vteam', 'bdteam','inner', array('vtipe'=>'PD','ldeleted'=>0), array('vteam'=>'asc'));		
		$grid->setSearch('plc2_upb_po.vpo_nomor','plc2_upb.vupb_nomor','plc2_raw_material.vnama','isyarat');
		$grid->changeFieldType('isyarat', 'combobox','',array(''=>'--select--', 0=>'-', 1=>'TMS', 2=>'MS'));
		/*$grid->changeFieldType('itujuan', 'combobox','',array(1=>'Bahan Baku Murah', 2=>'Sumber Supplier Baru', 3=>'Harga Murah', 4=>'Lain-lain'));
		$grid->changeFieldType('iprioritas', 'combobox','',array(4=>'Urgent', 1=>'#1', 2=>'#2', 3=>'#3'));
		$grid->changeFieldType('iappmoa', 'combobox','',array(''=>'-', 1=>'Tidak', 2=>'Baik'));
		$grid->changeFieldType('iappmutu', 'combobox','',array(''=>'-', 1=>'Tidak', 2=>'Ada'));
		$grid->changeFieldType('iappinspeksi', 'combobox','',array(''=>'-', 1=>'Tidak', 2=>'Sesuai'));
		$grid->changeFieldType('iapptrial', 'combobox','',array(''=>'-', 1=>'Tidak', 2=>'Sesuai'));*/
		$grid->changeFieldType('istatus', 'combobox','',array(1=>'Has been Approved (Final)', 2=>'Need to be Approved'));

		$grid->addFields('vupb_nomor','vupb_nama','vgenerik','vnama','vsupplier','vfile','vnip_appqa_ksk');
		
		/*$grid->setQuery('plc2_upb.iupb_id in (select f.iupb_id from plc2.plc2_upb_formula f 
									where f.ifor_id in (select st.ifor_id from plc2.plc2_upb_stabilita st where st.inumber=1 and st.iapppd=2))',null); //Approval stabilita lab dengan number yang 1 dan dengan status stabilita lab memenuhi syarat*/
		/*integrasi PD detail , status sudah stabilita lab ambil dari pd detail, minimal sudah ada month dan approval 20170510 by mansur*/
				$grid->setQuery('plc2_upb.iupb_id in(
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
				',null);


		// CEK di soi fg, vamoa dan soi mikro fg
		// $grid->setQuery('plc2_upb.iupb_id in (select up.iupb_id from plc2.plc2_upb up
		// 				inner join plc2.study_literatur_pd st on up.iupb_id=st.iupb_id
		// 				where 
		// 				(case when st.iuji_mikro=1 then
		// 				(case when st.ijenis_sediaan=1
		// 					then up.iupb_id in (select fo.iupb_id from plc2.mikro_fg mi inner join plc2.plc2_upb_formula fo on fo.ifor_id=mi.ifor_id where mi.iappqa_soi=2 and mi.lDeleted=0 and fo.ldeleted=0) AND up.iupb_id in (select sp.iupb_id from plc2.plc2_upb_soi_fg sp where sp.ldeleted=0 and sp.iapppd=2 and sp.iappqa=2) AND up.iupb_id in (select mo.iupb_id from plc2.plc2_vamoa mo where mo.lDeleted=0 and mo.iapppd=2)
		// 					else
		// 						up.iupb_id in (select sp.iupb_id from plc2.plc2_upb_soi_fg sp where sp.ldeleted=0 and sp.iapppd=2 and sp.iappqa=2) AND up.iupb_id in (select mo.iupb_id from plc2.plc2_vamoa mo where mo.lDeleted=0 and mo.iapppd=2)
		// 					end)
		// 				else up.ldeleted=0
		// 				end)
		// 				)',null);
		$grid->setLabel('vupb_nomor','Nomor UPB');
		$grid->setLabel('plc2_upb.vupb_nomor','Nomor UPB');
		$grid->setLabel('vfile', 'Nama File');
		$grid->setLabel('isubmit_ksk', 'Status');

		//$grid->addFields('ipo_id','imanufacture_id','raw_id','vnama_produk','vbatch_no','texp_date','vmetode','vcoa');
		//$grid->addFields('vcatt_handling','itujuan','iprioritas','iappmoa','vcatt_moa','iappmutu','vcatt_mutu','iappinspeksi','vcatt_inspeksi','iapptrial','vcatt_trial','vjmlh_pelanggan');
		//$grid->addFields('vkemampuan_stock','vprofesionalisme','vbonafit','iketerampilan','vcatt_keterampilan','iresult','vcatatan','vnip_appqa_ksk');		
		$grid->setLabel('vupb_nama','Nama Usulan');
		$grid->setLabel('vgenerik','Nama Generik');
		$grid->setLabel('vnama','Nama Bahan Baku');
		$grid->setLabel('vsupplier','Supplier');
		$grid->setLabel('ipo_id','No. PO');
		$grid->setLabel('imanufacture_id','Manufacturer');
		$grid->setLabel('raw_id','Bahan Baku');
		$grid->setLabel('vnama_produk','Nama Produk');
		$grid->setLabel('vbatch_no','No. Batch');
		$grid->setLabel('texp_date','Tanggal expired');
		$grid->setLabel('vmetode','Method of Analysis');
		$grid->setLabel('vcoa','No. CoA');
		$grid->setLabel('vcatt_handling','Cat. Handling');
		$grid->setLabel('itujuan','Tujuan');
		$grid->setLabel('iprioritas','Prioritas');
		$grid->setLabel('iappmoa','Penulisan MoA');
		$grid->setLabel('vcatt_moa','&nbsp;');
		$grid->setLabel('vcatt_mutu','&nbsp;');
		$grid->setLabel('vcatt_inspeksi','&nbsp;');
		$grid->setLabel('vcatt_trial','&nbsp;');
		$grid->setLabel('vcatt_keterampilan','&nbsp;');
		$grid->setLabel('iappmutu','Standar Mutu yang diajukan');
		$grid->setLabel('iappinspeksi','Inspeksi dan Test');
		$grid->setLabel('iapptrial','Trial dan Stabilita');
		$grid->setLabel('vjmlh_pelanggan','Jumlah Pelanggan produk');
		$grid->setLabel('vkemampuan_stock','Kemampuan stok');
		$grid->setLabel('vprofesionalisme','Profesionalisme Manajemen');
		$grid->setLabel('vbonafit','Bonafitas pabrik pembuat');
		$grid->setLabel('iketerampilan','Keterampilan/peralatan khusus');
		$grid->setLabel('iresult', 'Kesimpulan');
		$grid->setLabel('vcatatan','Catatan');
		$grid->setLabel('plc2_raw_material.vnama','Bahan Baku');
		$grid->setLabel('isyarat','Kesimpulan QC');
		$grid->setLabel('plc2_upb_po.vpo_nomor','No. PO');
		$grid->setLabel('plc2_upb_ro.vro_nomor','No. Penerimaan');
		$grid->setLabel('iappqa_ksk','Approval QA');
		$grid->setLabel('iappqc_ksk','Approval QC');
		$grid->setLabel('vnip_appqa_ksk','Approval QA');
		$grid->setLabel('vnip_appqc_ksk','Approval QC');
		
		$grid->setQuery('plc2_upb_ro_detail.ldeleted', 0);	
		// $grid->setQuery('plc2_upb_ro.iapppr', 2);
		// $grid->setQuery('plc2_upb_ro.iclose_po', 1);
		//$grid->setQuery('vrec_jum_pd is not null',null);		
		//tidak diperlukan lagi table ro uji detail
		//$grid->setQuery('plc2_upb_ro_detail.irodet_id in (select rud.irodet_id from plc2.plc2_upb_ro_uji_detail rud where rud.ldeleted=0)',null);		
		//$grid->setQuery('iapppd_analisa',2);

		/*basic required start*/
			$grid->setQuery('plc2.plc2_upb.ldeleted', 0);
			$grid->setQuery('plc2.plc2_upb.iKill', 0);
			$grid->setQuery('plc2.plc2_upb.itipe_id not in (6)',NULL);
			$grid->setQuery('plc2_upb.ihold', 0);
		/*basic required finish*/
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('QA', $manager)){
				$type='QA';
				$grid->setQuery('plc2_upb.iteamqa_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			elseif(in_array('QC', $manager)){
				$type='QC';
				$grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth_localnon->my_teams().')', null);
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
			elseif(in_array('QC', $team)){
				$type='QC';
				$grid->setQuery('plc2_upb.iteamqc_id IN ('.$this->auth_localnon->my_teams().')', null);
			}
			else{$type='';}
		}
		$grid->setFormUpload(TRUE);
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
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				$isUpload = $this->input->get('isUpload');
   				if($isUpload) {	
   					$lastId=$this->input->get('lastId');
					$path = realpath("files/plc/approval_ksk/");
					if(!file_exists($path."/".$lastId)){
						if (!mkdir($path."/".$lastId, 0777, true)) { //id review
							die('Failed upload, try again!');
						}
					}
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
					$sql1="update plc2.approval_ksk_file set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where irodet_id='".$lastId."' and iapp_ksk_id not in (".$fileid.")";
					$this->db_plc0->query($sql1);
					$i=0;
					foreach ($_FILES['fileupload']["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {
							$tmp_name = $_FILES['fileupload']["tmp_name"][$key];
							$name =$_FILES['fileupload']["name"][$key];
							$data['filename'] = $name;
							//$data['id']=$idossier_dok_list_id;
							$data['dInsertDate'] = date('Y-m-d H:i:s');

								if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name)) {
									$sql[]="INSERT INTO plc2.approval_ksk_file (irodet_id, vFilename, vKeterangan, dCreate, cCreate) 
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
						$this->db_plc0->query($q);
						}catch(Exception $e) {
						die($e);
						}
					}
					$r['message'] = 'Data Berhasil di Simpan!';
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');					
					echo json_encode($r);
				}  else {
					echo $grid->updated_form();
				}
				break;
			case 'delete':
				echo $grid->delete_row();
				break;
			case 'download':
				$this->download($this->input->get('file'));
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
			case 'confirm':
				$post=$this->input->post();
				$get=$this->input->get();
		    	if($this->auth_localnon->is_manager()){
					$x=$this->auth_localnon->dept();
					$manager=$x['manager'];
					if(in_array('QA', $manager)){
						$type='QA';
					}
					elseif(in_array('QC', $manager)){
						$type='QC';
					}
					else{$type='';}
				}
				else{$type='';}
		    	$nip = $this->user->gNIP;
				$skg=date('Y-m-d H:i:s');
				$iapp=$type=='QA'?'iappqa_ksk':'iappqc_ksk';
				$vnip=$type=='QA'?'vnip_appqa_ksk':'vnip_appqc_ksk';
				$tapp=$type=='QA'?'tappqa_ksk':'tappqc_ksk';
				$this->db_plc0->where('irodet_id', $get['last_id']);
				$this->db_plc0->update('plc2.plc2_upb_ro_detail', array($iapp=>2,$vnip=>$nip,$tapp=>$skg));
		    
		    	$ipo_id = $get['ipo_id'];
		    	$irodet_id = $get['last_id'];
		        $vnama = $get['vnama'];

		        
		        $hsql= "select a.vpo_nomor,c.vnmsupp,a.trequest,a.tdeadline,a.vor_nomor,a.ttransfer,
		                a.tapp_pur,a.vnip_pur
		                	from plc2.plc2_upb_po a
		                left outer join hrd.mnf_supplier c on c.isupplier_id = a.isupplier_id
		                where a.ipo_id = ".$ipo_id;

		        
		        $rupb = $this->db_plc0->query($hsql)->row_array();
		        
		        $vpo_nomor= $rupb['vpo_nomor'];
		        $vnmsupp = $rupb['vnmsupp'];
		        $vtdeadline= $rupb['tdeadline'];
		        $vor_nomor= $rupb['vor_nomor'];
		        $trequest= $rupb['trequest'];
		        $ttransfer = $rupb['ttransfer'];
		        $tapp_pur= $rupb['tapp_pur'];
		        $vnip_pur = $rupb['vnip_pur'];                        

				$qiupb="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id
		                from plc2.plc2_upb u 
		                where u.iupb_id in (
		                select distinct(rs.iupb_id) from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
							select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id))";        

		        $rsql = $this->db_plc0->query($qiupb)->row_array();

		        $pd = $rsql['iteampd_id'];

		        $sql1="select ra.vnama as vnama from plc2.plc2_upb_ro_detail ro
					inner join plc2.plc2_raw_material ra on ro.raw_id=ra.raw_id
					where ro.irodet_id=".$get['last_id'];

				$dt=$this->db_plc0->query($sql1)->row_array();
				$vnama='-';
				if($dt){
					$vnama=$dt['vnama'];
				}else{$vnama='-';}


		        $team = $pd ;
		        
		        $toEmail2='';
		        $toEmail = $this->lib_utilitas->get_email_team( $pd );
		        $toEmail2 = $this->lib_utilitas->get_email_leader( $pd );                        

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
		        $cc = $arrEmail;
		        $subject="Proses Approval KSK ".$vpo_nomor." Selesai";
		        $content="
		                Diberitahukan bahwa telah ada approval pada proses Approval KSK(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
		                <div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
		                        <table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
		                                <tr>
		                                        <td style='width: 110px;'><b>No PO</b></td><td style='width: 20px;'> : </td><td>".$vpo_nomor."</td>
		                                </tr>
		                                <tr>
		                                        <td><b>Bahan Baku</b></td><td> : </td><td>".$vnama."</td>
		                                </tr>
		                                <tr>
		                                        <td><b>Proses Selanjutnya</b></td><td> : </td><td>Stabilita Lab - Input oleh PD/AD</td>
		                                </tr>
		                        </table>
		                </div>
		                <br/> 
		                Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
		                Post Master";
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
	function listBox_bahan_baku_approval_ksk_iappqa_ksk($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
    function listBox_bahan_baku_approval_ksk_iappqc_ksk($value) {
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
    function listBox_bahan_baku_approval_ksk_isubmit_ksk($value) {
    	if($value==0){$vstatus='Draft - Need to be Submit';}
    	elseif($value==1){$vstatus='Submited';}
    	return $vstatus;
    }
    function listBox_Action($row, $actions) {
	    //print_r($row);
	    if($row->iappqa_ksk<>0){
	    	unset($actions['edit']);
	    }
	    if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			/*if(in_array('QC', $manager)){
				$type='QC';
				if(($row->isubmit_ksk<>0)&&($row->iappqa_ksk<>0)&&($row->iappqc_ksk<>0)){
					unset($actions['edit']);
				}
			}else*/

			if(in_array('PD', $manager)){
				$type='PD';
				if($row->isubmit_ksk<>0){
					unset($actions['edit']);
				}
			}elseif(in_array('QA', $manager)){
				$type='QA';
				if($row->isubmit_ksk==0){
					unset($actions['edit']);
				}
			}
			else{$type='';}
		}
		else{
			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			/*if(in_array('QC', $team)){
				$type='QC';
				unset($actions['edit']);
			}else*/
			if(in_array('PD', $team)){
				$type='PD';
				if($row->isubmit_ksk<>0){
					unset($actions['edit']);
				}
			}elseif(in_array('QA', $team)){
				$type='QA';
				unset($actions['edit']);
			}
		}
    return $actions; 
}
	//Keterangan approval 

	//editing updatebox new
    function updateBox_bahan_baku_approval_ksk_vupb_nomor($field, $id, $value, $rowData){
    	$ipo_id=$rowData['ipo_id'];
    	$qiupb="select distinct(up.vupb_nomor) as vupb_nomor from plc2.plc2_upb_request_sample rs 
				inner join plc2.plc2_upb up on rs.iupb_id=up.iupb_id
				where rs.ireq_id in (select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id) Limit 1";
		$return ='<input type="hidden" name="bahan_baku_approval_ksk_ipo_id" value="'.$rowData['ipo_id'].'">';
		$return .= '<input type="hidden" name="isdraft" id="isdraft">';
		$dt=$this->db_plc0->query($qiupb)->row_array();
		if($dt){
			$data=$dt['vupb_nomor'];
		}else{$data='-';}
		if($this->input->get('action')=='view'){
			$vupb_nomor=$data;
		}else{
			$vupb_nomor='<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="35" value="'.$data.'" />';
		}
		$return .=$vupb_nomor;
		//print_r($rowData);
		return $return;
    }

    function updateBox_bahan_baku_approval_ksk_vupb_nama($field, $id, $value, $rowData) {
		$ipo_id=$rowData['ipo_id'];
    	$qiupb="select distinct(up.vupb_nama) as vupb_nama from plc2.plc2_upb_request_sample rs 
				inner join plc2.plc2_upb up on rs.iupb_id=up.iupb_id
				where rs.ireq_id in (select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id) Limit 1";
		$dt=$this->db_plc0->query($qiupb)->row_array();
		if($dt){
			$data=$dt['vupb_nama'];
		}else{$data='-';}
		if($this->input->get('action')=='view'){
			$return=$data;
		}else{
			$return='<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="35" value="'.$data.'" />';
		}
		return $return;
	}
	function updateBox_bahan_baku_approval_ksk_vgenerik($field, $id, $value, $rowData) {
		$ipo_id=$rowData['ipo_id'];
    	$qiupb="select distinct(up.vgenerik) as vgenerik from plc2.plc2_upb_request_sample rs 
				inner join plc2.plc2_upb up on rs.iupb_id=up.iupb_id
				where rs.ireq_id in (select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id) Limit 1";
		$dt=$this->db_plc0->query($qiupb)->row_array();
		if($dt){
			$data=$dt['vgenerik'];
		}else{$data='-';}
		if($this->input->get('action')=='view'){
			$return=$data;
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="35" value="'.$data.'" />';
		}
		return $return;
	}

	function updateBox_bahan_baku_approval_ksk_vnama($field, $id, $value, $rowData) {
		$raw_id=$rowData['raw_id'];
    	$qiupb="select raw.vnama as vnama from plc2.plc2_raw_material raw where raw.raw_id='".$raw_id."'";
		$dt=$this->db_plc0->query($qiupb)->row_array();
		if($dt){
			$data=$dt['vnama'];
		}else{$data='-';}
		if($this->input->get('action')=='view'){
			$return=$data;
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="35" value="'.$data.'" />';
		}
		return $return;
	}

	function updateBox_bahan_baku_approval_ksk_vsupplier($field, $id, $value, $rowData) {
		$raw_id=$rowData['ipo_id']; 
    	$qiupb="SELECT m.vnmsupp FROM plc2.plc2_upb_po p join
			hrd.mnf_supplier m on m.isupplier_id = p.isupplier_id
			where p.ipo_id = '".$raw_id."' and p.ldeleted=0 LIMIT 1";
		$dt=$this->db_plc0->query($qiupb)->row_array();
		if($dt){
			$data=$dt['vnmsupp'];
		}else{$data='-';}
		if($this->input->get('action')=='view'){
			$return=$data;
		}else{
			$return	= '<input type="text" disabled="TRUE" name="'.$id.'_dis" id="'.$id.'_dis" class="input_rows1" size="35" value="'.$data.'" />';
		}
		return $return;
	}

    function updateBox_bahan_baku_approval_ksk_vfile($field, $id, $value, $rowData){
    	$qr="select * from plc2.approval_ksk_file where irodet_id='".$rowData['irodet_id']."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');	
		return $this->load->view('bahan_baku_approval_ksk_file',$data,TRUE);
    }
    function updateBox_bahan_baku_approval_ksk_vnip_appqa_ksk($field, $id, $value, $rowData) {
	//print_r($rowData);
		if($rowData['vnip_appqa_ksk'] != null){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vnip_appqa_ksk']))->row_array();
			if($rowData['iappqa_ksk']==2){$st="Approved";}elseif($rowData['iappqa_ksk']==1){$st="Rejected";
				// $rowa = $this->db_plc0->get_where('plc2.plc2_upb_approve', array('vmodule'=>$this->input->get('modul_id'), 'iupb_id'=>$rowData['iupb_id']))->row_array();
				// if(isset($rowa)){$reason=$rowa['treason'];}
				
			} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vnip_appqa_ksk'].' )'.' pada '.$rowData['tappqa_ksk'];
			// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
	function updateBox_bahan_baku_approval_ksk_vnip_appqc_ksk($field, $id, $value, $rowData) {
	//print_r($rowData);
		if($rowData['vnip_appqc_ksk'] != null){
			$row = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rowData['vnip_appqc_ksk']))->row_array();
			if($rowData['iappqc_ksk']==2){$st="Approved";}elseif($rowData['iappqc_ksk']==1){$st="Rejected";
				// $rowa = $this->db_plc0->get_where('plc2.plc2_upb_approve', array('vmodule'=>$this->input->get('modul_id'), 'iupb_id'=>$rowData['iupb_id']))->row_array();
				// if(isset($rowa)){$reason=$rowa['treason'];}
				
			} 
			$ret= $st.' oleh '.$row['vName'].' ( '.$rowData['vnip_appqc_ksk'].' )'.' pada '.$rowData['tappqc_ksk'];
			// if(isset($rowa)){$ret.='<br>Alasan: '.$reason;}
		}
		else{
			$ret='Waiting for Approval';
		}
		
		return $ret;
	}
/*
    //editing updatebox old
	function insertBox_bahan_baku_approval_ksk_vnip_appqa_ksk($field, $id) {
		return '-';
	}
	
	
	//
	function updateBox_bahan_baku_approval_ksk_ipo_id($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_upb_po', array('ipo_id'=>$rowData['ipo_id']))->row_array();
		$return ='<span id="'.$id.'">'.$row['vpo_nomor'].'</span>
		<input type="hidden" name="'.$id.'" value="'.$rowData['ipo_id'].'">
		';
		$return .= '<input type="hidden" name="isdraft" id="isdraft">';
		return $return;
	}
	function updateBox_bahan_baku_approval_ksk_imanufacture_id($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('hrd.mnf_manufacturer', array('imanufacture_id'=>$rowData['imanufacture_id']))->row_array();
		//return '<span id="'.$id.'">'.$row['vnmmanufacture'].'</span>';
		if(sizeOf($row) > 0){
			return '<span id="'.$id.'">'.$row['vnmmanufacture'].'</span>';
		}
		else{
			return '-';
		}
	}
	function updateBox_bahan_baku_approval_ksk_raw_id($name, $id, $value, $rowData) {
		$row = $this->db_plc0->get_where('plc2.plc2_raw_material', array('raw_id'=>$rowData['raw_id']))->row_array();
		return '<span id="'.$id.'">'.$row['vnama'].'</span>
        <input type="hidden" name="'.$id.'" value="'.$rowData['raw_id'].'">
        ';
	}
	function updateBox_bahan_baku_approval_ksk_vnama_produk($name, $id, $value, $rowData) {
		return '<span id="'.$id.'">'.$value.'</span>';
	}
	function updateBox_bahan_baku_approval_ksk_vbatch_no($name, $id, $value, $rowData) {
		return '<span id="'.$id.'">'.$value.'</span>';
	}
	function updateBox_bahan_baku_approval_ksk_texp_date($name, $id, $value, $rowData) {
		if($value != '' && $value != '0000-00-00') {
			$value = date('d M Y', strtotime($value));
		}
		else {
			$value = '';
		}		
		return '<span id="'.$id.'">'.$value.'</span>';
	}
	function updateBox_bahan_baku_approval_ksk_vmetode($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		if(in_array('PR', $mydept)) {
			return '<input type="text" size="50" value="'.$value.'" name="'.$name.'" id="'.$id.'" />';
		}
		else {
			return '<span id="'.$id.'">'.$value.'</span>';
		}		
	}
	function updateBox_bahan_baku_approval_ksk_vcoa($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		if(in_array('PR', $mydept)) {
			return '<input type="text" value="'.$value.'" name="'.$name.'" id="'.$id.'" />';
		}
		else {
			return '<span id="'.$id.'">'.$value.'</span>';
		}		
	}
	function updateBox_bahan_baku_approval_ksk_vcatt_handling($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		if(in_array('PR', $mydept)) {
			return '<input type="text" size="50" value="'.$value.'" name="'.$name.'" id="'.$id.'" />';
		}
		else {
			return '<span id="'.$id.'">'.$value.'</span>';
		}		
	}
	function updateBox_bahan_baku_approval_ksk_itujuan($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		$array = array(''=>'--select--',0=>'-', 1=>'Bahan Baku Murah', 2=>'Sumber Supplier Baru', 3=>'Harga Murah', 4=>'Lain-lain');
		if(in_array('PR', $mydept)) {
			return form_dropdown($name, $array, $value);
		}
		else {
			return '<span id="'.$id.'">'.$array[$value].'</span>';
		}		
	}
	function updateBox_bahan_baku_approval_ksk_iprioritas($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		$array = array(''=>'--select--','0'=>'-', 4=>'Urgent', 1=>'#1', 2=>'#2', 3=>'#3');
		if(in_array('PR', $mydept)) {
			return form_dropdown($name, $array, $value);
		}
		else {
			return '<span id="'.$id.'">'.$array[$value].'</span>';
		}		
	}
	function updateBox_bahan_baku_approval_ksk_iappmoa($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		$array = array(''=>'--select--',0=>'-', 1=>'Tidak', 2=>'Baik');
		if(in_array('PD', $mydept)) {
			return form_dropdown($name, $array, $value);
		}
		else {
			return '<span id="'.$id.'">'.$array[$value].'</span>';
		}		
	}	
	function updateBox_bahan_baku_approval_ksk_vcatt_moa($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		if(in_array('PD', $mydept)) {
			return '<input type="text" size="50" value="'.$value.'" name="'.$name.'" id="'.$id.'" />';
		}
		else {
			return '<span id="'.$id.'">'.$value.'</span>';
		}		
	}
	function updateBox_bahan_baku_approval_ksk_iappmutu($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		$array = array(''=>'--select--',0=>'-', 1=>'Tidak', 2=>'Ada');
		if(in_array('PD', $mydept)) {
			return form_dropdown($name, $array, $value);
		}
		else {
			return '<span id="'.$id.'">'.$array[$value].'</span>';
		}		
	}
	function updateBox_bahan_baku_approval_ksk_vcatt_mutu($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		if(in_array('PD', $mydept)) {
			return '<input type="text" size="50" value="'.$value.'" name="'.$name.'" id="'.$id.'" />';
		}
		else {
			return '<span id="'.$id.'">'.$value.'</span>';
		}		
	}
	function updateBox_bahan_baku_approval_ksk_iappinspeksi($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		$array = array(''=>'--select--',0=>'-', 1=>'Tidak', 2=>'Sesuai');
		if(in_array('PD', $mydept)) {
			return form_dropdown($name, $array, $value);
		}
		else {
			return '<span id="'.$id.'">'.$array[$value].'</span>';
		}		
	}
	function updateBox_bahan_baku_approval_ksk_vcatt_inspeksi($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		if(in_array('PD', $mydept)) {
			return '<input type="text" size="50" value="'.$value.'" name="'.$name.'" id="'.$id.'" />';
		}
		else {
			return '<span id="'.$id.'">'.$value.'</span>';
		}		
	}
	function updateBox_bahan_baku_approval_ksk_iapptrial($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		$array = array(''=>'--select--',0=>'-', 1=>'Tidak', 2=>'Sesuai');
		if(in_array('PD', $mydept)) {
			return form_dropdown($name, $array, $value);
		}
		else {
			return '<span id="'.$id.'">'.$array[$value].'</span>';
		}		
	}
	function updateBox_bahan_baku_approval_ksk_vcatt_trial($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		if(in_array('PD', $mydept)) {
			return '<input type="text" size="50" value="'.$value.'" name="'.$name.'" id="'.$id.'" />';
		}
		else {
			return '<span id="'.$id.'">'.$value.'</span>';
		}		
	}
	function updateBox_bahan_baku_approval_ksk_vjmlh_pelanggan($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		if(in_array('PR', $mydept)) {
			return '<input type="text" value="'.$value.'" name="'.$name.'" id="'.$id.'" />';
		}
		else {
			return '<span id="'.$id.'">'.$value.'</span>';
		}		
	}
	function updateBox_bahan_baku_approval_ksk_vkemampuan_stock($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		if(in_array('PR', $mydept)) {
			return '<input type="text" size="50" value="'.$value.'" name="'.$name.'" id="'.$id.'" />';
		}
		else {
			return '<span id="'.$id.'">'.$value.'</span>';
		}		
	}
	function updateBox_bahan_baku_approval_ksk_vprofesionalisme($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		if(in_array('PR', $mydept)) {
			return '<input type="text" size="35" value="'.$value.'" name="'.$name.'" id="'.$id.'" />';
		}
		else {
			return '<span id="'.$id.'">'.$value.'</span>';
		}		
	}
	function updateBox_bahan_baku_approval_ksk_vbonafit($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		if(in_array('PR', $mydept)) {
			return '<input type="text" size="35" value="'.$value.'" name="'.$name.'" id="'.$id.'" />';
		}
		else {
			return '<span id="'.$id.'">'.$value.'</span>';
		}		
	}
	function updateBox_bahan_baku_approval_ksk_iketerampilan($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		$array = array(''=>'--select--',0=>'-', 1=>'Tidak', 2=>'Baik');
		if(in_array('PR', $mydept)) {
			return form_dropdown($name, $array, $value);
		}
		else {
			return '<span id="'.$id.'">'.$array[$value].'</span>';
		}		
	}	
	function updateBox_bahan_baku_approval_ksk_vcatt_keterampilan($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		if(in_array('PR', $mydept)) {
			return '<input type="text" size="50" value="'.$value.'" name="'.$name.'" id="'.$id.'" />';
		}
		else {
			return '<span id="'.$id.'">'.$value.'</span>';
		}		
	}
	function updateBox_bahan_baku_approval_ksk_iresult($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		$array = array(''=>'--select--',0=>'-', 1=>'Ditolak', 2=>'Disetujui');
		if(in_array('QA', $mydept)) {
			return form_dropdown($name, $array, $value);
		}
		else {
			return '<span id="'.$id.'">'.$array[$value].'</span>';
		}		
	}
	function updateBox_bahan_baku_approval_ksk_vcatatan($name, $id, $value, $rowData) {
		$mydept = $this->auth_localnon->my_depts(TRUE);
		if(in_array('QA', $mydept)) {
			return '<input type="text" size="50" value="'.$value.'" name="'.$name.'" id="'.$id.'" />';
		}
		else {
			return '<span id="'.$id.'">'.$value.'</span>';
		}		
	}*/

	function before_update_processor($row, $post, $postData) {
		/*$user = $this->auth_localnon->user();
		$skrg = date('Y-m-d H:i:s');
		$postData['trec_date_pd'] = to_mysql($postData['trec_date_pd']);
		$postData['trec_date_qc'] = to_mysql($postData['trec_date_qc']);
		$postData['trec_date_qa'] = to_mysql($postData['trec_date_qa']);*/
		/*$mydept = $this->auth_localnon->my_depts(TRUE);
		$type='';
		if(in_array('QA', $mydept)) {
			$type='QA';
		}elseif(in_array('PR', $mydept)){
			$type='PR';
		}elseif (in_array('PD', $mydept)) {
			$type='PD';
		}
		if ($postData['isdraft']==true) {
			if($type=='QA'){$postData['isubmitqa']=0;}
			elseif($type=='PR'){$postData['isubmitpr']=0;}
			elseif($type=='PD'){$postData['isubmitpd']=0;}
		}
		else{
			if($type=='QA'){$postData['isubmitqa']=1;}
			elseif($type=='PR'){$postData['isubmitpr']=1;}
			elseif($type=='PD'){$postData['isubmitpd']=1;}
		}
		if($postData['isdraft']=='nol'){
			if($type=='QA'){unset($postData['isubmitqa']);}
			elseif($type=='PR'){unset($postData['isubmitpr']);}
			elseif($type=='PD'){unset($postData['isubmitpd']);}
		}*/
		$postData['dupdate'] = date('Y-m-d H:i:s');
		$postData['cUpdate'] =$this->user->gNIP;
		if($postData['isdraft']==true){
			$postData['isubmit_ksk']=0;
		} 
		else{$postData['isubmit_ksk']=1;} 
		//print_r($postData);exit();
		return $postData;
	}
	function after_update_processor($row, $insertId, $postData, $old_data) {
		$this->load->helper(array('search_array','mydb'));
		$this->plcdb = mydb('plc');
		$post = $this->input->post();
		$mydept = $this->auth_localnon->my_depts(TRUE);
		/*$master_action=0;
		if(in_array('QA', $mydept)) {
			$master_action=11;
		}elseif(in_array('PR', $mydept)){
			$master_action=13;
		}elseif (in_array('PD', $mydept)) {
			$master_action=6;
		}*/
		//print_r($postData);
		
		$ipo_id = $postData['ipo_id'];
		//get upb_id
		$qiupb="select distinct(rs.iupb_id) as iupb_id from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
					select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id) Limit 1";
		$riu = $this->db_plc0->query($qiupb)->row_array();
		$iupb_id=$riu['iupb_id'];
		/*if(($postData['isdraft']!=true)&&($postData['isdraft']!='nol')){
			if($master_action!=0){
				$this->lib_flow->insert_logs($this->input->get('modul_id'),$iupb_id,$master_action);
			}
		}
		
		foreach($riu as $xx){
			$iupb_id=$xx['iupb_id'];
			$getbp=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // activity 3 input data
			$bizsup=$getbp['idplc2_biz_process_sub'];
			
			$hacek=$this->biz_process->cek_last_status($iupb_id,$bizsup,7); // status 7 => submit
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 7); // status 7 => submit
				//update last log
					$this->biz_process->update_last_log($iupb_id, $bizsup, 7);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($iupb_id, $bizsup, 7); // status 7 => submit
				//insert last log
					$this->biz_process->insert_last_log($iupb_id, $bizsup, 7);
			}
		}*/
	}/*
	function manipulate_update_button($buttons, $rowData) {
    	unset($buttons['update_back']);
    	unset($buttons['update']);
		//print_r($rowData);exit();
		//echo $rowData['vnip_formulator']."<br>".$this->user->gNIP;
    	$user = $this->auth_localnon->user();
    
    	$x=$this->auth_localnon->dept();
    	if($this->auth_localnon->is_manager()){
    		$x=$this->auth_localnon->dept();
    		$manager=$x['manager'];
    		if(in_array('PD', $manager)){$type='PD';}
    		elseif(in_array('PR', $manager)){$type='PR';}
    		elseif(in_array('QA', $manager)){$type='QA';}
    		elseif(in_array('QC', $manager)){$type='QC';}
    		else{$type='';}
    	}
		else{
			$x=$this->auth_localnon->dept();
    		$team=$x['team'];
			if(in_array('PD', $team)){$type='PD';}
			elseif(in_array('PR', $team)){$type='PR';}
			elseif(in_array('QA', $team)){$type='QA';}
			elseif(in_array('QC', $team)){$type='QC';}
			else{$type='';}
		}
		
		//echo $type;
		// cek status upb, klao upb 
			unset($buttons['update_back']);
    		unset($buttons['update']);
			
			//echo $this->auth_localnon->my_teams();
			
    		$ipo_id=$rowData['ipo_id'];
    		$irodet_id=$rowData['irodet_id'];


            $rawId = intval ($rowData['raw_id']);
			$qiupb="select vnama from plc2.plc2_raw_material where raw_id = $rawId";
			$raw = $this->db_plc0->query($qiupb)->row_array();;
            
            $vnama = $raw['vnama'];
			//get upb_id
			$qiupb="select distinct(rs.iupb_id) from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
						select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id)";
			$riu = $this->db_plc0->query($qiupb)->result_array();
			//print_r($riu);

			$qcek="select * from plc2.plc2_upb_ro_detail f where f.irodet_id=$irodet_id";
			$rcek = $this->db_plc0->query($qcek)->row_array();
			
			$x=$this->auth_localnon->my_teams();
			//print_r($x);
			$arrhak=$this->biz_process->get(3, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // 3 input data
		//print_r($arrhak);
		//echo $type;
			$js = $this->load->view('bahan_baku_approval_ksk_js');
			$update = '<button onclick="javascript:update_btn_back(\'bahan_baku_approval_ksk\', \''.base_url().'processor/plc/bahan/baku/approval/ksk?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_bahan_baku_approval_ksk">Update & Submit</button>';
			$updatedraft = '<button onclick="javascript:update_draft_btn(\'bahan_baku_approval_ksk\', \''.base_url().'processor/plc/bahan/baku/approval/ksk?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_bahan_baku_approval_ksk">Update as Draft</button>';
			$updatedraft2 = '<button onclick="javascript:update_draft2(\'bahan_baku_approval_ksk\', \''.base_url().'processor/plc/bahan/baku/approval/ksk?company_id='.$this->input->get('company_id').'&draft=nol&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, \'nol\')" class="ui-button-text icon-save" id="button_save_bahan_baku_approval_ksk">Update</button>';
			if(empty($arrhak)){
				$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$this->input->get('modul_id')); // 3 input data
				if(empty($getbp)){}
				else{
					if($this->auth_localnon->is_manager()){ //jika manager PR
						if(($type=='QA')&&($rcek['iappqa_ksk']==0)){
							//$update = '<button onclick="javascript:update_btn_upload(\'bahan_baku_approval_ksk\', \''.base_url().'processor/plc/bahan/baku/approval/ksk?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_bb_approval_ksk">Update</button>';
							$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/baku/approval/ksk?action=approve&ipo_id='.$ipo_id.'&irodet_id='.$irodet_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'&vnama='.$vnama.'\')" class="ui-button-text icon-save" id="button_approve_bb_approval_ksk">Approve</button>';
							$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/baku/approval/ksk?action=reject&ipo_id='.$ipo_id.'&irodet_id='.$irodet_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bb_approval_ksk">Reject</button>';
							if($rowData['isubmitqa']==0){
								$buttons['update'] = $updatedraft.$update.$js;
							}else{
								$buttons['update'] = $updatedraft2.$approve.$reject.$js;
							}
						}
						elseif((($type=='PR')||($type=='PD'))&&($rcek['iappqa_ksk']==0)){
							//$update = '<button onclick="javascript:update_btn_upload(\'bahan_baku_approval_ksk\', \''.base_url().'processor/plc/bahan/baku/approval/ksk?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_bb_approval_ksk">Update</button>';
							if(($rowData['isubmitpr']==0)&&($type=='PR')){
								$buttons['update'] = $updatedraft.$update.$js;
							}elseif(($rowData['isubmitpd']==0)&&($type=='PD')){
								$buttons['update'] = $updatedraft.$update.$js;
							}else{
								$buttons['update'] = $updatedraft2.$js;
							}
						}
						else{}
					}
					else{
						if((($type=='PR')||($type=='PD'))&&($rcek['iappqa_ksk']==0)){
							//$update = '<button onclick="javascript:update_btn_upload(\'bahan_baku_approval_ksk\', \''.base_url().'processor/plc/bahan/baku/approval/ksk?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_bb_approval_ksk">Update</button>';
								
							if(($rowData['isubmitpr']==0)&&($type=='PR')){
								$buttons['update'] = $updatedraft.$update.$js;
							}elseif(($rowData['isubmitpd']==0)&&($type=='PD')){
								$buttons['update'] = $updatedraft.$update.$js;
							}else{}
						}
						else{}
					}
				}
			}else{
				if($this->auth_localnon->is_manager()){ //jika manager PR
					if(($type=='QA')&&($rcek['iappqa_ksk']==0)){
						//$update = '<button onclick="javascript:update_btn_upload(\'bahan_baku_approval_ksk\', \''.base_url().'processor/plc/bahan/baku/approval/ksk?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_bb_approval_ksk">Update</button>';
						$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/baku/approval/ksk?action=approve&ipo_id='.$ipo_id.'&irodet_id='.$irodet_id.'&user='.$user->gNip.'&status=1&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'&vnama='.$vnama.'\')" class="ui-button-text icon-save" id="button_approve_bb_approval_ksk">Approve</button>';
						$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/baku/approval/ksk?action=reject&ipo_id='.$ipo_id.'&irodet_id='.$irodet_id.'&user='.$user->gNip.'&status=3&type='.$type.'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bb_approval_ksk">Reject</button>';
						if($rowData['isubmitqa']==0){
							$buttons['update'] = $updatedraft.$update.$js;
						}else{
							$buttons['update'] = $updatedraft2.$approve.$reject.$js;
						}
					}
					elseif((($type=='PR')||($type=='PD'))&&($rcek['iappqa_ksk']==0)){
						//$update = '<button onclick="javascript:update_btn_upload(\'bahan_baku_approval_ksk\', \''.base_url().'processor/plc/bahan/baku/approval/ksk?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_bb_approval_ksk">Update</button>';
						if(($rowData['isubmitpr']==0)&&($type=='PR')){
							$buttons['update'] = $updatedraft.$update.$js;
						}elseif(($rowData['isubmitpd']==0)&&($type=='PD')){
							$buttons['update'] = $updatedraft.$update.$js;
						}else{
							$buttons['update'] = $updatedraft2.$js;
						}
					}
					else{}
					//array_unshift($buttons, $reject, $approve, $revise);
				}
				else{
					if((($type=='PR')||($type=='PD'))&&($rcek['iappqa_ksk']==0)){
						//$update = '<button onclick="javascript:update_btn_upload(\'bahan_baku_approval_ksk\', \''.base_url().'processor/plc/bahan/baku/approval/ksk?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_bb_approval_ksk">Update</button>';
						if(($rowData['isubmitpr']==0)&&($type=='PR')){
							$buttons['update'] = $updatedraft.$update.$js;
						}elseif(($rowData['isubmitpd']==0)&&($type=='PD')){
							$buttons['update'] = $updatedraft.$update.$js;
						}else{}
					}
					else{}
				}
			}
   
    	return $buttons;
    }*/
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
								var url = "'.base_url().'processor/plc/bahan/baku/approval/ksk";
								if(o.status == true) {
					
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_bahan_baku_approval_ksk").html(data);
									});
					
								}
									reload_grid("grid_bahan_baku_approval_ksk");
							}
					
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Approval</h1><br />';
    	$echo .= '<form id="form_bahan_baku_approval_ksk_approve" action="'.base_url().'processor/plc/bahan/baku/approval/ksk?action=approve_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="ipo_id" value="'.$this->input->get('ipo_id').'" />
				<input type="hidden" name="irodet_id" value="'.$this->input->get('irodet_id').'" />
				<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
                <input type="hidden" name="vnama" value="'.$this->input->get('vnama').'" />
				<textarea name="remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_bahan_baku_approval_ksk_approve\')">Approve</button>';
    		
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function approve_process() {

    	$post = $this->input->post();
    	//print_r($post);exit();

		$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
		$this->db_plc0->where('irodet_id', $post['irodet_id']);
		$this->db_plc0->update('plc2.plc2_upb_ro_detail', array('iappqa_ksk'=>2,'vnip_appqa_ksk'=>$nip,'tappqa_ksk'=>$skg));
    
    	$ipo_id = $post['ipo_id'];
    	$irodet_id = $post['irodet_id'];
        $vnama = $post['vnama'];
		//get upb_id
		$qiupb="select distinct(rs.iupb_id) from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
					select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id)";
		$riu = $this->db_plc0->query($qiupb)->result_array();
		
		foreach($riu as $xx){
			$iupb_id=$xx['iupb_id'];
			$ins['iupb_id'] = $xx['iupb_id'];
			$ins['iapp_id'] = $post['group_id']; // relasikan dgn erp_privi.privi_apps
			$ins['vmodule'] = $post['modul_id']; // relasikan dgn erp_privi.privi_modules
			$ins['idiv_id'] = '';
			$ins['vtipe'] = $post['type'];
			$ins['iapprove'] = '2';
			$ins['cnip'] = $this->user->gNIP;
			$ins['treason'] = $post['remark'];
			$ins['tupdate'] = date('Y-m-d H:i:s');
		
			//$this->db_plc0->insert('plc2.plc2_upb_approve', $ins);
			//$this->lib_flow->insert_logs($post['modul_id'],$iupb_id,11,2);
		/*
			$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$post['modul_id']); // 1 approval
			$bizsup=$getbp['idplc2_biz_process_sub'];
			
			$hacek=$this->biz_process->cek_last_status($xx['iupb_id'],$bizsup,1); // status 1 => app
			if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($xx['iupb_id'], $bizsup, 1); // status 1 => app
				//update last log
					$this->biz_process->update_last_log($xx['iupb_id'], $bizsup, 1);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($xx['iupb_id'], $bizsup, 1); // status 1 => app
				//insert last log
					$this->biz_process->insert_last_log($xx['iupb_id'], $bizsup, 1);
			}*/
		}
        
        $hsql= "select a.vpo_nomor,c.vnmsupp,a.trequest,a.tdeadline,a.vor_nomor,a.ttransfer,
                a.tapp_pur,a.vnip_pur
                	from plc2.plc2_upb_po a
                left outer join hrd.mnf_supplier c on c.isupplier_id = a.isupplier_id
                where a.ipo_id = ".$ipo_id;

        
        $rupb = $this->db_plc0->query($hsql)->row_array();
        
        $vpo_nomor= $rupb['vpo_nomor'];
        $vnmsupp = $rupb['vnmsupp'];
        $vtdeadline= $rupb['tdeadline'];
        $vor_nomor= $rupb['vor_nomor'];
        $trequest= $rupb['trequest'];
        $ttransfer = $rupb['ttransfer'];
        $tapp_pur= $rupb['tapp_pur'];
        $vnip_pur = $rupb['vnip_pur'];                        

		$qiupb="select u.vupb_nomor,u.iteambusdev_id,u.iteampd_id,u.iteamqa_id,u.iteamqc_id
                from plc2.plc2_upb u 
                where u.iupb_id in (
                select distinct(rs.iupb_id) from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
					select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id))";        

        $rsql = $this->db_plc0->query($qiupb)->row_array();

        $pd = $rsql['iteampd_id'];

        $sql1="select ra.vnama as vnama from plc2.plc2_upb_ro_detail ro
			inner join plc2.plc2_raw_material ra on ro.raw_id=ra.raw_id
			where ro.irodet_id=".$post['irodet_id'];

		$dt=$this->db_plc0->query($sql1)->row_array();
		$vnama='-';
		if($dt){
			$vnama=$dt['vnama'];
		}else{$vnama='-';}


        $team = $pd ;
        
        $toEmail2='';
        $toEmail = $this->lib_utilitas->get_email_team( $pd );
        $toEmail2 = $this->lib_utilitas->get_email_leader( $pd );                        

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
        $cc = $arrEmail;
        $subject="Proses Approval KSK ".$vpo_nomor." Selesai";
        $content="
                Diberitahukan bahwa telah ada approval pada proses Approval KSK(aplikasi PLC) dengan rincian sebagai berikut :<br><br>
                <div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
                        <table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
                                <tr>
                                        <td style='width: 110px;'><b>No PO</b></td><td style='width: 20px;'> : </td><td>".$vpo_nomor."</td>
                                </tr>
                                <tr>
                                        <td><b>Bahan Baku</b></td><td> : </td><td>".$vnama."</td>
                                </tr>
                                <tr>
                                        <td><b>Proses Selanjutnya</b></td><td> : </td><td>Stabilita Lab - Input oleh PD/AD</td>
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
    	
		$data['status']  = true;
    	$data['last_id'] = $irodet_id;
    	return json_encode($data);
    }
    
    function reject_view() {
    	$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	 return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize(),
					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var url = "'.base_url().'processor/plc/bahan/baku/approval/ksk";
								if(o.status == true) {
									//alert("aaaa");
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=view&id="+last_id, function(data) {
										 $("div#form_bahan_baku_approval_ksk").html(data);
									});
					
								}
									reload_grid("grid_bahan_baku_approval_ksk");
							}
					 	 })
					 }
				 </script>';
    	$echo .= '<h1>Reject</h1><br />';
    	$echo .= '<form id="form_bahan_baku_approval_ksk_reject" action="'.base_url().'processor/plc/bahan/baku/approval/ksk?action=reject_process" method="post">';
    	$echo .= '<div style="vertical-align: top;">';
    	$echo .= 'Remark : 
				<input type="hidden" name="ipo_id" value="'.$this->input->get('ipo_id').'" />
				<input type="hidden" name="irodet_id" value="'.$this->input->get('irodet_id').'" />
    			<input type="hidden" name="type" value="'.$this->input->get('type').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="remark"></textarea><button type="button" onclick="submit_ajax(\'form_bahan_baku_approval_ksk_reject\')">Reject</button>';
    	$echo .= '</div>';
    	$echo .= '</form>';
    	return $echo;
    }
    
    function reject_process () {
    	$post = $this->input->post();
    	$nip = $this->user->gNIP;
		$skg=date('Y-m-d H:i:s');
	 	$this->db_plc0->where('irodet_id', $post['irodet_id']);
		$this->db_plc0->update('plc2.plc2_upb_ro_detail', array('iappqa_ksk'=>1,'vnip_appqa_ksk'=>$nip,'tappqa_ksk'=>$skg));
    
		$ipo_id = $post['ipo_id'];
		$irodet_id = $post['irodet_id'];
		//get upb_id
		$qiupb="select distinct(rs.iupb_id) from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
					select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id)";
		$riu = $this->db_plc0->query($qiupb)->result_array();
		
		foreach($riu as $xx){
			$ins['iupb_id'] = $xx['iupb_id'];
			$ins['iapp_id'] = $post['group_id']; // relasikan dgn erp_privi.privi_apps
			$ins['vmodule'] = $post['modul_id']; // relasikan dgn erp_privi.privi_modules
			$ins['idiv_id'] = '';
			$ins['vtipe'] = $post['type'];
			$ins['iapprove'] = '2';
			$ins['cnip'] = $this->user->gNIP;
			$ins['treason'] = $post['remark'];
			$ins['tupdate'] = date('Y-m-d H:i:s');
		
			$this->db_plc0->insert('plc2.plc2_upb_approve', $ins);
		
			/*$getbp=$this->biz_process->get(1, $this->auth_localnon->my_teams(),$post['modul_id']); // 1 approval
			$bizsup=$getbp['idplc2_biz_process_sub'];
			
				
			$hacek=$this->biz_process->cek_last_status($xx['iupb_id'],$bizsup,2); // status 2 => reject*/
			/*if($hacek==1){ // jika sudah pernah ada data maka update saja
				//insert log
					$this->biz_process->insert_log($xx['iupb_id'], $bizsup, 2); // status 2 => reject
				//update last log
					$this->biz_process->update_last_log($xx['iupb_id'], $bizsup, 2);
			}
			elseif($hacek==0){
				//insert log
					$this->biz_process->insert_log($xx['iupb_id'], $bizsup, 2); // status 2 => reject
				//insert last log
					$this->biz_process->insert_last_log($xx['iupb_id'], $bizsup, 2);
			}*/
		}
		
    	$data['status']  = true;
    	$data['last_id'] = $irodet_id;
    	return json_encode($data);
    }

    function manipulate_update_button($buttons, $rowData){
		//print_r($rowData);exit();
		unset($buttons['update']);
		$js=$this->load->view('bahan_baku_approval_ksk_js');
		$js .= $this->load->view('uploadjs');
		$cNip=$this->user->gNIP;
		$ipo_id=$rowData['ipo_id'];
		$sql= "select u.vupb_nomor, u.iupb_id
                from plc2.plc2_upb u 
                where u.iupb_id in (
                	select distinct(rs.iupb_id) from plc2.plc2_upb_request_sample rs where rs.ireq_id in (
					select pod.ireq_id from plc2.plc2_upb_po_detail pod where pod.ipo_id=$ipo_id))";
		$dt=$this->db_plc0->query($sql)->row_array();
		$sql1="select * from plc2.plc2_upb_ro_detail de inner join plc2.plc2_raw_material ra on ra.raw_id=de.raw_id where de.irodet_id=".$this->input->get('id');
		$dt2=$this->db_plc0->query($sql1)->row_array();
		$setuju = '<button onclick="javascript:setuju(\'bahan_baku_approval_ksk\', \''.base_url().'processor/plc/bahan/baku/approval/ksk?action=confirm&last_id='.$this->input->get('id').'&ipo_id='.$rowData['ipo_id'].'&vnama='.$dt2['vnama'].'&foreign_key='.$this->input->get('foreign_key').'&company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, '.$dt['iupb_id'].', \''.$dt['vupb_nomor'].'\')" class="ui-button-text icon-save" id="button_save_soi_fg">Confirm</button>';
		$approve = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/baku/approval/ksk?action=approve&irodet_id='.$rowData['irodet_id'].'&ipo_id='.$rowData['ipo_id'].'&cNip='.$cNip.'&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bahan_baku_approval_ksk">Approve</button>';
		$reject = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/bahan/baku/approval/ksk?action=reject&irodet_id='.$rowData['irodet_id'].'&ipo_id='.$rowData['ipo_id'].'&cNip='.$cNip.'&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_bahan_baku_approval_ksk">Reject</button>';

		$update = '<button onclick="javascript:update_btn_back(\'bahan_baku_approval_ksk\', \''.base_url().'processor/plc/bahan/baku/approval/ksk?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_bahan_baku_approval_ksk">Update & Submit</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'bahan_baku_approval_ksk\', \''.base_url().'processor/plc/bahan/baku/approval/ksk?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_bahan_baku_approval_ksk">Update as Draft</button>';
		if($this->auth_localnon->is_manager()){
			$x=$this->auth_localnon->dept();
			$manager=$x['manager'];
			if(in_array('PD', $manager)){
				$type='PD';
				if($rowData['isubmit_ksk']==0){
					$buttons['update']=$updatedraft.$update.$js;
				}else{}
			}
			elseif(in_array('QA', $manager)){
				$type='QA';
				if(($rowData['isubmit_ksk']!=0)&&($rowData['iappqa_ksk']==0)){
					$buttons['update']=$setuju.$js;
				}else{}
			}
			/*elseif(in_array('QC', $manager)){
				$type='QC';
				if(($rowData['isubmit_ksk']!=0)&&($rowData['iappqc_ksk']==0)&&($rowData['iappqa_ksk']<>0)){
					$buttons['update']=$setuju.$js;
				}else{}
			}*/
			else{
				$type='';
			}

		}else{

			$x=$this->auth_localnon->dept();
			$team=$x['team'];
			if(in_array('PD', $team)){
				$type='PD';
				if($rowData['isubmit_ksk']==0){
					$buttons['update']=$updatedraft.$update.$js;
				}else{}
			}else{
				$type='';
			}
		}
		return $buttons;
	}

	function output(){		
    	$this->index($this->input->get('action'));
    }

    function download($filename) {
		$this->load->helper('download');		
		$name = $_GET['file'];
		$id = $_GET['id'];
		$path = file_get_contents('./files/plc/approval_ksk/'.$id.'/'.$filename);	
		force_download($filename, $path);
	}
}