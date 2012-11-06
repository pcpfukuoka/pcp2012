<html>
	<head>
		<title>登録確認画面</title>
	</head>
	<body>
		入力したデータを表示します。
<?php
	$student_id = $_POST['student_id'];
	$student_name = $_POST['student_name'];
	$sex = $_POST['sex'];
	$class = $_POST['class'];
?>
		<table border="1" width="650">
			<tr>
				<td bgcolor="pink" widgh="150" align="center">生徒番号</td>
				<td><?= $student_id ?></td>
			</tr>
			<tr>
				<td bgcolor="pink" align="center">氏名</td>
				<td><?= $student_name ?></td>
			</tr>
			<tr>
				<td bgcolor="pink" align="center">性別</td>
				<td><?= $sex ?></td>
			</tr>
			<tr>
				<td bgcolor="pink" align="center">クラス</td>
				<td><?= $class ?></td>
			</tr>
		</table>
		<form action="touroku3.php" method="POST">
			<input type="hidden" name="student_id" value="<?= $student_id ?>">
			<input type="hidden" name="student_name" value="<?= $student_name ?>">
			<input type="hidden" name="sex" value="<?= $sex ?>">
			<input type="hidden" name="class" value="<?= $class ?>">
			入力内容をご確認いただき、問題なければ「登録」ボタンを押してください<br>
			<input type="submit" value="登録">
		</form>
	</body>
</html>