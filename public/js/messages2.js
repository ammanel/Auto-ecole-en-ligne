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
   
    var contenu = document.getElementById("chat-input").value;
    try {
        document.getElementById("chat-input").value="";
    } catch (error) {
        
    }
    
    var idconnecter = document.getElementById("idpersonneconnecter").value;
    var idrecupar = document.getElementById("idrecupar").value;
    
    axios.post("ecole?contenu="+contenu+"&idconnecter="+idconnecter+"&idrecupar="+idrecupar).then(function(response) {
        
        const messages = response.data;
        var idconnecter = document.getElementById("idpersonneconnecter").value;
        var idrecupar = document.getElementById("idrecupar").value;
        listeMessage = [];
        listeIdEnvoyerPar = [];
        listeIdRecuPar = [];
        document.getElementById("chat-input").innerHTML = "";
        
        console.log(message);

        for (let index = 0; index < messages.length; index++) {
           listeMessage[index] = messages[index].contenu;
           listeIdEnvoyerPar[index] = messages[index].envoyerpar;
           listeIdRecuPar[index] = messages[index].recupar;
            
        }
        var idconnecter = document.getElementById("idpersonneconnecter").value;
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
        document.getElementById("mess").innerHTML= mot;
        document.getElementById("chat-logs").scrollTo(0,document.getElementById("chat-logs").scrollHeight);
		
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

        

        
        


    

    
});



};


document.getElementById("sendmessage").addEventListener('click',messageenvoi)


setInterval(function () {
    var link = document.getElementById("sendmessage").href
    
    axios.post(link+"?contenu=uvbsuvbsiudbvdjksbvjkbsvcjkxbkjvbxjkcbvkjvbdfsvkvjbskjdbvsjkbvsjkdvb skcv kjs dvjskvksjvbkjsdbvkjsbvjksd").then(function(response) {
    const messages = response.data;
    
    var idconnecter = document.getElementById("idpersonneconnecter").value;
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
    var idconnecter = document.getElementById("idpersonneconnecter").value;
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
    document.getElementById("mess").innerHTML= mot;

    
});
},3000)


setInterval(function () {
    var idconnecter = document.getElementById("idpersonneconnecter").value;
    axios.post("notifications?envoyerpar="+idconnecter).then(function(response) {
    const messages = response.data;
    document.getElementById("notifs_responsable").innerHTML=messages.nombre
    axios.post("listeNotifications?envoyerpar="+idconnecter).then(function(response) {
        const messages = response.data;
        var listeMessage = [];
        for (let index = 0; index < messages.length; index++) {
        listeMessage[index] = messages[index].contenu;
        }
        mot = "";
        for (let index = 0; index < listeMessage.length; index++) {

            if (index == 10) {
                break;
            }
            mot = mot + "<li><i class='fa fa-envelope' aria-hidden='true'></i> &emsp;"+listeMessage[index]+"</li>";
            
            
           
        
        };

        document.getElementById("message_notifications_responsable").innerHTML=mot;

        try {
            document.getElementById('lu').value;
            lu();

        } catch (error) {
            
        }
    })
    
    
    
});
},3000)


function lu() {
    var idconnecter = document.getElementById("idpersonneconnecter").value;
    axios.post("notifications?lu=oui&envoyerpar="+idconnecter).then(function(response) {
        const messages = response.data;
        document.getElementById("chat-logs").scrollTo(0,document.getElementById("chat-logs").scrollHeight);
})

}