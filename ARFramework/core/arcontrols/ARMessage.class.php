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
			}
			if($messageType == ARMessageType::ERRO){
				$class = "icon-ban-circle";
			}
			if($messageType == ARMessageType::SUCESSO){
				$class = "icon-ok";
			}
			
			$script = "<script type=\"text/javascript\">";
			
			$script .= "bootbox.alert(\"<i class='{$class}'></i><p class='text-center'>{$message}</p>\", function() { {$callBackFunctionJavaScript} });	";
			
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