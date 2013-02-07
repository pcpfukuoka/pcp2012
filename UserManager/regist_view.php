<?php
session_start();

$error_check = 0;

//記入ミスがあった場合
if($_SESSION['id_check'] || $_SESSION['pass_check'] || $_SESSION['name_check'] || $_SESSION['kana_check'] ||
$_SESSION['address_check'] || $_SESSION['tel_check'] || $_SESSION['mail_check'] || $_SESSION['student_check'])
{
	$id_check = $_SESSION['id_check'];
	$pass_check = $_SESSION['pass_check'];
	$name_check = $_SESSION['name_check'];
	$kana_check = $_SESSION['kana_check'];
	$address_check = $_SESSION['address_check'];
	$tel_check = $_SESSION['tel_check'];
	$mail_check = $_SESSION['mail_check'];
	$student_check = $_SESSION['student_check'];

	$error_check = 1;
}

function error_message($i)
{
	if($i == 1)
	{
		echo $id_check;
	}
	elseif ($i == 2)
	{
		echo $pass_check;
	}
	elseif ($i == 3)
	{
		echo $name_check;
	}
	elseif ($i == 4)
	{
		echo $kana_check[$j];
	}
	elseif ($i == 5)
	{
		echo $address_check[$j];
	}
	elseif ($i == 6)
	{
		echo $tel_check[$j];
	}
	elseif ($i == 7)
	{
		echo $mail_check[$j];
	}
	elseif ($i == 8)
	{
		echo $student_check[$j];
	}
}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<META http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<script src="../javascript/jquery-1.8.2.min.js"></script>
		<script src="../javascript/jquery-ui-1.8.24.custom.min.js"></script>
		<script src="../javascript/form_reference.js"></script>
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

		<form method ="post" action="userCheck.php">
		<table>
			<?php
			if ($error_check == 1)
			{
				error_message(1);
			}
			?>
			<tr>
				<td align="center">ユーザID:</td>
				<td align="center"><input type="text" name="user_id" id="user_id"></td>
			</tr>

			<?php
			if ($error_check == 1)
			{
				error_message(2);
			}
			?>
			<tr>
				<td align="center">パスワード：</td>
				<td align="center"><input type="text" name="pass" id="pass"></td>
			</tr>

			<?php
			if ($error_check == 1)
			{
				error_message(3);
			}
			?>
			<tr>
				<td align="center">ユーザ名：</td>
				<td align="center"><input type="text" name="user_name" id="user_name"></td>
			</tr>

			<?php
			if ($error_check == 1)
			{
				error_message(4);
			}
			?>
			<tr>
				<td align="center">ﾌﾘｶﾞﾅ：</td>
				<td align="center"><input type="text" name="user_kana" id="user_kana"></td>
			</tr>

			<?php
			if ($error_check == 1)
			{
				error_message(5);
			}
			?>
			<tr>
				<td align="center">住所：</td>
				<td align="center"><input type="text" name="user_address" id="user_address"></td>
			</tr>

			<?php
			if ($error_check == 1)
			{
				error_message(6);
			}
			?>
			<tr>
				<td align="center">電話番号</td>
				<td align="center"><input type="text" name="user_tel" id="user_tel"></td>
			</tr>

			<?php
			if ($error_check == 1)
			{
				error_message(7);
			}
			?>
			<tr>
				<td align="center">メールアドレス：</td>
				<td align="center"><input type="text" name="user_email" id="user_email"></td>
			</tr>

			<tr>
				<td align="center">権限：</td>
				<td align="center">
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
					</select>
				</td>
		</tr>

		<?php
			if ($error_check == 1)
			{
				error_message(8);
			}
			?>
		<tr>
			<td>学籍番号※学生のみ</td>

					<td><input type="checkbox" id="student">学生
			<input type="text" name="student_id" id="student_id" disabled="true"></td>
		</tr>
	</table>
		<br>
		<input type = "hidden" name = "regist_flg" value = "0">
		<input class="button4"type="submit" value ="登録">
		</form>
		</div>
	</body>
	<script>
		$(function() {
			//検索結果から権限を追加するための処理
			$(document).on('click', '#student', function() {

				//対象のinputタグのNameを配列にかくのう

				if(document.getElementById("student").checked)
				{
						$("*[name=student_id]").attr('disabled', false);
				}
				else
				{
						$("*[name=student_id]").attr('disabled', true);
				}
			});
		});
	</script>
</html>