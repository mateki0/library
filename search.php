<?php


	
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Borrow a book</title>
</head>
<link rel="stylesheet" href="searchCss.css">
<!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">-->


<body>

<div class="all">

	
	
	<?php
	session_start();
	
	if(isset($_SESSION['login'])){

	echo '<div class="user">Welcome <a id="nick" href="userPanel.php">'.$_SESSION['login'].'</a><span class="logBack"><a id="logout"  href="logout.php">Logout</a><a id="backTo"  href="index.php">Back to library</a></span></div>';
	} else {
		echo '<div class="user"> Welcome Guest, please <a href="loginPanel.php">login</a> to borrow a book, or <a href="register.php">register</a> if you don&apos;t have account yet. <a style="margin-left:2%" href="index.php">Back to library</a></div>';
	}
	?>
	
	<h1 class="welcome">Welcome in our library</h1>
	
		<?php
			if(isset($_SESSION['borrowed'])){
				echo $_SESSION['borrowed'];
				unset($_SESSION['borrowed']);
			}
			
			?>
		<div class="list">
		
			<table>
				<thead>
				<tr>
					<th>Title</th>
					<th>Author</th>
					<th>Quantity</th>
				</tr>
				</thead>
				<tbody>
				

				<?php
					require_once "database.php";
					
					
					$query = $_POST['search'];
					
					$query = htmlentities($query, ENT_NOQUOTES, 'UTF-8');
					if(strlen($query)>2){
					$getList = $db->prepare("SELECT * FROM books WHERE title LIKE '%$query%' OR author LIKE '%$query%' ");
					
					$getList->execute();
					
//						echo $getList->rowCount();
					if(($getList->rowCount()) > 0){
//						header("Location: index.php");
					$list=$getList->fetch();
						$listAll=$getList->fetchAll();
					$id = $list['id'];
					$title = $list['title'];
						

					if(isset($_SESSION['login'])){
					
						
					echo '
					
					
					<tr>
						<td>'.$list['title'].'<br/><div class="borrow"><a class="borrow" href="borrow.php?book_id='.$list['id'].'">Borrow</a></div></td>
						<td>'.$list['author'].'</td>
						<td>'.$list['number'].'</td>
					</tr>
					
					';
					
					foreach($listAll as $list){
							echo '
					
					
					<tr>
						<td>'.$list['title'].'<br/><div class="borrow"><a class="borrow" href="borrow.php?book_id='.$list['id'].'">Borrow</a></div></td>
						<td>'.$list['author'].'</td>
						<td>'.$list['number'].'</td>
					</tr>
					
					';
					}
					} else{
						
						echo '
					
					
					<tr>
						<td>'.$list['title'].'<br/></td>
						<td>'.$list['author'].'</td>
						<td>'.$list['number'].'</td>
					</tr>
					
					';
					foreach($listAll as $list){
					echo '
					
					
					<tr>
						<td>'.$list['title'].'<br/></td>
						<td>'.$list['author'].'</td>
						<td>'.$list['number'].'</td>
					</tr>
					
					';
						
					
					}
					}
					
					} else{
						header('Location: index.php');
						$_SESSION['borrowed'] = '<span class="borrowed">We dont have book you&apos;re looking for.</span>';
						
					}
					}else{
						header('Location: index.php');
						$_SESSION['borrowed'] = '<span class="borrowed">Minimum query length is 3 letters.</span>';
						
					}

					?>
					

				</tbody>
			</table>
		</div>
		
	</div>
</div>
<!--	<input class="checkbox" type="checkbox"/>-->
</body>
</html>