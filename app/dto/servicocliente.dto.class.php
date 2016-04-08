<?php
/**
 * Description of servico_cliente
 *
 * @author artur
 */
class ServicoClienteDTO extends GenericDTO {
    //put your code here
    
    private $id_servico;
    private $id_cliente;
    private $fl_habilitado;
    
    public function __construct() {
        parent::__construct();
        parent::setKeys("id_cliente,id_servico");
        parent::setTable("servico_cliente");
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
        * Getter para a variavel $fl_habilitado
        * @return Valor da variavel $fl_habilitado
        */
    public function getFl_Habilitado() {
            return $this->fl_habilitado;
    }
    /**
        * Setter para a variavel $fl_habilitado, atribuindo o valor passado para a mesma.
        * @param $value - Valor a ser atribuido.
        */
    public function setFl_Habilitado($value) {
            $this->fl_habilitado = $value;
    }
}

?>
