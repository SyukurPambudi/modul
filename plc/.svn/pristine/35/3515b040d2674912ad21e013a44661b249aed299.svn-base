<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class import_daftar_upi extends MX_Controller {
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
		$grid->setTitle('Daftar UPI');
		//dc.m_vendor  database.tabel
		$grid->setTable('plc2.daftar_upi');		
		$grid->setUrl('import_daftar_upi');
		$grid->addList('vNo_upi','vNama_usulan','mnf_kategori.vkategori','plc2_upb_master_kategori_upb.vkategori','iSubmit_upi','iApprove_bdirm','iApprove_dir');
		$grid->setSortBy('vNo_upi');
		$grid->setSortOrder('desc'); //sort ordernya

		$grid->addFields('iApprove_bdirm','iApprove_dir','vNo_upi','dTgl_upi','cPengusul_upi','vNama_usulan','vKekuatan','vDosis','vNama_generik','vIndikasi','ikategori_id','ikategoriupi_id');//,'history','dupdate','cUpdate');

		//setting widht grid
		$grid->setLabel('iSubmit_upi','Status'); 
		$grid ->setWidth('iSubmit_upi', '100'); 
		$grid->setAlign('iSubmit_upi', 'center'); 

		$grid->setLabel('iApprove_bdirm','Approval BDIRM'); 
		$grid ->setWidth('iApprove_bdirm', '100'); 
		$grid->setAlign('iApprove_bdirm', 'center'); 

		$grid->setLabel('iApprove_dir','Approval Direksi'); 
		$grid ->setWidth('iApprove_dir', '100'); 
		$grid->setAlign('iApprove_dir', 'center'); 

		$grid->setLabel('vNo_upi','No UPI'); 
		$grid ->setWidth('vNo_upi', '100'); 
		$grid->setAlign('vNo_upi', 'center'); 

		$grid->setLabel('dTgl_upi','Tanggal UPI'); 
		$grid ->setWidth('dTgl_upi', '100'); 
		$grid->setAlign('dTgl_upi', 'center'); 

		$grid->setLabel('cPengusul_upi','Nama Pengusul'); 
		$grid ->setWidth('cPengusul_upi', '250'); 
		$grid->setAlign('cPengusul_upi', 'center');

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
		$grid ->setWidth('ikategori_id', '150'); 
		$grid->setAlign('ikategori_id', 'center');

		$grid->setLabel('plc2_upb_master_kategori_upb.vkategori','Kategori UPI'); 
		$grid->setWidth('plc2_upb_master_kategori_upb.vkategori','50'); 
		$grid->setAlign('plc2_upb_master_kategori_upb.vkategori','center'); 

		$grid->setLabel('ikategoriupi_id','Kategori UPI'); 
		$grid ->setWidth('ikategoriupi_id', '50'); 
		$grid->setAlign('ikategoriupi_id', 'center');



		$grid->setLabel('vNama_usulan','Nama Usulan'); 
		$grid ->setWidth('vNama_usulan', '300'); 

		//search 
		$grid->setSearch('vNo_upi','vNama_usulan','mnf_kategori.vkategori','plc2_upb_master_kategori_upb.vkategori','iApprove_bdirm','iApprove_dir');
		$grid->changeFieldType('iApprove_bdirm','combobox','',array(''=>'--Select--',0=>'Waiting Approval',1=>'Rejected', 2=>'Approved'));
		$grid->changeFieldType('iApprove_dir','combobox','',array(''=>'--Select--',0=>'Waiting Approval',1=>'Rejected', 2=>'Approved'));
		
		$grid->setLabel('dupdate','Tgl Update'); 
		$grid->setLabel('cUpdate','Update By'); 
		
		$grid->setFormUpload(TRUE);
		
		//Field yg mandatori
		$grid->setRequired('vNo_upi','dTgl_upi','cPengusul_upi','vNama_usulan','vKekuatan','vDosis','vNama_generik','vIndikasi','ikategori_id','ikategoriupi_id');//,'history','dupdate','cUpdate');
		//$grid->setRequired('vNo_upi','vNama_usulan','mnf_kategori.vkategori','plc2_upb_master_kategori_upb.vkategori');
		//$grid->setRequired('vNo_upi','vNama_usulan');	
		//$grid->setRequired('vNama_usulan');	
		$grid->setQuery('daftar_upi.lDeleted = "0" ', null);	
		
		
		$mydept = $this->auth->my_depts(TRUE);
			if (isset($mydept)) 
			{
				// cek punya dep
				if((in_array('DR', $mydept))) {
					$grid->setQuery('daftar_upi.iApprove_bdirm not in (1) ', null);	
				}
			}
		

		// kondisi datatable
		$grid->setQuery('iStatusKill = "0" ', null);	
		$grid->setJoinTable('hrd.mnf_kategori', 'mnf_kategori.ikategori_id = daftar_upi.ikategori_id', 'inner');
		$grid->setJoinTable('plc2.plc2_upb_master_kategori_upb', 'plc2_upb_master_kategori_upb.ikategori_id = daftar_upi.ikategoriupi_id', 'inner');
		$grid->changeFieldType('iSubmit_upi','combobox','',array('0'=>'Draft','1'=>'Submitted'));
	//	$grid->setQuery('asset.asset_sparepart.history', 0);
		//$grid->setMultiSelect(true);
		
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
			case 'employee_list':
				$this->employee_list();
			default:
				$grid->render_grid();
				break;
		}
    }

    function listBox_import_daftar_upi_iApprove_bdirm($value) {
    	/* $appd = $this->db_plc0->get_where('plc2.plc2_status', array('idplc2_status' => $value))->row_array();
    	if($value==0){$appd['vCaption']="Waiting For Approval";} */
    	if($value==0){$vstatus='Waiting for approval';}
    	elseif($value==1){$vstatus='Rejected';}
    	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    }
	 function listBox_import_daftar_upi_iApprove_dir($value, $pk, $name, $rowData) {
    	/* $team = $this->db_plc0->get_where('plc2.plc2_status', array('idplc2_status' => $value))->row_array();
    	if($value==0){$team['vCaption']="Waiting For Approval";} */
	 	if($value==0){
	 		
	 		if ( $rowData->iApprove_bdirm == 2 or  $rowData->iApprove_bdirm == 0 ) {
	 			$vstatus='Waiting for approval';
	 		}else{
	 			$vstatus='-';	
	 		}
	 		
	 		
	 	}
	 	elseif($value==1){$vstatus='Rejected';}
	 	elseif($value==2){$vstatus='Approved';}
    	return $vstatus;
    } 

    function searchBox_import_daftar_upi_mnf_kategori_vkategori($rowData, $id) {
		$teams = $this->db_plc0->get_where('hrd.mnf_kategori', array('ldeleted' => 0))->result_array();
    	$o = '<select class="required" name="'.$id.'" id="'.$id.'">';
    	$o .= '<option value="">--Select--</option>';
    	foreach ($teams as $t) {
    		$o .= '<option value="'.$t['vkategori'].'">'.$t['vkategori'].'</option>';
    	}
    	$o .= '</select>';
    	return $o;
    } 

    function searchBox_import_daftar_upi_plc2_upb_master_kategori_upb_vkategori($rowData, $id) {
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
	 	//$rows = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$row->iupb_id,'ldeleted'=>0))->row_array();
	 	//$idtim_bd =$rows['iteambusdev_id'];
	 	$mydept = $this->auth->my_depts(TRUE);
	 	$x = $this->auth->my_teams();
		$array = explode(',', $x);
		// cek user bagian dari tim bd terkait
		//print_r($mydept);

	 	if ($row->iApprove_dir<>0) {
	 		// status sudah diapprove or reject , button edit hide 
	 		//if((in_array('BDI', $mydept))  and $row->iApprove_bdirm <> 0 ) {
	 			unset($actions['edit']);
	 		 	unset($actions['delete']);
	 		//}
	 		 
	 	}else{
	 		$mydept = $this->auth->my_depts(TRUE);
	 		if (isset($mydept)) 
			{
				if((in_array('BDI', $mydept))  and $row->iApprove_bdirm <> 0 ) {
					unset($actions['edit']);
	 		 		unset($actions['delete']);
				}
				// cek punya dep
				if((in_array('DR', $mydept))  and $row->iApprove_bdirm <> 2 ) {
					unset($actions['edit']);
	 		 		unset($actions['delete']);
				}else if( (in_array('BDI', $mydept))  and $row->iApprove_bdirm ==1 ){
					unset($actions['edit']);
	 		 		unset($actions['delete']);
				}
			}

	 		/*
	 		if((in_array($idtim_bd, $array))) {
				$actions['delete'];
				$actions['edit'];
			}else{
				 unset($actions['edit']);
		 		 unset($actions['delete']);
			}
			*/

	 	}

	 	
		 return $actions;

	} 

