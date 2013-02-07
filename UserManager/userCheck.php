<?php
$user_id = $_POST['user_id'];
$pass = $_POST['pass'];
$user_name = $_POST['user_name'];
$user_kana = $_POST['user_kana'];
$user_address = $_POST['user_address'];
$user_tel = $_POST['user_tel'];
$user_email = $_POST['user_email'];
$autho_seq = $_POST['autho_seq'];

require_once("../javascript/form_reference.js");

$id_check = checkU($user_id, 'ic,pc,tc', 0, 0);
?>