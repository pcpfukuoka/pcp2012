<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<META http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
	</head>
	<body>		
		<?php 
		require_once("../lib/dbconect.php");
		$dbcon = DbConnect();
		
		//権限選択用データ取得
		$sql = "SELECT * FROM m_autho WHERE delete_flg = 0;";
		$result = mysql_query($sql);
		$cnt = mysql_num_rows($result);
		?>
		
		<form method ="post" action="regist.php">
		ユーザID:<input type="text" name="user_id"><br>
		パスワード：<input type="text" name="pass"><br>
		ユーザ名：<input type="text" name="user_name"><br>
		ふりがな：<input type="text" name="user_kana"><br>
		住所：<input type="text" name="user_address"><br>
		電話番号<input type="text" name="user_tel"><br>
		メールアドレス：<input type="text" name="user_email"><br>
		権限：
		<select name = "autho_seq" size = "1">
			<option value = "-1">選択</option>
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
		
		学籍番号※学生のみ<input type="text" name="stuent_id"><br>
		<input class="button4"type="submit" value ="登録">
		</form>		
	</body>
</html>