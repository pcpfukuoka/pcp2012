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

		<form method ="post" name="frm1" action="regist.php" >
		<table>

			<tr>
				<td align="center">ユーザID:</td>
				<td align="center"><span class="check_result" name="user_id_check" id="user_id_check" ></span><input type="text" name="user_id" id="user_id" Onblur="ubCheck('#user_id', 'ic,ac,tc', 0, 0, 'frm1.user_id_check')"></td>
				<td></td>
			</tr>

			<tr>
				<td align="center">パスワード：</td>
				<td align="center"><input type="text" name="pass" id="pass" Onblur="ubCheck('#pass', 'ic,ac,tc', 0, 0, 'frm1.pass_check')"></td>
			</tr>

			<tr>
				<td align="center">ユーザ名：</td>
				<td align="center"><input type="text" name="user_name" id="user_name" Onblur="ubCheck('#user_name', 'ic,tc', 0, 0, 'frm1.user_name_check')"></td>
			</tr>

			<tr>
				<td align="center">ﾌﾘｶﾞﾅ：</td>
				<td align="center"><input type="text" name="user_kana" id="user_kana" Onblur="ubCheck('#user_kana', 'ic,fc,tc', 0, 0, 'frm1.user_kana_check')"></td>
			</tr>

			<tr>
				<td align="center">住所：</td>
				<td align="center"><input type="text" name="user_address" id="user_address" Onblur="ubCheck('#user_address', 'ic,tc', 0, 0, 'frm1.user_address_check')"></td>
			</tr>

			<tr>
				<td align="center">電話番号</td>
				<td align="center"><input type="text" name="user_tel" id="user_tel" Onblur="ubCheck('#user_tel', 'ic,nc,lc', 10, 10, 'frm1.user_tel_check')"></td>
			</tr>

			<tr>
				<td align="center">メールアドレス：</td>
				<td align="center"><input type="text" name="user_email" id="user_email" Onblur="ubCheck('#user_email', 'ic,mc', 0, 0, 'frm1.user_email_check')"></td>
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
				<input type="text" name="student_id" id="student_id" disabled="true" Onblur="ubCheck('#student_id', 'ic,nc,tc,lc', 6, 6, 'frm1.student_id_check')">
			</td>
		</tr>
	</table>
		<br>

		<?php
		$input_names = array("user_id", "pass", "user_name", "user_kana", "user_address",
							"user_tel", "user_email", "student_id");
		$check_cmd = array("ic,pc,tc", "ic,pc,tc", "ic,tc", "ic,fc,tc", "ic,tc", "ic,nc,lc",
							"ic,mc", "ic,nc,lc");
		$check_val_min = array(0, 0, 0, 0, 0, 10, 0, 6);
		$check_val_max = array(0, 0, 0, 0, 0, 10, 0, 6);
		?>
		<input class="button4" id="sub" type="submit" value ="登録"
		onClick="ucCheck(<?= $input_names?>, <?= $check_cmd?>, <?= $check_val_min?>, <?= $check_val_max ?>);">
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
						$("*[name=student]").attr('value', 0);
				}
				else
				{
						$("*[name=student_id]").attr('disabled', true);
						$("*[name=student]").attr('value', 1);
				}
			});
		});

		function user_check()
		{

			var check_flg = true;
			var i = 0;

			//対象のinputタグのNameを配列に格納
			var input_names = new Array("user_id", "pass", "user_name", "user_kana", "user_address",
										"user_tel", "user_email", "student_id");
			var check_cmd = new Array("ic,pc,tc", "ic,pc,tc", "ic,tc", "ic,fc,tc", "ic,tc",	"ic,nc,lc",
										"ic,mc", "ic,nc,lc");
			var check_val_min = new Array(0, 0, 0, 0, 0, 10, 0, 6);
			var check_val_max = new Array(0, 0, 0, 0, 0, 10, 0, 6);
			var check_result = new Array("0","0","0","0","0","0","0", "0");

			//チェックだけ
			for (i = 0; i < input_names.length; i++)
			{
				if (i != 7)
				{
					check_result[i] = userCheck($("#"+input_names[i]+"").val(), check_cmd[i], check_val_min[i], check_val_max[i]);
				}

				if ( (i == 7) && ($("#student").value() == 1) )
				{
					check_result[i] = userCheck($("#"+input_names[i]+"").val(), check_cmd[i], check_val_min[i], check_val_max[i]);

				}

			}


			//チェックの結果を反映
			for (i = 0; i < input_names.length; i++)
			{
				//if(check_result[i] != "0")
				//{
					$("#"+input_names[i]+"_check").text("※" + check_result[i]);
					check_flg = false;
				//}
			}

			if(check_flg)
			{
				return true; // 「OK」時は送信を実行
			}
			else
			{
				return false; // 送信を中止
			}
		}

	</script>

</html>