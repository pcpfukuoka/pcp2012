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
		
		$id = "user_id,pass,user_name,user_kana,user_address,user_tel,user_email";
		$cmd = "ic,pc/ic,pc/ic/ic,fc/ic/ic,nc,lc/ic,mc";
		$min = "0,0,0,0,0,10,0";
		$max = "0,0,0,0,0,11,0";
		$span = "user_id_check,pass_check,user_name_check,user_kana_check,user_address_check,user_tel_check,user_email_check";
		

		//選択ユーザ情報データ取得
		$sql = "SELECT m_user.user_seq,user_name,user_kana,user_address,user_tel,user_email,user_id,pass,autho_seq,student_id FROM m_user LEFT JOIN m_student ON m_user.user_seq = m_student.user_seq WHERE m_user.delete_flg = 0 AND m_user.user_seq = '$user_seq'";
		$result_user = mysql_query($sql);
		$user_row = mysql_fetch_array($result_user);
		?>

		<form method ="post" action="change.php" onsubmit="return Check()">
		<table>
			<tr>
				<td align="center">ユーザID:</td>
				<td align="center"><span class="check_result" name="user_id_check" id="user_id_check" ></span><input type="text" name="user_id" id="user_id" value="<?= $user_row['user_id'] ?>" disabled="true" Onblur="check('#user_id', 'ic,ac,tc', 0, 0)"></td>
			</tr>

			<tr>
				<td align="center">パスワード：</td>
				<td align="center"><span class="check_result" name="pass_check" id="pass_check" ></span><input type="text" name="pass" id="pass" value="<?= $user_row['pass'] ?>" disabled="true" Onblur="check('#pass', 'ic,ac,tc', 0, 0)"></td>
			</tr>

			<tr>
				<td align="center">ユーザ名</td>
				<td align="center"><span class="check_result" name="user_name_check" id="user_name_check" ></span><input type="text" name="user_name" id="user_name" value="<?= $user_row['user_name'] ?>" disabled="true" Onblur="check('#user_name', 'ic,tc', 0, 0)"></td>
			</tr>

			<tr>
				<td align="center">ふりがな：</td>
				<td align="center"><span class="check_result" name="kana_check" id="kana_check" ></span><input type="text" name="user_kana" id="user_kana" value="<?= $user_row['user_kana'] ?>" disabled="true" Onblur="check('#user_kana', 'ic,fc,tc', 0, 0)"></td>
			</tr>

			<tr>
				<td align="center">住所：</td>
				<td align="center"><span class="check_result" name="user_address_check" id="user_address_check" ></span><input type="text" name="user_address" id="user_address" value="<?= $user_row['user_address'] ?>" disabled="true" Onblur="check('#user_address', 'ic,tc', 0, 0)"></td>
			</tr>

			<tr>
				<td align="center">電話番号:</td>
				<td align="center"><span class="check_result" name="user_tel_check" id="user_tel_check" ></span><input type="text" name="user_tel" id="user_tel" value="<?= $user_row['user_tel'] ?>" disabled="true" Onblur="check('#user_tel', 'ic,nc,lc', 10, 10)"></td>
			</tr>

			<tr>
				<td align="center">メールアドレス：</td>
				<td align="center"><span class="check_result" name="user_email_check" id="user_email_check" ></span><input type="text" name="user_email" id="user_email" value="<?= $user_row['user_email'] ?>" disabled="true" Onblur="check('#user_email', 'ic,mc', 0, 0)"></td>
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
			<td><input type="text" name="stuent_id" id="student_id" value="<?= $user_row['student_id'] ?>" disabled Onblur="check('#student_id', 'ic,nc,tc,lc', 6, 6)"></td>
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
			<form method="POST" action="delete.php" onSubmit="return Check()">
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
					$(this).data('id','1');
					
				}
				else
				{
					for (i = 0; i < input_names.length; i++)
					{
						$("*[name="+input_names[i]+"]").attr('disabled', true);

					}
					$(this).data('id','0');
					
				}
			});
		});
		function Check(){

			if(window.confirm('送信してよろしいですか？')){ // 確認ダイアログを表示

				return true; // 「OK」時は送信を実行

			}
			else{ // 「キャンセル」時の処理

				window.alert('キャンセルされました'); // 警告ダイアログを表示
				return false; // 送信を中止

			}

		}
				
			</script>

</html>