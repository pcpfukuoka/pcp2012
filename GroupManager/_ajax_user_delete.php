<?php

//DBに接続
require_once("../lib/dbconect.php");
$link = DbConnect();
//POSTでKEYを取得
$id = $_POST[id];
$sql = "UPDATE group_details SET delete_flg = 1 WHERE group_details_seq = '$id'";
mysql_query($sql);
Dbdissconnect($link);
