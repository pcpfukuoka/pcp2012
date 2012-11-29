<?php
$title = $_POST['title'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$target_group = $_POST['target_group'];
$description = $_POST['question_description'];

require_once("../lib/dbconect.php");
$link = DbConnect();


$sql = "INSERT INTO question VALUES (0,'$title','$target_group','$start_date','$end_date','$description')";

mysql_query($sql);
$seq = mysql_insert_id();

Dbdissconnect($link);

echo $seq;