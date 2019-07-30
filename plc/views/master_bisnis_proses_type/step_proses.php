<select class="multiselect" style="width: 500px; height: 200px;" multiple="multiple" name="steps[]" >
	<?php
		foreach($steps as $step) {
			echo '<option '.$step['selected'].' value="'.$step['idplc2_biz_has_steps'].'">'.$step['vStepName'].'</option>';
		}
	?>
</select>