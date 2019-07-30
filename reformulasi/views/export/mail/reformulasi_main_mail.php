<?php
$tittle = isset($tittle)? $tittle:'-';
$menuapp = isset($menuapp)? $menuapp:'-';
$caption = isset($caption)? $caption:'-';
$link_aplikasi = "http://www.npl-net.com/erp";
?>
<style type="text/css">
table.tbl3 {border-collapse: collapse; border: 1px solid black; font-size: 12px;}

tr.tr3, th.th3, th.thHdr3, td.td3 {border: none; background: #ececec;}
</style>
<p>Kepada Yth. Bapak/Ibu,</p>
<p><?php echo $caption ?></p>
<br/>
<table class="tbl3" width="100%" border="1" cellspacing="4" cellpadding="4">
	<?php 
	foreach ($cdata as $kd => $vd) {
		$caption=isset($capdata[$kd])?$capdata[$kd]:"";
		echo "<tr><td class='td3'>".$caption."</td><td>".$vd."</td></tr>";
	}
	
	?>
	<tr><td class="td3">Link Aplikasi</td><td><a href="<?php echo $link_aplikasi;?>" title="erp" target="_blank"><?php echo $link_aplikasi;?></a></td></tr>
	<tr><td class="td3">Menu Aplikasi</td><td><?php echo $menuapp;?></td></tr>
</table>