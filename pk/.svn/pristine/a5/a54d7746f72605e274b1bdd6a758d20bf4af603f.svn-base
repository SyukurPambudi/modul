<?php

class lib_pk_pd2_spv
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


    //Start Here 7-2-3  
    function spv_pd2_02 ($post){
        $iAspekId = $post['_iAspekId'];
        $cNipNya  = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1  = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $c = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];
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
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>No. UPB</b></td>
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>Nama Usulan</b></td>
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>Team</b></td>
                <td style='border: 1px solid #dddddd;' colspan='2' ><b>Tanggal Stabilita</b></td>   
                <td style='border: 1px solid #dddddd;' colspan='2' ><b>Status Stabilita</b></td>   
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>Tanggal Approve</b></td> 
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>Grup Produk</b></td>     
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>Selisih Hari</b></td> 
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>Selisih Bulan<br>(Hari / 22)</b></td> 
            </tr>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>Lab</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Pilot</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Lab</b></td>   
                <td style='border: 1px solid #dddddd;' ><b>Pilot</b></td> 
            </tr>
        ";

        $sql1 ="SELECT sta.*,u.vupb_nomor, t.vteam, g.vNama_Group, u.iGroup_produk, u.vupb_nama, ABS((DATEDIFF(sta.tapppd, sta.tdate) / 22)) as selisih, ABS(DATEDIFF(sta.tapppd, sta.tdate)) AS hari FROM (
                    SELECT p.ifor_id, p.tapppd, f.iupb_id, 'Stabilita Pilot' as proses, p.tdate,IF (p.isucced = 2, 'MS', 'TMS') AS stat_pilot, IF (s.isucced = 2, 'MS', 'TMS') AS stat_lab, p.tapppd AS tsta_pilot, s.tapppd AS tsta_lab
                        FROM plc2.plc2_upb_stabilita_pilot p 
                        JOIN plc2.plc2_upb_formula f ON p.ifor_id = f.ifor_id
                        JOIN plc2.plc2_upb_stabilita s ON p.ifor_id = s.ifor_id
                        WHERE p.tapppd IS NOT NULL AND p.isucced IN (1,2) AND p.ldeleted = 0 AND f.ldeleted = 0 AND s.ldeleted = 0
                    UNION
                    SELECT s.ifor_id, s.tapppd, f.iupb_id, 'Stabilita Lab' as proses, s.tdate,'-' AS stat_pilot, IF (s.isucced = 2, 'MS', 'TMS') AS stat_lab, '-' AS tsta_pilot, s.tapppd AS tsta_lab
                        FROM plc2.plc2_upb_stabilita s 
                        JOIN plc2.plc2_upb_formula f ON s.ifor_id = f.ifor_id
                        WHERE s.tapppd IS NOT NULL AND s.isucced IN (1,2) AND s.ldeleted = 0 AND f.ldeleted = 0
                            AND (SELECT COUNT(*) FROM plc2.plc2_upb_stabilita_pilot WHERE ifor_id = f.ifor_id AND iupb_id = f.iupb_id AND tapppd IS NOT NULL) = 0
                    ORDER BY tapppd DESC, iupb_id ASC
                ) AS sta
                    JOIN plc2.plc2_upb u ON sta.iupb_id = u.iupb_id
                    JOIN plc2.plc2_upb_team t ON u.iteampd_id = t.iteam_id
                    JOIN plc2.master_group_produk g ON u.iGroup_produk = g.imaster_group_produk
                    WHERE u.iteampd_id = 3 AND u.ldeleted = 0 AND t.ldeleted = 0 AND g.lDeleted = 0
                        AND DATE(sta.tapppd) BETWEEN ? AND ?";
        $arrPeriode = array($perode1,$perode2);
        $c = $this->db_erp_pk->query($sql1.' AND ABS((DATEDIFF(sta.tapppd, sta.tdate) / 22)) <= 5 ORDER BY u.iGroup_produk ASC, sta.tapppd DESC', $arrPeriode)->result_array();
        $no = 1;
        if(!empty($c)){
            $sama = 0;
            $stbl = 1;
            for ($i=count($c)-1; $i >= 0; $i--) { 
                if ($c[$i]['iGroup_produk'] == $sama){
                    $stbl += 1;
                    $c[$i]['grp_sama'] = ($i==0)?$stbl:0;
                }else{
                    if ( ($i+1) <= count($c)-1 ){
                        $c[$i+1]['grp_sama'] = $stbl;
                    }
                    $c[$i]['grp_sama'] = ($i==0)?$stbl:0;
                    $stbl = 1;
                }
                $sama = $c[$i]['iGroup_produk'];
            }
            foreach ($c as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }
                
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;' >".$no."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$v['vupb_nomor']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$v['vupb_nama']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$v['vteam']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$v['tsta_lab']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$v['tsta_pilot']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$v['stat_lab']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$v['stat_pilot']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$v['tdate']."</td> ";
                if ($v['grp_sama'] >= 1){
                    $html .= "<td rowspan='".$v['grp_sama']."' style='text-align: center;border: 1px solid #dddddd;'>".$v['vNama_Group']."</td>"; 
                }
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".number_format($v['hari'])."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".number_format($v['selisih'],2)."</td>";
                $html .= "</tr>"; 
                $no++;
            }
        } 
        $html .="</table>";

        $html .= "<br><table>
                    <tr>
                        <td><b>Jumlah Formulasi dan stabilitas produk baru yang selesai > 5 bulan  :</b></td>
                        
                    </tr>
                </table>";
        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>No. UPB</b></td>
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>Nama Usulan</b></td>
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>Team</b></td>
                <td style='border: 1px solid #dddddd;' colspan='2' ><b>Tanggal Stabilita</b></td>   
                <td style='border: 1px solid #dddddd;' colspan='2' ><b>Status Stabilita</b></td>   
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>Tanggal Approve</b></td> 
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>Grup Produk</b></td>     
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>Selisih Hari</b></td> 
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>Selisih Bulan<br>(Hari / 22)</b></td> 
            </tr>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>Lab</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Pilot</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Lab</b></td>   
                <td style='border: 1px solid #dddddd;' ><b>Pilot</b></td> 
            </tr>
        ";
        $d = $this->db_erp_pk->query($sql1.' AND ABS((DATEDIFF(sta.tapppd, sta.tdate) / 22)) > 5', $arrPeriode)->result_array();
        $n = 1;
        if(!empty($d)){
            $sama = 0;
            $stbl = 1;
            for ($i=count($d)-1; $i >= 0; $i--) { 
                if ($d[$i]['iGroup_produk'] == $sama){
                    $stbl += 1;
                    $d[$i]['grp_sama'] = ($i==0)?$stbl:0;
                }else{
                    if ( ($i+1) <= count($d)-1 ){
                        $d[$i+1]['grp_sama'] = $stbl;
                    }
                    $d[$i]['grp_sama'] = ($i==0)?$stbl:0;
                    $stbl = 1;
                }
                $sama = $d[$i]['iGroup_produk'];
            }
            foreach ($d as $w) {
                if (fmod($n,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }
                
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;' >".$n."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$w['vupb_nomor']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$w['vupb_nama']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$w['vteam']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$w['tsta_lab']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$w['tsta_pilot']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$w['stat_lab']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$w['stat_pilot']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$w['tdate']."</td> ";
                if ($w['grp_sama'] >= 1){
                    $html .= "<td rowspan='".$w['grp_sama']."' style='text-align: center;border: 1px solid #dddddd;'>".$w['vNama_Group']."</td>"; 
                }
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".number_format($w['hari'])."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".number_format($w['selisih'],2)."</td>";
                $html .= "</tr>"; 
                $n++;
            }
        } 
        $html .="</table>";


        $sql2 = $sql1." AND ABS((DATEDIFF(sta.tapppd, sta.tdate) / 22)) <= 5 GROUP BY u.iGroup_produk";
        
        $result     = number_format($this->db_erp_pk->query($sql2, $arrPeriode)->num_rows());
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>".$vAspekName."</td>
                  
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result." Group Produk</b></td>
                    </tr>
                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }


    function spv_pd2_03 ($post){
        $iAspekId = $post['_iAspekId'];
        $cNipNya  = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1  = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $c = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];
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
                <td style='border: 1px solid #dddddd;' ><b>No. UPB</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama Usulan</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Team</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Approve Setting<br>Prioritas</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Approve<br>Spesifikasi FG</b></td>  
                <td style='border: 1px solid #dddddd;' ><b>Approve<br>SOI BB</b></td>   
                <td style='border: 1px solid #dddddd;' ><b>Approve<br>SOI FG</b></td>   
                <td style='border: 1px solid #dddddd;' ><b>Total</b></td>    
                <td style='border: 1px solid #dddddd;' ><b>Rata-Rata<br>(Total / 3)</b></td>  
            </tr>
        ";

        $sql1 ="SELECT f.ispekfg_id, bb.isoibb_id, pr.iprioritas_id, prd.iprioritasdet_id, t.vteam,
                        u.iupb_id, u.vupb_nomor, u.vupb_nama, pr.tappdir,
                        (SELECT(IF(pr.tappdir IS NOT NULL AND pr.tappdir <> '0000-00-00 00:00:00' AND pr.iappdir = 1,pr.tappdir,pr.tappbusdev))) AS app_prio,
                        f.tapp_pd, bb.tapp_qc, fg.dapppd,
                        (SELECT GREATEST(DATE(f.tapp_pd), DATE(bb.tapp_qc),DATE(fg.dapppd))) AS last_date
                    FROM plc2.plc2_upb u
                    JOIN plc2.plc2_upb_spesifikasi_fg f ON u.iupb_id = f.iupb_id
                    JOIN plc2.plc2_upb_soi_bahanbaku bb ON u.iupb_id = bb.iupb_id
                    JOIN plc2.plc2_upb_soi_fg fg ON u.iupb_id = fg.iupb_id
                    JOIN plc2.plc2_upb_prioritas_detail prd ON u.iupb_id = prd.iupb_id
                    JOIN plc2.plc2_upb_prioritas pr ON prd.iprioritas_id = pr.iprioritas_id
                    JOIN plc2.plc2_upb_team t ON u.iteampd_id = t.iteam_id
                    WHERE u.iteampd_id = 3 AND f.tapp_pd IS NOT NULL 
                        AND bb.tapp_qc IS NOT NULL AND fg.dapppd IS NOT NULL
                        AND IF (pr.tappdir IS NOT NULL AND pr.tappdir <> '0000-00-00 00:00:00' AND pr.iappdir = 1, 
                                        pr.tappdir BETWEEN ? AND ? AND pr.iappdir = 1, 
                                        pr.tappbusdev BETWEEN ? AND ? AND pr.iappbusdev = 2)
                        AND u.ldeleted = 0 AND f.ldeleted = 0 AND bb.ldeleted = 0 
                        AND fg.ldeleted = 0 AND prd.ldeleted = 0 AND pr.ldeleted = 0 AND t.ldeleted = 0
                        AND f.tapp_pd IS NOT NULL AND f.tapp_pd <> '0000-00-00 00:00:00'
                        AND bb.tapp_qc IS NOT NULL AND bb.tapp_qc <> '0000-00-00 00:00:00'
                        AND fg.dapppd IS NOT NULL AND fg.dapppd <> '0000-00-00 00:00:00'
                    ORDER BY pr.tappdir DESC, u.vupb_nama ASC";
        $arrPeriode = array($perode1,$perode2,$perode1,$perode2);
        $c = $this->db_erp_pk->query($sql1, $arrPeriode)->result_array();
        $no = 1;
        $sum = 0;
        if(!empty($c)){
            foreach ($c as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }
                $sql3 = "SELECT ABS(DATEDIFF(DATE(?),DATE(?))) AS total";
                $sel = $this->db_erp_pk->query($sql3, array($v['app_prio'],$v['last_date']))->row_array();
                $tot = intval($sel['total']);
                $rata2 = $tot / 3;
                
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$no."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$v['vupb_nomor']."</td>"; 
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$v['vupb_nama']."</td> ";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$v['vteam']."</td> ";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'><b>".$v['app_prio']."</b></td> ";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".(($v['last_date']==date('Y-m-d',strtotime($v['tapp_pd'])))?"<b>".$v['tapp_pd']."</b>":$v['tapp_pd'])."</td>"; 
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".(($v['last_date']==date('Y-m-d',strtotime($v['tapp_qc'])))?"<b>".$v['tapp_qc']."</b>":$v['tapp_qc'])."</td>"; 
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".(($v['last_date']==date('Y-m-d',strtotime($v['dapppd'])))?"<b>".$v['dapppd']."</b>":$v['dapppd'])."</td>"; 
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".number_format($tot)." Hari</td> ";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".number_format($rata2,2)." Hari</td> ";
                $html .= "</tr>"; 
                $sum += $rata2;
                $no++;
            }
            $html .="<tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'> 
                        <td style='border: 1px solid #dddddd;' colspan='9' ><b>Total</b></td>    
                        <td style='border: 1px solid #dddddd;' ><b>".number_format($sum,2)." Hari</b></td>  
                    </tr>";
        } 
        $html .="</table>";
        
        $result     = number_format($sum / 22,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>".$vAspekName."</td>
                  
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".number_format($sum,2)." Hari / 22</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total</td>
                  
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result." Bulan</b></td>
                    </tr>
                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }
 

    function spv_pd2_07($post)    {
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
                        <td><b>Jumlah UPB yang memiliki tgl approval produksi Pilot</b></td>
                    </tr>
                    </table>";
        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Nomor UPB</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Nama UPB</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Kode Produk</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Nama Produk</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Batch Ke</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Tgl Approve Produksi Pilot</b></td> 
                </tr>
            ";
 
        //Batch Lebih > 3
        $sqlbb= " SELECT distinct(u.vupb_nomor), u.vupb_nama, u.iupb_id,
                      i.c_iteno,i.c_itnam, 
                        (select COUNT(DISTINCT(pm.c_panumb1)) 
                         from purchase.pamsh pm where pm.c_iteno=p.c_iteno 
                          AND pm.lDeleted =0) 
                          as batchke, pp.tapppd_pp 
                    FROM plc2.plc2_upb_formula p 
                        JOIN plc2.plc2_upb_prodpilot pp ON p.ifor_id = pp.ifor_id 
                        JOIN plc2.plc2_upb u ON u.iupb_id = p.iupb_id 
                        JOIN sales.itemas i ON i.c_iteno = p.c_iteno 
                    WHERE u.ldeleted = 0 AND p.ldeleted = 0 
                        AND pp.ldeleted =0 AND u.iteampd_id = 3 
                        AND pp.iapppd_pp = 2 AND pp.tapppd_pp >= '".$perode1."' 
                        AND pp.tapppd_pp <= '".$perode2."' 
                        AND ( select COUNT(DISTINCT(pm.c_panumb1)) 
                            from purchase.pamsh pm where pm.c_iteno=p.c_iteno 
                            AND pm.lDeleted =0 ) > 3";  
        $batch = $this->db_erp_pk->query($sqlbb)->result_array(); 
        $x = 0 ;  
        $upb_simp = ''; 
        foreach ($batch as $b) {  
            if($x==0){
                $upb_simp .= $b['iupb_id'];
            }else{
                $upb_simp .= ','.$b['iupb_id'];
            }
             $x++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='border: 1px solid #dddddd;' >".$x."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['vupb_nomor']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['vupb_nama']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['c_iteno']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['c_itnam']."</td> 
                        <td style='border: 1px solid #dddddd;' >".$b['batchke']."</td> 
                        <td style='border: 1px solid #dddddd;' >".$b['tapppd_pp']."</td>   
                      </tr>";   
        } 
        $html .= "</table><br><hr>";
    
        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                    <tr>
                        <td><b>Jumlah UPB  yang memiliki Tgl Estimasi Launching</b></td>
                    </tr>
                    </table>";
        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Nomor UPB</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Nama UPB</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Status</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Tanggal Launching</b></td> 
                    </tr>
            "; 

        //Launcing
        $sql2 = "SELECT distinct(pu.vupb_nomor), pu.vupb_nama, pk.tmemo_date,pk.istatus_launching FROM plc2.plc2_upb_bahan_kemas pk 
                        JOIN plc2.plc2_upb pu on pu.iupb_id = pk.iupb_id 
                        WHERE pu.ldeleted = 0 
                        AND pk.ldeleted = 0 
                        AND pu.iteampd_id = 3
                        AND pk.istatus_launching = 2
                        AND pk.iappdr_launch = 2
                        AND pk.iupb_id in (".$upb_simp.") 
                        AND pk.tmemo_date >= '".$perode1."' AND pk.tmemo_date <= '".$perode2."' 
                        ";
         
        $lauch = $this->db_erp_pk->query($sql2)->result_array(); 
        $y = 0 ; 
        foreach ($lauch as $t) {  
             $y++;
             $sts = "Batal Launching";
             if($t['istatus_launching']==2){
                $sts = "Launching";
             }
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='border: 1px solid #dddddd;' >".$y."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['vupb_nomor']."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['vupb_nama']."</td>
                        <td style='border: 1px solid #dddddd;' >".$sts."</td> 
                        <td style='border: 1px solid #dddddd;' >".$t['tmemo_date']."</td> 
                      </tr>";   
        }  
        $html .= "</table>"; 
        $html .= "<br /> ";  

        // if($y==0){
        //     $hasil = 0;
        // }else{
        //     $hasil = ($x/$y) * 100;
        // }
        if($x==0){
            $hasil = 0;
        }else{
            $hasil = ($y/$x) * 100;
        }
        $result     = number_format($hasil,2);
        $getpoint = $this->getPoint($result, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 800px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB yang memiliki tgl approval produksi Pilot (y)</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$x."</td>
                    </tr>  

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB  yang memiliki Tgl Estimasi Launching (x)</td> 
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$y."</td>
                    </tr>  
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah produk yang ada tanggal estimasi launching dibandingkan dengan jumlah produk yang ada tanggal approve produksi pilot PD Manager = X/Y *100%</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $result . " %</b></td>
                    </tr> 
                </table>";      
        
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }
    /*function spv_pd2_07($post){
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
                        <td><b>Jumlah UPB yang memiliki tgl approval produksi Pilot</b></td>
                    </tr>
                    </table>";
        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Nomor UPB</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Nama UPB</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Kode Produk</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Nama Produk</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Batch Ke</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Tgl Approve Produksi Pilot</b></td> 
                </tr>
            ";
 
        //Batch Lebih > 3
        $sqlbb= " SELECT u.vupb_nomor, u.vupb_nama, 
                      i.c_iteno,i.c_itnam, 
                        (select COUNT(DISTINCT(pm.c_panumb1)) 
                         from purchase.pamsh pm where pm.c_iteno=p.c_iteno 
                          AND pm.lDeleted =0) 
                          as batchke, pp.tapppd_pp 
                    FROM plc2.plc2_upb_formula p 
                        JOIN plc2.plc2_upb_prodpilot pp ON p.ifor_id = pp.ifor_id 
                        JOIN plc2.plc2_upb u ON u.iupb_id = p.iupb_id 
                        JOIN sales.itemas i ON i.c_iteno = p.c_iteno 
                    WHERE u.ldeleted = 0 AND p.ldeleted = 0 
                        AND pp.ldeleted =0 AND u.iteampd_id = 3 
                        AND pp.iapppd_pp = 2 AND pp.tapppd_pp >= '".$perode1."' 
                        AND pp.tapppd_pp <= '".$perode2."' 
                        AND ( select COUNT(DISTINCT(pm.c_panumb1)) 
                            from purchase.pamsh pm where pm.c_iteno=p.c_iteno 
                            AND pm.lDeleted =0 ) >= 3";  
        $batch = $this->db_erp_pk->query($sqlbb)->result_array(); 
        $x = 0 ;   
        foreach ($batch as $b) {  
             $x++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='border: 1px solid #dddddd;' >".$x."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['vupb_nomor']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['vupb_nama']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['c_iteno']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['c_itnam']."</td> 
                        <td style='border: 1px solid #dddddd;' >".$b['batchke']."</td> 
                        <td style='border: 1px solid #dddddd;' >".$b['tapppd_pp']."</td>   
                      </tr>";   
        } 
        $html .= "</table><br><hr>";
    
        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                    <tr>
                        <td><b>Jumlah UPB  yang memiliki Tgl Estimasi Launching</b></td>
                    </tr>
                    </table>";
        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Nomor UPB</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Nama UPB</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Tanggal Launching</b></td> 
                    </tr>
            "; 

        //Launcing
        $sql2 = "SELECT distinct(pu.vupb_nomor), pu.vupb_nama, pk.tmemo_date FROM plc2.plc2_upb_bahan_kemas pk 
                        JOIN plc2.plc2_upb pu on pu.iupb_id = pk.iupb_id 
                        WHERE pu.ldeleted = 0 
                        AND pk.ldeleted = 0 
                        AND pu.iteampd_id = 3
                        AND pk.istatus_launching = 2
                        AND pk.iappdr_launch = 2
                        AND pk.tmemo_date >= '".$perode1."' AND pk.tmemo_date <= '".$perode2."'
                        ";
         
        $lauch = $this->db_erp_pk->query($sql2)->result_array(); 
        $y = 0 ; 
        foreach ($lauch as $t) {  
             $y++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='border: 1px solid #dddddd;' >".$y."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['vupb_nomor']."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['vupb_nama']."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['tmemo_date']."</td> 
                      </tr>";   
        }  
        $html .= "</table>"; 
        $html .= "<br /> ";  

        if($x==0){
            $hasil = 0;
        }else{
            $hasil = ($x/$y) * 100;
        }
        $result     = number_format($hasil,2);
        $getpoint = $this->getPoint($result, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 800px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB yang memiliki tgl approval produksi Pilot (y)</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$y."</td>
                    </tr>  

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB  yang memiliki Tgl Estimasi Launching (x)</td> 
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$x."</td>
                    </tr>  
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah produk yang ada tanggal estimasi launching dibandingkan dengan jumlah produk yang ada tanggal approve produksi pilot PD Manager = X/Y *100%</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $result . " %</b></td>
                    </tr> 
                </table>";      
        
        echo $result . "~" . $point . "~" . $warna . "~" . $html;
    }*/

    //End Here

    //=============================================================================Start N17770============================================================================================
    function spv_pd2_01 ($post){
        $iAspekId = $post['_iAspekId'];
        $cNipNya  = $post['_cNipNya'];
        //$cNipNya = 'N09484';
        $dPeriode1  = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $c = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];
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
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>No. UPB</b></td>
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>Nama Usulan</b></td>
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>Team</b></td>
                <td style='border: 1px solid #dddddd;' colspan='2' ><b>Tanggal Stabilita</b></td>   
                <td style='border: 1px solid #dddddd;' colspan='2' ><b>Status Stabilita</b></td>   
                <td style='border: 1px solid #dddddd;' rowspan='2' ><b>Grup Produk</b></td>   
            </tr>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>Lab</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Pilot</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Lab</b></td>   
                <td style='border: 1px solid #dddddd;' ><b>Pilot</b></td> 
            </tr>
        ";

        $sql1 ="SELECT sta.*,u.vupb_nomor, t.vteam, g.vNama_Group, u.iGroup_produk, u.vupb_nama FROM (
                    SELECT p.ifor_id, p.tapppd, f.iupb_id, 'Stabilita Pilot' as proses,IF (p.isucced = 2, 'MS', 'TMS') AS stat_pilot, IF (s.isucced = 2, 'MS', 'TMS') AS stat_lab, p.tapppd AS tsta_pilot, s.tapppd AS tsta_lab
                        FROM plc2.plc2_upb_stabilita_pilot p 
                        JOIN plc2.plc2_upb_formula f ON p.ifor_id = f.ifor_id
                        JOIN plc2.plc2_upb_stabilita s ON p.ifor_id = s.ifor_id
                        WHERE p.tapppd IS NOT NULL AND p.isucced IN (1,2) AND p.ldeleted = 0 AND f.ldeleted = 0 AND s.ldeleted = 0
                    UNION
                    SELECT s.ifor_id, s.tapppd, f.iupb_id, 'Stabilita Lab' as proses, '-' AS stat_pilot, IF (s.isucced = 2, 'MS', 'TMS') AS stat_lab, '-' AS tsta_pilot, s.tapppd AS tsta_lab
                        FROM plc2.plc2_upb_stabilita s 
                        JOIN plc2.plc2_upb_formula f ON s.ifor_id = f.ifor_id
                        WHERE s.tapppd IS NOT NULL AND s.isucced IN (1,2) AND s.ldeleted = 0 AND f.ldeleted = 0
                            AND (SELECT COUNT(*) FROM plc2.plc2_upb_stabilita_pilot WHERE ifor_id = f.ifor_id AND iupb_id = f.iupb_id AND tapppd IS NOT NULL) = 0
                    ORDER BY tapppd DESC, iupb_id ASC
                ) AS sta
                    JOIN plc2.plc2_upb u ON sta.iupb_id = u.iupb_id
                    JOIN plc2.plc2_upb_team t ON u.iteampd_id = t.iteam_id
                    JOIN plc2.master_group_produk g ON u.iGroup_produk = g.imaster_group_produk
                    WHERE u.iteampd_id = 3 AND u.ldeleted = 0 AND t.ldeleted = 0 AND g.lDeleted = 0
                        AND DATE(sta.tapppd) BETWEEN ? AND ?";
        $arrPeriode = array($perode1,$perode2);
        $c = $this->db_erp_pk->query($sql1." ORDER BY u.iGroup_produk ASC, sta.tapppd DESC", $arrPeriode)->result_array();
        $no = 1;
        if(!empty($c)){
            $sama = 0;
            $stbl = 1;
            for ($i=count($c)-1; $i >= 0; $i--) { 
                if ($c[$i]['iGroup_produk'] == $sama){
                    $stbl += 1;
                    $c[$i]['grp_sama'] = ($i==0)?$stbl:0;
                }else{
                    if ( ($i+1) <= count($c)-1 ){
                        $c[$i+1]['grp_sama'] = $stbl;
                    }
                    $c[$i]['grp_sama'] = ($i==0)?$stbl:0;
                    $stbl = 1;
                }
                $sama = $c[$i]['iGroup_produk'];
            }

            foreach ($c as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;' >".$no."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$v['vupb_nomor']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$v['vupb_nama']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$v['vteam']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$v['tsta_lab']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$v['tsta_pilot']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$v['stat_lab']."</td>";
                $html .= "<td style='text-align: center;border: 1px solid #dddddd;'>".$v['stat_pilot']."</td>";
                if ($v['grp_sama'] >= 1){
                    $html .= "<td rowspan='".$v['grp_sama']."' style='text-align: center;border: 1px solid #dddddd;'>".$v['vNama_Group']."</td>"; 
                }
                $html .= "</tr>"; 
                $no++;
            }
        } 
        $html .="</table>";

        $sql2 = $sql1." GROUP BY iGroup_produk";
        
        $result     = number_format($this->db_erp_pk->query($sql2, $arrPeriode)->num_rows());
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>".$vAspekName."</td>
                  
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result." Group Produk</b></td>
                    </tr>
                </table>";
        echo $result."~".$point."~".$warna."~".$html;
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

    function spv_pd2_08 ($post){
        $iAspekId = $post['_iAspekId'];
        $cNipNya  = $post['_cNipNya'];
        $this->getChild($cNipNya);
        $dPeriode1  = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $c = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];
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
                <td style='border: 1px solid #dddddd;' ><b>No. Complaint</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Disampaikan<br>Melalui</b></td>
                <td style='border: 1px solid #dddddd;' ><b>PIC</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Atasan Langsung PIC</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal<br>Terima</b></td>
            </tr>
        ";

        $sql1 ="SELECT d.cpic, e.vName, d.dtanggal_terima, c.vNo_complaint, c.vDisampaikan_melalui, a.cNip AS nip_atasan, a.vName As nama_atasan
                    FROM complain.investigasi_detail d
                    JOIN complain.investigasi i ON d.iInvest_id = i.iInvest_id
                    JOIN complain.complaint c ON i.iComplaint = c.iComplaint
                    JOIN hrd.employee e ON d.cpic = e.cNip
                    JOIN hrd.employee a ON e.cUpper = a.cNip
                    WHERE cpic IN ( '".implode("','", $this->pd_2_child)."','".$cNipNya."' )
                        AND d.dtanggal_terima BETWEEN ? AND ? 
                        AND d.ldeleted = 0 AND i.ldeleted = 0 AND c.lDeleted = 0
                    GROUP BY c.vNo_complaint";
        $arrPeriode = array($perode1,$perode2);
        $c = $this->db_erp_pk->query($sql1, $arrPeriode)->result_array();
        $no = 1;
        if(!empty($c)){
            foreach ($c as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }
                
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'> 
                            <td style='text-align: center;border: 1px solid #dddddd;' >".$no."</td>
                            <td style='text-align: center;border: 1px solid #dddddd;'>".$v['vNo_complaint']."</td> 
                            <td style='text-align: center;border: 1px solid #dddddd;'>".$v['vDisampaikan_melalui']."</td> 
                            <td style='text-align: center;border: 1px solid #dddddd;'>".$v['cpic']." - ".$v['vName']."</td> 
                            <td style='text-align: center;border: 1px solid #dddddd;'>".$v['nip_atasan']." - ".$v['nama_atasan']."</td> 
                            <td style='text-align: center;border: 1px solid #dddddd;'>".$v['dtanggal_terima']."</td> 
                          </tr>"; 
                $no++;
            }
        } 
        $html .="</table>";
        
        $result     = number_format($this->db_erp_pk->query($sql1, $arrPeriode)->num_rows());
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);+
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>".$vAspekName."</td>
                  
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result."</b></td>
                    </tr>
                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }
    //==============================================================================End N17770=============================================================================================

    /*N15748*/
     function spv_pd2_04($post){
        $iAspekId = $post['_iAspekId'];
        $iPkTransId = $post['_iPkTransId'];
        $cNipNya  = $post['_cNipNya'];
        $dPeriode1  = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $c = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];
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
                <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;''>
                        <td colspan='7' style='text-align: left;border: 1px solid #dddddd;'><b>UPB Launching (X)</b></td>
                    </tr>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>No UPB</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama Produk</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Team PD</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Status Launching</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Estimasi <br/>Launching</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Approve <br/>Launching</b></td>
            </tr>
        ";
        /*Cek Untuk Support Data Terlebih Dahulu*/
        $wherecek=array("iAspekId"=>$iAspekId,"iPkTransId"=>$iPkTransId);
        $this->db_erp_pk->where($wherecek);
        $rowcek=$this->db_erp_pk->get("hrd.pk_trans_support_data")->num_rows();
        if($rowcek==0){
            $wherecek['cCreatedBy']=$cNipNya;
            $this->db_erp_pk->insert("hrd.pk_trans_support_data",$wherecek);
        }

        $sql1 ="select up.iupb_id,up.vupb_nomor,up.vupb_nama,te.vteam,te.vtipe,bk.tmemo_date,bk.istatus_launching,bk.tappbd_launch from plc2.plc2_upb_bahan_kemas bk
                    join plc2.plc2_upb up on up.iupb_id=bk.iupb_id
                    join plc2.plc2_upb_team te on te.iteam_id=up.iteampd_id
                    where bk.ldeleted=0 and up.ldeleted=0 and te.ldeleted=0
                    and bk.istatus_launching=2 #status Launching
                    and bk.iappbd_launch =2
                    and bk.tappbd_launch is not null 
                    and bk.tappbd_launch != '0000-00-00 00:00'
                    and up.iteampd_id=3 #team PD
                    and bk.tmemo_date BETWEEN '".$perode1."' AND '".$perode2."'
                    group by up.iupb_id
                    ORDER BY up.vupb_nomor desc";
        $c = $this->db_erp_pk->query($sql1)->result_array();
        $no=1;
        $iupb_id=array();
        if(!empty($c)){
            foreach ($c as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }
                $iupb_id[]=$v['iupb_id'];
                $arrlanc=array(1 => "Process", 2=>"Launching");
                $ilaunc=isset($arrlanc[$v['istatus_launching']])?$arrlanc[$v['istatus_launching']]:'Process';
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'> 
                            <td style='text-align: center;border: 1px solid #dddddd;' >".$no."</td>
                            <td style='text-align: center;border: 1px solid #dddddd;'>".$v['vupb_nomor']."</td> 
                            <td style='text-align: left;border: 1px solid #dddddd;'>".$v['vupb_nama']."</td> 
                            <td style='text-align: center;border: 1px solid #dddddd;'>".$v['vtipe']." ".$v['vteam']."</td> 
                            <td style='text-align: center;border: 1px solid #dddddd;'>".$ilaunc."</td> 
                            <td style='text-align: center;border: 1px solid #dddddd;'>".date("Y-m-d",strtotime($v['tmemo_date']))."</td> 
                            <td style='text-align: center;border: 1px solid #dddddd;'>".date("Y-m-d",strtotime($v['tappbd_launch']))."</td> 
                          </tr>"; 
                $no++;
            }
        }
        $html .="</table>";

        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;''>
                        <td colspan='5' style='text-align: left;border: 1px solid #dddddd;'><b>UPB Setting Prioritas (Y)</b></td>
                    </tr>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>No UPB</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama Produk</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Team PD</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Approval<br />Setting Prioritas</b></td>
            </tr>
        ";

        $sql2="select * from (
                select up.vupb_nomor, up.vupb_nama,te.vteam,te.vtipe,if(pri.iappdir=1,pri.tappdir,pri.tappbusdev) as approval,if(pri.iappdir=1,'DIR','BD') as jenisapp from plc2.plc2_upb_prioritas_detail de
                    join plc2.plc2_upb_prioritas pri on pri.iprioritas_id=de.iprioritas_id
                    join plc2.plc2_upb up on up.iupb_id=de.iupb_id
                    join plc2.plc2_upb_team te on te.iteam_id=up.iteampd_id
                    join plc2.plc2_upb_bahan_kemas bk on bk.iupb_id=up.iupb_id
                    where de.ldeleted=0 and up.ldeleted=0 and pri.ldeleted=0
                    and bk.tmemo_date is null
                    and (case when pri.iappdir=1 then pri.tappdir is not null else pri.iappbusdev=2 and pri.tappbusdev is not null end)
                    and up.iteampd_id=3
                    and up.iupb_id not in (
                        select if(su.vValue is null,'0',su.vValue) from 
                        hrd.pk_trans_support_data su 
                        join hrd.pk_trans tr on tr.id=su.iPkTransId
                        where
                        tr.lDeleted=0 and tr.cNip='".$cNipNya."'
                            and su.iPkTransId!=".$iPkTransId." #and su.iAspekId!=".$iAspekId."
                        )
                UNION

                    select up.vupb_nomor, up.vupb_nama,te.vteam,te.vtipe,if(pri.iappdir=1,pri.tappdir,pri.tappbusdev) as approval,if(pri.iappdir=1,'DIR','BD') as jenisapp from plc2.plc2_upb_bahan_kemas bk
                    join plc2.plc2_upb up on up.iupb_id=bk.iupb_id
                    join plc2.plc2_upb_team te on te.iteam_id=up.iteampd_id
                    join plc2.plc2_upb_prioritas_detail de on de.iupb_id=up.iupb_id
                    join plc2.plc2_upb_prioritas pri on pri.iprioritas_id=de.iprioritas_id
                    where bk.ldeleted=0 and up.ldeleted=0 and te.ldeleted=0
                    and bk.istatus_launching=2 #status Launching
                    and bk.iappbd_launch is not null 
                    and up.iteampd_id=3 #team PD
                   and bk.tmemo_date BETWEEN '".$perode1."' AND '".$perode2."'
                    group by up.iupb_id
                ) as z
                ";
        $no2=1;
        $c2 = $this->db_erp_pk->query($sql2)->result_array();
        if(!empty($c2)){
            foreach ($c2 as $v2) {
                if (fmod($no2,2)==0){
                    $color2 = 'background-color: #eaedce';
                }else{
                    $color2 = '';
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color2."'> 
                            <td style='text-align: center;border: 1px solid #dddddd;' >".$no2."</td>
                            <td style='text-align: center;border: 1px solid #dddddd;'>".$v2['vupb_nomor']."</td> 
                            <td style='text-align: left;border: 1px solid #dddddd;'>".$v2['vupb_nama']."</td> 
                            <td style='text-align: center;border: 1px solid #dddddd;'>".$v2['vtipe']." ".$v2['vteam']."</td> 
                            <td style='text-align: center;border: 1px solid #dddddd;'>".date("Y-m-d",strtotime($v2['approval']))." [".$v2['jenisapp']."]</td> 
                          </tr>"; 
                $no2++;
            }
        }

        $html .="</table>";

        $nilai=0;
        $cupb=0;
        $no2=$no2-1;
        if(count($iupb_id)>0){
            $iupb_idup=implode(",", $iupb_id);
            $dataupdate["vValue"]=$iupb_idup;
            $this->db_erp_pk->where($wherecek);
            $this->db_erp_pk->update("hrd.pk_trans_support_data",$dataupdate);
            $cupb=count($iupb_id);
            $nilai=$cupb/$no2*100;
        }

        $result     = number_format($nilai,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr> 
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah UPB Launching (X)</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$cupb."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah keseluruhan UPB Setting Prioritas (Y)</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$no2."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Persentae X dan Y</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result." %</b></td>
                    </tr>

                </table>";

       
        echo $result."~".$point."~".$warna."~".$html;
    }

    function spv_pd2_05($post){
        $iAspekId = $post['_iAspekId'];
        $cNipNya  = $post['_cNipNya'];
        $dPeriode1  = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $c = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];
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
                <td style='border: 1px solid #dddddd;' ><b>No Req Panel</b></td>
                <td style='border: 1px solid #dddddd;' ><b>No UPB</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama Produk</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Team PD</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Jenis Panel</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Approval Req <br/>(Busdev)</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Kirim <br />PD</b></td>
            </tr>
        ";

        $sql1 ="SELECT otc_sample_panel.vNoreq_sample,plc2_upb.vupb_nomor,plc2_upb.vupb_nama,otc_panel_test.iApp_busdev,otc_panel_test.iHasil_panel,otc_panel_test.dApp_busdev,plc2_upb.iteampd_id,otc_sample_panel.dTanggalKirimPD, plc2_upb_team.vtipe, plc2_upb_team.vteam,otc_sample_panel.iJenis_panel
                FROM plc2.otc_panel_test
                INNER JOIN plc2.otc_sample_panel ON otc_sample_panel.isample_panel_id = plc2.otc_panel_test.isample_panel_id
                INNER JOIN plc2.plc2_upb_formula ON plc2_upb_formula.ifor_id = plc2.otc_sample_panel.ifor_id
                INNER JOIN plc2.plc2_upb ON plc2_upb.iupb_id = plc2.plc2_upb_formula.iupb_id
                JOIN plc2.plc2_upb_team ON plc2_upb_team.iteam_id = plc2_upb.iteampd_id
                WHERE otc_panel_test.lDeleted =  0
                AND plc2_upb.ldeleted=0
                AND plc2_upb_formula.ldeleted=0
                AND otc_sample_panel.lDeleted=0
                AND otc_panel_test.iApp_busdev = 2
                AND otc_panel_test.iHasil_panel IN (1,2)
                AND plc2_upb.iteampd_id = 3
                AND otc_panel_test.dApp_busdev BETWEEN '".$perode1."' AND '".$perode2."'
                GROUP BY otc_panel_test.ipanel_test_id
                ORDER BY plc2_upb.vupb_nomor desc";
        $c = $this->db_erp_pk->query($sql1)->result_array();
        $data=array();
        if(!empty($c)){
            foreach ($c as $v) {
                if($v["dTanggalKirimPD"]!="" && $v["dTanggalKirimPD"]!=NULL && $v["dTanggalKirimPD"]!="0000-00-00" && (date('Y-m-d',strtotime($v["dTanggalKirimPD"]))>=date('Y-m-d',strtotime($perode1))) && (date('Y-m-d',strtotime($v["dTanggalKirimPD"]))<=date('Y-m-d',strtotime($perode2)))){
                    $data["datax"][]=$v;
                }else{
                    $data["datay"][]=$v;
                }
            }
        } 
        $data2=asort($data);
        $no = 1;
        $x = 0;
        $y = 0;
        if(isset($data['datax'])){
            foreach ($data['datax'] as $key => $vn) {
                $arr=array(1=> "Kecil" , 2=> "Besar", 3=>"Eksternal");
                $jenis=isset($arr[$vn['iJenis_panel']])?$arr[$vn['iJenis_panel']]:"-";
                $color="background-color: #eaedce";
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'> 
                            <td style='text-align: center;border: 1px solid #dddddd;' >".$no."</td>
                            <td style='text-align: center;border: 1px solid #dddddd;'>".$vn['vNoreq_sample']."</td> 
                            <td style='text-align: center;border: 1px solid #dddddd;'>".$vn['vupb_nomor']."</td> 
                            <td style='text-align: left;border: 1px solid #dddddd;'>".$vn['vupb_nama']."</td> 
                            <td style='text-align: center;border: 1px solid #dddddd;'>".$vn['vtipe']." ".$vn['vteam']."</td> 
                            <td style='text-align: center;border: 1px solid #dddddd;'>".$jenis."</td> 
                            <td style='text-align: center;border: 1px solid #dddddd;'>".date("Y-m-d",strtotime($vn['dApp_busdev']))."</td> 
                            <td style='text-align: center;border: 1px solid #dddddd;'>".$vn['dTanggalKirimPD']."</td> 
                          </tr>"; 
                $no++;
            }
            if(count($data["datax"])+1==$no){
                $html.="<tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #ff9191;line-height: 14px;'><td colspan='8'>  </td></tr>";
            }
             $x=count($data["datax"]);
        }
        if(isset($data['datay'])){
            foreach ($data['datay'] as $key => $vn) {
                $arr=array(1=> "Kecil" , 2=> "Besar", 3=>"Eksternal");
                $jenis=isset($arr[$vn['iJenis_panel']])?$arr[$vn['iJenis_panel']]:"-";
                $color="background-color: #eaedce";
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'> 
                        <td style='text-align: center;border: 1px solid #dddddd;' >".$no."</td>
                        <td style='text-align: center;border: 1px solid #dddddd;'>".$vn['vNoreq_sample']."</td> 
                        <td style='text-align: center;border: 1px solid #dddddd;'>".$vn['vupb_nomor']."</td> 
                        <td style='text-align: left;border: 1px solid #dddddd;'>".$vn['vupb_nama']."</td> 
                        <td style='text-align: center;border: 1px solid #dddddd;'>".$vn['vtipe']." ".$vn['vteam']."</td> 
                        <td style='text-align: center;border: 1px solid #dddddd;'>".$jenis."</td>
                        <td style='text-align: center;border: 1px solid #dddddd;'>".date("Y-m-d",strtotime($vn['dApp_busdev']))."</td> 
                        <td style='text-align: center;border: 1px solid #dddddd;'>".$vn['dTanggalKirimPD']."</td> 
                      </tr>"; 
                $no++;
            }
            $y=count($data["datay"]);
        }

        $html .="</table>";

       
        $y=$y+$x;
        $nilai=0;
        if($x==0 || $y==0){
            $nilai=0;
        }else{
            $nilai=$x/$y*100;
        }  

        $result     = number_format($nilai,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr> 
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Panel Dengan Tanggal Kirim PD (X)</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$x."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Keseluruhan Panel (Y)</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$y."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Persentase X dan Y</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result." %</b></td>
                    </tr>

                </table>";

       
        echo $result."~".$point."~".$warna."~".$html;
    }

    function spv_pd2_06($post){
        $iAspekId = $post['_iAspekId'];
        $cNipNya  = $post['_cNipNya'];
        $dPeriode1  = $post['_dPeriode1'];
        $x_prd1 = explode("-", $dPeriode1);
        $c = $x_prd1['2']."-".$x_prd1['1']."-".$x_prd1['0'];
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
                <td style='border: 1px solid #dddddd;' ><b>No Sample Panel</b></td>
                <td style='border: 1px solid #dddddd;' ><b>No UPB</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama Produk</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Team PD</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Jenis Panel</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Hasil Panel</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Request <br />Panel (A)</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Kirim <br />PD(B)</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Selisih A & B <br /> (Hari)</b></td>
            </tr>
        ";

        $sql1 ="SELECT otc_sample_panel.vNoreq_sample,plc2_upb.vupb_nomor,plc2_upb.vupb_nama,otc_panel_test.iApp_busdev,otc_panel_test.iHasil_panel,otc_panel_test.dApp_busdev,plc2_upb.iteampd_id,otc_sample_panel.dTanggalKirimPD, plc2_upb_team.vtipe, plc2_upb_team.vteam,otc_sample_panel.dRequest,otc_sample_panel.iJenis_panel
                FROM plc2.otc_panel_test
                INNER JOIN plc2.otc_sample_panel ON otc_sample_panel.isample_panel_id = plc2.otc_panel_test.isample_panel_id
                INNER JOIN plc2.plc2_upb_formula ON plc2_upb_formula.ifor_id = plc2.otc_sample_panel.ifor_id
                INNER JOIN plc2.plc2_upb ON plc2_upb.iupb_id = plc2.plc2_upb_formula.iupb_id
                JOIN plc2.plc2_upb_team ON plc2_upb_team.iteam_id = plc2_upb.iteampd_id
                WHERE otc_panel_test.lDeleted =  0
                AND plc2_upb.ldeleted=0
                AND plc2_upb_formula.ldeleted=0
                AND otc_sample_panel.lDeleted=0
                AND otc_panel_test.iApp_busdev = 2
                AND otc_panel_test.iHasil_panel IN (1,2)
                AND plc2_upb.iteampd_id = 3
                AND otc_sample_panel.dTanggalKirimPD BETWEEN '".$perode1."' AND '".$perode2."'
                GROUP BY otc_panel_test.ipanel_test_id
                ORDER BY plc2_upb.vupb_nomor desc";
        $c = $this->db_erp_pk->query($sql1)->result_array();
        $data=array();
        if(!empty($c)){
            foreach ($c as $v) {
                if($v["dTanggalKirimPD"]!="" && $v["dTanggalKirimPD"]!=NULL && $v["dTanggalKirimPD"]!="0000-00-00" && (date('Y-m-d',strtotime($v["dTanggalKirimPD"]))>=date('Y-m-d',strtotime($perode1))) && (date('Y-m-d',strtotime($v["dTanggalKirimPD"]))<=date('Y-m-d',strtotime($perode2)))){
                    $data["datax"][]=$v;
                }else{
                    $data["datay"][]=$v;
                }
            }
        } 
        $data2=asort($data);
        $no = 1;
        $countselisih=array();
        $x=0;
        if(isset($data['datax'])){
            if($data['datax']>0){
                foreach ($data['datax'] as $key => $vn) {
                    $se=$this->selisihnokerja($vn['dRequest'], $vn['dTanggalKirimPD']);
                    $countselisih[]=$se;
                    $arr=array(1=> "Kecil" , 2=> "Besar", 3=>"Eksternal");
                   $arr2=array(1=> "TMS" , 2=> "MS");
                     $jenis=isset($arr[$vn['iJenis_panel']])?$arr[$vn['iJenis_panel']]:"-";
                     $hasil=isset($arr2[$vn['iHasil_panel']])?$arr2[$vn['iHasil_panel']]:"-";
                    $color="background-color: #eaedce";
                    $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'> 
                                <td style='text-align: center;border: 1px solid #dddddd;' >".$no."</td>
                                <td style='text-align: center;border: 1px solid #dddddd;'>".$vn['vNoreq_sample']."</td> 
                                <td style='text-align: center;border: 1px solid #dddddd;'>".$vn['vupb_nomor']."</td> 
                                <td style='text-align: left;border: 1px solid #dddddd;'>".$vn['vupb_nama']."</td> 
                                <td style='text-align: center;border: 1px solid #dddddd;'>".$vn['vtipe']." ".$vn['vteam']."</td> 
                                <td style='text-align: center;border: 1px solid #dddddd;'>".$jenis."</td>
                                <td style='text-align: center;border: 1px solid #dddddd;'>".$hasil."</td>
                                <td style='text-align: center;border: 1px solid #dddddd;'>".$vn['dRequest']."</td> 
                                <td style='text-align: center;border: 1px solid #dddddd;'>".$vn['dTanggalKirimPD']."</td> 
                                <td style='text-align: center;border: 1px solid #dddddd;'>".$se."</td> 
                              </tr>"; 
                    $no++;
                }
            }
           /* if(count($data["datax"])+1==$no){
                $html.="<tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #ff9191;line-height: 14px;'><td colspan='11'>  </td></tr>";
            }*/

        $x=count($data["datax"]);

        }
         /*if(isset($data['datay'])){
            foreach ($data['datay'] as $key => $vn) {
                $se=0;
                if($vn['dTanggalKirimPD']!="" && $vn["dRequest"]!=""){
                    $se=$this->selisihnokerja($vn['dRequest'], $vn['dTanggalKirimPD']);
                }
                $countselisih[]=$se;
                $arr=array(1=> "Kecil" , 2=> "Besar", 3=>"Eksternal");
                $arr2=array(1=> "TMS" , 2=> "MS");
                $jenis=isset($arr[$vn['iJenis_panel']])?$arr[$vn['iJenis_panel']]:"-";
                $hasil=isset($arr2[$vn['iHasil_panel']])?$arr2[$vn['iHasil_panel']]:"-";
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'> 
                        <td style='text-align: center;border: 1px solid #dddddd;' >".$no."</td>
                        <td style='text-align: center;border: 1px solid #dddddd;'>".$vn['vNoreq_sample']."</td> 
                        <td style='text-align: center;border: 1px solid #dddddd;'>".$vn['vupb_nomor']."</td> 
                        <td style='text-align: left;border: 1px solid #dddddd;'>".$vn['vupb_nama']."</td> 
                        <td style='text-align: center;border: 1px solid #dddddd;'>".$vn['vtipe']." ".$vn['vteam']."</td> 
                        <td style='text-align: center;border: 1px solid #dddddd;'>".$jenis."</td>
                        <td style='text-align: center;border: 1px solid #dddddd;'>".$hasil."</td>
                        <td style='text-align: center;border: 1px solid #dddddd;'>".$vn['dRequest']."</td> 
                        <td style='text-align: center;border: 1px solid #dddddd;'>".$vn['dTanggalKirimPD']."</td> 
                        <td style='text-align: center;border: 1px solid #dddddd;'>".$se."</td> 
                      </tr>"; 
                $no++;
            }
        }*/
        $y=array_sum($countselisih);
        $selisihbln=number_format($y/22,2);
        $html.="<tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #b5f2a6;line-height: 14px;text-align: center;'><td colspan='9' style='text-align: center;border: 1px solid #dddddd;'><b>Jumlah Selisih (Hari)</b></td><td style='text-align: center;border: 1px solid #dddddd;'><b>".$y."</b></td></tr>";

        $html .="</table>";

        $nilai=0;
        if($x==0 || $selisihbln==0){
            $nilai=0;
        }else{
            $nilai=$selisihbln/$x;
        }  

        $result     = number_format($nilai,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 300px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr> 
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Selisih A & B (Bulan) (X)</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$selisihbln."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Panel Dengan Tanggal Kirim PD (Y)</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$x."</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Kecepatan Rata - Rata (X/Y)</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result." Bulan</b></td>
                    </tr>

                </table>";

       
        echo $result."~".$point."~".$warna."~".$html;
    }

    function selisihnokerja($current,$last){ 
        $tanggal1 = new DateTime($current);
        $tanggal2 = new DateTime($last); 
        $perbedaan = $tanggal2->diff($tanggal1)->format("%a");
        return $perbedaan;
    }

    /*N15748 End*/
}
?>