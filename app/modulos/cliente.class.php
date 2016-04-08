<?php

/**
 * Description of cliente
 *
 * @author artur
 */
class Cliente extends Page{
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function generatePage($args) {
        $clienteUi = new ClienteUI();
        switch ($args->acao) {
            case "exibir":
                $script = "
                        function gerarModalPDF(endereco){
                        
                            $('#lnk_modal').attr('href',endereco);
                            $('#lnk_modal').click();
                            
                            return false;
                        }
                    ";
                parent::addCustonScript($script);
                $servicoClienteDto = new ServicoClienteDTO();
                if(!empty($_SESSION["id_cliente"])){
	                $servicoClienteDto->setId_Cliente($_SESSION["id_cliente"]);
	                $servicoClienteRetornoDto = $servicoClienteDto->obterPorFiltroDTO(false);
                                
	                //$this->addItemPage($clienteUi->gerarHtmlIncial($servicoClienteRetornoDto));
	                $arrayPermissao = array();
	                $servicoCliente = new ServicoClienteDTO();
	                foreach ($servicoClienteRetornoDto->getIterator() as $servicoCliente) {
	                    if($servicoCliente->getFl_Habilitado() == "1"){
	                        $arrayPermissao[] = $servicoCliente->getId_Servico();
	                    }
	                }
                }
                //die(print_r($arrayPermissao));
                switch ($_REQUEST["page"]) {
                    case "boleto":
                         //if (in_array("1", $arrayPermissao)) {   
                            $this->addItemPage($clienteUi->gerarPaginaBoletos());
                         //}
                    break;
                    case "extrato":
                        //if (in_array("2", $arrayPermissao)) {
                            $this->addItemPage($clienteUi->gerarPaginaExtratos());
                        //}
                    break;    
                    case "segundavia":
                        //if (in_array("6", $arrayPermissao)) {
                            $this->addItemPage($clienteUi->gerarPaginaBoletos());
                        //}
                    break;    
                    case "demonstrativo":
                        //if (in_array("5", $arrayPermissao)) {
                            $this->addItemPage($clienteUi->gerarPaginaDemonstrativo());
                        //}
                    break;
                    case "clientes":
                         $this->addItemPage($clienteUi->gerarPaginaClientes());
                    break;
                    case "servico":
                        $this->addItemPage($clienteUi->gerarPaginaServico());
                    break;
                    case "servicocliente":
                        $this->addItemPage($clienteUi->gerarPaginaServicoCliente());
                    break;
                    default :
                        $this->addItemPage($clienteUi->gerarBoasVindas());
                    break;    
                }
                
            break;
            case "gerarBoleto":
                $this->gerarBoletoMensal($_REQUEST['cpfcnpj'],$_REQUEST['dtenvio']);
            break;
            case "gerarExtrato":       
                $this->gerarExtratoMensal($_REQUEST['dtenvio']);
            break;
            case "gerarDemonstrativo":       
                $this->gerarDemonstrativoAnual($_REQUEST['dtenvio']);
            break;
            default :
                $this->addItemPage($clienteUi->gerarHtmlIncial());
                $this->addItemPage($clienteUi->gerarBoasVindas());
            break;    
        }
        
    }
    
    public function gerarBoletoMensal($cpfcnpj,$dataBase){
        $servico = new ServicosJTecnologia($_SESSION["url_wsdl_servico"]);
        try {
                $cpfcnpj = str_replace(".", "", $cpfcnpj);
                $cpfcnpj = str_replace("/", "", $cpfcnpj);
                $cpfcnpj = str_replace("-", "", $cpfcnpj);
                $cpfLocatario = htmlspecialchars($cpfcnpj);
//                $dataBase = split("/", $dataBase);
//                $mesBase = htmlspecialchars($dataBase[1]."/".$dataBase[2]);
		$file = $servico->boletoMensalLocatario($dataBase, $cpfLocatario, '0');
		if ($file != ''){
                    header("Content-Type: application/pdf");
                    header("Content-Disposition: inline; filename=Boleto.pdf");
                    echo base64_decode( $file[out] );
                    print_r($file);
		} else {
			echo '<div class="alert alert-block"><h4>Não existe boleto para a data informada! </h4></div>';
		}
        } catch ( SoapFault $fault ){
                echo 'Opz, ' , $fault->getMessage();
        }
    }
    
    public function gerarExtratoMensal($dataBase){
        $servico = new ServicosJTecnologia($_SESSION["url_wsdl_servico"]);
        try {
		$file = $servico->extratoMensalLocador(trim($_SESSION["codLocador"]), $dataBase);
                //die($_SESSION["codLocador"]);
		if ($file != ''){
		    header("Content-Type: application/pdf");
                    header("Content-Disposition: inline; filename=ExtratoMensal.pdf");
                    header("Pragma: no-cache");
                    echo base64_decode( $file[out] );
                    print_r($file);
		} else {
			echo '<div class="alert alert-block"><h4>Não existe extrato mensal para a data informada! </h4></div>';
		}
	} catch ( SoapFault $fault ){
		echo 'Opz, ' , $fault->getMessage();
	}
    }
    
    public function gerarDemonstrativoAnual($dataBase){
        $servico = new ServicosJTecnologia($_SESSION["url_wsdl_servico"]);
        try {

		$file = $servico->demonstrativoAnual($dataBase,$_SESSION["codLocador"]);
		if ($file != ''){
		    header("Content-Type: application/pdf");
                    header("Content-Disposition: inline; filename=DemonstrativoAnual.pdf");
                    echo base64_decode( $file[out] );
                    print_r($file);
		} else {
			echo '<div class="alert alert-block"><h4> Não existe demonstrativo para o ano base informado! </h4></div>';
		}
	} catch (Exception $fault ){
		echo 'Opz, ' , $fault->getMessage();
	}
    }
    
    public function gerarMenuInicial(){
       $clienteUi = new ClienteUI();
       $servicoClienteDto = new ServicoClienteDTO();
       if(!empty($_SESSION["id_cliente"])){
       		$servicoClienteDto->setId_Cliente($_SESSION["id_cliente"]);       		
       		$servicoClienteRetornoDto = $servicoClienteDto->obterPorFiltroDTO(false);
       }else{
       	$servicoClienteRetornoDto = new ServicoClienteDTO();
       }		
       return $clienteUi->gerarHtmlIncial($servicoClienteRetornoDto); 
    }
    
}

?>
