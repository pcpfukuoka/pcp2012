<?php 
$id = "user_id,pass,user_name,user_kana,user_address,user_tel,user_email";
$cmd = "ic,pc/ic,pc/ic/ic,fc/ic/ic,nc,lc/ic,mc";
$min = "0,0,0,0,0,10,0";
$max = "0,0,0,0,0,11,0";
$span = "user_id_check,pass_check,user_name_check,user_kana_check,user_address_check,user_tel_check,user_email_check";
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<META http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
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

		<form method ="post" action="regist.php" onsubmit="return check('<?= $id ?>', '<?= $cmd ?>', '<?= $min ?>', '<?= $max ?>', '<?= $span ?>')">
		<table>

			<tr>
				<td align="center">ユーザID:</td>
				<td align="center"><span class="check_result" name="user_id_check" id="user_id_check" ></span><input type="text" name="user_id" id="user_id"></td>
				<td></td>
			</tr>

			<tr>
				<td align="center">パスワード：</td>
				<td align="center"><span class="check_result" name="pass_check" id="pass_check" ></span><input type="text" name="pass" id="pass"></td>
			</tr>

			<tr>
				<td align="center">ユーザ名：</td>
				<td align="center"><span class="check_result" name="user_name_check" id="user_name_check" ></span><input type="text" name="user_name" id="user_name"></td>
			</tr>

			<tr>
				<td align="center">ﾌﾘｶﾞﾅ：</td>
				<td align="center"><span class="check_result" name="user_kana_check" id="user_kana_check" ></span><input type="text" name="user_kana" id="user_kana"></td>
			</tr>

			<tr>
				<td align="center">住所：</td>
				<td align="center"><span class="check_result" name="user_address_check" id="user_address_check" ></span><input type="text" name="user_address" id="user_address"></td>
			</tr>

			<tr>
				<td align="center">電話番号</td>
				<td align="center"><span class="check_result" name="user_tel_check" id="user_tel_check" ></span><input type="text" name="user_tel" id="user_tel"></td>
			</tr>

			<tr>
				<td align="center">メールアドレス：</td>
				<td align="center"><span class="check_result" name="user_email_check" id="user_email_check" ></span><input type="text" name="user_email" id="user_email"></td>
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

		<tr>
			<td>学籍番号※学生のみ</td>

			<td>
				<input type="checkbox"  name="student" id="student" value="0">学生
				<span class="check_result" name="student_id_check" id="student_id_check" ></span>
				<input type="text" name="student_id" id="student_id" disabled="true">
			</td>
		</tr>
	</table>
		<br>

		<input class="button4" id="sub" type="submit" value ="登録">
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