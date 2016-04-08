<?php
/**
 * Description of cliente
 *
 * @author artur
 */
class ClienteDB extends Conexao{
    //put your code here
    private $conn;
    
    public function __construct() {
        $this->conn = Conexao::getInstance();
    }
    
    public function obterClientes(ClienteDTO $clienteDTO){
    	$query = "
    			select  id_cliente,
						cod_cliente,
						desc_nome_empresa,
						desc_descricao_servico,
						desc_caminho_logomarca,
						desc_url_servicos,
						case tipo_acesso when 'C' then 'Capctha' else 'Senha' end as tipo_acesso
    			from 	cliente
    			where 1=1  
    			";
    	
    	if(!is_null($clienteDTO->getCod_Cliente())){
    	
    		$query .= " and cod_cliente like '%{$clienteDTO->getCod_Cliente()}%' ";
    	
    	}
    	
    	if(!is_null($clienteDTO->getDesc_Nome_Empresa())){
    		 
    		$query .= " and desc_nome_empresa like '%{$clienteDTO->getDesc_Nome_Empresa()}%' ";
    		 
    	}
    	
    	$query .= " ORDER BY desc_nome_empresa ";
    	
    	//die($query);
    	
    	$recordSet = $this->conn->Execute($query);
    	
    	return $clienteDTO->bindDTO($recordSet);
    }
}

?>
