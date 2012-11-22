<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta>
		<script src="../javascript/frame_jump.js"></script>
		<title>成績管理メイン</title>
	</head>

	<body>
		<div align = "center">
			<font size = "6">成績管理メイン画面</font><hr><br><br><br>
		</div>
		<input type="button" value="点数一覧"onclick="jump('../Results_management/list_search.php','right')">
		<input type="button" value="テスト・点数登録" onclick="jump('../Results_management/res_test.php','right')">
		<input type="button" value="出席管理"onclick="jump('../Results_management/res_main.php','right')">
		<input type="button" value="教師・教科追加"onclick="jump('../Results_management/tea_subj_add.php','right')">
		<input type="button" value="教師・教科削除"onclick="jump('../Results_management/ts_del_add.php','right')">
<!-- 		<a href="list_search.php">点数一覧</a>
		<a href="res_test.php">テスト・点数登録</a><br><br>
		<a href="res_main.php">出席管理</a>
		<a href="tea_subj_add.php">教師・教科追加</a><br><br>
		<a href="ts_del_add.php">教師・教科削除</a>
-->
	</body>
</html>
