window.onload = (function(){
    document.getElementById("lado").addEventListener("keyup", function(ev){
        console.log(ev);
        if(ev.keyCode < 48 || ev.keyCode > 57){
            document.getElementById("msg-lado").innerHTML = "Valor informado incorreto";
            document.getElementById("msg-lado").style.color = "red";
            document.getElementById("msg-lado").className = "erro";
        }
    });
    document.getElementById("salvar").addEventListener("click", function(){
        salvaTabuleiro();
    });
});

function salvaTabuleiro(){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
        if(this.status == 200){
            item = JSON.parse(this.responseText);
            if(item.ERR){
                alert.apply(item.ERR);
            }
            // [...]
        } else{
            apresentaMensagem("Problema de conexão");
        }
        // [...]
    }
    xhttp.open("POST", "processa2.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("lado="+document.getElementById("lado").value);
}

function apresentaMensagem(error){
    divfundo = document.createElement("div");
    divmsg = document.createElement("div");
    divmsg.className = "msg";
    btn = document.createElement("button");
    btn.innerHTML = "OK";
    btn.addEventListener("click", fechar); 
    divmsg.appendChild(btn);
    divfundo.appendChild(divmsg);
    divfundo.className = "fundo";
    divmsg.innerHTML = error;

    document.getElementById("corpo").appendChild(divfundo);
}

function fechar(){
    for(div of document.getElementByClassName("fundo")){
        div.style.display = "none";
    }
}