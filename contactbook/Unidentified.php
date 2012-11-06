<html>
	<head>
	　<title> 未確認</title>
	</head>
	
	<body>
	  <div align="center">
	    <font size = "7">未確認</font><br>
	  </div>
	  
	  <a href=""><font size ="4">←戻る</font></a>
	  <hr color="green">
	  <br><br><br>
	  
	  
	    <?php
         mysql_connect("tamokuteki41","root","");
         mysql_select_db("pcp2012");

         mysql_query("SET NAMES sjis"); //文字化け対策
	  
	     $sql = "select date, sender, subject FROM contact_book";
	     $result = mysql_query($sql);

	     $kensu = mysql_num_rows($result);
        ?>
	  
	  
	  <p align="center">
	    
	    <table border="1" >
	      <tr bgcolor="yellow">
	       <td><font size="5"></font>日付</td>
	       <td><font size="5"></font>FROM</td>
	       <td><font size="5"></font>件名</td>
	      </tr>
	      
	        <?php
             for($i=0; $i<$kensu; $i++){
               $gyo = mysql_fetch_array($result);
            ?>
            
           <tr>
            <td><?= $gyo[0] ?></td>
            <td><?= $gyo[1] ?></td>
            <td><?= $gyo[2] ?></td>
           </tr>
           
             <?php
              }
             ?>
               
	    
	    
	    
	    </table>
	  
	  </body>
</html>