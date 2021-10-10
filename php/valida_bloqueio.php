<?php
session_start();
include_once("conexao.php");
$retorn = "go";
$usuario = $_SESSION['usuario'];
if($retorn){
	$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
	$result_senha = "SELECT id,usuario,senha FROM usuarios WHERE senha='$senha' LIMIT 1";
	//echo "$usuario - $senha";
	if((!empty($usuario)) AND (!empty($senha))){
		//Gerar a senha criptografa
		//echo password_hash($senha, PASSWORD_DEFAULT);
		//Pesquisar o usuário no BD
		$result_usuario = "SELECT id,usuario,senha FROM usuarios WHERE usuario='$usuario' LIMIT 1";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		if($resultado_usuario){
			$row_usuario = mysqli_fetch_assoc($resultado_usuario);
			if(password_verify($senha, $row_usuario['senha'])){
				$_SESSION['id'] = $row_usuario['id'];
				$_SESSION['usuario'] = $row_usuario['usuario'];			
				$_SESSION["sessiontime"] = time() + 400;
				
				header("Location:/gestlog/php/volta.html");
				/*header("Location://localhost/gestlog/pages/inicio.php");*/
			}else{
				$_SESSION['msg'] = "<div class='alert alert-danger'>Senha incorreta!</div>";
				header("Location:/gestlog/pages/tela_bloqueio.php");
			}
		}
	}else{
		$_SESSION['msg'] = "<div class='alert alert-danger'>Digite sua Senha!</div>";
		header("Location:/gestlog/pages/tela_bloqueio.php");
	}
}else{
	session_unset();
	$_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada! :(</div>"; 
	header("Location:/gestlog/pages/home.php");
}
