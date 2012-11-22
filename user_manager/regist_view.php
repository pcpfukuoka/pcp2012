<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<META http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
	</head>
	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<?php
		require_once("../lib/dbconect.php");
		$dbcon = DbConnect();

		//権限選択用データ取得
		$sql = "SELECT * FROM m_autho WHERE delete_flg = 0;";
		$result = mysql_query($sql);
		$cnt = mysql_num_rows($result);
		?>

		<form method ="post" action="regist.php">
		<table>
			<tr>
				<td align="center">ユーザID:</td>
				<td align="center"><input type="text" name="user_id"></td>
			</tr>

			<tr>
				<td align="center">パスワード：</td>
				<td align="center"><input type="text" name="pass"></td>
			</tr>

			<tr>
				<td align="center">ユーザ名：</td>
				<td align="center"><input type="text" name="user_name"></td>
			</tr>

			<tr>
				<td align="center">ふりがな：</td>
				<td align="center"><input type="text" name="user_kana"></td>
			</tr>

			<tr>
				<td align="center">住所：</td>
				<td align="center"><input type="text" name="user_address"></td>
			</tr>

			<tr>
				<td align="center">電話番号</td>
				<td align="center"><input type="text" name="user_tel"></td>
			</tr>

			<tr>
				<td align="center">メールアドレス：</td>
				<td align="center"><input type="text" name="user_email"></td>
			</tr>

			<tr>
				<td align="center">権限：</td>
				<td align="center"><select name = "autho_seq" size = "1">
			<option value = "-1">選択</option></td>
			</tr>



			<?php
			for($i = 0; $i < $cnt; $i++)
			{
				$row = mysql_fetch_array($result);
				?>
				<option value = "<?=  $row['autho_seq'] ?>"><?= $row['autho_name'] ?></option>
		<?php
			}
			?>
		</select><br>
		<tr>
			<td>学籍番号※学生のみ</td>
			<td><input type="text" name="stuent_id"></td>
		</tr>
	</table>
		<br>
		<input class="button4"type="submit" value ="登録">
		</form>
		</div>
	</body>
</html>