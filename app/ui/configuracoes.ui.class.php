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
class ConfiguracoesUI {
    //put your code here
    public function __construct() {
        ;
    }
    
    public function gerarPaginaConfiguracoes(){
        $fieldSet = new ARFieldSet();
        $fieldSet->legend = "Gerenciamento de Serviços e configurações para o clinte";
        $div = new ARDiv();
        $div->class  = "alert alert-block";
        $div->addItem(new ARTextHml("<h4>Em construção/ Análise com Jean</h4>"));
        $fieldSet->addItem($div);
        
        return $fieldSet;
        
    }
}

?>
