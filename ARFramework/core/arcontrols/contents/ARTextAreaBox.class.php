<?php
/**
 * Description of ARTextBox
 *
 * @author artur
 */

class ARTextAreaBox extends objetoHTML {
    //put your code here
    
    var $name;
    var $id;
    var $width;
    var $heigth;
    var $style;
    var $default;
    var $showIniValues;
    var $iniValue;
    var $maxLength;
    var $bootStrap;
    var $label;
    var $cols;
    var $row;
    var $class;
    var $useTinyMce;
    var $require;
    
    public function __construct() {
        parent::__construct();
    }

    protected function inicializarCampos(){
        if(empty($this->name)){
            $this->name = "ARTextAreaBox_".rand(100, 4000);
        }
        
        if(empty($this->id)){            
            $this->id  = $this->name;
        }
        
        if(empty($this->width)){            
           $this->width = "40"; 
        }
        
        if(empty($this->heigth)){            
           $this->heigth = "20"; 
        }
        
        if(empty($this->style)){            
           $this->style = ""; 
        }
        
        if(empty($this->default)){            
           $this->default = ""; 
        }
        
        if(empty($this->showIniValues)){            
           $this->showIniValues = true; 
        }
        
        if(empty($this->iniValue)){            
           $this->iniValue = ""; 
        }
        
        if(empty($this->typeARTextBox)){
            $this->typeARTextBox = TipoARTextBox::TEXT;
        }
        
        if(empty($this->bootStrap)){
            $this->bootStrap = true;
        }
        
        if(empty($this->class)){
            $this->class = "span7";
        }
        
        if(empty($this->row)){
            $this->row = "10";
        }
        
        if(empty($this->cols)){
            $this->cols = "8";
        }
               
    }
    
    public function bind(){
        $this->inicializarCampos();
        //die(var_dump($this));
        if($this->useTinyMce){
            return $this->scriptsAreaTextBox()."   ".$this->gerarAreaTextBox();
        }else{
            return $this->gerarAreaTextBox();
        }
    }
    
    private function scriptsAreaTextBox(){
        
    	
        $js = " <script type=\"text/javascript\">
                        tinymce.init({
                            selector: \"textarea\",
                            plugins: [
                                \"advlist autolink lists link image charmap print preview hr anchor pagebreak\",
                                \"searchreplace wordcount visualblocks visualchars code fullscreen\",
                                \"insertdatetime media nonbreaking save table contextmenu directionality\",
				\"emoticons template paste textcolor \"	
                            ],language : 'pt_BR',
                            toolbar1: \"insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image\",
toolbar2: \"forecolor backcolor emoticons\",
                        });
                    ";
                    
        $js .= " </script>";
        
    	/*
        $js = " <script type=\"text/javascript\">
                         CKEDITOR.replace('{$this->id}');
                    ";
        $js .= " </script>";        
        */
        
        return $js;
    }
    
    private function gerarAreaTextBox(){
        //<input type="text" maxlength="200" name="user_nome" class="inputBig" value="<?php echo $arrayValor->getUser_Nome() != null ? $arrayValor->getUser_Nome() : ''; id=user_nome>
        $textBox  = " <div class=\"control-group\"> ";
        $textBox .= " <label class=\"control-label\" for=\"{$this->id}\">{$this->label}:</label>";
        $textBox .= " <div class=\"controls\" style=\"width:{$this->width}%;\"> ";
        $textBox .= " <textarea rows=\"{$this->row}\" cols=\"{$this->cols}\"";
        $textBox .= " maxlength=\"{$this->maxLength}\" name=\"$this->name\" id=\"{$this->id}\" class=\"{$this->getClass()}\"";
        $textBox .= " style=\"{$this->style}\" ";
        //Adiciona os eventos a serem disparados através de reflection.
        $class = new ReflectionClass(get_class($this));
        
        $properties = $class->getParentClass()->getParentClass()->getProperties(ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC);

        if($this->require){
        	$textBox .= " required=\"true\" ";
        }	
        
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
        
        $textBox .= " > {$this->default} </textarea> ";
        $textBox .= " </div>";
        $textBox .= " </div>";
        return $textBox;
    }
}

?>
