<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class lib_pk_pd3 {
    private $_ci;
    private $sess_auth;
    private $db_erp_pk;

    function __construct() {
        $this->_ci = &get_instance();
        $this->_ci->load->library('Zend', 'Zend/Session/Namespace');
        $this->sess_auth = new Zend_Session_Namespace('auth');
        $this->db_erp_pk = $this->_ci->load->database('pk',false, true);
    }


    function getTglPrio($bdID,$periode){
        if($periode < '2016-01-01'){
        
            $cekPrioLebih2016 = '   select date(b.tappbusdev) tappbusdev
                                    from plc2.plc2_upb_prioritas_detail a 
                                    join plc2.plc2_upb_prioritas b on b.iprioritas_id=a.iprioritas_id
                                    join plc2.plc2_upb c on c.iupb_id = a.iupb_id
                                    where a.ldeleted=0
                                    and b.ldeleted=0
                                    and b.iappbusdev=2
                                    and date(b.tappbusdev) > "2016-01-01" 
                                    order by b.tappbusdev ASC Limit 1
                                ';
            $dPrioLebih2016 =$this->db_erp_pk->query($cekPrioLebih2016)->row_array();

            if(!empty($dPrioLebih2016)){
                // jika ada , maka ambil tanggal prioritas yang ini 
                $tgl = $dPrioLebih2016['tappbusdev'];
            }else{
                $tgl = '2016-01-01';
            
            }
        }else{
            $tgl = date('Y-m-d',strtotime($periode));
        }

        return $tgl;
    }
    function getDurasiBulan($start, $end ){
       $kolor = '';
       if($start > $end){
            $start1= $start ;
            $end=$start;
            $start=$start1;
            $kolor = 'red';
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


    function getPoint($result,$iAspekId){
        $sql = "select a.nPoint,(select cWarna FROM hrd.pk_warna WHERE iPoint=a.nPoint) as warna from hrd.pk_aspek_detail as a WHERE a.iAspekId='".$iAspekId."' and '".$result."' between a.yNilai1 and a.yNilai2";
        $query = $this->db_erp_pk->query($sql);
        if ( $query->num_rows() > 0) {
            $row = $query->row();
            $value = $row->nPoint."~".$row->warna;
        }else{
            $value = '20~#FF3333';
        }

        return $value;

    }

    function hitung_bulan($perode1,$perode2){
        $date1 = new DateTime($perode1);
        $date2 = new DateTime($perode2);

        $diff = $date1->diff($date2);
        $bulan = (($diff->format('%y') * 12) + $diff->format('%m'))+1;

        return $bulan;
    }

    function sumTime($times){
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


    function datediff($tgl1,$tgl2,$cNip){
        $sql = "SELECT iCompanyId FROM hrd.employee WHERE cNip='".$cNip."' ";
        $query = $this->db_erp_pk->query($sql);
        if ( $query->num_rows() > 0) {
            $row = $query->row();
            $company = $row->iCompanyId;
        }

        $dstart = date('Y-m-d',strtotime($tgl1));
        $dend = date('Y-m-d',strtotime($tgl2));
        $increment = "++";
        if ($dstart > $dend){
             $dstart = date('Y-m-d',strtotime($tgl2));
             $dend = date('Y-m-d',strtotime($tgl1));
             $increment = "--";
            //echo "Lebih Besar ".$dstart." > ".$dend ;
            //exit();
        }

        $start      = new DateTime($dstart);
        $start->modify('+1 day');
        $end        = new DateTime($dend);
        $end->modify('+1 day');
        $period     = new DatePeriod($start, new DateInterval('P1D'), $end);
        $year1      = date('Y',strtotime($dstart));
        $year2      = date('Y',strtotime($dend));
        //cari hari liburnya
        $sql= "SELECT *
                FROM (SELECT a.dDate AS tgl,a.cYear, 'hol' AS src,a.cdescription AS ket
                      FROM hrd.holiday AS a
                  UNION ALL
                      SELECT b.dDate AS tgl,b.cYear,'cho' AS src,b.vDescription AS ket
                      FROM hrd.compholiday AS b
                        WHERE b.iCompanyId='".$company."'
                     )AS tabgab
                   WHERE cyear BETWEEN '".$year1."' AND '".$year2."'";


        $holidays = Array();
        $result = mysql_query($sql) or die(mysql_error()."</br>".$sql);

        while ($row = mysql_fetch_assoc($result)) {
            array_push($holidays, $row['tgl']);
        }

        $lama = 0;
        foreach($period as $dt) {

                $curr    = $dt->format('D');
                $tanggal = $dt->format('Y-m-d');
                // for the updated question
                if ($curr == 'Sat' || $curr == 'Sun') {
                    continue;
                }
                if (in_array($dt->format('Y-m-d'), $holidays)) {

                }else{
                    if ($increment=='++'){
                        $lama++;
                    }else{
                        $lama--;
                    }

                }


        }

        if ($increment=='++'){
            return $lama+1;
        }else{
            return $lama-1;
        }


    }


    function getvName($cNip) {

        $vName = '';

        $sql = "SELECT vName FROM hrd.employee WHERE cNip = '{$cNip}' AND lDeleted = 0";
        $query = $this->db_erp_pk->query($sql);

        if ($query->num_rows() > 0) {
            $row = $query->row();

            $vName = $row->vName;
        }

        return $vName;
    }



    /* -- */

    /*PD3 N14615 Start*/
    function PD3_getParameter6($post){

        $iPkTransId = $post['_iPkTransId'];
        $val7A = $post['_val7A'];

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
                <td style='border: 1px solid #dddddd;' ><b>No UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kategori UPB</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Confirm Cek Dokumen Prareg oleh PD</b></td>
            </tr>
        ";

        /*get Support data*/
        $sql1 = "SELECT a.vValue
                from hrd.pk_trans_support_data a
                where a.iPkTransId='".$iPkTransId."'
                and a.iAspekId='".$iAspekId."' ";

        $sql7A = "SELECT a.vValue
                from hrd.pk_trans_support_data a
                where a.iPkTransId='".$iPkTransId."'
                and a.iAspekId=11194";
        $tot7A      = $this->db_erp_pk->query($sql7A)->row_array();

        $val7A = $tot7A['vValue'];
        $val7A = (isset($val7A))?$val7A:0;


        //Non Kategory A
        $sql2 ="SELECT pu.`iupb_id`,pu.vupb_nomor,pu.vupb_nama,pu.ikategoriupb_id, pu.tconfirm_dok_pd
                FROM plc2.plc2_upb pu
                WHERE pu.`ldeleted` = 0
                AND pu.`iteampd_id` = 2
                AND pu.`itipe_id` NOT IN(6)
                AND pu.iconfirm_dok_pd=1
                AND pu.tconfirm_dok_pd IS NOT NULL
                AND pu.tconfirm_dok_pd between '".$perode1."' AND '".$perode2."'";

        $b = $this->db_erp_pk->query($sql2)->result_array();
        $no = 1;
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }
                $k='';
                $sqlk ="SELECT u.`vkategori` FROM plc2.`plc2_upb_master_kategori_upb` u WHERE u.`ldeleted`=0 AND  u.`ikategori_id` = '".$v['ikategoriupb_id']."'";
                $kat = $this->db_erp_pk->query($sqlk)->row_array();
                if(empty($kat['vkategori'])){
                    $k = '-';
                }else{
                    $k = $kat['vkategori'];
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$no."</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nama']."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$k."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('d-m-Y',strtotime($v['tconfirm_dok_pd']))."</td>
                          </tr>";
                $no++;
            }
        }

        $html .="</table>";
        //$totA       = $this->db_erp_pk->query($sql1)->num_rows();

        $totAd      = $this->db_erp_pk->query($sql1)->row_array();
        $totA       =     $totAd['vValue'];
        $totb       = $this->db_erp_pk->query($sql2)->num_rows();
        $hasil_b    =  ($totb + $val7A) / $totA ;

        /*echo $totb.'+'.$val7A.'/'.$totA;
        exit;*/

        $result     = number_format($hasil_b ,2);

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
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>(a) Parameter 7</td>

                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$val7A."</td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>(b) Total Seluruh Produk</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$totb."</td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>(c) Jumlah Formulator</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$totA."</td>
                    </tr>


                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Produktivitas (a+b)/c</td>

                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result."</b></td>
                    </tr>
                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function PD3_getParameter7($post){

        $iPkTransId = $post['_iPkTransId'];
        $val7A = $post['_val7A'];

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



        /*get Support data*/
        $sql1 = "SELECT a.vValue
                from hrd.pk_trans_support_data a
                where a.iPkTransId='".$iPkTransId."'
                and a.iAspekId='".$iAspekId."' ";




        //$totA       = $this->db_erp_pk->query($sql1)->num_rows();

        $totAd      = $this->db_erp_pk->query($sql1)->row_array();
        $totA       =     $totAd['vValue'];

        $html .= "Jumlah Reformulasi : ".$totA;


        /*echo $totb.'+'.$val7A.'/'.$totA;
        exit;*/
        $hasil_b = $totA;

        $result     = number_format($hasil_b ,2);

        $getpoint   = $this->getPoint($result,$iAspekId);
        $x_getpoint = explode("~", $getpoint);
        $point      = $x_getpoint['0'];
        $warna      = $x_getpoint['1'];


        echo $result."~".$point."~".$warna."~".$html;
    }


    function PD3_getParameter13($post){
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


    /*PD3 N14615 End*/


     /*PD 1 (3,4,5,9) ARIES-------------------------------------------------------------------*/
    function PD3_getParameter3($post){

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
                <td style='border: 1px solid #dddddd;' ><b>No UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kategori UPB</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Approval Cek Dokumen Prareg / Cek Dokumen Reg oleh PD</b></td>
            </tr>
        ";


        //Kategory A
        $sql1 ="SELECT pu.`iupb_id`, pu.tconfirm_dok_pd FROM plc2.plc2_upb pu
                WHERE pu.`ldeleted` = 0 AND
                pu.`iteampd_id` = 2 AND pu.`itipe_id` NOT IN(6) AND
                pu.`ikategoriupb_id` = 10 AND pu.iconfirm_dok_pd=1
                AND pu.tconfirm_dok_pd IS NOT NULL AND
                pu.tconfirm_dok_pd between '".$perode1."' AND '".$perode2."'";
        //Non Kategory A
        $sql2x ="SELECT pu.`iupb_id`,pu.vupb_nomor,pu.vupb_nama,pu.ikategoriupb_id, pu.tconfirm_dok_pd FROM plc2.plc2_upb pu
                WHERE pu.`ldeleted` = 0 AND pu.`iteampd_id` = 2 AND pu.`itipe_id` NOT IN(6)
                AND pu.iconfirm_dok_pd=1 AND pu.tconfirm_dok_pd IS NOT NULL AND
                pu.tconfirm_dok_pd between '".$perode1."' AND '".$perode2."' 
                ";

           $sql2 ="
                    select u.tconfirm_dok_pd,u.dconfirm_registrasi_pd,if(u.ineed_prareg=1,'Ya','Tidak') as butuh ,b.vName

                    ,u.* 
            from plc2.plc2_upb u
            join plc2.plc2_biz_process_type b on b.idplc2_biz_process_type=u.itipe_id
            where u.ldeleted=0 #ora di hapus
            and u.ihold=0 #ora di hold
            and u.iteampd_id = 2 #team e PD GP
            and u.ineed_prareg =1
            and u.tconfirm_dok_pd is not NULL #tanggal approve pd ora kosong
            and u.tconfirm_dok_pd !='0000-00-00' #tanggal approve pd ora kosong
             and u.tconfirm_dok_pd between '".$perode1."' AND '".$perode2."'
            
            union    
                     
            select u.tconfirm_dok_pd,u.dconfirm_registrasi_pd,if(u.ineed_prareg=1,'Ya','Tidak') as butuh,b.vName ,u.* 
                        from plc2.plc2_upb u
                        join plc2.plc2_biz_process_type b on b.idplc2_biz_process_type=u.itipe_id
                        where u.ldeleted=0 #ora di hapus
                        and u.ihold=0 #ora di hold
                        and u.iteampd_id = 2 #team e PD GP
                        and u.ineed_prareg =0
                        and u.dconfirm_registrasi_pd is not NULL #tanggal approve pd ora kosong
                        and u.dconfirm_registrasi_pd !='0000-00-00' #tanggal approve pd ora kosong
                         and u.dconfirm_registrasi_pd between '".$perode1."' AND '".$perode2."'

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
                $k='';
                $sqlk ="SELECT u.`vkategori` FROM plc2.`plc2_upb_master_kategori_upb` u WHERE u.`ldeleted`=0 AND  u.`ikategori_id` = '".$v['ikategoriupb_id']."'";
                $kat = $this->db_erp_pk->query($sqlk)->row_array();
                if(empty($kat['vkategori'])){
                    $k = '-';
                }else{
                    $k = $kat['vkategori'];
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$no."</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nama']."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$k."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('d-m-Y',strtotime($v['tconfirm_dok_pd']))."</td>
                          </tr>";
                $no++;
            }
        }

        $html .="</table>";
        $totA       = $this->db_erp_pk->query($sql1)->num_rows();
        $totb       = $this->db_erp_pk->query($sql2)->num_rows();
        if($totb==0){
            $hasil_b    =0;
        }else{
            $hasil_b    = $totA / $totb;
        }
        $result     = number_format($hasil_b * 100,2);
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
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>(a) Total Product Kategory A</td>

                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totA."</td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>(b) Total Seluruh Produk</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'>".$totb."</td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Persentase Produk (a/b * 100%)</td>

                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result." %</b></td>
                    </tr>
                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }
    function PD3_getParameter4($post){

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
                <td style='border: 1px solid #dddddd;' ><b>No UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kategori UPB</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Approval Cek Dokumen Prareg oleh PD</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Approval Prioritas</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Prioritas</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Durasi (Bulan)</b></td>
            </tr>
        ";


        //Kategory A Prareg
        // $sqlto ="SELECT pu.`iupb_id`,pu.vupb_nomor,pu.vupb_nama,pu.ikategoriupb_id, pu.tconfirm_dok_pd, pp.`tappbusdev` FROM plc2.plc2_upb pu JOIN
        //         plc2.`plc2_upb_prioritas_detail` pd ON pd.`iupb_id` = pu.`iupb_id` JOIN
        //         plc2.plc2_upb_prioritas pp ON pp.`iprioritas_id` = pd.`iprioritas_id`
        //         WHERE pu.`ldeleted` = 0 AND
        //         pu.`iteampd_id` = 2 AND pu.`itipe_id` NOT IN(6) AND
        //         pu.`ikategoriupb_id` = 10 AND pu.iconfirm_dok_pd=1
        //         AND pd.`ldeleted` = 0 AND pp.`ldeleted` = 0
        //         AND pu.tconfirm_dok_pd IS NOT NULL
        //         AND pp.`tappbusdev` IS NOT NULL AND
        //         pu.tconfirm_dok_pd between '".$perode1."' AND '".$perode2."'";

      $sqlto ="SELECT pu.`iupb_id`,pu.vupb_nomor,pu.vupb_nama,pu.ikategoriupb_id, pu.tconfirm_dok_pd,pu.iteambusdev_id,
                  (SELECT pp.`tappbusdev` FROM plc2.`plc2_upb_prioritas_detail` pd JOIN
                  plc2.plc2_upb_prioritas pp ON pp.`iprioritas_id` = pd.`iprioritas_id` WHERE
                  pd.`ldeleted` = 0 AND pp.`ldeleted` = 0
                  #and date(pp.`tappbusdev`) <= '2018-12-31'
                  and date(pp.`tappbusdev`) >= '2016-01-01'
                 AND pp.`tappbusdev` IS NOT NULL AND pd.`iupb_id` = pu.iupb_id ORDER BY pp.`iprioritas_id` ASC LIMIT 1)
                  AS `tappbusdev`
              FROM plc2.plc2_upb pu
              WHERE pu.`ldeleted` = 0 AND
              pu.iteampd_id = 2 AND pu.`itipe_id` NOT IN(6) 
              #AND pu.`ikategoriupb_id` = 10 
              AND pu.iconfirm_dok_pd=1
              AND pu.tconfirm_dok_pd IS NOT NULL
              AND pu.ineed_prareg = 1 #butuh prareg
              AND pu.`iupb_id` IN (SELECT DISTINCT(pd.`iupb_id`) FROM plc2.`plc2_upb_prioritas_detail` pd JOIN
                  plc2.plc2_upb_prioritas pp ON pp.`iprioritas_id` = pd.`iprioritas_id` WHERE
                  pd.`ldeleted` = 0 AND pp.`ldeleted` = 0
                  AND pp.`tappbusdev` IS NOT NULL AND pd.`iupb_id` = pu.`iupb_id`) AND

              pu.tconfirm_dok_pd between '".$perode1."' AND '".$perode2."'";

        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $selisih = 0;
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                $tglPrio = $this->getTglPrio($v['iteambusdev_id'],$v['tappbusdev']);
                $durasi = $this->getDurasiBulan(date("Y-m-d",strtotime($tglPrio)),date('Y-m-d', strtotime($v['tconfirm_dok_pd'])));

                $tglPrio = date('Y-m-d', strtotime($tglPrio));
                $tglConfirm = date('Y-m-d', strtotime($v['tconfirm_dok_pd']));
                if($tglPrio > $tglConfirm){
                    $kolor = "red";
                }else{
                    $kolor = "";
                }

                /*$durasi = number_format($this->selisihHari($v['tappbusdev'],$v['tconfirm_dok_pd'],$cNipNya)/22,2);
                if($durasi<0){
                    $durasi = -1 * $durasi;
                }*/
                $selisih += $durasi; 

                // $timeEnd = strtotime($v['tappbusdev']);
                // $timeStart = strtotime($v['tconfirm_dok_pd']);
                // $time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
                //     $time +=  (date("m",$timeEnd)-date("m",$timeStart));
                // if($time <=0){
                //     $durasi = -1*($time);
                // }else{
                //     $durasi = $time;
                // }
                // $selisih += $durasi;


                $k='';
                $sqlk ="SELECT u.`vkategori` FROM plc2.`plc2_upb_master_kategori_upb` u WHERE u.`ldeleted`=0 AND  u.`ikategori_id` = '".$v['ikategoriupb_id']."'";
                $kat = $this->db_erp_pk->query($sqlk)->row_array();
                if(empty($kat['vkategori'])){
                    $k = '-';
                }else{
                    $k = $kat['vkategori'];
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$no."</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nama']."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$k."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($v['tconfirm_dok_pd']))."</td>
                            <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('Y-m-d',strtotime($v['tappbusdev']))."</td>
                            <td style='width:5%;text-align: left;border: 1px solid #dddddd;color:".$kolor."'>
                            ".$tglPrio."</td>
                            <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                                ".$durasi."</td>
                          </tr>";
                $no++;
            }
        }

        $html .="</table>";
        $total      = $no-1;
        if($total<1){
            $result     = number_format(0,2);
        }else{
            $result     = number_format($selisih/$total,2);
        }

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
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Durasi (Bulan)</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$selisih." </b></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Product</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'><B>".$total." </B></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Rata-Rata</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result." Bulan</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }
    function PD3_getParameter5($post){

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

        $html .= "<table class='tabl-detail' cellspacing='0' cellpadding='3' width='100%'>
            <tr style='width:100%; border: 1px solid #f86609; background: #b5f2a6; border-collapse: collapse;text-align: center;'>
                <td style='border: 1px solid #dddddd;' ><b>No</b></td>
                <td style='border: 1px solid #dddddd;' ><b>No UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kategori UPB</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Group Produk</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Approval<br>Cek Dokumen Registrasi<br>Oleh PD</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Approval Prioritas</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Prioritas</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Durasi (Bulan)</b></td>
            </tr>
        ";


        //Kategory A Prareg
        // $sqlto ="SELECT pu.`iupb_id`,pu.vupb_nomor,pu.vupb_nama,pu.ikategoriupb_id, pu.dconfirm_registrasi_pd, pp.`tappbusdev` FROM plc2.plc2_upb pu JOIN
        //         plc2.`plc2_upb_prioritas_detail` pd ON pd.`iupb_id` = pu.`iupb_id` JOIN
        //         plc2.plc2_upb_prioritas pp ON pp.`iprioritas_id` = pd.`iprioritas_id`
        //         WHERE pu.`ldeleted` = 0 AND
        //         pu.`iteampd_id` = 2 AND pu.`itipe_id` NOT IN(6) AND
        //         pu.`ikategoriupb_id` = 10 AND pu.iconfirm_registrasi_pd=1
        //         AND pd.`ldeleted` = 0 AND pp.`ldeleted` = 0
        //         AND pu.dconfirm_registrasi_pd IS NOT NULL
        //         AND pp.`tappbusdev` IS NOT NULL AND
        //         pu.dconfirm_registrasi_pd between '".$perode1."' AND '".$perode2."'";

        $sqlto ="SELECT pu.iupb_id, pu.vupb_nomor, pu.vupb_nama, pu.ikategoriupb_id, pu.dconfirm_registrasi_pd, pu.iteambusdev_id,
                    ( SELECT pp.tappbusdev FROM plc2.plc2_upb_prioritas_detail pd 
                        JOIN plc2.plc2_upb_prioritas pp ON pp.iprioritas_id = pd.iprioritas_id 
                        WHERE pd.ldeleted = 0 AND pp.ldeleted = 0
                            #and date(pp.tappbusdev) <= '2018-12-31'
                            AND DATE(pp.tappbusdev) >= '2016-01-01'
                            AND pp.tappbusdev IS NOT NULL AND pd.iupb_id = pu.iupb_id 
                            ORDER BY pp.iprioritas_id ASC LIMIT 1) AS tappbusdev,
                        b.vNama_Group, k.vKekuatan, vkategori, pu.iGroup_produk, pu.ims_kekuatan
                FROM plc2.plc2_upb pu
                JOIN plc2.master_group_produk b ON b.imaster_group_produk = pu.iGroup_produk
                JOIN plc2.master_kekuatan k ON pu.ims_kekuatan = k.ims_kekuatan
                JOIN plc2.plc2_upb_master_kategori_upb mk on pu.ikategoriupb_id = mk.ikategori_id
                WHERE pu.ldeleted = 0 AND pu.iteampd_id = 2 AND pu.itipe_id NOT IN(6) 
                    #AND pu.ikategoriupb_id = 10 
                    AND pu.iconfirm_registrasi_pd=1
                    AND pu.dconfirm_registrasi_pd IS NOT NULL
                    AND pu.iupb_id IN (
                        SELECT DISTINCT(pd.iupb_id) FROM plc2.plc2_upb_prioritas_detail pd 
                        JOIN plc2.plc2_upb_prioritas pp ON pp.iprioritas_id = pd.iprioritas_id 
                        WHERE pd.ldeleted = 0 AND pp.ldeleted = 0 AND pp.tappbusdev IS NOT NULL AND pd.iupb_id = pu.iupb_id) 
                    AND pu.dconfirm_registrasi_pd between ? AND ? ";

        $b = $this->db_erp_pk->query($sqlto.' ORDER BY pu.iGroup_produk ASC, pu.dconfirm_registrasi_pd DESC', array($perode1, $perode2))->result_array();
        $baseGroup = $this->db_erp_pk->query($sqlto.' GROUP BY pu.iGroup_produk', array($perode1, $perode2))->result_array();

        $arrUPBid = array();
        foreach ($baseGroup as $bg) {
            $grup = $bg['iGroup_produk'];
            $duration = 0;
            $iupb_id = 0;
            foreach ($b as $v) {
                if ($grup == $v['iGroup_produk']){
                    $tglPrio = $this->getTglPrio($v['iteambusdev_id'],$v['tappbusdev']);
                    $durasi = $this->getDurasiBulan($tglPrio,$v['dconfirm_registrasi_pd']);
                    if ($durasi > $duration){
                        $duration = $durasi;
                        $iupb_id = $v['iupb_id'];
                    }
                }
            }
            array_push($arrUPBid, $iupb_id);
        }

        $no = 1;
        $selisih=0;
        if(!empty($b)){
            foreach ($b as $v) {

                /*$timeEnd = strtotime($v['tappbusdev']);
                $timeStart = strtotime($v['dconfirm_registrasi_pd']);
                $time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
                    $time +=  (date("m",$timeEnd)-date("m",$timeStart));
                if($time <=0){
                    $durasi = -1*($time);
                }else{
                    $durasi = $time;
                }*/

                $tglPrio = $this->getTglPrio($v['iteambusdev_id'],$v['tappbusdev']);
                $durasi = $this->getDurasiBulan($tglPrio,$v['dconfirm_registrasi_pd']);
                $kolor = ($tglPrio > $v['dconfirm_registrasi_pd'])?"red":"";
                $color = (fmod($no,2)==0)?"background-color: #eaedce":"";
                if (!in_array($v['iupb_id'], $arrUPBid)){
                    $decoration = "text-decoration: line-through;color:gray;";
                }else{
                    $decoration = "font-weight:bolder;color:#333;";
                    $selisih += $durasi;
                }

                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'>
                            <td style='text-align: center;border: 1px solid #dddddd;".$decoration."' >".$no."</td>
                            <td style='text-align: center;border: 1px solid #dddddd;".$decoration."'>".$v['vupb_nomor']."</td>
                            <td style='text-align: center;border: 1px solid #dddddd;".$decoration."'>".$v['vupb_nama']."</td>
                            <td style='text-align: center;border: 1px solid #dddddd;".$decoration."'>".$v['vkategori']."</td>
                            <td style='text-align: center;border: 1px solid #dddddd;".$decoration."'>".$v['vNama_Group']."</td>
                            <td style='text-align: center;border: 1px solid #dddddd;".$decoration."'>
                                ".date('Y-m-d',strtotime($v['dconfirm_registrasi_pd']))."</td>
                            <td style='text-align: center;border: 1px solid #dddddd;".$decoration."'>
                                ".date('Y-m-d',strtotime($v['tappbusdev']))."</td>
                             <td style='text-align: center;border: 1px solid #dddddd;".$decoration."color:".$kolor."'>
                            ".$tglPrio."</td>
                            <td style='text-align: center;border: 1px solid #dddddd;".$decoration."'>
                                ".$durasi."</td>
                          </tr>";
                $no++;

            }
        }

        $html .="</table>";
        $total      = $no-1;
        if($total<1){
            $result     = number_format(0,2);
        }else{
            $result     = number_format($selisih/$total,2);
        }


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
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Total Durasi (Bulan)</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$selisih." </b></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Product Semua Kategori</td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'><B>".$total." </B></td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Rata-Rata</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result." Bulan</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }
    
   function PD3_getParameter9($post){

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
                <td style='border: 1px solid #dddddd;' ><b>No UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kategori UPB</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Approval Cek Dokumen Prareg oleh PD</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Spesial DDS</b></td>
            </tr>
        ";

        //DDS
        $sql2 ="SELECT pu.`iupb_id`,pu.vupb_nomor,pu.vupb_nama,pu.ikategoriupb_id, pu.imaster_delivery,mds.`iType`, pu.tconfirm_dok_pd FROM plc2.plc2_upb pu
            JOIN plc2.`master_delivery_system` mds ON mds.`imaster_delivery_system` = pu.`imaster_delivery`
            WHERE pu.`ldeleted` = 0 AND pu.`iteampd_id` = 2 AND pu.`itipe_id` NOT IN(6) AND
                pu.tconfirm_dok_pd between '".$perode1."' AND '".$perode2."' ORDER BY mds.`iType` DESC";

        $b = $this->db_erp_pk->query($sql2)->result_array();
        $no = 1;
        $dds = 0;
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }
                $k='';
                $sqlk ="SELECT u.`vkategori` FROM plc2.`plc2_upb_master_kategori_upb` u WHERE u.`ldeleted`=0 AND  u.`ikategori_id` = '".$v['ikategoriupb_id']."'";
                $kat = $this->db_erp_pk->query($sqlk)->row_array();
                if(empty($kat['vkategori'])){
                    $k = '-';
                }else{
                    $k = $kat['vkategori'];
                }


                if($v['iType']==2){
                    $dds++;
                    $ke = 'DDS  -> Draft Delivery Systems';
                }else{
                    $ke = 'NDDS -> Non Draft Delivery Systems';
                }

                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$no."</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nama']."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$k."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('d-m-Y',strtotime($v['tconfirm_dok_pd']))."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>".$ke."</td>
                          </tr>";

                $no++;
            }
        }

        $html .="</table>";
        $totDDS     = $dds;
        $totb       = $this->db_erp_pk->query($sql2)->num_rows();
        $result     = number_format($totDDS,2);
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
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Seluruh Product (Product)</td>

                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totb." </td>
                    </tr>

                    <tr style='border: 1px solid #dddddd; border-collapse: collapse;'>
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Product Spesial DDS (Product)</td>

                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'>".$totDDS." </td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }


    /*------------------END OF PD 1 (3,4,5,9) & 3 (3,4,5,9,11)-------------------------------------------------*/
    function PD3_getParameter1($post){
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
                <td style='border: 1px solid #dddddd;' ><b>No UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tipe UPB</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Team PD</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Butuh Prareg</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Approval <br>Cek Dokumen Prareg</b></td> 
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Cek Dokumen Registrasi oleh PD</b></td> 
            </tr>
        ";


        $sqlto ="
                    select u.tconfirm_dok_pd,u.dconfirm_registrasi_pd,if(u.ineed_prareg=1,'Ya','Tidak') as butuh ,b.vName

                    ,u.* 
            from plc2.plc2_upb u
            join plc2.plc2_biz_process_type b on b.idplc2_biz_process_type=u.itipe_id
            where u.ldeleted=0 #ora di hapus
            and u.ihold=0 #ora di hold
            and u.iteampd_id = 2 #team e PD GP
            and u.ineed_prareg =1
            and u.tconfirm_dok_pd is not NULL #tanggal approve pd ora kosong
            and u.tconfirm_dok_pd !='0000-00-00' #tanggal approve pd ora kosong
             and u.tconfirm_dok_pd between '".$perode1."' AND '".$perode2."'
            
            union    
                     
            select u.tconfirm_dok_pd,u.dconfirm_registrasi_pd,if(u.ineed_prareg=1,'Ya','Tidak') as butuh,b.vName ,u.* 
                        from plc2.plc2_upb u
                        join plc2.plc2_biz_process_type b on b.idplc2_biz_process_type=u.itipe_id
                        where u.ldeleted=0 #ora di hapus
                        and u.ihold=0 #ora di hold
                        and u.iteampd_id = 2 #team e PD GP
                        and u.ineed_prareg =0
                        and u.dconfirm_registrasi_pd is not NULL #tanggal approve pd ora kosong
                        and u.dconfirm_registrasi_pd !='0000-00-00' #tanggal approve pd ora kosong
                         and u.dconfirm_registrasi_pd between '".$perode1."' AND '".$perode2."'

        "; 
 
        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $selisih = 0;
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                $k='';
                $sqlk ="SELECT u.vkategori FROM plc2.plc2_upb_master_kategori_upb u WHERE u.ldeleted=0 AND  u.ikategori_id = '".$v['ikategoriupb_id']."'";
                $kat = $this->db_erp_pk->query($sqlk)->row_array();
                if(empty($kat['vkategori'])){
                    $k = '-';
                }else{
                    $k = $kat['vkategori'];
                }

                $sqlk1 ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$v['iteampd_id']."'";
                $kat1 = $this->db_erp_pk->query($sqlk1)->row_array();
                if(empty($kat1['vteam'])){
                    $k1 = '-';
                }else{
                    $k1 = $kat1['vteam'];
                }

                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'> 
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$no."</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nomor']."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vName']."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nama']."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k1."</td>
                            <td style='width:8%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['butuh']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                ".$v['tconfirm_dok_pd']."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                ".$v['dconfirm_registrasi_pd']."</td>
                          </tr>"; 
                $no++;
            }
        } 

        $html .="</table>";
        $total      = $no-1;  
        if($total<1){
            $result     = number_format(0,0);
        }else{
            $result     = number_format($total,0);
        }

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
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah No Usulan Produk</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result." Produk</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function PD3_getParameter1xx($post){
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
                <td style='border: 1px solid #dddddd;' ><b>No UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kategori UPB</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Butuh Prareg</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Approval <br>Cek Dokumen Prareg / Cek Dokumen Registrasi oleh PD</b></td> 
            </tr>
        ";


        $sqlto ="
                    select u.tconfirm_dok_pd as tanggal,if(u.ineed_prareg=1,'Ya','Tidak') as butuh ,u.* from plc2.plc2_upb u
            where u.ldeleted=0 #ora di hapus
            and u.ihold=0 #ora di hold
            and u.iteampd_id = 2 #team e PD ulujami
            and u.itipe_id not in (6) #group e GP
            and u.ineed_prareg =1
            and u.tconfirm_dok_pd is not NULL #tanggal approve pd ora kosong
            and u.tconfirm_dok_pd !='0000-00-00' #tanggal approve pd ora kosong
             and u.tconfirm_dok_pd between '".$perode1."' AND '".$perode2."'
            
            union    
                     
            select u.dconfirm_registrasi_pd as tanggal,if(u.ineed_prareg=1,'Ya','Tidak') as butuh ,u.* from plc2.plc2_upb u
                        where u.ldeleted=0 #ora di hapus
                        and u.ihold=0 #ora di hold
                        and u.iteampd_id = 2 #team e PD ulujami
                        and u.itipe_id not in (6) #group e GP
                        and u.ineed_prareg =0
                        and u.dconfirm_registrasi_pd is not NULL #tanggal approve pd ora kosong
                        and u.dconfirm_registrasi_pd !='0000-00-00' #tanggal approve pd ora kosong
                         and u.dconfirm_registrasi_pd between '".$perode1."' AND '".$perode2."'

        "; 
 
        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $selisih = 0;
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                $k='';
                $sqlk ="SELECT u.vkategori FROM plc2.plc2_upb_master_kategori_upb u WHERE u.ldeleted=0 AND  u.ikategori_id = '".$v['ikategoriupb_id']."'";
                $kat = $this->db_erp_pk->query($sqlk)->row_array();
                if(empty($kat['vkategori'])){
                    $k = '-';
                }else{
                    $k = $kat['vkategori'];
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'> 
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$no."</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nomor']."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nama']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$k."</td> 
                            <td style='width:8%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['butuh']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                ".date('d-m-Y',strtotime($v['tanggal']))."</td>
                          </tr>"; 
                $no++;
            }
        } 

        $html .="</table>";
        $total      = $no-1;  
        if($total<1){
            $result     = number_format(0,0);
        }else{
            $result     = number_format($total,0);
        }

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
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah No Usulan Produk</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result." Produk</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

     /*PD3 N15748 Start*/
    function PD3_getParameter1x($post){
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
                <td style='border: 1px solid #dddddd;' ><b>No UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kategori UPB</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Approval Cek Dokumen Prareg oleh PD</b></td>
            </tr>
        ";


        $sqlto ="select u.tconfirm_dok_pd,u.* from plc2.plc2_upb u
            where u.ldeleted=0 #ora di hapus
            and u.ihold=0 #ora di hold
            and u.iteampd_id = 2 #team e PD ulujami
            and u.itipe_id not in (6) #group e ulujami
            and u.tconfirm_dok_pd is not NULL #tanggal approve pd ora kosong
            and u.tconfirm_dok_pd !='0000-00-00' #tanggal approve pd ora kosong
            and u.tconfirm_dok_pd between '".$perode1."' AND '".$perode2."'";

        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $selisih = 0;
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                $k='';
                $sqlk ="SELECT u.vkategori FROM plc2.plc2_upb_master_kategori_upb u WHERE u.ldeleted=0 AND  u.ikategori_id = '".$v['ikategoriupb_id']."'";
                $kat = $this->db_erp_pk->query($sqlk)->row_array();
                if(empty($kat['vkategori'])){
                    $k = '-';
                }else{
                    $k = $kat['vkategori'];
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$no."</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nama']."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$k."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                ".date('d-m-Y',strtotime($v['tconfirm_dok_pd']))."</td>
                          </tr>";
                $no++;
            }
        }

        $html .="</table>";
        $total      = $no-1;
        if($total<1){
            $result     = number_format(0,0);
        }else{
            $result     = number_format($total,0);
        }

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
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah No Usulan Produk</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result." Produk</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }
    
    function PD3_getParameter2($post){
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
                <td style='border: 1px solid #dddddd;' ><b>No UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tipe</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Team PD</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Group Produk</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kekuatan</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Approval <br> Cek Dokumen Registrasi oleh PD</b></td> 
            </tr>
        ";


        $sqlto ="SELECT u.dconfirm_registrasi_pd, c.vName, b.vNama_Group, k.vKekuatan, u.* 
                    FROM  plc2.plc2_upb u
                    JOIN plc2.master_group_produk b ON b.imaster_group_produk=u.iGroup_produk
                    JOIN plc2.plc2_biz_process_type c ON c.idplc2_biz_process_type=u.itipe_id
                    JOIN plc2.master_kekuatan k ON u.ims_kekuatan = k.ims_kekuatan
                    WHERE u.ldeleted=0 #ora di hapus
                        AND u.ihold=0 #ora di hold
                        AND u.iteampd_id = 2 #team e PD ulujami
                        #and u.itipe_id not in (6) # untuk ulujami , semua tipe upb
                        AND u.dconfirm_registrasi_pd is not NULL #tanggal approve pd ora kosong
                        AND u.dconfirm_registrasi_pd !='0000-00-00' #tanggal approve pd ora kosong
                        AND u.dconfirm_registrasi_pd  BETWEEN ? AND ? "; 
 
        $b = $this->db_erp_pk->query($sqlto, array($perode1, $perode2))->result_array();
        
        $sqlc = $sqlto;
        $sqlc .= ' GROUP BY u.iGroup_produk, u.ims_kekuatan';

        $countgroup=$this->db_erp_pk->query($sqlc, array($perode1, $perode2))->num_rows();

        $no = 1;
        $selisih = 0;
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                $k='';
                $sqlk ="SELECT u.vkategori FROM plc2.plc2_upb_master_kategori_upb u WHERE u.ldeleted=0 AND  u.ikategori_id = '".$v['ikategoriupb_id']."'";
                $kat = $this->db_erp_pk->query($sqlk)->row_array();
                if(empty($kat['vkategori'])){
                    $k = '-';
                }else{
                    $k = $kat['vkategori'];
                }

                $sqlk1 ="SELECT u.`vteam` FROM plc2.`plc2_upb_team` u WHERE u.`ldeleted`=0 AND  u.`iteam_id` = '".$v['iteampd_id']."'";
                $kat1 = $this->db_erp_pk->query($sqlk1)->row_array();
                if(empty($kat1['vteam'])){
                    $k1 = '-';
                }else{
                    $k1 = $kat1['vteam'];
                }


                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'> 
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$no."</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nomor']."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vName']."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nama']."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$k1."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vNama_Group']."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vKekuatan']."</td> 
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                ".date('d-m-Y',strtotime($v['dconfirm_registrasi_pd']))."</td>
                          </tr>"; 
                $no++;
            }
        } 

        $html .="</table>";
        $total      = $no-1;  
        if($total<1){
            $result     = number_format(0,0);
        }else{
            $result     = number_format($total,0);
        }

        $result = $countgroup;

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
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Produk</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result." Produk</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function PD3_getParameter2x($post){
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
                <td style='border: 1px solid #dddddd;' ><b>No UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kategori UPB</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Approve Cek Dokumen Registrasi PD</b></td>
            </tr>
        ";


        $sqlto ="select u.dconfirm_registrasi_pd,u.* from plc2.plc2_upb u
            where u.ldeleted=0 #ora di hapus
            and u.ihold=0 #ora di hold
            and u.iteampd_id = 2 #team e PD ulujami
            and u.itipe_id not in (6) #group e ulujami
            and u.dconfirm_registrasi_pd is not NULL #tanggal approve pd ora kosong
            and u.dconfirm_registrasi_pd !='0000-00-00' #tanggal approve pd ora kosong
            and u.dconfirm_registrasi_pd between '".$perode1."' AND '".$perode2."'";

        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $selisih = 0;
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                $k='';
                $sqlk ="SELECT u.vkategori FROM plc2.plc2_upb_master_kategori_upb u WHERE u.ldeleted=0 AND  u.ikategori_id = '".$v['ikategoriupb_id']."'";
                $kat = $this->db_erp_pk->query($sqlk)->row_array();
                if(empty($kat['vkategori'])){
                    $k = '-';
                }else{
                    $k = $kat['vkategori'];
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$no."</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nama']."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$k."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                ".date('d-m-Y',strtotime($v['dconfirm_registrasi_pd']))."</td>
                          </tr>";
                $no++;
            }
        }

        $html .="</table>";
        $total      = $no-1;
        if($total<1){
            $result     = number_format(0,0);
        }else{
            $result     = number_format($total,0);
        }

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
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah No Usulan Produk</td>
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result." Produk</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }
    function PD3_getParameter14($post){

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
                <td style='border: 1px solid #dddddd;' ><b>No UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kategori UPB</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Registrasi</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Applet</b></td>
            </tr>
        ";


        //Kategory A Prareg
      /*  $sqlto ="SELECT pu.`iupb_id`,pu.vupb_nomor,pu.vupb_nama,pu.ikategoriupb_id, pu.tconfirm_dok_pd, pp.`tappbusdev`
                FROM plc2.plc2_upb pu
                JOIN plc2.`plc2_upb_prioritas_detail` pd ON pd.`iupb_id` = pu.`iupb_id`
                JOIN plc2.plc2_upb_prioritas pp ON pp.`iprioritas_id` = pd.`iprioritas_id`
                WHERE pu.`ldeleted` = 0
                AND pu.`iteampd_id` = 2
                AND pu.`itipe_id` NOT IN(6)
                AND pu.`ikategoriupb_id` = 10
                AND pu.iconfirm_dok_pd=1
                AND pd.`ldeleted` = 0
                AND pp.`ldeleted` = 0
                AND pu.tconfirm_dok_pd IS NOT NULL
                AND pp.`tappbusdev` IS NOT NULL
                AND pu.tconfirm_dok_pd between '".$perode1."' AND '".$perode2."'"; */


        $sqlto ="SELECT pu.`iupb_id`,pu.vupb_nomor,pu.vupb_nama,pu.ikategoriupb_id
                #, pu.tconfirm_dok_pd, pp.`tappbusdev`
                ,pu.tregistrasi,pu.dinput_applet

                FROM plc2.plc2_upb pu

                WHERE pu.`ldeleted` = 0
                AND pu.`iteampd_id` = 2
                AND pu.`itipe_id` NOT IN(6)

                #Kategori A , tapi di project charter tidak ada keterangan hanya ambil yang kategori A
                #AND pu.`ikategoriupb_id` = 10

                #Tgl Registrasi tidak null
                AND pu.tregistrasi IS NOT NULL
                # Tgl Input Applet tidak null
                AND pu.dinput_applet IS NOT NULL


                AND pu.dinput_applet between '".$perode1."' AND '".$perode2."'";




        $b = $this->db_erp_pk->query($sqlto)->result_array();
        $no = 1;
        $selisih = 0;
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                $timeEnd = strtotime($v['dinput_applet']);
                $timeStart = strtotime($v['tregistrasi']);
                $time = (date("Y",$timeEnd)-date("Y",$timeStart))*12;
                    $time +=  (date("m",$timeEnd)-date("m",$timeStart));
                if($time <=0){
                    $durasi = -1*($time);
                }else{
                    $durasi = $time;
                }


                $selisih += $durasi;


                $k='';
                $sqlk ="SELECT u.`vkategori` FROM plc2.`plc2_upb_master_kategori_upb` u WHERE u.`ldeleted`=0 AND  u.`ikategori_id` = '".$v['ikategoriupb_id']."'";
                $kat = $this->db_erp_pk->query($sqlk)->row_array();
                if(empty($kat['vkategori'])){
                    $k = '-';
                }else{
                    $k = $kat['vkategori'];
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'>
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$no."</td>

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nomor']."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nama']."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$k."</td>
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('d-m-Y',strtotime($v['tregistrasi']))."</td>
                            <td style='width:5%;text-align: left;border: 1px solid #dddddd;'>
                                ".date('d-m-Y',strtotime($v['dinput_applet']))."</td>
                          </tr>";
                $no++;
            }
        }

        $html .="</table>";
        $total      = $no-1;
        if($total<1){
            $result     = number_format(0,0);
        }else{
            $result     = number_format($total,0);
        }

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
                        <td style='width:150px;text-align: left;border: 1px solid #dddddd;'>Total Product </td>
                        <td style='width:100px;text-align: right;border: 1px solid #dddddd;'><B>".$total." </B></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }

    function PD3_getParameter15($post){
        $iAspekId = $post['_iAspekId'];
        $cNipNya  = $post['_cNipNya'];
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
                <td style='border: 1px solid #dddddd;' ><b>No UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tipe UPB</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Nama UPB </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Team Busdev </b></td>
                <td style='border: 1px solid #dddddd;' ><b>Team PD</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Kategori UPB</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Group Produk</b></td>
                <td style='border: 1px solid #dddddd;' ><b>Tanggal Applet</b></td> 
            </tr>
        ";


        $sqlto ="select u.dinput_applet,b.vNama_Group
            ,c.vteam as BDTeam
            ,d.vteam as PDTeam
            ,e.vName
            ,u.* 
            from plc2.plc2_upb u
            join plc2.master_group_produk b on b.imaster_group_produk=u.iGroup_produk
            join plc2.plc2_upb_team c on c.iteam_id = u.iteambusdev_id
            join plc2.plc2_upb_team d on d.iteam_id = u.iteampd_id
            join plc2.plc2_biz_process_type e on e.idplc2_biz_process_type = u.itipe_id
            where u.ldeleted=0 #ora di hapus
            and u.ihold=0 #ora di hold
            and u.iteambusdev_id = 22 # busdev 2
            and u.ikategoriupb_id = 10 # Kategori A
            and u.dinput_applet is not NULL #tanggal applet pd ora kosong
            and u.dinput_applet !='0000-00-00' #tanggal applet pd ora kosong
            and u.dinput_applet between '".$perode1."' AND '".$perode2."'"; 
 
        $b = $this->db_erp_pk->query($sqlto)->result_array();
        
        $sqlc = $sqlto;
        $sqlc .= ' group by u.iGroup_produk';

        $countgroup=$this->db_erp_pk->query($sqlc)->num_rows();

        $no = 1;
        $selisih = 0;
        if(!empty($b)){
            foreach ($b as $v) {
                if (fmod($no,2)==0){
                    $color = 'background-color: #eaedce';
                }else{
                    $color = '';
                }

                $k='';
                $sqlk ="SELECT u.vkategori FROM plc2.plc2_upb_master_kategori_upb u WHERE u.ldeleted=0 AND  u.ikategori_id = '".$v['ikategoriupb_id']."'";
                $kat = $this->db_erp_pk->query($sqlk)->row_array();
                if(empty($kat['vkategori'])){
                    $k = '-';
                }else{
                    $k = $kat['vkategori'];
                }
                $html .= "<tr style='border: 1px solid #dddddd; border-collapse: collapse;".$color."'> 
                            <td style='width:5%;text-align: center;border: 1px solid #dddddd;' >".$no."</td>
                            

                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nomor']."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vName']."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vupb_nama']."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['BDTeam']."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['PDTeam']."</td>
                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>".$k."</td> 
                            <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>
                                ".$v['vNama_Group']."</td> 

                            <td style='width:10%;text-align: center;border: 1px solid #dddddd;'>
                                ".date('d-m-Y',strtotime($v['dinput_applet']))."</td>
                          </tr>"; 
                $no++;
            }
        } 

        $html .="</table>";
        $total      = $no-1;  
        if($total<1){
            $result     = number_format(0,0);
        }else{
            $result     = number_format($total,0);
        }

        $result = $countgroup;

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
                        <td style='width:10%;text-align: left;border: 1px solid #dddddd;'>Jumlah Group</td> 
                        <td style='width:10%;text-align: right;border: 1px solid #dddddd;'><b>".$result." Group</b></td>
                    </tr>

                </table>";
        echo $result."~".$point."~".$warna."~".$html;
    }


    function selisihHari($tglAwal, $tglAkhir, $nip, $type="day"){
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
        if($type=='day'){  
            if($counthr==5){
                $hasil = $selisih-$libur1-$libur2-$libur3;
            }else{
                $hasil = $selisih-$libur1-$libur2;
            }
            if($hasil>=0){
                if(date('H:i:s', strtotime($tglAwal)) > date('H:i:s', strtotime($tglAkhir))){
                    $hasil=$hasil-1;
                }
            } 
            return $hasil;
        } 
    }
    /*End For N15748 Editing*/
}
?>
