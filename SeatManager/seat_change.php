<html>
	<head>
		<title>座席表</title>
    <script src="../sp/js/jquery-1.8.2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
	<link rel="stylesheet" type="text/css" href="../css/button.css" />
	<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
	<link rel="stylesheet" type="text/css" href="../css/table.css" />
	</head>
	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align="center">
			<font class="Cubicfont">席替え</font>
		</div>
		<hr color="blue">
	<script>

	var id_evc = 0;
	var name_evc = "";
	var user_seq_evc = 0;

    $(function() {
	    $('.change').click(function(){
			if(id_evc == 0)
			{
					//一回目にクリックしたセルのデータを保存
					id_evc = $(this).attr("id");
					name_evc = $(this).children("p").text();
					user_seq_evc = $(this).children().val();

					//一回目にクリックしたセルの色を変える
					$(this).css({"background": "yellow"});

		    }
			else
			{


					//データの交換
					$('#' + id_evc).children("p").text($(this).children("p").text());
					$(this).children("p").text(name_evc);

					$('#' + id_evc).children().attr({"value": $(this).children().val()});
					$(this).children().attr({"value": user_seq_evc});

					//セルの色を戻す
					$('#' + id_evc).css({"background": "burlywood"});

					id_evc = 0;
					name_evc = "";
					user_seq_evc = 0;

			}
	    });

		$('.rand').click(function()
		{
			for(var i = 0;i <= 100;i++)
			{
				var count = $('#count').val();
				var seat_no = (Math.ceil(Math.random()*count))
				var seat_no2 = (Math.ceil(Math.random()*count))


				var evc_name = $('#'+seat_no).children("p").text();
				var evc_value = $('#'+seat_no).children().val();

				$('#'+seat_no).children("p").text($('#'+seat_no2).children("p").text());
				$('#'+seat_no).children().val( $('#'+seat_no2).children().val());

				$('#'+seat_no2).children("p").text(evc_name);
				$('#'+seat_no2).children().val(evc_value);
			}
		});
    });
    </script>





<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//文字コード設定
	mysql_query("SET NAMES UTF8");


?>
	<form action="seat_change_check.php" method="POST">

	<table class="table_01">
<?php
	$group = $_POST['group'];
	$sql = "select max(row) as mx from seat where group_seq ='$group'";
	$res = mysql_query($sql);
	$ret = mysql_fetch_assoc($res);
	$row_max = $ret['mx'];


	$sql = "select max(col) as mx from seat where group_seq ='$group'";
	$res = mysql_query($sql);
	$ret = mysql_fetch_assoc($res);
	$col_max = $ret['mx'];

	$id = 1;
	$count = 0;
		for($row = 1; $row <= $row_max; $row++)
		{
			echo "<tr>";

			for($col = 1; $col <= $col_max; $col++)
			{
				$sql = "select user_seq from seat where group_seq ='$group' and row='$row'and col='$col'";

				$res = mysql_query($sql);
				$ret = mysql_fetch_array($res);
				$user_seq = $ret['user_seq'];


						if($user_seq == "0")
						{
							echo "<td id='$id'class='change'><p></p></td>";
						}
						else
						{
							$sql = "select user_name from m_user where user_seq='$user_seq'";
							$res = mysql_query($sql);
							$ret = mysql_fetch_array($res);
							$name = $ret['user_name'];
							echo "<td id='$id'class='change'>";?>
							<input name = user_seq<?= $row?>[<?= $col?>] type="hidden" value = <?= $user_seq ?>>
							<?php echo " <p>$name</p></td>";
						}

						echo "</td>";
						$id++;
						$count++;
			}
			echo "</tr>";
		}
?>

	</table>
		<input name= "group" type="hidden" value= "<?= $group ?>">
		<input name="row_max" type="hidden" value= "<?= $row_max ?>">
		<input name="col_max" type="hidden" value= "<?= $col_max ?>">
		<input name="check_flg" type="hidden" value="0">

		<table>
			<tr>
				<td>
					<input type="button" value="ランダム" class = "rand button4">
				</td>
				<td>
					<input type="submit" value="確認画面へ" class="button4">
				</td>
			</tr>
		</table>
	</form>

	<input id="count" type="hidden" value="<?= $count ?>">

	</body>
</html>