<?php
$module=isset($module)?$module:"-";
$headerCaption=isset($headerCaption)?$headerCaption:"-";
$vupb_nomor=isset($rowUPB['vupb_nomor'])?$rowUPB['vupb_nomor']:"-";
$vupb_nama=isset($rowUPB['vupb_nama'])?$rowUPB['vupb_nama']:"-";
$vgenerik=isset($rowUPB['vgenerik'])?$rowUPB['vgenerik']:"-";
$tRegistrasi_req_doc=isset($rowUPB['tRegistrasi_req_doc'])?$rowUPB['tRegistrasi_req_doc']:"-";
$link_aplikasi = "www.npl-net.com/erp";
?>
<html>
<head>
<title>Revise Service Request</title>
<style type="text/css">
table.tbl3 {border-collapse: collapse; border: 1px solid black; font-size: 12px;}

tr.tr3, th.th3, th.thHdr3, td.td3 {border: none; background: #ececec;}
</style>
</head>
<body>
<p>Kepada Yth. Bapak/Ibu,</p>
<p><?php echo $headerCaption ?></p>
<br/>
<table class="tbl3" width="100%" border="1" cellspacing="4" cellpadding="4">
	<tr><td class="td3">No. UPB</td><td><?php echo $vupb_nomor;?></td></tr>
	<tr><td class="td3">Nama Usulan</td><td><?php echo $vupb_nama;?></td></tr>
	<tr><td class="td3">Nama Generik</td><td><?php echo $vgenerik;?></td></tr>
	<tr><td class="td3">Dokumen Revisi</td><td><?php echo $tRegistrasi_req_doc;?></td></tr>
	<tr><td class="td3">Link Aplikasi</td><td><a href="<?php echo $link_aplikasi;?>" title="erp" target="_blank"><?php echo $link_aplikasi;?></a></td></tr>
	<tr><td class="td3">Menu Aplikasi</td><td>PLC -- Lokal -- <?php echo $module ?></td></tr>
</table>
</body>
</html>