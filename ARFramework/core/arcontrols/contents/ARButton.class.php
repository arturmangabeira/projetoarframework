<?php
/**
 * Description of ARCheckBox
 *
 * @author artur mangabeira
 */
class TipoClassButton {
    const AZUL_ESCURO = "btn-primary";
    const AZUL  = "btn-info";
    const VERDE  = "btn-success";
    const LARANJA  = "btn-warning";
    const VERMELHO  = "btn-danger";
    const PRETO  = "btn-inverse";    
    const DIREITA = "btn pull-right";
    const PADRAO = "";
}

class TipoSizeButton {
	const GRANDE = "btn btn-large";
	const PADRAO  = "btn btn-default";
	const PEQUENO  = "btn btn-small";
	const MINI  = "btn btn-mini";	
}

class ActionButton{
	private $classe;
	private $metodo;
	
	function __construct($classe, $metodo){
		$this->setClasse($classe);
		$this->setMetodo($metodo);
	}
		
	public function getClasse() {
		return $this->classe;
	}
	
	public function setClasse($value) {
		$this->classe = $value;
	}
	
	public function getMetodo() {
		return $this->metodo;
	}
	
	public function setMetodo($value) {
		$this->metodo = $value;
	}
}

class ARButton extends objetoHTML {
    //put your code here
    
    var $name;
    var $id;
    var $style;
    var $bootstrap;
    /**
     * Variavel do tipo TipoClassButton.
     * @var TipoClassButton 
     */
    var $class;
    var $label;
    var $causesValidation;
    var $causesValidationScriptCuston;
    var $setActionScriptCustom;
    
    /**
     * Variavel do tipo ARAction		
     * @var ActionButton
     */
    var $setAction;
    
    /**
     * 
     * @var TipoSizeButton
     */
    var $sizeButton;
    
    public function __construct() {
        parent::__construct();
    }
    
    protected function inicializarCampos(){
        if(empty($this->name)){
            $this->name = "ARButton_".rand(100, 4000);
        }
        
        if(empty($this->id)){            
            $this->id   = $this->name;
        }
        
        if(empty($this->style)){            
           $this->style = ""; 
        }
         
        if(empty($this->class)){            
           $this->class = TipoClassButton::PADRAO; 
        }
        
        if(empty($this->label)){            
           $this->class = "Botão"; 
        }
        
        if(empty($this->bootstrap)){
        	$this->bootstrap = true;
        }
        
        if(empty($this->causesValidation)){
        	$this->causesValidation = false;
        }
        
        if(empty($this->sizeButton)){
        	$this->sizeButton = TipoSizeButton::PADRAO;
        }
    }
    
    public function bind(){
       $this->inicializarCampos();
              
       return $this->gerarBotao();
    }
    
