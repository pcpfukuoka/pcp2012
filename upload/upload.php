<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>sample</title>
	</head>
<body>

<?php

if (is_uploaded_file($_FILES["upfile"]["tmp_name"]))
{
	if (move_uploaded_file($_FILES["upfile"]["tmp_name"], "../Calendar/menu.jpg"))
	{
		chmod("../Calendar/menu.jpg", 0644);
		echo $_FILES["upfile"]["name"] . "をアップロードしました。<br><br><br>";

		echo "<div align = 'center'>";
		echo "<input type = 'button' value = '閉じる' onclick='window.close()' style='font-size:30px; width:100px; height:50px'>";
		echo "</div>";
	}
	else
	{
		echo "ファイルをアップロードできません。<br><br><br>";
		echo "<div align = 'center'>";
		echo "<input type = 'button' value = '閉じる' onclick='window.close()' style='font-size:30px; width:100px; height:50px'>";
		echo "</div>";


	}
}
	else
	{
		echo "ファイルが選択されていません。<br><br><br>";
		echo "<div align = 'center'>";
		echo "<input type = 'button' value = '閉じる' onclick='window.close()' style='font-size:30px; width:100px; height:50px'>";
		echo "</div>";
}

?>

</body>
</html>