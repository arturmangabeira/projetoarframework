<?php
error_reporting ( E_ERROR );
/**
 * Description of servico
 *
 * @author artur
 *        
 */
class AdminUI {
	// put your code here
	public function __construct() {
		;
	}
	public function gerarLoginAdmin() {
		$divPai = new ARDiv ();
		$divPai->class = "thumbnail center well well-small text-center";
		// $divPai->addItem(new ARTextHml("<h2>Nome da Empresa </h2>"));
		
		$divPai->addItem ( new ARTextHml ( "<p>" ) );
		
		$imagem = new ARImage ();
		$imagem->bootStrap = false;		
		$imagem->src =  ARFrameWork::obterTemaAtual()."dist/img/admin.png";
		$imagem->width = 100;
		$imagem->heigth = 100;
		
		$divPai->addItem(new ARTextHml("</p>"));
        
		$divPai->addItem($imagem);
		
		$divPai->addItem ( new ARTextHml ( "<p></p>" ) );
		// $divPai->addItem(new ARTextHml("<p>Empresa {$clienteDtoRetorno->getDesc_Nome_Empresa()}</p>"));
		$divPai->addItem ( new ARTextHml ( "<p>Área do Administrador do sistema.</p>" ) );
		$divPai->addItem ( new ARTextHml ( "<b><p>Preencha os campos </p></b>" ) );
		
		$form = new ARForm ();
		$form->id = "frm_login";
		$form->name = "frm_login";
		// $form->action = "index.php?modulos=login&acao=logar";
		$form->method = TipoMethodForm::POST;
		if ($tipoAcesso == "S") {
			$form->style = "margin-left: -100px;";
		}
		
		$div = new ARDiv ();
		$div->class = "input-prepend";
		if ($tipoAcesso == "C") {
			// $div->style = "margin-rigth: 200px;";
			$div->addItem ( new ARTextHml ( "<span class=\"add-on\"><i class=\"icon-user\"></i></span>" ) );
		}
		
		$textBox = new ARTextBox ();
		$textBox->id = "login";
		$textBox->name = "login";
		$textBox->placeholder = "Informe o Login";	
		$textBox->bootStrap = true;
		$textBox->label = "Login";		
		$textBox->require = true;
		
		
		$div->addItem ( $textBox );
			
		$textBox = new ARTextBox ();
		$textBox->id = "senha";
		$textBox->name = "senha";
		$textBox->label = "Senha";
		$textBox->placeholder = "Informe a senha de acesso";
		$textBox->typeARTextBox = TipoARTextBox::PASSWORD;
		$textBox->maxLength = 20;
		$textBox->bootStrap = true;
		$textBox->require = true;
		$div->addItem ( $textBox );
			
		$form->addItem ( $div );		
		
		$div = new ARDiv ();
		$div->class = "input-prepend";
		// Caso o serviço exiba somente a inforação do captcha
		if ($tipoAcesso == "C") {
			
			$textBox = new ARTextBox ();
			$textBox->id = "dsCpt";
			$textBox->name = "dsCpt";
			$textBox->placeholder = "";
			$textBox->bootStrap = false;
			$textBox->style = "width:100px;";
			$textBox->maxLength = 6;
			$div->addItem ( $textBox );
			$div->addItem ( new ARTextHml ( " <span>te</span> " ) );
			// Imagem capatcha
			$img = new ARImage ();
			$img->src = "index.php?modulos=login&acao=gerarCpt&ajax=true";
			$div->addItem ( $img );
		}
		
		$form->addItem ( $div );
		
		$form->addItem ( new ARTextHml ( " <p></p> " ) );
		
		$div2Botton = new ARDiv ();
		$div2Botton->class = "form-group";
		
		$div2Botton->addItem ( new ARTextHml ( "<label class=\"col-md-4 control-label\" for=\"btnLogar\"></label>" ) );
		
		// $div2Botton->addItem("<label class=\"col-md-4 control-label\" for=\"btnLogar\"></label>");
		
		$divBottons = new ARDiv ();
		//$divBottons->class = "col-md-4 center-block";
		$divBottons->class = "form-actions";
		
		$button = new ARButton ();
		$button->id = "btnLogar";
		$button->label = "Entrar";
		$button->class = TipoClassButton::PADRAO." center-block";
		$button->sizeButton = TipoSizeButton::GRANDE;
		$button->causesValidation = true;
		$button->setAction = new ARAction( "admin", "logar" );
		
		$divBottons->addItem ( $button );
		
		$ranStr = md5 ( microtime () );
		$ranStr = substr ( $ranStr, 0, 6 );
		$this->cpt = $ranStr;
		$_SESSION ['cap_code'] = $ranStr;
		
		// $form->addItem($button);	
				
		//$div2Botton->addItem ( $divBottons );
		$form->addItem ( $divBottons );
		///$form->addItem ( $div2Botton );
		
		$divPai->addItem ( $form );
		//$divPai->addItem ( new ARTextHml ( "<p>Em caso de dúvidas quanto aos dados fornecidos acima, entre em contato com a imobiliaria através do telefone (71)3018-0777.</p>" ) );
		
		if (! empty ( $_REQUEST ['mensagem'] )) {
			$div = new ARDiv ();
			$div->class = "alert alert-block";
			$div->addItem ( new ARTextHml ( base64_decode ( $_REQUEST ['mensagem'] ) ) );
			$divPai->addItem ( $div );
		}
		
		return $divPai;
	}
}