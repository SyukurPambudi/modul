<?php

class lib_pk_ad1_man_462
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
        $date1 = new DateTime($perode1);
        $date2 = new DateTime($perode2);

        $diff = $date1->diff($date2);
        $bulan = (($diff->format('%y') * 12) + $diff->format('%m')) + 1;

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
    /*===============Start Function=======================*/ 
    function PK_AD1_MAN_462_01($post)    {
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
        $iAspekId = $post['_iAspekId'];
        $cNipNya  = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1  = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];

        $dPeriode2  = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2']."-".$x_prd2['1']."-".$x_prd2['0'];

        $jenis = array(1=>'UM',2=>'Claim');

        $bulan = $this->hitung_bulan($perode1,$perode2);
        
        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='".$iAspekId."'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;
          $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                        
                    </tr>
                </table>";
        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>No UPD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama Usulan </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Jenis Standar Dokumen</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Team Andev</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Submit CK3</b></td>
            </tr>
        ";


        //Kategory A
        $sql2 ="select u.*,r.iKelengkapan_data3,r.iSubmit_kelengkapan3,r.dCek_kelengkapan3,j.vjenis_dok,te.vteam
                from dossier.dossier_upd u
                join dossier.dossier_review r on r.idossier_upd_id=u.idossier_upd_id
                join dossier.dossier_standar_dok s on u.istandar_dok_id=s.istandar_dok_id
                join dossier.dossier_jenis_dok j on s.ijenis_dok_id=j.ijenis_dok_id
                join plc2.plc2_upb_team te on te.iteam_id=u.iTeam_andev
                where
                u.lDeleted=0 and r.lDeleted=0 and s.lDeleted=0 and j.lDeleted=0 #status deleted
                and u.is_old=0 #data baru
                and u.iTeam_andev=17 #Team Andev 1
                and j.ijenis_dok_id in (6,3) #Jenis UPD EUCTD solid dan EUCTD steril
                and r.iKelengkapan_data3=2 and r.iSubmit_kelengkapan3=1 and r.dCek_kelengkapan3 is not null
                and r.dCek_kelengkapan3 >= '".$perode1."'
                and r.dCek_kelengkapan3 <= '".$perode2."'
                group by u.idossier_upd_id
                ";
        $b = $this->db_erp_pk->query($sql2)->result_array();
        $no = 1;
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }
                
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'> 
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$no."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['vUpd_no']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['vNama_usulan']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['vjenis_dok']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['vteam']."</td> 
                            <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>".$v['dCek_kelengkapan3']."</td> 
                          </tr>"; 
                $no++;
            }

        } 

        $html .="</table>";
        $hasil_b       = $this->db_erp_pk->query($sql2)->num_rows();
        
        $result     = number_format($hasil_b,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>                   

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Usulan</td>
                  
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result."</b></td>
                    </tr>
                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function PK_AD1_MAN_462_02($post)    {
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
        $iAspekId = $post['_iAspekId'];
        $cNipNya  = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1  = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];

        $dPeriode2  = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2']."-".$x_prd2['1']."-".$x_prd2['0'];

        $jenis = array(1=>'UM',2=>'Claim');

        $bulan = $this->hitung_bulan($perode1,$perode2);
        
        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='".$iAspekId."'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;
          $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                        
                    </tr>
                </table>";
        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>No UPD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama Usulan </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Jenis Standar Dokumen</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Team Andev</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Submit CK3</b></td>
            </tr>
        ";


        //Kategory A
        $sql2 ="select u.*,r.iKelengkapan_data3,r.iSubmit_kelengkapan3,r.dCek_kelengkapan3,j.vjenis_dok,te.vteam 
                from dossier.dossier_upd u
                join dossier.dossier_review r on r.idossier_upd_id=u.idossier_upd_id
                join dossier.dossier_standar_dok s on u.istandar_dok_id=s.istandar_dok_id
                join dossier.dossier_jenis_dok j on s.ijenis_dok_id=j.ijenis_dok_id
                join plc2.plc2_upb_team te on te.iteam_id=u.iTeam_andev
                where
                u.lDeleted=0 and r.lDeleted=0 and s.lDeleted=0 and j.lDeleted=0 #status deleted
                and u.is_old=0 #data baru
                and u.iTeam_andev=17 #Team Andev 1
                and j.ijenis_dok_id not in (6,3) #Jenis bukan UPD EUCTD solid dan EUCTD steril
                and r.iKelengkapan_data3=2 and r.iSubmit_kelengkapan3=1 and r.dCek_kelengkapan3 is not null
                and r.dCek_kelengkapan3 >= '".$perode1."'
                and r.dCek_kelengkapan3 <= '".$perode2."'
                group by u.idossier_upd_id
                ";
        $b = $this->db_erp_pk->query($sql2)->result_array();
        $no = 1;
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }
                
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'> 
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$no."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['vUpd_no']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['vNama_usulan']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['vjenis_dok']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['vteam']."</td> 
                            <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>".$v['dCek_kelengkapan3']."</td> 
                          </tr>"; 
                $no++;
            }

        } 

        $html .="</table>";
        $hasil_b       = $this->db_erp_pk->query($sql2)->num_rows();
        
        $result     = number_format($hasil_b,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>                   

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Usulan</td>
                  
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result."</b></td>
                    </tr>
                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }
}
?>