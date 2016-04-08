<?php
	/**
	 * Gerador de Getters e Setters 2.0
	 * by Savior <bfmaster_duran@yahoo.com.br>
	 * 
	 * Script utilizado para gerar getters and setters de classes.
	 * Mostrando o output delas em tela.
	 */
	$arq = isset($_POST['file_location']) ? $_POST['file_location'] : null;
	$php_v = isset($_POST['php']) ? $_POST['php'] : "php4";
	$tipo_fun = isset($_POST['tipo_fun']) ? $_POST['tipo_fun'] : null;
	$comentario = (boolean)(isset($_POST['comentario']) ? intval($_POST['comentario']) : false);

	if (isset($arq)) {
		$temp = explode(".",$arq);
		if (sizeof($temp) > 0) {
			if (strtolower($temp[sizeof($temp)-1]) == 'php') {
				if (file_exists($arq)) {

					//echo "<pre>" .htmlentities(file_get_contents($arq)) . "</pre>";
					$reg_exp = ($php_v == "php5") ? '/(public|protected|private) \\$(\\w*)/i' : '/var \\$(\\w*)/i';
					preg_match_all($reg_exp, file_get_contents($arq), $result, PREG_SET_ORDER);
					if (sizeof($result) > 0) {
						$arrVars = array();
						
						for ($matchi = 0; $matchi < sizeof($result); $matchi++) {
							$arrVars[] = ($php_v == "php5") ? $result[$matchi][2] : $result[$matchi][1];
						}
						if (sizeof($arrVars) > 0)
							generate($arrVars);
					} else
						echo "N&atilde;o foi encontrado variaveis para criar getters e setters!<br />Tem certeza que o arquivo est&aacute; na vers&atilde;o do php selecionado?";
				}
			} else
				echo "Arquivo tem que ser em .php!";
		} else
			echo "O arquivo n&atilde;o tem extens&atilde;o!";


	}

	function generate($arr) {
		global $php_v, $tipo_fun, $comentario;		
		$out = "<h3>Getters and Setters gerados:</h3>";
		$out .= "<pre style=\"border: 1px dashed #000000; padding: 5px; font-size: 8pt; background: #EFFFFF;\">";		
		foreach ($arr as $key => $val) {
			$valMetodo = "";
                        //Getter
			if ($comentario) {
				$out .= "<span style=\"color: red;\">";
				$out .= "\t/**\n";
				$out .= "\t * Getter para a variavel \$" . $val . "\n";
				$out .= "\t * @return Valor da variavel \$" . $val . "\n";
				$out .= "\t */\n";
				$out .= "</span>";
			}
			
                        if(strstr($val,"_")){
                           $arrayString = explode("_", $val);
                           $novoValue = "";
                           foreach ($arrayString as $value) {
                               $novoValue .= strtoupper(substr($value, 0, 1)).substr($value, 1, strlen($value));
                           }
                           $valMetodo = $novoValue;
                        }else{
                           $valMetodo = $val;
                        }
			$out .= "\t" . (($php_v == "php5") ? "<span style=\"color: blue\">" . $tipo_fun . "</span>" : "") . " function get" . ucfirst($valMetodo) . "() {\r\n";
                        //$out .= "\t" . (($php_v == "php5") ? "<span style=\"color: blue\">" . "private" . "</span>" : "") . " function get" . $valMetodo . "() {\r\n";
			$out .= "\t\t<span style=\"color: blue\">return</span> \$this->" . $val .";\r\n";
			$out .= "\t}\r\n";
			//Setter
			
			
			if ($comentario) {
				$out .= "<span style=\"color: red;\">";
				$out .= "\t/**\n";
				$out .= "\t * Setter para a variavel \$" . $val . ", atribuindo o valor passado para a mesma.\n";
				$out .= "\t * @param \$" . $val . " - Valor a ser atribuido.\n";
				$out .= "\t */\n";
				$out .= "</span>";
			}
			$out .= "\t" . (($php_v == "php5") ? "<span style=\"color: blue\">" . $tipo_fun . "</span>" : "") . " function set" . ucfirst($valMetodo) . "($"."value) {\r\n";
                        //$out .= "\t" . (($php_v == "php5") ? "<span style=\"color: blue\">" . $tipo_fun . "</span>" : "") . " function " . $valMetodo . "($"."value) {\r\n";
			$out .= "\t\t<span style=\"color: blue\">\$this-></span>" . $val . " = \$" . "value" . ";\r\n";
			$out .= "\t}\r\n";
			$out .= "\r\n";
		}
		$out .= "</pre><hr />";

		echo $out;
	}
?>
<h3>Gerador de Getters and Setters 2.0 - by <a href="mailt:bfmaster_duran@yahoo.com.br" title="mail me ;D">savior</a></h2>
<form action="<? echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
	<p>
		<label for="localizacao">Localiza&ccedil;&atilde;o da Classe:</label>
		<input type="file" name="localizacao" id="localizacao" size="50" value="<?php echo $arq; ?>" />
	</p>
	<input type="radio" name="php" id="php4" value="php4" checked="checked" onclick="document.getElementById('tipo').style.display='none';" /> <label for="php4">PHP4</label>
	<input type="radio" name="php" id="php5"  value="php5" onclick="document.getElementById('tipo').style.display='block';" /> <label for="php5">PHP5</label>
	<div id="tipo" <?php if($php_v != "php5") { ?>style="display: none;"<?php } ?>>
		<strong>Tipo dos m&eacute;todos:</strong><br />
		<input type="radio" value="public" name="tipo_fun" id="public" <?php if(!isset($tipo_fun) || ($tipo_fun == "public")) { ?>checked="checked"<?php } ?>><label for="public">M&eacute;todos p&uacute;blicos (public)</label><br />
		<input type="radio" value="private" name="tipo_fun" id="private" <?php if($tipo_fun == "private") { ?>checked="checked"<?php } ?>><label for="private">M&eacute;todos privados (private)</label><br />
		<input type="radio" value="protected" name="tipo_fun" id="protected" <?php if($tipo_fun == "protected") { ?>checked="checked"<?php } ?>><label for="protected">M&eacute;todos protegidos (protected)</label><br />
	</div>
	<p>
		<input type="radio" name="comentario" value="1" id="comentario_1" checked="checked"><label for="comentario_1">Com coment&aacute;rios</label>
		<input type="radio" name="comentario" value="0" id="comentario_0"><label for="comentario_0">Sem coment&aacute;rios</label>
	</p>
	<p>
		<input type="hidden" name="file_location" id="file_location" value="" />
		<input type="submit" value="Gerar" onclick="document.getElementById('file_location').value = document.getElementById('localizacao').value;"/>
	</p>
</form>