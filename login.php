<?php 
// Autor: Yannick Bayard
 error_reporting(E_ALL);
	session_name("test");
	session_start();
	$_SESSION["token"]=$_POST['token'];
	session_write_close();
	$dir="".$_SESSION["token"];
	if(is_dir($dir))
	{
		header("Location: mainsite.html");
	}
	else
	{
		header("Location: failed_login.html");
	}
	exit;
// Autor: Yannick Bayard
?>