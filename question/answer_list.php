<?php
session_start();

//GETで値がなければこのページには遷移させない
//今はテスト用にその処理は欠かないけど最終的には追加する

$user_seq = $_SESSION['login_info[user]'];

?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>
	<body>		
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
		$sql = "SELECT * FROM question WHERE question_seq NOT IN ( SELECT question_seq FROM question_awnser WHERE awnser_user_seq = '$user_seq' ) AND '" . $day . "' BETWEEN start_date AND end_date";;
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
	</body>
</html>