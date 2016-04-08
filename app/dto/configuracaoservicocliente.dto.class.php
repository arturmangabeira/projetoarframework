<?php

/**
 * Description of servico
 *
 * @author artur
 */
class ConfiguracaoServicoClienteDTO extends GenericDTO {
    //put your code here
    private $desc_servico;    
    private $id_servico;
    private $id_cliente;
    
    public function __construct() {
        parent::__construct();
        parent::setTable("servico");
        parent::setKey("id_servico");
    }
    
    /**
     * Getter para a variavel $id_cliente
     * @return Valor da variavel $id_cliente
     */
    public function getId_Cliente() {
    	return $this->id_cliente;
    }
    /**
     * Setter para a variavel $id_cliente, atribuindo o valor passado para a mesma.
     * @param $id_cliente - Valor a ser atribuido.
     */
    public function setId_Cliente($value) {
    	$this->id_cliente = $value;
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
