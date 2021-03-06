<?php
	require_once("../lib/dbconect.php");
	$dbcon = dbconnect();
	if(!isset($_GET['id']))
	{
		header("Location:Draft.php");
	}
	else
	{
		$contact_book_seq = $_GET['id'];
	}

	$sql = "SELECT contact_book.group_seq AS group_seq, contact_book_seq, link_contact_book_seq, reception_user_seq, m_user.user_name AS reception_user_name, title,
			contents, m_group.group_name AS group_name
			FROM contact_book
			LEFT JOIN m_user ON contact_book.reception_user_seq = m_user.user_seq
			LEFT JOIN m_group ON contact_book.group_seq = m_group.group_seq
			WHERE contact_book_seq = '$contact_book_seq';";
	$result = mysql_query($sql);
	$contact_book_row = mysql_fetch_array($result);
?>

<html>
	<head>
		<title> 送信</title>
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
		    <font class="Cubicfont">送信</font>
		  </div>

		  <hr color="blue">
		  <br>

		  <form action="relay.php" method="POST" id="input">
			  <font size="5">To： </font>

			  <?php
			  	//グループ宛て
				if($contact_book_row['group_seq'] >= 0)
				{
			  ?>
			  		<?= $contact_book_row['group_name']?><br>
			  <?php
				}
				//個人宛て
				else
				{
			  ?>
					<?= $contact_book_row['reception_user_name']?><br>
			  <?php
				}
			  ?>

			  <font size="5">件名： </font>
			  <input size="40" type="text" name="title" value="<?= $contact_book_row['title']?>"><br><br>
		      <font size="5">本文</font><br>
		      <textarea id='animated' rows="2" cols="50" name="contents"><?= $contact_book_row['contents'] ?></textarea><br>

		      <input type="hidden" value="<?= $contact_book_row['group_seq'] ?>" name="group_seq">
		      <input type="hidden" value="<?= $contact_book_row['contact_book_seq'] ?>" name="contact_book_seq">
		      <input type="hidden" value="<?= $contact_book_row['reception_user_seq'] ?>" name="reception_user_seq">
		      <input type="hidden" value="<?= $contact_book_row['link_contact_book_seq'] ?>" name="link_id">

			  <table>
			      <tr>
			      	 <td><input class="button4" type="submit" value="送信" name = "send_update"></td>
			      	 <td><input class="button4" type="submit" value="保存" name="Re_preservation"></td>
				  </tr>
			  </table>
	      </form>
	    </div>
    </body>
</html>