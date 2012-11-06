<script type="text/javascript">
var counter = 0;
function AddTableRows(){
	// カウンタを回す
	counter++;

	var table1 = document.getElementById("table1");
	var row1 = table1.insertRow(counter);
	var cell1 = row1.insertCell(0);
	var cell2 = row1.insertCell(1);



	cell1.setAttribute("class","name");
	cell2.setAttribute("class","address");

	cell1.className = 'name';
	cell2.className = 'address';

	var HTML1 = '<input type="text" name="name' + counter + '" value="" size="10" maxlength="20" />';
	var HTML2 = '<input type="text" name="address' + counter + '" value="" size="10" maxlength="20" />';

	cell1.innerHTML = HTML1;
	cell2.innerHTML = HTML2;
}
</script>

<table border="1" cellspacing="0" cellpadding="4" id="table1">
    <th></th>
	<tr>
    <td class="name"><input type="text" name="name0" value="" size="10" maxlength="20" /></td>
    <td class="address"><input type="text" name="address0" value="" size="10" maxlength="20" />
    </td>
  </tr>
</table>
<form method="GET" action="#">
  <input type="radio" value="追加" onClick="AddTableRows();" />1<br>
  <input type="radio" value="追加" onClick="AddTableRows();" />2<br>
  <input type="radio" value="追加" onClick="AddTableRows();" />3<br>
  <input type="radio" value="追加" onClick="AddTableRows();" />4<br>
</form>
