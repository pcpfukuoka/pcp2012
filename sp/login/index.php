<?php
	session_start();
	if(isset($_SESSION["login_flg"]) && $_SESSION['login_flg'] == "true")
	{
		header("Location:../index.php");
	}
?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<link rel="stylesheet" href="../css/jquery.mobile-1.2.0.min.css" />
		<script src="../js/jquery-1.8.2.min.js"></script>
		<script src="../js/jquery.mobile-1.2.0.min.js"></script>
					
		<title>PCP2012</title>
	</head>
	<body>
		<div data-role="page" id="login" align="center">
			<div data-role="header" data-position="fixed">
				<p>ログイン画面</p>
			</div>
			
			<div data-role="content">
				<?php
					if(isset($_SESSION['login_flg']) && $_SESSION['login_flg'] == "false")
					{
						echo "<h1>ログインに失敗しました。再度ログインしてください。</h1>";
					}
				?>		
				<form action="login.php" method="POST">
					<div data-role="fieldcontain">
						<label for="id" id="id">ID:</label>
						<input type="text" name="id">
					</div>
					
					<br>
					
					<div data-role="fieldcontain">
						<label for="pass" id="pass">パスワード：</label>
						<input type="password" name="pass">
					</div>
					
					<br>
					
					<input type="submit" value="ログイン"><br>
				</form>
			</div>
			
			<div data-role="footer" data-position="fixed">
				<p>PCP2012</p>
			</div>
		</div>
	</body>
</html>