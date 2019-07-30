<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dummy_data_upb_kill extends MX_Controller {
    function __construct() {

    parent::__construct();
      $this->db_plc0 = $this->load->database('plc0',false, true);
      $this->load->library('auth');
      $this->dbset = $this->load->database('plc', true);
      $this->user = $this->auth->user();
      $this->url = 'dummy_data_upb_kill'; 
      $this->load->library('excellib/PHPExcel');
      //$this->load->library('excellib/PHPExcel/IOFactory');
      
    }

    function index($action = '') {
      $action = $this->input->get('action') ? $this->input->get('action') : 'create'; 
        //Bikin Object Baru Nama nya $grid    
      $grid = new Grid;
      $grid->setTitle('Kill UPB');
      //dc.m_vendor  database.tabel
      $grid->setTable('plc2.plc2_upb');   
      $grid->setUrl('dummy_data_upb_kill');

      $grid->addFields('vFile','cNip','cDate','explorer');

      //setting widht grid

      $grid->setLabel('vFile','Import File');
      $grid->setLabel('cNip','Dummy By');
      $grid->setLabel('cDate','Dummy at');
      $grid->setFormUpload(TRUE);

    
  //Field mandatori

  //  $grid->setQuery('asset.asset_sparepart.ldeleted', 0);
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
          if (isset($_FILES['vFile'])) {

                  if($_FILES['vFile']['tmp_name']){

                    if(!$_FILES['vFile']['error'])
                    {


                        $inputFile = $_FILES['vFile']['tmp_name'];
                        $extension = strtoupper(pathinfo($inputFile, PATHINFO_EXTENSION));
                        
                        if($extension == 'XLSX' || $extension == 'ODS' || $extension == 'TMP' ){

                          

                            //Read spreadsheeet workbook
                            try {
                                 $inputFileType = PHPExcel_IOFactory::identify($inputFile);
                                 $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                                     $objPHPExcel = $objReader->load($inputFile);
                            } catch(Exception $e) {
                                    die($e->getMessage());
                            }

                            //Get worksheet dimensions
                            $sheet = $objPHPExcel->getSheet(0); 
                            $highestRow = $sheet->getHighestRow(); 
                            $highestColumn = $sheet->getHighestColumn();

                            //Loop through each row of the worksheet in turn
                            for ($row = 1; $row <= $highestRow; $row++){ 
                                    //  Read a row of data into an array
                                    // rowData urutan NO,NO UPB
                                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                                    foreach($rowData as $list) 
                                    { 
                                      $vupb_nomor = $list[1]; // No UPB
                                    }

                                    
                                    $cek_upb='select * 
                                            from plc2.plc2_upb a 
                                            where a.vupb_nomor = "'.$vupb_nomor.'"
                                            ';
                                    $dupb = $this->db_plc0->query($cek_upb)->row_array();

                                    if (!empty($dupb)) {
                                      $cNip = $this->user->gNIP;
                                      $tUpdated = date('Y-m-d H:i:s', mktime());
                                      $SQL = "UPDATE plc2.plc2_upb set vnipKill='{$cNip}', dateKill='{$tUpdated}', iKill='1' where vupb_nomor = '{$vupb_nomor}'";
                                      $this->dbset->query($SQL);  
                                    }

                            }

                        }
                        else{
                            echo "Please upload an XLSX or ODS file";
                        }
                    }
                    else{
                      echo $_FILES['spreadsheet']['error'];
                    }
                 }


            $r['message'] ='Dummy Success';
            $r['status'] = TRUE;
            //$r['last_id'] = 1;
            
            echo json_encode($r);

            

          }else{
            $r['status'] = False;
            //$r['last_id'] = 1;
            $r['message'] = 'Tidak ada File diupload';
            echo json_encode($r);
          } 

        break;
      default:
        $grid->render_form();
        break;
    }
    }

   

/*manipulasi view object form end*/
function insertBox_dummy_data_upb_kill_vFile($field, $id) {
      $return = '<input type="file" name="'.$field.'" id="'.$id.'"  class="input_rows1 required" size="15" />';
      return $return;
}

function insertBox_dummy_data_upb_kill_cNip($field, $id) {
    $return = $this->user->gName;
    return $return;
}

function insertBox_dummy_data_upb_kill_cDate($field, $id) {
    $return =date('Y-m-d H:i:s');
    return $return;
}

function insertBox_dummy_data_upb_kill_explorer($field, $id) {

  $data['root_path'] = '/data/srv/npl-net/npl-net/v3/erp/files/plc/';
  
  $return = $this->load->view('file_explorer/dashboard',$data,true);
  return $return ;

}


function before_insert_processor($row, $postData) {
  $postData['dcreate'] = date('Y-m-d H:i:s');
  $postData['cCreated'] =$this->user->gNIP;
  return $postData;

} 

/*
function manipulate_insert_button($buttons) {

            $btnSave  = "";
            $btnSave .=  "<script type='text/javascript'>
                                            function save_btn_".$this->url."(grid, url, dis) {
                                var req = $('#form_create_'+grid+' input.required, #form_create_'+grid+' select.required, #form_create_'+grid+' textarea.required');
                            var conf=0;
                            var alert_message = '';
                            if(conf > 0) {    
                              showMessage(alert_message);
                            }
                            else {  

                              if ($('#dummy_data_upb_kill_vFile').val()=='') {
                                  alert('Pilih File');
                              }else{

                                custom_confirm(comfirm_message,function(){  
                                  $.ajax({
                                    url: $('#form_create_'+grid).attr('action'),
                                    type: 'post',
                                    data: $('#form_create_'+grid).serialize(),
                                    success: function(data) {
                                      var o = $.parseJSON(data);
                                      var info = 'Error';
                                      var header = 'Error';
                                      var last_id = o.last_id;
                                      var foreign_id = o.foreign_id;
                                      if(o.status == true) {  
                                        info = 'Info';
                                        header = 'Info';
                                        _custom_alert(o.message,header,info, grid, 1, 20000);           
                                        $('#form_create_'+grid)[0].reset();
                                        
                                      }

                                      $('#grid_'+grid).trigger('reloadGrid');
                                      
                                      
                                    }
                                  });
                                })  
                              }                     
                            }   
                          }</script>";
                    
              
                    $btnSave .= "<button type='button'
                                            name='button_save_".$this->url."'
                                            id='button_save_".$this->url."'
                                            class='icon-save ui-button'
                                            onclick='javascript:save_btn_".$this->url."(\"dummy_data_upb_kill\", \"".base_url()."processor/plc/dummy/data/upb/kill?company_id=".$this->input->get('company_id')."&group_id=".$this->input->get('group_id')."&modul_id=".$this->input->get('modul_id')."\", this)'>Save
                                            </button>
                           ";
            $buttons['save'] = $btnSave;
            
  return $buttons;
  
}
*/

  

  



  public function output(){
    $this->index($this->input->get('action'));
  }

}
