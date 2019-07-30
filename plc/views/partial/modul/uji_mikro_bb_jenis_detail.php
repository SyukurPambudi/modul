<?php 
	if (empty($datas)) {
		$return ='Data tidak tersedia';	
	}else{
		$return = "<ul>";
			foreach ($datas as $data) {
				$return .= "<li>";
					$return .= $data['vjenis_mikro'];
				$return .= "</li>";
			}
		$return .= "</ul>";
	}

	echo $return ;
 ?>