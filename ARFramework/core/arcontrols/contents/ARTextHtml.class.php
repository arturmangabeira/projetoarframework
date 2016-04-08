<?php
/**
 * Description of ARSpan
 *
 * @author artur
 */
class ARTextHml extends objetoHTML{
    //put your code here
    var $textHtml;
    public function __construct($textoHtml="") {
        parent::__construct();
        $this->textHtml = $textoHtml;
    }
    
    public function bind() {
        return $this->gerarTextHtml();
    }
    
    private function gerarTextHtml(){
        return $this->textHtml;
    }
    
    public function setTextHtml($textoHtml){
        $this->textHtml = $textoHtml;
    }
}

?>
