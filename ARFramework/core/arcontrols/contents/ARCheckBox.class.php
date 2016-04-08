<?php
/**
 * Description of ARTextBox
 *
 * @author artur
 */

class ARCheckBox extends objetoHTML {
    //put your code here
    
    var $name;
    var $id;
    var $style;
    var $value;
    var $bootStrap;
    var $label;
    var $class;
    var $href;
    var $selected;
    var $text;
    /**
     * Variavel do tipo TipoARTargetLink
     * @var TipoARTargetLink 
     */
    VAR $target;
    
    public function __construct() {
        parent::__construct();
    }

    protected function inicializarCampos(){
        if(empty($this->name)){
            $this->name = "ARCheckBox_".rand(100, 4000);
        }
        
        if(empty($this->id)){            
            $this->id  = $this->name;
        }
        
        if(empty($this->style)){            
           $this->style = ""; 
        }       
        
    }
    
    public function bind(){
        $this->inicializarCampos();
       
        return $this->gerarARCheckBox();
    }
    
    private function scriptsARCheckBox(){
               
        $js = " <script type=\"text/javascript\">
                        $(document).ready(function() {
              ";
        if($this->modal){
            $js .= " $(\"#{$this->id}\").fancybox({
                        'width'		: '50%',
                        'height'	: '50%',
                        'titleShow'	: false,
                        'transitionIn'	: 'elastic',
                        'transitionOut'	: 'elastic',
                        'type' : 'iframe'
                     });           
                    ";
        }
        $js .= " }); </script>";

        return $js;
    }
    
    private function gerarARCheckBox(){
    	$chkBox   = "";
    	if($this->bootStrap){
	        $chkBox   = " <div class=\"control-group\"> ";
	        $chkBox  .= " <label class=\"control-label\" for=\"{$this->id}\">{$this->label}:</label>";
	        $chkBox  .= " <div class=\"controls\">  
	                      <label class=\"checkbox\">  ";
    	}
        if($this->selected){
           $selecionado = "checked=\"checked\""; 
        }else{
        	$selecionado = "";
        }
        $chkBox .= "  <input type=\"checkbox\" {$selecionado} name=\"{$this->name}\" value=\"{$this->value}\" id=\"{$this->id}\"";
        $chkBox  .= " style=\"{$this->style}\" class=\"{$this->class}\" ";
        //Adiciona os eventos a serem disparados através de reflection.
        $class = new ReflectionClass(get_class($this));
        
        $properties = $class->getParentClass()->getParentClass()->getProperties(ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC);

        if (!is_null($properties)) {

            foreach ($properties as $prop) {
                $propName = $prop->getName();
                
                $method = new ReflectionMethod(get_class($this), 'get'.$propName);
                //$method->setAccessible(true);
                $valor = $method->invoke($this);

                if(!empty($valor)){
                    $chkBox  .= " $propName=\"$valor\" ";
                }
                
            }
        }
        
        if($this->bootStrap){
	        $chkBox  .= " > {$this->text} </label>";
	        $chkBox  .= " </div>";
	        $chkBox  .= " </div>";
        }else{
        	$chkBox  .= " >";
        }
        return $chkBox ;
    }
}

?>
