<?php
session_start();
error_reporting(E_ERROR);
//unset($_SESSION["acessoLogin"]);
//unset($_SESSION["cod_cliente"]);
//die();
if (empty($_SESSION["acessoLogin"]) && empty($_SESSION["cod_cliente"]) && $_REQUEST["modulos"] != "admin") {
	
	//Registra o cookie caso não exista!
	if(empty($_COOKIE["ccod_cliente"])){
		setcookie("ccod_cliente",$_REQUEST["cod_cliente"]);
	}
	$cod_cliente = "";
	if(empty($_REQUEST["cod_cliente"])){
		$cod_cliente = $_COOKIE["ccod_cliente"];
	}else{
		$cod_cliente = $_REQUEST["cod_cliente"];
		$_SESSION["cod_cliente"] = "true";
	}
	//redireciona para a tela de login com o código do cliente fornecido!
	funcoes::redirecionar("index.php?modulos=login&acao=obter&cod_cliente=".$cod_cliente);
}
//caso seja uma aquisão em ajax não será exibido o conteúdo do html	
if($_REQUEST['ajax'] != "true") { 
?>
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
        <!-- Css 
        <link href="recipient/estilo.css" rel="stylesheet"> -->
        <!-- Fonts -->
        <script src="bibliotecas/javascript/jquery/jquery-1.8.2.min.js" type="text/javascript"></script>
        <script src="recipient/js/bootstrap.min.js" type="text/javascript"></script> 
        <script src="recipient/js/bootbox.min.js" type="text/javascript"></script>        
    </head>
<body>
<?php 
}
if ($_REQUEST['designer'] != "false" && $_REQUEST['ajax'] != "true") {		
	//die("testes");
	if(!empty($_SESSION["acessoLogin"]) && $_REQUEST['ocultarDesigner'] != "true"){		
		//require_once 'modulos/cliente.class.php';
		if($_REQUEST["modulos"] != "admin" && empty($_SESSION["acessoAdmin"])){
			$cliente = new Cliente();
			echo $cliente->gerarMenuInicial()->bind();
		}else{
			if(!empty($_SESSION["acessoAdmin"]) && $_REQUEST["modulos"] != "login"){
				$cliente = new Cliente();
				echo $cliente->gerarMenuInicial()->bind();
			}
		}
	}	
}
?>	