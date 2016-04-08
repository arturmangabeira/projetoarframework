<?php
//error_reporting(E_ALL);
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of baseDTO
 *
 * @author artur
 */
class BaseDTO {
    
    private $conn;
    
    //put your code here
    public function __construct() {
        $this->conn = Conexao::getInstance();
    }
    
   
    /**
     * Insere o DTO passado retornando o sqAtual através do DTO de retorno. 
     * @tutorial 
     * Ex: $acaoDTO = new AcaoDTO;
     *     $acaoRetonorDTO = $acaoDTO->inserirDTO();
     *     $sqAcao = $acaoRetonorDTO->getSqAcao(); //Obtém o max(sqAtual)
     * através da transação. 
     * @return GenericDTO 
     * @author Artur Mangabeira
     */
    public function inserirDTO(){
        //Abrindo a transação para a inserir e obter a sqAtual.
        $this->conn->StartTrans();
        
        $sql = " INSERT INTO ";
        $sql_into = " (";
        $sql_values = " VALUES (";
        
        $class = new ReflectionClass(get_class($this));
        
        $method = new ReflectionMethod(get_class($this), "getTable");
        $tabela = $method->invoke($this);
        
        $sql .= $tabela;
        
        $properties = $class->getProperties( ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC );

        if (!is_null($properties))
        {
                //$prop = New ReflectionProperty(get_class($this),"");
                foreach ($properties as $prop)
                {
                        $propName = $prop->getName();
                        
                        $method = new ReflectionMethod(get_class($this), "get" . ucfirst($propName));
                        $valor = $method->invoke($this);
                        
                        if (!is_null($valor) && !is_array($valor)){
                           $sql_into .=  "{$propName},";
                           if (is_double($valor) || is_float($valor) || is_int($valor) || is_integer($valor) || is_real($valor)){
                                $sql_values .= "{$valor},";
                           }else{
                               if(is_string($valor)){                               	 
                               	  $valor_sem_escape = str_replace("'", "&#39;", $valor);
                               	  $valor_sem_escape = str_replace("\"", "&quot;", $valor_sem_escape);                               	  
                                  $sql_values .= "'{$valor_sem_escape}',"; 
                               }
                           }
                        }
                        
                }
                $sql_into   .= "|";
                $sql_values .= "|";
                
                $sql_into   = str_replace(",|", "", $sql_into);
                $sql_values = str_replace(",|", "", $sql_values);
                
                $sql_into   .= " ) ";
                $sql_values .= ") ";
                
                
                $sql = $sql.$sql_into.$sql_values;
                //die($sql);
                $this->conn->Execute($sql); 
                if ( $this->conn->HasFailedTrans() ){
                    $this->conn->CompleteTrans(false);
                    throw new Exception("Erro no método baseDTO::inserirDTO através do objeto {$class->name}. Query gerada: {$sql} ");
                }else{
                    $method = new ReflectionMethod(get_class($this), "getKey");
                    $key = $method->invoke($this);
                    if(!is_null($key)){
	                    $sql  = " SELECT MAX({$key}) AS {$key} FROM {$tabela} ";	                    
	                    $result = $this->conn->Execute($sql);
	                    $this->conn->CompleteTrans(true);
	                    return $this->bindDTO($result);
                    }else{
	                    $this->conn->CompleteTrans(true);
	                    return $this;
                    }
                }
        } 
    }
    
