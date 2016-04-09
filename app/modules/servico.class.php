<?php
/**
 * Description of servico
 *
 * @author artur
 */
class Servico extends Page {
    //put your code here
    private $servicoUI; 
    public function __construct() {
        parent::__construct();
        $this->servicoUI = new ServicoUI();
    }
    
    public function generatePage($args) {
    	
    	switch ($args->acao) {
    		case "listar":
    			$servicoDTO = new ServicoDTO();
    			$result = $servicoDTO->obterTodosDTO();
    			//die(var_dump($result));
    			$this->addItemPage($this->servicoUI->gerarPaginaServico($result));
    		break;
    		case "excluir":
    			$this->excluir();    			
    			$this->filtrar();
    		break;
    	}
    	
    }
    
    public function filtrar(){
    	
        ARMessage::showMessage("Teste de mensagem com dialog!", ARMessageType::AVISO);
               
    	$servicoDTO = new ServicoDTO();
    	$servicoDTO->bindContextDTO();
    	$result = $servicoDTO->obterPorFiltroDTO();
    	
    	$this->addItemPage($this->servicoUI->gerarPaginaServico($result));
    	
    }
    
    public function excluir(){
    	$servicoDTO = new ServicoDTO();
    	
    	$servicoDTO->setId_Servico($_REQUEST["valueid"]);
    	
    	$servicoDTO->excluirDTO();
    }
}

?>
