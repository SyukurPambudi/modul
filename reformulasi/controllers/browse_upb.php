<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Browse_upb extends MX_Controller {
    function __construct() {
        parent::__construct();
		$this->load->library('auth');
        $this->db = $this->load->database('formulasi', false, true);
    }
    function index($action = '') {
    	//Bikin Object Baru Nama nya $grid		
		$grid = new Grid;		
		$grid->setTitle('List UPB');		
		$grid->setTable('plc2.plc2_upb');		
		$grid->setUrl('browse_upb');
		$grid->addList('no_produk','nama_produk','vKey','pilih');
		$grid->setSql("SELECT a.idossier_upd_id AS pk,a.vUpd_no AS no_produk , a.vNama_usulan AS nama_produk , '2' AS iKey, 'LOKAL' AS vKey 
			FROM dossier.dossier_upd a WHERE a.lDeleted=0 
			-- AND a.idossier_upd_id IN (
			-- 	#untuk pengecekan telah approve basic formula + spesifikasi fg 
			-- 	SELECT iupb_id FROM plc2.plc2_upb_formula 
			-- 	WHERE iapppd_basic = 2 AND iapp_basic = 2 AND iKey = 2 AND iFreformulasi = 1;
			-- )
			UNION 
			SELECT b.iupb_id AS pk ,b.vupb_nomor AS no_produk, b.vupb_nama AS nama_produk , '1' AS iKey, 'EXPORT' AS vKey 
			FROM plc2.plc2_upb b 
			LEFT JOIN plc2.plc2_upb_formula fr ON b.iupb_id = fr.iupb_id
			WHERE b.lDeleted=0 
			-- AND b.iupb_id IN (
			-- 	#untuk pengecekan telah melalui stabilita lab & approve kesimpulan stabilita
			-- 	SELECT fp.iupb_id
			-- 	FROM pddetail.formula_process fp
			-- 	JOIN pddetail.formula_stabilita fs ON fp.iFormula_process = fs.iFormula_process
			-- 	WHERE fs.iApp_formula = '2' AND fp.irefor = '1'
			-- )
			ORDER BY nama_produk ASC");


		$grid->setWidth('no_produk', '70');
		$grid->setWidth('nama_produk', '200');
		$grid->setWidth('vKey', '100');
		$grid->setWidth('pilih', '25');

		$grid->setLabel('no_produk', 'No. Usulan Produk');
		$grid->setLabel('nama_produk', 'Nama Usulan Produk');
		$grid->setLabel('vKey', 'Jenis');	

		$grid->setSearch('no_produk','nama_produk','vKey');
		$grid->setAlign('no_produk', 'center');
		$grid->setAlign('vKey', 'center');
		$grid->setAlign('pilih', 'center');
		//$grid->setRelation('iteambusdev_id', 'plc2.plc2_div_team', 'idplc2_div_team', 'vName','bdTeamName','inner');
		// $grid->setInputGet('pdId', $this->input->get('pdId'));
		// $grid->setRelation('iteampd_id', 'plc2.plc2_upb_team', 'iteam_id', 'vteam','pdTeamName','inner');
		// $grid->setRelation('ikategoriupb_id', 'plc2.plc2_upb_master_kategori_upb', 'ikategori_id', 'vkategori','katUpb','inner');
		
		
		
		switch ($action) {
			case 'json':
				$grid->getJsonData();
				break;			
			default:
				$grid->render_grid();
				break;
		}
    }

	function output(){
    	$this->index($this->input->get('action'));
    }

	function listBox_browse_upb_pilih($value, $pk, $name, $rowData) {
		$o = '<input type="radio" name="pilih" onClick="javascript:pilih_usulan_produk(
				\''.$rowData->no_produk.'\'
				,\''.$rowData->nama_produk.'\'
				,\''.$rowData->iKey.'\'
				,\''.$rowData->pk.'\') ;" />
			<script type="text/javascript">
				function pilih_usulan_produk (no_produk, nama_produk, iKey, pk) {				
					custom_confirm("Yakin", function() {
						$("#mbr_revisi_change_control_no_produk").val(no_produk);
						$("#mbr_revisi_change_control_nama_produk").val(nama_produk);
						$("#alert_dialog_form").dialog("close");
					});
				}
			</script>';
		//'.$pk.','.$rowData->cNamaSup.'
		return $o;
	}
}
