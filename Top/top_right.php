<?php
session_start();

$flg = $_SESSION['position_flg'];

if($flg == "student")
{
	header("Location:student_top.php");
}
else if($flg == "parent")
{
	header("Location:protector-top.php");
	
}
else if ($flg == "teacher")
{
	header("Location:teacher_top.php");	
}
?>
