<?php

	$i = 0;
	while (isset($_POST['seq'][$i]))
	{
		$seq = $_POST['seq'][$i];
		
		$str = "date" . $i;
		$date = $_POST[$str];
		
		$sql = "UPDATE Attendance SET ";
		 switch ($date)
		 {
		 	$sql = $sql."Attendance_flg=1,absence_flg=0,"
		 }
	}
?>