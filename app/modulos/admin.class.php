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
class Admin extends Page {
    //put your code here
    private $cpt;
    private $admUi;
    public function __construct() {
        parent::__construct();
        $this->admUi = new AdminUI();
    }
    
    public function generatePage($args) {       
    	if($args->acao == "logout"){
            $this->logOut();
        }else{
            $this->addItemPage($this->admUi->gerarLoginAdmin());    	
        }
    }      

    public function logar($args){
    	    	
    	$usuarioDto = new UsuarioDTO();
    	
    	$usuarioDto->bindContextDTO();    	
    	
        $retornoDto = $usuarioDto->obterPorFiltroDTO(false);
        
        if($retornoDto->count() > 0){
        	/**
        	 * 
        	 * @var UsuarioDTO
        	 */
        	$retornoDto =  $retornoDto->getIterator()->current();
        	//die(var_dump($retornoDto));
	        $_SESSION["nomeAdmin"] =  $retornoDto->getNome_Usuario();
	        $_SESSION["acessoLogin"] = "true";
	        if($retornoDto->getAdmin_Usuario() == 1){
		        $_SESSION["acessoAdmin"] = "true";
		        funcoes::redirecionar("index.php?modulos=cliente&acao=exibir&page=bvd");
	        }	        
        }else{
        	ARMessage::showMessage("Login e Senha Inválidas para acesso ao modo administrador", ARMessageType::ERRO);
        }
    }
    
    public function novaSenha(){
    	//die("chegou");
    	//$codCliente = $_SESSION["codCliente"];
    	//$_SESSION["cpfcnpj"] = $_REQUEST["dsCpfCnpj"];
    	//$this->addItemPage($this->loginUi->gerarTelaRecuperarSenha());
    	funcoes::redirecionar("index.php?modulos=loginalterar");
    	//funcoes::redirecionar("index.php?modulos=login&acao=alterarSenha&cod_cliente={$codCliente}");    	
    }
    
    public function logOut(){
        $codCliente = $_SESSION["codCliente"];
        //die($codCliente);
        session_destroy();
        //destroy o cookie
        setcookie("ccod_cliente");
        
        unset($_SESSION);
        
        funcoes::redirecionar("index.php");
    }
    
    public function cancelar(){
    	
    	$codCliente = $_SESSION["codCliente"];
        	
    	//funcoes::redirecionar("index.php?modulos=login&acao=obter&cod_cliente={$codCliente}");
    	ARMessage::showMessage("Testando a mesagem com ajax, será que vai dar certo!!");
    }
}

?>
