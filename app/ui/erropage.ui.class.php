<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of servico
 *
 * @author artur
 */
class ErroPageUI {
    //put your code here
    public function __construct() {
        ;
    }
    
	public function exibirMensagemErro($strMensagem,$mensagemTrace){
    	$div = new ARDiv();
    	$div->class = "alert alert-error";
    	$div->addItem(new ARTextHml("<h4> Erro !</h4>"));
    	
    	$div->addItem(new ARTextHml("<h5>Detalhe do erro: </h5>"));
    	$div->addItem(new ARTextHml("<p>{$strMensagem}</p>"));
    	
    	$div->addItem(new ARTextHml("<h5>Pilha de execução: </h5>"));
    	$div->addItem(new ARTextHml("<p>{$mensagemTrace}</p>"));
    	
    	return $div;    	 
    }
}
