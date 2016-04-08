<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class TipoARSelectBox {
    const ASMSELECT = "asmselect";
    const MULTISELECT = "multiselect";
}
/**
 * Description of ARCheckBox
 *
 * @author armcunha
 */
class ARSelectBox extends objetoHTML {
    //put your code here
    
    /**
     * Variavel que contém o array de checkBoxHtml;
     * @var ArrayObject 
     */
    private $campo;
    
    var $name;
    var $id;
    var $width;
    var $heigth;
    var $style;
    var $function;
    var $default;
    var $showIniValues;
    var $iniValue;
    var $iniCaption;
    var $selected;
    var $multiSelect;
    var $class;
    var $disable;
    var $gerarScript;
    var $tipoArSelectBox;
    var $size;
    var $label;
    var $require;
    
    public function __construct() {
        parent::__construct();
        $this->campo     = new ArrayObject();
        $this->campo->setFlags(ArrayObject::ARRAY_AS_PROPS);
        $this->gerarScript = true;
    }
    
    /**
     * Função que adiciona o campo para o prenchimento do checkbox.
     * @param CheckBoxHTML $campoHtml
     */
    public function addCampo(CampoHTML $campoHtml){
        $this->campo->append($campoHtml);
    }
    
    protected function obterCampo(){
        return $this->campo;
    }


    protected function inicializarCampos($count=null){
        if(empty($this->name)){
            $this->name = "ARCheckBox_".rand(100, 4000);
        }
        
        if(empty($this->id)){            
            $this->id   = $this->name;
        }
        
        if(empty($this->width)){            
           $this->width = "70"; 
        }
        
        if(empty($this->heigth)){            
           $this->heigth = "20"; 
        }
        
        if(empty($this->style)){            
           $this->style = ""; 
        }
        
        if(empty($this->function)){            
           $this->function = ""; 
        }
        
        if(empty($this->default)){            
           $this->default = $_REQUEST[$this->name]; 
        }
        
        if(empty($this->showIniValues)){            
           $this->showIniValues = true; 
        }
        
        if(empty($this->iniValue)){            
           $this->iniValue = "0"; 
        }
        
        if(empty($this->iniCaption)){            
           $this->iniCaption = "- Selecione -"; 
        }
        
        if(empty($this->selected)){            
           $this->selected = ""; 
        }
        
        if(empty($this->multiSelect)){            
           $this->multiSelect = false; 
        }
         
        if(empty($this->class)){            
           $this->class = "span3"; 
        }
        
        if(empty($this->disable)){            
           $this->disable = false; 
        }
        
        if(empty($size)){
           $this->size = "1";  
        }
        
        if(empty($this->tipoArSelectBox)){            
           $this->tipoArSelectBox = TipoARSelectBox::MULTISELECT;
        }
        
        if($this->multiSelect == true && $this->gerarScript == true){
            
            $jsAsmSelect  = "";
            if ($this->tipoArSelectBox == TipoARSelectBox::ASMSELECT){
                $jsAsmSelect  .= "\r\n"."<script src=\"bibliotecas/javascript/asmselect/jquery.asmselect.js\" type=\"text/javascript\"></script>";
                $jsAsmSelect  .= "\r\n"."<link rel=\"stylesheet\" href=\"bibliotecas/javascript/asmselect/jquery.asmselect.css\" />";
            }else{
                if ($this->tipoArSelectBox == TipoARSelectBox::MULTISELECT){
                    $jsAsmSelect  .= "\r\n"."<script src=\"bibliotecas/javascript/jquery.multselect/jquery.multiselect.js\" type=\"text/javascript\"></script>";
                    $jsAsmSelect  .= "\r\n"."<script src=\"bibliotecas/javascript/jquery.multselect/jquery.multiselect.br.js\" type=\"text/javascript\"></script>";
                    $jsAsmSelect  .= "\r\n"."<link rel=\"stylesheet\" href=\"bibliotecas/javascript/jquery.multselect/jquery.multiselect.css\" />";
                }
            }
            //echo $jsAsmSelect;
            
            $jsAsmSelect = "\r\n"."<script type=\"text/javascript\">"."\r\n"." $(document).ready(function() {"."\r\n"."";
            if ($this->tipoArSelectBox == TipoARSelectBox::ASMSELECT){
                $jsAsmSelect .= "    $(\"#{$this->id}\").asmSelect({"."\r\n".				
                                    "      animate: true,"."\r\n".
                                    "      highlight: true,"."\r\n".
                                    "      sortable: true,"."\r\n".
                                    "      removeLabel: 'Excluir',"."\r\n".
                                    "      highlightAddedLabel: 'Incluir: ',//Text that precedes highlight of added item"."\r\n".
                                    "      highlightRemovedLabel: 'Remover: ',"."\r\n".
                                    "      selectClass: '{$this->class}'"."\r\n".
                            "     }); "."\r\n".
                        " });"."\r\n".   
                        "</script>"."\r\n";
                
            }else{
                 if ($this->tipoArSelectBox == TipoARSelectBox::MULTISELECT){
                    if (is_null($count)){
                       $count = $this->campo->count(); 
                    } 
                    $jsAsmSelect .= " $(\"#$this->id\").multiselect({"."\r\n".
                                            "selectedList: {$count}"."\r\n".
                                       "});"."\r\n".
                                       
                            "});"."\r\n".   
                            "</script>"."\r\n";                    
                 }
            }
            
            echo $jsAsmSelect;
        }
        
    }
    
