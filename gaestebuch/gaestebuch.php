<?php
/*
* Author : Patrick Lampe
* Datum : 11.01.2011
* Modul : gaestebuch
* Beschreibung : Dieses Modul stellt ein G�stebuch bereit
*/


function input()
{ 
	global $mysql, $log, $msg;
	
	if(!ISSET($_POST['send']))
	{
		//Template ausf�llen -->
		$tpl = dirname(__FILE__)."/template/gaestebuch.input.tpl";
		if(is_file($tpl))
			$template = file_get_contents($tpl);	
							
		$template = str_replace("%title%", $_REQUEST['title'], $template);
		$template = str_replace("%input%", $_REQUEST['input'], $template);
		$_SESSION['content'] .= $template;
		// <-- Template ausf�llen
		unset($_POST['title']) ;
		unset($_POST['input']) ;
	}
	else
	{

		//Template ausf�llen -->
		$tpl = dirname(__FILE__)."/template/gaestebuch.input.tpl";
		if(is_file($tpl))
			$template = file_get_contents($tpl);	
							
		$template = str_replace("%title%", $_REQUEST['title'], $template);
		$template = str_replace("%input%", $_REQUEST['input'], $template);
		$_SESSION['content'] .= $template;
		// <-- Template ausf�llen

		if(empty($_POST["title"]) AND empty($_POST["input"]))
		{
				$msg->error("Bitte f�llen sie das Feld Titel auszuf�llen und f�gen eine Nachricht hinzu");
				return;
		}
		elseif(empty($_POST["title"]))
		{
				$msg->error("Bitte f�llen sie das Feld Titel auszuf�llen");
				return;
		}
		elseif(empty($_POST['input']))
		{
				$msg->error("Sie haben vergessen ein Eintrag zu machen");
				return;
		}

				
		if(!$msg->error)
		{
			$q = mysql_query("SELECT id FROM "._PREFIX_."user WHERE loginname = '".mysql_real_escape_string($_POST['loginname'])."'");
			$o = mysql_fetch_object($q);
			$date = date('d-m-Y H:i:s');
			if($o->id == "")
			{
				$mysql->insert("gaestebuch",array('',
											  $_POST['title'],
											  $_POST['input'],
											 "Gast",
											  $date));
					
					$log->add("Erstelle G�stebucheintrag", "<loginname>Gast</loginname>");
					$msg->success("Ein G�stebucheintrag mit dem Titel ".$_POST['title']." wurde erstellt");
			}
			else
			{
				$mysql->insert("gaestebuch",array('',
											  $_POST['title'],
											  $_POST['input'],
											  $o->id
											  ));
					
					$log->add("Erstelle G�stebucheintrag", "<id>".$o->id."</id><loginname>".mysql_real_escape_string($_POST['loginname'])."</loginname>");
					$msg->success("Ein G�stebucheintrag mit dem Titel ".$_POST['title']." wurde erstellt");
							unset($_POST['title']) ;
		unset($_POST['input']) ;
			}
		} 
		else 
		{
			$msg->error("der Eintrag konnte nicht vorgenommen werden");
			unset($_POST['insert']);
			$data = input();
		}
		unset($_POST['title']) ;
		unset($_POST['input']) ;
		
	}
};
function output()
{
	global $mysql;
		unset($_POST['title']) ;
		unset($_POST['input']) ;
		
		$tpl = dirname(__FILE__)."/template/gaestebuch.output.tpl";
		if(is_file($tpl))
			$tpl = file_get_contents($tpl);
			
		$qGb = $mysql->query("SELECT * FROM "._PREFIX_."gaestebuch ORDER BY `id` desc LIMIT 0 , 30");
		while($o = mysql_fetch_object($qGb))
		{
			
				$Gb .= str_replace(array("%title%", "%content%", "%autor%", "%date%"), array($o->titel, $o->content, $o->user, $o->datetime), $tpl);
		}
		$_SESSION['content'] .= $Gb;
}


input();
		unset($_POST['title']) ;
		unset($_POST['input']) ;
output();

?>