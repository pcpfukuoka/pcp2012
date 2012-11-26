<?php

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//$sql = "SELECT * FROM m_user";
	//$result = mysql_query($sql);

	//$sql = "SELECT group_seq, group_name FROM m_group WHERE class_flg = 1";
	//$result = mysql_query($sql);

	$sql = "SELECT attendance_class_seq, attendance_class_name
			FROM attendance_class";
	$res = mysql_query($sql);

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<title>座席表</title>
		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
	</head>

	<body>
		<div align="center">
			<font size = "7">座席表</font><br><br>
		</div>

		<hr color="blue">
		<br><br>

		<table align = "center" border="1">

			<?php
				$class = $_POST['class'];
				$sql = "SELECT max(row) as mx FROM seat WHERE attendance_class_seq='$class'";
				$res = mysql_query($sql);
				$row = mysql_fetch_assoc($res);
				$row_max = $row['mx'];

				$sql = "SELECT max(col) as mx FROM seat WHERE attendance_class_seq ='$class'";
				$res = mysql_query($sql);
				$row = mysql_fetch_assoc($res);
				$col_max = $row['mx'];

				for($i = 1; $i <= $row_max; $i++)
				{
					echo "<tr>";

					for($j = 1; $j <= $col_max; $j++)
					{
						$sql = "SELECT user_seq FROM seat
								WHERE attendance_class_seq ='$class'
								AND row='$i'and col='$j'";

						$res = mysql_query($sql);
						$row = mysql_fetch_assoc($res);
						$user_seq = $row['user_seq'];

						if($user_seq == "")
						{
							echo "<td class='sample'width='100'>";
						}
						else
						{
							$sql = "SELECT user_name,user_seq FROM m_user WHERE user_seq='$user_seq'";
							$res = mysql_query($sql);
							$row = mysql_fetch_array($res);
							$user_name = $row['user_name'];
							$user_seq = $row['user_seq']
			?>
							<td class="sample" width="200" align="center">
								<?=$user_name?><br>
								<input type="button" data-id="<?= $user_seq?>" id="Attendance_<?=$user_seq?>" class="Attendance" value="出席">
								<input type="button" data-id="<?= $user_seq?>" id="Absence_<?=$user_seq?>" class="Absence" value="欠席">
								<input type="button" data-id="<?= $user_seq?>" id="Lateness_<?=$user_seq?>" class="Lateness" value="遅刻">
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
		            class: <?= $class ?>
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
		            class: <?= $class ?>
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
		            class: <?= $class ?>
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