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
class ARTabs extends objetoHTML{
    
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
            $this->name = "ARTabs_".rand(100, 4000);
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
     * Adiciona a os ites html ao tab.
     * @param string $titulo
     * @param objetoHTML $itemHtml
     */
    public function addTab($titulo, $itemHtml){
        if($itemHtml instanceof objetoHTML){
            $this->title->append($titulo);
            $this->campo->append($itemHtml);
        }else{
            throw new Exception("O objeto deve herdar de ObjetoHTML!");
        }
    }
    
    /**
     * Adiciona a os ites html ao tab.
     * @param string $titulo
     * @param string $enderecoPagina
     */
    public function addTabAjax($titulo, $enderecoPagina){
        if(!empty($enderecoPagina)){
            $this->title->append($titulo);
            $this->campoAjax->append($enderecoPagina);
        }else{
            throw new Exception("Favor informar a página para renderizar na aba com ajax!");
        }
    }
    
    public function bind() {
        $this->inicializarCampos();
        if($this->obterCampoAjax()->count() >0){ 
            return $this->gerarScripts()."\r\n"."\r\n".$this->gerarTabsAjax();
        }else{
            return $this->gerarScripts()."\r\n"."\r\n".$this->gerarTabs();
        }
    }
    
    private function gerarScripts(){
        $script = " <script type=\"text/javascript\">
                        $(function() {
                            $( \"#{$this->id}\" ).tabs({ active: {$this->active} });
                            
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
    
    private function gerarTabs(){
       $tabs = "\r\n"." <div id=\"{$this->id}\" name=\"{$this->name}\" style=\"$this->style\">";
       $tabs .= "\r\n"."   <ul>";
       $tabsCount = 1;
       foreach ($this->obterTitulo()->getIterator() as $titulo) {
           $tabs .= "\r\n"."    <li> <a href=\"#tab_{$tabsCount}\">  {$titulo} </a> </li>";
           $tabsCount++;
       }
       $tabs .= "\r\n"."   </ul>";
       
       $tabsCount = 1;
       //Adiciona os objetoHTML
       foreach ($this->obterCampo()->getIterator() as $campo) {
            $tabs .= "\r\n"."   <div id=\"tab_{$tabsCount}\">";
            $method = new ReflectionMethod(get_class($campo), "bind");
            $value = $method->invoke($campo);
            $tabs .= $value."\r\n";
            $tabs .= "\r\n"."   </div>";
            $tabsCount++;
       }
       
       $tabs .= "\r\n"." </div> ";
       
       return $tabs;
    }
    
    private function gerarTabsAjax(){
       $tabs = "\r\n"." <div id=\"{$this->id}\" name=\"{$this->name}\" style=\"$this->style\">";
       $tabs .= "\r\n"."   <ul>";
       $tabsCount = 1;
       foreach ($this->obterTitulo()->getIterator() as $titulo) {
           $tabs .= "\r\n"."    <li> <a href=\"#tab_{$tabsCount}\" id=\"lnk_{$tabsCount}\">  {$titulo} </a> </li>";
           $tabsCount++;
       }
       $tabs .= "\r\n"."   </ul>";
       
       $tabsCount = 1;
       //Adiciona os objetoHTML
       foreach ($this->obterCampoAjax()->getIterator() as $url) {
            $tabs .= "\r\n"."   <div id=\"tab_{$tabsCount}\">";
            $tabs .= "\r\n"."   </div>";
            $script = "
                        <script type=\"text/javascript\">
                          $(document).ready(function() {  
                            $('#lnk_{$tabsCount}').click(function(){
                                //alert('testes');
                                executarAjaxAba('tab_{$tabsCount}','{$url}');
                            });
                         });   
                        </script>";
            $tabs .= $script;    
                            
                            
            $tabsCount++;
       }
       
       //Adiciona os objetoHTML
       foreach ($this->obterCampo()->getIterator() as $campo) {
            $tabs .= "\r\n"."   <div id=\"tab_{$tabsCount}\">";
            $method = new ReflectionMethod(get_class($campo), "bind");
            $value = $method->invoke($campo);
            $tabs .= $value."\r\n";
            $tabs .= "\r\n"."   </div>";
            $tabsCount++;
       }
       
       $scriptExec = "
                <script type=\"text/javascript\">
                  $(document).ready(function() {  
                    var idAba = {$this->active} +1;    
                    $('#lnk_'+idAba).click(); 
                 });   
                </script>";
       
       $tabs .= "\r\n"." </div> ";
       
       $tabs .= $scriptExec;
       
       return $tabs;
    }
}

?>
