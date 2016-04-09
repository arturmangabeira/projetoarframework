<?php

/**
 * Description of configuracoes
 *
 * @author artur
 */
class ConfiguracaoCliente extends PageGrid{
	//put your code here
	private $clienteDB;
	
	public function __construct() {
		parent::__construct();
		$this->clienteDB = new ClienteDB();		
	}

	public function generatePage($args) {

		if($_SESSION["acessoAdmin"] == false){
			ARMessage::showMessage("Você não possuie acesso ao gerênciamento do sistema!",ARMessageType::AVISO);
			return;
		}
		
		switch ($args->acao) {
			case "listar":
				$fieldSet = new ARFieldSet();
				$fieldSet->legend = "Clientes";		
				
				$configUI = new ConfiguracaoClienteUI();		
				$clienteDTO = new ClienteDTO();		
				
				//$result = $clienteDTO->obterTodosDTO();
				$clienteDTO->bindContextDTO();
				$result = $this->clienteDB->obterClientes($clienteDTO);
				
				$fieldSet->addItem($configUI->gerarPaginaConfiguracoesCliente($result));
				
				$this->addItemPage($fieldSet);
			break;
			case "excluir":				
				$this->excluir();
				
				$fieldSet = new ARFieldSet();
				$fieldSet->legend = "Clientes";		
				
				$configUI = new ConfiguracaoClienteUI();		
				$clienteDTO = new ClienteDTO();		
				
				$result = $clienteDTO->obterTodosDTO();
				
				$fieldSet->addItem($configUI->gerarPaginaConfiguracoesCliente($result));
				
				$this->addItemPage($fieldSet);
			break;
		}
	}
	
	public function filtrar($param){	
		
		$configUI = new ConfiguracaoClienteUI();
		$clienteDTO = new ClienteDTO();
		
		$clienteDTO->bindContextDTO();
		
		$_REQUEST[Config::ACAO] = "listar";
		
		$result = $this->clienteDB->obterClientes($clienteDTO);
		$fieldSet = new ARFieldSet();
		$fieldSet->legend = "Clientes";
		$fieldSet->addItem($configUI->gerarPaginaConfiguracoesCliente($result));
		$this->addItemPage($fieldSet);
	}
	
	public function excluir(){
		$clienteDTO = new ClienteDTO();
		
		$clienteDTO->setId_Cliente($_REQUEST["valueid"]);
		
		$clienteDTO->excluirDTO();		
	}
}