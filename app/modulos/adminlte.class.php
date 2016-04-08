<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author artur
 */
class AdminLTE extends Page {
    //put your code here
    private $cpt;
    private $admUi;
    public function __construct() {
        parent::__construct();
        $this->admUi = new AdminUI();
    }
    
    public function generatePage($args) {           	
        
    }          
}

?>
