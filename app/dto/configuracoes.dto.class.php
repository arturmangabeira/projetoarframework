<?php

/**
 * Description of Configuracoes
 *
 * @author artur
 */
class ConfiguracoesDTO extends GenericDTO {
    //put your code here
        
    public function __construct() {
        parent::__construct();
        parent::setTable("Configuracoes");
        parent::setKey("id_Configuracoes");
    }
    
}

?>
