<?php

error_reporting(E_ERROR);
require_once 'ARFramework/core/basebd/genericDTO.class.php';

require_once 'ARFramework/core/pagecontent/funcoes.php';

require_once 'app/config.php';
require_once 'ARFramework/core/basebd/conexao.class.php';

require_once 'ipage.class.php';
//include de bibliotecas de controles

require_once 'ARFramework/core/htmlcontrols/objetoHTML.class.php';
require_once 'ARFramework/core/htmlcontrols/campoHTML.class.php';

require_once 'ARFramework/core/arcontrols/conteiners/ARAccordion.class.php';
require_once 'ARFramework/core/arcontrols/conteiners/ARArticle.class.php';
require_once 'ARFramework/core/arcontrols/conteiners/ARAside.class.php';
require_once 'ARFramework/core/arcontrols/conteiners/ARDiv.class.php';
require_once 'ARFramework/core/arcontrols/conteiners/ARFieldSet.class.php';
require_once 'ARFramework/core/arcontrols/conteiners/ARForm.class.php';
require_once 'ARFramework/core/arcontrols/conteiners/ARSection.class.php';

require_once 'ARFramework/core/arcontrols/contents/ARButton.class.php';
require_once 'ARFramework/core/arcontrols/contents/ARCheckBox.class.php';
require_once 'ARFramework/core/arcontrols/contents/ARCheckBoxDB.class.php';
require_once 'ARFramework/core/arcontrols/contents/ARImage.class.php';
require_once 'ARFramework/core/arcontrols/contents/ARLink.class.php';
require_once 'ARFramework/core/arcontrols/contents/ARSelectBox.class.php';
require_once 'ARFramework/core/arcontrols/contents/ARSelectBoxDB.class.php';
require_once 'ARFramework/core/arcontrols/contents/ARTable.class.php';
require_once 'ARFramework/core/arcontrols/contents/ARTextAreaBox.class.php';
require_once 'ARFramework/core/arcontrols/contents/ARTextBox.class.php';
require_once 'ARFramework/core/arcontrols/contents/ARTextHtml.class.php';

require_once 'ARFramework/core/arcontrols/ARAction.class.php';
require_once 'ARFramework/core/arcontrols/ARMessage.class.php';
require_once 'ARFramework/core/arcontrols/ARBootstrap.class.php';

include_once 'funcoes.php';

include_once 'iformat.class.php';

//include_once 'format/formater.class.php';

//Listagem dos dtos para adicionar na referencia de forma automática
//Listagem dos DTO

$path = "app/dto/";

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

//Listagem dos DBs
$path = "app/db/";

$diretorioDB = dir($path);

while($arquivo = $diretorioDB -> read())
{
	if($arquivo != "." && $arquivo != ".."){
		if(file_exists($path.$arquivo)){
			require_once($path.$arquivo);
		}
	}
}
$diretorioDB -> close();

//Listagem dos formater
$path = "app/formater/";

$diretorio = dir($path);

while($arquivo = $diretorio -> read())
{
	if($arquivo != "." && $arquivo != ".." && !empty($arquivo)){
		if(file_exists($path.$arquivo) && !is_dir($path.$arquivo)){			
			require_once($path.$arquivo);
		}
	}
}
$diretorio -> close();

//die("formarterTeste");
//Listagem dos UIs
$path = "app/ui/";

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

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of page
 *
 * @author arturmangabeira
 */
class Page implements IPage{
    
    var $campo;
    var $scriptsRel;
    var $scriptsCuston;
    var $scriptCssRel;
    var $scriptCssCuston;
    //put your code here
    public function __construct() {
        $this->campo     = new ArrayObject();
        $this->campo->setFlags(ArrayObject::ARRAY_AS_PROPS);
        $this->scriptsRel     = new ArrayObject();
        $this->scriptsRel->setFlags(ArrayObject::ARRAY_AS_PROPS);
        $this->scriptsCuston     = new ArrayObject();
        $this->scriptsCuston->setFlags(ArrayObject::ARRAY_AS_PROPS);
        $this->scriptCssCuston     = new ArrayObject();
        $this->scriptCssCuston->setFlags(ArrayObject::ARRAY_AS_PROPS);
        $this->scriptCssRel     = new ArrayObject();
        $this->scriptCssRel->setFlags(ArrayObject::ARRAY_AS_PROPS);
        
    }
    
    public function bindPage(){
        //Executa os scripts que foram carregados nas classes filhas
        $this->gerarDadosPage();
    }
    
    private function gerarDadosPage(){
        
       //die(print_r($this->obterCampo()->getIterator()));
       foreach ($this->obterCampo()->getIterator() as $key => $campo) {      		
       		       		
            $method = new ReflectionMethod(get_class($campo), "bind");
            $value = $method->invoke($campo);
            echo $value;
       }
    }
    
