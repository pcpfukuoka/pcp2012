<?php
	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	$sql = "SELECT subject_seq, subject_name FROM m_subject;";

	$result = mysql_query($sql);

	$count = mysql_num_rows($result);

?>

<html>
	<head>
		<meta charset="utf-8">

	</head>

	<body>
		<form action="old_lesson_view.php" method="post">

			<input type="date" name="date" />

			<select name="subject_seq">
					<?php
		   				for ($i = 0; $i < $count; $i++)
		   				{
		   					$row = mysql_fetch_array($result);
	  				?>
	    				<option value="<?= $row['subject_seq']?>"><?= $row['subject_name'] ?></option>
	  				<?php
	    				}
	  				?>
			</select>
			<input type="submit" value="決定" />

		</form>


	</body>
</html>