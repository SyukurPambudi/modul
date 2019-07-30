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