<?php

/**
 * Description of cliente
 *
 * @author artur
 */
class ClienteDTO extends GenericDTO {
    //put your code here
    
    private $id_cliente;
    private $cod_cliente;
    private $desc_caminho_logomarca;
    private $desc_url_servicos;
    private $desc_descricao_servico;
    private $desc_nome_empresa;
    private $tipo_acesso;
    
    public function __construct() {
        parent::__construct();
        parent::setTable("cliente");
        parent::setKey("id_cliente");
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
        * Getter para a variavel $cod_cliente
        * @return Valor da variavel $cod_cliente
        */
    public function getCod_Cliente() {
            return $this->cod_cliente;
    }
    /**
        * Setter para a variavel $cod_cliente, atribuindo o valor passado para a mesma.
        * @param $cod_cliente - Valor a ser atribuido.
        */
    public function setCod_Cliente($value) {
            $this->cod_cliente = $value;
    }

    /**
        * Getter para a variavel $desc_caminho_logo_marca
        * @return Valor da variavel $desc_caminho_logo_marca
        */
    public function getDesc_Caminho_LogoMarca() {
            return $this->desc_caminho_logomarca;
    }
    /**
        * Setter para a variavel $desc_caminho_logo_marca, atribuindo o valor passado para a mesma.
        * @param $desc_caminho_logo_marca - Valor a ser atribuido.
        */
    public function setDesc_Caminho_LogoMarca($value) {
            $this->desc_caminho_logomarca = $value;
    }

    /**
        * Getter para a variavel $desc_url_servico
        * @return Valor da variavel $desc_url_servico
        */
    public function getDesc_Url_Servicos() {
            return $this->desc_url_servicos;
    }
    /**
        * Setter para a variavel $desc_url_servico, atribuindo o valor passado para a mesma.
        * @param $desc_url_servico - Valor a ser atribuido.
        */
    public function setDesc_Url_Servicos($value) {
            $this->desc_url_servicos = $value;
    }
    
    /**
        * Getter para a variavel $desc_url_servico
        * @return Valor da variavel $desc_url_servico
        */
    public function getDesc_Descricao_Servico() {
            return $this->desc_descricao_servico;
    }
    /**
        * Setter para a variavel $desc_url_servico, atribuindo o valor passado para a mesma.
        * @param $desc_url_servico - Valor a ser atribuido.
        */
    public function setDesc_Descricao_Servico($value) {
            $this->desc_descricao_servico = $value;
    }
    
    /**
        * Getter para a variavel $desc_nome_empresa
        * @return Valor da variavel $desc_nome_empresa
        */
    public function getDesc_Nome_Empresa() {
            return $this->desc_nome_empresa;
    }
    /**
        * Setter para a variavel $desc_nome_empresa, atribuindo o valor passado para a mesma.
        * @param $value - Valor a ser atribuido.
        */
    public function setDesc_Nome_Empresa($value) {
            $this->desc_nome_empresa = $value;
    }
    
    /**
     * Getter para a variavel $desc_nome_empresa
     * @return Valor da variavel $desc_nome_empresa
     */
    public function getTipo_Acesso() {
    	return $this->tipo_acesso;
    }
    /**
     * Setter para a variavel $desc_nome_empresa, atribuindo o valor passado para a mesma.
     * @param $value - Valor a ser atribuido.
     */
    public function setTipo_Acesso($value) {
    	$this->tipo_acesso = $value;
    }

}

?>
