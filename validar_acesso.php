<?php
	session_start();

	require_once('db.class.php');

	$usuario =  $_POST['usuario'];
	$senha = md5($_POST['senha']);

	$objDB = new Db();
	$link = $objDB->conecta_mysql();

	$sql = "SELECT id, usuario, email FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";

	$resultado_id = mysqli_query($link, $sql);

	if(!$resultado_id){
		echo 'Erro no sistema, favor entrar em contato com o administrador do site';
	} else{
		$dados_usuario = mysqli_fetch_array($resultado_id);
		if(!isset($dados_usuario['usuario'])){
			header('Location: index.php?erro=1');
		} else {
			$_SESSION['id'] = $dados_usuario['id'];
			$_SESSION['usuario'] = $dados_usuario['usuario'];
			$_SESSION['email'] = $dados_usuario['email'];
			
			header('Location: home.php');
		}
	}
?>