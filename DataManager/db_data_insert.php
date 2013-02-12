  <?php
      //ライブラリ読み込み
      require_once './Classes/PHPExcel.php';
      require_once './Classes/PHPExcel/IOFactory.php';
      $target = $_POST['target'];

      if($_POST{'mode'} == "upload"){
          //Excel読み込み
          $filepath = $_FILES["upload_file"]["tmp_name"];
          $objReader = PHPExcel_IOFactory::createReader('Excel5');
          $xlsObject = $objReader->load($filepath);

          // セルから値を取得
          	$xlsObject->setActiveSheetIndex(0);
          	$xlsSheet = $xlsObject->getActiveSheet();
          	#-- シート名
          	$sheetTitle = "user_data";
          	$j = 0;
          	#-- シートの行ごとに読んでいく
          	foreach ($xlsSheet->getRowIterator() as $row) {
          		$xlsCell = $row->getCellIterator();
          		$xlsCell->setIterateOnlyExistingCells(true);
          		$k = 0;
          		#-- 行のセルごとに読んでいく
          		foreach ($xlsCell as $cell) {
          			#-- 「シート名・行番号・セル番号」の連想配列にセル内のデータを格納
          			$data[$sheetTitle][$j][$k] = $cell->getCalculatedValue();
          			$k++;
          		}
          		$j++;
          	}
      }


      //ここ以降に処理を書く

      //DB接続
      require_once("../lib/dbconect.php");
      $dbcon = DbConnect();

	if($target == 1)
	{
		for($i = 0; $i < count($data[$sheetTitle]); $i++)
		{

			$user_name = $data[$sheetTitle][$i][0];
			$user_kana = $data[$sheetTitle][$i][1];
			$user_address = $data[$sheetTitle][$i][2];
			$user_tel = $data[$sheetTitle][$i][3];
			$user_email = $data[$sheetTitle][$i][4];
			$user_id = $data[$sheetTitle][$i][5];
			$pass = $data[$sheetTitle][$i][6];
			$autho_seq = $data[$sheetTitle][$i][7];
			$sql = "INSERT INTO m_user VALUES ('0', '$user_name', '$user_kana', '$user_address', '$user_tel', '$user_email', '$user_id', '$pass', '$autho_seq','0','0'); ";
			echo $sql;
			echo "<br>";
			mysql_query($sql);

			if($data[$sheetTitle][$i][8] != "0")
			{
			$user_seq = mysql_insert_id($dbcon);
			$student_id = $data[$sheetTitle][$i][8];
			$sql = "INSERT INTO m_student VALUES (0,'$user_seq','$student_id');";
			mysql_query($sql);
			echo $sql;
			echo "<br>";

			}
		}
	}else if($target == 2)
	{
		for($i = 0; $i < count($data[$sheetTitle]); $i++)
		{

		$group_seq = $data[$sheetTitle][$i][0];
		$user_seq = $data[$sheetTitle][$i][1];
		$date = $data[$sheetTitle][$i][2];
		$Attendance_seq = $data[$sheetTitle][$i][3];
		$Absence_seq = $data[$sheetTitle][$i][4];
		$Leaving_seq = $data[$sheetTitle][$i][5];
		$Letaness_seq= $data[$sheetTitle][$i][6];
		$Absence_due_to_mourning_seq = $data[$sheetTitle][$i][7];
		$sql = "INSERT INTO attendance VALUES ('0','$group_seq', '$user_seq', '$date', '$Attendance_seq', '$Absence_seq', '$Leaving_seq', '$Letaness_seq', '$Absence_due_to_mourning_seq','0','0'); ";
		echo $sql;
		echo "<br>";
		mysql_query($sql);


		}

	}

      ?>