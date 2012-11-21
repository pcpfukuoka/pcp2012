<?php

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	$sql = "SELECT * FROM m_user";
	$result = mysql_query($sql);

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
							echo "<td class='sample'width='100'></td>";
						}
						else
						{
							$sql = "SELECT user_name,user_seq FROM m_user WHERE user_seq='$user_seq'";
							$res = mysql_query($sql);
							$row = mysql_fetch_array($res);
							$user_name = $row['user_name'];
							$user_seq = $row['user_seq']?>

							<td class='sample'width='150'>
							<?=$user_name?>
								<input type="button" data-id="<?=$user_seq?>" id="Attendance_<?=$user_seq?>" class="Attendance" value="出席">
								<input type="button" data-id="<?=$user_seq?>" id="Absence_<?=$user_seq?>" class="Absence" value="欠席">
								<input type="hidden" value="<?=$class ?>">
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

			//検索結果から権限を追加するための処理
			$(document).on('click', '.checkUser', function() {
				//選択したli要素からdata-idを取得する(data-idはm_userのuser_seq)
		        var id = $(this).parent().data('id');
		        //表示しているユーザ名を取得
		        var user_name = $('#user_name_'+id).html();
		        //ポストでデータを送信、宛先でDB処理を行う
		        $.post('_seatlist.php', {
		            id: id,
		            gs: <?= $group_seq ?>
		        },
		        //戻り値として、user_seq受け取る
		        function(rs) {
			        //選択した要素のIDを指定して削除
		        	$('#list_user_'+id).fadeOut(800);

					//追加して表示する内容を設定
		        	var e = $(
		                    '<li id="select_user_'+rs+'" data-id="'+rs+'">' +
		                    '<input type="checkbox" class="delete_user"> ' +
		                    '<span></span> ' +
		                    '</li>'
		                );
	            	//id=select_userにe要素を追加
	                $('#select_user').append(e).find('li:last span:eq(0)').text(user_name);
		        });
		    });

		});
	</script>
</html>