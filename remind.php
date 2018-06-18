
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Notepad</title>
	
	<link rel="stylesheet" href="remindCss.css">
	
</head>
<body>
<div class="container">
	<div class="login">
	
	<form action="RemindSystem.php" method="post" class="inputs">
		<input type="email" name="email" placeholder="E-mail"><br/>
		<input type="submit" value="Send" id="submit">
        <?php

        if(isset($_SESSION['e_email'])){
            echo '<div class="error">'.$_SESSION['e_email'].'</div>';
            unset($_SESSION['e_email']);
        }

        ?>
		</form>
		<br/>
		<div class="links">
			<a href="loginPanel.php" id="forgot">Back to login</a><br/>
			<a href="index.php" id="forgot">Back to library</a><br/>
			
	</div>
	</div>
</div>

</body>
</html>