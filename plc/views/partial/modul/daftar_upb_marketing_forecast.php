<?php 
	/*
		echo $row_value;
		echo "<br>";
		echo $hasTeamID;
	*/

		//print_r($rowDataH);
?>

<?php 
	if($act == 'create'){
		// add new record

?>
		<div class="box-tambah margin_3 grid-list2 ">
			<table style="width: 75%">
				<thead>
					<tr>
						<th style="width: 5%;"> Tahun </th>
						<th> Jumlah <span >*</span></th>
						<th> Marketing Forecast</th>
						<th> Inc(%) <span>*</span></th>

					</tr>
				</thead>
				<tbody>
					</tr>
					<tr>
						<td>
						<input class="input_rows-table2 input_tgl center" onkeypress="return isNumberKey(event)" name="thn1" type="text" >
						</td>
						<td>
						<input class="input_rows-table2 right currency" name="jum1" type="text" onkeypress="return isFloatKey(event)" >
						</td>
						<td>
						<input class="input_rows-table2 right currency" name="for1" type="text" onkeypress="return isFloatKey(event)" >
						</td>
						<td>
						<input class="input_rows-table2 right" onkeypress="return isFloatKey(event)" onchange="TotalCalculation(this.form.jum1,this.form.for1,this.form.inc1,this.form.jum2,this.form.for2)" name="inc1" type="text" >
						</td>
						<td><button type="button" onclick="TotalCalculation(this.form.jum1,this.form.for1,this.form.inc1,this.form.jum2,this.form.for2)" class="btn btn-s submit">Count</button></td>
					</tr>
					<tr>
						<td>
						<input class="input_rows-table2 input_tgl center" onkeypress="return isNumberKey(event)" name="thn2" type="text" >
						</td>
						<td>
						<input class="input_rows-table2 right currency" name="jum2" type="text" onkeypress="return isFloatKey(event)" >
						</td>
						<td>
						<input class="input_rows-table2 right currency" name="for2" type="text" onkeypress="return isFloatKey(event)" >
						</td>
						<td>
						<input class="input_rows-table2 right" onkeypress="return isFloatKey(event)"  onchange="TotalCalculation(this.form.jum2,this.form.for2,this.form.inc2,this.form.jum3,this.form.for3)" name="inc2" type="text" >
						</td>
						<td><button type="button" onclick="TotalCalculation(this.form.jum2,this.form.for2,this.form.inc2,this.form.jum3,this.form.for3)" class="btn btn-s submit">Count</button></td>
					</tr>
					<tr>
						<td>
						<input class="input_rows-table2 input_tgl center" onkeypress="return isNumberKey(event)" name="thn3" type="text" >
						</td>
						<td>
						<input class="input_rows-table2 right" name="jum3" type="text" onkeypress="return isFloatKey(event)">
						</td>
						<td>
						<input class="input_rows-table2 right" name="for3" type="text" onkeypress="return isFloatKey(event)">
						</td>
						<td>
						<input class="input_rows-table2 right" name="inc3" type="text" onkeypress="return isFloatKey(event)">
						</td>
					</tr>
				</tbody>
			</table>
		</div>



<?php 
	}else{
		$row1 = $this->db->get_where('plc2.plc2_upb_forecast', array('iupb_id' => $rowDataH['iupb_id'], 'ino'=>1, 'ldeleted'=>0))->row_array();
		$row2 = $this->db->get_where('plc2.plc2_upb_forecast', array('iupb_id' => $rowDataH['iupb_id'], 'ino'=>2, 'ldeleted'=>0))->row_array();
		$row3 = $this->db->get_where('plc2.plc2_upb_forecast', array('iupb_id' => $rowDataH['iupb_id'], 'ino'=>3, 'ldeleted'=>0))->row_array();


		// form update
?>		
	<div class="box-tambah margin_3 grid-list2 ">
		<table style="width: 75%">
			<thead>
				<tr>
					<th style="width: 5%;"> Tahun </th>
					<th> Jumlah <span >*</span></th>
					<th> Marketing Forecast</th>
					<th> Inc(%) <span>*</span></th>

				</tr>
			</thead>
			<tbody>
				</tr>
				<tr>
					<td>
						<input type="hidden" name="idfor1" value="<?php echo !empty($row1['idplc2_upb_forecast']) ? $row1['idplc2_upb_forecast'] : '' ?>" />
					<input class="input_rows-table2 input_tgl center" onkeypress="return isNumberKey(event)" value="<?php echo !empty($row1['vyear']) ? $row1['vyear'] : '' ?>" name="thn1" type="text" >
					</td>
					<td>
					<input class="input_rows-table2 right currency" onkeypress="return isFloatKey(event)" name="jum1" value="<?php echo !empty($row1['vunit']) ? $row1['vunit'] : '' ?>" type="text" >
					</td>
					<td>
					<input class="input_rows-table2 right currency" onkeypress="return isFloatKey(event)" name="for1" value="<?php echo !empty($row1['vforecast']) ? $row1['vforecast'] : '' ?>" type="text" >
					</td>
					<td>
					<input class="input_rows-table2 right " onkeypress="return isFloatKey(event)" value="<?php echo !empty($row1['vincrement']) ? $row1['vincrement'] : '' ?>" onchange="TotalCalculation(this.form.jum1,this.form.for1,this.form.inc1,this.form.jum2,this.form.for2)" name="inc1" type="text" >
					</td>
					<td><button type="button" onclick="TotalCalculation(this.form.jum1,this.form.for1,this.form.inc1,this.form.jum2,this.form.for2)" class="btn btn-s submit">Count</button></td>
				</tr>
				<tr>
					<td>
						<input type="hidden" name="idfor2" value="<?php echo !empty($row2['idplc2_upb_forecast']) ? $row2['idplc2_upb_forecast'] : '' ?>" />
					<input class="input_rows-table2 input_tgl center" onkeypress="return isNumberKey(event)" value="<?php echo !empty($row2['vyear']) ? $row2['vyear'] : ''  ?>" name="thn2" type="text" >
					</td>
					<td>
					<input class="input_rows-table2 right currency" onkeypress="return isFloatKey(event)" value="<?php echo !empty($row2['vunit']) ? $row2['vunit'] : '' ?>" name="jum2" type="text" >
					</td>
					<td>
					<input class="input_rows-table2 right currency" onkeypress="return isFloatKey(event)" value="<?php echo !empty($row2['vforecast']) ? $row2['vforecast'] : '' ?>" name="for2" type="text" >
					</td>
					<td>
					<input class="input_rows-table2 right" onkeypress="return isFloatKey(event)" value="<?php echo !empty($row2['vincrement']) ? $row2['vincrement'] : '' ?>" onchange="TotalCalculation(this.form.jum2,this.form.for2,this.form.inc2,this.form.jum3,this.form.for3)" name="inc2" type="text" >
					</td>
					<td><button type="button" onclick="TotalCalculation(this.form.jum2,this.form.for2,this.form.inc2,this.form.jum3,this.form.for3)" class="btn btn-s submit">Count</button></td>
				</tr>
				<tr>
					<td>
						<input type="hidden" name="idfor3" value="<?php echo !empty($row3['idplc2_upb_forecast']) ? $row3['idplc2_upb_forecast'] : '' ?>" />
					<input class="input_rows-table2 input_tgl center" onkeypress="return isNumberKey(event)" value="<?php echo !empty($row3['vyear']) ? $row3['vyear'] : '' ?>" name="thn3" type="text" >
					</td>
					<td>
					<input class="input_rows-table2 right" onkeypress="return isFloatKey(event)" value="<?php echo !empty($row3['vunit']) ? $row3['vunit'] : '' ?>" name="jum3" type="text" >
					</td>
					<td>
					<input class="input_rows-table2 right" onkeypress="return isFloatKey(event)" value="<?php echo !empty($row3['vforecast']) ? $row3['vforecast'] : '' ?>" name="for3" type="text" >
					</td>
					<td>
					<input class="input_rows-table2 right" onkeypress="return isFloatKey(event)" value="<?php echo !empty($row3['vincrement']) ? $row3['vincrement'] : '' ?>" name="inc3" type="text" >
					</td>
				</tr>
			</tbody>
		</table>
	</div>
<?php 
	}
 ?>		








