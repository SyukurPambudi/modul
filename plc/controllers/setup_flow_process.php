<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class setup_flow_process extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->dbset = $this->load->database('plc0',false, true);

		$this->title = 'Master Flow';
		$this->url = 'setup_flow_process';

		$this->maintable = 'plc3.m_flow';	
		$datagrid['islist'] = array(
			'vKode_flow' => array('label'=>'Kode Flow','width'=>100,'align'=>'center','search'=>true,'required'=>true)
			,'vNama_flow' => array('label'=>'Nama Flow','width'=>300,'align'=>'left','search'=>true,'required'=>true)
		);
		$datagrid['isField'] = array(
			'vKode_flow' => array('label'=>'Kode')
			,'vNama_flow' => array('label'=>'Nama Flow')
			,'form_flow_process' => array('label'=>'Flow Process')
		);
		$datagrid['shortBy']=array('vKode_flow'=>'Desc');
		$this->setGroupBy='vKode_flow';	

		$datagrid['setQuery']=array(
								0=>array('vall'=>'lDeleted','nilai'=>0)
								/*,1=>array('vall'=>'ikalibrasi','nilai'=>1)*/
								);

		$this->datagrid=$datagrid;

		$this->load->library('auth_localnon');
		$this->user = $this->auth_localnon->user();
    }

    function index($action = '') {
    	$grid = new Grid;		
		$grid->setTitle($this->title);		
		$grid->setTable($this->maintable );
		$grid->setUrl($this->url);
		$grid->setGroupBy($this->setGroupBy);
		foreach ($this->datagrid as $kv => $vv) {
			/*Untuk List*/
			if($kv=='islist'){
				foreach ($vv as $list => $vlist) {
					$grid->addList($list);
					foreach ($vlist as $kdis => $vdis) {
						if($kdis=='label'){
							$grid->setLabel($list, $vdis);
						}
						if($kdis=='width'){
							$grid->setWidth($list, $vdis);
						}
						if($kdis=='align'){
							$grid->setAlign($list, $vdis);
						}
						if($kdis=='search' && $vdis==true){
							$grid->setSearch($list);
						}
						if($kdis=='required'){
							$grid->setRequired($list);
						}
					}
				}
			}
			/*Untuk Field*/
			if($kv=='isField'){
				foreach ($vv as $list => $vlist) {
					$grid->addFields($list);
					foreach ($vlist as $kdis => $vdis) {
						if($kdis=='label'){
							$grid->setLabel($list, $vdis);
						}
					}
				}
			}

			/*Untuk Short List*/
			if($kv=='shortBy'){
				foreach ($vv as $list => $vlist) {
					$grid->setSortBy($list);
					$grid->setSortOrder($vlist);
				}
			}

			if($kv=='inputGet'){
				foreach ($vv as $list => $vlist) {
					$grid->setInputGet($list,$vlist);
				}
			}

			if($kv=='jointableinner'){
				foreach ($vv as $list => $vlist) {
					foreach ($vlist as $tbjoin => $onjoin) {
						$grid->setJoinTable($tbjoin, $onjoin, 'inner');
					}
				}
			}
			if($kv=='setQuery'){
				foreach ($vv as $kv => $vlist) {
					$grid->setQuery($vlist['vall'], $vlist['nilai']);
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
			case 'update':
				$grid->render_form($this->input->get('id'));
				break;
			case 'view':
				$grid->render_form($this->input->get('id'),TRUE);
				break;
			case 'updateproses':
				echo $grid->updated_form();
				break;	
			case 'delete':
				echo $grid->delete_row();
				break;	
			case 'dataDetailsFlow':
				echo $this->getDataDetails();
				break;
			case 'getProcess':
				echo $this->getProcess();
				break;	
			default:
				$grid->render_grid();
				break;
		}
    }

	function output(){
    	$this->index($this->input->get('action'));
    }

    function manipulate_update_button($buttons, $rowData){
		//unset($buttons['update']);
		return $buttons;
	}

	/*Manipulate Insert Form*/
	function insertBox_setup_flow_process_form_cCode($field,$id){
		  $vIsi = '';
		$js = '';
		$o = "";
	
		return $js.$o;
	}

	/*Manipulate update form*/
	function updateBox_setup_flow_process_form_flow_process($field, $id, $value, $rowData) {
		$data['get']=$this->input->get();
    	$data['id']=$this->input->get('id');
		return $this->load->view('template/grid/master_flow_details_grid',$data,TRUE);
	}

	/*After Update Process*/
	function after_update_processor($r, $insertid, $postData){
		/*Deklarasi*/
		$vkodeInsert=array();
		$vkodeUpdate=array();
		$iUrutInsert=array();
		$iUrutUpdate=array();
		$idupdate=array();

		$iM_flow=$postData['setup_flow_process_iM_flow'];

		foreach ($postData as $kpost => $vpost) {
			if($kpost=="setup_flow_process_vkode"){
				foreach ($vpost as $key => $vbel) {
					if($key==0){
						foreach ($vbel as $kbel => $vlast) {
							$vkodeInsert[$kbel]=$vlast;
						}
					}else{
						foreach ($vbel as $kbel => $vlast) {
							$vkodeUpdate[$key]=$vlast;
						}
						$idupdate[]=$key;
					}
				}
			}

			if($kpost=="setup_flow_process_iUrut"){
				foreach ($vpost as $key => $vbel) {
					if($key==0){
						foreach ($vbel as $kbel => $vlast) {
							$iUrutInsert[$kbel]=$vlast;
						}
					}else{
						foreach ($vbel as $kbel => $vlast) {
							$iUrutUpdate[$key]=$vlast;
						}
					}
				}
			}
		}
		$date=date("Y-m-d H:i:s");
		if(count($idupdate)==0){
			$datadel=array();
			$datadel['lDeleted']=1;
			$datadel['dupdate']=$date;
			$datadel['cUpdate']=$this->user->gNIP;
			$this->dbset->where('iM_flow',$iM_flow);
			if($this->dbset->update("plc3.m_flow_proses",$datadel)){

			}else{
				echo "Deleted Failed";
			}
		}else{
			$datadel=array();
			$datadel['lDeleted']=1;
			$datadel['dupdate']=$date;
			$datadel['cUpdate']=$this->user->gNIP;
			$this->dbset->where('iM_flow',$iM_flow);
			$this->dbset->where_not_in('iM_flow_proses',$idupdate);
			if($this->dbset->update("plc3.m_flow_proses",$datadel)){

			}else{
				echo "Deleted Failed";
			}
		}

		
		if(count($vkodeInsert)>0){
			foreach ($vkodeInsert as $ki => $vi) {
				$dataInsert=array();
				$iUrut=isset($iUrutInsert[$ki])?$iUrutInsert[$ki]:'0';
				$dataInsert['iM_modul']=$vi;
				$dataInsert['iM_flow']=$iM_flow;
				$dataInsert['iUrut']=$iUrut;
				$dataInsert['dCreate']=$date;
				$dataInsert['cCreated']=$this->user->gNIP;
				if($this->dbset->insert('plc3.m_flow_proses',$dataInsert)){

				}else{
					echo "Failed Insert";
				}
			}
		}

		if(count($vkodeUpdate)){
			foreach ($vkodeUpdate as $ku => $vu) {
				$this->dbset->where('iM_flow_proses',$ku);
				$dataupdate=array();
				$dataupdate['iM_modul']=$vu;
				$iUrut=isset($iUrutUpdate[$ku])?$iUrutUpdate[$ku]:'0';
				$dataupdate['iUrut']=$iUrut;
				$dataupdate['dupdate']=$date;
				$dataupdate['cUpdate']=$this->user->gNIP;
				if($this->dbset->update('plc3.m_flow_proses',$dataupdate)){

				}else{
					echo "Failed Insert";
				}
			}
		}

	}

    /*Function Tambahan*/

    function getDataDetails(){
    	$post=$this->input->post();
    	$get=$this->input->get();
    	$nmTable=isset($get['nmTable'])?$get['nmTable']:$this->url;
    	$grid=isset($get['grid'])?$get['grid']:$this->url;
    	$id=isset($get['id'])?$get['id']:0;
		$sql_data="select mp.*,md.iM_modul,md.vKode_modul,md.vNama_modul from plc3.m_flow_proses mp
				join plc3.m_flow mf on mf.iM_flow=mp.iM_flow
				join plc3.m_modul md on md.iM_modul=mp.iM_modul
				where mp.lDeleted=0 and mf.lDeleted=0 and md.lDeleted=0
				and mp.iM_flow=".$id." ORDER by mp.iUrut ASC";
		$q=$this->dbset->query($sql_data);
		$rsel=array('hapus','vKode_modul',"iUrut");
		$data = new StdClass;
		$data->records=$q->num_rows();
		$i=0;
		foreach ($q->result() as $k) {
			$data->rows[$i]['id']=$i;
			$z=0;
			foreach ($rsel as $dsel => $vsel) {
				if($vsel=="hapus"){
					$dataar[$dsel]="<input type='hidden' class='num_rows_".$nmTable."' value='".$i."' /><a href='javascript:;' onclick='javascript:hapus_row_".$nmTable."(".$i.")'><center><span class='ui-icon ui-icon-close'></span></center></a>";
				}elseif($vsel=="vKode_modul"){
					$dataar[$dsel]="<input type='text' size='35' id='".$grid."_vkode_text_".$i."' value='".$k->vKode_modul." - ".$k->vNama_modul."' class='autocomplate_flow_process required' name='".$grid."_vkode_text[".$k->iM_flow_proses."][]'><input type='hidden' size='10' class='required classiMmodul' value='".$k->iM_modul."' id='".$grid."_vkode_".$i."' name='".$grid."_vkode[".$k->iM_flow_proses."][]'>";
				}elseif($vsel=="iUrut"){
					$dataar[$dsel]="<input type='text' size='5' id='".$grid."_iUrut_".$i."' value='".$k->iUrut."' class='numbersOnly required' name='".$grid."_iUrut[".$k->iM_flow_proses."][]'>";
				}else{
					$dataar[$dsel]=$k->{$vsel};
				}
				$z++;
			}
			$data->rows[$i]['cell']=$dataar;
			$i++;
		}
		return json_encode($data);
    }


    function getProcess(){
    	$term = $this->input->get('term');
    	$id = $this->input->get('id');
    	$sql='select * from plc3.m_modul mo where mo.lDeleted=0 and mo.iM_flow='.$id.' and (mo.vNama_modul like "%'.$term.'%" or mo.vKode_modul like "%'.$term.'%") order by mo.vNama_modul ASC';
    	$dt=$this->dbset->query($sql);
    	$data = array();
    	if($dt->num_rows>0){
    		foreach($dt->result_array() as $line) {
	
				$row_array['value'] = $line['vKode_modul'].' - '.trim($line['vNama_modul']);
				$row_array['id']    = $line['iM_modul'];
	
				array_push($data, $row_array);
			}
    	}
    	return json_encode($data);
		exit;
    }

}