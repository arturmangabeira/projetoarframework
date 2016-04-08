<?php

   //require_once 'config.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ARTableClass{
    const CONDESED = "table table-condensed";
    const CONDESED_HOVER = "table table-condensed table-hover";
}

class ARTableRow{
    private $row;
    var $id;
    var $rowspan;
    var $class;
    var $style;
    
    public function __construct() {
        $this->row     = new ArrayObject();
        $this->row->setFlags(ArrayObject::ARRAY_AS_PROPS);        
    }
    
    public function addTableCollum($ArTableCollum){
        if($ArTableCollum instanceof ARTableCollum){
            $this->row->append($ArTableCollum);
        }else{
            throw new Exception("O objeto esperado deve ser do tipo ARTableCollum");
        }
    }
    
    public function obterTableCollums(){
        return $this->row;
    }
}

class ARTableCollum{
    /**
     *
     * @var objetoHTML 
     */
    private $collum;
    var $id;
    var $colspan;
    var $class;
    var $style;
    
    public function __construct() {
        
    }
    
    /**
     * Constroe a tabela a partir da coluna.
     * @param objetoHTML $objetHtml
     * @throws Exception
     */
    public function addCollum($objetoHtml){
        if($objetoHtml instanceof objetoHTML){
            $this->collum = $objetoHtml;
        }else{
            throw new Exception("O objeto esperado deve ser do tipo objetoHtml");
        }
    }
    
    /**
     * 
     * @return objetoHTML
     */
    public function obterCollum(){
        return $this->collum;
    }
    
    
}
/**
 * Description of ARTable
 *
 * @author arturmangabeira
 */
class ARTable extends objetoHTML{
    //put your code here
    //put your code here
    
    var $name;
    var $id;
    var $width;
    var $heigth;
    var $style;
        
    /**
     * Variavel que contém os tipos das classes disponíveis para a table
     * @var ARTableClass $TipoClassARTable
     */
    var $TipoClassARTable;
    
    /**
     * Variavel que contem um array de ARTableCollum
     * @var ArrayObject $row
     */
    private $row;
    
    /**
     * Variavel que contem um array de ARTableCollum
     * @var ArrayObject $header
     */
    private $header;
    
    /**
     * Variavel que contem um array de ARTableCollum
     * @var ArrayObject $footer
     */
    private $footer;
    
    function __construct() {        
        
        $this->header     = new ArrayObject();
        $this->header->setFlags(ArrayObject::ARRAY_AS_PROPS);
        $this->row       = new ArrayObject();
        $this->row->setFlags(ArrayObject::ARRAY_AS_PROPS);
        $this->footer       = new ArrayObject();
        $this->footer->setFlags(ArrayObject::ARRAY_AS_PROPS);
    }
    
    
    public function addTableRow($ArTableRow){
        if($ArTableRow instanceof ARTableRow){
            $this->row->append($ArTableRow);
        }else{
            throw new Exception("Esperado um objeto que herde de ARTableRow");
        }
    }
    
    public function addTableHeader($ArTableRow){
        if($ArTableRow instanceof ARTableRow){
            $this->header->append($ArTableRow);
        }else{
            throw new Exception("Esperado um objeto que herde de ARTableRow");
        }
    }
    
    public function addTableFooter($ArTableRow){
        if($ArTableRow instanceof ARTableRow){
            $this->footer->append($ArTableRow);
        }else{
            throw new Exception("Esperado um objeto que herde de ARTableRow");
        }
    }
    
    protected function inicializarCampos(){
        if(empty($this->name)){
            $this->name = "ARTable_".rand(100, 4000);;
        }
        
        if(empty($this->id)){            
            $this->id = $this->name;
        }
        
        if(empty($this->TipoClassARTable)){
            $this->TipoClassARTable = ARTableClass::CONDESED;
        }
        
        if(empty($this->width)){            
           $this->width     = "700"; 
        }
        
        if(empty($this->heigth)){            
           $this->heigth     = "200"; 
        }
        
        if(empty($this->style)){            
           $this->style     = ""; 
        }
               
        if(empty($this->userPage)){            
           $this->userPage     = Config::DEFINE_USER_PAGE_GRID_TRUE;
        }
        
        if(empty($this->rowNum)){            
           $this->rowNum     = "10";
        }
        
        if(empty($this->idField)){
            $this->idField = "id";
        }
    }
    
    public function bind(){
        $this->inicializarCampos();
        $strgrid = "<div class=\"row\" >
                        <div class=\"span12\" >";
        
        if(!empty($this->style))
            $style  ="style=\"{$this->style}\"";
            
        $strgrid .= "   <table class=\"{$this->TipoClassARTable}\" id=\"{$this->id}\" name=\"{$this->name}\" {$style} width=\"{$this->width}\" heigth=\"{$this->heigth}\">";
        $this->bindHeadTable($strgrid);
        $this->bindBodyTable($strgrid);
        $this->bindFooterTable($strgrid);
        $strgrid .= "   </table>";
        $strgrid .= "
                        </div>
                    </div>";
        
        return $strgrid;
    }
    
