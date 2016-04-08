<?php
/**
 * Description of ARTextBox
 *
 * @author artur
 */

class TipoARTextBox{
    const NUMBER = "numero";
    const DATETIME = "datetime";
    const DATETIME_YEAR = "datetimeyear";
    const DATETIME_MONTH_YEAR = "datetimemonthyear";
    const PASSWORD = "password";
    const FILE = "file";
    const TEXT = "text";
    const HIDDEN = "hidden"; 
}

class TipoARTextBoxMask{
    const MONETARIO = "numero";
    const CPF = "cpf";
    const CPNJ = "cnpj";
    const CPF_CNPJ = "cpf_cnpj";
    const TELEFONE = "telefone";
    const CUSTOM = "custom";
}

class TipoARTextBoxClass{
    const PADRAO = "PADRAO";
    const SELECT = "SELECT";
    const MINI = "MINI";
    const SMALL = "SMALL";
    const MEDIUM = "MEDIUM";
    const LARGE = "LARGE";
    const XLARGE= "XLARGE";
    const XXLARGE = "XXLARGE";
}

class ARTextBox extends objetoHTML {
    //put your code here
    
    private static $instancias;
    var $name;
    var $id;
    var $width;
    var $heigth;
    var $style;
    var $function;
    var $default;
    var $disable;
    var $showIniValues;
    var $iniValue;
    var $iniCaption;
    var $maxLength;
    var $bootStrap;
    var $label;
    var $placeholder;
    var $size;
    var $require;
    /**
     * Variavel do tipo TipoARTextBoxClass
     * @var TipoARTextBoxClass 
     */
    var $typeClassTextBox;
    /**
     * Define o tipo da variável ARTextBox
     * @var TipoARTextBox 
     */    
    var $typeARTextBox;
    
    /**
     *Define o tipo da variável TipoARTextBoxMask
     * @var TipoARTextBoxMask
     */
    var $typeARTextBoxMask;
    private $mask;
    
    public function __construct() {
        parent::__construct();
        self::$instancias++;
    }

    protected function inicializarCampos(){
        if(empty($this->name)){
            $this->name = "ARTextBox_".rand(100, 4000);
        }
        
        if(empty($this->id)){            
            $this->id  = $this->name;
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
           $this->default = $_REQUEST["{$this->name}"]; 
        }
        
        if(empty($this->showIniValues)){            
           $this->showIniValues = true; 
        }
        
        if(empty($this->iniValue)){            
           $this->iniValue = ""; 
        }
        
        if($this->getClass() == null){            
           $this->setClass("inputBig");
        }
        
        if(empty($this->iniCaption)){            
           $this->iniCaption = "Campo nome ".$this->name; 
        }
        
        if(empty($this->typeARTextBox)){
            $this->typeARTextBox = TipoARTextBox::TEXT;
        }
        
        if(empty($this->typeClassTextBox)){
            $this->typeClassTextBox = TipoARTextBoxClass::PADRAO;
        }
        
        if($this->disable){
            $this->disable = "disabled";
        }
        
        if($this->bootStrap == false ){
        	$this->bootStrap = false;
        }else{
        	$this->bootStrap = true;
        }
       
    }
    
    public function bind(){
        $this->inicializarCampos();
        return $this->scriptsTextBox()."   ".$this->gerarTextBox();
    }
    
