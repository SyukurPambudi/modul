<?php

class lib_pk_analytical_development_lokal
{
    private $_ci;
    private $sess_auth;
    private $db_erp_pk;

    function __construct()
    {
        $this->_ci = &get_instance();
        $this->_ci->load->library('Zend', 'Zend/Session/Namespace');
        $this->sess_auth = new Zend_Session_Namespace('auth');
        $this->db_erp_pk = $this->_ci->load->database('pk',false, true);
        $this->pd_2_child = array();
    }


    function getPoint($result, $iAspekId)
    {   
        $sql = "select a.nPoint,(select cWarna FROM hrd.pk_warna WHERE iPoint=a.nPoint) as warna from hrd.pk_aspek_detail as a WHERE a.iAspekId='" . $iAspekId . "' and '" . $result . "' between a.yNilai1 and a.yNilai2";
        if($result < 0){
            $sql = "select a.nPoint,(select cWarna FROM hrd.pk_warna WHERE iPoint=a.nPoint) as warna from hrd.pk_aspek_detail as a WHERE a.iAspekId='" . $iAspekId . "' and '" . $result . "' between a.yNilai2 and a.yNilai1";
            
        }else{
            $sql = "select a.nPoint,(select cWarna FROM hrd.pk_warna WHERE iPoint=a.nPoint) as warna from hrd.pk_aspek_detail as a WHERE a.iAspekId='" . $iAspekId . "' and '" . $result . "' between a.yNilai1 and a.yNilai2";
        }
        
        $query = $this->db_erp_pk->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $value = $row->nPoint . "~" . $row->warna;
        } else {
            $value = '20~#FF3333';
        }

