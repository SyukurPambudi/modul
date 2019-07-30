<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['plc_dept'] = array('AD','BD','DR','FA','MR','PD','PR','QA','QC','BIC','MIS','BDI','IR','IM','TD');
$config['plc_level'] = array(1,2,3,4,5,6);
$config['IR_Status'] = array(
    '7' => 'IR Need to be Submitted',
    '1' => 'IR Need Requester Superior Approval (lv. Manager)',
    '2' => 'IR Need PD Manager Approval',
    'G' => 'IR Need Sourcing Mail',
    'H' => 'IR Need Quotation',
    'P' => 'PO Need to be Generated',
    'F' => 'PO Already Generated',
    'M' => 'Rejected By M.I.S.',
    'S' => 'Rejected By Requester Superior',
    'D' => 'Rejected By PD Manager Approval',
    'X' => 'Rejected By Head Buyer',
);