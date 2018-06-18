<?php

session_start();
require_once 'database.php';

$title1 = $_GET['book_title1'];
$title2 = $_GET['book_title2'];
$title3 = $_GET['book_title3'];

// extend date by 30 days after click button
$update = $db->prepare("UPDATE users SET date1= date1 + INTERVAL 30 DAY WHERE book1=:title ");
$update->bindValue(':title', $title1);
$update->execute();

$update2 = $db->prepare("UPDATE users SET date2= date2 + INTERVAL 30 DAY WHERE book2=:title2 ");
$update2->bindValue(':title2', $title2);
$update2->execute();


$update3 = $db->prepare("UPDATE users SET date3= date3 + INTERVAL 30 DAY WHERE book3=:title3 ");
$update3->bindValue(':title3', $title3);
$update3->execute();

header ('Location: userPanel.php');