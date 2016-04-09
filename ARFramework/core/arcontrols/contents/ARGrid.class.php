<?php 
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
  class ARGridClass{
    const CONDESED = "table table-condensed";
    const CONDESED_HOVER = "table table-condensed table-hover";
    const BORDERED = "table table-bordered";
  }
  
  class ARGridAlign{
    const CENTER = "text-align: center";
    const LEFT = "text-align: left";
    const RIGTH = "text-align: rigth";
  }

   class ARField {
       var $field;
       var $fieldCaption;
       var $fieldCaptionAlign;
       var $fieldFilter;
       var $width;
       var $height;
       
       var $class;
       var $style;
       var $visible;
       /**
        *
        * @var ARGridAlign 
        */
       var $align;
       /**
        * Variavel que conterá um IFormat a ser adicionado a collum.
        * @var IFormat; 
        */
       var $formart;
       
       
       
       public function __construct($field="", $fieldCaption="") {
           $this->field = $field;
           $this->fieldCaption = $fieldCaption;
           $this->visible = true;
       }
       
       public function getWidth(){
        return $this->width;
       }
    
       public function getField(){
            return $this->field;
       }
    
       public function getHeigth(){
        return $this->height;
       }
    
       public function getFieldCaption(){
        return $this->fieldCaption;
       }
       
       public function getClass(){
        return $this->class;
       }
       
       public function getStyle(){
        return $this->style;
       }
       
       public function getObjetoHtml(){
           return $this->objetoHTML;
       }
       
   }
   
   class ARFieldDate extends ARField{
       var $fieldFilterDataIni;
       var $fieldFilterDataEnd;
       
       public function __construct($field = "", $fieldCaption = "") {
           parent::__construct($field, $fieldCaption);
       }
   }
   
/**
 * Description of ARGrid
 *
 * @author Artur Mangabeira
 */
class ARGrid extends objetoHTML {
    //put your code here
    var $id;
    var $name;
    var $width;
    var $height;
    var $legend;
    var $ajax;
    var $ajaxOn;
    /**
     * Ação a ser exutada na página para renderizar a grid na tela em ajax
     * Ex: if($_REQUEST['ACAO'] = 'gerarGrid'){
     *      //Realizacao de um filtro
     *      return $this->addItemPage(gerarGrid());    
     * }
     * @var string
     */
    var $actionAjaxSubmit;
    /**
    *
    * @var ARGridClass 
    */
    var $class;
    var $style;
    private $page;
    /**
     * Variavel para conter o array de botõs customizados
     * @var ArrayObject
     */
    private $button;
    /**
     * DataSource a ser utilizado na query;
     * @var ArrayObject 
     */
    var $dataSource;
    /**
     * Utilizada para concatenar os filtros fornecidos pelo usuário
     * @var ArrayObject 
     */
    private $concatFilter;
    
    /**
     * Permite exibir os detalhes do qtd das linhas. 
     * @var type 
     */
    var $showInformation;
    
    var $classSubmitButtons;
    
    var $allowPagination;
    var $itenPerPage;
    var $showButtons;
    var $showButtonDelete;
    var $showButtonNew;
    var $showButtonEdit;
    var $showSelectField;
    
    
    /**
     * Variavel do tipo ARField em um ArrayObject
     * @var ArrayObject 
     */
    var $field;
    
    /**
     *
     * @var GenericDTO 
     */
    private $genericDTO;
    

    public function __construct() {
        parent::__construct();
        //Criando os objetos de campo
        $this->field     = new ArrayObject();
        $this->field->setFlags(ArrayObject::ARRAY_AS_PROPS);
        $this->button     = new ArrayObject();
        $this->button->setFlags(ArrayObject::ARRAY_AS_PROPS);
        $this->concatFilter     = new ArrayObject();
        $this->concatFilter->setFlags(ArrayObject::ARRAY_AS_PROPS);
        //Inicializando as variavies
        $this->showButtonNew = true;
        $this->showButtonEdit = true;
        $this->showButtonDelete = true;
        $this->showButtons = true;
        $this->allowPagination = true;
        $this->showSelectField = true;
        $this->ajax = false;
        $this->ajaxOn = $_REQUEST['ajax'];
        $this->showInformation = true;
        $this->genericDTO = new GenericDTO();
        
        if(!empty($_REQUEST['page'])){
            $this->page = $_REQUEST['page'];
        }else{
            $this->page = 1;
        }
    }
    
