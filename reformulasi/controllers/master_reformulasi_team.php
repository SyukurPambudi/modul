<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master_reformulasi_team extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
		$this->user = $this->auth->user(); 
        $this->jns_refor = array("Local", "Export");
        $this->dbset2 = $this->load->database('formulasi', false, true);
    }
    function index($action = '') {
    	$action = $this->input->get('action');
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;
		$grid->setTitle('Stakeholder');		
		$grid->setTable('reformulasi.reformulasi_team');		
		$grid->setUrl('master_reformulasi_team');
		$grid->addList('vteam','vnip','reformulasi_master_departement.vkode_departement','iStatus','iTipe');
		$grid->setSortBy('vteam');
		$grid->setSortOrder('asc'); //sort ordernya
		$grid->setWidth('vnip', '350'); // width nya
		$grid->setWidth('vteam', '150'); // width nya
		$grid->setWidth('reformulasi_master_departement.vkode_departement', '150'); // width nya
		$grid->setWidth('iStatus', '150'); // width nya
		$grid->setWidth('iTipe', '150'); // width nya
		$grid->addFields('vteam','vnip','cDeptId','iStatus','iTipe','team');
		$grid->setLabel('vnip', 'Manager'); //Ganti Label
		$grid->setLabel('vteam','Nama Team');
		$grid->setLabel('cDeptId','Departement');
		$grid->setLabel('reformulasi_master_departement.vkode_departement','Departement');
		$grid->setLabel('iStatus','Status');
		$grid->setLabel('iTipe','Jenis');
		$grid->setSearch('vteam','vnip','iStatus','iTipe');
		$grid->setRequired('vteam','vnip','cDeptId','iStatus');	//Field yg mandatori
		$grid->setQuery('reformulasi_team.ldeleted', 0);
		$grid->setDeletedKey('ldeleted');

        $grid->setAlign('vteam', 'center');
        $grid->setAlign('vnip', 'center');
        $grid->setAlign('cDeptId', 'center');
        $grid->setAlign('reformulasi_master_departement.vkode_departement', 'center');
        $grid->setAlign('iStatus', 'center');
        $grid->setAlign('iTipe', 'center');
		
		$grid->changeFieldType('iStatus','combobox','',array(''=>'Pilih',1=>'Aktif',0=>'Tidak aktif'));
		$grid->changeFieldType('iTipe','combobox','',array(''=>'Pilih',1=>'Local',2=>'Export'));

		

        $grid->setJoinTable('reformulasi.reformulasi_master_departement', 'reformulasi_team.cDeptId = reformulasi_master_departement.ireformulasi_master_departement', 'left'); 
		
	//	$grid->setMultiSelect(true);
		
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
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				echo $grid->updated_form();
				break;
			case 'searchcNip':
                echo $this->searchcNip();
                break;
			case 'employee_list':
				$this->employee_list();
			default:
				$grid->render_grid();
				break;
		}
    }

    public function searchcNip() {
        $tgl        = date('Y-m-d');
        $term       = $this->input->get('term'); 
        
        $data = array(); 

        //$sql = "select cNip, vName from hrd.employee where (cNip like '%{$term}%') limit 1 ";
        $sql = "SELECT a.cNip,a.vName,a.iDivisionID,a.iDepartementId,a.ibagid,a.iArea,a.iPostId,
                (SELECT vDescription FROM hrd.msdivision WHERE iDivID=a.iDivisionID) AS divisi,
                (SELECT vDescription FROM hrd.msdepartement WHERE iDeptID=a.iDepartementId) AS departement,
                (SELECT vDescription FROM hrd.bagian WHERE ibagid=a.ibagid) AS bagian,
                (SELECT vAreaname FROM hrd.area WHERE iAreaID=a.iArea) AS vAreaname,
                (SELECT vDescription FROM hrd.position WHERE iPostId=a.iPostId) AS jabatan,
                (SELECT c.vDescription FROM hrd.position AS b LEFT JOIN hrd.lvlemp AS c ON c.iLvlEmp=b.iLvlID 
                  WHERE b.iPostId=a.iPostID) AS lvlemply
                FROM hrd.employee AS a WHERE 
                (a.dresign='0000-00-00' OR a.dresign>'".date('Y-m-d H:i:s')."') AND
                (a.cNip LIKE '%{$term}%' OR a.vName LIKE '%{$term}%') ORDER BY a.vName ASC limit 50";
        //echo $sql;exit;   
    
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {         
            foreach($query->result_array() as $line) {
                $row_array['id']        = trim($line['cNip']);
                $row_array['value']     = trim($line['cNip']).' - '.trim($line['vName']);
                $row_array['divisi']    = trim($line['divisi']);
                $row_array['vAreaname'] = trim($line['vAreaname']);
                $row_array['jabatan']   = trim($line['jabatan']);
                $row_array['departement']   = trim($line['departement']);
                $row_array['bagian']        = trim($line['bagian']);
                $row_array['lvlemply']      = trim($line['lvlemply']);

                $row_array['iDivisionID']   = trim($line['iDivisionID']);
                $row_array['iDepartementId']    = trim($line['iDepartementId']);
                $row_array['ibagid']        = trim($line['ibagid']);
                $row_array['iArea']         = trim($line['iArea']);
                $row_array['iPostId']       = trim($line['iPostId']); 
                
                array_push($data, $row_array);
            }
        }
        
        echo json_encode($data);
        exit;   
    }

    function listBox_master_reformulasi_team_iTipe($value) {
        if($value==1){
            $vstatus='Local';
        }elseif($value==2){
            $vstatus='Export';
        }
        return $vstatus;
    }

    function listBox_master_reformulasi_team_vnip($value) {
        $query = "SELECT vName FROM hrd.employee WHERE cNip = '".$value."' LIMIT 1";
        $data = $this->dbset2->query($query)->row_array();
        return $data['vName']." - ".$value;
    }

	function searchBox_master_reformulasi_team_vteam($name, $id) {
		return '<input id="'.$id.'" type="text" />';
	}

	function insertCheck_master_reformulasi_team_vteam($value, $field, $rows) {
		$this->db->where('vteam', $value);
		$j = $this->db->count_all_results('reformulasi.reformulasi_team');
		if($j > 0) {
			return 'Nama Team '.$value.' sudah ada yg insert!';
		} 
		else {
			return TRUE;
		}
	}

	function insertBox_master_reformulasi_team_team($field, $id) {
		// $this->load->config('reformulasi_config');
		// $conf_level = $this->config->item('plc_level');
		// $level = '<select name="iLevel[]" class="master_reformulasi_team_iLevel">';
		// $level .= '<option value="">--select--</option>';
		// foreach($conf_level as $d) {
			// $level .= '<option value="'.$d.'">'.$d.'</option>';
		// }
		// $level .= '</select>';
		// $data['level'] = $level;
		
		return $this->load->view('master_reformulasi_team_struktur_member','',TRUE);
	}
	
	function updateBox_master_reformulasi_team_team($field, $id, $value, $rowData) {
		$rowId = $rowData['ireformulasi_team'];
		$this->db->select(array('reformulasi.reformulasi_team_item.*', 'hrd.employee.vName'), false);
		$this->db->where(array('ireformulasi_team' => $rowId, 'reformulasi.reformulasi_team_item.ldeleted' => 0));
		$this->db->order_by('reformulasi.reformulasi_team_item.ireformulasi_team_item', 'ASC');
		$this->db->join('hrd.employee', 'reformulasi.reformulasi_team_item.vnip = hrd.employee.cNip', 'inner');
		$data['member'] = $this->db->get('reformulasi.reformulasi_team_item')->result_array();
		
		// $this->load->config('reformulasi_config');
		// $conf_level = $this->config->item('plc_level');
		// $level = '<select name="iLevel[]" class="master_reformulasi_team_iLevel">';
		// $level .= '<option value="">--select--</option>';
		// foreach($conf_level as $d) {
			// $level .= '<option value="'.$d.'">'.$d.'</option>';
		// }
		// $level .= '</select>';
		// $data['level'] = $level;
		
		return $this->load->view('master_reformulasi_team_struktur_member',$data,TRUE); 
	}
	
	function insertBox_master_reformulasi_team_cDeptId($field, $id) {
		$query = "SELECT * FROM reformulasi.reformulasi_master_departement WHERE lDeleted = '0' AND iStatus = '0' ORDER BY vkode_departement ASC";
        $dept = $this->dbset2->query($query)->result_array();
        $o = '<select class="input_rows1 required" name="'.$field.'" id="'.$id.'">';
        $o .= '<option value="">--Select--</option>';
        foreach ($dept as $t) {
            $o .= '<option value="'.$t['ireformulasi_master_departement'].'">'.$t['vkode_departement'].'</option>';
        }
        $o .= '</select>';
		return $o;
	}
	
	function updateBox_master_reformulasi_team_cDeptId($field, $id, $value) {
		$query = "SELECT * FROM reformulasi.reformulasi_master_departement WHERE lDeleted = '0' AND iStatus = '0' ORDER BY vkode_departement ASC";
        $dept = $this->dbset2->query($query)->result_array();
        $o = '<select class="input_rows1 required" name="'.$field.'" id="'.$id.'">';
        $o .= '<option value="">--Select--</option>';
        foreach ($dept as $t) {
        	if ($value == $t['ireformulasi_master_departement']){
                $selected = " selected";
            }else{
                $selected = "";
            }
            $o .= '<option '.$selected.' value="'.$t['ireformulasi_master_departement'].'">'.$t['vkode_departement'].'</option>';
        }
        $o .= '</select>';
		return $o;
	}

	function insertBox_master_reformulasi_team_vnip($field, $id){
		$url6 = base_url().'processor/reformulasi/master/reformulasi/team?action=searchcNip'; 
                $o = "<script type='text/javascript'>
                        $(document).ready(function() { 
                            $('#".$id."_').live('keyup', function(e) {
                                var config = {
                                    source: '".$url6."',                    
                                    select: function(event, ui){
                                        $('#".$id."').val(ui.item.id);
                                        $('#".$id."_').val(ui.item.value);  
                                        return false;                           
                                    },
                                    minLength: 2,
                                    autoFocus: true,
                                    }; 
                                $('#".$id."_').autocomplete(config);  
                                $(this).keypress(function(e){
                                    if(e.which != 13) {
                                        $('#".$id."').val('');
                                    }           
                                });
                                $(this).blur(function(){
                                    if($('#".$id."').val() == '') {
                                        $(this).val('');
                                    }           
                                });

                            }); 
                                
                        }); 
                  </script>";
        $o   .= '<input type="hidden" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="50" maxlength = "50"  value=""/>';
        $o   .= '<input type="text" name="'.$field.'_"  id="'.$id.'_"  class="input_rows1 required" size="50" maxlength = "50"  value=""/>';             
        return $o;
	}

	function updateBox_master_reformulasi_team_vnip($field, $id, $value, $rowData){
		$vn = "SELECT e.`vName` FROM hrd.`employee` e WHERE e.`cNip` = '".$value."'";
        $vName = $this->db->query($vn)->row_array();
        if(empty($vName['vName'])){
            $vName['vName'] = '-';
        }
        if ($this->input->get('action') == 'view') {
             $o= $value.' - '.$vName['vName']; 
        }else{
			$url6 = base_url().'processor/reformulasi/master/reformulasi/team?action=searchcNip'; 
            $o = "<script type='text/javascript'>
	                    $(document).ready(function() { 
	                        $('#".$id."_').live('keyup', function(e) {
	                            var config = {
	                                source: '".$url6."',                    
	                                select: function(event, ui){
	                                    $('#".$id."').val(ui.item.id);
	                                    $('#".$id."_').val(ui.item.value);  
	                                    return false;                           
	                                },
	                                minLength: 2,
	                                autoFocus: true,
	                                }; 
	                            $('#".$id."_').autocomplete(config);  
	                            $(this).keypress(function(e){
	                                if(e.which != 13) {
	                                    $('#".$id."').val('');
	                                }           
	                            });
	                            $(this).blur(function(){
	                                if($('#".$id."').val() == '') {
	                                    $(this).val('');
	                                }           
	                            });

	                        }); 
	                            
	                    }); 
	              </script>";
            $o   .= '<input type="hidden" name="'.$field.'"  id="'.$id.'"  class="input_rows1 required" size="50" maxlength = "50"  value="'.$value.'"/>';
            $o   .= '<input type="text" name="'.$field.'_"  id="'.$id.'_"  class="input_rows1 required" size="50" maxlength = "50"  value="'.$value.' - '.$vName['vName'].'"/>';
        }

        
        return $o;
	}

	function insertBox_master_reformulasi_team_iTipe($field, $id) {
        $o = '<select class="input_rows1 required" name="'.$field.'" id="'.$id.'">';
        $o .= '<option value="1" selected>Local</option>';
        $o .= '<option value="2">Export</option>';
        $o .= '</select> <style>
                 #'.$id.'{
                     width:100px;   
                }
              </style>';
        return $o;
    }
    function updateBox_master_reformulasi_team_iTipe($field, $id, $value, $rowData) {
        if ($this->input->get('action') == 'view') {
             $return= $this->jns_refor[$value-1]; 
        }else{
            $return = '<select class="input_rows1 required" name="'.$field.'" id="'.$id.'">';
            $data = '';
            foreach ($this->jns_refor as $i => $j) {
                if ($value == ($i+1) ){
                    $selected = " selected";
                }else{
                    $selected = "";
                }
                $return .= '<option '.$selected.' value="'.($i+1).'">'.$j.'</option>';
            }
            $return .= '</select> <style>
                     #'.$id.'{
                         width:100px;   
                    }
                  </style>';
        } 
        return $return;
    } 
	
	function searchBox_master_reformulasi_team_cDeptId($field, $id) {
		$query = "SELECT * FROM reformulasi.reformulasi_master_departement WHERE lDeleted = '0' AND iStatus = '0' ORDER BY vkode_departement ASC";
        $dept = $this->dbset2->query($query)->result_array();
        $o = '<select class="input_rows1 required" name="'.$field.'" id="'.$id.'">';
        $o .= '<option value="">--Select--</option>';
        foreach ($dept as $t) {
            $o .= '<option value="'.$t['ireformulasi_master_departement'].'">'.$t['vkode_departement'].'</option>';
        }
        $o .= '</select>';
		return $o;
	}
	
	function before_insert_processor($row, $postData) {
		$user = $this->auth->user();
		unset($postData['nip']);
		unset($postData['name']);
		//unset($postData['iLevel']);
		unset($postData['team']);
		$postData['cnip'] = $user->gNIP;
		$postData['tupdate'] = date('Y-m-d H:i:s');
		return $postData;
	}
	
	function after_insert_processor ($row, $insertId, $postData) {
		$user = $this->auth->user();

		$sql = "SELECT rd.`vkode_departement` FROM reformulasi.`reformulasi_master_departement` rd 
			WHERE rd.`ireformulasi_master_departement` = '".$postData['cDeptId']."' LIMIT 1";
		$dsql = $this->db->query($sql)->row_array();
		$qlU = "UPDATE reformulasi.`reformulasi_team` SET `vtipe` = '".$dsql['vkode_departement']."' 
			WHERE `ireformulasi_team` = '".$insertId."'";
		$this->db->query($qlU);

		$nip = $postData['nip'];
		//$level = $postData['iLevel'];		
		foreach($nip as $k => $v) {
			$this->db->insert('reformulasi.reformulasi_team_item', array('ireformulasi_team'=>$insertId,'vnip'=>$v,'iLevel'=>0,'ccreated'=>$user->gNIP,'tcreated'=>date('Y-m-d H:i:s')));
			//$this->db->insert('reformulasi.reformulasi_team_item', array('ireformulasi_team'=>$insertId,'vnip'=>$v,'iLevel'=>$level[$k],'ccreated'=>$user->gNIP,'tcreated'=>date('Y-m-d H:i:s')));
		}
		return TRUE;
	}
	
	function before_update_processor($row, $postData) {
		//print_r($postData);
		$user = $this->auth->user();
		unset($postData['nip']);
		unset($postData['name']);
		//unset($postData['iLevel']);
		unset($postData['team']);
		$postData['cupdate'] = $user->gNIP;
		$postData['tupdate'] = date('Y-m-d H:i:s');
		return $postData;
	}
	
	function after_update_processor ($row, $updateId, $postData) {
		$user = $this->auth->user();
		$nip = $postData['nip'];

		$sql = "SELECT rd.`vkode_departement` FROM reformulasi.`reformulasi_master_departement` rd 
			WHERE rd.`ireformulasi_master_departement` = '".$postData['cDeptId']."' LIMIT 1";
		$dsql = $this->db->query($sql)->row_array();
		$qlU = "UPDATE reformulasi.`reformulasi_team` SET `vtipe` = '".$dsql['vkode_departement']."' 
			WHERE `ireformulasi_team` = '".$updateId."'";
		$this->db->query($qlU);
		
		//$level = $postData['iLevel'];
		$this->db->where('ireformulasi_team', $updateId);
		if($this->db->update('reformulasi.reformulasi_team_item', array('ldeleted'=>1,'cupdated'=>$user->gNIP,'tupdated'=>date('Y-m-d H:i:s')))) {
			foreach($nip as $k => $v) {
				$this->db->insert('reformulasi.reformulasi_team_item', array('ireformulasi_team'=>$updateId,'vnip'=>$v,'iLevel'=>'','ccreated'=>$user->gNIP,'tcreated'=>date('Y-m-d H:i:s')));
				//$this->db->insert('reformulasi.reformulasi_team_item', array('ireformulasi_team'=>$updateId,'vnip'=>$v,'iLevel'=>$level[$k],'ccreated'=>$user->gNIP,'tcreated'=>date('Y-m-d H:i:s')));
			}
		}
		return TRUE;
	}

	function employee_list() {
		$term = $this->input->get('term');
		$return_arr = array();
		$this->db->like('cNip',$term);
		$this->db->or_like('vName',$term);
		$this->db->limit(50);
		$lines = $this->db->get('hrd.employee')->result_array();
		$i=0;
		foreach($lines as $line) {
			$row_array["value"] = trim($line["vName"]).' - '.trim($line["cNip"]);
			$row_array["id"] = trim($line["cNip"]);
			array_push($return_arr, $row_array);
		}
		echo json_encode($return_arr);exit();
	}
	
    function output(){
    	$this->index($this->input->get('action'));
    }


    public function listBox_Action($row, $actions) {
    	$teamid= $row->ireformulasi_team;
    	

//		unset($actions['edit']);
//		unset($actions['view']);
//		unset($actions['delete']);
		if($this->auth->is_manager()   ){
			$x=$this->auth->team();
			$manager=$x['manager'];
			if(in_array($teamid, $manager)  ){
				
				
			}else{
				unset($actions['edit']);
			}
			
			
		}else if($this->user->gDivId == 6){



		}else{
			unset($actions['edit']);
		}


		return $actions;
		
    }




	function manipulate_update_button($buttons) {
        if ($this->input->get('action') == 'view') {unset($buttons['update']);}

        else{

        }
        return $buttons;
    }


}