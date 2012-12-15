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
		<form action="old_lesson_view.php" method="POST">

			<input type="date" id="name" />

			<select id="subject">
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

		</form>


	</body>
</html>