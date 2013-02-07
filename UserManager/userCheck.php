<html>
	<head>
		<script src="../javascript/form_reference.js"></script>
		<script src="../javascript/jquery-1.8.2.min.js"></script>
	</head>
</html>
<?php
session_start();

//受け取ったデータをSESSIONに入れる
$_SESSION['user_id'] = $_POST['user_id'];
$_SESSION['pass'] = $_POST['pass'];
$_SESSION['user_name'] = $_POST['user_name'];
$_SESSION['user_kana'] = $_POST['user_kana'];
$_SESSION['user_address'] = $_POST['user_address'];
$_SESSION['user_tel'] = $_POST['user_tel'];
$_SESSION['user_email'] = $_POST['user_email'];
$_SESSION['autho_seq'] = $_POST['autho_seq'];

?>




<?php
//受け取ったデータのチェック
$id_check = userCheck($_POST['user_id'], 'ic,pc,tc', 0, 0);
$pass_check = userCheck($_POST['pass'], 'ic,pc,tc', 0, 0);
$name_check = userCheck($_POST['user_name'], 'ic,tc', 0, 0);
$kana_check = userCheck($_POST['user_kana'], 'ic,fc,tc', 0, 0);
$address_check = userCheck($_POST['user_address'], 'ic,tc', 0, 0);
$tel_check = userCheck($_POST['user_email'], 'ic,nc,lc', 10, 10);
$mail_check = userCheck($_POST['autho_seq'], 'ic,mc', 0, 0);

//学生番号が入っていた場合のチェック
if(isset($_POST['stuent_id']))
{
	$_SESSION['student_id'] = $_POST['student_id'];
	$student_check = userCheck($_POST['student_id'], 'ic,nc,tc,lc', 6, 6);
}

//エラーメッセージがある場合、メッセージをSESSIONに入れ、前ページに戻る
if(($id_check) || ($pass_check) || ($name_check) || ($kana_check) ||
	($address_check) || ($tel_check) || ($mail_check) || ($student_check))
{
	$_SESSION['id_check'] = $id_check;
	$_SESSION['pass_check'] = $pass_check;
	$_SESSION['name_check'] = $name_check;
	$_SESSION['kana_check'] = $kana_check;
	$_SESSION['address_check'] = $address_check;
	$_SESSION['tel_check'] = $tel_check;
	$_SESSION['mail_check'] = $mail_check;
	$_SESSION['student_check'] = $student_check;

	if($_POST['regist_flg'] == 0)
	{
		header("Location: regist_view.php");
	}
	if($_POST['regist_flg'] == 1)
	{
		header("Location: change_view.php");
	}
}
else
{
	if($_POST['regist_flg'] == 0)
	{
		header("Location: regist.php");
	}
	if($_POST['regist_flg'] == 1)
	{
		header("Location: change.php");
	}
}
?>