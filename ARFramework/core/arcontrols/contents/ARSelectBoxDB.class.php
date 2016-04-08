<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ARCheckBoxDB
 *
 * @author arturmangabeira
 */
class ARSelectBoxDB extends ARSelectBox{
    
    private $conn;
    /**
     * List de genericDTO
     * @var ArrayObject 
     */
    private $listDTO;
    
    /**
     * DataSource de genericDTO
     * @var ArrayObject 
     */
    public $dataSource;
    
    public $queryAssoc;
    
           
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->conn = Conexao::getInstance();
        $this->listDTO = new ArrayObject();
        $this->listDTO->setFlags(ArrayObject::ARRAY_AS_PROPS);
    }
    
    public function show(GenericDTO $genericDto){
        parent::inicializarCampos();
        
        $this->listDTO->setFlags(ArrayObject::ARRAY_AS_PROPS);
        $objetoDTO = new GenericDTO();
        foreach ($this->listDTO->getIterator() as $objetoDTO) {
            $checkBox = new CheckBoxHTML();
            foreach (parent::obterCampo()->getIterator() as $checkBox) {
                $class = new ReflectionClass($objetoDTO->getClass());
                $propriedades = new ReflectionProperty();                
                foreach ($class->getProperties() as $propriedades) {
                    //$prop = new ReflectionProperty($objetoDTO->getClass(), $propriedades);
                    $propriedades->getValue($class);
                }
                
            }
        }
        
    }
    
    public function bind(){
       parent::inicializarCampos($this->dataSource->count());
       
       $$combo = "";
       if($this->multiSelect){
           $combo = $this->gerarComboMultiSelect();
       }else{
           $combo = $this->gerarCombo();
       } 
       
       return $combo;
    }
    
    private function gerarCombo(){
       $combo  = " <div class=\"control-group\"> ";
       $combo .= " <label class=\"control-label\" for=\"{$this->id}\">{$this->label}:</label>";
       $combo .= " <div class=\"controls\"> ";
       if($this->dataSource->count() > 0){
            $desabilitar = "";
           if ($this->disable)
               $desabilitar = "disabled=\"disabled\"";
           $required = "";
               
           if($this->require){
              $required = " required=\"true\" ";
           }
           $combo .= "<select id=\"{$this->id}\" {$desabilitar} name=\"{$this->name}\" {$this->function} class=\"{$this->class}\" style=\"{$this->style}\" {$required}>";
           if ($this->showIniValues){
               $combo .= "<option value=\"{$this->iniValue}\"> {$this->iniCaption} </option>";
           }
           $genericDto = new GenericDTO();
           foreach ($this->dataSource as $genericDto) {
               $campo = new CampoHTML();
               foreach ($this->obterCampo()->getIterator() as $campo) {
                  $selecionado = "";
                  
                  $method = new ReflectionMethod(get_class($genericDto), "get".ucfirst($campo->getField()));
                  $option_value = $method->invoke($genericDto);
                  
                  $method = new ReflectionMethod(get_class($genericDto), "get".ucfirst($campo->getFieldCaption()));
                  $option_name = $method->invoke($genericDto);
                  
                  if ($this->default == $option_value){                      
                      $selecionado = "selected";
                  }
                  $combo .= "<option value=\"{$option_value}\" {$selecionado}> {$option_name} </option>";  
               }
           }
           $combo .= "</select>";
           $combo .= " </div>";
           $combo .= " </div>";
       }
       
       return $combo; 
    }
    
    private function gerarComboMultiSelect(){
       $div_dados_selecionados =  "<div>";
       $combo  = " <div class=\"control-group\"> ";
       $combo .= " <label class=\"control-label\" for=\"{$this->id}\">{$this->label}:</label>";
       $combo .= " <div class=\"controls\"> ";
       if($this->dataSource->count() > 0){
            $desabilitar = "";
           if ($this->disable)
               $desabilitar = "disabled=\"disabled\"";
           
           $combo .= "<select id=\"{$this->id}\" {$desabilitar} name=\"{$this->name}[]\" multiple=\"multiple\" title=\"{$this->iniCaption}\" {$this->function}  class=\"{$this->class}\" style=\"{$this->style}\">";
           //$combo = "<select id=\"{$this->id}\" {$desabilitar} name=\"{$this->name}[]\" multiple=\"multiple\" {$this->function} >";
           $genericDto = new GenericDTO();
           foreach ($this->dataSource as $genericDto) {
               $campo = new CampoHTML();
               foreach ($this->obterCampo()->getIterator() as $campo) {
                  $selecionado = "";
                  $method = new ReflectionMethod(get_class($genericDto), "get".ucfirst($campo->getField()));
                  $option_value = $method->invoke($genericDto);
                  
                  $method = new ReflectionMethod(get_class($genericDto), "get".ucfirst($campo->getFieldCaption()));
                  $option_name = $method->invoke($genericDto);
                  
                  if(!empty($this->queryAssoc)){ 
                    if($this->verificarExistencia($option_value)){
                        $selecionado = "selected";
                    }
                  }
                  $combo .= "<option value=\"{$option_value}\" {$selecionado}> {$option_name} </option>";  
               }
           }
           $combo .= "</select>";
       }
       $combo .= " </div>";
       $combo .= " </div>";
       $div_dados_selecionados .= $combo."</div> <br /> <div id=\"dados_selecionados_text\"> </div>";
       
       return $div_dados_selecionados;
    }
    
    private function verificarExistencia($sqGeral){
       $retorno = false;
       $query = $this->queryAssoc;
       $query = $this->queryAssoc.$sqGeral;  
       
       $resultSetMultiSelect = $this->conn->Execute($query); 
       
       if($resultSetMultiSelect->RecordCount() > 0){
           $retorno = true;
       }
       return $retorno;
    }
}

?>
