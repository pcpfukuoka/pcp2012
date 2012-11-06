<?php
session_start();
$user_seq = $_POST['id'];
$autho_seq = $_SESSION['autho_sel'];
require_once("../lib/dbconect.php");
$link = DbConnect();
$sql = "SELECT autho_seq FROM m_user WHERE user_seq = '$user_seq' AND delete_flg = 0;";
$result_back_seq = mysql_query($sql);
$back_seq_row = mysql_fetch_array($result_back_seq);
$back_autho_seq = $back_seq_row['autho_seq'];
$sql = "UPDATE m_user SET back_autho_seq = '$back_autho_seq', autho_seq = '$autho_seq' WHERE user_seq = '$user_seq';";
mysql_query($sql);
Dbdissconnect($link);
echo $user_seq;
