<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class import_tambahan_data extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
        $this->load->library('biz_process');
        $this->load->library('lib_utilitas');
		$this->user = $this->auth->user(); 
		$this->dbset = $this->load->database('plc', true);
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Tambahan Data');
		//dc.m_vendor  database.tabel
		$grid->setTable('plc2.upi_dok_td');		
		$grid->setUrl('import_tambahan_data');
		$grid->addList('vNo_request','daftar_upi.vNo_upi','daftar_upi.vNama_usulan','mnf_kategori.vkategori','plc2_upb_master_kategori_upb.vkategori','iSubmit_td','iApprove_bdirm');
		$grid->setSortBy('iupi_dok_td_id');
		$grid->setSortOrder('DESC'); //sort ordernya

		$grid->addFields('iApprove_bdirm','vNo_request','iupi_id','vNama_usulan','vKekuatan','vDosis','vNama_generik','vIndikasi','ikategori_id');
		$grid->addFields('vNo_ijin','vhistori','vMemo');
		//$grid->addFields('history_tambahan_data','tambahan_data');

		//setting widht grid
		$grid->setLabel('vNo_ijin','No Ijin Edar'); 
		$grid ->setWidth('vNo_ijin', '100'); 
		$grid->setAlign('vNo_ijin', 'center'); 

		$grid->setLabel('vMemo','Upload Memo'); 
		$grid ->setWidth('vMemo', '100'); 
		$grid->setAlign('vMemo', 'center'); 

		$grid->setLabel('vhistori','Histori TD'); 
		$grid ->setWidth('vhistori', '100'); 
		$grid->setAlign('vhistori', 'center'); 

		$grid->setLabel('vNo_request','No Request'); 
		$grid ->setWidth('vNo_request', '100'); 
		$grid->setAlign('vNo_request', 'center'); 

		$grid->setLabel('iSubmit_td','Status'); 
		$grid ->setWidth('iSubmit_td', '100'); 
		$grid->setAlign('iSubmit_td', 'center'); 

		$grid->setLabel('iSubmit_td_check','NIE Status'); 
		$grid ->setWidth('iSubmit_td_check', '100'); 
		$grid->setAlign('iSubmit_td_check', 'center'); 

		$grid->setLabel('iApprove_bdirm','Approval BDIRM'); 
		$grid ->setWidth('iApprove_bdirm', '150'); 
		$grid->setAlign('iApprove_bdirm', 'center'); 

		$grid->setLabel('iApprove_dir','Approval Direksi'); 
		$grid ->setWidth('iApprove_dir', '150'); 
		$grid->setAlign('iApprove_dir', 'center'); 

		$grid->setLabel('daftar_upi.vNo_upi','No UPI'); 
		$grid->setWidth('daftar_upi.vNo_upi','80'); 
		$grid->setAlign('daftar_upi.vNo_upi','center'); 

		$grid->setLabel('iupi_id','No UPI'); 
		$grid ->setWidth('iupi_id', '50'); 
		$grid->setAlign('iupi_id', 'center'); 

		$grid->setLabel('dTgl_upi','Tanggal UPI'); 
		$grid ->setWidth('dTgl_upi', '100'); 
		$grid->setAlign('dTgl_upi', 'center'); 

		$grid->setLabel('cPengusul_upi','Nama Pengusul'); 
		$grid ->setWidth('cPengusul_upi', '200'); 
		$grid->setAlign('cPengusul_upi', 'center');

		$grid->setLabel('daftar_upi.vNama_usulan','Nama Usulan'); 
		$grid->setLabel('vNama_usulan','Nama Usulan'); 
		$grid ->setWidth('vNama_usulan', '250'); 
		$grid->setAlign('vNama_usulan', 'left');

		$grid->setLabel('vKekuatan','Kekuatan'); 
		$grid ->setWidth('vKekuatan', '10'); 
		$grid->setAlign('vKekuatan', 'center');

		$grid->setLabel('vDosis','Dosis'); 
		$grid ->setWidth('vDosis', '10'); 
		$grid->setAlign('vDosis', 'center');

		$grid->setLabel('vNama_generik','Nama Generik'); 
		$grid ->setWidth('vNama_generik', '10'); 
		$grid->setAlign('vNama_generik', 'center');

		$grid->setLabel('vIndikasi','Indikasi'); 
		$grid ->setWidth('vIndikasi', '10'); 
		$grid->setAlign('vIndikasi', 'center');
		
		$grid->setLabel('mnf_kategori.vkategori','Kategori Produk'); 
		$grid->setLabel('ikategori_id','Kategori Produk'); 
		$grid ->setWidth('ikategori_id', '50'); 
		$grid->setAlign('ikategori_id', 'center');

		$grid->setLabel('plc2_upb_master_kategori_upb.vkategori','Kategori UPI'); 
		$grid->setWidth('plc2_upb_master_kategori_upb.vkategori','50'); 
		$grid->setAlign('plc2_upb_master_kategori_upb.vkategori','center');  

		$grid->setLabel('ikategoriupi_id','Kategori UPI'); 
		$grid ->setWidth('ikategoriupi_id', '150'); 
		$grid->setAlign('ikategoriupi_id', 'center');

		
		$grid->setLabel('vNama_usulan','Nama Usulan'); 
		$grid ->setWidth('vNama_usulan', '300'); 


		$grid->setLabel('isediaan_id','Sediaan Produk'); 
		$grid->setLabel('itipe_id','Type Produk'); 
		$grid->setLabel('ibe','Tipe BE'); 
		$grid->setLabel('vhpp_target','Target HPP'); 
		$grid->setLabel('tunique','Keunggulan Produk');
		$grid->setLabel('tpacking','Spesifikasi Kemasan');
		$grid->setLabel('ttarget_prareg','Estimasi Pra Registrasi');
		$grid->setLabel('ipatent','Tipe Hak Paten');
		$grid->setLabel('tinfo_paten','Informasi Hak Paten');
		$grid->setLabel('patent_year','Paten Exp');
		$grid->setLabel('iteammarketing_id','Team Marketing');

		$grid->setLabel('iregister','Registrasi Untuk');
		$grid->setLabel('tmemo_bde','Memo');

		$grid->setLabel('fMkt_forcast','Marketing Forecast');
		$grid->setLabel('fSales_upbk','Total Sales di UPB (+000000)');
		$grid->setLabel('fSales_upb','Total Sales di UPB');
		$grid->setLabel('fSales_newk','Total Sales Terbaru (+000000)');
		$grid->setLabel('fSales_new','Total Sales Terbaru');
		$grid->setLabel('iForcast_year1','Forcast Untuk Aggrement Year 1');
		$grid->setLabel('iForcast_year2','Forcast Untuk Aggrement Year 2');
		$grid->setLabel('iForcast_year3','Forcast Untuk Aggrement Year 3');	


		$grid->setLabel('dTerima_dok_reg','Tgl Terima Dok. Registrasi dari Principal');
		$grid->setLabel('vNo_or_prareg','No OR Prareg');
		$grid->setLabel('dCap_lengkap','Tgl Cap Lengkap');
		$grid->setLabel('dTgl_spb','Tgl SPB');
		$grid->setLabel('dPrareg','Tgl Prareg');
		$grid->setLabel('dTambahan_data','Tgl Tambahan Data');
		$grid->setLabel('dSubmit_td','Tgl Submit TD');	

		//search 
		$grid->setSearch('vNo_request','daftar_upi.vNo_upi','iSubmit_td');
		
		$grid->setLabel('dupdate','Tgl Update'); 
		$grid->setLabel('cUpdate','Update By'); 
		
		$grid->setFormUpload(TRUE);
		
		//Field yg mandatori
		$grid->setRequired('iupi_id','vMemo');//,'history','dupdate','cUpdate');
		
		// kondisi datatable
		//$grid->setQuery('istatus = "0" ', null);	

		$grid->setQuery('daftar_upi.iStatusKill = "0" ', null);
		$grid->setJoinTable('plc2.daftar_upi', 'daftar_upi.iupi_id = upi_dok_td.iupi_id', 'inner');
		$grid->setJoinTable('hrd.mnf_kategori', 'mnf_kategori.ikategori_id = daftar_upi.ikategori_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_master_kategori_upb', 'plc2_upb_master_kategori_upb.ikategori_id = daftar_upi.ikategoriupi_id', 'inner');
	
		//$grid->setMultiSelect(true);

		$grid->changeFieldType('iSubmit_td','combobox','',array(0=>'Draft',1=>'Submitted'));
		$grid->changeFieldType('iSubmit_td_check','combobox','',array(0=>'Draft',1=>'Submitted'));
		
		//Set View Gridnya (Default = grid)
		$grid->setGridView('grid');
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			case 'create':
				$grid->render_form();
				break;
			case 'createproses':
				$isUpload = $this->input->get('isUpload');
                if($isUpload) {

                    $lastId=$this->input->get('lastId');
                    $path = realpath("files/plc/import/td_file");
                    if(!file_exists($path."/".$lastId)){
                        if (!mkdir($path."/".$lastId, 0777, true)) { //id review
                            die('Failed upload, try again!');
                        }
                    }
                    $fKeterangan = array();
					foreach($_POST as $key=>$value) {						
						if ($key == 'fileketerangan_studyad') {
							foreach($value as $k=>$v) {
								$fKeterangan[$k] = $v;
							}
						}
					}
					$tglRequest = array();
					foreach($_POST as $key=>$value) {						
						if ($key == 'tglRequest') {
							foreach($value as $k=>$v) {
								$tglRequest[$k] = $v;
							}
						}
					}
                    $i=0;
                    foreach ($_FILES['fileupload_studyad']["error"] as $key => $error) {
                        if ($error == UPLOAD_ERR_OK) {
                            $tmp_name = $_FILES['fileupload_studyad']["tmp_name"][$key];
                            $name =$_FILES['fileupload_studyad']["name"][$key];
                            $data['filename'] = $name;
                            $data['dInsertDate'] = date('Y-m-d H:i:s');
                            $data['dDate'] = date('Y-m-d');

                                if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name)) {
                                    $sql[]="INSERT INTO plc2.upi_dok_td_memo_file (iupi_dok_td_id, vMemo, dCreate, cCreated,vKeterangan,dTglrequest) 
                                            VALUES (".$lastId.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."','".$fKeterangan[$i]."','".$data['dDate']."')";
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
                    $r['message']="Data Berhasil Disimpan";
                    $r['status'] = TRUE;
                    $r['last_id'] = $this->input->get('lastId');                    
                    echo json_encode($r);
                }else{
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
			case 'cariproduk':
				$this->cariproduk();
				break;	
			case 'downloaddDokumen':
				$this->downloaddDokumen();
				break;			
			case 'cariapplicant':
				$this->cariapplicant();
				break;
			case 'cariprinsipal':
				$this->cariprinsipal();
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				   $isUpload = $this->input->get('isUpload');
                   $post=$this->input->post();
                    
                    $iujiLabs=$post['import_tambahan_data_iupi_dok_td_id'];

                    if($isUpload) { 
                         	$path = realpath("files/plc/import/td_file");
	                        if(!file_exists($path."/".$iujiLabs)){
	                            if (!mkdir($path."/".$iujiLabs, 0777, true)) { //id review
	                                die('Failed upload, try again!');
	                            }
	                        }

                       		$fKeterangan = array();
							foreach($_POST as $key=>$value) {						
								if ($key == 'fileketerangan_studyad') {
									foreach($value as $k=>$v) {
										$fKeterangan[$k] = $v;
									}
								}
							}
							$tglRequest = array();
							foreach($_POST as $key=>$value) {						
								if ($key == 'tglRequest') {
									foreach($value as $k=>$v) {
										$tglRequest[$k] = $v;
									}
								}
							}

							/*   foreach ($_FILES['fileupload_studyad']["error"] as $key => $error) {
                        if ($error == UPLOAD_ERR_OK) {
                            $tmp_name = $_FILES['fileupload_studyad']["tmp_name"][$key];
                            $name =$_FILES['fileupload_studyad']["name"][$key];
                            $data['filename'] = $name;
                            $data['dInsertDate'] = date('Y-m-d H:i:s');

                                if(move_uploaded_file($tmp_name, $path."/".$lastId."/".$name)) {
                                    $sql[]="INSERT INTO plc2.upi_dok_td_memo_file (iupi_dok_td_id, vMemo, dCreate, cCreated,vKeterangan,dTglrequest) 
                                            VALUES (".$lastId.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."','".$fKeterangan[$i]."','".$tglRequest[$i]."')";
                                    $i++;   
                                }
                                else{
                                    echo "Upload ke folder gagal";  
                                }
                        }*/



                           if (isset($_FILES['fileupload_studyad']))  {
                            $i=0;
                             foreach ($_FILES['fileupload_studyad']["error"] as $key => $error) {
                                    if ($error == UPLOAD_ERR_OK) {
                                        $tmp_name = $_FILES['fileupload_studyad']["tmp_name"][$key];
                                        $name =$_FILES['fileupload_studyad']["name"][$key];
                                        $data['filename'] = $name;
                                        $data['dInsertDate'] = date('Y-m-d H:i:s');
                                        $data['dDate'] = date('Y-m-d');
                                            if(move_uploaded_file($tmp_name, $path."/".$iujiLabs."/".$name)) {
                                                $sql[]="INSERT INTO plc2.upi_dok_td_memo_file (iupi_dok_td_id, vMemo, dCreate, cCreated,vKeterangan,dTglrequest)
                                                        VALUES (".$iujiLabs.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."','".$fKeterangan[$i]."','".$data['dDate']."')";
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
                           $qr="SELECT * FROM plc2.`upi_dok_td_memo_file` a WHERE  a.`iupi_dok_td_id` ='".$iujiLabs."' and lDeleted=0";
					       $up = $this->db_plc0->query($qr)->result_array();
					       
					       foreach ($up as $row) {
					       		$path = realpath("files/plc/import/td_detail_file");
						        if(!file_exists($path."/".$row['iMemo_id'])){
						            if (!mkdir($path."/".$row['iMemo_id'], 0777, true)) { //id review
						                die('Failed upload, try again!');
						            }
						        }

						   		$namefile ="filedetail_".$row['iMemo_id'];
						   		$sqlasd=array();
						   		if(isset($_FILES[$namefile])){
						   			//print_r(expression)
							        foreach ($_FILES[$namefile]["error"] as $key => $error) {
							        	
							        	//$r['info']="Data Berhasil Disimpansdad";
						                if ($error == UPLOAD_ERR_OK) {
						                    $tmp_name = $_FILES[$namefile]["tmp_name"][$key];
						                    $name =$_FILES[$namefile]["name"][$key];
						                    $data['filename'] = $name;
						                    $data['dInsertDate'] = date('Y-m-d H:i:s');

						                        if(move_uploaded_file($tmp_name, $path."/".$row['iMemo_id']."/".$name)) {
						                            $sqlasd[]="INSERT INTO plc2.`upi_dok_td_detail_file` (`iupi_dok_td_id`,vFileupidetail,dCreate,`cCreated`,`iMemo_id`) 
						                                    VALUES (".$iujiLabs.",'".$data['filename']."','".$data['dInsertDate']."','".$this->user->gNIP."','".$row['iMemo_id']."')";
						                            $i++;   
						                        }
						                        else{
						                            echo "Upload ke folder gagal";  
						                        }
						                }
						            }
						         }
					            foreach($sqlasd as $q) {
					                try {
					                $this->dbset->query($q);
					                }catch(Exception $e) {
					                die($e);
					                }
					            }
					        }


                            $r['message']="Data Berhasil Disimpan";
                            $r['status'] = TRUE;
                            $r['last_id'] = $this->input->get('lastId');                    
                            echo json_encode($r);

                        }else{
                            $fileid1='';
                            foreach($_POST as $key=>$value) {
                                if ($key == 'fileid_studyad') {
                                    $i=0;
                                    foreach($value as $k=>$v) {
                                        if($i==0){
                                            $fileid1 .= "'".$v."'";
                                        }else{
                                            $fileid1 .= ",'".$v."'";
                                        }
                                        $i++;
                                    }
                                }
                            }
                            $tgl= date('Y-m-d H:i:s');
                            $sql1="update plc2.upi_dok_td_memo_file set lDeleted=1, dupdate='".$tgl."', cUpdate='".$this->user->gNIP."' where iupi_dok_td_id='".$iujiLabs."' and iMemo_id not in (".$fileid1.")";
                            $this->dbset->query($sql1);

                            echo $grid->updated_form();
                        }
				/*echo $grid->updated_form();*/
				break;
			case 'updateproses2':
				echo $this->updateproses2();
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
			case 'gethistkomposisi':
				echo $this->gethistkomposisi();
				break;	
			case 'getdetil':
				$this->getdetil();
				break;	
			case 'downloadMemo':
				$this->downloadMemo();
				break;
			case 'employee_list':
				$this->employee_list();
			default:
				$grid->render_grid();
				break;
		}
    }

    function getdetil(){
		$iupi_id=$_POST['iupi_id'];
		$data = array();

		$sql2 = "SELECT * FROM plc2.daftar_upi a JOIN hrd.employee b ON b.cNip=a.cPengusul_upi 
					JOIN plc2.`registrasi_upi` c ON c.`iupi_id`=a.`iupi_id` WHERE a.ldeleted = 0 AND a.iupi_id='".$iupi_id."'";
		$data2 = $this->dbset->query($sql2)->row_array();
	 	

	 	$row_array['vNo_upi'] = trim($data2['vNo_upi']);
		$row_array['dTgl_upi'] = trim($data2['dTgl_upi']);
		$row_array['cPengusul_upi'] = trim($data2['vName']);
		$row_array['vNama_usulan'] = trim($data2['vNama_usulan']);
		$row_array['vKekuatan'] = trim($data2['vKekuatan']);

		$row_array['vDosis'] = trim($data2['vDosis']);
		$row_array['vNama_generik'] = trim($data2['vNama_generik']);
		$row_array['vIndikasi'] = trim($data2['vIndikasi']);

		$row_array['vNo_ijin'] = trim($data2['vNo_ijin']);

		$row_array['ikategori_id'] = trim($data2['ikategori_id']);
		$row_array['ikategoriupi_id'] = trim($data2['ikategoriupi_id']);

	 	array_push($data, $row_array);
	 	echo json_encode($data);
	    exit;
	}

	function searchBox_import_tambahan_data_iSubmit_td($rowData, $id) {
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    		$o .= '<option value="0">Draft - Need to be Publish</option>';
    		$o .= '<option value="1">Submitted</option>';
    	
    	$o .= '</select>';
    	return $o;
    } 

	function listBox_import_tambahan_data_iApprove_bdirm($value) {
		if($value==0){$vstatus='Waiting for approval';}
		elseif($value==1){$vstatus='Rejected';}
		elseif($value==2){$vstatus='Approved';}
		return $vstatus;
	}
    function searchBox_import_tambahan_data_mnf_kategori_vkategori($rowData, $id) {
		$teams = $this->db_plc0->get_where('hrd.mnf_kategori', array('ldeleted' => 0))->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['vkategori'].'">'.$t['vkategori'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    } 

    function searchBox_import_tambahan_data_plc2_upb_master_kategori_upb_vkategori($rowData, $id) {
		$teams = $this->db_plc0->get_where('plc2.plc2_upb_master_kategori_upb', array('ldeleted' => 0))->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['vkategori'].'">'.$t['vkategori'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    }   

  
	function listBox_Action($row, $actions) {

	 	$mydept = $this->auth->my_depts(TRUE);
	 	$x = $this->auth->my_teams();
		$array = explode(',', $x);
		// cek user bagian dari tim bd terkait
		

	 	if ($row->iSubmit_td<>0) {
	 		// status sudah diapprove or reject , button edit hide 
	 		 	if ($row->iApprove_bdirm<>0) {
	 		 		unset($actions['edit']);
		 		 	unset($actions['delete']);
	 		 	}else{
	 		 		if($row->iSubmit_td_check<>0){
	 		 			if((in_array('BDI', $mydept))) {
							if($this->auth->is_manager()){
								//$buttons['update'] = $approve_bdirm.$reject_bdirm.$js;	
							}else{
								unset($actions['edit']);
			 		 			unset($actions['delete']);
							}
						}
	 		 		}else{
	 		 			///-------------------------------
			 		 	
	 		 		}
	 		 		
	 		 	}
	 	}
	 	
		 return $actions;
	}

/*manipulasi view object form start*/

	function insertBox_import_tambahan_data_iApprove_bdirm($field, $id) {
		return '-';
	}

	function updateBox_import_tambahan_data_iApprove_bdirm($field, $id, $value, $rowData) {
		if(($value <> 0) || (!empty($value))){
			$sql_dtapp = 'select * 
						from plc2.upi_dok_td a 
						join hrd.employee b on b.cNip=a.cApprove_bdirm
						where
						a.lDeleted = 0
						and  a.iupi_id = "'.$rowData['iupi_id'].'"';
			$row = $this->db_plc0->query($sql_dtapp)->row_array();
			if($value==2){
				$st='<p style="color:green;font-size:120%;">Approved';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApprove_bdirm'].'</br> Alasan: '.$row['vRemark_bdirm'].'</p>';
			}
			elseif($value==1){
				$st='<p style="color:red;font-size:120%;">Rejected';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApprove_bdirm'].'</br> Alasan: '.$row['vRemark_bdirm'].'</p>';
			} 

			
			
			
		}
		else{
			$ret='Waiting for Approval';
		}
		$ret .= "<input type='hidden' name='".$field."' id='".$id."'  value='".$value."'/>";
		return $ret;
	}

	function insertBox_import_tambahan_data_iApprove_dir($field, $id) {
		return '-';
	}

	function updateBox_import_tambahan_data_iApprove_dir($field, $id, $value, $rowData) {
		//print_r($rowData);
		if(($value <> 0) || (!empty($value))){
			$sql_dtapp = 'select * 
						from plc2.upi_dok_td a 
						join hrd.employee b on b.cNip=a.cApprove_dir
						where
						a.lDeleted = 0
						and  a.iupi_id = "'.$rowData['iupi_id'].'"';
			$row = $this->db_plc0->query($sql_dtapp)->row_array();
			if($value==2){
				$st='<p style="color:green;font-size:120%;">Approved';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApprove_dir'].'</br> Alasan: '.$row['vRemark_dir'].'</p>';
			}
			elseif($value==1){
				$st='<p style="color:red;font-size:120%;">Rejected';
				$ret= $st.' oleh '.$row['vName'].' pada '.$row['dApprove_dir'].'</br> Alasan: '.$row['vRemark_dir'].'</p>';
			} 
		}
		else{
			$ret='Waiting for Approval';
		}
		$ret .= "<input type='hidden' name='".$field."' id='".$id."'  value='".$value."'/>";
		return $ret;
	}

	function insertBox_import_tambahan_data_vNo_request($field, $id) {
		return 'Auto Number';
	}

	function updateBox_import_tambahan_data_vNo_request($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}else{

				$return= $value;
				$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
		}
		
		return $return;
	}


	function insertBox_import_tambahan_data_iupi_id($field, $id) {
		$return = '<script>
						$( "button.icon_pop" ).button({
							icons: {
								primary: "ui-icon-newwin"
							},
							text: false
						})
					</script>';
		$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" />
					';
		$return .= '<input type="text" name="'.$id.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="10" />';
		$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/import/browse/upi/tambahan/data/?field=import_tambahan_data\',\'List UPI\')" type="button">&nbsp;</button>';                
		
		return $return;
	}

	function updateBox_import_tambahan_data_iupi_id($field, $id, $value, $rowData) {
		$sql = 'select a.iupi_id,a.vNo_upi,a.vNama_usulan from plc2.daftar_upi a where a.iupi_id ="'.$value.'" ';
		$data_upb = $this->dbset->query($sql)->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $data_upb['vNo_upi'];

		}else{
			
			if ($rowData['iSubmit_td'] == 0) {
				$return = '<script>
							$( "button.icon_pop" ).button({
								icons: {
									primary: "ui-icon-newwin"
								},
								text: false
							})
						</script>';
			$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />
						';
			$return .= '<input type="text" name="'.$field.'_dis" class="required" disabled="TRUE" id="'.$id.'_dis" class="input_rows1" size="10" value="'.$data_upb['vNo_upi'].'"/>';
			$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/plc/import/browse/upi/tambahan/data/?field=import_tambahan_data\',\'List UPI\')" type="button">&nbsp;</button>';                
			
			}else{
				$return= $data_upb['vNo_upi'];
				$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';
			}
			
			//$return= $data_upb['vNo_upi'];
		}
		
		return $return;
	}


	function insertBox_import_tambahan_data_dTgl_upi($field, $id) {
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" class="input_rows1 required" size="8" />
					<input type="hidden" name="isdraft" id="isdraft">
		';
		return $return;
	}

    function updateBox_import_tambahan_data_dTgl_upi($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['dTgl_upi'];

		}
		else{
				$return = '<input type="text" name="'.$field.'" size="8" readonly="readonly" id="'.$id.'" value="'.$rows['dTgl_upi'].'" class="input_rows1 required" size="10" />
					<input type="hidden" name="isdraft" id="isdraft">
				';

		}
		
		return $return;
	}


	function insertBox_import_tambahan_data_cPengusul_upi($field, $id) {
		$return = '<input type="text" name="'.$field.'"  readonly="readonly" id="'.$id.'" class="input_rows1 required" size="35" />';
		return $return;
	}

	function updateBox_import_tambahan_data_cPengusul_upi($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
    	$rowss = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$rows['cPengusul_upi']))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rowss['vName'];

		}
		else{
				$return = '<input type="text" name="'.$field.'" size="35" readonly="readonly" id="'.$id.'" value="'.$rowss['vName'].'" class="input_rows1 required" size="10" />';

		}
		
		return $return;
	}


	function insertBox_import_tambahan_data_vNama_usulan($field, $id) {
		$return = '<input type="text" name="'.$field.'"  disabled="true" id="'.$id.'" class="input_rows1 required" size="35" />
					<input type="hidden" name="isdraft" id="isdraft">
					<input type="hidden" name="ispilih" id="ispilih">';
		return $return;
	}

	function updateBox_import_tambahan_data_vNama_usulan($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vNama_usulan'];

		}
		else{
				$return = '<input type="text" name="'.$field.'" size="35" disabled="true" id="'.$id.'" value="'.$rows['vNama_usulan'].'" class="input_rows1 required" size="10" />
				<input type="hidden" name="isdraft" id="isdraft">
				<input type="hidden" name="ispilih" id="ispilih">';

		}
		
		return $return;
	}

	function insertBox_import_tambahan_data_vKekuatan($field, $id) {
		$return = '<input type="text" name="'.$field.'" style="text-align:right;" disabled="true" id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_tambahan_data_vKekuatan($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vKekuatan'];

		}
		else{
				$return = '<input type="text" style="text-align:right;" name="'.$field.'" size="8" disabled="true" id="'.$id.'" value="'.$rows['vKekuatan'].'" class="input_rows1 required"/>';

		}
		
		return $return;
	}

	function insertBox_import_tambahan_data_vDosis($field, $id) {
		$return = '<input type="text" style="text-align:right;" name="'.$field.'"  disabled="true" id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_tambahan_data_vDosis($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vDosis'];

		}
		else{
				$return = '<input style="text-align:right;" type="text" name="'.$field.'" size="8" disabled="true" id="'.$id.'" value="'.$rows['vDosis'].'" class="input_rows1 required"  />';

		}
		
		return $return;
	}

	function insertBox_import_tambahan_data_vNama_generik($field, $id) {
		$return = '<input type="text" name="'.$field.'"  disabled="true" id="'.$id.'" class="input_rows1 required" size="35" />';
		return $return;
	}

	function updateBox_import_tambahan_data_vNama_generik($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') {
			$return= $rows['vNama_generik'];

		}
		else{
				$return = '<input type="text" name="'.$field.'" size="35" disabled="true" id="'.$id.'" value="'.$rows['vNama_generik'].'" class="input_rows1 required" size="10" />';

		}
		
		return $return;
	}

	function insertBox_import_tambahan_data_vIndikasi($field, $id) {
		$o 	= "<textarea name='".$id."' id='".$id."' class='required' disabled style='width: 240px; height: 50px;'size='250'></textarea>";		
		$o .= "	<script>
				$('#".$id."').keyup(function() {
				var len = this.value.length;
				if (len >= 250) {
				this.value = this.value.substring(0, 250);
				}
				$('#maxlengthnote').text(250 - len);
				});
			</script>";
	    $o .= '<br/>tersisa <span id="maxlengthnote">250</span> karakter<br/>';
    
                                            
		return $o;
	}

	function updateBox_import_tambahan_data_vIndikasi($field, $id, $value, $rowData) {
		$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
		if ($this->input->get('action') == 'view') { 
			$o = "<label title='Note'>".nl2br($rows['vIndikasi'])."</label>";
		
		}else{
			$o 	= "<textarea name='".$id."' id='".$id."' class='required' disabled   style='width: 240px; height: 50px;'size='250'>".nl2br($rows['vIndikasi'])."</textarea>";		
			$o .= "	<script>
				$('#".$id."').keyup(function() {
				var len = this.value.length;
				if (len >= 250) {
				this.value = this.value.substring(0, 250);
				}
				$('#maxlengthnote').text(250 - len);
				});
			</script>";
	    	$o .= '<br/>tersisa <span id="maxlengthnote">250</span> karakter<br/>';
	    
		}

		return $o;
	}

	function insertBox_import_tambahan_data_ikategori_id($field, $id) {
        
            $o  = "<select name='".$field."' id='".$id."' class='required' disabled='true'>";
            $o .= "<option value=''>Pilih</option>";
            $sql = "select a.ikategori_id,a.vkategori from hrd.mnf_kategori a where a.ldeleted=0";
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $row) {
                       if ($id == $row['ikategori_id']) $selected = " selected";
                       else $selected = '';
                       $o .= "<option {$selected}  value='".$row['ikategori_id']."'>".$row['vkategori']."</option>";
                }
            }
            $o .= "</select>";
            
            return $o;
    } 

    function updateBox_import_tambahan_data_ikategori_id($field, $id, $value, $rowData) {
    	$rows = $this->db_plc0->get_where('plc2.daftar_upi', array('iupi_id'=>$rowData['iupi_id'],'ldeleted'=>0))->row_array();
        if ($this->input->get('action') == 'view') {
            $sql = 'select a.ikategori_id,a.vkategori from hrd.mnf_kategori a where a.ikategori_id= "'.$rows['ikategori_id'].'"';
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $o = $row->vkategori;
            }
        } else {

            $o  = "<select name='".$field."' id='".$id."' class='required' disabled='true'>";
            $o .= "<option value=''>Pilih</option>";
            $sql = "select a.ikategori_id,a.vkategori from hrd.mnf_kategori a where a.ldeleted=0";
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $row) {
                       if ($rows['ikategori_id'] == $row['ikategori_id']) $selected = " selected";
                       else $selected = '';
                       $o .= "<option {$selected} value='".$row['ikategori_id']."'>".$row['vkategori']."</option>";
                }
            }
        }   

            $o .= "</select>";
            
            return $o;
    } 

    function insertBox_import_tambahan_data_vNo_ijin($field, $id) {
		$return = '<input type="text" name="'.$field.'" style="text-align:right;" disabled="true" id="'.$id.'" class="input_rows1" size="8" />';
		return $return;
	}

	function updateBox_import_tambahan_data_vNo_ijin($field, $id, $value, $rowData) {
		$sql = "SELECT * FROM plc2.daftar_upi a JOIN plc2.`registrasi_upi` c ON c.`iupi_id`=a.`iupi_id` 
				WHERE a.ldeleted = 0 AND a.iupi_id='".$rowData['iupi_id']."'";

    	$rows = $this->db_plc0->query($sql)->row_array();

		if ($this->input->get('action') == 'view') {
			$return ="<label title='Note'>".nl2br($rows['vNo_ijin'])."</label>";
		}
		else{
			if($rows['vNo_ijin']=""){
				$return = '<input type="text" style="text-align:right;" name="'.$field.'" size="8" disabled="true" id="'.$id.'" class="input_rows1"/>';
				
			}else{
				$return = '<input type="text" style="text-align:right;" name="'.$field.'" size="8" disabled="true" id="'.$id.'" value="'.$rows['vNo_ijin'].'" class="input_rows1"/>';
			}

		}
		
		return $return;
	}

   
	/*function insertBox_import_tambahan_data_vNie($field, $id) {
        $return = '<input type="text" name="'.$field.'" style="text-align:left;"  id="'.$id.'" class="input_rows1" size="8" />';
        return $return;
    }
 	function updateBox_import_tambahan_data_vNie($field, $id, $value, $rowData) {
    if ($this->input->get('action') == 'view') {
        $return= $value;
    }
    else{
    	if($rowData['iSubmit_td']<>0){
    		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required " size="8" />';
    	}else{
    		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 " size="8" />';
    	}
        
    }
    return $return;
    }*/
	

	function insertBox_import_tambahan_data_vMemo($field, $id) {
		$data['field'] = $field;
		return $this->load->view('import/import_tambahan_data_memo',$data,TRUE);
	}


	function updateBox_import_tambahan_data_vMemo($field, $id, $value, $rowData) {
		$qr="SELECT * FROM plc2.`upi_dok_td_memo_file` a WHERE  a.`iupi_dok_td_id` ='".$rowData['iupi_dok_td_id']."' and lDeleted=0";
		$data['rows'] = $this->db_plc0->query($qr)->result_array();
		$data['date'] = date('Y-m-d H:i:s');

		if($rowData['iSubmit_td']==0){
			//Buat isi data Kalo View draft
			$return = $this->load->view('import/import_tambahan_data_memo',$data,TRUE);
		}else if($rowData['iSubmit_td_check']==0){
			//Buat Upload td Semua
			$return = $this->load->view('import/import_tambahan_data_detail',$data,TRUE);
		}else{
			//Buat view Kalo udah diapprove
			$return = $this->load->view('import/import_tambahan_data_detail_view',$data,TRUE);
			//$return = $this->load->view('import/import_tambahan_data_detail',$data,TRUE);
		}
		return $return;
	}


	function insertBox_import_tambahan_data_vhistori($field, $id) {
		$return ='';
		$return .= '
					<script type="text/javascript">
						$("label[for=\''.$id.'\']").hide();
						$("label[for=\''.$id.'\']").next().css("margin-left",0);
					</script>
				';
		$return .= '<div id="hist_dok_td_view"></div>';
		return $return;
		//return "ooo";
	}

	function updateBox_import_tambahan_data_vhistori($field, $id, $value, $rowData) {
		$sql1="SELECT * FROM plc2.`upi_dok_td` a JOIN plc2.daftar_upi b ON a.iupi_id = b.iupi_id
			WHERE a.`iupi_id` =".$rowData['iupi_id']." AND a.lDeleted=0 AND b.iStatusKill = 0 AND a.iApprove_bdirm=2 ORDER BY a.iupi_dok_td_id  DESC";
		//$sql2="SELECT * FROM plc2.`upi_dok_td` a JOIN plc2.`upi_dok_td_detail` b ON a.`iupi_dok_td_id` = b.`iupi_dok_td_id` WHERE a.`iupi_dok_td_id` ='".$rowData['iupi_dok_td_id']."'";

		$data['rows'] = $this->db_plc0->query($sql1)->result_array();
		//$data['rows'] = $this->db_plc0->query($sql2)->result_array();

		$return ='';
		$return .= '
					<script type="text/javascript">
						$("label[for=\''.$id.'\']").hide();
						$("label[for=\''.$id.'\']").next().css("margin-left",0);
					</script>
				';
		$return .= '<div id="hist_dok_td_view"> ';
		$return .= $this->load->view('import/import_tambahan_data_history',$data,TRUE);
		$return .='</div>';
		return $return;
		//return "ooo";
	}

	/*function insertBox_import_tambahan_data_tambahan_data($field, $id) {
		return "-";
	}


	function updateBox_import_tambahan_data_tambahan_data($field, $id, $value, $rowData) {
		$qr="SELECT b.`iMemo_id` FROM plc2.`upi_dok_td` a JOIN plc2.`upi_dok_td_memo_file` b ON a.`iupi_dok_td_id` = b.`iupi_dok_td_id`
			WHERE a.`iupi_dok_td_id` ='".$rowData['iupi_dok_td_id']."'";
			$data['rows'] = $this->db_plc0->query($qr)->result_array();
			$data['date'] = date('Y-m-d H:i:s');
		if($rowData['vNie'] ==""){
			$ro .= $this->load->view('import/import_tambahan_data_detail',$data,TRUE);
		}else{
			$ro = "-"
		}
		return $ro;
	}


/*manipulasi view object form end*/

