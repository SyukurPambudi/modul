<?php
class lib_refor { 	
	private $_ci;
    private $sess_auth;
    function __construct() {
        $this->_ci=&get_instance();
        $this->_ci->load->library('Zend', 'Zend/Session/Namespace');
        $this->sess_auth = new Zend_Session_Namespace('auth');
		$this->logged_nip = $this->sess_auth->gNIP;
		
		//$this->updetIformula();
    }
    function user() {
		return $this->sess_auth;
	}
	

	/*-------------------------------------------------  auth    					start-------------------------------------------------------*/

	

	/*-------------------------------------------------  auth       				end --------------------------------------------------------*/

	/*get activity  modul*/
	
	function get_module_activities($modul_id){
		$sql = '
				select * 
				from erp_privi.m_modul a 
				join erp_privi.m_modul_activity b on b.iM_modul=a.iM_modul
				join erp_privi.m_activity c on c.iM_activity=b.iM_activity
				where a.lDeleted=0
				and b.lDeleted=0
				and c.lDeleted=0
				and a.idprivi_modules= 	"'.$modul_id.'"
				';
		$datas = $this->_ci->db->query($sql)->result_array();
		
		return $datas;
	}

	function get_module_activities_last($modul_id){

		$sql = '
				select * 
				from erp_privi.m_modul a 
				join erp_privi.m_modul_activity b on b.iM_modul=a.iM_modul
				join erp_privi.m_activity c on c.iM_activity=b.iM_activity
				where a.lDeleted=0
				and b.lDeleted=0
				and c.lDeleted=0
				and a.idprivi_modules= "'.$modul_id.'"
				order by b.iSort DESC
				limit 1
				';
		//echo $sql;
		$data = $this->_ci->db->query($sql)->row_array();
		
		return $data;

	}

