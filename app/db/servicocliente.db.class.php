<?php
/**
 * Description of servico_cliente
 *
 * @author artur
 */
class ServicoClienteDB extends Conexao{
    //put your code here
    private $conn;
    
    public function __construct() {
        $this->conn = Conexao::getInstance();
    }
}

?>