    private function gerarBotao(){
        $button = " <button type=\"button\" class=\"$this->sizeButton {$this->class}\" style=\"{$this->style}\" name=\"{$this->name}\" id=\"{$this->id}\"";
       
       //Adiciona os eventos a serem disparados através de reflection.
        $class = new ReflectionClass(get_class($this));

        //$properties = $class->getProperties(ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC);
        
        $properties = $class->getParentClass()->getParentClass()->getProperties(ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC);

        if (!is_null($properties)) {

            foreach ($properties as $prop) {
                $propName = $prop->getName();
                
                $method = new ReflectionMethod(get_class($this), 'get'.$propName);
                //$method->setAccessible(true);
                $valor = $method->invoke($this);

                if(!empty($valor)){
                    $button .= " $propName=\"$valor\" ";
                }
                
            }
        }
       $button .= ">  ";
       
       $button .= " {$this->label} </button> ";
       
       $urlActionMetodoButton = "";
       if($this->setAction != null){
       		$action = $this->setAction;
       		//$urlActionMetodoButton = "index.php?modulos=".$action->getClasse()."&metodo=".$action->getMetodo()."&ajax=true";
       		$urlActionMetodoButton = $action->obterURLMetodo();
       }
                     
       
       if($this->causesValidation){
       	$script = "
       			<script type=\"text/javascript\">
       				// pre-submit callback 
					function showRequest_{$this->id}(formData, jqForm, options) { 
					    exibirImagemAviso('');
					    return true; 
					} 
					 
					// post-submit callback 
					function showResponse_{$this->id}(responseText, statusText, xhr, form)  { 
					    setTimeout(function(){
							$.fancybox.close();
       					}, 300);
					} 
					
	       			$(document).ready(function() 
					{
						$(\"#{$this->id}\").click(function(){
						   var retorno = true; 	
						   $('input[required=\"true\"], select[required=\"true\"], textarea[required=\"true\"]').each(
						      function(index){  
						          var element = $(this);
						          //caso o elemto escolhido seja do tipo 'input'
						          if (element.is('input')){
							          if(element.val() == element.attr('placeholder') || $.trim(element.val()) == '' ){
							          	if($('label[for=\"'+element.attr('name')+'\"]').html() != undefined){
							           		bootbox.alert(\"<i class='icon-info-sign'></i><p class='text-center'>Favor preencher o campo \" + $('label[for=\"'+element.attr('name')+'\"]').html().replace(/\:/g,'')+\"</p>\", function() {
											  element.focus();
											});							           		
							           	}else{
							           		bootbox.alert(\"Favor preencher o campo em destaque \");
							           	}
							           	element.focus();
							           	retorno = false;
							           	return false;
							          }
						          }else{
						          	 if (element.is('select')){
						          	 	if(element.val() == '0' || element.val() == ''){
						          	 		if($('label[for=\"'+element.attr('name')+'\"]') != undefined){
							           			bootbox.alert(\"Favor preencher o campo \" + $('label[for=\"'+element.attr('name')+'\"]').html().replace(/\:/g,''));
								           	}else{
								           		bootbox.alert(\"Favor preencher o campo em destaque \");
								           	}           
							           		element.focus();
							           		retorno = false;
							           		return false;
						          	 	}
						          	 }else{
						          	 	//caso tenha sido passado uma referencia do tinyMCE
						          	    if(typeof(tinyMCE) != \"undefined\"){
						          	 		//alert(tinyMCE.get($(this).attr('id')).getContent());
						          	 		if($.trim(tinyMCE.get($(this).attr('id')).getContent()) == ''){
							          	 		if($('label[for=\"'+element.attr('name')+'\"]') != undefined){
								          	 		bootbox.alert(\"<i class='icon-info-sign'></i><p class='text-center'>Favor preencher o campo \" + $('label[for=\"'+element.attr('name')+'\"]').html().replace(/\:/g,'')+\"</p>\", function() {
													  element.focus();
													});
												}else{
													bootbox.alert(\"Favor preencher o campo em destaque \");
												}
												element.focus();
								           		retorno = false;
								           		return false;
						          	 		}
						          	 	}else{
						          	 		//obtém o texto do texarea para verificar se foi passado o valor
						          	 		if($.trim(element.val()) == ''){
							          	 		if($('label[for=\"'+element.attr('name')+'\"]') != undefined){
								          	 		bootbox.alert(\"<i class='icon-info-sign'></i><p class='text-center'>Favor preencher o campo \" + $('label[for=\"'+element.attr('name')+'\"]').html().replace(/\:/g,'')+\"</p>\", function() {
													  element.focus();
													});
												}else{
													bootbox.alert(\"Favor preencher o campo em destaque \");
												}
												element.focus();
								           		retorno = false;
								           		return false;
						          	 		}
						          	 	}						          	 	
       								 }
						          }
						   });";
       	if(!empty($this->causesValidationScriptCuston)){
       		$script .= $this->causesValidationScriptCuston;
       	}
       	if($this->setAction != null){
	       	$script .= "
	       					   if(retorno == true){ 	
								   //capturando o form
								   var form = $(this).parents('form:first');
								   if(form != undefined){
									   form.attr('action','{$urlActionMetodoButton}');
									   //força o método para post. 
									   form.attr('method','post');
									   //form.submit();
									   //exibirImagemAviso('');
									   var options = { 
										        target:        '#divconteudo',   // target element(s) to be updated with server response 
										        beforeSubmit:  showRequest_{$this->id},  // pre-submit callback 
										        success:       showResponse_{$this->id}  // post-submit callback 
										 
										        // other available options: 
										        //url:       url         // override for form's 'action' attribute 
										        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
										        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
										        //clearForm: true        // clear all form fields after successful submit 
										        //resetForm: true        // reset the form after successful submit 
										 
										        // $.ajax options can be used here too, for example: 
										        //timeout:   3000 
										    };
									form.ajaxForm(options).submit();	    
									   /*form.ajaxForm({
								       		success:
								       		function(responseText, statusText, xhr, form){
								       			dados = responseText;
								       			setTimeout(function(){
								       			$.fancybox.close();alert('teste');}, 1000);
					       						$('body').append(dados);
								       		}
								       }).submit();*/
									   return false;
								   }else{
								   		location.href = '{$urlActionMetodoButton}';
								   }
							   }";	       	
       	}
						   
		$script .= "  });
					});
				</script>	
					";
       }else{
       	if($this->setAction != null){
	       	$script = "
	       	<script type=\"text/javascript\">
	       	// pre-submit callback 
			function showRequest_{$this->id}(formData, jqForm, options) { 
			    exibirImagemAviso('');
			    return true; 
			}					 
			// post-submit callback 
			function showResponse_{$this->id}(responseText, statusText, xhr, form)  { 
			    setTimeout(function(){
					$.fancybox.close();
       			}, 300);
			} 
	       	$(document).ready(function()
	       	{
	       	   $(\"#{$this->id}\").click(function(){	       	   		
	       	   	   {$this->setActionScriptCustom}
	       	   	   exibirImagemAviso('');	
		       	   //capturando o form
				   var form = $(this).parents('form:first');				   
				   if(form != undefined && form.is('form')){				   	   
					   form.attr('action','{$urlActionMetodoButton}');
					   //força o método para post. 
					   form.attr('method','post');
					   //form.submit();
					   var options = { 
					        target:        '#divconteudo',   // target element(s) to be updated with server response 
					        beforeSubmit:  showRequest_{$this->id},  // pre-submit callback 
					        success:       showResponse_{$this->id}  // post-submit callback 
					 
					        // other available options: 
					        //url:       url         // override for form's 'action' attribute 
					        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
					        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
					        //clearForm: true        // clear all form fields after successful submit 
					        //resetForm: true        // reset the form after successful submit 
					 
					        // $.ajax options can be used here too, for example: 
					        //timeout:   3000 
					    };
					   form.ajaxForm(options).submit();
					   /*form.ajaxForm({
				       		success:
				       		function(responseText, statusText, xhr, form){
				       			dados = responseText;
				       		}
				       	}).submit();*/
					   return false;
				   }else{
				   		//cria um form para enviar no formato post.
				   		$.post('{$urlActionMetodoButton}', function(data){
				   			$('#divconteudo').html(data);
       					}).done(function(data) {
							    setTimeout(function(){
									$.fancybox.close();
				       			}, 300);
						});
					    
					   return false;
				   		
				   }
			   });
	       	});
	       </script>	
       	";
       	}
       }
       
       $button .= $script;
       
       return $button;
    }
    
}

?>