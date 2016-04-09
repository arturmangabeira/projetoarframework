<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formater
 *
 * @author artur
 */
class formater {
    //put your code here
}

class FormaterUsuario implements IFormat {
    
    public function __construct() {
        ;
    }
    
    public function generateFormat($field, $arrayField) {
        $link = new ARLink();
        $link->text = $field;
        $link->href = "index.php?modules=usuario&acao=editar&designer=false&valueid={$arrayField->getSqUsuario()}";
        $link->modal = true;
        $link->bootStrap = false;
        
        return $link;
    }    //put your code here
}

class FormaterClienteImagem implements IFormat {

	public function __construct() {
		;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see IFormat::generateFormat()
	 */
	public function generateFormat($field, $arrayField) {
		$imagem = new ARImage();		
		$imagem->src = "{$arrayField->getDesc_Caminho_LogoMarca()}";
		$imagem->width = "100";
		$imagem->heigth = "100";

		return $imagem;
	}    //put your code here
}

class FormaterClienteLink implements IFormat {

	public function __construct() {
		;
	}

	/**
	 *
	 * {@inheritDoc}
	 * @see IFormat::generateFormat()
	 */
	public function generateFormat($field, $arrayField) {
		$imagem = new ARLink();
		$imagem->href = "index.php?modules=configuracaoclientemnt&acao=editarDescricao&designer=false&valueid={$arrayField->getId_Cliente()}";
		$imagem->modal = true;
		$imagem->modalWidth = "50";
		$imagem->modalHeigth = "100";
		$imagem->text = $arrayField->getDesc_Descricao_Servico();

		return $imagem;
	}
	
	//put your code here
}






?>