    /**
     * Monta as colunas da table de acordo com as colunas que são passadas para 
     * o método addCollums
     * @return string
     */ 
    private function bindHeadTable(&$strgrid){
       if ($this->header->count() > 0){
           $strgrid .= "<thead> ";
           $arRow = new ARTableRow;
           foreach ($this->header as $arRow) {
                if(!empty($arRow->id))
                    $id = "id=\"{$arRow->id}\"";
                if(!empty($arRow->class))    
                    $class ="class=\"{$arRow->class}\"";
                if(!empty($arRow->style))
                    $style  ="style=\"{$arRow->style}\"";
                if(!empty($arRow->colspan))
                    $rowspan = "rowspan=\"{$arRow->rowspan}\"";
               $strgrid .= "<tr {$id} {$class} {$style} {$rowspan} >";
               $arCollumHead = new ARTableCollum();
               foreach ($arRow->obterTableCollums() as $arCollumHead) {
                        if(!empty($arCollumHead->id))
                            $id = "id=\"{$arCollumHead->id}\"";
                        if(!empty($arCollumHead->class))    
                            $class ="class=\"{$arCollumHead->class}\"";
                        if(!empty($arCollumHead->style))
                            $style  ="style=\"{$arCollumHead->style}\"";
                        if(!empty($arCollumHead->colspan))
                            $cowspan = "colspan=\"{$arCollumHead->colspan}\"";
                        $strgrid .= "<th {$id} {$class} {$style} {$cowspan} >
                            {$arCollumHead->obterCollum()->bind()}
                            </th>";
               }
               $strgrid .= "</tr>";
           }
           $strgrid .= " </thead>";
        }else{
            $strgrid .= "";
        }  
    }
    
    private function bindBodyTable(&$strgrid){
        if ($this->row->count() > 0){
           $strgrid .= "<tbody> ";
           $arRow = new ARTableRow;
           foreach ($this->row as $arRow) {
                if(!empty($arRow->id))
                    $id = "id=\"{$arRow->id}\"";
                if(!empty($arRow->class))    
                    $class ="class=\"{$arRow->class}\"";
                if(!empty($arRow->style))
                    $style  ="style=\"{$arRow->style}\"";
                if(!empty($arRow->colspan))
                    $rowspan = "rowspan=\"{$arRow->rowspan}\"";
               $strgrid .= "<tr {$id} {$class} {$style} {$rowspan} >";
               $arCollumHead = new ARTableCollum();
               foreach ($arRow->obterTableCollums() as $arCollumHead) {
                        if(!empty($arCollumHead->id))
                            $id = "id=\"{$arCollumHead->id}\"";
                        if(!empty($arCollumHead->class))    
                            $class ="class=\"{$arCollumHead->class}\"";
                        if(!empty($arCollumHead->style))
                            $style  ="style=\"{$arCollumHead->style}\"";
                        if(!empty($arCollumHead->colspan))
                            $cowspan = "colspan=\"{$arCollumHead->colspan}\"";
                        $strgrid .= "<td {$id} {$class} {$style} {$cowspan} >
                            {$arCollumHead->obterCollum()->bind()}
                            </td>";
               }
               $strgrid .= "</tr>";
           }
           $strgrid .= " </tbody>";
        }else{
            $strgrid .= "";
        }  
    }
    
    private function bindFooterTable(&$strgrid){
        if ($this->footer->count() > 0){
           $strgrid .= "<tfoot> ";
           $arRow = new ARTableRow;
           foreach ($this->footer as $arRow) {
                if(!empty($arRow->id))
                    $id = "id=\"{$arRow->id}\"";
                if(!empty($arRow->class))    
                    $class ="class=\"{$arRow->class}\"";
                if(!empty($arRow->style))
                    $style  ="style=\"{$arRow->style}\"";
                if(!empty($arRow->colspan))
                    $rowspan = "rowspan=\"{$arRow->rowspan}\"";
               $strgrid .= "<tr {$id} {$class} {$style} {$rowspan} >";
               $arCollumHead = new ARTableCollum();
               foreach ($arRow->obterTableCollums() as $arCollumHead) {
                        if(!empty($arCollumHead->id))
                            $id = "id=\"{$arCollumHead->id}\"";
                        if(!empty($arCollumHead->class))    
                            $class ="class=\"{$arCollumHead->class}\"";
                        if(!empty($arCollumHead->style))
                            $style  ="style=\"{$arCollumHead->style}\"";
                        if(!empty($arCollumHead->colspan))
                            $cowspan = "colspan=\"{$arCollumHead->colspan}\"";
                        $strgrid .= "<td {$id} {$class} {$style} {$cowspan} >
                            {$arCollumHead->obterCollum()->bind()}
                            </td>";
               }
               $strgrid .= "</tr>";
           }
           $strgrid .= " </tfoot>";
        }else{
            $strgrid .= "";
        }  
    }
    
}

?>
