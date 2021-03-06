<?php
	session_start();

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

	$sql = "SELECT DATE_FORMAT(date,'%Y-%m') AS select_date
			FROM attendance
			GROUP BY DATE_FORMAT(date,'%Y-%m')
			ORDER BY DATE_FORMAT(date,'%Y-%m') DESC;";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);

	$sql = "SELECT DISTINCT attendance.group_seq, m_group.group_name AS group_name
			FROM attendance
			LEFT JOIN m_group ON attendance.group_seq = m_group.group_seq
			WHERE m_group.class_flg = 1
			ORDER BY attendance.group_seq";

	$result_2 = mysql_query($sql);
	$cnt = mysql_num_rows($result_2);

	Dbdissconnect($dbcon);

?>

<html>

	<head>
		<title>一覧</title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
		<script src="../javascript/frame_jump.js"></script>
		<script src="../javascript/jquery-1.8.2.min.js"></script>
		<script src="../javascript/jquery-ui-1.8.24.custom.min.js"></script>
	</head>

	<body>
	<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
			<div align="center">
				<font class="Cubicfont">一覧</font>
			</div>

			<hr color="blue"><br><br>

			<!-- 一覧テーブル作成 -->
			<p align="left">
				<font size="5"></font>
			</p>

			<div align="center">

				<!-------------------------------------------------------------------->
				<!-- 日付とクラスを検索すると、画面遷移することなく一覧が表示される -->
				<!-------------------------------------------------------------------->


				<table class="table_02">
					<tr>
						<td align="center" width="80" ><font size="5">年月</font></td>
						<td align="center" width="100"><font size="5">クラス</font></td>
						<td align="center" width="40"></td>
					</tr>

					<tr>
						<td align="center" width="80">
							<select id="date">
								<?php
									$check_flg1 = 0;
									for($i = 0; $i < $num; $i++)
									{
										$row = mysql_fetch_array($result);
										if($check_flg1 == 0)
										{

								?>
											<option value="<?= $row['select_date'] ?>" selected="selected"><?= $row['select_date'] ?></option>
								<?php
											//$_SESSION['date'] = $row['select_date'];
											$check_flg1 = 1;
										}
										else
										{

								?>
											<option value="<?= $row['select_date'] ?>"><?= $row['select_date'] ?></option>
								<?php
											//$_SESSION['date'] = $row['select_date'];
										}
									}
								?>

							</select>
						</td>


						<td align="center" width="100">
							<select id="group">
								<?php
									$check_flg2 = 0;
									 for ($i = 0; $i < $cnt; $i++)
									{
										$row = mysql_fetch_array($result_2);
										if($check_flg2 == 0)
										{
							  	?>
								<option value="<?=$row['group_seq']?>" selected="selected"><?= $row['group_name'] ?></option>
							  	<?php
							  				$check_flg2 = 1;
							  			}
							  			else
							  			{
							  	?>
								<option value="<?=$row['group_seq']?>"><?= $row['group_name'] ?></option>
								<?php
							  			}
									}
							  	?>
							</select>
						</td>
						<td align="center"width="40"><input id="search" class="button4" type = "button" value = "検索" name = "search"></td>


					</tr>
				</table>
			</div>
			<br><br><br>

			<div align="center">
				<table class="table_01" id="SearchResult" border = "1">
				</table>
			</div>
		</div>
	</body>

	<script>
		$(function() {

			$(document).on('click', '#search', function() {

				var date =  $('#date').val();
		        var group_seq =  $('#group').val();
		        $.post('_ajax_attendance_search.php', {
		            date: date,
		            group_seq : group_seq
		        },
		        //戻り値として、user_seq受け取る
		        function(rs) {

		        	var parsers = JSON.parse(rs);
		        	reWriteTable(parsers)
		        });
		    });
		});

		// テーブルに検索結果を追加
		function reWriteTable( response )
		{
			// 元にある行を削除

			$("#SearchResult tr").remove();


			$("#SearchResult").append(
				    $('<tr>').append(
					        $('<th class="name">').text("学籍番号")
			          ).append(
					        $('<th class="name">').text("クラス")
			          ).append(
					        $('<th class="name">').text("氏名")
			          ).append(
					        $('<th class="name">').text("出席")
			          ).append(
					        $('<th class="name">').text("欠席")
			          ).append(
					        $('<th class="name">').text("早退")
			          ).append(
					        $('<th class="name">').text("遅刻")
			          ).append(
					        $('<th class="name">').text("忌引")
			));

			// 取得したデータを行に入れる
			for (var i=0; i< response.length; i++) {

				//追加して表示する内容を設定
	        	var e = $(
	                    '<tr>' +
	                    '<td>'+response[i]['student_id']+'</td> ' +
	                    '<td>'+response[i]['group_name']+'</td> ' +
	                    '<td> <a href="A_details.php?id='+response[i]['user_seq']+'"> '+response[i]['user_name']+'</td> ' +
	                    '<td>'+response[i]['Attendance_flg']+'</td> ' +
	                    '<td>'+response[i]['Absence_flg']+'</td> ' +
	                    '<td>'+response[i]['Leaving_early_flg']+'</td> ' +
	                    '<td>'+response[i]['Lateness_flg']+'</td> ' +
	                    '<td>'+response[i]['Absence_due_to_mourning_flg']+'</td> ' +
	                    '</tr>'
	                );
            	//id=select_userにe要素を追加
                $('#SearchResult').append(e);
			}
		}

	</script>
</html>