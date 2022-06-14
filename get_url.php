<?php
	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php?erro=1');
	}

	require_once('db.class.php');

	$id_usuario = $_SESSION['id'];

	$objDB = new Db();
	$link = $objDB->conecta_mysql();

	$sql = "SELECT DATE_FORMAT(t.data_inclusao, '%d %b %Y %T') AS data_inclusao_formatada, t.url, u.usuario, t.status_http, t.body_http FROM urls AS t JOIN usuarios AS u ON(t.id_usuario = u.id) 
	WHERE id_usuario = $id_usuario ORDER BY data_inclusao DESC";

	$resultado_id = mysqli_query($link, $sql);

	if($resultado_id){

		while($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
			echo '<a href="#" class="list-group-item">';
				echo '<h4 class="list-group-item-heading">'.$registro['url'].' <small> - '.$registro['data_inclusao_formatada'].'</small></h4>';
				echo '<p class="list-group-item-text">'.'Status: '.$registro['status_http'].'</p>';
				echo '<p class="list-group-item-text">'.'Corpo: '.$registro['body_http'].'</p>';
			echo '</a>';
		}

	} else {
		echo 'Erro na consulta de urls no banco de dados.';
	}
?>