<?php
	$class = $_POST['class'];
	$row_max = $_POST['row'];
	$col_max = $_POST['col'];
?>

<html>
	<body>
	<form action="seat_register_add.php" method="POST">
		<table border="1">
<?php
	for($row = 1; $row <= $row_max; $row++)
	{
		echo "<tr>";
		for($col = 1; $col <= $col_max; $col++)
		{
			echo "<td>";
			//echo "<input name=student[row][]type=text>";
?>
			<input name="attendance_no<?= $row?>[<?= $col?>]"type=text>
<?php
			echo "</td>";


		}
		echo "</tr>";
	}

		echo "<input name=class type=hidden value=$class>";
		echo "<input name=row_max type=hidden value=$row_max>";
		echo "<input name=col_max type=hidden value=$col_max>";
?>
		</table>

		<input type="submit" value="登録">
	</form>
	</body>
</html>