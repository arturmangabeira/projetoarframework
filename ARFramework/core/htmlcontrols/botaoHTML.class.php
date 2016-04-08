<?php
require_once 'objetoHTML.class.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of botaDTO
 *
 * @author armcunha
 */
class botaoHTML extends objetoHTML{
    
    private $action = "action";
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function setAction($action){
        $this->action = $action;
    }
    
    public function getAction(){
        return $this->action;
    }

}

?>
