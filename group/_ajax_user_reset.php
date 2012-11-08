<?php
session_start();
$user_seq = $_POST['id'];
$group_seq = $_POST['gs'];
require_once("../lib/dbconect.php");
$link = DbConnect();
$sql = "INSERT INTO group_details VALUES (0,'$group_seq','$user_seq',0)";
mysql_query($sql);
Dbdissconnect($link);
echo $user_seq;
