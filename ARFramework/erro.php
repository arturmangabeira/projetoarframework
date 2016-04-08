<!DOCTYPE HTML>
<html lang="pt-br">
<head>
        <title>Serviços Web JTecnologia</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Artur Mangabeira">
        <!-- Bootstrap -->
        <link href="recipient/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="recipient/css/bootstrap-responsive.css" rel="stylesheet">
        <!-- Fasome -->
        <link href="recipient/fasome/css/font-awesome.min.css" rel="stylesheet">        
    </head>
<body>
	<div class="alert alert-error">
		<h4> Erro !</h4>
		<h5>Detalhe do erro: </h5>	
		<?php
			$msg = $_REQUEST["msg_error"];
			echo "<p>{$msg}</p>";	
			if(!empty($_REQUEST["msg_error_trace"])){
				echo "<h5>Pilha de execução: </h5>";
				$msgTraca = $_REQUEST["msg_error_trace"];
				echo "<p>{$msgTraca}</p>";
			}
		?>
	</div>
	<footer>
	    <hr>
	    <div class="row-fluid">
	        <div class="span3"></div>
	        <div class="span6"><p class="text-center">ARFramework – 1.0.0 - 09/06/2013 | © 2013 ARTecnologia</p></div>
	        <div class="span3"></div>
	    </div>
	</footer>
</body>
</html>