<?php

$time = time() + 60 * 60*24;


setcookie("user_seq","12",$time,"/");
setcookie("subject_seq","15","12",$time,"/");
setcookie("flg","false","12",$time,"/");

header("Location:http://49.212.201.99:3000");

?>