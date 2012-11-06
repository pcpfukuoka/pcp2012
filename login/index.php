<?php
	session_start();
	if(isset($_SESSION["login_flg"]) && $_SESSION['login_flg'] == "true")
	{
		header("Location: ../index.php");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title></title>
</head>
<body>
	<div>
	<?php
		if(isset($_SESSION['login_flg']) && $_SESSION['login_flg'] == "false")
		{
			echo "<h1>ログインに失敗しました。再度ログインしてください。</h1>";
		}
		?>
	
		<form action="login.php" method="POST">
			ID：<input type="text" name="id"><br>
			パスワード：<input type="password" name="pass"><br>
			<input type="submit" value="ログイン"><br>
		</form>	
	</div>
</body>
</html>