<?php
/**
 * Description of servico
 *
 * @author artur
 */
class ServicoDB extends Conexao{
    //put your code here
    private $conn;
    
    public function __construct() {
        $this->conn = Conexao::getInstance();
    }
    
    public function obterServicoConfiguracaoClientes($id_cliente){
    	$query = "
    			select  id_servico,
    					desc_servico,
    					{$id_cliente} as id_cliente
    			from 	servico    			
    			";
    	   	 
    	$query .= " ORDER BY desc_servico ";
    	 
    	$configuracaoClienteServicoDto = new ConfiguracaoServicoClienteDTO();
    	
    	    	
    	$recordSet = $this->conn->Execute($query);
    	//retornar o DTO preenchido. 
    	return $configuracaoClienteServicoDto->bindDTO($recordSet);
    }
}

?>
