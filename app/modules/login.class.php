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
class Login extends Page {
    //put your code here
    private $cpt;
    private $loginUi;
    public function __construct() {
        parent::__construct();
        $this->loginUi = new LoginUI();
    }
    
    public function generatePage($args) {
        
        switch ($args->acao) {            
            case "gerarCpt":       
                $this->loginUi->gerarCaptcha();
            break;
            case "logout":       
                $this->logOut();
            break;
            case "alterarSenha":
            	$this->addItemPage($this->loginUi->gerarTelaRecuperarSenha());
            break;
           case "obter":           		
                $this->addItemPage($this->loginUi->gerarLoginHtml());
            break; 
        }
    }
       
    //public function logar(ClienteDTO $clienteDto,$cpfcnpj){
    public function logar(){
    	
    	$clienteDto = new ClienteDTO();
    	$clienteDto->setCod_Cliente($_SESSION["codCliente"]);
    	$dsCpfCnpj = str_replace(".", "", $_REQUEST["dsCpfCnpj"]);
    	$dsCpfCnpj = str_replace("/", "", $dsCpfCnpj);
    	$cpfcnpj = str_replace("-", "", $dsCpfCnpj);
    	
    	$senha = $_REQUEST["dsSenhaUsuario"];
    	
    	//die(var_dump($clienteDto));
        $retornoDto = $clienteDto->obterPorFiltroDTO()->getIterator()->current();
        //Obtem o serviço a ser utilizado para a realização do login.
        require_once 'modules/servicosjt.class.php';
        $servico = new ServicosJTecnologia($retornoDto->getDesc_Url_Servicos());
        $_SESSION["url_wsdl_servico"] = $retornoDto->getDesc_Url_Servicos();
        $cpfLocatario = htmlspecialchars($cpfcnpj);
        //Verifica o tipo acesso passado para logar da forma correta
        if($_SESSION["id_cliente"]){
        	if($servico->loginAcessoServicoSGA($$cpfcnpj, $senha)){
        		$dadosLocador = $servico->verificaCadastro($cpfLocatario);
        	}else{
        		$dadosLocador = 0;
        	}
        }else{
        	$dadosLocador = $servico->verificaCadastro($cpfLocatario);
        }
        unset($_SESSION["acessoLogin"]);
        unset($_SESSION["acessoAdmin"]);
        $codLocador = substr($dadosLocador, 0, stripos($dadosLocador, '|'));
        $_SESSION["cpfcnpj"] = $_REQUEST["dsCpfCnpj"];
        $_SESSION["codLocador"] =  "123";
        $_SESSION["emailLocador"] =  "arturmangabeira@gmail.com";
        $_SESSION["nomeLocador"] =  "Artur Mangabeira";
        $_SESSION["tipoCliente"] =  "P";
        $_SESSION["acessoLogin"] = "true";
        funcoes::redirecionar("index.php?modules=cliente&acao=exibir&page=bvd");
        /*
        //Verifica se o cadastro foi validado e se o capatcha é válido!
        if ($codLocador > 0 && $_SESSION['cap_code'] == $_REQUEST['dsCpt']){
            $_SESSION["cpfcnpf"] = $cpfcnpj;
            $arr_dados = explode("|", $dadosLocador);
            $_SESSION["codLocador"] =  $arr_dados[0];
            $_SESSION["emailLocador"] =  $arr_dados[1];
            $_SESSION["nomeLocador"] =  $arr_dados[2];
            $_SESSION["tipoCliente"] =  $arr_dados[3];
            $_SESSION["acessoLogin"] = "true";
            funcoes::redirecionar("index.php?modules=cliente&acao=exibir&page=bvd");
        }else{
            funcoes::redirecionar("index.php?modules=login&acao=obter&cod_cliente={$retornoDto->getCod_Cliente()}","Não foi encontrado proprietário/locatário com o cpf/cnpj fornecido!");
        } 
        */       
    }
    
    public function novaSenha(){
    	//die("chegou");
    	//$codCliente = $_SESSION["codCliente"];
    	//$_SESSION["cpfcnpj"] = $_REQUEST["dsCpfCnpj"];
    	//$this->addItemPage($this->loginUi->gerarTelaRecuperarSenha());
    	funcoes::redirecionar("index.php?modules=loginalterar");
    	//funcoes::redirecionar("index.php?modules=login&acao=alterarSenha&cod_cliente={$codCliente}");    	
    }
    
    public function logOut(){             
        //destroy o cookie
        setcookie("ccod_cliente");
        if($_SESSION["acessoAdmin"] == "true"){
        	session_destroy();
        	unset($_SESSION["acessoLogin"]); 
           	unset($_SESSION["acessoAdmin"]);
        	funcoes::redirecionar("index.php?modules=admin");
        }else{
        	$codCliente = $_SESSION["codCliente"];
        	session_destroy();
        	unset($_SESSION["acessoLogin"]); 
           	unset($_SESSION["acessoAdmin"]);
           	unset($_SESSION["codCliente"]);
        	funcoes::redirecionar("index.php?modules=login&acao=obter&cod_cliente={$codCliente}");
        }
    }
    
    public function cancelar(){
    	
    	$codCliente = $_SESSION["codCliente"];
        	
    	//funcoes::redirecionar("index.php?modules=login&acao=obter&cod_cliente={$codCliente}");
    	ARMessage::showMessage("Testando a mesagem com ajax, será que vai dar certo!!");
    }
}

?>
