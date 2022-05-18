<?php
// Autor: Yannick Bayard	
		session_start();
		error_reporting(E_ERROR | E_PARSE);
		//only testing
		$_SESSION["token"]=1234;
		$log=json_decode($_POST["data"],TRUE);
		$dir="Download/".$_SESSION["token"]."/log.txt";
		
		$file= fopen($dir,"w+") or die("unable to open file!");
		
		for($i=0;$i<count($log);$i++)
		{
			fwrite($file,"Typ: ".$log[$i]['type']."\n"."Date: ".$log[$i]['date']."\n".		"Message: ".$log[$i]['message'][0]."\n");
		}
		fclose($file);
		
		$result->path=$dir;
		
		echo json_encode($result);
			

// Autor: Yannick Bayard 
?>