    private function scriptsTextBox(){
    	
    	
               
        $js = "<script type=\"text/javascript\">
                    $(document).ready(function() {
                        
                    ";
    	
    	
        if($this->typeARTextBoxMask == TipoARTextBoxMask::MONETARIO){
            
            $js .= "
                    $(\"#{$this->id}\").maskMoney({decimal:','});
                        if($(\"#{$this->id}\").val() != \"\"){
                            valor  = $(\"#{$this->id}\").val();
                            $(\"#{$this->id}\").val(valor.split('.')[0]+"."+valor.split('.')[1].slice(0,2));
                            $(\"#{$this->id}\").maskMoney('mask');
                        }
                ";
        }else{
            
            if($this->typeARTextBoxMask == TipoARTextBoxMask::CPF){
                    $js .= "
                            $(\"#{$this->id}\").mask(\"999.999.999-99\");
                        ";
            }else{
                if($this->typeARTextBoxMask == TipoARTextBoxMask::CPNJ){
                    $js .= "
                            $(\"#{$this->id}\").mask(\"99.999.999/9999-99\");
                        ";
                }else{
                    if($this->typeARTextBoxMask == TipoARTextBoxMask::TELEFONE){
                        $js .= "
                            $(\"#{$this->id}\").mask(\"(99)9999-9999\");
                        ";
                    }else{
                        if($this->typeARTextBoxMask == TipoARTextBoxMask::CUSTOM){
                            $js .= "
                                $(\"#{$this->id}\").mask(\"{$this->getMask()}\");
                            ";
                        }else{
                            if($this->typeARTextBoxMask == TipoARTextBoxMask::CPF_CNPJ){
                                $js .= "
                                    $(\"#{$this->id}\").keypress(function(event){
                                       var tecla = (window.event) ? event.keyCode : event.which;
                                        if ((tecla > 47 && tecla < 58)) cpfcnpj(document.getElementById('{$this->id}'));
                                        else {
                                            if (tecla != 8) return false;
                                            else return true;
                                        }
                                        
                                        
                                    });
                                    $(\"#{$this->id}\").blur(function(event){
                                        cpfcnpj(document.getElementById('{$this->id}'));
                                    });    
                                ";
                            }
                        }
                    }    
                }
            }
        }
        
        if($this->typeARTextBox == TipoARTextBox::DATETIME){
                        
            $js .= "
                $(\"#{$this->id}\").datepicker();
            ";
        }else{
            //{ altFormat: "yy-mm-dd" }
            if($this->typeARTextBox == TipoARTextBox::DATETIME_YEAR){
                $js .= "
                    $(\"#{$this->id}\").datepicker({ 
                        dateFormat: \"yy\",
                        changeYear: true
                    });
                ";
            }else{
                if($this->typeARTextBox == TipoARTextBox::DATETIME_MONTH_YEAR){
                $js .= "
                    $(\"#{$this->id}\").datepicker({ 
                        dateFormat: \"mm/yy\",
                        changeYear: true
                    });
                ";
            }else{
                    if($this->typeARTextBox == TipoARTextBox::NUMBER){
                        //repete o numero 9 de acordo com o maxlength que foi descrito no usuário.
                        $caracter = str_repeat("9",  $this->maxLength);
                        $js .= "
                                    $(\"#{$this->id}\").mask(\"{$caracter}\");
                                ";
                    }
                }
            }
        }
                       
        $js .= " }); ";               
        
        if($this->typeARTextBoxMask == TipoARTextBoxMask::CPF_CNPJ){
            //Define o tamanho padrão do campo 
            $this->maxLength = 18;
            //Insere o campo com a máscara adequada ao tamanho da informação.
            $js .= "
                    function cpfcnpj(obj){
                       
                        if(obj.value.length == 3){
                                obj.value = obj.value + '.';
                                return false;
                        }
                        if(obj.value.length == 7){
                                obj.value = obj.value + '.';
                                return false;
                        }
                        if(obj.value.length == 11){
                                obj.value = obj.value + '-';
                                return false;
                        }
                        if(obj.value.length == 15){
                                p0=obj.value.charAt(0);
                                p1=obj.value.charAt(1);
                                p2=obj.value.charAt(2);
                                p3=obj.value.charAt(4);
                                p4=obj.value.charAt(5);
                                p5=obj.value.charAt(6);
                                p6=obj.value.charAt(8);
                                p7=obj.value.charAt(9);
                                p8=obj.value.charAt(10);
                                p9=obj.value.charAt(12);
                                p10=obj.value.charAt(13);
                                p11=obj.value.charAt(14);
                                obj.value = '';
                                obj.value = p0 + p1 + '.' + p2 + p3 + p4 + '.' + p5 + p6 + p7 + '/' + p8 + p9 + p10 + p11 + '-';
                                p0='';
                                p1='';
                                p2='';
                                p3='';
                                p4='';
                                p5='';
                                p6='';
                                p7='';
                                p8='';
                                p9='';
                                p10='';
                                p11='';
                                return false;
                        }
                }
                
               function verificaNumero(e) {
                    
                    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                            return false;
                    }
                }

                ";
        }
        
        $js .= " </script>";

        return $js;
    }
    
    private function gerarTextBox(){
        $textBox  = "";
        if($this->typeARTextBox != TipoARTextBox::HIDDEN && $this->bootStrap){            
            /*
            $textBox  = " <div class=\"control-group\"> ";
            $textBox .= " <label class=\"control-label\" for=\"{$this->id}\">{$this->label}:</label>";
            $textBox .= " <div class=\"controls\"> ";              
            */
            $textBox = $this->obterBootStrapDiv($this->typeClassTextBox);
        }
        if($this->typeARTextBox == TipoARTextBox::DATETIME_YEAR || $this->typeARTextBox == TipoARTextBox::DATETIME || $this->typeARTextBox == TipoARTextBox::DATETIME_MONTH_YEAR || $this->typeARTextBox == TipoARTextBox::NUMBER){
            $this->typeARTextBox = TipoARTextBox::TEXT;
        }
        
        $textBox .= "<input type=\"{$this->typeARTextBox}\" {$this->disable} ";
        $textBox .= " maxlength=\"{$this->maxLength}\" placeholder=\"{$this->placeholder}\" name=\"$this->name\" id=\"{$this->id}\" class=\"{$this->typeClassTextBox}\" value=\"{$this->default}\" ";
        $textBox .= " style=\"{$this->style}\" width=\"{$this->width}\" size=\"{$this->size}\"";
        
        if($this->require){
        	$textBox .= " required=\"true\" ";
        }
        //Adiciona os eventos a serem disparados através de reflection.
        $class = new ReflectionClass(get_class($this));

        //$properties = $class->getProperties(ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC);
        
        $properties = $class->getParentClass()->getParentClass()->getProperties(ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC);

        if (!is_null($properties)) {

            foreach ($properties as $prop) {
                $propName = $prop->getName();
                
                $method = new ReflectionMethod(get_class($this), 'get'.$propName);
                //$method->setAccessible(true);
                $valor = $method->invoke($this);

                if(!empty($valor)){
                    $textBox .= " $propName=\"$valor\" ";
                }
                
            }
        }
        
        $textBox .= " >";
        if($this->typeARTextBox != TipoARTextBox::HIDDEN && $this->bootStrap){
            $textBox .= " </div>";
            $textBox .= " </div>";
        }
        return $textBox;
    }
    
    public function setMask($mask){
        $this->mask = $mask;
    }
    
    private function getMask(){
        return $this->mask;
    }
    
    private function obterBootStrapDiv($textBoxClass){
        $divBootStrap = "";
        if(Config::VERSAO_BOOTSTRAP == "2"){
            $divBootStrap  = " <div class=\"control-group\"> ";
            $divBootStrap .= " <label class=\"control-label\" for=\"{$this->id}\">{$this->label}:</label>";
            $divBootStrap .= " <div class=\"controls\"> ";
        }else{
            if(Config::VERSAO_BOOTSTRAP == "3"){
                $divBootStrap  = " <div class=\"form-group\"> ";
                $divBootStrap .= " <label class=\"col-sm-1 control-label\" for=\"{$this->id}\">{$this->label}:</label>";
                $classe = ARBootstrap::obterClassBootStrap($this, $textBoxClass);
                $divBootStrap .= " <div class=\"{$classe}\"> ";
                //aletera o valor para ficar a propriedade passada
                $this->typeClassTextBox = "form-control";
            }
        }
        
        return $divBootStrap;
    }
}

?>
