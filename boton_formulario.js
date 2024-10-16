var x = document.getElementById("frmlogin");
var y = document.getElementById("frmregistrar");
var z = document.getElementById("btnvai");
var textcolor1=document.getElementById("vaibtnlogin");
var textcolor2=document.getElementById("vaibtnregistrar");
textcolor1.style.color="white";
textcolor2.style.color="white";

function registrarvai(){
    x.style.left = "-400px";
    y.style.left = "50px";
    z.style.left = "110px";
    textcolor1.style.color="white";
    textcolor2.style.color="white";
}
function loginvai(){
    x.style.left = "50px";
    y.style.left = "450px";
    z.style.left = "0";
    textcolor1.style.color="white";
    textcolor2.style.color="white";
    
}
function dragElement(elmnt) {
    var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
    
    elmnt.onmousedown = dragMouseDown;
  
    function dragMouseDown(e) {
      e = e || window.event;
      e.preventDefault();
      // Obtén la posición del cursor al inicio
      pos3 = e.clientX;
      pos4 = e.clientY;
      document.onmouseup = closeDragElement;
      // Llama a la función cada vez que el cursor se mueve
      document.onmousemove = elementDrag;
    }
  
    function elementDrag(e) {
      e = e || window.event;
      e.preventDefault();
      // Calcula la nueva posición del cursor
      pos1 = pos3 - e.clientX;
      pos2 = pos4 - e.clientY;
      pos3 = e.clientX;
      pos4 = e.clientY;
      // Establece la nueva posición del elemento
      elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
      elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
    }
  
    function closeDragElement() {
      // Deja de mover el elemento cuando se suelta el botón del mouse
      document.onmouseup = null;
      document.onmousemove = null;
    }
  }