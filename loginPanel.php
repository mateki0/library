
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Notepad</title>
	
	<link rel="stylesheet" href="style.css">
	
</head>
<body>
<div class="container">
	<div class="login">
	<?php
		session_start();
		
		if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
			header ('Location: index.php');
            unset($_SESSION['logged']);

		}
			
			
		if(isset($_SESSION['welcome'])){
			echo $_SESSION['welcome'];
			unset($_SESSION['welcome']);
		}
		
		?>
	<form action="login.php" method="post" class="inputs">
		<input type="text" name="login" placeholder="Login"><br/>
		<input type="password" name="pass" placeholder="Password"><br>
		<?php
		
		if(isset($_SESSION['badUser'])){
			echo $_SESSION['badUser'];
			unset($_SESSION['badUser']);
		}
		
		?>
		<input type="submit" value="Submit" id="submit">
		</form>
		<br/>
		<div class="links">
			<a href="remind.php" id="forgot">Forgot your password?</a><br/>
			<a href="register.php" id="reg">Register</a>
	</div>
	</div>
</div>

</body>
</html>