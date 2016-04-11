<?php
ini_set("display_errors", 1);
error_reporting(E_ERROR);
class ARFrameWork{
	
	function __construct(){
	
	}
	
	/**
	 *
	 * @param string $message
	 * @param ARMessageType $messageType
	 */
	static function construirAplicacao(){
		
		
		ini_set("display_errors", 1);
		if (function_exists("ini_get"))
		{
			if(!ini_get("display_errors"))
			{
				ini_set("display_errors", 1);
			}
		
			if(ini_get("magic_quotes_sybase"))
			{
				ini_set("magic_quotes_sybase", 0);
			}
		
			// Fixed register_globals behavior!!
			if (ini_get("register_globals"))
			{
				foreach($GLOBALS as $s_variable_name => $m_variable_value)
				{
					if (!in_array($s_variable_name, array("GLOBALS", "argv", "argc", "_FILES", "_COOKIE", "_POST", "_GET", "_REQUEST", "_SERVER", "_ENV", "_SESSION", "s_variable_name", "m_variable_value")))
					{
						unset($GLOBALS[$s_variable_name]);
					}
				}
				unset($GLOBALS["s_variable_name"]);
				unset($GLOBALS["m_variable_value"]);
				//echo "<br/><b>Warning</b>: I suppose you do not need enter here. Please deactivate \"register_globals\" directive<br/>";
			}
		}
		
		error_reporting(E_ALL);
				
		include_once 'core/pagecontent/page.class.php';	                                
		include_once 'core/pagecontent/pageGrid.class.php';
		
		//nclusão do tema definido no config
		$tema = Config::TEMA;
		$caminhoTema = "app/themes/".$tema."/";
		if(is_dir("app/themes/".$tema)){
		
                        if(empty($_REQUEST['modules'])){
                            $_REQUEST['modules'] = Config::PAGINA_INICIAL;
                        }
                    
			//nova instância criada pelo nome do modulo passado.
			if(!empty($_REQUEST['modules'])){	                                
				//Obtém o nome do módulo para obter a classe a ser utilizada
				//die("modules/".$_REQUEST['modules']."/".$_REQUEST['modules'].".class.php");
								
				//Listagem dos modules para inclusão dinâmica.
				$path = "app/modules/";
				
				$diretorio = dir($path);
				
				while($arquivo = $diretorio -> read())
				{
					if($arquivo != "." && $arquivo != ".."){
						if(file_exists($path.$arquivo)){
							require_once($path.$arquivo);
						}
					}
				}
				
				$diretorio -> close();
				
				if(file_exists($caminhoTema."header.php")){
					include_once $caminhoTema."header.php";
				}else{
					$_REQUEST["msg_error"] = "O tema escolhido não possui o arquivo header.php favor criar! ({$tema})";
					include_once 'erro.php';
					die();
				}
					
				if(!file_exists($caminhoTema."footer.php")){
					$_REQUEST["msg_error"] = "O tema escolhido não possui o arquivo footer.php favor criar! ({$tema})";
					include_once 'erro.php';
					die();
				}
				
				if($_REQUEST['ajax'] != "true"){
					$script = "
							<script src=\"ARFramework/lib/javascript/fancybox/source/jquery.fancybox.pack.js\" type=\"text/javascript\"></script>
        						<script src=\"ARFramework/lib/javascript/jquery-ui-1.10.1.custom/js/jquery-ui-1.10.1.custom.js\" type=\"text/javascript\"></script> 
                                                        <script src=\"ARFramework/lib/javascript/ARFramework.js\" type=\"text/javascript\"></script> 
        						<link rel=\"stylesheet\" type=\"text/css\" href=\"ARFramework/lib/javascript/jquery-ui-1.10.1.custom/css/cupertino/jquery-ui-1.10.1.custom.css\">
        						<link rel=\"stylesheet\" type=\"text/css\" href=\"ARFramework/lib/javascript/fancybox/source/jquery.fancybox.css\"> 
								<script type=\"text/javascript\">
									function exibirImagemAviso(mensagem){
						
										var modal = $(\"<a>\").fancybox({
								            'width': '90%',
								            'height': '85%',
								            'titleShow': false,
								            'transitionIn': 'elastic',
								            'transitionOut': 'elastic',
								            'modal': 'true',
								            'type': 'inline'
							        	}).attr('href',\"#div_aviso\");
							    	
							    		$(\"#topo\").append(modal);
							    		//modific a mensagem caso seja fornecido!
										if(mensagem != undefined && mensagem != \"\"){
											$(\"#div_aviso .text-center\").html(mensagem);
										}
							    		
							    		modal.click();
									}
							
									function limparDados(){
									$(\"input, select, textarea\").each(
										      function(index){  
										          var element = $(this);
										          //caso o elemto escolhido seja do tipo 'input'
										          if (element.is('input')){
												     if(element.attr('type') == 'checkbox' || element.attr('type') == 'radio'){		
										        	  	element.attr('checked',false);					        	  
													 }else{
														element.val('');
													 }
										          }else
											      {
										          	 if (element.is('select'))
											         {
										          		element.val('0');			          	 	
											         }else
												     {					          	 
											          	 element.val('');
														 element.text('');	
											         }
										          	   
										      	 }
									});
								}		
							
								</script>
							
							<div style=\"display: none;\">
								<div id=\"div_aviso\">				
									<i class=\"icon-info-sign\"></i><p class=\"text-center\"> <img src=\"ARFramework/lib/images/loading.gif\" width=\"100px\" height=\"100px\" /> Aguarde Requisição...</p>
								</div>
							</div>
							<!-- Cabeçalho -->
							<div id=\"topo\">	
							</div>"
					; 
					echo $script;
					echo "<div id='divconteudo'>";
				}				
				
				try{				
					//inclue uma nova instancia da classe passada por parametro para executar
					//o métido generatePage sobrescrito na classe.
					//$class = new ReflectionClass($_REQUEST['modules']);
					//$instance = $class->newInstanceArgs();
					 
					//$method = new ReflectionMethod($instance, "generatePage");
					//$method->invokeArgs($instance,$_REQUEST["acao"]);
					$modulo = $_REQUEST['modules'];
					$class = new $modulo();
					//escreve os argumentos para o generetPage
					$args = json_decode(json_encode($_REQUEST), FALSE);
					
					if(method_exists($class,'generatePage')){
						$class->generatePage($args);
					}else{
						throw new Exception("O método generatePage(args) não foi definido na construção da página! Este método é necessáiro para todo o funcionamento do framework.");
					}
					
					//executa o método caso o mesmo seja indicado na página;
					if(!empty($_REQUEST['metodo']) ){
						if(method_exists($class,$_REQUEST['metodo'])){
							$method = new ReflectionMethod($class, $_REQUEST['metodo']);							
							$method->invokeArgs($class,array($args));							
						}else{
							throw new Exception("O método ".$_REQUEST['metodo']." não foi identificado!");
						}
					}
					 
					//Obtém os scripts adicionados na classe para geração dos javascriot e css da página.
					//o método é executado pela classe pai Page
					if ($_REQUEST['gerarScript'] != "false" && $_REQUEST['ajax'] != "true") {
						//$method = new ReflectionMethod($instance, "obterScripts");
						//echo $method->invoke($instance);
                                                if(method_exists($class,'bindPage')){
                                                    echo $class->obterScripts();
                                                }else{
                                                    throw new Exception("You most been extends in your class a class Page or PageGrid to start a page!");
                                                }
					}
					
					//Método respôsavél por criar toda a construção da página.
					//O método é executado pela classe pai Page
                                        if(method_exists($class,'bindPage')){
                                            $class->bindPage();
                                        }else{
                                            throw new Exception("You most been extends in your class a class Page or PageGrid to start a page!");
                                        }
					//$method = new ReflectionMethod($instance, "bindPage");
					//echo $method->invoke($instance);
					
				}catch (Exception $ex){					
					$_REQUEST["msg_error"] = $ex->getMessage();
					$_REQUEST["msg_error_trace"] = "Code: ".$ex->getCode()."<br/> Arquivo: ".$ex->getFile()."<br/> Linha: ".$ex->getLine()."<br/> Trace: ".$ex->getTraceAsString();
					include_once 'erro.php';
					die();
				}
			}
			
			if($_REQUEST['ajax'] != "true" && $_REQUEST['designer'] != "true"){
				echo "</div>";
				//inclue o footer do tema
				include_once $caminhoTema."footer.php";
			}			
			
		}else{			
			$_REQUEST["msg_error"] = "O tema que foi escolhido não existe! ({$tema})";
			include_once 'erro.php';
			die();
		}
	}
	
	static function obterTemaAtual(){
		return "app/themes/".Config::TEMA."/";
	}
	
}