    /**
     * Atualiza o DTO passado através do DTO inferido. 
     * @tutorial 
     * Ex: $acaoDTO = new AcaoDTO;
     *     $acaoDTO->setAcao("Editar");
     *     $acaoDTO->atualizarDTO();
     * Urtilizado através de transação. 
     * @author Artur Mangabeira
     */
    public function atualizarDTO(){
        //Abrindo a transação para a atualizar.
        $this->conn->StartTrans();
        $sql = " UPDATE ";
        $sql_set = " SET ";
        $sql_where = " ";
        
        $class = new ReflectionClass(get_class($this));
        
        $method = new ReflectionMethod(get_class($this), "getTable");
        $tabela = $method->invoke($this);
        $sql .= $tabela;
        
        $method = new ReflectionMethod(get_class($this), "getKey");
        $sqDsCodigoKey = $method->invoke($this);
        
        $sql_where .= " WHERE ";
        
        if(is_null($sqDsCodigoKey)){
        	$method = new ReflectionMethod(get_class($this), "getKeys");
        	$sqDsCodigoKey = $method->invoke($this);
        }
        
        $chaves = explode(",", $sqDsCodigoKey);
        
        $arrayCondices = array();
        
        foreach ($chaves as $value) {
        	$method = new ReflectionMethod(get_class($this), "get".$value);
        	$valorCodigoKey = $method->invoke($this);
        	$arrayCondices[] = "{$value} = {$valorCodigoKey}";
        	//$sql_where .= " AND {$value} = {$valorCodigoKey} ";
        }            
        
        $sql_where .= implode(" AND ", $arrayCondices);
        
        $properties = $class->getProperties( ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC );

        if (!is_null($properties))
        {
                //$prop = New ReflectionProperty(get_class($this),"");
                foreach ($properties as $prop)
                {
                        $propName = $prop->getName();
                        
                        $method = new ReflectionMethod(get_class($this), "get" . ucfirst($propName));
                        $valor = $method->invoke($this);
                        
                        if (!is_null($valor) && !is_array($valor)){
                           if (is_double($valor) || is_float($valor) || is_int($valor) || is_integer($valor) || is_real($valor)){
                               if(!in_array($propName, $chaves)){                                   
                                   $sql_set .= "{$propName} = {$valor},";
                               }
                           }else{
                               if(is_string($valor)){
                               	if(!in_array($propName, $chaves)){
	                               	  $valor_sem_escape = str_replace("'", "&#39;", $valor);
	                               	  $valor_sem_escape = str_replace("\"", "&quot;", $valor_sem_escape);
	                               	  //$valor_ =  $this->conn->qstr($valor_sem_escape);
	                                  $sql_set .= "{$propName} = '{$valor_sem_escape}',";
	                             }
                               }
                           }
                        }
                        
                }
                $sql_set   .= "|";
                $sql_set   = str_replace(",|", "", $sql_set);

                $sql = $sql.$sql_set.$sql_where;
                //die($sql);
                $this->conn->Execute($sql);
                if ( $this->conn->HasFailedTrans() ){
                    $this->conn->CompleteTrans(false);
                    throw new Exception("Erro no método baseDTO::atualizarDTO através do objeto {$class->name}. Query gerada: {$sql} ");
                }else{
                    $this->conn->CompleteTrans(true);
                }
        }      
    }
    
    /**
     * Exclue o DTO passado através do DTO inferido. 
     * @tutorial 
     * Ex: $acaoDTO = new AcaoDTO;
     *     $acaoDTO->setSqAcao(1);
     *     $acaoDTO->excluirDTO();
     * utilizado através de transação. 
     * @author Artur Mangabeira
     */
    public function excluirDTO(){
         //Abrindo a transação para a exclusão.
        $this->conn->StartTrans();
        $sql = " DELETE FROM ";
        $sql_where = " ";
        
        $method = new ReflectionMethod(get_class($this), "getTable");
        $tabela = $method->invoke($this);
        
        $sql .= $tabela;
        
        $method = new ReflectionMethod(get_class($this), "getKey");
        $sqDsCodigoKey = $method->invoke($this);
        
        $method = new ReflectionMethod(get_class($this), "get".$sqDsCodigoKey);
        $valorCodigoKey = $method->invoke($this);
        //Caso o valor obtido seja um array
        if(is_array($valorCodigoKey)){
            $sqValor = implode(",",$valorCodigoKey);

            $sql_where .= " WHERE {$sqDsCodigoKey} IN ({$sqValor}) ";
        }else{
            $sql_where .= " WHERE {$sqDsCodigoKey} IN ({$valorCodigoKey}) ";
        }
                       
        $sql = $sql.$sql_where;
        
        $this->conn->Execute($sql);
        if ( $this->conn->HasFailedTrans() ){
            $this->conn->CompleteTrans(false);
            $class = new ReflectionClass(get_class($this));
            throw new Exception("Erro no método baseDTO::excluirDTO através do objeto {$class->name}. Query gerada: {$sql} ");
        }else{
            $this->conn->CompleteTrans(true);
        }
    }
    
