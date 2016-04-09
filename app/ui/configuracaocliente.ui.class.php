<?php

class ConfiguracaoClienteUI {
	//put your code here
	public function __construct() {
		;
	}

	public function gerarPaginaConfiguracoesCliente($clienteDto){
		
		$divPai = new ARDiv();

		$form = new ARForm();
                $form->class = TipoFormClassBootstrap::FORM_HORIZONTAL;
		$form->method = TipoMethodForm::POST;
		$form->action = "index.php?modules=cliente&acao=listar";
		$form->id = "frmcliente";
		//$form->onsubmit("return validarFiltro();");
		
		$fieldSetFiltro = new ARFieldSet();
		$fieldSetFiltro->legend = "Filtro";
		
		$txtNome = new ARTextBox();
		$txtNome->name = "desc_nome_empresa";
		$txtNome->id = "desc_nome_empresa";
		$txtNome->label = "Nome Empresa";
		$txtNome->typeClassTextBox = TipoARTextBoxClass::SELECT;
                $txtNome->sizeLabelBootStrapClass = 1;
		$txtNome->bootStrap = true;
		$form->addItem($txtNome);
		
		$txtLogin = new ARTextBox();
		$txtLogin->name = "cod_cliente";
		$txtLogin->id = "cod_cliente";
		$txtLogin->label = "Código do Cliente";
		$txtLogin->typeClassTextBox = TipoARTextBoxClass::SELECT;
                $txtLogin->sizeLabelBootStrapClass = 1;
		$txtLogin->bootStrap = true;
		$form->addItem($txtLogin);		
		
		//Adiciona butao para submeter
		$div = new ARDiv();
		$div->style = "margin-left: 8%;";
		$botao = new ARButton();
		$botao->id = "btn_filtrar";
		$botao->name = "btn_filtrar";
		$botao->class = TipoClassButton::AZUL;
		$botao->label = "Filtrar";
		$acao = new ARAction("configuracaocliente", "filtrar");
		$acao->setParameter("debugar", "true");
		$botao->setAction = $acao;		
		//$botao->onclick("return filtrarcliente();");
		$div->addItem($botao);
		
		$botao = new ARButton();
		$botao->id = "btn_limpar";
		$botao->name = "btn_limpar";
		$botao->class = TipoClassButton::PADRAO;
		$botao->label = "Limpar";
		$botao->onclick("limparDados();");
		$div->addItem($botao);
		//Adiciona o botao ao form;
		$form->addItem($div);
		
		$fieldSetFiltro->addItem($form);
		
		$div1 = new ARDiv();
		$div1->id = "tabelacliente";
                $div1->class = "col-sm-12";
		
		$div1->addItem($this->gerarGrid($clienteDto));
				
		$divPai->addItem($fieldSetFiltro);
		$divPai->addItem($div1);
				
		return $divPai;

	}
	
