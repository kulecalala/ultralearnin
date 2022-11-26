<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="/../imagens/logo/ultralerning.png" type="image/x-icon"/>
    <title>Ultralearning - login</title>
    <link rel="stylesheet" href="/../css/login.css"/>
  </head>
  <body>
    <div id="container">

      <!--Login page-->
      <div id="login">
        <div id="topo">

        </div>

        <!--Avisos-->
        <?=$mensagem;?>

        <form class="" action="" method="post">
          <fieldset> <legend>E-mail</legend>
            <input type="email" name="email" value="<?=$email?>" placeHolder="O seu e-mail"/>
          </fieldset>


          <fieldset>
            <legend>Senha</legend>
            <input type="password" name="senha" min="8" size="8" value="<?=$senha?>" placeHolder="A sua senha"/>
          </fieldset>

          <div id="lembre-se-de-mim">
            <input type="checkbox" name="remenber" <?=$check;?>/> <p>Lembre-se de mim!</p>
          </div>

          <button type="submit" name="iniciarSeccao" id="btn-start"/>
            Iniciar
          </button>

          <p> <a href="#"> Esqueci a minha senha</a> </p>
          <p> <a href="#"> Crie uma conta </a> </p>
          </p>

        </form>


      </div>
    </div>
  </body>
</html>
