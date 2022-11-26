//Funcao destaque a pagina
function activeMenu(){
  const correntLocation = location.href;
  const menuItem        = document.querySelectorAll('a');
  const menuLength      = menuItem.length;

  for (let i = 0; i < menuLength; i++) {
    if( menuItem[i].href === correntLocation ) {
      menuItem[i].className = "active";
    }
  }
}

//Funcao para visializar items ocultos
function showModal( visualizar ) {
  var element = document.getElementById(visualizar);
  element.classList.add("show-modal");
}

//Funcao para ocultar items visiveis
function hiddenModal( visualizar ) {
  var element = document.getElementById(visualizar);
  element.classList.remove('show-modal');
}
