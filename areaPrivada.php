<?php
	session_start();
	if (!isset($_SESSION['id_usuario'])) 
	{
		header("location: nao.html");
		exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>Area Privada</title>
	<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
	<h1 class="priv">SEJA BEM VINDO!</h1>
	<a href="index.php" class="priv"> Desconectar </a>
</body>
</html>
