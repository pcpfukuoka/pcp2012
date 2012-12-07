<!-- 未完成 -->

<?php
	$group = $_POST['group'];
	$row_max = $_POST['row'];
	$col_max = $_POST['col'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//文字コード設定
	mysql_query("SET NAMES UTF8");

?>


<html>
	<head>
		<script src="../jquery-1.8.2.min.js"></script>
		<script src="./jquery.detail.click.js"></script>
		<script src="jquery.detail.click.min.js"></script>
	<style>
		.sample001 {
 			border-collapse: separate;
 			border: 1px solid #cccccc;
 			margin: 10px;
		}
		.sample001 td {
 			border: 1px solid #0066ff;
		}
		td.show01 {
 			empty-cells: show;
		}

	</style>
	</head>
	<body>
	<script>

	var seat_id = 1;
	var list_id = 101;
	var mode = "";
	var id_evc = "";
	var name_evc = "";
	var user_seq_evc ="";

    $(function() {

		$('#add').click(function(){
			$('.seat').attr({"bgcolor": "white"});

			for(var seat_id = 1; seat_id <= 100; seat_id++)
			{
				if($('#'+seat_id).children('p').text() == "")
				{
					$('#'+seat_id).attr({"bgcolor": "red"});
					break;
				}
			}

			mode ="add";
	    });

		$('#change').click(function(){
			$('.seat').attr({"bgcolor": "white"});
			mode ="change";
			seat_id = 0;
			id_evc = "";
			name_evc = "";
			user_seq_evc ="";
	    });

		$('.list').click(function(){

			if(mode == "add")
			{
				if($(this).children("p").text() != "-")
				{
					$('#' + seat_id).children('input:eq(1)').val($(this).attr("id"));
					$('#' + seat_id).attr({"bgcolor": "white"});
					$('#' + seat_id).children("p").text($(this).children("p").text());
					$(this).children("p").text('-');

					$('.seat').attr({"bgcolor": "white"});
					seat_id++;
					$('#' + seat_id).attr({"bgcolor": "red"});
				}
			}


	    });

		$('.seat').click(function(){

			if(mode == "add")
			{
				if($(this).children("p").text() != "")
				{
					list_id = $(this).children('input:eq(1)').val();
					$('#'+list_id).children('p').text($(this).children("p").text());
					$(this).children('p').text("");
				}
				else
				{
					$('.seat').attr({"bgcolor": "white"});
					seat_id = $(this).attr("id");
					$(this).attr({"bgcolor": "red"});
				}

			}
			else if(mode == "change")
			{
				if(id_evc == 0)
				{
						//一回目にクリックしたセルのデータを保存
						id_evc = $(this).attr("id");
						name_evc = $(this).children("p").text();
						user_seq_evc = $(this).children().val();

						//一回目にクリックしたセルの色を変える
						$(this).attr({"bgcolor": "yellow"});
			    }
				else
				{

						$('#' + id_evc).children("p").text($(this).children("p").text());
						$('#' + id_evc).children().attr({"value": $(this).children().val()});

						$(this).children("p").text(name_evc);
						$(this).children().attr({"value": user_seq_evc});


						//セルの色を戻す
						$('#' + id_evc).attr({"bgcolor": ""});

						seat_id = 0;
						id_evc = 0;
						name_evc = "";
						user_seq_evc = "";
						attendance_no2 = ""
				}
			}
	    });
    });
    </script>


	<form action="seat_register_add.php" method="POST">
		<table class="sample001">
<?php

	for($row = 1; $row <= $row_max; $row++)
	{
		echo "<tr>";
		$seat_id = $row;
		for($col = 1; $col <= $col_max; $col++)
		{
?>
			<td id="<?=$seat_id?>" class='seat'width='100' height='50'>
			<p></p>
			<input name = user_seq<?= $row?>[<?= $col?>] type="hidden" value = <?= $user_seq ?>>
			<input type="hidden" value="">
			</td>
<?php
			$seat_id = $seat_id + $row_max;
		}
		echo "</tr>";
	}


?>
		</table>
		<input id="add" type="button" value="追加">
		<input id="change" type="button" value="入れ替え">
		<input type="submit" value="登録">
	</form>



	<?php


		$sql = "SELECT m_user.user_seq,m_user.user_name
					from group_details,m_user
						where group_details.group_seq = '$group'
							and group_details.user_seq = m_user.user_seq";


		//echo $sql;

		$result = mysql_query($sql);
		$count = mysql_num_rows($result);


		echo "<table>";
		$list_id = 101;
		while($row = mysql_fetch_array($result))
		{
			echo "<tr>";
?>
			<td id="<?=$list_id ?>"class="list"><p><?=$row['user_name'] ?></p></td>
<?php
			echo "</tr>";
			$list_id++;
		}


		echo "<table>";


		echo "<input name=group type=hidden value=$group>";
		echo "<input name=row_max type=hidden value=$row_max>";
		echo "<input name=col_max type=hidden value=$col_max>";
?>



	</body>
</html>