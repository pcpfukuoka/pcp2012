<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<script src="../javascript/frame_jump.js"></script>
		<title>成績管理メイン画面</title>
	</head>

	<body>
	<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align = "center">
			<font class="Cubicfont2">成績管理メイン</font><hr color="blue"><br><br><br>

		<table>
			<tr>
				<td>
					<input class="button2" type="button" value="点数一覧"onclick="jump('../Results_management/list_search.php','right')">
				</td>
			</tr>
		</table>
		<br>

		<table>
			<tr>
				<td>
					<input class="button2" type="button" value="テスト・点数登録" onclick="jump('../Results_management/res_test.php?sub=-1','right')">
				</td>
			</tr>
		</table>
		<br>

		<table>

			<tr>
				<td>
					<input class="button2" type="button" value="教師・教科追加"onclick="jump('../Results_management/tea_subj_add.php','right')">
				</td>
			</tr>
		</table>
		<br>

		<table>
			<tr>
				<td>
					<input class="button2" type="button" value="教師・教科削除"onclick="jump('../Results_management/ts_del_add.php','right')">
				</td>
			</tr>
		</table>
		<br>

		<table>
			<tr>
				<td>
					<input class="button2" type="button" value="成績確認（生徒）"onclick="jump('../Results_management/Per.ver.php','right')">
				</td>
			</tr>
		</table>




</div>

<!-- 		<a href="list_search.php">点数一覧</a>
		<a href="res_test.php">テスト・点数登録</a><br><br>
		<a href="res_main.php">出席管理</a>
		<a href="tea_subj_add.php">教師・教科追加</a><br><br>
		<a href="ts_del_add.php">教師・教科削除</a>
-->
	</div>
	</body>
</html>
