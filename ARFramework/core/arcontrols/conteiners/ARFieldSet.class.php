<?php

class FieldSetLegendClass {
    const TEXT = "text-info";
    const TEXT_SUCESS = "badge badge-success";
    const TEXT_INFO = "badge badge-info";
}
/**
 * Description of ARCheckBox
 *
 * @author artur mangabeira
 */
class ARFieldSet extends objetoHTML {
    //put your code here
    
    /**
     * Variavel que contém o array de checkBoxHtml;
     * @var ArrayObject 
     */
    private $campo;
    
    var $name;
    var $id;
    var $style;
    var $class;
    var $legend;
    /**
     * Variavel que contém o tipo de classe na legenda do fieldset
     * @var FieldSetLegendClass 
     */
    var $legendClass;
        
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
            $this->name = "ARFieldSet_".rand(100, 4000);
        }
        
        if(empty($this->id)){            
            $this->id  = $this->name;
        }
        
        if(empty($this->style)){            
           $this->style = ""; 
        }
        
        if(empty($this->legendClass)){
            $this->legendClass = FieldSetLegendClass::TEXT;
        }
    }
    
    
    public function bind(){
       $this->inicializarCampos();
       return $this->gerarFieldSet();
    }
    
    private function gerarFieldSet(){
        $fieldSet = "\r\n"."<fieldset class=\"{$this->class}\" id=\"{$this->id}\" style=\"{$this->style}\" >";
        $fieldSet .= "\r\n"." <legend>"."\r\n"."   <h4>"."\r\n"."     <p class=\"{$this->legendClass}\">{$this->legend}</p>"."\r\n"."   </h4>"."\r\n"." </legend>"."\r\n";
       //Adiciona os objetoHTML
       foreach ($this->obterCampo()->getIterator() as $campo) {
            $method = new ReflectionMethod(get_class($campo), "bind");
            $value = $method->invoke($campo);
            $fieldSet .= $value."\r\n";
       }
       
       $fieldSet .= "\r\n"." </fieldset> ";
       
       return $fieldSet;
    }
    
}

?>