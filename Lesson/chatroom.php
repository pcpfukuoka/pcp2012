<?php

$time = time() + 60 * 60*24;


setcookie("user_seq","9",$time,"/");
setcookie("subject_seq","5",$time,"/");
setcookie("group_seq","15",$time,"/");



setcookie("flg",true,$time,"/");

header("Location:http://49.212.201.99:3000");

?>