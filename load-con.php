<?php
// Autor: Yannick Bayard
$oldLines=0;
$newLines=1;

	header("Access-Control-Allow-Origin: *");	
	session_start();
	/*Nur zum testen da Sessions nicht 100% mit Xampp zu funktioniernen scheinen.
	* Im normal fall sollte diese Zeile entfallen da die selbe Session benutzt wird 
	* und token damit initialisiert sein sollte;
	*/
	$_SESSION['token']=1234;
	if(isset($_POST['action'])&&!empty($_POST['action']))
	{
		$action=$_POST['action'];
		switch ($action)
		{
			case 'read' :read();break;
			case 'ping' :ping($_POST['port']);break;
			
		}
	}

	function read()
	{
		$newLines=1;
		$dir=$_SESSION["token"]; // Pfad in dennen sich die einzelnen messeges sich befinden solten
		$j=0;
		if (is_dir($dir)==true)
		{
				$file=scandir($dir);
				for($i=2;$i<count($file);$i++)
				{
					$xmlFile=$dir."/".$file[$i];
		
	
					
					if(strpos($xmlFile, 'IN')!==false)
					{
						$type="Request";
					}
					else if (strpos($xmlFile, 'OUT')!==false)
					{
						$type="Response";
					}
					if(file_exists($xmlFile))
					{
						$xml_object = simplexml_load_file($xmlFile);
				
						foreach($xml_object->MessageData->attributes() as $message)
						{
							$result[$j]["type"]=$type;
							$result[$j]["date"]=sliceDate($file[$i]);
							$result[$j]["message"]=$message;
							$result[$j]["Array-Size"]=(count($file)-2);
							$newLines++;
						}
						$j++;
					}
					else
					{
						echo "Datei nicht gefunden";
					}
				}
				if($result !=null)
				{
					echo json_encode($result);
				}
		}
		else
		{
			header("Location: failed_login.html");
		}
	}
	
	function sliceDate($string)
	{
		return str_replace("'",":",str_replace("-",".",str_replace(".","",str_replace("_"," ",substr($string,(strpos($string,"_")+1),(strpos($string,".")-3))))));
	}
	
	function ping($port)
	{
		if($port==null)
		{
			echo false;
		}
		
		$fp=fsockopen('127.0.0.1',$port);
		if($fp)
		{
			echo(true);
		}
		else
		{
			echo(false);
		}
		fclose($fp);
	}
	// Autor: Yannick Bayard
?>