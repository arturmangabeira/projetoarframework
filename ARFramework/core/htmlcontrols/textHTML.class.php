<?php
require_once 'objetoHTML.class.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of textHTML
 *
 * @author armcunha
 */
class textHTML extends objetoHTML{
    
    private $caption;
    private $sortable = "true";
    private $field;
    
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function setCaption($caption){
        $this->caption = $caption;
    }
    
    public function getCaption(){
        return $this->caption;
    }
    
    public function setSortable($sortable="true"){
        $this->sortable = $sortable;
    }
    
    public function getSortable(){
        return $this->sortable;
    }
    
    public function setField($field){
        $this->field = $field;
    }
    
    public function getField(){
        return $this->field;
    }
}

?>
