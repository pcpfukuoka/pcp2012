<?php
session_start();
$user_id = $_SESSION['user_id'];
$pass = $_SESSION['pass'];
$user_name = $_SESSION['user_name'];
$user_kana = $_SESSION['user_kana'];
$user_address = $_SESSION['user_address'];
$user_tel = $_SESSION['user_tel'];
$user_email = $_SESSION['user_email'];
$autho_seq = $_SESSION['autho_seq'];
$user_seq = $_SESSION['user_seq'];


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

if(isset($_SESSION['student_id']))
{
	$student_id = $_SESSION['student_id'];
	$sql = "UPDATE m_student SET student_id='$student_id' WHERE user_seq='$user_seq';";
	mysql_query($sql);
}
header("Location: comp_dis.html");