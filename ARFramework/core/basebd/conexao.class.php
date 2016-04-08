<?php
//error_reporting(0);
include_once 'adodb5/adodb.inc.php';
include_once 'bibliotecas/config.php';

define('ADODB_ERROR_LOG_TYPE',3);
define('ADODB_ERROR_LOG_DEST','log/adodb_errors.log');
define('ADODB_ASSOC_CASE', 2);

class Conexao {
    
    private static $conexao = null;
    
    function __construct() {
        
    }
    
    /** 
     * Metodo que conecta com a base e devolve uma conexão com o banco 
     *
     * @return NewADOConnection 
     */
    static public function getInstance() {
        if (!isset(self::$conexao)) {
            $id_cnn = &NewADOConnection(Config::DB_DRIVER);
            $id_cnn->Connect(Config::DB_HOST, Config::DB_USUARIO, Config::DB_SENHA, Config::DB_BANCO);
            $id_cnn->SetFetchMode(ADODB_FETCH_ASSOC);
            $id_cnn->EXECUTE("SET NAMES 'UTF8'");
            //Ajustado para permitir exibir o erro ao tentar colocar os dados errados da conexão.
            if($id_cnn->_errorMsg){            
            	throw new Exception($id_cnn->_errorMsg);
            }else{
            	self::$conexao = $id_cnn;
            }
        }
        return self::$conexao;
    }
    
    static public function getInstancePDO() {
    	if (!isset(self::$conexao)) {
    		$conn = new PDO('mysql:host='.Config::DB_HOST.';dbname='.Config::DB_BANCO, Config::DB_USUARIO, Config::DB_SENHA);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            self::$conexao = $conn;
    	}
    	return self::$conexao;
    }
    
//    static public function obterCount(GenericDTO &$genericDto){
//        if (isset(self::$conexao)) {
//            getInstance();
//        }
//        
//        if (!empty($genericDto->getTable())){
//            $sql = " SELECT COUNT('X') as count FROM {$genericDto->getTable()}";
//            
//            $recordSet = self::$conexao->Execute($sql);
//            if ($recordSet->RecordCount() > 0){
//                $rdados = $recordSet->getArray();
//                $dados = $rdados[0];
//                $genericDto->setCount($dados['count']);
//            }
//        }
//    }
}
?>
