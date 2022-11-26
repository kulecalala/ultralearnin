<!DOCTYPE html>
<html lang="pt">
<header>
  <meta charset="UTF-8"/>
  <title> UltraLearning </title>
  <link rel="shortcut icon" href="/imagens/logo/ultralerning.png" type="image/x-icon"/>
  <link rel="stylesheet" href="/css/biblioteca.css"/>
  <link rel="stylesheet" href="/css/sites.css"/>
  <link rel="stylesheet" href="/css/pesquisar.css"/>
  <link rel="stylesheet" href="/css/add.css"/>
  <link rel="stylesheet" href="/css/cadeiras.css"/>
  <link rel="stylesheet" href="/css/toDoList.css"/>
  <link rel="stylesheet" href="/css/sejaSabio.css"/>
  <link rel="stylesheet" href="/css/dicionario.css"/>
  <link rel="stylesheet" href="/css/projectos.css"/>
  <link rel="stylesheet" href="/css/style.css"/>
</header>
<script type="text/javascript" src="/js/funcoes.js"></script>
<script type="text/javascript" src="/js/hiddenDiv.js"></script>
<body>
  <div id="interface">
    <header id="cabecalho">
      <!--Acesso rapido-->
      <div id="acesso-rapido">
        <!--logo-->
        <div id="logo-tipo">
          <div id="icon"></div>
          <div id="appName">UltraLearning</div>
        </div>

        <!--Pesqusar conteudos-->
        <div id="searching">
          <form name="" class="" action="/pesquisar/" method="get">
            <label for="searching">Pesquisar</label>
            <input type="text" name="procurar" value="<?=isset($pesquisar)? "$pesquisar": "";?>" placeHolder="O que é que desejas saber?" id="searching" required/>
            <input type="submit" value="Buscar" id="btn-searching"/>
          </form>
        </div>

        <!--Novo conteudo-->
        <div class="atalhos-icons" id="atalhos-icons" title="Adicionar novos conteúdos">
          <button id="add-conteudo" onclick="showModal('addNewConteudo')">
            +
          </button>
        </div>

        <!--Notificacoes-->
        <div class="atalhos-icons" title="Notificações">

          <button id="notification" onclick="showModal('viewNotificacoes')">
            <div id="numeroDeNotificacoes" title="Tens <?=$qtdeNotificacoesPorVer?> notificações por ver!">
              <?=$qtdeNotificacoesPorVer?>
            </div>
            N
          </button>
        </div>

        <!--Horario-->
        <div class="atalhos-icons" title="Horario de actividades">
          <button id="horario" onclick="showModal('horario-actividade')">
            H
          </button>
        </div>

        <!--dashboard-->
        <a href="/dashboard.php">
          <div id="dashboard" title="Painel de controle">
            <div class="dashboard-cube"></div>
            <div class="dashboard-cube"></div>
            <div class="dashboard-cube"></div>
            <div class="dashboard-cube"></div>
            <div class="dashboard-cube"></div>
            <div class="dashboard-cube"></div>
            <div class="dashboard-cube"></div>
            <div class="dashboard-cube"></div>
            <div class="dashboard-cube"></div>
          </div>
        </a>

        <!--To do list-->
        <div id="ultra-to-do-list" title="Lista de tarefas" onclick="showModal('toDoListShow')">

          <div id="numeroDetarefas" title="Tens <?=$qtdeTarefasPorFazerMy?> tarefas por fazer!">
            <?=$qtdeTarefasPorFazerMy?>
          </div>

          <div class="linhas">
            <div class="cubo" id="cubo"></div>
            <div class="linha"></div>
          </div>

          <div class="linhas">
            <div class="cubo"></div>
            <div class="linha"></div>
          </div>

          <div class="linhas">
            <div class="cubo" id="cubo"></div>
            <div class="linha"></div>
          </div>

          <div class="linhas">
            <div class="cubo"></div>
            <div class="linha"></div>
          </div>
        </div>

        <!--Perfil-->
        <div id="dados-user">

          <div id="option" onclick="showModal('more-options')">
            <div class="linhas-option"></div>
            <div class="linhas-option"></div>
            <div class="linhas-option"></div>
            <div class="linhas-option"></div>
            <div class="linhas-option"></div>
          </div>

          <div id="name">
            <?=substr($globalUserName, 0, 28)?>
          </div>

          <div id="icon">
            <!--Foto de peril-->
            <img src="\users\<?=$showPhotoP;?>" alt="Foto de perfil" id="globalUserfotoDePerfil"/>
          </div>

        </div>
      </div>

      <!--Menu-->
      <nav id="menu">
        <ul>
          <a href="/home.php" title="Home">
            <li>Início</li>
          </a>

          <a href="#" title="Nóticias">
            <li>News</li>
          </a>

          <a href="/biblioteca.php" title="Biblioteca">
            <li>Biblioteca</li>
          </a>

          <a href="/debates.php" title="Debates">
            <li>Debates</li>
          </a>

          <a href="/artigos.php" title="Debates">
            <li>Artigos</li>
          </a>

          <a href="/chat.php" title="Debates">
            <li>Chat</li>
          </a>

          <a href="/cadeiras.php" title="Cadeiras">
            <li>Cadeiras</li>
          </a>

          <a href="/cursos.php" title="Cursos">
            <li>Cursos</li>
          </a>

          <a href="/busness.php" title="Busness">
            <li>Busness</li>
          </a>

          <a href="/livros.php" title="Livros">
            <li>Livros</li>
          </a>

          <a href="/projectos.php" title="Projectos">
            <li>Projectos</li>
          </a>

          <a href="/marketplace.php" title="Tech">
            <li>Market</li>
          </a>

          <a href="/bot.php" title="Robo de buscas">
            <li>Bot</li>
          </a>

          <a href="/games.php" title="Jogos">
            <li>Games</li>
          </a>

          <!--destacar pagina actual-->
          <script type="text/javascript">
            activeMenu();
          </script>
        </ul>

      </nav>

      <!--Notificacoes-->
      <?=$mensagem;?>

      <!--adicionar conteudo-->
      <div class="addNewConteudo" id="addNewConteudo">
        <div id="o-que-adicionar">
          <div id="close-acesso-r" onclick="hiddenModal('addNewConteudo')">&times;</div>
          <div id="add-menu">
            <div id="titulo-menu">Add Conteudo</div>
            <ul>
              <a href="#autores">     <li> Autor/Professor  </li> </a>
              <a href="#newcurso">    <li> Curso            </li> </a>
              <a href="#busness">     <li> Busness          </li> </a>
              <a href="#definicoes">  <li> Definição        </li> </a>
              <a href="#desafiosExe"> <li> Desafio          </li> </a>
              <a href="#dicionario">  <li> Diciónario       </li> </a>
              <a href=#boasPraticasP> <li> Dicas De T.I     </li> </a>
              <a href="#fazerCurso">  <li> Fazer Curso      </li> </a>
              <a href="#project">     <li> Projecto         </li> </a>
              <a href="#imagens">     <li> Imagems          </li> </a>
              <a href="#livros">      <li> Livro            </li> </a>
              <a href="#objectivos">  <li> Objectivo        </li> </a>
              <a href="#pesquisar_p"> <li> Trabalho         </li> </a>
              <a href="#whatLearn">   <li> Quero Aprender   </li> </a>
              <a href="#seja_rico">   <li> Seja Sábio       </li> </a>
              <a href="#meus_sites">  <li> Site             </li> </a>
              <a href="#toDoListDay"> <li> Tarefa           </li> </a>
            </ul>
          </div>


          <!--Adicionar novos conteudos-->
          <div id="add-conteudos">

            <!--Definicoes-->
            <div class="option-add">
              <a name="definicoes">
                <div class="option-title"> Definições </div>
              </a>

              <form name="" action="" method="post">
                <div class="option-form">
                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Definição: </label>

                    <div class="desc-conteudo">
                      <textarea name="definicao" placeHolder="Descreva aqui o pretendes definir!" id="definir" required></textarea>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Ficheiro: </label>
                    <div class="desc-conteudo">
                      <select name="ficheiro" size="1" required>
                        <option value=""> Selecione o tipo </option>

                        <?=$listarTipoDeFicheiros;?>

                      </select>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Fonte: </label>
                    <div class="desc-conteudo">
                      <input type="text" name="fonte" value="" placeHolder="A fonte da definição (Opcional)!"/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Cadeira: </label>
                    <div class="desc-conteudo">
                      <select name="cadeiras" size="1" required>
                        <option value="">Esta disciplina esta relacionada a cadeira de? </option>

                        <?=$listarCadeiras;?>

                      </select>
                    </div>
                  </div>
                </div>

                <div class="option-btn">
                  <input type="submit" name="addDefinicoes" value="Salvar" class="btn-add">
                </div>
              </form>

            </div>

            <!--Autores-->
            <div class="option-add">
              <!--topo-->
              <div class="option-title">
                <a name="autores">Autor/Professor </a>
              </div>

              <!--Formulario-->
              <form name="" action="" method="post">
                <div class="option-form2">
                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Nome: </label>
                    <div class="desc-conteudo">
                      <input type="text" name="nomeProf" placeHolder="Insira o nome do professor!"/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Descricao: </label>
                    <div class="desc-conteudo">
                      <textarea name="descricaoProf" id="descricaoProf" placeHolder="Faca uma breve descrição do professor aqui!"></textarea>
                    </div>
                  </div>
                </div>

                <!--Botoes-->
                <div class="option-btn">
                  <input type="submit" name="addProfessor" value="Salvar" class="btn-add">
                </div>

              </form>
            </div>

            <!--Busness/Negocios-->
            <div class="option-add">
              <!--topo-->
              <div class="option-title">
                <a name="busness"> Negócios </a>
              </div>

              <!--Formulario-->
              <form name="" action="" method="post">
                <div class="option-form2">
                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Titulo: </label>
                    <div class="desc-conteudo">
                      <input type="text" name="tituloV" value="" placeHolder="Insira aqui o titulo" required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Descrição: </label>
                    <div class="desc-conteudo">
                      <textarea name="descricaoN" placeHolder="Faça aqui a descricao da vaga de Negócios" id="descricaoVaga" required></textarea>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Requisitos: </label>
                    <div class="desc-conteudo">
                      <textarea name="requisitosN" placeHolder="Faça uma breve descrição dos requisitos necessarios aqui! (Opcional)" id="requisitosVaga"></textarea>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">E-mail: </label>
                    <div class="desc-conteudo">
                      <input type="email" name="emailN" value="" placeHolder="E-mail para contacto aqui (opcional)" required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Telefone(s): </label>
                    <div class="desc-conteudo">
                      <input type="text" name="numberN" value="" placeHolder="Numero(s) para conctacto aqui (opcional)" required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo" tile="Inicio das candidaturas">Inicio: </label>
                    <div class="desc-conteudo">
                      <input type="date" name="iniciaEmN" value="" placeHolder="" required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo" title='Fim das candidaturas'>Termino: </label>
                    <div class="desc-conteudo">
                      <input type="date" name="terminaEmN" value="" placeHolder="" required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Visibility: </label>
                    <div class="desc-conteudo">
                      <select name="quemPodeVerN" size="1" required>
                        <option value="">Quem pode ver</option>
                        <option value="e" selected>Apenas eu</option>
                        <option value="g">Todos os ultralearners</option>
                      </select>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo" title='Fim das candidaturas'>Imagem: </label>
                    <div class="desc-conteudo">
                      <input type="file" name="imagemN" value="" placeHolder=""class="limitarOcupacao"/>
                      <div id="breve-recomendacao">(Opcional)</div>
                    </div>
                  </div>

                </div>

                <!--Botoes-->
                <div class="option-btn">
                  <input type="submit" name="addNegocios" value="Salvar" class="btn-add">
                </div>

              </form>
            </div>

            <!--adicionar novo curso-->
            <div class="option-add">
              <!--topo-->
              <div class="option-title">
                <a name="newcurso"> Adicionar Novo Curso </a>
              </div>

              <!--Formulario-->
              <form name="" action="" method="post" enctype="multipart/form-data">
                <div class="option-form2">
                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Titulo: </label>
                    <div class="desc-conteudo">
                      <input type="text" name="tituloC" value="" placeHolder="Insira o titulo do curso" required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Descrição: </label>
                    <div class="desc-conteudo">
                      <textarea name="descricaoC" placeHolder="Faça uma breve descricao do curso aqui" id="descricaoCurso" required></textarea>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Nº Video: </label>
                    <div class="desc-conteudo">
                      <input type="number" name="qtdeVideoC" value="" min="1" placeHolder="Numero de aulas" required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Criado por: </label>
                    <div class="desc-conteudo">
                      <select name="criadoPorC" size="1" required>
                        <option value="">
                          Selecione o link de referencia/origem
                        </option>

                        <?=$listaDeSites?>
                      </select>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Tecnologia: </label>
                    <div class="desc-conteudo">
                      <select name="tecnologiaC" size="1" required>
                        <option value="">
                          Selecione a tecnologia
                        </option>

                        <?=$listarTecnologias?>
                      </select>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Professor: </label>
                    <div class="desc-conteudo">
                      <select size="1" name="professorC" required>
                        <option value="">
                          Selecione o profossor/criador do curso
                        </option>

                        <?=$listarProfessores?>
                      </select>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Lançado: </label>
                    <div class="desc-conteudo">
                      <input type="date" name="dataC" value="" placeHolder="" required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Cadeira: </label>
                    <div class="desc-conteudo">
                      <select size="1" name="cadeiraC" riquered>
                        <option value="">Selecione a cadeira</option>

                        <?=$listarCadeiras;?>
                      </select>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Imagem: </label>
                    <div class="desc-conteudo">
                      <input type="file" name="imagemC" value="" placeHolder="" class="limitarOcupacao"/>
                      <div id="breve-recomendacao">(Opcional)</div>
                    </div>
                  </div>

                </div>

                <!--Botoes-->
                <div class="option-btn">
                  <input type="submit" name="AddCurso" value="Salvar" class="btn-add">
                </div>

              </form>
            </div>

            <!--curso-->
            <div class="option-add">
              <!--topo-->
              <div class="option-title">
                <a name="fazerCurso"> Fazer novo curso </a>
              </div>

              <!--Formulario-->
              <form name="" action="" method="post" enctype="multipart/form-data">
                <div class="option-form2">
                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Curso: </label>
                    <div class="desc-conteudo">
                      <select name="fazerCurso" size="1" required>
                        <option value="">
                          Selecione o curso que deseja fazer!
                        </option>

                        <?=$listarCursos;?>
                      </select>
                    </div>
                  </div>
                </div>

                <!--Botoes-->
                <div class="option-btn">
                  <input type="submit" name="AddNewCourse" value="Salvar" class="btn-add">
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
                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Palavra: </label>
                    <div class="desc-conteudo">
                      <input type="text" name="palavra" value="" placeHolder="Insira a palavra ou frase!" required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Significado: </label>
                    <div class="desc-conteudo">
                      <textarea name="significado" placeHolder="Significado ou tradução do termo!" id="descricaao-nexo" required></textarea>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Fonte: </label>
                    <div class="desc-conteudo">
                      <input type="text" name="fonte" value="" placeHolder="Origem do conteudo (Opcional)">
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Tipo: </label>
                    <div class="desc-conteudo">
                      <select name="tipo" size="1" required>
                        <option value="">Qual é o tipo de diciónario?</option>
                        <option value="t" selected>Técnico</option>
                        <option value="g">Geral</option>
                        <option value="e">Ciências Exatas</option>
                        <option value="i">Indisponivel</option>
                      </select>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Cadeira: </label>
                    <div class="desc-conteudo">
                      <select name="cadeira" size="1" required>
                        <option value="">Este termo esta relacionado a cadeira de?</option>

                        <?=$listarCadeiras;?>
                      </select>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Tecnologia: </label>
                    <div class="desc-conteudo">
                      <select name="tecnoDict" size="1" required>
                        <option value="">Selecione a tecnologia?</option>

                        <?=$listarTecnologias?>
                      </select>
                    </div>
                  </div>
                </div>

                <!--Botoes-->
                <div class="option-btn">
                  <input type="submit" name="addDicionario" value="Salvar" class="btn-add">
                </div>
              </form>
            </div>

            <!--Boas praticas de programacao-->
            <div class="option-add">
              <!--Topo-->
              <div class="option-title">
                <a name="boasPraticasP"> Dicas De T.I </a>
              </div>

              <!--Formulario-->
              <form name="" action="" method="post" >
                <div class="option-form2">
                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Dica: </label>
                    <div class="desc-conteudo">
                      <textarea name="boaPratica" placeHolder="Escreva aqui a boa pratica de programação" id="boaPratica"></textarea>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Tecnologia: </label>
                    <div class="desc-conteudo">
                      <select name="sobreTecnologia" size="1" required>
                        <option value="">Selecione a tecnologia</option>

                        <?=$listarTecnologias?>
                      </select>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Categoria: </label>
                    <div class="desc-conteudo">
                      <select name="categoiaPratica" size="1" required>
                        <option value="">Selecione a categoria</option>

                        <?=$listarBoasPraticas?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="option-btn">
                  <input type="submit" name="addBoaPratica" value="Salvar" class="btn-add">
                </div>
              </form>

            </div>

            <!--Desafio/Exercicio-->
            <div class="option-add">
              <!--Topo-->
              <div class="option-title">
                <a name="desafiosExe"> Desafios </a>
              </div>

              <!--Formulario-->
              <form name="" action="" method="post" >
                <div class="option-form2">
                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Titulo: </label>
                    <div class="desc-conteudo">
                      <input type="text" name="tituloD" value="" placeHolder="Escreva o titulo do exercicio/desafio" required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Desafio: </label>
                    <div class="desc-conteudo">
                      <textarea name="descricaoD" placeHolder="Descreva aqui o seu exercicio ou desafio" id="exercicioD" required></textarea>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Cadeira: </label>
                    <div class="desc-conteudo">
                      <select name="cadeiraD" size="1" required>
                        <option value="">Este exercicio esta relacionado a</option>

                        <?=$listarCadeiras?>
                      </select>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Categoria: </label>
                    <div class="desc-conteudo">
                      <select name="categoriaD" size="1" required>
                        <option value="">Selecione a categoria</option>
                        <option value="d">Desafio</option>
                        <option value="e" selected>Exercicio</option>
                      </select>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Dificuldade: </label>
                    <div class="desc-conteudo">
                      <select name="nivelDificuldade" size="1" required>
                        <option value="">Selecione a categoria</option>
                        <option value="b"> Básico </option>
                        <option value="i"> Intermediario </option>
                        <option value="m"> Médio </option>
                        <option value="d"> Difícil </option>
                        <option value="h"> Muito Difícil </option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="option-btn">
                  <input type="submit" name="addDesafioE" value="Salvar" class="btn-add">
                </div>
              </form>
            </div>

            <!--Imagens-->
            <div class="option-add">
              <!--topo-->
              <div class="option-title">
                <a name="imagens"> Imagens </a>
              </div>

              <!--Formulario-->
              <form name="" action="" method="post" enctype="multipart/form-data">
                <div class="option-form2">

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Imagem: </label>
                    <div class="desc-conteudo">
                      <input type="file" name="imagemUp" required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Titulo: </label>
                    <div class="desc-conteudo">
                      <input type="text" name="tituloI" placeHolder="Dê um nome a esta imagem." required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Descrição: </label>
                    <div class="desc-conteudo">
                      <textarea name="descricaoI" placeHolder="Forneça mais detalhes sobre a imagem aqui!" required id="descricaoImagem"></textarea>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Sobre: </label>
                    <div class="desc-conteudo">
                      <select name="sobreI" size="1" required>
                        <option value="">
                          Esta imagem esta relacionada a
                        </option>

                        <?=$listarCadeiras?>
                      </select>
                    </div>
                  </div>

                </div>

                <!--Botoes-->
                <div class="option-btn">
                  <input type="submit" name="addImagens" value="Salvar" class="btn-add">
                </div>

              </form>
            </div>


            <!--Livros-->
            <div class="option-add">
              <!--topo-->
              <div class="option-title">
                <a name="livros"> Livros </a>
              </div>

              <!--Formulario-->
              <form name="" action="" method="post" enctype="multipart/form-data">
                <div class="option-form2">
                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Livro: </label>
                    <div class="desc-conteudo">
                      <input type="file" name="carregarLivro" id="validadeDesafio"/> <div id="breve-recomendacao">(Opcional)</div>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Titulo: </label>
                    <div class="desc-conteudo">
                      <input type="text" name="tituloL" placeHolder="Qual é o titulo do livro" required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Descrição: </label>
                    <div class="desc-conteudo">
                      <textarea name="descricaoL" placeHolder="Faça uma descrição sobre o livro que pretende carregar na plataforma!" required id="descricaoLivro"></textarea>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Autor: </label>
                    <div class="desc-conteudo">
                      <select name="autorL" size="1" required>
                        <option value="">
                          Selecione o autor/a do livro
                        </option>

                        <?=$listarProfessores?>
                      </select>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Nº Paginas: </label>
                    <div class="desc-conteudo">
                      <input type="number" name="numeroP" value="" min="1" placeHolder="Qual é o número de páginas do livro?" required>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Sobre: </label>
                    <div class="desc-conteudo">
                      <select name="sobreL" size="1" required>
                        <option value="">
                          Este livro esta relacionada a
                        </option>

                        <?=$listarCadeiras?>
                      </select>
                    </div>
                  </div>

                </div>

                <!--Botoes-->
                <div class="option-btn">
                  <input type="submit" name="addLivros" value="Salvar" class="btn-add">
                </div>

              </form>
            </div>

            <!--Objectivos-->
            <div class="option-add">
              <!--topo-->
              <div class="option-title">
                <a name="objectivos"> Objectivos </a>
              </div>

              <!--Formulario-->
              <form name="" action="" method="post">
                <div class="option-form2">
                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Objectivo: </label>
                    <div class="desc-conteudo">
                      <input type="text" name="tituloOb" placeHolder="Dê um nome aos seus objectivos"/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Descrição: </label>
                    <div class="desc-conteudo">
                      <textarea name="descricaoOb" placeHolder="Faça aqui uma breve descrição dos seus objectivos" id="descricaoObjec" required></textarea>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Inicia em: </label>
                    <div class="desc-conteudo">
                      <input type="date" name="dataInO" required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Expira em: </label>
                    <div class="desc-conteudo">
                      <input type="date" name="dateExO" required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Sobre: </label>
                    <div class="desc-conteudo">
                      <select name="sobreO" size="1" required>
                        <option value="">Esta relacionada a area de</option>

                        <?=$listarCadeiras?>
                      </select>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">%: </label>
                    <div class="desc-conteudo-range">
                      min 0 <input type="range" name="percentagemO" min="0" max="100" value="0" required/> 100 max
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Categoria: </label>
                    <div class="desc-conteudo">
                      <select name="categoriaO" size="1" required>
                        <option value="">
                          Qual a cagetoria do objectivo?
                        </option>

                        <?=$listarCObjectivos?>
                      </select>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Estado: </label>
                    <div class="desc-conteudo">
                      <select name="estadoOb" size="1" required>
                        <option value="">
                          Qual o estado actual do objectivo?
                        </option>
                        <option value="n">Não realizado</option>
                        <option value="c" selected>Curto Praso</option>
                        <option value="m">Médio Praso</option>
                        <option value="l">Longo prazo</option>
                        <option value="a">Objectivo alcançado</option>
                      </select>
                    </div>
                  </div>
                </div>

                <!--Botoes-->
                <div class="option-btn">
                  <input type="submit" name="addObjectivos" value="Salvar" class="btn-add">
                </div>

              </form>
            </div>

            <!--O que aprender -->
            <div class="option-add">
              <!--topo-->
              <div class="option-title">
                <a name="whatLearn"> O que quero aprender </a>
              </div>

              <!--Formulario-->
              <form name="" action="" method="post">
                <div class="option-form2">
                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Aprender:</label>
                    <div class="desc-conteudo">
                      <textarea name="queroAprender" placeHolder="Faça aqui uma descrição do que desejas aprender" id="queroAprender" required></textarea>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Key Word's: </label>
                    <div class="desc-conteudo">
                      <input type="text" name="weyWordA" value="" placeHolder="Escreva aqui palavras chave para facilitar as buscas automatizadas" required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Tecnologia: </label>
                    <div class="desc-conteudo">
                      <select name="tecnologiaA" size="1" required>
                        <option value="">
                          Qual a tecnologia a ser aprendida?
                        </option>

                        <?=$listarTecnologias?>
                      </select>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Até: </label>
                    <div class="desc-conteudo">
                      <input type="date" name="aprenderA" value="" required id="validadeDesafio"/> <div id="breve-recomendacao">(Opcional)</div>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Sobre: </label>
                    <div class="desc-conteudo">
                      <select name="cadeiraA" size="1" required>
                        <option value="">Seleciona a cadeira</option>
                        <?=$todasMinhasCadOption?>
                      </select>
                    </div>
                  </div>

                </div>


                <!--Botoes-->
                <div class="option-btn">
                  <input type="submit" name="addOqueAprender" value="Salvar" class="btn-add">
                </div>

              </form>
            </div>

            <!--Projectos-->
            <div class="option-add">
              <!--topo-->
              <div class="option-title">
                <a name="project"> Projecto </a>
              </div>

              <!--Formulario-->
              <form name="" action="" method="post">
                <div class="option-form2">
                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Tema: </label>
                    <div class="desc-conteudo">
                      <input type="text" name="nomeP" placeholder="Escreva aqui um nome para o projecto" required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Descrição: </label>
                    <div class="desc-conteudo">
                      <textarea name="descricaoP" placeHolder="Faça uma breve descrição da tua ideia aqui" id="descricaoP" required></textarea>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Sobre: </label>
                    <div class="desc-conteudo">
                      <select name="sobreP" size="1" required>
                        <option value="">Cadeira</option>
                        <?=$todasMinhasCadOption?>
                      </select>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Categoria: </label>
                    <div class="desc-conteudo">
                      <select name="categoriaP" size="1" required>
                        <option value="">Qual a categoria</option>
                        <option value="i">Ideia</option>
                        <option value="p">Projecto</option>
                        <option value="n">Negócio</option>
                      </select>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">%: </label>
                    <div class="desc-conteudo-range">
                      <div id="left">min 0</div>

                      <input type="range" value="0" name="percentagemP" min="0" max="100" value="">

                      <div id="right">100 max</div>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Estado: </label>
                    <div class="desc-conteudo">
                      <select name="estadoP" size="1" required>
                        <option value="">Qual é o estado actual? </option>
                        <option value="p">Por desenvolver</option>
                        <option value="a">A desenvolver</option>
                        <option value="f">Concluido</option>
                        <option value="u">Em actualização</option>
                      </select>
                    </div>
                  </div>

                </div>

                <!--Botoes-->
                <div class="option-btn">
                  <input type="submit" name="AddProjectos" value="Salvar" class="btn-add">
                </div>

              </form>
            </div>

            <!--Pesquisar por -->
            <div class="option-add">
              <!--Topo-->
              <div class="option-title">
                <a name="pesquisar_p">Trabalho</a>
              </div>

              <!--Formulario-->
              <form name="" action="" method="post" >
                <div class="option-form2">
                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Tema: </label>
                    <div class="desc-conteudo">
                      <input type="text" name="tituloPes" placeHolder="Tema do trabalho" required>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Descrição: </label>
                    <div class="desc-conteudo">
                      <textarea name="descricaoPes" placeHolder="Descrição do trabalho" id="descricaoPes" required></textarea>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Cadeira:</label>
                    <div class="desc-conteudo">
                      <select name="cadeiraPes" size="1" required>
                        <option value="">Selecione a cadeira/disciplina</option>
                         <?=$todasMinhasCadOption?>
                      </select>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Categoria:</label>
                    <div class="desc-conteudo">
                      <select name="categoriaPes" size="1" required>
                        <option value="">Selecione a categoria</option>
                        <?=$listarCatMaterias?>
                      </select>
                    </div>
                  </div>

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
                <a name="seja_rico">Seja Sábio</a>
              </div>
              <!--Formulario-->
              <form name="" action="" method="post" >
                <div class="option-form2">
                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Dica: </label>
                    <div class="desc-conteudo">
                      <textarea name="dicaRiqueza" placeHolder="Escreva aqui a dica de riqueza / sabedoria!" id="dicaRiqueza" required></textarea>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Fonte: </label>
                    <div class="desc-conteudo">
                      <input type="text" name="origemDica" value="" placeHolder="Origem da dica de riqueza/sabedoria!? (opcional)">
                    </div>
                  </div>

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
                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Nome:</label>
                    <div class="desc-conteudo">
                      <input type="text" name="nome" value="" placeHolder="Nome do site" required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Link: </label>
                    <div class="desc-conteudo">
                      <input type="text" name="linkWeb" value="" placeHolder="Link do site!" required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Descrição: </label>
                    <div class="desc-conteudo">
                      <textarea name="descricao" placeHolder="Faça uma breve descrição do site aqui!" id="description-site" required></textarea>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                  <label for="" class="desc-titulo">Cadeira: </label>
                  <div class="desc-conteudo">
                    <select name="cadeira" size="1" required>
                      <option value="">Este site esta relacionado a cadeira de?</option>

                      <?=$listarCadeiras;?>
                    </select>
                  </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Imagem: </label>
                    <div class="desc-conteudo">
                      <input type="file" name="imagem" title="Opcional" value="" placeHolder="Link do site!" id="validadeDesafio"/> <div id="breve-recomendacao">(Opcional)</div>
                    </div>
                  </div>
                </div>

                <div class="option-btn">
                  <input type="submit" name="addSites" value="Salvar" class="btn-add">
                </div>
              </form>
            </div>

            <!-- Adiconar tarefas -->
            <div class="option-add">
              <!--topo-->
              <div class="option-title">
                <a name="toDoListDay"> Tarefa</a>
              </div>

              <!--Formulario-->
              <form name="" action="" method="post">
                <div class="option-form2">
                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Titulo:</label>
                    <div class="desc-conteudo">
                      <input type="text" name="tema" value="" placeHolder="Tema da tarefa" required/>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Descrição: </label>
                    <div class="desc-conteudo">
                      <textarea name="descricao" placeHolder="Objectivo da tarefa!" id="description-toDo" required></textarea>
                    </div>
                  </div>

                  <div class="conteiner-itens">
                    <label for="" class="desc-titulo">Sobre: </label>
                    <div class="desc-conteudo">
                      <select name="cadeira" size="1" required>
                        <option value="">A tarefa é sobre?</option>

                        <?=$todasMinhasCadOption?>
                      </select>
                    </div>
                  </div>

                </div>

                <div class="option-btn">
                  <input type="submit" name="addTarefasToDo" value="Salvar" class="btn-add">
                </div>
              </form>
            </div>

          </div>

        </div>

      </div> <!--Conteudo a adicionar-->

      <!--notificacoes -->
      <div class="viewNotificacoes" id="viewNotificacoes">
        <div class="view-modal-title">
          <div id="titulo-area-notificacoes">
            Notificações
            <span onclick="hiddenModal('viewNotificacoes')">
              &times;
            </span>
          </div>
        </div>

        <div id="caixa-de-notificacoes">
          <?=$listarNotificacoes?>
        </div>

        <a href="/notificacoes.php" id="ver-mais">
          Todas notificações
        </a>
      </div> <!--Notificacoes-->

      <!--To Do List-->
      <div class="toDoListShow" id="toDoListShow">
        <h3>
          Tarefas do dia
          <span onclick="hiddenModal('toDoListShow')" title="Fechar">&times;</span>
        </h3>

        <div id="tarefas">
          <?=$toDoListUser?>
        </div>

        <div id="gestor">
          <a href="/gestorDeTarefas.php"> Gestor de tarefas </a>
        </div>
      </div>

    </header>
