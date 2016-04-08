<?php
/**
 * Description of configuracoes
 *
 * @author artur
 */
class ConfiguracaoClienteMnt extends PageGrid{
	//put your code here
	public function __construct() {
		parent::__construct();
	}

	public function generatePage($args) {
		
		if($_SESSION["acessoAdmin"] == false){
			ARMessage::showMessage("Você não possuie acesso ao gerênciamento do sistema!",ARMessageType::AVISO);
			return;
		}
		
		$configUI = new ConfiguracaoClienteUI();		
		 switch ($args->acao) {            
            case "editar":                 	
                $this->addItemPage($configUI->gerarPaginaClienteMNT($_REQUEST["valueid"]));
            break;
            
            case "editarDescricao":            	
            	$this->addItemPage($configUI->gerarPaginaEditarDescricao($_REQUEST["valueid"]));
            	break;
            
            default:				
				$this->addItemPage($configUI->gerarPaginaClienteMNT(0));
			break;
		 }
	}
	
	public function salvarDescricao(){
		
		$clienteDTO = new ClienteDTO();
				
		if(!empty($_REQUEST["id_cliente"])){
			
			$clienteDTO->bindContextDTO();
			
			$clienteDTO->atualizarDTO();
			
			ARMessage::showMessage("A descrição foi alterado com sucesso!",ARMessageType::ERRO,"window.parent.$('#btn_filtrar').click(); window.parent.$.fancybox.close(); ");
			
		}
	}
	
	public function salvar(){			
		
		$clienteDTO = new ClienteDTO();
		
		//die(var_dump($_REQUEST));
		
		if(empty($_REQUEST["id_cliente"])){
		
			$clienteDTO->setCod_Cliente($_REQUEST["cod_cliente"]);		
			//verifia a exitenci do cliente
			$result = $clienteDTO->obterPorFiltroDTO();
			
			if($result->count() == 0){			
				$clienteDTO->bindContextDTO();			
				//realiza o upload do arquivo
				$caminhoArquivo = Config::CAMINHO_APP.Config::CAMINHO_CADASTRO_CLIENTES.$clienteDTO->getCod_Cliente();
				//verifica se o diretório existe. caso não exista será criado um novo com permissão de escrita. 
				if(!is_dir($caminhoArquivo)){
					mkdir($caminhoArquivo,0777);
				}
	
				$nomeArquivo = funcoes::moverArquivoUpload($clienteDTO->getDesc_Caminho_LogoMarca(), $caminhoArquivo."/");
				
				$clienteDTO->setDesc_Caminho_LogoMarca(Config::CAMINHO_CADASTRO_CLIENTES.$clienteDTO->getCod_Cliente()."/".$nomeArquivo);
				
				$resultado = $clienteDTO->inserirDTO();
				
				ARMessage::showMessage("Cliente inserido com sucesso! Voce será redirecionado para a tela de listagem do clientes",ARMessageType::ERRO,"","index.php?modulos=configuracaocliente&acao=listar",1000);
			}else{
				ARMessage::showMessage("O código do cliente informado já existe na base, favor fornecer um outro!",ARMessageType::ERRO);	
			}		
		}else{			
			//preenche o DTO de acordo com o contexto.			
			$clienteDTO->bindContextDTO();
			
			//verifica se o usuário não inseriu uma nova imagem
			if(!empty($_REQUEST["desc_caminho_logomarca_aux"])){
				$clienteDTO->setDesc_Caminho_LogoMarca($_REQUEST["desc_caminho_logomarca_aux"]);				
			}else{
				//significa que está mandando uma nova imagem.
				//remove a imagem anterior do servidor.
				$caminhoArquivoRemover = Config::CAMINHO_APP.$_REQUEST["desc_caminho_logomarca_anterior"];
				//remove a imagem anterior do servidor.
				unlink($caminhoArquivoRemover);
				
				$caminhoArquivo = Config::CAMINHO_APP.Config::CAMINHO_CADASTRO_CLIENTES.$clienteDTO->getCod_Cliente();
				
				$nomeArquivo = funcoes::moverArquivoUpload($clienteDTO->getDesc_Caminho_LogoMarca(), $caminhoArquivo."/");
				
				$clienteDTO->setDesc_Caminho_LogoMarca(Config::CAMINHO_CADASTRO_CLIENTES.$clienteDTO->getCod_Cliente()."/".$nomeArquivo);
			}
			
			//realiza o upload do arquivo
			$caminhoArquivo = Config::CAMINHO_APP.Config::CAMINHO_CADASTRO_CLIENTES.$clienteDTO->getCod_Cliente();
			//verifica se o diretório existe. caso não exista será criado um novo com permissão de escrita.
			if(!is_dir($caminhoArquivo)){
				mkdir($caminhoArquivo,0777);
			}
		
			
		
			$resultado = $clienteDTO->atualizarDTO();
		
			ARMessage::showMessage("Cliente inserido com sucesso! Voce será redirecionado para a tela de listagem do clientes",ARMessageType::ERRO,"","index.php?modulos=configuracaocliente&acao=listar",1000);	
					
		}
	}
	
}