<?php
/**
 * Description of ARTextBox
 *
 * @author artur
 */
class TipoARTargetLink{
    const _BLANK = "_blank";
    const _PARENT = "_parent";
    const _SELF = "_self";
    const _TOP = "_top";
}

class ARLink extends objetoHTML {
    //put your code here
    
    var $name;
    var $id;
    var $width;
    var $heigth;
    var $style;
    var $value;
    var $text;
    var $bootStrap;
    var $label;
    var $class;
    var $modal;
    var $modalWidth;
    var $modalHeigth;
    var $href;
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
            $this->name = "ARLink_".rand(100, 4000);
        }
        
        if(empty($this->id)){            
            $this->id  = $this->name;
        }
        
        if(empty($this->width)){            
           $this->width = "40"; 
        }
        
        if(empty($this->heigth)){            
           $this->heigth = "20"; 
        }
        
        if(empty($this->style)){            
           $this->style = ""; 
        }
        
        if(empty($this->modalWidth)){
            $this->modalWidth = "50";
        }
        
        if(empty($this->modalHeigth)){
            $this->modalHeigth = "50";
        }
        
        if(empty($this->class)){
            $this->class = "text-right";
        }
        
        if(empty($this->target)){            
           $this->target = TipoARTargetLink::_SELF; 
        }
        
    }
    
    public function bind(){
        $this->inicializarCampos();
        
        if($this->modal){
            return $this->scriptsLink()."   ".$this->gerarLink();
        }else{
            return $this->gerarLink();
        }
    }
    
    private function scriptsLink(){
               
        $js = " <script type=\"text/javascript\">
                        $(document).ready(function() {
              ";
        if($this->modal){
            $js .= " $(\"#{$this->id}\").fancybox({
                        'width'		: '{$this->modalWidth}%',
                        'height'	: '{$this->modalHeigth}%',
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
    
    private function gerarLink(){
        $link = "";
        if($this->bootStrap){
            $link  .= " <div class=\"control-group\"> ";
            $link  .= " <label class=\"control-label\" for=\"{$this->id}\">{$this->label}</label>";
            $link  .= " <div class=\"controls\" style=\"width:{$this->width}%;\"> ";
        }
        $link  .= " <a name=\"$this->name\" id=\"{$this->id}\" value=\"{$this->value}\"";
        $link  .= " style=\"{$this->style}\" class=\"{$this->class}\" href=\"{$this->href}\" target=\"{$this->target}\"";
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
                    $link  .= " $propName=\"$valor\" ";
                }
                
            }
        }
        
        $link  .= " > {$this->text} </a> ";
        if($this->bootStrap){
            $link  .= " </div>";
            $link  .= " </div>";
        }
        return $link ;
    }
}

?>
