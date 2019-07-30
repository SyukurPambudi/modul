<?php
class Biz_process {
 	protected $_ci;
	function __construct() {
        $this->_ci=&get_instance();
    }
	function get($act, $div, $modul = '') {
		//$url = $url == '' ? $this->_ci->uri->segment(1) : $url;
		$sql = "SELECT * FROM plc2.plc2_biz_process_sub s WHERE s.vModule = '".$modul."' AND s.idplc2_activity = '".$act."' AND s.iteam_id IN (".$div.")";
		//return $sql;
		return $this->_ci->db->query($sql)->row_array();
			
	}
	public function cek_last_status($upb_id,$bizup,$status) {
		//cek sudahada last status tsb?
		$sql="select * from plc2.plc2_upb_status_last where idplc2_upb='".$upb_id."' and idplc2_biz_process_sub='".$bizup."' and idplc2_status='".$status."'";
		return $this->_ci->db->query($sql)->num_rows();		 
	}
	public function get_last_status($upb_id) {
		//get status yg dihubungkan dgn tabel plc2_status
		$this->_ci->db->where('idplc2_upb', $upb_id);
		$this->_ci->db->order_by('tUpdatedAt', 'desc');		
		return $this->_ci->db->get('plc2.plc2_upb_status_last',1)->row_array();		 
	}
	public function get_next_process($upb_id) {
		$s = $this->get_last_status($upb_id); // ambil status terakhir
		$this->_ci->db->select('iAffectedProcess');
		$this->_ci->db->where(array('idplc2_biz_process_sub'=> $s['idplc2_biz_process_sub'], 'idplc2_status'=>$s['idplc2_status']));
		$a = $this->_ci->db->get('plc2.plc2_effect_action')->row_array();
		if(isset($a['iAffectedProcess'])){return $a['iAffectedProcess'];}else{ return '0';}
		
		/*$a = $this->_ci->db->get('effect_action')->result_array();
		$return = '';
		$i=1;
		foreach($a as $k) {
			if($i == 1) {
				$return .= $k['iAffectedProcess'];
			}
			else {
				$return .= ','.$k['iAffectedProcess'];
			}			
		}
		return $return;*/
	}
	public function insert_log($upbid, $biz_sub, $status, $note = '', $approve = 0) {
		$user = $this->_ci->auth->user();
		$data['idplc2_upb'] = $upbid;
		$data['idplc2_biz_process_sub'] = $biz_sub;
		$data['idplc2_status'] = $status;
		$data['cNip'] = $user->gNIP;
		$data['vNote'] = $note;
		$data['isApproved'] = $approve;
		$data['t1stCreatedAt'] = date('Y-m-d H:i:s');
		$data['c1stCreatedBy'] = $user->gNIP;
		return $this->_ci->db->insert('plc2.plc2_upb_status_log', $data);
	}
	public function insert_last_log($upbid, $biz_sub, $status, $note = '', $approve = 0) {
		$user = $this->_ci->auth->user();
		$this->_ci->db->where('idplc2_upb', $upbid);
		$this->_ci->db->where('idplc2_biz_process_sub', $biz_sub);
		$this->_ci->db->from('plc2.plc2_upb_status_last');
		$c = $this->_ci->db->count_all_results();
		if($c > 0) {
		//jika sudah ada status last upb dgn sub biz proses tsb 
			$u['idplc2_biz_process_sub'] = $biz_sub;
			$u['idplc2_status'] = $status;
			$u['tUpdatedAt'] = date('Y-m-d H:i:s');
			$u['cUpdatedBy'] = $user->gNIP;
			$this->_ci->db->where('idplc2_upb', $upbid);
			$this->_ci->db->where('idplc2_biz_process_sub', $biz_sub);
			$this->_ci->db->update('plc2.plc2_upb_status_last', $u);
			
			if($this->get_next_process($upbid) > 0) {
				$this->_ci->db->where('idplc2_upb', $upbid);
				$this->_ci->db->where('idplc2_biz_process_sub', $this->get_next_process($upbid));
				$this->_ci->db->from('plc2.plc2_upb_status_last');
				$c2 = $this->_ci->db->count_all_results();
				if($c2 == 0) {
					$data['idplc2_upb'] = $upbid;
					$data['idplc2_biz_process_sub'] = $this->get_next_process($upbid);
					$data['idplc2_status'] = 0;
					$data['cNip'] = $user->gNIP;
					$data['vNote'] = '';
					//$data['isApproved'] = 0;
					$data['t1stCreatedAt'] = date('Y-m-d H:i:s');
					$data['c1stCreatedBy'] = $user->gNIP;
					return $this->_ci->db->insert('plc2.plc2_upb_status_last', $data);
				}
				else {
					$this->_ci->db->where(array('idplc2_upb'=>$upbid,'idplc2_biz_process_sub'=>$this->get_next_process($upbid)));
					$datau['tUpdatedAt'] = date('Y-m-d H:i:s');
					$datau['cUpdatedBy'] = $user->gNIP;
					return $this->_ci->db->update('plc2.plc2_upb_status_last', $datau);
				}
			}
		}
		else {
			$data['idplc2_upb'] = $upbid;
			$data['idplc2_biz_process_sub'] = $biz_sub;
			$data['idplc2_status'] = $status;
			$data['cNip'] = $user->gNIP;
			$data['vNote'] = $note;
			//$data['isApproved'] = $approve;
			$data['t1stCreatedAt'] = date('Y-m-d H:i:s');
			$data['c1stCreatedBy'] = $user->gNIP;
			return $this->_ci->db->insert('plc2.plc2_upb_status_last', $data);
		}
	}
	
	//untuk finish good, soi finish good & mikro biologi
	public function update_last_log($upbid, $biz_sub, $status, $note = '', $approve = 0) {
		$user = $this->_ci->auth->user();
		$u['tUpdatedAt'] = date('Y-m-d H:i:s');
		$u['cUpdatedBy'] = $user->gNIP;
		$this->_ci->db->where('idplc2_upb', $upbid);
		$this->_ci->db->where('idplc2_biz_process_sub', $biz_sub);
		$this->_ci->db->update('plc2.plc2_upb_status_last', $u);
	}
}
