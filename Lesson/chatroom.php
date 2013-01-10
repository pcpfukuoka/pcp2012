<?php

$time = time() + 60 * 60*24;


setcookie("user_seq","12",$time,"/");
setcookie("subject_seq","15",$time,"/");



setcookie("flg",false,$time,"/");

header("Location:http://49.212.201.99:3000");

?>