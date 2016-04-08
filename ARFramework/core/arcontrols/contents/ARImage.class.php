<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class TipoAlignImagem{
    const TOP    = "top";
    const BOTTON = "botton";
    const MIDDLE = "middle";
    const LEFT   = "left";
    const RIGHT  = "right";
}
/**
 * Description of ARImagem
 *
 * @author artur
 */
class ARImage extends objetoHTML {
    //put your code here
    var $name;
    var $id;
    var $src;
    var $alt;
    /**
     * Variavel do tipo TipoAlignImagem
     * @var TipoAlignImagem 
     */
    var $align;
    var $width;
    var $heigth;
    var $style;
    var $bootStrap;
    var $label;
    
    public function __construct() {
        parent::__construct();
    }
    
    protected function inicializarCampos(){
        if(empty($this->name)){
            $this->name = "ARImagem_".rand(100, 4000);
        }
        
        if(empty($this->id)){            
            $this->id  = $this->name;
        }
    }
    
    public function bind(){
        $this->inicializarCampos();
        return $this->gerarImagem();
    }
    
    public function gerarImagem(){
        $img = "";
        if($this->bootStrap){
           $img  .= "\r\n"."  <div class=\"control-group\"> ";
           $img  .= "\r\n"."       <label class=\"control-label\" for=\"{$this->id}\">{$this->label}:</label>";
           $img  .= "\r\n"."       <div class=\"controls\"> "; 
        }
        $img  .= "\r\n"."             <img src=\"{$this->src}\" id=\"{$this->id}\" alt=\"{$this->alt}\" height=\"{$this->heigth}\" width=\"{$this->width}\"";
        $img  .= "\r\n"." align=\"{$this->align}\" style=\"{$this->style}\" ";
        
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
                    $img  .= " $propName=\"$valor\" ";
                }
                
            }
        }
        $img  .= " />";
        
        if($this->bootStrap){
            $img  .= "\r\n"."     </div>";
            $img  .= "\r\n"."  </div>";
        }
        
        return $img;
    }
}

?>