	public function gerarPaginaClienteMNT($cod_cliente){
		
		$clienteDTO = new ClienteDTO();
		
		$divPai = new ARDiv();
				
		$form = new ARForm();
		$form->method = TipoMethodForm::POST;
		$form->enctype = TipoEncTypeForm::FILE;
		//$form->action = "index.php?modules=configuracaoclienteclientemnt&acao=listar";
		$form->id = "frmcliente";
		//$form->onsubmit("return validarFiltro();");
		
		$fieldSetFiltro = new ARFieldSet();
				
		if($cod_cliente > 0){
			
			$clienteDTO->setId_Cliente($cod_cliente);
			$clienteDTO = $clienteDTO->obterPorSqDTO()->getIterator()->current();
			$fieldSetFiltro->legend = "Editar Cliente";
			
			$txtNome = new ARTextBox();
			$txtNome->name = "id_cliente";
			$txtNome->id = "id_cliente";
			$txtNome->typeARTextBox = TipoARTextBox::HIDDEN;
			$txtNome->default = $clienteDTO->getId_Cliente();
			
			$form->addItem($txtNome);
			
		}else{
			$fieldSetFiltro->legend = "Cadastro de Cliente";
		}
		
		$txtNome = new ARTextBox();
		$txtNome->name = "desc_nome_empresa";
		$txtNome->id = "desc_nome_empresa";
		$txtNome->label = "Nome Empresa";
		$txtNome->typeClassTextBox = TipoARTextBoxClass::PADRAO;
		$txtNome->bootStrap = true;
		$txtNome->require = true;
		$txtNome->default = $clienteDTO->getDesc_Nome_Empresa();
		
		$form->addItem($txtNome);
		
		$txtLogin = new ARTextBox();
		$txtLogin->name = "cod_cliente";
		$txtLogin->id = "cod_cliente";
		$txtLogin->label = "Código do Cliente";
		$txtLogin->typeClassTextBox = TipoARTextBoxClass::PADRAO;
		$txtLogin->bootStrap = true;
		$txtLogin->require = true;
		$txtLogin->default = $clienteDTO->getCod_Cliente();
		
		
		$form->addItem($txtLogin);
		
		$txtLogin = new ARTextAreaBox();
		$txtLogin->name = "desc_descricao_servico";		
		$txtLogin->label = "Descriçao do Serviço";
		//$txtLogin->typeClassTextBox = TipoARTextBoxClass::PADRAO;
		$txtLogin->bootStrap = true;
		$txtLogin->require = true;
		$txtLogin->row = 5;
		$txtLogin->cols = 20;
		//$txtLogin->width = "30";
		$txtLogin->heigth = 100;
		$txtLogin->useTinyMce = true;
		$txtLogin->default = $clienteDTO->getDesc_Descricao_Servico();
		
		$form->addItem($txtLogin);
		
		$txtLogin = new ARTextBox();
		$txtLogin->name = "desc_url_servicos";		
		$txtLogin->label = "WSDL do serviço";
		$txtLogin->typeClassTextBox = TipoARTextBoxClass::XXLARGE;
		$txtLogin->bootStrap = true;
		$txtLogin->require = true;
		$txtLogin->width = 200;
		$txtLogin->default = $clienteDTO->getDesc_Url_Servicos();
		
		$form->addItem($txtLogin);
		
		$selectTipoServico = new ARSelectBox();
		$selectTipoServico->name = "tipo_acesso";
		$selectTipoServico->label = "Tipo de Acesso";
		$selectTipoServico->require = true;
		$selectTipoServico->default = $clienteDTO->getTipo_Acesso();
		
		$campo = new CampoHTML();
		$campo->setField("C");
		$campo->setFieldCaption("Captcha");
		
		$selectTipoServico->addCampo($campo);
		
		$campo = new CampoHTML();
		$campo->setField("S");
		$campo->setFieldCaption("Senha");
		$selectTipoServico->addCampo($campo);		
		
		$form->addItem($selectTipoServico);
		
		if($cod_cliente == 0){		
			$txtLogin = new ARTextBox();
			$txtLogin->name = "desc_caminho_logomarca";		
			$txtLogin->label = "Logomarca";
			$txtLogin->typeClassTextBox = TipoARTextBoxClass::PADRAO;
			$txtLogin->typeARTextBox = TipoARTextBox::FILE;
			$txtLogin->bootStrap = true;
			$txtLogin->require = true;
			
			$form->addItem($txtLogin);
		}else{		
			
			if(!is_null($clienteDTO->getDesc_Caminho_LogoMarca())){
				
				$divFile = new ARDiv();
				$divFile->id = "divFIle";
				$divFile->style = "display: none;";
			
				$txtLogin = new ARTextBox();
				$txtLogin->name = "desc_caminho_logomarca";
				$txtLogin->label = "Logomarca";
				$txtLogin->typeClassTextBox = TipoARTextBoxClass::PADRAO;
				$txtLogin->typeARTextBox = TipoARTextBox::FILE;
				$txtLogin->bootStrap = true;				
					
				$divFile->addItem($txtLogin);
				
				$form->addItem($divFile);
				
				$divFile = new ARDiv();
				$divFile->id = "divHidden";		
				
				$txtLogin = new ARTextBox();
				$txtLogin->name = "desc_caminho_logomarca_aux";
				$txtLogin->label = "Logomarca";
				$txtLogin->typeClassTextBox = TipoARTextBoxClass::PADRAO;
				$txtLogin->typeARTextBox = TipoARTextBox::HIDDEN;
				$txtLogin->default = $clienteDTO->getDesc_Caminho_LogoMarca();
				$txtLogin->bootStrap = true;				
				
				$divFile->addItem($txtLogin);
					
				$form->addItem($divFile);
				
				$divImagem = new ARDiv();
				$divImagem->id = "imgLogo";
				
				$imagem = new ARImage();
				$imagem->src = $clienteDTO->getDesc_Caminho_LogoMarca();
				$imagem->width = "400";			
				$imagem->heigth = "400";
				$imagem->label = "Logomarca";
				$imagem->bootStrap = true;
				
				$divImagem->addItem($imagem);
				
				$form->addItem($divImagem);
				
				$txtLogin = new ARTextBox();
				$txtLogin->name = "desc_caminho_logomarca_anterior";				
				$txtLogin->typeARTextBox = TipoARTextBox::HIDDEN;
				$txtLogin->default = $clienteDTO->getDesc_Caminho_LogoMarca();
								
				$form->addItem($txtLogin);
				
				$link = new ARLink();
				$link->id = "lnkremovelogo";
				$link->bootStrap = true;
				$link->label = " ";
				$link->text = "Remover Logo Marca";
				$link->href = "javascript:return false;";
				$link->onclick(" $('#divHidden').remove(); $('#imgLogo').remove(); $('#divFIle').show(); $('#desc_caminho_logomarca').attr('required','true'); $('#lnkremovelogo').remove(); ");			
				
				$form->addItem($link);
			}else{
				$txtLogin = new ARTextBox();
				$txtLogin->name = "desc_caminho_logomarca";
				$txtLogin->label = "Logomarca";
				$txtLogin->typeClassTextBox = TipoARTextBoxClass::PADRAO;
				$txtLogin->typeARTextBox = TipoARTextBox::FILE;
				$txtLogin->bootStrap = true;
				$txtLogin->require = true;
					
				$form->addItem($txtLogin);
			}
		}
		
		//Adiciona butao para submeter
		$div = new ARDiv();
		$div->style = "margin-left: 8%;";
		$botao = new ARButton();
		$botao->id = "btn_salvar";
		$botao->name = "btn_salvar";
		$botao->class = TipoClassButton::AZUL;
		$botao->label = "Salvar";
		$botao->setAction = new ARAction("configuracaoclientemnt", "salvar");
		$botao->causesValidation = true;
		//para funcionar com o tinymce.
		$botao->causesValidationScriptCuston = " $('#desc_descricao_servico').text(tinyMCE.get('desc_descricao_servico').getContent()); ";
		
		$div->addItem($botao);
		
		$botao = new ARButton();
		$botao->id = "btn_limpar";
		$botao->name = "btn_limpar";
		$botao->class = TipoClassButton::PADRAO;
		$botao->label = "Cancelar";
		$botao->onclick(" location.href = 'index.php?modules=configuracaocliente&acao=listar' ");
		$div->addItem($botao);
		//Adiciona o botao ao form;
		$form->addItem($div);
		
		$fieldSetFiltro->addItem($form);
				
		$divPai->addItem($fieldSetFiltro);		
		
		return $divPai;
	}
	
