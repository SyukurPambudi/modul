<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_details_performance_busdev_4 extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
		$this->db_erp_pk = $this->load->database('pk', false,true);
		$this->user = $this->auth->user(); 
    }
    function index($action = '') {
    	$iparameter_id=$this->input->get('iparameter_id');
        $imaster_id=$this->input->get('id');
        switch ($action) {      
            case "view":
                echo $this->renderfunc($imaster_id,$iparameter_id);
                break;
            default:
                echo $this->renderfunc($imaster_id,$iparameter_id);
                break;
        }

    }
    public function renderfunc($imaster_id,$iparameter_id){
        $q="select * from pk.pk_parameter where ldeleted=0 and iparameter_id=$iparameter_id limit 1";
        $st=$this->db_erp_pk->query($q)->row_array();
        if(method_exists($this, $st['vFunction'])){
            $func=$st['vFunction'];
            return $this->$func($imaster_id);
        }else{
            return "NOT FOUND FUNCTION";
        }
    }

	public function output(){
		$this->index($this->input->get('action'));
	}

    private function getDetMaster($imaster_id){
        $tq="select * from pk.pk_master mas where mas.ldeleted=0 and mas.idmaster_id=$imaster_id";
        $qmas=$this->db_erp_pk->query($tq)->row_array();
        return $qmas;
    }

    private function getSemester($date,$now1=FALSE){
        $now=date('Y-m-d',strtotime($date));
        $d = new DateTime($now);
        $m=0;
        $y=0;
        $semester='01'; 
        $d->modify( 'first day of -2 year' );
        $m=$d->format( 'm' );
        $y=$d->format('Y');
        if(intval($m)<=6){
                $semester='01';
        }elseif(intval($m)>=7){
            $semester='02';
        } 
        $data['tanggal']=$d->format( 'm' ).$d->format('Y').'-'.$date;
        $data['semester']=$semester;
        $data['tahun']=$y;
        return $data;
    }

    public function BD1_1($imaster_id){

        $dmas=$this->getDetMaster($imaster_id);
        $tgl2=$dmas['tgl2'];
        $tgl1=$dmas['tgl1'];

        $sql='SELECT u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , m.vNama_Group, u.`vupb_nomor`,u.vupb_nama , ua.`tupdate`, u.vKode_obat FROM plc2.`plc2_upb` u 
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
            JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
            WHERE u.`ldeleted` = 0 
            AND u.tinfo_paten IS NOT NULL
            AND u.tinfo_paten !=""
            AND u.`iteambusdev_id` = 4 
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            AND ua.`tupdate` >= "'.$tgl1.'" 
            AND ua.`tupdate` <= "'.$tgl2.'"';  


        $sql_iGroup_produk='SELECT COUNT(DISTINCT(u.`iGroup_produk`)) as iGroup_produk FROM plc2.`plc2_upb` u 
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
            JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
            WHERE u.`ldeleted` = 0 
            AND u.tinfo_paten IS NOT NULL
            AND u.tinfo_paten !=""
            AND u.`iteambusdev_id` = 4 
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            AND ua.`tupdate` >= "'.$tgl1.'" 
            AND ua.`tupdate` <= "'.$tgl2.'"';  
        $res_iGrp = $this->db_erp_pk->query($sql_iGroup_produk)->row_array();
        $res = $this->db_erp_pk->query($sql)->result_array();
        $data['sql']=$sql; 
        $data['dataall'] = $res;
        $data['datacount'] = $res_iGrp;
        $view=$this->load->view('busdev/detail_perform/details_bd1_1',$data,true);
        return $view;
    }

    public function BD1_2($imaster_id){

        $dmas=$this->getDetMaster($imaster_id);
        $tgl2=$dmas['tgl2'];
        $tgl1=$dmas['tgl1'];

        $sql='SELECT ut.vteam ,u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , ua.`tupdate`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u 
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
            JOIN plc2.plc2_upb_team ut on ut.iteam_id = u.iteammarketing_id
            #JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
            WHERE u.`ldeleted` = 0 
            AND u.tinfo_paten IS NOT NULL
            AND u.tinfo_paten !=""
            AND u.iteammarketing_id IS NOT NULL
            AND u.`iteambusdev_id` = 4 
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            AND ua.`tupdate` >= "'.$tgl1.'" 
            AND ua.`tupdate` <= "'.$tgl2.'"';  


        $sql_iGroup_produk='SELECT COUNT(DISTINCT(u.iteammarketing_id)) as iteammarketing_id FROM plc2.`plc2_upb` u 
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
            JOIN plc2.plc2_upb_team ut on ut.iteam_id = u.iteammarketing_id
            #JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
            WHERE u.`ldeleted` = 0 
            AND u.tinfo_paten IS NOT NULL
            AND u.tinfo_paten !=""
            AND u.iteammarketing_id IS NOT NULL
            AND u.`iteambusdev_id` = 4 
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            AND ua.`tupdate` >= "'.$tgl1.'" 
            AND ua.`tupdate` <= "'.$tgl2.'"';  
        $res_iGrp = $this->db_erp_pk->query($sql_iGroup_produk)->row_array();
        $res = $this->db_erp_pk->query($sql)->result_array();
        $data['sql']=$sql; 
        $data['dataall'] = $res;
        $data['datacount'] = $res_iGrp;
        $view=$this->load->view('busdev/detail_perform/details_bd1_2',$data,true);
        return $view;
    }

    public function BD1_3($imaster_id){

        $dmas=$this->getDetMaster($imaster_id);
        $tgl2=$dmas['tgl2'];
        $tgl1=$dmas['tgl1'];


        $sql='SELECT pb.vkategori , u.`ikategoriupb_id`,  u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , ua.`tupdate`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u 
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`  
            JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
            #JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
            WHERE u.`ldeleted` = 0 
            AND u.tinfo_paten IS NOT NULL
            AND u.tinfo_paten !=""
            AND u.`iteambusdev_id` = 4 
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            AND ua.`tupdate` >= "'.$tgl1.'" 
            AND ua.`tupdate` <= "'.$tgl2.'" 
            '; 

        $sql_iGroup_produk='SELECT COUNT(u.`iupb_id`) As t_upb2 FROM plc2.`plc2_upb` u 
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
            JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
            #JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
            WHERE u.`ldeleted` = 0 
            AND u.tinfo_paten IS NOT NULL
            AND u.tinfo_paten !=""
            AND u.`iteambusdev_id` = 4 
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            AND ua.`tupdate` >= "'.$tgl1.'"
            AND ua.`tupdate` <= "'.$tgl2.'"
            ';

        $res_iGrp = $this->db_erp_pk->query($sql_iGroup_produk)->row_array();
        $res = $this->db_erp_pk->query($sql)->result_array();
        $data['sql']=$sql; 
        $data['dataall'] = $res;
        $data['datacount'] = $res_iGrp;
        $view=$this->load->view('busdev/detail_perform/details_bd1_3',$data,true);
        return $view;
    }

    public function BD1_4($imaster_id){

        $dmas=$this->getDetMaster($imaster_id);
        $tgl2=$dmas['tgl2'];
        $tgl1=$dmas['tgl1'];


        $sql='SELECT u.`tsubmit_prareg` , ( 
                        SELECT b.`tappbusdev`
                        FROM plc2.plc2_upb_prioritas b 
                        JOIN plc2.plc2_upb_prioritas_detail c ON c.iprioritas_id=b.iprioritas_id
                        WHERE 
                        b.ldeleted=0
                        AND c.ldeleted=0
                        AND c.iupb_id=u.iupb_id
                        AND tappbusdev IS NOT NULL
                        ORDER BY b.iprioritas_id DESC LIMIT 1 
                    ) AS tappbusdev , u.`iupb_id`, u.`iGroup_produk`,
                     u.`vupb_nomor`,u.vupb_nama ,  u.vKode_obat, u.tinfo_paten

                    FROM plc2.`plc2_upb` u   
                    WHERE u.`ldeleted` = 0 
                    AND u.`iupb_id` IN (
                        SELECT cb.`iupb_id`
                        FROM plc2.plc2_upb_prioritas bb 
                        JOIN plc2.plc2_upb_prioritas_detail cb ON cb.iprioritas_id=bb.iprioritas_id
                        WHERE 
                        bb.ldeleted=0
                        AND cb.ldeleted=0 
                        AND tappbusdev IS NOT NULL 
                        )
                    AND u.`tsubmit_prareg` IS NOT NULL
                    AND u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 4 
                    AND u.`tsubmit_prareg` >= "'.$tgl1.'" 
                    AND u.`tsubmit_prareg` <= "'.$tgl2.'"  
            ';  
 
        $res = $this->db_erp_pk->query($sql)->result_array();
        $data['sql']=$sql; 
        $data['dataall'] = $res; 
        $view=$this->load->view('busdev/detail_perform/details_bd1_4',$data,true);
        return $view;
    }


    public function BD1_5($imaster_id){

        $dmas=$this->getDetMaster($imaster_id);
        $tgl2=$dmas['tgl2'];
        $tgl1=$dmas['tgl1'];


        $sql = 'SELECT pb.vkategori , u.`ikategoriupb_id`, u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , u.`tsubmit_prareg`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u 
                    JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id` 
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    WHERE u.`ldeleted` = 0  
                    AND u.`iteambusdev_id` = 4 
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2 
                    AND u.`ikategoriupb_id` = 10 
                    AND u.tsubmit_prareg IS NOT NULL
                    AND u.`tsubmit_prareg` >= "'.$tgl1.'" 
                    AND u.`tsubmit_prareg` <= "'.$tgl2.'" ';

  
        $res = $this->db_erp_pk->query($sql)->result_array();
        $data['sql']=$sql; 
        $data['dataall'] = $res; 
        $view=$this->load->view('busdev/detail_perform/details_bd1_5',$data,true);
        return $view;
    }


    public function BD1_6($imaster_id){

        $dmas=$this->getDetMaster($imaster_id);
        $tgl2=$dmas['tgl2'];
        $tgl1=$dmas['tgl1'];


        $sql='SELECT ut.vteam, u.`ikategoriupb_id`, u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , u.`tsubmit_prareg`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u  
            JOIN plc2.plc2_upb_team ut on ut.iteam_id = u.iteammarketing_id
            WHERE u.`ldeleted` = 0  
            AND u.`iteambusdev_id` = 4 
            AND u.iteammarketing_id IS NOT NULL
            AND u.tsubmit_prareg IS NOT NULL
            AND u.`tsubmit_prareg` >= "'.$tgl1.'" 
            AND u.`tsubmit_prareg` <= "'.$tgl2.'" '; 

        //Menghitung Jumalah Divisi Marketing (B)
        $sql_iGroup_produk='SELECT COUNT(DISTINCT(u.iteammarketing_id)) As t_Mark FROM plc2.`plc2_upb` u  
            JOIN plc2.plc2_upb_team ut on ut.iteam_id = u.iteammarketing_id
            WHERE u.`ldeleted` = 0   
            AND u.`iteambusdev_id` = 4 
            AND u.iteammarketing_id IS NOT NULL
            AND u.tsubmit_prareg IS NOT NULL
            AND u.`tsubmit_prareg` >= "'.$tgl1.'" 
            AND u.`tsubmit_prareg` <= "'.$tgl2.'" '; 
 

        $res_iGrp = $this->db_erp_pk->query($sql_iGroup_produk)->row_array();
        $res = $this->db_erp_pk->query($sql)->result_array();
        $data['sql']=$sql; 
        $data['dataall'] = $res;
        $data['datacount'] = $res_iGrp;
        $view=$this->load->view('busdev/detail_perform/details_bd1_6',$data,true);
        return $view;
    }

    public function BD1_7($imaster_id){

        $dmas=$this->getDetMaster($imaster_id);
        $tgl2=$dmas['tgl2'];
        $tgl1=$dmas['tgl1']; 

        //Menghitung BE
        $sqlp1='SELECT pb.vkategori ,pu.`ibe`, pu.`tsubmit_prareg`,pu.`ttarget_hpr` ,pu.`iupb_id`
                ,pu.`iGroup_produk`,
                     pu.`vupb_nomor`,pu.vupb_nama ,  pu.vKode_obat
                FROM plc2.`plc2_upb` pu 
                JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = pu.`ikategoriupb_id`
                WHERE 
                pu.`ldeleted` = 0
                AND pu.`ibe` = 1
                AND pu.`tsubmit_prareg` IS NOT NULL
                AND pu.`ttarget_hpr` IS NOT NULL
                AND pu.`ikategoriupb_id` = 10
                AND pu.`iteambusdev_id` = 4
                AND pu.`ttarget_hpr` >= "'.$tgl1.'" 
                AND pu.`ttarget_hpr` <= "'.$tgl2.'" ';  

        $sqlp2='SELECT pb.vkategori, pu.`ibe`, pu.`tsubmit_prareg`,pu.`tregistrasi` ,pu.`iupb_id`
                ,pu.`iGroup_produk`,
                     pu.`vupb_nomor`,pu.vupb_nama ,  pu.vKode_obat
                FROM plc2.`plc2_upb` pu  
                JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = pu.`ikategoriupb_id`
                WHERE 
                pu.`ldeleted` = 0
                AND pu.`ibe` = 2
                AND pu.`tsubmit_prareg` IS NOT NULL
                AND pu.`tregistrasi` IS NOT NULL
                AND pu.`ikategoriupb_id` = 10
                AND pu.`iteambusdev_id` = 4
                AND pu.`tregistrasi` >= "'.$tgl1.'" 
                AND pu.`tregistrasi` <= "'.$tgl2.'" '; 
 

        $res2 = $this->db_erp_pk->query($sqlp2)->result_array();
        $res1 = $this->db_erp_pk->query($sqlp1)->result_array(); 
        $data['dataall'] = $res1;
        $data['dataall2'] = $res2;
        $view=$this->load->view('busdev/detail_perform/details_bd1_7',$data,true);
        return $view;
    }

    public function BD1_8($imaster_id){

        $dmas=$this->getDetMaster($imaster_id);
        $tgl2=$dmas['tgl2'];
        $tgl1=$dmas['tgl1'];


        $sql = 'SELECT m.vNama_Group ,u.iGroup_produk, pb.vkategori , u.dinput_applet, u.`ikategoriupb_id`, u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , u.`tsubmit_prareg`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u 
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 4 
                    AND u.dinput_applet IS NOT NULL 
                    AND u.`dinput_applet` >= "'.$tgl1.'" 
                    AND u.`dinput_applet` <= "'.$tgl2.'" 
                    AND u.`ikategoriupb_id` = 10 
                    '; 

         $sql_t = 'SELECT COUNT(DISTINCT(u.`iGroup_produk`)) AS t_upb FROM plc2.`plc2_upb` u 
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 4 
                    AND u.dinput_applet IS NOT NULL 
                    AND u.`dinput_applet` >= "'.$tgl1.'" 
                    AND u.`dinput_applet` <= "'.$tgl2.'" 
                    AND u.`ikategoriupb_id` = 10 
                    ';

        $gr = $this->db_erp_pk->query($sql_t)->row_array();
        $data['t_pr'] = $gr['t_upb'];
  
        $res = $this->db_erp_pk->query($sql)->result_array();
        $data['sql']=$sql; 
        $data['dataall'] = $res; 
        $view=$this->load->view('busdev/detail_perform/details_bd1_8',$data,true);
        return $view;
    }

    public function BD1_9($imaster_id){

        $dmas=$this->getDetMaster($imaster_id);
        $tgl2=$dmas['tgl2'];
        $tgl1=$dmas['tgl1'];


        $sql = 'SELECT m.vNama_Group, pb.vkategori , u.dinput_applet, u.`ikategoriupb_id`, u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , u.`tsubmit_prareg`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u 
        JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
        JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 4 
                    AND u.dinput_applet IS NOT NULL 
                    AND u.`dinput_applet` >= "'.$tgl1.'" 
                    AND u.`dinput_applet` <= "'.$tgl2.'" 
                    AND u.`ikategoriupb_id` = 11 
                    '; 

        $sql_t = 'SELECT COUNT(DISTINCT(u.`iGroup_produk`)) AS t_upb FROM plc2.`plc2_upb` u 
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 4 
                    AND u.dinput_applet IS NOT NULL 
                    AND u.`dinput_applet` >= "'.$tgl1.'" 
                    AND u.`dinput_applet` <= "'.$tgl2.'" 
                    AND u.`ikategoriupb_id` = 11 
                    ';

        $gr = $this->db_erp_pk->query($sql_t)->row_array();
        $data['t_pr'] = $gr['t_upb'];
  
        $res = $this->db_erp_pk->query($sql)->result_array();
        $data['sql']=$sql; 
        $data['dataall'] = $res; 
        $view=$this->load->view('busdev/detail_perform/details_bd1_9',$data,true);
        return $view;
    }

    public function BD1_10($imaster_id){

        $dmas=$this->getDetMaster($imaster_id);
        $tgl2=$dmas['tgl2'];
        $tgl1=$dmas['tgl1'];


        $sql = ' SELECT pb.vkategori ,u.`iupb_id` , u.`dinput_applet` , u.`tregistrasi`, u.ikategoriupb_id, u.`vupb_nomor`,u.vupb_nama ,  u.vKode_obat FROM plc2.`plc2_upb` u 
             JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 4 
                    AND u.dinput_applet IS NOT NULL 
                    AND u.tregistrasi IS NOT NULL  
                    AND u.`ikategoriupb_id` = 10 
                    AND u.`dinput_applet` >= "'.$tgl1.'" 
                    AND u.`dinput_applet` <= "'.$tgl2.'" '; 
 
        $res = $this->db_erp_pk->query($sql)->result_array();
        $data['sql']=$sql; 
        $data['dataall'] = $res; 
        $view=$this->load->view('busdev/detail_perform/details_bd1_10',$data,true);
        return $view;
    }

    public function BD1_11($imaster_id){

        $dmas=$this->getDetMaster($imaster_id);
        $tgl2=$dmas['tgl2'];
        $tgl1=$dmas['tgl1']; 

        $sql = 'SELECT pb.vkategori , u.`iupb_id` ,u.`vupb_nomor`,u.vupb_nama ,  u.vKode_obat, u.`dinput_applet` , u.`tregistrasi`, 
                    u.ikategoriupb_id, 

                    (SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                    AND ad.`iupb_id`  = u.`iupb_id`
                    AND ad.`dsubmit_dok` IS NOT NULL
                    ORDER BY ad.`dsubmit_dok` DESC LIMIT 1)  AS dsubmit_dok

                    FROM plc2.`plc2_upb` u  
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    WHERE u.`ldeleted` = 0 
                    AND u.`iupb_id` IN (SELECT ad.`iupb_id` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0  
                    AND ad.`dsubmit_dok` IS NOT NULL )

                    AND u.`iteambusdev_id` = 4 
                    AND u.dinput_applet IS NOT NULL 
                    AND u.tregistrasi IS NOT NULL AND u.`ikategoriupb_id` = 11 
                    AND u.`dinput_applet` >= "'.$tgl1.'" 
                    AND u.`dinput_applet` <= "'.$tgl2.'" '; 
 
        $res = $this->db_erp_pk->query($sql)->result_array();
        $data['sql']=$sql; 
        $data['dataall'] = $res; 
        $view=$this->load->view('busdev/detail_perform/details_bd1_11',$data,true);
        return $view;
    }
     public function BD1_13($imaster_id){

        $dmas=$this->getDetMaster($imaster_id);
        $tgl2=$dmas['tgl2'];
        $tgl1=$dmas['tgl1'];
        $nippemohon = $dmas['vnip'];

        $sql = 'SELECT cc.`dCreate`, inb.vMessages, cc.vpejabat, cc.thasil, mt.vtarget_kunjungan FROM kartu_call.`call_card` cc 
                    JOIN kartu_call.master_target_kunjungan mt on mt.itarget_kunjungan_id = cc.itarget_kunjungan_id
                    JOIN gps_msg.inbox inb on inb.id = cc.igpsm_id
                    WHERE cc.`lDeleted` = 0 
                    AND cc.`itarget_kunjungan_id` = 5   
                    AND cc.`vNIP` LIKE "%'.$nippemohon.'%"
                    AND cc.`dCreate` >= "'.$tgl1.'" 
                    AND cc.`dCreate` <= "'.$tgl2.'"  
                    '; 
  
        $res = $this->db_erp_pk->query($sql)->result_array();
        $data['sql']=$sql; 
        $data['dataall'] = $res; 

        $timeEnd = strtotime($tgl2);
        $timeStart = strtotime($tgl1);
        $time =  (date("m",$timeEnd)-date("m",$timeStart))+1;   
        $data['selisih'] = $time; 
        $data['t1'] =  $tgl1;
        $data['t2'] =  $tgl2;


        $view=$this->load->view('busdev/detail_perform/details_bd1_13',$data,true);
        return $view;
    }
}

