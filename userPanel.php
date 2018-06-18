<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="panelCss.css">
</head>

<body>
	<div class="all">
	
	<div class="user">
	<a href="index.php" >Back to library</a>
	</div>
	
		<table>
			<thead>
				<tr>
					<td colspan="2" class="your">Your Books:</td>
				</tr>
			</thead>
			<tbody>
				<?php
				session_start();
				require_once 'database.php';
				$id = $_SESSION['id'];
				// get this user books list
				$getBooks = $db->prepare("SELECT book1,book2,book3,date1,date2,date3 FROM users WHERE id=:id");
				$getBooks->bindValue(':id', $id);
				
				$getBooks->execute();
				
				$books = $getBooks->fetch();
	
				
				$listAll= $getBooks->fetchAll();
				

				// echo titles and dates from db in table
				if(!empty($books['book1'])){
				echo '
				<tr>
				<td> '.$books['book1'].' <a class="back" href="giveBack.php?book_title='.$books['book1'].'">Give Back</a></td>
				<td ><span class="deadline"> Deadline:'.$books['date1'].'</span><a class="extend" href="extend.php?book_title1='.$books['book1'].'">Extend</a></td>
				</tr>
				
				';
				}
				if(!empty($books['book2'])){
				echo '
				<tr>
				<td> '.$books['book2'].'<a  class="back" href="giveBack.php?book_title='.$books['book2'].'">Give Back</a></td>
				<td> <span class="deadline">Deadline:'.$books['date2'].'</span><a class="extend" href="extend.php?book_title2='.$books['book2'].'">Extend</a></td>
				</tr>
				
				';
				}
					if(!empty($books['book3'])){
				echo '
				<tr>
				<td> '.$books['book3'].' <a class="back" href="giveBack.php?book_title='.$books['book3'].'">Give Back</a></td>
				<td><span class="deadline"> Deadline:'.$books['date3'].'</span><a class="extend" href="extend.php?book_title3='.$books['book3'].'">Extend</a></td>
				</tr>
				
				';
				}
				
				?>
			</tbody>
		</table>
	</div>
	
</body>
</html>