    var $scriptButton = 0;
    var $scriptMask = 0;
    var $scriptDatePicker = 0;
    var $scriptTinyMCE = 0;
    var $asmSelect = 0;
    var $multiSelect = 0;
    
    public function obterScriptsARControls($obj){
    	
    		//$class = get_class($obj);
    		//$properties = $class->getProperties( ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC );
    		
    		if(method_exists($obj,'obterCampo')){    		
	    		$method = new ReflectionMethod($obj, "obterCampo");
	    		$method->setAccessible(true);
	    		$valor = $method->invoke($obj);
    		}else{
    			$valor = $obj;
    		}
    		
    		if(!is_null($valor)){
    			$arrayItens = $valor;
    			foreach ($arrayItens as $objCampo){
    				    				 
    				if($objCampo instanceof ARButton){
    					$propriedade = new ReflectionProperty($objCampo, "setAction");
    					if (!is_null($propriedade)){
    						//verifica se o tipo passado ActionButton está diferente de null    						
    						if($scriptButton == 0){
    							$scriptButton++;
    							//nesse caso somente adiciona uma única vez para o button com a mesma acao
    							$this->addScriptRel(Config::SITE_ADDRESS."ARFramework/lib/javascript/jquery/jquery.form.min.js");
    							return;
    						}    						
    					}
    				}else{
    					if($objCampo instanceof ARTextBox){
    						$propriedade = new ReflectionProperty($objCampo, "typeARTextBoxMask");
    						if ($propriedade->getValue($objCampo) != null){
    							//verifica se o tipo passado ActionButton está diferente de null
    							if($scriptMask == 0){
    								$scriptMask++;
    								$this->addScriptRel(Config::SITE_ADDRESS."ARFramework/lib/javascript/jquery/jquery.maskedinput.min.js");
    								if($propriedade->getValue($objCampo) == TipoARTextBoxMask::MONETARIO){
    									$this->addScriptRel(Config::SITE_ADDRESS."arcontrols/javascript/jquery.maskmoney/jquery.maskMoney.js");
    								}
    							}else{
    								if($scriptMask == 1){
    									$scriptMask++;
	    								if($propriedade->getValue($objCampo) == TipoARTextBoxMask::MONETARIO){
	    									$this->addScriptRel(Config::SITE_ADDRESS."ARFramework/lib/javascript/jquery.maskmoney/jquery.maskMoney.js");
	    								}
    								}
    							}
    						}
    						$propriedade = new ReflectionProperty($objCampo, "typeARTextBox");
    						if ($propriedade->getValue($objCampo) != null){
    							//verifica se o tipo passado ActionButton está diferente de null
    							if($scriptDatePicker == 0){
    								$scriptDatePicker++;
    								if($propriedade->getValue($objCampo) == TipoARTextBox::DATETIME || $propriedade->getValue($objCampo) == TipoARTextBox::DATETIME_MONTH_YEAR || $propriedade->getValue($objCampo) == TipoARTextBox::DATETIME_YEAR){
    									$this->addScriptRel(Config::SITE_ADDRESS."ARFramework/lib/javascript/jquery/jquery.ui.datepicker-pt-BR.js");
    								}else{
    									if($propriedade->getValue($objCampo) == TipoARTextBox::NUMBER){
    										if($scriptMask == 0){
    											$scriptMask++;
    											$this->addScriptRel(Config::SITE_ADDRESS."ARFramework/lib/javascript/jquery/jquery.maskedinput.min.js");
    										}
    									}
    								}
    							}
    						}
    					}else{
    						if($objCampo instanceof ARTextAreaBox){//useTinyMce
    							$propriedade = new ReflectionProperty($objCampo, "useTinyMce");
    							if ($propriedade != null && ($propriedade->getValue($objCampo) == true)){
    								//verifica se o tipo passado ActionButton está diferente de null
    								if($scriptTinyMCE == 0){
    									$scriptTinyMCE++;
    									$this->addScriptRel(Config::SITE_ADDRESS."ARFramework/lib/javascript/tinymce_4.03/js/tinymce/tinymce.min.js");
    									//$this->addScriptRel(Config::SITE_ADDRESS."arcontrols/javascript/ckeditor/ckeditor.js");
    								}
    							}
    						}else{
    							if($objCampo instanceof ARSelectBox){
    								//tipoArSelectBox
    								//TipoARSelectBox
    								$propriedade = new ReflectionProperty($objCampo, "tipoArSelectBox");
    								if ($propriedade->getValue($objCampo) != null){
    									if($propriedade->getValue($objCampo) == TipoARSelectBox::ASMSELECT){
    										if($asmSelect == 0){
    											$asmSelect++;
    											$this->addScriptRel(Config::SITE_ADDRESS."ARFramework/lib/javascript/asmselect/jquery.asmselect.js");
    											$this->addScriptCssRel("ARFramework/lib/javascript/asmselect/jquery.asmselect.css");
    										}
    									}else{
    										if($propriedade->getValue($objCampo) == TipoARSelectBox::MULTISELECT){
    											if($multiSelect == 0){
    												$multiSelect++;
    												$this->addScriptRel(Config::SITE_ADDRESS."ARFramework/lib/javascript/jquery.multselect/jquery.multiselect.js");
    												$this->addScriptRel(Config::SITE_ADDRESS."ARFramework/lib/javascript/jquery.multselect/jquery.multiselect.br.js");
    												$this->addScriptCssRel(Config::SITE_ADDRESS."ARFramework/lib/javascript/jquery.multselect/jquery.multiselect.css");
    											}
    										}
    									}
    									
    								}
    								
    							}else{
    								if(method_exists($objCampo,'obterCampo')){
    									$methodAnalise = new ReflectionMethod($objCampo, "obterCampo");
    									$methodAnalise->setAccessible(true);
    									$valorAnalise = $methodAnalise->invoke($objCampo);
    									if(!is_null($valorAnalise)){
    										$this->obterScriptsARControls($valorAnalise);
    									}else{
    										continue;
    									}
    								}
    							}
    						}
    					}    					
    				}
    			}
    		}
    	
    }
    
