/*function creationXHR(){
    var resultat = null;
    try{
        resultat = new XMLHttpRequest();
    }
    catch(Error){
        try{
            resultat = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch(Error){
            try{
                resultat = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch(Error){
                resultat = null;
            }
        }
    }
    return resultat;
    
}
*/



var message = ""


function messageenvoi(event){
    event.preventDefault();
    const url = this.href;
    document.getElementById("chat-input").innerHTML="";
    var contenu = document.getElementById("chat-input").value;
    
    
    axios.post("ecole?contenu="+contenu).then(function(response) {
        
        const messages = response.data;
        var idconnecter = document.getElementById("idconnecter").value;
        var idrecupar = document.getElementById("idrecupar").value;
        listeMessage = [];
        listeIdEnvoyerPar = [];
        listeIdRecuPar = [];
        document.getElementById("chat-input").innerHTML = "";
        

        for (let index = 0; index < messages.length; index++) {
           listeMessage[index] = messages[index].contenu;
           listeIdEnvoyerPar[index] = messages[index].envoyerpar;
           listeIdRecuPar[index] = messages[index].recupar;
            
        }
        var idconnecter = document.getElementById("idconnecter").value;
			var idrecupar = document.getElementById("idrecupar").value;
			listeMessage = [];
			listeIdEnvoyerPar = [];
			listeIdRecuPar = [];
            
	
	
			for (let index = 0; index < messages.length; index++) {
			   listeMessage[index] = messages[index].contenu;
			   listeIdEnvoyerPar[index] = messages[index].envoyerpar;
			   listeIdRecuPar[index] = messages[index].recupar;
				
			}
			
		mot = "";
        
        for (let index = 0; index < listeMessage.length; index++) {


            if ( listeIdEnvoyerPar[index] == idconnecter && listeIdRecuPar[index] == idrecupar ) {
                mot = mot+'<div class="chat-msg self"><div class="cm-msg-text">'+listeMessage[index]+'</div><br/> <br/><br/><br/></div>';
            }
            else if(listeIdEnvoyerPar[index] == idrecupar && listeIdRecuPar[index] == idconnecter){
                mot = mot+'<div class="chat-msg user"><div class="cm-msg-text">'+listeMessage[index]+'</div><br/> <br/><br/><br/></div>';
            }
            
           
        
        };
        document.getElementById("chat-logs").innerHTML= mot;
		
        /*const html = response.map(function(message){
            return '<div class="chat-msg self"><div class="cm-msg-text">'+message.contenu+'</div><br/><br/><br/><br/></div><div class="chat-msg user"><div class="cm-msg-text">textox</div><br/><br/><br/><br/></div>'

        }).join('');
        console.log(html)
        

        */

        /*function test(listeconecter , listerecupar ,idconnecter , idrecupar)
        {
            for (let index = 0; index < listeconecter.length; index++) {
                if
            }
        }*/

        console.log(listeMessage);
        console.log(listeIdEnvoyerPar);
        console.log(listeIdRecuPar);

        
        


    

    
});



};


document.getElementById("envoi").addEventListener('click',messageenvoi)


setInterval(function () {
        
        axios.post("ecole?contenu=uvbsuvbsiudbvdjksbvjkbsvcjkxbkjvbxjkcbvkjvbdfsvkvjbskjdbvsjkbvsjkdvb skcv kjs dvjskvksjvbkjsdbvkjsbvjksd").then(function(response) {
        const messages = response.data;
        var idconnecter = document.getElementById("idconnecter").value;
        var idrecupar = document.getElementById("idrecupar").value;
        listeMessage = [];
        listeIdEnvoyerPar = [];
        listeIdRecuPar = [];
        document.getElementById("chat-input").innerHTML = "";
        

        for (let index = 0; index < messages.length; index++) {
           listeMessage[index] = messages[index].contenu;
           listeIdEnvoyerPar[index] = messages[index].envoyerpar;
           listeIdRecuPar[index] = messages[index].recupar;
            
        }
        var idconnecter = document.getElementById("idconnecter").value;
			var idrecupar = document.getElementById("idrecupar").value;
			listeMessage = [];
			listeIdEnvoyerPar = [];
			listeIdRecuPar = [];
            
	
	
			for (let index = 0; index < messages.length; index++) {
			   listeMessage[index] = messages[index].contenu;
			   listeIdEnvoyerPar[index] = messages[index].envoyerpar;
			   listeIdRecuPar[index] = messages[index].recupar;
				
			}
			
		mot = "";
        
        for (let index = 0; index < listeMessage.length; index++) {


            if ( listeIdEnvoyerPar[index] == idconnecter && listeIdRecuPar[index] == idrecupar ) {
                mot = mot+'<div class="chat-msg self"><div class="cm-msg-text">'+listeMessage[index]+'</div><br/> <br/><br/><br/></div>';
            }
            else if(listeIdEnvoyerPar[index] == idrecupar && listeIdRecuPar[index] == idconnecter){
                mot = mot+'<div class="chat-msg user"><div class="cm-msg-text">'+listeMessage[index]+'</div><br/> <br/><br/><br/></div>';
            }
            
           
        
        };
        console.log(messages);
        document.getElementById("chat-logs").innerHTML= mot;
    });
},1000)
