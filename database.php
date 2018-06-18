<?php

$config = require_once 'config.php';

try
{
$db = new PDO("mysql:host={$config['host']};dbname={$config['database']};charset=UTF8",$config['user'], $config['password'],
				  [PDO::ATTR_EMULATE_PREPARES =>FALSE,
				   PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]
				 )	;
}


catch(PDOException $error)
{
	echo $error->getMessage();
	exit('Database error');
}