<?php

class MetodosClienteWS {
	const EXTRATO_MENSAL_LOCADOR = "ExtratoMensalLocadorPDF";
        const BOLETO_MENSAL_LOCATARIO = "BoletoMensalLocatario";
        const VERIFICA_CADASTRO_LOCATARIO = "VerificaCadastroLocatario";
        const VERIFICA_CADASTRO_PROPRIETARIO = "VerificaCadastroProprietario";
        const DEMONSTRATIVO_ANUAL = "DemonstrativoAnual";
        const VERIFICA_CADASTRO = "VerificaCadastro";
        const LOGIN_ACESSO_SGA = "LoginAcessoServicoSGA";
        const ALTERA_SENHA_SGA = "AlterarSenhaServicoSGA";
}


class ServicosJTecnologia{

    private $ws;
    
    public function __construct($_wsdl) {
        $this->ws = new WebServices($_wsdl);
    }

    function extratoMensalLocador($codLocador,$mesBase){
        //$parametros = array($codLocador,$mesBase);
        $parametros = array('codLocador' => trim($codLocador), 'mesBase' => $mesBase,);
        return $this->ws->carregar(MetodosClienteWS::EXTRATO_MENSAL_LOCADOR, $parametros);
    }

    function boletoMensalLocatario($MesBase,$cpfLocatario,$idLocatario){
        $parametros = array(trim($MesBase),trim($cpfLocatario),$idLocatario);
        return $this->ws->carregar(MetodosClienteWS::BOLETO_MENSAL_LOCATARIO, $parametros);
    }

    function verificaCadastroLocatario($cpfLocatario){
        $parametros = array($cpfLocatario);
        return $this->ws->carregar(MetodosClienteWS::VERIFICA_CADASTRO_LOCATARIO, $parametros);
    }

    function verificaCadastroProprietario($cpfProprietario){
        $parametros = array($cpfProprietario);
        return $this->ws->carregar(MetodosClienteWS::VERIFICA_CADASTRO_PROPRIETARIO, $parametros);
    }
    
    function verificaCadastro($cpfcnpj){
        $parametros = array($cpfcnpj);
        return $this->ws->carregar(MetodosClienteWS::VERIFICA_CADASTRO, $parametros);
    }

    function demonstrativoAnual($anoBase,$scodProprietario){
        $parametros = array($anoBase,$scodProprietario);
        return $this->ws->carregar(MetodosClienteWS::DEMONSTRATIVO_ANUAL, $parametros);
    }
    
    function loginAcessoServicoSGA($cpfcnpj,$senha){
    	$parametros = array($cpfcnpj,$senha);
    	return $this->ws->carregar(MetodosClienteWS::LOGIN_ACESSO_SGA, $parametros);    
    }
    
    function alterarSenhaServicoSGA($cpfcnpj,$novaSenha){
    	$parametros = array($cpfcnpj,$novaSenha);
    	return $this->ws->carregar(MetodosClienteWS::ALTERA_SENHA_SGA, $parametros);
    }
}
?>