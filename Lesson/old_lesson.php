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
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<script src="../javascript/old_lesson_js.js" type = "text/javascript"></script>
	</head>

	<body>
			<input type="date" id="date" />

			<select id="subject_seq">
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
			<input type="submit" value="決定" onclick="decision_click()"/>

		</form>


	</body>
</html>