<?php
$user_id = $_POST['user_id'];
$pass = $_POST['pass'];
$user_name = $_POST['user_name'];
$user_kana = $_POST['user_kana'];
$user_address = $_POST['user_address'];
$user_tel = $_POST['user_tel'];
$user_email = $_POST['user_email'];
$autho_seq = $_POST['autho_seq'];
$user_seq = $_POST['user_seq'];


//DB接続
require_once("../lib/dbconect.php");
$dbcon = DbConnect();


//登録処理
$sql = "UPDATE m_user SET 
		user_name='$user_name', 
		user_kana='$user_kana', 
		user_address='$user_address', 
		user_tel='$user_tel', 
		user_email='$user_email', 
		user_id='$user_id', 
		pass='$pass', 
		autho_seq='$autho_seq' 
		WHERE user_seq='$user_seq';";
mysql_query($sql);

if(isset($_POST['stuent_id']))
{
	$student_id = $_POST['stuent_id'];
	$sql = "UPDATE m_student SET student_id='$student_id' WHERE user_seq='$user_seq';";
	mysql_query($sql);
}
header("Location: comp_dis.html");