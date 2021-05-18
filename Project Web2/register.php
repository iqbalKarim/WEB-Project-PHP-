<?php 
    $error = [];
    if (!empty($_POST)){

        extract($_POST);
      

        $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;


        if (empty($name)){
            $error[] = "name";
        }
        if (empty($password)){
            $error[] = "password";
        }
        if (preg_match('/(\w+)@((?:\w+\.){1,3}(?:com|tr))/iu', $email) == 0){
            $error[] = "email";
        }
        if( !file_exists($_FILES["profile"]['tmp_name']) || !is_uploaded_file($_FILES["profile"]['tmp_name'])) {
            $error[] = "profile";
        }

        require_once "./db.php";

        if (empty($error)){
            $rs = $db->prepare("insert into users (name, email, password, file) values (?,?,?,?)");
            $rs->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $_FILES["profile"]["name"]]);
        }



        if (empty($error)){
            move_uploaded_file($_FILES["profile"]["tmp_name"], "./images/".$_FILES["profile"]["name"]);
            header("Location: index.php");
            exit;
        }
    }
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

    form{
        width: 500px;
        margin: 100px auto;
    }
    </style>
  </head>
  <body>
    <div class="container">
        <nav>
            <div class="nav-wrapper teal lighten-2 white-text">
            <a href="./index.php" class="brand-logo center">TaskMan</a>
            </div>
        </nav>


        
        <form action="" method="post" enctype="multipart/form-data">

        <div class="input-field">
                <input name = "name" id="icon_prefix" type="text" class="validate"
                <?= isset($name) ? "value = '$name'" :  '' ?> 
                >
                <label for="icon_prefix">Name Lastname</label>
            </div>

            <div class="input-field">
                <input name = "email" id="icon_prefix" type="text" class="validate"
                <?= isset($email) ? "value = '$email'" :  '' ?>
                >
                <label for="icon_prefix">Email</label>
            </div>

            <div class="input-field">
                <input name = "password" id="icon_prefix" type="text" class="validate"
                <?= isset($password) ? "value = '$password'" :  '' ?>
                >
                <label for="icon_prefix">Password</label>
            </div>
            

            <div class="file-field input-field">
                <div class="btn">
                    <span>File</span>
                    <input type="file" name = "profile">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>


            <div class="center-align">
                <button class="btn waves-effect waves-light" type="submit" name="action">Register<i class="material-icons right">send</i></button>
            </div>
        </form>


    </div>

    <?php
        if ( in_array("name", $error)){
            echo "<script> M.toast({html: 'Name cannot be blank!', classes: 'grey white-text'}) ; </script>" ;
        }
        if ( in_array("email", $error)){
            echo "<script> M.toast({html: 'Please enter valid Email!', classes: 'grey white-text'}) ; </script>" ;
        }
        if ( in_array("password", $error)){
            echo "<script> M.toast({html: 'Password cannot be blank!', classes: 'grey white-text'}) ; </script>" ;
        }
        if ( in_array("profile", $error)){
            echo "<script> M.toast({html: 'Please upload a profile picture!', classes: 'grey white-text'}) ; </script>" ;
        }
    ?>

  <script>
    $(function(){
    })
  </script>
  </body>
</html>