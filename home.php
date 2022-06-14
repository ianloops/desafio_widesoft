<?php
	session_start();
	if(!isset($_SESSION['usuario'])){
		header('Location: index.html?erro=1');
	}

	require_once('db.class.php');

	$objDB = new Db();
	$link = $objDB->conecta_mysql();

	$id_usuario = $_SESSION['id'];

	$sql = "SELECT COUNT(*) AS qtde_urls FROM urls WHERE id_usuario = '$id_usuario'";

	$qtde_urls = 0;
	$resultado_id = mysqli_query($link, $sql);
	
	if($resultado_id){
		$registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
		$qtde_urls = $registro['qtde_urls'];
	} else{
		echo 'Erro ao executar a query';
	}

?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Interwebs</title>
		
		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

		<script type="text/javascript">
			$(document).ready(function(){
				$('#btn_url').click(function(){
					var regex = /http[\-A-Za-z0-9+&@#\/%?=~_|$!:,.;]*:\/\/[\-A-Za-z0-9+&@#\/%?=~_|$!:,.;]*/g;
					if($('#texto_url').val().match(regex)){
						$.ajax({
							url: 'inclui_url.php',
							method: 'post',
							data: $('#form_url').serialize(),
							success: function(data){
								$('#texto_url').val('');
								atualizaUrl();
								alert('URL cadastrada com sucesso');
							}
						});
					}
				});

				function atualizaUrl(){
					$.ajax({
						url :'get_url.php',
						success: function(data){
							$('#urls').html(data);
						}
					})
				}

				atualizaUrl();
			});
		</script>
	
	</head>

	<body>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top">
	      <div class="container">
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	            <li><a href="sair.php">Sair</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">
	    	
	    	<div class="col-md-3">
	    		<div class="panel panel-default">
	    			<div class="panel-body">
	    				<h4><?= $_SESSION['usuario'] ?></h4>

	    				<hr>
	    				<div class="col-md-6">
	    					URLs<br> <?= $qtde_urls ?>
	    				</div>
	    				
	    			</div>
	    		</div>
	    	</div>
	    	<div class="col-md-9">
	    		<div class="panel panel-default">
	    			<div class="panel-body">
	    				<form id="form_url" class="input-group">
	    					<input type="url" required class="form-control" placeholder="Insira a URL" maxlength="140" id="texto_url" name="texto_url">
	    					<span class="input-group-btn">
	    						<button class="btn btn-default" id="btn_url" type="button">Rastrear</button>
	    					</span>
	    				</form>
	    			</div>

				<div id="urls" class="list-group">
					
				</div>

	    		</div>
			</div>
		</div>


	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>