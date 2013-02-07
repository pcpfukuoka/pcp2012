<?php
		 //データベースの呼出
         require_once("../lib/dbconect.php");
         $dbcon = DbConnect();

         //ユーザーの件数の取り出し
	     $sql = "SELECT * FROM m_user";
	     $result = mysql_query($sql);
	     $kensu = mysql_num_rows($result);

	     //グループの件数の取り出し
	     $sql = "SELECT *
				 FROM m_group
				 WHERE delete_flg = 0";
	     $group = mysql_query($sql);
	     $count = mysql_num_rows($group);

	     //データベースを閉じる
	     DBdissconnect($dbcon);
?>

<html>
	<head>
	  <title> 新規作成</title>
	  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	  <meta http-equiv="Content-Style-Type" content="text/css">
	  <link rel="stylesheet" type="text/css" href="../css/button.css" />
	  <link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
	  <link rel="stylesheet" type="text/css" href="../css/text_display.css" />

	  <style>
			textarea {
				border:1px solid #ccc;
			}

			#animated {
				vertical-align: top;
				-webkit-transition: height 0.2s;
				-moz-transition: height 0.2s;
				transition: height 0.2s;
			}

		</style>

		<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js'></script>
		<script src='autosize.js'></script>


		<script>
			$(function(){
				$('#normal').autosize();
				$('#animated').autosize({append: "\n"});
			});
		</script>

	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">

			<div align="center">
			   <font class="Cubicfont">新規作成</font>
			</div>

			<hr color="blue">
			<br>

			<form action="relay.php" method="POST" id="input">
				  <font size="5">宛先</font>
				  <input type="radio" name="switch" value="user_seq">
				  <select name="to_user">
				  <?php
					   for ($i = 0; $i < $kensu; $i++)
					   {
					   		$row = mysql_fetch_array($result);
				  ?>
					    	<option value="<?=$row['user_seq']?>"><?= $row['user_name'] ?></option>
				  <?php
				    	}
				  ?>

				  </select>

				  <input type="radio" name="switch" value="group_seq">
				  <select name="to_group">
				  	<option value="0">全ユーザー</option>
	  				<?php
		   				for ($i = 0; $i < $count; $i++)
		   				{
		   					$row = mysql_fetch_array($group);
	  				?>
	    					<option value="<?=$row['group_seq']?>"><?= $row['group_name'] ?></option>
	  				<?php
	    				}
	  				?>
	  			  </select>
				  <br>
				  <font size="5">件名</font>
				  <input size="40" type="text" name="title"><br><br>
			      <font size="5">本文</font><br>

				  <?php
					//<textarea rows="2" cols="50" name="contents" id="message" onkeydown="textareaResize(event)"></textarea><br>
					//<textarea id='normal' name="contents" rows="2" cols="50"></textarea>
				  ?>

			      <textarea id='animated' name="contents" rows="2" cols="50"></textarea><br>

			      <!-- 隠し文字 -->
			      <input type="hidden" value="0" name="link_id">
			      <table>
			      	<tr>
			      		<td><input class="button4" type="submit" value="送信" name = "send"></td>
			      		<td><input class="button4" type="submit" value="保存" name="Preservation"></td>
				  	</tr>
				  </table>
		    </form>
	    </div>
    </body>
</html>
