<html>
	<head>
		<title>座席表</title>
    <script src="../jquery-1.8.2.min.js"></script>
	</head>
	<body>
	<script>

	var id = 0;
	var name1 = "";
	var name2 = "";
	var attendance_no1 = 0;
	var attendance_no2 = 0;

    $(function() {
	    $('.change').click(function(){
		if(id == 0)
		{
				//一回目にクリックしたセルのデータを保存
				id = $(this).attr("id");
				name1 = $(this).children("p").text();
				attendance_no1 = $(this).children().val();

				//一回目にクリックしたセルの色を変える
				$(this).attr({"bgcolor": "yellow"});

	    }
		else
		{

				//二回目にクリックしたセルのデータを保存
				name2 = $(this).children("p").text();
				attendance_no2 = $(this).children().val();

				//データの交換
				$(this).children("p").text(name1);
				$('#' + id).children("p").text(name2);

				$(this).children().attr({"value": attendance_no1});
				$('#' + id).children().attr({"value": attendance_no2});

				//セルの色を戻す
				$('#' + id).attr({"bgcolor": ""});

				id = 0;
				name1 = "";
				name2 = "";
				attendance_no1 = "";
				attendance_no2 = "";

		}
	    });
    });
    </script>




<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();
	mysql_query("set names utf8");

	//文字コード設定
	mysql_query("SET NAMES UTF8");


?>
	<form action="seat_change_update.php" method="POST">
	<table border = 1  cellspacing="10">
<?php
	$class = 1;
	$sql = "select max(row) as mx from seat where attendance_class_seq ='$class'";
	$res = mysql_query($sql);
	$ret = mysql_fetch_assoc($res);
	$row_max = $ret['mx'];


	$sql = "select max(col) as mx from seat where attendance_class_seq ='$class'";
	$res = mysql_query($sql);
	$ret = mysql_fetch_assoc($res);
	$col_max = $ret['mx'];

	$id = 1;
		for($row = 1; $row <= $row_max; $row++)
		{
			echo "<tr>";

			for($col = 1; $col <= $col_max; $col++)
			{
				$sql = "select user_seq from seat where attendance_class_seq ='$class' and row='$row'and col='$col'";

				$res = mysql_query($sql);
				$ret = mysql_fetch_array($res);
				$user_seq = $ret['user_seq'];


						if($user_seq == "0")
						{
							echo "<td id='$id'class='change'width='100'></td>";
						}
						else
						{
							$sql = "select user_name from m_user where user_seq='$user_seq'";
							$res = mysql_query($sql);
							$ret = mysql_fetch_array($res);
							$name = $ret['user_name'];
							echo "<td id='$id'class='change'width='100'>";?>
							<input name = user_seq<?= $row?>[<?= $col?>] type="hidden" value = <?= $user_seq ?>>
							<?php echo " <p>$name</p></td>";
						}

						echo "</td>";
						$id++;
			}
			echo "</tr>";
		}


		echo "<input name=class type=hidden value=$class>";
		echo "<input name=row_max type=hidden value=$row_max>";
		echo "<input name=col_max type=hidden value=$col_max>";
?>
	</table>
	<input type="submit" value="更新">
	</form>

	<p class="test">クリック</p>
	<p>　取得</p><p class="get">あ </p>


	</body>
</html>