    /**
     * Obtem ArrayObject por sem filtro (por todos) de acordo com o DTO passado
     * @return ArrayObject 
     * @author Artur Mangabeira
     */
    public function obterTodosDTO(){
        $sql = " SELECT ";
        $sql_from = " FROM ";
        $sql_campos = " ";
        
        $class = new ReflectionClass(get_class($this));
        
        $method = new ReflectionMethod(get_class($this), "getTable");
        $tabela = $method->invoke($this);
        
        $sql_from .= $tabela;
        
        $properties = $class->getProperties( ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC );

        if (!is_null($properties))
        {
                //$prop = New ReflectionProperty(get_class($this),"");
                foreach ($properties as $prop)
                {
                        $propName = $prop->getName();
                        $sql_campos .= "$propName,";
                        
                }
                $sql_campos .= "|";
                
                $sql_campos   = str_replace(",|", "", $sql_campos);
                
                $sql = $sql.$sql_campos.$sql_from;
                
                $rs = $this->conn->Execute($sql);
                if($rs){
                    return $this->bindDTO($rs);
                }else{
                    throw new Exception("Erro no método baseDTO::obterTodosDTO através do objeto {$class->name}. Query gerada: {$sql} ");        
                }
        }       
    }
    
    /**
     * Obtem ArrayObject por sq de acordo com o DTO passado
     * @return ArrayObject 
     * @author Artur Mangabeira
     */
    public function obterPorSqDTO(){
        $sql = " SELECT ";
        $sql_from = " FROM ";
        $sql_campos = " ";
        $sql_where  = " ";
        $class = new ReflectionClass(get_class($this));
        
        $method = new ReflectionMethod(get_class($this), "getTable");
        $tabela = $method->invoke($this);
        
        $sql_from .= $tabela;
        
        $method = new ReflectionMethod(get_class($this), "getKey");
        $sqDsCodigoKey = $method->invoke($this);
        
        $method = new ReflectionMethod(get_class($this), "get" . ucfirst($sqDsCodigoKey));
        $valor = $method->invoke($this);
        
        $sql_where .= " WHERE {$sqDsCodigoKey} = {$valor}";
        
        
        $properties = $class->getProperties( ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC );

        if (!is_null($properties))
        {
                //$prop = New ReflectionProperty(get_class($this),"");
                foreach ($properties as $prop)
                {
                        $propName = $prop->getName();
                        $sql_campos .= "$propName,";
                }
                $sql_campos .= "|";
                
                $sql_campos   = str_replace(",|", "", $sql_campos);
                
                $sql = $sql.$sql_campos.$sql_from.$sql_where;
                
                $rs = $this->conn->Execute($sql);
                if($rs){
                    return $this->bindDTO($this->conn->Execute($sql));
                }else{
                    throw new Exception("Erro no método baseDTO::obterPorSqDTO através do objeto {$class->name}. Query gerada: {$sql} ");
                }
        }       
    }
    
    /**
     * Obtem ArrayObject por filtro de acordo com o DTO passado
     * @return ArrayObject 
     * @author Artur Mangabeira
     */
    public function obterPorFiltroDTO($useLike=true){
        $sql = " SELECT ";
        $sql_from = " FROM ";
        $sql_campos = " ";
        $sql_where  = " ";
        $class = new ReflectionClass(get_class($this));
        
        $method = new ReflectionMethod(get_class($this), "getTable");
        $tabela = $method->invoke($this);
        
        $sql_from .= $tabela;
        
        $sql_where .= " WHERE 1 = 1 ";
        
        $properties = $class->getProperties( ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC );

        if (!is_null($properties))
        {
                //$prop = New ReflectionProperty(get_class($this),"");
                foreach ($properties as $prop)
                {
                        $propName = $prop->getName();
                        $sql_campos .= "$propName,";
                        
                        $method = new ReflectionMethod(get_class($this), "get" . ucfirst($propName));
                        $valor = $method->invoke($this);
                        
                        if(!is_null($valor) && !is_array($valor)){
                            if (is_double($valor) || is_float($valor) || is_int($valor) || is_integer($valor) || is_real($valor)){
                                $sql_where .= " AND {$propName} = {$valor}";
                            }else{
                                if(is_string($valor)){
                                	if($useLike){
                                    	$sql_where .= " AND {$propName} LIKE '%{$valor}%'";
                                	}else{
                                		$sql_where .= " AND {$propName} = '{$valor}'";
                                	}
                                }
                            }
                        }
                        
                }
                $sql_campos .= "|";
                
                $sql_campos   = str_replace(",|", "", $sql_campos);
                
                $sql = $sql.$sql_campos.$sql_from.$sql_where;
                //Implementa a ordenação
                //Itens para a paginação
                $method = new ReflectionMethod(get_class($this), "getSortName");
                $getSortName = $method->invoke($this);
                
                $method = new ReflectionMethod(get_class($this), "getSortOrder");
                $getSortOrder = $method->invoke($this);
                
                if ($getSortName != null && $getSortOrder != null){ 
                    $sql .= " ORDER BY {$getSortName} {$getSortOrder} ";
                }
                //die($sql);
                $rs = $this->conn->Execute($sql);
                if($rs){
                    return $this->bindDTO($rs);
                }else{
                    throw new Exception("Erro no método baseDTO::obterPorFiltroDTO através do objeto {$class->name}. Query gerada: {$sql} ");        
                }
        }       
    }
    
