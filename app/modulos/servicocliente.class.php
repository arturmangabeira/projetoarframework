<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of servico_cliente
 *
 * @author artur
 */
class ServicoCliente extends PageGrid{
    //put your code here
	//private $servicoUI;
    public function __construct() {
    	parent::__construct();
        $this->servicoUI = new ServicoUI();
    }
    
    public function generatePage($args){    	
    	   	
    	if($args->acao == "listar"){
    		$this->addScriptRel(ARFrameWork::obterTemaAtual()."javascript/servicocliente.js");
    		$clienteDTO = new ClienteDTO();
    		$result = $clienteDTO->obterTodosDTO();
    		$this->addItemPage($this->servicoUI->gerarPaginaConfiguracoesServicoCliente($result));
    	}else{
    		if($args->acao == "habilitarServicoCliente"){    			
    			$servicoClienteDto = new ServicoClienteDTO();
    			$servicoClienteDto->setId_Cliente($_REQUEST["id_cliente"]);
    			$servicoClienteDto->setId_Servico($_REQUEST["id_servico"]);
    			//realiza a consulta inicial para verificar se exite registro com esses dados
    			$texto = "";
    			try{
	    			$result = $servicoClienteDto->obterPorFiltroDTO(false);
	    			
	    			if($result->count() > 0){
	    				//verifica se foi feita a habilitação incialemente
	    				$servicoClienteDto = $result->getIterator()->current();
	    				
	    				if($servicoClienteDto->getFl_Habilitado() == "1"){
	    					//desabilita a habilitação setando o flag como 0
	    					$servicoClienteDto->setFl_Habilitado("0");   					
	    				}else{
	    					//habilita o flag como 1
	    					$servicoClienteDto->setFl_Habilitado("1");
	    				}
	    				
	    				//atualiza a informação
	    				$servicoClienteDto->atualizarDTO();
	    				$texto = "1|Registro atualizado com sucesso!";
	    			}else{
	    				//caso não tenhi sido informado entao cadastra o item setando o flag como 1 habilitado
	    				$servicoClienteDto->setFl_Habilitado("1");
	    				$servicoClienteDto->inserirDTO();
	    				$texto = "1|Registro inserido com sucesso!";
	    			}
	    			$this->addItemPage(new ARTextHml($texto));
    			}catch(Exception $ex){
    				$this->addItemPage(new ARTextHml("0|".$ex->getMessage()));
    			}
    			
    			
    		}
    	}
    }
}

?>
