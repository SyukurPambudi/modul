<?php
/**
 * Created by PhpStorm.
 * User: Yandi.Prabowo
 * Date: 12/29/2015
 * Time: 9:41 AM
 */


$data_a = array();
$id =   $_ci_data['_ci_vars']['iupb_id'];
$this->load->model('gantt_model');
$data = $this->gantt_model->getBizStep();
$rowCount = count($data);

$upbNo = $this->gantt_model->getUpbNo($id);
$upbInfo = $this->gantt_model->getUpbInfo($id);
$i = 0;
while ($i < 30) {
    $count = count($upbInfo);
    if ($count > 0) {
        $vStepName = $data[$i]['vStepName'];
        $color = 'default';
        if($i==0 || $i==3 || $i==7){
            $dStart1 = date('Y-m-d',strtotime($upbInfo['dStart_A' . $i]));
            $dEnd1 = date('Y-m-d',strtotime($upbInfo['dEnd_A' . $i]));
            $dEnd2 = date('Y-m-d',strtotime($upbInfo['dEnd_B' . $i]));

            if ($i == 0){
                $note1 = 'Input/Approval BD';
                $note2 = 'Approval Direksi';
            }elseif($i == 3){
                $note1 = 'Pengiriman oleh BD';
                $note2 = 'Penerimaan oleh PD';
            }elseif($i == 3){
            $note1 = 'Penerimaan oleh PD';
            $note2 = 'Penerimaan oleh QA';
            }
            if ($dStart1 != '1970-01-01' ) {
                $data_a[$i] = getTigaTanggal($dStart1, $dEnd1, $dEnd2, $vStepName, $note1, $note2);
            }
        }else{
            $dStart1 = date('Y-m-d',strtotime($upbInfo['dStart' . $i]));
            $dEnd1 = date('Y-m-d',strtotime($upbInfo['dEnd' . $i]));

            if ($dStart1 != '1970-01-01' ){
                $data_a[$i] = getDuaTanggal($dStart1,$dEnd1,$vStepName);
            }

        }
    }
    $i++;
}
$array_data = array(array('label'=>'','series'=> $data_a));
$gantt_graph = new GanttChart( 'pt_BR' );
$gantt_graph->setData( $array_data )
            ->render();

function getDateTimeInterval($dt1, $dt2) {
    $dt1 = new DateTime($dt1);
    $dt2 = new DateTime($dt2);
    return $dt1->diff($dt2);
}

function getTigaTanggal($dStart1,$dEnd1,$dEnd2,$vStepName,$note1,$note2){

    $color = 'default';

    $diff1 =  getDateTimeInterval($dEnd1,$dStart1);
    $diff1 =  $diff1->format('%Y year,%m month, %d days');
    $description1 = "Proses: ".$vStepName .": ".$note1."\n". "Start Date: " . $dStart1."\n".
        "End Date: " . $dEnd1."\n"."Duration: ".$diff1;

    $diff2 =  getDateTimeInterval($dEnd2,$dEnd1);
    $diff2 =  $diff2->format('%Y year,%m month, %d days');
    $description2 = "Proses: ".$vStepName .": ".$note2."\n". "Start Date: " . $dEnd1."\n".
        "End Date: " . $dEnd2."\n"."Duration: ".$diff2;

    if ($dEnd1 == NULL || $dEnd1 == '1970-01-01') {
        $now = new DateTime();
        $dEnd1 = $now->format("Y-m-d H:i:s");
        $color = '#980000';
        $diff1 =  getDateTimeInterval($dEnd1,$dStart1);
        $diff1 =  $diff1->format('%Y year,%m month, %d days');
        $description1 = "Proses: ".$vStepName .": ".$note1."\n". "Start Date: " . $dStart1."\n".
            "End Date: -" . "\n"."Duration: ".$diff1;

        $data_a =
            array(
                'label' => $vStepName,
                'allocations' => array(
                    array(
                        'label' => $vStepName,
                        'start' => $dStart1,
                        'end' => $dEnd1,
                        'description' => $description1,
                        'color' => $color,
                    ),
                ),

            );
    }else {
        $dtgl = date('Y-m-d',strtotime($dEnd1 . "+1 days"));
        $dStart2 = $dtgl;
        if ($dEnd2 == NULL || $dEnd2 == '1970-01-01') {
            $now = new DateTime();
            $dEnd2 = $now->format("Y-m-d H:i:s");
            $color = '#980000';
            $diff2 =  getDateTimeInterval($dEnd2,$dEnd1);
            $diff2 =  $diff2->format('%Y year,%m month, %d days');
            $description2 = "Proses: ".$vStepName .": ".$note2."\n". "Start Date: " . $dStart2."\n".
                "End Date: -" . "\n"."Duration: ".$diff2;
        }

        $data_a =
            array(
                'label' => $vStepName,
                'allocations' => array(
                    array(
                        'label' => $vStepName." : ".$note1,
                        'start' => $dStart1,
                        'end' => $dEnd1,
                        'description' => $description1,
                        'color' => 'default',
                    ),
                    array(
                        'label' => $vStepName." : ".$note2,
                        'start' => $dStart2,
                        'end' => $dEnd2,
                        'description' => $description2,
                        'color' => $color,
                    ),
                ),

            );
    }
    return $data_a;
}

function getDuaTanggal($dStart1,$dEnd1,$vStepName){
    $color = 'default';

    $diff1 =  getDateTimeInterval($dEnd1,$dStart1);
    $diff1 =  $diff1->format('%Y year,%m month, %d days');
    $description1 = "Proses: ".$vStepName ."\n". "Start Date: " . $dStart1."\n".
        "End Date: " . $dEnd1."\n"."Duration: ".$diff1;

    if ($dEnd1 == NULL || $dEnd1 == '1970-01-01') {
        $now = new DateTime();
        $dEnd1 = $now->format("Y-m-d H:i:s");
        $color = '#980000';
        $description1 = "Proses: ".$vStepName ."\n". "Start Date: " . $dStart1."\n".
            "End Date: -" . "\n"."Duration: -";

    }
    $data_a =
        array(
            'label' => $vStepName,
            'allocations' => array(
                array(
                    'label' => $vStepName." : Input/Approval",
                    'start' => $dStart1,
                    'end' => $dEnd1,
                    'description' => $description1,
                    'color' => $color,
                ),
            ),

        );
    return $data_a;
}