    /**
     * Função que adiciona o objetoHTML para o prenchimento do form.
     * @param CheckBoxHTML $campoHtml
     */
    public function addItemPage(ObjetoHTML $objetoHTML){
        if($objetoHTML instanceof ObjetoHTML){
            $this->campo->append($objetoHTML);
        }else{
            throw new Exception("O objeto deve herdar de ObjetoHTML!");
        }
    }
    
    protected function obterCampo(){
        return $this->campo;
    }
    
    /**
     * Função que adiciona o objetoHTML para o prenchimento do form.
     * @param CheckBoxHTML $campoHtml
     */
    public function addScriptRel($caminhoScript){
        $this->scriptsRel->append($caminhoScript);
    }
    
    private function obterScriptRel(){
        return $this->scriptsRel;
    }
    
    /**
     * Função que adiciona o objetoHTML para o prenchimento do form.
     * @param CheckBoxHTML $campoHtml
     */
    public function addCustonScript($script){
        $this->scriptsCuston->append($script);
    }
    
    private function obterCustonScript(){
        return $this->scriptsCuston;
    }
    
    /**
     * Função que adiciona o objetoHTML para o prenchimento do form.
     * @param CheckBoxHTML $campoHtml
     */
    public function addScriptCssCuston($caminhoScriptCss){
        $this->scriptCssCuston->append($caminhoScriptCss);
    }
    
    private function obterScriptCssCuston(){
        return $this->scriptCssCuston;
    }
    
     /**
     * Função que adiciona o objetoHTML para o prenchimento do form.
     * @param CheckBoxHTML $campoHtml
     */
    public function addScriptCssRel($caminhoScriptCss){
        $this->scriptCssRel->append($caminhoScriptCss);
    }
    
    private function obterScriptCssRel(){
        return $this->scriptCssRel;
    }
       
    public function obterScripts(){
    	
        //Obtém primeiro os javstips include        
    	foreach ($this->obterCampo()->getIterator() as $campo) {
    		 
    		$this->obterScriptsARControls($campo);
    	}
    	
        $js = "";
        foreach ($this->obterScriptRel()->getIterator() as $campo) {
            $js .= "\r\n"."<script src=\"{$campo}\" type=\"text/javascript\"></script> ";
        }
        
        if($this->obterCustonScript()->count() >0){
            
            $js .= "\r\n"." <script type=\"text/javascript\"> "."\r\n";
            foreach ($this->obterCustonScript()->getIterator() as $campo) {
                $js .= $campo;
            }
            $js .= " </script> ";
        }
        
        echo $js."\r\n";
        
        $css = "";
        foreach ($this->obterScriptCssRel()->getIterator() as $campo) {
            $css .= "\r\n"."<link rel=\"stylesheet\" href=\"{$campo}\" /> ";
        }
        
        if($this->obterScriptCssCuston()->count() >0){
            
            $css .= "\r\n"." <style type=\"text/css\"> "."\r\n";
            foreach ($this->obterScriptCssCuston()->getIterator() as $campo) {
                $css .= "\r\n".$campo."\r\n";
            }
            $css .= "\r\n"." </style> "."\r\n";
        }
        
        echo $css."\r\n";
    }

}

?>
