
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	</head>
	<body>

<?php
if(isset($_POST['question_list_name']))
{
	for($i = 0; $i < count($_POST["question_list_name"]); $i++)
		{
			echo $_POST["question_list_name"][$i];
		}

}
?>
	
	
	</body>
</html>