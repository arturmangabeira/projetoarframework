<?php
require_once 'ARFramework/lib/nusoap/lib/nusoap.php';
/**
 * Description of WebServices
 * Classe de consumo do webservice dos serviços do cliente 
 * disponíveis e cada caminho.
 *
 * @author artur
 */
class WebServices extends nusoap_client{
    private $wsdl;
    
    public function __construct($wsdl) {
        $this->wsdl = $wsdl;
    }
	
    public function carregar($metodo,$parametros){

            // criacao de uma instancia do cliente
            $cliente = new nusoap_client($this->wsdl, true);		
            //$cliente->setDebugLevel = 8;
            // verifica se ocorreu erro na criacao do objeto
            $err = $cliente->getError();
            if ($err){
                    echo "<div class=\"alert alert-error\"> <h4> Erro ao conectar</h4>  ".$err." </div>";
                    return "NULL";
            }

            //Chama metodo com os parametros
            $result = $cliente->call($metodo, $parametros);

            if ($cliente->fault){
                    die("<div class=\"alert alert-error\"> <h4>Falha</h4> ".print_r($result)."</div>");
            }else{
                    // verifica se ocorreu erro
                    $err = $cliente->getError();
                    if ($err){
                            echo "<div class=\"alert alert-error\"> <h4>Erro! </h4> ".$cliente->getDebug()."</div>";
                            echo "<div class=\"alert alert-error\"> <h4>WSDL Error! </h4> ".$err."</div>";
                    } else{
                            //	echo unserialize($result);
                            //retorna os dados do webservice
                            return $result;
                    }
            }
    }
}
?>