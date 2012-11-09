<html>
<head>
<title>ページ新規追加画面</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
</head>
<body>
 <div align = "center">
 <font size = "6">教科追加<br>
	</font>
	</div>
 <?php 
 require_once("../lib/dbconect.php");
   $link = DbConnect();
   
   if(isset($_POST['tea_subj']))
   {
   	?>
   	<div align = "center">
   	<font size = "6">先生教科画面</font>
   	</div><br><br>
   	<?php
   	//$sql = "SELECT teacher_seq FROM m_teacher WHERE delete_flg = 0";
   	$sql = "SELECT teacher_seq subject_seq user_seq FROM m_teacher";
   	$result = mysql_query($sql);
   	$count = mysql_num_rows($result);
   	 
   	?>
   		    
   		    <!-- テーブルの作成 -->
   		    	<table border="1" width="80%">
   		    		<tr>
   		     			<th width="50%">教師名</th>
   		     			<th width="30%">担当教科</th>
   		     		</tr>
   		     		
   		     		<?php 
   		     		for($i = 0; $i < $count; $i++)
   					{
   				    	$row = mysql_fetch_array($result);
   				    	
   				    	$subject_seq = $row['subject_seq'];
   				    	$user_seq = $row['user_seq'];
   				    	
   				    	$sql = "SELECT user_name FROM m_user WHERE delete_flg = 0 AND user_seq = $user_seq";
   				    	$res_use = mysql_query($sql);
   				    	$user_name = mysql_fetch_array($res_use);
   				    	
   				    	$sql = "SELECT subject_name FROM m_subject WHERE delete_flg = 0 AND subject_seq = $subject_seq";
   				    	$res_subj = mysql_query($sql);
   				    	$subject_name = mysql_fetch_array($res_subj);
   					?>
   						<tr>
   						<!-- ページ名の表示とチェックボックスの作成 -->
   							<td align = "center"><?= $user_name['user_name'] ?></td>
   							<td align = "center"><?= $subject_name ?></td>
   						</tr>
   					<?php
   					}
   					?>
   					<tr>
   					<td align = "center"><input size ="15" type="text" name="tea_name"></td>
   					<td align = "center">選択してください</td>
   					</tr>
   				</table><br>
   				<?php 
   				Dbdissconnect($link);
   				?>
   				<input type = "submit" value = "確認">&nbsp;&nbsp;
   				<input class="button4" type="button" value="戻る" onClick="history.back()">
   	   	
   }
   elseif(isset($_POST['tea']))
   {
   }
   elseif(isset($_POST['subj']))
   {
   }
   else
   {
   	?>
   	エラー
   	<input class="button4" type="button" value="戻る" onClick="history.back()">
   	<?php
   }
   ?>
	
</body>
</html>
	