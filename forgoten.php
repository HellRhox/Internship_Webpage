<?php

	$_db_host="localhost";
	$_db_datenbank="test";
	$_db_username = "root";
	$_db_passwort = "";
	$_db_tablename="user";

	$mysqli= new mysqli("$_db_host","$_db_username","$_db_passwort","$_db_datenbank");
 
	if ($mysqli->connect_errno)
	{
		die("Keine Datenbankverbindung ,möglich: " .$mysqli->connect_error);
	}

	$email=$_POST["email"];
	
	$sql="SELECT * FROM user where
	 	  email=?";
	
	$statment=$mysqli->prepare($sql);
	$statment->bind_param('s',$email);
	$statment->execute();
	
	$_res=$statment->get_result();
	
	$user=$_res->fetch_assoc();
	
	$newPassword=random_str(5);
	file_put_contents("pswd.txt",$newPassword);
	$sql="Update user Set password=?
			where id=?";
	$statment=$mysqli->prepare($sql);
	$hashedPw=password_hash($newPassword,1);
	$statment->bind_param('ss',$hashedPw,$user["ID"]);
	$statment->execute();
	
	$empfaenger=$user["email"];
	$betreff="Password Reset";
	$from ="From: Auto <auto@email.de>\n Reply-To: human@email.de\n";
	$text="Ihr neues Passwort ist $newPassword";
	
	//mail($empfaenger,$betreff,$text,$from);

	header("Location: login.html");
	
	function random_str($length,$keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') 
	{
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    if ($max < 1) {
        throw new Exception('$keyspace must be at least two characters long');
    }
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}
?>