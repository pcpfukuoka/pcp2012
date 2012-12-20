<?php
        mysql_connect("105-pc", "root", "");
        mysql_select_db("sample");

        mysql_query("SET NAMES UTF8");

        $message1 = "select * from schedule";
        $message = mysql_query($message1);
		$count = mysql_num_rows($message);

		echo $count;

       for($j=0; $j<$count; $j++){
        $gyo = mysql_fetch_array($message);
        $idate = $gyo['date'];
        $ischedule =$gyo['schedule'];
            $icomment = $gyo['comment'];
            $ic_color = $gyo['color'];

            echo $idate;
            echo $ischedule;
            echo $icomment;
            echo $ic_color;
            echo "<br>";

        }
?>