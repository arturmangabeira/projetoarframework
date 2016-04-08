<?php
require_once 'textHTML.class.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of linkHTML
 *
 * @author armcunha
 */
class linkHTML extends textHTML {
    
    private $href;
    private $param;
    private $action;
    private $caption;
    private $modal;
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->setModal(false);
    }
    
    public function setHref($href){
        $this->href = $href;
    }
    
    public function getHref(){
        return $this->href;
    }
    
    public function setAction($action){
        $this->action = $action;
    }
    
    public function getAction(){
        return $this->action;
    }
    
    public function setCaption($caption){
        $this->caption = $caption;
    }
    
    public function getCaption(){
        return $this->caption;
    }
    
    public function setParam($param){
        $this->param = $param;
    }
    
    public function getParam(){
        return $this->param;
    }
    
    public function setModal($param){
        $this->modal = $param;
    }
    
    public function getModal(){
        return $this->modal;
    }

}

?>
