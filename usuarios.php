<?php 
	Class Usuario{
	private $pdo;
			public $msgErro = "";//tudo ok

			public function conectar($nome, $host, $usuario, $senha)
			{
				global $pdo;
				global $msgErro;
				try 
				{
					$pdo = new PDO("mysql:dbname=".$nome.";host=".$host,$usuario,$senha);	
				} 
				catch (PDOException $e) 
				{
					$msgErro = $e->getMessage();
				}
			}

			public function cadastrar($nome, $telefone, $email, $senha)
			{
				global $pdo;

				//verificar se já existe o email cadastrado

				$sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e");
				$sql->bindValue(":e",$email);
				$sql->execute();
				if ($sql->rowCOunt() > 0) 
				{
				 return false; 	// já está cadastrada
				}
				else
				{
					// caso não, Cadastrar
					$sql = $pdo->prepare("INSERT INTO usuarios (nome, telefone, email, senha) VALUES (:n, :t, :e, :s)");
					$sql->bindValue(":n",$nome);
					$sql->bindValue(":t",$telefone);
					$sql->bindValue(":e",$email);
					$sql->bindValue(":s",md5($senha));
					$sql->execute();
					return true;
				}
			}

			public function logar($email, $senha)
			{
				global $pdo;
				//verificar se o email e senha estão cadastrados, se sim
				session_start();
				if (isset($_SESSION['data_erro'])) 
				{
					$diferenca = floor((strtotime(date('Y-m-d H:i:s')) - strtotime($_SESSION['data_erro']))/60);
					if(3 - $diferenca < 0)
					{
					$_SESSION['tentativas'] = 0;
					unset($_SESSION['tentativas']);
					}			
				}
				if (isset($_SESSION['tentativas'])and $_SESSION['tentativas'] > 5 and (3-diferenca>0)){
					?>
						<div class="msg-erro">
							Operação foi bloqueada por ter excedido o numero maximo de tentativas! 
					<?php
						if (3-diferenca < 1) 
						{
						echo "Tente novamente em".(3-diferenca)."minutos";
						}
						elseif (3-diferenca == 1) 
						{
							echo "Tente novamente em".(3-diferenca)."minuto";
						}
					?>					
						</div>
					<?php
					exit;
				}
				else
				{
					$sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e AND senha = :s");
					$sql->bindValue(":e",$email);
					$sql->bindValue(":s",md5($senha));
					$sql->execute();

					if ($sql->rowCount() > 0)
					{
					//entrar no sistema(sessão)
						$dado = $sql->fetch();
						session_start();
						$_SESSION['id_usuario'] = $dado['id_usuario'];
						return true; //logado com sucesso	
					}
					else
					{
						if (!isset($_SESSION['tentativas'])) 
						{
							$_SESSION['tentativas'] = 0;
						}
						$_SESSION['tentativas']++;
						if (!isset($_SESSION['data_erro'])) 
						{
							$_SESSION['data_erro'] = date('Y-m-d H:i:s');
						} 
						return false; //não foi possivel logar
					}
				}
			}
		}
?>
