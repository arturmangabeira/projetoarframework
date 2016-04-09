<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of servico
 *
 * @author artur
 */
class ServicoUI {
    //put your code here
    public function __construct() {
        ;
    }
    
    /**
     * 
     * @param ServicoDTO $servicoDTO
     * @return ARDiv
     */
    public function gerarPaginaServico($servicoDTO){
        $divPai = new ARDiv();

		$form = new ARForm();
		$form->method = TipoMethodForm::POST;
		$form->action = "index.php?modules=servico&acao=listar";
		$form->id = "frmcliente";
		//$form->onsubmit("return validarFiltro();");
		
		$fieldSetFiltro = new ARFieldSet();
		$fieldSetFiltro->legend = "Filtro";
		
		$txtNome = new ARTextBox();
		$txtNome->name = "desc_servico";		
		$txtNome->label = "Descrição do Serviço";
		$txtNome->typeClassTextBox = TipoARTextBoxClass::SELECT;
		$txtNome->bootStrap = true;
		
		$form->addItem($txtNome);
		
		$txtLogin = new ARTextBox();
		$txtLogin->name = "desc_wsdl_servico";
		$txtLogin->id = "desc_servico";
		$txtLogin->label = "Nome do Serviço";
		$txtLogin->typeClassTextBox = TipoARTextBoxClass::SELECT;
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
		$botao->setAction = new ARAction("servico", "filtrar");		
		
		$div->addItem($botao);
		
		$botao = new ARButton();
		$botao->id = "btn_limpar";
		$botao->name = "btn_limpar";
		$botao->class = TipoClassButton::PADRAO;
		$botao->label = "Limpar";
		$botao->onclick("limparDados();");
		$div->addItem($botao);
		
		$form->addItem($div);
		
		$fieldSetFiltro->addItem($form);
		
		$div1 = new ARDiv();
		$div1->id = "tabelacliente";
		
		$div1->addItem($this->gerarGrid($servicoDTO));
				
		$divPai->addItem($fieldSetFiltro);
		$divPai->addItem($div1);
				
		return $divPai;
        
    }
    
    public function gerarPaginaServicoMNT($id_servico){
    	
    	$servicoDTO = new ServicoDTO();
    	
    	$divPai = new ARDiv();
    	
    	$form = new ARForm();
    	$form->method = TipoMethodForm::POST;
    	$form->enctype = TipoEncTypeForm::FILE;
    	//$form->action = "index.php?modules=configuracaoclienteclientemnt&acao=listar";
    	$form->id = "frmservico";
    	//$form->onsubmit("return validarFiltro();");
    	
    	$fieldSetFiltro = new ARFieldSet();
    	
    	if($id_servico > 0){
    			
    		$servicoDTO->setId_Servico($id_servico);
    		$servicoDTO = $servicoDTO->obterPorSqDTO()->getIterator()->current();
    		$fieldSetFiltro->legend = "Editar Serviço";
    			
    		$txtNome = new ARTextBox();
    		$txtNome->name = "id_servico";
    		$txtNome->id = "id_servico";
    		$txtNome->typeARTextBox = TipoARTextBox::HIDDEN;
    		$txtNome->default = $servicoDTO->getID_Servico();
    			
    		$form->addItem($txtNome);
    			
    	}else{
    		$fieldSetFiltro->legend = "Cadastro de Serviço";
    	}
    	
    	$txtNome = new ARTextAreaBox();
    	$txtNome->name = "desc_servico";
    	$txtNome->id = "desc_servico";
    	$txtNome->label = "Descrição do Serviço";
    	//$txtNome->typeClassTextBox = TipoARTextBoxClass::PADRAO;
    	$txtNome->bootStrap = true;
    	$txtNome->require = true;
    	$txtNome->default = $servicoDTO->getDesc_Servico();
    	
    	$form->addItem($txtNome);
    	
    	$txtLogin = new ARTextBox();
    	$txtLogin->name = "desc_wsdl_servico";
    	$txtLogin->id = "desc_wsdl_servico";
    	$txtLogin->label = "Nome do Serviço";
    	$txtLogin->typeClassTextBox = TipoARTextBoxClass::PADRAO;
    	$txtLogin->bootStrap = true;
    	$txtLogin->require = true;
    	$txtLogin->default = $servicoDTO->getDesc_Wsdl_Servico();
    	
    	
    	$form->addItem($txtLogin);
    	    	    	
    	//Adiciona butao para submeter
    	$div = new ARDiv();
    	$div->style = "margin-left: 8%;";
    	$botao = new ARButton();
    	$botao->id = "btn_salvar";
    	$botao->name = "btn_salvar";
    	$botao->class = TipoClassButton::AZUL;
    	$botao->label = "Salvar";
    	$botao->setAction = new ARAction("servicomnt", "salvar");
    	$botao->causesValidation = true;
    	//para funcionar com o tinymce.
    	//$botao->causesValidationScriptCuston = " $('#desc_descricao_servico').text(tinyMCE.get('desc_descricao_servico').getContent()); ";
    	
    	$div->addItem($botao);
    	
    	$botao = new ARButton();
    	$botao->id = "btn_limpar";
    	$botao->name = "btn_limpar";
    	$botao->class = TipoClassButton::PADRAO;
    	$botao->label = "Cancelar";
    	$botao->onclick(" location.href = 'index.php?modules=servico&acao=listar' ");
    	$div->addItem($botao);
    	//Adiciona o botao ao form;
    	$form->addItem($div);
    	
    	$fieldSetFiltro->addItem($form);
    	
    	$divPai->addItem($fieldSetFiltro);
    	
    	return $divPai;
    }
    
