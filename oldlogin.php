<?php
	$_db_host="localhost";
	$_db_datenbank="test";
	$_db_username = "root";
	$_db_passwort = "";
 
	session_start();
	$_SESSION["login"]=0;
	$link= new mysqli("$_db_host","$_db_username","$_db_passwort","$_db_datenbank");
 
	if ($link->connect_errno)
	{
		die("Keine Datenbankverbindung ,möglich: " .$link->connect_error);
	}	
	
	$_username=(string)$_POST["bname"];
	$_passwort=(string)$_POST["passwd"];
	
	
	$_sql= "SELECT * FROM user WHERE
			username= ?";
	
	$statment = $link->prepare($_sql);
	$statment->bind_param('s',$_username);
	$statment->execute();
	
	$_res=$statment->get_result();
	$_anzahl = $_res->num_rows;
	
	$_SESSION["user"] = $_res->fetch_assoc();
	echo $_SESSION["user"]["password"];

	if (password_verify($_passwort,$_SESSION["user"]["password"])==true||$_passwort==$_SESSION["user"]["password"])
	{
		header("Location: mainsite.html");
		
		$_SESSION["login"]=1;

            # Das Einlogdatum in der Tabelle setzen !
            $_sql = "UPDATE user SET last_login=NOW()
                     WHERE username=?";
			$statment=$link->prepare($_sql);
			$statment->bind_param('s',$_username);
			$statment->execute();
	}
	else
	{
		header("Location:failed_login.html");
	}
	
?>