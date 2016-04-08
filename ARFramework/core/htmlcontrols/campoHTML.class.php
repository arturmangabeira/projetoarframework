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
class CampoHTML extends objetoHTML{
    
    private $field;
    private $fieldCaption;
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
    
    public function setFieldCaption($caption){
        $this->fieldCaption = $caption;
    }
    
    public function getFieldCaption(){
        return $this->fieldCaption;
    }
}

?>
