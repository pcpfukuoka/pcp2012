<?php
	$row_max = $_POST['row_max'];
	$col_max = $_POST['col_max'];


	for($row = 1; $row <= $row_max; $row++)
	{
		for($col = 1; $col <= $col_max; $col++)
		{

			$student[$row][$col] = $_POST['student'.'$row'.'$col'];
			echo $student[$row][$col];
		}
	}
?>
