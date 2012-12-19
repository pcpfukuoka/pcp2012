
<?php

	$date = $_POST['date'];

	$subject_seq = $_POST['subject_seq'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	$sql = "SELECT div_url, canvas_url FROM board WHERE date='". $date ."' AND subject_seq=15;";
	//$sql = "SELECT div_url FROM board WHERE date='". $date ."' AND subject_seq=15;";
	$result = mysql_query($sql);

	$count = mysql_num_rows($result);


?>
<html>
	<head>
	<script src="../javascript/old_lesson_view_js.js"></script>
		<link rel="stylesheet" href="../css/old_lesson_view_css.css">

	</head>


	<body>

		<table border="0">
		<?php
			for($i = 1;$i <= $count;$i++){

				$row = mysql_fetch_array($result);
				$aaa = substr($row['div_url'],30);
				$bbb = "url(../../balckboard/public/".$aaa;
		?>

		<?php
			}

		?>

					<td>
						<div class="div_background" style="background-image:url(../images/kokuban.jpg)"id="1" onclick="aaa('../images/kokuban.jpg')">

						</div>
						<div class="div_background" style="background-image:url(../images/1529147.jpg)"id="2" onclick="aaa('../images/1529147.jpg')">

						</div>
					</td>
		</table>


	</body>
</html>
