
<?php

session_start();

	if(isset($_POST['email'])){
		$ok = true;
		
		// check login
		
		
		$login = $_POST['login'];
		if(strlen($login)<3 || strlen($login)>20){
			$ok = false;
			$_SESSION['e_login'] = "Login must have 3 to 20 letters";
		}
		
		
		
		if (ctype_alnum($login)==false){
			$ok=false;
			$_SESSION['e_login'] = "Only alphanumeric can be used";
		}
		
		// check name
		
		$name = $_POST['name'];
		if (strlen($name)<1 || strlen($name)>25){
			$ok = false;
			$_SESSION['e_name'] = "Name must have 1-25 letters";
		}
		
		
		
			if (ctype_alnum($name)==false){
			$ok=false;
			$_SESSION['e_name'] = "Only alphanumeric can be used";
		}
		
		// check and hash password
		
		$pass1 = $_POST['pass1'];
		$pass2 = $_POST['pass2'];
			if(strlen($pass1)<8 || strlen($pass1)>20){
				$ok = false;
				$_SESSION['e_pass'] = "Password must have 8-20 letters";
			}
		
		
			if($pass1 != $pass2){
				$ok = false;
				$_SESSION['e_pass'] = "Passwords must be identical";
			}
		
		$pass_hash = password_hash($pass1, PASSWORD_DEFAULT);
		// check lastname
		
		
			$lastname= $_POST['lastname'];
		if(strlen($lastname) <1 || strlen($lastname) >25){
			$ok = false;
			$_SESSION['e_lastname'] = "Lastname must have 1-25 letters";
		}
		
		// check email
		
		$email = $_POST['email'];
		$email2 = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if((filter_var($email2, FILTER_VALIDATE_EMAIL)==false) || $email != $email2){
			$ok = false;
			$_SESSION['e_email'] = "Invalid e-mail";
		}
		
		
		// check terms of use
		$terms = $_POST['check'];
		if(!isset($terms)){
			$ok = false;
			$_SESSION['e_checkbox'] = "Accept our terms of use";
		}
		
		$secret = "6LctyFkUAAAAANS4WV18jBgJhmJWjCq8_ffmYh1Z";
		
		$captcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		
		$decode = json_decode($captcha);
		if($decode->success == false){
			$ok = false;
			$_SESSION['e_captcha'] = "Verify captcha";
		}
		
		
		
		require_once 'database.php';
		
		$checkEmail = $db->prepare("SELECT id FROM users WHERE email=:email");
		$checkEmail->bindValue(':email', $email);
		$checkEmail->execute();
		
		$emailCheck = $checkEmail->rowCount();
		
		if($emailCheck>0){
			$ok = false;
			$_SESSION['e_email'] = "Email is already taken";
		}
		
		$checkLogin = $db->prepare("SELECT id FROM users WHERE login=:login");
		$checkLogin->bindValue(':login', $login);
		$checkLogin->execute();
		
		$loginCheck= $checkLogin->rowCount();
		
		if($emailCheck>0){
			$ok = false;
			$_SESSION['e_login'] = "Login is already taken";
		}
		if ($ok == true){

           $token = bin2hex(random_bytes(64));
		
		$register = $db->prepare("INSERT INTO users VALUES(NULL,:login,:pass1,:email, :lastname, '','','' ,'', '','' ,:token)");
		$register->bindValue(':login',$login, PDO::PARAM_STR);
		$register->bindValue(':pass1',$pass_hash, PDO::PARAM_STR);
		$register->bindValue(':email',$email2, PDO::PARAM_STR);
		$register->bindValue(':lastname', $lastname, PDO::PARAM_STR);
		$register->bindValue(':token', $token, PDO::PARAM_STR);

		$register->execute();
		
		
		$_SESSION['succesfull'] = true;
		
		$_SESSION['welcome'] = "U can login now";
		header('Location: loginPanel.php');
			
	}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Notepad</title>
	
	<link rel="stylesheet" href="registerCss.css">
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<div class="container">
	<div class="login">
	
	<form method="post" class="inputs">
		<input type="text" name="login" placeholder="Login"><br/>
		<?php
		if(isset ($_SESSION['e_login'])){
			echo '<div class="error">'.$_SESSION['e_login'].'</div>';
			unset($_SESSION['e_login']);
		}
		?>
		<input type="password" name="pass1" placeholder="Password"><br/>
		<?php
		
		if(isset($_SESSION['e_pass'])){
			echo	'<div class="error">'.$_SESSION['e_pass'].'</div>';
			unset($_SESSION['e_pass']);
		}
		
		?>
		
		<input type="password" name="pass2" placeholder="Confirm Password"><br/>
	
		<input type="text" name="name" placeholder="Name"><br/>
		<?php
		if(isset ($_SESSION['e_name'])){
			echo '<div class="error">'.$_SESSION['e_name'].'</div>';
			unset($_SESSION['e_name']);
		}
		?>
		<input type="text" name="lastname" placeholder="Last Name"><br/>
			<?php
		
		if(isset($_SESSION['e_lastname'])){
			echo '<div class="error">'.$_SESSION['e_lastname'].'</div>';
			unset($_SESSION['e_lastname']);
		}
		
		?>
		
		<input type="text" name="email" placeholder="E-mail"><br/>
			<?php
		
		if(isset($_SESSION['e_email'])){
			echo '<div class="error">'.$_SESSION['e_email'].'</div>';
			unset($_SESSION['e_email']);
		}
		
		?>
		<label>
		<input type="checkbox" name="check" id="checkbox"><span id="accept">Accept terms of use</span> 
			</label>
				<?php
		
		if(isset($_SESSION['e_checkbox'])){
			echo '<div class="error">'.$_SESSION['e_checkbox'].'</div>';
			unset($_SESSION['e_checkbox']);
		}
		
		?>
		<div class="g-recaptcha"  data-sitekey="6LctyFkUAAAAAIZmsxDNIZbMz6BQex4IJ7VCsbiC"></div>
				<?php
		
		if(isset($_SESSION['e_captcha'])){
			echo '<div class="error">'.$_SESSION['e_captcha'].'</div>';
			unset($_SESSION['e_captcha']);
		}
		
		?>
		<input type="submit" value="Send" id="submit">
		</form>
		<br/>
		<div class="links">
			<a href="loginPanel.php" id="back">Back to login</a><br/>
			
	</div>
	</div>
</div>

</body>
</html>