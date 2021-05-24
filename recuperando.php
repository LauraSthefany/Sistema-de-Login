<?php
	require_once 'CLASSES/usuarios.php';
	$u = new Usuario;
	$u->conectar("login_grupo2","ec2-18-228-16-225.sa-east-1.compute.amazonaws.com","developer","dev_password");


	if (isset($_GET['codigo'])) {
		$codigo = $_GET['codigo'];
		$email_codigo = base64_decode($codigo);

		$selecionar = mysql_query("SELECT * FROM 'codigos' WHERE codigo = '$codigo' AND data1 > NOW()");
		if (mysql_num_rows($selecionar) >= 1){
			if (isset($_POST['acao']) && $_POST['acao'] == 'Alterar'){
				$nova_senha = $_POST['novasenha'];

				$atualizar = mysql_query("UPDATE 'usuarios' SET 'senha' = '$nova_senha' WHERE 'email' = 'email_codigo'");
				if ($atualizar){
					$mudar = mysql_query("DELETE FROM 'codigos' WHERE codigo='$codigo'");
					?>
							<div id="msg-sucesso">
								A senha foi alterada com sucesso!
							</div>
							<?php
				}
			}
		}
		elseif (!$selecionar) {
			die('Invalid query: ' . mysql_error());
		}
		else{
				?>
					<div class="msg-erro">
					Desculpe mas esse link já expirou!
					</div>
					<?php
			}
	}
			?>
			<!DOCTYPE html>
			<html>
			<head>
				<title>Recuperando</title>
				<link rel="stylesheet" type="text/css" href="estilo.css">
			</head>
			<body>
				<div id="corpo-form">
					<h1>ALTERE A SENHA</h1>
					<form action="" method="POST" enctype="multipart/form-data" >
						<input type="password" name="novasenha" placeholder="Nova senha">
						<input type="password" name="confSenha" placeholder="Confirmar nova senha">
						<input type="hidden" name="acao" value="Alterar">
						<input type="submit" value="Enviar">
						<a href="testando.php"><strong>Logue-se</strong></a>
						<?php 
						if(isset($_POST['novasenha'])){
						$novasenha = addslashes($_POST['novasenha']);
						$confSenha = addslashes($_POST['confSenha']);
						if ($novasenha <> $confSenha) {
						?>
							<div class="msg-erro-1">
								Senha e confirmar senha não correspondem!
							</div>
						<?php
						}	
						} 
						?>
					</form>
				</div>
			</body>
			</html>
