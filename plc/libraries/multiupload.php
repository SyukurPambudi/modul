<?php
class Multiupload {
 	protected $_ci;
	function __construct() {
        $this->_ci=&get_instance();
		$this->dbset = $this->_ci->load->database('plc', true); 
    }
	public function insert_upload($path, $kolom1,$kolom2, $database, $id, $field1, $field2,$arr,$lastid) {
				$user = $this->_ci->auth->user();
					
				$sql = array();
   					//$path = realpath("files/plc/spek_fg/");
   					echo $path."/".$lastid;
					if (!mkdir($path."/".$lastid, 0777, true)) {
					    die('Failed upload, try again!');
					}
					$file_keterangan = array();
					foreach($_POST as $key=>$value) {						
						if ($key == $kolom2) {
							foreach($value as $k=>$v) {
								$file_keterangan[$k] = $v;
							}
						}
					}
					
					$i = 0;
					foreach ($_FILES[$kolom1]["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {				
							$tmp_name = $_FILES[$kolom1]["tmp_name"][$key];
							$name = $_FILES[$kolom1]["name"][$key];
							$data['filename'] = $name;
							$data['id']=$this->input->get('lastId');
							//$data['iupb_id'] = $insertId;
							//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
							$data['dInsertDate'] = date('Y-m-d H:i:s');
							if(move_uploaded_file($tmp_name, $path."/".$this->input->get('lastId')."/".$name)) {	
								$sql[] = "INSERT INTO ".$database." (".$id.", ".$field1.", dInsertDate, ".$field2.", cInsert) 
										VALUES ('".$data['id']."', '".$data['filename']."','".$data['dInsertDate']."','".$file_keterangan[$i]."','".$this->user->gNIP."')";
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
					
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');					
					echo json_encode($r);
	}

	public function update_upload($path, $kolom1,$kolom2, $database, $id, $field1, $field2) {
				$isUpload = $this->input->get('isUpload');
				$sql = array();
   				if($isUpload) {
					//$path = realpath("files/plc/spek_fg/");
					if (!mkdir($path."/".$this->input->get('lastId'), 0777, true)) {
					    die('Failed upload, try again!');
					}
						//print_r($_POST);
					$file_keterangan = array();
					$file_tanggal = array();
					foreach($_POST as $key=>$value) {						
						if ($key == $kolom2) {
							foreach($value as $k=>$v) {
								$file_keterangan[$k] = $v;
							}
						}				
					}
					$i = 0;		
					
					foreach ($_FILES[$kolom1]["error"] as $key => $error) {	
						if ($error == UPLOAD_ERR_OK) {
							$tmp_name = $_FILES[$kolom1]["tmp_name"][$key];
							$name = $_FILES[$kolom1]["name"][$key];
							$data['filename'] = $name;
							$data['id']=$this->input->get('lastId');
							//$data['iupb_id'] = $insertId;
							$data['dUpdateDate'] = date('Y-m-d H:i:s');
			 				//$file_tanggal[$i] = date('l, F jS, Y', strtotime($file_tanggal[$i]));		
			 				if(move_uploaded_file($tmp_name, $path."/".$this->input->get('lastId')."/".$name)) 
			 				{
								$sql[] = "UPDATE ".$database." 
										  set ".$field1." = '".$data['filename']."', dUpdateDate = '".$data['dUpdateDate']."', ".$field2." = '".$file_keterangan[$i]."', cUpdated = '".$this->user->gNIP."' 
								 		  where ".$id."='".$data['id']."'";
										
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
					
					$r['status'] = TRUE;
					$r['last_id'] = $this->input->get('lastId');					
					echo json_encode($r);
					exit();
				}  else {
				echo $grid->updated_form();
				}
				break;
	}
}
