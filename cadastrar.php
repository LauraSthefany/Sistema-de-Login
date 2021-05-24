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
<body id="cds">
	<div id="corpo-form-cds">
	<h1>CADASTRO</h1>
	<form method="POST">
		<input type="text" name="nome" placeholder=" Nome Completo" maxlength="30">
		<input type="text" name="telefone" placeholder=" Telefone" maxlength="30">
		<input type="email" name="email" placeholder=" Usuário" maxlength="40">
		<input type="password" name="senha" placeholder=" Senha" maxlength="15">
		<input type="password" name="confSenha" placeholder=" Confirmar Senha">
		<input type="submit" value="Cadastrar">
		<a href="index.php">Já se cadastrou?<strong>Logue-se</strong></a>
	</form>
</div>
<?php
	//verificar se clicou no botao
	if(isset($_POST['nome'])){
		$nome = addslashes($_POST['nome']);
		$telefone = addslashes($_POST['telefone']);
		$email = addslashes($_POST['email']);
		$senha = addslashes($_POST['senha']);
		$confSenha = addslashes($_POST['confSenha']);
		//verificar se esta preenchido
		if (!empty($nome) && !empty($telefone) && !empty($email) && !empty($senha) && !empty($confSenha)){
				$u->conectar("login_grupo2","ec2-18-228-16-225.sa-east-1.compute.amazonaws.com","developer","dev_password");
				if ($u->msgErro == "") 
				{ //está tudo certo
					if ($senha == $confSenha) {
							if ($u->cadastrar($nome,$telefone,$email,$senha)) {
							?>
							<div id="msg-sucesso">
								Cadastrado com sucesso! Acesse para entrar!
							</div>
							<?php
							}
							else{
							?>
							<div class="msg-erro">
								Email já cadastrado!
							</div>
							<?php
							}}
					else{
						?>
							<div class="msg-erro">
								Senha e confirmar senha não correspondem!
							</div>
						<?php
					}}
				else{
					?>
							<div class="msg-erro">
								<?php echo "Erro: ".$u->msgErro; 
								?>
							</div>
							<?php
				}
		}
		else{
			?>
				<div class="msg-erro">
					Preencha todos os campos!
				</div>
			<?php
		}
	}
?>
</body>
</html>