    /**
     * 
     * @param ServicoDTO $servicoDTO
     * @return ARGrid
     */
    public function gerarGrid($servicoDto){
    
    	$arGrid = new ARGrid();
    
    	$arGrid->legend = "Lista de Serviços";
    
    	$field = new ARField("id_servico","");
    
    	$arGrid->addField($field);
    
    	$field = new ARField();
    	$field->field = "desc_wsdl_servico";
    	$field->fieldCaption = "Nome Servico";
    	$field->fieldFilter = "desc_wsdl_servico";
    
    	$arGrid->addField($field);
    
    	$field = new ARField();
    	$field->field = "desc_servico";
    	$field->fieldCaption = "Descrição do Serviço";
    	//$field->formart = new Formatercliente();
    	$field->fieldFilter = "desc_servico";
    	$arGrid->addField($field);    	  
    
    	$arGrid->dataSource = $servicoDto;
    	$arGrid->itenPerPage = 5;
    	//$arGrid->ajax = true;
    	$arGrid->actionAjaxSubmit = Config::ACAO_GERAR_GRID;
    	$arGrid->classSubmitButtons = "servicomnt";
    	$arGrid->itenPerPage = 10;
    
    	return $arGrid;
    
    }
    
    public function gerarPaginaConfiguracoesServicoCliente($clienteDto){
    
    	$divPai = new ARDiv();
    
    	$form = new ARForm();
    	$form->method = TipoMethodForm::POST;
    	$form->action = "index.php?modules=cliente&acao=listar";
    	$form->id = "frmcliente";
    	//$form->onsubmit("return validarFiltro();");
    
    	$fieldSetFiltro = new ARFieldSet();
    	$fieldSetFiltro->legend = "Configuração de Cliente e Serviço";
    
    	$div1 = new ARDiv();
    	$div1->id = "tabelacliente";
    	
    	$div1->addItem($this->gerarGridClienteServico($clienteDto));
    
    	$divPai->addItem($fieldSetFiltro);
    	$divPai->addItem($div1);
    
    	return $divPai;
    
    }
    
    public function gerarGridClienteServico($clienteDto){
    
    	$arGrid = new ARGrid();
    	$arGrid->showButtons = false;
    	$arGrid->legend = "Lista de Serviços dos Clientes";
    	
    	$arGrid->showSelectField = false;
    	
    	$field = new ARField("id_cliente","");    	
    	$field->visible = false;
    	
    	$arGrid->addField($field);
    
    	$field = new ARField();
    	$field->field = "desc_nome_empresa";
    	$field->fieldCaption = "Nome Empresa";
    	$field->fieldFilter = "desc_nome_empresa";
    
    	$arGrid->addField($field);
    	
    	$field = new ARField();
    	$field->field = "id_cliente";
    	$field->fieldCaption = "Serviço Configuração";
    	$field->formart = new FormaterServicoCliente();
    	$field->fieldFilter = "id_cliente";
    	
    	$arGrid->addField($field);
    
    	$arGrid->dataSource = $clienteDto;
    	//$arGrid->itenPerPage = 5;
    	//$arGrid->ajax = true;
    	$arGrid->actionAjaxSubmit = Config::ACAO_GERAR_GRID;
    	$arGrid->classSubmitButtons = "configuracaoclientemnt";
    	$arGrid->itenPerPage = 2;
    
    	return $arGrid;
    
    }
    
}

?>