/*manipulasi proses object form start*/

function manipulate_insert_button($buttons) {
	unset($buttons['save']);

	$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'import_tambahan_data\', \''.base_url().'processor/plc/import/tambahan/data?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_import_tambahan_data">Save as Draft</button>';
	$save = '<button onclick="javascript:save_btn_multiupload(\'import_tambahan_data\', \''.base_url().'processor/plc/import/tambahan/data?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_import_tambahan_data">Save &amp; Submit</button>';
	$js = $this->load->view('import/import_tambahan_data_js');
	$buttons['save'] = $save_draft.$save.$js;

	return $buttons;
}

function before_insert_processor($row, $postData) {

	// ubah status submit
		/*if($postData['isdraft']==true |){
			$postData['iSubmit_td']=0;
		} 
		else{$postData['iSubmit_td']=1;} */

		if($postData['isdraft']==true){
			$postData['iSubmit_td']=0;
		}else{
			$postData['iSubmit_td']=1;
		}

		/*if($postData['vNie'] != ""){
			$postData['iSubmit_td_check']=1;
		}*/

		$postData['dCreate'] = date('Y-m-d H:i:s');
		$postData['cCreated'] =$this->user->gNIP;

	return $postData;

}

function before_update_processor($row, $postData) {
	
	// ubah status submit
	/*if($postData['isdraft']==true){s
		$postData['iSubmit_td']=0;
	} else{$postData['iSubmit_td']=1;} */

	if($postData['isdraft']==true){
		$postData['iSubmit_td']=0;
	}else{
		$postData['iSubmit_td']=1;
	}

	

	$postData['dupdate'] = date('Y-m-d H:i:s');
	$postData['cUpdate'] =$this->user->gNIP;

	
	return $postData;

}