	function get_last_module_activity($modul_id,$iKey_id){
		$sql ='sELECT IFNULL( (	select   b1.iSort
								from erp_privi.m_modul_log_activity a1 
								join erp_privi.m_modul c1 on c1.idprivi_modules=a1.idprivi_modules
								join erp_privi.m_modul_activity b1 on b1.iM_activity=a1.iM_activity and b1.iM_modul=c1.iM_modul and b1.iSort=a1.iSort
								where a1.idprivi_modules="'.$modul_id.'"  and a1.iKey_id="'.$iKey_id.'"
								and a1.lDeleted=0
								and b1.lDeleted=0
								and c1.lDeleted=0
								order by b1.iSort DESC limit 1) ,0) as last_sort ';
		$data = $this->_ci->db->query($sql)->row_array();
		
		return $data;
	}

	function get_current_module_activities($modul_id,$iKey_id){
		$sql = '
				select * 
				from erp_privi.m_modul a 
				join erp_privi.m_modul_activity b on b.iM_modul=a.iM_modul
				join erp_privi.m_activity c on c.iM_activity=b.iM_activity
				where a.lDeleted=0
				and b.lDeleted=0
				and c.lDeleted=0
				and a.idprivi_modules= "'.$modul_id.'"

				and b.iSort > (
							SELECT IFNULL( (	select   b1.iSort
								from erp_privi.m_modul_log_activity a1 
								join erp_privi.m_modul c1 on c1.idprivi_modules=a1.idprivi_modules
								join erp_privi.m_modul_activity b1 on b1.iM_activity=a1.iM_activity and b1.iM_modul=c1.iM_modul and b1.iSort=a1.iSort
								where a1.idprivi_modules="'.$modul_id.'"  and a1.iKey_id="'.$iKey_id.'"
								and a1.lDeleted=0
								and b1.lDeleted=0
								and c1.lDeleted=0
								order by b1.iSort DESC limit 1) ,0) as last_sort
				)
				limit 1

				';
				/* echo '<pre>'.$sql; */
		$datas = $this->_ci->db->query($sql)->result_array();
		
		return $datas;
	}

	function updetIformula(){
		$sql='SELECT 
				plc2_upb.iupb_id,formula_process.iFormula_process ,formula_stabilita.vNo_formula AS formula_stabilita_vNo_formula
				FROM (`pddetail`.`formula_process`)
				INNER JOIN `pddetail`.`formula_process_detail` ON `formula_process_detail`.`iFormula_process` = `formula_process`.`iFormula_process`
				INNER JOIN `pddetail`.`formula_stabilita` ON `formula_stabilita`.`iFormula_process` = `formula_process`.`iFormula_process`
				INNER JOIN `plc2`.`plc2_upb` ON `plc2_upb`.`iupb_id` = `formula_process`.`iupb_id`
				WHERE `formula_process_detail`.`lDeleted` = "0" 
				AND `formula_stabilita`.`lDeleted` = "0" 
				AND `formula_process`.`lDeleted` = "0" 
				GROUP BY plc2_upb.iupb_id, formula_stabilita.iVersi
				order by plc2_upb.iupb_id, formula_stabilita.iVersi 
		';		
		/* echo '<pre>'.$sql;
		exit; */
		$datas = $this->_ci->db->query($sql)->result_array();

		foreach ($datas as $data) {
			/* update ditabel formula untuk get last iFormula_process pada pddetail, karena yang dipakai adalah formula terakhir */
			$data_ss=array('iFormula_process'=>$data['iFormula_process']);
			$this->_ci->db-> where('iupb_id', $data['iupb_id']);
			$this->_ci->db->update('plc2.plc2_upb_formula', $data_ss);


		}



	}

	function getLastactivity($modul_id,$iKey_id){

		
		$iFinish = 0;
		$activity_last_mapping = $this->get_module_activities_last($modul_id);
		$last_mapping = $activity_last_mapping['iSort'];

		$last_module_activity = $this->get_last_module_activity($modul_id,$iKey_id);
		$last_sort = $last_module_activity['last_sort'];

		
		if( $last_sort == $last_mapping){
			$iFinish = 1;
		}

		return $iFinish;

	}

	function getCurrent_modul($iupb_id){
		$sql = 'select c.vNama_modul,d.iUrut
				from erp_privi.m_modul_log_upb a 
				join erp_privi.m_modul_log_activity b on b.iM_modul_log_activity=a.iM_modul_log_activity
				join erp_privi.m_modul c on c.idprivi_modules=b.idprivi_modules 
				join erp_privi.m_flow_proses d on d.iM_modul=c.iM_modul and d.iM_flow=1
				where a.lDeleted=0 and  a.iupb_id = "'.$iupb_id.'" 
				order by d.iUrut DESC
				limit 1';

		$dMod = $this->_ci->db->query($sql)->row_array();

		if(empty($dMod)){
			$data['vNama_modul'] = 'Log Modul tidak ditemukan';
			$data['iUrut'] = 0;
		}else{
			$data['vNama_modul'] = $dMod['vNama_modul'];
			$data['iUrut'] = $dMod['iUrut'];
		}

		/*print_r($data);*/
		return $data;
	}

	function getOpenEditing($modul_id,$iKey_id){

		
		$iOpen = 0;

		$sql = '
				select * 
				from erp_privi.m_modul a 
				join erp_privi.t_modul_open b on b.idprivi_modules=a.idprivi_modules
				where a.lDeleted=0
				and b.lDeleted=0
				and a.idprivi_modules= "'.$modul_id.'"
				and b.iKey_id = "'.$iKey_id.'"
				and b.iActive = 1
				';
		
		$data = $this->_ci->db->query($sql)->row_array();
		
		if(!empty($data)){
			$iOpen = 1;	
		}


		return $iOpen;

	}

	function getLastStatusApprove($modul_id,$iKey_id){
		$sql='select a.iApprove 
			from erp_privi.m_modul_log_activity a 
			where a.lDeleted=0 
			and a.iKey_id = "'.$iKey_id.'"
			and a.idprivi_modules= "'.$modul_id.'"
			and a.iM_activity <> 1
			order by a.iSort DESC
			limit 1
			';

		$data = $this->_ci->db->query($sql)->row_array();
		$iBoleh = false;

		if(!empty($data)){
			if($data['iApprove']==2){
				$iBoleh = true;	
			}else{
				$iBoleh = false;	
			}
			
		}else{
			$iBoleh = true;	
		}


		return $iBoleh;

	}

	function getIDActivityAndSort($iM_modul_activity){
		$sql = 'select * from erp_privi.m_modul_activity a where a.iM_modul_activity = "'.$iM_modul_activity.'" 		';
		$dAct = $this->_ci->db->query($sql)->row_array();

		if(empty($dMod)){
			$data = $dAct;
		}else{
			$data = array();
		}

		/*print_r($data);*/
		return $data;



	}

	function MigrasiInsertActivityModule($iupb_ids,$modul_id,$iKey_id,$iM_activity,$iSort,$vRemark='',$iApprove=0,$dapp,$capp){
		$isTrue = 0;
		$data=array();
		$data['iKey_id'] =$iKey_id;
		$data['idprivi_modules'] = $modul_id;
		$data['iM_activity'] = $iM_activity;
		$data['iSort'] = $iSort;

		$data['vRemark'] = $vRemark;
		$data['iApprove'] = $iApprove;
		$data['dCreate'] = $dapp;
		$data['cCreated'] = $capp;
		

		/* $data['dCreate'] = date('Y-m-d H:i:s');
		$data['cCreated'] = $this->logged_nip; */

		/* check sudah ada belum , jika sudah / jangan masukin */
		$ins = $this->_ci->db-> insert('erp_privi.m_modul_log_activity', $data);	
		$insertID =$this->_ci->db->insert_id();

		//echo $insertID;
		//print_r($iupb_ids);
		

		if($ins){
			

			foreach ($iupb_ids as $key => $value) {
				$data2['iM_modul_log_activity'] = $insertID;
				$data2['iupb_id'] = $value;
				$data2['dCreate'] = date('Y-m-d H:i:s');
				$data2['cCreated'] = $this->logged_nip;
				$ins2 = $this->_ci->db-> insert('erp_privi.m_modul_log_upb', $data2);	

			}

			$isTrue = 1;
		}
		

		
		return $isTrue;

	}

	function InsertActivityModule($iupb_ids,$modul_id,$iKey_id,$iM_activity,$iSort,$vRemark='',$iApprove=0){
		$isTrue = 0;
		$data=array();
		$data['iKey_id'] =$iKey_id;
		$data['idprivi_modules'] = $modul_id;
		$data['iM_activity'] = $iM_activity;
		$data['iSort'] = $iSort;

		$data['vRemark'] = $vRemark;
		$data['iApprove'] = $iApprove;
		

		$data['dCreate'] = date('Y-m-d H:i:s');
		$data['cCreated'] = $this->logged_nip;
		$ins = $this->_ci->db-> insert('erp_privi.m_modul_log_activity', $data);	
		$insertID =$this->_ci->db->insert_id();

		//echo $insertID;
		//print_r($iupb_ids);
		

		if($ins){
			

			foreach ($iupb_ids as $key => $value) {
				$data2['iM_modul_log_activity'] = $insertID;
				$data2['iupb_id'] = $value;
				$data2['dCreate'] = date('Y-m-d H:i:s');
				$data2['cCreated'] = $this->logged_nip;
				$ins2 = $this->_ci->db-> insert('erp_privi.m_modul_log_upb', $data2);	

			}

			$isTrue = 1;
		}
		

		
		return $isTrue;

	}

	function hasTeam($nip){
		$teams = '';
		$sql = "select rmd.vkode_departement 
				from reformulasi.reformulasi_team t
				join reformulasi.reformulasi_master_departement rmd on rmd.ireformulasi_master_departement=t.cDeptId 
				where t.ldeleted=0
				and t.vnip='".$nip."'
				and t.iTipe=2

				union 

				select rmd.vkode_departement 
				from reformulasi.reformulasi_team_item ti 
				join reformulasi.reformulasi_team t1 on t1.ireformulasi_team=ti.ireformulasi_team
				join reformulasi.reformulasi_master_departement rmd on rmd.ireformulasi_master_departement=t1.cDeptId 
				where ti.ldeleted=0
				and t1.iTipe=2
				and ti.vnip='".$nip."'
				  ";
		//echo '<pre>'.$sql;
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		if ($jmlRow > 0) {
			$rows = $query->result_array();
			$i=0;
			foreach ($rows as $data ) {
				if($i==0){
					$teams = $data['vkode_departement'];
				}else{
					$teams .= ','.$data['vkode_departement'];
				}
				$i++;
			}

		}

		return $teams;
	}

	function hasTeamID($nip){
		$teams = '';
		$sql = "select t.ireformulasi_team
				from reformulasi.reformulasi_team t
				where t.ldeleted=0
				and t.vnip='".$nip."'
				and t.iTipe=2

				union 

				select t1.ireformulasi_team 
				from reformulasi.reformulasi_team_item ti 
				join reformulasi.reformulasi_team t1 on t1.ireformulasi_team=ti.ireformulasi_team
				where ti.ldeleted=0
				and t1.iTipe=2
				and ti.vnip='".$nip."'
				  ";
		/*echo $sql;*/
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		if ($jmlRow > 0) {
			$rows = $query->result_array();
			$i=0;
			foreach ($rows as $data ) {
				if($i==0){
					$teams = $data['ireformulasi_team'];
				}else{
					$teams .= ','.$data['ireformulasi_team'];
				}
				$i++;
			}

		}

		return $teams;
	}

	function getNamaTeamUPB($iupb_id){
		$sql = 'select 
				*
				,ifnull(b.vteam,"-") as nmPD
				,ifnull(c.vteam,"-") as nmBD
				,ifnull(d.vteam,"-") as nmMKT
				,ifnull(e.vteam,"-") as nmQA
				,ifnull(f.vteam,"-") as nmAD

				
				from plc2.plc2_upb a 
				left join reformulasi.reformulasi_team b on b.ireformulasi_team=a.iteampd_id
				left join reformulasi.reformulasi_team c on c.ireformulasi_team=a.iteambusdev_id
				left join reformulasi.reformulasi_team d on d.ireformulasi_team=a.iteammarketing_id
				left join reformulasi.reformulasi_team e on e.ireformulasi_team=a.iteamqa_id 
				left join reformulasi.reformulasi_team f on f.ireformulasi_team=a.iteamad_id
				where a.ldeleted=0 
				and a.iupb_id="'.$iupb_id.'"';
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		if ($jmlRow > 0) {
			$rows = $query->row_array();
		}

		return $rows;

	}

	function managerAndChief($ireformulasi_team){
		$nips = '';
		$sql = 'select t.vnip
					from reformulasi.reformulasi_team t
					where t.ldeleted=0
					and t.ireformulasi_team = "'.$ireformulasi_team.'"
					and t.iTipe=2

					union 

					select t1.vnip
					from reformulasi.reformulasi_team_item ti 
					join reformulasi.reformulasi_team t1 on t1.ireformulasi_team=ti.ireformulasi_team
					where ti.ldeleted=0
					and ti.iapprove=1
					and t1.iTipe=2
					and t1.ireformulasi_team = "'.$ireformulasi_team.'"
				';

				/* echo '<pre>'.$sql;
				exit; */
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		if ($jmlRow > 0) {
			$rows = $query->result_array();
			$i=0;
			foreach ($rows as $data ) {
				if($i==0){
					$nips = $data['vnip'];
				}else{
					$nips .= ','.$data['vnip'];
				}
				$i++;
			}

		}

		return $nips;

	}

	function managerAndChiefIn($ireformulasi_team){
		$nips = '';
		$sql = 'select t.vnip
					from reformulasi.reformulasi_team t
					where t.ldeleted=0
					and t.ireformulasi_team in ('.$ireformulasi_team.')
					and t.iTipe=2

					union 

					select t1.vnip
					from reformulasi.reformulasi_team_item ti 
					join reformulasi.reformulasi_team t1 on t1.ireformulasi_team=ti.ireformulasi_team
					where ti.ldeleted=0
					and ti.iapprove=1
					and t1.iTipe=2
					and t1.ireformulasi_team in ('.$ireformulasi_team.')
				';

				/*echo $sql;
				exit;*/
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		if ($jmlRow > 0) {
			$rows = $query->result_array();
			$i=0;
			foreach ($rows as $data ) {
				if($i==0){
					$nips = $data['vnip'];
				}else{
					$nips .= ','.$data['vnip'];
				}
				$i++;
			}

		}

		return $nips;

	}

	function upbTeam($iupb_id){
			$sql = 'select 
					ifnull(a.iTeamPD,0) as PD
					, ifnull(a.iTeamAndev,0) as AD
					, 10 as QA
			from reformulasi.export_req_refor a 
			where a.lDeleted=0 
			and a.iexport_req_refor= "'.$iupb_id.'"';

		//echo $sql;
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		$rows = array();
		if ($jmlRow > 0) {
			$rows = $query->row_array();
		}

		return $rows;

	}

	function getAuthorModul($modul_id){		

		$sql = 'select * 
				from erp_privi.m_modul a 
				where a.lDeleted=0 
				and a.idprivi_modules="'.$modul_id.'"

				';
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		$rows=array();
		if ($jmlRow > 0) {
			$rows = $query->row_array();
		}

		return $rows;
	}

	function getIModulID($modul_id){

		$sql = 'select *
				from erp_privi.m_modul a 
				where a.lDeleted=0 
				and a.idprivi_modules="'.$modul_id.'"

				';
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		$rows=array();
		if ($jmlRow > 0) {
			$rows = $query->row_array();
		}
		$return=isset($rows['iM_modul'])?$rows['iM_modul']:'';
		return $return;

	}

	function getHistoryActivityUPB($modul_id, $iupb_id, $showDeleted=false){
	    $sql = 'SELECT b.vNama_activity, a.dCreate, c.vName, a.vRemark, IF(a.iApprove = 2, "Approve", IF(a.iApprove = 1, "Reject", "-")) AS setatus
	            FROM erp_privi.m_modul_log_activity a 
				JOIN erp_privi.m_activity b ON b.iM_activity = a.iM_activity
				JOIN erp_privi.m_modul_log_upb c ON c.iM_modul_log_activity = a.iM_modul_log_activity 
	            JOIN hrd.employee c ON c.cNip = a.cCreated
	            WHERE a.idprivi_modules = ?
	            AND c.iupb_id = ?
	    ';
	    if (!$showDeleted){
	    	$sql .= ' AND a.lDeleted = 0';
	    }
	    $sql .= ' ORDER BY a.iM_modul_log_activity DESC';

	    $query = $this->_ci->db->query($sql, array($modul_id, $iupb_id));
		$jmlRow = $query->num_rows();
		
		$html = '';

		if ($jmlRow > 0) {
			$rows = $query->result_array();
			$i=0;
			foreach ($rows as $data ) {
				$html .='
                    <tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['vNama_activity'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['setatus'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['dCreate'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['vName'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['vRemark'].'</span>
                        </td>
                    </tr>';


				$i++;
			}
		}else{
			$html .='
                    <tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
                        <td colspan="5" style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">No Data</span>
                        </td>
                    </tr>';


		}

		return $html;

	}

	function getHistoryActivity($modul_id, $iKey_id, $showDeleted=false){
	    $sql = 'SELECT b.vNama_activity, a.dCreate, c.vName, a.vRemark, IF(a.iApprove = 2, "Approve", IF(a.iApprove = 1, "Reject", "-" )) AS setatus
	            FROM erp_privi.m_modul_log_activity a 
	            JOIN erp_privi.m_activity b ON b.iM_activity = a.iM_activity
	            JOIN hrd.employee c ON c.cNip = a.cCreated
	            WHERE a.idprivi_modules = ?
	            	AND a.iKey_id = ?
	    ';

	    if (!$showDeleted){
	    	$sql .= ' AND a.lDeleted = 0';
	    }
	    $sql .= ' ORDER BY a.iM_modul_log_activity DESC';

	    $query = $this->_ci->db->query($sql, array($modul_id, $iKey_id));
		$jmlRow = $query->num_rows();
		
		$html = '';

		if ($jmlRow > 0) {
			$rows = $query->result_array();
			$i=0;
			foreach ($rows as $data ) {
				$html .='
                    <tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['vNama_activity'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['setatus'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['dCreate'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['vName'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">'.$data['vRemark'].'</span>
                        </td>
                    </tr>';


				$i++;
			}
		}else{
			$html .='
                    <tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
                        <td colspan="5" style="border: 1px solid #dddddd; text-align: center;">
                            <span class="">No Data</span>
                        </td>
                    </tr>';


		}

		return $html;

	}

	function isAdmin($isNiP=0){
		$this->_ci->db->like('vContent',$isNiP);
		$this->_ci->db->where('cVariable','ADMINPLCACCESS');
		$query = $this->_ci->db->get('plc2.plc_sysparam');
		$ret=false;
		if($query->num_rows()>0){
			$ret=true;
		}
		return $ret;
	}

	function whoAmI($nip) { 
        $sql = 'select b.vDescription as vdepartemen,a.*,b.*,c.iLvlemp 
                        from hrd.employee a 
                        join hrd.msdepartement b on b.iDeptID=a.iDepartementID
                        join hrd.position c on c.iPostId=a.iPostID
                        where a.cNip ="'.$nip.'"
                        ';
        
        $data = $this->_ci->db->query($sql)->row_array();
        return $data;
    }
    


	function getUploadFileFromField($iModul_id){
		$where=array(
				"m_modul_fields.iM_jenis_field"=>16
				,"m_modul.idprivi_modules"=>$iModul_id
			);
		$this->_ci->db->select("*")
						->from("erp_privi.m_modul_fields")
						->join("erp_privi.m_modul","m_modul.iM_modul=m_modul_fields.iM_modul")
						->where($where);
		$q=$this->_ci->db->get();
		$row=array();
		if($q->num_rows()>=1){
			$row=$q->result_array();
		}
		return $row;
	}

	function getUpbId($keyi,$id){
		$iupb_id="0";
		$sql="dasdas";
		switch ($keyi) {
			case 'ifor_id':
				$this->_ci->db->select("*")
					->from("plc2.plc2_upb_formula")
					->where("ifor_id",$id);
				$row=$this->_ci->db->get()->row_array();
				if(count($row)>0&&isset($row['iupb_id'])){
					$iupb_id=$row['iupb_id'];
				}
				break;
			case 'ibuatmbr_id':
				$this->_ci->db->select("*")
					->from("plc2.plc2_upb_buat_mbr")
					->join("plc2.plc2_upb_formula","plc2_upb_formula.ifor_id=plc2_upb_buat_mbr.ifor_id")
					->where($keyi,$id);
				$row=$this->_ci->db->get()->row_array();
				if(count($row)>0&&isset($row['iupb_id'])){
					$iupb_id=$row['iupb_id'];
				}
				break;
			case "imikro_fg_id":
				$this->_ci->db->select("*")
					->from("plc2.mikro_fg")
					->join("plc2.plc2_upb_formula","plc2_upb_formula.ifor_id=mikro_fg.ifor_id")
					->where("imikro_fg_id",$id);
				$row=$this->_ci->db->get()->row_array();
				if(count($row)>0&&isset($row['iupb_id'])){
					$iupb_id=$row['iupb_id'];
				}
				break;
			case "irodet_id":
				$this->_ci->db->select("*")
					->from("plc2.plc2_upb_ro_detail")
					->join("plc2.plc2_upb_request_sample","plc2.plc2_upb_request_sample.ireq_id = plc2.plc2_upb_ro_detail.ireq_id")
					->where("irodet_id",$id);
				$row=$this->_ci->db->get()->row_array();
				$sql=$this->_ci->db->last_query();
				if(count($row)>0&&isset($row['iupb_id'])){
					$iupb_id=$row['iupb_id'];
				}
				break;
			case "isoi_id":
				$this->_ci->db->select("*")
					->from("plc2.plc2_upb_soi_fg")
					->where("isoi_id",$id);
				$row=$this->_ci->db->get()->row_array();
				$sql=$this->_ci->db->last_query();
				if(count($row)>0&&isset($row['iupb_id'])){
					$iupb_id=$row['iupb_id'];
				}
				break;
			case "ivalmoa_id":
				$this->_ci->db->select("*")
					->from("plc2.plc2_vamoa")
					->where("ivalmoa_id",$id);
				$row=$this->_ci->db->get()->row_array();
				$sql=$this->_ci->db->last_query();
				if(count($row)>0&&isset($row['iupb_id'])){
					$iupb_id=$row['iupb_id'];
				}
				break;
			default:
				$iupb_id=$id;
				break;
		}
		return $iupb_id;
	}

	function generateFilename ($filename, $urut=0){
		$exDot = explode('.', $filename);
		$ext = $exDot[count($exDot)-1];
		$generated = str_replace(' ', '_', $filename);
		$generated = str_replace('.'.$ext, '', $generated);
		$generated = preg_replace('/[^A-Za-z0-9\-]/', '_', $generated);
		$dateNow = date('Y_m_d__H_i_s');
		$nameGenerated = $urut.'__'.$dateNow.'__'.$generated.'.'.$ext;
		return $nameGenerated;
	}

	function getUpbLog($iM_modul,$ijenis=0){
		$ii=000;
		$qReqModul=$this->getRequirmentModule($iM_modul);
		$sqlAnd='';
		if($qReqModul->num_rows()>0){
			foreach ($qReqModul->result_array() as $kreq => $vreq) {
				$iM_modul_activity=$vreq["iM_modul_activity"];
				$arraywhere=array('m_modul_activity.lDeleted'=>0
								,'m_modul.lDeleted'=>0
								,'m_modul_activity.iM_modul_activity'=>$iM_modul_activity);
				$arrid=array(1,3,4);
				/* $this->_ci->db->select('*')
						->from('erp_privi.m_modul_log_activity')
						->join('erp_privi.m_modul','m_modul.idprivi_modules=m_modul_log_activity.idprivi_modules')
						->join('erp_privi.m_modul_activity','m_modul_activity.iM_modul=m_modul.iM_modul')
						->where($arraywhere)
						->where_in($arrid)
						->where("(CASE 
							WHEN m_modul_activity.iM_activity=1
							THEN m_modul_log_activity.iApprove=1
							ELSE m_modul_log_activity.iApprove=2
							END)",NULL,TRUE); */
				$qq="SELECT m_modul_log_activity.*,m_modul.* FROM (`plc3`.`m_modul_log_activity`) 
						JOIN `plc3`.`m_modul` ON `m_modul`.`idprivi_modules`=`m_modul_log_activity`.`idprivi_modules` 
						JOIN `plc3`.`m_modul_activity` ON `m_modul_activity`.`iM_modul`=`m_modul`.`iM_modul` AND m_modul_activity.iM_activity=m_modul_log_activity.iM_activity
						WHERE `m_modul_activity`.`lDeleted` = 0 AND `m_modul`.`lDeleted` = 0 
						AND `m_modul_activity`.`iM_modul_activity` = '".$iM_modul_activity."'
						AND m_modul_activity.iM_activity IN (1,3,4)
						AND CASE WHEN m_modul_activity.iM_activity=1
						THEN m_modul_log_activity.iApprove=1
						ELSE m_modul_log_activity.iApprove=2
						END";
				$quee=$this->_ci->db->query($qq);
				
				if($quee->num_rows()>0){
					$sqlAndTambah=array();
					foreach ($quee->result_array() as $kk => $vv) {
						$sqlAndTambah[$vv["vTable_name"].".".$vv["vFieldPK"]][]=$vv["iKey_id"];
					}
					if(count($sqlAndTambah)>0){
						foreach ($sqlAndTambah as $kk => $vv) {
							$ini=implode(",",$vv);
							if($ijenis==0){
								$sqlAnd.=" AND ".$kk." IN (".$ini.")";
							}else{
								$sqlAnd.=$kk." IN (".$ini.")~~~";
							}
						}
					}
				}
			}
		}
		return $sqlAnd;
	}
	
	function getRequirmentModule($iM_modul){
		$arraywhere=array('m_modul_requirement.lDeleted'=>0,'isMainGrid'=>0,'m_modul_requirement.iM_modul'=>$iM_modul);
		$this->_ci->db->select('*')
						->from('erp_privi.m_modul_requirement')
					/* 	->join('erp_privi.m_modul','m_modul.iM_modul=m_modul_requirement.iM_modul')
						->join('erp_privi.m_modul_activity','m_modul_activity.iM_modul_activity=m_modul_requirement.iM_modul_activity') */
						->where($arraywhere);
		$quee=$this->_ci->db->get();
		/* print_r($this->_ci->db->last_query());exit(); */
		return $quee;
		// return $this->_ci->db->last_query();
	}
	
	/* Get Modul Data */
	function getDataModul($iM_modul){
		$this->_ci->db->select('*')
						->from('erp_privi.m_modul')
						->where('iM_modul',$iM_modul);
		$data=$this->_ci->db->get()->row_array();
		return $data;
	}
	/*  */

	/*get activity  modul*/
	function gridFilterUPBbyTeam($grid, $modul_id){
		$nip = $this->user()->gNIP; 
		$isAdmin = $this->isAdmin($nip);
		if (!$isAdmin){
			$arrTeam = explode(',',$this->hasTeam($nip));
            $AuthModul = $this->getAuthorModul($modul_id);
            $nipAuthor = explode(',', $AuthModul['vNip_author']);
            $nipParticipant = explode(',', $AuthModul['vNip_author']);
            $teamID = $this->hasTeamID($nip);

            if(in_array('PD', $arrTeam)){
                $grid->setQuery('plc2_upb.iteampd_id in ('.$teamID.')', NULL);                        
            }else if(in_array('AD', $arrTeam)){
                $grid->setQuery('plc2_upb.iteamad_id in ('.$teamID.')', NULL);                        
            }else if(in_array('QA', $arrTeam)){
                $grid->setQuery('plc2_upb.iteamqa_id in ('.$teamID.')', NULL);                        
            }else if(in_array('BD', $arrTeam)){
                $grid->setQuery('plc2_upb.iteambusdev_id in ('.$teamID.')', NULL);                        
            }else if( in_array($nip, $nipAuthor )|| in_array($nip, $nipParticipant)  ){

            }
		}

	}

	function queryFilterUPBbyTeam($modul_id, $tableAlias = 'plc2_upb'){
		$nip = $this->user()->gNIP; 
		$isAdmin = $this->isAdmin($nip);
		$filter = '';
        if(!$isAdmin){
			$arrTeam = explode(',',$this->hasTeam($nip));
            $AuthModul = $this->getAuthorModul($modul_id);
            $nipAuthor = explode(',', $AuthModul['vNip_author']);
            $nipParticipant = explode(',', $AuthModul['vNip_author']);
            $teamID = $this->hasTeamID($nip);

            if(in_array('PD', $arrTeam)){     
                $filter = ' AND '.$tableAlias.'.iteampd_id IN ('.$teamID.')';        
            }else if(in_array('AD', $arrTeam)){    
                $filter = ' AND '.$tableAlias.'.iteamad_id IN ('.$teamID.')';                        
            }else if(in_array('QA', $arrTeam)){    
                $filter = ' AND '.$tableAlias.'.iteamqa_id IN ('.$teamID.')';                        
            }else if(in_array('BD', $arrTeam)){    
                $filter = ' AND '.$tableAlias.'.iteambusdev_id IN ('.$teamID.')';                         
            }else if( in_array($nip, $nipAuthor )|| in_array($nip, $nipParticipant)  ){

            }
        }  
        return $filter;
	}

	function getFieldUpdate($table, $idModulAct, $status, $remark){
		$activity = $this->_ci->db->get_where('erp_privi.m_modul_activity', array('iM_modul_activity' => $idModulAct))->row_array();

		$sqlField = 'SHOW COLUMNS FROM '.$table;
		$rowField = $this->_ci->db->query($sqlField)->result_array();

		$dataUpdate = array();
		if (!empty($activity)){
			$vFieldName = $activity['vFieldName'];
			$dFieldName = $activity['dFieldName'];
			$cFieldName = $activity['cFieldName'];
			$tFieldName = $activity['tFieldName'];

			foreach ($rowField as $tField) {
				$fieldName = $tField['Field'];

				if ($fieldName == $vFieldName){
					$dataUpdate[$vFieldName] = $status;
				}

				if ($fieldName == $dFieldName){
					$dataUpdate[$dFieldName] = date('Y-m-d H:i:s');
				}

				if ($fieldName == $cFieldName){
					$dataUpdate[$cFieldName] = $this->logged_nip;
				}

				if ($fieldName == $tFieldName){
					$dataUpdate[$tFieldName] = $remark;
 				}
			}
		}
		return $dataUpdate;
	}

	/*  */

	/*get activity  modul*/
	
	function getDataFilterMainGrid($iM_modul){
		$return=array();
		$sql=$this->getUpbLog($iM_modul,1);
		if(strlen($sql)>0){
			$return = explode('~~~',trim($sql));
		}
		$where =array('lDeleted'=>0,'iM_modul'=>$iM_modul,'isMainGrid'=>1);
		$this->_ci->db->select('*')
						->from('erp_privi.m_modul_requirement')
						->where($where);
		$data=$this->_ci->db->get()->result_array();
		foreach ($data as $kd => $vv) {
			if($vv['tSource_Optional']!=""){
				$iM_modul_activity=$vv["iM_modul_activity"];
				$qq="SELECT m_modul_log_activity.*,m_modul.* FROM (`plc3`.`m_modul_log_activity`) 
						JOIN `plc3`.`m_modul` ON `m_modul`.`idprivi_modules`=`m_modul_log_activity`.`idprivi_modules` 
						JOIN `plc3`.`m_modul_activity` ON `m_modul_activity`.`iM_modul`=`m_modul`.`iM_modul` AND m_modul_activity.iM_activity=m_modul_log_activity.iM_activity
						WHERE `m_modul_activity`.`lDeleted` = 0 AND `m_modul`.`lDeleted` = 0 
						AND `m_modul_activity`.`iM_modul_activity` = '".$iM_modul_activity."'
						AND m_modul_activity.iM_activity IN (1,3,4)
						AND CASE WHEN m_modul_activity.iM_activity=1
						THEN m_modul_log_activity.iApprove=1
						ELSE m_modul_log_activity.iApprove=2
						END";
				$quee=$this->_ci->db->query($qq);
				
				if($quee->num_rows()>0){
					$sqlAndTambah=array();
					foreach ($quee->result_array() as $kk => $vv3) {
						$sqlAndTambah[$vv3["vTable_name"].".".$vv3["vFieldPK"]][]=$vv3["iKey_id"];
					}
					if(count($sqlAndTambah)>0){
						foreach ($sqlAndTambah as $kk1 => $vv1) {
							$ini=implode(",",$vv1);
							$returns=$kk1." IN (".$ini.")";
							$stsourch=str_replace('(?)',$returns,$vv['tSource_Optional']);
							$return[]=$stsourch;
						}
					}
				}else{
					$return[]=$vv['tSource_Optional'];
				}
			}
		}
		$ret=array_filter($return);
		return $ret;
	}
	
}
