<?php

class lib_pk_softdev
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

    function getPointEmpty($result, $iAspekId)
    {
        $sql = "select a.nPoint,(select cWarna FROM hrd.pk_warna
              WHERE iPoint=a.nPoint) as warna
              from hrd.pk_aspek_detail as a WHERE a.iAspekId='" . $iAspekId . "' and a.nPoint = 20";

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
    /*===============Start Function Softdev Manager=======================*/
    function SDM_getParameter1($post)
    {
        $iAspekId = $post['_iAspekId'];
        $cNipNya = $post['_cNipNya'];
        $iPkTransId = $post['_iPkTransId'];
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];

        $jenis = array(1 => 'UM', 2 => 'Claim');

        $bulan = $this->hitung_bulan($perode1, $perode2);

        $sql = "SELECT cTahun, iSemester FROM hrd.pk_trans WHERE id='" . $iPkTransId . "'";
        $query = $this->db_erp_pk->query($sql);
        $cTahun = $query->row()->cTahun;
        $iSemester = $query->row()->iSemester;


        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Size Project</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tgl Closing Project</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Status</b></td>
            </tr>
        ";

//a.dcloseGm between '" . $perode1 . "' and '" . $perode2 . "'
        $sqlto = "Select distinct a.id, a.problem_subject,
                case when a.iStatus =13 then a.iSizeProject else 0 end iSizeProject ,
                case when a.iStatus =13 then date(a.dcloseGm) else '-' end dcloseGm, c.cStatus
                from hrd.ss_raw_problems a
                inner join  hrd.ss_raw_pic b on a.id = b.rawid and b.pic = '" . $cNipNya . "' and iRoleId = 1
                left join hrd.ss_project_status c on a.iStatus = c.id
                where
                a.cSemester= '$iSemester' and a.cTahun = '$cTahun'
                and b.Deleted = 'No'  and a.eProject_priority = 'Y' order by iStatus desc";

        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $size = 0;
        if (!empty($b)) {
            foreach ($b as $v) {
                $size += $v['iSizeProject'];
                if (fmod($no, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }

                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $no . "</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['id'] . "</td>
                            <td style='width:50%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['problem_subject'] . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . $v['iSizeProject'] . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . $v['dcloseGm'] . "</td>
                            <td style='width:50%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['cStatus'] . "</td>
                          </tr>";
                $no++;
            }
        }

        $html .= "</table>";
        $total = $size;
        if ($total < 1) {
            $result = number_format(0, 0);
        } else {
            $result = number_format($total, 0);
        }

        $getpoint = $this->getPoint($total, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Size Project</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $result . "</b></td>
                    </tr>

                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }

    function SDM_getParameter2($post)
    {
        $iAspekId = $post['_iAspekId'];
        $cNipNya = $post['_cNipNya'];
        $iPkTransId = $post['_iPkTransId'];
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];

        $jenis = array(1 => 'UM', 2 => 'Claim');
        $bulan = $this->hitung_bulan($perode1, $perode2);

        $sql = "SELECT cTahun, iSemester FROM hrd.pk_trans WHERE id='" . $iPkTransId . "'";
        $query = $this->db_erp_pk->query($sql);
        $cTahun = $query->row()->cTahun;
        $iSemester = $query->row()->iSemester;
        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Size Project</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Est. Finish</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Act. Finish</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Selisih</b></td>

            </tr>
        ";

        //a.dcloseGm between '" . $perode1 . "' and '" . $perode2 . "'
        $sqlto = "Select distinct a.id, a.problem_subject, a.iSizeProject, date(a.dcloseGm) dcloseGm ,
                 c.cStatus, a.dTarget_implement,
                	CASE when date(a.dcloseGm) > date(a.dTarget_implement) then 'Ya'
                		else 'Tidak' end status
                 from hrd.ss_raw_problems a
                 inner join  hrd.ss_raw_pic b on a.id = b.rawid and b.pic = '" . $cNipNya . "' and iRoleId = 1
                 left outer join hrd.ss_project_status c on c.id = a.iStatus
                 where
                 a.cSemester= '$iSemester' and a.cTahun = '$cTahun' and b.Deleted = 'No' and
                 iStatus = 13  and a.eProject_priority = 'Y'";

        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 0;
        $tot_hasil = 0;
        $result =0;
        if (!empty($b)) {
            foreach ($b as $v) {
                $no++;
                $hasil=$this->selisihHari($v['dTarget_implement'],$v['dcloseGm'], $cNipNya);

                $tot_hasil += $hasil;

                if (fmod($no, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $no . "</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['id'] . "</td>
                            <td style='width:40%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['problem_subject'] . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . $v['iSizeProject'] . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . date('d-m-Y', strtotime($v['dTarget_implement'])) . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . date('d-m-Y', strtotime($v['dcloseGm'])) . "</td>
                            <td style='width:20%;text-align: center;border: 1px solid #dddddd;'>
                                " . $hasil . " Hari</td>

                          </tr>";

            }
        }

        $html .= "</table>";
        $total = ($tot_hasil / $no) ;

        $result = number_format($total, 2, '.', '');

        $getpoint = $this->getPoint($total, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Project</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $no . " Project</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $tot_hasil . " Hari</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Rata - rata</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $result . " Hari</b></td>
                    </tr>

                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }
    function SDM_getParameter3($post)
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
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SVN Name</b></td>
                <td style='border: 1px solid #dddddd;' ><b>File </b></td>
                <td style='border: 1px solid #dddddd;' ><b>LOC</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Commit Date</b></td>
            </tr>
        ";


        //Kategory A
        $sql = "select a.iCommitId, a.iSvnId,d.vName as appname,  a.vAuthor,c.vName, b.vFile,
            sum(b.iLOC)loc, a.tCommit, MONTH(a.tCommit) Bulan
            from hrd.svn_commit_header a
            left outer join hrd.svn_commit_detail b on a.iCommitId = b.iCommitId
            left outer join hrd.employee c on a.vAuthor = c.cNip
            left outer join hrd.svn_info d on d.iSvnId = a.iSvnId
            where a.tCommit between '" . $perode1 . "' and '" . $perode2 . "'
        and a.vAuthor = '" . $cNipNya . "'
        and b.vFile not in (select cd.vFile from hrd.svn_commit_detail cd
            	inner join hrd.svn_exclude  b on substr(cd.vFile,1,length(Trim(b.vFile))) = Trim(b.vFile))
            group by  a.iCommitId, a.iSvnId, a.vAuthor, c.vName, d.vName, b.vFile,a.tCommit";

        $b = $this->db_erp_pk->query($sql)->result_array();
        $no = 1;
        $loc = 0;
        if (!empty($b)) {
            foreach ($b as $v) {
                $loc += $v['loc'];
                if (fmod($no, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }

                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $no . "</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['appname'] . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['vFile'] . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['loc'] . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . date('d-m-Y', strtotime($v['tCommit'])) . "</td>
                          </tr>";
                $no++;
            }
        }

        $html .= "</table>";


        $result = number_format($loc, 2);
        $getpoint = $this->getPoint($loc, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total LOC</td>
                        
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>" . $result . "</td>
                    </tr>

                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }

    function SDM_getParameter4($post)
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
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Module Id </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Module Name </b></td>
                <td style='border: 1px solid #dddddd;' ><b>File</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Size</b></td>
            </tr>
        ";

        $sqlto = "select b.moduleId, c.V_MDL_NAME,  c.V_ATTACH, c.N_SIZE
            from hrd.ss_raw_problems a
            left outer join hrd.ss_raw_problems_module b on a.id = b.parentId
            left outer join hrd.prv_appmodules c on c.id = b.moduleId
            where a.activity_id = 24 and
            a.actual_finish between  '" . $perode1 . "' and '" . $perode2 . "' and
            a.pic = '" . $cNipNya . "'and c.N_SIZE > 0
            group by b.moduleId, c.V_MDL_NAME,  c.V_ATTACH, c.N_SIZE";

        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $selisih = 0;
        $size = 0;
        if (!empty($b)) {
            foreach ($b as $v) {
                $size += $v['N_SIZE'];
                if (fmod($no, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }

                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $no . "</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['moduleId'] . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['V_MDL_NAME'] . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['V_ATTACH'] . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['N_SIZE'] . "</td>
                          </tr>";
                $no++;
            }
        }

        $html .= "</table>";
        $total = $size;

        $result = number_format($total, 2);

        $getpoint = $this->getPoint($total, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
 
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Kontribusi Design</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>" . $result . " </b></td>
                    </tr>

                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }

    function SDM_getParameter5($post)
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
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>NIP </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama </b></td>
                <td style='border: 1px solid #dddddd;' ><b>AVG LOC</b></td>
            </tr>
        ";

        $bawah = $this->getInferior($cNipNya);

        $sqlto = "select min(loc)loc from (select a.vAuthor,c.vName, sum(b.iLOC)/6 loc
			from hrd.svn_commit_header a
			left outer join hrd.svn_commit_detail b on a.iCommitId = b.iCommitId
			left outer join hrd.employee c on a.vAuthor = c.cNip
			where a.tCommit between '" . $perode1 . "' and '" . $perode2 . "' and
			a.vAuthor in ('" . implode("','", $bawah) . "')	group by a.vAuthor)as hasil";

        $sqlmain =
            "select a.vAuthor,c.vName, sum(b.iLOC)/6 loc
			from hrd.svn_commit_header a
			left outer join hrd.svn_commit_detail b on a.iCommitId = b.iCommitId
			left outer join hrd.employee c on a.vAuthor = c.cNip
			where a.tCommit between '" . $perode1 . "' and '" . $perode2 . "' and
			a.vAuthor in ('" . implode("','", $bawah) . "')	group by a.vAuthor";

        $a = $this->db_erp_pk->query($sqlto)->result_array();
        $b = $this->db_erp_pk->query($sqlmain)->result_array();
        $no = 1;
        $selisih = 0;
        if (!empty($b)) {
            foreach ($b as $v) {

                if (fmod($no, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }
                $loc_result = number_format($v['loc'], 2);
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $no . "</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['vAuthor'] . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['vName'] . "</td>
                            <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                                $loc_result</td>

                          </tr>";
                $no++;

            }
        }
        $loc = 0;
        if (!empty($a)) {
            foreach ($a as $v) {
                $loc = $v['loc'];
            }
        }
        $html .= "</table>";
        $total = $loc;
        if ($total < 1) {
            $result = number_format(0, 2);
        } else {
            $result = number_format($total, 2);
        }


        $getpoint = $this->getPoint($total, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }    
    /*===============End Function Softdev Manager=======================*/
    /*===============Start Function Programmer Staff=======================*/
    function hitungPrg1($post)
    {
        $totalJamAll = 0;
        $totalReqAll = 0;
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
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Assign Time</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Actual Start</b></td> 
                <td style='border: 1px solid #dddddd;' ><b>Respond(Hour)</b></td> 
            </tr>
        ";

        $arrJadwal=$this->getJadwalKerja($cNipNya);

        $sqlto = "SELECT z.id,z.problem_subject, z.date_posted,z.assignTime, 
					z.actual_start,z.startDuration,z.input_date,z.commentType,
					z.vType, z.solution_id FROM (
					SELECT a.id,b.solution_id,a.problem_subject, a.date_posted,	Case when a.approveDate is not null then a.approveDate
						When a.assignTime is not null then a.assignTime  else a.date_posted end assignTime,
									a.actual_start,b.startDuration,b.input_date,b.commentType,
									b.vType,iGrp_activity_id
									FROM hrd.ss_raw_problems a 
									JOIN hrd.ss_solution b ON b.id = a.id
                                    JOIN hrd.ss_activity_type c on c.activity_id = a.activity_id
									WHERE b.pic = '" . $cNipNya . "' 
									And a.parent_id = 0
									AND DATE(a.date_posted) BETWEEN '" . $perode1 . "' AND '" . $perode2 . "'
									AND CASE WHEN (SELECT assign FROM hrd.ss_support_type WHERE typeId=a.typeId)='Y'
									    THEN (b.commentType = 3) END
									AND a.activity_id != 22
									AND (b.isDeleted = 0 OR b.isDeleted IS NULL)
                                    AND c.iGrp_activity_id = 20
					UNION
					SELECT a.id,b.solution_id,a.problem_subject, a.date_posted,	Case when a.approveDate is not null then a.approveDate
						When a.assignTime is not null then a.assignTime  else a.date_posted end assignTime,
									a.actual_start,b.startDuration,b.input_date,b.commentType,
									b.vType,c.iGrp_activity_id
									FROM hrd.ss_raw_problems a 
									JOIN hrd.ss_solution b ON b.id = a.id
                                    JOIN hrd.ss_activity_type c on c.activity_id = a.activity_id
									WHERE b.pic = '" . $cNipNya . "' 
									And a.parent_id = 0
									AND DATE(a.date_posted) BETWEEN '" . $perode1 . "' AND '" . $perode2 . "'
									AND b.commentType = 50
									AND a.activity_id != 22
									AND (b.isDeleted = 0 OR b.isDeleted IS NULL)
                                    AND c.iGrp_activity_id = 20
				) AS z
				GROUP BY z.id, z.vType
				ORDER BY z.date_posted,z.solution_id";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $size = 0;
        $noRow=0;
        if (!empty($rows)) {
			$jumlahRequest = count($rows);
			$totalJam = 0;
			
			$tmpData = array();            
            for($i=0;$i<$jumlahRequest;$i++) {
                $noRow++;
				$id = $rows[$i]['id'];
				$subject = $rows[$i]['problem_subject'];
				
				$date_posted = $rows[$i]['date_posted'];
				$assignTime = $rows[$i]['assignTime'];
				$actual_start = $rows[$i]['actual_start'];
				
				if( $rows[$i]['vType'] == 'Joblog' ) {
					$start_duration = (empty($assignTime)||strtotime($assignTime)<strtotime($date_posted))?$date_posted:$assignTime;
					$t_start_duration = strtotime($start_duration);
					
					$input_date = $rows[$i]['startDuration'];
					$t_input_date = strtotime($input_date);
				} else {
					$start_def = (empty($assignTime))?$date_posted:$assignTime;
					$start_duration = (empty($rows[$i]['startDuration']))?$start_def:$rows[$i]['startDuration'];
					$t_start_duration = strtotime($start_duration);
					
					$input_date = $rows[$i]['input_date'];
					$t_input_date = strtotime($input_date);
				}
				
				$date_start = $this->formatTimestamp($start_duration,'date');
				$dt_start = strtotime($date_start);
				$day_start = date('N',$dt_start);
				
				$date_respon = $this->formatTimestamp($input_date,'date');
				$dt_respon = strtotime($date_respon);
				$day_respon = date('N',$dt_respon);
				
				$hour_start = $this->formatTimestamp($start_duration,'hour');
				$ht_start = strtotime($hour_start);
				
				$hour_respon = $this->formatTimestamp($input_date,'hour');
				$ht_respon = strtotime($hour_respon);
				
				$jam_umum_masuk = $arrJadwal['umum']['masuk'];
				$t_jam_umum_masuk = strtotime($jam_umum_masuk);
				
				$jam_umum_keluar = $arrJadwal['umum']['keluar'];
				$t_jam_umum_keluar = strtotime($jam_umum_keluar);
				
				$jam_keluar_start = $arrJadwal[ $day_start ]['keluar'];
				$t_jam_keluar_start = strtotime($jam_keluar_start);
				
				$calcHour = 0;
				
				if( $dt_start == $dt_respon ) {// direspon di hari yang sama
					$calcHour = ( $ht_respon - $ht_start )/3600;
					$calcHour = ( $calcHour < 0 )? 0:$calcHour;
					
					if( $rows[$i]['vType'] == 'Joblog' ) {
						$tmpData[ $id ]['joblog'] = $calcHour;
					} else {
						$tmpData[ $id ]['followup'] = $calcHour;
					}
				} else { // direspon di hari yang berbeda
					
					$calcHour = $this->hitung_beda_hari( $t_start_duration, $t_input_date, $arrJadwal );
					$calcHour = $calcHour / 3600;
					$calcHour = ( $calcHour < 0 )? 0:$calcHour;
					
					if( $rows[$i]['vType'] == 'Joblog' ) {
						$tmpData[ $id ]['joblog'] = $calcHour;
					} else {
						$tmpData[ $id ]['followup'] = $calcHour;
					}
					$dateStart = date('Y-m-d H:i:s',$t_start_duration);
				}                
                
                if (fmod($noRow, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }
                
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $id . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $subject . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . $start_duration . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . $input_date . "</td>        
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . number_format( $calcHour, 2 ) . "</td>                                                        
                          </tr>";
                $no++;
            }
        }

        $html .= "</table>";

        $jumlahRequest = 0;
        if(count($tmpData)>0) {
            foreach( $tmpData as $tdKey => $tdVal ) {
                $x1 = 9999999999;
                if( isset($tdVal['joblog'])) {
                    $x1 = $tdVal['joblog'];
                }

                $x2 = 9999999999;
                if( isset($tdVal['followup'])) {
                    $x2 = $tdVal['followup'];
                }

                if( $x1 < $x2 ) {
                    $totalJam += $x1;
                    $jumlahRequest++;
                } else if( $x2 < $x1 ) {
                    $totalJam += $x2;
                    $jumlahRequest++;
                }
            }
        }
        $totalJamAll+=$totalJam;
        $totalReqAll+=$jumlahRequest;

        $hasil = $totalJam / $jumlahRequest;
        $hasil = number_format( $hasil, 2 );
        
        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Respond: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format( $totalJam, 2 )." Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Request: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$jumlahRequest."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " Jam</b></td>
                    </tr>
                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }

    function hitungPrg2($post)
    {
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

        $jenis = array(1 => 'UM', 2 => 'Claim');

        $bulan = $this->hitung_bulan($perode1, $perode2);

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Start</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Finish</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Duration</b></td>
            </tr>
        ";

        $arrJadwal=$this->getJadwalKerja($cNipNya);
        
        $sqlto = "SELECT a.id,a.problem_subject, a.date_posted,b.input_date,b.startDuration,b.commentType, a.actual_start,a.actual_finish,a.tMarkedAsFinished 
					FROM hrd.ss_raw_problems a
					JOIN hrd.ss_solution b ON b.id = a.id
					WHERE a.activity_id = 3 
						AND a.finishing_by = '" .$cNipNya. "' 
						AND b.pic = a.pic 
					AND b.commentType = 8
					AND DATE(a.date_posted) BETWEEN '" . $perode1 . "'AND LAST_DAY('" . $perode2 . "')
					ORDER BY a.date_posted";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 0;
        $tot_hasil = 0;
        $result =0;
        $jumlahRequest = count($rows);
        for($i=0;$i<$jumlahRequest;$i++) {
            $noRow++;
            $id = $rows[$i]['id'];
            $subject = $rows[$i]['problem_subject'];

            $date_posted = $rows[$i]['date_posted'];
            $start_duration = (empty($rows[$i]['startDuration']))?$date_posted:$rows[$i]['startDuration'];
            $t_start_duration = strtotime($start_duration);

            $input_date = $rows[$i]['input_date'];
            $t_input_date = strtotime($input_date);

            $date_start = $this->formatTimestamp($start_duration,'date');
            $dt_start = strtotime($date_start);
            $day_start = date('N',$dt_start);

            $date_respon = $this->formatTimestamp($input_date,'date');
            $dt_respon = strtotime($date_respon);
            $day_respon = date('N',$dt_respon);

            $hour_start = $this->formatTimestamp($start_duration,'hour');
            $ht_start = strtotime($hour_start);

            $hour_respon = $this->formatTimestamp($input_date,'hour');
            $ht_respon = strtotime($hour_respon);

            $jam_umum_masuk = $arrJadwal['umum']['masuk'];
            $t_jam_umum_masuk = strtotime($jam_umum_masuk);

            $jam_umum_keluar = $arrJadwal['umum']['keluar'];
            $t_jam_umum_keluar = strtotime($jam_umum_keluar);

            $jam_keluar_start = $arrJadwal[ $day_start ]['keluar'];
            $t_jam_keluar_start = strtotime($jam_keluar_start);

            $calcHour = 0;
            if( $dt_start == $dt_respon ) {// direspon di hari yang sama
                $calcHour = ( $ht_respon - $ht_start )/3600;
                $totalJam += $calcHour;
            } else { // direspon di hari yang berbeda
                if( $ht_start > $t_jam_keluar_start ) { // start duration > jam keluar pic
                    $t_start_duration = $this->addDay($t_start_duration,1);// + ke hari esok
                }
                $t_start_duration = $this->skipLibur($t_start_duration,$arrJadwal);

                $count_libur = $this->getJumlahHariLibur($t_start_duration,$t_input_date,$arrJadwal);

                $t_start_duration+=$count_libur;

                $calcHour = ( $t_input_date - $t_start_duration ) / 3600;
                $totalJam += $calcHour;
            }
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }            
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $id . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $start_duration . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $input_date . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . number_format( $calcHour, 2 ) . " Jam</td>

                      </tr>";

            }

        $html .= "</table>";
        
        $hasil = $totalJam / $jumlahRequest;
        $hasil = number_format( $hasil, 2 );
                

        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Respond: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format( $totalJam, 2 ) . " Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Request: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jumlahRequest . " Hari</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " Jam</b></td>
                    </tr>

                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }
    
   function hitungPrg3($post)
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
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<b>Task Yang Rework</b>";
        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No </b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject </b></td>
            </tr>
        "; 

        $sql = "SELECT a.activity_id,a.id,b.commentType,a.problem_subject, a.date_posted,b.input_date, b.startDuration,
                a.actual_start,a.actual_finish,a.estimated_start,a.estimated_finish,a.updateSchedule
				FROM hrd.ss_raw_problems a
				LEFT JOIN hrd.ss_solution b ON b.id = a.id
				WHERE a.pic = '".$cNipNya."'
				AND a.activity_id IN(5,6)
				AND DATE(a.date_posted) BETWEEN '" . $perode1 . "' AND LAST_DAY('" . $perode2 . "')
				AND b.commentType=6 GROUP BY a.id
				ORDER BY a.id";

        $b = $this->db_erp_pk->query($sql)->result_array();
        $no = 1;
        $loc = 0;
        $x=count($b);
        if (!empty($b)) {
           
            foreach ($b as $v) {
                if (fmod($no, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }

                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $no . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['id'] . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['problem_subject'] . "</td>
                          </tr>";
                $no++;
            }
        }else{
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;'></td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'></td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'></td>
                          </tr>";            
        }

        $html .= "</table>";

        $html .= "<b>Task Yang Finish</b>";
        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No </b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject </b></td>
            </tr>
        "; 
        $sql = "SELECT a.activity_id,a.id,b.commentType,a.problem_subject, a.date_posted,b.input_date, b.startDuration,
                a.actual_start,a.actual_finish,a.estimated_start,a.estimated_finish,a.updateSchedule
				FROM hrd.ss_raw_problems a
				LEFT JOIN hrd.ss_solution b ON b.id = a.id
				WHERE a.pic = '".$cNipNya."'
				AND a.activity_id IN(5,6)
				AND DATE(a.date_posted) BETWEEN '" . $perode1 . "' AND LAST_DAY('" . $perode2 . "')
				AND b.commentType=8 GROUP BY a.id
				ORDER BY a.id";

        $b = $this->db_erp_pk->query($sql)->result_array();
        $no = 1;
        $loc = 0;
        $y=count($b);
        if (!empty($b)) {
           
            foreach ($b as $v) {
                if (fmod($no, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }

                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $no . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['id'] . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['problem_subject'] . "</td>
                          </tr>";
                $no++;
            }
        }else{
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;'></td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'></td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'></td>
                          </tr>";            
        }

        $html .= "</table>";
        
        $result = ($x/$y);
        $result = number_format( $result, 2);
        
        $getpoint = $this->getPoint($result, $iAspekId);
        
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Rework: </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>" . $x . "</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Task yg Finish: </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>" . $y . "</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>" . $result . "</td>
                    </tr>                    
                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }

    function hitungPrg4($post)
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

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Module Id</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Module Name</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Actual Finish</b></td>
            </tr>
        ";

        $sqlto = "SELECT b.id,a.moduleId,b.problem_subject,b.date_posted,b.estimated_finish,b.actual_start,b.actual_finish,c.V_MDL_NAME
					FROM hrd.ss_raw_problems_module a
					JOIN hrd.ss_raw_problems b ON b.id = a.parentId
					LEFT JOIN hrd.prv_appmodules c on c.ID = a.moduleId
					WHERE 
					b.requestor = '".$cNipNya."'
					AND b.activity_id =5
					AND b.actual_finish BETWEEN '".$perode1."' AND LAST_DAY('".$perode2."')
					GROUP BY id, moduleId
					ORDER BY b.actual_finish, a.parentId";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;

        $jumlahRequest = count($rows);
        $c_datapermonth = array();
        $c_nippermonth = array();        
        for($i=0;$i<$jumlahRequest;$i++) {
            if (fmod($no, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }
            $data_id = $rows[$i]['id'];
            $module_name = $rows[$i]['V_MDL_NAME'];
            $module_id = $rows[$i]['moduleId'];
            $subject = $rows[$i]['problem_subject'];
            $actual_finish = $rows[$i]['actual_finish'];
            $t_actual_finish = strtotime($actual_finish);                
                
            $month = date('n', $t_actual_finish);
            $c_datapermonth[$month][$data_id] = 1;
            $c_nippermonth[$month][$cNipNya] = 1;                
 
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $no . "</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $data_id . "</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $module_id . "</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $module_name . "</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $actual_finish . "</td>
                      </tr>";
            $no++;
        }

        $html .= "</table>";

        $m_start = date('n',strtotime($perode1));//get month in numeric
        $m_end = date('n',strtotime($perode2));//get month in numeric
        $jml_bulan = 0;
        for ($i = $m_start; $i <= $m_end; $i++) {
            $jml_bulan++;
        }

        $hasil = $jumlahRequest/$jml_bulan;
        $result = number_format($hasil,2);

        $getpoint = $this->getPoint($result, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
 
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Module yang diselesaikan (a)</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>" . $jumlahRequest . " </b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result (a / " .$jml_bulan. ")</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>" . $result . " </b></td>
                    </tr>
                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }

    function hitungPrg5($post){
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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Module Id</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Module Name</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Actual Finish</b></td>
            </tr>
        ";

        $sqlto = "SELECT b.id,a.moduleId,b.problem_subject,b.date_posted,b.estimated_finish,b.actual_start,b.actual_finish,c.V_MDL_NAME
					FROM hrd.ss_raw_problems_module a
					JOIN hrd.ss_raw_problems b ON b.id = a.parentId
					LEFT JOIN hrd.prv_appmodules c on c.ID = a.moduleId
					WHERE
					b.requestor = '".$cNipNya."'
					AND b.activity_id =6
					AND b.actual_finish BETWEEN '".$perode1."' AND LAST_DAY('".$perode2."')
					GROUP BY id, moduleId
					ORDER BY b.actual_finish, a.parentId";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;

        $jumlahRequest = count($rows);
        $c_datapermonth = array();
        $c_nippermonth = array();
        for($i=0;$i<$jumlahRequest;$i++) {
            if (fmod($no, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }
            $data_id = $rows[$i]['id'];
            $module_name = $rows[$i]['V_MDL_NAME'];
            $module_id = $rows[$i]['moduleId'];
            $subject = $rows[$i]['problem_subject'];
            $actual_finish = $rows[$i]['actual_finish'];
            $t_actual_finish = strtotime($actual_finish);

            $month = date('n', $t_actual_finish);
            $c_datapermonth[$month][$data_id] = 1;
            $c_nippermonth[$month][$cNipNya] = 1;

            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $no . "</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $data_id . "</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $module_id . "</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $module_name . "</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $actual_finish . "</td>
                      </tr>";
            $no++;
        }

        $html .= "</table>";

        $m_start = date('n',strtotime($perode1));//get month in numeric
        $m_end = date('n',strtotime($perode2));//get month in numeric
        $jml_bulan = 0;
        for ($i = $m_start; $i <= $m_end; $i++) {
            $jml_bulan++;
        }

        $hasil = $jumlahRequest/$jml_bulan;
        $result = number_format($hasil,2);

        $getpoint = $this->getPoint($result, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Module yang diselesaikan (a)</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>" . $jumlahRequest . " </b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result (a / " .$jml_bulan. ")</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>" . $result . " </b></td>
                    </tr>
                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }
    function hitungPrg6($post){
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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Blame Id </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Svn Id </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Rev.No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Blame Rev.No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Author</b></td>
                <td style='border: 1px solid #dddddd;' ><b>File</b></td>                
            </tr>
        ";

        $sqlto = "select bh.* from hrd.svn_blame_header bh
					inner join (select cd.iRevisionNumber,cd.iSvnId from hrd.svn_commit_detail cd where cd.iCommitId in(
							select ch.iCommitId from hrd.svn_commit_header ch
						where right(ch.vVersion,2)<> '.0' AND ch.vAuthor = '$cNipNya' AND
						date(ch.tLaunch) between '$perode1' and '$perode2')) c on c.iRevisionNumber = bh.iRevisionNumber and
						c.iSvnId=bh.iSvnId
						and bh.vAuthor <> '$cNipNya'
				group by bh.iRevisionNumber,bh.iSvnId
				order by bh.iRevisionNumber";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $noRow = 0;

        $jumlahRequest = count($rows);
        for($i=0;$i<$jumlahRequest;$i++) {
            $noRow++;
            $iBlameId = $rows[$i]['iBlameId'];
            $iSvnId = $rows[$i]['iSvnId'];
            $iRevisionNumber = $rows[$i]['iRevisionNumber'];
            $iBlamedRevNumber = $rows[$i]['iBlamedRevNumber'];
            $vAuthor = $rows[$i]['vAuthor'];
            $vFile = $rows[$i]['vFile'];

            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $iBlameId . "</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $iSvnId . "</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $iRevisionNumber . "</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $iBlamedRevNumber . "</td>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $vAuthor . "</td>
                        <td style='width:30%;text-align: left;border: 1px solid #dddddd;'>
                            " . $vFile . "</td>                            
                      </tr>";
                      
        }

        $html .= "</table>";

        $m_start = date('n',strtotime($perode1));//get month in numeric
        $m_end = date('n',strtotime($perode2));//get month in numeric
        $jml_bulan = 0;
        for ($i = $m_start; $i <= $m_end; $i++) {
            $jml_bulan++;
        }

        $hasil = $jumlahRequest/$jml_bulan;
        $result = number_format($hasil,2);

        $getpoint = $this->getPoint($result, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>" . $jumlahRequest . " </b></td>
                    </tr>

                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }    

    function hitungPrg7($post)
    {
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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Est. Start</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Est. Finish</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Created Date</b></td>
            </tr>
        ";

        //$arrJadwal=$this->getJadwalKerja($cNipNya);
        
        $sqlto = "SELECT a.id,a.problem_subject,a.date_posted,x.tCreatedAt updateSchedule,x.estimated_start,x.estimated_finish,a.actual_start,a.actual_finish
					FROM hrd.ss_raw_problems a
                    left outer join hrd.ss_activity_type aty on aty.activity_id = a.activity_id
					LEFT OUTER JOIN (SELECT h.iSSID,h.cPIC, max(h.iScheduleFreq)iScheduleFreq, max(h.tCreatedAt)tCreatedAt,min(d.dDate) estimated_start, max(d.dDate)estimated_finish
							FROM 	hrd.ss_task_scheduling h
							left outer join hrd.ss_task_scheduling_detail d on h.iSSID = d.iSSID and h.cPIC = d.cPIC and h.iScheduleType = d.iScheduleType
						and h.iScheduleFreq = d.iScheduleFreq
							WHERE h.cPic = '$cNipNya'  and h.iSSID in (SELECT a.id FROM hrd.ss_raw_problems a
											WHERE a.pic = '$cNipNya'  AND DATE(a.date_posted) BETWEEN '$perode1' AND LAST_DAY('$perode2'))
									and h.tApproved2 IS NOT NULL
							Group by h.iSSID,h.cPIC
							order by h.iSSID,h.cPIC	) x ON x.iSSID = a.id
					WHERE a.pic = '$cNipNya'
						AND DATE(a.date_posted) BETWEEN '$perode1' AND LAST_DAY('$perode2')
                        	and left(aty.activity,2) <> 'DS' and a.activity_id not in (22,0)
					ORDER BY a.id";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 0;
        $scheduled = 0;
        $result =0;
        $jumlahRequest = count($rows);
        for($i=0;$i<$jumlahRequest;$i++) {
            $noRow++;
            $id = $rows[$i]['id'];
            $subject = $rows[$i]['problem_subject'];
            $date_posted = $rows[$i]['date_posted'];

            $actual_start = $rows[$i]['actual_start'];
            $t_actual_start = strtotime($actual_start);
            $d_actual_start = date('Y-m-d',$t_actual_start);

            $estimated_start = $rows[$i]['estimated_start'];
            $t_estimated_start = strtotime($estimated_start);
            $d_estimated_start = $t_estimated_start ? date('Y-m-d',$t_estimated_start) :'';
            $td_estimated_start = strtotime($d_estimated_start);

            $estimated_finish = $rows[$i]['estimated_finish'];
            $t_estimated_finish = strtotime($estimated_finish);
            $d_estimated_finish = $t_estimated_finish ? date('Y-m-d',$t_estimated_finish) : '';
            $td_estimated_finish = strtotime($d_estimated_finish);

            $updateSchedule = $rows[$i]['updateSchedule'];
            $t_updateSchedule = strtotime($updateSchedule);
            $d_updateSchedule = $t_updateSchedule ? date('Y-m-d',$t_updateSchedule) :'';
            $td_updateSchedule = strtotime($d_updateSchedule);

            if( !empty($d_estimated_finish) && !empty($d_estimated_start) )
            {
                $scheduled++;
                //if ($d_updateSchedule < $d_actual_start){
                //    $scheduled++;
                //}

            }
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }            
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $id . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $d_estimated_start . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $d_estimated_finish . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $d_updateSchedule . "</td>

                      </tr>";

            }

        $html .= "</table>";
        
        $hasil = number_format( ($scheduled / $jumlahRequest) * 100, 2 );        

        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Task yg Terjadwalkan: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $scheduled . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Seluruh Task: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jumlahRequest . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " %</b></td>
                    </tr>

                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }
    function hitungPrg8($post)
    {
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
        
        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Est. Finish</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Finish Date</b></td>
            </tr>
        ";

        //$arrJadwal=$this->getJadwalKerja($cNipNya);
        
        $sqlto = "SELECT a.history_id, a.id, b.problem_subject, a.activity_id, a.estimated_finish,
				  a.actual_finish,a.date_posted,a.actual_start,a.activity_id,b.activity_id
				  FROM hrd.ss_raw_history a
				  LEFT JOIN hrd.ss_raw_problems b ON b.id = a.id
				  WHERE a.finishing_by ='$cNipNya' AND a.estimated_finish IS NOT NULL AND
				  DATE(a.actual_finish) BETWEEN '$perode1' AND LAST_DAY('$perode2')
				  AND b.activity_id NOT IN (22, 37)
				  ORDER BY a.history_id,a.id";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        foreach($rows as $row) {
            //$noRow++;
            $history_id = $row['history_id'];
            $raw_id = $row['id'];
            $subject = $row['problem_subject'];
            $est_finish = $row['estimated_finish'];
            $act_finish = $row['actual_finish'];
            $act_start  = $row['actual_start'];
            $date_posted = $row['date_posted'];

            $data_container[ $raw_id ][] = array('problem_subject'=>$subject,'est_finish'=>$est_finish,'act_finish'=>$act_finish,'act_start'=>$act_start,'date_posted'=>$date_posted);

        }        
        
        foreach($data_container as $raw_id => $data) {
            $noRow++;
            $jumlahDataPerId = count( $data_container[ $raw_id ] );

            if( $jumlahDataPerId > 3 ) {
                //$dump = end( $data_container[ $raw_id ] );
                $est_ = $data_container[ $raw_id ][3]['est_finish'];
                $act_ = $data_container[ $raw_id ][3]['act_finish'];
                $act2_ = $data_container[ $raw_id ][3]['act_start'];
                $date_ = $data_container[ $raw_id ][3]['date_posted'];

                $data_stored[$cNipNya][ $raw_id ]['est_finish'] = $est_;
                $data_stored[$cNipNya][ $raw_id ]['act_finish'] = $act_;
                $data_stored[$cNipNya][ $raw_id ]['act_start'] = $act2_;
                $data_stored[$cNipNya][ $raw_id ]['date_posted'] = $date_;
            }
            else {
                $dump = end( $data_container[ $raw_id ] );

                $data_stored[$cNipNya][ $raw_id ]['est_finish'] = $dump['est_finish'];
                $data_stored[$cNipNya][ $raw_id ]['act_finish'] = $dump['act_finish'];
                $data_stored[$cNipNya][ $raw_id ]['act_start'] = $dump['act_start'];
                $data_stored[$cNipNya][ $raw_id ]['date_posted'] = $dump['date_posted'];
            }
            $data_stored[$cNipNya][ $raw_id ]['problem_subject'] = $dump['problem_subject'];
                        
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }            
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $raw_id . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $dump['problem_subject'] . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $dump['est_finish'] . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $dump['act_finish'] . "</td>

                      </tr>";

            }

        $html .= "</table>";
        $hasil = $this->prosesHitPrg8( $data_stored );

        $total_hasil = $data_tepat = $data_all = 0;
        $data_tepat = isset($hasil['data_tepat'])?$hasil['data_tepat']:$data_tepat;
        $data_all = isset($hasil['data_all'])?$hasil['data_all']:$data_all;
        if( $data_all > 0 ) {
            $total_hasil = number_format($data_tepat/$data_all*100, 2);
        } else {
            $total_hasil = 0;
        }
        
        $getpoint = $this->getPoint($total_hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];
                
        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Task Sesuai Jadwal: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $data_tepat . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Seluruh Task: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $data_all . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $total_hasil . " %</b></td>
                    </tr>

                </table>";
        echo $total_hasil . "~" . $point . "~" . $warna . "~" . $html;
    }    
    
    function hitungPrg9($post)    {
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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
            </tr>
        ";
        
        $commentType = 5;
        $sqlto = "SELECT a.confirm_date,a.satisfaction_value,a.id,b.commentType,
                  a.problem_subject, a.date_posted,b.input_date, b.startDuration,
                  a.actual_start,a.actual_finish,a.estimated_start,a.estimated_finish,a.updateSchedule
				    FROM hrd.ss_raw_problems a
				        JOIN hrd.ss_solution b ON b.id = a.id
				    WHERE a.pic = '$cNipNya' 
				        AND DATE(a.date_posted) BETWEEN '$perode1' AND LAST_DAY('$perode2')
				        AND b.commentType = $commentType
				        AND a.confirm_date IS NOT NULL
				    GROUP BY a.id ORDER BY a.id";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $html .= "<b>Jumlah Task Yang Rework</b>";
        $noRow = 0;
        foreach($rows as $row) {
            $noRow++;
            $raw_id = $row['id'];
            $subject = $row['problem_subject'];
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }            
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $raw_id . "</td>
                        <td style='width:75%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>
    
                      </tr>";            
    
        }        
        $html .= "</table>";
        $jml_rework = $noRow;
        
        $html .= "<br /> ";
        
        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
            </tr>
        ";        
        $commentType = 8;
        $sqlto = "SELECT a.confirm_date,a.satisfaction_value,a.id,b.commentType,
                  a.problem_subject, a.date_posted,b.input_date, b.startDuration,
                  a.actual_start,a.actual_finish,a.estimated_start,a.estimated_finish,a.updateSchedule
				    FROM hrd.ss_raw_problems a
				        JOIN hrd.ss_solution b ON b.id = a.id
				    WHERE a.pic = '$cNipNya' 
				        AND DATE(a.date_posted) BETWEEN '$perode1' AND LAST_DAY('$perode2')
				        AND b.commentType = $commentType
				        AND a.confirm_date IS NOT NULL
				    GROUP BY a.id ORDER BY a.id";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $noRow = 0;
        $html .= "<b>Jumlah Task Yang Finish</b>";
        foreach($rows as $row) {
            $noRow++;
            $raw_id = $row['id'];
            $subject = $row['problem_subject'];
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }            
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $raw_id . "</td>
                        <td style='width:75%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>
    
                      </tr>";            
        }        
        $html .= "</table>";
        $jml_finish = $noRow;   

        $hasil = number_format( ($jml_rework / $jml_finish) * 100, 2 );

        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];
                
        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah task yang rework: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jml_rework . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah task yang finish: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jml_finish . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " %</b></td>
                    </tr>

                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }

    function hitungPrg10($post)    {
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

        $dayCount = 0;
        $hasWeeklyScheduleCount = 0;
        
        $workDays = $this->getWorkDay($cNipNya);
        $date = $perode1;
        $noRow = 0;
        while ($date < $perode2) {
            $noRow ++;
            while ($this->isOff($cNipNya, $workDays, $date)) {
                $date = date('Y-m-d', strtotime($date.' +1 days')); 
            }
            $dayCount++;
            $dUpTo = $this->getScheduleEndDate($cNipNya, $date);

            $q = $this->getScheduleQuery($cNipNya, $date, $dUpTo);

            $data = Array();
            $result = mysql_query($q) or die(mysql_error()."</br>".$q);
            while ($row = mysql_fetch_assoc($result)) {
                array_push($data, $row);
            }

            $rowCount = count($data);
            $hasSchedule = $this->hasSchedule($data, $debug);

            if ($hasSchedule) {
                $hasWeeklyScheduleCount++;              
   
                $html .= "</br>".$noRow.". Weekly Work Schedule: (".$hasWeeklyScheduleCount.")</br>"; 
                $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <td style='border: 1px solid #dddddd;' ><b>Date</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Duration </b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Schedule Frequency</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>ID</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>                        
                    </tr>
                ";       
                for ($i = 0; $i < $rowCount; $i++) { 
                    if (fmod($i, 2) == 0) {
                        $color = 'background-color: #eaedce';
                    } else {
                        $color = '';
                    }                     
                    $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                                <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                    " . $data[$i]['dDate'] . "</td>
                                <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                                    " . $data[$i]['yDuration2'] . "</td>
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                    " . $data[$i]['iScheduleFreq'] . "</td>
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                    " . $data[$i]['iSSID'] . "</td>
                                <td style='width:50%;text-align: center;border: 1px solid #dddddd;'>
                                    " . $data[$i]['problem_subject'] . "</td>
        
                              </tr>";
    
                }
                $html .= "</table>";               
            } else
                $html .= "</br>".$noRow.". No weekly work schedule for date : ".$date."</br>";


            $date = date('Y-m-d', strtotime($date.' +1 days')); 
        }
 
        $hasil = number_format($hasWeeklyScheduleCount / $dayCount * 100);
        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];
                
        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Weekly work schedule for : </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$perode1. " to " .$perode2. "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total normal working days : </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" .number_format($dayCount)."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total days that have weekly work schedule :</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format($hasWeeklyScheduleCount)  . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Percentage having weekly work schedule :</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil  . " %</b></td>
                    </tr>
                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }         

    function hitungPrg11($post)
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
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<b>LOC identified as bug </b>";
        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Author </b></td>
                <td style='border: 1px solid #dddddd;' ><b>File </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Rev# </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Blame Rev# </b></td>
                <td style='border: 1px solid #dddddd;' ><b>LoC</b></td>                
            </tr>
        "; 

        $sql = "select bh.* from hrd.svn_blame_header bh
					inner join (select cd.iRevisionNumber,cd.iSvnId from hrd.svn_commit_detail cd 
                    where cd.iCommitId in(
						select ch.iCommitId from hrd.svn_commit_header ch
						where right(ch.vVersion,2)<> '.0' AND ch.vAuthor = '$cNipNya' AND
						date(ch.tLaunch) between '$perode1' and '$perode2')) c on c.iRevisionNumber = bh.iRevisionNumber 
                        and c.iSvnId=bh.iSvnId
						and bh.vAuthor <> '$cNipNya'
						group by bh.iRevisionNumber,bh.iSvnId";

        $rows = $this->db_erp_pk->query($sql)->result_array();
        $no = 1;
        $loc = $max = $total_loc = 0;
        if (!empty($rows)) {
            $max = count($rows);
            $noRow = 0;
            $total_bugs = 0;           
            for ($i = 0; $i < $max; $i++) {
                $noRow++;
                $vAuthor = $rows[$i]['vAuthor'];
                $vFile = $rows[$i]['vFile'];
                $iRevisionNumber = $rows[$i]['iRevisionNumber'];
                $iBlamedRevNumber = $rows[$i]['iBlamedRevNumber'];
                $iLOC = $rows[$i]['iLOC'];                
                if (fmod($noRow, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }

                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $vAuthor . "</td>
                            <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                                " . $vFile . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $iRevisionNumber . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $iBlamedRevNumber. "</td>
                            <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                                " . $iLOC . "</td>                                                             
                          </tr>";
                $no++;
            }
        }else{
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;'></td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'></td>
                            <td style='width:20%;text-align: left;border: 1px solid #dddddd;'></td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'></td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'></td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'></td>                                                     
                          </tr>";            
        }

        $html .= "</table>";
/*
        $html .= "<b>Total contribution LOC</b>";
        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Author </b></td>
                <td style='border: 1px solid #dddddd;' ><b>File </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Rev# </b></td>
                <td style='border: 1px solid #dddddd;' ><b>LOC </b></td>            
            </tr>
        "; 
*/        
        $sql = "select cd.iCommitId,cd.vVersion,cd.vAuthor,cd.vFile,cd.iRevisionNumber,cd.iLOC,ch.tCommit from 
                    hrd.svn_commit_detail cd
					inner join hrd.svn_commit_header ch on ch.iCommitId = cd.iCommitId and
						date(ch.tCommit) between '$perode1' AND LAST_DAY('$perode2')and
						ch.vAuthor = '$cNipNya'
						where cd.vFile not in (select a.vFile from hrd.svn_commit_detail a
	                   inner join hrd.svn_exclude  b on substr(a.vFile,1,length(Trim(b.vFile))) = Trim(b.vFile))";

        $rows = $this->db_erp_pk->query($sql)->result_array();
        $no = 1;
        $loc = 0;
        $y=count($rows);
        if (!empty($rows)) {
            $noRow = 0;
            $max2 = count($rows);
            $total_loc = 0;
            for ($i = 0; $i < $max2; $i++) {
                $noRow++;
                $iLOC = $rows[$i]['iLOC'];
                $total_loc += $iLOC;
                    
                $vAuthor = $rows[$i]['vAuthor'];
                $vFile = $rows[$i]['vFile'];
                $iRevisionNumber = $rows[$i]['iRevisionNumber'];
                $iLOC = $rows[$i]['iLOC'];      
/*                          
                if (fmod($noRow, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }
    
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $vAuthor . "</td>
                            <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                                " . $vFile . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $iRevisionNumber . "</td>
                            <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                                " . $iLOC . "</td>                                                             
                          </tr>";
*/                          
                $no++;  
            }          
        }

        $html .= "</table>";
        
        $result = ($total_loc > 0 ? number_format(($max / $total_loc)*100 , 2):0);
        
        $getpoint = $this->getPoint($result, $iAspekId);
        
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Bugs: </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>" . number_format($max ) . "</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Contribution of LOC: </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>" . number_format($total_loc) . "</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>" . $result . "%</td>
                    </tr>                    
                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }

    function hitungPrg12($post)
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
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<b>LOC identified as bug </b>";
        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Author </b></td>
                <td style='border: 1px solid #dddddd;' ><b>File </b></td>
                <td style='border: 1px solid #dddddd;' ><b>LoC </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Commit Date</b></td>              
            </tr>
        "; 

        $sql = "select cd.iCommitId,cd.vVersion,cd.vAuthor,cd.vFile,cd.iRevisionNumber,cd.iLOC,ch.tCommit
					from hrd.svn_commit_detail cd
					inner join hrd.svn_commit_header ch on ch.iCommitId = cd.iCommitId and
						date(ch.tCommit) between '$perode1' AND LAST_DAY('$perode2')and
						ch.vAuthor = '$cNipNya'
					where cd.vFile not in (select a.vFile from hrd.svn_commit_detail a
	inner join hrd.svn_exclude  b on substr(a.vFile,1,length(Trim(b.vFile))) = Trim(b.vFile))";

        $rows = $this->db_erp_pk->query($sql)->result_array();
        $no = 1;
        $loc = $max = $total_loc = 0;
        if (!empty($rows)) {
            $max = count($rows);
            $noRow = 0;
            $total_loc = 0;           
            for ($i = 0; $i < $max; $i++) {
                $noRow++;
                $vAuthor = $rows[$i]['vAuthor'];
                $vFile = $rows[$i]['vFile'];
                $tCommit = $rows[$i]['tCommit'];
                $iLOC = $rows[$i]['iLOC'];                
                if (fmod($noRow, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }

                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $vAuthor . "</td>
                            <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                                " . $vFile . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $iLOC . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $tCommit. "</td>                                                           
                          </tr>";
                $no++;
                $total_loc += $iLOC;
            }
        }else{
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;'></td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'></td>
                            <td style='width:20%;text-align: left;border: 1px solid #dddddd;'></td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'></td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'></td>                                                  
                          </tr>";            
        }

        $html .= "</table>";

        
        $result = $total_loc;
        
        $getpoint = $this->getPoint($result, $iAspekId);
        
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>" . number_format($result) . "</td>
                    </tr>                    
                </table>";
        echo number_format($result) . "~" . $point . "~" . $warna . "~" . $html;
    }
    
    function hitungPrg13($post)
    {
        $iAspekId = $post['_iAspekId'];
        $iPkTransId = $post['_iPkTransId'];
        $cNipNya = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];
        $periode1 = $x_prd1['2'] . "-" . $x_prd1['1'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];
        $periode2 = $x_prd2['2'] . "-" . $x_prd2['1'];

        $sql = "SELECT cTahun, iSemester FROM hrd.pk_trans WHERE id='" . $iPkTransId . "'";
        $query = $this->db_erp_pk->query($sql);
        $cTahun = $query->row()->cTahun;
        $iSemester = $query->row()->iSemester;

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Project Contribution</b></td>
            </tr>
        ";

        $sqlto = "select a.id,a.problem_subject,c.vName, a.problem_description, a.dTarget_implement, a.dSubmit_requirement
                from hrd.ss_raw_problems a 
                inner join hrd.ss_raw_pic b on a.id =b.rawid and b.pic = '$cNipNya' and b.Deleted = 'No'
                left outer join hrd.employee c on c.cNip =  b.pic
                where  a.cSemester= '$iSemester' and a.cTahun = '$cTahun'
                and a.iStatus =13 and a.eProject_priority = 'Y' and DATE(a.dcloseGm) <= '$perode2'";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $no = $totalContibution = 0;
        if (!empty($rows)) {
			$raw = count($rows);           
            foreach ($rows as $d) {
                $ssid = $d['id'];
                $problem_subject = $d['problem_subject'];  
                              
                $TotalProject = $this->getIncentiveProject($ssid,$periode1);
                if($TotalProject){
                    $dataict = $this->getActIncentive($cNipNya,$ssid,$periode1,$periode2,$TotalProject);
                    if($dataict) {
                        $no++;
                        $Contibution = $dataict/100;
                        if (fmod($no, 2) == 0) {
                            $color = 'background-color: #eaedce';
                        } else {
                            $color = '';
                        }
                        $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                                <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $no . "</td>
        
                                <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                    " . $ssid . "</td>
                                <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                    " . $problem_subject . "</td>
                                <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                    " . number_format($dataict,2) . " %</td>
                              </tr>";

                        $totalContibution += $Contibution;
                    }
                }      
            }                                 
        }


        $html .= "</table>";


        $hasil = $totalContibution;
        $result = number_format($hasil,2);

        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result :</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>" . $result . " </b></td>
                    </tr>
                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }

    function hitungPrg14($post)
    {
        $iAspekId = $post['_iAspekId'];
        $iPkTransId = $post['_iPkTransId'];
        $cNipNya = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];
        $periode1 = $x_prd1['2'] . "-" . $x_prd1['1'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];
        $periode2 = $x_prd2['2'] . "-" . $x_prd2['1'];

        $sql = "SELECT cTahun, iSemester FROM hrd.pk_trans WHERE id='" . $iPkTransId . "'";
        $query = $this->db_erp_pk->query($sql);
        $cTahun = $query->row()->cTahun;
        $iSemester = $query->row()->iSemester;

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";



        $sqlto = "select a.id,a.problem_subject,c.vName, a.problem_description, a.dTarget_implement, a.dSubmit_requirement
                from hrd.ss_raw_problems a
                inner join hrd.ss_raw_pic b on a.id =b.rawid and b.pic = '$cNipNya' and b.Deleted = 'No'
                left outer join hrd.employee c on c.cNip =  b.pic
                where  a.cSemester= '$iSemester' and a.cTahun = '$cTahun'
                and a.iStatus =13 and a.eProject_priority = 'Y' and DATE(a.dcloseGm) <= '$perode2'";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $no = $totalContibution = 0;
        if (!empty($rows)) {

            $raw = count($rows);
            foreach ($rows as $d) {
                $ssid = $d['id'];
                $problem_subject = $d['problem_subject'];


                $sql = "SELECT cPic,vAlias, iRawId,problem_subject, vGrpActivityName, SUM(iModuleSize) iFinalModuleSize from
                        (select a.cPic,e.vAlias, a.iRawId,b.problem_subject, a.vGrpActivityName,
                        CASE
                            WHEN a.iActivityId IN (6,232,34,218,219,235) THEN a.iModuleSize * 0.25
                            ELSE a.iModuleSize
                        END iModuleSize
                        from hrd.ss_ict_temp a
                            left outer join hrd.ss_raw_problems b on a.iRawId = b.id
                            left outer join hrd.employee e on a.cPic = e.cNip
                        where a.cPeriod >= '$periode1'   and iModuleSize > 0 and eIsCheck = 'Y'
                        and a.cPic = '$cNipNya'
                        group by a.cPic,e.vAlias, a.iRawId,b.problem_subject order by a.cPic,a.iRawId) tmp
                        GROUP BY cPic,vAlias, iRawId,problem_subject, vGrpActivityName" ;

                $rows_= $this->db_erp_pk->query($sql)->result_array();
                $incentive = 0;
                if (!empty($rows_)) {
                    $html .= "<br /> ";
                    $html .= "<b>Project: ".$ssid."-".$problem_subject."
                    </b>";
                    $html .= "<br /> ";
                    $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                                <td style='border: 1px solid #dddddd;' ><b>SSiD Task</b></td>
                                <td style='border: 1px solid #dddddd;' ><b>Problem Subject </b></td>
                                <td style='border: 1px solid #dddddd;' ><b>Size Task</b></td>
                            </tr>
                        ";
                    $totalsize = 0;
                    foreach ($rows_ as $e) {
                        $id = $e['iRawId'];
                        $pic = $e['cPic'];
                        $subject = $e['problem_subject'];
                        $vGrpActivityName = $e['vGrpActivityName'];
                        $projectId = $this->getHighestParent($id);

                        if($projectId == $ssid){
                            if($projectId != $id && $vGrpActivityName == 'Coding'){
                                $size = $e['iFinalModuleSize'];
                                $no++;
                                if (fmod($no, 2) == 0) {
                                    $color = 'background-color: #eaedce';
                                } else {
                                    $color = '';
                                }
                                $totalsize += $size;
                                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                                <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $no . "</td>

                                <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                    " . $id . "</td>
                                <td style='width:60%;text-align: left;border: 1px solid #dddddd;'>
                                    " . $subject . "</td>
                                <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                                    " . number_format($size,2) . "</td>
                              </tr>";
                                $totalContibution += $e['iFinalModuleSize'];
                            }
                        }
                    }
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <th colspan ='3' style='text-align: right;border: 1px solid #dddddd;' >Total</th>
                            <td style='text-align: right;border: 1px solid #dddddd;' >" . number_format($totalsize,2) . "</td>
                          </tr>";
                $html .= "</table>";
            }
        }





        $hasil = $totalContibution;
        $result = number_format($hasil,2);

        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result :</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>" . $result . " </b></td>
                    </tr>
                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }
    /*=================End Function Programmer Staff======================================================*/


    //==============================Start Funtion PK Technical writer=====================================
    function hitungTw1($post)
    {
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
        
        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Est. Finish</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Finish Date</b></td>
            </tr>
        ";

        //$arrJadwal=$this->getJadwalKerja($cNipNya);
        
        $sqlto = "SELECT a.history_id, a.id, b.problem_subject, a.activity_id, a.estimated_finish,
				  a.actual_finish,a.date_posted,a.actual_start,a.activity_id,b.activity_id
				  FROM hrd.ss_raw_history a
				  LEFT JOIN hrd.ss_raw_problems b ON b.id = a.id
				  WHERE a.finishing_by ='$cNipNya' AND a.estimated_finish IS NOT NULL AND
				  DATE(a.actual_finish) BETWEEN '$perode1' AND LAST_DAY('$perode2')
				  AND b.activity_id NOT IN (22, 37)
				  ORDER BY a.history_id,a.id";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        foreach($rows as $row) {
            //$noRow++;
            $history_id = $row['history_id'];
            $raw_id = $row['id'];
            $subject = $row['problem_subject'];
            $est_finish = $row['estimated_finish'];
            $act_finish = $row['actual_finish'];
            $act_start  = $row['actual_start'];
            $date_posted = $row['date_posted'];

            $data_container[ $raw_id ][] = array('problem_subject'=>$subject,'est_finish'=>$est_finish,'act_finish'=>$act_finish,'act_start'=>$act_start,'date_posted'=>$date_posted);

        }        
        
        foreach($data_container as $raw_id => $data) {
            $noRow++;
            $jumlahDataPerId = count( $data_container[ $raw_id ] );

            if( $jumlahDataPerId > 3 ) {
                //$dump = end( $data_container[ $raw_id ] );
                $est_ = $data_container[ $raw_id ][3]['est_finish'];
                $act_ = $data_container[ $raw_id ][3]['act_finish'];
                $act2_ = $data_container[ $raw_id ][3]['act_start'];
                $date_ = $data_container[ $raw_id ][3]['date_posted'];

                $data_stored[$cNipNya][ $raw_id ]['est_finish'] = $est_;
                $data_stored[$cNipNya][ $raw_id ]['act_finish'] = $act_;
                $data_stored[$cNipNya][ $raw_id ]['act_start'] = $act2_;
                $data_stored[$cNipNya][ $raw_id ]['date_posted'] = $date_;
            }
            else {
                $dump = end( $data_container[ $raw_id ] );

                $data_stored[$cNipNya][ $raw_id ]['est_finish'] = $dump['est_finish'];
                $data_stored[$cNipNya][ $raw_id ]['act_finish'] = $dump['act_finish'];
                $data_stored[$cNipNya][ $raw_id ]['act_start'] = $dump['act_start'];
                $data_stored[$cNipNya][ $raw_id ]['date_posted'] = $dump['date_posted'];
            }
            $data_stored[$cNipNya][ $raw_id ]['problem_subject'] = $dump['problem_subject'];
                        
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }            
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $raw_id . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $dump['problem_subject'] . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $dump['est_finish'] . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $dump['act_finish'] . "</td>

                      </tr>";

            }

        $html .= "</table>";
        $hasil = $this->prosesHitPrg8( $data_stored );

        $total_hasil = $data_tepat = $data_all = 0;
        $data_tepat = isset($hasil['data_tepat'])?$hasil['data_tepat']:$data_tepat;
        $data_all = isset($hasil['data_all'])?$hasil['data_all']:$data_all;
        if( $data_all > 0 ) {
            $total_hasil = number_format($data_tepat/$data_all*100, 2);
        } else {
            $total_hasil = 0;
        }
        
        $getpoint = $this->getPoint($total_hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];
                
        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Task Sesuai Jadwal: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $data_tepat . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Seluruh Task: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $data_all . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $total_hasil . " %</b></td>
                    </tr>

                </table>";
        echo $total_hasil . "~" . $point . "~" . $warna . "~" . $html;
    }        

    function hitungTw2($post)    {
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

        $dayCount = 0;
        $hasWeeklyScheduleCount = 0;
        
        $workDays = $this->getWorkDay($cNipNya);
        $date = $perode1;
        $noRow = 0;
        while ($date < $perode2) {
            $noRow ++;
            while ($this->isOff($cNipNya, $workDays, $date)) {
                $date = date('Y-m-d', strtotime($date.' +1 days')); 
            }
            $dayCount++;
            $dUpTo = $this->getScheduleEndDate($cNipNya, $date);

            $q = $this->getScheduleQuery($cNipNya, $date, $dUpTo);

            $data = Array();
            $result = mysql_query($q) or die(mysql_error()."</br>".$q);
            while ($row = mysql_fetch_assoc($result)) {
                array_push($data, $row);
            }

            $rowCount = count($data);
            $hasSchedule = $this->hasSchedule($data, $debug);

            if ($hasSchedule) {
                $hasWeeklyScheduleCount++;              
   
                $html .= "</br>".$noRow.". Weekly Work Schedule: (".$hasWeeklyScheduleCount.")</br>"; 
                $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <td style='border: 1px solid #dddddd;' ><b>Date</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Duration </b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Schedule Frequency</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>ID</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>                        
                    </tr>
                ";       
                for ($i = 0; $i < $rowCount; $i++) { 
                    if (fmod($i, 2) == 0) {
                        $color = 'background-color: #eaedce';
                    } else {
                        $color = '';
                    }                     
                    $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                                <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                    " . $data[$i]['dDate'] . "</td>
                                <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                                    " . $data[$i]['yDuration2'] . "</td>
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                    " . $data[$i]['iScheduleFreq'] . "</td>
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                    " . $data[$i]['iSSID'] . "</td>
                                <td style='width:50%;text-align: center;border: 1px solid #dddddd;'>
                                    " . $data[$i]['problem_subject'] . "</td>
        
                              </tr>";
    
                }
                $html .= "</table>";               
            } else
                $html .= "</br>".$noRow.". No weekly work schedule for date : ".$date."</br>";


            $date = date('Y-m-d', strtotime($date.' +1 days')); 
        }
 
        $hasil = number_format($hasWeeklyScheduleCount / $dayCount * 100);
        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];
                
        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Weekly work schedule for : </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$perode1. " to " .$perode2. "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total normal working days : </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" .number_format($dayCount)."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total days that have weekly work schedule :</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format($hasWeeklyScheduleCount)  . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Percentage having weekly work schedule :</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil  . " %</b></td>
                    </tr>
                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }    

   function hitungTw5($post)
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
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<b>Task Yang Rework</b>";
        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No </b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject </b></td>
            </tr>
        "; 

        $sql = "SELECT a.activity_id,a.id,b.commentType,a.problem_subject, a.date_posted,b.input_date, b.startDuration,
                a.actual_start,a.actual_finish,a.estimated_start,a.estimated_finish,a.updateSchedule
				FROM hrd.ss_raw_problems a
				LEFT JOIN hrd.ss_solution b ON b.id = a.id
				WHERE a.pic = '".$cNipNya."'
				AND a.activity_id IN(231,232)
				AND DATE(a.date_posted) BETWEEN '" . $perode1 . "' AND LAST_DAY('" . $perode2 . "')
				AND b.commentType=6 GROUP BY a.id
				ORDER BY a.id";

        $b = $this->db_erp_pk->query($sql)->result_array();
        $no = 1;
        $loc = 0;
        $x=count($b);
        if (!empty($b)) {
           
            foreach ($b as $v) {
                if (fmod($no, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }

                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $no . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['id'] . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['problem_subject'] . "</td>
                          </tr>";
                $no++;
            }
        }else{
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;'></td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'></td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'></td>
                          </tr>";            
        }

        $html .= "</table>";

        $html .= "<b>Task Yang Finish</b>";
        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No </b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject </b></td>
            </tr>
        "; 
        $sql = "SELECT a.activity_id,a.id,b.commentType,a.problem_subject, a.date_posted,b.input_date, b.startDuration,
                a.actual_start,a.actual_finish,a.estimated_start,a.estimated_finish,a.updateSchedule
				FROM hrd.ss_raw_problems a
				LEFT JOIN hrd.ss_solution b ON b.id = a.id
				WHERE a.pic = '".$cNipNya."'
				AND a.activity_id IN(231,232)
				AND DATE(a.date_posted) BETWEEN '" . $perode1 . "' AND LAST_DAY('" . $perode2 . "')
				AND b.commentType=8 GROUP BY a.id
				ORDER BY a.id";

        $b = $this->db_erp_pk->query($sql)->result_array();
        $no = 1;
        $loc = 0;
        $y=count($b);
        if (!empty($b)) {
           
            foreach ($b as $v) {
                if (fmod($no, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }

                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $no . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['id'] . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['problem_subject'] . "</td>
                          </tr>";
                $no++;
            }
        }else{
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;'></td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'></td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'></td>
                          </tr>";            
        }

        $html .= "</table>";
        
        if($y == 0){
            $result = 0;
        }else{
            $result = ($x/$y);
            $result = number_format( $result, 2);
        }
        
        
        $getpoint = $this->getPoint($result, $iAspekId);
        
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Rework: </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>" . $x . "</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Task yg Finish: </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>" . $y . "</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>" . $result . "</td>
                    </tr>                    
                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }    
    //==============================End Function PK Technical writer======================================

    //============================Ini tempat Funtion function tambahan=====================================
    function getInferior($superior = '', $type = '1', $datecustom = false)
    {
        //$CI =& get_instance();
        //$MIS_MANAGER = $CI->session->userdata('mis_manager');
        $arrProperties = array();
        if (!$superior) return false;
        //if(in_array($superior)) {
        //$arrProperties[] = $superior;
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
        $sql = "SELECT e.cNip, e.dResign, (SELECT COUNT(cNip) FROM hrd.employee WHERE cUpper=e.cNip) AS child
				  FROM hrd.employee e
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

        if($cNipNya == 'N00347'){
            $sql = "select " . $iMsGroupAspekId . " as iMsGroupAspekId,CASE when a.iStatus =13 then a.iSizeProject else 0 end iSizeProject,
                    CONCAT(a.id,' - ',a.problem_subject) AS vAspekName,
                1 as lAutoCalculation, 'generateDetail' as vFunctionLink, 0 AS iparameter_id, 0  AS nBobot,a.id as ssid
                from hrd.ss_raw_problems a
                inner join hrd.ss_raw_pic b on b.rawid = a.id and b.pic = '$cNipNya' and b.iRoleId =1 and b.Deleted ='No'
                WHERE a.estimated_start BETWEEN '$perode1' AND '$perode2'
                and a.id not in(SELECT LEFT(vAspekName,6) from hrd.pk_aspek_dynamic)
                and a.Deleted ='No'
                AND a.confirmPP = 2
                GROUP BY CONCAT(a.problem_subject,' (',a.id,')') 	 ";
        }else{
            $sql = "select " . $iMsGroupAspekId . " as iMsGroupAspekId,CASE when a.iStatus =13 then a.iSizeProject else 0 end iSizeProject,
                    CONCAT(a.id,' - ',a.problem_subject) AS vAspekName,
                1 as lAutoCalculation, 'generateDetail' as vFunctionLink, 0 AS iparameter_id, 0  AS nBobot,a.id as ssid
                from hrd.ss_raw_problems a
                inner join hrd.ss_raw_pic b on b.rawid = a.id and b.pic = '$cNipNya' and b.iRoleId =1 and b.Deleted ='No'
                where cSemester= '$iSemester' and cTahun = '$cTahun'
                and a.id not in(SELECT LEFT(vAspekName,6) from hrd.pk_aspek_dynamic)
                and a.eProject_priority = 'Y' and a.Deleted ='No'
                GROUP BY CONCAT(a.problem_subject,' (',a.id,')') ";
        }


        $b = $this->db_erp_pk->query($sql)->result_array();

        $nSize = $size = 0;
        if (!empty($b)) {
            foreach ($b as $v) {
                $size = ($v['iSizeProject']== 0) ? 100 : $v['iSizeProject'];
                $nSize += $size;
            }
        }
        $no = 1;
        if (!empty($b)) {
            foreach ($b as $v) {
                $date = date("Y-m-d H:i:s");
                $nBobot = ( (($v['iSizeProject']== 0) ? 100 : $v['iSizeProject'])/$nSize)*100;
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
   /*
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

        //cari jml anak buah yg programmer
        $sql = "select cNip from hrd.employee a where a.cUpper = '$cNipNya' and a.iPostID in(358,30)
                        and (a.dresign ='0000-00-00' or a.dresign > '$perode1')
                            union
                        select cNip from hrd.employee b where b.cUpper in (
                        select cNip from hrd.employee c where c.cUpper = '$cNipNya' and c.iPostID in(358,30)
                        and (c.dresign ='0000-00-00' or c.dresign > '$perode1'))
                        and iPostId in(358,30) ";

        $query = $this->db_erp_pk->query($sql)->result_array();
        $JmlProgrammer = count($query);

        $sql = "select vContent from hrd.ss_sysparam where cVariable = 'ProjectSize'";

        $query = $this->db_erp_pk->query($sql);
        $stdsize = $query->row()->vContent;

        $stdproject = $JmlProgrammer * 6;

        $sql = "select " . $iMsGroupAspekId . " as iMsGroupAspekId,a.iSizeProject,
                    CONCAT(a.id,' - ',a.problem_subject) AS vAspekName,
                1 as lAutoCalculation, 'generateDetail' as vFunctionLink, 0 AS iparameter_id, 0  AS nBobot,a.id as ssid, a.iStatus
                from hrd.ss_raw_problems a
                inner join hrd.ss_raw_pic b on b.rawid = a.id and b.pic = '$cNipNya' and b.iRoleId =1 and b.Deleted ='No'
                where cSemester= '$iSemester' and cTahun = '$cTahun'
                and a.id not in(SELECT LEFT(vAspekName,6) from hrd.pk_aspek_dynamic)
                and a.eProject_priority = 'Y' and a.Deleted ='No'
                GROUP BY CONCAT(a.problem_subject,' (',a.id,')') order by a.iSizeProject desc";

        $b = $this->db_erp_pk->query($sql)->result_array();

        //compare with maxsize
        $finishSize = 0;
        if (!empty($b)) {
            foreach ($b as $v) {
                if($v['iStatus']==13){
                    $finishSize += $v['iSizeProject'];
                }
            }
        }

        $nSize = $size = 0;
        if (!empty($b)) {
            if ($finishSize >= $stdsize) {
                    foreach ($b as $v) {
                        if($v['iStatus']==13){
                            $size = ($v['iSizeProject']== 0) ? 100 : $v['iSizeProject'];
                            $nSize += $size;
                        }
                    }

            }else{
                $hitung =0;
                foreach ($b as $v) {
                    $hitung += 1;
                    if($hitung<=$stdproject){
                        $size = ($v['iSizeProject']== 0) ? 100 : $v['iSizeProject'];
                        $nSize += $size;
                    }

                }
            }
        }


        $no = 1;
        if (!empty($b)) {

                foreach ($b as $v) {
                    if ($finishSize >= $stdsize) {
                        if($v['iStatus']!=13){
                            continue;
                        }
                    }
                    $date = date("Y-m-d H:i:s");
                    $nBobot = ((($v['iSizeProject'] == 0) ? 100 : $v['iSizeProject']) / $nSize) * 100;
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
*/
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
       

        if($cNipNya == 'N00347'){
            $sqlmain = "Select date(estimated_finish) as dTarget_implement,date(dcloseGm) dcloseGm, iStatus, 0 iSizeProject  from hrd.ss_raw_problems where id =" . $vSsid;
        }else{
            $sqlmain = "Select dTarget_implement,date(dcloseGm) dcloseGm, iStatus, iSizeProject  from hrd.ss_raw_problems where id =" . $vSsid;
        }

        $qsqlmain = $this->db_erp_pk->query($sqlmain);
        $tglawal = '';
        $tglakhir = '';
		if($qsqlmain->num_rows>=1){
			$dtmain=$qsqlmain->result_array();
			foreach ($dtmain as $kmain => $vmain) {
				$tglawal =  $vmain['dTarget_implement'];
   	            $tglakhir =  $vmain['dcloseGm'];
                $iStatus = $vmain['iStatus'];
                $iSize = $vmain['iSizeProject'];
			}
        }
        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                    <tr>
                        <td align='right'><b>Size Project :</b></td>
                        <td>" . $iSize . "</td>

                    </tr>
                </table>";
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
        $sql = "select a.cPic,e.vAlias, a.iRawId, a.vGrpActivityName, sum(a.iFinalIncentive) as iFinalIncentive
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
                $vGrpActivityName = $d['vGrpActivityName'];
                $projectId = $this->getHighestParent($id);
                if($projectId == $ssid){
                    if($projectId != $id && $vGrpActivityName == 'Coding'){
                        $incentive += $d['iFinalIncentive'];
                    }
                }
    
            }
        }
        $ict = ($incentive/ $dataict)*100;

        return $ict;
    }

    function getActSize($cNipNya,$ssid,$period1,$period2){
        $sql = "select a.cPic,e.vAlias, a.iRawId, a.vGrpActivityName, sum(a.iModuleSize) as iFinalModuleSize
                from hrd.ss_ict_temp a
            left outer join hrd.ss_raw_problems b on a.iRawId = b.id
            left outer join hrd.employee e on a.cPic = e.cNip
                where a.cPeriod >= '$period1'   and iModuleSize > 0 and eIsCheck = 'Y'
                and a.cPic = '$cNipNya'
                group by a.cPic,e.vAlias, a.iRawId order by a.cPic,a.iRawId" ;

        $rows= $this->db_erp_pk->query($sql)->result_array();


        $z = 0;
        $incentive = 0;
        if (!empty($rows)) {
            foreach ($rows as $d) {
                $id = $d['iRawId'];
                $pic = $d['cPic'];
                $vGrpActivityName = $d['vGrpActivityName'];
                $projectId = $this->getHighestParent($id);
                  if($projectId == $ssid){
                        if($projectId != $id && $vGrpActivityName == 'Coding'){
                            $incentive += $d['iFinalModuleSize'];
                        }
                  }
            }
        }
        $ict = $incentive;

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
        $sql = "select a.cPic, a.iRawId, a.vGrpActivityName, sum(a.iFinalIncentive) as iFinalIncentive
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
                        /*if($ssid==358648){
                            echo $id.' - '.$d['iFinalIncentive'];
                            echo "<br>";    
                        }*/
                        $finalIct = $d['iFinalIncentive'];
                        if ($d['vGrpActivityName']!=='Coding'){
                            $finalIct = 0;
                        }                      
                        $dataict +=$finalIct;
                        
                    }
                }
    
            }
        }
        /*if($ssid==358648)   {
            echo $dataict;
        }*/
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

    function TSPERFM_01($post){
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

       /* $html.="<style>
                #pk_soft_dev thead tr{
                    display:block;
                }
                #pk_soft_dev tbody{
                    display:block;
                    height:100px;
                    overflow:auto;//set tbody to auto
                }
                #pk_soft_dev th,#pk_soft_dev td{
                    width:100px;//fixed width
                }
                </style>";*/
        $html .= "<table cellspacing='0' cellpadding='3' width='100%' id='pk_soft_dev' >
            <thead>
            <tr style='border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <th style='border: 1px solid #dddddd;width:25px;' ><b>No</b></th>
                <th style='border: 1px solid #dddddd;width:75px;' ><b>Nomor SSID</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Problem Subject</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Comment Type</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Date Post</b></th> 
                <th style='border: 1px solid #dddddd;' ><b>Actual Finish</b></th> 
                <th style='border: 1px solid #dddddd;' ><b>Selisih</b></th> 
            </tr>
            </thead>
        ";
        $html.='<tbody>';


        $sqlto ="SELECT z.id,z.problem_subject, z.date_posted,z.assignTime,z.actual_start,z.startDuration,z.input_date,z.commentType, z.vType, z.solution_id,z.actual_finish 
            FROM (SELECT a.id,b.solution_id,a.problem_subject, a.date_posted, 
            Case when a.approveDate is not null then a.approveDate 
            When a.assignTime is not null then a.assignTime 
            else a.date_posted end 
            assignTime, a.actual_start,b.startDuration,b.input_date,b.commentType,b.vType,iGrp_activity_id, a.actual_finish 
            FROM hrd.ss_raw_problems a JOIN hrd.ss_solution b ON b.id = a.id JOIN hrd.ss_activity_type c on c.activity_id = a.activity_id 
            WHERE #pic nip pengusul dan requestor bukan nip pengusul 
            a.requestor not in ('".$cNipNya."') and a.posted_by not in ('".$cNipNya."')
            AND a.pic like '%".$cNipNya."%'
            #interval waktu penilaian 
            AND DATE(a.actual_finish) between '".$perode1."' AND '".$perode2."' 
            AND CASE WHEN (SELECT assign FROM hrd.ss_support_type WHERE typeId=a.typeId)='Y' 
            THEN (b.commentType = 2) END 
            #Activity Type-Client CPU Instalasi 
            AND a.activity_id = 224 
            AND (b.isDeleted = 0 OR b.isDeleted IS NULL) 
            UNION 
            SELECT a.id,b.solution_id,a.problem_subject, a.date_posted, 
            Case when a.approveDate is not null then a.approveDate 
            When a.assignTime is not null then a.assignTime 
            else a.date_posted end 
            assignTime, a.actual_start,b.startDuration,b.input_date,b.commentType, b.vType,c.iGrp_activity_id, a.actual_finish 
            FROM hrd.ss_raw_problems a 
            JOIN hrd.ss_solution b ON b.id = a.id 
            JOIN hrd.ss_activity_type c on c.activity_id = a.activity_id 
            WHERE #pic nip pengusul dan requestor bukan nip pengusul 
            a.requestor not in ('".$cNipNya."') and a.posted_by not in ('".$cNipNya."')
            AND a.pic like '%".$cNipNya."%' 
            #interval waktu penilaian 
            AND DATE(a.actual_finish) between '".$perode1."' AND '".$perode2."' AND (b.commentType = 50) 
            #Activity Type-Client CPU Instalasi 
            AND a.activity_id = 224 AND (b.isDeleted = 0 OR b.isDeleted IS NULL) 
            ) AS z 
            GROUP BY z.id, z.vType 
            ORDER BY z.date_posted,z.solution_id"; 
 
        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $selisih = 0;
        $selc=array();
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                /*Cek Hasil*/
                $s=$this->selisihHari($v['date_posted'], $v['actual_finish'], $cNipNya,'minute');
                $selc[]=number_format($s/1440, 2, '.', '' );
                //mencari hari 
                $jmlhr = floor($s/1440);
                $sisahr = $s%1440;
                
                //mencari jam
                $jmljam = floor($sisahr/60);
                $sisajam = $sisahr%60; //sisa dari menit

                $selisih=$jmlhr." Hari ".$jmljam. " Jam ".$sisajam." Menit";

                $jenis=array(1=>'FeedBack',2=>'Assigment',3=>'Follow up',4=>'Validation', 5=>'Unfinish', 6=>'Rework v&v', 7=>'Confirm', 8 =>'Documentation Verification', 9=>'Documentation Confirm', 70=>'rejected', 71=>'Approve', 50=>'accepted', 52=>'postpone', 53=>'rejected', 59=>'acceptance error', 60=>'submit schedule', 61=>'approve schedule', 62=>'execution schedule', 63=>'aggreed schedule', 99=>'joblog', 98=>'sizing');
                $dlink=explode("/",base_url());
                $dlink[3]="ss";
                $linkss=implode("/",$dlink);
                $html .= '<tr style="border: 1px solid #dddddd; border-collapse: collapse;'.$color.'"> 
                            <td style="text-align: center;border: 1px solid #dddddd;width:25px;" >'.$no.'</td>

                            <td style="text-align: left;border: 1px solid #dddddd;width:75px;">
                                <a href="javascript:void(0);" title="'.$v['problem_subject'].'" onclick="window.open(\''.$linkss.'index.php/rawproblems/detail/'.$v['id'].'\', \'_blank\', 
                        \'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0,top=84,left=283\');">'.$v['id'].'</a></td>'; 
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['problem_subject'].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$jenis[$v['commentType']].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['date_posted'].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['actual_finish'].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$selisih.'</td>';
                $html.='</tr>';
                $no++;
            }
        } 
        $html.='</tbody>';
        $html .="</table>";
        $pembilang =0;  
        $penyebut =0;
        $total=0;
        if(count($selc)>=1){
            $pembilang = number_format(array_sum($selc),2);  
            $penyebut = $no-1;
            $total=number_format(($pembilang/$penyebut),2);
        }
        if(count($selc)<1){
            $result     = number_format(0,2);
        }else{
            $result     = number_format($total,2);
        }

        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah selisih :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$pembilang." Hari</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah SSID Memenuhi Syarat :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$penyebut." SSID</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Rata - Rata :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$result." Hari</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function TSPERFM_02($post){
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

       /* $html.="<style>
                #pk_soft_dev thead tr{
                    display:block;
                }
                #pk_soft_dev tbody{
                    display:block;
                    height:100px;
                    overflow:auto;//set tbody to auto
                }
                #pk_soft_dev th,#pk_soft_dev td{
                    width:100px;//fixed width
                }
                </style>";*/
        $html .= "<table cellspacing='0' cellpadding='3' width='100%' id='pk_soft_dev' >
            <thead>
            <tr style='border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <th style='border: 1px solid #dddddd;width:25px;' ><b>No</b></th>
                <th style='border: 1px solid #dddddd;width:75px;' ><b>Nomor SSID</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Problem Subject</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Actual Start</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Actual Finish</b></th> 
                <th style='border: 1px solid #dddddd;' ><b>SLA Rate</b></th> 
                <th style='border: 1px solid #dddddd;' ><b>Selisih</b></th> 
                <th style='border: 1px solid #dddddd;' ><b>Persentase SLA dan Selisih</b></th> 
            </tr>
            </thead>
        ";
        $html.='<tbody>';


        $sqlto ="SELECT z.id,z.problem_subject, z.date_posted,z.assignTime,z.actual_start,z.startDuration,z.input_date,z.commentType, z.vType, z.solution_id,z.actual_finish,z.iSLARate 
                FROM (SELECT a.id,b.solution_id,a.problem_subject, a.date_posted, 
                Case when a.approveDate is not null then a.approveDate 
                When a.assignTime is not null then a.assignTime 
                else a.date_posted end 
                assignTime, a.actual_start,b.startDuration,b.input_date,b.commentType,b.vType,iGrp_activity_id, a.actual_finish , c.iSLARate
                FROM hrd.ss_raw_problems a JOIN hrd.ss_solution b ON b.id = a.id 
                JOIN hrd.ss_activity_type c on c.activity_id = a.activity_id 
                WHERE #pic nip pengusul dan requestor bukan nip pengusul 
                a.requestor not in ('".$cNipNya."') 
                AND a.pic like '%".$cNipNya."%'
                #interval waktu penilaian 
                AND DATE(a.actual_finish) between '".$perode1."' AND '".$perode2."'
                AND CASE WHEN (SELECT assign FROM hrd.ss_support_type WHERE typeId=a.typeId)='Y' 
                THEN (b.commentType = 2) END
                #bukan module
                AND c.isModule='N' 
                #SLA yes
                AND c.isSLA='Y'  
                AND (b.isDeleted = 0 OR b.isDeleted IS NULL) 
                UNION 
                SELECT a.id,b.solution_id,a.problem_subject, a.date_posted, 
                Case when a.approveDate is not null then a.approveDate 
                When a.assignTime is not null then a.assignTime 
                else a.date_posted end 
                assignTime, a.actual_start,b.startDuration,b.input_date,b.commentType, b.vType,c.iGrp_activity_id, a.actual_finish, c.iSLARate 
                FROM hrd.ss_raw_problems a 
                JOIN hrd.ss_solution b ON b.id = a.id 
                JOIN hrd.ss_activity_type c on c.activity_id = a.activity_id 
                WHERE #pic nip pengusul dan requestor bukan nip pengusul 
                a.requestor not in ('".$cNipNya."') 
                AND a.pic like '%".$cNipNya."%'
                #interval waktu penilaian 
                AND DATE(a.actual_finish) between '".$perode1."' AND '".$perode2."' #AND (b.commentType = 50) 
                #bukan module
                AND c.isModule='N' 
                #SLA yes
                AND c.isSLA='Y'   
                #Activity Type-Client CPU Instalasi 
                AND (b.isDeleted = 0 OR b.isDeleted IS NULL) 
                ) AS z 
                GROUP BY z.id 
                ORDER BY z.date_posted,z.solution_id"; 
 
        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $selisih = 0;
        $mem=0;
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                /*Cek Hasil*/
                $takhir= date('Y-m-d H:i:s', strtotime($v['actual_finish']));
                $tawal= date('Y-m-d H:i:s', strtotime($v['actual_start']));
                $selisih=$this->selisihHari($tawal,$takhir,$cNipNya,'minute');
                $durasi=$selisih;
                $rate=$v['iSLARate'];
                $persen="Tidak Memenuhi";
               if($rate>=$selisih){ //Cek Apabila rate SLA kurang dari durasi pengerjaan - by minute
                    $mem++;
                    $persen="Memenuhi";
                }else{
                    $color='background-color: #f45342';
                }

                $mark='';

                if($v['actual_finish']!='' or $v['actual_finish']!=NULL or $v['actual_finish']!='1970-01-01' or $v['actual_finish']!='0000-00-00'){
                    $mark=date('Y-m-d H:i:s', strtotime($v['actual_finish']));
                    if($mark=='1970-01-01'){
                        $mark='';
                    }
                }
                $actual='';
                if($v['actual_start']!='' or $v['actual_start']!=NULL or $v['actual_start']!='1970-01-01' or $v['actual_start']!='0000-00-00'){
                    $actual=date('Y-m-d H:i:s', strtotime($v['actual_start']));
                    if($actual=='1970-01-01'){
                        $actual='';
                    }
                }

                $dlink=explode("/",base_url());
                $dlink[3]="ss";
                $linkss=implode("/",$dlink);
                $html .= '<tr style="border: 1px solid #dddddd; border-collapse: collapse;'.$color.'"> 
                            <td style="text-align: center;border: 1px solid #dddddd;width:25px;" >'.$no.'</td>

                            <td style="text-align: left;border: 1px solid #dddddd;width:75px;">
                                <a href="javascript:void(0);" title="'.$v['problem_subject'].'" onclick="window.open(\''.$linkss.'index.php/rawproblems/detail/'.$v['id'].'\', \'_blank\', 
                        \'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0,top=84,left=283\');">'.$v['id'].'</a></td>'; 
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['problem_subject'].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$actual.'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$mark.'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['iSLARate'].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$selisih.'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$persen.'</td>';
                $html.='</tr>';
                $no++;
            }
        } 
        $html.='</tbody>';
        $html .="</table>";
        
        $total=0;
        $no=$no-1;
        if($no >= 1 and $mem !=0){
            $total=$mem/$no*100;
        }

        if($total<1){
            $result     = number_format(0,2);
        }else{
            $result     = number_format($total,2);
        }

        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah SSID :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$no." SSID</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah SSID Memenuhi Syarat SLA :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$mem." SSID</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Persentase  :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$result." %</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function TSPERFM_03($post){
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

       /* $html.="<style>
                #pk_soft_dev thead tr{
                    display:block;
                }
                #pk_soft_dev tbody{
                    display:block;
                    height:100px;
                    overflow:auto;//set tbody to auto
                }
                #pk_soft_dev th,#pk_soft_dev td{
                    width:100px;//fixed width
                }
                </style>";*/
        $html .= "<table cellspacing='0' cellpadding='3' width='100%' id='pk_soft_dev' >
            <thead>
            <tr style='border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <th style='border: 1px solid #dddddd;width:25px;' ><b>No</b></th>
                <th style='border: 1px solid #dddddd;width:75px;' ><b>Nomor SSID</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Problem Subject</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Actual Start</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Mark Finish</b></th> 
                <th style='border: 1px solid #dddddd;' ><b>Satisfaction</b></th>
            </tr>
            </thead>
        ";
        $html.='<tbody>';


        $sqlto ="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
            where 
            #raw ldeleted
            raw.Deleted='No' AND
            #activity type Maintenance Server dari virus dan Junk data user yang tidak berhubungan dengan kantor
            raw.activity_id=221 AND
            #status SS telah finish
            raw.taskStatus='Finish' AND
            #pic nip pengusul dan requestor bukan nip pengusul
            raw.requestor not in ('".$cNipNya."') AND raw.pic like '%".$cNipNya."%' AND
            #interval waktu penilaian
            raw.tMarkedAsFinished between '".$perode1."' AND '".$perode2."'
            ORDER BY raw.satisfaction_value DESC
            LIMIT 6"; 
 
        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $satis=array();
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                /*Cek Hasil*/
                if($v['tMarkedAsFinished']!='' or $v['tMarkedAsFinished']!=NULL or $v['tMarkedAsFinished']!='1970-01-01' or $v['tMarkedAsFinished']!='0000-00-00'){
                    $mark=date('Y-m-d H:m:s', strtotime($v['tMarkedAsFinished']));
                    if($mark=='1970-01-01'){
                        $mark='';
                    }
                }
                $actual='';
                if($v['actual_start']!='' or $v['actual_start']!=NULL or $v['actual_start']!='1970-01-01' or $v['actual_start']!='0000-00-00'){
                    $actual=date('Y-m-d H:m:s', strtotime($v['actual_start']));
                    if($actual=='1970-01-01'){
                        $actual='';
                    }
                }

                $dlink=explode("/",base_url());
                $dlink[3]="ss";
                $linkss=implode("/",$dlink);
                $html .= '<tr style="border: 1px solid #dddddd; border-collapse: collapse;'.$color.'"> 
                            <td style="text-align: center;border: 1px solid #dddddd;width:25px;" >'.$no.'</td>

                            <td style="text-align: left;border: 1px solid #dddddd;width:75px;">
                                <a href="javascript:void(0);" title="'.$v['problem_subject'].'" onclick="window.open(\''.$linkss.'index.php/rawproblems/detail/'.$v['id'].'\', \'_blank\', 
                        \'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0,top=84,left=283\');">'.$v['id'].'</a></td>'; 
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['problem_subject'].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$actual.'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$mark.'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['satisfaction_value'].'</td>';
                $html.='</tr>';
                $no++;
                $satis[]=$v['satisfaction_value'];
            }
        } 
        $html.='</tbody>';
        $html .="</table>";
        
        $total=0;
        $no=$no-1;
        $pembilang=0;
        $total=0;
        if($no >= 1){
            $pembilang = array_sum($satis); 
            if($pembilang!=0){
                $total=number_format(($pembilang/6),2);
            }
        }

        if($total<1){
            $result     = number_format(0,2);
        }else{
            $result     = number_format($total,2);
        }

        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah Satisfaction :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$pembilang."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah / 6  :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$result." %</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function TSPERFM_04($post){
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

       /* $html.="<style>
                #pk_soft_dev thead tr{
                    display:block;
                }
                #pk_soft_dev tbody{
                    display:block;
                    height:100px;
                    overflow:auto;//set tbody to auto
                }
                #pk_soft_dev th,#pk_soft_dev td{
                    width:100px;//fixed width
                }
                </style>";*/
        $html .= "<table cellspacing='0' cellpadding='3' width='100%' id='pk_soft_dev' >
            <thead>
            <tr style='border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <th style='border: 1px solid #dddddd;width:25px;' ><b>No</b></th>
                <th style='border: 1px solid #dddddd;width:75px;' ><b>Nomor SSID</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Problem Subject</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Actual Start</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Mark Finish</b></th> 
                <th style='border: 1px solid #dddddd;' ><b>Satisfaction</b></th>
            </tr>
            </thead>
        ";
        $html.='<tbody>';


        $sqlto ="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
            where 
            #raw ldeleted
            raw.Deleted='No' AND
            #activity type Maintenance - Cek & Update Account Email dan LDAP
            raw.activity_id=222 AND
            #status SS telah finish
            raw.taskStatus='Finish' AND
            #pic nip pengusul dan requestor bukan nip pengusul
            raw.requestor not in ('".$cNipNya."') AND raw.pic like '%".$cNipNya."%' AND
            #interval waktu penilaian
            raw.tMarkedAsFinished between '".$perode1."' AND '".$perode2."'
            ORDER BY raw.satisfaction_value DESC
            LIMIT 6"; 
 
        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $satis=array();
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                /*Cek Hasil*/
                if($v['tMarkedAsFinished']!='' or $v['tMarkedAsFinished']!=NULL or $v['tMarkedAsFinished']!='1970-01-01' or $v['tMarkedAsFinished']!='0000-00-00'){
                    $mark=date('Y-m-d H:m:s', strtotime($v['tMarkedAsFinished']));
                    if($mark=='1970-01-01'){
                        $mark='';
                    }
                }
                $actual='';
                if($v['actual_start']!='' or $v['actual_start']!=NULL or $v['actual_start']!='1970-01-01' or $v['actual_start']!='0000-00-00'){
                    $actual=date('Y-m-d H:m:s', strtotime($v['actual_start']));
                    if($actual=='1970-01-01'){
                        $actual='';
                    }
                }

                $dlink=explode("/",base_url());
                $dlink[3]="ss";
                $linkss=implode("/",$dlink);
                $html .= '<tr style="border: 1px solid #dddddd; border-collapse: collapse;'.$color.'"> 
                            <td style="text-align: center;border: 1px solid #dddddd;width:25px;" >'.$no.'</td>

                            <td style="text-align: left;border: 1px solid #dddddd;width:75px;">
                                <a href="javascript:void(0);" title="'.$v['problem_subject'].'" onclick="window.open(\''.$linkss.'index.php/rawproblems/detail/'.$v['id'].'\', \'_blank\', 
                        \'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0,top=84,left=283\');">'.$v['id'].'</a></td>'; 
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['problem_subject'].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$actual.'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$mark.'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['satisfaction_value'].'</td>';
                $html.='</tr>';
                $no++;
                $satis[]=$v['satisfaction_value'];
            }
        } 
        $html.='</tbody>';
        $html .="</table>";
        
        $total=0;
        $no=$no-1;
        $pembilang=0;
        $total=0;
        if($no >= 1){
            $pembilang = array_sum($satis); 
            if($pembilang!=0){
                $total=number_format(($pembilang/6),2);
            }
        }

        if($total<1){
            $result     = number_format(0,2);
        }else{
            $result     = number_format($total,2);
        }

        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah Satisfaction :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$pembilang."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah / 6  :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$result." %</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function TSPERFM_07($post){
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

       /* $html.="<style>
                #pk_soft_dev thead tr{
                    display:block;
                }
                #pk_soft_dev tbody{
                    display:block;
                    height:100px;
                    overflow:auto;//set tbody to auto
                }
                #pk_soft_dev th,#pk_soft_dev td{
                    width:100px;//fixed width
                }
                </style>";*/
        $html .= "<table cellspacing='0' cellpadding='3' width='100%' id='pk_soft_dev' >
            <thead>
            <tr style='border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <th style='border: 1px solid #dddddd;width:25px;' ><b>No</b></th>
                <th style='border: 1px solid #dddddd;width:75px;' ><b>Nomor SSID</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Problem Subject</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Actual Start</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Mark Finish</b></th> 
                <th style='border: 1px solid #dddddd;' ><b>Satisfaction</b></th>
            </tr>
            </thead>
        ";
        $html.='<tbody>';


        $sqlto ="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
            where 
            #raw ldeleted
            raw.Deleted='No' AND
            #activity type Maintenance - Cek & Update Account Email dan LDAP
            raw.activity_id=223 AND
            #status SS telah finish
            raw.taskStatus='Finish' AND
            #pic nip pengusul dan requestor bukan nip pengusul
            raw.requestor not in ('".$cNipNya."') AND raw.pic like '%".$cNipNya."%' AND
            #interval waktu penilaian
            raw.tMarkedAsFinished between '".$perode1."' AND '".$perode2."'
            ORDER BY raw.satisfaction_value DESC
            LIMIT 6"; 
 
        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $satis=array();
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                /*Cek Hasil*/
                if($v['tMarkedAsFinished']!='' or $v['tMarkedAsFinished']!=NULL or $v['tMarkedAsFinished']!='1970-01-01' or $v['tMarkedAsFinished']!='0000-00-00'){
                    $mark=date('Y-m-d H:m:s', strtotime($v['tMarkedAsFinished']));
                    if($mark=='1970-01-01'){
                        $mark='';
                    }
                }
                $actual='';
                if($v['actual_start']!='' or $v['actual_start']!=NULL or $v['actual_start']!='1970-01-01' or $v['actual_start']!='0000-00-00'){
                    $actual=date('Y-m-d H:m:s', strtotime($v['actual_start']));
                    if($actual=='1970-01-01'){
                        $actual='';
                    }
                }

                $dlink=explode("/",base_url());
                $dlink[3]="ss";
                $linkss=implode("/",$dlink);
                $html .= '<tr style="border: 1px solid #dddddd; border-collapse: collapse;'.$color.'"> 
                            <td style="text-align: center;border: 1px solid #dddddd;width:25px;" >'.$no.'</td>

                            <td style="text-align: left;border: 1px solid #dddddd;width:75px;">
                                <a href="javascript:void(0);" title="'.$v['problem_subject'].'" onclick="window.open(\''.$linkss.'index.php/rawproblems/detail/'.$v['id'].'\', \'_blank\', 
                        \'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0,top=84,left=283\');">'.$v['id'].'</a></td>'; 
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['problem_subject'].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$actual.'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$mark.'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['satisfaction_value'].'</td>';
                $html.='</tr>';
                $no++;
                $satis[]=$v['satisfaction_value'];
            }
        } 
        $html.='</tbody>';
        $html .="</table>";
        
        $total=0;
        $no=$no-1;
        $pembilang=0;
        $total=0;
        if($no >= 1){
            $pembilang = array_sum($satis); 
            if($pembilang!=0){
                $total=number_format(($pembilang/6),2);
            }
        }

        if($total<1){
            $result     = number_format(0,2);
        }else{
            $result     = number_format($total,2);
        }

        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah Satisfaction :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$pembilang."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah / 6  :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$result." %</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function TSPERFM_08($post){
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

       /* $html.="<style>
                #pk_soft_dev thead tr{
                    display:block;
                }
                #pk_soft_dev tbody{
                    display:block;
                    height:100px;
                    overflow:auto;//set tbody to auto
                }
                #pk_soft_dev th,#pk_soft_dev td{
                    width:100px;//fixed width
                }
                </style>";*/
        $html .= "<table cellspacing='0' cellpadding='3' width='100%' id='pk_soft_dev' >
            <thead>
            <tr style='border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <th style='border: 1px solid #dddddd;width:25px;' ><b>No</b></th>
                <th style='border: 1px solid #dddddd;width:75px;' ><b>Nomor SSID</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Problem Subject</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Task Status</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Tanggal Finish</b></th> 
                <th style='border: 1px solid #dddddd;' ><b>Unfinish</b></th>
            </tr>
            </thead>
        ";
        $html.='<tbody>';


        $sqlto ="SELECT b.* FROM  hrd.ss_raw_problems b 
                #mengambil task finish dan satisfaction gx null
                WHERE b.taskStatus ='Finish' AND b.satisfaction_value IS NOT NULL AND b.Deleted='No' 
                AND b.finishing_by IS NOT NULL 
                #not requested
                AND b.requestor NOT IN ('".$cNipNya."') 
                AND b.pic LIKE '%".$cNipNya."%' AND 
                b.tMarkedAsFinished BETWEEN '".$perode1."' AND '".$perode2."'"; 
 
        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $satis=array();
        $pembagi=0;
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                $sq = "SELECT so.commentType FROM hrd.ss_solution so WHERE so.commentType IN (5) AND so.id ='".$v['id']."'";
                
                $ss=$this->db_erp_pk->query($sq);
                $un='';
                if($ss->num_rows>0){
                    $un="Unfinish";
                    $color = 'background-color: #f45342';
                    $pembagi++;
                }

                $dlink=explode("/",base_url());
                $dlink[3]="ss";
                $linkss=implode("/",$dlink);
                $html .= '<tr style="border: 1px solid #dddddd; border-collapse: collapse;'.$color.'"> 
                            <td style="text-align: center;border: 1px solid #dddddd;width:25px;" >'.$no.'</td>

                            <td style="text-align: left;border: 1px solid #dddddd;width:75px;">
                                <a href="javascript:void(0);" title="'.$v['problem_subject'].'" onclick="window.open(\''.$linkss.'index.php/rawproblems/detail/'.$v['id'].'\', \'_blank\', 
                        \'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0,top=84,left=283\');">'.$v['id'].'</a></td>'; 
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['problem_subject'].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['taskStatus'].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['tMarkedAsFinished'].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$un.'</td>';
                $html.='</tr>';
                $no++;
            }
        } 
        $html.='</tbody>';
        $html .="</table>";
        
        $total=0;
        $no=$no-1;
        $totFinish = $no;
        $unfinish = $pembagi;
        if($no >= 1){
            if($pembagi!=0){
                $rata = $unfinish/$totFinish ;//* 100;
                $total = $rata * 100;
            }
        }

        if($total<1){
            $result     = number_format(0,2);
        }else{
            $result     = number_format($total,2);
        }

        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Total Task UnFinisih :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$unfinish." SSID</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Total Task Finisih :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$totFinish." SSID</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Persentase :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$result." %</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function TSPERFM_10($post){
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

       /* $html.="<style>
                #pk_soft_dev thead tr{
                    display:block;
                }
                #pk_soft_dev tbody{
                    display:block;
                    height:100px;
                    overflow:auto;//set tbody to auto
                }
                #pk_soft_dev th,#pk_soft_dev td{
                    width:100px;//fixed width
                }
                </style>";*/
        $html .= "<table cellspacing='0' cellpadding='3' width='100%' id='pk_soft_dev' >
            <thead>
            <tr style='border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <th style='border: 1px solid #dddddd;width:25px;' ><b>No</b></th>
                <th style='border: 1px solid #dddddd;width:75px;' ><b>Nomor SSID</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Problem Subject</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Accepted Date</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Date Posted</b></th> 
                <th style='border: 1px solid #dddddd;' ><b>Selisih Jam</b></th>
            </tr>
            </thead>
        ";
        $html.='<tbody>';


        $sqlto ="SELECT z.id,z.problem_subject, z.date_posted,z.assignTime, 
            z.actual_start,z.startDuration,z.input_date,z.commentType,
            z.vType, z.solution_id FROM (
            SELECT a.id,b.solution_id,a.problem_subject, a.date_posted, CASE WHEN a.approveDate IS NOT NULL THEN a.approveDate
                WHEN a.assignTime IS NOT NULL THEN a.assignTime  ELSE a.date_posted END assignTime,
                            a.actual_start,b.startDuration,b.input_date,b.commentType,
                            b.vType
                            FROM hrd.ss_raw_problems a 
                            JOIN hrd.ss_solution b ON b.id = a.id
                            WHERE 
                            #Bukan Req
                            a.requestor NOT IN ('".$cNipNya."') 
                            AND a.pic LIKE '%".$cNipNya."%'
                            #AND a.parent_id != 0
                            AND DATE(a.date_posted) BETWEEN '".$perode1."' AND '".$perode2."'
                            AND CASE WHEN (SELECT assign FROM hrd.ss_support_type WHERE typeId=a.typeId)='Y'
                                THEN (b.commentType = 2) END
                            #AND a.activity_id != 22
                            AND b.pic LIKE '%".$cNipNya."%'
                            AND (b.isDeleted = 0 OR b.isDeleted IS NULL)
            UNION
            SELECT a.id,b.solution_id,a.problem_subject, a.date_posted, CASE WHEN a.approveDate IS NOT NULL THEN a.approveDate
                WHEN a.assignTime IS NOT NULL THEN a.assignTime  ELSE a.date_posted END assignTime,
                            a.actual_start,b.startDuration,b.input_date,b.commentType,
                            b.vType
                            FROM hrd.ss_raw_problems a 
                            JOIN hrd.ss_solution b ON b.id = a.id
                            WHERE 
                            #Bukan Req
                            a.requestor NOT IN ('".$cNipNya."') 
                            AND a.pic LIKE '%".$cNipNya."%'
                            #AND a.parent_id != 0
                            AND DATE(a.date_posted) BETWEEN '".$perode1."' AND '".$perode2."'
                            AND b.commentType = 50
                            #AND a.activity_id != 22
                            AND b.pic LIKE '%".$cNipNya."%'
                            AND (b.isDeleted = 0 OR b.isDeleted IS NULL)
        ) AS z
        GROUP BY z.id, z.vType
        ORDER BY z.date_posted,z.solution_id"; 
 
        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $cc=0;
        $pembagi=0;
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                $id = $v['id'];

                $subject = $v['problem_subject'];
                $date_posted = $v['date_posted'];
                $assignTime = $v['assignTime'];
                $actual_start = $v['actual_start'];


                if( $v['vType'] == 'Joblog' ) {
                    $start_duration = (empty($assignTime)||strtotime($assignTime)<strtotime($date_posted))?$date_posted:$assignTime;
                    $input_date = $v['startDuration'];
                } else {
                    $start_def = (empty($assignTime))?$date_posted:$assignTime;
                    $start_duration = (empty($v['startDuration']))?$start_def:$v['startDuration'];                  
                    $input_date = $v['input_date'];
                }
                
                $selisih=($this->selisihJam($start_duration, $input_date, $cNipNya)) *24*3600;
                
                $time = (strtotime($input_date)-strtotime($start_duration)) - $selisih;
                $durasi=0;
                if($time <=0){
                    $durasi = 0;
                }else{
                    $nn=$time/3600;
                    $durasi = number_format( $nn, 2) ;
                }

                $dlink=explode("/",base_url());
                $dlink[3]="ss";
                $linkss=implode("/",$dlink);
                $html .= '<tr style="border: 1px solid #dddddd; border-collapse: collapse;'.$color.'"> 
                            <td style="text-align: center;border: 1px solid #dddddd;width:25px;" >'.$no.'</td>

                            <td style="text-align: left;border: 1px solid #dddddd;width:75px;">
                                <a href="javascript:void(0);" title="'.$v['problem_subject'].'" onclick="window.open(\''.$linkss.'index.php/rawproblems/detail/'.$v['id'].'\', \'_blank\', 
                        \'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0,top=84,left=283\');">'.$v['id'].'</a></td>'; 
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['problem_subject'].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$input_date.'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$start_duration.'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$durasi.'</td>';
                $html.='</tr>';
                $no++;
                $cc= $durasi+$cc;
            }
        } 
        $html.='</tbody>';
        $html .="</table>";
        
        $total=0;
        $no=$no-1;
        $selisih=0;
        if($cc>0){
            $selisih=$cc;
            $total=$selisih/$no;
        }

        if($total<1){
            $result     = number_format(0,2);
        }else{
            $result     = number_format($total,2);
        }

        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah selisih :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$selisih." Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah Task :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$no." SSID</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Rata-Rata Kecepatan :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$result." Jam</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function TSPERFM_11($post){
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

       /* $html.="<style>
                #pk_soft_dev thead tr{
                    display:block;
                }
                #pk_soft_dev tbody{
                    display:block;
                    height:100px;
                    overflow:auto;//set tbody to auto
                }
                #pk_soft_dev th,#pk_soft_dev td{
                    width:100px;//fixed width
                }
                </style>";*/
        $html .= "<table cellspacing='0' cellpadding='3' width='100%' id='pk_soft_dev' >
            <thead>
            <tr style='border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <th style='border: 1px solid #dddddd;width:25px;' ><b>No</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Tanggal</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Jam Masuk</b></th> 
            </tr>
            </thead>
        ";
        $html.='<tbody>';


        $sqlto ="SELECT b.cin, b.dAbsensi FROM hrd.msabsen b 
                WHERE b.cin > '08:00:00' AND b.cin !=''
                AND b.cNip LIKE '%".$cNipNya."%' AND b.dAbsensi
                BETWEEN '".$perode1."' AND '".$perode2."'"; 
 
        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        if(!empty($b)){
            foreach ($b as $v) {
                $ini=$this->CekoptionalFunc11(date('Y-m-d',strtotime($v['dAbsensi'])),$cNipNya);
                if($ini==false){
                    if (fmod($no,2)==0){
                        $color = 'background-color: #eaedce';
                    }else{
                        $color = '';
                    }
                    $html .= '<tr style="border: 1px solid #dddddd; border-collapse: collapse;'.$color.'"> 
                                <td style="text-align: center;border: 1px solid #dddddd;width:25px;" >'.$no.'</td>';
                    $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['dAbsensi'].'</td>';
                    $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['cin'].'</td>';
                    $html.='</tr>';
                    $no++;
                }
            }
        } 
        $html.='</tbody>';
        $html .="</table>";
        
        $total=0;
        $no=$no-1;
        $total=$no;

        if($total<1){
            $result     = number_format(0,2);
        }else{
            $result     = number_format($total,2);
        }

        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Total Jumlah Hadir Telat dalam 1 Periode :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$result." Jam</b></td>
                    </tr>
                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function TSPERFM_12($post){
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

       /* $html.="<style>
                #pk_soft_dev thead tr{
                    display:block;
                }
                #pk_soft_dev tbody{
                    display:block;
                    height:100px;
                    overflow:auto;//set tbody to auto
                }
                #pk_soft_dev th,#pk_soft_dev td{
                    width:100px;//fixed width
                }
                </style>";*/
        $html .= "<table cellspacing='0' cellpadding='3' width='100%' id='pk_soft_dev' >
            <thead>
            <tr style='border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <th style='border: 1px solid #dddddd;width:25px;' ><b>No</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Bulan</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Jumlah</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Nilai</b></th>
            </tr>
            </thead>
        ";
        $html.='<tbody>';

        $sql1 = "SELECT * FROM hrd.dshift da
                    INNER JOIN hrd.gshift gs ON da.iShiftID=gs.iShiftID
                    INNER JOIN hrd.employee em ON em.igshiftid=gs.iGShiftID
                    WHERE em.cNip='".$cNipNya."' AND (da.ciIn!='00:00:00' OR da.ciEnd!='00:00:00')";
        // Cek Area
        //$sql1 ="SELECT a.`iArea` FROM hrd.employee a WHERE a.`cNip`='".$this->nippemohon."'";
        $qsqlmain1 = $this->db_erp_pk->query($sql1);
            
        $dtmain=$qsqlmain1->num_rows();
        $cout ="17:00:00";
        if($dtmain==5){
            $cout ="18:00:00";
        }

        $sqlto ="SELECT DISTINCT
                    (
                    SELECT COUNT(*) FROM hrd.msabsen aa
                    WHERE aa.cNip = '".$cNipNya."'
                    AND MONTH(aa.dAbsensi)=MONTH(a.dAbsensi )
                    # AND YEAR(aa.dAbsensi)=2016
                    AND aa.cout>'".$cout."' AND aa.cout <> ':  :' AND aa.cout != '' AND aa.dAbsensi BETWEEN '".$perode1."' AND '".$perode2."'
                    ) 
                        AS piket, MONTH(a.dAbsensi) AS bln
                        FROM hrd.msabsen a
                        WHERE a.cNip='".$cNipNya."'

                        # AND month(a.dAbsensi)=12
                        AND a.dAbsensi BETWEEN '".$perode1."' AND '".$perode2."'
                        # AND YEAR(a.dAbsensi)=2016
                        GROUP BY MONTH(a.dAbsensi)"; 
 
        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $bulan = array(0=>'January',1=>'February',2=>'Maret',3=>'April',4=>'May',5=>'Juni',6=>'Juli',7=>'Agustus',8=>'September',9=>'Oktober',10=>'November',11=>'Desember');
        $no = 1;
        $cc=0;
        $tot=0;
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }
                $n=0;
                if($v['piket']>=10){
                    $tot += 100;
                    $n = 100;
                }else if($v['piket']>=9){
                    $tot += 80;
                    $n = 80;
                }else if($v['piket']>=8){
                    $tot += 60;
                    $n = 60;
                }else if($v['piket']>=7){
                    $tot += 40;
                    $n = 40;
                }else{
                    $tot += 20;
                    $n = 20;
                }

                $html .= '<tr style="border: 1px solid #dddddd; border-collapse: collapse;'.$color.'"><td style="text-align: center;border: 1px solid #dddddd;width:25px;" >'.$no.'</td>'; 
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$bulan[$v['bln']-1].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['piket'].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$n.'</td>';
                $html.='</tr>';
                $html.='<tr id="row_'.$bulan[$v['bln']-1].'">';
                $html.='<td colspan="4"  style="text-align: left;border: 1px solid #dddddd;">';
                $html.='<table width="100%" style="border-collapse:collapse;border: 1px solid #dddddd;">
                                <tr bgcolor="#D3D3D3">
                                    <th width="25px" style="text-align: center;">No</th>
                                    <th style="text-align: center;">Tanggal</th>
                                    <th style="text-align: center;">Jam Keluar</th>
                                </tr>';

                                $sql = "SELECT * FROM hrd.msabsen a WHERE a.cNip='".$cNipNya."' 
                                        AND a.cout>'".$cout."' AND a.cout != ':  :' AND a.cout != '' AND a.dAbsensi BETWEEN '".$perode1."' AND '".$perode2."' AND MONTH(a.dAbsensi) = ".$v['bln'];
                                $dt = $this->db_erp_pk->query($sql)->result_array();
                                $xyz = 1;
                                foreach ($dt as $key) {
                $html.='<tr style="border: 1px solid #dddddd;"><td width="25px" style="text-align: center;">'.$xyz.'</td><td style="text-align: center;">'.$key['dAbsensi'].'</td><td style="text-align: center;">'.$key['cout'].'</td></tr>';
                                    $xyz++;
                                }
                $html.='</table>';
                $html.='</td></tr>';
                $no++;
            }
        } 
        $html.='</tbody>';
        $html .="</table>";
        $total=0;
        $selisih=0;
        if($tot>0){
           $total=number_format( $tot/6, 2, '.', '' );
        }

        if($total<1){
            $result     = number_format(0,2);
        }else{
            $result     = number_format($total,2);
        }

        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Total Nilai :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$tot."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Rata - Rata Nilai / Semester :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$result."</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function TSPERFM_14($post){
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

       /* $html.="<style>
                #pk_soft_dev thead tr{
                    display:block;
                }
                #pk_soft_dev tbody{
                    display:block;
                    height:100px;
                    overflow:auto;//set tbody to auto
                }
                #pk_soft_dev th,#pk_soft_dev td{
                    width:100px;//fixed width
                }
                </style>";*/
        $html .= "<table cellspacing='0' cellpadding='3' width='100%' id='pk_soft_dev' >
            <thead>
            <tr style='border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <th style='border: 1px solid #dddddd;width:25px;' ><b>No</b></th>
                <th style='border: 1px solid #dddddd;width:75px;' ><b>Nomor SSID</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Problem Subject</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Satisfaction value</b></th>
            </tr>
            </thead>
        ";
        $html.='<tbody>';


        $sqlto ="SELECT * FROM  hrd.ss_raw_problems b 
                WHERE b.satisfaction_value IS NOT NULL AND b.satisfaction_value > 0  AND  b.taskStatus = 'Finish' AND
                b.pic LIKE '".$cNipNya."' AND b.Deleted='No' AND
                b.`tMarkedAsFinished` BETWEEN '".$perode1."' AND '".$perode2."'";
 
        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $cc=0;
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                $id = $v['id'];

               
                $dlink=explode("/",base_url());
                $dlink[3]="ss";
                $linkss=implode("/",$dlink);
                $html .= '<tr style="border: 1px solid #dddddd; border-collapse: collapse;'.$color.'"> 
                            <td style="text-align: center;border: 1px solid #dddddd;width:25px;" >'.$no.'</td>

                            <td style="text-align: left;border: 1px solid #dddddd;width:75px;">
                                <a href="javascript:void(0);" title="'.$v['problem_subject'].'" onclick="window.open(\''.$linkss.'index.php/rawproblems/detail/'.$v['id'].'\', \'_blank\', 
                        \'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0,top=84,left=283\');">'.$v['id'].'</a></td>'; 
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['problem_subject'].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['satisfaction_value'].'</td>';
                $html.='</tr>';
                $no++;
                $cc= $v['satisfaction_value']+$cc;
            }
        } 
        $html.='</tbody>';
        $html .="</table>";
        
        $total=0;
        $no=$no-1;
        $selisih=0;
        if($cc>0){
            $selisih=$cc;
            $total=$selisih/$no;
        }

        if($total<1){
            $result     = number_format(0,2);
        }else{
            $result     = number_format($total,2);
        }

        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah Satisfaction :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$selisih."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah Task Finish :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$no." SSID</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Rata - Rata :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$result."</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function TSPERFM_16($post){
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

       /* $html.="<style>
                #pk_soft_dev thead tr{
                    display:block;
                }
                #pk_soft_dev tbody{
                    display:block;
                    height:100px;
                    overflow:auto;//set tbody to auto
                }
                #pk_soft_dev th,#pk_soft_dev td{
                    width:100px;//fixed width
                }
                </style>";*/
        $html .= "<table cellspacing='0' cellpadding='3' width='100%' id='pk_soft_dev' >
            <thead>
            <tr style='border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <th style='border: 1px solid #dddddd;width:25px;' ><b>No</b></th>
                <th style='border: 1px solid #dddddd;width:75px;' ><b>Nomor SSID</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Problem Subject</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Actual Start</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Mark Finish</b></th> 
                <th style='border: 1px solid #dddddd;' ><b>Satisfaction</b></th>
            </tr>
            </thead>
        ";
        $html.='<tbody>';


        $sqlto ="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
            where 
            #raw ldeleted
            raw.Deleted='No' AND
            #activity type Maintenance - Bandwith Monitoring 
            raw.activity_id=230 AND
            #status SS telah finish
            raw.taskStatus='Finish' AND
            #pic nip pengusul dan requestor bukan nip pengusul
            raw.requestor not in ('".$cNipNya."') AND raw.pic like '%".$cNipNya."%' AND
            #interval waktu penilaian
            raw.tMarkedAsFinished between '".$perode1."' AND '".$perode2."'
            ORDER BY raw.satisfaction_value DESC
            LIMIT 6"; 
 
        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $pembagi=0;
        $satis=array();
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                $id = $v['id'];
                if($v['tMarkedAsFinished']!='' or $v['tMarkedAsFinished']!=NULL or $v['tMarkedAsFinished']!='1970-01-01' or $v['tMarkedAsFinished']!='0000-00-00'){
                    $mark=date('Y-m-d H:m:s', strtotime($v['tMarkedAsFinished']));
                    if($mark=='1970-01-01'){
                        $mark='';
                    }
                }
                $actual='';
                if($v['actual_start']!='' or $v['actual_start']!=NULL or $v['actual_start']!='1970-01-01' or $v['actual_start']!='0000-00-00'){
                    $actual=date('Y-m-d H:m:s', strtotime($v['actual_start']));
                    if($actual=='1970-01-01'){
                        $actual='';
                    }
                }

                $dlink=explode("/",base_url());
                $dlink[3]="ss";
                $linkss=implode("/",$dlink);
                $html .= '<tr style="border: 1px solid #dddddd; border-collapse: collapse;'.$color.'"> 
                            <td style="text-align: center;border: 1px solid #dddddd;width:25px;" >'.$no.'</td>

                            <td style="text-align: left;border: 1px solid #dddddd;width:75px;">
                                <a href="javascript:void(0);" title="'.$v['problem_subject'].'" onclick="window.open(\''.$linkss.'index.php/rawproblems/detail/'.$v['id'].'\', \'_blank\', 
                        \'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0,top=84,left=283\');">'.$v['id'].'</a></td>'; 
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['problem_subject'].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$actual.'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$mark.'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['satisfaction_value'].'</td>';
                $html.='</tr>';
                $satis[]=$v['satisfaction_value'];
                $no++;
            }
        } 
        $html.='</tbody>';
        $html .="</table>";
        $c=$no-1;
        $pembilang =0; 
        $rat=0;
        if ($c<>0) {
            $pembilang = array_sum($satis); 
            $rat=0;
            if($pembilang!=0){
                $rat=number_format(($pembilang/6),2);
            }
        }
        $total=$rat;

        if($total<1){
            $result     = number_format(0,2);
        }else{
            $result     = number_format($total,2);
        }

        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah Satisfaction: :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$pembilang."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah / 6 :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$result."</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function TSPERFM_05($post){
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

       /* $html.="<style>
                #pk_soft_dev thead tr{
                    display:block;
                }
                #pk_soft_dev tbody{
                    display:block;
                    height:100px;
                    overflow:auto;//set tbody to auto
                }
                #pk_soft_dev th,#pk_soft_dev td{
                    width:100px;//fixed width
                }
                </style>";*/
        $html .= "<table cellspacing='0' cellpadding='3' width='100%' id='pk_soft_dev' >
            <thead>
            <tr style='border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <th style='border: 1px solid #dddddd;width:25px;' ><b>No</b></th>
                <th style='border: 1px solid #dddddd;width:75px;' ><b>Nomor SSID</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Problem Subject</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Actual Start</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Mark Finish</b></th> 
                <th style='border: 1px solid #dddddd;' ><b>Satisfaction</b></th>
            </tr>
            </thead>
        ";
        $html.='<tbody>';


        $sqlto ="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
            where 
            #raw ldeleted
            raw.Deleted='No' AND
            #Maintenance – Backup Server 
            raw.activity_id=225 AND
            #status SS telah finish
            raw.taskStatus='Finish' AND
            #pic nip pengusul dan requestor bukan nip pengusul
            raw.requestor not in ('".$cNipNya."') AND raw.pic like '%".$cNipNya."%' AND
            #interval waktu penilaian
            raw.tMarkedAsFinished between '".$perode1."' AND '".$perode2."'
            ORDER BY raw.satisfaction_value DESC
            LIMIT 6"; 
 
        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $pembagi=0;
        $satis=array();
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                $id = $v['id'];
                if($v['tMarkedAsFinished']!='' or $v['tMarkedAsFinished']!=NULL or $v['tMarkedAsFinished']!='1970-01-01' or $v['tMarkedAsFinished']!='0000-00-00'){
                    $mark=date('Y-m-d H:m:s', strtotime($v['tMarkedAsFinished']));
                    if($mark=='1970-01-01'){
                        $mark='';
                    }
                }
                $actual='';
                if($v['actual_start']!='' or $v['actual_start']!=NULL or $v['actual_start']!='1970-01-01' or $v['actual_start']!='0000-00-00'){
                    $actual=date('Y-m-d H:m:s', strtotime($v['actual_start']));
                    if($actual=='1970-01-01'){
                        $actual='';
                    }
                }

                $dlink=explode("/",base_url());
                $dlink[3]="ss";
                $linkss=implode("/",$dlink);
                $html .= '<tr style="border: 1px solid #dddddd; border-collapse: collapse;'.$color.'"> 
                            <td style="text-align: center;border: 1px solid #dddddd;width:25px;" >'.$no.'</td>

                            <td style="text-align: left;border: 1px solid #dddddd;width:75px;">
                                <a href="javascript:void(0);" title="'.$v['problem_subject'].'" onclick="window.open(\''.$linkss.'index.php/rawproblems/detail/'.$v['id'].'\', \'_blank\', 
                        \'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0,top=84,left=283\');">'.$v['id'].'</a></td>'; 
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['problem_subject'].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$actual.'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$mark.'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['satisfaction_value'].'</td>';
                $html.='</tr>';
                $satis[]=$v['satisfaction_value'];
                $no++;
            }
        } 
        $html.='</tbody>';
        $html .="</table>";
        $c=$no-1;
        $pembilang =0; 
        $rat=0;
        if ($c<>0) {
            $pembilang = array_sum($satis); 
            $rat=0;
            if($pembilang!=0){
                $rat=number_format(($pembilang/6),2);
            }
        }
        $total=$rat;

        if($total<1){
            $result     = number_format(0,2);
        }else{
            $result     = number_format($total,2);
        }

        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah Satisfaction: :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$pembilang."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah / 6 :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$result."</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function TSPERFM_06($post){
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

       /* $html.="<style>
                #pk_soft_dev thead tr{
                    display:block;
                }
                #pk_soft_dev tbody{
                    display:block;
                    height:100px;
                    overflow:auto;//set tbody to auto
                }
                #pk_soft_dev th,#pk_soft_dev td{
                    width:100px;//fixed width
                }
                </style>";*/
        $html .= "<table cellspacing='0' cellpadding='3' width='100%' id='pk_soft_dev' >
            <thead>
            <tr style='border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <th style='border: 1px solid #dddddd;width:25px;' ><b>No</b></th>
                <th style='border: 1px solid #dddddd;width:75px;' ><b>Nomor SSID</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Problem Subject</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Actual Start</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Mark Finish</b></th> 
                <th style='border: 1px solid #dddddd;' ><b>Satisfaction</b></th>
            </tr>
            </thead>
        ";
        $html.='<tbody>';


        $sqlto ="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
            where 
            #raw ldeleted
            raw.Deleted='No' AND
            #Maintenance – Pengecekan Penarikan Email 
            raw.activity_id=226 AND
            #status SS telah finish
            raw.taskStatus='Finish' AND
            #pic nip pengusul dan requestor bukan nip pengusul
            raw.requestor not in ('".$cNipNya."') AND raw.pic like '%".$cNipNya."%' AND
            #interval waktu penilaian
            raw.tMarkedAsFinished between '".$perode1."' AND '".$perode2."'
            ORDER BY raw.satisfaction_value DESC
            LIMIT 6"; 
 
        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $pembagi=0;
        $satis=array();
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                $id = $v['id'];
                if($v['tMarkedAsFinished']!='' or $v['tMarkedAsFinished']!=NULL or $v['tMarkedAsFinished']!='1970-01-01' or $v['tMarkedAsFinished']!='0000-00-00'){
                    $mark=date('Y-m-d H:m:s', strtotime($v['tMarkedAsFinished']));
                    if($mark=='1970-01-01'){
                        $mark='';
                    }
                }
                $actual='';
                if($v['actual_start']!='' or $v['actual_start']!=NULL or $v['actual_start']!='1970-01-01' or $v['actual_start']!='0000-00-00'){
                    $actual=date('Y-m-d H:m:s', strtotime($v['actual_start']));
                    if($actual=='1970-01-01'){
                        $actual='';
                    }
                }

                $dlink=explode("/",base_url());
                $dlink[3]="ss";
                $linkss=implode("/",$dlink);
                $html .= '<tr style="border: 1px solid #dddddd; border-collapse: collapse;'.$color.'"> 
                            <td style="text-align: center;border: 1px solid #dddddd;width:25px;" >'.$no.'</td>

                            <td style="text-align: left;border: 1px solid #dddddd;width:75px;">
                                <a href="javascript:void(0);" title="'.$v['problem_subject'].'" onclick="window.open(\''.$linkss.'index.php/rawproblems/detail/'.$v['id'].'\', \'_blank\', 
                        \'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0,top=84,left=283\');">'.$v['id'].'</a></td>'; 
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['problem_subject'].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$actual.'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$mark.'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['satisfaction_value'].'</td>';
                $html.='</tr>';
                $satis[]=$v['satisfaction_value'];
                $no++;
            }
        } 
        $html.='</tbody>';
        $html .="</table>";
        $c=$no-1;
        $pembilang =0; 
        $rat=0;
        if ($c<>0) {
            $pembilang = array_sum($satis); 
            $rat=0;
            if($pembilang!=0){
                $rat=number_format(($pembilang/6),2);
            }
        }
        $total=$rat;

        if($total<1){
            $result     = number_format(0,2);
        }else{
            $result     = number_format($total,2);
        }

        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah Satisfaction: :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$pembilang."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah / 6 :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$result."</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function TSPERFM_09($post){
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

       /* $html.="<style>
                #pk_soft_dev thead tr{
                    display:block;
                }
                #pk_soft_dev tbody{
                    display:block;
                    height:100px;
                    overflow:auto;//set tbody to auto
                }
                #pk_soft_dev th,#pk_soft_dev td{
                    width:100px;//fixed width
                }
                </style>";*/
        $html .= "<table cellspacing='0' cellpadding='3' width='100%' id='pk_soft_dev' >
            <thead>
            <tr style='border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <th style='border: 1px solid #dddddd;width:25px;' ><b>No</b></th>
                <th style='border: 1px solid #dddddd;width:75px;' ><b>Nomor SSID</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Problem Subject</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Actual Start</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Mark Finish</b></th> 
                <th style='border: 1px solid #dddddd;' ><b>Satisfaction</b></th>
            </tr>
            </thead>
        ";
        $html.='<tbody>';


        $sqlto ="select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value from hrd.ss_raw_problems raw 
            where 
            #raw ldeleted
            raw.Deleted='No' AND
            #Maintenance – Daily/Weekly/Monthly Checklist  
            raw.activity_id=227 AND
            #status SS telah finish
            raw.taskStatus='Finish' AND
            #pic nip pengusul dan requestor bukan nip pengusul
            raw.requestor not in ('".$cNipNya."') AND raw.pic like '%".$cNipNya."%' AND
            #interval waktu penilaian
            raw.tMarkedAsFinished between '".$perode1."' AND '".$perode2."'
            ORDER BY raw.satisfaction_value DESC
            LIMIT 6"; 
 
        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $pembagi=0;
        $satis=array();
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                $id = $v['id'];
                if($v['tMarkedAsFinished']!='' or $v['tMarkedAsFinished']!=NULL or $v['tMarkedAsFinished']!='1970-01-01' or $v['tMarkedAsFinished']!='0000-00-00'){
                    $mark=date('Y-m-d H:m:s', strtotime($v['tMarkedAsFinished']));
                    if($mark=='1970-01-01'){
                        $mark='';
                    }
                }
                $actual='';
                if($v['actual_start']!='' or $v['actual_start']!=NULL or $v['actual_start']!='1970-01-01' or $v['actual_start']!='0000-00-00'){
                    $actual=date('Y-m-d H:m:s', strtotime($v['actual_start']));
                    if($actual=='1970-01-01'){
                        $actual='';
                    }
                }

                $dlink=explode("/",base_url());
                $dlink[3]="ss";
                $linkss=implode("/",$dlink);
                $html .= '<tr style="border: 1px solid #dddddd; border-collapse: collapse;'.$color.'"> 
                            <td style="text-align: center;border: 1px solid #dddddd;width:25px;" >'.$no.'</td>

                            <td style="text-align: left;border: 1px solid #dddddd;width:75px;">
                                <a href="javascript:void(0);" title="'.$v['problem_subject'].'" onclick="window.open(\''.$linkss.'index.php/rawproblems/detail/'.$v['id'].'\', \'_blank\', 
                        \'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0,top=84,left=283\');">'.$v['id'].'</a></td>'; 
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['problem_subject'].'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$actual.'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$mark.'</td>';
                $html.='<td style="text-align: left;border: 1px solid #dddddd;">'.$v['satisfaction_value'].'</td>';
                $html.='</tr>';
                $satis[]=$v['satisfaction_value'];
                $no++;
            }
        } 
        $html.='</tbody>';
        $html .="</table>";
        $c=$no-1;
        $pembilang =0; 
        $rat=0;
        if ($c<>0) {
            $pembilang = array_sum($satis); 
            $rat=0;
            if($pembilang!=0){
                $rat=number_format(($pembilang/6),2);
            }
        }
        $total=$rat;

        if($total<1){
            $result     = number_format(0,2);
        }else{
            $result     = number_format($total,2);
        }

        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah Satisfaction: :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$pembilang."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                         <td style='border: 1px solid #dddddd;' colspan='10'><b>Jumlah / 6 :</b></td>
                         <td style='border: 1px solid #dddddd;'><b>".$result."</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }


    //==============================Start Funtion PK System ANalyst=====================================
    function hitungsa1($post)
    {
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
        
        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Est. Finish</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Finish Date</b></td>
            </tr>
        ";

        //$arrJadwal=$this->getJadwalKerja($cNipNya);
        
        $sqlto = "SELECT a.history_id, a.id, b.problem_subject, a.activity_id, a.estimated_finish,
				  a.actual_finish,a.date_posted,a.actual_start,a.activity_id,b.activity_id
				  FROM hrd.ss_raw_history a
				  LEFT JOIN hrd.ss_raw_problems b ON b.id = a.id
				  WHERE a.finishing_by ='$cNipNya' AND a.estimated_finish IS NOT NULL AND
				  DATE(a.actual_finish) BETWEEN '$perode1' AND LAST_DAY('$perode2')
				  AND b.activity_id NOT IN (22, 37)
				  ORDER BY a.history_id,a.id";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        foreach($rows as $row) {
            //$noRow++;
            $history_id = $row['history_id'];
            $raw_id = $row['id'];
            $subject = $row['problem_subject'];
            $est_finish = $row['estimated_finish'];
            $act_finish = $row['actual_finish'];
            $act_start  = $row['actual_start'];
            $date_posted = $row['date_posted'];

            $data_container[ $raw_id ][] = array('problem_subject'=>$subject,'est_finish'=>$est_finish,'act_finish'=>$act_finish,'act_start'=>$act_start,'date_posted'=>$date_posted);

        }        
        
        foreach($data_container as $raw_id => $data) {
            $noRow++;
            $jumlahDataPerId = count( $data_container[ $raw_id ] );

            if( $jumlahDataPerId > 3 ) {
                //$dump = end( $data_container[ $raw_id ] );
                $est_ = $data_container[ $raw_id ][3]['est_finish'];
                $act_ = $data_container[ $raw_id ][3]['act_finish'];
                $act2_ = $data_container[ $raw_id ][3]['act_start'];
                $date_ = $data_container[ $raw_id ][3]['date_posted'];

                $data_stored[$cNipNya][ $raw_id ]['est_finish'] = $est_;
                $data_stored[$cNipNya][ $raw_id ]['act_finish'] = $act_;
                $data_stored[$cNipNya][ $raw_id ]['act_start'] = $act2_;
                $data_stored[$cNipNya][ $raw_id ]['date_posted'] = $date_;
            }
            else {
                $dump = end( $data_container[ $raw_id ] );

                $data_stored[$cNipNya][ $raw_id ]['est_finish'] = $dump['est_finish'];
                $data_stored[$cNipNya][ $raw_id ]['act_finish'] = $dump['act_finish'];
                $data_stored[$cNipNya][ $raw_id ]['act_start'] = $dump['act_start'];
                $data_stored[$cNipNya][ $raw_id ]['date_posted'] = $dump['date_posted'];
            }
            $data_stored[$cNipNya][ $raw_id ]['problem_subject'] = $dump['problem_subject'];
                        
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }            
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $raw_id . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $dump['problem_subject'] . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $dump['est_finish'] . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $dump['act_finish'] . "</td>

                      </tr>";

            }

        $html .= "</table>";
        $hasil = $this->prosesHitPrg8( $data_stored );

        $total_hasil = $data_tepat = $data_all = 0;
        $data_tepat = isset($hasil['data_tepat'])?$hasil['data_tepat']:$data_tepat;
        $data_all = isset($hasil['data_all'])?$hasil['data_all']:$data_all;
        if( $data_all > 0 ) {
            $total_hasil = number_format($data_tepat/$data_all*100, 2);
        } else {
            $total_hasil = 0;
        }
        
        $getpoint = $this->getPoint($total_hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];
                
        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Task Sesuai Jadwal: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $data_tepat . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Seluruh Task: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $data_all . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $total_hasil . " %</b></td>
                    </tr>

                </table>";
        echo $total_hasil . "~" . $point . "~" . $warna . "~" . $html;
    }        
    function hitungsa2($post)    {
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

        $dayCount = 0;
        $hasWeeklyScheduleCount = 0;
        
        $workDays = $this->getWorkDay($cNipNya);
        $date = $perode1;
        $noRow = 0;
        while ($date < $perode2) {
            $noRow ++;
            while ($this->isOff($cNipNya, $workDays, $date)) {
                $date = date('Y-m-d', strtotime($date.' +1 days')); 
            }
            $dayCount++;
            $dUpTo = $this->getScheduleEndDate($cNipNya, $date);

            $q = $this->getScheduleQuery($cNipNya, $date, $dUpTo);

            $data = Array();
            $result = mysql_query($q) or die(mysql_error()."</br>".$q);
            while ($row = mysql_fetch_assoc($result)) {
                array_push($data, $row);
            }

            $rowCount = count($data);
            $hasSchedule = $this->hasSchedule($data, $debug);

            if ($hasSchedule) {
                $hasWeeklyScheduleCount++;              
   
                $html .= "</br>".$noRow.". Weekly Work Schedule: (".$hasWeeklyScheduleCount.")</br>"; 
                $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <td style='border: 1px solid #dddddd;' ><b>Date</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Duration </b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Schedule Frequency</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>ID</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>                        
                    </tr>
                ";       
                for ($i = 0; $i < $rowCount; $i++) { 
                    if (fmod($i, 2) == 0) {
                        $color = 'background-color: #eaedce';
                    } else {
                        $color = '';
                    }                     
                    $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                                <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                    " . $data[$i]['dDate'] . "</td>
                                <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                                    " . $data[$i]['yDuration2'] . "</td>
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                    " . $data[$i]['iScheduleFreq'] . "</td>
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                    " . $data[$i]['iSSID'] . "</td>
                                <td style='width:50%;text-align: center;border: 1px solid #dddddd;'>
                                    " . $data[$i]['problem_subject'] . "</td>
        
                              </tr>";
    
                }
                $html .= "</table>";               
            } else
                $html .= "</br>".$noRow.". No weekly work schedule for date : ".$date."</br>";


            $date = date('Y-m-d', strtotime($date.' +1 days')); 
        }
 
        $hasil = number_format($hasWeeklyScheduleCount / $dayCount * 100);
        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];
                
        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Weekly work schedule for : </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$perode1. " to " .$perode2. "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total normal working days : </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" .number_format($dayCount)."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total days that have weekly work schedule :</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format($hasWeeklyScheduleCount)  . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Percentage having weekly work schedule :</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil  . " %</b></td>
                    </tr>
                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }          
    
    function hitungsa3($post)    {
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
        
        $bawah = $this->getInferior($cNipNya);

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
            </tr>
        ";
        
        $commentType = 5;
        $sqlto = "SELECT a.confirm_date,a.satisfaction_value,a.id,b.commentType,
                  a.problem_subject, a.date_posted,b.input_date, b.startDuration,
                  a.actual_start,a.actual_finish,a.estimated_start,a.estimated_finish,a.updateSchedule
				    FROM hrd.ss_raw_problems a
				        JOIN hrd.ss_solution b ON b.id = a.id
				    WHERE a.pic in ('" . implode("','", $bawah) . "')	
				        AND DATE(a.date_posted) BETWEEN '$perode1' AND LAST_DAY('$perode2')
				        AND b.commentType = $commentType
				        AND a.confirm_date IS NOT NULL
				    GROUP BY a.id ORDER BY a.id";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $html .= "<b>Jumlah Task Yang Rework</b>";
        $noRow = 0;
        foreach($rows as $row) {
            $noRow++;
            $raw_id = $row['id'];
            $subject = $row['problem_subject'];
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }            
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $raw_id . "</td>
                        <td style='width:75%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>
    
                      </tr>";            
    
        }        
        $html .= "</table>";
        $jml_rework = $noRow;
        
        $html .= "<br /> ";
        
        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
            </tr>
        ";        
        $commentType = 8;
        $sqlto = "SELECT a.confirm_date,a.satisfaction_value,a.id,b.commentType,
                  a.problem_subject, a.date_posted,b.input_date, b.startDuration,
                  a.actual_start,a.actual_finish,a.estimated_start,a.estimated_finish,a.updateSchedule
				    FROM hrd.ss_raw_problems a
				        JOIN hrd.ss_solution b ON b.id = a.id
				    WHERE a.pic in ('" . implode("','", $bawah) . "')	 
				        AND DATE(a.date_posted) BETWEEN '$perode1' AND LAST_DAY('$perode2')
				        AND b.commentType = $commentType
				        AND a.confirm_date IS NOT NULL
				    GROUP BY a.id ORDER BY a.id";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $noRow = 0;
        $html .= "<b>Jumlah Task Yang Finish</b>";
        foreach($rows as $row) {
            $noRow++;
            $raw_id = $row['id'];
            $subject = $row['problem_subject'];
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }            
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $raw_id . "</td>
                        <td style='width:75%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>
    
                      </tr>";            
        }        
        $html .= "</table>";
        $jml_finish = $noRow;   
             
        $hasil = number_format($jml_rework/$jml_finish,2); 

        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];
                
        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah task yang rework: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jml_rework . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah task yang finish: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jml_finish . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " %</b></td>
                    </tr>

                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }

    function hitungsa4($post)    {
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

        $dayCount = 0;
        $hasWeeklyScheduleCount = 0;

        $bawah = $this->getInferior($cNipNya);
        $mx=count($bawah);
        for($ii=0;$ii<$mx;$ii++) {

            $nipchild =$bawah[$ii];

            $html .= "
                <table>
                    <tr>
                        <td><b>Bawahan :</b></td>
                        <td>" . $nipchild . "</td>

                    </tr>
                </table>";
            $workDays = $this->getWorkDay($nipchild);
            $date = $perode1;
            $noRow = 0;
            while ($date < $perode2) {
                $noRow ++;
                while ($this->isOff($nipchild, $workDays, $date)) {
                    $date = date('Y-m-d', strtotime($date.' +1 days'));
                }
                $dayCount++;
                $dUpTo = $this->getScheduleEndDate($nipchild, $date);
    
                $q = $this->getScheduleQuery($nipchild, $date, $dUpTo);
    
                $data = Array();
                $result = mysql_query($q) or die(mysql_error()."</br>".$q);
                while ($row = mysql_fetch_assoc($result)) {
                    array_push($data, $row);
                }
    
                $rowCount = count($data);
                $hasSchedule = $this->hasSchedule($data, $debug);
    
                if ($hasSchedule) {
                    $hasWeeklyScheduleCount++;
    
                    $html .= "</br>".$noRow.". Weekly Work Schedule: (".$hasWeeklyScheduleCount.")</br>";
                    $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <td style='border: 1px solid #dddddd;' ><b>Date</b></td>
                            <td style='border: 1px solid #dddddd;' ><b>Duration </b></td>
                            <td style='border: 1px solid #dddddd;' ><b>Schedule Frequency</b></td>
                            <td style='border: 1px solid #dddddd;' ><b>ID</b></td>
                            <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                        </tr>
                    ";
                    for ($i = 0; $i < $rowCount; $i++) {
                        if (fmod($i, 2) == 0) {
                            $color = 'background-color: #eaedce';
                        } else {
                            $color = '';
                        }
                        $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                                    <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                        " . $data[$i]['dDate'] . "</td>
                                    <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                                        " . $data[$i]['yDuration2'] . "</td>
                                    <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                        " . $data[$i]['iScheduleFreq'] . "</td>
                                    <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                        " . $data[$i]['iSSID'] . "</td>
                                    <td style='width:50%;text-align: center;border: 1px solid #dddddd;'>
                                        " . $data[$i]['problem_subject'] . "</td>
    
                                  </tr>";
    
                    }
                    $html .= "</table>";
                } else
                    $html .= "</br>".$noRow.". No weekly work schedule for date : ".$date."</br>";
    
    
                $date = date('Y-m-d', strtotime($date.' +1 days'));
            }            
        }



        $hasil = number_format($hasWeeklyScheduleCount / $dayCount * 100);
        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Weekly work schedule for : </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$perode1. " to " .$perode2. "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total normal working days : </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" .number_format($dayCount)."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total days that have weekly work schedule :</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format($hasWeeklyScheduleCount)  . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Percentage having weekly work schedule :</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil  . " %</b></td>
                    </tr>
                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }
    function hitungsa5($post)
    {
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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";
        $bawah = $this->getInferior($cNipNya);
        array_push($bawah,$cNipNya);
        $mx=count($bawah);
        $allscheduled = $alljumlahRequest = 0;
        for($ii=0;$ii<$mx;$ii++) {

            $nipchild =$bawah[$ii];

            $html .= "
                <table>
                    <tr>
                        <td><b>Bawahan :</b></td>
                        <td>" . $nipchild . "</td>

                    </tr>
                </table>";
            $workDays = $this->getWorkDay($nipchild);
            $date = $perode1;
            $noRow = 0;                

            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Est. Start</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Est. Finish</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Created Date</b></td>
                </tr>
            ";
    
            
            $sqlto = "SELECT a.id,a.problem_subject,a.date_posted,x.tCreatedAt updateSchedule,x.estimated_start,x.estimated_finish,a.actual_start,a.actual_finish
    					FROM hrd.ss_raw_problems a
                        left outer join hrd.ss_activity_type aty on aty.activity_id = a.activity_id
    					LEFT OUTER JOIN (SELECT h.iSSID,h.cPIC, max(h.iScheduleFreq)iScheduleFreq, max(h.tCreatedAt)tCreatedAt,min(d.dDate) estimated_start, max(d.dDate)estimated_finish
    							FROM 	hrd.ss_task_scheduling h
    							left outer join hrd.ss_task_scheduling_detail d on h.iSSID = d.iSSID and h.cPIC = d.cPIC and h.iScheduleType = d.iScheduleType
    						and h.iScheduleFreq = d.iScheduleFreq
    							WHERE h.cPic = '$nipchild'  and h.iSSID in (SELECT a.id FROM hrd.ss_raw_problems a
    											WHERE a.pic = '$nipchild'  AND DATE(a.date_posted) BETWEEN '$perode1' AND LAST_DAY('$perode2'))
    									and h.tApproved2 IS NOT NULL
    							Group by h.iSSID,h.cPIC
    							order by h.iSSID,h.cPIC	) x ON x.iSSID = a.id
    					WHERE a.pic = '$nipchild'
    						AND DATE(a.date_posted) BETWEEN '$perode1' AND LAST_DAY('$perode2')
                            	and left(aty.activity,2) <> 'DS' and a.activity_id not in (22,0)
    					ORDER BY a.id";
    
            $rows = $this->db_erp_pk->query($sqlto)->result_array();
            $no = 0;
            $scheduled =  0;
            $result =0;
            $jumlahRequest = count($rows);
            for($i=0;$i<$jumlahRequest;$i++) {
                $noRow++;
                $id = $rows[$i]['id'];
                $subject = $rows[$i]['problem_subject'];
                $date_posted = $rows[$i]['date_posted'];
    
                $actual_start = $rows[$i]['actual_start'];
                $t_actual_start = strtotime($actual_start);
                $d_actual_start = date('Y-m-d',$t_actual_start);
    
                $estimated_start = $rows[$i]['estimated_start'];
                $t_estimated_start = strtotime($estimated_start);
                $d_estimated_start = $t_estimated_start ? date('Y-m-d',$t_estimated_start) :'';
                $td_estimated_start = strtotime($d_estimated_start);
    
                $estimated_finish = $rows[$i]['estimated_finish'];
                $t_estimated_finish = strtotime($estimated_finish);
                $d_estimated_finish = $t_estimated_finish ? date('Y-m-d',$t_estimated_finish) : '';
                $td_estimated_finish = strtotime($d_estimated_finish);
    
                $updateSchedule = $rows[$i]['updateSchedule'];
                $t_updateSchedule = strtotime($updateSchedule);
                $d_updateSchedule = $t_updateSchedule ? date('Y-m-d',$t_updateSchedule) :'';
                $td_updateSchedule = strtotime($d_updateSchedule);
    
                if( !empty($d_estimated_finish) && !empty($d_estimated_start) )
                {
                    $scheduled++;

                }
                if (fmod($noRow, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }            
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
    
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $id . "</td>
                            <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                                " . $subject . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . $d_estimated_start . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . $d_estimated_finish . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . $d_updateSchedule . "</td>
    
                          </tr>";
    
                }
                $subhasil = number_format( ($scheduled / $jumlahRequest) * 100, 2 );  
                $allscheduled += $scheduled;
                $alljumlahRequest += $jumlahRequest;
                $html .= "<br /> ";
                
    
                $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                            <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                                <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                            </tr>
                            <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                                <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Task yg Terjadwalkan: </td>
                                <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $scheduled . "</b></td>
                            </tr>
                            <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                                <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Seluruh Task: </td>
                                <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jumlahRequest . "</b></td>
                            </tr>
                            <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                                <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                                <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $subhasil . " %</b></td>
                            </tr>
        
                        </table><br clear='all' /><br />";
        }
        
        $hasil = number_format( ($allscheduled / $alljumlahRequest) * 100, 2 );        

        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";
        $html .= "<h1>Result:</h1>";
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Task yg Terjadwalkan: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $allscheduled . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Seluruh Task: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $alljumlahRequest . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " %</b></td>
                    </tr>

                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }    

    function hitungsa9($post)    {

        $iAspekId = $post['_iAspekId'];
        $cNipNya = $post['_cNipNya'];

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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";

        $dayCount = 0;
        $hasWeeklyScheduleCount = 0;

        $bawah = $this->getInferior($cNipNya);
        array_push($bawah,$cNipNya);
        $mx=count($bawah);
        $allRowCount = $allUnknownDurationCount = $allUnfinish = $allTotalIntervalInSeconds= 0;

        for($ii=0;$ii<$mx;$ii++) {
            $nipchild =$bawah[$ii];
            $html .= "
                <table>
                    <tr>
                        <td><b>NIP :</b></td>
                        <td>" . $nipchild . "</td>
                    </tr>
                </table>";

            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <td style='border: 1px solid #dddddd;' ><b>No</b></td> 
                    <td style='border: 1px solid #dddddd;' ><b>SSiD</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Problem Subject </b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Tgl Submit </b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Tgl Finish </b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Durasi </b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Seconds </b></td>
                </tr>
            ";
                        
            $q = "SELECT r.*
                      FROM (
                          SELECT r.id, r.problem_subject, stype.assign, stype.changeRequest, 
                              stype.editData, r.date_posted, r.approveDate, r.assignTime, a.activity,
                              CASE
                              WHEN stype.assign='Y' THEN r.assignTime
                              WHEN stype.changeRequest='Y' OR stype.editData='Y' THEN r.approveDate
                              ELSE r.date_posted
                              END AS tSubmitted, r.tMarkedAsFinished, r.confirm_date, r.finishing_by    
                          FROM hrd.ss_raw_problems r
                          LEFT JOIN hrd.ss_support_type stype ON r.typeId=stype.typeId, hrd.ss_activity_type a
                          WHERE r.pic LIKE '%$nipchild%' AND r.requestor<>'$nipchild' AND
                            (r.finishing_by='' OR r.finishing_by='$nipchild') AND r.Deleted='No' AND
                            r.activity_id=a.activity_id and r.parent_id = 0 and a.activity LIKE '%DS%'
                      ) r
                      WHERE LEFT(r.tSubmitted,10) > '$perode1' AND LEFT(r.tSubmitted,10) < '$perode2'";                  
            
            $fld = $this->db_erp_pk->query($q)->result_array();

            $fastest = $slowest = 0;
            $totalInterval = $this->getDateTimeInterval("00:00", "00:00");
            $rowCount = $unknownDurationCount = $unfinish = $divider = $totInt = 0;
            $jumlah = count($fld);
            $noRow = 0;
            for($i=0;$i<$jumlah;$i++) {
                $noRow++;
                if (fmod($i, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }  
                $raw_id = $fld[$i]['id'];

                if (!$this->isProject($fld[$i]['id'])) {
                    $rowCount++;
                    $convertedSDTime = $fld[$i]['tSubmitted'];
                    if ($fld[$i]['tMarkedAsFinished'] && substr($fld[$i]['tMarkedAsFinished'],0,10)>substr($fld[$i]['tSubmitted'],0,10)) {
                        $convertedSDTime = $this->convertToWeekday($nipchild, $fld[$i]['tSubmitted']);
                    }
                    $converted = ($convertedSDTime!==$fld[$i]['tSubmitted']);
                    if ($fld[$i]['tMarkedAsFinished'] && $convertedSDTime>$fld[$i]['tMarkedAsFinished']) {
                        $duration = "Unknown";
                        $unknownDurationCount++;
                        $durasi=0;

                    } else {
                        $interval = $this->getDuration($nipchild, $convertedSDTime, $fld[$i]['tMarkedAsFinished']);
                        $duration = $this->hDateTimeInterval($interval);
                        $fastest = min($this->DateTimeIntervalToSeconds($interval), ($fastest ? $fastest : $this->DateTimeIntervalToSeconds($interval)));
                        $slowest = max($this->DateTimeIntervalToSeconds($interval), $slowest);
                        $totalInterval = $this->addDateTimeIntervalByDateInterval($totalInterval, $interval);
                        $durasi = $this->DateTimeIntervalToSeconds($interval);
                    }
                    $unfinish += ($fld[$i]['confirm_date'] ? 0 : 1);

                    if ($rowCount) {
                        $divider = $rowCount - $unknownDurationCount;
                        $avgSpeed = ($divider ? round($this->DateTimeIntervalToSeconds($totalInterval)/$divider) : "Unknown");
                        $totInt = $this->DateTimeIntervalToSeconds($totalInterval);
                        //$avgSpeedTask = round($totInt/($divider));

                        $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                                <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                                <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                                    " . $raw_id . "</td>
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                    " . $fld[$i]['problem_subject'] . "</td>
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                    " . $fld[$i]['tSubmitted'] . "</td>
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                    " . $fld[$i]['tMarkedAsFinished'] . "</td>
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                    " . $duration . "</td>
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                    " . number_format($durasi) . "</td>
                              </tr>";
                    }

                }
 
            }

            $allRowCount += $rowCount;
            $allUnknownDurationCount += $unknownDurationCount;
            $allUnfinish += $unfinish;
            $allTotalIntervalInSeconds += $this->DateTimeIntervalToSeconds($totalInterval);
            $TaskAvgSpeed = ($rowCount-$unknownDurationCount)>0 ? round($this->DateTimeIntervalToSeconds($totalInterval)/($rowCount-$unknownDurationCount)):0;

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Task : </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format($rowCount). "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total uncalculated : </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format($unknownDurationCount)." task(s). (".number_format($unknownDurationCount/$rowCount*100,2)."%)</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Hasn't finished :</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format($unfinish)." task(s). (".number_format($unfinish/$rowCount*100,2)."%)</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Average :</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$this->secondsToHDateInterval($TaskAvgSpeed)." (".number_format($TaskAvgSpeed)." seconds)</b></td>
                    </tr>
                </table><br clear='all' /><br />";

        }



        $allAvgSpeed = round($allTotalIntervalInSeconds/($allRowCount-$allUnknownDurationCount));
        $hasil = number_format($allAvgSpeed);
        $result = $allAvgSpeed;
        $getpoint = $this->getPoint($result, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];
    
        $html .= "<br /> ";
        $html .= "<h1>Result:</h1>";
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Task : </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format($allRowCount). "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total uncalculated : </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format($allUnknownDurationCount)." task(s). (".number_format($allUnknownDurationCount/$allRowCount*100,2)."%)</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Hasn't finished :</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format($allUnfinish)." task(s). (".number_format($allUnfinish/$allRowCount*100,2)."%)</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Average :</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$this->secondsToHDateInterval($allAvgSpeed)." (".number_format($allAvgSpeed)." seconds)</b></td>
                    </tr>
                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }
    
    function hitungsa10($post)
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
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<b>LOC identified as bug </b>";
        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Author </b></td>
                <td style='border: 1px solid #dddddd;' ><b>File </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Rev# </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Blame Rev# </b></td>
                <td style='border: 1px solid #dddddd;' ><b>LoC</b></td>                
            </tr>
        "; 

        $sql = "select bh.* from hrd.svn_blame_header bh
					inner join (select cd.iRevisionNumber,cd.iSvnId from hrd.svn_commit_detail cd 
                    where cd.iCommitId in(
						select ch.iCommitId from hrd.svn_commit_header ch
						where right(ch.vVersion,2)<> '.0' AND ch.vAuthor = '$cNipNya' AND
						date(ch.tLaunch) between '$perode1' and '$perode2')) c on c.iRevisionNumber = bh.iRevisionNumber 
                        and c.iSvnId=bh.iSvnId
						and bh.vAuthor <> '$cNipNya'
						group by bh.iRevisionNumber,bh.iSvnId";

        $rows = $this->db_erp_pk->query($sql)->result_array();
        $no = 1;
        $loc = $max = $total_loc = 0;
        if (!empty($rows)) {
            $max = count($rows);
            $noRow = 0;
            $total_bugs = 0;           
            for ($i = 0; $i < $max; $i++) {
                $noRow++;
                $vAuthor = $rows[$i]['vAuthor'];
                $vFile = $rows[$i]['vFile'];
                $iRevisionNumber = $rows[$i]['iRevisionNumber'];
                $iBlamedRevNumber = $rows[$i]['iBlamedRevNumber'];
                $iLOC = $rows[$i]['iLOC'];                
                if (fmod($noRow, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }

                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $vAuthor . "</td>
                            <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                                " . $vFile . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $iRevisionNumber . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $iBlamedRevNumber. "</td>
                            <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                                " . $iLOC . "</td>                                                             
                          </tr>";
                $no++;
            }
        }else{
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;'></td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'></td>
                            <td style='width:20%;text-align: left;border: 1px solid #dddddd;'></td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'></td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'></td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'></td>                                                     
                          </tr>";            
        }

        $html .= "</table>";
/*
        $html .= "<b>Total contribution LOC</b>";
        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Author </b></td>
                <td style='border: 1px solid #dddddd;' ><b>File </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Rev# </b></td>
                <td style='border: 1px solid #dddddd;' ><b>LOC </b></td>            
            </tr>
        "; 
*/        
        $sql = "select cd.iCommitId,cd.vVersion,cd.vAuthor,cd.vFile,cd.iRevisionNumber,cd.iLOC,ch.tCommit from 
                    hrd.svn_commit_detail cd
					inner join hrd.svn_commit_header ch on ch.iCommitId = cd.iCommitId and
						date(ch.tCommit) between '$perode1' AND LAST_DAY('$perode2')and
						ch.vAuthor = '$cNipNya'
						where cd.vFile not in (select a.vFile from hrd.svn_commit_detail a
	                   inner join hrd.svn_exclude  b on substr(a.vFile,1,length(Trim(b.vFile))) = Trim(b.vFile))";

        $rows = $this->db_erp_pk->query($sql)->result_array();
        $no = 1;
        $loc = 0;
        $y=count($rows);
        if (!empty($rows)) {
            $noRow = 0;
            $max2 = count($rows);
            $total_loc = 0;
            for ($i = 0; $i < $max2; $i++) {
                $noRow++;
                $iLOC = $rows[$i]['iLOC'];
                $total_loc += $iLOC;
                    
                $vAuthor = $rows[$i]['vAuthor'];
                $vFile = $rows[$i]['vFile'];
                $iRevisionNumber = $rows[$i]['iRevisionNumber'];
                $iLOC = $rows[$i]['iLOC'];      
/*                          
                if (fmod($noRow, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }
    
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $vAuthor . "</td>
                            <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                                " . $vFile . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $iRevisionNumber . "</td>
                            <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>
                                " . $iLOC . "</td>                                                             
                          </tr>";
*/                          
                $no++;  
            }          
        }

        $html .= "</table>";
        
        $result = ($total_loc > 0 ? number_format(($max / $total_loc)*100 , 2):0);
        
        $getpoint = $this->getPoint($result, $iAspekId);
        
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Bugs: </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>" . number_format($max ) . "</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Contribution of LOC: </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>" . number_format($total_loc) . "</td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>" . $result . "%</td>
                    </tr>                    
                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }
        
    function hitungsa11($post)
    {
        $iAspekId = $post['_iAspekId'];
        $iPkTransId = $post['_iPkTransId'];
        $cNipNya = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];
        $periode1 = $x_prd1['2'] . "-" . $x_prd1['1'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];
        $periode2 = $x_prd2['2'] . "-" . $x_prd2['1'];

        $sql = "SELECT cTahun, iSemester FROM hrd.pk_trans WHERE id='" . $iPkTransId . "'";
        $query = $this->db_erp_pk->query($sql);
        $cTahun = $query->row()->cTahun;
        $iSemester = $query->row()->iSemester;

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject </b></td>
            </tr>
        ";

        $sqlto = "select a.id,a.problem_subject,c.vName, a.problem_description, a.dTarget_implement, a.dSubmit_requirement
                from hrd.ss_raw_problems a 
                inner join hrd.ss_raw_pic b on a.id =b.rawid and b.pic = '$cNipNya' and b.Deleted = 'No'
                left outer join hrd.employee c on c.cNip =  b.pic
                where a.cSemester= '$iSemester' and a.cTahun = '$cTahun'
                and a.iStatus =13 and a.eProject_priority = 'Y' and DATE(a.dcloseGm) <= '$perode2'";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $no = $totalContibution = $raw = 0;
        if (!empty($rows)) {
			$raw = count($rows);           
            foreach ($rows as $d) {
                $no++;
                $ssid = $d['id'];
                $problem_subject = $d['problem_subject'];

                if (fmod($no, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                                <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $no . "</td>

                                <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                                    " . $ssid . "</td>
                                <td style='width:80%;text-align: left;border: 1px solid #dddddd;'>
                                    " . $problem_subject . "</td>
                              </tr>";

            }                                 
        }


        $html .= "</table>";


        $hasil = $raw;
        $result = number_format($hasil,2);

        $getpoint = $this->getPoint($result, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result :</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>" . $result . " Project </b></td>
                    </tr>
                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }           
    //==============================End Funtion PK System ANalyst=====================================


    //==============================Start Funtion PK Data Support=====================================
    function hitungDs1($post) {
        $iAspekId = $post['_iAspekId'];
        $iPkTransId = $post['_iPkTransId'];
        $cNipNya = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];
        $periode1 = $x_prd1['2'] . "-" . $x_prd1['1'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];
        $periode2 = $x_prd2['2'] . "-" . $x_prd2['1'];

        $sql = "SELECT cTahun, iSemester FROM hrd.pk_trans WHERE id='" . $iPkTransId . "'";
        $query = $this->db_erp_pk->query($sql);
        $cTahun = $query->row()->cTahun;
        $iSemester = $query->row()->iSemester;

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                        
                    </tr>
                </table>";

        $arrJadwal=$this->getJadwalKerja($cNipNya);

        $bawah = $this->getInferior($cNipNya);
        array_push($bawah,$cNipNya);
        $mx=count($bawah);
        $jumlah_objek = 0;
        $total_nilai = 0;
        $totalJamAll = $total_jam = $max = 0;
        $totalReqAll = 0;

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Filename </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Package Diterima </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Package di kemas </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Speed(hour) </b></td>
            </tr>
        ";


        $sqlto = "select a.cKode_area, b.vAreaName, a.cPIC, max(cast(concat(d_recv, ' ',c_recv) as datetime)) tRecv,
    max(cast(concat(d_filedate, ' ',c_filetime) as DATETIME)) tPackage, a.c_realfn cFName
                  FROM rcvinfo a
                  LEFT OUTER JOIN area b ON a.cKode_area = b.cAreaCode
                  WHERE a.cPIC = '$cNipNya'
                  AND d_recv BETWEEN '$perode1' AND LAST_DAY('$perode2')
                  group BY b.vAreaName,a.cKode_area,a.cPIC, a.c_realfn";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $noRow= $total_nilai = $totalJam = 0;
        $jumlahRequest = count($rows);
        for($i=0;$i<$jumlahRequest;$i++) {
            $noRow++;
            $iIdSpa = $rows[$i]['cFName'];
            //$cNip = $rows[$i]['cNip'].' - '.$rows[$i]['vName'];

            $start_duration = $rows[$i]['tPackage'];
            $t_start_duration = strtotime($start_duration);

            $input_date = $rows[$i]['tRecv'];
            $t_input_date = strtotime($input_date);

            $date_start = $this->formatTimestamp($start_duration,'date');
            $dt_start = strtotime($date_start);
            $day_start = date('N',$dt_start);

            $date_respon = $this->formatTimestamp($input_date,'date');
            $dt_respon = strtotime($date_respon);
            $day_respon = date('N',$dt_respon);

            $hour_start = $this->formatTimestamp($start_duration,'hour');
            $ht_start = strtotime($hour_start);

            $hour_respon = $this->formatTimestamp($input_date,'hour');
            $ht_respon = strtotime($hour_respon);

            $jam_umum_masuk = $arrJadwal['umum']['masuk'];
            $t_jam_umum_masuk = strtotime($jam_umum_masuk);

            $jam_umum_keluar = $arrJadwal['umum']['keluar'];
            $t_jam_umum_keluar = strtotime($jam_umum_keluar);

            $jam_keluar_start = $arrJadwal[ $day_start ]['keluar'];
            $t_jam_keluar_start = strtotime($jam_keluar_start);

            $calcHour = 0;
            if( $dt_start == $dt_respon ) {// direspon di hari yang sama
                $calcHour = ( $ht_respon - $ht_start )/3600;
                $totalJam += $calcHour;
            } else { // direspon di hari yang berbeda
                if( $ht_start > $t_jam_keluar_start ) { // start duration > jam keluar pic
                    $t_start_duration = $this->addDay($t_start_duration,1);// + ke hari esok
                }
                $calcHour = $this->hitung_beda_hari( $t_start_duration, $t_input_date, $arrJadwal );
                $calcHour = $calcHour / 3600;
                $calcHour = ( $calcHour < 0 )? 0:$calcHour;

                $totalJam += $calcHour;
            }
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>

                <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                    " . $iIdSpa . "</td>
                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                    " . $start_duration . "</td>
                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                    " . $input_date . "</td>
                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                    " . number_format( $calcHour, 2 ) . " Jam</td>

              </tr>";

        }


        $html .= "</table>";

        if($jumlahRequest > 0) {
            $hasil = $totalJam/$jumlahRequest;
            $hasil = number_format($hasil,2);
            $getpoint = $this->getPoint($hasil, $iAspekId);
        }else{
            $hasil = $result = 'No Data';
            $getpoint = $this->getPointEmpty($hasil, $iAspekId);
        }
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Kecepatan: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format( $totalJam, 2 )." Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Request: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$jumlahRequest."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " Jam</b></td>
                    </tr>
                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }

    function hitungDs2($post)
    {
        $totalJamAll = 0;
        $totalReqAll = 0;
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
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Assign Time</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Actual Start</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Respond(Hour)</b></td>
            </tr>
        ";

        $arrJadwal=$this->getJadwalKerja($cNipNya);

        $sqlto = "SELECT z.id,z.problem_subject, z.date_posted,z.assignTime,
					z.actual_start,z.startDuration,z.input_date,z.commentType,
					z.vType, z.solution_id FROM (
					SELECT a.id,b.solution_id,a.problem_subject, a.date_posted,	Case when a.approveDate is not null then a.approveDate
						When a.assignTime is not null then a.assignTime  else a.date_posted end assignTime,
									a.actual_start,b.startDuration,b.input_date,b.commentType,
									b.vType,iGrp_activity_id
									FROM hrd.ss_raw_problems a
									JOIN hrd.ss_solution b ON b.id = a.id
                                    JOIN hrd.ss_activity_type c on c.activity_id = a.activity_id
									WHERE b.pic = '" . $cNipNya . "'
									And a.parent_id = 0
									AND DATE(a.date_posted) BETWEEN '" . $perode1 . "' AND '" . $perode2 . "'
									AND CASE WHEN (SELECT assign FROM hrd.ss_support_type WHERE typeId=a.typeId)='Y'
									    THEN (b.commentType = 3) END
									AND a.activity_id != 22
									AND (b.isDeleted = 0 OR b.isDeleted IS NULL)
                                    AND c.iGrp_activity_id = 20
					UNION
					SELECT a.id,b.solution_id,a.problem_subject, a.date_posted,	Case when a.approveDate is not null then a.approveDate
						When a.assignTime is not null then a.assignTime  else a.date_posted end assignTime,
									a.actual_start,b.startDuration,b.input_date,b.commentType,
									b.vType,c.iGrp_activity_id
									FROM hrd.ss_raw_problems a
									JOIN hrd.ss_solution b ON b.id = a.id
                                    JOIN hrd.ss_activity_type c on c.activity_id = a.activity_id
									WHERE b.pic = '" . $cNipNya . "'
									And a.parent_id = 0
									AND DATE(a.date_posted) BETWEEN '" . $perode1 . "' AND '" . $perode2 . "'
									AND b.commentType = 50
									AND a.activity_id != 22
									AND (b.isDeleted = 0 OR b.isDeleted IS NULL)
                                    AND c.iGrp_activity_id = 20
				) AS z
				GROUP BY z.id, z.vType
				ORDER BY z.date_posted,z.solution_id";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $size = 0;
        $noRow=0;
        $totalJam = 0;

        $tmpData = array();
        if (!empty($rows)) {
            $jumlahRequest = count($rows);

            for($i=0;$i<$jumlahRequest;$i++) {
                $noRow++;
                $id = $rows[$i]['id'];
                $subject = $rows[$i]['problem_subject'];

                $date_posted = $rows[$i]['date_posted'];
                $assignTime = $rows[$i]['assignTime'];
                $actual_start = $rows[$i]['actual_start'];

                if( $rows[$i]['vType'] == 'Joblog' ) {
                    $start_duration = (empty($assignTime)||strtotime($assignTime)<strtotime($date_posted))?$date_posted:$assignTime;
                    $t_start_duration = strtotime($start_duration);

                    $input_date = $rows[$i]['startDuration'];
                    $t_input_date = strtotime($input_date);
                } else {
                    $start_def = (empty($assignTime))?$date_posted:$assignTime;
                    $start_duration = (empty($rows[$i]['startDuration']))?$start_def:$rows[$i]['startDuration'];
                    $t_start_duration = strtotime($start_duration);

                    $input_date = $rows[$i]['input_date'];
                    $t_input_date = strtotime($input_date);
                }

                $date_start = $this->formatTimestamp($start_duration,'date');
                $dt_start = strtotime($date_start);
                $day_start = date('N',$dt_start);

                $date_respon = $this->formatTimestamp($input_date,'date');
                $dt_respon = strtotime($date_respon);
                $day_respon = date('N',$dt_respon);

                $hour_start = $this->formatTimestamp($start_duration,'hour');
                $ht_start = strtotime($hour_start);

                $hour_respon = $this->formatTimestamp($input_date,'hour');
                $ht_respon = strtotime($hour_respon);

                $jam_umum_masuk = $arrJadwal['umum']['masuk'];
                $t_jam_umum_masuk = strtotime($jam_umum_masuk);

                $jam_umum_keluar = $arrJadwal['umum']['keluar'];
                $t_jam_umum_keluar = strtotime($jam_umum_keluar);

                $jam_keluar_start = $arrJadwal[ $day_start ]['keluar'];
                $t_jam_keluar_start = strtotime($jam_keluar_start);

                $calcHour = 0;

                if( $dt_start == $dt_respon ) {// direspon di hari yang sama
                    $calcHour = ( $ht_respon - $ht_start )/3600;
                    $calcHour = ( $calcHour < 0 )? 0:$calcHour;

                    if( $rows[$i]['vType'] == 'Joblog' ) {
                        $tmpData[ $id ]['joblog'] = $calcHour;
                    } else {
                        $tmpData[ $id ]['followup'] = $calcHour;
                    }
                } else { // direspon di hari yang berbeda

                    $calcHour = $this->hitung_beda_hari( $t_start_duration, $t_input_date, $arrJadwal );
                    $calcHour = $calcHour / 3600;
                    $calcHour = ( $calcHour < 0 )? 0:$calcHour;

                    if( $rows[$i]['vType'] == 'Joblog' ) {
                        $tmpData[ $id ]['joblog'] = $calcHour;
                    } else {
                        $tmpData[ $id ]['followup'] = $calcHour;
                    }
                    $dateStart = date('Y-m-d H:i:s',$t_start_duration);
                }

                if (fmod($noRow, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }

                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $id . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $subject . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . $start_duration . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . $input_date . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . number_format( $calcHour, 2 ) . "</td>
                          </tr>";
                $no++;
            }
        }

        $html .= "</table>";

        $jumlahRequest = 0;
        if(count($tmpData)>0) {
            foreach( $tmpData as $tdKey => $tdVal ) {
                $x1 = 9999999999;
                if( isset($tdVal['joblog'])) {
                    $x1 = $tdVal['joblog'];
                }

                $x2 = 9999999999;
                if( isset($tdVal['followup'])) {
                    $x2 = $tdVal['followup'];
                }

                if( $x1 < $x2 ) {
                    $totalJam += $x1;
                    $jumlahRequest++;
                } else if( $x2 < $x1 ) {
                    $totalJam += $x2;
                    $jumlahRequest++;
                }
            }
        }

        if($jumlahRequest > 0) {
            $hasil = $totalJam/$jumlahRequest;
            $hasil = number_format($hasil,2);
            $getpoint = $this->getPoint($hasil, $iAspekId);
        }else{
            $hasil = $result = 'No Data';
            $getpoint = $this->getPointEmpty($hasil, $iAspekId);
        }
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Respond: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format( $totalJam, 2 )." Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Request: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$jumlahRequest."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " Jam</b></td>
                    </tr>
                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }

    function hitungDs3($post)
    {
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

        $jenis = array(1 => 'UM', 2 => 'Claim');

        $bulan = $this->hitung_bulan($perode1, $perode2);

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Start</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Finish</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Duration</b></td>
            </tr>
        ";

        $arrJadwal=$this->getJadwalKerja($cNipNya);

        $sqlto = "SELECT a.id,a.problem_subject, a.date_posted,b.input_date,b.startDuration,b.commentType, a.actual_start,a.actual_finish,a.tMarkedAsFinished
					FROM hrd.ss_raw_problems a
					JOIN hrd.ss_solution b ON b.id = a.id
					WHERE a.activity_id = 4
						AND a.finishing_by = '" .$cNipNya. "'
						AND b.pic = a.pic
					AND b.commentType = 8
					AND DATE(a.date_posted) BETWEEN '" . $perode1 . "'AND LAST_DAY('" . $perode2 . "')
					ORDER BY a.date_posted";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 0;
        $tot_hasil = 0;
        $result =0;
        $jumlahRequest = count($rows);
        for($i=0;$i<$jumlahRequest;$i++) {
            $noRow++;
            $id = $rows[$i]['id'];
            $subject = $rows[$i]['problem_subject'];

            $date_posted = $rows[$i]['date_posted'];
            $start_duration = (empty($rows[$i]['startDuration']))?$date_posted:$rows[$i]['startDuration'];
            $t_start_duration = strtotime($start_duration);

            $input_date = $rows[$i]['input_date'];
            $t_input_date = strtotime($input_date);

            $date_start = $this->formatTimestamp($start_duration,'date');
            $dt_start = strtotime($date_start);
            $day_start = date('N',$dt_start);

            $date_respon = $this->formatTimestamp($input_date,'date');
            $dt_respon = strtotime($date_respon);
            $day_respon = date('N',$dt_respon);

            $hour_start = $this->formatTimestamp($start_duration,'hour');
            $ht_start = strtotime($hour_start);

            $hour_respon = $this->formatTimestamp($input_date,'hour');
            $ht_respon = strtotime($hour_respon);

            $jam_umum_masuk = $arrJadwal['umum']['masuk'];
            $t_jam_umum_masuk = strtotime($jam_umum_masuk);

            $jam_umum_keluar = $arrJadwal['umum']['keluar'];
            $t_jam_umum_keluar = strtotime($jam_umum_keluar);

            $jam_keluar_start = $arrJadwal[ $day_start ]['keluar'];
            $t_jam_keluar_start = strtotime($jam_keluar_start);

            $calcHour = 0;
            if( $dt_start == $dt_respon ) {// direspon di hari yang sama
                $calcHour = ( $ht_respon - $ht_start )/3600;
                $totalJam += $calcHour;
            } else { // direspon di hari yang berbeda
                if( $ht_start > $t_jam_keluar_start ) { // start duration > jam keluar pic
                    $t_start_duration = $this->addDay($t_start_duration,1);// + ke hari esok
                }
                $t_start_duration = $this->skipLibur($t_start_duration,$arrJadwal);

                $count_libur = $this->getJumlahHariLibur($t_start_duration,$t_input_date,$arrJadwal);

                $t_start_duration+=$count_libur;

                $calcHour = ( $t_input_date - $t_start_duration ) / 3600;
                $totalJam += $calcHour;
            }
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $id . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $start_duration . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $input_date . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . number_format( $calcHour, 2 ) . " Jam</td>

                      </tr>";

        }

        $html .= "</table>";

        if($jumlahRequest > 0) {
            $hasil = $totalJam/$jumlahRequest;
            $hasil = number_format($hasil,2);
            $getpoint = $this->getPoint($hasil, $iAspekId);
        }else{
            $hasil = $result = 'No Data';
            $getpoint = $this->getPointEmpty($hasil, $iAspekId);
        }
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Durasi: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format( $totalJam, 2 ) . " Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Task: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jumlahRequest . " Task</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " Jam</b></td>
                    </tr>

                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }
    function hitungDs4($post)
    {
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

        $jenis = array(1 => 'UM', 2 => 'Claim');

        $bulan = $this->hitung_bulan($perode1, $perode2);

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Start</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Finish</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Duration</b></td>
            </tr>
        ";

        $arrJadwal=$this->getJadwalKerja($cNipNya);

        $sqlto = "SELECT a.id,a.problem_subject, a.date_posted,b.input_date,b.startDuration,b.commentType, a.actual_start,a.actual_finish,a.tMarkedAsFinished
					FROM hrd.ss_raw_problems a
					JOIN hrd.ss_solution b ON b.id = a.id
					WHERE a.activity_id = 7
						AND a.finishing_by = '" .$cNipNya. "'
						AND b.pic = a.pic
					AND b.commentType = 8
					AND DATE(a.date_posted) BETWEEN '" . $perode1 . "'AND LAST_DAY('" . $perode2 . "')
					ORDER BY a.date_posted";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 0;
        $tot_hasil = 0;
        $result =0;
        $jumlahRequest = count($rows);
        for($i=0;$i<$jumlahRequest;$i++) {
            $noRow++;
            $id = $rows[$i]['id'];
            $subject = $rows[$i]['problem_subject'];

            $date_posted = $rows[$i]['date_posted'];
            $start_duration = (empty($rows[$i]['startDuration']))?$date_posted:$rows[$i]['startDuration'];
            $t_start_duration = strtotime($start_duration);

            $input_date = $rows[$i]['input_date'];
            $t_input_date = strtotime($input_date);

            $date_start = $this->formatTimestamp($start_duration,'date');
            $dt_start = strtotime($date_start);
            $day_start = date('N',$dt_start);

            $date_respon = $this->formatTimestamp($input_date,'date');
            $dt_respon = strtotime($date_respon);
            $day_respon = date('N',$dt_respon);

            $hour_start = $this->formatTimestamp($start_duration,'hour');
            $ht_start = strtotime($hour_start);

            $hour_respon = $this->formatTimestamp($input_date,'hour');
            $ht_respon = strtotime($hour_respon);

            $jam_umum_masuk = $arrJadwal['umum']['masuk'];
            $t_jam_umum_masuk = strtotime($jam_umum_masuk);

            $jam_umum_keluar = $arrJadwal['umum']['keluar'];
            $t_jam_umum_keluar = strtotime($jam_umum_keluar);

            $jam_keluar_start = $arrJadwal[ $day_start ]['keluar'];
            $t_jam_keluar_start = strtotime($jam_keluar_start);

            $calcHour = 0;
            if( $dt_start == $dt_respon ) {// direspon di hari yang sama
                $calcHour = ( $ht_respon - $ht_start )/3600;
                $totalJam += $calcHour;
            } else { // direspon di hari yang berbeda
                if( $ht_start > $t_jam_keluar_start ) { // start duration > jam keluar pic
                    $t_start_duration = $this->addDay($t_start_duration,1);// + ke hari esok
                }
                $t_start_duration = $this->skipLibur($t_start_duration,$arrJadwal);

                $count_libur = $this->getJumlahHariLibur($t_start_duration,$t_input_date,$arrJadwal);

                $t_start_duration+=$count_libur;

                $calcHour = ( $t_input_date - $t_start_duration ) / 3600;
                $totalJam += $calcHour;
            }
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $id . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $start_duration . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $input_date . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . number_format( $calcHour, 2 ) . " Jam</td>

                      </tr>";

        }

        $html .= "</table>";

        if($jumlahRequest > 0) {
            $hasil = $totalJam/$jumlahRequest;
            $hasil = number_format($hasil,2);
            $getpoint = $this->getPoint($hasil, $iAspekId);
        }else{
            $hasil = $result = 'No Data';
            $getpoint = $this->getPointEmpty($hasil, $iAspekId);
        }
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Durasi: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format( $totalJam, 2 ) . " Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Task: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jumlahRequest . " Task</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " Jam</b></td>
                    </tr>

                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }

    function hitungDs5($post)
    {
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

        $jenis = array(1 => 'UM', 2 => 'Claim');

        $bulan = $this->hitung_bulan($perode1, $perode2);

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Start</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Finish</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Duration</b></td>
            </tr>
        ";

        $arrJadwal=$this->getJadwalKerja($cNipNya);

        $sqlto = "SELECT a.id,a.problem_subject, a.date_posted,b.input_date,b.startDuration,b.commentType, a.actual_start,a.actual_finish,a.tMarkedAsFinished
					FROM hrd.ss_raw_problems a
					JOIN hrd.ss_solution b ON b.id = a.id
					WHERE a.activity_id in(11,4)
						AND a.finishing_by = '" .$cNipNya. "'
						AND b.pic = a.pic
					AND b.commentType = 8
					AND DATE(a.date_posted) BETWEEN '" . $perode1 . "'AND LAST_DAY('" . $perode2 . "')
					ORDER BY a.date_posted";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 0;
        $tot_hasil = 0;
        $result =0;
        $jumlahRequest = count($rows);
        for($i=0;$i<$jumlahRequest;$i++) {
            $noRow++;
            $id = $rows[$i]['id'];
            $subject = $rows[$i]['problem_subject'];

            $date_posted = $rows[$i]['date_posted'];
            $start_duration = (empty($rows[$i]['startDuration']))?$date_posted:$rows[$i]['startDuration'];
            $t_start_duration = strtotime($start_duration);

            $input_date = $rows[$i]['input_date'];
            $t_input_date = strtotime($input_date);

            $date_start = $this->formatTimestamp($start_duration,'date');
            $dt_start = strtotime($date_start);
            $day_start = date('N',$dt_start);

            $date_respon = $this->formatTimestamp($input_date,'date');
            $dt_respon = strtotime($date_respon);
            $day_respon = date('N',$dt_respon);

            $hour_start = $this->formatTimestamp($start_duration,'hour');
            $ht_start = strtotime($hour_start);

            $hour_respon = $this->formatTimestamp($input_date,'hour');
            $ht_respon = strtotime($hour_respon);

            $jam_umum_masuk = $arrJadwal['umum']['masuk'];
            $t_jam_umum_masuk = strtotime($jam_umum_masuk);

            $jam_umum_keluar = $arrJadwal['umum']['keluar'];
            $t_jam_umum_keluar = strtotime($jam_umum_keluar);

            $jam_keluar_start = $arrJadwal[ $day_start ]['keluar'];
            $t_jam_keluar_start = strtotime($jam_keluar_start);

            $calcHour = 0;
            if( $dt_start == $dt_respon ) {// direspon di hari yang sama
                $calcHour = ( $ht_respon - $ht_start )/3600;
                $totalJam += $calcHour;
            } else { // direspon di hari yang berbeda
                if( $ht_start > $t_jam_keluar_start ) { // start duration > jam keluar pic
                    $t_start_duration = $this->addDay($t_start_duration,1);// + ke hari esok
                }
                $t_start_duration = $this->skipLibur($t_start_duration,$arrJadwal);

                $count_libur = $this->getJumlahHariLibur($t_start_duration,$t_input_date,$arrJadwal);

                $t_start_duration+=$count_libur;

                $calcHour = ( $t_input_date - $t_start_duration ) / 3600;
                $totalJam += $calcHour;
            }
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $id . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $start_duration . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $input_date . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . number_format( $calcHour, 2 ) . " Jam</td>

                      </tr>";

        }

        $html .= "</table>";


        if($jumlahRequest > 0) {
            $hasil = $totalJam/$jumlahRequest;
            $hasil = number_format($hasil,2);
            $getpoint = $this->getPoint($hasil, $iAspekId);
        }else{
            $hasil = $result = 'No Data';
            $getpoint = $this->getPointEmpty($hasil, $iAspekId);
        }

        //$getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Durasi: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format( $totalJam, 2 ) . " Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Task: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jumlahRequest . " Task</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " Jam</b></td>
                    </tr>

                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }

    function hitungDs6($post)    {
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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Satisfaction</b></td>
            </tr>
        ";

        $sqlto = "SELECT a.confirm_date,a.satisfaction_value,a.id,b.commentType,a.problem_subject, a.date_posted,b.input_date, b.startDuration,
					a.actual_start,a.actual_finish,a.estimated_start,a.estimated_finish,a.updateSchedule
					FROM ss_raw_problems a
					JOIN ss_solution b ON b.id = a.id
					WHERE a.finishing_by = '$cNipNya'
					AND DATE(a.confirm_date) BETWEEN '$perode1' AND LAST_DAY('$perode2')
					AND confirm_date IS NOT NULL
					GROUP BY a.id
					ORDER BY a.satisfaction_value";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $html .= "<b>Detail Task</b>";
        $noRow = $jumlah = $parent = 0;
        $totalTask = 0 ;
        foreach($rows as $row) {
            $noRow++;
            $raw_id = $row['id'];
            $subject = $row['problem_subject'];
            $satisfaction_value = $row['satisfaction_value'];
            if($satisfaction_value == 0) {
                $parent+=1;
            }
            $jumlah +=$satisfaction_value;
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $raw_id . "</td>
                        <td style='width:50%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $satisfaction_value . "</td>
                      </tr>";

        }
        $html .= "</table>";
        $totalTask = $noRow - $parent;
        if($totalTask > 0){
            $hasil = number_format( ($jumlah / ( $noRow - $parent )),2 );
        }else{
            $hasil = 0;
        }


        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>(A) Total Satisfaction: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format($jumlah,0) . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>(B) Satisfaction Value = 0</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format($parent,0) . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>(C) Total Task</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format($noRow,0) . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result (A / (C - B))</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " %</b></td>
                    </tr>

                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }

    function hitungDs7($post)    {

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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Data Area </b></td>
                <td style='border: 1px solid #dddddd;' ><b>File Name</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Error Date</b></td>
            </tr>
        ";

        $sqlto = "SELECT cDataArea,b.vAreaName,cpackageId,DATE(tError)tError,a.cPIC
					FROM ss_disterror a
					LEFT OUTER JOIN area b ON a.cDataArea = b.cAreaCode
					WHERE a.cPIC = '$cNipNya'
					AND cDataArea LIKE 'HO'
					AND DATE(tError) BETWEEN '$perode1' AND LAST_DAY('$perode2')
					group by cDataArea,b.vAreaName,cpackageId,DATE(tError),a.cPIC";



        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $noRow = $noRow2 = 0;
        foreach($rows as $row) {
            $noRow++;
            $vAreaName = $row['vAreaName'];
            $cpackageId = $row['cpackageId'];
            $tError = $row['tError'];
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $vAreaName . "</td>
                        <td style='width:35%;text-align: left;border: 1px solid #dddddd;'>
                            " . $cpackageId . "</td>
                        <td style='width:35%;text-align: left;border: 1px solid #dddddd;'>
                            " . $tError . "</td>
                      </tr>";
        }

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kd Data Area </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Area</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama File</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Pengemasan</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Data Diterima</b></td>
            </tr>
        ";

/*

        $sqlto2 = "select a.iAreaId, b.vAreaName,a.cDataArea, a.cPIC, max(a.tRecv)tRecv, max(a.tPackage)tPackage, max(a.tUpdated)tUpdated , a.cFName
                  FROM ss_rcvinfo a
                  LEFT OUTER JOIN area b ON a.cDataArea = b.cAreaCode
                  WHERE a.cPIC = '$cNipNya' AND a.cDataArea LIKE 'HO'
                  AND DATE(a.tRecv) BETWEEN '$perode1' AND LAST_DAY('$perode2')
                  group by a.iAreaId, b.vAreaName,a.cDataArea,a.cPIC, a.cFName";
*/
        $sqlto2 = "select a.cKode_area, b.vAreaName, a.cPIC, max(cast(concat(d_recv, ' ',c_recv) as datetime)) tRecv,
                        max(cast(concat(d_filedate, ' ',c_filetime) as DATETIME)) tPackage, a.c_realfn cFName,
                        SUBSTRING(a.c_fname,2,2) as cDataArea
                                      FROM rcvinfo a
                                      LEFT OUTER JOIN area b ON a.cKode_area = b.cAreaCode
                                      WHERE a.cPIC = '$cNipNya' AND SUBSTRING(a.c_fname,2,2) LIKE 'HO'
                            AND d_recv BETWEEN '$perode1' AND LAST_DAY('$perode2')
                                      group BY b.vAreaName,a.cKode_area,a.cPIC, a.c_realfn";

        $rows2 = $this->db_erp_pk->query($sqlto2)->result_array();
        foreach($rows2 as $row2) {
            $noRow2++;
            $vAreaName = $row2['vAreaName'];
            $cDataArea = $row2['cDataArea'];
            $tPackage = $row2['tPackage'];
            $tRecv = $row2['tRecv'];
            $cFName = $row2['cFName'];

            if (fmod($noRow2, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow2 . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $cDataArea . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $vAreaName . "</td>
                        <td style='width:25%;text-align: center;border: 1px solid #dddddd;'>
                            " . $cFName . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $tPackage . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $tRecv . "</td>
                      </tr>";
        }
        $html .= "</table>";


        if($noRow2 > 0) {
            $hasil = ($noRow/$noRow2 )* 100;
            $result = number_format($hasil,2);
            $getpoint = $this->getPoint($result, $iAspekId);
        }else{
            $hasil = $result = 'No Data';
            $getpoint = $this->getPointEmpty($hasil, $iAspekId);
        }

        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Data Terdistribusi: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $noRow2 . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Data Error: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $noRow . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $result . " %</b></td>
                    </tr>

                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }

    function hitungDs8($post)    {

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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Data Area </b></td>
                <td style='border: 1px solid #dddddd;' ><b>File Name</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Error Date</b></td>
            </tr>
        ";

        $sqlto = "SELECT cDataArea,b.vAreaName,cpackageId,DATE(tError)tError,a.cPIC
					FROM ss_disterror a
					LEFT OUTER JOIN area b ON a.cDataArea = b.cAreaCode
					WHERE a.cPIC = '$cNipNya'
					AND cDataArea NOT LIKE 'HO'
					AND DATE(tError) BETWEEN '$perode1' AND LAST_DAY('$perode2')
					group by cDataArea,b.vAreaName,cpackageId,DATE(tError),a.cPIC";



        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $noRow = $noRow2 = 0;
        foreach($rows as $row) {
            $noRow++;
            $vAreaName = $row['vAreaName'];
            $cpackageId = $row['cpackageId'];
            $tError = $row['tError'];
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $vAreaName . "</td>
                        <td style='width:35%;text-align: left;border: 1px solid #dddddd;'>
                            " . $cpackageId . "</td>
                        <td style='width:35%;text-align: left;border: 1px solid #dddddd;'>
                            " . $tError . "</td>
                      </tr>";
        }

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kd Data Area </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Area</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama File</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Pengemasan</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Data Diterima</b></td>
            </tr>
        ";

        $sqlto2 = "select a.cKode_area, b.vAreaName, a.cPIC, max(cast(concat(d_recv, ' ',c_recv) as datetime)) tRecv,
                        max(cast(concat(d_filedate, ' ',c_filetime) as DATETIME)) tPackage, a.c_realfn cFName,
                        SUBSTRING(a.c_fname,2,2) as cDataArea
                                      FROM rcvinfo a
                                      LEFT OUTER JOIN area b ON a.cKode_area = b.cAreaCode
                                      WHERE a.cPIC = '$cNipNya' AND SUBSTRING(a.c_fname,2,2) NOT LIKE 'HO'
                            AND d_recv BETWEEN '$perode1' AND LAST_DAY('$perode2')
                                      group BY b.vAreaName,a.cKode_area,a.cPIC, a.c_realfn";

        $rows2 = $this->db_erp_pk->query($sqlto2)->result_array();
        foreach($rows2 as $row2) {
            $noRow2++;
            $vAreaName = $row2['vAreaName'];
            $cDataArea = $row2['cDataArea'];
            $tPackage = $row2['tPackage'];
            $tRecv = $row2['tRecv'];
            $cFName = $row2['cFName'];

            if (fmod($noRow2, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow2 . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $cDataArea . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $vAreaName . "</td>
                        <td style='width:25%;text-align: center;border: 1px solid #dddddd;'>
                            " . $cFName . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $tPackage . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $tRecv . "</td>
                      </tr>";
        }
        $html .= "</table>";


        if($noRow2 > 0) {
            $hasil = ($noRow/$noRow2 )* 100;
            $result = number_format($hasil,2);
            $getpoint = $this->getPoint($result, $iAspekId);
        }else{
            $hasil = $result = 'No Data';
            $getpoint = $this->getPointEmpty($hasil, $iAspekId);
        }

        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Data Terdistribusi: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $noRow2 . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Data Error: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $noRow . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $result . " %</b></td>
                    </tr>

                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }

    function hitungDs9($post)    {
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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
            </tr>
        ";

        $commentType = 5;
        $sqlto = "SELECT a.confirm_date,a.satisfaction_value,a.id,b.commentType,
                  a.problem_subject, a.date_posted,b.input_date, b.startDuration,
                  a.actual_start,a.actual_finish,a.estimated_start,a.estimated_finish,a.updateSchedule
				    FROM hrd.ss_raw_problems a
				        JOIN hrd.ss_solution b ON b.id = a.id
				    WHERE a.pic = '$cNipNya'
				        AND DATE(a.date_posted) BETWEEN '$perode1' AND LAST_DAY('$perode2')
				        AND b.commentType = $commentType
				        AND a.confirm_date IS NOT NULL
				    GROUP BY a.id ORDER BY a.id";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $html .= "<b>Jumlah Task Yang Rework</b>";
        $noRow = 0;
        foreach($rows as $row) {
            $noRow++;
            $raw_id = $row['id'];
            $subject = $row['problem_subject'];
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $raw_id . "</td>
                        <td style='width:75%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>

                      </tr>";

        }
        $html .= "</table>";
        $jml_rework = $noRow;

        $html .= "<br /> ";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
            </tr>
        ";
        $commentType = 8;
        $sqlto = "SELECT a.confirm_date,a.satisfaction_value,a.id,b.commentType,
                  a.problem_subject, a.date_posted,b.input_date, b.startDuration,
                  a.actual_start,a.actual_finish,a.estimated_start,a.estimated_finish,a.updateSchedule
				    FROM hrd.ss_raw_problems a
				        JOIN hrd.ss_solution b ON b.id = a.id
				    WHERE a.pic = '$cNipNya'
				        AND DATE(a.date_posted) BETWEEN '$perode1' AND LAST_DAY('$perode2')
				        AND b.commentType = $commentType
				        AND a.confirm_date IS NOT NULL
				    GROUP BY a.id ORDER BY a.id";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $noRow = 0;
        $html .= "<b>Jumlah Task Yang Finish</b>";
        foreach($rows as $row) {
            $noRow++;
            $raw_id = $row['id'];
            $subject = $row['problem_subject'];
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $raw_id . "</td>
                        <td style='width:75%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>

                      </tr>";
        }
        $html .= "</table>";
        $jml_finish = $noRow;

        if ($jml_finish>0){
            $hasil = number_format( ($jml_rework / $jml_finish) * 100, 2 );
        }else{
            $hasil = 0 ;
        }


        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah task yang rework: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jml_rework . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah task yang finish: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jml_finish . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " %</b></td>
                    </tr>

                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }

    function hitungDs10($post){
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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Id SPA </b></td>
                <td style='border: 1px solid #dddddd;' ><b>SPA</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Cetak</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Selesai</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kecepatan(Jam)</b></td>
            </tr>
        ";

        $arrJadwal=$this->getJadwalKerja($cNipNya);

        $sqlto ="SELECT a.iIdSpa, a.cNip, c.vName, a.dPrinted , a.dFinished FROM ss_spah a
				JOIN ss_spad b ON b.iIdSpad = a.iIdSpa
				LEFT JOIN  employee c on a.cNip = c.cNip
				WHERE b.vPic LIKE '%$cNipNya%'
				AND a.dFinished BETWEEN '$perode1' AND LAST_DAY('$perode2')";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $noRow= $total_nilai = $totalJam = 0;
        $jumlahRequest = count($rows);
        for($i=0;$i<$jumlahRequest;$i++) {
            $noRow++;
            $iIdSpa = $rows[$i]['iIdSpa'];
            $cNip = $rows[$i]['cNip'].' - '.$rows[$i]['vName'];

            $start_duration = $rows[$i]['dPrinted'];
            $t_start_duration = strtotime($start_duration);

            $input_date = $rows[$i]['dFinished'];
            $t_input_date = strtotime($input_date);

            $date_start = $this->formatTimestamp($start_duration,'date');
            $dt_start = strtotime($date_start);
            $day_start = date('N',$dt_start);

            $date_respon = $this->formatTimestamp($input_date,'date');
            $dt_respon = strtotime($date_respon);
            $day_respon = date('N',$dt_respon);

            $hour_start = $this->formatTimestamp($start_duration,'hour');
            $ht_start = strtotime($hour_start);

            $hour_respon = $this->formatTimestamp($input_date,'hour');
            $ht_respon = strtotime($hour_respon);

            $jam_umum_masuk = $arrJadwal['umum']['masuk'];
            $t_jam_umum_masuk = strtotime($jam_umum_masuk);

            $jam_umum_keluar = $arrJadwal['umum']['keluar'];
            $t_jam_umum_keluar = strtotime($jam_umum_keluar);

            $jam_keluar_start = $arrJadwal[ $day_start ]['keluar'];
            $t_jam_keluar_start = strtotime($jam_keluar_start);

            $calcHour = 0;
            if( $dt_start == $dt_respon ) {// direspon di hari yang sama
                $calcHour = ( $ht_respon - $ht_start )/3600;
                $totalJam += $calcHour;
            } else { // direspon di hari yang berbeda
                if( $ht_start > $t_jam_keluar_start ) { // start duration > jam keluar pic
                    $t_start_duration = $this->addDay($t_start_duration,1);// + ke hari esok
                }
                $calcHour = $this->hitung_beda_hari( $t_start_duration, $t_input_date, $arrJadwal );
                $calcHour = $calcHour / 3600;
                $calcHour = ( $calcHour < 0 )? 0:$calcHour;

                $totalJam += $calcHour;
            }
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>

                <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                    " . $iIdSpa . "</td>
                <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                    " . $cNip . "</td>
                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                    " . $start_duration . "</td>
                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                    " . $input_date . "</td>
                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                    " . number_format( $calcHour, 2 ) . " Jam</td>

              </tr>";

        }


        $html .= "</table>";

        if($jumlahRequest > 0) {
            $hasil = $totalJam/$jumlahRequest;
            $hasil = number_format($hasil,2);
            $getpoint = $this->getPoint($hasil, $iAspekId);
        }else{
            $hasil = $result = 'No Data';
            $getpoint = $this->getPointEmpty($hasil, $iAspekId);
        }
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Kecepatan: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format( $totalJam, 2 )." Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Request: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$jumlahRequest."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " Jam</b></td>
                    </tr>
                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }
    //==============================End Funtion PK Data Support=====================================


    //==============================Start Funtion PK Data Support Supervisor=====================================
    function hitungDsSpv1($post) {
        $iAspekId = $post['_iAspekId'];
        $iPkTransId = $post['_iPkTransId'];
        $cNipNya = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];
        $periode1 = $x_prd1['2'] . "-" . $x_prd1['1'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];
        $periode2 = $x_prd2['2'] . "-" . $x_prd2['1'];

        $sql = "SELECT cTahun, iSemester FROM hrd.pk_trans WHERE id='" . $iPkTransId . "'";
        $query = $this->db_erp_pk->query($sql);
        $cTahun = $query->row()->cTahun;
        $iSemester = $query->row()->iSemester;

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";



        $bawah = $this->getInferior($cNipNya);
        array_push($bawah,$cNipNya);
        $mx=count($bawah);
        $jumlah_objek = 0;
        $total_nilai = 0;
        $totalJamAll = $total_jam = $max = 0;
        $totalReqAll = $alltotalJam = $alljumlahRequest = $subhasil = 0;

        for($ii=0;$ii<$mx;$ii++) {
            $nipchild = $bawah[$ii];
            $html .= "
                <table>
                    <tr>
                        <td><b>NIP :</b></td>
                        <td>" . $nipchild . "</td>
                    </tr>
                </table>";


            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Filename </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Package Diterima </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Package di kemas </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Speed(hour) </b></td>
            </tr>
        ";

            $arrJadwal=$this->getJadwalKerja($nipchild);

            $sqlto = "select a.cKode_area, b.vAreaName, a.cPIC, max(cast(concat(d_recv, ' ',c_recv) as datetime)) tRecv,
                  max(cast(concat(d_filedate, ' ',c_filetime) as DATETIME)) tPackage, a.c_realfn cFName
                  FROM rcvinfo a
                  LEFT OUTER JOIN area b ON a.cKode_area = b.cAreaCode
                  WHERE a.cPIC = '$nipchild'
                  AND d_recv BETWEEN '$perode1' AND LAST_DAY('$perode2')
                  group BY b.vAreaName,a.cKode_area,a.cPIC, a.c_realfn";

            $rows = $this->db_erp_pk->query($sqlto)->result_array();
            $noRow = $total_nilai = $totalJam = 0;
            $jumlahRequest = count($rows);
            for ($i = 0; $i < $jumlahRequest; $i++) {
                $noRow++;
                $iIdSpa = $rows[$i]['cFName'];
                //$cNip = $rows[$i]['cNip'].' - '.$rows[$i]['vName'];

                $start_duration = $rows[$i]['tPackage'];
                $t_start_duration = strtotime($start_duration);

                $input_date = $rows[$i]['tRecv'];
                $t_input_date = strtotime($input_date);

                $date_start = $this->formatTimestamp($start_duration, 'date');
                $dt_start = strtotime($date_start);
                $day_start = date('N', $dt_start);

                $date_respon = $this->formatTimestamp($input_date, 'date');
                $dt_respon = strtotime($date_respon);
                $day_respon = date('N', $dt_respon);

                $hour_start = $this->formatTimestamp($start_duration, 'hour');
                $ht_start = strtotime($hour_start);

                $hour_respon = $this->formatTimestamp($input_date, 'hour');
                $ht_respon = strtotime($hour_respon);

                $jam_umum_masuk = $arrJadwal['umum']['masuk'];
                $t_jam_umum_masuk = strtotime($jam_umum_masuk);

                $jam_umum_keluar = $arrJadwal['umum']['keluar'];
                $t_jam_umum_keluar = strtotime($jam_umum_keluar);

                $jam_keluar_start = $arrJadwal[$day_start]['keluar'];
                $t_jam_keluar_start = strtotime($jam_keluar_start);

                $calcHour = 0;
                if ($dt_start == $dt_respon) {// direspon di hari yang sama
                    $calcHour = ($ht_respon - $ht_start) / 3600;
                    $totalJam += $calcHour;
                } else { // direspon di hari yang berbeda
                    if ($ht_start > $t_jam_keluar_start) { // start duration > jam keluar pic
                        $t_start_duration = $this->addDay($t_start_duration, 1);// + ke hari esok
                    }
                    $calcHour = $this->hitung_beda_hari($t_start_duration, $t_input_date, $arrJadwal);
                    $calcHour = $calcHour / 3600;
                    $calcHour = ($calcHour < 0) ? 0 : $calcHour;

                    $totalJam += $calcHour;
                }
                if (fmod($noRow, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>

                <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                    " . $iIdSpa . "</td>
                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                    " . $start_duration . "</td>
                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                    " . $input_date . "</td>
                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                    " . number_format($calcHour, 2) . " Jam</td>

              </tr>";

            }

            $subhasil = number_format( ($totalJam / $jumlahRequest) * 100, 2 );
            $alltotalJam += $totalJam;
            $alljumlahRequest += $jumlahRequest;
            $html .= "<br /> ";
            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Kecepatan: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format( $totalJam, 2 )." Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Request: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$jumlahRequest."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $subhasil . " Jam</b></td>
                    </tr>
                </table><br clear='all' /><br />";


        }



        if($alljumlahRequest > 0) {
            $hasil = ($alltotalJam/$alljumlahRequest);
            $hasil = number_format($hasil,2);
            $getpoint = $this->getPoint($hasil, $iAspekId);
        }else{
            $hasil = $result = 'No Data';
            $getpoint = $this->getPointEmpty($hasil, $iAspekId);
        }
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Grand Total Kecepatan: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format( $alltotalJam, 2 )." Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Grand Total Request: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$alljumlahRequest."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " Jam</b></td>
                    </tr>
                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }
    function hitungDsSpv2($post)
    {
        $totalJamAll = 0;
        $totalReqAll = 0;
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
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";


        $bawah = $this->getInferior($cNipNya);
        array_push($bawah,$cNipNya);
        $mx=count($bawah);
        $alltotalJam = $alljumlahRequest = $subhasil =  $alljumlahRequest = $alltotalJam = $max = 0;

        for($ii=0;$ii<$mx;$ii++) {
            $nipchild = $bawah[$ii];
            $html .= "
                <table>
                    <tr>
                        <td><b>NIP :</b></td>
                        <td>" . $nipchild . "</td>
                    </tr>
                </table>";
            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Assign Time</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Actual Start</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Respond(Hour)</b></td>
            </tr>
        ";

            $arrJadwal = $this->getJadwalKerja($nipchild);

            $sqlto = "SELECT z.id,z.problem_subject, z.date_posted,z.assignTime,
					z.actual_start,z.startDuration,z.input_date,z.commentType,
					z.vType, z.solution_id FROM (
					SELECT a.id,b.solution_id,a.problem_subject, a.date_posted,	Case when a.approveDate is not null then a.approveDate
						When a.assignTime is not null then a.assignTime  else a.date_posted end assignTime,
									a.actual_start,b.startDuration,b.input_date,b.commentType,
									b.vType,iGrp_activity_id
									FROM hrd.ss_raw_problems a
									JOIN hrd.ss_solution b ON b.id = a.id
                                    JOIN hrd.ss_activity_type c on c.activity_id = a.activity_id
									WHERE b.pic = '" . $nipchild . "'
									And a.parent_id = 0
									AND DATE(a.date_posted) BETWEEN '" . $perode1 . "' AND '" . $perode2 . "'
									AND CASE WHEN (SELECT assign FROM hrd.ss_support_type WHERE typeId=a.typeId)='Y'
									    THEN (b.commentType = 3) END
									AND a.activity_id != 22
									AND (b.isDeleted = 0 OR b.isDeleted IS NULL)
                                    AND c.iGrp_activity_id = 20
					UNION
					SELECT a.id,b.solution_id,a.problem_subject, a.date_posted,	Case when a.approveDate is not null then a.approveDate
						When a.assignTime is not null then a.assignTime  else a.date_posted end assignTime,
									a.actual_start,b.startDuration,b.input_date,b.commentType,
									b.vType,c.iGrp_activity_id
									FROM hrd.ss_raw_problems a
									JOIN hrd.ss_solution b ON b.id = a.id
                                    JOIN hrd.ss_activity_type c on c.activity_id = a.activity_id
									WHERE b.pic = '" . $nipchild . "'
									And a.parent_id = 0
									AND DATE(a.date_posted) BETWEEN '" . $perode1 . "' AND '" . $perode2 . "'
									AND b.commentType = 50
									AND a.activity_id != 22
									AND (b.isDeleted = 0 OR b.isDeleted IS NULL)
                                    AND c.iGrp_activity_id = 20
				) AS z
				GROUP BY z.id, z.vType
				ORDER BY z.date_posted,z.solution_id";

            $rows = $this->db_erp_pk->query($sqlto)->result_array();
            $no = 1;
            $size = 0;
            $noRow = 0;
            $totalJam = $subhasil = $jumlahRequest = 0;

            $tmpData = array();
            if (!empty($rows)) {
                $jumlahRequest = count($rows);

                for ($i = 0; $i < $jumlahRequest; $i++) {
                    $noRow++;
                    $id = $rows[$i]['id'];
                    $subject = $rows[$i]['problem_subject'];

                    $date_posted = $rows[$i]['date_posted'];
                    $assignTime = $rows[$i]['assignTime'];
                    $actual_start = $rows[$i]['actual_start'];

                    if ($rows[$i]['vType'] == 'Joblog') {
                        $start_duration = (empty($assignTime) || strtotime($assignTime) < strtotime($date_posted)) ? $date_posted : $assignTime;
                        $t_start_duration = strtotime($start_duration);

                        $input_date = $rows[$i]['startDuration'];
                        $t_input_date = strtotime($input_date);
                    } else {
                        $start_def = (empty($assignTime)) ? $date_posted : $assignTime;
                        $start_duration = (empty($rows[$i]['startDuration'])) ? $start_def : $rows[$i]['startDuration'];
                        $t_start_duration = strtotime($start_duration);

                        $input_date = $rows[$i]['input_date'];
                        $t_input_date = strtotime($input_date);
                    }

                    $date_start = $this->formatTimestamp($start_duration, 'date');
                    $dt_start = strtotime($date_start);
                    $day_start = date('N', $dt_start);

                    $date_respon = $this->formatTimestamp($input_date, 'date');
                    $dt_respon = strtotime($date_respon);
                    $day_respon = date('N', $dt_respon);

                    $hour_start = $this->formatTimestamp($start_duration, 'hour');
                    $ht_start = strtotime($hour_start);

                    $hour_respon = $this->formatTimestamp($input_date, 'hour');
                    $ht_respon = strtotime($hour_respon);

                    $jam_umum_masuk = $arrJadwal['umum']['masuk'];
                    $t_jam_umum_masuk = strtotime($jam_umum_masuk);

                    $jam_umum_keluar = $arrJadwal['umum']['keluar'];
                    $t_jam_umum_keluar = strtotime($jam_umum_keluar);

                    $jam_keluar_start = $arrJadwal[$day_start]['keluar'];
                    $t_jam_keluar_start = strtotime($jam_keluar_start);

                    $calcHour = 0;

                    if ($dt_start == $dt_respon) {// direspon di hari yang sama
                        $calcHour = ($ht_respon - $ht_start) / 3600;
                        $calcHour = ($calcHour < 0) ? 0 : $calcHour;

                        if ($rows[$i]['vType'] == 'Joblog') {
                            $tmpData[$id]['joblog'] = $calcHour;
                        } else {
                            $tmpData[$id]['followup'] = $calcHour;
                        }
                    } else { // direspon di hari yang berbeda

                        $calcHour = $this->hitung_beda_hari($t_start_duration, $t_input_date, $arrJadwal);
                        $calcHour = $calcHour / 3600;
                        $calcHour = ($calcHour < 0) ? 0 : $calcHour;

                        if ($rows[$i]['vType'] == 'Joblog') {
                            $tmpData[$id]['joblog'] = $calcHour;
                        } else {
                            $tmpData[$id]['followup'] = $calcHour;
                        }
                        $dateStart = date('Y-m-d H:i:s', $t_start_duration);
                    }

                    if (fmod($noRow, 2) == 0) {
                        $color = 'background-color: #eaedce';
                    } else {
                        $color = '';
                    }

                    $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $id . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $subject . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . $start_duration . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . $input_date . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . number_format($calcHour, 2) . "</td>
                          </tr>";
                    $no++;
                }
                $jumlahRequest = 0;
                if(count($tmpData)>0) {
                    foreach( $tmpData as $tdKey => $tdVal ) {
                        $x1 = 9999999999;
                        if( isset($tdVal['joblog'])) {
                            $x1 = $tdVal['joblog'];
                        }

                        $x2 = 9999999999;
                        if( isset($tdVal['followup'])) {
                            $x2 = $tdVal['followup'];
                        }

                        if( $x1 < $x2 ) {
                            $totalJam += $x1;
                            $jumlahRequest++;
                        } else if( $x2 < $x1 ) {
                            $totalJam += $x2;
                            $jumlahRequest++;
                        }
                    }
                }
                $html .= "</table>";

                if($jumlahRequest > 0) {
                    $subhasil = $totalJam/$jumlahRequest;
                    $subhasil = number_format($subhasil,2);
                }else{
                    $subhasil = $result = 'No Data';
                }
                $html .= "<br /> ";

                $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Respond: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format( $totalJam, 2 )." Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Request: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$jumlahRequest."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $subhasil . " Jam</b></td>
                    </tr>
                </table><br clear='all' /><br />";

                $alljumlahRequest += $jumlahRequest;
                $alltotalJam += $totalJam;
            }

        }



        if($alljumlahRequest > 0) {
            $hasil = $alltotalJam/$alljumlahRequest;
            $hasil = number_format($hasil,2);
            $getpoint = $this->getPoint($hasil, $iAspekId);
        }else{
            $hasil = $result = 'No Data';
            $getpoint = $this->getPointEmpty($hasil, $iAspekId);
        }
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Respond: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format( $alltotalJam, 2 )." Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Request: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$alljumlahRequest."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " Jam</b></td>
                    </tr>
                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }
    function hitungDsSpv3($post)
    {
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

        $jenis = array(1 => 'UM', 2 => 'Claim');

        $bulan = $this->hitung_bulan($perode1, $perode2);

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";
        $bawah = $this->getInferior($cNipNya);
        array_push($bawah,$cNipNya);
        $mx=count($bawah);

        $alltotalJam = $alljumlahRequest = $subhasil =  $alljumlahRequest = $alltotalJam = $max = 0;

        for($ii=0;$ii<$mx;$ii++) {
            $totalJam = $subhasil = $jumlahRequest = 0;
            $nipchild = $bawah[$ii];
            $html .= "
                <table>
                    <tr>
                        <td><b>NIP :</b></td>
                        <td>" . $nipchild . "</td>
                    </tr>
                </table>";
            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Start</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Finish</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Duration</b></td>
            </tr>
        ";

            $arrJadwal = $this->getJadwalKerja($nipchild);

            $sqlto = "SELECT a.id,a.problem_subject, a.date_posted,b.input_date,b.startDuration,b.commentType, a.actual_start,a.actual_finish,a.tMarkedAsFinished
					FROM hrd.ss_raw_problems a
					JOIN hrd.ss_solution b ON b.id = a.id
					WHERE a.activity_id = 4
						AND a.finishing_by = '" . $nipchild . "'
						AND b.pic = a.pic
					AND b.commentType = 8
					AND DATE(a.date_posted) BETWEEN '" . $perode1 . "'AND LAST_DAY('" . $perode2 . "')
					ORDER BY a.date_posted";

            $rows = $this->db_erp_pk->query($sqlto)->result_array();
            $no = 0;
            $tot_hasil = $noRow = 0;
            $result = 0;
            $jumlahRequest = count($rows);

            for ($i = 0; $i < $jumlahRequest; $i++) {
                $noRow++;
                $id = $rows[$i]['id'];
                $subject = $rows[$i]['problem_subject'];

                $date_posted = $rows[$i]['date_posted'];
                $start_duration = (empty($rows[$i]['startDuration'])) ? $date_posted : $rows[$i]['startDuration'];
                $t_start_duration = strtotime($start_duration);

                $input_date = $rows[$i]['input_date'];
                $t_input_date = strtotime($input_date);

                $date_start = $this->formatTimestamp($start_duration, 'date');
                $dt_start = strtotime($date_start);
                $day_start = date('N', $dt_start);

                $date_respon = $this->formatTimestamp($input_date, 'date');
                $dt_respon = strtotime($date_respon);
                $day_respon = date('N', $dt_respon);

                $hour_start = $this->formatTimestamp($start_duration, 'hour');
                $ht_start = strtotime($hour_start);

                $hour_respon = $this->formatTimestamp($input_date, 'hour');
                $ht_respon = strtotime($hour_respon);

                $jam_umum_masuk = $arrJadwal['umum']['masuk'];
                $t_jam_umum_masuk = strtotime($jam_umum_masuk);

                $jam_umum_keluar = $arrJadwal['umum']['keluar'];
                $t_jam_umum_keluar = strtotime($jam_umum_keluar);

                $jam_keluar_start = $arrJadwal[$day_start]['keluar'];
                $t_jam_keluar_start = strtotime($jam_keluar_start);

                $calcHour = 0;
                if ($dt_start == $dt_respon) {// direspon di hari yang sama
                    $calcHour = ($ht_respon - $ht_start) / 3600;
                    $totalJam += $calcHour;
                } else { // direspon di hari yang berbeda
                    if ($ht_start > $t_jam_keluar_start) { // start duration > jam keluar pic
                        $t_start_duration = $this->addDay($t_start_duration, 1);// + ke hari esok
                    }
                    $t_start_duration = $this->skipLibur($t_start_duration, $arrJadwal);

                    $count_libur = $this->getJumlahHariLibur($t_start_duration, $t_input_date, $arrJadwal);

                    $t_start_duration += $count_libur;

                    $calcHour = ($t_input_date - $t_start_duration) / 3600;
                    $totalJam += $calcHour;
                }
                if (fmod($noRow, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $id . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $start_duration . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $input_date . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . number_format($calcHour, 2) . " Jam</td>

                      </tr>";

            }
            if($jumlahRequest > 0) {
                $subhasil = $totalJam/$jumlahRequest;
                $subhasil = number_format($subhasil,2);
            }else{
                $subhasil = $result = 'No Data';
            }

            $html .= "<br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Durasi: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format( $totalJam, 2 ) . " Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Task: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jumlahRequest . " Task</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $subhasil . " Jam</b></td>
                    </tr>

                </table><br clear='all' /><br />";
            $alljumlahRequest += $jumlahRequest;
            $alltotalJam += $totalJam;

        }
        $html .= "</table>";

        if($alljumlahRequest > 0) {
            $hasil = $alltotalJam/$alljumlahRequest;
            $hasil = number_format($hasil,2);
            $getpoint = $this->getPoint($hasil, $iAspekId);
        }else{
            $hasil = $result = 'No Data';
            $getpoint = $this->getPointEmpty($hasil, $iAspekId);
        }
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Durasi: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format( $alltotalJam, 2 ) . " Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Task: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $alljumlahRequest . " Task</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " Jam</b></td>
                    </tr>

                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }
    function hitungDsSpv4($post)
    {
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

        $jenis = array(1 => 'UM', 2 => 'Claim');

        $bulan = $this->hitung_bulan($perode1, $perode2);

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";

        $bawah = $this->getInferior($cNipNya);
        array_push($bawah,$cNipNya);
        $mx=count($bawah);
        $alltotalJam = $alljumlahRequest = $subhasil =  $alljumlahRequest = $alltotalJam = $max = 0;

        for($ii=0;$ii<$mx;$ii++) {
            $nipchild = $bawah[$ii];
            $html .= "
                <table>
                    <tr>
                        <td><b>NIP :</b></td>
                        <td>" . $nipchild . "</td>
                    </tr>
                </table>";
            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Start</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Finish</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Duration</b></td>
            </tr>
        ";

            $arrJadwal = $this->getJadwalKerja($nipchild);

            $sqlto = "SELECT a.id,a.problem_subject, a.date_posted,b.input_date,b.startDuration,b.commentType, a.actual_start,a.actual_finish,a.tMarkedAsFinished
					FROM hrd.ss_raw_problems a
					JOIN hrd.ss_solution b ON b.id = a.id
					WHERE a.activity_id = 7
						AND a.finishing_by = '" . $nipchild . "'
						AND b.pic = a.pic
					AND b.commentType = 8
					AND DATE(a.date_posted) BETWEEN '" . $perode1 . "'AND LAST_DAY('" . $perode2 . "')
					ORDER BY a.date_posted";

            $rows = $this->db_erp_pk->query($sqlto)->result_array();
            $totalJam = $subhasil = $jumlahRequest = $noRow = 0;
            $jumlahRequest = count($rows);
            for ($i = 0; $i < $jumlahRequest; $i++) {
                $noRow++;
                $id = $rows[$i]['id'];
                $subject = $rows[$i]['problem_subject'];

                $date_posted = $rows[$i]['date_posted'];
                $start_duration = (empty($rows[$i]['startDuration'])) ? $date_posted : $rows[$i]['startDuration'];
                $t_start_duration = strtotime($start_duration);

                $input_date = $rows[$i]['input_date'];
                $t_input_date = strtotime($input_date);

                $date_start = $this->formatTimestamp($start_duration, 'date');
                $dt_start = strtotime($date_start);
                $day_start = date('N', $dt_start);

                $date_respon = $this->formatTimestamp($input_date, 'date');
                $dt_respon = strtotime($date_respon);
                $day_respon = date('N', $dt_respon);

                $hour_start = $this->formatTimestamp($start_duration, 'hour');
                $ht_start = strtotime($hour_start);

                $hour_respon = $this->formatTimestamp($input_date, 'hour');
                $ht_respon = strtotime($hour_respon);

                $jam_umum_masuk = $arrJadwal['umum']['masuk'];
                $t_jam_umum_masuk = strtotime($jam_umum_masuk);

                $jam_umum_keluar = $arrJadwal['umum']['keluar'];
                $t_jam_umum_keluar = strtotime($jam_umum_keluar);

                $jam_keluar_start = $arrJadwal[$day_start]['keluar'];
                $t_jam_keluar_start = strtotime($jam_keluar_start);

                $calcHour = 0;
                if ($dt_start == $dt_respon) {// direspon di hari yang sama
                    $calcHour = ($ht_respon - $ht_start) / 3600;
                    $totalJam += $calcHour;
                } else { // direspon di hari yang berbeda
                    if ($ht_start > $t_jam_keluar_start) { // start duration > jam keluar pic
                        $t_start_duration = $this->addDay($t_start_duration, 1);// + ke hari esok
                    }
                    $t_start_duration = $this->skipLibur($t_start_duration, $arrJadwal);

                    $count_libur = $this->getJumlahHariLibur($t_start_duration, $t_input_date, $arrJadwal);

                    $t_start_duration += $count_libur;

                    $calcHour = ($t_input_date - $t_start_duration) / 3600;
                    $totalJam += $calcHour;
                }
                if (fmod($noRow, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $id . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $start_duration . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $input_date . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . number_format($calcHour, 2) . " Jam</td>

                      </tr>";

            }
            if($jumlahRequest > 0) {
                $subhasil = $totalJam/$jumlahRequest;
                $subhasil = number_format($subhasil,2);
            }else{
                $subhasil = $result = 'No Data';
            }


            $html .= "<br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Durasi: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format( $totalJam, 2 ) . " Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Task: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jumlahRequest . " Task</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $subhasil . " Jam</b></td>
                    </tr>

                </table><br clear='all' /><br />";
            $alljumlahRequest += $jumlahRequest;
            $alltotalJam += $totalJam;
        }
        $html .= "</table>";

        if($alljumlahRequest > 0) {
            $hasil = $alltotalJam/$alljumlahRequest;
            $hasil = number_format($hasil,2);
            $getpoint = $this->getPoint($hasil, $iAspekId);
        }else{
            $hasil = $result = 'No Data';
            $getpoint = $this->getPointEmpty($hasil, $iAspekId);
        }
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Durasi: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format( $alltotalJam, 2 ) . " Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Task: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $alljumlahRequest . " Task</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " Jam</b></td>
                    </tr>

                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }
    function hitungDsSpv5($post)
    {
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

        $jenis = array(1 => 'UM', 2 => 'Claim');

        $bulan = $this->hitung_bulan($perode1, $perode2);

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";

        $bawah = $this->getInferior($cNipNya);
        array_push($bawah,$cNipNya);
        $mx=count($bawah);
        $alltotalJam = $alljumlahRequest = $subhasil =  $alljumlahRequest = $alltotalJam = $max = 0;

        for($ii=0;$ii<$mx;$ii++) {
            $nipchild = $bawah[$ii];
            $html .= "
                <table>
                    <tr>
                        <td><b>NIP :</b></td>
                        <td>" . $nipchild . "</td>
                    </tr>
                </table>";
            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Start</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Finish</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Duration</b></td>
            </tr>
        ";

            $arrJadwal = $this->getJadwalKerja($nipchild);

            $sqlto = "SELECT a.id,a.problem_subject, a.date_posted,b.input_date,b.startDuration,b.commentType, a.actual_start,a.actual_finish,a.tMarkedAsFinished
					FROM hrd.ss_raw_problems a
					JOIN hrd.ss_solution b ON b.id = a.id
					WHERE a.activity_id = 11
						AND a.finishing_by = '" . $nipchild . "'
						AND b.pic = a.pic
					AND b.commentType = 8
					AND DATE(a.date_posted) BETWEEN '" . $perode1 . "'AND LAST_DAY('" . $perode2 . "')
					ORDER BY a.date_posted";

            $rows = $this->db_erp_pk->query($sqlto)->result_array();
            $no = 0;
            $tot_hasil = 0;
            $result = 0;
            $totalJam = $subhasil = $jumlahRequest = $noRow = 0;
            $jumlahRequest = count($rows);
            for ($i = 0; $i < $jumlahRequest; $i++) {
                $noRow++;
                $id = $rows[$i]['id'];
                $subject = $rows[$i]['problem_subject'];

                $date_posted = $rows[$i]['date_posted'];
                $start_duration = (empty($rows[$i]['startDuration'])) ? $date_posted : $rows[$i]['startDuration'];
                $t_start_duration = strtotime($start_duration);

                $input_date = $rows[$i]['input_date'];
                $t_input_date = strtotime($input_date);

                $date_start = $this->formatTimestamp($start_duration, 'date');
                $dt_start = strtotime($date_start);
                $day_start = date('N', $dt_start);

                $date_respon = $this->formatTimestamp($input_date, 'date');
                $dt_respon = strtotime($date_respon);
                $day_respon = date('N', $dt_respon);

                $hour_start = $this->formatTimestamp($start_duration, 'hour');
                $ht_start = strtotime($hour_start);

                $hour_respon = $this->formatTimestamp($input_date, 'hour');
                $ht_respon = strtotime($hour_respon);

                $jam_umum_masuk = $arrJadwal['umum']['masuk'];
                $t_jam_umum_masuk = strtotime($jam_umum_masuk);

                $jam_umum_keluar = $arrJadwal['umum']['keluar'];
                $t_jam_umum_keluar = strtotime($jam_umum_keluar);

                $jam_keluar_start = $arrJadwal[$day_start]['keluar'];
                $t_jam_keluar_start = strtotime($jam_keluar_start);

                $calcHour = 0;
                if ($dt_start == $dt_respon) {// direspon di hari yang sama
                    $calcHour = ($ht_respon - $ht_start) / 3600;
                    $totalJam += $calcHour;
                } else { // direspon di hari yang berbeda
                    if ($ht_start > $t_jam_keluar_start) { // start duration > jam keluar pic
                        $t_start_duration = $this->addDay($t_start_duration, 1);// + ke hari esok
                    }
                    $t_start_duration = $this->skipLibur($t_start_duration, $arrJadwal);

                    $count_libur = $this->getJumlahHariLibur($t_start_duration, $t_input_date, $arrJadwal);

                    $t_start_duration += $count_libur;

                    $calcHour = ($t_input_date - $t_start_duration) / 3600;
                    $totalJam += $calcHour;
                }
                if (fmod($noRow, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>

                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                            " . $id . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $start_duration . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $input_date . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . number_format($calcHour, 2) . " Jam</td>

                      </tr>";

            }
            if($jumlahRequest > 0) {
                $subhasil = $totalJam/$jumlahRequest;
                $subhasil = number_format($subhasil,2);
            }else{
                $subhasil = $result = 'No Data';
            }

            $html .= "<br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Durasi: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format( $totalJam, 2 ) . " Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Task: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jumlahRequest . " Task</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $subhasil . " Jam</b></td>
                    </tr>

                </table><br clear='all' /><br />";
            $alljumlahRequest += $jumlahRequest;
            $alltotalJam += $totalJam;
        }
        $html .= "</table>";


        if($alljumlahRequest > 0) {
            $hasil = $alltotalJam/$alljumlahRequest;
            $hasil = number_format($hasil,2);
            $getpoint = $this->getPoint($hasil, $iAspekId);
        }else{
            $hasil = $result = 'No Data';
            $getpoint = $this->getPointEmpty($hasil, $iAspekId);
        }

        //$getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Durasi: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format( $alltotalJam, 2 ) . " Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Task: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $alljumlahRequest . " Task</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " Jam</b></td>
                    </tr>

                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }
    function hitungDsSpv6($post)    {
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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";
        $bawah = $this->getInferior($cNipNya);
        array_push($bawah,$cNipNya);
        $mx=count($bawah);
        $totalParents = $totalnoRow =  $totaljumlah = $subhasil  = $max = 0;

        for($ii=0;$ii<$mx;$ii++) {
            $nipchild = $bawah[$ii];
            $html .= "
                <table>
                    <tr>
                        <td><b>NIP :</b></td>
                        <td>" . $nipchild . "</td>
                    </tr>
                </table>";
            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Satisfaction</b></td>
            </tr>
        ";

            $sqlto = "SELECT a.confirm_date,a.satisfaction_value,a.id,b.commentType,a.problem_subject, a.date_posted,b.input_date, b.startDuration,
					a.actual_start,a.actual_finish,a.estimated_start,a.estimated_finish,a.updateSchedule
					FROM ss_raw_problems a
					JOIN ss_solution b ON b.id = a.id
					WHERE a.finishing_by = '$nipchild'
					AND DATE(a.confirm_date) BETWEEN '$perode1' AND LAST_DAY('$perode2')
					AND confirm_date IS NOT NULL
					GROUP BY a.id
					ORDER BY a.satisfaction_value";

            $rows = $this->db_erp_pk->query($sqlto)->result_array();
            $html .= "<b>Detail Task</b>";
            $noRow = $jumlah = $parent = 0;
            $totalTask = $subhasil = $jumlahRequest = 0;

            foreach ($rows as $row) {
                $noRow++;
                $raw_id = $row['id'];
                $subject = $row['problem_subject'];
                $satisfaction_value = $row['satisfaction_value'];
                if ($satisfaction_value == 0) {
                    $parent += 1;
                }
                $jumlah += $satisfaction_value;
                if (fmod($noRow, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $raw_id . "</td>
                        <td style='width:50%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $satisfaction_value . "</td>
                      </tr>";

            }
            $totalTask = $noRow - $parent;
            if($totalTask > 0){
                $subhasil = number_format( ($jumlah / ( $noRow - $parent )),2 );
            }else{
                $subhasil = 0;
            }


            $html .= "<br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>(A) Total Satisfaction: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format($jumlah,0) . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>(B) Satisfaction Value = 0</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format($parent,0) . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>(C) Total Task</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format($noRow,0) . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result (A / (C - B))</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $subhasil . " %</b></td>
                    </tr>

                </table><br clear='all' /><br />";
            $totalParents += $parent;
            $totalnoRow += $noRow;
            $totaljumlah += $jumlah;

        }

        $html .= "</table>";
        $totalTask = $totalnoRow - $totalParents;
        if($totalTask > 0){
            $hasil = number_format( ($totaljumlah / ( $totalnoRow - $totalParents )),2 );
        }else{
            $hasil = 0;
        }

        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>(A) Total Satisfaction: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format($totaljumlah,0) . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>(B) Satisfaction Value = 0</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format($totalParents,0) . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>(C) Total Task</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format($totalnoRow,0) . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result (A / (C - B))</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " %</b></td>
                    </tr>

                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }
    function hitungDsSpv7($post)    {

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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";
        $bawah = $this->getInferior($cNipNya);
        array_push($bawah,$cNipNya);
        $mx=count($bawah);
        $totalnoRow2 = $totalnoRow =  $hasil = $alltotalJam = $max = 0;

        for($ii=0;$ii<$mx;$ii++) {
            $nipchild = $bawah[$ii];
            $html .= "
                <table>
                    <tr>
                        <td><b>NIP :</b></td>
                        <td>" . $nipchild . "</td>
                    </tr>
                </table>";
            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Data Area </b></td>
                <td style='border: 1px solid #dddddd;' ><b>File Name</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Error Date</b></td>
            </tr>
        ";

            $sqlto = "SELECT cDataArea,b.vAreaName,cpackageId,DATE(tError)tError,a.cPIC
					FROM ss_disterror a
					LEFT OUTER JOIN area b ON a.cDataArea = b.cAreaCode
					WHERE a.cPIC = '$nipchild'
					AND cDataArea LIKE 'HO'
					AND DATE(tError) BETWEEN '$perode1' AND LAST_DAY('$perode2')
					group by cDataArea,b.vAreaName,cpackageId,DATE(tError),a.cPIC";


            $rows = $this->db_erp_pk->query($sqlto)->result_array();
            $noRow = $noRow2 = $subhasil = 0;
            foreach ($rows as $row) {
                $noRow++;
                $vAreaName = $row['vAreaName'];
                $cpackageId = $row['cpackageId'];
                $tError = $row['tError'];
                if (fmod($noRow, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $vAreaName . "</td>
                        <td style='width:35%;text-align: left;border: 1px solid #dddddd;'>
                            " . $cpackageId . "</td>
                        <td style='width:35%;text-align: left;border: 1px solid #dddddd;'>
                            " . $tError . "</td>
                      </tr>";
            }

            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kd Data Area </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Area</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama File</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Pengemasan</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Data Diterima</b></td>
            </tr>
        ";

            $sqlto2 = "select a.cKode_area, b.vAreaName, a.cPIC, max(cast(concat(d_recv, ' ',c_recv) as datetime)) tRecv,
                        max(cast(concat(d_filedate, ' ',c_filetime) as DATETIME)) tPackage, a.c_realfn cFName,
                        SUBSTRING(a.c_fname,2,2) as cDataArea
                                      FROM rcvinfo a
                                      LEFT OUTER JOIN area b ON a.cKode_area = b.cAreaCode
                                      WHERE a.cPIC = '$nipchild' AND SUBSTRING(a.c_fname,2,2) LIKE 'HO'
                            AND d_recv BETWEEN '$perode1' AND LAST_DAY('$perode2')
                                      group BY b.vAreaName,a.cKode_area,a.cPIC, a.c_realfn";

            $rows2 = $this->db_erp_pk->query($sqlto2)->result_array();
            foreach ($rows2 as $row2) {
                $noRow2++;
                $vAreaName = $row2['vAreaName'];
                $cDataArea = $row2['cDataArea'];
                $tPackage = $row2['tPackage'];
                $tRecv = $row2['tRecv'];
                $cFName = $row2['cFName'];

                if (fmod($noRow2, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow2 . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $cDataArea . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $vAreaName . "</td>
                        <td style='width:25%;text-align: center;border: 1px solid #dddddd;'>
                            " . $cFName . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $tPackage . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $tRecv . "</td>
                      </tr>";
            }

            if($noRow2 > 0) {
                $subhasil = ($noRow/$noRow2 )* 100;
                $subhasil = number_format($subhasil,2);
            }else{
                $subhasil = $result = 'No Data';
            }


            $html .= "<br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Data Terdistribusi: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $noRow2 . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Data Error: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $noRow . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $subhasil . " %</b></td>
                    </tr>

                </table><br clear='all' /><br />";
            $totalnoRow2 += $noRow2;
            $totalnoRow += $noRow;
        }
        $html .= "</table>";


        if($totalnoRow2 > 0) {
            $hasil = ($totalnoRow/$totalnoRow2 )* 100;
            $result = number_format($hasil,2);
            $getpoint = $this->getPoint($result, $iAspekId);
        }else{
            $hasil = $result = 'No Data';
            $getpoint = $this->getPointEmpty($hasil, $iAspekId);
        }

        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Data Terdistribusi: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $totalnoRow2 . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Data Error: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $totalnoRow . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $result . " %</b></td>
                    </tr>

                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }
    function hitungDsSpv8($post)
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

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";
        $bawah = $this->getInferior($cNipNya);
        array_push($bawah,$cNipNya);
        $mx=count($bawah);
        $totalnoRow2 = $totalnoRow =  $hasil = $alltotalJam = $max = 0;

        for($ii=0;$ii<$mx;$ii++) {
            $nipchild = $bawah[$ii];
            $html .= "
                <table>
                    <tr>
                        <td><b>NIP :</b></td>
                        <td>" . $nipchild . "</td>
                    </tr>
                </table>";
            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Data Area </b></td>
                <td style='border: 1px solid #dddddd;' ><b>File Name</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Error Date</b></td>
            </tr>
        ";

            $sqlto = "SELECT cDataArea,b.vAreaName,cpackageId,DATE(tError)tError,a.cPIC
					FROM ss_disterror a
					LEFT OUTER JOIN area b ON a.cDataArea = b.cAreaCode
					WHERE a.cPIC = '$nipchild'
					AND cDataArea NOT LIKE 'HO'
					AND DATE(tError) BETWEEN '$perode1' AND LAST_DAY('$perode2')
					group by cDataArea,b.vAreaName,cpackageId,DATE(tError),a.cPIC";


            $rows = $this->db_erp_pk->query($sqlto)->result_array();
            $noRow = $noRow2 = $subhasil = 0;
            foreach ($rows as $row) {
                $noRow++;
                $vAreaName = $row['vAreaName'];
                $cpackageId = $row['cpackageId'];
                $tError = $row['tError'];
                if (fmod($noRow, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $vAreaName . "</td>
                        <td style='width:35%;text-align: left;border: 1px solid #dddddd;'>
                            " . $cpackageId . "</td>
                        <td style='width:35%;text-align: left;border: 1px solid #dddddd;'>
                            " . $tError . "</td>
                      </tr>";
            }

            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kd Data Area </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Area</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama File</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Pengemasan</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Data Diterima</b></td>
            </tr>
        ";

            $sqlto2 = "select a.cKode_area, b.vAreaName, a.cPIC, max(cast(concat(d_recv, ' ',c_recv) as datetime)) tRecv,
                        max(cast(concat(d_filedate, ' ',c_filetime) as DATETIME)) tPackage, a.c_realfn cFName,
                        SUBSTRING(a.c_fname,2,2) as cDataArea
                                      FROM rcvinfo a
                                      LEFT OUTER JOIN area b ON a.cKode_area = b.cAreaCode
                                      WHERE a.cPIC = '$nipchild' AND SUBSTRING(a.c_fname,2,2) NOT LIKE 'HO'
                            AND d_recv BETWEEN '$perode1' AND LAST_DAY('$perode2')
                                      group BY b.vAreaName,a.cKode_area,a.cPIC, a.c_realfn";

            $rows2 = $this->db_erp_pk->query($sqlto2)->result_array();
            foreach ($rows2 as $row2) {
                $noRow2++;
                $vAreaName = $row2['vAreaName'];
                $cDataArea = $row2['cDataArea'];
                $tPackage = $row2['tPackage'];
                $tRecv = $row2['tRecv'];
                $cFName = $row2['cFName'];

                if (fmod($noRow2, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow2 . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $cDataArea . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $vAreaName . "</td>
                        <td style='width:25%;text-align: center;border: 1px solid #dddddd;'>
                            " . $cFName . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $tPackage . "</td>
                        <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                            " . $tRecv . "</td>
                      </tr>";
            }
            if($noRow2 > 0) {
                $subhasil = ($noRow/$noRow2 )* 100;
                $subhasil = number_format($subhasil,2);
            }else{
                $subhasil = $result = 'No Data';
            }

            $html .= "<br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Data Terdistribusi: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $noRow2 . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Data Error: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $noRow . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $subhasil . " %</b></td>
                    </tr>

                </table><br clear='all' /><br />";

            $totalnoRow2 += $noRow2;
            $totalnoRow += $noRow;
        }
        $html .= "</table>";
        if($totalnoRow2 > 0) {
            $hasil = ($totalnoRow/$totalnoRow2 )* 100;
            $result = number_format($hasil,2);
            $getpoint = $this->getPoint($result, $iAspekId);
        }else{
            $hasil = $result = 'No Data';
            $getpoint = $this->getPointEmpty($hasil, $iAspekId);
        }


        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Data Terdistribusi: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $totalnoRow2 . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Data Error: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $totalnoRow . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $result . " %</b></td>
                    </tr>

                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }
    function hitungDsSpv9($post)    {

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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";
        $bawah = $this->getInferior($cNipNya);
        array_push($bawah,$cNipNya);
        $mx=count($bawah);
        $alltotalJam = $alljumlahRequest = $subhasil =  $alljumlahRequest = $alltotalJam = $max = 0;
        $totalRework =  $totalFinish = $subhasil = 0;
        for($ii=0;$ii<$mx;$ii++) {
            $nipchild = $bawah[$ii];
            $html .= "
                <table>
                    <tr>
                        <td><b>NIP :</b></td>
                        <td>" . $nipchild . "</td>
                    </tr>
                </table>";
            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
            </tr>
        ";

            $commentType = 5;
            $sqlto = "SELECT a.confirm_date,a.satisfaction_value,a.id,b.commentType,
                  a.problem_subject, a.date_posted,b.input_date, b.startDuration,
                  a.actual_start,a.actual_finish,a.estimated_start,a.estimated_finish,a.updateSchedule
				    FROM hrd.ss_raw_problems a
				        JOIN hrd.ss_solution b ON b.id = a.id
				    WHERE a.pic = '$nipchild'
				        AND DATE(a.date_posted) BETWEEN '$perode1' AND LAST_DAY('$perode2')
				        AND b.commentType = $commentType
				        AND a.confirm_date IS NOT NULL
				    GROUP BY a.id ORDER BY a.id";

            $rows = $this->db_erp_pk->query($sqlto)->result_array();
            $html .= "<b>Jumlah Task Yang Rework</b>";
            $noRow = 0;

            foreach ($rows as $row) {
                $noRow++;
                $raw_id = $row['id'];
                $subject = $row['problem_subject'];
                if (fmod($noRow, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $raw_id . "</td>
                        <td style='width:75%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>

                      </tr>";

            }
            $html .= "</table>";
            $jml_rework = $noRow;

            $html .= "<br /> ";

            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
            </tr>
        ";
            $commentType = 8;
            $sqlto = "SELECT a.confirm_date,a.satisfaction_value,a.id,b.commentType,
                  a.problem_subject, a.date_posted,b.input_date, b.startDuration,
                  a.actual_start,a.actual_finish,a.estimated_start,a.estimated_finish,a.updateSchedule
				    FROM hrd.ss_raw_problems a
				        JOIN hrd.ss_solution b ON b.id = a.id
				    WHERE a.pic = '$nipchild'
				        AND DATE(a.date_posted) BETWEEN '$perode1' AND LAST_DAY('$perode2')
				        AND b.commentType = $commentType
				        AND a.confirm_date IS NOT NULL
				    GROUP BY a.id ORDER BY a.id";

            $rows = $this->db_erp_pk->query($sqlto)->result_array();
            $noRow = 0;
            $html .= "<b>Jumlah Task Yang Finish</b>";
            foreach ($rows as $row) {
                $noRow++;
                $raw_id = $row['id'];
                $subject = $row['problem_subject'];
                if (fmod($noRow, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $raw_id . "</td>
                        <td style='width:75%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>

                      </tr>";
            }
            $jml_finish = $noRow;

            if ($jml_finish>0){
                $subhasil = number_format( ($jml_rework / $jml_finish) * 100, 2 );
            }else{
                $subhasil = 0 ;
            }


            $html .= "<br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah task yang rework: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jml_rework . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah task yang finish: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jml_finish . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $subhasil . " %</b></td>
                    </tr>

                </table><br clear='all' /><br />";
            $totalRework += $jml_rework;
            $totalFinish += $jml_finish;

        }
        $html .= "</table>";


        if ($totalFinish>0){
            $hasil = number_format( ($totalRework / $totalFinish) * 100, 2 );
        }else{
            $hasil = 0 ;
        }


        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah task yang rework: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $totalRework . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah task yang finish: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $totalFinish . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " %</b></td>
                    </tr>

                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }

    function hitungDsSpv10($post){
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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>
                    </tr>
                </table>";

        $bawah = $this->getInferior($cNipNya);
        array_push($bawah,$cNipNya);
        $mx=count($bawah);
        $alltotalJam = $alljumlahRequest = $subhasil =  $alljumlahRequest = $alltotalJam = $max = 0;

        for($ii=0;$ii<$mx;$ii++) {
            $nipchild = $bawah[$ii];
            $html .= "
                <table>
                    <tr>
                        <td><b>NIP :</b></td>
                        <td>" . $nipchild . "</td>
                    </tr>
                </table>";
            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Id SPA </b></td>
                <td style='border: 1px solid #dddddd;' ><b>SPA</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Cetak</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Selesai</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kecepatan(Jam)</b></td>
            </tr>
        ";

            $arrJadwal = $this->getJadwalKerja($nipchild);

            $sqlto = "SELECT a.iIdSpa, a.cNip, c.vName, a.dPrinted , a.dFinished FROM ss_spah a
				JOIN ss_spad b ON b.iIdSpad = a.iIdSpa
				LEFT JOIN  employee c on a.cNip = c.cNip
				WHERE b.vPic LIKE '%$nipchild%'
				AND a.dFinished BETWEEN '$perode1' AND LAST_DAY('$perode2')";

            $rows = $this->db_erp_pk->query($sqlto)->result_array();
            $noRow = $total_nilai = $totalJam = 0;
            $totalJam = $subhasil = $jumlahRequest = $noRow = 0;
            $jumlahRequest = count($rows);
            for ($i = 0; $i < $jumlahRequest; $i++) {
                $noRow++;
                $iIdSpa = $rows[$i]['iIdSpa'];
                $cNip = $rows[$i]['cNip'] . ' - ' . $rows[$i]['vName'];

                $start_duration = $rows[$i]['dPrinted'];
                $t_start_duration = strtotime($start_duration);

                $input_date = $rows[$i]['dFinished'];
                $t_input_date = strtotime($input_date);

                $date_start = $this->formatTimestamp($start_duration, 'date');
                $dt_start = strtotime($date_start);
                $day_start = date('N', $dt_start);

                $date_respon = $this->formatTimestamp($input_date, 'date');
                $dt_respon = strtotime($date_respon);
                $day_respon = date('N', $dt_respon);

                $hour_start = $this->formatTimestamp($start_duration, 'hour');
                $ht_start = strtotime($hour_start);

                $hour_respon = $this->formatTimestamp($input_date, 'hour');
                $ht_respon = strtotime($hour_respon);

                $jam_umum_masuk = $arrJadwal['umum']['masuk'];
                $t_jam_umum_masuk = strtotime($jam_umum_masuk);

                $jam_umum_keluar = $arrJadwal['umum']['keluar'];
                $t_jam_umum_keluar = strtotime($jam_umum_keluar);

                $jam_keluar_start = $arrJadwal[$day_start]['keluar'];
                $t_jam_keluar_start = strtotime($jam_keluar_start);

                $calcHour = 0;
                if ($dt_start == $dt_respon) {// direspon di hari yang sama
                    $calcHour = ($ht_respon - $ht_start) / 3600;
                    $totalJam += $calcHour;
                } else { // direspon di hari yang berbeda
                    if ($ht_start > $t_jam_keluar_start) { // start duration > jam keluar pic
                        $t_start_duration = $this->addDay($t_start_duration, 1);// + ke hari esok
                    }
                    $calcHour = $this->hitung_beda_hari($t_start_duration, $t_input_date, $arrJadwal);
                    $calcHour = $calcHour / 3600;
                    $calcHour = ($calcHour < 0) ? 0 : $calcHour;

                    $totalJam += $calcHour;
                }
                if (fmod($noRow, 2) == 0) {
                    $color = 'background-color: #eaedce';
                } else {
                    $color = '';
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>

                <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                    " . $iIdSpa . "</td>
                <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>
                    " . $cNip . "</td>
                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                    " . $start_duration . "</td>
                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                    " . $input_date . "</td>
                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                    " . number_format($calcHour, 2) . " Jam</td>

              </tr>";

            }
            if($jumlahRequest > 0) {
                $subhasil = $totalJam/$jumlahRequest;
                $subhasil = number_format($subhasil,2);
            }else{
                $subhasil = $result = 'No Data';
            }


            $html .= "<br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Kecepatan: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format( $totalJam, 2 )." Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Request: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$jumlahRequest."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $subhasil . " Jam</b></td>
                    </tr>
                </table><br clear='all' /><br />";
            $alljumlahRequest += $jumlahRequest;
            $alltotalJam += $totalJam;
        }
        $html .= "</table>";

        if($alljumlahRequest > 0) {
            $hasil = $alltotalJam/$alljumlahRequest;
            $hasil = number_format($hasil,2);
            $getpoint = $this->getPoint($hasil, $iAspekId);
        }else{
            $hasil = $result = 'No Data';
            $getpoint = $this->getPointEmpty($hasil, $iAspekId);
        }
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Kecepatan: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format( $alltotalJam, 2 )." Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Request: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$alljumlahRequest."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " Jam</b></td>
                    </tr>
                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }
    /*==========================================end of pk DS Supervisor============================================================*/
    /*========================================Start Function QA Spv===========================================================*/
    function hitungQaSpv1($post)
    {
        $iAspekId = $post['_iAspekId'];
        $cNipNya = $post['_cNipNya'];
        $iPkTransId = $post['_iPkTransId'];
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];

        $sql = "SELECT cTahun, iSemester FROM hrd.pk_trans WHERE id='" . $iPkTransId . "'";
        $query = $this->db_erp_pk->query($sql);

        //cari aspek dulu
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";
        $bawah = $this->getInferior($cNipNya);
        array_push($bawah,$cNipNya);
        $mx=count($bawah);
        $alltotalJam = $Alljumlahtask = $subhasil =  $allSelisih = $alltotalJam = $max = 0;

        for($ii=0;$ii<$mx;$ii++) {
            $nipchild = $bawah[$ii];
            $html .= "
                <table>
                    <tr>
                        <td><b>NIP :</b></td>
                        <td>" . $nipchild . "</td>
                    </tr>
                </table>";
            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Target. Finish</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Actual Finish</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Selisih</b></td>

            </tr>
        ";

            $sqlto = "SELECT a.id,a.problem_subject, a.dTargetQa, max(b.input_date)input_date,b.commentType
					FROM hrd.ss_raw_problems a
					JOIN hrd.ss_solution b ON b.id = a.id
						LEFT JOIN hrd.ss_activity_type c ON c.activity_id = a.activity_id
					WHERE a.validateBy = '$nipchild'
						AND b.pic = a.validateBy
					AND b.commentType = 4 AND c.iGrp_activity_id = 3
					AND DATE(a.date_posted) BETWEEN '$perode1' AND LAST_DAY('$perode2')
					GROUP BY a.id,a.problem_subject, a.dTargetQa,b.commentType
					ORDER BY a.date_posted";

            $b = $this->db_erp_pk->query($sqlto)->result_array();
            $no = 0;
            $tot_hasil = $selisih = 0;
            $result = 0;
            if (!empty($b)) {
                foreach ($b as $v) {
                    $no++;
                    $dtarget = (empty($v['dTargetQa'])||$v['dTargetQa']=='0000-00-00')?$v['input_date']:$v['dTargetQa'];
                    $selisih = $this->selisihHari($dtarget, $v['input_date'], $nipchild);

                    $tot_hasil += $selisih;

                    if (fmod($no, 2) == 0) {
                        $color = 'background-color: #eaedce';
                    } else {
                        $color = '';
                    }
                    $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $no . "</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['id'] . "</td>
                            <td style='width:40%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['problem_subject'] . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . date('d-m-Y', strtotime($dtarget)) . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . date('d-m-Y', strtotime($v['input_date'])) . "</td>
                            <td style='width:20%;text-align: center;border: 1px solid #dddddd;'>
                                " . $selisih . " Hari</td>

                          </tr>";

                }
            }
            $subhasil = ($tot_hasil / $no) ;
            $subhasil = number_format($subhasil, 2, '.', '');

            $html .= "<br /> ";

            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Task</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $no . " Project</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $tot_hasil . " Hari</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Rata - rata</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $subhasil . " Hari</b></td>
                    </tr>

                </table><br clear='all' /><br />";

            $Alljumlahtask += $no;
            $allSelisih += $tot_hasil;
        }

        $html .= "</table>";
        $total = ($allSelisih/$Alljumlahtask) ;

        $result = number_format($total, 2, '.', '');

        $getpoint = $this->getPoint($total, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Task</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $Alljumlahtask . " Project</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $allSelisih . " Hari</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Rata - rata</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $result . " Hari</b></td>
                    </tr>

                </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }
    function hitungQaSpv2($post)
    {
        $totalJamAll = 0;
        $totalReqAll = 0;
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
        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";


        $bawah = $this->getInferior($cNipNya);
        array_push($bawah,$cNipNya);
        $mx=count($bawah);
        $alltotalJam = $alljumlahRequest = $subhasil =  $alljumlahRequest = $alltotalJam = $max = 0;

        for($ii=0;$ii<$mx;$ii++) {
            $nipchild = $bawah[$ii];
            $html .= "
                <table>
                    <tr>
                        <td><b>NIP :</b></td>
                        <td>" . $nipchild . "</td>
                    </tr>
                </table>";
            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Assign Time</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Actual Start</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Respond(Hour)</b></td>
            </tr>
        ";

            $arrJadwal = $this->getJadwalKerja($nipchild);

            $sqlto = "SELECT z.id,z.problem_subject, z.date_posted,z.assignTime,
					z.actual_start,z.startDuration,z.input_date,z.commentType,
					z.vType, z.solution_id FROM (
					SELECT a.id,b.solution_id,a.problem_subject, a.date_posted,	Case when a.approveDate is not null then a.approveDate
						When a.assignTime is not null then a.assignTime  else a.date_posted end assignTime,
									a.actual_start,b.startDuration,b.input_date,b.commentType,
									b.vType,iGrp_activity_id
									FROM hrd.ss_raw_problems a
									JOIN hrd.ss_solution b ON b.id = a.id
                                    JOIN hrd.ss_activity_type c on c.activity_id = a.activity_id
									WHERE b.pic = '" . $nipchild . "'
									And a.parent_id = 0
									AND DATE(a.date_posted) BETWEEN '" . $perode1 . "' AND '" . $perode2 . "'
									AND CASE WHEN (SELECT assign FROM hrd.ss_support_type WHERE typeId=a.typeId)='Y'
									    THEN (b.commentType = 3) END
									AND a.activity_id != 22
									AND (b.isDeleted = 0 OR b.isDeleted IS NULL)
                                    AND c.iGrp_activity_id = 20
					UNION
					SELECT a.id,b.solution_id,a.problem_subject, a.date_posted,	Case when a.approveDate is not null then a.approveDate
						When a.assignTime is not null then a.assignTime  else a.date_posted end assignTime,
									a.actual_start,b.startDuration,b.input_date,b.commentType,
									b.vType,c.iGrp_activity_id
									FROM hrd.ss_raw_problems a
									JOIN hrd.ss_solution b ON b.id = a.id
                                    JOIN hrd.ss_activity_type c on c.activity_id = a.activity_id
									WHERE b.pic = '" . $nipchild . "'
									And a.parent_id = 0
									AND DATE(a.date_posted) BETWEEN '" . $perode1 . "' AND '" . $perode2 . "'
									AND b.commentType = 50
									AND a.activity_id != 22
									AND (b.isDeleted = 0 OR b.isDeleted IS NULL)
                                    AND c.iGrp_activity_id = 20
				) AS z
				GROUP BY z.id, z.vType
				ORDER BY z.date_posted,z.solution_id";

            $rows = $this->db_erp_pk->query($sqlto)->result_array();
            $no = 1;
            $size = 0;
            $noRow = 0;
            $totalJam = $subhasil = $jumlahRequest = 0;

            $tmpData = array();
            if (!empty($rows)) {
                $jumlahRequest = count($rows);

                for ($i = 0; $i < $jumlahRequest; $i++) {
                    $noRow++;
                    $id = $rows[$i]['id'];
                    $subject = $rows[$i]['problem_subject'];

                    $date_posted = $rows[$i]['date_posted'];
                    $assignTime = $rows[$i]['assignTime'];
                    $actual_start = $rows[$i]['actual_start'];

                    if ($rows[$i]['vType'] == 'Joblog') {
                        $start_duration = (empty($assignTime) || strtotime($assignTime) < strtotime($date_posted)) ? $date_posted : $assignTime;
                        $t_start_duration = strtotime($start_duration);

                        $input_date = $rows[$i]['startDuration'];
                        $t_input_date = strtotime($input_date);
                    } else {
                        $start_def = (empty($assignTime)) ? $date_posted : $assignTime;
                        $start_duration = (empty($rows[$i]['startDuration'])) ? $start_def : $rows[$i]['startDuration'];
                        $t_start_duration = strtotime($start_duration);

                        $input_date = $rows[$i]['input_date'];
                        $t_input_date = strtotime($input_date);
                    }

                    $date_start = $this->formatTimestamp($start_duration, 'date');
                    $dt_start = strtotime($date_start);
                    $day_start = date('N', $dt_start);

                    $date_respon = $this->formatTimestamp($input_date, 'date');
                    $dt_respon = strtotime($date_respon);
                    $day_respon = date('N', $dt_respon);

                    $hour_start = $this->formatTimestamp($start_duration, 'hour');
                    $ht_start = strtotime($hour_start);

                    $hour_respon = $this->formatTimestamp($input_date, 'hour');
                    $ht_respon = strtotime($hour_respon);

                    $jam_umum_masuk = $arrJadwal['umum']['masuk'];
                    $t_jam_umum_masuk = strtotime($jam_umum_masuk);

                    $jam_umum_keluar = $arrJadwal['umum']['keluar'];
                    $t_jam_umum_keluar = strtotime($jam_umum_keluar);

                    $jam_keluar_start = $arrJadwal[$day_start]['keluar'];
                    $t_jam_keluar_start = strtotime($jam_keluar_start);

                    $calcHour = 0;

                    if ($dt_start == $dt_respon) {// direspon di hari yang sama
                        $calcHour = ($ht_respon - $ht_start) / 3600;
                        $calcHour = ($calcHour < 0) ? 0 : $calcHour;

                        if ($rows[$i]['vType'] == 'Joblog') {
                            $tmpData[$id]['joblog'] = $calcHour;
                        } else {
                            $tmpData[$id]['followup'] = $calcHour;
                        }
                    } else { // direspon di hari yang berbeda

                        $calcHour = $this->hitung_beda_hari($t_start_duration, $t_input_date, $arrJadwal);
                        $calcHour = $calcHour / 3600;
                        $calcHour = ($calcHour < 0) ? 0 : $calcHour;

                        if ($rows[$i]['vType'] == 'Joblog') {
                            $tmpData[$id]['joblog'] = $calcHour;
                        } else {
                            $tmpData[$id]['followup'] = $calcHour;
                        }
                        $dateStart = date('Y-m-d H:i:s', $t_start_duration);
                    }

                    if (fmod($noRow, 2) == 0) {
                        $color = 'background-color: #eaedce';
                    } else {
                        $color = '';
                    }

                    $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $id . "</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $subject . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . $start_duration . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . $input_date . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " . number_format($calcHour, 2) . "</td>
                          </tr>";
                    $no++;
                }
                $jumlahRequest = 0;
                if(count($tmpData)>0) {
                    foreach( $tmpData as $tdKey => $tdVal ) {
                        $x1 = 9999999999;
                        if( isset($tdVal['joblog'])) {
                            $x1 = $tdVal['joblog'];
                        }

                        $x2 = 9999999999;
                        if( isset($tdVal['followup'])) {
                            $x2 = $tdVal['followup'];
                        }

                        if( $x1 < $x2 ) {
                            $totalJam += $x1;
                            $jumlahRequest++;
                        } else if( $x2 < $x1 ) {
                            $totalJam += $x2;
                            $jumlahRequest++;
                        }
                    }
                }
                $html .= "</table>";

                if($jumlahRequest > 0) {
                    $subhasil = $totalJam/$jumlahRequest;
                    $subhasil = number_format($subhasil,2);
                }else{
                    $subhasil = $result = 'No Data';
                }
                $html .= "<br /> ";

                $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Respond: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format( $totalJam, 2 )." Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Request: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$jumlahRequest."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $subhasil . " Jam</b></td>
                    </tr>
                </table><br clear='all' /><br />";

                $alljumlahRequest += $jumlahRequest;
                $alltotalJam += $totalJam;
            }

        }



        if($alljumlahRequest > 0) {
            $hasil = $alltotalJam/$alljumlahRequest;
            $hasil = number_format($hasil,2);
            $getpoint = $this->getPoint($hasil, $iAspekId);
        }else{
            $hasil = $result = 'No Data';
            $getpoint = $this->getPointEmpty($hasil, $iAspekId);
        }
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Respond: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format( $alltotalJam, 2 )." Jam</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Request: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$alljumlahRequest."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " Jam</b></td>
                    </tr>
                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }
    function hitungQaSpv3($post){
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

        $dayCount = 0;
        $hasWeeklyScheduleCount = 0;

        $workDays = $this->getWorkDay($cNipNya);
        $date = $perode1;
        $noRow = 0;
        while ($date < $perode2) {
            $noRow ++;
            while ($this->isOff($cNipNya, $workDays, $date)) {
                $date = date('Y-m-d', strtotime($date.' +1 days'));
            }
            $dayCount++;
            $dUpTo = $this->getScheduleEndDate($cNipNya, $date);

            $q = $this->getScheduleQuery($cNipNya, $date, $dUpTo);

            $data = Array();
            $result = mysql_query($q) or die(mysql_error()."</br>".$q);
            while ($row = mysql_fetch_assoc($result)) {
                array_push($data, $row);
            }

            $rowCount = count($data);
            $hasSchedule = $this->hasSchedule($data, $debug);

            if ($hasSchedule) {
                $hasWeeklyScheduleCount++;

                $html .= "</br>".$noRow.". Weekly Work Schedule: (".$hasWeeklyScheduleCount.")</br>";
                $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <td style='border: 1px solid #dddddd;' ><b>Date</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Duration </b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Schedule Frequency</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>ID</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                    </tr>
                ";
                for ($i = 0; $i < $rowCount; $i++) {
                    if (fmod($i, 2) == 0) {
                        $color = 'background-color: #eaedce';
                    } else {
                        $color = '';
                    }
                    $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                                <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                    " . $data[$i]['dDate'] . "</td>
                                <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                                    " . $data[$i]['yDuration2'] . "</td>
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                    " . $data[$i]['iScheduleFreq'] . "</td>
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                    " . $data[$i]['iSSID'] . "</td>
                                <td style='width:50%;text-align: center;border: 1px solid #dddddd;'>
                                    " . $data[$i]['problem_subject'] . "</td>

                              </tr>";

                }
                $html .= "</table>";
            } else
                $html .= "</br>".$noRow.". No weekly work schedule for date : ".$date."</br>";


            $date = date('Y-m-d', strtotime($date.' +1 days'));
        }

        $hasil = number_format($hasWeeklyScheduleCount / $dayCount * 100);
        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Weekly work schedule for : </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$perode1. " to " .$perode2. "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total normal working days : </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" .number_format($dayCount)."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total days that have weekly work schedule :</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format($hasWeeklyScheduleCount)  . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Percentage having weekly work schedule :</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil  . " %</b></td>
                    </tr>
                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }
    function hitungQaSpv4($post){
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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
            </tr>
        ";

        $commentType = 6;

        $sqlto = "SELECT a.id, b.pic, a.problem_subject, a.dTargetQa,max(b.input_date)input_date
                    FROM hrd.ss_raw_problems a
                    JOIN hrd.ss_solution b ON b.id = a.id
                        WHERE b.commentType = '$commentType'  AND a.id IN (
                        SELECT a1.id
                            FROM hrd.ss_raw_problems a1
                            Left JOIN hrd.ss_solution b1 ON b1.id = a1.id
                            LEFT JOIN hrd.ss_activity_type c1 ON c1.activity_id = a1.activity_id
                            WHERE c1.iGrp_activity_id = 3 AND b1.pic = '$cNipNya'
                            AND DATE(a1.date_posted) BETWEEN '$perode1' AND LAST_DAY('$perode2')

                        GROUP BY a1.id
                                 ORDER BY a1.id)
                    GROUP BY a.id, b.pic,a.problem_subject, a.dTargetQa
                    ORDER BY a.date_posted";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $html .= "<b>Jumlah Task Yang Rework</b>";
        $noRow = 0;
        foreach($rows as $row) {
            if($row['pic']!= $cNipNya){
                continue;
            }
            $noRow++;
            $raw_id = $row['id'];
            $subject = $row['problem_subject'];
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $raw_id . "</td>
                        <td style='width:75%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>

                      </tr>";

        }
        $html .= "</table>";
        $jml_rework = $noRow;

        $html .= "<br /> ";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
            </tr>
        ";
        $commentType = 4;
        $sqlto = "SELECT a.id, b.pic,a.problem_subject, a.dTargetQa, max(b.input_date)input_date
                            FROM hrd.ss_raw_problems a
                            Left JOIN hrd.ss_solution b ON b.id = a.id
                            LEFT JOIN hrd.ss_activity_type c ON c.activity_id = a.activity_id
                            WHERE c.iGrp_activity_id = 3 AND b.pic = '$cNipNya'
                            AND DATE(a.date_posted) BETWEEN '$perode1' AND LAST_DAY('$perode2')
                            AND a.confirm_date IS NOT NULL
                        GROUP BY a.id,b.pic,a.problem_subject, a.dTargetQa
                                 ORDER BY a.date_posted";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $noRow = 0;
        $html .= "<b>Jumlah Task Yang Diverifikasi</b>";
        foreach($rows as $row) {
            if($row['pic']!= $cNipNya){
                continue;
            }
            $noRow++;
            $raw_id = $row['id'];
            $subject = $row['problem_subject'];
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $raw_id . "</td>
                        <td style='width:75%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>

                      </tr>";
        }
        $html .= "</table>";
        $jml_finish = $noRow;

        $hasil = number_format( ($jml_rework / $jml_finish) * 100, 2 );

        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah task yang rework: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jml_rework . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah task yang diverifikasi: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jml_finish . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " %</b></td>
                    </tr>

                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }
    function hitungQaSpv5($post)
    {
        $iAspekId = $post['_iAspekId'];
        $cNipNya = $post['_cNipNya'];
        $iPkTransId = $post['_iPkTransId'];
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];

        $jenis = array(1 => 'UM', 2 => 'Claim');
        $bulan = $this->hitung_bulan($perode1, $perode2);

        $sql = "SELECT cTahun, iSemester FROM hrd.pk_trans WHERE id='" . $iPkTransId . "'";
        $query = $this->db_erp_pk->query($sql);
        $cTahun = $query->row()->cTahun;
        $iSemester = $query->row()->iSemester;

        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";
        $bawah = $this->getInferior($cNipNya);
        array_push($bawah,$cNipNya);
        $mx=count($bawah);

        $Allstandard_wh = $Alltotal_size =0;
        for($ii=0;$ii<$mx;$ii++) {
            $nipchild = $bawah[$ii];
            $html .= "
                <table>
                    <tr>
                        <td><b>NIP :</b></td>
                        <td>" . $nipchild . "</td>
                    </tr>
                </table>";
            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Activity</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Module</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Size</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Minutes of Size</b></td>

            </tr>";

            $sqlto = "SELECT a.id, b.pic,a.problem_subject, a.confirm_date, a.activity_id, c.activity, a.dTargetQa,
          max(b.input_date)input_date,e.moduleId
                    FROM hrd.ss_raw_problems a
                        Left JOIN hrd.ss_solution b ON b.id = a.id
                        LEFT JOIN hrd.ss_activity_type c ON c.activity_id = a.activity_id
                        LEFT JOIN hrd.ss_raw_problems_module e ON a.id = e.parentId
                    wHERE c.iGrp_activity_id = 3 AND b.pic = '$nipchild'
                        AND DATE(a.date_posted) BETWEEN '$perode1' AND LAST_DAY('$perode2')
                        AND a.confirm_date IS NOT NULL
                    GROUP BY a.id, b.pic,a.problem_subject, a.confirm_date, a.activity_id, c.activity, a.dTargetQa,e.moduleId
                    ORDER BY a.id";

            $b = $this->db_erp_pk->query($sqlto)->result_array();
            $no = $result = 0;

            $dayCount = $total_size = $subhasil = $total_minute_size = 0;
            $workDays = $this->getWorkDay($cNipNya);
            //$date = $perode1;
            $date = '2018-11-15';
            while ($date < $perode2) {
                while ($this->isOff($nipchild, $workDays, $date)) {
                    $date = date('Y-m-d', strtotime($date.' +1 days'));
                }
                $dayCount++;
                $date = date('Y-m-d', strtotime($date.' +1 days'));
            }

            if (!empty($b)) {
                foreach ($b as $v) {
                    $no++;

                    $moduleId = $v['moduleId'];
                    $confirm_date = $v['confirm_date'];
                    $activity_id  = $v['activity_id'];
                    $sqlto2 = "SELECT N_SIZE FROM(
                            SELECT ID, N_SIZE,D_START FROM hrd.prv_appmodules WHERE N_SIZE > 0 AND D_START <> '0000-00-00'
                            UNION
                            SELECT ID, N_SIZE,D_START FROM hrd.prv_appmodules_history WHERE N_SIZE > 0 AND D_START <> '0000-00-00'
                            ORDER BY ID	)module
                            WHERE ID = $moduleId AND D_START <= '$confirm_date' ORDER BY D_START ASC LIMIT 1 ";

                    $query = $this->db_erp_pk->query($sqlto2);
                    if($n_size = $query->row()->N_SIZE){
                        $minute_size = ($activity_id == 5) ? ($n_size * 2)  : ($n_size * 2) *0.25;
                    }else{
                        $minute_size = 0;
                    };


                    if (fmod($no, 2) == 0) {
                        $color = 'background-color: #eaedce';
                    } else {
                        $color = '';
                    }
                    $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $no . "</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['id'] . "</td>
                            <td style='width:40%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['problem_subject'] . "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " .$v['activity']. "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " .$moduleId. "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " .$n_size. "</td>
                            <td style='width:20%;text-align: center;border: 1px solid #dddddd;'>
                                " .number_format($minute_size,2). "</td>

                          </tr>";
                    $total_minute_size += $minute_size;

                }
            }
            $standard_wh = ($dayCount*6*60);
            $subhasil = ($total_minute_size / $standard_wh)*100;
            $subhasil = number_format($subhasil, 2, '.', '');

            $html .= "<br /> ";
            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'><b>".$nipchild."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Minutes of Size (A)</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format($total_minute_size, 0). " Minutes</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Working Days</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $dayCount . " Days</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Standard Working Hour (C)</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format($standard_wh,0) . " Minutes</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Results ((A/C)*100)</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $subhasil . " Percent</b></td>
                    </tr>

                </table><br clear='all' /><br />";

                $Allstandard_wh += $standard_wh;
                $Alltotal_size += $total_minute_size;
        }
        $html .= "</table>";

        $total = ($Alltotal_size/$Allstandard_wh)*100 ;
        $result = number_format($total, 2, '.', '');

        $getpoint = $this->getPoint($total, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'><b>All Team</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Minutes of Size (A)</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format($Alltotal_size, 0). " Minutes</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Team Member (B)</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $mx . " </b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Standard Working Hour (C)</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . number_format($Allstandard_wh,0) . " Minutes</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Results (A/(B*C)*100)</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $result . " Percent</b></td>
                    </tr>
                    </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }
    function hitungQaSpv6($post){
        $iAspekId = $post['_iAspekId'];
        $cNipNya  = $post['_cNipNya'];
        //$cNipNya = 'N09484';
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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>".$vAspekName."</td>

                    </tr>
                </table>";

        $bawah = $this->getInferior($cNipNya);
        array_push($bawah,$cNipNya);
        $mx=count($bawah);
        $totalSatis = $totaltask = $subhasil =  $alljumlahRequest = $alltotalJam = $max = 0;

        for($ii=0;$ii<$mx;$ii++) {
            $nipchild = $bawah[$ii];
            $html .= "
                <table>
                    <tr>
                        <td><b>NIP :</b></td>
                        <td>" . $nipchild . "</td>
                    </tr>
                </table>";
            $html .= "<table cellspacing='0' cellpadding='3' width='100%' id='pk_soft_dev' >
            <thead>
            <tr style='border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <th style='border: 1px solid #dddddd;width:25px;' ><b>No</b></th>
                <th style='border: 1px solid #dddddd;width:75px;' ><b>Nomor SSID</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Problem Subject</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Actual Start</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Mark Finish</b></th>
                <th style='border: 1px solid #dddddd;' ><b>Satisfaction</b></th>
            </tr>
            </thead>
        ";
            $html .= '<tbody>';


            $sqlto = "select raw.id,raw.problem_subject, raw.actual_start, raw.tMarkedAsFinished, raw.satisfaction_value
            from hrd.ss_raw_problems raw
            where
            raw.Deleted='No' AND
            #status SS telah finish
            raw.taskStatus='Finish' AND
            #pic nip pengusul dan validateBy bukan nip pengusul
            raw.requestor not in ('" . $nipchild . "') AND raw.validateBy like '%" . $nipchild . "%' AND
            #interval waktu penilaian
            raw.tMarkedAsFinished between '" . $perode1 . "' AND '" . $perode2 . "'
            ORDER BY raw.satisfaction_value DESC";

            $b = $this->db_erp_pk->query($sqlto)->result_array();
            $no = 0;
            $task = $pembilang = $satis = $subhasil = 0;
            if (!empty($b)) {
                foreach ($b as $v) {
                    $no++;
                    if (fmod($no, 2) == 0) {
                        $color = 'background-color: #eaedce';
                    } else {
                        $color = '';
                    }

                    $id = $v['id'];
                    if ($v['tMarkedAsFinished'] != '' or $v['tMarkedAsFinished'] != NULL or $v['tMarkedAsFinished'] != '1970-01-01' or $v['tMarkedAsFinished'] != '0000-00-00') {
                        $mark = date('Y-m-d H:m:s', strtotime($v['tMarkedAsFinished']));
                        if ($mark == '1970-01-01') {
                            $mark = '';
                        }
                    }
                    $actual = '';
                    if ($v['actual_start'] != '' or $v['actual_start'] != NULL or $v['actual_start'] != '1970-01-01' or $v['actual_start'] != '0000-00-00') {
                        $actual = date('Y-m-d H:m:s', strtotime($v['actual_start']));
                        if ($actual == '1970-01-01') {
                            $actual = '';
                        }
                    }

                    $dlink = explode("/", base_url());
                    $dlink[3] = "ss";
                    $linkss = implode("/", $dlink);
                    $html .= '<tr style="border: 1px solid #dddddd; border-collapse: collapse;' . $color . '">
                            <td style="text-align: center;border: 1px solid #dddddd;width:25px;" >' . $no . '</td>

                            <td style="text-align: left;border: 1px solid #dddddd;width:75px;">
                                <a href="javascript:void(0);" title="' . $v['problem_subject'] . '" onclick="window.open(\'' . $linkss . 'index.php/rawproblems/detail/' . $v['id'] . '\', \'_blank\',
                        \'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=0,screeny=0,top=84,left=283\');">' . $v['id'] . '</a></td>';
                    $html .= '<td style="text-align: left;border: 1px solid #dddddd;">' . $v['problem_subject'] . '</td>';
                    $html .= '<td style="text-align: center;border: 1px solid #dddddd;">' . $actual . '</td>';
                    $html .= '<td style="text-align: center;border: 1px solid #dddddd;">' . $mark . '</td>';
                    $html .= '<td style="text-align: center;border: 1px solid #dddddd;">' . $v['satisfaction_value'] . '</td>';
                    $html .= '</tr>';
                    $satis += $v['satisfaction_value'];
                    $task = $no;

                }
            }

            $subhasil = ($satis / $task) ;
            $subhasil = number_format($subhasil, 2, '.', '');

            $html .= "<br /> ";
            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Satisfaction ".$nipchild.": </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format( $satis, 0)."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Task: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$task."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $subhasil . "</b></td>
                    </tr>
                </table><br clear='all' /><br />";
            $totalSatis += $satis;
            $totaltask += $no;
        }
        $html.='</tbody>';
        $html .="</table>";

        $total = ($totalSatis/$totaltask) ;

        $result = number_format($total, 2, '.', '');

        $getpoint = $this->getPoint($total, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Satisfaction: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format( $totalSatis )."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Task: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$totaltask."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $result . "</b></td>
                    </tr>
                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }
    function hitungQaSpv7($post)
    {
        $iAspekId = $post['_iAspekId'];
        $cNipNya = $post['_cNipNya'];
        $iPkTransId = $post['_iPkTransId'];
        $dPeriode1 = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $perode1 = $x_prd1['2'] . "-" . $x_prd1['1'] . "-" . $x_prd1['0'];

        $dPeriode2 = $post['_dPeriode2'];
        $x_prd2 = explode("-", $dPeriode2);
        $perode2 = $x_prd2['2'] . "-" . $x_prd2['1'] . "-" . $x_prd2['0'];

        $jenis = array(1 => 'UM', 2 => 'Claim');
        $bulan = $this->hitung_bulan($perode1, $perode2);

        $sql = "SELECT cTahun, iSemester FROM hrd.pk_trans WHERE id='" . $iPkTransId . "'";
        $query = $this->db_erp_pk->query($sql);
        $cTahun = $query->row()->cTahun;
        $iSemester = $query->row()->iSemester;

        $sql = "SELECT vAspekName FROM hrd.pk_aspek WHERE id='" . $iAspekId . "'";
        $query = $this->db_erp_pk->query($sql);
        $vAspekName = $query->row()->vAspekName;

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";
        $bawah = $this->getInferior($cNipNya);
        array_push($bawah,$cNipNya);
        $mx=count($bawah);
        $totalBugs=$totalModules=0;
        for($ii=0;$ii<$mx;$ii++) {
            $nipchild = $bawah[$ii];
            $html .= "
                <table>
                    <tr>
                        <td><b>NIP :</b></td>
                        <td>" . $nipchild . "</td>
                    </tr>
                </table>";
            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Activity</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Module</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Version</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Launch</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Bugs</b></td>

            </tr>";

            $sqlto = "SELECT a.id, b.pic,a.problem_subject,a.activity_id, h.activity, a.confirm_date,a.date_posted,
                    a.dTargetQa, max(b.input_date)input_date,e.moduleId,d.I_APP_ID,f.iSvnId,g.vURL
                        FROM hrd.ss_raw_problems a
                            Left JOIN hrd.ss_solution b ON b.id = a.id
                            LEFT JOIN hrd.ss_activity_type c ON c.activity_id = a.activity_id
                            LEFT JOIN hrd.ss_raw_problems_module e ON a.id = e.parentId
                            LEFT JOIN hrd.prv_appmodules d ON d.ID = e.moduleId
                            LEFT JOIN hrd.prv_application f ON f.I_APP_ID = d.I_APP_ID
                            LEFT JOIN hrd.svn_info g ON g.iSvnId = f.iSvnId
                            LEFT JOIN hrd.ss_activity_type h ON h.activity_id = a.activity_id
                        wHERE c.iGrp_activity_id = 3 AND b.pic = '$nipchild'
                            AND DATE(a.date_posted) BETWEEN '$perode1' AND LAST_DAY('$perode2')
                            AND a.confirm_date IS NOT NULL 	AND g.vURL IS NOT null
                    GROUP BY a.id, b.pic,a.problem_subject, a.activity_id, a.confirm_date,a.date_posted, h.activity,a.dTargetQa,e.moduleId, d.I_APP_ID,f.iSvnId,g.vURL
                    ORDER BY e.moduleId";

            $b = $this->db_erp_pk->query($sqlto)->result_array();
            $no = $result = $bugs = $subhasil= 0;


            if (!empty($b)) {
                foreach ($b as $v) {
                    $tLaunch = $vVersion = "";
                    $confirm_date = $v['confirm_date'];
                    $date_posted = $v['date_posted'];
                    $iSvnId =  $v['iSvnId'];
                    $moduleId =  $v['moduleId'];
                    $sqlto2 = "SELECT a.iSvnId, a.vVersion, a.tLaunch FROM hrd.svn_commit_header a
                                WHERE a.iSvnId = '$iSvnId' AND tLaunch > '$confirm_date'
                                GROUP BY a.iSvnId, a.vVersion, a.tLaunch
                                ORDER BY a.tLaunch ASC LIMIT 1";

                    if($query = $this->db_erp_pk->query($sqlto2)){
                        $tLaunch = $query->row()->tLaunch;
                        $vVersion = $query->row()->vVersion;
                    };

                    if(empty($vVersion)){
                        continue;
                    }
                    if($v['activity_id']==3){
                        $bugs++;
                        $rework = 'Y';
                    }else{
                        $rework = '';
                    }


                    $no++;
                    if (fmod($no, 2) == 0) {
                        $color = 'background-color: #eaedce';
                    } else {
                        $color = '';
                    }
                    $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $no . "</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['id'] . "</td>
                            <td style='width:40%;text-align: left;border: 1px solid #dddddd;'>
                                " . $v['problem_subject'] . "</td>
                            <td style='width:20%;text-align: center;border: 1px solid #dddddd;'>
                                " .$v['activity']. "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " .$moduleId. "</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                " .$vVersion. "</td>
                            <td style='width:20%;text-align: center;border: 1px solid #dddddd;'>
                                " .$tLaunch. "</td>
                            <td style='width:20%;text-align: center;border: 1px solid #dddddd;'>
                                " .$rework. "</td>
                          </tr>";

                }
            }

            $subhasil = ($bugs/$no)*100;
            $subhasil = number_format($subhasil, 2, '.', '');

            $html .= "<br /> ";
            $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'><b>".$nipchild."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Module QC Passed</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $no. "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Module QC Passed(Bugs)</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $bugs . " </b></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Results</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $subhasil . " Percent</b></td>
                    </tr>

                </table><br clear='all' /><br />";
            $totalBugs += $bugs;
            $totalModules += $no;

        }
        $html .= "</table>";

        $total = ($totalBugs/$totalModules)*100 ;
        $result = number_format($total, 2, '.', '');

        $getpoint = $this->getPoint($total, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'><b>All Team</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Module QC Passed</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $totalModules. "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Module QC Passed(Bugs)</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $totalBugs . " </b></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Results</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $result . " Percent</b></td>
                    </tr>
                    </table>";
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }
    function hitungQaSpv8($post){
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

        $html = "
                <table>
                    <tr>
                        <td><b>Point Untuk Aspek :</b></td>
                        <td>" . $vAspekName . "</td>

                    </tr>
                </table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
            </tr>
        ";

        $commentType = 5;
        $sqlto = "SELECT a.id,a.problem_subject, a.dTargetQa,max(b.input_date)input_date,b.commentType
                            FROM hrd.ss_raw_problems a
                            JOIN hrd.ss_solution b ON b.id = a.id
                            LEFT JOIN hrd.ss_activity_type c ON c.activity_id = a.activity_id
                                WHERE a.id IN(
                                  SELECT a1.id
                                      FROM hrd.ss_raw_problems a1
                                      Left JOIN hrd.ss_solution b1 ON b1.id = a1.id
                                      LEFT JOIN hrd.ss_activity_type c1 ON c1.activity_id = a1.activity_id
                                      WHERE c1.iGrp_activity_id = 3 AND b1.pic = '$cNipNya'
                                      AND DATE(a1.date_posted) BETWEEN '$perode1' AND LAST_DAY('$perode2')
                                      AND a1.confirm_date IS NOT NULL
                                  GROUP BY a1.id
                                           ORDER BY a1.id)AND  b.commentType = $commentType  AND b.pic = a.requestor
                            GROUP BY a.id,a.problem_subject, a.dTargetQa,b.commentType
                            ORDER BY a.date_posted";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $html .= "<b>Jumlah Task Yang Rework</b>";
        $noRow = 0;
        foreach($rows as $row) {
            $noRow++;
            $raw_id = $row['id'];
            $subject = $row['problem_subject'];
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $raw_id . "</td>
                        <td style='width:75%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>

                      </tr>";

        }
        $html .= "</table>";
        $jml_rework = $noRow;

        $html .= "<br /> ";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>SSiD </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Problem Subject</b></td>
            </tr>
        ";
        $commentType = 4;
        $sqlto = "SELECT a.id, b.pic,a.problem_subject, a.dTargetQa, max(b.input_date)input_date
                            FROM hrd.ss_raw_problems a
                            Left JOIN hrd.ss_solution b ON b.id = a.id
                            LEFT JOIN hrd.ss_activity_type c ON c.activity_id = a.activity_id
                            WHERE c.iGrp_activity_id = 3 AND b.pic = '$cNipNya'
                            AND DATE(a.date_posted) BETWEEN '$perode1' AND LAST_DAY('$perode2')
                            AND a.confirm_date IS NOT NULL
                        GROUP BY a.id,b.pic,a.problem_subject, a.dTargetQa
                                 ORDER BY a.date_posted";

        $rows = $this->db_erp_pk->query($sqlto)->result_array();
        $noRow = 0;
        $html .= "<b>Jumlah Task Yang Diverifikasi</b>";
        foreach($rows as $row) {
            if($row['pic']!= $cNipNya){
                continue;
            }
            $noRow++;
            $raw_id = $row['id'];
            $subject = $row['problem_subject'];
            if (fmod($noRow, 2) == 0) {
                $color = 'background-color: #eaedce';
            } else {
                $color = '';
            }
            $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;" . $color . "'>
                        <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >" . $noRow . "</td>
                        <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                            " . $raw_id . "</td>
                        <td style='width:75%;text-align: left;border: 1px solid #dddddd;'>
                            " . $subject . "</td>

                      </tr>";
        }
        $html .= "</table>";
        $jml_finish = $noRow;

        $hasil = number_format( ($jml_rework / $jml_finish) * 100, 2 );

        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<br /> ";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah task yang rework: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jml_rework . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah task yang diverifikasi: </td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $jml_finish . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Result</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $hasil . " %</b></td>
                    </tr>

                </table>";
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }
    //====================================================end of QA Supervisor==================================================================
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



    private function getDateTimeInterval($dt1, $dt2) {
       $dt1 = new DateTime($dt1);
       $dt2 = new DateTime($dt2);
       return $dt1->diff($dt2);
    }    

    private function isProject($iSSID) {
        $q = "SELECT r.parent_id, if (r.support_type IN (25,29), 1, 0) AS isProject
              FROM hrd.ss_raw_problems r
              WHERE r.id=$iSSID";
        $r = mysql_query($q) or die(mysql_error()."</br>$q");
        $fld = mysql_fetch_assoc($r);
        if ($fld['isProject'])
            return true;
        else {
            $parentId = $fld['parent_id'];
            if ($parentId) {
                return $this->isProject($parentId);
            }
            else
                return false;
        }
    }  
    private function convertToWeekday($nip, $datetime) {
        $workDay = $this->getWorkDay($nip);
        $dayNumber = date("w", strtotime(substr($datetime,0,10)));
        $time = substr($datetime,11,8);
        $convertedDatetime = $datetime;
        if (($workDay==6 && $dayNumber==6 && $time>"12:00:00") || 
            ($dayNumber>0 && $dayNumber<6 && $time>"17:00:00")) {
            $convertedDatetime = date('Y-m-d', strtotime(substr($convertedDatetime,0,10).' +1 days'))." 08:00:00";
        }
        while ($this->isOff($nip, $workDay, substr($convertedDatetime,0,10))) {
            $convertedDatetime = date('Y-m-d', strtotime(substr($convertedDatetime,0,10).' +1 days'))." 08:00:00";
        }
        return $convertedDatetime;
    }        
   private function getDuration($nip, $dt1, $dt2) {

        $workDay = $this->getWorkDay($nip);
        if (substr($dt2,11,8)>"13:00:00") {
            $dt2 = date('Y-m-d H:i:s', strtotime($dt2.' -1 hours'));
        }
        if (substr($dt1,0,10)==substr($dt2,0,10)) {
            if ($dt2<$dt1) $dt2 = date('Y-m-d H:i:s', strtotime($dt2.' +1 hours'));
            $interval = $this->getDateTimeInterval($dt1, $dt2);
        } else {
            $dt = $dt1;
            $interval = $this->getDateTimeInterval("00:00", "00:00");
            while (substr($dt,0,10)<substr($dt2,0,10)) {
                $dtUpTo = substr($dt,0,10)." ".
                          (date("w", strtotime(substr($dt,0,10)))==6 ? 
                            "12:00" : 
                            (substr($dt,11,8)>"12:00:00" ? "17:00" : "16:00")
                          );
                $newInterval = $this->getDateTimeInterval($dt, $dtUpTo);
                $interval = $this->addDateTimeIntervalByDateInterval($interval, $newInterval);
                $dt = date('Y-m-d', strtotime(substr($dt,0,10).' +1 days'))." 08:00:00";
                while ($this->isOff($nip, $workDay, substr($dt,0,10))) {
                    $dt = date('Y-m-d', strtotime(substr($dt,0,10).' +1 days'))." 08:00:00";    
                }
            }
            if ($dt2>$dt) {
                $lastDayInterval = $this->getDateTimeInterval($dt, $dt2);
                $interval = $this->addDateTimeIntervalByDateInterval($interval, $lastDayInterval);
            }
        }
        return $interval;
    }       
    private function addDateTimeIntervalByDateInterval($interval1, $interval2) {
        $dt1 = new DateTime('00:00');
        $dt2 = clone $dt1;
        $dt1->add($interval1);
        $dt1->add($interval2);
        return $dt2->diff($dt1);
    }    

    private function hDateTimeInterval($interval) {
        $seconds = $this->DateTimeIntervalToSeconds($interval);
        return $this->secondsToHDateInterval($seconds);
    }

    private function secondsToHDateInterval($seconds) {
        $days = strval(floor($seconds/(8*3600)));
        $timeRemainder = $seconds % (8*3600);
        $hours = strval(floor($timeRemainder/3600));
        $timeRemainder = $timeRemainder % 3600;
        $minutes = strval(floor($timeRemainder/60));
        $seconds = strval($timeRemainder % 60);
        return $days."d ".$hours."h ".$minutes."m ".$seconds."s";
    }

    private function DateTimeIntervalToSeconds($interval) {
        return $interval->days*86400+$interval->h*3600+$interval->i*60+$interval->s;
    }
    function ceilHour($toHour='08:00:00',$goHour = '00:00:00') {
        $goHour_ = strtotime($goHour);
        $toHour_ = strtotime($toHour);

        if($goHour_ < $toHour_) {
            return $toHour_;
        }else {
            return $goHour_;
        }
    }
    function floorHour($toHour='17:00:00',$goHour = '18:00:00') {
        $goHour_ = strtotime($goHour);
        $toHour_ = strtotime($toHour);

        if($toHour_ < $goHour_) {
            return $toHour_;
        }else {
            return $goHour_;
        }
    }

}
?>