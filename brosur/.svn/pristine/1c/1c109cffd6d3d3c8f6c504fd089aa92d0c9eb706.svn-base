<?php
class lib_plc { 	
	private $_ci;
    private $sess_auth;
    function __construct() {
        $this->_ci=&get_instance();
        $this->_ci->load->library('Zend', 'Zend/Session/Namespace');
        $this->sess_auth = new Zend_Session_Namespace('auth');
        $this->logged_nip = $this->sess_auth->gNIP;
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
				from plc3.m_modul a 
				join plc3.m_modul_activity b on b.iM_modul=a.iM_modul
				join plc3.m_activity c on c.iM_activity=b.iM_activity
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
				from plc3.m_modul a 
				join plc3.m_modul_activity b on b.iM_modul=a.iM_modul
				join plc3.m_activity c on c.iM_activity=b.iM_activity
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
								from plc3.m_modul_log_activity a1 
								join plc3.m_modul c1 on c1.idprivi_modules=a1.idprivi_modules
								join plc3.m_modul_activity b1 on b1.iM_activity=a1.iM_activity and b1.iM_modul=c1.iM_modul and b1.iSort=a1.iSort
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
				from plc3.m_modul a 
				join plc3.m_modul_activity b on b.iM_modul=a.iM_modul
				join plc3.m_activity c on c.iM_activity=b.iM_activity
				where a.lDeleted=0
				and b.lDeleted=0
				and c.lDeleted=0
				and a.idprivi_modules= "'.$modul_id.'"

				and b.iSort > (
							SELECT IFNULL( (	select   b1.iSort
								from plc3.m_modul_log_activity a1 
								join plc3.m_modul c1 on c1.idprivi_modules=a1.idprivi_modules
								join plc3.m_modul_activity b1 on b1.iM_activity=a1.iM_activity and b1.iM_modul=c1.iM_modul and b1.iSort=a1.iSort
								where a1.idprivi_modules="'.$modul_id.'"  and a1.iKey_id="'.$iKey_id.'"
								and a1.lDeleted=0
								and b1.lDeleted=0
								and c1.lDeleted=0
								order by b1.iSort DESC limit 1) ,0) as last_sort
				)
				limit 1

				';
				/*echo '<pre>'.$sql;*/
		$datas = $this->_ci->db->query($sql)->result_array();
		
		return $datas;
	}

	function getLastactivity($modul_id,$iKey_id){

		
		$iFinish = 0;
		$activity_last_mapping = $this->get_module_activities_last($modul_id);
		$last_mapping = (!empty($activity_last_mapping)) ? $activity_last_mapping['iSort'] : 0;

		$last_module_activity = $this->get_last_module_activity($modul_id,$iKey_id);
		$last_sort = $last_module_activity['last_sort'];

		
		if( $last_sort == $last_mapping){
			$iFinish = 1;
		}

		return $iFinish;

	}

