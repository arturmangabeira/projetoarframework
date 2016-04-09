<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ARBootstrap
 *
 * @author Artur
 */
class ARBootstrap {
        
    private static $arrClassTextBox = array(2 => array("PADRAO" => "",
                                                         "SELECT" => "input-medium search-query",
                                                         "MINI" => "input-mini",
                                                         "SMALL" => "input-small",
                                                         "MEDIUM" => "input-medium",
                                                         "LARGE" => "input-large",
                                                         "XLARGE" => "input-xlarge",
                                                         "XXLARGE" => "input-xxlarge"),
                                            3 => array("PADRAO" => "col-xs-3",
                                                         "SELECT" => "col-xs-3",
                                                         "MINI" => "col-xs-1",
                                                         "SMALL" => "col-xs-2",
                                                         "MEDIUM" => "col-xs-3",
                                                         "LARGE" => "col-xs-4",
                                                         "XLARGE" => "col-xs-5",
                                                         "XXLARGE" => "col-xs-6"));
    
    private static $arrClassSelectBox =  array(2 => array("PADRAO" => "",
                                                         "SELECT" => "input-medium search-query",
                                                         "MINI" => "input-mini",
                                                         "SMALL" => "input-small",
                                                         "MEDIUM" => "input-medium",
                                                         "LARGE" => "input-large",
                                                         "XLARGE" => "input-xlarge",
                                                         "XXLARGE" => "input-xxlarge"),
                                            3 => array("PADRAO" => "col-xs-3",
                                                         "SELECT" => "col-xs-3",
                                                         "MINI" => "col-xs-1",
                                                         "SMALL" => "col-xs-2",
                                                         "MEDIUM" => "col-xs-3",
                                                         "LARGE" => "col-xs-4",
                                                         "XLARGE" => "col-xs-5",
                                                         "XXLARGE" => "col-xs-6"));
    
    static function obterClassBootStrap($objHtml,$classElement){
        if($objHtml instanceof ARTextBox){            
            return self::$arrClassTextBox[Config::VERSAO_BOOTSTRAP][$classElement];
        }
        
        if($objHtml instanceof ARSelectBox){
            return self::$arrClassSelectBox[Config::VERSAO_BOOTSTRAP][$classElement];
        }
    }
    
    
}