        return $value;

    }
    function getPointDynamic($result, $iAspekId)
    {
        if($result < 0){
            $sql = "select a.nPoint,(select cWarna FROM hrd.pk_warna WHERE iPoint=a.nPoint) as warna from hrd.pk_aspek_dynamic_detail as a WHERE a.iAspekId='" . $iAspekId . "' and '" . $result . "' between a.yNilai2 and a.yNilai1";
        }else{
            $sql = "select a.nPoint,(select cWarna FROM hrd.pk_warna WHERE iPoint=a.nPoint) as warna from hrd.pk_aspek_dynamic_detail as a WHERE a.iAspekId='" . $iAspekId . "' and '" . $result . "' between a.yNilai1 and a.yNilai2";
        }

        $query = $this->db_erp_pk->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $value = $row->nPoint . "~" . $row->warna;
        } else {
            $value = '20~#FF3333';
        }

        return $value;

    }
    function hitung_bulan($perode1, $perode2)
    {
        $tgl_skr = new DateTime($perode2, new DateTimeZone("Europe/London"));
        $tgl_lalu = new DateTime($perode1, new DateTimeZone("Europe/London"));

        $cek_val ="";
        $bulan=0;
        do { 
            if($cek_val!=$tgl_skr->format("Y-m")){
                // $tgl = $tgl_skr->format("Y-m"); 
                // $htmlxy .= "<td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$tgl."</td> ";
                $bulan++;
            }
            $cek_val=$tgl_skr->format("Y-m");  
            $tgl_skr->modify('-1 month');
        } while ($tgl_skr >= $tgl_lalu);

        // $date1 = new DateTime($perode1);
        // $date2 = new DateTime($perode2);

        // $diff = $date1->diff($date2);
        // $bulan = (($diff->format('%y') * 12) + $diff->format('%m')) + 1;

        return $bulan;
    }

    function sumTime($times)
    {
        // loop throught all the times
        $minutes = 0;
        foreach ($times as $time) {
            list($hour, $minute) = explode(':', $time);
            $minutes += $hour * 60;
            $minutes += $minute;
        }

        $hours = floor($minutes / 60);
        $minutes -= $hours * 60;

        // returns the time already formatted
        return sprintf('%02d:%02d', $hours, $minutes);
    }


    function datediff($tgl1, $tgl2, $cNip)
    {
        $sql = "SELECT iCompanyId FROM hrd.employee WHERE cNip='" . $cNip . "' ";
        $query = $this->db_erp_pk->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $company = $row->iCompanyId;
        }

        $dstart = date('Y-m-d', strtotime($tgl1));
        $dend = date('Y-m-d', strtotime($tgl2));
        $increment = "++";
        if ($dstart > $dend) {
            $dstart = date('Y-m-d', strtotime($tgl2));
            $dend = date('Y-m-d', strtotime($tgl1));
            $increment = "--";
            //echo "Lebih Besar ".$dstart." > ".$dend ;
            //exit();
        }

        $start = new DateTime($dstart);
        $start->modify('+1 day');
        $end = new DateTime($dend);
        $end->modify('+1 day');
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);
        $year1 = date('Y', strtotime($dstart));
        $year2 = date('Y', strtotime($dend));
        //cari hari liburnya
        $sql = "SELECT *
                FROM (SELECT a.dDate AS tgl,a.cYear, 'hol' AS src,a.cdescription AS ket
                      FROM hrd.holiday AS a
                  UNION ALL
                      SELECT b.dDate AS tgl,b.cYear,'cho' AS src,b.vDescription AS ket
                      FROM hrd.compholiday AS b
                        WHERE b.iCompanyId='" . $company . "'
                     )AS tabgab
                   WHERE cyear BETWEEN '" . $year1 . "' AND '" . $year2 . "'";


        $holidays = Array();
        $result = mysql_query($sql) or die(mysql_error() . "</br>" . $sql);

        while ($row = mysql_fetch_assoc($result)) {
            array_push($holidays, $row['tgl']);
        }

        $lama = 0;
        foreach ($period as $dt) {

            $curr = $dt->format('D');
            $tanggal = $dt->format('Y-m-d');
            // for the updated question
            if ($curr == 'Sat' || $curr == 'Sun') {
                continue;
            }
            if (in_array($dt->format('Y-m-d'), $holidays)) {

            } else {
                if ($increment == '++') {
                    $lama++;
                } else {
                    $lama--;
                }

            }


        }

        if ($increment == '++') {
            return $lama + 1;
        } else {
            return $lama - 1;
        }


    }


    function getvName($cNip)
    {

        $vName = '';

        $sql = "SELECT vName FROM hrd.employee WHERE cNip = '{$cNip}' AND lDeleted = 0";
        $query = $this->db_erp_pk->query($sql);

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $vName = $row->vName;
        }

        return $vName;
    }



    //Cek Tanggal libur, dan tanggal kerja
    function selisihHari($tglAwal, $tglAkhir, $nip, $type = "day")
    {
        $this->dbseth = $this->_ci->load->database('hrd', true);
        $sqlc = "select * from hrd.dshift da
                inner join hrd.gshift gs on da.iShiftID=gs.iShiftID
                inner join hrd.employee em on em.igshiftid=gs.iGShiftID
                where em.cNip='" . $nip . "' and (da.ciIn!='00:00:00' or da.ciEnd!='00:00:00')";
        $counthr = $this->dbseth->query($sqlc)->num_rows();

        $tglLibur = array();
        $sqlholi = "select * from hrd.holiday holi
            where holi.bDeleted=0 and holi.ddate Between '" . $tglAwal . "' AND '" . $tglAkhir . "'";
        $qlholi = $this->dbseth->query($sqlholi);
        if ($qlholi->num_rows() >= 1) {
            foreach ($qlholi->result_array() as $kholi => $vholi) {
                array_push($tglLibur, $vholi['ddate']);
            }
        }
        $pecah1 = explode("-", date("Y-m-d", strtotime($tglAwal)));

        $date1 = $pecah1[2];
        $month1 = $pecah1[1];
        $year1 = $pecah1[0];
        $pecah2 = explode("-", date("Y-m-d", strtotime($tglAkhir)));
        $date2 = $pecah2[2];
        $month2 = $pecah2[1];
        $year2 = $pecah2[0];

        $jd1 = GregorianToJD($month1, $date1, $year1);
        $jd2 = GregorianToJD($month2, $date2, $year2);
        $selisih = $jd2 - $jd1;
        $libur1 = 0;
        $libur2 = 0;
        $libur3 = 0;
        for ($i = 1; $i <= $selisih; $i++) {
            $tanggal = mktime(0, 0, 0, $month1, $date1 + $i, $year1);
            $tglstr = date("Y-m-d", $tanggal);
            if (in_array($tglstr, $tglLibur)) {
                $libur1++;
            }
            if ((date("N", $tanggal) == 7)) {
                if (in_array($tglstr, $tglLibur)) {
                    $libur1 = $libur1 - 1;
                }
                $libur2++;
            }
            if ((date("N", $tanggal) == 6)) {
                if (in_array($tglstr, $tglLibur)) {
                    $libur1 = $libur1 - 1;
                }
                $libur3++;
            }
        }
        if ($type == 'day') {
            if ($counthr == 5) {
                $hasil = $selisih - $libur1 - $libur2 - $libur3;
            } else {
                $hasil = $selisih - $libur1 - $libur2;
            }
            if ($hasil >= 0) {
                if (date('H:i:s', strtotime($tglAwal)) > date('H:i:s', strtotime($tglAkhir))) {
                    $hasil = $hasil - 1;
                }
            }
            return $hasil;
        }
        if($type='minute'){
            if($counthr==5){
                $hasil = $selisih-$libur1-$libur2-$libur3;
            }else{
                $hasil = $selisih-$libur1-$libur2;
            }
            $hmennt=0;
            if($hasil>=1){
                if(date('H:i:s', strtotime($tglAwal)) > date('H:i:s', strtotime($tglAkhir))){
                    #$hasil=$hasil-1;
                    $hmennt=(int)$hasil*1440;
                    $selmnt=$this->selisihMenit(date('H:i:s', strtotime($tglAkhir)),date('H:i:s', strtotime($tglAwal)));
                    $selmnt=1440-(int)$selmnt;
                    $hmennt=$hmennt+(int)$selmnt;
                    return $hmennt;
                }else{
                    $hmennt=(int)$hasil*1440;
                    $selmnt=$this->selisihMenit(date('H:i:s', strtotime($tglAwal)),date('H:i:s', strtotime($tglAkhir)));
                    $hmennt=$hmennt+(int)$selmnt;
                    return $hmennt;
                }
            }else{
                if(date('H:i:s', strtotime($tglAkhir)) > date('H:i:s', strtotime($tglAwal))){
                    $selmnt=$this->selisihMenit(date('H:i:s', strtotime($tglAwal)),date('H:i:s', strtotime($tglAkhir)));
                    return $selmnt;
                    $hmennt=(int)$selmnt;
                    return $hmennt;
                }else{
                    return "0";
                }
            }
        }

    }

    function CekoptionalFunc11($tgl, $nip)
    {
        $this->dbseth = $this->_ci->load->database('hrd', true);
        $sqlc = "select * from hrd.dshift da
                inner join hrd.gshift gs on da.iShiftID=gs.iShiftID
                inner join hrd.employee em on em.igshiftid=gs.iGShiftID
                where em.cNip='" . $nip . "' and (da.ciIn!='00:00:00' or da.ciEnd!='00:00:00')";
        $counthr = $this->dbseth->query($sqlc)->num_rows();

        $tglLibur = array();
        $sqlholi = "select * from hrd.holiday holi
            where holi.bDeleted=0 and holi.ddate = '".$tgl."'";
        $qlholi = $this->dbseth->query($sqlholi);
        $retlibur=false;
        if ($qlholi->num_rows() >= 1) {
            $retlibur=true;
        }
        $pecah1 = explode("-", date("Y-m-d", strtotime($tgl)));

        $date1 = $pecah1[2];
        $month1 = $pecah1[1];
        $year1 = $pecah1[0];
        $tanggal = mktime(0, 0, 0, $month1, $date1, $year1);
        if ((date("N", $tanggal) == 7)) {
             $retlibur=true;
        }
        if ((date("N", $tanggal) == 6)) {
             $retlibur=true;
        }        
        return $retlibur;

    }

    function getHoliday($tglAwal, $tglAkhir, $nip, $type="holiday"){
        $this->dbseth = $this->_ci->load->database('hrd', true); 
        $sqlc="select * from hrd.dshift da
                inner join hrd.gshift gs on da.iShiftID=gs.iShiftID
                inner join hrd.employee em on em.igshiftid=gs.iGShiftID
                where em.cNip='".$nip."' and (da.ciIn!='00:00:00' or da.ciEnd!='00:00:00')";
        $counthr=$this->dbseth->query($sqlc)->num_rows();
 
        $tglLibur = array();
        $sqlholi="select * from hrd.holiday holi
            where holi.bDeleted=0 and holi.ddate Between '".$tglAwal."' AND '".$tglAkhir."'";
        $qlholi=$this->dbseth->query($sqlholi);
        if($qlholi->num_rows()>=1){
            foreach ($qlholi->result_array() as $kholi => $vholi) {
                array_push($tglLibur, $vholi['ddate']);
            }
        } 
        $pecah1 = explode("-", date("Y-m-d",strtotime($tglAwal)));

        $date1 = $pecah1[2];
        $month1 = $pecah1[1];
        $year1 = $pecah1[0]; 
        $pecah2 = explode("-", date("Y-m-d",strtotime($tglAkhir)));
        $date2 = $pecah2[2];
        $month2 = $pecah2[1];
        $year2 =  $pecah2[0]; 

        $jd1 = GregorianToJD($month1, $date1, $year1);
        $jd2 = GregorianToJD($month2, $date2, $year2);
        $selisih = $jd2 - $jd1;
        $libur1=0;
        $libur2=0;
        $libur3=0; 
        for($i=1; $i<=$selisih; $i++){ 
            $tanggal = mktime(0, 0, 0, $month1, $date1+$i, $year1);
            $tglstr = date("Y-m-d", $tanggal); 
            if (in_array($tglstr, $tglLibur))
            {
                $libur1++;
            } 
            if ((date("N", $tanggal) == 7))
            {
                if (in_array($tglstr, $tglLibur))
                {
                    $libur1=$libur1-1;
                }
                $libur2++;
            }
            if ((date("N", $tanggal) == 6))
            {
                if (in_array($tglstr, $tglLibur))
                {
                    $libur1=$libur1-1;
                }
                $libur3++;
            }
        }
        $hasil=0;
        if($type=='holiday'){  
            $hasil=$libur1;
        }elseif($type=='offkerja'){
            if($counthr==5){
                $hasil = $libur2+$libur3;
            }else{
                $hasil = $libur2;
            }
        }elseif($type=='offbrutto'){
           $hasil=$selisih;
        }
        return $hasil; 
    }
 

    function getChild ($nip){
        $sql = "SELECT cNip FROM hrd.employee WHERE cUpper = ? ";
        $child = $this->db_erp_pk->query($sql, array($nip))->result_array();
        if (count($child) > 0){
            foreach ($child as $c) {
                if (isset($c['cNip'])){
                    array_push($this->pd_2_child, $c['cNip']);
                    $this->getChild($c['cNip']);
                }
            }
        }
    }




    //PK START HERE

    function ANDEV_LOKAL_01($post)    {
        $noRow = 0;
        $totalJamAll = 0;
        $totalReqAll = 0;
        $tmpData = array();
        $totalJam = 0;
        $iAspekId = $post['_iAspekId'];
        $cNipNya = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $data_nip = array();
        $data_container = array();
        $data_stored = array();

        $debug = 0;
        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td> 
                    </tr>
                </table>";  

        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                    <tr>
                        <td><b>Jumlah UPB Validasi MOA BB</b></td>
                    </tr>
                    </table>";
        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Nomor UPB</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Nama UPB</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Jenis Metode</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Tanggal Approve PD</b></td> 
                </tr>
            ";
 
        //VAMOA BB
       $sqlbb= " SELECT pu.vupb_nomor, pu.vupb_nama, pv.dapppd, pv.ivalmoa_id,pm.vnama_metode FROM plc2.plc2_vamoa pv 
            JOIN plc2.plc2_upb pu on pu.iupb_id = pv.iupb_id 
            JOIN plc2.plc2_vamoa_metode vm  ON vm.ivalmoa_id = pv.ivalmoa_id
            JOIN plc2.plc2_master_jenis_metode pm on vm.iplc2_master_jenis_metode = pm.iplc2_master_jenis_metode
            WHERE
            pv.iupb_id IN (
                SELECT  distinct (ud.iupb_id) FROM plc2.plc2_upb_prioritas up 
                    JOIN plc2.plc2_upb_prioritas_detail ud ON ud.iprioritas_id = up.iprioritas_id
                    WHERE up.ldeleted = 0 and ud.ldeleted = 0 and up.iappdir = 1 and ud.iupb_id = pv.iupb_id 
            )
            AND  pv.lDeleted = 0 and pv.iapppd = 2 and pv.dapppd >= '".$perode1."'  AND pv.dapppd <= '".$perode2."' 

            order by pu.vupb_nomor "; 
   
        $batch = $this->db_erp_pk->query($sqlbb)->result_array(); 
        $x = 0 ;   
        foreach ($batch as $b) {  
             $x++;  
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='border: 1px solid #dddddd;' >".$x."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['vupb_nomor']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['vupb_nama']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['vnama_metode']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['dapppd']."</td>   
                      </tr>";   
        } 
        $html .= "</table><br><hr>";
        
        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                    <tr>
                        <td><b>Jumlah UPB Validasi MOA FG</b></td>
                    </tr>
                    </table>";
        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Nomor UPB</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Nama UPB</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Jenis Metode</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Tanggal Approve PD</b></td> 
                    </tr>
            "; 
 
       //VAMOA FG
        $sql2= " SELECT pu.vupb_nomor, pu.vupb_nama, pm.vnama_metode, pv.dapppd, pv.ivalmoa_fg_id FROM plc2.plc2_vamoa_fg pv 
            JOIN plc2.plc2_upb pu on pu.iupb_id = pv.iupb_id 
            JOIN plc2.plc2_vamoa_fg_metode vm  ON vm.ivalmoa_fg_id = pv.ivalmoa_fg_id
            JOIN plc2.plc2_master_jenis_metode pm on vm.iplc2_master_jenis_metode = pm.iplc2_master_jenis_metode 
            WHERE
            pv.iupb_id IN (
                SELECT  distinct (ud.iupb_id) FROM plc2.plc2_upb_prioritas up 
                    JOIN plc2.plc2_upb_prioritas_detail ud ON ud.iprioritas_id = up.iprioritas_id
                    WHERE up.ldeleted = 0 and ud.ldeleted = 0 and up.iappdir = 1 and ud.iupb_id = pv.iupb_id 
            )
            AND  pv.lDeleted = 0 and pv.iapppd = 2 and pv.dapppd >= '".$perode1."'  AND pv.dapppd <= '".$perode2."' 

            order by pu.vupb_nomor "; 
         
        $lauch = $this->db_erp_pk->query($sql2)->result_array(); 
        $y = 0 ; 
        foreach ($lauch as $t) {   
             $y++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='border: 1px solid #dddddd;' >".$y."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['vupb_nomor']."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['vupb_nama']."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['vnama_metode']."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['dapppd']."</td>  
                      </tr>";   
        }  
        $html .= "</table>"; 
        $html .= "<br /> ";   
       
        $result     = $x+$y;
        $getpoint = $this->getPoint($result, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 800px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Seluruh UPB yang melakukan VALIDASI MOA BB & VALIDASI MOA FG</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$result." Metode</td>
                    </tr>   
                </table>";      
        
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }
    function ANDEV_LOKAL_03($post)    {
        $noRow = 0;
        $totalJamAll = 0;
        $totalReqAll = 0;
        $tmpData = array();
        $totalJam = 0;
        $iAspekId = $post['_iAspekId'];
        $cNipNya = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $data_nip = array();
        $data_container = array();
        $data_stored = array();

        $debug = 0;
        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td> 
                    </tr>
                </table>";  
        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                <tr style='width:100%; border: 1px solid #f86609; background:  #33c1ff; border-collapse: collapse;text-align: center;'>
                    <td colspan='6'><b>UPB SOI BB</b></td>
                </tr>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Nomor UPB</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Nama UPB</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Tanggal Setting Prioritas</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Tanggal Approve</b></td> 
                    <td style='border: 1px solid #dddddd;' ><b>Selisih (Hari)</b></td> 
                </tr>
            ";
 
        //Draft SOI BB
       $sqlbb= "SELECT u.vupb_nomor,u.vupb_nama,if(pr.iappdir=1,pr.tappdir,pr.tappbusdev) as approval,bb2.dApproval as appsoi,if(pr.iappdir=1,'DIR','BD') as jenisapp,pr.tappbusdev from plc2.draft_soi_bb bb2
                join plc2.plc2_upb_prioritas_detail det on det.iupb_id = bb2.iupb_id
                join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=det.iprioritas_id
                join plc2.plc2_upb u on u.iupb_id=bb2.iupb_id 
                where
                pr.ldeleted=0 and bb2.lDeleted=0 and det.ldeleted=0
                and pr.iappbusdev=2 and pr.tappbusdev is not null
                #and (case when pr.iappdir=1 then pr.tappdir is not null else pr.iappbusdev=2 and pr.tappbusdev is not null end)
                and bb2.idraft_soi_bb in (
                    select bb.idraft_soi_bb from plc2.draft_soi_bb bb
                    where bb.lDeleted=0 and bb.iApprove=2
                    and bb.dApproval is not null 
                   and bb.dApproval BETWEEN '".$perode1."' AND '".$perode2."'
                    group by bb.iupb_id
                    order by bb.dApproval DESC
                )
                group by bb2.iupb_id
                order by approval ASC"; 
   
        $batch = $this->db_erp_pk->query($sqlbb)->result_array(); 
        $x = 0 ;  
        $countselisih=array(); 
        foreach ($batch as $b) {  
             $x++;
              $se=$this->selisihnokerja(date("Y-m-d",strtotime($b['tappbusdev'])),date("Y-m-d",strtotime($b['appsoi'])));
              $countselisih[]=$se;
             $color =fmod($x,2)==0?'background-color: #eaedce':'';
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'>
                        <td style='border: 1px solid #dddddd;' >".$x."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['vupb_nomor']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['vupb_nama']."</td>
                        <td style='border: 1px solid #dddddd;text-align: center;'>".date("Y-m-d",strtotime($b['tappbusdev']))."</td>
                        <td style='border: 1px solid #dddddd;text-align: center;'>".date("Y-m-d",strtotime($b['appsoi']))."</td>   
                        <td style='border: 1px solid #dddddd;text-align: right;'>".$se."</td>   
                      </tr>";   
        } 
        $y=array_sum($countselisih);
        $selisihbln=$y;
        $html.="<tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #b5f2a6;line-height: 14px;text-align: center;'><td colspan='5' style='text-align: center;border: 1px solid #dddddd;'><b>Jumlah Selisih (Hari) (X)</b></td><td style='text-align: right;border: 1px solid #dddddd;'><b>".$y."</b></td></tr>";
        $html .= "</table><br>";
        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                <tr style='width:100%; border: 1px solid #f86609; background:  #33c1ff; border-collapse: collapse;text-align: center;'>
                    <td colspan='6'><b>UPB SOI FG Tentative</b></td>
                </tr>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Nomor UPB</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Nama UPB</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Tanggal Setting Prioritas</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Tanggal Approve</b></td> 
                    <td style='border: 1px solid #dddddd;' ><b>Selisih (Hari)</b></td> 
                </tr>
            ";
 
        //Soi FG Tentative
       $sqlfg= "SELECT u.vupb_nomor,u.vupb_nama,if(pr.iappdir=1,pr.tappdir,pr.tappbusdev) as approval,bb2.dApproval as appsoi,if(pr.iappdir=1,'DIR','BD') as jenisapp,pr.tappbusdev from plc2.soi_fg_tentatif bb2
                join plc2.plc2_upb_prioritas_detail det on det.iupb_id = bb2.iupb_id
                join plc2.plc2_upb_prioritas pr on pr.iprioritas_id=det.iprioritas_id
                join plc2.plc2_upb u on u.iupb_id=bb2.iupb_id 
                where
                pr.ldeleted=0 and bb2.lDeleted=0 and det.ldeleted=0
                and pr.iappbusdev=2 and pr.tappbusdev is not null
                #and (case when pr.iappdir=1 then pr.tappdir is not null else pr.iappbusdev=2 and pr.tappbusdev is not null end)
                and bb2.isoi_fg_tentatif in (
                    select bb.isoi_fg_tentatif from plc2.soi_fg_tentatif bb
                    where bb.lDeleted=0 and bb.iApprove=2
                    and bb.dApproval is not null 
                   and bb.dApproval BETWEEN '".$perode1."' AND '".$perode2."'
                    group by bb.iupb_id
                    order by bb.dApproval DESC
                )
                group by bb2.iupb_id
                order by approval ASC"; 
   
        $batch1 = $this->db_erp_pk->query($sqlfg)->result_array(); 
        $x1 = 0 ;  
        $countselisih2=array(); 
        foreach ($batch1 as $b1) {  
             $x1++;
              $se1=$this->selisihnokerja(date("Y-m-d",strtotime($b1['tappbusdev'])),date("Y-m-d",strtotime($b1['appsoi'])));
              $countselisih2[]=$se1;
             $color1 =fmod($x1,2)==0?'background-color: #eaedce':'';
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color1."'>
                        <td style='border: 1px solid #dddddd;' >".$x1."</td>
                        <td style='border: 1px solid #dddddd;' >".$b1['vupb_nomor']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b1['vupb_nama']."</td>
                        <td style='border: 1px solid #dddddd;text-align: center;'>".date("Y-m-d",strtotime($b1['tappbusdev']))."</td>
                        <td style='border: 1px solid #dddddd;text-align: center;'>".date("Y-m-d",strtotime($b1['appsoi']))."</td>   
                        <td style='border: 1px solid #dddddd;text-align: right;'>".$se1."</td>   
                      </tr>";   
        } 
        $y2=array_sum($countselisih2);
        $selisihbln1=$y2;
        $html.="<tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #b5f2a6;line-height: 14px;text-align: center;'><td colspan='5' style='text-align: center;border: 1px solid #dddddd;'><b>Jumlah Selisih (Hari) (Y)</b></td><td style='text-align: right;border: 1px solid #dddddd;'><b>".$y2."</b></td></tr>";
        $html .= "</table><br><hr>";

        $jmlselisih=$selisihbln1+$selisihbln;
        $selisihbln=$jmlselisih/22;

        $result     = number_format($selisihbln,2);
        $result1=number_format($selisihbln, 2, ',', '');
        $getpoint = $this->getPoint($result1, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 800px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih SOI BB & SOI FG Tentative (X+Y)</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$jmlselisih." Hari</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>jumlah Selisih dalam bulan (22 Hari)</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan</td>
                    </tr>   
                </table>";      
        
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }

    function selisihnokerja($current,$last){ 
        $tanggal1 = new DateTime($current);
        $tanggal2 = new DateTime($last); 
        $perbedaan = $tanggal2->diff($tanggal1)->format("%a");
        return $perbedaan;
    }

     function ANDEV_LOKAL_04($post)    {
        $noRow = 0;
        $totalJamAll = 0;
        $totalReqAll = 0;
        $tmpData = array();
        $totalJam = 0;
        $iAspekId = $post['_iAspekId'];
        $cNipNya = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $data_nip = array();
        $data_container = array();
        $data_stored = array();

        $debug = 0;
        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td> 
                    </tr>
                </table>";  
 
        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <td rowspan='2' style='border: 1px solid #dddddd;' ><b>No</b></td>
                    <td rowspan='2' style='border: 1px solid #dddddd;' ><b>Nomor UPB</b></td>
                    <td rowspan='2' style='border: 1px solid #dddddd;' ><b>Nama UPB</b></td>
                    <td rowspan='2' style='border: 1px solid #dddddd;' ><b>Flow</b></td>
                    <td rowspan='2' style='border: 1px solid #dddddd;' ><b>Month</b></td>  
                    <td rowspan='2' style='border: 1px solid #dddddd;' ><b>Tgl Mapping<br>(x)</b></td>  
                    <td style='border: 1px solid #dddddd;' colspan='4'><b>Uji Kimiawi</b></td>   
                    <td rowspan='2' style='border: 1px solid #dddddd;' ><b>Selisih Hari<br>(x-a) + (x-b)</b></td> 
                </tr>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'> 
                    <td style='border: 1px solid #dddddd;' ><b>Uji Kadar</b></td> 
                    <td style='border: 1px solid #dddddd;' ><b>Approve <br>Uji Kadar<br>(a)</b></td> 
                    <td style='border: 1px solid #dddddd;' ><b>Uji Disolusi</b></td> 
                    <td style='border: 1px solid #dddddd;' ><b>Approve <br>Uji Disolusi<br>(b)</b></td>   
                </tr>
            ";
 
        //FORMULA
      
        $sumDisolusi=0;
        $sumKadar = 0;

        //Tampilin Bulan ke 3 Doang
        $formula = "SELECT DISTINCT(fp.iFormula_process) , fpd.iFormula_process_detail, pu.vupb_nomor, pu.vupb_nama, mp.vNama_proses, mf.tKet_flow, pu.iupb_id, (SELECT pds.dFinish_time FROM pddetail.formula_process_detail pds where 
                                 pds.iFormula_process = fpd.iFormula_process and pds.iProses_id=1 and pds.is_proses=1) 
                                 as tglmapping
                                 FROM pddetail.formula_process fp
            JOIN pddetail.formula_process_detail fpd on fp.iFormula_process = fpd.iFormula_process
            JOIN pddetail.formula_stabilita fs on fs.iFormula_process = fp.iFormula_process
            JOIN plc2.plc2_upb pu on pu.iupb_id = fp.iupb_id
            JOIN pddetail.flow_uji_kimia ki on ki.iFormula_process = fp.iFormula_process and ki.iFormula_process_detail=fpd.iFormula_process_detail
            JOIN pddetail.flow_uji_kimia_detail kid on kid.iFlow_uji = ki.iFlow_uji   
            JOIN pddetail.master_proses mp on mp.iProses_id = fpd.is_prevProses 
            JOIN pddetail.master_flow mf on mf.iMaster_flow = fp.iMaster_flow 
            WHERE fp.iMaster_flow = 9 and fpd.iProses_id = 6 and fpd.is_prevProses = 23 AND kid.iProses_id = 17
            and ki.lDeleted = 0 and kid.lDeleted = 0 and kid.iProses_id in (17,18)";

        $for = $this->db_erp_pk->query($formula)->result_array();
        $x = 1;
        $z = 0;
        $hitungHari = 0;

        $simpanUPB  = "";
        foreach ($for as $f) {
             
             if($z==0){ 
                $simpanUPB = $f['iupb_id'];
             }else{ 
                $simpanUPB .= ','.$f['iupb_id']; 
             }
             $z++;

            $disolusi="N";
            $sql18 = "SELECT fd.iFlow_uji_kimia_detail FROM pddetail.flow_uji_kimia f 
                    JOIN pddetail.flow_uji_kimia_detail fd on f.iFlow_uji = fd.iFlow_uji
                    where fd.iProses_id = 18 AND f.iFormula_process='".$f['iFormula_process']."' AND f.iFormula_process_detail='".$f['iFormula_process_detail']."' LIMIT 1 ";
            if($this->db_erp_pk->query($sql18)->num_rows()){
                $disolusi = "Y";
            }  


            if($disolusi=="N"){
                $sql17_tampil = "SELECT fd.dFinish_time FROM pddetail.flow_uji_kimia f 
                    JOIN pddetail.flow_uji_kimia_detail fd on f.iFlow_uji = fd.iFlow_uji
                    where fd.iProses_id = 17 AND f.iFormula_process='".$f['iFormula_process']."' AND f.iFormula_process_detail='".$f['iFormula_process_detail']."' 
                    AND fd.iapproval_finish = 2 
                    and fd.dFinish_time>='".$perode1."' and fd.dFinish_time <= '".$perode2."'
                    LIMIT 1 ";
                $que17_tampil = $this->db_erp_pk->query($sql17_tampil)->row_array();
                if(!empty($que17_tampil['dFinish_time'])){

                    $selisih = $this->selisihnokerja($f['tglmapping'],$que17_tampil['dFinish_time']);
                    $hitungHari += $selisih;
                    $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='border: 1px solid #dddddd;' >".$x++."</td>
                        <td style='border: 1px solid #dddddd;' >".$f['vupb_nomor']."</td>
                        <td style='border: 1px solid #dddddd;' >".$f['vupb_nama']."</td>
                        <td style='border: 1px solid #dddddd;' >".$f['tKet_flow']."</td>
                        <td style='border: 1px solid #dddddd;' >".$f['vNama_proses']."</td> 
                        <td style='border: 1px solid #dddddd;' >".$f['tglmapping']."</td>  
                        <td style='border: 1px solid #dddddd;' ><b>Y</b></td>  
                        <td style='border: 1px solid #dddddd;' >".$que17_tampil['dFinish_time']."</td>  
                        <td style='border: 1px solid #dddddd;' ><b>".$disolusi."</b></td>   
                        <td style='border: 1px solid #dddddd;' >-</td>   
                        <td style='border: 1px solid #dddddd;' >".$selisih."</td>  
                      </tr>";   
                }
            }else{
                $sql17_tampil = "SELECT fd.dFinish_time FROM pddetail.flow_uji_kimia f 
                    JOIN pddetail.flow_uji_kimia_detail fd on f.iFlow_uji = fd.iFlow_uji
                    where fd.iProses_id = 17 AND f.iFormula_process='".$f['iFormula_process']."' AND f.iFormula_process_detail='".$f['iFormula_process_detail']."' 
                    AND fd.iapproval_finish = 2 
                    and fd.dFinish_time>='".$perode1."' and fd.dFinish_time <= '".$perode2."'
                    LIMIT 1 ";
                $que17_tampil = $this->db_erp_pk->query($sql17_tampil)->row_array();

                $tam = 0;
                if(empty($que17_tampil['dFinish_time'])){
                    $que17_tampil['dFinish_time']='-';
                    $tam = 1;
                }

                $sql18_tampil = "SELECT fd.dFinish_time FROM pddetail.flow_uji_kimia f 
                    JOIN pddetail.flow_uji_kimia_detail fd on f.iFlow_uji = fd.iFlow_uji
                    where fd.iProses_id = 18 AND f.iFormula_process='".$f['iFormula_process']."' AND f.iFormula_process_detail='".$f['iFormula_process_detail']."' 
                    AND fd.iapproval_finish = 2 
                    and fd.dFinish_time>='".$perode1."' and fd.dFinish_time <= '".$perode2."'
                    LIMIT 1 ";
                $que18_tampil = $this->db_erp_pk->query($sql18_tampil)->row_array();

                $tam1 = 0; 
                if(empty($que18_tampil['dFinish_time'])){
                    $que18_tampil['dFinish_time']='-';
                    $tam1 = 1;
                }

                if($tam!=1 && $tam1!=1){
                    $selisih1 = $this->selisihnokerja($f['tglmapping'],$que17_tampil['dFinish_time']);
                    $selisih2 = $this->selisihnokerja($f['tglmapping'],$que18_tampil['dFinish_time']); 
                    $selisih = $selisih1+$selisih2;

                    $hitungHari += $selisih;

                    $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='border: 1px solid #dddddd;' >".$x++."</td>
                            <td style='border: 1px solid #dddddd;' >".$f['vupb_nomor']."</td>
                            <td style='border: 1px solid #dddddd;' >".$f['vupb_nama']."</td>
                            <td style='border: 1px solid #dddddd;' >".$f['tKet_flow']."</td>
                            <td style='border: 1px solid #dddddd;' >".$f['vNama_proses']."</td> 
                            <td style='border: 1px solid #dddddd;' >".$f['tglmapping']."</td>  
                            <td style='border: 1px solid #dddddd;' ><b>Y</b></td>  
                            <td style='border: 1px solid #dddddd;' >".$que17_tampil['dFinish_time']."</td>  
                            <td style='border: 1px solid #dddddd;' ><b>".$disolusi."</b></td>   
                            <td style='border: 1px solid #dddddd;' >".$que18_tampil['dFinish_time']."</td>   
                            <td style='border: 1px solid #dddddd;' >".$selisih."</td>  
                          </tr>";   
                }else{
                    if($tam==0){
                            $sql18_tampil_1 = "SELECT fd.dFinish_time FROM pddetail.flow_uji_kimia f 
                                JOIN pddetail.flow_uji_kimia_detail fd on f.iFlow_uji = fd.iFlow_uji
                                where fd.iProses_id = 18 AND f.iFormula_process='".$f['iFormula_process']."' AND f.iFormula_process_detail='".$f['iFormula_process_detail']."' 
                                    AND fd.iapproval_finish = 2 
                                LIMIT 1 ";
                            $que18_tampil_1 = $this->db_erp_pk->query($sql18_tampil_1)->row_array(); 
                            if(!empty($que18_tampil_1['dFinish_time'])){ 
                                //Dihitung  

                                $selisih1 = $this->selisihnokerja($f['tglmapping'],$que17_tampil['dFinish_time']);
                                $selisih2 = $this->selisihnokerja($f['tglmapping'],$que18_tampil_1['dFinish_time']); 
                                $selisih = $selisih1+$selisih2;

                                $hitungHari += $selisih;

                                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                                    <td style='border: 1px solid #dddddd;' >".$x++."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['vupb_nomor']."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['vupb_nama']."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['tKet_flow']."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['vNama_proses']."</td> 
                                    <td style='border: 1px solid #dddddd;' >".$f['tglmapping']."</td>  
                                    <td style='border: 1px solid #dddddd;' ><b>Y</b></td>  
                                    <td style='border: 1px solid #dddddd;' >".$que17_tampil['dFinish_time']."</td>  
                                    <td style='border: 1px solid #dddddd;' ><b>".$disolusi."</b></td>   
                                    <td style='border: 1px solid #dddddd;' >".$que18_tampil_1['dFinish_time']."</td>   
                                    <td style='border: 1px solid #dddddd;' >".$selisih."</td>  
                                  </tr>";  
                            }else{ 
                                //Tidak Dihitung
                                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;' bgcolor='#ddd'>
                                    <td style='border: 1px solid #dddddd;' >".$x++."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['vupb_nomor']."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['vupb_nama']."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['tKet_flow']."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['vNama_proses']."</td> 
                                    <td style='border: 1px solid #dddddd;' >".$f['tglmapping']."</td>  
                                    <td style='border: 1px solid #dddddd;' ><b>Y</b></td>  
                                    <td style='border: 1px solid #dddddd;' >".$que17_tampil['dFinish_time']."</td>  
                                    <td style='border: 1px solid #dddddd;' ><b>".$disolusi."</b></td>   
                                    <td style='border: 1px solid #dddddd;' >-</td>   
                                    <td style='border: 1px solid #dddddd;' >-</td>  
                                  </tr>";  
                            }
                    }else if($tam1==0){
                            $sql17_tampil_1 = "SELECT fd.dFinish_time FROM pddetail.flow_uji_kimia f 
                                JOIN pddetail.flow_uji_kimia_detail fd on f.iFlow_uji = fd.iFlow_uji
                                where fd.iProses_id = 17 AND f.iFormula_process='".$f['iFormula_process']."' AND f.iFormula_process_detail='".$f['iFormula_process_detail']."' 
                                AND fd.iapproval_finish = 2 
                                and fd.dFinish_time>='".$perode1."' and fd.dFinish_time <= '".$perode2."'
                                LIMIT 1 ";
                            $que17_tampil_1 = $this->db_erp_pk->query($sql17_tampil_1)->row_array();
 
                            if(!empty($que17_tampil_1['dFinish_time'])){ 
                                //Dihitung  
                                $selisih1 = $this->selisihnokerja($f['tglmapping'],$que17_tampil_1['dFinish_time']);
                                $selisih2 = $this->selisihnokerja($f['tglmapping'],$que18_tampil['dFinish_time']); 
                                $selisih = $selisih1+$selisih2;

                                $hitungHari += $selisih;

                                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                                    <td style='border: 1px solid #dddddd;' >".$x++."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['vupb_nomor']."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['vupb_nama']."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['tKet_flow']."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['vNama_proses']."</td> 
                                    <td style='border: 1px solid #dddddd;' >".$f['tglmapping']."</td>  
                                    <td style='border: 1px solid #dddddd;' ><b>Y</b></td>  
                                    <td style='border: 1px solid #dddddd;' >".$que17_tampil_1['dFinish_time']."</td>  
                                    <td style='border: 1px solid #dddddd;' ><b>".$disolusi."</b></td>   
                                    <td style='border: 1px solid #dddddd;' >".$que18_tampil['dFinish_time']."</td>   
                                    <td style='border: 1px solid #dddddd;' >".$selisih."</td>  
                                  </tr>";  
                            }else{ 
                                //Tidak DIhitung
                                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;' bgcolor='#ddd'>
                                    <td style='border: 1px solid #dddddd;' >".$x++."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['vupb_nomor']."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['vupb_nama']."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['tKet_flow']."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['vNama_proses']."</td> 
                                    <td style='border: 1px solid #dddddd;' >".$f['tglmapping']."</td>  
                                    <td style='border: 1px solid #dddddd;' ><b>Y</b></td>  
                                    <td style='border: 1px solid #dddddd;' >-</td>  
                                    <td style='border: 1px solid #dddddd;' ><b>".$disolusi."</b></td>   
                                    <td style='border: 1px solid #dddddd;' >".$que18_tampil['dFinish_time']."</td>   
                                    <td style='border: 1px solid #dddddd;' >-</td>  
                                  </tr>";  
                            }
                    }
                }
            } 
            
        }
 
        $formula = "SELECT DISTINCT(fp.iFormula_process) , fpd.iFormula_process_detail, pu.vupb_nomor, pu.vupb_nama, mp.vNama_proses, mf.tKet_flow, pu.iupb_id,fpd.is_prevProses, (SELECT pds.dFinish_time FROM pddetail.formula_process_detail pds where 
                                 pds.iFormula_process = fpd.iFormula_process and pds.iProses_id=1 and pds.is_proses=1) 
                                 as tglmapping
                                 FROM pddetail.formula_process fp
            JOIN pddetail.formula_process_detail fpd on fp.iFormula_process = fpd.iFormula_process
            JOIN pddetail.formula_stabilita fs on fs.iFormula_process = fp.iFormula_process
            JOIN plc2.plc2_upb pu on pu.iupb_id = fp.iupb_id
            JOIN pddetail.flow_uji_kimia ki on ki.iFormula_process = fp.iFormula_process and ki.iFormula_process_detail=fpd.iFormula_process_detail
            JOIN pddetail.flow_uji_kimia_detail kid on kid.iFlow_uji = ki.iFlow_uji   
            JOIN pddetail.master_proses mp on mp.iProses_id = fpd.is_prevProses 
            JOIN pddetail.master_flow mf on mf.iMaster_flow = fp.iMaster_flow 
            WHERE fp.iMaster_flow = 9 and fpd.iProses_id = 6 and kid.iProses_id = 17 and pu.iupb_id NOT IN (".$simpanUPB.")
            and ki.lDeleted = 0 and kid.lDeleted = 0 and kid.iProses_id in (17,18)"; 
        $for = $this->db_erp_pk->query($formula)->result_array();
        foreach ($for as $f) {
            $sqlCek = "SELECT fud.`iProses_id` FROM pddetail.`flow_upb` fu JOIN
                pddetail.`flow_upb_detail` fud ON fu.`iFlow_upb` = `fud`.`iFlow_upb`
                WHERE fud.`lDeleted` = 0 
                AND fu.`iupb_id` = '".$f['iupb_id']."' 
                AND fud.`iProses_id` > 23
                AND fu.`iMaster_flow` = 9 LIMIT 1";
             $cek = $this->db_erp_pk->query($sqlCek); 
             if($cek->num_rows()>0){ 
                $dt = $cek->row_array();
                if($f['is_prevProses']==$dt['iProses_id']){
                        $disolusi="N";
                        $sql18 = "SELECT fd.iFlow_uji_kimia_detail FROM pddetail.flow_uji_kimia f 
                                JOIN pddetail.flow_uji_kimia_detail fd on f.iFlow_uji = fd.iFlow_uji
                                where fd.iProses_id = 18 AND f.iFormula_process='".$f['iFormula_process']."' AND f.iFormula_process_detail='".$f['iFormula_process_detail']."' LIMIT 1 ";
                        if($this->db_erp_pk->query($sql18)->num_rows()){
                            $disolusi = "Y";
                        }  


                        if($disolusi=="N"){
                            $sql17_tampil = "SELECT fd.dFinish_time FROM pddetail.flow_uji_kimia f 
                                JOIN pddetail.flow_uji_kimia_detail fd on f.iFlow_uji = fd.iFlow_uji
                                where fd.iProses_id = 17 AND f.iFormula_process='".$f['iFormula_process']."' AND f.iFormula_process_detail='".$f['iFormula_process_detail']."' 
                                AND fd.iapproval_finish = 2 
                                and fd.dFinish_time>='".$perode1."' and fd.dFinish_time <= '".$perode2."'
                                LIMIT 1 ";
                            $que17_tampil = $this->db_erp_pk->query($sql17_tampil)->row_array();
                            if(!empty($que17_tampil['dFinish_time'])){

                                $selisih = $this->selisihnokerja($f['tglmapping'],$que17_tampil['dFinish_time']);
                                $hitungHari += $selisih;
                                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                                    <td style='border: 1px solid #dddddd;' >".$x++."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['vupb_nomor']."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['vupb_nama']."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['tKet_flow']."</td>
                                    <td style='border: 1px solid #dddddd;' >".$f['vNama_proses']."</td> 
                                    <td style='border: 1px solid #dddddd;' >".$f['tglmapping']."</td>  
                                    <td style='border: 1px solid #dddddd;' ><b>Y</b></td>  
                                    <td style='border: 1px solid #dddddd;' >".$que17_tampil['dFinish_time']."</td>  
                                    <td style='border: 1px solid #dddddd;' ><b>".$disolusi."</b></td>   
                                    <td style='border: 1px solid #dddddd;' >-</td>   
                                    <td style='border: 1px solid #dddddd;' >".$selisih."</td>  
                                  </tr>";   
                            }
                        }else{
                            $sql17_tampil = "SELECT fd.dFinish_time FROM pddetail.flow_uji_kimia f 
                                JOIN pddetail.flow_uji_kimia_detail fd on f.iFlow_uji = fd.iFlow_uji
                                where fd.iProses_id = 17 AND f.iFormula_process='".$f['iFormula_process']."' AND f.iFormula_process_detail='".$f['iFormula_process_detail']."' 
                                AND fd.iapproval_finish = 2 
                                and fd.dFinish_time>='".$perode1."' and fd.dFinish_time <= '".$perode2."'
                                LIMIT 1 ";
                            $que17_tampil = $this->db_erp_pk->query($sql17_tampil)->row_array();

                            $tam = 0;
                            if(empty($que17_tampil['dFinish_time'])){
                                $que17_tampil['dFinish_time']='NOT Approve';
                                $tam = 1;
                            }

                            $sql18_tampil = "SELECT fd.dFinish_time FROM pddetail.flow_uji_kimia f 
                                JOIN pddetail.flow_uji_kimia_detail fd on f.iFlow_uji = fd.iFlow_uji
                                where fd.iProses_id = 18 AND f.iFormula_process='".$f['iFormula_process']."' AND f.iFormula_process_detail='".$f['iFormula_process_detail']."' 
                                AND fd.iapproval_finish = 2 
                                and fd.dFinish_time>='".$perode1."' and fd.dFinish_time <= '".$perode2."'
                                LIMIT 1 ";
                            $que18_tampil = $this->db_erp_pk->query($sql18_tampil)->row_array();

                            $tam1 = 0; 
                            if(empty($que18_tampil['dFinish_time'])){
                                $que18_tampil['dFinish_time']='-';
                                $tam1 = 1;
                            }

                            if($tam!=1 && $tam1!=1){
                                $selisih1 = $this->selisihnokerja($f['tglmapping'],$que17_tampil['dFinish_time']);
                                $selisih2 = $this->selisihnokerja($f['tglmapping'],$que18_tampil['dFinish_time']); 
                                $selisih = $selisih1+$selisih2;

                                $hitungHari += $selisih;

                                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                                        <td style='border: 1px solid #dddddd;' >".$x++."</td>
                                        <td style='border: 1px solid #dddddd;' >".$f['vupb_nomor']."</td>
                                        <td style='border: 1px solid #dddddd;' >".$f['vupb_nama']."</td>
                                        <td style='border: 1px solid #dddddd;' >".$f['tKet_flow']."</td>
                                        <td style='border: 1px solid #dddddd;' >".$f['vNama_proses']."</td> 
                                        <td style='border: 1px solid #dddddd;' >".$f['tglmapping']."</td>  
                                        <td style='border: 1px solid #dddddd;' ><b>Y</b></td>  
                                        <td style='border: 1px solid #dddddd;' >".$que17_tampil['dFinish_time']."</td>  
                                        <td style='border: 1px solid #dddddd;' ><b>".$disolusi."</b></td>   
                                        <td style='border: 1px solid #dddddd;' >".$que18_tampil['dFinish_time']."</td>   
                                        <td style='border: 1px solid #dddddd;' >".$selisih."</td>  
                                      </tr>";   
                            }else{
                                if($tam==0){
                                        $sql18_tampil_1 = "SELECT fd.dFinish_time FROM pddetail.flow_uji_kimia f 
                                            JOIN pddetail.flow_uji_kimia_detail fd on f.iFlow_uji = fd.iFlow_uji
                                            where fd.iProses_id = 18 AND f.iFormula_process='".$f['iFormula_process']."' AND f.iFormula_process_detail='".$f['iFormula_process_detail']."' 
                                                AND fd.iapproval_finish = 2 
                                            LIMIT 1 ";
                                        $que18_tampil_1 = $this->db_erp_pk->query($sql18_tampil_1)->row_array(); 
                                        if(!empty($que18_tampil_1['dFinish_time'])){ 
                                            //Dihitung  

                                            $selisih1 = $this->selisihnokerja($f['tglmapping'],$que17_tampil['dFinish_time']);
                                            $selisih2 = $this->selisihnokerja($f['tglmapping'],$que18_tampil_1['dFinish_time']); 
                                            $selisih = $selisih1+$selisih2;

                                            $hitungHari += $selisih;

                                            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                                                <td style='border: 1px solid #dddddd;' >".$x++."</td>
                                                <td style='border: 1px solid #dddddd;' >".$f['vupb_nomor']."</td>
                                                <td style='border: 1px solid #dddddd;' >".$f['vupb_nama']."</td>
                                                <td style='border: 1px solid #dddddd;' >".$f['tKet_flow']."</td>
                                                <td style='border: 1px solid #dddddd;' >".$f['vNama_proses']."</td> 
                                                <td style='border: 1px solid #dddddd;' >".$f['tglmapping']."</td>  
                                                <td style='border: 1px solid #dddddd;' ><b>Y</b></td>  
                                                <td style='border: 1px solid #dddddd;' >".$que17_tampil['dFinish_time']."</td>  
                                                <td style='border: 1px solid #dddddd;' ><b>".$disolusi."</b></td>   
                                                <td style='border: 1px solid #dddddd;' >".$que18_tampil_1['dFinish_time']."</td>   
                                                <td style='border: 1px solid #dddddd;' >".$selisih."</td>  
                                              </tr>";  
                                        }else{ 
                                            //Tidak Dihitung
                                            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;' bgcolor='#ddd'>
                                                <td style='border: 1px solid #dddddd;' >".$x++."</td>
                                                <td style='border: 1px solid #dddddd;' >".$f['vupb_nomor']."</td>
                                                <td style='border: 1px solid #dddddd;' >".$f['vupb_nama']."</td>
                                                <td style='border: 1px solid #dddddd;' >".$f['tKet_flow']."</td>
                                                <td style='border: 1px solid #dddddd;' >".$f['vNama_proses']."</td> 
                                                <td style='border: 1px solid #dddddd;' >".$f['tglmapping']."</td>  
                                                <td style='border: 1px solid #dddddd;' ><b>Y</b></td>  
                                                <td style='border: 1px solid #dddddd;' >".$que17_tampil['dFinish_time']."</td>  
                                                <td style='border: 1px solid #dddddd;' ><b>".$disolusi."</b></td>   
                                                <td style='border: 1px solid #dddddd;' >-</td>   
                                                <td style='border: 1px solid #dddddd;' >-</td>  
                                              </tr>";  
                                        }
                                }else if($tam1==0){
                                        $sql17_tampil_1 = "SELECT fd.dFinish_time FROM pddetail.flow_uji_kimia f 
                                            JOIN pddetail.flow_uji_kimia_detail fd on f.iFlow_uji = fd.iFlow_uji
                                            where fd.iProses_id = 17 AND f.iFormula_process='".$f['iFormula_process']."' AND f.iFormula_process_detail='".$f['iFormula_process_detail']."' 
                                            AND fd.iapproval_finish = 2 
                                            and fd.dFinish_time>='".$perode1."' and fd.dFinish_time <= '".$perode2."'
                                            LIMIT 1 ";
                                        $que17_tampil_1 = $this->db_erp_pk->query($sql17_tampil_1)->row_array();
             
                                        if(!empty($que17_tampil_1['dFinish_time'])){ 
                                            //Dihitung  
                                            $selisih1 = $this->selisihnokerja($f['tglmapping'],$que17_tampil_1['dFinish_time']);
                                            $selisih2 = $this->selisihnokerja($f['tglmapping'],$que18_tampil['dFinish_time']); 
                                            $selisih = $selisih1+$selisih2;

                                            $hitungHari += $selisih;

                                            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                                                <td style='border: 1px solid #dddddd;' >".$x++."</td>
                                                <td style='border: 1px solid #dddddd;' >".$f['vupb_nomor']."</td>
                                                <td style='border: 1px solid #dddddd;' >".$f['vupb_nama']."</td>
                                                <td style='border: 1px solid #dddddd;' >".$f['tKet_flow']."</td>
                                                <td style='border: 1px solid #dddddd;' >".$f['vNama_proses']."</td> 
                                                <td style='border: 1px solid #dddddd;' >".$f['tglmapping']."</td>  
                                                <td style='border: 1px solid #dddddd;' ><b>Y</b></td>  
                                                <td style='border: 1px solid #dddddd;' >".$que17_tampil_1['dFinish_time']."</td>  
                                                <td style='border: 1px solid #dddddd;' ><b>".$disolusi."</b></td>   
                                                <td style='border: 1px solid #dddddd;' >".$que18_tampil['dFinish_time']."</td>   
                                                <td style='border: 1px solid #dddddd;' >".$selisih."</td>  
                                              </tr>";  
                                        }else{ 
                                            //Tidak DIhitung
                                            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;' bgcolor='#ddd'>
                                                <td style='border: 1px solid #dddddd;' >".$x++."</td>
                                                <td style='border: 1px solid #dddddd;' >".$f['vupb_nomor']."</td>
                                                <td style='border: 1px solid #dddddd;' >".$f['vupb_nama']."</td>
                                                <td style='border: 1px solid #dddddd;' >".$f['tKet_flow']."</td>
                                                <td style='border: 1px solid #dddddd;' >".$f['vNama_proses']."</td> 
                                                <td style='border: 1px solid #dddddd;' >".$f['tglmapping']."</td>  
                                                <td style='border: 1px solid #dddddd;' ><b>Y</b></td>  
                                                <td style='border: 1px solid #dddddd;' >-</td>  
                                                <td style='border: 1px solid #dddddd;' ><b>".$disolusi."</b></td>   
                                                <td style='border: 1px solid #dddddd;' >".$que18_tampil['dFinish_time']."</td>   
                                                <td style='border: 1px solid #dddddd;' >-</td>  
                                              </tr>";  
                                        }
                                }
                            }
                        } 
                }
             }
        }

        $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;' bgcolor='#eee'>
                                                <td style='border: 1px solid #dddddd; ' colspan='10'>Total Selisih Hari</td>
                                                <td style='border: 1px solid #dddddd;' >".$hitungHari." (Hari)</td> 
                                              </tr>"; 
        if($hitungHari==0){
            $total = 0;
        }else{
            $total = number_format($hitungHari/22,2);
        }
        $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;' bgcolor='#eee'>
                                                <td style='border: 1px solid #dddddd; ' colspan='10'>Total Selisih Bulan (/22)</td>
                                                <td style='border: 1px solid #dddddd;' >".$total." (Bulan)</td> 
                                              </tr>"; 
  
        $result     = $total;
        $getpoint = $this->getPoint($result, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

            
        
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    } 

    function ANDEV_LOKAL_05($post) {
        $noRow = 0;
        $totalJamAll = 0;
        $totalReqAll = 0;
        $tmpData = array();
        $totalJam = 0;
        $iAspekId = $post['_iAspekId'];
        $cNipNya = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $data_nip = array();
        $data_container = array();
        $data_stored = array();

        $debug = 0;
        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td> 
                    </tr>
                </table>";  
        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center; padding: 5px;'>
                    <td style='border: 1px solid #dddddd;' rowspan='2' ><b>No</b></td>
                    <td style='border: 1px solid #dddddd;' rowspan='2' ><b>Nomor UPB</b></td>
                    <td style='border: 1px solid #dddddd;' rowspan='2' ><b>Nama UPB</b></td>
                    <td style='border: 1px solid #dddddd;' rowspan='2' ><b>Tanggal Approve<br>Setting Prioritas</b></td>
                    <td style='border: 1px solid #dddddd;' colspan='3' ><b>Tanggal Approve BB</b></td> 
                    <td style='border: 1px solid #dddddd;' colspan='3' ><b>Tanggal Approve FG</b></td> 
                </tr>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <td style='border: 1px solid #dddddd;' ><b>Draft SOI (X1)</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Validasi MOA (Y1)</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Selisih</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Draft SOI (X2)</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Validasi MOA (Y2)</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Selisih</b></td>
                </tr>
            ";
 
        
       $sql= "SELECT u.iupb_id, u.vupb_nomor, u.vupb_nama, vbb.dapppd AS app_moa_bb, bb.dApproval, vfg.dapppd AS app_moa_fg, fg.dApproval_draftsoi,
                #hitung selisih bb dan fg
                ABS(DATEDIFF(vbb.dapppd, bb.dApproval)) AS selisih_bb, ABS(DATEDIFF(vfg.dapppd, fg.dApproval_draftsoi)) AS selisih_fg,
                 (SELECT (IF(p.tappdir IS NOT NULL AND p.tappdir <> '0000-00-00 00:00:00' AND p.iappdir = 1, p.tappdir,p.tappbusdev)) AS appr_prioritas
                     FROM plc2.plc2_upb_prioritas p 
                     JOIN plc2.plc2_upb_prioritas_detail d ON p.iprioritas_id = d.iprioritas_id
                     WHERE d.iupb_id = u.iupb_id ORDER BY p.iprioritas_id ASC LIMIT 1) AS appr_prioritas 
                FROM plc2.plc2_upb u 
                JOIN plc2.plc2_vamoa vbb ON u.iupb_id = vbb.iupb_id
                JOIN plc2.plc2_vamoa_fg vfg ON u.iupb_id = vfg.iupb_id
                JOIN plc2.draft_soi_bb bb ON u.iupb_id = bb.iupb_id
                JOIN plc2.plc2_upb_fg fg ON u.iupb_id = fg.iupb_id
                WHERE u.ldeleted = 0 
                    AND vbb.lDeleted = 0 AND vbb.iapppd = 2 AND vbb.dapppd IS NOT NULL AND vbb.dapppd <> '0000-00-00 00:00:00'
                    AND bb.lDeleted = 0 AND bb.iApprove = 2 AND bb.dApproval IS NOT NULL AND bb.dApproval <> '0000-00-00 00:00:00'
                    AND vfg.lDeleted = 0 AND vfg.iapppd = 2 AND vfg.dapppd IS NOT NULL AND vfg.dapppd <> '0000-00-00 00:00:00'
                    AND fg.lDeleted = 0 AND fg.iApprove_draftsoi = 2 AND fg.dApproval_draftsoi IS NOT NULL AND fg.dApproval_draftsoi <> '0000-00-00 00:00:00'
                    #cek apakah sudah pernah di setting priorotas
                    AND (SELECT COUNT(*) FROM plc2.plc2_upb_prioritas_detail d
                                JOIN plc2.plc2_upb_prioritas pr ON d.iprioritas_id = pr.iprioritas_id
                                WHERE d.iupb_id = u.iupb_id AND d.ldeleted = 0 AND pr.ldeleted = 0 
                                    AND pr.iappbusdev = 2 AND pr.tappbusdev IS NOT NULL 
                                    AND pr.tappbusdev <> '0000-00-00 00:00:00') > 0
                    AND DATE(vfg.dapppd) BETWEEN ? AND ?
                    AND DATE(vbb.dapppd) BETWEEN ? AND ?
                    ORDER BY u.iupb_id ASC"; 

        // $sql = "SELECT upb.*, u.vupb_nomor, u.vupb_nama,
        //         (SELECT (IF(p.tappdir IS NOT NULL AND p.tappdir <> '0000-00-00 00:00:00' AND p.iappdir = 1, p.tappdir,p.tappbusdev)) AS appr_prioritas
        //             FROM plc2.plc2_upb_prioritas p 
        //             JOIN plc2.plc2_upb_prioritas_detail d ON p.iprioritas_id = d.iprioritas_id
        //             WHERE d.iupb_id = upb.iupb_id ORDER BY p.iprioritas_id ASC LIMIT 1) AS appr_prioritas 
        //         FROM (
        //             SELECT fg.iupb_id, v.dapppd, fg.dApproval_draftsoi, '-' AS dApproval, v.dapppd AS app_moa_fg, '-' AS app_moa_bb,
        //                     ABS(DATEDIFF(v.dapppd, fg.dApproval_draftsoi)) AS selisih_fg, '-' AS selisih_bb
        //                 FROM plc2.plc2_upb_fg fg
        //                 JOIN plc2.plc2_vamoa_fg v ON fg.iupb_id = v.iupb_id
        //                 WHERE fg.lDeleted = 0 AND v.lDeleted = 0
        //                     AND fg.iApprove_draftsoi = 2 AND fg.dApproval_draftsoi IS NOT NULL 
        //                     AND fg.dApproval_draftsoi <> '0000-00-00 00:00:00'
        //                     AND v.iapppd = 2 AND v.dapppd IS NOT NULL
        //                     AND v.dapppd <> '0000-00-00 00:00:00'
        //             UNION
        //             SELECT bb.iupb_id, v.dapppd, '-' AS dApproval_draftsoi, bb.dApproval, '-' AS app_moa_fg, v.dapppd AS app_moa_bb, 
        //                     '-' AS selisih_fg, ABS(DATEDIFF(bb.dApproval, v.dapppd)) AS selisih_bb
        //                 FROM plc2.draft_soi_bb bb
        //                 JOIN plc2.plc2_vamoa v ON bb.iupb_id = v.iupb_id
        //                 WHERE bb.lDeleted = 0 AND v.lDeleted = 0
        //                     AND bb.iApprove = 2 AND bb.dApproval IS NOT NULL
        //                     AND bb.dApproval <> '0000-00-00 00:00:00'
        //                     AND v.iapppd = 2 AND v.dapppd IS NOT NULL
        //                     AND v.dapppd <> '0000-00-00 00:00:00'
        //         ) AS upb
        //             JOIN plc2.plc2_upb u ON upb.iupb_id = u.iupb_id
        //             WHERE u.ldeleted = 0 
        //                 AND DATE(upb.dapppd) BETWEEN ? AND ?
        //                 AND (SELECT COUNT(*) FROM plc2.plc2_upb_prioritas_detail d
        //                             JOIN plc2.plc2_upb_prioritas pr ON d.iprioritas_id = pr.iprioritas_id
        //                             WHERE d.iupb_id = upb.iupb_id AND d.ldeleted = 0 AND pr.ldeleted = 0 
        //                                 AND pr.iappbusdev = 2 AND pr.tappbusdev IS NOT NULL 
        //                                 AND pr.tappbusdev <> '0000-00-00 00:00:00') > 0
        //             ORDER BY upb.dapppd DESC";

        $arrPeriode = array($perode1, $perode2, $perode1, $perode2);
   
        $batch = $this->db_erp_pk->query($sql, $arrPeriode)->result_array(); 
        $x = 0 ;   
        $selisih_fg = 0;
        $selisih_bb = 0;
        foreach ($batch as $b) {  
             $x++;
             if (fmod($x,2)==0){
                    $color = 'background-color: #eaedce;';
                }else{
                    $color = '';
                }
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse; text-align: left; ".$color." '>
                        <td style='border: 1px solid #dddddd;' >".$x."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['vupb_nomor']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['vupb_nama']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['appr_prioritas']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['dApproval']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['app_moa_bb']."</td>   
                        <td style='border: 1px solid #dddddd;' >".$b['selisih_bb']."</td> 
                        <td style='border: 1px solid #dddddd;' >".$b['dApproval_draftsoi']."</td>   
                        <td style='border: 1px solid #dddddd;' >".$b['app_moa_fg']."</td> 
                        <td style='border: 1px solid #dddddd;' >".$b['selisih_fg']."</td>  
                      </tr>";  
            $selisih_fg += ($b['selisih_fg']=='-')?0:$b['selisih_fg'];
            $selisih_bb += ($b['selisih_bb']=='-')?0:$b['selisih_bb'];
        } 
        $html .= "<tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center; padding: 5px;'>
                        <td style='border: 1px solid #dddddd;' colspan='6' ><b>Total Hari</b></td>
                        <td style='border: 1px solid #dddddd;' >".$selisih_bb."</td> 
                        <td style='border: 1px solid #dddddd;' colspan='2' ><b></td>
                        <td style='border: 1px solid #dddddd;' >".$selisih_fg."</td> 
                      </tr>"; 
        $html .= "</table>";
        $html .= "<br /> ";   
       
        $result     = number_format(($selisih_fg + $selisih_bb) / 22, 2);
        $getpoint = $this->getPoint($result, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 50%;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>".$vAspekName."</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>( ".$selisih_bb." + ".$selisih_fg." ) / 22</td>
                    </tr>   
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Bulan</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan</td>
                    </tr> 
                </table>";      
        
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }
 
}
?>