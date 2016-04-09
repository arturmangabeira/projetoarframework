<?php
error_reporting(E_ERROR);
/**
 * Description of servico
*
* @author artur
*/
class LoginUI {
	//put your code here
	public function __construct() {
		;
	}	
	
	public function gerarLoginHtml(){
        $divPai = new ARDiv();
        $divPai->class = "thumbnail center well well-small text-center";
        //$divPai->addItem(new ARTextHml("<h2>Nome da Empresa </h2>"));
                
        $divPai->addItem(new ARTextHml("<p>"));
        $imagem = new ARImage();
        $imagem->bootStrap = false;
        
        $clienteDtoRetorno = new ClienteDTO();
        if (!empty($_REQUEST['cod_cliente'])) {
            $clienteDto = new ClienteDTO();           
            $clienteDto->setCod_Cliente($_REQUEST['cod_cliente']);
            $retornoDto = $clienteDto->obterPorFiltroDTO(false);
            if($retornoDto->count() >0 ){
                $clienteDtoRetorno = $retornoDto->getIterator()->current();
                $_SESSION["codCliente"] = $_REQUEST['cod_cliente'];    
                $_SESSION["id_cliente"] = $clienteDtoRetorno->getId_Cliente();
                $tipoAcesso = $clienteDtoRetorno->getTipo_Acesso();
                $_SESSION["tipo_acesso"] = $tipoAcesso;
                $imagem->src =  $clienteDtoRetorno->getDesc_Caminho_LogoMarca();
                //$imagem->width = "150px";
            }else{
                $imagem->src =  "bibliotecas/images/semlogo.jpg"; 
                $imagem->width = "100px";
            }

        }else{ 
            $imagem->src =  "bibliotecas/images/semlogo.jpg"; 
            $imagem->width = "100px";
        }
            $divPai->addItem(new ARTextHml("</p>"));
            $divPai->addItem($imagem);
        if($clienteDtoRetorno->getCod_Cliente() != null){
            
            $divPai->addItem(new ARTextHml("<p></p>"));
            //$divPai->addItem(new ARTextHml("<p>Empresa {$clienteDtoRetorno->getDesc_Nome_Empresa()}</p>"));
            $divPai->addItem(new ARTextHml("<p>{$clienteDtoRetorno->getDesc_Descricao_Servico()} </p>"));
            $divPai->addItem(new ARTextHml("<b><p>Preencha os campos </p></b>"));

            $form = new ARForm();
            $form->id = "frm_login";
            $form->name = "frm_login";
            //$form->action = "index.php?modules=login&acao=logar";
            $form->method = TipoMethodForm::POST;
            if($tipoAcesso == "S"){
            	$form->style = "margin-left: -100px;";
            }
            		
            $div = new ARDiv();
            $div->class = "input-prepend";
            if($tipoAcesso == "C"){
             //$div->style = "margin-rigth: 200px;";
             $div->addItem(new ARTextHml("<span class=\"add-on\"><i class=\"icon-user\"></i></span>"));
            }
            
            $textBox = new ARTextBox();
            $textBox->id = "dsCpfCnpj";
            $textBox->name = "dsCpfCnpj";
            $textBox->placeholder = "Informe seu CPF ou CNPJ";            
            $textBox->typeARTextBoxMask = TipoARTextBoxMask::CPF_CNPJ;
            if($tipoAcesso == "C"){
            	$textBox->bootStrap = false;
            	$textBox->label = "";
            }else{
            	$textBox->bootStrap = true;
            	$textBox->label = "CPF/CNPJ";
            }
            $textBox->require = true;
            
            $div->addItem($textBox);
                        
            if($tipoAcesso == "S"){
            	$textBox = new ARTextBox();
            	$textBox->id = "dsSenhaUsuario";
            	$textBox->name = "dsSenhaUsuario";
            	$textBox->label = "Senha";
            	$textBox->placeholder = "Informe a senha de acesso";
            	$textBox->typeARTextBox = TipoARTextBox::PASSWORD;
            	$textBox->maxLength = 20;
            	$textBox->bootStrap = true;
            	$textBox->require = true;
            	$div->addItem($textBox);
            }                 
            			
			$form->addItem($div);
			
			if($tipoAcesso == "C"){
				$form->addItem(new ARTextHml(" <p>Selecione o campo abaixo para validar o captcha!</p> "));
			}
            
            $div = new ARDiv();
            $div->class = "input-prepend";
            //Caso o serviço exiba somente a inforação do captcha
            if($tipoAcesso == "C"){            
            	/*
	            $textBox = new ARTextBox();
	            $textBox->id = "dsCpt";
	            $textBox->name = "dsCpt";
	            $textBox->placeholder = "";
	            $textBox->bootStrap = false;
	            $textBox->style = "width:100px;";
	            $textBox->maxLength = 6;
	            $div->addItem($textBox);
	            $div->addItem(new ARTextHml(" <span>te</span> "));
	            //Imagem capatcha
	            $img = new ARImage();
	            $img->src = "index.php?modules=login&acao=gerarCpt&ajax=true";
	            $div->addItem($img);
	            */
            	$divCaptcha = new ARDiv();
            	$divCaptcha->class = "g-recaptcha";
            	$divCaptcha->setPropriedades("data-sitekey", "6LeqxBwTAAAAAK_Ck5jG4A6_mbxGAWLR271FZvMJ");
            	
            	$div->addItem($divCaptcha);
            	
            }
            
            $form->addItem($div);
            
            $form->addItem(new ARTextHml(" <p></p> "));
            
            if($tipoAcesso == "S"){
            
	            $div2Botton = new ARDiv();
	            $div2Botton->class = "form-group";
	            
	            $div2Botton->addItem(new ARTextHml("<label class=\"col-md-4 control-label\" for=\"btnLogar\"></label>"));
	            
	            //$div2Botton->addItem("<label class=\"col-md-4 control-label\" for=\"btnLogar\"></label>");
	            
	            $divBottons = new ARDiv();
	            $divBottons->class = "col-md-8";
            }
            
            $button = new ARButton();
            $button->id = "btnLogar";
            $button->label = "Entrar";
            $button->class = TipoClassButton::VERDE;
            $button->sizeButton = TipoSizeButton::GRANDE;                                    
            $button->setAction = new ARAction("login","logar");
            
            //no caso do captcha deve ser validado de forma manual
            if($tipoAcesso == "C"){
            	$button->setActionScriptCustom = "
            				var element = $('#dsCpfCnpj');
            				if(element.val() == element.attr('placeholder') || $.trim(element.val()) == '' ){
								bootbox.alert(\"Favor validar o campo CPF/CNPJ. \");
            					return false;            		
            				}
            				if (grecaptcha.getResponse() == '') {
            					bootbox.alert(\"Favor validar o campo não sou um robô. \");
            					return false;
            				}";
            	$form->addItem($button);
            }else{
            	$button->causesValidation = true;
            	$divBottons->addItem($button);
            }
            
            /*
            $ranStr = md5(microtime());
            $ranStr = substr($ranStr, 0, 6);
            $this->cpt = $ranStr;
            $_SESSION['cap_code'] = $ranStr;
            */
            //$form->addItem($button);
            
            if($tipoAcesso == "S"){
	            $button = new ARButton();
	            $button->label = "Mudar minha senha";
	            $button->class = TipoClassButton::LARANJA;
	            //$button->class = "btn btn-primary btn-lg ";
	            $button->sizeButton = TipoSizeButton::GRANDE;
	            $button->causesValidation = false;
	            $button->setAction = new ARAction("login","novaSenha");
				
	            $divBottons->addItem($button);
	            
	            $div2Botton->addItem($divBottons);
	            
	            $form->addItem($div2Botton);
            }
            
            
            
            $divPai->addItem($form);
            $divPai->addItem(new ARTextHml("<p>Em caso de dúvidas quanto aos dados fornecidos acima, entre em contato com a imobiliaria através do telefone (71)3018-0777.</p>"));

            if(!empty($_REQUEST['mensagem'])){
            $div = new ARDiv();
            $div->class = "alert alert-block"; 
            $div->addItem(new ARTextHml(base64_decode($_REQUEST['mensagem'])));
            $divPai->addItem($div); 
            }
        }else{
            $divPai->addItem(new ARTextHml("<p></p>"));
            $div = new ARDiv();
            $div->class = "alert alert-block"; 
            $div->addItem(new ARTextHml("<h5>Favor fornecer um código de cliente válido!</h5>"));
            $divPai->addItem($div);
        }
        return $divPai;
    }
    
    public function gerarTelaRecuperarSenha(){
    	
    	$divPai = new ARDiv();
    	$divPai->class = "thumbnail center well well-small text-center";
    	//$divPai->addItem(new ARTextHml("<h2>Nome da Empresa </h2>"));
        
    	$divPai->addItem(new ARTextHml("<p>"));
    	
    	$imagem = new ARImage();
    	$imagem->bootStrap = false;
    
    	$clienteDtoRetorno = new ClienteDTO();
    	if (!empty($_SESSION["codCliente"])) {
    		$clienteDto = new ClienteDTO();
    		$clienteDto = new ClienteDTO();
    		$clienteDto->setCod_Cliente($_SESSION["codCliente"]);
    		$retornoDto = $clienteDto->obterPorFiltroDTO();
    		if($retornoDto->count() >0 ){
    			$clienteDtoRetorno = $retornoDto->getIterator()->current();
    			//$_SESSION["codCliente"] = $_REQUEST['cod_cliente'];
    			$_SESSION["id_cliente"] = $clienteDtoRetorno->getId_Cliente();
    			$imagem->src =  $clienteDtoRetorno->getDesc_Caminho_LogoMarca();
    			//$imagem->width = "150px";
    		}else{
    			$imagem->src =  "bibliotecas/images/semlogo.jpg";
    			$imagem->width = "100px";
    		}
    
    	}else{
    		$imagem->src =  "bibliotecas/images/semlogo.jpg";
    		$imagem->width = "100px";
    	}
    	$divPai->addItem(new ARTextHml("</p>"));
    	$divPai->addItem($imagem);
    	if($clienteDtoRetorno->getCod_Cliente() != null){
    
    		$divPai->addItem(new ARTextHml("<p></p>"));
    		//$divPai->addItem(new ARTextHml("<p>Empresa {$clienteDtoRetorno->getDesc_Nome_Empresa()}</p>"));
    		$divPai->addItem(new ARTextHml("<p>{$clienteDtoRetorno->getDesc_Descricao_Servico()} </p>"));
    		$divPai->addItem(new ARTextHml("<b><p>Preencha os campos para alteração de senha</p></b>"));
    
    		$form = new ARForm();
    		$form->id = "frm_login";
    		$form->name = "frm_login";
    		//$form->action = "index.php?modules=login&acao=logar";
    		$form->method = TipoMethodForm::POST;
    		$form->style = "margin-left: -100px;";
    
    		$div = new ARDiv();
    		$div->class = "input-prepend";
    		//$div->style = "margin-rigth: 200px;";
    		//$div->addItem(new ARTextHml("<span class=\"add-on\"><i class=\"icon-user\"></i></span>"));
    		$textBox = new ARTextBox();
    		$textBox->id = "dsCpfCnpj";
    		$textBox->name = "dsCpfCnpj";
    		$textBox->placeholder = "Informe seu CPF ou CNPJ";
    		$textBox->label = "CPF/CNPJ";
    		$textBox->typeARTextBoxMask = TipoARTextBoxMask::CPF_CNPJ;
    		$textBox->bootStrap = true;
    		$textBox->require = true;
    		$div->addItem($textBox);
    
    		$textBox = new ARTextBox();
    		$textBox->id = "dsSenhaAtual";
    		$textBox->name = "dsSenhaAtual";
    		$textBox->label = "Senha Atual";
    		$textBox->placeholder = "Informe a senha atual";
    		$textBox->typeARTextBox = TipoARTextBox::PASSWORD;
    		$textBox->bootStrap = true;
    		$textBox->maxLength = 20;    		
    		$textBox->require = true;
    		//$div->addItem($textBox);
    		
    		$textBox = new ARTextBox();
    		$textBox->id = "dsSenhaNova";
    		$textBox->name = "dsSenhaNova";
    		$textBox->label = "Nova Senha";
    		$textBox->placeholder = "Informe a nova senha";
    		$textBox->typeARTextBox = TipoARTextBox::PASSWORD;
    		$textBox->bootStrap = true;
    		$textBox->maxLength = 20;    		
    		$textBox->require = true;
    		
    		$div->addItem($textBox);   
    		
    		$textBox = new ARTextBox();
    		$textBox->id = "dsSenhaNovaAux";
    		$textBox->name = "dsSenhaNovaAux";
    		$textBox->label = "Confirmar Nova Senha";
    		$textBox->placeholder = "Informe a nova senha novamente";
    		$textBox->typeARTextBox = TipoARTextBox::PASSWORD;
    		$textBox->bootStrap = true;
    		$textBox->maxLength = 20;
    		$textBox->require = true;
    		
    		$div->addItem($textBox);
    
    		$form->addItem($div);
    
    		$div = new ARDiv();
    		$div->class = "input-prepend";
    		
    		$textBox = new ARTextBox();
    		$textBox->id = "dsCpt";
    		$textBox->name = "dsCpt";
    		$textBox->placeholder = "";
    		$textBox->bootStrap = false;
    		$textBox->style = "width:100px;";
    		$textBox->maxLength = 6;
    		
    		$div2Botton = new ARDiv();
            $div2Botton->class = "form-group";
            
            $div2Botton->addItem(new ARTextHml("<label class=\"col-md-4 control-label\" for=\"btnLogar\"></label>"));
            
            //$div2Botton->addItem("<label class=\"col-md-4 control-label\" for=\"btnLogar\"></label>");
            
            $divBottons = new ARDiv();
            $divBottons->class = "col-md-8";
    		
    		$button = new ARButton();
    		$button->label = "Alterar Senha";
    		$button->class = TipoClassButton::PADRAO;
    		$button->sizeButton = TipoSizeButton::GRANDE;
    		$button->causesValidation = true;
    		$scriptValidarSenha = "
    					if($.trim($('#dsSenhaNova').val()) != $.trim($('#dsSenhaNovaAux').val())){
    						bootbox.alert(\"As senhas não conferem. Por favor revise! \");
    						return false;
    					}
    				";
    		$button->causesValidationScriptCuston = $scriptValidarSenha;
    		$button->setAction = new ARAction("loginalterar","alterarSenha");
    
    		$ranStr = md5(microtime());
    		$ranStr = substr($ranStr, 0, 6);
    		$this->cpt = $ranStr;
    		$_SESSION['cap_code'] = $ranStr;
    
    		$divBottons->addItem($button);
    
    		$button = new ARButton();
    		$button->label = "Cancelar";
    		$button->class = TipoClassButton::VERMELHO;
    		$button->sizeButton = TipoSizeButton::GRANDE;
    		$button->causesValidation = false;
    		$button->setAction = new ARAction("loginalterar","cancelar");
    
    		$divBottons->addItem($button);
    		
    		$div2Botton->addItem($divBottons);
    		
    		$form->addItem($div2Botton);
    
    		$divPai->addItem($form);    		
    
    		if(!empty($_REQUEST['mensagem'])){
    			$div = new ARDiv();
    			$div->class = "alert alert-block";
    			$div->addItem(new ARTextHml(base64_decode($_REQUEST['mensagem'])));
    			$divPai->addItem($div);
    		}
    	}else{
    		$divPai->addItem(new ARTextHml("<p></p>"));
    		$div = new ARDiv();
    		$div->class = "alert alert-block";
    		$div->addItem(new ARTextHml("<h5>Favor fornecer um código de cliente válido!</h5>"));
    		$divPai->addItem($div);
    	}
    	return $divPai;
    }
    
    public function gerarCaptcha(){
        $newImage = imagecreatefromjpeg("bibliotecas/images/cap_bg.jpg");
        $txtColor = imagecolorallocate($newImage, 0, 0, 0);
        imagestring($newImage, 5, 5, 5, $_SESSION['cap_code'], $txtColor);
        header("Content-type: image/jpeg");
        imagejpeg($newImage);
    }
}