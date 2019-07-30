<?php

class lib_pk_ass_manager_produksi_nbl_1_1
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
    /*===============Start Function=======================*/ 
    function ASC_NBL11_P_01($post)    {
        
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
        $html .= "<table>
                    <tr>
                        <td><h4><b>Total MBR solid, Liquid, Softgel, dan Steril. (X)</b></td>
                    </tr>
                </table>";
        $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>PA No </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Batch No </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kode Produk</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama Produk</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Type</b></td>  
                <td style='border: 1px solid #dddddd;' ><b>Toll</b></td>  
                <td style='border: 1px solid #dddddd;' ><b>Import</b></td>  
                <td style='border: 1px solid #dddddd;' ><b>Floor</b></td>  
                <td style='border: 1px solid #dddddd;' ><b>Kategori</b></td>  
                <td style='border: 1px solid #dddddd;' ><b>Plan Date</b></td>  
            </tr>
        ";


        //Kategory A
        $sql2 ="select a.c_panumb,a.c_panumb1,a.c_iteno,b.c_itnam,a.c_type,b.c_toll,d.c_nmfloor,b.l_import,e.c_nmkateg,a.d_plandate
                from purchase.pamsh a
                join sales.itemas b on b.c_iteno =a.c_iteno and b.iCompanyID=3
                join sales.jenis c on c.c_jenis=b.c_jenis  and c.iCompanyID=3
                join mrp.kategori e on e.c_kategori=c.c_kategori and e.iCompanyID=3
                join purchase.floor d on d.c_floor=a.c_lokasi  and d.iCompanyID=3
                where 
                a.c_type in ('N')
                and b.c_toll = 'N'
                and b.l_import= 0

                and (d.c_floor='0003' or d.c_floor='0001')
                and (e.c_kategori = 'S' or e.c_kategori = 'L' or e.c_kategori = 'G' or e.c_kategori = 'I')  
                and a.iCompanyID=3
                and a.d_plandate >= '".$perode1."'
                and a.d_plandate <= '".$perode2."'
                order by a.d_datent,a.d_plandate DESC
                
                ";

        $sql1 ="select a.c_panumb,a.c_panumb1,a.c_iteno,b.c_itnam,a.c_type,b.c_toll,d.c_nmfloor,b.l_import,e.c_nmkateg,a.d_plandate,a.c_flgprd, re.d_packing
                from purchase.pamsh a
                join sales.itemas b on b.c_iteno =a.c_iteno and b.iCompanyID=3
                join sales.jenis c on c.c_jenis=b.c_jenis  and c.iCompanyID=3
                join mrp.kategori e on e.c_kategori=c.c_kategori and e.iCompanyID=3
                join purchase.floor d on d.c_floor=a.c_lokasi  and d.iCompanyID=3
                join (select *
                    from sales.recent r 
                    where 
                    r.d_packing >= '".$perode1."'
                    and r.d_packing <= '".$perode2."'
                    and r.iCompanyID=3
                    group by r.c_batchno
                    order by r.d_packing DESC
                    ) re on re.c_batchno = a.c_panumb

                where  
                a.c_type in ('N')
                and b.c_toll = 'N'
                and b.l_import= 0
                
                and (d.c_floor='0003' or d.c_floor='0001')
                and (e.c_kategori = 'S' or e.c_kategori = 'L' or e.c_kategori = 'G' or e.c_kategori = 'I')  
                and a.iCompanyID=3
                and a.d_plandate >= '".$perode1."'
                and a.d_plandate <= '".$perode2."'
                and a.c_flgprd='W'
                order by a.c_panumb,a.d_plandate DESC
                
                ";
        /*$sql1 ="select a.c_panumb,a.c_panumb1,a.c_iteno,b.c_itnam,a.c_type,b.c_toll,d.c_nmfloor,b.l_import,e.c_nmkateg,a.d_plandate
                from purchase.pamsh a
                join sales.itemas b on b.c_iteno =a.c_iteno and a.iCompanyID=3
                join sales.jenis c on c.c_jenis=b.c_jenis  and c.iCompanyID=3
                join mrp.kategori e on e.c_kategori=c.c_kategori and e.iCompanyID=3
                join purchase.floor d on d.c_floor=a.c_lokasi  and d.iCompanyID=3
                where 
                ( a.c_type in ('R','N')
                or b.c_toll = 'Y'
                or b.l_import= 0
                )
                and d.c_floor='0002'
                and e.c_kategori = 'I' #steril
                and a.iCompanyID=3
                and a.d_plandate >= '".$perode1."'
                and a.d_plandate <= '".$perode2."'
                and a.c_flgprd='W'
                order by a.d_datent DESC
                
                ";*/


        //Non Kategory A
       /* $sql1 ="select a.c_panumb,a.c_panumb1,a.c_iteno,b.c_itnam, re.d_packing
                from purchase.pamsh a 
                join sales.itemas b on b.c_iteno=a.c_iteno
                join (select *
                    from sales.recent r 
                    where 
                    r.d_packing >= '".$perode1."'
                    and r.d_packing <= '".$perode2."'
                    and r.iCompanyID=3
                    group by r.c_batchno
                    order by r.d_packing DESC
                    ) re on re.c_batchno = a.c_panumb
                where a.c_flgprd='W'

                "; */
 
        $b = $this->db_erp_pk->query($sql2)->result_array();
        $c = $this->db_erp_pk->query($sql1)->result_array();
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
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_panumb']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_panumb1']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_iteno']."</td> 
                            <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>".$v['c_itnam']."</td> 
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;'>".$v['c_type']."</td> 
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;'>".$v['c_toll']."</td> 
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;'>".$v['l_import']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_nmfloor']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_nmkateg']."</td> 

                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['d_plandate']."</td> 

                          </tr>"; 
                $no++;
            }

            
            $html .= "<table>
                    <tr>
                        <td><b>Total MBR steril close (Y)</b></td>
                    </tr>
                </table>";
            $html .= "<table cellspacing='0' cellpadding='3' width='100%'>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>PA No </b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Batch No </b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Kode Produk</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Nama Produk</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Status</b></td>  
                    <td style='border: 1px solid #dddddd;' ><b>Packing Date</b></td>  
                </tr>
            ";
            $no1 = 1;
            if(!empty($c)){
                foreach ($c as $v) {
                    if (fmod($no1,2)==0){
                        $color = 'background-color: #eaedce';
                    }else{
                        $color = '';
                    }
                    
                    $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'> 
                                <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$no1."</td>
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_panumb']."</td> 
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_panumb1']."</td> 
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_iteno']."</td> 
                                <td style='width:20%;text-align: left;border: 1px solid #dddddd;'>".$v['c_itnam']."</td> 
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['c_flgprd']."</td> 
                                <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$v['d_packing']."</td> 

                              </tr>"; 
                    $no1++;
                }
            }



        } 

        $html .="</table>";
        $totA       = $this->db_erp_pk->query($sql1)->num_rows();
        $totb       = $this->db_erp_pk->query($sql2)->num_rows(); 
        if($totb==0){
            $hasil_b    =0;
        }else{
            $hasil_b    =   $totA / $totb  ;
        }
        
        $result     = number_format($hasil_b * 100,2);
        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];

        $html .= "<br /> ";
        
        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 550px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>(x) Total MBR solid, Liquid, Softgel, dan Steril.</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$totb."</td>
                    </tr> 


                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>(y) Total MBR solid, Liquid, Softgel, dan Steril close</td>
                        
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totA."</td>
                    </tr>

                    

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Persentase Produk (y/x * 100%)</td>
                  
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result." %</b></td>
                    </tr>
                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

   
     
    function ASC_NBL11_P_06($post)    {
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
                    <table cellspacing='0' cellpadding='3' width='850px'>
                        <tr>
                            <td><b>Point Untuk Aspek :</b></td>
                            <td style='text-align:left'>".$vAspekName."</td>
                        </tr>
                    </table><br><hr>";


            $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                        <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                            <th>No</th>
                            <th>Kode Batch</th>
                            <th>Kode Obat</th>
                            <th>Nama Produk</th>
                            <th>No Rework</th>
                            <th>Rework Ke</th>
                            <th>Jenis</th>
                            <th>Prosess</th>
                            <th>Tanggal Approve Rework</th> 
                        </tr>
            ";

        //Rework Non Steril
        $sql = " SELECT km.vBatch_no, km.vNama, km.vKode_obat, kd.*, kr.*, 
                    kj.vnama_jenis ,kp.vProses_name FROM kanban.kbn_rework kr 
                    JOIN kanban.kbn_rework_detail kd on kr.iRework = kd.iRework
                    JOIN kanban.kbn_mbr km on km.id = kr.mbr_id
                    JOIN kanban.kbn_master_jenis kj on km.ijenis_id = kj.ijenis_id
                    JOIN kanban.kbn_master_proses kp on kp.iProses_id = kr.iProses_id
                    WHERE 
                        kr.ldeleted = 0 and
                        kd.ldeleted = 0 and 
                        km.iDeleted = 0 and
                        kd.iapp_rework = 2 and 
                        kj.jenis_kategori = 2 and
                        kd.dapp_rework >= '".$perode1."' and 
                        kd.dapp_rework <= '".$perode2."' ";

        $sql_loop = $this->db_erp_pk->query($sql)->result_array();
        $i=0; 
        foreach ($sql_loop as $sl) {  
             $i++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                         <td style='border: 1px solid #dddddd;'>".$i."</td>
                         <td style='border: 1px solid #dddddd;'>".$sl['vBatch_no']."</td>
                         <td style='border: 1px solid #dddddd;'>".$sl['vKode_obat']."</td>
                         <td style='border: 1px solid #dddddd;'>".$sl['vNama']."</td>
                         <td style='border: 1px solid #dddddd;'>".$sl['vNo_request']."</td>
                         <td style='border: 1px solid #dddddd;'>".$sl['iReq_count']."</td> 
                         <td style='border: 1px solid #dddddd;'>".$sl['vnama_jenis']."</td> 
                         <td style='border: 1px solid #dddddd;'>".$sl['vProses_name']."</td> 
                         <td style='border: 1px solid #dddddd;'>".date('Y-m-d',strtotime($sl['dapp_rework']))."</td> 
                      </tr>"; 
        }

        $bulan = $this->hitung_bulan($perode1, $perode2);
        if($bulan==0){
            $hasil = 0;
        }else{
            $hasil = number_format(($i/$bulan),2);
        } 

        $html .= "</table><table align='left' cellspacing='0' cellpadding='3' style='width: 550px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Rework</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $i . "</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Periode Semester</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $bulan . " Bulan</b></td>
                    </tr>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Rata - rata Rework</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" .$hasil. "</b></td>
                    </tr> 
                </table>";
        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }
    function ASC_NBL11_P_09($post)    {
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
                        <td><b>Jumlah Produk yang di DN Batal Turun</b></td>
                    </tr>
                    </table>";
        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                    <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Kode Produk</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Nama Produk</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Batch No</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>DN Number</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Floor</b></td>
                    <td style='border: 1px solid #dddddd;' ><b>Remark</b></td> 
                    <td style='border: 1px solid #dddddd;' ><b>Periode</b></td>  
                </tr>
            ";

        $sqlBatalProd = "SELECT d.c_nmfloor, r.id, r.d_dndate , r.d_datent, r.c_dnnumb, i.c_iteno,i.c_itnam, r.c_batchno, r.c_status, r.c_remark FROM sales.recent r
                 JOIN sales.itemas i on r.c_iteno = i.c_iteno 
                 JOIN purchase.pamsh p on r.c_batchno = p.c_panumb  
                 join purchase.floor d on d.c_floor=p.c_lokasi   
                     WHERE r.d_dndate >= '".$perode1."' and r.d_dndate <= '".$perode2."' and
                     i.l_tolletc <>1 and p.c_jnsmbr = 1   
                     and r.n_dncode = 1 and r.l_canmbr = 1 and (d.c_floor='0003' or d.c_floor='0001')
                ORDER by r.d_dndate";
        $batal = $this->db_erp_pk->query($sqlBatalProd)->result_array(); 
        $x = 0 ;



        $simpanXperiode = array(); 
        foreach ($batal as $b) {  
             $x++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='border: 1px solid #dddddd;' >".$x."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['c_iteno']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['c_itnam']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['c_batchno']."</td>
                        <td style='border: 1px solid #dddddd;' >".$b['c_dnnumb']."</td> 
                        <td style='border: 1px solid #dddddd;'>".$b['c_nmfloor']."</td> 
                        <td style='border: 1px solid #dddddd;' >".$b['c_remark']."</td>  
                        <td style='border: 1px solid #dddddd;' >".$b['d_dndate']."</td>  
                      </tr>"; 
             $pecah = explode('-', $b['d_dndate']);
             $stringXo = $pecah['0'].$pecah['1'];  
             $simpanXperiode[$stringXo]++; 
             
        }
        //print_r($simpanXperiode);exit;
        $html .= "</table>";



        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                    <tr>
                        <td><b>Jumlah MBR Yang Turun Di bulan yang dipilih di Aplikasi Novell - Rekap Penurunan MBR dan di filter/ identifikasi hanya untuk produk diluar Export, Launching, applet dll.</b></td>
                    </tr>
                    </table>";
        $html .= "<table cellspacing='0' cellpadding='3' width='850px'>
                    <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                        <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Kode Produk</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Nama Produk</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>OPT Batch</b></td>
                        <td style='border: 1px solid #dddddd;' ><b>Real Produksi</b></td> 
                        <td style='border: 1px solid #dddddd;' ><b>Floor</b></td> 
                        <td style='border: 1px solid #dddddd;' ><b>Periode</b></td>  
                    </tr>
            ";
        $tgl1 = $x_prd1['2'].$x_prd1['1'];
        $tgl2 = $x_prd2['2'].$x_prd2['1'];
        $sqlJumlahTurun = "SELECT d.c_nmfloor, r.id, left(r.c_period,4) as perTahun, right(r.c_period,2) as perBulan, r.c_iteno, i.c_itnam, r.n_optbatch,r.c_userid, r3.n_realprod FROM mrp.rpb r 
                JOIN sales.itemas i on i.c_iteno = r.c_iteno
                JOIN mrp.rpb03 r3 on r3.c_iteno = r.c_iteno 

                JOIN purchase.pamsh p on i.c_iteno = p.c_iteno
                join purchase.floor d on d.c_floor=p.c_lokasi 
                where (i.c_export<>'Y' or i.l_import=0) and 
                i.c_status='A' and r3.n_realprod>0 
                and (d.c_floor='0003' or d.c_floor='0001') 
                and CONVERT(r.c_period,UNSIGNED INTEGER)>=".$tgl1."
                and CONVERT(r.c_period,UNSIGNED INTEGER)<=".$tgl2."
                GROUP by i.c_iteno
                ";
        $turun = $this->db_erp_pk->query($sqlJumlahTurun)->result_array(); 
        $y = 0 ;
        $simpanYperiode = array(); 
        foreach ($turun as $t) {  
             $y++;
             $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='border: 1px solid #dddddd;' >".$y."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['c_iteno']."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['c_itnam']."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['n_optbatch']."</td>
                        <td style='border: 1px solid #dddddd;' >".$t['n_realprod']."</td> 
                        <td style='border: 1px solid #dddddd;'>".$t['c_nmfloor']."</td> 
                        <td style='border: 1px solid #dddddd;' >".$t['perTahun']."-".$t['perBulan']."</td>  
                      </tr>"; 
             $stringYo = $t['perTahun'].$t['perBulan'];  
             $simpanYperiode[$stringYo]++; 
        }
        //print_r($simpanYperiode);exit;
        $html .= "</table>";
        /*
            SELECT r.id, r.c_period, r.c_iteno, i.c_itnam, r.n_optbatch,r.c_userid, r3.n_realprod FROM mrp.rpb r 
                JOIN sales.itemas i on i.c_iteno = r.c_iteno
                JOIN mrp.rpb03 r3 on r3.c_iteno = r.c_iteno 
                where (i.c_export<>'Y' or i.l_import=0) and 
                i.c_status='A' and r3.n_realprod>0 
                and CONVERT(r.c_period,UNSIGNED INTEGER)>=201707
                and CONVERT(r.c_period,UNSIGNED INTEGER)<=201712
    
        */
        /*
            SELECT r.id, r.d_datent, r.c_dnnumb, i.c_iteno,i.c_itnam, r.c_batchno, r.c_status, r.c_remark FROM sales.recent r
                 JOIN sales.itemas i on r.c_iteno = i.c_iteno 
                 JOIN purchase.pamsh p on r.c_batchno = p.c_panumb 
                     WHERE r.d_dndate >= "2017-07-01" and r.d_dndate <= "2018-12-31" and
                     i.l_tolletc <>1 and p.c_jnsmbr = 1 
                     and r.n_dncode = 1 and r.l_canmbr = 1 
                ORDER by r.d_dndate
        */

        $html .= "<br /> ";

        $bulan = $this->hitung_bulan($perode1,$perode2); 

        if($x==0 || $y==0){
            $hasil = 0;
        }else{
            $tot = 0;
            foreach ($simpanXperiode as $k  => $v) {
                if(!empty($simpanYperiode[$k]) || $simpanYperiode[$k]!=0){
                    //echo $k.' : '.$v.'/'.$simpanYperiode[$k].'<br>';
                    $hsl = $v/$simpanYperiode[$k];
                }
                $tot+=$hsl;
            }
            //echo $tot; 
        } 
        $hit = $tot/$bulan;
        $hasil = number_format($hit*100 ,2);
        
        $htmlxy = "<table align='left' cellspacing='0' cellpadding='3' style='width: 100%;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                    <td style='width:2%;text-align: left;border: 1px solid #dddddd;'></td> ";

                    $tgl_skr = new DateTime($perode2, new DateTimeZone("Europe/London"));
                    $tgl_lalu = new DateTime($perode1, new DateTimeZone("Europe/London"));

                    $cek_val ="";
                    do { 
                        if($cek_val!=$tgl_skr->format("Y-m")){
                            $tgl = $tgl_skr->format("Y-m"); 
                            $htmlxy .= "<td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$tgl."</td> ";
                        }
                        $cek_val=$tgl_skr->format("Y-m");  
                        $tgl_skr->modify('-1 month');
                    } while ($tgl_skr >= $tgl_lalu);
 
                    $htmlxy .= "</tr><tr><td style='width:2%;text-align: left;border: 1px solid #dddddd;'>(x)</td> ";

                    $tgl_skr = new DateTime($perode2, new DateTimeZone("Europe/London"));
                    $tgl_lalu = new DateTime($perode1, new DateTimeZone("Europe/London"));
                    $cek_val ="";
                    do { 
                        if($cek_val!=$tgl_skr->format("Y-m")){
                            $tgl = explode('-',$tgl_skr->format("Y-m"));  
                            $tgl0 = $tgl[0].$tgl[1];
                            if(!empty($simpanXperiode[$tgl0]) || $simpanXperiode[$tgl0]!=0){
                                $htmlxy .= "<td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$simpanXperiode[$tgl0]."</td>";
                            }else{
                                $htmlxy .= "<td style='width:10%;text-align: right;border: 1px solid #dddddd;'>0</td>";
                            }
                        }
                        $cek_val=$tgl_skr->format("Y-m");  
                        $tgl_skr->modify('-1 month');
                    } while ($tgl_skr >= $tgl_lalu);

                     

                    $htmlxy .= "</tr><tr><td style='width:2%;text-align: left;border: 1px solid #dddddd;'>(y)</td> ";

                    $tgl_skr = new DateTime($perode2, new DateTimeZone("Europe/London"));
                    $tgl_lalu = new DateTime($perode1, new DateTimeZone("Europe/London"));
                    $cek_val ="";
                    do { 
                        if($cek_val!=$tgl_skr->format("Y-m")){
                            $tgl = explode('-',$tgl_skr->format("Y-m"));  
                            $tgl0 = $tgl[0].$tgl[1];
                            if(!empty($simpanYperiode[$tgl0]) || $simpanYperiode[$tgl0]!=0){
                                $htmlxy .= "<td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$simpanYperiode[$tgl0]."</td>";
                            }else{
                                $htmlxy .= "<td style='width:10%;text-align: right;border: 1px solid #dddddd;'>0</td>";
                            }
                        }
                        $cek_val=$tgl_skr->format("Y-m");  
                        $tgl_skr->modify('-1 month');
                    } while ($tgl_skr >= $tgl_lalu);


        $htmlxy .= "</tr></table>";

        $html .= "<table align='left' cellspacing='0' cellpadding='3' style='width: 800px;'>
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;background-color: #3bdeea;'>
                        <td colspan='2' style='text-align: left;border: 1px solid #dddddd;'></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>(x)Jumlah Produk yang di DN Batal Turun</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$x."</td>
                    </tr> 


                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>(y) Jumlah MBR Yang Turun Di bulan yang dipilih di Aplikasi Novell - Rekap Penurunan MBR dan di filter/ identifikasi hanya untuk produk diluar Export, Launching, applet dll.</td> 
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$y."</td>
                    </tr> 

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Periode Semester</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>" . $bulan . " Bulan</b></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Detail Total (x) & (y) per Bulan</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>" . $htmlxy  . "</b></td>
                    </tr> 
                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Persentase MBR (x/y * 100%) per bulan</td>
                  
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$hasil." %</b></td>
                    </tr>
                </table>";      
        
        $getpoint = $this->getPoint($hasil, $iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point = $x_getpoint['0'];
        $warna = $x_getpoint['1'];
        echo $hasil . "~" . $point . "~" . $warna . "~" . $html;
    }
}
?>