    /**
     * Função para o preenchimento de um DTO de acordo com o resultado 
     * da consulta feita.
     * Exemplo: moduloGrupoDTO contendo os seguintes campos 
     *          sqGrupo
     *          sqModulo
     *          dsModulo
     *          dsGrupo
     *          com suas propriedades gets e sets definidas:
     *          setSqGrupo,getSqGrupo
     *          setSqModulo,getSqModulo
     *          setDsModulo,getSqModulo
     *          setDsGrupo, getDsGrupo.
     * 
     *          Para a consulta:
     *          Query = "Select sqGrupo,sqModulo,dsModulo,dsGrupo FROM Modulo
     *          JOIN MODULO_GRUPO ON MODULO_GRUPO.sqModulo = Modulo.sqModulo
     *          JOIN Grupo ON Grupo.sqGrupo = MODULO_GRUPO.sqGrupo"
     *          --Executa a query
     *          $rs = $this->conn->Execute($sql);
     *          --Preenche o DTO especifico 
     *          $moduloGrupoDto = new ModuloGrupoDTO();
     *          return $moduloGrupoDto->bindDTO($rs);     
     *     
     * @param RecordSet $rs. 
     * @return ArrayObject contendo o DTO preenchido.
     * @author Artur Mangabeira
     */
    public function bindDTO(&$rs){
        $arrayObjectRetorno = new ArrayObject();
        $arrayObjectRetorno->setFlags(ArrayObject::ARRAY_AS_PROPS);
        if($rs->RecordCount() >0){
            foreach ($rs->getArray() as $value) {
                $arrayObjectRetorno->append($this->bindValues($value));
                
            }
        }
        
        return $arrayObjectRetorno;
    }
    
    /**
     * Preenche os valores dos campos de acordo com o DTO passado.
     * @param GenericDTO $value
     * @return A instacia do objeto para ser adicionado o array de objetos.
     * @author Artur Mangabeira
     */
    private function bindValues(&$value){
        $class = new ReflectionClass(get_class($this));
        //Cria uma nova instancia da classe passada.
        $instance = $class->newInstanceArgs();

        $properties = $class->getProperties( ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC );

        if (!is_null($properties))
        {
                //$prop = New ReflectionProperty(get_class($this),"");
                foreach ($properties as $prop)
                {
                        $propName = $prop->getName();
                        if (!$prop->getDeclaringClass() instanceof GenericDTO){
                            $propValue = $value[$propName];
                        }
                        
                        // If exists value, set it;
                        if ($propValue != "")
                        {
                                $method = new ReflectionMethod($instance, "set" . ucfirst($propName));
                                $method->invokeArgs($instance, array($propValue));
                        }
                }
        }
        //Retorna a instancia criada para ser adicionada ao array na geração do iterator.
        return $instance;
    }
    
    /**
     * Retorna o DTO preenchido a partir do contexto utilizado.
     * @return GenericDTO 
     * @author Artur Mangabeira
     */
    public function bindContextDTO(){
        $class = new ReflectionClass(get_class($this));

        $properties = $class->getProperties( ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC );

        if (!is_null($properties))
        {
                //$prop = New ReflectionProperty(get_class($this),"");
                foreach ($properties as $prop)
                {
                        $propName = $prop->getName();
                        if (!$prop->getDeclaringClass() instanceof GenericDTO){
                        	//caso a propriedade seja vaiza verifica se foi fornecido algum arquivo para preenchimento
                        	if(!empty($_REQUEST[$propName])){
                            	$propValue = $_REQUEST[$propName];
                        	}else{
                        		//verifica se trata de um arquivo
                        		if(!empty($_FILES[$propName])){
                        			$propValue = $_FILES[$propName];
                        		}
                        	}
                        }
                        // If exists value, set it;
                        if ($propValue != "")
                        {
                                $method = new ReflectionMethod(get_class($this), "set" . ucfirst($propName));
                                $method->invokeArgs($this, array($propValue));
                        }
                        $propValue = "";
                }
        }
    }
    
}

?>
