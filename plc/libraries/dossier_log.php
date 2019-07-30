<?php
class dossier_log { 
	private $_ci;
    private $sess_auth;
    function __construct() {
        $this->_ci=&get_instance();
        $this->_ci->load->library('Zend', 'Zend/Session/Namespace');
        $this->sess_auth = new Zend_Session_Namespace('auth');
    }
    function insertlog($iupd=0,$vkode='',$iproses=0){
    	$nip=$this->sess_auth->gNIP;
    	$date=date('Y-m-d H:m:s');
    	$data['idossier_upd_id']=$iupd;
    	$data['vkode_module']=$vkode;
    	$data['iproses']=$iproses;
    	$data['dCreate']=$date;
    	$data['cCreated']=$nip;
    	$data2['vkode_module']=$vkode;
    	$data2['iproses']=$iproses;
    	$data2['dupdate']=$date;
    	$data2['cUpdate']=$nip;
    	if($iproses=="3"){
    		$sql="select * from dossier.dossier_log lo where lo.idossier_upd_id=".$iupd." 
    		and lo.vkode_module='".$vkode."' and lo.iproses=".$iproses;
    		$s=$this->_ci->db->query($sql);
    		if($s->num_rows()!=0){
    			$this->_ci->db->where('idossier_upd_id',$iupd);
    			$this->_ci->db->where('vkode_module',$vkode);
    			$this->_ci->db->update('dossier.dossier_log',$data2);
    		}else{
    			$this->_ci->db->insert('dossier.dossier_log',$data);
    		}
    	}else{
    			$this->_ci->db->insert('dossier.dossier_log',$data);
    		}
    }
}