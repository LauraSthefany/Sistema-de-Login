<?php 
	require_once 'CLASSES/usuarios.php';
	$u = new Usuario;
?>
<!DOCTYPE html>
<htmllang="pt-br">
<head>
	<meta charset="utf-8"/>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
	<div id="corpo-form">
	<h1>LOGIN</h1>
	<form method="POST">
		<input type="email" placeholder=" Usuário" name="email">
		<input type="password" placeholder=" Senha" name="senha">
		<input type="submit" value="Acessar">
		<a href="cadastrar.php">Ainda não é inscrito?<strong>Cadastre-se</strong></a>
		<a href="recuperar.php">Esqueceu a senha?<strong>Recupere!</strong></a>
	</form>
</div>
<?php
if(isset($_POST['email'])){
		$email = addslashes($_POST['email']);
		$senha = addslashes($_POST['senha']);
		//verificar se esta preenchido
		if (!empty($email) && !empty($senha))
		{
			$u->conectar("login_grupo2","ec2-18-228-16-225.sa-east-1.compute.amazonaws.com","developer","dev_password");
			if ($u->msgErro == "") 
				{ 
				if ($u->logar($email,$senha)) 
				{
					header("location: areaPrivada.php");
				}
				else{
					?>
					<div class="msg-erro">Email e/ou senha estão incorretos!</div>
					<?php
				}
			}
			else{
				?>
					<div class="msg-erro"><?php echo "Erro: ".$u->msgErro;?></div>
					<?php
			}}
		else{
			?>
					<div class="msg-erro">Preencha todos os campos!</div>
					<?php
		}}
?>
</body>
</html>