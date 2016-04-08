<?php
include_once 'bibliotecas/genericDTO.class.php';
/**
 * Description of servico
 *
 * @author artur
 */
class ServicoDTO extends GenericDTO {
    //put your code here
    private $desc_servico;
    private $desc_wsdl_servico;
    private $id_servico;
    
    public function __construct() {
        parent::__construct();
        parent::setTable("servico");
        parent::setKey("id_servico");
    }
    /**
        * Getter para a variavel $desc_servico
        * @return Valor da variavel $desc_servico
        */
    public function getDesc_Servico() {
            return $this->desc_servico;
    }
    /**
        * Setter para a variavel $desc_servico, atribuindo o valor passado para a mesma.
        * @param $desc_servico - Valor a ser atribuido.
        */
    public function setDesc_Servico($value) {
            $this->desc_servico = $value;
    }

    /**
        * Getter para a variavel $desc_wsdl_servico
        * @return Valor da variavel $desc_wsdl_servico
        */
    public function getDesc_Wsdl_Servico() {
            return $this->desc_wsdl_servico;
    }
    /**
        * Setter para a variavel $desc_wsdl_servico, atribuindo o valor passado para a mesma.
        * @param $desc_wsdl_servico - Valor a ser atribuido.
        */
    public function setDesc_Wsdl_Servico($value) {
            $this->desc_wsdl_servico = $value;
    }

    /**
        * Getter para a variavel $id_servico
        * @return Valor da variavel $id_servico
        */
    public function getId_Servico() {
            return $this->id_servico;
    }
    /**
        * Setter para a variavel $id_servico, atribuindo o valor passado para a mesma.
        * @param $id_servico - Valor a ser atribuido.
        */
    public function setId_Servico($value) {
            $this->id_servico = $value;
    }
}

?>
