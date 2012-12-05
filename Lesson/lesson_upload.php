
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>sample</title>
</head>
<body>

<?php

$data = $_FILES['upfile'];
$date = $_POST['date'];


$data['tmp_name'];

move_uploaded_file($data['tmp_name'], '../test/');

?>

</body>
</html>