    /**
     * Adciona o campo do tipo ARField para montar a GRID
     * @param ARField $_field
     */
    public function addField($_field){
        if($_field instanceof ARField){
            $this->field->append($_field);
        }else{
            throw new Exception("O objeto esperado deve ser do tipo ARField");
        }
    }
    
    /**
     * Funcão para adicionar um botão customizado na grid;
     * @param ARButton $button
     * @throws Exception
     */
    public function addCustonButton($button){
        if($button instanceof ARButton){
            $this->button->append($button);
        }else{
            throw new Exception("O objeto esperado deve ser do tipo ARButton");
        }
    }
    
    public function addFilterField($fieldFilter){
        if(!empty($fieldFilter)){
            $this->concatFilter->append($fieldFilter);
        }else{
            throw new Exception("O campo de filtro não pode ser vazio!");
        }
    }
    
    private function inicilizarCampos(){
       if(empty($this->name)){
            $this->name = "ARGrid_".rand(100, 4000);
        }
        
        if(empty($this->id)){
            if(!empty($_REQUEST['tlbid'])){
                $this->id   = $_REQUEST['tlbid'];
                $this->name   = $_REQUEST['tlbid'];
            }else{
                $this->id   = $this->name;
            }
        }
        
        if(empty($this->style)){            
           $this->style = ""; 
        }
        
        if(empty($this->itenPerPage)){            
           $this->itenPerPage = 10; 
        }
        
        if(empty($this->class)){
            $this->class = ARGridClass::BORDERED;
        }
        
        if(empty($this->width)){
           $this->width = "100%"; 
        }
        
        if(empty($this->height)){
           $this->height = "100%";             
        }
        
        if(empty($this->classSubmitButtons)){
        	$this->classSubmitButtons = $this->genericDTO->getmodules();
        }
    }
    
