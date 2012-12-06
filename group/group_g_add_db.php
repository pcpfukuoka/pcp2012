<html>
	<head>
		<script src="../javascript/frame_jump.js"></script>
	</head>

	<body>
	</body>
</html>
<?php
require_once("../lib/dbconect.php");
$dbcon = DbConnect();
if((isset($_POST['new_group_name'])) && (isset($_POST['autho_select'])))
{
	$group_name = $_POST['new_group_name'];
	$autho_seq = $_POST['autho_select'];
	$find_flg = 0;

	$sql = "SELECT * FROM m_group WHERE delete_flg = 0;";
	$result = mysql_query($sql);
	$cnt = mysql_num_rows($result);
	
	for($i = 0; $i < $cnt; $i++)
	{
		$row = mysql_fetch_array($result);
		if($row['group_name'] == $group_name)
		{
			$find_flg = 1;
			break;
		}
	}
	
	if($find_flg == 0)
	{
		$sql = "insert into m_group values(0, '$group_name', '$autho_seq',0, 0)";
		mysql_query($sql);
			
		$sql = "SELECT * FROM m_group WHERE delete_flg = 0 ORDER BY group_seq DESC;";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$group_seq = $row['group_seq'];
		print "<script language=javascript>leftreload();</script>";
		print "<script language=javascript>jump('group_details.php?id=".$group_seq."','right');</script>";
	}
	else
	{

		header("Location:group_g_add.php?name_error=$group_name");
	}
}
else
{
	header("Location:../dummy.html");
}
?>