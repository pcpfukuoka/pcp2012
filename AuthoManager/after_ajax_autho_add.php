<?php
session_start();
$user_seq = $_POST['id'];
require_once("../lib/dbconect.php");
$link = DbConnect();
$sql = "SELECT back_autho_seq FROM m_user WHERE delete_flg = 0 AND user_seq = '$user_seq';";
$result_back_seq = mysql_query($sql);
$back_seq_row = mysql_fetch_array($result_back_seq);
$back_autho_seq = $back_seq_row['back_autho_seq'];
$seq = 0;
$sql = "UPDATE m_user SET autho_seq = '$back_autho_seq', back_autho_seq = '$seq' WHERE user_seq = '$user_seq';";
mysql_query($sql);
Dbdissconnect($link);

echo $user_seq;
?>