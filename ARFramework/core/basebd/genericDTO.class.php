<?php
require_once 'baseDTO.class.php';
class GenericDTO extends BaseDTO {
    
    private $table;
    private $class;
    private $page;
    private $sortname;
    private $sortorder;
    private $itenperpage;
    private $count;
    private $modules;
    private $submodulo;
    private $acao;
    private $designer;
    private $key;
    private $idField;
    private $keys;
    
    function __construct() {
       parent::__construct();
       $this->setSortName($_REQUEST['sidx']);
       $this->setSortOrder($_REQUEST['sord']);
       $this->setPage($_REQUEST['page']);
       $this->setItenPerPage($_REQUEST['rows']);
       $this->setmodules($_REQUEST['modules']);
       $this->setSubModulo($_REQUEST['submodulo']);
       $this->setAcao($_REQUEST['acao']);
       $this->setDesigner($_REQUEST['designer']);
       $this->setIdField($_REQUEST['idField']);
    }
    
    public function setTable($table){
        $this->table = $table;
    }
    
    public function getTable(){
        return $this->table;
    }
    
    public function setClass($class){
        $this->class = $class;
    }
    
    public function getClass(){
        return $this->class;
    }
    
    public function setPage($page){
        $this->page = $page;
    }
    
    public function getPage(){
        return $this->page;
    }
    
    public function setSortName($sortname){
        $this->sortname = $sortname;
    }
    
    public function getSortName(){
        return $this->sortname;
    }
    
    public function setSortOrder($sortorder){
        $this->sortorder = $sortorder;
    }
    
    public function getSortOrder(){
        return $this->sortorder;
    }
    
    public function setItenPerPage($itenperpage){
        $this->itenperpage = $itenperpage;
    }
    
    public function getItenPerPage(){
        return $this->itenperpage;
    }
    
    public function setCount($count){
        $this->count = $count;
    }
    
    public function getCount(){
        return $this->count;
    }
    
    public function setmodules($modules){
        $this->modules = $modules;
    }
    
    public function getmodules(){
        return $this->modules;
    }
    
    public function setSubModulo($submodulo){
        $this->submodulo = $submodulo;
    }
    
    public function getSubModulo(){
        return $this->submodulo;
    }
    
    public function setAcao($acao){
        $this->acao = $acao;
    }
    
    public function getAcao(){
        return $this->acao;
    }
    //designer
    public function setDesigner($designer){
        $this->designer = $designer;
    }
    
    public function getDesigner(){
        return $this->designer;
    }
    
    public function setKey($key){
        $this->key = $key;
    }
    
    public function getKey(){
        return $this->key;
    }
    
    public function setIdField($value){
        $this->idField = $value;
    }
    
    public function getIdField(){
        return $this->idField;
    }
    
    public function setKeys($key){
    	$this->keys = $key;
    }
    
    public function getKeys(){
    	return $this->keys;
    }
    
}    
?>
