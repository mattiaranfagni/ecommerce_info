<?php
	session_start();
?>
<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


<?php
	$dbh=new PDO('mysql:dbname=quintaa_ecommerce;host:127.0.0.1','quintaa','NB7U@91A');
	for($i=0;$i<count($_SESSION['carrello']);$i++) {
		$stm= $dbh->prepare('SELECT * FROM prodotti WHERE prodotti.idprodotto=:prod');
		$stm->bindValue(':prod',$_SESSION['carrello'][$i]);
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
			'</tr> ';
		}
		echo '</table>  ';
	}
?>
</html>