<?php
class funcoes {

    private static $acao;
    private static $modulo;
    private static $submodulo;
    
    function funcoes() {
        
    }
    
    public static function preencheDTO(GenericDTO $genericDTO,$sql=""){
        $conn = Conexao::getInstance();
        
        if (empty($sql)){
            $sql = "SELECT * FROM ".$genericDTO->getTable();
        }
        
        $recordSet = $conn->Execute($sql);
        
        if($recordSet->RecordCount() > 0){        
            $array_methods = get_class_methods("CaixaDTO");
            $arrayValor = $retorno->getArray();
            foreach ($arrayValor as $value) {
                //print_r($array_methods)
                foreach($array_methods as $metodos) {
                    if(strstr($metodos,'set')){
                            $genericDTO->$metodos;	
                    }	
                }
            }
        }
        //http://apostilas.fok.com.br/manual-do-php/language.oop5.reflection.php#language.oop5.reflection.reflectionmethod        
    }
    
    public static function redirecionar($url,$mensagem="",$classe="",$timeout=false,$time=3000){
        $concatenaE = "&";
        if(!strstr($url,"?")){
            $url .= "?";
            $concatenaE = "";
        }
        
        if(!empty($mensagem)){
            $url = $url."{$concatenaE}mensagem=".base64_encode($mensagem);
                        
        }
        if(!empty($classe)){
           $url = $url."&classe=".$classe;  
        }
        
        $url = Config::SITE_ADDRESS.$url;
        
        //header("Location:".$url);
        $script  = "<script type=\"text/javascript\">";
        if($timeout){
        	$script .= "  setTimeout(function(){ location.href='{$url}'; }, "+$time+");";
        }else{
        	$script .= "  location.href='{$url}'; ";
        }
        $script .= "</script>";
        
        echo $script;
    }
    
    public static function gerarTituloPagina($titulo){
        $titulo = "<div id=\"topBar\">
                        <div class=\"titPage\"><strong><h4> <p class=\"text-info\">{$titulo}</p> </h4></strong></div>
                   </div>";
                        
        echo $titulo;               
    }
    
    /**
     * Metodo para remover caracteres de uma string
     * @param string $string
     * @param mixed $array_remover
     */
    public static function remover_caracteres($string,$array_remover=array("-","/",".")) {
        $string = str_replace($array_remover,"",$string);
        return $string;
    }
    
    
    public static function trataValorMonetario($valor) {

        if(trim($valor)!='') {
            $valor = str_replace(".","",$valor);
            $valor = str_replace(",",".",$valor);
        }else {
            $valor = "NULL";
        }
        return $valor;
    }
    
    /**
    * Verifica se um diretório existe, suas permissões, e o criar caso não exista
    * @param string Pasta a ser analisada
    * @param int Permissão desejada
    * @return boolean True caso exista ou seja criado, ou false
    */
   public static function verificar_diretorio($diretorio = "", $permissao = 0777) {

       if (trim($diretorio) == "") {
           return false;
       }
       if (file_exists($diretorio)) {

           if (is_writable($diretorio)) {
               return true;
           }

           if (@chmod($diretorio, $permissao)) {
               return true;
           }
       } elseif (mkdir($diretorio, $permissao)) {
           return true;
       }

       return false;
   }
   
   //Remove um array de strings de um texto
    public static function retirar_palavras($array, $texto) {
        foreach ($array as $i => $valor)
            $texto = eregi_replace($valor, "", $texto);

        return $texto;
    }
    
