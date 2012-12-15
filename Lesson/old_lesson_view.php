
<?php

$date = $_POST['date'];

$subject_seq = $_POST['subject_seq'];

//データベースの呼出
require_once("../lib/dbconect.php");
$dbcon = DbConnect();

//$sql = "SELECT div_url, canvas_url FROM board WHERE date=". $date ."subject_seq=".$subject_seq .";";
$sql = "SELECT div_url FROM board WHERE date='". $date ."' AND subject_seq=15;";
$result = mysql_query($sql);

$count = mysql_num_rows($result);

?>
<html>
<head>
</head>

<body>old_lesson_view,php
<?php
	?>

</body>
</html>
