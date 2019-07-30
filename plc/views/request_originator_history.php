<input type="text" min="0" id="upb_request_originator_ireq_ke" name="upb_request_originator_ireq_ke" value ='<?php echo $jumlah ?>' size="3" readonly='readonly'> <br>
<table style = "margin-top:10px; width:90%;"cellspacing="0" cellpadding="0" border="0" style="width: 100%;" id="grid_master_category" tabindex="1" role="grid" aria-multiselectable="false" aria-labelledby="gbox_grid_master_category" class="ui-jqgrid-btable">
                        <thead>
                            <th class="ui-state-default ui-th-column ui-th-ltr" role="columnheader" id="grid_history_originator" style="width: 2%;">
                                <span class="ui-jqgrid-resize ui-jqgrid-resize-ltr" style="cursor: col-resize;">&nbsp;</span>
                                    <div id="jqgh_grid_history_originator" class="ui-jqgrid-sortable">No
                                        <span style="display:none" class="s-ico">
                                            <span class="ui-grid-ico-sort ui-icon-asc ui-state-disabled ui-icon ui-icon-triangle-1-n ui-sort-ltr" sort="asc">
                                        </span>
                                    </div>
                                </span>
                            </th>

                            <th class="ui-state-default ui-th-column ui-th-ltr" role="columnheader" id="grid_history_originator" style="width: 13%;">
                                <span class="ui-jqgrid-resize ui-jqgrid-resize-ltr" style="cursor: col-resize;">&nbsp;</span>
                                    <div id="jqgh_grid_history_originator" class="ui-jqgrid-sortable">No Request
                                        <span style="display:none" class="s-ico">
                                            <span class="ui-grid-ico-sort ui-icon-asc ui-state-disabled ui-icon ui-icon-triangle-1-n ui-sort-ltr" sort="asc">
                                        </span>
                                    </div>
                                </span>
                            </th>
                            <th class="ui-state-default ui-th-column ui-th-ltr" role="columnheader" id="grid_history_originator" style="width: 20%;">
                                <span class="ui-jqgrid-resize ui-jqgrid-resize-ltr" style="cursor: col-resize;">&nbsp;</span>
                                    <div id="jqgh_grid_history_originator" class="ui-jqgrid-sortable">Tgl Request
                                        <span style="display:none" class="s-ico">
                                            <span class="ui-grid-ico-sort ui-icon-asc ui-state-disabled ui-icon ui-icon-triangle-1-n ui-sort-ltr" sort="asc">
                                        </span>
                                    </div>
                                </span>
                            </th>
                            <th class="ui-state-default ui-th-column ui-th-ltr" role="columnheader" id="grid_history_originator" style="width: 20%;">
                                <span class="ui-jqgrid-resize ui-jqgrid-resize-ltr" style="cursor: col-resize;">&nbsp;</span>
                                    <div id="jqgh_grid_history_originator" class="ui-jqgrid-sortable">Tgl Approve
                                        <span style="display:none" class="s-ico">
                                            <span class="ui-grid-ico-sort ui-icon-asc ui-state-disabled ui-icon ui-icon-triangle-1-n ui-sort-ltr" sort="asc">
                                        </span>
                                    </div>
                                </span>
                            </th>
                            <th class="ui-state-default ui-th-column ui-th-ltr" role="columnheader" id="grid_history_originator" style="width: 20%;">
                                <span class="ui-jqgrid-resize ui-jqgrid-resize-ltr" style="cursor: col-resize;">&nbsp;</span>
                                    <div id="jqgh_grid_history_originator" class="ui-jqgrid-sortable">Approve By
                                        <span style="display:none" class="s-ico">
                                            <span class="ui-grid-ico-sort ui-icon-asc ui-state-disabled ui-icon ui-icon-triangle-1-n ui-sort-ltr" sort="asc">
                                        </span>
                                    </div>
                                </span>
                            </th>
                        </tr>
                        </thead>        
                        <tbody>
                        <?php 
                            $i = 1;
                            foreach($datanya as $data) {
                                if ($data['vnip_apppd']!='') {
                                    $sql_user='select * from employee e where e.cNip ="'.$data['vnip_apppd'].'" ';
                                    $user= $this->dbset2->query($sql_user)->row_array();
                                    $approve_by=$user['vName'];
                                }else{
                                    $approve_by='-';
                                }
                            	
                        ?>
                               <tr class="ui-widget-content jqgrow ui-row-ltr" role="row" id="param_id">
                                   <td class="ui-state-default jqgrid-rownum" style="text-align:right; width:5%;" role="gridcell"><?php echo $i ?></td>
                                   <td style="text-align:center; width:5%;" ><?php echo $data['vreq_ori_no'] ?></td>
                                   <td style="text-align:center; width:5%;" ><?php echo $data['tcreate'] ?></td>
                                   <td style="text-align:center; width:5%;" ><?php echo $data['tapppd'] ?></td>
                                   <td style="text-align:center; width:5%;" > <?php echo $approve_by  ?></td>
                               </tr>
                      <?php 
                        $i++;
                        }   
                      ?>
                        </tbody>
                    </table>