/*function creationXHHR(){
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




function Message(){
    var message = document.getElementById("chat-input").value;
    var envoyerPar = document.getElementById("envoyerPar").value;
    var recuPar = document.getElementById("RecuPar").value;
    var DateCreation = document.getElementById("DateCreation").value;
    var path = document.getElementById("path").value;
    var param = "Message="+message+"&EnvoyerPar="+envoyerPar+"&RecuPar="+recuPar+"&Date="+DateCreation;
    var object = new creationXHHR();
    //object.open("post",path+"/MessageController.php",true);
    object.open("post","../../../../Message/envoi",true);
    object.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    object.send(param);

}
*/

function messageenvoi(event){
    event.preventDefault();
    const url = this.href;
    document.getElementById("chat-input").innerHTML="";
    var contenu = document.getElementById("chat-input").value;
    
    
    axios.post("ecole?contenu="+contenu);

    

    
    
}






document.getElementById("envoi").addEventListener('click',messageenvoi)