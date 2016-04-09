<?php

class ARMessageType{
	const AVISO = "aviso";
	const ERRO = "erro";
	const SUCESSO = "sucesso"; 
}

class ARMessage {
	function __construct(){
		
	}

	/**
	 * 
	 * @param string $message
	 * @param ARMessageType $messageType
	 */
	static function showMessage($message,$messageType = ARMessageType::SUCESSO,$callBackFunctionJavaScript="",$redirecionar="",$timeout="3000"){
		if(!empty($message)){
			$class = "";
			if($messageType == ARMessageType::AVISO){
				$class = "icon-info-sign";
                                $imagem = "ARFramework/lib/images/info.png";
                                $texto = "Aviso";
			}
			if($messageType == ARMessageType::ERRO){
				$class = "icon-ban-circle";
                                $imagem = "";
			}
			if($messageType == ARMessageType::SUCESSO){
				$class = "icon-ok";
                                $imagem = "";
			}
			
                        $mensagem = "<i class=\"{$class}\"></i><p class=\"text-center\">{$message}</p>";                        
                        
			$script = "<script type=\"text/javascript\">";
                        
                        $script .= "bootbox.dialog({
                                    title: \"{$texto}\",
                                    message: '<img src=\"{$imagem}\" width=\"100px\"/>{$mensagem}',
                                     buttons: {
                                            success: {
                                              label: \"Ok!\",
                                              className: \"btn-success\",
                                              callback: function() {
                                                {$callBackFunctionJavaScript}
                                              }
                                            }
                                        }
                                  });"; 
			
			//$script .= "bootbox.alert(\"<i class='{$class}'></i><p class='text-center'>{$message}</p>\", function() { {$callBackFunctionJavaScript}});";
			
			if(!empty($redirecionar)){
			
				$script .= "setTimeout(function(){
							location.href = '{$redirecionar}';
       					}, {$timeout});";
			}
			
			$script .= "</script>";
			
			echo $script;
		}
	}
	
}