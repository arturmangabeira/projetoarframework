/**
 * funcção utilizada para gravar os dados enviados 
 */
function habilitarServicoCliente(p_id_cliente,p_id_servico){
	
	var url = "index.php?modulos=servicocliente&acao=habilitarServicoCliente&ajax=true";
	$.ajax({
		  type: "POST",
		  url: url,
		  data: {id_cliente: p_id_cliente,id_servico: p_id_servico},
		  success: function(data){
			  $("#divchk_"+p_id_cliente+"_"+p_id_servico).find("p").each(function(){
				  var resultado = data.split("|");				  
				  if(resultado[0] == 1){
					  $(this).html("<div class=\"alert alert-success\">"+resultado[1]+"</div>").fadeIn( "slow" );
				  }else{
					  $(this).html("<div class=\"alert alert-error\">"+resultado[1]+"</div>").fadeIn( "slow" );
				  }
				  
				  setTimeout(function(){
					  $("#divchk_"+p_id_cliente+"_"+p_id_servico).find("p").fadeOut( "slow" );
 					}, 3000);

			  });
		}		  
	});
}