     /**
     * Metodo que retira acenstos das pelavras ou texto
     */
    public static function retirar_acentos($string) {
        $array1 = array(   "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì",
                "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç",
                "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì",
                "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" );
        $array2 = array(   "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o",
                "o", "o", "o", "o", "u", "u", "u", "u", "c",
                "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I",
                "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );
        return str_replace( $array1, $array2, $string);
    }
    
    /**
    * @method Verifica se arquivo e renomeia ate encontrar nome que nao exista
    * String com o diretorio do arquivo
    * @param string $caminho
    * String com o nome do arquivo
    * @param string $arquivo
    * String com o nome alterado do arquivo
    * @return string $arquivo
    */
   public static function verificarArquivoExiste($caminho, $arquivo) {
       $cont = 1;
       $arquivo_existe = true;
       $extensao = array();
       // Pega extensão do arquivo
       preg_match("/\\.(gif|png|jpg|jpeg){1}$/i", $arquivo, $extensao);

       // Faz um loop ate q o arquivo renomeado nao exista no diretorio
       while ($arquivo_existe == true) {
           // Verifica se o arquivo ja existe no diretorio
           if (file_exists($caminho . $arquivo)) {
               //captura o nome sem a extensão
               $nome = substr($arquivo, 0, -4);
               // Gera um nome único para a imagem com código randomico
               $arquivo = $nome . "_" . rand(0, 100) . "." . $extensao[1];
               $cont++;
               $arquivo_existe = true;
           } else {
               $arquivo_existe = false;
           }
       }
       return $arquivo; //retorna o nome alterado do arquivo
   }

    /**
     * @method Metodo para fazer upload de arquivo
     * Arquivo de imagem - retira os espcos e caracteres especiais
     * @param $_FILE $arquivo Arquivo de upload
     * @param string $caminho Caminho fisico do servidor
     * @return string $nome_arquivo
     */
    public static function  moverArquivoUpload($arquivo, $caminho) {
        // Define o diretório destino do upload
        if (!empty($arquivo) && is_file($arquivo['tmp_name'])) {

            //substitui os espacos em branco e retira os acentos
            $nome_arquivo = trim(self::retirar_acentos(str_replace(" ", "", $arquivo['name'])));

            //substitui alguns caracteres que podem gerar problema na exibicao da imagem
            $array_caracteres = array("°", "º", "ª", "@", "#", "!", "%", ",", ";");

            $nome_arquivo = self::retirar_palavras($array_caracteres, $nome_arquivo);

            //Chama metodo para verificar se o arquivo a ser incluso
            //ja existe no diretorio de imagems, caso exista eh renomeado
            if (file_exists($caminho . $nome_arquivo)) {
                //recebe o nome novo do arquivo, ja renomeado
                $nome_arquivo = self::verificarArquivoExiste($caminho, $nome_arquivo);
            }

            // Move o arquivo para o diretorio definido
            if (move_uploaded_file($arquivo['tmp_name'], $caminho . $nome_arquivo)) {
                chmod($caminho . $nome_arquivo, 0777); //fornece permissao
            } else {
                die("Falha na transferencia do arquivo! " . $caminho . $nome_arquivo);
            }
        } //fim do if
        //retorna o nome do arquivo
        return $nome_arquivo;
    }

    
    public static function validarAcesso(){
        self::$acao = $_REQUEST['acao'];
        self::$modulo = $_REQUEST['modules'];
        self::$submodulo = $_REQUEST['submodulo'];
        
        $conn = Conexao::getInstance();
        
        $sqGrupo = "";
        
        if (!empty($_SESSION["sqGrupo"])){
           $sqGrupo = $_SESSION["sqGrupo"]; 
        }
        $modulo = new Modulo();   
        $moduloDTO = new ModuloGrupoDTO();
        $moduloDTO->setDsNomeModulo(self::$modulo);
        $moduloDTO->setSqGrupo($sqGrupo);
        
        $arrayRetorno = new ArrayObject();
        
        $arrayRetorno = $modulo->obterModuloPorNome($moduloDTO);   
        
        if($arrayRetorno->count() >0){
            
            $moduloDTO = new ModuloDTO();
            $moduloDTO = $arrayRetorno->getIterator()->current();
            
            if(!empty(self::$modulo) && !empty(self::$acao)){
                
                $sql = " SELECT sqModulo FROM wd_modulo_grupo_acoes where ";
                
                $sql .= " sqModulo = {$moduloDTO->getSqModulo()} ";
                
                if (self::$acao == Config::ACAO_NOVO){
                
                    $sql .= " AND sqAcao = 2 ";
                
                }
                
                if (self::$acao == Config::ACAO_EDITAR){
                
                    $sql .= " AND sqAcao = 3 ";
                
                }
                
                if (self::$acao == Config::ACAO_LISTAR || self::$acao == Config::ACAO_FILTRAR){
                
                    $sql .= " AND sqAcao = 1 ";
                
                }
                
                if (self::$acao == Config::ACAO_EXCLUIR){
                
                    $sql .= " AND sqAcao = 4 ";
                
                }
                
                $sql .= " AND sqGrupo = {$sqGrupo} ";
                
                $result = $conn->Execute($sql);

                if ($result->RecordCount() == 0){
                    
                    if (self::$acao == Config::ACAO_NOVO){
                        $mensagem = "Você não possue acesso a ação ".Config::ACAO_NOVO." no módulo de ".self::$modulo;
                    }
                    
                    if (self::$acao == Config::ACAO_ATUALIZAR || self::$acao == Config::ACAO_EDITAR){
                        $mensagem = "Você não possue acesso a ação ".Config::ACAO_ATUALIZAR." no módulo de ".self::$modulo;
                    }

                    if (self::$acao == Config::ACAO_EXCLUIR){
                        $mensagem = "Você não possue acesso a ação ".Config::ACAO_EXCLUIR." no módulo de ".self::$modulo;
                    }

                    if (self::$acao == Config::ACAO_LISTAR){
                        $mensagem = "Você não possue acesso a ação ".Config::ACAO_LISTAR." no módulo de ".self::$modulo;
                    }

                                        
                    self::redirecionar("main.php", $mensagem, Config::MENSAGEM_ERRO);
                }
            }
        }
    }
}   
?>
