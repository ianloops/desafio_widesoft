<?php
	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php?erro=1');
	}

	require_once('db.class.php');

	$texto_url = $_POST['texto_url'];
	$id_usuario = $_SESSION['id'];
	$status_http=404;
	$body_http_response='teste';


	if($texto_url == '' || $id_usuario == ''){
		die();
	}

	$objDB = new Db();
	$link = $objDB->conecta_mysql();

	$sql = "INSERT INTO urls(id_usuario, url, status_http, body_http) values ($id_usuario, '$texto_url', $status_http, '$body_http_response')";

	mysqli_query($link, $sql);
?>