<?php
	session_start();
	$_SESSION  = array(); //unset all variables, unecessary with destroy
	session_destroy();
	header('Location: ./signin.php');

?>