	public function gerarPaginaEditarDescricao($cod_cliente){
	
		$clienteDTO = new ClienteDTO();
	
		$divPai = new ARDiv();
	
		$form = new ARForm();
		$form->method = TipoMethodForm::POST;
		$form->enctype = TipoEncTypeForm::FILE;
		//$form->action = "index.php?modules=configuracaoclienteclientemnt&acao=listar";
		$form->id = "frmcliente";
		//$form->onsubmit("return validarFiltro();");
	
		$fieldSetFiltro = new ARFieldSet();
	
		if($cod_cliente > 0){
				
			$clienteDTO->setId_Cliente($cod_cliente);
			$clienteDTO = $clienteDTO->obterPorSqDTO()->getIterator()->current();
			$fieldSetFiltro->legend = "Editar Descricao do cliente {$clienteDTO->getDesc_Nome_Empresa()}";
				
			$txtNome = new ARTextBox();
			$txtNome->name = "id_cliente";
			$txtNome->id = "id_cliente";
			$txtNome->typeARTextBox = TipoARTextBox::HIDDEN;
			$txtNome->default = $clienteDTO->getId_Cliente();
				
			$form->addItem($txtNome);
				
		}
		
		$txtLogin = new ARTextAreaBox();
		$txtLogin->name = "desc_descricao_servico";
		$txtLogin->label = "Descriçao do Serviço";
		//$txtLogin->typeClassTextBox = TipoARTextBoxClass::PADRAO;
		$txtLogin->bootStrap = true;
		$txtLogin->require = true;
		$txtLogin->row = 5;
		$txtLogin->cols = 20;
		//$txtLogin->width = "30";
		$txtLogin->heigth = 100;
		$txtLogin->useTinyMce = true;
		$txtLogin->default = $clienteDTO->getDesc_Descricao_Servico();
	
		$form->addItem($txtLogin);
		
		//Adiciona butao para submeter
		$div = new ARDiv();
		$div->style = "margin-left: 8%;";
		$botao = new ARButton();
		$botao->id = "btn_salvar";
		$botao->name = "btn_salvar";
		$botao->class = TipoClassButton::AZUL;
		$botao->label = "Salvar";
		$botao->setAction = new ARAction("configuracaoclientemnt", "salvarDescricao");
		$botao->causesValidation = true;
		//para funcionar com o tinymce.
		$botao->causesValidationScriptCuston = " $('#desc_descricao_servico').text(tinyMCE.get('desc_descricao_servico').getContent()); ";
	
		$div->addItem($botao);
	
		$botao = new ARButton();
		$botao->id = "btn_limpar";
		$botao->name = "btn_limpar";
		$botao->class = TipoClassButton::PADRAO;
		$botao->label = "Cancelar";
		$botao->onclick(" window.parent.$.fancybox.close(); ");
		$div->addItem($botao);
		//Adiciona o botao ao form;
		$form->addItem($div);
	
		$fieldSetFiltro->addItem($form);
	
		$divPai->addItem($fieldSetFiltro);
	
		return $divPai;
	}
	
