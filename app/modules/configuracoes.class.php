<?php
/**
 * Description of configuracoes
 *
 * @author artur
 */
class Configuracoes extends Page{
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function generatePage($args) {                       
        $configUI = new ConfiguracoesUI();
        $this->addItemPage($configUI->gerarPaginaConfiguracoes());
    }       
}

?>
