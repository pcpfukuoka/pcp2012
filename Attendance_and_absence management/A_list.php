<?php

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>一覧</title>
	</head>

	<body>
		<div align="center">
			<font size="7">一覧</font>
			<br>
		</div>
		<br>
		<hr color="blue"><br>

		<!-- 一覧テーブル作成 -->
		<p align="left">
			<font size="5"></font>
		</p>

		<div align="center">

					<!-------------------------------------------------------------------->
					<!-- 日付とクラスを検索すると、画面遷移することなく一覧が表示される -->
					<!-------------------------------------------------------------------->

					<table>
						<tr>
							<td align="center"width="150" bgcolor="yellow"><font size="5">日付</font></td>
							<td align="center"width="150" bgcolor="yellow"><font size="5">クラス</font></td>
							<td align="center"width="80"></td>
						</tr>

						<tr>
							<td align="center"width="150"><input type = "text" name = "serch_date"></td>
							<td align="center"width="150"><input type = "text" name = "serch_class"></td>
							<td align="center"width="80"><input class="button4" type = "submit" value = "検索" name = "g_serch"></td>
						</tr>
					</table>
		</div>
	</body>
</html>

				<?php
				for ($i = 0; $i < $count; $i++){
					$row = mysql_fetch_array($result);
				?>
					<tr>
						<td><?= $row['send_date'] ?></td>
						<td><?= $row['send_user_name'] ?></td>
						<td>
							<!-- GETでcontact_book_seqを送る -->
							<a href="view.php?id=<?= $row['contact_book_seq'] ?>"><?= $row['title'] ?></a>
						</td>
					</tr>
				<?php
				}
				?>

			</table>
			<hr>
		</div>
	</body>
</html>>