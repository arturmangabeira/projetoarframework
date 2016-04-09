<?php
/**
 * Description of cliente
 *
 * @author artur
 */
class ErroPage extends Page{
    //put your code here
    var $erroUI;
    public function __construct() {
        parent::__construct();
        $this->erroUI = new ErroPageUI();
    }
    
    public function generatePage($args) {                            
			$this->addItemPage($this->erroUI->exibirMensagemErro($_REQUEST["msg_error"],$_REQUEST["msg_error_trace"]));                        
    }    
}

?>
