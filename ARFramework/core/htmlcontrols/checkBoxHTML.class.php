<?php
require_once 'objetoHTML.class.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of checkBoxHTML
 *
 * @author armcunha
 */
class CheckBoxHTML extends objetoHTML{
    
    private $field;
    private $caption;
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function setField($field){
        $this->field = $field;
    }
    
    public function getField(){
        return $this->field;
    }
    
    public function setCaption($caption){
        $this->caption = $caption;
    }
    
    public function getCaption(){
        return $this->caption;
    }
}

?>
