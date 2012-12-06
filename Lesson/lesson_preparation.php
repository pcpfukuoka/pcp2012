<?php

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	$sql = "SELECT subject_seq, subject_name FROM m_subject;";

	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
?>
<html>
	<head>

	</head>
	<body>
		<form action="add.php" method="post" enctype="multipart/form-data">
			ファイル：<br/>
			<!-- 授業がある日付・授業するクラス・授業の科目 -->
			<input type="date" name= "date" size= "30" /><br />

			<select name="subject">
				<?php
				foreach($row as $key => $val)
				{
					echo '<option value="'. $key. '">'. $val. '</option>'';
				}
				?>
			</select>
			<br />
			<input type="submit" value="決定" />
		</form>
	</body>
</html>