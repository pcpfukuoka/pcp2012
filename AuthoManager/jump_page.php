<html>
<head>
<?php
	//セッションの開始
	session_start();

	/****************************************************
	 * $autho_sel : メイン画面から渡された権限グループのseqを入れる
	 * 				それをセッションで受け渡す
	 ***************************************************/
	//$_SESSION['autho_sel'] = $_GET['id'];
	//$autho_sel = $_POST['autho_sel'];
	$autho_sel = $_GET['id'];

	$_SESSION['autho_sel'] = $autho_sel;

	if (isset($_POST['list']))
	{

		//一覧ボタンの処理
		header('Location: autho_list.php');
		exit;
		/*
		echo <<<EOM
		<script type="text/javascript">
				alert("aaaa");
		</script>
		*/
EOM;


	}
	elseif ( isset($_POST['edit']))
	{
		//編集ボタンの処理
		Header('Location: autho_edit.php');
		exit;
	}
	elseif ( isset($_POST['add']))
	{
		//追加ボタンの処理
		Header('Location: autho_add.php');
		exit;
	}
	elseif ( isset($_POST['reg']))
	{
		//登録ボタンの処理
		Header('Location: autho_reg.php');
		exit;
	}
	elseif ( isset($_POST['delete']))
	{
		//削除ボタンの処理
		Header('Location: autho_delete.php');
		exit;
	}
	elseif ( isset($_POST['page']))
	{
		//ページ追加ボタンの処理
		Header('Location: page_add.php');
		exit;
	}



	Header('Location: autho_main.php');
	exit;




?>
</head>
</html>