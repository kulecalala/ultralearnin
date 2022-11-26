<!--Menu de ajuda-->
<div id="view-modal-faq">
  <button type="button" name="button" onclick="showModal('modal-faq')">
    ?
  </button>
</div>

<!--Painel de ajuda -->
<div class="modal-faq" id="modal-faq">
  <div id="titulo-componentes">
    <div id="titulo">
      <strong>No que podemos ser util</strong>
    </div>

    <span onclick="hiddenModal('modal-faq')"> &times; </span>
  </div>

  <div id="visualizar-conteudo">

  </div>
</div>

<!--Horario-->
<div class="horario-actividade" id="horario-actividade">
  <div class="view-modal-title">
    <strong>Horário</strong>
  </div>
  <div class="view-modal-sair">
    <span class="sair-modal" onclick="hiddenModal('horario-actividade')">
      &times;
    </span>
  </div>

  <!--topo-->
  <div id="topo">

    <div class="identificador" id="tempos"> Tempo </div>
    <div class="identificador" id="actividades"> Inicio </div>
    <div class="identificador" id="actividades"> Termino </div>
    <div class="identificador"> Domingo </div>
    <div class="identificador"> Segunda </div>
    <div class="identificador"> Terça </div>
    <div class="identificador"> Quarta </div>
    <div class="identificador"> Quinta </div>
    <div class="identificador"> Sexta </div>
    <div class="identificador" id="sabado"> Sábado </div>

  </div> <!--fim topo-->

  <!--Meu horario-->
  <div id="horario">
  </div> <!-- FIm Meu horario-->

  <!--Formulario para criar novo tempo de estudos-->
  <div id="criar-horario-estudos">
  </div>

</div>

<!--Opticoes de utilizador-->
<div class="more-options" id="more-options">
  <div id="more-option-topo">
    <div id="foto-no-perfil">
      <!--Foto de peril-->
      <img src="\users\<?=$showPhotoP;?>" alt="Foto de perfil" id="globalUserfotoDePerfil"/>
    </div>

    <span onclick="hiddenModal('more-options')">&times;</span>

    <p><?=substr($_SESSION['userName'], 0, 25)?></p>
    <p>Ultralearner</p>

  </div>

  <div id="more-option-list">
    <ul>
      <li> <a href="/perfil">Perfil</a> </li>
      <li> <a href="#">Ultra Convite</a> </li>
      <li> <a href="#">Partilhar</a> </li>
      <li> <a href="/logout">Sair</a> </li>
    </ul>
  </div>
</div> <!-- Mais opcoes do utilizador-->
