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
if(isset($_POST['new_group_name']))
{
	$group_name = $_POST['new_group_name'];
	
	if(isset($_POST['class_flg']))
	{
		$class_flg = "0";
	}
	else
	{
		$class_flg = "0";
	}
	
	$seq = $_POST['seq'];
	
		//アップデート分書式
		$sql = "UPDATE m_group SET group_name = '$group_name', class_flg = $class_flg WHERE group_seq = $seq";
		mysql_query($sql);
		
	print "<script language=javascript>leftreload();</script>";
	print "<script language=javascript>jump('group_details.php?id=".$group_seq."','right');</script>";
}
else
{
		print "<script language=javascript>jump('../dummy.html','right');</script>";
}
?>