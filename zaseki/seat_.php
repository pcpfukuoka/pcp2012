<html>
	<head>
		<title>zaseki</title>
	</head>
	<body>
		<form action="seat_list2.php" method="POST">
		<table>
			<tr>
				<td>
				行
				</td>
				<td>
					<select name = "row">
					<option value = "1">1</option>
					<option value = "2">2</option>
					<option value = "3">3</option>
					<option value = "4">4</option>
					<option value = "5">5</option>
					<option value = "6">6</option>
					</select>
				</td>
			</tr>

			<tr>
				<td>
				列
				</td>
				<td>
					<select name = "col">
					<option value = "1">1</option>
					<option value = "2">2</option>
					<option value = "3">3</option>
					<option value = "4">4</option>
					<option value = "5">5</option>
					<option value = "6">6</option>
					</select>


					<input type="hidden" value="row">
					<input type="hidden" value="col">

				</td>
			</tr>

		</table>
		<input type="submit" value="変更">

		</form>
	</body>
</html>