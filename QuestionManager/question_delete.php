<?php

//DB接続
require_once("../lib/dbconect.php");
$dbcon = DbConnect();

//SQL生成

$question_seq = $_GET['id'];

$sql = "UPDATE question SET delete_flg = '1' WHERE question_seq = '$question_seq'";

mysql_query($sql);

header("Location: comp_dis_del.html");



