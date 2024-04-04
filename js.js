
//ACCORDION
function accordion(id) {
  var x = document.getElementById(id);
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }

}

function accordionClose(id) { //ACCORDION JUST CLOSE FOR INPUT FILTER
  var x = document.getElementById(id);
  x.className = x.className.replace(" w3-show", "");
}

function accordionOpen(id) { //ACCORDION JUST CLOSE FOR INPUT FILTER
  var x = document.getElementById(id);
  x.className += " w3-show";
}



function enabledisable(className) {
  var x = document.getElementsByClassName(className);
  
  
  for(i=0;i<(x.length);i++){
    if (x[i].disabled == true) {
      x[i].removeAttribute("disabled", "false");

    } 
    else {
      x[i].setAttribute("disabled", "true");
    }
  }
  

}
function changeTab(tabName) {
  var i;
  var x = document.getElementsByClassName("tab");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  document.getElementById(tabName).style.display = "block";  
}


function checkboxprint() {
  var x =document.getElementsByClassName("checkboxprint");
  for(var i=0;i<x.length;i++){
    if (x[i].hidden == true) {
      x[i].removeAttribute("hidden", "false");
    } 
  
  }

 
} 

function expandcollapse() {
  var x = document.getElementsByClassName("urundiv")
  
  for(i=0;i<(x.length);i++){
    if (x[i].className.indexOf("w3-show") == -1){
      x[i].className += " w3-show";
    } 
    else {
      x[i].className = x[i].className.replace(" w3-show", "");
    }
  }
  

}