// function cariproduk() {
// 	$term = $this->input->get('term');
// 	$return_arr = array();
// 	$sqlprod = "select * 
// 				from plc2.plc2_produk_kompetitor a
// 				join plc2.plc2_manuf_kompetitor b on b.iplc2_manuf_kompetitor_id=a.iplc2_manuf_kompetitor_id
// 				where a.vNama_produk like '%".$term."%'
// 				and a.lDeleted = 0
// 				and b.lDeleted=0";
// 	$lines= $this->db_plc0->query($sqlprod)->result_array();
// 	//$lines = $this->db_plc0->get('plc2.plc2_produk_kompetitor')->result_array();
// 	$i=0;
// 	foreach($lines as $line) {
// 		$row_array["value"] = trim($line["vNama_produk"]);
// 		$row_array["id"] = trim($line["iplc2_produk_kompetitor_id"]);
// 		$row_array["manuf"] = trim($line["vNama_manuf"]);
// 		array_push($return_arr, $row_array);
// 	}
// 	echo json_encode($return_arr);exit();
	
// }


function after_insert_processor($fields, $id, $postData) {

	/*if(isset($postData['vNama_dokumen'])){
		if(($postData['vNama_dokumen'][0])!=""){
			foreach($postData['vNama_dokumen'] as $k=>$v){
				$pri['iupi_dok_td_id']=$id;
				$pri['vNama_dokumen']=$v;
				$pri['dTgl_td']=$postData['dTgl_td'][$k];

				$pri['dCreate']=date('Y-m-d H:i:s');
				$pri['cCreated']=$this->user->gNIP;


				$this->db_plc0->insert('plc2.upi_dok_td_detail', $pri);

			}
		}
	}*/

	//update service_request autonumber No Brosur
	$nomor = "R".str_pad($id, 8, "0", STR_PAD_LEFT);
	$sql = "UPDATE plc2.upi_dok_td SET vNo_request = '".$nomor."' WHERE iupi_dok_td_id=$id LIMIT 1";
	$query = $this->db_plc0->query( $sql );

	/*$logged_nip =$this->user->gNIP;
	$qupi="select c.vNo_request,c.iSubmit_td,a.iupi_id,a.vNo_upi,a.dTgl_upi,a.cPengusul_upi,a.vNama_usulan,a.vKekuatan,a.vDosis,a.vNama_generik,a.vIndikasi 
			,a.iSubmit_upi,(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BDI' and te.ldeleted=0) as bdirm,
			b.cNip,b.vName,c.iupi_dok_td_id
			from plc2.daftar_upi a 
			join plc2.upi_dok_td c on c.iupi_id=a.iupi_id
			join hrd.employee b on b.cNip=a.cPengusul_upi
			where a.lDeleted=0
			and c.iupi_dok_td_id = '".$id."'";
	$rupd = $this->db_plc0->query($qupi)->row_array();

	$submit = $rupd['iSubmit_td'] ;

	if ($submit == 1) {
		$bdirm = $rupd['bdirm'];

		$team = $bdirm;
		//$team = '81' ;

        $toEmail2='';
		$toEmail = $this->lib_utilitas->get_email_team( $team );
        $toEmail2 = $this->lib_utilitas->get_email_leader( $team );
        $arrEmail = $this->lib_utilitas->get_email_by_nip( $logged_nip );                    
                    
		$to = $cc = '';
		if(is_array($arrEmail)) {
			$count = count($toEmail);
			$to = $toEmail[0];
			for($i=1;$i<$count;$i++) {
				$cc.=isset($toEmail[$i]) ? $toEmail[$i].';' : ';';
			}
		}	

		$to = $toEmail2.';'.$toEmail;
		$cc = $arrEmail;                        


			$subject="New : Tambahan Data UPI ".$rupd['vNo_upi'];
			$content="Diberitahukan bahwa telah ada Input Tambahan Data UPI pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
				<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
					<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
						<tr>
							<td style='width: 110px;'><b>No UPI</b></td><td style='width: 20px;'> : </td><td>".$rupd['vNo_upi']."</td>
						</tr>
						<tr>
							<td><b>No Request</b></td><td> : </td><td>".$rupd['vNo_request']."</td>
						</tr>
						<tr>
							<td><b>Tanggal UPI</b></td><td> : </td><td>".$rupd['dTgl_upi']."</td>
						</tr>
						<tr>
							<td><b>Diinput oleh</b></td><td> : </td><td>".$rupd['cNip'].' - '.$rupd['vName']."</td>
						</tr>
						<tr>
							<td><b>Nama Usulan</b></td><td> : </td><td>".$rupd['vNama_usulan']."</td>
						</tr>
						<tr>
							<td><b>Kekuatan</b></td><td> : </td><td>".$rupd['vKekuatan']."</td>
						</tr>
						<tr>
							<td><b>Dosis</b></td><td> : </td><td> ".$rupd['vDosis']."</td>
						</tr>
						<tr>
							<td><b>Nama Generik</b></td><td> : </td><td>".$rupd['vNama_generik']."</td>
						</tr>
						<tr>
							<td><b>Indikasi</b></td><td> : </td><td><p> ".$rupd['vIndikasi']."</p></td>
						</tr>
					</table>
				</div>
				<br/> 
				Demikian, mohon segera follow up  pada aplikasi ERP Product Life Cycle. Terimakasih.<br><br><br>
				Post Master";
			$this->lib_utilitas->send_email($to, $cc, $subject, $content);
		
	}*/


}

