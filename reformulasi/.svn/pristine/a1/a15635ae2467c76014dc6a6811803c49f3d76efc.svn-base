<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lib_utilitas {
	private $_ci;
	public $url;
	public $session;
	public $userinfo;
	public $moduleinfo;
	public $tmp;
	public function __construct() {
		$this->_ci=& get_instance();
		$this->_ci->load->library('Zend', 'Zend/Session/Namespace');
        $this->sess_auth = new Zend_Session_Namespace('auth');
	
	}
	public function set_url($url) {
		$this->url = $url;
	}
	function send_email($to, $cc, $subject, $content) {
		$this->_ci->load->helper('email');
		$this->_ci->load->library('email');
		
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = '10.1.48.4';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['wordwrap'] = FALSE;
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		
		$from = "postmaster@novellpharm.com";
		$to=$to;
		$cc = $cc;

		$sql = "select * from plc2.mailsparam a where a.cVariable='reformulasi_app'";
        $smail = $this->_ci->db->query($sql)->row_array();

        //print_r($smail);
		$bcc = $smail['vBcc']; 
		$subject = $subject;
		$content = $content;
		
		
		$this->_ci->email->initialize($config);
		$this->_ci->email->from($from, 'MIS-Reformulasi');
		$this->_ci->email->to($to);
		$this->_ci->email->cc($cc);
		$this->_ci->email->bcc($bcc);
		//if(valid_email($cc))$this->_ci->email->cc($cc);
		$this->_ci->email->subject($subject);
		$this->_ci->email->message($content);
		
		$this->_ci->email->send();
	}
	function setExcelHeader($excel_file_name)//this function used to set the header variable
	{
		header("Content-type: application/octet-stream");//A MIME attachment with the content type "application/octet-stream" is a binary file.
		//Typically, it will be an application or a document that must be opened in an application, such as a spreadsheet or word processor.
		header("Content-Disposition: attachment; filename=$excel_file_name");//with this extension of file name you tell what kind of file it is.
		header("Pragma: no-cache");//Prevent Caching
		header("Expires: 0");//Expires and 0 mean that the browser will not cache the page on your hard drive
	}
	
	function get_email_by_nip($nip='') {
	if($nip=='') return false;
	$this->_ci->load->helper('email');
	$sql = "SELECT * FROM hrd.employee where cNip = '$nip' LIMIT 1";
	$query = $this->_ci->db->query( $sql );
	if($query->num_rows()>0) {
		$row = $query->row_array();
		if(valid_email( $row['vEmail'] )) {
			return $row['vEmail'];
		}
	}
	
	return false;
	}
	

	function get_email_team($team='') {
		if($team=='') return false;
		$this->_ci->load->helper('email');
		
		$sql = "select ti.vnip,e.vEmail 
				from reformulasi.reformulasi_team_item ti 
                left join hrd.employee e on e.cNip=ti.vnip
                where ti.ireformulasi_team in (".$team.") 
                and ti.ldeleted = 0 and ti.vnip not in ('".$this->sess_auth->gNIP."')";
		$query = $this->_ci->db->query( $sql );
		if($query->num_rows()>0) {
			$row = $query->result_array();
			$remail='';
			foreach($row as $roem){
				if(valid_email( trim($roem['vEmail']) )) {
					$remail.=$roem['vEmail'].',';
				}
			}
			//$remail=rtrim($remail , ";");
			return $remail;
		}

		return false;
	}


	function get_email_leader($team='') {
		if($team=='') return false;
		$this->_ci->load->helper('email');
		
		$sql = "select ti.vnip,e.vEmail 
				from reformulasi.reformulasi_team ti 
                left join hrd.employee e on e.cNip=ti.vnip
                where ti.ireformulasi_team in (".$team.") and ti.ldeleted = 0 
                #and ti.vnip not in ('".$this->sess_auth->gNIP."')
                ";
		$query = $this->_ci->db->query( $sql );
		if($query->num_rows()>0) {
			$row = $query->result_array();
			$remail='';
			foreach($row as $roem){
				if(valid_email( trim($roem['vEmail']) )) {
					$remail.=$roem['vEmail'].',';
				}
			}
			//$remail=rtrim($remail , ";");
			return $remail;
		}

		return false;
	} 



	function get_nip_team($team='') {
		if($team=='') return false;
		$this->_ci->load->helper('email');
		
		$sql = "select ti.vnip,e.vEmail,e.cNip 
				from reformulasi.reformulasi_team_item ti 
                left join hrd.employee e on e.cNip=ti.vnip
                where ti.ireformulasi_team in (".$team.") 
                and ti.ldeleted = 0 and ti.vnip not in ('".$this->sess_auth->gNIP."')";
        //echo $sql;
		$query = $this->_ci->db->query( $sql );
		if($query->num_rows()>0) {
			$row = $query->result_array();
			$remail='';
			foreach($row as $roem){
				if(trim($roem['cNip']) <> '') {
					$remail.=$roem['cNip'].',';
				}
			}
			return $remail;
		}

		return false;
	}


	function get_nip_leader($team='') {
		if($team=='') return false;
		$this->_ci->load->helper('email');
		
		$sql = "select ti.vnip,e.vEmail,e.cNip 
				from reformulasi.reformulasi_team ti 
                left join hrd.employee e on e.cNip=ti.vnip
                where ti.ireformulasi_team in (".$team.") and ti.ldeleted = 0 
                #and ti.vnip not in ('".$this->sess_auth->gNIP."')
                ";
		$query = $this->_ci->db->query( $sql );
		if($query->num_rows()>0) {
			$row = $query->result_array();
			$remail='';
			foreach($row as $roem){
				if(trim($roem['cNip']) <> '') {
					$remail.=$roem['cNip'].',';
				}
			}
			return $remail;
		}

		return false;
	} 


}