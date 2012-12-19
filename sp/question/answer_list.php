<?php
session_start();

//GETで値がなければこのページには遷移させない
//今はテスト用にその処理は欠かないけど最終的には追加する

$user_seq = $_SESSION['login_info[user]'];

?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, intital-scale=1">
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	</head>
	<body>
	 <div align="center">
			<div data-role="header" data-position="fixed">
				<div data-role="navbar">
					<ul>
						<li><a href="">スケジュール</a></li>
						<li><a href="../contactbook/main.php">連絡帳</a></li>
						<li><a href="">授業</a></li>
						<li><a href="../Results_management/Per_ver.php">成績確認</a></li>
						<li><a href="answer_list.php" class="ui-btn-active">アンケート</a></li>
					</ul>
				</div>
			</div>
			
			<div data-role="content">		
		<table border="1">
			<tr bgcolor="yellow">
				<th align="center"width="35%"><font size="5">タイトル</font></th>
				<th align="center"width="35%"><font size="5">期間</font></th>
				<th align="center"width="35%"><font size="5"></font></th>				
			</tr>
		<?php 
		require_once("../lib/dbconect.php");
		$dbcon = DbConnect();
		$day = date("Y-m-d");
		//表示用ユーザ情報取得
		$sql = "SELECT * FROM question 
				WHERE question_seq 
				NOT IN ( SELECT question_seq FROM question_awnser WHERE awnser_user_seq = '$user_seq' ) 
				AND '" . $day . "' BETWEEN start_date AND end_date";
		$result = mysql_query($sql);
		$cnt = mysql_num_rows($result);
		
		for($i = 0; $i < $cnt; $i++)
		{
			$row = mysql_fetch_array($result);
			?>
			<tr>
				<td><?= $row['question_title'] ?></td>
				<td><?= $row['start_date'] ?> ~ <?= $row['end_date'] ?></td>
				<td><a href="answer_regist_view.php?id=<?= $row['question_seq'] ?>">回答する</a></td>
				</tr>				
	<?php 
		}
			
		?>
		</table>
		</div>
	    	 
	    	<div data-role="footer" data-position="fixed" >
				<p>PCP2012</p>
				<a href="#" data-rel="back" data-role="button" data-icon="back"  class="ui-btn-left">戻る</a>
				<a href="../index.php" data-role="button" data-icon="home" data-iconpos="notext" class="ui-btn-right">トップへ</a>
			</div>
	</div>
	</body>
</html>