    public function bind() {
        if($this->ajax){
            if(empty($this->actionAjaxSubmit)){
                throw new Exception("Para gerar grid com ajax é necessário informar a ação(actionAjaxSubmit) que gera o grid com ajax!
                <br/> Exemplo: <br/> if(\$_REQUEST['ACAO'] = 'gerarGrid'){ <br/>
                               return \$this->addItemPage(gerarGrid());<br/>
                            } <br/> 
                              Nesse caso o actionAjaxSubmit seria igual a gerarGrid; ");
            }
        }
        
        if($this->dataSource->count() > 0){
        
	        $this->inicilizarCampos();
	        if($this->ajaxOn != "true" || !empty($_REQUEST["metodo"])){
	            $scripts = "
	                    <script type=\"text/javascript\" >
	                        $(document).ready(function() {";
	
	            if($this->showSelectField){            
	                $scripts .= "  
	                                $('#{$this->id} input[name=\"chk_item[]\"]').each(function(e){
	                                    $(this).click(function(i){
	                                        var countCheck = $('#{$this->id} input[name=\"chk_item[]\"]').length;
	                                        var countCheckChecked = $('#{$this->id} :input[name=\"chk_item[]\"]:checked').length;
	                                        if (countCheck == countCheckChecked){
	                                             $('#chk_{$this->id}').attr('checked', true); 
	                                        }else{
	                                            $('#chk_{$this->id}').attr('checked', false);  
	                                        }
	
	                                    });
	                                });";
	             }
	             $scripts .= "                         
	                            $('#chk_{$this->id}').click(function() {
	                                if ($('#chk_{$this->id}').attr('checked') == 'checked') {
	                                    $('#{$this->id} input[type=\"checkbox\"]').each(function(i) {
	                                        $(this).attr('checked', true);
	                                    });
	                                } else {
	                                    $('#{$this->id} input[type=\"checkbox\"]').each(function(i) {
	                                        $(this).attr('checked', false);
	                                    });
	                                }
	                            })
	                        });
	
	                        function chekcItem(idTd){
	                            //alert($('#'+idTd).find('input[name=\"chk_item[]\"]').attr('checked'));
	    //                        if($('#'+idTd).find('input[name=\"chk_item[]\"]').attr('checked') == 'checked'){
	    //                            $('#'+idTd).find('input[name=\"chk_item[]\"]').attr('checked', false);
	    //                        }else{
	    //                            $('#'+idTd).find('input[name=\"chk_item[]\"]').attr('checked', true);
	    //                        }
	    //                        $('#'+idTd).find('input[name=\"chk_item[]\"]').click();
	                        }
	                        
	                        function checkPage(idLi,page,countPage){
	                            //Adiciona o active na página atual.
	                            $('#'+idLi).attr('class','active');
	                            if(page == '1'){
	                                $('#li1').attr('class','active');
	                                $('#li2').attr('class','active');
	                                $('#li3').attr('class','');
	                                $('#li4').attr('class','');
	                                for (var i=2;i<=countPage;i++)
	                                {
	                                    $('#lid_'+i).attr('class','disable');
	                                }
	                            }else{
	                                $('#li1').attr('class','');
	                                $('#li2').attr('class','');
	                                if(page == countPage){
	                                    $('#li3').attr('class','active');
	                                    $('#li4').attr('class','active');
	                                    for (var i=1;i<countPage;i++)
	                                    {
	                                        $('#lid_'+i).attr('class','disable');
	                                    }
	                                }else{
	                                    $('#li3').attr('class','');
	                                    $('#li4').attr('class','');
	                                    
	                                    for (var i=1;i<=countPage;i++)
	                                    {
	                                        if(i != page){
	                                            $('#lid_'+i).attr('class','disable');
	                                        }
	                                    }
	                                }
	                            }
	                        }
	                ";
	            if($this->showButtons){                    
	                if($this->showButtonNew){
	                    $scripts .= " 
	                                  function incluirRegistro_{$this->id}(){
	                                      location.href = 'index.php?modules={$this->classSubmitButtons}&acao=".Config::ACAO_NOVO."';".
	                                  "
	                                  }   
	                               ";
	                }
	
	                if($this->showButtonEdit){
	                    $scripts .= " 
	                                  function editarRegistro_{$this->id}(){
	                                        var selecionado = 0;
	                                        var idSel = 0;
	                                        $('#{$this->id} input[name=\"chk_item[]\"]').each(function(i) {
	                                            if ($(this).attr('checked') == 'checked') {
	                                                selecionado++;
	                                                idSel = $(this).val();
	                                            }
	                                        });
	
	                                        if (selecionado > 1) {
	                                            //alert('Favor selecionar apenas 1 item para edição!');
	                                            bootbox.alert(\"<i class='icon-info-sign'></i><p class='text-center'>Favor selecionar apenas 1 item para edição!</p>\", function() {
												  
												});	
	                                            return false;
	                                        } else {
	                                            if (selecionado == 0) {
	                                                //alert('Favor selecionar 1 item para edição!');
	                                                bootbox.alert(\"<i class='icon-info-sign'></i><p class='text-center'>Favor selecionar 1 item para edição!</p>\", function() {
												  
													});	
	                                                return false;
	                                            }
	                                        }
	                                        location.href='index.php?modules={$this->classSubmitButtons}&acao=".Config::ACAO_EDITAR."&valueid='+idSel;
	                                 }   
	                                ";
	                }
	
	                if($this->showButtonDelete){
	                    $scripts .= " 
	                                  function excluirRegistro_{$this->id}(){
	                                        var selecionado = 0;
	                                        var idSel = [];
	                                        var countArray = 0;
	                                        var selecionado = false;
	                                        $('#{$this->id} input[name=\"chk_item[]\"]').each(function(i) {
	                                            if ($(this).attr('checked') == 'checked') {
	                                                selecionado = true;
	                                                idSel[countArray] = $(this).val();
	                                                countArray++;
	                                            }
	                                        });
	
	                                        if (selecionado == false) {
	                                            alert('Favor selecionar ao menos um item para exclusão!');
	                                            return false;
	                                        }
	
	                                        if (confirm('Deseja excluir o(s) iten(s) selecionado(s) ?')){
	                                           location.href='index.php?modules={$this->genericDTO->getmodules()}&acao=".Config::ACAO_EXCLUIR."&valueid='+idSel.join();            
	                                        }else{
	                                           return false;
	                                        } 
	                                  }   
	                               ";
	                }                    
	            }
	
	            if($this->ajax){
	                $scripts .= "  
	                        function paginarDados(href){
	                            $.ajax({
	                                    url: href,
	                                    type: \"POST\",
	                                    success: function(result) {
	                                        $('#tlbdiv_{$this->id}').html(result);";
	                                        if($this->showSelectField){            
	                                         $scripts .= "  
	                                                         $('#{$this->id} input[name=\"chk_item[]\"]').each(function(e){
	                                                             $(this).click(function(i){
	                                                                 var countCheck = $('#{$this->id} input[name=\"chk_item[]\"]').length;
	                                                                 var countCheckChecked = $('#{$this->id} :input[name=\"chk_item[]\"]:checked').length;
	                                                                 if (countCheck == countCheckChecked){
	                                                                      $('#chk_{$this->id}').attr('checked', true); 
	                                                                 }else{
	                                                                     $('#chk_{$this->id}').attr('checked', false);  
	                                                                 }
	
	                                                             });
	                                                         });";
	                                      }
	                                      $scripts .= "                         
	                                                     $('#chk_{$this->id}').click(function() {
	                                                         if ($('#chk_{$this->id}').attr('checked') == 'checked') {
	                                                             $('#{$this->id} input[type=\"checkbox\"]').each(function(i) {
	                                                                 $(this).attr('checked', true);
	                                                             });
	                                                         } else {
	                                                             $('#{$this->id} input[type=\"checkbox\"]').each(function(i) {
	                                                                 $(this).attr('checked', false);
	                                                             });
	                                                         }
	                                                     });
	                                    }";                         
	               $scripts .= "  
	                            });    
	                        }
	                    ";
	            }
	            
	            
	
	            $scripts .= " </script>";
	
	            $strgrid = $scripts;    
	        }
	        $strgrid .= "<div class=\"row\" >
	                        <div class=\"span12\" >";
	        
	        if(!empty($this->style))
	            $style  ="style=\"{$this->style}\"";
	        if(!empty($this->legend)){    
	            if($this->ajaxOn != "true" || empty($_REQUEST["page"])){
	                $strgrid .= "   
	                        <fieldset>
	                        <legend>
	                        <h4>
	                            <p class=\"text-info\">{$this->legend}</p>
	                        </h4>
	                        </legend>";
	            }
	        }
	        if($this->ajaxOn != "true"){
	            $strgrid .= " 
	                    <div id=\"tlbdiv_{$this->id}\"> 
	                    ";
	        }
	       
	        if($this->showButtons){
	            $strgrid .=  "\r\n"."<div style=\"margin-top: -12px;\">";
	            //Exibe os botoes da grid
	            $btnIncluir = "\r\n"."
	                <div style=\"margin: 2px; float: left;\">"."\r\n"."
	                    <button type=\"button\" id=\"btnGridIncluir\" class=\"btn btn-info\" name=\"save\" onclick=\"javascript:return incluirRegistro_{$this->id}();\"> Adicionar </button>"."\r\n"."
	                </div>"."\r\n";
	
	            if ($this->showButtonNew){
	                $strgrid .=  $btnIncluir;
	            }
	
	            $btnEditar = "\r\n"."
	                <div style=\"margin: 2px; float: left;\">"."\r\n"."
	                    <button type=\"button\" class=\"btn btn-info\" name=\"save\" onclick=\"javascript:return editarRegistro_{$this->id}();\">Editar</button>"."\r\n"."
	                </div>"."\r\n";
	
	            if ($this->showButtonEdit){
	                $strgrid .=  $btnEditar;
	            }
	
	            $btnExcluir = "\r\n"."
	                <div style=\"margin: 2px; float: left;\">"."\r\n"."
	                    <button type=\"button\" class=\"btn btn-danger\" name=\"save\" onclick=\"javascript:return excluirRegistro_{$this->id}();\">Excluir</button>"."\r\n"."
	                </div>"."\r\n";
	
	            if ($this->showButtonDelete){
	                $strgrid .=  $btnExcluir;
	            }
	
	            $this->addButtonCustom($strgrid);
	            $borda = "";
	            if($this->class != ARGridClass::BORDERED){
	                $borda = "border-top: 1px solid #E5E5E5;";
	            }
	            $strgrid .=  "\r\n"."</div> 
	                  <div style=\"margin: 2px; clear: both;{$borda}\">"."\r\n"."
	                  </div>"."\r\n";
	        }     
	        
	        
	        $strgrid .= "                 
	                <div>";
	        
	        $strgrid .= " <table class=\"{$this->class}\" id=\"{$this->id}\" name=\"{$this->name}\" {$style} width=\"{$this->width}\" heigth=\"{$this->height}\">";
	        if($this->showInformation){
	            $strgrid .= " 
	                          <tr> 
	                                <td colspan=\"{$this->field->count()}\" align=\"center\">({$this->dataSource->count()}) Registros encontrados </td>
	                          <tr>
	                        ";
	            $strgrid .= " 
	                          <tr> 
	                                <td colspan=\"{$this->field->count()}\" align=\"center\">({$this->itenPerPage}) Itens por página </td>
	                          <tr>
	                        ";             
	        }
	        $this->bindHeadTable($strgrid);
	        $this->bindBodyTable($strgrid);
	        //$this->bindFooterTable($strgrid);
	        $strgrid .= " </table> ";
	        $strgrid .= " </div>
	                          ";
	        
	        
	        
	        if($this->showButtons){
	            $borda = "";
	            if($this->class != ARGridClass::BORDERED){
	                $borda = "border-top: 1px solid #E5E5E5;";
	            }
	             $strgrid .=  "\r\n"."<div style=\"margin-top: -20px;{$borda}\">";
	            //Exibe os botoes da grid
	            $btnIncluir = "\r\n"."
	                <div style=\"margin: 2px; float: left;\">"."\r\n"."
	                    <button type=\"button\" id=\"btnGridIncluir\" class=\"btn btn-info\" name=\"save\" onclick=\"javascript:return incluirRegistro_{$this->id}();\"> Adicionar </button>"."\r\n"."
	                </div>"."\r\n";
	
	            if ($this->showButtonNew){
	                $strgrid .=  $btnIncluir;
	            }
	
	            $btnEditar = "\r\n"."
	                <div style=\"margin: 2px; float: left;\">"."\r\n"."
	                    <button type=\"button\" class=\"btn btn-info\" name=\"save\" onclick=\"javascript:return editarRegistro_{$this->id}();\">Editar</button>"."\r\n"."
	                </div>"."\r\n";
	
	            if ($this->showButtonEdit){
	                $strgrid .=  $btnEditar;
	            }
	
	            $btnExcluir = "\r\n"."
	                <div style=\"margin: 2px; float: left;\">"."\r\n"."
	                    <button type=\"button\" class=\"btn btn-danger\" name=\"save\" onclick=\"javascript:return excluirRegistro_{$this->id}();\">Excluir</button>"."\r\n"."
	                </div>"."\r\n";
	
	            if ($this->showButtonDelete){
	                $strgrid .=  $btnExcluir;
	            }
	
	            $this->addButtonCustom($strgrid);
	
	            $strgrid .=  "\r\n"."</div> 
	                  <div style=\"margin: 2px; clear: both;\">"."\r\n"."
	                  </div>"."\r\n";
	        }
	        
	        if($this->allowPagination){
	             //if($this->ajaxOn != "true"){
	                $this->paginacao($strgrid,$this->dataSource->count());
	             //}
	        }
	        
	        if($this->ajaxOn != "true"){
	            $strgrid .= " </div>
	                          ";
	        }
	        if(!empty($this->legend)){  
	            if($this->ajaxOn != "true"){
	                $strgrid .= " </fieldset> ";
	            }
	        }
	        if($this->ajaxOn != "true"){
	            $strgrid .= " </div>  ";
	
	            $strgrid .= "
	                        </div>";
	        }
        }else{
        	$strgrid = "";
        	if(!empty($this->legend)){
        		
        			$strgrid .= "
        			<fieldset>
        			<legend>
        			<h4>
        			<p class=\"text-info\">{$this->legend}</p>
        			</h4>
        			</legend>";
        		
        	}
        	
        	$strgrid .= "
                <div>
        			<div> <p>Não foram encontrado dados com a consulta realizada.</p> </div>
        			";
        	
        	$strgrid .= "<div style=\"margin: 2px; float: left;\">"."\r\n"."
                    <button type=\"button\" id=\"btnGridIncluir\" class=\"btn btn-info\" name=\"save\" onclick=\"javascript:return incluirRegistro_{$this->id}();\"> Adicionar um novo registro.</button>"."\r\n"."
                </div>"."\r\n";
        	
        	
        	$strgrid .= " </div>
                          ";
        	
        	$strgrid .= " <script type=\"text/javascript\" >
        	function incluirRegistro_{$this->id}(){
        	location.href = 'index.php?modules={$this->genericDTO->getmodules()}&acao=".Config::ACAO_NOVO."';".
        	"
                                  }
				</script>
                               ";
        	
        }
        
        
        return $strgrid;
    }
    
    private function addButtonCustom(&$strgrid){
        if($this->button->count() > 0){
            $arbutton = new ARButton();
            foreach ($this->button->getIterator() as $arbutton) {
                $strgrid .= "\r\n"."
                <div style=\"margin: 2px; float: left;\">"."\r\n"."
                    {$arbutton->bind()}"."\r\n"."
                </div>"."\r\n";
            }
        }
    }
            
    
    /**
     * Monta as colunas da table de acordo com as colunas que são passadas para 
     * o método addCollums
     * @return string
     */ 
    private function bindHeadTable(&$strgrid){
       if ($this->field->count() > 0){
           //$strgrid .= "<thead> ";
           $arRow = new ARField;
           $strgrid .= "<tr >";
           
           //Escreve o item inicial que é os checks para edição ou exclusão;
           if($this->showSelectField){
                $strgrid .= "<td width=\"3%\">";
                $strgrid .= "<input type=\"checkbox\" id=\"chk_{$this->id}\" value=\"0\" name=\"\"/>";
                $strgrid .= "</td>";
           }
           
           foreach ($this->field->getIterator() as $key => $arRow) {
                $class = "";
                $style = "";
                $width = "";
                $heigth = "";
                $visible = "";
               if($key != 0 || !$this->showSelectField){               		
                     if(!empty($arRow->class))    
                          $class ="class=\"{$arRow->class}\"";
                     //if(!empty($arRow->style))
                          //$style  ="style=\"{$arRow->style}\"";
                     if(!$arRow->visible)
                     	$visible = ";display:none;";
                     if(!empty($arRow->fieldCaptionAlign))
                     	$style  ="style=\"{$arRow->fieldCaptionAlign};{$arRow->style};{$visible}\"";
                     else
                     	$style  ="style=\"".ARGridAlign::CENTER.";{$arRow->style}{$visible}\"";
                     if(!empty($arRow->width))
                          $width  ="width=\"{$arRow->width}\"";     
                     if(!empty($arRow->height))
                          $heigth  ="height=\"{$arRow->height}\"";  
                     
                      $strgrid .= "<th {$class} {$style} {$width} {$heigth}>
                            {$arRow->getFieldCaption()}
                          </th>";
               }
           }
           $strgrid .= "</tr>";
           //$strgrid .= " </thead>";
        }else{
            $strgrid .= "";
        }  
    }
    
    private function bindBodyTable(&$strgrid){
        if ($this->field->count() > 0){
        	
           $count = $this->dataSource->count();
            if($count > 0){   
            	$rp = 1;            	
            	$start = 0;            	 
            	$countReg = 0;
            	if($this->allowPagination && $this->itenPerPage > 0){
	                $rp = $this->itenPerPage;
	
	                $start = (($this->page-1) * $rp);
	                
	                $countReg = 0;
            	}
                //$strgrid .= "<tbody> ";
                $tr = 1;
                foreach ($this->dataSource->getIterator() as $key => $genericDto) {
                    //Efetua o cálculo da paginação sem utilizar limit da consulta.
                    if($key >= $start && $countReg < $rp ){
                        if($this->allowPagination){
                            $countReg++;
                        }
                       
                        $class = new ReflectionClass(get_class($genericDto));
                        
                        $properties = $class->getProperties(ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PUBLIC);
                        if($tr == 1){
                            $bgcolor = "style=\"border: 1px solid #aed0ea;background:#d7ebf9;\"";
                        }else{
                            $bgcolor = "bgcolor=\"#FFFFFF\"";
                        }
                        
                        if (!is_null($properties)) {
                            $strgrid .= "<tr id=\"{$key}\" {$bgcolor} > ";
                            $arField = new ARField();
                            foreach ($this->field->getIterator() as $keyfield => $arField) {
                                $class = "";
                                $style = "";
                                $width = "";
                                $heigth = "";
                                $visible = "";
                                foreach ($properties as $prop) {
                                    $propName = $prop->getName();
                                    if($arField->field === $propName){
                                        $method = new ReflectionMethod(get_class($genericDto), "get" . ucfirst($propName));
                                        $valor = $method->invoke($genericDto);
                                        if(!is_null($valor)){
                                            if($keyfield != 0 || !$this->showSelectField){
                                                if(!empty($arField->class))    
                                                        $tdclass = "class=\"{$arField->class}\"";
                                                   //if(!empty($arField->style))
                                                        //$style  = "style=\"{$arField->style}\"";
                                                   if(!empty($arField->width))
                                                        $width  = "width=\"{$arField->width}\"";     
                                                   if(!empty($arField->height))
                                                        $heigth = "height=\"{$arField->height}\"";
                                                   if(empty($arField->align)){
                                                        $align  = "style='".ARGridAlign::CENTER."'";     
                                                   }else{
                                                        $align  = "style='".$arField->align.";{$arField->style}'";     
                                                   }
                                                   if(!$arField->visible)
                                                        $visible = "style='display:none;'";       
                                                    $strgrid .= "<td {$tdclass} {$style} {$width} {$heigth} {$visible} {$align}  onclick=\"chekcItem({$key});\"> ";

                                                    if(!is_null($arField->formart)){
                                                        if($arField->formart instanceof IFormat){ 
                                                            $format = $arField->formart->generateFormat($valor, $genericDto);
                                                            if($format instanceof objetoHTML){
                                                                $strgrid .= $format->bind();
                                                            }else{
                                                                throw new Exception("O retorno do método generateFormat deve retornar um objeto do tipo objetoHtml!");
                                                            }
                                                        }else{
                                                            throw new Exception("O objeto esperado deve herdar da interface IFormat!");
                                                        }
                                                    }else{
                                                        if($tr == 1){
                                                            $bgcolor = "#2779aa";
                                                        }else{
                                                            $bgcolor = "#000000";
                                                        }
                                                        $strgrid .= "<font color=\"{$bgcolor}\">{$valor}</font>";
                                                    }
                                                    $strgrid .= " </td>";
                                            }else{
                                                $strgrid .= "<td>";
                                                $strgrid .= "<input type=\"checkbox\" value=\"{$valor}\" name=\"chk_item[]\" />";
                                                $strgrid .= "</td>";
                                            }
                                        }else{
                                            $strgrid .= "<td > </td>";
                                        }
                                    }
                                }
                            }
                            $strgrid .= "</tr> ";
                            if($tr == 1){
                                $tr--;
                            }else{
                                $tr++;
                            }
                        }
                    }
                }
                //$strgrid .= " </tbody>";
            }
        }else{
            $strgrid .= "";
        }  
    }
    
    private function paginacao(&$strgrid,$count){
        $qdtPages = ceil($count/$this->itenPerPage);
        
        if($qdtPages > 1){
            
            $endereco = "";
            $enderecoAjax = "";
            $funcao = "";
            if(!$this->ajax){
                $endereco = "index.php?modules={$this->genericDTO->getmodules()}&submodulo={$this->genericDTO->getSubModulo()}&acao={$this->genericDTO->getAcao()}";
            }else{
                $endereco = "#lnk";
                $enderecoAjax = "index.php?modules={$this->genericDTO->getmodules()}&submodulo={$this->genericDTO->getSubModulo()}&acao={$this->actionAjaxSubmit}&ajax=true&tlbid={$this->id}";
            }
            //Concatena os filtros passado pela consulta informado na grid.
//            if($this->concatFilter->count() >0){
//                foreach ($this->concatFilter as $filtro) {
//                    $endereco .= "&{$filtro}=".$_REQUEST[$filtro];
//                }
//            }
            $arRow = new ARField();
            foreach ($this->field->getIterator() as $arRow) {
                if($arRow instanceof ARField){
                    if(!empty($arRow->fieldFilter)){
                        $endereco .= "&{$arRow->fieldFilter}=".$_REQUEST[$arRow->fieldFilter];
                    }else{
                        $endereco .= "&{$arRow->field}=".$_REQUEST[$arRow->field];
                    }
                }else{
                    if($arRow instanceof ARFieldDate){
                        if(!empty($arRow->fieldFilterDataIni) && !empty($arRow->fieldFilterDataEnd)){
                            $endereco .= "&{$arRow->fieldFilterDataIni}=".$_REQUEST[$arRow->fieldFilterDataIni];
                            $endereco .= "&{$arRow->fieldFilterDataEnd}=".$_REQUEST[$arRow->fieldFilterDataEnd];
                        }else{
                            if(!empty($arRow->fieldFilter)){
                                $endereco .= "&{$arRow->fieldFilter}=".$_REQUEST[$arRow->fieldFilter];
                            }else{
                                $endereco .= "&{$arRow->field}=".$_REQUEST[$arRow->field];
                            }
                        }
                    }
                }
            }
            
            if(Config::VERSAO_BOOTSTRAP == 3){
                $strgrid .= "<a name=\"#lnk\"></a> \r\n"
                        . "<div class=\"col-sm-10\">"
                        . "<div class=\"dataTables_paginate paging_simple_numbers\">\r\n"
                        . "<ul class=\"pagination\">";
               
            }else{
            
                $strgrid .= "
                     <a name=\"#lnk\"></a>
                    <div class=\"pagination pagination-centered\">
                        <ul>";
            }
            $class = "";
            $enderecoInicial = $endereco;
            if($this->page == 1){
                $class = "disabled";
                $enderecoInicial = "#lnk";
            }
            
            $anteriorPage = $this->page-1;
            if($this->ajax){
                $funcao = "onclick=paginarDados('{$enderecoAjax}&page={$anteriorPage}')";
                $enderecoPagina = $enderecoInicial;
            }else{
                $funcao = "";
                $enderecoPagina = "{$enderecoInicial}&page={$anteriorPage}";
            }
            
            $strgrid .= " <li class=\"{$class}\" id=\"li1\"><a href=\"{$enderecoInicial}&page=1\" {$funcao} > Primeira</a></li> ";
            
            $strgrid .= " <li class=\"{$class}\" id=\"li2\"><a href=\"{$enderecoPagina}\" {$funcao} >« Anterior</a></li>";
            
            for($i=1; $i <= $qdtPages; $i++){
                if($i == $this->page){
                    if($this->ajax){
                        $funcao = "onclick=paginarDados('{$enderecoAjax}&page={$i}'),checkPage('lid_{$i}',{$i},{$qdtPages});";
                        $enderecoPagina = $endereco;
                        $strgrid .= " <li id=\"lid_{$i}\" class=\"active\"><a href=\"{$enderecoPagina}\" {$funcao}>{$i}</a></li> <li></li> ";
                    }else{
                        $strgrid .= " <li id=\"lid_{$i}\" class=\"active\"><a href=\"#lnk\">{$i}</a></li> <li></li> ";
                    }
                }else{
                    if($this->ajax){
                        $funcao = "onclick=paginarDados('{$enderecoAjax}&page={$i}'),checkPage('lid_{$i}',{$i},{$qdtPages});";
                        $enderecoPagina = $endereco;
                    }else{
                        $funcao = "";
                        $enderecoPagina = "{$endereco}&page={$i}";
                    }
                    $strgrid .= " <li id=\"lid_{$i}\" class=\"\"><a href=\"{$enderecoPagina}\" {$funcao} >{$i}</a></li> <li></li> ";
                }
            }

            $strgrid .= "";        
            $proximaPage = $this->page+1;
            $classFinal = "";
            $enderecoFinal = $endereco;
            if($this->page == $qdtPages){
                $classFinal = "disabled";
                $enderecoFinal = "#";
            }
            
            if($this->ajax){
                if($this->page != $qdtPages){
                    $funcao = "onclick=paginarDados('{$enderecoAjax}&page={$proximaPage}')";
                }else{
                    $funcao = "";
                }
                $enderecoPagina = $enderecoFinal;
            }else{
                $funcao = "";
                $enderecoPagina = "{$enderecoFinal}&page={$proximaPage}";
            }
            
            $strgrid .= " </li> <li></li><li class=\"{$classFinal}\" id=\"li3\"><a href=\"{$enderecoPagina}\" {$funcao} >Próximo »</a>
                    </li> ";
            if($this->ajax){
                if($this->page != $qdtPages){
                    $funcao = "onclick=paginarDados('{$enderecoAjax}&page={$qdtPages}')";
                }else{
                    $funcao = ""; 
                }
                $enderecoPagina = $enderecoFinal;
            }else{
                $funcao = "";
                $enderecoPagina = "{$enderecoFinal}&page={$qdtPages}";
            }
            $strgrid .= " </li> <li></li><li class=\"{$classFinal}\" id=\"li4\"><a href=\"{$enderecoPagina}\" {$funcao} >Última </a>
                    </li> ";
            
            $strgrid .= "</ul>
                    </div>";
            if(Config::VERSAO_BOOTSTRAP == 3){
                $strgrid .= "</div>";
            }
        }
    }
    
}

?>
