<?php
/**
 * Description of ARCheckBox
 *
 * @author artur mangabeira
 */
class ARDiv extends objetoHTML {
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
    protected $propriedades;
        
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
    
    public function setPropriedades($propName, $propValue){
    	$this->propriedades[$propName] = $propValue;
    }


    protected function inicializarCampos(){
        if(empty($this->name)){
            $this->name = "ARDiv_".rand(100, 4000);
        }
        
        if(empty($this->id)){            
            $this->id   = $this->name;
        }
        
        if(empty($this->style)){            
           $this->style = ""; 
        }
    }
    
    
    public function bind(){
       $this->inicializarCampos();
       return $this->gerarDiv();
    }
    
    private function gerarDiv(){
        $div = "<div class=\"{$this->class}\" id=\"{$this->id}\" style=\"{$this->style}\" ";
        
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
                    $div .= " $propName=\"$valor\" ";
                }
                
            }
            //inclu as propriedades nova do programador
            if($this->propriedades){
            	foreach ($this->propriedades as $propName => $valor) {
            		$div .= " $propName=\"$valor\" ";
            	}
            }
            
        }
       $div .= "> 
                ";
       //Adiciona os objetoHTML
       foreach ($this->obterCampo()->getIterator() as $campo) {
            $method = new ReflectionMethod(get_class($campo), "bind");
            $value = $method->invoke($campo);
            $div .= $value;
       }
       $div .= "</div>";
       
       return $div;
    }
    
}

?>