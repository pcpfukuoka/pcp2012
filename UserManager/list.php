<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
		<link rel="stylesheet" href="../css/animate.css">
		<link rel="stylesheet" href="../css/jPages.css">
		<script type="text/javascript" src="../javascript/jquery-1.8.2.min.js"></script>
		<script type="text/javascript" src="../javascript/jPages.js"></script>
		<script> 
		$(function(){
		$(".holder").jPages({ 
		containerID : "list",
		previous : "←", //前へのボタン
		next : "→", //次へのボタン
		perPage : 5, //1ページに表示する個数
		midRange : 5,
		endRange : 2,
		delay : 20, //要素間の表示速度
		animation: "flipInY" //アニメーションAnimate.cssを参考に
		});
		});
		</script>
		</head>
	<body>
	<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div class="holder"></div>
		<table class="table_01">
		<thead>
		<tr>
			<th>ユーザ名</th>
			<th>ユーザID</th>
			<th>権限名</th>
		</tr>
		</thead>
		<tbody id="list">
		<?php
		require_once("../lib/dbconect.php");
		$dbcon = DbConnect();
		//表示用ユーザ情報取得
		$sql = "SELECT user_seq,user_name, user_id, m_autho.autho_name FROM m_user  left JOIN m_autho ON m_user.autho_seq = m_autho.autho_seq AND m_autho.delete_flg = 0 WHERE m_user.delete_flg = 0 ORDER BY user_kana ASC;";
		$result = mysql_query($sql);
		$cnt = mysql_num_rows($result);

		for($i = 0; $i < $cnt; $i++)
		{
			$row = mysql_fetch_array($result);
			?>
			<tr>
				<td><a href="change_view.php?id=<?= $row['user_seq'] ?>"><?= $row['user_name'] ?></a></td>
				<td><?= $row['user_id'] ?></td>
				<td><?= $row['autho_name'] ?></td>
			</tr>
	<?php
		}

		?>
		</tbody>
		</table>
		</div>
	</body>
</html>