function after_update_processor($fields, $id, $postData) {

}




	function manipulate_update_button($buttons, $rowData) {
		$mydept = $this->auth->my_depts(TRUE);
		$cNip= $this->user->gNIP;

		$js = $this->load->view('import/import_tambahan_data_js');

		$update = '<button onclick="javascript:update_btn_back(\'import_tambahan_data\', \''.base_url().'processor/plc/import/tambahan/data?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_update_upi_detail">Update & Submit</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'import_tambahan_data\', \''.base_url().'processor/plc/import/tambahan/data?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_import_tambahan_data">Update as Draft</button>';

		$updatepilih = '<button onclick="javascript:update_pilih_btn(\'import_tambahan_data\', \''.base_url().'processor/plc/import/tambahan/data?company_id='.$this->input->get('company_id').'&ispilih=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_import_tambahan_data">Update</button>';

		$approve_bdirm = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/tambahan/data?action=approve&iupi_dok_td_id='.$rowData['iupi_dok_td_id'].'&cNip='.$cNip.'&lvl=1&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_import_tambahan_data">Approve</button>';
		$reject_bdirm = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/tambahan/data?action=reject&iupi_dok_td_id='.$rowData['iupi_dok_td_id'].'&cNip='.$cNip.'&lvl=1&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_import_tambahan_data">Reject</button>';



		if ($this->input->get('action') == 'view') {unset($buttons['update']);}

		else{
			
			unset($buttons['update_back']);
			unset($buttons['update']);
			
			if ($rowData['iSubmit_td']== 0) {
				// jika masih draft , show button update draft & update submit 
				if (isset($mydept)) {
					// cek punya dep
					if((in_array('BDI', $mydept)) || (in_array('BDE', $mydept))) {

								$buttons['update'] = $update.$updatedraft.$js;
					}
				}

			}else{

				if ($rowData['iSubmit_td_check']== 0) {
					if (isset($mydept)) {
						if((in_array('BDI', $mydept)) || (in_array('BDE', $mydept))) {
							//if($this->auth->is_manager()){
								$buttons['update'] = $updatepilih.$js;	
							//}
						}
					}

				}else{
					if (isset($mydept)) {
						if((in_array('BDI', $mydept))) {
							if($this->auth->is_manager()){
								//$buttons['update'] = $approve_bdirm.$reject_bdirm.$js;
								$buttons['update'] = $approve_bdirm.$js;	
							}
						}
					}	
				}
				
			}
			

		}

		return $buttons;
}

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
								var url = "'.base_url().'processor/plc/import/tambahan/data";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_import_tambahan_data").html(data);
										 $("#button_approve_import_tambahan_data").hide();
										 $("#button_reject_import_tambahan_data").hide();
									});
									
								}
									reload_grid("grid_import_tambahan_data");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_import_tambahan_data_approve" action="'.base_url().'processor/plc/import/tambahan/data?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="iupi_dok_td_id" value="'.$this->input->get('iupi_dok_td_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_import_tambahan_data_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
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
								var url = "'.base_url().'processor/plc/import/tambahan/data";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_import_tambahan_data").html(data);
										 $("#button_approve_import_tambahan_data").hide();
										 $("#button_reject_import_tambahan_data").hide();
									});
									
								}
									reload_grid("grid_import_tambahan_data");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_import_tambahan_data_approve" action="'.base_url().'processor/plc/import/tambahan/data?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="iupi_dok_td_id" value="'.$this->input->get('iupi_dok_td_id').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_import_tambahan_data_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	function updateproses2(){
		$post=$this->input->post();
        $iujiLabs=$post['import_tambahan_data_iupi_dok_td_id'];

	        $LengkapiDokumen = array();
			foreach($_POST as $key=>$value) {						
				if ($key == 'LengkapiDokumen') {
					foreach($value as $k=>$v) {
						$LengkapiDokumen[$k] = $v;
					}
				}
			}
			$tglRequest = array();
			foreach($_POST as $key=>$value) {						
				if ($key == 'tglMelengkapi') {
					foreach($value as $k=>$v) {
						$tglRequest[$k] = $v;
					}
				}
			}
			$idMemo = array();
			$sql=array();
			foreach($_POST as $key=>$value) {						
				if ($key == 'idMemo') {
					$i=0;
					foreach($value as $k=>$v) {
						$idMemo[$k] = $v;
						$data['dInsertDate'] = date('Y-m-d H:i:s');
						$sql[] ="INSERT INTO plc2.`upi_dok_td_detail` (`iupi_dok_td_id`,`vNama_dokumen`,`dTgl_td`,`dcreate`,`iMemo_id`,`cCreated`)
									VALUES ('".$iujiLabs."','".$LengkapiDokumen[$i]."','".$tglRequest[$i]."','".$data['dInsertDate']."','".$idMemo[$i]."','".$this->user->gNIP."')";
						$i++;
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

	        $date = date('Y-m-d H:i:s');
	        $sqlupdate = "UPDATE plc2.`upi_dok_td` SET `cCreated` = '".$this->user->gNIP."', `dupdate` ='".$date."', `iSubmit_td_check`='1' WHERE `iupi_dok_td_id` ='".$iujiLabs."'";
	        $this->db_plc0->query($sqlupdate);



        $r['message']="Data Berhasil Disimpan";
        $r['status'] = TRUE;
        $r['last_id'] = $iujiLabs;                    
        return json_encode($r);
	}

	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$iupi_dok_td_id = $post['iupi_dok_td_id'];
		$vRemark = $post['vRemark'];

		$data=array('iApprove_bdirm'=>'2','cApprove_bdirm'=>$cNip , 'dApprove_bdirm'=>date('Y-m-d H:i:s'), 'vRemark_bdirm'=>$vRemark);
		$this -> db -> where('iupi_dok_td_id', $iupi_dok_td_id);
		$updet = $this -> db -> update('plc2.upi_dok_td', $data);

		$data['status']  = true;
		$data['last_id'] = $post['iupi_dok_td_id'];
		return json_encode($data);
	}
	function reject_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$iupi_dok_td_id = $post['iupi_dok_td_id'];
		$vRemark = $post['vRemark'];

		$data=array('iApprove_bdirm'=>'0','cApprove_bdirm'=>$cNip , 'dApprove_bdirm'=>date('Y-m-d H:i:s'), 'vRemark_bdirm'=>$vRemark);
		$this -> db -> where('iupi_dok_td_id', $iupi_dok_td_id);
		$updet = $this -> db -> update('plc2.upi_dok_td', $data);

		$data['status']  = true;
		$data['last_id'] = $post['iupi_dok_td_id'];
		return json_encode($data);
	}


	// Tambahan Download

	function downloadMemo($filename) {
        $this->load->helper('download');        
        $name = $_GET['filememo'];
        $id = $_GET['id'];
        $path = file_get_contents('./files/plc/import/td_file/'.$id.'/'.$name);    
        force_download($name, $path);
    }
    function downloaddDokumen($filename) {
        $this->load->helper('download');        
        $name = $_GET['filedokumen'];
        $id = $_GET['id'];
        $path = file_get_contents('./files/plc/import/td_detail_file/'.$id.'/'.$name);    
        force_download($name, $path);
    }




	public function output(){
		$this->index($this->input->get('action'));
	}

}

