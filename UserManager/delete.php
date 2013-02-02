<?php
//DB接続
require_once("../lib/dbconect.php");
$dbcon = DbConnect();

//SQL生成

$user_seq = $_POST['user_seq'];

$sql = "UPDATE m_user SET delete_flg = '1' WHERE user_seq = '$user_seq'";

mysql_query($sql);

header("Location: comp_dis.html");
