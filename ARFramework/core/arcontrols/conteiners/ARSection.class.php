<?php
/**
 * Description of ARSection
 *
 * @author artur mangabeira
 */
class ARSection extends objetoHTML {
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
            $this->name = "ARSection_".rand(100, 4000);
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
       return $this->gerarSection();
    }
    
    private function gerarSection(){
       $section = "<section>";
       //Adiciona os objetoHTML
       foreach ($this->obterCampo()->getIterator() as $campo) {
            $method = new ReflectionMethod(get_class($campo), "bind");
            $value = $method->invoke($campo);
            $section .= $value;
       }
       
       $section .= " </section> ";
       
       return $section;
    }
    
}

?>