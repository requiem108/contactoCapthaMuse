document.getElementById('formContacto502').addEventListener('submit',MandarFormulario);



function MandarFormulario(event){
   event.preventDefault();
    let formulario = event.currentTarget;
    
    var datos = new FormData(formulario);
    
    
    fetch(URLdireccion+'servicio.php',{
                method: 'POST',
                body: datos
            })
            .then(res=>res.text())
            .then(respuesta=>{
        
            document.getElementById('Respuesta502').innerHTML=respuesta;
        console.log(respuesta);
    });
    
}