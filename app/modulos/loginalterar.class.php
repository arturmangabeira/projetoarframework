<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author artur
 */
class LoginAlterar extends Page {
    //put your code here
    private $cpt;
    private $loginUi;
    public function __construct() {
        parent::__construct();
        $this->loginUi = new LoginUI();
    }
    
    public function generatePage($args) {        
        
        $this->addItemPage($this->loginUi->gerarTelaRecuperarSenha());
        
    }       
    
    public function alterarSenha(){
    	//die("chegou");
    	$codCliente = $_SESSION["codCliente"];
    	$_SESSION["cpfcnpj"] = $_REQUEST["dsCpfCnpj"];
    	
    	//deve ser feito um teste utilizando o servico novo de james    	
    	//$servico = new ServicosJTecnologia($_SESSION["url_wsdl_servico"]);    	
    	
    	if($_REQUEST["dsSenhaNovaAux"] == $_REQUEST["dsSenhaNova"]){
    		//$resultado = $servico->alterarSnhaServicoSGA($cpfcnp,$_REQUEST["dsSenhaNova"]);
    		$resultado = 1;
    		if($resultado == 1){
    			ARMessage::showMessage("Senha atuzalizada com sucesso!. Vocè será redirecionado para a tela de login do sistema!",ARMessageType::ERRO,"","index.php?modulos=login&acao=obter&cod_cliente={$codCliente}");
    		}
    	}else{
    		ARMessage::showMessage("As senhas não conferem. Senha nova e a senha confirmada!!",ARMessageType::ERRO);
    	}
    	
    	//funcoes::redirecionar("index.php?modulos=cliente&acao=exibir&page=bvd");
    	//funcoes::redirecionar("index.php?modulos=login&acao=alterarSenha&cod_cliente={$codCliente}");    	
    }   
        
    public function cancelar(){
    	
    	$codCliente = $_SESSION["codCliente"];
        	
    	funcoes::redirecionar("index.php?modulos=login&acao=obter&cod_cliente={$codCliente}");
    	//ARMessage::showMessage("Testando a mesagem com ajaxForm!!",ARMessageType::AVISO,"","index.php?modulos=login&acao=obter&cod_cliente={$codCliente}",0);
    }
}

?>
