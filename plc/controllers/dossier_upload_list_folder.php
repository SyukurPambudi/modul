<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class dossier_upload_list_folder extends MX_Controller {
    function __construct() {
        parent::__construct();
$this->db_plc0 = $this->load->database('plc0',false, true);
		$this->load->library('auth');
    }
    function index($action = '') {
    	
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;
            case 'ceklistfolder':
                $post=$this->input->post();
                $data['path']=$this->input->post('getpath');
                echo $this->load->view("export/table_select_view_list",$data,TRUE);
                break;	
            case 'datalistfolderselect':
                $post=$this->input->post();
                $path=str_replace("_","\\",$post['path']);
                $path=str_replace("--","_",$path);
                echo $this->datalistfolderselect($path);
                break;
            case 'datatablelist':
                $post=$this->input->post();
                $data['id']=$post['id'];
                echo $this->load->view('export/datatable_list_file_select',$data,TRUE);
                break;
            case 'get_datatablelist':
                $post=$this->input->post();
                echo $this->get_datatablelist($post['id']);
                break;
			default:
				$path = realpath("files/plc/dossier_dok");
                $data['listdat']=$this->listFolderFiles($path);
                $data['idossier_dok_list_id']=1;
                $return = $this->load->view('export/treeview_js',$data,true);
                echo  $return;
				break;
		}
    }

    function get_datatablelist($id){
        $sqld="select * from dossier.dossier_dok_list_file fi where fi.lDeleted=0 and fi.idossier_dok_list_id=".$id;
    }

    function datalistfolderselect($dir){
        $data = new StdClass;
        $i=0;
        $rsel=array('pilih','nmfile');
        foreach (new DirectoryIterator($dir) as $fileInfo) {
           if (!$fileInfo->isDot()) {
                if (!$fileInfo->isDir()) {
                    foreach ($rsel as $dsel => $vsel) {
                        switch ($vsel) {
                            case 'pilih':
                                $dataar[$dsel]=$this->getpilihfile($dir,$fileInfo->getFilename());
                                break;
                            default:
                                $dataar[$dsel]=$fileInfo->getFilename();
                                break;
                        }
                    }
                    $data->rows[$i]['cell']=$dataar;
                    $i++;
                }
            } 
        }
        $data->records=$i;
        return json_encode($data);
    }

    function getpilihfile($path,$fileName){
        $o="<input type='checkbox' name='pilih_file_dossier_upload[".$fileName."]' value='".$path."' class='input_select_file' >";
        $o.="<input type='hidden' name='idossier_dok_list_id' class='input_select_file' value=1 />";
        return $o;
    }

    function viewlist(){
        //$return =$this->load->view('export/dossier_upload_ztree_js');
        //$return .=$this->load->view('export/dossier_upload_ztree_css');
        //$return =$this->load->view('export/view_dossier_upload_list_folder');
        $path = realpath("files/plc/dossier_dok");
        $return=$this->listFolderFiles($path);
    	return $return;
    }

    function listFolderFiles($dir,$i=0){
            $o='';
            $o.='<ul id="content_list" class="filetree tree-app treeview">';
            foreach (new DirectoryIterator($dir) as $fileInfo) {
                if (!$fileInfo->isDot()) {
                    if ($fileInfo->isDir()) {
                        $havedir=$this->ceksublist($fileInfo->getPathname());
                        $id=explode("\\",$fileInfo->getPathname());
                        $ilast=implode("_",$id);
                        if($havedir!=0){
                            if($i==0){
                                $o.='<li class="collapsable lastCollapsable"><div class="hitarea collapsable-hitarea lastCollapsable-hitarea"></div><span class="folder" id="'.$ilast.'" style="cursor:pointer;">'.$fileInfo->getFilename().'</span>';
                                $o.='<ul style="display: block;">';
                                $o.=$this->listFolderFiles($fileInfo->getPathname(),1);
                            }else{
                                $o.='<li class="expandable">';
                                $o.='<div class="hitarea expandable-hitarea"></div>
                                    <span class="folder" id="'.$ilast.'" style="cursor:pointer;">'.$fileInfo->getFilename().'</span>
                                    <ul style="display: block;">';
                                 $o.=$this->listFolderFiles($fileInfo->getPathname(),1);
                            }
                            $o.='</ul></li>';
                        }else{
                            $da=str_replace('_','--',$fileInfo->getPathname());
                            $pathlast=str_replace('\\','_',$da);
                            $o.='<li class="last">
                                    <span class="folder" id="'.$ilast.'" style="cursor:pointer;" onclick="show_list_data(\''.$pathlast.'\')">'.$fileInfo->getFilename().'</span>
                                </li>';
                        }
                    }
                     
                }
            }
            $o.='</ul>';
            return $o;
        }

        function ceksublist($dir){
            $i=0;
            foreach (new DirectoryIterator($dir) as $fileInfo) {
                if (!$fileInfo->isDot()) {
                    if ($fileInfo->isDir()) {
                        $i++;
                    }
                } 
            }
            return $i;
        }

	function output(){
    	$this->index($this->input->get('action'));
    }
}
