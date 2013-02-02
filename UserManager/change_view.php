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
		<table>
			<tr>
				<td align="center">ユーザID:</td>
				<td align="center"><input type="text" name="user_id" id="user_id" value="<?= $user_row['user_id'] ?>" disabled="true" Onblur="check('#user_id', ic, ac, nc)"></td>
			</tr>

			<tr>
				<td align="center">パスワード：</td>
				<td align="center"><input type="text" name="pass" id="pass" value="<?= $user_row['pass'] ?>" disabled="true" Onblur="check('#pass', ic, ac, nc, c)"></td>
			</tr>

			<tr>
				<td align="center">ユーザ名</td>
				<td align="center"><input type="text" name="user_name" id="user_name" value="<?= $user_row['user_name'] ?>" disabled="true" Onblur="check('#user_name', ic, tc, t, )"></td>
			</tr>

			<tr>
				<td align="center">ふりがな：</td>
				<td align="center"><input type="text" name="user_kana" id="user_kana" value="<?= $user_row['user_kana'] ?>" disabled="true" Onblur="check('#user_kana', ic, tc, t, )"></td>
			</tr>

			<tr>
				<td align="center">住所：</td>
				<td align="center"><input type="text" name="user_address" id="user_address" value="<?= $user_row['user_address'] ?>" disabled="true" Onblur="check('#user_address', ic, tc, t, )"></td>
			</tr>

			<tr>
				<td align="center">電話番号:</td>
				<td align="center"><input type="text" name="user_tel" id="user_tel" value="<?= $user_row['user_tel'] ?>" disabled="true" Onblur="check('#user_tel', ic, vc, tc, foc)"></td>
			</tr>

			<tr>
				<td align="center">メールアドレス：</td>
				<td align="center"><input type="text" name="user_email" id="user_email" value="<?= $user_row['user_email'] ?>" disabled="true" Onblur="check('#user_email', ic, cE)"></td>
			</tr>

			<tr>
				<td align="center">権限：</td>
				<td align="center">
					<select name = "autho_seq" size = "1" disabled="true">
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
					</select>
					</td>
		</tr>
		<tr>
			<td>学籍番号※学生のみ</td>
			<td><input type="text" name="stuent_id" id="student_id" value="<?= $user_row['student_id'] ?>" disabled Onblur="check('#student_id', ic, tc, vc, )"></td>
		</tr>
	</table>

		<br>
		<table>
		<tr>
		<td>
		<input type="hidden" value="<?= $user_row['user_seq'] ?>" name="user_seq">
		<input class="button4" type="submit" value ="更新">
		</form>
		</td>
		<td>
		<input class="button4" type="button" id="edit" data-id="0" value ="編集">
		</td>
			<form method="POST" action="delete.php">
		<td>
				<input type="hidden" value="<?= $user_row['user_seq'] ?>" name="user_seq">
				<input class="button4" type="submit" value ="削除">
		</td>
			</form>
		</tr>
		</table>
		</div>
	</body>


				<script>
		$(function() {
			//検索結果から権限を追加するための処理
			$(document).on('click', '#edit', function() {

				//対象のinputタグのNameを配列にかくのう
				var input_names = new Array("user_id", "pass", "user_name", "user_kana", "user_address	",
										"user_tel", "user_email", "autho_seq", "stuent_id");
				var flg = $(this).data('id');

				if(flg == 0)
				{
					for (i = 0; i < input_names.length; i++)
					{
						$("*[name="+input_names[i]+"]").attr('disabled', false);

					}
				}
				else
				{
					for (i = 0; i < input_names.length; i++)
					{
						$("*[name="+input_names[i]+"]").attr('disabled', true);

					}

				}

				$(this).data('id'). = 1;
				
			});
		});

		//strはid
		function check(str)
		{
			var a =  $(str).val();
			var ret = inputCheck(a);


		}
			</script>

</html>