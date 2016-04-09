<?php	

if($_REQUEST['ajax'] != "true") { 
?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
        <title>Artur Mangabeira Framework</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Artur Mangabeira">
        <!-- Bootstrap -->
        <link href="ARFramework/lib/recipient/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="ARFramework/lib/recipient/css/bootstrap-responsive.css" rel="stylesheet">
        <!-- Fasome -->
        <link href="ARFramework/lib/recipient/fasome/css/font-awesome.min.css" rel="stylesheet">
        <!-- Css 
        <link href="recipient/estilo.css" rel="stylesheet"> -->
        <!-- Fonts -->
        <script src="ARFramework/lib/javascript/jquery/jquery-1.8.2.min.js" type="text/javascript"></script>
        <script src="ARFramework/lib/recipient/js/bootstrap.min.js" type="text/javascript"></script> 
        <script src="ARFramework/lib/recipient/js/bootbox.min.js" type="text/javascript"></script>
        <?php if(!empty($_SESSION["tipo_acesso"]) && $_SESSION["tipo_acesso"] == "C") {?>
        <script src='https://www.google.com/recaptcha/api.js'></script>        
        <?php } ?>
    </head>
<body>
<?php 
}
if ($_REQUEST['designer'] != "false" && $_REQUEST['ajax'] != "true") {		
	//die("testes");
	if(!empty($_SESSION["acessoLogin"]) && $_REQUEST['ocultarDesigner'] != "true"){		
		//require_once 'modules/cliente.class.php';
		if($_REQUEST["modules"] != "admin" && empty($_SESSION["acessoAdmin"])){
			$cliente = new Cliente();
			echo $cliente->gerarMenuInicial()->bind();
		}else{
			if(!empty($_SESSION["acessoAdmin"]) && $_REQUEST["modules"] != "login"){
				$cliente = new Cliente();
				echo $cliente->gerarMenuInicial()->bind();
			}
		}
	}	
}
?>	