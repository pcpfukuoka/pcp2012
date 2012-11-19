<?php
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	//これでDBを呼び出す関数が使えるようになる

	$flg = "false";

/*	if(isset($_POST['serch_name']))
	{
		$group_name = $_POST['serch_name'];

		$sql = "SELECT DATE_FORMAT(date,'%Y-%m') AS select_date FROM attendance GROUP BY DATE_FORMAT(date,'%Y-%m') ORDER BY DATE_FORMAT(date,'%Y/%m');";
		$result = mysql_query($sql);
		$num = mysql_num_rows($result);

		$flg = "true";
	}
*/

	$sql = "SELECT DATE_FORMAT(date,'%Y-%m') AS select_date FROM attendance GROUP BY DATE_FORMAT(date,'%Y-%m') ORDER BY DATE_FORMAT(date,'%Y/%m');";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);

	Dbdissconnect($dbcon);
?>

<html>

	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>一覧</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>

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
					<td align="center" width="80" bgcolor="yellow"><font size="5">年月</font></td>
					<td align="center" width="150" bgcolor="yellow"><font size="5">クラス</font></td>
					<td align="center" width="40"></td>
				</tr>

				<tr>
					<td align="center"width="80">
						<select>
						<option value="-1">選択</option>
							<?php
							for($i = 0; $i < $num; $i++)
							{
								$row = mysql_fetch_array($result);
							?>
								<option value="<?= $row['select_date'] ?>"><?= $row['select_date'] ?></option>

							<?php
							}
							?>

						</select>
					</td>

					<td align="center"width="150"><input type = "text" name = "class"></td>
					<td align="center"width="40"><input id="search"  class="button4" type = "button" value = "検索" name = "serch"></td>
				</tr>
			</table>
		</div>
	</body>
			<script>
		$(function() {

			//検索結果から権限を追加するための処理
			$(document).on('click', '#search', function() {
				//選択したli要素からdata-idを取得する(data-idはm_userのuser_seq)
		        //ポストでデータを送信、宛先でDB処理を行う
		        var id = 0;
		        $.post('_ajax_attendance_search.php', {
		            id: id,
		        },
		        //戻り値として、user_seq受け取る
		        function(rs) {

		        	alert(rs.length);

		        });
		    });
		});
			</script>




</html>