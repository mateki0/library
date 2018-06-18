
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Borrow a book</title>
</head>
<link rel="stylesheet" href="booksCss.css">
<!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">-->


<body>

<div class="all">

	
	
	<?php
	session_start();
	
	if(isset($_SESSION['login'])){

	echo '<div class="user">Welcome <a id="nick" href="userPanel.php">'.$_SESSION['login'].'</a><a id="logout" href="logout.php">Logout</a></div> ';
	} else {
		echo '<div class="user"> Welcome Guest, please <a href="loginPanel.php">login</a> to borrow a book, or <a href="register.php">register</a> if you don&apos;t have account yet.</div>';
	}
	?>
	
	<h1 class="welcome">Welcome in our library</h1>
	<div>
	<form action="search.php"  method="post">
		<input class="search" name="search" type="text" placeholder="Search">
		<input type="submit" value="Search" name="submit" class="submit">
	</form>
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
					<th id="quant">Quantity</th>
				</tr>
				</thead>
				<tbody>
				

				<?php
					require_once "database.php";
					
					$select = $db->prepare("SELECT * FROM books ORDER BY title ASC");
					$select->execute();
					
					$list = $select->fetch();
					
					$listAll= $select-> fetchAll();
//					$query = $_POST['search'];
//					$submit = $_POST['submit'];
					
					
					
						
						if(isset($_SESSION['login'])){
					foreach($listAll as $list){
					echo '
				
					
					<tr>
						<td>'.$list['title'].'<br/><div class="borrow"><a  href="borrow.php?book_id='.$list['id'].'">Borrow</a></div></td>
						<td>'.$list['author'].'</td>
						<td>'.$list['number'].'</td>
					</tr>
					
					';
					}
					
						} else{
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
					 
					 
					?>
				</tbody>
			</table>
		</div>
		
	</div>
</div>
<!--	<input class="checkbox" type="checkbox"/>-->
</body>
</html>