<?php 
	$label 		= str_replace($field, 'form_detail_'.$field, $id);

	if ($act == 'create'){
		echo '<p><b>Save First...!!!</b></p>';
	} else {
		$url2   	= base_url().'processor/reformulasi/v3/export/stress/kesimpulan/';
	    $urlParam 	= $url2.'?iexport_formulasi='.$rowDataH['iexport_formulasi'].'&company_id='.$this->input->get('company_id').'&modul_id='.$this->input->get('modul_id').'&group_id='.$this->input->get('group_id'); 

	    $return      = '<table id="'.$id.'" width="99%" style="margin:5px;">';
	    $return     .= '<tr>';
	    $return     .= '    <td>';
	    $return     .= '        <script type="text/javascript">';
	    $return     .= '            $(document).ready(function() {    
	                                    $("#'.$this->url.'_setup_application").tabs();                       
	                                    browse_tab(\''.$urlParam.'\',\'GROUP\', \''.$this->url.'_group\');  
	                                }); ';
	    $return     .= '        </script>';
	    $return     .= '        <div id="'.$this->url.'_setup_application" width="100%">';
	    $return     .= '            <ul  style="display: none;">                        
	                                    <li><a href="#'.$this->url.'_group">Setup Fields</a></li>
	                                </ul>                      
	                                <div id="'.$this->url.'_group"></div>
	                            </div> ';
	    $return     .= '    </td>';            
	    $return     .= '<tr>';            
	    $return     .= '</table>';

	    echo $return;

	    ?>
			<script type="text/javascript">
				$("label[for='<?php echo $label; ?>']").css({"border": "1px solid #dddddd", "background": "#548cb6", "border-collapse": "collapse","width":"99%","font-weight":"bold","color":"#ffffff","text-shadow": "0 1px 1px rgba(0, 0, 0, 0.3)","text-transform": "uppercase","text-align": "center","padding":"5px","margin-top":"10px"});
				$("#<?php echo $id; ?>").parent().removeClass('rows_input');
			</script>
	    <?php
	}


?>
