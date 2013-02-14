<?php
	session_start();
	if(isset($_SESSION["login_flg"]) && $_SESSION['login_flg'] == "true")
	{
		header("Location: ../index.php");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<script type="text/javascript">
if ((navigator.userAgent.indexOf('iPhone') > 0 && navigator.userAgent.indexOf('iPad') == -1) || navigator.userAgent.indexOf('iPod') > 0 || navigator.userAgent.indexOf('Android') > 0) {
	location.href = '../sp/';
}
</script>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />

<title></title>
</head>
<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align="center">
			<font class="Cubicfont">ログイン</font>
		</div>


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
	</div>
</body>
</html>