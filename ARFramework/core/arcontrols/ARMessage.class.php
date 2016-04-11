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
				$class = "btn-primary";
                                $imagem = "ARFramework/lib/images/info.png";
                                $texto = "Aviso";
			}
			if($messageType == ARMessageType::ERRO){
				$class = "btn-danger";
                                $imagem = "ARFramework/lib/images/error.png";
                                $texto = "Erro";
			}
			if($messageType == ARMessageType::SUCESSO){
				$class = "btn-success";
                                $imagem = "ARFramework/lib/images/success.png";
                                $texto = "Sucesso";
			}
			                                                
			$script = "<script type=\"text/javascript\">";
                        
                        $script .= "bootbox.dialog({
                                    title: \"{$texto}\",
                                    message: '<img src=\"{$imagem}\" width=\"80px\" height=\"80px\"/>&nbsp;{$message}',
                                     buttons: {
                                            success: {
                                              label: \"Ok!\",
                                              className: \"{$class}\",
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