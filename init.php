<?php
/*
* Author : Patrick Lampe
* Datum : 11.01.2011
* Modul : gaestebuch
* Beschreibung : Dieses Modul stellt ein G�stebuch bereit
*/

global $user, $content;

	$modulename = "gaestebuch";
	$moduletitle = "G�stebuch";
	$content->addModule($modulename, $moduletitle);

	if($_GET['a'] == $modulename)
	{
		$content->pagetitle = $moduletitle;
		$path = dirname(__FILE__) . "/";
		require_once($path."gaestebuch.php");
	}

?>