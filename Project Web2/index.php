<?php 
  session_start();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Title of the document</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <style>
      .container{
        margin: auto;
        
      }
      textarea{
        width: 100px;
      }
      form{
        width: 500px;
        margin: 100px auto;
      }
      a{
        color: white;
      }
 
    </style>
  </head>
  <body>
    
    <div class="container">
      <nav>
        <div class="nav-wrapper teal lighten-2 white-text">
          <a href="#" class="brand-logo center">TaskMan</a>
          <ul id="nav-mobile" class="right">
            <li><a href="register.php"><i class="material-icons left">person_add</i>Register</a></li>
          </ul>
        </div>
      </nav>
      

      <form action="login.php" method="post">
      
        <div class="input-field">
          <i class="material-icons prefix">account_circle</i>
          <input name = "email" id="icon_prefix" type="text" class="validate"
          <?= isset($email) ? "value = '$email'" : ''?>
          >
          <label for="icon_prefix">Email</label>
        </div>

        <div class="input-field">
          <i class="material-icons prefix">lock</i>
          <input name = "password" id="icon_prefix" type="password" class="validate"
            <?= isset($password) ? "value = '$password'" : ''?>
          >
          <label for="icon_prefix">Password</label>
        </div>
        
        <div class="center-align">
          <button class="btn waves-effect waves-light" type="submit" name="action">Login</button>
        </div>
      </form>

    </div>

    <?php
        if ( isset($_SESSION["error"])) {
          $err = $_SESSION["error"];
          echo "<script> M.toast({html: '$err', classes: 'grey white-text'}) ; </script>" ;
          unset($_SESSION["error"]);
        }
    ?> 

  <script>
    $(function(){

    })
  </script>
  </body>
</html>