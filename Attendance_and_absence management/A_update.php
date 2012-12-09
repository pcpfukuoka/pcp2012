<?php

	$i = 0;

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	while (isset($_POST['seq'][$i]))
	{
		$seq = $_POST['seq'][$i];

		$str = "date" . $i;
		$date = $_POST[$str];

		//echo "連番＝" . $seq . "　チェック＝" . $date;

		$sql = "UPDATE Attendance SET ";
		 switch ($date)
		 {
		 	case 1:
		 		$sql = $sql . "Attendance_flg=1,absence_flg=0,Leaving_early_flg=0,Lateness_flg=0,Absence_due_to_mourning_flg=0";
		 		break;

		 	case 2:
		 	    $sql = $sql . "Attendance_flg=0,absence_flg=1,Leaving_early_flg=0,Lateness_flg=0,Absence_due_to_mourning_flg=0";
		 	    break;

		 	case 3:
		 	    $sql = $sql . "Attendance_flg=0,absence_flg=0,Leaving_early_flg=1,Lateness_flg=0,Absence_due_to_mourning_flg=0";
		 	    break;

			case 4:
		 	    $sql = $sql . "Attendance_flg=0,absence_flg=0,Leaving_early_flg=0,Lateness_flg=1,Absence_due_to_mourning_flg=0";
		 	    break;

		   case 5:
			    $sql = $sql . "Attendance_flg=0,absence_flg=0,Leaving_early_flg=0,Lateness_flg=0,Absence_due_to_mourning_flg=1";
			    break;
		}

		$sql = $sql . " WHERE Attendance_seq='$seq'";
		//echo "<br>" . $sql;
		mysql_query($sql);

		$i++;
	}

	//データベースを閉じる
	Dbdissconnect($dbcon);

	echo "更新完了しました";
	Sleep(1);
	header("Location:A_list.php");



?>