<?php

	$_db_host="localhost";
	$_db_datenbank="test";
	$_db_username = "root";
	$_db_passwort = "";

	$username = $_POST["uname"];
	$passwort = $_POST["passwd"];
	$Email = $_POST["email"];
	$comp = $_POST["compName"];

	$mysqli= new mysqli("$_db_host","$_db_username","$_db_passwort","$_db_datenbank");

	if($mysqli->connect_errno)
	{
		die("Keine Datenbankverbindung ,möglich".$mysqli->connect_error);
	}

	$sql="Insert into user (username,password,email,companyName)
		  Values (?,?,?,?)";
		  
	$statment=$mysqli->prepare($sql);
	$statment->bind_param('ssss',$username,password_hash($passwort,1),$Email,$comp);
	$statment->execute();
	
	header("Location:login.html");

?>