<?php
	session_start();
?>
<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<?php 
	try {
		if(!isset($_SESSION['idlog'])) {
			$dbh=new PDO('mysql:dbname=quintaa_ecommerce;host:127.0.0.1','quintaa','NB7U@91A');
			$stm= $dbh->prepare('SELECT * FROM utenti WHERE utenti.email=:email AND utenti.password= md5(:pw)');
			$stm->bindValue(':pw',$_GET['password']);
			$stm->bindValue(':email',$_GET['email']); 
			if($stm->execute()) {}
			$sqlrows=$stm->rowCount();
			if($sqlrows==1) {
				$row=$stm->fetch(PDO::FETCH_ASSOC);
				$_SESSION['idlog']=$row['idutente'];
				echo 'login effettuato';
				$_SESSION['logged']=true;
				header('Location: ./hello.php');
			}
			else {
				$_SESSION['carrello']=Array();
				echo 'login fallito';
			}
		}
		else {
			header('Location: ./hello.php');
		}
	}
	catch(PDOException $e) {
		echo 'Errore '.$e->getMessage();
	}

?>
	<form action="" method="get" onsubmit="return controlla()">
		Email: <input id="email" type="email" name="email"/> </br>
		Password: <input id="password" type="password" name="password"/> </br>
		<input type="submit" value="OK" name="ok"/>
	</form>
	<script>
	function controlla() {
		var email=document.getElementById('email');
		var password=document.getElementById('password');
		if(email.value=='') {
			alert('riempi il campo email');
			return false; //non valida il form e non prosegue
		}
		if(password.value=='') {
			alert('riempi il campo password');
			return false; //non valida il form e non prosegue
		}
	}
	</script>
</html>