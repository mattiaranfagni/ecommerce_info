<?php
	session_start();
?>
<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<?php
	if(!isset($_SESSION['idlog'])) {
		header('Location: ./signin.php');
	}
	else {
		$id=$_SESSION['idlog'];
		$logged=$_SESSION['logged'];
	}
	
?>
<body>
Ti sei loggato! <?php echo 'ID User: '.$id;?> </br>
<a href="./logout.php"> Clicca qui per sloggarti </a>
<form method="get" action="./carrello.php"> 
	<input class="btn btn-default" type="submit" value="Vedi carrello">
</form>
<?php
	$dbh=new PDO('mysql:dbname=quintaa_ecommerce;host:127.0.0.1','quintaa','NB7U@91A');
	$stm= $dbh->prepare('SELECT * FROM categorie');
	if($stm->execute()) {}
	echo ' <form method="get" action=""> <select name="categoria" onchange="submit()">';
	while($row=$stm->fetch(PDO::FETCH_ASSOC)) {
		 echo '<option value="'.$row['idcategoria'].'"';
		 if($_GET['categoria']==$row['idcategoria']) {
			 echo ' selected';
		 }
		 echo '>'.$row['descrizionecategoria'].'</option>';
	}
	echo '</select> </form>';
	if(!isset($_GET['categoria'])) 
		$_GET['categoria']=1;
	$stm= $dbh->prepare('SELECT * FROM prodotti WHERE prodotti.categorie_idcategoria=:categoria');
	$stm->bindValue(':categoria',$_GET['categoria']);
	if($stm->execute()) {}
	echo 
		'<table class="table table-striped">
		<tr>
			<th>Id prodotto</th>
			<th>Descrizione prodotto</th>
			<th>Prezzo</th>
			<th>Immagine prodotto</th>
		</tr>';
	while($row=$stm->fetch(PDO::FETCH_ASSOC)) {
		 echo 
		 ' <tr> 
			<td>'.$row['idprodotto'].'</td>'.
			'<td>'.$row['descrizioneprodotto'].'</td>'.
			'<td>'.$row['prezzo'].'</td>'.
			'<td> <img src="'.$row['imgprodotto'].'"/>'.'</td>'.
			'<td> <form method="get" action=""> <input class="btn btn-default" type="submit" name="compra" value="Compra subito"> <input type="hidden"  name="prodottocomprato" value="'.$row['idprodotto'].'"> <input type="hidden"  name="categoria" value="'.$_GET['categoria'].'">  </form>'.
		'</tr> ';
	}
	echo '</table>  ';
	if(isset($_GET['compra']) && isset($_GET['prodottocomprato'])) {
		if(count($_SESSION['carrello'])==0)
			array_push($_SESSION['carrello'],$_GET['prodottocomprato']);
		else {
			if(!array_search($_GET['prodottocomprato'],$_SESSION['carrello']))
				array_push($_SESSION['carrello'],$_GET['prodottocomprato']);
			for($i=0;$i<count($_SESSION['carrello']);$i++) 
				echo $_SESSION['carrello'][$i];
		}
	}
	else
	{
		unset($_GET['prodottocomprato']);
	}
?>
</body>
</html>