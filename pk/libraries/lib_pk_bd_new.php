<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class lib_pk_bd_new
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

    function getDurasiBulan($start, $end ){
       if($start > $end){
            $start1= $start ;
            $end=$start;
            $start=$start1;

        }

        $date1  = $start;
        $awal   = substr($date1, 0,7);
        $date2  = $end;
        $akhir  = substr($date2, 0,7);

        $output = array();
        $time   = strtotime($date1);
        $last   = date('m-Y', strtotime($date2));
        
        do{
            $akhir_bulan = date('Y-m-t', $time);
            $awal_bulan = date('Y-m-01', $time);
            $bulan = date('Y-m', $time);
            $month = date('m-Y', $time);
            $total = date('t', $time);

            $output[] = array(
                'awal_bulan' => $awal_bulan,
                'akhir_bulan' => $akhir_bulan,
                'month' => $month,
                'bulan' => $bulan,
                'total' => $total,
            );

            $time = strtotime('first day of +1 month', $time);
            
        } while ($month != $last);

        $bulanKoma = 0;
        $i = 1;
        foreach ($output as $data ) {
            
            if ($data['bulan'] == $awal) {
                $startTanggal       = strtotime($date1);
                $lastDateOfMonth = strtotime($data['akhir_bulan']);
                $firstDateOfMonth = strtotime($data['awal_bulan']);
                
                //$lama        = $startTanggal - $firstDateOfMonth;
                $lama        = $lastDateOfMonth -  $startTanggal;
                $lamaHari = floor($lama / (60 * 60 * 24))+1;

                $selisih = number_format(($lamaHari/$data['total']),2);
                $bulanKoma += number_format(($lamaHari/$data['total']),2);

            }else if($data['bulan'] == $akhir){

                $EndTanggal       = strtotime($date2);
                $firstDateOfMonth = strtotime($data['awal_bulan']);
                $lama        = $EndTanggal - $firstDateOfMonth;

                $lamaHari = floor($lama / (60 * 60 * 24))+1;

                $selisih = number_format(($lamaHari/$data['total']),2);
                $bulanKoma += number_format(($lamaHari/$data['total']),2);

                
            }else{
                $lamaHari = $data['total'];
                $selisih = number_format(($lamaHari/$data['total']),2);
                $bulanKoma += number_format(($lamaHari/$data['total']),2);
            }

            $i++;
            
        }

        return $bulanKoma;

    }


    /* function datediff($tgl1, $tgl2, $cNip) */
    function datediff($tglAwal, $tglAkhir, $nip, $type = "day")
    {
        /* $sql = "SELECT iCompanyId FROM hrd.employee WHERE cNip='" . $cNip . "' ";
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
        } */


        /* Modify */
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
    /*===============Start Function Softdev Manager=======================*/

    //==============================End Function PK Technical writer======================================

    //============================Ini tempat Funtion function tambahan=====================================
    function getInferior($superior = '', $type = '1', $datecustom = false)
    {
        $CI =& get_instance();
        //$MIS_MANAGER = $CI->session->userdata('mis_manager');
        $arrProperties = array();
        if (!$superior) return false;
        //if(in_array($superior)) {
        $arrProperties[] = $superior;
        //}

        $bawahan = $this->get_child($superior, $datecustom);
        $bawExp = explode(",", $bawahan);
        $arrayBawahan = array();
        foreach ($bawExp as $b) {
            if (strlen($b) > 3) {
                if (!in_array($b, $arrProperties)) {
                    if ($type == '1') {
                        $arrProperties[] = $b;
                    } else {
                        $properties = $this->get_properties($b);
                        $exp = explode('^', $properties);
                        $a1 = array('nip' => $b, 'nama' => capital_name($exp[1], '1'), 'iPostId' => $exp[6]);
                        array_push($arrProperties, $a1);
                    }
                }
            }
        }
        return $arrProperties;
    }

    function get_child($nip, $datecustom = false, $monthyear = false)
    {

        $CI =& get_instance();
        $this->db_erp_pk = $this->_ci->load->database('pk',false, true);
        $r = $this->get_childs($nip, $datecustom, $monthyear);
        $today = ($datecustom) ? "$datecustom" : "" . date("Y-m-d") . "";
        $child = '';
        foreach ($r as $v) {
            if ($monthyear) {
                $date1 = date('Y-m-01', strtotime($today));
                $date2 = date('Y-m-t', strtotime($today));
                $active = (($v['dResign'] >= $date1 && $v['dResign'] <= $date2) || $v['dResign'] == '0000-00-00');
            } else {
                $active = ($v['dResign'] == '0000-00-00' || $v['dResign'] >= $today);
            }

            if ($active) $child = $child . $v['cNip'] . ',';
            if ($v['child']) $child .= $this->get_child($v['cNip'], $datecustom, $monthyear);
        }
        return $child;
    }

    function get_childs($nip, $date = false, $monthyear = false)
    {
        $sql = "SELECT e.cNip, e.dResign, (SELECT COUNT(cNip) FROM employee WHERE cUpper=e.cNip) AS child
				  FROM employee e
					  WHERE e.cUpper='$nip'";

        return $this->db_erp_pk->query($sql)->result_array();
    }

    function generatePO($post)
    {
        $iMsGroupAspekId = $post['_iMsGroupAspekId'];
        $cNipNya = $post['_cNipNya'];
        $iPkTransId = $post['_iPkTransId'];
        $iSkemaId = $post['_iSkemaId'];

        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];
        $periode1 = $x_prd1['2'] . $x_prd1['1'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];
        $periode2 = $x_prd2['2'] . $x_prd2['1'];

        $cTahun =   $post['cTahun'];
        $iSemester = $post['iSemester'];

        $sql = "select " . $iMsGroupAspekId . " as iMsGroupAspekId,a.iSizeProject,
                    CONCAT(a.id,' - ',a.problem_subject) AS vAspekName,
                1 as lAutoCalculation, 'generateDetail' as vFunctionLink, 0 AS iparameter_id, 0  AS nBobot,a.id as ssid
                from hrd.ss_raw_problems a
                inner join hrd.ss_raw_pic b on b.rawid = a.id and b.pic = '$cNipNya' and b.iRoleId =1
                where cSemester= '$iSemester' and cTahun = '$cTahun'
                and a.id not in(SELECT LEFT(vAspekName,6) from hrd.pk_aspek_dynamic)
                and a.crPrior <> 1
                GROUP BY CONCAT(a.problem_subject,' (',a.id,')') ";

        $b = $this->db_erp_pk->query($sql)->result_array();

        $nSize = 0;
        if (!empty($b)) {
            foreach ($b as $v) {
                $nSize += $v['iSizeProject'];
            }
        }
        $no = 1;
        if (!empty($b)) {
            foreach ($b as $v) {
                $date = date("Y-m-d H:i:s");
                $nBobot = ( $v['iSizeProject']/$nSize)*100;
                $sql_po = "INSERT INTO hrd.pk_aspek_dynamic(iSkemaId, iMsGroupAspekId, iUrut, vAspekName, nBobot, iPkTransId, lAutoCalculation, vFunctionLink)
                            VALUES ('" . $iSkemaId . "','" . $iMsGroupAspekId . "','" . $no . "','" . $v['vAspekName'] . "','" . $nBobot . "','" . $iPkTransId . "','1','generateDetail')";

                $this->db_erp_pk->query($sql_po);
                $insert_id = $this->db_erp_pk->insert_id();

                $sql1 = "select * from hrd.pk_po_deskripsi ";
                $dtni = $this->db_erp_pk->query($sql1)->result_array();

                foreach ($dtni as $key => $val) {
                    $vDescription = $val['deskripsi'];
                    $yNilai1 = $val['yNilai1'];
                    $yNilai2 = $val['yNilai2'];
                    $nPoint = $val['poin'];

                    $sql_po = "INSERT INTO hrd.pk_aspek_dynamic_detail(iAspekId, vDescription, nPoint, yNilai1, yNilai2,
                          cCreatedBy,tCreated) VALUES('" . $insert_id . "','" . $vDescription . "','" . $nPoint . "',
                          '" . $yNilai1 . "','" . $yNilai2 . "','Auto','" . $date . "')";
                    $this->db_erp_pk->query($sql_po);
                }
                $no++;
            }
        }
    }

   function generateDetail($post)
    {
        $iAspekId = $post['_iAspekId'];
        $cNipNya = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];

        $jenis = array(1 => 'UM', 2 => 'Claim');

        $bulan = $this->hitung_bulan($perode1, $perode2);

        //cari aspek dulu
        $sql = "SELECT vAspekName, LEFT(vAspekName,6)ssid FROM hrd.pk_aspek_dynamic WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;
        $vSsid = $query->row()->ssid;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";

        $sqlmain = "Select dTarget_implement,date(dcloseGm) dcloseGm, iStatus  from hrd.ss_raw_problems where id =".$vSsid;
        $qsqlmain = $this->db_erp_pk->query($sqlmain);
        $tglawal = '';
        $tglakhir = '';
		if($qsqlmain->num_rows>=1){
			$dtmain=$qsqlmain->result_array();
			foreach ($dtmain as $kmain => $vmain) {
				$tglawal =  $vmain['dTarget_implement'];
   	            $tglakhir =  $vmain['dcloseGm'];
                $iStatus = $vmain['iStatus'];
			}
        }

        $html .= "</table>";

        if($iStatus == 13){
            $hasil=$this->selisihHari($tglawal, $tglakhir, $cNipNya);
        }else{
            $hasil= '999';
        }

        $result = $hasil;

        $getpoint = $this->getPointDynamic($result, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $final = ($iStatus == 13 ? $result.' Hari' : 'Oh no you havent finishing this project!!!');

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 400px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Tgl. Target Selesai Project:</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $tglawal . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Tgl. Actual Selesai Project:</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $tglakhir . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Selisih:</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" .$final. "</b></td>
                    </tr>

                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }

    function showWeeklySchedule($nip, $dStart, $dEnd, $debug = 0,$pk = 0) {
        $dayCount = 0;
        $hasWeeklyScheduleCount = 0;

        $workDays = $this->getWorkDay($nip);
        $date = $dStart;
        while ($date < $dEnd) {
            while ($this->isOff($nip, $workDays, $date)) {
                $date = date('Y-m-d', strtotime($date.' +1 days'));
            }
            $dayCount++;
            $dUpTo = $this->getScheduleEndDate($nip, $date);

            $q = $this->getScheduleQuery($nip, $date, $dUpTo);

            $data = Array();
            $result = mysql_query($q) or die(mysql_error()."</br>".$q);
            while ($row = mysql_fetch_assoc($result)) {
                array_push($data, $row);
            }

            $rowCount = count($data);
            $hasSchedule = $this->hasSchedule($data, $debug);

            if ($hasSchedule) {
                $hasWeeklyScheduleCount++;
                if($debug>0) {
                    echo "</br>&gt; Has weekly work schedule:</br>";
                    echo "<table border=1><tr><th>Date</th><th>Duration</th><th>Schedule Frequency</th><th>ID</th><th>Subject</th></tr>";
                    for ($i = 0; $i < $rowCount; $i++) {
                        echo "<tr><td>" . $data[$i]['dDate'] . "</td>
                        <td>" . $data[$i]['yDuration2'] . "</td>
                        <td>" . $data[$i]['iScheduleFreq'] . "</td>
                        <td>" . $data[$i]['iSSID'] . "</td>
                        <td>" . $data[$i]['problem_subject'] . "</td></tr>";
                    }
                    echo "</table>";
                }
            } else
                if($debug>0) {
                    echo "</br>&gt; No weekly work schedule</br>";
                    echo "</br>";
                }


            $date = date('Y-m-d', strtotime($date.' +1 days'));
        }
        echo "</br>Weekly work schedule for ".$dStart. " to " .$dEnd. ":";
        echo "</br>NIP: ".$nip;
        echo "</br>Total normal working days : " . number_format($dayCount);
        echo "</br>Total days that have weekly work schedule : " . number_format($hasWeeklyScheduleCount);
        echo "</br>Percentage having weekly work schedule : " . number_format($hasWeeklyScheduleCount / $dayCount * 100) . "%";

        if($pk){
            $return = array('dayCount'=>$dayCount,'hasWeeklyScheduleCount'=>$hasWeeklyScheduleCount);
            return $return;
        }
    }
    private function getScheduleEndDate($nip, $dateStart) {
        $workDay = $this->getWorkDay($nip);
        $workDayCounter = 0;
        $endDate = $dateStart;
        while ($workDayCounter<5) {
           $endDate = date('Y-m-d', strtotime($endDate.' +1 days'));
           if (!($this->isOff($nip, $workDay, $endDate))) {
               $workDayCounter++;
           }
        }
        return $endDate;
    }
    private function isOff($nip, $workDay, $date) {
        if (date("w", strtotime($date))==0) { // Sunday
            return "Sunday";
        } else {
            if ($workDay==5 && date("w", strtotime($date))==6) {
                return "Saturday";
            } else {
                $sql = "SELECT *
                        FROM (SELECT h.cdescription AS vDesc
                              FROM hrd.holiday h
                              WHERE h.ddate='$date' AND h.bDeleted=0
                              UNION ALL
                              SELECT h2.vDescription AS vDesc
                              FROM hrd.compholiday h2
                              WHERE h2.dDate='$date' AND h2.ldeleted=0
                              UNION ALL
                              SELECT c.vketreq AS vDesc
                              FROM hrd.cuti c
                              WHERE c.dcuti='$date' AND c.ldeleted=0 AND c.cnip LIKE '$nip') AS daysOff
                        LIMIT 1";
                $fld = mysql_fetch_assoc(mysql_query($sql));
                return ($fld['vDesc'] ? $fld['vDesc'] : 0);
            }
        }
    }
    private function getScheduleQuery($nip, $from, $to){
        $q = "SELECT x.dDate, x.iSSID, x.iScheduleType, x.iScheduleFreq, x.yDuration2, r.problem_subject
              FROM hrd.ss_task_scheduling_detail x
              INNER JOIN (
                  SELECT *
                  FROM (
                      SELECT w.iSSID, w.cPIC, w.iScheduleType, w.iScheduleFreq, w.tCreatedAt
                      FROM hrd.ss_task_scheduling w
                      WHERE LEFT(w.tCreatedAt,10) <= '$from' AND w.cPIC LIKE '$nip' AND
                        w.tApproved2 IS NOT NULL AND w.iScheduleType IN (3,4,5)
                      ORDER BY w.iSSID, w.iScheduleType, w.iScheduleFreq DESC
                  ) h
                  GROUP BY iScheduleType, iSSID
              ) h
              ON x.iSSID=h.iSSID AND x.cPIC=h.cPIC AND x.iScheduleType=h.iScheduleType AND x.iScheduleFreq=h.iScheduleFreq,
              hrd.ss_raw_problems r
              WHERE x.dDate > '$from' AND x.dDate <= '$to' AND x.yDuration2>0 AND r.id=x.iSSID
              ORDER BY x.dDate, x.iSSID, x.iScheduleFreq DESC";
        return $q;
    }
    private function hasSchedule($data, $debug=0) {
        $hasSchedule = true;
        $rowCount = count($data);
        $dayCount = 0;
        if ($rowCount>=5) {
            $i = 0;
            while ($i<$rowCount) {
                $duration = 0;
                $tDate = $data[$i]['dDate'];
                $dayCount++;
                while ($i<$rowCount && $tDate==$data[$i]['dDate']) {
                    $duration += $data[$i]['yDuration2'];
                    $i++;
                }
                if ($debug) echo "</br>$tDate, duration = $duration</br>";
                if ($duration<4) {
                    $hasSchedule = false;
                    break;
                }
            }
            if ($dayCount<5) $hasSchedule=false;
        } else
            $hasSchedule = false;
        return $hasSchedule;
    }
    function getActIncentive($cNipNya,$ssid,$period1,$period2,$dataict){
        $sql = "select a.cPic,e.vAlias, a.iRawId, a.vGrpActivityName, a.iFinalIncentive
                from hrd.ss_ict_temp a
            left outer join hrd.ss_raw_problems b on a.iRawId = b.id
            left outer join hrd.employee e on a.cPic = e.cNip
                where a.cPeriod >= '$period1'   and iModuleSize > 0 and eIsCheck = 'Y'
                and a.cPic = '$cNipNya'
                group by a.cPic,e.vAlias, a.iRawId order by a.cPic,a.iRawId" ;

        $rows= $this->db_erp_pk->query($sql)->result_array();;

        $z = 0;
        $incentive = 0;
        if (!empty($rows)) {
            foreach ($rows as $d) {
                $id = $d['iRawId'];
                $pic = $d['cPic'];
                $projectId = $this->getHighestParent($id);
                if($projectId == $ssid){
                    if($projectId != $id){
                        $incentive += $d['iFinalIncentive'];
                    }
                }

            }
        }
        $ict = ($incentive/ $dataict)*100;

        return $ict;
    }
    function nip_exists($cnip, $array) {
        $result = -1;
        for($t=0; $t<sizeof($array); $t++) {
            if ($array[$t]['cnip'] == $cnip) {
                $result = $t;
                break;
            }
        }
        return $result;
    }
	function getHighestParent($childId){
		// mendapatkan top parent dari lower child
		$CI=& get_instance();
		$ret = 0;
		$destId = $childId;
		$ret = $childId;
		do{
			$balik = "F";
			$result = $this->breakdown_getHighestParent($destId);
			if($result){
				$ret = $result['id'];
				$destId = $ret;
				if($result['parent_id'] == 0){
					$balik = "T";
					break;
				}
			}else{
				$balik = "T";
				break;
			}
		}while($balik == "F");
		return $ret;
	}
	function breakdown_getHighestParent($childId){
		$sql = "SELECT id, parent_id FROM hrd.ss_raw_problems WHERE Deleted='No' AND id =
            (SELECT parent_id FROM hrd.ss_raw_problems WHERE id='$childId')";
		return $this->db_erp_pk->query($sql)->row_array();
	}
    function getIncentiveProject($ssid,$period1){
        $sql = "select a.cPic, a.iRawId, a.vGrpActivityName, a.iFinalIncentive
                    from hrd.ss_ict_temp a
                left outer join hrd.ss_raw_problems b on a.iRawId = b.id
                    where a.cPeriod >= '$period1' and iModuleSize > 0 and eIsCheck = 'Y'
                    group by a.cPic, a.iRawId order by a.cPic,a.iRawId" ;

        $rows= $this->db_erp_pk->query($sql)->result_array();
        $dataict = 0;
        if (!empty($rows)) {
            foreach ($rows as $d) {
                $id = $d['iRawId'];
                $projectId = $this->getHighestParent($id);
                if($projectId == $ssid){
                    if($projectId != $id){
                        $dataict +=$d['iFinalIncentive'];
                    }
                }

            }
        }
        return $dataict;
    }
    function prosesHitPrg8( $data_stored = array() ) {
    	$hasil = 0;
    	$arrTotal=array();//array total
    	$c_nip = count( $data_stored );//data nip

    	$data_tepat = 0;
    	$data_all = 0;

    	foreach( $data_stored as $nip => $raws ) {
    		$data_all = count($data_stored[$nip]);//data seluruhnya
    		$data_tepat = 0;//data tepat waktu
    		$data_telat = 0;//data telat waktu

    		foreach( $raws as $raw_id => $data ) {
    			$est_finish = strtotime( $data['est_finish'] );
    			$act_finish = strtotime( $data['act_finish'] );
    			$act_start = strtotime( $data['act_start'] );
    			$date_posted = strtotime( $data['date_posted'] );

    			/* Code review note by Eddy: Untuk task yang tidak ada estimasinya, harusnya tidak diperhitungkan sebagai ada
    			 * estimasi. Kode program di bawah ini harusnya tidak jadi masalah juga karena pada query datanya sendiri,
    			 * yaitu pada pk_model/hitungPrg8, query sudah memfilter out estimated_finish yang isi-nya kosong.
    			 *
    			 * Yang menjadi pertimbangan adalah apakah perlu dibuat agar meng-exclude-kan task yang diestimasikan selesai
    			 * pada hari yang sama dengan dilakukan-nya estimasi.
    			*/
    			if(empty($est_finish) or trim($est_finish) == '') {
    				if($act_start == $act_finish) {
    					$est_finish = $act_finish;
    				}
    				else {
    					$est_finish = $date_posted;
    				}
    			}

    			if( $act_finish <= $est_finish ) {
    				$data_tepat++;
    			}else {
    				$data_telat++;
    			}
    		}
    	}
    	$hasil = array('data_tepat' => $data_tepat, 'data_all' => $data_all);
    	return $hasil;

    }
    private function getWorkDay($nip) {
        $sql = "SELECT s.iWorkDay
                FROM hrd.hshift s, hrd.employee e
                WHERE e.cNIP like '$nip' AND e.igshiftid=s.igshiftid
                LIMIT 1";
        $result = mysql_query($sql);
        $row = mysql_fetch_row($result);
        return $row[0];
    }
	function getJamKerja($iShiftID){
		$sql = "SELECT iDays hari, ciIn masuk, ciEnd keluar FROM hrd.dshift WHERE iShiftID=$iShiftID ORDER BY hari";
		return $this->db_erp_pk->query($sql)->result_array();
	}
    function addDay($tDate, $modifier) {
    	$newDay = $tDate + ( $modifier * 86400 );
    	return $newDay;
    }
    function skipLibur($tDate,$arrJadwal) {
    	//echo 'date='.date('Y-m-d',$tDate);
    	$thisDay = date('N',$tDate);
    	//echo 'thisday='.$thisDay;
    	for($i=$thisDay;$i<=7;$i++) {
    		if($arrJadwal[$i]['isKerja']) {//hari kerja
    			//echo "\n".date('Y-m-d',$tDate);
    			if( $this->getHoliday($tDate) ) {
    				$tDate+=86400;
    			}else {
    				$tDate = $this->setHour($arrJadwal['umum']['masuk'],$tDate);
    				return $tDate;
    			}
    		}else {//hari libur
    			$tDate+=86400;
    		}
    	}
    	for($i=1;$i<$thisDay;$i++) {
    		if($arrJadwal[$i]['isKerja']) {//hari kerja
    			if( $this->getHoliday($tDate) ) {
    				$tDate+=86400;
    			}else {
    				$tDate = $this->setHour($arrJadwal['umum']['masuk'],$tDate);
    				return $tDate;
    			}
    		}else {//hari libur
    			$tDate+=86400;
    		}
    	}
    	return $tDate;
    }
    function getHoliday($date) {
    	//$CI =& get_instance();
    	$date = date('Y-m-d',$date);
    	if($data = $this->getQueryHoliday($date)) {
    		foreach($data as $dt) {
    			if($dt['libur']) {
    				return true;
    			}else {
    				return false;
    			}
    		}
    	}
    }
    function setHour($newHour='08:00:00',$tDate) {
    	$strDate = date('Y-m-d',$tDate);
    	$strHour = date('H:i:s',$tDate);
    	$strNew = $strDate.' '.$newHour;

    	$tDateNew = strtotime($strNew);
    	return $tDateNew;
    }
    function getJumlahHariLibur($tStartDate,$tEndDate,$arrJadwal) {
    	$cHariLibur=0;

    	while( $tStartDate < $tEndDate ) {
    		$thisDay = date('N',$tStartDate);
    		if( $arrJadwal[$thisDay]['isKerja'] ) {
    			if( $this->getHoliday($tStartDate) ) {
    				$cHariLibur+=86400;
    			}
    			else {
    				// do nothing
    			}
    		}else {
    			$cHariLibur+=86400;
    		}
    		$tStartDate+=86400;
    	}

    	return $cHariLibur;
    }
    function formatTimestamp($timestamp,$type='date'){
    	$return='';
    	if($type=='date') {
    		$timestamp = strtotime($timestamp);
    		$return=date('Y-m-d',$timestamp);
    	}elseif($type=='hour') {
    		$timestamp = strtotime($timestamp);
    		$return=date('H:i:s',$timestamp);
    	}
    	return $return;
    }
    function hitung_beda_hari($start,$stop,$jadwal_kerja) {
    	$start_i = strtotime(date('Y-m-d',$start));
    	$stop_i = strtotime(date('Y-m-d',$stop));

    	$total = 0;
    	for($i=$start_i; $i<=$stop_i; $i+=86400) {
    		if( $this->bukan_hari_kerja($i,$jadwal_kerja) ) {
    			continue;
    		} else {
    			$n = date('N',$i);
    			$jam_start = $jadwal_kerja[$n]['masuk'];
    			$jam_stop = $jadwal_kerja[$n]['keluar'];

    			if( date('Y-m-d',$i) == date('Y-m-d',$start) ) { //hari awal hitung
    				$jam_start = date('H:i:s',$start);
    				if( strtotime($jam_start) >= strtotime($jam_stop) ) {
    					continue;
    				} else {
    					$x = strtotime($jam_stop) - strtotime($jam_start);
    					if( $x/3600 > 5 ) { //lewat jam istirahat
    						$x -= 3600;
    					}
    					$total+=$x;
    				}
    			} else if( date('Y-m-d',$i) == date('Y-m-d',$stop) ) { //hari akhir hitung
    				$jam_stop_asli = $jam_stop;
    				$jam_stop = date('H:i:s',$stop);

    				if( strtotime($jam_stop) > strtotime($jam_stop_asli) ) {
    					$jam_stop = $jam_stop_asli;
    				}

    				$x = strtotime($jam_stop) - strtotime($jam_start);
    				if( $x/3600 > 5 ) { //lewat jam istirahat
    					$x -= 3600;
    				}
    				$total += $x;
    			} else { // hari gap hitung
    				$total += ( strtotime($jam_stop) - strtotime($jam_start) - 3600 );
    			}
    		}
    	}
    	//$jam = $total/3600;
    	//echo 'total='.$jam.'jam';
    	return $total;
    }
    function getJadwalKerja( $nip ) {
    	$CI =& get_instance();
    	$jadwalKerja=array();

    	$shift = $this->get_work_day($nip);
    	$shift = explode('^',$shift);

    	$shiftId = $shift[0];
    	$jamMasuk = $shift[2];
    	$jamKeluar = $shift[3];

    	$jadwalKerja['umum']['id']=$shiftId;
    	$jadwalKerja['umum']['masuk']=$shift[2];
    	$jadwalKerja['umum']['keluar']=$shift[3];

    	$arrJadwal = $this->getJamKerja($shiftId);

    	$tidakKerja = strtotime('00:00:00');
    	foreach( $arrJadwal as $dt ) {
    		$hari = $dt['hari'];//dalam angka
    		$jam_masuk = $dt['masuk'];
    		$jam_keluar = $dt['keluar'];
    		$jam_masuk_ = strtotime($jam_masuk);
    		$jam_keluar_ = strtotime($jam_keluar);
    		$isKerja = 1;//masuk kerja

    		$jadwalKerja[ $hari ]['masuk'] = $jam_masuk;
    		$jadwalKerja[ $hari ]['keluar'] = $jam_keluar;

    		//if( $tidakKerja == $jam_masuk_ && $tidakKerja == $jam_keluar_ )
    		//{ $isKerja = 0; }
    		if( $jam_masuk == '00:00:00' && $jam_keluar == '00:00:00') {
    			$isKerja = 0;
    		}

    		$jadwalKerja[ $hari ]['isKerja'] = $isKerja;
    	}
    	return $jadwalKerja;
    }
	function get_work_day($nip){
		$sql1 = "SELECT h.iShiftID shift,h.iWorkDay hari,d.ciIn masuk, d.ciEnd keluar
				FROM hrd.hshift h INNER JOIN hrd.dshift d ON h.iShiftID=d.iShiftID
				WHERE d.iDays=1 AND h.igshiftid=(SELECT igshiftid FROM hrd.employee WHERE cNip='$nip') LIMIT 1";
		$sql = $this->db_erp_pk->query($sql1);
		$a = ($sql->num_rows()==0) ? '1^5^08:00:00^17:00:00' : $sql->row()->shift.'^'.$sql->row()->hari.'^'.$sql->row()->masuk.'^'.$sql->row()->keluar;
		return $a;
		/*
		format return: shiftKe^jmlHariKerja^jamMasuk^jamKeluar
		*/
	}
	function bukan_hari_kerja($tdate,$jadwal_kerja) {
		$return = false;
		$n_date = date('N',$tdate);

		if( $this->getHoliday($tdate) ) {
			$return = true;
		}
		if( !$jadwal_kerja[$n_date]['isKerja']) {
			$return = true;
		}

		return $return;

	}
    function getQueryHoliday($date) {
        $sql="SELECT COALESCE( (
				SELECT 1 FROM hrd.holiday WHERE ddate = '$date'
			  ), 0 ) AS `libur`";
        //echo $sql;exit();
        $result = $this->db_erp_pk->query($sql);
        return $result->result_array();
    }



    //================================= Function Untuk PK TS Staff=================================//




    /*Optional function for PK TS*/
    function selisihMenit($mntawal, $mntakhir){
        $a='1991-03-19 '.$mntawal;
        $b='1991-03-19 '.$mntakhir;
        $mna=date_create($a);
        $mnb=date_create($b);
        $diff=date_diff($mna,$mnb);
        $j=$diff->h;
        $s=0;
        if($j>0){
            $s=$j*60;
        }
        $m=$diff->i;
        $n=$s+$m;
        return $n;
    }

    function selisihJam($tglAwal, $tglAkhir, $nip){
        $this->dbseth = $this->_ci->load->database('hrd', true);
        //select jumlah hari kerja shiftnya
        $sqlc="select * from hrd.dshift da
                inner join hrd.gshift gs on da.iShiftID=gs.iShiftID
                inner join hrd.employee em on em.igshiftid=gs.iGShiftID
                where em.cNip='".$nip."' and (da.ciIn!='00:00:00' or da.ciEnd!='00:00:00')";
        $counthr=$this->dbseth->query($sqlc)->num_rows();

        //$tglLibur = Array("2016-12-25", "2016-12-26");
        $tglLibur = array();
        $sqlholi="select * from hrd.holiday holi
            where holi.bDeleted=0 and holi.ddate Between '".$tglAwal."' AND '".$tglAkhir."'";
        $qlholi=$this->dbseth->query($sqlholi);
        if($qlholi->num_rows()>=1){
            foreach ($qlholi->result_array() as $kholi => $vholi) {
                array_push($tglLibur, $vholi['ddate']);
            }
        }
         // memecah string tanggal awal untuk mendapatkan
        // tanggal, bulan, tahun
        $pecah1 = explode("-", date("Y-m-d",strtotime($tglAwal)));
        $date1 = $pecah1[2];
        $month1 = $pecah1[1];
        $year1 = $pecah1[0];
        // memecah string tanggal akhir untuk mendapatkan
        // tanggal, bulan, tahun
        $pecah2 = explode("-", date("Y-m-d",strtotime($tglAkhir)));
        $date2 = $pecah2[2];
        $month2 = $pecah2[1];
        $year2 =  $pecah2[0];
        // mencari selisih hari dari tanggal awal dan akhir
        $jd1 = GregorianToJD($month1, $date1, $year1);
        $jd2 = GregorianToJD($month2, $date2, $year2);
        $selisih = $jd2 - $jd1;
        $libur1=0;
        $libur2=0;
        $libur3=0;
        // proses menghitung tanggal merah dan hari minggu
        // di antara tanggal awal dan akhir
        for($i=1; $i<=$selisih; $i++){
            // menentukan tanggal pada hari ke-i dari tanggal awal
            $tanggal = mktime(0, 0, 0, $month1, $date1+$i, $year1);
            $tglstr = date("Y-m-d", $tanggal);
            // menghitung jumlah tanggal pada hari ke-i
            // yang masuk dalam daftar tanggal merah selain minggu
            if (in_array($tglstr, $tglLibur))
            {
                $libur1++;
            }
            // menghitung jumlah tanggal pada hari ke-i
            // yang merupakan hari minggu
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
         // Menotalkan jumlah libur
        if($counthr==5){
            return $libur1+$libur2+$libur3;
        }else{
            return $libur1+$libur2;
        }
    }

    //BD - 1 START---------------------------------------------------------------------------------------------
    function BD1_1($post){
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

        $sql2='SELECT DISTINCT(u.`iGroup_produk`) as jml FROM plc2.`plc2_upb` u
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
            JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
            WHERE u.`ldeleted` = 0
            #AND u.tinfo_paten IS NOT NULL
            #AND u.tinfo_paten !=""
            AND u.`iteambusdev_id` = 4
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            and u.itipe_id <> 6
            and u.ldeleted = 0
            and u.iKill = 0
            AND ua.`tupdate` >= "'.$perode1.'"
            AND ua.`tupdate` <= "'.$perode2.'"';


        $totDDS     = $dds;
        $totb       = $this->db_erp_pk->query($sql2)->num_rows();
        $result     = $totb;
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqlDetail='SELECT u.tinfo_paten, u.`iupb_id`, m.vNama_Group ,u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , ua.`tupdate`, u.vKode_obat FROM plc2.`plc2_upb` u
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
            JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
            WHERE u.`ldeleted` = 0
            #AND u.tinfo_paten IS NOT NULL
            #AND u.tinfo_paten !=""
            AND u.`iteambusdev_id` = 4
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            and u.itipe_id <> 6
            and u.ldeleted = 0
            and u.iKill = 0
            AND ua.`tupdate` >= "'.$perode1.'"
            AND ua.`tupdate` <= "'.$perode2.'"';

            echo '<pre>'.$sqlDetail;    

        $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Group Produk</th>
                        <th>Info Paten</th>
                        <th>Approval Direksi</th>
                    </tr>
        ";

        $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
        $i=0;
        foreach ($upbDetail as $ub) {
             $i++;

             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vNama_Group']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tinfo_paten']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tupdate']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>

                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Group UPB</td>

                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr>
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }
    function BD1_1x($post){

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

            $sql2='SELECT DISTINCT(u.`iGroup_produk`) as jml FROM plc2.`plc2_upb` u
                JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                WHERE u.`ldeleted` = 0
                AND u.tinfo_paten IS NOT NULL
                AND u.tinfo_paten !=""
                AND u.`iteambusdev_id` = 4
                AND ua.`vtipe` = "DR"
                AND ua.`iapprove` = 2
                and u.itipe_id <> 6
                and u.ldeleted = 0
                and u.iKill = 0
                AND ua.`tupdate` >= "'.$perode1.'"
                AND ua.`tupdate` <= "'.$perode2.'"';


            $totDDS     = $dds;
            $totb       = $this->db_erp_pk->query($sql2)->num_rows();
            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";

            $sqlDetail='SELECT u.tinfo_paten, u.`iupb_id`, m.vNama_Group ,u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , ua.`tupdate`, u.vKode_obat FROM plc2.`plc2_upb` u
                JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                WHERE u.`ldeleted` = 0
                AND u.tinfo_paten IS NOT NULL
                AND u.tinfo_paten !=""
                AND u.`iteambusdev_id` = 4
                AND ua.`vtipe` = "DR"
                AND ua.`iapprove` = 2
                and u.itipe_id <> 6
                and u.ldeleted = 0
                and u.iKill = 0
                AND ua.`tupdate` >= "'.$perode1.'"
                AND ua.`tupdate` <= "'.$perode2.'"';


            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Group Produk</th>
                            <th>Info Paten</th>
                            <th>Approval Direksi</th>
                        </tr>
            ";

            $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
            $i=0;
            foreach ($upbDetail as $ub) {
                 $i++;

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vNama_Group']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tinfo_paten']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tupdate']."</td>
                          </tr>";

            }

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Group UPB</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }

    function BD1_2($post){

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

            $sql1='SELECT ut.vteam ,u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` ,
                u.`vupb_nomor`,u.vupb_nama , ua.`tupdate`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u
                JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                JOIN plc2.plc2_upb_team ut on ut.iteam_id = u.iteammarketing_id
                join plc2.group_marketing gm on gm.iGroup_marketing=ut.iGroup_marketing
                WHERE u.`ldeleted` = 0
                AND u.tinfo_paten IS NOT NULL
                AND u.tinfo_paten !=""
                AND u.iteammarketing_id IS NOT NULL
                AND u.`iteambusdev_id` = "4"
                AND ua.`vtipe` = "DR"
                AND ua.`iapprove` = 2
                and gm.iGroup_marketing= 1 # Group Etichal
                AND ua.`tupdate` >= "'.$perode1.'"
                AND ua.`tupdate` <= "'.$perode2.'"
                
                ';

            $sql2 = ' order by u.iteammarketing_id';

            $sqlDetail = $sql1.$sql2;

                
            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>

                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Team Marketing</th>
                            <th>Info Paten</th>
                            <th>Approval Direksi</th>
                        </tr>
            ";

            $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
            $i=0;
            foreach ($upbDetail as $ub) {
                 $i++;

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vteam']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tinfo_paten']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tupdate']."</td>
                          </tr>";

            }

            $html .= "</table><br /> ";

            $detailMKT = '<table border="1" style="border:1px;border-collapse:collapse;">
                            <thead>
                                <th>
                                    No
                                </th>
                                <th>
                                    Marketing
                                </th>
                                <th>
                                    Jumlah UPB
                                </th>
                            </thead>
                            <tbody>';

            $sqlMar = 'select b.vteam,b.iteam_id 
                        from plc2.group_marketing a 
                        join plc2.plc2_upb_team b on b.iGroup_marketing=a.iGroup_marketing
                        where a.iGroup_marketing=1';                      
            $dMar = $this->db_erp_pk->query($sqlMar)->result_array();            
                            $no=1;
                            $retArr = array();
                            foreach ($dMar as $mar) {
                                $sqlCMkt = $sql1.' and iteammarketing_id = "'.$mar['iteam_id'].'"  ';

                                //echo $sqlCMkt;
                                $countMR = $this->db_erp_pk->query($sqlCMkt)->num_rows();

                                array_push($retArr, $countMR);
                                $detailMKT .= '<tr>
                                                    <td>'.$no.'</td>
                                                    <td style="text-align:left;">'.$mar['vteam'].'</td>
                                                    <td>'.$countMR.'</td>
                                              </tr>';
                                    
                                $no++;
                            }
            $detailMKT .=   '</tbody>
                        </table>';

                        $smallestMkt = min($retArr);

                        $result     = $smallestMkt;
                        $getpoint   = $this->getPoint($result,$iAspekId);
                        $x_getpoint = explode("~", $getpoint);
                        $point      = $x_getpoint['0'];
                        $warna      = $x_getpoint['1'];


            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 100%%;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB / Marketing</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$detailMKT." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Terkecil</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                        </tr>


                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }

    function BD1_2x($post){

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

             $sqlp1='SELECT COUNT(u.`iupb_id`) As t_upb FROM plc2.`plc2_upb` u
                    JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    #JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    WHERE u.`ldeleted` = 0
                    AND u.tinfo_paten IS NOT NULL
                    AND u.tinfo_paten !=""
                    AND u.`iteambusdev_id` = 4
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    and u.itipe_id <> 6
                    and u.ldeleted = 0
                    and u.iKill = 0
                    AND ua.`tupdate` >= "'.$perode1.'"
                    AND ua.`tupdate` <= "'.$perode2.'"
                    AND u.`ikategoriupb_id` = 10
                    ';

            //Menghitung JumLAH upb (B) Sesuai Parameter 1
            $sqlp2='SELECT COUNT(u.`iupb_id`) As t_upb2 FROM plc2.`plc2_upb` u
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
            JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
            #JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
            WHERE u.`ldeleted` = 0
            AND u.tinfo_paten IS NOT NULL
            AND u.tinfo_paten !=""
            AND u.`iteambusdev_id` = 4
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            and u.itipe_id <> 6
            and u.ldeleted = 0
            and u.iKill = 0
            AND ua.`tupdate` >= "'.$perode1.'"
            AND ua.`tupdate` <= "'.$perode2.'"
            ';

            $upb = $this->db_erp_pk->query($sqlp1)->row_array();
            $mar = $this->db_erp_pk->query($sqlp2)->row_array();

            if($mar['t_upb2']>0){
                $hasil      = ($upb['t_upb']/$mar['t_upb2'])*100;
                $totb       = number_format( $hasil, 2, '.', '' );
            }else{
                $totb       = 0;
            }

            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";

            $sqlDetail='SELECT ut.vteam ,u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` ,
                u.`vupb_nomor`,u.vupb_nama , ua.`tupdate`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u
                JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                JOIN plc2.plc2_upb_team ut on ut.iteam_id = u.iteammarketing_id
                WHERE u.`ldeleted` = 0
                AND u.tinfo_paten IS NOT NULL
                AND u.tinfo_paten !=""
                AND u.iteammarketing_id IS NOT NULL
                AND u.`iteambusdev_id` = "4"
                AND ua.`vtipe` = "DR"
                AND ua.`iapprove` = 2
                and u.itipe_id <> 6
                and u.ldeleted = 0
                and u.iKill = 0
                AND ua.`tupdate` >= "'.$perode1.'"
                AND ua.`tupdate` <= "'.$perode2.'"';

            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>

                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Team Marketing</th>
                            <th>Info Paten</th>
                            <th>Approval Direksi</th>
                        </tr>
            ";

            $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
            $i=0;
            foreach ($upbDetail as $ub) {
                 $i++;

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vteam']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tinfo_paten']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tupdate']."</td>
                          </tr>";

            }

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori A</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Memenuhi Syarat</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$mar['t_upb2']." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata (Jumlah UPB Kategori A / Jumlah Memenuhi Syarat</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                        </tr>


                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }

    function BD1_13($post){

            $iAspekId = $post['_iAspekId'];
            $cNipNya  = $post['_cNipNya'];
            $dPeriode1  = $post['_dPeriode1'];
            $x_prd1 = explode("-", $dPeriode1);
            $perode1 = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];

            $dPeriode2  = $post['_dPeriode2'];
            $x_prd2 = explode("-", $dPeriode2);
            $perode2 = $x_prd2['2']."-".$x_prd2['1']."-".$x_prd2['0'];



            //cari aspek dulu
            $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='".$iAspekId."'";
            $query = $this->db_erp_pk->query($sql);
            $vAspekName = $query->row()->vAspekName;

            $sql_par5 ='
                    SELECT  i.tReceived ,e.vName,t.vtarget_kunjungan,cc.vpejabat
                    FROM kartu_call.`call_card` cc 
                    join hrd.employee e on e.cNip=cc.vNIP
                    join gps_msg.inbox i on i.ID=cc.igpsm_id
                    join kartu_call.master_target_kunjungan t on t.itarget_kunjungan_id=cc.itarget_kunjungan_id
                    WHERE cc.`lDeleted` = 0 
                    AND t.`isHead` = 1  
                    AND cc.`vNIP` LIKE "%'.$cNipNya.'%"
                    AND date(i.`tReceived`) >= "'.$perode1.'"
                    AND date(i.`tReceived`) <= "'.$perode2.'"
                        ';

            $qupb = $this->db_erp_pk->query($sql_par5);
            if($qupb->num_rows() > 0) {
                $tot = $qupb->num_rows();
                $totb = number_format( $tot, 2, '.', '' );
            }else{
                $totb       = 0;
            }




            $html = "
                    <table cellspacing='0' cellpadding='3' width='850px'>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>
                        </tr>
                    </table><br><hr>";


            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>Tanggal Kunjungan</th>
                            <th>Nama</th>
                            <th>Target Kunjungan</th>
                            <th>Nama Pejabat</th>
                        </tr>
            ";

            $bacthDetail = $this->db_erp_pk->query($sql_par5)->result_array();
            $i=0;

    


            
            foreach ($bacthDetail as $ub) {
                 $i++;
                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                             <td style='border: 1px solid #dddddd;'>".$i."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['tReceived']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['vName']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['vtarget_kunjungan']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['vpejabat']."</td>
                             
                          </tr>";
            }

            $html .= "</table><br /> ";

            $timeEnd = strtotime($perode2);
            $timeStart = strtotime($perode1);
            $bulan = 1+(date("Y",$timeEnd)-date("Y",$timeStart))*12;
            $bulan +=  (date("m",$timeEnd)-date("m",$timeStart));      


            $result     = number_format(($i/$bulan), 2, '.', '' );

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Kunjungan (A)</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Bulan (B)</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$bulan." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Result (A/B) </td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result."</td>
                        </tr>
                    </table><br/><br/>";

            

            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];


            echo $result."~".$point."~".$warna."~".$html;
    }



    function BD1_3x($post){
        // dari parameter 5 sebelumnya

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

        //Menghitung Jumalah UPB yang sudah submit prareg dan tipenya A
         $sqlp1 = 'SELECT COUNT(u.`iupb_id`) AS t_upb FROM plc2.`plc2_upb` u
                    JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                    WHERE u.`ldeleted` = 0
                    AND u.`iteambusdev_id` = 4
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.`ikategoriupb_id` = 10
                    AND u.tsubmit_prareg IS NOT NULL
                    AND u.`tsubmit_prareg` >= "'.$perode1.'"
                    AND u.`tsubmit_prareg` <= "'.$perode2.'"
                    and u.itipe_id <> 6
                    and u.ldeleted = 0
                    and u.iKill = 0
                    ';



        $upb = $this->db_erp_pk->query($sqlp1)->row_array();

        if($upb['t_upb']>0){
            $hasil      = $upb['t_upb'];
            $totb       = number_format( $hasil, 2, '.', '' );
        }else{
            $totb       = 0;
        }

        $result     = $totb;
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqlDetail='SELECT u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` ,
            u.`vupb_nomor`,u.vupb_nama , ua.`tupdate`, u.vKode_obat, u.iteammarketing_id,u.tsubmit_prareg
            FROM plc2.`plc2_upb` u
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
            WHERE u.`ldeleted` = 0
            AND u.`iteambusdev_id` = 4
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            AND u.`ikategoriupb_id` = 10
            AND u.`tsubmit_prareg` >= "'.$perode1.'"
            AND u.`tsubmit_prareg` <= "'.$perode2.'"
            and u.itipe_id <> 6
            and u.ldeleted = 0
            and u.iKill = 0
            ';

        $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>

                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Info Paten</th>
                        <th>Approval Direksi</th>
                        <th>Tanggal Prareg</th>
                    </tr>
        ";

        $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
        $i=0;
        foreach ($upbDetail as $ub) {
             $i++;

             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tinfo_paten']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tupdate']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tsubmit_prareg']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>



                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Masuk Tahap Prareg</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }



    function BD1_4x($post){
        // dari parameter 5 sebelumnya

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

        //Menghitung Jumalah UPB yang sudah submit registrasi dan tipenya A
         $sqlp1 = 'SELECT COUNT(u.`iupb_id`) AS t_upb FROM plc2.`plc2_upb` u
                    JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                    WHERE u.`ldeleted` = 0
                    AND u.`iteambusdev_id` = 4
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.`ikategoriupb_id` = 10
                    AND u.tregistrasi IS NOT NULL
                    AND u.`tregistrasi` >= "'.$perode1.'"
                    AND u.`tregistrasi` <= "'.$perode2.'"
                    and u.itipe_id <> 6
                    and u.ldeleted = 0
                    and u.iKill = 0
                    ';



        $upb = $this->db_erp_pk->query($sqlp1)->row_array();

        if($upb['t_upb']>0){
            $hasil      = $upb['t_upb'];
            $totb       = number_format( $hasil, 2, '.', '' );
        }else{
            $totb       = 0;
        }

        $result     = $totb;
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqlDetail='SELECT u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` ,
            u.`vupb_nomor`,u.vupb_nama , ua.`tupdate`, u.vKode_obat, u.iteammarketing_id,u.tregistrasi
            FROM plc2.`plc2_upb` u
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
            WHERE u.`ldeleted` = 0
            AND u.`iteambusdev_id` = 4
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            AND u.`ikategoriupb_id` = 10
            AND u.tregistrasi IS NOT NULL
            AND u.`tregistrasi` >= "'.$perode1.'"
            AND u.`tregistrasi` <= "'.$perode2.'"
            and u.itipe_id <> 6
            and u.ldeleted = 0
            and u.iKill = 0
            ';
        //echo $sqlDetail;

        $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>

                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Info Paten</th>
                        <th>Approval Direksi</th>
                        <th>Tanggal Registrasi</th>
                    </tr>
        ";

        $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
        $i=0;
        foreach ($upbDetail as $ub) {
             $i++;

             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tinfo_paten']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tupdate']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tregistrasi']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>



                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Masuk Tahap Registrasi</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }



    function BD1_5x($post){
        // dari parameter 5 sebelumnya

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

       /*
            Rata-rata Jangka waktu dari UPB approved dan dokumen pra reg submit ke BPOM
            (dihitung sejak tanggal UPB di-approved Direktur hingga diterimanya file pra reg oleh BPOM)

       */
         $sqlp1 = 'SELECT
                    u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` ,
                    u.`vupb_nomor`,u.vupb_nama
                    , date(ua.tupdate) as appdir,u.tsubmit_prareg
                    ,sum(datediff( u.tsubmit_prareg,date(ua.tupdate)  )) as selisih
                    FROM plc2.`plc2_upb` u
                    JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                    WHERE u.`ldeleted` = 0
                    AND u.`iteambusdev_id` = 4
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.`ikategoriupb_id` = 10
                    AND u.tsubmit_prareg IS NOT NULL
                    AND u.`tsubmit_prareg` >= "'.$perode1.'"
                    AND u.`tsubmit_prareg` <= "'.$perode2.'"
                    and u.itipe_id <> 6
                    and u.ldeleted = 0
                    and u.iKill = 0
                    ';
        $sqlp2 = 'SELECT
                    u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` ,
                    u.`vupb_nomor`,u.vupb_nama
                    , date(ua.tupdate) as appdir,u.tsubmit_prareg
                    ,datediff( u.tsubmit_prareg,date(ua.tupdate)  ) as selisih
                    FROM plc2.`plc2_upb` u
                    JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                    WHERE u.`ldeleted` = 0
                    AND u.`iteambusdev_id` = 4
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.`ikategoriupb_id` = 10
                    AND u.tsubmit_prareg IS NOT NULL
                    AND u.`tsubmit_prareg` >= "'.$perode1.'"
                    AND u.`tsubmit_prareg` <= "'.$perode2.'"
                    and u.itipe_id <> 6
                    and u.ldeleted = 0
                    and u.iKill = 0
                    ';

        $upb = $this->db_erp_pk->query($sqlp1)->row_array();
        $upbDetail = $this->db_erp_pk->query($sqlp2)->result_array();

        if($upb['iupb_id'] > 0){
            $hasil      = $upb['selisih']/30;
            $totb       = number_format( $hasil, 2, '.', '' );
        }else{
            $totb       = 0;
        }

        $result     = $totb;
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>

                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Info Paten</th>
                        <th>Approval Direksi</th>
                        <th>Tanggal Prareg</th>
                        <th>Selisih Hari</th>
                    </tr>
        ";


        $i=0;
        foreach ($upbDetail as $ub) {
             $i++;

             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tinfo_paten']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['appdir']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tsubmit_prareg']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['selisih']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata Rata ( Bulan ) </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }




    function BD1_6x($post){
        // dari parameter 5 sebelumnya

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

       /*
            Realisasi produk baru Applet nomor registrasi

       */
         $sqlp1 = 'SELECT
                    DISTINCT(u.`iGroup_produk`) as jml,
                    u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` ,
                    u.`vupb_nomor`,u.vupb_nama
                    , date(ua.tupdate) as appdir
                    ,u.dinput_applet
                    FROM plc2.`plc2_upb` u
                    JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                    WHERE u.`ldeleted` = 0
                    AND u.`iteambusdev_id` = 4
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.`ikategoriupb_id` in( 10,11 )
                    AND u.dinput_applet IS NOT NULL
                    AND u.`dinput_applet` >= "'.$perode1.'"
                    AND u.`dinput_applet` <= "'.$perode2.'"
                    and u.itipe_id <> 6
                    and u.ldeleted = 0
                    and u.iKill = 0
                    ';
        $sqlp2 = 'SELECT
                    u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` ,
                    u.`vupb_nomor`,u.vupb_nama , m.vNama_Group
                    , date(ua.tupdate) as appdir,date(u.dinput_applet) as dinput_applet
                    FROM plc2.`plc2_upb` u
                    JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                    JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    WHERE u.`ldeleted` = 0
                    AND u.`iteambusdev_id` = 4
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.`ikategoriupb_id` in( 10,11 )
                    AND u.dinput_applet IS NOT NULL
                    AND u.`dinput_applet` >= "'.$perode1.'"
                    AND u.`dinput_applet` <= "'.$perode2.'"
                    and u.itipe_id <> 6
                    and u.ldeleted = 0
                    and u.iKill = 0
                    ';

        $upb = $this->db_erp_pk->query($sqlp1)->row_array();
        $upbDetail = $this->db_erp_pk->query($sqlp2)->result_array();

        if($upb['iupb_id'] > 0){
            $hasil      = $upb['jml'];
            $totb       = number_format( $hasil, 2, '.', '' );
        }else{
            $totb       = 0;
        }

        $result     = $totb;
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>

                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Approval Direksi</th>
                        <th>Tanggal Applet</th>
                        <th>Group Produk</th>
                    </tr>
        ";


        $i=0;
        foreach ($upbDetail as $ub) {
             $i++;

             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['appdir']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dinput_applet']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['vNama_Group']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";




        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Group Produk </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }


    function BD1_10x($post){

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

       /*
            Rata-rata jangka waktu diperolehnya nomer registrasi
            (dihitung dari tanggal proses registrasi atau setelah KOMNAS untuk produk yang perlu evaluasi pra klinik dan klinik ),

       */
         $sqlp1 = 'SELECT
                    u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` ,
                    u.`vupb_nomor`,u.vupb_nama
                    , date(u.dinput_applet) as applet,u.tsubmit_prareg
                    ,sum(datediff( u.dinput_applet,date(u.tregistrasi)  )) as selisih
                    FROM plc2.`plc2_upb` u
                    JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                    WHERE u.`ldeleted` = 0
                    AND u.`iteambusdev_id` = 4
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.`ikategoriupb_id` = 10
                    AND u.dinput_applet IS NOT NULL
                    AND u.tregistrasi IS NOT NULL
                    AND u.`dinput_applet` >= "'.$perode1.'"
                    AND u.`dinput_applet` <= "'.$perode2.'"
                    and u.itipe_id <> 6
                    and u.ldeleted = 0
                    and u.iKill = 0
                    ';
        $sqlp2 = 'SELECT
                    u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` ,
                    u.`vupb_nomor`,u.vupb_nama
                    , date(u.dinput_applet) as applet,u.tsubmit_prareg
                    ,datediff( u.dinput_applet,date(u.tregistrasi)  ) as selisih
                    FROM plc2.`plc2_upb` u
                    JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                    WHERE u.`ldeleted` = 0
                    AND u.`iteambusdev_id` = 4
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.`ikategoriupb_id` = 10
                    AND u.dinput_applet IS NOT NULL
                    AND u.tregistrasi IS NOT NULL
                    AND u.`dinput_applet` >= "'.$perode1.'"
                    AND u.`dinput_applet` <= "'.$perode2.'"
                    and u.itipe_id <> 6
                    and u.ldeleted = 0
                    and u.iKill = 0
                    ';

        $upb = $this->db_erp_pk->query($sqlp1)->row_array();
        $upbDetail = $this->db_erp_pk->query($sqlp2)->result_array();

        if($upb['iupb_id'] > 0){
            $hasil      = abs($upb['selisih']/30);
            $totb       = number_format( $hasil, 2, '.', '' );
        }else{
            $totb       = 0;
        }

        $result     = $totb;
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>

                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Info Paten</th>
                        <th>Tanggal Applet</th>
                        <th>Tanggal Registrasi</th>
                        <th>Selisih Hari</th>
                    </tr>
        ";


        $i=0;
        foreach ($upbDetail as $ub) {
             $i++;

             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tinfo_paten']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['applet']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tsubmit_prareg']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['selisih']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata Rata ( Bulan ) </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD1_11x($post){

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

       /*
            Rata-rata jangka waktu diperolehnya nomer registrasi (dihitung dari tanggal masuk jawaban tambahan data terakhir ke BPOM),
            untuk produk kategori B (termasuk OGB) --

       */

         $sqlp1 = 'SELECT
                    u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` ,
                    u.`vupb_nomor`,u.vupb_nama
                    , date(u.dinput_applet) as applet,u.tsubmit_prareg

                    #,sum(datediff( u.dinput_applet,date(u.tregistrasi)  )) as selisih

                    ,(SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0
                    AND ad.`iupb_id`  = u.`iupb_id`
                    AND ad.`dsubmit_dok` IS NOT NULL
                    ORDER BY ad.`dsubmit_dok` DESC LIMIT 1)  AS dsubmit_dok
                    , sum(datediff(

                        (SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0
                        AND ad.`iupb_id`  = u.`iupb_id`
                        AND ad.`dsubmit_dok` IS NOT NULL
                        ORDER BY ad.`dsubmit_dok` DESC LIMIT 1)
                        ,
                        date(u.dinput_applet)

                    ) ) as selisih


                    FROM plc2.`plc2_upb` u
                    JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                    WHERE u.`ldeleted` = 0
                    AND u.`iteambusdev_id` = 4
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.`ikategoriupb_id` = 11
                    AND u.dinput_applet IS NOT NULL
                    AND u.tregistrasi IS NOT NULL
                    AND u.`dinput_applet` >= "'.$perode1.'"
                    AND u.`dinput_applet` <= "'.$perode2.'"
                    and u.itipe_id <> 6
                    and u.ldeleted = 0
                    and u.iKill = 0
                    ';
        $sqlp2 = 'SELECT
                    u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` ,
                    u.`vupb_nomor`,u.vupb_nama
                    , date(u.dinput_applet) as applet,u.tsubmit_prareg
                    ,(SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0
                    AND ad.`iupb_id`  = u.`iupb_id`
                    AND ad.`dsubmit_dok` IS NOT NULL
                    ORDER BY ad.`dsubmit_dok` DESC LIMIT 1)  AS dsubmit_dok
                    , sum(datediff(

                        (SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0
                        AND ad.`iupb_id`  = u.`iupb_id`
                        AND ad.`dsubmit_dok` IS NOT NULL
                        ORDER BY ad.`dsubmit_dok` DESC LIMIT 1)
                        ,
                        date(u.dinput_applet)

                    ) ) as selisih

                    FROM plc2.`plc2_upb` u
                    JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                    WHERE u.`ldeleted` = 0
                    AND u.`iteambusdev_id` = 4
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.`ikategoriupb_id` = 11
                    AND u.dinput_applet IS NOT NULL
                    AND u.tregistrasi IS NOT NULL
                    AND u.`dinput_applet` >= "'.$perode1.'"
                    AND u.`dinput_applet` <= "'.$perode2.'"
                    and u.itipe_id <> 6
                    and u.ldeleted = 0
                    and u.iKill = 0
                    ';
        //echo $sqlp2;

        $upb = $this->db_erp_pk->query($sqlp1)->row_array();
        $upbDetail = $this->db_erp_pk->query($sqlp2)->result_array();

        if($upb['iupb_id'] > 0){
            $hasil      = abs($upb['selisih']/30);
            $totb       = number_format( $hasil, 2, '.', '' );
        }else{
            $totb       = 0;
        }

        $result     = $totb;
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>

                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Info Paten</th>
                        <th>Tanggal Applet</th>
                        <th>Tanggal Last TD</th>
                        <th>Selisih Hari</th>
                    </tr>
        ";


        $i=0;
        foreach ($upbDetail as $ub) {
             $i++;

             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tinfo_paten']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['applet']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dsubmit_dok']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['selisih']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata Rata ( Bulan ) </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD1_12x($post){

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

       /*
            Rata-rata jangka waktu diperolehnya nomer registrasi
            (dihitung dari tanggal proses registrasi atau setelah KOMNAS untuk produk yang perlu evaluasi pra klinik dan klinik ),

       */
         $sqlp1 = 'SELECT
                    u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` ,
                    u.`vupb_nomor`,u.vupb_nama
                    , date(u.dinput_applet) as applet,u.ttarget_noreg
                    ,datediff( u.ttarget_noreg,date(u.dinput_applet)  ) as selisih
                    FROM plc2.`plc2_upb` u
                    JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                    WHERE u.`ldeleted` = 0
                    AND u.`iteambusdev_id` = 4
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.`ikategoriupb_id` = 10
                    AND u.dinput_applet IS NOT NULL
                    AND u.ttarget_noreg IS NOT NULL
                    AND u.`ttarget_noreg` >= "'.$perode1.'"
                    AND u.`ttarget_noreg` <= "'.$perode2.'"
                    and u.itipe_id <> 6
                    and u.ldeleted = 0
                    and u.iKill = 0
                    ';
        $sqlp2 = 'SELECT
                    u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` ,
                    u.`vupb_nomor`,u.vupb_nama
                    , date(u.dinput_applet) as applet,u.ttarget_noreg
                    ,datediff( u.ttarget_noreg,date(u.dinput_applet)  ) as selisih
                    FROM plc2.`plc2_upb` u
                    JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                    WHERE u.`ldeleted` = 0
                    AND u.`iteambusdev_id` = 4
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.`ikategoriupb_id` = 10
                    AND u.dinput_applet IS NOT NULL
                    AND u.ttarget_noreg IS NOT NULL
                    AND u.`ttarget_noreg` >= "'.$perode1.'"
                    AND u.`ttarget_noreg` <= "'.$perode2.'"
                    and u.itipe_id <> 6
                    and u.ldeleted = 0
                    and u.iKill = 0
                    ';
       //echo '<pre>'.$sqlp2;
        $upb = $this->db_erp_pk->query($sqlp1)->row_array();
        $upbDetail = $this->db_erp_pk->query($sqlp2)->result_array();

        if($upb['iupb_id'] > 0){
            $hasil      = abs($upb['selisih']/30);
            $totb       = number_format( $hasil, 2, '.', '' );
        }else{
            $totb       = 0;
        }

        $result     = $totb;
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>

                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Info Paten</th>
                        <th>Tanggal Applet</th>
                        <th>Tanggal NIE</th>
                        <th>Selisih Hari</th>
                    </tr>
        ";


        $i=0;
        foreach ($upbDetail as $ub) {
             $i++;

             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tinfo_paten']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['applet']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['ttarget_noreg']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['selisih']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata Rata ( Bulan ) </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }



    //BD - 1 END-----------------------------------------------------------------------------------------------

     //BD - 2 START---------------------------------------------------------------------------------------------
    public function selisihbulan($date1,$date2){
        $arrdate1=explode('-',date_format($date1,"Y-m-d"));
        $arrdate2=explode('-',date_format($date2,"Y-m-d"));
        $sisa=0;
        /*Edit Date 1*/
        $sumdate1=$arrdate1[0]*12+$arrdate1[1];
        $sumdate2=$arrdate2[0]*12+$arrdate2[1];

        $sisa=intval($sumdate1)-intval($sumdate2);
        $min=-1;
        $sisa=$sisa<0?$sisa*$min:$sisa;
        return intval($sisa);
    }

    public function selisihminggu($startDate,$endDate,$day_number=1){
        if($startDate > $endDate){
            $tgl1=$startDate;
            $tgl2=$endDate;
            $startDate=$tgl2;
            $endDate=$tgl1;
        }
        $endDate = strtotime($endDate);
        $days=array('1'=>'Monday','2' => 'Tuesday','3' => 'Wednesday','4'=>'Thursday','5' =>'Friday','6' => 'Saturday','7'=>'Sunday');
        for($i = strtotime($days[$day_number], strtotime($startDate)); $i <= $endDate; $i = strtotime('+1 week', $i))
        $date_array[]=date('Y-m-d',$i);
        return count($date_array);
    }

    function BD2_1($post){

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
            $sql2='SELECT DISTINCT(u.`iGroup_produk`) as jml FROM plc2.`plc2_upb` u
                JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                WHERE u.`ldeleted` = 0
                AND u.tinfo_paten IS NOT NULL
                AND u.tinfo_paten !=""
                AND u.`iteambusdev_id` = 22
                and u.iappdireksi = 2
                AND ua.`vtipe` = "DR"
                AND ua.`iapprove` = 2
                AND ua.`tupdate` >= "'.$perode1.'"
                AND ua.`tupdate` <= "'.$perode2.'"';


            $totDDS     = $dds;
            $totb       = $this->db_erp_pk->query($sql2)->num_rows();
            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";

            $sqlDetail='SELECT u.tinfo_paten, u.`iupb_id`, m.vNama_Group ,u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , ua.`tupdate`, u.vKode_obat FROM plc2.`plc2_upb` u
                JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                WHERE u.`ldeleted` = 0
                AND u.tinfo_paten IS NOT NULL
                AND u.tinfo_paten !=""
                AND u.`iteambusdev_id` = 22
                and u.iappdireksi = 2
                AND ua.`vtipe` = "DR"
                AND ua.`iapprove` = 2
                AND ua.`tupdate` >= "'.$perode1.'"
                AND ua.`tupdate` <= "'.$perode2.'"';


            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Group Produk</th>
                            <th>Info Paten</th>
                            <th>Approval Direksi</th>
                        </tr>
            ";

            $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
            $i=0;
            foreach ($upbDetail as $ub) {
                 $i++;

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vNama_Group']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tinfo_paten']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tupdate']."</td>
                          </tr>";

            }

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Group UPB</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }
    function BD2_2($post){

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

            $sql1='SELECT ut.vteam ,u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` ,
                u.`vupb_nomor`,u.vupb_nama , ua.`tupdate`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u
                JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                JOIN plc2.plc2_upb_team ut on ut.iteam_id = u.iteammarketing_id
                join plc2.group_marketing b on b.iGroup_marketing=ut.iGroup_marketing
                WHERE u.`ldeleted` = 0
                AND u.tinfo_paten IS NOT NULL
                AND u.tinfo_paten !=""
                and u.iappdireksi = 2
                AND u.iteammarketing_id IS NOT NULL
                AND u.`iteambusdev_id` = "22"
                AND ua.`vtipe` = "DR"
                AND ua.`iapprove` = 2
                and b.iGroup_marketing=2
                AND ua.`tupdate` >= "'.$perode1.'"
                AND ua.`tupdate` <= "'.$perode2.'"';

            $html .= "<table cellspacing='0' cellpadding='3' width='85%'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>

                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Team Marketing</th>
                            <th>Info Paten</th>
                            <th>Approval Direksi</th>
                        </tr>
            ";

            $upbDetail = $this->db_erp_pk->query($sql1)->result_array();
            $i=0;
            foreach ($upbDetail as $ub) {
                 $i++;

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vteam']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tinfo_paten']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tupdate']."</td>
                          </tr>";

            }

            $html .= "</table><br /> ";

            $detailMKT = '<table border="1" style="border:1px;border-collapse:collapse;">
                            <thead>
                                <th>
                                    No
                                </th>
                                <th>
                                    Marketing
                                </th>
                                <th>
                                    Jumlah UPB
                                </th>
                            </thead>
                            <tbody>';

            $sqlMar = 'select b.vteam,b.iteam_id 
                        from plc2.group_marketing a 
                        join plc2.plc2_upb_team b on b.iGroup_marketing=a.iGroup_marketing
                        where a.iGroup_marketing=2';                      
            $dMar = $this->db_erp_pk->query($sqlMar)->result_array();            
                            $no=1;
                            $retArr = array();
                            foreach ($dMar as $mar) {
                                $sqlCMkt = $sql1.' and iteammarketing_id = "'.$mar['iteam_id'].'"  ';

                                //echo $sqlCMkt;
                                $countMR = $this->db_erp_pk->query($sqlCMkt)->num_rows();

                                array_push($retArr, $countMR);
                                $detailMKT .= '<tr>
                                                    <td>'.$no.'</td>
                                                    <td style="text-align:left;">'.$mar['vteam'].'</td>
                                                    <td>'.$countMR.'</td>
                                              </tr>';
                                    
                                $no++;
                            }
            $detailMKT .=   '</tbody>
                        </table>';

            $smallestMkt = min($retArr);
            $result     = $smallestMkt;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];



            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB /  Marketing</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$detailMKT." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Terkecil</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                        </tr>


                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }
    function BD2_3($post){

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

            $sqlp1='SELECT COUNT(u.`iupb_id`) As t_upb1 FROM plc2.`plc2_upb` u
                JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                WHERE u.`ldeleted` = 0
                AND u.tinfo_paten IS NOT NULL
                AND u.tinfo_paten !=""
                AND u.`iteambusdev_id` = "22"
                and u.iappdireksi = 2
                AND ua.`vtipe` = "DR"
                AND ua.`iapprove` = 2
                AND ua.`tupdate` >= "'.$perode1.'"
                AND ua.`tupdate` <= "'.$perode2.'"
                AND u.`ikategoriupb_id` = 10
                ';

             //Menghitung JumLAH upb (B) Sesuai Parameter 1
            $sqlp2='SELECT COUNT(u.`iupb_id`) As t_upb2 FROM plc2.`plc2_upb` u
                JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                WHERE u.`ldeleted` = 0
                AND u.tinfo_paten IS NOT NULL
                AND u.tinfo_paten !=""
                AND u.`iteambusdev_id` = "22"
                and u.iappdireksi = 2
                AND ua.`vtipe` = "DR"
                AND ua.`iapprove` = 2
                AND ua.`tupdate` >= "'.$perode1.'"
                AND ua.`tupdate` <= "'.$perode2.'"
                ';

            $upb1 = $this->db_erp_pk->query($sqlp1)->row_array();
            $upb2 = $this->db_erp_pk->query($sqlp2)->row_array();

            if($upb2['t_upb2']>0){
                $hasil      =  $upb1['t_upb1']/$upb2['t_upb2']*100;;
                $totb       = number_format( $hasil, 2, '.', '' );
            }else{
                $totb       = 0;
            }

            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";

            $sqlDetail='SELECT pb.vkategori , u.`ikategoriupb_id`, u.tinfo_paten, u.`iupb_id`,
                u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , ua.`tupdate`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u
                JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                WHERE u.`ldeleted` = 0
                AND u.tinfo_paten IS NOT NULL
                AND u.tinfo_paten !=""
                AND u.`iteambusdev_id` = "22"
                and u.iappdireksi = 2
                AND ua.`vtipe` = "DR"
                AND ua.`iapprove` = 2
                AND ua.`tupdate` >= "'.$perode1.'"
                AND ua.`tupdate` <= "'.$perode2.'"
                ';

            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Info Paten</th>
                            <th>Kategori UPB</th>
                            <th>Approval Direksi</th>
                        </tr>
            ";

            $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
            $i=0;
            foreach ($upbDetail as $ub) {
                 $i++;

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tinfo_paten']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vkategori']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tupdate']."</td>
                          </tr>";

            }

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori A</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$upb1['t_upb1']." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata (Jumlah UPB Kategori A / Jumlah UPB)</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                        </tr>


                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }


    function BD2_4($post){
        // dari parameter 5 sebelumnya

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
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqPrareg = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(u.tconfirm_dok_qa) as tconfirm_dok_qa , u.tsubmit_prareg ,
                            ABS(datediff(u.tconfirm_dok_qa, u.tsubmit_prareg)) as selisih,u.iteambusdev_id
                    FROM plc2.plc2_upb u 
                    JOIN hrd.employee e on e.cNip = u.vnip_confirm_dok_qa
                    where u.`ldeleted` = 0 AND u.`iteambusdev_id` = 22 
                    AND u.itipe_id <> 6
                    and u.ineed_prareg=1
                    AND u.iconfirm_dok_qa = 1 AND u.tsubmit_prareg IS NOT NULL
                    AND u.`tsubmit_prareg` >= "'.$perode1.'"
                    AND u.`tsubmit_prareg` <= "'.$perode2.'"
                    ';

        $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='7' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Approval QA Manager Cek Dokumen Prareg</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Team Busdev</th>
                        <th>Approval QA By</th>
                        <th>Tanggal Approval QA</th>
                        <th>Tanggal Submit Prareg</th> 
                        <th>Selisih</th> 
                    </tr>
        "; 

        $cekDouble = array();

        $i=0;
        $sumselisih = 0;
        $total_parareg = 0;
        foreach ($upbPrareg as $ub) {
            $selisih = $this->datediff($ub['tconfirm_dok_qa'],$ub['tsubmit_prareg'],$cNipNya);

            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ub['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }

             $i++;  
             array_push($cekDouble,$ub['iupb_id']);
             $total_parareg++;
             $sumselisih += $selisih;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['cNip']."-".$ub['vName']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tconfirm_dok_qa']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tsubmit_prareg']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$selisih."</td>
                        </tr>"; 

        } 
        $html .= "</table><br /> ";

        //-------------------------------------------------------------------------------------- INI REG

        $sqReq = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(u.tconfirm_registrasi_qa) as tconfirm_registrasi_qa, u.tsubmit_reg , ABS(datediff(u.tconfirm_registrasi_qa, u.tsubmit_reg )) as selisih,u.iteambusdev_id
                    FROM plc2.plc2_upb u 
                    JOIN hrd.employee e on e.cNip = u.cnip_confirm_registrasi_qa
                    where u.`ldeleted` = 0 AND u.`iteambusdev_id` = 22 
                    AND u.itipe_id <> 6
                    and u.ineed_prareg=0
                    AND u.iconfirm_registrasi_qa = 1 AND u.tsubmit_reg IS NOT NULL
                    AND u.`tsubmit_reg` >= "'.$perode1.'"
                    AND u.`tsubmit_reg` <= "'.$perode2.'"
                    ';

        $upbReq = $this->db_erp_pk->query($sqReq)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='7' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Approval QA Manager Cek Dokumen Registrasi</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Team Busdev</th>
                        <th>Approval QA By</th>
                        <th>Tanggal Approval QA</th>
                        <th>Tanggal Submit Registrasi</th> 
                        <th>Selisih</th> 
                    </tr>
        "; 
        $i=0;
        $total_req=0;
        $kurangTotal = 0;
        foreach ($upbReq as $ur) {
            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ur['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }

             $i++; 
             $total_req++;
             if (in_array($ur['iupb_id'], $cekDouble)) {
                $kurangTotal++;
             }

             $selisih = $this->datediff($ur['tconfirm_registrasi_qa'],$ur['tsubmit_reg'],$cNipNya);

             $sumselisih += $selisih;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['cNip']."-".$ur['vName']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['tconfirm_registrasi_qa']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['tsubmit_reg']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$selisih."</td>
                        </tr>"; 

        } 
        $html .= "</table><br /> ";

        $totalUpb  = $total_req + $total_parareg; 
        $jumlahUpb = $totalUpb - $kurangTotal;
        if($sumselisih==0){
          $tot = 0;
        }else{
          $tot = $sumselisih / $totalUpb;
          $tot = $tot/5;
        }
        $result     = number_format($tot,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total UPB Prareg & Reg</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalUpb." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih (Hari)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format($sumselisih)." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata- Rata (Minggu)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Minggu</td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_4xz($post){
        // dari parameter 5 sebelumnya

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
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqPrareg = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, e.cNip, e.vName, u.tconfirm_dok_qa, u.tsubmit_prareg ,
                            ABS(datediff(u.tconfirm_dok_qa, u.tsubmit_prareg)) as selisih,u.iteambusdev_id
                    FROM plc2.plc2_upb u 
                    JOIN hrd.employee e on e.cNip = u.vnip_confirm_dok_qa
                    where u.`ldeleted` = 0 AND u.`iteambusdev_id` = 22 
                    AND u.itipe_id <> 6
                    AND u.iconfirm_dok_qa = 1 AND u.tsubmit_prareg IS NOT NULL
                    AND u.`tsubmit_prareg` >= "'.$perode1.'"
                    AND u.`tsubmit_prareg` <= "'.$perode2.'"
                    ';

        $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='7' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Approval QA Manager Cek Dokumen Prareg</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Team Busdev</th>
                        <th>Approval QA By</th>
                        <th>Tanggal Approval QA</th>
                        <th>Tanggal Submit Prareg</th> 
                        <th>Selisih</th> 
                    </tr>
        "; 

        $cekDouble = array();

        $i=0;
        $sumselisih = 0;
        $total_parareg = 0;
        foreach ($upbPrareg as $ub) {
            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ub['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }

             $i++;  
             array_push($cekDouble,$u['iupb_id']);
             $total_parareg++;
             $sumselisih += $ub['selisih'];
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['cNip']."-".$ub['vName']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tconfirm_dok_qa']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tsubmit_prareg']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['selisih']."</td>
                        </tr>"; 

        } 
        $html .= "</table><br /> ";

        //-------------------------------------------------------------------------------------- INI REG

        $sqReq = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, e.cNip, e.vName, u.tconfirm_registrasi_qa, u.tsubmit_reg , ABS(datediff(u.tconfirm_registrasi_qa, u.tsubmit_reg )) as selisih,u.iteambusdev_id
                    FROM plc2.plc2_upb u 
                    JOIN hrd.employee e on e.cNip = u.cnip_confirm_registrasi_qa
                    where u.`ldeleted` = 0 AND u.`iteambusdev_id` = 22 
                    AND u.itipe_id <> 6
                    AND u.iconfirm_registrasi_qa = 1 AND u.tsubmit_reg IS NOT NULL
                    AND u.`tsubmit_reg` >= "'.$perode1.'"
                    AND u.`tsubmit_reg` <= "'.$perode2.'"
                    ';

        $upbReq = $this->db_erp_pk->query($sqReq)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='7' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Approval QA Manager Cek Dokumen Registrasi</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Team Busdev</th>
                        <th>Approval QA By</th>
                        <th>Tanggal Approval QA</th>
                        <th>Tanggal Submit Registrasi</th> 
                        <th>Selisih</th> 
                    </tr>
        "; 
        $i=0;
        $total_req=0;
        $kurangTotal = 0;
        foreach ($upbReq as $ur) {
            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ur['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }

             $i++; 
             $total_req++;
             if (in_array($ur['iupb_id'], $cekDouble)) {
                $kurangTotal++;
             }
             $sumselisih += $ur['selisih'];
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['cNip']."-".$ur['vName']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['tconfirm_registrasi_qa']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['tsubmit_reg']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['selisih']."</td>
                        </tr>"; 

        } 
        $html .= "</table><br /> ";

        $totalUpb  = $total_req + $total_parareg; 
        $jumlahUpb = $totalUpb - $kurangTotal;
        if($sumselisih==0){
          $tot = 0;
        }else{
          $tot = $sumselisih / $totalUpb;
          $tot = $tot/5;
        }
        $result     = number_format($tot,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total UPB Prareg & Reg</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalUpb." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih (Hari)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format($sumselisih)." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata- Rata (Minggu)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Minggu</td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_4zz($post){
        // dari parameter 5 sebelumnya

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
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqPrareg = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, e.cNip, e.vName, u.tconfirm_dok_qa, u.tsubmit_prareg ,
                            ABS(datediff(u.tconfirm_dok_qa, u.tsubmit_prareg)) as selisih
                    FROM plc2.plc2_upb u 
                    JOIN hrd.employee e on e.cNip = u.vnip_confirm_dok_qa
                    where u.`ldeleted` = 0 AND u.`iteambusdev_id` = 22 
                    AND u.itipe_id <> 6
                    AND u.iconfirm_dok_qa = 1 AND u.tsubmit_prareg IS NOT NULL
                    AND u.`tsubmit_prareg` >= "'.$perode1.'"
                    AND u.`tsubmit_prareg` <= "'.$perode2.'"
                    ';

        $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='7' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Approval QA Manager Cek Dokumen Prareg</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Approval QA By</th>
                        <th>Tanggal Approval QA</th>
                        <th>Tanggal Submit Prareg</th> 
                        <th>Selisih</th> 
                    </tr>
        "; 

        $cekDouble = array();

        $i=0;
        $sumselisih = 0;
        $total_parareg = 0;
        foreach ($upbPrareg as $ub) {
             $i++;  
             array_push($cekDouble,$u['iupb_id']);
             $total_parareg++;
             $sumselisih += $ub['selisih'];
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['cNip']."-".$ub['vName']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tconfirm_dok_qa']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tsubmit_prareg']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['selisih']."</td>
                        </tr>"; 

        } 
        $html .= "</table><br /> ";

        //-------------------------------------------------------------------------------------- INI REG

        $sqReq = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, e.cNip, e.vName, u.tconfirm_registrasi_qa, u.tsubmit_reg , ABS(datediff(u.tconfirm_registrasi_qa, u.tsubmit_reg )) as selisih
                    FROM plc2.plc2_upb u 
                    JOIN hrd.employee e on e.cNip = u.cnip_confirm_registrasi_qa
                    where u.`ldeleted` = 0 AND u.`iteambusdev_id` = 22 
                    AND u.itipe_id <> 6
                    AND u.iconfirm_registrasi_qa = 1 AND u.tsubmit_reg IS NOT NULL
                    AND u.`tsubmit_reg` >= "'.$perode1.'"
                    AND u.`tsubmit_reg` <= "'.$perode2.'"
                    ';

        $upbReq = $this->db_erp_pk->query($sqReq)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='7' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Approval QA Manager Cek Dokumen Registrasi</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Approval QA By</th>
                        <th>Tanggal Approval QA</th>
                        <th>Tanggal Submit Registrasi</th> 
                        <th>Selisih</th> 
                    </tr>
        "; 
        $i=0;
        $total_req=0;
        $kurangTotal = 0;
        foreach ($upbReq as $ur) {
             $i++; 
             $total_req++;
             if (in_array($ur['iupb_id'], $cekDouble)) {
                $kurangTotal++;
             }
             $sumselisih += $ur['selisih'];
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['cNip']."-".$ur['vName']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['tconfirm_registrasi_qa']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['tsubmit_reg']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['selisih']."</td>
                        </tr>"; 

        } 
        $html .= "</table><br /> ";

        $totalUpb  = $total_req + $total_parareg; 
        $jumlahUpb = $totalUpb - $kurangTotal;
        if($sumselisih==0){
          $tot = 0;
        }else{
          $tot = $sumselisih / $totalUpb;
          $tot = $tot/5;
        }
        $result     = number_format($tot,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total UPB Prareg & Reg</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalUpb." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih (Hari)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$jumlahUpb." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata- Rata (Minggu)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Minggu</td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }
    function BD2_4x($post){

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

            $sql_par = 'select a.*,a.tsubmit_prareg,c.tappbusdev from plc2.plc2_upb a
                    join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR"
                    join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
                    join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
                    #Filter Deleted
                    where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0
                    #upb team nya
                    and a.iteambusdev_id="22"
                    #Tanggal Prareg not null
                    and a.tsubmit_prareg is not null
                    #Tanggal Approve BDM not NUll
                    and c.tappbusdev is not null
                    #Tanggal app dir not null
                    and a.iappdireksi = 2 and app.tupdate is not null
                    #periode tanggal prareg
                    and a.tsubmit_prareg >= "'.$perode1.'"
                    and a.tsubmit_prareg <= "'.$perode2.'"
                    group by a.iupb_id
                ';

            $qupb = $this->db_erp_pk->query($sql_par);
            if($qupb->num_rows() > 0) {
                $sumsel=array();
                foreach ($qupb->result_array() as $r => $vrupb) {
                    $tglprareg=date_create($vrupb['tsubmit_prareg']);
                    $tglprio=date_create($vrupb['tappbusdev']);
                    $sumsel[]=$this->selisihbulan($tglprareg,$tglprio);
                }
                $hasil1=intval(array_sum($sumsel))/$qupb->num_rows();
                $totb = number_format( $hasil1, 2, '.', '' );
            }else{
                $totb       = 0;
            }

            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";

            $sqlDetail = 'select a.*,a.tsubmit_prareg,c.tappbusdev,d.vNama_Group from plc2.plc2_upb a
                    join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR"
                    join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
                    join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
                    join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk
                    #Filter Deleted
                    where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0
                    #upb team nya
                    and a.iteambusdev_id="22"
                    #Tanggal Prareg not null
                    and a.tsubmit_prareg is not null
                    #Tanggal Approve BDM not NUll
                    and c.tappbusdev is not null
                    #Tanggal app dir not null
                    and a.iappdireksi = 2 and app.tupdate is not null
                    #periode tanggal prareg
                    and a.tsubmit_prareg >= "'.$perode1.'"
                    and a.tsubmit_prareg <= "'.$perode2.'"
                    group by a.iupb_id
                    ';

            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Group Product</th>
                            <th>Tanggal Setting Prioritas (A)</th>
                            <th>Tanggal Submit Prareg (B)</th>
                            <th>Selesih antara A dan B</th>
                        </tr>
            ";

            $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
            $i=0;
            $tsel=0;
            foreach ($upbDetail as $ub) {
                 $i++;
                 $months=$this->selisihbulan(date_create($ub['tappbusdev']),date_create($ub['tsubmit_prareg']));
                 $selisih = (int) floor($months);
                 $tsel=$tsel+$selisih;

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vNama_Group']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['tappbusdev']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tsubmit_prareg']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$selisih."</td>
                          </tr>";
            }

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$tsel." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata Jangka Waktu (Jumlah Selisih / Jumlah UPB)</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan</td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }
    function BD2_5x($post){

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
            // $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='".$iAspekId."'";
            // $query = $this->db_erp_pk->query($sql);
            // $vAspekName = $query->row()->vAspekName;

            // $sql_par = 'select a.*,a.tsubmit_prareg,c.tappbusdev,kat.vkategori,a.ikategori_id,app.tupdate
            //     from plc2.plc2_upb a
            //     join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR" and app.vmodule="AppUPB-DR"
            //     join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
            //     join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
            //     join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategori_id
            //     #Filter Deleted
            //     where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0 and kat.ldeleted=0
            //     #upb team nya
            //     and a.iteambusdev_id="22"
            //     #Tanggal Prareg not null
            //     and a.tsubmit_prareg is not null
            //     #Tanggal Approve BDM not NUll
            //     and c.tappbusdev is not null
            //     #Tanggal app dir not null
            //     and a.iappdireksi = 2 and app.tupdate is not null
            //     #Kategori UPB A
            //     and a.ikategori_id=10
            //     #periode tanggal
            //     and app.tupdate >= "'.$perode1.'"
            //     and app.tupdate <= "'.$perode2.'"
            //     group by a.iupb_id
            //     ';

            // $qupb = $this->db_erp_pk->query($sql_par);
            // if($qupb->num_rows() > 0) {
            //     $hasil=intval($qupb->num_rows());
            //     $totb = number_format( $hasil, 2, '.', '' );
            // }else{
            //     $totb = 0;
            // }
            // $result     = $totb;
            // $getpoint   = $this->getPoint($result,$iAspekId);
            // $x_getpoint = explode("~", $getpoint);
            // $point      = $x_getpoint['0'];
            // $warna      = $x_getpoint['1'];

            // $html = "
            //         <table>
            //             <tr>
            //                 <td><b>Point Untuk Aspek :</b></td>
            //                 <td>".$vAspekName."</td>

            //             </tr>
            //         </table>";
            // $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
            //             <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
            //                 <th>No</th>
            //                 <th>No UPB</th>
            //                 <th>Nama UPB</th>
            //                 <th>Kode Obat</th>
            //                 <th>Tanggal Approval Direksi</th>
            //                 <th>Tanggal Prareg</th>
            //                 <th>Kategori UPB</th>
            //             </tr>
            // ";

            // $upbDetail = $this->db_erp_pk->query($sql_par)->result_array();
            // $i=0;
            // foreach ($upbDetail as $ub) {
            //      $i++;
            //      $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
            //                 <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
            //                 <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
            //                     ".$ub['vupb_nomor']."</td>
            //                 <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
            //                     ".$ub['vupb_nama']."</td>
            //                 <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
            //                     ".$ub['vKode_obat']."</td>
            //                 <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
            //                     ".date('Y-m-d',strtotime($ub['tupdate']))."</td>
            //                 <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
            //                     ".date('Y-m-d',strtotime($ub['tsubmit_prareg']))."</td>
            //                 <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
            //                     ".$ub['vkategori']."</td>
            //               </tr>";
            // }

            // $html .= "</table><br /> ";

            // $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
            //             <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
            //                 <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
            //             </tr>

            //             <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
            //                 <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>File produk baru(bukan Group Produk) kategori A</td>

            //                 <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
            //             </tr>
            //         </table><br/><br/>";


            // echo $result."~".$point."~".$warna."~".$html;
            $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='".$iAspekId."'";
            $query = $this->db_erp_pk->query($sql);
            $vAspekName = $query->row()->vAspekName;
            $sqlp2 = 'SELECT pb.vkategori , u.`ikategoriupb_id`, u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , u.`tsubmit_prareg`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u
                        JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                        JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                        WHERE u.`ldeleted` = 0
                        AND u.`iteambusdev_id` = 22
                        AND ua.`vtipe` = "DR"
                        AND ua.`iapprove` = 2
                        and u.itipe_id <> 6
                        AND u.tsubmit_prareg IS NOT NULL and  u.tsubmit_prareg <> "0000-00-00"
                        AND u.`tsubmit_prareg` >= "'.$perode1.'"
                        AND u.`tsubmit_prareg` <= "'.$perode2.'"
                        ORDER by  u.`ikategoriupb_id` ';

            $html = "
                    <table width='750px'>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";


            $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategori UPB</th>
                          <th>Tgl Prareg</th>
                        </tr>
            ";
            $i=0;
            $t_a =0;
            $t_all=0;
            $upbDetail = $this->db_erp_pk->query($sqlp2)->result_array();
            foreach ($upbDetail as $ub) {
                 $i++;
                 $col = "";
                 $t_all++;
                 if($ub['vkategori']=="A"){
                   $t_a++;
                   $col = "bgcolor='#C0C0C0'";
                 }

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vkategori']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tsubmit_prareg']."</td>
                          </tr>";

            }

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Seluruhnya </td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$t_all." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori A </td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$t_a." </td>
                        </tr>

                    </table><br/><br/>";

            $result     = $t_a;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];


            echo $result."~".$point."~".$warna."~".$html;
    }
    function BD2_5($post){
        // dari parameter 5 sebelumnya

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
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqPrareg = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, ua.tupdate, u.tsubmit_prareg  ,u.iteambusdev_id,kat.vkategori
                    FROM plc2.`plc2_upb` u
                        JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                        JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                        join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=u.ikategoriupb_id
                    WHERE u.`ldeleted` = 0 
                    AND u.tsubmit_prareg IS NOT NULL AND u.tsubmit_prareg <>"0000-00-00"
                    AND u.`iteambusdev_id` = 22
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.itipe_id <> 6
                    and u.ineed_prareg = 1
                    AND u.ldeleted = 0 
                    AND u.ikategoriupb_id = 10 # Kategori A
                    AND u.`tsubmit_prareg` >= "'.$perode1.'"
                    AND u.`tsubmit_prareg` <= "'.$perode2.'"
                    ';

        $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Submit Prareg</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th> 
                        <th>Team Busdev</th> 
                        <th>Kategori</th> 
                        <th>Tanggal Approval Direksi</th>
                        <th>Tanggal Submit Prareg</th> 
                    </tr>
        "; 

        $cekDouble = array();

        $i=0;
        $total_parareg = 0;
        foreach ($upbPrareg as $ub) {
            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ub['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }

             $i++; 
             array_push($cekDouble,$ub['iupb_id']);
             $total_parareg++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vkategori']."</td>
                                
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tupdate']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tsubmit_prareg']."</td>
                        </tr>"; 

        } 
        $html .= "</table><br /> ";

        //-------------------------------------------------------------------------------------- INI REG

        $sqReq = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, ua.tupdate, u.tregistrasi  ,u.iteambusdev_id,kat.vkategori
                    FROM plc2.`plc2_upb` u
                        JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                        JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                        join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=u.ikategoriupb_id
                    WHERE u.`ldeleted` = 0 
                    AND u.tregistrasi IS NOT NULL AND u.tregistrasi <>"0000-00-00"
                    AND u.`iteambusdev_id` = 22
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.itipe_id <> 6
                    AND u.ldeleted = 0
                    and u.ineed_prareg = 0
                    AND u.ikategoriupb_id = 10 # Kategori A
                    AND u.`tregistrasi` >= "'.$perode1.'"
                    AND u.`tregistrasi` <= "'.$perode2.'"
                    '; 


        $upbReq = $this->db_erp_pk->query($sqReq)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Submit Registrasi</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th> 
                        <th>Team Busdev</th> 
                        <th>Kategori</th> 
                        <th>Tanggal Approval Direksi</th>
                        <th>Tanggal Submit Registrasi</th> 
                    </tr>
        "; 
        $i=0;
        $total_req=0;
        $kurangTotal = 0;
        foreach ($upbReq as $ur) {
            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ur['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }

             $i++; 
             $total_req++;
             if (in_array($ur['iupb_id'], $cekDouble)) {
                $kurangTotal++;
             }
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['vupb_nama']."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vkategori']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['tupdate']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['tregistrasi']."</td>
                        </tr>"; 

        } 
        $html .= "</table><br /> ";

        $totalUpb  = $total_req + $total_parareg; 
        $jumlahUpb = $totalUpb - $kurangTotal; 
        $result     = number_format($jumlahUpb);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total UPB Prareg & Reg</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalUpb." </td>
                    </tr>
                    
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }
    function BD2_5xy($post){
        // dari parameter 5 sebelumnya

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
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqPrareg = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, ua.tupdate, u.tsubmit_prareg  ,u.iteambusdev_id
                    FROM plc2.`plc2_upb` u
                        JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                        JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    WHERE u.`ldeleted` = 0 
                    AND u.tsubmit_prareg IS NOT NULL AND u.tsubmit_prareg <>"0000-00-00"
                    AND u.`iteambusdev_id` = 22
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.itipe_id <> 6
                    and u.ineed_prareg = 1
                    AND u.ldeleted = 0 
                    AND u.`tsubmit_prareg` >= "'.$perode1.'"
                    AND u.`tsubmit_prareg` <= "'.$perode2.'"
                    ';

        $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Approval Busdev Manager Prareg</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th> 
                        <th>Team Busdev</th> 
                        <th>Tanggal Approval Busdev</th>
                        <th>Tanggal Submit Prareg</th> 
                    </tr>
        "; 

        $cekDouble = array();

        $i=0;
        $total_parareg = 0;
        foreach ($upbPrareg as $ub) {
            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ub['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }

             $i++; 
             array_push($cekDouble,$u['iupb_id']);
             $total_parareg++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tupdate']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tsubmit_prareg']."</td>
                        </tr>"; 

        } 
        $html .= "</table><br /> ";

        //-------------------------------------------------------------------------------------- INI REG

        $sqReq = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, ua.tupdate, u.tregistrasi  ,u.iteambusdev_id
                    FROM plc2.`plc2_upb` u
                        JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                        JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    WHERE u.`ldeleted` = 0 
                    AND u.tregistrasi IS NOT NULL AND u.tregistrasi <>"0000-00-00"
                    AND u.`iteambusdev_id` = 22
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.itipe_id <> 6
                    AND u.ldeleted = 0
                    and u.ineed_prareg = 0
                    AND u.`tregistrasi` >= "'.$perode1.'"
                    AND u.`tregistrasi` <= "'.$perode2.'"
                    '; 

        $upbReq = $this->db_erp_pk->query($sqReq)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Approval QA Manager Cek Dokumen Registrasi</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th> 
                        <th>Team Busdev</th> 
                        
                        <th>Tanggal Approval QA</th>
                        <th>Tanggal Submit Registrasi</th> 
                    </tr>
        "; 
        $i=0;
        $total_req=0;
        $kurangTotal = 0;
        foreach ($upbReq as $ur) {
            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ur['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }

             $i++; 
             $total_req++;
             if (in_array($ur['iupb_id'], $cekDouble)) {
                $kurangTotal++;
             }
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['vupb_nama']."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['tupdate']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['tregistrasi']."</td>
                        </tr>"; 

        } 
        $html .= "</table><br /> ";

        $totalUpb  = $total_req + $total_parareg; 
        $jumlahUpb = $totalUpb - $kurangTotal; 
        $result     = number_format($jumlahUpb);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total UPB Prareg & Reg</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalUpb." </td>
                    </tr>
                    
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_5xx($post){
        // dari parameter 5 sebelumnya

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
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqPrareg = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, ua.tupdate, u.tsubmit_prareg  
                    FROM plc2.`plc2_upb` u
                        JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                        JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    WHERE u.`ldeleted` = 0 
                    AND u.tsubmit_prareg IS NOT NULL AND u.tsubmit_prareg <>"0000-00-00"
                    AND u.`iteambusdev_id` = 22
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.itipe_id <> 6
                    AND u.ldeleted = 0 
                    AND u.`tsubmit_prareg` >= "'.$perode1.'"
                    AND u.`tsubmit_prareg` <= "'.$perode2.'"
                    ';

        $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Approval Busdev Manager Prareg</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th> 
                        <th>Tanggal Approval Busdev</th>
                        <th>Tanggal Submit Prareg</th> 
                    </tr>
        "; 

        $cekDouble = array();

        $i=0;
        $total_parareg = 0;
        foreach ($upbPrareg as $ub) {
             $i++; 
             array_push($cekDouble,$u['iupb_id']);
             $total_parareg++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tupdate']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tsubmit_prareg']."</td>
                        </tr>"; 

        } 
        $html .= "</table><br /> ";

        //-------------------------------------------------------------------------------------- INI REG

        $sqReq = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, ua.tupdate, u.tregistrasi  
                    FROM plc2.`plc2_upb` u
                        JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                        JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    WHERE u.`ldeleted` = 0 
                    AND u.tregistrasi IS NOT NULL AND u.tregistrasi <>"0000-00-00"
                    AND u.`iteambusdev_id` = 22
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.itipe_id <> 6
                    AND u.ldeleted = 0
                    AND u.`tregistrasi` >= "'.$perode1.'"
                    AND u.`tregistrasi` <= "'.$perode2.'"
                    '; 

        $upbReq = $this->db_erp_pk->query($sqReq)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Approval QA Manager Cek Dokumen Registrasi</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th> 
                        <th>Tanggal Approval QA</th>
                        <th>Tanggal Submit Registrasi</th> 
                    </tr>
        "; 
        $i=0;
        $total_req=0;
        $kurangTotal = 0;
        foreach ($upbReq as $ur) {
             $i++; 
             $total_req++;
             if (in_array($ur['iupb_id'], $cekDouble)) {
                $kurangTotal++;
             }
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['vupb_nama']."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['tupdate']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['tregistrasi']."</td>
                        </tr>"; 

        } 
        $html .= "</table><br /> ";

        $totalUpb  = $total_req + $total_parareg; 
        $jumlahUpb = $totalUpb - $kurangTotal; 
        $result     = number_format($jumlahUpb);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total UPB Prareg & Reg</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalUpb." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr> 
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }
    function BD2_6($post){
        // dari parameter 5 sebelumnya

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

        $cekDouble = array();

            $sqlMar = 'select b.iteam_id 
                from plc2.group_marketing a 
                join plc2.plc2_upb_team b on b.iGroup_marketing=a.iGroup_marketing
                where a.iGroup_marketing=2';                      
            $dMar = $this->db_erp_pk->query($sqlMar)->result_array();            
            $no=1;
            $arrMarketing = array();
            foreach ($dMar as $mar) {
                $arrMarketing[$mar['iteam_id']]=0;

                //$arrMarketing[]=$mar['iteam_id'];
            }

            

        $sql2='SELECT ut.vteam, u.`ikategoriupb_id`, u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , u.`tsubmit_prareg`, u.vKode_obat, u.iteammarketing_id , u.iteambusdev_id
            FROM plc2.`plc2_upb` u
            JOIN plc2.plc2_upb_team ut on ut.iteam_id = u.iteammarketing_id
            join plc2.group_marketing b on b.iGroup_marketing=ut.iGroup_marketing
            WHERE u.`ldeleted` = 0
            AND u.`iteambusdev_id` = 22
            and ineed_prareg = 1
            AND u.iteammarketing_id IS NOT NULL
            and b.iGroup_marketing=2
            AND u.tsubmit_prareg IS NOT NULL
            and u.itipe_id <> 6
            AND u.`tsubmit_prareg` >= "'.$perode1.'"
            AND u.`tsubmit_prareg` <= "'.$perode2.'"
            order by u.iteammarketing_id';


        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                      <th>No</th>
                      <th>No UPB</th>
                      <th>Nama UPB</th>
                      <th>Team Busdev</th>
                      <th>Team Marketing</th>
                      <th>Tgl Prareg</th>
                    </tr>
        ";

        $arrayname = array();
        $i=0;
        $upbDetail = $this->db_erp_pk->query($sql2)->result_array();
        foreach ($upbDetail as $ub) {

            $arrMarketing[$ub['iteammarketing_id']] +=1;

            

            if (in_array($ub['iteammarketing_id'], $cekDouble)) {
                
            }else{
               array_push($cekDouble,$ub['iteammarketing_id']); 
            }

            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ub['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }

             $i++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$k."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['vteam']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['tsubmit_prareg']."</td>
                      </tr>";

        }


        /*print_r($arrMarketing);
            exit;*/

       
        $html .= "</table><br /> ";





        $html .= "<br />";

        $sql2='SELECT ut.vteam, u.`ikategoriupb_id`, u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , u.`tregistrasi`, u.vKode_obat, u.iteammarketing_id , u.iteambusdev_id
            FROM plc2.`plc2_upb` u
            JOIN plc2.plc2_upb_team ut on ut.iteam_id = u.iteammarketing_id
            join plc2.group_marketing b on b.iGroup_marketing=ut.iGroup_marketing
            WHERE u.`ldeleted` = 0
            AND u.`iteambusdev_id` = 22
            and ineed_prareg = 0
            AND u.iteammarketing_id IS NOT NULL
            and b.iGroup_marketing=2
            AND u.tregistrasi IS NOT NULL
            and u.itipe_id <> 6
            AND u.`tregistrasi` >= "'.$perode1.'"
            AND u.`tregistrasi` <= "'.$perode2.'"
            order by u.iteammarketing_id';



        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                      <th>No</th>
                      <th>No UPB</th>
                      <th>Nama UPB</th>
                      <th>Team Busdev</th>
                      <th>Team Marketing</th>
                      <th>Tgl Registrasi</th>
                    </tr>
        ";


        $ii=0;
        $upbDetail = $this->db_erp_pk->query($sql2)->result_array();
        foreach ($upbDetail as $ub) {
            $arrMarketing[$ub['iteammarketing_id']] +=1;

            if (in_array($ub['iteammarketing_id'], $cekDouble)) {
                
            }else{
               array_push($cekDouble,$ub['iteammarketing_id']); 
            }


            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ub['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }

             $ii++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$ii."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$k."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['vteam']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['tregistrasi']."</td>
                      </tr>";

        }


        $isum = $i+$ii;
        
        //$counts = array_column($dealers, 'count');
        // find index of min value
        //$index = array_search(min($counts), $counts, true);

        $tot        =  min($arrMarketing); #Jumlah UPB yang paling sedikit marketingnya
        $result     = number_format($tot,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Seluruh UPB </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$isum." UPB </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Terkecil </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$tot." Marketing</td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }
    function BD2_6x($post){

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

            $sql_par = 'select a.*,a.tsubmit_prareg,a.ttarget_hpr,kat.vkategori
                from plc2.plc2_upb a
                join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR"
                join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
                join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
                join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategori_id
                #Filter Deleted
                where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0
                #upb team nya
                and a.iteambusdev_id="22"
                #Tanggal Prareg not null
                and a.tsubmit_prareg is not null
                #Tanggal Approve BDM not NUll
                and c.tappbusdev is not null
                #Tanggal HPR Not NULl
                and a.ttarget_hpr is not null
                #Kategori UPB A
                and a.ikategoriupb_id=10
                #Tanggal app dir not null
                and a.iappdireksi = 2 and app.tupdate is not null
                #periode tanggal prareg
                and a.ttarget_hpr >= "'.$perode1.'"
                and a.ttarget_hpr <= "'.$perode2.'"
                group by a.iupb_id
                ';


            $qupb = $this->db_erp_pk->query($sql_par);
            if($qupb->num_rows() > 0) {
                $sumsel=array();
                foreach ($qupb->result_array() as $r => $vrupb) {
                    $tgl1=date_create($vrupb['ttarget_hpr']);
                    $tgl2=date_create($vrupb['tsubmit_prareg']);
                    $sumsel[]=$this->selisihbulan($tgl1,$tgl2);
                }
                $hasil1=intval(array_sum($sumsel))/$qupb->num_rows();

                $totb = number_format( $hasil1, 2, '.', '' );

            }else{
                $totb = 0 ;

            }

            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";


            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Kategori UPB</th>
                            <th>Tanggal Submit Prareg (A)</th>
                            <th>Tanggal HPR (B)</th>
                            <th>Selesih antara A dan B - Bulan</th>
                        </tr>
            ";

            $upbDetail = $this->db_erp_pk->query($sql_par)->result_array();
            $i=0;
            $tsel=0;
            foreach ($upbDetail as $ub) {
                 $i++;
                 $months=$this->selisihbulan(date_create($ub['tsubmit_prareg']),date_create($ub['ttarget_hpr']));
                 $selisih = (int) floor($months);
                 $tsel=$tsel+$selisih;

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vNama_Group']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['tsubmit_prareg']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['ttarget_hpr']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$selisih."</td>
                          </tr>";
            }

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$tsel." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata Jangka Waktu (Jumlah Selisih / Jumlah UPB)</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan</td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_7($post){
        // dari parameter 5 sebelumnya

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

         
        $sqlRata = 'SELECT  pu.`vupb_nomor`,pu.vupb_nama , pb.vkategori , pu.`tsubmit_prareg`,pu.`ttarget_hpr` , ABS(datediff(pu.`ttarget_hpr`, pu.`tsubmit_prareg`)) as selisih,pu.iteambusdev_id
            FROM plc2.`plc2_upb` pu
            JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = pu.`ikategoriupb_id`
            WHERE
            pu.`ldeleted` = 0
            AND pu.`tsubmit_prareg` IS NOT NULL
            AND pu.`ttarget_hpr` IS NOT NULL AND pu.`ttarget_hpr` <>"0000-00-00"
            AND pu.`ikategoriupb_id` = 10
            AND pu.`iteambusdev_id` = 22
            and pu.itipe_id <> 6
            AND pu.`ttarget_hpr` >= "'.$perode1.'"
            AND pu.`ttarget_hpr` <= "'.$perode2.'" ';  

        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <th>No</th>
                    <th>No UPB</th>
                    <th>Nama UPB</th> 
                    <th>Team Busdev</th> 
                    <th>Kategori UPB</th>
                    <th>Tanggal HPR</th>
                    <th>Tanggal Prareg</th>
                    <th>Selisih (Bulan)</th>
                    </tr>
        ";
 
        $upbDetail = $this->db_erp_pk->query($sqlRata)->result_array(); 
        $i = 0;
        $totalUpb=0;
        $totalSls=0;
        foreach ($upbDetail as $ub) { 
            
            $selisih = $this->getDurasiBulan($ub['tsubmit_prareg'],$ub['ttarget_hpr']);

            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ub['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }
             $i++;
             $totalUpb++;
             $totalSls += $selisih;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td> 
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['ttarget_hpr']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['tsubmit_prareg']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$selisih."</td>
                      </tr>"; 
        }

        $tot        = $totalSls/$totalUpb;   
        $result     = number_format($tot,2);
        //$result     = number_format(($result/22),2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalUpb." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih Bulan</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalSls." Bulan </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Rata -Rata Selisih Bulan</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan </td>
                    </tr> 
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_7zz($post){
        // dari parameter 5 sebelumnya

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

         
        $sqlRata = 'SELECT  pu.`vupb_nomor`,pu.vupb_nama , pb.vkategori , pu.`tsubmit_prareg`,pu.`ttarget_hpr` , ABS(datediff(pu.`ttarget_hpr`, pu.`tsubmit_prareg`)) as selisih,pu.iteambusdev_id
            FROM plc2.`plc2_upb` pu
            JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = pu.`ikategoriupb_id`
            WHERE
            pu.`ldeleted` = 0
            AND pu.`tsubmit_prareg` IS NOT NULL
            AND pu.`ttarget_hpr` IS NOT NULL AND pu.`ttarget_hpr` <>"0000-00-00"
            AND pu.`ikategoriupb_id` = 10
            AND pu.`iteambusdev_id` = 22
            and pu.itipe_id <> 6
            AND pu.`ttarget_hpr` >= "'.$perode1.'"
            AND pu.`ttarget_hpr` <= "'.$perode2.'" ';  

        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <th>No</th>
                    <th>No UPB</th>
                    <th>Nama UPB</th> 
                    <th>Team Busdev</th> 
                    <th>Kategori UPB</th>
                    <th>Tanggal HPR</th>
                    <th>Tanggal Prareg</th>
                    <th>Selisih (Hari)</th>
                    </tr>
        ";
 
        $upbDetail = $this->db_erp_pk->query($sqlRata)->result_array(); 
        $i = 0;
        $totalUpb=0;
        $totalSls=0;
        foreach ($upbDetail as $ub) { 
            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ub['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }
             $i++;
             $totalUpb++;
             $totalSls += $ub['selisih'];
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td> 
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['ttarget_hpr']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['tsubmit_prareg']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['selisih']."</td>
                      </tr>"; 
        }

        $tot        = $totalSls/$totalUpb;   
        $result     = number_format($tot,2);
        $result     = number_format(($result/22),2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalUpb." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih Hari</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalSls." Hari </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih Bulan</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan </td>
                    </tr> 
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }
    function BD2_7xx($post){
        // dari parameter 5 sebelumnya

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

         
        $sqlRata = 'SELECT  pu.`vupb_nomor`,pu.vupb_nama , pb.vkategori , pu.`tsubmit_prareg`,pu.`ttarget_hpr` , ABS(datediff(pu.`ttarget_hpr`, pu.`tsubmit_prareg`)) as selisih
            FROM plc2.`plc2_upb` pu
            JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = pu.`ikategoriupb_id`
            WHERE
            pu.`ldeleted` = 0
            AND pu.`tsubmit_prareg` IS NOT NULL
            AND pu.`ttarget_hpr` IS NOT NULL AND pu.`ttarget_hpr` <>"0000-00-00"
            AND pu.`ikategoriupb_id` = 10
            AND pu.`iteambusdev_id` = 22
            and pu.itipe_id <> 6
            AND pu.`ttarget_hpr` >= "'.$perode1.'"
            AND pu.`ttarget_hpr` <= "'.$perode2.'" ';  

        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <th>No</th>
                    <th>No UPB</th>
                    <th>Nama UPB</th> 
                    <th>Kategori UPB</th>
                    <th>Tanggal HPR</th>
                    <th>Tanggal Prareg</th>
                    <th>Selisih (Hari)</th>
                    </tr>
        ";
 
        $upbDetail = $this->db_erp_pk->query($sqlRata)->result_array(); 
        $i = 0;
        $totalUpb=0;
        $totalSls=0;
        foreach ($upbDetail as $ub) { 
             $i++;
             $totalUpb++;
             $totalSls += $ub['selisih'];
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['ttarget_hpr']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['tsubmit_prareg']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['selisih']."</td>
                      </tr>"; 
        }

        $tot        = $totalSls/22;   
        $result     = number_format($tot,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalUpb." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih Hari</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalSls." Hari </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih Bulan</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan </td>
                    </tr> 
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }
    function BD2_7x($post){

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

            $sql_par = 'select a.*,a.tregistrasi,a.ttarget_hpr,kat.vkategori
                from plc2.plc2_upb a
                join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR"
                join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
                join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
                join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategoriupb_id
                #Filter Deleted
                where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0
                #upb team nya
                and a.iteambusdev_id="22"
                #Tanggal HPR Not NULl
                and a.ttarget_hpr is not null
                #Tanggal Registrasi Not Null
                and a.tregistrasi is not null
                #Kategori UPB A
                and a.ikategoriupb_id=10
                #Tanggal app dir not null
                and a.iappdireksi = 2 and app.tupdate is not null
                #periode tanggal prareg
                and a.tregistrasi >= "'.$perode1.'"
                and a.tregistrasi <= "'.$perode2.'"
                group by a.iupb_id
                ';


            $qupb = $this->db_erp_pk->query($sql_par);
            if($qupb->num_rows() > 0) {
                $sumsel=array();
                foreach ($qupb->result_array() as $r => $vrupb) {
                    $tgl1=$vrupb['tregistrasi'];
                    $tgl2=$vrupb['ttarget_hpr'];
                    $sumsel[]=$this->selisihminggu($tgl1,$tgl2);
                }
                $hasil1=intval(array_sum($sumsel))/$qupb->num_rows();

                $totb = number_format( $hasil1, 2, '.', '' );

            }else{
                $totb = 0 ;
            }


            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";


            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Kategori UPB</th>
                            <th>Tanggal HPR (A)</th>
                            <th>Tanggal Registrasi (B)</th>
                            <th>Selesih antara A dan B - Minggu</th>
                        </tr>
            ";

            $upbDetail = $this->db_erp_pk->query($sql_par)->result_array();
            $i=0;
            $tsel=0;
            foreach ($upbDetail as $ub) {
                 $i++;
                 $months=$this->selisihminggu($ub['ttarget_hpr'],$ub['tregistrasi']);
                 $selisih = (int) floor($months);
                 $tsel=$tsel+$selisih;

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vkategori']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['ttarget_hpr']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['tregistrasi']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$selisih."</td>
                          </tr>";
            }

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$tsel." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata Jangka Waktu (Jumlah Selisih / Jumlah UPB)</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Minggu</td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }
    function BD2_8($post){

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

            $sql_par = 'select
                #group distinct karena hanya mengambil jumlah group produk
                count(distinct(a.iGroup_produk)) jum
                #a.dinput_applet,a.*
                from plc2.plc2_upb a
                join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR"
                join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
                join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk
                #Filter Deleted
                where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0
                #upb team nya
                and a.iteambusdev_id="22"
                #Tanggal Applet Not NULl
                and a.dinput_applet is not null
                #Kategori UPB A
                and a.ikategoriupb_id=10
                #Tanggal app dir not null
                and a.iappdireksi = 2 and app.tupdate is not null
                #periode tanggal prareg
                and a.dinput_applet >= "'.$perode1.'"
                and a.dinput_applet <= "'.$perode2.'"
                ';


            $qupb = $this->db_erp_pk->query($sql_par);
            if($qupb->num_rows() > 0) {
                $dr=$qupb->row_array();
                $totb = number_format( $dr['jum'], 2, '.', '' );
            }else{
                $totb = 0 ;
            }


            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";


            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Kategori UPB</th>
                            <th>Tanggal Applet</th>
                            <th>Kategori Group Produk</th>
                        </tr>
            ";

            $sqlDetail = 'select
                    #group distinct karena hanya mengambil jumlah group produk
                    #count(distinct(a.iGroup_produk)) jum
                    distinct(a.vupb_nomor),a.vupb_nama,a.dinput_applet,d.vNama_Group,kat.vkategori
                    from plc2.plc2_upb a
                    join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR"
                    join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
                    join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
                    join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk
                    join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategoriupb_id
                    #Filter Deleted
                    where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0
                    #upb team nya
                    and a.iteambusdev_id="22"
                    #Tanggal Applet Not NULl
                    and a.dinput_applet is not null
                    #Kategori UPB A
                    and a.ikategoriupb_id=10
                    #Tanggal app dir not null
                    and a.iappdireksi = 2 and app.tupdate is not null
                    #periode tanggal prareg
                    and a.dinput_applet >= "'.$perode1.'"
                    and a.dinput_applet <= "'.$perode2.'"';
            $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
            $i=0;
            $tsel=0;
            foreach ($upbDetail as $ub) {
                 $i++;
                 $months=$this->selisihminggu($ub['ttarget_hpr'],$ub['tregistrasi']);
                 $selisih = (int) floor($months);
                 $tsel=$tsel+$selisih;

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vkategori']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['dinput_applet']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vNama_Group']."</td>
                          </tr>";
            }

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Realisasi produk baru Applet nomor registrasi A (total)</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Group</td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }
    function BD2_9($post){

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


            $sql_par = 'select
                #group distinct karena hanya mengambil jumlah group produk
                count(distinct(a.iGroup_produk)) jum
                #a.dinput_applet,a.*
                from plc2.plc2_upb a
                join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR"
                join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
                join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk
                #Filter Deleted
                where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0
                #upb team nya
                and a.iteambusdev_id="22"
                #Tanggal Applet Not NULl
                and a.dinput_applet is not null
                #Kategori UPB B
                and a.ikategoriupb_id=11
                #Tanggal app dir not null
                and a.iappdireksi = 2 and app.tupdate is not null
                #periode tanggal prareg
                and a.dinput_applet >= "'.$perode1.'"
                and a.dinput_applet <= "'.$perode2.'"
                ';


            $qupb = $this->db_erp_pk->query($sql_par);
            if($qupb->num_rows() > 0) {
                $dr=$qupb->row_array();
                $totb = number_format( $dr['jum'], 2, '.', '' );
            }else{
                $totb = 0 ;
            }


            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";


            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Kategori UPB</th>
                            <th>Tanggal Applet</th>
                            <th>Kategori Group Produk</th>
                        </tr>
            ";

            $sqlDetail = 'select
                    #group distinct karena hanya mengambil jumlah group produk
                    #count(distinct(a.iGroup_produk)) jum
                    distinct(a.vupb_nomor),a.vupb_nama,a.dinput_applet,d.vNama_Group,kat.vkategori
                    from plc2.plc2_upb a
                    join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR"
                    join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
                    join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
                    join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk
                    join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategoriupb_id
                    #Filter Deleted
                    where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0
                    #upb team nya
                    and a.iteambusdev_id="22"
                    #Tanggal Applet Not NULl
                    and a.dinput_applet is not null
                    #Kategori UPB B
                    and a.ikategoriupb_id=11 
                    #Tanggal app dir not null
                    and a.iappdireksi = 2 and app.tupdate is not null
                    #periode tanggal prareg
                    and a.dinput_applet >= "'.$perode1.'"
                    and a.dinput_applet <= "'.$perode2.'"';
            $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
            $i=0;
            $tsel=0;
            foreach ($upbDetail as $ub) {
                 $i++;
                 $months=$this->selisihminggu($ub['ttarget_hpr'],$ub['tregistrasi']);
                 $selisih = (int) floor($months);
                 $tsel=$tsel+$selisih;

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vkategori']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['dinput_applet']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vNama_Group']."</td>
                          </tr>";
            }

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Realisasi Applet nomor registrasi produk baru B (total)</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Group</td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_10z($post){
        // dari parameter 5 sebelumnya

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

        
        $sqlReq = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama,  u.tregistrasi , pb.vkategori,
                        u.dinput_applet,u.dNie,
                    ABS(datediff(u.tregistrasi, IF(u.dinput_applet IS NOT NULL and  u.dinput_applet<>"0000-00-00", u.dinput_applet, u.dNie))) AS SELISIH

                    FROM plc2.`plc2_upb` u 
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    WHERE u.`ldeleted` = 0 
                        AND u.tregistrasi IS NOT NULL AND u.tregistrasi <>"0000-00-00"
                        AND u.`iteambusdev_id` = 22  
                        AND u.itipe_id <> 6
                        AND u.ldeleted = 0
                        AND (u.`ikategoriupb_id` = 10  or u.`ikategoriupb_id` = 1 or u.`ikategoriupb_id` = 20 or u.`ikategoriupb_id` = 21 or u.`ikategoriupb_id` = 22)
                        AND 
                        IF(u.dinput_applet IS not NULL and u.dinput_applet<>"0000-00-00",
                            u.dinput_applet IS NOT NULL 
                            AND u.dinput_applet <> "0000-00-00" 
                            AND u.dinput_applet >= "'.$perode1.'" 
                            AND u.dinput_applet <= "'.$perode2.'" 
                            , 
                            u.dNie IS NOT NULL 
                            AND u.dNie <> "0000-00-00" 
                            AND u.dNie >= "'.$perode1.'" 
                            AND u.dNie <= "'.$perode2.'" 
                            
                        )';
 

       
        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategori UPB</th>   
                          <th>Tanggal Registrasi</th> 
                          <th>Tanggal Applet</th> 
                          <th>Tanggal NIE</th> 
                          <th>Selisih </th> 
                    </tr>
        ";
        $i=0; 
        $selisih = 0; 
        $upbDetail = $this->db_erp_pk->query($sqlReq)->result_array();
        foreach ($upbDetail as $ub) {
             $i++;  
             $selisih += $ub['SELISIH'];
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td> 
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tregistrasi']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dinput_applet']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dNie']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['SELISIH']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        if($selisih==0){
            $result = 0;
            /*$result  = number_format($tot,2);
            $result  = number_format(($result/22),2);*/

        }else{
            $tot = $selisih/$i;
            $result     = number_format($tot,2);
            $result     = number_format(($result/22),2);

            
        } 


        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori A </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                    </tr> 

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Hari)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format($selisih,2)." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr> 
                </table><br/><br/>";
 

        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_10($post){
        // dari parameter 5 sebelumnya

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

        
        $sqlReq = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama,  u.tregistrasi , pb.vkategori,
                        u.dinput_applet,u.dNie,
                    ABS(datediff(u.tregistrasi, IF(u.dinput_applet IS NOT NULL and  u.dinput_applet<>"0000-00-00", u.dinput_applet, u.dNie))) AS SELISIH

                    FROM plc2.`plc2_upb` u 
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    WHERE u.`ldeleted` = 0 
                        AND u.tregistrasi IS NOT NULL AND u.tregistrasi <>"0000-00-00"
                        AND u.`iteambusdev_id` = 22  
                        AND u.itipe_id <> 6
                        AND u.ldeleted = 0
                        AND (u.`ikategoriupb_id` = 10  or u.`ikategoriupb_id` = 1 or u.`ikategoriupb_id` = 20 or u.`ikategoriupb_id` = 21 or u.`ikategoriupb_id` = 22)
                        AND 
                        IF(u.dinput_applet IS not NULL and u.dinput_applet<>"0000-00-00",
                            u.dinput_applet IS NOT NULL 
                            AND u.dinput_applet <> "0000-00-00" 
                            AND u.dinput_applet >= "'.$perode1.'" 
                            AND u.dinput_applet <= "'.$perode2.'" 
                            , 
                            u.dNie IS NOT NULL 
                            AND u.dNie <> "0000-00-00" 
                            AND u.dNie >= "'.$perode1.'" 
                            AND u.dNie <= "'.$perode2.'" 
                            
                        )';
 

       
        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategori UPB</th>   
                          <th>Tanggal Registrasi</th> 
                          <th>Tanggal Applet</th> 
                          <th>Tanggal NIE</th> 
                          <th>Selisih </th> 
                    </tr>
        ";
        $i=0; 
        $selisih = 0; 
        $upbDetail = $this->db_erp_pk->query($sqlReq)->result_array();
        foreach ($upbDetail as $ub) {

            $tgl1=$ub['tregistrasi'];

            if($ub['dinput_applet'] <> ''){
                $tgl2=$ub['dinput_applet'];
            }else{
                $tgl2=$ub['dNie'];
            }
            
            $sel = $this->getDurasiBulan($tgl1,$tgl2);

             $i++;  
             $selisih += $sel;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td> 
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tregistrasi']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dinput_applet']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dNie']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$sel."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        if($selisih==0){
            $result = 0;
            /*$result  = number_format($tot,2);
            $result  = number_format(($result/22),2);*/

        }else{
            $tot = $selisih/$i;
            $result     = number_format($tot,2);
            /*$result     = number_format(($result/22),2);*/

            
        } 


        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori A </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                    </tr> 

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format($selisih,2)." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - Rata Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr> 
                </table><br/><br/>";
 

        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_10xx($post){
        // dari parameter 5 sebelumnya

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

        
        $sqlReq = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama,  u.tregistrasi , pb.vkategori,
                    IF(u.dinput_applet IS NULL or u.dinput_applet<>"0000-00-00", u.dinput_applet, u.dNie) AS TAMPIL,
                    ABS(datediff(u.tregistrasi, IF(u.dinput_applet IS NULL or u.dinput_applet<>"0000-00-00", u.dinput_applet, u.dNie))) AS SELISIH
                    FROM plc2.`plc2_upb` u 
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    WHERE u.`ldeleted` = 0 
                        AND u.tregistrasi IS NOT NULL AND u.tregistrasi <>"0000-00-00"
                        AND u.`iteambusdev_id` = 22  
                        AND u.itipe_id <> 6
                        AND u.ldeleted = 0
                        AND (u.`ikategoriupb_id` = 10  or u.`ikategoriupb_id` = 1 or u.`ikategoriupb_id` = 20 or u.`ikategoriupb_id` = 21 or u.`ikategoriupb_id` = 22)
                        AND 
                        IF(u.dinput_applet IS NULL AND u.dinput_applet<>"0000-00-00",u.dNie IS NOT NULL 
                            AND u.dNie <> "0000-00-00" 
                            AND u.dNie >= "'.$perode1.'" 
                            AND u.dNie <= "'.$perode2.'" , 
                            u.dinput_applet IS NOT NULL 
                            AND u.dinput_applet <> "0000-00-00" 
                            AND u.dinput_applet >= "'.$perode1.'" 
                            AND u.dinput_applet <= "'.$perode2.'" 
                        )';
 

       
        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategori UPB</th>   
                          <th>Tanggal Registrasi</th> 
                          <th>Tanggal Applet/NIE</th> 
                          <th>Selisih </th> 
                    </tr>
        ";
        $i=0; 
        $selisih = 0; 
        $upbDetail = $this->db_erp_pk->query($sqlReq)->result_array();
        foreach ($upbDetail as $ub) {
             $i++;  
             $selisih += $ub['SELISIH'];
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td> 
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tregistrasi']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['TAMPIL']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['SELISIH']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        if($selisih==0){
            $result = 0;
        }else{
            $tot = $selisih/22;
            $result = number_format($tot,2);
        } 
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori A </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                    </tr> 

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Hari)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr> 
                </table><br/><br/>";
 

        echo $result."~".$point."~".$warna."~".$html;
    }
    function BD2_10x($post){

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


            $sql_par = 'select a.*,a.dinput_applet,a.tregistrasi , kat.vkategori
                from plc2.plc2_upb a
                join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR"
                join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
                join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
                join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategori_id
                #Filter Deleted
                where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0
                #upb team nya
                and a.iteambusdev_id="22"
                #Tanggal Applet Not NULl
                and a.dinput_applet is not null
                #Tanggal Registrasi Not Null
                and a.tregistrasi is not null
                #Kategori UPB A
                and a.ikategoriupb_id=10
                #Tanggal app dir not null
                and a.iappdireksi = 2 and app.tupdate is not null
                #periode tanggal prareg
                and a.dinput_applet >= "'.$perode1.'"
                and a.dinput_applet <= "'.$perode2.'"
                group by a.iupb_id
                ';


            $qupb = $this->db_erp_pk->query($sql_par);
            if($qupb->num_rows() > 0) {
                $sumsel=array();
                foreach ($qupb->result_array() as $r => $vrupb) {
                    $tgl1=date_create($vrupb['dinput_applet']);
                    $tgl2=date_create($vrupb['tregistrasi']);
                    $sumsel[]=$this->selisihbulan($tgl1,$tgl2);
                }
                $hasil1=intval(array_sum($sumsel))/$qupb->num_rows();

                $totb = number_format( $hasil1, 2, '.', '' );

            }else{
                $totb   =0;
            }

            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";


            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Kategori UPB</th>
                            <th>Tanggal Applet (A)</th>
                            <th>Tanggal Registrasi (B)</th>
                            <th>Selesih antara A dan B - Bulan</th>
                        </tr>
            ";

            $upbDetail = $this->db_erp_pk->query($sql_par)->result_array();
            $i=0;
            $tsel=0;
            foreach ($upbDetail as $ub) {
                 $i++;
                 $months=$this->selisihbulan(date_create($ub['dinput_applet']),date_create($ub['tregistrasi']));
                 $selisih = (int) floor($months);
                 $tsel=$tsel+$selisih;

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vkategori']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['dinput_applet']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['tregistrasi']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$selisih."</td>
                          </tr>";
            }

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$tsel." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Pemerataan file pra registrasi per divisi (Jumlah Selisih / Jumlah UPB)</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan</td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }
    function BD2_11x($post){

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


            $sql_par = 'select a.*,a.dinput_applet,
                #Filter Dokumen Applet Dsubmit Not NUll and Last Update
                (select dap.dsubmit_dok from plc2.applet_dokumen dap where dap.lDeleted=0 and dap.dsubmit_dok is not null and dap.iupb_id=a.iupb_id order by dap.dsubmit_dok DESC limit 1) as dsubmit_dok,kat.vkategori
                from plc2.plc2_upb a
                join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR"
                join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
                join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
                join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=a.ikategori_id
                join plc2.applet_dokumen d on d.iupb_id=a.iupb_id
                #Filter Deleted
                where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0 #and d.lDeleted=0
                #upb team nya
                and a.iteambusdev_id="22"
                #Tanggal HPR Not NULl
                and a.dinput_applet is not null
                #Kategori UPB B
                and a.ikategoriupb_id=11
                #Tanggal app dir not null
                and a.iappdireksi = 2 and app.tupdate is not null
                #periode tanggal prareg
                and a.dinput_applet >= "'.$perode1.'"
                and a.dinput_applet <= "'.$perode2.'"
                group by a.iupb_id ';


            $qupb = $this->db_erp_pk->query($sql_par);
            if($qupb->num_rows() > 0) {
                $sumsel=array();
                foreach ($qupb->result_array() as $r => $vrupb) {
                    $tgl1=date_create($vrupb['dsubmit_dok']);
                    $tgl2=date_create($vrupb['dinput_applet']);
                    $sumsel[]=$this->selisihbulan($tgl1,$tgl2);
                }
                $hasil1=intval(array_sum($sumsel))/$qupb->num_rows();

                $totb = number_format( $hasil1, 2, '.', '' );

            }else{
                $totb   =0;
            }

            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";


            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Kategori UPB</th>
                            <th>Tanggal Dokumen Tambahan Applet (A)</th>
                            <th>Tanggal Input Applet (B)</th>
                            <th>Selisih antara A dan B - Bulan</th>
                        </tr>
            ";

            $upbDetail = $this->db_erp_pk->query($sql_par)->result_array();
            $i=0;
            $tsel=0;
            foreach ($upbDetail as $ub) {
                 $i++;
                 $months=$this->selisihbulan(date_create($ub['dsubmit_dok']),date_create($ub['dinput_applet']));
                 $selisih = (int) floor($months);
                 $tsel=$tsel+$selisih;

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vkategori']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['dsubmit_dok']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['dinput_applet']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$selisih."</td>
                          </tr>";
            }

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$tsel." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata-rata Jangka waktu diperolehnya nomor Applet (dihitung dari tanggal masuk jawaban tambahan data terakhir ke BPOM), untuk produk kategori B (termasuk OGB) :</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan</td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }
    
    function BD2_13($post){

            $iAspekId = $post['_iAspekId'];
            $cNipNya  = $post['_cNipNya'];
            $dPeriode1  = $post['_dPeriode1'];
            $x_prd1 = explode("-", $dPeriode1);
            $perode1 = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];

            $dPeriode2  = $post['_dPeriode2'];
            $x_prd2 = explode("-", $dPeriode2);
            $perode2 = $x_prd2['2']."-".$x_prd2['1']."-".$x_prd2['0'];



            //cari aspek dulu
            $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='".$iAspekId."'";
            $query = $this->db_erp_pk->query($sql);
            $vAspekName = $query->row()->vAspekName;

            $sql_par5 ='
                    SELECT  i.tReceived ,e.vName,t.vtarget_kunjungan,cc.vpejabat
                    FROM kartu_call.`call_card` cc 
                    join hrd.employee e on e.cNip=cc.vNIP
                    join gps_msg.inbox i on i.ID=cc.igpsm_id
                    join kartu_call.master_target_kunjungan t on t.itarget_kunjungan_id=cc.itarget_kunjungan_id
                    WHERE cc.`lDeleted` = 0 
                    AND t.`isHead` = 1  
                    AND cc.`vNIP` LIKE "%'.$cNipNya.'%"
                    AND date(i.`tReceived`) >= "'.$perode1.'"
                    AND date(i.`tReceived`) <= "'.$perode2.'"
                        ';

            $qupb = $this->db_erp_pk->query($sql_par5);
            if($qupb->num_rows() > 0) {
                $tot = $qupb->num_rows();
                $totb = number_format( $tot, 2, '.', '' );
            }else{
                $totb       = 0;
            }




            $html = "
                    <table cellspacing='0' cellpadding='3' width='850px'>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>
                        </tr>
                    </table><br><hr>";


            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>Tanggal Kunjungan</th>
                            <th>Nama</th>
                            <th>Target Kunjungan</th>
                            <th>Nama Pejabat</th>
                        </tr>
            ";

            $bacthDetail = $this->db_erp_pk->query($sql_par5)->result_array();
            $i=0;

    


            
            foreach ($bacthDetail as $ub) {
                 $i++;
                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                             <td style='border: 1px solid #dddddd;'>".$i."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['tReceived']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['vName']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['vtarget_kunjungan']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['vpejabat']."</td>
                             
                          </tr>";
            }

            $html .= "</table><br /> ";

            $timeEnd = strtotime($perode2);
            $timeStart = strtotime($perode1);
            $bulan = 1+(date("Y",$timeEnd)-date("Y",$timeStart))*12;
            $bulan +=  (date("m",$timeEnd)-date("m",$timeStart));      


            $result     = number_format(($i/$bulan), 2, '.', '' );

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Kunjungan (A)</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Bulan (B)</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$bulan." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Result (A/B) </td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result."</td>
                        </tr>
                    </table><br/><br/>";

            

            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];


            echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_13x($post){

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

            $sql_par ='
                    SELECT  i.tReceived ,e.vName,t.vtarget_kunjungan,cc.vpejabat
                    FROM kartu_call.`call_card` cc 
                    join hrd.employee e on e.cNip=cc.vNIP
                    join gps_msg.inbox i on i.ID=cc.igpsm_id
                    join kartu_call.master_target_kunjungan t on t.itarget_kunjungan_id=cc.itarget_kunjungan_id
                    WHERE cc.`lDeleted` = 0 
                    AND t.`isHead` = 1  
                    AND cc.`vNIP` LIKE "%'.$cNipNya.'%"
                    AND date(i.`tReceived`) >= "'.$perode1.'"
                    AND date(i.`tReceived`) <= "'.$perode2.'"

                    

            
                        ';

            /*$sql_par = 'SELECT cc.*,i.tReceived
                    FROM kartu_call.call_card cc
                    JOIN gps_msg.inbox i on i.ID=cc.igpsm_id
                    WHERE cc.lDeleted = 0
                    AND cc.itarget_kunjungan_id = 5
                    AND cc.vNIP LIKE "%'.$cNipNya.'%"
                    AND i.tReceived >= "'.$perode1.'"
                    AND i.tReceived <= "'.$perode2.'"
                ';*/
            $qupb = $this->db_erp_pk->query($sql_par);
            if($qupb->num_rows() > 0) {
                $hasil1 = $qupb->num_rows()/$bulan;
                $totb   = number_format( $hasil1, 2, '.', '' );
            }else{
                $totb   =0;
            }

            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";

            $sqlDetail='SELECT cc.*,i.tReceived,ma.vtarget_kunjungan
                    FROM kartu_call.call_card cc
                    JOIN gps_msg.inbox i on i.ID=cc.igpsm_id
                    JOIN kartu_call.master_target_kunjungan ma on ma.itarget_kunjungan_id=cc.itarget_kunjungan_id
                    WHERE cc.`lDeleted` = 0 
                    AND ma.`isHead` = 1  
                    AND cc.`vNIP` LIKE "%'.$cNipNya.'%"
                    AND date(i.`tReceived`) >= "'.$perode1.'"
                    AND date(i.`tReceived`) <= "'.$perode2.'"

                    #AND cc.`dCreate` >= "'.$perode1.'"
                    #AND cc.`dCreate` <= "'.$perode2.'"
                    ';

            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>Tanggal Kunjungan</th>
                            <th>Target Kunjungan</th>
                            <th>Nama Pejabat</th>
                        </tr>
            ";

            $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
            $i=0;
            foreach ($upbDetail as $ub) {
                 $i++;

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tReceived']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vtarget_kunjungan']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vpejabat']."</td>
                          </tr>";
            }

            $html .= "</table><br /> ";

             $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Kunjungan (A)</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Bua</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$bulan." Bulan </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata-rata kunjungan per bulan bertemu dengan KASIE dan KASUBDIT BPOM (bukan evaluator) :</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result."</td>
                        </tr>
                    </table><br/><br/>";

            echo $result."~".$point."~".$warna."~".$html;
    }
    function BD2_14($post){

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

            $sqlCountMar = 'SELECT COUNT(DISTINCT(p.`iteammarketing_id`) ) AS totMark FROM plc2.`plc2_upb` p
                        JOIN plc2.plc2_upb_team te ON p.`iteammarketing_id`=te.iteam_id
                        WHERE p.`ldeleted` = 0 AND p.`iKill` = 0 AND p.`tsubmit_prareg` IS NOT NULL AND p.`iteambusdev_id` = 5
                        AND  p.tsubmit_prareg >= "'.$perode1.'" AND p.tsubmit_prareg <= "'.$perode2.'"
                        ';
            $sqlDataAll = 'SELECT COUNT(p.`vupb_nama`) AS totCount FROM plc2.`plc2_upb` p
                        JOIN plc2.plc2_upb_team te ON p.`iteammarketing_id`=te.iteam_id
                        WHERE p.`ldeleted` = 0 AND p.`iKill` = 0 AND p.`tsubmit_prareg` IS NOT NULL AND p.`iteambusdev_id` = 5
                        AND  p.tsubmit_prareg >= "'.$perode1.'" AND p.tsubmit_prareg <= "'.$perode2.'"
                        ';


            $dtMarket   = $this->db_erp_pk->query($sqlCountMar)->row_array();
            $dtAll      = $this->db_erp_pk->query($sqlDataAll)->row_array();

            $t_market = 0;
            if(empty($dtMarket['totMark']) or $dtMarket['totMark']==0){
                 $totb = 0;
            }else{
                $t_market = $dtMarket['totMark'];
                $totb = $dtAll['totCount'] / $dtMarket['totMark'];
            }

            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";

            $sqlDetail = 'SELECT p.`vupb_nama`,p.`vupb_nomor`, te.`vteam`, p.`iteammarketing_id`, p.`tsubmit_prareg` FROM plc2.`plc2_upb` p
                    JOIN plc2.plc2_upb_team te ON p.`iteammarketing_id`=te.iteam_id
                    WHERE p.`ldeleted` = 0 AND p.`iKill` = 0 AND p.`tsubmit_prareg` IS NOT NULL AND p.`iteambusdev_id` = 5
                    AND  p.tsubmit_prareg >= "'.$perode1.'" AND p.tsubmit_prareg <= "'.$perode2.'"
                    ';

            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Team Marketing</th>
                            <th>Tanggal Submit Prareg</th>
                        </tr>
            ";

            $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
            $i=0;
            $tsel=0;
            foreach ($upbDetail as $ub) {
                 $i++;

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vteam']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['tsubmit_prareg']))."</td>
                          </tr>";
            }

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Team Marketing Selisih</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$t_market." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata Produk Perdivisi</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Produk</td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }



    //BD - 2 END-----------------------------------------------------------------------------------------------

    //BD - 3 START---------------------------------------------------------------------------------------------
    function BD3_1($post){

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

            $sql_par = 'select
                #group distinct karena hanya mengambil jumlah group produk
                distinct(a.iGroup_produk) jum
                #app.tupdate,a.*,d.vNama_Group
                from plc2.plc2_upb a
                join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR"
                join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
                join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk
                #Filter Deleted
                where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0
                #upb team nya
                and a.iteambusdev_id="5"
                #Kategori Produk Non Alkes dan Not NUll
                and a.ikategori_id!=15 and a.ikategori_id is not null
                #Informasi Hak Patent Not NUll
                and a.tinfo_paten is not NULL
                #approval direksi
                and a.iappdireksi = 2 and app.tupdate is not null
                #periode tanggal prareg
                and app.tupdate >= "'.$perode1.'"
                and app.tupdate <= "'.$perode2.'"
                group by a.iupb_id
                ';
            $qupb = $this->db_erp_pk->query($sql_par);
            if($qupb->num_rows() > 0) {
                $d=$qupb->result_array();
                foreach ($d as $k => $v) {
                    $s[$v['jum']]=$v['jum'];
                }
                $totb=count($s);

            }else{
                $totb = number_format(0);
            }
            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";

            $sqlDetail = 'select
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
                and a.iteambusdev_id="5"
                #Kategori Produk Non Alkes dan Not NUll
                and a.ikategori_id!=15 and a.ikategori_id is not null
                #Informasi Hak Patent Not NUll
                and a.tinfo_paten is not NULL
                #approval direksi
                and a.iappdireksi = 2 and app.tupdate is not null
                #periode tanggal prareg
                and app.tupdate >= "'.$perode1.'"
                and app.tupdate <= "'.$perode2.'"
                group by a.iupb_id
                ';
            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Info Hak Paten</th>
                            <th>Kategori Produk</th>
                            <th>Tanggal Approve Direksi</th>
                            <th>Kategori Group Produk</th>
                        </tr>
            ";

            $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
            $i=0;
            $tsel=array();
            foreach ($upbDetail as $ub) {
                 $i++;
                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tinfo_paten']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vkategori']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['tupdate']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vNama_Group']."</td>
                          </tr>";

                          $tsel[$ub['iGroup_produk']]=$ub['iGroup_produk'];

            }

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Pengajuan Usulan Group Produk Baru (tidak termasuk ALKES) *</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".count($tsel)." </td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }
    function BD3_2($post){

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

            $sdisct ='select
                #group distinct karena hanya mengambil jumlah group produk
                distinct(te.iteam_id) jum';
            $sdat='select app.tupdate,a.*,te.vteam,d.vNama_Group,a.iteammarketing_id';
            $sql_par = ' from plc2.plc2_upb a
                    join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR"
                    join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
                    join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk
                    join plc2.plc2_upb_team te on a.iteammarketing_id=te.iteam_id
                    #Filter Deleted
                    where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0
                    #upb team nya
                    and a.iteambusdev_id="5"
                    #approval direksi
                    and a.iappdireksi = 2 and app.tupdate is not null
                    #periode tanggal prareg
                    and app.tupdate >= "'.$perode1.'"
                    and app.tupdate <= "'.$perode2.'"
                    group by a.iupb_id
                    ';
            $qupbdat = $this->db_erp_pk->query($sdat.$sql_par);
            if($qupbdat->num_rows() > 0) {
                $d=$this->db_erp_pk->query($sdisct.$sql_par)->num_rows();
                $hasil=$qupbdat->num_rows()/$d;
                $totb = number_format( $hasil, 3, '.', '' );
            }else{
                $totb = number_format(0);

            }

            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";

            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>

                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Group Produk</th>
                            <th>Team Marketing</th>
                            <th>Info Paten</th>
                            <th>Approval Direksi</th>
                        </tr>
            ";

            $upbDetail = $this->db_erp_pk->query($sdat.$sql_par)->result_array();
            $i=0;
            $iteam=array();
            foreach ($upbDetail as $ub) {
                 $i++;
                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vNama_Group']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vteam']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tinfo_paten']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['tupdate']))."</td>
                          </tr>";
                          $iteam[$ub['iteammarketing_id']]=$ub['iteammarketing_id'];

            }

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Group Marketing</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".count($iteam)." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata (Jumlah UPB / Jumlah Group Marketing) </td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }
    function BD3_3($post){

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

            $sql_par = 'select
                a.*,s.dTanggalTerimaBD,t.dApp_dir, s.iJenis_panel
                from plc2.plc2_upb a
                join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR"
                join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
                join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk
                join plc2.otc_sample_panel s on s.iupb_id = a.iupb_id
                join plc2.otc_panel_test t on t.isample_panel_id=s.isample_panel_id
                #Filter Deleted
                where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0 and s.lDeleted=0 and t.lDeleted=0
                #upb team nya
                and a.iteambusdev_id="5"
                #Tanggal app dir not null
                and a.iappdireksi = 2 and app.tupdate is not null
                #tanggal approve req panel not null
                and t.dApp_dir is not null
                #tanggal terima sample
                and s.dTanggalTerimaBD is not null
                #periode tanggal prareg
                and t.dApp_dir >= "'.$perode1.'"
                and t.dApp_dir <= "'.$perode2.'"
                group by s.isample_panel_id
                ';
                $qupb = $this->db_erp_pk->query($sql_par);
                if($qupb->num_rows() > 0) {
                    $sumsel=array();
                    foreach ($qupb->result_array() as $r => $vrupb) {
                        $tgl1=date_create($vrupb['dApp_dir']);
                        $tgl2=date_create($vrupb['dTanggalTerimaBD']);
                        $sumsel[]=$this->selisihbulan($tgl1,$tgl2);
                    }
                    $hasil1=intval(array_sum($sumsel))/$qupb->num_rows();

                    $totb = number_format( $hasil1, 2, '.', '' );

                }else{
                    //Jika Tidak ada UPB Sama Sekali
                    $totb = number_format(0);

                }

            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";

            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Jenis Panel</th>
                            <th>Tanggal Approval Panel (A)</th>
                            <th>Tanggal Terima Sample Panel (B)</th>
                            <th>Selesih antara A dan B - Bulan</th>
                        </tr>
            ";

            $upbDetail = $this->db_erp_pk->query($sql_par)->result_array();
            $i=0;
            $tot=0;
            $iteam=array();
            $a= array('1' => 'Panel Kecil','2'=>'Panel Besar','3'=>'Panel Eksternal');
            foreach ($upbDetail as $ub) {
                $i++;

                $selisih=0;

                $date1=date_create($ub['dApp_dir']);
                $date2=date_create($ub['dTanggalTerimaBD']);

                /*$diff =  $date1->diff($date2);*/
                $months=$this->selisihbulan($date1,$date2);
                $selisih = (int) floor($months);
                $tot+=$selisih;

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$a[$ub['iJenis_panel']]."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['dApp_dir']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['dTanggalTerimaBD']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$selisih."</td>
                          </tr>";

            }

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$tot." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Panel (Target 1 bulan)</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan</td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }
    function BD3_5($post){

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

            $sql_par = 'select
                #group distinct karena hanya mengambil jumlah group produk
                count(distinct(a.iGroup_produk)) jum
                #a.tsubmit_prareg,a.*
                from plc2.plc2_upb a
                join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR"
                join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
                join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk
                #Filter Deleted
                where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0
                #upb team nya
                and a.iteambusdev_id="5"
                #Tanggal Prared Not NULl
                and a.tsubmit_prareg is not null
                #Tanggal app dir not null
                and a.iappdireksi = 2 and app.tupdate is not null
                #periode tanggal prareg
                and a.tsubmit_prareg >= "'.$perode1.'"
                and a.tsubmit_prareg <= "'.$perode2.'"
                ';
            $qupb = $this->db_erp_pk->query($sql_par);
            if($qupb->num_rows() > 0) {
                $d=$qupb->row_array();
                $hasil=$d['jum'];
                $totb = number_format( $hasil, 2, '.', '' );

            }else{
                $totb = number_format(0);
            }

            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";

            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Kode Obat</th>
                            <th>Tanggal Prareg</th>
                            <th>Kategori Group Produk</th>
                        </tr>
            ";

            $sql_detail = 'select
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
                    and a.iteambusdev_id="5"
                    #Tanggal Prared Not NULl
                    and a.tsubmit_prareg is not null
                    #Tanggal app dir not null
                    and a.iappdireksi = 2 and app.tupdate is not null
                    #periode tanggal prareg
                    and a.tsubmit_prareg >= "'.$perode1.'"
                    and a.tsubmit_prareg <= "'.$perode2.'"
                ';


            $upbDetail = $this->db_erp_pk->query($sql_detail)->result_array();
            $i=0;
            $tot=0;
            $iteam=array();
            foreach ($upbDetail as $ub) {
                $i++;
                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vKode_obat']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['tsubmit_prareg']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vNama_Group']."</td>
                          </tr>";

            }

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Submit file pra registrasi ke BPOM untuk produk baru </td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Group</td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }
    function BD3_6($post){

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

            $sql_par = 'select a.*,a.tsubmit_prareg,a.ttanggal
                from plc2.plc2_upb a join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR"
                join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
                join plc2.plc2_upb_prioritas c on c.iprioritas_id=b.iprioritas_id
                #Filter Deleted
                where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and c.ldeleted=0
                #upb team nya
                and a.iteambusdev_id="5"
                #Tanggal Prareg not null
                and a.tsubmit_prareg is not null
                #Tanggal Submit UPB not NUll
                and a.ttanggal is not null
                #Tanggal app dir not null
                and a.iappdireksi = 2 and app.tupdate is not null
                #periode tanggal prareg
                and a.tsubmit_prareg >= "'.$perode1.'"
                and a.tsubmit_prareg <= "'.$perode2.'"
                group by a.iupb_id
                ';
            //return array('score'=>$sql_par,'hasil'=>0,'detail'=>$calcDetail->output());exit();
            $qupb = $this->db_erp_pk->query($sql_par);
            if($qupb->num_rows() > 0) {
                $sumsel=array();
                foreach ($qupb->result_array() as $r => $vrupb) {
                    $tgl1=date_create($vrupb['tsubmit_prareg']);
                    $tgl2=date_create($vrupb['ttanggal']);
                    $sumsel[]=$this->selisihbulan($tgl1,$tgl2);
                }
                $hasil1=intval(array_sum($sumsel))/$qupb->num_rows();
                $totb = number_format( $hasil1, 2, '.', '' );

            }else{
                //Jika Tidak ada UPB Sama Sekali
                $totb = number_format(0);
            }




            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";

            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Tanggal Submit Prareg (A)</th>
                            <th>Tanggal Submit UPB (B)</th>
                            <th>Selesih antara A dan B - Bulan</th>
                        </tr>
            ";


            $upbDetail = $this->db_erp_pk->query($sql_par)->result_array();
            $i=0;
            $tot=0;
            $iteam=array();
            foreach ($upbDetail as $ub) {
                $i++;
                $selisih=0;

                $date1=date_create($ub['tsubmit_prareg']);
                $date2=date_create($ub['ttanggal']);

                $months=$this->selisihbulan($date1,$date2);
                $selisih = (int) floor($months);
                $tot += $selisih;
                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['tsubmit_prareg']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['ttanggal']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$selisih."</td>
                          </tr>";

            }

            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$tot." </td>
                        </tr>


                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata-rata Jangka waktu antara UPB dan submit pre-registrasi (dihitung sejak UPB hingga tanggal diterimanya file oleh BPOM) </td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan</td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }
    function BD3_7($post){

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

            $selall= 'select z.iupb_id, z.vupb_nomor, z.vupb_nama, z.vKode_obat, z.iGroup_produk, z.dinput_applet, z.ttarget_noreg';
            $seldisct= 'select distinct(z.iGroup_produk) as jum';
            $sql_par =' from (
                        #untuk Produk Kategori Obat
                        select
                        a.iupb_id,a.vupb_nomor,a.vupb_nama,a.vKode_obat, a.iGroup_produk, a.dinput_applet, a.ttarget_noreg
                        from plc2.plc2_upb a
                        join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR"
                        join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
                        join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk
                        #Filter Deleted
                        where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0
                        #upb team nya
                        and a.iteambusdev_id="5"
                        #Tanggal Applet Not NULl
                        #and a.dinput_applet is not null
                        #Kategori Obat
                        AND a.ikategori_id in (1,2,5,10,11,12)
                        #Tanggal app dir not null
                        and a.iappdireksi = 2 and app.tupdate is not null
                        #periode tanggal prareg
                        and a.dinput_applet >= "'.$perode1.'"
                        and a.dinput_applet <= "'.$perode2.'"
                        group by a.iupb_id
                        UNION
                        select
                        #untuk Produk Kategori Non Obat
                        a.iupb_id,a.vupb_nomor,a.vupb_nama,a.vKode_obat, a.iGroup_produk, a.dinput_applet, a.ttarget_noreg
                        from plc2.plc2_upb a
                        join plc2.plc2_upb_approve app on app.iupb_id=a.iupb_id and app.vtipe="DR"
                        join plc2.plc2_upb_prioritas_detail b on b.iupb_id=a.iupb_id
                        join plc2.master_group_produk d on d.imaster_group_produk=a.iGroup_produk
                        #Filter Deleted
                        where a.ldeleted=0 and app.ldeleted=0 and b.ldeleted=0 and d.lDeleted=0
                        #upb team nya
                        and a.iteambusdev_id="5"
                        #Tanggal NIE Not NULl
                        and a.ttarget_noreg is not null
                        #Kategori Obat
                        AND a.ikategori_id in (3,4,6,7,8,9,13)
                        #Tanggal app dir not null
                        and a.iappdireksi = 2 and app.tupdate is not null
                        #periode tanggal prareg
                        and a.ttarget_noreg >= "'.$perode1.'"
                        and a.ttarget_noreg <= "'.$perode2.'"
                        group by a.iupb_id
                        ) AS z
                        group by z.iupb_id
                        ORDER BY z.vupb_nomor ASC
                    ';

            $qupb = $this->db_erp_pk->query($selall.$sql_par);
            if($qupb->num_rows() > 0) {
                $qgroup=$this->db_erp_pk->query($seldisct.$sql_par)->row_array();
                $hasil=$qupb->num_rows()/$qgroup['jum'];
                $totb = number_format( $hasil, 2, '.', '' );

            }else{
                $totb = number_format(0);
                $hasil = number_format( $hasil, 2, '.', '' );
            }

            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";

            $html .= "";

            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr>
                            <th colspan='6'>Kategori Obat</th>
                        </tr>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Kategori UPB</th>
                            <th>Tanggal Applet</th>
                            <th>Kategori Produk</th>
                        </tr>
            ";


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
                    and a.iteambusdev_id="5"
                    #Tanggal Applet Not NULl
                    #and a.dinput_applet is not null
                    #Kategori Obat
                    AND a.ikategori_id in (1,2,5,10,11,12)
                    #Tanggal app dir not null
                    and a.iappdireksi = 2 and app.tupdate is not null
                    #periode tanggal prareg
                    and a.dinput_applet >= "'.$perode1.'"
                    and a.dinput_applet <= "'.$perode2.'"
                    group by a.iupb_id
                ';

            $upbDetail = $this->db_erp_pk->query($sql_par_obat)->result_array();
            $i=0;
            $tot=0;
            $iteam=array();
            foreach ($upbDetail as $ub) {
             $i++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date('Y-m-d',strtotime($ub['dinput_applet']))."</td>
                         <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vNama_Group']."</td>
                      </tr>";
            }

            $html .= "<tr>
                            <th colspan='6'>Kategori NON Obat</th>
                        </tr>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Kategori UPB</th>
                            <th>Tanggal NIE</th>
                            <th>Kategori Produk</th>
                        </tr>";

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
                    and a.iteambusdev_id="5"
                    #Tanggal NIE Not NULl
                    and a.ttarget_noreg is not null
                    #Kategori Obat
                    AND a.ikategori_id in (3,4,6,7,8,9,13)
                    #Tanggal app dir not null
                    and a.iappdireksi = 2 and app.tupdate is not null
                    #periode tanggal prareg
                    and a.ttarget_noreg >= "'.$perode1.'"
                    and a.ttarget_noreg <= "'.$perode2.'"
                    group by a.iupb_id
                ';
            $upbDetail = $this->db_erp_pk->query($sql_par_non)->result_array();
            //$i=0;
            $tot=0;
            $iteam=array();
            foreach ($upbDetail as $ub) {
             $i++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date('Y-m-d',strtotime($ub['ttarget_noreg']))."</td>
                         <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vNama_Group']."</td>
                      </tr>";
            }


            $html .= "</table><br /> ";

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
                    and a.iteambusdev_id="5"
                    #Tanggal Applet Not NULl
                    #and a.dinput_applet is not null
                    #Kategori Obat
                    AND a.ikategori_id in (1,2,5,10,11,12)
                    #Tanggal app dir not null
                    and a.iappdireksi = 2 and app.tupdate is not null
                    #periode tanggal prareg
                    and a.dinput_applet >= "'.$perode1.'"
                    and a.dinput_applet <= "'.$perode2.'"
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
                    and a.iteambusdev_id="5"
                    #Tanggal NIE Not NULl
                    and a.ttarget_noreg is not null
                    #Kategori Obat
                    AND a.ikategori_id in (3,4,6,7,8,9,13)
                    #Tanggal app dir not null
                    and a.iappdireksi = 2 and app.tupdate is not null
                    #periode tanggal prareg
                    and a.ttarget_noreg >= "'.$perode1.'"
                    and a.ttarget_noreg <= "'.$perode2.'"
                    group by a.iupb_id
                    ) AS z
                    group by z.iupb_id
                    ORDER BY z.vupb_nomor ASC
                ';
            $Jum = $this->db_erp_pk->query($sql_par_disc)->row_array();
            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Memenuhi Syarat (A)</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Kategori Produk (B)</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$Jum['jum']." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Realisasi NIE / APPLET produk baru Food suplement, OTC & kosmetik * (tidak termasuk ALKES)  (A/B):</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result."</td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }
    function BD3_9($post){

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

            $sqlp1 = '   SELECT u.`dinput_applet`, u.`tregistrasi` ,mk.vkategori,  u.`iupb_id` , u.`dinput_applet` ,  u.ikategoriupb_id, u.`vupb_nomor`,u.vupb_nama ,  u.vKode_obat FROM plc2.`plc2_upb` u
                    join hrd.mnf_kategori mk on mk.ikategori_id = u.ikategori_id
                    WHERE u.`ldeleted` = 0
                    AND u.`iteambusdev_id` = 5
                    AND u.dinput_applet IS NOT NULL
                    AND u.`ikategori_id` IN (1,2,5,10, 11, 12)
                    AND u.`tregistrasi` IS NOT NULL
                    AND u.`dinput_applet` >= "'.$perode1.'"
                    AND u.`dinput_applet` <= "'.$perode2.'"
                    ';

            $sqlp2 = '  SELECT u.`ttarget_noreg`, u.`tregistrasi`,mk.vkategori,  u.`iupb_id` , u.`dinput_applet` ,  u.ikategoriupb_id, u.`vupb_nomor`,u.vupb_nama ,  u.vKode_obat FROM plc2.`plc2_upb` u
                    join hrd.mnf_kategori mk on mk.ikategori_id = u.ikategori_id
                    WHERE u.`ldeleted` = 0
                    AND u.`iteambusdev_id` = 5
                    AND u.`ttarget_noreg` IS NOT NULL
                    AND u.`ikategori_id` IN (7)
                    AND u.`tregistrasi` IS NOT NULL
                    AND u.`ttarget_noreg` >= "'.$perode1.'"
                    AND u.`ttarget_noreg` <= "'.$perode2.'"
                    ';

            $t_be = $this->db_erp_pk->query($sqlp1)->result_array();
            $t_nbe = $this->db_erp_pk->query($sqlp2)->result_array();

            //Menghitung BE
            $selisih_be = 0;
            $upb_be = 0 ;
            foreach ($t_be as $be) {
                $timeEnd = strtotime($be['dinput_applet']);
                $timeStart = strtotime($be['tregistrasi']);

                $time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
                    $time +=  (date("m",$timeEnd)-date("m",$timeStart));
                if($time <=0){
                    $durasi = -1*($time);
                }else{
                    $durasi = $time;
                }
                $selisih_be += $durasi;
                $upb_be ++;
            }


            //Menghitung NON BE
            $selisih_nbe = 0;
            $upb_nbe = 0 ;
            foreach ($t_nbe as $nbe) {
                $durasi = 0;
                $timeEnd = strtotime($nbe['ttarget_noreg']);
                $timeStart = strtotime($nbe['tregistrasi']);

                $time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
                    $time +=  (date("m",$timeEnd)-date("m",$timeStart));
                if($time <=0){
                    $durasi = -1*($time);
                }else{
                    $durasi = $time;
                }
                $selisih_nbe += $durasi;
                $upb_nbe ++;
            }

            //Mentotalkan Data
            $sum_selisih = $selisih_nbe + $selisih_be;
            $sum_upb = $upb_nbe + $upb_be;
            if($sum_upb>0){
                $hasil = $sum_selisih/$sum_upb;  // (A)/(B)
                $totb = number_format( $hasil, 2, '.', '' );
            }else{
                $totb = number_format(0);
            }

            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table width='800px'>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";


            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr>
                            <th colspan='7'>Kategori Obat</th>
                        </tr>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Kategori</th>
                            <th>Tanggal Applet</th>
                            <th>Tanggal Registrasi</th>
                            <th>Selisih (Bulan)</th>
                        </tr>
            ";

            $upbDetail = $this->db_erp_pk->query($sqlp1)->result_array();
            $i=0;
            $selisih2 = 0;
            $y = 0;
            foreach ($upbDetail as $ub) {
             $i++;
             $y++;
                $durasi = 0;
                $timeEnd = strtotime($ub['dinput_applet']);
                $timeStart = strtotime($ub['tregistrasi']);
                $time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
                $time +=  (date("m",$timeEnd)-date("m",$timeStart));
                if($time <=0){
                    $durasi = -1*($time);
                }else{
                    $durasi = $time;
                }
                $selisih2 += $durasi;

             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date('Y-m-d',strtotime($ub['dinput_applet']))."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date('Y-m-d',strtotime($ub['tregistrasi']))."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$durasi."</td>
                      </tr>";
            }

            $html .= "<tr>
                            <th colspan='7'>Kategori NON Obat</th>
                        </tr>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Kategori</th>
                            <th>Tanggal NIE</th>
                            <th>Tanggal Registrasi</th>
                            <th>Selisih (Bulan)</th>
                        </tr>";


            $upbDetail = $this->db_erp_pk->query($sqlp2)->result_array();
            //$i=0;
            $tot=0;
            $iteam=array();
            $selisih22=0;
            $i = 0;
            $y = 0;
            foreach ($upbDetail as $ub) {
                $i++;
                $y++;
                $timeEnd = strtotime($ub['ttarget_noreg']);
                $timeStart = strtotime($ub['tregistrasi']);
                $time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
                $time +=  (date("m",$timeEnd)-date("m",$timeStart));
                if($time <=0){
                    $durasi = -1*($time);
                }else{
                    $durasi = $time;
                }
                $selisih22 += $durasi;

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vkategori']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['ttarget_noreg']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['tregistrasi']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$durasi."</td>
                          </tr>";
            }


            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori Obat</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori Non Obat</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$y." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih UPB Kategori Obat</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih2." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih UPB Kategori Non Obat</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih22." </td>
                        </tr>


                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata (Total Selisih (Obat & Non Obat) / Jumlah UBP (Obat & Non Obat)):</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan</td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }
    function BD3_10($post){

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

            $sql_t = '  SELECT u.`ttarget_noreg`, u.`tregistrasi` , u.`iupb_id` , u.`dinput_applet` , u.`tregistrasi`, u.ikategoriupb_id, u.`vupb_nomor`,u.vupb_nama ,  u.vKode_obat FROM plc2.`plc2_upb` u
                    join hrd.mnf_kategori mk on mk.ikategori_id = u.ikategori_id
                    WHERE u.`ldeleted` = 0
                    AND u.`iteambusdev_id` = 5
                    AND u.`ttarget_noreg` IS NOT NULL
                    AND u.`ikategori_id` IN (3,4,6,8,9,10,13)
                    AND u.`tregistrasi` IS NOT NULL
                    AND u.dinput_applet IS NOT NULL
                    AND u.`ttarget_noreg` >= "'.$perode1.'"
                    AND u.`ttarget_noreg` <= "'.$perode2.'"
                    ';

            $loop = $this->db_erp_pk->query($sql_t)->result_array();

            $selisih = 0;
            $upb = 0;
            foreach ($loop as $v) {
                $timeEnd = strtotime($v['ttarget_noreg']);
                $timeStart = strtotime($v['tregistrasi']);

                $time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
                $time +=  (date("m",$timeEnd)-date("m",$timeStart));

                if($time <=0){
                    $durasi = -1*($time);
                }else{
                    $durasi = $time;
                }
                $selisih += $durasi;
                $upb ++;
            }

            if($upb>0){
                $hasil = $selisih/$upb;  // (A)/(B)
                $totb = number_format( $hasil, 2, '.', '' );
            }else{
                $totb = 0;
            }

            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";

            $html .= "";

            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Kategori</th>
                            <th>Tanggal NIE</th>
                            <th>Tanggal Registrasi</th>
                            <th>Selisih (Bulan)</th>
                        </tr>
            ";



            $upbDetail = $this->db_erp_pk->query($sql_t)->result_array();
            $i=0;
            $selisih=0;
            $iteam=array();
            foreach ($upbDetail as $ub) {
             $i++;
                $timeEnd = strtotime($ub['ttarget_noreg']);
                $timeStart = strtotime($ub['tregistrasi']);

                $time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
                $time +=  (date("m",$timeEnd)-date("m",$timeStart));

                if($time <=0){
                    $durasi = -1*($time);
                }else{
                    $durasi = $time;
                }
                $selisih += $durasi;

                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vkategori']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['ttarget_noreg']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($ub['tregistrasi']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$durasi."</td>
                          </tr>";
            }


            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Memenuhi Syarat (A)</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata (Total Selisih / Jumlah UBP) :</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan</td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }
    function BD3_12($post){

            $iAspekId = $post['_iAspekId'];
            $cNipNya  = $post['_cNipNya'];
            $dPeriode1  = $post['_dPeriode1'];
            $x_prd1 = explode("-", $dPeriode1);
            $perode1 = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];

            $dPeriode2  = $post['_dPeriode2'];
            $x_prd2 = explode("-", $dPeriode2);
            $perode2 = $x_prd2['2']."-".$x_prd2['1']."-".$x_prd2['0'];



            //cari aspek dulu
            $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='".$iAspekId."'";
            $query = $this->db_erp_pk->query($sql);
            $vAspekName = $query->row()->vAspekName;

            $sql_par5 ='
                    SELECT  i.tReceived ,e.vName,t.vtarget_kunjungan,cc.vpejabat
                    FROM kartu_call.`call_card` cc 
                    join hrd.employee e on e.cNip=cc.vNIP
                    join gps_msg.inbox i on i.ID=cc.igpsm_id
                    join kartu_call.master_target_kunjungan t on t.itarget_kunjungan_id=cc.itarget_kunjungan_id
                    WHERE cc.`lDeleted` = 0 
                    AND t.`isHead` = 1  
                    AND cc.`vNIP` LIKE "%'.$cNipNya.'%"
                    AND date(i.`tReceived`) >= "'.$perode1.'"
                    AND date(i.`tReceived`) <= "'.$perode2.'"
                        ';

            $qupb = $this->db_erp_pk->query($sql_par5);
            if($qupb->num_rows() > 0) {
                $tot = $qupb->num_rows();
                $totb = number_format( $tot, 2, '.', '' );
            }else{
                $totb       = 0;
            }




            $html = "
                    <table cellspacing='0' cellpadding='3' width='850px'>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>
                        </tr>
                    </table><br><hr>";


            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>Tanggal Kunjungan</th>
                            <th>Nama</th>
                            <th>Target Kunjungan</th>
                            <th>Nama Pejabat</th>
                        </tr>
            ";

            $bacthDetail = $this->db_erp_pk->query($sql_par5)->result_array();
            $i=0;

    


            
            foreach ($bacthDetail as $ub) {
                 $i++;
                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                             <td style='border: 1px solid #dddddd;'>".$i."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['tReceived']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['vName']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['vtarget_kunjungan']."</td>
                             <td style='border: 1px solid #dddddd;'>".$ub['vpejabat']."</td>
                             
                          </tr>";
            }

            $html .= "</table><br /> ";

            $timeEnd = strtotime($perode2);
            $timeStart = strtotime($perode1);
            $bulan = 1+(date("Y",$timeEnd)-date("Y",$timeStart))*12;
            $bulan +=  (date("m",$timeEnd)-date("m",$timeStart));      


            $result     = number_format(($i/$bulan), 2, '.', '' );

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Kunjungan (A)</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Bulan (B)</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$bulan." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Result (A/B) </td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result."</td>
                        </tr>
                    </table><br/><br/>";

            

            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];


            echo $result."~".$point."~".$warna."~".$html;
    }

    function BD3_12x($post){

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

            $sql_t ='
                    SELECT  i.tReceived ,e.vName,t.vtarget_kunjungan,cc.vpejabat
                    FROM kartu_call.`call_card` cc 
                    join hrd.employee e on e.cNip=cc.vNIP
                    join gps_msg.inbox i on i.ID=cc.igpsm_id
                    join kartu_call.master_target_kunjungan t on t.itarget_kunjungan_id=cc.itarget_kunjungan_id
                    WHERE cc.`lDeleted` = 0 
                    AND t.`isHead` = 1  
                    AND cc.`vNIP` LIKE "%'.$cNipNya.'%"
                    AND date(i.`tReceived`) >= "'.$perode1.'"
                    AND date(i.`tReceived`) <= "'.$perode2.'"

                    

            
                        ';

           /* $sql_t = 'SELECT COUNT(cc.`icall_id`) AS `icall_id` FROM kartu_call.`call_card` cc
                    WHERE cc.`lDeleted` = 0
                    AND cc.`itarget_kunjungan_id` = 5
                    AND cc.`vNIP` LIKE "%'.$cNipNya.'%"
                    AND cc.`dCreate` >= "'.$perode1.'"
                    AND cc.`dCreate` <= "'.$perode2.'"
                    ';*/
            $tot = $this->db_erp_pk->query($sql_t)->row_array();

            $timeEnd = strtotime($perode2);
            $timeStart = strtotime($perode1);


            $time = 1 + (date("Y",$timeEnd)-date("Y",$timeStart))*12;
            $time +=  (date("m",$timeEnd)-date("m",$timeStart));
            if($time < 1){
                $hasil = number_format(0);
                $totb = number_format( $hasil, 2, '.', '' );
            }else{
                $hasil = $tot['icall_id'] / $time;  // (A)/(B)
                $totb = number_format( $hasil, 2, '.', '' );
            }

            $result     = $totb;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];

            $html = "
                    <table>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td>".$vAspekName."</td>

                        </tr>
                    </table>";

            $html .= "";

            $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>Messages</th>
                            <th>Pejabat</th>
                            <th>Hasil</th>
                            <th>Target Kunjungan</th>
                            <th>Tgl Kunjungan</th>
                        </tr>
            ";


            $sqldetail = 'SELECT cc.`dCreate`, inb.vMessages, cc.vpejabat, cc.thasil, mt.vtarget_kunjungan FROM kartu_call.`call_card` cc
                    JOIN kartu_call.master_target_kunjungan mt on mt.itarget_kunjungan_id = cc.itarget_kunjungan_id
                    JOIN gps_msg.inbox inb on inb.id = cc.igpsm_id
                    WHERE cc.`lDeleted` = 0 
                    AND mt.`isHead` = 1  
                    AND cc.`vNIP` LIKE "%'.$cNipNya.'%"
                    AND date(i.`tReceived`) >= "'.$perode1.'"
                    AND date(i.`tReceived`) <= "'.$perode2.'"

                    #AND cc.`dCreate` >= "'.$perode1.'"
                    #AND cc.`dCreate` <= "'.$perode2.'"
                    ';
            $upbDetail = $this->db_erp_pk->query($sqldetail)->result_array();
            $i=0;
            $selisih=0;
            $iteam=array();
            foreach ($upbDetail as $ub) {
             $i++;

                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vMessages']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vpejabat']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['thasil']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vtarget_kunjungan']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['dCreate']."</td>
                          </tr>";
            }


            $html .= "</table><br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Call</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Tanggal Mulai Perhitungan</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$perode1." </td>
                        </tr>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Tanggal Akhir Perhitungan</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$perode2." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Selisih Tanggal</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$bulan." Bulan</td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata-rata Kunjungan</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan</td>
                        </tr>
                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }

    //N16945 START
    function BD1_3($post){
        // dari parameter 5 sebelumnya

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
                <table cellspacing='0' cellpadding='3' width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                    </tr>
                </table>";
        $sqlDetail='SELECT u.tinfo_paten, u.`iupb_id`, m.vNama_Group ,u.`iGroup_produk` , u.`vupb_nomor`, u.vupb_nama, u.vgenerik, ua.`tupdate`,
            u.vKode_obat, pb.vkategori, u.vgenerik 
            FROM plc2.`plc2_upb` u
            JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
            JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
            JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
            WHERE u.`ldeleted` = 0
            AND u.`iteambusdev_id` = 4
            AND ua.`vtipe` = "DR"
            AND ua.`iapprove` = 2
            and u.itipe_id <> 6
            and u.ldeleted = 0
            and u.iKill = 0
            AND ua.`tupdate` >= "'.$perode1.'"
            AND ua.`tupdate` <= "'.$perode2.'"
            ORDER BY u.`ikategoriupb_id`';


        $html .= "<table cellspacing='0' cellpadding='3' width='900px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Nama Generik</th>
                        <th>Group Produk</th>
                        <th>Kategori</th>
                        <th>Info Paten</th>
                        <th>Approval Direksi</th>
                    </tr>
        ";

        $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
        $i=0;
        $t_all = 0;
        $t_a  = 0;
        foreach ($upbDetail as $ub) {
             $i++;
             $col = "";
             $t_all++;
             if($ub['vkategori']=="A"){
               $t_a++;
               $col = "bgcolor='#C0C0C0'";
             }
             $html .= "<tr ".$col." style='border: 1px solid #dddddd; border-collapse: collapse; '>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:15%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:15%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vgenerik']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vNama_Group']."</td>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tinfo_paten']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tupdate']."</td>
                      </tr>";

        }
        if($t_all==0){
          $tot = 0;
        }else{
          $tot = ($t_a/$t_all) * 100;
        }
        $result     = number_format($tot,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Seluruh UPB</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$t_all." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori A</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$t_a." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Persentase UPB Kategori A</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format($tot,2)." %</td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }
    
    //Modification Project 476226
    /*function BD1_4($post){
        // dari parameter 5 sebelumnya

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


        $sqldtl='SELECT u.`tsubmit_prareg` , (
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
                    AND u.`tsubmit_prareg` IS NOT NULL and  u.`tsubmit_prareg` <> "0000-00-00"
                    AND u.`ldeleted` = 0
                    and u.itipe_id <> 6
                    AND u.`iteambusdev_id` = 4
                    AND u.`tsubmit_prareg` >= "'.$perode1.'"
                    AND u.`tsubmit_prareg` <= "'.$perode2.'"
            ';

        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    			<th>No</th>
                    			<th>No UPB</th>
                    			<th>Nama UPB</th>
                    			<th>Info Paten</th>
                    			<th>Tanggal Seting Prioritas</th>
                    			<th>Tanggal Prareg</th>
                    			<th>Selisih (Bulan)</th>
                    </tr>
        ";

        $upbDetail = $this->db_erp_pk->query($sqldtl)->result_array();
        $i=0;
        $tot_upb = 0;
        $selisih = 0;
        foreach ($upbDetail as $ub) {
             $i++;
             $tot_upb++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tinfo_paten']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tappbusdev']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tsubmit_prareg']."</td>";

                            $timeEnd = strtotime($ub['tsubmit_prareg']);
                    				$timeStart = strtotime($ub['tappbusdev']);
                    				$time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
                    				$time +=  (date("m",$timeEnd)-date("m",$timeStart));
                    				if($time <=0){
                    					$durasi = -1*($time);
                    				}else{
                    					$durasi = $time;
                    				}
                    				$selisih += $durasi;

               $html .="<td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                          ".$durasi."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        if($tot_upb==0){
          $tot = 0;
        }else{
          $tot = $selisih / $tot_upb;
        }
        $result     = number_format($tot,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$tot_upb." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih UPB (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata (Total Selisih / Jumlah UBP) :</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }*/

    function BD1_4A($post){
        // dari parameter 5 sebelumnya

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


        $sqldtl='SELECT u.`tsubmit_prareg` , date((
                        SELECT b.`tappbusdev`
                        FROM plc2.plc2_upb_prioritas b
                        JOIN plc2.plc2_upb_prioritas_detail c ON c.iprioritas_id=b.iprioritas_id
                        WHERE
                        b.ldeleted=0
                        AND c.ldeleted=0
                        AND c.iupb_id=u.iupb_id
                        AND tappbusdev IS NOT NULL
                        ORDER BY b.iprioritas_id ASC LIMIT 1
                    ) )AS tappbusdev , u.`iupb_id`, u.`iGroup_produk`,
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
                    AND u.`tsubmit_prareg` IS NOT NULL and  u.`tsubmit_prareg` <> "0000-00-00"
                    AND u.`ldeleted` = 0
                    and u.itipe_id <> 6
                    AND u.`iteambusdev_id` = 4
                    AND u.`tsubmit_prareg` >= "'.$perode1.'"
                    AND u.`tsubmit_prareg` <= "'.$perode2.'"
            ';

        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                                <th>No</th>
                                <th>No UPB</th>
                                <th>Nama UPB</th>
                                <th>Info Paten</th>
                                <th>Tanggal Seting Prioritas</th>
                                <th>Tanggal Prareg</th>
                                <th>Selisih (Bulan)</th>
                    </tr>
        ";

        $upbDetail = $this->db_erp_pk->query($sqldtl)->result_array();
        $i=0;
        $tot_upb = 0;
        $selisih = 0;
        foreach ($upbDetail as $ub) {
             $i++;
             $tot_upb++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tinfo_paten']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tappbusdev']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tsubmit_prareg']."</td>";

                            $durasi = $this->getDurasiBulan($ub['tappbusdev'],$ub['tsubmit_prareg']);
        /*                    $timeEnd = strtotime($ub['tsubmit_prareg']);
                                    $timeStart = strtotime($ub['tappbusdev']);
                                    $time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
                                    $time +=  (date("m",$timeEnd)-date("m",$timeStart));
                                    if($time <=0){
                                        $durasi = -1*($time);
                                    }else{
                                        $durasi = $time;
                                    }*/
                                    $selisih += $durasi;

               $html .="<td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                          ".$durasi."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        if($tot_upb==0){
          $tot = 0;
        }else{
          $tot = $selisih / $tot_upb;
        }
        $result     = number_format($tot,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$tot_upb." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih UPB (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata (Total Selisih / Jumlah UBP) :</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD1_4($post){
        // dari parameter 5 sebelumnya

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
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqPrareg = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(u.tconfirm_dok_qa) as tconfirm_dok_qa , u.tsubmit_prareg ,
                            ABS(datediff(u.tconfirm_dok_qa, u.tsubmit_prareg)) as selisih,u.iteambusdev_id
                    FROM plc2.plc2_upb u 
                    JOIN hrd.employee e on e.cNip = u.vnip_confirm_dok_qa
                    where u.`ldeleted` = 0 AND u.`iteambusdev_id` = 4 
                    AND u.itipe_id <> 6
                    and u.ineed_prareg=1
                    AND u.iconfirm_dok_qa = 1 AND u.tsubmit_prareg IS NOT NULL
                    AND u.`tsubmit_prareg` >= "'.$perode1.'"
                    AND u.`tsubmit_prareg` <= "'.$perode2.'"
                    ';

        $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='7' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Approval QA Manager Cek Dokumen Prareg</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Team Busdev</th>
                        <th>Approval QA By</th>
                        <th>Tanggal Approval QA</th>
                        <th>Tanggal Submit Prareg</th> 
                        <th>Selisih</th> 
                    </tr>
        "; 

        $cekDouble = array();

        $i=0;
        $sumselisih = 0;
        $total_parareg = 0;
        foreach ($upbPrareg as $ub) {
            $selisih = $this->datediff($ub['tconfirm_dok_qa'],$ub['tsubmit_prareg'],$cNipNya);

            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ub['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }

             $i++;  
             array_push($cekDouble,$u['iupb_id']);
             $total_parareg++;
             $sumselisih += $selisih;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['cNip']."-".$ub['vName']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tconfirm_dok_qa']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tsubmit_prareg']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$selisih."</td>
                        </tr>"; 

        } 
        $html .= "</table><br /> ";

        //-------------------------------------------------------------------------------------- INI REG

        $sqReq = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(u.tconfirm_registrasi_qa) as tconfirm_registrasi_qa, u.tsubmit_reg , ABS(datediff(u.tconfirm_registrasi_qa, u.tsubmit_reg )) as selisih,u.iteambusdev_id
                    FROM plc2.plc2_upb u 
                    JOIN hrd.employee e on e.cNip = u.cnip_confirm_registrasi_qa
                    where u.`ldeleted` = 0 AND u.`iteambusdev_id` = 4 
                    AND u.itipe_id <> 6
                    and u.ineed_prareg=0
                    AND u.iconfirm_registrasi_qa = 1 AND u.tsubmit_reg IS NOT NULL
                    AND u.`tsubmit_reg` >= "'.$perode1.'"
                    AND u.`tsubmit_reg` <= "'.$perode2.'"
                    ';

        $upbReq = $this->db_erp_pk->query($sqReq)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='7' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Approval QA Manager Cek Dokumen Registrasi</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Team Busdev</th>
                        <th>Approval QA By</th>
                        <th>Tanggal Approval QA</th>
                        <th>Tanggal Submit Registrasi</th> 
                        <th>Selisih</th> 
                    </tr>
        "; 
        $i=0;
        $total_req=0;
        $kurangTotal = 0;
        foreach ($upbReq as $ur) {
            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ur['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }

             $i++; 
             $total_req++;
             if (in_array($ur['iupb_id'], $cekDouble)) {
                $kurangTotal++;
             }

             $selisih = $this->datediff($ur['tconfirm_registrasi_qa'],$ur['tsubmit_reg'],$cNipNya);

             $sumselisih += $selisih;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['cNip']."-".$ur['vName']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['tconfirm_registrasi_qa']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['tsubmit_reg']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$selisih."</td>
                        </tr>"; 

        } 
        $html .= "</table><br /> ";

        $totalUpb  = $total_req + $total_parareg; 
        $jumlahUpb = $totalUpb - $kurangTotal;
        if($sumselisih==0){
          $tot = 0;
        }else{
          $tot = $sumselisih / $totalUpb;
          $tot = $tot/5;
        }
        $result     = number_format($tot,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total UPB Prareg & Reg</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalUpb." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih (Hari)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format($sumselisih)." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata- Rata (Minggu)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Minggu</td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

    //Modification Project 476226
    /*function BD1_5($post){
        // dari parameter 5 sebelumnya

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
        $sqlp2 = 'SELECT pb.vkategori , u.`ikategoriupb_id`, u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , u.`tsubmit_prareg`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u
                    JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    WHERE u.`ldeleted` = 0
                    AND u.`iteambusdev_id` = 4
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    and u.itipe_id <> 6
                    AND u.tsubmit_prareg IS NOT NULL and  u.tsubmit_prareg <> "0000-00-00"
                    AND u.`tsubmit_prareg` >= "'.$perode1.'"
                    AND u.`tsubmit_prareg` <= "'.$perode2.'"
                    ORDER by  u.`ikategoriupb_id` ';

        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                      <th>No</th>
                      <th>No UPB</th>
                      <th>Nama UPB</th>
                      <th>Kategori UPB</th>
                      <th>Tgl Prareg</th>
                    </tr>
        ";
        $i=0;
        $t_a =0;
        $t_all=0;
        $upbDetail = $this->db_erp_pk->query($sqlp2)->result_array();
        foreach ($upbDetail as $ub) {
             $i++;
             $col = "";
             $t_all++;
             if($ub['vkategori']=="A"){
               $t_a++;
               $col = "bgcolor='#C0C0C0'";
             }

             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tsubmit_prareg']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Seluruhnya </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$t_all." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori A </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$t_a." </td>
                    </tr>

                </table><br/><br/>";

        $result     = $t_a;
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        echo $result."~".$point."~".$warna."~".$html;
    }*/

    function BD1_5A($post){
        // dari parameter 5 sebelumnya

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
        $sqlp2 = 'SELECT pb.vkategori , u.`ikategoriupb_id`, u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , u.`tsubmit_prareg`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u
                    JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    WHERE u.`ldeleted` = 0
                    AND u.`iteambusdev_id` = 4
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    and u.itipe_id <> 6
                    AND u.tsubmit_prareg IS NOT NULL and  u.tsubmit_prareg <> "0000-00-00"
                    AND u.`tsubmit_prareg` >= "'.$perode1.'"
                    AND u.`tsubmit_prareg` <= "'.$perode2.'"
                    ORDER by  u.`ikategoriupb_id` ';

        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                      <th>No</th>
                      <th>No UPB</th>
                      <th>Nama UPB</th>
                      <th>Kategory UPB</th>
                      <th>Tgl Prareg</th>
                    </tr>
        ";
        $i=0;
        $t_a =0;
        $t_all=0;
        $upbDetail = $this->db_erp_pk->query($sqlp2)->result_array();
        foreach ($upbDetail as $ub) {
             $i++;
             $col = "";
             $t_all++;
             if($ub['vkategori']=="A"){
               $t_a++;
               $col = "bgcolor='#C0C0C0'";
             }

             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tsubmit_prareg']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Seluruhnya </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$t_all." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategory A </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$t_a." </td>
                    </tr>

                </table><br/><br/>";

        $result     = $t_a;
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD1_5($post){
        // dari parameter 5 sebelumnya

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
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqPrareg = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, ua.tupdate, u.tsubmit_prareg  ,u.iteambusdev_id,kat.vkategori
                    FROM plc2.`plc2_upb` u
                        JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                        JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                        join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=u.ikategoriupb_id
                    WHERE u.`ldeleted` = 0 
                    AND u.tsubmit_prareg IS NOT NULL AND u.tsubmit_prareg <>"0000-00-00"
                    AND u.`iteambusdev_id` = 4
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.itipe_id <> 6
                    and u.ineed_prareg = 1
                    AND u.ldeleted = 0 
                    AND u.ikategoriupb_id = 10 # Kategori A
                    AND u.`tsubmit_prareg` >= "'.$perode1.'"
                    AND u.`tsubmit_prareg` <= "'.$perode2.'"
                    ';

        $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Submit Prareg</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th> 
                        <th>Team Busdev</th> 
                        <th>Kategori</th> 
                        <th>Tanggal Approval Direksi</th>
                        <th>Tanggal Submit Prareg</th> 
                    </tr>
        "; 

        $cekDouble = array();

        $i=0;
        $total_parareg = 0;
        foreach ($upbPrareg as $ub) {
            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ub['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }

             $i++; 
             array_push($cekDouble,$u['iupb_id']);
             $total_parareg++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vkategori']."</td>
                                
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tupdate']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tsubmit_prareg']."</td>
                        </tr>"; 

        } 
        $html .= "</table><br /> ";

        //-------------------------------------------------------------------------------------- INI REG

        $sqReq = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, ua.tupdate, u.tregistrasi  ,u.iteambusdev_id,kat.vkategori
                    FROM plc2.`plc2_upb` u
                        JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                        JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                        join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=u.ikategoriupb_id
                    WHERE u.`ldeleted` = 0 
                    AND u.tregistrasi IS NOT NULL AND u.tregistrasi <>"0000-00-00"
                    AND u.`iteambusdev_id` = 4
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.itipe_id <> 6
                    AND u.ldeleted = 0
                    and u.ineed_prareg = 0
                    AND u.ikategoriupb_id = 10 # Kategori A
                    AND u.`tregistrasi` >= "'.$perode1.'"
                    AND u.`tregistrasi` <= "'.$perode2.'"
                    '; 

        $upbReq = $this->db_erp_pk->query($sqReq)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Submit Registrasi</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th> 
                        <th>Team Busdev</th> 
                        <th>Kategori</th> 
                        <th>Tanggal Approval Direksi</th>
                        <th>Tanggal Submit Registrasi</th> 
                    </tr>
        "; 
        $i=0;
        $total_req=0;
        $kurangTotal = 0;
        foreach ($upbReq as $ur) {
            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ur['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }

             $i++; 
             $total_req++;
             if (in_array($ur['iupb_id'], $cekDouble)) {
                $kurangTotal++;
             }
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['vupb_nama']."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vkategori']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['tupdate']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['tregistrasi']."</td>
                        </tr>"; 

        } 
        $html .= "</table><br /> ";

        $totalUpb  = $total_req + $total_parareg; 
        $jumlahUpb = $totalUpb - $kurangTotal; 
        $result     = number_format($jumlahUpb);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total UPB Prareg & Reg</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalUpb." </td>
                    </tr>
                    
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }


    function BD1_6($post){
        // dari parameter 5 sebelumnya

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


        $sql1='SELECT ut.vteam, u.`ikategoriupb_id`, u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , u.`tsubmit_prareg`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u
            JOIN plc2.plc2_upb_team ut on ut.iteam_id = u.iteammarketing_id
            WHERE u.`ldeleted` = 0
            AND u.`iteambusdev_id` = 4
            AND u.iteammarketing_id IS NOT NULL
            AND u.tsubmit_prareg IS NOT NULL
            and u.itipe_id <> 6
            AND u.`tsubmit_prareg` >= "'.$perode1.'"
            AND u.`tsubmit_prareg` <= "'.$perode2.'"
            ';

        $sql2= ' order by u.iteammarketing_id';

        $sqlDetail = $sql1.$sql2;

        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                      <th>No</th>
                      <th>No UPB</th>
                      <th>Nama UPB</th>
                      <th>Info Paten</th>
                      <th>Team Marketing</th>
                      <th>Tgl Prareg</th>
                    </tr>
        ";


        $i=0;
        $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
        foreach ($upbDetail as $ub) {
             $i++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tinfo_paten']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['vteam']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['tsubmit_prareg']."</td>
                      </tr>";

        }

                            $detailMKT = '<table border="1" style="border:1px;border-collapse:collapse;">
                            <thead>
                                <th>
                                    No
                                </th>
                                <th>
                                    Marketing
                                </th>
                                <th>
                                    Jumlah UPB
                                </th>
                            </thead>
                            <tbody>';

            $sqlMar = 'select b.vteam,b.iteam_id 
                        from plc2.group_marketing a 
                        join plc2.plc2_upb_team b on b.iGroup_marketing=a.iGroup_marketing
                        where a.iGroup_marketing=1';                      
            $dMar = $this->db_erp_pk->query($sqlMar)->result_array();            
                            $no=1;
                            $retArr = array();
                            foreach ($dMar as $mar) {
                                $sqlCMkt = $sql1.' and iteammarketing_id = "'.$mar['iteam_id'].'"  ';

                              //  echo $sqlCMkt;
                                $countMR = $this->db_erp_pk->query($sqlCMkt)->num_rows();

                                array_push($retArr, $countMR);
                                $detailMKT .= '<tr>
                                                    <td>'.$no.'</td>
                                                    <td style="text-align:left;">'.$mar['vteam'].'</td>
                                                    <td>'.$countMR.'</td>
                                              </tr>';
                                    
                                $no++;
                            }
            $detailMKT .=   '</tbody>
                        </table>';

            $smallestMkt = min($retArr);
            $result     = $smallestMkt;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];



        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Seluruh UPB </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." UPB </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB / Marketing</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$detailMKT." Marketing</td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Terkecil</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." UPB /Divisi</td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

    //Modification Project 476226
    /*function BD1_7($post){
        // dari parameter 5 sebelumnya

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

            //Menghitung BE
        $sqlp1='SELECT pb.vkategori ,pu.`ibe`, pu.`tsubmit_prareg`,pu.`ttarget_hpr` ,pu.`iupb_id`
                ,pu.`iGroup_produk`,
                     pu.`vupb_nomor`,pu.vupb_nama ,  pu.vKode_obat
                FROM plc2.`plc2_upb` pu
                JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = pu.`ikategoriupb_id`
                WHERE
                pu.`ldeleted` = 0
                AND pu.`tsubmit_prareg` IS NOT NULL
                AND pu.`ttarget_hpr` IS NOT NULL
                AND pu.`ikategoriupb_id` = 10
                AND pu.`iteambusdev_id` = 4
                and pu.itipe_id <> 6
                AND pu.`ttarget_hpr` >= "'.$perode1.'"
                AND pu.`ttarget_hpr` <= "'.$perode2.'"

                Order BY pu.`ibe`';


        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <th>No</th>
                    <th>No UPB</th>
                    <th>Nama UPB</th>
                    <th>Tipe BE</th>
                    <th>Kategori UPB</th>
                    <th>Tanggal HPR</th>
                    <th>Tanggal Prareg</th>
                    <th>Selisih (Bulan)</th>
                    </tr>
        ";


        $i_be=0;
        $i_nbe=0;
        $be = array('1'=>'BE','2'=>'Non BE');
        $selisih_be = 0;
        $selisih_nbe = 0;
        $upbDetail = $this->db_erp_pk->query($sqlp1)->result_array();

        $t_all = 0;
        $se_al = 0;
        foreach ($upbDetail as $ub) {
             $timeEnd = strtotime($ub['ttarget_hpr']);
             $timeStart = strtotime($ub['tsubmit_prareg']);
             $time =(date("Y",$timeEnd)-date("Y",$timeStart))*12;
             $time +=  (date("m",$timeEnd)-date("m",$timeStart));
             if($time <=0){
              $durasi = -1*($time);
             }else{
              $durasi = $time;
             }
             $se_al += $durasi;
             $t_all ++;


             $col = "";
             if($ub['ibe']==1){
               $i_be++;
               $selisih_be += $durasi;
               $col = "bgcolor='#C0C0C0'";
               $i = $i_be;
             }else{
               $i_nbe++;
               $i = $i_nbe;
               $selisih_nbe += $durasi;
             }


             $html .= "<tr ".$col." style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$be[$ub['ibe']]."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['ttarget_hpr']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['tsubmit_prareg']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$durasi."</td>
                      </tr>";

        }

        if($t_all==0){
          $tot = 0;
        }else{
          $tot = $se_al/$t_all;
        }
            //Menghitung Jumalah Divisi Marketing (B)
        $result     = number_format($tot,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB BE</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i_be." UPB </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih UPB BE</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih_be." Bulan </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB NON BE</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i_nbe." UPB </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih UPB NON BE</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih_nbe." Bulan </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata (Total Selisih (BE & NBE) / Jumlah UBP (BE & NBE))</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan </td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }*/
    function BD1_7A($post){
        // dari parameter 5 sebelumnya

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

            //Menghitung BE
        $sqlp1='SELECT pb.vkategori ,pu.`ibe`, pu.`tsubmit_prareg`,pu.`ttarget_hpr` ,pu.`iupb_id`
                ,pu.`iGroup_produk`,
                     pu.`vupb_nomor`,pu.vupb_nama ,  pu.vKode_obat
                FROM plc2.`plc2_upb` pu
                JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = pu.`ikategoriupb_id`
                WHERE
                pu.`ldeleted` = 0
                AND pu.`tsubmit_prareg` IS NOT NULL
                AND pu.`ttarget_hpr` IS NOT NULL
                AND pu.`ikategoriupb_id` = 10
                AND pu.`iteambusdev_id` = 4
                and pu.itipe_id <> 6
                AND pu.`ttarget_hpr` >= "'.$perode1.'"
                AND pu.`ttarget_hpr` <= "'.$perode2.'"

                Order BY pu.`ibe`';


        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <th>No</th>
                    <th>No UPB</th>
                    <th>Nama UPB</th>
                    <th>Tipe BE</th>
                    <th>Kategory UPB</th>
                    <th>Tanggal HPR</th>
                    <th>Tanggal Prareg</th>
                    <th>Selisih (Bulan)</th>
                    </tr>
        ";


        $i_be=0;
        $i_nbe=0;
        $be = array('1'=>'BE','2'=>'Non BE');
        $selisih_be = 0;
        $selisih_nbe = 0;
        $upbDetail = $this->db_erp_pk->query($sqlp1)->result_array();

        $t_all = 0;
        $se_al = 0;
        foreach ($upbDetail as $ub) {
/*             $timeEnd = strtotime($ub['ttarget_hpr']);
             $timeStart = strtotime($ub['tsubmit_prareg']);
             $time =(date("Y",$timeEnd)-date("Y",$timeStart))*12;
             $time +=  (date("m",$timeEnd)-date("m",$timeStart));
             if($time <=0){
              $durasi = -1*($time);
             }else{
              $durasi = $time;
             }*/

             $durasi = $this->getDurasiBulan($ub['tsubmit_prareg'],$ub['ttarget_hpr']);

             $se_al += $durasi;
             $t_all ++;


             $col = "";
             if($ub['ibe']==1){
               $i_be++;
               $selisih_be += $durasi;
               $col = "bgcolor='#C0C0C0'";
               $i = $i_be;
             }else{
               $i_nbe++;
               $i = $i_nbe;
               $selisih_nbe += $durasi;
             }


             $html .= "<tr ".$col." style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$be[$ub['ibe']]."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['ttarget_hpr']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['tsubmit_prareg']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$durasi."</td>
                      </tr>";

        }

        if($t_all==0){
          $tot = 0;
        }else{
          $tot = $se_al/$t_all;
        }
            //Menghitung Jumalah Divisi Marketing (B)
        $result     = number_format($tot,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB BE</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i_be." UPB </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih UPB BE</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih_be." Bulan </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB NON BE</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i_nbe." UPB </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih UPB NON BE</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih_nbe." Bulan </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata (Total Selisih (BE & NBE) / Jumlah UBP (BE & NBE))</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan </td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD1_7($post){
        // dari parameter 5 sebelumnya

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

         
        $sqlRata = 'SELECT  pu.`vupb_nomor`,pu.vupb_nama , pb.vkategori , pu.`tsubmit_prareg`,pu.`ttarget_hpr` , ABS(datediff(pu.`ttarget_hpr`, pu.`tsubmit_prareg`)) as selisih,pu.iteambusdev_id
            FROM plc2.`plc2_upb` pu
            JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = pu.`ikategoriupb_id`
            WHERE
            pu.`ldeleted` = 0
            AND pu.`tsubmit_prareg` IS NOT NULL
            AND pu.`ttarget_hpr` IS NOT NULL AND pu.`ttarget_hpr` <>"0000-00-00"
            AND pu.`ikategoriupb_id` = 10
            AND pu.`iteambusdev_id` = 4
            and pu.itipe_id <> 6
            AND pu.`ttarget_hpr` >= "'.$perode1.'"
            AND pu.`ttarget_hpr` <= "'.$perode2.'" ';  

        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <th>No</th>
                    <th>No UPB</th>
                    <th>Nama UPB</th> 
                    <th>Team Busdev</th> 
                    <th>Kategori UPB</th>
                    <th>Tanggal HPR</th>
                    <th>Tanggal Prareg</th>
                    <th>Selisih (Bulan)</th>
                    </tr>
        ";
 
        $upbDetail = $this->db_erp_pk->query($sqlRata)->result_array(); 
        $i = 0;
        $totalUpb=0;
        $totalSls=0;
        foreach ($upbDetail as $ub) { 
            
            //$selisih = $this->selisihHari($ub['tsubmit_prareg'],$ub['ttarget_hpr'],$cNipNya);
            $selisih = $this->getDurasiBulan($ub['tsubmit_prareg'],$ub['ttarget_hpr']);

            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ub['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }
             $i++;
             $totalUpb++;
             $totalSls += $selisih;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td> 
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['ttarget_hpr']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['tsubmit_prareg']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$selisih."</td>
                      </tr>"; 
        }

        $tot        = $totalSls/$totalUpb;   
        $result     = number_format($tot,2);
        //$result     = number_format(($result/22),2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalUpb." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih Bulan</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalSls." Bulan </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Rata-Rata Selisih Bulan</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan </td>
                    </tr> 
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }


    function BD1_8($post){
        // dari parameter 5 sebelumnya

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

        $sql_pp = 'SELECT m.vNama_Group ,u.iGroup_produk, pb.vkategori , u.dinput_applet, u.`ikategoriupb_id`, u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , u.`tsubmit_prareg`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u 
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 4 
                    AND u.dinput_applet IS NOT NULL 
                    AND u.`dinput_applet` >= "'.$perode1.'" 
                    AND u.`dinput_applet` <= "'.$perode2.'" 
                    AND u.`ikategoriupb_id` = 10 
                    AND u.itipe_id <> 6
                    ORDER by u.iGroup_produk
                    '; 

         $sql_t = 'SELECT COUNT(DISTINCT(u.`iGroup_produk`)) AS t_upb FROM plc2.`plc2_upb` u 
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 4 
                    AND u.dinput_applet IS NOT NULL 
                    AND u.`dinput_applet` >= "'.$perode1.'" 
                    AND u.`dinput_applet` <= "'.$perode2.'" 
                    AND u.`ikategoriupb_id` = 10 
                    AND u.itipe_id <> 6
                    ';
 

        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategori UPB</th>  
                          <th>Group Produk</th>
                          <th>Tgl Applet</th>
                    </tr>
        ";
        $i=0; 
        $upbDetail = $this->db_erp_pk->query($sql_pp)->result_array();
        foreach ($upbDetail as $ub) {
             $i++; 

             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vNama_Group']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dinput_applet']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        $jum = $this->db_erp_pk->query($sql_t)->row_array();
        if(empty($jum['t_upb'])){
            $result     = 0;
        }else{ 
            $result     = $jum['t_upb'];
        }
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Group Produk (Kategori A) </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Group Produk</td>
                    </tr> 
                </table><br/><br/>";
 

        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD1_9($post){
        // dari parameter 5 sebelumnya

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

        $sql_pp = 'SELECT m.vNama_Group ,u.iGroup_produk, pb.vkategori , u.dinput_applet, u.`ikategoriupb_id`, u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , u.`tsubmit_prareg`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u 
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 4 
                    AND u.dinput_applet IS NOT NULL 
                    AND u.`dinput_applet` >= "'.$perode1.'" 
                    AND u.`dinput_applet` <= "'.$perode2.'" 
                    AND u.`ikategoriupb_id` = 11 
                    AND u.itipe_id <> 6
                    ORDER by u.iGroup_produk
                    '; 

         $sql_t = 'SELECT COUNT(DISTINCT(u.`iGroup_produk`)) AS t_upb FROM plc2.`plc2_upb` u 
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 4 
                    AND u.dinput_applet IS NOT NULL 
                    AND u.`dinput_applet` >= "'.$perode1.'" 
                    AND u.`dinput_applet` <= "'.$perode2.'" 
                    AND u.`ikategoriupb_id` = 11
                    AND u.itipe_id <> 6
                    ';
 

        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategori UPB</th>  
                          <th>Group Produk</th>
                          <th>Tgl Applet</th>
                    </tr>
        ";
        $i=0; 
        $upbDetail = $this->db_erp_pk->query($sql_pp)->result_array();
        foreach ($upbDetail as $ub) {
             $i++; 

             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vNama_Group']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dinput_applet']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        $jum = $this->db_erp_pk->query($sql_t)->row_array();
        if(empty($jum['t_upb'])){
            $result     = 0;
        }else{ 
            $result     = $jum['t_upb'];
        }
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Group Produk (Kategori B) </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Group Produk</td>
                    </tr> 
                </table><br/><br/>";
 

        echo $result."~".$point."~".$warna."~".$html;
    }

    //Modification Project 476226
    /*function BD1_10($post){
        // dari parameter 5 sebelumnya

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

        
        $sql_pp = ' SELECT pb.vkategori ,u.`iupb_id` , u.`dinput_applet` , u.`tregistrasi`, u.ikategoriupb_id, u.`vupb_nomor`,u.vupb_nama ,  u.vKode_obat FROM plc2.`plc2_upb` u 
             JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 4 
                    AND u.dinput_applet IS NOT NULL 
                    AND u.tregistrasi IS NOT NULL  
                    AND u.`ikategoriupb_id` = 10 
                    AND u.itipe_id <> 6
                    AND u.`dinput_applet` >= "'.$perode1.'" 
                    AND u.`dinput_applet` <= "'.$perode2.'" '; 

       
        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategori UPB</th>  
                          <th>Tanggal Applet</th> 
                          <th>Tanggal Registrasi</th> 
                          <th>Selisih (Bulan)</th> 
                    </tr>
        ";
        $i=0; 
        $selisih = 0;
        $tot_u = 0;
        $upbDetail = $this->db_erp_pk->query($sql_pp)->result_array();
        foreach ($upbDetail as $ub) {
             $i++; 
             $tot_u++;


                $timeEnd = strtotime($ub['dinput_applet']);
                $timeStart = strtotime($ub['tregistrasi']);
                $time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
                $time +=  (date("m",$timeEnd)-date("m",$timeStart));      
                if($time <=0){
                    $durasi = -1*($time); 
                }else{
                    $durasi = $time;
                }
                $selisih += $durasi;


             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td> 
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dinput_applet']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tregistrasi']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$durasi."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        if($tot_u==0){
            $result = 0;
        }else{
            $tot = $selisih/$tot_u;
            $result = number_format($tot,2);
        } 
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori A </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$tot_u." </td>
                    </tr> 

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata (Total Selisih / Jumlah UBP Kategori A)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan</td>
                    </tr> 

                </table><br/><br/>";
 

        echo $result."~".$point."~".$warna."~".$html;
    }*/

    function BD1_10A($post){
        // dari parameter 5 sebelumnya

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

        
        $sql_pp = ' SELECT pb.vkategori ,u.`iupb_id` , date(u.`dinput_applet`) as dinput_applet  , u.`tregistrasi`, u.ikategoriupb_id, u.`vupb_nomor`,u.vupb_nama ,  u.vKode_obat 
            FROM plc2.`plc2_upb` u 
             JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 4 
                    AND u.dinput_applet IS NOT NULL 
                    AND u.tregistrasi IS NOT NULL  
                    AND u.`ikategoriupb_id` = 10 
                    AND u.itipe_id <> 6
                    
                    AND u.`dinput_applet` >= "'.$perode1.'" 
                    AND u.`dinput_applet` <= "'.$perode2.'" '; 

       
        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategory UPB</th>  
                          <th>Tanggal Applet</th> 
                          <th>Tanggal Registrasi</th> 
                          <th>Selisih (Bulan)</th> 
                    </tr>
        ";
        $i=0; 
        $selisih = 0;
        $tot_u = 0;
        $upbDetail = $this->db_erp_pk->query($sql_pp)->result_array();
        foreach ($upbDetail as $ub) {
             $i++; 
             $tot_u++;


                /*$timeEnd = strtotime($ub['dinput_applet']);
                $timeStart = strtotime($ub['tregistrasi']);
                $time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
                $time +=  (date("m",$timeEnd)-date("m",$timeStart));      
                if($time <=0){
                    $durasi = -1*($time); 
                }else{
                    $durasi = $time;
                }*/
                $durasi = $this->getDurasiBulan($ub['tregistrasi'],$ub['dinput_applet']);
                $selisih += $durasi;


             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td> 
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dinput_applet']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tregistrasi']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$durasi."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        if($tot_u==0){
            $result = 0;
        }else{
            $tot = $selisih/$tot_u;
            $result = number_format($tot,2);
        } 
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori A </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$tot_u." </td>
                    </tr> 

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata (Total Selisih / Jumlah UBP Kategory A)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan</td>
                    </tr> 

                </table><br/><br/>";
 

        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD1_10($post){
        // dari parameter 5 sebelumnya

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

        
        $sqlReq = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama,  u.tregistrasi , pb.vkategori,
                        u.dinput_applet,u.dNie,
                    ABS(datediff(u.tregistrasi, IF(u.dinput_applet IS NOT NULL and  u.dinput_applet<>"0000-00-00", u.dinput_applet, u.dNie))) AS SELISIH

                    FROM plc2.`plc2_upb` u 
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    WHERE u.`ldeleted` = 0 
                        AND u.tregistrasi IS NOT NULL AND u.tregistrasi <>"0000-00-00"
                        AND u.`iteambusdev_id` = 4  
                        AND u.itipe_id <> 6
                        and u.iKomnas = 0 
                        AND u.ldeleted = 0
                        AND (u.`ikategoriupb_id` = 10  or u.`ikategoriupb_id` = 1 or u.`ikategoriupb_id` = 20 or u.`ikategoriupb_id` = 21 or u.`ikategoriupb_id` = 22)
                        AND 
                        IF(u.dinput_applet IS not NULL and u.dinput_applet<>"0000-00-00",
                            u.dinput_applet IS NOT NULL 
                            AND u.dinput_applet <> "0000-00-00" 
                            AND u.dinput_applet >= "'.$perode1.'" 
                            AND u.dinput_applet <= "'.$perode2.'" 
                            , 
                            u.dNie IS NOT NULL 
                            AND u.dNie <> "0000-00-00" 
                            AND u.dNie >= "'.$perode1.'" 
                            AND u.dNie <= "'.$perode2.'" 
                            
                        )';
 

       
        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategori UPB</th>   
                          <th>Tanggal Registrasi</th> 
                          <th>Tanggal Applet</th> 
                          <th>Tanggal NIE</th> 
                          <th>Selisih </th> 
                    </tr>
        ";
        $i=0; 
        $selisih = 0; 
        $upbDetail = $this->db_erp_pk->query($sqlReq)->result_array();
        foreach ($upbDetail as $ub) {

            $tgl1=$ub['tregistrasi'];

            if($ub['dinput_applet'] <> ''){
                $tgl2=$ub['dinput_applet'];
            }else{
                $tgl2=$ub['dNie'];
            }
            
            /*$sel = $this->selisihHari($tgl1,$tgl2,$cNipNya);*/
            $sel = $this->getDurasiBulan($tgl1,$tgl2);

             $i++;  
             $selisih += $sel;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td> 
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tregistrasi']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dinput_applet']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dNie']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$sel."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        if($selisih==0){
            $result = 0;
            /*$result  = number_format($tot,2);
            $result  = number_format(($result/22),2);*/

        }else{
            $tot = $selisih/$i;
            $result     = number_format($tot,2);
            //$result     = number_format(($result/22),2);

            
        } 


        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori A </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                    </tr> 

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format($selisih,2)." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'> Rata - Rata Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr> 
                </table><br/><br/>";
 

        echo $result."~".$point."~".$warna."~".$html;
    }

    //Modification Project 476226
    /*function BD1_11($post){
        // dari parameter 5 sebelumnya

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

        
    

         $sql_pp = 'SELECT pb.vkategori , u.`iupb_id` ,u.`vupb_nomor`,u.vupb_nama ,  u.vKode_obat, u.`dinput_applet` , u.`tregistrasi`, 
                    u.ikategoriupb_id, 

                    (
                        SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                            AND ad.`iupb_id`  = u.`iupb_id`
                            AND ad.`dsubmit_dok` IS NOT NULL
                            ORDER BY ad.`dsubmit_dok` DESC LIMIT 1
                    )  AS dsubmit_dok

                    FROM plc2.`plc2_upb` u  
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    WHERE u.`ldeleted` = 0 
                    AND u.`iupb_id` IN (SELECT ad.`iupb_id` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0  
                    AND ad.`dsubmit_dok` IS NOT NULL )
                    AND u.itipe_id <> 6
                    AND u.`iteambusdev_id` = 4 
                    AND u.dinput_applet IS NOT NULL 
                    AND u.tregistrasi IS NOT NULL 
                    AND u.`ikategoriupb_id` = 11 
                    AND u.`dinput_applet` >= "'.$perode1.'" 
                    AND u.`dinput_applet` <= "'.$perode2.'" '; 


       
        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategori UPB</th>  
                          <th>Tanggal Applet Dokumen</th> 
                          <th>Tanggal LAST TD</th>  
                          <th>Selisih (Bulan)</th> 
                    </tr>
        ";
        $i=0; 
        $selisih = 0;
        $tot_u = 0;
        $upbDetail = $this->db_erp_pk->query($sql_pp)->result_array();
        foreach ($upbDetail as $ub) {
             $i++; 
             $tot_u++;


                $timeEnd = strtotime($ub['dinput_applet']);
                $timeStart = strtotime($ub['dsubmit_dok']);
                $time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
                $time +=  (date("m",$timeEnd)-date("m",$timeStart));      
                if($time <=0){
                    $durasi = -1*($time); 
                }else{
                    $durasi = $time;
                }
                $selisih += $durasi;


             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td> 
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dinput_applet']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dsubmit_dok']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$durasi."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        if($tot_u==0){
            $result = 0;
        }else{
            $tot = $selisih/$tot_u;
            $result = number_format($tot,2);
        } 
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori B </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$tot_u." </td>
                    </tr> 

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata (Total Selisih / Jumlah UBP Kategori B)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan</td>
                    </tr> 

                </table><br/><br/>";
 

        echo $result."~".$point."~".$warna."~".$html;
    }*/
    function BD1_11A($post){
        // dari parameter 5 sebelumnya

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

        
    

         $sql_pp = 'SELECT pb.vkategori , u.`iupb_id` ,u.`vupb_nomor`,u.vupb_nama ,  u.vKode_obat, date(u.`dinput_applet`) as dinput_applet  , u.`tregistrasi`, 
                    u.ikategoriupb_id, 

                    date((SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                    AND ad.`iupb_id`  = u.`iupb_id`
                    AND ad.`dsubmit_dok` IS NOT NULL
                    ORDER BY ad.`dsubmit_dok` DESC LIMIT 1) ) AS dsubmit_dok

                    FROM plc2.`plc2_upb` u  
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    WHERE u.`ldeleted` = 0 
                    AND u.`iupb_id` IN (SELECT ad.`iupb_id` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0  
                    AND ad.`dsubmit_dok` IS NOT NULL )
                    AND u.itipe_id <> 6
                    AND u.`iteambusdev_id` = 4 
                    AND u.dinput_applet IS NOT NULL 
                    AND u.tregistrasi IS NOT NULL 
                    AND u.`ikategoriupb_id` = 11 
                    AND u.`dinput_applet` >= "'.$perode1.'" 
                    AND u.`dinput_applet` <= "'.$perode2.'" '; 


       
        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategory UPB</th>  
                          <th>Tanggal Applet Dokumen</th> 
                          <th>Tanggal LAST TD</th>  
                          <th>Selisih (Bulan)</th> 
                    </tr>
        ";
        $i=0; 
        $selisih = 0;
        $tot_u = 0;
        $upbDetail = $this->db_erp_pk->query($sql_pp)->result_array();
        foreach ($upbDetail as $ub) {
             $i++; 
             $tot_u++;


                /*$timeEnd = strtotime($ub['dinput_applet']);
                $timeStart = strtotime($ub['dsubmit_dok']);
                $time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
                $time +=  (date("m",$timeEnd)-date("m",$timeStart));      
                if($time <=0){
                    $durasi = -1*($time); 
                }else{
                    $durasi = $time;
                }*/

                $durasi = $this->getDurasiBulan($ub['dsubmit_dok'],$ub['dinput_applet']);
                
                $selisih += $durasi;


             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td> 
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dinput_applet']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dsubmit_dok']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$durasi."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        if($tot_u==0){
            $result = 0;
        }else{
            $tot = $selisih/$tot_u;
            $result = number_format($tot,2);
        } 
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori B </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$tot_u." </td>
                    </tr> 

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - rata (Total Selisih / Jumlah UBP Kategory B)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan</td>
                    </tr> 

                </table><br/><br/>";
 

        echo $result."~".$point."~".$warna."~".$html;
    }
    function BD1_11($post){
        // dari parameter 5 sebelumnya

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

        
        $sqlTD = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama,  pb.vkategori,
                    ( SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                          AND ad.`iupb_id`  = u.`iupb_id`
                          AND ad.`dsubmit_dok` IS NOT NULL
                          ORDER BY ad.`dsubmit_dok` DESC LIMIT 1
                    )  AS dsubmit_dok,

                    u.dinput_applet,u.dNie,
                    (SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                              AND ad.`iupb_id`  = u.`iupb_id`
                              AND ad.`dsubmit_dok` IS NOT NULL
                              ORDER BY ad.`dsubmit_dok` DESC LIMIT 1) as TAMPIL1,
                    u.tsubmit_reg as TAMPIL

                    #IF(u.dinput_applet IS NULL or u.dinput_applet<>"0000-00-00", u.dNie, u.dinput_applet) AS TAMPIL,
                    ,ABS(datediff(
                        ( SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                              AND ad.`iupb_id`  = u.`iupb_id`
                              AND ad.`dsubmit_dok` IS NOT NULL
                              ORDER BY ad.`dsubmit_dok` DESC LIMIT 1
                        ), IF(u.dinput_applet IS not NULL and u.dinput_applet<>"0000-00-00", 
                             u.dinput_applet ,u.dNie  ))
                    ) 
                    AS SELISIH
                  FROM plc2.`plc2_upb` u 
                  JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                  WHERE u.`ldeleted` = 0  
                      AND u.`iteambusdev_id` = 4  
                      AND u.itipe_id <> 6
                      AND u.`iupb_id` IN (SELECT ad.`iupb_id` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0  
                            AND ad.`dsubmit_dok` IS NOT NULL )
                      AND u.ldeleted = 0
                      AND u.`ikategoriupb_id` = 11
                      and u.tsubmit_reg is not null
                      AND 
                      IF(u.dinput_applet IS not NULL and u.dinput_applet<>"0000-00-00",
                            u.dinput_applet IS NOT NULL 
                            AND u.dinput_applet <> "0000-00-00" 
                            AND u.dinput_applet >= "'.$perode1.'" 
                            AND u.dinput_applet <= "'.$perode2.'" 
                            , 
                            u.dNie IS NOT NULL 
                            AND u.dNie <> "0000-00-00" 
                            AND u.dNie >= "'.$perode1.'" 
                            AND u.dNie <= "'.$perode2.'" 
                            
                        )';
        /*echo '<pre>'.$sqlTD;*/
        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategori UPB</th>  
                          <th>Tanggal Applet Dokumen</th> 
                          <th>Tanggal NIE</th> 
                          <th>Tanggal Registrasi</th>  
                          <th>Selisih (Hari)</th> 
                    </tr>
        ";
        $i=0;  
        $selisih = 0; 
        $upbDetail = $this->db_erp_pk->query($sqlTD)->result_array();
        foreach ($upbDetail as $ub) {
            $tgl1=$ub['TAMPIL'];

            if($ub['dinput_applet'] <> ''){
                $tgl2=$ub['dinput_applet'];
            }else{
                $tgl2=$ub['dNie'];
            }
            
            $sel = $this->getDurasiBulan($tgl1,$tgl2);

             $i++;   
             $selisih += $sel;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td> 
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dinput_applet']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dNie']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['TAMPIL']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$sel."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        if($selisih==0){
            $result = 0;
        }else{
            $tot = $selisih/$i;
            $result  = number_format($tot,2);
            //$result  = number_format(($result/22),2);

            /*$result = number_format($tot,2);*/
        } 
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori B </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                    </tr> 

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - Rata Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr> 

                </table><br/><br/>";

        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_11($post){
        // dari parameter 5 sebelumnya

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

        
        $sqlTD = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama,  pb.vkategori,
                    ( SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                          AND ad.`iupb_id`  = u.`iupb_id`
                          AND ad.`dsubmit_dok` IS NOT NULL
                          ORDER BY ad.`dsubmit_dok` DESC LIMIT 1
                    )  AS dsubmit_dok,

                    u.dinput_applet,u.dNie,
                    (SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                              AND ad.`iupb_id`  = u.`iupb_id`
                              AND ad.`dsubmit_dok` IS NOT NULL
                              ORDER BY ad.`dsubmit_dok` DESC LIMIT 1) as TAMPIL

                    #IF(u.dinput_applet IS NULL or u.dinput_applet<>"0000-00-00", u.dNie, u.dinput_applet) AS TAMPIL,
                    ,ABS(datediff(
                        ( SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                              AND ad.`iupb_id`  = u.`iupb_id`
                              AND ad.`dsubmit_dok` IS NOT NULL
                              ORDER BY ad.`dsubmit_dok` DESC LIMIT 1
                        ), IF(u.dinput_applet IS not NULL and u.dinput_applet<>"0000-00-00", 
                             u.dinput_applet ,u.dNie  ))
                    ) 
                    AS SELISIH
                  FROM plc2.`plc2_upb` u 
                  JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                  WHERE u.`ldeleted` = 0  
                      AND u.`iteambusdev_id` = 22  
                      AND u.itipe_id <> 6
                      AND u.`iupb_id` IN (SELECT ad.`iupb_id` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0  
                            AND ad.`dsubmit_dok` IS NOT NULL )
                      AND u.ldeleted = 0
                      AND u.`ikategoriupb_id` = 11
                      AND 
                      IF(u.dinput_applet IS not NULL and u.dinput_applet<>"0000-00-00",
                            u.dinput_applet IS NOT NULL 
                            AND u.dinput_applet <> "0000-00-00" 
                            AND u.dinput_applet >= "'.$perode1.'" 
                            AND u.dinput_applet <= "'.$perode2.'" 
                            , 
                            u.dNie IS NOT NULL 
                            AND u.dNie <> "0000-00-00" 
                            AND u.dNie >= "'.$perode1.'" 
                            AND u.dNie <= "'.$perode2.'" 
                            
                        )';
        /*echo '<pre>'.$sqlTD;*/
        
        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategori UPB</th>  
                          <th>Tanggal Applet Dokumen</th> 
                          <th>Tanggal NIE</th> 
                          <th>Tanggal LAST TD</th>  
                          <th>Selisih (Bulan)</th> 
                    </tr>
        ";
        $i=0;  
        $selisih = 0; 
        $upbDetail = $this->db_erp_pk->query($sqlTD)->result_array();
        foreach ($upbDetail as $ub) {
            $tgl1=$ub['TAMPIL'];

            if($ub['dinput_applet'] <> ''){
                $tgl2=$ub['dinput_applet'];
            }else{
                $tgl2=$ub['dNie'];
            }
            
            $sel = $this->getDurasiBulan($tgl1,$tgl2);

             $i++;   
             $selisih += $sel;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td> 
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dinput_applet']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dNie']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['TAMPIL']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$sel."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        if($selisih==0){
            $result = 0;
        }else{
            $tot = $selisih/$i;
            $result  = number_format($tot,2);
            //$result  = number_format(($result/22),2);

            /*$result = number_format($tot,2);*/
        } 
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori B </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                    </tr> 

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - Rata Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr> 

                </table><br/><br/>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2xy_11($post){
        // dari parameter 5 sebelumnya

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

        
        $sqlTD = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama,  pb.vkategori,
                    ( SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                          AND ad.`iupb_id`  = u.`iupb_id`
                          AND ad.`dsubmit_dok` IS NOT NULL
                          ORDER BY ad.`dsubmit_dok` DESC LIMIT 1
                    )  AS dsubmit_dok,

                    u.dinput_applet,u.dNie,
                    (SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                              AND ad.`iupb_id`  = u.`iupb_id`
                              AND ad.`dsubmit_dok` IS NOT NULL
                              ORDER BY ad.`dsubmit_dok` DESC LIMIT 1) as TAMPIL

                    #IF(u.dinput_applet IS NULL or u.dinput_applet<>"0000-00-00", u.dNie, u.dinput_applet) AS TAMPIL,
                    ,ABS(datediff(
                        ( SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                              AND ad.`iupb_id`  = u.`iupb_id`
                              AND ad.`dsubmit_dok` IS NOT NULL
                              ORDER BY ad.`dsubmit_dok` DESC LIMIT 1
                        ), IF(u.dinput_applet IS not NULL and u.dinput_applet<>"0000-00-00", 
                             u.dinput_applet ,u.dNie  ))
                    ) 
                    AS SELISIH
                  FROM plc2.`plc2_upb` u 
                  JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                  WHERE u.`ldeleted` = 0  
                      AND u.`iteambusdev_id` = 22  
                      AND u.itipe_id <> 6
                      AND u.`iupb_id` IN (SELECT ad.`iupb_id` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0  
                            AND ad.`dsubmit_dok` IS NOT NULL )
                      AND u.ldeleted = 0
                      AND u.`ikategoriupb_id` = 11
                      AND 
                      IF(u.dinput_applet IS not NULL and u.dinput_applet<>"0000-00-00",
                            u.dinput_applet IS NOT NULL 
                            AND u.dinput_applet <> "0000-00-00" 
                            AND u.dinput_applet >= "'.$perode1.'" 
                            AND u.dinput_applet <= "'.$perode2.'" 
                            , 
                            u.dNie IS NOT NULL 
                            AND u.dNie <> "0000-00-00" 
                            AND u.dNie >= "'.$perode1.'" 
                            AND u.dNie <= "'.$perode2.'" 
                            
                        )';
  
        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategori UPB</th>  
                          <th>Tanggal Applet Dokumen</th> 
                          <th>Tanggal NIE</th> 
                          <th>Tanggal LAST TD</th>  
                          <th>Selisih (Hari)</th> 
                    </tr>
        ";
        $i=0;  
        $selisih = 0; 
        $upbDetail = $this->db_erp_pk->query($sqlTD)->result_array();
        foreach ($upbDetail as $ub) {
             $i++;   
             $selisih += $ub['SELISIH'];
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td> 
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dinput_applet']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dNie']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['TAMPIL']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['SELISIH']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        if($selisih==0){
            $result = 0;
        }else{
            $tot = $selisih/$i;
            $result  = number_format($tot,2);
            $result  = number_format(($result/22),2);

            /*$result = number_format($tot,2);*/
        } 
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori B </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                    </tr> 

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Hari)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr> 

                </table><br/><br/>";
 

        echo $result."~".$point."~".$warna."~".$html;
    }
    function BD2_11xx($post){
        // dari parameter 5 sebelumnya

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

        
        $sqlTD = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama,  pb.vkategori,
                    ( SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                          AND ad.`iupb_id`  = u.`iupb_id`
                          AND ad.`dsubmit_dok` IS NOT NULL
                          ORDER BY ad.`dsubmit_dok` DESC LIMIT 1
                    )  AS dsubmit_dok,
                    IF(u.dinput_applet IS NULL or u.dinput_applet<>"0000-00-00", u.dinput_applet, u.dNie) AS TAMPIL,
                    ABS(datediff(
                        ( SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                              AND ad.`iupb_id`  = u.`iupb_id`
                              AND ad.`dsubmit_dok` IS NOT NULL
                              ORDER BY ad.`dsubmit_dok` DESC LIMIT 1
                        ), IF(u.dinput_applet IS NULL or u.dinput_applet<>"0000-00-00", 
                            u.dinput_applet, u.dNie))
                    ) 
                    AS SELISIH
                  FROM plc2.`plc2_upb` u 
                  JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                  WHERE u.`ldeleted` = 0  
                      AND u.`iteambusdev_id` = 22  
                      AND u.itipe_id <> 6
                      AND u.`iupb_id` IN (SELECT ad.`iupb_id` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0  
                            AND ad.`dsubmit_dok` IS NOT NULL )
                      AND u.ldeleted = 0
                      AND u.`ikategoriupb_id` = 11
                      AND 
                      IF(u.dinput_applet IS NULL AND u.dinput_applet<>"0000-00-00",u.dNie IS NOT NULL 
                        AND u.dNie <> "0000-00-00" 
                        AND u.dNie >= "'.$perode1.'" 
                        AND u.dNie <= "'.$perode2.'" , 
                        u.dinput_applet IS NOT NULL 
                        AND u.dinput_applet <> "0000-00-00" 
                        AND u.dinput_applet >= "'.$perode1.'" 
                        AND u.dinput_applet <= "'.$perode2.'" 
                      )';
  
        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategori UPB</th>  
                          <th>Tanggal Applet Dokumen / NIE</th> 
                          <th>Tanggal LAST TD</th>  
                          <th>Selisih (Hari)</th> 
                    </tr>
        ";
        $i=0;  
        $selisih = 0; 
        $upbDetail = $this->db_erp_pk->query($sqlTD)->result_array();
        foreach ($upbDetail as $ub) {
             $i++;   
             $selisih += $ub['SELISIH'];
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td> 
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dinput_applet']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['TAMPIL']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['SELISIH']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        if($selisih==0){
            $result = 0;
        }else{
            $tot = $selisih/22;
            $result = number_format($tot,2);
        } 
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori B </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                    </tr> 

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Hari)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr> 

                </table><br/><br/>";
 

        echo $result."~".$point."~".$warna."~".$html;
    }

    

    //BD - 3 END---------------------------------------------------------------------------------------------

    /* 
    ------------------------PROJECT PK BUSDEV 24 JUNI 2019-------------------------
    */

    //Supri Start

    function BD1_739_VER01_PARAMETER04($post){
         // dari parameter 5 sebelumnya

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
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqPrareg = 'SELECT aa.* FROM (
            SELECT z.*
            FROM (
                     SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tconfirm_dok_qa , u.tsubmit_prareg ,
                            ABS(datediff(la.dCreate, u.tsubmit_prareg)) as selisih,u.iteambusdev_id,Concat("2") as nilai
                     FROM plc2.plc2_upb u
                     JOIN plc3.m_modul_log_activity la on la.iKey_id=u.iupb_id
                     JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                     JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort and moa.vDept_assigned="QA"
                     JOIN hrd.employee e on e.cNip = la.cCreated
                     WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0
                         AND u.iteambusdev_id = 4 
                     #AND u.istatus = 7
                     AND u.iappdireksi = 2
                     AND u.itipe_id <> 6
                     and u.ineed_prareg=1
                     AND la.iApprove=2
                     and mo.vKode_modul="PL00018"
                     AND u.iconfirm_dok_qa = 2 AND u.tsubmit_prareg IS NOT NULL
                     AND u.tsubmit_prareg >= "'.$perode1.'"
                     AND u.tsubmit_prareg <= "'.$perode2.'"
         
                     UNION
         
                     SELECT  u.vupb_nomor, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tconfirm_dok_qa , his.dtanggal as tsubmit_prareg ,
                            ABS(datediff(la.dCreate, his.dtanggal)) as selisih,u.iteambusdev_id, Concat("1") as nilai
                     FROM plc2.plc2_upb u
                     JOIN plc3.m_modul_log_activity la on la.iKey_id=u.iupb_id
                     JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules
                     JOIN hrd.employee e on e.cNip = la.cCreated
                     JOIN plc2.tanggal_history_prareg_reg his on his.iupb_id=u.iupb_id
                     JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort and moa.vDept_assigned="QA"
                     where u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0
                         AND u.iteambusdev_id = 4 
                         #AND u.istatus = 7
                         AND u.iappdireksi = 2
                     AND u.itipe_id <> 6
                     and u.ineed_prareg=1
                     and la.iApprove=2
                     and la.lDeleted=0
                     AND u.iconfirm_dok_qa = 2
                     and mo.vKode_modul="PL00018"
                     #Check Aktivity
                            and his.id IN (
                                select na.id_pk from ( 
                                        select ta.dtanggal,ta.id as id_pk 
                                            FROM plc2.tanggal_history_prareg_reg ta 
                                            WHERE ta.ldeleted=0 
                                            AND ta.ijenis=1 
                                        group by ta.iupb_id 
                                        order by ta.id ASC                                
                                    ) as na
                                    Where na.dtanggal >= "'.$perode1.'"
                                    AND na.dtanggal <= "'.$perode2.'"
                            )
               ) as z
               ORDER BY z.nilai ASC
         ) as aa GROUP BY aa.iupb_id
                    ';

        $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
        //$html.='<pre>'.$sqPrareg.'</pre>';
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='7' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Approval QA Manager Cek Dokumen Prareg</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Team Busdev</th>
                        <th>Approval QA By</th>
                        <th>Tanggal Approval QA</th>
                        <th>Tanggal Submit Prareg</th> 
                        <th>Selisih</th> 
                    </tr>
        "; 

        $cekDouble = array();

        $i=0;
        $sumselisih = 0;
        $total_parareg = 0;
        foreach ($upbPrareg as $ub) {
            $selisih = $this->datediff($ub['tconfirm_dok_qa'],$ub['tsubmit_prareg'],$cNipNya);

            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ub['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }

             $i++;  
            //  array_push($cekDouble,$u['iupb_id']);
             $total_parareg++;
             $sumselisih += $selisih;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['cNip']."-".$ub['vName']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tconfirm_dok_qa']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tsubmit_prareg']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$selisih."</td>
                        </tr>"; 

        } 
        $html .= "</table><br /> ";

        //-------------------------------------------------------------------------------------- INI REG

        $sqReq = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(u.tconfirm_registrasi_qa) as tconfirm_registrasi_qa, u.tsubmit_reg , ABS(datediff(u.tconfirm_registrasi_qa, u.tsubmit_reg )) as selisih,u.iteambusdev_id
                    FROM plc2.plc2_upb u 
                    JOIN hrd.employee e on e.cNip = u.cnip_confirm_registrasi_qa
                    where u.`ldeleted` = 0 AND u.`iteambusdev_id` = 4 
                    AND u.itipe_id <> 6
                    and u.ineed_prareg=0
                    AND u.iconfirm_registrasi_qa = 1 AND u.tsubmit_reg IS NOT NULL
                    AND u.`tsubmit_reg` >= "'.$perode1.'"
                    AND u.`tsubmit_reg` <= "'.$perode2.'"
                    ';
        $sqReq = 'SELECT aa.* FROM (
            SELECT z.*
            FROM (
                        SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tconfirm_registrasi_qa , u.tsubmit_reg ,
                            ABS(datediff(la.dCreate, u.tsubmit_reg)) as selisih,u.iteambusdev_id,Concat("2") as nilai
                        FROM plc2.plc2_upb u
                        JOIN plc3.m_modul_log_activity la on la.iKey_id=u.iupb_id
                        JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                        JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort and moa.vDept_assigned="QA"
                        JOIN hrd.employee e on e.cNip = la.cCreated
                        WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0
                            AND u.iteambusdev_id = 4 
                            #AND u.istatus = 7
                            AND u.iappdireksi = 2
                        AND u.itipe_id <> 6
                        and u.ineed_prareg=0
                        AND la.iApprove=2
                        and mo.vKode_modul="PL00029"
                        AND u.iconfirm_registrasi_qa = 2 AND u.tsubmit_reg IS NOT NULL
                        AND u.tsubmit_reg >= "'.$perode1.'"
                        AND u.tsubmit_reg <= "'.$perode2.'"
            
                        UNION
            
                        SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tconfirm_registrasi_qa ,his.dtanggal as tsubmit_reg ,
                        ABS(datediff(la.dCreate, his.dtanggal)) as selisih,u.iteambusdev_id,Concat("1") as nilai
                        FROM plc2.plc2_upb u
                        JOIN plc3.m_modul_log_activity la on la.iKey_id=u.iupb_id
                        JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules
                        JOIN hrd.employee e on e.cNip = la.cCreated
                        JOIN plc2.tanggal_history_prareg_reg his on his.iupb_id=u.iupb_id
                        JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort and moa.vDept_assigned="QA"
                        where u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0
                            AND u.iteambusdev_id = 4 
                            #AND u.istatus = 7
                            AND u.iappdireksi = 2
                        AND u.itipe_id <> 6
                        and u.ineed_prareg=0
                        and la.iApprove=2
                        and la.lDeleted=0
                        AND u.iconfirm_registrasi_qa = 2
                        and mo.vKode_modul="PL00029"
                        #Check Aktivity
                        and his.id IN (
                            select na.id_pk from ( 
                                    select ta.dtanggal,ta.id as id_pk 
                                        FROM plc2.tanggal_history_prareg_reg ta 
                                        WHERE ta.ldeleted=0 
                                        AND ta.ijenis=2 
                                    group by ta.iupb_id 
                                    order by ta.id ASC                                
                                ) as na
                                Where na.dtanggal >= "'.$perode1.'"
                                AND na.dtanggal <= "'.$perode2.'"
                        )
                ) as z
                ORDER BY z.nilai ASC
            ) as aa GROUP BY aa.iupb_id
                    ';
        //$html.='<pre>'.$sqReq.'</pre>';
        $upbReq = $this->db_erp_pk->query($sqReq)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='7' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Approval QA Manager Cek Dokumen Registrasi</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Team Busdev</th>
                        <th>Approval QA By</th>
                        <th>Tanggal Approval QA</th>
                        <th>Tanggal Submit Registrasi</th> 
                        <th>Selisih</th> 
                    </tr>
        "; 
        $i=0;
        $total_req=0;
        $kurangTotal = 0;
        foreach ($upbReq as $ur) {
            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ur['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }

             $i++; 
             $total_req++;
             if (in_array($ur['iupb_id'], $cekDouble)) {
                $kurangTotal++;
             }

             $selisih = $this->datediff($ur['tconfirm_registrasi_qa'],$ur['tsubmit_reg'],$cNipNya);

             $sumselisih += $selisih;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['cNip']."-".$ur['vName']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['tconfirm_registrasi_qa']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ur['tsubmit_reg']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$selisih."</td>
                        </tr>"; 

        } 
        $html .= "</table><br /> ";

        $totalUpb  = $total_req + $total_parareg; 
        $jumlahUpb = $totalUpb - $kurangTotal;
        if($sumselisih==0){
          $tot = 0;
        }else{
          $tot = $sumselisih / $totalUpb;
          $tot = $tot/5;
        }
        $result     = number_format($tot,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total UPB Prareg & Reg</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalUpb." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih (Hari)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format($sumselisih)." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata- Rata (Minggu)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Minggu</td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }


    function BD2_739_VER01_PARAMETER04($post){
        // dari parameter 5 sebelumnya

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
               <table width='750px'>
                   <tr>
                       <td><b>Point Untuk Aspek :</b></td>
                       <td>".$vAspekName."</td>

                   </tr>
               </table>";

       $sqPrareg = 'SELECT aa.* FROM (
           SELECT z.*
           FROM (
                    SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tconfirm_dok_qa , u.tsubmit_prareg ,
                           ABS(datediff(la.dCreate, u.tsubmit_prareg)) as selisih,u.iteambusdev_id,Concat("2") as nilai
                    FROM plc2.plc2_upb u
                    JOIN plc3.m_modul_log_activity la on la.iKey_id=u.iupb_id
                    JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                    JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort and moa.vDept_assigned="QA"
                    JOIN hrd.employee e on e.cNip = la.cCreated
                    WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0
                        AND u.iteambusdev_id = 22 
                    #AND u.istatus = 7
                    AND u.iappdireksi = 2
                    AND u.itipe_id <> 6
                    and u.ineed_prareg=1
                    AND la.iApprove=2
                    and mo.vKode_modul="PL00018"
                    AND u.iconfirm_dok_qa = 2 AND u.tsubmit_prareg IS NOT NULL
                    AND u.tsubmit_prareg >= "'.$perode1.'"
                    AND u.tsubmit_prareg <= "'.$perode2.'"
        
                    UNION
        
                    SELECT  u.vupb_nomor, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tconfirm_dok_qa , his.dtanggal as tsubmit_prareg ,
                           ABS(datediff(la.dCreate, his.dtanggal)) as selisih,u.iteambusdev_id, Concat("1") as nilai
                    FROM plc2.plc2_upb u
                    JOIN plc3.m_modul_log_activity la on la.iKey_id=u.iupb_id
                    JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules
                    JOIN hrd.employee e on e.cNip = la.cCreated
                    JOIN plc2.tanggal_history_prareg_reg his on his.iupb_id=u.iupb_id
                    JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort and moa.vDept_assigned="QA"
                    where u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0
                        AND u.iteambusdev_id = 22 
                        #AND u.istatus = 7
                        AND u.iappdireksi = 2
                    AND u.itipe_id <> 6
                    and u.ineed_prareg=1
                    and la.iApprove=2
                    and la.lDeleted=0
                    AND u.iconfirm_dok_qa = 2
                    and mo.vKode_modul="PL00018"
                    #Check Aktivity
                        and his.id IN (
                            select na.id_pk from ( 
                                    select ta.dtanggal,ta.id as id_pk 
                                        FROM plc2.tanggal_history_prareg_reg ta 
                                        WHERE ta.ldeleted=0 
                                        AND ta.ijenis=1 
                                    group by ta.iupb_id 
                                    order by ta.id ASC                                
                                ) as na
                                Where na.dtanggal >= "'.$perode1.'"
                                AND na.dtanggal <= "'.$perode2.'"
                        )
              ) as z
              ORDER BY z.nilai ASC
        ) as aa GROUP BY aa.iupb_id
                   ';

       $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
       //$html.='<pre>'.$sqPrareg.'</pre>';
       $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                   <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                       <th colspan='7' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Approval QA Manager Cek Dokumen Prareg</th> 
                   </tr>
                   <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                       <th>No</th>
                       <th>No UPB</th>
                       <th>Nama UPB</th>
                       <th>Team Busdev</th>
                       <th>Approval QA By</th>
                       <th>Tanggal Approval QA</th>
                       <th>Tanggal Submit Prareg</th> 
                       <th>Selisih</th> 
                   </tr>
       "; 

       $cekDouble = array();

       $i=0;
       $sumselisih = 0;
       $total_parareg = 0;
       foreach ($upbPrareg as $ub) {
           $selisih = $this->datediff($ub['tconfirm_dok_qa'],$ub['tsubmit_prareg'],$cNipNya);

           $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ub['iteambusdev_id']."'";
           $kat = $this->db_erp_pk->query($sqlk)->row_array();
           if(empty($kat['vteam'])){
               $k = '-';
           }else{
               $k = $kat['vteam'];
           }

            $i++;  
           //  array_push($cekDouble,$u['iupb_id']);
            $total_parareg++;
            $sumselisih += $selisih;
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                           <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                           <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                               ".$ub['vupb_nomor']."</td>
                           <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                               ".$ub['vupb_nama']."</td>
                           <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                               ".$k."</td>
                           <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                               ".$ub['cNip']."-".$ub['vName']."</td>
                           <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                               ".$ub['tconfirm_dok_qa']."</td>
                           <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                               ".$ub['tsubmit_prareg']."</td>
                           <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                               ".$selisih."</td>
                       </tr>"; 

       } 
       $html .= "</table><br /> ";

       //-------------------------------------------------------------------------------------- INI REG

       $sqReq = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(u.tconfirm_registrasi_qa) as tconfirm_registrasi_qa, u.tsubmit_reg , ABS(datediff(u.tconfirm_registrasi_qa, u.tsubmit_reg )) as selisih,u.iteambusdev_id
                   FROM plc2.plc2_upb u 
                   JOIN hrd.employee e on e.cNip = u.cnip_confirm_registrasi_qa
                   where u.`ldeleted` = 0 AND u.`iteambusdev_id` = 22 
                   AND u.itipe_id <> 6
                   and u.ineed_prareg=0
                   AND u.iconfirm_registrasi_qa = 1 AND u.tsubmit_reg IS NOT NULL
                   AND u.`tsubmit_reg` >= "'.$perode1.'"
                   AND u.`tsubmit_reg` <= "'.$perode2.'"
                   ';
       $sqReq = 'SELECT aa.* FROM (
           SELECT z.*
           FROM (
                       SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tconfirm_registrasi_qa , u.tsubmit_reg ,
                           ABS(datediff(la.dCreate, u.tsubmit_reg)) as selisih,u.iteambusdev_id,Concat("2") as nilai
                       FROM plc2.plc2_upb u
                       JOIN plc3.m_modul_log_activity la on la.iKey_id=u.iupb_id
                       JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                       JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort and moa.vDept_assigned="QA"
                       JOIN hrd.employee e on e.cNip = la.cCreated
                       WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0
                           AND u.iteambusdev_id = 22 
                           #AND u.istatus = 7
                           AND u.iappdireksi = 2
                       AND u.itipe_id <> 6
                       and u.ineed_prareg=0
                       AND la.iApprove=2
                       and mo.vKode_modul="PL00029"
                       AND u.iconfirm_registrasi_qa = 2 AND u.tsubmit_reg IS NOT NULL
                       AND u.tsubmit_reg >= "'.$perode1.'"
                       AND u.tsubmit_reg <= "'.$perode2.'"
           
                       UNION
           
                       SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tconfirm_registrasi_qa ,his.dtanggal as tsubmit_reg ,
                       ABS(datediff(la.dCreate, his.dtanggal)) as selisih,u.iteambusdev_id,Concat("1") as nilai
                       FROM plc2.plc2_upb u
                       JOIN plc3.m_modul_log_activity la on la.iKey_id=u.iupb_id
                       JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules
                       JOIN hrd.employee e on e.cNip = la.cCreated
                       JOIN plc2.tanggal_history_prareg_reg his on his.iupb_id=u.iupb_id
                       JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort and moa.vDept_assigned="QA"
                       where u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0
                           AND u.iteambusdev_id = 22 
                           #AND u.istatus = 7
                           AND u.iappdireksi = 2
                       AND u.itipe_id <> 6
                       and u.ineed_prareg=0
                       and la.iApprove=2
                       and la.lDeleted=0
                       AND u.iconfirm_registrasi_qa = 2
                       and mo.vKode_modul="PL00029"
                       #Check Aktivity
                        and his.id IN (
                            select na.id_pk from ( 
                                    select ta.dtanggal,ta.id as id_pk 
                                        FROM plc2.tanggal_history_prareg_reg ta 
                                        WHERE ta.ldeleted=0 
                                        AND ta.ijenis=2 
                                    group by ta.iupb_id 
                                    order by ta.id ASC                                
                                ) as na
                                Where na.dtanggal >= "'.$perode1.'"
                                AND na.dtanggal <= "'.$perode2.'"
                        )
               ) as z
               ORDER BY z.nilai ASC
           ) as aa GROUP BY aa.iupb_id
                   ';
       //$html.='<pre>'.$sqReq.'</pre>';
       $upbReq = $this->db_erp_pk->query($sqReq)->result_array();  
       $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                   <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                       <th colspan='7' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Approval QA Manager Cek Dokumen Registrasi</th> 
                   </tr>
                   <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                       <th>No</th>
                       <th>No UPB</th>
                       <th>Nama UPB</th>
                       <th>Team Busdev</th>
                       <th>Approval QA By</th>
                       <th>Tanggal Approval QA</th>
                       <th>Tanggal Submit Registrasi</th> 
                       <th>Selisih</th> 
                   </tr>
       "; 
       $i=0;
       $total_req=0;
       $kurangTotal = 0;
       foreach ($upbReq as $ur) {
           $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ur['iteambusdev_id']."'";
           $kat = $this->db_erp_pk->query($sqlk)->row_array();
           if(empty($kat['vteam'])){
               $k = '-';
           }else{
               $k = $kat['vteam'];
           }

            $i++; 
            $total_req++;
            if (in_array($ur['iupb_id'], $cekDouble)) {
               $kurangTotal++;
            }

            $selisih = $this->datediff($ur['tconfirm_registrasi_qa'],$ur['tsubmit_reg'],$cNipNya);

            $sumselisih += $selisih;
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                           <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                           <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                               ".$ur['vupb_nomor']."</td>
                           <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                               ".$ur['vupb_nama']."</td>
                           <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                               ".$k."</td>
                           <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                               ".$ur['cNip']."-".$ur['vName']."</td>
                           <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                               ".$ur['tconfirm_registrasi_qa']."</td>
                           <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                               ".$ur['tsubmit_reg']."</td>
                           <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                               ".$selisih."</td>
                       </tr>"; 

       } 
       $html .= "</table><br /> ";

       $totalUpb  = $total_req + $total_parareg; 
       $jumlahUpb = $totalUpb - $kurangTotal;
       if($sumselisih==0){
         $tot = 0;
       }else{
         $tot = $sumselisih / $totalUpb;
         $tot = $tot/5;
       }
       $result     = number_format($tot,2);
       $getpoint   = $this->getPoint($result,$iAspekId);
       $x_getpoint = explode("~", $getpoint);
       $point      = $x_getpoint['0'];
       $warna      = $x_getpoint['1'];


       $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                   <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                       <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                   </tr>
                   <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                       <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total UPB Prareg & Reg</td>
                       <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalUpb." </td>
                   </tr>

                   <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                       <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih (Hari)</td>
                       <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format($sumselisih)." </td>
                   </tr>

                   <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                       <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata- Rata (Minggu)</td>
                       <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Minggu</td>
                   </tr>

               </table><br/><br/>";


       echo $result."~".$point."~".$warna."~".$html;
   }


    function BD1_739_VER01_PARAMETER05($post){
         // dari parameter 5 sebelumnya

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
                 <table width='750px'>
                     <tr>
                         <td><b>Point Untuk Aspek :</b></td>
                         <td>".$vAspekName."</td>
 
                     </tr>
                 </table>";
 
         $sqPrareg = 'SELECT aa.* FROM (
                        SELECT z.*
                        FROM (
                            SELECT u.vupb_nomor,u.vgenerik, u.iupb_id, u.vupb_nama, e.cNip, e.vName,if(u.ineed_prareg=1,"YA", "TIDAK") as needPrareg, date(la.dCreate) as tglSettingPrio , if(u.ineed_prareg=1,u.tsubmit_prareg, u.tsubmit_reg) as tanggalSubmit,
                                ABS(datediff(la.dCreate, if(u.ineed_prareg=1,u.tsubmit_prareg, u.tsubmit_reg))) as selisih,u.iteambusdev_id,Concat("2") as nilai
                            FROM plc2.plc2_upb u
                            JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                            JOIN plc3.m_modul_log_activity la on la.iKey_id=det.iprioritas_id
                            JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                            JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                            JOIN hrd.employee e on e.cNip = la.cCreated
                            WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0
                            AND u.iteambusdev_id = 4 
                            #AND u.istatus = 7
                            AND u.iappdireksi = 2
                            AND u.itipe_id <> 6
                            AND la.iApprove=2
                            and mo.vKode_modul="PL00002"
                            and moa.vDept_assigned="DR"
                            and moa.iType=3
                            and moa.iM_activity=4
                            AND (
                            case when u.ineed_prareg=1 then
                                u.tsubmit_prareg is not null
                                AND u.tsubmit_prareg >= "'.$perode1.'"
                                AND u.tsubmit_prareg <= "'.$perode2.'"
                            ELSE
                                u.tsubmit_reg is not null
                                AND u.tsubmit_reg >= "'.$perode1.'"
                                AND u.tsubmit_reg <= "'.$perode2.'"
                            END
                            )

                            UNION

                            SELECT u.vupb_nomor,u.vgenerik, u.iupb_id, u.vupb_nama, e.cNip, e.vName,if(u.ineed_prareg=1,"YA", "TIDAK") as needPrareg, date(la.dCreate) as tglSettingPrio , his.dtanggal as tanggalSubmit,
                                ABS(datediff(la.dCreate, his.dtanggal)) as selisih,u.iteambusdev_id,Concat("2") as nilai
                            FROM plc2.plc2_upb u
                            JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                            JOIN plc3.m_modul_log_activity la on la.iKey_id=det.iprioritas_id
                            JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules
                            JOIN hrd.employee e on e.cNip = la.cCreated
                            JOIN plc2.tanggal_history_prareg_reg his on his.iupb_id=u.iupb_id
                            JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                            where u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0
                            AND u.iteambusdev_id = 4 
                            #AND u.istatus = 7
                            AND u.iappdireksi = 2
                            AND u.itipe_id <> 6
                            AND la.iApprove=2
                            and mo.vKode_modul="PL00002"
                            and moa.vDept_assigned="DR"
                            and moa.iType=3
                            and moa.iM_activity=4
                            and his.ldeleted=0#Check Aktivity
                            and his.id IN (
                                select na.id_pk from ( 
                                        select ta.dtanggal,ta.id as id_pk 
                                            FROM plc2.tanggal_history_prareg_reg ta 
                                            join plc2.plc2_upb up on up.iupb_id=ta.iupb_id
                                            WHERE ta.ldeleted=0 
                                            AND (case when up.ineed_prareg=1 then
                                                ta.ijenis=1
                                            ELSE
                                                ta.ijenis=2
                                            END) 
                                        group by ta.iupb_id 
                                        order by ta.id ASC                                
                                    ) as na
                                    Where na.dtanggal >= "'.$perode1.'"
                                    AND na.dtanggal <= "'.$perode2.'"
                            )
                        ) as z
                        ORDER BY z.nilai ASC
                    ) as aa GROUP BY aa.iupb_id
                     ';
            
                                
         $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
         $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                     <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                         <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Submit Prareg / Reg</th> 
                     </tr>
                     <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                         <th>No</th>
                         <th>No UPB</th>
                         <th>Nama Generik</th> 
                         <th>Selisih</th> 
                         <th>Melalui Prareg</th> 
                         <th>Tgl Prareg / Reg</th>
                         <th>Tgl Setting Prioritas</th> 
                     </tr>
         "; 
 
         $cekDouble = array();
 
         $i=0;
         $total_parareg = array();
         foreach ($upbPrareg as $ub) {
            $selisih = $this->getDurasiBulan($ub['tglSettingPrio'],$ub['tanggalSubmit']);
              $i++; 
              $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                             <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                             <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                                 ".$ub['vupb_nomor']."</td>
                             <td style='width:25%;text-align: left;border: 1px solid #dddddd;'>
                                 ".$ub['vgenerik']."</td>
                             <td style='width:5%;text-align: right;border: 1px solid #dddddd;'>
                                 ".$selisih."</td> 
                             <td style='width:5%;text-align: center;border: 1px solid #dddddd;'>
                                 ".$ub['needPrareg']."</td>
                             <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                 ".$ub['tanggalSubmit']."</td>
                             <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                 ".$ub['tglSettingPrio']."</td>
                         </tr>"; 
            $total_parareg[]=$selisih;
 
         } 
         $html .= "</table><br /> ";
 
         //-------------------------------------------------------------------------------------- INI REG
 
         $sqReq = 'SELECT aa.* FROM (
            SELECT z.*
            FROM (
                SELECT u.vupb_nomor,u.vgenerik, u.iupb_id, u.vupb_nama, e.cNip, e.vName,if(u.ineed_prareg=1,"YA", "TIDAK") as needPrareg, date(la.dCreate) as tglSettingPrio , concat("'.$perode2.'") as tanggalSubmit,
                    ABS(datediff(la.dCreate, "'.$perode2.'")) as selisih,u.iteambusdev_id,Concat("2") as nilai
                FROM plc2.plc2_upb u
                JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                JOIN plc3.m_modul_log_activity la on la.iKey_id=det.iprioritas_id
                JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                JOIN hrd.employee e on e.cNip = la.cCreated
                WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0
                AND u.iteambusdev_id = 4 
                #AND u.istatus = 7
                AND u.iappdireksi = 2
                AND u.itipe_id <> 6
                AND la.iApprove=2
                and mo.vKode_modul="PL00002"
                and moa.vDept_assigned="DR"
                and moa.iType=3
                and moa.iM_activity=4
                AND (
                case when u.ineed_prareg=1 then
                    u.tsubmit_prareg is NULL
                ELSE
                    u.tsubmit_reg is null
                END
                )
            ) as z
            ORDER BY z.nilai ASC
        ) as aa GROUP BY aa.iupb_id
         '; 
         $upbReq = $this->db_erp_pk->query($sqReq)->result_array();  
         $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >UPB Belum Tanggal Prareg / Reg</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama Generik</th> 
                        <th>Selisih</th> 
                        <th>Melalui Prareg</th> 
                        <th>Tgl Prareg / Reg</th>
                        <th>Tgl Akhir Semester</th> 
                    </tr>
         "; 
         $i=0;
         foreach ($upbReq as $ur) {
            $selisih = $this->getDurasiBulan($ur['tglSettingPrio'],$ur['tanggalSubmit']);
            $i++; 
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                           <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                           <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                               ".$ur['vupb_nomor']."</td>
                           <td style='width:25%;text-align: left;border: 1px solid #dddddd;'>
                               ".$ur['vgenerik']."</td>
                           <td style='width:5%;text-align: right;border: 1px solid #dddddd;'>
                               ".$selisih."</td> 
                           <td style='width:5%;text-align: center;border: 1px solid #dddddd;'>
                               ".$ur['needPrareg']."</td>
                           <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                               ".$ur['tanggalSubmit']."</td>
                           <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                               ".$ur['tglSettingPrio']."</td>
                       </tr>"; 
            $total_parareg[]=$selisih;
 
         } 
         $html .= "</table><br /> ";
 
         $total=array_sum($total_parareg);
         $nn=$total/$i;
         $result     = number_format($nn);
         $getpoint   = $this->getPoint($result,$iAspekId);
         $x_getpoint = explode("~", $getpoint);
         $point      = $x_getpoint['0'];
         $warna      = $x_getpoint['1'];
 
 
         $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                     <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                     </tr>
                     <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                         <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jangka Waktu Proses Pengembangan UPB</td>
                         <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$total." Bulan</td>
                     </tr>
                     <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                         <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>UPB Belum Tanggal Prareg / Reg</td>
                         <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i."</td>
                     </tr>
                     <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                         <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - Rata Jangka Waktu Proses Pengembangan UPB</td>
                         <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan</td>
                     </tr>
                     
                 </table><br/><br/>";
 
 
         echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_739_VER01_PARAMETER05($post){
        // dari parameter 5 sebelumnya

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
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqPrareg = 'SELECT aa.* FROM (
                       SELECT z.*
                       FROM (
                           SELECT u.vupb_nomor,u.vgenerik, u.iupb_id, u.vupb_nama, e.cNip, e.vName,if(u.ineed_prareg=1,"YA", "TIDAK") as needPrareg, date(la.dCreate) as tglSettingPrio , if(u.ineed_prareg=1,u.tsubmit_prareg, u.tsubmit_reg) as tanggalSubmit,
                               ABS(datediff(la.dCreate, if(u.ineed_prareg=1,u.tsubmit_prareg, u.tsubmit_reg))) as selisih,u.iteambusdev_id,Concat("2") as nilai
                           FROM plc2.plc2_upb u
                           JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                           JOIN plc3.m_modul_log_activity la on la.iKey_id=det.iprioritas_id
                           JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                           JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                           JOIN hrd.employee e on e.cNip = la.cCreated
                           WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0
                           AND u.iteambusdev_id = 22 
                           #AND u.istatus = 7
                           AND u.iappdireksi = 2
                           AND u.itipe_id <> 6
                           AND la.iApprove=2
                           and mo.vKode_modul="PL00002"
                           and moa.vDept_assigned="DR"
                           and moa.iType=3
                           and moa.iM_activity=4
                           AND (
                           case when u.ineed_prareg=1 then
                               u.tsubmit_prareg is not null
                               AND u.tsubmit_prareg >= "'.$perode1.'"
                               AND u.tsubmit_prareg <= "'.$perode2.'"
                           ELSE
                               u.tsubmit_reg is not null
                               AND u.tsubmit_reg >= "'.$perode1.'"
                               AND u.tsubmit_reg <= "'.$perode2.'"
                           END
                           )

                           UNION

                           SELECT u.vupb_nomor,u.vgenerik, u.iupb_id, u.vupb_nama, e.cNip, e.vName,if(u.ineed_prareg=1,"YA", "TIDAK") as needPrareg, date(la.dCreate) as tglSettingPrio , his.dtanggal as tanggalSubmit,
                               ABS(datediff(la.dCreate, his.dtanggal)) as selisih,u.iteambusdev_id,Concat("2") as nilai
                           FROM plc2.plc2_upb u
                           JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                           JOIN plc3.m_modul_log_activity la on la.iKey_id=det.iprioritas_id
                           JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules
                           JOIN hrd.employee e on e.cNip = la.cCreated
                           JOIN plc2.tanggal_history_prareg_reg his on his.iupb_id=u.iupb_id
                           JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                           where u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0
                           AND u.iteambusdev_id = 22 
                           #AND u.istatus = 7
                           AND u.iappdireksi = 2
                           AND u.itipe_id <> 6
                           AND la.iApprove=2
                           and mo.vKode_modul="PL00002"
                           and moa.vDept_assigned="DR"
                           and moa.iType=3
                           and moa.iM_activity=4
                           and his.ldeleted=0
                           #Check Aktivity
                           and his.id IN (
                            select na.id_pk from ( 
                                    select ta.dtanggal,ta.id as id_pk 
                                        FROM plc2.tanggal_history_prareg_reg ta 
                                        join plc2.plc2_upb up on up.iupb_id=ta.iupb_id
                                        WHERE ta.ldeleted=0 
                                        AND (case when up.ineed_prareg=1 then
                                            ta.ijenis=1
                                        ELSE
                                            ta.ijenis=2
                                        END) 
                                    group by ta.iupb_id 
                                    order by ta.id ASC                                
                                ) as na
                                Where na.dtanggal >= "'.$perode1.'"
                                AND na.dtanggal <= "'.$perode2.'"
                            )
                       ) as z
                       ORDER BY z.nilai ASC
                   ) as aa GROUP BY aa.iupb_id
                    ';
           
                               
        $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Submit Prareg / Reg</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama Generik</th> 
                        <th>Selisih</th> 
                        <th>Melalui Prareg</th> 
                        <th>Tgl Prareg / Reg</th>
                        <th>Tgl Setting Prioritas</th> 
                    </tr>
        "; 

        $cekDouble = array();

        $i=0;
        $total_parareg = array();
        foreach ($upbPrareg as $ub) {
           $selisih = $this->getDurasiBulan($ub['tglSettingPrio'],$ub['tanggalSubmit']);
             $i++; 
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:25%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vgenerik']."</td>
                            <td style='width:5%;text-align: right;border: 1px solid #dddddd;'>
                                ".$selisih."</td> 
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;'>
                                ".$ub['needPrareg']."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                ".$ub['tanggalSubmit']."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                ".$ub['tglSettingPrio']."</td>
                        </tr>"; 
           $total_parareg[]=$selisih;

        } 
        $html .= "</table><br /> ";

        //-------------------------------------------------------------------------------------- INI REG

        $sqReq = 'SELECT aa.* FROM (
           SELECT z.*
           FROM (
               SELECT u.vupb_nomor,u.vgenerik, u.iupb_id, u.vupb_nama, e.cNip, e.vName,if(u.ineed_prareg=1,"YA", "TIDAK") as needPrareg, date(la.dCreate) as tglSettingPrio , concat("'.$perode2.'") as tanggalSubmit,
                   ABS(datediff(la.dCreate, "'.$perode2.'")) as selisih,u.iteambusdev_id,Concat("2") as nilai
               FROM plc2.plc2_upb u
               JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
               JOIN plc3.m_modul_log_activity la on la.iKey_id=det.iprioritas_id
               JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
               JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
               JOIN hrd.employee e on e.cNip = la.cCreated
               WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0
               AND u.iteambusdev_id = 22 
               #AND u.istatus = 7
               AND u.iappdireksi = 2
               AND u.itipe_id <> 6
               AND la.iApprove=2
               and mo.vKode_modul="PL00002"
               and moa.vDept_assigned="DR"
               and moa.iType=3
               and moa.iM_activity=4
               AND (
               case when u.ineed_prareg=1 then
                   u.tsubmit_prareg is NULL
               ELSE
                   u.tsubmit_reg is null
               END
               )
           ) as z
           ORDER BY z.nilai ASC
       ) as aa GROUP BY aa.iupb_id
        '; 
        $upbReq = $this->db_erp_pk->query($sqReq)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                   <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                       <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >UPB Belum Tanggal Prareg / Reg</th> 
                   </tr>
                   <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                       <th>No</th>
                       <th>No UPB</th>
                       <th>Nama Generik</th> 
                       <th>Selisih</th> 
                       <th>Melalui Prareg</th> 
                       <th>Tgl Prareg / Reg</th>
                       <th>Tgl Akhir Semester</th> 
                   </tr>
        "; 
        $i=0;
        foreach ($upbReq as $ur) {
           $selisih = $this->getDurasiBulan($ur['tglSettingPrio'],$ur['tanggalSubmit']);
           $i++; 
           $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                          <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                          <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                              ".$ur['vupb_nomor']."</td>
                          <td style='width:25%;text-align: left;border: 1px solid #dddddd;'>
                              ".$ur['vgenerik']."</td>
                          <td style='width:5%;text-align: right;border: 1px solid #dddddd;'>
                              ".$selisih."</td> 
                          <td style='width:5%;text-align: center;border: 1px solid #dddddd;'>
                              ".$ur['needPrareg']."</td>
                          <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                              ".$ur['tanggalSubmit']."</td>
                          <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                              ".$ur['tglSettingPrio']."</td>
                      </tr>"; 
           $total_parareg[]=$selisih;

        } 
        $html .= "</table><br /> ";

        $total=array_sum($total_parareg);
        $nn=$total/$i;
        $result     = number_format($nn);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jangka Waktu Proses Pengembangan UPB</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$total." Bulan</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>UPB Belum Tanggal Prareg / Reg</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i."</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - Rata Jangka Waktu Proses Pengembangan UPB</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan</td>
                    </tr>
                    
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
   }

    function BD1_739_VER01_PARAMETER10($post){

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
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqPrareg = 'SELECT aa.* FROM (
                            SELECT z.*
                            FROM (
                                SELECT CONCAT("NIE") as jns,u.vupb_nomor,u.vgenerik, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tglSettingPrio , it.d_from as tanggalReg,u.iteambusdev_id
                                FROM plc2.plc2_upb u
                                JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                                JOIN plc3.m_modul_log_activity la on la.iKey_id=det.iprioritas_id
                                JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                                JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                                JOIN hrd.employee e on e.cNip = la.cCreated
                                JOIN plc2.plc2_upb_formula fo on fo.iupb_id = u.iupb_id
                                JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                                JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                                WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0 and fo.ldeleted=0 and mb.ldeleted=0
                                AND u.iteambusdev_id = 4 
                                #AND u.istatus = 7
                                AND u.iappdireksi = 2
                                AND u.ikategoriupb_id=10 # Kategori A
                                AND u.itipe_id <> 6
                                AND la.iApprove=2
                                and mo.vKode_modul="PL00002"
                                and moa.vDept_assigned="DR"
                                and moa.iType=3
                                and moa.iM_activity=4
                                AND u.iHasil_registrasi=0
                                and it.id IN ( 
                                    SELECT za.id FROM (
                                            SELECT fo.iupb_id,it.d_from,it.id FROM  plc2.plc2_upb_formula fo
                                            JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                                            JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                                            WHERE fo.ldeleted=0 and mb.ldeleted=0 
                                            GROUP BY it.c_iteno ORDER BY it.id ASC
                                            ) as za
                                            WHERE
                                            za.d_from >= "'.$perode1.'" 
                                            AND za.d_from <= "'.$perode2.'"
                                        )
                                
                                UNION
                                
                                    SELECT CONCAT("APPLET") as jns,u.vupb_nomor,u.vgenerik, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tglSettingPrio , u.dinput_applet as tanggalReg,u.iteambusdev_id
                                FROM plc2.plc2_upb u
                                JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                                JOIN plc3.m_modul_log_activity la on la.iKey_id=det.iprioritas_id
                                JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                                JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                                JOIN hrd.employee e on e.cNip = la.cCreated
                                WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0 
                                AND u.iteambusdev_id = 4 
                                #AND u.istatus = 7
                                AND u.iappdireksi = 2
                                AND u.ikategoriupb_id=10 # Kategori A
                                AND u.itipe_id <> 6
                                AND la.iApprove=2
                                and mo.vKode_modul="PL00002"
                                and moa.vDept_assigned="DR"
                                and moa.iType=3
                                and moa.iM_activity=4
                                AND u.iHasil_registrasi=1
                                AND u.dinput_applet >= "'.$perode1.'"
                                AND u.dinput_applet <= "'.$perode2.'"
                                
                            ) as z
                            ORDER BY z.iupb_id ASC
                        ) as aa GROUP BY aa.iupb_id
                    ';                      
        $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >A. UPB Kategori A yang sudah disetting prioritas dan memiliki tgl Applet / NIE</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama Generik</th> 
                        <th>Tgl Setting Prioritas</th> 
                        <th>Hasil Registrasi</th> 
                        <th>Tgl Applet/NIE</th>
                    </tr>
        "; 

        $cekDouble = array();

        $i=0;
        $total_parareg = array();
        $nilaiA=0;
        foreach ($upbPrareg as $ub) {
             $i++; 
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:25%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vgenerik']."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                ".$ub['tglSettingPrio']."</td>
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                ".$ub['jns']."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                ".$ub['tanggalReg']."</td>
                        </tr>"; 
                        $nilaiA++;

        } 
        $html .= "</table><br /> ";

        //-------------------------------------------------------------------------------------- INI REG

        $sqReq = 'SELECT aa.* FROM (
            SELECT z.*
            FROM (
                SELECT u.vupb_nomor,u.vgenerik, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tglSettingPrio,u.iteambusdev_id
                FROM plc2.plc2_upb u
                JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                JOIN plc3.m_modul_log_activity la on la.iKey_id=det.iprioritas_id
                JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                JOIN hrd.employee e on e.cNip = la.cCreated
                WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0 
                AND u.iteambusdev_id = 4 
                #AND u.istatus = 7
                AND u.iappdireksi = 2
                AND u.ikategoriupb_id=10 # Kategori A
                AND u.itipe_id <> 6
                AND la.iApprove=2
                and mo.vKode_modul="PL00002"
                and moa.vDept_assigned="DR"
                and moa.iType=3
                and moa.iM_activity=4
                AND la.dCreate >= "'.$perode1.'"
                AND la.dCreate <= "'.$perode2.'"
                
            ) as z
            ORDER BY z.iupb_id ASC
        ) as aa GROUP BY aa.iupb_id
        '; 
        $upbReq = $this->db_erp_pk->query($sqReq)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                   <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                       <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >B. UPB Kategori A yang sudah disetting prioritas</th> 
                   </tr>
                   <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama Generik</th> 
                        <th>Tgl Setting Prioritas</th> 
                    </tr>
        "; 
        $i=0;
        $nilaiB=0;
        foreach ($upbReq as $ur) {
           $i++; 
           $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                        <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ur['vupb_nomor']."</td>
                        <td style='width:25%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ur['vgenerik']."</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            ".$ur['tglSettingPrio']."</td>
                    </tr>"; 
                    $nilaiB++;

        } 
        $html .= "</table><br /> ";

        $total=($nilaiA/$nilaiB)*100;
        $result     = number_format($total,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah A</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$nilaiA." </td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah B</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$nilaiB." </td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Hasil (A/B)*100%</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." %</td>
                    </tr>
                    
                    
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
   }

   function BD2_739_VER01_PARAMETER10($post){

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
            <table width='750px'>
                <tr>
                    <td><b>Point Untuk Aspek :</b></td>
                    <td>".$vAspekName."</td>

                </tr>
            </table>";

    $sqPrareg = 'SELECT aa.* FROM (
                        SELECT z.*
                        FROM (
                            SELECT CONCAT("NIE") as jns,u.vupb_nomor,u.vgenerik, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tglSettingPrio , it.d_from as tanggalReg,u.iteambusdev_id
                            FROM plc2.plc2_upb u
                            JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                            JOIN plc3.m_modul_log_activity la on la.iKey_id=det.iprioritas_id
                            JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                            JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                            JOIN hrd.employee e on e.cNip = la.cCreated
                            JOIN plc2.plc2_upb_formula fo on fo.iupb_id = u.iupb_id
                            JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                            JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                            WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0 and fo.ldeleted=0 and mb.ldeleted=0
                            AND u.iteambusdev_id = 22 
                            #AND u.istatus = 7
                            AND u.iappdireksi = 2
                            AND u.ikategoriupb_id=10 # Kategori A
                            AND u.itipe_id <> 6
                            AND la.iApprove=2
                            and mo.vKode_modul="PL00002"
                            and moa.vDept_assigned="DR"
                            and moa.iType=3
                            and moa.iM_activity=4
                            AND u.iHasil_registrasi=0
                            and it.id IN ( 
                                    SELECT za.id FROM (
                                            SELECT fo.iupb_id,it.d_from,it.id FROM  plc2.plc2_upb_formula fo
                                            JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                                            JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                                            WHERE fo.ldeleted=0 and mb.ldeleted=0 
                                            GROUP BY it.c_iteno ORDER BY it.id ASC
                                            ) as za
                                            WHERE
                                            za.d_from >= "'.$perode1.'" 
                                            AND za.d_from <= "'.$perode2.'"
                                        )
                            
                            UNION
                            
                                SELECT CONCAT("APPLET") as jns,u.vupb_nomor,u.vgenerik, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tglSettingPrio , u.dinput_applet as tanggalReg,u.iteambusdev_id
                            FROM plc2.plc2_upb u
                            JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                            JOIN plc3.m_modul_log_activity la on la.iKey_id=det.iprioritas_id
                            JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                            JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                            JOIN hrd.employee e on e.cNip = la.cCreated
                            WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0 
                            AND u.iteambusdev_id = 22 
                            #AND u.istatus = 7
                            AND u.iappdireksi = 2
                            AND u.ikategoriupb_id=10 # Kategori A
                            AND u.itipe_id <> 6
                            AND la.iApprove=2
                            and mo.vKode_modul="PL00002"
                            and moa.vDept_assigned="DR"
                            and moa.iType=3
                            and moa.iM_activity=4
                            AND u.iHasil_registrasi=1
                            AND u.dinput_applet >= "'.$perode1.'"
                            AND u.dinput_applet <= "'.$perode2.'"
                            
                        ) as z
                        ORDER BY z.iupb_id ASC
                    ) as aa GROUP BY aa.iupb_id
                ';                      
    $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
    $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                    <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >A. UPB Kategori A yang sudah disetting prioritas dan memiliki tgl Applet / NIE</th> 
                </tr>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <th>No</th>
                    <th>No UPB</th>
                    <th>Nama Generik</th> 
                    <th>Tgl Setting Prioritas</th> 
                    <th>Hasil Registrasi</th> 
                    <th>Tgl Applet/NIE</th>
                </tr>
    "; 

    $cekDouble = array();

    $i=0;
    $total_parareg = array();
    $nilaiA=0;
    foreach ($upbPrareg as $ub) {
         $i++; 
         $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                        <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:25%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vgenerik']."</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            ".$ub['tglSettingPrio']."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            ".$ub['jns']."</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            ".$ub['tanggalReg']."</td>
                    </tr>"; 
                    $nilaiA++;

    } 
    $html .= "</table><br /> ";

    //-------------------------------------------------------------------------------------- INI REG

    $sqReq = 'SELECT aa.* FROM (
        SELECT z.*
        FROM (
            SELECT u.vupb_nomor,u.vgenerik, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tglSettingPrio,u.iteambusdev_id
            FROM plc2.plc2_upb u
            JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
            JOIN plc3.m_modul_log_activity la on la.iKey_id=det.iprioritas_id
            JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
            JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
            JOIN hrd.employee e on e.cNip = la.cCreated
            WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0 
            AND u.iteambusdev_id = 22 
            #AND u.istatus = 7
            AND u.iappdireksi = 2
            AND u.ikategoriupb_id=10 # Kategori A
            AND u.itipe_id <> 6
            AND la.iApprove=2
            and mo.vKode_modul="PL00002"
            and moa.vDept_assigned="DR"
            and moa.iType=3
            and moa.iM_activity=4
            AND la.dCreate >= "'.$perode1.'"
            AND la.dCreate <= "'.$perode2.'"
            
        ) as z
        ORDER BY z.iupb_id ASC
    ) as aa GROUP BY aa.iupb_id
    '; 
    $upbReq = $this->db_erp_pk->query($sqReq)->result_array();  
    $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
               <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                   <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >B. UPB Kategori A yang sudah disetting prioritas</th> 
               </tr>
               <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <th>No</th>
                    <th>No UPB</th>
                    <th>Nama Generik</th> 
                    <th>Tgl Setting Prioritas</th> 
                </tr>
    "; 
    $i=0;
    $nilaiB=0;
    foreach ($upbReq as $ur) {
       $i++; 
       $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                    <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                    <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                        ".$ur['vupb_nomor']."</td>
                    <td style='width:25%;text-align: left;border: 1px solid #dddddd;'>
                        ".$ur['vgenerik']."</td>
                    <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                        ".$ur['tglSettingPrio']."</td>
                </tr>"; 
                $nilaiB++;

    } 
    $html .= "</table><br /> ";

    $total=($nilaiA/$nilaiB)*100;
    $result     = number_format($total,2);
    $getpoint   = $this->getPoint($result,$iAspekId);
    $x_getpoint = explode("~", $getpoint);
    $point      = $x_getpoint['0'];
    $warna      = $x_getpoint['1'];


    $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                    <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                </tr>
                <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                    <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah A</td>
                    <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$nilaiA." </td>
                </tr>
                <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                    <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah B</td>
                    <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$nilaiB." </td>
                </tr>
                <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                    <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Hasil (A/B)*100%</td>
                    <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." %</td>
                </tr>
                
                
            </table><br/><br/>";


    echo $result."~".$point."~".$warna."~".$html;
}

   function BD1_739_VER01_PARAMETER12($post){

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
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqPrareg = 'SELECT aa.* FROM (
                            SELECT z.*
                            FROM (
                                SELECT CONCAT("NIE") as jns,u.vupb_nomor,u.vgenerik, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tglSettingPrio , it.d_from as tanggalReg,u.iteambusdev_id
                                FROM plc2.plc2_upb u
                                JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                                JOIN plc3.m_modul_log_activity la on la.iKey_id=det.iprioritas_id
                                JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                                JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                                JOIN hrd.employee e on e.cNip = la.cCreated
                                JOIN plc2.plc2_upb_formula fo on fo.iupb_id = u.iupb_id
                                JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                                JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                                WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0 and fo.ldeleted=0 and mb.ldeleted=0
                                AND u.iteambusdev_id = 4 
                                #AND u.istatus = 7
                                AND u.iappdireksi = 2
                                AND u.ikategoriupb_id=11 # Kategori B
                                AND u.itipe_id <> 6
                                AND la.iApprove=2
                                and mo.vKode_modul="PL00002"
                                and moa.vDept_assigned="DR"
                                and moa.iType=3
                                and moa.iM_activity=4
                                AND u.iHasil_registrasi=0
                                and it.id IN ( 
                                    SELECT za.id FROM (
                                            SELECT fo.iupb_id,it.d_from,it.id FROM  plc2.plc2_upb_formula fo
                                            JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                                            JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                                            WHERE fo.ldeleted=0 and mb.ldeleted=0 
                                            GROUP BY it.c_iteno ORDER BY it.id ASC
                                            ) as za
                                            WHERE
                                            za.d_from >= "'.$perode1.'" 
                                            AND za.d_from <= "'.$perode2.'"
                                        )
                                
                                UNION
                                
                                    SELECT CONCAT("APPLET") as jns,u.vupb_nomor,u.vgenerik, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tglSettingPrio , u.dinput_applet as tanggalReg,u.iteambusdev_id
                                FROM plc2.plc2_upb u
                                JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                                JOIN plc3.m_modul_log_activity la on la.iKey_id=det.iprioritas_id
                                JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                                JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                                JOIN hrd.employee e on e.cNip = la.cCreated
                                WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0 
                                AND u.iteambusdev_id = 4 
                                #AND u.istatus = 7
                                AND u.iappdireksi = 2
                                AND u.ikategoriupb_id=11 # Kategori B
                                AND u.itipe_id <> 6
                                AND la.iApprove=2
                                and mo.vKode_modul="PL00002"
                                and moa.vDept_assigned="DR"
                                and moa.iType=3
                                and moa.iM_activity=4
                                AND u.iHasil_registrasi=1
                                AND u.dinput_applet >= "'.$perode1.'"
                                AND u.dinput_applet <= "'.$perode2.'"
                                
                            ) as z
                            ORDER BY z.iupb_id ASC
                        ) as aa GROUP BY aa.iupb_id
                    ';                      
        $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >A. UPB Kategori B yang sudah disetting prioritas dan memiliki tgl Applet / NIE</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama Generik</th> 
                        <th>Tgl Setting Prioritas</th> 
                        <th>Tgl Applet/NIE</th>
                    </tr>
        "; 

        $cekDouble = array();

        $i=0;
        $total_parareg = array();
        $nilaiA=0;
        foreach ($upbPrareg as $ub) {
            $i++; 
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:25%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vgenerik']."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                ".$ub['tglSettingPrio']."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                ".$ub['tanggalReg']."</td>
                        </tr>"; 
                        $nilaiA++;

        } 
        $html .= "</table><br /> ";

        //-------------------------------------------------------------------------------------- INI REG

        $sqReq = 'SELECT aa.* FROM (
            SELECT z.*
            FROM (
                SELECT u.vupb_nomor,u.vgenerik, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tglSettingPrio,u.iteambusdev_id
                FROM plc2.plc2_upb u
                JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                JOIN plc3.m_modul_log_activity la on la.iKey_id=det.iprioritas_id
                JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                JOIN hrd.employee e on e.cNip = la.cCreated
                WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0 
                AND u.iteambusdev_id = 4 
                #AND u.istatus = 7
                AND u.iappdireksi = 2
                AND u.ikategoriupb_id=11 # Kategori B
                AND u.itipe_id <> 6
                AND la.iApprove=2
                and mo.vKode_modul="PL00002"
                and moa.vDept_assigned="DR"
                and moa.iType=3
                and moa.iM_activity=4
                AND la.dCreate >= "'.$perode1.'"
                AND la.dCreate <= "'.$perode2.'"
                
            ) as z
            ORDER BY z.iupb_id ASC
        ) as aa GROUP BY aa.iupb_id
        '; 
        $upbReq = $this->db_erp_pk->query($sqReq)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                    <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >B. UPB Kategori B yang sudah disetting prioritas</th> 
                </tr>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama Generik</th> 
                        <th>Tgl Setting Prioritas</th> 
                    </tr>
        "; 
        $i=0;
        $nilaiB=0;
        foreach ($upbReq as $ur) {
        $i++; 
        $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                        <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ur['vupb_nomor']."</td>
                        <td style='width:25%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ur['vgenerik']."</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            ".$ur['tglSettingPrio']."</td>
                    </tr>"; 
                    $nilaiB++;

        } 
        $html .= "</table><br /> ";

        $total=($nilaiA/$nilaiB)*100;
        $result     = number_format($total,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah A</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$nilaiA." %</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah B</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$nilaiB." %</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Hasil (A/B)*100%</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." %</td>
                    </tr>
                    
                    
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_739_VER01_PARAMETER12($post){

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
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqPrareg = 'SELECT aa.* FROM (
                            SELECT z.*
                            FROM (
                                SELECT CONCAT("NIE") as jns,u.vupb_nomor,u.vgenerik, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tglSettingPrio , it.d_from as tanggalReg,u.iteambusdev_id
                                FROM plc2.plc2_upb u
                                JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                                JOIN plc3.m_modul_log_activity la on la.iKey_id=det.iprioritas_id
                                JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                                JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                                JOIN hrd.employee e on e.cNip = la.cCreated
                                JOIN plc2.plc2_upb_formula fo on fo.iupb_id = u.iupb_id
                                JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                                JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                                WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0 and fo.ldeleted=0 and mb.ldeleted=0
                                AND u.iteambusdev_id = 22 
                                #AND u.istatus = 7
                                AND u.iappdireksi = 2
                                AND u.ikategoriupb_id=11 # Kategori B
                                AND u.itipe_id <> 6
                                AND la.iApprove=2
                                and mo.vKode_modul="PL00002"
                                and moa.vDept_assigned="DR"
                                and moa.iType=3
                                and moa.iM_activity=4
                                AND u.iHasil_registrasi=0
                                and it.id IN ( 
                                    SELECT za.id FROM (
                                            SELECT fo.iupb_id,it.d_from,it.id FROM  plc2.plc2_upb_formula fo
                                            JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                                            JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                                            WHERE fo.ldeleted=0 and mb.ldeleted=0 
                                            GROUP BY it.c_iteno ORDER BY it.id ASC
                                            ) as za
                                            WHERE
                                            za.d_from >= "'.$perode1.'" 
                                            AND za.d_from <= "'.$perode2.'"
                                        )
                                
                                UNION
                                
                                    SELECT CONCAT("APPLET") as jns,u.vupb_nomor,u.vgenerik, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tglSettingPrio , u.dinput_applet as tanggalReg,u.iteambusdev_id
                                FROM plc2.plc2_upb u
                                JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                                JOIN plc3.m_modul_log_activity la on la.iKey_id=det.iprioritas_id
                                JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                                JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                                JOIN hrd.employee e on e.cNip = la.cCreated
                                WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0 
                                AND u.iteambusdev_id = 22 
                                #AND u.istatus = 7
                                AND u.iappdireksi = 2
                                AND u.ikategoriupb_id=11 # Kategori B
                                AND u.itipe_id <> 6
                                AND la.iApprove=2
                                and mo.vKode_modul="PL00002"
                                and moa.vDept_assigned="DR"
                                and moa.iType=3
                                and moa.iM_activity=4
                                AND u.iHasil_registrasi=1
                                AND u.dinput_applet >= "'.$perode1.'"
                                AND u.dinput_applet <= "'.$perode2.'"
                                
                            ) as z
                            ORDER BY z.iupb_id ASC
                        ) as aa GROUP BY aa.iupb_id
                    ';                      
        $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >A. UPB Kategori B yang sudah disetting prioritas dan memiliki tgl Applet / NIE</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama Generik</th> 
                        <th>Tgl Setting Prioritas</th> 
                        <th>Tgl Applet/NIE</th>
                    </tr>
        "; 

        $cekDouble = array();

        $i=0;
        $total_parareg = array();
        $nilaiA=0;
        foreach ($upbPrareg as $ub) {
            $i++; 
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:25%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vgenerik']."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                ".$ub['tglSettingPrio']."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                ".$ub['tanggalReg']."</td>
                        </tr>"; 
                        $nilaiA++;

        } 
        $html .= "</table><br /> ";

        //-------------------------------------------------------------------------------------- INI REG

        $sqReq = 'SELECT aa.* FROM (
            SELECT z.*
            FROM (
                SELECT u.vupb_nomor,u.vgenerik, u.iupb_id, u.vupb_nama, e.cNip, e.vName, date(la.dCreate) as tglSettingPrio,u.iteambusdev_id
                FROM plc2.plc2_upb u
                JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                JOIN plc3.m_modul_log_activity la on la.iKey_id=det.iprioritas_id
                JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                JOIN hrd.employee e on e.cNip = la.cCreated
                WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0 
                AND u.iteambusdev_id = 22 
                #AND u.istatus = 7
                AND u.iappdireksi = 2
                AND u.ikategoriupb_id=11 # Kategori B
                AND u.itipe_id <> 6
                AND la.iApprove=2
                and mo.vKode_modul="PL00002"
                and moa.vDept_assigned="DR"
                and moa.iType=3
                and moa.iM_activity=4
                AND la.dCreate >= "'.$perode1.'"
                AND la.dCreate <= "'.$perode2.'"
                
            ) as z
            ORDER BY z.iupb_id ASC
        ) as aa GROUP BY aa.iupb_id
        '; 
        $upbReq = $this->db_erp_pk->query($sqReq)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                    <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >B. UPB Kategori B yang sudah disetting prioritas</th> 
                </tr>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama Generik</th> 
                        <th>Tgl Setting Prioritas</th> 
                    </tr>
        "; 
        $i=0;
        $nilaiB=0;
        foreach ($upbReq as $ur) {
        $i++; 
        $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                        <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ur['vupb_nomor']."</td>
                        <td style='width:25%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ur['vgenerik']."</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            ".$ur['tglSettingPrio']."</td>
                    </tr>"; 
                    $nilaiB++;

        } 
        $html .= "</table><br /> ";

        $total=($nilaiA/$nilaiB)*100;
        $result     = number_format($total,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah A</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$nilaiA."</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah B</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$nilaiB."</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Hasil (A/B)*100%</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." %</td>
                    </tr>
                    
                    
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }


    function BD1_739_VER01_PARAMETER13($post){

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
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqPrareg = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama , pb.vkategori,u.dinput_applet,u.ttarget_hpr
                    ,(SELECT it.d_from FROM  plc2.plc2_upb_formula fo
                                            JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                                            JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                                            WHERE fo.ldeleted=0 and mb.ldeleted=0 and fo.iupb_id=u.iupb_id
                                            GROUP BY it.c_iteno ORDER BY it.id ASC LIMIT 1 )as dNie
                    ,IF((select count(reg.id) from plc2.tanggal_history_prareg_reg reg 
                            where reg.ldeleted=0 and reg.ijenis=1 and reg.iupb_id=u.iupb_id 
                            order by reg.id ASC LIMIT 1) = 0, u.tsubmit_prareg,
                            (select reg.dtanggal from plc2.tanggal_history_prareg_reg reg 
                            where reg.ldeleted=0 and reg.ijenis=2 and reg.iupb_id=u.iupb_id 
                            order by reg.id ASC LIMIT 1)) as tprareg
                    ,IF(u.ineed_prareg=1
                        ,(SELECT la.dCreate FROM plc3.m_modul_log_activity la
                            JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                            JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                            WHERE
                            la.iApprove=2 and la.lDeleted=0
                            and mo.vKode_modul="PL00018"
                            and moa.vDept_assigned="BD"
                            and la.iKey_id=u.iupb_id order By la.iM_modul_log_activity DESC LIMIT 1)
                        ,"-"
                        ) as tglPrareg
                    ,(SELECT la.dCreate FROM plc3.m_modul_log_activity la
                            JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                            JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                            WHERE
                            la.iApprove=2 and la.lDeleted=0
                            and mo.vKode_modul="PL00029"
                            and moa.vDept_assigned="QA"
                            and la.iKey_id=u.iupb_id order By la.iM_modul_log_activity DESC LIMIT 1) as tglRegQA
                    ,(SELECT la.dCreate FROM plc3.m_modul_log_activity la
                            JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                            JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                            WHERE
                            la.iApprove=2 and la.lDeleted=0
                            and mo.vKode_modul="PL00029"
                            and moa.vDept_assigned="BD"
                            and la.iKey_id=u.iupb_id order By la.iM_modul_log_activity DESC LIMIT 1) as tglRegBD
                    FROM plc2.plc2_upb u 
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.ikategoriupb_id
                    JOIN plc2.plc2_upb_formula fo on fo.iupb_id = u.iupb_id
                    JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                    JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                    WHERE u.ldeleted = 0 
                    AND u.iteambusdev_id = 4  
                    AND u.iappdireksi = 2
                    AND u.itipe_id <> 6
                    AND u.ldeleted = 0
                    AND u.iHasil_registrasi=1
                    AND u.dinput_applet <> "0000-00-00" 
                    AND u.dinput_applet >= "'.$perode1.'" 
                    AND u.dinput_applet <= "'.$perode2.'" 
                    ';                      
        $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >Ketepatan waktu kesiapan produk baru setelah Applet</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Tgl HPR</th> 
                            <th>Tgl Prareg</th> 
                            <th>Tgl Approval QA</th> 
                            <th>Tgl BD CekDokReg</th> 
                            <th>Tgl Applet</th> 
                            <th>Tgl NIE</th> 
                            <th>Selisih (Hari)</th> 
                    </tr>
        "; 

        $cekDouble = array();

        $i=0;
        $total_parareg = array();
        $nilaiA=0;
        foreach ($upbPrareg as $ub) {
            $tgl1=$ub['dNie'];
            $tgl2=date("Y-m-d",strtotime($ub['dinput_applet']));
            $sel = $this->selisihHari($tgl1,$tgl2,$cNipNya) ;
            $i++; 
                    $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                    <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                    <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                        ".$ub['vupb_nomor']."</td>
                    <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                        ".$ub['vupb_nama']."</td>
                    <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                        ".date("Y-m-d",strtotime($ub['ttarget_hpr']))."</td>
                    <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                        ".date("Y-m-d",strtotime($ub['tprareg']))."</td>
                    <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                        ".date("Y-m-d",strtotime($ub['tglRegQA']))."</td>
                    <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                        ".date("Y-m-d",strtotime($ub['tglRegBD']))."</td>
                    <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                        ".date("Y-m-d",strtotime($ub['dinput_applet']))."</td>
                    <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                        ".$ub['dNie']."</td>
                    <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                        ".$sel."</td>
                </tr>";
                $nilaiA+=$sel;

        } 
        $html .= "</table><br /> ";

        $total=$nilaiA/5;
        $result     = number_format($total,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih (Hari)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$nilaiA."</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih (Minggu)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result."</td>
                    </tr>
                    
                    
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_739_VER01_PARAMETER13($post){

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
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqPrareg = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama , pb.vkategori,u.dinput_applet,u.ttarget_hpr
                    ,(SELECT it.d_from FROM  plc2.plc2_upb_formula fo
                                            JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                                            JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                                            WHERE fo.ldeleted=0 and mb.ldeleted=0 and fo.iupb_id=u.iupb_id
                                            GROUP BY it.c_iteno ORDER BY it.id ASC LIMIT 1 )as dNie
                    ,IF((select count(reg.id) from plc2.tanggal_history_prareg_reg reg 
                            where reg.ldeleted=0 and reg.ijenis=1 and reg.iupb_id=u.iupb_id 
                            order by reg.id ASC LIMIT 1) = 0, u.tsubmit_prareg,
                            (select reg.dtanggal from plc2.tanggal_history_prareg_reg reg 
                            where reg.ldeleted=0 and reg.ijenis=2 and reg.iupb_id=u.iupb_id 
                            order by reg.id ASC LIMIT 1)) as tprareg
                    ,IF(u.ineed_prareg=1
                        ,(SELECT la.dCreate FROM plc3.m_modul_log_activity la
                            JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                            JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                            WHERE
                            la.iApprove=2 and la.lDeleted=0
                            and mo.vKode_modul="PL00018"
                            and moa.vDept_assigned="BD"
                            and la.iKey_id=u.iupb_id order By la.iM_modul_log_activity DESC LIMIT 1)
                        ,"-"
                        ) as tglPrareg
                    ,(SELECT la.dCreate FROM plc3.m_modul_log_activity la
                            JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                            JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                            WHERE
                            la.iApprove=2 and la.lDeleted=0
                            and mo.vKode_modul="PL00029"
                            and moa.vDept_assigned="QA"
                            and la.iKey_id=u.iupb_id order By la.iM_modul_log_activity DESC LIMIT 1) as tglRegQA
                    ,(SELECT la.dCreate FROM plc3.m_modul_log_activity la
                            JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                            JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                            WHERE
                            la.iApprove=2 and la.lDeleted=0
                            and mo.vKode_modul="PL00029"
                            and moa.vDept_assigned="BD"
                            and la.iKey_id=u.iupb_id order By la.iM_modul_log_activity DESC LIMIT 1) as tglRegBD
                    FROM plc2.plc2_upb u 
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.ikategoriupb_id
                    JOIN plc2.plc2_upb_formula fo on fo.iupb_id = u.iupb_id
                    JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                    JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                    WHERE u.ldeleted = 0 
                    AND u.iteambusdev_id = 22  
                    AND u.iappdireksi = 2
                    AND u.itipe_id <> 6
                    AND u.ldeleted = 0
                    AND u.iHasil_registrasi=1
                    AND u.dinput_applet <> "0000-00-00" 
                    AND u.dinput_applet >= "'.$perode1.'" 
                    AND u.dinput_applet <= "'.$perode2.'" 
                    ';                      
        $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >Ketepatan waktu kesiapan produk baru setelah Applet</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Tgl HPR</th> 
                            <th>Tgl Prareg</th> 
                            <th>Tgl Approval QA</th> 
                            <th>Tgl BD CekDokReg</th> 
                            <th>Tanggal Applet</th> 
                            <th>Tanggal NIE</th> 
                            <th>Selisih (Hari)</th> 
                    </tr>
        "; 

        $cekDouble = array();

        $i=0;
        $total_parareg = array();
        $nilaiA=0;
        foreach ($upbPrareg as $ub) {
            $tgl1=$ub['dNie'];
            $tgl2=date("Y-m-d",strtotime($ub['dinput_applet']));
            $sel = $this->selisihHari($tgl1,$tgl2,$cNipNya) ;
            $i++; 
                    $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                    <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                    <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                        ".$ub['vupb_nomor']."</td>
                    <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                        ".$ub['vupb_nama']."</td>
                    <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                        ".date("Y-m-d",strtotime($ub['ttarget_hpr']))."</td>
                    <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                        ".date("Y-m-d",strtotime($ub['tprareg']))."</td>
                    <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                        ".date("Y-m-d",strtotime($ub['tglRegQA']))."</td>
                    <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                        ".date("Y-m-d",strtotime($ub['tglRegBD']))."</td>
                    <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                        ".date("Y-m-d",strtotime($ub['dinput_applet']))."</td>
                    <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                        ".$ub['dNie']."</td>
                    <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                        ".$sel."</td>
                </tr>";
                $nilaiA+=$sel;

        } 
        $html .= "</table><br /> ";

        $total=$nilaiA/5;
        $result     = number_format($total,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih (Hari)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$nilaiA."</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih (Minggu)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result."</td>
                    </tr>
                    
                    
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

   function BD1_739_VER01_PARAMETER14($post){
        // dari parameter 5 sebelumnya

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

        
        $sqlReq = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama , pb.vkategori,u.dinput_applet,u.ttarget_hpr
            ,IF((select count(reg.id) from plc2.tanggal_history_prareg_reg reg 
                    where reg.ldeleted=0 and reg.ijenis=1 and reg.iupb_id=u.iupb_id 
                    order by reg.id ASC LIMIT 1) = 0, u.tsubmit_prareg,
                    (select reg.dtanggal from plc2.tanggal_history_prareg_reg reg 
                    where reg.ldeleted=0 and reg.ijenis=2 and reg.iupb_id=u.iupb_id 
                    order by reg.id ASC LIMIT 1)) as tprareg
            ,IF((select count(reg.id) from plc2.tanggal_history_prareg_reg reg 
                    where reg.ldeleted=0 and reg.ijenis=2 and reg.iupb_id=u.iupb_id 
                    order by reg.id ASC LIMIT 1) = 0, u.tregistrasi,
                    (select reg.dtanggal from plc2.tanggal_history_prareg_reg reg 
                    where reg.ldeleted=0 and reg.ijenis=2 and reg.iupb_id=u.iupb_id 
                    order by reg.id ASC LIMIT 1)) as tregistrasi
            ,IF ((SELECT count(it.id) FROM  plc2.plc2_upb_formula fo
                    JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                    JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                    WHERE fo.ldeleted=0 and mb.ldeleted=0 and fo.iupb_id=u.iupb_id
                    ORDER BY it.id LIMIT 1
            ) = 0,
                NULL,
                (SELECT it.d_from FROM  plc2.plc2_upb_formula fo
                    JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                    JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                    WHERE fo.ldeleted=0 and mb.ldeleted=0 and fo.iupb_id=u.iupb_id
                    ORDER BY it.id LIMIT 1
            )) as dNie
            ,IF(u.ineed_prareg=1
                ,(SELECT la.dCreate FROM plc3.m_modul_log_activity la
                    JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                    JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                    WHERE
                    la.iApprove=2 and la.lDeleted=0
                    and mo.vKode_modul="PL00018"
                    and moa.vDept_assigned="BD"
                    and la.iKey_id=u.iupb_id order By la.iM_modul_log_activity DESC LIMIT 1)
                ,"-"
                ) as tglPrareg
            ,(SELECT la.dCreate FROM plc3.m_modul_log_activity la
                    JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                    JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                    WHERE
                    la.iApprove=2 and la.lDeleted=0
                    and mo.vKode_modul="PL00029"
                    and moa.vDept_assigned="QA"
                    and la.iKey_id=u.iupb_id order By la.iM_modul_log_activity DESC LIMIT 1) as tglRegQA
            ,(SELECT la.dCreate FROM plc3.m_modul_log_activity la
                    JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                    JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                    WHERE
                    la.iApprove=2 and la.lDeleted=0
                    and mo.vKode_modul="PL00029"
                    and moa.vDept_assigned="BD"
                    and la.iKey_id=u.iupb_id order By la.iM_modul_log_activity DESC LIMIT 1) as tglRegBD
            FROM plc2.plc2_upb u 
            JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.ikategoriupb_id
            WHERE u.ldeleted = 0 
            AND u.tregistrasi IS NOT NULL AND u.tregistrasi <>"0000-00-00"
            AND u.iteambusdev_id = 4  
            AND u.iappdireksi = 2
            AND u.itipe_id <> 6
            and u.iKomnas = 0 
            AND u.ldeleted = 0
            AND u.ikategoriupb_id IN(10,1,20,21,22)
            AND (CASE 
            WHEN u.dinput_applet IS not NULL and u.dinput_applet<>"0000-00-00" THEN
            u.dinput_applet IS NOT NULL 
            AND u.dinput_applet <> "0000-00-00" 
            AND u.dinput_applet >= "'.$perode1.'" 
            AND u.dinput_applet <= "'.$perode2.'" 
            ELSE  
            u.iupb_id IN 
                (SELECT za.iupb_id FROM (
                SELECT fo.iupb_id,it.d_from,it.id FROM  plc2.plc2_upb_formula fo
                    JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                    JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                    WHERE fo.ldeleted=0 and mb.ldeleted=0 
                    GROUP BY it.c_iteno ORDER BY it.id ASC
                    ) as za
                    WHERE
                    za.d_from >= "'.$perode1.'" 
                    AND za.d_from <= "'.$perode2.'"
                )
            END
            )
            ';
 

       
        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        // $html.='<pre>'.$sqlReq.'</pre>';
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategori UPB</th>   
                          <th>Tgl HPR</th> 
                            <th>Tgl Prareg</th> 
                            <th>Tgl Approval QA</th> 
                            <th>Tgl BD CekDokReg</th>  
                          <th>Tanggal Registrasi</th>
                          <th>Tanggal Applet</th> 
                          <th>Tanggal NIE</th> 
                          <th>Selisih </th> 
                    </tr>
        ";
        $i=0; 
        $selisih = 0; 
        $upbDetail = $this->db_erp_pk->query($sqlReq)->result_array();
        foreach ($upbDetail as $ub) {

            $tgl1=$ub['tregistrasi'];
            $tglApplet="";
            if($ub['dinput_applet'] <> ''){
                $tgl2=$ub['dinput_applet'];
                $tglApplet=date("Y-m-d",strtotime($ub['dinput_applet']));
            }else{
                $tgl2=$ub['dNie'];
            }
            
            /*$sel = $this->selisihHari($tgl1,$tgl2,$cNipNya);*/
            $sel = $this->getDurasiBulan($tgl1,$tgl2);
            $sel=number_format($sel,2);

             $i++;  
             $selisih += $sel;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date("Y-m-d",strtotime($ub['ttarget_hpr']))."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date("Y-m-d",strtotime($ub['tprareg']))."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date("Y-m-d",strtotime($ub['tglRegQA']))."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date("Y-m-d",strtotime($ub['tglRegBD']))."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tregistrasi']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$tglApplet."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dNie']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$sel."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        if($selisih==0){
            $result = 0;

        }else{
            $tot = $selisih/$i;
            $result     = number_format($tot,2);

            
        } 


        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori A </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                    </tr> 

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format($selisih,2)." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'> Rata - Rata Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr> 
                </table><br/><br/>";
 

        echo $result."~".$point."~".$warna."~".$html;
   }

   function BD2_739_VER01_PARAMETER14($post){
        // dari parameter 5 sebelumnya

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

        
        $sqlReq = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama , pb.vkategori,u.dinput_applet,u.ttarget_hpr
            ,IF((select count(reg.id) from plc2.tanggal_history_prareg_reg reg 
                    where reg.ldeleted=0 and reg.ijenis=1 and reg.iupb_id=u.iupb_id 
                    order by reg.id ASC LIMIT 1) = 0, u.tsubmit_prareg,
                    (select reg.dtanggal from plc2.tanggal_history_prareg_reg reg 
                    where reg.ldeleted=0 and reg.ijenis=2 and reg.iupb_id=u.iupb_id 
                    order by reg.id ASC LIMIT 1)) as tprareg
            ,IF((select count(reg.id) from plc2.tanggal_history_prareg_reg reg 
                    where reg.ldeleted=0 and reg.ijenis=2 and reg.iupb_id=u.iupb_id 
                    order by reg.id ASC LIMIT 1) = 0, u.tregistrasi,
                    (select reg.dtanggal from plc2.tanggal_history_prareg_reg reg 
                    where reg.ldeleted=0 and reg.ijenis=2 and reg.iupb_id=u.iupb_id 
                    order by reg.id ASC LIMIT 1)) as tregistrasi
            ,IF ((SELECT count(it.id) FROM  plc2.plc2_upb_formula fo
                    JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                    JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                    WHERE fo.ldeleted=0 and mb.ldeleted=0 and fo.iupb_id=u.iupb_id
                    ORDER BY it.id LIMIT 1
            ) = 0,
                NULL,
                (SELECT it.d_from FROM  plc2.plc2_upb_formula fo
                    JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                    JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                    WHERE fo.ldeleted=0 and mb.ldeleted=0 and fo.iupb_id=u.iupb_id
                    ORDER BY it.id LIMIT 1
            )) as dNie
            ,IF(u.ineed_prareg=1
                ,(SELECT la.dCreate FROM plc3.m_modul_log_activity la
                    JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                    JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                    WHERE
                    la.iApprove=2 and la.lDeleted=0
                    and mo.vKode_modul="PL00018"
                    and moa.vDept_assigned="BD"
                    and la.iKey_id=u.iupb_id order By la.iM_modul_log_activity DESC LIMIT 1)
                ,"-"
                ) as tglPrareg
            ,(SELECT la.dCreate FROM plc3.m_modul_log_activity la
                    JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                    JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                    WHERE
                    la.iApprove=2 and la.lDeleted=0
                    and mo.vKode_modul="PL00029"
                    and moa.vDept_assigned="QA"
                    and la.iKey_id=u.iupb_id order By la.iM_modul_log_activity DESC LIMIT 1) as tglRegQA
            ,(SELECT la.dCreate FROM plc3.m_modul_log_activity la
                    JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                    JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                    WHERE
                    la.iApprove=2 and la.lDeleted=0
                    and mo.vKode_modul="PL00029"
                    and moa.vDept_assigned="BD"
                    and la.iKey_id=u.iupb_id order By la.iM_modul_log_activity DESC LIMIT 1) as tglRegBD
            FROM plc2.plc2_upb u 
            JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.ikategoriupb_id
            WHERE u.ldeleted = 0 
            AND u.tregistrasi IS NOT NULL AND u.tregistrasi <>"0000-00-00"
            AND u.iteambusdev_id = 22  
            AND u.iappdireksi = 2
            AND u.itipe_id <> 6
            and u.iKomnas = 0 
            AND u.ldeleted = 0
            AND u.ikategoriupb_id IN(10,1,20,21,22)
            AND (CASE 
            WHEN u.dinput_applet IS not NULL and u.dinput_applet<>"0000-00-00" THEN
            u.dinput_applet IS NOT NULL 
            AND u.dinput_applet <> "0000-00-00" 
            AND u.dinput_applet >= "'.$perode1.'" 
            AND u.dinput_applet <= "'.$perode2.'" 
            ELSE  
            u.iupb_id IN 
                (SELECT za.iupb_id FROM (
                SELECT fo.iupb_id,it.d_from,it.id FROM  plc2.plc2_upb_formula fo
                    JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                    JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                    WHERE fo.ldeleted=0 and mb.ldeleted=0 
                    GROUP BY it.c_iteno ORDER BY it.id ASC
                    ) as za
                    WHERE
                    za.d_from >= "'.$perode1.'" 
                    AND za.d_from <= "'.$perode2.'"
                )
            END
            )
            ';


    
        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        // $html.='<pre>'.$sqlReq.'</pre>';
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Kategori UPB</th>   
                        <th>Tgl HPR</th> 
                            <th>Tgl Prareg</th> 
                            <th>Tgl Approval QA</th> 
                            <th>Tgl BD CekDokReg</th> 
                        <th>Tanggal Registrasi</th>
                        <th>Tanggal Applet</th> 
                        <th>Tanggal NIE</th> 
                        <th>Selisih </th> 
                    </tr>
        ";
        $i=0; 
        $selisih = 0; 
        $upbDetail = $this->db_erp_pk->query($sqlReq)->result_array();
        foreach ($upbDetail as $ub) {

            $tgl1=$ub['tregistrasi'];
            $tglApplet="";
            if($ub['dinput_applet'] <> ''){
                $tgl2=$ub['dinput_applet'];
                $tglApplet=date("Y-m-d",strtotime($ub['dinput_applet']));
            }else{
                $tgl2=$ub['dNie'];
            }
            
            /*$sel = $this->selisihHari($tgl1,$tgl2,$cNipNya);*/
            $sel = $this->getDurasiBulan($tgl1,$tgl2);
            $sel=number_format($sel,2);

            $i++;  
            $selisih += $sel;
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date("Y-m-d",strtotime($ub['ttarget_hpr']))."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date("Y-m-d",strtotime($ub['tprareg']))."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date("Y-m-d",strtotime($ub['tglRegQA']))."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date("Y-m-d",strtotime($ub['tglRegBD']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tregistrasi']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$tglApplet."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dNie']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$sel."</td>
                    </tr>";

        }

        $html .= "</table><br /> ";

        if($selisih==0){
            $result = 0;

        }else{
            $tot = $selisih/$i;
            $result     = number_format($tot,2);

            
        } 


        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori A </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                    </tr> 

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format($selisih,2)." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'> Rata - Rata Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr> 
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

   function BD1_739_VER01_PARAMETER15($post){
        // dari parameter 5 sebelumnya

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

        
        $sqlTD = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama,  pb.vkategori,
                    ( SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                          AND ad.`iupb_id`  = u.`iupb_id`
                          AND ad.`dsubmit_dok` IS NOT NULL
                          ORDER BY ad.`dsubmit_dok` DESC LIMIT 1
                    )  AS dsubmit_dok,

                    u.dinput_applet,u.dNie,
                    (SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                              AND ad.`iupb_id`  = u.`iupb_id`
                              AND ad.`dsubmit_dok` IS NOT NULL
                              ORDER BY ad.`dsubmit_dok` DESC LIMIT 1) as TAMPIL1,
                    u.tsubmit_reg as TAMPIL

                    #IF(u.dinput_applet IS NULL or u.dinput_applet<>"0000-00-00", u.dNie, u.dinput_applet) AS TAMPIL,
                    ,ABS(datediff(
                        ( SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                              AND ad.`iupb_id`  = u.`iupb_id`
                              AND ad.`dsubmit_dok` IS NOT NULL
                              ORDER BY ad.`dsubmit_dok` DESC LIMIT 1
                        ), IF(u.dinput_applet IS not NULL and u.dinput_applet<>"0000-00-00", 
                             u.dinput_applet ,u.dNie  ))
                    ) 
                    AS SELISIH
                  FROM plc2.`plc2_upb` u 
                  JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                  WHERE u.`ldeleted` = 0  
                      AND u.`iteambusdev_id` = 4  
                      AND u.itipe_id <> 6
                      AND u.`iupb_id` IN (SELECT ad.`iupb_id` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0  
                            AND ad.`dsubmit_dok` IS NOT NULL )
                      AND u.ldeleted = 0
                      AND u.`ikategoriupb_id` = 11
                      and u.tsubmit_reg is not null
                      AND 
                      IF(u.dinput_applet IS not NULL and u.dinput_applet<>"0000-00-00",
                            u.dinput_applet IS NOT NULL 
                            AND u.dinput_applet <> "0000-00-00" 
                            AND u.dinput_applet >= "'.$perode1.'" 
                            AND u.dinput_applet <= "'.$perode2.'" 
                            , 
                            u.dNie IS NOT NULL 
                            AND u.dNie <> "0000-00-00" 
                            AND u.dNie >= "'.$perode1.'" 
                            AND u.dNie <= "'.$perode2.'" 
                            
                        )';
        $sqlTD='SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama , pb.vkategori,u.dinput_applet,u.ttarget_hpr
        ,IF((select count(reg.id) from plc2.tanggal_history_prareg_reg reg 
                where reg.ldeleted=0 and reg.ijenis=1 and reg.iupb_id=u.iupb_id 
                order by reg.id ASC LIMIT 1) = 0, u.tsubmit_prareg,
                (select reg.dtanggal from plc2.tanggal_history_prareg_reg reg 
                where reg.ldeleted=0 and reg.ijenis=2 and reg.iupb_id=u.iupb_id 
                order by reg.id ASC LIMIT 1)) as tprareg
        ,IF((select count(reg.id) from plc2.tanggal_history_prareg_reg reg 
                where reg.ldeleted=0 and reg.ijenis=2 and reg.iupb_id=u.iupb_id 
                order by reg.id ASC LIMIT 1) = 0, u.tregistrasi,
                (select reg.dtanggal from plc2.tanggal_history_prareg_reg reg 
                where reg.ldeleted=0 and reg.ijenis=2 and reg.iupb_id=u.iupb_id 
                order by reg.id ASC LIMIT 1)) as tregistrasi
        ,IF ((SELECT count(it.id) FROM  plc2.plc2_upb_formula fo
                JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                WHERE fo.ldeleted=0 and mb.ldeleted=0 and fo.iupb_id=u.iupb_id
                ORDER BY it.id LIMIT 1
        ) = 0,
            NULL,
            (SELECT it.d_from FROM  plc2.plc2_upb_formula fo
                JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                WHERE fo.ldeleted=0 and mb.ldeleted=0 and fo.iupb_id=u.iupb_id
                ORDER BY it.id LIMIT 1
        )) as dNie
        ,IF(u.ineed_prareg=1
            ,(SELECT la.dCreate FROM plc3.m_modul_log_activity la
                JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                WHERE
                la.iApprove=2 and la.lDeleted=0
                and mo.vKode_modul="PL00018"
                and moa.vDept_assigned="BD"
                and la.iKey_id=u.iupb_id order By la.iM_modul_log_activity DESC LIMIT 1)
            ,"-"
            ) as tglPrareg
        ,(SELECT la.dCreate FROM plc3.m_modul_log_activity la
                JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                WHERE
                la.iApprove=2 and la.lDeleted=0
                and mo.vKode_modul="PL00029"
                and moa.vDept_assigned="QA"
                and la.iKey_id=u.iupb_id order By la.iM_modul_log_activity DESC LIMIT 1) as tglRegQA
        ,(SELECT la.dCreate FROM plc3.m_modul_log_activity la
                JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                WHERE
                la.iApprove=2 and la.lDeleted=0
                and mo.vKode_modul="PL00029"
                and moa.vDept_assigned="BD"
                and la.iKey_id=u.iupb_id order By la.iM_modul_log_activity DESC LIMIT 1) as tglRegBD
        ,(SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                          AND ad.`iupb_id`  = u.`iupb_id`
                          AND ad.`dsubmit_dok` IS NOT NULL
                          ORDER BY ad.`dsubmit_dok` DESC LIMIT 1
                    )  AS dsubmit_dok
        FROM plc2.plc2_upb u 
        JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.ikategoriupb_id
        WHERE u.ldeleted = 0 
        AND u.tregistrasi IS NOT NULL AND u.tregistrasi <>"0000-00-00"
        AND u.iteambusdev_id = 4  
        AND u.iappdireksi = 2
        AND u.itipe_id <> 6
        and u.iKomnas = 0 
        AND u.`iupb_id` IN (SELECT ad.`iupb_id` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 AND ad.`dsubmit_dok` IS NOT NULL )
        AND u.ldeleted = 0
        AND u.`ikategoriupb_id` = 11
        #and u.tsubmit_reg is not null
        AND (CASE 
        WHEN u.dinput_applet IS not NULL and u.dinput_applet<>"0000-00-00" THEN
            u.dinput_applet IS NOT NULL 
            AND u.dinput_applet <> "0000-00-00" 
            AND u.dinput_applet >= "'.$perode1.'" 
            AND u.dinput_applet <= "'.$perode2.'" 
            ELSE  
            u.iupb_id IN 
                (SELECT za.iupb_id FROM (
                SELECT fo.iupb_id,it.d_from,it.id FROM  plc2.plc2_upb_formula fo
                    JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                    JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                    WHERE fo.ldeleted=0 and mb.ldeleted=0 
                    GROUP BY it.c_iteno ORDER BY it.id ASC
                    ) as za
                    WHERE
                    za.d_from >= "'.$perode1.'" 
                    AND za.d_from <= "'.$perode2.'"
                )
        END
        )';
        
        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

                // $html.= '<pre>'.$sqlTD.'</pre>';
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategori UPB</th>  
                          <th>Tgl HPR</th> 
                            <th>Tgl Prareg</th> 
                            <th>Tgl Approval QA</th> 
                            <th>Tgl BD CekDokReg</th> 
                          <th>Tanggal Applet Dokumen</th> 
                          <th>Tanggal NIE</th> 
                          <th>Tanggal Registrasi</th>  
                          <th>Selisih</th> 
                    </tr>
        ";
        $i=0;  
        $selisih = 0; 
        $upbDetail = $this->db_erp_pk->query($sqlTD)->result_array();
        foreach ($upbDetail as $ub) {
            $tgl1=$ub['tregistrasi'];

            if($ub['dinput_applet'] <> ''){
                $tgl2=$ub['dinput_applet'];
            }else{
                $tgl2=$ub['dNie'];
            }
            
            $sel = $this->getDurasiBulan($tgl1,$tgl2);

             $i++;   
             $selisih += $sel;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date("Y-m-d",strtotime($ub['ttarget_hpr']))."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date("Y-m-d",strtotime($ub['tprareg']))."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date("Y-m-d",strtotime($ub['tglRegQA']))."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date("Y-m-d",strtotime($ub['tglRegBD']))."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dinput_applet']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dNie']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tregistrasi']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$sel."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        if($selisih==0){
            $result = 0;
        }else{
            $tot = $selisih/$i;
            $result  = number_format($tot,2);
            //$result  = number_format(($result/22),2);

            /*$result = number_format($tot,2);*/
        } 
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori B </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                    </tr> 

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - Rata Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr> 

                </table><br/><br/>";

        echo $result."~".$point."~".$warna."~".$html;
   }

   function BD2_739_VER01_PARAMETER15($post){
        // dari parameter 5 sebelumnya

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

        
        $sqlTD = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama,  pb.vkategori,
                    ( SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                        AND ad.`iupb_id`  = u.`iupb_id`
                        AND ad.`dsubmit_dok` IS NOT NULL
                        ORDER BY ad.`dsubmit_dok` DESC LIMIT 1
                    )  AS dsubmit_dok,

                    u.dinput_applet,u.dNie,
                    (SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                            AND ad.`iupb_id`  = u.`iupb_id`
                            AND ad.`dsubmit_dok` IS NOT NULL
                            ORDER BY ad.`dsubmit_dok` DESC LIMIT 1) as TAMPIL1,
                    u.tsubmit_reg as TAMPIL

                    #IF(u.dinput_applet IS NULL or u.dinput_applet<>"0000-00-00", u.dNie, u.dinput_applet) AS TAMPIL,
                    ,ABS(datediff(
                        ( SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                            AND ad.`iupb_id`  = u.`iupb_id`
                            AND ad.`dsubmit_dok` IS NOT NULL
                            ORDER BY ad.`dsubmit_dok` DESC LIMIT 1
                        ), IF(u.dinput_applet IS not NULL and u.dinput_applet<>"0000-00-00", 
                            u.dinput_applet ,u.dNie  ))
                    ) 
                    AS SELISIH
                FROM plc2.`plc2_upb` u 
                JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                WHERE u.`ldeleted` = 0  
                    AND u.`iteambusdev_id` = 22  
                    AND u.itipe_id <> 6
                    AND u.`iupb_id` IN (SELECT ad.`iupb_id` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0  
                            AND ad.`dsubmit_dok` IS NOT NULL )
                    AND u.ldeleted = 0
                    AND u.`ikategoriupb_id` = 11
                    and u.tsubmit_reg is not null
                    AND 
                    IF(u.dinput_applet IS not NULL and u.dinput_applet<>"0000-00-00",
                            u.dinput_applet IS NOT NULL 
                            AND u.dinput_applet <> "0000-00-00" 
                            AND u.dinput_applet >= "'.$perode1.'" 
                            AND u.dinput_applet <= "'.$perode2.'" 
                            , 
                            u.dNie IS NOT NULL 
                            AND u.dNie <> "0000-00-00" 
                            AND u.dNie >= "'.$perode1.'" 
                            AND u.dNie <= "'.$perode2.'" 
                            
                        )';
                        $sqlTD='SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama , pb.vkategori,u.dinput_applet,u.ttarget_hpr
                        ,IF((select count(reg.id) from plc2.tanggal_history_prareg_reg reg 
                                where reg.ldeleted=0 and reg.ijenis=1 and reg.iupb_id=u.iupb_id 
                                order by reg.id ASC LIMIT 1) = 0, u.tsubmit_prareg,
                                (select reg.dtanggal from plc2.tanggal_history_prareg_reg reg 
                                where reg.ldeleted=0 and reg.ijenis=2 and reg.iupb_id=u.iupb_id 
                                order by reg.id ASC LIMIT 1)) as tprareg
                        ,IF((select count(reg.id) from plc2.tanggal_history_prareg_reg reg 
                                where reg.ldeleted=0 and reg.ijenis=2 and reg.iupb_id=u.iupb_id 
                                order by reg.id ASC LIMIT 1) = 0, u.tregistrasi,
                                (select reg.dtanggal from plc2.tanggal_history_prareg_reg reg 
                                where reg.ldeleted=0 and reg.ijenis=2 and reg.iupb_id=u.iupb_id 
                                order by reg.id ASC LIMIT 1)) as tregistrasi
                        ,IF ((SELECT count(it.id) FROM  plc2.plc2_upb_formula fo
                                JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                                JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                                WHERE fo.ldeleted=0 and mb.ldeleted=0 and fo.iupb_id=u.iupb_id
                                ORDER BY it.id LIMIT 1
                        ) = 0,
                            NULL,
                            (SELECT it.d_from FROM  plc2.plc2_upb_formula fo
                                JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                                JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                                WHERE fo.ldeleted=0 and mb.ldeleted=0 and fo.iupb_id=u.iupb_id
                                ORDER BY it.id LIMIT 1
                        )) as dNie
                        ,IF(u.ineed_prareg=1
                            ,(SELECT la.dCreate FROM plc3.m_modul_log_activity la
                                JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                                JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                                WHERE
                                la.iApprove=2 and la.lDeleted=0
                                and mo.vKode_modul="PL00018"
                                and moa.vDept_assigned="BD"
                                and la.iKey_id=u.iupb_id order By la.iM_modul_log_activity DESC LIMIT 1)
                            ,"-"
                            ) as tglPrareg
                        ,(SELECT la.dCreate FROM plc3.m_modul_log_activity la
                                JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                                JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                                WHERE
                                la.iApprove=2 and la.lDeleted=0
                                and mo.vKode_modul="PL00029"
                                and moa.vDept_assigned="QA"
                                and la.iKey_id=u.iupb_id order By la.iM_modul_log_activity DESC LIMIT 1) as tglRegQA
                        ,(SELECT la.dCreate FROM plc3.m_modul_log_activity la
                                JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                                JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                                WHERE
                                la.iApprove=2 and la.lDeleted=0
                                and mo.vKode_modul="PL00029"
                                and moa.vDept_assigned="BD"
                                and la.iKey_id=u.iupb_id order By la.iM_modul_log_activity DESC LIMIT 1) as tglRegBD
                        ,(SELECT ad.`dsubmit_dok` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 
                                          AND ad.`iupb_id`  = u.`iupb_id`
                                          AND ad.`dsubmit_dok` IS NOT NULL
                                          ORDER BY ad.`dsubmit_dok` DESC LIMIT 1
                                    )  AS dsubmit_dok
                        FROM plc2.plc2_upb u 
                        JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.ikategoriupb_id
                        WHERE u.ldeleted = 0 
                        AND u.tregistrasi IS NOT NULL AND u.tregistrasi <>"0000-00-00"
                        AND u.iteambusdev_id = 22  
                        AND u.iappdireksi = 2
                        AND u.itipe_id <> 6
                        and u.iKomnas = 0 
                        AND u.`iupb_id` IN (SELECT ad.`iupb_id` FROM plc2.`applet_dokumen` ad WHERE ad.`lDeleted` = 0 AND ad.`dsubmit_dok` IS NOT NULL )
                        AND u.ldeleted = 0
                        AND u.`ikategoriupb_id` = 11
                        #and u.tsubmit_reg is not null
                        AND (CASE 
                        WHEN u.dinput_applet IS not NULL and u.dinput_applet<>"0000-00-00" THEN
                            u.dinput_applet IS NOT NULL 
                            AND u.dinput_applet <> "0000-00-00" 
                            AND u.dinput_applet >= "'.$perode1.'" 
                            AND u.dinput_applet <= "'.$perode2.'" 
                            ELSE  
                            u.iupb_id IN 
                                (SELECT za.iupb_id FROM (
                                SELECT fo.iupb_id,it.d_from,it.id FROM  plc2.plc2_upb_formula fo
                                    JOIN plc2.plc2_upb_buat_mbr mb on mb.ifor_id = fo.ifor_id
                                    JOIN sales.itemreg it on it.c_iteno = mb.c_iteno
                                    WHERE fo.ldeleted=0 and mb.ldeleted=0 
                                    GROUP BY it.c_iteno ORDER BY it.id ASC
                                    ) as za
                                    WHERE
                                    za.d_from >= "'.$perode1.'" 
                                    AND za.d_from <= "'.$perode2.'"
                                )
                        END
                        )';
        
        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

                // $html.= '<pre>'.$sqlTD.'</pre>';
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Kategori UPB</th>
                        <th>Tgl HPR</th> 
                        <th>Tgl Prareg</th> 
                        <th>Tgl Approval QA</th> 
                        <th>Tgl BD CekDokReg</th> 
                        <th>Tanggal Applet Dokumen</th> 
                        <th>Tanggal NIE</th> 
                        <th>Tanggal Registrasi</th>  
                        <th>Selisih</th> 
                    </tr>
        ";
        $i=0;  
        $selisih = 0; 
        $upbDetail = $this->db_erp_pk->query($sqlTD)->result_array();
        foreach ($upbDetail as $ub) {
            $tgl1=$ub['tregistrasi'];

            if($ub['dinput_applet'] <> ''){
                $tgl2=$ub['dinput_applet'];
            }else{
                $tgl2=$ub['dNie'];
            }
            
            $sel = $this->getDurasiBulan($tgl1,$tgl2);

            $i++;   
            $selisih += $sel;
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date("Y-m-d",strtotime($ub['ttarget_hpr']))."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date("Y-m-d",strtotime($ub['tprareg']))."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date("Y-m-d",strtotime($ub['tglRegQA']))."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date("Y-m-d",strtotime($ub['tglRegBD']))."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".date("Y-m-d",strtotime($ub['dinput_applet']))."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dNie']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tregistrasi']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$sel."</td>
                    </tr>";

        }

        $html .= "</table><br /> ";

        if($selisih==0){
            $result = 0;
        }else{
            $tot = $selisih/$i;
            $result  = number_format($tot,2);
            //$result  = number_format(($result/22),2);

            /*$result = number_format($tot,2);*/
        } 
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori B </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                    </tr> 

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$selisih." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Rata - Rata Total Selish (Bulan)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr> 

                </table><br/><br/>";

        echo $result."~".$point."~".$warna."~".$html;
    }

   function BD1_739_VER01_PARAMETER17($post){

        $iAspekId = $post['_iAspekId'];
        $cNipNya  = $post['_cNipNya'];
        $dPeriode1  = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];

        $dPeriode2  = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2']."-".$x_prd2['1']."-".$x_prd2['0'];



        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='".$iAspekId."'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $sql_par5 ='
                SELECT  i.tReceived ,e.vName,t.vtarget_kunjungan,cc.vpejabat
                FROM kartu_call.`call_card` cc 
                join hrd.employee e on e.cNip=cc.vNIP
                join gps_msg.inbox i on i.ID=cc.igpsm_id
                join kartu_call.master_target_kunjungan t on t.itarget_kunjungan_id=cc.itarget_kunjungan_id
                WHERE cc.`lDeleted` = 0 
                AND t.`isHead` = 1  
                AND cc.`vNIP` LIKE "%'.$cNipNya.'%"
                AND date(i.`tReceived`) >= "'.$perode1.'"
                AND date(i.`tReceived`) <= "'.$perode2.'"
                    ';

        $qupb = $this->db_erp_pk->query($sql_par5);
        if($qupb->num_rows() > 0) {
            $tot = $qupb->num_rows();
            $totb = number_format( $tot, 2, '.', '' );
        }else{
            $totb       = 0;
        }




        $html = "
                <table cellspacing='0' cellpadding='3' width='850px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                    </tr>
                </table><br><hr>";


        $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Nama</th>
                        <th>Target Kunjungan</th>
                        <th>Nama Pejabat</th>
                    </tr>
        ";

        $bacthDetail = $this->db_erp_pk->query($sql_par5)->result_array();
        $i=0;




        
        foreach ($bacthDetail as $ub) {
            $i++;
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='border: 1px solid #dddddd;'>".$i."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['tReceived']."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['vName']."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['vtarget_kunjungan']."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['vpejabat']."</td>
                        
                    </tr>";
        }

        $html .= "</table><br /> ";

        $timeEnd = strtotime($perode2);
        $timeStart = strtotime($perode1);
        $bulan = 1+(date("Y",$timeEnd)-date("Y",$timeStart))*12;
        $bulan +=  (date("m",$timeEnd)-date("m",$timeStart));      


        $result     = number_format(($i/$bulan), 2, '.', '' );

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Kunjungan (A)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Bulan (B)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$bulan." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Result (A/B) </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result."</td>
                    </tr>
                </table><br/><br/>";

        

        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_739_VER01_PARAMETER17($post){

        $iAspekId = $post['_iAspekId'];
        $cNipNya  = $post['_cNipNya'];
        $dPeriode1  = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];

        $dPeriode2  = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2']."-".$x_prd2['1']."-".$x_prd2['0'];



        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='".$iAspekId."'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $sql_par5 ='
                SELECT  i.tReceived ,e.vName,t.vtarget_kunjungan,cc.vpejabat
                FROM kartu_call.`call_card` cc 
                join hrd.employee e on e.cNip=cc.vNIP
                join gps_msg.inbox i on i.ID=cc.igpsm_id
                join kartu_call.master_target_kunjungan t on t.itarget_kunjungan_id=cc.itarget_kunjungan_id
                WHERE cc.`lDeleted` = 0 
                AND t.`isHead` = 1  
                AND cc.`vNIP` LIKE "%'.$cNipNya.'%"
                AND date(i.`tReceived`) >= "'.$perode1.'"
                AND date(i.`tReceived`) <= "'.$perode2.'"
                    ';

        $qupb = $this->db_erp_pk->query($sql_par5);
        if($qupb->num_rows() > 0) {
            $tot = $qupb->num_rows();
            $totb = number_format( $tot, 2, '.', '' );
        }else{
            $totb       = 0;
        }




        $html = "
                <table cellspacing='0' cellpadding='3' width='850px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                    </tr>
                </table><br><hr>";


        $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Nama</th>
                        <th>Target Kunjungan</th>
                        <th>Nama Pejabat</th>
                    </tr>
        ";

        $bacthDetail = $this->db_erp_pk->query($sql_par5)->result_array();
        $i=0;




        
        foreach ($bacthDetail as $ub) {
            $i++;
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='border: 1px solid #dddddd;'>".$i."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['tReceived']."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['vName']."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['vtarget_kunjungan']."</td>
                        <td style='border: 1px solid #dddddd;'>".$ub['vpejabat']."</td>
                        
                    </tr>";
        }

        $html .= "</table><br /> ";

        $timeEnd = strtotime($perode2);
        $timeStart = strtotime($perode1);
        $bulan = 1+(date("Y",$timeEnd)-date("Y",$timeStart))*12;
        $bulan +=  (date("m",$timeEnd)-date("m",$timeStart));      


        $result     = number_format(($i/$bulan), 2, '.', '' );

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Kunjungan (A)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Bulan (B)</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$bulan." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Result (A/B) </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result."</td>
                    </tr>
                </table><br/><br/>";

        

        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        echo $result."~".$point."~".$warna."~".$html;
    }




    //Supri End

    //Syukur Start
    function BD1_739_VER01_PARAMETER01($post){
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

        $sql2='SELECT DISTINCT(u.`iGroup_produk`) as jml 
            FROM plc2.`plc2_upb` u
            JOIN plc3.m_modul_log_activity a ON u.iupb_id=a.iKey_id
            JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
            JOIN plc2.master_group_produk c ON u.iGroup_produk=c.imaster_group_produk
            WHERE 
            u.`ldeleted` = 0
            and a.lDeleted = 0
            AND b.lDeleted = 0
            AND c.lDeleted = 0
            AND u.`iteambusdev_id` = 4
            AND b.vKode_modul = "PL00001"
            AND a.iApprove = 2
            AND a.iSort = 999
            and u.iKill = 0
            AND a.dCreate >= "'.$perode1.'"
            AND a.dCreate <= "'.$perode2.'"
            ORDER BY u.iupb_id';


      //  $totDDS     = $dds;
        $totb       = $this->db_erp_pk->query($sql2)->num_rows();
        $result     = $totb;
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqlDetail='SELECT u.`iupb_id`, u.vgenerik, c.vNama_Group ,u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , a.dCreate, u.vKode_obat 
                    FROM plc2.plc2_upb u
                    JOIN plc3.m_modul_log_activity a ON u.iupb_id=a.iKey_id
                    JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
                    JOIN plc2.master_group_produk c ON u.iGroup_produk=c.imaster_group_produk
                    WHERE 
                    u.`ldeleted` = 0
                    and a.lDeleted = 0
                    AND b.lDeleted = 0
                    AND c.lDeleted = 0
                    AND u.`iteambusdev_id` = 4
                    AND b.vKode_modul = "PL00001"
                    AND a.iApprove = 2
                    AND a.iSort = 999
                    and u.iKill = 0
                    AND a.dCreate >= "'.$perode1.'"
                    AND a.dCreate <= "'.$perode2.'"
                    ORDER BY u.iGroup_produk';

           // echo '<pre>'.$sqlDetail;    

        $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Nama Generik</th>
                        <th>Group Produk</th>
                        <th>Approval Direksi</th>
                    </tr>
        ";

        $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
        $i=0;
        foreach ($upbDetail as $ub) {
             $i++;

             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vgenerik']."</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vNama_Group']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dCreate']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>

                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Group UPB</td>

                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr>
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD1_739_VER01_PARAMETER02($post){

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

            $sql1='SELECT c.vteam ,u.vgenerik, u.`iupb_id`, u.`iGroup_produk` ,
                u.`vupb_nomor`,u.vupb_nama , a.dCreate, u.vKode_obat, u.iteammarketing_id  FROM plc2.`plc2_upb` u
                JOIN plc3.m_modul_log_activity a ON u.iupb_id=a.iKey_id
                JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
                JOIN plc2.plc2_upb_team c ON c.iteam_id = u.iteammarketing_id
                join plc2.group_marketing d ON d.iGroup_marketing=c.iGroup_marketing
                WHERE u.`ldeleted` = 0
                AND u.tinfo_paten IS NOT NULL
                AND u.tinfo_paten !=""
                AND u.iteammarketing_id IS NOT NULL
                AND u.`iteambusdev_id` = "4"
                AND a.iSort = 999
                AND a.iApprove = 2
                AND d.iGroup_marketing= 1 # Group Etichal
                AND a.dCreate >= "'.$perode1.'"
                AND a.dCreate <= "'.$perode2.'"
                
                ';

            $sql2 = ' order by u.iteammarketing_id';

            $sqlDetail = $sql1.$sql2;

                
            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>

                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Nama Generik</th>
                            <th>Team Marketing</th>
                            <th>Approval Direksi</th>
                        </tr>
            ";

            $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
            $i=0;
            foreach ($upbDetail as $ub) {
                 $i++;

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vgenerik']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vteam']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['dCreate']."</td>
                          </tr>";

            }

            $html .= "</table><br /> ";

            $detailMKT = '<table border="1" style="border:1px;border-collapse:collapse;">
                            <thead>
                                <th>
                                    No
                                </th>
                                <th>
                                    Marketing
                                </th>
                                <th>
                                    Jumlah UPB
                                </th>
                            </thead>
                            <tbody>';

            $sqlMar = 'select b.vteam,b.iteam_id 
                        from plc2.group_marketing a 
                        join plc2.plc2_upb_team b on b.iGroup_marketing=a.iGroup_marketing
                        where a.iGroup_marketing=1 AND b.iteam_id <> 8
                        AND b.iteam_id <> 29';                      
            $dMar = $this->db_erp_pk->query($sqlMar)->result_array();            
                            $no=1;
                            $retArr = array();
                            foreach ($dMar as $mar) {
                                $sqlCMkt = $sql1.' and iteammarketing_id = "'.$mar['iteam_id'].'"  ';

                                //echo $sqlCMkt;
                                $countMR = $this->db_erp_pk->query($sqlCMkt)->num_rows();

                                array_push($retArr, $countMR);
                                $detailMKT .= '<tr>
                                                    <td>'.$no.'</td>
                                                    <td style="text-align:left;">'.$mar['vteam'].'</td>
                                                    <td>'.$countMR.'</td>
                                              </tr>';
                                    
                                $no++;
                            }
            $detailMKT .=   '</tbody>
                        </table>';

                        $smallestMkt = min($retArr);

                        $result     = $smallestMkt;
                        $getpoint   = $this->getPoint($result,$iAspekId);
                        $x_getpoint = explode("~", $getpoint);
                        $point      = $x_getpoint['0'];
                        $warna      = $x_getpoint['1'];


            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 100%%;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB / Marketing</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$detailMKT." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Terkecil</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                        </tr>


                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }

    function BD1_739_VER01_PARAMETER03($post){
        // dari parameter 5 sebelumnya

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
                <table cellspacing='0' cellpadding='3' width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                    </tr>
                </table>";
        $sqlDetail='SELECT u.tinfo_paten, u.`iupb_id`, c.vNama_Group ,u.`iGroup_produk` , u.`vupb_nomor`, u.vupb_nama, u.vgenerik, a.dCreate, u.vKode_obat, d.vkategori, u.vgenerik  
            FROM plc2.`plc2_upb` u
            JOIN plc3.m_modul_log_activity a ON u.iupb_id=a.iKey_id
            JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
            JOIN plc2.master_group_produk c on u.`iGroup_produk` = c.imaster_group_produk
            JOIN plc2.plc2_upb_master_kategori_upb d ON d.ikategori_id = u.`ikategoriupb_id`
            WHERE u.`ldeleted` = 0
            AND u.`iteambusdev_id` = 4
            AND a.iSort = 999
            AND a.iApprove = 2
            and u.itipe_id <> 6
            and u.ldeleted = 0
            and u.iKill = 0
            AND a.dCreate >= "'.$perode1.'"
            AND a.dCreate <= "'.$perode2.'"
            ORDER BY u.`ikategoriupb_id`';


        $html .= "<table cellspacing='0' cellpadding='3' width='900px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Nama Generik</th>
                        <th>Group Produk</th>
                        <th>Kategori</th>
                        <th>Info Paten</th>
                        <th>Approval Direksi</th>
                    </tr>
        ";

        $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
        $i=0;
        $t_all = 0;
        $t_a  = 0;
        foreach ($upbDetail as $ub) {
             $i++;
             $col = "";
             $t_all++;
             if($ub['vkategori']=="A"){
               $t_a++;
               $col = "bgcolor='#C0C0C0'";
             }
             $html .= "<tr ".$col." style='border: 1px solid #dddddd; border-collapse: collapse; '>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:15%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:15%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vgenerik']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vNama_Group']."</td>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tinfo_paten']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dCreate']."</td>
                      </tr>";

        }
        if($t_all==0){
          $tot = 0;
        }else{
          $tot = ($t_a/$t_all) * 100;
        }
        $result     = number_format($tot,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Seluruh UPB</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$t_all." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori A</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$t_a." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Persentase UPB Kategori A</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format($tot,2)." %</td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }


    function BD1_739_VER01_PARAMETER06($post){
        // dari parameter 5 sebelumnya

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
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

         $sqPrareg = 'SELECT aa.* FROM (
                       SELECT z.*
                       FROM (
                           SELECT u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.iteambusdev_id, mku.vkategori, u.`ikategoriupb_id`,
                                     u.`vupb_nomor`,u.vupb_nama,if(u.ineed_prareg=1,"Ya", "Tidak") as needPrareg, DATE(la.dCreate) as appdir, if(u.ineed_prareg=1,u.tsubmit_prareg, u.tsubmit_reg) as tanggalSubmit,
                                ABS(datediff(la.dCreate, if(u.ineed_prareg=1,u.tsubmit_prareg, u.tsubmit_reg))) as selisih
                           FROM plc2.plc2_upb u
                         #  JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                             JOIN plc3.m_modul_log_activity la on la.iKey_id=u.iupb_id
                           JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                           JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                           JOIN hrd.employee e on e.cNip = la.cCreated
                           JOIN plc2.plc2_upb_master_kategori_upb mku ON u.ikategoriupb_id=mku.ikategori_id
                           WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0
                           AND u.iteambusdev_id = 4 
                           #AND u.istatus = 7
                           AND u.iappdireksi = 2
                           AND u.itipe_id <> 6
                           AND u.iKill = 0
                           and u.ldeleted = 0
                           AND la.iApprove=2
                           AND u.`ikategoriupb_id` = 10
                           and u.itipe_id <> 6
                       
                           AND (
                           case when u.ineed_prareg=1 then
                               u.tsubmit_prareg is not null
                               AND u.tsubmit_prareg >= "'.$perode1.'" 
                               AND u.tsubmit_prareg <= "'.$perode2.'" 
                           ELSE
                               u.tsubmit_reg is not null
                               AND u.tsubmit_reg >= "'.$perode1.'" 
                               AND u.tsubmit_reg <= "'.$perode2.'" 
                           END
                           )
                           UNION 
                          SELECT u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.iteambusdev_id, mku.vkategori, u.`ikategoriupb_id`,
                                     u.`vupb_nomor`,u.vupb_nama,if(u.ineed_prareg=1,"Ya", "Tidak") as needPrareg, DATE(la.dCreate) as appdir, if(u.ineed_prareg=1,u.tsubmit_prareg, u.tsubmit_reg) as tanggalSubmit,
                                ABS(datediff(la.dCreate, if(u.ineed_prareg=1,u.tsubmit_prareg, u.tsubmit_reg))) as selisih
                           FROM plc2.plc2_upb u
                       #    JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                           JOIN plc3.m_modul_log_activity la on la.iKey_id=u.iupb_id
                           JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules
                           JOIN hrd.employee e on e.cNip = la.cCreated
                           JOIN plc2.plc2_upb_master_kategori_upb mku ON u.ikategoriupb_id=mku.ikategori_id
                           JOIN plc2.tanggal_history_prareg_reg his on his.iupb_id=u.iupb_id
                           JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                           where u.ldeleted = 0 
                             AND la.lDeleted=0 
                             AND mo.lDeleted=0 
                             AND moa.lDeleted=0
                           AND u.iteambusdev_id = 4 
                             AND u.`ikategoriupb_id` = 10
                           AND u.iappdireksi = 2
                           AND u.itipe_id <> 6
                           AND la.iApprove=2
                           and moa.iType=3
                           and his.ldeleted=0
                           AND his.ijenis = 1
                           #Check Aktivity
                           and his.id IN (
                               select na.id_pk from ( 
                                       select ta.dtanggal,ta.id as id_pk 
                                           FROM plc2.tanggal_history_prareg_reg ta
                                           join plc2.plc2_upb up on up.iupb_id=ta.iupb_id 
                                           WHERE ta.ldeleted=0 
                                           AND (case when up.ineed_prareg=1 then
                                                ta.ijenis=1
                                            ELSE
                                                ta.ijenis=2
                                            END)
                                       group by ta.iupb_id 
                                       order by ta.id ASC                                
                                   ) as na
                                   Where na.dtanggal >= "'.$perode1.'"
                                   AND na.dtanggal <= "'.$perode2.'"
                           )
                     

                        ) AS z

                    #   ORDER BY z.nilai ASC

                    ) as aa GROUP BY aa.iupb_id
                    ORDER BY needPrareg
                    ';
        

       /* $sqPrareg = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, ua.tupdate, u.tsubmit_prareg  ,u.iteambusdev_id,kat.vkategori
                    FROM plc2.`plc2_upb` u
                        JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                        JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                        join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=u.ikategoriupb_id
                    WHERE u.`ldeleted` = 0 
                    AND u.tsubmit_prareg IS NOT NULL AND u.tsubmit_prareg <>"0000-00-00"
                    AND u.`iteambusdev_id` = 4
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.itipe_id <> 6
                    and u.ineed_prareg = 1
                    AND u.ldeleted = 0 
                    AND u.ikategoriupb_id = 10 # Kategori A
                    AND u.`tsubmit_prareg` >= "'.$perode1.'"
                    AND u.`tsubmit_prareg` <= "'.$perode2.'"
                    ';
*/
        $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Submit Prareg</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th> 
                        <th>Team Busdev</th> 
                        <th>Kategori</th> 
                        <th>Need Prareg</th> 
                        <th>Tanggal Approval Direksi</th>
                        <th>Tanggal Submit Prareg</th> 
                    </tr>
        "; 

        $cekDouble = array();
        $kurangTotal=0;
        $i=0;
        $total_parareg = 0;
        foreach ($upbPrareg as $ub) {
            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ub['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }

             $i++; 
             if (in_array($ub['iupb_id'], $cekDouble)) {
               $kurangTotal++;
            }
             array_push($cekDouble,$ub['iupb_id']);
             $total_parareg++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vkategori']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['needPrareg']."</td>    
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['appdir']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tanggalSubmit']."</td>
                        </tr>"; 

            

        } 
        $html .= "</table><br /> ";

        //-------------------------------------------------------------------------------------- INI REG



        $totalUpb  =$total_parareg; 
        $jumlahUpb = $totalUpb - $kurangTotal; 
        $result     = number_format($jumlahUpb);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total UPB Prareg & Reg</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalUpb." </td>
                    </tr>
                    
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }
    

    function BD1_739_VER01_PARAMETER07($post){
        // dari parameter 5 sebelumnya

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

        $sql1='SELECT aa.* FROM (
                SELECT z.*
                FROM (
                   SELECT ut.vteam, u.ikategoriupb_id, u.iupb_id, u.tinfo_paten,
                     u.iGroup_produk, u.vupb_nomor, u.vupb_nama , u.tsubmit_prareg, 
                     u.iteammarketing_id 
                   FROM plc2.plc2_upb u
                    JOIN plc2.plc2_upb_team ut on ut.iteam_id = u.iteammarketing_id
                    JOIN plc3.m_modul_log_activity la on la.iKey_id=u.iupb_id
                    JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                    JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                    JOIN hrd.employee e on e.cNip = la.cCreated
                    WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0
                    AND u.iteambusdev_id = 4 
                    AND u.iteammarketing_id IS NOT NULL
                    AND u.tsubmit_prareg IS NOT NULL
                    AND u.iappdireksi = 2
                    AND u.itipe_id <> 6
                    AND u.iKill = 0
                    and u.ldeleted = 0
                    AND la.iApprove=2
                    AND u.`ikategoriupb_id` = 10
                    and u.itipe_id <> 6
                    AND u.iteammarketing_id IS NOT NULL
                    AND u.tsubmit_prareg IS NOT NULL
                    AND (
                    case when u.ineed_prareg=1 then
                       u.tsubmit_prareg is not null
                       AND u.tsubmit_prareg >= "'.$perode1.'"
                       AND u.tsubmit_prareg <= "'.$perode2.'"
                    ELSE
                       u.tsubmit_reg is not null
                       AND u.tsubmit_reg >= "'.$perode1.'"
                       AND u.tsubmit_reg <= "'.$perode2.'"
                    END
                   )
                    UNION 
                        SELECT ut.vteam, u.ikategoriupb_id, u.iupb_id, u.tinfo_paten,
                             u.iGroup_produk, u.vupb_nomor, u.vupb_nama , u.tsubmit_prareg, 
                             u.iteammarketing_id 
                        FROM plc2.plc2_upb u
                        JOIN plc2.plc2_upb_team ut ON u.iteammarketing_id=ut.iteam_id
                        JOIN plc3.m_modul_log_activity la on la.iKey_id=u.iupb_id
                        JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules
                        JOIN hrd.employee e on e.cNip = la.cCreated
                        JOIN plc2.tanggal_history_prareg_reg his on his.iupb_id=u.iupb_id
                        JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort and moa.vDept_assigned="QA"
                        where u.ldeleted = 0 
                            AND la.lDeleted=0 
                            AND mo.lDeleted=0 
                            AND moa.lDeleted=0
                          AND la.iApprove=2
                           AND u.`ikategoriupb_id` = 10
                             AND u.iteambusdev_id = 4 
                          AND u.iappdireksi = 2
                          AND u.iteambusdev_id = 4 
                            AND u.iteammarketing_id IS NOT NULL
                             AND u.tsubmit_prareg IS NOT NULL
                            AND u.iappdireksi = 2
                            AND u.itipe_id <> 6
                            AND u.iKill = 0
                            and u.ldeleted = 0
                        AND u.itipe_id <> 6
                        and u.ineed_prareg=0
                        and la.iApprove=2
                        and la.lDeleted=0

                       #Check Aktivity
                           and his.id IN (
                               select na.id_pk from ( 
                                       select ta.dtanggal,ta.id as id_pk 
                                           FROM plc2.tanggal_history_prareg_reg ta 
                                           WHERE ta.ldeleted=0 
                                       group by ta.iupb_id 
                                       order by ta.id ASC                                
                                   ) as na
                                   Where na.dtanggal >= "'.$perode1.'"
                                   AND na.dtanggal <= "'.$perode2.'"
                           )

                    ) AS z
                ) as aa 
            ';

            $sql11= ' GROUP BY aa.iupb_id';

        /*$sql1='SELECT ut.vteam, u.`ikategoriupb_id`, u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , u.`tsubmit_prareg`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u
            JOIN plc2.plc2_upb_team ut on ut.iteam_id = u.iteammarketing_id
            JOIN plc3.m_modul_log_activity a ON u.iupb_id=a.iKey_id
            JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
            WHERE u.`ldeleted` = 0
            AND a.iSort = 999
            AND a.iApprove = 2
            AND a.lDeleted = 0
            AND b.lDeleted = 0
            AND u.`iteambusdev_id` = 4
            AND u.iteammarketing_id IS NOT NULL
            AND u.tsubmit_prareg IS NOT NULL
            and u.itipe_id <> 6
            AND u.`tsubmit_prareg` >= "'.$perode1.'"
            AND u.`tsubmit_prareg` <= "'.$perode2.'"
            ';*/

        $sql2= ' order by aa.iteammarketing_id';

        $sqlDetail = $sql1.$sql11.$sql2;

        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                      <th>No</th>
                      <th>No UPB</th>
                      <th>Nama UPB</th>
                      <th>Info Paten</th>
                      <th>Team Marketing</th>
                      <th>Tgl Prareg</th>
                    </tr>
        ";


        $i=0;
        $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
        foreach ($upbDetail as $ub) {
             $i++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tinfo_paten']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['vteam']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['tsubmit_prareg']."</td>
                      </tr>";

        }

                            $detailMKT = '<table border="1" style="border:1px;border-collapse:collapse;">
                            <thead>
                                <th>
                                    No
                                </th>
                                <th>
                                    Marketing
                                </th>
                                <th>
                                    Jumlah UPB
                                </th>
                            </thead>
                            <tbody>';

            $sqlMar = 'select b.vteam,b.iteam_id 
                        from plc2.group_marketing a 
                        join plc2.plc2_upb_team b on b.iGroup_marketing=a.iGroup_marketing
                        where a.iGroup_marketing=1 AND b.iteam_id <> 8
                        AND b.iteam_id <> 29';                      
            $dMar = $this->db_erp_pk->query($sqlMar)->result_array();            
                            $no=1;
                            $retArr = array();
                            foreach ($dMar as $mar) {
                                $sqlCMkt = $sql1.' where aa. iteammarketing_id = "'.$mar['iteam_id'].'"  '.$sql11;
                                //echo "<pre>". $sqlCMkt;exit();
                                //echo $sqlCMkt;
                                $countMR = $this->db_erp_pk->query($sqlCMkt)->num_rows();

                                array_push($retArr, $countMR);
                                $detailMKT .= '<tr>
                                                    <td>'.$no.'</td>
                                                    <td style="text-align:left;">'.$mar['vteam'].'</td>
                                                    <td>'.$countMR.'</td>
                                              </tr>';
                                    
                                $no++;
                            }
            $detailMKT .=   '</tbody>
                        </table>';

            $smallestMkt = min($retArr);
            $result     = $smallestMkt;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];



        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Seluruh UPB </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." UPB </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB / Marketing</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$detailMKT." Marketing</td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Terkecil</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." UPB /Divisi</td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD1_739_VER01_PARAMETER08($post){
        // dari parameter 7 sebelumnya

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

         
        $sqlRata = 'SELECT  pu.`vupb_nomor`,pu.vupb_nama, pu.tinfo_paten , d.vkategori , pu.`tsubmit_prareg`,
            pu.`ttarget_hpr` , ABS(datediff(pu.`ttarget_hpr`, pu.`tsubmit_prareg`)) as selisih,pu.iteambusdev_id
            FROM plc2.`plc2_upb` pu
            JOIN plc2.plc2_upb_master_kategori_upb d ON d.ikategori_id = pu.`ikategoriupb_id`
            JOIN plc3.m_modul_log_activity a ON pu.iupb_id=a.iKey_id
            JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
            WHERE
            pu.`ldeleted` = 0
            AND pu.`tsubmit_prareg` IS NOT NULL
            AND a.iSort = 999
            AND a.iApprove = 2
            AND a.lDeleted = 0
            AND b.lDeleted = 0
            AND pu.`ttarget_hpr` IS NOT NULL AND pu.`ttarget_hpr` <>"0000-00-00"
            AND pu.`ikategoriupb_id` = 10
            AND pu.`iteambusdev_id` = 4
            and pu.itipe_id <> 6
            AND pu.`ttarget_hpr` >= "'.$perode1.'"
            AND pu.`ttarget_hpr` <= "'.$perode2.'" ';  

        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <th>No</th>
                    <th>No UPB</th>
                    <th>Nama UPB</th> 
                    <th>Team Busdev</th> 
                    <th>Kategori UPB</th>
                    <th>Tanggal HPR</th>
                    <th>Tanggal Prareg</th>
                    <th>Selisih (Bulan)</th>
                    </tr>
        ";
 
        $upbDetail = $this->db_erp_pk->query($sqlRata)->result_array(); 
        $i = 0;
        $totalUpb=0;
        $totalSls=0;
        foreach ($upbDetail as $ub) { 
            
            //$selisih = $this->selisihHari($ub['tsubmit_prareg'],$ub['ttarget_hpr'],$cNipNya);
            $selisih = $this->getDurasiBulan($ub['tsubmit_prareg'],$ub['ttarget_hpr']);

            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ub['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }
             $i++;
             $totalUpb++;
             $totalSls += $selisih;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td> 
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['ttarget_hpr']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['tsubmit_prareg']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$selisih."</td>
                      </tr>"; 
        }

        $tot        = $totalSls/$totalUpb;   
        $result     = number_format($tot,2);
        //$result     = number_format(($result/22),2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalUpb." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih Bulan</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalSls." Bulan </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Rata-Rata Selisih Bulan</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan </td>
                    </tr> 
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD1_739_VER01_PARAMETER09($post){
        // dari parameter 5 sebelumnya

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

        $sql_pp = 'SELECT m.vNama_Group ,u.iGroup_produk, pb.vkategori , u.dinput_applet, u.`ikategoriupb_id`, 
                    u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , 
                    u.`tsubmit_prareg`, u.vKode_obat, u.iteammarketing_id 
                    FROM plc2.`plc2_upb` u 
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    JOIN plc3.m_modul_log_activity a ON u.iupb_id=a.iKey_id
                    JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 4 
                    AND a.iSort = 999
                    AND a.iApprove = 2
                    AND b.vKode_modul = "PL00001"
                    AND a.lDeleted = 0
                    AND b.lDeleted = 0
                    AND u.dinput_applet IS NOT NULL 
                    AND u.dinput_applet <>"0000-00-00"
                    AND u.`dinput_applet` >= "'.$perode1.'" 
                    AND u.`dinput_applet` <= "'.$perode2.'"  
                    AND u.`ikategoriupb_id` = 10 
                    AND u.iKill = 0
                    AND u.itipe_id <> 6
                    ORDER by u.iGroup_produk
                    '; 

         $sql_t = 'SELECT COUNT(DISTINCT(u.`iGroup_produk`)) AS t_upb FROM plc2.`plc2_upb` u 
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    JOIN plc3.m_modul_log_activity a ON u.iupb_id=a.iKey_id
                    JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 4 
                    AND a.iSort = 999
                    AND a.iApprove = 2
                    AND b.vKode_modul = "PL00001"
                    AND a.lDeleted = 0
                    AND b.lDeleted = 0
                     AND u.iKill = 0
                    AND u.dinput_applet IS NOT NULL 
                    AND u.dinput_applet <>"0000-00-00"
                    AND u.`dinput_applet` >= "'.$perode1.'" 
                    AND u.`dinput_applet` <= "'.$perode2.'" 
                    AND u.`ikategoriupb_id` = 10 
                    AND u.iKill = 0
                    AND u.itipe_id <> 6
                    ';
 

        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategori UPB</th>  
                          <th>Group Produk</th>
                          <th>Tgl Applet</th>
                    </tr>
        ";
        $i=0; 
        $upbDetail = $this->db_erp_pk->query($sql_pp)->result_array();
        foreach ($upbDetail as $ub) {
             $i++; 

             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vNama_Group']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dinput_applet']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        $jum = $this->db_erp_pk->query($sql_t)->row_array();
        if(empty($jum['t_upb'])){
            $result     = 0;
        }else{ 
            $result     = $jum['t_upb'];
        }
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Group Produk (Kategori A) </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Group Produk</td>
                    </tr> 
                </table><br/><br/>";
 

        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD1_739_VER01_PARAMETER11($post){
        // dari parameter 9 sebelumnya

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

        $sql_pp = 'SELECT m.vNama_Group ,u.iGroup_produk, pb.vkategori , u.dinput_applet, 
                    u.`ikategoriupb_id`, u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , 
                    u.`vupb_nomor`,u.vupb_nama , u.`tsubmit_prareg`, u.vKode_obat, u.iteammarketing_id 
                    FROM plc2.`plc2_upb` u 
                    JOIN plc3.m_modul_log_activity a ON u.iupb_id=a.iKey_id
                    JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 4 
                    AND u.dinput_applet IS NOT NULL 
                    AND a.iSort = 999
                    AND a.iApprove = 2
                    AND b.vKode_modul = "PL00001"
                    AND u.`dinput_applet` >= "'.$perode1.'" 
                    AND u.`dinput_applet` <= "'.$perode2.'" 
                    AND u.`ikategoriupb_id` = 11 
                    AND u.itipe_id <> 6
                    ORDER by u.iGroup_produk
                    '; 

         $sql_t = 'SELECT COUNT(DISTINCT(u.`iGroup_produk`)) AS t_upb FROM plc2.`plc2_upb` u 
                    JOIN plc3.m_modul_log_activity a ON u.iupb_id=a.iKey_id
                    JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 4 
                    AND u.dinput_applet IS NOT NULL 
                    AND a.iSort = 999
                    AND a.iApprove = 2
                    AND b.vKode_modul = "PL00001"
                    AND u.`dinput_applet` >= "'.$perode1.'" 
                    AND u.`dinput_applet` <= "'.$perode2.'" 
                    AND u.`ikategoriupb_id` = 11
                    AND u.itipe_id <> 6
                    ';
 

        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategori UPB</th>  
                          <th>Group Produk</th>
                          <th>Tgl Applet</th>
                    </tr>
        ";
        $i=0; 
        $upbDetail = $this->db_erp_pk->query($sql_pp)->result_array();
        foreach ($upbDetail as $ub) {
             $i++; 

             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vNama_Group']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dinput_applet']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        $jum = $this->db_erp_pk->query($sql_t)->row_array();
        if(empty($jum['t_upb'])){
            $result     = 0;
        }else{ 
            $result     = $jum['t_upb'];
        }
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Group Produk (Kategori B) </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Group Produk</td>
                    </tr> 
                </table><br/><br/>";
 

        echo $result."~".$point."~".$warna."~".$html;
    }

    //'ini PK Busdev 2'
    function BD2_739_VER01_PARAMETER01($post){
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

        $sql2='SELECT DISTINCT(u.`iGroup_produk`) as jml 
            FROM plc2.`plc2_upb` u
            JOIN plc3.m_modul_log_activity a ON u.iupb_id=a.iKey_id
            JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
            JOIN plc2.master_group_produk c ON u.iGroup_produk=c.imaster_group_produk
            WHERE 
            u.`ldeleted` = 0
            and a.lDeleted = 0
            AND b.lDeleted = 0
            AND c.lDeleted = 0
            AND u.`iteambusdev_id` = 22
            AND b.vKode_modul = "PL00001"
            AND a.iApprove = 2
            AND a.iSort = 999
            and u.iKill = 0
            AND a.dCreate >= "'.$perode1.'"
            AND a.dCreate <= "'.$perode2.'"
            ORDER BY u.iupb_id';


      //  $totDDS     = $dds;
        $totb       = $this->db_erp_pk->query($sql2)->num_rows();
        $result     = $totb;
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $sqlDetail='SELECT u.`iupb_id`, u.vgenerik, c.vNama_Group ,u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , a.dCreate, u.vKode_obat 
                    FROM plc2.plc2_upb u
                    JOIN plc3.m_modul_log_activity a ON u.iupb_id=a.iKey_id
                    JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
                    JOIN plc2.master_group_produk c ON u.iGroup_produk=c.imaster_group_produk
                    WHERE 
                    u.`ldeleted` = 0
                    and a.lDeleted = 0
                    AND b.lDeleted = 0
                    AND c.lDeleted = 0
                    AND u.`iteambusdev_id` = 22
                    AND b.vKode_modul = "PL00001"
                    AND a.iApprove = 2
                    AND a.iSort = 999
                    and u.iKill = 0
                    AND a.dCreate >= "'.$perode1.'"
                    AND a.dCreate <= "'.$perode2.'"
                    ORDER BY u.iGroup_produk';

           // echo '<pre>'.$sqlDetail;    

        $html .= "<table cellspacing='0' cellpadding='3' width='650px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Nama Generik</th>
                        <th>Group Produk</th>
                        <th>Approval Direksi</th>
                    </tr>
        ";

        $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
        $i=0;
        foreach ($upbDetail as $ub) {
             $i++;

             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vgenerik']."</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vNama_Group']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dCreate']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>

                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Group UPB</td>

                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                    </tr>
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_739_VER01_PARAMETER02($post){

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

            $sql1='SELECT c.vteam ,u.vgenerik, u.`iupb_id`, u.`iGroup_produk` ,
                    u.`vupb_nomor`,u.vupb_nama , a.dCreate, u.vKode_obat, u.iteammarketing_id  FROM plc2.`plc2_upb` u
                    JOIN plc3.m_modul_log_activity a ON u.iupb_id=a.iKey_id
                    JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
                    JOIN plc2.plc2_upb_team c ON c.iteam_id = u.iteammarketing_id
                    join plc2.group_marketing d ON d.iGroup_marketing=c.iGroup_marketing
                    WHERE u.`ldeleted` = 0
                    AND u.tinfo_paten IS NOT NULL
                    AND u.tinfo_paten !=""
                    AND u.iteammarketing_id IS NOT NULL
                    AND u.`iteambusdev_id` = "22"
                    AND a.iSort = 999
                    AND a.iApprove = 2
                    AND u.iKill = 0
                    AND d.iGroup_marketing= 1 # Group Etichal
                    AND a.dCreate >= "'.$perode1.'"
                    AND a.dCreate <= "'.$perode2.'"
                    
                    ';

            $sql2 = ' order by u.iteammarketing_id';

            $sqlDetail = $sql1.$sql2;

                
            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>

                            <th>No</th>
                            <th>No UPB</th>
                            <th>Nama UPB</th>
                            <th>Nama Generik</th>
                            <th>Team Marketing</th>
                            <th>Approval Direksi</th>
                        </tr>
            ";

            $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
            $i=0;
            foreach ($upbDetail as $ub) {
                 $i++;

                 $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vgenerik']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vteam']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['dCreate']."</td>
                          </tr>";

            }

            $html .= "</table><br /> ";

            $detailMKT = '<table border="1" style="border:1px;border-collapse:collapse;">
                            <thead>
                                <th>
                                    No
                                </th>
                                <th>
                                    Marketing
                                </th>
                                <th>
                                    Jumlah UPB
                                </th>
                            </thead>
                            <tbody>';

            $sqlMar = 'select b.vteam,b.iteam_id 
                        from plc2.group_marketing a 
                        join plc2.plc2_upb_team b on b.iGroup_marketing=a.iGroup_marketing
                        where a.iGroup_marketing=1 AND b.iteam_id IN ("8","29")';                      
            $dMar = $this->db_erp_pk->query($sqlMar)->result_array();            
                            $no=1;
                            $retArr = array();
                            foreach ($dMar as $mar) {
                                $sqlCMkt = $sql1.' and iteammarketing_id = "'.$mar['iteam_id'].'"  ';

                                //echo $sqlCMkt;
                                $countMR = $this->db_erp_pk->query($sqlCMkt)->num_rows();

                                array_push($retArr, $countMR);
                                $detailMKT .= '<tr>
                                                    <td>'.$no.'</td>
                                                    <td style="text-align:left;">'.$mar['vteam'].'</td>
                                                    <td>'.$countMR.'</td>
                                              </tr>';
                                    
                                $no++;
                            }
            $detailMKT .=   '</tbody>
                        </table>';

                        $smallestMkt = min($retArr);

                        $result     = $smallestMkt;
                        $getpoint   = $this->getPoint($result,$iAspekId);
                        $x_getpoint = explode("~", $getpoint);
                        $point      = $x_getpoint['0'];
                        $warna      = $x_getpoint['1'];


            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 100%%;'>
                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                            <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>

                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB / Marketing</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$detailMKT." </td>
                        </tr>

                        <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Terkecil</td>
                            <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." </td>
                        </tr>


                    </table><br/><br/>";


            echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_739_VER01_PARAMETER03($post){
        // dari parameter 5 sebelumnya

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
                <table cellspacing='0' cellpadding='3' width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                    </tr>
                </table>";
        $sqlDetail='SELECT u.tinfo_paten, u.`iupb_id`, c.vNama_Group ,u.`iGroup_produk` , u.`vupb_nomor`, u.vupb_nama, u.vgenerik, a.dCreate, u.vKode_obat, d.vkategori, u.vgenerik  
            FROM plc2.`plc2_upb` u
            JOIN plc3.m_modul_log_activity a ON u.iupb_id=a.iKey_id
            JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
            JOIN plc2.master_group_produk c on u.`iGroup_produk` = c.imaster_group_produk
            JOIN plc2.plc2_upb_master_kategori_upb d ON d.ikategori_id = u.`ikategoriupb_id`
            WHERE u.`ldeleted` = 0
            AND u.`iteambusdev_id` = 22
            AND a.iSort = 999   
            AND a.iApprove = 2
            and u.itipe_id <> 6
            and u.ldeleted = 0
            and u.iKill = 0
            AND a.dCreate >= "'.$perode1.'"
            AND a.dCreate <= "'.$perode2.'"
            ORDER BY u.`ikategoriupb_id`';


        $html .= "<table cellspacing='0' cellpadding='3' width='900px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th>
                        <th>Nama Generik</th>
                        <th>Group Produk</th>
                        <th>Kategori</th>
                        <th>Info Paten</th>
                        <th>Approval Direksi</th>
                    </tr>
        ";

        $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
        $i=0;
        $t_all = 0;
        $t_a  = 0;
        foreach ($upbDetail as $ub) {
             $i++;
             $col = "";
             $t_all++;
             if($ub['vkategori']=="A"){
               $t_a++;
               $col = "bgcolor='#C0C0C0'";
             }
             $html .= "<tr ".$col." style='border: 1px solid #dddddd; border-collapse: collapse; '>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:15%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:15%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vgenerik']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vNama_Group']."</td>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tinfo_paten']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dCreate']."</td>
                      </tr>";

        }
        if($t_all==0){
          $tot = 0;
        }else{
          $tot = ($t_a/$t_all) * 100;
        }
        $result     = number_format($tot,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Seluruh UPB</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$t_all." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Kategori A</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$t_a." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Persentase UPB Kategori A</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".number_format($tot,2)." %</td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

   function BD2_739_VER01_PARAMETER06($post){
        // dari parameter 5 sebelumnya

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
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

         $sqPrareg = 'SELECT aa.* FROM (
                       SELECT z.*
                       FROM (
                           SELECT u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.iteambusdev_id, mku.vkategori, u.`ikategoriupb_id`,
                                     u.`vupb_nomor`,u.vupb_nama,if(u.ineed_prareg=1,"Ya", "Tidak") as needPrareg, DATE(la.dCreate) as appdir, if(u.ineed_prareg=1,u.tsubmit_prareg, u.tsubmit_reg) as tanggalSubmit,
                                ABS(datediff(la.dCreate, if(u.ineed_prareg=1,u.tsubmit_prareg, u.tsubmit_reg))) as selisih
                           FROM plc2.plc2_upb u
                         #  JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                             JOIN plc3.m_modul_log_activity la on la.iKey_id=u.iupb_id
                           JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                           JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                           JOIN hrd.employee e on e.cNip = la.cCreated
                           JOIN plc2.plc2_upb_master_kategori_upb mku ON u.ikategoriupb_id=mku.ikategori_id
                           WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0
                           AND u.iteambusdev_id = 22
                           AND u.iappdireksi = 2
                           AND u.itipe_id <> 6
                           AND u.iKill = 0
                           and u.ldeleted = 0
                           AND la.iApprove=2
                           AND u.`ikategoriupb_id` = 10
                           and u.itipe_id <> 6
                       
                           AND (
                           case when u.ineed_prareg=1 then
                               u.tsubmit_prareg is not null
                               AND u.tsubmit_prareg >= "'.$perode1.'" 
                               AND u.tsubmit_prareg <= "'.$perode2.'" 
                           ELSE
                               u.tsubmit_reg is not null
                               AND u.tsubmit_reg >= "'.$perode1.'" 
                               AND u.tsubmit_reg <= "'.$perode2.'" 
                           END
                           )
                           UNION 
                          SELECT u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.iteambusdev_id, mku.vkategori, u.`ikategoriupb_id`,
                                     u.`vupb_nomor`,u.vupb_nama,if(u.ineed_prareg=1,"Ya", "Tidak") as needPrareg, DATE(la.dCreate) as appdir, if(u.ineed_prareg=1,u.tsubmit_prareg, u.tsubmit_reg) as tanggalSubmit,
                                ABS(datediff(la.dCreate, if(u.ineed_prareg=1,u.tsubmit_prareg, u.tsubmit_reg))) as selisih
                           FROM plc2.plc2_upb u
                       #    JOIN plc2.plc2_upb_prioritas_detail det on det.iupb_id=u.iupb_id
                           JOIN plc3.m_modul_log_activity la on la.iKey_id=u.iupb_id
                           JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules
                           JOIN hrd.employee e on e.cNip = la.cCreated
                           JOIN plc2.plc2_upb_master_kategori_upb mku ON u.ikategoriupb_id=mku.ikategori_id
                           JOIN plc2.tanggal_history_prareg_reg his on his.iupb_id=u.iupb_id
                           JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                           where u.ldeleted = 0 
                             AND la.lDeleted=0 
                             AND mo.lDeleted=0 
                             AND moa.lDeleted=0
                           AND u.iteambusdev_id = 22 
                             AND u.`ikategoriupb_id` = 10
                           AND u.iappdireksi = 2
                           AND u.itipe_id <> 6
                           AND la.iApprove=2
                           and moa.iType=3
                           and his.ldeleted=0
                           AND his.ijenis = 1
                           #Check Aktivity
                           and his.id IN (
                            select na.id_pk from ( 
                                    select ta.dtanggal,ta.id as id_pk 
                                        FROM plc2.tanggal_history_prareg_reg ta
                                        join plc2.plc2_upb up on up.iupb_id=ta.iupb_id 
                                        WHERE ta.ldeleted=0 
                                        AND (case when up.ineed_prareg=1 then
                                             ta.ijenis=1
                                         ELSE
                                             ta.ijenis=2
                                         END)
                                    group by ta.iupb_id 
                                    order by ta.id ASC                                
                                ) as na
                                Where na.dtanggal >= "'.$perode1.'"
                                AND na.dtanggal <= "'.$perode2.'"
                        )

                     

                        ) AS z

                    #   ORDER BY z.nilai ASC

                    ) as aa GROUP BY aa.iupb_id
                    ORDER BY needPrareg
                    ';
        

       /* $sqPrareg = 'SELECT u.vupb_nomor, u.iupb_id, u.vupb_nama, ua.tupdate, u.tsubmit_prareg  ,u.iteambusdev_id,kat.vkategori
                    FROM plc2.`plc2_upb` u
                        JOIN plc2.plc2_upb_approve ua ON ua.`iupb_id` = u.`iupb_id`
                        JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                        join plc2.plc2_upb_master_kategori_upb kat on kat.ikategori_id=u.ikategoriupb_id
                    WHERE u.`ldeleted` = 0 
                    AND u.tsubmit_prareg IS NOT NULL AND u.tsubmit_prareg <>"0000-00-00"
                    AND u.`iteambusdev_id` = 4
                    AND ua.`vtipe` = "DR"
                    AND ua.`iapprove` = 2
                    AND u.itipe_id <> 6
                    and u.ineed_prareg = 1
                    AND u.ldeleted = 0 
                    AND u.ikategoriupb_id = 10 # Kategori A
                    AND u.`tsubmit_prareg` >= "'.$perode1.'"
                    AND u.`tsubmit_prareg` <= "'.$perode2.'"
                    ';
*/
        $upbPrareg = $this->db_erp_pk->query($sqPrareg)->result_array();  
        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <th colspan='6' style='text-align: left;border: 1px solid #dddddd;' >Tanggal Submit Prareg</th> 
                    </tr>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <th>No</th>
                        <th>No UPB</th>
                        <th>Nama UPB</th> 
                        <th>Team Busdev</th> 
                        <th>Kategori</th> 
                        <th>Need Prareg</th> 
                        <th>Tanggal Approval Direksi</th>
                        <th>Tanggal Submit Prareg</th> 
                    </tr>
        "; 

        $cekDouble = array();
        $kurangTotal=0;
        $i=0;
        $total_parareg = 0;
        foreach ($upbPrareg as $ub) {
            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ub['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }

             $i++; 
             if (in_array($ub['iupb_id'], $cekDouble)) {
               $kurangTotal++;
            }
             array_push($cekDouble,$ub['iupb_id']);
             $total_parareg++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vupb_nama']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['vkategori']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['needPrareg']."</td>    
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['appdir']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$ub['tanggalSubmit']."</td>
                        </tr>"; 

            

        } 
        $html .= "</table><br /> ";

        //-------------------------------------------------------------------------------------- INI REG



        $totalUpb  =$total_parareg; 
        $jumlahUpb = $totalUpb - $kurangTotal; 
        $result     = number_format($jumlahUpb);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total UPB Prareg & Reg</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalUpb." </td>
                    </tr>
                    
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_739_VER01_PARAMETER07($post){
        // dari parameter 5 sebelumnya

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

         $sql1='SELECT aa.* FROM (
                SELECT z.*
                FROM (
                   SELECT ut.vteam, u.ikategoriupb_id, u.iupb_id, u.tinfo_paten,
                     u.iGroup_produk, u.vupb_nomor, u.vupb_nama , u.tsubmit_prareg, 
                     u.iteammarketing_id 
                   FROM plc2.plc2_upb u
                    JOIN plc2.plc2_upb_team ut on ut.iteam_id = u.iteammarketing_id
                    JOIN plc3.m_modul_log_activity la on la.iKey_id=u.iupb_id
                    JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules 
                    JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort 
                    JOIN hrd.employee e on e.cNip = la.cCreated
                    WHERE u.ldeleted = 0 AND la.lDeleted=0 AND mo.lDeleted=0 AND moa.lDeleted=0
                    AND u.iteambusdev_id = 22 
                    AND u.iteammarketing_id IS NOT NULL
                    AND u.tsubmit_prareg IS NOT NULL
                    AND u.iappdireksi = 2
                    AND u.itipe_id <> 6
                    AND u.iKill = 0
                    and u.ldeleted = 0
                    AND la.iApprove=2
                    AND u.`ikategoriupb_id` = 10
                    and u.itipe_id <> 6
                    AND u.iteammarketing_id IS NOT NULL
                    AND u.tsubmit_prareg IS NOT NULL
                    AND (
                    case when u.ineed_prareg=1 then
                       u.tsubmit_prareg is not null
                       AND u.tsubmit_prareg >= "'.$perode1.'"
                       AND u.tsubmit_prareg <= "'.$perode2.'"
                    ELSE
                       u.tsubmit_reg is not null
                       AND u.tsubmit_reg >= "'.$perode1.'"
                       AND u.tsubmit_reg <= "'.$perode2.'"
                    END
                   )
                    UNION 
                        SELECT ut.vteam, u.ikategoriupb_id, u.iupb_id, u.tinfo_paten,
                             u.iGroup_produk, u.vupb_nomor, u.vupb_nama , u.tsubmit_prareg, 
                             u.iteammarketing_id 
                        FROM plc2.plc2_upb u
                        JOIN plc2.plc2_upb_team ut ON u.iteammarketing_id=ut.iteam_id
                        JOIN plc3.m_modul_log_activity la on la.iKey_id=u.iupb_id
                        JOIN plc3.m_modul mo on mo.idprivi_modules=la.idprivi_modules
                        JOIN hrd.employee e on e.cNip = la.cCreated
                        JOIN plc2.tanggal_history_prareg_reg his on his.iupb_id=u.iupb_id
                        JOIN plc3.m_modul_activity moa on moa.iM_modul=mo.iM_modul and moa.iM_activity=la.iM_activity and la.iSort=moa.iSort and moa.vDept_assigned="QA"
                        where u.ldeleted = 0 
                            AND la.lDeleted=0 
                            AND mo.lDeleted=0 
                            AND moa.lDeleted=0
                          AND la.iApprove=2
                           AND u.`ikategoriupb_id` = 10
                             AND u.iteambusdev_id = 4 
                          AND u.iappdireksi = 2
                          AND u.iteambusdev_id = 4 
                            AND u.iteammarketing_id IS NOT NULL
                             AND u.tsubmit_prareg IS NOT NULL
                            AND u.iappdireksi = 2
                            AND u.itipe_id <> 6
                            AND u.iKill = 0
                            and u.ldeleted = 0
                        AND u.itipe_id <> 6
                        and u.ineed_prareg=0
                        and la.iApprove=2
                        and la.lDeleted=0
                       #Check Aktivity
                        and his.id IN (
                            select min(ta.id) as id_pk 
                        FROM plc2.tanggal_history_prareg_reg ta 
                        WHERE ta.ldeleted=0 
                        AND ta.ijenis=2 
                        AND ta.dtanggal >= "'.$perode1.'"
                        AND ta.dtanggal <= "'.$perode2.'"
                        group by ta.iupb_id 
                        order by ta.id ASC 
                        )

                    ) AS z
                ) as aa 
            ';

            $sql11= ' GROUP BY aa.iupb_id';

        /*$sql1='SELECT ut.vteam, u.`ikategoriupb_id`, u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , u.`tsubmit_prareg`, u.vKode_obat, u.iteammarketing_id FROM plc2.`plc2_upb` u
            JOIN plc2.plc2_upb_team ut on ut.iteam_id = u.iteammarketing_id
            JOIN plc3.m_modul_log_activity a ON u.iupb_id=a.iKey_id
            JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
            WHERE u.`ldeleted` = 0
            AND u.`iteambusdev_id` = 22
            AND a.iSort = 999
            AND a.iApprove = 2
            AND a.lDeleted = 0
            AND b.lDeleted = 0
            AND u.iKill = 0
            and u.itipe_id <> 6
            AND u.iteammarketing_id IS NOT NULL
            AND u.tsubmit_prareg IS NOT NULL
            AND u.`tsubmit_prareg` >= "'.$perode1.'"
            AND u.`tsubmit_prareg` <= "'.$perode2.'"
            ';
*/
        $sql2= ' order by aa.iteammarketing_id';

        $sqlDetail = $sql1.$sql2;

        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                      <th>No</th>
                      <th>No UPB</th>
                      <th>Nama UPB</th>
                      <th>Info Paten</th>
                      <th>Team Marketing</th>
                      <th>Tgl Prareg</th>
                    </tr>
        ";


        $i=0;
        $upbDetail = $this->db_erp_pk->query($sqlDetail)->result_array();
        foreach ($upbDetail as $ub) {
             $i++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['tinfo_paten']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['vteam']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['tsubmit_prareg']."</td>
                      </tr>";

        }

                            $detailMKT = '<table border="1" style="border:1px;border-collapse:collapse;">
                            <thead>
                                <th>
                                    No
                                </th>
                                <th>
                                    Marketing
                                </th>
                                <th>
                                    Jumlah UPB
                                </th>
                            </thead>
                            <tbody>';

            $sqlMar = 'select b.vteam,b.iteam_id 
                        from plc2.group_marketing a 
                        join plc2.plc2_upb_team b on b.iGroup_marketing=a.iGroup_marketing
                        where a.iGroup_marketing=1 AND b.iteam_id IN ("8","29")';                      
            $dMar = $this->db_erp_pk->query($sqlMar)->result_array();            
                            $no=1;
                            $retArr = array();
                            foreach ($dMar as $mar) {
                                $sqlCMkt = $sql1.' where aa. iteammarketing_id = "'.$mar['iteam_id'].'"  ';

                                
                                $countMR = $this->db_erp_pk->query($sqlCMkt)->num_rows();

                                array_push($retArr, $countMR);
                                $detailMKT .= '<tr>
                                                    <td>'.$no.'</td>
                                                    <td style="text-align:left;">'.$mar['vteam'].'</td>
                                                    <td>'.$countMR.'</td>
                                              </tr>';
                                    
                                $no++;
                            }
            $detailMKT .=   '</tbody>
                        </table>';

            $smallestMkt = min($retArr);
            $result     = $smallestMkt;
            $getpoint   = $this->getPoint($result,$iAspekId);
            $x_getpoint = explode("~", $getpoint);
            $point      = $x_getpoint['0'];
            $warna      = $x_getpoint['1'];



        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Seluruh UPB </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$i." UPB </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB / Marketing</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$detailMKT." Marketing</td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Terkecil</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." UPB /Divisi</td>
                    </tr>

                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_739_VER01_PARAMETER08($post){
        // dari parameter 7 sebelumnya

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

         
        $sqlRata = 'SELECT  pu.`vupb_nomor`,pu.vupb_nama, pu.tinfo_paten , d.vkategori , pu.`tsubmit_prareg`,
                    pu.`ttarget_hpr` , ABS(datediff(pu.`ttarget_hpr`, pu.`tsubmit_prareg`)) as selisih,pu.iteambusdev_id
                    FROM plc2.`plc2_upb` pu
                    JOIN plc2.plc2_upb_master_kategori_upb d ON d.ikategori_id = pu.`ikategoriupb_id`
                    JOIN plc3.m_modul_log_activity a ON pu.iupb_id=a.iKey_id
                    JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
                    WHERE
                    pu.`iteambusdev_id` = 22
                    AND pu.`ldeleted` = 0
                    AND pu.`tsubmit_prareg` IS NOT NULL
                    AND a.iSort = 999
                    AND a.iApprove = 2
                    AND a.lDeleted = 0
                    AND b.lDeleted = 0
                    AND pu.iKill = 0
                    AND pu.`ikategoriupb_id` = 10
                    and pu.itipe_id <> 6
                    AND pu.`ttarget_hpr` IS NOT NULL AND pu.`ttarget_hpr` <>"0000-00-00"
                    AND pu.`ttarget_hpr` >= "'.$perode1.'"
                    AND pu.`ttarget_hpr` <= "'.$perode2.'" ';  

        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>
                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <th>No</th>
                    <th>No UPB</th>
                    <th>Nama UPB</th> 
                    <th>Team Busdev</th> 
                    <th>Kategori UPB</th>
                    <th>Tanggal HPR</th>
                    <th>Tanggal Prareg</th>
                    <th>Selisih (Bulan)</th>
                    </tr>
        ";
 
        $upbDetail = $this->db_erp_pk->query($sqlRata)->result_array(); 
        $i = 0;
        $totalUpb=0;
        $totalSls=0;
        foreach ($upbDetail as $ub) { 
            
            //$selisih = $this->selisihHari($ub['tsubmit_prareg'],$ub['ttarget_hpr'],$cNipNya);
            $selisih = $this->getDurasiBulan($ub['tsubmit_prareg'],$ub['ttarget_hpr']);

            $sqlk ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$ub['iteambusdev_id']."'";
            $kat = $this->db_erp_pk->query($sqlk)->row_array();
            if(empty($kat['vteam'])){
                $k = '-';
            }else{
                $k = $kat['vteam'];
            }
             $i++;
             $totalUpb++;
             $totalSls += $selisih;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td> 
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['ttarget_hpr']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$ub['tsubmit_prareg']."</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                            ".$selisih."</td>
                      </tr>"; 
        }

        $tot        = $totalSls/$totalUpb;   
        $result     = number_format($tot,2);
        //$result     = number_format(($result/22),2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "</table><br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalUpb." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Selisih Bulan</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totalSls." Bulan </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Rata-Rata Selisih Bulan</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Bulan </td>
                    </tr> 
                </table><br/><br/>";


        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_739_VER01_PARAMETER09($post){
        // dari parameter 5 sebelumnya

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

        $sql_pp = 'SELECT u.iupb_id, m.vNama_Group ,u.iGroup_produk, pb.vkategori , u.dinput_applet, u.`ikategoriupb_id`, 
                    u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , u.`vupb_nomor`,u.vupb_nama , 
                    u.`tsubmit_prareg`, u.vKode_obat, u.iteammarketing_id 
                    FROM plc2.`plc2_upb` u 
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    JOIN plc3.m_modul_log_activity a ON u.iupb_id=a.iKey_id
                    JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 22 
                    AND a.iSort = 999
                    AND a.iApprove = 2
                    AND b.vKode_modul = "PL00001"
                    AND a.lDeleted = 0
                    AND b.lDeleted = 0
                    AND u.`ikategoriupb_id` = 10 
                    AND u.iKill = 0
                    AND u.itipe_id <> 6
                    AND u.dinput_applet IS NOT NULL 
                    AND u.dinput_applet <>"0000-00-00"
                    AND u.`dinput_applet` >= "'.$perode1.'" 
                    AND u.`dinput_applet` <= "'.$perode2.'" 
                    ORDER by u.iGroup_produk
                    '; 

         $sql_t = 'SELECT COUNT(DISTINCT(u.`iGroup_produk`)) AS t_upb FROM plc2.`plc2_upb` u 
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    JOIN plc3.m_modul_log_activity a ON u.iupb_id=a.iKey_id
                    JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 22 
                    AND a.iSort = 999
                    AND a.iApprove = 2
                    AND b.vKode_modul = "PL00001"
                    AND a.lDeleted = 0
                    AND b.lDeleted = 0
                    AND u.`ikategoriupb_id` = 10 
                    AND u.iKill = 0
                    AND u.itipe_id <> 6
                    AND u.dinput_applet IS NOT NULL 
                    AND u.dinput_applet <>"0000-00-00"
                    AND u.`dinput_applet` >= "'.$perode1.'" 
                    AND u.`dinput_applet` <= "'.$perode2.'" 
                    ';
 

        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategori UPB</th>  
                          <th>Group Produk</th>
                          <th>Tgl Applet</th>
                    </tr>
        ";
        $i=0; 
        $upbDetail = $this->db_erp_pk->query($sql_pp)->result_array();
        foreach ($upbDetail as $ub) {
             $i++; 

             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vNama_Group']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dinput_applet']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        $jum = $this->db_erp_pk->query($sql_t)->row_array();
        if(empty($jum['t_upb'])){
            $result     = 0;
        }else{ 
            $result     = $jum['t_upb'];
        }
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Group Produk (Kategori A) </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Group Produk</td>
                    </tr> 
                </table><br/><br/>";
 

        echo $result."~".$point."~".$warna."~".$html;
    }

    function BD2_739_VER01_PARAMETER11($post){
        // dari parameter 9 sebelumnya

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

        $sql_pp = 'SELECT u.iupb_id ,m.vNama_Group ,u.iGroup_produk, pb.vkategori , u.dinput_applet, 
                    u.`ikategoriupb_id`, u.tinfo_paten, u.`iupb_id`, u.`iGroup_produk` , 
                    u.`vupb_nomor`,u.vupb_nama , u.`tsubmit_prareg`, u.vKode_obat, u.iteammarketing_id 
                    FROM plc2.`plc2_upb` u 
                    JOIN plc3.m_modul_log_activity a ON u.iupb_id=a.iKey_id
                    JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 22 
                    AND u.dinput_applet IS NOT NULL 
                    AND a.iSort = 999
                    AND a.iApprove = 2
                    AND u.iKill = 0
                    AND b.vKode_modul = "PL00001"
                    AND u.itipe_id <> 6
                    AND u.`ikategoriupb_id` = 11 
                    AND u.`dinput_applet` >= "'.$perode1.'" 
                    AND u.`dinput_applet` <= "'.$perode2.'" 
                    ORDER by u.iGroup_produk
                    '; 

         $sql_t = 'SELECT COUNT(DISTINCT(u.`iGroup_produk`)) AS t_upb FROM plc2.`plc2_upb` u 
                    JOIN plc3.m_modul_log_activity a ON u.iupb_id=a.iKey_id
                    JOIN plc3.m_modul b ON a.idprivi_modules=b.idprivi_modules
                    JOIN plc2.plc2_upb_master_kategori_upb pb on pb.ikategori_id = u.`ikategoriupb_id`
                    JOIN plc2.master_group_produk m on u.`iGroup_produk` = m.imaster_group_produk
                    WHERE u.`ldeleted` = 0 
                    AND u.`iteambusdev_id` = 22 
                    AND u.dinput_applet IS NOT NULL 
                    AND a.iSort = 999
                    AND a.iApprove = 2
                    AND u.iKill = 0
                    AND b.vKode_modul = "PL00001"
                    AND u.itipe_id <> 6
                    AND u.`ikategoriupb_id` = 11 
                    AND u.`dinput_applet` >= "'.$perode1.'" 
                    AND u.`dinput_applet` <= "'.$perode2.'" 
                    ';
 

        $html = "
                <table width='750px'>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";


        $html .= "<table cellspacing='0' cellpadding='3' width='750px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                          <th>No</th>
                          <th>No UPB</th>
                          <th>Nama UPB</th>
                          <th>Kategori UPB</th>  
                          <th>Group Produk</th>
                          <th>Tgl Applet</th>
                    </tr>
        ";
        $i=0; 
        $upbDetail = $this->db_erp_pk->query($sql_pp)->result_array();
        foreach ($upbDetail as $ub) {
             $i++; 

             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$i."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nomor']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vupb_nama']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vkategori']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['vNama_Group']."</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            ".$ub['dinput_applet']."</td>
                      </tr>";

        }

        $html .= "</table><br /> ";

        $jum = $this->db_erp_pk->query($sql_t)->row_array();
        if(empty($jum['t_upb'])){
            $result     = 0;
        }else{ 
            $result     = $jum['t_upb'];
        }
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 500px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah Group Produk (Kategori B) </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$result." Group Produk</td>
                    </tr> 
                </table><br/><br/>";
 

        echo $result."~".$point."~".$warna."~".$html;
    }
    //Syukur End


}
?>
