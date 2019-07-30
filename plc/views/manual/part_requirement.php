<h3>Inject Information Modul <?php echo $mod['vNama_modul']; ?> </h3>
<hr>
<div id="isi_requirement" class="tabel3">
	<ul>
		<?php foreach ($reqs as $req ) {
		?>
			<li style="margin-left: 2%;"><?php echo $req['vParameter'] ?></li>	
		<?php 

		} ?>
	</ul>
</div>