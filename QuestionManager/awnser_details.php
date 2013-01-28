<?php

require_once("../lib/dbconect.php");
$dbcon = DbConnect();


$details_seq = $_GET['id'];

$sql = "SELECT question_awnser_list.question_awnser_list_seq,m_user.user_name,question_awnser_list.awnser_name 
		FROM question_details 
		right JOIN question_awnser_list ON question_details.question_details_seq = question_awnser_list.question_details_seq
		right JOIN question_awnser ON question_awnser_list.question_awnser_list_seq = question_awnser.question_awnser_list_seq
		left JOIN m_user ON question_awnser.awnser_user_seq = m_user.user_seq
		WHERE question_awnser_list.question_details_seq = '$details_seq'
		ORDER BY question_awnser_list.question_awnser_list_seq, m_user.user_seq";

$result = mysql_query($sql);
$cnt = mysql_num_rows($result);
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<META http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
	</head>
	<body>
	<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
			<table border="1">
			<tr>
				<th>回答者</th>
				<th>回答</th>
			</tr>
		<?php 
			for($i; $i < $cnt; $i++)
			{	
				$row = mysql_fetch_array($result);
			?>
			<tr>
				<td><?= $row['user_name'] ?></td>
				<td><?= $row['awnser_name'] ?></td>
			</tr>
		<?php 
			}
		?>
		</table>
		</div>
		</body>
</html>