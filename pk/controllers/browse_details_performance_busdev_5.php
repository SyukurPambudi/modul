<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class browse_details_performance_busdev_5 extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->db_erp_pk = $this->load->database('pk', false,true);
        $this->user = $this->auth->user(); 
        $this->load->library('calc_bd3');
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

    public function BD3_1($imaster_id){
        $dm=$this->getmasterdata($imaster_id);
        $itim=$this->itim($dm['vnip']);
        $sql_par = 'select 
                #group distinct karena hanya mengambil jumlah group produk 
                #count(distinct(a.iGroup_produk)) jum 
                app.tupdate,a.*,d.vNama_Group,a.tinfo_paten,kat.vkategori 
                from plc2.plc2_upb a 
                join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
                join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
                join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk 
                join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategori_id
                #Filter Deleted 
                where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0 
                #upb team nya 
                and a.iteambusdev_id="'.$itim.'"   
                #Kategori Produk Non Alkes dan Not NUll
                and a.ikategori_id!=15 and a.ikategori_id is not null
                #Informasi Hak Patent Not NUll
                and a.tinfo_paten is not NULL
                #approval direksi
                and a.iappdireksi = 2 and app.tupdate is not null 
                #periode tanggal prareg 
                and app.tupdate >= "'.$dm['tgl1'].'" 
                and app.tupdate <= "'.$dm['tgl2'].'" 
                group by a.iupb_id   
                ';
        $data['rcount']=$this->db->query($sql_par)->num_rows();
        $data['dataall']=$this->db->query($sql_par)->result_array();
        $view=$this->load->view('busdev/detail_perform/busdev_3/details_bd3_1',$data,true);
        return $view;
    } 

    public function BD3_2($imaster_id){
        $dm=$this->getmasterdata($imaster_id);
        $itim=$this->itim($dm['vnip']);
        $sdisct ='select 
                #group distinct karena hanya mengambil jumlah group produk 
                distinct(a.iteammarketing_id) jum ';
        $sdat='select app.tupdate,a.*,te.vteam,d.vNama_Group,a.iteammarketing_id';
        $sql_par = ' from plc2.plc2_upb a 
                join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
                join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
                join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk
                join plc2.plc2_upb_team te on a.iteammarketing_id=te.iteam_id
                #Filter Deleted 
                where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0 
                #upb team nya 
                and a.iteambusdev_id="'.$itim.'"
                #approval direksi
                and a.iappdireksi = 2 and app.tupdate is not null 
                #periode tanggal prareg 
                and app.tupdate >= "'.$dm['tgl1'].'" 
                and app.tupdate <= "'.$dm['tgl2'].'" 
                group by a.iupb_id 
                ';
        //$data['rcount']=$this->db->query($sdat.$sql_par)->num_rows();
        $data['dataall']=$this->db->query($sdat.$sql_par)->result_array();
        //$data['jumdisc']=$this->db->query($sdisct.$sql_par)->result_array();
        $view=$this->load->view('busdev/detail_perform/busdev_3/details_bd3_2',$data,true);
        return $view;
    }

    public function BD3_3($imaster_id){
        $dm=$this->getmasterdata($imaster_id);
        $itim=$this->itim($dm['vnip']);
        $sql_par = 'select 
                    a.*,s.dTanggalTerimaBD,t.dApp_dir,s.iJenis_panel
                    from plc2.plc2_upb a 
                    join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
                    join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
                    join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk 
                    join plc2.otc_sample_panel s on s.iupb_id = a.iupb_id 
                    join plc2.otc_panel_test t on t.isample_panel_id=s.isample_panel_id 
                    #Filter Deleted 
                    where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0 and s.lDeleted=0 and t.lDeleted=0
                    #upb team nya 
                    and a.iteambusdev_id="'.$itim.'" 
                    #Tanggal app dir not null 
                    and a.iappdireksi = 2 and app.tupdate is not null 
                    #tanggal approve req panel not null
                    and t.dApp_dir is not null
                    #tanggal terima sample
                    and s.dTanggalTerimaBD is not null
                    #periode tanggal prareg 
                    and t.dApp_dir >= "'.$dm['tgl1'].'"  
                    and t.dApp_dir <= "'.$dm['tgl2'].'" 
                    group by s.isample_panel_id  
                ';
        $data['rcount']=$this->db->query($sql_par)->num_rows();
        $data['dataall']=$this->db->query($sql_par)->result_array();
        $data['controller']=$this;
        $view=$this->load->view('busdev/detail_perform/busdev_3/details_bd3_3',$data,true);
        return $view;
    } 

    public function BD3_5($imaster_id){
        $dm=$this->getmasterdata($imaster_id);
        $itim=$this->itim($dm['vnip']);
        $sql_par = 'select 
                    #group distinct karena hanya mengambil jumlah group produk 
                    #count(distinct(a.iGroup_produk)) jum 
                    a.tsubmit_prareg,a.*,d.vNama_Group 
                    from plc2.plc2_upb a 
                    join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
                    join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
                    join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk 
                    #Filter Deleted 
                    where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0 
                    #upb team nya 
                    and a.iteambusdev_id="'.$itim.'"  
                    #Tanggal Prared Not NULl 
                    and a.tsubmit_prareg is not null 
                    #Tanggal app dir not null 
                    and a.iappdireksi = 2 and app.tupdate is not null 
                    #periode tanggal prareg 
                    and a.tsubmit_prareg >= "'.$dm['tgl1'].'" 
                    and a.tsubmit_prareg <= "'.$dm['tgl2'].'"  
                ';
        $data['rcount']=$this->db->query($sql_par)->num_rows();
        $data['dataall']=$this->db->query($sql_par)->result_array();
        $view=$this->load->view('busdev/detail_perform/busdev_3/details_bd3_5',$data,true);
        return $view;
    }
    public function BD3_6($imaster_id){
        $dm=$this->getmasterdata($imaster_id);
        $itim=$this->itim($dm['vnip']);
        $sql_par = 'select a.*,a.tsubmit_prareg,a.ttanggal 
                from plc2.plc2_upb a join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
                join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
                join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id 
                #Filter Deleted 
                where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0 
                #upb team nya 
                and a.iteambusdev_id="'.$itim.'" 
                #Tanggal Prareg not null 
                and a.tsubmit_prareg is not null 
                #Tanggal Submit UPB not NUll 
                and a.ttanggal is not null 
                #Tanggal app dir not null 
                and a.iappdireksi = 2 and app.tupdate is not null 
                #periode tanggal prareg 
                and a.tsubmit_prareg >= "'.$dm['tgl1'].'" 
                and a.tsubmit_prareg <= "'.$dm['tgl2'].'" 
                group by a.iupb_id  
                ';
        $data['rcount']=$this->db->query($sql_par)->num_rows();
        $data['dataall']=$this->db->query($sql_par)->result_array();
        $data['controller']=$this;
        $view=$this->load->view('busdev/detail_perform/busdev_3/details_bd3_6',$data,true);
        return $view;
    }

    public function BD3_7($imaster_id){
        $dm=$this->getmasterdata($imaster_id);
        $itim=$this->itim($dm['vnip']);
        $sql_par_obat = 'select
                    a.iupb_id,a.vupb_nomor,a.vupb_nama,a.vKode_obat, a.iGroup_produk, a.dinput_applet, a.ttarget_noreg,d.vNama_Group, kat.vkategori
                    from plc2.plc2_upb a 
                    join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
                    join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
                    join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk 
                    join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategori_id
                    #Filter Deleted 
                    where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0 
                    #upb team nya 
                    and a.iteambusdev_id="'.$itim.'" 
                    #Tanggal Applet Not NULl 
                    #and a.dinput_applet is not null 
                    #Kategori Obat
                    AND a.ikategori_id in (1,2,5,10,11,12)
                    #Tanggal app dir not null 
                    and a.iappdireksi = 2 and app.tupdate is not null 
                    #periode tanggal prareg 
                    and a.dinput_applet >= "'.$dm['tgl1'].'" 
                    and a.dinput_applet <= "'.$dm['tgl2'].'"
                    group by a.iupb_id  
                ';
        $data['rcount_obat']=$this->db->query($sql_par_obat)->num_rows();
        $data['dataall_obat']=$this->db->query($sql_par_obat)->result_array();
        $sql_par_non = 'select
                    a.iupb_id,a.vupb_nomor,a.vupb_nama,a.vKode_obat, a.iGroup_produk, a.dinput_applet, a.ttarget_noreg,d.vNama_Group, kat.vkategori
                    from plc2.plc2_upb a 
                    join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
                    join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
                    join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk 
                    join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategori_id
                    #Filter Deleted 
                    where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0 
                    #upb team nya 
                    and a.iteambusdev_id="'.$itim.'" 
                    #Tanggal NIE Not NULl 
                    and a.ttarget_noreg is not null 
                    #Kategori Obat
                    AND a.ikategori_id in (3,4,6,7,8,9,13)
                    #Tanggal app dir not null 
                    and a.iappdireksi = 2 and app.tupdate is not null 
                    #periode tanggal prareg 
                    and a.ttarget_noreg >= "'.$dm['tgl1'].'" 
                    and a.ttarget_noreg <= "'.$dm['tgl2'].'"
                    group by a.iupb_id  
                ';
        $data['rcount_non']=$this->db->query($sql_par_non)->num_rows();
        $data['dataall_non']=$this->db->query($sql_par_non)->result_array();
        $sql_par_disc = 'select distinct(z.iGroup_produk) as jum
                    from (
                    #untuk Produk Kategori Obat
                    select
                    a.iupb_id,a.vupb_nomor,a.vupb_nama,a.vKode_obat, a.iGroup_produk, a.dinput_applet, a.ttarget_noreg, kat.vkategori
                    from plc2.plc2_upb a 
                    join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
                    join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
                    join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk 
                    join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategori_id
                    #Filter Deleted 
                    where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0 
                    #upb team nya 
                    and a.iteambusdev_id="'.$itim.'" 
                    #Tanggal Applet Not NULl 
                    #and a.dinput_applet is not null 
                    #Kategori Obat
                    AND a.ikategori_id in (1,2,5,10,11,12)
                    #Tanggal app dir not null 
                    and a.iappdireksi = 2 and app.tupdate is not null 
                    #periode tanggal prareg 
                    and a.dinput_applet >= "'.$dm['tgl1'].'" 
                    and a.dinput_applet <= "'.$dm['tgl2'].'"
                    group by a.iupb_id
                    UNION
                    select
                    #untuk Produk Kategori Non Obat
                    a.iupb_id,a.vupb_nomor,a.vupb_nama,a.vKode_obat, a.iGroup_produk, a.dinput_applet, a.ttarget_noreg, kat.vkategori
                    from plc2.plc2_upb a 
                    join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" 
                    join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id 
                    join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk 
                    join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategori_id
                    #Filter Deleted 
                    where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0 
                    #upb team nya 
                    and a.iteambusdev_id="'.$itim.'" 
                    #Tanggal NIE Not NULl 
                    and a.ttarget_noreg is not null 
                    #Kategori Obat
                    AND a.ikategori_id in (3,4,6,7,8,9,13)
                    #Tanggal app dir not null 
                    and a.iappdireksi = 2 and app.tupdate is not null 
                    #periode tanggal prareg 
                    and a.ttarget_noreg >= "'.$dm['tgl1'].'" 
                    and a.ttarget_noreg <= "'.$dm['tgl2'].'"
                    group by a.iupb_id
                    ) AS z
                    group by z.iupb_id 
                    ORDER BY z.vupb_nomor ASC  
                ';
        $data['rcount_disc']=$this->db->query($sql_par_disc)->num_rows();
        $data['dataall_disc']=$this->db->query($sql_par_disc)->row_array();
        $view=$this->load->view('busdev/detail_perform/busdev_3/details_bd3_7',$data,true);
        return $view;
    }

    public function BD3_9($imaster_id){

        $dmas=$this->getDetMaster($imaster_id);
        $tgl2=$dmas['tgl2'];
        $tgl1=$dmas['tgl1']; 


        $sqlp1 = '  SELECT u.`dinput_applet`, u.`tregistrasi` ,mk.vkategori,  u.`iupb_id` , u.`dinput_applet` ,  u.ikategoriupb_id, u.`vupb_nomor`,u.vupb_nama ,  u.vKode_obat FROM plc2.`plc2_upb` u 
                    join hrd.mnf_kategori mk on mk.ikategori_id = u.ikategori_id
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 5 
                    AND u.dinput_applet IS NOT NULL  
                    AND u.`ikategori_id` IN (1,2,5,10, 11, 12)
                    AND u.`tregistrasi` IS NOT NULL
                    AND u.`dinput_applet` >= "'.$tgl1.'" 
                    AND u.`dinput_applet` <= "'.$tgl2.'"  
                    ';

        $sqlp2 = '  SELECT u.`ttarget_noreg`, u.`tregistrasi` ,mk.vkategori,  u.`iupb_id` , u.`dinput_applet` ,  u.ikategoriupb_id, u.`vupb_nomor`,u.vupb_nama ,  u.vKode_obat FROM plc2.`plc2_upb` u 
                    join hrd.mnf_kategori mk on mk.ikategori_id = u.ikategori_id
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 5 
                    AND u.`ttarget_noreg` IS NOT NULL  
                    AND u.`ikategori_id` IN (7)
                    AND u.`tregistrasi` IS NOT NULL
                    AND u.`ttarget_noreg` >= "'.$tgl1.'" 
                    AND u.`ttarget_noreg` <= "'.$tgl2.'"  
                    ';


        //Menghitung BE 

        $res2 = $this->db_erp_pk->query($sqlp2)->result_array();
        $res1 = $this->db_erp_pk->query($sqlp1)->result_array(); 
        $data['dataall'] = $res1;
        $data['dataall2'] = $res2;
        $view=$this->load->view('busdev/detail_perform/busdev_3/details_bd3_9',$data,true);
        return $view;
    }

    public function BD3_10($imaster_id){

        $dmas=$this->getDetMaster($imaster_id);
        $tgl2=$dmas['tgl2'];
        $tgl1=$dmas['tgl1'];


        $sql = '  SELECT mk.vkategori, u.`ttarget_noreg`, u.`tregistrasi`, u.`iupb_id` , u.`dinput_applet` , u.`tregistrasi`, u.ikategoriupb_id, u.`vupb_nomor`,u.vupb_nama ,  u.vKode_obat FROM plc2.`plc2_upb` u 
                    join hrd.mnf_kategori mk on mk.ikategori_id = u.ikategori_id
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 5 
                    AND u.`ttarget_noreg` IS NOT NULL  
                    AND u.`ikategori_id` IN (3,4,6,8,9,10,13)
                    AND u.`tregistrasi` IS NOT NULL
                    AND u.dinput_applet IS NOT NULL  
                    AND u.`ttarget_noreg` >= "'.$tgl1.'" 
                    AND u.`ttarget_noreg` <= "'.$tgl2.'"  
                    '; 

        $res = $this->db_erp_pk->query($sql)->result_array();
        $data['sql']=$sql; 
        $data['dataall'] = $res; 
        $view=$this->load->view('busdev/detail_perform/busdev_3/details_bd3_10',$data,true);
        return $view;
    }
 
    public function BD3_12($imaster_id){

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


        $view=$this->load->view('busdev/detail_perform/busdev_3/details_bd3_12',$data,true);
        return $view;
    }

    public function getmasterdata($imaster_id){
        $sql="select * from pk.pk_master ma where ma.idmaster_id=".$imaster_id." and ma.ldeleted=0 LIMIT 1";
        $data=$this->db->query($sql)->row_array();
        return $data;
    }
    
    public function itim($nip){
        $itim=0;
        $sqltim='select a.iteam_id,a.* 
                from plc2.plc2_upb_team a 
                where a.ldeleted=0 
                and a.iteam_id in(4,5,22) 
                and  a.vnip="'.$nip.'"'; 
        $dTim = $this->db->query($sqltim)->row_array();
        if(!empty($dTim)){
            $itim=$dTim['iteam_id'];
        }
        return $itim;
    }
}

