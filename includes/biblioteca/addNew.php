<!--Definicoes-->
<div id="add-conteudos">
  <div class="option-add">
    <a name="definicoes">
      <div class="option-title"> Definições </div>
    </a>

    <form name="" action="" method="post">
      <div class="option-form">
        <label for="">O que definir: </label>

        <textarea name="definicao" placeHolder="Descreva aqui o pretendes definir!" required></textarea>

        <select name="cadeiras" size="1" required>
          <option value="">Esta disciplina esta relacionada a cadeira de? </option>

          <?=$listarCadeiras;?>

        </select>
      </div>

      <div class="option-btn">
        <input type="submit" name="addDefinicoes" value="Salvar" class="btn-add">
      </div>
    </form>

  </div>

  <!--Dicionario-->
  <div class="option-add">
    <!--topo-->
    <div class="option-title">
      <a name="dicionario">Diciónario</a>
    </div>

    <!--Formulario-->
    <form name="" action="" method="post">
      <div class="option-form2">
        <label for="">Palavra: </label>
        <input type="text" name="palavra" value="" placeHolder="Insira a palavra ou frase!" required/>

        <label for="">Significado: </label>
        <textarea name="significado" rows="8" cols="80" placeHolder="Significado ou tradução do termo!" required></textarea>

        <label for="">Tipo: </label>
        <select name="tipo" size="1" required>
          <option value="">Qual é o tipo de diciónario?</option>
          <option value="t" selected>Técnico</option>
          <option value="g">Geral</option>
        </select>

        <label for="">Cadeira: </label>
        <select name="cadeira" size="1" required id="r-termo">
          <option value="">Este termo esta relacionado a cadeira de?</option>

          <?=$listarCadeiras;?>
        </select>
      </div>

      <!--Botoes-->
      <div class="option-btn">
        <input type="submit" name="addDicionario" value="Salvar" class="btn-add">
      </div>
    </form>

  </div>

  <!--Imagens-->
  <div class="option-add">
    <a name="imagens">Imagens</a>
  </div>

  <!--Livros-->
  <div class="option-add">
    <a name="livros">Livros</a>
  </div>

  <!--Pesquisar por -->
  <div class="option-add">
    <!--Topo-->
    <div class="option-title">
      <a name="pesquisar_p">Pesquisar</a>
    </div>

    <!--Formulario-->
    <form name="" action="" method="post" >
      <div class="option-form2">
      </div>

      <div class="option-btn">
        <input type="submit" name="addPesquisarPor" value="Salvar" class="btn-add">
      </div>
    </form>

  </div>

  <!--Seja rico -->
  <div class="option-add">
    <!--Topo-->
    <div class="option-title">
      <a name="seja_rico">Seja rico</a>
    </div>
    <!--Formulario-->
    <form name="" action="" method="post" >
      <div class="option-form2">

        <label for="">Dica:</label>
        <textarea name="dicaRiqueza" placeHolder="Escreva aqui a dica de riqueza/sabedoria!" id="dicaRiqueza"></textarea>

        <label for="">Fonte: </label>
        <input type="text" name="origemDica" value="" placeHolder="Qual a origem da dica de riqueza/sabedoria!? (opcional)" id="origemDica">
      </div>

      <!--Botoes-->
      <div class="option-btn">
        <input type="submit" name="addDicasSabias" value="Salvar" class="btn-add">
      </div>
    </form>

  </div>

  <!--Sites-->
  <div class="option-add">
    <!--topo-->
    <div class="option-title">
      <a name="meus_sites">Sites</a>
    </div>

    <!--Formulario-->
    <form name="" action="" method="post" enctype="multipart/form-data">
      <div class="option-form2">
        <label for="">Nome: </label>
        <input type="text" name="nome" value="" placeHolder="Nome do site"  id="nome-s" required/>

        <label for="">Link: </label>
        <input type="text" name="linkWeb" value="" placeHolder="Link do site!" id="link-s" required/>

        <label for="">Descrição: </label>
        <textarea name="descricao" rows="8" cols="80" placeHolder="Significado ou tradução do termo!" id="description-site" style="width: 76%; height: 198px;" required></textarea>

        <label for="">Cadeira: </label>
        <select name="cadeira" size="1" required id="r-termo">
          <option value="">Este site esta relacionado a cadeira de?</option>

          <?=$listarCadeiras;?>
        </select>

        <label for="">Imagem: </label>
        <input type="file" name="imagem" title="Opcional" value="" placeHolder="Link do site!" style="width: 79%; height: 38px;"/>
      </div>

      <div class="option-btn">
        <input type="submit" name="addSites" value="Salvar" class="btn-add">
      </div>
    </form>
  </div>
</div>

</div>
</div>
