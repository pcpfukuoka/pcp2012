<?php
	//SESSIONでユーザIDの取得
	session_start();
	$user_seq = $_SESSION['login_info[user]'];
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<script type="text/javascript">
			function search(){
				parent.right.location="A_search.php";
			}

			function A_list(){
				parent.right.location="A_list.php";
			}

		</script>
		<title>出欠管理</title>
	</head>

	<body>
		<div align="center">
			<font size = "7">出欠管理</font><br><br>
		</div>

		<hr color="blue">
		<br><br>

		<p align="center">

			<!-- それぞれのリンク先に移動 -->
			<input type="text"  style="border:0" name="seating_list" value="座席名簿" onclick="search()">
			<br><br>
			<input type="text" style="border:0" name="A_list" value="一覧" onclick="A_list()">
			<br><br>

		</p>
	</body>
</html>

