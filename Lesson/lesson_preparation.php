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
			<script src="../javascript/jquery-1.8.2.min.js"></script>
			<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
			<link rel="stylesheet" type="text/css" href="../css/button.css" />
			<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
	</head>
	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div align="center">
			<font class="Cubicfont">授業</font>
		</div>
		<hr color="blue"></hr>
		<br><br><br>

		<table border="1">
			<tr>
				<th>授業の日付</th>
				<th>教科</th>
				<th>クラス</th>
				<th>決定</th>
			<tr>

			<tr>
				<form action="test.php" method="post" enctype="multipart/form-data">
					<!-- 授業がある日付・授業するクラス・授業の科目 -->
					<td>
						<input type="date" name= "date" size= "30" id="date" min="<?= date("Y-m-d") ?>"/><br />
					</td>

					<td>
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
					</td>

					<td>
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
					</td>

					<td>
						<input type="submit" value="決定" id="decision" disabled=disabled />
					</td>
				</form>
			</tr>
		</table>
	</body>
	<script>

	$(function() {
		/* 決定ボタンをクリックした後の過去授業の画像を出力する処理 */

		//日付ボタンを選択した後に決定ボタンを表示
		$(document).on('change', '#date', function() {
			var decision_ele =document.getElementById("decision");
			decision_ele.disabled=false;
	    });
	});
	</script>
</html>