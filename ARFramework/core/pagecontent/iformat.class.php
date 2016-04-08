<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IFormat
 *
 * @author artur
 */
interface IFormat {
    //put your code here
     /**
      * Funcao que deve retornar um objetoHtml;
      */
     public function generateFormat($field,$arrayField);
}

?>