	/**
	 * 
	 * @param ClienteDTO $clienteDto
	 */
	public function gerarGrid($clienteDto){
	
		$arGrid = new ARGrid();
	
                $arGrid->class = "table table-bordered table-hover dataTable";
                
		$arGrid->legend = "Lista de Clientes";
	
		$field = new ARField("id_cliente","");
	
		$arGrid->addField($field);
	
		$field = new ARField();
		$field->field = "desc_nome_empresa";
		$field->fieldCaption = "Nome Empresa";
		$field->fieldFilter = "desc_nome_empresa";
	
		$arGrid->addField($field);
	
		$field = new ARField();
		$field->field = "cod_cliente";
		$field->fieldCaption = "Código Cliente";
		//$field->formart = new Formatercliente();
		$field->fieldFilter = "cod_cliente";
		$arGrid->addField($field);
	
		$field = new ARField();
		$field->field = "desc_descricao_servico";
		$field->fieldCaption = "Descrição do Serviço";
		$field->fieldFilter = "desc_descricao_servico";
		$field->formart = new FormaterClienteLink();
		$field->width = 200;
	
		$arGrid->addField($field);
		
		$field = new ARField();
		$field->field = "desc_url_servicos";
		$field->fieldCaption = "URL Serviço";
		$field->fieldFilter = "desc_url_servicos";
		$field->width = 50;
		
		
		$arGrid->addField($field);
		
		$field = new ARField();
		$field->field = "tipo_acesso";
		$field->fieldCaption = "Tipo de Acesso";
		$field->fieldFilter = "tipo_acesso";
		$field->align = ARGridAlign::CENTER;
		$field->width = 150;		
		
		$arGrid->addField($field);
		
		$field = new ARField();
		$field->field = "desc_caminho_logomarca";
		$field->fieldCaption = "Logomarca";
		//$field->fieldFilter = "tipo_acesso";
		$field->formart = new FormaterClienteImagem();
		$field->align = ARGridAlign::CENTER;
		$field->width = 150;
		
		$arGrid->addField($field);
	
		$arGrid->dataSource = $clienteDto;
		$arGrid->itenPerPage = 5;
		//$arGrid->ajax = true;
		$arGrid->actionAjaxSubmit = Config::ACAO_GERAR_GRID;
		$arGrid->classSubmitButtons = "configuracaoclientemnt";
		$arGrid->itenPerPage = 3;
	
		return $arGrid;
	
	}
}






