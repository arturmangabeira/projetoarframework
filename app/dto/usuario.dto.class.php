<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'bibliotecas/genericDTO.class.php';
/**
 * Description of cliente
 *
 * @author artur
 */
class UsuarioDTO extends GenericDTO {
    //put your code here
    
    private $id_usuario;
    private $nome_usuario;
    private $login;
    private $senha;
    private $admin_usuario;   
    
    public function __construct() {
        parent::__construct();
        parent::setTable("usuario");
        parent::setKey("id_usuario");
    }
    
    /**
        * Getter para a variavel $id_cliente
        * @return Valor da variavel $id_cliente
        */
    public function getId_Usuario() {
            return $this->id_usuario;
    }
    /**
        * Setter para a variavel $id_cliente, atribuindo o valor passado para a mesma.
        * @param $id_cliente - Valor a ser atribuido.
        */
    public function setId_Usuario($value) {
            $this->id_usuario = $value;
    }

    /**
        * Getter para a variavel $cod_cliente
        * @return Valor da variavel $cod_cliente
        */
    public function getNome_Usuario() {
            return $this->nome_usuario;
    }
    /**
        * Setter para a variavel $cod_cliente, atribuindo o valor passado para a mesma.
        * @param $cod_cliente - Valor a ser atribuido.
        */
    public function setNome_Usuario($value) {
            $this->nome_usuario = $value;
    }

    /**
        * Getter para a variavel $desc_caminho_logo_marca
        * @return Valor da variavel $desc_caminho_logo_marca
        */
    public function getLogin() {
            return $this->login;
    }
    /**
        * Setter para a variavel $desc_caminho_logo_marca, atribuindo o valor passado para a mesma.
        * @param $desc_caminho_logo_marca - Valor a ser atribuido.
        */
    public function setLogin($value) {
            $this->login = $value;
    }

    /**
        * Getter para a variavel $desc_url_servico
        * @return Valor da variavel $desc_url_servico
        */
    public function getSenha() {
            return $this->senha;
    }
    /**
        * Setter para a variavel $desc_url_servico, atribuindo o valor passado para a mesma.
        * @param $desc_url_servico - Valor a ser atribuido.
        */
    public function setSenha($value) {
            $this->senha = $value;
    }
    
    /**
        * Getter para a variavel $desc_url_servico
        * @return Valor da variavel $desc_url_servico
        */
    public function getAdmin_Usuario() {
            return $this->admin_usuario;
    }
    /**
        * Setter para a variavel $desc_url_servico, atribuindo o valor passado para a mesma.
        * @param $desc_url_servico - Valor a ser atribuido.
        */
    public function setAdmin_Usuario($value) {
            $this->admin_usuario = $value;
    }  
}

?>