    public function bind(){
       $this->inicializarCampos();
       $combo = "";
       if($this->multiSelect){
           $combo = $this->gerarComboMultiSelect();
       }else{
           $combo = $this->gerarCombo();
       } 
       
       return $combo;
    }
    
    private function gerarCombo(){
       $combo  = "\r\n"." <div class=\"control-group\"> ";
       $combo .= "\r\n"."       <label class=\"control-label\" for=\"{$this->id}\">{$this->label}:</label>";
       $combo .= "\r\n"." <div class=\"controls\"> ";
       if($this->obterCampo()->count() > 0){
           $desabilitar = "";
           if ($this->disable)
               $desabilitar = "disabled=\"disabled\"";
           $required = "";

           if($this->require){
           	$required = " required=\"true\" ";
           }
               
           $combo .= "\r\n"."   <select id=\"{$this->id}\" {$desabilitar} name=\"{$this->name}\" {$this->function} class=\"{$this->class}\" style=\"{$this->style}\" size=\"{$this->size}\" {$required}>";
           if ($this->showIniValues){
               $combo .= "\r\n"."      <option value=\"{$this->iniValue}\"> {$this->iniCaption} </option>";
           }
           $campo = new CampoHTML();
           foreach ($this->obterCampo()->getIterator() as $campo) {
               if ($campo->getField() == $this->default)                   
                   $selecionado = "selected";
               else
                   $selecionado = "";
               $combo .= "\r\n"."      <option value=\"{$campo->getField()}\" {$selecionado} style=\"{$campo->getStyle()}\"> {$campo->getFieldCaption()} </option>";  
           }
           $combo .= "\r\n"."   </select>";
           $combo .= "\r\n"." </div>";
           $combo .= "\r\n"." </div>";
       }
       
       return $combo;
    }
    
    private function gerarComboMultiSelect(){
       $div_dados_selecionados =  "<div>";
       $combo  = "\r\n"." <div class=\"control-group\"> ";
       $combo .= "\r\n"." <label class=\"control-label\" for=\"{$this->id}\">{$this->label}:</label>";
       $combo .= "\r\n"." <div class=\"controls\"> ";
       if($this->obterCampo()->count() > 0){
            $desabilitar = "";
           if ($this->disable)
               $$desabilitar = "disabled=\"disabled\"";
           
           $combo .= "\r\n"."<select id=\"{$this->id}\" {$desabilitar} name=\"{$this->name}[]\" multiple=\"multiple\" {$this->function} title=\"{$this->iniCaption}\" class=\"{$this->class}\" style=\"{$this->style}\">";
           //$combo = "<select id=\"{$this->id}\" {$desabilitar} name=\"{$this->name}[]\" multiple=\"multiple\" {$this->function} style=\"{$this->style}\">";
           
           $campo = new CampoHTML();
           foreach ($this->obterCampo()->getIterator() as $campo) {
               $combo .= "\r\n"."<option value=\"{$campo->getField()}\"> {$campo->getFieldCaption()} </option>";  
           }
           $combo .= "\r\n"."</select>";
       }
       $combo .= "\r\n"." </div>";
       $combo .= "\r\n"." </div>";
       $div_dados_selecionados .= $combo."</div>"."\r\n"."<br />"."\r\n"." <div id=\"dados_selecionados_text\">"."\r\n"." </div>";
       
       return $div_dados_selecionados;
    }
    
}

?>