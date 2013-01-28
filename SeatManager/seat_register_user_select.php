<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//文字コード設定
	mysql_query("SET NAMES UTF8");

	$group = $_POST['group'];


?>

<html>
	<head>
		<title>user_select</title>
		<script src="../sp/js/jquery-1.8.2.min.js"></script>
			<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
			<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
			<link rel="stylesheet" type="text/css" href="../css/table.css" />
			<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<style>

			.left_box{
				float:left;
				width:300px;
				margin-left:20px;
				margin-right:20px;
			}
			.right_box{
				float:left;
				width:200px;
				margin-left:20px;
				margin-right:20px;
			}
			.user_list {
				width:300px;
				height:300px;
				overflow:scroll;
			}
	</style>
	</head>
	<body>

	<script>
	 	 $(function() {

			var $user_cnt = $("input[type=checkbox]:checked").length;
			$('#user_cnt').text($user_cnt + "人の生徒が選択されています");

			var $row_max = $('#row_max').val();
			var $col_max = $('#col_max').val();
			var $seat_cnt = $row_max * $col_max;
			$('#seat_cnt').text($seat_cnt + "人分の座席があります");

			var $balance = $seat_cnt - $user_cnt;
			if($balance < 0)
			{
				$balance = $balance * -1;
				$('#balance').text($balance + "人分の座席が不足しています");
				$('#next').attr("disabled", "disabled");

				$('#message').children("font").text("※座席数が不足しないように調整してください");
				$('#message').children("font").css("color","red");
			}
			else
			{
				$('#balance').text($balance + "人分の座席が余っています");

				$('#message').children("font").text("※よろしければ確認画面へ進んでください");
				$('#message').children("font").css("color","blue");
			}





			$("input[type=checkbox]").click(function(){
				$user_cnt = $("input[type=checkbox]:checked").length;
				$('#user_cnt').text($user_cnt + "人の生徒が選択されています");

				$balance = $seat_cnt - $user_cnt;

				if($balance < 0)
				{
					$balance = $balance * -1;
					$('#balance').text($balance + "人分の座席が不足しています");
					$('#next').attr("disabled", "disabled");

					$('#message').children("font").text("※座席数が不足しないように調整してください");
					$('#message').children("font").css("color","red");
				}
				else
				{
					$('#balance').text($balance + "人分の座席が余っています");
					$('#next').removeAttr("disabled");

					$('#message').children("font").text("※よろしければ確認画面へ進んでください");
					$('#message').children("font").css("color","blue");
				}

			});

			$("#row_max").click(function(){
				$row_max = $('#row_max').val();
				$seat_cnt = $row_max * $col_max;
				$('#seat_cnt').text($seat_cnt + "人分の座席があります");

				$balance = $seat_cnt - $user_cnt;
				if($balance < 0)
				{
					$balance = $balance * -1;
					$('#balance').text($balance + "人分の座席が不足しています");
					$('#next').attr("disabled", "disabled");

					$('#message').children("font").text("※座席数が不足しないように調整してください");
					$('#message').children("font").css("color","red");
				}
				else
				{
					$('#balance').text($balance + "人分の座席が余っています");
					$('#next').removeAttr("disabled");

					$('#message').children("font").text("※よろしければ確認画面へ進んでください");
					$('#message').children("font").css("color","blue");
				}

			});

			$("#col_max").click(function(){
				$col_max = $('#col_max').val();
				$seat_cnt = $row_max * $col_max;
				$('#seat_cnt').text($seat_cnt + "人分の座席があります");

				$balance = $seat_cnt - $user_cnt;
				if($balance < 0)
				{
					$balance = $balance * -1;
					$('#balance').text($balance + "人分の座席が不足しています");
					$('#next').attr("disabled", "disabled");

					$('#message').children("font").text("※座席数が不足しないように調整してください");
					$('#message').children("font").css("color","red");
				}
				else
				{
					$('#balance').text($balance + "人分の座席が余っています");
					$('#next').removeAttr("disabled");

					$('#message').children("font").text("※よろしければ確認画面へ進んでください");
					$('#message').children("font").css("color","blue");
				}

			});

			$("#all_check").click(function(){
				$('#check input').attr('checked','checked');

				$user_cnt = $("input[type=checkbox]:checked").length;
				$('#user_cnt').text($user_cnt + "人の生徒が選択されています");

				$balance = $seat_cnt - $user_cnt;

				if($balance < 0)
				{
					$balance = $balance * -1;
					$('#balance').text($balance + "人分の座席が不足しています");
					$('#next').attr("disabled", "disabled");

					$('#message').children("font").text("※座席数が不足しないように調整してください");
					$('#message').children("font").css("color","red");
				}
				else
				{
					$('#balance').text($balance + "人分の座席が余っています");
					$('#next').removeAttr("disabled");

					$('#message').children("font").text("※よろしければ確認画面へ進んでください");
					$('#message').children("font").css("color","blue");
				}
			});

			//全てのチェックボックスのチェックを解除
			$("#all_lift").click(function(){
				$('#check input').removeAttr('checked');

				$user_cnt = $("input[type=checkbox]:checked").length;
				$('#user_cnt').text($user_cnt + "人の生徒が選択されています");

				$balance = $seat_cnt - $user_cnt;

				if($balance < 0)
				{
					$balance = $balance * -1;
					$('#balance').text($balance + "人分の座席が不足しています");
					$('#next').attr("disabled", "disabled");

					$('#message').children("font").text("※座席数が不足しないように調整してください");
					$('#message').children("font").css("color","red");
				}
				else
				{
					$('#balance').text($balance + "人分の座席が余っています");
					$('#next').removeAttr("disabled");

					$('#message').children("font").text("※よろしければ確認画面へ進んでください");
					$('#message').children("font").css("color","blue");
				}
			});

    	});
    </script>

