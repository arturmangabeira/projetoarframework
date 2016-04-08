<?php
require_once 'eventsHTML.class.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of objetoHTML
 *
 * @author armcunha
 */
class objetoHTML extends eventsHTML{
    //put your code here
    private $name;
    private $id;
    private $value;
    private $width;
    private $style;
    private $cor;    
    private $class;
    private $align;
    
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function setName($name){
        $this->name = $name;
    }
    
    public function getName(){
        return $this->name;
    }
    
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function setValue($value){
        $this->value = $value;
    }
    
    public function getValue(){
        return $this->value;
    }
    
    public function setWidth($width){
        $this->width = $width;
    }
    
    public function getWidth(){
        return $this->width;
    }
    
    public function setStyle($width){
        $this->width = $width;
    }
    
    public function getStyle(){
        return $this->width;
    }
    
    public function setCor($cor){
        $this->cor = $cor;
    }
    
    public function getCor(){
        return $this->cor;
    }
    
    public function setClass($class){
        $this->class = $class;
    }
    
    public function getClass(){
        return $this->class;
    }
    
    public function setAlign($align){
        $this->align = $align;
    }
    
    public function getAlign(){
        return $this->align;
    }
    
    public function bind(){}
    
}    

?>
