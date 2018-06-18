<?php
//if((!isset($_SESSION['logged'])) || $_SESSION['logged'] ==false){
//			header ('Location: index.php');
//			exit();
//		}

session_start();
require_once 'database.php';

// set book and date to empty after click 'give back' button
$title = $_GET['book_title'];
for($i= 1; $i<=3; $i++ ){
$del = $db->prepare("UPDATE users SET book$i = '', date$i='' WHERE book$i=:title ");
$del->bindValue(':title', $title);
$del->execute();
	// delete it aswell from borrowedbooks table
	$del2 = $db->prepare("DELETE FROM borrowedbooks WHERE title=:title ");
$del2->bindValue(':title', $title);
$del2->execute();
	
}
// give back book adds one quantity in our store
$add = $db->prepare("UPDATE books SET number = number+1 WHERE title=:title2");
$add->bindValue(':title2', $title);
$add->execute();
header ('Location: userPanel.php');
