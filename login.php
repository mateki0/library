<?php

session_start();
require_once 'database.php';



	$login = $_POST['login'];
	$pass = $_POST['pass'];
	
	$login = htmlentities($login, ENT_QUOTES, "UTF-8");

	if (isset($login)){
		$log = $db->prepare("SELECT * FROM users WHERE login = :login");
		$log->bindValue(":login", $login, PDO::PARAM_STR);
		$log->execute();
		$how_many_users = $log->rowCount() ;
		
		if($how_many_users>0)
		{
			$row = $log->fetch();
			if(password_verify($pass,$row['pass'])){
			
		
		
		$_SESSION['logged'] = true;
		$_SESSION['id'] = $row['id'];
		$_SESSION['login'] = $row['login'];
		$_SESSION['pass'] = $row['pass'];
		$_SESSION['email'] = $row['email'];
		$_SESSION['lastname'] = $row['lastname'];
		$_SESSION['books'] = $row['books'];
		
			
		header ('Location: index.php');
				
				
		}else{
		
		header('Location: loginPanel.php');
		echo $_SESSION['badUser'] = '<span class="error"> Wrong password</span>';

			
			}
			
			
			
			
}else{
			header('Location: loginPanel.php');
		echo $_SESSION['badUser'] = '<span class="error"> User not found</span>';
		}
	}