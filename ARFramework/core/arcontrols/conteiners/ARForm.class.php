<?php

class TipoFormClassBootstrap{
    const FORM_HORIZONTAL = "form-horizontal";
    const FORM_VERTICAL = "form";
}


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class TipoMethodForm {
    const POST = "post";
    const GET  = "get";
}
class TipoEncTypeForm {
    const FILE = "multipart/form-data";
    const APPLICATION  = "application/x-www-form-urlencoded";
    const TEXT = "text/plain";
}
/**
 * Description of ARCheckBox
 *
 * @author armcunha
 */
class ARForm extends objetoHTML {
    //put your code here
    
    /**
     * Variavel que contém o array de checkBoxHtml;
     * @var ArrayObject 
     */
    private $campo;
    
    var $name;
    var $id;
    var $style;
    
    /**
     *
     * @var TipoFormClassBootstrap
     */
    var $class;
    
    var $action;
    /**
     * Variável do tipo TipoEncTypeForm
     * @var TipoEncTypeForm 
     */
    var $enctype;
    /**
     * Variavel do tipo TipoMethodForm
     * @var TipoMethodForm 
     */
    var $method;
    
    public function __construct() {
        parent::__construct();
        $this->campo     = new ArrayObject();
        $this->campo->setFlags(ArrayObject::ARRAY_AS_PROPS);
    }
    
    /**
     * Função que adiciona o objetoHTML para o prenchimento do form.
     * @param CheckBoxHTML $campoHtml
     */
    public function addItem($objetoHTML){
        if($objetoHTML instanceof ObjetoHTML){
            $this->campo->append($objetoHTML);
        }else{
            throw new Exception("O objeto deve herdar de ObjetoHTML!");
        }
    }
    
    protected function obterCampo(){
        return $this->campo;
    }


    protected function inicializarCampos(){
        if(empty($this->name)){
            $this->name = "ARForm_".rand(100, 4000);
        }
        
        if(empty($this->id)){            
            $this->id   = $this->name;
        }
        
        if(empty($this->style)){            
           $this->style = ""; 
        }
         
        if(empty($this->class)){            
           $this->class = "form-horizontal"; 
        }
    }
    
    public function adicionarScripts(){
        $endscript   = "<script src=\"bibliotecas/javascript/jquery/jquery.ui.datepicker-pt-BR.js\" type=\"text/javascript\"></script>";
        $endscript  .= "<script src=\"bibliotecas/javascript/jquery.maskmoney/jquery.maskMoney.js\" type=\"text/javascript\"></script>";
        $endscript  .= "<script src=\"bibliotecas/javascript/jquery/jquery.maskedinput.min.js\" type=\"text/javascript\"></script>";
        $endscript  .= "<script type=\"text/javascript\" src=\"bibliotecas/javascript/tinymce_4.03/js/tinymce/tinymce.min.js\"></script>";
        
        echo "";
        //echo $endscript;
    }
    
    public function bind(){
       $this->inicializarCampos();
       $this->adicionarScripts();       
       return $this->gerarForm();
    }
    
    private function gerarForm(){
        $form = "<form class=\"{$this->class}\" id=\"{$this->id}\" style=\"{$this->style}\" action=\"{$this->action}\" method=\"{$this->method}\"";
        
        if(!empty($this->enctype)){
            $form .= " enctype=\"{$this->enctype}\" ";
        }
        
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
                    $form .= " $propName=\"$valor\" ";
                }
                
            }
        }
       $form .= "> 
                ";
       //Adiciona os objetoHTML
       foreach ($this->obterCampo()->getIterator() as $campo) {
            $method = new ReflectionMethod(get_class($campo), "bind");
            $value = $method->invoke($campo);
            $form .= $value;
       }
       $form .= "</form>";
       
       return $form;
    }
    
}

?>