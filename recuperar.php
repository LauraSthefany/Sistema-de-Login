<!DOCTYPE html>
<html>
<?php
ini_set('smtp_port', 587);
require_once 'CLASSES/usuarios.php';
$u = new Usuario;
$u->conectar("login_grupo2","ec2-18-228-16-225.sa-east-1.compute.amazonaws.com","developer","dev_password");
?>
<head>
	<title>Recupere a sua senha</title>
	<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
	<?php
	if (isset($_POST['acao']) && $_POST['acao'] == 'recuperar'){
			$email = strip_tags(filter_input(INPUT_POST, 'emailRecupera', FILTER_SANITIZE_STRING));

			$user = "developer";
			$senha = "dev_password";
			$bd= new PDO("mysql:dbname=login_grupo2;host=ec2-18-228-16-225.sa-east-1.compute.amazonaws.com", $user, $senha);

			$verificar = $bd->prepare("SELECT email FROM usuarios WHERE email = '$email'");

				$verificar->bindValue(":e",$email);
				$verificar->execute();
				$row_cnt =$verificar->rowCOunt();

			if ($row_cnt == 1) {
				$codigo = base64_encode($email);
				$data_expirar = date('Y-m-d H:i:s', strtotime('+1 day'));

				$mensagem = '<p>Recemos uma tentativa de recuperação de senha para esse e-mail, caso não tenha sido você, desconsidere este e-mail, caso contrário clique no link abaixo<br/> <a href="localhost/Trabalho_4at/recuperando.php?codigo'.$codigo.'"> Recuperar Senha</a></p>';
				$email_remetente = 'laurasilva26@acad.charqueadas.ifsul.edu.br';

				$headers = "MIME-Version: 1.1\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\n";
				$headers .= "From: $email_remetente\n";
				$headers .= "Return-Path: $email_remetente\n";
				$headers .= "Replay-To: $email\n";

				$inserir = $bd->prepare("INSERT INTO 'codigos' SET codigo = '$codigo', data1 = '$data_expirar'");
				if ($inserir) {
					if(mail("$email", "Assunto", "$mensagem", $headers, "-f$email_remetente")){
							?>
								<div id="msg-sucesso">
									Enviamos um e-mail com um link para recuperação de senha, para o endereço de e-mail informado.
								</div>
							<?php
						}
				}
			}
	}

	?>
	<div id="corpo-form">
		<form action="" method="POST" enctype="multipart/form-data" >
					<h1 id="px">RECUPERAR SENHA</h1>
					<p>
						Para recuperar, insira o email cadastrado, o qual receberá um link para a recuperação da senha caso o mesmo corresponder a uma conta do site.
					</p>
					<br>
					<input type="text" name="emailRecupera" placeholder=" Insira o e-mail do usuário">
					<input type="hidden" name="acao" value="recuperar">
					<input type="submit" value="Enviar">
					<a href="index.php">Lembrou da senha?<strong>Logue-se</strong></a>
		</form>
	</div>
</body>
</html>