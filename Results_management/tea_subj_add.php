<html>
<head>
<title>ページ新規追加画面</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" ></meta><?php //文字化け防止?>
</head>
<body>
<form action=".php" method="POST">
 <?php
   require_once("../lib/dbconect.php");
   $link = DbConnect();
    $sql = "SELECT _name, p_seq FROM m_ WHERE delete_flg = 0";
    $result = mysql_query($sql);
    $result_del = mysql_query($sql);
    
    $count = mysql_num_rows($result);
    
   ?>
   
   <div align = "center">
	<font size = "6">教科追加<hr><br>
	<?php 
	//ラジオボタンにより教師の追加か教科の追加また両方の追加を選択
	//両方の場合新しい先生の担当が新しい教科になる
	?>
	先生と教科<input type="radio" name="q1" value="tea_subj" checked>
	先生<input type="radio" name="q1" value="tea">
	教科<input type="radio" name="q1" value="subj">

	ページ追加</font>
	</div><br><br>
   <table border="1" width="70%"><!-- 教科のテーブル  -->
    <tr>
     <th width="50%">教科一覧</th>
     <th width="20%">チェック</th>
     </tr>
     <?php 
    for($i = 0; $i < $count; $i++)
	{
    	$row = mysql_fetch_array($result);
	?>       	
    <tr>
    <td align = "center"><?= $row['_name'] ?></td>
    <td align = "center"><input type="radio" name="subj_radio" value="subj_<?= $row['_seq'] ?>" >
    </td>
    </tr>
    <?php 
	}
    ?>
    <tr>
    <td align = "center"><input size ="15" type="text" name="subj_name"></td>
    <td align = "center"><input type="radio" name="subj_radio" value="subj_name" ></td>
    </tr></table><br>
      <br><hr>
    
    <?php
    /**********************************
     * 
     * 
     * チェックボックスで消したいページを取得し、
     * page_del_con.phpに飛ばす。
     **********************************/ 
    ?>
    <div align = "center">
		<font size = "6">先生追加画面</font>
	</div><br><br>
	<?php 
   //$sql = "SELECT teacher_seq FROM m_teacher WHERE delete_flg = 0";
   $sql = "SELECT teacher_seq subject_seq user_seq FROM m_teacher";
   $result = mysql_query($sql);
    $count = mysql_num_rows($result);
    $sql = "SELECT user_name FROM m_user WHERE delete_flg = 0 AND ";
    $result = mysql_query($sql);
	    
    ?>
	    
	    <!-- テーブルの作成 -->
	    	<table border="1" width="100%">
	    		<tr>
	     			<th width="50%">教師名</th>
	     			<th width="30%">担当教科</th>
	     			<th width = "20%">チェック</th>
	     		</tr>
	     		
	     		<?php 
	     		for($i = 0; $i < $count; $i++)
				{
			    	$row = mysql_fetch_array($result);
			    	
			    	$sql = "SELECT user_name FROM m_user WHERE delete_flg = 0 AND user_seq = $row['user_seq']";
			    	$result_name = mysql_query($sql);
				?>
					<tr>
					<!-- ページ名の表示とチェックボックスの作成 -->
						<td align = "center"><?= $row['_name'] ?></td>
						<td align = "center"><input type="radio" name="tea_radio" value="tea_<?= $row['_seq'] ?>" >
						</td>
					</tr>
				<?php
				}
				?>
				<tr>
				<td align = "center"><input size ="15" type="text" name="tea_name"></td>
				<td align = "center"><input type="radio" name="tea_radio" value="tea_name" ></td>
				</tr>
			</table><br>
			<?php 
			Dbdissconnect($link);
			?>
			<input type = "submit" value = "確認">&nbsp;&nbsp;
			<input type = "reset" value="クリア"><br><br>
	    </form>
</body>
</html>