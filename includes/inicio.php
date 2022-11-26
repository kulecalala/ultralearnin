<!DOCTYPE html>
<html lang="pt" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title> UltraLearning </title>
    <link rel="stylesheet" href="/css/home.css"/>
  </head>
  <body>
    <header>
      <div id="logo">
        <div id="logo"></div>
        <div id="name">UltraLearning</div>
        <p>Um pouco de tudo o que precisas para mundar o seu futuro.</p>
      </div>

      <div id="slideShow">
        <marquee>Rapé de nóticias sobre a nossa plataforma, tecnologia e programação, o mundo das tic's e outras...</marquee>
      </div>

      <div id="pesquisar">
        <form class="" action="?pagina=pesquirar" method="get">
          <label for="">Pesquisar</label>

          <input type="text" name="" value="" placeholder="O que é que desejas saber?" id="texto"/>

          <input type="submit" name="" value="Buscar" id="btn-buscar"/>
        </form>
      </div>

      <div id="controle">
        <a href="/login">
          <button type="button" name="button" id="btn-login">
            Login
          </button>
        </a>

        <a href="#">
          <button type="button" id="btn-criar">
            Criar conta
          </button>
        </a>
      </div>
    </header>

    <section>
      corpo
    </section>

    <!--Footer da pagina-->
    <footer id="roda-pe">

      <!--items do rada-pe-->
      <div id="conteiner-roda-pe">

        <!--Nosso logo e breve descricao-->
        <div id="um-pouco-de-nos">

          <!--um pouco de nos-->
          <div id="logo-nome-lema">
            <!--logo-->
            <div id="logo">
            </div>

            <!--nome logo -->
            <div id="nome-lema">
              <div id="nome">
                <strong>UltraLearning</strong>
              </div>
              <p>O que precisas para mudar o seu futuro.</p>

            </div>
          </div>


          <!--Nossas redes sociais-->
          <div id="social-media">
            <p>Siga-nos nas nossas mídias e fica por dentro de todas as novidades e dicas que temos para si.</p>

            <div id="social-icons">
              <!--Facebook-->
              <div class="item-list" style="margin-left: 3px;">
                <a href="https://www.facebook.com/" target="_blank" title="Viste a nossa página no facebook!">
                  <div id="facebook"></div>
                </a>
              </div>

              <!--Instagram-->
              <div class="item-list">
                <a href="https://www.instagram.com/" target="_blank" title="Visite a nossa pagina no instagram!">
                  <div id="instagram"></div>
                </a>
              </div>

              <!--Twitter-->
              <div class="item-list">
                <a href="https://www.twitter.com/" target="_blank" title="Visite a nossa pagina no twitter!">
                  <div id="twitter"></div>
                </a>
              </div>

              <!--Youtube-->
              <div class="item-list">
                <a href="https://www.youtube.com/" target="_blank" title="Visite o nosso canal no youtube!">
                  <div id="youtube"></div>
                </a>
              </div>

              <!---->
              <div class="item-list">
                <a href="https://www.whatsapp.com/" target="_blank" title="Faça parte do nosso grupo no whatsapp!">
                  <div id="whatsapp"></div>
                </a>
              </div>

            </div>

            <p>Siga-nos e seja um verdadeiro <strong>ULTRALEARNER</strong> você também! </p>
          </div>
        </div>

        <!--Menu de opcoes -->
        <div id="footer-menu">

          <!---->
          <div class="cardapio-list">
            <!--designacao-->
            <div class="title"> Empresa </div>

            <!--menu-->
            <ul>
              <li> <a href="#">Sobre nós</a> </li>
              <li> <a href="#">Carreira</a> </li>
              <li> <a href="#">Nóticias</a> </li>
              <li> <a href="#">Manual de utilização</a> </li>
            </ul>
          </div>

          <!---->
          <div class="cardapio-list">
            <!--designacao-->
            <div class="title"> Legal </div>

            <!--menu-->
            <ul>
              <li> <a href="#">Termos de uso</a> </li>
              <li> <a href="#">Privacidade</a> </li>
              <li> <a href="#">Cancelar</a> </li>
              <li> <a href="#">Segurança</a> </li>
            </ul>
          </div>

          <!---->
          <div class="cardapio-list">
            <!--designacao-->
            <div class="title"> Técnica </div>

            <!--menu-->
            <ul>
              <li> <a href="#">Estado</a> </li>
              <li> <a href="#">Lançamento</a> </li>
              <li> <a href="#">Próximo Lançamento</a> </li>
              <li> <a href="#">API</a> </li>
            </ul>
          </div>

          <!---->
          <div class="cardapio-list">
            <!--designacao-->
            <div class="title"> Mais </div>

            <!--menu-->
            <ul>
              <li> <a href="#">O metódo Ultralearning</a> </li>
              <li> <a href="#">Blog</a> </li>
              <li> <a href="#">Vantagens</a> </li>
              <li> <a href="#">A sua opinião importa</a> </li>
            </ul>
          </div>
        </div>

      </div>

      <!--All right's-->
      <div id="todos-direitos">
        UltraLearning &copy; <?=date('Y')?> by Tchimbalanha Tech Ltda. Todos os Direitos Reservados.
      </div>

    </footer>
  </body>
</html>
