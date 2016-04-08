<?php
/**
 * Description of configuracoes
 *
 * @author artur
 */
class ServicoMnt extends PageGrid{
	//put your code here
	private $servicoUI;
	public function __construct() {
		parent::__construct();
		$this->servicoUI = new ServicoUI();
	}

	public function generatePage($args) {
		
		if($_SESSION["acessoAdmin"] == false){
			ARMessage::showMessage("Você não possuie acesso ao gerênciamento do sistema!",ARMessageType::AVISO);
			return;
		}		
				
		 switch ($args->acao) {            
            case "editar":                 	
                $this->addItemPage($this->servicoUI->gerarPaginaServicoMNT($_REQUEST["valueid"]));
            break;           
            
            default:				
				$this->addItemPage($this->servicoUI->gerarPaginaServicoMNT(0));
			break;
		 }
	}
	
	public function salvar(){			
		
		$servicoDTO = new ServicoDTO();
				
		if(empty($_REQUEST["id_servico"])){				
					
			$servicoDTO->bindContextDTO();			
			
			$resultado = $servicoDTO->inserirDTO();
			
			ARMessage::showMessage("Serviço inserido com sucesso! Voce será redirecionado para a tela de listagem de serviços",ARMessageType::ERRO,"","index.php?modulos=servico&acao=listar",1000);
			
		}else{			
			//preenche o DTO de acordo com o contexto.			
			$servicoDTO->bindContextDTO();	
			
			$servicoDTO->setId_Servico($_REQUEST["id_servico"]);
			
			$resultado = $servicoDTO->atualizarDTO();
		
			ARMessage::showMessage("Serviço atualizado com sucesso! Voce será redirecionado para a tela de listagem de serviços",ARMessageType::ERRO,"","index.php?modulos=servico&acao=listar",1000);	
					
		}
	}
	
}