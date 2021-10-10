<?php
	$servidor = "localhost";
	$usuario = "admin";
	$senha = "admin";
	$dbname = "estoque2";
	
	//Criar a conexao
	$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
		if ($conn){ 
			$dbase = mysqli_select_db($conn, $dbname);
			header('Location:/gestlog/pages/home.php');	
		}else{
		header('Location:/gestlog/pages/error/500.html');	
		}
