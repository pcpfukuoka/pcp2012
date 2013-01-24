<?php

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	$sql = "SELECT subject_seq, subject_name FROM m_subject;";
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);

	$group_sel = "SELECT group_seq,group_name FROM pcp2012.m_group WHERE class_flg =1;";
	$group_result = mysql_query($group_sel);
	$count2 = mysql_num_rows($group_result);


	//データベースを閉じる
	Dbdissconnect($dbcon);
?>
<html>
	<head>
			<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">


	</head>
	<body>
		<form action="test.php" method="post" enctype="multipart/form-data">
			<!-- 授業がある日付・授業するクラス・授業の科目 -->
			<input type="date" name= "date" size= "30" /><br />

			<select name="subject">
				<?php
	   				for ($i = 0; $i < $count; $i++)
	   				{
	   					$row = mysql_fetch_array($result);
  				?>
    				<option value="<?= $row['subject_seq']?>"><?= $row['subject_name'] ?></option>
  				<?php
    				}
  				?>
			</select>

			<select name="group">
				<?php
	   				for ($i = 0; $i < $count2; $i++)
	   				{
	   					$row = mysql_fetch_array($group_result);
  				?>
    				<option value="<?= $row['group_seq']?>"><?= $row['group_name'] ?></option>
  				<?php
    				}
  				?>
			</select>

			<br />
			<input type="submit" value="決定" />
		</form>
	</body>
</html>