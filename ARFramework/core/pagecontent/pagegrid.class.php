<?php
include_once 'page.class.php';
require_once 'ARFramework/core/arcontrols/contents/ARGrid.class.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pagegrid
 *
 * @author artur
 */
class PageGrid extends Page{
    //put your code here
    public function __construct() {
        parent::__construct();
        parent::addScriptRel("ARFramework/lib/javascript/jquery.jqGrid-4.4.4/js/jquery.jqGrid.src.js");	
        parent::addScriptRel("ARFramework/lib/javascript/jquery.jqGrid-4.4.4/js/grid.locale-pt-br.js");	
        parent::addScriptCssRel("ARFramework/lib/javascript/jquery.jqGrid-4.4.4/css/ui.jqgrid.css");
        
    }
    
    public function datasource(){
        return null;
    }
    
    public function gerarXML(ArrayObject $dataSource){
            $count = $dataSource->count();
            if($count > 0){
                $dados_iniciais = new GenericDTO();
                $dados_iniciais = $dataSource->getIterator()->current();

                header("Content-type: text/xml");
                $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
                $xml .= "<rows>";

                $xml .= "<page>{$dados_iniciais->getPage()}</page>";

                if ($count > 0) {
                    $total_pages = ceil($count / $dados_iniciais->getItenPerPage());
                } else {
                    $total_pages = 0;
                }
                
                if ($dados_iniciais->getPage() == null) 
                    $page = 1;
                else
                    $page = $dados_iniciais->getPage();

                if ($dados_iniciais->getItenPerPage() != null) 
                    $rp = $dados_iniciais->getItenPerPage();

                $start = (($page-1) * $rp);
                
                $xml .= "<total>{$total_pages}</total>";
                $xml .= "<records>{$count}</records>";
                $countReg = 0;
                foreach ($dataSource->getIterator() as $key => $genericDto) {
                    //Efetua o cálculo da paginação sem utilizar limit da consulta.
                    if($key >= $start && $countReg <= $rp ){
                        $countReg++;
                        $class = new ReflectionClass(get_class($genericDto));

                        $properties = $class->getProperties(ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC);

                        if (!is_null($properties)) {

                            $method = new ReflectionMethod(get_class($genericDto), "get" . ucfirst($dados_iniciais->getIdField()));
                            $valor = $method->invoke($genericDto);

                            $xml .= "<row>";

                            $xml .= "<id>".$valor. "</id>";

                            foreach ($properties as $prop) {
                                $propName = $prop->getName();

                                $method = new ReflectionMethod(get_class($genericDto), "get" . ucfirst($propName));
                                $valor = $method->invoke($genericDto);

                                if(!is_null($valor)){
                                    $xml .= "<{$propName}><![CDATA[" . html_entity_decode($valor) . "]]></{$propName}>";
                                }

                            }
                            $xml .= "</row>";
                        }
                    }
                }
                $xml .= "</rows>";
            }

            return new ARTextHml($xml);
    }
}

?>
