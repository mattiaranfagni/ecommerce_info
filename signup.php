<?
	session_start();
?>
<html>
<?php 
	try {
		$dbh=new PDO('mysql:dbname=quintaa_ecommerce;host:127.0.0.1','quintaa','NB7U@91A');
		$stm= $dbh->prepare('INSERT INTO utenti(username,password,email) VALUES(:user,md5(:pw),:email)');
		$stm->bindValue(':user',$_POST['username']);
		$stm->bindValue(':pw',$_POST['password']);
		$stm->bindValue(':email',$_POST['email']);
		if($stm->execute() && isset($_POST['email'])) {
			header('Location: ./signin.php');
		}
		else {
			if(isset($_POST['email'])) {
				echo 'Mail presente';
			}
		}
		
	}
	catch(PDOException $e) {
		echo 'Errore '.$e->getMessage();
	}

?>
	<form action="" method="post" onsubmit="return controlla()">
		Username: <input id="username" type="text" name="username"/> </br>
		Email: <input id="email" type="email" name="email"/> </br>
		Password: <input id="password" type="password" name="password"/> </br>
		Conferma password: <input id="password2" type="password" name="password2"/> </br>
		<input type="submit" value="OK" name="ok"/>
	</form>
	<script>
	function controlla() {
		var username=document.getElementById('username');
		var email=document.getElementById('email');
		var password=document.getElementById('password');
		var password2=document.getElementById('password2');
		if(username.value=='') {
			alert('riempi il campo username');
			return false; //non valida il form e non prosegue
		}
		if(email.value=='') {
			alert('riempi il campo email');
			return false; //non valida il form e non prosegue
		}
		if(password.value=='') {
			alert('riempi il campo password');
			return false; //non valida il form e non prosegue
		}
		else if(password.value!=password2.value) {
			alert('le due password inserite non corrispondono');
			return false;
		}
	}
	</script>
</html>