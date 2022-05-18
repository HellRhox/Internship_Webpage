<?php
	if($_SESSION["login"]!=1)
	{
		header("Location: login.html");
	}
	else
	{
		echo "";
	}
?>