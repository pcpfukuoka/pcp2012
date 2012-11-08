<?php
require_once("../lib/dbconect.php");
$dbcon = DbConnect();
if((isset($_POST['new_group_name'])) && (isset($_POST['autho_select'])))
{
	$group_name = $_POST['new_group_name'];
	$autho_seq = $_POST['autho_select'];

	$sql = "insert into m_group values(0, '$group_name', '$autho_seq', 0)";
	mysql_query($sql);

	$sql = "SELECT * FROM m_group WHERE delete_flg = 0 ORDER BY group_seq DESC;";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$group_seq = $row['group_seq'];
	header("Location:group_details.php?id=$group_seq");
	
}
else
{
	header("Location:../dummy.html");
}
