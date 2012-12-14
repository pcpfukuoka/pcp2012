<?php
session_start();

$title = $_POST['title'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$target_group = $_POST['target_group'];
$description = $_POST['question_description'];



//セッションに情報を格納
$_SESSION['question_info[flg]'] = "true";
$_SESSION['question_info[question_title]'] = $title;
$_SESSION['question_info[start_date]'] = $start_date;
$_SESSION['question_info[end_date]'] = $end_date;
$_SESSION['question_info[target_group]'] = $target_group;
$_SESSION['question_info[question_description]'] = $description;
