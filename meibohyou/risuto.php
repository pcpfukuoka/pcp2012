<html>
	<head>
		<title>リスト</title>
	</head>
	<body>
				<form action="kakunin.php" method="POST">
<?php
	mysql_connect("105-pc","root","");
	mysql_select_db("sample");

	mysql_query("SET NAMES sjis");

		$sql = "select student_id, student_name, sex, class from namelist";
		$result = mysql_query($sql);
		
	$kensu = mysql_num_rows($result);
?>


		
		<table border="1" width="100%">
			<tr>
				<th width="10%">出席番号</th>
				<th width="10%">氏名</th>
				<th width="10%">性別</th>
				<th width="10%">クラス</th>
				<th width="10%">委員会</th>
				<th width="10%">給食当番</th>
				<th width="10%">清掃区域</th>
				<th width="10%">クラブ活動</th>
				
			</tr>
<?php
	for($i=0; $i<$kensu; $i++){
		$gyo = mysql_fetch_array($result);
?>
			

					<td><?= $gyo[0] ?></td>
					<td><?= $gyo[1] ?></td>
					<td><?= $gyo[2] ?></td>
					<td><?= $gyo[3] ?></td>

					<td>
						<select name="iinkai" style="width:130" td bgcolor="blue">
							<option value="" selected></option>
							<option value="">学級</option>
							<option value="">文化</option>
							<option value="">保健</option>
							<option value="">体育</option>
							<option value="">風紀</option>
							<option value="">音楽</option>
							<option value="">放送</option>
							<option value="">図書</option>
							<option value="">給食</option>
							<option value="">園芸</option>
							<option value="">運営</option>
						</select>
					</td>
					<td>
						<select name="touban" style="width:130">
							<option value="" selected></option>
							<option value="">米,パン</option>
							<option value="">温食</option>
							<option value="">サラダ</option>
							<option value="">牛乳</option>
							<option value="">フルーツ</option>
						</select>
					</td>
					<td>
						<select name="seisou" style="width:130">
							<option value="" selected></option>
							<option value="">教室</option>
							<option value="">廊下</option>
							<option value="">渡り廊下</option>
							<option value="">職員室</option>
							<option value="">校長室</option>
							<option value="">特別室</option>
							<option value="">トイレ</option>
							<option value="">体育館</option>
							<option value="">図書室</option>
							<option value="">階段</option>
						</select>
					</td>
					<td>
						<select name="club" style="width:130">
							<option value="" selected></option>
							<option value=""></option>
							<option value=""></option>
							<option value="">/option>
							<option value=""></option>
							<option value=""></option>
							<option value=""></option>
							<option value=""></option>
							<option value=""></option>
							<option value=""></option>
							<option value=""></option>
						</select>
						<tr></tr>

				</td>
<?php
	}
?>
		</table>
			<input type="submit" value="確認">&nbsp;&nbsp;
			<input type="reset" value="クリア">
	</body>
</html>