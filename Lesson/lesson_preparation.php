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
			<link rel="stylesheet" type="text/css" href="../css/table.css" />
			<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
	</head>
	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
	<div align="center">
			<font class="Cubicfont">授業</font>
		</div>
		<hr color="blue"></hr>
		<br><br><br>

		<table class="table_01">
			<tr>
				<th>授業の日付</th>
				<th>クラス</th>
				<th>時間割</th>
				<th>教科</th>
				<th>決定</th>
			<tr>

			<tr>
				<form action="test.php" method="post" enctype="multipart/form-data"  onsubmit="return check();">
					<!-- 授業がある日付・授業するクラス・授業の科目 -->
					<td align="center">
						<input type="date" name= "date" size= "30" id="date" min="<?= date("Y-m-d") ?>"/><br />
					</td>

					<td align="center">
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

					<td align="center">
						<select name="time_table">
							<option value="1">１時間目</option>
							<option value="2">２時間目</option>
							<option value="3">３時間目</option>
							<option value="4">４時間目</option>
							<option value="5">５時間目</option>
							<option value="6">６時間目</option>
						</select>
					</td>


					<td align="center">
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



					<td align="center">
						<input class="button3" type="submit" value="決定" id="decision"/>
					</td>
				</form>
			</tr>
		</table>
		</div>
	</body>
	<script>
	//全ての項目を選択していない時にsubmitさせず、alartを出す。
	function check(){
		var date_ele=document.getElementById("date");
		if(date_ele.value){
             return true;
		}else{
			 alert('すべての項目を入力してください');
             return false;
		}
	}
	</script>
</html>