/*manipulasi view object form start*/

	function insertBox_import_daftar_upi_iApprove_bdirm($field, $id) {
		return '-';
	}

	function updateBox_import_daftar_upi_iApprove_bdirm($field, $id, $value, $rowData) {
		if(($value <> 0) || (!empty($value))){
			$sql_dtapp = 'select * 
						from plc2.daftar_upi a 
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
		
		return $ret;
	}

	function insertBox_import_daftar_upi_iApprove_dir($field, $id) {
		return '-';
	}

	function updateBox_import_daftar_upi_iApprove_dir($field, $id, $value, $rowData) {
		//print_r($rowData);
		if(($value <> 0) || (!empty($value))){
			$sql_dtapp = 'select * 
						from plc2.daftar_upi a 
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
		
		return $ret;
	}


	function insertBox_import_daftar_upi_vNo_upi($field, $id) {
		$o = '<label title="Auto Number">Auto Generate</label>';
		return $o;
	}



	function updateBox_import_daftar_upi_vNo_upi($field, $id, $value, $rowData) {
		$o = "<input type='hidden' name='".$field."' id='".$id."'  value='".$value."'/>";
		$o .= "<label title='Auto Number'>".$value."</label>";
		return $o;
	}


	function insertBox_import_daftar_upi_cPengusul_upi($field, $id) {
		$cNip = $this->user->gNIP;
		$emp = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$cNip))->row_array();

		$o = "<input type='hidden' name='".$field."' id='".$id."'   value='".$emp['cNip']."'/>
				<input type='hidden' name='isdraft' id='isdraft'>
			";
		$o .= "<label title='Auto Number'>".$emp['cNip'].' | '.$emp['vName']."</label>";
		return $o;
	}
	
	
	function updateBox_import_daftar_upi_cPengusul_upi($field, $id, $value, $rowData) {
		$vcNip = $value;
		$vemp = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$vcNip))->row_array();

		$cNip = $this->user->gNIP;
		$emp = $this->db_plc0->get_where('hrd.employee', array('cNip'=>$cNip))->row_array();

		if ($this->input->get('action') == 'view') {
			$return= $vemp['cNip'].' | '.$vemp['vName'];

		}
		else{
			$return = "<input type='hidden' name='".$field."' id='".$id."'   value='".$vemp['cNip']."'/>
						<input type='hidden' name='isdraft' id='isdraft'>
					";
			$return .= "<label title='Nip Pengusul'>".$vemp['cNip'].' | '.$vemp['vName']."</label>";

		}

		return $return;
	
	}

	function insertBox_import_daftar_upi_vNama_usulan($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class="input_rows1 required" size="40" />';
		return $return;
	}

	function updateBox_import_daftar_upi_vNama_usulan($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{

			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="40" />';
			//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/koperasi/koperasi/nip/popup?field=master_teamsvc_perasset\',\'List Employee\')" type="button">&nbsp;</button>';
		}
		return $return;
	}


	function insertBox_import_daftar_upi_vKekuatan($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_daftar_upi_vKekuatan($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{

			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="8" />';
		}
		return $return;
	}

	function insertBox_import_daftar_upi_vDosis($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class="input_rows1 required" size="8" />';
		return $return;
	}

	function updateBox_import_daftar_upi_vDosis($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{

			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="8" />';
			//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/koperasi/koperasi/nip/popup?field=master_teamsvc_perasset\',\'List Employee\')" type="button">&nbsp;</button>';
		}
		return $return;
	}

	function insertBox_import_daftar_upi_vNama_generik($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class="input_rows1 required" size="40" />';
		return $return;
	}

	function updateBox_import_daftar_upi_vNama_generik($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{

			$return = '<input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="40" />';
			//$return .= '&nbsp;<button class="icon_pop"  onclick="browse(\''.base_url().'processor/koperasi/koperasi/nip/popup?field=master_teamsvc_perasset\',\'List Employee\')" type="button">&nbsp;</button>';
		}
		return $return;
	}

	function insertBox_import_daftar_upi_vIndikasi($field, $id) {
		$o 	= "<textarea name='".$id."' id='".$id."' class='required' style='width: 240px; height: 50px;'size='250'></textarea>";		
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

	function updateBox_import_daftar_upi_vIndikasi($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') { 
			$o = "<label title='Note'>".nl2br($value)."</label>";
		
		}else{
			$o 	= "<textarea name='".$id."' id='".$id."' class='required'   style='width: 240px; height: 50px;'size='250'>".nl2br($value)."</textarea>";		
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

    function insertBox_import_daftar_upi_ikategori_id($field, $id) {
        
            $o  = "<select name='".$field."' id='".$id."' class='required'>";
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

    function updateBox_import_daftar_upi_ikategori_id($field, $id, $value) {
        if ($this->input->get('action') == 'view') {
            $sql = 'select a.ikategori_id,a.vkategori from hrd.mnf_kategori a where a.ikategori_id= "'.$value.'"';
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $o = $row->vkategori;
            }
        } else {

            $o  = "<select name='".$field."' id='".$id."' class='required'>";
            $o .= "<option value=''>Pilih</option>";
            $sql = "select a.ikategori_id,a.vkategori from hrd.mnf_kategori a where a.ldeleted=0";
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $row) {
                       if ($value == $row['ikategori_id']) $selected = " selected";
                       else $selected = '';
                       $o .= "<option {$selected} value='".$row['ikategori_id']."'>".$row['vkategori']."</option>";
                }
            }
        }   

            $o .= "</select>";
            
            return $o;
    }  

    function insertBox_import_daftar_upi_ikategoriupi_id($field, $id) {
        
            $o  = "<select name='".$field."' id='".$id."' class='required'>";
            $o .= "<option value=''>Pilih</option>";
            $sql = "select a.ikategori_id,a.vkategori from plc2.plc2_upb_master_kategori_upb a where a.ldeleted=0";
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

    function updateBox_import_daftar_upi_ikategoriupi_id($field, $id, $value) {
        if ($this->input->get('action') == 'view') {
            $sql = 'select a.ikategori_id,a.vkategori from plc2.plc2_upb_master_kategori_upb a where a.ikategori_id= "'.$value.'"';
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $o = $row->vkategori;
            }
        } else {

            $o  = "<select name='".$field."' id='".$id."' class='required'>";
            $o .= "<option value=''>Pilih</option>";
            $sql = "select a.ikategori_id,a.vkategori from plc2.plc2_upb_master_kategori_upb a where a.ldeleted=0";
            $query = $this->dbset->query($sql);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $row) {
                       if ($value == $row['ikategori_id']) $selected = " selected";
                       else $selected = '';
                       $o .= "<option {$selected} value='".$row['ikategori_id']."'>".$row['vkategori']."</option>";
                }
            }
        }   

            $o .= "</select>";
            
            return $o;
    }

    function insertBox_import_daftar_upi_dTgl_upi($field, $id) {
		$return = '<input type="text" name="'.$field.'"  id="'.$id.'" class="input_rows1 required" size="8" />';
		$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
		return $return;
	}

    function updateBox_import_daftar_upi_dTgl_upi($field, $id, $value, $rowData) {
		if ($this->input->get('action') == 'view') {
			$return= $value;

		}
		else{
			if ($rowData['iSubmit_upi'] == 0) {
				$return = '<input type="text" name="'.$field.'" size="8" readonly="readonly" id="'.$id.'" value="'.$value.'" class="input_rows1 required" size="10" />';
				$return .='<script>
					 $("#'.$id.'").datepicker({	changeMonth:true,
												changeYear:true,
												dateFormat:"yy-mm-dd" });
				</script>';
			}else{
				$return = $value;
				$return .= '<input type="hidden" name="'.$field.'" id="'.$id.'" class="input_rows1 required" value="'.$value.'" />';	
			}
			
		}
		
		return $return;
	}  


	function manipulate_insert_button($buttons) {
		unset($buttons['save']);

		$save_draft = '<button onclick="javascript:save_draft_btn_multiupload(\'import_daftar_upi\', \''.base_url().'processor/plc/import/daftar/upi?draft=true\', this, true)" class="ui-button-text icon-save" id="button_save_draft_import_daftar_upi">Save as Draft</button>';
		$save = '<button onclick="javascript:save_btn_multiupload(\'import_daftar_upi\', \''.base_url().'processor/plc/import/daftar/upi?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_import_daftar_upi">Save &amp; Submit</button>';
		$js = $this->load->view('import/import_daftar_upi_js');
		$buttons['save'] = $save_draft.$save.$js;

		return $buttons;
	}

	function manipulate_update_button($buttons, $rowData) {
		//$rows = $this->db_plc0->get_where('plc2.plc2_upb', array('iupb_id'=>$rowData['iupb_id'],'ldeleted'=>0))->row_array();
		//$idtim_bd =$rows['iteambusdev_id'];
		$mydept = $this->auth->my_depts(TRUE);
		$cNip= $this->user->gNIP;
		$js = $this->load->view('import/import_daftar_upi_js');
		$approve_bdirm = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/daftar/upi?action=approve&iupi_id='.$rowData['iupi_id'].'&cNip='.$cNip.'&lvl=1&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_import_daftar_upi">Approve</button>';
		$reject_bdirm = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/daftar/upi?action=reject&iupi_id='.$rowData['iupi_id'].'&cNip='.$cNip.'&lvl=1&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_import_daftar_upi">Reject</button>';

		$approve_dir = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/daftar/upi?action=approve&iupi_id='.$rowData['iupi_id'].'&cNip='.$cNip.'&lvl=2&status=1&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_approve_import_daftar_upi">Approve</button>';
		$reject_dir = '<button onclick="javascript:load_popup(\''.base_url().'processor/plc/import/daftar/upi?action=reject&iupi_id='.$rowData['iupi_id'].'&cNip='.$cNip.'&lvl=2&status=2&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\')" class="ui-button-text icon-save" id="button_reject_import_daftar_upi">Reject</button>';


		$update = '<button onclick="javascript:update_btn_back(\'import_daftar_upi\', \''.base_url().'processor/plc/import/daftar/upi?company_id='.$this->input->get('company_id').'&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this)" class="ui-button-text icon-save" id="button_save_import_daftar_upi">Update & Submit</button>';
		$updatedraft = '<button onclick="javascript:update_draft_btn(\'import_daftar_upi\', \''.base_url().'processor/plc/import/daftar/upi?company_id='.$this->input->get('company_id').'&draft=true&group_id='.$this->input->get('group_id').'&modul_id='.$this->input->get('modul_id').'\', this, true)" class="ui-button-text icon-save" id="button_save_import_daftar_upi">Update as Draft</button>';



		if ($this->input->get('action') == 'view') {unset($buttons['update']);}

		else{
			
			unset($buttons['update_back']);
			unset($buttons['update']);
			
			if ($rowData['iSubmit_upi']== 0) {
				// jika masih draft , show button update draft & update submit 
				if (isset($mydept)) {
					// cek punya dep
					if((in_array('BDI', $mydept)) || (in_array('BDE', $mydept))) {
						//cek dep ada bdirm
						//$x = $this->auth->my_teams();
						//$array = explode(',', $x);
							// cek user bagian dari tim bd terkait
						//	if((in_array($idtim_bd, $array))) {
								$buttons['update'] = $update.$updatedraft.$js;
						//	}
					}
				}

			}else{
				// sudah disubmit , show button approval 
				if ($rowData['iApprove_bdirm']==0) {
					// jika approval bdirm 0 
					if (isset($mydept)) {
						if((in_array('BDI', $mydept))) {
							if($this->auth->is_manager()){
								$buttons['update'] = $approve_bdirm.$reject_bdirm.$js;	
							}
						}
					}

					

				}else if($rowData['iApprove_dir']==0){
					if ($rowData['iApprove_bdirm']==2) {
						if (isset($mydept)) {
							if((in_array('DR', $mydept))) {
								if($this->auth->is_manager()){
									$buttons['update'] = $approve_dir.$reject_dir.$js;
								}
							}
						}
						
					}

					
				}


				

				
			}
			

			//$buttons['update'] = $update.$updatedraft.$approve.$reject.$js;
			//$buttons['update'] = $update.$updatedraft.$approve_dir.$reject_dir.$js;
		}

		return $buttons;

	}

	function approve_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
						return $.ajax({
					 	 	url: $("#"+form_id).attr("action"),
					 	 	type: $("#"+form_id).attr("method"),
					 	 	data: $("#"+form_id).serialize()+"&ikategori_id="+$("#import_daftar_upi_ikategori_id").val(),

					 	 	success: function(data) {
					 	 		var o = $.parseJSON(data);
								var last_id = o.last_id;
								var url = "'.base_url().'processor/plc/import/daftar/upi";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_import_daftar_upi").html(data);
										 $("#button_approve_import_daftar_upi").hide();
										 $("#button_reject_import_daftar_upi").hide();
									});
									
								}
									reload_grid("grid_import_daftar_upi");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Approval</h1><br />';
		$echo .= '<form id="form_import_daftar_upi_approve" action="'.base_url().'processor/plc/import/daftar/upi?action=approve_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="iupi_id" value="'.$this->input->get('iupi_id').'" />
				<input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				
				<textarea name="vRemark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_import_daftar_upi_approve\')">Approve</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}

	
	function approve_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$iupi_id = $post['iupi_id'];
		$lvl = $post['lvl'];
		$vRemark = $post['vRemark'];
		$ikategori_id = $post['ikategori_id'];

		if($ikategori_id==3||$ikategori_id==4){
			$k=1;
		}else{
			$k=0;
		}

		if ($lvl == 2) {
			//approval direksi 
			$data=array('iApprove_dir'=>'2','cApprove_dir'=>$cNip , 'dApprove_dir'=>date('Y-m-d H:i:s'), 'vRemark_dir'=>$vRemark,'iStatusUji'=>$k,'ikategori_id'=>$ikategori_id);
		}else{
			//bdirm
			$data=array('iApprove_bdirm'=>'2','cApprove_bdirm'=>$cNip , 'dApprove_bdirm'=>date('Y-m-d H:i:s'), 'vRemark_bdirm'=>$vRemark,'iStatusUji'=>$k,'ikategori_id'=>$ikategori_id);
		}

		$this -> db -> where('iupi_id', $iupi_id);
		$updet = $this -> db -> update('plc2.daftar_upi', $data);

		$data['status']  = true;
		$data['last_id'] = $post['iupi_id'];
		return json_encode($data);

		$logged_nip =$this->user->gNIP;
		$qupi="select a.iupi_id,a.vNo_upi,a.dTgl_upi,a.cPengusul_upi,a.vNama_usulan,a.vKekuatan,a.vDosis,a.vNama_generik,a.vIndikasi 
				,a.iSubmit_upi,
				(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BDI' and te.ldeleted=0) as bdirm,
				(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='DR' and te.ldeleted=0) as dr,
				b.cNip,b.vName
				from plc2.daftar_upi a 
				join hrd.employee b on b.cNip=a.cPengusul_upi
				where a.lDeleted=0
				and a.iupi_id = '".$id."'";
		$rupd = $this->db_plc0->query($qupi)->row_array();

		$iApprove_bdirm = $rupd['iApprove_bdirm'] ;

		if ($iApprove_bdirm == 2) {
			$bdirm = $rupd['bdirm'];
			$dr = $rupd['dr'];

		//$team = $bdirm;
			$team = $bdirm. ','.$dr;
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

			//$to = $arrEmail;
			//$cc = $toEmail2.';'.$toEmail;                        

				$subject="Approval : Daftar UPI ".$rupd['vNo_upi'];
				$content="Diberitahukan bahwa telah ada Input Daftar UPI pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>No UPI</b></td><td style='width: 20px;'> : </td><td>".$rupd['vNo_upi']."</td>
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
			
		}

	}

	function reject_view() {
		$echo = '<script type="text/javascript">
					 function submit_ajax(form_id) {
					 	var remark = $("#reject_import_daftar_upi_remark").val();
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
								var url = "'.base_url().'processor/plc/import/daftar/upi";								
								if(o.status == true) {
									
									$("#alert_dialog_form").dialog("close");
										 $.get(url+"?action=update&id="+last_id, function(data) {
										 $("div#form_import_daftar_upi").html(data);
										 $("#button_approve_import_daftar_upi").hide();
										 $("#button_reject_import_daftar_upi").hide();
									});
									
								}
									reload_grid("grid_import_daftar_upi");
							}
					 	 	
					 	 })
					 }
				 </script>';
		$echo .= '<h1>Reject</h1><br />';
		$echo .= '<form id="form_import_daftar_upi_reject" action="'.base_url().'processor/plc/import/daftar/upi?action=reject_process" method="post">';
		$echo .= '<div style="vertical-align: top;">';
		$echo .= 'Remark : 
				<input type="hidden" name="iupi_id" value="'.$this->input->get('iupi_id').'" />
				<input type="hidden" name="lvl" value="'.$this->input->get('lvl').'" />
				<input type="hidden" name="group_id" value="'.$this->input->get('group_id').'" />
				<input type="hidden" name="modul_id" value="'.$this->input->get('modul_id').'" />
				<textarea name="vRemark" id="reject_import_daftar_upi_remark"></textarea>
		<button type="button" onclick="submit_ajax(\'form_import_daftar_upi_reject\')">Reject</button>';
			
		$echo .= '</div>';
		$echo .= '</form>';
		return $echo;
	}
	
	function reject_process() {
		$post = $this->input->post();
		$cNip= $this->user->gNIP;
		$vName= $this->user->gName;
		$iupi_id = $post['iupi_id'];
		$lvl = $post['lvl'];
		$vRemark = $post['vRemark'];

		if ($lvl == 2) {
			//approval direksi 
			$data=array('iApprove_dir'=>'1','cApprove_dir'=>$cNip , 'dApprove_dir'=>date('Y-m-d H:i:s'), 'vRemark_dir'=>$vRemark);
		}else{
			//bdirm
			$data=array('iApprove_bdirm'=>'1','cApprove_bdirm'=>$cNip , 'dApprove_bdirm'=>date('Y-m-d H:i:s'), 'vRemark_bdirm'=>$vRemark);
		}
		$this -> db -> where('iupi_id', $iupi_id);
		$updet = $this -> db -> update('plc2.daftar_upi', $data);

		$data['status']  = true;
		$data['last_id'] = $post['iupi_id'];
		return json_encode($data);
	}