	function getCurrent_modul($iupb_id){
		$sql = 'select c.vNama_modul,d.iUrut
				from plc3.m_modul_log_upb a 
				join plc3.m_modul_log_activity b on b.iM_modul_log_activity=a.iM_modul_log_activity
				join plc3.m_modul c on c.idprivi_modules=b.idprivi_modules 
				join plc3.m_flow_proses d on d.iM_modul=c.iM_modul and d.iM_flow=1
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
				from plc3.m_modul a 
				join plc3.t_modul_open b on b.idprivi_modules=a.idprivi_modules
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
			from plc3.m_modul_log_activity a 
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
		$sql = 'select * from plc3.m_modul_activity a where a.iM_modul_activity = "'.$iM_modul_activity.'" 		';
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
		$ins = $this->_ci->db-> insert('plc3.m_modul_log_activity', $data);	
		$insertID =$this->_ci->db->insert_id();

		//echo $insertID;
		//print_r($iupb_ids);
		

		if($ins){
			

			foreach ($iupb_ids as $key => $value) {
				$data2['iM_modul_log_activity'] = $insertID;
				$data2['iupb_id'] = $value;
				$data2['dCreate'] = date('Y-m-d H:i:s');
				$data2['cCreated'] = $this->logged_nip;
				$ins2 = $this->_ci->db-> insert('plc3.m_modul_log_upb', $data2);	

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
		$ins = $this->_ci->db-> insert('plc3.m_modul_log_activity', $data);	
		$insertID =$this->_ci->db->insert_id();

		//echo $insertID;
		//print_r($iupb_ids);
		

		if($ins){
			

			foreach ($iupb_ids as $key => $value) {
				$data2['iM_modul_log_activity'] = $insertID;
				$data2['iupb_id'] = $value;
				$data2['dCreate'] = date('Y-m-d H:i:s');
				$data2['cCreated'] = $this->logged_nip;
				$ins2 = $this->_ci->db-> insert('plc3.m_modul_log_upb', $data2);	

			}

			$isTrue = 1;
		}
		

		
		return $isTrue;

	}

	function hasTeam($nip){
		$teams = '';
		$sql = "select t.cDeptId
				from plc2.plc2_upb_team t
				where t.ldeleted=0
				and t.vnip='".$nip."'
				and t.iTipe=1

				union 

				select t1.cDeptId 
				from plc2.plc2_upb_team_item ti 
				join plc2.plc2_upb_team t1 on t1.iteam_id=ti.iteam_id
				where ti.ldeleted=0
				and t1.iTipe=1
				and ti.vnip='".$nip."'
				  ";
		
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		if ($jmlRow > 0) {
			$rows = $query->result_array();
			$i=0;
			foreach ($rows as $data ) {
				if($i==0){
					$teams = $data['cDeptId'];
				}else{
					$teams .= ','.$data['cDeptId'];
				}
				$i++;
			}

		}

		return $teams;
	}

	function hasTeamID($nip){
		$teams = '';
		$sql = "select t.iteam_id
				from plc2.plc2_upb_team t
				where t.ldeleted=0
				and t.vnip='".$nip."'
				and t.iTipe=1

				union 

				select t1.iteam_id 
				from plc2.plc2_upb_team_item ti 
				join plc2.plc2_upb_team t1 on t1.iteam_id=ti.iteam_id
				where ti.ldeleted=0
				and t1.iTipe=1
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
					$teams = $data['iteam_id'];
				}else{
					$teams .= ','.$data['iteam_id'];
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
				left join plc2.plc2_upb_team b on b.iteam_id=a.iteampd_id
				left join plc2.plc2_upb_team c on c.iteam_id=a.iteambusdev_id
				left join plc2.plc2_upb_team d on d.iteam_id=a.iteammarketing_id
				left join plc2.plc2_upb_team e on e.iteam_id=a.iteamqa_id 
				left join plc2.plc2_upb_team f on f.iteam_id=a.iteamad_id
				where a.ldeleted=0 
				and a.iupb_id="'.$iupb_id.'"';
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		if ($jmlRow > 0) {
			$rows = $query->row_array();
		}

		return $rows;

	}

	function managerAndChief($iteam_id){
		$nips = '';
		$sql = 'select t.vnip
					from plc2.plc2_upb_team t
					where t.ldeleted=0
					and t.iteam_id="'.$iteam_id.'"
					and t.iTipe=1

					union 

					select t1.vnip
					from plc2.plc2_upb_team_item ti 
					join plc2.plc2_upb_team t1 on t1.iteam_id=ti.iteam_id
					where ti.ldeleted=0
					and ti.iapprove=1
					and t1.iTipe=1
					and t1.iteam_id="'.$iteam_id.'" 
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
				ifnull(a.iteambusdev_id,0) as BD
				, ifnull(a.iteampd_id,0) as PD
				, ifnull(a.iteamqa_id,0) as QA
				, ifnull(a.iteamad_id,0) as AD
				,ifnull(a.iteammarketing_id,0) as MR
				,20 as DR
		from plc2.plc2_upb a 
		where a.ldeleted=0 
		and a.iupb_id= "'.$iupb_id.'"';

		//echo $sql;
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		if ($jmlRow > 0) {
			$rows = $query->row_array();
		}else{
			$rows = array();
		}

		return $rows;

	}

	function getAuthorModul($modul_id){		

		$sql = 'select * 
				from plc3.m_modul a 
				where a.lDeleted=0 
				and a.idprivi_modules="'.$modul_id.'"

				';
		$query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		if ($jmlRow > 0) {
			$rows = $query->row_array();
		}

		return $rows;
	}

	function getIModulID($modul_id){

		$sql = 'select *
				from plc3.m_modul a 
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


	function getHistoryActivity($modul_id,$iKey_id){
	    $sql = '
	            select b.vNama_activity,a.dCreate,c.vName,a.vRemark
	            ,if(a.iApprove=2,"Approve",if(a.iApprove=1,"Reject","-")) as setatus
	            from plc3.m_modul_log_activity a 
	            join plc3.m_activity b on b.iM_activity=a.iM_activity
	            join hrd.employee c on c.cNip=a.cCreated
	            where 
	            a.lDeleted=0
	            and a.idprivi_modules ="'.$modul_id.'"
	            and a.iKey_id ="'.$iKey_id.'"

	    ';   

	    $query = $this->_ci->db->query($sql);
		$jmlRow = $query->num_rows();
		
		$html = '';

		if ($jmlRow > 0) {
			$rows = $query->result_array();
			$i=0;
			foreach ($rows as $data ) {
				$html .='
                    <tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
                        <td style="border: 1px solid #dddddd; width: 30%; text-align: center;">
                            <span class="">'.$data['vNama_activity'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; width: 20%; text-align: center;">
                            <span class="">'.$data['setatus'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; width: 20%; text-align: center;">
                            <span class="">'.$data['dCreate'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; width: 20%; text-align: center;">
                            <span class="">'.$data['vName'].'</span>
                        </td>
                        <td style="border: 1px solid #dddddd; width: 30%; text-align: center;">
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
						->from("plc3.m_modul_fields")
						->join("plc3.m_modul","m_modul.iM_modul=m_modul_fields.iM_modul")
						->join("plc2.sys_masterdok","sys_masterdok.iM_modul_fields=m_modul_fields.iM_modul_fields")
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
			default:
				$iupb_id=$id;
				break;
		}
		return $iupb_id;
	}

	function generateFilename ($filename){
		$exDot = explode('.', $filename);
		$ext = $exDot[count($exDot)-1];
		$generated = str_replace(' ', '_', $filename);
		$generated = str_replace('.'.$ext, '', $generated);
		$generated = preg_replace('/[^A-Za-z0-9\-]/', '_', $generated);
		return $generated.'.'.$ext;
	}

	/*get activity  modul*/
	
}
