<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ARCheckBoxDB
 *
 * @author armcunha
 */
class ARCheckBoxDB extends ARCheckBox{
    
    private $conn;
    /**
     * List de genericDTO
     * @var ArrayObject 
     */
    private $listDTO;
    
    
    public $resultSet;
        
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
       parent::inicializarCampos();
       
       $combo = "";
       if($this->resultSet->RecordCount() > 0){
           $combo = "<select id=\"{$this->id}\" name=\"{$this->name}\" {$this->function} style=\"{$this->style}\">";
           if ($this->showIniValues){
               $combo .= "<option value=\"{$this->iniValue}\"> {$this->iniCaption} </option>";
           }
           foreach ($this->resultSet->getArray() as $value) {
               $campo = new CampoHTML();
               foreach ($this->obterCampo()->getIterator() as $campo) {
                  $combo .= "<option value=\"{$value[$campo->getField()]}\"> {$value[$campo->getFieldCaption()]} </option>";  
               }
           }
           $combo .= "</select>";
       }
       
       return $combo;
    }
    
}

?>
