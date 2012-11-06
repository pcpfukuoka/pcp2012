<?php
//session_start();
$autho_seq = 1;
//どのボタンが押されたか
//list,page,
$button_seq = 'list';
//$_SESSION['autho_sel'] = $autho_seq;
?>
<html>
<script type="text/javascript" src="../javascript/frame_jump.js">
	$(function (){


		alert("aaaaa");
	if (<?= $button_seq ?>="list")
	{
		console.log("list");
		jump("auto_management/autho_list.php", "right");
	}
	else if (<?= $button_seq ?>="edit")
	{
		console.log("reg");
		jump("auto_management/autho_edit.php", "right");
	}
	else if (<?= $button_seq ?>="add")
	{
		console.log("add");
		jump("auto_management/autho_add.php", "right");
	}
	elseif (<?= $button_seq ?>="reg")
	{
		console.log("regi");
		jump("auto_management/autho_reg.php", "right");
	}
	elseif (<?= $button_seq ?>="delete")
	{
		console.log("dele");
		jump("auto_management/autho_delete.php", "right");
	}
	elseif (<?= $button_seq?>="page")
	{
		console.log("add");
		jump("auto_management/page_add.php", "right");
	}
}
</script>
<?php
	//Header('Location: autho_main.php');
	//exit;
 ?>
</html>