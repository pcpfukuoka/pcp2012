<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<META http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
	</head>
	<body>
		<img class="bg" src="../../images/blue-big.jpg" alt="" />
			<div id="container">
		<?php
		if(!isset($_GET['id']))
		{
			header("Location: ../dummy.html");
		}
		else
		{
			$user_seq = $_GET['id'];
		}

		require_once("../lib/dbconect.php");
		$dbcon = DbConnect();

		//権限選択用データ取得
		$sql = "SELECT * FROM m_autho WHERE delete_flg = 0;";
		$result_autho = mysql_query($sql);
		$cnt = mysql_num_rows($result_autho);

		//選択ユーザ情報データ取得
		$sql = "SELECT m_user.user_seq,user_name,user_kana,user_address,user_tel,user_email,user_id,pass,autho_seq,student_id FROM m_user LEFT JOIN m_student ON m_user.user_seq = m_student.user_seq WHERE m_user.delete_flg = 0 AND m_user.user_seq = '$user_seq'";
		$result_user = mysql_query($sql);
		$user_row = mysql_fetch_array($result_user);
		?>

		<form method ="post" action="change.php">
		ユーザID:<input type="text" name="user_id" value="<?= $user_row['user_id'] ?>"><br>
		パスワード：<input type="text" name="pass" value="<?= $user_row['pass'] ?>"><br>
		ユーザ名：<input type="text" name="user_name" value="<?= $user_row['user_name'] ?>"><br>
		ふりがな：<input type="text" name="user_kana" value="<?= $user_row['user_kana'] ?>"><br>
		住所：<input type="text" name="user_address" value="<?= $user_row['user_address'] ?>"><br>
		電話番号<input type="text" name="user_tel" value="<?= $user_row['user_tel'] ?>"><br>
		メールアドレス：<input type="text" name="user_email" value="<?= $user_row['user_email'] ?>"><br>
		権限：
		<select name = "autho_seq" size = "1">
			<option value = "-1">選択</option>
			<?php
			for($i = 0; $i < $cnt; $i++)
			{
				$row = mysql_fetch_array($result_autho);
				if($row['autho_seq'] == $user_row['autho_seq'])
				{?>

					<option value = "<?=  $row['autho_seq'] ?>" selected><?= $row['autho_name'] ?></option>
			<?php
				}
				else
				{?>
					<option value = "<?=  $row['autho_seq'] ?>"><?= $row['autho_name'] ?></option>
			<?php
				}
				?>
		<?php
			}
			?>
		</select><br>

		学籍番号※学生のみ<input type="text" name="stuent_id" value="<?= $user_row['student_id'] ?>"><br>
		<input type="hidden" value="<?= $user_row['user_seq'] ?>" name="user_seq">
		<input class="button4" type="submit" value ="登録">
		</form>
		</div>
	</body>
</html>