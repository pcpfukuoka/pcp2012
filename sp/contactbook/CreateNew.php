<?php
		 //データベースの呼出
         require_once("../lib/dbconect.php");
         $dbcon = DbConnect();

         //ユーザーの件数の取り出し
	     $sql = "SELECT * FROM m_user";
	     $result = mysql_query($sql);
	     $kensu = mysql_num_rows($result);

	     //グループの件数の取り出し
	     $sql = "SELECT *
				 FROM m_group
				 WHERE delete_flg = 0";
	     $group = mysql_query($sql);
	     $count = mysql_num_rows($group);

	     //データベースを閉じる
	     DBdissconnect($dbcon);
?>

<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, intital-scale=1">
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
		<title> 新規作成</title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta http-equiv="Content-Style-Type" content="text/css">

		<link rel="stylesheet" type="text/css" href="../../css/text_display.css" />
	</head>

	<body>
		<div align="center">
			<div data-role="header" data-position="fixed">
				<div data-role="navbar">
					<ul>
						<li><a href="main.php" class="ui-btn-active">連絡帳</a></li>
						<li><a href="../Lesson/join_lesson.php">授業</a></li>
						<li><a href="../Results_management/Per_ver.php">成績確認</a></li>
						<li><a href="../question/answer_list.php">アンケート</a></li>
					</ul>
				</div>
			</div>

			<div data-role="content" align="left">
				<form action="relay.php" method="POST" id="input">
					<div align="center">
					<font class="Cubicfont">新規作成</font><br><br>
					</div>

					<hr color="blue">
					<br><br><br>

					<div align="center">
						<font size="5">宛先</font>
					</div>
					<div data-role="controlgroup" align="left">
						<input type="radio" name="switch" value="user_seq" id=test01>
						<table>
							<tr>
								<td>
									<label for="test01">個人</label>
									<select name="to_user" data-native-menu="false">
									<?php
									for ($i = 0; $i < $kensu; $i++)
									{
										$row = mysql_fetch_array($result);
									?>
										<option value="<?=$row['user_seq']?>"><?= $row['user_name'] ?></option>
									<?php
									}
									?>
									</select>
								</td>
							</tr>
						</table>
					</div>

					<div data-role="controlgroup" align="left">
						<input type="radio" name="switch" value="group_seq" id=test02>
						<table>
							<tr>
								<td>
									<label for="test02">グループ</label>
									<select name="to_group"  data-native-menu="false">
									<?php
										for ($i = 0; $i < $count; $i++)
										{
											$row = mysql_fetch_array($group);
									?>
											<option value="<?=$row['group_seq']?>"><?= $row['group_name'] ?></option>
									<?php
										}
									?>
									</select>
								</td>
							</tr>
						</table>
					</div>

					<br>
					<font size="5">件名</font>
					<input size="40" type="text" name="title"><br><br>
					<font size="5">本文</font><br>
					<textarea rows="40" cols="50" name="contents"></textarea><br>

					<!--隠し文字-->
					<input type="hidden" value="0" name="link_id">
					<div align="center">
						<input class="button4" type="submit" data-role="button" data-inline="true" value="送信" name = "send">
						<input class="button4" type="submit" data-role="button" data-inline="true" value="保存" name="Preservation"><br>
					</div>

				</form>
			</div>

			<div data-role="footer" data-position="fixed" >
				<p>PCP2012</p>
				<a href="main.php" data-rel="back" data-role="button" data-icon="back"  class="ui-btn-left">戻る</a>
				<a href="../index.php" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right">トップへ</a>
			</div>
		</div>
	</body>
</html>
