<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ARTabs
 *
 * @author artur
 */
class ARAccordion extends objetoHTML{
    
    /**
     * Variavel que contém o array de objetoHTML;
     * @var ArrayObject 
     */
    private $campo;
    /**
     * Variavel que contém o array de objetoHTML;
     * @var ArrayObject 
     */
    private $campoAjax;
    /**
     * Variavel que contém o array de string;
     * @var ArrayObject 
     */
    private $title;
    
    public $id;
    public $name;
    public $style;
    public $active;
    
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->campo     = new ArrayObject();
        $this->campo->setFlags(ArrayObject::ARRAY_AS_PROPS);
        
        $this->campoAjax     = new ArrayObject();
        $this->campoAjax->setFlags(ArrayObject::ARRAY_AS_PROPS);
        
        $this->title     = new ArrayObject();
        $this->title->setFlags(ArrayObject::ARRAY_AS_PROPS);
    }
    
    protected function inicializarCampos(){
        if(empty($this->name)){
            $this->name = "ARAccordion_".rand(100, 4000);
        }
        
        if(empty($this->id)){            
            $this->id  = $this->name;
        }
        
        if(empty($this->style)){            
           $this->style = ""; 
        }
        
        if(empty($this->active)){            
           $this->active = 0; 
        }
    }
    
    private function obterCampo(){
        return $this->campo;
    }
    
    private function obterCampoAjax(){
        return $this->campoAjax;
    }
    
    private function obterTitulo(){
        return $this->title;
    }
    
    /**
     * Adiciona a os ites html ao Section.
     * @param string $titulo
     * @param objetoHTML $itemHtml
     */
    public function addSection($titulo, $itemHtml=null,$ajax=false,$enderecoPagina=""){
        if($itemHtml instanceof objetoHTML){
            $array = array("titulo" => $titulo, "itemHtml" => $itemHtml,"ajax" => $ajax,"endereco" => $enderecoPagina);
            $this->campo->append($array);
        }else{
             if(is_null($itemHtml)){
                 $array = array("titulo" => $titulo, "itemHtml" => $itemHtml,"ajax" => $ajax,"endereco" => $enderecoPagina);
                 $this->campo->append($array);
             }else{ 
                throw new Exception("O objeto deve herdar de ObjetoHTML!");
             }
        }
    }
    
    public function bind() {
        $this->inicializarCampos();
        if($this->obterCampoAjax()->count() >0){ 
            return $this->gerarScripts()."\r\n"."\r\n".$this->gerarTabsAjax();
        }else{
            return $this->gerarScripts()."\r\n"."\r\n".$this->gerarSections();
        }
    }
    
    private function gerarScripts(){
        $script = " <script type=\"text/javascript\">
                        $(function() {
                            $( \"#{$this->id}\" ).accordion();
                            
                        });
                    </script>";

        if($this->obterCampoAjax()->count() >0){                        
            $scriptAjax = "
                           <script type=\"text/javascript\">
                                function executarAjaxAba(idAba,Purl) { 
                                    $('#'+idAba).html('Carregando aguarde...');
                                    $.ajax({
                                            url: Purl,
                                            type: \"POST\",                                            
                                            success: function(result) {
                                                //Write your code here
                                                $('#'+idAba).html(result);
                                            }
                                    });
                                }; 
                           </script> "; 
            
           $script .=  $scriptAjax;
        }
        return $script;                    
    }
    
    private function gerarSections(){
       $tabs = "\r\n"." <div id=\"{$this->id}\" name=\"{$this->name}\" style=\"$this->style\">";
       
       $tabsCount = 1;
       //Adiciona os objetoHTML
       //die(var_dump($this->obterCampo()));
       foreach ($this->obterCampo()->getIterator() as $campo) {
            $tabs .= "\r\n"."   <h3> {$campo['titulo']} </h3>";
            $tabs .= "\r\n"."   <div id=\"tab_{$tabsCount}\"> 
                                    <p>";
            if(!is_null($campo["itemHtml"])){
                $method = new ReflectionMethod(get_class($campo["itemHtml"]), "bind");
                $value = $method->invoke($campo["itemHtml"]);
                $tabs .= $value."\r\n";
            }
            $tabs .= "\r\n"."       </p>
                </div>";
            $tabsCount++;
       }
       
       $tabs .= "\r\n"." </div> ";
       
       return $tabs;
    }
    
}

?>
