<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie-edge">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootst.." integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/b.." rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css..">
<title>Document</title>
<script type="text/javascript">

	function toggle_check()
	{
		var checkboxes = document.getElementsByName('id[]');
		var button = document.getElementById('toggle');
		if(button.checked == true)
		{
			for(var i in checkboxes)
			{
				checkboxes[i].checked = true;
			}
		}
		else 
		{
			for(var i in checkboxes)
			{
				checkboxes[i].checked = false;
			}
		}
	//document.getElementById("test").submit();
	}


	function toggle_check1()
	{
		var checkboxes = document.getElementsByName('id[]');
		var button = document.getElementById('toggle');
		for (var i in checkboxes)
		{
			if (checkboxes[i].checked === false)
			{
				button.checked = false;
				break;
			}
		}
		var rez = true;

		for (var i in checkboxes)
		{
			rez = rez && checkboxes[i].checked;
		}

		if (rez === true)
		{
			button.checked = true;
		}	
	}
	
</script>
</head>
<body>

<?php
	session_start();
require('connect.php');

$query = "SELECT * FROM users";
$result = mysqli_query($link, $query);

session_start();

if($_SESSION['login'] == false)
{
header('Location: logout.php'); //переадресация на страницу входа
exit();
}

if($_SESSION['username'])

//if(isset($_POST['id'])){
// $_SESSION['id']=$_POST['id'];
//}
//if(isset($_POST['id'])){
// print_r($_POST['id']);
//}
if (isset($_POST['action'])) {
//$_SESSION['login'] = false;
switch ($_POST['action']) {
case 'Lock':
//lock();
foreach($_POST['id'] as $key=>$value)
{
// and print out the values
$query = "UPDATE `users` SET `status` = '0' WHERE `users`.`id` = '$value';";
$result1 = mysqli_query($link, $query);
//echo 'The value of $_SESSION['."'".$key."'".'] is '."'".$value."'".' <br />';
}
foreach($_POST['id'] as $key=>$value)
{
print_r($_POST['id']);
if ($value == $_SESSION['id']){
$_SESSION['login'] = false;
}
}
break;
case 'Unlock':
//unlock();
foreach($_POST['id'] as $key=>$value)
{
// and print out the values
$query = "UPDATE `users` SET `status` = '1' WHERE `users`.`id` = '$value'";
$result1 = mysqli_query($link, $query);
//echo 'The value of $_SESSION['."'".$key."'".'] is '."'".$value."'".' <br />';
}
break;
case 'Remove':
//unlock();
foreach($_POST['id'] as $key=>$value)
{
// and print out the values
$query = "DELETE FROM `users` WHERE `users`.`id` = '$value'";
$result1 = mysqli_query($link, $query);
//echo 'The value of $_SESSION['."'".$key."'".'] is '."'".$value."'".' <br />';
}
foreach($_POST['id'] as $key=>$value)
{
print_r($_POST['id']);
if ($value == $_SESSION['id']){
$_SESSION['login'] = false;
}
}
break;
}
header("Location: content.php");
}
?>

<div class="container" style="width: 70%">
<form id="test" method="post">
<h3>Users</h3>
<div class="btn-toolbar">
<div class="btn-group">
<button type="submit" class="btn" name="action" value="Lock"><i class="fa fa-lock"></i></button>
<button type="submit" class="btn" name="action" value="Unlock"><i class="fa fa-unlock"></i></button>
<button type="submit" class="btn" name="action" value="Remove"><i class="fa fa-trash"></i></button>
</div>
</div>
<table class="table">
<thead class="thead-light">
<tr>
<th scope="col"><div class="checkbox" align="middle">
<input type="checkbox" id="toggle