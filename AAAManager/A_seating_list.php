<?php

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	$A_date = $_SESSION['$A_date'];
	$group_seq = $_POST['group_seq'];

	//$sql = "SELECT * FROM m_user";
	//$result = mysql_query($sql);

//	$sql = "SELECT attendance_class_seq, attendance_class_name
//			FROM attendance_class";
//	$res = mysql_query($sql);

//	$sql = "SELECT group_seq, group_name FROM m_group WHERE class_flg = 1";
//	$result = mysql_query($sql);

/*	$sql = "SELECT max(row) as mx FROM seat WHERE group_seq='$group_seq'";
	$res = mysql_query($sql);
	$row = mysql_fetch_array($res);
	$row_max = $row['mx'];

	$sql = "SELECT max(col) as mx FROM seat WHERE group_seq ='$group_seq'";
	$res = mysql_query($sql);
	$row = mysql_fetch_array($res);
	$col_max = $row['mx'];
*/

	$sql = "SELECT user_name, user_seq
			FROM m_user WHERE user_seq IN (SELECT user_seq FROM group_details WHERE group_seq = '$group_seq');";
	$result = mysql_query($sql);

?>

<html>
	<head>
		<title>座席表</title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<script src="../javascript/frame_jump.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
			<div align="center">
				<font class="Cubicfont">座席表</font>
			</div>

			<hr color="blue">
			<br><br>

			<table border="4" align="center" bgcolor="#FFE7CE" bordercolor="#DC143C">

				<?php

					for($i = 1; $i <= 6; $i++)
					{
						echo "<tr>";

						for($j = 1; $j <= 5; $j++)
						{
							$row = mysql_fetch_array($result);
							$user_seq = $row['user_seq'];

							if($user_seq == "")
							{
								echo "<td class='sample'width='100'>";
							}
							else
							{
								$user_name = $row['user_name'];

				?>
								<td class="sample" width="200" align="center">
									<font size = "4"><?=$user_name?></font><br>
									<table align="center">
										<tr>
											<td><input type="button" data-id="<?= $user_seq?>" id="Attendance_<?=$user_seq?>" class="Attendance button5" value="出席"></td>
											<td><input type="button" data-id="<?= $user_seq?>" id="Absence_<?=$user_seq?>" class="Absence button5" value="欠席"></td>
											<td><input type="button" data-id="<?= $user_seq?>" id="Lateness_<?=$user_seq?>" class="Lateness button5" value="遅刻"></td>
										</tr>
									</table>
								</td>
				<?php
							}
							echo "</td>";
						}
						echo "</tr>";
					}

					//データベースを閉じる
					Dbdissconnect($dbcon);
				?>
			</table>
		</div>
	</body>

	<script>
		$(function() {

			//出席ボタン//
			//検索結果から権限を追加するための処理
			$(document).on('click', '.Attendance', function() {
				//選択したli要素からdata-idを取得する(data-idはm_userのuser_seq)
		        var id = $(this).data('id');
		        //ポストでデータを送信、宛先でDB処理を行う
		        $.post('_seatlist_attendance.php', {
		            id: id,
		            class: <?= $group_seq ?>
		        },
		        //戻り値として、user_seq受け取る
		        function(rs) {

		        	$('#Attendance_'+id).remove();
		        	$('#Absence_'+id).remove();
		        	$('#Lateness_'+id).remove();

		        });
		    });

			//欠席ボタン//
			//検索結果から権限を追加するための処理
			$(document).on('click', '.Absence', function() {
				//選択したli要素からdata-idを取得する(data-idはm_userのuser_seq)
		        var id = $(this).data('id');
		        //ポストでデータを送信、宛先でDB処理を行う
		        $.post('_seatlist_absence.php', {
		            id: id,
		            class: <?= $group_seq ?>
		        },
		        //戻り値として、user_seq受け取る
		        function(rs) {

		        	$('#Attendance_'+id).remove();
		        	$('#Absence_'+id).remove();
		        	$('#Lateness_'+id).remove();

		        });
		    });

			//遅刻ボタン//
			//検索結果から権限を追加するための処理
			$(document).on('click', '.Lateness', function() {
				//選択したli要素からdata-idを取得する(data-idはm_userのuser_seq)
		        var id = $(this).data('id');
		        //ポストでデータを送信、宛先でDB処理を行う
		        $.post('_seatlist_lateness.php', {
		            id: id,
		            class: <?= $group_seq ?>
		        },
		        //戻り値として、user_seq受け取る
		        function(rs) {

		        	$('#Attendance_'+id).remove();
		        	$('#Absence_'+id).remove();
		        	$('#Lateness_'+id).remove();

		        });
		    });

		});
	</script>
</html>