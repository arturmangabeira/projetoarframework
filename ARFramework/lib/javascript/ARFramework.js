/**
 * 
 */
function ARFrameworkMessage(pmessage,typeMessage,callBackFunction,redirect,timeout){
	
	var imagem = "";
	var texto = "";
	var classbutton = "";
	
	
	
	if(typeMessage == "aviso"){
		imagem = "/ARFramework/lib/images/info.png";
        texto = "Aviso";
        classbutton = "btn-primary";
               
	}
	
	if(typeMessage == "sucesso"){
		imagem = "ARFramework/lib/images/success.png";
        texto = "Sucesso";
        classbutton = "btn-success";
	}
	
	if(typeMessage == "erro"){
		imagem = "ARFramework/lib/images/error.png";
        texto = "Sucesso";
        classbutton = "btn-danger";
	}	
	
	
	bootbox.dialog({
	    title: texto,
	    message: '<img src=\"'+imagem+'\" width=\"100px\" height=\"100px\"/>'+pmessage,
	    buttons: {
           success: {
              label: "Ok",
              className: classbutton,
              callback: function() {
            	callBackFunction
              }
           }
	    }
        });	
  
        if(redirect != undefined){

                      if(timeout == undefined){
                              timeout = 300;
                      }

                      setTimeout(function(){
                              location.href = redirect;
                      }, timeout);
        }
  
}