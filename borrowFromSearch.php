<?php

session_start();
require_once 'database.php';

$id = $_GET['book_id'];

$list = $db->prepare("SELECT * FROM books WHERE id=:id");
$list->bindValue(':id', $id, PDO::PARAM_INT);
$list->execute();


$rows = $list->fetch();
if($rows['number']<=0){
	$_SESSION['borrowed'] = '<span class="borrowed">We dont have this book already, sorry</span>';
	header('Location:index.php');
	
}else{
	
	
$books = $db->prepare("UPDATE books SET number=number - 1 WHERE id=:id");
$books->bindValue(':id', $id, PDO::PARAM_INT);

	$title = $rows['title'];


	$idUser = $_SESSION['id'];

	
	$bookAdd = $db->prepare("SELECT * FROM users");
	$bookAdd->execute();
	
	$bookFetch = $bookAdd->fetch();

	
	$book1 = $bookFetch['book1'];
	$book2 = $bookFetch['book2'];
	$book3 = $bookFetch['book3'];
	if(empty($book1) ){

			$borrowedBooks1 = $db->prepare("INSERT INTO borrowedbooks VALUES (:bookId, :title, :author, :idUser)");
		$borrowedBooks1->bindValue(':bookId', $id, PDO::PARAM_INT);
		$borrowedBooks1->bindValue(':title', $title, PDO::PARAM_STR);
		$borrowedBooks1->bindValue(':author', $author, PDO::PARAM_STR);
		$borrowedBooks1->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$borrowedBooks1->execute();
			

			if($book1 != $title && $book2 != $title && $book3 != $title){
		$user1 = $db->prepare("UPDATE users SET book1=:title , date1=now() + INTERVAL 30 DAY WHERE id=:idUser");
		$user1->bindValue(':idUser', $idUser,PDO::PARAM_INT);
		$user1->bindValue(':title', $title, PDO::PARAM_STR);
		$user1->execute();
		$books->execute();
		$_SESSION['borrowed'] = '<span class="borrowed">Book added to your account</span>';
				unset($_SESSION['borrowed']);
	}else{
					$_SESSION['borrowed'] = '<span class="borrowed">You already added this title</span>';
				unset($_SESSION['borrowed']);
			}
			
	
	}else if(empty($book2)) {
		
		$borrowedBooks2 = $db->prepare("INSERT INTO borrowedbooks VALUES (:bookId,:title, :author, :idUser)");
		$borrowedBooks2->bindValue(':bookId', $id, PDO::PARAM_INT);
		$borrowedBooks2->bindValue(':title', $title, PDO::PARAM_STR);
		$borrowedBooks2->bindValue(':author', $author, PDO::PARAM_STR);
		$borrowedBooks2->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$borrowedBooks2->execute();
		if($book1 != $title && $book2 != $title && $book3 != $title){
			$ok = true;
		$user1 = $db->prepare("UPDATE users SET book2=:title, date2=now() + INTERVAL 30 DAY WHERE id=:idUser");
		$user1->bindValue(':idUser', $idUser,PDO::PARAM_INT);
		$user1->bindValue(':title', $title, PDO::PARAM_STR);
		$user1->execute();
		$books->execute();
			$_SESSION['borrowed'] = '<span class="borrowed">Book added to your account</span>';
			unset($_SESSION['borrowed']);
		}else{
					$_SESSION['borrowed'] = '<span class="borrowed">You already added this title</span>';
			unset($_SESSION['borrowed']);
			}
		
	} else if (empty($book3) ) {

			$borrowedBooks3 = $db->prepare("INSERT INTO borrowedbooks VALUES (:bookId, :title, :author, :idUser)");
		$borrowedBooks3->bindValue(':bookId', $id, PDO::PARAM_INT);
		$borrowedBooks3->bindValue(':title', $title, PDO::PARAM_STR);
		$borrowedBooks3->bindValue(':author', $author, PDO::PARAM_STR);
		$borrowedBooks3->bindValue(':idUser', $idUser, PDO::PARAM_INT);
		$borrowedBooks3->execute();
		if($book1 != $title && $book2 != $title && $book3 != $title){
					$ok = true;
		$user1 = $db->prepare("UPDATE users SET book3=:title , date3=now() + INTERVAL 30 DAY WHERE id=:idUser");
		$user1->bindValue(':idUser', $idUser,PDO::PARAM_INT);
		$user1->bindValue(':title', $title, PDO::PARAM_STR);
		$user1->execute();
			$books->execute();
			
		$_SESSION['borrowed'] = '<span class="borrowed">Book added to your account</span>';
			unset($_SESSION['borrowed']);
		} else{
					$_SESSION['borrowed'] = '<span class="borrowed">You already added this title</span>';
			unset($_SESSION['borrowed']);
			}
	} else if(!empty($book1) || !empty($book2) || !empty($book3)) {
		$ok = false;
		$_SESSION['borrowed'] = '<span class="borrowed">You cannot borrow more than 3 books</span>';
		unset($_SESSION['borrowed']);
	}





header ("Location: search.php");
//	if($list->rowCount()){
//		header ('Location: index.php');
//	}

}



