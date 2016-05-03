<?php
class ARAction{
	
	protected $param;
	
	private $classe;
	private $metodo;
	
	function __construct($classe, $metodo){
		$this->classe = $classe;
		$this->metodo = $metodo;
	}
	
	/**
	 * Adds a parameter to the action
	 * @param  $param = parameter name
	 * @param  $value = parameter value
	 */
	public function setParameter($param, $value)
	{
		$this->param[$param] = $value;
	}
	
	public function obterURLMetodo(){
		
                /*
                 * COMENTADO PARA SER UTILIZADO EM OUTRO MOMENTO.
                 */
                /*            
		$url['modules'] = $this->classe;
		// get the method name
		$url['metodo'] = $this->metodo;
		
		$this->setParameter("ajax", "true");
		
		// verifica se foi fornecido parametros
		if ($this->param)
		{
			$url = array_merge($url, $this->param);
		}
		//devolve a string de montagem para execução do método.		
		return 'index.php?'.http_build_query($url);
		*/
            
                return Config::SITE_ADDRESS."action/{$this->classe}/$this->metodo";
            
	}
	
	
}