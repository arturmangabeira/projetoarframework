<?php
session_start();
/**
 * Description of cliente
 *
 * @author artur
 */
class ClienteUI {
    //put your code here
    public function __construct() {
        ;
    }
    
    /**
     * Função que monta a página inicial de cliente 
     * @param ArrayObject $servicoClienteDto
     * @return objetoHTML
     */
    public function gerarHtmlIncial($servicoClienteDto){        
        
        $divHead = new ARDiv();
        $divHead->class = "head";
        
        $divNavBar = new ARDiv();
        $divNavBar->class = "navbar";

        $divNavBarInner = new ARDiv();
        $divNavBarInner->class = "navbar-inner";

        $divConteiner = new ARDiv();
        $divConteiner->class = "sidebar-menu";
        
        $divConteiner->addItem(new ARTextHml("<ul class=\"sidebar-menu\">"));
        $divConteiner->addItem(new ARTextHml("<li><a href=\"index.php?modulos=cliente&acao=exibir&page=bvd\"><i class=\"icon-home\"></i> Início</a></li>"));
        
        $divConteiner->addItem(new ARTextHml("<li><a href=\"index.php?modulos=cliente&acao=exibir&page=boleto\"><i class=\"icon-barcode\"></i> Boleto</a></li>"));


        $divConteiner->addItem(new ARTextHml("<li><a href=\"index.php?modulos=cliente&acao=exibir&page=extrato\"><i class=\"icon-th\"></i>Segunda Via</a></li>"));


        $divConteiner->addItem(new ARTextHml("<li><a href=\"index.php?modulos=cliente&acao=exibir&page=extrato\"><i class=\"icon-list-alt\"></i> Extrato Mensal</a></li>"));


        $divConteiner->addItem(new ARTextHml("<li><a href=\"index.php?modulos=cliente&acao=exibir&page=demonstrativo\"><i class=\"icon-align-justify\"></i> Demonstrativo Anual</a></li>"));
	
        
        
        
        $divConteiner->addItem(new ARTextHml("<li class=\"treeview\"><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\" href=\"index.php?modulos=configuracoes\">
                                                <i class=\"icon-cog\"></i> Configurações <span class=\"caret\"></span></a>
                                                <ul class=\"treeview-menu\">
                                                            <li><a href=\"index.php?modulos=configuracaocliente&acao=listar\">Clientes</a></li>
                                                            <li><a href=\"index.php?modulos=servico&acao=listar\">Serviços</a></li>
                                                            <li><a href=\"index.php?modulos=servicocliente&acao=listar\">Serviços do Cliente</a></li>
                                                                <li role=\"separator\" class=\"divider\"></li>
                                                            <li><a href=\"#\">Preferências</a></li>												            												            
                                                     </ul>
        					</li> "));
                
        $divConteiner->addItem(new ARTextHml("</ul>"));
        $divBtn = new ARDiv();
        $divBtn->class = "btn-group pull-right";
        
        $button = new ARButton();
        $button->class = TipoClassButton::AZUL;
        $button->bootstrap = false;
        $button->label = "<i class=\"icon-off\"></i> Sair";
       //$button->onclick(" location.href='index.php?modulos=login&acao=logout'; ");
               
        $button->setAction = new ARAction("login", "logout");;
        //$button->setAction = new ActionButton("login", "logout");;
        
        //$divBtn->addItem($button);
        //$divConteiner->addItem($divBtn);
        
        $divNavBarInner->addItem($divConteiner);
        $divNavBar->addItem($divNavBarInner);
        
        //$divHead->addItem($divRow);
        $divHead->addItem($divNavBar);
        
        $link = new ARLink();
        $link->id = "lnk_modal";
        $link->modal = true;
        $link->bootStrap = false;
        //$divHead->addItem($link);
        
        $divConteiner->addItem($link);
        
        return $divConteiner;
         
    }
    
    public function gerarBoasVindas(){
        $div = new ARDiv();
        $div->class = "alert alert-block";
        $div->addItem(new ARTextHml("<h4>Bem Vindo !</h4>"));
        if($_SESSION["acessoAdmin"] == false){
	        if($_SESSION["tipoCliente"] == "L"){
	            $nomeTipo = "LOCATÁRIO - ".$_SESSION["nomeLocador"];
	        }else{
	            $nomeTipo = "PROPRIETÁRIO - ".$_SESSION["nomeLocador"];
	        }
	        $div->addItem(new ARTextHml("<h5>{$nomeTipo} </h5>"));
	        $div->addItem(new ARTextHml("<p>Essa é a página responsável por oferecer os serviços para sua comodidade. Para iniciar escolha um dos itens acima.</p>"));
        }else{
        	$nomeTipo = "Administrador - ".$_SESSION["nomeAdmin"];
        	$div->addItem(new ARTextHml("<h5>{$nomeTipo} </h5>"));
        	$div->addItem(new ARTextHml("<p>Essa é a página responsável pela adminstração dos serviços SGA.</p>"));
        }
        
        return $div;
    }
    
    public function gerarPaginaBoletos(){
        $fieldSet = new ARFieldSet();
        $fieldSet->legend = "Boleto";
        
        $form = new ARForm();
        $form->name = "form_boleto";
        $form->action = "index.php?modulos=cliente&acao=gerarBoleto&page=boleto";
        $form->method = TipoMethodForm::POST;
        $form->onsubmit("
                          if ($('#dsCpfCnpj').val() == ''){
                              alert('Favor informar o campo Cpf/Cnpj');
                              $('#dsCpfCnpj').focus();
                              return false;
                          }
                          if ($('#dsMesBase').val() == ''){
                              alert('Favor informar o campo Mês Base');
                              $('#dsMesBase').focus();
                              return false;
                          }
						  var d = new Date();
						  var data_ultimo_diames = (new Date(d.getFullYear(), d.getMonth()+1, 0));
						  var parts = '01/'+$('#dsMesBase').val();
						  parts = parts.split('/');
						  var data_mesbase = (new Date(parts[2],parts[1]-1,parts[0])); 
                          if (data_mesbase > data_ultimo_diames){
                              alert('Mês Base deve ser menor ou igual ao mês atual');
                              $('#dsMesBase').focus();
                              return false;
                          }
                          var cpfcnpj = $('#dsCpfCnpj').val();
                          var dtenvio = $('#dsMesBase').val();
                          return gerarModalPDF('index.php?modulos=cliente&acao=gerarBoleto&ajax=true&cpfcnpj='+cpfcnpj+'&dtenvio='+dtenvio);
                        ");
        
        $text = new ARTextBox();
        $text->name = "dsCpfCnpj";
        $text->default = $_SESSION["cpfcnpj"];
        $dsCpfCnpj = str_replace(".", "", $_SESSION["cpfcnpj"]);
        $dsCpfCnpj = str_replace("/", "", $dsCpfCnpj);
        $dsCpfCnpj = str_replace("-", "", $dsCpfCnpj);
        if($_SESSION["tipoCliente"] == "L"){
            $text->disable = true;
        }
        $text->bootStrap = true;
        $text->label = "Cpf/Cnpj";
        $text->typeARTextBoxMask = TipoARTextBoxMask::CPF_CNPJ;
        
        $form->addItem($text);
        //Mes base
        $text = new ARTextBox();
        $text->name = "dsMesBase";
        $text->bootStrap = true;
        $text->label = "Mês Base";
        $text->typeARTextBox = TipoARTextBox::TEXT;
        $text->typeARTextBoxMask = TipoARTextBoxMask::CUSTOM;
        $text->setMask("99/9999");
        
        
        
        $form->addItem($text);
        $div = new ARDiv();
        $div->style = "margin-left: 180px;";
        $butao = new ARButton();
        $butao->onclick("$('#form_boleto').submit();");
        $butao->class = TipoClassButton::AZUL_ESCURO;
        $butao->label = "Gerar Boleto";
        $div->addItem($butao);
        
        $form->addItem($div);
        
        $fieldSet->addItem($form);
        
         return $fieldSet;
        
    }
    
    public function gerarPaginaExtratos(){
        $fieldSet = new ARFieldSet();
        $fieldSet->legend = "Extrato Mensal";
        
        $form = new ARForm();
        $form->name = "form_boleto";
        $form->action = "index.php?modulos=cliente&acao=gerarExtrato&page=extrato";
        $form->method = TipoMethodForm::POST;
        $form->onsubmit("                          
                          if ($('#dsMesBase').val() == ''){
                              alert('Favor informar o campo Mês Base');
                              $('#dsMesBase').focus();
                              return false;
                          }
                          var cpfcnpj = $('#dsCpfCnpj').val();
                          var dtenvio = $('#dsMesBase').val();                          
                          return gerarModalPDF('index.php?modulos=cliente&acao=gerarExtrato&designer=false&cpfcnpj='+cpfcnpj+'&dtenvio='+dtenvio);
                        ");
        //Mes base
        $text = new ARTextBox();
        $text->name = "dsMesBase";
        $text->bootStrap = true;
        $text->label = "Mês Base";
        $text->typeARTextBox = TipoARTextBox::TEXT;
        $text->typeARTextBoxMask = TipoARTextBoxMask::CUSTOM;
        $text->setMask("99/9999");
        
        $form->addItem($text);
        $div = new ARDiv();
        $div->style = "margin-left: 180px;";
        $butao = new ARButton();
        $butao->onclick("$('#form_boleto').submit();");
        $butao->class = TipoClassButton::AZUL_ESCURO;
        $butao->label = "Gerar Extrato";
        $div->addItem($butao);
        
        $form->addItem($div);
        
        $fieldSet->addItem($form);
        
         return $fieldSet;
        
    }
    
    public function gerarPaginaDemonstrativo(){
        $fieldSet = new ARFieldSet();
        $fieldSet->legend = "Demonstrativo Anual";
        
        $form = new ARForm();
        $form->name = "form_boleto";
        $form->action = "index.php?modulos=cliente&acao=gerarDemonstrativo&page=demonstrativo";
        $form->method = TipoMethodForm::POST;
        $form->onsubmit("
                          if ($('#dsAnoBase').val() == ''){
                              alert('Favor informar o campo Ano Base');
                              $('#dsAnoBase').focus();
                              return false;
                          }
                          var cpfcnpj = $('#dsCpfCnpj').val();
                          var dtenvio = $('#dsAnoBase').val();
                          return gerarModalPDF('index.php?modulos=cliente&acao=gerarDemonstrativo&ajax=true&cpfcnpj='+cpfcnpj+'&dtenvio='+dtenvio);
                        ");
        //Mes base
        $text = new ARTextBox();
        $text->name = "dsAnoBase";
        $text->bootStrap = true;
        $text->label = "Ano Base";
        $text->typeARTextBox = TipoARTextBox::TEXT;
        $text->typeARTextBoxMask = TipoARTextBoxMask::CUSTOM;
        $text->setMask("9999");
        
        $form->addItem($text);
        $div = new ARDiv();
        $div->style = "margin-left: 180px;";
        $butao = new ARButton();
        $butao->onclick("$('#form_boleto').submit();");
        $butao->class = TipoClassButton::AZUL_ESCURO;
        $butao->label = "Gerar Demonstrativo Anual";
        $div->addItem($butao);
        
        $form->addItem($div);
        
        $fieldSet->addItem($form);
        
        return $fieldSet;
        
    }
    
    public function gerarPaginaClientes(){
        $fieldSet = new ARFieldSet();
        $fieldSet->legend = "Gerenciamento de Clientes ";
        
        $div = new ARDiv();
        $div->class  = "alert alert-block";
        $div->addItem(new ARTextHml("<h4>Em construção/ Análise com Jean</h4>"));
        $fieldSet->addItem($div);

        return $fieldSet;
        
    }
    
    public function gerarPaginaServico(){
        $fieldSet = new ARFieldSet();
        $fieldSet->legend = "Gerenciamento de Serviço";
        $div = new ARDiv();
        $div->class  = "alert alert-block";
        $div->addItem(new ARTextHml("<h4>Em construção/ Análise com Jean</h4>"));
        $fieldSet->addItem($div);
        
        return $fieldSet;
        
    }
    
    public function gerarPaginaServicoCliente(){
        $fieldSet = new ARFieldSet();
        $fieldSet->legend = "Gerenciamento de Serviço/Cliente";
        $div = new ARDiv();
        $div->class  = "alert alert-block";
        $div->addItem(new ARTextHml("<h4>Em construção/ Análise com Jean</h4>"));
        $fieldSet->addItem($div);
        
        return $fieldSet;
        
    }
}
?>