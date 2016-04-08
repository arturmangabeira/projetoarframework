<?php
class Config{
	/*
    //const DB_HOST    = "192.168.1.130:3306";
    const DB_HOST = "mysql.jsolucoesti.com.br";
    const DB_USUARIO = "jsolucoesti01";
    const DB_SENHA   = "Brasilia2001";
//    const DB_USUARIO = "root";
//    const DB_SENHA   = "bdartur";
    const DB_BANCO   = "jsolucoesti01";
    */
	const DB_HOST = "localhost";	
	const DB_USUARIO = "sga";
	const DB_SENHA   = "sga456";
	const DB_BANCO   = "sga";
    const DB_DRIVER  = "mysqlt";
    
    //Acões para a Grid
    const ACAO = "acao";
    const ACAO_EDITAR = "editar";
    const ACAO_ATUALIZAR = "atualizar";
    const ACAO_EXCLUIR = "excluir";
    const ACAO_NOVO = "incluir";
    const ACAO_FILTRAR = "filtrar";
    const ACAO_LISTAR = "listar";
    const ACAO_INSERIR = "inserir";
    const ACAO_OBTER_DADOS_GRID = "obterDadosGrid";
    const ACAO_GERAR_GRID = "gerarGrid";
    const VALUEID = "valueid";
    
    //Data Type de definição da flexigrid
    const DATA_TYPE_GRID_XML = "xml";
    const DATA_TYPE_GRID_JSON = "json";
    const DEFINE_USER_PAGE_GRID_TRUE = "true";
    const DEFINE_USER_PAGE_GRID_FALSE = "false";
    
    //Classe das mensagens enviadas para exibição.
    const MENSAGEM_SUCESSO = "success";
    const MENSAGEM_ERRO = "error";
    const MENSAGEM_AVISO = "warning";
    const MENSAGEM_INFORMACAO = "info";
	//
    const APP_LOGIN = "userloteria";
    const APP_SENHA = "dividaativa2012";
    
    CONST CAMINHO_APP = "C:/wamp/www/projetoar/";
    
    const CAMINHO_CADASTRO_CLIENTES = "clientes/";
    
    //CONFIGURAÇÕES DO TEMA
    const TEMA = "adminlte";
    
    const PAGINA_INICIAL = "admin";
    
    const VERSAO_BOOTSTRAP = "3";
    
    public static function autenticacao($login, $senha) {
        $retorno = false;
        if (Config::APP_LOGIN == $login and Config::APP_SENHA == base64_decode($senha)) {
            $retorno = true;
        }
        return $retorno;
    }
    
}
define("PATH_LIB_FPDF","/var/www/bibliotecas/libfpdf/");
ini_set('include_path',get_include_path().':'.PATH_LIB_FPDF);
define("listar","1");
define("inserir","2");
define("atualizar","3");
define("excluir","4");
?>
