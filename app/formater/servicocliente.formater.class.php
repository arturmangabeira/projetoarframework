<?php
class FormaterServicoClienteCheckBox implements IFormat {

	public function __construct() {
		;
	}

	public function generateFormat($field, $arrayField) {
		
		$div = new ARDiv();
		$div->id = "divchk_{$field}_{$arrayField->getId_Servico()}";
		
		$elemt = new ARTextHml("<p></p>");
		
		$checkbox = new ARCheckBox();
		$checkbox->value = $field;
		$checkbox->bootStrap = false;
		
		 //verifica se o cliente esta habilitado no serviço:
		$servicoClienteDto = new ServicoClienteDTO();

		$servicoClienteDto->setId_Cliente($field);
		$servicoClienteDto->setId_Servico($arrayField->getId_Servico());

		$result = $servicoClienteDto->obterPorFiltroDTO(false);

		if($result->count() >0){
			$servicoClienteDto = $result->getIterator()->current();

			if($servicoClienteDto->getFl_Habilitado() == 1){
				$checkbox->selected = true;
			}else{
				$checkbox->selected = false;
			}
		}

		$checkbox->onclick("javascript: habilitarServicoCliente({$field},{$arrayField->getId_Servico()})");		
		
		$div->addItem($checkbox);
		
		$div->addItem($elemt);
		
		return $div;
	}    //put your code here
}

class FormaterServicoCliente implements IFormat {

	public function __construct() {
		;
	}

	public function generateFormat($field, $arrayField) {

		$servicoDb = new ServicoDB();
		if($_REQUEST["page"] == 2){
			//die(var_dump($servicoDb->obterServicoConfiguracaoClientes($arrayField->getId_Cliente())));
		}
		return $this->gerarGridServico($servicoDb->obterServicoConfiguracaoClientes($arrayField->getId_Cliente()));

	}    //put your code here

	public function gerarGridServico($servicoDto){
		$arGrid = new ARGrid();

		$arGrid->showButtons = false;

		$arGrid->showInformation = false;

		$arGrid->showSelectField = false;

		$arGrid->legend = "Lista de Serviços do cliente ";

		$field = new ARField("id_servico","");

		$field = new ARField();
		$field->field = "desc_servico";
		$field->fieldCaption = "Descrição do Serviço";
		//$field->formart = new Formatercliente();
		$field->fieldFilter = "desc_servico";
		$arGrid->addField($field);

		$field = new ARField();
		$field->field = "id_cliente";
		$field->fieldCaption = "Serviços habilitados";
		$field->formart = new FormaterServicoClienteCheckBox();

		$arGrid->addField($field);

		$arGrid->dataSource = $servicoDto;
		$arGrid->allowPagination = false;
		//$arGrid->ajax = true;		

		return $arGrid;
	}

}