<img class="bg" src="../images/blue-big.jpg" alt="" />
<div id="container">
	<div align="center">
		<font class="Cubicfont">登録選択画面</font>
	</div>
	<hr color="blue">
<div class="left_box">
	<form action="seat_register_check.php" method="POST">
	<FIELDSET style="background-color:white;height:150px;">
	    <LEGEND>
	    <b>メッセージ</b>
	    </LEGEND>
			<p id ="user_cnt">100<p>
			<p id ="seat_cnt">100</p>
			<p id = "balance"></p>
			<p id = "message"><font size="2"></font></p>
	</FIELDSET>

	<FIELDSET style="background-color:white;">
	    <LEGEND>
	    <b>座席数選択</b>
	    </LEGEND>
	    	<table>
	    		<tr>
	    			<td><p>横列：</p></td>
	    			<td>
		    			<SELECT id="row_max" name="row_max">
							<OPTION value="1">１</OPTION>
							<OPTION value="2">２</OPTION>
							<OPTION value="3">３</OPTION>
							<OPTION value="4">４</OPTION>
							<OPTION value="5">５</OPTION>
							<OPTION value="6" selected>６</OPTION>
							<OPTION value="7">７</OPTION>
							<OPTION value="8">８</OPTION>
							<OPTION value="9">９</OPTION>
						</SELECT>
					</td>
				</tr>
				<tr>
					<td><p>縦列：</p></td>
					<td>
							<SELECT id="col_max"name="col_max">
							<OPTION value="1">１</OPTION>
							<OPTION value="2">２</OPTION>
							<OPTION value="3">３</OPTION>
							<OPTION value="4">４</OPTION>
							<OPTION value="5">５</OPTION>
							<OPTION value="6" selected>６</OPTION>
							<OPTION value="7">７</OPTION>
							<OPTION value="8">８</OPTION>
							<OPTION value="9">９</OPTION>
						</SELECT>
					</td>
				</tr>
			</table>

	</FIELDSET>

	<input name= "group" type="hidden" value= "<?= $group ?>">

	<br>
	<input id="next"type="submit" class="button4" value="確認画面へ">
</div>
<div class="right_box">

	<FIELDSET style="background-color:white;">
    <LEGEND>
    <b>生徒リスト</b>
    </LEGEND>


	<div id="check" class="user_list">

	<table>
		<tr>
			<td><input style="width: 120px" id="all_check"type="button" value="すべて選択"></td>
			<td><input style="width: 120px" id="all_lift" type="button" value="すべて解除"></td>
	<table>
<?php
	$sql = "SELECT m_user.user_seq,m_user.user_name
		from group_details,m_user
			where group_details.group_seq = '$group'
				and group_details.user_seq = m_user.user_seq";
	$res = mysql_query($sql);
	while($gyo = mysql_fetch_array($res))
	{
?>
		<tr>
			<td>
				<input type="checkbox" name="user[]" value="<?= $gyo['user_seq']?>" checked="checked">
			</td>
			<td>
				<p><?= $gyo['user_name']?></p>
			</td>
		</tr>
<?php
	}
?>
	</table>
	</div>
	</FIELDSET>


	</form>
</div>
</div>
	</body>
</html>