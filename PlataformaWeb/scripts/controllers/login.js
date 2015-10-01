//------- LOGIN ----------
function init(){
    document.getElementById('registro').style.display = 'none';
}

function registro_usuario(){
    document.getElementById('inicio_sesion').style.display = 'none';
    document.getElementById('registro').style.display = 'block';
    //$("#filtros").modal();
}
function volver(){
    document.write("<script>location.href='index.html'</script>"); 
}
function errorUsuario(){
    Materialize.toast('ERROR!', 4000);
}
//------- LOGIN ----------