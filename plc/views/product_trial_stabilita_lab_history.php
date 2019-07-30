<style type="text/css">
	table.hover_table tr:hover {
		
	}
</style>
<table class="hover_table" id="best_formula_detail" cellspacing="0" cellpadding="1" style="width: 98%; border: 1px solid #dddddd; text-align: center; margin-left: 5px; border-collapse: collapse">
	<thead>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #548cb6; border-collapse: collapse">
		<th colspan="7" style="border: 1px solid #dddddd;"><span style="font-weight: bold; color: #ffffff; text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3); text-transform: uppercase;">Stabilita Laboraturium Formula : <?php echo $vkode_surat; ?></span></th>
	</tr>
	<tr style="width: 98%; border: 1px solid #dddddd; background: #b3d2ea; border-collapse: collapse">
		<th style="border: 1px solid #dddddd;">No</th>
		<th style="border: 1px solid #dddddd;">Stabilita Bulan</th>
		<th style="border: 1px solid #dddddd;">Tanggal</th>
		<th style="border: 1px solid #dddddd;">Real Time Test</th>
		<th style="border: 1px solid #dddddd;">Accelerated Test</th>
		<th style="border: 1px solid #dddddd;">Status</th>
		<th style="border: 1px solid #dddddd;">Approval</th>
	</tr>
	</thead>
	<tbody>
		<?php
			
			$sql="select * from plc2.plc2_upb_stabilita st where st.ifor_id=$ifor_id and st.ista_id <> $ista_id";
			//echo $sql;
			$res=$this->db_plc0->query($sql)->result_array();
			$n = 1;
			$x=0;
						
			foreach($res as $r) {
		?>
		<tr style="border: 1px solid #dddddd; border-collapse: collapse; background: #ffffff; ">
			<td style="border: 1px solid #dddddd; width: 3%; text-align: center;">
				<span class="master_sediaan_produk_spek_num"><?php echo $n;?></span>
			</td>		
			<td style="border: 1px solid #dddddd; width: 7%;">
				<?php echo $r['inumber']; ?>
			</td>	
			<td style="border: 1px solid #dddddd; width: 12%">
				<?php echo $r['tdate']; ?>
			</td>
			<td style="border: 1px solid #dddddd; width: 20%;">
				<?php echo $r['vrealtime']; ?>
			</td>	
			<td style="border: 1px solid #dddddd; width: 20%">
				<?php echo $r['vaccelerate']; ?>
			</td>
			<td style="border: 1px solid #dddddd; width: 15%;">
				<?php  
					if($r['isucced']==0){ echo "Belum Stabilita";}
					elseif($r['isucced']==1){ echo "Tidak Memenuhi Syarat";}
					elseif($r['isucced']==2){ echo "Memenuhi Syarat";}
				?>
			</td>
			<td style="border: 1px solid #dddddd; width: 20%">
				<?php
					$x=$r['vnip_apppd'];
					$sel2="select * from hrd.employee h where h.cNip='$x'";
					$res2=$this->db_plc0->query($sel2)->row_array();
					if($r['iapppd']==1){$echo="Rejected";}
					elseif($r['iapppd']==2){$echo="Approved";}
					echo $echo.' oleh '.$res2['vName'].' ( '.$r['vnip_apppd'].' )'.' pada '.$r['tapppd'];
				?>
			</td>
		</tr>
		<?php
				$n++;
			}
		?>
	</tbody>
</table>