/*manipulasi view object form end*/

/*manipulasi proses object form start*/
function before_insert_processor($row, $postData) {

	// ubah status submit
		if($postData['isdraft']==true){
			$postData['iSubmit_upi']=0;
		} 
		else{$postData['iSubmit_upi']=1;} 

	$postData['dCreate'] = date('Y-m-d H:i:s');
	$postData['cCreated'] =$this->user->gNIP;

		if($postData['ikategori_id']==3||$postData['ikategori_id']==4){
			$postData['iStatusUji']=1;
		}else{
			$postData['iStatusUji']=0;
		}
	
	return $postData;

}

function before_update_processor($row, $postData) {
	
	// ubah status submit
	if($postData['isdraft']==true){
		$postData['iSubmit_upi']=0;
	} 
	else{$postData['iSubmit_upi']=1;
		} 
	$postData['dupdate'] = date('Y-m-d H:i:s');
	$postData['cUpdate'] =$this->user->gNIP;

		if($postData['ikategori_id']==3||$postData['ikategori_id']==4){
			$postData['iStatusUji']=1;
		}else{
			$postData['iStatusUji']=0;
		}
	
	return $postData;

}



function after_insert_processor($fields, $id, $post) {

	//update service_request autonumber No Brosur
	$nomor = "UPI".str_pad($id, 4, "0", STR_PAD_LEFT);
	$sql = "UPDATE plc2.daftar_upi SET vNo_upi = '".$nomor."' WHERE iupi_id=$id LIMIT 1";
	$query = $this->db_plc0->query( $sql );

	//notifikasi UPI ke BDIRM
	
		$logged_nip =$this->user->gNIP;
		$qupi="select a.iupi_id,a.vNo_upi,a.dTgl_upi,a.cPengusul_upi,a.vNama_usulan,a.vKekuatan,a.vDosis,a.vNama_generik,a.vIndikasi 
				,a.iSubmit_upi,
				(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BDI' and te.ldeleted=0) as bdirm,
				(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='DR' and te.ldeleted=0) as dr,
				b.cNip,b.vName
				from plc2.daftar_upi a 
				join hrd.employee b on b.cNip=a.cPengusul_upi
				where a.lDeleted=0
				and a.iupi_id = '".$id."'";
		$rupd = $this->db_plc0->query($qupi)->row_array();

		$submit = $rupd['iSubmit_upi'] ;

		if ($submit == 1) {
			$bdirm = $rupd['bdirm'];
			$dr = $rupd['dr'];

		$team = $bdirm;
		//	$team = $bdirm. ','.$dr;
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

			//$to = $arrEmail;
			//$cc = $toEmail2.';'.$toEmail;                        

				$subject="Approval : Daftar UPI ".$rupd['vNo_upi'];
				$content="Diberitahukan bahwa telah ada Input Daftar UPI pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
					<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
						<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
							<tr>
								<td style='width: 110px;'><b>No UPI</b></td><td style='width: 20px;'> : </td><td>".$rupd['vNo_upi']."</td>
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
			
		}


	
}

function after_update_processor($fields, $id, $post) {
	$logged_nip =$this->user->gNIP;
	$qupi="select a.iupi_id,a.vNo_upi,a.dTgl_upi,a.cPengusul_upi,a.vNama_usulan,a.vKekuatan,a.vDosis,a.vNama_generik,a.vIndikasi 
			,a.iSubmit_upi,
			(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='BDI' and te.ldeleted=0) as bdirm,
			(select te.iteam_id from plc2.plc2_upb_team te where te.vtipe='DR' and te.ldeleted=0) as dr,
			b.cNip,b.vName
			from plc2.daftar_upi a 
			join hrd.employee b on b.cNip=a.cPengusul_upi
			where a.lDeleted=0
			and a.iupi_id = '".$id."'";
	$rupd = $this->db_plc0->query($qupi)->row_array();

	$submit = $rupd['iSubmit_upi'] ;

	if ($submit == 1) {
		$bdirm = $rupd['bdirm'];
		$dr = $rupd['dr'];

		$team = $bdirm;
		//$team = $bdirm. ','.$dr;
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

		//$to = $arrEmail;
		//$cc = $toEmail2.';'.$toEmail;                        

			$subject="Approval : Daftar UPI ".$rupd['vNo_upi'];
			$content="Diberitahukan bahwa telah ada Input Daftar UPI pada aplikasi PLC dengan rincian sebagai berikut :<br><br>
				<div style='width: 600px;padding: 10px;background : #cfd1cf;margin: 0px;'>
					<table border='0' bgcolor='#cfd1cf' style='width: 600px;'>
						<tr>
							<td style='width: 110px;'><b>No UPI</b></td><td style='width: 20px;'> : </td><td>".$rupd['vNo_upi']."</td>
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
		
	}

}



/*manipulasi proses object form end*/    

/*function pendukung start*/    
	
/*function pendukung end*/    	

	
	




	

	
	

	public function output(){
		$this->index($this->input->get('action'));
	}

}

